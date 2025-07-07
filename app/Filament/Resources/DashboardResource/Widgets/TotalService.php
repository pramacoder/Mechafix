<?php

namespace App\Filament\Resources\BookingServiceResource\Widgets;

use App\Models\BookingService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalService extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Service', BookingService::count() . ' Services')
                ->description('Jumlah Pesanan'),
            Stat::make('Booking Service', BookingService::where('status', 'booking')->count() . ' Services')
                ->description('Jumlah Pesanan'),
            Stat::make('Inprogress', BookingService::where('status', 'inprogress')->count() . ' Services')
                ->description('Jumlah Pesanan'),
            Stat::make('Complete Service', BookingService::where('status', 'selesai')->count() . ' Services')
                ->description('Jumlah Pesanan'),
        ];
    }
}
