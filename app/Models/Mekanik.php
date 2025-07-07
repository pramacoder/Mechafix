<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    use HasFactory;

    protected $table = 'mekaniks';
    protected $primaryKey = 'id_mekanik';
    public $incrementing = true;

    protected $fillable = [
        'id_mekanik',
        'kuantitas_hari',
    ];

    protected $casts = [
        'kuantitas_hari' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function riwayatPerbaikans()
    {
        return $this->hasMany(RiwayatPerbaikan::class, 'id_mekanik', 'id_mekanik');
    }

    public function bookingServices()
    {
        return $this->hasMany(BookingService::class, 'id_mekanik', 'id_mekanik');
    }
}
