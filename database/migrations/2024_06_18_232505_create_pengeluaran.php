<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->uuid('id_pengeluaran')->primary();
            $table->tinyInteger('jenis_pengeluaran');
            $table->uuid('barang')->nullable();
            $table->foreign('barang')->references('id_persediaan')->on('persediaan')->onDelete('set null');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->string('deskripsi');
            $table->timestamp('tanggal_pengeluaran');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pengeluaran');
    }
};
