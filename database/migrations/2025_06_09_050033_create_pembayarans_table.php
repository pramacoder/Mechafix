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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->date('tanggal_pembayaran');
            $table->bigInteger('total_pembayaran');
            $table->string('qris');
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['Belum Dibayar', 'Sudah Dibayar'])->default('Belum Dibayar');
            $table->unsignedBigInteger('id_transaksi_barang')->nullable();
            $table->unsignedBigInteger('id_transaksi_service')->nullable();
            $table->unsignedBigInteger('id_booking_service')->nullable();
            $table->unsignedBigInteger('id_plat_kendaraan');
            $table->timestamps();

            // foreign keys
            $table->foreign('id_transaksi_barang')->references('id_transaksi_barang')->on('transaksi_spare_parts')->onDelete('cascade');
            $table->foreign('id_transaksi_service')->references('id_transaksi_service')->on('transaksi_services')->onDelete('cascade');
            $table->foreign('id_booking_service')->references('id_booking_service')->on('booking_services')->onDelete('cascade');
            $table->foreign('id_plat_kendaraan')->references('id_plat_kendaraan')->on('plat_kendaraans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};