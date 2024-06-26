<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Jobs\SendWhatsAppMessage;
use App\Models\KategoriLayanan;
use App\Models\Nasabah;
use App\Models\Saldo;
use App\Models\Tagihan;
use App\Traits\WhatsAppApi;
use Auth;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    use WhatsAppApi;

    private $viewIndex = 'index';
    private $viewCreate = 'form';
    private $viewEdit = 'form';
    private $viewShow = 'detail';
    private $routePrefix = 'tagihan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Mendapatkan daftar bulan dan tahun unik dari transaksi
        $bulan = Model::distinct()
            ->selectRaw('MONTH(tanggal_bayar) as bulan')
            ->pluck('bulan');

        $tahun = Model::distinct()
            ->selectRaw('YEAR(tanggal_bayar) as tahun')
            ->pluck('tahun');

        // kategori layanan pluck name and id
        $kategoriLayanan = KategoriLayanan::pluck('name', 'id');

        // $tahunMin pada tabel smua tabel ambil dari created_at
        $tahunMin = Model::min('created_at');

        // ambil tahun dari $tahunMin
        $tahunMin = date('Y', strtotime($tahunMin));

        // $tahunMax pada tabel smua tabel ambil dari created_at
        $tahunMax = Model::max('created_at');

        // ambil tahun dari $tahunMax
        $tahunMax = date('Y', strtotime($tahunMax));

        // Mendapatkan pengguna yang saat ini login
        $currentUser = Auth::user();

        // Query builder untuk mengambil data tagihan berdasarkan user_id
        $tagihanQuery = Model::with('nasabah.kategoriLayanan')->latest();

        // Tambahkan orderBy ke query builder untuk mengurutkan berdasarkan tanggal tagihan
        $tagihanQuery->orderBy('tanggal_tagihan', 'asc');

        // ambil data RT dari nasabah
        $rt = $tagihanQuery->get()->pluck('nasabah.rt')->unique();

        // ambil data RT dari nasabah
        $rw = $tagihanQuery->get()->pluck('nasabah.rw')->unique();

        // Menyimpan filter dalam variabel
        $filters = $request->only(['bulan', 'tahun', 'status', 'kategori_layanan_id', 'q', 'rt', 'rw']);

        // Jika pengguna adalah admin, maka tampilkan semua data
        if ($currentUser->akses == 'admin') {
            foreach ($filters as $key => $value) {
                if ($key === 'bulan' && !empty($value)) {
                    $tagihanQuery->whereMonth('tanggal_tagihan', $value);
                }
                if ($key === 'tahun' && !empty($value)) {
                    $tagihanQuery->whereYear('tanggal_tagihan', $value);
                }
                if ($key === 'status' && !empty($value)) {
                    $tagihanQuery->where('status', $value);
                }
                if ($key === 'kategori_layanan_id' && !empty($value)) {
                    $tagihanQuery->whereHas('nasabah', function ($query) use ($value) {
                        $query->where('kategori_layanan_id', $value);
                    });
                }
                if ($key === 'q' && !empty($value)) {
                    $tagihanQuery->whereHas('nasabah', function ($query) use ($value) {
                        $query->where('name', 'like', '%' . $value . '%');
                    });
                }
                if ($key === 'rt' && !empty($value)) {
                    $tagihanQuery->whereHas('nasabah', function ($query) use ($value) {
                        $query->where('rt', $value);
                    });
                }
                if ($key === 'rw' && !empty($value)) {
                    $tagihanQuery->whereHas('nasabah', function ($query) use ($value) {
                        $query->where('rw', $value);
                    });
                }
            }

            $models = $tagihanQuery->paginate(50)->appends($filters);
        } else {
            // Jika bukan admin, filter data dengan status lunas dan user_id
            $models = $tagihanQuery->where(function ($query) use ($currentUser) {
                $query->where('status', 'lunas')->where('user_id', $currentUser->id);
            })->paginate(50)->appends($filters);
        }

        // Ubah format tanggal tagihan dan tanggal jatuh tempo menjadi format Indonesia menggunakan Carbon
        foreach ($models as $model) {
            $model->tanggal_tagihan = Carbon::parse($model->tanggal_tagihan)->translatedFormat('d F Y');
            $model->tanggal_jatuh_tempo = Carbon::parse($model->tanggal_jatuh_tempo)->translatedFormat('d F Y');
            $model->tanggal_bayar = Carbon::parse($model->tanggal_bayar)->translatedFormat('d F Y');
        }

        $data = [
            'models' => $models,
            'bulan' => $bulan,
            'tahunMin' => $tahunMin,
            'tahunMax' => $tahunMax,
            'tahun' => $tahun,
            'rt' => $rt,
            'rw' => $rw,
            'kategoriLayanan' => $kategoriLayanan,
            'routePrefix' => $this->routePrefix,
            'title' => 'Tagihan'
        ];

        return view('tagihan.' . $this->viewIndex, $data);
    }


    // buat tagihan untuk semua nasabah yang sudah terdaftar selama 1 tahun
    public function buatTagihan()
    {
        // Ambil semua nasabah yang sudah terdaftar
        $nasabahs = Nasabah::where('is_ppc', 1)->get();

        // Ambil tahun sekarang
        $currentYear = now()->year;

        // Mulai dari bulan pertama (Januari)
        $startMonth = 1;

        // Sampai dengan bulan kedua belas (Desember)
        $endMonth = 12;

        // Looping untuk setiap nasabah
        foreach ($nasabahs as $nasabah) {
            // Ambil kategori layanan dari nasabah
            $kategoriLayanan = $nasabah->kategoriLayanan;

            // Looping untuk setiap bulan
            for ($month = $startMonth; $month <= $endMonth; $month++) {
                // Buat tanggal tagihan 2023-01-01
                $tanggalTagihan = $currentYear . '-' . $month . '-' . '01';

                // Buat tanggal jatuh tempo 2023-01-25
                $tanggalJatuhTempo = $currentYear . '-' . $month . '-' . '27';

                // parameter tanggal tagihan
                $cekTagihan = now()->setYear($currentYear)->setMonth($month)->setDay(01);

                // Cek apakah tagihan sudah ada
                $existingBill = Model::where('nasabah_id', $nasabah->id)
                    ->whereMonth('tanggal_tagihan', $cekTagihan->month)
                    ->whereYear('tanggal_tagihan', $currentYear)
                    ->first();

                // Jika belum ada, buat tagihan baru
                if (!$existingBill) {
                    // Hitung jumlah tagihan berdasarkan harga kategori layanan
                    $jumlahTagihan = $kategoriLayanan->harga;

                    // Buat record tagihan baru
                    Model::create([
                        'nasabah_id' => $nasabah->id,
                        'tanggal_tagihan' => $tanggalTagihan,
                        'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                        'jumlah_tagihan' => $jumlahTagihan,
                        'status' => 'belum',
                        'keterangan' => 'Tagihan bulan ' . $tanggalTagihan
                    ]);
                }
            }
        }

        return redirect()->route('tagihan.index')->with('success', 'Selesai membuat tagihan untuk seluruh bulan pada tahun yang berjalan.');
    }

    // fungsu buat tagihan untuk semua nasabah pada bulan ini
    public function buatTagihanBulanIni()
    {
        // Ambil semua nasabah yang sudah terdaftar
        $nasabahs = Nasabah::where('is_ppc', 1)->get();

        // Ambil tahun sekarang
        $currentYear = now()->year;

        // Ambil bulan sekarang
        $currentMonth = 2;


        // Looping untuk setiap nasabah
        foreach ($nasabahs as $nasabah) {
            // Ambil kategori layanan dari nasabah
            $kategoriLayanan = $nasabah->kategoriLayanan;

            // Buat tanggal tagihan
            $tanggalTagihan = $currentYear . '-' . $currentMonth . '-' . '01';


            // Cek apakah tagihan sudah ada
            $existingBill = Model::where('nasabah_id', $nasabah->id)
                ->whereMonth('tanggal_tagihan', $tanggalTagihan)
                ->whereYear('tanggal_tagihan', $currentYear)
                ->first();

            // Jika belum ada, buat tagihan baru
            if (!$existingBill) {
                // Hitung jumlah tagihan berdasarkan harga kategori layanan
                $jumlahTagihan = $kategoriLayanan->harga;

                // Buat record tagihan baru
                Model::create([
                    'nasabah_id' => $nasabah->id,
                    'tanggal_tagihan' => $tanggalTagihan,
                    'tanggal_jatuh_tempo' => now()->setYear($currentYear)->setMonth($currentMonth)->setDay(25),
                    'jumlah_tagihan' => $jumlahTagihan,
                    'status' => 'belum',
                    'keterangan' => 'Tagihan bulan ' . $tanggalTagihan
                ]);
            }
        }

        return redirect()->route('tagihan.index')->with('success', 'Selesai membuat tagihan untuk bulan ini.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagihanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Model $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $tagihan)
    {
        // edit tagihan with nasabah with kategori layanan
        $model = $tagihan->load('nasabah.kategoriLayanan');
        // ubah format tanggal tagihan dan tanggal jatuh tempo menjadi format Indonesia menggunakan Carbon
        $model->tanggal_tagihan = Carbon::parse($model->tanggal_tagihan)->translatedFormat('d F Y');
        $model->tanggal_jatuh_tempo = Carbon::parse($model->tanggal_jatuh_tempo)->translatedFormat('d F Y');

        $data = [
            'model' => Model::findOrFail($tagihan->id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $tagihan->id],
            'button' => 'UPDATE',
            'title' => 'Tagihan'
        ];
        return view('tagihan.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagihanRequest  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagihanRequest $request, Model $tagihan)
    {
        // update tagihan
        $model = Model::findOrFail($tagihan->id);
        dd($model);
        $model->fill($request);
        $model->save();
        
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $tagihan)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);
        
        // Validasi status
        $request->validate([
            'status' => 'required|in:belum'
        ]);

        // Hitung saldo baru setelah pembayaran
        $saldoTerbaru = Saldo::latest()->first();
        $saldoBaru = $saldoTerbaru->saldo - $tagihan->jumlah_tagihan;
        
        // Update saldo utama
        $saldoTerbaru->update([
            'saldo' => $saldoBaru
        ]);
        
        // Update status pembayaran
        $tagihan->update([
            'status' => $request->status
        ]);
        
        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function broadcastWhatsapp()
    {
        // Mendapatkan tanggal awal bulan ini
        $tanggalAwalBulanIni = now()->startOfMonth()->toDateString();

        // dd($tanggalAwalBulanIni);

        // Mendapatkan tagihan yang belum dibayar dan memiliki tanggal tagihan pada bulan ini
        $tagihans = Tagihan::where('status', 'belum')
                            ->where('tanggal_tagihan', $tanggalAwalBulanIni)
                            ->get();

        // Cek apakah berhasil mengambil data
        // dd($tagihans);

        // Kirim pesan WhatsApp untuk setiap tagihan
        foreach ($tagihans as $tagihan) {
            // Ambil nomor WhatsApp dari nasabah
            $nomorWhatsApp = $tagihan->nasabah->nohp;

            // cek nomor hp nasabah, jika didepan ada 08 maka ganti dengan 628
            if (substr($nomorWhatsApp, 0, 2) == '08') {
                $nomorWhatsApp = '628' . substr($nomorWhatsApp, 2);
            } else {
                $nomorWhatsApp = $nomorWhatsApp;
            }


            // Buat pesan WhatsApp
            $bulanTagihan = Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('F');
            $pesan = "Halo, " . $tagihan->nasabah->name . ". Ini adalah pengingat bahwa tagihan Anda dengan jumlah Rp. " . number_format($tagihan->jumlah_tagihan, 0, ',', '.')." Periode Bulan " . $bulanTagihan . " belum dibayar. Silakan segera lakukan pembayaran melalui aplikasi atau melalui outlet terdekat. Terima kasih.";

            // dd($nomorWhatsApp);
            // Kirim pesan menggunakan API WhatsApp
            $waResponse = $this->sendMessage($nomorWhatsApp, $pesan);
            
            // Periksa respon dari pengiriman pesan
            if ($waResponse) {
                // Jika berhasil, atur nilai whatsapp_sent menjadi 1
                $tagihan->update(['whatsapp_sent' => 1]);
            } else {
                // Jika gagal, lakukan penanganan kesalahan
                Log::error('Gagal mengirim pesan WhatsApp untuk tagihan dengan ID: ' . $tagihan->id);
                // Lakukan tindakan lain sesuai kebutuhan aplikasi Anda, misalnya, kirim notifikasi ke admin
            }
        }

        return back()->with('success', 'Broadcast WhatsApp telah dimasukkan ke dalam antrian.');
    }




    
}
