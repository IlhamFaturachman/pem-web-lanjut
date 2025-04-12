<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    use HasFactory;

    protected $table = 't_stok';
    protected $primaryKey = 'stok_id';

    protected $fillable = [
        'barang_id',
        'user_id',
        'stok_tanggal',
        'stok_jumlah',
    ];

    protected $dates = ['stok_tanggal'];

    /**
     * Relasi ke model Barang
     */
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
