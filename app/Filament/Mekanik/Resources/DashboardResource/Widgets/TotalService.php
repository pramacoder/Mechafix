<?php

namespace App\Filament\Mekanik\Resources\DashboardResource\Widgets;

use App\Models\BookingService;
use App\Models\Mekanik;
use App\Models\TransaksiService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TotalService extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $mekanik = Mekanik::where('id', $user->id)->first();
        $totalHariBekerja = $mekanik?->kuantitas_hari ?? 0;

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Booking ID bulan ini dan bulan lalu untuk mekanik ini
        $bookingThisMonth = BookingService::where('id_mekanik', $mekanik->id_mekanik)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->pluck('id_booking_service');

        $bookingLastMonth = BookingService::where('id_mekanik', $mekanik->id_mekanik)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->pluck('id_booking_service');

        // Total pendapatan (subtotal_service) bulan ini dan bulan lalu
        $totalThisMonth = TransaksiService::whereIn('id_booking_service', $bookingThisMonth)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('subtotal_service');

        $totalLastMonth = TransaksiService::whereIn('id_booking_service', $bookingLastMonth)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('subtotal_service');

        // Hitung pendapatan 50%
        $pendapatanThisMonth = $totalThisMonth * 0.5;
        $pendapatanLastMonth = $totalLastMonth * 0.5;

        // Hitung selisih
        $selisih = $pendapatanThisMonth - $pendapatanLastMonth;
        $selisihAbs = abs($selisih);

        // Format angka ke k/M
        $formatRupiah = fn($angka) => 'Rp ' . number_format($angka, 0, ',', '.');

        // Deskripsi tren
        if ($selisih > 0) {
            $desc = $formatRupiah($selisihAbs) . ' meningkat';
            $icon = 'heroicon-m-arrow-trending-up';
        } elseif ($selisih < 0) {
            $desc = $formatRupiah($selisihAbs) . ' menurun';
            $icon = 'heroicon-m-arrow-trending-down';
        } else {
            $desc = 'No change';
            $icon = 'heroicon-m-minus';
        }

        // Ambil waktu kerja rata-rata harian dari estimasi_waktu
        $bookingIds = $bookingThisMonth;
        $waktuPerHari = TransaksiService::select(
            DB::raw('DATE(transaksi_services.created_at) as tanggal'),
            DB::raw('SUM(services.estimasi_waktu) as total_menit')
        )
            ->join('services', 'transaksi_services.id_service', '=', 'services.id_service')
            ->whereIn('transaksi_services.id_booking_service', $bookingIds)
            ->whereBetween('transaksi_services.created_at', [$startOfMonth, $endOfMonth])
            ->groupBy(DB::raw('DATE(transaksi_services.created_at)'))
            ->pluck('total_menit', 'tanggal')
            ->toArray();

        $rataRataMenit = count($waktuPerHari) > 0
            ? array_sum($waktuPerHari) / count($waktuPerHari)
            : 0;

        $jam = floor($rataRataMenit / 60);
        $menit = round($rataRataMenit % 60);
        $formattedWaktu = sprintf('%d jam %02d menit', $jam, $menit);

        return [
            Stat::make('Total pendapatan bulan ini', $formatRupiah($pendapatanThisMonth))
                ->description($desc)
                ->descriptionIcon($icon),
            Stat::make('Total hari bekerja dalam seminggu', $totalHariBekerja . ' hari')
                ->description('Hari di mana mekanik bekerja dalam seminggu'),
            Stat::make('Waktu kerja rata-rata tiap bulan', $formattedWaktu)
                ->description('Rata-rata jam kerja per hari di bulan ini'),
        ];
    }
}
