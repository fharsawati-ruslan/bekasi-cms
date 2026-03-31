<?php

namespace App\Imports;

use App\Models\TipePenguranganGaji;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TipePenguranganGajiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return TipePenguranganGaji::updateOrCreate(
            ['nama' => strtoupper($row['nama'])],
            [
                'nama' => strtoupper($row['nama']),
                'diangsur' => $row['diangsur'] ?? 0,
                'memotong_kas' => $row['memotong_kas'] ?? 0,
            ]
        );
    }
}