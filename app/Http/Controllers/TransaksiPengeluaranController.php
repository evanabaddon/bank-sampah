<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPengeluaran;
use App\Http\Requests\StoreTransaksiPengeluaranRequest;
use App\Http\Requests\UpdateTransaksiPengeluaranRequest;
use App\Models\Saldo;
use App\Models\TransaksiPengeluaran as Model;
use Illuminate\Http\Request;

class TransaksiPengeluaranController extends Controller
{
    private $viewIndex = 'index';
    private $viewCreate = 'form';
    private $viewEdit = 'form';
    private $viewShow = 'detail';
    private $routePrefix = 'transaksi-pengeluaran';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua data transaksi pengeluaran
        $models = Model::latest()->paginate(50);

        // ambil nama operator yang melakukan transaksi berdasarkan id_user yang ada di tabel transaksi pengeluaran relasinya dengan tabel users
        $models->load('user');
        
        $data = [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Transaksi Pengeluaran'
        ];
        return view('transaksi-pengeluaran.' . $this->viewIndex, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Jenis Sampah'
        ];
        return view('transaksi-pengeluaran.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransaksiPengeluaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaksiPengeluaranRequest $request)
    {
       
        // Validasi input sesuai kebutuhan Anda
        $this->validate($request, [
            'deskripsi' => 'required',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
        ]);
       
        // Simpan data transaksi pengeluaran ke dalam tabel
        $transaksiPengeluaran = new TransaksiPengeluaran();
        $transaksiPengeluaran->deskripsi = $request->input('deskripsi');
        $transaksiPengeluaran->jumlah = $request->input('jumlah');
        $transaksiPengeluaran->tanggal = $request->input('tanggal');  
        // Ambil user yang sedang login
        $transaksiPengeluaran->user_id = auth()->user()->id;
        $transaksiPengeluaran->save();

        // Update saldo perusahaan
        $saldoPerusahaan = Saldo::first(); // Ambil saldo perusahaan pertama
        $saldoPerusahaan->saldo -= $transaksiPengeluaran->jumlah; // Mengurangkan saldo perusahaan sesuai dengan jumlah pengeluaran
        $saldoPerusahaan->save();

        // Redirect ke halaman yang sesuai
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Transaksi berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransaksiPengeluaran  $transaksiPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(TransaksiPengeluaran $transaksiPengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransaksiPengeluaran  $transaksiPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(TransaksiPengeluaran $transaksiPengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransaksiPengeluaranRequest  $request
     * @param  \App\Models\TransaksiPengeluaran  $transaksiPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaksiPengeluaranRequest $request, TransaksiPengeluaran $transaksiPengeluaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransaksiPengeluaran  $transaksiPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransaksiPengeluaran $transaksiPengeluaran)
    {
        // Update saldo perusahaan
        $saldoPerusahaan = Saldo::first(); // Ambil saldo perusahaan pertama
        $saldoPerusahaan->saldo += $transaksiPengeluaran->jumlah; // Menambahkan saldo perusahaan sesuai dengan jumlah pengeluaran
        $saldoPerusahaan->save();
        // Hapus data transaksi pengeluaran
        $transaksiPengeluaran->delete();

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
