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
        Schema::table('jenis_sampahs', function (Blueprint $table) {
            $table->decimal('stok', 10, 2)->change(); // Ubah tipe kolom stok ke desimal dengan panjang 10 dan 2 desimal
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_sampahs', function (Blueprint $table) {
            $table->integer('stok')->change(); // Kembalikan tipe kolom stok ke integer (sesuaikan dengan tipe data asal)
        });
    }
};
