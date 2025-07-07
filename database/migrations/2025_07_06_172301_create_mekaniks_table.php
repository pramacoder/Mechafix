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
        Schema::create('mekaniks', function (Blueprint $table) {
            $table->id('id_mekanik');
            $table->string('nama_mekanik');
            $table->integer('kuantitas_hari')->default(0);
            $table->unsignedBigInteger('user_id')->nullable(); // jika ingin relasi ke users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mekaniks');
    }
};
