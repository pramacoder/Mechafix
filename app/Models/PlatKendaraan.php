<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatKendaraan extends Model
{
    use HasFactory;

    protected $table = 'plat_kendaraans';
    protected $primaryKey = 'id_kendaraan';
    public $incrementing = true;

    protected $fillable = [
        'nomor_plat',
        'cc_kendaraan',
        'id_konsumen',
    ];

    protected $casts = [
        'nomor_plat' => 'string',
        'cc_motor' => 'integer',
    ];

    // Relationships
    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen', 'id_konsumen');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_plat_kendaraan', 'id_plat_kendaraan');
    }

    public function bookingService()
    {
        return $this->hasMany(BookingService::class, 'id_plat_kendaraan', 'id_plat_kendaraan');
    }

    public function riwayatPerbaikan()
    {
        return $this->hasMany(RiwayatPerbaikan::class, 'id_plat_kendaraan', 'id_plat_kendaraan');
    }
}