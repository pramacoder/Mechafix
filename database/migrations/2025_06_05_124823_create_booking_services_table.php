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
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id('id_booking_service');
            $table->date('tanggal_booking');
            $table->time('estimasi_kedatangan');
            $table->text('keluhan_konsumen');
            $table->enum('status_booking', ['menunggu', 'dikonfirmasi', 'selesai', 'batal'])->default('menunggu');
            $table->unsignedBigInteger('id_konsumen');
            $table->unsignedBigInteger('id_plat_kendaraan');
            $table->timestamps();

            // foreign keys
            $table->foreign('id_konsumen')->references('id_konsumen')->on('konsumens')->onDelete('cascade');
            $table->foreign('id_plat_kendaraan')->references('id_plat_kendaraan')->on('plat_kendaraans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_services');
    }
};