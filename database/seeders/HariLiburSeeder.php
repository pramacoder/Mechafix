<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HariLibur;
use Carbon\Carbon;
use Alkoumi\LaravelHijriDate\Hijri;

class HariLiburSeeder extends Seeder
{
    public function run()
    {
        for ($year = 2025; $year <= 2027; $year++) {
            $this->generateHolidaysForYear($year);
        }
    }

    private function generateHolidaysForYear($year)
    {
        $holidays = [];

        $holidays = array_merge($holidays, [
            [
                'nama_hari_libur' => 'Tahun Baru Masehi',
                'tanggal_mulai' => "$year-01-01",
                'tanggal_berakhir' => "$year-01-01",
                'keterangan' => "Perayaan tahun baru kalender masehi $year",
                'id_admin' => 1,
            ],
            [
                'nama_hari_libur' => 'Hari Buruh',
                'tanggal_mulai' => "$year-05-01",
                'tanggal_berakhir' => "$year-05-01",
                'keterangan' => 'Hari Buruh Internasional',
                'id_admin' => 1,
            ],
            [
                'nama_hari_libur' => 'Pancasila',
                'tanggal_mulai' => "$year-06-01",
                'tanggal_berakhir' => "$year-06-01",
                'keterangan' => 'Hari lahir Pancasila',
                'id_admin' => 1,
            ],
            [
                'nama_hari_libur' => 'Kemerdekaan RI',
                'tanggal_mulai' => "$year-08-17",
                'tanggal_berakhir' => "$year-08-17",
                'keterangan' => 'Hari Kemerdekaan Republik Indonesia ke-' . ($year - 1945),
                'id_admin' => 1,
            ],
            [
                'nama_hari_libur' => 'Hari Natal',
                'tanggal_mulai' => "$year-12-25",
                'tanggal_berakhir' => "$year-12-25",
                'keterangan' => 'Peringatan kelahiran Yesus Kristus',
                'id_admin' => 1,
            ],
        ]);

        // 2. HARI RAYA ISLAM (dengan perhitungan Hijri)
        $holidays = array_merge($holidays, $this->getIslamicHolidays($year));

        // 3. HARI RAYA HINDU (dengan perhitungan siklus)
        $holidays = array_merge($holidays, $this->getHinduHolidays($year));

        // 4. HARI RAYA BUDDHA
        $holidays = array_merge($holidays, $this->getBuddhistHolidays($year));

        // 5. HARI RAYA KONG HU CHU
        $holidays = array_merge($holidays, $this->getKongHuChuHolidays($year));

        // 6. HARI RAYA KRISTEN (dengan perhitungan Paskah)
        $holidays = array_merge($holidays, $this->getChristianHolidays($year));

        // 7. HARI LIBUR INTERNASIONAL
        $holidays = array_merge($holidays, $this->getInternationalHolidays($year));

        // Insert ke database
        foreach ($holidays as $holiday) {
            HariLibur::create($holiday);
        }
    }

    private function getIslamicHolidays($year)
    {
        $holidays = [];
        
        try {
            // Loop untuk setiap bulan dalam tahun untuk mencari hari raya Islam
            for ($month = 1; $month <= 12; $month++) {
                for ($day = 1; $day <= Carbon::create($year, $month)->daysInMonth; $day++) {
                    $date = Carbon::create($year, $month, $day);
                    
                    // Set tanggal untuk library Hijri
                    $hijriDate = Hijri::Date('j-n', $date->timestamp);
                    list($hijriDay, $hijriMonth) = explode('-', $hijriDate);
                    $hijriDay = (int)$hijriDay;
                    $hijriMonth = (int)$hijriMonth;

                    // Idul Fitri (1-2 Syawal)
                    if ($hijriMonth == 10 && $hijriDay == 1) {
                        $holidays[] = [
                            'nama_hari_libur' => 'Hari Raya Idul Fitri',
                            'tanggal_mulai' => $date->format('Y-m-d'),
                            'tanggal_berakhir' => $date->addDay()->format('Y-m-d'),
                            'keterangan' => 'Hari Raya Idul Fitri ' . (1400 + $year - 1979) . ' H (2 hari)',
                            'id_admin' => 1,
                        ];
                    }

                    // Idul Adha (10 Dzulhijjah)
                    if ($hijriMonth == 12 && $hijriDay == 10) {
                        $holidays[] = [
                            'nama_hari_libur' => 'Hari Raya Idul Adha',
                            'tanggal_mulai' => $date->format('Y-m-d'),
                            'tanggal_berakhir' => $date->format('Y-m-d'),
                            'keterangan' => 'Hari Raya Idul Adha ' . (1400 + $year - 1979) . ' H',
                            'id_admin' => 1,
                        ];
                    }

                    // Tahun Baru Islam (1 Muharram)
                    if ($hijriMonth == 1 && $hijriDay == 1) {
                        $holidays[] = [
                            'nama_hari_libur' => 'Tahun Baru Islam',
                            'tanggal_mulai' => $date->format('Y-m-d'),
                            'tanggal_berakhir' => $date->format('Y-m-d'),
                            'keterangan' => 'Tahun Baru Islam ' . (1400 + $year - 1979) . ' H',
                            'id_admin' => 1,
                        ];
                    }

                    // Maulid Nabi (12 Rabiul Awal)
                    if ($hijriMonth == 3 && $hijriDay == 12) {
                        $holidays[] = [
                            'nama_hari_libur' => 'Maulid Nabi Muhammad',
                            'tanggal_mulai' => $date->format('Y-m-d'),
                            'tanggal_berakhir' => $date->format('Y-m-d'),
                            'keterangan' => 'Peringatan kelahiran Nabi Muhammad SAW',
                            'id_admin' => 1,
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            $holidays = $this->getIslamicHolidaysFallback($year);
        }

        return $holidays;
    }

    private function getHinduHolidays($year)
    {
        $holidays = [];

        // Nyepi (tanggal tetap berdasarkan perhitungan)
        $nyepiDates = [
            2025 => '2025-03-29',
            2026 => '2026-03-19', 
            2027 => '2027-03-08',
        ];

        if (isset($nyepiDates[$year])) {
            $holidays[] = [
                'nama_hari_libur' => 'Hari Raya Nyepi',
                'tanggal_mulai' => $nyepiDates[$year],
                'tanggal_berakhir' => $nyepiDates[$year],
                'keterangan' => 'Tahun Baru Saka ' . (1900 + $year - 1978),
                'id_admin' => 1,
            ];
        }

        // Galungan (siklus 210 hari)
        $firstGalungan = Carbon::create(2025, 4, 23);
        $galunganInterval = 210;
        
        $startOfYear = Carbon::create($year, 1, 1);
        $endOfYear = Carbon::create($year, 12, 31);
        
        $daysDifference = $firstGalungan->diffInDays($startOfYear, false);
        if ($daysDifference >= 0) {
            $cyclesPassed = floor($daysDifference / $galunganInterval);
            $currentGalungan = $firstGalungan->copy()->addDays($cyclesPassed * $galunganInterval);
            
            while ($currentGalungan->year == $year) {
                $holidays[] = [
                    'nama_hari_libur' => 'Hari Raya Galungan',
                    'tanggal_mulai' => $currentGalungan->format('Y-m-d'),
                    'tanggal_berakhir' => $currentGalungan->format('Y-m-d'),
                    'keterangan' => 'Hari Raya Galungan (siklus 210 hari)',
                    'id_admin' => 1,
                ];
                
                $currentGalungan->addDays($galunganInterval);
            }
        }

        return $holidays;
    }

    private function getBuddhistHolidays($year)
    {
        $waisakDates = [
            2025 => '2025-05-12',
            2026 => '2026-05-31',
            2027 => '2027-05-20',
        ];

        $holidays = [];
        if (isset($waisakDates[$year])) {
            $holidays[] = [
                'nama_hari_libur' => 'Hari Raya Waisak',
                'tanggal_mulai' => $waisakDates[$year],
                'tanggal_berakhir' => $waisakDates[$year],
                'keterangan' => 'Peringatan kelahiran, pencerahan, dan wafat Buddha Gautama',
                'id_admin' => 1,
            ];
        }

        return $holidays;
    }

    private function getKongHuChuHolidays($year)
    {
        $imlekDates = [
            2025 => '2025-01-29',
            2026 => '2026-02-10',
            2027 => '2027-02-05',
        ];

        $holidays = [];
        if (isset($imlekDates[$year])) {
            $imlekDate = $imlekDates[$year];
            
            // Imlek
            $holidays[] = [
                'nama_hari_libur' => 'Imlek',
                'tanggal_mulai' => $imlekDate,
                'tanggal_berakhir' => $imlekDate,
                'keterangan' => 'Tahun Baru Imlek ' . (2500 + $year - 1924),
                'id_admin' => 1,
            ];

            // Cap Go Meh (15 hari setelah Imlek)
            $capGoMehDate = Carbon::createFromFormat('Y-m-d', $imlekDate)->addDays(15);
            $holidays[] = [
                'nama_hari_libur' => 'Cap Go Meh',
                'tanggal_mulai' => $capGoMehDate->format('Y-m-d'),
                'tanggal_berakhir' => $capGoMehDate->format('Y-m-d'),
                'keterangan' => 'Perayaan hari ke-15 setelah Imlek',
                'id_admin' => 1,
            ];
        }

        return $holidays;
    }

    private function getChristianHolidays($year)
    {
        $holidays = [];

        // Hitung tanggal Paskah menggunakan algoritma yang sama
        $easterDate = $this->calculateEasterDate($year);

        // Jumat Agung (2 hari sebelum Paskah)
        $goodFriday = $easterDate->copy()->subDays(2);
        $holidays[] = [
            'nama_hari_libur' => 'Jumat Agung',
            'tanggal_mulai' => $goodFriday->format('Y-m-d'),
            'tanggal_berakhir' => $goodFriday->format('Y-m-d'),
            'keterangan' => 'Peringatan wafat Yesus Kristus',
            'id_admin' => 1,
        ];

        // Kenaikan Isa Al-Masih (40 hari setelah Paskah)
        $ascensionDate = $easterDate->copy()->addDays(40);
        $holidays[] = [
            'nama_hari_libur' => 'Kenaikan Isa Al-Masih',
            'tanggal_mulai' => $ascensionDate->format('Y-m-d'),
            'tanggal_berakhir' => $ascensionDate->format('Y-m-d'),
            'keterangan' => 'Peringatan kenaikan Yesus Kristus ke surga',
            'id_admin' => 1,
        ];

        return $holidays;
    }

    private function calculateEasterDate($year)
    {
        $a = $year % 19;
        $b = floor($year / 100);
        $c = $year % 100;
        $d = floor($b / 4);
        $e = $b % 4;
        $f = floor(($b + 8) / 25);
        $g = floor(($b - $f + 1) / 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = floor($c / 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = floor(($a + 11 * $h + 22 * $l) / 451);
        $month = floor(($h + $l - 7 * $m + 114) / 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        return Carbon::create($year, $month, $day);
    }

    private function getInternationalHolidays($year)
    {
        return [
            [
                'nama_hari_libur' => 'Valentine Day',
                'tanggal_mulai' => "$year-02-14",
                'tanggal_berakhir' => "$year-02-14",
                'keterangan' => 'Hari Kasih Sayang Internasional',
                'id_admin' => 1,
            ],
            [
                'nama_hari_libur' => 'International Women\'s Day',
                'tanggal_mulai' => "$year-03-08",
                'tanggal_berakhir' => "$year-03-08",
                'keterangan' => 'Hari Perempuan Internasional',
                'id_admin' => 1,
            ],
            [
                'nama_hari_libur' => 'Earth Day',
                'tanggal_mulai' => "$year-04-22",
                'tanggal_berakhir' => "$year-04-22",
                'keterangan' => 'Hari Bumi Sedunia',
                'id_admin' => 1,
            ],
            [
                'nama_hari_libur' => 'World Environment Day',
                'tanggal_mulai' => "$year-06-05",
                'tanggal_berakhir' => "$year-06-05",
                'keterangan' => 'Hari Lingkungan Hidup Sedunia',
                'id_admin' => 1,
            ],
            [
                'nama_hari_libur' => 'Halloween',
                'tanggal_mulai' => "$year-10-31",
                'tanggal_berakhir' => "$year-10-31",
                'keterangan' => 'Halloween - Perayaan tradisional Barat',
                'id_admin' => 1,
            ],
        ];
    }

    private function getIslamicHolidaysFallback($year)
    {
        // Estimasi manual jika library Hijri tidak tersedia
        $estimatedDates = [
            2025 => [
                'idul_fitri' => '2025-03-31',
                'idul_adha' => '2025-06-07',
                'tahun_baru_islam' => '2025-06-27',
                'maulid_nabi' => '2025-09-05',
            ],
            2026 => [
                'idul_fitri' => '2026-03-20',
                'idul_adha' => '2026-05-27',
                'tahun_baru_islam' => '2026-06-16',
                'maulid_nabi' => '2026-08-25',
            ],
            2027 => [
                'idul_fitri' => '2027-03-09',
                'idul_adha' => '2027-05-16',
                'tahun_baru_islam' => '2027-06-06',
                'maulid_nabi' => '2027-08-14',
            ],
        ];

        $holidays = [];
        if (isset($estimatedDates[$year])) {
            $dates = $estimatedDates[$year];
            
            $holidays[] = [
                'nama_hari_libur' => 'Hari Raya Idul Fitri',
                'tanggal_mulai' => $dates['idul_fitri'],
                'tanggal_berakhir' => Carbon::parse($dates['idul_fitri'])->addDay()->format('Y-m-d'),
                'keterangan' => 'Hari Raya Idul Fitri (estimasi)',
                'id_admin' => 1,
            ];

            $holidays[] = [
                'nama_hari_libur' => 'Hari Raya Idul Adha',
                'tanggal_mulai' => $dates['idul_adha'],
                'tanggal_berakhir' => $dates['idul_adha'],
                'keterangan' => 'Hari Raya Idul Adha (estimasi)',
                'id_admin' => 1,
            ];

            $holidays[] = [
                'nama_hari_libur' => 'Tahun Baru Islam',
                'tanggal_mulai' => $dates['tahun_baru_islam'],
                'tanggal_berakhir' => $dates['tahun_baru_islam'],
                'keterangan' => 'Tahun Baru Islam (estimasi)',
                'id_admin' => 1,
            ];

            $holidays[] = [
                'nama_hari_libur' => 'Maulid Nabi Muhammad',
                'tanggal_mulai' => $dates['maulid_nabi'],
                'tanggal_berakhir' => $dates['maulid_nabi'],
                'keterangan' => 'Peringatan kelahiran Nabi Muhammad SAW (estimasi)',
                'id_admin' => 1,
            ];
        }

        return $holidays;
    }
}