<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\TransaksiSparePart;
use Filament\Widgets\ChartWidget;

class PenjualanBarangChart extends ChartWidget
{
    protected static ?string $heading = 'Penjualan Barang Mechafix';

    protected function getData(): array
    {
        $year = now()->year;
        $data = TransaksiSparePart::selectRaw('MONTH(created_at) as month, SUM(kuantitas_barang) as total')
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
                    'label' => 'Total Penjualan Barang',
                    'data' => $monthlyTotals,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
