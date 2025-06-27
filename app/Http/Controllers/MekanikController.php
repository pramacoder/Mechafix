<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\TransaksiService;
use App\Models\Service;
use App\Models\RiwayatPerbaikan;
use App\Models\Pembayaran;
use App\Models\SparePart;
use App\Models\TransaksiSparePart;
use App\Notifications\BookingCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MekanikController extends Controller
{
    public function dashboard()
    {
        // Ambil data booking milik mekanik yang login
        $mekanik = auth()->user()->mekanik;
        $bookings = $mekanik
            ? $mekanik->bookingServices()->with(['konsumen.user', 'platKendaraan', 'transaksiServices.service', 'transaksiSpareParts.sparePart', 'pembayarans'])->get()
            : collect();

        $conversations = collect();

        return view('dashboard.mekanik', compact('bookings', 'conversations'));
    }

    public function saveServices(BookingService $booking, Request $request)
    {
        try {
            Log::info('=== SAVE SERVICES START ===');
            Log::info('Booking ID: ' . $booking->id_booking_service);

            if ($booking->id_mekanik !== auth()->user()->mekanik->id_mekanik) {
                Log::error('Unauthorized: Mekanik tidak sesuai');
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            $request->validate([
                'services' => 'nullable|array',
                'services.*' => 'exists:services,id_service',
                'spareparts' => 'nullable|array',
                'spareparts.*' => 'exists:spare_parts,id_barang',
            ]);
            if (empty($request->services) && empty($request->spareparts)) {
                return redirect()->back()->with('error', 'Pilih minimal satu service atau spare part.');
            }

            Log::info('Services to save: ' . json_encode($request->services));
            Log::info('Spareparts to save: ' . json_encode($request->spareparts));

            DB::beginTransaction();

            // Hapus transaksi lama
            $booking->transaksiServices()->delete();
            $booking->transaksiSpareParts()->delete();

            $totalBiaya = 0;

            // Simpan service
            if ($request->has('services')) {
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
            }

            // Simpan spare part
            if ($request->has('spareparts')) {
                foreach ($request->spareparts as $sparepartId) {
                    $sparepart = SparePart::where('id_barang', $sparepartId)->first();
                    if (!$sparepart) {
                        Log::error('SparePart not found: ' . $sparepartId);
                        continue;
                    }
                    $transaksiSpare = TransaksiSparePart::create([
                        'id_barang' => $sparepartId,
                        'kuantitas_barang' => 1,
                        'subtotal_barang' => $sparepart->harga_barang,
                        'id_booking_service' => $booking->id_booking_service,
                    ]);
                    Log::info('Created TransaksiSparePart: ' . $transaksiSpare->id_transaksi_barang . ' with subtotal: ' . $sparepart->harga_barang);
                    $totalBiaya += $sparepart->harga_barang;
                }
            }

            Log::info('Calculated total_biaya: ' . $totalBiaya);

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
        if ($booking->id_mekanik !== auth()->user()->mekanik->id_mekanik) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $serviceCount = $booking->transaksiServices()->count();
        $sparepartCount = $booking->transaksiSpareParts()->count();

        if ($serviceCount === 0 && $sparepartCount === 0) {
            return redirect()->back()->with('error', 'Please select services or spare parts first before completing the job.');
        }

        // Jika GET, tampilkan form riwayat
        if ($request->isMethod('get')) {
            $booking->load(['konsumen.user', 'platKendaraan', 'transaksiServices.service', 'transaksiSpareParts.sparePart']);
            $defaultNextService = \Carbon\Carbon::now()->addMonths(3)->format('Y-m-d');
            return view('dashboard.mekanik-riwayat-form', compact('booking', 'defaultNextService'));
        }

        // Jika POST, proses simpan
        $request->validate([
            'deskripsi_perbaikan' => 'required|string',
            'dokumentasi_perbaikan' => 'nullable|image|max:2048',
            'next_service' => 'nullable|date|after_or_equal:today',
        ]);

        $calculatedTotal = $booking->transaksiServices()->sum('subtotal_service') + $booking->transaksiSpareParts()->sum('subtotal_barang');

        DB::beginTransaction();

        // Update status booking ke selesai
        $booking->update(['status_booking' => 'selesai']);

        $booking->konsumen->user->notify(new BookingCompleted($booking));
        
        // Buat pembayaran (TIDAK perlu id_booking_service di tabel pembayaran)
        $pembayaran = Pembayaran::create([
            'tanggal_pembayaran' => today(),
            'total_pembayaran' => $calculatedTotal,
            'qris' => 'oli motor.webp',
            'status_pembayaran' => 'Belum Dibayar',
        ]);

        // Update id_pembayaran di booking_services
        $booking->update(['id_pembayaran' => $pembayaran->id_pembayaran]);

        // Update id_pembayaran di transaksi service & spare part (PASTI JALAN)
        TransaksiService::where('id_booking_service', $booking->id_booking_service)
            ->update(['id_pembayaran' => $pembayaran->id_pembayaran]);
        TransaksiSparePart::where('id_booking_service', $booking->id_booking_service)
            ->update(['id_pembayaran' => $pembayaran->id_pembayaran]);
        BookingService::where('id_booking_service', $pembayaran->id_booking_service)
            ->update(['id_booking_service' => $pembayaran->id_pembayaran]);
            
        $dokumentasiPath = null;
        if ($request->hasFile('dokumentasi_perbaikan')) {
            $dokumentasiPath = $request->file('dokumentasi_perbaikan')->store('riwayat_perbaikan', 'public');
        }

        RiwayatPerbaikan::create([
            'tanggal_perbaikan' => today(),
            'deskripsi_perbaikan' => $request->deskripsi_perbaikan,
            'dokumentasi_perbaikan' => $dokumentasiPath,
            'next_service' => $request->next_service ?: today()->addMonths(3),
            'id_plat_kendaraan' => $booking->id_plat_kendaraan,
            'id_mekanik' => $booking->id_mekanik,
            'id_pembayaran' => $pembayaran->id_pembayaran,
        ]);

        DB::commit();

        return redirect()->route('mekanik.dashboard')->with('success', 'Riwayat perbaikan berhasil disimpan & job selesai!');
        // return redirect()->route('dashboard')->with('success', 'Riwayat perbaikan berhasil disimpan & job selesai!');
    }

    // Helper method untuk mendapatkan total biaya booking
    public static function getBookingTotal($bookingId)
    {
        return TransaksiService::where('id_booking_service', $bookingId)->sum('subtotal_service');
    }
}
