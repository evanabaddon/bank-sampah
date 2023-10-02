<?php

namespace Database\Seeders;

use App\Models\Saldo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaldoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat sebuah record saldo dengan nilai awal 0
        Saldo::create([
            'saldo' => 0,
        ]);
    }
}
