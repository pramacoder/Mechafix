<?php

namespace App\Filament\Resources\PlatKendaraanResource\Pages;

use App\Filament\Resources\PlatKendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlatKendaraan extends EditRecord
{
    protected static string $resource = PlatKendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
