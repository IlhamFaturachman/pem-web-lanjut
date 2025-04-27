<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password',
        'profile_pic',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    /**
     * 
     * Mendapatkan nama role
     * 
     */
    public function getRoleName(): string
    {
        return $this->level->level_name;
    }

    /**
     * 
     * Cek apakah user memiliki role tertentu
     * 
     */
    public function hasRole($role): bool
    {
        return $this->level->level_kode === $role;
    }

    /**
     * 
     * Mendapatkan kode role
     * 
     */
    public function getRole()
    {
        return $this->level->level_kode;
    }

    protected function profilePic(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? url('/uploads/profile/' . $value) : null,
        );
    }
}
