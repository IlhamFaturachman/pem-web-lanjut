<?php

namespace Database\Seeders; 

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run()
    {
        $penjualanIds = DB::table('t_penjualan')->pluck('penjualan_id'); // Ambil semua penjualan_id
        $barang = DB::table('m_barang')->select('barang_id', 'harga_jual')->get(); // Ambil semua data barang

        foreach ($penjualanIds as $penjualanId) { // Loop setiap penjualan_id
            $barangTerpilih = $barang->random(3); // Ambil 3 barang berbeda
            
            foreach ($barangTerpilih as $barangData) { // Loop setiap barang yang dipilih
                DB::table('t_penjualan_detail')->insert([ // Insert data ke table t_penjualan_detail
                    'penjualan_id' => $penjualanId, // penjualan_id adalah foreign key pada table t_penjualan_detail
                    'barang_id' => $barangData->barang_id, // barang_id adalah foreign key pada table t_penjualan_detail
                    'harga' => $barangData->harga_jual, // harga adalah integer
                    'jumlah' => rand(1, 5), // jumlah adalah integer
                ]);
            }
        }
    }
}
