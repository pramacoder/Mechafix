<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\BookingService;
use App\Models\Mekanik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class KonsumenController extends Controller
{
    public function uploadBuktiPembayaran(Request $request, Pembayaran $pembayaran)
    {
        try {
            Log::info('Upload bukti pembayaran - Payment ID: ' . $pembayaran->id_pembayaran);

            // Pastikan pembayaran milik konsumen yang login
            if ($pembayaran->bookingService->id_konsumen !== auth()->user()->konsumen->id_konsumen) {
                Log::error('Unauthorized: Payment not belongs to logged user');
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            $request->validate([
                'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Hapus file lama jika ada
            if ($pembayaran->bukti_pembayaran && $pembayaran->bukti_pembayaran !== 'cash_payment_confirmed') {
                Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
            }

            // Upload file baru
            $file = $request->file('bukti_pembayaran');
            $filename = 'bukti_' . $pembayaran->id_pembayaran . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            // Update pembayaran
            $pembayaran->update([
                'bukti_pembayaran' => $path
            ]);

            Log::info('Bukti pembayaran uploaded: ' . $path);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
        } catch (\Exception $e) {
            Log::error('Error uploading bukti pembayaran: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal upload bukti pembayaran: ' . $e->getMessage());
        }
    }

    public function cashPayment(Request $request, Pembayaran $pembayaran)
    {
        try {
            Log::info('Cash payment confirmation - Payment ID: ' . $pembayaran->id_pembayaran);
            Log::info('Konsumen ID from pembayaran: ' . $pembayaran->bookingService->id_konsumen);
            Log::info('Auth konsumen ID: ' . auth()->user()->konsumen->id_konsumen);

            // Pastikan pembayaran milik konsumen yang login
            if ($pembayaran->bookingService->id_konsumen !== auth()->user()->konsumen->id_konsumen) {
                Log::error('Unauthorized: Payment not belongs to logged user');
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            // Pastikan status pembayaran masih belum dibayar
            if ($pembayaran->status_pembayaran === 'Sudah Dibayar') {
                return redirect()->back()->with('error', 'Pembayaran sudah lunas.');
            }

            // Update bukti pembayaran dengan marker cash payment
            $pembayaran->update([
                'bukti_pembayaran' => 'cash_payment_confirmed'
            ]);

            Log::info('Cash payment confirmed for payment: ' . $pembayaran->id_pembayaran);

            return redirect()->back()->with('success', 'Konfirmasi pembayaran tunai berhasil! Silakan bayar ke admin/kasir dengan total Rp ' . number_format($pembayaran->total_pembayaran, 0, ',', '.'));
        } catch (\Exception $e) {
            Log::error('Error confirming cash payment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal konfirmasi pembayaran: ' . $e->getMessage());
        }
    }

    public function cancelBooking(Request $request, BookingService $booking)
    {
        try {
            Log::info('Cancel booking - Booking ID: ' . $booking->id_booking_service);

            // Pastikan booking milik konsumen yang login
            if ($booking->id_konsumen !== auth()->user()->konsumen->id_konsumen) {
                Log::error('Unauthorized: Booking not belongs to logged user');
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            // Pastikan status masih menunggu dan sudah >= 3 hari
            if ($booking->status_booking !== 'menunggu') {
                return redirect()->back()->with('error', 'Booking tidak dapat dibatalkan.');
            }

            if (now()->diffInDays($booking->tanggal_booking, false) < 3) {
                return redirect()->back()->with('error', 'Booking hanya dapat dibatalkan jika sudah 3 hari tidak ada respon.');
            }

            // Update status booking
            $booking->update([
                'status_booking' => 'batal'
            ]);

            Log::info('Booking cancelled: ' . $booking->id_booking_service);

            return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
        } catch (\Exception $e) {
            Log::error('Error cancelling booking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membatalkan booking: ' . $e->getMessage());
        }
    }

    public function mekanikProfile(Mekanik $mekanik)
    {
        try {
            // Load relationships yang diperlukan
            $mekanik->load([
                'user',
                'bookingServices.platKendaraan',
                'bookingServices.transaksiServices.service',
                'riwayatPerbaikans.platKendaraan'
            ]);

            // Get basic statistics
            $stats = [
                'total_jobs' => $mekanik->bookingServices()->count(),
                'completed_jobs' => $mekanik->bookingServices()->where('status_booking', 'selesai')->count(),
                'active_jobs' => $mekanik->bookingServices()->where('status_booking', 'dikonfirmasi')->count(),
                'pending_jobs' => $mekanik->bookingServices()->where('status_booking', 'menunggu')->count(),
                'working_days' => $mekanik->created_at ? now()->diffInDays($mekanik->created_at) : 0,
                'working_months' => $mekanik->created_at ? now()->diffInMonths($mekanik->created_at) : 0,
            ];

            // Get recent work history (hanya untuk konsumen yang login)
            $myBookings = $mekanik->bookingServices()
                ->where('id_konsumen', auth()->user()->konsumen->id_konsumen)
                ->with(['platKendaraan', 'transaksiServices.service', 'pembayarans'])
                ->latest()
                ->take(5)
                ->get();

            // Get specialties dari services yang pernah dikerjakan
            $specialties = $mekanik->bookingServices()
                ->with('transaksiServices.service')
                ->get()
                ->flatMap(function($booking) {
                    return $booking->transaksiServices->pluck('service.kategori_service');
                })
                ->filter()
                ->unique()
                ->take(5)
                ->toArray();

            // Performance metrics
            $performance = [
                'completion_rate' => $stats['total_jobs'] > 0 ? round(($stats['completed_jobs'] / $stats['total_jobs']) * 100) : 0,
                'avg_jobs_per_month' => $stats['working_months'] > 0 ? round($stats['total_jobs'] / $stats['working_months'], 1) : 0,
                'total_revenue' => $mekanik->bookingServices()
                    ->whereHas('pembayarans', function($q) {
                        $q->where('status_pembayaran', 'Sudah Dibayar');
                    })
                    ->with('pembayarans')
                    ->get()
                    ->sum(function($booking) {
                        return $booking->pembayarans->first()->total_pembayaran ?? 0;
                    })
            ];

            return view('konsumen.mekanik-profile', compact(
                'mekanik', 
                'stats', 
                'myBookings', 
                'specialties',
                'performance'
            ));

        } catch (\Exception $e) {
            Log::error('Error loading mechanic profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load mechanic profile.');
        }
    }
}