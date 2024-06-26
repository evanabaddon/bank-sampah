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
            // Tambahkan kolom user_id
            $table->foreignId('user_id')->after('id')->nullable()->constrained('users')->onDelete('cascade');

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
            // Hapus kolom user_id
            $table->dropForeign(['user_id']);
        });
    }
};
