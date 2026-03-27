<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $guarded = [];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function terapis()
    {
        return $this->belongsTo(Terapis::class);
    }
}