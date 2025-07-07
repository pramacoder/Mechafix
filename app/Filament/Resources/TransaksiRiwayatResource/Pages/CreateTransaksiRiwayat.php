<?php

namespace App\Filament\Resources\TransaksiRiwayatResource\Pages;

use App\Filament\Resources\TransaksiRiwayatResource;
use App\Models\RiwayatPerbaikan;
use App\Models\TransaksiService;
use App\Models\TransaksiSparePart;
use App\Models\Pembayaran;
use App\Models\BookingService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTransaksiRiwayat extends CreateRecord
{
    protected static string $resource = TransaksiRiwayatResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Debug log data yang diterima

        // 1. Ambil data dari booking service jika tidak ada di form
        $konsumenId = $data['id_konsumen'] ?? null;
        $platKendaraanId = $data['id_plat_kendaraan'] ?? null;
        $mekanikId = $data['id_mekanik'] ?? null;
        $bookingId = $data['id_booking_service'] ?? null;

        // Jika data belum ada, ambil dari booking service
        if ((!$konsumenId || !$platKendaraanId || !$mekanikId) && $bookingId) {
            $booking = BookingService::find($bookingId);
            if ($booking) {
                $konsumenId = $konsumenId ?: $booking->id_konsumen;
                $platKendaraanId = $platKendaraanId ?: $booking->id_plat_kendaraan;
                $mekanikId = $mekanikId ?: $booking->id_mekanik;
            }
        }

        // Validasi data yang diperlukan
        if (!$konsumenId || !$platKendaraanId || !$mekanikId) {
            throw new \Exception('Missing required data: konsumen, plat kendaraan, or mekanik');
        }

        // 2. Hitung total dengan mengambil harga dari master data
        $services = $data['transaksi_services'] ?? [];
        $spareParts = $data['transaksi_spare_parts'] ?? [];
        $serviceTotal = 0;

        foreach ($services as $service) {
            if (!empty($service['id_service'])) {
                $serviceModel = \App\Models\Service::find($service['id_service']);
                if ($serviceModel) {
                    $kuantitas = max(1, (int)($service['kuantitas_service'] ?? 1));
                    $serviceTotal += $serviceModel->biaya_service * $kuantitas;
                }
            }
        }

        $sparepartTotal = 0;
        foreach ($spareParts as $sp) {
            if (!empty($sp['id_barang'])) {
                $sparePartModel = \App\Models\SparePart::find($sp['id_barang']);
                if ($sparePartModel) {
                    $kuantitas = max(1, (int)($sp['kuantitas_barang'] ?? 1));
                    $sparepartTotal += $sparePartModel->harga_barang * $kuantitas;
                }
            }
        }

        $grandTotal = $serviceTotal + $sparepartTotal;

        // 3. Buat pembayaran
        $pembayaran = Pembayaran::create([
            'id_konsumen' => $konsumenId,
            'total_pembayaran' => $grandTotal,
            'tanggal_pembayaran' => today(),
            'status_pembayaran' => 'Belum Dibayar',
        ]);

        // 4. Buat riwayat perbaikan
        $riwayat = RiwayatPerbaikan::create([
            'tanggal_perbaikan' => $data['tanggal_perbaikan'],
            'deskripsi_perbaikan' => $data['deskripsi_perbaikan'],
            'dokumentasi_perbaikan' => $data['dokumentasi_perbaikan'] ?? null,
            'next_service' => $data['next_service'],
            'id_plat_kendaraan' => $platKendaraanId,
            'id_mekanik' => $mekanikId,
            'id_pembayaran' => $pembayaran->id_pembayaran,
        ]);

        // 5. Buat transaksi services
        foreach ($services as $service) {
            if (!empty($service['id_service'])) {
                $serviceModel = \App\Models\Service::find($service['id_service']);
                if ($serviceModel) {
                    $kuantitas = max(1, (int)($service['kuantitas_service'] ?? 1));
                    $subtotal = $serviceModel->biaya_service * $kuantitas;

                    $transaksiService = TransaksiService::create([
                        'id_service' => $service['id_service'],
                        'kuantitas_service' => $kuantitas,
                        'subtotal_service' => $subtotal,
                        'id_pembayaran' => $pembayaran->id_pembayaran,
                        'id_booking_service' => $bookingId,
                    ]);
                }
            }
        }

        // 6. Buat transaksi spare parts
        foreach ($spareParts as $sp) {
            if (!empty($sp['id_barang'])) {
                $sparePartModel = \App\Models\SparePart::find($sp['id_barang']);
                if ($sparePartModel) {
                    $kuantitas = max(1, (int)($sp['kuantitas_barang'] ?? 1));
                    $subtotal = $sparePartModel->harga_barang * $kuantitas;

                    $transaksiSparePart = TransaksiSparePart::create([
                        'id_barang' => $sp['id_barang'],
                        'kuantitas_barang' => $kuantitas,
                        'subtotal_barang' => $subtotal,
                        'id_pembayaran' => $pembayaran->id_pembayaran,
                        'id_booking_service' => $bookingId,
                    ]);

                }
            }
        }

        // 7. Update booking service dengan id_pembayaran (opsional)
        if ($bookingId) {
            BookingService::where('id_booking_service', $bookingId)
                ->update(['id_pembayaran' => $pembayaran->id_pembayaran,
                          'status_booking' => 'selesai']);
        }

        return $riwayat;
    }
}