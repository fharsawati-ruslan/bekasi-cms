<?php

namespace App\Imports;

use App\Models\Satuan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SatuanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 🔥 normalize header (biar bebas Nama / nama / SATUAN)
        $row = array_change_key_case($row, CASE_LOWER);

        // 🔥 ambil data fleksibel
        $nama = $row['nama'] ?? $row['satuan'] ?? null;

        // 🔥 skip kalau kosong
        if (!$nama) {
            return null;
        }

        return Satuan::updateOrCreate(
            ['nama' => strtoupper($nama)] // 🔥 auto uppercase
        );
    }
}