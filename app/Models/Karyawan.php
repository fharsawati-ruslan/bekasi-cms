<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // 🔗 CABANG
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    // 🔗 JABATAN
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    // 🔗 ROLE (INI TAMBAHAN BARU 🔥)
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'is_terapis' => 'boolean',
        'is_active' => 'boolean',
        'bergabung_pada' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR (OPSIONAL BIAR UI BAGUS)
    |--------------------------------------------------------------------------
    */

    // Contoh: ambil nama role langsung
    public function getNamaRoleAttribute()
    {
        return $this->role?->name;
    }

    // Contoh: ambil nama cabang
    public function getNamaCabangAttribute()
    {
        return $this->cabang?->nama;
    }
}
