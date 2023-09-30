<?php

namespace App\Http\Controllers;

use App\Models\TransaksiBank as Model;
use App\Http\Requests\StoreTransaksiBankRequest;
use App\Http\Requests\UpdateTransaksiBankRequest;
use App\Models\DetailTransaksiBank;
use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\TransaksiBank;
use Auth;

class TransaksiBankController extends Controller
{
    private $viewIndex = 'index';
    private $viewCreate = 'form';
    private $viewEdit = 'form';
    private $viewShow = 'show';
    private $routePrefix = 'transaksi-bank';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Model::latest()
        ->join('users', 'transaksi_banks.id_operator', '=', 'users.id') // Join dengan tabel users
        ->select('transaksi_banks.*', 'users.name as operator_name') // Pilih kolom yang diperlukan
        ->paginate(50);

        $data = [
            'models' => $transactions,
            'routePrefix' => $this->routePrefix,
            'title' => 'Transaksi Bank Sampah'
        ];

        return view('transaksi-bank.' . $this->viewIndex, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_nasabah = null)
    {
        
        // Get nasabah when is_bsp = 1
        $nasabahs = Nasabah::where('is_bsp', 1)->pluck('name', 'id')->all();

        // Get jenis sampah and convert it to an array with 'id' as the key and 'harga' as the value
        $jenisSampahs = JenisSampah::pluck('name', 'id')->all();

        // Get the prices of each jenis sampah and convert it to an array with 'id' as the key and 'harga' as the value
        $hargaSampah = JenisSampah::pluck('harga', 'id')->all();

        // Define additional data
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Transaksi Bank Sampah',
            'idNasabah' => $id_nasabah, // Variabel ini akan digunakan dalam form
        ];

        // Return the view with compacted data
        return view($this->routePrefix . '.' . $this->viewCreate, compact('nasabahs', 'jenisSampahs', 'hargaSampah', 'id_nasabah') + $data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransaksiBankRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaksiBankRequest $request)
    {
        // Pastikan pengguna telah login
        if (Auth::check()) {
            $id_operator = Auth::user()->id; // Mengambil id_operator dari pengguna yang login
        } else {
            // Handle jika pengguna tidak login (opsional)
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Validasi input
        $this->validate($request, [
            'id_nasabah' => 'required|exists:nasabahs,id',
            'jenis_sampah' => 'required|array',
            'jenis_sampah.*' => 'exists:jenis_sampahs,id',
            'berat' => 'required|array',
            'berat.*' => 'numeric|min:0.01',
        ]);

        // Membuat transaksi bank sampah baru
        $transaksi = new TransaksiBank();
        $transaksi->id_nasabah = $request->input('id_nasabah');
        $transaksi->id_operator = $id_operator; // Menyimpan id_operator

        // Hitung total harga sesuai dengan logika aplikasi Anda
        $jenisSampahIds = $request->input('jenis_sampah');
        $beratSampahs = $request->input('berat');
        $totalHarga = 0;

        foreach ($jenisSampahIds as $index => $jenisSampahId) {
            $jenisSampah = JenisSampah::find($jenisSampahId);
            $hargaSampah = JenisSampah::find($jenisSampahId)->harga;
            $berat = $beratSampahs[$index];
            $subtotal = $hargaSampah * $berat; // Hitung subtotal berdasarkan harga dan berat
            $totalHarga += $subtotal;
            // menambah stok jenis sampah
            $jenisSampah->stok += $berat;
            $jenisSampah->save();
        }

        $transaksi->total_harga = $totalHarga;
        $transaksi->save();

        // Menyimpan detail transaksi bank sampah
        foreach ($jenisSampahIds as $index => $jenisSampahId) {
            $berat = $beratSampahs[$index];

            $detail = new DetailTransaksiBank();
            $detail->id_transaksi_bank = $transaksi->id;
            $detail->id_jenis_sampah = $jenisSampahId;
            $detail->berat = $berat; // Memasukkan berat yang sesuai
            $detail->harga = $hargaSampah; // Menggunakan harga per kilogram
            $detail->save();
        }

        // Update saldo nasabah
        $nasabah = Nasabah::find($request->input('id_nasabah'));
        $nasabah->saldo += $totalHarga;
        $nasabah->save();

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Transaksi berhasil disimpan');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransaksiBank  $transaksiBank
     * @return \Illuminate\Http\Response
     */
    public function show(Model $transaksiBank)
    {
        $transaksiBank->load('operator', 'nasabah', 'detailTransaksiBank.jenisSampah');
        // dd($transaksiBank->toArray());
        
        return view($this->routePrefix . '.' . $this->viewShow, compact('transaksiBank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransaksiBank  $transaksiBank
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $transaksiBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransaksiBankRequest  $request
     * @param  \App\Models\TransaksiBank  $transaksiBank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiBankRequest $request, Model $transaksiBank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiBank  $transaksiBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $transaksiBank)
    {
        // Pastikan pengguna telah login
        if (Auth::check()) {
            $id_operator = Auth::user()->id; // Mengambil id_operator dari pengguna yang login
        } else {
            // Handle jika pengguna tidak login (opsional)
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Mengambil data transaksi bank
        $transaksi = TransaksiBank::find($transaksiBank->id);

        // Mengambil detail transaksi bank
        $detailTransaksi = DetailTransaksiBank::where('id_transaksi_bank', $transaksi->id)->get();

        // Mengembalikan stok jenis sampah sesuai dengan berat pada detail transaksi
        foreach ($detailTransaksi as $detail) {
            $jenisSampah = JenisSampah::find($detail->id_jenis_sampah);
            // mengurangkan stok jenis sampah
            $jenisSampah->stok -= $detail->berat;
            $jenisSampah->save();
        }

        // Mengambil saldo nasabah terkait
        $nasabah = Nasabah::find($transaksi->id_nasabah);

        // Mengurangkan saldo nasabah sesuai dengan total transaksi
        $nasabah->saldo -= $transaksi->total_harga;
        $nasabah->save();

        // Hapus transaksi bank
        $transaksiBank->delete();

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Transaksi berhasil dihapus');
    }


}
