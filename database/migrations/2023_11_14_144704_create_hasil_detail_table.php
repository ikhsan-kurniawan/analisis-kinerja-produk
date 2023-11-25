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
        Schema::create('hasil_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_hasil');
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->integer('peringkat');
            $table->foreign('id_hasil')->references('id')->on('hasil');
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
        Schema::dropIfExists('hasil_detail');
    }
};
