<?php

// selain menggunakan command:
// php artisan db:seed
// kita juga bisa menggunakan command:
// php artisan db:seed --class=NamaSeeder
// namun akan lebih efisien jika kita menaruh semua class Seeder dalam satu file yaitu DatabaseSeeder.php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LevelSeeder::class); // untuk menambahkan data ke table m_level
        $this->call(UserSeeder::class); // untuk menambahkan data ke table m_user
    }
}
