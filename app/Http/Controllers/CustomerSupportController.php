<?php

namespace App\Http\Controllers;

use App\Models\SupportAgent;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class CustomerSupportController extends Controller
{
    public function selectDepartment(Request $request)
    {
        $request->validate([
            'support_department_id' => ['required', 'exists:support_departments,id'],
        ]);

        $contact_id = Session::get('customer_portal_user')[0] ?? null;
        $customer = Contact::where('id', $contact_id)->where('active', 1)->first();

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found.'
            ], 401);
        }

        $existingConversation = SupportConversation::where('customer_id', $customer->id)
            ->whereIn('status', ['waiting', 'active'])
            ->latest()
            ->first();

        if ($existingConversation) {
            return response()->json([
                'status' => true,
                'conversation_id' => $existingConversation->id,
                'assigned_agent_id' => $existingConversation->assigned_agent_id,
                'message' => 'Existing conversation loaded.',
            ]);
        }

        $assignedAgent = $this->findAvailableAgent($request->support_department_id);

        DB::beginTransaction();

        try {
            if ($assignedAgent) {
                $notification = new Notification();
                $notification->notification_title = "New Support Conversation Started by {$customer->name}";
                $notification->notification_message = "Customer {$customer->name} has started a new support conversation.";
                $notification->is_read = 0;
                $notification->user_id = $assignedAgent->user_id ?? null;
                $notification->order_id = null;
                $notification->save();
            }

            $conversation = SupportConversation::create([
                'customer_id' => $customer->id,
                'support_department_id' => $request->support_department_id,
                'assigned_agent_id' => $assignedAgent ? $assignedAgent->id : null,
                'status' => $assignedAgent ? 'active' : 'waiting',
                'priority' => 'normal',
                'started_at' => now(),
                'last_message_at' => now(),
            ]);

            if ($assignedAgent) {
                $agentName = $assignedAgent->user->name ?? ('Agent #' . $assignedAgent->id);

                SupportMessage::create([
                    'support_conversation_id' => $conversation->id,
                    'sender_type' => 'system',
                    'sender_id' => null,
                    'message' => "Agent {$agentName} assigned.",
                    'is_read' => false,
                ]);
            } else {
                SupportMessage::create([
                    'support_conversation_id' => $conversation->id,
                    'sender_type' => 'system',
                    'sender_id' => null,
                    'message' => 'Waiting for support agent.',
                    'is_read' => false,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'conversation_id' => $conversation->id,
                'assigned_agent_id' => $conversation->assigned_agent_id,
                'message' => $assignedAgent
                    ? 'Support conversation created and agent assigned.'
                    : 'Support conversation created. Waiting for available agent.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            \Log::error('Customer conversation create failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to create support conversation.',
            ], 500);
        }
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:support_conversations,id'],
            'message' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,zip,txt'],
        ]);

        $contact_id = Session::get('customer_portal_user')[0] ?? null;
        $customer = Contact::where('id', $contact_id)->where('active', 1)->first();

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found.'
            ], 401);
        }

        $conversation = SupportConversation::where('id', $request->conversation_id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$conversation) {
            return response()->json([
                'status' => false,
                'message' => 'Conversation not found.'
            ], 404);
        }

        if ($conversation->status === 'closed') {
            return response()->json([
                'status' => false,
                'message' => 'This conversation is already closed.'
            ], 422);
        }

        $messageText = trim((string) $request->input('message', ''));
        $attachmentPath = null;
        $attachmentName = null;
        $attachmentType = null;
        $attachmentMime = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $folder = 'customer_chat/' . $conversation->id;
            $originalName = $file->getClientOriginalName();
            $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9\.\-\_]/', '_', $originalName);

            $attachmentPath = $file->storeAs($folder, $safeName, 'public');
            $attachmentName = $originalName;
            $attachmentMime = $file->getMimeType();
            $attachmentType = strpos($attachmentMime, 'image/') === 0 ? 'image' : 'document';
        }

        if ($messageText === '' && !$attachmentPath) {
            return response()->json([
                'status' => false,
                'message' => 'Message or attachment is required.'
            ], 422);
        }

        $message = SupportMessage::create([
            'support_conversation_id' => $conversation->id,
            'sender_type' => 'customer',
            'sender_id' => $customer->id,
            'message' => $messageText !== '' ? $messageText : null,
            'attachment_name' => $attachmentName,
            'attachment_path' => empty($attachmentPath) ? null : 'app/public/' . $attachmentPath,
            'attachment_type' => $attachmentType,
            'attachment_mime' => $attachmentMime,
            'is_read' => false,
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Message sent successfully.',
            'data' => $this->formatMessage($message),
        ]);
    }

    public function messages(SupportConversation $conversation)
    {
        $contact_id = Session::get('customer_portal_user')[0] ?? null;
        $customer = Contact::where('id', $contact_id)->where('active', 1)->first();

        if (!$customer || (int) $conversation->customer_id !== (int) $customer->id) {
            abort(403);
        }

        $messages = SupportMessage::where('support_conversation_id', $conversation->id)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($message) {
                return $this->formatMessage($message);
            });

        return response()->json([
            'status' => true,
            'conversation_id' => $conversation->id,
            'conversation_status' => $conversation->status,
            'assigned_agent_id' => $conversation->assigned_agent_id,
            'messages' => $messages,
        ]);
    }

    public function poll(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:support_conversations,id'],
            'last_message_id' => ['nullable', 'integer'],
        ]);

        $contact_id = Session::get('customer_portal_user')[0] ?? null;
        $customer = Contact::where('id', $contact_id)->where('active', 1)->first();

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found.'
            ], 401);
        }

        $conversation = SupportConversation::where('id', $request->conversation_id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$conversation) {
            return response()->json([
                'status' => false,
                'message' => 'Conversation not found.'
            ], 404);
        }

        $lastMessageId = (int) $request->input('last_message_id', 0);

        $messages = SupportMessage::where('support_conversation_id', $conversation->id)
            ->where('id', '>', $lastMessageId)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($message) {
                return $this->formatMessage($message);
            });

        return response()->json([
            'status' => true,
            'conversation_id' => $conversation->id,
            'conversation_status' => $conversation->status,
            'assigned_agent_id' => $conversation->assigned_agent_id,
            'messages' => $messages,
        ]);
    }

    private function formatMessage($message)
    {
        return [
            'id' => $message->id,
            'support_conversation_id' => $message->support_conversation_id,
            'sender_type' => $message->sender_type,
            'sender_id' => $message->sender_id,
            'message' => $message->message,
            'attachment_name' => $message->attachment_name,
            'attachment_path' => $message->attachment_path,
            'attachment_type' => $message->attachment_type,
            'attachment_mime' => $message->attachment_mime,
            'attachment_url' => $message->attachment_path ? asset('storage/' . $message->attachment_path) : null,
            'created_at' => $message->created_at ? $message->created_at->format('Y-m-d h:i A') : null,
        ];
    }

    private function getAgentDisplayName($agent)
    {
        return optional($agent->user)->name ?: ('Agent #' . $agent->id);
    }

    private function findAvailableAgent($departmentId)
    {
        $agents = SupportAgent::with('user')
            ->where('is_online', true)
            ->where('is_available', true)
            ->whereHas('departments', function ($query) use ($departmentId) {
                $query->where('support_departments.id', $departmentId);
            })
            ->withCount([
                'assignedConversations as active_chats_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->orderBy('active_chats_count', 'asc')
            ->get();

        foreach ($agents as $agent) {
            if ((int) $agent->active_chats_count < (int) $agent->max_active_chats) {
                return $agent;
            }
        }

        return null;
    }
}
