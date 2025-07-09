<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilachatConversation extends Model
{
    use HasFactory;

    protected $table = 'filachat_conversations';

    protected $fillable = [
        'senderable_id',
        'senderable_type',
        'receiverable_id',
        'receiverable_type',
    ];

    // Polymorphic relationships
    public function senderable()
    {
        return $this->morphTo();
    }

    public function receiverable()
    {
        return $this->morphTo();
    }

    // Alias untuk sender dan receiver (backward compatibility)
    public function sender()
    {
        return $this->senderable();
    }

    public function receiver()
    {
        return $this->receiverable();
    }

    public function messages()
    {
        return $this->hasMany(FilachatMessage::class, 'filachat_conversation_id');
    }

    // Helper methods
    public function getOtherParticipant($currentUser)
    {
        if ($currentUser instanceof \App\Models\Konsumen) {
            return $this->receiverable;
        } else {
            return $this->senderable;
        }
    }

    public function latestMessage()
    {
        return $this->hasOne(FilachatMessage::class, 'filachat_conversation_id')->latest();
    }
}