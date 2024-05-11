<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Tagihan;
use App\Models\TransaksiBank;

class BerandaOperatorController extends Controller
{
    public function index()
    {
       // daftar transaksi bank terbaru berdasarkan user yang login
        $dataTransaksiBSP = TransaksiBank::where('id_operator', auth()->user()->id)->orderBy('id', 'desc')->take(5)->get();
        // daftar tagihan terbaru dengan status belum lunas
        $dataTagihan = Tagihan::where('status', 'lunas')->where('user_id', auth()->user()->id)->orderBy('id', 'desc')->take(5)->get();

        return view('operator.beranda_index', compact('dataTransaksiBSP', 'dataTagihan'));
    }

    public function validasiQr($kodenasabah)
    {
        // Cari user dengan kode nasabah dari hasil scan
        $nasabah = Nasabah::where('kodenasabah', $kodenasabah)->first();

        // Jika nasabah ditemukan
        if ($nasabah) {
            // Redirect ke halaman nasabah dengan ID nasabah
            // kirim id nasabah sebagai parameter
            return response()->json([
                'status' => 'success',
                'nasabah' => $nasabah->id
            ]);

            // return redirect()->route('nasabah.show', ['nasabah' => $nasabah->id]);
        } else {
            // Nasabah tidak ditemukan, mungkin tampilkan pesan kesalahan
            return response()->json([
                'status' => 'error',
                'message' => 'Nasabah tidak ditemukan'
            ]);

            // return redirect()->back()->with('error', 'Nasabah tidak ditemukan');
        }
    }


}
