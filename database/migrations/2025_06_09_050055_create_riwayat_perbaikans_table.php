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
        Schema::create('riwayat_perbaikans', function (Blueprint $table) {
            $table->id('id_riwayat_perbaikan');
            $table->date('tanggal_perbaikan');
            $table->text('deskripsi_perbaikan');
            $table->string('dokumentasi_perbaikan');
            $table->date('next_service');
            $table->unsignedBigInteger('id_plat_kendaraan');
            $table->unsignedBigInteger('id_mekanik');
            $table->unsignedBigInteger('id_pembayaran');
            $table->timestamps();

            // foreign keys
            $table->foreign('id_plat_kendaraan')->references('id_plat_kendaraan')->on('plat_kendaraans')->onDelete('cascade');
            $table->foreign('id_mekanik')->references('id_mekanik')->on('mekaniks')->onDelete('cascade');
            $table->foreign('id_pembayaran')->references('id_pembayaran')->on('pembayarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_perbaikans');
    }
};