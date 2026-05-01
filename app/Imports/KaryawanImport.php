<?php

namespace App\Imports;

use App\Models\Karyawan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
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
        // ambil kolom tabel (sekali saja)
        $this->columns = Schema::getColumnListing('karyawans');

        // mapping lowercase biar aman
        $this->cabangMap = \App\Models\Cabang::pluck('id', 'nama')
            ->mapWithKeys(fn($id, $nama) => [Str::lower(trim($nama)) => $id])
            ->toArray();

        $this->jabatanMap = \App\Models\Jabatan::pluck('id', 'nama')
            ->mapWithKeys(fn($id, $nama) => [Str::lower(trim($nama)) => $id])
            ->toArray();
    }

    public function model(array $row)
    {
        // normalize key (biar aman dari spasi / kapital)
        $row = array_change_key_case($row, CASE_LOWER);

        $cabang = isset($row['cabang']) 
            ? Str::lower(trim($row['cabang'])) 
            : null;

        $jabatan = isset($row['jabatan']) 
            ? Str::lower(trim($row['jabatan'])) 
            : null;

        $data = [
            'cabang_id' => $this->cabangMap[$cabang] ?? null,
            'jabatan_id' => $this->jabatanMap[$jabatan] ?? null,

            'role' => $row['role'] ?? 'staff',
            'nama' => $row['nama'] ?? null,
            'nik' => $row['nik'] ?? null,
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'hp' => $row['hp'] ?? null,
            'jenis_kelamin' => $row['jenis_kelamin'] ?? null,

            'menikah' => (int) ($row['menikah'] ?? 0),
            'jumlah_anak' => (int) ($row['jumlah_anak'] ?? 0),

            'pendidikan' => $row['pendidikan'] ?? null,
            'penyakit' => $row['penyakit'] ?? null,
            'nomor_darurat' => $row['nomor_darurat'] ?? null,

            'bergabung_pada' => $row['bergabung_pada'] ?? null,

            'gaji_pokok' => (float) ($row['gaji_pokok'] ?? 0),
            'komisi' => (float) ($row['komisi'] ?? 0),

            'email' => $row['email'] ?? null,

            // password default (bcrypt "password")
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.ogPZl8r6QJ9lF6e.',
        ];

        // filter hanya kolom yang ada di DB
        $safeData = array_intersect_key($data, array_flip($this->columns));

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