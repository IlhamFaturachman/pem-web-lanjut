<?php

// Kita buat file migration ini menggunakan command:
// php artisan make:migration create_t_stok_table

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
        // Fungsi ini berfungsi untuk membuat table t_stok
        Schema::create('t_stok', function (Blueprint $table) {
            $table->id('stok_id'); // stok_id adalah primary key
            $table->unsignedBigInteger('barang_id')->index(); // barang_id adalah foreign key yang memiliki index
            $table->unsignedBigInteger('user_id')->index(); // user_id adalah foreign key yang memiliki index
            $table->dateTime('stok_tanggal'); // stok_tanggal adalah datetime
            $table->integer('stok_jumlah'); // stok_jumlah adalah integer
            $table->timestamps(); // created_at dan updated_at adalah timestamp

            // Mendefinisikan foreign key pada kolom barang_id dengan referensi pada kolom barang_id pada table m_barang
            $table->foreign('barang_id') // barang_id adalah foreign key pada table t_stok
                ->references('barang_id') // barang_id adalah primary key pada table m_barang
                ->on('m_barang') // m_barang adalah table yang berisi data barang
                ->cascadeOnUpdate() // on update cascade yang artinya adalah barang yang diubah akan terikat dengan barang yang sama pada table m_barang
                ->cascadeOnDelete(); // on delete cascade yang artinya adalah barang yang dihapus akan terikat dengan barang yang sama pada table m_barang

            // Mendefinisikan foreign key pada kolom user_id dengan referensi pada kolom user_id pada table m_user
            $table->foreign('user_id') // user_id adalah foreign key pada table t_stok
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
        // Fungsi ini berfungsi untuk menghapus table t_stok
        Schema::dropIfExists('t_stok');
    }
};

// Untuk menjalankan migration, kita bisa menggunakan command:
// php artisan migrate