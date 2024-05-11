<?php

namespace App\Jobs;

use App\Traits\WhatsAppApi;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use WhatsAppApi; // Import WhatsAppApi trait

    protected $tagihan;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tagihan $tagihan)
    {
        $this->tagihan = $tagihan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Ambil nomor WhatsApp dari nasabah
        $nomorWhatsApp = $this->tagihan->nasabah->nohp;

        // Buat pesan WhatsApp
        $bulanTagihan = Carbon::parse($this->tagihan->tanggal_tagihan)->translatedFormat('F');
        $pesan = "Halo, " . $this->tagihan->nasabah->name . ". Ini adalah pengingat bahwa tagihan Anda dengan jumlah Rp. " . number_format($this->tagihan->jumlah_tagihan, 0, ',', '.')." Periode Bulan " . $bulanTagihan . " belum dibayar. Silakan segera lakukan pembayaran melalui aplikasi atau melalui outlet terdekat. Terima kasih.";

        // Kirim pesan menggunakan API WhatsApp
        $waResponse = $this->sendMessage($nomorWhatsApp, $pesan);
        
        // Periksa respon dari pengiriman pesan
        if ($waResponse) {
            // Jika berhasil, atur nilai whatsapp_sent menjadi 1
            $this->tagihan->update(['whatsapp_sent' => 1]);
        } else {
            // Jika gagal, lakukan penanganan kesalahan
            Log::error('Gagal mengirim pesan WhatsApp untuk tagihan dengan ID: ' . $this->tagihan->id);
            // Lakukan tindakan lain sesuai kebutuhan aplikasi Anda, misalnya, kirim notifikasi ke admin
        }
    }
}
