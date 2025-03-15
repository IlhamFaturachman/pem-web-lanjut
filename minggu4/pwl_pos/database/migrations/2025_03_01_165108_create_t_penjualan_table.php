<?php

// Kita buat file migration ini menggunakan command:
// php artisan make:migration create_t_penjualan_table

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
        // Fungsi ini berfungsi untuk membuat table t_penjualan
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id'); // penjualan_id adalah primary key
            $table->unsignedBigInteger('user_id')->index(); // user_id adalah foreign key yang memiliki index
            $table->string('pembeli', 50); // pembeli adalah string dengan panjang 50 karakter
            $table->string('penjualan_kode', 20); // penjualan_kode adalah string dengan panjang 20 karakter
            $table->dateTime('penjualan_tanggal'); // penjualan_tanggal adalah date
            $table->timestamps();

            // Mendefinisikan foreign key pada kolom user_id dengan referensi pada kolom user_id pada table m_user
            $table->foreign('user_id') // user_id adalah foreign key pada table t_penjualan
                ->references('user_id') // user_id adalah primary key pada table m_user
                ->on('m_user') // m_user adalah table yang berisi data user
                ->cascadeOnUpdate() // on update cascade yang artinya adalah user yang diubah akan terikat dengan user yang sama pada table m_user
                ->cascadeOnDelete(); // on delete cascade yang artinya adalah user yang dihapus akan terikat dengan user yang sama pada table m_user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Fungsi ini berfungsi untuk menghapus table t_penjualan
        Schema::dropIfExists('t_penjualan');
    }
};

// Untuk menjalankan migration, kita bisa menggunakan command:
// php artisan migrate