<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Android extends Model
{
    protected $fillable = [
        'nama',
        'foto',
        'link',
        'deskripsi',
        'aktif'
    ];
}
