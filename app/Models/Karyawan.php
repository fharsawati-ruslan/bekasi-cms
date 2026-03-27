<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jabatan;

class Karyawan extends Model
{
    protected $guarded = [];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}