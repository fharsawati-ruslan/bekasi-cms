<?php

namespace App\Imports;

use App\Models\Ruangan;
use App\Models\Cabang;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class RuanganImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // ❌ kalau kosong, stop
        if ($rows->isEmpty()) {
            return;
        }

        // 🔥 skip header
        $rows = $rows->skip(1);

        foreach ($rows as $index => $row) {

            try {

                // 🔥 validasi minimal 2 kolom
                if (!isset($row[0]) || !isset($row[1])) {
                    continue;
                }

                // 🔥 bersihin data
                $namaCabang  = trim((string) $row[0]);
                $namaRuangan = trim((string) $row[1]);

                // ❌ skip kalau kosong
                if ($namaCabang === '' || $namaRuangan === '') {
                    continue;
                }

                // 🔥 AUTO CREATE CABANG (case insensitive)
                $cabang = Cabang::whereRaw('LOWER(nama) = ?', [strtolower($namaCabang)])
                    ->first();

                if (!$cabang) {
                    $cabang = Cabang::create([
                        'nama' => $namaCabang
                    ]);
                }

                // 🔥 INSERT / UPDATE RUANGAN
                Ruangan::updateOrCreate(
                    [
                        'nama' => $namaRuangan,
                        'cabang_id' => $cabang->id,
                    ],
                    [
                        'aktif' => 1,
                    ]
                );

            } catch (\Throwable $e) {

                // 🔥 biar gak nge-crash semua import
                logger('Import error row ' . $index . ': ' . $e->getMessage());

                continue;
            }
        }
    }
}