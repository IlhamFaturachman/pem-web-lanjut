<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'KAT-001',
                'kategori_name' => 'Elektronik',
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'KAT-002',
                'kategori_name' => 'Pakaian',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'KAT-003',
                'kategori_name' => 'Kecantikan',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'KAT-004',
                'kategori_name' => 'Makanan',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'KAT-005',
                'kategori_name' => 'Olahraga',
            ],
        ];

        // untuk memasukkan data ke table m_kategori
        DB::table('m_kategori')->insert($data);
    }
}
