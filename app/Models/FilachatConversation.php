<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilachatConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'senderable_id',
        'senderable_type',
        'receiverable_id',
        'receiverable_type',
    ];

    public function sender()
    {
        return $this->morphTo(__FUNCTION__, 'senderable_type', 'senderable_id');
    }

    public function receiver()
    {
        return $this->morphTo(__FUNCTION__, 'receiverable_type', 'receiverable_id');
    }

    public function messages()
    {
        return $this->hasMany(FilachatMessage::class, 'filachat_conversation_id');
    }
}
