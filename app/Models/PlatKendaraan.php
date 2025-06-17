<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatKendaraan extends Model
{
    use HasFactory;

    protected $table = 'plat_kendaraans';
    protected $primaryKey = 'id_plat_kendaraan';
    public $incrementing = true;

    protected $fillable = [
        'nomor_plat_kendaraan',
        'cc_kendaraan',
        'id_konsumen',
    ];

    protected $casts = [
        'nomor_plat_kendaraan' => 'string',
        'cc_motor' => 'integer',
    ];

    // Relationships
    public function konsumens()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen', 'id_konsumen');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_plat_kendaraan', 'id_plat_kendaraan');
    }

    public function bookingServices()
    {
        return $this->hasMany(BookingService::class, 'id_plat_kendaraan', 'id_plat_kendaraan');
    }

    public function riwayatPerbaikans()
    {
        return $this->hasMany(RiwayatPerbaikan::class, 'id_plat_kendaraan', 'id_plat_kendaraan');
    }
}