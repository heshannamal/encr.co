@extends('layouts.app', ['activePage' => 'customer_supports', 'titlePage' => __('Customer Supports')])

@section('content')
<audio id="newMessageSound" preload="auto">
    <source src="{{ asset('assets/customer_portal/assets/sms.mp3') }}" type="audio/mpeg">
</audio>

<style>
    .cs-chat-application {
        height: 75vh;
        background: #fff;
        display: flex;
        overflow: hidden;
        position: relative;
        border-radius: 0.5rem;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        width: 100%;
    }

    .cs-chat-body {
        background-color: #f8f9fa;
        overflow-y: auto;
    }

    .cs-chat-sidebar {
        width: 350px;
        border-right: 1px solid #ddd;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        background: #fff;
    }

    .cs-chat-item:hover {
        background-color: #f5f5f5;
    }

    .cs-chat-item.active {
        background-color: #ebebeb;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .btn-icon {
        border: none;
        background: transparent;
        padding: 0.5rem;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon:hover {
        background-color: rgba(0,0,0,0.05);
    }

    .input-group-merge {
        box-shadow: none !important;
        border: 1px solid #eee;
    }

    .cs-message-search-bar {
        display: none;
        border-bottom: 1px solid #eee;
        background: #fff;
    }

    .cs-message-search-bar.open {
        display: block;
    }

    .message.message-hidden-by-search {
        display: none !important;
    }

    .message-search-empty {
        display: none;
    }

    .message-search-empty.show {
        display: block;
    }

    .cs-header-actions {
        position: relative;
    }

    .cs-header-menu {
        position: absolute;
        top: 42px;
        right: 0;
        min-width: 180px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        z-index: 200;
        display: none;
        overflow: hidden;
    }

    .cs-header-menu.open {
        display: block;
    }

    .cs-header-menu button {
        width: 100%;
        border: 0;
        background: #fff;
        text-align: left;
        padding: 10px 14px;
        font-size: 14px;
    }

    .cs-header-menu button:hover {
        background: #f7f7f7;
    }

    .message-system {
        display: flex;
        justify-content: center;
        margin-bottom: 12px;
    }

    .message-system .message-content {
        background: #eef1f4;
        color: #6c757d;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 12px;
        max-width: 80%;
        text-align: center;
        box-shadow: none;
    }

    @media (max-width: 768px) {
        .cs-chat-sidebar {
            width: 100%;
            position: absolute;
            height: 100%;
            z-index: 10;
            background: white;
            transition: transform 0.3s ease-in-out;
        }

        .cs-chat-window {
            width: 100%;
        }

        .cs-chat-application.chat-open .cs-chat-sidebar {
            transform: translateX(-100%);
        }

        .cs-chat-application:not(.chat-open) .cs-chat-window {
            display: none !important;
        }

        .cs-chat-application.chat-open .cs-chat-window {
            display: flex !important;
        }
    }
    .as-msg a {
        color: #ffffff;
        text-decoration: underline;
        word-break: break-all;
    }
</style>

<div class="mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Customer Supports</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;" id="scrollTable">
        <div class="card" style="border: unset;">
            <div class="cs-chat-application">

                <div class="cs-chat-sidebar" id="cs-chat-sidebar">
                    <div class="cs-sidebar-header d-flex align-items-center justify-content-between px-3 py-2 border-bottom bg-dark text-white">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/img/organization/default.png') }}" class="rounded-circle mr-2" width="40" height="40" alt="User">
                            <span class="font-weight-bold">Support Chats</span>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-icon" type="button">
                                <i class="fas fa-ellipsis-v text-white"></i>
                            </button>
                        </div>
                    </div>

                    <div class="cs-search-box p-2 bg-white border-bottom">
                        <div class="input-group input-group-merge bg-light rounded-pill">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-0 bg-transparent">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text"
                                   class="form-control border-0 bg-transparent shadow-none"
                                   id="chatSearchInput"
                                   placeholder="Search chats"
                                   style="font-size: 14px;">
                        </div>
                    </div>

                    <div class="cs-chat-list-wrapper" style="overflow-y: auto; flex: 1;">
                        <ul class="list-unstyled mb-0" id="chatList">
                            @forelse($conversations as $conversation)
                                @php
                                    $customerName = $conversation->customer->name ?? $conversation->customer->first_name ?? 'Customer';
                                    $lastMessage = $conversation->messages->sortByDesc('id')->first();
                                    $lastText = $lastMessage
                                        ? ($lastMessage->message ?? ($lastMessage->attachment_name ? '📎 ' . $lastMessage->attachment_name : 'No messages yet'))
                                        : 'No messages yet';
                                    $lastTime = $conversation->last_message_at ? $conversation->last_message_at->format('h:i A') : '';
                                    $unreadCount = $conversation->messages->where('sender_type', 'customer')->where('is_read', false)->count();
                                    $assignedAgentName = optional(optional($conversation->assignedAgent)->user)->name;
                                @endphp

                                <li class="cs-chat-item d-flex align-items-center px-3 py-3 border-bottom cursor-pointer"
                                    data-conversation-id="{{ $conversation->id }}"
                                    data-customer-name="{{ $customerName }}"
                                    data-customer-avatar="{{ asset('assets/img/organization/default.png') }}">

                                    <img src="{{ asset('assets/img/organization/default.png') }}" class="rounded-circle mr-3" width="45" height="45" alt="User">

                                    <div class="cs-chat-info flex-grow-1 overflow-hidden">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center overflow-hidden">
                                                <h6 class="mb-0 text-truncate">{{ $customerName }}</h6>
                                                <span class="badge badge-danger rounded-pill ml-2 conversation-unread-count"
                                                      style="{{ $unreadCount > 0 ? '' : 'display:none;' }}">
                                                    {{ $unreadCount }}
                                                </span>
                                            </div>
                                            <small class="text-muted conversation-time">{{ $lastTime }}</small>
                                        </div>

                                        <p class="mb-0 text-muted text-truncate small conversation-last-message">
                                            {{ $lastText }}
                                        </p>

                                        <small class="text-muted conversation-status-line">
                                            {{ $conversation->department->name ?? 'Support' }}
                                            • {{ ucfirst($conversation->status) }}
                                            @if($assignedAgentName)
                                                • {{ $assignedAgentName }}
                                            @elseif($conversation->status === 'waiting')
                                                • Unassigned
                                            @endif
                                        </small>
                                    </div>
                                </li>
                            @empty
                                <li class="px-3 py-4 text-muted text-center">
                                    No support conversations found.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="cs-chat-window d-flex flex-column flex-grow-1 position-relative" id="cs-chat-window">
                    <div class="cs-chat-header d-flex align-items-center px-3 py-2 border-bottom bg-dark text-white" style="height: 60px;">
                        <button class="btn btn-icon d-md-none mr-2 text-white" onclick="backToSidebar()">
                            <i class="fas fa-arrow-left"></i>
                        </button>

                        <img src="{{ asset('assets/img/organization/default.png') }}" id="header-avatar" class="rounded-circle mr-3" width="40" height="40" alt="User">

                        <div class="flex-grow-1">
                            <h6 class="mb-0 text-white" id="header-name">Select a chat</h6>
                            <small class="text-white-50" id="header-subtitle">No conversation selected</small>
                        </div>

                        <div class="d-flex align-items-center cs-header-actions">
                            <button class="btn btn-sm btn-warning mr-2"
                                    onclick="openTransferModal()"
                                    id="transferButton"
                                    disabled>
                                Transfer
                            </button>

                            <button class="btn btn-sm btn-danger mr-2"
                                    onclick="openCloseModal()"
                                    id="closeButton"
                                    disabled>
                                Close
                            </button>

                            <button class="btn btn-icon" type="button" id="messageSearchToggle">
                                <i class="fas fa-search text-white"></i>
                            </button>

                            <button class="btn btn-icon" type="button" id="headerMenuToggle">
                                <i class="fas fa-ellipsis-v text-white"></i>
                            </button>

                            <div class="cs-header-menu" id="headerMenu">
                                <button type="button" onclick="openDeleteModal()">Delete chat</button>
                            </div>
                        </div>
                    </div>

                    <div class="cs-message-search-bar p-2" id="messageSearchBar">
                        <div class="input-group input-group-merge bg-light rounded-pill">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-0 bg-transparent">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text"
                                   class="form-control border-0 bg-transparent shadow-none"
                                   id="messageSearchInput"
                                   placeholder="Search messages in this chat">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-link text-muted pr-3" type="button" onclick="clearMessageSearch()">Clear</button>
                            </div>
                        </div>
                    </div>

                    <div class="cs-chat-body p-3 flex-grow-1" id="cs-chat-body">
                        <div class="h-100 d-flex align-items-center justify-content-center text-muted">
                            Select a conversation from the left panel.
                        </div>
                    </div>

                    <div class="message-search-empty text-center text-muted py-2" id="messageSearchEmpty">
                        No matching messages found.
                    </div>

                    <input type="file"
                           id="adminAttachmentInput"
                           hidden
                           accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.zip,.txt">

                    <div id="adminAttachmentPreview"
                         class="px-3 py-2 small text-muted bg-white border-top"
                         style="display:none;"></div>

                    <div class="cs-chat-footer px-3 py-2 bg-light d-flex align-items-center">
                        <button class="btn btn-icon mr-2"
                                type="button"
                                onclick="triggerAttachment()"
                                id="attachButton"
                                disabled>
                            <i class="fas fa-paperclip text-secondary"></i>
                        </button>

                        <div class="flex-grow-1 position-relative">
                            <input type="text"
                                   class="form-control rounded-pill border-0 px-3"
                                   id="cs-chat-input"
                                   placeholder="Type a message"
                                   style="padding-right: 40px;"
                                   disabled>
                        </div>

                        <button class="btn btn-icon ml-2 bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;"
                                onclick="sendMessage()"
                                id="sendButton"
                                type="button"
                                disabled>
                            <i class="fas fa-paper-plane" style="font-size: 16px; margin-left: -2px;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="transferChatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="transferChatForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer Conversation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeTransferModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="transfer_conversation_id" name="conversation_id">

                    <div class="form-group">
                        <label>Transfer to Department</label>
                        <select class="form-control" id="transfer_department_id" name="to_department_id" required>
                            <option value="">Select department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Transfer to Agent</label>
                        <select class="form-control" id="transfer_agent_id" name="to_agent_id">
                            <option value="">Auto assign from selected department</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Reason</label>
                        <textarea class="form-control" id="transfer_reason" name="reason" rows="3" placeholder="Optional reason"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeTransferModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Transfer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="closeChatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="closeChatForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Close Conversation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeCloseModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="close_conversation_id" name="conversation_id">

                    <div class="form-group">
                        <label>Closing Message</label>
                        <textarea class="form-control"
                                  id="close_message"
                                  name="message"
                                  rows="4"
                                  placeholder="Type a closing message for the customer."
                                  required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeCloseModal()">Cancel</button>
                    <button type="submit" class="btn btn-danger">Close Conversation</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteChatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="deleteChatForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Conversation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeDeleteModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="delete_conversation_id" name="conversation_id">
                    <p class="mb-0">Are you sure you want to delete this chat?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Chat</button>
                </div>
            </div>
        </form>
    </div>
</div>
@php
    $transferAgents = ($agents ?? collect())->map(function ($agent) {
        return [
            'id' => $agent->id,
            'name' => optional($agent->user)->name ?? ('Agent #'.$agent->id),
            'department_ids' => $agent->departments
                ->pluck('id')
                ->map(function ($id) {
                    return (string) $id;
                })
                ->values()
                ->toArray(),
        ];
    })->values()->toArray();
@endphp

<script>
    window.transferAgents = {!! json_encode($transferAgents) !!};

    console.log('Admin support AJAX polling chat script loaded');


    let currentConversationId = null;
    let currentConversationStatus = null;
    let currentAssignedAgentId = null;
    let currentAssignedAgentName = null;
    let currentDepartmentName = null;
    let pollingInterval = null;
    let sidebarPollingInterval = null;
    let isPollingMessages = false;
    let isPollingSidebar = false;
    let isSendingMessage = false;
    let lastMessageId = 0;
    let suppressMessageSound = false;
    let isInitialConversationLoad = false;

    const chatBody = document.getElementById('cs-chat-body');
    const chatInput = document.getElementById('cs-chat-input');
    const sendButton = document.getElementById('sendButton');
    const attachButton = document.getElementById('attachButton');
    const adminAttachmentInput = document.getElementById('adminAttachmentInput');
    const adminAttachmentPreview = document.getElementById('adminAttachmentPreview');
    const chatList = document.getElementById('chatList');
    const headerName = document.getElementById('header-name');
    const headerSubtitle = document.getElementById('header-subtitle');
    const headerAvatar = document.getElementById('header-avatar');
    const transferConversationIdInput = document.getElementById('transfer_conversation_id');
    const closeConversationIdInput = document.getElementById('close_conversation_id');
    const deleteConversationIdInput = document.getElementById('delete_conversation_id');
    const chatSearchInput = document.getElementById('chatSearchInput');
    const transferButton = document.getElementById('transferButton');
    const closeButton = document.getElementById('closeButton');
    const messageSearchToggle = document.getElementById('messageSearchToggle');
    const messageSearchBar = document.getElementById('messageSearchBar');
    const messageSearchInput = document.getElementById('messageSearchInput');
    const messageSearchEmpty = document.getElementById('messageSearchEmpty');
    const headerMenuToggle = document.getElementById('headerMenuToggle');
    const headerMenu = document.getElementById('headerMenu');

    document.addEventListener('DOMContentLoaded', function () {
        bindStaticEvents();
        startSidebarPolling();
        disableChatInputs();
        renderSidebarItemBindings();
    });

    function bindStaticEvents() {
        if (chatInput) {
            chatInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
        }

        if (adminAttachmentInput) {
            adminAttachmentInput.addEventListener('change', function () {
                updateAttachmentPreview();
            });
        }

        if (chatSearchInput) {
            chatSearchInput.addEventListener('input', function () {
                filterConversationList(this.value);
            });
        }

        if (messageSearchToggle) {
            messageSearchToggle.addEventListener('click', function () {
                toggleMessageSearch();
            });
        }

        if (messageSearchInput) {
            messageSearchInput.addEventListener('input', function () {
                filterMessagesInCurrentChat(this.value);
            });
        }

        if (headerMenuToggle) {
            headerMenuToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleHeaderMenu();
            });
        }

        document.addEventListener('click', function (e) {
            if (headerMenu && !headerMenu.contains(e.target) && e.target !== headerMenuToggle) {
                headerMenu.classList.remove('open');
            }
        });

        const transferForm = document.getElementById('transferChatForm');
        if (transferForm) {
            transferForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(transferForm);

                fetch("{{ route('admin.support.transfer') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.status) {
                        alert(data.message || 'Transfer failed.');
                        return;
                    }

                    closeTransferModal();

                    if (currentConversationId && String(currentConversationId) === String(data.conversation_id || '')) {
                        currentConversationStatus = data.assigned_agent_id ? 'active' : 'waiting';
                        currentAssignedAgentId = data.assigned_agent_id || null;
                        updateHeaderSubtitle();
                        if (currentConversationStatus === 'closed') {
                            disableChatInputs();
                        } else {
                            enableChatInputs();
                        }
                        loadConversationMessages(currentConversationId);
                    }

                    pollSidebar();
                })
                .catch(error => {
                    console.error(error);
                    alert('Transfer failed.');
                });
            });
        }

        const closeForm = document.getElementById('closeChatForm');
        if (closeForm) {
            closeForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(closeForm);

                fetch("{{ route('admin.support.close-conversation') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.status) {
                        alert(data.message || 'Failed to close conversation.');
                        return;
                    }

                    closeCloseModal();
                    if (data.data) {
                        appendMessageIfNotExists(data.data);
                        lastMessageId = Math.max(Number(lastMessageId), Number(data.data.id || 0));
                    }

                    currentConversationStatus = 'closed';
                    updateHeaderSubtitle();
                    updateActionButtons();
                    disableChatInputs();
                    pollSidebar();
                })
                .catch(error => {
                    console.error(error);
                    alert('Failed to close conversation.');
                });
            });
        }

        const deleteForm = document.getElementById('deleteChatForm');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function (e) {
                e.preventDefault();

                fetch("{{ route('admin.support.delete-conversation') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        conversation_id: currentConversationId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.status) {
                        alert(data.message || 'Failed to delete conversation.');
                        return;
                    }

                    closeDeleteModal();
                    resetCurrentChatView();
                    pollSidebar();
                })
                .catch(error => {
                    console.error(error);
                    alert('Failed to delete conversation.');
                });
            });
        }
    }

    function renderSidebarItemBindings() {
        if (!chatList) {
            return;
        }

        chatList.querySelectorAll('.cs-chat-item[data-conversation-id]').forEach(function (item) {
            item.addEventListener('click', function () {
                openConversation(
                    item,
                    item.getAttribute('data-conversation-id'),
                    item.getAttribute('data-customer-name') || 'Customer',
                    item.getAttribute('data-customer-avatar') || "{{ asset('assets/img/organization/default.png') }}"
                );
            });
        });
    }

    function resetCurrentChatView() {
        currentConversationId = null;
        currentConversationStatus = null;
        currentAssignedAgentId = null;
        currentAssignedAgentName = null;
        currentDepartmentName = null;
        lastMessageId = 0;
        stopMessagePolling();
        clearAttachment();
        clearMessageSearch();

        document.querySelectorAll('.cs-chat-item').forEach(function (item) {
            item.classList.remove('active');
        });

        if (chatBody) {
            chatBody.innerHTML = `
                <div class="h-100 d-flex align-items-center justify-content-center text-muted">
                    Select a conversation from the left panel.
                </div>
            `;
        }

        if (headerName) {
            headerName.innerText = 'Select a chat';
        }

        if (headerSubtitle) {
            headerSubtitle.innerText = 'No conversation selected';
        }

        if (headerAvatar) {
            headerAvatar.src = "{{ asset('assets/img/organization/default.png') }}";
        }

        disableChatInputs();
        updateActionButtons();
    }

    function openConversation(element, conversationId, name, avatar) {
        document.querySelectorAll('.cs-chat-item').forEach(function (item) {
            item.classList.remove('active');
        });

        if (element) {
            element.classList.add('active');
        }

        currentConversationId = conversationId;
        lastMessageId = 0;
        suppressMessageSound = true;
        isInitialConversationLoad = true;

        if (headerName) {
            headerName.innerText = name || 'Customer';
        }

        if (headerAvatar) {
            headerAvatar.src = avatar || "{{ asset('assets/img/organization/default.png') }}";
        }

        if (transferConversationIdInput) {
            transferConversationIdInput.value = conversationId;
        }

        if (closeConversationIdInput) {
            closeConversationIdInput.value = conversationId;
        }

        if (deleteConversationIdInput) {
            deleteConversationIdInput.value = conversationId;
        }

        clearAttachment();
        loadConversationMessages(conversationId);
        markConversationAsRead(conversationId);

        if (window.innerWidth <= 768) {
            const app = document.querySelector('.cs-chat-application');
            if (app) {
                app.classList.add('chat-open');
            }
        }
    }

    function backToSidebar() {
        const app = document.querySelector('.cs-chat-application');
        if (app) {
            app.classList.remove('chat-open');
        }
    }

    function triggerAttachment() {
        if (!currentConversationId || !adminAttachmentInput || (sendButton && sendButton.disabled)) {
            return;
        }

        adminAttachmentInput.click();
    }

    function updateAttachmentPreview() {
        if (!adminAttachmentInput || !adminAttachmentPreview) {
            return;
        }

        if (adminAttachmentInput.files && adminAttachmentInput.files.length > 0) {
            adminAttachmentPreview.style.display = 'block';
            adminAttachmentPreview.innerHTML =
                'Selected file: <strong>' + escapeHtml(adminAttachmentInput.files[0].name) + '</strong>' +
                ' <button type="button" class="btn btn-sm btn-link text-danger p-0 ml-2" onclick="clearAttachment()">Remove</button>';
        } else {
            adminAttachmentPreview.style.display = 'none';
            adminAttachmentPreview.innerHTML = '';
        }
    }

    function clearAttachment() {
        if (adminAttachmentInput) {
            adminAttachmentInput.value = '';
        }

        if (adminAttachmentPreview) {
            adminAttachmentPreview.style.display = 'none';
            adminAttachmentPreview.innerHTML = '';
        }
    }

    function sendMessage() {
        if (isSendingMessage || !currentConversationId) {
            return;
        }

        const message = chatInput ? chatInput.value.trim() : '';
        const file = (adminAttachmentInput && adminAttachmentInput.files.length > 0)
            ? adminAttachmentInput.files[0]
            : null;

        if (!message && !file) {
            return;
        }

        isSendingMessage = true;
        if (sendButton) sendButton.disabled = true;
        if (chatInput) chatInput.disabled = true;
        if (attachButton) attachButton.disabled = true;

        const formData = new FormData();
        formData.append('conversation_id', currentConversationId);
        formData.append('message', message);
        if (file) {
            formData.append('attachment', file);
        }

        fetch("{{ route('admin.support.send-message') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            isSendingMessage = false;

            if (!data.status) {
                enableChatInputs();
                alert(data.message || 'Failed to send message.');
                return;
            }

            if (chatInput) {
                chatInput.value = '';
            }

            clearAttachment();

            // When first message assigns agent, load whole conversation to also get system message
            loadConversationMessages(currentConversationId);
            pollSidebar();
        })
        .catch(error => {
            isSendingMessage = false;
            enableChatInputs();
            console.error(error);
            alert('Failed to send message.');
        });
    }

    function loadConversationMessages(conversationId) {
        if (!conversationId) {
            return;
        }

        fetch("{{ url('/admin/support/messages') }}/" + conversationId, {
            method: "GET",
            headers: {
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.status) {
                return;
            }

            if (chatBody) {
                chatBody.innerHTML = '';
            }

            lastMessageId = 0;
            clearMessageSearch();

            if (data.conversation) {
                if (headerName) {
                    headerName.innerText = data.conversation.customer_name || 'Customer';
                }

                currentDepartmentName = data.conversation.department_name || 'Support';
                currentConversationStatus = String(data.conversation.status || '').toLowerCase();
                currentAssignedAgentId = data.conversation.assigned_agent_id || null;
                currentAssignedAgentName = data.conversation.assigned_agent_name || null;

                updateHeaderSubtitle();
            }

            if (Array.isArray(data.messages)) {
                data.messages.forEach(function (item) {
                    appendMessageIfNotExists(item);
                    lastMessageId = Math.max(Number(lastMessageId), Number(item.id || 0));
                });
            }

            if (currentConversationStatus === 'closed') {
                disableChatInputs();
            } else {
                enableChatInputs();
            }

            updateActionButtons();
            scrollChatToBottom();
            startMessagePolling();

            setTimeout(function () {
                suppressMessageSound = false;
                isInitialConversationLoad = false;
            }, 300);
        })
        .catch(error => {
            console.error(error);
        });
    }

    function startMessagePolling() {
        stopMessagePolling();

        if (!currentConversationId) {
            return;
        }

        pollMessages();

        pollingInterval = setInterval(function () {
            pollMessages();
        }, 3000);
    }

    function stopMessagePolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
            pollingInterval = null;
        }
    }

    function pollMessages() {
        if (!currentConversationId || isPollingMessages) {
            return;
        }

        isPollingMessages = true;

        fetch("{{ route('admin.support.poll-messages') }}?conversation_id=" + encodeURIComponent(currentConversationId) + "&last_message_id=" + encodeURIComponent(lastMessageId), {
            method: "GET",
            headers: {
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            isPollingMessages = false;

            if (!data.status) {
                return;
            }

            if (data.conversation) {
                currentDepartmentName = data.conversation.department_name || currentDepartmentName || 'Support';
                currentConversationStatus = String(data.conversation.status || '').toLowerCase();
                currentAssignedAgentId = data.conversation.assigned_agent_id || null;
                currentAssignedAgentName = data.conversation.assigned_agent_name || null;

                updateHeaderSubtitle();
                updateActionButtons();

                if (currentConversationStatus === 'closed') {
                    disableChatInputs();
                } else {
                    enableChatInputs();
                }
            }

            if (Array.isArray(data.messages) && data.messages.length > 0) {
                data.messages.forEach(function (item) {
                    const existed = document.querySelector('[data-message-id="' + item.id + '"]');

                    appendMessageIfNotExists(item);
                    lastMessageId = Math.max(Number(lastMessageId), Number(item.id || 0));

                    if (!existed && item.sender_type === 'customer' && !suppressMessageSound && !isInitialConversationLoad) {
                        playNewMessageSound();
                    }

                    updateSidebarPreview(
                        item.support_conversation_id || currentConversationId,
                        getSidebarPreviewText(item),
                        item.created_at || '',
                        item.unread_count
                    );
                });

                filterMessagesInCurrentChat(messageSearchInput ? messageSearchInput.value : '');
            }
        })
        .catch(error => {
            isPollingMessages = false;
            console.error('Message polling error:', error);
        });
    }

    function startSidebarPolling() {
        if (sidebarPollingInterval) {
            clearInterval(sidebarPollingInterval);
            sidebarPollingInterval = null;
        }

        pollSidebar();

        sidebarPollingInterval = setInterval(function () {
            pollSidebar();
        }, 5000);
    }

    function stopSidebarPolling() {
        if (sidebarPollingInterval) {
            clearInterval(sidebarPollingInterval);
            sidebarPollingInterval = null;
        }
    }

    function pollSidebar() {
        if (isPollingSidebar) {
            return;
        }

        isPollingSidebar = true;

        fetch("{{ route('admin.support.sidebar-list') }}", {
            method: "GET",
            headers: {
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            isPollingSidebar = false;

            if (!data.status || !Array.isArray(data.conversations)) {
                return;
            }

            renderSidebarConversations(data.conversations);
        })
        .catch(error => {
            isPollingSidebar = false;
            console.error('Sidebar polling error:', error);
        });
    }

    function renderSidebarConversations(conversations) {
        if (!chatList) {
            return;
        }

        let html = '';

        if (!conversations || !conversations.length) {
            chatList.innerHTML = '<li class="px-3 py-4 text-muted text-center">No support conversations found.</li>';
            return;
        }

        conversations.forEach(function (convo) {
            const activeClass = String(currentConversationId) === String(convo.id) ? 'active' : '';
            const customerName = convo.customer_name || 'Customer';
            const avatar = convo.avatar || "{{ asset('assets/img/organization/default.png') }}";
            const unreadCount = Number(convo.unread_count || 0);

            let statusLine = (convo.department_name || 'Support') + ' • ' + (convo.status || 'Waiting');
            if (convo.assigned_agent_name) {
                statusLine += ' • ' + convo.assigned_agent_name;
            } else if (String(convo.status || '').toLowerCase() === 'waiting') {
                statusLine += ' • Unassigned';
            }

            html += `
                <li class="cs-chat-item d-flex align-items-center px-3 py-3 border-bottom cursor-pointer ${activeClass}"
                    data-conversation-id="${convo.id}"
                    data-customer-name="${escapeHtml(customerName)}"
                    data-customer-avatar="${escapeHtml(avatar)}">

                    <img src="${escapeHtml(avatar)}" class="rounded-circle mr-3" width="45" height="45" alt="User">

                    <div class="cs-chat-info flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center overflow-hidden">
                                <h6 class="mb-0 text-truncate">${escapeHtml(customerName)}</h6>
                                <span class="badge badge-danger rounded-pill ml-2 conversation-unread-count"
                                      style="${unreadCount > 0 ? '' : 'display:none;'}">
                                    ${unreadCount}
                                </span>
                            </div>
                            <small class="text-muted conversation-time">${escapeHtml(convo.last_message_at || '')}</small>
                        </div>

                        <p class="mb-0 text-muted text-truncate small conversation-last-message">
                            ${escapeHtml(convo.last_message || 'No messages yet')}
                        </p>

                        <small class="text-muted conversation-status-line">
                            ${escapeHtml(statusLine)}
                        </small>
                    </div>
                </li>
            `;
        });

        chatList.innerHTML = html;
        renderSidebarItemBindings();
        filterConversationList(chatSearchInput ? chatSearchInput.value : '');
    }

    function filterConversationList(keyword) {
        const term = String(keyword || '').toLowerCase().trim();
        const items = chatList ? chatList.querySelectorAll('.cs-chat-item[data-conversation-id]') : [];
        let visibleCount = 0;

        items.forEach(function (item) {
            const customerName = String(item.getAttribute('data-customer-name') || '').toLowerCase();
            const statusLine = String((item.querySelector('.conversation-status-line') || {}).textContent || '').toLowerCase();
            const lastMessage = String((item.querySelector('.conversation-last-message') || {}).textContent || '').toLowerCase();

            const matched =
                !term ||
                customerName.indexOf(term) !== -1 ||
                statusLine.indexOf(term) !== -1 ||
                lastMessage.indexOf(term) !== -1;

            item.style.display = matched ? '' : 'none';

            if (matched) {
                visibleCount++;
            }
        });

        toggleSearchEmptyState(visibleCount, term);
    }

    function toggleSearchEmptyState(visibleCount, term) {
        let emptyNode = document.getElementById('chatSearchEmptyState');

        if (!emptyNode) {
            emptyNode = document.createElement('li');
            emptyNode.id = 'chatSearchEmptyState';
            emptyNode.className = 'px-3 py-4 text-muted text-center';
            chatList.appendChild(emptyNode);
        }

        if (term && visibleCount === 0) {
            emptyNode.textContent = 'No matching conversations found.';
            emptyNode.style.display = '';
        } else {
            emptyNode.style.display = 'none';
        }
    }

    function toggleMessageSearch() {
        if (!messageSearchBar) {
            return;
        }

        messageSearchBar.classList.toggle('open');

        if (messageSearchBar.classList.contains('open') && messageSearchInput) {
            messageSearchInput.focus();
        } else {
            clearMessageSearch();
        }
    }

    function clearMessageSearch() {
        if (messageSearchInput) {
            messageSearchInput.value = '';
        }

        filterMessagesInCurrentChat('');
    }

    function filterMessagesInCurrentChat(keyword) {
        const term = String(keyword || '').toLowerCase().trim();
        const messages = chatBody ? chatBody.querySelectorAll('.message[data-message-id]') : [];
        let visibleCount = 0;

        messages.forEach(function (node) {
            const text = String(node.textContent || '').toLowerCase();
            const matched = !term || text.indexOf(term) !== -1;

            node.classList.toggle('message-hidden-by-search', !matched);

            if (matched) {
                visibleCount++;
            }
        });

        if (messageSearchEmpty) {
            messageSearchEmpty.classList.toggle('show', !!term && visibleCount === 0);
        }
    }

    function toggleHeaderMenu() {
        if (!headerMenu) {
            return;
        }

        headerMenu.classList.toggle('open');
    }

    function openDeleteModal() {
        if (!currentConversationId) {
            return;
        }

        if (deleteConversationIdInput) {
            deleteConversationIdInput.value = currentConversationId;
        }

        if (headerMenu) {
            headerMenu.classList.remove('open');
        }

        $('#deleteChatModal').modal('show');
    }

    function closeDeleteModal() {
        $('#deleteChatModal').modal('hide');
    }

    function openTransferModal() {
        if (!currentConversationId) {
            alert('Please select a conversation first.');
            return;
        }

        if (transferConversationIdInput) {
            transferConversationIdInput.value = currentConversationId;
        }

        $('#transferChatModal').modal('show');
    }

    function closeTransferModal() {
        $('#transferChatModal').modal('hide');
    }

    function openCloseModal() {
        if (!currentConversationId) {
            alert('Please select a conversation first.');
            return;
        }

        if (currentConversationStatus === 'closed') {
            alert('Conversation is already closed.');
            return;
        }

        if (closeConversationIdInput) {
            closeConversationIdInput.value = currentConversationId;
        }

        $('#closeChatModal').modal('show');
    }

    function closeCloseModal() {
        $('#closeChatModal').modal('hide');
    }

    function appendMessageIfNotExists(item) {
        if (!item || !item.id) {
            return;
        }

        if (document.querySelector('[data-message-id="' + item.id + '"]')) {
            return;
        }

        if (item.sender_type === 'customer') {
            appendCustomerMessage(
                item.message || '',
                item.created_at || '',
                item.id || '',
                item.attachment_url || '',
                item.attachment_name || '',
                item.attachment_type || ''
            );
        } else if (item.sender_type === 'system') {
            appendSystemMessage(
                item.message || '',
                item.created_at || '',
                item.id || ''
            );
        } else {
            appendAgentMessage(
                item.message || '',
                item.created_at || '',
                item.id || '',
                item.attachment_url || '',
                item.attachment_name || '',
                item.attachment_type || ''
            );
        }
    }

    function renderAttachmentHtml(attachmentUrl, attachmentName, attachmentType, isAgent) {
        if (!attachmentUrl) {
            return '';
        }

        if (attachmentType === 'image') {
            return `
                <div class="mb-1">
                    <a href="${attachmentUrl}" target="_blank">
                        <img src="${attachmentUrl}"
                             alt="${escapeHtml(attachmentName || 'Image')}"
                             style="max-width:220px; max-height:220px; border-radius:8px; display:block;">
                    </a>
                    <small style="display:block; margin-top:4px; ${isAgent ? 'color:rgba(255,255,255,.8);' : ''}">
                        ${escapeHtml(attachmentName || 'Image')}
                    </small>
                </div>
            `;
        }

        if (isAgent) {
            return `
                <div class="mb-1">
                    <a href="${attachmentUrl}" target="_blank" download style="color:#fff;text-decoration:underline;">
                        📄 ${escapeHtml(attachmentName || 'Document')}
                    </a>
                </div>
            `;
        }

        return `
            <div class="mb-1">
                <a href="${attachmentUrl}" target="_blank" download>
                    📄 ${escapeHtml(attachmentName || 'Document')}
                </a>
            </div>
        `;
    }

    function appendCustomerMessage(message, time, id, attachmentUrl, attachmentName, attachmentType) {
        if (!chatBody) {
            return;
        }

        let html = '';

        if (message) {
            html += '<p class="mb-1 ">' + makeLinksClickable(message) + '</p>';
        }

        html += renderAttachmentHtml(attachmentUrl, attachmentName, attachmentType, false);
        html += '<small class="text-muted float-right" style="font-size:10px;">' + escapeHtml(time || '') + '</small>';

        chatBody.insertAdjacentHTML('beforeend', `
            <div class="message received d-flex mb-3" data-message-id="${id}">
                <div class="message-content bg-white p-2 rounded shadow-sm" style="max-width: 75%; border-top-left-radius: 0;">
                    ${html}
                </div>
            </div>
        `);

        scrollChatToBottom();
    }

    function appendAgentMessage(message, time, id, attachmentUrl, attachmentName, attachmentType) {
        if (!chatBody) {
            return;
        }

        let html = '';

        if (message) {
            html += '<p class="mb-1 as-msg">' + makeLinksClickable(message) + '</p>';
        }

        html += renderAttachmentHtml(attachmentUrl, attachmentName, attachmentType, true);
        html += '<small class="text-white-50 float-right" style="font-size:10px;">' + escapeHtml(time || '') + '</small>';

        chatBody.insertAdjacentHTML('beforeend', `
            <div class="message sent d-flex justify-content-end mb-3" data-message-id="${id}">
                <div class="message-content p-2 rounded shadow-sm bg-primary text-white" style="max-width: 75%; border-top-right-radius: 0;">
                    ${html}
                </div>
            </div>
        `);

        scrollChatToBottom();
    }

    function appendSystemMessage(message, time, id) {
        if (!chatBody) {
            return;
        }

        let html = '';

        if (message) {
            html += '<span>' + makeLinksClickable(message) + '</span>';
        }

        if (time) {
            html += '<div><small style="opacity:.8;">' + escapeHtml(time) + '</small></div>';
        }

        chatBody.insertAdjacentHTML('beforeend', `
            <div class="message message-system" data-message-id="${id}">
                <div class="message-content">
                    ${html}
                </div>
            </div>
        `);

        scrollChatToBottom();
    }

    function getSidebarPreviewText(item) {
        if (item.message) {
            return item.message;
        }

        if (item.attachment_name) {
            return '📎 ' + item.attachment_name;
        }

        return 'No messages yet';
    }

    function updateSidebarPreview(conversationId, message, time, unreadCount) {
        const item = document.querySelector('.cs-chat-item[data-conversation-id="' + conversationId + '"]');
        if (!item) {
            return;
        }

        const messageNode = item.querySelector('.conversation-last-message');
        const timeNode = item.querySelector('.conversation-time');

        if (messageNode) {
            messageNode.textContent = message || 'No messages yet';
        }

        if (timeNode) {
            timeNode.textContent = time || '';
        }

        if (typeof unreadCount !== 'undefined') {
            updateUnreadBadge(conversationId, unreadCount);
        }
    }

    function updateUnreadBadge(conversationId, count) {
        const item = document.querySelector('.cs-chat-item[data-conversation-id="' + conversationId + '"]');
        if (!item) {
            return;
        }

        const badge = item.querySelector('.conversation-unread-count');
        if (!badge) {
            return;
        }

        if (Number(count) > 0) {
            badge.style.display = '';
            badge.textContent = count;
        } else {
            badge.style.display = 'none';
            badge.textContent = '0';
        }
    }

    function markConversationAsRead(conversationId) {
        fetch("{{ route('admin.support.mark-read') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                conversation_id: conversationId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                updateUnreadBadge(conversationId, 0);
            }
        })
        .catch(error => {
            console.error('Mark read failed:', error);
        });
    }

    function setLastMessageIdFromDOM() {
        lastMessageId = 0;

        document.querySelectorAll('[data-message-id]').forEach(function (node) {
            const id = parseInt(node.getAttribute('data-message-id'), 10);
            if (!isNaN(id) && id > lastMessageId) {
                lastMessageId = id;
            }
        });
    }

    function enableChatInputs() {
        if (chatInput) chatInput.disabled = false;
        if (sendButton) sendButton.disabled = false;
        if (attachButton) attachButton.disabled = false;
        updateActionButtons();
    }

    function disableChatInputs() {
        if (chatInput) chatInput.disabled = true;
        if (sendButton) sendButton.disabled = true;
        if (attachButton) attachButton.disabled = true;
        updateActionButtons();
    }

    function updateActionButtons() {
        const hasConversation = !!currentConversationId;
        const isClosed = currentConversationStatus === 'closed';

        if (transferButton) {
            transferButton.disabled = !hasConversation;
        }

        if (closeButton) {
            closeButton.disabled = !hasConversation || isClosed;
        }
    }

    function updateHeaderSubtitle() {
        if (!headerSubtitle) {
            return;
        }

        if (!currentConversationId) {
            headerSubtitle.innerText = 'No conversation selected';
            return;
        }

        let text = (currentDepartmentName || 'Support') + ' • ' + ucfirst(currentConversationStatus || 'waiting');

        if (currentAssignedAgentName) {
            text += ' • ' + currentAssignedAgentName;
        } else if (currentConversationStatus === 'waiting') {
            text += ' • Unassigned';
        }

        headerSubtitle.innerText = text;
    }

    function ucfirst(value) {
        const text = String(value || '');
        if (!text.length) {
            return '';
        }
        return text.charAt(0).toUpperCase() + text.slice(1);
    }

    function scrollChatToBottom() {
        if (!chatBody) {
            return;
        }

        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function playNewMessageSound() {
        const audio = document.getElementById('newMessageSound');
        if (!audio) return;

        audio.currentTime = 0;
        audio.play().catch(function () {});
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return String(text).replace(/[&<>"']/g, function (m) {
            return map[m];
        });
    }
    function makeLinksClickable(text) {
        if (!text) return '';

        return text.replace(
            /((https?:\/\/|www\.)[^\s]+)/gi,
            function(url) {
                let href = url;

                if (!/^https?:\/\//i.test(href)) {
                    href = 'https://' + href;
                }

                return `<a href="${href}" target="_blank">${url}</a>`;
            }
        );
    }


    document.addEventListener('DOMContentLoaded', function () {
        const departmentSelect = document.getElementById('transfer_department_id');
        const agentSelect = document.getElementById('transfer_agent_id');

        if (!departmentSelect || !agentSelect) {
            return;
        }

        function loadAgentsByDepartment() {
            const selectedDepartmentId = departmentSelect.value;

            agentSelect.innerHTML = `
                <option value="">Auto assign from selected department</option>
            `;

            if (!selectedDepartmentId) {
                return;
            }

            const filteredAgents = (window.transferAgents || []).filter(agent => {
                return agent.department_ids.includes(selectedDepartmentId);
            });

            filteredAgents.forEach(agent => {
                const option = document.createElement('option');
                option.value = agent.id;
                option.textContent = agent.name;
                agentSelect.appendChild(option);
            });

            if (filteredAgents.length === 0) {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No agents found for selected department';
                option.disabled = true;
                agentSelect.appendChild(option);
            }
        }

        departmentSelect.addEventListener('change', loadAgentsByDepartment);

        if (window.jQuery && $('#transferChatModal').length) {
            $('#transferChatModal').on('shown.bs.modal', function () {
                loadAgentsByDepartment();
            });
        }
    });

</script>
@endsection
