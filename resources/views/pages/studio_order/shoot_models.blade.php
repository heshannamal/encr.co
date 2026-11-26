@extends('layouts.app', ['activePage' => 'shoot_models', 'titlePage' => __('Shoot Models')])

@section('content')

<style>
    /* ==========================================================
       SHOOT MODELS PAGE  (all classes start with "fm-")
       ========================================================== */
    .fm-page {
        --fm-primary: #16a394;
        --fm-primary-dark: #12897c;
        --fm-green: #1fb67a;
        --fm-link: #1d5fd0;
        --fm-border: #e6e8eb;
        --fm-head: #7d7d7d;
        --fm-text: #1f2328;
        --fm-muted: #6b7280;
        --fm-bottom-gap: 110px;   /* space for the fixed world-clock bar */

        font-family: 'Open Sans', sans-serif;
        color: var(--fm-text);
        padding-top: 0 !important;
        padding-bottom: var(--fm-bottom-gap) !important;
    }

    .fm-page *, .fm-page *::before, .fm-page *::after { box-sizing: border-box; }

    .fm-card { background: #fff; border: 1px solid var(--fm-border); border-radius: 6px; }
    .fm-hidden { display: none !important; }
    .fm-dash { color: #b4b9c0; }
    .fm-table td.fm-c-toggle { display: none; }   /* card open/close arrow: phones only */

    /* ---------- Toolbar ---------- */
    .fm-toolbar {
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;
        gap: 12px; padding: 12px 14px; margin-bottom: 14px;
    }
    .fm-search { position: relative; flex: 1 1 240px; max-width: 320px; }
    .fm-search i {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        color: #9aa0a6; font-size: 12px; pointer-events: none;
    }
    .fm-search .fm-input { padding-left: 30px; }

    .fm-input {
        width: 100%; height: 34px; padding: 0 10px; font-size: 12.5px; color: var(--fm-text);
        background: #fff; border: 1px solid #d6d9de; border-radius: 4px; outline: none;
        font-family: inherit;
        transition: border-color .15s, box-shadow .15s;
    }
    .fm-input::placeholder { color: #9aa0a6; }
    .fm-input:focus { border-color: var(--fm-primary); box-shadow: 0 0 0 3px rgba(22, 163, 148, .15); }
    .fm-input.is-invalid { border-color: #d64550; }
    textarea.fm-input { height: auto; min-height: 64px; padding: 8px 10px; resize: vertical; line-height: 1.45; }

    .fm-btn {
        height: 34px; display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 0 14px; font-size: 12.5px; font-weight: 600; border-radius: 4px;
        border: 1px solid transparent; cursor: pointer; white-space: nowrap;
        transition: background .15s, border-color .15s, color .15s;
    }
    .fm-btn-primary { background: var(--fm-primary); color: #fff; }
    .fm-btn-primary:hover { background: var(--fm-primary-dark); color: #fff; }
    .fm-btn-outline { background: #fff; border-color: #cfd3d8; color: #374151; }
    .fm-btn-outline:hover { background: #f5f6f7; }
    .fm-btn-danger { background: #d64550; color: #fff; }
    .fm-btn-danger:hover { background: #bf3540; color: #fff; }
    .fm-btn:disabled { opacity: .6; cursor: not-allowed; }

    /* ---------- Table ---------- */
    .fm-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .fm-table { width: 100%; min-width: 1080px; border-collapse: collapse; margin: 0; }

    .fm-table thead th {
        background: var(--fm-head); color: #fff; font-size: 10.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .04em; padding: 12px 10px; white-space: nowrap; border: 0;
    }
    .fm-table thead th:first-child { border-top-left-radius: 6px; padding-left: 14px; }
    .fm-table thead th:last-child  { border-top-right-radius: 6px; }
    .fm-table th.fm-sortable { cursor: pointer; user-select: none; }
    .fm-table th.fm-sortable i { margin-left: 4px; font-size: 10px; opacity: .75; }
    .fm-table th.fm-sortable.is-active i { opacity: 1; }

    .fm-table tbody td {
        padding: 12px 10px; font-size: 12.5px; vertical-align: middle;
        border-top: 1px solid var(--fm-border); white-space: nowrap;
    }
    .fm-table tbody td:first-child { padding-left: 14px; }
    .fm-table tbody tr:hover { background: #fafbfc; }

    .fm-name { font-weight: 700; }
    .fm-id { color: #374151; }

    .fm-avatar {
        width: 36px; height: 36px; border-radius: 50%; overflow: hidden; flex-shrink: 0;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700; color: #fff; letter-spacing: .02em;
    }
    .fm-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .fm-avatar-lg { width: 72px; height: 72px; font-size: 22px; }

    .fm-gender { display: inline-flex; align-items: center; gap: 5px; }
    .fm-gender i { font-size: 11px; }
    .fm-gender.is-male i   { color: #1d5fd0; }
    .fm-gender.is-female i { color: #c2416b; }

    .fm-row-actions { display: inline-flex; align-items: center; gap: 10px; }
    .fm-profile-btn {
        height: 28px; padding: 0 12px; font-size: 11.5px; font-weight: 700; color: #fff;
        background: var(--fm-green); border: 0; border-radius: 4px; cursor: pointer;
        transition: background .15s;
        display: inline-flex; align-items: center; justify-content: center; white-space: nowrap;
        text-decoration: none !important;
    }
    .fm-profile-btn, .fm-profile-btn:hover, .fm-profile-btn:focus { color: #fff !important; }
    .fm-profile-btn:hover { background: #18a06a; }
    a.fm-btn { text-decoration: none !important; }
    a.fm-btn-primary, a.fm-btn-primary:hover { color: #fff !important; }
    .fm-icon-btn {
        width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid #f3c9cd; border-radius: 6px; background: #fff; color: #d64550; cursor: pointer;
        transition: background .15s, border-color .15s;
    }
    .fm-icon-btn:hover { background: #fdecee; border-color: #eba4ab; }

    .fm-empty { padding: 48px 16px; text-align: center; color: var(--fm-muted); font-size: 13px; }
    .fm-empty i { display: block; font-size: 28px; margin-bottom: 10px; color: #c3c7cc; }

    .fm-footer {
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;
        gap: 12px; padding: 12px 16px; border-top: 1px solid var(--fm-border);
    }
    .fm-info { font-size: 12px; color: var(--fm-muted); }
    .fm-pagination { display: flex; flex-wrap: wrap; gap: 4px; }
    .fm-page-btn {
        min-width: 32px; height: 30px; padding: 0 9px; font-size: 12px; color: #4b5563;
        background: #fff; border: 1px solid #dcdfe3; border-radius: 4px; cursor: pointer;
    }
    .fm-page-btn:hover:not(:disabled):not(.active) { background: #f5f6f7; }
    .fm-page-btn.active { background: var(--fm-primary); border-color: var(--fm-primary); color: #fff; font-weight: 700; }
    .fm-page-btn:disabled { color: #c0c4ca; cursor: not-allowed; }
    .fm-ellipsis { min-width: 24px; height: 30px; display: inline-flex; align-items: center; justify-content: center; color: #9aa0a6; }

    /* ---------- Inline delete confirmation (no popup) ---------- */
    .fm-table tbody tr.fm-confirm-row td { padding: 0 10px 12px; border-top: 0; white-space: normal; }
    .fm-confirm {
        display: flex; align-items: center; flex-wrap: wrap; gap: 12px; padding: 12px 14px;
        background: #fff5f5; border: 1px solid #f3c9cd; border-radius: 8px; animation: fmConfirmIn .15s ease-out;
    }
    @keyframes fmConfirmIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: none; } }
    .fm-confirm .fm-del-person { flex: 1; min-width: 220px; margin: 0; border: 0; padding: 0; }
    .fm-confirm .fm-warn { flex-basis: 100%; }
    .fm-confirm-btns { display: flex; gap: 8px; margin-left: auto; }
    tr.is-confirming td { background: #fff9f9; }
    .fm-del-person { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border: 1px solid var(--fm-border); border-radius: 8px; margin-bottom: 12px; }
    .fm-del-person b { display: block; font-size: 13.5px; }
    .fm-del-person span { font-size: 12px; color: var(--fm-muted); }
    .fm-warn { display: flex; gap: 8px; padding: 10px 12px; font-size: 12px; line-height: 1.45; color: #8a4b00; background: #fff6e0; border-radius: 8px; }
    .fm-warn i { margin-top: 2px; }

    /* ---------- Toast ---------- */
    .fm-toast {
        position: fixed; right: 20px; bottom: 80px; z-index: 10070; display: flex; align-items: center; gap: 10px;
        max-width: calc(100vw - 40px); padding: 12px 16px; font-size: 13px; color: #fff; background: #1f2937;
        border-radius: 8px; box-shadow: 0 10px 30px rgba(15, 23, 42, .25);
        opacity: 0; transform: translateY(10px); pointer-events: none; transition: opacity .2s, transform .2s;
    }
    .fm-toast.is-visible { opacity: 1; transform: none; }
    .fm-toast i { color: #34d399; }
    .fm-toast.is-error i { color: #f87171; }

    /* ==========================================================
       PHONES 
       ========================================================== */
    @media (max-width: 767.98px) {
        .fm-page {
            --fm-bottom-gap: 130px;
            --fm-m-shadow: 0 1px 2px rgba(16, 24, 40, .05), 0 2px 8px rgba(16, 24, 40, .06);
        }

        /* ---------- Search + Add Models card ---------- */
        .fm-toolbar {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            padding: 16px;
            margin-bottom: 12px;
            border: 1px solid #eef0f2;
            border-radius: 16px;
            box-shadow: var(--fm-m-shadow);
        }
        .fm-search { flex: 0 0 auto; max-width: none; }
        .fm-search i { left: 14px; font-size: 13px; }
        .fm-toolbar .fm-input {
            height: 44px;
            padding: 0 12px;
            font-size: 14px;
            border-color: #e2e5e9;
            border-radius: 10px;
        }
        .fm-toolbar .fm-search .fm-input { padding-left: 38px; }   /* room for the search icon */

        .fm-toolbar .fm-btn-primary {
            width: 100%;
            height: 44px;
            font-size: 13.5px;
            font-weight: 700;
            background: #14b8a1;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(20, 184, 161, .25);
        }
        .fm-toolbar .fm-btn-primary:hover { background: #10a08c; }
        .fm-toolbar .fm-btn-primary i { font-size: 12px; }

        /* ---------- Model cards ---------- */
        .fm-list-card { background: transparent; border: 0; border-radius: 0; }
        .fm-table-wrap { overflow: visible; }   /* do not cut the card shadows */

        .fm-table { min-width: 0; display: block; }
        .fm-table thead { display: none; }
        .fm-table tbody { display: block; }

        .fm-table tbody tr[data-id] {
            display: grid;
            grid-template-columns: 56px minmax(0, 1fr) auto;
            grid-template-areas:
                "image  name   toggle"
                "image  reg    ."
                "image  id     ."
                "email  email  email"
                "phone  phone  phone"
                "gender gender gender"
                "height height height"
                "age    age    age"
                "act    act    act";
            column-gap: 12px;
            align-items: center;
            padding: 12px 12px 0;
            margin-bottom: 12px;
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: var(--fm-m-shadow);
            overflow: hidden;
        }
        .fm-table tbody tr[data-id]:hover { background: #fff; }
        .fm-table tbody tr.is-confirming { margin-bottom: 6px; }
        tr.is-confirming td { background: transparent; }

        .fm-table tbody td { padding: 0 !important; border: 0; white-space: normal; }

        .fm-c-image  { grid-area: image; align-self: start; }
        .fm-c-name   { grid-area: name; min-width: 0; }
        .fm-c-reg    { grid-area: reg; font-size: 12.5px; color: #1f2328; }
        .fm-c-id     { grid-area: id; }
        .fm-table td.fm-c-toggle { grid-area: toggle; display: block; align-self: start; }
        .fm-c-email  { grid-area: email; }
        .fm-c-phone  { grid-area: phone; }
        .fm-c-gender { grid-area: gender; }
        .fm-c-height { grid-area: height; }
        .fm-c-age    { grid-area: age; }
        .fm-c-act    { grid-area: act; }

        /* Photo with a light ring */
        .fm-c-image .fm-avatar { width: 56px; height: 56px; font-size: 16px; box-shadow: 0 0 0 2px #e5e7eb; }

        .fm-name { font-size: 13.5px; color: #111827; overflow-wrap: anywhere; }
        .fm-id { font-size: 12.5px; font-weight: 700; color: #1f2328; }

        /* Open / close arrow */
        .fm-row-toggle {
            width: 26px;
            height: 24px;
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
        .fm-row-toggle:hover { background: #f1f2f4; }
        .fm-row-toggle i { transition: transform .2s; }
        tr.is-open .fm-row-toggle i { transform: rotate(180deg); }

        /* Details (shown when the card is opened): "Label ........ value" */
        .fm-table tbody td.fm-c-email, .fm-table tbody td.fm-c-phone, .fm-table tbody td.fm-c-gender,
        .fm-table tbody td.fm-c-height, .fm-table tbody td.fm-c-age {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin: 0 -12px;
            padding: 10px 12px !important;
            font-size: 12.5px;
            color: #1f2328;
            text-align: right;
            border-top: 1px solid #eceef1 !important;
        }
        .fm-table tbody td.fm-c-email { margin-top: 12px; overflow-wrap: anywhere; }
        .fm-c-email::before, .fm-c-phone::before, .fm-c-gender::before,
        .fm-c-height::before, .fm-c-age::before {
            content: attr(data-label);
            flex-shrink: 0;
            font-size: 12.5px;
            font-weight: 400;
            color: #4b5563;
            text-align: left;
        }
        .fm-c-gender .fm-gender i { display: none; }   /* plain text, like the design */

        .fm-table tbody tr[data-id]:not(.is-open) .fm-c-email,
        .fm-table tbody tr[data-id]:not(.is-open) .fm-c-phone,
        .fm-table tbody tr[data-id]:not(.is-open) .fm-c-gender,
        .fm-table tbody tr[data-id]:not(.is-open) .fm-c-height,
        .fm-table tbody tr[data-id]:not(.is-open) .fm-c-age { display: none; }

        /* Grey strip with "Model Profile" + delete */
        .fm-table tbody td.fm-c-act {
            margin: 12px -12px 0;
            padding: 8px 12px !important;
            background: #f9fafb;
            border-top: 1px solid #eceef1 !important;
        }
        .fm-table tbody tr.is-open td.fm-c-act { margin-top: 0; }   /* open card: strip right under "Age" */
        .fm-row-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; width: 100%; }
        .fm-c-act .fm-profile-btn {
            height: 28px;
            font-size: 11.5px;
            font-weight: 700;
            color: #1fa45f !important;
            background: #fff;
            border: 1px solid #a8dcc0;
            border-radius: 6px;
        }
        .fm-c-act .fm-profile-btn:hover { background: #f1faf5; }
        .fm-c-act .fm-icon-btn {
            width: auto;
            height: 28px;
            font-size: 12px;
            border-color: #f3a9ad;
            border-radius: 6px;
        }

        /* ---------- Empty message + pagination ---------- */
        .fm-empty {
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: var(--fm-m-shadow);
        }
        .fm-footer {
            flex-direction: column;
            justify-content: center;
            padding: 12px;
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            box-shadow: var(--fm-m-shadow);
        }
        .fm-pagination { justify-content: center; }

        /* ---------- Delete confirmation (under the card) ---------- */
        .fm-table tbody tr.fm-confirm-row { display: block; margin-bottom: 12px; padding: 0; border-top: 0; }
        .fm-table tbody tr.fm-confirm-row td { display: block; padding: 0 !important; }
        .fm-confirm { border-radius: 14px; }
        .fm-confirm .fm-del-person { min-width: 0; }
        .fm-confirm .fm-del-person span { overflow-wrap: anywhere; }
        .fm-confirm-btns { width: 100%; }
        .fm-confirm-btns .fm-btn { flex: 1; height: 40px; border-radius: 8px; }

        .fm-toast { left: 16px; right: 16px; bottom: 140px; }
    }

    /* Very small phones (320px) */
    @media (max-width: 359.98px) {
        .fm-toolbar { padding: 12px; }
        .fm-table tbody tr[data-id] { grid-template-columns: 48px minmax(0, 1fr) auto; column-gap: 10px; }
        .fm-c-image .fm-avatar { width: 48px; height: 48px; }
    }
    @media (max-width: 768px) {
        .header1 {
            height: 40px;
            margin-top: 11px;
        }
    }
</style>

<div class="container-fluid fm-page">

    @section('order-header')
        <span>Shoot Models</span>
    @endsection

    {{-- ================= TOOLBAR ================= --}}
    <div class="fm-card fm-toolbar">
        <div class="fm-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="fmSearch" class="fm-input" placeholder="Search by name, register date, email, phone..." autocomplete="off">
        </div>
        <a href="{{ route('studio.shoot.create') }}" class="fm-btn fm-btn-primary" id="fmAddBtn">
            <i class="fa-solid fa-plus"></i> Add Models
        </a>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="fm-card fm-list-card">
        <div class="fm-table-wrap">
            <table class="fm-table">
                <thead>
                    <tr>
                        <th class="fm-sortable" data-sort="registered" style="width: 130px;">Register Date <i class="fa-solid fa-sort"></i></th>
                        <th class="fm-sortable" data-sort="id" style="width: 100px;">Model ID <i class="fa-solid fa-sort"></i></th>
                        <th style="width: 60px;">Image</th>
                        <th class="fm-sortable" data-sort="name">Name <i class="fa-solid fa-sort"></i></th>
                        <th class="fm-sortable" data-sort="email" style="width: 200px;">Email Address <i class="fa-solid fa-sort"></i></th>
                        <th style="width: 140px;">Phone No</th>
                        <th class="fm-sortable" data-sort="gender" style="width: 100px;">Gender <i class="fa-solid fa-sort"></i></th>
                        <th class="fm-sortable" data-sort="height" style="width: 90px;">Height <i class="fa-solid fa-sort"></i></th>
                        <th class="fm-sortable" data-sort="age" style="width: 70px;">Age <i class="fa-solid fa-sort"></i></th>
                        <th style="width: 160px;"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody id="fmBody"></tbody>
            </table>
        </div>

        <div id="fmEmpty" class="fm-empty fm-hidden">
            <i class="fa-regular fa-user"></i>
            <span id="fmEmptyText">No models found.</span>
        </div>

        <div class="fm-footer">
            <div class="fm-info" id="fmInfo"></div>
            <div class="fm-pagination" id="fmPagination"></div>
        </div>
    </div>

    <div class="fm-toast" id="fmToast" role="status" aria-live="polite">
        <i class="fa-solid fa-circle-check"></i><span data-role="text"></span>
    </div>
</div>

@endsection

@push('js')
<script>
$(function () {

    const PER_PAGE = 10;

    // Model Profile page link ("__ID__" is replaced with the model id)
    const PROFILE_URL = @json(route('studio.shoot.models.profile', ['id' => '__ID__']));
    /* =====================================================
       DATA FROM THE CONTROLLER (StudioOrderController@shootModels)
       height_in = total height in inches (5'7" = 67)
       ===================================================== */
    let models = @json($fashionModels);
    const DESTROY_URL = @json(route('studio.shoot.models.destroy', ['fashionModel' => '__ID__']));

    // AJAX helper: returns a Promise (rejects with the jQuery XHR on error)
    function api(method, url, data) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                url: url, method: method,
                data: data ? JSON.stringify(data) : null,
                contentType: 'application/json', dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json' },
            }).done(resolve).fail(reject);
        });
    }
    function errorMessage(xhr, fallback) {
        const json = xhr && xhr.responseJSON;
        if (json && json.errors) { const first = Object.values(json.errors)[0]; if (first && first[0]) return first[0]; }
        if (json && json.message && xhr.status !== 500) return json.message;
        if (xhr && xhr.status === 419) return 'Your session has expired. Please refresh the page.';
        if (xhr && xhr.status === 404) return 'This model no longer exists. Please refresh the page.';
        return fallback || 'Something went wrong. Please try again.';
    }

    /* =====================================================
       HELPERS
       ===================================================== */
    function esc(v) { return $('<div>').text(v == null ? '' : String(v)).html(); }

    function todayISO() {
        const d = new Date();
        return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
    }

    function formatDate(iso) {
        if (!iso) return '';
        const p = iso.split('-');
        return new Date(+p[0], +p[1] - 1, +p[2]).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
    }

    // Age in full years from "YYYY-MM-DD"
    function ageFrom(dob) {
        if (!dob) return null;
        const p = dob.split('-').map(Number);
        const now = new Date();
        let age = now.getFullYear() - p[0];
        if (now.getMonth() + 1 < p[1] || (now.getMonth() + 1 === p[1] && now.getDate() < p[2])) age--;
        return age >= 0 ? age : null;
    }

    // 67 -> 5'7"
    function formatHeight(inches) {
        if (!inches) return '';
        const ft = Math.floor(inches / 12), inch = Math.round((inches - ft * 12) * 10) / 10;
        return ft + '\'' + inch + '"';
    }

    // Age saved on the profile (fashion_models.age), else from the date of birth
    function modelAge(m) { return m.age !== null && m.age !== undefined ? m.age : ageFrom(m.date_of_birth); }

    function modelId(id) { return '#' + String(id).padStart(6, '0'); }

    const AVATAR_COLORS = ['#16a394', '#7b5fc7', '#d6713a', '#1d5fd0', '#c2416b', '#3d8b40'];
    function avatar(m, large) {
        const cls = 'fm-avatar' + (large ? ' fm-avatar-lg' : '');
        if (m.photo) return '<span class="' + cls + '"><img src="' + esc(m.photo) + '" alt="' + esc(m.name) + '"></span>';
        let hash = 0;
        for (let i = 0; i < m.name.length; i++) hash = (hash * 31 + m.name.charCodeAt(i)) >>> 0;
        const initials = m.name.split(/\s+/).map(function (w) { return w.charAt(0); }).slice(0, 2).join('').toUpperCase();
        return '<span class="' + cls + '" style="background:' + AVATAR_COLORS[hash % AVATAR_COLORS.length] + '">' + esc(initials) + '</span>';
    }

    function genderLabel(g) {
        if (g === 'Female') return '<span class="fm-gender is-female"><i class="fa-solid fa-venus"></i>Female</span>';
        if (g === 'Male')   return '<span class="fm-gender is-male"><i class="fa-solid fa-mars"></i>Male</span>';
        return '<span class="fm-dash">—</span>';
    }

    function orDash(v) { return (v === null || v === undefined || v === '') ? '<span class="fm-dash">—</span>' : esc(v); }

    let toastTimer = null;
    function showToast(message, isError) {
        const $t = $('#fmToast');
        $t.toggleClass('is-error', !!isError).find('i').attr('class', isError ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check');
        $t.find('[data-role="text"]').text(message);
        $t.addClass('is-visible');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { $t.removeClass('is-visible'); }, 3000);
    }

    function findModel(id) { return models.find(function (m) { return String(m.id) === String(id); }); }

    /* =====================================================
       TABLE: sort, search, paginate
       ===================================================== */
    let filtered = models.slice();
    let page = 1;
    let sortKey = 'registered';
    let sortDir = 'desc';

    function sortValue(m) {
        switch (sortKey) {
            case 'registered': return m.registered || '';
            case 'id':         return m.id;
            case 'name':       return m.name.toLowerCase();
            case 'email':      return (m.email || '').toLowerCase();
            case 'gender':     return m.gender || '';
            case 'height':     return m.height_in || 0;
            case 'age':        return modelAge(m) || 0;
        }
        return '';
    }

    function sortModels() {
        models.sort(function (a, b) {
            const x = sortValue(a), y = sortValue(b);
            if ((x === '' || x === 0) && y) return 1;     // empty values always last
            if (x && (y === '' || y === 0)) return -1;
            if (x < y) return sortDir === 'asc' ? -1 : 1;
            if (x > y) return sortDir === 'asc' ? 1 : -1;
            return 0;
        });
        $('.fm-sortable').removeClass('is-active').find('i').attr('class', 'fa-solid fa-sort');
        $('.fm-sortable[data-sort="' + sortKey + '"]').addClass('is-active').find('i')
            .attr('class', sortDir === 'asc' ? 'fa-solid fa-sort-up' : 'fa-solid fa-sort-down');
    }

    function applySearch(keepPage) {
        const q = $('#fmSearch').val().trim().toLowerCase();
        filtered = models.filter(function (m) {
            if (!q) return true;
            const text = [m.name, m.email, m.phone_number, modelId(m.id), String(m.id), m.gender,
                          formatDate(m.registered), m.registered, formatHeight(m.height_in)].join(' ').toLowerCase();
            return text.indexOf(q) !== -1;
        });
        if (!keepPage) page = 1;
        render();
    }

    function rowHtml(m) {
        const age = modelAge(m);
        return '<tr data-id="' + m.id + '">' +
            '<td class="fm-c-reg" data-label="Register Date">' + esc(formatDate(m.registered)) + '</td>' +
            '<td class="fm-c-id"><span class="fm-id">' + esc(modelId(m.id)) + '</span></td>' +
            '<td class="fm-c-image">' + avatar(m) + '</td>' +
            '<td class="fm-c-name"><span class="fm-name">' + esc(m.name) + '</span></td>' +
            '<td class="fm-c-email" data-label="Email Address">' + orDash(m.email) + '</td>' +
            '<td class="fm-c-phone" data-label="Phone No">' + orDash(m.phone_number) + '</td>' +
            '<td class="fm-c-gender" data-label="Gender">' + genderLabel(m.gender) + '</td>' +
            '<td class="fm-c-height" data-label="Height">' + orDash(formatHeight(m.height_in)) + '</td>' +
            '<td class="fm-c-age" data-label="Age">' + orDash(age) + '</td>' +
            '<td class="fm-c-act"><div class="fm-row-actions">' +
                '<a href="' + esc(PROFILE_URL.replace('__ID__', m.id)) + '" class="fm-profile-btn">Model Profile</a>' +
                '<button type="button" class="fm-icon-btn" data-action="delete" title="Delete model" aria-label="Delete ' + esc(m.name) + '"><i class="fa-regular fa-trash-can"></i></button>' +
            '</div></td>' +
            // Phones only: open / close the card details (hidden on desktop)
            '<td class="fm-c-toggle">' +
                '<button type="button" class="fm-row-toggle" data-action="toggle" aria-expanded="false" aria-label="Show details for ' + esc(m.name) + '">' +
                    '<i class="fa-solid fa-chevron-down"></i>' +
                '</button>' +
            '</td>' +
        '</tr>';
    }

    function pageList(current, total) {
        if (total <= 7) return Array.from({ length: total }, function (_, i) { return i + 1; });
        if (current <= 4)         return [1, 2, 3, 4, 5, '…', total];
        if (current >= total - 3) return [1, '…', total - 4, total - 3, total - 2, total - 1, total];
        return [1, '…', current - 1, current, current + 1, '…', total];
    }

    function render() {
        const total = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        page = Math.min(Math.max(page, 1), totalPages);
        const start = (page - 1) * PER_PAGE;
        const list = filtered.slice(start, start + PER_PAGE);

        $('#fmBody').html(list.map(rowHtml).join(''));

        if (!total) {
            $('#fmEmptyText').text(models.length ? 'No models match your search.' : 'No models yet. Click "Add Models" to add the first one.');
            $('#fmEmpty').removeClass('fm-hidden');
            $('#fmInfo').text('No models found');
            $('#fmPagination').empty();
            return;
        }

        $('#fmEmpty').addClass('fm-hidden');
        $('#fmInfo').text('Showing ' + (start + 1) + '–' + (start + list.length) + ' of ' + total + (total === 1 ? ' Model' : ' Models'));

        let html = '<button type="button" class="fm-page-btn" data-page="prev"' + (page === 1 ? ' disabled' : '') + '>Previous</button>';
        pageList(page, totalPages).forEach(function (p) {
            html += p === '…' ? '<span class="fm-ellipsis">…</span>'
                : '<button type="button" class="fm-page-btn' + (p === page ? ' active' : '') + '" data-page="' + p + '">' + p + '</button>';
        });
        html += '<button type="button" class="fm-page-btn" data-page="next"' + (page === totalPages ? ' disabled' : '') + '>Next</button>';
        $('#fmPagination').html(html);
    }

    $('.fm-sortable').on('click', function () {
        const key = $(this).data('sort');
        if (sortKey === key) sortDir = sortDir === 'asc' ? 'desc' : 'asc';
        else { sortKey = key; sortDir = (key === 'registered' || key === 'id') ? 'desc' : 'asc'; }
        sortModels();
        applySearch();
    });

    let searchTimer = null;
    $('#fmSearch').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { applySearch(); }, 250);
    });

    $('#fmPagination').on('click', '.fm-page-btn', function () {
        if (this.disabled) return;
        const t = $(this).data('page');
        if (t === 'prev') page--; else if (t === 'next') page++; else page = parseInt(t, 10);
        render();
        $('html, body').stop().animate({ scrollTop: $('.fm-table-wrap').offset().top - 90 }, 250);
    });

    /* =====================================================
       DELETE (inline confirmation under the row, no popup)
       ===================================================== */
    function closeConfirm() {
        $('#fmBody .fm-confirm-row').remove();
        $('#fmBody tr.is-confirming').removeClass('is-confirming');
    }

    $('#fmBody').on('click', '[data-action="delete"]', function () {
        const $row = $(this).closest('tr');
        const m = findModel($row.data('id'));
        if (!m) return;
        const isOpen = $row.hasClass('is-confirming');
        closeConfirm();
        if (isOpen) return;                    // second click on the bin closes it

        const age = modelAge(m);
        $row.addClass('is-confirming').after(
            '<tr class="fm-confirm-row" data-for="' + m.id + '"><td colspan="10">' +
                '<div class="fm-confirm" role="alert">' +
                    '<div class="fm-del-person">' + avatar(m) +
                        '<div><b>Delete ' + esc(m.name) + '?</b><span>' + esc(modelId(m.id)) + (m.gender ? ' · ' + esc(m.gender) : '') +
                        (age !== null ? ' · ' + age + ' years' : '') + (m.email ? ' · ' + esc(m.email) : '') + '</span></div>' +
                    '</div>' +
                    '<div class="fm-confirm-btns">' +
                        '<button type="button" class="fm-btn fm-btn-outline" data-action="delete-cancel">Cancel</button>' +
                        '<button type="button" class="fm-btn fm-btn-danger" data-action="delete-confirm"><i class="fa-regular fa-trash-can"></i> Delete Model</button>' +
                    '</div>' +
                    '<div class="fm-warn"><i class="fa-solid fa-triangle-exclamation"></i>' +
                        '<span>This model will be removed from the list and can no longer be assigned to shoot items. Items already assigned to this model will show <b>Not assigned</b>.</span></div>' +
                '</div>' +
            '</td></tr>'
        );
        $('#fmBody [data-action="delete-confirm"]').trigger('focus');
    });

    $('#fmBody').on('click', '[data-action="delete-cancel"]', closeConfirm);
    $(document).on('keydown', function (e) { if (e.key === 'Escape') closeConfirm(); });

    $('#fmBody').on('click', '[data-action="delete-confirm"]', function () {
        const m = findModel($(this).closest('.fm-confirm-row').data('for'));
        if (!m) return;
        const $btn = $(this).prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Deleting...');
        api('DELETE', DESTROY_URL.replace('__ID__', m.id)).then(function () {
            models = models.filter(function (x) { return x !== m; });
            applySearch(true);
            showToast('"' + m.name + '" deleted.');
        }).catch(function (xhr) {
            $btn.prop('disabled', false).html('<i class="fa-regular fa-trash-can"></i> Delete Model');
            showToast(errorMessage(xhr, 'Could not delete the model. Please try again.'), true);
        });
    });

    /* =====================================================
       PHONES 
       ===================================================== */
    const phoneQuery = window.matchMedia('(max-width: 767.98px)');

    // Open / close the details of one model card
    $('#fmBody').on('click', '[data-action="toggle"]', function () {
        const $row = $(this).closest('tr');
        const open = !$row.hasClass('is-open');
        const name = (findModel($row.data('id')) || {}).name || '';
        $row.toggleClass('is-open', open);
        $(this).attr('aria-expanded', open ? 'true' : 'false')
               .attr('aria-label', (open ? 'Hide details for ' : 'Show details for ') + name);
    });

    /* ---------------- INIT ---------------- */
    sortModels();
    applySearch();
});
</script>
@endpush