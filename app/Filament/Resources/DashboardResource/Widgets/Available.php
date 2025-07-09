<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Konsumen;
use App\Models\Mekanik;
use App\Models\Pembayaran;
use App\Models\TransaksiSparePart;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Available extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Mekanik', Mekanik::count() . ' Available')
                ->description('Jumlah Mekanik Tersedia'),
            Stat::make('Jumlah Konsumen', Konsumen::count() . ' Konsumen')
                ->description('Jumlah Pengunjung'),
            Stat::make('Banyaknya Pembelian', TransaksiSparePart::sum('kuantitas_barang') . ' Spare Parts')
                ->description('Jumlah Pesanan'),
            Stat::make(
                'Total Pendapatan',
                'Rp ' . number_format(Pembayaran::sum('total_pembayaran'), 0, ',', '.') . ' rupiah'
            )
                ->description('Pendapatan Bulan Ini'),
        ];
    }
}
