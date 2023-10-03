<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_penjualans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unsignedBigInteger('jenis_sampah_id');
            $table->decimal('jumlah_kg', 10, 2);
            $table->decimal('total_harga', 10, 2);
            // Tambahkan kolom lain sesuai kebutuhan
            $table->timestamps();

            // Definisikan kunci asing ke tabel jenis_sampah
            $table->foreign('jenis_sampah_id')->references('id')->on('jenis_sampahs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_penjualans');
    }
};
