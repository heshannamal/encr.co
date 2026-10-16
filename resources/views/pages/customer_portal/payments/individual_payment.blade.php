@extends('pages.customer_portal.layouts.sidebar', ['sub_active' => 'orders'])

@section('sub-sidebar-content')
<style>
    .no-spinner::-webkit-inner-spin-button,
    .no-spinner::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    .no-spinner {
    -moz-appearance: textfield;
    }
    @media (max-width: 768px) {
        #pay-selected-btn{
            width:100%;
        }
    }

    @media (max-width: 767.98px) {

    /* =========================================
       CARD
       ========================================= */

    .order-table-wrapper {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .order-table-wrapper .card,
    .order-table-wrapper .card-body,
    .customer-table,
    .table-responsive {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }

    .order-table-wrapper .card-body {
        padding: 10px !important;
    }

    .table-responsive {
        overflow: visible !important;
    }


    /* =========================================
       TABLE RESET
       ========================================= */

    .mobile-order-table {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        border: 0 !important;
    }

    .mobile-order-table thead {
        display: block !important;
        width: 100% !important;
    }

    .mobile-order-table thead tr {
        display: block !important;
        width: 100% !important;
    }

    /* Hide all headers */
    .mobile-order-table thead th {
        display: none !important;
    }

    /* Only Select All */
    .mobile-order-table thead th:first-child {
        display: block !important;
        width: 100% !important;
        border: 0 !important;
        padding: 0 0 10px 2px !important;
    }


    /* =========================================
       TBODY
       ========================================= */

    .mobile-order-table tbody {
        display: block !important;
        width: 100% !important;
    }


    /* =========================================
       ORDER CARD
       ========================================= */

    .mobile-order-table tbody tr.order-table-row {
        display: grid !important;

        width: 100% !important;
        max-width: 100% !important;

        box-sizing: border-box !important;

        /*
         * 3 columns:
         * checkbox | order number | payment status
         */
        grid-template-columns: 28px minmax(0, 1fr) auto;

        /* grid-template-columns: 50% 50%; */
        /*
         * Every item is initially in its own row.
         */
        grid-auto-flow: row;

        margin: 0 0 15px 0 !important;
        padding: 15px !important;

        background: #fff;

        border: 1px solid #e5e7eb !important;
        border-radius: 14px !important;

        overflow: hidden !important;
        gap: 12px 5px;
    }


    /* =========================================
       RESET ALL TD
       ========================================= */

    .mobile-order-table tbody tr.order-table-row > td {
        box-sizing: border-box !important;
        border: 0 !important;
        margin: 0 !important;
        min-width: 0 !important;
    }


    /* =========================================
       ROW 1
       CHECKBOX | ORDER NUMBER | PAYMENT STATUS
       ========================================= */


    .mobile-order-table .order-checkbox-cell {
        display: flex !important;

        grid-column: 1;
        grid-row: 1;

        width: auto !important;

        align-items: center;
        justify-content: flex-start;

        padding: 0 !important;

        margin: 0 !important;
    }

    .mobile-order-table .order-checkbox-cell .order-checkbox {
        display: block !important;

        width: 17px;
        height: 17px;

        margin: 0 !important;
    }


    /* Order Number */
    .mobile-order-table .order-number-cell {
        display: flex !important;

        grid-column: 2 / 38;
        grid-row: 1;

        width: auto !important;
        min-width: 0 !important;

        align-items: center;

        padding: 0 8px !important;
        margin: 0 !important;

        font-size: 15px;
        font-weight: 700;

        overflow: hidden;
    }

    .mobile-order-table .order-number-cell a {
        display: block;

        max-width: 100%;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;

        text-decoration: none;
        font-weight: 700;
    }


    /* Payment Status - RIGHT */
    .mobile-order-table .payment-status-cell {
        display: flex !important;

        grid-column: 39;
        grid-row: 1;

        width: auto !important;

        align-items: center;
        justify-content: flex-end;

        padding: 0 !important;
        margin: 0 !important;

        white-space: nowrap;
    }

    .mobile-order-table .payment-status-cell .lable-table {
        font-size: 10px;
        line-height: 1;

        padding: 6px 8px;

        white-space: nowrap;
    }

    /* =========================================
   ROW 2
   SALES REP | OPEN DATE
   ========================================= */

    .mobile-order-table .sales-rep-cell,
    .mobile-order-table .open-date-cell {
        position: relative !important;
        box-sizing: border-box !important;

        margin-top: 18px !important;

        font-size: 13px;
        min-width: 0;
    }


    /* Sales Rep - LEFT 50% */
    .mobile-order-table .sales-rep-cell {
        grid-column: 1 / 30;
        grid-row: 2;

        width: 50% !important;
        max-width: 50% !important;

        padding: 0 8px 0 0 !important;
    }


    /* Open Date - RIGHT 50% */
    .mobile-order-table .open-date-cell {
        grid-column: 30 / 25;
        grid-row: 2;

        width: 50% !important;
        max-width: 50% !important;

        margin-left: 50% !important;

        margin-top: -18px !important;

        padding: 0 0 0 8px !important;
    }


    /* =========================================
       LABELS
       ========================================= */

    .mobile-order-table td[data-label]::before {
        content: attr(data-label);

        display: block;

        margin-bottom: 5px;

        font-size: 10px;
        line-height: 1.2;

        font-weight: 600;

        color: #8b8f98;

        text-transform: uppercase;
        letter-spacing: .3px;
    }


    /* =========================================
       ROW 3
       SALES TAX
       ========================================= */

    .mobile-order-table .sales-tax-cell {
        display: block !important;

        grid-column: 1 / 4;
        grid-row: 3;

        width: auto !important;

        margin-top: 18px !important;
        padding: 14px 0 0 0 !important;

        border-top: 1px solid #eeeeee !important;

        font-size: 13px;
    }


    /* =========================================
       ROW 4
       TOTAL | ORDER VIEW | PAYMENT
       ========================================= */

    .mobile-order-table .total-cell {
        display: block !important;

        grid-column: 1 / 2;
        grid-row: 4;

        width: auto !important;

        margin-top: 18px !important;
        padding: 0 !important;

        font-size: 15px;
        font-weight: 700;
    }


    .mobile-order-table .action-cell {
        display: flex !important;

        grid-column: 40 / 4;
        grid-row: 4;

        width: auto !important;

        margin-top: 18px !important;
        padding: 0 !important;

        justify-content: flex-end;
        align-items: flex-end;

        gap: 5px;

        min-width: 0;
    }


    /* =========================================
       ACTION BUTTONS
       ========================================= */

    .mobile-order-table .action-cell .btn {
        display: inline-flex !important;

        align-items: center;
        justify-content: center;

        padding: 6px 8px !important;

        font-size: 10px;
        line-height: 1.2;

        white-space: nowrap;
    }

    .mobile-order-table .order-view-btn {
        display: inline-flex !important;

        align-items: center;
        justify-content: center;

        gap: 3px;
    }

    .mobile-order-table .order-view-btn .material-icons-outlined {
        font-size: 15px;
    }
    .order-table-wrapper .card, .order-table-wrapper .card-body, .customer-table, .table-responsive {
        background-color: transparent;
    }
    .table-light tr th {
        background-color: transparent;
    }
    .select-all-checkbox {
        height: 29px;
        min-height: 20px;
        width: 20px;
    }
}

@media (max-width: 767.98px) {

    .mobile-order-table thead th:first-child {
        display: block !important;
        width: 100% !important;
        padding: 0 0 10px 2px !important;
        border: none !important;
    }

    .select-all-checkbox {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        margin: 0 !important;
    }

    .mobile-order-table thead th:first-child::after {
        content: "All Select";
        display: inline-block;

        margin-left: 7px;

        font-size: 13px;
        font-weight: 500;
        color: #555;

        vertical-align: middle;
    }
}

.swal2-close {
    font-size: 28px !important;
    font-weight: 400 !important;
    color: #6c757d !important;

    width: 40px !important;
    height: 40px !important;

    line-height: 40px !important;

    transition: all 0.2s ease;
    display: block !important;
}

.swal2-close:hover {
    color: #dc3545 !important;
    transform: rotate(90deg);
}

</style>

<div class="row">
    <!--breadcrumb-->
    <div class="col page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><a href="{{ route('customer_portal.dashboard') }}" class="text-decoration-none" style="color: unset;"> HOME</a></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">INDIVIDUAL PAYMENTS</li>
                </ol>
            </nav>
        </div>
    </div>
     @if(session('error'))
        <div class="alert alert-danger border-0 bg-grd-danger alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><span class="material-icons-outlined fs-2">report_gmailerrorred</span>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Error</h6>
                    <div class="text-white"> {{ session('error') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!--end breadcrumb-->
    <div class="col d-md-flex d-grid align-items-center gap-3 justify-content-end mb-3 col-12">
        <button type="button" id="pay-selected-btn" class="btn btn-success px-4">Pay All Orders</button>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-12 d-flex mb-4 order-table-wrapper">
        <div class="card  w-100">
            <div class="card-body">
                <div class="customer-table">
                    <div class="table-responsive white-space-nowrap">
                        <table class="table align-middle mobile-order-table">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select-all" class="select-all-checkbox">
                                    </th>
                                    <th>Order No</th>
                                    <th>Sales Rep</th>
                                    <th>Open Date</th>
                                    <th>Payment Status</th>
                                    <th>Sales Tax $</th>
                                    <th>Total $</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    @php
                                        $status = $order->payment_status['payment_status'] ?? 0;
                                        if ($order->payment_status['payment_status'] == 0) {
                                            $payment_status = "PENDING";
                                            $payment_bg_color = 'bg-danger-subtle text-danger border-danger-subtle';
                                        } elseif ($order->payment_status['payment_status'] == 1) {
                                            $payment_status = "PARTIAL";
                                            $payment_bg_color = 'bg-warning-subtle text-warning border-warning-subtle';
                                        }  elseif ($order->payment_status['payment_status'] == 2)  {
                                            $payment_status = "PAID";
                                            $payment_bg_color = 'bg-success-subtle text-success border-success-subtle';
                                        } else {
                                            $payment_status = "PENDING";
                                            $payment_bg_color = 'bg-danger-subtle text-danger border-danger-subtle';
                                        }
                                    @endphp
                                    <tr class="order-table-row">
                                        <td class="order-checkbox-cell">
                                            <input class="form-check-input order-checkbox" data-amount="{{$order->payment_status['balance_to_be_paid']}}" @if($status == 2) disabled @endif type="checkbox" value="{{ $order->id }}">
                                        </td>
                                        <td class="order-number-cell">
                                            <a href="{{ route('customer_portal.order_view', ['id' => $order->id]) }}">{{ $order->order_no }}</a>

                                        </td>
                                        <td  class="sales-rep-cell" data-label="Sales Rep">{{ $order->userDetails->name ?? ''}}</td>
                                        <td  class="open-date-cell" data-label="Open Date">{{$order->open_date ?? ''}}</td>
                                        <td  class="payment-status-cell"><span
                                            class="lable-table {{$payment_bg_color}} rounded border  font-text2 fw-bold">{{$payment_status}}</span></td>
                                        <td class="sales-tax-cell" data-label="Sales Tax">{{ number_format($order->sales_tax, 2) }}</td>
                                        <td class="total-cell" data-label="Total">{{ number_format($order->order_total, 2) }}</td>
                                        <td class="action-cell">
                                            <a href="{{ route('customer_portal.order_view', ['id' => $order->id]) }}"
                                            class="btn btn-outline-secondary btn-sm order-view-btn">
                                                <span class="material-icons-outlined">visibility</span>
                                                <span>Order View</span>
                                            </a>
                                            @if ($status != 2)
                                                <a href="{{ route('customer_portal.payment_edit', ['orderId' => $order->id]) }}" class="btn btn btn-success  btn-sm">Pay</a>
                                            @else
                                            <a href="{{ route('customer_portal.payment_edit', ['orderId' => $order->id]) }}" class="btn btn-secondary btn-sm">Paid</a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--end row-->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.order-checkbox');
    const payButton = document.getElementById('pay-selected-btn');

    const PAY_ALL_TEXT = 'Pay All Orders';
    let isProcessing = false; // 🔒 Prevent double clicks

    /* =========================
        Helpers
    ========================== */
    function getPayableCheckboxes() {
        return Array.from(checkboxes).filter(cb => !cb.disabled);
    }

    function getCheckedCheckboxes() {
        return Array.from(checkboxes).filter(cb => cb.checked);
    }

    function calculateTotal(list) {
        return list.reduce((sum, cb) => {
            return sum + parseFloat(cb.dataset.amount || 0);
        }, 0).toFixed(2);
    }

    /* =========================
        Button State
    ========================== */
    function updateButtonState() {
        const payableCount = getPayableCheckboxes().length;

        if (payableCount === 0) {
            payButton.disabled = true;
            payButton.textContent = 'Paid in Full';
            payButton.classList.add('disabled');
            return;
        }

        payButton.disabled = false;
        updatePayButtonText();
    }

    function updatePayButtonText() {
        const checkedCount = getCheckedCheckboxes().length;

        if (checkedCount > 1) {
            payButton.textContent = `Pay Selected Orders (${checkedCount})`;
        } else {
            payButton.textContent = PAY_ALL_TEXT;
        }
    }

    /* =========================
        Select All
    ========================== */
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => {
                if (!cb.disabled) cb.checked = this.checked;
            });
            updatePayButtonText();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            updatePayButtonText();
        });
    });

    /* =========================
        Pay Button Click
    ========================== */
    payButton.addEventListener('click', function () {
        if (isProcessing) return;

        const checked = getCheckedCheckboxes();
        const payable = getPayableCheckboxes();

        /* ===== PAY ALL (0 or 1 selected) ===== */
        if (checked.length <= 1) {
            const totalAmount = calculateTotal(payable);

            Swal.fire({
                title: 'Pay all orders?',
                showCloseButton: true,
                closeButtonHtml: '&times;',
                html: `
                    <div style="font-size:15px">
                        <p>This will pay <b>${payable.length}</b> orders.</p>
                        <hr>
                        <p><strong>Total Amount:</strong></p>
                        <h3 style="color:#198754">$ ${totalAmount}</h3>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Pay All',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                allowOutsideClick: false
            }).then(result => {
                if (!result.isConfirmed) return;

                isProcessing = true;

                Swal.fire({
                    title: 'Processing Payment...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                payable.forEach(cb => cb.checked = true);

                const ids = payable.map(cb => cb.value);

                window.location.href =
                    `{{ route('customer_portal.pay_multiple_orders') }}?order_ids=${ids.join(',')}`;
            });

            return;
        }

        /* ===== PAY SELECTED (2+) ===== */
        const totalAmount = calculateTotal(checked);

        Swal.fire({
            title: 'Pay selected orders?',
            html: `
                <div style="font-size:15px">
                    <p>You selected <b>${checked.length}</b> orders.</p>
                    <hr>
                    <p><strong>Total Amount:</strong></p>
                    <h3 style="color:#0d6efd">$ ${totalAmount}</h3>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Pay Selected',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            allowOutsideClick: false
        }).then(result => {
            if (!result.isConfirmed) return;

            isProcessing = true;

            Swal.fire({
                title: 'Processing Payment...',
                html: `<strong>Total:</strong> $ ${totalAmount}`,
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            const selectedIds = checked.map(cb => cb.value);

            window.location.href =
                `{{ route('customer_portal.pay_multiple_orders') }}?order_ids=${selectedIds.join(',')}`;
        });
    });

    /* =========================
        Init
    ========================== */
    updateButtonState();
});
</script>






@endsection
