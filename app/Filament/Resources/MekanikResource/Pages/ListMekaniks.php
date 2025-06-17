<?php

namespace App\Filament\Resources\MekanikResource\Pages;

use App\Filament\Resources\MekanikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMekaniks extends ListRecords
{
    protected static string $resource = MekanikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
