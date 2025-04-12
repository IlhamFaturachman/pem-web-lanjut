<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use App\Models\PenjualanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $row->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $row->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
