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

    public function ruangans()
    {
    return $this->hasMany(Ruangan::class);
    }

    public function wilayahs()
    {
        return $this->hasMany(Wilayah::class, 'cabang_id');
    }
    public function kamars()
    {
    return $this->hasMany(Kamar::class);
    }

}