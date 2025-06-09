<?php

namespace App\Filament\Resources\MekanikResource\Pages;

use App\Filament\Resources\MekanikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMekanik extends EditRecord
{
    protected static string $resource = MekanikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
