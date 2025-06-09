<?php

namespace App\Filament\Resources\PlatKendaraanResource\Pages;

use App\Filament\Resources\PlatKendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlatKendaraans extends ListRecords
{
    protected static string $resource = PlatKendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
