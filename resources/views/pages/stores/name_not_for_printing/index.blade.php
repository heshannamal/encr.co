@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
    .main_card {
        margin-top: 20px;
        border: unset;
        padding-bottom: 15px;
        border-radius: unset;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }
    .export_csv {
        width: 125px;
        height: 35px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .export_csv_div {
        margin-right: 15px;
        padding: 15px;
        padding-bottom: unset;
    }
    .shipping_header {
        font-size: 18px;
    }
    .card_div {
        padding: 15px;
        padding-bottom: 5px;
    }
    .per_page {
        font-size: 11px;
        color: #717070;
        font-weight: 500;
        margin-bottom: unset;
    }
    .search_icon {
        padding-top: 3px;
        padding-right: 6px;
    }
    .search_input {
        height: 25px;
        border: unset;
        width: 160px;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .page_qty {
        margin-top: 4px;
        margin-left: 10px;
        border: 1px solid #DEDEDE;
        border-radius: 11px;
        width: 40px;
        text-align: center;
        color: #47D6B6;
    }
    .order_id_select_div {
        margin-right: 5px;
        margin-left: 15px;
        padding-left: 5px;
        padding-right: 5px;
        border-radius: 8px;
        height: 20px;
        margin-top: 4px;
    }
    .total_qty_text {
        font-size: 10px;
        color: #B3B3B3;
        font-weight: 500;
        margin-bottom: unset;
    }
    .total_qty_text2 {
        font-size: 11px;
        color: #B3B3B3;
        font-weight: 500;
        margin-bottom: unset;
    }
    .pin_filter_div {
        margin-right: 5px;
        margin-left: 5px;
        padding-left: 5px;
        padding-right: 5px;
        border-radius: 8px;
        margin-top: 4px;
    }
    .btn-link:disabled, .btn-link.disabled {
        pointer-events: none;
        color: #8898aa;
    }
    .save-icon {
        cursor: pointer;
        color: #47D6B6;
        font-size: 18px;
        transition: all 0.2s ease-in-out;
    }
    .table td{
        padding: 0px !important;
    }

    /* ===== Mobile-only styles ===== */
    @media (max-width: 767px) {
        .desktop-only-nnfp {
            display: none !important;
        }
        .mobile-only-nnfp {
            display: block !important;
        }

        /* Make main card match top_header width — same col-lg-12 full-width container */
        .main_card {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin-top: 10px !important;
        }

        /* Mobile item card */
        .nnfp-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            margin-bottom: 10px;
            overflow: hidden;
        }

        /* Card header row — product image + info + chevron */
        .nnfp-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            cursor: pointer;
        }
        .nnfp-card-header:active {
            background: #f9f9f9;
        }

        /* Product thumbnail */
        .nnfp-thumb {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }
        .nnfp-thumb img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .nnfp-thumb .nnfp-thumb-icon {
            font-size: 20px;
            color: #ccc;
        }

        /* Text block */
        .nnfp-card-info {
            flex: 1;
            min-width: 0;
        }
        .nnfp-product-name {
            font-size: 13px;
            font-weight: 700;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .nnfp-order-link {
            font-size: 12px;
            font-weight: 700;
            color: #47D6B6;
            text-decoration: none;
            display: block;
            margin-top: 1px;
        }
        .nnfp-customer-name {
            font-size: 12px;
            color: #717070;
            margin-top: 2px;
        }

        /* Chevron */
        .nnfp-chevron {
            font-size: 14px;
            color: #bbb;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }
        .nnfp-chevron.open {
            transform: rotate(180deg);
        }

        /* Expanded details */
        .nnfp-card-body {
            display: none;
            border-top: 1px solid #f0f0f0;
            padding: 14px;
            background: #fafafa;
        }

        /* Info rows */
        .nnfp-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
        }
        .nnfp-detail-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .nnfp-detail-label {
            color: #9ca3af;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .nnfp-detail-val {
            font-weight: 600;
            color: #333;
            font-size: 13px;
            text-align: right;
        }
        .nnfp-detail-val.empty {
            color: #ccc;
            font-weight: 400;
        }

        /* Custom number input row */
        .nnfp-number-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0 0;
        }
        .nnfp-number-input-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nnfp-number-input-wrap .custom_number {
            width: 90px;
            height: 36px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            text-align: center;
            font-size: 16px;
            font-weight: 700;
            color: #333;
            padding: 0 8px;
        }
        .nnfp-save-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
        }
        .nnfp-save-btn .save-icon {
            font-size: 22px;
        }
        .nnfp-save-btn:disabled .save-icon {
            color: #ccc;
        }

        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }
        
        /* Prevent iOS Safari from auto-zooming on focus */
        input[type="text"],
        input[type="number"],
        input[type="search"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="url"],
        select,
        textarea,
        .form-control,
        .select2-selection,
        .select2-search__field,
        .select2-search input {
            font-size: 16px !important;
        }
    }

    /* ===== Desktop: hide mobile layout ===== */
    @media (min-width: 768px) {
        .mobile-only-nnfp {
            display: none !important;
        }
        .desktop-only-nnfp {
            display: block !important;
        }
    }

</style>


<div class="container-fluid mb-5" style="background-color: transparent;padding: 0 !important;">
    <div class="se-pre-con"></div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')

    {{-- ===================== DESKTOP VIEW ===================== --}}
    <div class="card col-lg-12 main_card desktop-only-nnfp" style="margin-top: 20px;">
        <div class="">
            <div class="row">
                <div class="card_div" style="width: 80%;">
                    <strong class="shipping_header">Names Not For Printing</strong>
                </div>

            </div>
            <hr style="margin: unset; margin-bottom: 10px;">

        </div>

        <div style="padding-top: 5px; overflow-x: auto;">
    <table class="table align-items-center" id="product_report_table" style="min-width: 100%;">
        <thead style="background-color: #717070;">
            <tr>
                <th scope="col" class="table_header_text text-left">PRODUCT</th>
                <th scope="col" class="table_header_text text-center">ORDER NO</th>
                <th scope="col" class="table_header_text text-center">CUSTOMER NAME</th>
                <th scope="col" class="table_header_text text-center">CUSTOM NAME</th>
                <th scope="col" class="table_header_text text-center">CUSTOM NUMBER</th>
                <th scope="col" class="table_header_text text-center">CREATED DATE</th>
                <th scope="col" class="table_header_text text-center">ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItems as $orderItem)
                @foreach ($orderItem->OrderItemDetails as $OrderItemDetail)
                    <tr>
                        <td scope="col" class="table_body" style="padding-left: .5rem;">
                            @if (!empty($orderItem->productDetails->images) && isset($orderItem->productDetails->images[0]->url))
                                <img style="height: 4rem; width:auto; margin-right:.5rem;" src="{{ asset($orderItem->productDetails->images[0]->url) }}" alt="Product Image">
                            @endif
                            {{ $orderItem->productDetails->product_name }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('store.individual_player', ['id' => $orderItem->orderDetails->order_no]) }}" class="a_tag_onclick">
                                {{$orderItem->orderDetails->order_no}}
                            </a>
                        </td>
                        <td class="text-center">{{ $orderItem->orderDetails->customerDetails->first_name ?? '' }} {{ $orderItem->orderDetails->customerDetails->last_name ?? '' }}</td>
                        <td class="text-center">{{ $OrderItemDetail->player_name ?? '' }}</td>
                        <td class="text-center">
                            <input type="text" class="custom_number" value="{{ $OrderItemDetail->player_number ?? '' }}" style="border: 1px solid #b3b3b3; background: transparent; text-align: center;">
                        </td>
                        <td class="text-center">{{ $OrderItemDetail->created_at ? date('m/d/Y', strtotime($OrderItemDetail->created_at)) : '' }}</td>
                        <td class="text-center">
                            <button class="btn btn-link save-icon" data-detail-id="{{$OrderItemDetail->id}}" title="Save Sports" disabled>
                                    <i class="fas fa-save"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>


    </div>

    {{-- ===================== MOBILE VIEW ===================== --}}
    <div class="mobile-only-nnfp" style="margin-top: 10px;">

        {{-- Section title --}}
        <div style="margin-bottom: 12px; padding: 0 2px;">
            <strong style="font-size: 15px; color: #333;">Names Not For Printing</strong>
        </div>

        {{-- Cards list --}}
        @foreach ($orderItems as $orderItem)
            @foreach ($orderItem->OrderItemDetails as $OrderItemDetail)
                @php
                    $productName = $orderItem->productDetails->product_name ?? 'Unknown Product';
                    $orderNo     = $orderItem->orderDetails->order_no ?? 'N/A';
                    $customerName = trim(($orderItem->orderDetails->customerDetails->first_name ?? '') . ' ' . ($orderItem->orderDetails->customerDetails->last_name ?? ''));
                    $customName   = $OrderItemDetail->player_name ?? '';
                    $customNumber = $OrderItemDetail->player_number ?? '';
                    $createdDate  = $OrderItemDetail->created_at ? date('m/d/Y', strtotime($OrderItemDetail->created_at)) : '';
                    $detailId     = $OrderItemDetail->id;
                    $imgUrl       = (!empty($orderItem->productDetails->images) && isset($orderItem->productDetails->images[0]->url))
                                        ? asset($orderItem->productDetails->images[0]->url)
                                        : null;
                @endphp
                <div class="nnfp-card">
                    {{-- Header (always visible, tap to expand) --}}
                    <div class="nnfp-card-header" onclick="toggleNnfpCard(this)">
                        <div class="nnfp-thumb">
                            @if($imgUrl)
                                <img src="{{ $imgUrl }}" alt="{{ $productName }}">
                            @else
                                <i class="fa fa-tshirt nnfp-thumb-icon"></i>
                            @endif
                        </div>
                        <div class="nnfp-card-info">
                            <div class="nnfp-product-name" title="{{ $productName }}">{{ $productName }}</div>
                            <a href="{{ route('store.individual_player', ['id' => $orderNo]) }}" class="nnfp-order-link" onclick="event.stopPropagation();">#{{ $orderNo }}</a>
                            <div class="nnfp-customer-name">{{ $customerName ?: '—' }}</div>
                        </div>
                        <i class="fa fa-chevron-down nnfp-chevron"></i>
                    </div>

                    {{-- Body (hidden by default, expands on tap) --}}
                    <div class="nnfp-card-body">

                        {{-- Custom Name --}}
                        <div class="nnfp-detail-row">
                            <span class="nnfp-detail-label">Custom Name</span>
                            <span class="nnfp-detail-val {{ $customName ? '' : 'empty' }}">
                                {{ $customName ?: '—' }}
                            </span>
                        </div>

                        {{-- Created Date --}}
                        <div class="nnfp-detail-row">
                            <span class="nnfp-detail-label">Created Date</span>
                            <span class="nnfp-detail-val {{ $createdDate ? '' : 'empty' }}">{{ $createdDate ?: '—' }}</span>
                        </div>

                        {{-- Custom Number --}}
                        <div class="nnfp-detail-row" style="display:block; padding-bottom:0; border-bottom:none;">
                            <span class="nnfp-detail-label">Custom Number</span>
                            <div class="nnfp-number-row">
                                <div class="nnfp-number-input-wrap">
                                    <input type="text"
                                           class="custom_number"
                                           value="{{ $customNumber }}"
                                           placeholder="—">
                                </div>
                                <button class="nnfp-save-btn" data-detail-id="{{ $detailId }}" title="Save" disabled>
                                    <i class="fas fa-save save-icon"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        @endforeach

        @if($orderItems->isEmpty())
            <div style="text-align:center; padding: 40px 0; color: #aaa; font-size: 14px;">
                No records found.
            </div>
        @endif

    </div>

</div>

<script>
    $(document).ready(function () {

        // ===== Desktop: DataTable =====
        if ($(window).width() >= 768) {
            $('#product_report_table').DataTable({
                paging: true,
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                searching: false,
                ordering: false,
            });
        }

        // ===== custom_number change enables save (desktop + mobile) =====
        $(document).on('change', '.custom_number', function() {
            var $row = $(this).closest('tr');
            if ($row.length) {
                // Desktop table row
                $row.find('.save-icon').prop('disabled', false);
            } else {
                // Mobile card body
                var $card = $(this).closest('.nnfp-card-body');
                $card.find('.nnfp-save-btn').prop('disabled', false);
            }
        });

        // ===== Save handler (desktop + mobile) =====
        $(document).on('click', '.save-icon, .nnfp-save-btn', function() {
            if ($(this).prop('disabled')) return;

            var detailId = $(this).data('detail-id');
            var $row = $(this).closest('tr');
            var customNumber;

            if ($row.length) {
                // Desktop
                customNumber = $row.find('.custom_number').val();
            } else {
                // Mobile
                customNumber = $(this).closest('.nnfp-card-body').find('.custom_number').val();
            }

            var $button = $(this);
            $(".se-pre-con").fadeIn('slow');

            $.ajax({
                url: '{{ route("store.save_name_not_for_printing") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    detail_id: detailId,
                    custom_number: customNumber
                },
                success: function(response) {
                    $('.se-pre-con').fadeOut('slow');
                    if (response.success) {
                        swal('Success', 'Custom number updated successfully.', 'success');
                        
                        $('[data-detail-id="' + detailId + '"]').prop('disabled', true);
                        
                        $('.custom_number').filter(function() {
                            return $(this).closest('tr, .nnfp-card-body')
                                        .find('[data-detail-id="' + detailId + '"]').length > 0;
                        }).val(customNumber);

                        $button.prop('disabled', true);
                    } else {
                        swal('Error', 'Failed to update custom number.', 'error');
                    }
                },
                error: function() {
                    $('.se-pre-con').fadeOut('slow');
                    swal('Error', 'An error occurred while processing your request.', 'error');
                }
            });
        });

    });

    // ===== Mobile card accordion toggle =====
    function toggleNnfpCard(headerEl) {
        var $header  = $(headerEl);
        var $card    = $header.closest('.nnfp-card');
        var $body    = $card.find('.nnfp-card-body');
        var $chevron = $header.find('.nnfp-chevron');

        if ($body.is(':visible')) {
            $body.slideUp(180);
            $chevron.removeClass('open');
        } else {
            $body.slideDown(180);
            $chevron.addClass('open');
        }
    }

</script>

@endsection
@section('content')
    @include('pages.stores.layouts.sidebar', ['sub_content' => 'overview'])
@endsection
