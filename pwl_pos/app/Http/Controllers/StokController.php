<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\StokModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok';
        $kategori = KategoriModel::all();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $stok = StokModel::with(['barang.kategori', 'user']);

        // Filter berdasarkan kategori (lewat relasi barang)
        if ($request->kategori_id) {
            $stok->whereHas('barang', function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori_id);
            });
        }

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('barang_nama', function ($row) {
                return $row->barang->barang_name ?? '-';
            })
            ->addColumn('kategori_nama', function ($row) {
                return $row->barang->kategori->kategori_nama ?? '-';
            })
            ->addColumn('stok_jumlah', function ($row) {
                return abs($row->stok_jumlah); // nilai absolut untuk ditampilkan rapi
            })
            ->addColumn('stok_jenis', function ($row) {
                return $row->stok_jumlah > 0
                    ? '<span class="badge badge-success">Masuk</span>'
                    : '<span class="badge badge-danger">Keluar</span>';
            })
            ->addColumn('stok_tanggal', function ($row) {
                return Carbon::parse($row->stok_tanggal)->format('d-m-Y');
            })
            ->addColumn('user_nama', function ($row) {
                return $row->user->name ?? '-';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $row->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $row->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $row->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi', 'stok_jenis'])
            ->make(true);
    }

    public function summary()
    {
        $summary = DB::table('t_stok')
            ->select(
                'm_barang.barang_name',
                DB::raw('SUM(t_stok.stok_jumlah) as total_stok')
            )
            ->join('m_barang', 't_stok.barang_id', '=', 'm_barang.barang_id')
            ->groupBy('t_stok.barang_id', 'm_barang.barang_name')
            ->get();

        // Tambahkan status stok
        $summary->transform(function ($item) {
            $item->status = $item->total_stok <= 10 ? 'Hampir Habis' : 'Aman';
            return $item;
        });

        return response()->json($summary);
    }

    public function export_stok_summary()
    {
        // Ambil ringkasan stok per barang
        $summary = StokModel::selectRaw('barang_id, SUM(stok_jumlah) as total_stok')
            ->with('barang')
            ->groupBy('barang_id')
            ->get();

        // Ambil log transaksi stok (semua riwayat)
        $logs = StokModel::with(['barang', 'user'])->orderBy('stok_tanggal', 'desc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Sheet 1: Ringkasan Stok
        $sheet->setTitle('Ringkasan Stok');

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Jumlah Stok Sekarang');
        $sheet->setCellValue('D1', 'Status');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $row = 2;
        foreach ($summary as $index => $item) {
            $status = $item->total_stok <= 5 ? 'Hampir Habis' : 'Aman';
            $sheet->setCellValue("A$row", $index + 1);
            $sheet->setCellValue("B$row", $item->barang->barang_name ?? '-');
            $sheet->setCellValue("C$row", $item->total_stok);
            $sheet->setCellValue("D$row", $status);
            $row++;
        }

        // Auto size kolom
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Sheet 2: Log Transaksi
        $logSheet = $spreadsheet->createSheet();
        $logSheet->setTitle('Log Transaksi Stok');

        $logSheet->setCellValue('A1', 'No');
        $logSheet->setCellValue('B1', 'Nama Barang');
        $logSheet->setCellValue('C1', 'Jenis');
        $logSheet->setCellValue('D1', 'Jumlah');
        $logSheet->setCellValue('E1', 'Tanggal');
        $logSheet->setCellValue('F1', 'Diinput Oleh');

        $logSheet->getStyle('A1:F1')->getFont()->setBold(true);

        $row = 2;
        foreach ($logs as $index => $log) {
            $logSheet->setCellValue("A$row", $index + 1);
            $logSheet->setCellValue("B$row", $log->barang->barang_name ?? '-');
            $logSheet->setCellValue("C$row", $log->stok_jenis);
            $logSheet->setCellValue("D$row", $log->stok_jumlah);
            $logSheet->setCellValue("E$row", $log->stok_tanggal);
            $logSheet->setCellValue("F$row", $log->user->nama ?? '-');
            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $logSheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Generate & return Excel file
        $filename = 'Ringkasan_Stok_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }



    public function create_ajax()
    {
        $barang = BarangModel::all();
        return view('stok.create_ajax', ['barang' => $barang]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_id' => 'required|exists:m_barang,barang_id',
                'stok_jumlah' => 'required|integer|min:1',
                'stok_tanggal' => 'required|date',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // Simpan ke tabel stok (ganti sesuai model kamu, contoh: StokModel)
            StokModel::create([
                'barang_id'     => $request->barang_id,
                'stok_jumlah'   => $request->stok_jumlah,
                'stok_tanggal'  => $request->stok_tanggal,
                'user_id'       => auth()->id(), // simpan user yang menambahkan stok
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Stok barang berhasil ditambahkan',
            ]);
        }

        return redirect('/');
    }
}
