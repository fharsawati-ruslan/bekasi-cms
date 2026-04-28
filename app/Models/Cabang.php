<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $guarded = [];

    // =========================
    // RELASI KE KARYAWAN
    // =========================
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'cabang_id');
    }

    // =========================
    // RELASI KE RUANGAN
    // =========================
    public function ruangans()
    {
        return $this->hasMany(Ruangan::class);
    }

    // =========================
    // RELASI KE WILAYAH
    // =========================
    public function wilayahs()
    {
        return $this->hasMany(Wilayah::class, 'cabang_id');
    }

    // =========================
    // RELASI KE KAMAR
    // =========================
    public function kamars()
    {
        return $this->hasMany(Kamar::class);
    }

    // 🔥🔥 INI YANG KURANG (WAJIB)
    // RELASI KE BANK (MANY TO MANY)
    // =========================
    public function banks()
    {
        return $this->belongsToMany(Bank::class);
    }
}