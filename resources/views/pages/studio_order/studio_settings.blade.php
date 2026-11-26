@extends('layouts.app', ['activePage' => 'studio_settings', 'titlePage' => __('Studio Settings')])

@section('content')

<style>
    /* ==========================================================
       STUDIO SETTINGS PAGE  (all classes start with "sst-")
       Values are saved in the studio_settings table
       ========================================================== */
    .sst-page {
        --sst-primary: #16a394;
        --sst-primary-dark: #12897c;
        --sst-primary-soft: #e8f6f4;
        --sst-border: #e6e8eb;
        --sst-text: #1f2328;
        --sst-muted: #6b7280;
        --sst-soft: #f7f8fa;
        --sst-danger: #d64550;
        --sst-warn-bg: #fff8e6;
        --sst-warn-text: #8a5a00;
        --sst-bottom-gap: 110px;   /* space for the fixed world-clock bar */

        font-family: 'Open Sans', sans-serif;
        color: var(--sst-text);
        padding-top: 0 !important;
        padding-bottom: var(--sst-bottom-gap) !important;
    }
    .sst-page *, .sst-page *::before, .sst-page *::after { box-sizing: border-box; }
    .sst-hidden { display: none !important; }

    .sst-page > .sst-grid { margin-top: 18px; }

    /* ---------- Layout: form + simple summary ---------- */
    .sst-grid { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: 18px; align-items: start; }

    .sst-card { background: #fff; border: 1px solid var(--sst-border); border-radius: 8px; }
    .sst-section { padding: 20px 22px; border-top: 1px solid var(--sst-border); }
    .sst-section:first-child { border-top: 0; }
    .sst-section-head { display: flex; gap: 12px; margin-bottom: 16px; }
    .sst-section-icon {
        flex: 0 0 36px; height: 36px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        background: var(--sst-primary-soft); color: var(--sst-primary); font-size: 15px;
    }
    .sst-section-head h2 { margin: 0; font-size: 15px; font-weight: 700; color: var(--sst-text); }
    .sst-section-head p { margin: 2px 0 0; font-size: 12.5px; color: var(--sst-muted); }

    .sst-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .sst-field label {
        display: block; margin-bottom: 6px;
        font-size: 12px; font-weight: 700; color: #374151;
    }
    .sst-field label small { font-weight: 400; color: var(--sst-muted); }
    .sst-help { margin-top: 6px; font-size: 12px; color: var(--sst-muted); }
    .sst-error { margin-top: 6px; font-size: 12px; color: var(--sst-danger); }
    .sst-error:empty { display: none; }

    /* ---------- Searchable picker ---------- */
    .sst-picker { position: relative; }
    .sst-picker-btn {
        width: 100%; min-height: 42px; display: flex; align-items: center; gap: 10px;
        padding: 6px 12px; border: 1px solid #d6d9de; border-radius: 8px; background: #fff;
        font-size: 13.5px; color: var(--sst-text); text-align: left; cursor: pointer;
        transition: border-color .15s, box-shadow .15s;
    }
    .sst-picker-btn:hover { border-color: #b9bec6; }
    .sst-picker-btn:focus-visible, .sst-picker.is-open .sst-picker-btn {
        outline: none; border-color: var(--sst-primary); box-shadow: 0 0 0 3px var(--sst-primary-soft);
    }
    .sst-picker-btn:disabled { background: var(--sst-soft); color: #9aa0a6; cursor: not-allowed; }
    .sst-picker.has-error .sst-picker-btn { border-color: var(--sst-danger); }
    .sst-picker-value { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .sst-picker-value.is-placeholder { color: #9aa0a6; }
    .sst-picker-sub { color: var(--sst-muted); font-size: 12px; margin-left: 4px; }
    .sst-picker-caret { color: #9aa0a6; font-size: 12px; transition: transform .15s; }
    .sst-picker.is-open .sst-picker-caret { transform: rotate(180deg); }

    .sst-pop {
        position: absolute; left: 0; right: 0; top: calc(100% + 6px); z-index: 30;
        background: #fff; border: 1px solid var(--sst-border); border-radius: 10px;
        box-shadow: 0 12px 28px rgba(17, 24, 39, .14); overflow: hidden;
    }
    .sst-pop-search { position: relative; padding: 8px; border-bottom: 1px solid var(--sst-border); }
    .sst-pop-search i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #9aa0a6; font-size: 13px; }
    .sst-pop-search input {
        width: 100%; height: 36px; padding: 0 10px 0 32px;
        border: 1px solid #d6d9de; border-radius: 7px; font-size: 13px; outline: none;
    }
    .sst-pop-search input:focus { border-color: var(--sst-primary); }
    .sst-pop-list { max-height: 260px; overflow-y: auto; padding: 4px; margin: 0; list-style: none; }
    .sst-opt {
        display: flex; align-items: center; gap: 10px; width: 100%;
        padding: 8px 10px; border: 0; border-radius: 7px; background: transparent;
        font-size: 13px; color: var(--sst-text); text-align: left; cursor: pointer;
    }
    .sst-opt:hover, .sst-opt.is-active { background: var(--sst-soft); }
    .sst-opt.is-selected { background: var(--sst-primary-soft); font-weight: 600; }
    .sst-opt-main { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .sst-opt small { color: var(--sst-muted); font-size: 11.5px; font-weight: 400; }
    .sst-opt .fa-check { color: var(--sst-primary); }
    .sst-pop-empty { padding: 14px; font-size: 12.5px; color: var(--sst-muted); text-align: center; }

    .sst-avatar {
        flex: 0 0 28px; width: 28px; height: 28px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; color: #fff;
    }
    .sst-avatar { position: relative; overflow: hidden; }
    .sst-avatar img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .sst-icon-chip {
        flex: 0 0 28px; width: 28px; height: 28px; border-radius: 7px;
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--sst-soft); color: var(--sst-muted); font-size: 12px;
    }

    /* ---------- Days stepper ---------- */
    .sst-days { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .sst-stepper { display: inline-flex; align-items: stretch; border: 1px solid #d6d9de; border-radius: 8px; overflow: hidden; }
    .sst-stepper button {
        width: 40px; border: 0; background: var(--sst-soft); color: #374151; font-size: 13px; cursor: pointer;
    }
    .sst-stepper button:hover { background: #eceef1; }
    .sst-stepper button:disabled { color: #c2c8d0; cursor: not-allowed; }
    .sst-stepper input {
        width: 64px; height: 42px; border: 0; border-left: 1px solid #d6d9de; border-right: 1px solid #d6d9de;
        text-align: center; font-size: 16px; font-weight: 700; color: var(--sst-text); outline: none;
        -moz-appearance: textfield;
    }
    .sst-stepper input::-webkit-outer-spin-button, .sst-stepper input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .sst-stepper.has-error { border-color: var(--sst-danger); }
    .sst-days-label { font-size: 13.5px; color: #374151; }


    /* ---------- Footer ---------- */
    .sst-footer {
        display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
        padding: 14px 22px; border-top: 1px solid var(--sst-border); background: #fcfcfd; border-radius: 0 0 8px 8px;
    }
    .sst-meta { font-size: 12.5px; color: var(--sst-muted); }
    .sst-meta b { color: #374151; font-weight: 600; }
    .sst-unsaved { display: inline-flex; align-items: center; gap: 6px; margin-left: 10px; color: var(--sst-warn-text); font-weight: 600; }
    .sst-unsaved i { font-size: 8px; }
    .sst-actions { display: flex; gap: 8px; }
    .sst-btn {
        display: inline-flex; align-items: center; gap: 7px; height: 38px; padding: 0 16px;
        border-radius: 8px; border: 1px solid #d6d9de; background: #fff; color: var(--sst-text);
        font-size: 13px; font-weight: 600; cursor: pointer;
    }
    .sst-btn:hover { background: #f5f6f7; }
    .sst-btn:disabled { opacity: .55; cursor: not-allowed; }
    .sst-btn-primary { background: var(--sst-primary); border-color: var(--sst-primary); color: #fff; }
    .sst-btn-primary:hover { background: var(--sst-primary-dark); }


    /* ---------- Summary (right side) ---------- */
    .sst-summary { position: sticky; top: 16px; }
    .sst-summary-head { padding: 16px 18px 12px; border-bottom: 1px solid var(--sst-border); }
    .sst-summary-head h3 { margin: 0; font-size: 14px; font-weight: 700; color: var(--sst-text); }
    .sst-summary-head p { margin: 2px 0 0; font-size: 12px; color: var(--sst-muted); }
    .sst-summary-list { margin: 0; padding: 6px 18px 10px; list-style: none; }
    .sst-summary-list li {
        display: flex; align-items: center; justify-content: space-between; gap: 12px;
        padding: 10px 0; border-top: 1px solid #f0f1f3; font-size: 13px;
    }
    .sst-summary-list li:first-child { border-top: 0; }
    .sst-summary-label { display: inline-flex; align-items: center; gap: 8px; color: var(--sst-muted); white-space: nowrap; }
    .sst-summary-label i { width: 14px; text-align: center; color: #9aa0a6; }
    .sst-summary-value {
        display: inline-flex; align-items: center; gap: 6px; min-width: 0;
        font-weight: 600; color: var(--sst-text); text-align: right;
    }
    .sst-summary-value span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .sst-summary-value .sst-avatar { flex-basis: 22px; width: 22px; height: 22px; font-size: 9px; }
    .sst-summary-value.is-missing { color: var(--sst-danger); font-weight: 600; }
    .sst-summary-value.is-changed::after {
        content: ''; flex: 0 0 7px; width: 7px; height: 7px; border-radius: 50%; background: #e0a100;
    }
    .sst-summary-foot { padding: 10px 18px 14px; font-size: 11.5px; color: var(--sst-muted); }
    .sst-summary-foot i { color: #e0a100; font-size: 7px; vertical-align: middle; margin-right: 4px; }

    /* ---------- Toast ---------- */
    .sst-toast {
        position: fixed; right: 24px; bottom: 130px; z-index: 1090;
        display: flex; align-items: center; gap: 10px; max-width: 380px;
        padding: 11px 16px; border-radius: 8px; background: #1f2328; color: #fff; font-size: 13px;
        box-shadow: 0 10px 24px rgba(0, 0, 0, .2);
        opacity: 0; transform: translateY(8px); pointer-events: none; transition: opacity .2s, transform .2s;
    }
    .sst-toast.is-visible { opacity: 1; transform: translateY(0); }
    .sst-toast i { color: #34d399; }
    .sst-toast.is-error i { color: #f87171; }

    @media (max-width: 1199.98px) {
        .sst-grid { grid-template-columns: 1fr; }
        .sst-summary { position: static; }
    }
    @media (max-width: 767.98px) {
        .sst-page { --sst-bottom-gap: 130px; }
        .sst-fields { grid-template-columns: 1fr; }
        .sst-section { padding: 16px; }
        .sst-footer { padding: 14px 16px; }
        .sst-actions { width: 100%; }
        .sst-actions .sst-btn { flex: 1; justify-content: center; height: 42px; }
        .sst-toast { left: 16px; right: 16px; bottom: 140px; }
        .sst-picker-btn, .sst-pop-search input, .sst-stepper input { font-size: 16px; }
    }

    @media (max-width: 768px) {
        .header1 {
            height: 40px;
            margin-top: 11px;
        }
    }
</style>

<div class="container-fluid sst-page">

    @section('order-header')
        <span>Studio Settings</span>
    @endsection

    <div class="sst-grid">

        {{-- ================= SETTINGS FORM ================= --}}
        <form class="sst-card" id="sstForm" novalidate>

            {{-- 1. Project Management link --}}
            <div class="sst-section">
                <div class="sst-section-head">
                    <div class="sst-section-icon"><i class="fa-solid fa-diagram-project"></i></div>
                    <div>
                        <h2>Project Management link</h2>
                        <p>Every new shoot becomes a task in this project and section. Its items become sub tasks.</p>
                    </div>
                </div>
                <div class="sst-fields">
                    <div class="sst-field">
                        <label id="lblProject">Project</label>
                        <div class="sst-picker" data-picker="project" aria-labelledby="lblProject"></div>
                        <div class="sst-error" data-error="project"></div>
                    </div>
                    <div class="sst-field">
                        <label id="lblSection">Section <small>(sections of the chosen project)</small></label>
                        <div class="sst-picker" data-picker="section" aria-labelledby="lblSection"></div>
                        <div class="sst-error" data-error="section"></div>
                    </div>
                </div>
            </div>

            {{-- 2. Default assignees --}}
            <div class="sst-section">
                <div class="sst-section-head">
                    <div class="sst-section-icon"><i class="fa-solid fa-user-check"></i></div>
                    <div>
                        <h2>Default assignees</h2>
                        <p>Set automatically when a shoot or item is created. It can still be changed later in Project Management.</p>
                    </div>
                </div>
                <div class="sst-fields">
                    <div class="sst-field">
                        <label id="lblShootUser">Shoot task</label>
                        <div class="sst-picker" data-picker="shootUser" aria-labelledby="lblShootUser"></div>
                        <div class="sst-help">The person who owns the whole shoot.</div>
                        <div class="sst-error" data-error="shootUser"></div>
                    </div>
                    <div class="sst-field">
                        <label id="lblItemUser">Shoot item task</label>
                        <div class="sst-picker" data-picker="itemUser" aria-labelledby="lblItemUser"></div>
                        <div class="sst-help">The person who gets each item ready.</div>
                        <div class="sst-error" data-error="itemUser"></div>
                    </div>
                </div>
            </div>

            {{-- 3. Due dates --}}
            <div class="sst-section">
                <div class="sst-section-head">
                    <div class="sst-section-icon"><i class="fa-regular fa-calendar-check"></i></div>
                    <div>
                        <h2>Item due date</h2>
                        <p>Items must be ready before the shoot. The shoot task itself is due on the shoot date.</p>
                    </div>
                </div>
                <div class="sst-field">
                    <label for="sstDays">Items are due</label>
                    <div class="sst-days">
                        <div class="sst-stepper" id="sstStepper">
                            <button type="button" data-step="-1" aria-label="One day less"><i class="fa-solid fa-minus"></i></button>
                            <input type="number" id="sstDays" min="0" max="30" step="1" inputmode="numeric" aria-describedby="sstDaysHelp">
                            <button type="button" data-step="1" aria-label="One day more"><i class="fa-solid fa-plus"></i></button>
                        </div>
                        <span class="sst-days-label" id="sstDaysWord">days before the shoot date</span>
                    </div>
                    <div class="sst-help" id="sstDaysHelp">From 0 (same day as the shoot) to 30 days.</div>
                    <div class="sst-error" data-error="days"></div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="sst-footer">
                <div class="sst-meta">
                    <span id="sstMetaText"></span>
                    <span class="sst-unsaved sst-hidden" id="sstUnsaved"><i class="fa-solid fa-circle"></i> Unsaved changes</span>
                </div>
                <div class="sst-actions">
                    <button type="button" class="sst-btn" id="sstReset" disabled><i class="fa-solid fa-rotate-left"></i> Discard</button>
                    <button type="submit" class="sst-btn sst-btn-primary" id="sstSave" disabled><i class="fa-solid fa-floppy-disk"></i> Save settings</button>
                </div>
            </div>
        </form>

        {{-- ================= SIMPLE SUMMARY ================= --}}
        <aside class="sst-card sst-summary" aria-label="What a new shoot will get">
            <div class="sst-summary-head">
                <h3>What a new shoot will get</h3>
                <p>Live preview with your current choices</p>
            </div>
            <ul class="sst-summary-list" id="sstSummary"></ul>
            <div class="sst-summary-foot sst-hidden" id="sstSummaryFoot"><i class="fa-solid fa-circle"></i>Changed, not saved yet</div>
        </aside>
    </div>

    <div class="sst-toast" id="sstToast" role="status" aria-live="polite"><i class="fa-solid fa-circle-check"></i><span></span></div>
</div>

@endsection

@push('js')
<script>
$(function () {
    /* =====================================================
       DATA FROM THE CONTROLLER
       ===================================================== */
    const PROJECTS = @json($projects);                 // [{ id, name, no }]
    const USERS    = @json($users);                    // [{ id, name, role, photo }] active users only
    const SETTINGS = @json($settings);                 // saved values (or defaults)
    const META     = @json($meta);                     // { by, at } last change
    const URLS = {
        sections: @json(route('studio.settings.sections', ['project' => '__ID__'])),
        save:     @json(route('studio.settings.update')),
    };

    // Sections are loaded per project and kept here: { projectId: [{ id, name, project_id }] }
    const sectionCache = {};
    sectionCache[SETTINGS.pm_project_id] = @json($sections);
    let loadingProject = null;

    // Screen keys <-> database keys
    const FIELD_KEYS = {
        project:   'pm_project_id',
        section:   'pm_section_id',
        shootUser: 'pm_shoot_assignee_id',
        itemUser:  'pm_item_assignee_id',
        days:      'item_due_days_before_shoot',
    };

    let saved = {
        project:   SETTINGS.pm_project_id,
        section:   SETTINGS.pm_section_id,
        shootUser: SETTINGS.pm_shoot_assignee_id,
        itemUser:  SETTINGS.pm_item_assignee_id,
        days:      SETTINGS.item_due_days_before_shoot,
        changedBy: META.by,
        changedAt: META.at,
    };

    let form = $.extend({}, saved);   // what is on the screen

    /* =====================================================
       HELPERS
       ===================================================== */
    function esc(v) {
        return String(v == null ? '' : v).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }
    const COLORS = ['#16a394', '#1d5fd0', '#b7791f', '#8b5cf6', '#d64550', '#0e7490', '#4b5563'];
    function avatar(user) {
        if (!user) return '<span class="sst-icon-chip"><i class="fa-regular fa-user"></i></span>';
        const parts = user.name.trim().split(/\s+/);
        const letters = (parts[0][0] + (parts.length > 1 ? parts[parts.length - 1][0] : '')).toUpperCase();
        return '<span class="sst-avatar" style="background:' + COLORS[user.id % COLORS.length] + '" aria-hidden="true">' + esc(letters) +
               (user.photo ? '<img src="' + esc(user.photo) + '" alt="" onerror="this.remove()">' : '') + '</span>';
    }
    const findProject = id => PROJECTS.find(p => p.id === id) || null;
    const findSection = id => Object.values(sectionCache).flat().find(s => s.id === id) || null;
    const findUser    = id => USERS.find(u => u.id === id) || null;
    const sectionsOf  = projectId => sectionCache[projectId] || [];

    function fmtDateTime(iso) {
        const d = new Date(iso);
        return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) + ' ' +
               d.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
    }
    function toast(message, isError) {
        const $t = $('#sstToast');
        $t.toggleClass('is-error', !!isError).find('i').attr('class', isError ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check');
        $t.find('span').text(message);
        $t.addClass('is-visible');
        clearTimeout(toast.timer);
        toast.timer = setTimeout(() => $t.removeClass('is-visible'), 3000);
    }

    /* =====================================================
       SEARCHABLE PICKER (one small component for all 4 dropdowns)
       ===================================================== */
    const PICKERS = {
        project: {
            placeholder: 'Choose a project',
            search: 'Search projects…',
            options: () => PROJECTS.map(p => ({ id: p.id, label: p.name, sub: p.no ? '#' + p.no : '#' + p.id, icon: 'fa-solid fa-folder' })),
        },
        section: {
            placeholder: () => loadingProject === form.project ? 'Loading sections…'
                             : (sectionsOf(form.project).length ? 'Choose a section' : 'This project has no sections'),
            search: 'Search sections…',
            disabled: () => !form.project || loadingProject === form.project || !sectionsOf(form.project).length,
            options: () => sectionsOf(form.project).map(s => ({ id: s.id, label: s.name, sub: '#' + s.id, icon: 'fa-solid fa-layer-group' })),
        },
        shootUser: {
            placeholder: 'Choose a person',
            search: 'Search people…',
            options: () => USERS.map(u => ({ id: u.id, label: u.name, sub: u.role, user: u })),
        },
        itemUser: {
            placeholder: 'Choose a person',
            search: 'Search people…',
            options: () => USERS.map(u => ({ id: u.id, label: u.name, sub: u.role, user: u })),
        },
    };

    function optionLead(o) {
        return o.user ? avatar(o.user) : '<span class="sst-icon-chip"><i class="' + o.icon + '"></i></span>';
    }

    function renderPicker(key) {
        const cfg = PICKERS[key];
        const $p = $('[data-picker="' + key + '"]');
        const selected = cfg.options().find(o => o.id === form[key]);
        const placeholder = typeof cfg.placeholder === 'function' ? cfg.placeholder() : cfg.placeholder;
        const disabled = cfg.disabled ? cfg.disabled() : false;
        const labelId = $p.attr('aria-labelledby');

        $p.html(
            '<button type="button" class="sst-picker-btn" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="' + labelId + ' ' + labelId + '-v"' + (disabled ? ' disabled' : '') + '>' +
                (selected ? optionLead(selected) : '') +
                '<span class="sst-picker-value' + (selected ? '' : ' is-placeholder') + '" id="' + labelId + '-v">' +
                    (selected ? esc(selected.label) + '<span class="sst-picker-sub">' + esc(selected.sub) + '</span>' : esc(placeholder)) +
                '</span>' +
                '<i class="fa-solid fa-chevron-down sst-picker-caret"></i>' +
            '</button>'
        );
    }

    let openKey = null;
    let activeIndex = 0;

    function openPicker(key) {
        closePicker();
        openKey = key;
        const cfg = PICKERS[key];
        const $p = $('[data-picker="' + key + '"]').addClass('is-open');
        $p.find('.sst-picker-btn').attr('aria-expanded', 'true');
        $p.append(
            '<div class="sst-pop">' +
                '<div class="sst-pop-search"><i class="fa-solid fa-magnifying-glass"></i>' +
                    '<input type="text" placeholder="' + esc(cfg.search) + '" aria-label="' + esc(cfg.search) + '"></div>' +
                '<ul class="sst-pop-list" role="listbox"></ul>' +
            '</div>'
        );
        const list = cfg.options();
        activeIndex = Math.max(0, list.findIndex(o => o.id === form[key]));
        renderOptions('');
        $p.find('.sst-pop-search input').trigger('focus');
    }

    function filteredOptions(q) {
        q = q.trim().toLowerCase();
        return PICKERS[openKey].options().filter(o => !q || o.label.toLowerCase().includes(q) || String(o.sub).toLowerCase().includes(q));
    }

    function renderOptions(q) {
        const $p = $('[data-picker="' + openKey + '"]');
        const list = filteredOptions(q);
        if (activeIndex >= list.length) activeIndex = Math.max(0, list.length - 1);
        $p.find('.sst-pop-list').html(list.length ? list.map((o, i) =>
            '<li><button type="button" class="sst-opt' + (o.id === form[openKey] ? ' is-selected' : '') + (i === activeIndex ? ' is-active' : '') + '" ' +
                'role="option" aria-selected="' + (o.id === form[openKey]) + '" data-id="' + o.id + '">' +
                optionLead(o) +
                '<span class="sst-opt-main">' + esc(o.label) + ' <small>' + esc(o.sub) + '</small></span>' +
                (o.id === form[openKey] ? '<i class="fa-solid fa-check"></i>' : '') +
            '</button></li>'
        ).join('') : '<li class="sst-pop-empty">Nothing found for “' + esc(q) + '”</li>');
        const active = $p.find('.sst-opt.is-active')[0];
        if (active) active.scrollIntoView({ block: 'nearest' });
    }

    function closePicker(focusButton) {
        if (!openKey) return;
        const $p = $('[data-picker="' + openKey + '"]').removeClass('is-open');
        $p.find('.sst-pop').remove();
        $p.find('.sst-picker-btn').attr('aria-expanded', 'false');
        if (focusButton) $p.find('.sst-picker-btn').trigger('focus');
        openKey = null;
    }

    // New project: keep the section only if it belongs to it, else pick its first section
    function pickSectionFor(projectId) {
        const list = sectionsOf(projectId);
        if (!list.some(s => s.id === form.section)) form.section = list.length ? list[0].id : null;
    }

    function loadSections(projectId) {
        if (sectionCache[projectId]) { pickSectionFor(projectId); renderPicker('section'); refresh(); return; }

        loadingProject = projectId;
        form.section = null;
        renderPicker('section');
        refresh();

        $.ajax({
            url: URLS.sections.replace('__ID__', encodeURIComponent(projectId)),
            method: 'GET',
            dataType: 'json',
            headers: { 'Accept': 'application/json' },
        }).done(function (res) {
            sectionCache[projectId] = (res && res.sections) || [];
        }).fail(function (xhr) {
            toast(messageFrom(xhr, 'Could not load the sections of this project.'), true);
        }).always(function () {
            if (loadingProject === projectId) loadingProject = null;
            if (form.project === projectId) pickSectionFor(projectId);
            renderPicker('section');
            refresh();
        });
    }

    function choose(key, id) {
        form[key] = id;
        if (key === 'project') loadSections(id);
        clearError(key);
        if (key === 'project') clearError('section');
        renderPicker(key);
        refresh();
    }

    $('.sst-page').on('click', '.sst-picker-btn', function () {
        const key = $(this).closest('.sst-picker').data('picker');
        if (openKey === key) closePicker(true); else openPicker(key);
    });

    $('.sst-page').on('click', '.sst-opt', function () {
        const key = openKey;
        choose(key, parseInt($(this).data('id'), 10));
        closePicker(true);
    });

    $('.sst-page').on('input', '.sst-pop-search input', function () {
        activeIndex = 0;
        renderOptions(this.value);
    });

    $('.sst-page').on('keydown', '.sst-pop-search input', function (e) {
        const list = filteredOptions(this.value);
        if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
            e.preventDefault();
            if (!list.length) return;
            activeIndex = (activeIndex + (e.key === 'ArrowDown' ? 1 : list.length - 1)) % list.length;
            renderOptions(this.value);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (list[activeIndex]) { const key = openKey; choose(key, list[activeIndex].id); closePicker(true); }
        } else if (e.key === 'Escape') {
            e.preventDefault();
            closePicker(true);
        } else if (e.key === 'Tab') {
            closePicker();
        }
    });

    $(document).on('click', function (e) {
        if (openKey && !$(e.target).closest('.sst-picker').length) closePicker();
    });

    /* =====================================================
       DAYS STEPPER
       ===================================================== */
    function setDays(value) {
        form.days = value;
        $('#sstDays').val(value === null ? '' : value);
        clearError('days');
        refresh();
    }

    $('#sstStepper').on('click', '[data-step]', function () {
        const current = Number.isInteger(form.days) ? form.days : saved.days;
        setDays(Math.min(30, Math.max(0, current + parseInt($(this).data('step'), 10))));
    });

    $('#sstDays').on('input', function () {
        const raw = this.value.trim();
        form.days = raw === '' ? null : Number(raw);
        clearError('days');
        refresh();
    });

    /* =====================================================
       DAYS BUTTONS, UNSAVED STATE
       ===================================================== */
    function daysValid(v) { return Number.isInteger(v) && v >= 0 && v <= 30; }

    function renderDaysControls() {
        $('#sstDaysWord').text((form.days === 1 ? 'day' : 'days') + ' before the shoot date');
        $('#sstStepper [data-step="-1"]').prop('disabled', !(form.days > 0));
        $('#sstStepper [data-step="1"]').prop('disabled', form.days !== null && form.days >= 30);
    }

    function renderSummary() {
        const project = findProject(form.project);
        const section = findSection(form.section);
        const shootUser = findUser(form.shootUser);
        const itemUser = findUser(form.itemUser);
        const days = daysValid(form.days) ? form.days : null;

        function row(icon, label, valueHtml, ok, key) {
            const changed = form[key] !== saved[key];
            return '<li><span class="sst-summary-label"><i class="' + icon + '"></i>' + label + '</span>' +
                   '<span class="sst-summary-value' + (ok ? '' : ' is-missing') + (changed ? ' is-changed' : '') + '">' + valueHtml + '</span></li>';
        }
        const person = u => u ? avatar(u) + '<span>' + esc(u.name) + '</span>' : '<span>Not set</span>';

        $('#sstSummary').html(
            row('fa-solid fa-folder', 'Project', '<span>' + esc(project ? project.name : 'Not set') + '</span>', !!project, 'project') +
            row('fa-solid fa-layer-group', 'Section', '<span>' + esc(section ? section.name : 'Not set') + '</span>', !!section, 'section') +
            row('fa-solid fa-camera', 'Shoot task', person(shootUser), !!shootUser, 'shootUser') +
            row('fa-solid fa-shirt', 'Item task', person(itemUser), !!itemUser, 'itemUser') +
            row('fa-regular fa-calendar', 'Items due',
                '<span>' + (days === null ? 'Not valid' : days === 0 ? 'On the shoot date' : days + (days === 1 ? ' day' : ' days') + ' before') + '</span>',
                days !== null, 'days')
        );
    }

    function isDirty() {
        return ['project', 'section', 'shootUser', 'itemUser', 'days'].some(k => form[k] !== saved[k]);
    }

    function refresh() {
        renderDaysControls();
        renderSummary();
        const dirty = isDirty();
        $('#sstUnsaved').toggleClass('sst-hidden', !dirty);
        $('#sstSummaryFoot').toggleClass('sst-hidden', !dirty);
        $('#sstSave, #sstReset').prop('disabled', !dirty);
    }

    function renderMeta() {
        if (saved.changedAt) {
            $('#sstMetaText').html('Last changed by <b>' + esc(saved.changedBy || 'Unknown user') + '</b> · ' + esc(fmtDateTime(saved.changedAt)));
        } else {
            $('#sstMetaText').text('Not saved yet – the default values are used.');
        }
    }

    function messageFrom(xhr, fallback) {
        const json = xhr && xhr.responseJSON;
        if (json && json.errors) { const first = Object.values(json.errors)[0]; if (first && first[0]) return first[0]; }
        if (json && json.message && xhr.status !== 500) return json.message;
        if (xhr && xhr.status === 419) return 'Your session has expired. Please refresh the page.';
        if (xhr && xhr.status === 403) return 'You do not have permission to change these settings.';
        return fallback || 'Something went wrong. Please try again.';
    }

    /* =====================================================
       VALIDATION + SAVE
       ===================================================== */
    function setError(key, message) {
        $('[data-error="' + key + '"]').text(message);
        if (key === 'days') $('#sstStepper').addClass('has-error');
        else $('[data-picker="' + key + '"]').addClass('has-error');
    }
    function clearError(key) {
        $('[data-error="' + key + '"]').text('');
        if (key === 'days') $('#sstStepper').removeClass('has-error');
        else $('[data-picker="' + key + '"]').removeClass('has-error');
    }

    function validate() {
        let ok = true;
        ['project', 'section', 'shootUser', 'itemUser', 'days'].forEach(clearError);

        if (!findProject(form.project)) { setError('project', 'Please choose a project.'); ok = false; }
        const section = findSection(form.section);
        if (!section) { setError('section', sectionsOf(form.project).length ? 'Please choose a section.' : 'This project has no sections. Add one in Project Management or choose another project.'); ok = false; }
        else if (section.project_id !== form.project) { setError('section', 'This section is not part of the chosen project.'); ok = false; }
        if (!findUser(form.shootUser)) { setError('shootUser', 'Please choose a person.'); ok = false; }
        if (!findUser(form.itemUser)) { setError('itemUser', 'Please choose a person.'); ok = false; }
        if (!daysValid(form.days)) { setError('days', 'Enter a whole number from 0 to 30.'); ok = false; }
        return ok;
    }

    $('#sstForm').on('submit', function (e) {
        e.preventDefault();
        if (!validate()) {
            toast('Please fix the highlighted fields.', true);
            const $first = $('.has-error').first();
            if ($first.length) $first[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
        const payload = { _token: $('meta[name="csrf-token"]').attr('content') };
        Object.keys(FIELD_KEYS).forEach(k => { payload[FIELD_KEYS[k]] = form[k]; });

        const $btn = $('#sstSave').prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Saving…');
        $('#sstReset').prop('disabled', true);

        $.ajax({
            url: URLS.save,
            method: 'POST',
            data: payload,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': payload._token, 'Accept': 'application/json' },
        }).done(function (res) {
            const s = res.settings;
            saved = {
                project: s.pm_project_id, section: s.pm_section_id,
                shootUser: s.pm_shoot_assignee_id, itemUser: s.pm_item_assignee_id,
                days: s.item_due_days_before_shoot,
                changedBy: res.meta.by, changedAt: res.meta.at,
            };
            form = $.extend({}, saved);
            renderMeta();
            toast(res.message || 'Settings saved. New shoots will use them.');
        }).fail(function (xhr) {
            // Show the server's field errors under the right fields
            const errors = (xhr.responseJSON && xhr.responseJSON.errors) || {};
            Object.keys(FIELD_KEYS).forEach(k => { if (errors[FIELD_KEYS[k]]) setError(k, errors[FIELD_KEYS[k]][0]); });
            toast(messageFrom(xhr, 'Could not save the settings.'), true);
        }).always(function () {
            $btn.html('<i class="fa-solid fa-floppy-disk"></i> Save settings');
            refresh();
        });
    });

    $('#sstReset').on('click', function () {
        form = $.extend({}, saved);
        $('#sstDays').val(form.days);
        ['project', 'section', 'shootUser', 'itemUser', 'days'].forEach(clearError);
        Object.keys(PICKERS).forEach(renderPicker);
        refresh();
        toast('Changes discarded.');
    });

    // Warn before leaving with unsaved changes
    window.addEventListener('beforeunload', function (e) {
        if (isDirty()) { e.preventDefault(); e.returnValue = ''; }
    });

    /* =====================================================
       PAGE TITLE UNDER THE HEADER 
       ===================================================== */
    const phoneQuery = window.matchMedia('(max-width: 767.98px)');

    function fixTitleUnderHeader() {
        const title = document.querySelector('.sst-order-title');
        if (!title) return;

        // The nearest block-level parent of the title (margin does not work on inline elements)
        let block = title.parentElement;
        while (block && block !== document.body && getComputedStyle(block).display.indexOf('inline') === 0) {
            block = block.parentElement;
        }
        if (!block || block === document.body) return;

        block.style.marginTop = '';                  // reset first, then measure again
        if (!phoneQuery.matches) return;

        // Fixed / sticky header(s) at the very top of the screen
        let headerBottom = 0;
        document.elementsFromPoint(window.innerWidth / 2, 1).forEach(function (el) {
            if (el === document.documentElement || el === document.body || el.contains(title)) return;
            const pos = getComputedStyle(el).position;
            if (pos === 'fixed' || pos === 'sticky') {
                headerBottom = Math.max(headerBottom, el.getBoundingClientRect().bottom);
            }
        });
        if (!headerBottom) return;

        // Title position on the page (not the screen), so scrolling does not matter
        const titleTop = title.getBoundingClientRect().top + window.scrollY;
        const gap = 10;
        if (titleTop < headerBottom + gap) {
            const current = parseFloat(getComputedStyle(block).marginTop) || 0;
            block.style.marginTop = (current + headerBottom + gap - titleTop) + 'px';
        }
    }

    let titleTimer = null;
    fixTitleUnderHeader();
    $(window).on('load', fixTitleUnderHeader);     // after the logo / fonts load (header height can change)
    $(window).on('resize orientationchange', function () {
        clearTimeout(titleTimer);
        titleTimer = setTimeout(fixTitleUnderHeader, 100);
    });

    /* =====================================================
       START
       ===================================================== */
    Object.keys(PICKERS).forEach(renderPicker);
    $('#sstDays').val(form.days);
    renderMeta();
    refresh();
});
</script>
@endpush