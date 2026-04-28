<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['paket_id', 'kode', 'is_used'];

public function paket()
{
    return $this->belongsTo(\App\Models\Paket::class);
}
}
