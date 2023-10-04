<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTagihanExport;
use App\Models\JenisSampah;
use App\Models\KategoriLayanan;
use App\Models\Tagihan;
use App\Models\TransaksiBank;
use App\Models\TransaksiPenarikan;
use App\Models\TransaksiPenjualan;
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

        // ambil tahun nya saja minimal yang ada di tabel tagihan
        $tahunTagihanMin = Tagihan::min('tanggal_tagihan');

        // ambil nilai tahunnya saja pada tahunMin
        $tahunTagihanMin = date('Y', strtotime($tahunTagihanMin));

        // ambil tahun nya saja maksimal yang ada di tabel tagihan
        $tahunTagihanMax = Tagihan::max('tanggal_tagihan');

        // ambil nilai tahunnya saja pada tahunMax
        $tahunTagihanMax = date('Y', strtotime($tahunTagihanMax));

        // abmil tahun min pada tabel transaksi bank
        $tahunBankMin = TransaksiBank::min('created_at');

        // ambil nilai tahunnya saja pada tahunBankMin
        $tahunBankMin = date('Y', strtotime($tahunBankMin));

        // ambil tahun max pada tabel transaksi bank
        $tahunBankMax = TransaksiBank::max('created_at');

        // ambil nilai tahunnya saja pada tahunBankMax
        $tahunBankMax = date('Y', strtotime($tahunBankMax));

        $data = 
            [
                'tahunTagihanMin' => $tahunTagihanMin,
                'tahunTagihanMax' => $tahunTagihanMax,  
                'tahunBankMin' => $tahunBankMin,
                'tahunBankMax' => $tahunBankMax,              
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
        $query = Tagihan::query()->with('nasabah.kategoriLayanan');

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

        // dd($models);

        // Cetak Excel dengan nama file 'laporan-tagihan.xlsx' dan kirim data yang sudah diambil sebelumnya
        return Excel::download(new LaporanTagihanExport($models), 'laporan-tagihan.xlsx');
  
    }
    
    // function laporan bank berdasarkan request dari index
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

    // function cetak pdf transaksi bank
    public function cetakPdfTransaksiBank (Request $request){
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
            'title' => 'Laporan Bank',
            'model' => $data,
            'jenisSampah' => $jenisSampah,
        ];

        // return view('laporan.laporan-bank-pdf', $models);

        // Cetak PDF dengan nama file 'laporan-bank.pdf' dan kirim data yang sudah diambil sebelumnya
        $pdf = \PDF::loadView('laporan.laporan-bank-pdf', $models);
        return $pdf->download('laporan-bank.pdf');
    }

    // function laporan transaksi penjualan berdasarkan request dari index
    public function transaksiPenjualan(Request $request)
    {
        // Ambil data dari model Transaksi Bank berdasarkan kriteria yang diberikan dalam request
        $query = TransaksiPenjualan::query();

        // Filter berdasarkan bulan jika bulan tidak kosong ambil dari kolom created_at
        if ($request->has('bulan') && !empty($request->bulan)) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter berdasarkan tahun jika tahun tidak kosong ambil dari kolom created_at
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $jenisSampah = null;

        // Filter berdasarkan jenis sampah jika jenis sampah tidak kosong
        if ($request->has('jenis_sampah_id') && !empty($request->jenis_sampah_id)) {
            $query->whereHas('detailTransaksiPenjualans', function ($q) use ($request, &$jenisSampah) {
                $q->where('jenis_sampah_id', $request->jenis_sampah_id);
                $jenisSampah = JenisSampah::find($request->jenis_sampah_id); // Ambil data jenis sampah
            });
        }

        // eksekusi query dan ambil hasilnya
        $data = $query->get();

        // Kirim data ke view dengan nama variabel yang benar
        $models = [
            'routePrefix' => $this->routePrefix,
            'title' => 'Laporan Tagihan',
            'model' => $data,
            'jenisSampah' => $jenisSampah,
        ];

        return view('laporan.laporan-penjualan', $models);

    }

    // function cetak pdf transaksi penjualan
    public function cetakPdfTransaksiPenjualan(Request $request){
        // Ambil data dari model Transaksi Bank berdasarkan kriteria yang diberikan dalam request
        $query = TransaksiPenjualan::query();

        // Filter berdasarkan bulan jika bulan tidak kosong ambil dari kolom created_at
        if ($request->has('bulan') && !empty($request->bulan)) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter berdasarkan tahun jika tahun tidak kosong ambil dari kolom created_at
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $jenisSampah = null;

        // Filter berdasarkan jenis sampah jika jenis sampah tidak kosong
        if ($request->has('jenis_sampah_id') && !empty($request->jenis_sampah_id)) {
            $query->whereHas('detailTransaksiPenjualans', function ($q) use ($request, &$jenisSampah) {
                $q->where('jenis_sampah_id', $request->jenis_sampah_id);
                $jenisSampah = JenisSampah::find($request->jenis_sampah_id); // Ambil data jenis sampah
            });
        }

        // eksekusi query dan ambil hasilnya
        $data = $query->get();

        // Kirim data ke view dengan nama variabel yang benar
        $models = [
            'routePrefix' => $this->routePrefix,
            'title' => 'Laporan Tagihan',
            'model' => $data,
            'jenisSampah' => $jenisSampah,
        ];

        // return view('laporan.laporan-penjualan-pdf', $models);

        // Cetak PDF dengan nama file 'laporan-penjualan.pdf' dan kirim data yang sudah diambil sebelumnya
        $pdf = \PDF::loadView('laporan.laporan-penjualan-pdf', $models);
        return $pdf->download('laporan-penjualan.pdf');
    }

    // function transaksi penarikan berdasarkan request dari index
    public function transaksiPenarikan(Request $request)
    {
        // Ambil data dari model Transaksi Bank berdasarkan kriteria yang diberikan dalam request
        $query = TransaksiPenarikan::query();

        // Filter berdasarkan bulan jika bulan tidak kosong ambil dari kolom created_at
        if ($request->has('bulan') && !empty($request->bulan)) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter berdasarkan tahun jika tahun tidak kosong ambil dari kolom created_at
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->whereYear('created_at', $request->tahun);
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
        ];

        return view('laporan.laporan-penarikan', $models);
    }
}
