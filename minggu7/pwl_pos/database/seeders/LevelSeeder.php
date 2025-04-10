<?php

// kita bisa menggunakan command:
// php artisan db:seed --class=LevelSeeder
// untuk membuat file seeder yang nantinya akan me-seed data ke table m_level dengan sejumlah data yang telah ditentukan

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Berisi data data yang telah disiapkan untuk table m_level
        $data = [
            [
                'level_id' => 1,
                'level_kode' => 'ADM',
                'level_name' => 'Administrator',
            ],
            [
                'level_id' => 2,
                'level_kode' => 'MNG',
                'level_name' => 'Manager',
            ],
            [
                'level_id' => 3,
                'level_kode' => 'STF',
                'level_name' => 'Staff/Kasir',
            ],
        ];

        // untuk memasukkan data ke table m_level
        DB::table('m_level')->insert($data);
    }
}

// untuk menambahkan data ke table m_level
// php artisan db:seed --class=LevelSeeder
