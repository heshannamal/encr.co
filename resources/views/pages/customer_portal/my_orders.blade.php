@extends('pages.customer_portal.layouts.sidebar', ['sub_active' => 'orders'])

@section('sub-sidebar-content')

    <style>
        .btn{
            --bs-btn-padding-x: 0.45rem;
            --bs-btn-padding-y: 0.075rem;
            margin: 4px;
        }
        /* MOBILE STYLING */
@media (max-width: 768px) {
    /* Stack table elements */
    #shipmentModalBody table,
    #shipmentModalBody thead,
    #shipmentModalBody tbody,
    #shipmentModalBody tfoot,
    #shipmentModalBody tr,
    #shipmentModalBody td {
        display: block;
        width: 100%;
    }

    #shipmentModalBody thead {
        display: none; /* Hide headers on mobile */
    }

    #shipmentModalBody tr {
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    /* Standard cell layout: Label on left, Value on right */
    #shipmentModalBody td {
        text-align: right;
        padding-left: 50% !important;
        position: relative;
        border: none !important;
    }

    #shipmentModalBody td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        width: 45%;
        text-align: left;
        font-weight: 700;
        color: #666;
    }

    /* FIX: FULL WIDTH TOTAL ROW */
    #shipmentModalBody tfoot tr.total-row td.desktop-td {
        display: none !important;
    }

    #shipmentModalBody tfoot tr.total-row td.mobile-td {
        display: block !important;
        width: 100% !important;
        padding-left: 0 !important; /* Remove the 50% gap */
        text-align: center !important; /* Center the text */
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6 !important;
        padding: 15px 0 !important;
    }

    /* Ensure no label appears before the Total text */
    #shipmentModalBody tfoot tr.total-row td.mobile-td::before {
        content: none !important;
    }
}

/* =========================================================
   MOBILE - MY ORDERS RESPONSIVE LAYOUT
   No HTML structure / ID / JS changes required
========================================================= */

@media (max-width: 768px) {

    /* =====================================================
       1. BREADCRUMB
    ===================================================== */

    .page-breadcrumb {
        display: flex !important;
        width: 100% !important;
        margin-bottom: 12px !important;
        align-items: center !important;
        overflow: hidden !important;
    }

    .page-breadcrumb .breadcrumb-title {
        padding-right: 8px !important;
        font-size: 12px !important;
        white-space: nowrap !important;
    }

    .page-breadcrumb .ps-3 {
        padding-left: 8px !important;
        min-width: 0 !important;
    }

    .page-breadcrumb .breadcrumb {
        font-size: 12px !important;
        white-space: nowrap !important;
    }


    /* =====================================================
       2. SEARCH
    ===================================================== */

    .row.g-3 {
        width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        row-gap: 12px !important;
    }

    .row.g-3 > .col-12.col-lg-4.col-xxl-5 {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    #orderSearch {
        width: 100% !important;
        min-height: 42px !important;
        font-size: 14px !important;
    }


    /* =====================================================
       3. PRODUCT COUNT / FILTERS
    ===================================================== */

    .product-count {
        width: 100% !important;

        display: flex !important;

        flex: 0 0 100% !important;
        max-width: 100% !important;

        margin-left: 0 !important;

        justify-content: flex-start !important;
        align-items: center !important;

        gap: 8px 16px !important;

        padding: 2px 0 4px !important;

        overflow: visible !important;
    }

    .product-count a {
        font-size: 12px !important;

        white-space: nowrap !important;

        line-height: 20px !important;
    }


    /* =====================================================
       4. MAIN CARD CONTAINER
    ===================================================== */

    .card.mt-4 {
        margin-top: 12px !important;

        width: 100% !important;

        background: transparent !important;

        border: none !important;

        box-shadow: none !important;
    }

    .card.mt-4 > .card-body {
        padding: 0 !important;
    }

    .customer-table {
        width: 100% !important;
    }


    /* =====================================================
       5. TABLE RESPONSIVE WRAPPER
    ===================================================== */

    .customer-table .table-responsive {
        overflow: visible !important;
        width: 100% !important;
    }


    /* =====================================================
       6. TABLE
    ===================================================== */

    .customer-table table {
        width: 100% !important;

        border-collapse: separate !important;

        border-spacing: 0 !important;

        white-space: normal !important;

        display: block !important;
    }


    /* =====================================================
       7. HIDE TABLE HEADER
    ===================================================== */

    /* .customer-table table thead {
        display: none !important;
    } */

    /* Table header keep only Select All checkbox */
    .customer-table table thead {
        display: table-header-group !important;
    }

    .customer-table table thead tr {
        display: block !important;
        width: 100% !important;
        height: 35px !important;
        margin-bottom: 8px !important;
    }

    /* Hide all header columns */
    .customer-table table thead tr th {
        display: none !important;
    }

    /* Show ONLY first header column */
    .customer-table table thead tr th:first-child {
        display: block !important;

        width: 100% !important;
        height: 35px !important;

        padding: 5px 0 !important;

        border: none !important;

        background: transparent !important;

        text-align: left !important;
    }

    /* Select All checkbox */
    .customer-table table thead tr th:first-child .form-check-input {
        display: block !important;

        width: 18px !important;
        height: 18px !important;

        margin: 0 !important;

        cursor: pointer !important;
    }


    /* =====================================================
       8. SELECT ALL CHECKBOX

       The first checkbox should remain visible separately.
    ===================================================== */

    .customer-table table tbody {
        display: block !important;

        width: 100% !important;
    }



    /* =====================================================
       9. EACH ORDER = CARD
    ===================================================== */

    .customer-table table tbody tr {
        display: grid !important;

        width: 100% !important;

        grid-template-columns: 1fr 1fr !important;

        grid-template-rows:
            auto
            auto
            auto
            auto
            auto !important;

        column-gap: 15px !important;
        row-gap: 10px !important;

        position: relative !important;

        margin-bottom: 12px !important;
        padding: 13px !important;

        background: #fff !important;

        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;

        white-space: normal !important;
    }


    /* =====================================================
       ALL TD RESET
    ===================================================== */

    .customer-table table tbody tr td {
        display: block !important;

        padding: 0 !important;
        margin: 0 !important;

        border: none !important;

        min-width: 0 !important;

        background: transparent !important;

        white-space: normal !important;
    }


    /* =====================================================
       1ST ROW

       Checkbox + Order Number  |  Status
                                  Payment Status
    ===================================================== */

    /* Checkbox */
    .customer-table table tbody tr td:nth-child(1) {
        grid-column: 1 !important;
        grid-row: 1 !important;

        display: flex !important;

        align-items: center !important;

        width: auto !important;
    }

    .customer-table table tbody tr td:nth-child(1) .form-check-input {
        width: 17px !important;
        height: 17px !important;

        margin: 0 8px 0 0 !important;
    }


    /* Order number */
    .customer-table table tbody tr td:nth-child(2) {
        grid-column: 1 !important;
        grid-row: 1 !important;

        /* padding-left: 25px !important; */

        align-self: center !important;

        font-size: 14px !important;

        font-weight: 700 !important;

        pointer-events: none !important;
    }

    .customer-table table tbody tr td:nth-child(2) a {
        pointer-events: auto !important;

        text-decoration: none !important;
    }


    /* Order Status */
.customer-table table tbody tr td:nth-child(3) {
    grid-column: 2 !important;
    grid-row: 1 !important;

    display: flex !important;
    justify-content: flex-end !important;
    align-items: flex-start !important;
    text-align: right !important;
}

/* Payment Status */
.customer-table table tbody tr td:nth-child(8) {
    grid-column: 2 !important;
    grid-row: 1 !important;

    display: flex !important;
    justify-content: flex-end !important;
    align-items: flex-start !important;
    text-align: right !important;

    margin-top: 27px !important;
}


    /* =====================================================
       2ND ROW

       Open:                 Est:
       date                  date
    ===================================================== */

    /* Open Date */
    .customer-table table tbody tr td:nth-child(4) {
        grid-column: 1 !important;
        grid-row: 2 !important;

        padding-top: 8px !important;

        font-size: 11px !important;

        color: #6b7280 !important;
    }

    .customer-table table tbody tr td:nth-child(4)::before {
        content: "Open:" !important;

        display: block !important;

        margin-bottom: 2px !important;

        font-size: 10px !important;

        font-weight: 600 !important;

        color: #495057 !important;
    }


    /* Est Date */
    .customer-table table tbody tr td:nth-child(5) {
        grid-column: 2 !important;
        grid-row: 2 !important;

        padding-top: 8px !important;

        font-size: 11px !important;

        color: #6b7280 !important;

        /* text-align: right !important; */
    }

    .customer-table table tbody tr td:nth-child(5)::before {
        content: "Est Delivery:" !important;

        display: block !important;

        margin-bottom: 2px !important;

        font-size: 10px !important;

        font-weight: 600 !important;

        color: #495057 !important;

        /* text-align: right !important; */
    }


    /* =====================================================
       3RD ROW

       Total                    Sales Rep
       $1,250.00                👤 John
    ===================================================== */

    /* Total */
    .customer-table table tbody tr td:nth-child(7) {
        grid-column: 1 !important;
        grid-row: 3 !important;

        padding-top: 5px !important;

        font-size: 14px !important;

        font-weight: 700 !important;

        color: #198754 !important;

        text-align: left !important;
    }

    .customer-table table tbody tr td:nth-child(7)::before {
        content: "Total" !important;

        display: block !important;

        margin-bottom: 2px !important;

        font-size: 10px !important;

        font-weight: 600 !important;

        color: #495057 !important;
    }


    /* Sales Rep */
    .customer-table table tbody tr td:nth-child(6) {
        grid-column: 2 !important;
        grid-row: 3 !important;

        padding-top: 5px !important;

        font-size: 12px !important;

        color: #6b7280 !important;

        /* text-align: right !important; */

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;
    }

    .customer-table table tbody tr td:nth-child(6)::before {
        content: "Sales Rep" !important;

        display: block !important;

        margin-bottom: 2px !important;

        font-size: 10px !important;

        font-weight: 600 !important;

        color: #495057 !important;
    }



    /* =====================================================
       4TH ROW

       Description
       ...
    ===================================================== */

    .customer-table table tbody tr td:nth-child(9) {
        grid-column: 1 / 3 !important;
        grid-row: 4 !important;

        padding-top: 5px !important;

        font-size: 11px !important;

        color: #6b7280 !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;
    }

    .customer-table table tbody tr td:nth-child(9)::before {
        content: "Description" !important;

        display: block !important;

        margin-bottom: 3px !important;

        font-size: 10px !important;

        font-weight: 600 !important;

        color: #495057 !important;
    }


    /* =====================================================
       5TH ROW

                         👁 Shipping Info
                              [View]
    ===================================================== */

    .customer-table table tbody tr td:nth-child(10) {
        grid-column: 1 / 3 !important;
        grid-row: 5 !important;

        display: flex !important;

        flex-direction: column !important;

        justify-content: flex-end !important;

        align-items: flex-end !important;

        padding-top: 5px !important;

        text-align: right !important;
    }


    /* View button */
    .customer-table table tbody tr td:nth-child(10) .btn {
        padding: 4px 16px !important;

        min-width: 70px !important;

        font-size: 11px !important;

        line-height: 1.4 !important;
    }


    /* =====================================================
       BADGES
    ===================================================== */

    .customer-table .lable-table {
        display: inline-block !important;

        padding: 4px 8px !important;

        font-size: 9px !important;

        line-height: 1.2 !important;

        white-space: nowrap !important;
        width: 85px;
        text-align: center;
    }


    /* =====================================================
       PREVENT OVERFLOW
    ===================================================== */

    .customer-table,
    .customer-table .table-responsive {
        width: 100% !important;

        overflow: visible !important;
    }

    .customer-table table {
        width: 100% !important;

        display: block !important;

        white-space: normal !important;
    }

    .customer-table table tbody {
        display: block !important;

        width: 100% !important;
    }
    .mobile_margin_top {

    }

    /* =====================================================
       PREVENT HORIZONTAL PAGE SCROLL
    ===================================================== */

    body {
        overflow-x: hidden !important;
    }

    .main-content {
        overflow-x: hidden !important;
    }
}

@media (max-width: 768px) {

    .customer-table table tbody tr[style*="display: none"] {
        display: none !important;
    }

    .customer-table table tbody tr:not([style*="display: none"]) {
        display: grid !important;
    }
    .customer-table table tbody tr.mobile-filter-hidden {
        display: none !important;
    }
    .modal.show .modal-dialog {
        padding: 5%;
        padding-top: 80px;
    }
    #shipmentModal {
        width: 100%;
        height: 100%;
        z-index: 99999;
    }

}

.shipment-summary-mobile {
    display: none;
}

.shipment-summary-desktop {
    display: inline;
}


/* Mobile */
@media (max-width: 767.98px) {

    .shipment-summary-mobile {
        display: inline;
    }

    .shipment-summary-desktop {
        display: none;
    }

}

.order-filter {
    color: #6c757d;
    text-decoration: none;
    transition: all 0.2s ease;
}

.order-filter:hover {
    color: #0d6efd;
    text-decoration: none;
}

.order-filter.active {
    color: #0d6efd !important;
    font-weight: 600;
}

.order-filter.active .text-secondary {
    color: #0d6efd !important;
}

    </style>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><a href="{{ route('customer_portal.dashboard') }}" class="text-decoration-none" style="color: unset;"> HOME</a></div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
            </ol>
        </nav>
    </div>
</div>
    <!--breadcrumb-->
    {{-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Components</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Products</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Settings</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
								<a class="dropdown-item" href="javascript:;">Another action</a>
								<a class="dropdown-item" href="javascript:;">Something else here</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div>
				<!--end breadcrumb--> --}}



    <div class="row g-3">
        <div class="col-12 col-lg-4 col-xxl-5">
            <div class="position-relative">
                <input class="form-control px-5" type="search" placeholder="Search Orders" id="orderSearch">
                <span
                    class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
            </div>
        </div>
        <div class="col-auto product-count d-flex align-items-center gap-3 gap-lg-4 fw-medium flex-wrap font-text1 justify-content-end ms-auto">
        {{-- <a href="javascript:;"><span class="me-1">All</span><span class="text-secondary">({{ $statusCounts['all'] }})</span></a>
        <a href="javascript:;"><span class="me-1">Pending Payment</span><span class="text-secondary">({{ $paymentCounts['pending'] }})</span></a>
        <a href="javascript:;"><span class="me-1">Quote</span><span class="text-secondary">({{ $statusCounts['quote'] }})</span></a>
        <a href="javascript:;"><span class="me-1">Production</span><span class="text-secondary">({{ $statusCounts['production'] }})</span></a>
        <a href="javascript:;"><span class="me-1">Fulfilled</span><span class="text-secondary">({{ $statusCounts['fulfilled'] }})</span></a> --}}

        <a href="javascript:;" class="order-filter" data-filter="all"><span class="me-1">All</span><span class="text-secondary">({{ $statusCounts['all'] }})</span></a>
        <a href="javascript:;" class="order-filter" data-filter="pending_payment"><span class="me-1">Pending Payment</span><span class="text-secondary">({{ $paymentCounts['pending'] }})</span></a>
        <a href="javascript:;" class="order-filter" data-filter="QUOTE"><span class="me-1">Quote</span><span class="text-secondary">({{ $statusCounts['quote'] }})</span></a>
        <a href="javascript:;" class="order-filter" data-filter="PRODUCTION"><span class="me-1">Production</span><span class="text-secondary">({{ $statusCounts['production'] }})</span></a>
        <a href="javascript:;" class="order-filter" data-filter="FULFILLED"><span class="me-1">Fulfilled</span><span class="text-secondary">({{ $statusCounts['fulfilled'] }})</span></a>
        {{-- <a href="javascript:;"><span class="me-1">Failed</span><span class="text-secondary">(42)</span></a> --}}
    </div>
    </div><!--end row-->

    <div class="card mt-4">
        <div class="card-body">
            <div class="customer-table">
                <div class="table-responsive white-space-nowrap">
                    <table class="table align-middle table-responsive" style="white-space: nowrap;">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    {{-- <input class="form-check-input" type="checkbox"> --}}
                                </th>
                                <th>Order#</th>
                                <th>Status</th>
                                <th>Open Date</th>
                                <th>Est Date</th>
                                <th>Sales Rep</th>
                                <th>Total $</th>
                                <th>Payment Status</th>
                                <th>Description</th>
                                <th>Shipping Info</th>
                            </tr>
                        </thead>
                        <tbody id="orderTableBody">
                            @foreach ($orders as $order)
                                @php
                                    if ($order->order_status_id == 1) {
                                        $order_status = 'QUOTE';
                                        $bg_color = 'bg-warning-subtle text-warning';
                                        $icon = 'bi-info-circle';
                                    } elseif ($order->order_status_id == 2) {
                                        $order_status = 'INVOICE';
                                        $bg_color = '#0f9f00';
                                        $color = '#b0ffc4';
                                        $icon = 'bi-info-circle';
                                    } elseif ($order->order_status_id == 3) {
                                        $order_status = 'PRODUCTION';
                                        $bg_color = 'bg-primary-subtle text-primary';
                                        $icon = 'bi-check2';
                                    } elseif ($order->order_status_id == 4) {
                                        $order_status = 'FULFILLED';
                                        $bg_color = 'bg-success-subtle text-success';
                                        $icon = 'bi-check2';
                                    } elseif ($order->order_status_id == 5) {
                                        $order_status = 'SHIPPED';
                                        $bg_color = '#0f9f00';
                                        $color = '#b0ffc4';
                                        $icon = 'bi-info-circle';
                                    } elseif ($order->order_status_id == 6) {
                                        $order_status = 'DELIVERED';
                                        $bg_color = '#0f9f00';
                                        $color = '#b0ffc4';
                                        $icon = 'bi-info-circle';
                                    } else {
                                        $order_status = 'CANCELED';
                                        $bg_color = '#0f9f00';
                                        $color = '#b0ffc4';
                                        $icon = 'bi-info-circle';
                                    }
                                @endphp
                                @php
                            if ($payments[$order->id]['paymentStatus'] == 0) {
                                $payment_status = "PENDING";
                                $payment_bg_color = 'bg-danger-subtle text-danger border-danger-subtle';
                            } elseif ($payments[$order->id]['paymentStatus'] == 1) {
                                $payment_status = "PARTIAL";
                                $payment_bg_color = 'bg-warning-subtle text-warning border-warning-subtle';
                            }  elseif ($payments[$order->id]['paymentStatus'] == 2)  {
                                $payment_status = "PAID";
                                $payment_bg_color = 'bg-success-subtle text-success border-success-subtle';
                            } else {
                                $payment_status = "PENDING";
                                $payment_bg_color = 'bg-danger-subtle text-danger border-danger-subtle';
                            }
                        @endphp
                                <tr data-status="{{ $order_status }}" data-payment="{{ in_array($payment_status, ['PENDING', 'PARTIAL']) ? 'pending_payment' : 'paid' }}">
                                    <td style="">
                                        {{-- <input class="form-check-input" type="checkbox"> --}}
                                    </td>
                                    <td style="padding:2px">
                                        <a href="{{ route('customer_portal.order_view', ['id' => $order->id]) }}">{{ $order->order_no }}</a>
                                    </td>
                                    <td style="padding:2px"><span class="lable-table {{ $bg_color }} rounded border border-success-subtle font-text2 fw-bold">{{ $order_status }}</span>
                                    </td>
                                    <td style="padding:2px">{{$order->open_date ?? ''}}</td>
                                    <td style="padding:2px">{{ $order->est_delivery_date ?? '' }}</td>
                                    <td style="padding:2px">{{ $users->where('id', $order->user_id)->first()->name ?? ''}}</td>
                                    <td style="padding:2px">{{ number_format($order->order_total, 2) }}</td>
                                    <td style="padding:2px" class="mobile_margin_top"><span
                                        class="lable-table {{$payment_bg_color}} rounded border  font-text2 fw-bold">{{$payment_status}}</span></td>
                                    <td style="padding:2px">{{ strlen($order->order_description) > 30 ? substr($order->order_description, 0, 30) . '...' : $order->order_description }}</td>
                                    {{-- <td style="padding:2px"><button type="button" class="btn btn-inverse-info px-5" onclick="redirectToSummary('{{$order->id}}')">View Shipment Summary</button></td> --}}
                                    <td style="padding:2px">
                                        <button type="button"
                                                class="btn btn-inverse-info px-5"
                                                onclick="redirectToSummary('{{$order->id}}')">

                                            <span class="shipment-summary-mobile">View Shipment Summary</span>
                                            <span class="shipment-summary-desktop">View</span>

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


    <div class="modal fade" id="shipmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shipment Summary</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="shipmentModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).on('click', '.order-filter', function () {

        // Remove active from all filters
        $('.order-filter').removeClass('active');

        // Add active to clicked filter
        $(this).addClass('active');

    });
</script>

<script>
    function redirectToSummary(orderId) {
       $('#shipmentModal').modal('show');
    $('#shipmentModalBody').html(`
        <div class="text-center py-5">
            <div class="spinner-border"></div>
        </div>
    `);


    $.ajax({
         url: "{{ route('customer_portal.shipment_summary_view_ajax', ':id') }}".replace(':id', orderId),
        type: 'GET',
        success: function (res) {
            $('#shipmentModalBody').html(buildShipmentHTML(res.shipments));
        },
        error: function () {
            $('#shipmentModalBody').html(`
                <div class="alert alert-danger">No shipment found</div>
            `);
        }
    });
    }

function buildShipmentHTML(shipments) {

    let html = '';

    shipments.forEach((data, shipmentIndex) => {

        let lastProduct = null;
        let rows = '';
        let totalOrdered = 0;
        let totalShipped = 0;

        // 🔹 Build item rows per shipment
        data.items.forEach(item => {
            const showProduct = item.name !== lastProduct;
            lastProduct = item.name;

            rows += `
                <tr>
                    <td data-label="ITEM">
                        ${showProduct ? item.name : `<span class="d-md-none text-muted">${item.name}</span>`}
                    </td>
                    <td data-label="SIZE">${item.size}</td>
                    <td data-label="ORDERED QTY" class="text-end">${item.ordered_qty}</td>
                    <td data-label="SHIPPED QTY" class="text-end">${item.shipped_qty}</td>
                </tr>
            `;

            totalOrdered += item.ordered_qty;
            totalShipped += item.shipped_qty;
        });

        // 🔹 Received badge
        let receivedRow = '';
        if (data.received_at) {
            receivedRow = `
                <div class="row mb-2">
                    <div class="col-4 text-muted">Status</div>
                    <div class="col-8">
                        <span class="badge bg-success">
                            ✓ Received on ${data.received_at}
                        </span>
                    </div>
                </div>
            `;
        }

        // 🔹 Shipment block
        html += `
            <div class="shipment-block mb-4">
                <h6 class="fw-bold mb-3">
                    Shipment ${shipmentIndex + 1}
                </h6>

                <div class="row mb-2">
                    <div class="col-4 text-muted">Tracking ID</div>
                    <div class="col-8">${data.tracking_no}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-4 text-muted">Tracking Link</div>
                    <div class="col-8">
                        <a href="${data.tracking_link}" target="_blank" class="text-success fw-bold">
                            CLICK HERE
                        </a>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-4 text-muted">Courier Service</div>
                    <div class="col-8">${data.Courier_Service}</div>
                </div>

                ${receivedRow}

                <h6 class="fw-bold mt-4">ITEM LIST</h6>

                <table class="table table-bordered mt-2">
                    <thead class="table-secondary">
                        <tr>
                            <th>ITEM</th>
                            <th>SIZE</th>
                            <th class="text-end">ORDERED QTY</th>
                            <th class="text-end">SHIPPED QTY</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rows}
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold bg-light total-row">
                            <td class="desktop-td"></td>
                            <td class="desktop-td"></td>
                            <td class="text-end desktop-td">
                                TOTAL Ordered: ${totalOrdered}
                            </td>
                            <td class="text-end desktop-td">
                                TOTAL Shipped: ${totalShipped}
                            </td>

                            <td class="mobile-td" colspan="4" style="display:none;">
                                TOTAL Ordered: ${totalOrdered} | Shipped: ${totalShipped}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            ${shipmentIndex < shipments.length - 1 ? '<hr>' : ''}
        `;
    });

    return html;
}



document.getElementById('orderSearch').addEventListener('keyup', function() {
    let searchText = this.value.toLowerCase();
    let rows = document.querySelectorAll('#orderTableBody tr');

    rows.forEach(row => {
        let rowText = row.innerText.toLowerCase();

        if (rowText.includes(searchText)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
document.querySelectorAll('.order-filter').forEach(filter => {
    filter.addEventListener('click', function () {

        let filterType = this.dataset.filter;
        let rows = document.querySelectorAll('#orderTableBody tr');

        rows.forEach(row => {

            let status = row.dataset.status;
            let payment = row.dataset.payment;

            // if (filterType === 'all') {
            //     row.style.display = "";
            // }
            // else if (filterType === 'pending_payment') {
            //     row.style.display = payment === 'pending_payment' ? "" : "none";
            // }
            // else {
            //     row.style.display = status === filterType ? "" : "none";
            // }

            if (filterType === 'all') {
                row.style.display = "";
                row.classList.remove('mobile-filter-hidden');
            }
            else if (filterType === 'pending_payment') {
                if (payment === 'pending_payment') {
                    row.style.display = "";
                    row.classList.remove('mobile-filter-hidden');
                } else {
                    row.style.display = "none";
                    row.classList.add('mobile-filter-hidden');
                }
            }
            else {
                if (status === filterType) {
                    row.style.display = "";
                    row.classList.remove('mobile-filter-hidden');
                } else {
                    row.style.display = "none";
                    row.classList.add('mobile-filter-hidden');
                }
            }

        });
    });
});
</script>

@endsection
