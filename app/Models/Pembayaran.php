<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';
    public $incrementing = true;

    protected $fillable = [
        'total_pembayaran',
        'tanggal_pembayaran',
        'qris',
        'bukti_pembayaran',
        'id_transaksi_barang',
        'id_transaksi_service',
        'id_plat_kendaraan',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'total_pembayaran' => 'integer',
        'qris' => 'string',
        'bukti_pembayaran' => 'string',
    ];

    // Relationships
    public function transaksiSparePart()
    {
        return $this->belongsTo(TransaksiSparePart::class, 'id_transaksi_barang', 'id_transaksi_barang');
    }

    public function transaksiService()
    {
        return $this->belongsTo(TransaksiService::class, 'id_transaksi_service', 'id_transaksi_service');
    }

    public function platKendaraan()
    {
        return $this->belongsTo(PlatKendaraan::class, 'id_plat_kendaraan', 'id_plat_kendaraan');
    }

    public function riwayatPerbaikan()
    {
        return $this->hasMany(RiwayatPerbaikan::class, 'id_pembayaran', 'id_pembayaran');
    }
}