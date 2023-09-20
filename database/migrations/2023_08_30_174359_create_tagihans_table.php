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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            // ambil id dari tabel nasabah
            $table->foreignId('nasabah_id')->constrained('nasabahs');
            // tanggal tagihan
            $table->date('tanggal_tagihan');
            // tanggal jatuh tempo
            $table->date('tanggal_jatuh_tempo');
            // jumlah tagihan
            $table->decimal('jumlah_tagihan', 19, 2);
            // jumlah bayar
            $table->decimal('jumlah_bayar', 19, 2)->nullable();
            // tanggal bayar
            $table->date('tanggal_bayar')->nullable();
            // status
            $table->enum('status', ['belum', 'lunas'])->default('belum');
            // keterangan
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagihans');
    }
};
