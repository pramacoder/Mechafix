<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Available extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Unique views', '192.1k')
                ->description('Jumlah Pesanan'),
            Stat::make('Bounce rate', '21%')
                ->description('Jumlah Pesanan'),
            Stat::make('Pageviews', '1.2M')
                ->description('Jumlah Pesanan'),
        ];
    }
}
