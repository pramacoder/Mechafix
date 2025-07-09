<?php

namespace App\Filament\Mekanik\Resources\DashboardResource\Widgets;

use App\Models\BookingService;
use Filament\Widgets\ChartWidget;

class Konribusi extends ChartWidget
{
    protected static ?string $heading = 'Kontribusi Service Bulanan';

    protected function getData(): array
    {
        $year = now()->year;
        $data = BookingService::selectRaw('MONTH(created_at) as month, COUNT(id_mekanik) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $monthlyTotals = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyTotals[] = $data[$month] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Kontribusi Service Tiap Bulan oleh ' . auth()->user()->name,
                    'data' => $monthlyTotals,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
