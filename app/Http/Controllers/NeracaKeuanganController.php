<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\TransaksiPengeluaran;
use App\Models\TransaksiPenjualan;
use Illuminate\Http\Request;
use PDF;

class NeracaKeuanganController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan daftar bulan dan tahun unik dari transaksi
        $bulan = Tagihan::distinct()
            ->selectRaw('MONTH(tanggal_bayar) as bulan')
            ->pluck('bulan');

        $tahun = Tagihan::distinct()
            ->selectRaw('YEAR(tanggal_bayar) as tahun')
            ->pluck('tahun');

        // $tahunMin pada tabel smua tabel ambil dari created_at
        $tahunMin = Tagihan::min('created_at');

        // ambil tahun dari $tahunMin
        $tahunMin = date('Y', strtotime($tahunMin));

        // $tahunMax pada tabel smua tabel ambil dari created_at
        $tahunMax = Tagihan::max('created_at');

        // ambil tahun dari $tahunMax
        $tahunMax = date('Y', strtotime($tahunMax));
        

        // Jika ada filter berdasarkan bulan dan tahun
        $bulanSelected = $request->input('bulan');
        $tahunSelected = $request->input('tahun');

        // Query builder untuk transaksi pemasukan (debet) dari Tagihan
        $pemasukanTagihan = Tagihan::where('status', 'lunas')
            ->whereMonth('tanggal_bayar', $bulanSelected)
            ->whereYear('tanggal_bayar', $tahunSelected)
            ->get();

        // Menambahkan sumber ke transaksi dari Tagihan
        $pemasukanTagihan->each(function ($item) {
            $item->sumber = 'Tagihan';
        });

        // Query builder untuk transaksi pemasukan (debet) dari TransaksiPenjualan
        $pemasukanPenjualan = TransaksiPenjualan::whereMonth('tanggal', $bulanSelected)
            ->whereYear('tanggal', $tahunSelected)
            ->get();

        // Menambahkan sumber ke transaksi dari TransaksiPenjualan
        $pemasukanPenjualan->each(function ($item) {
            $item->sumber = 'Penjualan';
        });

        // Filter transaksi pengeluaran berdasarkan bulan dan tahun jika dipilih
        $pengeluaran = TransaksiPengeluaran::whereMonth('tanggal', $bulanSelected)
            ->whereYear('tanggal', $tahunSelected)
            ->get();

        // Gabungkan data pemasukan dari kedua sumber
        $pemasukan = $pemasukanTagihan->concat($pemasukanPenjualan);

        // Menghitung total debet (pemasukan) dari Tagihan
        $totalDebetTagihan = $pemasukanTagihan->sum('jumlah_tagihan');

        // Menghitung total debet (pemasukan) dari TransaksiPenjualan
        $totalDebetPenjualan = $pemasukanPenjualan->sum('total_harga');

        // Menghitung total debet (pemasukan) dan kredit (pengeluaran)
        $totalDebet = $totalDebetTagihan + $totalDebetPenjualan;
        $totalKredit = $pengeluaran->sum('jumlah');

        // Menghitung saldo (debet - kredit)
        $saldo = $totalDebet - $totalKredit;

        // Mengirim data ke view neraca.blade.php
        return view('neraca.index', compact('pemasukan', 'pengeluaran', 'totalDebet', 'totalKredit', 'saldo', 'bulan', 'tahun', 'bulanSelected', 'tahunSelected', 'tahunMin', 'tahunMax'));
    }



    public function generatePdf(Request $request)
    {
        // Mendapatkan daftar bulan dan tahun unik dari transaksi
        $bulan = Tagihan::distinct()
            ->selectRaw('MONTH(tanggal_bayar) as bulan')
            ->pluck('bulan');

        $tahun = Tagihan::distinct()
            ->selectRaw('YEAR(tanggal_bayar) as tahun')
            ->pluck('tahun');

        // Jika ada filter berdasarkan bulan dan tahun
        $bulanSelected = $request->input('bulan');
        $tahunSelected = $request->input('tahun');

        // Query builder untuk transaksi pemasukan (debet) dari Tagihan
        $pemasukanTagihan = Tagihan::where('status', 'lunas')
            ->whereMonth('tanggal_bayar', $bulanSelected)
            ->whereYear('tanggal_bayar', $tahunSelected)
            ->get();

        // Menambahkan sumber ke transaksi dari Tagihan
        $pemasukanTagihan->each(function ($item) {
            $item->sumber = 'Tagihan';
        });

        // Query builder untuk transaksi pemasukan (debet) dari TransaksiPenjualan
        $pemasukanPenjualan = TransaksiPenjualan::whereMonth('tanggal', $bulanSelected)
            ->whereYear('tanggal', $tahunSelected)
            ->get();

        // Menambahkan sumber ke transaksi dari TransaksiPenjualan
        $pemasukanPenjualan->each(function ($item) {
            $item->sumber = 'Penjualan';
        });

        // Filter transaksi pengeluaran berdasarkan bulan dan tahun jika dipilih
        $pengeluaran = TransaksiPengeluaran::whereMonth('tanggal', $bulanSelected)
            ->whereYear('tanggal', $tahunSelected)
            ->get();

        // Gabungkan data pemasukan dari kedua sumber
        $pemasukan = $pemasukanTagihan->concat($pemasukanPenjualan);

        // Menghitung total debet (pemasukan) dari Tagihan
        $totalDebetTagihan = $pemasukanTagihan->sum('jumlah_tagihan');

        // Menghitung total debet (pemasukan) dari TransaksiPenjualan
        $totalDebetPenjualan = $pemasukanPenjualan->sum('total_harga');

        // Menghitung total debet (pemasukan) dan kredit (pengeluaran)
        $totalDebet = $totalDebetTagihan + $totalDebetPenjualan;
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

        // return view('neraca.pdf', compact('pemasukan', 'pengeluaran', 'totalDebet', 'totalKredit', 'saldo', 'bulanText', 'bulanSelected', 'tahunSelected'));

        // Membuat PDF dari view Blade
        $pdf = PDF::loadView('neraca.pdf', compact('pemasukan', 'pengeluaran', 'totalDebet', 'totalKredit', 'saldo', 'bulanText', 'bulanSelected', 'tahunSelected'));

        // Mengatur nama file PDF yang akan dihasilkan
        $fileName = 'laporan_neraca_keuangan.pdf';

        // Menghasilkan dan mengirimkan laporan PDF ke browser
        return $pdf->download($fileName);
    }

}
