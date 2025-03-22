<?php

// Kita buat file migration ini menggunakan command:
// php artisan make:migration create_m_user_table

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
        // Fungsi ini berfungsi untuk membuat table m_user
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('user_id'); // user_id adalah primary key
            $table->unsignedBigInteger('level_id')->index(); // level_id adalah foreign key yang memiliki index
            $table->string('username', 20)->unique(); // username adalah unique dengan panjang 20 karakter
            $table->string('nama', 100); // nama adalah string dengan panjang 100 karakter
            $table->string('password'); // password adalah string
            $table->timestamps(); // created_at dan updated_at adalah timestamp

            // Mendefinisikan foreign key pada kolom level_id dengan referensi pada kolom level_id pada table m_level
            $table->foreign('level_id') // level_id adalah foreign key pada table m_user
                ->references('level_id') // level_id adalah primary key pada table m_level
                ->on('m_level') // m_level adalah table yang berisi data level
                ->cascadeOnUpdate() // on update cascade yang artinya adalah level yang diubah akan terikat dengan level yang sama pada table m_level
                ->cascadeOnDelete(); // on delete cascade yang artinya adalah level yang dihapus akan terikat dengan level yang sama pada table m_level
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Fungsi ini berfungsi untuk menghapus table m_user
        Schema::dropIfExists('m_user');
    }
};

// Untuk menjalankan migration, kita bisa menggunakan command:
// php artisan migrate
