<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SupplierImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 🔥 normalize header
        $row = array_change_key_case($row, CASE_LOWER);

        $nama = $row['nama'] ?? $row['nama '] ?? null;
        $telpon = $row['telpon'] ?? $row['no_telp'] ?? $row['phone'] ?? '';
        $alamat = $row['alamat'] ?? '';

        if (!$nama) {
            return null;
        }

        return Supplier::updateOrCreate(
            ['nama' => $nama],
            [
                'telpon' => $telpon,
                'alamat' => $alamat,
            ]
        );
    }
}