<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Saldo;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function print($tagihan_id)
    {
        $tagihan = Tagihan::findOrFail($tagihan_id);
        return view('nota.print', compact('tagihan'));
    }

    public function updateStatusAndPrint($tagihan_id)
    {
        // Retrieve the tagihan (bill) based on the provided tagihan_id
        $tagihan = Tagihan::findOrFail($tagihan_id);

        // Update the status of the tagihan to "lunas" dan update tanggal bayar dan user_id yang melakukan pembayaran

        $tagihan->update(
            [
                'user_id' => auth()->user()->id,
                'status' => 'lunas',
                'tanggal_bayar' => now(),
            ]);

        // Mengambil jumlah tagihan yang telah dibayar
        $jumlahTagihan = $tagihan->jumlah_tagihan;

        // Mengambil saldo perusahaan
        $saldoPerusahaan = Saldo::first(); // Ambil saldo perusahaan pertama

        // Menambahkan saldo perusahaan sesuai dengan jumlah tagihan yang dibayar
        $saldoPerusahaan->saldo += $jumlahTagihan;
        $saldoPerusahaan->save();

        // return ke halaman detail nasabah
        return redirect()->route('nasabah.show', ['nasabah' => $tagihan->nasabah_id]);
    }

    // fungsi kirim nota ke whatsapp nasabah
    public function kirimNota($tagihan_id)
    {
        // Retrieve the tagihan (bill) based on the provided tagihan_id
        $tagihan = Tagihan::findOrFail($tagihan_id);

        // Retrieve the nasabah (customer) based on the provided nasabah_id
        $nasabah = Nasabah::findOrFail($tagihan->nasabah_id);

        // nomor tagihan
        $nomor_tagihan = 'PPC/' . $tagihan->id . '/' . $tagihan->nasabah_id . '/' . date('my', strtotime($tagihan->tanggal_tagihan));

        // bulan tagihan
        $bulan_tagihan = date('F Y', strtotime($tagihan->tanggal_tagihan));

        // footer pesan. ambil dari env nama aplikasi
        $footer = env('APP_NAME');

        // Format URL untuk mengirim pesan ke WhatsApp nasabah dengan status tagihan lunas
        $whatsappUrl = 'https://api.whatsapp.com/send?phone=' . $nasabah->nohp . '&text=Tagihan%20anda%20dengan%20nomor%20tagihan%20' . $nomor_tagihan . '%20Bulan%20'. $bulan_tagihan. '%20telah%20lunas.%20Terima%20kasih. *' . $footer . '*.';
    
        // Redirect ke URL WhatsApp dengan membuka tab baru
        return redirect()->away($whatsappUrl)->withHeaders(['target' => '_blank', 'rel' => 'noopener noreferrer']);

    }
}
