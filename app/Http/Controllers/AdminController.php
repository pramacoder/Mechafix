<?php
// filepath: c:\laragon\www\Mechafix\app\Http\Controllers\AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Mekanik;
use App\Models\BookingService;
use App\Models\PlatKendaraan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_konsumen' => User::whereHas('konsumen')->count(),
            'total_mekanik' => User::whereHas('mekanik')->count(),
            'total_bookings' => BookingService::count(),
            'pending_bookings' => BookingService::where('status_booking', 'menunggu')->count(),
            'total_vehicles' => PlatKendaraan::count(),
            'total_services' => Service::count(),
        ];

        $recentBookings = BookingService::with(['konsumen.user', 'platKendaraan', 'mekanik.user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }

    public function users()
    {
        $users = User::with(['konsumen', 'mekanik'])->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function mekaniks()
    {
        $mekaniks = Mekanik::with('user')->get();
        return view('admin.mekaniks.index', compact('mekaniks'));
    }

    public function bookings()
    {
        $bookings = BookingService::with(['konsumen.user', 'platKendaraan', 'mekanik.user'])
            ->latest()
            ->get();
        return view('admin.bookings.index', compact('bookings'));
    }
}