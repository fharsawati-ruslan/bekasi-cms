<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paket;

class PaketImportSeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('app/voucher.csv');

        if (!file_exists($path)) {
            echo "File voucher.csv tidak ditemukan\n";
            return;
        }

        $file = fopen($path, 'r');

        $header = fgetcsv($file); // skip header

        while (($row = fgetcsv($file)) !== false) {

            Paket::updateOrCreate(
                ['nama' => $row[0]],
                [
                    'tipe_voucher' => strtolower($row[1]),
                    'nilai' => $row[2] ?: null,
                    'berlaku_hingga' => $row[3],
                    'jumlah_tukar_poin' => $row[4],
                ]
            );
        }

        fclose($file);

        echo "Import selesai 🚀\n";
    }
}