<?php

// Kita buat file migration ini menggunakan command:
// php artisan make:migration create_m_barang_table

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
        // Fungsi ini berfungsi untuk membuat table m_barang
        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id'); // barang_id adalah primary key
            $table->unsignedBigInteger('kategori_id')->index(); // kategori_id adalah foreign key yang memiliki index
            $table->string('barang_kode', 10)->unique(); // barang_kode adalah unique dengan panjang 10 karakter
            $table->string('barang_name', 100); // barang_name adalah string dengan panjang 100 karakter
            $table->integer('harga_beli'); // harga_beli adalah integer
            $table->integer('harga_jual'); // harga_jual adalah integer
            $table->timestamps(); // created_at dan updated_at adalah timestamp

            // Mendefinisikan foreign key pada kolom kategori_id dengan referensi pada kolom kategori_id pada table m_kategori
            $table->foreign('kategori_id') // kategori_id adalah foreign key pada table m_barang
                ->references('kategori_id') // kategori_id adalah primary key pada table m_kategori
                ->on('m_kategori') // m_kategori adalah table yang berisi data kategori
                ->cascadeOnUpdate() // on update cascade yang artinya adalah kategori yang diubah akan terikat dengan kategori yang sama pada table m_kategori
                ->cascadeOnDelete(); // on delete cascade yang artinya adalah kategori yang dihapus akan terikat dengan kategori yang sama pada table m_kategori
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Fungsi ini berfungsi untuk menghapus table m_barang
        Schema::dropIfExists('m_barang');
    }
};

// Untuk menjalankan migration, kita bisa menggunakan command:
// php artisan migrate