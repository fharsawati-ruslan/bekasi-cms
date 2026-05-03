<?php

namespace App\Imports;

use App\Models\Poin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PoinImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Poin([
            'nama_member' => $row['nama'] ?? '',
            'poin'        => (int) ($row['penyesuaian poin'] ?? 0),
            'keterangan'  => $row['keterangan'] ?? null,
            'tanggal'     => now(),
        ]);
    }
}