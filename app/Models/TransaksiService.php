<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiService extends Model
{
    use HasFactory;

    protected $table = 'transaksi_services';
    protected $primaryKey = 'id_transaksi_service';
    public $incrementing = true;

    protected $fillable = [
        'id_service',
        'kuantitas_service',
        'subtotal_service',
    ];

    protected $casts = [
        'kuantitas_service' => 'integer',
        'subtotal_service' => 'integer',
    ];

    // Relationships
    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service', 'id_service');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_transaksi_service', 'id_transaksi_service');
    }
}