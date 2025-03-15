<?php

// Kita buat file migration ini menggunakan command:
// php artisan make:migration create_m_kategori_table

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
        // Fungsi ini berfungsi untuk membuat table m_kategori
        Schema::create('m_kategori', function (Blueprint $table) {
            $table->id('kategori_id'); // kategori_id adalah primary key
            $table->string('kategori_kode', 10)->unique(); // kategori_kode adalah unique dengan panjang 10 karakter
            $table->string('kategori_name', 100); // kategori_name adalah string dengan panjang 100 karakter
            $table->timestamps(); // created_at dan updated_at adalah timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Fungsi ini berfungsi untuk menghapus table m_kategori
        Schema::dropIfExists('m_kategori');
    }
};

// Untuk menjalankan migration, kita bisa menggunakan command:
// php artisan migrate