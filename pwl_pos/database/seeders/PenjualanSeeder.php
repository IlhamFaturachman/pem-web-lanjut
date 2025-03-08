<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 3,
                'pembeli' => 'Customer Ilham',
                'penjualan_kode' => 'BUY001',
                'penjualan_tanggal' => now(), // fungsi ini berfungsi untuk mengambil waktu sekarang
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 3,
                'pembeli' => 'Customer Linda',
                'penjualan_kode' => 'BUY002',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli' => 'Customer Arseta',
                'penjualan_kode' => 'BUY003',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 3,
                'pembeli' => 'Customer Salsabila',
                'penjualan_kode' => 'BUY004',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 3,
                'pembeli' => 'Customer Dwi',
                'penjualan_kode' => 'BUY005',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Customer Budi',
                'penjualan_kode' => 'BUY006',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 3,
                'pembeli' => 'Customer Indra',
                'penjualan_kode' => 'BUY007',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 3,
                'pembeli' => 'Customer Rina',
                'penjualan_kode' => 'BUY008',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'Customer Toto',
                'penjualan_kode' => 'BUY009',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3,
                'pembeli' => 'Customer Fitri',
                'penjualan_kode' => 'BUY010',
                'penjualan_tanggal' => now(),
            ],
        ];

        // untuk memasukkan data ke table t_penjualan
        DB::table('t_penjualan')->insert($data);
    }
}
