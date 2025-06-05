<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    use HasFactory;

    protected $table = 'booking_services';
    protected $primaryKey = 'id_booking_service';
    public $incrementing = true;

    protected $fillable = [
        'tanggal_booking',
        'estimasi_kedatangan',
        'keluhan_konsumen',
        'status_booking',
        'id_konsumen',
        'id_plat_kendaraan',
    ];

    protected $casts = [
        'tanggal_booking' => 'datetime',
        'estimasi_kedatangan' => 'datetime',
        'keluhan_konsumen' => 'string',
        'status_booking' => 'string',
    ];

    // Relationships
    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen', 'id_konsumen');
    }

    public function platKendaraan()
    {
        return $this->belongsTo(PlatKendaraan::class, 'id_plat_kendaraan', 'id_plat_kendaraan');
    }
}