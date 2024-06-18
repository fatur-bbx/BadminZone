<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendapatan', function (Blueprint $table) {
            $table->uuid('id_pendapatan')->primary();
            $table->tinyInteger('jenis_pendapatan');
            $table->uuid('barang')->nullable();
            $table->foreign('barang')->references('id_persediaan')->on('persediaan')->onDelete('set null');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->string('deskripsi');
            $table->timestamp('tanggal_pendapatan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendapatan');
    }
};
