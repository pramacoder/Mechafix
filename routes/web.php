<?php

use App\Http\Controllers\BookingServiceController;
use App\Http\Controllers\FilachatController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\PlatKendaraanController;
use App\Models\FilachatAgent;
use App\Models\FilachatConversation;
use App\Models\PlatKendaraan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparePartController;

// Guest routes (untuk tamu yang belum login)
Route::get('/', fn() => view('guest.home'))->name('guest.home');
Route::get('/services', fn() => view('guest.services'))->name('guest.services');
Route::get('/part_shop', fn() => view('guest.part_shop'))->name('guest.part_shop');
Route::get('/our_profile', fn() => view('guest.our_profile'))->name('guest.our_profile');
Route::get('/chat_contact', fn() => view('guest.chat_contact'))->name('guest.chat_contact');
Route::get('/history', fn() => view('guest.history'))->name('guest.history');

// Konsumen routes (untuk user yang sudah login)
Route::get('/konsumen/home', fn() => view('konsumen.home'))->name('konsumen.home');
Route::get('/konsumen/services', fn() => view('konsumen.services'))->name('konsumen.services');
Route::get('/konsumen/part_shop', fn() => view('konsumen.part_shop'))->name('konsumen.part_shop');
Route::get('/konsumen/our_profile', fn() => view('konsumen.our_profile'))->name('konsumen.our_profile');
Route::get('/konsumen/chat_contact', fn() => view('konsumen.chat_contact'))->name('konsumen.chat_contact');
Route::get('/konsumen/history', fn() => view('konsumen.history'))->name('konsumen.history');
Route::get('/konsumen/billing', fn() => view('konsumen.billing'))->name('konsumen.billing');
Route::get('/pricelist', [KonsumenController::class, 'pricelist'])->name('pricelist');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard utama - content berbeda berdasarkan role
    Route::get('/dashboard', function () {
        $data = [];
        if (Auth::user()->isMekanik()) {
            $user = Auth::user();
            $mekanikAgent = FilachatAgent::firstOrCreate([
                'agentable_id' => $user->id,
                'agentable_type' => get_class($user),
                'role' => 'mekanik',
            ]);
            $conversations = FilachatConversation::where('receiverable_id', $mekanikAgent->id)
                ->where('receiverable_type', get_class($mekanikAgent))
                ->with(['sender.agentable', 'messages' => fn($q) => $q->orderBy('created_at', 'asc')])
                ->get()
                ->sortByDesc(fn($conv) => optional($conv->messages->last())->created_at);
            $data['conversations'] = $conversations;
        }
        return view('dashboard.konsumen', $data);
    })->name('dashboard.konsumen');

    // Konsumen routes
    Route::middleware('role:konsumen')->group(function () {
        Route::get('/dashboard/konsumen', function () {
            return view('dashboard.konsumen');
        })->name('dashboard.konsumen');
        Route::get('/konsumen/profile', function () {
            return view('profile.show');
        })->name('konsumen.profile');
        Route::resource('platkendaraan', PlatKendaraanController::class)->except(['show']);
        Route::get('/my-platkendaraan', [PlatKendaraanController::class, 'index'])->name('platkendaraan.index');
        Route::get('/booking/create', [BookingServiceController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingServiceController::class, 'store'])->name('booking.store');
        Route::patch('/booking/{booking}/cancel', [KonsumenController::class, 'cancelBooking'])->name('konsumen.cancel-booking');
        Route::post('/konsumen/payment/{pembayaran}/cash', [KonsumenController::class, 'cashPayment'])->name('konsumen.cash-payment');
        Route::post('/konsumen/payment/{pembayaran}/upload-bukti', [KonsumenController::class, 'uploadBuktiPembayaran'])->name('konsumen.upload-bukti');
        Route::get('/mekanik/{mekanik}/profile', [KonsumenController::class, 'mekanikProfile'])->name('konsumen.mekanik-profile');
        Route::get('/platkendaraan/{id}/history', [PlatKendaraanController::class, 'history'])->name('platkendaraan.history');
        Route::get('/konsumen/part_shop', [\App\Http\Controllers\SparePartController::class, 'index'])->name('konsumen.part_shop');
    });

    // Mekanik routes
    Route::middleware('role:mekanik')->prefix('mekanik')->group(function () {
        Route::get('/dashboard', [MekanikController::class, 'dashboard'])->name('mekanik.dashboard');
        Route::patch('/booking/{booking}/services', [MekanikController::class, 'saveServices'])->name('mekanik.save-services');
        Route::match(['get', 'post'], '/booking/{booking}/complete', [MekanikController::class, 'completeJob'])->name('mekanik.complete-job'); 
        // ini
    });
});

// Chat routes
Route::prefix('mekanik')->group(function () {
    Route::get('{mekanik}/chat', [FilachatController::class, 'showChat'])->name('filachat.show');
    Route::post('{mekanik}/chat', [FilachatController::class, 'sendMessage'])->name('filachat.send');
});

Route::prefix('admin')->group(function () {
    Route::get('{admin}/chat', [FilachatController::class, 'showChat'])->name('filachat.show');
    Route::post('{admin}/chat', [FilachatController::class, 'sendMessage'])->name('filachat.send');
});

Route::prefix('dashboard/mekanik')->group(function () {
    Route::get('chat', [FilachatController::class, 'mekanikInbox'])->name('filachat.mekanik.inbox');
    Route::get('chat/{conversation}', [FilachatController::class, 'mekanikChat'])->name('filachat.mekanik.chat');
    Route::post('chat/{conversation}', [FilachatController::class, 'mekanikReply'])->name('filachat.mekanik.reply');
});

Route::post('/notifications/mark-read/{id}', function($id) {
    $notif = auth()->user()->unreadNotifications()->find($id);
    if ($notif) $notif->markAsRead();
    return response()->json(['success' => true]);
})->middleware('auth');

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout')->middleware('auth');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Booking API Routes
Route::prefix('booking')->group(function () {
    // Get booking status by license plate number
    Route::get('status/{plateNumber}', [BookingController::class, 'getBookingStatus']);
    
    // Update booking status (protected route - requires authentication)
    Route::middleware('auth:sanctum')->put('status/{id}', [BookingController::class, 'updateBookingStatus']);
    
    // Get all bookings (protected route - requires authentication)
    Route::middleware('auth:sanctum')->get('all', [BookingController::class, 'getAllBookings']);
    
    // Get booking statistics (protected route - requires authentication)
    Route::middleware('auth:sanctum')->get('statistics', [BookingController::class, 'getBookingStatistics']);
});

// Public API Routes (no authentication required)
Route::get('booking-status/{plateNumber}', [BookingController::class, 'getBookingStatus']);

// Alternative routes for web requests
Route::prefix('v1')->group(function () {
    Route::get('booking-status/{plateNumber}', [BookingController::class, 'getBookingStatus']);
    Route::get('booking-statistics', [BookingController::class, 'getBookingStatistics']);
});

// Tambahan route agar dashboard.konsumen terdefinisi
Route::get('/dashboard/konsumen', function () {
    return view('dashboard.konsumen');
})->name('dashboard.konsumen');

Route::get('/booking-status/{plateNumber}', [BookingServiceController::class, 'getBookingStatus']);
Route::get('/konsumen/part_shop', [SparePartController::class, 'index'])->name('konsumen.part_shop');

// Chat dengan mekanik
Route::get('mekanik/{mekanik}/chat', [FilachatController::class, 'showChat'])->name('filachat.show');
// Chat dengan admin
Route::middleware(['auth', 'role:konsumen'])->group(function () {
    Route::get('admin/{admin}/chat', [\App\Http\Controllers\FilachatController::class, 'showAdminChat'])->name('filachat.admin.show');
    Route::post('admin/{admin}/chat', [\App\Http\Controllers\FilachatController::class, 'sendAdminMessage'])->name('filachat.admin.send');
});