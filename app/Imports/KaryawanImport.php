<?php

namespace App\Imports;

use App\Models\Karyawan;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class KaryawanImport implements 
    ToModel, 
    WithHeadingRow, 
    WithChunkReading, 
    WithBatchInserts
{
    protected array $columns;
    protected array $cabangMap = [];
    protected array $jabatanMap = [];

    public function __construct()
    {
        // ambil kolom DB
        $this->columns = Schema::getColumnListing('karyawans');

        // 🔥 ambil semua cabang SEKALI
        $this->cabangMap = \App\Models\Cabang::pluck('id', 'nama')->toArray();

        // 🔥 ambil semua jabatan SEKALI
        $this->jabatanMap = \App\Models\Jabatan::pluck('id', 'nama')->toArray();
    }

    public function model(array $row)
    {
        $data = [
            'cabang_id' => $this->cabangMap[$row['cabang']] ?? null,
            'jabatan_id' => $this->jabatanMap[$row['jabatan']] ?? null,

            'role' => $row['role'] ?? 'staff',
            'nama' => $row['nama'] ?? null,
            'nik' => $row['nik'] ?? null,
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'hp' => $row['hp'] ?? null,
            'jenis_kelamin' => $row['jenis_kelamin'] ?? null,

            'menikah' => $row['menikah'] ?? 0,
            'jumlah_anak' => $row['jumlah_anak'] ?? 0,

            'pendidikan' => $row['pendidikan'] ?? null,
            'penyakit' => $row['penyakit'] ?? null,
            'nomor_darurat' => $row['nomor_darurat'] ?? null,

            'bergabung_pada' => $row['bergabung_pada'] ?? null,

            'gaji_pokok' => $row['gaji_pokok'] ?? 0,
            'komisi' => $row['komisi'] ?? 0,

            'email' => $row['email'] ?? null,

            // 🔥 anti timeout
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.ogPZl8r6QJ9lF6e.',
        ];

        // 🔥 FILTER AMAN
        $safeData = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $this->columns)) {
                $safeData[$key] = $value;
            }
        }

        return new Karyawan($safeData);
    }

    public function chunkSize(): int
    {
        return 200;
    }

    public function batchSize(): int
    {
        return 200;
    }
}