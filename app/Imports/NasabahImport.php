<?php

namespace App\Imports;

use App\Models\Nasabah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NasabahImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Mendapatkan kode nasabah terakhir dari database
        $lastNasabah = Nasabah::orderBy('id', 'desc')->first();

        // Menginisialisasi nomor nasabah baru
        $newNasabahNumber = 1;

        // Jika ada kode nasabah terakhir, ambil nomor nasabahnya
        if ($lastNasabah) {
            $lastNasabahNumber = (int) substr($lastNasabah->kodenasabah, 3);
            $newNasabahNumber = $lastNasabahNumber + 1;
        }

        // Format ulang nomor nasabah dengan 4 digit
        $newNasabahId = sprintf("NAS%04d", $newNasabahNumber);

        // Jika kolom 'name' tidak ada dalam baris data, kembalikan null
        if (!isset($row['name'])) {
            return null;
        }

        // Buat atau perbarui catatan nasabah berdasarkan data baris
        return new Nasabah([
            'kodenasabah' => $newNasabahId,
            'name' => $row['name'] ?? null,
            'rt' => $row['rt'] ?? null,
            'rw' => $row['rw'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'nohp' => $row['nohp'] ?? null,
            'is_bsp' => $row['is_bsp'] ?? null,
            'is_ppc' => $row['is_ppc'] ?? null,
            'kategori_layanan_id' => $row['kategori_layanan_id'] ?? null,
            'saldo' => $row['saldo'] ?? 0,
        ]);
    }
}