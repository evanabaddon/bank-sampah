<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\TransaksiPengeluaran;
use Illuminate\Http\Request;
use PDF;

class NeracaKeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan daftar bulan dan tahun unik dari transaksi
        $bulan = Tagihan::distinct()->selectRaw('MONTH(tanggal_tagihan) as bulan')->pluck('bulan');
        $tahun = Tagihan::distinct()->selectRaw('YEAR(tanggal_tagihan) as tahun')->pluck('tahun');

        // Jika ada filter berdasarkan bulan dan tahun
        $bulanSelected = $request->input('bulan');
        $tahunSelected = $request->input('tahun');

        // Inisialisasi query builder untuk transaksi pemasukan (debet) dan transaksi pengeluaran (kredit)
        $pemasukanQuery = Tagihan::where('status', 'lunas');
        $pengeluaranQuery = TransaksiPengeluaran::query();

        // Filter transaksi berdasarkan bulan dan tahun jika dipilih
        if ($bulanSelected && $tahunSelected) {
            $pemasukanQuery->whereMonth('tanggal_tagihan', $bulanSelected)
                ->whereYear('tanggal_tagihan', $tahunSelected);
            $pengeluaranQuery->whereMonth('tanggal', $bulanSelected)
                ->whereYear('tanggal', $tahunSelected);
        } else {
            // Jika bulan dan tahun tidak dipilih, set query builder kosong
            $pemasukanQuery->whereRaw('1=0'); // Ini akan membuat query kosong
            $pengeluaranQuery->whereRaw('1=0'); // Ini akan membuat query kosong
        }

        // Ambil hasil query builder jika bulan dan tahun sudah dipilih
        $pemasukan = $bulanSelected && $tahunSelected ? $pemasukanQuery->get() : collect();
        $pengeluaran = $bulanSelected && $tahunSelected ? $pengeluaranQuery->get() : collect();

        // Menghitung total debet (pemasukan) dan kredit (pengeluaran)
        $totalDebet = $pemasukan->sum('jumlah_tagihan');
        $totalKredit = $pengeluaran->sum('jumlah');

        // Menghitung saldo (debet - kredit)
        $saldo = $totalDebet - $totalKredit;

        // Mengirim data ke view neraca.blade.php
        return view('neraca.index', compact('pemasukan', 'pengeluaran', 'totalDebet', 'totalKredit', 'saldo', 'bulan', 'tahun', 'bulanSelected', 'tahunSelected'));
    }

    public function generatePdf(Request $request)
    {
        // Mendapatkan data sesuai filter bulan dan tahun
        $bulanSelected = $request->input('bulan');
        $tahunSelected = $request->input('tahun');

        // Inisialisasi query builder untuk transaksi pemasukan (debet) dan transaksi pengeluaran (kredit)
        $pemasukanQuery = Tagihan::where('status', 'lunas');
        $pengeluaranQuery = TransaksiPengeluaran::query();

        // Filter transaksi berdasarkan bulan dan tahun jika dipilih
        if ($bulanSelected && $tahunSelected) {
            $pemasukanQuery->whereMonth('tanggal_tagihan', $bulanSelected)
                ->whereYear('tanggal_tagihan', $tahunSelected);
            $pengeluaranQuery->whereMonth('tanggal', $bulanSelected)
                ->whereYear('tanggal', $tahunSelected);
        } else {
            // Jika bulan dan tahun tidak dipilih, set query builder kosong
            $pemasukanQuery->whereRaw('1=0'); // Ini akan membuat query kosong
            $pengeluaranQuery->whereRaw('1=0'); // Ini akan membuat query kosong
        }

        // Ambil hasil query builder jika bulan dan tahun sudah dipilih
        $pemasukan = $bulanSelected && $tahunSelected ? $pemasukanQuery->get() : collect();
        $pengeluaran = $bulanSelected && $tahunSelected ? $pengeluaranQuery->get() : collect();

        // Menghitung total debet (pemasukan) dan kredit (pengeluaran)
        $totalDebet = $pemasukan->sum('jumlah_tagihan');
        $totalKredit = $pengeluaran->sum('jumlah');

        // Menghitung saldo (debet - kredit)
        $saldo = $totalDebet - $totalKredit;

        // Mengambil nama bulan dalam bahasa Indonesia
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        // Membuat nama bulan dan tahun dalam bahasa Indonesia
        $bulanText = $bulanSelected && $tahunSelected ? $namaBulan[$bulanSelected] . ' ' . $tahunSelected : 'Semua Bulan';

        // Membuat PDF dari view Blade
        $pdf = PDF::loadView('neraca.pdf', compact('pemasukan', 'pengeluaran', 'totalDebet', 'totalKredit', 'saldo', 'bulanText', 'bulanSelected', 'tahunSelected'));

        // Mengatur nama file PDF yang akan dihasilkan
        $fileName = 'laporan_neraca_keuangan.pdf';

        // Menghasilkan dan mengirimkan laporan PDF ke browser
        return $pdf->download($fileName);
    }

}
