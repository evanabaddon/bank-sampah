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
            $table->dropColumn('jenis_sampah_id');
            $table->dropColumn('jumlah_kg');
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
            $table->unsignedBigInteger('jenis_sampah_id');
            $table->decimal('jumlah_kg', 10, 2);
        });
    }
};
