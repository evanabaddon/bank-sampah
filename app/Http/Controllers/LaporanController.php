<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\KategoriLayanan;
use App\Models\Tagihan;
use App\Models\TransaksiBank;
use Barryvdh\Reflection\DocBlock\Tag;
use Illuminate\Http\Request;
use Excel;

class LaporanController extends Controller
{
    private $viewIndex = 'index';
    private $viewCreate = 'form';
    private $viewEdit = 'form';
    private $viewShow = 'show';
    private $routePrefix = 'laporan';
    public function index()
    {
        // Ambil semua data kategori layanan
        $kategoriLayanans = KategoriLayanan::all();
        // Ambil semua data jenis sampah
        $jenisSampahs = JenisSampah::all();

        $data = 
            [
                'kategoriLayanans' => $kategoriLayanans,
                'jenisSampahs' => $jenisSampahs,
                'routePrefix' => $this->routePrefix,
                'title' => 'Laporan'
            ];
        
        return view('laporan.index', $data);
    }

    // function laporan tagihan berdasarkan request dari index
    public function tagihan(Request $request)
    {
        // Ambil data dari model Tagihan berdasarkan kriteria yang diberikan dalam request
        $query = Tagihan::query();

        // Filter berdasarkan status jika status tidak kosong
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan bulan jika bulan tidak kosong
        if ($request->has('bulan') && !empty($request->bulan)) {
            $query->whereMonth('tanggal_tagihan', $request->bulan);
        }

        // Filter berdasarkan tahun jika tahun tidak kosong
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->whereYear('tanggal_tagihan', $request->tahun);
        }

        // Filter berdasarkan kategori layanan jika kategori layanan tidak kosong
        if ($request->has('kategori_layanan_id') && !empty($request->kategori_layanan_id)) {
            $query->whereHas('nasabah', function ($q) use ($request) {
                $q->where('kategori_layanan_id', $request->kategori_layanan_id);
            });
        }

        // Eksekusi query dan ambil hasilnya
        $data = $query->get();

        // Ambil kategori layanan berdasarkan 'kategori_layanan_id' dari query parameter
        $kategoriLayanan = KategoriLayanan::find($request->kategori_layanan_id);


        // Ubah format tanggal tagihan dan tanggal jatuh tempo menjadi format Indonesia menggunakan Carbon
        foreach ($data as $model) {
            $model->tanggal_tagihan = \Carbon\Carbon::parse($model->tanggal_tagihan)->translatedFormat('d F Y');
            $model->tanggal_jatuh_tempo = \Carbon\Carbon::parse($model->tanggal_jatuh_tempo)->translatedFormat('d F Y');
        }

        // Kirim data ke view dengan nama variabel yang benar
        $models = [
            'routePrefix' => $this->routePrefix,
            'title' => 'Laporan Tagihan',
            'kategoriLayanan' => $kategoriLayanan,
            'model' => $data, // Ganti 'data' menjadi 'model'
        ];

        return view('laporan.laporan-tagihan', $models);
    }

    // function cetak pdf tagihan
    public function cetakPdfTagihan(Request $request)
    {
        // Ambil data dari model Tagihan berdasarkan kriteria yang diberikan dalam request
        $query = Tagihan::query();

        // Filter berdasarkan status jika status tidak kosong
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan bulan jika bulan tidak kosong
        if ($request->has('bulan') && !empty($request->bulan)) {
            $query->whereMonth('tanggal_tagihan', $request->bulan);
        }

        // Filter berdasarkan tahun jika tahun tidak kosong
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->whereYear('tanggal_tagihan', $request->tahun);
        }

        // Filter berdasarkan kategori layanan jika kategori layanan tidak kosong
        if ($request->has('kategori_layanan_id') && !empty($request->kategori_layanan_id)) {
            $query->whereHas('nasabah', function ($q) use ($request) {
                $q->where('kategori_layanan_id', $request->kategori_layanan_id);
            });
        }

        // Eksekusi query dan ambil hasilnya
        $data = $query->get();

        // Ambil kategori layanan berdasarkan 'kategori_layanan_id' dari query parameter
        $kategoriLayanan = KategoriLayanan::find($request->kategori_layanan_id);


        // Ubah format tanggal tagihan dan tanggal jatuh tempo menjadi format Indonesia menggunakan Carbon
        foreach ($data as $model) {
            $model->tanggal_tagihan = \Carbon\Carbon::parse($model->tanggal_tagihan)->translatedFormat('d F Y');
            $model->tanggal_jatuh_tempo = \Carbon\Carbon::parse($model->tanggal_jatuh_tempo)->translatedFormat('d F Y');
        }

        // Kirim data ke view dengan nama variabel yang benar
        $models = [
            'routePrefix' => $this->routePrefix,
            'title' => 'Laporan Tagihan',
            'kategoriLayanan' => $kategoriLayanan,
            'model' => $data, // Ganti 'data' menjadi 'model'
        ];

        // Cetak PDF dengan nama file 'laporan-tagihan.pdf' dan kirim data yang sudah diambil sebelumnya
        $pdf = \PDF::loadView('laporan.laporan-tagihan-pdf', $models);
        return $pdf->download('laporan-tagihan.pdf');
    }

    // function cetak excel tagihan
    public function cetakExcelTagihan(Request $request)
    {
        // Ambil data dari model Tagihan berdasarkan kriteria yang diberikan dalam request
        $query = Tagihan::query();

        // Filter berdasarkan status jika status tidak kosong
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan bulan jika bulan tidak kosong
        if ($request->has('bulan') && !empty($request->bulan)) {
            $query->whereMonth('tanggal_tagihan', $request->bulan);
        }

        // Filter berdasarkan tahun jika tahun tidak kosong
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->whereYear('tanggal_tagihan', $request->tahun);
        }

        // Filter berdasarkan kategori layanan jika kategori layanan tidak kosong
        if ($request->has('kategori_layanan_id') && !empty($request->kategori_layanan_id)) {
            $query->whereHas('nasabah', function ($q) use ($request) {
                $q->where('kategori_layanan_id', $request->kategori_layanan_id);
            });
        }

        // Eksekusi query dan ambil hasilnya
        $data = $query->get();

        // Ambil kategori layanan berdasarkan 'kategori_layanan_id' dari query parameter
        $kategoriLayanan = KategoriLayanan::find($request->kategori_layanan_id);

         // Ubah format tanggal tagihan dan tanggal jatuh tempo menjadi format Indonesia menggunakan Carbon
         foreach ($data as $model) {
            $model->tanggal_tagihan = \Carbon\Carbon::parse($model->tanggal_tagihan)->translatedFormat('d F Y');
            $model->tanggal_jatuh_tempo = \Carbon\Carbon::parse($model->tanggal_jatuh_tempo)->translatedFormat('d F Y');
        }

        // Kirim data ke view dengan nama variabel yang benar
        $models = [
            'routePrefix' => $this->routePrefix,
            'title' => 'Laporan Tagihan',
            'kategoriLayanan' => $kategoriLayanan,
            'model' => $data, // Ganti 'data' menjadi 'model'
        ];

        // Cetak Excel dengan nama file 'laporan-tagihan.xlsx' dan kirim data yang sudah diambil sebelumnya
        // return Excel::download(new \App\Exports\LaporanTagihanExport($models), 'laporan-tagihan.xlsx');
    }
    
    public  function transaksiBank(Request $request){
        // Ambil data dari model Transaksi Bank berdasarkan kriteria yang diberikan dalam request
        $query = TransaksiBank::query();

        // Filter berdasarkan bulan jika bulan tidak kosong ambil dari kolom created_at
        if ($request->has('bulan') && !empty($request->bulan)) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter berdasarkan tahun jika tahun tidak kosong ambil dari kolom created_at
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->whereYear('created_at', $request->tahun);
        }

        $jenisSampah = null;

        // Filter berdasarkan jenis sampah jika jenis sampah tidak kosong
        if ($request->has('jenis_sampah_id') && !empty($request->jenis_sampah_id)) {
            $query->whereHas('detailTransaksiBank', function ($q) use ($request, &$jenisSampah) {
                $q->where('id_jenis_sampah', $request->jenis_sampah_id);
                $jenisSampah = JenisSampah::find($request->jenis_sampah_id); // Ambil data jenis sampah
            });
        }


        // Filter berdasarkan nama jikan tabel transaksi bank berelasikan dengan tabel nasabah dengan menggunakan id nasabah
        if ($request->has('nama') && !empty($request->nama)) {
            $query->whereHas('nasabah', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->nama . '%');
            });
        }
        // Ekseskusi query dan ambil hasilnya
        $data = $query->get();

        // Kirim data ke view dengan nama variabel yang benar
        $models = [
            'routePrefix' => $this->routePrefix,
            'title' => 'Laporan Tagihan',
            'model' => $data,
            'jenisSampah' => $jenisSampah,
        ];

        return view('laporan.laporan-bank', $models);
    }

    
}
