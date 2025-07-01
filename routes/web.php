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

Route::get('/', fn() => view('konsumen.home'));
Route::get('/services', fn() => view('konsumen.services'))->name('services');
Route::get('/part_shop', fn() => view('konsumen.part_shop'))->name('part_shop');
Route::get('/history', fn() => view('konsumen.history'))->name('history');
Route::get('/billing', fn() => view('konsumen.billing'))->name('billing');

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
        return view('dashboard', $data);
    })->name('dashboard');

    // Konsumen routes
    Route::middleware('role:konsumen')->group(function () {
        Route::resource('platkendaraan', PlatKendaraanController::class)->except(['show']);
        Route::get('/my-platkendaraan', [PlatKendaraanController::class, 'index'])->name('platkendaraan.index');
        Route::get('/booking/create', [BookingServiceController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingServiceController::class, 'store'])->name('booking.store');
        Route::patch('/booking/{booking}/cancel', [KonsumenController::class, 'cancelBooking'])->name('konsumen.cancel-booking');
        Route::post('/konsumen/payment/{pembayaran}/cash', [KonsumenController::class, 'cashPayment'])->name('konsumen.cash-payment');
        Route::post('/konsumen/payment/{pembayaran}/upload-bukti', [KonsumenController::class, 'uploadBuktiPembayaran'])->name('konsumen.upload-bukti');
        Route::get('/mekanik/{mekanik}/profile', [KonsumenController::class, 'mekanikProfile'])->name('konsumen.mekanik-profile');
        Route::get('/platkendaraan/{id}/history', [PlatKendaraanController::class, 'history'])->name('platkendaraan.history');
    });

    // Mekanik routes
    Route::middleware('role:mekanik')->prefix('mekanik')->group(function () {
        Route::get('/dashboard', [MekanikController::class, 'dashboard'])->name('mekanik.dashboard');
        Route::patch('/booking/{booking}/services', [MekanikController::class, 'saveServices'])->name('mekanik.save-services');
        Route::match(['get', 'post'], '/booking/{booking}/complete', [MekanikController::class, 'completeJob'])->name('mekanik.complete-job');
    });
});

// Chat routes
Route::prefix('mekanik')->group(function () {
    Route::get('{mekanik}/chat', [FilachatController::class, 'showChat'])->name('filachat.show');
    Route::post('{mekanik}/chat', [FilachatController::class, 'sendMessage'])->name('filachat.send');
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


