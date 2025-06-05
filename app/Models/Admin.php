<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';
    protected $primaryKey = 'id_admin';
    public $incrementing = true;

    protected $fillable = [
        'shift_kerja',
        'gaji',
        'id',
    ];

    protected $casts = [
        'shift_kerja' => 'enum: Pagi, Sore',
        'gaji' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function hariLibur()
    {
        return $this->hasMany(HariLibur::class, 'id_admin', 'id_admin');
    }    
}