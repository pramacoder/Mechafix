<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\TransaksiService;
use App\Models\Service;
use App\Models\RiwayatPerbaikan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MekanikController extends Controller
{
    public function saveServices(BookingService $booking, Request $request)
    {
        try {
            Log::info('=== SAVE SERVICES START ===');
            Log::info('Booking ID: ' . $booking->id_booking_service);
            
            // Pastikan hanya mekanik yang di-assign yang bisa save services
            if ($booking->id_mekanik !== auth()->user()->mekanik->id_mekanik) {
                Log::error('Unauthorized: Mekanik tidak sesuai');
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            $request->validate([
                'services' => 'required|array|min:1',
                'services.*' => 'exists:services,id_service',
            ]);

            Log::info('Services to save: ' . json_encode($request->services));

            DB::beginTransaction();

            // Hapus transaksi service yang lama (jika ada)
            $booking->transaksiServices()->delete();

            $totalBiaya = 0;

            // Simpan service yang dipilih ke transaksi_services
            foreach ($request->services as $serviceId) {
                $service = Service::find($serviceId);
                
                if (!$service) {
                    Log::error('Service not found: ' . $serviceId);
                    continue;
                }

                $transaksi = TransaksiService::create([
                    'id_service' => $serviceId,
                    'kuantitas_service' => 1,
                    'subtotal_service' => $service->biaya_service,
                    'id_booking_service' => $booking->id_booking_service,
                ]);

                Log::info('Created TransaksiService: ' . $transaksi->id_transaksi_service . ' with subtotal: ' . $service->biaya_service);
                $totalBiaya += $service->biaya_service;
            }

            Log::info('Calculated total_biaya: ' . $totalBiaya);

            // TIDAK UPDATE total_biaya ke booking_services karena kolom tidak ada
            // Total akan dihitung dari transaksi_services

            DB::commit();

            return redirect()->back()->with('success', 'Service details saved successfully! Total cost: Rp ' . number_format($totalBiaya, 0, ',', '.') . '. You can now complete the job.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error saving services: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save services: ' . $e->getMessage());
        }
    }

    public function completeJob(BookingService $booking, Request $request)
    {
        try {
            Log::info('=== COMPLETE JOB START ===');
            Log::info('Booking ID: ' . $booking->id_booking_service);
            
            $booking->refresh();
            Log::info('Current status: ' . $booking->status_booking);
            
            // Pastikan hanya mekanik yang di-assign yang bisa complete
            if ($booking->id_mekanik !== auth()->user()->mekanik->id_mekanik) {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            // Count transaksi services
            $transaksiCount = $booking->transaksiServices()->count();
            Log::info('Transaksi services count: ' . $transaksiCount);
            
            // Pastikan service sudah dipilih
            if ($transaksiCount === 0) {
                return redirect()->back()->with('error', 'Please select services first before completing the job.');
            }

            // Hitung total dari transaksi services
            $calculatedTotal = $booking->transaksiServices()->sum('subtotal_service');
            Log::info('Calculated total from transaksi: ' . $calculatedTotal);
            
            if ($calculatedTotal <= 0) {
                Log::error('Calculated total is 0 or negative: ' . $calculatedTotal);
                return redirect()->back()->with('error', 'Unable to calculate total cost. Please re-select services.');
            }

            DB::beginTransaction();

            // Update booking status ke "selesai"
            $booking->update(['status_booking' => 'selesai']);
            Log::info('Booking status updated to: selesai');

            // Buat record pembayaran sesuai struktur DB
            $pembayaran = Pembayaran::create([
                'tanggal_pembayaran' => today(),
                'total_pembayaran' => $calculatedTotal,
                'qris' => 'oli motor.webp',
                'status_pembayaran' => 'Belum Dibayar',
                'id_transaksi_service' => $booking->transaksiServices->first()->id_transaksi_service,
                'id_booking_service' => $booking->id_booking_service,
                'id_plat_kendaraan' => $booking->id_plat_kendaraan,
                // id_transaksi_barang dan bukti_pembayaran biarkan NULL
            ]);

            Log::info('Pembayaran created with ID: ' . $pembayaran->id_pembayaran . ', Total: ' . $pembayaran->total_pembayaran);

            // Create repair history record
            $riwayat = RiwayatPerbaikan::create([
                'tanggal_perbaikan' => today(),
                'deskripsi_perbaikan' => 'Service completed: ' . $booking->transaksiServices->pluck('service.nama_service')->join(', '),
                'dokumentasi_perbaikan' => 'Services performed by mechanic: ' . auth()->user()->name,
                'next_service' => today()->addMonths(3),
                'id_plat_kendaraan' => $booking->id_plat_kendaraan,
                'id_mekanik' => $booking->id_mekanik,
                'id_pembayaran' => $pembayaran->id_pembayaran,
            ]);

            Log::info('RiwayatPerbaikan created: ' . $riwayat->id_riwayat_perbaikan);

            DB::commit();

            return redirect()->back()->with('success', 'Job completed successfully! Customer can now proceed with payment. Total: Rp ' . number_format($calculatedTotal, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error completing job: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Failed to complete job: ' . $e->getMessage());
        }
    }

    // Helper method untuk mendapatkan total biaya booking
    public static function getBookingTotal($bookingId)
    {
        return TransaksiService::where('id_booking_service', $bookingId)->sum('subtotal_service');
    }
}