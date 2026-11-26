@extends('layouts.app', ['activePage' => 'shoot_models', 'titlePage' => __('Add Model')])

@section('content')

<style>
    .mp-page {
        --mp-primary: #16a394;
        --mp-primary-dark: #12897c;
        --mp-accent: #f26b3a;          /* orange from the design */
        --mp-accent-soft: #fff1ea;
        --mp-danger: #e5484d;
        --mp-border: #e6e8eb;
        --mp-text: #1f2328;
        --mp-muted: #6b7280;
        --mp-bottom-gap: 110px;        /* space for the fixed world-clock bar */

        font-family: 'Open Sans', sans-serif;
        color: var(--mp-text);
        padding-top: 0 !important;
        padding-bottom: var(--mp-bottom-gap) !important;
    }
    .mp-page *, .mp-page *::before, .mp-page *::after { box-sizing: border-box; }
    .mp-hidden { display: none !important; }
    .mp-dash { color: #b4b9c0; }

    /* ---------- Cards ---------- */
    .mp-card { background: #fff; border: 1px solid var(--mp-border); border-radius: 10px; margin-bottom: 16px; }
    .mp-card-head {
        display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
        padding: 14px 18px; border-bottom: 1px solid var(--mp-border);
    }
    .mp-card-title { display: flex; align-items: center; gap: 10px; margin: 0; font-size: 14.5px; font-weight: 700; color: #1a1a1a; }
    .mp-card-title small { font-size: 11.5px; font-weight: 500; color: var(--mp-muted); }
    .mp-card-sub { display: block; margin-top: 1px; font-size: 11.5px; font-weight: 500; color: var(--mp-muted); }
    .mp-card-icon {
        width: 30px; height: 30px; border-radius: 7px; display: inline-flex; align-items: center; justify-content: center;
        color: var(--mp-accent); background: var(--mp-accent-soft); font-size: 13px; flex-shrink: 0;
    }
    .mp-card-body { padding: 16px 18px; }
    .mp-card-actions { display: flex; flex-wrap: wrap; gap: 8px; }

    .mp-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .mp-row > .mp-card { margin-bottom: 0; }
    .mp-row + .mp-row, .mp-row + .mp-card, .mp-card + .mp-row { margin-top: 16px; }

    /* ---------- Buttons / inputs ---------- */
    .mp-btn {
        height: 34px; display: inline-flex; align-items: center; justify-content: center; gap: 7px;
        padding: 0 13px; font-size: 12.5px; font-weight: 600; border-radius: 6px; border: 1px solid transparent;
        cursor: pointer; white-space: nowrap; text-decoration: none !important; font-family: inherit;
        transition: background .15s, border-color .15s, color .15s, box-shadow .15s;
    }
    .mp-btn-outline { background: #fff; border-color: #d6d9de; color: #374151 !important; }
    .mp-btn-outline:hover { background: #f5f6f7; }
    .mp-btn-primary { background: var(--mp-primary); color: #fff !important; }
    .mp-btn-primary:hover { background: var(--mp-primary-dark); }
    .mp-btn-accent { background: var(--mp-accent); color: #fff !important; }
    .mp-btn-accent:hover { background: #e2592a; }
    .mp-btn-danger { background: var(--mp-danger); color: #fff !important; }
    .mp-btn-danger:hover { background: #d13a40; }
    .mp-btn-sm { height: 30px; padding: 0 10px; font-size: 12px; }
    .mp-btn:disabled { opacity: .6; cursor: not-allowed; }

    .mp-icon-btn {
        width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid #e1e4e8; border-radius: 6px; background: #fff; color: #6b7280; cursor: pointer;
        font-size: 12px; transition: background .15s, color .15s, border-color .15s;
    }
    .mp-icon-btn:hover { background: #f5f6f7; color: #1f2328; }
    .mp-icon-btn.is-danger { color: var(--mp-danger); border-color: #f6cfd1; }
    .mp-icon-btn.is-danger:hover { background: #fdecee; }
    .mp-icon-btn.is-blue { color: #1d5fd0; border-color: #cfdcf5; }
    .mp-icon-btn.is-blue:hover { background: #eef4ff; }

    .mp-input {
        width: 100%; height: 36px; padding: 0 10px; font-size: 13px; color: var(--mp-text); font-family: inherit;
        background: #fff; border: 1px solid #d6d9de; border-radius: 6px; outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .mp-input::placeholder { color: #9aa0a6; }
    .mp-input:focus { border-color: var(--mp-primary); box-shadow: 0 0 0 3px rgba(22, 163, 148, .15); }
    .mp-input.is-invalid { border-color: var(--mp-danger); }
    textarea.mp-input { height: auto; min-height: 70px; padding: 8px 10px; resize: vertical; line-height: 1.45; }

    .mp-label { display: block; margin-bottom: 5px; font-size: 12px; font-weight: 700; color: #374151; }
    .mp-req { color: var(--mp-danger); }
    .mp-hint { margin-top: 4px; font-size: 11px; color: #9aa0a6; }
    .mp-error { margin-top: 4px; font-size: 11.5px; color: var(--mp-danger); display: none; }
    .mp-error.is-visible { display: block; }

    .mp-seg { display: inline-flex; padding: 3px; background: #f1f2f4; border-radius: 8px; gap: 3px; }
    .mp-seg button {
        height: 28px; padding: 0 12px; font-size: 12px; font-weight: 700; color: #4b5563;
        background: transparent; border: 0; border-radius: 6px; cursor: pointer; font-family: inherit;
    }
    .mp-seg button.is-active { background: #1f2328; color: #fff; }

    .mp-empty {
        padding: 18px 12px; text-align: center; font-size: 12.5px; color: var(--mp-muted);
        border: 1px dashed #dfe2e6; border-radius: 8px; background: #fcfcfd;
    }

    .mp-chip {
        display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px; font-size: 11.5px; font-weight: 700;
        border-radius: 999px; border: 1px solid transparent; white-space: nowrap;
    }
    .mp-chip-outline { color: #374151; background: #fff; border-color: #d6d9de; }
    .mp-chip-orange  { color: #c2410c; background: var(--mp-accent-soft); border-color: #fbd3c0; }
    .mp-chip-green   { color: #15803d; background: #eafaf0; border-color: #bfe8cd; }
    .mp-chip-grey    { color: #6b7280; background: #f1f2f4; }
    .mp-chip .mp-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    /* ---------- Model images (4 sides) ---------- */
    .mp-img-wrap { display: grid; grid-template-columns: 172px minmax(0, 1fr); gap: 14px; }
    .mp-side-list { display: flex; flex-direction: column; gap: 6px; }
    .mp-side {
        display: flex; align-items: center; justify-content: space-between; gap: 6px; padding: 6px 6px 6px 10px; min-width: 0;
        font-size: 12.5px; border-radius: 8px; cursor: pointer; border: 1px solid transparent; background: #fff;
        transition: background .15s;
    }
    .mp-side:hover { background: #f8f9fa; }
    .mp-side.is-active { background: #f1f2f4; border-color: #e6e8eb; font-weight: 600; }
    .mp-side-name { display: inline-flex; align-items: center; gap: 6px; min-width: 0; white-space: nowrap; }
    .mp-side-btns { display: inline-flex; gap: 4px; flex-shrink: 0; }
    .mp-side .mp-icon-btn { width: 26px; height: 26px; font-size: 11px; }
    .mp-side .mp-icon-btn:disabled { opacity: .35; cursor: not-allowed; background: #fff; }
    .mp-side-dot { width: 6px; height: 6px; border-radius: 50%; background: #16a34a; }

    .mp-img-preview { background: #f1f2f4; border-radius: 10px; padding: 10px; display: flex; flex-direction: column; min-height: 520px; }
    .mp-img-preview-title { margin-bottom: 8px; font-size: 12px; font-weight: 700; }
    .mp-img-frame {
        flex: 1; position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden;
        border: 2px dashed #d0d4d9; border-radius: 8px; background: #fff; min-height: 480px;
    }
    .mp-img-frame img { width: 100%; height: 100%; max-height: 620px; object-fit: contain; display: block; }
    .mp-img-drop { text-align: center; color: var(--mp-muted); font-size: 12.5px; padding: 18px; cursor: pointer; }
    .mp-img-drop i { display: block; margin-bottom: 8px; font-size: 26px; color: #c3c7cc; }
    .mp-img-frame.is-drag { border-color: var(--mp-primary); background: #f2fbf9; }

    /* ---------- Body measurements ---------- */
    .mp-measure-wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .mp-mtable { width: 100%; border-collapse: collapse; }
    .mp-mtable th {
        padding: 8px 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;
        color: var(--mp-muted); text-align: left; border-bottom: 1px solid var(--mp-border);
    }
    .mp-mtable td { padding: 8px 8px; font-size: 13px; border-bottom: 1px solid #f0f1f3; vertical-align: middle; }
    .mp-mtable tr { transition: background .15s; }
    .mp-mtable tbody tr { cursor: pointer; }
    .mp-mtable tbody tr:hover { background: #fafbfc; }
    .mp-mtable tbody tr.is-active { background: #fff6f1; }
    .mp-mno {
        width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;
        font-size: 10.5px; font-weight: 700; color: #fff; background: #1f2328; border-radius: 50%;
    }
    .mp-mtable tr.is-active .mp-mno { background: var(--mp-accent); }
    .mp-mname { font-weight: 600; }
    .mp-mval { font-weight: 700; font-size: 14px; }
    .mp-munit { font-size: 11.5px; color: #9aa0a6; }
    .mp-mtable .mp-input { height: 32px; width: 90px; padding: 0 8px; }
    .mp-mtable .mp-height-inputs { display: inline-flex; gap: 4px; }
    .mp-mtable .mp-height-inputs .mp-input { width: 56px; }

    .mp-mfoot {
        display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-top: 12px; padding: 10px 12px;
        font-size: 12px; color: var(--mp-muted); background: #f6f7f8; border-radius: 8px;
    }
    .mp-mfoot b { color: #1f2328; }

    .mp-diagram { display: flex; align-items: center; justify-content: center; }
    .mp-body-svg { width: 100%; height: auto; max-height: 640px; display: block; }
    .mp-body-svg .mp-guide { transition: stroke .15s, stroke-width .15s; }
    .mp-body-svg .mp-guide.is-active { stroke: var(--mp-accent); stroke-width: 2.6; }
    .mp-body-svg .mp-marker { cursor: pointer; outline: none; }
    .mp-body-svg .mp-marker > path:first-of-type { transition: fill .15s; }
    .mp-body-svg .mp-marker:hover > path:first-of-type,
    .mp-body-svg .mp-marker:focus-visible > path:first-of-type { fill: #3b4150; }
    .mp-body-svg .mp-marker.is-active > path:first-of-type { fill: var(--mp-accent); }

    /* ---------- Confirmation popup (delete / leave page) ---------- */
    body.mp-cmodal-open { overflow: hidden; }
    .mp-cmodal { position: fixed; inset: 0; z-index: 10080; display: none; align-items: center; justify-content: center; padding: 20px; }
    .mp-cmodal.is-open { display: flex; }
    .mp-cmodal-backdrop { position: absolute; inset: 0; background: rgba(15, 23, 42, .5); animation: mpFade .15s ease-out; }
    .mp-cmodal-box {
        position: relative; width: 100%; max-width: 400px; padding: 24px 24px 20px; text-align: center;
        background: #fff; border-radius: 12px; box-shadow: 0 24px 60px rgba(15, 23, 42, .3); animation: mpPop .18s ease-out;
    }
    .mp-cmodal-icon {
        width: 52px; height: 52px; margin: 0 auto 14px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 20px; color: var(--mp-danger); background: #fdecee;
    }
    .mp-cmodal.is-warn .mp-cmodal-icon { color: #a15c00; background: #fff6e0; }
    .mp-cmodal-title { margin: 0 0 6px; font-size: 17px; font-weight: 700; color: #1a1a1a; }
    .mp-cmodal-text { margin: 0; font-size: 13px; line-height: 1.55; color: #4b5563; overflow-wrap: anywhere; }
    .mp-cmodal-text b { color: #1f2328; }
    .mp-cmodal-btns { display: flex; gap: 10px; margin-top: 20px; }
    .mp-cmodal-btns .mp-btn { flex: 1; height: 40px; font-size: 13px; }
    .mp-cmodal-x { position: absolute; top: 10px; right: 10px; width: 30px; height: 30px; border: 0; border-radius: 6px; background: transparent; color: #9aa0a6; cursor: pointer; }
    .mp-cmodal-x:hover { background: #f1f2f4; color: #1f2328; }
    @keyframes mpFade { from { opacity: 0; } to { opacity: 1; } }
    @keyframes mpPop { from { opacity: 0; transform: translateY(10px) scale(.97); } to { opacity: 1; transform: none; } }

    /* ---------- Toast ---------- */
    .mp-toast {
        position: fixed; right: 20px; bottom: 80px; z-index: 10070; display: flex; align-items: center; gap: 10px;
        max-width: calc(100vw - 40px); padding: 12px 16px; font-size: 13px; color: #fff; background: #1f2937;
        border-radius: 8px; box-shadow: 0 10px 30px rgba(15, 23, 42, .25);
        opacity: 0; transform: translateY(10px); pointer-events: none; transition: opacity .2s, transform .2s;
    }
    .mp-toast.is-visible { opacity: 1; transform: none; }
    .mp-toast i { color: #34d399; }
    .mp-toast.is-error i { color: #f87171; }

    /* ---------- Responsive ---------- */
    @media (max-width: 1199.98px) {
        .mp-row { grid-template-columns: 1fr; }
        .mp-measure-wrap { grid-template-columns: 1fr; }
    }
    @media (max-width: 767.98px) {
        .mp-page { --mp-bottom-gap: 130px; }
        .mp-card-head { padding: 12px 14px; }
        .mp-card-body { padding: 14px; }
        .mp-img-wrap { grid-template-columns: 1fr; }
        .mp-img-preview { min-height: 360px; }
        .mp-img-frame { min-height: 320px; }
        .mp-mtable th:nth-child(4), .mp-mtable td:nth-child(4) { display: none; }   /* hide unit column on phones */
        .mp-cmodal { align-items: flex-end; padding: 0; }
        .mp-cmodal-box { max-width: none; border-radius: 16px 16px 0 0; padding-bottom: 28px; }
        .mp-toast { left: 16px; right: 16px; bottom: 140px; }
    }

    /* ---------- Print / PDF ---------- */
    @media print {
        .mp-no-print, .navbar, .sidenav, #sidenav-main, footer, .footer, #mobileScrollDownBtn { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; }
        .mp-page { padding: 0 !important; }
        .mp-card { break-inside: avoid; box-shadow: none; }
        .mp-row { grid-template-columns: 1fr 1fr; }
    }
</style>

<style>
    /* ---------- Header (same as the profile page) ---------- */
    .mp-hero {
        position: relative; display: flex; align-items: center; gap: 18px; padding: 18px 20px; margin-bottom: 16px;
        background: #fff; border: 1px solid var(--mp-border); border-radius: 10px; overflow: hidden;
    }
    .mp-hero::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: var(--mp-accent); }
    .mp-hero-photo { position: relative; flex-shrink: 0; }
    .mp-hero-avatar {
        width: 84px; height: 84px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center;
        font-size: 26px; font-weight: 700; color: #fff; box-shadow: 0 0 0 3px #fff, 0 0 0 5px #f6c9b4;
    }
    .mp-hero-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .mp-hero-cam {
        position: absolute; right: -2px; bottom: -2px; width: 28px; height: 28px; border-radius: 50%; border: 2px solid #fff;
        display: flex; align-items: center; justify-content: center; background: #1f2328; color: #fff; font-size: 11px; cursor: pointer;
    }
    .mp-hero-cam:hover { background: #374151; }
    .mp-hero-main { flex: 1; min-width: 0; }
    .mp-hero-name { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; margin: 0; font-size: 22px; font-weight: 700; color: #1a1a1a; }
    .mp-hero-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
    .mp-hero-org { margin-top: 8px; font-size: 12px; color: var(--mp-muted); }
    .mp-hero-actions { display: flex; flex-wrap: wrap; gap: 8px; align-self: flex-start; }
    .mp-hero-avatar.is-empty { background: #e9ebee; color: #9aa0a6; box-shadow: 0 0 0 3px #fff, 0 0 0 5px #eceef1; }
    .mp-hero-photo-x {
        position: absolute; left: -2px; bottom: -2px; width: 24px; height: 24px; border-radius: 50%; border: 2px solid #fff; padding: 0;
        display: flex; align-items: center; justify-content: center; background: var(--mp-danger); color: #fff; font-size: 10px; cursor: pointer;
    }
    .mp-hero-right { display: flex; flex-direction: column; align-items: flex-end; gap: 10px; align-self: flex-start; }

    /* ---------- Personal info cards ---------- */
    .mp-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .mp-info {
        position: relative; display: flex; gap: 12px; padding: 14px; min-height: 78px;
        background: #fcfcfd; border: 1px solid var(--mp-border); border-radius: 8px; transition: border-color .15s, background .15s;
    }
    .mp-info:hover { border-color: #d6d9de; background: #fff; }
    .mp-info.is-editing { border-color: var(--mp-primary); background: #fff; box-shadow: 0 0 0 3px rgba(22, 163, 148, .1); }
    .mp-info-icon {
        width: 30px; height: 30px; flex-shrink: 0; border-radius: 7px; display: flex; align-items: center; justify-content: center;
        color: var(--mp-accent); background: var(--mp-accent-soft); font-size: 12px;
    }
    .mp-info-main { flex: 1; min-width: 0; }
    .mp-info-label { font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--mp-muted); }
    .mp-info-value { margin-top: 3px; font-size: 13.5px; font-weight: 700; color: #1f2328; overflow-wrap: anywhere; }
    .mp-info-note { margin-top: 2px; font-size: 11px; color: #9aa0a6; }
    .mp-info .mp-input { margin-top: 6px; height: 34px; background: #fff; }
    .mp-info:focus-within { border-color: var(--mp-primary); background: #fff; box-shadow: 0 0 0 3px rgba(22, 163, 148, .1); }
    .mp-info.mp-span-2 { grid-column: 1 / -1; }
    .mp-info .mp-choice { margin-top: 6px; }
    .mp-info .mp-choice label { height: 34px; }

    .mp-progress { display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 600; color: var(--mp-muted); }
    .mp-progress-bar { width: 140px; height: 6px; border-radius: 999px; background: #eceef1; overflow: hidden; }
    .mp-progress-bar span { display: block; height: 100%; width: 0; background: var(--mp-primary); transition: width .25s; }

    /* Yes / No radio cards */
    .mp-choice { display: flex; gap: 8px; }
    .mp-choice label {
        flex: 1; display: flex; align-items: center; gap: 8px; height: 36px; padding: 0 12px; margin: 0;
        font-size: 13px; font-weight: 600; border: 1px solid #d6d9de; border-radius: 6px; cursor: pointer; background: #fff;
    }
    .mp-choice input { accent-color: var(--mp-primary); }
    .mp-choice label.is-checked { border-color: var(--mp-primary); background: #f3fbf8; }

    /* Sticky save bar */
    .mp-savebar {
        position: sticky; bottom: 70px; z-index: 50; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
        margin-top: 16px; padding: 12px 16px; background: #fff; border: 1px solid var(--mp-border); border-radius: 10px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .1);
    }
    .mp-savebar-text { font-size: 12.5px; color: var(--mp-muted); }
    .mp-savebar-text b { color: var(--mp-text); }
    .mp-savebar-btns { display: flex; gap: 8px; }
    .mp-savebar .mp-btn { height: 38px; padding: 0 16px; }

    .mp-page .mp-toast { bottom: 150px; }          /* keep the toast above the sticky save bar */
    /* Previous photoshoot photos */
    .mp-drop {
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; padding: 22px 16px;
        text-align: center; font-size: 12.5px; color: var(--mp-muted); background: #fcfcfd;
        border: 2px dashed #d0d4d9; border-radius: 10px; cursor: pointer; transition: border-color .15s, background .15s;
    }
    .mp-drop:hover, .mp-drop.is-drag { border-color: var(--mp-primary); background: #f2fbf9; }
    .mp-drop i { font-size: 26px; color: #c3c7cc; margin-bottom: 4px; }
    .mp-drop b { color: var(--mp-text); }
    .mp-shots { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px; margin-top: 14px; }
    .mp-shot { position: relative; border: 1px solid var(--mp-border); border-radius: 8px; overflow: hidden; background: #fff; }
    .mp-shot-img { aspect-ratio: 3 / 4; background: #f1f2f4; }
    .mp-shot-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .mp-shot-meta { padding: 6px 8px; font-size: 11px; color: var(--mp-muted); }
    .mp-shot-meta b { display: block; font-size: 11.5px; color: var(--mp-text); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .mp-shot .mp-icon-btn { position: absolute; top: 6px; right: 6px; background: rgba(255, 255, 255, .95); }
    .mp-shot.is-confirming { outline: 2px solid var(--mp-danger); outline-offset: -2px; }

    .mp-shake { animation: mpShake .4s; }
    @keyframes mpShake { 0%, 100% { transform: none; } 25% { transform: translateX(-4px); } 75% { transform: translateX(4px); } }

    @media (max-width: 767.98px) {
        .mp-hero { flex-wrap: wrap; padding: 16px; }
        .mp-hero-avatar { width: 68px; height: 68px; font-size: 22px; }
        .mp-hero-name { font-size: 18px; }
        .mp-hero-right { width: 100%; align-items: stretch; }
        .mp-hero-actions { width: 100%; }
        .mp-hero-actions .mp-btn { flex: 1; }
        .mp-info-grid { grid-template-columns: 1fr; }
        .mp-progress { width: 100%; }
        .mp-progress-bar { flex: 1; }
        .mp-savebar { bottom: 110px; }
        .mp-page .mp-toast { bottom: 200px; }
        .mp-savebar-btns { width: 100%; }
        .mp-savebar-btns .mp-btn { flex: 1; }
    }
    @media (max-width: 768px) {
        .header1 {
            height: 40px;
            margin-top: 11px;
        }
    }
</style>

<div class="container-fluid mp-page" id="mpPage">

    @section('order-header')
        <span>Add Model</span>
    @endsection

    {{-- ================= HEADER ================= --}}
    <div class="mp-hero" id="mpHero">
        <div class="mp-hero-photo">
            <div class="mp-hero-avatar is-empty" id="mpPhoto"><i class="fa-regular fa-user"></i></div>
            <label class="mp-hero-cam" title="Upload profile photo">
                <i class="fa-solid fa-camera"></i>
                <input type="file" id="mpPhotoFile" accept="image/jpeg,image/png,image/webp" hidden>
            </label>
            <button type="button" class="mp-hero-photo-x mp-hidden" id="mpPhotoRemove" title="Remove profile photo" aria-label="Remove profile photo"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="mp-hero-main">
            <h1 class="mp-hero-name"><span id="mpHeroName">New Model</span></h1>
            <div class="mp-hero-chips" id="mpHeroChips"></div>
            <div class="mp-hero-org">ENCORE GROUP LLC · Fit &amp; Fashion Models</div>
        </div>
        <div class="mp-hero-right">
            <div class="mp-hero-actions">
                <a href="{{ route('studio.shoot.models') }}" class="mp-btn mp-btn-outline" data-leave>Cancel</a>
                <button type="submit" form="mpForm" class="mp-btn mp-btn-danger"><i class="fa-solid fa-check"></i> Save Model</button>
            </div>
            <div class="mp-progress" title="How much of the form is filled in">
                <div class="mp-progress-bar"><span id="mpProgress"></span></div>
                <span id="mpProgressText">0% complete</span>
            </div>
        </div>
    </div>

    <form id="mpForm" novalidate autocomplete="off">

        <datalist id="mpCountryList">
            <option value="Sri Lanka"><option value="India"><option value="United States"><option value="United Kingdom"><option value="Australia">
            <option value="Canada"><option value="United Arab Emirates"><option value="Singapore"><option value="Maldives"><option value="Japan">
        </datalist>

        {{-- ================= MODEL IMAGE (left) + PERSONAL INFO (right) ================= --}}
        <div class="mp-row">
            <div class="mp-card">
                <div class="mp-card-head">
                    <div class="mp-card-title">
                        <span class="mp-card-icon"><i class="fa-regular fa-user"></i></span>
                        <span>Model image<span class="mp-card-sub">Optional</span></span>
                    </div>
                </div>
                <div class="mp-card-body">
                    <div class="mp-img-wrap">
                        <div class="mp-side-list" id="mpSideList"></div>
                        <div class="mp-img-preview">
                            <div class="mp-img-preview-title" id="mpImgTitle">Front Side</div>
                            <div class="mp-img-frame" id="mpImgFrame"></div>
                        </div>
                    </div>
                    <input type="file" id="mpImgFile" accept="image/jpeg,image/png,image/webp" hidden>
                </div>
            </div>

            <div class="mp-card">
                <div class="mp-card-head">
                    <div class="mp-card-title">
                        <span class="mp-card-icon"><i class="fa-regular fa-user"></i></span>
                        <span>Personal Information<span class="mp-card-sub">Fields marked <span class="mp-req">*</span> are required</span></span>
                    </div>
                </div>
                <div class="mp-card-body">
                    <div class="mp-info-grid">
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-regular fa-user"></i></span>
                            <div class="mp-info-main">
                                <label class="mp-info-label" for="fName">Full Name <span class="mp-req">*</span></label>
                                <input type="text" class="mp-input" id="fName" name="name" maxlength="150" placeholder="Full name">
                                <div class="mp-error" data-error="name"></div>
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-solid fa-location-dot"></i></span>
                            <div class="mp-info-main">
                                <label class="mp-info-label" for="fAddress">Current Address</label>
                                <input type="text" class="mp-input" id="fAddress" name="address" maxlength="255" placeholder="Street, city (where the model lives now)">
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-solid fa-phone"></i></span>
                            <div class="mp-info-main">
                                <label class="mp-info-label" for="fPhone">Phone Number <span class="mp-req">*</span></label>
                                <input type="tel" class="mp-input" id="fPhone" name="phone_number" maxlength="20" placeholder="+94 7X XXX XXXX">
                                <div class="mp-error" data-error="phone_number"></div>
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-regular fa-envelope"></i></span>
                            <div class="mp-info-main">
                                <label class="mp-info-label" for="fEmail">Email Address</label>
                                <input type="email" class="mp-input" id="fEmail" name="email" maxlength="150" placeholder="name@example.com">
                                <div class="mp-error" data-error="email"></div>
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-regular fa-calendar"></i></span>
                            <div class="mp-info-main">
                                <label class="mp-info-label" for="fDob">Date of Birth <span class="mp-req">*</span></label>
                                <input type="date" class="mp-input" id="fDob" name="date_of_birth">
                                <div class="mp-error" data-error="date_of_birth"></div>
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-regular fa-calendar"></i></span>
                            <div class="mp-info-main">
                                <label class="mp-info-label" for="fAge">Age</label>
                                <input type="number" class="mp-input" id="fAge" name="age" min="16" max="99" placeholder="Filled from date of birth">
                                <div class="mp-info-note">Age recorded at registration</div>
                                <div class="mp-error" data-error="age"></div>
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-solid fa-earth-asia"></i></span>
                            <div class="mp-info-main">
                                <label class="mp-info-label" for="fCountry">Country</label>
                                <input type="text" class="mp-input" id="fCountry" name="country" maxlength="100" placeholder="e.g. Sri Lanka" list="mpCountryList">
                                <div class="mp-error" data-error="country"></div>
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-regular fa-flag"></i></span>
                            <div class="mp-info-main">
                                <label class="mp-info-label" for="fNationality">Nationality</label>
                                <input type="text" class="mp-input" id="fNationality" name="nationality" maxlength="100" placeholder="e.g. Sri Lankan">
                                <div class="mp-error" data-error="nationality"></div>
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-solid fa-venus-mars"></i></span>
                            <div class="mp-info-main">
                                <span class="mp-info-label">Gender <span class="mp-req">*</span></span>
                                <div class="mp-choice" data-choice="gender">
                                    <label><input type="radio" name="gender" value="Female"> Female</label>
                                    <label><input type="radio" name="gender" value="Male"> Male</label>
                                </div>
                                <div class="mp-error" data-error="gender"></div>
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-solid fa-shirt"></i></span>
                            <div class="mp-info-main">
                                <label class="mp-info-label" for="fSize">US Clothing Size</label>
                                <select class="mp-input" id="fSize" name="us_size">
                                    <option value="">Select size</option>
                                    <option>0</option><option>2</option><option>4</option><option>6</option><option>8</option><option>10</option>
                                    <option>12</option><option>14</option><option>16</option><option>18</option>
                                    <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option><option>2XL</option>
                                </select>
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-solid fa-shirt"></i></span>
                            <div class="mp-info-main">
                                <label class="mp-info-label" for="fType">Model Type</label>
                                <select class="mp-input" id="fType" name="model_type">
                                    <option value="">Select type</option>
                                    <option selected>Fit &amp; Fashion</option><option>Commercial</option><option>Runway</option>
                                    <option>Fitness</option><option>Plus Size</option><option>Parts</option>
                                </select>
                            </div>
                        </div>
                        <div class="mp-info">
                            <span class="mp-info-icon"><i class="fa-regular fa-star"></i></span>
                            <div class="mp-info-main">
                                <span class="mp-info-label">Previous Modeling Experience</span>
                                <div class="mp-choice" data-choice="experience">
                                    <label><input type="radio" name="experience" value="1"> Yes</label>
                                    <label class="is-checked"><input type="radio" name="experience" value="0" checked> No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= BODY MEASUREMENTS ================= --}}
        <div class="mp-card" style="margin-top:16px">
            <div class="mp-card-head">
                <div class="mp-card-title">
                    <span class="mp-card-icon"><i class="fa-solid fa-ruler"></i></span>
                    <span>Body Measurements <small id="mpUnitNote">Enter values in inches</small></span>
                </div>
                <div class="mp-card-actions">
                    <div class="mp-seg" role="group" aria-label="Unit">
                        <button type="button" class="is-active" data-unit="in">in</button>
                        <button type="button" data-unit="cm">cm</button>
                    </div>
                </div>
            </div>
            <div class="mp-card-body">
                <div class="mp-measure-wrap">
                    <div>
                        <table class="mp-mtable">
                            <thead><tr><th style="width:44px">No.</th><th>Measurement</th><th style="width:130px">Value</th><th style="width:60px">Unit</th></tr></thead>
                            <tbody id="mpMeasureBody"></tbody>
                        </table>
                        <div class="mp-mfoot">
                            <span><i class="fa-solid fa-circle-info"></i> <b id="mpMeasureCount">0 of 12</b> measurements entered</span>
                            <span>Height is required. The rest can be added later.</span>
                        </div>
                        <div class="mp-error" data-error="measurements"></div>
                    </div>
                    <div class="mp-diagram" id="mpDiagram">
                        <svg class="mp-body-svg" viewBox="0 0 664 731" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Body measurement guide (front and back)">
<mask id="path-1-inside-1_3368_10977" fill="white">
<path d="M0 12C0 5.37256 5.37258 0 12 0H651.85C658.477 0 663.85 5.37258 663.85 12V718.25C663.85 724.877 658.477 730.25 651.85 730.25H12C5.37258 730.25 0 724.877 0 718.25V12Z"/>
</mask>
<path d="M0 12C0 5.37256 5.37258 0 12 0H651.85C658.477 0 663.85 5.37258 663.85 12V718.25C663.85 724.877 658.477 730.25 651.85 730.25H12C5.37258 730.25 0 724.877 0 718.25V12Z"/>
<path d="M0 12C0 5.37256 5.37258 0 12 0H651.85C658.477 0 663.85 5.37258 663.85 12V718.25C663.85 724.877 658.477 730.25 651.85 730.25H12C5.37258 730.25 0 724.877 0 718.25V12Z" fill="url(#paint0_linear_3368_10977)"/>
<path d="M12 0V1H651.85V0V-1H12V0ZM663.85 12H662.85V718.25H663.85H664.85V12H663.85ZM651.85 730.25V729.25H12V730.25V731.25H651.85V730.25ZM0 718.25H1V12H0H-1V718.25H0ZM12 730.25V729.25C5.92486 729.25 1 724.325 1 718.25H0H-1C-1 725.43 4.82029 731.25 12 731.25V730.25ZM663.85 718.25H662.85C662.85 724.325 657.925 729.25 651.85 729.25V730.25V731.25C659.03 731.25 664.85 725.43 664.85 718.25H663.85ZM651.85 0V1C657.925 1 662.85 5.92487 662.85 12H663.85H664.85C664.85 4.8203 659.03 -1 651.85 -1V0ZM12 0V-1C4.8203 -1 -1 4.82028 -1 12H0H1C1 5.92485 5.92487 1 12 1V0Z" fill="#EEF0F3" mask="url(#path-1-inside-1_3368_10977)"/>
<path d="M116.608 103.935V95.9351H121.905V97.3296H118.3V99.2358H121.553V100.63H118.3V103.935H116.608ZM124.143 103.935V95.9351H127.299C127.903 95.9351 128.419 96.0431 128.846 96.2593C129.275 96.4728 129.602 96.7762 129.826 97.1694C130.053 97.5601 130.166 98.0197 130.166 98.5483C130.166 99.0796 130.052 99.5366 129.822 99.9194C129.593 100.3 129.261 100.591 128.826 100.794C128.394 100.998 127.871 101.099 127.256 101.099H125.143V99.7397H126.983C127.305 99.7397 127.574 99.6955 127.787 99.6069C128.001 99.5184 128.16 99.3856 128.264 99.2085C128.371 99.0314 128.424 98.8114 128.424 98.5483C128.424 98.2827 128.371 98.0588 128.264 97.8765C128.16 97.6942 127.999 97.5562 127.783 97.4624C127.57 97.366 127.3 97.3179 126.975 97.3179H125.834V103.935H124.143ZM128.463 100.294L130.451 103.935H128.584L126.639 100.294H128.463ZM139.813 99.9351C139.813 100.807 139.648 101.55 139.317 102.162C138.989 102.774 138.541 103.241 137.973 103.564C137.408 103.884 136.773 104.044 136.067 104.044C135.356 104.044 134.718 103.883 134.153 103.56C133.588 103.237 133.141 102.77 132.813 102.158C132.485 101.546 132.321 100.805 132.321 99.9351C132.321 99.0627 132.485 98.3205 132.813 97.7085C133.141 97.0965 133.588 96.6304 134.153 96.3101C134.718 95.9871 135.356 95.8257 136.067 95.8257C136.773 95.8257 137.408 95.9871 137.973 96.3101C138.541 96.6304 138.989 97.0965 139.317 97.7085C139.648 98.3205 139.813 99.0627 139.813 99.9351ZM138.098 99.9351C138.098 99.37 138.014 98.8934 137.844 98.5054C137.678 98.1174 137.442 97.8231 137.137 97.6226C136.833 97.422 136.476 97.3218 136.067 97.3218C135.658 97.3218 135.301 97.422 134.997 97.6226C134.692 97.8231 134.455 98.1174 134.286 98.5054C134.119 98.8934 134.036 99.37 134.036 99.9351C134.036 100.5 134.119 100.977 134.286 101.365C134.455 101.753 134.692 102.047 134.997 102.248C135.301 102.448 135.658 102.548 136.067 102.548C136.476 102.548 136.833 102.448 137.137 102.248C137.442 102.047 137.678 101.753 137.844 101.365C138.014 100.977 138.098 100.5 138.098 99.9351ZM148.857 95.9351V103.935H147.396L143.916 98.8999H143.857V103.935H142.166V95.9351H143.65L147.103 100.966H147.174V95.9351H148.857ZM151.05 97.3296V95.9351H157.62V97.3296H155.171V103.935H153.499V97.3296H151.05Z" fill="#6B7280"/>
<path d="M442.45 103.935V95.9351H445.653C446.241 95.9351 446.732 96.0223 447.125 96.1968C447.519 96.3713 447.814 96.6134 448.012 96.9233C448.21 97.2306 448.309 97.5848 448.309 97.9858C448.309 98.2983 448.246 98.5731 448.121 98.8101C447.996 99.0444 447.825 99.2371 447.606 99.3882C447.39 99.5366 447.142 99.6421 446.864 99.7046V99.7827C447.168 99.7957 447.454 99.8817 447.719 100.041C447.987 100.199 448.205 100.422 448.371 100.708C448.538 100.992 448.621 101.331 448.621 101.724C448.621 102.149 448.516 102.528 448.305 102.861C448.097 103.192 447.788 103.453 447.379 103.646C446.97 103.839 446.467 103.935 445.868 103.935H442.45ZM444.141 102.552H445.52C445.991 102.552 446.335 102.462 446.551 102.283C446.767 102.1 446.875 101.858 446.875 101.556C446.875 101.335 446.822 101.139 446.715 100.97C446.608 100.801 446.456 100.668 446.258 100.572C446.063 100.475 445.83 100.427 445.559 100.427H444.141V102.552ZM444.141 99.2827H445.395C445.627 99.2827 445.832 99.2424 446.012 99.1616C446.194 99.0783 446.338 98.9611 446.442 98.8101C446.549 98.659 446.602 98.478 446.602 98.2671C446.602 97.978 446.499 97.745 446.293 97.5679C446.09 97.3908 445.801 97.3022 445.426 97.3022H444.141V99.2827ZM452.201 103.935H450.388L453.15 95.9351H455.33L458.088 103.935H456.275L454.271 97.7632H454.209L452.201 103.935ZM452.088 100.791H456.369V102.111H452.088V100.791ZM466.833 98.7358H465.122C465.091 98.5145 465.027 98.3179 464.931 98.146C464.835 97.9715 464.711 97.8231 464.56 97.7007C464.409 97.5783 464.234 97.4845 464.036 97.4194C463.841 97.3543 463.629 97.3218 463.4 97.3218C462.986 97.3218 462.625 97.4246 462.318 97.6304C462.01 97.8335 461.772 98.1304 461.603 98.521C461.433 98.909 461.349 99.3804 461.349 99.9351C461.349 100.505 461.433 100.985 461.603 101.373C461.775 101.761 462.014 102.054 462.321 102.251C462.629 102.449 462.984 102.548 463.388 102.548C463.614 102.548 463.824 102.518 464.017 102.458C464.212 102.399 464.385 102.311 464.536 102.197C464.687 102.08 464.812 101.938 464.911 101.771C465.013 101.604 465.083 101.414 465.122 101.201L466.833 101.208C466.789 101.576 466.678 101.93 466.501 102.271C466.327 102.61 466.091 102.913 465.794 103.181C465.5 103.447 465.148 103.658 464.739 103.814C464.333 103.968 463.874 104.044 463.361 104.044C462.647 104.044 462.009 103.883 461.446 103.56C460.887 103.237 460.444 102.77 460.118 102.158C459.795 101.546 459.634 100.805 459.634 99.9351C459.634 99.0627 459.798 98.3205 460.126 97.7085C460.454 97.0965 460.9 96.6304 461.462 96.3101C462.025 95.9871 462.657 95.8257 463.361 95.8257C463.824 95.8257 464.254 95.8908 464.65 96.021C465.048 96.1512 465.401 96.3413 465.708 96.5913C466.015 96.8387 466.265 97.1421 466.458 97.5015C466.654 97.8608 466.779 98.2723 466.833 98.7358ZM469.146 103.935V95.9351H470.837V99.4624H470.943L473.822 95.9351H475.849L472.88 99.5171L475.884 103.935H473.861L471.67 100.646L470.837 101.662V103.935H469.146Z" fill="#6B7280"/>
<path d="M140.744 189.889C122.888 192.045 103.657 196.357 95.4159 204.98C92.6687 216.837 98.1631 227.616 109.152 238.395C114.646 259.954 117.393 276.122 114.646 295.525C109.152 313.849 98.1631 335.407 100.91 360.199C103.657 394.693 109.152 437.809 111.899 475.536C111.899 491.705 113.273 513.263 114.646 545.6L117.393 586.561L136.624 590.873L139.371 586.561C139.371 545.6 142.118 502.484 144.865 470.147L150.359 373.134V189.889H140.744Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path d="M95.4156 204.98C84.4269 211.447 76.1854 227.616 73.4382 249.174C70.6911 276.122 65.1967 313.849 59.7024 346.187L54.208 373.134L67.9439 375.29L76.1854 353.732C84.4269 319.239 89.9213 286.901 98.1628 259.954C103.657 249.174 106.404 241.629 109.151 238.395L95.4156 204.98Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path d="M159.974 189.889C177.83 192.045 197.06 196.357 205.302 204.98C208.049 216.837 202.555 227.616 191.566 238.395C186.072 259.954 183.324 276.122 186.072 295.525C191.566 313.849 202.555 335.407 199.808 360.199C197.06 394.693 191.566 437.809 188.819 475.536C188.819 491.705 187.445 513.263 186.072 545.6L183.324 586.561L164.094 590.873L161.347 586.561C161.347 545.6 158.6 502.484 155.853 470.147L150.358 373.134V189.889H159.974Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path d="M205.302 204.98C216.291 211.447 224.532 227.616 227.28 249.174C230.027 276.122 235.521 313.849 241.015 346.187L246.51 373.134L232.774 375.29L224.532 353.732C216.291 319.239 210.797 286.901 202.555 259.954C197.061 249.174 194.313 241.629 191.566 238.395L205.302 204.98Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path d="M154.48 174.798H146.239C143.204 174.798 140.744 176.729 140.744 179.11V189.889C140.744 192.271 143.204 194.201 146.239 194.201H154.48C157.515 194.201 159.975 192.271 159.975 189.889V179.11C159.975 176.729 157.515 174.798 154.48 174.798Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path d="M150.359 178.032C163.255 178.032 173.71 167.898 173.71 155.396C173.71 142.894 163.255 132.76 150.359 132.76C137.462 132.76 127.008 142.894 127.008 155.396C127.008 167.898 137.462 178.032 150.359 178.032Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path opacity="0.55" d="M122.888 243.785C123.22 244.219 123.556 244.643 123.897 245.056M177.832 243.785C177.5 244.219 177.163 244.643 176.823 245.056M126.049 247.479C126.812 248.275 127.591 249.025 128.382 249.731M130.887 251.789C131.767 252.454 132.658 253.068 133.553 253.633M136.367 255.242C137.35 255.747 138.334 256.197 139.312 256.592M142.374 257.661C143.441 257.976 144.494 258.227 145.525 258.417M148.74 258.822C149.29 258.858 149.831 258.876 150.36 258.876C150.889 258.876 151.429 258.858 151.979 258.822M155.195 258.417C156.225 258.227 157.278 257.976 158.345 257.661M161.407 256.592C162.385 256.197 163.369 255.747 164.352 255.242M167.166 253.633C168.062 253.068 168.952 252.454 169.832 251.789M172.337 249.731C173.128 249.025 173.907 248.275 174.67 247.479" stroke-width="1.2935" stroke="#9AA1AD"/>
<path class="mp-guide" data-m="1" d="M308.321 138.149V590.872" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="1" role="button" tabindex="0" aria-label="Height"><title>1 · Height</title><path d="M308.321 374.212C315.149 374.212 320.684 369.869 320.684 364.511C320.684 359.153 315.149 354.81 308.321 354.81C301.494 354.81 295.959 359.153 295.959 364.511C295.959 369.869 301.494 374.212 308.321 374.212Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M309.656 357.754V364.81H308.164V359.17H308.123L306.507 360.183V358.86L308.254 357.754H309.656Z" fill="white"/></g>
<path class="mp-guide" data-m="2" d="M117.393 295.524H183.325" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="2" role="button" tabindex="0" aria-label="Waist"><title>2 · Waist</title><path d="M197.061 305.226C203.888 305.226 209.423 300.882 209.423 295.525C209.423 290.167 203.888 285.823 197.061 285.823C190.233 285.823 184.698 290.167 184.698 295.525C184.698 300.882 190.233 305.226 197.061 305.226Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M194.956 295.823V294.748L197.467 292.423C197.681 292.216 197.86 292.03 198.005 291.865C198.152 291.7 198.263 291.538 198.339 291.379C198.415 291.218 198.453 291.045 198.453 290.859C198.453 290.652 198.406 290.474 198.311 290.325C198.217 290.173 198.089 290.057 197.926 289.977C197.763 289.894 197.578 289.853 197.371 289.853C197.155 289.853 196.967 289.897 196.806 289.984C196.645 290.071 196.521 290.196 196.434 290.359C196.347 290.522 196.303 290.717 196.303 290.942H194.887C194.887 290.48 194.992 290.079 195.201 289.739C195.41 289.399 195.702 289.136 196.079 288.95C196.456 288.764 196.89 288.671 197.381 288.671C197.887 288.671 198.326 288.761 198.701 288.94C199.077 289.117 199.37 289.363 199.579 289.677C199.788 289.992 199.893 290.353 199.893 290.759C199.893 291.025 199.84 291.288 199.734 291.548C199.631 291.807 199.446 292.096 199.18 292.413C198.913 292.727 198.538 293.105 198.053 293.546L197.023 294.555V294.604H199.986V295.823H194.956Z" fill="white"/></g>
<path class="mp-guide" data-m="4" d="M106.404 228.694H194.315" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="4" role="button" tabindex="0" aria-label="Chest"><title>4 · Chest</title><path d="M202.556 238.395C209.383 238.395 214.918 234.052 214.918 228.694C214.918 223.336 209.383 218.993 202.556 218.993C195.728 218.993 190.193 223.336 190.193 228.694C190.193 234.052 195.728 238.395 202.556 238.395Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M199.426 227.752V226.578L202.371 221.937H203.384V223.563H202.785L200.928 226.502V226.557H205.113V227.752H199.426ZM202.812 228.993V227.394L202.84 226.874V221.937H204.238V228.993H202.812Z" fill="white"/></g>
<path class="mp-guide" data-m="5" d="M103.657 335.407H197.062" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="5" role="button" tabindex="0" aria-label="Hips"><title>5 · Hips</title><path d="M206.677 345.109C213.504 345.109 219.039 340.765 219.039 335.407C219.039 330.049 213.504 325.706 206.677 325.706C199.849 325.706 194.314 330.049 194.314 335.407C194.314 340.765 199.849 345.109 206.677 345.109Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M207.078 335.803C206.591 335.803 206.157 335.713 205.776 335.534C205.397 335.355 205.096 335.108 204.873 334.793C204.65 334.478 204.534 334.118 204.525 333.711H205.972C205.988 333.985 206.103 334.206 206.317 334.376C206.53 334.546 206.784 334.631 207.078 334.631C207.312 334.631 207.519 334.58 207.698 334.476C207.88 334.371 208.021 334.225 208.122 334.039C208.225 333.85 208.277 333.634 208.277 333.391C208.277 333.143 208.224 332.925 208.118 332.736C208.015 332.548 207.872 332.401 207.688 332.295C207.504 332.19 207.294 332.136 207.057 332.134C206.851 332.134 206.65 332.176 206.455 332.261C206.262 332.346 206.111 332.462 206.003 332.609L204.677 332.371L205.011 328.651H209.324V329.87H206.241L206.058 331.637H206.1C206.224 331.463 206.411 331.318 206.661 331.203C206.912 331.089 207.192 331.031 207.502 331.031C207.927 331.031 208.306 331.131 208.639 331.331C208.972 331.531 209.235 331.805 209.428 332.154C209.62 332.501 209.716 332.901 209.714 333.353C209.716 333.829 209.606 334.251 209.383 334.621C209.162 334.988 208.853 335.278 208.456 335.489C208.061 335.698 207.602 335.803 207.078 335.803Z" fill="white"/></g>
<path class="mp-guide" data-m="6" d="M140.743 185.577H159.974" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="6" role="button" tabindex="0" aria-label="Neck Width"><title>6 · Neck Width</title><path d="M175.083 195.279C181.911 195.279 187.445 190.935 187.445 185.577C187.445 180.219 181.911 175.876 175.083 175.876C168.256 175.876 162.721 180.219 162.721 185.577C162.721 190.935 168.256 195.279 175.083 195.279Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M175.539 185.972C175.177 185.97 174.826 185.909 174.489 185.79C174.153 185.67 173.853 185.476 173.586 185.208C173.32 184.939 173.108 184.583 172.952 184.14C172.798 183.696 172.721 183.152 172.721 182.507C172.724 181.914 172.791 181.385 172.925 180.919C173.06 180.45 173.253 180.053 173.503 179.727C173.756 179.4 174.058 179.152 174.409 178.982C174.761 178.81 175.155 178.724 175.591 178.724C176.062 178.724 176.478 178.816 176.838 179C177.199 179.181 177.488 179.428 177.706 179.74C177.927 180.053 178.06 180.403 178.106 180.791H176.635C176.578 180.545 176.457 180.352 176.273 180.212C176.089 180.072 175.862 180.002 175.591 180.002C175.132 180.002 174.783 180.202 174.544 180.602C174.307 181.001 174.187 181.544 174.182 182.231H174.23C174.336 182.022 174.478 181.844 174.657 181.697C174.839 181.548 175.044 181.434 175.274 181.356C175.506 181.276 175.751 181.236 176.008 181.236C176.426 181.236 176.798 181.334 177.124 181.532C177.45 181.727 177.708 181.996 177.896 182.338C178.084 182.68 178.178 183.072 178.178 183.513C178.178 183.99 178.067 184.415 177.844 184.787C177.624 185.159 177.315 185.451 176.917 185.662C176.522 185.871 176.063 185.975 175.539 185.972ZM175.533 184.801C175.762 184.801 175.968 184.746 176.149 184.636C176.331 184.526 176.473 184.376 176.576 184.188C176.68 184 176.731 183.788 176.731 183.554C176.731 183.32 176.68 183.11 176.576 182.924C176.475 182.738 176.335 182.589 176.156 182.479C175.977 182.369 175.773 182.314 175.543 182.314C175.371 182.314 175.211 182.346 175.064 182.41C174.919 182.475 174.792 182.564 174.682 182.679C174.574 182.794 174.489 182.927 174.427 183.079C174.365 183.228 174.334 183.388 174.334 183.557C174.334 183.785 174.385 183.993 174.489 184.181C174.594 184.369 174.737 184.52 174.916 184.632C175.097 184.745 175.303 184.801 175.533 184.801Z" fill="white"/></g>
<path class="mp-guide" data-m="7" d="M106.404 396.848H148.986" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="7" role="button" tabindex="0" aria-label="Thigh"><title>7 · Thigh</title><path d="M92.668 406.55C99.4956 406.55 105.03 402.206 105.03 396.848C105.03 391.49 99.4956 387.147 92.668 387.147C85.8405 387.147 80.3057 391.49 80.3057 396.848C80.3057 402.206 85.8405 406.55 92.668 406.55Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M89.513 397.147L92.4378 391.359V391.311H89.0307V390.092H93.9812V391.328L91.0529 397.147H89.513Z" fill="white"/></g>
<path class="mp-guide" data-m="8" d="M114.646 572.548H139.37" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="8" role="button" tabindex="0" aria-label="Leg Opening"><title>8 · Leg Opening</title><path d="M100.909 582.249C107.737 582.249 113.272 577.906 113.272 572.548C113.272 567.19 107.737 562.847 100.909 562.847C94.0817 562.847 88.5469 567.19 88.5469 572.548C88.5469 577.906 94.0817 582.249 100.909 582.249Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M101.285 572.943C100.755 572.943 100.283 572.857 99.8692 572.685C99.4581 572.51 99.1354 572.273 98.9011 571.972C98.6668 571.671 98.5497 571.33 98.5497 570.948C98.5497 570.654 98.6163 570.385 98.7495 570.139C98.885 569.891 99.0688 569.685 99.3007 569.522C99.5327 569.357 99.7922 569.251 100.079 569.205V569.157C99.7027 569.081 99.3972 568.899 99.1629 568.609C98.9287 568.318 98.8115 567.979 98.8115 567.593C98.8115 567.228 98.9183 566.903 99.1319 566.618C99.3455 566.331 99.6383 566.106 100.01 565.943C100.385 565.777 100.81 565.695 101.285 565.695C101.76 565.695 102.184 565.777 102.556 565.943C102.931 566.108 103.225 566.334 103.438 566.622C103.652 566.906 103.76 567.23 103.762 567.593C103.76 567.981 103.64 568.32 103.404 568.609C103.167 568.899 102.864 569.081 102.494 569.157V569.205C102.777 569.251 103.033 569.357 103.263 569.522C103.494 569.685 103.678 569.891 103.814 570.139C103.952 570.385 104.022 570.654 104.024 570.948C104.022 571.33 103.903 571.671 103.669 571.972C103.435 572.273 103.111 572.51 102.698 572.685C102.286 572.857 101.816 572.943 101.285 572.943ZM101.285 571.848C101.522 571.848 101.728 571.805 101.905 571.72C102.082 571.633 102.22 571.513 102.319 571.362C102.42 571.208 102.47 571.031 102.47 570.831C102.47 570.627 102.418 570.447 102.315 570.29C102.212 570.132 102.072 570.008 101.895 569.918C101.718 569.827 101.515 569.781 101.285 569.781C101.058 569.781 100.854 569.827 100.675 569.918C100.496 570.008 100.355 570.132 100.252 570.29C100.151 570.447 100.1 570.627 100.1 570.831C100.1 571.031 100.149 571.208 100.248 571.362C100.347 571.513 100.486 571.633 100.665 571.72C100.844 571.805 101.051 571.848 101.285 571.848ZM101.285 568.695C101.483 568.695 101.658 568.655 101.812 568.575C101.966 568.494 102.087 568.383 102.174 568.241C102.261 568.098 102.305 567.934 102.305 567.748C102.305 567.564 102.261 567.404 102.174 567.266C102.087 567.126 101.967 567.017 101.816 566.938C101.664 566.858 101.487 566.818 101.285 566.818C101.085 566.818 100.908 566.858 100.755 566.938C100.601 567.017 100.48 567.126 100.393 567.266C100.308 567.404 100.265 567.564 100.265 567.748C100.265 567.934 100.309 568.098 100.396 568.241C100.484 568.383 100.604 568.494 100.758 568.575C100.912 568.655 101.088 568.695 101.285 568.695Z" fill="white"/></g>
<path class="mp-guide" data-m="9" d="M92.668 204.979H208.05" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="9" role="button" tabindex="0" aria-label="Across Shoulder"><title>9 · Across Shoulder</title><path d="M219.038 214.681C225.866 214.681 231.401 210.337 231.401 204.98C231.401 199.622 225.866 195.278 219.038 195.278C212.211 195.278 206.676 199.622 206.676 204.98C206.676 210.337 212.211 214.681 219.038 214.681Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M219.339 198.126C219.702 198.126 220.051 198.187 220.387 198.309C220.724 198.431 221.025 198.625 221.289 198.891C221.556 199.158 221.766 199.511 221.92 199.952C222.076 200.391 222.155 200.93 222.158 201.568C222.158 202.167 222.09 202.703 221.954 203.173C221.821 203.642 221.629 204.04 221.379 204.369C221.129 204.697 220.827 204.948 220.473 205.12C220.119 205.29 219.724 205.375 219.288 205.375C218.817 205.375 218.401 205.284 218.041 205.103C217.68 204.919 217.39 204.67 217.169 204.355C216.951 204.038 216.819 203.682 216.773 203.287H218.244C218.301 203.544 218.422 203.744 218.606 203.887C218.789 204.027 219.017 204.097 219.288 204.097C219.747 204.097 220.096 203.897 220.335 203.497C220.574 203.095 220.695 202.545 220.697 201.847H220.649C220.543 202.054 220.401 202.232 220.221 202.381C220.042 202.528 219.837 202.642 219.605 202.722C219.375 202.802 219.13 202.843 218.871 202.843C218.455 202.843 218.084 202.745 217.758 202.55C217.432 202.355 217.175 202.086 216.987 201.744C216.798 201.402 216.704 201.011 216.704 200.572C216.702 200.099 216.811 199.678 217.031 199.308C217.252 198.938 217.56 198.649 217.955 198.44C218.352 198.229 218.814 198.124 219.339 198.126ZM219.35 199.298C219.118 199.298 218.911 199.353 218.73 199.463C218.551 199.573 218.408 199.721 218.303 199.908C218.199 200.094 218.149 200.301 218.151 200.531C218.151 200.763 218.201 200.972 218.303 201.158C218.406 201.342 218.546 201.489 218.723 201.599C218.902 201.707 219.106 201.761 219.336 201.761C219.508 201.761 219.668 201.729 219.815 201.664C219.962 201.6 220.089 201.512 220.197 201.399C220.308 201.284 220.394 201.152 220.456 201.003C220.518 200.854 220.549 200.695 220.549 200.528C220.546 200.305 220.494 200.1 220.39 199.914C220.287 199.728 220.144 199.579 219.963 199.467C219.782 199.354 219.577 199.298 219.35 199.298Z" fill="white"/></g>
<path class="mp-guide" data-m="10" d="M81.679 213.603L48.7129 351.576" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="10" role="button" tabindex="0" aria-label="Sleeve Length"><title>10 · Sleeve Length</title><path d="M62.4493 290.135C69.2769 290.135 74.8117 285.792 74.8117 280.434C74.8117 275.076 69.2769 270.732 62.4493 270.732C55.6217 270.732 50.0869 275.076 50.0869 280.434C50.0869 285.792 55.6217 290.135 62.4493 290.135Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M58.5488 273.677V280.732H57.0571V275.093H57.0157L55.4 276.106V274.783L57.1467 273.677H58.5488ZM62.992 280.887C62.3995 280.885 61.8896 280.739 61.4624 280.45C61.0375 280.161 60.7103 279.741 60.4806 279.192C60.2532 278.644 60.1407 277.983 60.143 277.212C60.143 276.442 60.2567 275.786 60.484 275.244C60.7137 274.702 61.041 274.29 61.4659 274.008C61.8931 273.723 62.4018 273.581 62.992 273.581C63.5823 273.581 64.0898 273.723 64.5147 274.008C64.9419 274.293 65.2703 274.706 65.5 275.248C65.7297 275.788 65.8434 276.442 65.8411 277.212C65.8411 277.986 65.7262 278.647 65.4966 279.196C65.2692 279.745 64.9431 280.164 64.5182 280.453C64.0933 280.743 63.5846 280.887 62.992 280.887ZM62.992 279.651C63.3962 279.651 63.7189 279.447 63.9601 279.041C64.2012 278.634 64.3207 278.025 64.3184 277.212C64.3184 276.676 64.2632 276.231 64.153 275.875C64.0451 275.519 63.8912 275.251 63.6914 275.072C63.4939 274.893 63.2607 274.804 62.992 274.804C62.5901 274.804 62.2686 275.004 62.0274 275.406C61.7863 275.808 61.6645 276.41 61.6622 277.212C61.6622 277.754 61.7162 278.206 61.8242 278.569C61.9344 278.93 62.0894 279.201 62.2892 279.382C62.489 279.561 62.7233 279.651 62.992 279.651Z" fill="white"/></g>
<path class="mp-guide" data-m="11" d="M51.4609 368.823L70.6913 370.979" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="11" role="button" tabindex="0" aria-label="Cuff Opening"><title>11 · Cuff Opening</title><path d="M50.087 365.589C56.9145 365.589 62.4494 361.246 62.4494 355.888C62.4494 350.53 56.9145 346.187 50.087 346.187C43.2594 346.187 37.7246 350.53 37.7246 355.888C37.7246 361.246 43.2594 365.589 50.087 365.589Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M47.5268 349.131V356.187H46.0351V350.547H45.9938L44.3781 351.56V350.237L46.1247 349.131H47.5268ZM52.2732 349.131V356.187H50.7815V350.547H50.7402L49.1245 351.56V350.237L50.8711 349.131H52.2732Z" fill="white"/></g>
<path class="mp-guide" data-m="12" d="M127.008 155.396H173.71" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="12" role="button" tabindex="0" aria-label="Head Circumference"><title>12 · Head Circumference</title><path d="M188.819 154.318C195.647 154.318 201.182 149.975 201.182 144.617C201.182 139.259 195.647 134.916 188.819 134.916C181.992 134.916 176.457 139.259 176.457 144.617C176.457 149.975 181.992 154.318 188.819 154.318Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M186.978 137.86V144.916H185.486V139.276H185.444L183.829 140.289V138.966L185.575 137.86H186.978ZM188.654 144.916V143.841L191.166 141.515C191.379 141.309 191.559 141.123 191.703 140.957C191.85 140.792 191.962 140.63 192.037 140.471C192.113 140.311 192.151 140.137 192.151 139.951C192.151 139.745 192.104 139.567 192.01 139.417C191.916 139.266 191.787 139.15 191.624 139.069C191.461 138.987 191.276 138.945 191.069 138.945C190.853 138.945 190.665 138.989 190.504 139.076C190.344 139.163 190.22 139.289 190.132 139.452C190.045 139.615 190.001 139.809 190.001 140.034H188.586C188.586 139.572 188.69 139.172 188.899 138.832C189.108 138.492 189.401 138.229 189.777 138.043C190.154 137.857 190.588 137.764 191.08 137.764C191.585 137.764 192.025 137.853 192.399 138.032C192.776 138.209 193.069 138.455 193.278 138.77C193.487 139.084 193.591 139.445 193.591 139.851C193.591 140.118 193.538 140.381 193.433 140.64C193.329 140.9 193.144 141.188 192.878 141.505C192.612 141.82 192.236 142.197 191.751 142.638L190.721 143.648V143.696H193.684V144.916H188.654Z" fill="white"/></g>
<path d="M462.669 189.895C444.812 192.051 425.582 196.363 417.341 204.987C414.594 216.844 420.088 227.624 431.077 238.404C436.571 259.964 439.318 276.134 436.571 295.538C431.077 313.864 420.088 335.424 422.835 360.218C425.582 394.714 431.077 437.834 433.824 475.564C433.824 491.734 435.197 513.294 436.571 545.634L439.318 586.598L458.548 590.91L461.295 586.598C461.295 545.634 464.043 502.514 466.79 470.174L472.284 373.154V189.895H462.669Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path d="M417.34 204.987C406.352 211.455 398.11 227.625 395.363 249.185C392.616 276.135 387.121 313.865 381.627 346.205L376.133 373.154L389.869 375.31L398.11 353.751C406.352 319.255 411.846 286.915 420.088 259.965C425.582 249.185 428.329 241.639 431.076 238.405L417.34 204.987Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path d="M481.898 189.895C499.755 192.051 518.985 196.363 527.227 204.987C529.974 216.844 524.48 227.624 513.491 238.404C507.997 259.964 505.249 276.134 507.997 295.538C513.491 313.864 524.48 335.424 521.732 360.218C518.985 394.714 513.491 437.834 510.744 475.564C510.744 491.734 509.37 513.294 507.997 545.634L505.249 586.598L486.019 590.91L483.272 586.598C483.272 545.634 480.525 502.514 477.778 470.174L472.283 373.154V189.895H481.898Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path d="M527.227 204.986C538.216 211.454 546.457 227.624 549.204 249.184C551.952 276.134 557.446 313.864 562.94 346.204L568.435 373.154L554.699 375.31L546.457 353.75C538.216 319.254 532.721 286.914 524.48 259.964C518.986 249.184 516.238 241.638 513.491 238.404L527.227 204.986Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path d="M476.405 174.803H468.163C465.129 174.803 462.669 176.733 462.669 179.115V189.895C462.669 192.276 465.129 194.207 468.163 194.207H476.405C479.439 194.207 481.899 192.276 481.899 189.895V179.115C481.899 176.733 479.439 174.803 476.405 174.803Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path d="M472.283 178.036C485.18 178.036 495.634 167.901 495.634 155.399C495.634 142.896 485.18 132.761 472.283 132.761C459.387 132.761 448.933 142.896 448.933 155.399C448.933 167.901 459.387 178.036 472.283 178.036Z" fill="#F2F3F5" stroke-width="1.40129" stroke-linejoin="round" stroke="#9AA1AD"/>
<path opacity="0.75" d="M448.933 151.087C448.933 138.151 458.548 129.527 472.283 129.527C486.019 129.527 495.634 138.151 495.634 151.087C488.766 143.541 480.525 141.385 472.283 141.385C464.042 141.385 455.8 143.541 448.933 151.087Z" fill="#4B5260"/>
<path opacity="0.75" d="M472.284 140.307C477.594 140.307 481.899 136.928 481.899 132.761C481.899 128.593 477.594 125.215 472.284 125.215C466.974 125.215 462.669 128.593 462.669 132.761C462.669 136.928 466.974 140.307 472.284 140.307Z" fill="#4B5260"/>
<path d="M472.284 194.207V195.824M472.284 368.842V367.225M472.284 199.058V202.292M472.284 205.526V208.76M472.284 211.994V215.228M472.284 218.461V221.695M472.284 224.929V228.163M472.284 231.397V234.631M472.284 237.865V241.099M472.284 244.333V247.567M472.284 250.801V254.035M472.284 257.269V260.503M472.284 263.737V266.971M472.284 270.205V273.439M472.284 276.673V279.907M472.284 283.141V286.375M472.284 289.609V292.843M472.284 296.077V299.311M472.284 302.545V305.779M472.284 309.013V312.247M472.284 315.481V318.715M472.284 321.949V325.183M472.284 328.417V331.651M472.284 334.885V338.119M472.284 341.353V344.587M472.284 347.821V351.055M472.284 354.289V357.523M472.284 360.757V363.991" stroke-width="1.2935" stroke="#9AA1AD"/>
<path d="M425.582 349.438C425.772 348.917 425.985 348.413 426.22 347.927M518.985 349.438C518.795 348.917 518.582 348.413 518.347 347.927M427.942 345.144C428.611 344.279 429.366 343.489 430.196 342.772M432.857 340.861C433.779 340.313 434.759 339.828 435.789 339.405M438.892 338.355C439.926 338.071 440.996 337.84 442.094 337.657M445.349 337.266C446.424 337.183 447.518 337.143 448.625 337.144M451.902 337.261C452.984 337.337 454.073 337.449 455.163 337.597M458.396 338.138C459.466 338.35 460.533 338.596 461.591 338.874M464.735 339.802C465.778 340.144 466.807 340.518 467.816 340.921M470.818 342.237C471.313 342.474 471.802 342.719 472.284 342.97C472.765 342.719 473.254 342.474 473.749 342.237M476.751 340.921C477.76 340.518 478.789 340.144 479.832 339.802M482.976 338.874C484.034 338.596 485.101 338.35 486.171 338.138M489.404 337.597C490.494 337.449 491.583 337.337 492.665 337.261M495.942 337.144C497.049 337.143 498.143 337.183 499.218 337.266M502.473 337.657C503.571 337.84 504.641 338.071 505.675 338.355M508.778 339.405C509.808 339.828 510.789 340.313 511.71 340.861M514.371 342.772C515.201 343.489 515.956 344.279 516.625 345.144" stroke-width="1.2935" stroke="#9AA1AD"/>
<path class="mp-guide" data-m="1" d="M630.246 138.151V590.91" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="1" role="button" tabindex="0" aria-label="Height"><title>1 · Height</title><path d="M630.246 374.232C637.073 374.232 642.608 369.889 642.608 364.531C642.608 359.172 637.073 354.829 630.246 354.829C623.419 354.829 617.884 359.172 617.884 364.531C617.884 369.889 623.419 374.232 630.246 374.232Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M631.581 357.773V364.829H630.089V359.189H630.048L628.432 360.202V358.879L630.179 357.773H631.581Z" fill="white"/></g>
<path class="mp-guide" data-m="2" d="M439.317 295.539H505.249" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="2" role="button" tabindex="0" aria-label="Waist"><title>2 · Waist</title><path d="M518.985 305.241C525.813 305.241 531.347 300.897 531.347 295.539C531.347 290.181 525.813 285.837 518.985 285.837C512.158 285.837 506.623 290.181 506.623 295.539C506.623 300.897 512.158 305.241 518.985 305.241Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M516.881 295.837V294.762L519.392 292.437C519.606 292.23 519.785 292.044 519.93 291.879C520.077 291.713 520.188 291.551 520.264 291.393C520.34 291.232 520.378 291.059 520.378 290.873C520.378 290.666 520.33 290.488 520.236 290.339C520.142 290.187 520.014 290.071 519.85 289.991C519.687 289.908 519.502 289.867 519.296 289.867C519.08 289.867 518.892 289.91 518.731 289.998C518.57 290.085 518.446 290.21 518.359 290.373C518.271 290.536 518.228 290.73 518.228 290.955H516.812C516.812 290.494 516.916 290.093 517.125 289.753C517.334 289.413 517.627 289.15 518.004 288.964C518.381 288.778 518.815 288.685 519.306 288.685C519.811 288.685 520.251 288.775 520.626 288.954C521.002 289.131 521.295 289.376 521.504 289.691C521.713 290.006 521.818 290.366 521.818 290.773C521.818 291.039 521.765 291.302 521.659 291.562C521.556 291.821 521.371 292.109 521.104 292.426C520.838 292.741 520.463 293.119 519.978 293.56L518.948 294.569V294.617H521.911V295.837H516.881Z" fill="white"/></g>
<path class="mp-guide" data-m="3" d="M431.076 252.419H513.491" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="3" role="button" tabindex="0" aria-label="Bust"><title>3 · Bust</title><path d="M524.479 262.121C531.307 262.121 536.842 257.777 536.842 252.419C536.842 247.06 531.307 242.717 524.479 242.717C517.652 242.717 512.117 247.06 512.117 252.419C512.117 257.777 517.652 262.121 524.479 262.121Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M524.842 252.813C524.327 252.813 523.869 252.725 523.467 252.548C523.068 252.369 522.752 252.123 522.52 251.811C522.29 251.496 522.172 251.133 522.165 250.722H523.667C523.676 250.894 523.732 251.046 523.836 251.177C523.941 251.305 524.082 251.405 524.256 251.477C524.431 251.548 524.627 251.583 524.845 251.583C525.073 251.583 525.273 251.543 525.448 251.463C525.623 251.382 525.759 251.271 525.858 251.129C525.957 250.986 526.006 250.822 526.006 250.636C526.006 250.448 525.953 250.281 525.848 250.136C525.744 249.989 525.595 249.875 525.4 249.792C525.207 249.709 524.977 249.668 524.711 249.668H524.053V248.572H524.711C524.936 248.572 525.135 248.533 525.307 248.455C525.481 248.377 525.617 248.269 525.713 248.131C525.81 247.991 525.858 247.828 525.858 247.642C525.858 247.465 525.816 247.31 525.731 247.177C525.648 247.042 525.531 246.936 525.379 246.86C525.23 246.784 525.055 246.747 524.855 246.747C524.653 246.747 524.469 246.783 524.301 246.857C524.133 246.928 523.999 247.03 523.898 247.163C523.797 247.297 523.743 247.453 523.736 247.632H522.306C522.313 247.225 522.429 246.867 522.654 246.557C522.879 246.247 523.182 246.005 523.564 245.83C523.947 245.653 524.38 245.565 524.862 245.565C525.349 245.565 525.775 245.653 526.14 245.83C526.506 246.007 526.789 246.246 526.991 246.547C527.196 246.845 527.297 247.181 527.295 247.553C527.297 247.948 527.174 248.277 526.926 248.541C526.68 248.806 526.36 248.973 525.965 249.044V249.1C526.484 249.166 526.879 249.346 527.15 249.64C527.423 249.932 527.559 250.297 527.556 250.736C527.559 251.138 527.443 251.495 527.208 251.807C526.976 252.12 526.656 252.365 526.247 252.545C525.838 252.724 525.37 252.813 524.842 252.813Z" fill="white"/></g>
<path class="mp-guide" data-m="5" d="M425.582 335.425H518.985" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="5" role="button" tabindex="0" aria-label="Hips"><title>5 · Hips</title><path d="M528.6 345.126C535.428 345.126 540.963 340.783 540.963 335.425C540.963 330.066 535.428 325.723 528.6 325.723C521.773 325.723 516.238 330.066 516.238 335.425C516.238 340.783 521.773 345.126 528.6 345.126Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M529.003 335.819C528.516 335.819 528.082 335.73 527.701 335.55C527.322 335.371 527.021 335.124 526.798 334.81C526.575 334.495 526.459 334.134 526.45 333.728H527.897C527.913 334.001 528.028 334.223 528.242 334.393C528.455 334.563 528.709 334.648 529.003 334.648C529.237 334.648 529.444 334.596 529.623 334.493C529.804 334.387 529.946 334.241 530.047 334.055C530.15 333.867 530.202 333.651 530.202 333.408C530.202 333.16 530.149 332.941 530.043 332.753C529.94 332.565 529.796 332.418 529.613 332.312C529.429 332.206 529.219 332.152 528.982 332.15C528.775 332.15 528.575 332.193 528.379 332.278C528.186 332.363 528.036 332.479 527.928 332.626L526.602 332.388L526.936 328.667H531.249V329.887H528.166L527.983 331.654H528.024C528.148 331.48 528.336 331.335 528.586 331.22C528.836 331.105 529.117 331.048 529.427 331.048C529.851 331.048 530.23 331.148 530.563 331.347C530.896 331.547 531.159 331.822 531.352 332.171C531.545 332.518 531.641 332.917 531.638 333.37C531.641 333.845 531.53 334.268 531.308 334.637C531.087 335.005 530.778 335.294 530.381 335.506C529.986 335.715 529.527 335.819 529.003 335.819Z" fill="white"/></g>
<path class="mp-guide" data-m="6" d="M462.668 185.583H481.898" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="6" role="button" tabindex="0" aria-label="Neck Width"><title>6 · Neck Width</title><path d="M497.008 195.285C503.835 195.285 509.37 190.941 509.37 185.583C509.37 180.225 503.835 175.881 497.008 175.881C490.18 175.881 484.646 180.225 484.646 185.583C484.646 190.941 490.18 195.285 497.008 195.285Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M497.464 185.977C497.101 185.975 496.751 185.914 496.413 185.795C496.078 185.675 495.777 185.481 495.511 185.213C495.244 184.944 495.033 184.588 494.877 184.145C494.723 183.701 494.646 183.157 494.646 182.512C494.648 181.919 494.716 181.39 494.849 180.923C494.985 180.455 495.178 180.058 495.428 179.731C495.681 179.405 495.983 179.157 496.334 178.987C496.686 178.815 497.08 178.729 497.516 178.729C497.987 178.729 498.402 178.821 498.763 179.005C499.124 179.186 499.413 179.433 499.631 179.745C499.852 180.058 499.985 180.408 500.031 180.796H498.56C498.502 180.55 498.382 180.357 498.198 180.217C498.014 180.077 497.787 180.007 497.516 180.007C497.057 180.007 496.707 180.207 496.469 180.607C496.232 181.006 496.111 181.549 496.107 182.236H496.155C496.261 182.027 496.403 181.849 496.582 181.702C496.764 181.553 496.969 181.439 497.199 181.361C497.431 181.281 497.676 181.24 497.933 181.24C498.351 181.24 498.723 181.339 499.049 181.537C499.375 181.732 499.632 182.001 499.821 182.343C500.009 182.685 500.103 183.077 500.103 183.518C500.103 183.995 499.992 184.42 499.769 184.792C499.548 185.164 499.24 185.456 498.842 185.667C498.447 185.876 497.988 185.98 497.464 185.977ZM497.457 184.806C497.687 184.806 497.893 184.751 498.074 184.641C498.255 184.53 498.398 184.381 498.501 184.193C498.605 184.004 498.656 183.793 498.656 183.559C498.656 183.325 498.605 183.114 498.501 182.928C498.4 182.742 498.26 182.594 498.081 182.484C497.902 182.374 497.697 182.319 497.468 182.319C497.295 182.319 497.136 182.351 496.989 182.415C496.844 182.479 496.717 182.569 496.606 182.684C496.498 182.799 496.413 182.932 496.351 183.083C496.289 183.233 496.258 183.392 496.258 183.562C496.258 183.79 496.31 183.998 496.413 184.186C496.519 184.374 496.662 184.525 496.841 184.637C497.022 184.75 497.228 184.806 497.457 184.806Z" fill="white"/></g>
<path class="mp-guide" data-m="7" d="M428.328 396.871H470.909" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="7" role="button" tabindex="0" aria-label="Thigh"><title>7 · Thigh</title><path d="M414.593 406.572C421.42 406.572 426.955 402.229 426.955 396.87C426.955 391.512 421.42 387.168 414.593 387.168C407.765 387.168 402.23 391.512 402.23 396.87C402.23 402.229 407.765 406.572 414.593 406.572Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M411.438 397.168L414.363 391.381V391.333H410.956V390.113H415.906V391.35L412.978 397.168H411.438Z" fill="white"/></g>
<path class="mp-guide" data-m="8" d="M436.57 572.584H461.295" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="8" role="button" tabindex="0" aria-label="Leg Opening"><title>8 · Leg Opening</title><path d="M422.835 582.286C429.662 582.286 435.197 577.942 435.197 572.584C435.197 567.226 429.662 562.882 422.835 562.882C416.007 562.882 410.473 567.226 410.473 572.584C410.473 577.942 416.007 582.286 422.835 582.286Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M423.211 572.979C422.68 572.979 422.208 572.893 421.795 572.72C421.384 572.546 421.061 572.308 420.827 572.007C420.593 571.706 420.475 571.365 420.475 570.984C420.475 570.69 420.542 570.42 420.675 570.175C420.811 569.926 420.995 569.721 421.227 569.558C421.458 569.393 421.718 569.287 422.005 569.241V569.193C421.628 569.117 421.323 568.934 421.089 568.645C420.854 568.353 420.737 568.014 420.737 567.629C420.737 567.263 420.844 566.938 421.058 566.654C421.271 566.367 421.564 566.142 421.936 565.978C422.311 565.813 422.735 565.73 423.211 565.73C423.686 565.73 424.11 565.813 424.482 565.978C424.856 566.144 425.15 566.37 425.364 566.657C425.578 566.942 425.686 567.266 425.688 567.629C425.686 568.017 425.566 568.356 425.33 568.645C425.093 568.934 424.79 569.117 424.42 569.193V569.241C424.703 569.287 424.959 569.393 425.188 569.558C425.42 569.721 425.604 569.926 425.74 570.175C425.877 570.42 425.947 570.69 425.95 570.984C425.947 571.365 425.829 571.706 425.595 572.007C425.361 572.308 425.037 572.546 424.623 572.72C424.212 572.893 423.741 572.979 423.211 572.979ZM423.211 571.883C423.447 571.883 423.654 571.841 423.831 571.756C424.008 571.669 424.146 571.549 424.244 571.398C424.345 571.244 424.396 571.067 424.396 570.867C424.396 570.663 424.344 570.482 424.241 570.326C424.138 570.168 423.997 570.044 423.821 569.954C423.644 569.862 423.441 569.816 423.211 569.816C422.983 569.816 422.78 569.862 422.601 569.954C422.422 570.044 422.281 570.168 422.177 570.326C422.076 570.482 422.026 570.663 422.026 570.867C422.026 571.067 422.075 571.244 422.174 571.398C422.273 571.549 422.412 571.669 422.591 571.756C422.77 571.841 422.977 571.883 423.211 571.883ZM423.211 568.731C423.408 568.731 423.584 568.691 423.738 568.61C423.892 568.53 424.012 568.419 424.1 568.276C424.187 568.134 424.231 567.97 424.231 567.784C424.231 567.6 424.187 567.439 424.1 567.301C424.012 567.161 423.893 567.052 423.741 566.974C423.59 566.894 423.413 566.854 423.211 566.854C423.011 566.854 422.834 566.894 422.68 566.974C422.526 567.052 422.406 567.161 422.319 567.301C422.234 567.439 422.191 567.6 422.191 567.784C422.191 567.97 422.235 568.134 422.322 568.276C422.409 568.419 422.53 568.53 422.684 568.61C422.838 568.691 423.013 568.731 423.211 568.731Z" fill="white"/></g>
<path class="mp-guide" data-m="9" d="M414.593 204.986H529.973" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="9" role="button" tabindex="0" aria-label="Across Shoulder"><title>9 · Across Shoulder</title><path d="M540.963 214.688C547.79 214.688 553.325 210.345 553.325 204.987C553.325 199.628 547.79 195.285 540.963 195.285C534.135 195.285 528.601 199.628 528.601 204.987C528.601 210.345 534.135 214.688 540.963 214.688Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M541.264 198.133C541.627 198.133 541.976 198.194 542.312 198.315C542.649 198.437 542.95 198.631 543.214 198.898C543.481 199.164 543.691 199.518 543.845 199.959C544.001 200.397 544.08 200.936 544.082 201.574C544.082 202.174 544.015 202.709 543.879 203.18C543.746 203.648 543.554 204.047 543.304 204.375C543.053 204.704 542.751 204.954 542.398 205.126C542.044 205.296 541.649 205.381 541.213 205.381C540.742 205.381 540.326 205.29 539.966 205.109C539.605 204.925 539.314 204.676 539.094 204.361C538.876 204.044 538.744 203.688 538.698 203.293H540.169C540.226 203.551 540.347 203.75 540.53 203.893C540.714 204.033 540.942 204.103 541.213 204.103C541.672 204.103 542.021 203.903 542.26 203.504C542.499 203.102 542.619 202.552 542.622 201.853H542.573C542.468 202.06 542.325 202.238 542.146 202.387C541.967 202.534 541.762 202.648 541.53 202.728C541.3 202.809 541.055 202.849 540.796 202.849C540.38 202.849 540.009 202.751 539.683 202.556C539.357 202.361 539.1 202.092 538.911 201.75C538.723 201.408 538.629 201.017 538.629 200.579C538.627 200.106 538.736 199.684 538.956 199.314C539.177 198.945 539.484 198.655 539.879 198.446C540.277 198.235 540.738 198.13 541.264 198.133ZM541.275 199.304C541.043 199.304 540.836 199.359 540.655 199.469C540.475 199.58 540.333 199.728 540.227 199.914C540.124 200.1 540.073 200.308 540.076 200.537C540.076 200.769 540.126 200.978 540.227 201.164C540.331 201.348 540.471 201.495 540.648 201.605C540.827 201.713 541.031 201.767 541.261 201.767C541.433 201.767 541.593 201.735 541.74 201.671C541.887 201.607 542.014 201.518 542.122 201.406C542.232 201.291 542.318 201.159 542.38 201.009C542.442 200.86 542.473 200.702 542.473 200.534C542.471 200.311 542.418 200.107 542.315 199.921C542.212 199.735 542.069 199.585 541.888 199.473C541.706 199.36 541.502 199.304 541.275 199.304Z" fill="white"/></g>
<path class="mp-guide" data-m="10" d="M403.605 213.611L370.639 351.595" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="10" role="button" tabindex="0" aria-label="Sleeve Length"><title>10 · Sleeve Length</title><path d="M384.375 290.148C391.202 290.148 396.737 285.805 396.737 280.447C396.737 275.088 391.202 270.745 384.375 270.745C377.547 270.745 372.013 275.088 372.013 280.447C372.013 285.805 377.547 290.148 384.375 290.148Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M380.475 273.689V280.745H378.983V275.105H378.942L377.326 276.118V274.795L379.072 273.689H380.475ZM384.918 280.9C384.325 280.897 383.815 280.752 383.388 280.462C382.963 280.173 382.636 279.754 382.406 279.205C382.179 278.656 382.066 277.995 382.069 277.224C382.069 276.454 382.182 275.799 382.41 275.257C382.639 274.715 382.967 274.302 383.392 274.02C383.819 273.735 384.328 273.593 384.918 273.593C385.508 273.593 386.016 273.735 386.441 274.02C386.868 274.305 387.196 274.718 387.426 275.26C387.655 275.8 387.769 276.454 387.767 277.224C387.767 277.998 387.652 278.659 387.422 279.208C387.195 279.757 386.869 280.176 386.444 280.466C386.019 280.755 385.51 280.9 384.918 280.9ZM384.918 279.663C385.322 279.663 385.645 279.46 385.886 279.053C386.127 278.647 386.246 278.037 386.244 277.224C386.244 276.689 386.189 276.243 386.079 275.887C385.971 275.531 385.817 275.264 385.617 275.084C385.42 274.905 385.187 274.816 384.918 274.816C384.516 274.816 384.194 275.017 383.953 275.419C383.712 275.821 383.59 276.422 383.588 277.224C383.588 277.766 383.642 278.218 383.75 278.581C383.86 278.942 384.015 279.213 384.215 279.394C384.415 279.573 384.649 279.663 384.918 279.663Z" fill="white"/></g>
<path class="mp-guide" data-m="11" d="M373.385 368.842L392.615 370.998" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="11" role="button" tabindex="0" aria-label="Cuff Opening"><title>11 · Cuff Opening</title><path d="M372.012 365.608C378.839 365.608 384.374 361.265 384.374 355.906C384.374 350.548 378.839 346.205 372.012 346.205C365.184 346.205 359.649 350.548 359.649 355.906C359.649 361.265 365.184 365.608 372.012 365.608Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M369.452 349.149V356.205H367.96V350.565H367.919L366.303 351.578V350.255L368.05 349.149H369.452ZM374.198 349.149V356.205H372.706V350.565H372.665L371.049 351.578V350.255L372.796 349.149H374.198Z" fill="white"/></g>
<path class="mp-guide" data-m="12" d="M448.933 155.399H495.634" stroke-width="1.72466" stroke="#B9BEC7"/>
<g class="mp-marker" data-m="12" role="button" tabindex="0" aria-label="Head Circumference"><title>12 · Head Circumference</title><path d="M510.744 154.321C517.571 154.321 523.106 149.977 523.106 144.619C523.106 139.261 517.571 134.917 510.744 134.917C503.917 134.917 498.382 139.261 498.382 144.619C498.382 149.977 503.917 154.321 510.744 154.321Z" fill="#16181D" stroke-width="1.61687" stroke="white"/><path d="M508.902 137.862V144.917H507.411V139.277H507.369L505.754 140.29V138.967L507.5 137.862H508.902ZM510.579 144.917V143.842L513.091 141.517C513.304 141.31 513.483 141.124 513.628 140.959C513.775 140.793 513.886 140.631 513.962 140.473C514.038 140.312 514.076 140.139 514.076 139.953C514.076 139.746 514.029 139.568 513.935 139.419C513.841 139.267 513.712 139.151 513.549 139.071C513.386 138.988 513.201 138.947 512.994 138.947C512.778 138.947 512.59 138.99 512.429 139.078C512.268 139.165 512.144 139.29 512.057 139.453C511.97 139.616 511.926 139.81 511.926 140.035H510.51C510.51 139.574 510.615 139.173 510.824 138.833C511.033 138.493 511.326 138.23 511.702 138.044C512.079 137.858 512.513 137.765 513.005 137.765C513.51 137.765 513.95 137.855 514.324 138.034C514.701 138.211 514.993 138.456 515.202 138.771C515.411 139.086 515.516 139.446 515.516 139.853C515.516 140.119 515.463 140.382 515.357 140.642C515.254 140.901 515.069 141.189 514.803 141.506C514.536 141.821 514.161 142.199 513.676 142.64L512.646 143.649V143.697H515.609V144.917H510.579Z" fill="white"/></g>
<path d="M169.584 626.769C169.533 626.338 169.326 626.002 168.962 625.764C168.599 625.525 168.153 625.406 167.624 625.406C167.238 625.406 166.9 625.468 166.61 625.593C166.323 625.718 166.099 625.89 165.937 626.109C165.778 626.328 165.698 626.576 165.698 626.855C165.698 627.088 165.753 627.288 165.864 627.456C165.978 627.62 166.123 627.758 166.299 627.869C166.475 627.977 166.66 628.066 166.853 628.137C167.046 628.206 167.224 628.261 167.386 628.304L168.272 628.542C168.499 628.602 168.752 628.684 169.03 628.789C169.312 628.894 169.58 629.038 169.836 629.22C170.094 629.399 170.307 629.629 170.475 629.91C170.643 630.191 170.726 630.537 170.726 630.946C170.726 631.417 170.603 631.843 170.356 632.224C170.111 632.605 169.753 632.907 169.282 633.132C168.813 633.356 168.244 633.468 167.573 633.468C166.948 633.468 166.407 633.367 165.949 633.166C165.495 632.964 165.137 632.683 164.876 632.322C164.617 631.961 164.471 631.542 164.437 631.065H165.528C165.556 631.394 165.667 631.667 165.86 631.883C166.056 632.096 166.303 632.255 166.601 632.36C166.903 632.463 167.226 632.514 167.573 632.514C167.976 632.514 168.339 632.448 168.66 632.318C168.981 632.184 169.235 632 169.422 631.764C169.61 631.525 169.704 631.247 169.704 630.929C169.704 630.639 169.623 630.403 169.461 630.221C169.299 630.039 169.086 629.892 168.822 629.778C168.557 629.664 168.272 629.565 167.965 629.48L166.891 629.173C166.209 628.977 165.67 628.697 165.272 628.333C164.874 627.97 164.675 627.494 164.675 626.906C164.675 626.417 164.807 625.991 165.072 625.627C165.339 625.261 165.697 624.977 166.146 624.775C166.597 624.571 167.101 624.468 167.658 624.468C168.221 624.468 168.721 624.569 169.158 624.771C169.596 624.97 169.942 625.242 170.198 625.589C170.457 625.936 170.593 626.329 170.607 626.769H169.584ZM175.072 633.451C174.441 633.451 173.897 633.312 173.44 633.034C172.985 632.752 172.634 632.36 172.387 631.858C172.143 631.352 172.021 630.764 172.021 630.093C172.021 629.423 172.143 628.832 172.387 628.321C172.634 627.806 172.978 627.406 173.419 627.119C173.862 626.829 174.379 626.684 174.97 626.684C175.311 626.684 175.647 626.741 175.98 626.855C176.312 626.968 176.615 627.153 176.887 627.409C177.16 627.662 177.377 627.997 177.539 628.414C177.701 628.832 177.782 629.346 177.782 629.957V630.383H172.737V629.514H176.759C176.759 629.144 176.686 628.815 176.538 628.525C176.393 628.235 176.186 628.007 175.916 627.839C175.649 627.671 175.333 627.588 174.97 627.588C174.569 627.588 174.223 627.687 173.93 627.886C173.64 628.082 173.417 628.338 173.261 628.653C173.105 628.968 173.027 629.306 173.027 629.667V630.247C173.027 630.741 173.112 631.16 173.282 631.504C173.456 631.845 173.696 632.105 174.002 632.284C174.309 632.46 174.666 632.548 175.072 632.548C175.336 632.548 175.575 632.511 175.788 632.437C176.004 632.36 176.19 632.247 176.346 632.096C176.502 631.943 176.623 631.752 176.708 631.525L177.68 631.798C177.578 632.127 177.406 632.417 177.164 632.667C176.923 632.914 176.625 633.108 176.269 633.247C175.914 633.383 175.515 633.451 175.072 633.451ZM180.318 624.588V633.315H179.312V624.588H180.318ZM184.904 633.451C184.273 633.451 183.729 633.312 183.272 633.034C182.817 632.752 182.467 632.36 182.219 631.858C181.975 631.352 181.853 630.764 181.853 630.093C181.853 629.423 181.975 628.832 182.219 628.321C182.467 627.806 182.81 627.406 183.251 627.119C183.694 626.829 184.211 626.684 184.802 626.684C185.143 626.684 185.479 626.741 185.812 626.855C186.144 626.968 186.447 627.153 186.719 627.409C186.992 627.662 187.209 627.997 187.371 628.414C187.533 628.832 187.614 629.346 187.614 629.957V630.383H182.569V629.514H186.592C186.592 629.144 186.518 628.815 186.37 628.525C186.225 628.235 186.018 628.007 185.748 627.839C185.481 627.671 185.165 627.588 184.802 627.588C184.401 627.588 184.055 627.687 183.762 627.886C183.472 628.082 183.249 628.338 183.093 628.653C182.937 628.968 182.859 629.306 182.859 629.667V630.247C182.859 630.741 182.944 631.16 183.114 631.504C183.288 631.845 183.528 632.105 183.834 632.284C184.141 632.46 184.498 632.548 184.904 632.548C185.168 632.548 185.407 632.511 185.62 632.437C185.836 632.36 186.022 632.247 186.178 632.096C186.334 631.943 186.455 631.752 186.54 631.525L187.512 631.798C187.41 632.127 187.238 632.417 186.996 632.667C186.755 632.914 186.457 633.108 186.101 633.247C185.746 633.383 185.347 633.451 184.904 633.451ZM191.803 633.451C191.19 633.451 190.661 633.306 190.218 633.017C189.775 632.727 189.434 632.328 189.195 631.819C188.957 631.311 188.837 630.73 188.837 630.076C188.837 629.412 188.959 628.825 189.204 628.316C189.451 627.805 189.795 627.406 190.235 627.119C190.678 626.829 191.195 626.684 191.786 626.684C192.246 626.684 192.661 626.769 193.03 626.94C193.4 627.11 193.702 627.349 193.938 627.656C194.174 627.963 194.32 628.321 194.377 628.73H193.371C193.295 628.431 193.124 628.167 192.86 627.937C192.599 627.704 192.246 627.588 191.803 627.588C191.411 627.588 191.067 627.69 190.772 627.894C190.479 628.096 190.251 628.382 190.086 628.751C189.924 629.117 189.843 629.548 189.843 630.042C189.843 630.548 189.922 630.988 190.082 631.363C190.244 631.738 190.471 632.029 190.763 632.237C191.059 632.444 191.405 632.548 191.803 632.548C192.065 632.548 192.302 632.502 192.515 632.412C192.728 632.321 192.908 632.19 193.056 632.019C193.204 631.849 193.309 631.644 193.371 631.406H194.377C194.32 631.792 194.18 632.14 193.955 632.45C193.734 632.757 193.44 633.001 193.073 633.183C192.709 633.362 192.286 633.451 191.803 633.451ZM198.694 626.769V627.622H195.302V626.769H198.694ZM196.29 625.201H197.296V631.44C197.296 631.724 197.337 631.937 197.42 632.079C197.505 632.218 197.613 632.312 197.744 632.36C197.877 632.406 198.018 632.429 198.165 632.429C198.276 632.429 198.367 632.423 198.438 632.412C198.509 632.397 198.566 632.386 198.609 632.377L198.813 633.281C198.745 633.306 198.65 633.332 198.528 633.358C198.405 633.386 198.251 633.4 198.063 633.4C197.779 633.4 197.501 633.339 197.228 633.217C196.958 633.095 196.734 632.909 196.555 632.659C196.378 632.409 196.29 632.093 196.29 631.713V625.201ZM205.508 633.468C205.093 633.468 204.717 633.39 204.378 633.234C204.04 633.075 203.772 632.846 203.573 632.548C203.374 632.247 203.275 631.883 203.275 631.457C203.275 631.082 203.349 630.778 203.496 630.545C203.644 630.309 203.842 630.125 204.089 629.991C204.336 629.858 204.609 629.758 204.907 629.693C205.208 629.625 205.511 629.571 205.815 629.531C206.212 629.48 206.535 629.441 206.782 629.416C207.032 629.387 207.214 629.341 207.327 629.275C207.444 629.21 207.502 629.096 207.502 628.934V628.9C207.502 628.48 207.387 628.153 207.157 627.92C206.93 627.687 206.584 627.571 206.121 627.571C205.641 627.571 205.265 627.676 204.992 627.886C204.719 628.096 204.528 628.321 204.417 628.559L203.462 628.218C203.633 627.821 203.86 627.511 204.144 627.289C204.431 627.065 204.744 626.909 205.082 626.821C205.422 626.73 205.758 626.684 206.087 626.684C206.297 626.684 206.539 626.71 206.812 626.761C207.087 626.809 207.353 626.91 207.609 627.064C207.867 627.217 208.082 627.448 208.252 627.758C208.422 628.068 208.508 628.483 208.508 629.002V633.315H207.502V632.429H207.451C207.383 632.571 207.269 632.723 207.11 632.885C206.951 633.046 206.739 633.184 206.475 633.298C206.211 633.412 205.888 633.468 205.508 633.468ZM205.661 632.565C206.059 632.565 206.394 632.487 206.667 632.331C206.942 632.174 207.15 631.973 207.289 631.725C207.431 631.478 207.502 631.218 207.502 630.946V630.025C207.459 630.076 207.366 630.123 207.221 630.166C207.079 630.206 206.914 630.241 206.726 630.272C206.542 630.301 206.361 630.326 206.185 630.349C206.012 630.369 205.871 630.386 205.763 630.4C205.502 630.434 205.258 630.49 205.03 630.566C204.806 630.64 204.624 630.752 204.485 630.903C204.349 631.051 204.28 631.252 204.28 631.508C204.28 631.858 204.41 632.122 204.668 632.301C204.93 632.477 205.261 632.565 205.661 632.565ZM213.718 633.315V626.769H214.69V627.792H214.775C214.911 627.443 215.132 627.171 215.436 626.978C215.74 626.782 216.105 626.684 216.531 626.684C216.963 626.684 217.322 626.782 217.609 626.978C217.899 627.171 218.125 627.443 218.286 627.792H218.355C218.522 627.454 218.774 627.186 219.109 626.987C219.444 626.785 219.846 626.684 220.315 626.684C220.9 626.684 221.379 626.867 221.751 627.234C222.123 627.598 222.309 628.164 222.309 628.934V633.315H221.304V628.934C221.304 628.451 221.171 628.106 220.907 627.899C220.643 627.691 220.332 627.588 219.974 627.588C219.514 627.588 219.157 627.727 218.904 628.005C218.652 628.281 218.525 628.63 218.525 629.054V633.315H217.502V628.832C217.502 628.46 217.382 628.16 217.14 627.933C216.899 627.703 216.588 627.588 216.207 627.588C215.946 627.588 215.701 627.657 215.474 627.796C215.25 627.936 215.068 628.129 214.929 628.376C214.792 628.62 214.724 628.903 214.724 629.224V633.315H213.718ZM226.892 633.451C226.262 633.451 225.718 633.312 225.26 633.034C224.806 632.752 224.455 632.36 224.208 631.858C223.963 631.352 223.841 630.764 223.841 630.093C223.841 629.423 223.963 628.832 224.208 628.321C224.455 627.806 224.799 627.406 225.239 627.119C225.682 626.829 226.199 626.684 226.79 626.684C227.131 626.684 227.468 626.741 227.8 626.855C228.132 626.968 228.435 627.153 228.708 627.409C228.98 627.662 229.198 627.997 229.36 628.414C229.522 628.832 229.603 629.346 229.603 629.957V630.383H224.557V629.514H228.58C228.58 629.144 228.506 628.815 228.358 628.525C228.213 628.235 228.006 628.007 227.736 627.839C227.469 627.671 227.154 627.588 226.79 627.588C226.389 627.588 226.043 627.687 225.75 627.886C225.46 628.082 225.237 628.338 225.081 628.653C224.925 628.968 224.847 629.306 224.847 629.667V630.247C224.847 630.741 224.932 631.16 225.103 631.504C225.276 631.845 225.516 632.105 225.823 632.284C226.13 632.46 226.486 632.548 226.892 632.548C227.157 632.548 227.395 632.511 227.608 632.437C227.824 632.36 228.01 632.247 228.166 632.096C228.323 631.943 228.443 631.752 228.529 631.525L229.5 631.798C229.398 632.127 229.226 632.417 228.985 632.667C228.743 632.914 228.445 633.108 228.09 633.247C227.735 633.383 227.335 633.451 226.892 633.451ZM233.059 633.468C232.644 633.468 232.267 633.39 231.929 633.234C231.591 633.075 231.323 632.846 231.124 632.548C230.925 632.247 230.826 631.883 230.826 631.457C230.826 631.082 230.899 630.778 231.047 630.545C231.195 630.309 231.392 630.125 231.639 629.991C231.887 629.858 232.159 629.758 232.458 629.693C232.759 629.625 233.061 629.571 233.365 629.531C233.763 629.48 234.085 629.441 234.333 629.416C234.583 629.387 234.764 629.341 234.878 629.275C234.995 629.21 235.053 629.096 235.053 628.934V628.9C235.053 628.48 234.938 628.153 234.708 627.92C234.48 627.687 234.135 627.571 233.672 627.571C233.192 627.571 232.816 627.676 232.543 627.886C232.27 628.096 232.078 628.321 231.968 628.559L231.013 628.218C231.184 627.821 231.411 627.511 231.695 627.289C231.982 627.065 232.294 626.909 232.632 626.821C232.973 626.73 233.309 626.684 233.638 626.684C233.848 626.684 234.09 626.71 234.362 626.761C234.638 626.809 234.904 626.91 235.159 627.064C235.418 627.217 235.632 627.448 235.803 627.758C235.973 628.068 236.059 628.483 236.059 629.002V633.315H235.053V632.429H235.002C234.934 632.571 234.82 632.723 234.661 632.885C234.502 633.046 234.29 633.184 234.026 633.298C233.762 633.412 233.439 633.468 233.059 633.468ZM233.212 632.565C233.61 632.565 233.945 632.487 234.218 632.331C234.493 632.174 234.701 631.973 234.84 631.725C234.982 631.478 235.053 631.218 235.053 630.946V630.025C235.01 630.076 234.916 630.123 234.772 630.166C234.63 630.206 234.465 630.241 234.277 630.272C234.093 630.301 233.912 630.326 233.736 630.349C233.563 630.369 233.422 630.386 233.314 630.4C233.053 630.434 232.809 630.49 232.581 630.566C232.357 630.64 232.175 630.752 232.036 630.903C231.899 631.051 231.831 631.252 231.831 631.508C231.831 631.858 231.96 632.122 232.219 632.301C232.48 632.477 232.811 632.565 233.212 632.565ZM242.53 628.235L241.627 628.491C241.57 628.341 241.486 628.194 241.376 628.052C241.268 627.907 241.12 627.788 240.932 627.694C240.745 627.6 240.505 627.554 240.212 627.554C239.812 627.554 239.478 627.646 239.211 627.831C238.947 628.012 238.815 628.244 238.815 628.525C238.815 628.775 238.905 628.973 239.087 629.117C239.269 629.262 239.553 629.383 239.94 629.48L240.911 629.718C241.496 629.86 241.932 630.078 242.219 630.37C242.506 630.66 242.65 631.034 242.65 631.491C242.65 631.866 242.542 632.201 242.326 632.497C242.113 632.792 241.815 633.025 241.431 633.196C241.047 633.366 240.601 633.451 240.093 633.451C239.425 633.451 238.873 633.306 238.435 633.017C237.998 632.727 237.721 632.304 237.604 631.747L238.559 631.508C238.65 631.86 238.822 632.125 239.074 632.301C239.33 632.477 239.664 632.565 240.076 632.565C240.545 632.565 240.917 632.466 241.192 632.267C241.471 632.065 241.61 631.823 241.61 631.542C241.61 631.315 241.53 631.125 241.371 630.971C241.212 630.815 240.968 630.698 240.638 630.622L239.547 630.366C238.948 630.224 238.508 630.004 238.226 629.706C237.948 629.404 237.809 629.028 237.809 628.576C237.809 628.207 237.913 627.88 238.12 627.596C238.33 627.312 238.616 627.089 238.976 626.927C239.34 626.765 239.752 626.684 240.212 626.684C240.86 626.684 241.369 626.826 241.738 627.11C242.11 627.394 242.374 627.769 242.53 628.235ZM248.289 630.639V626.769H249.294V633.315H248.289V632.207H248.22C248.067 632.539 247.828 632.822 247.505 633.055C247.181 633.285 246.772 633.4 246.277 633.4C245.868 633.4 245.505 633.311 245.186 633.132C244.868 632.95 244.618 632.677 244.436 632.314C244.255 631.947 244.164 631.485 244.164 630.929V626.769H245.169V630.86C245.169 631.338 245.303 631.718 245.57 632.002C245.84 632.287 246.184 632.429 246.601 632.429C246.851 632.429 247.105 632.365 247.364 632.237C247.625 632.109 247.844 631.913 248.02 631.649C248.199 631.385 248.289 631.048 248.289 630.639ZM251.136 633.315V626.769H252.108V627.758H252.176C252.295 627.434 252.511 627.171 252.824 626.97C253.136 626.768 253.489 626.667 253.881 626.667C253.954 626.667 254.047 626.669 254.158 626.671C254.268 626.674 254.352 626.679 254.409 626.684V627.707C254.375 627.698 254.297 627.686 254.175 627.669C254.055 627.649 253.929 627.639 253.795 627.639C253.477 627.639 253.193 627.706 252.943 627.839C252.696 627.97 252.5 628.152 252.355 628.385C252.213 628.615 252.142 628.877 252.142 629.173V633.315H251.136ZM258.146 633.451C257.516 633.451 256.972 633.312 256.514 633.034C256.06 632.752 255.709 632.36 255.462 631.858C255.217 631.352 255.095 630.764 255.095 630.093C255.095 629.423 255.217 628.832 255.462 628.321C255.709 627.806 256.052 627.406 256.493 627.119C256.936 626.829 257.453 626.684 258.044 626.684C258.385 626.684 258.722 626.741 259.054 626.855C259.386 626.968 259.689 627.153 259.962 627.409C260.234 627.662 260.452 627.997 260.614 628.414C260.775 628.832 260.856 629.346 260.856 629.957V630.383H255.811V629.514H259.834C259.834 629.144 259.76 628.815 259.612 628.525C259.467 628.235 259.26 628.007 258.99 627.839C258.723 627.671 258.408 627.588 258.044 627.588C257.643 627.588 257.297 627.687 257.004 627.886C256.714 628.082 256.491 628.338 256.335 628.653C256.179 628.968 256.101 629.306 256.101 629.667V630.247C256.101 630.741 256.186 631.16 256.356 631.504C256.53 631.845 256.77 632.105 257.077 632.284C257.383 632.46 257.74 632.548 258.146 632.548C258.41 632.548 258.649 632.511 258.862 632.437C259.078 632.36 259.264 632.247 259.42 632.096C259.577 631.943 259.697 631.752 259.783 631.525L260.754 631.798C260.652 632.127 260.48 632.417 260.239 632.667C259.997 632.914 259.699 633.108 259.344 633.247C258.989 633.383 258.589 633.451 258.146 633.451ZM262.386 633.315V626.769H263.358V627.792H263.443C263.579 627.443 263.8 627.171 264.104 626.978C264.408 626.782 264.773 626.684 265.199 626.684C265.631 626.684 265.99 626.782 266.277 626.978C266.567 627.171 266.793 627.443 266.954 627.792H267.023C267.19 627.454 267.442 627.186 267.777 626.987C268.112 626.785 268.514 626.684 268.983 626.684C269.568 626.684 270.047 626.867 270.419 627.234C270.791 627.598 270.977 628.164 270.977 628.934V633.315H269.972V628.934C269.972 628.451 269.839 628.106 269.575 627.899C269.311 627.691 269 627.588 268.642 627.588C268.182 627.588 267.825 627.727 267.572 628.005C267.32 628.281 267.193 628.63 267.193 629.054V633.315H266.17V628.832C266.17 628.46 266.05 628.16 265.808 627.933C265.567 627.703 265.256 627.588 264.875 627.588C264.614 627.588 264.369 627.657 264.142 627.796C263.918 627.936 263.736 628.129 263.597 628.376C263.46 628.62 263.392 628.903 263.392 629.224V633.315H262.386ZM275.56 633.451C274.93 633.451 274.386 633.312 273.928 633.034C273.474 632.752 273.123 632.36 272.876 631.858C272.631 631.352 272.509 630.764 272.509 630.093C272.509 629.423 272.631 628.832 272.876 628.321C273.123 627.806 273.467 627.406 273.907 627.119C274.35 626.829 274.867 626.684 275.458 626.684C275.799 626.684 276.136 626.741 276.468 626.855C276.8 626.968 277.103 627.153 277.376 627.409C277.648 627.662 277.866 627.997 278.028 628.414C278.19 628.832 278.271 629.346 278.271 629.957V630.383H273.225V629.514H277.248C277.248 629.144 277.174 628.815 277.026 628.525C276.881 628.235 276.674 628.007 276.404 627.839C276.137 627.671 275.822 627.588 275.458 627.588C275.057 627.588 274.711 627.687 274.418 627.886C274.128 628.082 273.905 628.338 273.749 628.653C273.593 628.968 273.515 629.306 273.515 629.667V630.247C273.515 630.741 273.6 631.16 273.771 631.504C273.944 631.845 274.184 632.105 274.491 632.284C274.797 632.46 275.154 632.548 275.56 632.548C275.824 632.548 276.063 632.511 276.276 632.437C276.492 632.36 276.678 632.247 276.834 632.096C276.991 631.943 277.111 631.752 277.197 631.525L278.168 631.798C278.066 632.127 277.894 632.417 277.653 632.667C277.411 632.914 277.113 633.108 276.758 633.247C276.403 633.383 276.003 633.451 275.56 633.451ZM280.806 629.377V633.315H279.8V626.769H280.772V627.792H280.857C281.011 627.46 281.244 627.193 281.556 626.991C281.869 626.787 282.272 626.684 282.766 626.684C283.209 626.684 283.597 626.775 283.93 626.957C284.262 627.136 284.521 627.409 284.705 627.775C284.89 628.139 284.982 628.599 284.982 629.156V633.315H283.976V629.224C283.976 628.71 283.843 628.309 283.576 628.022C283.309 627.733 282.942 627.588 282.476 627.588C282.155 627.588 281.869 627.657 281.616 627.796C281.366 627.936 281.168 628.139 281.023 628.406C280.878 628.673 280.806 628.997 280.806 629.377ZM289.666 626.769V627.622H286.274V626.769H289.666ZM287.263 625.201H288.269V631.44C288.269 631.724 288.31 631.937 288.392 632.079C288.478 632.218 288.585 632.312 288.716 632.36C288.85 632.406 288.99 632.429 289.138 632.429C289.249 632.429 289.34 632.423 289.411 632.412C289.482 632.397 289.539 632.386 289.581 632.377L289.786 633.281C289.718 633.306 289.622 633.332 289.5 633.358C289.378 633.386 289.223 633.4 289.036 633.4C288.752 633.4 288.473 633.339 288.201 633.217C287.931 633.095 287.706 632.909 287.527 632.659C287.351 632.409 287.263 632.093 287.263 631.713V625.201ZM297.213 633.451C296.622 633.451 296.104 633.311 295.658 633.029C295.215 632.748 294.868 632.355 294.618 631.849C294.371 631.343 294.247 630.752 294.247 630.076C294.247 629.394 294.371 628.799 294.618 628.291C294.868 627.782 295.215 627.387 295.658 627.106C296.104 626.825 296.622 626.684 297.213 626.684C297.804 626.684 298.321 626.825 298.764 627.106C299.21 627.387 299.557 627.782 299.804 628.291C300.054 628.799 300.179 629.394 300.179 630.076C300.179 630.752 300.054 631.343 299.804 631.849C299.557 632.355 299.21 632.748 298.764 633.029C298.321 633.311 297.804 633.451 297.213 633.451ZM297.213 632.548C297.662 632.548 298.032 632.433 298.321 632.203C298.611 631.973 298.826 631.67 298.965 631.295C299.104 630.92 299.174 630.514 299.174 630.076C299.174 629.639 299.104 629.231 298.965 628.853C298.826 628.475 298.611 628.17 298.321 627.937C298.032 627.704 297.662 627.588 297.213 627.588C296.764 627.588 296.395 627.704 296.105 627.937C295.816 628.17 295.601 628.475 295.462 628.853C295.323 629.231 295.253 629.639 295.253 630.076C295.253 630.514 295.323 630.92 295.462 631.295C295.601 631.67 295.816 631.973 296.105 632.203C296.395 632.433 296.764 632.548 297.213 632.548ZM301.714 633.315V626.769H302.686V627.758H302.754C302.873 627.434 303.089 627.171 303.402 626.97C303.714 626.768 304.067 626.667 304.459 626.667C304.533 626.667 304.625 626.669 304.736 626.671C304.846 626.674 304.93 626.679 304.987 626.684V627.707C304.953 627.698 304.875 627.686 304.753 627.669C304.633 627.649 304.507 627.639 304.373 627.639C304.055 627.639 303.771 627.706 303.521 627.839C303.274 627.97 303.078 628.152 302.933 628.385C302.791 628.615 302.72 628.877 302.72 629.173V633.315H301.714ZM309.554 633.315V626.769H310.526V627.792H310.611C310.747 627.443 310.968 627.171 311.272 626.978C311.576 626.782 311.941 626.684 312.367 626.684C312.799 626.684 313.158 626.782 313.445 626.978C313.735 627.171 313.96 627.443 314.122 627.792H314.191C314.358 627.454 314.61 627.186 314.945 626.987C315.28 626.785 315.682 626.684 316.151 626.684C316.736 626.684 317.215 626.867 317.587 627.234C317.959 627.598 318.145 628.164 318.145 628.934V633.315H317.139V628.934C317.139 628.451 317.007 628.106 316.743 627.899C316.479 627.691 316.168 627.588 315.81 627.588C315.35 627.588 314.993 627.727 314.74 628.005C314.487 628.281 314.361 628.63 314.361 629.054V633.315H313.338V628.832C313.338 628.46 313.218 628.16 312.976 627.933C312.735 627.703 312.424 627.588 312.043 627.588C311.782 627.588 311.537 627.657 311.31 627.796C311.085 627.936 310.904 628.129 310.764 628.376C310.628 628.62 310.56 628.903 310.56 629.224V633.315H309.554ZM321.91 633.468C321.495 633.468 321.119 633.39 320.781 633.234C320.443 633.075 320.174 632.846 319.975 632.548C319.777 632.247 319.677 631.883 319.677 631.457C319.677 631.082 319.751 630.778 319.899 630.545C320.046 630.309 320.244 630.125 320.491 629.991C320.738 629.858 321.011 629.758 321.309 629.693C321.61 629.625 321.913 629.571 322.217 629.531C322.615 629.48 322.937 629.441 323.184 629.416C323.434 629.387 323.616 629.341 323.73 629.275C323.846 629.21 323.904 629.096 323.904 628.934V628.9C323.904 628.48 323.789 628.153 323.559 627.92C323.332 627.687 322.987 627.571 322.524 627.571C322.044 627.571 321.667 627.676 321.394 627.886C321.122 628.096 320.93 628.321 320.819 628.559L319.865 628.218C320.035 627.821 320.262 627.511 320.546 627.289C320.833 627.065 321.146 626.909 321.484 626.821C321.825 626.73 322.16 626.684 322.49 626.684C322.7 626.684 322.941 626.71 323.214 626.761C323.49 626.809 323.755 626.91 324.011 627.064C324.269 627.217 324.484 627.448 324.654 627.758C324.825 628.068 324.91 628.483 324.91 629.002V633.315H323.904V632.429H323.853C323.785 632.571 323.671 632.723 323.512 632.885C323.353 633.046 323.142 633.184 322.877 633.298C322.613 633.412 322.291 633.468 321.91 633.468ZM322.063 632.565C322.461 632.565 322.796 632.487 323.069 632.331C323.345 632.174 323.552 631.973 323.691 631.725C323.833 631.478 323.904 631.218 323.904 630.946V630.025C323.862 630.076 323.768 630.123 323.623 630.166C323.481 630.206 323.316 630.241 323.129 630.272C322.944 630.301 322.764 630.326 322.588 630.349C322.414 630.369 322.274 630.386 322.166 630.4C321.904 630.434 321.66 630.49 321.433 630.566C321.208 630.64 321.027 630.752 320.887 630.903C320.751 631.051 320.683 631.252 320.683 631.508C320.683 631.858 320.812 632.122 321.071 632.301C321.332 632.477 321.663 632.565 322.063 632.565ZM326.746 633.315V626.769H327.717V627.758H327.785C327.905 627.434 328.121 627.171 328.433 626.97C328.746 626.768 329.098 626.667 329.49 626.667C329.564 626.667 329.656 626.669 329.767 626.671C329.878 626.674 329.962 626.679 330.018 626.684V627.707C329.984 627.698 329.906 627.686 329.784 627.669C329.665 627.649 329.538 627.639 329.405 627.639C329.087 627.639 328.802 627.706 328.552 627.839C328.305 627.97 328.109 628.152 327.964 628.385C327.822 628.615 327.751 628.877 327.751 629.173V633.315H326.746ZM332.148 630.929L332.131 629.684H332.335L335.199 626.769H336.443L333.392 629.855H333.307L332.148 630.929ZM331.21 633.315V624.588H332.216V633.315H331.21ZM335.37 633.315L332.813 630.076L333.529 629.377L336.648 633.315H335.37ZM340.213 633.451C339.582 633.451 339.038 633.312 338.581 633.034C338.126 632.752 337.775 632.36 337.528 631.858C337.284 631.352 337.161 630.764 337.161 630.093C337.161 629.423 337.284 628.832 337.528 628.321C337.775 627.806 338.119 627.406 338.559 627.119C339.002 626.829 339.519 626.684 340.11 626.684C340.451 626.684 340.788 626.741 341.12 626.855C341.453 626.968 341.755 627.153 342.028 627.409C342.301 627.662 342.518 627.997 342.68 628.414C342.842 628.832 342.923 629.346 342.923 629.957V630.383H337.877V629.514H341.9C341.9 629.144 341.826 628.815 341.679 628.525C341.534 628.235 341.326 628.007 341.056 627.839C340.789 627.671 340.474 627.588 340.11 627.588C339.71 627.588 339.363 627.687 339.071 627.886C338.781 628.082 338.558 628.338 338.402 628.653C338.245 628.968 338.167 629.306 338.167 629.667V630.247C338.167 630.741 338.252 631.16 338.423 631.504C338.596 631.845 338.836 632.105 339.143 632.284C339.45 632.46 339.806 632.548 340.213 632.548C340.477 632.548 340.715 632.511 340.929 632.437C341.144 632.36 341.331 632.247 341.487 632.096C341.643 631.943 341.764 631.752 341.849 631.525L342.821 631.798C342.718 632.127 342.546 632.417 342.305 632.667C342.063 632.914 341.765 633.108 341.41 633.247C341.055 633.383 340.656 633.451 340.213 633.451ZM344.453 633.315V626.769H345.424V627.758H345.492C345.612 627.434 345.828 627.171 346.14 626.97C346.453 626.768 346.805 626.667 347.197 626.667C347.271 626.667 347.363 626.669 347.474 626.671C347.585 626.674 347.669 626.679 347.725 626.684V627.707C347.691 627.698 347.613 627.686 347.491 627.669C347.372 627.649 347.245 627.639 347.112 627.639C346.794 627.639 346.51 627.706 346.26 627.839C346.012 627.97 345.816 628.152 345.671 628.385C345.529 628.615 345.458 628.877 345.458 629.173V633.315H344.453ZM355.139 626.769V627.622H351.747V626.769H355.139ZM352.736 625.201H353.741V631.44C353.741 631.724 353.783 631.937 353.865 632.079C353.95 632.218 354.058 632.312 354.189 632.36C354.322 632.406 354.463 632.429 354.611 632.429C354.721 632.429 354.812 632.423 354.883 632.412C354.954 632.397 355.011 632.386 355.054 632.377L355.258 633.281C355.19 633.306 355.095 633.332 354.973 633.358C354.851 633.386 354.696 633.4 354.508 633.4C354.224 633.4 353.946 633.339 353.673 633.217C353.403 633.095 353.179 632.909 353 632.659C352.824 632.409 352.736 632.093 352.736 631.713V625.201ZM359.241 633.451C358.65 633.451 358.131 633.311 357.685 633.029C357.242 632.748 356.896 632.355 356.646 631.849C356.398 631.343 356.275 630.752 356.275 630.076C356.275 629.394 356.398 628.799 356.646 628.291C356.896 627.782 357.242 627.387 357.685 627.106C358.131 626.825 358.65 626.684 359.241 626.684C359.832 626.684 360.349 626.825 360.792 627.106C361.238 627.387 361.584 627.782 361.832 628.291C362.082 628.799 362.207 629.394 362.207 630.076C362.207 630.752 362.082 631.343 361.832 631.849C361.584 632.355 361.238 632.748 360.792 633.029C360.349 633.311 359.832 633.451 359.241 633.451ZM359.241 632.548C359.69 632.548 360.059 632.433 360.349 632.203C360.638 631.973 360.853 631.67 360.992 631.295C361.131 630.92 361.201 630.514 361.201 630.076C361.201 629.639 361.131 629.231 360.992 628.853C360.853 628.475 360.638 628.17 360.349 627.937C360.059 627.704 359.69 627.588 359.241 627.588C358.792 627.588 358.423 627.704 358.133 627.937C357.843 628.17 357.628 628.475 357.489 628.853C357.35 629.231 357.28 629.639 357.28 630.076C357.28 630.514 357.35 630.92 357.489 631.295C357.628 631.67 357.843 631.973 358.133 632.203C358.423 632.433 358.792 632.548 359.241 632.548ZM368.122 629.377V633.315H367.117V624.588H368.122V627.792H368.208C368.361 627.454 368.591 627.186 368.898 626.987C369.208 626.785 369.62 626.684 370.134 626.684C370.58 626.684 370.97 626.774 371.306 626.953C371.641 627.129 371.901 627.4 372.085 627.767C372.273 628.13 372.367 628.593 372.367 629.156V633.315H371.361V629.224C371.361 628.704 371.226 628.302 370.956 628.018C370.689 627.731 370.318 627.588 369.844 627.588C369.514 627.588 369.219 627.657 368.958 627.796C368.699 627.936 368.495 628.139 368.344 628.406C368.196 628.673 368.122 628.997 368.122 629.377ZM374.207 633.315V626.769H375.212V633.315H374.207ZM374.718 625.679C374.522 625.679 374.353 625.612 374.211 625.478C374.072 625.345 374.002 625.184 374.002 624.997C374.002 624.809 374.072 624.649 374.211 624.515C374.353 624.382 374.522 624.315 374.718 624.315C374.914 624.315 375.082 624.382 375.221 624.515C375.363 624.649 375.434 624.809 375.434 624.997C375.434 625.184 375.363 625.345 375.221 625.478C375.082 625.612 374.914 625.679 374.718 625.679ZM379.696 635.906C379.21 635.906 378.793 635.843 378.443 635.718C378.094 635.596 377.803 635.434 377.57 635.233C377.34 635.034 377.157 634.821 377.02 634.593L377.821 634.031C377.912 634.15 378.027 634.287 378.166 634.44C378.306 634.596 378.496 634.731 378.737 634.845C378.982 634.961 379.301 635.019 379.696 635.019C380.225 635.019 380.661 634.892 381.005 634.636C381.348 634.38 381.52 633.98 381.52 633.434V632.105H381.435C381.361 632.224 381.256 632.372 381.12 632.548C380.986 632.721 380.793 632.876 380.54 633.012C380.29 633.146 379.952 633.213 379.526 633.213C378.997 633.213 378.523 633.088 378.103 632.838C377.685 632.588 377.354 632.224 377.11 631.747C376.868 631.269 376.747 630.69 376.747 630.008C376.747 629.338 376.865 628.754 377.101 628.257C377.337 627.757 377.665 627.37 378.085 627.098C378.506 626.822 378.992 626.684 379.543 626.684C379.969 626.684 380.307 626.755 380.557 626.897C380.81 627.037 381.003 627.196 381.137 627.375C381.273 627.551 381.378 627.696 381.452 627.809H381.554V626.769H382.526V633.502C382.526 634.065 382.398 634.522 382.142 634.875C381.889 635.23 381.549 635.49 381.12 635.654C380.693 635.822 380.219 635.906 379.696 635.906ZM379.662 632.309C380.066 632.309 380.407 632.217 380.685 632.032C380.963 631.848 381.175 631.582 381.32 631.235C381.465 630.889 381.537 630.474 381.537 629.991C381.537 629.519 381.466 629.103 381.324 628.742C381.182 628.382 380.972 628.099 380.693 627.894C380.415 627.69 380.071 627.588 379.662 627.588C379.236 627.588 378.881 627.696 378.597 627.912C378.316 628.127 378.104 628.417 377.962 628.781C377.823 629.144 377.753 629.548 377.753 629.991C377.753 630.446 377.824 630.848 377.966 631.197C378.111 631.544 378.324 631.816 378.605 632.015C378.889 632.211 379.242 632.309 379.662 632.309ZM385.372 629.377V633.315H384.367V624.588H385.372V627.792H385.458C385.611 627.454 385.841 627.186 386.148 626.987C386.458 626.785 386.87 626.684 387.384 626.684C387.83 626.684 388.22 626.774 388.556 626.953C388.891 627.129 389.151 627.4 389.335 627.767C389.523 628.13 389.617 628.593 389.617 629.156V633.315H388.611V629.224C388.611 628.704 388.476 628.302 388.206 628.018C387.939 627.731 387.568 627.588 387.094 627.588C386.764 627.588 386.469 627.657 386.208 627.796C385.949 627.936 385.745 628.139 385.594 628.406C385.446 628.673 385.372 628.997 385.372 629.377ZM392.462 624.588V633.315H391.457V624.588H392.462ZM394.304 633.315V626.769H395.31V633.315H394.304ZM394.816 625.679C394.62 625.679 394.451 625.612 394.309 625.478C394.169 625.345 394.1 625.184 394.1 624.997C394.1 624.809 394.169 624.649 394.309 624.515C394.451 624.382 394.62 624.315 394.816 624.315C395.012 624.315 395.179 624.382 395.318 624.515C395.46 624.649 395.532 624.809 395.532 624.997C395.532 625.184 395.46 625.345 395.318 625.478C395.179 625.612 395.012 625.679 394.816 625.679ZM399.794 635.906C399.308 635.906 398.891 635.843 398.541 635.718C398.192 635.596 397.9 635.434 397.668 635.233C397.437 635.034 397.254 634.821 397.118 634.593L397.919 634.031C398.01 634.15 398.125 634.287 398.264 634.44C398.403 634.596 398.594 634.731 398.835 634.845C399.079 634.961 399.399 635.019 399.794 635.019C400.322 635.019 400.758 634.892 401.102 634.636C401.446 634.38 401.618 633.98 401.618 633.434V632.105H401.533C401.459 632.224 401.354 632.372 401.217 632.548C401.084 632.721 400.891 632.876 400.638 633.012C400.388 633.146 400.05 633.213 399.623 633.213C399.095 633.213 398.621 633.088 398.2 632.838C397.783 632.588 397.452 632.224 397.207 631.747C396.966 631.269 396.845 630.69 396.845 630.008C396.845 629.338 396.963 628.754 397.199 628.257C397.435 627.757 397.763 627.37 398.183 627.098C398.604 626.822 399.089 626.684 399.641 626.684C400.067 626.684 400.405 626.755 400.655 626.897C400.908 627.037 401.101 627.196 401.234 627.375C401.371 627.551 401.476 627.696 401.55 627.809H401.652V626.769H402.623V633.502C402.623 634.065 402.496 634.522 402.24 634.875C401.987 635.23 401.646 635.49 401.217 635.654C400.791 635.822 400.317 635.906 399.794 635.906ZM399.76 632.309C400.163 632.309 400.504 632.217 400.783 632.032C401.061 631.848 401.273 631.582 401.418 631.235C401.562 630.889 401.635 630.474 401.635 629.991C401.635 629.519 401.564 629.103 401.422 628.742C401.28 628.382 401.07 628.099 400.791 627.894C400.513 627.69 400.169 627.588 399.76 627.588C399.334 627.588 398.979 627.696 398.695 627.912C398.413 628.127 398.202 628.417 398.06 628.781C397.92 629.144 397.851 629.548 397.851 629.991C397.851 630.446 397.922 630.848 398.064 631.197C398.209 631.544 398.422 631.816 398.703 632.015C398.987 632.211 399.339 632.309 399.76 632.309ZM405.47 629.377V633.315H404.464V624.588H405.47V627.792H405.555C405.709 627.454 405.939 627.186 406.246 626.987C406.555 626.785 406.967 626.684 407.481 626.684C407.927 626.684 408.318 626.774 408.653 626.953C408.989 627.129 409.248 627.4 409.433 627.767C409.621 628.13 409.714 628.593 409.714 629.156V633.315H408.709V629.224C408.709 628.704 408.574 628.302 408.304 628.018C408.037 627.731 407.666 627.588 407.192 627.588C406.862 627.588 406.567 627.657 406.305 627.796C406.047 627.936 405.842 628.139 405.692 628.406C405.544 628.673 405.47 628.997 405.47 629.377ZM414.401 626.769V627.622H411.009V626.769H414.401ZM411.997 625.201H413.003V631.44C413.003 631.724 413.044 631.937 413.127 632.079C413.212 632.218 413.32 632.312 413.451 632.36C413.584 632.406 413.725 632.429 413.872 632.429C413.983 632.429 414.074 632.423 414.145 632.412C414.216 632.397 414.273 632.386 414.316 632.377L414.52 633.281C414.452 633.306 414.357 633.332 414.235 633.358C414.112 633.386 413.958 633.4 413.77 633.4C413.486 633.4 413.208 633.339 412.935 633.217C412.665 633.095 412.441 632.909 412.262 632.659C412.085 632.409 411.997 632.093 411.997 631.713V625.201ZM419.289 633.315V626.769H420.294V633.315H419.289ZM419.8 625.679C419.604 625.679 419.435 625.612 419.293 625.478C419.154 625.345 419.084 625.184 419.084 624.997C419.084 624.809 419.154 624.649 419.293 624.515C419.435 624.382 419.604 624.315 419.8 624.315C419.996 624.315 420.164 624.382 420.303 624.515C420.445 624.649 420.516 624.809 420.516 624.997C420.516 625.184 420.445 625.345 420.303 625.478C420.164 625.612 419.996 625.679 419.8 625.679ZM424.983 626.769V627.622H421.591V626.769H424.983ZM422.579 625.201H423.585V631.44C423.585 631.724 423.626 631.937 423.709 632.079C423.794 632.218 423.902 632.312 424.033 632.36C424.166 632.406 424.307 632.429 424.454 632.429C424.565 632.429 424.656 632.423 424.727 632.412C424.798 632.397 424.855 632.386 424.898 632.377L425.102 633.281C425.034 633.306 424.939 633.332 424.817 633.358C424.695 633.386 424.54 633.4 424.352 633.4C424.068 633.4 423.79 633.339 423.517 633.217C423.247 633.095 423.023 632.909 422.844 632.659C422.668 632.409 422.579 632.093 422.579 631.713V625.201ZM432.53 633.451C431.939 633.451 431.42 633.311 430.974 633.029C430.531 632.748 430.185 632.355 429.935 631.849C429.687 631.343 429.564 630.752 429.564 630.076C429.564 629.394 429.687 628.799 429.935 628.291C430.185 627.782 430.531 627.387 430.974 627.106C431.42 626.825 431.939 626.684 432.53 626.684C433.121 626.684 433.638 626.825 434.081 627.106C434.527 627.387 434.874 627.782 435.121 628.291C435.371 628.799 435.496 629.394 435.496 630.076C435.496 630.752 435.371 631.343 435.121 631.849C434.874 632.355 434.527 632.748 434.081 633.029C433.638 633.311 433.121 633.451 432.53 633.451ZM432.53 632.548C432.979 632.548 433.348 632.433 433.638 632.203C433.927 631.973 434.142 631.67 434.281 631.295C434.42 630.92 434.49 630.514 434.49 630.076C434.49 629.639 434.42 629.231 434.281 628.853C434.142 628.475 433.927 628.17 433.638 627.937C433.348 627.704 432.979 627.588 432.53 627.588C432.081 627.588 431.712 627.704 431.422 627.937C431.132 628.17 430.918 628.475 430.778 628.853C430.639 629.231 430.57 629.639 430.57 630.076C430.57 630.514 430.639 630.92 430.778 631.295C430.918 631.67 431.132 631.973 431.422 632.203C431.712 632.433 432.081 632.548 432.53 632.548ZM438.036 629.377V633.315H437.031V626.769H438.002V627.792H438.088C438.241 627.46 438.474 627.193 438.786 626.991C439.099 626.787 439.502 626.684 439.997 626.684C440.44 626.684 440.828 626.775 441.16 626.957C441.492 627.136 441.751 627.409 441.936 627.775C442.12 628.139 442.213 628.599 442.213 629.156V633.315H441.207V629.224C441.207 628.71 441.073 628.309 440.806 628.022C440.539 627.733 440.173 627.588 439.707 627.588C439.386 627.588 439.099 627.657 438.846 627.796C438.596 627.936 438.399 628.139 438.254 628.406C438.109 628.673 438.036 628.997 438.036 629.377ZM450.272 626.769V627.622H446.88V626.769H450.272ZM447.869 625.201H448.874V631.44C448.874 631.724 448.915 631.937 448.998 632.079C449.083 632.218 449.191 632.312 449.322 632.36C449.455 632.406 449.596 632.429 449.744 632.429C449.854 632.429 449.945 632.423 450.016 632.412C450.087 632.397 450.144 632.386 450.187 632.377L450.391 633.281C450.323 633.306 450.228 633.332 450.106 633.358C449.984 633.386 449.829 633.4 449.641 633.4C449.357 633.4 449.079 633.339 448.806 633.217C448.536 633.095 448.312 632.909 448.133 632.659C447.957 632.409 447.869 632.093 447.869 631.713V625.201ZM452.931 629.377V633.315H451.925V624.588H452.931V627.792H453.016C453.17 627.454 453.4 627.186 453.707 626.987C454.016 626.785 454.428 626.684 454.942 626.684C455.388 626.684 455.779 626.774 456.114 626.953C456.449 627.129 456.709 627.4 456.894 627.767C457.082 628.13 457.175 628.593 457.175 629.156V633.315H456.17V629.224C456.17 628.704 456.035 628.302 455.765 628.018C455.498 627.731 455.127 627.588 454.653 627.588C454.323 627.588 454.028 627.657 453.766 627.796C453.508 627.936 453.303 628.139 453.153 628.406C453.005 628.673 452.931 628.997 452.931 629.377ZM461.759 633.451C461.129 633.451 460.585 633.312 460.127 633.034C459.673 632.752 459.322 632.36 459.075 631.858C458.831 631.352 458.708 630.764 458.708 630.093C458.708 629.423 458.831 628.832 459.075 628.321C459.322 627.806 459.666 627.406 460.106 627.119C460.549 626.829 461.066 626.684 461.657 626.684C461.998 626.684 462.335 626.741 462.667 626.855C463 626.968 463.302 627.153 463.575 627.409C463.848 627.662 464.065 627.997 464.227 628.414C464.389 628.832 464.47 629.346 464.47 629.957V630.383H459.424V629.514H463.447C463.447 629.144 463.373 628.815 463.225 628.525C463.081 628.235 462.873 628.007 462.603 627.839C462.336 627.671 462.021 627.588 461.657 627.588C461.257 627.588 460.91 627.687 460.617 627.886C460.328 628.082 460.105 628.338 459.948 628.653C459.792 628.968 459.714 629.306 459.714 629.667V630.247C459.714 630.741 459.799 631.16 459.97 631.504C460.143 631.845 460.383 632.105 460.69 632.284C460.997 632.46 461.353 632.548 461.759 632.548C462.024 632.548 462.262 632.511 462.475 632.437C462.691 632.36 462.877 632.247 463.034 632.096C463.19 631.943 463.311 631.752 463.396 631.525L464.367 631.798C464.265 632.127 464.093 632.417 463.852 632.667C463.61 632.914 463.312 633.108 462.957 633.247C462.602 633.383 462.203 633.451 461.759 633.451ZM469.511 633.315V624.588H470.517V627.809H470.602C470.676 627.696 470.778 627.551 470.909 627.375C471.042 627.196 471.233 627.037 471.48 626.897C471.73 626.755 472.068 626.684 472.494 626.684C473.045 626.684 473.531 626.822 473.951 627.098C474.372 627.373 474.7 627.764 474.936 628.269C475.171 628.775 475.289 629.372 475.289 630.059C475.289 630.752 475.171 631.353 474.936 631.862C474.7 632.367 474.373 632.76 473.956 633.038C473.538 633.314 473.056 633.451 472.511 633.451C472.09 633.451 471.754 633.382 471.501 633.242C471.248 633.1 471.054 632.94 470.917 632.761C470.781 632.579 470.676 632.429 470.602 632.309H470.483V633.315H469.511ZM470.5 630.042C470.5 630.537 470.572 630.973 470.717 631.35C470.862 631.725 471.073 632.019 471.352 632.233C471.63 632.443 471.971 632.548 472.375 632.548C472.795 632.548 473.146 632.437 473.427 632.216C473.711 631.991 473.924 631.69 474.066 631.312C474.211 630.931 474.284 630.508 474.284 630.042C474.284 629.582 474.213 629.167 474.071 628.798C473.931 628.426 473.72 628.132 473.436 627.916C473.154 627.697 472.801 627.588 472.375 627.588C471.965 627.588 471.622 627.691 471.343 627.899C471.065 628.103 470.855 628.39 470.713 628.76C470.571 629.126 470.5 629.554 470.5 630.042ZM479.487 633.451C478.896 633.451 478.377 633.311 477.931 633.029C477.488 632.748 477.142 632.355 476.892 631.849C476.644 631.343 476.521 630.752 476.521 630.076C476.521 629.394 476.644 628.799 476.892 628.291C477.142 627.782 477.488 627.387 477.931 627.106C478.377 626.825 478.896 626.684 479.487 626.684C480.078 626.684 480.595 626.825 481.038 627.106C481.484 627.387 481.831 627.782 482.078 628.291C482.328 628.799 482.453 629.394 482.453 630.076C482.453 630.752 482.328 631.343 482.078 631.849C481.831 632.355 481.484 632.748 481.038 633.029C480.595 633.311 480.078 633.451 479.487 633.451ZM479.487 632.548C479.936 632.548 480.305 632.433 480.595 632.203C480.884 631.973 481.099 631.67 481.238 631.295C481.377 630.92 481.447 630.514 481.447 630.076C481.447 629.639 481.377 629.231 481.238 628.853C481.099 628.475 480.884 628.17 480.595 627.937C480.305 627.704 479.936 627.588 479.487 627.588C479.038 627.588 478.669 627.704 478.379 627.937C478.089 628.17 477.875 628.475 477.735 628.853C477.596 629.231 477.527 629.639 477.527 630.076C477.527 630.514 477.596 630.92 477.735 631.295C477.875 631.67 478.089 631.973 478.379 632.203C478.669 632.433 479.038 632.548 479.487 632.548ZM486.459 633.451C485.914 633.451 485.432 633.314 485.015 633.038C484.597 632.76 484.271 632.367 484.035 631.862C483.799 631.353 483.681 630.752 483.681 630.059C483.681 629.372 483.799 628.775 484.035 628.269C484.271 627.764 484.599 627.373 485.019 627.098C485.44 626.822 485.925 626.684 486.476 626.684C486.903 626.684 487.239 626.755 487.486 626.897C487.736 627.037 487.927 627.196 488.057 627.375C488.191 627.551 488.295 627.696 488.369 627.809H488.454V624.588H489.459V633.315H488.488V632.309H488.369C488.295 632.429 488.19 632.579 488.053 632.761C487.917 632.94 487.722 633.1 487.469 633.242C487.217 633.382 486.88 633.451 486.459 633.451ZM486.596 632.548C486.999 632.548 487.34 632.443 487.619 632.233C487.897 632.019 488.109 631.725 488.253 631.35C488.398 630.973 488.471 630.537 488.471 630.042C488.471 629.554 488.4 629.126 488.258 628.76C488.116 628.39 487.905 628.103 487.627 627.899C487.349 627.691 487.005 627.588 486.596 627.588C486.17 627.588 485.815 627.697 485.53 627.916C485.249 628.132 485.038 628.426 484.896 628.798C484.756 629.167 484.687 629.582 484.687 630.042C484.687 630.508 484.758 630.931 484.9 631.312C485.045 631.69 485.258 631.991 485.539 632.216C485.823 632.437 486.175 632.548 486.596 632.548ZM492.089 635.769C491.918 635.769 491.766 635.755 491.633 635.727C491.499 635.701 491.407 635.676 491.356 635.65L491.611 634.764C491.856 634.826 492.072 634.849 492.259 634.832C492.447 634.815 492.613 634.731 492.758 634.581C492.905 634.433 493.04 634.193 493.163 633.86L493.35 633.349L490.93 626.769H492.021L493.827 631.985H493.896L495.702 626.769H496.793L494.015 634.269C493.89 634.608 493.735 634.887 493.55 635.109C493.366 635.333 493.151 635.5 492.907 635.608C492.665 635.716 492.393 635.769 492.089 635.769ZM498.443 633.383C498.233 633.383 498.053 633.308 497.902 633.157C497.752 633.007 497.676 632.826 497.676 632.616C497.676 632.406 497.752 632.225 497.902 632.075C498.053 631.924 498.233 631.849 498.443 631.849C498.654 631.849 498.834 631.924 498.985 632.075C499.135 632.225 499.21 632.406 499.21 632.616C499.21 632.755 499.175 632.883 499.104 633C499.036 633.116 498.943 633.21 498.827 633.281C498.713 633.349 498.585 633.383 498.443 633.383Z" fill="#6B7280"/>
<defs>
<linearGradient id="paint0_linear_3368_10977" x1="331.925" y1="0" x2="331.925" y2="730.25" gradientUnits="userSpaceOnUse">
<stop stop-color="white"/>
<stop offset="1" stop-color="#FAFAFB"/>
</linearGradient>
</defs>
</svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= MODELING EXPERIENCE ================= --}}
        <div class="mp-card" style="margin-top:16px">
            <div class="mp-card-head">
                <div class="mp-card-title"><span class="mp-card-icon"><i class="fa-regular fa-star"></i></span> Modeling Experience</div>
            </div>
            <div class="mp-card-body">
                <div class="mp-empty" id="mpExpNone">Choose <b>Yes</b> for Previous Modeling Experience to add the details.</div>
                <div id="mpExpDetails" class="mp-hidden">
                    <label class="mp-label" for="fExp">Experience details</label>
                    <textarea class="mp-input" id="fExp" name="experience_details" rows="4" maxlength="1000" placeholder="Brands, campaigns, runway shows, years of experience..."></textarea>
                </div>
            </div>
        </div>

        {{-- ================= PREVIOUS PHOTOSHOOTS (photos) ================= --}}
        <div class="mp-card" style="margin-top:16px">
            <div class="mp-card-head">
                <div class="mp-card-title">
                    <span class="mp-card-icon"><i class="fa-solid fa-film"></i></span>
                    <span>Previous Photoshoots<span class="mp-card-sub" id="mpShotCount">Photos from the model's earlier shoots (optional)</span></span>
                </div>
                <div class="mp-card-actions">
                    <button type="button" class="mp-btn mp-btn-outline mp-btn-sm mp-hidden" id="mpShotClear"><i class="fa-regular fa-trash-can"></i> Remove all</button>
                </div>
            </div>
            <div class="mp-card-body">
                <div class="mp-drop" id="mpShotDrop" role="button" tabindex="0">
                    <i class="fa-regular fa-images"></i>
                    <span><b>Click to upload</b> or drag photos here</span>
                    <span>You can pick several photos at once · JPG, PNG or WEBP · up to 5 MB each · max 20 photos</span>
                </div>
                <input type="file" id="mpShotFile" accept="image/jpeg,image/png,image/webp" multiple hidden>
                <div class="mp-shots" id="mpShots"></div>
            </div>
        </div>

        {{-- ================= SAVE BAR ================= --}}
        <div class="mp-savebar">
            <div class="mp-savebar-text" id="mpSaveText">Nothing entered yet.</div>
            <div class="mp-savebar-btns">
                <a href="{{ route('studio.shoot.models') }}" class="mp-btn mp-btn-outline" data-leave>Cancel</a>
                <button type="submit" class="mp-btn mp-btn-primary" id="mpSave"><i class="fa-solid fa-check"></i> Save Model</button>
            </div>
        </div>
    </form>

    <div class="mp-toast" id="mpToast" role="status" aria-live="polite">
        <i class="fa-solid fa-circle-check"></i><span data-role="text"></span>
    </div>
</div>

@endsection

@push('js')
<script>
$(function () {

    const LIST_URL  = @json(route('studio.shoot.models'));
    const STORE_URL = @json(route('studio.shoot.models.store'));   // StudioOrderController@storeShootModel

    const MEASURES = [
        { no: 1,  key: 'height',             name: 'Height', required: true },
        { no: 2,  key: 'waist',              name: 'Waist' },
        { no: 3,  key: 'bust',               name: 'Bust' },
        { no: 4,  key: 'chest',              name: 'Chest' },
        { no: 5,  key: 'hips',               name: 'Hips' },
        { no: 6,  key: 'neck_width',         name: 'Neck Width' },
        { no: 7,  key: 'thigh',              name: 'Thigh' },
        { no: 8,  key: 'leg_opening',        name: 'Leg Opening' },
        { no: 9,  key: 'across_shoulder',    name: 'Across Shoulder' },
        { no: 10, key: 'sleeve_length',      name: 'Sleeve Length' },
        { no: 11, key: 'cuff_opening',       name: 'Cuff Opening' },
        { no: 12, key: 'head_circumference', name: 'Head Circumference' },
    ];
    const SIDES = [
        { key: 'front', name: 'Front Side' }, { key: 'right', name: 'Right side' },
        { key: 'left',  name: 'Left side' },  { key: 'back',  name: 'Back side' },
    ];

    // Form state (measurements are kept in INCHES; height = total inches)
    const SHOT_MAX = 20;
    const S = { photo: null, images: { front: null, right: null, left: null, back: null }, measurements: {}, shots: [], photoFile: null, imageFiles: {} };
    let dirty = false, saving = false;

    /* ---------------- helpers ---------------- */
    function esc(v) { return $('<div>').text(v == null ? '' : String(v)).html(); }
    function pad(n) { return String(n).padStart(2, '0'); }
    function todayISO() { const d = new Date(); return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()); }
    function round(n, d) { const p = Math.pow(10, d); return Math.round(n * p) / p; }
    function ageFrom(dob) {
        if (!dob) return null;
        const p = dob.split('-').map(Number), now = new Date();
        let age = now.getFullYear() - p[0];
        if (now.getMonth() + 1 < p[1] || (now.getMonth() + 1 === p[1] && now.getDate() < p[2])) age--;
        return age;
    }
    function initials(name) { return name.split(/\s+/).filter(Boolean).map(function (w) { return w.charAt(0); }).slice(0, 2).join('').toUpperCase(); }
    const AVATAR_COLORS = ['#16a394', '#7b5fc7', '#d6713a', '#1d5fd0', '#c2416b', '#3d8b40'];
    function avatarColor(name) { let h = 0; for (let i = 0; i < name.length; i++) h = (h * 31 + name.charCodeAt(i)) >>> 0; return AVATAR_COLORS[h % AVATAR_COLORS.length]; }

    let toastTimer = null;
    function toast(msg, isError) {
        const $t = $('#mpToast');
        $t.toggleClass('is-error', !!isError).find('i').attr('class', isError ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check');
        $t.find('[data-role="text"]').text(msg);
        $t.addClass('is-visible');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { $t.removeClass('is-visible'); }, 3000);
    }
    function readImage(file, done) {
        if (!file) return;
        if (!/^image\/(jpeg|png|webp)$/.test(file.type)) { toast('Please choose a JPG, PNG or WEBP image.', true); return; }
        if (file.size > 5 * 1024 * 1024) { toast('The image must be 5 MB or smaller.', true); return; }
        const r = new FileReader();
        r.onload = function (e) { done(e.target.result, file); };
        r.readAsDataURL(file);
    }
    function markDirty() { dirty = true; updateProgress(); }

    /* =====================================================
       CONFIRMATION POPUP (delete / leave page)
       askConfirm({ title, html, ok, warn, icon, onConfirm })
       ===================================================== */
    const $cm = $('<div class="mp-cmodal" id="mpCModal" aria-hidden="true">' +
        '<div class="mp-cmodal-backdrop" data-confirm="no"></div>' +
        '<div class="mp-cmodal-box" role="alertdialog" aria-modal="true" aria-labelledby="mpCTitle" aria-describedby="mpCText">' +
            '<button type="button" class="mp-cmodal-x" data-confirm="no" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>' +
            '<div class="mp-cmodal-icon"><i></i></div>' +
            '<h5 class="mp-cmodal-title" id="mpCTitle"></h5>' +
            '<p class="mp-cmodal-text" id="mpCText"></p>' +
            '<div class="mp-cmodal-btns">' +
                '<button type="button" class="mp-btn mp-btn-outline" data-confirm="no">Cancel</button>' +
                '<button type="button" class="mp-btn mp-btn-danger" data-confirm="yes"></button>' +
            '</div>' +
        '</div></div>').appendTo('#mpPage');
    let confirmAction = null, confirmFocus = null;

    function closeConfirm() {
        if (!$cm.hasClass('is-open')) return;
        $cm.removeClass('is-open').attr('aria-hidden', 'true');
        $('body').removeClass('mp-cmodal-open');
        $('#mpShots .mp-shot').removeClass('is-confirming');
        confirmAction = null;
        if (confirmFocus && confirmFocus.focus) confirmFocus.focus();
    }
    function askConfirm(o) {
        confirmAction = o.onConfirm;
        confirmFocus = document.activeElement;
        $cm.toggleClass('is-warn', !!o.warn);
        $cm.find('.mp-cmodal-icon i').attr('class', o.icon || 'fa-regular fa-trash-can');
        $cm.find('.mp-cmodal-title').text(o.title);
        $cm.find('.mp-cmodal-text').html(o.html || '');
        $cm.find('[data-confirm="yes"]').text(o.ok || 'Remove').attr('class', 'mp-btn ' + (o.warn ? 'mp-btn-primary' : 'mp-btn-danger'));
        $cm.addClass('is-open').attr('aria-hidden', 'false');
        $('body').addClass('mp-cmodal-open');
        setTimeout(function () { $cm.find('[data-confirm="yes"]').trigger('focus'); }, 30);
    }
    $cm.on('click', '[data-confirm="no"]', closeConfirm);
    $cm.on('click', '[data-confirm="yes"]', function () { const a = confirmAction; closeConfirm(); if (a) a(); });
    $(document).on('keydown', function (e) {
        if (!$cm.hasClass('is-open')) return;
        if (e.key === 'Escape') { e.preventDefault(); closeConfirm(); }
        if (e.key === 'Tab') {                       // keep the keyboard inside the popup
            const $f = $cm.find('button'), first = $f[0], last = $f[$f.length - 1];
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        }
    });

    /* ---------------- leave with unsaved changes ---------------- */
    $(document).on('click', '[data-leave]', function (e) {
        if (!dirty) return;
        e.preventDefault();
        const href = this.href;
        askConfirm({
            title: 'Leave without saving?', html: 'The details you entered for this model will be <b>lost</b>.',
            ok: 'Leave page', warn: true, icon: 'fa-solid fa-triangle-exclamation',
            onConfirm: function () { dirty = false; window.location.href = href; },
        });
    });
    window.addEventListener('beforeunload', function (e) { if (dirty && !saving) { e.preventDefault(); e.returnValue = ''; } });

    /* ---------------- personal info ---------------- */
    $('#fDob').attr('max', todayISO());
    $('#mpForm').on('input change', 'input[name], select[name], textarea[name]', function () {
        $(this).removeClass('is-invalid');
        $('[data-error="' + this.name + '"]').removeClass('is-visible');
        markDirty();
    });
    // Age is filled from the date of birth (can still be changed by hand)
    $('#fDob').on('change', function () {
        const a = ageFrom(this.value);
        if (a !== null && a >= 0) { $('#fAge').val(a).removeClass('is-invalid'); $('[data-error="age"]').removeClass('is-visible'); }
    });
    $('#fName').on('input', renderPhoto);

    // radio "cards" (gender, experience)
    $('#mpForm').on('change', '.mp-choice input', function () {
        $(this).closest('.mp-choice').find('label').removeClass('is-checked');
        $(this).closest('label').addClass('is-checked');
        if (this.name === 'experience') { $('#mpExpDetails').toggleClass('mp-hidden', this.value !== '1'); $('#mpExpNone').toggleClass('mp-hidden', this.value === '1'); }
    });

    /* ---------------- profile photo ---------------- */
    // Header: photo / initials, live name and chips
    function renderPhoto() {
        const name = $.trim($('#fName').val());
        const $a = $('#mpPhoto').removeClass('is-empty');
        if (S.photo) $a.css('background', '#f1f2f4').html('<img src="' + esc(S.photo) + '" alt="Profile photo">');
        else if (name) $a.css('background', avatarColor(name)).text(initials(name));
        else $a.addClass('is-empty').css('background', '').html('<i class="fa-regular fa-user"></i>');
        $('#mpPhotoRemove').toggleClass('mp-hidden', !S.photo);
        $('#mpHeroName').text(name || 'New Model');
        const gender = $('[name="gender"]:checked').val(), size = $('#fSize').val();
        $('#mpHeroChips').html(
            '<span class="mp-chip mp-chip-orange">New model</span>' +
            (gender ? '<span class="mp-chip mp-chip-outline">' + esc(gender) + ' model</span>' : '') +
            (size ? '<span class="mp-chip mp-chip-outline">US size ' + esc(size) + '</span>' : '')
        );
    }
    $('#mpForm').on('change', '[name="gender"], #fSize', renderPhoto);
    $('#mpPhotoFile').on('change', function () {
        readImage(this.files[0], function (src, file) { S.photo = src; S.photoFile = file; renderPhoto(); markDirty(); });
        this.value = '';
    });
    $('#mpPhotoRemove').on('click', function () {
        askConfirm({ title: 'Remove profile photo?', html: 'The photo you picked will be removed from this form.',
            onConfirm: function () { S.photo = null; S.photoFile = null; renderPhoto(); markDirty(); } });
    });

    /* ---------------- model images ---------------- */
    let activeSide = 'front', uploadSide = null;
    function renderImages() {
        $('#mpSideList').html(SIDES.map(function (s) {
            const has = !!S.images[s.key];
            return '<div class="mp-side' + (s.key === activeSide ? ' is-active' : '') + '" data-side="' + s.key + '" role="button" tabindex="0">' +
                '<span class="mp-side-name">' + s.name + (has ? '<span class="mp-side-dot" title="Image uploaded"></span>' : '') + '</span>' +
                '<span class="mp-side-btns">' +
                    '<button type="button" class="mp-icon-btn is-danger" data-action="img-delete" title="Delete ' + s.name + ' image"' + (has ? '' : ' disabled') + '><i class="fa-regular fa-trash-can"></i></button>' +
                    '<button type="button" class="mp-icon-btn is-blue" data-action="img-upload" title="' + (has ? 'Change' : 'Upload') + ' ' + s.name + ' image"><i class="fa-regular fa-pen-to-square"></i></button>' +
                '</span></div>';
        }).join(''));
        const side = SIDES.find(function (s) { return s.key === activeSide; });
        $('#mpImgTitle').text(side.name);
        $('#mpImgFrame').html(S.images[activeSide]
            ? '<img src="' + esc(S.images[activeSide]) + '" alt="' + esc(side.name) + '">'
            : '<div class="mp-img-drop" data-action="img-upload-active"><i class="fa-regular fa-image"></i>No ' + side.name.toLowerCase() + ' image yet.<br><b>Click to upload</b> or drop an image here.</div>');
    }
    function startUpload(k) { uploadSide = k; $('#mpImgFile').trigger('click'); }
    function setImage(k, src, file) { S.images[k] = src; S.imageFiles[k] = file; activeSide = k; renderImages(); markDirty(); }

    $('#mpSideList').on('click', '.mp-side', function (e) { if ($(e.target).closest('[data-action]').length) return; activeSide = this.dataset.side; renderImages(); });
    $('#mpSideList').on('keydown', '.mp-side', function (e) { if (e.key === 'Enter') { activeSide = this.dataset.side; renderImages(); } });
    $('#mpSideList').on('click', '[data-action="img-upload"]', function () { startUpload($(this).closest('.mp-side').data('side')); });
    $('#mpImgFrame').on('click', '[data-action="img-upload-active"]', function () { startUpload(activeSide); });
    $('#mpImgFile').on('change', function () { const k = uploadSide || activeSide; readImage(this.files[0], function (src, file) { setImage(k, src, file); }); this.value = ''; });
    $('#mpImgFrame').on('dragover', function (e) { e.preventDefault(); $(this).addClass('is-drag'); })
        .on('dragleave drop', function () { $(this).removeClass('is-drag'); })
        .on('drop', function (e) { e.preventDefault(); readImage(e.originalEvent.dataTransfer.files[0], function (src, file) { setImage(activeSide, src, file); }); });
    $('#mpSideList').on('click', '[data-action="img-delete"]', function () {
        const k = $(this).closest('.mp-side').data('side'), name = SIDES.find(function (s) { return s.key === k; }).name;
        askConfirm({ title: 'Remove ' + name.toLowerCase() + ' image?', html: 'The <b>' + esc(name) + '</b> image will be removed from this form.',
            onConfirm: function () { S.images[k] = null; S.imageFiles[k] = null; renderImages(); markDirty(); } });
    });

    /* ---------------- measurements ---------------- */
    let unit = 'in';
    function shown(key) {
        const v = S.measurements[key];
        if (v == null) return '';
        return unit === 'cm' ? (key === 'height' ? Math.round(v * 2.54) : round(v * 2.54, 1)) : v;
    }
    function renderMeasures() {
        $('#mpMeasureBody').html(MEASURES.map(function (m) {
            let field;
            if (m.key === 'height' && unit === 'in') {
                const v = S.measurements.height;
                const ft = v != null ? Math.floor(v / 12) : '', inch = v != null ? round(v - Math.floor(v / 12) * 12, 1) : '';
                field = '<span class="mp-height-inputs"><input type="number" class="mp-input" data-ft min="3" max="7" value="' + ft + '" placeholder="ft" aria-label="Height feet"><input type="number" class="mp-input" data-in min="0" max="11.9" step="0.5" value="' + inch + '" placeholder="in" aria-label="Height inches"></span>';
            } else {
                field = '<input type="number" class="mp-input" data-val min="0" step="' + (unit === 'cm' ? '0.5' : '0.25') + '" value="' + shown(m.key) + '" placeholder="0" aria-label="' + esc(m.name) + '">';
            }
            return '<tr data-no="' + m.no + '" data-key="' + m.key + '">' +
                '<td><span class="mp-mno">' + pad(m.no) + '</span></td>' +
                '<td class="mp-mname">' + esc(m.name) + (m.required ? ' <span class="mp-req">*</span>' : '') + '</td>' +
                '<td>' + field + '</td>' +
                '<td class="mp-munit">' + (unit === 'cm' ? 'cm' : (m.key === 'height' ? 'ft / in' : 'in')) + '</td></tr>';
        }).join(''));
        $('#mpUnitNote').text(unit === 'cm' ? 'Enter values in centimetres (saved as inches)' : 'Enter values in inches');
        updateMeasureCount();
    }
    // read one row -> inches (null if empty). Returns { ok, value, err }
    function readRow($row) {
        const key = $row.data('key'), m = MEASURES.find(function (x) { return x.key === key; });
        if (key === 'height' && unit === 'in') {
            const ft = $row.find('[data-ft]').val(), inch = $row.find('[data-in]').val();
            if (ft === '' && inch === '') return { ok: true, value: null, m: m };
            const f = Number(ft || 0), i = Number(inch || 0);
            if (f < 3 || f > 7 || i < 0 || i >= 12) return { ok: false, m: m, err: 'Height must be between 3 ft and 7 ft 11 in.' };
            return { ok: true, value: round(f * 12 + i, 1), m: m };
        }
        const raw = $row.find('[data-val]').val();
        if (raw === '') return { ok: true, value: null, m: m };
        const n = Number(raw), inches = unit === 'cm' ? n / 2.54 : n;
        if (!(n > 0) || inches > (key === 'height' ? 96 : 80)) return { ok: false, m: m, err: m.name + ' must be a positive number.' };
        return { ok: true, value: round(inches, key === 'height' ? 1 : 2), m: m };
    }
    function updateMeasureCount() {
        const n = MEASURES.filter(function (m) { return S.measurements[m.key] != null; }).length;
        $('#mpMeasureCount').text(n + ' of 12');
    }
    function highlight(no) {
        $('#mpMeasureBody tr').removeClass('is-active'); $('#mpDiagram [data-m]').removeClass('is-active');
        if (!no) return;
        $('#mpMeasureBody tr[data-no="' + no + '"]').addClass('is-active'); $('#mpDiagram [data-m="' + no + '"]').addClass('is-active');
    }
    $('#mpMeasureBody').on('input', 'input', function () {
        const $row = $(this).closest('tr'), r = readRow($row);
        $row.find('input').toggleClass('is-invalid', !r.ok);
        if (r.ok) S.measurements[r.m.key] = r.value;
        $('[data-error="measurements"]').removeClass('is-visible');
        updateMeasureCount(); markDirty();
    });
    $('#mpMeasureBody').on('focus', 'input', function () { highlight(Number($(this).closest('tr').data('no'))); });
    $('#mpMeasureBody').on('click', 'tr', function (e) { if (!$(e.target).is('input')) { highlight(Number(this.dataset.no)); $(this).find('input').first().trigger('focus'); } });
    $('#mpMeasureBody').on('keydown', 'input', function (e) {           // Enter -> next measurement
        if (e.key !== 'Enter') return;
        e.preventDefault();
        const $inputs = $('#mpMeasureBody input'), i = $inputs.index(this);
        if (i < $inputs.length - 1) $inputs.eq(i + 1).trigger('focus').trigger('select');
    });
    $('#mpDiagram').on('click keydown', '.mp-marker', function (e) {
        if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;
        const no = Number(this.dataset.m);
        highlight(no);
        $('#mpMeasureBody tr[data-no="' + no + '"] input').first().trigger('focus');
    });
    $('.mp-seg').on('click', 'button', function () {
        if (this.dataset.unit === unit) return;
        const bad = $('#mpMeasureBody tr').map(function () { return readRow($(this)); }).get().find(function (r) { return !r.ok; });
        if (bad) { toast('Fix "' + bad.m.name + '" before switching units.', true); return; }
        unit = this.dataset.unit;
        $(this).addClass('is-active').siblings().removeClass('is-active');
        renderMeasures();
    });

    /* ---------------- previous photoshoot photos (one or more) ---------------- */
    function fileSize(b) { return b >= 1048576 ? (b / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(b / 1024)) + ' KB'; }

    function renderShots() {
        const n = S.shots.length;
        $('#mpShotCount').text(n ? n + (n === 1 ? ' photo' : ' photos') + ' added · max ' + SHOT_MAX : 'Photos from the model\'s earlier shoots (optional)');
        $('#mpShotClear').toggleClass('mp-hidden', n < 2);
        $('#mpShotDrop').toggleClass('mp-hidden', n >= SHOT_MAX);
        $('#mpShots').html(S.shots.map(function (p) {
            return '<div class="mp-shot" data-id="' + p.id + '">' +
                '<div class="mp-shot-img"><img src="' + esc(p.src) + '" alt="' + esc(p.name) + '"></div>' +
                '<div class="mp-shot-meta"><b title="' + esc(p.name) + '">' + esc(p.name) + '</b>' + esc(fileSize(p.size)) + '</div>' +
                '<button type="button" class="mp-icon-btn is-danger" data-action="shot-remove" title="Remove photo" aria-label="Remove ' + esc(p.name) + '"><i class="fa-regular fa-trash-can"></i></button>' +
            '</div>';
        }).join(''));
    }

    function addShots(fileList) {
        const files = Array.prototype.slice.call(fileList || []);
        if (!files.length) return;
        const room = SHOT_MAX - S.shots.length;
        let skipped = 0, tooMany = 0;
        files.forEach(function (file, i) {
            if (i >= room) { tooMany++; return; }
            if (!/^image\/(jpeg|png|webp)$/.test(file.type) || file.size > 5 * 1024 * 1024) { skipped++; return; }
            const item = { id: Date.now() + '_' + i + '_' + Math.random().toString(36).slice(2, 6), name: file.name, size: file.size, file: file, src: '' };
            S.shots.push(item);
            const r = new FileReader();
            r.onload = function (e) { item.src = e.target.result; renderShots(); };
            r.readAsDataURL(file);
        });
        renderShots(); markDirty();
        if (tooMany) toast('Only ' + SHOT_MAX + ' photos are allowed. ' + tooMany + ' not added.', true);
        else if (skipped) toast(skipped + (skipped === 1 ? ' file was' : ' files were') + ' skipped (must be JPG, PNG or WEBP up to 5 MB).', true);
    }

    $('#mpShotDrop').on('click', function () { $('#mpShotFile').trigger('click'); })
        .on('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); $('#mpShotFile').trigger('click'); } })
        .on('dragover', function (e) { e.preventDefault(); $(this).addClass('is-drag'); })
        .on('dragleave drop', function () { $(this).removeClass('is-drag'); })
        .on('drop', function (e) { e.preventDefault(); addShots(e.originalEvent.dataTransfer.files); });
    $('#mpShotFile').on('change', function () { addShots(this.files); this.value = ''; });

    $('#mpShots').on('click', '[data-action="shot-remove"]', function () {
        const $shot = $(this).closest('.mp-shot'), id = String($shot.data('id'));
        const p = S.shots.find(function (x) { return x.id === id; });
        askConfirm({ title: 'Remove this photo?', html: '<b>' + esc(p.name) + '</b> will be removed from this form.',
            onConfirm: function () { S.shots = S.shots.filter(function (x) { return x !== p; }); renderShots(); markDirty(); } });
        $shot.addClass('is-confirming');            // red outline on the photo being removed
    });
    $('#mpShotClear').on('click', function () {
        askConfirm({ title: 'Remove all ' + S.shots.length + ' photos?', html: 'Every previous photoshoot photo you added will be removed from this form.',
            ok: 'Remove all', onConfirm: function () { S.shots = []; renderShots(); markDirty(); } });
    });

    /* ---------------- progress ---------------- */
    function updateProgress() {
        const checks = [
            $.trim($('#fName').val()), $.trim($('#fPhone').val()), $('#fDob').val(), $('[name="gender"]:checked').length,
            $.trim($('#fEmail').val()), $.trim($('#fAddress').val()), $('#fSize').val(),
            S.measurements.height != null, MEASURES.filter(function (m) { return S.measurements[m.key] != null; }).length >= 6,
            SIDES.some(function (s) { return S.images[s.key]; }), S.shots.length,
        ];
        const pct = Math.round(checks.filter(Boolean).length / checks.length * 100);
        $('#mpProgress').css('width', pct + '%');
        $('#mpProgressText').text(pct + '% complete');
        const missing = [];
        if (!$.trim($('#fName').val())) missing.push('name');
        if (!$.trim($('#fPhone').val())) missing.push('phone');
        if (!$('#fDob').val()) missing.push('date of birth');
        if (!$('[name="gender"]:checked').length) missing.push('gender');
        if (S.measurements.height == null) missing.push('height');
        $('#mpSaveText').html(missing.length
            ? 'Still required: <b>' + esc(missing.join(', ')) + '</b>'
            : '<i class="fa-solid fa-circle-check" style="color:#16a34a"></i> All required details are filled in. Ready to save.');
    }

    /* ---------------- validate + save ---------------- */
    function showError(name, msg) {
        $('[data-error="' + name + '"]').text(msg).addClass('is-visible');
        $('[name="' + name + '"]').not('[type="radio"]').addClass('is-invalid');
    }
    function validate() {
        $('.mp-error').removeClass('is-visible'); $('#mpForm .is-invalid').removeClass('is-invalid');
        const name = $.trim($('#fName').val()).replace(/\s+/g, ' '), phone = $.trim($('#fPhone').val()),
              email = $.trim($('#fEmail').val()), dob = $('#fDob').val();
        let first = null;
        function fail(n, msg, el) { showError(n, msg); if (!first) first = el; }

        if (name.length < 2) fail('name', 'Please enter the model\'s full name.', $('#fName'));
        if (!phone) fail('phone_number', 'Please enter a phone number.', $('#fPhone'));
        else if (!/^[+()\d\s-]{7,}$/.test(phone)) fail('phone_number', 'Please enter a valid phone number.', $('#fPhone'));
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) fail('email', 'Please enter a valid email address.', $('#fEmail'));
        if (!dob) fail('date_of_birth', 'Please pick the date of birth.', $('#fDob'));
        else if (dob > todayISO()) fail('date_of_birth', 'Date of birth cannot be in the future.', $('#fDob'));
        else if (ageFrom(dob) < 16) fail('date_of_birth', 'The model must be at least 16 years old.', $('#fDob'));
        const age = $('#fAge').val();
        if (age !== '' && !(Number(age) >= 16 && Number(age) <= 99)) fail('age', 'Age must be between 16 and 99.', $('#fAge'));
        if (!$('[name="gender"]:checked').length) fail('gender', 'Please choose a gender.', $('[data-choice="gender"]'));

        const rows = $('#mpMeasureBody tr').map(function () { return readRow($(this)); }).get();
        const bad = rows.find(function (r) { return !r.ok; });
        if (bad) {
            $('[data-error="measurements"]').text(bad.err).addClass('is-visible');
            $('#mpMeasureBody tr[data-key="' + bad.m.key + '"] input').addClass('is-invalid');
            if (!first) first = $('#mpMeasureBody tr[data-key="' + bad.m.key + '"]');
        } else if (S.measurements.height == null) {
            $('[data-error="measurements"]').text('Height is required.').addClass('is-visible');
            $('#mpMeasureBody tr[data-key="height"] input').addClass('is-invalid');
            if (!first) first = $('#mpMeasureBody tr[data-key="height"]');
        }
        return first;
    }

    $('#mpForm').on('submit', function (e) {
        e.preventDefault();
        const $first = validate();
        if ($first) {
            $first[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            $first.removeClass('mp-shake'); void $first[0].offsetWidth; $first.addClass('mp-shake');
            setTimeout(function () { ($first.is('input, select') ? $first : $first.find('input').first()).trigger('focus'); }, 350);
            toast('Please fix the highlighted fields.', true);
            return;
        }

        // Multipart form for StudioOrderController@storeShootModel (measurements in inches)
        const fd = new FormData();
        fd.append('name', $.trim($('#fName').val()).replace(/\s+/g, ' '));
        fd.append('address', $.trim($('#fAddress').val()));
        fd.append('phone_number', $.trim($('#fPhone').val()));
        fd.append('email', $.trim($('#fEmail').val()));
        fd.append('country', $.trim($('#fCountry').val()));
        fd.append('nationality', $.trim($('#fNationality').val()));
        fd.append('date_of_birth', $('#fDob').val());
        fd.append('age', $('#fAge').val());
        fd.append('gender', $('[name="gender"]:checked').val() || '');
        fd.append('us_size', $('#fSize').val());
        fd.append('model_type', $('#fType').val());
        fd.append('experience', $('[name="experience"]:checked').val() === '1' ? '1' : '0');
        fd.append('experience_details', $('[name="experience"]:checked').val() === '1' ? $.trim($('#fExp').val()) : '');
        MEASURES.forEach(function (m) {
            const v = S.measurements[m.key];
            fd.append('measurements[' + m.key + ']', v === null || v === undefined ? '' : v);
        });
        if (S.photoFile) fd.append('profile_photo', S.photoFile);
        SIDES.forEach(function (sd) { if (S.imageFiles[sd.key]) fd.append('images[' + sd.key + ']', S.imageFiles[sd.key]); });
        S.shots.forEach(function (p) { fd.append('photoshoot_photos[]', p.file); });

        saving = true;
        const $btns = $('#mpSave, #mpHero button[type="submit"]').prop('disabled', true);
        const labels = $btns.map(function () { return $(this).html(); }).get();
        $btns.html('<i class="fa-solid fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: STORE_URL, method: 'POST', data: fd, processData: false, contentType: false, dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json' },
        }).done(function (res) {
            dirty = false;
            toast((res && res.message ? res.message : 'Model saved.') + ' Opening the profile...');
            $btns.html('<i class="fa-solid fa-check"></i> Saved');
            setTimeout(function () { window.location.href = res.redirect || LIST_URL; }, 900);
        }).fail(function (xhr) {
            saving = false;
            $btns.each(function (i) { $(this).prop('disabled', false).html(labels[i]); });
            showServerErrors(xhr);
        });
    });

    // Laravel 422 errors -> show them under the right fields
    function showServerErrors(xhr) {
        const json = xhr && xhr.responseJSON;
        if (xhr && xhr.status === 422 && json && json.errors) {
            let $first = null;
            Object.keys(json.errors).forEach(function (field) {
                const msg = json.errors[field][0];
                let $target;
                if (field.indexOf('measurements.') === 0) {
                    const key = field.split('.')[1];
                    $('[data-error="measurements"]').text(msg).addClass('is-visible');
                    $target = $('#mpMeasureBody tr[data-key="' + key + '"]');
                    $target.find('input').addClass('is-invalid');
                } else if ($('[data-error="' + field + '"]').length) {
                    showError(field, msg);
                    $target = $('[name="' + field + '"]').first().closest('.mp-info');
                } else {
                    toast(msg, true);                       // images / photos
                }
                if (!$first && $target && $target.length) $first = $target;
            });
            if ($first) $first[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            toast('Please fix the highlighted fields.', true);
            return;
        }
        let msg = 'Could not save the model. Please try again.';
        if (json && json.message && xhr.status !== 500) msg = json.message;
        if (xhr && xhr.status === 419) msg = 'Your session has expired. Please refresh the page.';
        if (xhr && xhr.status === 413) msg = 'The images are too big to upload together. Please use smaller photos.';
        toast(msg, true);
    }

    /* ---------------- init ---------------- */
    renderPhoto(); renderImages(); renderMeasures(); renderShots(); updateProgress();
});
</script>
@endpush