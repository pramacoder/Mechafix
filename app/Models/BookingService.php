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
        'id_mekanik',
        'id_pembayaran',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'estimasi_kedatangan' => 'datetime',
        'keluhan_konsumen' => 'string',
        'status_booking' => 'string',
    ];

    // Relationships
    public function konsumens()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen', 'id_konsumen');
    }

    public function platKendaraan()
    {
        return $this->belongsTo(PlatKendaraan::class, 'id_plat_kendaraan', 'id_plat_kendaraan');
    }

    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'id_mekanik', 'id_mekanik');
    }

    public function pembayarans()
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran', 'id_pembayaran');
    }

    public function isCompleted()
    {
        return $this->status_booking === 'selesai';
    }

    public function isPaid()
    {
        return $this->pembayarans()->where('status_pembayaran', 'Sudah Dibayar')->exists();
    }

    public function isConfirmed()
    {
        return $this->status_booking === 'dikonfirmasi';
    }

    public function isPending()
    {
        return $this->status_booking === 'menunggu';
    }

    public function transaksiServices()
    {
        return $this->hasMany(TransaksiService::class, 'id_booking_service', 'id_booking_service');
    }

    // public function transaksiSpareParts()
    // {
    //     return $this->hasMany(TransaksiSparePart::class, 'id_booking_service', 'id_booking_service');
    // }

    public function transaksiSpareParts()
    {
        return $this->hasMany(TransaksiSparePart::class, 'id_booking_service');
    }

    public function serviceDetails()
    {
        return $this->transaksiServices();
    }

    public function services()
    {
        return $this->belongsToMany(
            Service::class,
            'transaksi_services',
            'id_booking_service',
            'id_service',
        )
            ->withPivot('kuantitas_service', 'subtotal_service')
            ->withTimestamps();
    }

    public function getTotalBiayaAttribute()
    {
        return $this->transaksiServices()->sum('subtotal_service');
    }

    public function getGrandTotalAttribute()
    {
        return $this->transaksiServices->sum('subtotal_service') + $this->transaksiSpareParts->sum('subtotal_barang');
    }
}
