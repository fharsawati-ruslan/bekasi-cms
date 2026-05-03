<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeMember extends Model
{
    protected $fillable = [
        'nama_tipe',
        'min_poin',
        'max_poin',
        'benefit',
    ];
}