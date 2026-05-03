<?php

namespace App\Imports;

use App\Models\TipeMember;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TipeMemberImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new TipeMember([
            'nama_tipe' => $row['nama'] ?? '',
            'min_poin'  => 0,
            'max_poin'  => $row['kelipatan poin'] ?? 0,
            'benefit'   => 'Auto import',
        ]);
    }
}