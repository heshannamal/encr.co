@extends('layouts.app', ['activePage' => 'projects', 'titlePage' => __('Projects')])

@section('content')
<style>
    .project-index-header {
        padding: 12px 0 16px 0;
    }
    .project-index-filters .form-select, .project-index-filters .btn {
        border-radius: 24px;
        font-size: 0.8rem;
        min-width: 120px;
    }
    .project-index-searchbar input {
        border-radius: 24px;
        border: 1px solid #bbb;
        padding: 8px 24px;
        font-size: 0.8rem;
        width: 100%;
        background: #fafafa;
        max-width: 340px;
    }
    .project-index-table th, .project-index-table td {
        font-size: 0.8rem;
        vertical-align: middle;
    }
    .project-index-table th {
        background-color: rgba(50, 50, 50, 1) !important;
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border: none;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    .project-index-table tr {
        transition: background 0.15s;
    }
    .project-index-table tbody tr:hover {
        background: #f7f7f7;
    }
    .project-index-avatar-group {
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }
    .project-index-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #bbb;
        margin-left: -8px;
    }
    .project-index-avatar:first-child {
        margin-left: 0;
    }
    .project-index-projecticon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: #fff;
        margin-right: 12px;
    }
    .icon-bg-pink { background: #f7b6e6; }
    .icon-bg-orange { background: #ffb97a; }
    .icon-bg-purple { background: #a88cf7; }
    .project-index-view-toggle-btn {
        background-color: rgba(50, 50, 50, 1);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 0.8rem;
        cursor: pointer;
        margin-left: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
    }
    .project-index-view-toggle-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 110%;
        background-color: rgba(50, 50, 50, 1);
        color: #fff;
        border-radius: 12px;
        min-width: 140px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.13);
        z-index: 10;
        padding: 0.25rem 0;
    }
    .project-index-view-toggle.show .project-index-view-toggle-dropdown {
        display: block;
    }
    .project-index-view-toggle-dropdown button {
        background: none;
        border: none;
        color: #fff;
        width: 100%;
        text-align: left;
        padding: 10px 18px;
        font-size: 0.8rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .project-index-view-toggle-dropdown button:hover {
        background: #444;
    }
    .project-index-create-btn {
        background: #47D6B6;
        color: #fff;
        border: 5px solid #47D6B6;
        border-radius: 28px;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 2px 8px !important;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s, color 0.2s;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(255,183,77,0.08);
        padding-left: 6px;
    }
    .project-index-create-btn:hover {
        background: #3cc5a8;
        border-color: #3cc5a8;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(71, 214, 182, 0.35);
    }
    .project-index-create-btn .icon-circle {
        background: #fff4e0;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 4px;
    }
    /* Mobile Responsive Styles */
    @media (max-width: 767.98px) {
        .action-right .view-switch-group {
                display: none !important;
        }

        .content-position {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        .card.shadow-sm.border-0 {
            background: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }

        /* Top Filter / Search Card */
        .card-header.project-index-header {
            background: #ffffff !important;
            border-radius: 18px !important;
            border: 1px solid #edf2f7 !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
            padding: 12px !important;
            margin-top: 8%;
            margin-bottom: 16px !important;
            box-sizing: border-box !important;
            width: 100% !important;
            position: relative !important;
        }

        .card-header.project-index-header .row {
            display: flex !important;
            flex-wrap: wrap !important;
            flex-direction: row !important;
            gap: 8px !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        /* Search Bar (Row 1) */
         .card-header.project-index-header .col.d-flex.justify-content-center {
            order: 1 !important;
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .card-header.project-index-header .advance-search {
            width: 100% !important;
            max-width: 100% !important;
        }

        .card-header.project-index-header .advance-search .input-group-alternative {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: none !important;
            height: 38px !important;
            display: flex !important;
            align-items: center !important;
        }

        .card-header.project-index-header .advance-search .input-group-text {
            color: #64748b !important;
            border: none !important;
            padding-left: 12px !important;
            padding-right: 6px !important;
        }

        .card-header.project-index-header .advance-search input.form-control {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            font-size: 13px !important;
            color: #334155 !important;
            height: 100% !important;
            padding-left: 4px !important;
        }

        .card-header.project-index-header .advance-search input::placeholder {
            color: #94a3b8 !important;
        }

        /* Filters container */
        .project-index-filters {
            display: contents !important;
        }

        /* The 3 Select2 dropdowns (Row 2) */
        #owner_select + .select2-container,
        #assignee_select + .select2-container,
        #project_status_select + .select2-container {
            order: 2 !important;
            width: calc((100% - 16px) / 3) !important;
            flex: 0 0 calc((100% - 16px) / 3) !important;
            max-width: calc((100% - 16px) / 3) !important;
            min-width: 0 !important;
            margin: 0 !important;
            box-sizing: border-box !important;
        }

        .select2-container {
            margin-right: 0 !important;
        }

        .select2-container--default .select2-selection--single {
            height: 36px !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            position: relative !important;
            box-shadow: none !important;
            box-sizing: border-box !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px !important;
            padding-left: 8px !important;
            padding-right: 18px !important;
            font-size: 12px !important;
            color: #64748b !important;
            font-weight: 500 !important;
            text-align: left !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            width: 100% !important;
            display: block !important;
            box-sizing: border-box !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            width: 16px !important;
            position: absolute !important;
            top: 0 !important;
            right: 4px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #64748b transparent transparent transparent !important;
            border-style: solid !important;
            border-width: 4px 3.5px 0 3.5px !important;
            height: 0 !important;
            width: 0 !important;
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            margin-left: -3.5px !important;
            margin-top: -2px !important;
        }

        /* Row 3: Per-Page Select */
        .project-index-filters > .col-auto.d-flex.gap-2 {
            order: 3 !important;
            width: 60px !important;
            flex: 0 0 60px !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        #taskPerPageFilter {
            height: 36px !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            width: 100% !important;
            min-width: 0 !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #334155 !important;
            text-align-last: center !important;
            box-shadow: none !important;
            padding: 0 2px !important;
            box-sizing: border-box !important;
        }

        /* Row 3: Action Buttons (Create Project + View Switch) */
        .action-right {
            order: 4 !important;
            flex: 1 1 auto !important;
            min-width: 0 !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            padding: 0 !important;
            margin: 0 !important;
            box-sizing: border-box !important;
        }

        .project-index-create-btn {
            flex: 1 1 auto !important;
            min-width: 0 !important;
            height: 36px !important;
            border-radius: 12px !important;
            background: #47D6B6 !important;
            border: none !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 4px !important;
            padding: 0 6px !important;
            box-shadow: 0 2px 8px rgba(71, 214, 182, 0.25) !important;
            white-space: nowrap !important;
        }

        .project-index-create-btn i {
            font-size: 11px !important;
        }

        .view-switch-group {
            display: flex !important;
            gap: 4px !important;
            padding: 0 !important;
            margin: 0 !important;
            flex-shrink: 0 !important;
            background: transparent !important;
        }

        .view-switch-btn {
            width: 34px !important;
            height: 34px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #1e293b !important;
            padding: 0 !important;
        }

        .view-switch-btn.active,
        .view-switch-group:not(:has(.active)) #btnListView {
            background: #1e293b !important;
            border: 1px solid #1e293b !important;
            color: #ffffff !important;
        }

        .view-switch-btn.active i,
        .view-switch-group:not(:has(.active)) #btnListView i {
            color: #ffffff !important;
        }

        .view-switch-btn:not(.active) i {
            color: #1e293b !important;
        }

        /* Card body & list view */
        .card-body.pt-3 {
            padding: 0 !important;
        }

        .table-responsive {
            overflow-x: visible !important;
            border: none !important;
        }

        #projectsTable thead {
            display: none !important;
        }

        #projectsTable,
        #projectsTable tbody {
            display: block !important;
            width: 100% !important;
        }

        #projectsTable tbody tr {
            display: flex !important;
            flex-wrap: wrap !important;
            flex-direction: row !important;
            background: #ffffff !important;
            border: 1px solid #edf2f7 !important;
            border-radius: 18px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
            padding: 16px !important;
            margin-bottom: 16px !important;
            position: relative !important;
            transition: transform 0.2s, box-shadow 0.2s !important;
            overflow: hidden !important;
        }

        #projectsTable tbody tr:hover {
            background: #ffffff !important;
        }

        /* Cell 1: Name & Type */
        #projectsTable tbody tr td:nth-child(1) {
            width: 100% !important;
            padding: 0 !important;
            border: none !important;
            margin-bottom: 10px !important;
            order: 1 !important;
        }

        #projectsTable tbody tr td:nth-child(1) a {
            text-decoration: none !important;
            display: block !important;
            width: 100% !important;
        }

        #projectsTable tbody tr td:nth-child(1) .d-flex {
            align-items: flex-start !important;
            width: 100% !important;
            min-width: 0 !important;
        }

        #projectsTable tbody tr td:nth-child(1) .project-index-projecticon {
            width: 44px !important;
            height: 44px !important;
            min-width: 44px !important;
            flex-shrink: 0 !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 1.2rem !important;
            margin-right: 12px !important;
            margin-top: 2px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
        }

        #projectsTable tbody tr td:nth-child(1) .d-flex > div:last-child {
            flex: 1 1 auto !important;
            min-width: 0 !important;
            width: 100% !important;
            padding-right: 60px !important;
        }

        #projectsTable tbody tr td:nth-child(1) div[style*="font-weight: 600"] {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            line-height: 1.35 !important;
            margin-bottom: 2px !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            display: block !important;
        }

        #projectsTable tbody tr td:nth-child(1) div[style*="color: #4caf50"] {
            font-size: 12px !important;
            color: #64748b !important;
            font-weight: 400 !important;
            white-space: normal !important;
            word-break: break-word !important;
            margin-top: 2px !important;
        }

        /* Cell 2: Project # */
        #projectsTable tbody tr td:nth-child(2) {
            position: absolute !important;
            right: 16px !important;
            top: 18px !important;
            padding: 0 !important;
            border: none !important;
            font-size: 12px !important;
            color: #94a3b8 !important;
            font-weight: 400 !important;
            background: transparent !important;
            order: 2 !important;
        }

        /* Cell 3: Assignees */
        #projectsTable tbody tr td:nth-child(3) {
            width: 100% !important;
            padding: 0 !important;
            border: none !important;
            margin-bottom: 12px !important;
            order: 3 !important;
        }

        #projectsTable tbody tr td:nth-child(3) .project-index-avatar-group {
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 0 !important;
        }

        #projectsTable tbody tr td:nth-child(3) .project-index-avatar {
            width: 28px !important;
            height: 28px !important;
            border-radius: 50% !important;
            border: 2px solid #ffffff !important;
            margin-left: -6px !important;
            margin-right: 0 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12) !important;
            object-fit: cover !important;
        }

        #projectsTable tbody tr td:nth-child(3) .project-index-avatar:first-child {
            margin-left: 0 !important;
        }

        /* Cell 4: Status */
        #projectsTable tbody tr td:nth-child(4) {
            display: inline-flex !important;
            width: auto !important;
            padding: 0 !important;
            border: none !important;
            margin-right: 8px !important;
            order: 4 !important;
            align-items: center !important;
        }

        /* Cell 5: Stage */
        #projectsTable tbody tr td:nth-child(5) {
            display: inline-flex !important;
            width: auto !important;
            padding: 0 !important;
            border: none !important;
            order: 5 !important;
            align-items: center !important;
        }

        .status-pill {
            padding: 4px 12px !important;
            border-radius: 12px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
        }

        .status-new {
            background: #e8f8ec !important;
            color: #28a745 !important;
        }

        #projectsTable tbody tr td:nth-child(5) .status-pill {
            background: #e3f2fd !important;
            color: #1976d2 !important;
            font-weight: 500 !important;
        }

        /* #projectsTable tbody tr td:nth-child(5) .status-pill::after {
            content: "\f107" !important;
            font-family: "FontAwesome", "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
            margin-left: 5px !important;
            font-size: 11px !important;
        } */

        /* Cell 6: Action / Delete button */
        #projectsTable tbody tr td:nth-child(6) {
            order: 6 !important;
            margin-left: auto !important;
            padding: 0 !important;
            border: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
        }

        #projectsTable tbody tr td:nth-child(6) .trash_btn {
            color: #ef4444 !important;
            font-size: 14px !important;
        }

        #projectsTable tbody tr td:nth-child(6) .share_btn {
            color: #64748b !important;
            font-size: 14px !important;
            margin-right: 6px !important;
        }

        #projectsTable tbody tr td:nth-child(6) .delete-project,
        #projectsTable tbody tr td:nth-child(6) .share-project {
            padding: 4px !important;
            background: transparent !important;
            border: none !important;
        }

        /* Tile View on mobile */
        #tileView .card {
            border-radius: 18px !important;
            border: 1px solid #edf2f7 !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
            margin-bottom: 16px !important;
        }

        #tileView .title-action-buttons .trash_btn {
            color: #ef4444 !important;
        }

        /* Fix search results dropdown on mobile - anchor to search bar itself */
        /* .advance-search {
            position: relative !important;
        }

        .advance-search .dropdown-menu-custom {
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            right: 0 !important;
            transform: none !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 4px 0 0 0 !important;
            border-radius: 12px !important;
        }
        .advance-search .dropdown-menu-custom {
            height: 60vh !important;
            max-height: 60vh !important;
            min-height: 60vh !important;
            overflow: hidden !important;
        }

        .advance-search .dropdown-menu-custom .custom-tab-content,
        .advance-search .dropdown-menu-custom .custom-tab-pane.active {
            height: 100% !important;
            overflow-y: auto !important;
        }

        .advance-search .dropdown-menu-custom .custom-tabs {
            height: 100% !important;
        }

        .advance-search .dropdown-menu-custom .custom-tab-bar {
            height: 100% !important;
            overflow-y: auto !important;
        } */

        /* Pagination center on mobile */
        .pagination {
            justify-content: center !important;
            flex-wrap: wrap !important;
        }
    }
    .auto_width_select {
        width: auto;
        min-width: fit-content !important;
        border: 1px solid rgb(209, 209, 209);
        background-color: transparent;
        padding: 5px !important;
    }

    .project-index-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 3px;
    }
    .project-index-projecticon {
        font-size: 1.5rem;
        padding: 4px;
        border-radius: 50%;
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .icon-bg-pink { background-color: #ec407a; }
    .icon-bg-orange { background-color: #ffa726; }
    .icon-bg-purple { background-color: #ab47bc; }

    #viewToggle.show .project-index-view-toggle-dropdown {
        display: block;
    }
    .project-index-view-toggle-dropdown button {
        display: block;
        padding: 8px 12px;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .modal-content {
      background: #fff;
      padding: 20px;
      width: 70%;
      max-width: 95%;
      border-radius: 10px;
      position: relative;
    }

    #closeModal {
      position: absolute;
      top: 10px; right: 15px;
      font-size: 24px;
      cursor: pointer;
    }

    .step-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .step.active {
      background: #333;
      color: #fff;
    }

    .step-content {
      display: none;
    }

    .step-content.active {
      display: block;
    }

    .btn-group {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
    }

    .btn {
      padding: 8px 18px;
      background-color: transparent;
      color: gray;
      border: 1px solid rgb(196, 196, 196);
      border-radius: 4px;
      cursor: pointer;
    }

    .btn:hover {
      background: #d1d1d1;
    }

    .icon-circle {
      margin-right: 8px;
    }

    .step-header {
    display: flex;
    margin-bottom: 20px;
    overflow: hidden;
    border-radius: 4px;
    }

    .step {
    position: relative;
    flex: 1;
    padding: 12px 20px;
    text-align: center;
    background: linear-gradient(to right, #d0d0d0, #656565);
    font-weight: bold;
    color: #444;
    clip-path: polygon(0 0, 93% 0, 100% 50%, 93% 100%, 0 100%);
    transition: background 0.3s, color 0.3s;
    z-index: 1;
    }

    .step:not(:last-child) {
    margin-right: -12px;
    z-index: 3;
    left: -30px;
    }

    .step.active {
    /* background-color: #333; */
    background: linear-gradient(to right, #464646, #1c1c1c);
    color: #fff;
    }

    .step:first-child {
    clip-path: polygon(0 0, 93% 0, 100% 50%, 93% 100%, 0 100%);
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
    z-index: 3;
    left: -10px;
    }

    .step:last-child {
    clip-path: polygon(0 2, 100% 0, 100% 100%, 0 100%, 7% 50%);
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
    left: -40px;
    z-index: 2;
    }
    .step-1 {
        padding: 15px 25px;
        border: 1px solid #d5d5d5;
        border-radius: 5px;
        box-shadow: 3px 3px 4px 0 #00000026;
    }
    .radio-row {
    display: flex;
    gap: 30px; /* spacing between options */
    flex-wrap: wrap; /* allow wrap on small screens */
    margin-top: 20px;
    }

    .radio-row label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    white-space: nowrap;
    }
    input[type="radio"] {
    accent-color: #2dd655;
    }
    .padding_top_bottom_10 {
        padding: 10px 0px;
    }
    .font_14_gray {
        font-size: 14px;
        color: gray;
    }
    .select2-container {
        border: 1px solid rgb(195, 195, 195) !important;
        border-radius: 20px !important;
        margin-right: 10px;
    }
    .select2-container--default .select2-selection--single {
        background-color: transparent !important;
    }
    .container-fluid  {
        font-family: Arial, sans-serif;
    }
    .header-layout {
        margin-bottom: 1.5rem !important;
    }
    .content-position {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
    .trash_btn {
        color: rgb(255, 136, 136);
        cursor: pointer;
    }
    .share_btn {
        color: #5e72e4;
        cursor: pointer;
    }
    .delete-project, .share-project {
        padding: 5px 8px;
        border: none;
    }
    .title-action-buttons {
        position: absolute;
        right: 5px;
        top: 6px;
        display: flex;
        gap: 2px;
        align-items: center;
    }
    @media ((min-width: 768px)) {
        .content-position {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
    }
    /* .dropdown-menu {
        left: 50%;
    } */

    /* new css add  */

    .custom-breadcrumb {
        background: none !important;
        font-family: Roboto Condensed !important;

        font-size: 12px;
    }

    .custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: ">" !important;
        color: #999999;
    }

    .custom-breadcrumb .breadcrumb-item a {
        color: #000;
        font-weight: 600;
        text-decoration: none;
    }

    .custom-breadcrumb .breadcrumb-item.active {
        color: #B3B3B3;
    }

    #owner_select .select2-container {
        width: 130px;
    }


    .view-switch-btn {
        background: none;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        padding: 4px 0;
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #888;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        position: relative;
        transition: color 0.2s ease;
    }


    .view-switch-btn:focus {
        outline: none !important;
        box-shadow: none !important;
        border: none !important;
    }
    .view-switch-btn.active {
        color: #000;
    }

    .view-switch-btn.active::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -3px;
        width: 100%;
        height: 2px;
        background: #000;
        border: none;

    }

    /* .tooltip-inner {
        background-color: #555 !important;
        padding: 6px 10px;
        font-size: 13px;
    } */

    .status-pill {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }
    .status-new { background:#e6f2ff; color:#1e66d6; }
    .status-completed { background:#e9f9ea; color:#2f9e3a; }
    .status-cancel { background:#ffeaea; color:#d23b3b; }


    .dropdown-menu.dropdown-menu-custom.mt-3.show {
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.05), 0 70px 140px rgba(0, 0, 0, 0.3), 0 30px 60px rgba(0, 0, 0, 0.22);
    }

    .advance-search {
        width: 100%;
        max-width: 420px;
    }


    .action-right {
        padding-right: 24px;
         gap: 14px;
    }

    .project-index-create-btn {
        padding: 6px 8px;
        border-radius: 30px;
    }


    .view-switch-group {
        display: flex;
        gap: 6px;
        padding: 6px;
        border-radius: 10px;
    }


    .view-switch-btn {
        width: 34px;
        height: 34px;
        border-radius: 6px;
        border: none;
        background: transparent;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .view-switch-btn i {
        font-size: 18px;
        color: #333;
    }

    .view-switch-btn:hover {
        background: #e6e6e6;
    }

    #owner_select + .select2-container {
        width: 110px !important;
    }

    #assignee_select + .select2-container {
        width: 106px !important;
    }

    #project_status_select + .select2-container {
        width: 95px !important;
    }

    .dropdown-menu-custom {
        /* left: 45% !important; */
        transform: translateX(-54%) !important;
        width: 230% !important;
        max-height: 60vh;
        border-radius: 0rem;
    }
    .bg-box.container-fluid.fix-nav.header-layout{
        margin-bottom: .5rem !important;
    }
    .select2-container .select2-selection--single {
        height: 24px !important;
    }
    .select2-selection__rendered {
        line-height: 24px !important;
    }

    .pagination.pagina001 .page-item.active .page-link {
        background: #5e72e4 !important;
        border-color: #5e72e4 !important;
        color: #fff !important;
        font-weight: 600;
    }

    .pagination.pagina001 .page-link {
        border-radius: 50%;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        display: block;
        padding-left: 17px;
        padding-right: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

#taskPerPageFilter option {
    text-align: center;
}



</style>
<div class="container-fluid mb-5 content-position" style="padding-left: 20px !important; padding-right: 20px !important;">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>PROJECTS</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color">BACK TO HOME</a>
    @endsection

    {{-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item" style=" font-family: Roboto Condensed !important;">
                <a href="{{ route('projects.home') }}">Project Management</a>
            </li>
            <li class="breadcrumb-item active" style=" font-family: Roboto Condensed !important;">
                Project
            </li>
        </ol>
    </nav> --}}

    <div class="card shadow-sm border-0">

        <div class="card-header project-index-header bg-white border-0 pb-0">
            <div class="row w-100 g-2 align-items-center" style="margin: unset;">
                <div class="col-auto d-flex flex-wrap gap-2 project-index-filters">
                     <div class="col-auto d-flex gap-2">
                        <select class="form-select form-select-sm" id="taskPerPageFilter" style="min-width: 65px; width: 65px; text-align-last: center;">
                            <option value="10" {{ request('per_page',10)==10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page')==20 ? 'selected' : '' }}>20</option>
                            <option value="40" {{ request('per_page')==40 ? 'selected' : '' }}>40</option>
                            <option value="60" {{ request('per_page')==60 ? 'selected' : '' }}>60</option>
                            <option value="100" {{ request('per_page')==100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                   
                    <select class="form-select mb-2 mb-md-0 mr-2 p-2 auto_width_select" id="owner_select">
                        <option value="">Created by</option>
                        <option value="{{ auth()->user()->id }}" {{ auth()->user()->id == request()->get('owner') ? 'selected' : '' }}>Me</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == request()->get('owner') ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select mb-2 mb-md-0 mr-2 p-2 auto_width_select" id="assignee_select">
                        <option value="">Assignee</option>
                        <option value="{{ auth()->user()->id }}" {{ auth()->user()->id == request()->get('assignee') ? 'selected' : '' }}>Me</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == request()->get('assignee') ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select mb-2 mb-md-0 p-2 auto_width_select" id="project_status_select">
                        <option value="">Status</option>
                        @foreach ($projectStatus as $projectStat)
                            <option value="{{ $projectStat->id }}" {{ $projectStat->id == request()->get('status') ? 'selected' : '' }}>
                                {{ $projectStat->status_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

               

                <!-- CENTER SEARCH (true center) -->
                <div class="col d-flex justify-content-center">
                    @include('pages.project.partials.project_master_search')
                </div>
                <div class="col-auto d-flex align-items-center gap-3 action-right">
                @can('create project')
                    <button id="openModalBtn" class="project-index-create-btn">
                        <i class="fa fa-plus"></i>
                        CREATE PROJECT
                    </button>
                @endcan

                <div class="view-switch-group">
                    <button class="view-switch-btn" title="List view"  id="btnListView">
                        <i class="fa fa-list"></i>
                    </button>
                    <button class="view-switch-btn" title="Grid view" id="btnTileView">
                        <i class="fa fa-th-large"></i>
                    </button>
                </div>
            </div>



            </div>
        </div>
        <div class="card-body pt-3">

            <!-- LIST VIEW -->
            <div id="listView" class="table-responsive">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table project-index-table align-middle mb-0" id="projectsTable">
                            <thead>
                                <tr>
                                    <th style="width: 35%;">NAME & TYPE</th>
                                    <th style="width: 10%;">PROJECT #</th>
                                    <th style="width: 20%;">ASSIGNEES</th>
                                    <th style="width: 10%;">STATUS</th>
                                    <th style="width: 15%;">STAGE</th>
                                    <th style="width: 10%;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr class="project-{{ $project->id }}">
                                        <td>
                                            <a href="{{ route('projects.view.temp', $project->id) }}" style="text-decoration: none;">
                                                <div class="d-flex align-items-center">
                                                    <span class="project-index-projecticon me-2" style="background-color: {{ $project->project_color ?? '#b5b5b5' }}">
                                                        @if ($project->project_icon_url)
                                                            <img src="{{ $project->project_icon_url }}" alt="Project Icon" style="width: 100%; height: 100%; object-fit: contain;">
                                                        @else
                                                            <i class="fa fa-server" style="color:#fff; font-size: smaller;"></i>
                                                        @endif
                                                    </span>
                                                    <div>
                                                        <div style="font-weight: 600;">{{ $project->new_display_name }}</div>
                                                        <div style="font-size: 0.8rem; color: #4caf50;">{{ $project->projectType->type_name ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td>{{ $project->project_no }}</td>
                                        <td>
                                            <div class="project-index-avatar-group">
                                                @foreach (explode(',', $project->project_assignee) as $assignee)
                                                    <img src="{{ asset($helper->getUserImage($assignee)) }}" class="project-index-avatar">
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            @if ($project->project_type_id == 2)
                                                <span class="status-pill status-new">New</span>
                                            @else
                                                <span class="status-pill status-{{ strtolower($project->projectStatus->status_name ?? '') }}">
                                                    {{ $project->projectStatus->status_name ?? '' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($project->stage_status)
                                                @php
                                                    $stage_bg = '#f5f5f5';
                                                    $stage_color = '#616161';
                                                    switch($project->stage_status) {
                                                        case 'Discussion': $stage_bg = '#e3f2fd'; $stage_color = '#1976d2'; break;
                                                        case 'UI/UX Design': $stage_bg = '#f3e5f5'; $stage_color = '#7b1fa2'; break;
                                                        case 'Development': $stage_bg = '#fff3e0'; $stage_color = '#f57c00'; break;
                                                        case 'Testing': $stage_bg = '#e8f5e9'; $stage_color = '#388e3c'; break;
                                                        case 'Live': $stage_bg = '#ffebee'; $stage_color = '#d32f2f'; break;
                                                    }
                                                @endphp
                                                <span class="status-pill" style="background:{{$stage_bg}}; color:{{$stage_color}};">
                                                    {{ $project->stage_status }}
                                                </span>
                                            @else
                                                <span style="color:#ccc;">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">

                                            @can('share project')
                                                <button type="button" class="btn btn-sm share-project" style="background: none;" data-id="{{ $project->id }}" data-assignees="{{ $project->project_assignee }}" data-toggle="tooltip" data-placement="bottom" title="Share this project"><i class="fa fa-share-alt share_btn"></i></button>
                                            @endcan
                                            @can('delete-project', $project)

                                                <button type="button" class="btn btn-sm delete-project" style="background: none;"  data-id="{{ $project->id }}" data-toggle="tooltip" data-placement="bottom" title="Delete this project"><i class="fa fas fa-trash trash_btn"></i> </button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TILE VIEW -->
            <div id="tileView" class="d-none">
                <div class="row">
                    @foreach ($projects as $project)
                        <div class="col-md-4 mb-4 project-{{ $project->id }}">
                            <a href="{{ route('projects.view.temp', $project->id) }}">
                                <div class="card shadow-sm">
                                    <div class="card-body d-flex">
                                        <span class="project-index-projecticon me-3" style="background-color: {{ $project->project_color ?? '#b5b5b5' }}">
                                            @if ($project->project_icon_url)
                                                <img src="{{ $project->project_icon_url }}" alt="Project Icon" style="width: 100%; height: 100%; object-fit: contain;">
                                            @else
                                                <i class="fa fa-server" style="color:#fff; font-size: smaller;"></i>
                                            @endif
                                        </span>
                                        <div>
                                            <h5 class="mb-1">{{ $project->new_display_name }} - {{ $project->project_no }}</h5>
                                            <p class="mb-1 text-success" style="font-size: 0.8rem;">{{ $project->projectType->type_name ?? '' }}</p>
                                        </div>

                                        <div class="title-action-buttons">
                                            @can('share project')
                                                <button type="button" class="btn btn-sm share-project" style="background: none;" data-id="{{ $project->id }}" data-assignees="{{ $project->project_assignee }}" data-toggle="tooltip" data-placement="bottom" title="Share this project"><i class="fa fa-share-alt share_btn"></i></button>
                                            @endcan
                                             @can('delete-project', $project)
                                                <button type="button" class="btn btn-sm delete-project title-delete-btn" style="background: none;"  data-id="{{ $project->id }}" data-toggle="tooltip" data-placement="bottom" title="Delete this project"><i class="fa fas fa-trash trash_btn"></i> </button>
                                
         
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-2 ">
                    <div style="float: right " >
                        {{ $projects->onEachSide(5)->withQueryString()->links('layouts.paginationlinks') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('pages.project.partials.add_project')

@include('pages.project.partials.share_project_modal')



<script>
    $('#taskPerPageFilter').change(function () {
        searchProject();
    });

    $(document).ready(function () {

        if ($.fn.DataTable.isDataTable('#projectsTable')) {
            $('#projectsTable').DataTable().destroy();
        }

        $('#projectsTable').DataTable({
            paging: false,
            searching: false,
            info: false,
            lengthChange: false,
            ordering: true,
            autoWidth: false,

            columnDefs: [
                {
                    // Name & Type
                    targets: 0,
                    render: function (data, type) {

                        if (type === 'sort') {
                            var tmp = document.createElement('div');
                            tmp.innerHTML = data;

                            return $(tmp)
                                .find('div[style*="font-weight: 600"]')
                                .text()
                                .trim()
                                .toLowerCase();
                        }

                        return data;
                    }
                },
                {
                    // Project Number
                    targets: 1,
                    type: 'num'
                },
                {
                    // Assignees
                    targets: 2,
                    orderable: false
                },
                {
                    // Status
                    targets: 3,
                    render: function (data, type) {

                        if (type === 'sort') {
                            return $('<div>')
                                .html(data)
                                .text()
                                .trim()
                                .toLowerCase();
                        }

                        return data;
                    }
                },
                {
                    // Stage
                    targets: 4,
                    render: function (data, type) {

                        if (type === 'sort') {
                            return $('<div>')
                                .html(data)
                                .text()
                                .trim()
                                .toLowerCase();
                        }

                        return data;
                    }
                },
                {
                    // Action
                    targets: 5,
                    orderable: false
                }
            ]
        });

    });
    
    document.addEventListener('DOMContentLoaded', () => {

        const listView = document.getElementById('listView');
        const tileView = document.getElementById('tileView');

        const btnList = document.getElementById('btnListView');
        const btnTile = document.getElementById('btnTileView');

        btnList.addEventListener('click', () => {
            listView.classList.remove('d-none');
            tileView.classList.add('d-none');

            btnList.classList.add('active');
            btnTile.classList.remove('active');
        });

        btnTile.addEventListener('click', () => {
            listView.classList.add('d-none');
            tileView.classList.remove('d-none');

            btnTile.classList.add('active');
            btnList.classList.remove('active');
        });

    });



    $(document).ready(function(){
        function getUrlParameter(param, url = window.location.href) {
            const params = new URL(url).searchParams;
            return params.get(param);
        }

        // Owner Select Functions
        $('#owner_select').select2({
            placeholder: 'Created by',
            allowClear: true,
            width: 'style',
            dropdownAutoWidth: false,
             minimumResultsForSearch: Infinity,

        });

        var ownerParam = getUrlParameter('owner');
        if (ownerParam) {
            $('#owner_select').val(ownerParam).trigger('change');
        }

        $('#owner_select').change(function(){
            searchProject();
        });

        // Assignee Select Functions
        $('#assignee_select').select2({
            placeholder: 'Assignee',
            allowClear: true,
            width: 'style',
            dropdownAutoWidth: false,
            minimumResultsForSearch: Infinity
        });

        var assigneeParam = getUrlParameter('assignee');
        if (assigneeParam) {
            $('#assignee_select').val(assigneeParam).trigger('change');
        }

        $('#assignee_select').change(function(){
            searchProject();
        });

        // Status Select Functions
        $('#project_status_select').select2({
            placeholder: 'Status',
            allowClear: true,
            width: 'style',
            dropdownAutoWidth: false,
            minimumResultsForSearch: Infinity
        });

        var statusParam = getUrlParameter('status');
        if (statusParam) {
            $('#project_status_select').val(statusParam).trigger('change');
        }

        $('#project_status_select').change(function(){
            searchProject();
        });

        // Text Search Functions
        $('#sr_text').focusout(function(){
            var srText = $('#sr_text').val();
            var existsrText = $('#sr_text').attr('data-sr');
            if(srText != existsrText){
                searchProject();
            }
        });

    });

    $('body').on('click', '.delete-project', function(){
        var projectId = $(this).data('id');
        Swal.fire({
            title: "Confirm Delete?",
            text: "Do You Want to Delete This Project?",
            type: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            closeOnConfirm: false,
            closeOnCancel: true

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: '{{ url("projects/delete/new/") }}/'+projectId,
                    method: 'GET',
                    success: function(data) {
                        deleteProject(projectId);
                    },
                    error: function(xhr, status, error) {
                        swal({
                            title: "Error!",
                            text: error,
                            type: "warning",
                            buttons: true,
                            dangerMode: true,
                            confirmButtonColor: '#5fb644',
                        });
                    }
                });
            }
        });
    });

    function deleteProject(projectId)
    {
        $('.project-'+projectId).fadeOut(300, function() { $(this).remove(); });
    }

/*
    function searchProject()
    {
        var srText = $('#sr_text').val();
        var ownerSelect = $('#owner_select').val();
        var assigneeSelect = $('#assignee_select').val();
        var projectStatusSelect = $('#project_status_select').val();
        var url = window.location.pathname;
        window.location.href = url + '?owner='+ownerSelect+'&assignee='+assigneeSelect+'&status='+projectStatusSelect+'&sr=' + encodeURIComponent(srText);
    }

*/

    function searchProject() {
        var srText = $('#sr_text').val() || '';
        var ownerSelect = $('#owner_select').val();
        var assigneeSelect = $('#assignee_select').val();
        var projectStatusSelect = $('#project_status_select').val();
        var perPage = $('#taskPerPageFilter').val();

        let params = new URLSearchParams();

        if (ownerSelect) params.append('owner', ownerSelect);
        if (assigneeSelect) params.append('assignee', assigneeSelect);
        if (projectStatusSelect) params.append('status', projectStatusSelect);
        if (srText.trim() !== '') params.append('sr', srText);

        params.append('per_page', perPage);

        window.location.href = window.location.pathname + '?' + params.toString();
    }

    $(document).ready(function () {
        let currentPage = new URLSearchParams(window.location.search).get('page') || 1;

        $('.pagination.pagina001 .page-link').each(function () {
            if ($(this).text().trim() == currentPage) {
                $(this).closest('.page-item').addClass('active');
            }
        });
    });


</script>

@endsection
