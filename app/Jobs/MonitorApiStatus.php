<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\ApiStatus;

class MonitorApiStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Lakukan permintaan HTTP GET ke endpoint /api/status
        $response = Http::get('https://wa.bumdespringgondani.com/api/status', [
            "api_key" => "af2f08697bdc7fcc27aac1f58625ef60f29cdc2f"
        ]);

        $dd($response);

        // Periksa apakah respons berhasil
        if ($response->successful()) {
            // Ambil data status dari respons
            $status = $response->json();

            // Simpan status ke dalam database
            ApiStatus::create([
                'server_status' => $status['server'],
                'device_status' => $status['device'],
            ]);
        } else {
            // Jika respons tidak berhasil, lakukan penanganan kesalahan di sini
            // Simpan status ke dalam database
             ApiStatus::create([
                'server_status' => 'ada kesalahan',
                'device_status' => 'ada kesalahan',
            ]);
            // Contoh: Log pesan kesalahan atau lakukan tindakan lain sesuai kebutuhan
            logger()->error('Failed to fetch API status: ' . $response->status());
        }
    }
}
