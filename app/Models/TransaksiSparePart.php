<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSparePart extends Model
{
    use HasFactory;

    protected $table = 'transaksi_spare_parts';
    protected $primaryKey = 'id_transaksi_barang';
    public $incrementing = true;

    protected $fillable = [
        'id_barang',
        'kuantitas_barang',
        'subtotal_barang',
    ];

    protected $casts = [
        'kuantitas_barang' => 'integer',
        'subtotal_barang' => 'integer',
    ];

    // Relationships
    public function sparePart()
    {
        return $this->belongsTo(SparePart::class, 'id_barang', 'id_barang');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_transaksi_barang', 'id_transaksi_barang');
    }
}