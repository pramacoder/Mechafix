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
        Schema::create('plat_kendaraans', function (Blueprint $table) {
            $table->id('id_plat_kendaraan');
            $table->string('nomor_plat_kendaraan')->unique();
            $table->string('cc_kendaraan');
            $table->unsignedBigInteger('id_konsumen');
            $table->timestamps();

            // foreign key
            $table->foreign('id_konsumen')->references('id_konsumen')->on('konsumens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plat_kendaraans');
    }
};