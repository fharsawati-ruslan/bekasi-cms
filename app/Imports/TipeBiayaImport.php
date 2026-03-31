<?php

namespace App\Imports;

use App\Models\TipeBiaya;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TipeBiayaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 🔥 normalize header
        $row = array_change_key_case($row, CASE_LOWER);

        // 🔥 ambil nama fleksibel (ikut excel kamu)
        $nama = 
            $row['nama'] ?? 
            $row['tipe biaya'] ?? 
            $row['tipe_biaya'] ?? 
            null;

        // 🔥 skip kalau kosong
        if (!$nama) {
            return null;
        }

        return TipeBiaya::updateOrCreate(
            ['nama' => strtoupper($nama)]
        );
    }
}