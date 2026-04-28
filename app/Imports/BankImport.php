<?php

namespace App\Imports;

use App\Models\Bank;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BankImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 🔥 normalize header (biar fleksibel)
        $row = array_change_key_case($row, CASE_LOWER);

        // 🔥 mapping fleksibel (support banyak kemungkinan header)
        $nama = $row['nama'] ?? $row['nama '] ?? null;

        $nomor_rekening =
            $row['nomor_rekening'] ??
            $row['nomor rekening'] ??
            $row['rekening'] ??
            null;

        $potongan =
            $row['potongan_transaksi'] ??
            $row['potongan transaksi'] ??
            $row['potongan'] ??
            0;

        $kasir =
            $row['tampilkan_di_kasir'] ??
            $row['tampilkan di kasir?'] ??
            $row['kasir'] ??
            '0';

        $global =
            $row['rekening_global'] ??
            $row['rekening global?'] ??
            '0';

        // ❌ skip kalau data penting kosong
        if (!$nama || !$nomor_rekening) {
            return null;
        }

        // 🔥 convert boolean fleksibel (ya/tidak, 1/0, true/false)
        $kasir = $this->toBool($kasir);
        $global = $this->toBool($global);

        // 🔥 update kalau sudah ada (biar gak duplicate)
        return Bank::updateOrCreate(
            ['nomor_rekening' => $nomor_rekening],
            [
                'nama' => $nama,
                'potongan_transaksi' => $potongan,
                'tampilkan_di_kasir' => $kasir,
                'rekening_global' => $global,
            ]
        );
    }

    /**
     * Convert berbagai format ke boolean
     */
    private function toBool($value): bool
    {
        $value = strtolower(trim((string) $value));

        return in_array($value, ['1', 'true', 'ya', 'yes'], true);
    }
}