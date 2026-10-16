<?php

namespace App\Events;

use App\Models\SupportMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class SupportMessageSent implements ShouldBroadcastNow
{
    use SerializesModels;

    public $messageData;
    public $conversationId;

    public function __construct(SupportMessage $message)
    {
        $this->conversationId = $message->support_conversation_id;

        $this->messageData = [
            'id' => $message->id,
            'support_conversation_id' => $message->support_conversation_id,
            'sender_type' => $message->sender_type,
            'sender_id' => $message->sender_id,
            'message' => $message->message,
            'created_at' => $message->created_at->format('h:i A'),
        ];
    }

    public function broadcastOn()
    {
        return new Channel('support-conversation.' . $this->conversationId);
    }

    public function broadcastAs()
    {
        return 'SupportMessageSent';
    }
}
