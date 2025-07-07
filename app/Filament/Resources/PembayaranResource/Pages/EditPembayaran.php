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
        // Load data spare parts untuk form edit
        $record = $this->record;

        // Load data spare parts berdasarkan relasi
        $spareParts = $record->transaksiSpareParts()->with('sparePart')->get();

        $data['transaksiSpareParts'] = $spareParts->map(function ($tp) {
            return [
                'id_barang' => $tp->id_barang,
                'kuantitas_barang' => $tp->kuantitas_barang,
                'subtotal_barang' => $tp->subtotal_barang,
            ];
        })->toArray();

        // Set total pembayaran
        $data['total_pembayaran'] = $record->total_pembayaran;

        return $data;
    }

    protected function handleRecordUpdate($record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Update data pembayaran utama
        $record->update([
            'id_konsumen' => $data['id_konsumen'],
            'tanggal_pembayaran' => $data['tanggal_pembayaran'],
            'status_pembayaran' => $data['status_pembayaran'],
            'qris' => $data['qris'] ?? $record->qris,
            'bukti_pembayaran' => $data['bukti_pembayaran'] ?? $record->bukti_pembayaran,
        ]);

        // Update spare parts - hapus yang lama, buat yang baru
        $record->transaksiSpareParts()->delete();
        
        $spareParts = $data['transaksiSpareParts'] ?? [];
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
                        'id_booking_service' => $record->bookingService?->id_booking_service,
                    ]);
                }
            }
        }

        // Update total pembayaran
        $record->update([
            'total_pembayaran' => $sparepartTotal
        ]);

        return $record;
    }
}