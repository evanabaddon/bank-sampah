<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
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

        // Update the status of the tagihan to "lunas" dan update tanggal bayar

        $tagihan->update(
            [
                'status' => 'lunas',
                'tanggal_bayar' => now(),
            ]);

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

        // Format URL untuk mengirim pesan ke WhatsApp nasabah dengan status tagihan lunas
        $whatsappUrl = 'https://api.whatsapp.com/send?phone=' . $nasabah->nohp . '&text=Tagihan%20anda%20dengan%20nomor%20tagihan%20' . $tagihan->nomor_tagihan . '%20telah%20lunas.%20Terima%20kasih.';
    
        // Redirect ke URL WhatsApp dengan membuka tab baru
        return redirect()->away($whatsappUrl)->withHeaders(['target' => '_blank', 'rel' => 'noopener noreferrer']);

    }
}
