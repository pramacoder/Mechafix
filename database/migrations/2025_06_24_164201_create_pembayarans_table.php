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
            $table->bigInteger('total_pembayaran')->default(0);
            $table->string('qris');
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['Belum Dibayar', 'Sudah Dibayar'])->default('Belum Dibayar');
            $table->unsignedBigInteger('id_konsumen')->nullable();
            $table->timestamps();

            $table->foreign('id_konsumen')->references('id_konsumen')->on('konsumens')->onDelete('set null');
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