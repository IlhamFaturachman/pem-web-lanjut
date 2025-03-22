<?php

// Kita buat file migration ini menggunakan command:
// php artisan make:migration create_m_level_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fungsi ini berfungsi untuk membuat table m_level
        Schema::create('m_level', function (Blueprint $table) {
            // Kolom level_id adalah primary key
            $table->id('level_id');
            // Kolom level_kode adalah unique
            $table->string('level_kode', 10)->unique();
            // Kolom level_name adalah string
            $table->string('level_name', 100);
            // Kolom created_at dan updated_at adalah timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Fungsi ini berfungsi untuk menghapus table m_level
        Schema::dropIfExists('m_level');
    }
};

// Untuk menjalankan migration, kita bisa menggunakan command:
// php artisan migrate