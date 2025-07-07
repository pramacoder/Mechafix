<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePembayaran extends CreateRecord
{
    protected static string $resource = PembayaranResource::class;

    protected function afterCreate(): void
    {
        $state = $this->form->getState();
        $this->record->refresh();
        $pembayaranId = $this->record->id_pembayaran;
        $bookingId = $state['id_booking_service'] ?? null;

        // Update relasi di booking
        if ($bookingId) {
            \App\Models\BookingService::where('id_booking_service', $bookingId)
                ->update(['id_pembayaran' => $pembayaranId]);
        }

        $services = $state['transaksiServices'] ?? [];
        foreach ($services as $service) {
            if (empty($service['id_service'])) continue;

            $serviceModel = \App\Models\Service::find($service['id_service']);
            if (!$serviceModel) continue;

            $kuantitas = max(1, (int)($service['kuantitas_service'] ?? 1));
            $harga = $serviceModel->biaya_service;
            $subtotal = $harga * $kuantitas;

            \App\Models\TransaksiService::create([
                'id_pembayaran' => $pembayaranId,
                'id_booking_service' => $bookingId,
                'id_service' => $service['id_service'],
                'kuantitas_service' => $kuantitas,
                'subtotal_service' => $subtotal,
            ]);
        }

        $spareParts = $state['transaksiSpareParts'] ?? [];
        foreach ($spareParts as $sp) {
            if (empty($sp['id_barang'])) continue;

            $sparePartModel = \App\Models\SparePart::query()
                ->select(['id_barang', 'harga_barang'])
                ->find($sp['id_barang']);
            if (!$sparePartModel) continue;

            $kuantitas = max(1, (int)($sp['kuantitas_barang'] ?? 1));
            $harga = $sparePartModel->harga_barang;
            $subtotal = $harga * $kuantitas;

            \App\Models\TransaksiSparePart::create([
                'id_pembayaran' => $pembayaranId,
                'id_booking_service' => $bookingId,
                'id_barang' => $sp['id_barang'],
                'kuantitas_barang' => $kuantitas,
                'subtotal_barang' => $subtotal,
            ]);
        }

        $this->record->update([
            'total_pembayaran' => $state['total_pembayaran'] ?? 0,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Filter out empty services
        $data['transaksiServices'] = array_filter(
            $data['transaksiServices'] ?? [],
            fn($service) => !empty($service['id_service'])
        );

        // Filter out empty spare parts
        $data['transaksiSpareParts'] = array_filter(
            $data['transaksiSpareParts'] ?? [],
            fn($sp) => !empty($sp['id_barang'])
        );

        $serviceTotal = 0;
        foreach ($data['transaksiServices'] as $index => $service) {
            $serviceModel = \App\Models\Service::find($service['id_service']);
            if (!$serviceModel) continue;

            $harga = $serviceModel->biaya_service;
            $qty = max(1, (int)($service['kuantitas_service'] ?? 1));
            $subtotal = $harga * $qty;

            $data['transaksiServices'][$index]['subtotal_service'] = $subtotal;
            $serviceTotal += $subtotal;
        }

        $sparepartTotal = 0;
        foreach ($data['transaksiSpareParts'] as $index => $sp) {
            $sparePartModel = \App\Models\SparePart::find($sp['id_barang']);
            if (!$sparePartModel) continue;

            $harga = $sparePartModel->harga_barang;
            $qty = max(1, (int)($sp['kuantitas_barang'] ?? 1));
            $subtotal = $harga * $qty;

            $data['transaksiSpareParts'][$index]['subtotal_barang'] = $subtotal;
            $sparepartTotal += $subtotal;
        }

        $data['total_pembayaran'] = $serviceTotal + $sparepartTotal;

        return $data;
    }
}
