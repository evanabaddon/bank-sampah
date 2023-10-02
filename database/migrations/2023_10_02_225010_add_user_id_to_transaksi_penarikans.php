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
        Schema::table('transaksi_penarikans', function (Blueprint $table) {
            // Tambahkan kolom baru user_id
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            // Tambahkan relasi ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_penarikans', function (Blueprint $table) {
            //
        });
    }
};
