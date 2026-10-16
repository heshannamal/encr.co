<?php

namespace App\Events;

use App\Models\SupportConversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class SupportConversationCreated implements ShouldBroadcastNow
{
    use SerializesModels;

    public $conversationData;

    public function __construct(SupportConversation $conversation)
    {
        $conversation->load(['customer', 'department', 'messages']);

        $customerName = $conversation->customer->name
            ?? $conversation->customer->first_name
            ?? 'Customer';

        $lastMessage = $conversation->messages->last();

        $this->conversationData = [
            'id' => $conversation->id,
            'customer_name' => $customerName,
            'department_name' => $conversation->department->name ?? 'Support',
            'status' => ucfirst($conversation->status),
            'last_message' => $lastMessage->message ?? 'No messages yet',
            'last_message_at' => $conversation->last_message_at
                ? $conversation->last_message_at->format('h:i A')
                : '',
            'avatar' => asset('assets/img/organization/default.png'),
        ];
    }

    public function broadcastOn()
    {
        return new Channel('support-admin');
    }

    public function broadcastAs()
    {
        return 'SupportConversationCreated';
    }
}
