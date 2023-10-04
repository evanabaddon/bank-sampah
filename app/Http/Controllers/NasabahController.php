<?php

namespace App\Http\Controllers;
use App\Models\KategoriLayanan;
use Illuminate\Http\Request;
use App\Models\Nasabah as Model;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class NasabahController extends Controller
{
    private $viewIndex = 'index';
    private $viewCreate = 'form';
    private $viewEdit = 'form';
    private $viewShow = 'detail';
    private $routePrefix = 'nasabah';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $modes = Model::with('kategoriLayanan')->latest()->paginate(50);
        $data = 
            [
              'models' => $modes,
              'routePrefix' => $this->routePrefix,
              'title' => 'Nasabah'
            ];
        return view('nasabah.' . $this->viewIndex, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategoriLayanans = KategoriLayanan::all(); // Ambil semua kategori layanan
        $data = [
            'model' => new Model(),
            'kategoriLayanans' => $kategoriLayanans, // Melewatkan data kategori layanan ke view
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Nasabah'
        ];
        return view('nasabah.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // generate otomatis kode nasabah untuk dijadikan qrcode
        $lastNasabah = Model::latest()->first();
        
        if ($lastNasabah) {
            $lastNasabahId = (int) substr($lastNasabah->kodenasabah, 3) + 1;
        } else {
            $lastNasabahId = 1;
        }
        
        $lastNasabahId = str_pad($lastNasabahId, 4, '0', STR_PAD_LEFT);
        $kodeNasabah = 'NAS' . $lastNasabahId;

       

        $requestData = $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'nohp' => 'required|unique:nasabahs',
            'is_bsp' => 'boolean',
            'is_ppc' => 'boolean',
            'kategori_layanan_id' => 'nullable',
        ]);

        $requestData['kodenasabah'] = $kodeNasabah;

        Model::create($requestData);
        flash('Data Berhasil Disimpan');
        return redirect()->route('nasabah.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Ambil data nasabah berdasarkan id
        $model = Model::with('kategoriLayanan')->findOrFail($id);

        
        // Ambil data tagihan hanya untuk tahun berjalan
        // $tagihans = $model->tagihans()->whereYear('tanggal_tagihan', now()->year)->get();

        // Ambil data tagihan untuk semua tahun
        $tagihans = $model->tagihans()->get();

        // kelompokkan tagihan berdasarkan tahun
        $tagihans = $tagihans->groupBy(function ($item, $key) {
            return Carbon::parse($item->tanggal_tagihan)->format('Y');
        });

        // ubah format tanggal tagihan dan tanggal jatuh tempo menjadi format Indonesia menggunakan Carbon
        foreach ($tagihans as $tagihan) {
            $tagihan->tanggal_tagihan = Carbon::parse($model->tanggal_tagihan)->translatedFormat('d F Y');
            $tagihan->tanggal_jatuh_tempo = Carbon::parse($model->tanggal_jatuh_tempo)->translatedFormat('d F Y');
        }

        
        $data = [
            'model' => $model,
            'tagihans' => $tagihans, // Pass data tagihan ke tampilan
            'title' => 'Nasabah'
        ];
        
        return view('nasabah.' . $this->viewShow, $data);;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategoriLayanans = KategoriLayanan::all(); // Ambil semua kategori layanan
        $data = [
            'model' => Model::findOrFail($id),
            'kategoriLayanans' => $kategoriLayanans, // Melewatkan data kategori layanan ke view
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'title' => 'Nasabah'
        ];
        return view('nasabah.' . $this->viewEdit, $data);
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
            'alamat' => 'required',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'nohp' => 'required',
            'is_bsp' => 'boolean',
            'is_ppc' => 'boolean',
            'kategori_layanan_id' => 'nullable',
        ]);
    
        $model = Model::findOrFail($id);
    
        // Jika nomor hp tidak berubah, maka tidak perlu validasi unik
        if ($request->input('nohp') === $model->nohp) {
            unset($requestData['nohp']);
        }
    
        // Validasi nomor hp unik hanya jika ada perubahan
        if (!empty($requestData['nohp'])) {
            $request->validate([
                'nohp' => 'unique:nasabahs',
            ]);
        }
    
        $model->fill($requestData);
    
        // Simpan nilai is_bsp dan is_ppc
        $model->is_bsp = $request->has('is_bsp');
        $model->is_ppc = $request->has('is_ppc');
        
        // Set kategori_layanan_id menjadi null jika is_ppc tidak terpilih
        if (!$request->has('is_ppc')) {
            $model->kategori_layanan_id = null;
        }
    
        $model->save();
    
        flash('Data Berhasil Diubah');
        return redirect()->route('nasabah.index');
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

    public function generatePin() {
        $pin = rand(100000, 999999);
        return $pin;
    }
    
    public function generateNewPin(Request $request, $id) {
        $model = Model::findOrFail($id);
        $newPin = $this->generatePin();
        
        // Simpan pin baru ke dalam database
        $model->update(['pin' => $newPin]);
    
        flash('PIN Baru berhasil dibuat: ' . $newPin);
        return redirect()->route('nasabah.show', $id);
    }
    
    public function kirimPin(Request $request, $id) {
        $model = Model::findOrFail($id);
        
        if (!$model->pin) {
            flash('Belum ada PIN yang dibuat untuk nasabah ini.');
            return redirect()->route('nasabah.show', $id);
        }
    
        // Format URL untuk mengirim pesan ke WhatsApp
        $whatsappUrl = "https://wa.me/{$model->nohp}?text=PIN%20anda%20adalah%20{$model->pin}";
    
        // Redirect ke URL WhatsApp dengan membuka tab baru
        return redirect()->away($whatsappUrl)->withHeaders(['target' => '_blank', 'rel' => 'noopener noreferrer']);
    }
    
    // Cetak kartu nasabah
    public function cetakKartu($id) {
        // Temukan nasabah berdasarkan ID
        $nasabah = Model::findOrFail($id);
        
        // Kirim data nasabah ke tampilan nasabah.kartu
        return view('nasabah.kartu', ['nasabah' => $nasabah]);
    }

}
