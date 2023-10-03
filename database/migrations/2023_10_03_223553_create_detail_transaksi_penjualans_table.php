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
        Schema::create('detail_transaksi_penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_penjualan_id');
            $table->unsignedBigInteger('jenis_sampah_id');
            $table->decimal('jumlah_kg', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();

            $table->foreign('transaksi_penjualan_id')->references('id')->on('transaksi_penjualans');
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
        Schema::dropIfExists('detail_transaksi_penjualans');
    }
};
