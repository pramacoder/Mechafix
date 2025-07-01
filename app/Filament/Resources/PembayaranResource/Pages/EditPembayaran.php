<?php

namespace App\Filament\Resources\PembayaranResource\Pages;

use App\Filament\Resources\PembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembayaran extends EditRecord
{
    protected static string $resource = PembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Ambil transaksi berdasarkan id_pembayaran (karena bisa tanpa booking)
        $data['services'] = \App\Models\TransaksiService::where('id_pembayaran', $this->record->id_pembayaran)
            ->orWhere('id_booking_service', $this->record->id_booking_service)
            ->get()
            ->map(fn($ts) => [
                'id_service' => $ts->id_service,
            ])
            ->toArray();

        $data['spareparts'] = \App\Models\TransaksiSparePart::where('id_pembayaran', $this->record->id_pembayaran)
            ->orWhere('id_booking_service', $this->record->id_booking_service)
            ->get()
            ->map(fn($ts) => [
                'id_barang' => $ts->id_barang,
                'qty' => $ts->kuantitas_barang,
            ])
            ->toArray();

        return $data;
    }
}
