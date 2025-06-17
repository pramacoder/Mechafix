<?php

namespace App\Filament\Resources\BookingServiceResource\Pages;

use App\Filament\Resources\BookingServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingService extends EditRecord
{
    protected static string $resource = BookingServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
