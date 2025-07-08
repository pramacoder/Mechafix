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

    public function isPagiShift()
    {
        return $this->shift_kerja === 'Pagi';
    }

    public function isSoreShift()
    {
        return $this->shift_kerja === 'Sore';
    }

    public function sentMessages()
    {
        return $this->morphMany(FilachatMessage::class, 'senderable');
    }

    public function receivedMessages()
    {
        return $this->morphMany(FilachatMessage::class, 'receiverable');
    }

    public function sentConversations()
    {
        return $this->morphMany(FilachatConversation::class, 'senderable');
    }

    public function receivedConversations()
    {
        return $this->morphMany(FilachatConversation::class, 'receiverable');
    }
}