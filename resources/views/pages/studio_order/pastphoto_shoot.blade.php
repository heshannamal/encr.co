@extends('layouts.app', ['activePage' => 'past_photoshoot', 'titlePage' => __('Past Photo Shoots')])

@section('content')

<style>
    /* ==========================================================
       SHOOT SCHEDULE PAGE  (all classes start with "ss-")
       ========================================================== */
    .ss-page {
        --ss-primary: #16a394;
        --ss-primary-dark: #12897c;
        --ss-link: #1d5fd0;
        --ss-border: #e6e8eb;
        --ss-head: #7d7d7d;
        --ss-text: #1f2328;
        --ss-muted: #6b7280;
        --ss-bottom-gap: 110px;   /* space for the fixed world-clock bar */

        font-family: 'Open Sans', sans-serif;
        color: var(--ss-text);
        padding-top: 0 !important;
        padding-bottom: var(--ss-bottom-gap) !important;
    }

    .ss-page *,
    .ss-page *::before,
    .ss-page *::after { box-sizing: border-box; }

    .ss-card {
        background: #fff;
        border: 1px solid var(--ss-border);
        border-radius: 6px;
    }

    .ss-hidden { display: none !important; }
    .ss-dash { color: #b4b9c0; }

    /* ---------- Phone-only ----------
    .ss-page .ss-m-only { display: none; }
    .ss-field .ss-m-label { display: none; }   /* filter labels: phones only */

    /* ---------- Edit shoot modal (opened by the phone Edit button) ---------- */
    .ss-edit-head {
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        padding: 16px 18px; border-bottom: 1px solid #eceef1;
    }
    .ss-edit-head .ss-modal-title { font-size: 18px; }
    .ss-edit-body { flex: 1; min-height: 0; overflow-y: auto; padding: 16px 18px 4px; }
    .ss-edit-field { margin-bottom: 14px; }
    .ss-edit-field label {
        display: block; margin: 0 0 8px; font-size: 14px; font-weight: 600; color: #1f2328;
    }
    .ss-edit-field label .ss-req { color: #e5383b; }
    .ss-edit-field .ss-input {
        height: 48px; padding: 0 14px; font-size: 14px; border-color: #dfe3e8; border-radius: 8px;
    }
    .ss-edit-field input[type="date"].ss-input,
    .ss-edit-field input[type="time"].ss-input {
        display: block; -webkit-appearance: none; appearance: none; text-align: left; line-height: 46px;
    }
    .ss-edit-hint { margin-top: 6px; font-size: 11.5px; line-height: 1.4; color: var(--ss-muted); }
    .ss-edit-field textarea.ss-input { height: 98px; padding: 10px 14px; line-height: 1.45; resize: none; }
    .ss-edit-foot { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 6px 16px 16px; }
    .ss-edit-foot .ss-btn { height: 48px; font-size: 15px; font-weight: 700; border-radius: 8px; }
    .ss-edit-cancel { color: #fff; background: #9aa1ab; }
    .ss-edit-cancel:hover { color: #fff; background: #8a919c; }
    .ss-edit-save { color: #fff; background: #1fa45f; }
    .ss-edit-save:hover { color: #fff; background: #198c50; }

    /* ---------- Filters ---------- */
    .ss-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }

    .ss-search { position: relative; flex: 1 1 200px; min-width: 180px; max-width: 300px; }
    .ss-search i {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        color: #9aa0a6; font-size: 12px; pointer-events: none;
    }
    .ss-search .ss-input { padding-left: 30px; }

    .ss-filter-group {
        display: flex; flex-wrap: nowrap; align-items: flex-end; gap: 8px;
        margin-left: auto; flex: 0 1 auto; min-width: 0;
    }

    .ss-field { display: flex; flex-direction: column; min-width: 0; }
    .ss-field label {
        font-size: 10px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
        color: #4b5563; margin-bottom: 4px; white-space: nowrap;
    }

    .ss-input {
        width: 100%; height: 34px; padding: 0 10px; font-size: 12.5px; color: var(--ss-text);
        background: #fff; border: 1px solid #d6d9de; border-radius: 4px; outline: none;
        text-overflow: ellipsis; transition: border-color .15s, box-shadow .15s;
    }
    .ss-input:focus { border-color: var(--ss-primary); box-shadow: 0 0 0 3px rgba(22, 163, 148, .15); }

    .ss-field-date  { flex: 0 1 160px; width: 160px; }
    .ss-field-style { flex: 0 1 180px; width: 180px; }

    /* Placeholders (grey) */
    .ss-input::placeholder { color: #9aa0a6; }
    .ss-input.is-placeholder { color: #9aa0a6; }
    .ss-input.is-placeholder option { color: #1f2328; }

    .ss-actions { display: flex; gap: 8px; flex-shrink: 0; }

    .ss-btn {
        height: 34px; display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 0 12px; font-size: 12.5px; font-weight: 600; border-radius: 4px;
        border: 1px solid transparent; cursor: pointer; white-space: nowrap;
        transition: background .15s, border-color .15s, color .15s;
    }
    .ss-btn-primary { background: var(--ss-primary); color: #fff; }
    .ss-btn-primary:hover { background: var(--ss-primary-dark); color: #fff; }
    .ss-btn-outline { background: #fff; border-color: #cfd3d8; color: #374151; }
    .ss-btn-outline:hover { background: #f5f6f7; }
    .ss-btn-danger { background: #d64550; color: #fff; }
    .ss-btn-danger:hover { background: #bf3540; color: #fff; }
    .ss-btn-icon { width: 34px; padding: 0; }
    .ss-btn:disabled { opacity: .6; cursor: not-allowed; }

    /* ---------- Main table ---------- */
    .ss-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    .ss-table { width: 100%; min-width: 1000px; border-collapse: collapse; margin: 0; }

    .ss-table > thead th {
        background: var(--ss-head); color: #fff; font-size: 10.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .04em; padding: 12px 10px;
        white-space: nowrap; border: 0;
    }
    .ss-table > thead th:first-child { border-top-left-radius: 6px; padding-left: 14px; }
    .ss-table > thead th:last-child  { border-top-right-radius: 6px; }

    .ss-table th.ss-sortable { cursor: pointer; user-select: none; }
    .ss-table th.ss-sortable i { margin-left: 4px; font-size: 10px; opacity: .75; }
    .ss-table th.ss-sortable.is-active i { opacity: 1; }

    .ss-table > tbody > tr.ss-row > td {
        padding: 14px 10px; font-size: 12.5px; vertical-align: middle;
        border-top: 1px solid var(--ss-border); white-space: nowrap;
    }
    .ss-table > tbody > tr.ss-row > td:first-child { padding-left: 14px; }
    .ss-table > tbody > tr.ss-row:hover { background: #fafbfc; }
    .ss-table > tbody > tr.ss-row.is-open { background: #f6fbfa; }

    /* Expand arrow */
    .ss-toggle {
        width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center;
        border: 0; border-radius: 6px; background: transparent; color: #1f2328; cursor: pointer;
        transition: background .15s;
    }
    .ss-toggle:hover { background: #eef0f2; }
    .ss-toggle i { font-size: 12px; transition: transform .2s; }
    .ss-row.is-open .ss-toggle i { transform: rotate(90deg); }

    .ss-expand-all { color: #fff; }
    .ss-expand-all:hover { background: rgba(255, 255, 255, .15); }
    .ss-expand-all.is-open i { transform: rotate(90deg); }

    .ss-date { display: flex; flex-direction: column; gap: 3px; }
    .ss-shoot-name { font-weight: 700; white-space: normal; line-height: 1.35; }
    .ss-name-wrap { display: inline-flex; align-items: center; gap: 6px; max-width: 100%; }
    .ss-name-wrap .ss-shoot-name { min-width: 0; overflow-wrap: anywhere; }
    .ss-name-editor { width: 100%; max-width: 340px; }
    .ss-name-input { flex: 1; min-width: 140px; height: 30px; padding: 0 8px; }

    .ss-badge {
        display: inline-block; width: fit-content; padding: 1px 8px; font-size: 10px;
        font-weight: 700; border-radius: 999px;
    }
    .ss-badge-upcoming { color: #13806f; background: #e3f6f3; }
    .ss-badge-today    { color: #1d5fd0; background: #e6efff; }
    .ss-badge-past     { color: #6b7280; background: #f1f2f4; }

    .ss-note {
        display: block; max-width: 220px; overflow: hidden; text-overflow: ellipsis;
        white-space: nowrap; color: #4b5563;
    }

    .ss-row-actions { display: inline-flex; gap: 6px; }

    /* Chat button: icon + comment count */
    .ss-chat-btn { position: relative; color: #1f5fbf; }
    .ss-chat-btn:hover { background: #f2f6fd; border-color: #a9bfe6; }
    .ss-chat-count {
        position: absolute; top: -6px; right: -6px;
        min-width: 17px; height: 17px; padding: 0 4px;
        font-size: 10px; font-weight: 700; line-height: 17px; text-align: center;
        color: #fff; background: #1f5fbf; border-radius: 999px; border: 2px solid #fff;
    }
    .ss-icon-btn {
        width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid #dfe3e8; border-radius: 6px; background: #fff; color: #374151;
        cursor: pointer; transition: background .15s, border-color .15s, color .15s;
    }
    .ss-icon-btn:hover { background: #f5f6f7; }
    .ss-icon-btn-danger { color: #d64550; border-color: #f3c9cd; }
    .ss-icon-btn-danger:hover { background: #fdecee; border-color: #eba4ab; color: #bf3540; }

    /* ---------- Expanded detail row ---------- */
    .ss-table > tbody > tr.ss-detail > td {
        padding: 0;
        background: #f6fbfa;
        border-top: 0;
    }

    .ss-detail-inner {
        margin: 0 14px 14px 46px;
        background: #fff;
        border: 1px solid var(--ss-border);
        border-radius: 8px;
        overflow: hidden;
        animation: ssOpen .18s ease-out;
    }

    @keyframes ssOpen {
        from { opacity: 0; transform: translateY(-4px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .ss-detail-head {
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;
        gap: 8px 16px; padding: 10px 14px; border-bottom: 1px solid var(--ss-border);
        background: #fbfcfc;
    }
    .ss-detail-title { font-size: 12.5px; font-weight: 700; color: #1f2328; }
    .ss-detail-title span { color: var(--ss-muted); font-weight: 600; }

    .ss-model-chips { display: flex; flex-wrap: wrap; align-items: center; gap: 6px; }
    .ss-model-chips-label {
        font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em;
        color: var(--ss-muted);
    }

    .ss-items { width: 100%; border-collapse: collapse; }
    .ss-items thead th {
        padding: 9px 10px; font-size: 10px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .04em; color: var(--ss-muted); background: #fff; text-align: left;
        border-bottom: 1px solid var(--ss-border); white-space: nowrap;
    }
    .ss-items thead th:first-child,
    .ss-items tbody td:first-child { padding-left: 14px; }
    .ss-items tbody td {
        padding: 9px 10px; font-size: 12.5px; vertical-align: middle;
        border-top: 1px solid #f0f1f3; white-space: nowrap;
    }
    .ss-items tbody tr:first-child td { border-top: 0; }
    /* Item chat: its own column, spaced like the other columns */
    .ss-items td.ss-i-chat { padding-right: 14px; }
    .ss-items tbody tr:hover { background: #fafbfc; }

    .ss-thumb {
        width: 42px; height: 42px; border: 1px solid var(--ss-border); border-radius: 6px;
        background: #fff; overflow: hidden; display: flex; align-items: center; justify-content: center;
    }
    .ss-thumb img { width: 100%; height: 100%; object-fit: contain; display: block; cursor: zoom-in; }
    .ss-thumb-empty { background: #eceef1; border-color: #eceef1; }

    .ss-item-name { font-weight: 700; white-space: normal; line-height: 1.3; }

    .ss-tags { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 4px; }
    .ss-tags:empty { display: none; }
    .ss-tag {
        display: inline-flex; align-items: center; gap: 5px; max-width: 200px; padding: 2px 8px;
        font-size: 10.5px; font-weight: 600; line-height: 1.5; border-radius: 999px;
        color: #5b42b0; background: #f0ecfb; white-space: nowrap;
    }
    .ss-tag i { font-size: 9.5px; }
    .ss-tag span { overflow: hidden; text-overflow: ellipsis; }

    .ss-page a.ss-order-link,
    .ss-page a.ss-order-link:visited { color: var(--ss-link) !important; font-weight: 700; text-decoration: none; }
    .ss-page a.ss-order-link:hover { color: #164aa6 !important; text-decoration: underline; }

    .ss-org { display: block; max-width: 170px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    /* Model (photo shoot person) */
    .ss-model { display: inline-flex; align-items: center; gap: 8px; }
    .ss-avatar {
        position: relative; overflow: hidden;
        flex-shrink: 0; width: 26px; height: 26px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 10.5px; font-weight: 700; color: #fff; letter-spacing: .02em;
    }
    /* profile photo sits on top of the initials (initials show if the photo cannot load) */
    .ss-avatar img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: block; background: #fff; }
    .ss-model-name { font-weight: 600; }
    .ss-model-chip {
        display: inline-flex; align-items: center; gap: 6px; padding: 2px 10px 2px 2px;
        font-size: 11.5px; font-weight: 600; background: #f3f4f6; border-radius: 999px;
    }
    .ss-model-chip .ss-avatar { width: 22px; height: 22px; font-size: 9.5px; }
    .ss-unassigned {
        display: inline-block; padding: 2px 9px; font-size: 11px; font-weight: 600;
        color: #9a6b00; background: #fff6e0; border-radius: 999px;
    }

    .ss-items-empty { padding: 22px 14px; text-align: center; font-size: 12.5px; color: var(--ss-muted); }

    /* ---------- Empty + footer ---------- */
    .ss-empty { padding: 48px 16px; text-align: center; color: var(--ss-muted); font-size: 13px; }
    .ss-empty i { display: block; font-size: 28px; margin-bottom: 10px; color: #c3c7cc; }

    .ss-footer {
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;
        gap: 12px; padding: 12px 16px; border-top: 1px solid var(--ss-border);
    }
    .ss-info { font-size: 12px; color: var(--ss-muted); }
    .ss-pagination { display: flex; flex-wrap: wrap; gap: 4px; }
    .ss-page-btn {
        min-width: 32px; height: 30px; padding: 0 9px; font-size: 12px; color: #4b5563;
        background: #fff; border: 1px solid #dcdfe3; border-radius: 4px; cursor: pointer;
    }
    .ss-page-btn:hover:not(:disabled):not(.active) { background: #f5f6f7; }
    .ss-page-btn.active { background: var(--ss-primary); border-color: var(--ss-primary); color: #fff; font-weight: 700; }
    .ss-page-btn:disabled { color: #c0c4ca; cursor: not-allowed; }
    .ss-ellipsis { min-width: 24px; height: 30px; display: inline-flex; align-items: center; justify-content: center; color: #9aa0a6; }

    /* ---------- Modals ---------- */
    body.ss-modal-open { overflow: hidden; }

    .ss-modal {
        position: fixed; inset: 0; z-index: 10060; display: none;
        align-items: center; justify-content: center; padding: 20px;
    }
    .ss-modal.is-open { display: flex; }
    .ss-modal-backdrop { position: absolute; inset: 0; background: rgba(15, 23, 42, .5); }

    .ss-modal-dialog {
        position: relative; width: 100%; max-width: 620px; max-height: calc(100vh - 40px);
        display: flex; flex-direction: column; background: #fff; border-radius: 10px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, .25); overflow: hidden;
        animation: ssModalIn .18s ease-out;
    }
    .ss-modal-dialog.ss-modal-sm { max-width: 420px; }
    .ss-modal.ss-modal-top { z-index: 10065; }   /* confirm box above the View modal */

    .ss-delete-summary { border: 1px solid var(--ss-border); border-radius: 8px; overflow: hidden; margin-bottom: 12px; }
    .ss-del-row { display: flex; justify-content: space-between; gap: 12px; padding: 8px 12px; font-size: 12.5px; }
    .ss-del-row + .ss-del-row { border-top: 1px solid #f0f1f3; }
    .ss-del-row span { color: var(--ss-muted); }
    .ss-del-row b { text-align: right; color: #1f2328; }
    .ss-delete-warn {
        display: flex; gap: 8px; padding: 10px 12px; font-size: 12px; line-height: 1.45;
        color: #8a4b00; background: #fff6e0; border-radius: 8px;
    }
    .ss-delete-warn i { margin-top: 2px; }
    .ss-confirm-quote {
        display: block; margin-top: 8px; padding: 8px 10px; font-style: italic; color: #4b5563;
        background: #f8f9fa; border-left: 3px solid #d6d9de; border-radius: 4px; white-space: pre-wrap;
    }

    @keyframes ssModalIn {
        from { opacity: 0; transform: translateY(12px) scale(.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .ss-modal-header { display: flex; align-items: flex-start; gap: 12px; padding: 18px 20px 14px; }
    .ss-modal-icon {
        flex-shrink: 0; width: 38px; height: 38px; border-radius: 8px; display: flex;
        align-items: center; justify-content: center; font-size: 16px;
        color: var(--ss-primary); background: #e3f6f3;
    }
    .ss-modal-icon.is-danger { color: #d64550; background: #fdecee; }
    .ss-modal-heading { flex: 1; min-width: 0; }
    .ss-modal-title { margin: 0; font-size: 17px; font-weight: 700; color: #1a1a1a; line-height: 1.3; }
    .ss-modal-sub { margin: 2px 0 0; font-size: 12px; color: var(--ss-muted); }
    .ss-modal-close {
        flex-shrink: 0; width: 32px; height: 32px; border: 0; border-radius: 6px;
        background: transparent; color: #6b7280; font-size: 16px; cursor: pointer;
    }
    .ss-modal-close:hover { background: #f1f2f4; color: #1f2328; }

    .ss-modal-body { flex: 1; min-height: 0; overflow-y: auto; padding: 4px 20px 18px; font-size: 13px; }
    .ss-modal-footer {
        display: flex; justify-content: flex-end; gap: 8px; padding: 14px 20px;
        border-top: 1px solid var(--ss-border); background: #fafbfc;
    }
    .ss-modal-footer .ss-btn { height: 38px; padding: 0 16px; }

    .ss-summary {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 16px;
    }
    .ss-stat { padding: 10px 12px; background: #f8f9fa; border: 1px solid #eef0f2; border-radius: 8px; }
    .ss-stat-label {
        font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; color: var(--ss-muted);
    }
    .ss-stat-value { margin-top: 3px; font-size: 14px; font-weight: 700; color: #1f2328; }

    .ss-section-title {
        margin: 0 0 8px; font-size: 11px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .04em; color: var(--ss-muted);
    }
    .ss-section { margin-bottom: 16px; }
    .ss-section:last-child { margin-bottom: 0; }
    .ss-note-box {
        padding: 10px 12px; background: #fffbea; border: 1px solid #f6e7b0; border-radius: 8px;
        color: #5c4a00; white-space: pre-wrap;
        overflow-wrap: anywhere;   /* very long words / links break instead of pushing the modal wider */
        word-break: break-word;    /* same, for older browsers */
    }

    .ss-mini-list { display: flex; flex-direction: column; gap: 8px; }
    .ss-mini {
        display: flex; align-items: center; gap: 10px; padding: 8px 10px;
        border: 1px solid var(--ss-border); border-radius: 8px;
    }
    .ss-mini .ss-thumb { width: 38px; height: 38px; }
    .ss-mini-main { flex: 1; min-width: 0; }
    .ss-mini-name { font-weight: 700; font-size: 12.5px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ss-mini-meta { font-size: 11.5px; color: var(--ss-muted); }
    .ss-mini-right { display: inline-flex; align-items: center; gap: 8px; flex-shrink: 0; }
    .ss-mini-remove {
        width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid #f3c9cd; border-radius: 6px; background: #fff; color: #d64550; cursor: pointer;
        transition: background .15s, border-color .15s;
    }
    .ss-mini-remove:hover { background: #fdecee; border-color: #eba4ab; }
    .ss-mini-empty {
        padding: 18px 12px; text-align: center; font-size: 12.5px; color: var(--ss-muted);
        border: 1px dashed #dfe2e6; border-radius: 8px;
    }

    /* ---------- Inline time ---------- */
    .ss-time-wrap { display: inline-flex; align-items: center; gap: 4px; }
    .ss-date-wrap { display: inline-flex; align-items: center; gap: 6px; }
    .ss-table > tbody > tr.ss-row > td.ss-c-date.is-editing { min-width: 210px; }
    .ss-date-input { width: 140px; height: 30px; padding: 0 6px; }
    .ss-table > tbody > tr.ss-row > td.ss-c-time.is-editing { min-width: 190px; }
    .ss-time-editor { display: inline-flex; align-items: center; gap: 4px; border-radius: 6px; }
    .ss-time-input { width: 118px; height: 30px; padding: 0 6px; }
    .ss-time-btn {
        width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid #d6d9de; border-radius: 6px; background: #fff; color: #6b7280; cursor: pointer;
    }
    .ss-time-btn:hover { background: #f5f6f7; color: #1f2328; }
    .ss-time-btn.is-save { color: #fff; background: var(--ss-primary); border-color: var(--ss-primary); }
    .ss-time-btn.is-save:hover { background: var(--ss-primary-dark); }
    .ss-time-editor.is-attention .ss-time-input { animation: ssAttention .6s ease; }

    /* ---------- Inline note ---------- */
    .ss-note-wrap { display: flex; align-items: center; gap: 6px; max-width: 240px; }
    .ss-note-wrap .ss-note { flex: 1; min-width: 0; }
    .ss-note-tools { display: inline-flex; gap: 2px; opacity: 0; transition: opacity .15s; }
    .ss-row:hover .ss-note-tools,
    .ss-note-tools:focus-within { opacity: 1; }
    @media (hover: none) { .ss-note-tools { opacity: 1; } }

    .ss-note-tool {
        width: 24px; height: 24px; border: 0; border-radius: 5px; background: transparent;
        color: #6b7280; font-size: 11px; cursor: pointer;
    }
    .ss-note-tool:hover { background: #eef0f2; color: #1f2328; }
    .ss-note-tool.is-danger:hover { background: #fdecee; color: #d64550; }

    .ss-note-add {
        display: inline-flex; align-items: center; gap: 5px; padding: 3px 8px;
        font-size: 11.5px; font-weight: 600; color: #9aa0a6; background: transparent;
        border: 1px dashed #d6d9de; border-radius: 999px; cursor: pointer;
        transition: color .15s, border-color .15s, background .15s;
    }
    .ss-note-add i { font-size: 9px; }
    .ss-row:hover .ss-note-add,
    .ss-note-add:focus { color: var(--ss-primary); border-color: #9fd9cf; background: #f2fbf9; }

    .ss-table > tbody > tr.ss-row > td.ss-c-note.is-editing { white-space: normal; vertical-align: top; }
    .ss-note-editor { width: 260px; }
    .ss-note-input { height: auto; min-height: 56px; padding: 7px 9px; line-height: 1.45; resize: none; white-space: pre-wrap; }
    .ss-note-editor-foot { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-top: 6px; }
    .ss-note-count { font-size: 10.5px; color: var(--ss-muted); }
    .ss-note-editor-btns { display: inline-flex; gap: 6px; }
    .ss-note-editor-btns .ss-btn { height: 28px; padding: 0 10px; font-size: 11.5px; }
    .ss-note-hint { margin-top: 4px; font-size: 10.5px; color: #9aa0a6; }
    .ss-note-editor.is-attention .ss-note-input { animation: ssAttention .6s ease; }
    @keyframes ssAttention {
        0%, 100% { box-shadow: 0 0 0 0 rgba(214, 113, 58, 0); border-color: #d6d9de; }
        30%      { box-shadow: 0 0 0 4px rgba(214, 113, 58, .25); border-color: #d6713a; }
    }

    /* ---------- Model dropdown button (per item) ---------- */
    .ss-model-btn {
        display: inline-flex; align-items: center; gap: 8px; max-width: 220px;
        padding: 3px 10px 3px 3px; font-size: 12.5px; color: #1f2328; background: #fff;
        border: 1px solid #e1e4e8; border-radius: 999px; cursor: pointer;
        transition: border-color .15s, background .15s, box-shadow .15s;
    }
    .ss-model-btn:hover { border-color: #b9c2cc; background: #fafbfc; }
    .ss-model-btn.is-open { border-color: var(--ss-primary); box-shadow: 0 0 0 3px rgba(22, 163, 148, .15); }
    .ss-model-btn.is-saving { opacity: .55; pointer-events: none; }
    .ss-model-btn .ss-model-name { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ss-model-btn.is-empty { color: #9a6b00; background: #fffaf0; border-style: dashed; border-color: #f0d79b; }
    .ss-model-btn.is-empty:hover { background: #fff4dc; }
    .ss-model-caret { font-size: 9px; color: #9aa0a6; margin-left: 2px; }
    .ss-avatar-empty { background: #f4e2b3 !important; color: #9a6b00 !important; font-size: 10px; }

    .ss-assigned-pill {
        display: inline-flex; align-items: center; gap: 5px; margin-left: 8px; padding: 2px 9px;
        font-size: 10.5px; font-weight: 700; color: #9a6b00; background: #fff6e0; border-radius: 999px;
    }
    .ss-assigned-pill.is-done { color: #13806f; background: #e3f6f3; }

    /* ---------- Model dropdown popover ---------- */
    .ss-pop {
        position: fixed; z-index: 10058; display: none; width: 280px;
        background: #fff; border: 1px solid #dfe3e8; border-radius: 10px;
        box-shadow: 0 14px 36px rgba(15, 23, 42, .18); overflow: hidden;
        font-family: 'Open Sans', sans-serif;
    }
    .ss-pop.is-open { display: block; animation: ssOpen .12s ease-out; }

    .ss-pop-search { position: relative; padding: 8px; border-bottom: 1px solid #eef0f2; }
    .ss-pop-search i { position: absolute; left: 19px; top: 50%; transform: translateY(-50%); font-size: 11px; color: #9aa0a6; }
    .ss-pop-search .ss-input { padding-left: 28px; height: 32px; }

    .ss-pop-list { max-height: 230px; overflow-y: auto; padding: 4px; }
    .ss-pop-option {
        width: 100%; display: flex; align-items: center; gap: 9px; padding: 6px 8px;
        font-size: 12.5px; color: #1f2328; text-align: left; background: transparent;
        border: 0; border-radius: 6px; cursor: pointer;
    }
    .ss-pop-option:hover,
    .ss-pop-option.is-active { background: #f2f7f6; }
    .ss-pop-option.is-current { font-weight: 700; }
    .ss-pop-option.is-clear { color: #6b7280; }
    .ss-pop-name { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ss-pop-check { color: var(--ss-primary); font-size: 11px; }
    .ss-pop-empty { padding: 14px 8px; font-size: 12px; color: var(--ss-muted); text-align: center; }

    .ss-pop-foot { padding: 6px; border-top: 1px solid #eef0f2; background: #fafbfc; }
    .ss-pop-add {
        width: 100%; display: flex; align-items: center; gap: 8px; padding: 7px 8px;
        font-size: 12.5px; font-weight: 600; color: var(--ss-primary); background: transparent;
        border: 0; border-radius: 6px; cursor: pointer;
    }
    .ss-pop-add:hover { background: #eaf7f4; }
    .ss-pop-new { display: flex; gap: 6px; }
    .ss-pop-new .ss-input { height: 32px; }
    .ss-pop-new .ss-btn { height: 32px; }
    .ss-pop-error { padding: 4px 4px 0; font-size: 11.5px; color: #d64550; }

    /* ---------- Model hover card ---------- */
    .ss-mcard {
        position: fixed; z-index: 10057; display: none; width: 300px;
        background: #fff; border: 1px solid #dfe3e8; border-radius: 12px;
        box-shadow: 0 14px 36px rgba(15, 23, 42, .18);
        font-family: 'Open Sans', sans-serif; font-size: 12px; color: #1f2328;
    }
    .ss-mcard.is-open { display: block; animation: ssOpen .12s ease-out; }
    .ss-mc-head { display: flex; align-items: center; gap: 12px; padding: 14px 14px 12px; }
    .ss-mc-head .ss-avatar { width: 56px; height: 56px; font-size: 18px; }
    .ss-mc-title { min-width: 0; flex: 1; }
    .ss-mc-name { display: flex; align-items: baseline; gap: 6px; font-size: 14px; font-weight: 700; line-height: 1.25; }
    .ss-mc-name span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ss-mc-name small { flex-shrink: 0; font-size: 10.5px; font-weight: 600; color: #9aa0a6; }
    .ss-mc-sub { margin-top: 3px; color: #4b5563; }
    .ss-mc-type {
        display: inline-block; margin-top: 5px; padding: 1px 8px; font-size: 10.5px; font-weight: 700;
        color: #6b5fc7; background: #f3f1fc; border-radius: 999px;
    }
    .ss-mc-section { padding: 10px 14px; border-top: 1px solid #eef0f2; }
    .ss-mc-measure { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; text-align: center; }
    .ss-mc-measure div { padding: 5px 2px; background: #f7f8fa; border-radius: 6px; }
    .ss-mc-measure b { display: block; font-size: 12.5px; }
    .ss-mc-measure span { font-size: 10px; color: var(--ss-muted); text-transform: uppercase; letter-spacing: .03em; }
    .ss-mc-measure .is-na b { font-size: 10.5px; font-weight: 600; color: #9aa0a6; }
    .ss-mc-line { display: flex; align-items: flex-start; gap: 8px; padding: 2px 0; line-height: 1.4; }
    .ss-mc-line > i { width: 14px; margin-top: 2px; text-align: center; font-size: 11px; color: #9aa0a6; }
    .ss-mc-line a { color: #1d5fd0; text-decoration: none; word-break: break-all; }
    .ss-mc-line a:hover { text-decoration: underline; }
    .ss-mc-na { color: #9aa0a6; font-style: italic; }
    .ss-mc-warn { color: #b45309; }
    .ss-mc-warn > i { color: #d97706; }
    .ss-mc-label { margin-bottom: 4px; font-size: 10px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ss-muted); }
    .ss-mc-shoots { list-style: none; margin: 0; padding: 0; }
    .ss-mc-shoot { display: flex; align-items: center; gap: 8px; margin: 0 -6px; padding: 4px 6px; border-radius: 6px; }
    .ss-mc-shoot-date { flex-shrink: 0; min-width: 46px; font-weight: 700; }
    .ss-mc-shoot-name { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #374151; }
    .ss-mc-shoot-qty { flex-shrink: 0; font-size: 11px; color: var(--ss-muted); }
    .ss-mc-shoot.is-same { background: #fff4e5; }
    .ss-mc-shoot.is-same .ss-mc-shoot-date,
    .ss-mc-shoot.is-same .ss-mc-shoot-name { color: #b45309; }
    .ss-mc-same {
        flex-shrink: 0; padding: 1px 7px; font-size: 10px; font-weight: 700;
        color: #b45309; background: #fde4c4; border-radius: 999px;
    }
    .ss-mc-more { display: inline-block; margin-top: 4px; font-size: 11.5px; font-weight: 600; color: #1d5fd0 !important; text-decoration: none !important; }
    .ss-mc-more:hover { text-decoration: underline !important; }
    .ss-mc-foot { padding: 8px 14px 12px; border-top: 1px solid #eef0f2; text-align: right; }
    .ss-mc-profile { font-size: 12px; font-weight: 700; color: var(--ss-primary) !important; text-decoration: none !important; }
    .ss-mc-profile:hover { text-decoration: underline !important; }

    /* ---------- Gender label (per item) ---------- */
    .ss-gender {
        display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px;
        font-size: 11.5px; font-weight: 600; border-radius: 999px; white-space: nowrap;
    }
    .ss-gender i { font-size: 10.5px; }
    .ss-gender.is-male   { color: #1d5fd0; background: #eef4ff; }
    .ss-gender.is-female { color: #c2416b; background: #fdf0f4; }
    .ss-gender.is-all    { color: #4b5563; background: #f1f2f4; }

    /* ---------- Toast ---------- */
    .ss-toast {
        position: fixed; right: 20px; bottom: 80px; z-index: 10070; display: flex; align-items: center;
        gap: 10px; max-width: calc(100vw - 40px); padding: 12px 16px; font-size: 13px; color: #fff;
        background: #1f2937; border-radius: 8px; box-shadow: 0 10px 30px rgba(15, 23, 42, .25);
        opacity: 0; transform: translateY(10px); pointer-events: none; transition: opacity .2s, transform .2s;
    }
    .ss-toast.is-visible { opacity: 1; transform: translateY(0); }
    .ss-toast i { color: #34d399; }
    .ss-toast.is-error i { color: #f87171; }

    /* ---------- Image hover preview ---------- */
    .ss-img-preview {
        position: fixed; z-index: 10050; display: none; width: 300px; height: 300px; padding: 10px;
        background: #fff; border: 1px solid #e6e8eb; border-radius: 10px;
        box-shadow: 0 12px 32px rgba(15, 23, 42, .18); pointer-events: none;
    }
    .ss-img-preview.is-visible { display: block; }
    .ss-img-preview img { width: 100%; height: 100%; object-fit: contain; }

    /* ==========================================================
       RESPONSIVE
       ========================================================== */
    @media (max-width: 1199.98px) {
        .ss-search { flex-basis: 100%; max-width: none; }
        .ss-filter-group { margin-left: 0; width: 100%; flex: 1 1 100%; flex-wrap: wrap; }
        .ss-field-date, .ss-field-style { flex: 1 1 160px; width: auto; }
    }

    /* ==========================================================
       PHONES
       ========================================================== */
    @media (max-width: 767.98px) {
        .ss-page {
            --ss-bottom-gap: 130px;
            --ss-mint: #3cc98b;            /* "Filters" (open) + "Filter activity" */
            --ss-mint-dark: #31b37a;
            --ss-m-shadow: 0 1px 2px rgba(16, 24, 40, .05), 0 2px 8px rgba(16, 24, 40, .06);
        }

        /* phone-only / desktop-only helpers */
        .ss-page .ss-d-only { display: none; }
        .ss-page span.ss-m-only { display: inline; }
        .ss-page div.ss-m-only { display: block; }
        .ss-page .ss-field.ss-m-only { display: flex; }
        .ss-page .ss-icon-btn.ss-m-only,
        .ss-page .ss-filter-toggle { display: inline-flex; }

        /* ---------- Search + Filters card ---------- */
        .ss-filters {
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            padding: 16px;
            margin-bottom: 12px;
            border: 1px solid #eef0f2;
            border-radius: 16px;
            box-shadow: var(--ss-m-shadow);
        }

        .ss-search { flex: 1 1 0; min-width: 0; max-width: none; }
        .ss-search i { left: 14px; font-size: 13px; }

        .ss-filters .ss-input {
            height: 44px;
            padding: 0 12px;
            font-size: 14px;
            border-color: #e2e5e9;
            border-radius: 10px;
        }
        .ss-filters .ss-search .ss-input { padding-left: 38px; }   /* room for the search icon */

        .ss-filter-toggle {
            flex: 0 0 auto;
            height: 44px;
            padding: 0 14px;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #1f2328;
            background: #fff;
            border: 1px solid #e2e5e9;
            border-radius: 10px;
        }
        .ss-filter-toggle svg { width: 16px; height: 16px; flex-shrink: 0; }
        .ss-filter-toggle:hover { background: #f7f8f9; }
        .ss-filters.is-open .ss-filter-toggle { color: #fff; background: var(--ss-mint); border-color: var(--ss-mint); }

        /* Filter panel: hidden until "Filters" is tapped */
        .ss-filter-group { display: none; }
        .ss-filters.is-open .ss-filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 14px 10px;
            width: 100%;
            margin: 6px 0 0;
        }
        .ss-filters .ss-field-date,
        .ss-filters .ss-field-style { flex: 1 1 100%; width: auto; }

        .ss-field .ss-m-label {
            display: block;
            margin: 0 0 6px;
            font-size: 12.5px;
            font-weight: 600;
            letter-spacing: 0;
            text-transform: none;
            color: #4b5563;
        }

        /* Native date picker (mm/dd/yyyy) — full height and left aligned on iOS */
        .ss-filters input[type="date"].ss-input {
            display: block;
            min-height: 44px;
            line-height: 42px;
            -webkit-appearance: none;
            appearance: none;
            text-align: left;
        }
        .ss-filters input[type="date"].ss-input::-webkit-date-and-time-value { text-align: left; }

        /* Reset filters (left) + Filter activity (right) */
        .ss-actions { flex: 1 1 100%; width: 100%; gap: 10px; margin-top: 2px; }
        .ss-actions .ss-btn { flex: 1 1 0; height: 44px; font-size: 13.5px; border-radius: 8px; }
        .ss-actions #ssReset {
            order: 1;
            width: auto;
            padding: 0 12px;
            color: #4b5563;
            background: #eef1f6;
            border-color: #dfe3ea;
        }
        .ss-actions #ssReset:hover { background: #e4e8ef; }
        .ss-actions #ssApply { order: 2; font-weight: 700; background: var(--ss-mint); }
        .ss-actions #ssApply:hover { background: var(--ss-mint-dark); }
        .ss-actions #ssApply > i { display: none; }

        /* ---------- Shoot cards ---------- */
        .ss-list-card { background: transparent; border: 0; border-radius: 0; }
        .ss-table-wrap { overflow: visible; }   /* do not cut the card shadows */

        .ss-table { min-width: 0; display: block; }
        .ss-table > thead { display: none; }
        .ss-table > tbody { display: block; }

        .ss-table > tbody > tr.ss-row {
            display: grid;
            grid-template-columns: auto auto minmax(0, 1fr);
            grid-template-areas:
                "name    name    toggle"
                "models  qty     ."
                "date    time    ."
                "note    note    note"
                "actions actions actions";
            column-gap: 18px;
            row-gap: 6px;
            align-items: center;
            padding: 14px;
            margin-bottom: 12px;
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: var(--ss-m-shadow);
        }
        .ss-table > tbody > tr.ss-row:hover,
        .ss-table > tbody > tr.ss-row.is-open { background: #fff; }

        /* open card: the item list below joins it as one card */
        .ss-table > tbody > tr.ss-row.is-open {
            margin-bottom: 0;
            border-bottom: 0;
            border-radius: 14px 14px 0 0;
        }

        .ss-table > tbody > tr.ss-row > td { padding: 0 !important; border: 0; white-space: normal; }

        .ss-c-toggle  { grid-area: toggle; justify-self: end; align-self: start; }
        .ss-c-name    { grid-area: name; min-width: 0; }
        .ss-c-models  { grid-area: models; }
        .ss-c-qty     { grid-area: qty; }
        .ss-c-date    { grid-area: date; }
        .ss-c-time    { grid-area: time; }
        .ss-c-actions { grid-area: actions; margin-top: 6px; }
        .ss-c-note    { grid-area: note; }

        /* Note: grey box with a small "Note" label (only when the shoot has a note) */
        .ss-table > tbody > tr.ss-row > td.ss-c-note { display: none; }
        .ss-table > tbody > tr.ss-row > td.ss-c-note.has-note {
            display: block;
            margin-top: 6px;
            padding: 8px 12px !important;
            background: #f3f4f6;
            border-radius: 10px;
        }
        .ss-c-note.has-note::before {
            content: attr(data-label);
            display: block;
            margin-bottom: 2px;
            font-size: 11px;
            font-weight: 500;
            color: #6b7280;
        }
        .ss-c-note .ss-note-wrap { display: block; max-width: none; }
        /* Long notes: only the first 2 lines, ending with "…".
           The full note is in the View (eye) modal — tapping the note box opens it too. */
        .ss-c-note .ss-note {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            max-width: none;               /* desktop limits it to 220px */
            overflow: hidden;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.45;
            color: #1f2328;
            white-space: normal;
            text-overflow: ellipsis;
            overflow-wrap: anywhere;
        }
        .ss-table > tbody > tr.ss-row > td.ss-c-note.has-note { cursor: pointer; }

        /* Arrow: down when closed, up when open */
        .ss-toggle { margin: -4px -4px 0 0; }
        .ss-toggle i { font-size: 13px; transform: rotate(90deg); }
        .ss-row.is-open .ss-toggle i { transform: rotate(-90deg); }

        /* Name + status badge */
        .ss-name-wrap { display: flex; flex-wrap: wrap; align-items: center; gap: 4px 8px; }
        .ss-shoot-name { font-size: 13.5px; color: #111827; }
        .ss-c-name .ss-badge {
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .02em;
            text-transform: uppercase;
            border-radius: 6px;
        }
        .ss-c-name .ss-badge-upcoming { color: #22a874; background: #e3f8ef; }

        /* "Label • value" lines */
        .ss-c-models, .ss-c-qty, .ss-c-date, .ss-c-time {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 4px;
            font-size: 12px;
            font-weight: 700;
            color: #1f2328;
        }
        .ss-c-models::before, .ss-c-qty::before, .ss-c-date::before, .ss-c-time::before {
            content: attr(data-label) " \2022";
            font-weight: 400;
            color: #4b5563;
            white-space: nowrap;
        }
        .ss-c-date .ss-badge { display: none; }          /* badge is shown next to the name */
        .ss-c-date .ss-date { flex-direction: row; }
        .ss-c-date .ss-date-wrap,
        .ss-c-time .ss-time-wrap { display: inline-flex; }

        /* Inline editors are replaced by the Edit modal on phones */
        .ss-table > tbody > tr.ss-row .ss-note-tools,
        .ss-c-time .ss-note-add { display: none; }

        /* Chat / View / Edit / Delete */
        .ss-row-actions { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; width: 100%; }
        .ss-row-actions .ss-icon-btn {
            width: auto;
            height: 30px;
            font-size: 13px;
            color: #1f2328;
            border-color: #dfe3e8;
            border-radius: 6px;
        }
        .ss-row-actions .ss-chat-btn { border-color: #c4c9cf; box-shadow: 0 1px 2px rgba(16, 24, 40, .06); }
        .ss-row-actions .ss-icon-btn-danger { color: #e5383b; }

        /* ---------- Item list (open card) ---------- */
        .ss-table > tbody > tr.ss-detail { display: block; margin-bottom: 12px; }
        .ss-table > tbody > tr.ss-detail > td {
            display: block;
            background: #fff;
            border: 1px solid #eef0f2;
            border-top: 0;
            border-radius: 0 0 14px 14px;
            box-shadow: var(--ss-m-shadow);
            clip-path: inset(0 -20px -20px -20px);   /* no shadow over the card above */
        }
        .ss-detail-inner {
            margin: 0;
            padding: 14px;
            border: 0;
            border-top: 1px solid #eceef1;
            border-radius: 0;
        }
        .ss-detail-head { display: none; }   /* models + assigned count: in the View (eye) modal */

        .ss-items, .ss-items tbody { display: block; }
        .ss-items thead { display: none; }

        .ss-items tbody tr {
            display: grid;
            grid-template-columns: 46px auto minmax(0, 1fr);
            grid-template-areas:
                "image name    name"
                "image order   gender"
                "image created created"
                "image exf     exf"
                ".     chat    chat"
                ".     model   model";
            column-gap: 10px;
            row-gap: 3px;
            align-items: center;
            padding: 12px;
            margin-bottom: 10px;
            background: #fff;
            border: 1px solid #e6e8eb;
            border-radius: 10px;
        }
        .ss-items tbody tr:last-child { margin-bottom: 0; }
        .ss-items tbody tr:hover { background: #fff; }
        .ss-items tbody td { padding: 0 !important; border: 0; white-space: normal; }

        .ss-i-image   { grid-area: image; align-self: start; }
        .ss-i-name    { grid-area: name; min-width: 0; }
        .ss-i-order   { grid-area: order; }
        .ss-i-gender  { grid-area: gender; }
        .ss-i-created { grid-area: created; }
        .ss-i-exf     { grid-area: exf; }
        .ss-items td.ss-i-chat { grid-area: chat; justify-self: start; margin-top: 4px; padding-right: 0 !important; }
        .ss-i-model   { grid-area: model; margin-top: 8px; min-width: 0; }

        .ss-thumb { width: 46px; height: 46px; }
        .ss-item-name { font-size: 13px; color: #111827; }
        .ss-i-order .ss-order-link { font-size: 12.5px; }

        .ss-i-gender, .ss-i-created, .ss-i-exf {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 4px;
            font-size: 12px;
            font-weight: 700;
            color: #1f2328;
        }
        .ss-i-gender::before, .ss-i-created::before, .ss-i-exf::before {
            content: attr(data-label) " \2022";
            font-weight: 400;
            color: #4b5563;
            white-space: nowrap;
        }
        /* Gender as plain bold text (like the design) */
        .ss-i-gender .ss-gender { padding: 0; font-size: 12px; font-weight: 700; color: #1f2328; background: none; }
        .ss-i-gender .ss-gender i { display: none; }

        /* Small chat pill */
        .ss-items .ss-i-chat .ss-chat-btn {
            width: 44px;
            height: 20px;
            font-size: 10.5px;
            color: #4b5563;
            border-color: #d6d9de;
            border-radius: 999px;
        }
        .ss-items .ss-i-chat .ss-chat-count { top: -7px; right: -9px; }

        /* Model button: full width yellow pill with arrow + eye */
        .ss-model-btn {
            width: 100%;
            max-width: 100%;
            min-height: 34px;
            padding: 3px 12px 3px 4px;
            font-size: 13px;
            font-weight: 600;
            background: #fdf6dc;
            border-color: #f1df9d;
        }
        .ss-model-btn:hover { background: #fbf0c9; border-color: #e9d080; }
        .ss-model-btn .ss-model-name { flex: 1; min-width: 0; text-align: left; }
        .ss-model-btn .ss-model-caret { margin-left: 0; font-size: 11px; color: #1f2328; }
        .ss-model-btn .ss-avatar { width: 26px; height: 26px; }
        .ss-model-btn.is-empty > span:not(.ss-avatar) { flex: 1; text-align: left; }
        /* .ss-model-btn in the selector: stronger than ".ss-page span.ss-m-only { display: inline }",
           so the eye stays a centered flex box (same level as the arrow) */
        .ss-page .ss-model-btn .ss-model-eye {
            display: inline-flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            margin-right: -6px;
            font-size: 13px;
            color: #1f2328;
            border-radius: 50%;
        }
        .ss-model-eye:hover { background: rgba(0, 0, 0, .06); }


        /* ---------- Empty message + pagination ---------- */
        .ss-empty {
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: var(--ss-m-shadow);
        }
        .ss-footer {
            flex-direction: column;
            justify-content: center;
            padding: 12px;
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: var(--ss-m-shadow);
        }
        .ss-pagination { justify-content: center; }

        /* ---------- Edit modal (centered, like the design) ---------- */
        .ss-modal.ss-modal-center { align-items: center; padding: 16px; }
        .ss-modal.ss-modal-center .ss-modal-dialog { max-height: calc(100vh - 32px); border-radius: 14px; }
        .ss-modal { align-items: flex-end; padding: 0; }
        .ss-modal-dialog, .ss-modal-dialog.ss-modal-sm { max-width: none; max-height: 92vh; border-radius: 14px 14px 0 0; }
        .ss-summary { grid-template-columns: repeat(3, 1fr); gap: 8px; }
        .ss-modal-footer .ss-btn { flex: 1; height: 42px; }
        .ss-toast { left: 16px; right: 16px; bottom: 140px; }
    }

    /* Very small phones (320px) */
    @media (max-width: 359.98px) {
        .ss-filters { padding: 12px; }
        .ss-filter-toggle { padding: 0 10px; }
        .ss-table > tbody > tr.ss-row { column-gap: 10px; padding: 12px; }
        .ss-c-models, .ss-c-qty, .ss-c-date, .ss-c-time { gap: 3px; font-size: 11.5px; }
        .ss-c-date .ss-date-wrap, .ss-c-time .ss-time-wrap { white-space: nowrap; }
        .ss-detail-inner { padding: 12px 10px; }
        .ss-items tbody tr { padding: 10px; column-gap: 8px; }
    }
    @media (max-width: 768px) {
        .header1 {
            height: 40px;
            margin-top: 11px;
        }
    }
</style>

<div class="container-fluid ss-page">

    @section('order-header')
        <span>Past Photo Shoots</span>
    @endsection

    {{-- ================= FILTERS ================= --}}
    <div class="ss-card ss-filters">
        <div class="ss-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="ssSearch" class="ss-input" placeholder="Search by shoot, item, order number, model..." autocomplete="off">
        </div>

        {{-- Phones only: opens / closes the filter panel below --}}
        <button type="button" id="ssFilterToggle" class="ss-btn ss-filter-toggle ss-m-only"
                aria-expanded="false" aria-controls="ssFilterGroup">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                <path d="M4 7h16M7 12h10M10 17h4"/>
            </svg>
            Filters
        </button>

        <div class="ss-filter-group" id="ssFilterGroup">
            {{-- Text box with a placeholder that becomes a date picker on focus.
                 On phones it has a label and is always a date picker. --}}
            <div class="ss-field ss-field-date">
                <label class="ss-m-label" for="ssDate">Past Shoot</label>
                <input type="text" id="ssDate" class="ss-input" placeholder="Past Shoot"
                       aria-label="Past Shoot" title="Show shoots on this date" autocomplete="off">
            </div>

            <div class="ss-field ss-field-style">
                <label class="ss-m-label" for="ssStyle">Product Style</label>
                <select id="ssStyle" class="ss-input is-placeholder" aria-label="Product Style">
                    <option value="">Product Style</option>
                </select>
            </div>

            <div class="ss-actions">
                <button type="button" id="ssApply" class="ss-btn ss-btn-primary">
                    <i class="fa-solid fa-filter"></i>
                    <span class="ss-d-only">Apply Filters</span>
                    <span class="ss-m-only">Filter activity</span>
                </button>
                <button type="button" id="ssReset" class="ss-btn ss-btn-outline ss-btn-icon" title="Reset Filters" aria-label="Reset Filters">
                    <i class="fa-solid fa-rotate-right"></i>
                    <span class="ss-m-only">Reset filters</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ================= SHOOTS TABLE ================= --}}
    <div class="ss-card ss-list-card">
        <div class="ss-table-wrap">
            <table class="ss-table">
                <thead>
                    <tr>
                        <th style="width: 44px;">
                            <button type="button" class="ss-toggle ss-expand-all" id="ssExpandAll" title="Expand / collapse all on this page" aria-label="Expand all">
                                <i class="fa-solid fa-angles-right"></i>
                            </button>
                        </th>
                        <th class="ss-sortable" data-sort="date" style="width: 130px;">Shoot Date <i class="fa-solid fa-sort"></i></th>
                        <th class="ss-sortable" data-sort="name">Shoot Name <i class="fa-solid fa-sort"></i></th>
                        <th class="ss-sortable" data-sort="time" style="width: 100px;">Time <i class="fa-solid fa-sort"></i></th>
                        <th class="ss-sortable" data-sort="models" style="width: 160px;">Number of Models <i class="fa-solid fa-sort"></i></th>
                        <th class="ss-sortable" data-sort="qty" style="width: 130px;">Item Quantity <i class="fa-solid fa-sort"></i></th>
                        <th class="ss-sortable" data-sort="note" style="width: 220px;">Note <i class="fa-solid fa-sort"></i></th>
                        <th style="width: 90px;"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody id="ssBody"></tbody>
            </table>
        </div>

        <div id="ssEmpty" class="ss-empty ss-hidden">
            <i class="fa-regular fa-calendar-xmark"></i>
            <span id="ssEmptyText">No shoots match your filters.</span>
        </div>

        <div class="ss-footer">
            <div class="ss-info" id="ssInfo"></div>
            <div class="ss-pagination" id="ssPagination"></div>
        </div>
    </div>

    {{-- ================= VIEW SHOOT MODAL ================= --}}
    <div class="ss-modal" id="ssViewModal" aria-hidden="true">
        <div class="ss-modal-backdrop" data-close></div>
        <div class="ss-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="ssViewTitle">
            <div class="ss-modal-header">
                <div class="ss-modal-icon"><i class="fa-solid fa-camera"></i></div>
                <div class="ss-modal-heading">
                    <h5 class="ss-modal-title" id="ssViewTitle"></h5>
                    <p class="ss-modal-sub" id="ssViewSub"></p>
                </div>
                <button type="button" class="ss-modal-close" data-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="ss-modal-body" id="ssViewBody"></div>
            <div class="ss-modal-footer">
                <button type="button" class="ss-btn ss-btn-outline" data-close>Close</button>
            </div>
        </div>
    </div>

    {{-- ================= REMOVE ITEM FROM SHOOT (confirm) =================
         Opens on top of the View modal --}}
    <div class="ss-modal ss-modal-top" id="ssRemoveItemModal" aria-hidden="true">
        <div class="ss-modal-backdrop" data-close></div>
        <div class="ss-modal-dialog ss-modal-sm" role="alertdialog" aria-modal="true" aria-labelledby="ssRemoveItemTitle" aria-describedby="ssRemoveItemText">
            <div class="ss-modal-header">
                <div class="ss-modal-icon is-danger"><i class="fa-solid fa-link-slash"></i></div>
                <div class="ss-modal-heading">
                    <h5 class="ss-modal-title" id="ssRemoveItemTitle">Remove item from shoot?</h5>
                    <p class="ss-modal-sub" id="ssRemoveItemText"></p>
                </div>
                <button type="button" class="ss-modal-close" data-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="ss-modal-footer">
                <button type="button" class="ss-btn ss-btn-outline" data-close>Cancel</button>
                <button type="button" class="ss-btn ss-btn-danger" id="ssRemoveItemConfirm">Remove from shoot</button>
            </div>
        </div>
    </div>

    {{-- ================= SHARED CONFIRM (remove time / remove note) ================= --}}
    <div class="ss-modal ss-modal-top" id="ssConfirmModal" aria-hidden="true">
        <div class="ss-modal-backdrop" data-close></div>
        <div class="ss-modal-dialog ss-modal-sm" role="alertdialog" aria-modal="true" aria-labelledby="ssConfirmTitle" aria-describedby="ssConfirmText">
            <div class="ss-modal-header">
                <div class="ss-modal-icon is-danger"><i id="ssConfirmIcon" class="fa-regular fa-trash-can"></i></div>
                <div class="ss-modal-heading">
                    <h5 class="ss-modal-title" id="ssConfirmTitle"></h5>
                    <p class="ss-modal-sub" id="ssConfirmText"></p>
                </div>
                <button type="button" class="ss-modal-close" data-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="ss-modal-footer">
                <button type="button" class="ss-btn ss-btn-outline" data-close>Cancel</button>
                <button type="button" class="ss-btn ss-btn-danger" id="ssConfirmOk">Remove</button>
            </div>
        </div>
    </div>

    {{-- ================= DELETE CONFIRM MODAL ================= --}}
    <div class="ss-modal" id="ssDeleteModal" aria-hidden="true">
        <div class="ss-modal-backdrop" data-close></div>
        <div class="ss-modal-dialog ss-modal-sm" role="dialog" aria-modal="true" aria-labelledby="ssDeleteTitle">
            <div class="ss-modal-header">
                <div class="ss-modal-icon is-danger"><i class="fa-regular fa-trash-can"></i></div>
                <div class="ss-modal-heading">
                    <h5 class="ss-modal-title" id="ssDeleteTitle">Delete shoot?</h5>
                    <p class="ss-modal-sub" id="ssDeleteText"></p>
                </div>
                <button type="button" class="ss-modal-close" data-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="ss-modal-body">
                <div class="ss-delete-summary" id="ssDeleteSummary"></div>
                <div class="ss-delete-warn">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>The shoot and its model assignments will be removed. The items stay in <b>Studio Items</b> and can be added to another shoot.</span>
                </div>
            </div>
            <div class="ss-modal-footer">
                <button type="button" class="ss-btn ss-btn-outline" data-close>Cancel</button>
                <button type="button" class="ss-btn ss-btn-danger" id="ssDeleteConfirm">Delete Shoot</button>
            </div>
        </div>
    </div>

    {{-- ================= EDIT SHOOT MODAL (phones: Edit button on each shoot card) =================
         Saves through the same routes as the desktop inline editors (name / date / time / note).
         A new date (today or later) moves the shoot to the Photo Shoot Schedule, like on desktop. --}}
    <div class="ss-modal ss-modal-center" id="ssEditModal" aria-hidden="true">
        <div class="ss-modal-backdrop" data-close></div>
        <div class="ss-modal-dialog ss-modal-sm" role="dialog" aria-modal="true" aria-labelledby="ssEditTitle">
            <div class="ss-edit-head">
                <h5 class="ss-modal-title" id="ssEditTitle">Edit</h5>
                <button type="button" class="ss-modal-close" data-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form class="ss-edit-body" id="ssEditForm" novalidate>
                <div class="ss-edit-field">
                    <label for="ssEditName">Shoot Name<span class="ss-req">*</span></label>
                    <input type="text" id="ssEditName" class="ss-input" maxlength="255" autocomplete="off" required>
                </div>
                <div class="ss-edit-field">
                    <label for="ssEditDate">Shoot Date <span class="ss-req">*</span></label>
                    <input type="date" id="ssEditDate" class="ss-input" required>
                    <div class="ss-edit-hint">Pick today or a later date to schedule this shoot again.</div>
                </div>
                <div class="ss-edit-field">
                    <label for="ssEditTime">Time</label>
                    <input type="time" id="ssEditTime" class="ss-input" step="60">
                </div>
                <div class="ss-edit-field">
                    <label for="ssEditNote">Note</label>
                    <textarea id="ssEditNote" class="ss-input" maxlength="500"></textarea>
                </div>
            </form>
            <div class="ss-edit-foot">
                <button type="button" class="ss-btn ss-edit-cancel" data-close>Cancel</button>
                <button type="button" class="ss-btn ss-edit-save" id="ssEditSave">Save</button>
            </div>
        </div>
    </div>

    <div class="ss-toast" id="ssToast" role="status" aria-live="polite">
        <i class="fa-solid fa-circle-check"></i><span data-role="text"></span>
    </div>

    {{-- Model dropdown (one shared popover for all items) --}}
    <div class="ss-pop" id="ssModelPop" role="dialog" aria-label="Choose model" aria-hidden="true">
        <div class="ss-pop-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="ss-input" data-role="search" placeholder="Search models..." autocomplete="off">
        </div>
        <div class="ss-pop-list" data-role="list" role="listbox"></div>
    </div>

    {{-- Selected model info card (desktop: hover the model button, phone: tap the eye or the photo) --}}
    <div class="ss-mcard" id="ssModelCard" role="tooltip" aria-hidden="true"></div>
</div>

<div class="ss-img-preview" id="ssImgPreview" aria-hidden="true"><img src="" alt=""></div>


@include('pages.studio_order.studio_chat')
@endsection

@push('js')
<script>
$(function () {

    const PER_PAGE  = 10;
    const ORDER_URL = @json(url('order_details/edit/__ID__/order')) + '?active_tab=order';
    let shoots   = @json($shoots);
    const MODELS = @json($fashionModels);
    const STYLES = @json($styles);

    const SS_ROUTES = {
        name:       @json(route('studio.shoot.schedule.name',   ['shoot' => '__SHOOT__'])),
        date:       @json(route('studio.shoot.schedule.date',   ['shoot' => '__SHOOT__'])),
        time:       @json(route('studio.shoot.schedule.time',   ['shoot' => '__SHOOT__'])),
        note:       @json(route('studio.shoot.schedule.note',   ['shoot' => '__SHOOT__'])),
        itemModel:  @json(route('studio.shoot.schedule.item.model',  ['shoot' => '__SHOOT__', 'item' => '__ITEM__'])),
        itemRemove: @json(route('studio.shoot.schedule.item.remove', ['shoot' => '__SHOOT__', 'item' => '__ITEM__'])),
        destroy:    @json(route('studio.shoots.destroy', ['shoot' => '__SHOOT__'])),
    };

    function ssRoute(name, shootId, itemId) {
        return SS_ROUTES[name]
            .replace('__SHOOT__', encodeURIComponent(shootId))
            .replace('__ITEM__', encodeURIComponent(itemId || ''));
    }

    // AJAX helper: returns a Promise (rejects with the jQuery XHR on error)
    function api(method, url, data) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                url: url,
                method: method,
                data: data ? JSON.stringify(data) : null,
                contentType: 'application/json',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                },
            }).done(resolve).fail(reject);
        });
    }

    // Nice message from a failed request
    function errorMessage(xhr, fallback) {
        const json = xhr && xhr.responseJSON;
        if (json && json.errors) {
            const first = Object.values(json.errors)[0];
            if (first && first[0]) return first[0];
        }
        if (json && json.message && xhr.status !== 500) return json.message;
        if (xhr && xhr.status === 419) return 'Your session has expired. Please refresh the page.';
        if (xhr && xhr.status === 404) return 'This record no longer exists. Please refresh the page.';
        return fallback || 'Something went wrong. Please try again.';
    }

    function iso(y, m, d) {
        return y + '-' + String(m).padStart(2, '0') + '-' + String(d).padStart(2, '0');
    }

    // Models of a shoot = the people assigned to its items (no duplicates, in item order).
    // So "Number of Models" always matches the items.
    function shootModels(s) {
        const list = [];
        const seen = {};
        s.items.forEach(function (i) {
            if (i.model_id && !seen[i.model_id]) { seen[i.model_id] = true; list.push(i.model); }
        });
        return list;
    }

    /* =====================================================
       HELPERS
       ===================================================== */
    function esc(value) { return $('<div>').text(value == null ? '' : String(value)).html(); }

    function todayISO() {
        const d = new Date();
        return iso(d.getFullYear(), d.getMonth() + 1, d.getDate());
    }

    function formatDate(isoDate) {
        if (!isoDate) return '—';
        const p = isoDate.split('-');
        return new Date(+p[0], +p[1] - 1, +p[2]).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
    }

    // "13:30" -> "01:30PM"
    function formatTime(t) {
        if (!t) return '—';
        const p = t.split(':');
        let h = +p[0];
        const ap = h >= 12 ? 'PM' : 'AM';
        h = h % 12 || 12;
        return String(h).padStart(2, '0') + ':' + p[1] + ap;
    }

    function pad2(n) { return String(n).padStart(2, '0'); }

    // Yesterday as "YYYY-MM-DD" (last day a past shoot can have)
    function yesterdayISO() {
        const d = new Date(); d.setDate(d.getDate() - 1);
        return d.getFullYear() + '-' + pad2(d.getMonth() + 1) + '-' + pad2(d.getDate());
    }
    function plural(n, word) { return n + ' ' + word + (n === 1 ? '' : 's'); }

    function orderNumber(id) { return String(id).padStart(6, '0'); }

    function dateBadge(date) {
        const today = todayISO();
        if (date === today) return '<span class="ss-badge ss-badge-today">Today</span>';
        if (date > today)   return '<span class="ss-badge ss-badge-upcoming">Upcoming</span>';
        return '<span class="ss-badge ss-badge-past">Past</span>';
    }

    // Same person always gets the same avatar color
    const AVATAR_COLORS = ['#16a394', '#7b5fc7', '#d6713a', '#1d5fd0', '#c2416b', '#3d8b40'];

    // Profile photo of a model (fashion_models.profile_photo) by id, or by name when no id is known
    function modelPhoto(name, id) {
        let m = null;
        if (id) m = MODELS.find(function (x) { return String(x.id) === String(id); });
        if (!m && name) m = MODELS.find(function (x) { return x.name === name; });
        return m && m.photo ? m.photo : null;
    }

    // Round avatar: profile photo if the model has one, otherwise coloured initials
    function avatar(name, id) {
        name = name || '';
        let hash = 0;
        for (let i = 0; i < name.length; i++) hash = (hash * 31 + name.charCodeAt(i)) >>> 0;
        const initials = name.split(/\s+/).map(function (w) { return w.charAt(0); }).slice(0, 2).join('').toUpperCase();
        const photo = modelPhoto(name, id);
        return '<span class="ss-avatar" style="background:' + AVATAR_COLORS[hash % AVATAR_COLORS.length] + '">' + esc(initials) +
            (photo ? '<img src="' + esc(photo) + '" alt="' + esc(name) + '" loading="lazy" onerror="this.remove()">' : '') +
        '</span>';
    }

    function thumb(item) {
        if (!item.image) return '<div class="ss-thumb ss-thumb-empty"></div>';
        return '<div class="ss-thumb"><img src="' + esc(item.image) + '" alt="' + esc(item.name) + '" loading="lazy" class="ss-thumb-img" ' +
               'onerror="this.parentNode.classList.add(\'ss-thumb-empty\'); this.remove();"></div>';
    }

    let toastTimer = null;
    function showToast(message, isError) {
        const $t = $('#ssToast');
        $t.toggleClass('is-error', !!isError)
          .find('i').attr('class', isError ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check');
        $t.find('[data-role="text"]').text(message);
        $t.addClass('is-visible');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { $t.removeClass('is-visible'); }, 3000);
    }

    // Button "Saving..." state while a request runs
    function setBusy($btn, busy, text) {
        if (busy) {
            $btn.data('label', $btn.html()).prop('disabled', true)
                .html('<i class="fa-solid fa-spinner fa-spin"></i> ' + (text || 'Saving...'));
        } else {
            $btn.prop('disabled', false).html($btn.data('label') || $btn.html());
        }
    }

    let confirmAction = null;

    function askConfirm(opts) {
        confirmAction = opts.onConfirm || null;
        $('#ssConfirmTitle').text(opts.title || 'Are you sure?');
        $('#ssConfirmText').html(opts.html || '');
        $('#ssConfirmOk').text(opts.confirmText || 'Remove');
        $('#ssConfirmIcon').attr('class', opts.icon || 'fa-regular fa-trash-can');
        openModal($('#ssConfirmModal'));
    }

    // onConfirm may return a Promise (AJAX): the box stays open with "Removing..." until it finishes
    $('#ssConfirmOk').on('click', function () {
        const action = confirmAction;
        if (!action) { closeModal($('#ssConfirmModal')); return; }

        const result = action();
        if (!result || typeof result.then !== 'function') {
            confirmAction = null;
            closeModal($('#ssConfirmModal'));
            return;
        }

        const $btn = $(this);
        setBusy($btn, true, 'Removing...');
        result.then(function () {
            setBusy($btn, false);
            confirmAction = null;
            closeModal($('#ssConfirmModal'));
        }).catch(function (xhr) {
            setBusy($btn, false);        // keep the box open so the user can try again
            showToast(errorMessage(xhr), true);
        });
    });

    /* =====================================================
       FILTER DROPDOWNS
       ===================================================== */
    STYLES.forEach(function (s) {
        $('#ssStyle').append($('<option>').val(s.id).text(s.name));
    });

    /* =====================================================
       STATE
       ===================================================== */
    let filtered = shoots.slice();
    let page     = 1;
    let sortKey  = 'date';
    let sortDir  = 'desc';   // newest past shoot first (this page shows only shoots before today)
    const open   = new Set();      // expanded shoot ids
    let pendingDelete = null;

    /* =====================================================
       SORT + FILTER
       ===================================================== */
    function sortValue(s) {
        switch (sortKey) {
            case 'date':   return s.date + ' ' + (s.time || '99:99');   // same day: shoots without a time go last
            case 'name':   return s.name.toLowerCase();
            case 'time':   return s.time || '';
            case 'models': return shootModels(s).length;
            case 'qty':    return s.items.length;
            case 'note':   return (s.note || '').toLowerCase();
        }
        return '';
    }

    function sortShoots() {
        shoots.sort(function (a, b) {
            const x = sortValue(a), y = sortValue(b);
            if (sortKey === 'note' || sortKey === 'time') {   // empty notes / times always last
                if (!x && y) return 1;
                if (x && !y) return -1;
            }
            if (x < y) return sortDir === 'asc' ? -1 : 1;
            if (x > y) return sortDir === 'asc' ? 1 : -1;
            return 0;
        });

        $('.ss-sortable').removeClass('is-active').find('i').attr('class', 'fa-solid fa-sort');
        $('.ss-sortable[data-sort="' + sortKey + '"]').addClass('is-active').find('i')
            .attr('class', sortDir === 'asc' ? 'fa-solid fa-sort-up' : 'fa-solid fa-sort-down');
    }

    function applyFilters() {
        const search  = $('#ssSearch').val().trim().toLowerCase();
        const date    = $('#ssDate').val();
        const styleId = $('#ssStyle').val();

        filtered = shoots.filter(function (s) {
            if (date && s.date !== date) return false;

            // A shoot matches when ANY of its items matches
            if (styleId && !s.items.some(function (i) { return i.style_ids.map(String).indexOf(styleId) !== -1; })) return false;

            if (search) {
                const text = [s.name, s.note, shootModels(s).join(' ')]
                    .concat(s.items.map(function (i) {
                        return i.name + ' ' + orderNumber(i.order_id) + ' #' + orderNumber(i.order_id) + ' ' + (i.model || '') + ' ' + i.kits.join(' ');
                    }))
                    .join(' ').toLowerCase();
                if (text.indexOf(search) === -1) return false;
            }
            return true;
        });

        page = 1;
        render();
    }

    /* =====================================================
       RENDER
       ===================================================== */
    function chatBadge(s) {
        const n = parseInt(s.chat_count, 10) || 0;
        return n > 0 ? '<span class="ss-chat-count">' + (n > 99 ? '99+' : n) + '</span>' : '';
    }

    function renderShootRow(s) {
        const isOpen = open.has(s.id);

        return '' +
        '<tr class="ss-row' + (isOpen ? ' is-open' : '') + '" data-id="' + s.id + '">' +
            '<td class="ss-c-toggle"><button type="button" class="ss-toggle" data-action="toggle" aria-expanded="' + isOpen + '" aria-label="Show items of ' + esc(s.name) + '"><i class="fa-solid fa-chevron-right"></i></button></td>' +
            '<td class="ss-c-date" data-label="Shoot Date">' + renderDateCell(s) + '</td>' +
            '<td class="ss-c-name">' + renderNameCell(s) + '</td>' +
            '<td class="ss-c-time" data-label="Time">' + renderTimeCell(s) + '</td>' +
            // desktop shows "01", phones show "1"
            '<td class="ss-c-models" data-label="Models Count">' + countCell(shootModels(s).length) + '</td>' +
            '<td class="ss-c-qty" data-label="Item Quantity">' + countCell(s.items.length) + '</td>' +
            // has-note: phones show the note as a grey "Note" box on the card
            '<td class="ss-c-note' + (s.note ? ' has-note' : '') + '" data-label="Note">' + renderNoteCell(s) + '</td>' +
            '<td class="ss-c-actions"><div class="ss-row-actions">' +
                '<button type="button" class="ss-icon-btn ss-chat-btn" data-action="chat" title="Shoot chat" aria-label="Open chat of ' + esc(s.name) + '"><i class="fa-regular fa-message"></i>' + chatBadge(s) + '</button>' +
                '<button type="button" class="ss-icon-btn" data-action="view" title="View shoot" aria-label="View ' + esc(s.name) + '"><i class="fa-regular fa-eye"></i></button>' +
                // phones only: opens the Edit modal (name / date / time / note)
                '<button type="button" class="ss-icon-btn ss-m-only" data-action="edit" title="Edit shoot" aria-label="Edit ' + esc(s.name) + '"><i class="fa-regular fa-pen-to-square"></i></button>' +
                '<button type="button" class="ss-icon-btn ss-icon-btn-danger" data-action="delete" title="Delete shoot"><i class="fa-regular fa-trash-can"></i></button>' +
            '</div></td>' +
        '</tr>' +
        (isOpen ? renderDetailRow(s) : '');
    }

    /* Time cell: "Add time" button, or the time with edit / clear icons */
    function countCell(n) {
        return '<span class="ss-d-only">' + pad2(n) + '</span><span class="ss-m-only">' + n + '</span>';
    }

    function renderNameCell(s) {
        return '<div class="ss-name-wrap">' +
                   '<div class="ss-shoot-name">' + esc(s.name) + '</div>' +
                   '<span class="ss-m-only">' + dateBadge(s.date) + '</span>' +   // phones: badge next to the name
                   '<span class="ss-note-tools">' +
                       '<button type="button" class="ss-note-tool" data-action="name-edit" title="Rename shoot" aria-label="Rename shoot"><i class="fa-solid fa-pen"></i></button>' +
                   '</span>' +
               '</div>';
    }

    function renderDateCell(s) {
        return '<div class="ss-date-wrap">' +
                   '<div class="ss-date"><span>' + esc(formatDate(s.date)) + '</span>' + dateBadge(s.date) + '</div>' +
                   '<span class="ss-note-tools">' +
                       '<button type="button" class="ss-note-tool" data-action="date-edit" title="Change shoot date" aria-label="Change shoot date"><i class="fa-solid fa-pen"></i></button>' +
                   '</span>' +
               '</div>';
    }

    function renderTimeCell(s) {
        if (!s.time) {
            return '<button type="button" class="ss-note-add" data-action="time-edit"><i class="fa-solid fa-plus"></i> Add time</button>' +
                   '<span class="ss-m-only ss-dash">—</span>';   // phones: add the time with the Edit button
        }
        return '<div class="ss-time-wrap">' +
                   '<span>' + esc(formatTime(s.time)) + '</span>' +
                   '<span class="ss-note-tools">' +
                       '<button type="button" class="ss-note-tool" data-action="time-edit" title="Edit time" aria-label="Edit time"><i class="fa-solid fa-pen"></i></button>' +
                       '<button type="button" class="ss-note-tool is-danger" data-action="time-clear" title="Remove time" aria-label="Remove time"><i class="fa-solid fa-xmark"></i></button>' +
                   '</span>' +
               '</div>';
    }

    /* Note cell: "Add note" button, or the note with edit / delete icons */
    function renderNoteCell(s) {
        if (!s.note) {
            return '<button type="button" class="ss-note-add" data-action="note-edit"><i class="fa-solid fa-plus"></i> Add note</button>';
        }
        return '<div class="ss-note-wrap">' +
                   '<span class="ss-note" title="' + esc(s.note) + '">' + esc(s.note) + '</span>' +
                   '<span class="ss-note-tools">' +
                       '<button type="button" class="ss-note-tool" data-action="note-edit" title="Edit note" aria-label="Edit note"><i class="fa-solid fa-pen"></i></button>' +
                       '<button type="button" class="ss-note-tool is-danger" data-action="note-delete" title="Delete note" aria-label="Delete note"><i class="fa-regular fa-trash-can"></i></button>' +
                   '</span>' +
               '</div>';
    }

    // "2 / 3 assigned" pill (orange while some items still have no model)
    function assignedPill(s) {
        const done = s.items.filter(function (i) { return i.model; }).length;
        const all  = s.items.length;
        if (!all) return '';
        const ok = done === all;
        return ' <span class="ss-assigned-pill' + (ok ? ' is-done' : '') + '">' +
                   '<i class="fa-solid ' + (ok ? 'fa-circle-check' : 'fa-user-clock') + '"></i> ' + done + ' / ' + all + ' assigned' +
               '</span>';
    }

    /* Gender label for one shoot item (order_items.gender: Men / Women / all — read only) */
    function genderLabel(i) {
        if (i.gender === 'male')   return '<span class="ss-gender is-male"><i class="fa-solid fa-mars"></i> Male</span>';
        if (i.gender === 'female') return '<span class="ss-gender is-female"><i class="fa-solid fa-venus"></i> Female</span>';
        if (i.gender === 'all')    return '<span class="ss-gender is-all"><i class="fa-solid fa-venus-mars"></i> All</span>';
        return '<span class="ss-dash">—</span>';
    }

    // Item chat icon (opens the item's sub discussion chat)
    function itemChatButton(i) {
        return '<button type="button" class="ss-icon-btn ss-chat-btn" data-action="item-chat" data-item="' + i.id + '" ' +
                   'title="Item chat" aria-label="Open chat of ' + esc(i.name) + '">' +
                   '<i class="fa-regular fa-message"></i>' + chatBadge(i) +
               '</button>';
    }

    function renderDetailRow(s) {
        const modelChips = shootModels(s).map(function (m) {
            return '<span class="ss-model-chip">' + avatar(m) + esc(m) + '</span>';
        }).join('');

        let body;
        if (!s.items.length) {
            body = '<div class="ss-items-empty">No items in this shoot yet.</div>';
        } else {
            body =
            '<table class="ss-items">' +
                '<thead><tr>' +
                    '<th>Created Date</th><th>Image</th><th>Name</th><th>Gender</th><th>Ex Factory Date</th>' +
                    '<th>Order Number</th><th>Model</th><th>Chat</th>' +
                '</tr></thead><tbody>' +
                s.items.map(function (i) {
                    const tags = i.kits.map(function (k) {
                        return '<span class="ss-tag" title="Kit: ' + esc(k) + '"><i class="fa-solid fa-boxes-stacked"></i><span>' + esc(k) + '</span></span>';
                    }).join('');
                    const model =
                        '<button type="button" class="ss-model-btn' + (i.model ? '' : ' is-empty') + '" data-action="pick-model" data-item="' + i.id + '" aria-haspopup="listbox">' +
                            (i.model
                                ? avatar(i.model, i.model_id) + '<span class="ss-model-name">' + esc(i.model) + '</span>'
                                : '<span class="ss-avatar ss-avatar-empty"><i class="fa-solid fa-user-plus"></i></span><span>Assign model</span>') +
                            '<i class="fa-solid fa-chevron-down ss-model-caret"></i>' +
                            // phones only: eye = model info card
                            (i.model ? '<span class="ss-model-eye ss-m-only" title="Model details"><i class="fa-regular fa-eye"></i></span>' : '') +
                        '</button>';

                    return '<tr>' +
                        '<td class="ss-i-created" data-label="Created Date">' + esc(formatDate(i.created_at)) + '</td>' +
                        '<td class="ss-i-image">' + thumb(i) + '</td>' +
                        '<td class="ss-i-name"><div class="ss-item-name">' + esc(i.name) + '</div><div class="ss-tags">' + tags + '</div></td>' +
                        '<td class="ss-i-gender" data-label="Gender">' + genderLabel(i) + '</td>' +
                        '<td class="ss-i-exf" data-label="Ex Factory Date">' + esc(formatDate(i.ex_factory_date)) + '</td>' +
                        '<td class="ss-i-order"><a class="ss-order-link" target="_blank" rel="noopener" href="' + esc(ORDER_URL.replace('__ID__', encodeURIComponent(i.order_id))) + '">#' + esc(orderNumber(i.order_id)) + '</a></td>' +
                        '<td class="ss-i-model">' + model + '</td>' +
                        '<td class="ss-i-chat">' + itemChatButton(i) + '</td>' +
                    '</tr>';
                }).join('') +
                '</tbody></table>';
        }

        return '' +
        '<tr class="ss-detail" data-detail-for="' + s.id + '"><td colspan="8">' +
            '<div class="ss-detail-inner">' +
                '<div class="ss-detail-head">' +
                    '<div class="ss-detail-title">Items in this shoot <span>(' + s.items.length + ')</span>' + assignedPill(s) + '</div>' +
                    '<div class="ss-model-chips"><span class="ss-model-chips-label">Models:</span>' + (modelChips || '<span class="ss-unassigned">None</span>') + '</div>' +
                '</div>' +
                body +
            '</div>' +
        '</td></tr>';
    }

    function pageList(current, total) {
        if (total <= 7) return Array.from({ length: total }, function (_, i) { return i + 1; });
        if (current <= 4)         return [1, 2, 3, 4, 5, '…', total];
        if (current >= total - 3) return [1, '…', total - 4, total - 3, total - 2, total - 1, total];
        return [1, '…', current - 1, current, current + 1, '…', total];
    }

    function renderPagination(totalPages) {
        let html = '<button type="button" class="ss-page-btn" data-page="prev"' + (page === 1 ? ' disabled' : '') + '>Previous</button>';
        pageList(page, totalPages).forEach(function (p) {
            html += (p === '…')
                ? '<span class="ss-ellipsis">…</span>'
                : '<button type="button" class="ss-page-btn' + (p === page ? ' active' : '') + '" data-page="' + p + '">' + p + '</button>';
        });
        html += '<button type="button" class="ss-page-btn" data-page="next"' + (page === totalPages ? ' disabled' : '') + '>Next</button>';
        $('#ssPagination').html(html);
    }

    function visibleShoots() {
        const start = (page - 1) * PER_PAGE;
        return filtered.slice(start, start + PER_PAGE);
    }

    function render() {
        closePop();   // a full re-draw closes the model dropdown
        hideCard();   // ... and the model info card
        const total      = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        page = Math.min(Math.max(page, 1), totalPages);

        const start = (page - 1) * PER_PAGE;
        const list  = visibleShoots();

        $('#ssBody').html(list.map(renderShootRow).join(''));

        if (!total) {
            $('#ssEmptyText').text(shoots.length ? 'No shoots match your filters.' : 'No past shoots yet. Shoots move here automatically after their date has passed.');
            $('#ssEmpty').removeClass('ss-hidden');
            $('#ssInfo').text('No shoots found');
            $('#ssPagination').empty();
        } else {
            $('#ssEmpty').addClass('ss-hidden');
            $('#ssInfo').text('Showing ' + (start + 1) + '–' + (start + list.length) + ' of ' + plural(total, 'Shoot'));
            renderPagination(totalPages);
        }

        updateExpandAll();
    }

    function updateExpandAll() {
        const list = visibleShoots();
        const allOpen = list.length > 0 && list.every(function (s) { return open.has(s.id); });
        $('#ssExpandAll').toggleClass('is-open', allOpen)
            .attr('aria-label', allOpen ? 'Collapse all' : 'Expand all');
    }

    function findShoot(id) {
        return shoots.find(function (s) { return String(s.id) === String(id); });
    }

    /* =====================================================
       EVENTS: table
       ===================================================== */
    // Arrow -> show / hide items (only this row is re-drawn)
    $('#ssBody').on('click', '[data-action="toggle"]', function () {
        const $row = $(this).closest('tr.ss-row');
        const s    = findShoot($row.data('id'));
        if (!s) return;

        if (open.has(s.id)) {
            open.delete(s.id);
            $row.removeClass('is-open').next('tr.ss-detail').remove();
            $(this).attr('aria-expanded', 'false');
        } else {
            open.add(s.id);
            $row.addClass('is-open').after(renderDetailRow(s));
            $(this).attr('aria-expanded', 'true');
        }
        updateExpandAll();
    });

    // Header arrow -> expand / collapse every shoot on this page
    $('#ssExpandAll').on('click', function () {
        const list = visibleShoots();
        const allOpen = list.length > 0 && list.every(function (s) { return open.has(s.id); });
        list.forEach(function (s) { allOpen ? open.delete(s.id) : open.add(s.id); });
        render();
    });

    $('.ss-sortable').on('click', function () {
        const key = $(this).data('sort');
        if (sortKey === key) {
            sortDir = sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            sortKey = key;
            sortDir = (key === 'models' || key === 'qty' || key === 'date') ? 'desc' : 'asc';
        }
        sortShoots();
        applyFilters();
    });

    $('#ssPagination').on('click', '.ss-page-btn', function () {
        if (this.disabled) return;
        const t = $(this).data('page');
        if (t === 'prev') page--; else if (t === 'next') page++; else page = parseInt(t, 10);
        render();
        $('html, body').stop().animate({ scrollTop: $('.ss-table-wrap').offset().top - 90 }, 250);
    });

    /* =====================================================
       EVENTS: filters
       ===================================================== */
    let searchTimer = null;
    $('#ssSearch').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(applyFilters, 250);
    });

    /* ---------------- PHONES ---------------- */
    const phoneQuery = window.matchMedia('(max-width: 767.98px)');
    function isPhone() { return phoneQuery.matches; }

    const $filters      = $('.ss-filters');
    const $filterToggle = $('#ssFilterToggle');

    function setFilterPanel(isOpenPanel) {
        $filters.toggleClass('is-open', isOpenPanel);
        $filterToggle.attr('aria-expanded', isOpenPanel ? 'true' : 'false');
    }

    // "Filters" button opens / closes the filter panel
    $filterToggle.on('click', function () { setFilterPanel(!$filters.hasClass('is-open')); });

    $('#ssApply').on('click', function () {
        applyFilters();
        if (isPhone()) setFilterPanel(false);    // phones: close the panel so the results are visible
    });

    /* "Past Shoot": shows a placeholder, becomes a date picker on focus.
       On phones it has a label, so it is always a date picker (mm/dd/yyyy). */
    const $ssDate = $('#ssDate');
    function ssDateType() {
        const el = $ssDate[0];
        if (!el || el.value) return;             
        el.type = isPhone() ? 'date' : 'text';
        if (el.type === 'date') el.max = yesterdayISO();
    }
    ssDateType();
    if (phoneQuery.addEventListener) phoneQuery.addEventListener('change', ssDateType);
    else if (phoneQuery.addListener) phoneQuery.addListener(ssDateType);

    $ssDate.on('focus', function () {
        if (this.type !== 'date') {
            this.type = 'date';
            this.max  = yesterdayISO();   // only shoots before today exist on this page
            try { if (this.showPicker) this.showPicker(); } catch (e) { /* the user can click again */ }
        }
    });
    $ssDate.on('blur', function () { if (!this.value && !isPhone()) this.type = 'text'; });
    $ssDate.on('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); applyFilters(); } });

    // Product Style: grey while nothing is chosen
    $('#ssStyle').on('change', function () { $(this).toggleClass('is-placeholder', !this.value); });

    $('#ssReset').on('click', function () {
        $('#ssSearch, #ssDate').val('');
        $ssDate.attr('type', isPhone() ? 'date' : 'text');
        $('#ssStyle').val('').addClass('is-placeholder');
        sortKey = 'date';
        sortDir = 'desc';
        sortShoots();
        applyFilters();
    });

    /* =====================================================
       MODALS
       ===================================================== */
    // Modals can open on top of each other (View -> Remove item), so keep a small stack
    const modalStack = [];   // [{ $m, focus }]

    function openModal($m) {
        modalStack.push({ $m: $m, focus: document.activeElement });
        $m.addClass('is-open').attr('aria-hidden', 'false');
        $('body').addClass('ss-modal-open');
        setTimeout(function () { $m.find('.ss-modal-close').trigger('focus'); }, 30);
    }

    function closeModal($m) {
        $m.removeClass('is-open').attr('aria-hidden', 'true');
        const idx = modalStack.findIndex(function (x) { return x.$m[0] === $m[0]; });
        const entry = idx !== -1 ? modalStack.splice(idx, 1)[0] : null;
        if (!$('.ss-modal.is-open').length) $('body').removeClass('ss-modal-open');
        if (entry && entry.focus && entry.focus.focus) entry.focus.focus();
    }

    $('.ss-modal').on('click', '[data-close]', function () { closeModal($(this).closest('.ss-modal')); });
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && modalStack.length) closeModal(modalStack[modalStack.length - 1].$m);   // only the top one
    });

    // View shoot
    let viewShoot  = null;  
    let removeItem = null;   

    function renderViewModal(s) {
        const assigned = s.items.filter(function (i) { return i.model; }).length;

        $('#ssViewTitle').text(s.name);
        $('#ssViewSub').html(esc(formatDate(s.date)) + (s.time ? ' at ' + esc(formatTime(s.time)) : ' · <span class="ss-dash">time not set</span>') + ' &nbsp;' + dateBadge(s.date));

        const itemsHtml = s.items.length
            ? s.items.map(function (i) {
                return '<div class="ss-mini" data-item="' + i.id + '">' + thumb(i) +
                    '<div class="ss-mini-main"><div class="ss-mini-name" title="' + esc(i.name) + '">' + esc(i.name) + '</div>' +
                    '<div class="ss-mini-meta">#' + esc(orderNumber(i.order_id)) + ' · Ex Factory ' + esc(formatDate(i.ex_factory_date)) + '</div></div>' +
                    '<span class="ss-mini-right">' +
                        (i.model ? '<span class="ss-model" title="' + esc(i.model) + '">' + avatar(i.model, i.model_id) + '</span>' : '<span class="ss-unassigned">Not assigned</span>') +
                        '<button type="button" class="ss-mini-remove" data-action="remove-item" title="Remove from shoot" aria-label="Remove ' + esc(i.name) + ' from shoot">' +
                            '<i class="fa-regular fa-trash-can"></i></button>' +
                    '</span>' +
                '</div>';
            }).join('')
            : '<div class="ss-mini-empty">No items in this shoot. Add items from the Studio Items page.</div>';

        $('#ssViewBody').html(
            '<div class="ss-summary">' +
                '<div class="ss-stat"><div class="ss-stat-label">Models</div><div class="ss-stat-value">' + shootModels(s).length + '</div></div>' +
                '<div class="ss-stat"><div class="ss-stat-label">Items</div><div class="ss-stat-value">' + s.items.length + '</div></div>' +
                '<div class="ss-stat"><div class="ss-stat-label">Assigned</div><div class="ss-stat-value">' + assigned + ' / ' + s.items.length + '</div></div>' +
            '</div>' +
            '<div class="ss-section"><p class="ss-section-title">Models</p><div class="ss-model-chips">' +
                (shootModels(s).map(function (m) { return '<span class="ss-model-chip">' + avatar(m) + esc(m) + '</span>'; }).join('') || '<span class="ss-unassigned">None</span>') +
            '</div></div>' +
            (s.note ? '<div class="ss-section"><p class="ss-section-title">Note</p><div class="ss-note-box">' + esc(s.note) + '</div></div>' : '') +
            '<div class="ss-section"><p class="ss-section-title">Items (' + s.items.length + ')</p><div class="ss-mini-list">' + itemsHtml + '</div></div>'
        );
    }

    // Chat icon -> right-side shoot chat (studio_chat.blade.php)
    $('#ssBody').on('click', '[data-action="chat"]', function () {
        const s = findShoot($(this).closest('tr.ss-row').data('id'));
        if (!s || !window.StudioChat) return;
        StudioChat.open({
            kind: 'shoot',
            id: s.id,
            title: s.name,
            onCount: function (n) {
                s.chat_count = n;
                $('#ssBody tr.ss-row[data-id="' + s.id + '"] [data-action="chat"]')
                    .find('.ss-chat-count').remove().end()
                    .append(chatBadge(s));
            },
        });
    });

    // Item chat icon -> right-side item chat (PM sub discussion of this shoot item)
    $('#ssBody').on('click', '[data-action="item-chat"]', function () {
        const $btn = $(this);
        const s = findShoot($btn.closest('tr.ss-detail').data('detail-for'));
        const itemId = $btn.data('item');
        const i = s ? s.items.find(function (x) { return String(x.id) === String(itemId); }) : null;
        if (!i || !window.StudioChat) return;
        StudioChat.open({
            kind: 'item',
            id: i.id,
            title: i.name,
            onCount: function (n) {
                i.chat_count = n;
                $('#ssBody tr.ss-detail[data-detail-for="' + s.id + '"] [data-action="item-chat"][data-item="' + i.id + '"]')
                    .find('.ss-chat-count').remove().end()
                    .append(chatBadge(i));
            },
        });
    });

    $('#ssBody').on('click', '[data-action="view"]', function () {
        const s = findShoot($(this).closest('tr.ss-row').data('id'));
        if (!s) return;
        viewShoot = s;
        renderViewModal(s);
        openModal($('#ssViewModal'));
    });

    // Step 1: trash icon -> ask first
    $('#ssViewBody').on('click', '[data-action="remove-item"]', function () {
        if (!viewShoot) return;
        const item = findItem(viewShoot, $(this).closest('.ss-mini').data('item'));
        if (!item) return;
        removeItem = item;
        $('#ssRemoveItemText').html(
            '<b>' + esc(item.name) + '</b> (#' + esc(orderNumber(item.order_id)) + ') will be removed from <b>' + esc(viewShoot.name) + '</b>. ' +
            'The item stays in Studio Items and can be added to a shoot again.'
        );
        openModal($('#ssRemoveItemModal'));
    });

    // Step 2: confirmed -> remove from this shoot only
    $('#ssRemoveItemConfirm').on('click', function () {
        if (!viewShoot || !removeItem) return;
        const s = viewShoot, item = removeItem;
        const $btn = $(this);

        setBusy($btn, true, 'Removing...');
        api('DELETE', ssRoute('itemRemove', s.id, item.id)).then(function () {
            setBusy($btn, false);
            s.items = s.items.filter(function (i) { return i !== item; });
            removeItem = null;

            closeModal($('#ssRemoveItemModal'));
            renderViewModal(s);       // update the View modal
            rerenderShoot(s);         // update the table row (Item Quantity, Models, item list)
            showToast('"' + item.name + '" removed from "' + s.name + '".');
        }).catch(function (xhr) {
            setBusy($btn, false);
            showToast(errorMessage(xhr, 'Could not remove the item. Please try again.'), true);
        });
    });

    // Delete shoot
    $('#ssBody').on('click', '[data-action="delete"]', function () {
        const s = findShoot($(this).closest('tr.ss-row').data('id'));
        if (!s) return;
        pendingDelete = s;
        const models = shootModels(s);
        $('#ssDeleteText').html('You are about to delete <b>' + esc(s.name) + '</b>.');
        $('#ssDeleteSummary').html(
            '<div class="ss-del-row"><span>Date</span><b>' + esc(formatDate(s.date)) + '</b></div>' +
            '<div class="ss-del-row"><span>Time</span><b>' + (s.time ? esc(formatTime(s.time)) : '<span class="ss-dash">not set</span>') + '</b></div>' +
            '<div class="ss-del-row"><span>Items</span><b>' + s.items.length + '</b></div>' +
            '<div class="ss-del-row"><span>Models</span><b>' + (models.length ? esc(models.join(', ')) : '<span class="ss-dash">none</span>') + '</b></div>'
        );
        openModal($('#ssDeleteModal'));
    });

    $('#ssDeleteConfirm').on('click', function () {
        if (!pendingDelete) return;
        const s = pendingDelete;
        const $btn = $(this);

        setBusy($btn, true, 'Deleting...');
        api('DELETE', ssRoute('destroy', s.id)).then(function () {
            setBusy($btn, false);
            shoots = shoots.filter(function (x) { return x !== s; });
            open.delete(s.id);
            pendingDelete = null;
            closeModal($('#ssDeleteModal'));
            const currentPage = page;
            applyFilters();
            page = currentPage;
            render();
            showToast('Shoot "' + s.name + '" deleted.');
        }).catch(function (xhr) {
            setBusy($btn, false);
            showToast(errorMessage(xhr, 'Could not delete the shoot. Please try again.'), true);
        });
    });

    /* =====================================================
       EDIT SHOOT MODAL (phones)
       -----------------------------------------------------
       Same rules and the same routes as the desktop inline
       editors. Only the changed fields are saved, one after
       the other (name -> time -> note -> date).
       Empty time / empty note = remove it.
       A new date (today or later) moves the shoot to the
       Photo Shoot Schedule, so it leaves this list (like desktop).
       ===================================================== */
    let editShoot = null;

    function openEditModal(s) {
        editShoot = s;
        $('#ssEditName').val(s.name || '');
        $('#ssEditDate').val(s.date || '').attr('min', earliestShootDate(s));
        $('#ssEditTime').val((s.time || '').slice(0, 5));
        $('#ssEditNote').val(s.note || '');
        openModal($('#ssEditModal'));
    }

    $('#ssBody').on('click', '[data-action="edit"]', function () {
        const s = findShoot($(this).closest('tr.ss-row').data('id'));
        if (s) openEditModal(s);
    });

    // Phones: tapping the (shortened) note box opens the View modal with the full note
    $('#ssBody').on('click', 'tr.ss-row > td.ss-c-note.has-note', function () {
        if (!isPhone()) return;    // desktop keeps its inline note editor
        $(this).closest('tr.ss-row').find('[data-action="view"]').trigger('click');
    });

    // Enter in a text box = Save (the note box keeps Enter for new lines)
    $('#ssEditForm').on('submit', function (e) { e.preventDefault(); $('#ssEditSave').trigger('click'); });
    $('#ssEditForm').on('keydown', 'input', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); $('#ssEditSave').trigger('click'); }
    });

    function editError(message, field) {
        showToast(message, true);
        if (field) $(field).trigger('focus');
    }

    $('#ssEditSave').on('click', function () {
        const s = editShoot;
        if (!s) return;

        const name = $.trim($('#ssEditName').val()).replace(/\s+/g, ' ');
        const date = $('#ssEditDate').val() || '';
        const time = $('#ssEditTime').val() || '';
        const note = $.trim($('#ssEditNote').val());

        const nameChanged = name !== s.name;
        const dateChanged = date !== s.date;
        const timeChanged = time !== (s.time || '').slice(0, 5);
        const noteChanged = note !== (s.note || '');

        // ---- Check first (same rules as the inline editors) ----
        if (nameChanged && name.length < NAME_MIN) return editError('Shoot name must be at least ' + NAME_MIN + ' characters.', '#ssEditName');
        if (dateChanged) {
            if (!date) return editError('Please choose a shoot date.', '#ssEditDate');
            if (date < todayISO()) return editError('Pick today or a later date. The shoot will then move to the Photo Shoot Schedule.', '#ssEditDate');
            const late = latestExFactoryItem(s);
            if (late && date < late.ex_factory_date) {
                return editError('"' + late.name + '" is ex factory on ' + formatDate(late.ex_factory_date) + '. The shoot date must be on or after that date.', '#ssEditDate');
            }
        }
        if (note.length > NOTE_MAX) return editError('Note can be up to ' + NOTE_MAX + ' characters.', '#ssEditNote');

        // ---- Requests for the changed fields only (date last: it moves the shoot away) ----
        const steps = [];
        if (nameChanged) steps.push(function () {
            return api('PATCH', ssRoute('name', s.id), { shoot_name: name })
                .then(function (res) { s.name = (res && res.name) || name; });
        });
        if (timeChanged) steps.push(function () {
            return api('PATCH', ssRoute('time', s.id), { shoot_time: time || null })
                .then(function (res) { s.time = time ? ((res && res.time) || time) : ''; });
        });
        if (noteChanged) steps.push(function () {
            return api('PATCH', ssRoute('note', s.id), { note: note || null })
                .then(function (res) { s.note = note ? ((res && typeof res.note === 'string') ? res.note : note) : ''; });
        });
        let moved = false;
        if (dateChanged) steps.push(function () {
            return api('PATCH', ssRoute('date', s.id), { shoot_date: date })
                .then(function (res) {
                    s.date = (res && res.date) || date;
                    // Now today / upcoming -> it belongs to the Photo Shoot Schedule page
                    shoots = shoots.filter(function (x) { return x !== s; });
                    open.delete(s.id);
                    moved = true;
                });
        });

        if (!steps.length) { closeModal($('#ssEditModal')); return; }

        // Re-sort and re-draw (name / date can change the list) but stay on the same page
        function refresh() {
            const currentPage = page;
            sortShoots();
            applyFilters();
            page = currentPage;
            render();
        }

        const $btn = $(this);
        setBusy($btn, true);
        $('#ssEditForm').find('input, textarea').prop('disabled', true);

        steps.reduce(function (p, step) { return p.then(step); }, Promise.resolve())
            .then(function () {
                setBusy($btn, false);
                $('#ssEditForm').find('input, textarea').prop('disabled', false);
                editShoot = null;
                closeModal($('#ssEditModal'));
                refresh();
                showToast(moved
                    ? '"' + s.name + '" rescheduled to ' + formatDate(s.date) + ' and moved to the Photo Shoot Schedule.'
                    : '"' + s.name + '" updated.');
            })
            .catch(function (xhr) {
                // Fields saved before the error stay saved; keep the box open to try again
                setBusy($btn, false);
                $('#ssEditForm').find('input, textarea').prop('disabled', false);
                refresh();
                showToast(errorMessage(xhr, 'Could not save the changes. Please try again.'), true);
            });
    });

    /* =====================================================
       IMAGE HOVER PREVIEW (desktop)
       ===================================================== */
    const $preview = $('#ssImgPreview');
    if (!window.matchMedia('(hover: none)').matches) {
        $(document).on('mouseenter', '.ss-page .ss-thumb-img', function () {
            $preview.find('img').attr('src', this.src);
            $preview.addClass('is-visible');
            const r = this.getBoundingClientRect(), w = $preview.outerWidth(), h = $preview.outerHeight();
            let left = r.right + 12;
            if (left + w > window.innerWidth - 12) left = r.left - w - 12;
            let top = Math.max(12, Math.min(r.top + r.height / 2 - h / 2, window.innerHeight - h - 12));
            $preview.css({ left: Math.max(12, left) + 'px', top: top + 'px' });
        });
        $(document).on('mouseleave', '.ss-page .ss-thumb-img', function () { $preview.removeClass('is-visible'); });
        $(window).on('scroll', function () { $preview.removeClass('is-visible'); });
    }

    /* =====================================================
       RE-DRAW ONE SHOOT (row + open item list) after a change
       ===================================================== */
    function rerenderShoot(s) {
        hideCard();
        const $row = $('#ssBody tr.ss-row[data-id="' + s.id + '"]');
        if (!$row.length) return;
        $row.next('tr.ss-detail').remove();
        $row.replaceWith(renderShootRow(s));
    }

    /* =====================================================
       INLINE NAME: rename the shoot
       -----------------------------------------------------
       ===================================================== */
    const NAME_MIN = 3, NAME_MAX = 255;

    function closeNameEditors() {
        $('#ssBody td.ss-c-name.is-editing').each(function () {
            const s = findShoot($(this).closest('tr.ss-row').data('id'));
            $(this).removeClass('is-editing').html(s ? renderNameCell(s) : '');
        });
    }

    // true (and flashes) if a name editor has a changed, unsaved value
    function flashUnsavedName() {
        let found = false;
        $('#ssBody td.ss-c-name.is-editing').each(function () {
            const shoot = findShoot($(this).closest('tr.ss-row').data('id'));
            const value = $.trim($(this).find('input').val());
            if (shoot && value !== shoot.name) {
                found = true;
                const $ed = $(this).find('.ss-time-editor').removeClass('is-attention');
                void $ed[0].offsetWidth;
                $ed.addClass('is-attention');
            }
        });
        return found;
    }

    function openNameEditor($cell, s) {
        if (flashUnsavedName()) return;
        closeNameEditors();
        $cell.addClass('is-editing').html(
            '<div class="ss-time-editor ss-name-editor">' +
                '<input type="text" class="ss-input ss-name-input" maxlength="' + NAME_MAX + '" aria-label="Shoot name" autocomplete="off">' +
                '<button type="button" class="ss-time-btn is-save" data-action="name-save" title="Save (Enter)" aria-label="Save name"><i class="fa-solid fa-check"></i></button>' +
                '<button type="button" class="ss-time-btn" data-action="name-cancel" title="Cancel (Esc)" aria-label="Cancel"><i class="fa-solid fa-xmark"></i></button>' +
            '</div>'
        );
        const input = $cell.find('input').val(s.name).trigger('focus')[0];
        input.select();
    }

    function saveName($cell) {
        const s = findShoot($cell.closest('tr.ss-row').data('id'));
        if (!s) return;
        const value = $.trim($cell.find('input').val()).replace(/\s+/g, ' ');

        if (value === s.name) { closeNameEditors(); return; }
        if (value.length < NAME_MIN) {
            showToast('Shoot name must be at least ' + NAME_MIN + ' characters.', true);
            $cell.find('input').trigger('focus');
            return;
        }

        const $save = $cell.find('[data-action="name-save"]');
        const before = s.name;
        $cell.find('input, button').prop('disabled', true);
        $save.html('<i class="fa-solid fa-spinner fa-spin"></i>');

        api('PATCH', ssRoute('name', s.id), { shoot_name: value }).then(function (res) {
            s.name = (res && res.name) || value;
            if (sortKey === 'name') {               // order can change -> re-sort, stay on the page
                const currentPage = page;
                sortShoots();
                applyFilters();
                page = currentPage;
                render();
            } else {
                rerenderShoot(s);
            }
            showToast('"' + before + '" renamed to "' + s.name + '".');
        }).catch(function (xhr) {
            $cell.find('input, button').prop('disabled', false);
            $save.html('<i class="fa-solid fa-check"></i>');
            showToast(errorMessage(xhr, 'Could not rename the shoot. Please try again.'), true);
        });
    }

    $('#ssBody').on('click', '[data-action="name-edit"]', function (e) {
        e.stopPropagation();
        const $cell = $(this).closest('td.ss-c-name');
        const s = findShoot($cell.closest('tr.ss-row').data('id'));
        if (s) openNameEditor($cell, s);
    });
    $('#ssBody').on('click', '[data-action="name-save"]', function () { saveName($(this).closest('td.ss-c-name')); });
    $('#ssBody').on('click', '[data-action="name-cancel"]', closeNameEditors);
    $('#ssBody').on('keydown', '.ss-name-input', function (e) {
        if (e.key === 'Enter')  { e.preventDefault(); saveName($(this).closest('td.ss-c-name')); }
        if (e.key === 'Escape') { e.stopPropagation(); closeNameEditors(); }
    });

    /* =====================================================
       INLINE DATE: change the shoot date
       ===================================================== */
    function closeDateEditors() {
        $('#ssBody td.ss-c-date.is-editing').each(function () {
            const s = findShoot($(this).closest('tr.ss-row').data('id'));
            $(this).removeClass('is-editing').html(s ? renderDateCell(s) : '');
        });
    }

    // true (and flashes) if a date editor has a changed, unsaved value
    function flashUnsavedDate() {
        let found = false;
        $('#ssBody td.ss-c-date.is-editing').each(function () {
            const shoot = findShoot($(this).closest('tr.ss-row').data('id'));
            const value = $(this).find('input').val() || '';
            if (shoot && value && value !== shoot.date) {
                found = true;
                const $ed = $(this).find('.ss-time-editor').removeClass('is-attention');
                void $ed[0].offsetWidth;
                $ed.addClass('is-attention');
            }
        });
        return found;
    }

    // Item of this shoot with the latest ex factory date 
    function latestExFactoryItem(s) {
        let best = null;
        (s.items || []).forEach(function (i) {
            if (i.ex_factory_date && (!best || i.ex_factory_date > best.ex_factory_date)) best = i;
        });
        return best;
    }

    // Earliest date this shoot can move to: today, or the latest ex factory date if that is later
    function earliestShootDate(s) {
        const late = latestExFactoryItem(s);
        return late && late.ex_factory_date > todayISO() ? late.ex_factory_date : todayISO();
    }

    function openDateEditor($cell, s) {
        if (flashUnsavedDate()) return;
        closeDateEditors();
        $cell.addClass('is-editing').html(
            '<div class="ss-time-editor ss-date-editor">' +
                '<input type="date" class="ss-input ss-date-input" aria-label="New shoot date" title="Pick today or a later date to schedule this shoot again" min="' + earliestShootDate(s) + '">' +
                '<button type="button" class="ss-time-btn is-save" data-action="date-save" title="Save (Enter)" aria-label="Save date"><i class="fa-solid fa-check"></i></button>' +
                '<button type="button" class="ss-time-btn" data-action="date-cancel" title="Cancel (Esc)" aria-label="Cancel"><i class="fa-solid fa-xmark"></i></button>' +
            '</div>'
        );
        $cell.find('input').val(s.date || '').trigger('focus');
    }

    function saveDate($cell) {
        const s = findShoot($cell.closest('tr.ss-row').data('id'));
        if (!s) return;
        const value = $cell.find('input').val() || '';

        if (!value || value === s.date) { closeDateEditors(); return; }
        if (value < todayISO()) {
            showToast('Pick today or a later date. The shoot will then move to the Photo Shoot Schedule.', true);
            $cell.find('input').trigger('focus');
            return;
        }

        // Not before the latest ex factory date of the shoot's items
        const late = latestExFactoryItem(s);
        if (late && value < late.ex_factory_date) {
            showToast('"' + late.name + '" is ex factory on ' + formatDate(late.ex_factory_date) + '. The shoot date must be on or after that date.', true);
            $cell.find('input').trigger('focus');
            return;
        }

        const $save = $cell.find('[data-action="date-save"]');
        $cell.find('input, button').prop('disabled', true);
        $save.html('<i class="fa-solid fa-spinner fa-spin"></i>');

        api('PATCH', ssRoute('date', s.id), { shoot_date: value }).then(function (res) {
            s.date = (res && res.date) || value;
            // The shoot is now today / upcoming -> it belongs to the Photo Shoot Schedule page
            shoots = shoots.filter(function (x) { return x !== s; });
            open.delete(s.id);
            const currentPage = page;
            applyFilters();
            page = currentPage;
            render();
            showToast('"' + s.name + '" rescheduled to ' + formatDate(s.date) + ' and moved to the Photo Shoot Schedule.');
        }).catch(function (xhr) {
            $cell.find('input, button').prop('disabled', false);
            $save.html('<i class="fa-solid fa-check"></i>');
            showToast(errorMessage(xhr, 'Could not change the date. Please try again.'), true);
        });
    }

    $('#ssBody').on('click', '[data-action="date-edit"]', function (e) {
        e.stopPropagation();
        const $cell = $(this).closest('td.ss-c-date');
        const s = findShoot($cell.closest('tr.ss-row').data('id'));
        if (s) openDateEditor($cell, s);
    });
    $('#ssBody').on('click', '[data-action="date-save"]', function () { saveDate($(this).closest('td.ss-c-date')); });
    $('#ssBody').on('click', '[data-action="date-cancel"]', closeDateEditors);
    $('#ssBody').on('keydown', '.ss-date-input', function (e) {
        if (e.key === 'Enter')  { e.preventDefault(); saveDate($(this).closest('td.ss-c-date')); }
        if (e.key === 'Escape') { e.stopPropagation(); closeDateEditors(); }
    });

    /* =====================================================
       INLINE TIME: add / edit / remove
       ===================================================== */
    function closeTimeEditors() {
        $('#ssBody td.ss-c-time.is-editing').each(function () {
            const s = findShoot($(this).closest('tr.ss-row').data('id'));
            $(this).removeClass('is-editing').html(s ? renderTimeCell(s) : '');
        });
    }

    // true (and flashes) if a time editor has a changed, unsaved value
    function flashUnsavedTime() {
        let found = false;
        $('#ssBody td.ss-c-time.is-editing').each(function () {
            const shoot = findShoot($(this).closest('tr.ss-row').data('id'));
            const value = $(this).find('input').val() || '';
            if (shoot && value !== (shoot.time || '')) {
                found = true;
                const $ed = $(this).find('.ss-time-editor').removeClass('is-attention');
                void $ed[0].offsetWidth;
                $ed.addClass('is-attention');
            }
        });
        return found;
    }

    function openTimeEditor($cell, s) {
        if (flashUnsavedTime()) return;
        closeTimeEditors();
        $cell.addClass('is-editing').html(
            '<div class="ss-time-editor">' +
                '<input type="time" class="ss-input ss-time-input" step="60" aria-label="Shoot time">' +
                '<button type="button" class="ss-time-btn is-save" data-action="time-save" title="Save (Enter)" aria-label="Save time"><i class="fa-solid fa-check"></i></button>' +
                '<button type="button" class="ss-time-btn" data-action="time-cancel" title="Cancel (Esc)" aria-label="Cancel"><i class="fa-solid fa-xmark"></i></button>' +
            '</div>'
        );
        // Focus only (no auto popup), so Enter saves right away.
        // Type the time, or click the clock icon to open the picker.
        $cell.find('input').val(s.time || '').trigger('focus');
    }

    function saveTime($cell) {
        const s = findShoot($cell.closest('tr.ss-row').data('id'));
        if (!s) return;
        const value  = $cell.find('input').val() || '';
        const before = s.time || '';

        if (!value) {                         // empty picker -> just close, use ✕ to remove a time
            closeTimeEditors();
            return;
        }
        if (value === before) { closeTimeEditors(); return; }

        const $save = $cell.find('[data-action="time-save"]');
        $cell.find('input, button').prop('disabled', true);
        $save.html('<i class="fa-solid fa-spinner fa-spin"></i>');

        api('PATCH', ssRoute('time', s.id), { shoot_time: value }).then(function (res) {
            s.time = res.time || value;
            rerenderShoot(s);
            showToast((before ? 'Time changed to ' : 'Time set to ') + formatTime(s.time) + ' for "' + s.name + '".');
        }).catch(function (xhr) {
            $cell.find('input, button').prop('disabled', false);
            $save.html('<i class="fa-solid fa-check"></i>');
            showToast(errorMessage(xhr, 'Could not save the time. Please try again.'), true);
        });
    }

    $('#ssBody').on('click', '[data-action="time-edit"]', function (e) {
        e.stopPropagation();
        const $cell = $(this).closest('td.ss-c-time');
        const s = findShoot($cell.closest('tr.ss-row').data('id'));
        if (s) openTimeEditor($cell, s);
    });

    $('#ssBody').on('click', '[data-action="time-save"]', function () { saveTime($(this).closest('td.ss-c-time')); });
    $('#ssBody').on('click', '[data-action="time-cancel"]', closeTimeEditors);

    $('#ssBody').on('keydown', '.ss-time-input', function (e) {
        if (e.key === 'Enter')  { e.preventDefault(); saveTime($(this).closest('td.ss-c-time')); }
        if (e.key === 'Escape') { e.stopPropagation(); closeTimeEditors(); }
    });

    $('#ssBody').on('click', '[data-action="time-clear"]', function (e) {
        e.stopPropagation();
        const s = findShoot($(this).closest('tr.ss-row').data('id'));
        if (!s) return;
        askConfirm({
            title: 'Remove shoot time?',
            html: 'The time <b>' + esc(formatTime(s.time)) + '</b> will be removed from <b>' + esc(s.name) + '</b> (' + esc(formatDate(s.date)) + ').',
            confirmText: 'Remove time',
            icon: 'fa-regular fa-clock',
            onConfirm: function () {
                return api('PATCH', ssRoute('time', s.id), { shoot_time: null }).then(function () {
                    s.time = '';
                    rerenderShoot(s);
                    showToast('Time removed from "' + s.name + '".');
                });
            },
        });
    });

    /* =====================================================
       INLINE NOTE: add / edit / delete
       ===================================================== */
    const NOTE_MAX = 500;

    function closeNoteEditors() {
        $('#ssBody td.ss-c-note.is-editing').each(function () {
            const s = findShoot($(this).closest('tr.ss-row').data('id'));
            $(this).removeClass('is-editing').html(s ? renderNoteCell(s) : '');
        });
    }

    // Returns true (and flashes the editor) if a note editor has unsaved text
    function flashUnsavedNote() {
        let found = false;
        $('#ssBody td.ss-c-note.is-editing').each(function () {
            const shoot = findShoot($(this).closest('tr.ss-row').data('id'));
            const typed = $.trim($(this).find('textarea').val());
            if (shoot && typed !== (shoot.note || '')) {
                found = true;
                const $ed = $(this).find('.ss-note-editor').removeClass('is-attention');
                void $ed[0].offsetWidth;            // restart the animation
                $ed.addClass('is-attention');
                $(this).find('textarea').trigger('focus');
            }
        });
        return found;
    }

    function openNoteEditor($cell, s) {
        if (flashUnsavedNote()) return;          // finish (save / cancel) the other note first
        closeNoteEditors();
        $cell.addClass('is-editing').html(
            '<div class="ss-note-editor">' +
                '<textarea class="ss-input ss-note-input" rows="2" maxlength="' + NOTE_MAX + '" placeholder="Write a note for this shoot..."></textarea>' +
                '<div class="ss-note-editor-foot">' +
                    '<span class="ss-note-count"><span data-role="count">0</span>/' + NOTE_MAX + '</span>' +
                    '<span class="ss-note-editor-btns">' +
                        '<button type="button" class="ss-btn ss-btn-outline" data-action="note-cancel">Cancel</button>' +
                        '<button type="button" class="ss-btn ss-btn-primary" data-action="note-save">Save</button>' +
                    '</span>' +
                '</div>' +
                '<div class="ss-note-hint">Enter to save · Shift+Enter for a new line · Esc to cancel</div>' +
            '</div>'
        );
        const $ta = $cell.find('textarea').val(s.note || '');
        autoGrow($ta[0]);
        $cell.find('[data-role="count"]').text($ta.val().length);
        $ta.trigger('focus');
        $ta[0].setSelectionRange($ta.val().length, $ta.val().length);
    }

    function autoGrow(el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight + 2, 160) + 'px';
    }

    function saveNote($cell) {
        const s = findShoot($cell.closest('tr.ss-row').data('id'));
        if (!s) return;
        const text = $.trim($cell.find('textarea').val());
        const before = s.note || '';

        if (text === before) { closeNoteEditors(); return; }

        // Emptying an existing note = removing it -> ask first (Cancel keeps the editor open)
        if (!text) { confirmRemoveNote(s); return; }

        const $save = $cell.find('[data-action="note-save"]');
        $cell.find('textarea, button').prop('disabled', true);
        setBusy($save, true);

        api('PATCH', ssRoute('note', s.id), { note: text }).then(function (res) {
            s.note = (res && typeof res.note === 'string') ? res.note : text;
            $cell.removeClass('is-editing').html(renderNoteCell(s));
            showToast(before ? 'Note updated.' : 'Note added.');
        }).catch(function (xhr) {
            $cell.find('textarea, button').prop('disabled', false);
            setBusy($save, false);
            showToast(errorMessage(xhr, 'Could not save the note. Please try again.'), true);
        });
    }

    function confirmRemoveNote(s) {
        const preview = s.note.length > 120 ? s.note.slice(0, 120) + '…' : s.note;
        askConfirm({
            title: 'Remove note?',
            html: 'This note will be removed from <b>' + esc(s.name) + '</b>:<br><span class="ss-confirm-quote">' + esc(preview) + '</span>',
            confirmText: 'Remove note',
            icon: 'fa-regular fa-note-sticky',
            onConfirm: function () {
                return api('PATCH', ssRoute('note', s.id), { note: null }).then(function () {
                    s.note = '';
                    rerenderShoot(s);
                    showToast('Note removed from "' + s.name + '".');
                });
            },
        });
    }

    $('#ssBody').on('click', '[data-action="note-edit"]', function (e) {
        e.stopPropagation();
        const $cell = $(this).closest('td.ss-c-note');
        const s = findShoot($cell.closest('tr.ss-row').data('id'));
        if (s) openNoteEditor($cell, s);
    });

    $('#ssBody').on('click', '[data-action="note-save"]', function () {
        saveNote($(this).closest('td.ss-c-note'));
    });

    $('#ssBody').on('click', '[data-action="note-cancel"]', closeNoteEditors);

    $('#ssBody').on('input', '.ss-note-input', function () {
        autoGrow(this);
        $(this).closest('.ss-note-editor').find('[data-role="count"]').text(this.value.length);
    });

    $('#ssBody').on('keydown', '.ss-note-input', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); saveNote($(this).closest('td.ss-c-note')); }
        if (e.key === 'Escape') { e.stopPropagation(); closeNoteEditors(); }
    });

    $('#ssBody').on('click', '[data-action="note-delete"]', function (e) {
        e.stopPropagation();
        const s = findShoot($(this).closest('tr.ss-row').data('id'));
        if (!s) return;
        confirmRemoveNote(s);
    });

    /* =====================================================
       MODEL DROPDOWN (per shoot item)
       -----------------------------------------------------
       - Click the model button on an item to open
       - Search, pick a person, or "Not assigned" to clear
       - "Add new model" adds a person to the list and assigns them
       ===================================================== */
    const $pop      = $('#ssModelPop');
    const $popList  = $pop.find('[data-role="list"]');
    const $popInput = $pop.find('[data-role="search"]');
    let popTarget   = null;   // { shoot, item, button }

    function findItem(s, itemId) {
        return s.items.find(function (i) { return String(i.id) === String(itemId); });
    }

    function renderPopList() {
        if (!popTarget) return;
        const q = $popInput.val().trim().toLowerCase();
        const currentId = popTarget.item.model_id ? String(popTarget.item.model_id) : '';
        const list = MODELS.filter(function (m) { return !q || m.name.toLowerCase().indexOf(q) !== -1; })
                           .sort(function (a, b) { return a.name.localeCompare(b.name); });

        let html = '';
        if (currentId && !q) {
            html += '<button type="button" class="ss-pop-option is-clear" data-model-id=""><span class="ss-avatar ss-avatar-empty"><i class="fa-solid fa-user-slash"></i></span><span>Not assigned</span></button>';
        }
        html += list.map(function (m) {
            const isCur = String(m.id) === currentId;
            return '<button type="button" class="ss-pop-option' + (isCur ? ' is-current' : '') + '" role="option" aria-selected="' + isCur + '" data-model-id="' + esc(m.id) + '">' +
                       avatar(m.name, m.id) + '<span class="ss-pop-name">' + esc(m.name) + '</span>' +
                       (isCur ? '<i class="fa-solid fa-check ss-pop-check"></i>' : '') +
                   '</button>';
        }).join('');

        if (!list.length) {
            html += '<div class="ss-pop-empty">' + (MODELS.length ? 'No model found' + (q ? ' for “' + esc(q) + '”' : '') + '.' : 'No models yet. Add models on the Fashion Models page.') + '</div>';
        }
        $popList.html(html);
        $popList.find('.ss-pop-option').first().addClass('is-active');
    }

    function positionPop(btn) {
        const r = btn.getBoundingClientRect();
        const w = Math.min(280, window.innerWidth - 24);
        $pop.css({ width: w + 'px' });
        const h = $pop.outerHeight();

        let left = Math.min(r.left, window.innerWidth - w - 12);
        let top  = r.bottom + 6;
        if (top + h > window.innerHeight - 12) top = Math.max(12, r.top - h - 6);   // open upwards if no room
        $pop.css({ left: Math.max(12, left) + 'px', top: top + 'px' });
    }

    function openPop(btn) {
        const s = findShoot($(btn).closest('tr.ss-detail').data('detail-for'));
        if (!s) return;
        const item = findItem(s, $(btn).data('item'));
        if (!item) return;

        popTarget = { shoot: s, item: item, button: btn };
        $popInput.val('');
        renderPopList();
        $pop.addClass('is-open').attr('aria-hidden', 'false');
        $(btn).addClass('is-open').attr('aria-expanded', 'true');
        positionPop(btn);
        $popInput.trigger('focus');   // focus right away so typing goes into the search box
    }

    function closePop() {
        if (!popTarget) return;
        $(popTarget.button).removeClass('is-open').attr('aria-expanded', 'false');
        $pop.removeClass('is-open').attr('aria-hidden', 'true');
        popTarget = null;
    }

    // modelId: fashion_models.id, or '' / null to clear
    function assignModel(modelId) {
        if (!popTarget) return;
        const s = popTarget.shoot, item = popTarget.item;
        const $btn = $(popTarget.button);
        const newId = modelId ? parseInt(modelId, 10) : null;
        closePop();
        if (newId === (item.model_id || null)) return;

        $btn.prop('disabled', true).addClass('is-saving');

        api('PATCH', ssRoute('itemModel', s.id, item.id), { fashion_model_id: newId }).then(function () {
            const model = MODELS.find(function (m) { return m.id === newId; });
            item.model_id = newId;
            item.model    = model ? model.name : null;
            rerenderShoot(s);
            if (model) showToast(model.name + ' assigned to "' + item.name + '".');
            else       showToast('Model removed from "' + item.name + '".');
        }).catch(function (xhr) {
            $btn.prop('disabled', false).removeClass('is-saving');
            showToast(errorMessage(xhr, 'Could not save the model. Please try again.'), true);
        });
    }

    $('#ssBody').on('click', '[data-action="pick-model"]', function (e) {
        e.stopPropagation();
        if (popTarget && popTarget.button === this) { closePop(); return; }
        closePop();
        openPop(this);
    });

    $popList.on('click', '.ss-pop-option', function () {
        assignModel($(this).attr('data-model-id'));
    });

    $popInput.on('input', renderPopList);

    // Keyboard: ↑ ↓ to move, Enter to pick, Esc to close
    $popInput.on('keydown', function (e) {
        const $opts = $popList.find('.ss-pop-option');
        let idx = $opts.index($opts.filter('.is-active'));
        if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
            e.preventDefault();
            idx = e.key === 'ArrowDown' ? Math.min(idx + 1, $opts.length - 1) : Math.max(idx - 1, 0);
            $opts.removeClass('is-active').eq(idx).addClass('is-active')[0].scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (idx >= 0) assignModel($opts.eq(idx).attr('data-model-id'));
        } else if (e.key === 'Escape') {
            e.stopPropagation();
            const btn = popTarget && popTarget.button;
            closePop();
            if (btn) btn.focus();
        }
    });

    // Close the dropdown / note editor when clicking somewhere else
    $(document).on('mousedown', function (e) {
        if (popTarget && !$(e.target).closest('#ssModelPop, [data-action="pick-model"]').length) closePop();
        // Clicking outside the note editor closes it ONLY if nothing was typed,
        // so a half-written note is never lost by a stray click
        if ($(e.target).closest('.ss-modal').length) return;   // confirm box is open -> leave editors alone
        if (!$(e.target).closest('td.ss-c-note, #ssModelPop, [data-action="pick-model"]').length) {
            if (!flashUnsavedNote()) closeNoteEditors();
        }
        // Same for the time editor
        if (!$(e.target).closest('td.ss-c-name').length) {
            if (!flashUnsavedName()) closeNameEditors();
        }
        if (!$(e.target).closest('td.ss-c-date').length) {
            if (!flashUnsavedDate()) closeDateEditors();
        }
        if (!$(e.target).closest('td.ss-c-time').length) {
            if (!flashUnsavedTime()) closeTimeEditors();
        }
    });

    $(window).on('resize', closePop);
    $('.ss-table-wrap').on('scroll', closePop);
    $(window).on('scroll', function () { if (popTarget) positionPop(popTarget.button); });

    /* =====================================================
       MODEL HOVER CARD
       ===================================================== */
    const $card       = $('#ssModelCard');
    const NO_HOVER    = window.matchMedia('(hover: none)').matches;
    let cardTimer     = null;
    let cardHideTimer = null;
    let cardButton    = null;

    // "2026-11-26" -> "Nov 26"  (year added only when it is not this year)
    function shortDate(isoDate) {
        const p = isoDate.split('-');
        const d = new Date(+p[0], +p[1] - 1, +p[2]);
        const opts = { month: 'short', day: '2-digit' };
        if (d.getFullYear() !== new Date().getFullYear()) opts.year = 'numeric';
        return d.toLocaleDateString('en-US', opts);
    }

    function modelById(id) {
        return MODELS.find(function (m) { return String(m.id) === String(id); }) || null;
    }

    // Upcoming shoots of a model: shoots on this page are counted live (changes made here show at once),
    // other shoots come from the server list.
    function modelBookings(modelId) {
        const m = modelById(modelId);
        const today = todayISO();
        const onPage = {};
        shoots.forEach(function (s) { onPage[s.id] = true; });

        const list = ((m && m.upcoming) || []).filter(function (u) { return !onPage[u.id]; });
        shoots.forEach(function (s) {
            const n = s.items.filter(function (i) { return String(i.model_id) === String(modelId); }).length;
            if (n && s.date && s.date >= today) list.push({ id: s.id, name: s.name, date: s.date, time: s.time, items: n });
        });

        return list.sort(function (a, b) {
            return (a.date + ' ' + (a.time || '99:99')).localeCompare(b.date + ' ' + (b.time || '99:99'));
        });
    }

    function cardHtml(m, s, item) {
        const genderAge = [m.gender, m.age != null ? m.age + ' yrs' : '', m.us_size ? 'US ' + m.us_size : '']
            .filter(Boolean).join(' · ');

        const measure = [['Height', m.height], ['Chest', m.chest], ['Waist', m.waist], ['Hips', m.hips]].map(function (x) {
            return '<div class="' + (x[1] ? '' : 'is-na') + '"><b>' + (x[1] ? esc(x[1]) : 'N/A') + '</b><span>' + x[0] + '</span></div>';
        }).join('');

        // THIS SHOOT: item count (+ gender warning)
        const inThis = s.items.filter(function (i) { return String(i.model_id) === String(m.id); }).length;
        let thisShoot = '<div class="ss-mc-label">This shoot</div>' +
            '<div class="ss-mc-line"><i class="fa-solid fa-camera"></i><span><b>' + plural(inThis, 'item') + '</b></span></div>';

        // Item gender (Male / Female) does not match the model gender
        const itemG  = item.gender;
        const modelG = (m.gender || '').toLowerCase();
        if ((itemG === 'male' || itemG === 'female') && modelG && modelG !== itemG) {
            thisShoot += '<div class="ss-mc-line ss-mc-warn"><i class="fa-solid fa-venus-mars"></i><span>This item is for ' +
                (itemG === 'male' ? 'Male' : 'Female') + '</span></div>';
        }

        // OTHER UPCOMING SHOOTS: date order, max 3 rows, same day = orange row
        const others = modelBookings(m.id).filter(function (b) { return String(b.id) !== String(s.id); });
        const MAX_ROWS = 3;
        let otherShoots = '';
        if (others.length) {
            otherShoots = '<div class="ss-mc-label">Other upcoming shoots (' + others.length + ')</div>' +
                '<ul class="ss-mc-shoots">' + others.slice(0, MAX_ROWS).map(function (b) {
                    const same = b.date === s.date;
                    return '<li class="ss-mc-shoot' + (same ? ' is-same' : '') + '">' +
                               '<span class="ss-mc-shoot-date">' + esc(shortDate(b.date)) + '</span>' +
                               '<span class="ss-mc-shoot-name" title="' + esc(b.name) + '">' + esc(b.name) + '</span>' +
                               (same ? '<span class="ss-mc-same">Same day</span>' : '') +
                               '<span class="ss-mc-shoot-qty">' + plural(b.items, 'item') + '</span>' +
                           '</li>';
                }).join('') + '</ul>' +
                (others.length > MAX_ROWS && m.profile
                    ? '<a class="ss-mc-more" href="' + esc(m.profile) + '">+' + (others.length - MAX_ROWS) + ' more</a>'
                    : '');
        }

        const phone = m.phone
            ? '<a href="tel:' + esc(m.phone.replace(/[^\d+]/g, '')) + '">' + esc(m.phone) + '</a>'
            : '<span class="ss-mc-na">Not available</span>';
        const email = m.email
            ? '<a href="mailto:' + esc(m.email) + '">' + esc(m.email) + '</a>'
            : '<span class="ss-mc-na">Not available</span>';

        return '<div class="ss-mc-head">' + avatar(m.name, m.id) +
                   '<div class="ss-mc-title">' +
                       '<div class="ss-mc-name"><span title="' + esc(m.name) + '">' + esc(m.name) + '</span>' + (m.code ? '<small>' + esc(m.code) + '</small>' : '') + '</div>' +
                       (genderAge ? '<div class="ss-mc-sub">' + esc(genderAge) + '</div>' : '') +
                       (m.model_type ? '<span class="ss-mc-type">' + esc(m.model_type) + '</span>' : '') +
                   '</div>' +
               '</div>' +
               '<div class="ss-mc-section"><div class="ss-mc-measure">' + measure + '</div></div>' +
               '<div class="ss-mc-section">' + thisShoot + '</div>' +
               (otherShoots ? '<div class="ss-mc-section">' + otherShoots + '</div>' : '') +
               '<div class="ss-mc-section">' +
                   '<div class="ss-mc-line"><i class="fa-solid fa-phone"></i>' + phone + '</div>' +
                   '<div class="ss-mc-line"><i class="fa-regular fa-envelope"></i>' + email + '</div>' +
               '</div>' +
               (m.profile ? '<div class="ss-mc-foot"><a class="ss-mc-profile" href="' + esc(m.profile) + '">View profile <i class="fa-solid fa-arrow-right"></i></a></div>' : '');
    }

    function positionCard(btn) {
        const r = btn.getBoundingClientRect();
        const w = Math.min(300, window.innerWidth - 24);
        $card.css({ width: w + 'px' });
        const h = $card.outerHeight();

        let top = r.top - h - 8;                                   // above the button
        if (top < 12) top = Math.min(r.bottom + 8, window.innerHeight - h - 12);   // no room -> below
        const left = Math.min(Math.max(12, r.left + r.width / 2 - w / 2), window.innerWidth - w - 12);
        $card.css({ left: left + 'px', top: Math.max(12, top) + 'px' });
    }

    function showCard(btn) {
        if (popTarget) return;   // the dropdown is open -> no card
        const s = findShoot($(btn).closest('tr.ss-detail').data('detail-for'));
        const item = s && findItem(s, $(btn).data('item'));
        const m = item && item.model_id ? modelById(item.model_id) : null;
        if (!m) return;          // "Assign model" button -> no card

        cardButton = btn;
        $card.html(cardHtml(m, s, item)).addClass('is-open').attr('aria-hidden', 'false');
        positionCard(btn);
    }

    function hideCard() {
        clearTimeout(cardTimer);
        clearTimeout(cardHideTimer);
        if (!cardButton) return;
        cardButton = null;
        $card.removeClass('is-open').attr('aria-hidden', 'true');
    }

    if (!NO_HOVER) {
        // Desktop: hover
        $('#ssBody').on('mouseenter', '[data-action="pick-model"]:not(.is-empty)', function () {
            const btn = this;
            clearTimeout(cardHideTimer);
            if (cardButton === btn) return;
            clearTimeout(cardTimer);
            cardTimer = setTimeout(function () { hideCard(); showCard(btn); }, 300);
        });
        $('#ssBody').on('mouseleave', '[data-action="pick-model"]', function () {
            clearTimeout(cardTimer);
            cardHideTimer = setTimeout(hideCard, 180);   // time to move the mouse onto the card
        });
        $card.on('mouseenter', function () { clearTimeout(cardHideTimer); });
        $card.on('mouseleave', function () { cardHideTimer = setTimeout(hideCard, 180); });
    } else {
        // Phone / tablet: tap the photo = card, tap the name = dropdown.
        // This runs before the dropdown click (the photo is inside the button).
        $('#ssBody').on('click', '[data-action="pick-model"]:not(.is-empty) .ss-avatar', function (e) {
            e.stopPropagation();
            e.preventDefault();
            const btn = $(this).closest('[data-action="pick-model"]')[0];
            if (cardButton === btn) { hideCard(); return; }
            closePop();
            hideCard();
            showCard(btn);
        });
        $(document).on('touchstart mousedown', function (e) {
            if (cardButton && !$(e.target).closest('#ssModelCard, [data-action="pick-model"] .ss-avatar, [data-action="pick-model"] .ss-model-eye').length) hideCard();
        });
    }

    // Phones: the eye inside the model button opens the model card (the rest of the button opens the dropdown).
    // A deeper element, so it runs before the dropdown click.
    $('#ssBody').on('click', '[data-action="pick-model"] .ss-model-eye', function (e) {
        e.stopPropagation();
        e.preventDefault();
        const btn = $(this).closest('[data-action="pick-model"]')[0];
        if (cardButton === btn) { hideCard(); return; }
        closePop();
        hideCard();
        showCard(btn);
    });
    $(document).on('touchstart mousedown', function (e) {
        if (cardButton && isPhone() &&
            !$(e.target).closest('#ssModelCard, [data-action="pick-model"] .ss-avatar, [data-action="pick-model"] .ss-model-eye').length) {
            hideCard();
        }
    });

    // Opening the dropdown closes the card
    $('#ssBody').on('click', '[data-action="pick-model"]', hideCard);
    $(window).on('resize', hideCard);
    $(window).on('scroll', function () { if (cardButton) positionCard(cardButton); });
    $('.ss-table-wrap').on('scroll', hideCard);
    $(document).on('keydown', function (e) { if (e.key === 'Escape') hideCard(); });

    /* ---------------- INIT ---------------- */
    sortShoots();
    applyFilters();
});
</script>
@endpush