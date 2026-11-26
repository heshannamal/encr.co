@extends('layouts.app', ['activePage' => 'studio_order', 'titlePage' => __('Studio Order')])

@section('content')


<style>
    /* ==========================================================
       STUDIO ORDER PAGE  (all classes start with "so-")
       ========================================================== */
    .so-page {
        --so-primary: #16a394;
        --so-primary-dark: #12897c;
        --so-link: #1d5fd0;
        --so-border: #e6e8eb;
        --so-head: #7d7d7d;
        --so-text: #1f2328;
        --so-muted: #6b7280;

        /* Change these two values if you need more / less space */
        --so-top-gap: 0px;        /* space between navbar and title */
        --so-bottom-gap: 110px;   /* space for the fixed world-clock bar */

        font-family: 'Open Sans', sans-serif;
        color: var(--so-text);
        padding-top: var(--so-top-gap) !important;
        padding-bottom: var(--so-bottom-gap) !important;
        margin-top: 0 !important;
    }

    .so-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.2;
        margin: 0 0 1rem;
    }

    .so-card {
        background: #fff;
        border: 1px solid var(--so-border);
        border-radius: 6px;
    }

    /* ---------- Filters ---------- */
    .so-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }

    .so-search {
        position: relative;
        flex: 1 1 200px;
        min-width: 180px;
        max-width: 300px;
    }

    .so-search i {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa0a6;
        font-size: 12px;
        pointer-events: none;
    }

    .so-search .so-input { padding-left: 30px; }

    .so-filter-group {
        display: flex;
        flex-wrap: nowrap;
        align-items: flex-end;
        gap: 8px;
        margin-left: auto;
        flex: 0 1 auto;
        min-width: 0;
    }

    .so-field { display: flex; flex-direction: column; min-width: 0; }

    /* Rows per page (10 / 20 / 50 / 100) */
    .so-field-perpage { flex: 0 0 76px; width: 76px; }
    .so-field-perpage .so-input { cursor: pointer; }

    .so-field label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #4b5563;
        margin-bottom: 4px;
        white-space: nowrap;
    }

    .so-input {
        width: 100%;
        height: 34px;
        padding: 0 10px;
        font-size: 12.5px;
        color: var(--so-text);
        background: #fff;
        border: 1px solid #d6d9de;
        border-radius: 4px;
        outline: none;
        text-overflow: ellipsis;
        transition: border-color .15s, box-shadow .15s;
    }

    .so-input:focus {
        border-color: var(--so-primary);
        box-shadow: 0 0 0 3px rgba(22, 163, 148, .15);
    }

    .so-field-shoot { flex: 0 1 140px; width: 140px; }
    .so-field-org   { flex: 0 1 260px; width: 260px; }
    .so-field-style { flex: 0 1 150px; width: 150px; }

    /* Empty select looks like a placeholder (grey), options stay dark */
    .so-input.is-placeholder { color: #9aa0a6; }
    .so-input.is-placeholder option { color: #1f2328; }
    .so-input::placeholder { color: #9aa0a6; }

    .so-actions { display: flex; gap: 8px; flex-shrink: 0; }

    .so-btn {
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 0 12px;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 4px;
        border: 1px solid transparent;
        cursor: pointer;
        white-space: nowrap;
        transition: background .15s, border-color .15s, color .15s;
    }

    .so-btn-primary { background: var(--so-primary); color: #fff; }
    .so-btn-primary:hover { background: var(--so-primary-dark); color: #fff; }

    .so-btn-outline { background: #fff; border-color: #cfd3d8; color: #374151; }
    .so-btn-outline:hover { background: #f5f6f7; }

    .so-btn-icon { width: 34px; padding: 0; }

    .so-btn-soft { background: #e9e8f5; color: #6b6a8a; }
    .so-btn-soft:hover:not(:disabled) { background: #dcdaf0; }

    .so-btn:disabled { opacity: .6; cursor: not-allowed; }

    /* ---------- Selection bar (hidden until something is selected) ---------- */
    .so-selection-bar {
        display: none;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 12px 16px;
        margin-bottom: 14px;
        background: #eefaf4;
        border: 1px solid #d3efe2;
        border-radius: 6px;
    }

    .so-selection-bar.is-visible {
        display: flex;
        animation: soSlideIn .2s ease-out;
    }

    @keyframes soSlideIn {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .so-sel-title { font-size: 14px; font-weight: 700; color: #1a1a1a; line-height: 1.3; }
    .so-sel-sub   { font-size: 11px; color: var(--so-muted); margin-top: 2px; }

    .so-sel-actions { display: flex; flex-wrap: wrap; gap: 8px; }

    /* ---------- Mobile toolbar (only on phones) ---------- */
    .so-mobile-toolbar { display: none; }

    /* ---------- Phone-only / desktop-only helpers ----------
       .so-m-only  = shown only on phones (hidden here, shown in the phone media query)
       .so-d-only  = hidden only on phones */
    .so-page .so-m-only { display: none; }
    .so-field .so-m-label { display: none; }          /* field labels: phones only */
    .so-table td.so-col-toggle { display: none; }     /* card open/close arrow: phones only */

    /* ---------- Table ---------- */
    .so-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    .so-table {
        width: 100%;
        min-width: 1180px;
        border-collapse: collapse;
        margin: 0;
    }

    .so-table thead th {
        background: var(--so-head);
        color: #fff;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: 12px 10px;
        white-space: nowrap;
        border: 0;
    }

    .so-table thead th:first-child { border-top-left-radius: 6px; padding-left: 16px; }
    .so-table thead th:last-child  { border-top-right-radius: 6px; }

    .so-table th.so-sortable { cursor: pointer; user-select: none; }
    .so-table th.so-sortable i { margin-left: 4px; font-size: 10px; opacity: .75; }
    .so-table th.so-sortable.is-active i { opacity: 1; }

    .so-table tbody td {
        padding: 10px;
        font-size: 12.5px;
        vertical-align: middle;
        border-top: 1px solid var(--so-border);
        white-space: nowrap;
    }

    .so-table tbody td:first-child { padding-left: 16px; }
    .so-table tbody tr:hover { background: #fafbfc; }
    .so-table tbody tr.is-selected,
    .so-table tbody tr.is-selected:hover { background: #f3fbf8; }
    .so-check {
        width: 15px;
        height: 15px;
        cursor: pointer;
        accent-color: var(--so-primary);
        vertical-align: middle;
    }

    .so-thumb {
        width: 46px;
        height: 46px;
        border: 1px solid var(--so-border);
        border-radius: 6px;
        background: #fff;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .so-thumb img { width: 100%; height: 100%; object-fit: contain; display: block; }

    .so-thumb-empty { background: #eceef1; border-color: #eceef1; }

    .so-thumb img { cursor: zoom-in; }
    .so-thumb.has-image:hover { border-color: var(--so-primary); }

    /* ---------- Large image preview (hover on desktop, tap on mobile) ---------- */
    .so-img-preview {
        position: fixed;
        z-index: 10050;
        display: none;
        width: 320px;
        height: 320px;
        padding: 10px;
        background: #fff;
        border: 1px solid var(--so-border, #e6e8eb);
        border-radius: 10px;
        box-shadow: 0 12px 32px rgba(15, 23, 42, .18);
        pointer-events: none;           /* never blocks the mouse */
    }

    .so-img-preview.is-visible {
        display: block;
        animation: soPreviewIn .15s ease-out;
    }

    @keyframes soPreviewIn {
        from { opacity: 0; transform: scale(.96); }
        to   { opacity: 1; transform: scale(1); }
    }

    .so-img-preview img {
        width: 100%;
        height: calc(100% - 26px);
        object-fit: contain;
        display: block;
    }

    .so-img-preview-caption {
        height: 26px;
        padding-top: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #1f2328;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Mobile: centered popup with a dark background, tap anywhere to close */
    .so-img-backdrop {
        position: fixed;
        inset: 0;
        z-index: 10049;
        display: none;
        background: rgba(15, 23, 42, .55);
    }

    .so-img-backdrop.is-visible { display: block; }

    .so-img-preview.is-modal {
        top: 50% !important;
        left: 50% !important;
        width: min(90vw, 420px);
        height: min(90vw, 420px);
        transform: translate(-50%, -50%);
        animation: none;
        pointer-events: auto;
    }

    .so-name { font-weight: 700; line-height: 1.3; white-space: normal; }

    /* Kit / shoot labels under the item name */
    .so-tags { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 5px; }
    .so-tags:empty { display: none; }

    .so-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        max-width: 220px;
        padding: 2px 8px;
        font-size: 10.5px;
        font-weight: 600;
        line-height: 1.5;
        border-radius: 999px;
        white-space: nowrap;
    }

    .so-tag i { font-size: 9.5px; flex-shrink: 0; }
    .so-tag span { overflow: hidden; text-overflow: ellipsis; }

    .so-tag-kit   { color: #5b42b0; background: #f0ecfb; }
    .so-tag-shoot { color: #13806f; background: #e3f6f3; }

    .so-page a.so-order-link,
    .so-page a.so-order-link:visited { color: var(--so-link) !important; font-weight: 700; text-decoration: none; }
    .so-page a.so-order-link:hover { color: #164aa6 !important; text-decoration: underline; }

    .so-org {
        display: block;
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Chat button: icon + count */
    .so-page a.so-chat-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-width: 34px;
        height: 28px;
        padding: 0 10px;
        font-size: 12px;
        color: var(--so-link) !important;
        background: #fff;
        border: 1px solid #cfd8e3;
        border-radius: 999px;
        text-decoration: none;
        transition: background .15s, border-color .15s;
    }

    .so-page a.so-chat-btn:hover { background: #f2f6fd; border-color: #a9bfe6; }

    .so-chat-label { display: none; }

    .so-chat-count {
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        font-size: 10px;
        font-weight: 700;
        color: #fff;
        background: var(--so-link);
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .so-empty {
        padding: 48px 16px;
        text-align: center;
        color: var(--so-muted);
        font-size: 13px;
    }

    .so-empty i { display: block; font-size: 28px; margin-bottom: 10px; color: #c3c7cc; }

    /* ---------- Footer / pagination ---------- */
    .so-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 12px 16px;
        border-top: 1px solid var(--so-border);
    }

    .so-info { font-size: 12px; color: var(--so-muted); }

    .so-pagination { display: flex; flex-wrap: wrap; gap: 4px; }

    .so-page-btn {
        min-width: 32px;
        height: 30px;
        padding: 0 9px;
        font-size: 12px;
        color: #4b5563;
        background: #fff;
        border: 1px solid #dcdfe3;
        border-radius: 4px;
        cursor: pointer;
    }

    .so-page-btn:hover:not(:disabled):not(.active) { background: #f5f6f7; }
    .so-page-btn.active { background: var(--so-primary); border-color: var(--so-primary); color: #fff; font-weight: 700; }
    .so-page-btn:disabled { color: #c0c4ca; cursor: not-allowed; }

    .so-ellipsis { min-width: 24px; height: 30px; display: inline-flex; align-items: center; justify-content: center; color: #9aa0a6; }

    .so-hidden { display: none !important; }

    /* ---------- Tech pack button ---------- */
    .so-tp-btn {
        display: inline-flex; align-items: center; gap: 7px; height: 28px; padding: 0 6px 0 11px;
        font-size: 12px; font-weight: 600; color: #374151; background: #fff;
        border: 1px solid #d6d9de; border-radius: 999px; cursor: pointer;
        transition: border-color .15s, background .15s, color .15s;
    }
    .so-tp-btn:hover { color: var(--so-primary); border-color: #9fd9cf; background: #f2fbf9; }
    .so-tp-btn i { font-size: 12px; }
    .so-tp-count {
        min-width: 18px; height: 18px; padding: 0 5px; font-size: 10px; font-weight: 700;
        color: #fff; background: var(--so-primary); border-radius: 999px;
        display: inline-flex; align-items: center; justify-content: center;
    }

    /* ---------- Tech pack viewer modal ---------- */
    .so-modal-dialog.so-modal-lg { max-width: 900px; }

    .so-tp-body { padding: 0 20px 16px; }

    .so-tp-stage {
        position: relative; height: min(62vh, 560px); display: flex; align-items: center; justify-content: center;
        background: #f4f5f7; border: 1px solid var(--so-border); border-radius: 10px; overflow: hidden;
        user-select: none;
    }
    .so-tp-stage img {
        max-width: 100%; max-height: 100%; object-fit: contain; display: block;
        transition: opacity .2s; cursor: zoom-in;
    }
    .so-tp-stage.is-loading img { opacity: 0; }

    .so-tp-spinner, .so-tp-error {
        position: absolute; inset: 0; display: none; align-items: center; justify-content: center;
        flex-direction: column; gap: 8px; font-size: 12.5px; color: var(--so-muted);
    }
    .so-tp-spinner i { font-size: 22px; color: var(--so-primary); }
    .so-tp-error i { font-size: 26px; color: #c3c7cc; }
    .so-tp-stage.is-loading .so-tp-spinner { display: flex; }
    .so-tp-stage.is-error .so-tp-error { display: flex; }
    .so-tp-stage.is-error img { display: none; }

    .so-tp-nav {
        position: absolute; top: 50%; transform: translateY(-50%); width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center; border: 0; border-radius: 50%;
        background: rgba(255, 255, 255, .92); color: #1f2328; font-size: 14px; cursor: pointer;
        box-shadow: 0 4px 14px rgba(15, 23, 42, .15); transition: background .15s, transform .15s;
    }
    .so-tp-nav:hover { background: #fff; transform: translateY(-50%) scale(1.06); }
    .so-tp-nav:disabled { opacity: .35; cursor: default; transform: translateY(-50%); }
    .so-tp-prev { left: 12px; }
    .so-tp-next { right: 12px; }

    .so-tp-counter {
        position: absolute; top: 12px; left: 12px; padding: 3px 10px; font-size: 11.5px; font-weight: 700;
        color: #fff; background: rgba(31, 41, 55, .75); border-radius: 999px;
    }

    .so-tp-caption {
        display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-top: 10px;
        font-size: 12.5px;
    }
    .so-tp-name { font-weight: 600; color: #1f2328; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .so-tp-links { display: inline-flex; gap: 6px; flex-shrink: 0; }
    .so-tp-links a {
        display: inline-flex; align-items: center; gap: 6px; height: 30px; padding: 0 10px;
        font-size: 12px; font-weight: 600; color: #374151 !important; background: #fff;
        border: 1px solid #d6d9de; border-radius: 6px; text-decoration: none !important;
    }
    .so-tp-links a:hover { background: #f5f6f7; }

    .so-tp-thumbs { display: flex; gap: 8px; margin-top: 12px; overflow-x: auto; padding-bottom: 4px; }
    .so-tp-thumb {
        flex-shrink: 0; width: 64px; height: 64px; padding: 0; overflow: hidden; cursor: pointer;
        background: #f4f5f7; border: 2px solid transparent; border-radius: 8px; opacity: .65;
        transition: opacity .15s, border-color .15s;
    }
    .so-tp-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .so-tp-thumb:hover { opacity: 1; }
    .so-tp-thumb.is-active { opacity: 1; border-color: var(--so-primary); }

    /* ==========================================================
       MODALS (Kit + Shoot) — same pattern for both
       ========================================================== */
    body.so-modal-open { overflow: hidden; }

    .so-page *,
    .so-page *::before,
    .so-page *::after { box-sizing: border-box; }

    .so-modal {
        position: fixed;
        inset: 0;
        z-index: 10060;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .so-modal.is-open { display: flex; }

    .so-modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, .5);
        animation: soFade .15s ease-out;
    }

    @keyframes soFade { from { opacity: 0; } to { opacity: 1; } }

    @keyframes soModalIn {
        from { opacity: 0; transform: translateY(12px) scale(.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .so-modal-dialog {
        position: relative;
        width: 100%;
        max-width: 560px;
        max-height: calc(100vh - 40px);
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, .25);
        overflow: hidden;
        animation: soModalIn .18s ease-out;
    }

    .so-modal-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 18px 20px 14px;
    }

    .so-modal-icon {
        flex-shrink: 0;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: var(--so-primary);
        background: #e3f6f3;
    }

    .so-modal-heading { flex: 1; min-width: 0; }

    .so-modal-title {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.3;
    }

    .so-modal-sub { margin: 2px 0 0; font-size: 12px; color: var(--so-muted); }

    .so-modal-close {
        flex-shrink: 0;
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 6px;
        background: transparent;
        color: #6b7280;
        font-size: 16px;
        cursor: pointer;
    }

    .so-modal-close:hover { background: #f1f2f4; color: #1f2328; }

    /* Selected items preview (chips) */
    .so-modal-selected {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding: 0 20px 14px;
    }

    .so-chip {
        max-width: 200px;
        padding: 3px 10px;
        font-size: 11.5px;
        color: #374151;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .so-chip b { color: var(--so-link); font-weight: 700; }
    .so-chip-more { background: #e3f6f3; border-color: #cdeee8; color: #13806f; font-weight: 600; }

    /* Tabs */
    .so-tabs {
        display: flex;
        gap: 4px;
        padding: 0 20px;
        border-bottom: 1px solid var(--so-border);
    }

    .so-tab {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 12px;
        font-size: 13px;
        font-weight: 600;
        color: var(--so-muted);
        background: transparent;
        border: 0;
        cursor: pointer;
    }

    .so-tab:hover { color: #1f2328; }
    .so-tab:focus { outline: none; }
    .so-tab:focus-visible { box-shadow: inset 0 0 0 2px rgba(22, 163, 148, .35); border-radius: 4px; }

    .so-tab.is-active { color: var(--so-primary); }

    .so-tab.is-active::after {
        content: '';
        position: absolute;
        left: 8px;
        right: 8px;
        bottom: -1px;
        height: 2px;
        background: var(--so-primary);
        border-radius: 2px;
    }

    .so-tab-count {
        min-width: 20px;
        height: 18px;
        padding: 0 6px;
        font-size: 10.5px;
        font-weight: 700;
        color: #4b5563;
        background: #eef0f2;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .so-tab.is-active .so-tab-count { color: #fff; background: var(--so-primary); }

    .so-modal-body {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 18px 20px;
    }

    .so-tab-panel { display: none; }
    .so-tab-panel.is-active { display: block; }

    /* Form */
    .so-form-row { margin-bottom: 14px; }
    .so-form-row:last-child { margin-bottom: 0; }

    .so-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    .so-form-label {
        display: block;
        margin-bottom: 6px;
        font-size: 12px;
        font-weight: 700;
        color: #374151;
    }

    .so-form-label .so-req { color: #d64550; }

    .so-modal .so-input { height: 40px; font-size: 13.5px; }

    .so-input-icon { position: relative; }
    .so-input-icon > i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa0a6;
        font-size: 13px;
        pointer-events: none;
    }
    .so-input-icon > .so-input { padding-left: 34px; }

    .so-input.is-invalid { border-color: #d64550; }
    .so-input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(214, 69, 80, .15); }

    .so-form-hint  { margin-top: 5px; font-size: 11.5px; color: var(--so-muted); }
    .so-form-error { margin-top: 5px; font-size: 11.5px; color: #d64550; display: none; }
    .so-form-error.is-visible { display: block; }

    /* Existing list */
    .so-list-search { margin-bottom: 12px; }

    .so-pick-list { display: flex; flex-direction: column; gap: 8px; }

    .so-pick {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 12px;
        border: 1px solid var(--so-border);
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        transition: border-color .15s, background .15s;
    }

    .so-pick:hover { border-color: #c9d6d3; background: #fbfcfc; }
    .so-pick.is-selected { border-color: var(--so-primary); background: #f3fbf8; }

    .so-pick input[type="radio"] {
        flex-shrink: 0;
        width: 16px;
        height: 16px;
        margin: 0;
        accent-color: var(--so-primary);
        cursor: pointer;
    }

    .so-pick-main { flex: 1; min-width: 0; }

    .so-pick-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #1f2328;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .so-pick-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 4px 12px;
        margin-top: 3px;
        font-size: 11.5px;
        color: var(--so-muted);
    }

    .so-pick-meta i { margin-right: 4px; color: #a3a8ae; }

    .so-badge-soft {
        display: inline-block;
        padding: 1px 8px;
        font-size: 10.5px;
        font-weight: 700;
        border-radius: 999px;
    }

    /* Shoot blocked by an ex factory date (Scheduled Shoots tab) */
    .so-pick.is-blocked { cursor: not-allowed; background: #fafafa; }
    .so-pick.is-blocked:hover { border-color: var(--so-border); background: #fafafa; }
    .so-pick.is-blocked .so-pick-name { color: #9aa0a6; }
    .so-pick-reason { flex-basis: 100%; color: #b45309; font-weight: 600; }
    .so-pick-reason i { color: #d97706 !important; }

    /* Note under the selected chips (kit items skipped because of ex factory date) */
    .so-modal-note {
        display: flex; gap: 10px; margin: 0 20px 14px; padding: 10px 12px;
        font-size: 12px; line-height: 1.5; color: #8a5a00; background: #fff8e6;
        border: 1px solid #f6e3b3; border-radius: 8px;
    }
    .so-modal-note[hidden] { display: none; }
    .so-modal-note i { margin-top: 2px; }
    .so-modal-note ul { margin: 4px 0 0; padding-left: 18px; }
    .so-date-hint { margin-top: 6px; font-size: 11.5px; color: var(--so-muted); }
    .so-date-hint b { color: #374151; }

    /* ---------- Kit box inside the shoot popup ---------- */
    .so-kitbox { margin: 0 20px 14px; border: 1px solid var(--so-border); border-radius: 10px; background: #fbfafe; }
    .so-kitbox[hidden] { display: none; }
    .so-kb-head { display: flex; align-items: center; gap: 8px; padding: 10px 12px 4px; font-size: 12.5px; font-weight: 700; color: #1f2328; }
    .so-kb-head i { color: #6b5fc7; }
    .so-kb-options { padding: 4px 12px 10px; }
    .so-kb-option { display: flex; align-items: center; gap: 8px; margin: 0; padding: 4px 0; font-size: 13px; color: #1f2328; cursor: pointer; }
    .so-kb-option input { margin: 0; accent-color: var(--so-primary); }
    .so-kb-option span { color: var(--so-muted); font-size: 12px; }
    .so-kb-list { margin: 0 12px; border-top: 1px solid var(--so-border); max-height: 230px; overflow-y: auto; }
    .so-kb-kit { border-bottom: 1px dashed #e6e8ec; }
    .so-kb-kit:last-child { border-bottom: 0; }
    .so-kb-row { display: flex; align-items: center; gap: 8px; padding: 7px 0; font-size: 12.5px; }
    .so-kb-row label { display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0; margin: 0; cursor: pointer; }
    .so-kb-row input { margin: 0; flex-shrink: 0; accent-color: var(--so-primary); }
    .so-kb-name { font-weight: 600; color: #1f2328; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .so-kb-plus { flex-shrink: 0; font-weight: 700; color: #13806f; white-space: nowrap; }
    .so-kb-plus.is-zero { color: #9aa0a6; }
    .so-kb-taken { flex-shrink: 0; font-size: 11px; color: #b45309; white-space: nowrap; }
    .so-kb-view { flex-shrink: 0; border: 0; background: none; padding: 2px 4px; font-size: 11.5px; font-weight: 600; color: var(--so-link); cursor: pointer; white-space: nowrap; }
    .so-kb-view i { font-size: 10px; transition: transform .15s; }
    .so-kb-kit.is-open .so-kb-view i { transform: rotate(180deg); }
    .so-kb-items { list-style: none; margin: 0 0 8px 24px; padding: 0; }
    .so-kb-item { display: flex; align-items: center; gap: 8px; padding: 4px 0; font-size: 12px; }
    .so-kb-item-name { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #374151; }
    .so-kb-item-name small { color: var(--so-muted); }
    .so-kb-status { flex-shrink: 0; font-size: 10.5px; font-weight: 700; padding: 1px 7px; border-radius: 999px; white-space: nowrap; }
    .so-kb-status.is-selected { color: #1d5fd0; background: #e6efff; }
    .so-kb-status.is-add      { color: #13806f; background: #e3f6f3; }
    .so-kb-status.is-off      { color: #6b7280; background: #f1f2f4; }
    .so-kb-status.is-skip     { color: #b42318; background: #fdecee; }
    .so-kb-foot { display: flex; align-items: center; gap: 6px; margin: 0 12px; padding: 8px 0 10px; border-top: 1px solid var(--so-border); font-size: 12px; }
    .so-kb-foot .so-link-btn { font-size: 12px; }
    .so-kb-total { margin-left: auto; color: #374151; }
    .so-kb-total b { color: var(--so-primary); }
    .so-chip-kit { background: #f3f1fc; border-color: #e1dcf6; }
    .so-chip-kit i { color: #6b5fc7; margin-right: 3px; font-size: 10px; }

    .so-badge-upcoming { color: #13806f; background: #e3f6f3; }
    .so-badge-today    { color: #1d5fd0; background: #e6efff; }
    .so-badge-past     { color: #6b7280; background: #f1f2f4; }

    .so-pick-delete {
        flex-shrink: 0;
        width: 32px;
        height: 32px;
        border: 1px solid transparent;
        border-radius: 6px;
        background: transparent;
        color: #9aa0a6;
        cursor: pointer;
    }

    .so-pick-delete:hover { color: #d64550; background: #fdecee; border-color: #f8d3d7; }

    /* Inline delete confirm (replaces the row content) */
    .so-pick-confirm {
        display: none;
        flex: 1;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .so-pick.is-confirming { border-color: #f3c1c7; background: #fff7f8; cursor: default; }
    .so-pick.is-confirming > :not(.so-pick-confirm) { display: none; }
    .so-pick.is-confirming .so-pick-confirm { display: flex; }

    .so-pick-confirm-text { font-size: 12.5px; color: #8a1c27; min-width: 0; }
    .so-pick-confirm-text b { word-break: break-word; }
    .so-pick-confirm-actions { display: flex; gap: 6px; }
    .so-pick-confirm-actions .so-btn { height: 30px; font-size: 12px; }

    .so-btn-danger { background: #d64550; color: #fff; }
    .so-btn-danger:hover { background: #bf3540; color: #fff; }

    .so-list-empty {
        padding: 32px 12px;
        text-align: center;
        font-size: 13px;
        color: var(--so-muted);
        border: 1px dashed #dfe2e6;
        border-radius: 8px;
    }

    .so-list-empty i { display: block; margin-bottom: 8px; font-size: 24px; color: #c3c7cc; }

    .so-link-btn {
        margin-top: 8px;
        padding: 0;
        border: 0;
        background: none;
        color: var(--so-primary);
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
    }

    .so-link-btn:hover { text-decoration: underline; }

    .so-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 14px 20px;
        border-top: 1px solid var(--so-border);
        background: #fafbfc;
    }

    .so-modal-footer .so-btn { height: 38px; padding: 0 16px; }

    /* Toast message (bottom right, above the world-clock bar) */
    .so-toast {
        position: fixed;
        right: 20px;
        bottom: 80px;
        z-index: 10070;
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: calc(100vw - 40px);
        padding: 12px 16px;
        font-size: 13px;
        color: #fff;
        background: #1f2937;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .25);
        opacity: 0;
        transform: translateY(10px);
        pointer-events: none;
        transition: opacity .2s, transform .2s;
    }

    .so-toast.is-visible { opacity: 1; transform: translateY(0); }
    .so-toast i { color: #34d399; }
    .so-toast.is-error i { color: #f87171; }

    /* "—" for empty values (future columns, missing dates) */
    .so-dash { color: #b4b9c0; }

    /* Chat is disabled until the item is added to a shoot */
    .so-page .so-chat-btn.is-disabled {
        color: #9aa0a6 !important;
        border-color: #e1e4e8;
        background: #f8f9fa;
        cursor: not-allowed;
        pointer-events: none;
    }

    .so-input:disabled { background: #f5f6f7; color: #9aa0a6; cursor: not-allowed; }

    /* ---------- Select2 (searchable organization list) ---------- */
    .so-page .so-field-org .select2-container { width: 100% !important; }
    .so-page .select2-container--default .select2-selection--single {
        height: 34px;
        border: 1px solid #d6d9de !important;
        border-radius: 4px;
    }
    .so-page .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px;
        padding-left: 10px;
        padding-right: 26px;
        font-size: 12.5px;
        color: var(--so-text);
    }
    .so-page .select2-container--default .select2-selection--single .select2-selection__arrow { height: 32px; }
    .so-page .select2-container--default.select2-container--focus .select2-selection--single,
    .so-page .select2-container--default.select2-container--open .select2-selection--single {
        border-color: var(--so-primary);
    }
    /* Organization dropdown list (opened under <body>).
       Colors are set clearly so the theme cannot hide the option text. */
    .select2-dropdown.so-select2-dropdown {
        z-index: 10055;
        font-family: 'Open Sans', sans-serif;
        font-size: 12.5px;
        background: #fff;
        border: 1px solid #d6d9de;
        border-radius: 4px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .12);
    }
    .select2-dropdown.so-select2-dropdown .select2-search--dropdown { padding: 8px; }
    .select2-dropdown.so-select2-dropdown .select2-search__field {
        height: 32px;
        padding: 0 10px;
        font-size: 12.5px;
        color: #1f2328;
        border: 1px solid #d6d9de;
        border-radius: 4px;
        outline: none;
    }
    .select2-dropdown.so-select2-dropdown .select2-search__field:focus { border-color: #16a394; }
    .select2-dropdown.so-select2-dropdown .select2-results > .select2-results__options {
        max-height: 260px;
        overflow-y: auto;
    }
    .select2-dropdown.so-select2-dropdown .select2-results__option {
        display: block;
        padding: 7px 12px;
        font-size: 12.5px;
        line-height: 1.4;
        color: #1f2328;
        background: #fff;
        white-space: normal;
    }
    .select2-dropdown.so-select2-dropdown .select2-results__option[aria-selected="true"],
    .select2-dropdown.so-select2-dropdown .select2-results__option--selected { background: #e3f6f3; color: #13806f; }
    .select2-dropdown.so-select2-dropdown .select2-results__option--highlighted,
    .select2-dropdown.so-select2-dropdown .select2-results__option--highlighted[aria-selected] { background: #16a394; color: #fff; }
    .select2-dropdown.so-select2-dropdown .select2-results__message { color: #6b7280; }

    /* ==========================================================
       RESPONSIVE
       ========================================================== */

    /* Tablets / small laptops: search on its own line, filters fill the width */
    @media (max-width: 1199.98px) {
        .so-search { flex-basis: 100%; max-width: none; }
        .so-filter-group { margin-left: 0; width: 100%; flex: 1 1 100%; flex-wrap: wrap; }
        .so-field-org   { flex: 2 1 200px; width: auto; }
        .so-field-shoot,
        .so-field-style { flex: 1 1 130px; width: auto; }
        .so-field-perpage { flex: 0 0 76px; }
    }

    /* ==========================================================
       PHONES (Figma mobile design)
       ========================================================== */
    @media (max-width: 767.98px) {
        .so-page {
            --so-bottom-gap: 130px;
            --so-mint: #3cc98b;            /* "Filters" (open) + "Filter activity" */
            --so-mint-dark: #31b37a;
            --so-m-card-radius: 16px;
            --so-m-shadow: 0 1px 2px rgba(16, 24, 40, .05), 0 2px 8px rgba(16, 24, 40, .06);
        }

        /* Leave room for the floating selection panel when items are selected */
        .so-page.has-selection { --so-bottom-gap: 330px; }

        .so-title { font-size: 1.4rem; margin-bottom: 1rem; }

        /* phone-only / desktop-only helpers */
        .so-page .so-d-only { display: none; }
        .so-page span.so-m-only { display: inline; }
        .so-page .so-field.so-m-only { display: flex; }

        /* ---------- Search + Filters card ---------- */
        .so-filters {
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            padding: 16px;
            margin-bottom: 12px;
            border: 1px solid #eef0f2;
            border-radius: var(--so-m-card-radius);
            box-shadow: var(--so-m-shadow);
        }

        .so-search { flex: 1 1 0; min-width: 0; max-width: none; }
        .so-search i { left: 14px; font-size: 13px; }
        .so-search .so-input { padding-left: 38px; }

        .so-filters .so-input {
            height: 44px;
            padding: 0 12px;
            font-size: 14px;
            border-color: #e2e5e9;
            border-radius: 10px;
        }
        .so-filters .so-search .so-input { padding-left: 38px; }   /* room for the search icon */

        .so-page .so-filter-toggle {
            display: inline-flex;
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
        .so-filter-toggle svg { width: 16px; height: 16px; flex-shrink: 0; }
        .so-filter-toggle:hover { background: #f7f8f9; }
        .so-filters.is-open .so-filter-toggle {
            color: #fff;
            background: var(--so-mint);
            border-color: var(--so-mint);
        }

        /* Filter panel: hidden until "Filters" is tapped */
        .so-filter-group { display: none; }
        .so-filters.is-open .so-filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 14px 10px;
            width: 100%;
            margin: 6px 0 0;
        }

        .so-filters .so-field,
        .so-filters .so-field-org,
        .so-filters .so-field-shoot,
        .so-filters .so-field-style { flex: 1 1 100%; width: auto; }
        .so-filters .so-field-sort,
        .so-filters .so-field-perpage { flex: 1 1 calc(50% - 5px); width: auto; }

        .so-field .so-m-label {
            display: block;
            margin: 0 0 6px;
            font-size: 12.5px;
            font-weight: 600;
            letter-spacing: 0;
            text-transform: none;
            color: #4b5563;
        }

        /* Native date picker (mm/dd/yyyy) — keep it full height and left aligned on iOS */
        .so-filters input[type="date"].so-input {
            display: block;
            min-height: 44px;
            line-height: 42px;
            -webkit-appearance: none;
            appearance: none;
            text-align: left;
        }
        .so-filters input[type="date"].so-input::-webkit-date-and-time-value { text-align: left; }

        /* Searchable organization list (Select2) */
        .so-page .select2-container--default .select2-selection--single {
            height: 44px;
            border-color: #e2e5e9 !important;
            border-radius: 10px;
        }
        .so-page .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px;
            padding-left: 12px;
            font-size: 14px;
        }
        .so-page .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px; right: 6px; }

        /* Reset filters (left) + Filter activity (right) */
        .so-actions { flex: 1 1 100%; width: 100%; gap: 10px; margin-top: 2px; }
        .so-actions .so-btn { flex: 1 1 0; height: 44px; font-size: 13.5px; border-radius: 8px; }
        .so-actions #soReset {
            order: 1;
            width: auto;
            padding: 0 12px;
            color: #4b5563;
            background: #eef1f6;
            border-color: #dfe3ea;
        }
        .so-actions #soReset:hover { background: #e4e8ef; }
        .so-actions #soApply {
            order: 2;
            font-weight: 700;
            background: var(--so-mint);
        }
        .so-actions #soApply:hover { background: var(--so-mint-dark); }
        .so-actions #soApply > i { display: none; }

        /* ---------- Selection panel (floats above the world-clock bar) ---------- */
        .so-selection-bar {
            position: fixed;
            left: 12px;
            right: 12px;
            bottom: 128px;
            z-index: 1035;
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            padding: 16px;
            margin: 0;
            background: #effbf4;
            border: 1px solid #d3efe2;
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, .18);
        }
        .so-sel-title { font-size: 15px; }
        .so-sel-sub   { font-size: 11.5px; }

        .so-sel-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            width: 100%;
        }
        .so-sel-actions .so-btn { height: 44px; font-size: 13px; border-radius: 8px; }
        .so-sel-actions #soClearSelection { grid-column: 1 / -1; background: #fff; border-color: #cfd3d8; }
        .so-sel-actions #soCreateKit { color: #5b5f86; background: #e4e6f4; }
        .so-sel-actions #soCreateKit:hover:not(:disabled) { background: #d9dcef; }
        .so-sel-actions #soCreateKit:disabled { opacity: .75; }

        /* ---------- "Select All" card ---------- */
        .so-list-card { background: transparent; border: 0; border-radius: 0; }

        .so-mobile-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 14px 16px;
            margin-bottom: 12px;
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: var(--so-m-card-radius);
            box-shadow: var(--so-m-shadow);
        }
        .so-mobile-toolbar label {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: #1f2328;
            cursor: pointer;
        }
        .so-mobile-toolbar .so-check { width: 18px; height: 18px; }

        .so-sel-count {
            flex-shrink: 0;
            padding: 4px 12px;
            font-size: 12.5px;
            font-weight: 600;
            color: #4b5563;
            background: #eef0f2;
            border-radius: 999px;
            white-space: nowrap;
        }

        /* ---------- Item cards ---------- */
        .so-table-wrap { overflow: visible; }   /* do not cut the card shadows */
        .so-table { min-width: 0; display: block; }
        .so-table thead { display: none; }
        .so-table tbody { display: block; }

        .so-table tbody tr.so-row {
            display: grid;
            grid-template-columns: 18px 60px minmax(0, 1fr) auto;
            grid-template-areas:
                "check image name    toggle"
                "check image created techpack"
                "check image order   chat"
                "exp   exp   exp     exp"
                "shoot shoot shoot   shoot"
                "org   org   org     org";
            column-gap: 10px;
            row-gap: 4px;
            align-items: center;
            padding: 12px;
            margin-bottom: 12px;
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: var(--so-m-shadow);
            overflow: hidden;
        }
        .so-table tbody tr.so-row.is-open { padding-bottom: 2px; }

        .so-table tbody tr.so-row:hover,
        .so-table tbody tr.so-row.is-selected,
        .so-table tbody tr.so-row.is-selected:hover { background: #fff; }

        .so-table tbody td { padding: 0; border: 0; white-space: normal; }
        .so-table tbody td:first-child { padding-left: 0; }

        .so-col-check   { grid-area: check; align-self: start; padding-top: 2px !important; }
        .so-col-image   { grid-area: image; align-self: start; }
        .so-col-name    { grid-area: name; min-width: 0; }
        .so-col-created { grid-area: created; min-width: 0; }
        .so-col-order   { grid-area: order; min-width: 0; }
        .so-table td.so-col-toggle { grid-area: toggle; display: block; justify-self: end; }
        .so-col-techpack { grid-area: techpack; justify-self: end; }
        .so-col-chat    { grid-area: chat; justify-self: end; }
        .so-col-exp     { grid-area: exp; }
        .so-col-shoot   { grid-area: shoot; }
        .so-col-org     { grid-area: org; }

        .so-row .so-check { width: 17px; height: 17px; }

        .so-row .so-thumb { width: 60px; height: 60px; border-radius: 6px; }

        .so-row .so-name { font-size: 13.5px; color: #111827; }
        .so-tag { max-width: 100%; }

        .so-col-created { font-size: 12.5px; color: #1f2328; }

        .so-page .so-col-order a.so-order-link {
            display: inline-block;
            max-width: 100%;
            padding: 1px 8px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.5;
            background: #fff;
            border: 1px solid #dbe3ef;
            border-radius: 999px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Open / close arrow */
        .so-row-toggle {
            width: 26px;
            height: 22px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #1f2328;
            background: transparent;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
        }
        .so-row-toggle:hover { background: #f1f2f4; }
        .so-row-toggle i { transition: transform .2s; }
        .so-row.is-open .so-row-toggle i { transform: rotate(180deg); }

        /* Small "Tech pack" and chat pills on the right */
        .so-col-techpack .so-tp-btn,
        .so-page .so-col-chat a.so-chat-btn {
            min-width: 76px;
            height: 22px;
            padding: 0 8px;
            gap: 5px;
            justify-content: center;
            font-size: 11.5px;
            font-weight: 500;
            border: 1px solid #d6d9de;
            border-radius: 999px;
        }
        .so-col-techpack .so-tp-btn { color: #374151; }
        .so-col-techpack .so-tp-btn > i,
        .so-col-techpack .so-tp-count { display: none; }
        .so-col-techpack .so-tp-btn.is-empty {
            display: inline-flex;
            align-items: center;
            color: #b4b9c0;
            background: #f8f9fa;
            border-color: #e5e7eb;
            cursor: default;
        }

        .so-page .so-col-chat a.so-chat-btn { color: #4b5563 !important; }
        .so-page .so-col-chat a.so-chat-btn > i { font-size: 11px; }
        .so-chat-label { display: none; }
        .so-col-chat .so-chat-count { min-width: 15px; height: 15px; padding: 0 4px; font-size: 9.5px; }

        /* Details shown when the card is opened */
        .so-col-exp,
        .so-col-shoot,
        .so-col-org {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin: 0 -12px;
            padding: 9px 12px !important;
            font-size: 12.5px;
            color: #1f2328;
            border-top: 1px solid #eceef1 !important;
        }
        .so-col-exp { margin-top: 8px; }

        .so-col-exp::before,
        .so-col-shoot::before,
        .so-col-org::before {
            content: attr(data-label);
            flex-shrink: 0;
            font-size: 12.5px;
            font-weight: 400;
            color: #4b5563;
        }

        .so-table tbody tr.so-row:not(.is-open) .so-col-exp,
        .so-table tbody tr.so-row:not(.is-open) .so-col-shoot,
        .so-table tbody tr.so-row:not(.is-open) .so-col-org { display: none; }

        .so-col-org .so-org { max-width: 60%; font-weight: 700; text-align: right; }

        /* ---------- Empty message + pagination ---------- */
        .so-empty {
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: var(--so-m-shadow);
        }

        .so-footer {
            flex-direction: column;
            justify-content: center;
            padding: 12px;
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: var(--so-m-shadow);
        }
        .so-pagination { justify-content: center; }

        /* Modals become a bottom sheet on phones */
        .so-modal { align-items: flex-end; padding: 0; }
        .so-tp-body { padding: 0 12px 12px; }
        .so-tp-stage { height: 52vh; }
        .so-tp-nav { width: 34px; height: 34px; }
        .so-tp-caption { flex-direction: column; align-items: stretch; }
        .so-tp-links a { flex: 1; justify-content: center; height: 36px; }
        .so-tp-thumb { width: 54px; height: 54px; }

        .so-modal-dialog {
            max-width: none;
            max-height: 92vh;
            border-radius: 14px 14px 0 0;
        }
        .so-modal-header { padding: 16px 16px 12px; }
        .so-modal-selected { padding: 0 16px 12px; }
        .so-tabs { padding: 0 12px; }
        .so-tab { flex: 1; justify-content: center; padding: 11px 6px; font-size: 12.5px; white-space: nowrap; }
        .so-tab > i { display: none; }
        .so-modal-body { padding: 16px; }
        .so-form-grid { grid-template-columns: 1fr; }
        .so-modal-footer { padding: 12px 16px; }
        .so-modal-footer .so-btn { flex: 1; height: 42px; }
        .so-modal-footer { flex-wrap: wrap; }
        .so-kitbox { margin: 0 16px 12px; }
        .so-kb-list { max-height: 180px; }
        .so-kb-row { flex-wrap: wrap; row-gap: 2px; }
        .so-kb-taken { order: 5; flex-basis: 100%; padding-left: 24px; }
        .so-modal-note { margin: 0 16px 12px; }

        .so-toast { left: 16px; right: 16px; bottom: 140px; }
        .so-page.has-selection .so-toast { bottom: 330px; }   /* above the selection panel */
    }

    /* Very small phones (320px) */
    @media (max-width: 359.98px) {
        .so-filters { padding: 12px; }
        .so-page .so-filter-toggle { padding: 0 10px; }
        .so-table tbody tr.so-row { grid-template-columns: 18px 48px minmax(0, 1fr) auto; column-gap: 8px; }
        .so-row .so-thumb { width: 48px; height: 48px; }
        .so-col-techpack .so-tp-btn,
        .so-page .so-col-chat a.so-chat-btn { min-width: 68px; }
    }
    @media (max-width: 768px) {
        .header1 {
            height: 40px;
            margin-top: 11px;
        }
    }
</style>

<div class="container-fluid so-page">

    @section('order-header')
        <span>Studio Items</span>
    @endsection

    {{-- ================= FILTERS ================= --}}
    <div class="so-card so-filters">
        <div class="so-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="soSearch" class="so-input" placeholder="Search by name, order number, organization..." autocomplete="off">
        </div>

        {{-- Phones only: opens / closes the filter panel below --}}
        <button type="button" id="soFilterToggle" class="so-btn so-filter-toggle so-m-only"
                aria-expanded="false" aria-controls="soFilterGroup">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
                <path d="M4 7h16M7 12h10M10 17h4"/>
            </svg>
            Filters
        </button>

        <div class="so-filter-group" id="soFilterGroup">
            {{-- Shows items that are in a shoot on the picked date.
                 It is a text box (so it can show a placeholder) that becomes a date picker on focus.
                 On phones it is always a date picker (it has a label there). --}}
            <div class="so-field so-field-shoot">
                <label class="so-m-label" for="soShootDate">Upcoming Shoot</label>
                <input type="text" id="soShootDate" class="so-input so-date-input" placeholder="Upcoming Shoot"
                       aria-label="Upcoming Shoot" title="Show items scheduled for this shoot date" autocomplete="off">
            </div>

            <div class="so-field so-field-org">
                <label class="so-m-label" for="soOrg">Organization</label>
                <select id="soOrg" class="so-input" aria-label="Organization">
                    <option value="">Organization</option>
                    @foreach($organizationData as $org)
                        <option value="{{ $org->id }}">{{ $org->organization_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="so-field so-field-style">
                <label class="so-m-label" for="soStyle">Product Style</label>
                <select id="soStyle" class="so-input is-placeholder" aria-label="Product Style">
                    <option value="">Product Style</option>
                    @foreach($productCategoryData as $category)
                        <option value="{{ $category->id }}">{{ $category->product_category_name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Phones only: order number filter (from the Figma design) --}}
            <div class="so-field so-field-orderno so-m-only">
                <label class="so-m-label" for="soOrderNo">Order Number</label>
                <input type="text" id="soOrderNo" class="so-input" placeholder="e.g. 002871"
                       inputmode="numeric" autocomplete="off">
            </div>

            {{-- Phones only: sort order (on desktop you sort by clicking the table headers) --}}
            <div class="so-field so-field-sort so-m-only">
                <label class="so-m-label" for="soMobileSort">Sort by</label>
                <select id="soMobileSort" class="so-input" aria-label="Sort by">
                    <option value="id-desc">Newest first</option>
                    <option value="id-asc">Oldest first</option>
                    <option value="name-asc">Name (A–Z)</option>
                    <option value="exp-asc">Ex Factory Date (soonest)</option>
                    <option value="exp-desc">Ex Factory Date (latest)</option>
                    <option value="order-desc">Order number (high–low)</option>
                    <option value="org-asc">Organization (A–Z)</option>
                </select>
            </div>

            {{-- Rows per page (changes the table at once, no need to click Apply) --}}
            <div class="so-field so-field-perpage">
                <label class="so-m-label" for="soPerPage">Rows per page</label>
                <select id="soPerPage" class="so-input" aria-label="Rows per page" title="Rows per page">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="so-actions">
                <button type="button" id="soApply" class="so-btn so-btn-primary">
                    <i class="fa-solid fa-filter"></i>
                    <span class="so-d-only">Apply Filters</span>
                    <span class="so-m-only">Filter activity</span>
                </button>
                <button type="button" id="soReset" class="so-btn so-btn-outline so-btn-icon" title="Reset Filters" aria-label="Reset Filters">
                    <i class="fa-solid fa-rotate-right"></i>
                    <span class="so-m-only">Reset filters</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ================= SELECTION BAR (hidden by default) ================= --}}
    <div class="so-selection-bar" id="soSelectionBar" aria-live="polite">
        <div>
            <div class="so-sel-title" id="soSelTitle">0 items selected</div>
            <div class="so-sel-sub" id="soSelSub"></div>
        </div>
        <div class="so-sel-actions">
             <button type="button" id="soCreateKit" class="so-btn so-btn-primary" disabled title="Select 2 or more items to create a kit">
                + Create Kit
            </button>
            <button type="button" id="soCreateShoot" class="so-btn so-btn-primary">
                + Create shoot
            </button>
            <button type="button" id="soClearSelection" class="so-btn so-btn-outline">
                Clear Selection
            </button>
        </div>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="so-card so-list-card">

        {{-- Shown only on phones (table header is hidden there).
             "Select All" selects every item on this page. --}}
        <div class="so-mobile-toolbar">
            <label>
                <input type="checkbox" class="so-check so-select-all" aria-label="Select all on this page"> Select All
            </label>
            <span class="so-sel-count" id="soMobileSelCount" aria-live="polite">0 selected</span>
        </div>

        <div class="so-table-wrap">
            <table class="so-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" class="so-check so-select-all" aria-label="Select all on this page">
                        </th>
                        <th class="so-sortable" data-sort="created" style="width: 130px;">
                            Created Date <i class="fa-solid fa-sort"></i>
                        </th>
                        <th style="width: 66px;">Image</th>
                        <th class="so-sortable" data-sort="name">
                            Name <i class="fa-solid fa-sort"></i>
                        </th>
                        <th class="so-sortable" data-sort="exp" style="width: 120px;">
                            Ex Factory Date <i class="fa-solid fa-sort"></i>
                        </th>
                        <th style="width: 120px;">Shoot Date</th>
                        <th class="so-sortable" data-sort="order" style="width: 120px;">
                            Order Number <i class="fa-solid fa-sort"></i>
                        </th>
                        <th class="so-sortable" data-sort="org" style="width: 170px;">
                            Organization Name <i class="fa-solid fa-sort"></i>
                        </th>
                        <th style="width: 110px;">Tech Pack</th>
                        <th style="width: 90px;">Chat</th>
                    </tr>
                </thead>

                <tbody id="soTableBody">
                    @foreach($studioItems as $item)
                        <tr class="so-row"
                            data-id="{{ $item['id'] }}"
                            data-name="{{ $item['name'] }}"
                            data-styles="{{ implode('|', $item['styles']) }}"
                            data-style-names="{{ implode(' ', $item['style_names']) }}"
                            data-created="{{ $item['created_date'] ? $item['created_date']->format('Y-m-d H:i:s') : '' }}"
                            data-exp="{{ $item['exp_date'] ? $item['exp_date']->format('Y-m-d') : '' }}"
                            data-order="{{ $item['order_number'] }}"
                            data-org="{{ $item['organization'] }}"
                            data-org-id="{{ $item['organization_id'] ?? '' }}">

                            <td class="so-col-check">
                                <input type="checkbox" class="so-check so-row-check" value="{{ $item['id'] }}" aria-label="Select {{ $item['name'] }}">
                            </td>

                            {{-- Order item created date (order_items.created_at) --}}
                            <td class="so-col-created" data-label="Created">
                                @if($item['created_date'])
                                    {{ $item['created_date']->format('M d, Y') }}
                                @else
                                    <span class="so-dash">—</span>
                                @endif
                            </td>

                            <td class="so-col-image">
                                @if($item['image'])
                                    <div class="so-thumb has-image">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" loading="lazy"
                                             class="so-thumb-img" data-caption="{{ $item['name'] }}"
                                             onerror="this.parentNode.classList.remove('has-image'); this.parentNode.classList.add('so-thumb-empty'); this.remove();">
                                    </div>
                                @else
                                    <div class="so-thumb so-thumb-empty"></div>
                                @endif
                            </td>

                            <td class="so-col-name">
                                <div class="so-name">{{ $item['name'] ?: '—' }}</div>
                                {{-- Kit / shoot labels (filled by JavaScript) --}}
                                <div class="so-tags" data-role="tags"></div>
                            </td>

                            <td class="so-col-exp" data-label="Ex Factory Date">
                                @if($item['exp_date'])
                                    {{ $item['exp_date']->format('M d, Y') }}
                                @else
                                    <span class="so-dash">—</span>
                                @endif
                            </td>

                            {{-- Shoot schedule date (filled by JavaScript from the shoots list) --}}
                            <td class="so-col-shoot" data-label="Shoot Date" data-role="shoot">
                                <span class="so-dash">—</span>
                            </td>

                            <td class="so-col-order">
                                {{-- Opens the order edit page in a new tab, e.g. /order_details/edit/2554/order?active_tab=order --}}
                                <a href="{{ url('order_details/edit/' . $item['order_id'] . '/order') }}?active_tab=order"
                                   class="so-order-link"
                                   target="_blank"
                                   rel="noopener"
                                   title="Open order #{{ $item['order_number'] }} in a new tab">#{{ $item['order_number'] }}</a>
                            </td>

                            <td class="so-col-org" data-label="Organization Name">
                                @if($item['organization'])
                                    <span class="so-org" title="{{ $item['organization'] }}">{{ $item['organization'] }}</span>
                                @else
                                    <span class="so-dash">—</span>
                                @endif
                            </td>

                            {{-- Tech pack images (order_item_files.tech_pack_images) -> preview modal --}}
                            <td class="so-col-techpack" data-label="Tech Pack">
                                @if(count($item['tech_packs']))
                                    <button type="button" class="so-tp-btn" data-role="techpack"
                                            data-files="{{ json_encode($item['tech_packs']) }}"
                                            data-title="{{ $item['name'] }}"
                                            data-order="{{ $item['order_number'] }}"
                                            title="View tech pack">
                                        <i class="fa-regular fa-images"></i>
                                        <span class="so-d-only">View</span>
                                        <span class="so-m-only">Tech pack</span>
                                        <span class="so-tp-count">{{ count($item['tech_packs']) }}</span>
                                    </button>
                                @else
                                    <span class="so-dash so-d-only" title="No tech pack uploaded">—</span>
                                    <span class="so-tp-btn is-empty so-m-only" title="No tech pack uploaded">Tech pack</span>
                                @endif
                            </td>

                            {{-- Item chat (PM sub discussion). Disabled until the item is in a shoot (set by JavaScript) --}}
                            <td class="so-col-chat">
                                <a href="#" class="so-chat-btn" data-role="chat" data-id="{{ $item['id'] }}" title="Item chat" role="button">
                                    <i class="fa-regular fa-message"></i>
                                    <span class="so-chat-label">Chat</span>
                                    @if(!empty($item['chat_count']))
                                        <span class="so-chat-count">{{ $item['chat_count'] }}</span>
                                    @endif
                                </a>
                            </td>

                            {{-- Phones only: open / close the card details (hidden on desktop) --}}
                            <td class="so-col-toggle">
                                <button type="button" class="so-row-toggle" data-role="row-toggle"
                                        aria-expanded="false" aria-label="Show details for {{ $item['name'] }}">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="soEmpty" class="so-empty so-hidden">
            <i class="fa-regular fa-folder-open"></i>
            <span id="soEmptyText">No studio items match your filters.</span>
        </div>

        <div class="so-footer">
            <div class="so-info" id="soInfo"></div>
            <div class="so-pagination" id="soPagination"></div>
        </div>
    </div>

    {{-- =====================================================
         KIT MODAL
         Tab 1: New Kit       -> create a kit with the selected items
         Tab 2: Existing Kits -> add selected items to a kit / delete a kit
         ===================================================== --}}
    <div class="so-modal" id="soKitModal" aria-hidden="true">
        <div class="so-modal-backdrop" data-close></div>

        <div class="so-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="soKitModalTitle">
            <div class="so-modal-header">
                <div class="so-modal-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                <div class="so-modal-heading">
                    <h5 class="so-modal-title" id="soKitModalTitle">Build a Kit</h5>
                    <p class="so-modal-sub" data-role="subtitle"></p>
                </div>
                <button type="button" class="so-modal-close" data-close aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="so-modal-selected" data-role="selected"></div>

            <div class="so-tabs" role="tablist">
                <button type="button" class="so-tab is-active" role="tab" data-tab="new" aria-selected="true">
                    <i class="fa-solid fa-plus"></i> New Kit
                </button>
                <button type="button" class="so-tab" role="tab" data-tab="existing" aria-selected="false">
                    <i class="fa-solid fa-layer-group"></i> Existing Kits
                    <span class="so-tab-count" data-role="count">0</span>
                </button>
            </div>

            <div class="so-modal-body">
                {{-- Tab 1: New Kit --}}
                <div class="so-tab-panel is-active" role="tabpanel" data-panel="new">
                    <form data-role="form" novalidate autocomplete="off">
                        <div class="so-form-row">
                            <label class="so-form-label" for="soKitName">Kit Name <span class="so-req">*</span></label>
                            <input type="text" id="soKitName" name="name" class="so-input" maxlength="100"
                                   placeholder="e.g. Spring Showcase 2027 – Home Kit">
                            <div class="so-form-error" data-error="name"></div>
                            <div class="so-form-hint">Give the kit a clear name so the team can find it later.</div>
                        </div>
                    </form>
                </div>

                {{-- Tab 2: Existing Kits --}}
                <div class="so-tab-panel" role="tabpanel" data-panel="existing">
                    <div class="so-input-icon so-list-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" class="so-input" data-role="search" placeholder="Search kits...">
                    </div>
                    <div class="so-pick-list" data-role="list"></div>
                </div>
            </div>

            <div class="so-modal-footer">
                <button type="button" class="so-btn so-btn-outline" data-close>Cancel</button>
                <button type="button" class="so-btn so-btn-primary" data-role="submit">Create Kit</button>
            </div>
        </div>
    </div>

    {{-- =====================================================
         SHOOT MODAL
         Tab 1: New Shoot       -> name, date
         Tab 2: Scheduled Shoots -> add selected items to a shoot / delete a shoot
         ===================================================== --}}
    <div class="so-modal" id="soShootModal" aria-hidden="true">
        <div class="so-modal-backdrop" data-close></div>

        <div class="so-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="soShootModalTitle">
            <div class="so-modal-header">
                <div class="so-modal-icon"><i class="fa-solid fa-camera"></i></div>
                <div class="so-modal-heading">
                    <h5 class="so-modal-title" id="soShootModalTitle">Schedule a Photo Shoot</h5>
                    <p class="so-modal-sub" data-role="subtitle"></p>
                </div>
                <button type="button" class="so-modal-close" data-close aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="so-modal-selected" data-role="selected"></div>

            {{-- Selected items are in kits: only the selected items, or also add kit items --}}
            <div class="so-kitbox" data-role="kitbox" hidden></div>

            <div class="so-modal-note" data-role="note" role="status" aria-live="polite" hidden></div>

            <div class="so-tabs" role="tablist">
                <button type="button" class="so-tab is-active" role="tab" data-tab="new" aria-selected="true">
                    <i class="fa-solid fa-plus"></i> New Shoot
                </button>
                <button type="button" class="so-tab" role="tab" data-tab="existing" aria-selected="false">
                    <i class="fa-regular fa-calendar"></i> Scheduled Shoots
                    <span class="so-tab-count" data-role="count">0</span>
                </button>
            </div>

            <div class="so-modal-body">
                {{-- Tab 1: New Shoot --}}
                <div class="so-tab-panel is-active" role="tabpanel" data-panel="new">
                    <form data-role="form" novalidate autocomplete="off">
                        <div class="so-form-row">
                            <label class="so-form-label" for="soShootName">Shoot Name <span class="so-req">*</span></label>
                            <input type="text" id="soShootName" name="name" class="so-input" maxlength="100"
                                   placeholder="e.g. Spring Catalog Shoot">
                            <div class="so-form-error" data-error="name"></div>
                        </div>

                        <div class="so-form-row">
                            <label class="so-form-label" for="soShootDateInput">Shoot Date <span class="so-req">*</span></label>
                            <input type="date" id="soShootDateInput" name="date" class="so-input" aria-describedby="soShootDateHint">
                            <div class="so-date-hint" id="soShootDateHint" data-role="date-hint"></div>
                            <div class="so-form-error" data-error="date"></div>
                        </div>
                    </form>
                </div>

                {{-- Tab 2: Scheduled Shoots --}}
                <div class="so-tab-panel" role="tabpanel" data-panel="existing">
                    <div class="so-input-icon so-list-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" class="so-input" data-role="search" placeholder="Search shoots...">
                    </div>
                    <div class="so-pick-list" data-role="list"></div>
                </div>
            </div>

            <div class="so-modal-footer">
                <button type="button" class="so-btn so-btn-outline" data-close>Cancel</button>
                <button type="button" class="so-btn so-btn-primary" data-role="submit">Create Shoot</button>
            </div>
        </div>
    </div>

    {{-- =====================================================
         TECH PACK VIEWER — one image at a time
         ←/→ keys or arrows to move, swipe on phones, Esc to close
         ===================================================== --}}
    <div class="so-modal" id="soTpModal" aria-hidden="true">
        <div class="so-modal-backdrop" data-close></div>
        <div class="so-modal-dialog so-modal-lg" role="dialog" aria-modal="true" aria-labelledby="soTpTitle">
            <div class="so-modal-header">
                <div class="so-modal-icon"><i class="fa-regular fa-images"></i></div>
                <div class="so-modal-heading">
                    <h5 class="so-modal-title" id="soTpTitle">Tech Pack</h5>
                    <p class="so-modal-sub" id="soTpSub"></p>
                </div>
                <button type="button" class="so-modal-close" data-close aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="so-tp-body">
                <div class="so-tp-stage" id="soTpStage">
                    <img src="" alt="" id="soTpImg">
                    <div class="so-tp-spinner"><i class="fa-solid fa-spinner fa-spin"></i>Loading image...</div>
                    <div class="so-tp-error"><i class="fa-regular fa-image"></i>This image could not be loaded.</div>
                    <span class="so-tp-counter" id="soTpCounter"></span>
                    <button type="button" class="so-tp-nav so-tp-prev" id="soTpPrev" aria-label="Previous image"><i class="fa-solid fa-chevron-left"></i></button>
                    <button type="button" class="so-tp-nav so-tp-next" id="soTpNext" aria-label="Next image"><i class="fa-solid fa-chevron-right"></i></button>
                </div>

                <div class="so-tp-caption">
                    <span class="so-tp-name" id="soTpName"></span>
                    <span class="so-tp-links">
                        <a href="#" id="soTpOpen" target="_blank" rel="noopener"><i class="fa-solid fa-up-right-from-square"></i> Open full size</a>
                        <a href="#" id="soTpDownload" download><i class="fa-solid fa-download"></i> Download</a>
                    </span>
                </div>

                <div class="so-tp-thumbs" id="soTpThumbs"></div>
            </div>
        </div>
    </div>

    {{-- Small success / error message --}}
    <div class="so-toast" id="soToast" role="status" aria-live="polite">
        <i class="fa-solid fa-circle-check"></i>
        <span data-role="text"></span>
    </div>
</div>

{{-- Large image preview (one shared element for all rows) --}}
<div class="so-img-backdrop" id="soImgBackdrop"></div>
<div class="so-img-preview" id="soImgPreview" aria-hidden="true">
    <img src="" alt="">
    <div class="so-img-preview-caption"></div>
</div>

@include('pages.studio_order.studio_chat')
@endsection

@push('js')
<script>
$(function () {

    // Rows per page: 10 / 20 / 50 / 100 (the user's choice is remembered in this browser)
    const PER_PAGE_OPTIONS = [10, 20, 50, 100];
    const PER_PAGE_KEY     = 'studio_items_per_page';
    let PER_PAGE = 10;
    try {
        const saved = parseInt(localStorage.getItem(PER_PAGE_KEY), 10);
        if (PER_PAGE_OPTIONS.indexOf(saved) !== -1) PER_PAGE = saved;
    } catch (e) { /* storage blocked -> keep 10 */ }
    $('#soPerPage').val(String(PER_PAGE));

    const $tbody      = $('#soTableBody');
    const $info       = $('#soInfo');
    const $pagination = $('#soPagination');
    const $empty      = $('#soEmpty');
    const $selBar     = $('#soSelectionBar');

    let allRows  = $tbody.find('tr.so-row').toArray();   // every row (in sorted order)
    let filtered = allRows.slice();                        // rows that pass the filters
    let page     = 1;
    let sortKey  = 'id';     // newest first (same order as created date)
    let sortDir  = 'desc';

    // Selected item ids. Kept across pages and filters.
    const selected = new Set();

    /* ---------------- SEARCHABLE ORGANIZATION LIST ---------------- */
    // There are thousands of organizations, so make the dropdown searchable (Select2 is in your layout)
    if ($.fn.select2) {
        const $org = $('#soOrg');

        $org.select2({
            width: '100%',
            placeholder: 'Organization',
            allowClear: true,
            dropdownParent: $('body'),
            language: {
                noResults: function () { return 'No organization found'; },
                searching: function () { return 'Searching...'; },
            },
        });

        // Select2 4.1 ignores "dropdownCssClass", so add our class when the list opens
        // and put the cursor in the search box
        $org.on('select2:open', function () {
            $('.select2-container--open .select2-dropdown').addClass('so-select2-dropdown');
            const search = document.querySelector('.select2-container--open .select2-search__field');
            if (search) search.focus();
        });
    }

    /* ---------------- SORTING ---------------- */
    function compareRows(a, b) {
        if (sortKey === 'id') {
            return (parseInt(a.dataset.id, 10) - parseInt(b.dataset.id, 10)) * (sortDir === 'asc' ? 1 : -1);
        }

        const x = (a.dataset[sortKey] || '').toLowerCase();
        const y = (b.dataset[sortKey] || '').toLowerCase();

        // Empty values always go to the bottom
        if (!x && y) return 1;
        if (x && !y) return -1;

        if (x < y) return sortDir === 'asc' ? -1 : 1;
        if (x > y) return sortDir === 'asc' ? 1 : -1;
        return 0;
    }

    // Keep items of the same kit together.
    // The group takes the place of its first item in the normal sort order,
    // and inside the group the items keep the normal sort order.
    function groupByKit(rows) {
        const result = [];
        const placed = new Set();

        rows.forEach(function (row) {
            if (placed.has(row)) return;

            const kitId = row.dataset.kit;
            if (!kitId) {
                result.push(row);
                placed.add(row);
                return;
            }

            rows.forEach(function (other) {
                if (!placed.has(other) && other.dataset.kit === kitId) {
                    result.push(other);
                    placed.add(other);
                }
            });
        });

        return result;
    }

    // Items NOT assigned to a shoot go first, then items that have a shoot.
    // (Both parts keep the normal sort order.)
    function unscheduledFirst(rows) {
        const noShoot  = rows.filter(function (row) { return !row.dataset.shoot; });
        const hasShoot = rows.filter(function (row) { return !!row.dataset.shoot; });
        return noShoot.concat(hasShoot);
    }

    function sortRows() {
        allRows.sort(compareRows);
        allRows = unscheduledFirst(allRows);   // 1. not-scheduled items on top
        allRows = groupByKit(allRows);         // 2. keep kit items together (a kit stays on top if any item still needs a shoot)
        allRows.forEach(function (row) { $tbody.append(row); });

        $('.so-sortable').removeClass('is-active').find('i').attr('class', 'fa-solid fa-sort');
        $('.so-sortable[data-sort="' + sortKey + '"]')
            .addClass('is-active')
            .find('i')
            .attr('class', sortDir === 'asc' ? 'fa-solid fa-sort-up' : 'fa-solid fa-sort-down');

        const mobileVal = sortKey + '-' + sortDir;
        if ($('#soMobileSort option[value="' + mobileVal + '"]').length) {
            $('#soMobileSort').val(mobileVal);
        }
    }

    /* ---------------- FILTERING ---------------- */
    function applyFilters() {
        const search  = $('#soSearch').val().trim().toLowerCase();
        const shootOn = $('#soShootDate').val() || '';          // "2026-11-04"
        const orgId   = $('#soOrg').val() || '';                 // organization id
        const style   = $('#soStyle').val() || '';               // product category id
        // Order number box (phones only; always empty on desktop). "#002871" and "002871" both work.
        const orderNo = ($('#soOrderNo').val() || '').trim().replace(/^#/, '').toLowerCase();

        filtered = allRows.filter(function (row) {
            const d = row.dataset;

            if (search) {
                const haystack = (d.name + ' ' + d.order + ' #' + d.order + ' ' + d.org + ' ' + (d.styleNames || '') + ' ' + (d.tags || '')).toLowerCase();
                if (haystack.indexOf(search) === -1) return false;
            }
            // Shoot date: match ANY shoot the item belongs to
            if (shootOn && (d.shootDates || '').split('|').indexOf(shootOn) === -1) return false;
            if (orgId && d.orgId !== orgId) return false;
            if (style && (d.styles || '').split('|').indexOf(style) === -1) return false;
            if (orderNo && String(d.order || '').toLowerCase().indexOf(orderNo) === -1) return false;

            return true;
        });

        page = 1;
        render();
    }

    /* ---------------- PAGINATION ---------------- */
    function pageList(current, total) {
        if (total <= 7) {
            return Array.from({ length: total }, function (_, i) { return i + 1; });
        }
        if (current <= 4)         return [1, 2, 3, 4, 5, '…', total];
        if (current >= total - 3) return [1, '…', total - 4, total - 3, total - 2, total - 1, total];
        return [1, '…', current - 1, current, current + 1, '…', total];
    }

    function renderPagination(totalPages) {
        let html = '<button type="button" class="so-page-btn" data-page="prev"' + (page === 1 ? ' disabled' : '') + '>Previous</button>';

        pageList(page, totalPages).forEach(function (p) {
            if (p === '…') {
                html += '<span class="so-ellipsis">…</span>';
            } else {
                html += '<button type="button" class="so-page-btn' + (p === page ? ' active' : '') + '" data-page="' + p + '">' + p + '</button>';
            }
        });

        html += '<button type="button" class="so-page-btn" data-page="next"' + (page === totalPages ? ' disabled' : '') + '>Next</button>';

        $pagination.html(html);
    }

    /* ---------------- RENDER ---------------- */
    function render() {
        const total      = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        page = Math.min(Math.max(page, 1), totalPages);

        const start   = (page - 1) * PER_PAGE;
        const end     = Math.min(start + PER_PAGE, total);
        const visible = filtered.slice(start, end);

        $(allRows).addClass('so-hidden');
        $(visible).removeClass('so-hidden');

        if (total === 0) {
            $('#soEmptyText').text(allRows.length === 0 ? 'No studio items yet.' : 'No studio items match your filters.');
            $empty.removeClass('so-hidden');
            $info.text('No studio items found');
            $pagination.empty();
        } else {
            $empty.addClass('so-hidden');
            $info.text('Showing ' + (start + 1) + '–' + end + ' of ' + total + ' Studio Items');
            renderPagination(totalPages);
        }

        syncCheckboxes();
    }

    /* ---------------- SELECTION ---------------- */
    function visibleRows() {
        return $tbody.find('tr.so-row:not(.so-hidden)');
    }

    // Make the checkboxes, row highlight and selection bar match the "selected" set
    function syncCheckboxes() {
        $(allRows).each(function () {
            const isSel = selected.has(this.dataset.id);
            $(this).toggleClass('is-selected', isSel)
                   .find('.so-row-check').prop('checked', isSel);
        });

        const $visible  = visibleRows();
        const onPage    = $visible.filter('.is-selected').length;
        const pageTotal = $visible.length;

        $('.so-select-all')
            .prop('checked', pageTotal > 0 && onPage === pageTotal)
            .prop('indeterminate', onPage > 0 && onPage < pageTotal);

        updateSelectionBar(onPage);
    }

    function updateSelectionBar(onPage) {
        const count = selected.size;

        // Phones: "N selected" pill in the Select All card + room for the floating panel
        $('#soMobileSelCount').text(count + ' selected');
        $('.so-page').toggleClass('has-selection', count > 0);

        if (count === 0) {
            $selBar.removeClass('is-visible');
            return;
        }

        const word = count === 1 ? 'item' : 'items';
        $('#soSelTitle').text(count + ' ' + word + ' selected');
        $('#soSelSub').text(onPage + ' on this page. Actions apply to all ' + count + ' selected ' + word + '.');

        // A kit needs 2 or more items
        $('#soCreateKit').prop('disabled', count < 2);

        $selBar.addClass('is-visible');
    }

    $tbody.on('change', '.so-row-check', function () {
        const id = $(this).closest('tr').attr('data-id');
        if (this.checked) selected.add(id); else selected.delete(id);
        syncCheckboxes();
    });

    $(document).on('change', '.so-select-all', function () {
        const checked = this.checked;
        visibleRows().each(function () {
            if (checked) selected.add(this.dataset.id); else selected.delete(this.dataset.id);
        });
        syncCheckboxes();
    });

    $('#soClearSelection').on('click', function () {
        selected.clear();
        syncCheckboxes();
    });

    // Selected rows' details (use these ids in your AJAX calls)
    function getSelectedItems() {
        return allRows
            .filter(function (row) { return selected.has(row.dataset.id); })
            .map(function (row) {
                return { id: row.dataset.id, name: row.dataset.name, order: row.dataset.order, exp: row.dataset.exp || '' };
            });
    }

    /* =====================================================
       HELPERS
       ===================================================== */
    function esc(value) {
        return $('<div>').text(value == null ? '' : String(value)).html();
    }

    function todayISO() {
        const d = new Date();
        return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
    }

    // "2026-11-12" -> "Nov 12, 2026"
    function formatDate(iso) {
        if (!iso) return '—';
        const p = iso.split('-');
        const d = new Date(+p[0], +p[1] - 1, +p[2]);
        return d.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
    }

    function plural(n, word) {
        return n + ' ' + word + (n === 1 ? '' : 's');
    }

    let toastTimer = null;
    function showToast(message, isError) {
        const $toast = $('#soToast');
        $toast.toggleClass('is-error', !!isError)
              .find('i').attr('class', isError ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check');
        $toast.find('[data-role="text"]').text(message);
        $toast.addClass('is-visible');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { $toast.removeClass('is-visible'); }, isError ? 6000 : 3000);   // errors stay longer
    }

    /* =====================================================
       API  (talks to StudioOrderController)
       -----------------------------------------------------
       Every function returns a Promise.
       On success it resolves with the saved kit / shoot.
       On error it rejects with the jQuery XHR (so we can
       read Laravel validation errors).
       ===================================================== */
    const STUDIO_ROUTES = {
        kitStore:     @json(route('studio.kits.store')),
        kitItems:     @json(route('studio.kits.items', ['kit' => '__ID__'])),
        kitDelete:    @json(route('studio.kits.destroy', ['kit' => '__ID__'])),
        shootStore:   @json(route('studio.shoots.store')),
        shootItems:   @json(route('studio.shoots.items', ['shoot' => '__ID__'])),
        shootDelete:  @json(route('studio.shoots.destroy', ['shoot' => '__ID__'])),
    };

    function routeFor(name, id) {
        return STUDIO_ROUTES[name].replace('__ID__', encodeURIComponent(id));
    }

    function request(method, url, data) {
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

    function itemIds(items) {
        return items.map(function (i) { return parseInt(i.id, 10); });
    }

    const studioApi = {
        createKit: function (data, items) {
            return request('POST', routeFor('kitStore'), { kit_name: data.name, item_ids: itemIds(items) })
                .then(function (res) { return res.kit; });
        },
        addToKit: function (kit, items) {
            return request('POST', routeFor('kitItems', kit.id), { item_ids: itemIds(items) })
                .then(function (res) { return res.kit; });
        },
        deleteKit: function (kit) {
            return request('DELETE', routeFor('kitDelete', kit.id));
        },

        createShoot: function (data, items) {
            return request('POST', routeFor('shootStore'), {
                shoot_name: data.name,
                shoot_date: data.date,
                item_ids: itemIds(items),
            }).then(function (res) { return res.shoot; });
        },
        addToShoot: function (shoot, items) {
            return request('POST', routeFor('shootItems', shoot.id), { item_ids: itemIds(items) })
                .then(function (res) { return res.shoot; });
        },
        deleteShoot: function (shoot) {
            return request('DELETE', routeFor('shootDelete', shoot.id));
        },
    };

    // Saved kits / shoots from the controller
    const initialKits   = @json($kits);
    const initialShoots = @json($shoots);

    // Read a nice message from a failed request
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

    /* =====================================================
       SHARED MODAL (used by both Kit and Shoot modals)
       ===================================================== */
    function createPickerModal(cfg) {
        const $m       = $(cfg.el);
        const $form    = $m.find('[data-role="form"]');
        const $submit  = $m.find('[data-role="submit"]');
        const $list    = $m.find('[data-role="list"]');
        const $search  = $m.find('[data-role="search"]');
        const $count   = $m.find('[data-role="count"]');

        let records    = cfg.records;   // existing kits / shoots
        let items      = [];            // selected studio items
        let tab        = 'new';
        let chosenId   = null;
        let busy       = false;
        let lastFocus  = null;

        /* ---------- tabs ---------- */
        function setTab(name) {
            tab = name;
            $m.find('.so-tab').each(function () {
                const active = this.dataset.tab === name;
                $(this).toggleClass('is-active', active).attr('aria-selected', active);
            });
            $m.find('.so-tab-panel').each(function () {
                $(this).toggleClass('is-active', this.dataset.panel === name);
            });

            if (name === 'existing') renderList();
            updateFooter();
            updateNote();

            setTimeout(function () {
                (name === 'new' ? $form.find('.so-input').first() : $search).trigger('focus');
            }, 50);
        }

        function updateFooter() {
            if (busy) return;
            if (tab === 'new') {
                $submit.text(cfg.labels.create).prop('disabled', false);
            } else {
                $submit.text(cfg.labels.addTo).prop('disabled', !chosenId);
            }
        }

        // Optional note above the tabs (shoot: kit items that will be skipped)
        function targetDate() {
            if (tab === 'new') return $form.find('[name="date"]').val() || '';
            const r = findRecord(chosenId);
            return r ? (r.date || '') : '';
        }
        function currentItems() {
            return cfg.expand ? cfg.expand(items) : items;
        }

        function renderSelected() {
            const list = currentItems();
            $m.find('[data-role="subtitle"]').text(cfg.text.subtitle(list.length));

            // Selected item chips (first 4 + "+N more"); kit items get a kit icon
            const chips = list.slice(0, 4).map(function (i) {
                const kit = i.fromKit ? ' so-chip-kit' : '';
                const title = i.fromKit ? i.name + ' (from kit ' + i.kitName + ')' : i.name;
                return '<span class="so-chip' + kit + '" title="' + esc(title) + '">' +
                           (i.fromKit ? '<i class="fa-solid fa-layer-group"></i>' : '') +
                           '<b>#' + esc(i.order) + '</b> ' + esc(i.name) + '</span>';
            });
            if (list.length > 4) chips.push('<span class="so-chip so-chip-more">+' + (list.length - 4) + ' more</span>');
            $m.find('[data-role="selected"]').html(chips.join(''));
        }

        function updateNote() {
            if (!cfg.note) return;
            const html = cfg.note(currentItems(), targetDate(), tab);
            $m.find('[data-role="note"]').html(html || '').prop('hidden', !html);
        }

        function setBusy(state) {
            busy = state;
            $submit.prop('disabled', state);
            if (state) {
                $submit.html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');
            } else {
                updateFooter();
            }
        }

        /* ---------- existing list ---------- */
        function renderCount() {
            $count.text(records.length);
        }

        function renderList() {
            const q = ($search.val() || '').trim().toLowerCase();
            const list = records.filter(function (r) { return cfg.matches(r, q); });

            if (!records.length) {
                $list.html(
                    '<div class="so-list-empty">' +
                        '<i class="' + cfg.emptyIcon + '"></i>' +
                        esc(cfg.text.empty) +
                        '<div><button type="button" class="so-link-btn" data-action="go-new">+ ' + esc(cfg.labels.create) + '</button></div>' +
                    '</div>'
                );
                return;
            }

            if (!list.length) {
                $list.html('<div class="so-list-empty"><i class="fa-solid fa-magnifying-glass"></i>No results for “' + esc(q) + '”.</div>');
                return;
            }

            $list.html(list.map(function (r) {
                const isSel   = String(r.id) === String(chosenId);
                const blocked = cfg.blockReason ? cfg.blockReason(r, items) : '';
                return (
                    '<div class="so-pick' + (isSel ? ' is-selected' : '') + (blocked ? ' is-blocked' : '') + '" data-id="' + esc(r.id) + '"' + (blocked ? ' aria-disabled="true"' : '') + '>' +
                        '<input type="radio" name="' + cfg.radioName + '" value="' + esc(r.id) + '"' + (isSel ? ' checked' : '') + (blocked ? ' disabled' : '') + ' aria-label="Select ' + esc(r.name) + '">' +
                        '<div class="so-pick-main">' +
                            '<div class="so-pick-name" title="' + esc(r.name) + '">' + esc(r.name) + '</div>' +
                            '<div class="so-pick-meta">' + cfg.renderMeta(r) +
                                (blocked ? '<span class="so-pick-reason"><i class="fa-solid fa-triangle-exclamation"></i>' + esc(blocked) + '</span>' : '') +
                            '</div>' +
                        '</div>' +
                        '<button type="button" class="so-pick-delete" data-action="delete" title="Delete ' + esc(cfg.noun) + '" aria-label="Delete ' + esc(r.name) + '">' +
                            '<i class="fa-regular fa-trash-can"></i>' +
                        '</button>' +
                        '<div class="so-pick-confirm">' +
                            '<div class="so-pick-confirm-text">Delete <b>' + esc(r.name) + '</b>? This cannot be undone.</div>' +
                            '<div class="so-pick-confirm-actions">' +
                                '<button type="button" class="so-btn so-btn-outline" data-action="cancel-delete">Cancel</button>' +
                                '<button type="button" class="so-btn so-btn-danger" data-action="confirm-delete">Delete</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
                );
            }).join(''));
        }

        function findRecord(id) {
            return records.find(function (r) { return String(r.id) === String(id); });
        }

        /* ---------- form ---------- */
        function readForm() {
            const data = {};
            $form.serializeArray().forEach(function (f) { data[f.name] = $.trim(f.value); });
            return data;
        }

        function clearErrors() {
            $form.find('.so-input').removeClass('is-invalid');
            $form.find('.so-form-error').removeClass('is-visible').text('');
        }

        function showErrors(errors) {
            clearErrors();
            let first = null;
            Object.keys(errors).forEach(function (field) {
                const $input = $form.find('[name="' + field + '"]');
                $input.addClass('is-invalid');
                $form.find('[data-error="' + field + '"]').text(errors[field]).addClass('is-visible');
                if (!first) first = $input;
            });
            if (first) first.trigger('focus');
        }

        /* ---------- open / close ---------- */
        function open(selectedItems) {
            items     = selectedItems;
            chosenId  = null;
            busy      = false;
            lastFocus = document.activeElement;

            $form[0].reset();
            clearErrors();
            $search.val('');
            if (cfg.onOpen) cfg.onOpen($form, items);

            renderSelected();

            renderCount();
            $m.addClass('is-open').attr('aria-hidden', 'false');
            $('body').addClass('so-modal-open');
            setTab('new');
        }

        function close() {
            if (busy) return;
            $m.removeClass('is-open').attr('aria-hidden', 'true');
            $m.find('.so-pick.is-confirming').removeClass('is-confirming');
            if (!$('.so-modal.is-open').length) $('body').removeClass('so-modal-open');
            if (lastFocus && lastFocus.focus) lastFocus.focus();
        }

        function isOpen() {
            return $m.hasClass('is-open');
        }

        /* ---------- submit ---------- */
        function submit() {
            if (busy) return;

            if (tab === 'new') {
                const data   = readForm();
                const errors = cfg.validate(data, records, items);
                if (Object.keys(errors).length) { showErrors(errors); return; }

                // Shoot: leave out kit items that are not ex factory by this date
                let sendItems = currentItems();
                if (cfg.prepare) {
                    const p = cfg.prepare(sendItems, data.date);
                    if (p.error) { showToast(p.error, true); return; }
                    sendItems = p.items;
                }

                setBusy(true);
                cfg.api.create(data, sendItems).then(function (record) {
                    records.unshift(record);
                    renderCount();
                    setBusy(false);
                    close();
                    showToast(cfg.text.created(record, sendItems.length));
                    if (cfg.onChange) cfg.onChange();
                    if (cfg.onDone) cfg.onDone();
                }).catch(function (xhr) {
                    setBusy(false);
                    handleError(xhr);
                });
            } else {
                const record = findRecord(chosenId);
                if (!record) return;
                if (cfg.blockReason && cfg.blockReason(record, items)) return;

                let sendItems = currentItems();
                if (cfg.prepare) {
                    const p = cfg.prepare(sendItems, record.date);
                    if (p.error) { showToast(p.error, true); return; }
                    sendItems = p.items;
                }

                setBusy(true);
                cfg.api.addTo(record, sendItems).then(function (updated) {
                    if (updated) Object.assign(record, updated);   // new item_ids / item_count from the server
                    setBusy(false);
                    close();
                    showToast(cfg.text.added(record, sendItems.length));
                    if (cfg.onChange) cfg.onChange();
                    if (cfg.onDone) cfg.onDone();
                }).catch(function (xhr) {
                    setBusy(false);
                    handleError(xhr);
                });
            }
        }

        
        function handleError(xhr) {
            const errors = xhr && xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors;

            if (errors && tab === 'new') {
                const fieldErrors = {};
                Object.keys(errors).forEach(function (key) {
                    const field = cfg.fieldMap[key];          
                    if (field) fieldErrors[field] = errors[key][0];
                });
                if (Object.keys(fieldErrors).length) {
                    showErrors(fieldErrors);
                    return;
                }
            }

            showToast(errorMessage(xhr), true);
        }

        /* ---------- events ---------- */
        $m.on('click', '[data-close]', close);

        $m.on('click', '.so-tab', function () {
            if (!busy) setTab(this.dataset.tab);
        });

        $submit.on('click', submit);

        $form.on('submit', function (e) { e.preventDefault(); submit(); });
        $form.on('keydown', '.so-input', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); submit(); }
        });

        // Remove the error as soon as the user types
        $form.on('input change', '.so-input', function () {
            $(this).removeClass('is-invalid');
            $form.find('[data-error="' + this.name + '"]').removeClass('is-visible').text('');
            if (this.name === 'date') updateNote();
        });

        $search.on('input', renderList);

        // Select a record
        $list.on('click', '.so-pick', function (e) {
            if ($(this).hasClass('is-confirming') || $(e.target).closest('[data-action]').length) return;
            if ($(this).hasClass('is-blocked')) return;   
            chosenId = this.dataset.id;
            $list.find('.so-pick').removeClass('is-selected');
            $(this).addClass('is-selected').find('input[type="radio"]').prop('checked', true);
            updateFooter();
            updateNote();
        });

        $list.on('click', '[data-action="go-new"]', function () { setTab('new'); });

        // Delete: step 1 -> ask
        $list.on('click', '[data-action="delete"]', function (e) {
            e.stopPropagation();
            $list.find('.so-pick.is-confirming').removeClass('is-confirming');
            $(this).closest('.so-pick').addClass('is-confirming');
        });

        $list.on('click', '[data-action="cancel-delete"]', function (e) {
            e.stopPropagation();
            $(this).closest('.so-pick').removeClass('is-confirming');
        });

        // Delete: step 2 -> confirmed
        $list.on('click', '[data-action="confirm-delete"]', function (e) {
            e.stopPropagation();
            const $row   = $(this).closest('.so-pick');
            const record = findRecord($row.data('id'));
            if (!record) return;

            const $btn = $(this).prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');

            cfg.api.remove(record).then(function () {
                records = records.filter(function (r) { return r !== record; });
                if (String(chosenId) === String(record.id)) chosenId = null;
                renderCount();
                renderList();
                updateFooter();
                showToast(cfg.text.deleted(record));
                if (cfg.onChange) cfg.onChange();
            }).catch(function (xhr) {
                $btn.prop('disabled', false).text('Delete');
                showToast(errorMessage(xhr, 'Could not delete. Please try again.'), true);
            });
        });

        return {
            open: open,
            close: close,
            isOpen: isOpen,
            getRecords: function () { return records; },
            refresh: function () { renderSelected(); updateNote(); },   // after the kit choice changes
        };
    }

    /* =====================================================
       KIT MODAL
       ===================================================== */
    const kitModal = createPickerModal({
        el: '#soKitModal',
        noun: 'kit',
        radioName: 'so_kit_pick',
        records: initialKits,
        fieldMap: { kit_name: 'name' },
        emptyIcon: 'fa-solid fa-boxes-stacked',
        labels: { create: 'Create Kit', addTo: 'Add to Kit' },
        api: { create: studioApi.createKit, addTo: studioApi.addToKit, remove: studioApi.deleteKit },
        text: {
            subtitle: function (n) { return 'Group ' + plural(n, 'selected item') + ' into a kit.'; },
            empty:    'No kits created yet.',
            created:  function (r, n) { return 'Kit "' + r.name + '" created with ' + plural(n, 'item') + '.'; },
            added:    function (r, n) { return plural(n, 'item') + ' added to "' + r.name + '".'; },
            deleted:  function (r) { return 'Kit "' + r.name + '" deleted.'; },
        },
        matches: function (r, q) {
            return !q || r.name.toLowerCase().indexOf(q) !== -1;
        },
        renderMeta: function (r) {
            return '<span><i class="fa-solid fa-shirt"></i>' + plural(r.item_count, 'item') + '</span>' +
                   '<span><i class="fa-regular fa-clock"></i>Created ' + esc(formatDate(r.created_at)) + '</span>';
        },
        validate: function (data, records) {
            const errors = {};
            if (!data.name) {
                errors.name = 'Please enter a kit name.';
            } else if (data.name.length < 3) {
                errors.name = 'Kit name must be at least 3 characters.';
            } else if (records.some(function (r) { return r.name.toLowerCase() === data.name.toLowerCase(); })) {
                errors.name = 'A kit with this name already exists. Use the "Existing Kits" tab to add to it.';
            }
            return errors;
        },
        onChange: function () { renderItemTags(); refreshTable(); },
        onDone: function () {
            selected.clear();
            syncCheckboxes();
        },
    });

    /* =====================================================
       SHOOT MODAL
       ===================================================== */
    const shootModal = createPickerModal({
        el: '#soShootModal',
        noun: 'shoot',
        radioName: 'so_shoot_pick',
        records: initialShoots,
        fieldMap: { shoot_name: 'name', shoot_date: 'date' },
        emptyIcon: 'fa-solid fa-camera',
        labels: { create: 'Create Shoot', addTo: 'Add to Shoot' },
        api: { create: studioApi.createShoot, addTo: studioApi.addToShoot, remove: studioApi.deleteShoot },
        text: {
            subtitle: function (n) { return 'Plan a photo shoot for ' + plural(n, 'item') + '.'; },
            empty:    'No shoots scheduled yet.',
            created:  function (r, n) { return 'Shoot "' + r.name + '" scheduled for ' + formatDate(r.date) + '.'; },
            added:    function (r, n) { return plural(n, 'item') + ' added to "' + r.name + '".'; },
            deleted:  function (r) { return 'Shoot "' + r.name + '" deleted.'; },
        },
        expand: function (items) { return kitBox.finalItems(items); },
        onOpen: function ($form, items) {
            kitBox.setup(items);   

            // Shoot date: not in the past, and not before the latest ex factory date of the selected items
            const latest = latestExFactory(items);
            const min = latest && latest.exp > todayISO() ? latest.exp : todayISO();
            $form.find('[name="date"]').attr('min', min);
            $('#soShootDateHint').html(latest
                ? 'Earliest possible date: <b>' + esc(formatDate(latest.exp)) + '</b> (“' + esc(latest.name) + '” is ex factory on that day)'
                : '');
        },
        blockReason: function (r, items) {
            const latest = latestExFactory(items);
            return latest && r.date && r.date < latest.exp
                ? 'Too early: “' + latest.name + '” is ex factory on ' + formatDate(latest.exp)
                : '';
        },
        prepare: function (items, date) {
            // Kit items (added with "Also add items from kits") that are not ex factory by the shoot date are skipped
            const skipped = items.filter(function (i) { return i.fromKit && i.exp && date && i.exp > date; });
            const kept    = items.filter(function (i) { return skipped.indexOf(i) === -1; });
            if (!kept.length) return { error: 'None of these items are ex factory by ' + formatDate(date) + '. Please pick a later date.' };
            return { items: kept, skipped: skipped };
        },
        note: function (items, date) {
            const kitItems = items.filter(function (i) { return i.fromKit; });
            if (!kitItems.length) return '';
            if (!date) {
                return '<i class="fa-solid fa-circle-info"></i><div>' + plural(kitItems.length, 'kit item') +
                       ' added. Kit items with an ex factory date after the shoot date will be skipped.</div>';
            }
            const skipped = kitItems.filter(function (i) { return i.exp && i.exp > date; });
            if (!skipped.length) return '';
            return '<i class="fa-solid fa-triangle-exclamation"></i><div><b>' + plural(skipped.length, 'kit item') +
                   ' will be skipped</b> – not ex factory by ' + esc(formatDate(date)) + ':<ul>' +
                   skipped.map(function (i) {
                       return '<li>' + esc(i.name) + ' <span style="opacity:.8">(' + esc(i.kitName) + ') – ex factory ' + esc(formatDate(i.exp)) + '</span></li>';
                   }).join('') + '</ul></div>';
        },
        matches: function (r, q) {
            return !q || r.name.toLowerCase().indexOf(q) !== -1;
        },
        renderMeta: function (r) {
            const today = todayISO();
            let badge = '<span class="so-badge-soft so-badge-upcoming">Upcoming</span>';
            if (r.date === today)     badge = '<span class="so-badge-soft so-badge-today">Today</span>';
            else if (r.date < today)  badge = '<span class="so-badge-soft so-badge-past">Past</span>';

            return '<span><i class="fa-regular fa-calendar"></i>' + esc(formatDate(r.date)) + '</span>' +
                   badge +
                   '<span><i class="fa-solid fa-shirt"></i>' + plural(r.item_count, 'item') + '</span>';
        },
        validate: function (data, records, items) {
            const errors = {};
            if (!data.name)                    errors.name = 'Please enter a shoot name.';
            else if (data.name.length < 3)     errors.name = 'Shoot name must be at least 3 characters.';

            if (!data.date)                    errors.date = 'Please pick a shoot date.';
            else if (data.date < todayISO())   errors.date = 'Shoot date cannot be in the past.';
            else {
                const latest = latestExFactory(items || []);
                if (latest && data.date < latest.exp) {
                    errors.date = '“' + latest.name + '” is ex factory on ' + formatDate(latest.exp) + '. Pick that date or a later one.';
                }
            }

            return errors;
        },
        onChange: function () { renderItemTags(); refreshTable(); },
        onDone: function () {
            selected.clear();
            syncCheckboxes();
        },
    });

    /* =====================================================
       ITEM LABELS + SHOOT DATES IN THE TABLE
       -----------------------------------------------------
       Built from the kits / shoots lists, so they update
       right away after create / add / delete (no reload).
       ===================================================== */
    function renderItemTags() {
        const kits   = kitModal.getRecords();
        const shoots = shootModal.getRecords();

        // item id -> { kits: [], shoots: [] }
        const map = {};
        function bucket(id) {
            id = String(id);
            if (!map[id]) map[id] = { kits: [], shoots: [] };
            return map[id];
        }
        function add(list, record) {
            if (list.indexOf(record) === -1) list.push(record);   // never show the same label twice
        }
        kits.forEach(function (k)   { (k.item_ids || []).forEach(function (id) { add(bucket(id).kits, k); }); });
        shoots.forEach(function (s) { (s.item_ids || []).forEach(function (id) { add(bucket(id).shoots, s); }); });

        allRows.forEach(function (row) {
            const info = map[row.dataset.id] || { kits: [], shoots: [] };

            // Labels under the item name
            const html =
                info.kits.map(function (k) {
                    return '<span class="so-tag so-tag-kit" title="Kit: ' + esc(k.name) + '">' +
                               '<i class="fa-solid fa-boxes-stacked"></i><span>' + esc(k.name) + '</span></span>';
                }).join('') +
                info.shoots.map(function (s) {
                    return '<span class="so-tag so-tag-shoot" title="Shoot: ' + esc(s.name) + ' – ' + esc(formatDate(s.date)) + '">' +
                               '<i class="fa-solid fa-camera"></i><span>' + esc(s.name) + '</span></span>';
                }).join('');
            $(row).find('[data-role="tags"]').html(html);

            // Shoot Date = shoot schedule date (Created Date now comes from the order item, in the blade).
            // If the item is in more than one shoot, use the newest shoot.
            const shoot = info.shoots.reduce(function (latest, s) {
                return (!latest || s.id > latest.id) ? s : latest;
            }, null);

            const dash = '<span class="so-dash">—</span>';
            $(row).find('[data-role="shoot"]').html(shoot && shoot.date ? esc(formatDate(shoot.date)) : dash);

            // Used by search (and the "Upcoming Shoot" filter later)
            row.dataset.shoot = shoot ? shoot.date : '';

            // All shoot dates of this item (used by the "Upcoming Shoot" filter)
            row.dataset.shootDates = info.shoots.map(function (s) { return s.date; }).join('|');

            // Chat needs a shoot: the item's chat is a sub discussion of the shoot's discussion
            $(row).find('[data-role="chat"]')
                .toggleClass('is-disabled', !shoot)
                .attr('aria-disabled', shoot ? null : 'true')
                .attr('tabindex', shoot ? null : '-1')
                .attr('title', shoot ? 'Item chat' : 'Add this item to a shoot to start the chat');
            if (!shoot) $(row).find('[data-role="chat"] .so-chat-count').remove();   // shoot deleted = chat deleted

            // Kit used for grouping rows = newest kit (same as the first kit label)
            const groupKit = info.kits.reduce(function (newest, k) {
                return (!newest || k.id > newest.id) ? k : newest;
            }, null);
            row.dataset.kit = groupKit ? String(groupKit.id) : '';
            row.dataset.tags  = info.kits.map(function (k) { return k.name; })
                                    .concat(info.shoots.map(function (s) { return s.name; })).join(' ');
        });
    }

    renderItemTags();

    /* =====================================================
       ITEM CHAT  (studio_chat.blade.php)
       ===================================================== */
    function setChatCount($btn, n) {
        $btn.find('.so-chat-count').remove();
        if (n > 0) $btn.append('<span class="so-chat-count">' + (n > 99 ? '99+' : n) + '</span>');
    }

    $tbody.on('click', '[data-role="chat"]', function (e) {
        e.preventDefault();
        const $btn = $(this);
        if ($btn.hasClass('is-disabled') || !window.StudioChat) return;
        const row = $btn.closest('tr.so-row')[0];
        StudioChat.open({
            kind: 'item',
            id: $btn.data('id'),
            title: row ? row.dataset.name : '',
            onCount: function (n) { setChatCount($btn, n); },
        });
    });

    // Re-sort (so kit groups move together) but stay on the same page
    function refreshTable() {
        const currentPage = page;
        sortRows();
        applyFilters();          // this goes back to page 1...
        page = currentPage;      // ...so return to the page the user was on
        render();
    }

    /* =====================================================
       TECH PACK VIEWER
       ===================================================== */
    const $tpModal = $('#soTpModal');
    const $tpStage = $('#soTpStage');
    const $tpImg   = $('#soTpImg');
    let tpFiles = [];
    let tpIndex = 0;
    let tpLastFocus = null;

    function tpShow(index) {
        if (!tpFiles.length) return;
        tpIndex = Math.max(0, Math.min(index, tpFiles.length - 1));
        const file = tpFiles[tpIndex];

        $tpStage.removeClass('is-error').addClass('is-loading');
        $tpImg.attr({ src: file.url, alt: file.name || 'Tech pack image' });

        $('#soTpCounter').text((tpIndex + 1) + ' / ' + tpFiles.length);
        $('#soTpName').text(file.name || '').attr('title', file.name || '');
        $('#soTpOpen').attr('href', file.url);
        $('#soTpDownload').attr({ href: file.url, download: file.name || '' });

        $('#soTpPrev').prop('disabled', tpIndex === 0);
        $('#soTpNext').prop('disabled', tpIndex === tpFiles.length - 1);
        $('#soTpPrev, #soTpNext, #soTpCounter').toggleClass('so-hidden', tpFiles.length < 2);

        $('#soTpThumbs .so-tp-thumb').removeClass('is-active').eq(tpIndex).addClass('is-active')
            .each(function () { this.scrollIntoView({ block: 'nearest', inline: 'nearest' }); });
    }

    $tpImg.on('load', function () { $tpStage.removeClass('is-loading'); });
    $tpImg.on('error', function () { $tpStage.removeClass('is-loading').addClass('is-error'); });
    $tpImg.on('click', function () { window.open(this.src, '_blank', 'noopener'); });

    function tpOpen(files, title, order) {
        tpFiles = files;
        tpLastFocus = document.activeElement;

        $('#soTpTitle').text('Tech Pack');
        $('#soTpSub').text(title + (order ? '  ·  #' + order : '') + '  ·  ' + plural(files.length, 'image'));

        $('#soTpThumbs').html(files.length < 2 ? '' : files.map(function (f, i) {
            return '<button type="button" class="so-tp-thumb" data-index="' + i + '" aria-label="Show image ' + (i + 1) + '">' +
                       '<img src="' + esc(f.url) + '" alt="" loading="lazy" onerror="this.style.visibility=\'hidden\'">' +
                   '</button>';
        }).join(''));

        $tpModal.addClass('is-open').attr('aria-hidden', 'false');
        $('body').addClass('so-modal-open');
        tpShow(0);
        setTimeout(function () { $tpModal.find('.so-modal-close').trigger('focus'); }, 30);
    }

    function tpClose() {
        $tpModal.removeClass('is-open').attr('aria-hidden', 'true');
        $tpImg.attr('src', '');
        if (!$('.so-modal.is-open').length) $('body').removeClass('so-modal-open');
        if (tpLastFocus && tpLastFocus.focus) tpLastFocus.focus();
    }

    $tbody.on('click', '[data-role="techpack"]', function () {
        let files = [];
        try { files = JSON.parse(this.dataset.files || '[]'); } catch (e) { files = []; }
        if (!files.length) return;
        tpOpen(files, this.dataset.title || '', this.dataset.order || '');
    });

    $tpModal.on('click', '[data-close]', tpClose);
    $('#soTpPrev').on('click', function () { tpShow(tpIndex - 1); });
    $('#soTpNext').on('click', function () { tpShow(tpIndex + 1); });
    $('#soTpThumbs').on('click', '.so-tp-thumb', function () { tpShow(parseInt(this.dataset.index, 10)); });

    $(document).on('keydown', function (e) {
        if (!$tpModal.hasClass('is-open')) return;
        if (e.key === 'ArrowLeft')  { e.preventDefault(); tpShow(tpIndex - 1); }
        if (e.key === 'ArrowRight') { e.preventDefault(); tpShow(tpIndex + 1); }
        if (e.key === 'Escape')     { tpClose(); }
    });

    // Swipe left / right on phones
    let tpTouchX = null;
    $tpStage.on('touchstart', function (e) { tpTouchX = e.originalEvent.touches[0].clientX; });
    $tpStage.on('touchend', function (e) {
        if (tpTouchX === null) return;
        const dx = e.originalEvent.changedTouches[0].clientX - tpTouchX;
        if (Math.abs(dx) > 40) tpShow(tpIndex + (dx < 0 ? 1 : -1));
        tpTouchX = null;
    });

    /* ---------- open the modals from the selection bar ---------- */
    $('#soCreateKit').on('click', function () {
        if (selected.size < 2) return;
        kitModal.open(getSelectedItems());
    });

    // ONE item = ONE shoot: items already in a shoot cannot go into another shoot
    function itemsAlreadyInShoot(items) {
        const shoots = shootModal.getRecords();
        return items.map(function (item) {
            const shoot = shoots.find(function (s) {
                return (s.item_ids || []).map(String).indexOf(String(item.id)) !== -1;
            });
            return shoot ? { item: item, shoot: shoot } : null;
        }).filter(Boolean);
    }

    /* =====================================================
       EX FACTORY + KIT BOX
       ===================================================== */
    // The item with the latest ex factory date (only items the user selected; kit extras are skipped instead)
    function latestExFactory(items) {
        let best = null;
        items.forEach(function (i) {
            if (!i.fromKit && i.exp && (!best || i.exp > best.exp)) best = i;
        });
        return best;
    }

    function itemInfo(id) {
        const row = allRows.find(function (r) { return String(r.dataset.id) === String(id); });
        return row ? { id: row.dataset.id, name: row.dataset.name, order: row.dataset.order, exp: row.dataset.exp || '' } : null;
    }

    function shootOfItem(id) {
        return shootModal.getRecords().find(function (s) {
            return (s.item_ids || []).map(String).indexOf(String(id)) !== -1;
        }) || null;
    }

    /* ---------- Kit box inside the shoot popup ----------
     */
    const kitBox = (function () {
        const $box = $('#soShootModal [data-role="kitbox"]');
        let base = [], kits = [], mode = 'selected', ticked = {}, opened = {};

        function baseIds() { return base.map(function (i) { return String(i.id); }); }

        // Kits that contain a selected item AND have other items that were not selected
        function involvedKits(items) {
            const ids = items.map(function (i) { return String(i.id); });
            return kitModal.getRecords().filter(function (k) {
                const kitIds = (k.item_ids || []).map(String);
                return kitIds.some(function (id) { return ids.indexOf(id) !== -1; }) &&
                       kitIds.some(function (id) { return ids.indexOf(id) === -1 && itemInfo(id); });
            });
        }

        // Kit items that are not selected (and still exist on the page)
        function extraItems(k) {
            const sel = baseIds();
            return (k.item_ids || [])
                .filter(function (id) { return sel.indexOf(String(id)) === -1; })
                .map(itemInfo).filter(Boolean);
        }

        function finalItems(items) {
            const list = items.map(function (i) { return $.extend({}, i, { fromKit: false }); });
            if (mode !== 'kits') return list;

            const ids = list.map(function (i) { return String(i.id); });
            kits.forEach(function (k) {
                if (!ticked[k.id]) return;
                extraItems(k).forEach(function (info) {
                    if (ids.indexOf(String(info.id)) !== -1 || shootOfItem(info.id)) return;   // already in the list / in a shoot
                    list.push($.extend(info, { fromKit: true, kitName: k.name }));
                    ids.push(String(info.id));
                });
            });
            return list;
        }

        function kitItemsHtml(k) {
            const sel = baseIds();
            const added = finalItems(base);   // to know which kit really adds a shared item
            return '<ul class="so-kb-items">' + (k.item_ids || []).map(itemInfo).filter(Boolean).map(function (i) {
                const isSel = sel.indexOf(String(i.id)) !== -1;
                const shoot = isSel ? null : shootOfItem(i.id);
                const hit   = added.find(function (a) { return String(a.id) === String(i.id); });

                let status;
                if (isSel)                     status = '<span class="so-kb-status is-selected">Selected</span>';
                else if (shoot)                status = '<span class="so-kb-status is-skip" title="One item can be in only one shoot">In “' + esc(shoot.name) + '”</span>';
                else if (hit && hit.kitName === k.name) status = '<span class="so-kb-status is-add">+ Added</span>';
                else if (hit)                  status = '<span class="so-kb-status is-add" title="Already added from kit ' + esc(hit.kitName) + '">+ Added (via ' + esc(hit.kitName) + ')</span>';
                else                           status = '<span class="so-kb-status is-off">Not added</span>';

                return '<li class="so-kb-item"><span class="so-kb-item-name" title="' + esc(i.name) + '">' + esc(i.name) +
                           ' <small>#' + esc(i.order) + ' · Ex factory ' + esc(formatDate(i.exp)) + '</small></span>' + status + '</li>';
            }).join('') + '</ul>';
        }

        function render() {
            if (!kits.length) { $box.prop('hidden', true).empty(); return; }

            const selCount = base.length;
            const head = (selCount === 1 ? 'This item is in ' : 'Selected items are in ') + plural(kits.length, 'kit');

            let html =
                '<div class="so-kb-head"><i class="fa-solid fa-layer-group"></i>' + esc(head) + '</div>' +
                '<div class="so-kb-options" role="radiogroup" aria-label="Kit items">' +
                    '<label class="so-kb-option"><input type="radio" name="so_kb_mode" value="selected"' + (mode === 'selected' ? ' checked' : '') + '>' +
                        'Only the selected ' + (selCount === 1 ? 'item' : 'items') + ' <span>(' + selCount + ')</span></label>' +
                    '<label class="so-kb-option"><input type="radio" name="so_kb_mode" value="kits"' + (mode === 'kits' ? ' checked' : '') + '>' +
                        'Also add items from kits</label>' +
                '</div>';

            if (mode === 'kits') {
                html += '<div class="so-kb-list">' + kits.map(function (k) {
                    const extra = extraItems(k);
                    const taken = extra.filter(function (i) { return shootOfItem(i.id); }).length;
                    const plus  = extra.length - taken;
                    const isOpen = !!opened[k.id];

                    return '<div class="so-kb-kit' + (isOpen ? ' is-open' : '') + '" data-kit="' + esc(k.id) + '">' +
                               '<div class="so-kb-row">' +
                                   '<label><input type="checkbox" data-role="kit-tick"' + (ticked[k.id] ? ' checked' : '') + (plus ? '' : ' disabled') + '>' +
                                       '<span class="so-kb-name" title="' + esc(k.name) + '">' + esc(k.name) + '</span></label>' +
                                   '<span class="so-kb-plus' + (plus ? '' : ' is-zero') + '">+' + plural(plus, 'item') + '</span>' +
                                   (taken ? '<span class="so-kb-taken">(' + taken + ' already in a shoot)</span>' : '') +
                                   '<button type="button" class="so-kb-view" data-role="kit-view" aria-expanded="' + isOpen + '">View items <i class="fa-solid fa-chevron-down"></i></button>' +
                               '</div>' +
                               (isOpen ? kitItemsHtml(k) : '') +
                           '</div>';
                }).join('') + '</div>';

                const total = finalItems(base).length;
                html += '<div class="so-kb-foot">' +
                            '<button type="button" class="so-link-btn" data-role="kit-all">Select all</button><span aria-hidden="true">·</span>' +
                            '<button type="button" class="so-link-btn" data-role="kit-clear">Clear</button>' +
                            '<span class="so-kb-total"><b>' + total + '</b> ' + (total === 1 ? 'item' : 'items') + ' will go to the shoot</span>' +
                        '</div>';
            }

            $box.html(html).prop('hidden', false);
        }

        function changed() {
            render();
            shootModal.refresh();
        }

        // Called every time the shoot popup opens
        function setup(items) {
            base = items; kits = involvedKits(items);
            mode = 'selected';                       
            ticked = {}; opened = {};
            kits.forEach(function (k) { ticked[k.id] = true; });   
            render();
        }

        $box.on('change', 'input[name="so_kb_mode"]', function () {
            mode = this.value;
            changed();
            $box.find('input[name="so_kb_mode"]:checked').trigger('focus');
        });
        $box.on('change', '[data-role="kit-tick"]', function () {
            ticked[$(this).closest('.so-kb-kit').data('kit')] = this.checked;
            const id = $(this).closest('.so-kb-kit').data('kit');
            changed();
            $box.find('.so-kb-kit[data-kit="' + id + '"] [data-role="kit-tick"]').trigger('focus');
        });
        $box.on('click', '[data-role="kit-view"]', function () {
            const id = $(this).closest('.so-kb-kit').data('kit');
            opened[id] = !opened[id];
            render();
            $box.find('.so-kb-kit[data-kit="' + id + '"] [data-role="kit-view"]').trigger('focus');
        });
        $box.on('click', '[data-role="kit-all"]', function () {
            kits.forEach(function (k) { ticked[k.id] = true; });
            changed();
        });
        $box.on('click', '[data-role="kit-clear"]', function () {
            ticked = {};
            changed();
        });

        return { setup: setup, finalItems: finalItems };
    })();

    $('#soCreateShoot').on('click', function () {
        if (selected.size < 1) return;
        const items = getSelectedItems();
        const taken = itemsAlreadyInShoot(items);
        if (taken.length) {
            const first = taken[0];
            const more  = taken.length - 1;
            showToast(
                '"' + first.item.name + '" is already in shoot "' + first.shoot.name + '"' +
                (more ? ' (and ' + plural(more, 'more selected item') + ')' : '') +
                '. One item can be in only one shoot. Unselect it, or remove it from that shoot first.',
                true
            );
            return;
        }

        shootModal.open(items);   
    });

    // Esc closes the open modal
    $(document).on('keydown', function (e) {
        if (e.key !== 'Escape') return;
        if (kitModal.isOpen())   kitModal.close();
        if (shootModal.isOpen()) shootModal.close();
    });

    /* ---------------- OTHER EVENTS ---------------- */

    $('.so-sortable').on('click', function () {
        const key = $(this).data('sort');
        if (sortKey === key) {
            sortDir = sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            sortKey = key;
            sortDir = (key === 'order' || key === 'created') ? 'desc' : 'asc';
        }
        sortRows();
        applyFilters();
    });

    $('#soMobileSort').on('change', function () {
        const parts = this.value.split('-');
        sortKey = parts[0];
        sortDir = parts[1];
        sortRows();
        applyFilters();
    });

    let searchTimer = null;
    $('#soSearch').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(applyFilters, 250);
    });

    /* ---------------- PHONES (Figma mobile layout) ---------------- */
    const phoneQuery = window.matchMedia('(max-width: 767.98px)');
    function isPhone() { return phoneQuery.matches; }

    const $filters      = $('.so-filters');
    const $filterToggle = $('#soFilterToggle');

    function setFilterPanel(open) {
        $filters.toggleClass('is-open', open);
        $filterToggle.attr('aria-expanded', open ? 'true' : 'false');
    }

    // "Filters" button opens / closes the filter panel
    $filterToggle.on('click', function () {
        setFilterPanel(!$filters.hasClass('is-open'));
    });

    // Open / close the details of one item card
    $tbody.on('click', '[data-role="row-toggle"]', function () {
        const $row = $(this).closest('tr.so-row');
        const open = !$row.hasClass('is-open');
        const name = $row.attr('data-name') || '';
        $row.toggleClass('is-open', open);
        $(this).attr('aria-expanded', open ? 'true' : 'false')
               .attr('aria-label', (open ? 'Hide details for ' : 'Show details for ') + name);
    });

    $('#soApply').on('click', function () {
        applyFilters();
        if (isPhone()) setFilterPanel(false);    // phones: close the panel so the results are visible
    });

    // Order number box: filter while typing (like the search box), Enter applies at once
    $('#soOrderNo').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(applyFilters, 250);
    }).on('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); applyFilters(); }
    });

    /* "Upcoming Shoot": text box with a placeholder that turns into a date picker.
       On phones it has a label, so it is always a date picker (mm/dd/yyyy). */
    const $shootDate = $('#soShootDate');
    function shootDateType() {
        const el = $shootDate[0];
        if (!el || el.value) return;            
        el.type = isPhone() ? 'date' : 'text';
    }
    shootDateType();
    if (phoneQuery.addEventListener) phoneQuery.addEventListener('change', shootDateType);
    else if (phoneQuery.addListener) phoneQuery.addListener(shootDateType);

    $shootDate.on('focus', function () {
        if (this.type !== 'date') {
            this.type = 'date';
            try { if (this.showPicker) this.showPicker(); } catch (e) { /* some browsers block it, the user can click again */ }
        }
    });
    $shootDate.on('blur', function () {
        if (!this.value && !isPhone()) this.type = 'text';   
    });
    $shootDate.on('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); applyFilters(); }
    });

    // Product Style: grey text while nothing is chosen
    $('#soStyle').on('change', function () {
        $(this).toggleClass('is-placeholder', !this.value);
    });

    $('#soReset').on('click', function () {
        $('#soSearch, #soShootDate, #soOrderNo').val('');
        $shootDate.attr('type', isPhone() ? 'date' : 'text');
        $('#soStyle').val('').addClass('is-placeholder');
        $('#soOrg').val('').trigger('change');   // trigger so Select2 updates too
        sortKey = 'id';
        sortDir = 'desc';
        sortRows();
        applyFilters();
    });

    $pagination.on('click', '.so-page-btn', function () {
        if (this.disabled) return;
        const target = $(this).data('page');

        if (target === 'prev')      page--;
        else if (target === 'next') page++;
        else                        page = parseInt(target, 10);

        render();
        $('html, body').stop().animate({ scrollTop: $('.so-table-wrap').offset().top - 90 }, 250);
    });

    // Change rows per page -> stay near the first row the user was looking at
    $('#soPerPage').on('change', function () {
        const size = parseInt(this.value, 10);
        if (PER_PAGE_OPTIONS.indexOf(size) === -1) return;

        const firstRow = (page - 1) * PER_PAGE;
        PER_PAGE = size;
        page = Math.floor(firstRow / PER_PAGE) + 1;
        try { localStorage.setItem(PER_PAGE_KEY, String(size)); } catch (e) { /* ignore */ }

        render();
    });

    /* ---------------- IMAGE PREVIEW ---------------- */
    const $preview   = $('#soImgPreview');
    const $previewImg = $preview.find('img');
    const $caption   = $preview.find('.so-img-preview-caption');
    const $backdrop  = $('#soImgBackdrop');

    // true on phones / tablets that have no mouse hover
    const isTouch = window.matchMedia('(hover: none)').matches;

    function fillPreview(img) {
        $previewImg.attr({ src: img.src, alt: img.alt });
        $caption.text(img.dataset.caption || '');
    }

    // Place the popup next to the thumbnail, flip it if there is no space
    function positionPreview(img) {
        const gap  = 12;
        const rect = img.getBoundingClientRect();
        const w    = $preview.outerWidth();
        const h    = $preview.outerHeight();
        const vw   = window.innerWidth;
        const vh   = window.innerHeight;

        // Right side first, left side if it does not fit
        let left = rect.right + gap;
        if (left + w > vw - gap) left = rect.left - w - gap;
        if (left < gap) left = gap;

        // Vertically centered on the thumbnail, kept inside the screen
        let top = rect.top + rect.height / 2 - h / 2;
        top = Math.max(gap, Math.min(top, vh - h - gap));

        $preview.css({ left: left + 'px', top: top + 'px' });
    }

    function hidePreview() {
        $preview.removeClass('is-visible is-modal').css({ left: '', top: '' });
        $backdrop.removeClass('is-visible');
    }

    if (!isTouch) {
        // Desktop: show on hover
        $tbody.on('mouseenter', '.so-thumb-img', function () {
            fillPreview(this);
            $preview.addClass('is-visible');
            positionPreview(this);
        });

        $tbody.on('mouseleave', '.so-thumb-img', hidePreview);

        // Hide when the page or table scrolls (popup would be in the wrong place)
        $(window).on('scroll resize', hidePreview);
        $('.so-table-wrap').on('scroll', hidePreview);
    } else {
        // Mobile: tap the image to open, tap anywhere to close
        $tbody.on('click', '.so-thumb-img', function (e) {
            e.preventDefault();
            e.stopPropagation();
            fillPreview(this);
            $preview.addClass('is-visible is-modal');
            $backdrop.addClass('is-visible');
        });

        $backdrop.add($preview).on('click', hidePreview);
    }

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') hidePreview();
    });

    /* ---------------- INIT ---------------- */
    sortRows();
    applyFilters();
});
</script>
@endpush