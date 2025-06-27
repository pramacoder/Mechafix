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
        Schema::create('transaksi_spare_parts', function (Blueprint $table) {
            $table->id('id_transaksi_barang');
            $table->unsignedBigInteger('id_barang');
            $table->integer('kuantitas_barang');
            $table->bigInteger('subtotal_barang')->default(0);
            $table->unsignedBigInteger('id_pembayaran')->nullable();
            $table->unsignedBigInteger('id_booking_service')->nullable();
            $table->timestamps();

            // foreign key
            $table->foreign('id_barang')->references('id_barang')->on('spare_parts')->onDelete('cascade');
            $table->foreign('id_pembayaran')->references('id_pembayaran')->on('pembayarans')->onDelete('set null');
            $table->foreign('id_booking_service')->references('id_booking_service')->on('booking_services')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_spare_parts');
    }
};