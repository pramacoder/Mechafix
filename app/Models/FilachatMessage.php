<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilachatMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'filachat_messages';

    protected $fillable = [
        'filachat_conversation_id',
        'message',
        'attachments',
        'original_attachment_file_names',
        'reactions',
        'is_starred',
        'metadata',
        'reply_to_message_id',
        'senderable_id',
        'senderable_type',
        'receiverable_id',
        'receiverable_type',
        'last_read_at',
        'edited_at',
        'sender_deleted_at',
        'receiver_deleted_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'original_attachment_file_names' => 'array',
        'reactions' => 'array',
        'metadata' => 'array',
        'is_starred' => 'boolean',
        'last_read_at' => 'datetime',
        'edited_at' => 'datetime',
        'sender_deleted_at' => 'datetime',
        'receiver_deleted_at' => 'datetime',
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

    // Alias untuk backward compatibility
    public function sender()
    {
        return $this->senderable();
    }

    public function receiver()
    {
        return $this->receiverable();
    }

    public function conversation()
    {
        return $this->belongsTo(FilachatConversation::class, 'filachat_conversation_id');
    }

    public function replyToMessage()
    {
        return $this->belongsTo(FilachatMessage::class, 'reply_to_message_id');
    }

    public function replies()
    {
        return $this->hasMany(FilachatMessage::class, 'reply_to_message_id');
    }

    // Helper methods
    public function isFromUser($user)
    {
        if ($user instanceof \App\Models\Konsumen) {
            return $this->senderable_type === 'App\Models\Konsumen' && 
                   $this->senderable_id === $user->id_konsumen;
        }
        
        return false;
    }

    public function getSenderName()
    {
        switch ($this->senderable_type) {
            case 'App\Models\Konsumen':
                return $this->senderable->user->name ?? 'Konsumen';
            case 'App\Models\Admin':
                return $this->senderable->user->name ?? 'Admin';
            case 'App\Models\Mekanik':
                return $this->senderable->user->name ?? 'Mekanik';
            default:
                return 'Unknown';
        }
    }
}