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
        Schema::table('transaksi_penjualans', function (Blueprint $table) {
            // Tambahkan kolom id_pengepul
            $table->unsignedBigInteger('id_pengepul')->nullable()->after('user_id');
            // Tambahkan relasi ke tabel pengepuls
            $table->foreign('id_pengepul')->references('id')->on('pengepuls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_penjualans', function (Blueprint $table) {
            // Hapus kolom id_pengepul
            $table->dropColumn('id_pengepul');
        });
    }
};
