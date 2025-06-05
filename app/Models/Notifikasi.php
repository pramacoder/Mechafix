<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'isi_notifikasi',
        'id_konsumen',
    ];

    protected $casts = [
        'isi_notifikasi' => 'string',
    ];

    // Relationships
    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen', 'id_konsumen');
    }
}