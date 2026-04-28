<?php

namespace App\Imports;

use App\Models\Bank;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BankImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 🔥 normalize header (huruf kecil semua)
        $row = array_change_key_case($row, CASE_LOWER);

        // 🔥 mapping fleksibel (ikut file kamu)
        $nama = $row['nama'] ?? $row['nama '] ?? null;

        $nomor_rekening = 
            $row['nomor_rekening'] ??
            $row['nomor rekening'] ??
            $row['rekening'] ??
            0;

        $potongan = 
            $row['potongan_transaksi'] ??
            $row['potongan transaksi'] ??
            0;

        $kasir = 
            $row['tampilkan_di_kasir'] ??
            $row['tampilkan di kasir?'] ??
            $row['kasir'] ??
            0;

        $global = 
            $row['rekening_global'] ??
            $row['rekening global?'] ??
            0;

        // 🔥 skip kalau nama kosong
        if (!$nama) {
            return null;
        }

        return Bank::updateOrCreate(
            ['nama' => $nama],
            [
                'nomor_rekening' => $nomor_rekening,
                'potongan_transaksi' => $potongan,
                'tampilkan_di_kasir' => filter_var($kasir, FILTER_VALIDATE_BOOLEAN),
                'rekening_global' => filter_var($global, FILTER_VALIDATE_BOOLEAN),
            ]
        );
    }
}