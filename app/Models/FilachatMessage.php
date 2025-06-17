<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilachatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'filachat_conversation_id',
        'message',
        'senderable_id',
        'senderable_type',
        'receiverable_id',
        'receiverable_type',
        'is_starred',
        'reply_to_message_id',
        'attachments',
        'original_attachment_file_names',
        'reactions',
        'metadata',
        'last_read_at',
        'edited_at',
        'sender_deleted_at',
        'receiver_deleted_at',
    ];

    public function conversation()
    {
        return $this->belongsTo(FilachatConversation::class, 'filachat_conversation_id');
    }

    public function sender()
    {
        return $this->morphTo(__FUNCTION__, 'senderable_type', 'senderable_id');
    }

    public function receiverable()
    {
        return $this->morphTo('receiverable');
    }
}
