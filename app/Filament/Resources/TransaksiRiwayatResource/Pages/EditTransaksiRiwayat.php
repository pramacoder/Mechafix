<?php

namespace App\Filament\Resources\TransaksiRiwayatResource\Pages;

use App\Filament\Resources\TransaksiRiwayatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransaksiRiwayat extends EditRecord
{
    protected static string $resource = TransaksiRiwayatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Ambil data riwayat perbaikan dengan relasi
        $record = $this->record;

        // Load data services berdasarkan id_pembayaran
        $services = \App\Models\TransaksiService::where('id_pembayaran', $record->id_pembayaran)
            ->with('service')
            ->get();

        $data['transaksi_services'] = $services->map(function ($ts) {
            return [
                'id_service' => $ts->id_service,
                'kuantitas_service' => $ts->kuantitas_service,
                'subtotal_service' => $ts->subtotal_service,
            ];
        })->toArray();

        // Load data spare parts berdasarkan id_pembayaran
        $spareParts = \App\Models\TransaksiSparePart::where('id_pembayaran', $record->id_pembayaran)
            ->with('sparePart')
            ->get();

        $data['transaksi_spare_parts'] = $spareParts->map(function ($tp) {
            return [
                'id_barang' => $tp->id_barang,
                'kuantitas_barang' => $tp->kuantitas_barang,
                'subtotal_barang' => $tp->subtotal_barang,
            ];
        })->toArray();

        // Hitung total
        $serviceTotal = $services->sum('subtotal_service');
        $sparepartTotal = $spareParts->sum('subtotal_barang');
        $data['total_pembayaran'] = $serviceTotal + $sparepartTotal;

        // Set hidden fields dari relasi
        if ($record->platKendaraan && $record->platKendaraan->konsumens) {
            $data['id_konsumen'] = $record->platKendaraan->konsumens->id_konsumen;
        }
        
        $data['id_plat_kendaraan'] = $record->id_plat_kendaraan;
        $data['id_mekanik'] = $record->id_mekanik;

        // Cari booking service yang terkait (jika ada)
        $bookingService = \App\Models\BookingService::where('id_pembayaran', $record->id_pembayaran)->first();
        if ($bookingService) {
            $data['id_booking_service'] = $bookingService->id_booking_service;
        }
        return $data;
    }

    protected function handleRecordUpdate($record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Update data riwayat perbaikan
        $record->update([
            'tanggal_perbaikan' => $data['tanggal_perbaikan'],
            'deskripsi_perbaikan' => $data['deskripsi_perbaikan'],
            'dokumentasi_perbaikan' => $data['dokumentasi_perbaikan'] ?? $record->dokumentasi_perbaikan,
            'next_service' => $data['next_service'],
        ]);

        // Update services - hapus yang lama, buat yang baru
        \App\Models\TransaksiService::where('id_pembayaran', $record->id_pembayaran)->delete();
        
        $services = $data['transaksi_services'] ?? [];
        $serviceTotal = 0;
        
        foreach ($services as $service) {
            if (!empty($service['id_service'])) {
                $serviceModel = \App\Models\Service::find($service['id_service']);
                if ($serviceModel) {
                    $kuantitas = max(1, (int)($service['kuantitas_service'] ?? 1));
                    $subtotal = $serviceModel->biaya_service * $kuantitas;
                    $serviceTotal += $subtotal;

                    \App\Models\TransaksiService::create([
                        'id_service' => $service['id_service'],
                        'kuantitas_service' => $kuantitas,
                        'subtotal_service' => $subtotal,
                        'id_pembayaran' => $record->id_pembayaran,
                        'id_booking_service' => $data['id_booking_service'] ?? null,
                    ]);
                }
            }
        }

        // Update spare parts - hapus yang lama, buat yang baru
        \App\Models\TransaksiSparePart::where('id_pembayaran', $record->id_pembayaran)->delete();
        
        $spareParts = $data['transaksi_spare_parts'] ?? [];
        $sparepartTotal = 0;
        
        foreach ($spareParts as $sp) {
            if (!empty($sp['id_barang'])) {
                $sparePartModel = \App\Models\SparePart::find($sp['id_barang']);
                if ($sparePartModel) {
                    $kuantitas = max(1, (int)($sp['kuantitas_barang'] ?? 1));
                    $subtotal = $sparePartModel->harga_barang * $kuantitas;
                    $sparepartTotal += $subtotal;

                    \App\Models\TransaksiSparePart::create([
                        'id_barang' => $sp['id_barang'],
                        'kuantitas_barang' => $kuantitas,
                        'subtotal_barang' => $subtotal,
                        'id_pembayaran' => $record->id_pembayaran,
                        'id_booking_service' => $data['id_booking_service'] ?? null,
                    ]);
                }
            }
        }

        // Update total pembayaran
        $grandTotal = $serviceTotal + $sparepartTotal;
        if ($record->pembayaran) {
            $record->pembayaran->update([
                'total_pembayaran' => $grandTotal
            ]);
        }
        return $record;
    }
}