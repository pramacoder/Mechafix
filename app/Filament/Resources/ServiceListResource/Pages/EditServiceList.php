<?php

namespace App\Filament\Resources\ServiceListResource\Pages;

use App\Filament\Resources\ServiceListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceList extends EditRecord
{
    protected static string $resource = ServiceListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
