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
            Stat::make('Booking Service Belum Terkonfirmasi', BookingService::where('status_booking', 'menunggu')->count() . ' Services')
                ->description('Jumlah Pesanan'),
            Stat::make('Inprogress', BookingService::where('status_booking', 'dikonfirmasi')->count() . ' Services')
                ->description('Jumlah Pesanan'),
            Stat::make('Complete Service', BookingService::where('status_booking', 'selesai')->count() . ' Services')
                ->description('Jumlah Pesanan'),
        ];
    }
}
