@extends('layouts.app', ['activePage' => 'pdt_tool', 'titlePage' => __('PDT')])

@section('content')

<style>
    .pdt-table-wrap {
        width: 100%;
    }

    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }

    #pdtTable {
        width: 100% !important;
    }

    #pdtTable th,
    #pdtTable td {
        white-space: nowrap;
        vertical-align: middle;
    }

    .pdt-path {
        max-width: 160px;
        display: inline-block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        vertical-align: middle;
    }

    .dataTables_wrapper {
        width: 100%;
    }

    .select2-container {
        width: 100% !important;
    }

    .parts-table th,
    .parts-table td {
        vertical-align: middle;
        white-space: nowrap;
    }

    .parts-table .form-control {
        min-width: 130px;
    }

    .parts-table .mesh-input {
        min-width: 260px;
    }


    .case-sensitive-option {
        font-family: Consolas, Monaco, monospace;
        font-size: 12px;
        white-space: pre;
    }

    .parts-case-note {
        color: #b45309;
        font-weight: 600;
    }

    /* MOBILE VIEW (max-width: 768px) */
    @media (max-width: 768px) {

        /* ---- Top buttons ---- */
        .card-body > .d-flex.justify-content-end {
            flex-direction: column;
            gap: 12px !important;
        }
        .pdt-action-btn {
            width: 100%;
            text-align: center;
            padding: 14px;
            border-radius: 12px;
            font-size: 15px;
        }
        /* Login button (second) */
        .card-body > .d-flex a.pdt-action-btn {
            order: 2;
            font-weight: 600;
            font-size: 13px !important;
            height: 44px;
        }
        /* Add product button (first, teal) */
        .card-body > .d-flex button.pdt-action-btn {
            order: 1;
            background: #14b8a6;
            border-color: #14b8a6;
            color: #fff;
            font-weight: 600;
            font-size: 13px !important;
            height: 44px;
        }
        .card-body > .d-flex button.pdt-action-btn i { color: #fff; }

        /* ---- DataTables: length / search / info / pagination ---- */
        .dataTables_length { display: none !important; }

        .dataTables_filter {
            position: relative;
            width: 100%;
            text-align: left !important;
            margin: 12px 0;
        }
        .dataTables_filter label {
            display: block;
            width: 100%;
            font-size: 0;            /* hides "Search:" text */
            margin: 0;
        }
        /* Custom placeholder text */
        .dataTables_filter::before {
            content: "Search products...";
            position: absolute;
            left: 46px;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa3ad;
            font-size: 14px;
            pointer-events: none;
        }
        /* Hide custom placeholder when user types */
        .dataTables_filter:has(input:not(:placeholder-shown))::before { display: none; }

        /* Search input with icon */
        .dataTables_filter input {
            width: 100% !important;
            margin: 0 !important;
            height: 50px;
            padding: 0 16px;
            padding-left: 46px !important;
            font-size: 15px;
            border: 1px solid #e3e7ec;
            border-radius: 14px;
            background: #fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='11' cy='11' r='8'/><line x1='21' y1='21' x2='16.65' y2='16.65'/></svg>") 16px center no-repeat !important;
        }
        /* Hide DataTables' own placeholder */
        .dataTables_filter input::placeholder { color: transparent; }

        .dataTables_info { padding: 0 0 10px !important; font-size: 14px; color: #6b7480; }
        .dataTables_paginate { text-align: center !important; }

        /* ---- Un-table the products table ---- */
        .dataTables_scrollHead { display: none !important; }
        .dataTables_scroll,
        .dataTables_scrollBody,
        .dt-scroll,
        .dt-scroll-body {
            overflow: visible !important;
            height: auto !important;
            max-height: none !important;
            width: 100% !important;
        }
        #pdtTable,
        #pdtTable tbody {
            display: block;
            width: 100% !important;
            margin: 0 !important;
            border: 0 !important;
            background: transparent;
        }
        #pdtTable thead { display: none !important; }
        .content-position .card { background-color: transparent; }

        /* ---- Product card (collapsed layout) ---- */
        #pdtTable tbody tr {
            display: grid;
            grid-template-columns: 1fr auto auto;
            grid-template-areas:
                "name    name    action"
                "pid     pid     pid"
                "created status  chev";
            column-gap: 12px;
            row-gap: 6px;
            background: #fff !important;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 14px;
            box-shadow: 0 2px 10px rgba(20, 30, 50, 0.07);
            cursor: pointer;
        }
        /* Expanded layout: adds DXF / Model / Parts rows */
        #pdtTable tbody tr.is-open {
            grid-template-areas:
                "name    name    action"
                "pid     pid     pid"
                "created status  chev"
                "dxf     dxf     dxf"
                "model   model   model"
                "parts   parts   parts";
        }
        #pdtTable tbody td {
            display: block;
            border: 0 !important;
            padding: 0 !important;
            white-space: normal !important;
            background: transparent !important;
            min-width: 0;
        }

        /* ---- Card fields ---- */
        /* Name */
        #pdtTable tbody td:nth-child(3) {
            grid-area: name;
            font-size: 14px;
            font-weight: 700;
            color: #1F2933;
            line-height: 1.3;
        }
        /* Edit button */
        #pdtTable tbody td:nth-child(8) {
            grid-area: action;
            align-self: start;
            justify-self: end;
        }
        #pdtTable .editBtn {
            background: #fff;
            color: #6B7280;
            border: 1px solid #d5dbe2;
            border-radius: 20px;
            font-size: 12px;
            box-shadow: none;
        }
        /* Product ID */
        #pdtTable tbody td:nth-child(2) {
            grid-area: pid;
            font-size: 12px;
            font-weight: 700;
            color: #4b5563;
        }
        #pdtTable tbody td:nth-child(2)::before {
            content: "Product ID: ";
            font-family: Consolas, Monaco, monospace;
            font-size: 12px;
            font-weight: 400;
            color: #757575;
        }
        /* Created */
        #pdtTable tbody td:nth-child(7) {
            grid-area: created;
            align-self: center;
            margin-top: 8px;
            font-family: Consolas, Monaco, monospace;
            font-size: 12px;
            color: #4b5563;
        }
        #pdtTable tbody td:nth-child(7)::before {
            content: "Created: ";
            font-size: 12px !important;
            color: #757575;
        }
        /* Status badge */
        #pdtTable tbody td:nth-child(1) {
            grid-area: status;
            align-self: center;
            justify-self: end;
            margin-top: 8px;
        }
        #pdtTable tbody td:nth-child(1) .badge {
            font-size: 11px;
            padding: 8px 8px;
            border-radius: 20px;
            margin-right: -26px;
        }

        /* ---- Card details (DXF / Model / Parts) ---- */
        #pdtTable tbody td:nth-child(4) { grid-area: dxf; }
        #pdtTable tbody td:nth-child(5) { grid-area: model; }
        #pdtTable tbody td:nth-child(6) { grid-area: parts; }

        #pdtTable tbody td:nth-child(4),
        #pdtTable tbody td:nth-child(5),
        #pdtTable tbody td:nth-child(6) {
            margin-top: 6px !important;
        }
        /* Small grey labels above each box */
        #pdtTable tbody td:nth-child(4)::before,
        #pdtTable tbody td:nth-child(5)::before,
        #pdtTable tbody td:nth-child(6)::before {
            display: block;
            font-size: 12px;
            color: #6B7280;
            margin-bottom: 6px;
        }
        #pdtTable tbody td:nth-child(4)::before { content: "Dxf path"; }
        #pdtTable tbody td:nth-child(5)::before { content: "Model path"; }
        #pdtTable tbody td:nth-child(6)::before { content: "Parts"; }

        /* Path boxes */
        #pdtTable .pdt-path {
            display: block;
            max-width: 100%;
            padding: 11px 11px;
            border: 1px solid #dde2e8;
            border-radius: 14px;
            font-size: 12px;
            color: #1F2933;
            background: #fff;
        }
        /* Copy button at the end of DXF + Model path boxes */
        #pdtTable tbody td:nth-child(4) .pdt-path,
        #pdtTable tbody td:nth-child(5) .pdt-path {
            position: relative;
            padding-right: 64px;
            min-height: 48px;
            line-height: 26px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        #pdtTable tbody td:nth-child(4) .pdt-path::after,
        #pdtTable tbody td:nth-child(5) .pdt-path::after {
            content: "";
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #f1f3f5 url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23555' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><rect x='9' y='9' width='13' height='13' rx='2'/><path d='M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1'/></svg>") center no-repeat;
        }

        /* ---- Expand / collapse ---- */
        /* Arrow */
        #pdtTable tbody tr::after {
            content: "";
            grid-area: chev;
            align-self: center;
            justify-self: end;
            width: 8px;
            height: 8px;
            margin: 8px 8px 0 0;
            border-right: 2px solid #111827;
            border-bottom: 2px solid #111827;
            transform: translateY(-3px) rotate(45deg);
            transition: transform 0.2s ease;
        }
        #pdtTable tbody tr.is-open::after {
            transform: translateY(3px) rotate(-135deg);
            margin-top: 8px;
        }
        /* Hide details until opened */
        #pdtTable tbody tr:not(.is-open) td:nth-child(4),
        #pdtTable tbody tr:not(.is-open) td:nth-child(5),
        #pdtTable tbody tr:not(.is-open) td:nth-child(6) {
            display: none;
        }
        /* Divider line when open */
        #pdtTable tbody tr.is-open td:nth-child(4) {
            border-top: 1px solid #e5e9ee !important;
            padding-top: 14px !important;
            margin-top: 10px !important;
        }

        /* ADD MODAL (#addPdtModal) */
        /* ---- Shell: shrinks to content, with height cap ---- */
        #addPdtModal .modal-dialog {
            height: auto !important;
            min-height: 0 !important;
            margin: 12px !important;
            margin-top: 35% !important;
            display: flex;
            align-items: center;
        }
        #addPdtModal .modal-content {
            height: auto !important;
            max-height: calc(100vh - 24px) !important;
            border: 0;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(20, 30, 50, 0.18);
        }

        /* ---- Header ---- */
        #addPdtModal .modal-header {
            padding: 14px 18px;
            border-bottom: 1px solid #eef1f4;
            align-items: center;
        }
        #addPdtModal .modal-title {
            font-size: 17px;
            font-weight: 700;
            color: #111827;
        }

        /* ---- Body + labels ---- */
        #addPdtModal .modal-body { padding: 14px 18px 4px; }
        #addPdtModal .form-group { margin-bottom: 12px; }
        #addPdtModal .form-group > label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7480;
            margin-bottom: 5px;
            margin-left: 5px;
        }

        /* ---- Inputs and select ---- */
        #addPdtModal .form-control,
        #addPdtModal .select2-container--default .select2-selection--single {
            height: 44px;
            border: 1px solid #e3e7ec;
            border-radius: 12px;
            background: #fafbfc;
            font-size: 14px;
        }
        #addPdtModal .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px;
            padding-left: 14px;
            color: #111827;
        }
        #addPdtModal .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px;
        }

        /* ---- File inputs ---- */
        #addPdtModal input[type="file"].form-control {
            padding: 6px 10px;
            line-height: 30px;
            font-size: 13px;
            color: #6b7480;
        }
        #addPdtModal input[type="file"]::file-selector-button {
            height: 30px;
            margin-right: 10px;
            padding: 0 12px;
            border: 0;
            border-radius: 8px;
            background: #e8ecf0;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        /* ---- Scan status message ---- */
        #addPdtModal .file-scan-status {
            margin: 0 0 8px;
            padding: 10px 12px;
            border: 0;
            border-radius: 12px;
            font-size: 12px;
            line-height: 1.45;
            background: #e8f6fb;
            color: #0b5f77;
        }
        #addPdtModal .file-scan-status.alert-success { background: #e6f7ee; color: #166534; }
        #addPdtModal .file-scan-status.alert-danger  { background: #fdecec; color: #991b1b; }

        /* ---- Parts section ---- */
        #addPdtModal .parts-table,
        #addPdtModal .table-responsive {
            overflow: visible;
        }

        /* ---- Footer: Cancel left, Add right ---- */
        #addPdtModal .modal-footer {
            display: flex;
            flex-wrap: nowrap;
            gap: 10px;
            padding: 10px 18px 16px;
            border-top: 0;
        }
        #addPdtModal .modal-footer .btn {
            flex: 1;
            margin: 0;
            height: 44px;
            padding: 0;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
        }
        #addPdtModal .modal-footer .btn-secondary {
            order: 1;
            background: #9ca3af;
            border-color: #9ca3af;
            color: #fff;
        }
        #addPdtModal .modal-footer .btn-success {
            order: 2;
            background: #16a34a;
            border-color: #16a34a;
        }


        /* EDIT MODAL (#editPdtModal) */
        /* ---- Shell: 16px side space, rounded ---- */
        #editPdtModal .modal-dialog {
            margin: 12px 16px !important;
            max-width: calc(100% - 32px) !important;
            width: calc(100% - 32px) !important;
            height: calc(100vh - 24px) !important;
        }
        #editPdtModal .modal-content {
            width: 100%;
            border: 0;
            border-radius: 24px;
        }

        /* ---- Header ---- */
        #editPdtModal .modal-header {
            padding: 18px 20px;
            border-bottom: 1px solid #e5e9ee;
        }
        #editPdtModal .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        /* ---- Body + labels ---- */
        #editPdtModal .modal-body { padding: 16px 18px; }
        #editPdtModal .form-group > label {
            font-size: 13px;
            font-weight: 600;
            color: #6b7480;
            margin-bottom: 6px;
        }

        /* ---- Inputs and select ---- */
        #editPdtModal .form-control,
        #editPdtModal .select2-container--default .select2-selection--single {
            height: 48px;
            border: 1px solid #e3e7ec;
            border-radius: 14px;
            background: #fafbfc;
            font-size: 15px;
            color: #111827;
        }
        #editPdtModal .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 46px;
            padding-left: 14px;
            color: #111827;
        }
        #editPdtModal .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }

        /* ---- File inputs ---- */
        #editPdtModal input[type="file"].form-control {
            padding: 6px 10px;
            line-height: 30px;
            font-size: 13px;
            color: #6b7480;
        }
        #editPdtModal input[type="file"]::file-selector-button {
            height: 30px;
            margin-right: 10px;
            padding: 0 12px;
            border: 0;
            border-radius: 8px;
            background: #e8ecf0;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        /* ---- Parts table turned into cards ---- */
        #editPdtModal .table-responsive { overflow: visible; }
        #editLayoutPartsTable,
        #editLayoutPartsTable tbody {
            display: block;
            width: 100% !important;
            border: 0 !important;
            background: transparent;
        }
        /* Header replaced by per-field labels */
        #editLayoutPartsTable thead { display: none; }

        /* One row = one card */
        #editLayoutPartsTable tbody tr {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-areas:
                "order  order"
                "key    label"
                "mesh   flip"
                "mirror delete";
            gap: 10px 12px;
            margin-bottom: 14px;
            padding: 14px;
            background: #fff;
            border: 1px solid #e3e7ec;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(20, 30, 50, 0.06);
        }
        #editLayoutPartsTable tbody td {
            display: block;
            min-width: 0;
            padding: 0 !important;
            border: 0 !important;
            background: transparent !important;
            white-space: normal;
        }

        /* Field labels */
        #editLayoutPartsTable tbody td:nth-child(2)::before,
        #editLayoutPartsTable tbody td:nth-child(3)::before,
        #editLayoutPartsTable tbody td:nth-child(4)::before,
        #editLayoutPartsTable tbody td:nth-child(5)::before {
            display: block;
            margin-bottom: 5px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #6b7480;
        }
        #editLayoutPartsTable tbody td:nth-child(2)::before { content: "Part Key"; }
        #editLayoutPartsTable tbody td:nth-child(3)::before { content: "Part Label"; }
        #editLayoutPartsTable tbody td:nth-child(4)::before { content: "3D Mesh Names"; }
        #editLayoutPartsTable tbody td:nth-child(5)::before { content: "Flip To"; }

        /* Cancel desktop min-widths so fields fit half-width columns */
        #editLayoutPartsTable .form-control,
        #editLayoutPartsTable .parts-select,
        #editLayoutPartsTable .mesh-select,
        #editLayoutPartsTable .select2-container,
        #editLayoutPartsTable .mesh-select + .select2-container {
            min-width: 0 !important;
            width: 100% !important;
        }

        /* Grid placement */
        #editLayoutPartsTable tbody td:nth-child(1) { grid-area: order; }
        #editLayoutPartsTable tbody td:nth-child(2) { grid-area: key; }
        #editLayoutPartsTable tbody td:nth-child(3) { grid-area: label; }
        #editLayoutPartsTable tbody td:nth-child(4) { grid-area: mesh; }
        #editLayoutPartsTable tbody td:nth-child(5) { grid-area: flip; }
        #editLayoutPartsTable tbody td:nth-child(6) { grid-area: mirror; align-self: center; text-align: left !important; }
        #editLayoutPartsTable tbody td:nth-child(7) { grid-area: delete; justify-self: end; }

        /* Order: small number box + "ORDER" text */
        #editLayoutPartsTable tbody td:nth-child(1) {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        #editLayoutPartsTable tbody td:nth-child(1) .form-control {
            width: 48px !important;
            height: 40px;
            padding: 0;
            text-align: center;
            font-weight: 700;
            border-radius: 10px;
            background: #fff;
        }
        #editLayoutPartsTable tbody td:nth-child(1)::after {
            content: "ORDER";
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        /* Mirror checkbox */
        #editLayoutPartsTable tbody td:nth-child(6) label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
            font-weight: 600;
            color: #111827;
        }
        #editLayoutPartsTable tbody td:nth-child(6) input[type="checkbox"] {
            width: 22px;
            height: 22px;
            margin: 0;
        }

        /* Delete button: soft red square */
        #editLayoutPartsTable .remove-edit-layout-part {
            width: 40px;
            height: 36px;
            padding: 0;
            background: #fee2e2;
            border: 0;
            border-radius: 10px;
            color: #dc2626;
        }

        /* ---- Add Part button ---- */
        #editAddLayoutPartBtn {
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
        }

        /* ---- Footer: Cancel left, Update right ---- */
        #editPdtModal .modal-footer {
            display: flex;
            flex-wrap: nowrap;
            gap: 12px;
            padding: 14px 18px 18px;
            border-top: 0;
        }
        #editPdtModal .modal-footer .btn {
            flex: 1;
            margin: 0;
            padding: 14px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
        }
        #editPdtModal .modal-footer .btn-secondary { order: 1; background: #9ca3af; border-color: #9ca3af; color: #fff; }
        #editPdtModal .modal-footer .btn-success   { order: 2; background: #16a34a; border-color: #16a34a; }
    }

    .product-used-option {
        color: #28a745 !important;
        font-weight: 700;
    }

    .product-used-option::after {
        content: "  ✓ Already added";
        font-size: 11px;
    }

    .file-scan-status {
        border-radius: 8px;
        font-size: 13px;
    }

    .parts-select {
        min-width: 180px;
    }

    .mesh-select {
        min-width: 280px;
    }

    .parts-table .select2-container {
        min-width: 180px;
    }

    .parts-table .mesh-select + .select2-container {
        min-width: 280px;
    }

    #addRelevantPartsSection {
        display: none;
    }

    #addRelevantPartsSection.is-ready {
        display: block;
    }

    /* Keep the header/footer fixed and scroll only the modal body. */
    #addPdtModal .modal-dialog,
    #editPdtModal .modal-dialog {
        height: calc(100vh - 30px);
        margin: 15px auto;
    }

    #addPdtModal .modal-content,
    #editPdtModal .modal-content {
        max-height: 100%;
        overflow: hidden;
    }

    #addPdtModal .modal-body,
    #editPdtModal .modal-body {
        min-height: 0;
        overflow-y: auto !important;
        overflow-x: hidden;
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
    }
     .pdt-action-btn {
        background: #ffffff;
        border: 1px solid #cfd6df;
        border-radius: 5px;
        color: #5f6975;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.4px;
        padding: 9px 14px;
        text-transform: uppercase;
        line-height: 1.2;
        box-shadow: none;
        transition: all 0.2s ease;
    }

    .pdt-action-btn i {
        margin-right: 6px;
        font-size: 12px;
        color: #68727d;
    }

    .pdt-action-btn:hover,
    .pdt-action-btn:focus {
        background: #f7f8fa;
        border-color: #aeb7c2;
        color: #3f4852;
        text-decoration: none;
        box-shadow: none;
    }

</style>

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>PDT Dashboard</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="card" style="border: unset;">
        <div class="card-body">

            <div class="d-flex justify-content-end mb-3" style="gap: 10px;">

                <a href="https://dev.encr.co/admin/login"
                target="_blank"
                class="btn pdt-action-btn">
                    <i class="fa fa-sign-in"></i>
                    LOGIN TO PDT
                </a>

                <button type="button"
                        class="btn pdt-action-btn"
                        data-toggle="modal"
                        data-target="#addPdtModal">
                    <i class="fa fa-plus"></i>
                    ADD PRODUCT
                </button>

            </div>

            <div class="pdt-table-wrap">
                <table id="pdtTable" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>DXF Path</th>
                            <th>Model Path</th>
                            <th>Parts</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($pdtProducts as $item)
                            @php
                                $layoutParts = is_array($item->layout_parts)
                                    ? $item->layout_parts
                                    : (json_decode($item->layout_parts ?? '[]', true) ?: []);

                                $partLabels = collect($layoutParts)
                                    ->sortBy(function ($part) {
                                        return $part['order'] ?? 999;
                                    })
                                    ->map(function ($part) {
                                        return $part['label'] ?? $part['key'] ?? '';
                                    })
                                    ->filter()
                                    ->values();
                            @endphp

                            <tr>
                                <td>
                                    @if($item->active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>

                                <td>{{ $item->product_id }}</td>

                                <td>{{ $item->product->product_name ?? '-' }}</td>

                                <td>
                                    <span class="pdt-path" title="{{ $item->dxf_path }}">
                                        {{ $item->dxf_path ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="pdt-path" title="{{ $item->modal_path }}">
                                        {{ $item->modal_path ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="pdt-path" title="{{ $partLabels->implode(', ') }}">
                                        {{ $partLabels->count() ? $partLabels->implode(', ') : '-' }}
                                    </span>
                                </td>

                                <td>{{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-' }}</td>

                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary editBtn"
                                        data-toggle="modal"
                                        data-target="#editPdtModal"
                                        data-id="{{ $item->id }}"
                                        data-product="{{ $item->product_id }}"
                                        data-model="{{ $item->modal_path }}"
                                        data-dxf="{{ $item->dxf_path }}"
                                        data-active="{{ $item->active }}"
                                        data-layout-parts='@json($layoutParts)'
                                    >
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- Edit PDT Modal --}}
<div class="modal fade" id="editPdtModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <form action="{{ route('pdt.update') }}" method="POST" enctype="multipart/form-data" class="modal-content" id="editproductForm">
            @csrf

            <input type="hidden" name="id" id="edit_id">

            <div class="modal-header">
                <h5 class="modal-title">Edit PDT Product</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>Product</label>
                    <select name="product_id" id="edit_product_id" class="form-control select2-edit" required>
                        @foreach($products as $product)
                            @php
                                $isUsed = in_array((int) $product->id, $usedProductIds ?? [], true);
                                $productName = $product->product_name ?: $product->show_in_catalog_name;
                            @endphp
                            <option
                                value="{{ $product->id }}"
                                data-used="{{ $isUsed ? 1 : 0 }}"
                            >
                                {{ $productName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Replace 3D Model (Optional)</label>
                    <input type="file" name="modal_path" id="edit_modal_path" class="form-control" accept=".glb,.gltf">
                </div>

                <div class="form-group">
                    <label>Replace DXF (Optional)</label>
                    <input type="file" name="dxf_path" id="edit_dxf_path" class="form-control" accept=".dxf">
                </div>
                <div id="editFileScanStatus" class="alert alert-info file-scan-status d-none"></div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="active" id="edit_active" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="form-group mt-4">
                    <label class="form-control-label">Product Relevant Parts</label>

                    <input type="hidden" name="layout_parts" id="editLayoutPartsInput">

                    <div class="table-responsive">
                        <table class="table table-bordered parts-table" id="editLayoutPartsTable">
                            <thead>
                                <tr>
                                    <th style="width:80px;">Order</th>
                                    <th>Part Key</th>
                                    <th>Part Label</th>
                                    <th>3D Mesh Names</th>
                                    <th>Flip To</th>
                                    <th style="width:90px;">Mirror</th>
                                    <th style="width:70px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-sm btn-primary" id="editAddLayoutPartBtn">
                        <i class="fas fa-plus"></i> Add Part
                    </button>

                    <small class="text-muted d-block mt-2">
                        Choose one DXF Part Key, one GLB Mesh Name, and an optional DXF Flip To target for each row.
                    </small>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Update
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>

        </form>
    </div>
</div>

{{-- Add PDT Modal --}}
<div class="modal fade" id="addPdtModal" tabindex="-1" role="dialog" aria-labelledby="addPdtModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <form action="{{ route('pdt.store') }}" method="POST" enctype="multipart/form-data" class="modal-content" id="addproductForm">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="addPdtModalLabel">Add PDT Product</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>Select Product</label>
                    <select name="product_id" id="product_id" class="form-control select2" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            @php
                                $isUsed = in_array((int) $product->id, $usedProductIds ?? [], true);
                                $productName = $product->product_name ?: $product->show_in_catalog_name;
                            @endphp
                            <option
                                value="{{ $product->id }}"
                                data-used="{{ $isUsed ? 1 : 0 }}"
                                {{ $isUsed ? 'disabled' : '' }}
                            >
                                {{ $productName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>3D Model File</label>
                    <input type="file" name="modal_path" id="add_modal_path" class="form-control" accept=".glb,.gltf" required>
                </div>

                <div class="form-group">
                    <label>DXF File</label>
                    <input type="file" name="dxf_path" id="add_dxf_path" class="form-control" accept=".dxf" required>
                </div>
                <div id="addFileScanStatus" class="alert alert-info file-scan-status d-none">
                    Select the GLB and DXF files. Exact case-sensitive keys and mesh names will be loaded as Select2 options; no mapping is selected automatically.
                </div>

                <div class="form-group mt-4" id="addRelevantPartsSection">
                    <label class="form-control-label">Product Relevant Parts</label>

                    <input type="hidden" name="layout_parts" id="layoutPartsInput">

                    <div class="table-responsive">
                        <table class="table table-bordered parts-table" id="layoutPartsTable">
                            <thead>
                                <tr>
                                    <th style="width:80px;">Order</th>
                                    <th>Part Key</th>
                                    <th>Part Label</th>
                                    <th>3D Mesh Names</th>
                                    <th>Flip To</th>
                                    <th style="width:90px;">Mirror</th>
                                    <th style="width:70px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-sm btn-primary" id="addLayoutPartBtn">
                        <i class="fas fa-plus"></i> Add Part
                    </button>

                    <small class="text-muted d-block mt-2">
                        Click Add Part, then manually select one DXF Part Key and one GLB Mesh Name for each row.
                    </small>
                </div>

            </div>

            <div class="modal-footer">
                <button id="addproductbtn" type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Add
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>

        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/dxf-parser@1.1.2/dist/dxf-parser.js"></script>

<script type="importmap">
{
    "imports": {
        "three": "https://cdn.jsdelivr.net/npm/three@0.165.0/build/three.module.js",
        "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.165.0/examples/jsm/"
    }
}
</script>

<script type="module">
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

const $ = window.jQuery;
const gltfLoader = new GLTFLoader();
const DxfParserClass = window.DxfParser?.default || window.DxfParser;

$(function () {
    const inspectorState = {
        add: {
            dxfParts: [],
            meshNames: [],
        },
        edit: {
            dxfParts: [],
            meshNames: [],
        },
    };

    const modalFor = (prefix) => prefix === 'add' ? $('#addPdtModal') : $('#editPdtModal');
    const bodyFor = (prefix) => prefix === 'add' ? $('#layoutPartsTable tbody') : $('#editLayoutPartsTable tbody');
    const hiddenFor = (prefix) => prefix === 'add' ? $('#layoutPartsInput') : $('#editLayoutPartsInput');

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function unique(values) {
        return [...new Set(
            (values || [])
                .map(value => String(value || '').trim())
                .filter(Boolean)
        )];
    }

    function humanize(value) {
        return String(value || '')
            .replace(/[_-]+/g, ' ')
            .replace(/\s+/g, ' ')
            .trim()
            .replace(/\b\w/g, letter => letter.toUpperCase());
    }


    function assetUrl(path) {
        if (!path) {
            return '';
        }

        if (/^https?:\/\//i.test(path)) {
            return path;
        }

        return `${window.location.origin}/${String(path).replace(/^\/+/, '')}`;
    }

    function showScanStatus(prefix, message, type = 'info') {
        const $status = prefix === 'add'
            ? $('#addFileScanStatus')
            : $('#editFileScanStatus');

        $status
            .removeClass('d-none alert-info alert-success alert-warning alert-danger')
            .addClass(`alert-${type}`)
            .html(message);
    }

    function formatProductOption(option) {
        if (!option.id) {
            return option.text;
        }

        const isUsed = Number($(option.element).data('used')) === 1;

        return $('<span>')
            .toggleClass('product-used-option', isUsed)
            .text(option.text);
    }

    function initProductSelects() {
        $('.select2').select2({
            dropdownParent: $('#addPdtModal'),
            width: '100%',
            placeholder: 'Select Product',
            allowClear: true,
            templateResult: formatProductOption,
        });

        $('.select2-edit').select2({
            dropdownParent: $('#editPdtModal'),
            width: '100%',
            placeholder: 'Select Product',
            templateResult: formatProductOption,
        });
    }

    function collectDxfParts(dxf) {
        const parts = new Set();

        const addEntityLayers = (entities) => {
            (entities || []).forEach(entity => {
                const layer = String(entity?.layer || '').trim();

                if (
                    layer &&
                    layer !== '0' &&
                    layer.toLowerCase() !== 'defpoints'
                ) {
                    parts.add(layer);
                }
            });
        };

        addEntityLayers(dxf?.entities);

        Object.values(dxf?.blocks || {}).forEach(block => {
            addEntityLayers(block?.entities);
        });

        Object.keys(dxf?.tables?.layer?.layers || {}).forEach(layer => {
            const cleanLayer = String(layer || '').trim();

            if (
                cleanLayer &&
                cleanLayer !== '0' &&
                cleanLayer.toLowerCase() !== 'defpoints'
            ) {
                parts.add(cleanLayer);
            }
        });

        return [...parts].sort((a, b) => a.localeCompare(b, undefined, {
            numeric: true,
            sensitivity: 'base',
        }));
    }

    async function inspectDxf(source) {
        if (!DxfParserClass) {
            throw new Error('DXF parser did not load.');
        }

        let text;

        if (source instanceof File) {
            text = await source.text();
        } else {
            const response = await fetch(assetUrl(source));

            if (!response.ok) {
                throw new Error(`DXF request failed (${response.status}).`);
            }

            text = await response.text();
        }

        const parser = new DxfParserClass();
        const dxf = parser.parseSync(text);
        const parts = collectDxfParts(dxf);

        if (!parts.length) {
            throw new Error('No usable DXF layer names were found.');
        }

        return parts;
    }

    async function inspectGlb(source) {
        let payload;
        let basePath = '';
        let sourceName = '';

        if (source instanceof File) {
            sourceName = source.name;
            payload = source.name.toLowerCase().endsWith('.gltf')
                ? await source.text()
                : await source.arrayBuffer();
        } else {
            const url = assetUrl(source);
            sourceName = url;
            basePath = url.substring(0, url.lastIndexOf('/') + 1);

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`GLB request failed (${response.status}).`);
            }

            payload = url.toLowerCase().endsWith('.gltf')
                ? await response.text()
                : await response.arrayBuffer();
        }

        return await new Promise((resolve, reject) => {
            gltfLoader.parse(
                payload,
                basePath,
                gltf => {
                    const meshNames = new Set();
                    let unnamedIndex = 1;

                    gltf.scene.traverse(object => {
                        if (!object?.isMesh) {
                            return;
                        }

                        const meshName = String(object.name || '').trim()
                            || `Part_${unnamedIndex++}`;

                        meshNames.add(meshName);
                    });

                    if (!meshNames.size) {
                        reject(new Error(`No mesh names were found in ${sourceName || 'the model'}.`));
                        return;
                    }

                    resolve([...meshNames].sort((a, b) => a.localeCompare(b, undefined, {
                        numeric: true,
                        sensitivity: 'base',
                    })));
                },
                reject
            );
        });
    }


    function optionHtml(values, selectedValues = [], includeBlank = false) {
        const selected = new Set(
            (Array.isArray(selectedValues) ? selectedValues : [selectedValues])
                .map(value => String(value || ''))
        );

        let html = includeBlank ? '<option value=""></option>' : '';

        unique(values).forEach(value => {
            html += `<option value="${escapeHtml(value)}" ${selected.has(value) ? 'selected' : ''}>${escapeHtml(value)}</option>`;
        });

        return html;
    }

    function formatExactOption(option) {
        if (!option.id) {
            return option.text;
        }

        return $('<span>')
            .addClass('case-sensitive-option')
            .attr('title', 'Exact case-sensitive value')
            .text(option.id);
    }

    function initRowSelect2($row, prefix) {
        const $modal = modalFor(prefix);
        const exactSelect2 = {
            dropdownParent: $modal,
            width: '100%',
            allowClear: true,
            tags: false,
            templateResult: formatExactOption,
            templateSelection: formatExactOption,
        };

        $row.find(`.${prefix}-part-key`).select2({
            ...exactSelect2,
            placeholder: 'Select exact DXF key',
        });

        $row.find(`.${prefix}-part-meshes`).select2({
            ...exactSelect2,
            placeholder: 'Select exact GLB mesh name',
        });

        $row.find(`.${prefix}-part-flip-to`).select2({
            ...exactSelect2,
            placeholder: 'No flip target',
        });
    }

    function addPartRow(prefix, data = {}) {
        const state = inspectorState[prefix];
        const $tableBody = bodyFor(prefix);
        const rowCount = $tableBody.find('tr').length + 1;

        const order = Number(data.order || rowCount);
        const key = String(data.key || '');
        const label = String(data.label || '');
        const mesh = Array.isArray(data.meshes)
            ? String(data.meshes[0] || '')
            : String(data.meshes || '');
        const flipTo = String(data.flip_to || data.flipTo || '');
        const flipMirror = [true, 1, '1', 'true'].includes(data.flip_mirror);

        const dxfOptions = unique([
            ...state.dxfParts,
            key,
            flipTo,
        ]);

        const meshOptions = unique([
            ...state.meshNames,
            mesh,
        ]);

        const row = `
            <tr>
                <td>
                    <input
                        type="number"
                        class="form-control ${prefix}-part-order"
                        value="${escapeHtml(order)}"
                        min="1"
                    >
                </td>

                <td>
                    <select class="form-control parts-select ${prefix}-part-key">
                        ${optionHtml(dxfOptions, key, true)}
                    </select>
                </td>

                <td>
                    <input
                        type="text"
                        class="form-control ${prefix}-part-label"
                        placeholder="Part Label"
                        value="${escapeHtml(label || key)}"
                        data-auto-label="${label && label !== key ? '0' : '1'}"
                    >
                </td>

                <td>
                    <select class="form-control mesh-select ${prefix}-part-meshes">
                        ${optionHtml(meshOptions, mesh, true)}
                    </select>
                </td>

                <td>
                    <select class="form-control parts-select ${prefix}-part-flip-to">
                        ${optionHtml(dxfOptions.filter(item => item !== key), flipTo, true)}
                    </select>
                </td>

                <td class="text-center">
                    <label class="mb-0">
                        <input
                            type="checkbox"
                            class="${prefix}-part-flip-mirror"
                            ${flipMirror ? 'checked' : ''}
                        >
                        Mirror
                    </label>
                </td>

                <td>
                    <button
                        type="button"
                        class="btn btn-sm btn-danger remove-${prefix}-layout-part"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        $tableBody.append(row);

        const $row = $tableBody.find('tr').last();
        initRowSelect2($row, prefix);

        $row.find(`.${prefix}-part-key`).on('change', function () {
            const selectedKey = String($(this).val() || '');
            const $label = $row.find(`.${prefix}-part-label`);

            if (!$label.val() || Number($label.data('auto-label')) === 1) {
                $label
                    .val(selectedKey)
                    .data('auto-label', 1);
            }

            // Do not auto-select a GLB mesh. The user must choose it manually.
            refreshFlipOptions(prefix);
        });

        $row.find(`.${prefix}-part-label`).on('input', function () {
            $(this).data('auto-label', 0);
        });
    }

    function destroySelect2($select) {
        if ($select.hasClass('select2-hidden-accessible')) {
            $select.select2('destroy');
        }
    }

    function refreshFlipOptions(prefix) {
        const state = inspectorState[prefix];
        const selectedKeys = unique(
            bodyFor(prefix)
                .find(`.${prefix}-part-key`)
                .map(function () {
                    return $(this).val();
                })
                .get()
        );

        const options = unique([...state.dxfParts, ...selectedKeys]);

        bodyFor(prefix).find('tr').each(function () {
            const $row = $(this);
            const key = String($row.find(`.${prefix}-part-key`).val() || '');
            const $flip = $row.find(`.${prefix}-part-flip-to`);
            const current = String($flip.val() || '');

            destroySelect2($flip);

            $flip.html(optionHtml(
                options.filter(option => option !== key),
                current,
                true
            ));

            $flip.select2({
                dropdownParent: modalFor(prefix),
                width: '100%',
                placeholder: 'No flip target',
                allowClear: true,
                tags: false,
                templateResult: formatExactOption,
                templateSelection: formatExactOption,
            });
        });
    }

    function reOrderRows(prefix) {
        bodyFor(prefix).find('tr').each(function (index) {
            $(this).find(`.${prefix}-part-order`).val(index + 1);
        });
    }

    function readRows(prefix) {
        const parts = [];

        bodyFor(prefix).find('tr').each(function (index) {
            const $row = $(this);

            const selectedMesh = String(
                $row.find(`.${prefix}-part-meshes`).val() || ''
            );

            parts.push({
                key: String($row.find(`.${prefix}-part-key`).val() || ''),
                label: String($row.find(`.${prefix}-part-label`).val() || ''),
                order: Number($row.find(`.${prefix}-part-order`).val() || index + 1),
                // Keep the database format compatible, but allow only one selected mesh.
                meshes: selectedMesh ? [selectedMesh] : [],
                flip_to: String($row.find(`.${prefix}-part-flip-to`).val() || ''),
                flip_mirror: $row.find(`.${prefix}-part-flip-mirror`).is(':checked'),
            });
        });

        return parts;
    }

    function renderRows(prefix, parts) {
        const $body = bodyFor(prefix);

        $body.find('select.select2-hidden-accessible').each(function () {
            destroySelect2($(this));
        });

        $body.empty();

        (parts || []).forEach(part => addPartRow(prefix, part));

        refreshFlipOptions(prefix);
    }


    function buildLayoutPartsJson(prefix) {
        const parts = readRows(prefix);
        const keys = new Set();
        const exactDxfKeys = new Set(inspectorState[prefix].dxfParts);
        const exactMeshNames = new Set(inspectorState[prefix].meshNames);

        if (!parts.length) {
            alert('Add at least one product part.');
            return false;
        }

        for (const part of parts) {
            if (!part.key) {
                alert('Select an exact DXF Part Key for every row.');
                return false;
            }

            if (!exactDxfKeys.has(part.key)) {
                alert(
                    `Part Key "${part.key}" does not exactly match a DXF key. ` +
                    'Part Keys are case-sensitive. Select the value from the DXF list.'
                );
                return false;
            }

            if (keys.has(part.key)) {
                alert(`Part Key "${part.key}" is selected more than once.`);
                return false;
            }

            const meshName = part.meshes[0] || '';

            if (!meshName) {
                alert(`Select one exact GLB mesh name for "${part.key}".`);
                return false;
            }

            if (!exactMeshNames.has(meshName)) {
                alert(
                    `Mesh Name "${meshName}" does not exactly match a GLB mesh. ` +
                    'Mesh Names are case-sensitive. Select the value from the GLB list.'
                );
                return false;
            }

            if (part.flip_to) {
                if (part.flip_to === part.key) {
                    alert(`"${part.key}" cannot flip to itself.`);
                    return false;
                }

                if (!exactDxfKeys.has(part.flip_to)) {
                    alert(
                        `Flip To "${part.flip_to}" does not exactly match a DXF key. ` +
                        'Flip targets are case-sensitive.'
                    );
                    return false;
                }
            }

            keys.add(part.key);
        }

        hiddenFor(prefix).val(JSON.stringify(parts));

        return true;
    }

    function updateAddReadyState() {
        const ready = (
            inspectorState.add.dxfParts.length > 0 &&
            inspectorState.add.meshNames.length > 0
        );

        $('#addproductbtn').prop('disabled', !ready);

        if (!ready) {
            return;
        }


        $('#addRelevantPartsSection')
            .addClass('is-ready');

        showScanStatus(
            'add',
            `<strong>Files detected successfully.</strong>
             ${inspectorState.add.dxfParts.length} DXF parts and
             ${inspectorState.add.meshNames.length} GLB meshes are ready.
             Click Add Part and choose the exact case-sensitive DXF key and GLB mesh name manually.`,
            'success'
        );

        window.setTimeout(() => {
            document.getElementById('addRelevantPartsSection')
                ?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 180);
    }

    $('#add_dxf_path').on('change', async function () {
        const file = this.files?.[0];

        if (!file) {
            inspectorState.add.dxfParts = [];
            return;
        }

        showScanStatus('add', 'Reading DXF part layers…', 'info');

        try {
            inspectorState.add.dxfParts = await inspectDxf(file);
            updateAddReadyState();
        } catch (error) {
            inspectorState.add.dxfParts = [];
            $('#addproductbtn').prop('disabled', true);
            showScanStatus('add', escapeHtml(error.message), 'danger');
        }
    });

    $('#add_modal_path').on('change', async function () {
        const file = this.files?.[0];

        if (!file) {
            inspectorState.add.meshNames = [];
            return;
        }

        showScanStatus('add', 'Reading GLB mesh names…', 'info');

        try {
            inspectorState.add.meshNames = await inspectGlb(file);
            updateAddReadyState();
        } catch (error) {
            inspectorState.add.meshNames = [];
            $('#addproductbtn').prop('disabled', true);
            showScanStatus('add', escapeHtml(error.message), 'danger');
        }
    });

    $('#edit_dxf_path').on('change', async function () {
        const file = this.files?.[0];

        if (!file) {
            return;
        }

        const existingParts = readRows('edit');
        showScanStatus('edit', 'Reading replacement DXF…', 'info');

        try {
            inspectorState.edit.dxfParts = await inspectDxf(file);
            renderRows('edit', existingParts);
            showScanStatus(
                'edit',
                `${inspectorState.edit.dxfParts.length} DXF parts detected.`,
                'success'
            );
        } catch (error) {
            showScanStatus('edit', escapeHtml(error.message), 'danger');
        }
    });

    $('#edit_modal_path').on('change', async function () {
        const file = this.files?.[0];

        if (!file) {
            return;
        }

        const existingParts = readRows('edit');
        showScanStatus('edit', 'Reading replacement GLB…', 'info');

        try {
            inspectorState.edit.meshNames = await inspectGlb(file);
            renderRows('edit', existingParts);
            showScanStatus(
                'edit',
                `${inspectorState.edit.meshNames.length} GLB meshes detected.`,
                'success'
            );
        } catch (error) {
            showScanStatus('edit', escapeHtml(error.message), 'danger');
        }
    });

    $('#addLayoutPartBtn').on('click', function () {
        addPartRow('add');
        refreshFlipOptions('add');
    });

    $('#editAddLayoutPartBtn').on('click', function () {
        addPartRow('edit');
        refreshFlipOptions('edit');
    });

    $(document).on('click', '.remove-add-layout-part', function () {
        const $row = $(this).closest('tr');

        $row.find('select.select2-hidden-accessible').each(function () {
            destroySelect2($(this));
        });

        $row.remove();
        reOrderRows('add');
        refreshFlipOptions('add');
    });

    $(document).on('click', '.remove-edit-layout-part', function () {
        const $row = $(this).closest('tr');

        $row.find('select.select2-hidden-accessible').each(function () {
            destroySelect2($(this));
        });

        $row.remove();
        reOrderRows('edit');
        refreshFlipOptions('edit');
    });

    $('#addPdtModal').on('shown.bs.modal', function () {
        $('#addproductbtn').prop('disabled', true);
        showScanStatus(
            'add',
            'Select the GLB and DXF files. Exact case-sensitive keys and mesh names will be loaded as Select2 options; no mapping is selected automatically.',
            'info'
        );
    });

    $('#addPdtModal').on('hidden.bs.modal', function () {
        $('#addproductForm')[0].reset();
        $('#product_id').val('').trigger('change');
        $('#addRelevantPartsSection').removeClass('is-ready');
        bodyFor('add').empty();
        hiddenFor('add').val('');
        inspectorState.add.dxfParts = [];
        inspectorState.add.meshNames = [];
        $('#addproductbtn').prop('disabled', true);
    });

    $('#addproductForm').on('submit', function (event) {
        if (!buildLayoutPartsJson('add')) {
            event.preventDefault();
            return;
        }

        $('.se-pre-con').fadeIn('slow');
    });

    $('#editproductForm').on('submit', function (event) {
        if (!buildLayoutPartsJson('edit')) {
            event.preventDefault();
            return;
        }

        $('.se-pre-con').fadeIn('slow');
    });

    $(document).on('click', '.editBtn', async function () {
        const $button = $(this);
        const currentProductId = String($button.data('product'));
        let layoutParts = $button.attr('data-layout-parts') || '[]';

        $('#edit_id').val($button.data('id'));
        $('#edit_active').val($button.data('active'));

        $('#edit_product_id option').each(function () {
            const isUsed = Number($(this).data('used')) === 1;
            const isCurrent = String(this.value) === currentProductId;

            $(this).prop('disabled', isUsed && !isCurrent);
        });

        $('#edit_product_id')
            .val(currentProductId)
            .trigger('change.select2');

        try {
            layoutParts = JSON.parse(layoutParts);
        } catch (error) {
            console.error('Invalid layout parts JSON:', error);
            layoutParts = [];
        }

        if (!Array.isArray(layoutParts)) {
            layoutParts = [];
        }

        inspectorState.edit.dxfParts = unique([
            ...layoutParts.map(part => part.key),
            ...layoutParts.map(part => part.flip_to),
        ]);

        inspectorState.edit.meshNames = unique(
            layoutParts.flatMap(part => Array.isArray(part.meshes) ? part.meshes : [])
        );

        renderRows(
            'edit',
            layoutParts.sort((a, b) => Number(a.order || 0) - Number(b.order || 0))
        );

        showScanStatus('edit', 'Reading current DXF and GLB files…', 'info');

        const dxfPath = $button.data('dxf');
        const modelPath = $button.data('model');

        const results = await Promise.allSettled([
            dxfPath ? inspectDxf(dxfPath) : Promise.resolve([]),
            modelPath ? inspectGlb(modelPath) : Promise.resolve([]),
        ]);

        const currentParts = readRows('edit');

        if (results[0].status === 'fulfilled') {
            inspectorState.edit.dxfParts = unique([
                ...results[0].value,
                ...inspectorState.edit.dxfParts,
            ]);
        }

        if (results[1].status === 'fulfilled') {
            inspectorState.edit.meshNames = unique([
                ...results[1].value,
                ...inspectorState.edit.meshNames,
            ]);
        }

        renderRows('edit', currentParts);

        const dxfCount = inspectorState.edit.dxfParts.length;
        const meshCount = inspectorState.edit.meshNames.length;

        showScanStatus(
            'edit',
            `${dxfCount} exact DXF keys and ${meshCount} exact GLB mesh names are available.`,
            dxfCount && meshCount ? 'success' : 'warning'
        );
    });

    $('#pdtTable').DataTable({
        pageLength: 25,
        responsive: false,
        scrollX: true,
        autoWidth: false,
        order: [[6, 'desc']],
        columnDefs: [
            {
                targets: [7],
                orderable: false,
            },
        ],
    });

    initProductSelects();

    // The CSS that hides and shows the details sits inside the mobile media query,
    $('#pdtTable tbody').on('click', 'tr', function (e) {
        if ($(e.target).closest('.editBtn').length) return; // Edit button keeps working
        $(this).toggleClass('is-open');
    });

    $('#pdtTable tbody').on('click', 'td:nth-child(4) .pdt-path, td:nth-child(5) .pdt-path', function (e) {
    if (window.innerWidth > 768) return;

    // only react to taps on the icon area (right 52px of the box)
    var fromRight = this.getBoundingClientRect().right - e.clientX;
    if (fromRight > 52) return;

    e.stopPropagation(); // don't toggle the card

    var text = $(this).attr('title') || $(this).text().trim();
    if (!text || text === '-') return;

    var done = function () {
        $('.copy-toast').remove();
        $('<div class="copy-toast">Copied</div>').css({
            position: 'fixed', left: '50%', bottom: '90px', transform: 'translateX(-50%)',
            background: '#1e293b', color: '#fff', padding: '6px 14px', borderRadius: '8px',
            fontSize: '12px', fontWeight: 600, zIndex: 10000
        }).appendTo('body').delay(900).fadeOut(300, function () { $(this).remove(); });
    };

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(done);
    } else {
        var $t = $('<textarea>').val(text).css({ position: 'fixed', opacity: 0 }).appendTo('body');
        $t[0].select();
        document.execCommand('copy');
        $t.remove();
        done();
    }
});

});
</script>

@endsection
