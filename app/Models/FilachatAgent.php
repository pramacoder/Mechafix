<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilachatAgent extends Model
{
    use HasFactory;

    protected $fillable = [
        'agentable_id',
        'agentable_type',
        'role',
    ];

    public function agentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversationsAsKonsumen()
    {
        return $this->hasMany(FilachatConversation::class, 'id_konsumen');
    }

    public function conversationsAsMekanik()
    {
        return $this->hasMany(FilachatConversation::class, 'id_mekanik');
    }
}
