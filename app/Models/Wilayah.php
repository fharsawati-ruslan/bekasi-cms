<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $fillable = [
        'cabang_id',
        'nama',
        'kode',
        'aktif',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}