@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
    .main_card {
        margin-top: 20px;
        border: 0;
        padding-bottom: 15px;
        border-radius: 0;
    }

    .share_btn {
        border: 0;
        background: transparent;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
    }

    .btn_section {
        margin-right: 15px;
        padding: 15px 15px 0;
    }

    .product_report {
        font-size: 18px;
    }

    .card_div {
        padding: 15px 15px 5px;
    }

    .share_btn_div {
        border-right: 1px solid #DEDEDE;
        margin: 5px;
    }

    .total_qty_text {
        font-size: 10px;
        color: #B3B3B3;
        font-weight: 500;
        margin-bottom: 0;
    }

    .qty_div {
        margin-right: 5px;
    }

    .qty_div2 {
        margin-right: 10px;
        margin-left: 5px;
        border-right: 1px solid #DEDEDE;
        padding-right: 10px;
    }

    .se-pre-con {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }

    .view-order {
        cursor: pointer;
    }

    /* =========================
       DESKTOP PRODUCT TABLE
       ========================= */
    .product_table_wrapper {
        padding-left: 35px;
        padding-right: 10px;
        overflow-x: auto;
        height: 80vh;
    }

    #product_report_table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    #product_report_table thead th {
        background: #717070;
        color: #fff;
        height: 40px;
        font-size: 11px;
        font-weight: 700;
        vertical-align: middle;
        border: 0;
    }

    .product-summary-row {
        background: #f3f3f3;
        border-bottom: 1px solid #DEDEDE;
        cursor: pointer;
        transition: background .15s ease;
    }

    .product-summary-row:hover {
        background: #ececec;
    }

    .product-toggle-cell {
        width: 42px;
        text-align: center;
        padding: 8px !important;
        vertical-align: middle !important;
    }

    .product-toggle-icon {
        color: #555;
        transition: transform .2s ease;
    }

    .product-toggle-icon.open {
        transform: rotate(90deg);
    }

    .product-main-cell {
        padding: 8px 10px !important;
        vertical-align: middle !important;
    }

    .product-main-wrap {
        display: flex;
        align-items: center;
        min-width: 0;
    }

    .product-thumb {
        width: 58px;
        height: 58px;
        object-fit: contain;
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 6px;
        margin-right: 10px;
        flex: 0 0 auto;
    }

    .product-thumb-placeholder {
        width: 58px;
        height: 58px;
        background: #ededed;
        border-radius: 6px;
        margin-right: 10px;
        flex: 0 0 auto;
    }

    .product-name {
        color: #4E4C4C;
        font-size: 12px;
        font-weight: 500;
        line-height: 1.35;
    }

    .product-total-qty {
        width: 150px;
        text-align: center;
        color: #4E4C4C;
        font-size: 12px;
        font-weight: 700;
        vertical-align: middle !important;
    }

    .product-expand-row {
        display: none;
    }

    .product-expand-row > td {
        padding: 0 !important;
        border: 0 !important;
        background: #f8f8f8;
    }

    .size-groups-wrap {
        padding: 10px 12px 14px;
    }
    
    .mobile-report-header {
        display: none;
    }

    .size-group {
        background: #fff;
        border: 1px solid #dedede;
        margin-bottom: 8px;
        border-radius: 4px;
        overflow: hidden;
    }

    .size-group:last-child {
        margin-bottom: 0;
    }

    .size-group-header {
        min-height: 42px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 8px 14px;
        background: #eeeeee;
        cursor: pointer;
        transition: background .15s ease;
    }

    .size-group-header:hover {
        background: #e7e7e7;
    }

    .size-group-left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .size-toggle-icon {
        width: 14px;
        color: #555;
        transition: transform .2s ease;
    }

    .size-toggle-icon.open {
        transform: rotate(90deg);
    }

    .size-label {
        font-size: 10px;
        font-weight: 700;
        color: #9b9b9b;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .size-name {
        font-size: 12px;
        font-weight: 700;
        color: #4E4C4C;
    }

    .size-qty {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 72px;
        height: 26px;
        padding: 0 10px;
        border-radius: 13px;
        background: #e9f6f2;
        color: #15977f;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .size-group-body {
        display: none;
        background: #fff;
    }

    .size-group-body.open {
        display: block;
    }

    .size-detail-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .size-detail-table thead th {
        height: 36px;
        background: #717070;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        text-align: center;
        vertical-align: middle;
        border: 0;
        padding: 8px 10px;
    }

    .size-detail-table thead th.text-right,
    .size-detail-table tbody td.text-right {
        text-align: right !important;
    }

    .size-detail-table tbody td {
        height: 40px;
        color: #4E4C4C;
        font-size: 11px;
        vertical-align: middle;
        border-bottom: 1px solid #e6e6e6;
        padding: 8px 10px;
        text-align: center;
    }

    .size-detail-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .size-detail-table tbody tr:hover {
        background: #fafafa;
    }

    .empty-size-message {
        padding: 18px;
        color: #999;
        text-align: center;
        font-size: 12px;
    }

    /* =========================
       MOBILE
       ========================= */
    .mobile-product-cards {
        display: none;
    }

    @media (max-width: 767px) {
        .bg-box.container-fluid.fix-nav.header-layout {
            margin-bottom: 0 !important;
        }

        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

        .product_table_wrapper {
            display: none !important;
        }

        .main_card {
            background: #fff !important;
            border-radius: 14px !important;
            width: auto !important;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .08) !important;
        }

        .desktop-report-header {
            display: none !important;
        }

        .mobile-report-header {
            display: block !important;
            padding: 0 10px 12px !important;
        }

        .mrh-title {
            font-size: 17px !important;
            font-weight: 700 !important;
            color: #1a1a1a !important;
            margin-bottom: 12px !important;
        }

        .mrh-stats {
            display: flex !important;
            gap: 10px !important;
            margin-bottom: 12px !important;
        }

        .mrh-stat-box {
            flex: 1 1 0 !important;
            background: #F5F5F5 !important;
            border-radius: 14px !important;
            padding: 10px 12px !important;
            text-align: center !important;
        }

        .mrh-stat-label {
            font-size: 11px !important;
            color: #9a9a9a !important;
            font-weight: 500 !important;
            margin-bottom: 4px !important;
        }

        .mrh-stat-value {
            font-size: 22px !important;
            color: #1a1a1a !important;
            font-weight: 700 !important;
        }

        .mrh-actions {
            display: flex !important;
            gap: 8px !important;
        }

        .mrh-action-btn {
            flex: 1 1 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            background: #fff !important;
            border: 1px solid #E5E5E5 !important;
            border-radius: 14px !important;
            padding: 8px 0 !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #4E4C4C !important;
            cursor: pointer !important;
        }

        .mrh-action-btn.pdf,
        .mrh-action-btn.pdf i {
            color: #E24C4C !important;
        }

        .mrh-action-btn.csv,
        .mrh-action-btn.csv i {
            color: #2E7BE0 !important;
        }

        .mobile-product-cards {
            display: block !important;
            margin-top: 12px !important;
        }

        .mp-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .08);
            margin-bottom: 12px;
            overflow: hidden;
        }

        .mp-card-header {
            display: flex;
            align-items: center;
            padding: 12px;
            cursor: pointer;
        }

        .mp-card-img {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: contain;
            background: #F3F3F3;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .mp-card-title-wrap {
            flex: 1 1 auto;
            min-width: 0;
        }

        .mp-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.35;
        }

        .mp-card-subtitle {
            font-size: 11px;
            color: #9a9a9a;
            margin-top: 2px;
        }

        .mp-card-qty {
            background: #E7F7F1;
            color: #12A587;
            font-weight: 700;
            font-size: 11px;
            padding: 4px 9px;
            border-radius: 20px;
            margin-right: 8px;
            white-space: nowrap;
        }

        .mp-card-chevron,
        .mp-size-chevron {
            transition: transform .2s ease;
            color: #4E4C4C;
        }

        .mp-card-chevron.open,
        .mp-size-chevron.open {
            transform: rotate(90deg);
        }

        .mp-card-body {
            display: none;
            background: #F8F8F8;
            padding: 10px;
        }

        .mp-card-body.open {
            display: block;
        }

        .mp-size-group {
            background: #fff;
            border: 1px solid #e7e7e7;
            border-radius: 12px;
            margin-bottom: 8px;
            overflow: hidden;
        }

        .mp-size-group:last-child {
            margin-bottom: 0;
        }

        .mp-size-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 12px;
            cursor: pointer;
            background: #fff;
        }

        .mp-size-left {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
        }

        .mp-size-name {
            font-size: 13px;
            font-weight: 700;
            color: #333;
        }

        .mp-size-qty {
            color: #12A587;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .mp-size-body {
            display: none;
            padding: 0 10px 10px;
            background: #F8F8F8;
        }

        .mp-size-body.open {
            display: block;
        }

        .mp-detail-row {
            background: #fff;
            border-radius: 10px;
            padding: 10px;
            margin-top: 8px;
        }

        .mp-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .mp-detail-label {
            font-size: 9px;
            color: #B3B3B3;
            font-weight: 600;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .mp-detail-value {
            font-size: 12px;
            color: #1a1a1a;
            font-weight: 600;
            word-break: break-word;
        }

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

    @media (min-width: 768px) {
        .mobile-report-header {
            display: none;
        }
    }
</style>

<div class="container-fluid mb-5" style="padding: 0 !important;">
    <div class="se-pre-con"></div>

    {{-- Mobile page header --}}
    <div class="d-block d-md-none"
         style="position:relative;background:#fff;border-bottom:1px solid #e8e8e8;padding:1rem 10px;margin:0 -10px 1rem;box-shadow:0 1px 3px rgba(0,0,0,.04);z-index:10;">
        <a href="{{ route('store.overview', ['id' => $store->id]) }}"
           style="position:absolute;left:0;top:50%;transform:translateY(-50%);color:#555;font-size:1.25rem;padding:1rem 10px;z-index:2;text-decoration:none;">
            <i class="fa fa-arrow-left"></i>
        </a>

        <h2 class="font-weight-bold text-center m-0"
            style="color:#333;font-size:1.25rem;padding:0 2rem;line-height:1.6rem;">
            Product Report
        </h2>
    </div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')

    <div class="card col-lg-12 main_card">
        <div class="desktop-report-header">
            <div class="row">
                <div class="card_div">
                    <strong class="product_report">Product Report</strong>
                </div>

                <div class="ml-auto btn_section">
                    <div class="row">
                        <div class="share_btn_div">
                            <button class="share_btn">
                                <i class="fa fa-share" style="padding:5px;"></i> SHARE
                            </button>
                        </div>

                        <div class="share_btn_div">
                            <button class="share_btn download-as-exel">
                                <i class="fa fa-download" style="padding:5px;"></i> CSV
                            </button>
                        </div>

                        <div class="share_btn_div" style="border:0;">
                            <button class="share_btn download-as-pdf">
                                <i class="fa fa-download" style="padding:5px;"></i> PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div style="padding-left:15px;">
                    <div class="row" style="padding:15px;">
                        <div class="qty_div">
                            <p class="total_qty_text">Total quantity of products</p>
                        </div>

                        <div class="qty_div2">
                            <p class="total_qty_text" style="color:#717070;">
                                {{ optional($store->StoreOrders->map->OrderItems->flatten())->sum('qty') ?: 'N/A' }}
                            </p>
                        </div>

                        <div class="qty_div">
                            <p class="total_qty_text">Total number of orders</p>
                        </div>

                        <div class="qty_div2">
                            <p class="total_qty_text" style="color:#717070;">
                                {{ optional($store->StoreOrders)->count() ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile report header --}}
        <div class="mobile-report-header">
            <div class="mrh-title">Product Report</div>

            <div class="mrh-stats">
                <div class="mrh-stat-box">
                    <div class="mrh-stat-label">Products</div>
                    <div class="mrh-stat-value">
                        {{ optional($store->StoreOrders->map->OrderItems->flatten())->sum('qty') ?: '0' }}
                    </div>
                </div>

                <div class="mrh-stat-box">
                    <div class="mrh-stat-label">Orders</div>
                    <div class="mrh-stat-value">
                        {{ optional($store->StoreOrders)->count() ?? '0' }}
                    </div>
                </div>
            </div>

            <div class="mrh-actions">
                <button class="mrh-action-btn share">
                    <i class="fa fa-share-alt"></i> Share
                </button>

                <button class="mrh-action-btn csv download-as-exel">
                    <i class="fa fa-file"></i> CSV
                </button>

                <button class="mrh-action-btn pdf download-as-pdf">
                    <i class="fa fa-file-alt"></i> PDF
                </button>
            </div>
        </div>

        <hr style="margin:0 0 10px;">
    </div>

    @php
        $orderItems = $store->StoreOrders->map->OrderItems->flatten();

        $groupedOrderItems = $orderItems
            ->groupBy(function ($item) {
                return optional($item->productDetails)->id;
            })
            ->filter();

        $productSizes = [
            31, 1, 2, 3, 4, 5, 6, 7, 8, 9,
            26, 17, 18, 19, 11, 12, 13, 14,
            15, 20, 21, 22, 23, 24, 25, 16,
            28, 29
        ];
    @endphp

    {{-- =========================
         DESKTOP REPORT
         ========================= --}}
    <div class="product_table_wrapper">
        <table class="table align-items-center" id="product_report_table">
            <thead>
                <tr>
                    <th style="width:42px;"></th>
                    <th>PRODUCT</th>
                    <th class="text-center" style="width:150px;">QTY</th>
                </tr>
            </thead>

            <tbody>
                @forelse($groupedOrderItems as $productId => $items)
                    @php
                        $firstItem = $items->first();
                        $product = $firstItem->productDetails;
                        $totalQty = $items->sum('qty');
                        $productPanelId = 'product_panel_' . $productId;

                        $allDetails = $items
                            ->flatMap(function ($orderItem) {
                                return $orderItem->OrderItemDetails;
                            })
                            ->values();

                        $sizeGroups = $allDetails
                            ->groupBy(function ($detail) {
                                return (string) ($detail->size ?? 'none');
                            })
                            ->sortBy(function ($group, $sizeId) use ($productSizes) {
                                if ($sizeId === 'none') {
                                    return PHP_INT_MAX;
                                }

                                $numericSizeId = is_numeric($sizeId) ? (int) $sizeId : $sizeId;
                                $index = array_search($numericSizeId, $productSizes, true);

                                return $index !== false ? $index : PHP_INT_MAX - 1;
                            });

                        $isNameAvailable = (int) ($product->set_individual_name ?? 0) === 1;
                        $isNumberAvailable = (int) ($product->set_individual_number ?? 0) === 1;
                    @endphp

                    {{-- Product summary row --}}
                    <tr class="product-summary-row"
                        onclick="toggleProductRow('{{ $productPanelId }}', this)">
                        <td class="product-toggle-cell">
                            <i class="fa fa-chevron-right product-toggle-icon"></i>
                        </td>

                        <td class="product-main-cell">
                            <div class="product-main-wrap">
                                @if(!empty($product->images) && isset($product->images[0]->url))
                                    <img class="product-thumb"
                                         src="{{ asset($product->images[0]->url) }}"
                                         alt="Product Image">
                                @else
                                    <div class="product-thumb-placeholder"></div>
                                @endif

                                <div class="product-name">
                                    {{ $product->product_name }}
                                </div>
                            </div>
                        </td>

                        <td class="product-total-qty">
                            {{ $totalQty }}
                        </td>
                    </tr>

                    {{-- Full-width product expansion --}}
                    <tr class="product-expand-row" id="{{ $productPanelId }}">
                        <td colspan="3">
                            <div class="size-groups-wrap">
                                @forelse($sizeGroups as $sizeId => $sizeDetails)
                                    @php
                                        $firstDetail = $sizeDetails->first();

                                        $sizeName = optional($firstDetail->SizeDetails)->size_name
                                            ?? ($sizeId === 'none' ? 'No Size' : 'Size ' . $sizeId);

                                        $sizeQty = $sizeDetails->sum('qty');

                                        $safeSizeId = preg_replace(
                                            '/[^A-Za-z0-9_-]/',
                                            '_',
                                            (string) $sizeId
                                        );

                                        $sizePanelId = 'size_panel_' . $productId . '_' . $safeSizeId;
                                    @endphp

                                    <div class="size-group">
                                        <div class="size-group-header"
                                             onclick="toggleSizeRow('{{ $sizePanelId }}', this); event.stopPropagation();">
                                            <div class="size-group-left">
                                                <i class="fa fa-chevron-right size-toggle-icon"></i>

                                                <div>
                                                    <div class="size-label">Size</div>
                                                    <div class="size-name">{{ $sizeName }}</div>
                                                </div>
                                            </div>

                                            <span class="size-qty">
                                                Qty {{ $sizeQty }}
                                            </span>
                                        </div>

                                        <div class="size-group-body" id="{{ $sizePanelId }}">
                                            <div class="table-responsive">
                                                <table class="size-detail-table">
                                                    <thead>
                                                        <tr>
                                                            <th>NAME</th>
                                                            <th>NUMBER</th>
                                                            <th>QTY</th>
                                                            <th class="text-right">TOTAL ($)</th>
                                                            <th class="text-right">PAID ($)</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach($sizeDetails as $detail)
                                                            <tr class="view-order"
                                                                data-store-order-item-id="{{ $detail->store_order_item_id ?? '-' }}"
                                                                data-item-detail-id="{{ $detail->id ?? '-' }}">
                                                                <td>
                                                                    {{ $isNameAvailable
                                                                        ? ($detail->player_name ?? '-')
                                                                        : 'N/A' }}
                                                                </td>

                                                                <td>
                                                                    {{ $isNumberAvailable
                                                                        ? ($detail->player_number ?? '-')
                                                                        : 'N/A' }}
                                                                </td>

                                                                <td>
                                                                    {{ $detail->qty ?? 0 }}
                                                                </td>

                                                                <td class="text-right">
                                                                    {{ number_format((float) ($detail->total_amount ?? 0), 2) }}
                                                                </td>

                                                                <td class="text-right">
                                                                    {{ number_format((float) ($detail->paid_amount ?? 0), 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-size-message">
                                        No size details are available for this product.
                                    </div>
                                @endforelse
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- =========================
         MOBILE REPORT
         ========================= --}}
    <div class="mobile-product-cards">
        @foreach($groupedOrderItems as $productId => $items)
            @php
                $firstItem = $items->first();
                $product = $firstItem->productDetails;
                $totalQty = $items->sum('qty');

                $allDetails = $items
                    ->flatMap(function ($orderItem) {
                        return $orderItem->OrderItemDetails;
                    })
                    ->values();

                $sizeGroups = $allDetails
                    ->groupBy(function ($detail) {
                        return (string) ($detail->size ?? 'none');
                    })
                    ->sortBy(function ($group, $sizeId) use ($productSizes) {
                        if ($sizeId === 'none') {
                            return PHP_INT_MAX;
                        }

                        $numericSizeId = is_numeric($sizeId) ? (int) $sizeId : $sizeId;
                        $index = array_search($numericSizeId, $productSizes, true);

                        return $index !== false ? $index : PHP_INT_MAX - 1;
                    });

                $isNameAvailable = (int) ($product->set_individual_name ?? 0) === 1;
                $isNumberAvailable = (int) ($product->set_individual_number ?? 0) === 1;

                $mobileProductId = 'mobile_product_' . $productId;
            @endphp

            <div class="mp-card">
                <div class="mp-card-header"
                     onclick="toggleMobileProduct('{{ $mobileProductId }}', this)">
                    @if(!empty($product->images) && isset($product->images[0]->url))
                        <img class="mp-card-img"
                             src="{{ asset($product->images[0]->url) }}"
                             alt="Product Image">
                    @else
                        <div class="mp-card-img"></div>
                    @endif

                    <div class="mp-card-title-wrap">
                        <div class="mp-card-title">
                            {{ $product->product_name }}
                        </div>

                        @if(!empty($product->manufacturer))
                            <div class="mp-card-subtitle">
                                {{ $product->manufacturer }}
                            </div>
                        @endif
                    </div>

                    <span class="mp-card-qty">
                        Qty {{ $totalQty }}
                    </span>

                    <i class="fa fa-chevron-right mp-card-chevron"></i>
                </div>

                <div class="mp-card-body" id="{{ $mobileProductId }}">
                    @forelse($sizeGroups as $sizeId => $sizeDetails)
                        @php
                            $firstDetail = $sizeDetails->first();

                            $sizeName = optional($firstDetail->SizeDetails)->size_name
                                ?? ($sizeId === 'none' ? 'No Size' : 'Size ' . $sizeId);

                            $sizeQty = $sizeDetails->sum('qty');

                            $safeSizeId = preg_replace(
                                '/[^A-Za-z0-9_-]/',
                                '_',
                                (string) $sizeId
                            );

                            $mobileSizeId = 'mobile_size_' . $productId . '_' . $safeSizeId;
                        @endphp

                        <div class="mp-size-group">
                            <div class="mp-size-header"
                                 onclick="toggleMobileSize('{{ $mobileSizeId }}', this); event.stopPropagation();">
                                <div class="mp-size-left">
                                    <i class="fa fa-chevron-right mp-size-chevron"></i>
                                    <span class="mp-size-name">{{ $sizeName }}</span>
                                </div>

                                <span class="mp-size-qty">
                                    Qty {{ $sizeQty }}
                                </span>
                            </div>

                            <div class="mp-size-body" id="{{ $mobileSizeId }}">
                                @foreach($sizeDetails as $detail)
                                    <div class="mp-detail-row view-order"
                                         data-store-order-item-id="{{ $detail->store_order_item_id ?? '-' }}"
                                         data-item-detail-id="{{ $detail->id ?? '-' }}">
                                        <div class="mp-detail-grid">
                                            <div>
                                                <div class="mp-detail-label">Name</div>
                                                <div class="mp-detail-value">
                                                    {{ $isNameAvailable
                                                        ? ($detail->player_name ?? '-')
                                                        : 'N/A' }}
                                                </div>
                                            </div>

                                            <div>
                                                <div class="mp-detail-label">Number</div>
                                                <div class="mp-detail-value">
                                                    {{ $isNumberAvailable
                                                        ? ($detail->player_number ?? '-')
                                                        : 'N/A' }}
                                                </div>
                                            </div>

                                            <div>
                                                <div class="mp-detail-label">Qty</div>
                                                <div class="mp-detail-value">
                                                    {{ $detail->qty ?? 0 }}
                                                </div>
                                            </div>

                                            <div>
                                                <div class="mp-detail-label">Total</div>
                                                <div class="mp-detail-value">
                                                    ${{ number_format((float) ($detail->total_amount ?? 0), 2) }}
                                                </div>
                                            </div>

                                            <div>
                                                <div class="mp-detail-label">Paid</div>
                                                <div class="mp-detail-value">
                                                    ${{ number_format((float) ($detail->paid_amount ?? 0), 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="empty-size-message">
                            No size details are available for this product.
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function toggleProductRow(panelId, rowEl) {
        const panel = document.getElementById(panelId);

        if (!panel) {
            return;
        }

        const isOpen = panel.style.display === 'table-row';

        panel.style.display = isOpen ? 'none' : 'table-row';

        const icon = rowEl.querySelector('.product-toggle-icon');

        if (icon) {
            icon.classList.toggle('open', !isOpen);
        }
    }

    function toggleSizeRow(panelId, headerEl) {
        const panel = document.getElementById(panelId);

        if (!panel) {
            return;
        }

        const isOpen = panel.classList.contains('open');

        panel.classList.toggle('open', !isOpen);

        const icon = headerEl.querySelector('.size-toggle-icon');

        if (icon) {
            icon.classList.toggle('open', !isOpen);
        }
    }

    function toggleMobileProduct(panelId, headerEl) {
        const panel = document.getElementById(panelId);

        if (!panel) {
            return;
        }

        const isOpen = panel.classList.contains('open');

        panel.classList.toggle('open', !isOpen);

        const icon = headerEl.querySelector('.mp-card-chevron');

        if (icon) {
            icon.classList.toggle('open', !isOpen);
        }
    }

    function toggleMobileSize(panelId, headerEl) {
        const panel = document.getElementById(panelId);

        if (!panel) {
            return;
        }

        const isOpen = panel.classList.contains('open');

        panel.classList.toggle('open', !isOpen);

        const icon = headerEl.querySelector('.mp-size-chevron');

        if (icon) {
            icon.classList.toggle('open', !isOpen);
        }
    }

    $(document).on('click', '.download-as-exel', function (e) {
        e.preventDefault();

        $(".se-pre-con").fadeIn("slow");

        const safetyTimer = setTimeout(function () {
            $(".se-pre-con").fadeOut("slow");
        }, 8000);

        $.ajax({
            url: "{{ route('store.product_report.download') }}",
            type: 'GET',
            data: {
                store_id: "{{ $store->id }}"
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data, status, xhr) {
                clearTimeout(safetyTimer);

                const disposition = xhr.getResponseHeader('Content-Disposition');
                let filename = 'product_report.csv';

                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition
                        .split('filename=')[1]
                        .replace(/"/g, '');
                }

                const blob = new Blob([data], {
                    type: 'text/csv'
                });

                const link = document.createElement('a');

                link.href = window.URL.createObjectURL(blob);
                link.download = filename;

                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                $(".se-pre-con").fadeOut("slow");
            },
            error: function () {
                clearTimeout(safetyTimer);
                $(".se-pre-con").fadeOut("slow");

                console.error('Failed to download product report.');
            }
        });
    });

    $(document).on('click', '.download-as-pdf', function (e) {
        e.preventDefault();

        $(".se-pre-con").fadeIn("slow");

        const safetyTimer = setTimeout(function () {
            $(".se-pre-con").fadeOut("slow");
        }, 8000);

        $.ajax({
            url: "{{ route('store.product_report.pdf') }}",
            type: 'GET',
            data: {
                store_id: "{{ $store->id }}"
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data, status, xhr) {
                clearTimeout(safetyTimer);

                const disposition = xhr.getResponseHeader('Content-Disposition');
                let filename = 'product_report.pdf';

                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition
                        .split('filename=')[1]
                        .replace(/"/g, '');
                }

                const blob = new Blob([data], {
                    type: 'application/pdf'
                });

                const link = document.createElement('a');

                link.href = window.URL.createObjectURL(blob);
                link.download = filename;

                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                $(".se-pre-con").fadeOut("slow");
            },
            error: function () {
                clearTimeout(safetyTimer);
                $(".se-pre-con").fadeOut("slow");

                console.error('Failed to download product report PDF.');
            }
        });
    });

    $(document).on('click', '.view-order', function (e) {
        e.stopPropagation();

        const storeOrderItemId = $(this).data('store-order-item-id');
        const itemDetailId = $(this).data('item-detail-id');

        $(".se-pre-con").fadeIn("slow");

        $.ajax({
            url: "{{ route('store.product_report.get_order_no') }}",
            type: 'GET',
            data: {
                store_order_item_id: storeOrderItemId
            },
            success: function (response) {
                $(".se-pre-con").fadeOut("slow");

                if (response) {
                    const baseUrl = "{{ route('store.individual_player', '') }}";
                    const redirectedUrl =
                        baseUrl +
                        '/' +
                        response.order_no +
                        '/?item_detail_id=' +
                        itemDetailId;

                    window.open(redirectedUrl, '_blank');
                } else {
                    swal(
                        'Error',
                        'Unable to retrieve order details.',
                        'error'
                    );
                }
            },
            error: function () {
                $(".se-pre-con").fadeOut("slow");

                swal(
                    'Error',
                    'An error occurred while fetching order details.',
                    'error'
                );
            }
        });
    });
</script>

@endsection

@section('content')
    @include('pages.stores.layouts.sidebar', ['sub_content' => 'overview'])
@endsection
