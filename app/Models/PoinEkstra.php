<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Poin;

class PoinEkstra extends Model
{
    protected $table = 'poin_ekstras';

    protected $fillable = [
        'poin_id',
        'nama',
        'tanggal_mulai',
        'tanggal_berakhir',
        'kelipatan_poin',
    ];

    // 🔗 Relasi balik ke Poin
    public function poin()
    {
        return $this->belongsTo(Poin::class);
    }
}