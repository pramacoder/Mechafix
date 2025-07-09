<?php

namespace App\Filament\Widgets;

use App\Models\HariLibur;
use Filament\Widgets\Widget;
use Guava\Calendar\Widgets\CalendarWidget;

class MyCalenderWidget extends CalendarWidget
{
    // protected static string $view = 'filament.widgets.my-calender-widget';

    public function getEvents(array $parameters = []): array
    {
        // Ambil semua hari libur
        $holidays = HariLibur::all();

        // Mapping ke format event calendar
        return $holidays->map(function ($holiday) {
            return [
                'id' => $holiday->id_hari_libur,
                'title' => $holiday->nama_hari_libur,
                'start' => $holiday->tanggal_mulai->format('Y-m-d'),
                'end' => $holiday->tanggal_berakhir->copy()->addDay()->format('Y-m-d'),
                'color' => '#ff6666',
                'allDay' => true,
            ];
        })->toArray();
    }
}
