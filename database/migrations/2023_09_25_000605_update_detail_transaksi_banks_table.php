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
        Schema::table('detail_transaksi_banks', function (Blueprint $table) {
            $table->decimal('berat', 8, 2)->change();
            $table->decimal('harga', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_transaksi_banks', function (Blueprint $table) {
            $table->integer('berat')->change();
            $table->integer('harga')->change();
        });
    }
};
