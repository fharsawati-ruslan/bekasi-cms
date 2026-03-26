<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $fillable = [
        'nama',
        'nilai',
    ];

    /**
     * 🔥 Helper ambil setting langsung
     * contoh: Pengaturan::getValue('Jam Buka')
     */
    public static function getValue($nama, $default = null)
    {
        return static::where('nama', $nama)->value('nilai') ?? $default;
    }

    /**
     * 🔥 Helper update / create
     */
    public static function setValue($nama, $nilai)
    {
        return static::updateOrCreate(
            ['nama' => $nama],
            ['nilai' => $nilai]
        );
    }
}
