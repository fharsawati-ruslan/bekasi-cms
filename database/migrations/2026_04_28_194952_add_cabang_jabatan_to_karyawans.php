<?php

namespace App\Imports;

use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KaryawanImport implements ToModel, WithHeadingRow
{
    protected array $columns;

    public function __construct()
    {
        // ambil kolom DB SEKALI saja
        $this->columns = Schema::getColumnListing('karyawans');
    }

    public function model(array $row)
    {
        // 🔥 mapping semua kemungkinan field
        $data = [
            'cabang_id' => $this->getCabang($row['cabang'] ?? null),
            'jabatan_id' => $this->getJabatan($row['jabatan'] ?? null),

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

            // ⚠️ ini sering bikin error
            'aktif' => $row['aktif'] ?? null,

            'gaji_pokok' => $row['gaji_pokok'] ?? 0,
            'komisi' => $row['komisi'] ?? 0,

            'email' => $row['email'] ?? null,
            'password' => isset($row['password'])
                ? Hash::make($row['password'])
                : Hash::make('123456'),
        ];

        // 🔥 FILTER SUPER KETAT (INI KUNCI FIX)
        $safeData = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $this->columns)) {
                $safeData[$key] = $value;
            }
        }

        return new Karyawan($safeData);
    }

    private function getCabang($nama)
    {
        if (!$nama) return null;

        return \App\Models\Cabang::where('nama', $nama)->value('id');
    }

    private function getJabatan($nama)
    {
        if (!$nama) return null;

        return \App\Models\Jabatan::where('nama', $nama)->value('id');
    }
}