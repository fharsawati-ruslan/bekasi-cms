<?php

namespace App\Imports;

use App\Models\PoinEkstra;
use App\Models\Poin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PoinEkstraImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $poin = Poin::where('nama', $row['poin_nama'])->first();

        return new PoinEkstra([
            'poin_id' => $poin?->id,
            'nama' => $row['nama'],
            'tanggal_mulai' => $row['tanggal_mulai'],
            'tanggal_berakhir' => $row['tanggal_berakhir'],
            'kelipatan_poin' => $row['kelipatan_poin'],
        ]);
    }
}