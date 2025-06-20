<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceList extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'full_name',
        'plat_kendaraan',
        'id_booking',
        'tgl_booking',
        'kendaraan',
        'cc_kendaraan',
        'note',
        'estimate_time',
        'mechanic',
        'service_items',
        'total_price',
    ];

    protected $casts = [
        'tgl_booking' => 'date',
        'service_items' => 'array',
        'total_ price' => 'decimal:0',
        'cc_kendaraan' => 'integer',
    ];
}
