<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SupportAgent;
use App\Models\SupportMessage;
use App\Models\SupportTransfer;
use App\Models\SupportConversation;
use App\Models\SupportDepartment;

class AdminSupportController extends Controller
{
    public function index()
    {
        $agent = SupportAgent::where('user_id', auth()->id())->first();
        if(!$agent){
             $conversations = collect();
        }else{
            $conversations = SupportConversation::with([
                    'customer',
                    'department',
                    'messages'
                ])
                ->when($agent, function ($query) use ($agent) {
                    $query->where(function ($q) use ($agent) {
                        $q->where('assigned_agent_id', $agent->id)
                        ->orWhereNull('assigned_agent_id');
                    });
                })
                ->orderByDesc('last_message_at')
                ->get();
        }
        $selectedConversation = null;

        $agents = SupportAgent::with(['user', 'departments'])
            ->where('id', '!=', optional($agent)->id)
            ->get();

        $departments = SupportDepartment::where('is_active', true)->get();

        return view('pages.customer_support.index', compact(
            'conversations',
            'selectedConversation',
            'agents',
            'departments'
        ));
    }

    public function getMessages(SupportConversation $conversation)
    {
        $conversation->load(['customer', 'department', 'messages', 'assignedAgent.user']);

        return response()->json([
            'status' => true,
            'conversation' => [
                'id' => $conversation->id,
                'customer_name' => $conversation->customer->name ?? $conversation->customer->first_name ?? 'Customer',
                'department_name' => $conversation->department->name ?? 'Support',
                'status' => ucfirst($conversation->status),
                'assigned_agent_id' => $conversation->assigned_agent_id,
                'assigned_agent_name' => optional(optional($conversation->assignedAgent)->user)->name,
            ],
            'messages' => $conversation->messages
                ->sortBy('id')
                ->values()
                ->map(function ($message) {
                    return $this->formatMessage($message);
                }),
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:support_conversations,id'],
            'message' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,zip,txt'],
        ]);

        $user = auth()->user();
        $agent = SupportAgent::with('user')->where('user_id', $user->id)->first();

        if (!$agent) {
            return response()->json([
                'status' => false,
                'message' => 'Support agent not found.'
            ], 403);
        }

        $conversation = SupportConversation::with('assignedAgent')
            ->findOrFail($request->conversation_id);

        if ($conversation->status === 'closed') {
            return response()->json([
                'status' => false,
                'message' => 'Conversation is already closed.'
            ], 422);
        }

        if ($conversation->assigned_agent_id && (int) $conversation->assigned_agent_id !== (int) $agent->id) {
            return response()->json([
                'status' => false,
                'message' => 'This conversation is assigned to another agent.'
            ], 403);
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

        DB::beginTransaction();

        try {
            $wasUnassigned = !$conversation->assigned_agent_id;

            if ($wasUnassigned) {
                $conversation->assigned_agent_id = $agent->id;
                $conversation->status = 'active';
                $conversation->save();

                $agentName = $agent->user->name ?? ('Agent #' . $agent->id);

                SupportMessage::create([
                    'support_conversation_id' => $conversation->id,
                    'sender_type' => 'system',
                    'sender_id' => null,
                    'message' => "Agent {$agentName} assigned.",
                    'is_read' => false,
                ]);
            }

            $message = SupportMessage::create([
                'support_conversation_id' => $conversation->id,
                'sender_type' => 'agent',
                'sender_id' => $agent->id,
                'message' => $messageText !== '' ? $messageText : null,
                'attachment_name' => $attachmentName,
                'attachment_path' => empty($attachmentPath) ? null : 'app/public/' . $attachmentPath,
                'attachment_type' => $attachmentType,
                'attachment_mime' => $attachmentMime,
                'is_read' => false,
            ]);

            $conversation->update([
                'assigned_agent_id' => $conversation->assigned_agent_id,
                'status' => 'active',
                'last_message_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Message sent successfully.',
                'data' => [
                    'id' => $message->id,
                    'support_conversation_id' => $message->support_conversation_id,
                    'sender_type' => $message->sender_type,
                    'message' => $message->message,
                    'attachment_name' => $message->attachment_name,
                    'attachment_path' => $message->attachment_path,
                    'attachment_type' => $message->attachment_type,
                    'attachment_mime' => $message->attachment_mime,
                    'attachment_url' => $message->attachment_path
                        ? asset('storage/' . str_replace('app/public/', '', $message->attachment_path))
                        : null,
                    'created_at' => $message->created_at
                        ? $message->created_at->format('Y-m-d h:i A')
                        : null,
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            \Log::error('Admin send message failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to send message.',
            ], 500);
        }
    }

    public function pollMessages(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:support_conversations,id'],
            'last_message_id' => ['nullable', 'integer'],
        ]);

        $conversation = SupportConversation::with(['customer', 'department', 'assignedAgent.user'])
            ->findOrFail($request->conversation_id);

        $lastMessageId = (int) $request->input('last_message_id', 0);

        $messages = SupportMessage::where('support_conversation_id', $conversation->id)
            ->where('id', '>', $lastMessageId)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($message) {
                $data = $this->formatMessage($message);
                $data['unread_count'] = SupportMessage::where('support_conversation_id', $message->support_conversation_id)
                    ->where('sender_type', 'customer')
                    ->where('is_read', false)
                    ->count();

                return $data;
            })
            ->values();

        return response()->json([
            'status' => true,
            'conversation' => [
                'id' => $conversation->id,
                'customer_name' => $conversation->customer->name ?? $conversation->customer->first_name ?? 'Customer',
                'department_name' => $conversation->department->name ?? 'Support',
                'status' => ucfirst($conversation->status),
                'assigned_agent_id' => $conversation->assigned_agent_id,
                'assigned_agent_name' => optional(optional($conversation->assignedAgent)->user)->name,
            ],
            'messages' => $messages,
        ]);
    }

    public function sidebarList()
    {
        $agent = SupportAgent::where('user_id', auth()->id())->first();

        $conversations = SupportConversation::with([
                'customer',
                'department',
                'assignedAgent.user',
                'messages' => function ($query) {
                    $query->latest('id');
                }
            ])
            ->when($agent, function ($query) use ($agent) {
                $query->where(function ($q) use ($agent) {
                    $q->where('assigned_agent_id', $agent->id)
                      ->orWhereNull('assigned_agent_id');
                });
            })
            ->orderByDesc('last_message_at')
            ->get()
            ->map(function ($conversation) {
                $lastMessage = $conversation->messages->sortByDesc('id')->first();

                return [
                    'id' => $conversation->id,
                    'customer_name' => $conversation->customer->name ?? $conversation->customer->first_name ?? 'Customer',
                    'avatar' => asset('assets/img/organization/default.png'),
                    'department_name' => $conversation->department->name ?? 'Support',
                    'status' => ucfirst($conversation->status),
                    'assigned_agent_id' => $conversation->assigned_agent_id,
                    'assigned_agent_name' => optional(optional($conversation->assignedAgent)->user)->name,
                    'last_message' => $lastMessage
                        ? ($lastMessage->message ?: ($lastMessage->attachment_name ? '📎 ' . $lastMessage->attachment_name : 'No messages yet'))
                        : 'No messages yet',
                    'last_message_at' => $conversation->last_message_at
                        ? $conversation->last_message_at->format('h:i A')
                        : '',
                    'last_message_date' => $conversation->last_message_at
                        ? $conversation->last_message_at->format('Y-m-d')
                        : '',
                    'unread_count' => \App\Models\SupportMessage::where('support_conversation_id', $conversation->id)
                        ->where('sender_type', 'customer')
                        ->where('is_read', false)
                        ->count(),
                ];
            })
            ->values();

        return response()->json([
            'status' => true,
            'conversations' => $conversations,
        ]);
    }

    public function closeConversation(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:support_conversations,id'],
            'message' => ['required', 'string'],
        ]);

        $user = auth()->user();
        $agent = SupportAgent::where('user_id', $user->id)->first();

        if (!$agent) {
            return response()->json([
                'status' => false,
                'message' => 'Support agent not found.'
            ], 403);
        }

        $conversation = SupportConversation::findOrFail($request->conversation_id);

        if ($conversation->status === 'closed') {
            return response()->json([
                'status' => false,
                'message' => 'Conversation is already closed.'
            ], 422);
        }

        $message = SupportMessage::create([
            'support_conversation_id' => $conversation->id,
            'sender_type' => 'agent',
            'sender_id' => $agent->id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        $conversation->update([
            'status' => 'closed',
            'closed_at' => now(),
            'last_message_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Conversation closed successfully.',
            'data' => $this->formatMessage($message),
        ]);
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:support_conversations,id'],
            'to_department_id' => ['required', 'exists:support_departments,id'],
            'to_agent_id' => ['nullable', 'exists:support_agents,id'],
            'reason' => ['nullable', 'string'],
        ]);

        $user = auth()->user();
        $fromAgent = SupportAgent::where('user_id', $user->id)->first();

        if (!$fromAgent) {
            return response()->json([
                'status' => false,
                'message' => 'Support agent not found.'
            ], 403);
        }

        $conversation = SupportConversation::findOrFail($request->conversation_id);

        $fromDepartmentId = $conversation->support_department_id;
        $toDepartmentId = (int) $request->to_department_id;

        $toAgent = null;

        if (!empty($request->to_agent_id)) {
            $toAgent = SupportAgent::with(['departments', 'user'])->findOrFail($request->to_agent_id);

            if ((int) $toAgent->id === (int) $fromAgent->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'You cannot transfer to yourself.'
                ], 422);
            }

            if (!$toAgent->is_available) {
                return response()->json([
                    'status' => false,
                    'message' => 'Selected agent is not available.'
                ], 422);
            }

            if (!$toAgent->is_online) {
                return response()->json([
                    'status' => false,
                    'message' => 'Selected agent is offline.'
                ], 422);
            }

            $belongsToDepartment = $toAgent->departments()
                ->where('support_departments.id', $toDepartmentId)
                ->exists();

            if (!$belongsToDepartment) {
                return response()->json([
                    'status' => false,
                    'message' => 'Selected agent does not belong to selected department.'
                ], 422);
            }
        } else {
            $toAgent = $this->findAvailableAgent($toDepartmentId, $fromAgent->id);
        }

        DB::beginTransaction();

        try {
            SupportTransfer::create([
                'support_conversation_id' => $conversation->id,
                'from_agent_id' => $fromAgent->id,
                'to_agent_id' => $toAgent ? $toAgent->id : null,
                'from_department_id' => $fromDepartmentId,
                'to_department_id' => $toDepartmentId,
                'reason' => $request->reason,
            ]);

            $conversation->update([
                'support_department_id' => $toDepartmentId,
                'assigned_agent_id' => $toAgent ? $toAgent->id : null,
                'status' => $toAgent ? 'active' : 'waiting',
                'closed_at' => null,
                'last_message_at' => now(),
            ]);

            SupportMessage::create([
                'support_conversation_id' => $conversation->id,
                'sender_type' => 'system',
                'sender_id' => null,
                'message' => $this->buildTransferMessage($toDepartmentId, $toAgent, $request->reason),
                'is_read' => false,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $toAgent
                    ? 'Conversation transferred successfully.'
                    : 'Conversation moved to new department and is waiting for available agent.',
                'conversation_id' => $conversation->id,
                'assigned_agent_id' => $toAgent ? $toAgent->id : null,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            \Log::error('Transfer failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Transfer failed.',
            ], 500);
        }
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
            'created_at' => $message->created_at
                ? $message->created_at->format('Y-m-d h:i A')
                : null,
        ];
    }

    private function getAgentDisplayName($agent)
    {
        return optional($agent->user)->name ?: ('Agent #' . $agent->id);
    }

    private function findAvailableAgent($departmentId, $excludeAgentId = null)
    {
        $agents = SupportAgent::with('user')
            ->where('is_online', true)
            ->where('is_available', true)
            ->when($excludeAgentId, function ($query) use ($excludeAgentId) {
                $query->where('id', '!=', $excludeAgentId);
            })
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

    private function buildTransferMessage($toDepartmentId, $toAgent = null, $reason = null)
    {
        $department = SupportDepartment::find($toDepartmentId);
        $departmentName = $department->name ?? 'another department';

        $message = "Conversation transferred to {$departmentName}";

        if ($toAgent) {
            $agentName = optional($toAgent->user)->name ?: ('Agent #' . $toAgent->id);
            $message .= " and assigned to {$agentName}";
        } else {
            $message .= " and is waiting for an available agent";
        }

        if ($reason) {
            $message .= ". Reason: {$reason}";
        }

        return $message;
    }

    public function markRead(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:support_conversations,id'],
        ]);

        $user = auth()->user();
        $agent = \App\Models\SupportAgent::where('user_id', $user->id)->first();

        if (!$agent) {
            return response()->json([
                'status' => false,
                'message' => 'Support agent not found.'
            ], 403);
        }

        $conversation = \App\Models\SupportConversation::findOrFail($request->conversation_id);

        // if no assigned agent, do not return error
        if ($conversation->assigned_agent_id && (int) $conversation->assigned_agent_id !== (int) $agent->id) {
            return response()->json([
                'status' => false,
                'message' => 'This conversation is assigned to another agent.'
            ], 403);
        }

        \App\Models\SupportMessage::where('support_conversation_id', $conversation->id)
            ->where('sender_type', 'customer')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Messages marked as read.'
        ]);
    }

    public function deleteConversation(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:support_conversations,id'],
        ]);

        $user = auth()->user();
        $agent = \App\Models\SupportAgent::where('user_id', $user->id)->first();

        if (!$agent) {
            return response()->json([
                'status' => false,
                'message' => 'Support agent not found.'
            ], 403);
        }

        $conversation = \App\Models\SupportConversation::findOrFail($request->conversation_id);

        // if no assigned agent, do not return error
        if ($conversation->assigned_agent_id && (int) $conversation->assigned_agent_id !== (int) $agent->id) {
            return response()->json([
                'status' => false,
                'message' => 'This conversation is assigned to another agent.'
            ], 403);
        }

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            \App\Models\SupportMessage::where('support_conversation_id', $conversation->id)->delete();

            if (class_exists(\App\Models\SupportTransfer::class)) {
                \App\Models\SupportTransfer::where('support_conversation_id', $conversation->id)->delete();
            }

            $conversation->delete();

            \Illuminate\Support\Facades\DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Conversation deleted successfully.'
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\DB::rollBack();

            \Log::error('Delete conversation failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to delete conversation.'
            ], 500);
        }
    }
}
