<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Konsumen;
use App\Models\Mekanik;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Available extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Mechanics', Mekanik::count() . ' Available')
                ->description('Jumlah Mekanik Tersedia'),
            Stat::make('Bounce rate', Konsumen::count() . ' Konsumen')
                ->description('Jumlah Pengunjung'),
            Stat::make('Pageviews', '1.2M')
                ->description('Jumlah Pesanan'),
        ];
    }
}
