<?php

namespace App\Imports;

use App\Models\Wilayah;
use App\Models\Cabang;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class WilayahImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rows->shift();

        foreach ($rows as $row) {

            $cabang = Cabang::where('nama', $row[0])->first();

            if (!$cabang) continue;

            Wilayah::updateOrCreate(
                [
                    'nama' => $row[1],
                    'cabang_id' => $cabang->id,
                ],
                [
                    'kode' => $row[2] ?? null,
                    'aktif' => $row[3] ?? 1,
                ]
            );
        }
    }
}