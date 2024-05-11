<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Saldo;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Traits\WhatsAppApi; 

class NotaController extends Controller
{
    use WhatsAppApi;

    public function print($tagihan_id)
    {
        $tagihan = Tagihan::findOrFail($tagihan_id);
        return view('nota.print', compact('tagihan'));
    }

    public function kwitansi($tagihan_id)
    {
        // ambil nilai nasabah_id dari tagihan
        $nasabah_id = Tagihan::findOrFail($tagihan_id)->nasabah_id;

        // tampilkan list semua tagihan mulai januari - desember berdasarkan user_id
        $listtagihan = Tagihan::where('nasabah_id', $nasabah_id)->get();

        $tagihan = Tagihan::findOrFail($tagihan_id);

        // urutkan berdasarkan bulan mulai dari januari - desember
        $listtagihan = $listtagihan->sortBy('tanggal_tagihan');
        
        return view('nota.kwitansi', compact('tagihan', 'listtagihan'));
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
        return redirect()->route('nasabah.show', ['nasabah' => $tagihan->nasabah_id])->with('success', 'Pembayaran berhasil dilakukan.');
    }
    
    // update status bayar massal
    public function updateStatusMasal(Request $request)
    {
        // Ambil semua tagihan dari request
        $tagihan_ids = $request->tagihan_ids;

        // Ambil semua tagihan berdasarkan tagihan_ids dengan status 'belum'
        $tagihan = Tagihan::whereIn('id', $tagihan_ids)->where('status', 'belum')->get();

        // Inisialisasi variabel untuk melacak keberhasilan pembayaran massal
        $success = true;

        // Proses pembayaran untuk setiap tagihan yang sesuai
        foreach ($tagihan as $item) {
            // Periksa jika tagihan belum lunas
            if ($item->status === 'belum') {
                // Update status tagihan menjadi 'lunas' dan catat tanggal bayar serta user yang melakukan pembayaran
                $item->update([
                    'user_id' => auth()->user()->id,
                    'status' => 'lunas',
                    'tanggal_bayar' => now(),
                ]);

                // Mengambil jumlah tagihan yang telah dibayar
                $jumlahTagihan = $item->jumlah_tagihan;

                // Mengambil saldo perusahaan
                $saldoPerusahaan = Saldo::firstOrNew(['id' => 1]);

                // Menambahkan saldo perusahaan sesuai dengan jumlah tagihan yang dibayar
                $saldoPerusahaan->saldo += $jumlahTagihan;
                $saldoPerusahaan->save();
            } else {
                // Jika tagihan sudah lunas, tandai pembayaran massal sebagai gagal
                $success = false;
            }
        }

        // Berikan respons berdasarkan hasil pembayaran massal
        if ($success) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
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
        $footer = settings()->get('business_name');

        // ambil link nota.print berdasarkan tagihan_id ambil dari fungsi print
        $link = route('kwitansi.nota', ['tagihan_id' => $tagihan->id]);

        // cek nomor hp nasabah, jika didepan ada 08 maka ganti dengan 628
        if (substr($nasabah->nohp, 0, 2) == '08') {
            $nasabah->nohp = '628' . substr($nasabah->nohp, 2);
        } else {
            $nasabah->nohp = $nasabah->nohp;
        }

        $pesan = 'Halo ' . $nasabah->name .', tagihan anda untuk bulan ' .$bulan_tagihan .' dengan nomor tagihan ' .$nomor_tagihan . ' telah lunas. Terima kasih. ' . $footer . '. '. $link;

        // Kirim pesan melalui WhatsApp menggunakan metode sendMessage dari traits WhatsAppApi
        $waResponse = $this->sendMessage($nasabah->nohp, $pesan);

        // Periksa status respon
        $response = json_decode($waResponse, true);
        // dd($response);

        if (isset($response['status']) && $response['status'] === false) {
            // Jika terjadi kesalahan dalam pengiriman pesan WhatsApp
            return redirect()->back()->with('error', 'Data pemakaian berhasil disimpan! Gagal mengirim pesan WhatsApp: ' . $response['message']);
        } else {
            // Jika pengiriman berhasil, lanjutkan dengan operasi lainnya
            return redirect()->back()->with('success', 'Data pemakaian berhasil disimpan! Pesan WhatsApp berhasil dikirim!');
        }

    }
}
