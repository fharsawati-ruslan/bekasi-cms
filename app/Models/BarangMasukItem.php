<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasukItem extends Model
{
    protected $fillable = [
        'barang_masuk_id',
        'barang_id',
        'qty',
        'harga',
        'subtotal'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
