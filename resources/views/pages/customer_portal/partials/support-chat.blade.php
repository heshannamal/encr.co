<style>
    @media (max-width: 767.98px) {

    /* =====================================================
       MOBILE CHAT PANEL
       ===================================================== */

    #asChatPanel {
        position: fixed !important;

        /*
         * Screen එකේ left/right දෙපැත්තෙන් small gap එකක්
         */
        left: 10px !important;
        right: 10px !important;

        /*
         * Bottom gap
         */
        bottom: 10px !important;

        /*
         * Don't use a fixed width on mobile
         */
        width: auto !important;
        max-width: none !important;

        /*
         * Keep panel inside viewport
         */
        height: calc(100dvh - 20px) !important;
        max-height: calc(100dvh - 20px) !important;

        /*
         * Prevent panel from going outside screen
         */
        box-sizing: border-box !important;

        /*
         * Rounded mobile appearance
         */
        border-radius: 16px !important;

        /*
         * Keep chat above everything
         */
        z-index: 99998 !important;

        /*
         * Prevent horizontal overflow
         */
        overflow: hidden !important;
    }


    /* =====================================================
       CHAT HEADER
       ===================================================== */

    #asChatPanel .as-chat-top {
        min-height: 60px !important;

        padding: 12px 14px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;

        box-sizing: border-box !important;
    }


    #asChatPanel .as-chat-top h6 {
        margin: 0 !important;
        font-size: 16px !important;
        line-height: 20px !important;
    }


    #asChatPanel .as-chat-top small {
        display: block !important;

        max-width: calc(100vw - 100px);

        font-size: 11px !important;
        line-height: 15px !important;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    /* Close button */

    #asChatPanel #asChatClose {
        width: 34px !important;
        height: 34px !important;

        min-width: 34px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        font-size: 27px !important;
        line-height: 1 !important;

        cursor: pointer;
    }


    /* =====================================================
       MESSAGE AREA
       ===================================================== */

    #asChatPanel .as-chat-messages {
        height: calc(100% - 125px) !important;

        max-height: none !important;

        overflow-y: auto !important;
        overflow-x: hidden !important;

        padding: 12px !important;

        box-sizing: border-box !important;

        /*
         * Smooth scrolling on mobile
         */
        -webkit-overflow-scrolling: touch;
    }


    /* =====================================================
       MESSAGE BUBBLES
       ===================================================== */

    #asChatPanel .as-msg {
        max-width: 82% !important;

        word-break: break-word !important;
        overflow-wrap: anywhere !important;

        font-size: 14px !important;
        line-height: 20px !important;

        margin-bottom: 8px !important;
    }


    #asChatPanel .as-msg-user {
        margin-left: auto !important;
    }


    #asChatPanel .as-msg-support {
        margin-right: auto !important;
    }


    #asChatPanel .as-msg-system {
        max-width: 90% !important;

        margin-left: auto !important;
        margin-right: auto !important;
    }


    /* Message images */

    #asChatPanel .as-msg img {
        max-width: 180px !important;
        max-height: 180px !important;

        width: auto !important;
        height: auto !important;

        object-fit: contain;
    }


    /* =====================================================
       SUPPORT TYPE BUTTONS
       ===================================================== */

    #asChatPanel #supportTypeOptions {
        padding: 6px !important;
    }


    #asChatPanel .support-type-btn {
        width: 100% !important;

        min-height: 44px !important;

        margin-bottom: 8px !important;

        font-size: 14px !important;
    }


    /* =====================================================
       INPUT AREA
       ===================================================== */

    #asChatPanel .as-chat-input-area {
        min-height: 58px !important;

        padding: 8px !important;

        display: flex !important;
        align-items: center !important;

        gap: 6px !important;

        box-sizing: border-box !important;
    }


    /* Attachment button */

    #asChatPanel .as-attach-btn {
        width: 38px !important;
        min-width: 38px !important;
        height: 38px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        margin: 0 !important;

        font-size: 18px !important;

        cursor: pointer;
    }


    /* Message input */

    #asChatPanel #asChatInput {
        min-width: 0 !important;

        flex: 1 1 auto !important;

        width: auto !important;

        height: 40px !important;

        font-size: 16px !important;

        padding: 8px 10px !important;

        box-sizing: border-box !important;
    }


    /* Send button */

    #asChatPanel #asChatSend {
        width: 40px !important;
        min-width: 40px !important;

        height: 40px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        padding: 0 !important;

        font-size: 17px !important;
    }


    /* =====================================================
       SELECTED FILE
       ===================================================== */

    #asSelectedFilePreview {
        max-width: 100% !important;

        padding: 6px 10px !important;

        box-sizing: border-box !important;

        overflow: hidden !important;
        word-break: break-word !important;
    }
}


/* =========================================================
   VERY SMALL PHONES
   ========================================================= */

@media (max-width: 380px) {

    #asChatPanel {
        left: 6px !important;
        right: 6px !important;
        bottom: 6px !important;

        height: calc(100dvh - 12px) !important;
        max-height: calc(100dvh - 12px) !important;

        border-radius: 14px !important;
    }


    #asChatPanel .as-chat-messages {
        padding: 10px !important;
    }


    #asChatPanel .as-msg {
        max-width: 88% !important;
        font-size: 13px !important;
    }


    #asChatPanel .as-chat-input-area {
        gap: 4px !important;
        padding: 6px !important;
    }


    #asChatPanel .as-attach-btn {
        width: 34px !important;
        min-width: 34px !important;
    }


    #asChatPanel #asChatSend {
        width: 38px !important;
        min-width: 38px !important;
    }
}

</style>

<!-- Support Chat Button -->
<div class="as-chat-trigger" id="asChatTrigger">💬
    <span id="asUnreadBadge"
          style="
            display:none;
            position:absolute;
            top:-6px;
            right:-6px;
            min-width:20px;
            height:20px;
            line-height:20px;
            padding:0 6px;
            border-radius:999px;
            background:#dc3545;
            color:#fff;
            font-size:11px;
            font-weight:700;
            text-align:center;
          ">0</span>

</div>

<!-- Chat Panel -->
<div class="as-chat-panel" id="asChatPanel">
    <div class="as-chat-top">
        <div>
            <h6>Support</h6>
            <small id="asChatStatus">
                @if(isset($activeConversation) && $activeConversation && $activeConversation->department)
                    {{ $activeConversation->department->name }}
                    @if($activeConversation->status === 'waiting')
                        • Waiting for agent
                    @elseif($activeConversation->status === 'active')
                        • Connected
                    @endif
                @else
                    Online • replies fast
                @endif
            </small>
        </div>
        <span id="asChatClose">×</span>
    </div>

    <div class="as-chat-messages" id="asChatMessages">
        @if(isset($activeConversation) && $activeConversation)
            @foreach($activeConversation->messages as $message)

                @php
                    $attachmentUrl = $message->attachment_path
                        ? asset('storage/' . $message->attachment_path)
                        : null;
                @endphp

                @if($message->sender_type === 'customer')
                    <div class="as-msg as-msg-user" data-message-id="{{ $message->id }}">

                        @if(!empty($message->message))
                            <div>
                                {!! preg_replace_callback(
                                    '~(https?://[^\s<]+|www\.[^\s<]+)~i',
                                    function ($m) {
                                        $url = trim($m[0], '<>');
                                        return '<a href="'.$url.'" target="_blank" rel="noopener noreferrer">'.$url.'</a>';
                                    },
                                    e($message->message)
                                ) !!}
                            </div>
                        @endif

                        @if($attachmentUrl)
                            @if($message->attachment_type === 'image')
                                <div style="margin-top:6px;">
                                    <a href="{{ $attachmentUrl }}" target="_blank">
                                        <img src="{{ $attachmentUrl }}"
                                            alt="{{ $message->attachment_name }}"
                                            style="max-width:180px; max-height:180px; border-radius:8px; display:block;">
                                    </a>
                                    <small style="display:block;margin-top:4px;">
                                        {{ $message->attachment_name }}
                                    </small>
                                </div>
                            @else
                                <div style="margin-top:6px;">
                                    <a href="{{ $attachmentUrl }}" target="_blank" download>
                                        📄 {{ $message->attachment_name }}
                                    </a>
                                </div>
                            @endif
                        @endif

                        @if($message->created_at)
                            <small style="display:block;margin-top:4px;opacity:.8;">
                                {{ $message->created_at->format('Y-m-d h:i A') }}
                            </small>
                        @endif
                    </div>

                @elseif($message->sender_type === 'system')
                    <div class="as-msg as-msg-system" data-message-id="{{ $message->id }}">
                        @if(!empty($message->message))
                            <div>{{ $message->message }}</div>
                        @endif

                        @if($message->created_at)
                            <small style="display:block;margin-top:4px;opacity:.7;">
                                {{ $message->created_at->format('Y-m-d h:i A') }}
                            </small>
                        @endif
                    </div>

                @else
                    <div class="as-msg as-msg-support" data-message-id="{{ $message->id }}">

                        @if(!empty($message->message))
                            <div>{{ $message->message }}</div>
                        @endif

                        @if($attachmentUrl)
                            @if($message->attachment_type === 'image')
                                <div style="margin-top:6px;">
                                    <a href="{{ $attachmentUrl }}" target="_blank">
                                        <img src="{{ $attachmentUrl }}"
                                            alt="{{ $message->attachment_name }}"
                                            style="max-width:180px; max-height:180px; border-radius:8px; display:block;">
                                    </a>
                                    <small style="display:block;margin-top:4px;opacity:.7;">
                                        {{ $message->attachment_name }}
                                    </small>
                                </div>
                            @else
                                <div style="margin-top:6px;">
                                    <a href="{{ $attachmentUrl }}" target="_blank" download>
                                        📄 {{ $message->attachment_name }}
                                    </a>
                                </div>
                            @endif
                        @endif

                        @if($message->created_at)
                            <small style="display:block;margin-top:4px;opacity:.7;">
                                {{ $message->created_at->format('Y-m-d h:i A') }}
                            </small>
                        @endif
                    </div>
                @endif

            @endforeach
        @else
            <div class="as-msg as-msg-support">
                👋 Hi! Please choose the type of support you need.
            </div>

            <div id="supportTypeOptions" class="p-2">
                @foreach($departments ?? [] as $department)
                    <button type="button"
                            class="btn btn-dark w-100 mb-2 support-type-btn"
                            data-id="{{ $department->id }}"
                            data-name="{{ $department->name }}">
                        {{ $department->name }}
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    <div class="as-chat-input-area">
        <label class="as-attach-btn" title="Attach file">
            📎
            <input type="file"
                   id="asChatFile"
                   hidden
                   accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.zip,.txt"
                   {{ (isset($activeConversation) && $activeConversation && $activeConversation->status !== 'closed') ? '' : 'disabled' }} />
        </label>

        <input type="text"
               id="asChatInput"
               placeholder="Type a message…"
               {{ (isset($activeConversation) && $activeConversation && $activeConversation->status !== 'closed') ? '' : 'disabled' }} />

        <button id="asChatSend"
                type="button"
                {{ (isset($activeConversation) && $activeConversation && $activeConversation->status !== 'closed') ? '' : 'disabled' }}>
            ➤
        </button>
    </div>

    <div id="asSelectedFilePreview" style="padding:8px 12px;font-size:12px;color:#666;display:none;"></div>
</div>

<style>
    .as-msg-system {
        max-width: 85%;
        margin: 10px auto;
        text-align: center;
        background: #f4f4f4;
        color: #666;
        padding: 8px 12px;
        border-radius: 12px;
        font-size: 13px;
        line-height: 1.4;
    }
</style>

<style>
@media (max-width: 767.98px) {

    #asChatTrigger {
        position: fixed !important;
        z-index: 99999;

        /* Important for touch dragging */
        touch-action: none;

        user-select: none;
        -webkit-user-select: none;

        cursor: grab;
    }

    #asChatTrigger.as-dragging {
        cursor: grabbing;
        transition: none !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const chatTrigger = document.getElementById('asChatTrigger');

    if (!chatTrigger) {
        return;
    }

    let isHolding = false;
    let isDragging = false;

    let startX = 0;
    let startY = 0;

    let startLeft = 0;
    let startTop = 0;

    let holdTimer = null;

    /*
     * User must hold the button for this amount of time
     * before dragging starts.
     */
    const holdTime = 350;

    /*
     * Small movement allowed before dragging starts.
     */
    const moveThreshold = 8;


    function isMobile() {
        return window.matchMedia('(max-width: 767.98px)').matches;
    }


    /* =====================================================
       TOUCH / POINTER START
       ===================================================== */

    chatTrigger.addEventListener('pointerdown', function (e) {

        if (!isMobile()) {
            return;
        }

        if (e.pointerType === 'mouse' && e.button !== 0) {
            return;
        }

        const rect = chatTrigger.getBoundingClientRect();

        startX = e.clientX;
        startY = e.clientY;

        startLeft = rect.left;
        startTop = rect.top;

        isHolding = true;
        isDragging = false;


        /*
         * User must keep touching the button for 350ms.
         */
        holdTimer = setTimeout(function () {

            if (isHolding) {

                isDragging = true;

                chatTrigger.classList.add('as-dragging');

                /*
                 * Change from right/bottom positioning
                 * to exact left/top positioning.
                 */
                chatTrigger.style.left = startLeft + 'px';
                chatTrigger.style.top = startTop + 'px';

                chatTrigger.style.right = 'auto';
                chatTrigger.style.bottom = 'auto';

            }

        }, holdTime);


        try {
            chatTrigger.setPointerCapture(e.pointerId);
        } catch (error) {}

    });


    /* =====================================================
       DRAG
       ===================================================== */

    chatTrigger.addEventListener('pointermove', function (e) {

        if (!isMobile() || !isHolding) {
            return;
        }

        const deltaX = e.clientX - startX;
        const deltaY = e.clientY - startY;


        /*
         * If user moves before the hold time,
         * cancel the hold.
         */
        if (!isDragging) {

            const distance = Math.sqrt(
                (deltaX * deltaX) +
                (deltaY * deltaY)
            );

            if (distance > moveThreshold) {

                clearTimeout(holdTimer);

                isHolding = false;
            }

            return;
        }


        /*
         * Calculate new position.
         */
        let newLeft = startLeft + deltaX;
        let newTop = startTop + deltaY;


        const buttonWidth = chatTrigger.offsetWidth;
        const buttonHeight = chatTrigger.offsetHeight;

        const margin = 8;


        /*
         * Don't allow the button to go outside
         * the screen.
         */

        newLeft = Math.max(
            margin,
            Math.min(
                newLeft,
                window.innerWidth - buttonWidth - margin
            )
        );


        newTop = Math.max(
            margin,
            Math.min(
                newTop,
                window.innerHeight - buttonHeight - margin
            )
        );


        chatTrigger.style.left = newLeft + 'px';
        chatTrigger.style.top = newTop + 'px';


        /*
         * Stop the page from scrolling while dragging.
         */
        e.preventDefault();

    }, { passive: false });


    /* =====================================================
       TOUCH / POINTER END
       ===================================================== */

    chatTrigger.addEventListener('pointerup', function (e) {

        clearTimeout(holdTimer);

        isHolding = false;

        if (isDragging) {

            /*
             * Drag finished.
             */
            isDragging = false;

            chatTrigger.classList.remove('as-dragging');


            /*
             * Prevent the click generated after
             * touch/drag from opening the chat.
             */
            chatTrigger.dataset.justDragged = '1';

            setTimeout(function () {
                delete chatTrigger.dataset.justDragged;
            }, 100);

        }


        try {
            chatTrigger.releasePointerCapture(e.pointerId);
        } catch (error) {}

    });


    /* =====================================================
       CANCEL
       ===================================================== */

    chatTrigger.addEventListener('pointercancel', function () {

        clearTimeout(holdTimer);

        isHolding = false;
        isDragging = false;

        chatTrigger.classList.remove('as-dragging');

    });


    /* =====================================================
       PREVENT CLICK AFTER DRAG
       ===================================================== */

    chatTrigger.addEventListener('click', function (e) {

        if (chatTrigger.dataset.justDragged === '1') {

            e.preventDefault();
            e.stopImmediatePropagation();

            delete chatTrigger.dataset.justDragged;
        }

    }, true);


    /* =====================================================
       KEEP INSIDE SCREEN AFTER RESIZE
       ===================================================== */

    window.addEventListener('resize', function () {

        if (!isMobile()) {
            return;
        }

        const rect = chatTrigger.getBoundingClientRect();

        const buttonWidth = chatTrigger.offsetWidth;
        const buttonHeight = chatTrigger.offsetHeight;

        const margin = 8;

        let left = rect.left;
        let top = rect.top;


        left = Math.max(
            margin,
            Math.min(
                left,
                window.innerWidth - buttonWidth - margin
            )
        );


        top = Math.max(
            margin,
            Math.min(
                top,
                window.innerHeight - buttonHeight - margin
            )
        );


        chatTrigger.style.left = left + 'px';
        chatTrigger.style.top = top + 'px';

        chatTrigger.style.right = 'auto';
        chatTrigger.style.bottom = 'auto';

    });

});
</script>

<script>
    console.log('Customer support chat AJAX polling script loaded');

    const asTrigger = document.getElementById('asChatTrigger');
    const asPanel = document.getElementById('asChatPanel');
    const asClose = document.getElementById('asChatClose');
    const asSend = document.getElementById('asChatSend');
    const asInput = document.getElementById('asChatInput');
    const asFile = document.getElementById('asChatFile');
    const asMessages = document.getElementById('asChatMessages');
    const asChatStatus = document.getElementById('asChatStatus');
    const asSelectedFilePreview = document.getElementById('asSelectedFilePreview');
    const asUnreadBadge = document.getElementById('asUnreadBadge');
    let unreadMessageCount = 0;

    let currentConversationId = @json(optional($activeConversation)->id);
    let selectedDepartmentName = @json(optional(optional($activeConversation)->department)->name);
    let conversationStatus = @json(optional($activeConversation)->status);
    let assignedAgentId = @json(optional($activeConversation)->assigned_agent_id);

    let pollingInterval = null;
    let isPollingRequestRunning = false;
    let lastMessageId = 0;
    let isSending = false;

    if (asTrigger) {
        asTrigger.onclick = function () {
            asPanel.classList.add('as-open');
            clearUnreadBadge();
            scrollBottom();
        };
    }

    if (asClose) {
        asClose.onclick = function () {
            asPanel.classList.remove('as-open');
        };
    }

    if (asSend) {
        asSend.onclick = function () {
            sendAsMessage();
        };
    }

    if (asInput) {
        asInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendAsMessage();
            }
        });
    }

    if (asFile) {
        asFile.addEventListener('change', function () {
            updateSelectedFilePreview();
        });
    }

    bindDepartmentButtons();

    if (currentConversationId && conversationStatus === 'closed') {
        showDepartmentSelection();
    } else if (currentConversationId) {
        updateChatStatusLabel();
        enableChatInputs();
        setLastMessageIdFromDOM();
        startPolling();
        scrollBottom();
    }

    function isChatOpen() {
        return asPanel && asPanel.classList.contains('as-open');
    }

    function updateUnreadBadge() {
        if (!asUnreadBadge) {
            return;
        }

        if (unreadMessageCount > 0) {
            asUnreadBadge.style.display = 'inline-block';
            asUnreadBadge.textContent = unreadMessageCount > 99 ? '99+' : unreadMessageCount;
        } else {
            asUnreadBadge.style.display = 'none';
            asUnreadBadge.textContent = '0';
        }
    }

    function clearUnreadBadge() {
        unreadMessageCount = 0;
        updateUnreadBadge();
    }

    function bindDepartmentButtons() {
        document.querySelectorAll('.support-type-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const departmentId = this.dataset.id;
                const departmentName = this.dataset.name;
                selectSupportDepartment(departmentId, departmentName);
            });
        });
    }

    function showDepartmentSelection() {
        stopPolling();

        currentConversationId = null;
        conversationStatus = null;
        lastMessageId = 0;
        selectedDepartmentName = null;
        assignedAgentId = null;

        if (asFile) {
            asFile.value = '';
        }

        if (asMessages) {
            asMessages.innerHTML = `
                <div class="as-msg as-msg-support">
                    👋 Hi! Please choose the type of support you need.
                </div>

                <div id="supportTypeOptions" class="p-2">
                    @foreach($departments ?? [] as $department)
                        <button type="button"
                                class="btn btn-dark w-100 mb-2 support-type-btn"
                                data-id="{{ $department->id }}"
                                data-name="{{ $department->name }}">
                            {{ $department->name }}
                        </button>
                    @endforeach
                </div>
            `;
        }

        bindDepartmentButtons();

        if (asChatStatus) {
            asChatStatus.textContent = 'Select support type';
        }

        if (asInput) {
            asInput.value = '';
            asInput.disabled = true;
        }

        if (asSend) {
            asSend.disabled = true;
        }

        if (asFile) {
            asFile.disabled = true;
        }

        updateSelectedFilePreview();
    }

    function selectSupportDepartment(departmentId, departmentName) {
        document.querySelectorAll('.support-type-btn').forEach(function (btn) {
            btn.disabled = true;
        });

        fetch("{{ route('customer.support.select-department') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                support_department_id: departmentId
            })
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (!data.status) {
                alert(data.message || 'Something went wrong.');
                document.querySelectorAll('.support-type-btn').forEach(function (btn) {
                    btn.disabled = false;
                });
                return;
            }

            currentConversationId = data.conversation_id;
            selectedDepartmentName = departmentName;
            assignedAgentId = data.assigned_agent_id || null;
            conversationStatus = assignedAgentId ? 'active' : 'waiting';
            lastMessageId = 0;

            enableChatAfterDepartmentSelection();
            enableChatInputs();
            loadMessages();
            startPolling();
        })
        .catch(function (error) {
            console.error(error);
            alert('Something went wrong.');
            document.querySelectorAll('.support-type-btn').forEach(function (btn) {
                btn.disabled = false;
            });
        });
    }

    function enableChatAfterDepartmentSelection() {
        const options = document.getElementById('supportTypeOptions');
        if (options) {
            options.remove();
        }

        asMessages.innerHTML = '';
        updateChatStatusLabel();
        scrollBottom();
    }

function sendAsMessage() {
    if (isSending) {
        return;
    }

    const text = asInput ? asInput.value.trim() : '';
    const file = asFile && asFile.files.length ? asFile.files[0] : null;

    if (!currentConversationId) {
        alert('Conversation not found.');
        return;
    }

    if (!text && !file) {
        return;
    }

    isSending = true;

    const tempBubble = addTempUserSendingBubble(text, file);

    if (asSend) {
        asSend.disabled = true;
    }

    if (asInput) {
        asInput.disabled = true;
    }

    if (asFile) {
        asFile.disabled = true;
    }

    const formData = new FormData();
    formData.append('conversation_id', currentConversationId);
    formData.append('message', text);

    if (file) {
        formData.append('attachment', file);
    }

    fetch("{{ route('customer.support.send-message') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: formData
    })
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        isSending = false;

        removeTempSendingBubble(tempBubble);

        if (conversationStatus !== 'closed') {
            enableChatInputs();
        }

        if (data.status) {
            const item = data.data;

            appendMessageIfNotExists(item);

            if (asInput) {
                asInput.value = '';
            }

            if (asFile) {
                asFile.value = '';
            }

            updateSelectedFilePreview();

            if (item.id) {
                lastMessageId = Math.max(Number(lastMessageId), Number(item.id));
            }
        } else {
            alert(data.message || 'Failed to send message.');
        }
    })
    .catch(function (error) {
        isSending = false;

        removeTempSendingBubble(tempBubble);

        if (conversationStatus !== 'closed') {
            enableChatInputs();
        }

        console.error(error);
        alert('Failed to send message.');
    });
}

    function startPolling() {
        stopPolling();

        if (!currentConversationId) {
            return;
        }

        pollMessages();

        pollingInterval = setInterval(function () {
            pollMessages();
        }, 3000);
    }

    function stopPolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
            pollingInterval = null;
        }
    }

    function pollMessages() {
        if (!currentConversationId || isPollingRequestRunning) {
            return;
        }

        isPollingRequestRunning = true;

        fetch("{{ route('customer.support.poll') }}?conversation_id=" + encodeURIComponent(currentConversationId) + "&last_message_id=" + encodeURIComponent(lastMessageId), {
            method: "GET",
            headers: {
                "Accept": "application/json"
            }
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            isPollingRequestRunning = false;

            if (!data.status) {
                return;
            }

            if (typeof data.assigned_agent_id !== 'undefined') {
                assignedAgentId = data.assigned_agent_id;
            }

            if (data.conversation_status) {
                conversationStatus = data.conversation_status;

                if (conversationStatus === 'closed') {
                    showDepartmentSelection();
                    return;
                }

                updateChatStatusLabel();
            }

            if (Array.isArray(data.messages) && data.messages.length > 0) {
                data.messages.forEach(function (item) {
                    const alreadyExists = document.querySelector('[data-message-id="' + item.id + '"]');

                    appendMessageIfNotExists(item);

                    if (item.id) {
                        lastMessageId = Math.max(Number(lastMessageId), Number(item.id));
                    }

                    if (!alreadyExists && item.sender_type !== 'customer' && !isChatOpen()) {
                        unreadMessageCount++;
                    }
                });

                updateUnreadBadge();
            }
        })
        .catch(function (error) {
            isPollingRequestRunning = false;
            console.error('Polling error:', error);
        });
    }

    function loadMessages() {
        if (!currentConversationId) {
            return;
        }

        fetch("{{ url('/customer/support/messages') }}/" + currentConversationId, {
            method: "GET",
            headers: {
                "Accept": "application/json"
            }
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (!data.status) {
                return;
            }

            asMessages.innerHTML = '';
            lastMessageId = 0;

            if (typeof data.assigned_agent_id !== 'undefined') {
                assignedAgentId = data.assigned_agent_id;
            }

            if (data.conversation_status) {
                conversationStatus = data.conversation_status;
            }

            updateChatStatusLabel();

            data.messages.forEach(function (item) {
                renderMessage(item);

                if (item.id) {
                    lastMessageId = Math.max(Number(lastMessageId), Number(item.id));
                }
            });

            if (conversationStatus === 'closed') {
                showDepartmentSelection();
                return;
            } else {
                enableChatInputs();
            }

            scrollBottom();
        })
        .catch(function (error) {
            console.error(error);
        });
    }

    function appendMessageIfNotExists(item) {
        if (!item || !item.id) {
            return;
        }

        if (document.querySelector('[data-message-id="' + item.id + '"]')) {
            return;
        }

        renderMessage(item);
    }

    function renderMessage(item) {
        if (item.sender_type === 'customer') {
            addUserBubble(
                item.message || '',
                item.created_at || '',
                item.id || '',
                item.attachment_url || '',
                item.attachment_name || '',
                item.attachment_type || ''
            );
        } else if (item.sender_type === 'system') {
            addSystemBubble(
                item.message || '',
                item.created_at || '',
                item.id || ''
            );
        } else {
            addSupportBubble(
                item.message || '',
                item.created_at || '',
                item.id || '',
                item.attachment_url || '',
                item.attachment_name || '',
                item.attachment_type || ''
            );
        }
    }

    function addUserBubble(text, time, id, attachmentUrl, attachmentName, attachmentType) {
        const msg = document.createElement('div');
        msg.className = 'as-msg as-msg-user';

        if (id) {
            msg.setAttribute('data-message-id', id);
        }

        let html = '';

        if (text) {
            html += '<div>' + makeLinksClickable(text) + '</div>';
        }

        html += renderCustomerAttachmentHtml(attachmentUrl, attachmentName, attachmentType);

        if (time) {
            html += '<small style="display:block;margin-top:4px;opacity:.8;">' + escapeHtml(time) + '</small>';
        }

        msg.innerHTML = html;
        asMessages.appendChild(msg);
        scrollBottom();
    }

    function addSupportBubble(text, time, id, attachmentUrl, attachmentName, attachmentType) {
        const msg = document.createElement('div');
        msg.className = 'as-msg as-msg-support';

        if (id) {
            msg.setAttribute('data-message-id', id);
        }

        let html = '';

        if (text) {
            html += '<div>' + makeLinksClickable(text) + '</div>';
        }

        html += renderCustomerAttachmentHtml(attachmentUrl, attachmentName, attachmentType);

        if (time) {
            html += '<small style="display:block;margin-top:4px;opacity:.7;">' + escapeHtml(time) + '</small>';
        }

        msg.innerHTML = html;
        asMessages.appendChild(msg);
        scrollBottom();
    }

    function addSystemBubble(text, time, id) {
        const msg = document.createElement('div');
        msg.className = 'as-msg as-msg-system';

        if (id) {
            msg.setAttribute('data-message-id', id);
        }

        let html = '';

        if (text) {
            html += '<div>' + makeLinksClickable(text) + '</div>';
        }

        if (time) {
            html += '<small style="display:block;margin-top:4px;opacity:.7;">' + escapeHtml(time) + '</small>';
        }

        msg.innerHTML = html;
        asMessages.appendChild(msg);
        scrollBottom();
    }

    function setLastMessageIdFromDOM() {
        const nodes = document.querySelectorAll('[data-message-id]');
        lastMessageId = 0;

        nodes.forEach(function (node) {
            const id = parseInt(node.getAttribute('data-message-id'), 10);
            if (!isNaN(id) && id > lastMessageId) {
                lastMessageId = id;
            }
        });
    }

    function updateSelectedFilePreview() {
        if (!asSelectedFilePreview || !asFile) {
            return;
        }

        if (asFile.files && asFile.files.length > 0) {
            const file = asFile.files[0];

            asSelectedFilePreview.style.display = 'flex';
            asSelectedFilePreview.style.alignItems = 'center';
            asSelectedFilePreview.style.justifyContent = 'space-between';
            asSelectedFilePreview.style.gap = '8px';

            asSelectedFilePreview.innerHTML =
                '<span>Selected file: <strong>' + escapeHtml(file.name) + '</strong></span>' +
                '<button type="button" id="asRemoveSelectedFile" ' +
                    'style="border:0;background:#dc3545;color:#fff;border-radius:50%;width:22px;height:22px;line-height:18px;font-size:14px;cursor:pointer;">×</button>';

            const removeBtn = document.getElementById('asRemoveSelectedFile');

            if (removeBtn) {
                removeBtn.onclick = function () {
                    asFile.value = '';
                    updateSelectedFilePreview();
                };
            }
        } else {
            asSelectedFilePreview.style.display = 'none';
            asSelectedFilePreview.innerHTML = '';
        }
    }

    function enableChatInputs() {
        if (asInput) asInput.disabled = false;
        if (asSend) asSend.disabled = false;
        if (asFile) asFile.disabled = false;
    }

    function disableChatInputs() {
        if (asInput) asInput.disabled = true;
        if (asSend) asSend.disabled = true;
        if (asFile) asFile.disabled = true;
    }

    function updateChatStatusLabel() {
        if (!asChatStatus) {
            return;
        }

        if (!selectedDepartmentName) {
            asChatStatus.textContent = 'Select support type';
            return;
        }

        if (conversationStatus === 'waiting') {
            asChatStatus.textContent = selectedDepartmentName + ' • Waiting for agent';
        } else if (conversationStatus === 'active') {
            asChatStatus.textContent = selectedDepartmentName + ' • Connected';
        } else if (conversationStatus === 'closed') {
            asChatStatus.textContent = selectedDepartmentName + ' • Closed';
        } else {
            asChatStatus.textContent = selectedDepartmentName;
        }
    }

    function scrollBottom() {
        if (!asMessages) return;
        asMessages.scrollTop = asMessages.scrollHeight;
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

    function renderCustomerAttachmentHtml(attachmentUrl, attachmentName, attachmentType) {
        if (!attachmentUrl) {
            return '';
        }

        if (attachmentType === 'image') {
            return `
                <div style="margin-top:6px;">
                    <a href="${attachmentUrl}" target="_blank">
                        <img src="${attachmentUrl}"
                            alt="${escapeHtml(attachmentName || 'Image')}"
                            style="max-width:180px; max-height:180px; border-radius:8px; display:block;">
                    </a>
                    <small style="display:block;margin-top:4px;">${escapeHtml(attachmentName || 'Image')}</small>
                </div>
            `;
        }

        return `
            <div style="margin-top:6px;">
                <a href="${attachmentUrl}" target="_blank" download>
                    📄 ${escapeHtml(attachmentName || 'Document')}
                </a>
            </div>
        `;
    }
function addTempUserSendingBubble(text, file) {
    if (!asMessages) {
        return null;
    }

    const tempId = 'temp-' + Date.now();

    const msg = document.createElement('div');
    msg.className = 'as-msg as-msg-user as-temp-sending';
    msg.setAttribute('data-temp-message-id', tempId);

    let html = '';

    if (text) {
        html += '<div>' + makeLinksClickable(escapeHtml(text)) + '</div>';
    }

    if (file) {
        const fileName = escapeHtml(file.name);

        if (file.type && file.type.startsWith('image/')) {
            const imageUrl = URL.createObjectURL(file);

            html += `
                <div style="margin-top:6px;">
                    <img src="${imageUrl}"
                         alt="${fileName}"
                         style="max-width:180px; max-height:180px; border-radius:8px; display:block;">
                    <small style="display:block;margin-top:4px;">${fileName}</small>
                </div>
            `;
        } else {
            html += `
                <div style="margin-top:6px;">
                    📄 ${fileName}
                </div>
            `;
        }
    }

    html += `
        <div class="as-bubble-footer">
            <span class="as-send-spinner"></span>
        </div>
    `;

    msg.innerHTML = html;
    asMessages.appendChild(msg);
    scrollBottom();

    return msg;
}

function removeTempSendingBubble(tempBubble) {
    if (tempBubble && tempBubble.parentNode) {
        tempBubble.parentNode.removeChild(tempBubble);
    }
}
</script>
