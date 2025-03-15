<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'BRG-001',
                'barang_name' => 'Handphone',
                'harga_beli' => 10000000,
                'harga_jual' => 15000000,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'BRG-002',
                'barang_name' => 'Laptop',
                'harga_beli' => 14000000,
                'harga_jual' => 16000000,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 2,
                'barang_kode' => 'BRG-003',
                'barang_name' => 'Trousers',
                'harga_beli' => 750000,
                'harga_jual' => 1200000,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode' => 'BRG-004',
                'barang_name' => 'Jaket',
                'harga_beli' => 500000,
                'harga_jual' => 800000,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 3,
                'barang_kode' => 'BRG-005',
                'barang_name' => 'Cushion Scintific',
                'harga_beli' => 150000,
                'harga_jual' => 200000,
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3,
                'barang_kode' => 'BRG-006',
                'barang_name' => 'Make Over Foundation',
                'harga_beli' => 20000,
                'harga_jual' => 30000,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 4,
                'barang_kode' => 'BRG-007',
                'barang_name' => 'Bakso',
                'harga_beli' => 5000,
                'harga_jual' => 7500,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 4,
                'barang_kode' => 'BRG-008',
                'barang_name' => 'Mie Goreng',
                'harga_beli' => 2500,
                'harga_jual' => 3000,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode' => 'BRG-009',
                'barang_name' => 'Golf Stick Premium',
                'harga_beli' => 7000000,
                'harga_jual' => 30000000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'BRG-010',
                'barang_name' => 'Nike Pegassus',
                'harga_beli' => 3400000,
                'harga_jual' => 5000000,
            ]
        ];

        // insert data ke table m_barang
        DB::table('m_barang')->insert($data);
    }
}
