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
        Schema::create('nasabahs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alamat');
            $table->string('nohp')->unique();
            $table->boolean('is_bsp')->default(false);
            $table->boolean('is_ppc')->default(false);
            $table->foreignId('kategori_layanan_id')->nullable()->constrained('kategori_layanans')->onDelete('cascade');
            $table->integer('saldo')->default(0);
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
        Schema::dropIfExists('nasabahs');
    }
};
