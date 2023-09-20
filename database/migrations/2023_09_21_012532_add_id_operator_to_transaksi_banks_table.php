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
        Schema::table('transaksi_banks', function (Blueprint $table) {
            // tambah kolom id_operator setelah kolom total_harga
            $table->unsignedBigInteger('id_operator')->after('total_harga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_banks', function (Blueprint $table) {
            //
        });
    }
};
