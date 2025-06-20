<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'Id_Karyawan',
        'name',
        'role',
        'sallary',
        'email',
        'phone',
    ];
}
