<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $guarded = [];

    // ✅ RELASI CABANG (WAJIB ADA)
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    // ✅ RELASI JABATAN (BIAR GAK ERROR BERIKUTNYA)
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}