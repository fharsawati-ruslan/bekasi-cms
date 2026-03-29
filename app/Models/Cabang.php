<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $guarded = [];

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'cabang_id');
    }
}
