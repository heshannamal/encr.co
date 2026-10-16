<?php

// app/Http/Controllers/ChatController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatChannel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Contact;
use App\Models\Organization;

class ChatController extends Controller
{
    public function startChat(Request $request)
    {
        $contact_id = Session::get('customer_portal_user')[0];
        $organizationId = Session::get('customer_portal_user')[1];
        $contact = Contact::where('id' , $contact_id)->where('active' , 1)->first();
        $organization = Organization::where('id' , $organizationId)->with('contactOrganizations')->first();

        $request->validate([
            'issue_type' => 'required|in:technical,sales',
        ]);

        // Determine assigned user
        if ($request->issue_type === 'technical') {
            $assignedUserId = 1; // Tech support user
        } else {
            $assignedUserId = $organization->user_id; // Org’s user
        }

        // Check if there's an active or open channel already
        $existingChannel = ChatChannel::where('organization_id', $organizationId)
            ->where('issue_type', $request->issue_type)
            ->whereIn('status', ['open', 'active'])
            ->first();

        if ($existingChannel) {
            $channel = $existingChannel;
        } else {
            // Create a new one if none found or previous closed
            $channel = ChatChannel::create([
                'organization_id' => $organizationId,
                'issue_type' => $request->issue_type,
                'assigned_user_id' => $assignedUserId,
                'status' => 'open',
            ]);
        }

        return response()->json([
            'success' => true,
            'channel' => $channel,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'channel_id' => 'required|exists:chat_channels,id',
            'message' => 'required|string',
        ]);

        $user = auth()->user(); // logged-in customer or agent
        $senderType = $user ? 'user' : 'contact';

        $message = ChatMessage::create([
            'channel_id' => $request->channel_id,
            'sender_type' => $senderType,
            'sender_id' => $user->id,
            'message' => $request->message,
        ]);

        // Broadcast for real-time updates
        broadcast(new \App\Events\NewChatMessage($message))->toOthers();

        return response()->json(['success' => true, 'message' => $message]);
    }
}

