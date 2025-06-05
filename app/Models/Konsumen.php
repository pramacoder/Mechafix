<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsumen extends Model
{
    use HasFactory;

    protected $table = 'konsumens';
    protected $primaryKey = 'id_konsumen';
    public $incrementing = true;

    protected $fillable = [
        'alamat_konsumen',
        'id',
    ];

    protected $casts = [
        'nama_konsumen' => 'string',
        'alamat_konsumen' => 'string',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function platKendaraan()
    {
        return $this->hasMany(PlatKendaraan::class, 'id_konsumen', 'id_konsumen');
    }

    public function bookingService()
    {
        return $this->hasMany(BookingService::class, 'id_konsumen', 'id_konsumen');
    }
}