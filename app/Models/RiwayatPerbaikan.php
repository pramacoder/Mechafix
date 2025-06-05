<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPerbaikan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_perbaikans';
    protected $primaryKey = 'id_riwayat_perbaikan';
    public $incrementing = true;

    protected $fillable = [
        'tanggal_perbaikan',
        'deskripsi_perbaikan',
        'dokumentasi_perbaikan',
        'next_service',
        'id_plat_kendaraan',
        'id_mekanik',
        'id_pembayaran',
    ];

    protected $casts = [
        'tanggal_perbaikan' => 'date',
        'next_service' => 'date',
        'deskripsi_perbaikan' => 'string',
        'dokumentasi_perbaikan' => 'string',
    ];

    // Relationships
    public function platKendaraan()
    {
        return $this->belongsTo(PlatKendaraan::class, 'id_plat_kendaraan', 'id_plat_kendaraan');
    }

    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'id_mekanik', 'id_mekanik');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran', 'id_pembayaran');
    }
}