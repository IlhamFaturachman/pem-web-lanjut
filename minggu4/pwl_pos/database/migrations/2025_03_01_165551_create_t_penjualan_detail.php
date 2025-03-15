<?php

// Kita buat file migration ini menggunakan command:
// php artisan make:migration create_t_penjualan_detail

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
        // Fungsi ini berfungsi untuk membuat table t_penjualan_detail
        Schema::create('t_penjualan_detail', function (Blueprint $table) {
            $table->id('detail_id'); // detail_id adalah primary key
            $table->unsignedBigInteger('penjualan_id')->index(); // penjualan_id adalah foreign key yang memiliki index
            $table->unsignedBigInteger('barang_id')->index(); // barang_id adalah foreign key yang memiliki index
            $table->integer('harga'); // harga adalah integer
            $table->integer('jumlah'); // jumlah adalah integer
            $table->timestamps(); // created_at dan updated_at adalah timestamp

            // Mendefinisikan foreign key pada kolom penjualan_id dengan referensi pada kolom penjualan_id pada table t_penjualan
            $table->foreign('penjualan_id') // penjualan_id adalah foreign key pada table t_penjualan_detail
                ->references('penjualan_id') // penjualan_id adalah primary key pada table t_penjualan
                ->on('t_penjualan') // t_penjualan adalah table yang berisi data penjualan
                ->cascadeOnUpdate() // on update cascade yang artinya adalah penjualan yang diubah akan terikat dengan penjualan yang sama pada table t_penjualan
                ->cascadeOnDelete(); // on delete cascade yang artinya adalah penjualan yang dihapus akan terikat dengan penjualan yang sama pada table t_penjualan

            // Mendefinisikan foreign key pada kolom barang_id dengan referensi pada kolom barang_id pada table m_barang
            $table->foreign('barang_id') // barang_id adalah foreign key pada table t_penjualan_detail
                ->references('barang_id') // barang_id adalah primary key pada table m_barang
                ->on('m_barang') // m_barang adalah table yang berisi data barang
                ->cascadeOnUpdate() // on update cascade yang artinya adalah barang yang diubah akan terikat dengan barang yang sama pada table m_barang
                ->cascadeOnDelete(); // on delete cascade yang artinya adalah barang yang dihapus akan terikat dengan barang yang sama pada table m_barang
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Fungsi ini berfungsi untuk menghapus table t_penjualan_detail
        Schema::dropIfExists('t_penjualan_detail');
    }
};

// Untuk menjalankan migration, kita bisa menggunakan command:
// php artisan migrate