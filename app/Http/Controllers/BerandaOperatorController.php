<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Tagihan;
use App\Models\TransaksiBank;
use App\Traits\HasFormatRupiah;
use DB;
use Illuminate\Http\Request;

class BerandaOperatorController extends Controller
{
    use HasFormatRupiah;

    public function index()
    {
        // hitung jumlah nasabah
        $jumlahNasabah = Nasabah::count();
        // hitung total tagihan belum lunas bulan ini dengan format rupiah
        $totalTagihanBulanIni = Tagihan::where('status', 'belum')->whereMonth('tanggal_jatuh_tempo', date('m'))->sum('jumlah_tagihan');
        
        // hitung total tagihan lunas bulan ini
        $totalTagihanLunasBulanIni = Tagihan::where('status', 'lunas')->whereMonth('tanggal_jatuh_tempo', date('m'))->sum('jumlah_tagihan');
        
        // hitung total transaksi bank bulan ini
        $totalTransaksiBankBulanIni = TransaksiBank::whereMonth('created_at', date('m'))->sum('total_harga');
        
        // tampilkan 10 nasabah terakhir
        $nasabahTerakhir = Nasabah::orderBy('created_at', 'desc')->limit(10)->get();

        $dataTransaksi = Tagihan::select(
            DB::raw("DATE_FORMAT(tanggal_jatuh_tempo, '%M %Y') as bulan_tahun"),
            DB::raw("COUNT(*) as jumlah_transaksi"),
            DB::raw("SUM(CASE WHEN status = 'lunas' THEN jumlah_tagihan ELSE 0 END) as total_tagihan_lunas"),
            DB::raw("SUM(CASE WHEN status = 'belum' THEN jumlah_tagihan ELSE 0 END) as total_tagihan_belum_lunas")
        )
        ->whereYear('tanggal_jatuh_tempo', date('Y')) // Filter data untuk satu tahun
        ->groupBy('bulan_tahun')
        ->orderBy('bulan_tahun')
        ->get();

        $dataTransaksiBSP = TransaksiBank::select(
            DB::raw("DATE_FORMAT(created_at, '%M %Y') as bulan_tahun"),
            DB::raw("SUM(total_harga) as total_transaksi_bsp")
        )
        ->whereYear('created_at', 2023) // Filter data untuk tahun 2023
        ->groupBy('bulan_tahun')
        ->orderByRaw('MIN(created_at) ASC') // Urutkan berdasarkan tanggal minimum dalam setiap grup
        ->get();

        return view('operator.beranda_index', compact('jumlahNasabah', 'totalTagihanBulanIni', 'totalTagihanLunasBulanIni', 'totalTransaksiBankBulanIni', 'dataTransaksi', 'dataTransaksiBSP', 'nasabahTerakhir'));
    }
}
