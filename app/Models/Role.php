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
        'permissions' => 'array', // 🔥 penting biar JSON jadi array
    ];

    // 🔗 RELASI KE USER
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // 🔐 CHECK PERMISSION (optional helper)
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions ?? []);
    }
}
