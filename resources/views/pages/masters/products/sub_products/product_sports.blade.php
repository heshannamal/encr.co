@extends('layouts.app', ['activePage' => 'product_sports', 'titlePage' => __('Product Sports')])

@section('content')

<style>
    .se-pre-con {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffffcc;
        display: none;
    }
    .table_header_text {
        color: white;
        font-weight: 600;
        text-align: center;
        background-color: rgba(50, 50, 50, 1) !important;
    }
    .save-icon {
        cursor: pointer;
        color: #47D6B6;
        font-size: 18px;
        transition: all 0.2s ease-in-out;
    }
    .save-icon:hover {
        color: #2cbda4;
        transform: scale(1.1);
    }
    .filter_div {
        margin: 20px 0;
        padding: 15px;
        background: #f9fafb;
        border-radius: 8px;
    }
    .table td {
        padding: 0;
    }

    /* MOBILE RESPONSIVE STYLES */
    @media (max-width: 768px) {
        body {
            background-color: #f8fafc !important;
        }
        .header1 {
            position: relative;
            display: block !important;
            top: 90px;
            background-color: white;
            padding-top: 10px;
        }
        .header-layout {
            margin-bottom: 0.5rem !important;
            position: relative !important;
            z-index: 10 !important;
        }

        .content-position {
            position: relative !important;
            top: 0 !important;
            padding-left: 14px !important;
            padding-right: 14px !important;
        }

        /* Card Container */
        .card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-top: 40px !important;
        }

        .home-btn-color {
            display: inline-flex !important;
            align-items: center !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #475569 !important;
            text-decoration: none !important;
            letter-spacing: 0.5px;
        }

        .home-btn-color::before {
            content: "\f053" !important;
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            font-size: 10px !important;
            margin-right: 6px !important;
        }

        /* Export Button */
        #export_csv.export-csv-btn {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            max-width: 100% !important;
            height: 44px !important;
            background-color: #ffffff !important;
            color: #475569 !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
            margin: 0 0 14px 0 !important;
            cursor: pointer !important;
        }

        #export_csv.export-csv-btn i {
            margin-right: 8px !important;
            font-size: 15px !important;
            color: #64748b !important;
        }

        /* Hide show entries */
        .dataTables_length {
            display: none !important;
        }

        /* DataTables Wrapper */
        .dataTables_wrapper {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .dataTables_wrapper .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .dataTables_wrapper .row > [class*="col-"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        /* Search Input Box */
        .dataTables_filter {
            width: 100% !important;
            float: none !important;
            text-align: left !important;
            margin: 0 0 14px 0 !important;
            padding: 0 !important;
            position: relative !important;
        }

        .dataTables_filter label {
            width: 100% !important;
            position: relative !important;
            margin: 0 !important;
            display: block !important;
            height: 48px !important;
            line-height: normal !important;
        }

        .dataTables_filter label::before {
            display: none !important;
        }

        .dataTables_filter input,
        .dataTables_filter input[type="search"] {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            height: 48px !important;
            padding: 10px 16px 10px 42px !important;
            background: #ffffff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><circle cx='11' cy='11' r='8'></circle><line x1='21' y1='21' x2='16.65' y2='16.65'></line></svg>") 14px center no-repeat !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            font-size: 14px !important;
            color: #334155 !important;
            box-sizing: border-box !important;
            margin: 0 !important;
            outline: none !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
        }

        .dataTables_filter input::placeholder {
            color: #94a3b8 !important;
            font-size: 14px !important;
        }

        /* Info text: Showing X and Sort info bar */
        .dataTables_info,
        .new-style-table .dataTables_info {
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            padding: 0 4px 12px 4px !important;
            margin: 0 !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
        }

        /* .dataTables_info::after {
            content: "Sort: Product Style Name" !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            margin-left: auto !important;
        } */

        /* Hide Table Headers */
        #product_sport_table thead {
            display: none !important;
        }

        /* Card-based layout for Table & Body */
        .table-responsive {
            overflow: visible !important;
            border: none !important;
            display: block !important;
            width: 100% !important;
            margin-bottom: 0 !important;
        }

        #product_sport_table {
            display: block !important;
            width: 100% !important;
            border: none !important;
            background: transparent !important;
            margin-bottom: 0 !important;
        }

        #product_sport_table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            width: 100% !important;
        }

        /* Each Row is a Card */
        #product_sport_table tbody tr {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            position: relative !important;
            background: #ffffff !important;
            border: 1px solid #f1f5f9 !important;
            border-radius: 16px !important;
            padding: 16px !important;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04) !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }

        #product_sport_table tbody tr td {
            border: none !important;
            padding: 0 !important;
            background: transparent !important;
        }

        /* ── PRODUCT NAME (td:nth-child(2)) ── */
        /* Top line: Header with T-shirt icon on the left and Chevron on the right */
        #product_sport_table tbody tr td:nth-child(2) {
            order: 1 !important;
            flex: 1 1 calc(100% - 28px) !important;
            max-width: calc(100% - 28px) !important;
            min-width: 0 !important;
            display: flex !important;
            align-items: flex-start !important;
            font-size: 13.5px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            line-height: 1.35 !important;
            padding-right: 8px !important;
            text-align: left !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
            white-space: normal !important;
        }

        /* Grey square shirt icon before product name */
        /* #product_sport_table tbody tr td:nth-child(2)::before {
            content: "" !important;
            display: inline-block !important;
            width: 48px !important;
            height: 48px !important;
            min-width: 48px !important;
            flex-shrink: 0 !important;
            margin-right: 12px !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23cbd5e1'><path d='M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z'/></svg>") center/28px no-repeat !important;
        } */

        /* ── PRODUCT NO (td:nth-child(1)) ── */
        /* Placed right below Product Name: Green badge text */
        #product_sport_table tbody tr td:nth-child(1) {
            order: 2 !important;
            /* margin-left: 60px !important; */
            /* margin-top: -24px !important; */
            font-size: 12.5px !important;
            font-weight: 700 !important;
            color: #10b981 !important;
            text-align: left !important;
            width: fit-content !important;
            padding-right: 8px !important;
        }

        /* ── PATTERN CODE (td:nth-child(3)) ── */
        /* Placed right below Product No: Grey text */
        #product_sport_table tbody tr td:nth-child(3) {
            order: 3 !important;
            width: 100% !important;
            /* margin-left: 60px !important; */
            margin-top: 2px !important;
            /* margin-bottom: 12px !important; */
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            text-align: left !important;
        }

        /* Card Divider Line between Header & Sports Selection */
        #product_sport_table tbody tr td:nth-child(3)::after {
            content: "" !important;
            display: block !important;
            height: 1px !important;
            background-color: #f1f5f9 !important;
            margin-top: 12px !important;
            margin-left: -16px !important;
            width: calc(100% + 32px) !important;
        }

        /* Accordion Chevron toggle indicator in top right */
        #product_sport_table tbody tr::after {
            content: "\f078" !important;
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            position: absolute !important;
            right: 18px !important;
            top: 22px !important;
            font-size: 12px !important;
            color: #64748b !important;
            pointer-events: none !important;
            transition: transform 0.2s ease !important;
        }

        #product_sport_table tbody tr:focus-within::after,
        #product_sport_table tbody tr:hover::after {
            content: "\f077" !important;
            transform: translateY(-1px);
        }

        /* ── ADDED SPORTS SELECTOR (td:nth-child(4)) ── */
        #product_sport_table tbody tr td:nth-child(4) {
            order: 4 !important;
            flex: 1 1 calc(100% - 60px) !important;
            width: calc(100% - 60px) !important;
            max-width: calc(100% - 60px) !important;
            min-width: 0 !important;
            display: flex !important;
            flex-direction: column !important;
            position: relative !important;
            margin-top: 6px !important;
            padding-right: 10px !important;
        }

        /* Added Sports Label */
        #product_sport_table tbody tr td:nth-child(4)::before {
            content: "Added Sports" !important;
            display: block !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #334155 !important;
            margin-bottom: 8px !important;
            text-align: left !important;
        }

        /* Select2 Container on Mobile */
        #product_sport_table tbody tr td:nth-child(4) .select2-container {
            width: 100% !important;
            max-width: 100% !important;
        }

        #product_sport_table tbody tr td:nth-child(4) .select2-container--default .select2-selection--multiple {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            min-height: 44px !important;
            padding: 4px 34px 4px 8px !important;
            position: relative !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02) !important;
            display: block !important;
            width: 100% !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
        }

        /* Inner rendered list: force wrap */
        #product_sport_table tbody tr td:nth-child(4) .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            gap: 4px !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            list-style: none !important;
            overflow: hidden !important;
        }


        /* Down arrow chevron on Select2 box */
        #product_sport_table tbody tr td:nth-child(4) .select2-container--default .select2-selection--multiple::after {
            content: "\f078" !important;
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            position: absolute !important;
            right: 14px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            font-size: 11px !important;
            color: #475569 !important;
            pointer-events: none !important;
        }

        /* Tags / Choices inside Select2 */
        #product_sport_table tbody tr td:nth-child(4) .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #f1f5f9 !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 999px !important;
            color: #334155 !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            padding: 3px 10px 3px 20px !important;
            margin: 0 !important;
            position: relative !important;
            line-height: 1.3 !important;
            max-width: 100% !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        #product_sport_table tbody tr td:nth-child(4) .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            position: absolute !important;
            left: 6px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: #64748b !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            margin-right: 0 !important;
            border: none !important;
        }

        #product_sport_table tbody tr td:nth-child(4) .select2-container--default .select2-selection--multiple .select2-search--inline {
            margin: 2px 0 !important;
        }

        #product_sport_table tbody tr td:nth-child(4) .select2-container--default .select2-selection--multiple .select2-search__field {
            font-size: 12px !important;
            margin: 0 !important;
            height: 28px !important;
            line-height: 28px !important;
        }

        /* Dropdown options styling */
        .select2-dropdown {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden !important;
            z-index: 99999 !important;
        }

        .select2-results__option {
            font-size: 13px !important;
            padding: 8px 12px !important;
            color: #334155 !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
            font-weight: 600 !important;
        }

        /* ── ACTION / SAVE BUTTON (td:nth-child(5)) ── */
        /* Positioned to the right of the select box, aligned at the bottom */
        #product_sport_table tbody tr td:nth-child(5) {
            order: 5 !important;
            flex: 0 0 48px !important;
            width: 48px !important;
            max-width: 48px !important;
            display: flex !important;
            align-items: flex-end !important;
            justify-content: center !important;
            margin-top: auto !important;
            padding-bottom: 0 !important;
        }

        /* Save Icon / Button styled as square rounded card button */
        #product_sport_table tbody tr td:nth-child(5) .save-icon {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 46px !important;
            height: 44px !important;
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-size: 16px !important;
            text-decoration: none !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02) !important;
            transition: all 0.2s ease !important;
            padding: 0 !important;
            cursor: pointer !important;
        }

        /* Disabled state: muted clean grey square button (Image 1) */
        #product_sport_table tbody tr td:nth-child(5) .save-icon:disabled {
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
            color: #475569 !important;
            opacity: 0.85 !important;
            cursor: not-allowed !important;
        }

        /* Enabled state when modified: vibrant mint green button (Image 2) */
        #product_sport_table tbody tr td:nth-child(5) .save-icon:not(:disabled) {
            background-color: #bbf7d0 !important;
            border-color: #86efac !important;
            color: #15803d !important;
            opacity: 1 !important;
            box-shadow: 0 2px 6px rgba(34, 197, 94, 0.25) !important;
        }

        #product_sport_table tbody tr td:nth-child(5) .save-icon:not(:disabled):hover {
            background-color: #86efac !important;
            color: #14532d !important;
            transform: scale(1.04) !important;
        }

        /* Pagination on mobile */
        .dataTables_paginate {
            display: flex !important;
            justify-content: center !important;
            margin-top: 16px !important;
            width: 100% !important;
        }

        .dataTables_paginate ul.pagination {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
        }

        .dataTables_paginate .page-item .page-link,
        .dataTables_paginate .page-item span {
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-size: 13px !important;
            padding: 6px 12px !important;
            background: #ffffff !important;
        }

        .dataTables_paginate .page-item.active .page-link {
            background-color: #14B8A6 !important;
            border-color: #14B8A6 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
        }
        /* ── COLLAPSE / EXPAND CARD ── */
        /* Default: card is collapsed — hide sports selector & action */
        #product_sport_table tbody tr.is-collapsed td:nth-child(4),
        #product_sport_table tbody tr.is-collapsed td:nth-child(5) {
            display: none !important;
        }

        /* Hide the divider line too when collapsed */
        #product_sport_table tbody tr.is-collapsed td:nth-child(3)::after {
            display: none !important;
        }

        /* Chevron: point down when collapsed, up when expanded */
        #product_sport_table tbody tr.is-collapsed::after {
            content: "\f078" !important; /* chevron-down */
            transform: rotate(0deg) !important;
        }
        #product_sport_table tbody tr:not(.is-collapsed)::after {
            content: "\f077" !important; /* chevron-up */
        }

        /* Pointer cursor on card header area */
        #product_sport_table tbody tr {
            cursor: pointer !important;
        }
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>PRODUCT SPORTS</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="card shadow-sm p-3">
        <button class="btn export-csv-btn ml-auto mb-2 mr-0" id="export_csv" style="max-width: 10rem;padding: .4rem .5rem;background-color: #47D6B6;color: white;border-radius: 0rem;" title="Export to CSV">
            <i class="fas fa-file-csv"></i> Export to CSV
        </button>
        <div class="">
            <table id="product_sport_table" class="table table-responsive table-bordered table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th class="table_header_text">PRODUCT NO</th>
                        <th class="table_header_text">PRODUCT NAME</th>
                        <th class="table_header_text">PATTERN CODE</th>
                        <th class="table_header_text">ADDED SPORTS</th>
                        <th class="table_header_text">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="text-center">{{ $product->product_no }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td class="text-center">{{ $product->pattern_code }}</td>
                            <td style="min-width: 250px;">
                                <select class="select2-sports form-control"
                                    multiple
                                    data-product-id="{{ $product->id }}">
                                    @foreach ($sports as $sport)
                                        <option
                                            value="{{ $sport->id }}"
                                            @if($product->productsport->pluck('sport_id')->contains($sport->id)) selected @endif>
                                            {{ $sport->sport_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-link save-icon" data-id="{{ $product->id }}" title="Save Sports" disabled>
                                    <i class="fas fa-save"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    const table = $('#product_sport_table').DataTable({
        pageLength: 25,
        responsive: true,
        autoWidth: false,
        ordering: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search products...",
            lengthMenu: "Show _MENU_ entries",
        },
        columnDefs: [
            { targets: [0, 2, 4], className: 'text-center align-middle' },
            { targets: '_all', className: 'align-middle' },
        ],
        drawCallback: function() {
            $('.select2-sports').select2({ width: '100%' });
        }
    });


    $('.select2-sports').select2({ width: '100%' });

    $(document).on('change', '.select2-sports', function () {
        $(this).closest('tr').find('.save-icon').prop('disabled', false);
    });

    $(document).on('click', '.save-icon', function () {
        const productId = $(this).data('id');
        const sports = $(this).closest('tr').find('.select2-sports').val();

        $.ajax({
            url: "{{ route('update.product.sports') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                sports: sports
            },
            beforeSend: function () {
                $('.se-pre-con').fadeIn('fast');
            },
            success: function (res) {
                $('.se-pre-con').fadeOut('fast');
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $(`button.save-icon[data-id='${productId}']`).prop('disabled', true);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message,
                    });
                }
            },
            error: function () {
                $('.se-pre-con').fadeOut('fast');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving. Please try again.',
                });
            }
        });
    });
    $('#export_csv').on('click', function () {
        $.ajax({
            url: "{{ route('export.product.sports.csv') }}",
            type: "GET",
            xhrFields: {
                responseType: 'blob'
            },
            beforeSend: function () {
                $('.se-pre-con').fadeIn('fast');
            },
            success: function (data) {
                $('.se-pre-con').fadeOut('fast');
                const blob = new Blob([data], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', 'product_sports.csv');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function () {
                $('.se-pre-con').fadeOut('fast');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while exporting. Please try again.',
                });
            }
        });
    });

});
</script>

<!-- mobile view only collapse/expand -->
<script>
    $(function () {
        const isMobile = () => window.innerWidth <= 768;

        // collapse all cards on load + after every redraw (mobile only)
        const collapse = () => isMobile() && $('#product_sport_table tbody tr:not(.toggle-init)').addClass('is-collapsed toggle-init');
        collapse();
        $('#product_sport_table').on('draw.dt', collapse);

        // toggle on card click (mobile only)
        $('#product_sport_table').on('click', 'tbody tr', function (e) {
            if (isMobile() && !$(e.target).closest('.select2-container, .save-icon').length)
                $(this).toggleClass('is-collapsed');
        });
    });
</script>

@endsection
