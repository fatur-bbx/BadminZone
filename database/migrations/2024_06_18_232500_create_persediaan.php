<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persediaan', function (Blueprint $table) {
            $table->uuid('id_persediaan')->primary();
            $table->string('nama_barang');
            $table->integer('harga_pcs');
            $table->integer('jumlah_persediaan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('persediaan');
    }
};
