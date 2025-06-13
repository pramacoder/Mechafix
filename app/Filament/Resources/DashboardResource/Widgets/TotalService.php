<?php

namespace App\Filament\Resources\BookingServiceResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalService extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Service', '50 Service')
                ->description('Jumlah Pesanan'),
            Stat::make('Booking Service', '10 Booking')
                ->description('Jumlah Pesanan'),
            Stat::make('Inprogress', '15 Service')
                ->description('Jumlah Pesanan'),
            Stat::make('Complete Service', '30 Services')
                ->description('Jumlah Pesanan'),
        ];
    }
}
