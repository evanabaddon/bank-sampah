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

    // public function handle()
    // {
    //     $nasabahs = Nasabah::where('is_ppc', 1)->get();

    //     foreach ($nasabahs as $nasabah) {
    //         $kategoriLayanan = $nasabah->kategoriLayanan;

    //         $currentYear = now()->year;
    //         // Buat tanggal tagihan 2023-01-01
    //         $tanggalTagihan = $currentYear . '-' . $month . '-' . '01';

    //         // Buat tanggal jatuh tempo 2023-01-25
    //         $tanggalJatuhTempo = $currentYear . '-' . $month . '-' . '27';

    //         // Periksa apakah sudah ada tagihan pada bulan ini untuk nasabah ini
    //         $existingBill = Tagihan::where('nasabah_id', $nasabah->id)
    //             ->whereMonth('tanggal_tagihan', now()->month)
    //             ->whereYear('tanggal_tagihan', now()->year)
    //             ->first();

    //         if (!$existingBill) {
                

    //             // Hitung jumlah tagihan berdasarkan harga kategori layanan
    //             $jumlahTagihan = $kategoriLayanan->harga;


    //             // Buat record tagihan baru
    //             Tagihan::create([
    //                 'nasabah_id' => $nasabah->id,
    //                 'tanggal_tagihan' => $tanggalTagihan,
    //                 'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
    //                 'jumlah_tagihan' => $jumlahTagihan,
    //                 'status' => 'belum',
    //                 'keterangan' => 'Tagihan bulan ini'
    //             ]);
    //             $this->info('Tagihan bulan ini untuk nasabah ' . $nasabah->name . ' sudah dibuat.');
    //         }
    //     }
    //     $this->info('Selesai membuat tagihan bulan ini.');
    // }

    public function handle()
    {
        $nasabahs = Nasabah::where('is_ppc', 1)->get();

        $currentYear = now()->year;
        $startMonth = 1; // Mulai dari bulan pertama (Januari)
        $endMonth = 12; // Sampai dengan bulan kedua belas (Desember)

        foreach ($nasabahs as $nasabah) {
            $kategoriLayanan = $nasabah->kategoriLayanan;

            for ($month = $startMonth; $month <= $endMonth; $month++) {
                // Buat tanggal tagihan 2023-01-01
                $tanggalTagihan = $currentYear . '-' . $month . '-' . '01';

                // Buat tanggal jatuh tempo 2023-01-25
                $tanggalJatuhTempo = $currentYear . '-' . $month . '-' . '27';

                // parameter tanggal tagihan
                $cekTagihan = now()->setYear($currentYear)->setMonth($month)->setDay(01);

                $existingBill = Tagihan::where('nasabah_id', $nasabah->id)
                    ->whereMonth('tanggal_tagihan', $cekTagihan->month)
                    ->whereYear('tanggal_tagihan', $currentYear)
                    ->first();

                if (!$existingBill) {
                    // Hitung jumlah tagihan berdasarkan harga kategori layanan
                    $jumlahTagihan = $kategoriLayanan->harga;

                    // Buat record tagihan baru
                    Tagihan::create([
                        'nasabah_id' => $nasabah->id,
                        'tanggal_tagihan' => $tanggalTagihan,
                        'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                        'jumlah_tagihan' => $jumlahTagihan,
                        'status' => 'belum',
                        'keterangan' => 'Tagihan bulan ' . $cekTagihan->format('M Y')
                    ]);

                    $this->info('Tagihan bulan ' . $cekTagihan->format('M Y') . ' untuk nasabah ' . $nasabah->name . ' sudah dibuat.');
                }
            }
        }

        $this->info('Selesai membuat tagihan untuk seluruh bulan pada tahun yang berjalan.');
    }

            
}
