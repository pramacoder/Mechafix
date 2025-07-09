<?php

use App\Http\Controllers\BookingServiceController;
use App\Http\Controllers\Auth\WebLoginController;
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
Route::get('/guest/services', fn() => view('guest.services'))->name('guest.services');
Route::get('/guest/part_shop', fn() => view('guest.part_shop'))->name('guest.part_shop');
Route::get('/guest/our_profile', fn() => view('guest.our_profile'))->name('guest.our_profile');
Route::get('/guest/chat_contact', fn() => view('guest.chat_contact'))->name('guest.chat_contact');
Route::get('/guest/history', fn() => view('guest.history'))->name('guest.history');

// Auth routes
// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

// Route::middleware('guest')->group(function () {
//     // Login routes
//     Route::get('/login', [WebLoginController::class, 'create'])->name('login');
//     Route::post('/login', [WebLoginController::class, 'store']);

//     // Register routes
//     Route::get('/register', [WebLoginController::class, 'showRegisterForm'])->name('register');
//     Route::post('/register', [WebLoginController::class, 'store']);
// });

// Route::post('/logout', [WebLoginController::class, 'destroy'])->name('logout')->middleware('auth');
// Dashboard route - redirect berdasarkan role
Route::get('/dashboard', function () {
    $user = auth('web')->user();

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

        Route::get('/konsumen/mekanik/{mekanik}/profile', [KonsumenController::class, 'mekanikProfile'])->name('konsumen.mekanik-profile');

        // Konsumen pages
        Route::get('/konsumen/home', fn() => view('konsumen.home'))->name('konsumen.home');
        Route::get('/konsumen/services', fn() => view('konsumen.services'))->name('konsumen.services');
        Route::get('/konsumen/part_shop', [SparePartController::class, 'index'])->name('konsumen.part_shop');
        Route::get('/konsumen/our_profile', fn() => view('konsumen.our_profile'))->name('konsumen.our_profile');
        Route::get('/konsumen/history', fn() => view('konsumen.history'))->name('konsumen.history');
        Route::get('/konsumen/billing', fn() => view('konsumen.billing'))->name('konsumen.billing');

        // Chat routes untuk konsumen - PERBAIKAN ROUTE
        Route::prefix('konsumen/chat')->name('filachat.')->group(function () {
            // Chat index/contact list
            Route::get('/', [FilachatController::class, 'chatIndex'])->name('index');
            Route::get('/contact', [FilachatController::class, 'chatIndex'])->name('contact'); // alias untuk chat_contact

            // Chat dengan admin
            Route::get('/admin/{admin}', [FilachatController::class, 'showAdminChat'])->name('admin.show');
            Route::post('/admin/{admin}/send', [FilachatController::class, 'sendAdminMessage'])->name('admin.send');

            // Chat dengan mekanik
            Route::get('/mekanik/{mekanik}', [FilachatController::class, 'showMekanikChat'])->name('show');
            Route::post('/mekanik/{mekanik}/send', [FilachatController::class, 'sendMekanikMessage'])->name('send');
        });

        // Backward compatibility routes
        Route::get('/konsumen/chat_contact', [FilachatController::class, 'chatIndex'])->name('konsumen.chat_contact');
        Route::get('/konsumen/chat', [FilachatController::class, 'chatIndex'])->name('konsumen.chat');

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

    // ===============================
    // NOTIFICATION ROUTES - DIPERBAIKI DAN DILENGKAPI
    // ===============================
    Route::prefix('notifications')->name('notifications.')->group(function () {
        // Mark single notification as read
        Route::post('/mark-read/{id}', function ($id) {
            try {
                $notification = auth('web')->user()->notifications()->where('id', $id)->first();
                if ($notification) {
                    $notification->markAsRead();
                    return response()->json([
                        'success' => true,
                        'message' => 'Notifikasi berhasil ditandai sebagai sudah dibaca'
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Notifikasi tidak ditemukan'
                ], 404);
            } catch (\Exception $e) {
                \Log::error('Error marking notification as read:', [
                    'notification_id' => $id,
                    'user_id' => auth('web')->id(),
                    'error' => $e->getMessage()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menandai notifikasi'
                ], 500);
            }
        })->name('mark-read');

        // Mark all notifications as read
        Route::post('/mark-all-read', function () {
            try {
                $user = auth('web')->user();
                $count = $user->unreadNotifications()->count();
                $user->unreadNotifications->markAsRead();

                return response()->json([
                    'success' => true,
                    'message' => "Berhasil menandai {$count} notifikasi sebagai sudah dibaca",
                    'count' => $count
                ]);
            } catch (\Exception $e) {
                \Log::error('Error marking all notifications as read:', [
                    'user_id' => auth('web')->id(),
                    'error' => $e->getMessage()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menandai semua notifikasi'
                ], 500);
            }
        })->name('mark-all-read');

        // Get notification count
        Route::get('/count', function () {
            try {
                $count = auth('web')->user()->unreadNotifications()->count();
                return response()->json([
                    'success' => true,
                    'count' => $count
                ]);
            } catch (\Exception $e) {
                \Log::error('Error getting notification count:', [
                    'user_id' => auth('web')->id(),
                    'error' => $e->getMessage()
                ]);
                return response()->json([
                    'success' => false,
                    'count' => 0
                ]);
            }
        })->name('count');

        // Get latest notifications (AJAX)
        Route::get('/latest', function () {
            try {
                $notifications = auth('web')->user()
                    ->unreadNotifications()
                    ->limit(10)
                    ->get()
                    ->map(function ($notif) {
                        return [
                            'id' => $notif->id,
                            'title' => $notif->data['title'] ?? 'Notifikasi Baru',
                            'message' => $notif->data['message'] ?? $notif->type,
                            'type' => $notif->type,
                            'created_at' => $notif->created_at->diffForHumans(),
                            'data' => $notif->data
                        ];
                    });

                return response()->json([
                    'success' => true,
                    'notifications' => $notifications,
                    'count' => $notifications->count()
                ]);
            } catch (\Exception $e) {
                \Log::error('Error getting latest notifications:', [
                    'user_id' => auth('web')->id(),
                    'error' => $e->getMessage()
                ]);
                return response()->json([
                    'success' => false,
                    'notifications' => [],
                    'count' => 0
                ]);
            }
        })->name('latest');

        // View all notifications page
        Route::get('/all', function () {
            try {
                $notifications = auth('web')->user()
                    ->notifications()
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);

                return view('dashboard.all-notifications', compact('notifications'));
            } catch (\Exception $e) {
                \Log::error('Error loading all notifications page:', [
                    'user_id' => auth('web')->id(),
                    'error' => $e->getMessage()
                ]);
                return redirect()->back()->with('error', 'Gagal memuat halaman notifikasi');
            }
        })->name('all');

        // Delete single notification
        Route::delete('/delete/{id}', function ($id) {
            try {
                $notification = auth('web')->user()->notifications()->where('id', $id)->first();
                if ($notification) {
                    $notification->delete();
                    return response()->json([
                        'success' => true,
                        'message' => 'Notifikasi berhasil dihapus'
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Notifikasi tidak ditemukan'
                ], 404);
            } catch (\Exception $e) {
                \Log::error('Error deleting notification:', [
                    'notification_id' => $id,
                    'user_id' => auth('web')->id(),
                    'error' => $e->getMessage()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus notifikasi'
                ], 500);
            }
        })->name('delete');

        // Clear all notifications
        Route::delete('/clear-all', function () {
            try {
                $user = auth('web')->user();
                $count = $user->notifications()->count();
                $user->notifications()->delete();

                return response()->json([
                    'success' => true,
                    'message' => "Berhasil menghapus {$count} notifikasi",
                    'count' => $count
                ]);
            } catch (\Exception $e) {
                \Log::error('Error clearing all notifications:', [
                    'user_id' => auth('web')->id(),
                    'error' => $e->getMessage()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus semua notifikasi'
                ], 500);
            }
        })->name('clear-all');
    });

    // Legacy notification route (untuk backward compatibility)
    Route::post('/notifications/mark-read/{id}', function ($id) {
        return redirect()->route('notifications.mark-read', $id);
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

    // API Notifications untuk mobile atau AJAX
    Route::prefix('notifications')->group(function () {
        Route::get('/', function () {
            $notifications = auth('web')->user()
                ->notifications()
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
            return response()->json(['data' => $notifications]);
        });

        Route::get('/unread', function () {
            $notifications = auth('web')->user()
                ->unreadNotifications()
                ->orderBy('created_at', 'desc')
                ->get();
            return response()->json(['data' => $notifications]);
        });
    });
});

Route::get('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login');
})->name('logout');

// Legacy/backward compatibility routes
Route::get('/dashboard/konsumen', function () {
    return redirect()->route('dashboard.konsumen');
})->middleware('auth');

Route::get('/dashboard/mekanik', function () {
    return redirect()->route('dashboard.mekanik');
})->middleware('auth');

// Tambahan route untuk booking service yang mungkin diperlukan
Route::get('/booking-service/create', [BookingServiceController::class, 'create'])->name('booking-service.create');
Route::post('/booking-service', [BookingServiceController::class, 'store'])->name('booking-service.store');
