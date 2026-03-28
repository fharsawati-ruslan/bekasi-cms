<?php

namespace App\Imports;

use App\Models\Cabang;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class CabangImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    public function model(array $row)
    {
        return new Cabang([
            'nama' => isset($row['nama']) ? ucwords(strtolower($row['nama'])) : null,
            'kode' => isset($row['kode']) ? strtoupper($row['kode']) : null,
            'wilayah' => $row['wilayah'] ?? null,
            'telpon' => $row['telpon'] ?? null,
            'hp' => $row['hp'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'tanggal_tutup_buku' => $row['tanggal_tutup_buku'] ?? 1,
            'aktif' => true,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nama' => ['required'],
            '*.kode' => ['required'],
        ];
    }
}