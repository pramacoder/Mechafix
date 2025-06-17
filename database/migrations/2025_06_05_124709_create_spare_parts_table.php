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
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id('id_barang');
            $table->string('nama_barang');
            $table->text('deskripsi_barang');
            $table->bigInteger('harga_barang');
            $table->integer('kuantitas_barang');
            $table->string('gambar_barang');
            $table->string('link_shopee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spare_parts');
    }
};