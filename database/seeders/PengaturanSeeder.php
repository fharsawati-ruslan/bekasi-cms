<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Masa Berlaku Poin' => '2 tahun',
            'Waktu Istirahat Terapis' => '30 menit',
            'Limit Saldo Setelah Pinjaman' => '100000',
            'Limit Biaya Disetujui' => '200000',
            'Limit Pinjaman Disetujui' => '100000',
            'Jam Tutup' => '21:00',
            'Jam Buka' => '08:00',
        ];

        foreach ($data as $nama => $nilai) {
            Pengaturan::updateOrCreate(
                ['nama' => $nama],
                ['nilai' => $nilai]
            );
        }
    }
}
