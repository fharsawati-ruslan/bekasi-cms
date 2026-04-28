<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'nama',
        'nomor_rekening',
        'potongan_transaksi',
        'tampilkan_di_kasir',
        'rekening_global',
    ];

    // 🔥 RELASI KE CABANG
    public function cabangs()
    {
        return $this->belongsToMany(Cabang::class);
    }
}