<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id_faktur');
            $table->string('nama_faktur');
            $table->string('handle_faktur');
            $table->uuid('id_pendapatan');
            $table->string('email_handle_faktur');
            $table->timestamps();
            $table->foreign('id_pendapatan')->references('id_pendapatan')->on('pendapatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
