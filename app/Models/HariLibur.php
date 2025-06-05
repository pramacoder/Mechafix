<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    use HasFactory;

    protected $table = 'hari_libur';
    protected $primaryKey = 'id_hari_libur';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_hari_libur',
        'tanggal_mulai',
        'tanggal_berakhir',
        'keterangan',
        'id_admin',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}