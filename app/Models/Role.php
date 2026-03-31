<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array', // 🔥 JSON otomatis jadi array
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // 🔗 KE USER
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // 🔗 KE KARYAWAN (INI TAMBAHAN DARI SAYA)
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    // 🔐 CEK PERMISSION
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions ?? []);
    }
}
