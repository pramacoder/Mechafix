<?php

use App\Http\Controllers\BookingServiceController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\PlatKendaraanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard utama - content berbeda berdasarkan role
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Routes untuk Konsumen
    Route::middleware(['role:konsumen'])->group(function () {
        // plat kendaraan
        Route::get('/my-platkendaraan', [PlatKendaraanController::class, 'index'])->name('platkendaraan.index');
        Route::get('/platkendaraan/create', [PlatKendaraanController::class, 'create'])->name('platkendaraan.create');
        Route::post('/platkendaraan', [PlatKendaraanController::class, 'store'])->name('platkendaraan.store');
        Route::get('/platkendaraan/{id_plat_kendaraan}/edit', [PlatKendaraanController::class, 'edit'])->name('platkendaraan.edit');
        Route::put('/platkendaraan/{id_plat_kendaraan}', [PlatKendaraanController::class, 'update'])->name('platkendaraan.update');
        Route::delete('/platkendaraan/{id_plat_kendaraan}', [PlatKendaraanController::class, 'destroy'])->name('platkendaraan.destroy');

        // booking services
        Route::get('/booking/create', [BookingServiceController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingServiceController::class, 'store'])->name('booking.store');
        Route::patch('/booking/{booking}/cancel', [KonsumenController::class, 'cancelBooking'])->name('konsumen.cancel-booking');

        // payments
        Route::post('/payment/{pembayaran}/upload-bukti', [KonsumenController::class, 'uploadBuktiPembayaran'])->name('konsumen.upload-bukti');
        Route::post('/payment/{pembayaran}/cash', [KonsumenController::class, 'cashPayment'])->name('konsumen.cash-payment');

        // saw mechanic profile
        Route::get('/mekanik/{mekanik}/profile', [KonsumenController::class, 'mekanikProfile'])->name('konsumen.mekanik-profile');
    });

    // Routes untuk Mekanik
    Route::middleware(['auth', 'role:mekanik'])->prefix('mekanik')->group(function () {
        Route::patch('/booking/{booking}/services', [MekanikController::class, 'saveServices'])->name('mekanik.save-services');
        Route::patch('/booking/{booking}/complete', [MekanikController::class, 'completeJob'])->name('mekanik.complete-job');
    });
});
