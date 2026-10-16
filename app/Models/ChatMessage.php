<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'channel_id', 'sender_type', 'sender_id', 'message', 'is_read'
    ];

    public function channel()
    {
        return $this->belongsTo(ChatChannel::class, 'channel_id');
    }

    public function sender()
    {
        if ($this->sender_type === 'user') {
            return $this->belongsTo(User::class, 'sender_id');
        } else {
            return $this->belongsTo(Contact::class, 'sender_id');
        }
    }
}
