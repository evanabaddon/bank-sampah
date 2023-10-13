<?php

namespace App\Http\Controllers;
use App\Models\Pengepul as Model;
use App\Http\Requests\StorePengepulRequest;
use App\Http\Requests\UpdatePengepulRequest;

class PengepulController extends Controller
{
    private $viewIndex = 'index';
    private $viewCreate = 'form';
    private $viewEdit = 'form';
    private $routePrefix = 'pengepul';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Query builder untuk mengambil data pengepul
        $models = Model::latest()->paginate(50);

        $data = [
            'models' => $models,
            'routePrefix' => 'pengepul',
            'title' => 'Pengepul'
        ];

        return view('pengepul.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Tampilkan halaman form untuk menambahkan pengepul
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'routePrefix' => 'pengepul',
            'title' => 'Tambah Pengepul'
        ];

        return view('pengepul.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePengepulRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePengepulRequest $request)
    {
        // isi user_id dengan id user yang sedang login
        $userid = auth()->user()->id;

        // validasi data yang dikirim
        $requestData = $request->validate(
            [
                'name' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
            ]
        );

        // Tambahkan user_id ke request data
        $requestData['user_id'] = $userid;

        // Simpan data ke database
        Model::create($requestData);

        // Redirect ke halaman daftar pengepul
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Pengepul berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengepul  $pengepul
     * @return \Illuminate\Http\Response
     */
    public function show(Model $pengepul)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengepul  $pengepul
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Tampilkan halaman form untuk mengubah data pengepul
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'routePrefix' => 'pengepul',
            'title' => 'Ubah Pengepul'
        ];

        return view('pengepul.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePengepulRequest  $request
     * @param  \App\Models\Pengepul  $pengepul
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePengepulRequest $request, Model $pengepul)
    {
        // validasi data yang dikirim
         $requestData = $request->validate(
            [
                'name' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
            ]
        );

        // Tambahkan user_id ke request data
        $requestData['user_id'] = auth()->user()->id;

        // Simpan data ke database
        $pengepul->update($requestData);

        // Redirect ke halaman daftar pengepul
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Pengepul berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengepul  $pengepul
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Hapus data dari database
        $model= Model::findOrFail($id);
        if ($model-> email=='admin@admin.com') {
            return back()->with('success', 'Pengepul berhasil dihapus');
        }
        $model->delete();
       
        return back()->with('success', 'Pengepul berhasil dihapus');
    }
}
