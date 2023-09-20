<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\JenisSampah as Model;

class JenisSampahController extends Controller
{
    private $viewIndex = 'index';
    private $viewCreate = 'form';
    private $viewEdit = 'form';
    private $viewShow = 'show';
    private $routePrefix = 'jenis-sampah';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $modes = Model::latest()->paginate(50);
        $data = 
            [
              'models' => $modes,
              'routePrefix' => $this->routePrefix,
              'title' => 'Jenis Sampah'
            ];
        return view('jenis-sampah.' . $this->viewIndex, $data);
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
        return view('jenis-sampah.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->validate(
            [
                'name' => 'required',
                'harga' => 'required',
            ]
        );
        Model::create($requestData);
        flash('Data Berhasil Disimpan');
        return redirect()->route('jenis-sampah.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'title' => 'Jenis Sampah'
        ];
        return view('jenis-sampah.' . $this->viewEdit,$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->validate([
            'name' => 'required',
            'harga' => 'required',
        ]);

        $model = Model::findOrFail($id);
        $model->fill($requestData);
        $model->save();
        flash('Data Berhasil Diubah');
        return redirect()->route('jenis-sampah.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model= Model::findOrFail($id);
        if ($model-> email=='admin@admin.com') {
            flash('Data tidak bisa dihapus',$level='danger');
            return back();
        }
        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
