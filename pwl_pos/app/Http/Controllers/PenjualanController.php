<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';
        $kategori = KategoriModel::all();

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::with(['user', 'details.barang']);

        // Filter berdasarkan kategori (dari relasi barang)
        if ($request->kategori_id) {
            $penjualan->whereHas('details.barang', function ($query) use ($request) {
                $query->where('kategori_id', $request->kategori_id);
            });
        }

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('penjualan_kode', function ($row) {
                return $row->penjualan_kode;
            })
            ->addColumn('pembeli', function ($row) {
                return $row->pembeli ?? '-';
            })
            ->addColumn('penjualan_tanggal', function ($row) {
                return Carbon::parse($row->penjualan_tanggal)->format('d-m-Y');
            })
            ->addColumn('total_item', function ($row) {
                return $row->details->sum('jumlah');
            })
            ->addColumn('total_harga', function ($row) {
                return number_format($row->details->sum(function ($d) {
                    return $d->jumlah * $d->harga;
                }), 0, ',', '.');
            })
            ->addColumn('user_nama', function ($row) {
                return $row->user->name ?? '-';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $row->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $barang = BarangModel::with(['kategori', 'stok_total'])->get(); // include kategori & total stok

        $kodePenjualan = 'PNJ-' . date('YmdHis');

        return view('penjualan.create_ajax', [
            'barang' => $barang,
            'kodePenjualan' => $kodePenjualan,
            'tanggal' => date('Y-m-d'),
        ]);
    }

    public function store_ajax(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/');
        }

        // Validasi input
        $rules = [
            'pembeli' => 'required|string|max:255',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'required|exists:m_barang,barang_id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        try {
            DB::beginTransaction();

            // Simpan header penjualan
            $penjualan = PenjualanModel::create([
                'penjualan_kode'     => 'PNJ-' . date('YmdHis'),
                'penjualan_tanggal'  => $request->penjualan_tanggal,
                'pembeli'            => $request->pembeli,
                'user_id'            => auth()->id(),
            ]);

            // Loop barang untuk simpan detail & kurangi stok via log keluar
            foreach ($request->barang_id as $i => $barang_id) {
                $jumlah = $request->jumlah[$i];
                $barang = BarangModel::with('stok_total')->findOrFail($barang_id);

                $stokSekarang = $barang->stok_total->total ?? 0;

                if ($jumlah > $stokSekarang) {
                    throw new \Exception("Stok barang \"{$barang->barang_name}\" tidak mencukupi. Sisa stok: {$stokSekarang}");
                }

                // Simpan ke detail penjualan
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id'    => $barang_id,
                    'harga'        => $barang->harga_jual,
                    'jumlah'       => $jumlah,
                ]);

                // Simpan ke log stok sebagai pengurangan
                StokModel::create([
                    'barang_id'     => $barang_id,
                    'stok_jumlah'   => -$jumlah, // negatif artinya keluar
                    'stok_tanggal'  => $request->penjualan_tanggal,
                    'user_id'       => auth()->id(),
                    'keterangan'    => 'Penjualan #' . $penjualan->penjualan_kode,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Transaksi penjualan berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan penjualan: ' . $e->getMessage(),
            ]);
        }
    }

    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::with([
            'user', // jika ingin tampilkan siapa yang input
            'details.barang' // relasi ke detail + barang
        ])->find($id);

        if (!$penjualan) {
            return response()->json([
                'status' => false,
                'message' => 'Data penjualan tidak ditemukan'
            ], 404);
        }

        return view('penjualan.show_ajax', [
            'penjualan' => $penjualan
        ]);
    }
}
