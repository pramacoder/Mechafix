<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JaOcero\FilaChat\Traits\HasFilaChat;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasFilaChat;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'id');
    }

    public function mekanik()
    {
        return $this->hasOne(Mekanik::class, 'id', 'id');
    }

    public function konsumen()
    {
        return $this->hasOne(Konsumen::class, 'id', 'id');
    }

    // checking the role
    public function isMekanik()
    {
        return $this->role === 'mekanik';
    }

    public function isKonsumen()
    {
        return $this->role === 'konsumen';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }   
}