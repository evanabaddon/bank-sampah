<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User as Model;

class UserController extends Controller
{
    private $viewIndex = 'user_index';
    private $viewCreate = 'user_form';
    private $viewEdit = 'user_form';
    private $viewShow = 'user_show';
    private $routePrefix = 'user';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('operator.' . $this->viewIndex, [
            'models' => Model::where('akses', '<>', 'nasabah')
                ->latest()
                ->paginate(50),
                'routePrefix' => $this->routePrefix,
                'title' => 'User'
        ]);    
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
            'title' => 'User'
        ];
        return view('operator.' . $this->viewCreate, $data);
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
                'email' => 'email|unique:users',
                'nohp' => 'required|unique:users',
                'password'=> 'required',
                'akses' => 'required|in:operator,admin'
            ]
        );
        $requestData['password'] = bcrypt($requestData['password']);
        $requestData['email_verified_at'] = now();
        Model::create($requestData);
        flash('Data Berhasil Disimpan');
        return redirect()->route('user.index');
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
            'title' => 'User'
        ];
        // tampilkan nama dalam $data
   
        return view('operator.' . $this->viewEdit,$data);
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
        $requestData = $request->validate(
            [
                'name' => 'required',
                'email' => 'email|unique:users,email,' . $id,
                'nohp' => 'required|unique:users,nohp,' . $id,
                'password'=> 'nullable',
                'akses' => 'required|in:operator,admin'
            ]
        );
        $model = Model::findOrFail($id);
        if ($requestData['password'] == "") {
            unset($requestData['password']);
        } else {
            $requestData['password'] = bcrypt($requestData['password']);
        }
        $model->fill($requestData);
        $model->save();
        flash('Data Berhasil Diubah');
        return redirect()->route('user.index');
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
