<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Models\KategoriLayanan;
use App\Models\Nasabah;
use Auth;
use Illuminate\Http\Request;

class TagihanController extends Controller
{

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


        // Jika pengguna adalah admin, maka tampilkan semua data
        if (!$currentUser || $currentUser->akses == 'admin') {
            // filter data berasarkan bulan
            if (request()->filled('bulan') && !request()->filled('tahun')) {
                $models = $tagihanQuery->whereMonth('tanggal_tagihan', request('bulan'))->paginate(50);
            }

            // filter data berasarkan tahun
            if (!request()->filled('tahun') && request()->filled('tahun')) {
                $models = $tagihanQuery->whereYear('tanggal_tagihan', request('tahun'))->paginate(50);
            }

            // filter data berasarkan status
            if (request()->filled('status')) {
                $models = $tagihanQuery->where('status', request('status'))->paginate(50);
            }

            // filter data berasarkan kategori layanan
            if (request()->filled('kategori_layanan_id')) {
                $models = $tagihanQuery->whereHas('nasabah', function ($query) {
                    $query->where('kategori_layanan_id', request('kategori_layanan_id'));
                })->paginate(50);
            }

            // filter data berasarkan nama nasabah
            if (request()->filled('q')) {
                $models = $tagihanQuery->whereHas('nasabah', function ($query) {
                    $query->where('name', 'like', '%' . request('q') . '%');
                })->paginate(50);
            }

            // filter data berdasarkan RT nasabah
            if (request()->filled('rt')) {
                $models = $tagihanQuery->whereHas('nasabah', function ($query) {
                    $query->where('rt', request('rt'));
                })->paginate(50);
            }

            $models = $tagihanQuery->paginate(50);
        } else  {
            
            // Jika bukan admin, filter data dengan status belum tanpa user_id atau filter data dengan status lunas dengan user_id, atau filter data berdasarakan pencarian nama nasabah dengan status belum tanpa user_id atau filter data berdasarakan pencarian nama nasabah dengan status lunas dengan user_id
            if (request()->filled('q')) {
                $models = $tagihanQuery->where(function ($query) use ($currentUser) {
                    $query->where('status', 'belum')->whereNull('user_id')->whereHas('nasabah', function ($query) {
                        $query->where('name', 'like', '%' . request('q') . '%');
                    });
                })->orWhere(function ($query) use ($currentUser) {
                    $query->where('status', 'lunas')->where('user_id', $currentUser->id)->whereHas('nasabah', function ($query) {
                        $query->where('name', 'like', '%' . request('q') . '%');
                    });
                })->paginate(50);
            }

            // Jika bukan admin, request status belum filter data dengan status belum tanpa user_id
            if (request()->filled('status') && request('status') == 'belum') {
                $models = $tagihanQuery->where('status', 'belum')->whereNull('user_id')->paginate(50);
            }

            // Jika bukan admin, request status lunas filter data dengan status lunas dengan user_id
            if ( request('status') == 'lunas') {
                $models = $tagihanQuery->where('status', 'lunas')->where('user_id', $currentUser->id)->paginate(50);
            }

            // Jika bukan admin, filter data dengan status belum tanpa user_id atau filter data dengan status lunas dengan user_id
            $models = $tagihanQuery->where(function ($query) use ($currentUser) {
                $query->where('status', 'belum')->whereNull('user_id');
            })->orWhere(function ($query) use ($currentUser) {
                $query->where('status', 'lunas')->where('user_id', $currentUser->id);
            })->paginate(50);
            
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

}
