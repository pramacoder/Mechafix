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
        Schema::create('transaksi_services', function (Blueprint $table) {
            $table->id('id_transaksi_service');
            $table->unsignedBigInteger('id_service');
            $table->unsignedBigInteger('id_booking_service')->nullable();
            $table->integer('kuantitas_service');
            $table->bigInteger('subtotal_service')->default(0);
            $table->unsignedBigInteger('id_pembayaran')->nullable();

            $table->timestamps();

            // foreign key
            $table->foreign('id_service')->references('id_service')->on('services')->onDelete('cascade');
            $table->foreign('id_booking_service')->references('id_booking_service')->on('booking_services')->onDelete('set null');
            $table->foreign('id_pembayaran')->references('id_pembayaran')->on('pembayarans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_services');
    }
};