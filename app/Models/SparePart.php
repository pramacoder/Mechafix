<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;

    protected $table = 'spare_parts';
    protected $primaryKey = 'id_barang';
    public $incrementing = true;

    protected $fillable = [
        'nama_barang',
        'deskripsi_barang',
        'harga_barang',
        'kuantitas_barang',
        'gambar_barang',
        'link_shopee',
    ];

    protected $casts = [
        'nama_barang' => 'string',
        'deskripsi_barang' => 'string',
        'harga_barang' => 'integer',
        'banyak_barang' => 'integer',
        'gambar_barang' => 'string',
        'link_shopee' => 'string',
    ];

    // Relationships
    public function transaksiSparePart()
    {
        return $this->hasMany(TransaksiSparePart::class, 'id_barang', 'id_barang');
    }
}