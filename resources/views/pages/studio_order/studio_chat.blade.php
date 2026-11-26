<div id="scChat" class="sc-root" aria-hidden="true">
    <div class="sc-backdrop" data-sc="close"></div>

    <aside class="sc-panel" role="dialog" aria-modal="true" aria-labelledby="scTitle">

        {{-- Header --}}
        <header class="sc-head">
            <div class="sc-head-icon"><i class="fa-regular fa-comments"></i></div>
            <div class="sc-head-text">
                <div class="sc-kicker" id="scKicker">Chat</div>
                <h3 class="sc-title" id="scTitle">Loading…</h3>
                <div class="sc-sub" id="scSub"></div>
            </div>
            <div class="sc-head-tools">
                <a href="#" class="sc-head-btn sc-hidden" id="scPmLink" target="_blank" rel="noopener" title="Open in Project Management">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
                <button type="button" class="sc-head-btn" data-sc="refresh" title="Refresh chat"><i class="fa-solid fa-rotate-right"></i></button>
                <button type="button" class="sc-head-btn" data-sc="close" title="Close chat" aria-label="Close chat"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </header>

        {{-- Comments --}}
        <div class="sc-body" id="scBody">
            <div class="sc-state" id="scState"></div>
            <div class="sc-list" id="scList"></div>
        </div>

        {{-- Write a comment --}}
        <footer class="sc-compose" id="scCompose">
            <div class="sc-editing sc-hidden" id="scEditing">
                <i class="fa-solid fa-pen"></i>
                <span>Editing your comment</span>
                <button type="button" class="sc-link-btn" data-sc="cancel-edit">Cancel</button>
            </div>

            <div class="sc-mention sc-hidden" id="scMention" role="listbox" aria-label="Mention someone"></div>

            <div class="sc-box">
                <div class="sc-editor" id="scEditor" contenteditable="true" role="textbox" aria-multiline="true"
                     data-placeholder="Write a comment… type @ to mention someone"></div>

                <div class="sc-files" id="scFiles"></div>

                <div class="sc-toolbar">
                    <button type="button" class="sc-tool" data-cmd="bold" title="Bold"><i class="fa-solid fa-bold"></i></button>
                    <button type="button" class="sc-tool" data-cmd="italic" title="Italic"><i class="fa-solid fa-italic"></i></button>
                    <button type="button" class="sc-tool" data-cmd="underline" title="Underline"><i class="fa-solid fa-underline"></i></button>
                    <button type="button" class="sc-tool" data-cmd="insertUnorderedList" title="Bulleted list"><i class="fa-solid fa-list-ul"></i></button>
                    <button type="button" class="sc-tool" data-cmd="insertOrderedList" title="Numbered list"><i class="fa-solid fa-list-ol"></i></button>
                    <span class="sc-tool-sep"></span>
                    <button type="button" class="sc-tool" data-sc="mention" title="Mention someone"><i class="fa-solid fa-at"></i></button>
                    <button type="button" class="sc-tool" data-sc="attach" title="Attach files"><i class="fa-solid fa-paperclip"></i></button>
                    <input type="file" id="scFileInput" multiple class="sc-hidden">

                    <button type="button" class="sc-send" id="scSend">
                        <i class="fa-solid fa-paper-plane"></i><span>Post</span>
                    </button>
                </div>
            </div>
        </footer>

        {{-- Centred confirm popup (delete comment / delete one attachment) --}}
        <div class="sc-confirm sc-hidden" id="scConfirm" role="alertdialog" aria-modal="true" aria-labelledby="scConfirmTitle" aria-describedby="scConfirmText">
            <div class="sc-confirm-card">
                <div class="sc-confirm-icon"><i class="fa-regular fa-trash-can"></i></div>
                <h4 id="scConfirmTitle">Delete this comment?</h4>
                <p id="scConfirmText">The comment and its attachments will be removed for everyone, also in Project Management.</p>
                <div class="sc-confirm-actions">
                    <button type="button" class="sc-btn" data-sc="confirm-no">Cancel</button>
                    <button type="button" class="sc-btn sc-btn-danger" data-sc="confirm-yes" id="scConfirmOk">Delete</button>
                </div>
            </div>
        </div>

        <div class="sc-toast" id="scToast" role="status" aria-live="polite"></div>
    </aside>
</div>

<style>
    /* Everything is scoped to #scChat so it never changes the page around it */
    #scChat {
        --sc-blue: #1f5fbf;
        --sc-blue-soft: #eef4fd;
        --sc-text: #1f2328;
        --sc-muted: #6b7280;
        --sc-line: #e5e7eb;
        --sc-bg: #f7f8fa;
        --sc-danger: #d64550;
        --sc-pin: #b7791f;
        position: fixed;
        inset: 0;
        z-index: 1080;
        visibility: hidden;
        pointer-events: none;
        font-family: 'Open Sans', sans-serif;
    }
    #scChat.is-open { visibility: visible; pointer-events: auto; }
    #scChat .sc-hidden { display: none !important; }

    #scChat .sc-backdrop {
        position: absolute; inset: 0;
        background: rgba(17, 24, 39, .35);
        opacity: 0; transition: opacity .2s;
    }
    #scChat.is-open .sc-backdrop { opacity: 1; }

    #scChat .sc-panel {
        position: absolute; top: 0; right: 0; bottom: 0;
        width: min(820px, 95vw); max-width: 100%;
        display: flex; flex-direction: column;
        background: #fff;
        box-shadow: -12px 0 32px rgba(17, 24, 39, .18);
        transform: translateX(100%);
        transition: transform .25s ease;
        color: var(--sc-text);
    }
    #scChat.is-open .sc-panel { transform: translateX(0); }

    /* Header */
    #scChat .sc-head {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 16px 16px 14px;
        border-bottom: 1px solid var(--sc-line);
    }
    #scChat .sc-head-icon {
        flex: 0 0 38px; height: 38px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        background: var(--sc-blue-soft); color: var(--sc-blue); font-size: 17px;
    }
    #scChat .sc-head-text { flex: 1; min-width: 0; }
    #scChat .sc-kicker { font-size: 11px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: var(--sc-blue); }
    #scChat .sc-title {
        margin: 2px 0 2px; font-size: 16px; font-weight: 700; line-height: 1.3; color: var(--sc-text);
        overflow-wrap: anywhere;
    }
    #scChat .sc-sub { font-size: 12px; color: var(--sc-muted); }
    #scChat .sc-head-tools { display: flex; gap: 4px; }
    #scChat .sc-head-btn {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid transparent; background: transparent; color: var(--sc-muted);
        font-size: 14px; cursor: pointer; text-decoration: none;
    }
    #scChat .sc-head-btn:hover { background: #f3f4f6; color: var(--sc-text); }

    /* Body */
    #scChat .sc-body { flex: 1; overflow-y: auto; background: var(--sc-bg); padding: 14px 16px; }
    #scChat .sc-state { text-align: center; color: var(--sc-muted); font-size: 13px; padding: 40px 12px; }
    #scChat .sc-state:empty { display: none; }
    #scChat .sc-state i { display: block; font-size: 28px; margin-bottom: 10px; color: #c2c8d0; }
    #scChat .sc-state.is-error i { color: var(--sc-danger); }
    #scChat .sc-state .sc-btn { margin-top: 12px; }

    #scChat .sc-group-label {
        font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em;
        color: var(--sc-muted); margin: 6px 0 8px;
    }
    #scChat .sc-group-label i { margin-right: 4px; }

    #scChat .sc-msg {
        position: relative; display: flex; gap: 10px;
        padding: 10px 12px; margin-bottom: 8px;
        background: #fff; border: 1px solid var(--sc-line); border-radius: 12px;
    }
    #scChat .sc-msg.is-pinned { border-color: #f0d9a8; background: #fffbf0; }
    #scChat .sc-msg.is-editing { border-color: var(--sc-blue); box-shadow: 0 0 0 2px var(--sc-blue-soft); }

    #scChat .sc-avatar {
        flex: 0 0 32px; width: 32px; height: 32px; border-radius: 50%;
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        background: #dbe5f5; color: var(--sc-blue); font-size: 12px; font-weight: 700;
    }
    #scChat .sc-avatar img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }

    #scChat .sc-msg-main { flex: 1; min-width: 0; }
    #scChat .sc-meta { display: flex; flex-wrap: wrap; align-items: baseline; gap: 6px; font-size: 12px; color: var(--sc-muted); padding-right: 72px; }
    #scChat .sc-meta b { font-size: 13px; color: var(--sc-text); }
    #scChat .sc-pin-badge { color: var(--sc-pin); font-weight: 600; }

    #scChat .sc-text { margin-top: 4px; font-size: 13px; line-height: 1.55; overflow-wrap: anywhere; }
    #scChat .sc-text p, #scChat .sc-text div { margin: 0; }
    #scChat .sc-text ul, #scChat .sc-text ol { margin: 4px 0; padding-left: 20px; }
    #scChat .sc-text a { color: var(--sc-blue); text-decoration: underline; }
    #scChat .sc-text img { max-width: 100% !important; height: auto; border-radius: 8px; margin-top: 6px; cursor: zoom-in; }
    #scChat .sc-text .comment-attachment { margin-top: 6px; }

    /* Attachments inside a comment: each one has Download + Delete */
    #scChat .sc-att { margin-top: 8px; max-width: 100%; }
    #scChat .sc-att-img img {
        display: block; width: auto !important; max-width: 100% !important; max-height: 260px;
        margin: 0; border-radius: 8px; cursor: zoom-in;
    }
    #scChat .sc-att-file { padding: 7px 10px; border: 1px solid var(--sc-line); border-radius: 8px; background: var(--sc-bg); }
    #scChat .sc-att-bar { display: flex; flex-wrap: wrap; align-items: center; gap: 6px; margin-top: 6px; font-size: 12px; }
    #scChat .sc-att-file .sc-att-bar { margin-top: 0; }
    #scChat .sc-att-name {
        display: inline-flex; align-items: center; gap: 6px; min-width: 0; max-width: 100%;
        color: var(--sc-text); font-weight: 600;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    #scChat .sc-att-file .sc-att-name { flex: 1 1 auto; }
    #scChat .sc-att-name i { color: var(--sc-muted); }
    #scChat .sc-att-btn {
        display: inline-flex; align-items: center; gap: 5px; height: 24px; padding: 0 9px;
        border: 0; border-radius: 6px; background: var(--sc-blue-soft);
        color: var(--sc-blue) !important; font-size: 12px; font-weight: 600;
        text-decoration: none !important; cursor: pointer; white-space: nowrap;
    }
    #scChat .sc-att-btn:hover { background: #dde8fa; }
    #scChat .sc-att-btn.is-danger { background: #fdecee; color: var(--sc-danger) !important; }
    #scChat .sc-att-btn.is-danger:hover { background: #fadadd; }
    #scChat .sc-att-btn:disabled { opacity: .6; cursor: wait; }

    /* Reactions (same 9 reactions as Project Management, saved in comment_reactions) */
    #scChat .sc-reacts { display: flex; flex-wrap: wrap; align-items: center; gap: 6px; margin-top: 8px; }
    #scChat .sc-react {
        display: inline-flex; align-items: center; gap: 4px; height: 24px; padding: 0 9px;
        border: 1px solid transparent; border-radius: 999px; background: #f3f4f6;
        font-size: 12px; color: var(--sc-muted); cursor: pointer; line-height: 1;
    }
    #scChat .sc-react:hover { background: #e5e7eb; }
    #scChat .sc-react.is-mine { background: #e3f2fd; border-color: #90caf9; color: #1976d2; font-weight: 600; }
    #scChat .sc-react-emoji { font-size: 14px; }
    #scChat .sc-react-add {
        display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 24px;
        border: 1px solid var(--sc-line); border-radius: 999px; background: #fff;
        color: var(--sc-muted); font-size: 13px; cursor: pointer;
    }
    #scChat .sc-react-add:hover { background: #f3f4f6; color: var(--sc-text); }
    #scChat .sc-react-picker {
        position: absolute; z-index: 6; display: flex; gap: 2px; padding: 6px 8px;
        background: #fff; border: 1px solid var(--sc-line); border-radius: 999px;
        box-shadow: 0 8px 24px rgba(17, 24, 39, .16);
    }
    #scChat .sc-react-pick {
        width: 34px; height: 34px; border: 0; border-radius: 50%; background: transparent;
        font-size: 20px; line-height: 1; cursor: pointer; transition: transform .12s, background .12s;
    }
    #scChat .sc-react-pick:hover, #scChat .sc-react-pick:focus-visible { background: #f3f4f6; transform: scale(1.18); }
    #scChat .sc-react-pick.is-mine { background: #e3f2fd; }

    #scChat .mention-tag {
        display: inline; padding: 1px 7px; border-radius: 12px;
        background: #e3f2fd; color: #1565c0; font-weight: 600; white-space: nowrap;
    }
    #scChat .mention-group-tag { background: #ede7f6; color: #5e35b1; }

    #scChat .sc-tools {
        position: absolute; top: 6px; right: 6px; display: flex; gap: 2px;
        opacity: 0; transition: opacity .15s;
    }
    #scChat .sc-msg:hover .sc-tools, #scChat .sc-msg:focus-within .sc-tools { opacity: 1; }
    #scChat .sc-tool-btn {
        width: 26px; height: 26px; border-radius: 6px; border: 0; background: transparent;
        color: var(--sc-muted); font-size: 12px; cursor: pointer;
    }
    #scChat .sc-tool-btn:hover { background: #f3f4f6; color: var(--sc-text); }
    #scChat .sc-tool-btn.is-danger:hover { background: #fdecee; color: var(--sc-danger); }
    #scChat .sc-tool-btn.is-on { color: var(--sc-pin); }

    /* Compose */
    #scChat .sc-compose { position: relative; border-top: 1px solid var(--sc-line); padding: 10px 12px 12px; background: #fff; }
    #scChat .sc-editing {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; color: var(--sc-blue); margin-bottom: 6px;
    }
    #scChat .sc-link-btn { margin-left: auto; border: 0; background: none; color: var(--sc-muted); font-size: 12px; cursor: pointer; text-decoration: underline; }

    #scChat .sc-box { border: 1px solid #d6d9de; border-radius: 12px; transition: border-color .15s, box-shadow .15s; }
    #scChat .sc-box:focus-within { border-color: var(--sc-blue); box-shadow: 0 0 0 3px var(--sc-blue-soft); }

    #scChat .sc-editor {
        min-height: 44px; max-height: 180px; overflow-y: auto;
        padding: 10px 12px; font-size: 13px; line-height: 1.5; outline: none;
        overflow-wrap: anywhere;
    }
    #scChat .sc-editor:empty::before { content: attr(data-placeholder); color: #9aa0a6; pointer-events: none; }
    #scChat .sc-editor ul, #scChat .sc-editor ol { margin: 2px 0; padding-left: 20px; }
    #scChat .sc-editor img { max-width: 120px; border-radius: 6px; }

    #scChat .sc-files { display: flex; flex-wrap: wrap; gap: 6px; padding: 0 10px; }
    #scChat .sc-files:empty { display: none; }
    #scChat .sc-file {
        display: inline-flex; align-items: center; gap: 6px; max-width: 100%;
        padding: 4px 6px 4px 8px; margin-bottom: 6px;
        border: 1px solid var(--sc-line); border-radius: 8px; background: var(--sc-bg); font-size: 12px;
    }
    #scChat .sc-file span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 220px; }
    #scChat .sc-file img { width: 22px; height: 22px; object-fit: cover; border-radius: 4px; }
    #scChat .sc-file button { border: 0; background: none; color: var(--sc-muted); cursor: pointer; padding: 0 2px; }
    #scChat .sc-file button:hover { color: var(--sc-danger); }
    #scChat .sc-file.is-error { border-color: #f3c9cd; color: var(--sc-danger); }

    #scChat .sc-toolbar { display: flex; align-items: center; gap: 2px; padding: 4px 6px 6px; }
    #scChat .sc-tool {
        width: 30px; height: 30px; border-radius: 7px; border: 0; background: transparent;
        color: #4b5563; font-size: 13px; cursor: pointer;
    }
    #scChat .sc-tool:hover { background: #f3f4f6; color: var(--sc-text); }
    #scChat .sc-tool-sep { width: 1px; height: 18px; background: var(--sc-line); margin: 0 4px; }
    #scChat .sc-send {
        margin-left: auto; display: inline-flex; align-items: center; gap: 6px;
        height: 32px; padding: 0 14px; border: 0; border-radius: 8px;
        background: var(--sc-blue); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer;
    }
    #scChat .sc-send:hover { background: #184e9e; }
    #scChat .sc-send:disabled { background: #9db6dc; cursor: not-allowed; }

    /* @mention list */
    #scChat .sc-mention {
        position: absolute; left: 12px; right: 12px; bottom: calc(100% - 4px);
        max-height: 240px; overflow-y: auto;
        background: #fff; border: 1px solid var(--sc-line); border-radius: 10px;
        box-shadow: 0 10px 24px rgba(17, 24, 39, .15); padding: 4px; z-index: 5;
    }
    #scChat .sc-mention-item {
        display: flex; align-items: center; gap: 8px; width: 100%;
        padding: 6px 8px; border: 0; border-radius: 7px; background: transparent;
        font-size: 13px; text-align: left; cursor: pointer; color: var(--sc-text);
    }
    #scChat .sc-mention-item.is-active, #scChat .sc-mention-item:hover { background: var(--sc-blue-soft); }
    #scChat .sc-mention-item .sc-avatar { flex-basis: 24px; width: 24px; height: 24px; font-size: 10px; }
    #scChat .sc-mention-item small { margin-left: auto; color: var(--sc-muted); font-size: 11px; }
    #scChat .sc-mention-empty { padding: 8px; font-size: 12px; color: var(--sc-muted); }

    /* Confirm popup */
    #scChat .sc-confirm {
        position: absolute; inset: 0; z-index: 10;
        display: flex; align-items: center; justify-content: center;
        background: rgba(17, 24, 39, .35); padding: 16px;
    }
    #scChat .sc-confirm-card {
        width: 340px; max-width: 100%; background: #fff; border-radius: 14px; padding: 22px 20px 18px;
        text-align: center; box-shadow: 0 20px 40px rgba(17, 24, 39, .25);
    }
    #scChat .sc-confirm-icon {
        width: 46px; height: 46px; margin: 0 auto 10px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: #fdecee; color: var(--sc-danger); font-size: 19px;
    }
    #scChat .sc-confirm-card h4 { margin: 0 0 6px; font-size: 16px; font-weight: 700; }
    #scChat .sc-confirm-card p { margin: 0 0 16px; font-size: 13px; color: var(--sc-muted); }
    #scChat .sc-confirm-actions { display: flex; gap: 8px; justify-content: center; }
    #scChat .sc-btn {
        height: 34px; padding: 0 16px; border-radius: 8px; border: 1px solid #d6d9de;
        background: #fff; color: var(--sc-text); font-size: 13px; font-weight: 600; cursor: pointer;
    }
    #scChat .sc-btn:hover { background: #f5f6f7; }
    #scChat .sc-btn-danger { background: var(--sc-danger); border-color: var(--sc-danger); color: #fff; }
    #scChat .sc-btn-danger:hover { background: #bf3540; }

    /* Toast */
    #scChat .sc-toast {
        position: absolute; left: 50%; bottom: 96px; transform: translate(-50%, 8px);
        max-width: calc(100% - 32px); padding: 8px 14px; border-radius: 8px;
        background: #1f2328; color: #fff; font-size: 13px;
        opacity: 0; pointer-events: none; transition: opacity .2s, transform .2s; z-index: 11;
    }
    #scChat .sc-toast.is-visible { opacity: 1; transform: translate(-50%, 0); }
    #scChat .sc-toast.is-error { background: var(--sc-danger); }

    html.sc-lock, html.sc-lock body { overflow: hidden !important; }

    @media (max-width: 576px) {
        #scChat .sc-panel { width: 100%; }
        #scChat .sc-tools { opacity: 1; }
        #scChat .sc-editor { font-size: 16px; }
    }
</style>

@push('js')
<script>
(function ($) {
    if (window.StudioChat) return;   // included twice by mistake

    const CFG = {
        me:        @json(auth()->id()),
        users:     @json($chatUsers ?? []),
        groups:    @json($chatGroups ?? []),
        assetBase: @json(asset('')),
        pmProject: @json(url('projects/view-temp')),
        targetUrl: {
            shoot: @json(route('studio.chat.shoot', ['shoot' => '__ID__'])),
            item:  @json(route('studio.chat.item',  ['item'  => '__ID__'])),
        },
        getUrl: {
            discussion:     @json(url('get_project_management_section_discussion_by_id')),
            sub_discussion: @json(url('get_project_management_section_sub_discussion_by_id')),
        },
        storeUrl:  @json(url('project_management_section_discussion_comment/store')),
        updateUrl: @json(url('project_management_section_discussion_comment/update')),
        deleteUrl: @json(url('project_management_section_discussion_comment/delete')),
        pinUrl:    @json(url('comment/toggle-pin')),
        reactUrl:  @json(url('comment/toggle-reaction')),
        uploadUrl: @json(route('project_management_section_discussion_comment.file_upload.temp')),
    };

    const IMAGE_EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];

    // Same list and order as Project Management (PmSectionDiscussionComment::getReactionTypes)
    const REACTIONS = [
        { type: 'like',     emoji: '👍', label: 'Like' },
        { type: 'heart',    emoji: '❤️', label: 'Love' },
        { type: 'surprise', emoji: '😲', label: 'Surprise' },
        { type: 'sad',      emoji: '😢', label: 'Sad' },
        { type: 'cry',      emoji: '😭', label: 'Cry' },
        { type: 'sweat',    emoji: '😅', label: 'Sweat' },
        { type: 'angry',    emoji: '😠', label: 'Angry' },
        { type: 'tongue',   emoji: '😜', label: 'Silly' },
        { type: 'tears',    emoji: '😂', label: 'Hysterical' },
    ];

    const $root    = $('#scChat');
    const $body    = $('#scBody');
    const $list    = $('#scList');
    const $state   = $('#scState');
    const $editor  = $('#scEditor');
    const $mention = $('#scMention');
    const $files   = $('#scFiles');
    const $send    = $('#scSend');
    const editor   = $editor[0];

    let opts      = null;   // what the page asked to open
    let chat      = null;   // { id, type, title, subtitle }
    let task      = null;   // PM discussion / sub discussion data
    let comments  = [];
    let editingId = null;
    let files     = [];     // [{ key, name, url, uploading, error }]
    let busy      = false;
    let openToken = 0;      // ignore late answers of a chat that was closed / changed
    let lastFocus = null;
    let savedRange = null;
    let mentionState = null; // { node, start, end, q, list, index }

    /* ---------------- helpers ---------------- */
    function esc(v) {
        return String(v == null ? '' : v).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function initials(name) {
        const parts = String(name || '?').trim().split(/\s+/);
        return ((parts[0] || '?').charAt(0) + (parts.length > 1 ? parts[parts.length - 1].charAt(0) : '')).toUpperCase();
    }

    function picUrl(path) {
        if (!path) return null;
        if (/default\.png$/i.test(path)) return null;   // show initials instead of the grey default
        if (/^(https?:)?\/\//i.test(path) || path.indexOf('data:') === 0) return path;
        return CFG.assetBase.replace(/\/$/, '') + '/' + String(path).replace(/^\//, '');
    }

    function avatar(name, pic) {
        const url = picUrl(pic);
        return '<span class="sc-avatar" aria-hidden="true">' + esc(initials(name)) +
               (url ? '<img src="' + esc(url) + '" alt="" onerror="this.remove()">' : '') +
               '</span>';
    }

    function fmtTime(value) {
        if (!value) return '';
        const d = new Date(String(value).replace(' ', 'T'));
        if (isNaN(d)) return esc(value);
        const today = new Date();
        const sameDay = d.toDateString() === today.toDateString();
        const time = d.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
        if (sameDay) return 'Today, ' + time;
        const opt = { month: 'short', day: 'numeric' };
        if (d.getFullYear() !== today.getFullYear()) opt.year = 'numeric';
        return d.toLocaleDateString([], opt) + ', ' + time;
    }

    function toast(message, isError) {
        const $t = $('#scToast');
        $t.text(message).toggleClass('is-error', !!isError).addClass('is-visible');
        clearTimeout(toast.timer);
        toast.timer = setTimeout(function () { $t.removeClass('is-visible'); }, 3000);
    }

    function messageFrom(xhr, fallback) {
        const json = xhr && xhr.responseJSON;
        if (json && json.errors) {
            const first = Object.values(json.errors)[0];
            if (first && first[0]) return first[0];
        }
        if (json && json.message) return json.message;
        if (xhr && xhr.status === 404) return 'This chat no longer exists. It may have been deleted.';
        if (xhr && xhr.status === 419) return 'Your session has expired. Please refresh the page.';
        if (xhr && xhr.status === 403) return 'You do not have permission to do this.';
        return fallback || 'Something went wrong. Please try again.';
    }

    /* AJAX that understands the PM answers: JSON, empty text, or ["error", "Error!", message] */
    function call(method, url, data, isForm) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                url: url,
                method: method,
                data: data || null,
                dataType: 'text',
                processData: !isForm,
                contentType: isForm ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                },
            }).done(function (text) {
                let json = null;
                if (text) {
                    try { json = JSON.parse(text); } catch (e) { json = text; }
                }
                if (Array.isArray(json) && json[0] === 'error') {
                    return reject({ message: json[2] || 'Something went wrong. Please try again.' });
                }
                if (json && json.error === true) {
                    return reject({ message: json.message || 'Something went wrong. Please try again.' });
                }
                resolve(json);
            }).fail(function (xhr) {
                try { xhr.responseJSON = xhr.responseJSON || JSON.parse(xhr.responseText); } catch (e) {}
                reject({ message: messageFrom(xhr), status: xhr.status });
            });
        });
    }

    /* Comment HTML comes from people: keep formatting, drop anything that can run code */
    function clean(html) {
        const doc = new DOMParser().parseFromString('<div>' + (html || '') + '</div>', 'text/html');
        const box = doc.body.firstChild;
        box.querySelectorAll('script, style, iframe, object, embed, link, meta, form, input, button, textarea, select').forEach(function (n) { n.remove(); });
        box.querySelectorAll('*').forEach(function (el) {
            Array.from(el.attributes).forEach(function (a) {
                const name = a.name.toLowerCase();
                const val  = String(a.value || '').trim().toLowerCase();
                if (name.indexOf('on') === 0) el.removeAttribute(a.name);
                if ((name === 'href' || name === 'src') && (val.indexOf('javascript:') === 0 || val.indexOf('vbscript:') === 0)) el.removeAttribute(a.name);
            });
            if (el.tagName === 'A') { el.setAttribute('target', '_blank'); el.setAttribute('rel', 'noopener'); }
        });
        return box.innerHTML;
    }

    /* ---------------- attachments inside comments ---------------- */
    const FILE_EXT_RE = /\.(pdf|docx?|xlsx?|pptx?|csv|txt|zip|rar|ai|psd|eps|mp4|mov|jpe?g|png|gif|webp|bmp|svg)([?#]|$)/i;

    function fileNameFrom(url) {
        const last = String(url || '').split(/[?#]/)[0].split('/').pop() || 'file';
        try { return decodeURIComponent(last); } catch (e) { return last; }
    }

    function isFileLink(a) {
        const href = a.getAttribute('href') || '';
        if (!href || a.closest('.mention-tag')) return false;
        return !!a.closest('.comment-attachment') ||
               /Product(%20| )Master(%20| )Temp|\/storage\/|\/uploads\//i.test(href) ||
               FILE_EXT_RE.test(href);
    }

    function attachmentBar(url, name, canManage, isImage) {
        return '<div class="sc-att-bar">' +
                   '<span class="sc-att-name" title="' + esc(name) + '"><i class="fa-regular ' + (isImage ? 'fa-image' : 'fa-file') + '"></i>' + esc(name) + '</span>' +
                   '<a class="sc-att-btn" href="' + esc(url) + '" target="_blank" rel="noopener" download="' + esc(name) + '"><i class="fa-solid fa-download"></i>Download</a>' +
                   (canManage ? '<button type="button" class="sc-att-btn is-danger" data-sc="del-att" data-url="' + esc(url) + '" title="Delete this attachment"><i class="fa-regular fa-trash-can"></i>Delete</button>' : '') +
               '</div>';
    }

    /* Comment HTML for the screen: every image / file gets its own Download + Delete bar */
    function bodyHtml(c, canManage) {
        const doc = new DOMParser().parseFromString('<div>' + clean(c.comment) + '</div>', 'text/html');
        const box = doc.body.firstChild;

        // Project Management saves its own Download/Delete bars inside the comment: turn them back into plain files
        box.querySelectorAll('.attachment-file-row').forEach(function (row) {
            const a = row.querySelector('a[href]');
            if (!a) { row.remove(); return; }
            const link = doc.createElement('a');
            link.setAttribute('href', a.getAttribute('href'));
            const nameEl = row.querySelector('.attachment-file-name');
            link.textContent = (nameEl ? nameEl.textContent : a.textContent).trim();
            row.replaceWith(link);
        });
        box.querySelectorAll('.attachment-footer').forEach(function (f) { f.remove(); });

        // Images
        box.querySelectorAll('img').forEach(function (img) {
            if (img.closest('.mention-tag')) return;
            const src = img.getAttribute('src');
            if (!src) return;
            const holder = img.closest('.attachment-wrapper') || img;
            const fig = doc.createElement('div');
            fig.className = 'sc-att sc-att-img';
            holder.parentNode.insertBefore(fig, holder);
            img.removeAttribute('style');
            fig.appendChild(img);
            if (holder !== img) holder.remove();
            fig.insertAdjacentHTML('beforeend', attachmentBar(src, fileNameFrom(src), canManage, true));
        });

        // Files (pdf, doc, zip …)
        box.querySelectorAll('a[href]').forEach(function (a) {
            if (a.closest('.sc-att') || a.querySelector('.sc-att') || !isFileLink(a)) return;
            const href = a.getAttribute('href');
            const name = a.textContent.trim() || fileNameFrom(href);
            const row = doc.createElement('div');
            row.className = 'sc-att sc-att-file';
            row.innerHTML = attachmentBar(href, name, canManage, false);
            const wrap = a.closest('.comment-attachment');
            (wrap && wrap.querySelectorAll('a').length === 1 ? wrap : a).replaceWith(row);
        });

        return box.innerHTML;
    }

    /* Remove ONE image / file from the saved comment HTML (same idea as Project Management) */
    function removeAttachment(html, url) {
        const doc = new DOMParser().parseFromString('<div>' + (html || '') + '</div>', 'text/html');
        const box = doc.body.firstChild;
        let found = false;

        box.querySelectorAll('img').forEach(function (img) {
            if (img.getAttribute('src') !== url) return;
            (img.closest('.comment-attachment') || img.closest('.attachment-wrapper') || img).remove();
            found = true;
        });
        box.querySelectorAll('.attachment-file-row').forEach(function (row) {
            const a = row.querySelector('a[href]');
            if (a && a.getAttribute('href') === url) { row.remove(); found = true; }
        });
        box.querySelectorAll('a[href]').forEach(function (a) {
            if (a.getAttribute('href') !== url) return;
            (a.closest('.comment-attachment') || a).remove();
            found = true;
        });

        if (!found) return null;
        const left = (box.textContent || '').replace(/\u00A0/g, ' ').trim();
        return { html: box.innerHTML, empty: !left && !box.querySelector('img, .mention-tag') };
    }

    /* ---------------- open / close ---------------- */
    function open(options) {
        opts = $.extend({ kind: 'shoot', id: null, title: '', onCount: null }, options || {});
        const token = ++openToken;

        if (!$root.hasClass('is-open')) lastFocus = document.activeElement;
        $root.addClass('is-open').attr('aria-hidden', 'false');
        $('html').addClass('sc-lock');

        chat = null; task = null; comments = [];
        resetComposer();
        $list.html('');
        $('#scKicker').text(opts.kind === 'item' ? 'Item chat' : 'Shoot chat');
        $('#scTitle').text(opts.title || 'Loading…');
        $('#scSub').text('');
        $('#scPmLink').addClass('sc-hidden');
        setComposerEnabled(false);
        showState('loading');

        call('GET', CFG.targetUrl[opts.kind === 'item' ? 'item' : 'shoot'].replace('__ID__', encodeURIComponent(opts.id)))
            .then(function (res) {
                if (token !== openToken) return;
                chat = res.chat;
                $('#scTitle').text(chat.title || opts.title);
                $('#scSub').text(chat.subtitle || '');
                return load(token);
            })
            .catch(function (err) {
                if (token !== openToken) return;
                showState('error', err.message);
            });

        setTimeout(function () { $root.find('.sc-head-btn[data-sc="close"]').trigger('focus'); }, 50);
    }

    function close() {
        if (!$root.hasClass('is-open')) return;
        openToken++;
        hideMention();
        $('#scConfirm').addClass('sc-hidden');
        $root.removeClass('is-open').attr('aria-hidden', 'true');
        $('html').removeClass('sc-lock');
        if (lastFocus && document.contains(lastFocus)) lastFocus.focus();
    }

    function load(token) {
        token = token || openToken;
        return call('GET', CFG.getUrl[chat.type] + '/' + encodeURIComponent(chat.id))
            .then(function (res) {
                if (token !== openToken) return;
                task = Array.isArray(res) ? res[0] : res;
                if (!task || !task.id) throw { message: 'This chat no longer exists. It may have been deleted.' };

                comments = (task.comments || []).slice();
                $('#scPmLink').attr('href', CFG.pmProject + '/' + task.project_id).removeClass('sc-hidden');
                setComposerEnabled(true);
                render();
                if (typeof opts.onCount === 'function') opts.onCount(comments.length);
            })
            .catch(function (err) {
                if (token !== openToken) return;
                setComposerEnabled(false);
                showState('error', err.message);
            });
    }

    function showState(kind, message) {
        if (kind === 'loading') {
            $state.removeClass('is-error').html('<i class="fa-solid fa-spinner fa-spin"></i>Loading chat…');
        } else if (kind === 'empty') {
            $state.removeClass('is-error').html('<i class="fa-regular fa-comments"></i>No comments yet. Start the conversation below.');
        } else if (kind === 'error') {
            $state.addClass('is-error').html(
                '<i class="fa-solid fa-circle-exclamation"></i>' + esc(message || 'Could not load the chat.') +
                '<div><button type="button" class="sc-btn" data-sc="retry">Try again</button></div>'
            );
        } else {
            $state.html('');
        }
    }

    /* ---------------- render comments ---------------- */
    function sortComments(list) {
        return list.sort(function (a, b) {
            if (a.is_pinned && !b.is_pinned) return -1;
            if (!a.is_pinned && b.is_pinned) return 1;
            if (a.is_pinned && b.is_pinned) return new Date(b.pinned_at) - new Date(a.pinned_at);
            return new Date(a.created_at) - new Date(b.created_at);
        });
    }

    function canPin(c) {
        return c.can_delete_comment === true || String(c.user_id) === String(CFG.me);
    }

    function reactionsHtml(c) {
        const grouped = (c.reactions_grouped && typeof c.reactions_grouped === 'object' && !Array.isArray(c.reactions_grouped)) ? c.reactions_grouped : {};
        const bubbles = REACTIONS.filter(function (r) { return parseInt(grouped[r.type], 10) > 0; }).map(function (r) {
            const mine = c.user_reaction === r.type;
            return '<button type="button" class="sc-react' + (mine ? ' is-mine' : '') + '" data-sc="react" data-type="' + r.type + '" ' +
                       'title="' + esc(r.label) + (mine ? ' – click to remove your reaction' : '') + '" aria-pressed="' + mine + '">' +
                       '<span class="sc-react-emoji">' + r.emoji + '</span><span>' + parseInt(grouped[r.type], 10) + '</span>' +
                   '</button>';
        }).join('');
        return '<div class="sc-reacts">' + bubbles +
                   '<button type="button" class="sc-react-add" data-sc="react-open" title="Add reaction" aria-label="Add reaction"><i class="fa-regular fa-face-smile"></i></button>' +
               '</div>';
    }

    function canManage(c) {
        return c.can_edit_comment === true || c.can_delete_comment === true || String(c.user_id) === String(CFG.me);
    }

    function renderComment(c) {
        const user  = c.user_info || c.userInfo || {};
        const name  = user.name || 'Unknown user';
        const tools = [];

        if (canPin(c)) {
            tools.push('<button type="button" class="sc-tool-btn' + (c.is_pinned ? ' is-on' : '') + '" data-sc="pin" title="' + (c.is_pinned ? 'Unpin' : 'Pin to top') + '"><i class="fa-solid fa-thumbtack"></i></button>');
        }
        if (c.can_edit_comment === true || String(c.user_id) === String(CFG.me)) {
            tools.push('<button type="button" class="sc-tool-btn" data-sc="edit" title="Edit"><i class="fa-solid fa-pen"></i></button>');
        }
        if (c.can_delete_comment === true) {
            tools.push('<button type="button" class="sc-tool-btn is-danger" data-sc="delete" title="Delete"><i class="fa-regular fa-trash-can"></i></button>');
        }

        return '<div class="sc-msg' + (c.is_pinned ? ' is-pinned' : '') + (String(c.id) === String(editingId) ? ' is-editing' : '') + '" data-id="' + esc(c.id) + '">' +
                   avatar(name, user.profile_pic) +
                   '<div class="sc-msg-main">' +
                       '<div class="sc-meta"><b>' + esc(name) + '</b>' +
                           '<span>' + fmtTime(c.created_at || c.date) + '</span>' +
                           (c.edit_count > 0 ? '<span>(edited)</span>' : '') +
                           (c.is_pinned ? '<span class="sc-pin-badge"><i class="fa-solid fa-thumbtack"></i> Pinned</span>' : '') +
                       '</div>' +
                       '<div class="sc-text">' + bodyHtml(c, canManage(c)) + '</div>' +
                       reactionsHtml(c) +
                   '</div>' +
                   (tools.length ? '<div class="sc-tools">' + tools.join('') + '</div>' : '') +
               '</div>';
    }

    function render(keepScroll) {
        const top = $body.scrollTop();
        sortComments(comments);

        if (!comments.length) {
            $list.html('');
            showState('empty');
            return;
        }
        showState('');

        const pinned = comments.filter(function (c) { return c.is_pinned; });
        const others = comments.filter(function (c) { return !c.is_pinned; });
        let html = '';
        if (pinned.length) {
            html += '<div class="sc-group-label"><i class="fa-solid fa-thumbtack"></i>Pinned</div>' + pinned.map(renderComment).join('');
            if (others.length) html += '<div class="sc-group-label">All comments</div>';
        }
        html += others.map(renderComment).join('');
        $list.html(html);

        if (keepScroll) $body.scrollTop(top);
        else $body.scrollTop($body[0].scrollHeight);
    }

    function findComment(id) {
        return comments.find(function (c) { return String(c.id) === String(id); });
    }

    /* ---------------- composer ---------------- */
    function setComposerEnabled(on) {
        $editor.attr('contenteditable', on ? 'true' : 'false');
        $root.find('.sc-tool').prop('disabled', !on);
        updateSend(on);
    }

    function updateSend(on) {
        const uploading = files.some(function (f) { return f.uploading; });
        $send.prop('disabled', on === false || busy || uploading || !chat || !task);
        $send.find('span').text(busy ? (editingId ? 'Saving…' : 'Posting…') : (uploading ? 'Uploading…' : (editingId ? 'Save' : 'Post')));
    }

    function resetComposer() {
        editingId = null;
        files = [];
        editor.innerHTML = '';
        $('#scEditing').addClass('sc-hidden');
        hideMention();
        renderFiles();
        updateSend();
    }

    function isEditorEmpty() {
        const text = (editor.textContent || '').replace(/ /g, ' ').trim();
        return !text && !editor.querySelector('img, .mention-tag');
    }

    function mentionedIds() {
        const users = [], groups = [];
        $editor.find('.mention-user-tag[data-user-id]').each(function () {
            const id = parseInt($(this).attr('data-user-id'), 10);
            if (id && users.indexOf(id) === -1) users.push(id);
        });
        $editor.find('.mention-tag[data-group-id]').each(function () {
            const id = parseInt($(this).attr('data-group-id'), 10);
            if (id && groups.indexOf(id) === -1) groups.push(id);
        });
        return { users: users.join(','), groups: groups.join(',') };
    }

    function attachmentsHtml() {
        return files.filter(function (f) { return f.url && !f.uploading && !f.error; }).map(function (f) {
            const ext = (f.name.split('.').pop() || '').toLowerCase();
            if (IMAGE_EXT.indexOf(ext) !== -1) {
                return '<div class="comment-attachment" style="margin-top:6px;"><img src="' + esc(f.url) + '" style="width:60%; max-width:100%;" /></div>';
            }
            return '<div class="comment-attachment" style="margin-top:6px;"><i class="fa-regular fa-file" style="margin-right:6px;"></i>' +
                   '<a href="' + esc(f.url) + '" target="_blank">' + esc(f.name) + '</a></div>';
        }).join('');
    }

    function submit() {
        if (busy || !chat || !task) return;
        hideMention();

        const hasFiles = files.some(function (f) { return f.url && !f.error; });
        if (isEditorEmpty() && !hasFiles) {
            toast('Please write a comment first.', true);
            editor.focus();
            return;
        }

        const html = (isEditorEmpty() ? '' : clean(editor.innerHTML)) + attachmentsHtml();
        const mentions = mentionedIds();
        const payload = { comment: html, _token: $('meta[name="csrf-token"]').attr('content') };
        if (mentions.users)  payload.mentioned_users  = mentions.users;
        if (mentions.groups) payload.mentioned_groups = mentions.groups;

        let url = CFG.storeUrl;
        if (editingId) {
            url = CFG.updateUrl + '/' + encodeURIComponent(editingId);
        } else {
            payload.project_id            = task.project_id;
            payload.section_id            = task.section_id;
            payload.section_discussion_id = chat.id;
            payload.discussion_type       = chat.type;
        }

        busy = true;
        updateSend();
        const wasEditing = !!editingId;

        call('POST', url, payload).then(function () {
            busy = false;
            resetComposer();
            toast(wasEditing ? 'Comment updated.' : 'Comment posted.');
            return load();
        }).catch(function (err) {
            busy = false;
            updateSend();
            toast(err.message || 'Could not save the comment.', true);
        });
    }

    function startEdit(c) {
        editingId = c.id;
        files = [];
        renderFiles();
        editor.innerHTML = clean(c.comment);
        $editor.find('.mention-tag').attr('contenteditable', 'false');
        $('#scEditing').removeClass('sc-hidden');
        render(true);
        updateSend();
        placeCaretAtEnd();
    }

    function placeCaretAtEnd() {
        editor.focus();
        const r = document.createRange();
        r.selectNodeContents(editor);
        r.collapse(false);
        const sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(r);
    }

    /* ---------------- attachments ---------------- */
    function renderFiles() {
        $files.html(files.map(function (f) {
            const ext = (f.name.split('.').pop() || '').toLowerCase();
            const thumb = (f.url && IMAGE_EXT.indexOf(ext) !== -1)
                ? '<img src="' + esc(f.url) + '" alt="">'
                : '<i class="fa-regular ' + (f.uploading ? 'fa-hourglass-half' : 'fa-file') + '"></i>';
            return '<span class="sc-file' + (f.error ? ' is-error' : '') + '" data-key="' + f.key + '" title="' + esc(f.error || f.name) + '">' +
                       (f.uploading ? '<i class="fa-solid fa-spinner fa-spin"></i>' : thumb) +
                       '<span>' + esc(f.error ? f.name + ' – failed' : f.name) + '</span>' +
                       (f.uploading ? '' : '<button type="button" data-sc="remove-file" aria-label="Remove ' + esc(f.name) + '"><i class="fa-solid fa-xmark"></i></button>') +
                   '</span>';
        }).join(''));
        updateSend();
    }

    function upload(fileList) {
        Array.from(fileList || []).forEach(function (file) {
            const rec = { key: 'f' + Date.now() + Math.random().toString(36).slice(2), name: file.name, url: null, uploading: true, error: null };
            files.push(rec);

            const fd = new FormData();
            fd.append('upload_file[]', file);
            fd.append('project_id', task ? task.project_id : '');
            fd.append('_token', $('meta[name="csrf-token"]').attr('content'));

            call('POST', CFG.uploadUrl, fd, true).then(function (res) {
                const first = res && Array.isArray(res.data) ? res.data[0] : null;
                if (!first || !first.url) throw { message: 'Upload failed.' };
                rec.url = first.url;
                rec.name = first.name || rec.name;
            }).catch(function (err) {
                rec.error = err.message || 'Upload failed.';
                toast('Could not upload ' + rec.name + '.', true);
            }).then(function () {
                rec.uploading = false;
                renderFiles();
            });
        });
        renderFiles();
    }

    /* ---------------- @mentions ---------------- */
    function saveRange() {
        const sel = window.getSelection();
        if (sel.rangeCount && editor.contains(sel.getRangeAt(0).startContainer)) savedRange = sel.getRangeAt(0).cloneRange();
    }

    function currentQuery() {
        const sel = window.getSelection();
        if (!sel.rangeCount) return null;
        const r = sel.getRangeAt(0);
        if (!r.collapsed || r.startContainer.nodeType !== 3 || !editor.contains(r.startContainer)) return null;
        const before = r.startContainer.textContent.slice(0, r.startOffset);
        const m = before.match(/(?:^|[\s ])@([^\s @]{0,30})$/);
        if (!m) return null;
        return { node: r.startContainer, end: r.startOffset, start: r.startOffset - m[1].length - 1, q: m[1].toLowerCase() };
    }

    function checkMention() {
        const q = currentQuery();
        if (!q) { hideMention(); return; }

        const people = CFG.users.filter(function (u) { return String(u.name).toLowerCase().indexOf(q.q) !== -1; })
            .slice(0, 8).map(function (u) { return { kind: 'user', id: u.id, name: u.name, pic: u.pic }; });
        const groups = CFG.groups.filter(function (g) { return String(g.name).toLowerCase().indexOf(q.q) !== -1; })
            .slice(0, 4).map(function (g) { return { kind: 'group', id: g.id, name: g.name }; });

        q.list = people.concat(groups);
        q.index = 0;
        mentionState = q;
        renderMention();
    }

    function renderMention() {
        const s = mentionState;
        if (!s) return;
        if (!s.list.length) {
            $mention.html('<div class="sc-mention-empty">No one found for “' + esc(s.q) + '”</div>').removeClass('sc-hidden');
            return;
        }
        $mention.html(s.list.map(function (r, i) {
            const pic = r.kind === 'group'
                ? '<span class="sc-avatar" aria-hidden="true"><i class="fa-solid fa-users"></i></span>'
                : avatar(r.name, r.pic);
            return '<button type="button" class="sc-mention-item' + (i === s.index ? ' is-active' : '') + '" data-index="' + i + '" role="option" aria-selected="' + (i === s.index) + '">' +
                       pic + '<span>' + esc(r.name) + '</span>' + (r.kind === 'group' ? '<small>Group</small>' : '') +
                   '</button>';
        }).join('')).removeClass('sc-hidden');
    }

    function hideMention() {
        mentionState = null;
        $mention.addClass('sc-hidden').html('');
    }

    function pickMention(index) {
        const s = mentionState;
        if (!s || !s.list[index]) return;
        const rec = s.list[index];

        const span = document.createElement('span');
        span.className = 'mention-tag ' + (rec.kind === 'group' ? 'mention-group-tag' : 'mention-user-tag');
        span.setAttribute(rec.kind === 'group' ? 'data-group-id' : 'data-user-id', rec.id);
        span.setAttribute('data-mention-type', rec.kind);
        span.setAttribute('contenteditable', 'false');
        span.textContent = '@' + rec.name;

        const r = document.createRange();
        r.setStart(s.node, Math.max(0, s.start));
        r.setEnd(s.node, s.end);
        r.deleteContents();
        r.insertNode(span);

        const space = document.createTextNode(' ');
        span.parentNode.insertBefore(space, span.nextSibling);

        const sel = window.getSelection();
        const after = document.createRange();
        after.setStart(space, 1);
        after.collapse(true);
        sel.removeAllRanges();
        sel.addRange(after);

        hideMention();
        editor.focus();
    }

    function insertAtSign() {
        editor.focus();
        if (savedRange) {
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(savedRange);
        }
        const needsSpace = (function () {
            const q = window.getSelection();
            if (!q.rangeCount) return false;
            const r = q.getRangeAt(0);
            if (r.startContainer.nodeType !== 3) return false;
            const prev = r.startContainer.textContent.charAt(r.startOffset - 1);
            return prev && !/[\s ]/.test(prev);
        })();
        document.execCommand('insertText', false, (needsSpace ? ' ' : '') + '@');
        checkMention();
    }

    /* ---------------- confirm popup ---------------- */
    let confirmAction = null;
    function askDelete(onYes, texts) {
        texts = texts || {};
        confirmAction = onYes;
        $('#scConfirmTitle').text(texts.title || 'Delete this comment?');
        $('#scConfirmText').text(texts.text || 'The comment and its attachments will be removed for everyone, also in Project Management.');
        $('#scConfirmOk').text(texts.ok || 'Delete');
        $('#scConfirm').removeClass('sc-hidden');
        setTimeout(function () { $('#scConfirm [data-sc="confirm-no"]').trigger('focus'); }, 30);
    }
    function closeConfirm() {
        confirmAction = null;
        $('#scConfirm').addClass('sc-hidden');
    }

    /* ---------------- events ---------------- */
    $root.on('click', '[data-sc="close"]', close);
    $root.on('click', '[data-sc="refresh"], [data-sc="retry"]', function () {
        if (!opts) return;
        if (!chat) { open(opts); return; }
        showState(comments.length ? '' : 'loading');
        load();
    });

    $root.on('click', '[data-sc="cancel-edit"]', function () {
        resetComposer();
        render(true);
    });

    $send.on('click', submit);

    $root.on('mousedown', '.sc-tool', function (e) { e.preventDefault(); saveRange(); });  // keep the caret in the editor
    $root.on('click', '.sc-tool[data-cmd]', function () {
        editor.focus();
        document.execCommand($(this).data('cmd'), false, null);
    });
    $root.on('click', '[data-sc="mention"]', insertAtSign);
    $root.on('click', '[data-sc="attach"]', function () { $('#scFileInput').trigger('click'); });

    $('#scFileInput').on('change', function () {
        upload(this.files);
        this.value = '';
    });

    $files.on('click', '[data-sc="remove-file"]', function () {
        const key = $(this).closest('.sc-file').data('key');
        files = files.filter(function (f) { return f.key !== key; });
        renderFiles();
    });

    // Paste as plain text (no strange fonts / colours from Word or web pages)
    $editor.on('paste', function (e) {
        const data = (e.originalEvent || e).clipboardData;
        if (!data) return;
        if (data.files && data.files.length) {
            e.preventDefault();
            upload(data.files);
            return;
        }
        e.preventDefault();
        document.execCommand('insertText', false, data.getData('text/plain'));
    });

    $editor.on('drop', function (e) {
        const dt = (e.originalEvent || e).dataTransfer;
        if (dt && dt.files && dt.files.length) {
            e.preventDefault();
            upload(dt.files);
        }
    });

    $editor.on('input', checkMention);
    $editor.on('keyup click', function (e) {
        saveRange();
        if (e.type === 'click' || ['ArrowLeft', 'ArrowRight', 'Home', 'End'].indexOf(e.key) !== -1) checkMention();
    });
    $editor.on('blur', function () {
        saveRange();
        setTimeout(function () { if (!$mention.is(':hover')) hideMention(); }, 150);
    });

    $editor.on('keydown', function (e) {
        if (mentionState && mentionState.list.length) {
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                const n = mentionState.list.length;
                mentionState.index = (mentionState.index + (e.key === 'ArrowDown' ? 1 : n - 1)) % n;
                renderMention();
                return;
            }
            if (e.key === 'Enter' || e.key === 'Tab') {
                e.preventDefault();
                pickMention(mentionState.index);
                return;
            }
        }
        if (e.key === 'Escape' && mentionState) {
            e.preventDefault();
            e.stopPropagation();
            hideMention();
            return;
        }
        // Ctrl / Cmd + Enter = post
        if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) {
            e.preventDefault();
            submit();
        }
    });

    $mention.on('mousedown', '.sc-mention-item', function (e) {
        e.preventDefault();
        pickMention(parseInt($(this).data('index'), 10));
    });

    // Comment tools
    $list.on('click', '[data-sc="edit"]', function () {
        const c = findComment($(this).closest('.sc-msg').data('id'));
        if (c) startEdit(c);
    });

    $list.on('click', '[data-sc="delete"]', function () {
        const id = $(this).closest('.sc-msg').data('id');
        askDelete(function () {
            call('GET', CFG.deleteUrl + '/' + encodeURIComponent(id)).then(function () {
                if (String(editingId) === String(id)) resetComposer();
                toast('Comment deleted.');
                return load();
            }).catch(function (err) {
                toast(err.message || 'Could not delete the comment.', true);
            });
        });
    });

    // Delete ONE image / file of a comment (the rest of the comment stays)
    $list.on('click', '[data-sc="del-att"]', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const $btn = $(this);
        const id   = $btn.closest('.sc-msg').data('id');
        const url  = $btn.attr('data-url');
        const c    = findComment(id);
        if (!c || !url) return;

        askDelete(function () {
            const result = removeAttachment(c.comment, url);
            if (!result) { toast('This attachment was already removed.', true); load(); return; }

            $btn.prop('disabled', true);
            // Nothing else left in the comment -> delete the whole comment, otherwise save it without this file
            const request = result.empty
                ? call('GET', CFG.deleteUrl + '/' + encodeURIComponent(id))
                : call('POST', CFG.updateUrl + '/' + encodeURIComponent(id), {
                      comment: result.html,
                      _token: $('meta[name="csrf-token"]').attr('content'),
                  });

            request.then(function () {
                if (String(editingId) === String(id)) resetComposer();
                toast('Attachment deleted.');
                return load();
            }).catch(function (err) {
                $btn.prop('disabled', false);
                toast(err.message || 'Could not delete the attachment.', true);
            });
        }, {
            title: 'Delete this attachment?',
            text: '"' + fileNameFrom(url) + '" will be removed from this comment for everyone, also in Project Management. The rest of the comment stays.',
        });
    });

    /* ---------------- reactions ---------------- */
    function closePicker() { $list.find('.sc-react-picker').remove(); }

    function sendReaction(id, type) {
        const c = findComment(id);
        if (!c) return;
        closePicker();
        call('POST', CFG.reactUrl + '/' + encodeURIComponent(id), {
            reaction_type: type || '',
            _token: $('meta[name="csrf-token"]').attr('content'),
        }).then(function (res) {
            if (!res || res.success !== true) throw { message: (res && res.message) || 'Could not save the reaction.' };
            c.reactions_grouped = res.reactions;
            c.user_reaction = res.user_reaction || null;
            $list.find('.sc-msg[data-id="' + id + '"] .sc-reacts').replaceWith(reactionsHtml(c));
        }).catch(function (err) {
            toast(err.message || 'Could not save the reaction.', true);
        });
    }

    // Open the 9-reaction picker above the smiley button
    $list.on('click', '[data-sc="react-open"]', function (e) {
        e.stopPropagation();
        const $btn = $(this);
        const $msg = $btn.closest('.sc-msg');
        const open = $msg.find('.sc-react-picker').length;
        closePicker();
        if (open) return;

        const c = findComment($msg.data('id'));
        const $picker = $('<div class="sc-react-picker" role="menu" aria-label="Pick a reaction"></div>').html(REACTIONS.map(function (r) {
            return '<button type="button" class="sc-react-pick' + (c && c.user_reaction === r.type ? ' is-mine' : '') + '" data-sc="react-pick" data-type="' + r.type + '" title="' + esc(r.label) + '" role="menuitem">' + r.emoji + '</button>';
        }).join(''));
        $msg.append($picker);

        // Place it just above the button, inside the comment card
        const btnPos = $btn.position();
        const msgW = $msg.outerWidth();
        const left = Math.max(8, Math.min(btnPos.left + $btn.closest('.sc-msg-main').position().left, msgW - $picker.outerWidth() - 8));
        let top = $btn.closest('.sc-reacts').position().top + $btn.closest('.sc-msg-main').position().top - $picker.outerHeight() - 6;
        if (top < 4) top = $btn.closest('.sc-reacts').position().top + $btn.closest('.sc-msg-main').position().top + $btn.outerHeight() + 6;
        $picker.css({ left: left, top: top });
        $picker.find('.sc-react-pick').first().trigger('focus');
    });

    // Pick one: same as my current reaction = remove it (the server does the toggle)
    $list.on('click', '[data-sc="react-pick"]', function (e) {
        e.stopPropagation();
        sendReaction($(this).closest('.sc-msg').data('id'), $(this).data('type'));
    });

    // Click a bubble: add that reaction, or remove it if it is mine
    $list.on('click', '[data-sc="react"]', function () {
        sendReaction($(this).closest('.sc-msg').data('id'), $(this).data('type'));
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.sc-react-picker, [data-sc="react-open"]').length) closePicker();
    });

    $list.on('click', '[data-sc="pin"]', function () {
        const $btn = $(this).prop('disabled', true);
        const id = $btn.closest('.sc-msg').data('id');
        call('POST', CFG.pinUrl + '/' + encodeURIComponent(id), { _token: $('meta[name="csrf-token"]').attr('content') })
            .then(function (res) {
                toast((res && res.message) || 'Done.');
                return load();
            })
            .catch(function (err) {
                $btn.prop('disabled', false);
                toast(err.message || 'Could not pin the comment.', true);
            });
    });

    // Open images full size in a new tab
    $list.on('click', '.sc-text .sc-att-img img, .sc-text > img', function () {
        if (this.src) window.open(this.src, '_blank', 'noopener');
    });

    $root.on('click', '[data-sc="confirm-no"]', closeConfirm);
    $root.on('click', '[data-sc="confirm-yes"]', function () {
        const fn = confirmAction;
        closeConfirm();
        if (fn) fn();
    });
    $('#scConfirm').on('click', function (e) { if (e.target === this) closeConfirm(); });

    // Esc closes the popup first, then the chat. Tab stays inside the panel.
    $(document).on('keydown', function (e) {
        if (!$root.hasClass('is-open')) return;
        if (e.key === 'Escape') {
            if ($list.find('.sc-react-picker').length) { closePicker(); return; }
            if (!$('#scConfirm').hasClass('sc-hidden')) closeConfirm();
            else close();
            return;
        }
        if (e.key === 'Tab') {
            const scope = !$('#scConfirm').hasClass('sc-hidden') ? $('#scConfirm') : $root.find('.sc-panel');
            const items = scope.find('a[href]:not(.sc-hidden), button:not(:disabled), [contenteditable="true"], input:not(.sc-hidden)')
                .filter(':visible').toArray();
            if (!items.length) return;
            const first = items[0], last = items[items.length - 1];
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        }
    });

    window.StudioChat = { open: open, close: close };
})(jQuery);
</script>
@endpush