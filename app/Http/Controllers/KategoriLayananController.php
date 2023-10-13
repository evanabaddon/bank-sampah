<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\KategoriLayanan as Model;

class KategoriLayananController extends Controller
{
    private $viewIndex = 'index';
    private $viewCreate = 'form';
    private $viewEdit = 'form';
    private $viewShow = 'show';
    private $routePrefix = 'kategori-layanan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->filled('q')){
            $modes = Model::search($request->q)->paginate(50);
        } else{
            $modes = Model::latest()->paginate(50);
        }
        $data = 
            [
              'models' => $modes,
              'routePrefix' => $this->routePrefix,
              'title' => 'Kategori Layanan'
            ];
        return view('kategori-layanan.' . $this->viewIndex, $data);
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
            'title' => 'Kategori Layanan'
        ];
        return view('kategori-layanan.' . $this->viewCreate, $data);
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

        return redirect()->route('kategori-layanan.index')->with('success', 'Kategori Layanan Berhasil Ditambahkan');
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
            'title' => 'Kategori Layanan'
        ];
        return view('kategori-layanan.' . $this->viewEdit,$data);
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
        return redirect()->route('kategori-layanan.index')->with('success', 'Kategori Layanan Berhasil Diubah');
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
        return back()->with('success', 'Kategori Layanan Berhasil Dihapus');
    }
}
