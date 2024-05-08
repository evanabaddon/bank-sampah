<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPenarikan as Model;
use App\Http\Requests\StoreTransaksiPenarikanRequest;
use App\Http\Requests\UpdateTransaksiPenarikanRequest;
use App\Models\Nasabah;
use Carbon\Carbon;

class TransaksiPenarikanController extends Controller
{
    private $viewIndex = 'index';
    private $viewCreate = 'form';
    private $viewEdit = 'form';
    private $viewShow = 'show';
    private $routePrefix = 'transaksi-penarikan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Model::with('user:id,name') // Mengambil relasi user dengan kolom id dan name
        ->latest()
        ->paginate(50);

        // foreach ($model as $transaction) {
        //     $transaction->created_at = $transaction->created_at->translatedFormat('d F Y H:i:s');
        // }


        $data = [
            'models' => $model,
            'routePrefix' => $this->routePrefix,
            'title' => 'Transaksi Penarikan Saldo'
        ];

        return view('transaksi-penarikan.' . $this->viewIndex, $data);
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

       
        // Define additional data
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Transaksi Penarikan Saldo',
            'idNasabah' => $id_nasabah, // Variabel ini akan digunakan dalam form
        ];

        // Return the view with compacted data
        return view($this->routePrefix . '.' . $this->viewCreate, compact('nasabahs',  'id_nasabah') + $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransaksiPenarikanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaksiPenarikanRequest $request)
    {
        // cek saldo nasabah
        $nasabah = Nasabah::findOrFail($request->id_nasabah);
        if ($nasabah->saldo < $request->jumlah) {
            // flash error saldo tidak cukup
            flash()->addError('Saldo tidak cukup');

            return redirect()->back()->with('error', 'Saldo tidak cukup');
        }


        // kurangi saldo nasabah
        $nasabah->saldo -= $request->jumlah;
        $nasabah->save();

        // buat transaksi penarikan
        $model = new Model();
        $model->nasabah_id = $request->id_nasabah;
        $model->jumlah = $request->jumlah;
        $model->user_id = auth()->user()->id;
        $model->save();

        // flash
        flash()->addSuccess('Data Berhasil Disimpan');

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Transaksi penarikan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransaksiPenarikan  $transaksiPenarikan
     * @return \Illuminate\Http\Response
     */
    public function show(Model $transaksiPenarikan)
    {
        // tampikan detail transaksi penarikan
        $data = [
            'model' => $transaksiPenarikan,
            'title' => 'Detail Transaksi Penarikan',
            'routePrefix' => $this->routePrefix,
        ];

        return view($this->routePrefix . '.' . $this->viewShow, $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransaksiPenarikan  $transaksiPenarikan
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $transaksiPenarikan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransaksiPenarikanRequest  $request
     * @param  \App\Models\TransaksiPenarikan  $transaksiPenarikan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiPenarikanRequest $request, Model $transaksiPenarikan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiPenarikan  $transaksiPenarikan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $transaksiPenarikan)
    {
        // hapus transaksi penarikan dan kembaikan saldo nasabah
        $nasabah = Nasabah::findOrFail($transaksiPenarikan->nasabah_id);
        $nasabah->saldo += $transaksiPenarikan->jumlah;
        $nasabah->save();
        $transaksiPenarikan->delete();

        // flash
        flash()->addSuccess('Data Berhasil Dihapus');

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Transaksi penarikan berhasil dihapus');
    }
}
