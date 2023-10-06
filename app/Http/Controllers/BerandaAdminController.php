<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Tagihan;
use App\Models\TransaksiBank;
use App\Models\TransaksiPengeluaran;
use App\Models\TransaksiPenjualan;
use DateTime;
use DB;

class BerandaAdminController extends Controller
{
    public function index()
    {
        // hitung jumlah nasabah
        $jumlahNasabah = Nasabah::count();

        // hitung total tagihan belum lunas bulan ini dengan format rupiah
        $totalTagihanBulanIni = Tagihan::where('status', 'belum')->whereMonth('tanggal_jatuh_tempo', date('m'))->sum('jumlah_tagihan');
        
        // hitung total tagihan lunas bulan ini
        $totalTagihanLunasBulanIni = Tagihan::where('status', 'lunas')->whereMonth('tanggal_jatuh_tempo', date('m'))->sum('jumlah_tagihan');
        
        // tampilkan 10 nasabah terakhir
        $nasabahTerakhir = Nasabah::orderBy('created_at', 'desc')->limit(10)->get();

        // Buat array bulan pada tahun ini dengan bahasa Indonesia, sperti januari, februari, maret, dst
        $dataBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataBulan[] = date('F', mktime(0, 0, 0, $i, 1));
        }
        
        $namaBulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ]; 
        
        // hitung transaksi bank bulan ini
        $totalTransaksiBankBulanIni = TransaksiBank::whereMonth('created_at', date('m'))->sum('total_harga');

        // hitung transaksi tagihan lunas bulan ini
        $totalTagihanLunasBulanIni = Tagihan::where('status', 'lunas')->whereMonth('tanggal_bayar', date('m'))->sum('jumlah_tagihan');

        // hitung transaksi tagihan belum lunas bulan ini
        $totalTagihanBelumLunasBulanIni = Tagihan::where('status', 'belum')->whereMonth('tanggal_jatuh_tempo', date('m'))->sum('jumlah_tagihan');

        // buat array data transaksi tagihan lunas tiap bulan
        $dataTagihanLunas = [];
        foreach($dataBulan as $bulan){
            $dataTagihanLunas[] = Tagihan::where('status', 'lunas')->whereMonth('tanggal_bayar', date('m', strtotime($bulan)))->sum('jumlah_tagihan');
        }

        // buat array data transaksi tagihan belum lunas tiap bulan
        $dataTagihanBelumLunas = [];
        foreach($dataBulan as $bulan){
            $dataTagihanBelumLunas[] = Tagihan::where('status', 'belum')->whereMonth('tanggal_jatuh_tempo', date('m', strtotime($bulan)))->sum('jumlah_tagihan');
        }

        // buat array data transaksi bank tiap bulan
        $dataTransaksiBSP = [];
        foreach($dataBulan as $bulan){
            $dataTransaksiBSP[] = TransaksiBank::whereMonth('created_at', date('m', strtotime($bulan)))->sum('total_harga');
        }

        // semua transaksi pemasukan bulan ini
        // hitung transaksi penjualan bulan ini
        $totalPenjualanBulanIni = TransaksiPenjualan::whereMonth('tanggal', date('m'))->sum('total_harga');

        // pemasukan bulan ini
        $pemasukanBulanIni = $totalPenjualanBulanIni + $totalTagihanLunasBulanIni;

        // semua transaksi pengeluaran bulan ini
        // hitung transaksi pengeluaraan bulan ini
        $totalPengeluaranBulanIni = TransaksiPengeluaran::whereMonth('tanggal', date('m'))->sum('jumlah');

        // total transaksi bank bulan kemarin
        $totalTransaksiBankKemarin = TransaksiBank::whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->sum('total_harga');

        // pengeluaran bulan ini
        $pengeluaranBulanIni = $totalPengeluaranBulanIni + $totalTransaksiBankBulanIni;

        // laba / rugi bulan ini
        $labaRugiBulanIni = $pemasukanBulanIni - $pengeluaranBulanIni;


        $tanggalKemarin = now()->subMonth();
        // semua transaksi pemasukan bulan kemarin
        // total transaksi tagihan lunas bulan kemarin
        $totalTagihanLunasKemarin = Tagihan::where('status', 'lunas')->whereYear('tanggal_bayar', $tanggalKemarin->year)->whereMonth('tanggal_bayar', $tanggalKemarin->month)->sum('jumlah_tagihan');

        // total penjualan bulan kemarin
        $totalPenjualanBulanKemarin = TransaksiPenjualan::whereYear('tanggal', $tanggalKemarin->year)->whereMonth('tanggal', $tanggalKemarin->month)->sum('total_harga');

        // semua transaksi pengeluaran bulan kemarin
        // total transaksi pengeluaraan bulan kemarin
        $totalPengeluaranBulanKemarin = TransaksiPengeluaran::whereYear('tanggal', $tanggalKemarin->year)->whereMonth('tanggal', $tanggalKemarin->month)->sum('jumlah');

        // total transaksi bank bulan kemarin
        $totalTransaksiBankKemarin = TransaksiBank::whereYear('created_at', $tanggalKemarin->year)->whereMonth('created_at', $tanggalKemarin->month)->sum('total_harga');

        // pemasaukan bulan kemarin
        $pemasukanBulanKemarin = $totalPenjualanBulanKemarin + $totalTagihanLunasKemarin;
        
        // pengeluaran bulan kemarin
        $pengeluaranBulanKemarin = $totalPengeluaranBulanKemarin + $totalTransaksiBankKemarin;

        // laba / rugi bulan kemarin
        $labaRugiBulanKemarin = $pemasukanBulanKemarin - $pengeluaranBulanKemarin;

        // prosentase kenaikan / penurunan pemasukan bulan ini dibandingkan bulan kemarin
        if ($pemasukanBulanKemarin != 0) {
            $prosentasePemasukan = ($pemasukanBulanIni - $pemasukanBulanKemarin) / $pemasukanBulanKemarin * 100;
            // batasi angka dibelakang koma menjadi 2 angka
            $prosentasePemasukan = number_format($prosentasePemasukan, 2);
        } else {
            // Handle the case where $pemasukanBulanKemarin is zero, e.g., set $prosentasePemasukan to a default value or show an error message.
            $prosentasePemasukan = 100; // Set a default value or handle it accordingly
        }

        // prosentase kenaikan / penurunan pengeluaran bulan ini dibandingkan bulan kemarin
        if ($pengeluaranBulanKemarin != 0) {
            $prosentasePengeluaran = ($pengeluaranBulanIni - $pengeluaranBulanKemarin) / $pengeluaranBulanKemarin * 100;
            // batasi angka dibelakang koma menjadi 2 angka
            $prosentasePengeluaran = number_format($prosentasePengeluaran, 2);
        } else {
            // Handle the case where $pemasukanBulanKemarin is zero, e.g., set $prosentasePemasukan to a default value or show an error message.
            $prosentasePengeluaran = 100; // Set a default value or handle it accordingly
        }

        // prosentase kenaikan / penurunan laba / rugi bulan ini dibandingkan bulan kemarin
        if ($labaRugiBulanKemarin != 0) {
            $prosentaseLabaRugi = ($labaRugiBulanIni - $labaRugiBulanKemarin) / $labaRugiBulanKemarin * 100;
            // batasi angka dibelakang koma menjadi 2 angka
            $prosentaseLabaRugi = number_format($prosentaseLabaRugi, 2);
        } else {
            // Handle the case where $labaRugiBulanKemarin is zero, e.g., set $prosentaseLabaRugi to a default value or show an error message.
            $prosentaseLabaRugi = 100; // Set a default value or handle it accordingly
        }

        // Buat array data pemasukan pada tahun ini yang diambl dari data Tagihan yang lunas dan Transaksi Penjualan
        $dataPemasukan = [];
        foreach ($dataBulan as $bulan) {
            $dataPemasukan[] = Tagihan::where('status', 'lunas')->whereMonth('tanggal_bayar', date('m', strtotime($bulan)))->sum('jumlah_tagihan') + TransaksiPenjualan::whereMonth('tanggal', date('m', strtotime($bulan)))->sum('total_harga');
        }

        // Buat array data pengeluaran pada tahun ini yang diambl dari data Transaksi Bank dan Transaksi Pengeluaran
        $dataPengeluaran = [];
        foreach ($dataBulan as $bulan) {
            $dataPengeluaran[] = TransaksiBank::whereMonth('created_at', date('m', strtotime($bulan)))->sum('total_harga') + TransaksiPengeluaran::whereMonth('tanggal', date('m', strtotime($bulan)))->sum('jumlah');
        }

        return view('admin.beranda_index', compact(
            'jumlahNasabah',
            'totalTagihanBulanIni',
            'totalTagihanLunasBulanIni',
            'totalTransaksiBankBulanIni',
            'totalTagihanBelumLunasBulanIni',
            'dataTagihanLunas',
            'dataTagihanBelumLunas',
            'dataTransaksiBSP', 
            'nasabahTerakhir',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'labaRugiBulanIni',
            'prosentasePemasukan',
            'prosentasePengeluaran',
            'prosentaseLabaRugi',
            'dataPemasukan',
            'dataPengeluaran',
        ));
    }
}
