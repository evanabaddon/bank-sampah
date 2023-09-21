<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Nasabah;
use App\Models\Tagihan;

class GenerateMonthlyBill extends Command
{
    protected $signature = 'generate:monthly-bill';
    protected $description = 'Generate monthly bills nasabah';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $nasabahs = Nasabah::where('is_ppc', 1)->get();

        foreach ($nasabahs as $nasabah) {
            $kategoriLayanan = $nasabah->kategoriLayanan;

            // Periksa apakah sudah ada tagihan pada bulan ini untuk nasabah ini
            $existingBill = Tagihan::where('nasabah_id', $nasabah->id)
                ->whereMonth('tanggal_tagihan', now()->month)
                ->whereYear('tanggal_tagihan', now()->year)
                ->first();

            if (!$existingBill) {
                // Hitung jumlah tagihan berdasarkan harga kategori layanan
                $jumlahTagihan = $kategoriLayanan->harga;

                // Buat record tagihan baru
                Tagihan::create([
                    'nasabah_id' => $nasabah->id,
                    'tanggal_tagihan' => now(),
                    'tanggal_jatuh_tempo' => now()->endOfMonth(),
                    'jumlah_tagihan' => $jumlahTagihan,
                    'status' => 'belum',
                    'keterangan' => 'Tagihan bulan ini'
                ]);
                $this->info('Tagihan bulan ini untuk nasabah ' . $nasabah->name . ' sudah dibuat.');
            }
            $this->info('Tagihan bulan ini untuk nasabah ' . $nasabah->name . ' sudah dibuat.');
        }
        $this->info('Selesai membuat tagihan bulan ini.');
    }

}
