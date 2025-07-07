<?php

use App\Http\Controllers\BookingServiceController;
use App\Http\Controllers\FilachatController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\PlatKendaraanController;
use App\Http\Controllers\SparePartController;
use App\Models\FilachatAgent;
use App\Models\FilachatConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Guest routes (untuk tamu yang belum login)
Route::get('/', fn() => view('guest.home'))->name('guest.home');
Route::get('/services', fn() => view('guest.services'))->name('guest.services');
Route::get('/part_shop', fn() => view('guest.part_shop'))->name('guest.part_shop');
Route::get('/our_profile', fn() => view('guest.our_profile'))->name('guest.our_profile');
Route::get('/chat_contact', fn() => view('guest.chat_contact'))->name('guest.chat_contact');
Route::get('/history', fn() => view('guest.history'))->name('guest.history');

// Auth routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Dashboard route - redirect berdasarkan role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'konsumen') {
        return redirect()->route('dashboard.konsumen');
    } elseif ($user->role === 'mekanik') {
        return redirect()->route('dashboard.mekanik');
    } elseif ($user->role === 'admin') {
        return redirect()->route('filament.admin.pages.dashboard');
    } else {
        return redirect()->route('filament.admin.pages.dashboard');
    }
})->middleware('auth')->name('dashboard');

// Protected routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Konsumen routes
    Route::middleware('role:konsumen')->group(function () {
        // Dashboard konsumen
        Route::get('/konsumen/dashboard', function () {
            return view('dashboard.konsumen');
        })->name('dashboard.konsumen');

        // Konsumen pages
        Route::get('/konsumen/home', fn() => view('konsumen.home'))->name('konsumen.home');
        Route::get('/konsumen/services', fn() => view('konsumen.services'))->name('konsumen.services');
        Route::get('/konsumen/part_shop', [SparePartController::class, 'index'])->name('konsumen.part_shop');
        Route::get('/konsumen/our_profile', fn() => view('konsumen.our_profile'))->name('konsumen.our_profile');
        Route::get('/konsumen/history', fn() => view('konsumen.history'))->name('konsumen.history');
        Route::get('/konsumen/billing', fn() => view('konsumen.billing'))->name('konsumen.billing');

        // Chat routes untuk konsumen - TAMBAHKAN ROUTE YANG HILANG
        Route::get('/konsumen/chat', [FilachatController::class, 'index'])->name('konsumen.chat');
        Route::get('/konsumen/chat_contact', [FilachatController::class, 'index'])->name('konsumen.chat_contact'); // Route yang hilang
        Route::get('/konsumen/chat/admin/{admin}', [FilachatController::class, 'showAdminChat'])->name('filachat.admin.show');
        Route::post('/konsumen/chat/admin/{admin}/send', [FilachatController::class, 'sendAdminMessage'])->name('filachat.admin.send');
        Route::get('/konsumen/chat/mekanik/{mekanik}', [FilachatController::class, 'showMekanikChat'])->name('filachat.show');
        Route::post('/konsumen/chat/mekanik/{mekanik}/send', [FilachatController::class, 'sendMekanikMessage'])->name('filachat.send');

        // Profile & vehicle management
        Route::get('/konsumen/profile', function () {
            return view('profile.show');
        })->name('konsumen.profile');

        Route::resource('platkendaraan', PlatKendaraanController::class)->except(['show']);
        Route::get('/my-platkendaraan', [PlatKendaraanController::class, 'index'])->name('platkendaraan.index');
        Route::get('/platkendaraan/{id}/history', [PlatKendaraanController::class, 'history'])->name('platkendaraan.history');

        // Booking routes
        Route::get('/booking/create', [BookingServiceController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingServiceController::class, 'store'])->name('booking.store');
        Route::patch('/booking/{booking}/cancel', [KonsumenController::class, 'cancelBooking'])->name('konsumen.cancel-booking');

        // Payment routes
        Route::post('/konsumen/payment/{pembayaran}/cash', [KonsumenController::class, 'cashPayment'])->name('konsumen.cash-payment');
        Route::post('/konsumen/payment/{pembayaran}/upload-bukti', [KonsumenController::class, 'uploadBuktiPembayaran'])->name('konsumen.upload-bukti');

        // Other routes
        Route::get('/pricelist', [KonsumenController::class, 'pricelist'])->name('pricelist');
        Route::get('/mekanik/{mekanik}/profile', [KonsumenController::class, 'mekanikProfile'])->name('konsumen.mekanik-profile');
    });

    // Mekanik routes
    Route::middleware('role:mekanik')->prefix('mekanik')->group(function () {
        // Dashboard mekanik
        Route::get('/dashboard', [MekanikController::class, 'dashboard'])->name('dashboard.mekanik');
        Route::patch('/booking/{booking}/services', [MekanikController::class, 'saveServices'])->name('mekanik.save-services');
        Route::match(['get', 'post'], '/booking/{booking}/complete', [MekanikController::class, 'completeJob'])->name('mekanik.complete-job');

        // Chat routes untuk mekanik
        Route::get('/chat', [FilachatController::class, 'mekanikInbox'])->name('filachat.mekanik.inbox');
        Route::get('/chat/{conversation}', [FilachatController::class, 'mekanikChat'])->name('filachat.mekanik.chat');
        Route::post('/chat/{conversation}', [FilachatController::class, 'mekanikReply'])->name('filachat.mekanik.reply');
    });

    // Notifications
    Route::post('/notifications/mark-read/{id}', function($id) {
        $notif = auth()->user()->unreadNotifications()->find($id);
        if ($notif) $notif->markAsRead();
        return response()->json(['success' => true]);
    });
});

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout')->middleware('auth');

// Public API Routes (no authentication required)
Route::prefix('api')->group(function () {
    Route::get('/booking-status/{plateNumber}', [BookingServiceController::class, 'getBookingStatus']);
    Route::get('/booking-statistics', [BookingServiceController::class, 'getBookingStatistics']);
});

// Protected API Routes
Route::middleware('auth:sanctum')->prefix('api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('booking')->group(function () {
        Route::put('/status/{id}', [BookingServiceController::class, 'updateBookingStatus']);
        Route::get('/all', [BookingServiceController::class, 'getAllBookings']);
    });
});

// Legacy/backward compatibility routes (redirect to new routes)
// PERBAIKAN: Ubah redirect untuk menggunakan route yang sudah ada
Route::get('/konsumen/chat_contact_old', function() {
    return redirect()->route('konsumen.chat_contact'); // Redirect ke route yang baru ditambahkan
})->middleware('auth');

// PERBAIKAN: gunakan route name yang benar
Route::get('/dashboard/konsumen', function() {
    return redirect()->route('dashboard.konsumen');
})->middleware('auth');

Route::get('/dashboard/mekanik', function() {
    return redirect()->route('dashboard.mekanik');
})->middleware('auth');

// Tambahan route untuk booking service yang mungkin diperlukan
Route::get('/booking-service/create', [BookingServiceController::class, 'create'])->name('booking-service.create');
Route::post('/booking-service', [BookingServiceController::class, 'store'])->name('booking-service.store');
