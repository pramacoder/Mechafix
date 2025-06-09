<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\HariLibur;
use App\Models\PlatKendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingServiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookings = BookingService::where('id_konsumen', Auth::user()->konsumen->id_konsumen)
            ->with(['platKendaraan', 'mekanik.user'])
            ->latest()
            ->get();

        return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        // Get user's vehicles - Simple belongsTo relationship
        $userVehicles = PlatKendaraan::where('id_konsumen', Auth::user()->konsumen->id_konsumen)->get();

        return view('booking.create', compact('userVehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_plat_kendaraan' => 'required|exists:plat_kendaraan,id_plat_kendaraan',
            'tanggal_booking' => [
                'required',
                'date',
                'after:today',
                'before_or_equal:' . now()->addMonths(3)->format('Y-m-d'),
                function ($attribute, $value, $fail) {
                    if (HariLibur::isHoliday($value)) {
                        $holidayName = HariLibur::getHolidayName($value);
                        $fail("Tanggal {$value} adalah hari libur ({$holidayName}). Silakan pilih tanggal lain.");
                    }
                },
            ],
            'estimasi_kedatangan' => 'required',
            'keluhan_konsumen' => 'required|string|max:1000',
        ]);

        // Verify vehicle belongs to user
        $vehicle = PlatKendaraan::where('id_konsumen', Auth::user()->konsumen->id_konsumen)
            ->where('id_plat_kendaraan', $request->id_plat_kendaraan)
            ->first();

        if (!$vehicle) {
            return back()->with('error', 'Selected vehicle does not belong to you.');
        }

        // Create booking
        $booking = BookingService::create([
            'tanggal_booking' => $request->tanggal_booking,
            'estimasi_kedatangan' => $request->estimasi_kedatangan,
            'keluhan_konsumen' => $request->keluhan_konsumen,
            'status_booking' => 'menunggu',
            'id_konsumen' => Auth::user()->konsumen->id_konsumen,
            'id_plat_kendaraan' => $request->id_plat_kendaraan,
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking submitted successfully! We will contact you soon.');
    }

    public function cancel(BookingService $booking)
    {
        // Check ownership
        if ($booking->id_konsumen !== Auth::user()->konsumen->id_konsumen) {
            abort(403);
        }

        // Check cancel deadline (3 days before)
        $cancelDeadline = Carbon::parse($booking->tanggal_booking)->subDays(3);

        if (now() > $cancelDeadline) {
            return back()->with('error', 'Cannot cancel booking. Cancellation must be done at least 3 days before the booking date.');
        }

        if ($booking->status_booking !== 'menunggu') {
            return back()->with('error', 'Can only cancel pending bookings.');
        }

        $booking->update(['status_booking' => 'batal']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
