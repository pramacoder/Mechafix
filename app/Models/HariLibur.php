<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HariLibur extends Model
{
    use HasFactory;

    protected $table = 'hari_libur';
    protected $primaryKey = 'id_hari_libur';
    public $incrementing = true;
    public $keyType = 'int';

    protected $fillable = [
        'nama_hari_libur',
        'tanggal_mulai',
        'tanggal_berakhir',
        'keterangan',
        'id_admin',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    // Static methods untuk validasi booking
    public static function isHoliday($date)
    {
        $checkDate = Carbon::parse($date)->format('Y-m-d');
        
        return static::where('tanggal_mulai', '<=', $checkDate)
                    ->where('tanggal_berakhir', '>=', $checkDate)
                    ->exists();
    }

    public static function getHolidayName($date)
    {
        $checkDate = Carbon::parse($date)->format('Y-m-d');
        
        $holiday = static::where('tanggal_mulai', '<=', $checkDate)
                         ->where('tanggal_berakhir', '>=', $checkDate)
                         ->first();
                         
        return $holiday ? $holiday->nama_hari_libur : null;
    }

    public static function getHolidayDates($startDate = null, $endDate = null)
    {
        $query = static::query();
        
        if ($startDate) {
            $query->where('tanggal_berakhir', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('tanggal_mulai', '<=', $endDate);
        }
        
        $holidays = $query->get();
        $holidayDates = [];
        
        foreach ($holidays as $holiday) {
            $current = $holiday->tanggal_mulai->copy();
            $end = $holiday->tanggal_berakhir;
            
            while ($current->lte($end)) {
                $holidayDates[] = $current->format('Y-m-d');
                $current->addDay();
            }
        }
        
        return $holidayDates;
    }

    public static function getHolidayDetails($startDate = null, $endDate = null)
    {
        $query = static::query();
        
        if ($startDate) {
            $query->where('tanggal_berakhir', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('tanggal_mulai', '<=', $endDate);
        }
        
        $holidays = $query->orderBy('tanggal_mulai')->get();
        $holidayDetails = [];
        
        foreach ($holidays as $holiday) {
            $dates = [];
            $current = $holiday->tanggal_mulai->copy();
            $end = $holiday->tanggal_berakhir;
            
            while ($current->lte($end)) {
                $dates[] = $current->format('Y-m-d');
                $current->addDay();
            }
            
            $holidayDetails[] = [
                'nama' => $holiday->nama_hari_libur,
                'dates' => $dates,
                'keterangan' => $holiday->keterangan,
                'tanggal_mulai' => $holiday->tanggal_mulai->format('Y-m-d'),
                'tanggal_berakhir' => $holiday->tanggal_berakhir->format('Y-m-d'),
                'duration' => count($dates),
            ];
        }
        
        return $holidayDetails;
    }
}