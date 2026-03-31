<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeBiaya extends Model
{
    protected $fillable = [
        'nama',
        'cabang_id', // 🔥 tambah ini
    ];

    // =========================
    // RELASI KE CABANG
    // =========================
    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    // =========================
    // (OPTIONAL) RELASI KE SUB TIPE
    // =========================
    public function subTipes()
    {
        return $this->hasMany(SubTipeBiaya::class);
    }
}