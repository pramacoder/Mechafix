<?php

namespace App\Filament\Resources\ServiceListResource\Pages;

use App\Filament\Resources\ServiceListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceLists extends ListRecords
{
    protected static string $resource = ServiceListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
