<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Queue;

class QueueMonitorController extends Controller
{
    public function index()
    {
        // Ambil daftar pekerjaan dalam antrian
        $jobs = Queue::getJobs();

        // Hitung jumlah total pekerjaan dalam antrian
        $totalJobs = count($jobs);

        // Tampilkan halaman pemantauan dengan data antrian
        return view('broadcast.queue-monitor', compact('jobs', 'totalJobs'));
    }
}
