<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_lists', function (Blueprint $table) {
            $table->id();
            $table->string('id_user');
            $table->string('full_name');
            $table->string('plat_kendaraan');
            $table->string('id_booking');
            $table->date('tgl_booking');
            $table->string('kendaraan');
            $table->integer('cc_kendaraan');
            $table->text('note')->nullable();
            $table->string('estimate_time');
            $table->string('mechanic')->nullable();
            $table->json('service_items');
            $table->decimal('total_price', 10, 0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_lists');
    }
};
