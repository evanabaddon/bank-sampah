<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use Auth;

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
    public function index()
    {
        // Mendapatkan pengguna yang saat ini login
        $currentUser = Auth::user();

        // Query builder untuk mengambil data tagihan berdasarkan user_id
        $tagihanQuery = Model::with('nasabah.kategoriLayanan')->latest();

        // Jika pengguna adalah admin, maka tampilkan semua data
        if (!$currentUser || $currentUser->akses == 'admin') {
            $models = $tagihanQuery->paginate(50);
        } else {
            // Jika bukan admin, filter data berdasarkan user_id
            $models = $tagihanQuery->where('user_id', $currentUser->id)->paginate(50);
        }

        // Ubah format tanggal tagihan dan tanggal jatuh tempo menjadi format Indonesia menggunakan Carbon
        foreach ($models as $model) {
            $model->tanggal_tagihan = Carbon::parse($model->tanggal_tagihan)->translatedFormat('d F Y');
            $model->tanggal_jatuh_tempo = Carbon::parse($model->tanggal_jatuh_tempo)->translatedFormat('d F Y');
            $model->tanggal_bayar = Carbon::parse($model->tanggal_bayar)->translatedFormat('d F Y');
        }

        $data = [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Tagihan'
        ];

        return view('tagihan.' . $this->viewIndex, $data);
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
        flash('Data Berhasil Diubah');
        return redirect()->route('tagihan.index');
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
