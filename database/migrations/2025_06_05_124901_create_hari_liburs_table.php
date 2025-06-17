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
        Schema::create('hari_libur', function (Blueprint $table) {
            $table->id('id_hari_libur');
            $table->string('nama_hari_libur');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('id_admin');
            $table->timestamps();

            // foreign key
            $table->foreign('id_admin')->references('id_admin')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hari_liburs');
    }
};