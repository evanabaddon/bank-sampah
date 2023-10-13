<?php

namespace App\Http\Controllers;
use App\Models\TransaksiPenjualan as Model;
use App\Http\Requests\StoreTransaksiPenjualanRequest;
use App\Http\Requests\UpdateTransaksiPenjualanRequest;
use App\Models\JenisSampah;
use App\Models\Pengepul;
use App\Models\Saldo;
use Carbon\Carbon;

class TransaksiPenjualanController extends Controller
{
    private $viewIndex = 'index';
    private $viewCreate = 'form';
    private $viewEdit = 'form';
    private $viewShow = 'show';
    private $routePrefix = 'transaksi-penjualan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Model::with('user:id,name', 'pengepul:id,name') // Mengambil relasi user dengan kolom id dan name
        ->latest()
        ->paginate(50);

        // ubah format tanggal transaksi menjadi format Indonesia menggunakan Carbon
        foreach ($transactions as $transaction) {
            $transaction->tanggal = Carbon::parse($transaction->tanggal)->translatedFormat('d F Y');
        }

        $data = [
            'models' => $transactions,
            'routePrefix' => $this->routePrefix,
            'title' => 'Transaksi Penjualan Sampah'
        ];

        return view('transaksi-penjualan.' . $this->viewIndex, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // mengambil data dari table jenis sampah
        $jenisSampahs = JenisSampah::pluck('name', 'id')->all();

        // mengabil data pengepul
        $pengepuls = Pengepul::pluck('name', 'id')->all();

        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'routePrefix' => $this->routePrefix,
            'title' => 'Transaksi Penjualan Sampah',
            'jenisSampahs' => $jenisSampahs,
            'pengepuls' => $pengepuls,
        ];
        return view('transaksi-penjualan.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransaksiPenjualanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaksiPenjualanRequest $request)
    {
        // Validasi input
        $this->validate($request, [
            'tanggal' => 'required|date',
        ]);
        
        // Ambil data jenis sampah, berat, dan harga dari input form
        $jenisSampahs = $request->input('jenis_sampah');
        $beratJenisSampahs = $request->input('berat');
        $hargaJenisSampahs = $request->input('harga');

        // Periksa apakah $jenisSampahs adalah array
        if (!is_array($jenisSampahs)) {
            return redirect()->back()->with('error', 'Data jenis sampah tidak valid');
        }

        // Cek stok jenis sampah yang akan dijual pada table jenis_sampahs apakah cukup
        $totalHarga = 0;
        foreach ($jenisSampahs as $key => $jenisSampahId) {
            $jenisSampah = JenisSampah::find($jenisSampahId);
            if (!$jenisSampah) {
                return redirect()->back()->with('error', 'Jenis sampah tidak ditemukan');
            }
            if ($jenisSampah->stok < $beratJenisSampahs[$key]) {
                return redirect()->back()->with('error', 'Stok jenis sampah ' . $jenisSampah->name . ' tidak cukup');
            }
            $totalHarga += $beratJenisSampahs[$key] * $hargaJenisSampahs[$key];
        }

        // Kurangi stok jenis sampah yang dijual pada table jenis_sampahs
        foreach ($jenisSampahs as $key => $jenisSampahId) {
            $jenisSampah = JenisSampah::find($jenisSampahId);
            $jenisSampah->stok -= $beratJenisSampahs[$key];
            $jenisSampah->save();
        }

        
        // Simpan data transaksi penjualan
        $transaksiPenjualan = new Model([
            'tanggal' => $request->input('tanggal'),
            'total_harga' => $totalHarga, // Gunakan total harga yang telah dihitung
            'user_id' => auth()->user()->id, // Ambil id user yang sedang login
            'id_pengepul' => $request->input('id_pengepul'),
        ]);

        // update tabel saldo
        $saldo = Saldo::first();
        $saldo->saldo += $totalHarga;
        $saldo->save();

        // dd($transaksiPenjualan);
        $transaksiPenjualan->save();

        // Simpan data detail transaksi penjualan ke table detail_transaksi_penjualans
        foreach ($jenisSampahs as $key => $jenisSampahId) {
            $transaksiPenjualan->detailTransaksiPenjualans()->create([
                'transaksi_penjualan_id' => $transaksiPenjualan->id, // Ambil id transaksi penjualan yang baru dibuat
                'jenis_sampah_id' => $jenisSampahId,
                'jumlah_kg' => $beratJenisSampahs[$key],
                'total_harga' => $hargaJenisSampahs[$key],
            ]);
        }

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Berhasil menambahkan data transaksi penjualan');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransaksiPenjualan  $transaksiPenjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Model $transaksiPenjualan)
    {
        $transaksiPenjualan = Model::with(['user', 'detailtransaksiPenjualans.jenisSampah', 'pengepul'])
        ->find($transaksiPenjualan->id);

        // ubah format tanggal transaksi menjadi format Indonesia menggunakan Carbon
        $transaksiPenjualan->tanggal = Carbon::parse($transaksiPenjualan->tanggal)->translatedFormat('d F Y');

        return view($this->routePrefix . '.' . $this->viewShow, compact('transaksiPenjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransaksiPenjualan  $transaksiPenjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $transaksiPenjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransaksiPenjualanRequest  $request
     * @param  \App\Models\TransaksiPenjualan  $transaksiPenjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiPenjualanRequest $request, Model $transaksiPenjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiPenjualan  $transaksiPenjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $transaksiPenjualan)
    {
        // kembalikan saldo
        $saldo = Saldo::first();
        $saldo->saldo -= $transaksiPenjualan->total_harga;
        $saldo->save();

        // kembalikan stok jenis sampah yang telah dijual
        foreach ($transaksiPenjualan->detailTransaksiPenjualans as $detailTransaksiPenjualan) {
            $jenisSampah = JenisSampah::find($detailTransaksiPenjualan->jenis_sampah_id);
            $jenisSampah->stok += $detailTransaksiPenjualan->jumlah_kg;
            $jenisSampah->save();
        }

        // Hapus data transaksi penjualan
        $transaksiPenjualan->delete();

        // Hapus data detail transaksi penjualan
        $transaksiPenjualan->detailTransaksiPenjualans()->delete();
        
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Berhasil menghapus data transaksi penjualan');
    }
}
