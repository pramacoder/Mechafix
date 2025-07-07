<?php

namespace App\Filament\Resources\TransaksiRiwayatResource\Pages;

use App\Filament\Resources\TransaksiRiwayatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransaksiRiwayats extends ListRecords
{
    protected static string $resource = TransaksiRiwayatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
