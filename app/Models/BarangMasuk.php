<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'tanggal',
        'supplier_id',
        'pembayaran',
        'total',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(BarangMasukItem::class);
    }
}
