<?php

namespace App\Imports;

use App\Models\TipeTransfer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TipeTransferImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return TipeTransfer::updateOrCreate(
            ['nama' => strtoupper($row['nama'])],
            ['nama' => strtoupper($row['nama'])]
        );
    }
}