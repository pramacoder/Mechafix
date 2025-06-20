<?php

namespace App\Filament\Resources\ServiceListResource\Pages;

use App\Filament\Resources\ServiceListResource;
use Filament\Resources\Pages\CreateRecord;

class CreateServiceList extends CreateRecord
{
    protected static string $resource = ServiceListResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Create')
            ->color('warning');
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Cancel')
            ->color('danger');
    }
}
