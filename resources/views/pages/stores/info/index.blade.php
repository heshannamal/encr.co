@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
    /* Top header */
    .store_name {
        font-size: 27px;
    }

    .status {
        background-color: rgba(199, 249, 123, 0.7);
        font-size: 12px;
        margin-left: 15px;
        width: 58px;
        color: rgb(0, 101, 0);
        text-align: center;
        border-radius: 16px;
        line-height: 1.7;
        height: 27px;
        padding-top: 3px;
        margin-top: 5px;
    }

    .copy_link_btn {
        background-color: transparent;
        border: unset;
        cursor: pointer;
        margin-top: 6px;
        font-size: 10px;
        font-weight: 600;
        color: #B3B3B3;
    }

    .copy_btn_div {
        text-align: center;
        padding: unset;
    }

    .edit_store_btn {
        background-color: transparent;
        color: #B3B3B3;
        border: 1px solid #B3B3B3;
        width: 110px;
        height: 33px;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
    }

    .view_store_btn {
        background-color: #47D6B6;
        color: white;
        border: unset;
        width: 110px;
        height: 33px;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
    }

    /* End Top header */

    .general_info_div {
        border: none;
        margin-bottom: 12px;
        padding: 12px 15px;
        border-radius: 6px;
        background: #fff;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.05);
    }

    .info_icon {
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #39AB92;
        border-radius: 50%;
        font-size: 13px;
        color: white;
        margin-right: 8px;
    }

    .general_info {
        font-size: 17px;
        color: #333;
    }

    .general_info_label {
        font-size: 13px;
        color: #818181;
        margin-bottom: .4rem;
    }

    .general_info_detail {
        font-size: 13px;
        margin-bottom: .4rem;
        color: #000;
    }

    .hr {
        border: 0.5px solid #dedede;
        margin: 8px 0;
    }

    .list_icon {
        font-size: 7px;
        color: #39AB92;
        margin-right: 4px;
    }

    .timeline_row {
        display: flex;
        margin: 0;
    }

    .timeline_topic_div {
        width: 7rem;
    }

    .timeline_topic {
        font-size: 13px;
        color: #818181;
        margin-bottom: 3px;
    }

    .timeline_details {
        font-size: 13px;
        color: #000;
        margin-bottom: 3px;
    }

    .info_row {
        display: flex;
        align-items: flex-start;
        margin-bottom: 5px;
    }

    .info_icon {
        width: 22px;
        height: 21px;
        margin-top: 3px;
        text-align: center;
        background-color: #39AB92;
        border-radius: 12px;
        font-size: 13px;
        margin-right: 10px;
        color: white;
    }

    .general_info {
        font-size: 18px;
    }

    .general_info_label {
        font-size: 13px;
        color: #818181;
        margin-bottom: .5rem;
    }

    .general_info_detail {
        font-size: 13px;
        margin-bottom: .5rem;
    }

    .hr {
        border: .1px solid#DEDEDE;
        width: 94%;
        margin-top: unset;
        margin-bottom: 10px;
    }

    .list_icon {
        font-size: 8px;
        padding: 5px;
    }

    .timeline_row {
        margin: unset;
    }

    .timeline_topic_div {
        padding-bottom: 5px;
        width: 7rem;
    }

    @media (max-width: 767px) {

        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }
        
        /* ---- Card shell (General Info / Collect Info / Taxes & Fees / Coupons / Products) ---- */
        .general_info_div {
            border-radius: 14px !important;
            padding: 18px 16px !important;
            box-shadow: none !important;
            border: 1px solid #EEEEEE !important;
            margin-bottom: 16px !important;
        }

        .general_info_div .d-flex.align-items-center.mb-2 {
            margin-bottom: 14px !important;
            padding-bottom: 14px !important;
            border-bottom: 1px solid #EEEEEE !important;
        }

        .general_info_div .info_icon {
            background-color: transparent !important;
            color: #39AB92 !important;
            width: 24px !important;
            height: 24px !important;
            font-size: 17px !important;
            border-radius: 0 !important;
            margin-right: 10px !important;
        }

        .general_info_div .general_info {
            font-size: 17px !important;
            font-weight: 700 !important;
            color: #17181A !important;
        }

        /* ---- Store Timeline ---- */
        .timeline_row {
            display: flex !important;
            flex-direction: column !important;
            text-align: left !important;
            margin-bottom: 16px !important;
        }

        .timeline_topic_div {
            width: 100% !important;
        }

        .timeline_topic {
            font-size: 12px !important;
            color: #9AA0A6 !important;
            margin-bottom: 4px !important;
        }

        .timeline_details {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #17181A !important;
        }

        /* Store Timeline + QR code: side by side, QR boxed & centered */
        .general_info_div .d-flex.justify-content-between.align-items-start {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .general_info_div .d-flex.justify-content-between.align-items-start>div:first-child {
            flex: 1 1 auto !important;
        }

        .general_info_div .text-right.mr-4 {
            text-align: center !important;
            margin: 0 !important;
            flex: 0 0 auto !important;
            background: #F7F8F9 !important;
            border-radius: 12px !important;
            padding: 10px !important;
        }

        .general_info_div .text-right.mr-4 img {
            width: 84px !important;
            height: 84px !important;
            border: none !important;
        }

        .general_info_div .text-right.mr-4::after {
            content: "Tap to enlarge & share" !important;
            display: block !important;
            font-size: 10px !important;
            color: #9AA0A6 !important;
            margin-top: 6px !important;
            white-space: nowrap !important;
        }

        /* ---- Store URL / URL (View Only) ---- */
        .mb-3 .timeline_row {
            margin-bottom: 14px !important;
        }

        .mb-3 .general_info_label {
            font-size: 12px !important;
            color: #9AA0A6 !important;
            margin-bottom: 6px !important;
        }

        .timeline_detaild_div {
            display: flex !important;
            align-items: center !important;
            background: #F7F8F9 !important;
            border-radius: 10px !important;
            padding: 10px 12px !important;
            gap: 8px !important;
        }

        .timeline_detaild_div a.general_info_detail {
            font-family: 'Courier New', monospace !important;
            font-size: 13px !important;
            color: #17181A !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            max-width: calc(100% - 40px) !important;
            flex: 1 1 auto !important;
            margin: 0 !important;
        }

        .timeline_detaild_div .copy-url {
            flex-shrink: 0 !important;
            background: #E9F8F3 !important;
            border: none !important;
            border-radius: 8px !important;
            color: #39AB92 !important;
            width: 32px !important;
            height: 32px !important;
        }

        .general_info_div hr.hr {
            display: none !important;
        }

        /* ---- Collect Info / Taxes & Fees rows ---- */
        .info_row {
            display: flex !important;
            flex-direction: column !important;
            margin-bottom: 16px !important;
        }

        .info_row .col-4.general_info_label,
        .info_row .col-8.general_info_detail {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .info_row .col-4.general_info_label {
            font-size: 12px !important;
            color: #9AA0A6 !important;
            margin-bottom: 4px !important;
        }

        .info_row .col-8.general_info_detail {
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #17181A !important;
        }

        /* ---- Products ---- */
        .col-lg-6 .general_info_div>.row:first-child {
            margin-bottom: 14px !important;
            padding-bottom: 14px !important;
            border-bottom: 1px solid #EEEEEE !important;
        }

        .col-lg-6 .general_info_div .product_row {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            align-items: flex-start !important;
            padding: 12px 0 !important;
            border-bottom: 1px solid #F2F2F2 !important;
            margin: 0 !important;
        }

        .col-lg-6 .general_info_div .product_row:last-child {
            border-bottom: none !important;
        }

        .col-lg-6 .general_info_div .product_row .col-lg-2:first-of-type {
            flex: 0 0 60px !important;
            max-width: 60px !important;
            width: 60px !important;
            padding: 0 !important;
        }

        .col-lg-6 .general_info_div .product_row .col-lg-2:first-of-type .general_info_label {
            font-size: 12px !important;
            color: #9AA0A6 !important;
            margin-bottom: 0 !important;
        }

        .col-lg-6 .general_info_div .product_row .col-lg-8 {
            flex: 1 1 auto !important;
            max-width: none !important;
            width: auto !important;
            padding: 0 8px !important;
        }

        .col-lg-6 .general_info_div .product_row .col-lg-8 .general_info_detail {
            font-size: 14px !important;
            color: #17181A !important;
            margin-bottom: 0 !important;
            line-height: 1.4 !important;
        }

        .col-lg-6 .general_info_div .product_row .col-lg-2:last-of-type {
            flex: 0 0 60px !important;
            max-width: 60px !important;
            width: 60px !important;
            text-align: right !important;
            padding: 0 !important;
        }

        .col-lg-6 .general_info_div .product_row .col-lg-2:last-of-type .general_info_label {
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #17181A !important;
            font-family: 'Courier New', monospace !important;
            margin-bottom: 0 !important;
        }

        /* ---- Coupons empty state ---- */
        .card.general_info_div .text-muted {
            display: block !important;
            text-align: center !important;
            color: #9AA0A6 !important;
            font-size: 14px !important;
            margin: 12px 0 4px !important;
        }

        /* ---- Two-column desktop grid (.col-lg-6) stacks full-width on mobile ---- */
        .col-lg-6 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding-left: 5px !important;
            padding-right: 5px !important;
        }

        .col-lg-12 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        .bg-box.container-fluid.fix-nav.header-layout{
            margin-bottom: 0 !important;
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
</style>

<div class="container-fluid mb-5" style="padding: 0 !important;">
    <div class="se-pre-con"></div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')

    <div class="col-lg-12" style="margin-top: 20px;">
        <div class="row">
            <div class="col-lg-6 px-1">
                <!-- General Info -->
                <div class="card general_info_div">
                    <div class="d-flex align-items-center mb-2">
                        <div class="info_icon">
                            <i class="fa fa-info mt-1"></i>
                        </div>
                        <strong class="general_info">General Info</strong>
                    </div>

                    <div class="px-2 pb-2">
                        <div class="mb-2 d-flex justify-content-between align-items-start">
                            <div>
                                <b>Store Timeline</b>
                                <div class="timeline_row mt-2">
                                    <div class="timeline_topic_div">
                                        <p class="timeline_topic">Open Date</p>
                                    </div>
                                    <div class="timeline_detaild_div">
                                        <p class="timeline_details">
                                            {{ $store->open_date ? \Carbon\Carbon::parse($store->open_date)->format('j M Y (g:ia)') : '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="timeline_row">
                                    <div class="timeline_topic_div">
                                        <p class="timeline_topic">Close Date</p>
                                    </div>
                                    <div class="timeline_detaild_div">
                                        <p class="timeline_details">
                                            {{ $store->close_date ? \Carbon\Carbon::parse($store->close_date)->format('j M Y (g:ia)') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- ✅ QR Code on right side of Store Timeline -->
                            <div class="text-right mr-4">
                                <a href="{{ $qrCodeBase64 }}" download="{{$store->store_name}}QR.png" title="Download QR Code">
                                    <img src="{{ $qrCodeBase64 }}" alt="QR Code"
                                        width="110"
                                        style="border: 2px solid #eee; height: 7rem; cursor: pointer;">
                                </a>
                            </div>
                        </div>

                        <hr class="hr">

                        <div class="mb-3">
                            <div class="timeline_row mt-2">
                                <div class="timeline_topic_div">
                                    <p class="general_info_label">Store URL</p>
                                </div>
                                <div class="timeline_detaild_div">
                                    <a href="{{ env('STORE_DOMAIN') }}/{{ $store->direct_access_url }}"
                                        target="_blank"
                                        class="general_info_detail text-truncate mr-2"
                                        style="max-width: calc(100% - 30px);">
                                        {{ env('STORE_DOMAIN') }}/{{ $store->direct_access_url }}
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-secondary copy-url"
                                        data-url="{{ env('STORE_DOMAIN') }}/{{ $store->direct_access_url }}">
                                        <i class="fa fa-clone"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="timeline_row mt-2">
                                <div class="timeline_topic_div">
                                    <p class="general_info_label">URL (View Only)</p>
                                </div>
                                <div class="timeline_detaild_div">
                                    <a href="{{ env('STORE_DOMAIN') }}/{{ $store->direct_access_url }}?view-only=true"
                                        target="_blank"
                                        class="general_info_detail text-truncate mr-2"
                                        style="max-width: calc(100% - 30px);">
                                        {{ env('STORE_DOMAIN') }}/{{ $store->direct_access_url }}?view-only=true
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-secondary copy-url"
                                        data-url="{{ env('STORE_DOMAIN') }}/{{ $store->direct_access_url }}?view-only=true">
                                        <i class="fa fa-clone"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr class="hr">
                    </div>
                </div>

                <!-- Collect Info -->
                <div class="card general_info_div">
                    <div class="d-flex align-items-center mb-2">
                        <div class="info_icon">
                            <i class="fa fa-database mt-1"></i>
                        </div>
                        <strong class="general_info">Collect Info</strong>
                    </div>

                    <div class="px-2 pb-2">
                        <div class="info_row">
                            <div class="col-4 general_info_label">Payment Method</div>
                            <div class="col-8 general_info_detail">Customer Credit Card</div>
                        </div>
                        <hr class="hr">
                        <div class="info_row">
                            <div class="col-4 general_info_label">Collect Billing Info</div>
                            <div class="col-8 general_info_detail">Yes</div>
                        </div>
                    </div>
                </div>

                <!-- Taxes & Fees -->
                <div class="card general_info_div">
                    <div class="d-flex align-items-center mb-2">
                        <div class="info_icon">
                            <i class="fa fa-file-invoice-dollar mt-1"></i>
                        </div>
                        <strong class="general_info">Taxes & Fees</strong>
                    </div>

                    <div class="px-2 pb-2">
                        <div class="info_row">
                            <div class="col-4 general_info_label">Taxes</div>
                            <div class="col-8 general_info_detail">Sales Tax - {{ $store->sales_tax }}0%</div>
                        </div>
                        <hr class="hr">
                        <div class="info_row">
                            <div class="col-4 general_info_label">Fee</div>
                            <div class="col-8 general_info_detail">Shipping is automatically calculated using Shippo</div>
                        </div>
                    </div>
                </div>

                <!-- Coupons -->
                <div class="card general_info_div">
                    <div class="d-flex align-items-center mb-2">
                        <div class="info_icon">
                            <i class="fa fa-tags mt-1"></i>
                        </div>
                        <strong class="general_info">Coupons</strong>
                    </div>

                    <div class="px-2 pb-2">
                        <div class="info_row">
                            <div class="col-4 general_info_label">Coupons</div>
                            <div class="col-8">
                                @forelse ($store->StoreAddedCoupons as $fee)
                                <p class="general_info_detail">
                                    <i class="fa fa-circle list_icon"></i>{{ $fee->storeCouponsDetails->coupon_name }}
                                </p>
                                @empty
                                <p class="general_info_detail text-muted">No coupons added</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" style="padding-left: 5px; padding-right: 5px;">
                <div class="card general_info_div">
                    <div class="row" style="margin-left: unset;">
                        <div class="info_icon">
                            <i class="fa fa-tshirt" style="margin-top: 4px;"></i>
                        </div>
                        <div>
                            <strong class="general_info"> Products</strong>
                        </div>
                    </div>

                    @foreach ($store->StoreAddedProducts as $product)
                    <div class="row product_row" style="padding-top: 15px;">
                        <div class="col-lg-2" style="padding-right: unset">
                            <p class="general_info_label">PRO {{$product->product_id}}</p>
                        </div>
                        <div class="col-lg-8">
                            <p class="general_info_detail">{{$product->product_name}}</p>
                        </div>
                        <div class="col-lg-2" style="padding-left: unset">
                            <p class="general_info_label">
                                ${{ number_format($product->default_price + $product->priceAdditions->sum('addition_amount'), 2) }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.copy-url').on('click', function() {
            let url = $(this).data('url');
            navigator.clipboard.writeText(url).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'URL copied to clipboard.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to copy URL.',
                });
                console.error('Failed to copy: ', err);
            });
        });
    });
</script>
@endsection
@section('content')
@include('pages.stores.layouts.sidebar', ['sub_content' => 'overview'])
@endsection
