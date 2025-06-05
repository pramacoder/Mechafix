<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $primaryKey = 'id_service';
    public $incrementing = true;

    protected $fillable = [
        'nama_service',
        'jenis_service',
        'biaya_service',
        'estimasi_waktu',
    ];

    protected $casts = [
        'nama_service' => 'string',
        'kategori_service' => 'string',
        'biaya_service' => 'integer',
        'estimasi_waktu' => 'integer',
    ];

    // Relationships
    public function transaksiService()
    {
        return $this->hasMany(TransaksiService::class, 'id_service', 'id_service');
    }
}