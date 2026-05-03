<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PoinEkstra;

class Poin extends Model
{
    protected $table = 'poins';

    protected $fillable = [
        'nama',
        'poin',
    ];

    public function ekstra()
    {
        return $this->hasMany(PoinEkstra::class);
    }
}