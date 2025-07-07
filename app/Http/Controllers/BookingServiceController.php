<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use App\Models\BookingService;
use App\Models\HariLibur;
use App\Models\Mekanik;
use App\Models\PlatKendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingServiceController extends Controller
{
    public function getBookingStatus($plateNumber): JsonResponse
    {
        try {
            $normalizedPlate = strtoupper(str_replace(' ', '', $plateNumber));
            $platKendaraan = PlatKendaraan::whereRaw("REPLACE(UPPER(nomor_plat_kendaraan), ' ', '') = ?", [$normalizedPlate])->first();

            if (!$platKendaraan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plat nomor tidak ditemukan'
                ], 404);
            }
            $booking = BookingService::with(['konsumen', 'platKendaraan', 'mekanik'])
            ->where('id_plat_kendaraan', $platKendaraan->id_plat_kendaraan)
            ->orderBy('created_at', 'desc')
            ->first();


            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada booking untuk plat nomor ini'
                ], 404);
            }
            $estimatedCompletion = null;
            $remainingTime = null;
            if ($booking->status_booking === 'dikonfirmasi') {
                $confirmationTime = Carbon::parse($booking->updated_at);
                $estimatedCompletion = $confirmationTime->copy()->addHours(48);
                $remainingTime = $estimatedCompletion->diffInSeconds(now());
                if ($remainingTime < 0) $remainingTime = 0;
            }
            // ...lanjutkan response sukses seperti biasa...
            return response()->json([
                'success' => true,
                'booking' => [
                    'id_booking_service' => $booking->id_booking_service,
                    'tanggal_booking' => $booking->tanggal_booking,
                    'estimasi_kedatangan' => $booking->estimasi_kedatangan,
                    'keluhan_konsumen' => $booking->keluhan_konsumen,
                    'status_booking' => $booking->status_booking,
                    'created_at' => $booking->created_at,
                    'updated_at' => $booking->updated_at,
                    'konsumen' => $booking->konsumen,
                    'plat_kendaraan' => $booking->platKendaraan,
                    'mekanik' => $booking->mekanik,
                    // tambahkan field lain jika perlu
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
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
        $user = auth()->user();
        $userVehicles = \App\Models\PlatKendaraan::where('id_konsumen', $user->konsumen->id_konsumen)->get();
        return view('booking.create', compact('userVehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_plat_kendaraan' => 'required|exists:plat_kendaraans,id_plat_kendaraan',
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

        return redirect()->route('dashboard.konsumen')->with('success', 'Booking submitted successfully! We will contact you soon.');
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
    /**
     * Get booking status by license plate number
     */


    /**
     * Update booking status
     */
    public function updateBookingStatus(Request $request, $id): JsonResponse
    {
        
        $request->validate([
            'status' => 'required|in:menunggu,dikonfirmasi,selesai,batal'
        ]);

        try {
            $booking = BookingService::findOrFail($id);
            
            $oldStatus = $booking->status_booking;
            $booking->status_booking = $request->status;
            
            // If status is changing to 'dikonfirmasi', update the timestamp
            if ($oldStatus !== 'dikonfirmasi' && $request->status === 'dikonfirmasi') {
                $booking->updated_at = Carbon::now();
            }
            
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'booking' => $booking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    /**
     * Get all bookings (for admin dashboard)
     */
    public function getAllBookings(): JsonResponse
    {
        try {
            $bookings = BookingService::with(['konsumen', 'platKendaraan', 'mekanik'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'bookings' => $bookings
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch bookings'
            ], 500);
        }
    }
    public function services()
    {
        $user = Auth::user();
        $userVehicles = $user && $user->konsumen ? $user->konsumen->platKendaraan ?? collect() : collect();
        return view('konsumen.services', compact('userVehicles'));
    }
    /**
     * Get booking statistics
     */
    public function getBookingStatistics(): JsonResponse
    {
        try {
            $stats = [
                'total_bookings' => BookingService::count(),
                'pending_bookings' => BookingService::where('status_booking', 'menunggu')->count(),
                'confirmed_bookings' => BookingService::where('status_booking', 'dikonfirmasi')->count(),
                'completed_bookings' => BookingService::where('status_booking', 'selesai')->count(),
                'cancelled_bookings' => BookingService::where('status_booking', 'batal')->count(),
                'average_completion_time' => $this->calculateAverageCompletionTime(),
                'accuracy_percentage' => $this->calculateAccuracyPercentage()
            ];

            return response()->json([
                'success' => true,
                'statistics' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics'
            ], 500);
        }
    }

    /**
     * Calculate average completion time
     */
    private function calculateAverageCompletionTime()
    {
        // This is a simplified calculation
        // In a real scenario, you'd track when status changes occur
        $completedBookings = BookingService::where('status_booking', 'selesai')
            ->select('created_at', 'updated_at')
            ->get();

        if ($completedBookings->isEmpty()) {
            return 0;
        }

        $totalHours = 0;
        foreach ($completedBookings as $booking) {
            $totalHours += Carbon::parse($booking->created_at)
                ->diffInHours(Carbon::parse($booking->updated_at));
        }

        return round($totalHours / $completedBookings->count(), 1);
    }

    /**
     * Calculate accuracy percentage
     */
    private function calculateAccuracyPercentage()
    {
        // This is a simplified calculation
        // In production, you'd track actual vs estimated completion times
        $completedBookings = BookingService::where('status_booking', 'selesai')->count();
        $totalBookings = BookingService::whereIn('status_booking', ['selesai', 'dikonfirmasi'])->count();

        if ($totalBookings === 0) {
            return 0;
        }

        // Assuming 95% accuracy for completed bookings
        return round(($completedBookings / $totalBookings) * 95, 1);
    }
}