<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
            ->addColumn('user_nama', function ($row) {
                return $row->user->name ?? '-';
            })
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $row->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $row->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $row->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
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
