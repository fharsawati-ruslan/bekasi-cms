<?php

namespace App\Imports;

use App\Models\Pengaturan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PengaturanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Pengaturan::updateOrCreate(
            ['nama' => $row['nama'] ?? '-'],
            ['nilai' => $row['nilai'] ?? '-'] // 🔥 biar gak null
        );
    }
}