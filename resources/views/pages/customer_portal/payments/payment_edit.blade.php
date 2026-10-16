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
    .paymentSummaryTable thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .paymentSummaryTable tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .paymentSummaryTable{
        width: 100%;
    }
    .paymentSummaryTable th, .paymentSummaryTable td {
        padding: 10px;
    }
    .btn-success:disabled {
    color: #fff;
    border-color: #787878;
    background-color: #787878;
    }
    .uploaded-checks {
        /* width: 130px !important; */
        height: 100px;
        overflow: hidden;
    }
    .uploaded-checks img {
        max-width: 100%;
        max-height: 100%;
    }

/* ---------- MOBILE VIEW ---------- */
@media (max-width: 768px) {
    .paymentSummaryTable thead {
        display: none;
    }

    .paymentSummaryTable,
    .paymentSummaryTable tbody,
    .paymentSummaryTable tr,
    .paymentSummaryTable td,
    .paymentSummaryTable tfoot {
        display: block;
        width: 100%;
    }

    .paymentSummaryTable tr {
        margin-bottom: 15px;
        background: #fff;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .paymentSummaryTable td {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border: none;
        font-size: 13px;
    }

    .paymentSummaryTable td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #555;
    }

    .paymentSummaryTable tfoot {
        margin-top: 15px;
        background: #f8f8f8;
        padding: 10px;
        border-radius: 8px;
    }

    .paymentSummaryTable tfoot th {
        display: flex;
        justify-content: space-between;
        width: 100%;
        font-size: 14px;
    }
}
.custom-modal-close-dark {
    background: transparent !important;
    border: 0 !important;
    color: #333 !important;
    font-size: 28px !important;
    line-height: 1 !important;
    font-weight: 400 !important;
    padding: 0 !important;
    margin-left: auto !important;
    cursor: pointer !important;
    opacity: 1 !important;
    box-shadow: none !important;
    outline: none !important;
}

.custom-modal-close-dark:hover {
    color: #dc3545 !important;
}
@media (max-width: 767px) {
    .techpack-responsive-table {
        border: 0 !important;
    }

    .techpack-responsive-table thead {
        display: none;
    }

    .techpack-responsive-table,
    .techpack-responsive-table tbody,
    .techpack-responsive-table tr,
    .techpack-responsive-table td {
        display: block;
        width: 100%;
    }

    .techpack-responsive-table tr {
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        margin-bottom: 12px;
        padding: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .techpack-responsive-table td {
        border: 0 !important;
        padding: 8px 0 !important;
        text-align: left !important;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        color: #333;
    }

    .techpack-responsive-table td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #555;
        min-width: 85px;
        flex-shrink: 0;
    }

    .techpack-responsive-table td:first-child {
        display: block;
        border-bottom: 1px solid #eee !important;
        padding-bottom: 10px !important;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .techpack-responsive-table td:first-child::before {
        display: block;
        margin-bottom: 4px;
    }

    .techpack-responsive-table .view-file-btn {
        white-space: nowrap;
        font-size: 12px;
        padding: 4px 10px;
    }
}

@media (max-width: 768px) {
    .mobile_bc_none {
        background-color: transparent;
    }
    .mobile_margin_bottom_unset {
        margin-bottom: unset !important;
    }
    .mobile_padding_unset {
        padding: unset !important;
    }
    .page-breadcrumb.d-none.d-sm-flex {
        display: flex !important;
    }
    .mobile_main_div {
        background-color: transparent;
        margin-bottom: unset;
        box-shadow: unset;
        margin-top: unset !important;
    }
    .mobile_padding_b_unset {
        padding-bottom: unset;
    }
    .mobile_padding_l_r {
        padding: 0px 1.7rem;
    }
    .mobile_margin_top_unset {
        margin-top: unset !important;
    }
    #venmo_payments, #paypal_payments{
        background-color: white;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
    }
    .modal {
        z-index: 99999;
    }
}
@media (max-width: 768px) {

    button[data-bs-target="#PaymentHistoryModal"] {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 7px !important;

        padding: 8px 14px !important;

        color: #555 !important;
        background: #f8f9fa !important;

        border: 1px solid #e3e5e8 !important;
        border-radius: 8px !important;

        outline: none !important;

        font-size: 11px !important;
        font-weight: 700 !important;
        letter-spacing: 0.3px !important;

        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06) !important;

        transition: all 0.2s ease !important;
    }

    button[data-bs-target="#PaymentHistoryModal"]::before {
        content: "↻" !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        line-height: 1 !important;
    }

    button[data-bs-target="#PaymentHistoryModal"]:active {
        transform: scale(0.97) !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08) !important;
    }

}
</style>
@if(session('success_msg'))
        <div class="alert alert-success border-0 bg-grd-success alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><span class="material-icons-outlined fs-2">check_circle</span>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Success</h6>
                    <div class="text-white"> {{ session('success_msg') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        {{-- <div class="alert alert-success fade in alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="font-size:20px">×</span>
            </button>
            {{ session('success_msg') }}
        </div> --}}
    @endif

    @if(session('error_msg'))
        <div class="alert alert-danger border-0 bg-grd-danger alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><span class="material-icons-outlined fs-2">report_gmailerrorred</span>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Error</h6>
                    <div class="text-white"> {{ session('error_msg') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        {{-- <div class="alert alert-danger fade in alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="font-size:20px">×</span>
            </button>
            {{ session('error_msg') }}
        </div> --}}
    @endif
    <!-- @if(session('payment_success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Payment Submitted',
                text: 'Your payment has been successfully submitted. Our account department will now proceed with the approval process.',
                confirmButtonText: 'Ok',
            });
        </script>
         <li><strong>Production Changes:</strong> Once an order enters production, any requested changes must be submitted within <strong>48 hours</strong>. After this period, changes may not be possible due to the custom production process.</li>
    @endif -->
    @if(session('payment_success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Payment Submitted',
                html: `
                    <p>Your payment has been successfully submitted. Our account department will now proceed with the approval process.</p>
                    <hr style="margin: 16px 0;">
                    <div style="text-align: left; font-size: 0.875rem; color: #444;">
                        <p style="font-weight: 700; margin-bottom: 10px;">⚠️ Important Order Information</p>
                        <ul style="padding-left: 18px; margin: 0; line-height: 1.8;">
                            <li><strong>Order Changes:</strong> AOnce payment is submitted, your order is considered final and is released to production. No changes or additions can be made after this point. If you have any questions or need additional items, please contact your sales representative.</li>

                            <li><strong>Custom-Made Items:</strong>  All products are custom made to order. Once an order enters production, <strong>All sales are final</strong> No refunds, cancellations, or changes are permitted.</li>
                        </ul>
                    </div>
                `,
                confirmButtonText: 'I Understand',
                width: '600px',
            });
        </script>
    @endif
    @if(session('po_order_success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Purchase Order Confirmed',
                text: 'Your purchase order has been successfully submitted. Our accounts department will now proceed with the approval process.',
                confirmButtonText: 'Ok',
            });
        </script>
    @endif
<!--breadcrumb-->
<div class="page-breadcrumb d-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><a href="{{ route('customer_portal.dashboard') }}" class="text-decoration-none"> HOME</a></div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">PAYMENTS</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->



        <div class="row">
            <div class="col-12 col-lg-8 d-flex mb-4 mobile_margin_bottom_unset">
                <div class="card mt-4 w-100 mobile_bc_none mobile_margin_bottom_unset mobile_main_div">
                    <div class="card-body mobile_padding_b_unset">
                        <div class="row justify-content-end">
                                <div class="col-md-3 ml-auto d-flex justify-content-end">
                                    <button type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#PaymentHistoryModal"
                                        style="color: #b3b3b3; background-color: white; border: none; outline: unset; font-weight: 600; cursor: pointer; position: relative;">
                                        PAYMENT HISTORY
                                    </button>
                                </div>
                            </div>
								<ul class="nav nav-tabs nav-success" role="tablist">
									<li class="nav-item" role="presentation">
										<a class="nav-link active" data-bs-toggle="tab" href="#Card_payments" role="tab" aria-selected="true">
											<div class="d-flex align-items-center">
												<div class="tab-icon">
												</div>
												<div class="tab-title">Card</div>
											</div>
										</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#check_payments" role="tab" aria-selected="false" tabindex="-1">
											<div class="d-flex align-items-center">
												<div class="tab-icon">
												</div>
												<div class="tab-title">Check</div>
											</div>
										</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#venmo_payments" role="tab" aria-selected="false" tabindex="-1">
											<div class="d-flex align-items-center">
												<div class="tab-icon">
												</div>
												<div class="tab-title">Venmo</div>
											</div>
										</a>
									</li>
                                    <li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#paypal_payments" role="tab" aria-selected="false" tabindex="-1">
											<div class="d-flex align-items-center">
												<div class="tab-icon">
												</div>
												<div class="tab-title">Paypal</div>
											</div>
										</a>
									</li>
                                    <li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#po_payments" role="tab" aria-selected="false" tabindex="-1">
											<div class="d-flex align-items-center">
												<div class="tab-icon">
												</div>
												<div class="tab-title">PO</div>
											</div>
										</a>
									</li>
                                    {{-- <li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#other_payments" role="tab" aria-selected="false" tabindex="-1">
											<div class="d-flex align-items-center">
												<div class="tab-icon">
												</div>
												<div class="tab-title">Other</div>
											</div>
										</a>
									</li> --}}
								</ul>
								<div class="tab-content py-3 mobile_margin_bottom_unset mobile_padding_b_unset">
									<div class="tab-pane fade show active" id="Card_payments" role="tabpanel">

										<div class="row p-1">
                                            <div class="col-12 col-lg-12 d-flex px-1">
                                                <div class="card w-100 border mobile_margin_bottom_unset">
                                                    <div class="card-body">
                                                        @if ($paymentStatus == 0 || $paymentStatus == 1)
                                                            <form id="payment-card-info" method="post" action="{{ route("customer_payment.online") }}">
                                                                @csrf
                                                                <div class="row p-1 ">
                                                                    <h4>Billing Details</h4>
                                                                    <div class="col-md-4 col-6">
                                                                        <label for="input1" class="form-label">First Name</label>
                                                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{$orderDetails->contactDetails['first_name']}}" required>
                                                                    </div>
                                                                    <div class="col-md-4 col-6">
                                                                        <label for="input1" class="form-label">Last Name</label>
                                                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{$orderDetails->contactDetails['last_name']}}" required >
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">Country</label>
                                                                        <input type="text" class="form-control" id="country" name="country" value="{{$orderDetails->organizationDetails['billing_country']}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">State</label>
                                                                        <input type="text" class="form-control" id="state" name="state" value="{{$orderDetails->organizationDetails['billing_state']}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">Street Address</label>
                                                                        <input type="text" class="form-control" id="street" name="street" value="{{$orderDetails->organizationDetails['billing_street']}}" required>
                                                                    </div>
                                                                    <div class="col-md-4 col-6">
                                                                        <label for="input1" class="form-label">City</label>
                                                                        <input type="text" class="form-control" id="city" name="city" value="{{$orderDetails->organizationDetails['billing_city']}}" required>
                                                                    </div>
                                                                    <div class="col-md-4 col-6">
                                                                        <label for="input1" class="form-label">Postal Code</label>
                                                                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{$orderDetails->organizationDetails['billing_postal_code']}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">Email</label>
                                                                        <input type="email" class="form-control" id="email" name="email" value="{{$orderDetails->email}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">Phone No</label>
                                                                        <input type="text" class="form-control" id="phone" name="phone" value="{{$orderDetails->phone_no}}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row p-1 ">
                                                                    <h4>Card Details</h4>
                                                                    <div class="col-md-6">
                                                                        <label for="input1" class="form-label">Name on Card</label>
                                                                        <input type="text" class="form-control" id="owner" name="owner" value="{{ old('owner') }}" placeholder="Card Owner's Name" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="input1" class="form-label">Card Number</label>
                                                                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="{{ old('cardNumber') }}" placeholder="Card Number" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="row  ">
                                                                            <div class="col-md-8 col-6">
                                                                                <label for="input1" class="form-label">Expiration Date</label>
                                                                                <div class="row  ">
                                                                                    <div class="col-md-6 col-6">

                                                                                        <select class="form-control mr-2" id="expiration-month" name="expiration-month">
                                                                                            @foreach($months as $k=>$v)
                                                                                            <option value="{{ $k }}" {{ old('expiration-month') == $k ? 'selected' : '' }}>{{ $v }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6 col-6">
                                                                                        <select class="form-control" id="expiration-year" name="expiration-year">
                                                                                            @for($i = date('Y'); $i <= (date('Y') + 15); $i++)
                                                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                                                            @endfor
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 col-6">
                                                                                <label for="input1" class="form-label">CVV</label>
                                                                                <input type="password" class="form-control" id="cvv" name="cvv" value="{{ old('cvv') }}" placeholder="CVV" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="input1" class="form-label">Payment Amount ($)</label>
                                                                        <input type="text" class="form-control" onchange="updatePaymentDetails(this)" value="{{number_format(($orderDetails->order_total - $payment), 2)}}">
                                                                    </div>
                                                                    <div class="col-md-6 col-6">
                                                                        <label for="input1" class="form-label">Card Processing Fee (3%) ($)</label>
                                                                        <input type="text" class="form-control" name="card_fee" id="card_processing_fee_showing" value="{{number_format((($orderDetails->order_total - $payment)/100*3), 2)}}" readonly />
                                                                        <input type="hidden" class="form-control" id="card_processing_fee" value="{{($orderDetails->order_total - $payment)/100*3}}">
                                                                    </div>
                                                                    <div class="col-md-6 col-6">
                                                                        <label for="input1" class="form-label">Amount ($)</label>
                                                                        <input type="number" class="form-control card_payment_amount" id="amount" name="amount" min="0" value="{{ sprintf("%.2f", ($orderDetails->order_total - $payment) + (($orderDetails->order_total - $payment) / 100 * 3)) }}" readonly/>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                                                <input type="hidden" class="form-control" id="company" name="company" value="{{$orderDetails->organizationDetails['organization_name']}}"/>
                                                                <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                                                <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                                                <input type="hidden" name="shipping" value="{{ $shipping }}">
                                                                <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                                                <input type="hidden" name="artwork" value="{{ $artwork }}">
                                                                <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                                                                <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                                                <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                                            </form>
                                                        @else
                                                        <div>
                                                            <div class="col-md-12">
                                                                @if($cardPayments->count()  > 0)
                                                                <div class="row mt-2 mb-2" style="font-size: 1.2rem; color:green; font-weight:600; margin-left:1px">
                                                                    <i class="fas fa-check-circle">  Order Already Paid</i>

                                                                </div>
                                                                <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                                                    Card Payments
                                                                </div>

                                                                <table class="paymentSummaryTable ">
                                                                    <thead>
                                                                        <th>TRANSACTION ID</th>
                                                                        <th>NAME</th>
                                                                        <th>DATE</th>
                                                                        <th>TIME</th>
                                                                        <th class="text-right">AMOUNT</th>
                                                                    </thead>
                                                                    @if ($cardPayments->isEmpty())
                                                                    @else
                                                                    <tbody>
                                                                        @foreach ($cardPayments as $cardPayment)
                                                                            <tr>
                                                                                <td data-label="Transaction ID">{{ $cardPayment->transaction_id }}</td>
                                                                                <td data-label="Name">{{ $cardPayment->name_on_card }}</td>
                                                                                <td data-label="Date">{{ $cardPayment->created_at->format('m-d-Y') }}</td>
                                                                                <td data-label="Time">{{ $cardPayment->created_at->format('H:i:s') }}</td>
                                                                                <td data-label="Amount" class="text-right">
                                                                                    $ {{ number_format($cardPayment->amount, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    @endif
                                                                    <tfoot>
                                                                        <th colspan="4">Total Amount</th>
                                                                        <th class="text-right">$ {{number_format($cardAmount, 2)}}</th>
                                                                    </tfoot>
                                                                </table>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="tab-pane fade" id="check_payments" role="tabpanel">
										<div class="row p-1">
                                            <div class="col-12 col-lg-12 d-flex px-1">
                                                <div class="card w-100 border">
                                                    <div class="card-body">
                                                        @if ($paymentStatus == 0 || $paymentStatus == 1)
                                                        @if($checkPayments->where('is_approved', 0)->count() > 0)
                                                             <div style="padding-left: 1rem;padding-right: 1rem;">
                                                            <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                                                Check Payments to approve
                                                            </div>
                                                            <table class="paymentSummaryTable">
                                                                <thead>
                                                                    <th>CHECK FRONT</th>
                                                                    <th>CHECK BACK</th>
                                                                    <th>DATE</th>
                                                                    <th>TIME</th>
                                                                    <th>PAID AMOUNT ($)</th>
                                                                    <th>TOTAL AMOUNT ($)</th>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($checkPayments as $checkPayment)
                                                                                @if($checkPayment->is_approved == 0)
                                                                                <tr>
                                                                                    <td data-label ="CHECK FRONT" class="uploaded-checks">
                                                                                        <a href="{{asset('uploads')}}/../{{$checkPayment->check_front}}" download="{{$orderDetails->order_no}}-check-front.{{ pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) }}">
                                                                                            @if(pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) == 'pdf')
                                                                                                <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                                            @else
                                                                                                <img src="{{asset('uploads')}}/../{{$checkPayment->check_front}}" />
                                                                                            @endif
                                                                                        </a>
                                                                                    </td>
                                                                                    <td data-label ="CHECK BACK" class="uploaded-checks">
                                                                                        <a href="{{asset('uploads')}}/../{{$checkPayment->check_back}}" download="{{$orderDetails->order_no}}-check-back.{{ pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) }}">
                                                                                            @if(pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) == 'pdf')
                                                                                                <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                                            @else
                                                                                                <img src="{{asset('uploads')}}/../{{$checkPayment->check_back}}" />
                                                                                            @endif
                                                                                        </a>
                                                                                    </td>
                                                                                    <td data-label ="DATE" style="vertical-align: middle;">{{$checkPayment->created_at->format('m-d-Y')}}</td>
                                                                                    <td data-label ="TIME" style="vertical-align: middle;">{{$checkPayment->created_at->format('H:m:s')}}</td>
                                                                                    <td data-label ="PAID AMOUNT ($)" style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->customer_paid_amount, 2)}}</td>
                                                                                    <td data-label ="TOTAL AMOUNT ($)" style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->amount, 2)}}</td>
                                                                                </tr>
                                                                                @endif
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                            </div>
                                                        @else

                                                        <form id="payment-check-info" method="post" action="{{ route("customer_payment.check") }}" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row p-1 ">
                                                                <div class="col-md-6">
                                                                    <label for="input1" class="form-label">Please indicate the amount that has been paid.*</label>
                                                                    <input type="number" class="form-control"  name="check_customer_paid_amount"  value="{{number_format(($orderDetails->order_total - $payment), 2)}}" id="check_customer_paid_amount" step="0.01" required>
                                                                </div>
                                                            </div>
                                                            <div class="row p-1 ">
                                                                <div class="col-md-6">
                                                                    <label for="input1" class="form-label">Front Side Of Your Check Uploaded</label>
                                                                    <div id="check_front_preview">
                                                                        <img src="{{asset('argon')}}/img/icons/check.png" style="width: 100%; opacity: 0.5;" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="input1" class="form-label">Back Side Of Your Check Uploaded</label>
                                                                    <div id="check_back_preview">
                                                                        <img src="{{asset('argon')}}/img/icons/check.png" style="width: 100%; opacity: 0.5;" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row p-1 ">
                                                                <div class="col-md-6">
                                                                    <label class="form-lable">Front Side Of Your Check <span class="text-danger">*</span></label>
                                                                    <input type="file" style="display: none" class="form-control" name="check_front" id="check_front" onchange="encodeFrontFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />

                                                                    <label for="check_front" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3;">
                                                                        <i class="fas fa-cloud-upload-alt" style="font-size: 30px;"></i><br>
                                                                        Drag & drop your file here or <b>CLICK HERE</b>  to upload the front side of your check
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-lable">Back Side Of Your Check <span class="text-danger">*</span></label>
                                                                    <input type="file"style="display: none" class="form-control" name="check_back" id="check_back" onchange="encodeBackFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />


                                                                    <label for="check_back" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3;">
                                                                        <i class="fas fa-cloud-upload-alt" style="font-size: 30px;"></i><br>
                                                                        Drag & drop your file here or <b>CLICK HERE</b>  to upload the back side of your check
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                                            <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                                            <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                                            <input type="hidden" name="shipping" value="{{ $shipping }}">
                                                            <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                                            <input type="hidden" name="artwork" value="{{ $artwork }}">
                                                            <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                                                            <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                                            <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                                        </form>
                                                        @endif
                                                        @else
                                                        <div>
                                                            <div class="col-md-12">

                                                                @if($checkPayments->count()  > 0)
                                                                <div class="row mt-2 mb-2" style="font-size: 1.2rem; color:green; font-weight:600; margin-left:1px">
                                                                    <i class="fas fa-check-circle">  Order Already Paid</i>
                                                                </div>
                                                                <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                                                    Check Payments
                                                                </div>
                                                                <table class="paymentSummaryTable">
                                                                    <thead>
                                                                        <th>CHECK FRONT</th>
                                                                        <th>CHECK BACK</th>
                                                                        <th>DATE</th>
                                                                        <th>TIME</th>
                                                                        <th>PAID AMOUNT ($)</th>
                                                                        <th>TOTAL AMOUNT ($)</th>
                                                                    </thead>
                                                                    @if ($checkPayments->isEmpty())
                                                                    @else
                                                                    <tbody>
                                                                    @foreach ($checkPayments as $checkPayment)
                                                                                    @if($checkPayment->is_approved !== 0)
                                                                                    <tr>
                                                                                        <td data-label ="CHECK FRONT" class="uploaded-checks">
                                                                                            <a href="{{asset('uploads')}}/../{{$checkPayment->check_front}}" download="{{$orderDetails->order_no}}-check-front.{{ pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) }}">
                                                                                                @if(pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) == 'pdf')
                                                                                                    <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                                                @else
                                                                                                    <img src="{{asset('uploads')}}/../{{$checkPayment->check_front}}" />
                                                                                                @endif
                                                                                            </a>
                                                                                        </td>
                                                                                        <td data-label ="CHECK BACK" class="uploaded-checks">
                                                                                            <a href="{{asset('uploads')}}/../{{$checkPayment->check_back}}" download="{{$orderDetails->order_no}}-check-back.{{ pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) }}">
                                                                                                @if(pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) == 'pdf')
                                                                                                    <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                                                @else
                                                                                                    <img src="{{asset('uploads')}}/../{{$checkPayment->check_back}}" />
                                                                                                @endif
                                                                                            </a>
                                                                                        </td>
                                                                                        <td data-label ="DATE" style="vertical-align: middle;">{{$checkPayment->created_at->format('m-d-Y')}}</td>
                                                                                        <td data-label ="TIME" style="vertical-align: middle;">{{$checkPayment->created_at->format('H:m:s')}}</td>
                                                                                        <td data-label ="PAID AMOUNT ($)" style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->customer_paid_amount, 2)}}</td>
                                                                                        <td data-label ="TOTAL AMOUNT ($)" style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->amount, 2)}}</td>
                                                                                    </tr>
                                                                                    @endif
                                                                    @endforeach
                                                                    </tbody>
                                                                    @endif
                                                                    <tfoot>
                                                                        <th colspan="4">Total Amount</th>
                                                                        <th class="text-right">$ {{number_format($checkAmount, 2)}}</th>
                                                                        <td></td>
                                                                    </tfoot>
                                                                </table>
                                                                @endif

                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
									</div>
									<div class="tab-pane fade" id="venmo_payments" role="tabpanel">
                                        @if ($paymentStatus == 0 || $paymentStatus == 1)
                                            @if($venmoPayments->where('is_approved', 0)->count() > 0)
                                                <div style="padding-left: 1rem;padding-right: 1rem;">
                                                <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                                    Venmo Payments to approve
                                                </div>
                                                <table class="paymentSummaryTable">
                                                    <thead>
                                                        <th>VENMO RECIPT</th>
                                                        <th>DATE</th>
                                                        <th>TIME</th>
                                                        <th class="text-right">CUST. PAID AMOUNT</th>
                                                        <th class="text-right">AMOUNT</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($venmoPayments as $venmoPayment)
                                                            @if($venmoPayment->is_approved == 0)
                                                            <tr>
                                                                <td data-label ="VENMO RECIPT" class="uploaded-checks">
                                                                    <a href="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}" download="{{$orderDetails->order_no}}-venmo-receipt.{{ pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) }}">
                                                                        @if(pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                                            <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                        @else
                                                                            <img src="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}" />
                                                                        @endif
                                                                    </a>
                                                                </td>
                                                                <td data-label ="DATE" style="vertical-align: middle;">{{$venmoPayment->created_at->format('m-d-Y')}}</td>
                                                                <td data-label ="TIME" style="vertical-align: middle;">{{$venmoPayment->created_at->format('H:m:s')}}</td>
                                                                <td data-label ="CUST. PAID AMOUNT" style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->customer_paid_amount, 2)}}</td>
                                                                <td data-label ="AMOUNT" style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->amount, 2)}}</td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            @else
                                                <form id="payment-venmo-info" method="post" action="{{ route("customer_payment.venmo") }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row p-1 ">
                                                        <div class="col-md-12">
                                                            <h6 for="input1" class="form-label">Please Use Our Venmo Handle - "@Encore-custom"</h6>

                                                        </div>
                                                    </div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-6">
                                                            <label class="form-lable">Please indicate the amount that has been paid.<span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" name="venmo_customer_paid_amount" id="venmo_customer_paid_amount" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" step="0.01" required/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-lable">Uploaded Venmo Receipt</label>
                                                            <div id="venmo_receipt_preview">
                                                                <img src="{{asset('argon')}}/img/icons/check.png" style="width: auto; opacity: 0.5;max-height: 200px;" />
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-12">
                                                            <label class="form-lable">Upload Venmo Receipt<span class="text-danger">*</span></label>
                                                            <input type="file" style="display: none" class="form-control" style="height: calc(7.5rem + 1px) !important;" name="venmo_receipt" id="venmo_receipt" onchange="encodeVenmoFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                                                            <label for="venmo_receipt" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3;">
                                                                <i class="fas fa-cloud-upload-alt" style="font-size: 36px;"></i><br>
                                                                Drag & drop your file here or <b>CLICK HERE</b>  to upload venmo recipt
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                                    <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                                    <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                                                    <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                                    <input type="hidden" name="artwork" value="{{ $artwork }}">
                                                    <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                                                    <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                                    <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                                </form>
                                            @endif
                                        @else
                                                <div>
                                                    <div class="col-md-12">

                                                        @if($venmoPayments->count()  > 0)
                                                        <div class="row mt-2 mb-2" style="font-size: 1.2rem; color:green; font-weight:600; margin-left:1px">
                                                            <i class="fas fa-check-circle">  Order Already Paid</i>
                                                        </div>
                                                        <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                                            Venmo Payments
                                                        </div>
                                                        <table class="paymentSummaryTable">
                                                            <thead>
                                                                <th>VENMO RECIPT</th>
                                                                <th>DATE</th>
                                                                <th>TIME</th>
                                                                <th class="text-right">CUST. PAID AMOUNT</th>
                                                                <th class="text-right">AMOUNT</th>
                                                                <th class="text-center">APPROVE</th>
                                                            </thead>
                                                            @if ($venmoPayments->isEmpty())
                                                                <tbody>
                                                                    <tr>
                                                                        <td>No Records</td>
                                                                    </tr>
                                                                </tbody>
                                                            @else
                                                            <tbody>
                                                                @foreach ($venmoPayments as $venmoPayment)
                                                                    @if($venmoPayment->is_approved !== 0)
                                                                    <tr>
                                                                        <td data-label ="VENMO RECIPT" class="uploaded-checks">
                                                                            <a href="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}" download="{{$orderDetails->order_no}}-venmo-receipt.{{ pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) }}">
                                                                                @if(pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                                                    <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                                @else
                                                                                    <img src="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}" />
                                                                                @endif
                                                                            </a>
                                                                        </td>
                                                                        <td data-label ="DATE" style="vertical-align: middle;">{{$venmoPayment->created_at->format('m-d-Y')}}</td>
                                                                        <td data-label ="TIME" style="vertical-align: middle;">{{$venmoPayment->created_at->format('H:m:s')}}</td>
                                                                        <td data-label ="CUST. PAID AMOUNT" style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->customer_paid_amount, 2)}}</td>
                                                                        <td data-label ="AMOUNT" style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->amount, 2)}}</td>
                                                                        <td data-label ="APPROVE" style="vertical-align: middle;" class="text-center">
                                                                            @if ($venmoPayment->is_approved == 0)
                                                                                <button type="button" class="btn btn-info btn-sm btn-custom approve-venmo" value="{{$venmoPayment->id}}" data-toggle="modal" data-target="#exampleModalVenmo">Approve</button>
                                                                            @elseif($venmoPayment->is_approved == 1)
                                                                            <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true">&nbsp;&nbsp;Approved</i></button>
                                                                            @else
                                                                            <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true">&nbsp;&nbsp;Rejected</i></button>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                            @endif
                                                            <tfoot>
                                                                <th colspan="3">Total Amount</th>
                                                                <th class="text-right">$ {{number_format($venmoAmount, 2)}}</th>
                                                                <td></td>
                                                            </tfoot>
                                                        </table>
                                                        @endif

                                                    </div>
                                                </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="paypal_payments" role="tabpanel">
                                        @if ($paymentStatus == 0 || $paymentStatus == 1)
                                             @if($paypalPayments->where('is_approved', 0)->count() > 0)
                                                <div style="padding-left: 1rem;padding-right: 1rem;">
                                                <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                                    Paypal Payments to approve
                                                </div>
                                                <table class="paymentSummaryTable">
                                                    <thead>
                                                        <th>PAYPAL RECEIPT</th>
                                                        <th>DATE</th>
                                                        <th>TIME</th>
                                                        <th class="text-right">AMOUNT</th>
                                                        <th class="text-center">APPROVE</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($paypalPayments as $paypalPayment)
                                                        @if($paypalPayment->is_approved == 0)
                                                            <tr>
                                                                <td data-label ="PAYPAL RECIPT" class="uploaded-checks">
                                                                    <a href="{{asset('uploads')}}/../{{$paypalPayment->paypal_receipt}}" download="{{$orderDetails->order_no}}-paypal-receipt.{{ pathinfo(storage_path($paypalPayment->paypal_receipt), PATHINFO_EXTENSION) }}">
                                                                        @if(pathinfo(storage_path($paypalPayment->paypal_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                                            <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                        @else
                                                                            <img src="{{asset('uploads')}}/../{{$paypalPayment->paypal_receipt}}" />
                                                                        @endif
                                                                    </a>
                                                                </td>
                                                                <td data-label ="DATE" style="vertical-align: middle;">{{$paypalPayment->created_at->format('m-d-Y')}}</td>
                                                                <td data-label ="TIME" style="vertical-align: middle;">{{$paypalPayment->created_at->format('H:m:s')}}</td>
                                                                <td data-label ="AMOUNT" style="vertical-align: middle;" class="text-right">$ {{number_format($paypalPayment->amount, 2)}}</td>
                                                                <td data-label ="APPROVE" style="vertical-align: middle;" class="text-center">
                                                                    @if ($paypalPayment->is_approved == 0)
                                                                        <button type="button" style="background-color: unset;border: none;outline: unset;color: #3055a6;" disabled>Pending</button>
                                                                        @elseif($paypalPayment->is_approved == 1)
                                                                        <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true">&nbsp;&nbsp;Approved</i></button>
                                                                        @else
                                                                        <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true">&nbsp;&nbsp;Rejected</i></button>
                                                                        @endif
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <th colspan="2">Total Amount</th>
                                                        <th class="text-right">$ {{number_format($paypalAmount, 2)}}</th>
                                                        <td></td>
                                                    </tfoot>
                                                </table>
                                                </div>
                                             @else
                                                <form id="payment-paypal-info" method="post" action="{{ route("customer_payment.paypal") }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row p-1 ">
                                                        <div class="col-md-12">
                                                            <h6 for="input1" class="form-label">Please Use Our PayPal Handle - "Info@encorelacrosse.com"</h6>

                                                        </div>
                                                    </div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-6">
                                                            <label class="form-lable">Payment Amount ($): <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" onchange="updatePaymentDetailsPaypal(this)" value="{{number_format(($orderDetails->order_total - $payment), 2)}}"/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-lable">Card Processing Fee (3%) ($):</label>
                                                            <input type="text" class="form-control" id="paypal_card_processing_fee_showing" name="paypal_fee" value="{{number_format((($orderDetails->order_total - $payment)/100*3), 2)}}" readonly>
                                                            <input type="hidden" class="form-control" id="paypal_card_processing_fee" value="{{($orderDetails->order_total - $payment)/100*3}}" />
                                                        </div>
                                                    </div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-12">
                                                            <label class="form-lable">Amount</label>
                                                            <input style="width: 50%;" type="number" class="form-control paypal_full_amount" id="paypal_amount" name="amount" min="0" step='0.01' readonly>

                                                        </div>
                                                    </div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-12">
                                                            <label class="form-lable">Paypal Recipt Uploaded</label>
                                                            <div id="paypal_receipt_preview">
                                                                <img src="{{asset('argon')}}/img/icons/check.png" style="width: auto; opacity: 0.5;max-height: 200px;" />
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-12">
                                                            <label class="form-lable">Upload PayPal Receipt <span class="text-danger">*</span></label>
                                                            <input type="file" style="display:none;" class="form-control" name="paypal_receipt" id="paypal_receipt" onchange="encodePaypalFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                                                            <label for="paypal_receipt" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3;">
                                                                <i class="fas fa-cloud-upload-alt" style="font-size: 36px;"></i><br>
                                                                Drag & drop your file here or <b>CLICK HERE</b>  to upload the paypal recipt
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                                    <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                                    <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                                                    <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                                    <input type="hidden" name="artwork" value="{{ $artwork }}">
                                                    <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                                                    <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                                    <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                                </form>
                                            @endif
                                        @else
                                        @endif
									</div>
                                    <div class="tab-pane fade" id="po_payments" role="tabpanel">
                                        @if($PurchaseorderReceipts && ($PurchaseorderReceipts->is_approved == 0 || $PurchaseorderReceipts->is_approved == 1))
                                            <div style="padding-left: 1rem;padding-right: 1rem;">
                                                <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                                    @if($PurchaseorderReceipts->is_approved == 1)
                                                        Purchase order approved &nbsp;&nbsp;<i class="fa fa-check " style="color: green;" aria-hidden="true"></i>
                                                    @else
                                                        Purchase order pending approve
                                                    @endif
                                                </div>
                                                <div id="purchase_order_receipt_preview">
                                                    @php
                                                        $filePath = asset( $PurchaseorderReceipts->receipt);
                                                        $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif']))
                                                        <img src="{{ $filePath }}" style="width: 600px; height: 800px;" alt="image_preview" />
                                                    @elseif ($fileType === 'pdf')
                                                        <canvas id="pdf-canvas" style="width: 600px; height: 800px;"></canvas>
                                                    @else
                                                        <p>Unsupported file type</p>
                                                    @endif
                                                </div>

                                                @if ($fileType === 'pdf')
                                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            var url = '{{ $filePath }}';
                                                            console.log('Fetching PDF from URL:', url);
                                                            var pdfjsLib = window['pdfjs-dist/build/pdf'];
                                                            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

                                                            var loadingTask = pdfjsLib.getDocument(url);
                                                            loadingTask.promise.then(function(pdf) {
                                                                pdf.getPage(1).then(function(page) {
                                                                    var scale = 1.5;
                                                                    var viewport = page.getViewport({ scale: scale });
                                                                    var canvas = document.getElementById('pdf-canvas');
                                                                    var context = canvas.getContext('2d');
                                                                    canvas.height = viewport.height;
                                                                    canvas.width = viewport.width;

                                                                    var renderContext = {
                                                                        canvasContext: context,
                                                                        viewport: viewport
                                                                    };
                                                                    page.render(renderContext).promise.then(function() {
                                                                        console.log('Page rendered');
                                                                    }).catch(function(error) {
                                                                        console.error('Error rendering page:', error);
                                                                    });
                                                                });
                                                            }).catch(function(error) {
                                                                console.error('Error loading PDF:', error);
                                                            });
                                                        });
                                                    </script>
                                                @endif
                                            </div>
                                        @else
                                            <form  method="post" action="{{ route("customer_payment.PO") }}" enctype="multipart/form-data">
                                                @csrf
                                                    <div class="row p-1 ">
                                                        <div class="col-md-12">
                                                            <label class="form-lable">Upload Purchase Order Receipt<span class="text-danger">*</span></label>
                                                            <input type="file" style="display: none" class="form-control" style="height: calc(7.5rem + 1px) !important;" name="PurchaseOrder_Receipt" id="PurchaseOrder_Receipt" onchange="encodePOFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                                                            <label for="PurchaseOrder_Receipt" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3;">
                                                                <i class="fas fa-cloud-upload-alt" style="font-size: 36px;"></i><br>
                                                                Drag & drop your file here or <b>CLICK HERE</b>  to upload purchase order receipt
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-12">
                                                            <label class="form-lable">Uploaded Purchase Order Receipt</label>
                                                            <div id="purchase_order_receipt_preview">
                                                                <img src="{{asset('argon')}}/img/icons/check.png" style="width: auto; opacity: 0.5;max-height: 200px;" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                                    <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                                    <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                                                    <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                                    <input type="hidden" name="artwork" value="{{ $artwork }}">
                                                    <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                                                    <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                                    <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                                    <button style="display: none" type="submit" class="btn btn-success btn-custom" id="confirm-purchase-po">Confirm Payment</button>
                                            </form>
                                        @endif
									</div>
                                    {{-- <div class="tab-pane fade" id="other_payments" role="tabpanel">

									</div> --}}
								</div>
							</div>
                </div>
            </div>
            <div class="col-12 col-lg-4 d-flex mb-4 mobile_padding_l_r">
                <div class="card mt-4 w-100 mobile_margin_top_unset">
                    <div class="card-body">
                        <h6 class="card-title mb-4 fw-bold">Payment Summary - #{{$orderDetails->order_no}}</h6>
                        <div>
                            <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Invoice amount ($) :</p>
                            <p class="fw-semi-bold">{{number_format($orderDetails->sub_total, 2)}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Artwork & other fees ($) :</p>
                            <p class=" fw-semi-bold">{{number_format($orderDetails->artwork, 2)}}</p>
                            </div>
                            @php
                                if ($orderDetails->discountType == 2) {
                                    $discountValue = $orderDetails->discount;
                                } else {
                                    $totalWithoutdisc = $orderDetails->sub_total + $orderDetails->artwork;
                                    $discountPercentage = $orderDetails->discount;
                                    $discountValue = ($totalWithoutdisc / 100) * $discountPercentage;
                                }
                            @endphp
                                @if ($orderDetails->discount_hidation == 1)
                                @if ($orderDetails->discountType == 2)
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Discount value ($) :</p>
                                        <p class="fw-semi-bold">{{number_format($discountValue, 2)}}</p>
                                    </div>
                                @elseif ($orderDetails->discountType == 1)
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Discount value {{ $orderDetails->discount }}% ($) :</p>
                                        <p class="fw-semi-bold">{{number_format($discountValue, 2)}}</p>
                                    </div>
                                @endif
                            @endif
                            @php
                                if ($orderDetails->sub_total > 0)
                                    $sales_tax = $orderDetails->sales_tax;
                                else
                                    $sales_tax = 0;
                            @endphp
                            <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Total invoice amount ($) :</p>
                            <p class="fw-semi-bold">{{number_format(($orderDetails->sub_total + $orderDetails->artwork - $discountValue),2)}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Sales tax fee {{number_format(($orderDetails['organizationDetails']->sales_tax), 2)}}% ($) :</p>
                            <p class="fw-semi-bold">{{number_format($sales_tax, 2)}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Shipping fee ($) :</p>
                            <p class="fw-semi-bold">{{number_format($orderDetails->shipping, 2)}}</p>
                            </div>
                        </div>
                        <div class=" border-top pt-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0 fw-bold">Grand Total :</h6>
                                    <p style="color: grey;font-weight: 100;font-size: .6rem;margin:0">(Invoice amount + Sales Tax + shipping)</p>
                                </div>
                                <h6 class="mb-0 fw-bold">{{number_format($orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - $discountValue, 2)}}</h6>
                            </div>
                            @if($cardAmount || $checkAmount || $venmoAmount || $paypalAmount  || $otherAmount || $purchaseorderAmount)
                                <div class="d-flex justify-content-between">
                                    <p class="fw-semi-bold">Paid amount ($) :</p>
                                    <p class="text-success fw-semi-bold">{{number_format((($cardAmount/103*100) + $checkAmount + $venmoAmount + ($paypalAmount/103*100)) + $otherAmount + $purchaseorderAmount, 2)}}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="fw-semi-bold">Paid processing fees 3% ($) :</p>
                                    <p class="fw-semi-bold">{{number_format((($cardAmount/103*3) + ($paypalAmount/103*3)), 2)}}</p>
                                </div>
                            @endif
                        </div>
                        <div class=" border-top pt-4">

                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0 fw-bold">Balance invoice amount ($) :</h6>
                                <h6 class="mb-0 fw-bold">{{number_format(($orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - ($cardAmount/103*100) - $checkAmount - $venmoAmount - $otherAmount - $purchaseorderAmount - ($paypalAmount/103*100) - $discountValue), 2)}}</h6>
                            </div>
                            @php
                                if ($orderDetails->sub_total > 0)
                                    $balanceDue = $orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - ($cardAmount/103*100) - $checkAmount - $venmoAmount - $otherAmount - $purchaseorderAmount - ($paypalAmount/103*100) - $discountValue;
                                else
                                    $balanceDue = 0;
                            @endphp

                            @php
                                if ($orderDetails->sub_total > 0)
                                    $processing_fee = $balanceDue * 3 / 100;
                                else
                                    $processing_fee = 0;
                            @endphp
                            <script>
                                const balanceDue = {{ (float) $balanceDue }};
                                const processingRate = 0.03;
                            </script>
                            {{-- @if(number_format(($balanceDue), 2) > 0) --}}
                                <div id="fee-section" style="display:none;" class="mt-2">
                                    <div class="d-flex justify-content-between d-none" id="processing-fee-row">
                                        <p class="fw-semi-bold">Processing fee 3% ($) :</p>
                                        <p class="fw-semi-bold" id="processing-fee">{{number_format($processing_fee, 2)}}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 fw-bold">Total amount to pay ($) :</h6>
                                        <h6 class="text-danger mb-0 fw-bold" id="total-amount">{{number_format(($balanceDue + $processing_fee), 2)}}</h6>
                                    </div>
                                </div>
                            {{-- @endif --}}
                        </div>
                        <div class="d-flex justify-content-between border-top pt-4">
                            <button type="button" id="confirmPayBtn" class="btn btn-success px-5 w-100 confirm-pay" @if($paymentStatus !== 0 && $paymentStatus !== 1) disabled @endif @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) disabled @endif> @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) <i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp; @endif Confirm & pay</button>
                            @php
                                $isDisabled = $paymentStatus !== 0 && $paymentStatus !== 1;
                                $latestPoRow = $PurchaseorderReceipts instanceof \Illuminate\Support\Collection
                                    ? $PurchaseorderReceipts->sortByDesc('created_at')->first()
                                    : $PurchaseorderReceipts;

                                $poOrder = $latestPoRow ? (int) $latestPoRow->is_approved : null;

                                $isPendingApproval = $checkPayments->where('is_approved', 0)->count() > 0 ||
                                                    $venmoPayments->where('is_approved', 0)->count() > 0 ||
                                                    $paypalPayments->where('is_approved', 0)->count() > 0 ||
                                                    $poOrder === 0;
                            @endphp

                            <button type="button"  id="confirmPoBtn" class="btn btn-success px-5 w-100 d-none" onclick="submitPOForm()"
                                @if($isDisabled || $poOrder === 0 || $poOrder === 1) disabled @endif>
                                @if($isPendingApproval)
                                    <i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;
                                @endif
                                @if($poOrder == 1)
                                    CONFIRMED
                                @elseif ($poOrder == 0)
                                    PENDING PO
                                @else
                                    CONFIRM PO
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->
<div class="modal fade" id="PaymentHistoryModal" tabindex="-1" role="dialog" aria-labelledby="PaymentHistoryModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title title-header-style" id="exampleModalLabel">Payment History</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <table class="paymentSummaryTable">
                        <thead>
                            <th>TRANSACTION ID</th>
                            <th>PAYMENT TYPE</th>
                            <th>PAYMENT STATUS</th>
                            <th>DATE</th>
                            <th>TIME</th>
                            <th class="text-right">AMOUNT</th>
                        </thead>
                        @if($cardPayments->count() > 0 || $checkPayments->count() > 0 || $venmoPayments->count() > 0 || $paypalPayments->count() > 0 || $PurchaseorderReceipts || $otherPayments->count() > 0)
                        <tbody>
                            @foreach ($cardPayments as $cardPayment)
                                <tr>
                                    <td data-label ="TRANSACTION ID">{{$cardPayment->transaction_id}}</td>
                                    <td data-label ="PAYMENT TYPE">CARD</td>
                                    <td data-label ="PAYMENT STATUS"><span style="color: #2dce89">Completed</span></td>
                                    <td data-label ="DATE">{{$cardPayment->created_at->format('m-d-Y')}}</td>
                                    <td data-label ="TIME">{{$cardPayment->created_at->format('H:m:s')}}</td>
                                    <td data-label ="AMOUNT" class="text-right">$ {{number_format($cardPayment->amount, 2)}}</td>
                                </tr>
                            @endforeach
                            @foreach ($checkPayments as $checkPayment)
                                @if($checkPayment->is_approved !== 0)
                                                <tr>
                                                    <td data-label ="TRANSACTION ID">CHECK{{$checkPayment->id}}</td>
                                                    <td data-label ="PAYMENT TYPE">CHECK</td>
                                                    <td data-label ="PAYMENT STATUS">@if($checkPayment->is_approved == 1) <span style="color: #2dce89">Completed</span> @else <span style="color: #fb6340">Rejected</span> @endif </td>
                                                    <td data-label ="DATE">{{$checkPayment->created_at->format('m-d-Y')}}</td>
                                                    <td data-label ="TIME" style="vertical-align: middle;">{{$checkPayment->created_at->format('H:m:s')}}</td>
                                                    <td data-label ="AMOUNT" style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->amount, 2)}}</td>
                                                </tr>
                                @endif
                            @endforeach
                            @foreach ($venmoPayments as $venmoPayment)
                            @if($venmoPayment->is_approved !== 0)
                                <tr>
                                    <td data-label ="TRANSACTION ID">VENMO{{$venmoPayment->id}}</td>
                                    <td data-label ="PAYMENT TYPE">VENMO</td>
                                    <td data-label ="PAYMENT STATUS">@if($venmoPayment->is_approved == 1) <span style="color: #2dce89">Completed</span> @else <span style="color: #fb6340">Rejected</span> @endif </td>
                                    <td data-label ="DATE" style="vertical-align: middle;">{{$venmoPayment->created_at->format('m-d-Y')}}</td>
                                    <td data-label ="TIME" style="vertical-align: middle;">{{$venmoPayment->created_at->format('H:m:s')}}</td>
                                    <td data-label ="AMOUNT" style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->amount, 2)}}</td>
                                </tr>
                            @endif
                            @endforeach
                            @foreach ($paypalPayments as $paypalPayment)
                            @if($paypalPayment->is_approved !== 0)
                                <tr>
                                    <td data-label ="TRANSACTION ID">PAYPAL{{$paypalPayment->id}}</td>
                                    <td data-label ="PAYMENT TYPE">PAYPAL</td>
                                    <td data-label ="PAYMENT STATUS">@if($paypalPayment->is_approved == 1) <span style="color: #2dce89">Completed</span> @else <span style="color: #fb6340">Rejected</span> @endif </td>
                                    <td data-label ="DATE" style="vertical-align: middle;">{{$paypalPayment->created_at->format('m-d-Y')}}</td>
                                    <td data-label ="TIME" style="vertical-align: middle;">{{$paypalPayment->created_at->format('H:m:s')}}</td>
                                    <td data-label ="AMOUNT" style="vertical-align: middle;" class="text-right">$ {{number_format($paypalPayment->amount, 2)}}</td>
                                </tr>
                            @endif
                            @endforeach
                            @foreach ($otherPayments as $otherPayment)
                                <tr>
                                    <td data-label ="TRANSACTION ID">OTH{{$otherPayment->id}}</td>
                                    <td data-label ="PAYMENT TYPE">OTHER</td>
                                    <td data-label ="PAYMENT STATUS"><span style="color: #2dce89">Completed</span></td>
                                    <td data-label ="DATE">{{$otherPayment->created_at->format('m-d-Y')}}</td>
                                    <td data-label ="TIME">{{$otherPayment->created_at->format('H:m:s')}}</td>
                                    <td data-label ="AMOUNT" class="text-right">$ {{number_format($otherPayment->amount, 2)}}</td>
                                </tr>
                            @endforeach
                            @if($PurchaseorderReceipts)
                                <tr>
                                    <td data-label ="TRANSACTION ID">PO{{$PurchaseorderReceipts->id}}</td>
                                    <td data-label ="PAYMENT TYPE">PO</td>
                                    <td data-label ="PAYMENT STATUS">@if($PurchaseorderReceipts->is_approved == 1) <span style="color: #2dce89">Completed</span> @else <span style="color: #fb6340">Rejected</span> @endif </td>
                                    <td data-label ="DATE">{{$PurchaseorderReceipts->created_at->format('m-d-Y')}}</td>
                                    <td data-label ="TIME">{{$PurchaseorderReceipts->created_at->format('H:m:s')}}</td>
                                    <td data-label ="AMOUNT" class="text-right">$ {{number_format($PurchaseorderReceipts->amount, 2)}}</td>
                                </tr>
                            @endif
                        </tbody>
                        @else
                        <tbody>
                            <tr>
                                <td style="justify-content: center;">No History Found</td>
                            </tr>
                        </tbody>

                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="checkTechPackBeforePayModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">

            <div class="modal-header ">
                <h5 class="modal-title">Order Items Details</h5>
                <button type="button"
                        class="custom-modal-close-dark"
                        onclick="closeTechPackPayModal()"
                        aria-label="Close">
                    &times;
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-warning mb-3">
                    Final Summary: Please double-check all item quantities and tech packs carefully before proceeding with payment.
                </div>
                <div class="border rounded p-3 mb-3 bg-light">
                    <h6 class="fw-bold mb-2">Shipping Address</h6>
                    <div id="techPackShippingAddress" style="line-height:1.6;">
                        -
                    </div>
                </div>

                <div id="techPackLoading" class="text-center py-4" style="display:none;">
                    Loading tech pack details...
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered mb-0 techpack-responsive-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Item Name</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tech Pack</th>
                            </tr>
                        </thead>
                        <tbody id="techPackCheckTableBody"></tbody>
                    </table>
                </div>
                <div class="form-check mt-3">
                    <input class="form-check-input"
                        type="checkbox"
                        id="confirmOrderReviewCheck">

                    <label class="form-check-label" for="confirmOrderReviewCheck">
                        I confirm that I have reviewed and approved the items, quantities (QTY), tech packs, and shipping address for this order before proceeding with payment. I understand that once payment is submitted, this order is final and no changes or additions can be made through the customer portal.
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary"
                        onclick="closeTechPackPayModal()">
                    Cancel
                </button>

                <button type="button"
                        class="btn btn-success"
                        id="confirmPayAfterTechPackCheck"
                        disabled>
                    Confirm & Pay
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    const confirmOrderReviewCheck = document.getElementById('confirmOrderReviewCheck');
    const confirmPayBtn = document.getElementById('confirmPayAfterTechPackCheck');

    if (confirmOrderReviewCheck && confirmPayBtn) {
        confirmOrderReviewCheck.addEventListener('change', function () {
            confirmPayBtn.disabled = !this.checked;
        });
    }
    function closeTechPackPayModal() {
        const modalEl = document.getElementById('checkTechPackBeforePayModal');

        if (!modalEl) {
            return;
        }

        // remove focus from modal/button before hide
        if (document.activeElement && modalEl.contains(document.activeElement)) {
            document.activeElement.blur();
        }

        // Bootstrap 5
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            instance.hide();
            return;
        }

        // Bootstrap 4
        if (window.jQuery && $('#checkTechPackBeforePayModal').length) {
            $('#checkTechPackBeforePayModal').modal('hide');
            return;
        }

        // fallback
        modalEl.style.display = 'none';
        modalEl.classList.remove('show');
        modalEl.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');

        document.querySelectorAll('.modal-backdrop').forEach(function (backdrop) {
            backdrop.remove();
        });
    }
    function submitPOForm() {
        $(".se-pre-con").fadeIn();
        Pace.restart();
            $("#confirm-purchase-po").click();
    }
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {

            const targetId = e.target.getAttribute('href'); // #Card_payments, etc
            let hasFee = false;

            if (targetId === '#Card_payments' || targetId === '#paypal_payments') {
                hasFee = true;
            }

            const feeSection = document.getElementById('fee-section');
            const feeEl = document.getElementById('processing-fee');
            const totalEl = document.getElementById('total-amount');
            const feeRow = document.getElementById('processing-fee-row');
            const confirmPayBtn = document.getElementById('confirmPayBtn');
            const confirmPoBtn = document.getElementById('confirmPoBtn');

            if (targetId === '#po_payments') {
                // PO tab
                confirmPayBtn.classList.add('d-none');
                confirmPoBtn.classList.remove('d-none');
            } else {
                // Other payment tabs
                confirmPayBtn.classList.remove('d-none');
                confirmPoBtn.classList.add('d-none');
            }

            if (balanceDue <= 0) {
                feeSection.style.display = 'none';
                return;
            }

            feeSection.style.display = 'block';

            let fee = 0;
            let total = balanceDue;

            if (hasFee) {
                fee = balanceDue * processingRate;
                total = balanceDue + fee;
            }

            // feeEl.innerText = fee.toFixed(2);
            totalEl.innerText = total.toFixed(2);
            if (fee > 0) {
                feeRow.classList.remove('d-none');
                feeEl.innerText = fee.toFixed(2);
            } else {
                feeRow.classList.add('d-none');
            }
        });
    });
    document.querySelector('[data-bs-toggle="tab"].active')?.dispatchEvent(
        new Event('shown.bs.tab')
    );

document.addEventListener('DOMContentLoaded', function () {

    // document.querySelectorAll('.confirm-pay').forEach(button => {
    //     button.addEventListener('click', function () {
    //         Pace.restart();
    //         const activeTab = document.querySelector('.tab-pane.active.show');
    //         if (!activeTab) return;

    //         const form = activeTab.querySelector('form');
    //         if (!form) return;

    //         // HTML5 validation check
    //         if (!form.checkValidity()) {
    //             form.reportValidity(); // show browser validation messages
    //             return;
    //         }

    //         form.submit();
    //     });
    // });
let activePaymentForm = null;
let activePayButton = null;

$('#checkTechPackBeforePayModal').on('hide.bs.modal', function () {
    // Move focus outside modal before Bootstrap hides it
    if (document.activeElement && this.contains(document.activeElement)) {
        document.activeElement.blur();
    }
});

$('#checkTechPackBeforePayModal').on('hidden.bs.modal', function () {
    // Return focus back to Pay button
    if (activePayButton) {
        activePayButton.focus();
    }
});

document.querySelectorAll('.confirm-pay').forEach(function (button) {
    button.addEventListener('click', function () {
        const activeTab = document.querySelector('.tab-pane.active.show');

        if (!activeTab) {
            return;
        }

        const form = activeTab.querySelector('form');

        if (!form) {
            return;
        }

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        activePaymentForm = form;
        activePayButton = this;

        loadTechPackCheckDetails();
    });
});

function loadTechPackCheckDetails() {
    const tbody = document.getElementById('techPackCheckTableBody');
    const loading = document.getElementById('techPackLoading');
    const confirmBtn = document.getElementById('confirmPayAfterTechPackCheck');
    const confirmCheck = document.getElementById('confirmOrderReviewCheck');
    const shippingAddressBox = document.getElementById('techPackShippingAddress');

    tbody.innerHTML = '';

    if (loading) {
        loading.style.display = 'block';
    }
    if (confirmCheck) {
        confirmCheck.checked = false;
    }

    if (confirmBtn) {
        confirmBtn.disabled = true;
        confirmBtn.innerText = 'Confirm & Pay';
    }

    if (confirmBtn) {
        confirmBtn.disabled = true;
    }

    $('#checkTechPackBeforePayModal').modal('show');

    fetch("{{ route('customer.order.techpack-check', $orderDetails->id) }}", {
        method: "GET",
        headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        if (loading) {
            loading.style.display = 'none';
        }

        if (!data.status) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-danger">
                        Unable to load tech pack details.
                    </td>
                </tr>
            `;
            return;
        }

        if (!data.items || data.items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center">
                        No items found.
                    </td>
                </tr>
            `;
            return;
        }

        if (shippingAddressBox) {
            shippingAddressBox.textContent = data.shipping_address || 'No shipping address found';
        }

        data.items.forEach(function (item) {
            const techPackButton = item.tech_pack
                ? `<button type="button"
                        class="btn btn-outline-secondary btn-sm view-file-btn"
                        data-file="${escapeHtml(item.tech_pack)}">
                        VIEW TECH PACK
                </button>`
                : `<button type="button"
                        class="btn btn-outline-secondary btn-sm view-file-btn"
                        data-file="">
                        VIEW TECH PACK
                </button>`;

            tbody.innerHTML += `
                <tr>
                    <td data-label="Item Name">
                        ${escapeHtml(item.name || '-')}
                    </td>

                    <td data-label="QTY" class="text-center">
                        ${escapeHtml(item.qty || '-')}
                    </td>

                    <td data-label="Status" class="text-center">
                        ${escapeHtml(item.status || '-')}
                    </td>

                    <td data-label="Tech Pack" class="text-center">
                        ${techPackButton}
                    </td>
                </tr>
            `;
        });


    })
    .catch(function (error) {
        console.error(error);

        if (loading) {
            loading.style.display = 'none';
        }

        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center text-danger">
                    Something went wrong while loading tech pack details.
                </td>
            </tr>
        `;
    });
}

document.getElementById('confirmPayAfterTechPackCheck').addEventListener('click', function () {
    const confirmCheck = document.getElementById('confirmOrderReviewCheck');

    if (!confirmCheck || !confirmCheck.checked) {
        Swal.fire('Confirmation Required', 'Please confirm that you reviewed the order details before payment.', 'warning');
        return;
    }
    if (!activePaymentForm) {
        return;
    }

    const confirmBtn = this;

    confirmBtn.disabled = true;
    confirmBtn.innerText = 'Processing...';

    // Move focus out before hiding modal
    confirmBtn.blur();

    $('#checkTechPackBeforePayModal').modal('hide');

    Pace.restart();

    setTimeout(function () {
        activePaymentForm.submit();
    }, 200);
});



document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('view-file-btn')) {
        var file = e.target.dataset.file;

        if (!file) {
            Swal.fire('No File Found', 'This file is not available yet', 'warning');
            return;
        }

        window.open(file, '_blank');
    }
});

});

    function updatePaymentDetails(invoice_amount) {

        var invoiceAmount = parseFloat(invoice_amount.value);

        var cardProcessingFee = (invoiceAmount / 100) * 3;
        $('#card_processing_fee_showing').val(cardProcessingFee.toFixed(2));

        var fullAmount = cardProcessingFee + invoiceAmount;
        $('.card_payment_amount').val(fullAmount.toFixed(2));

    }

    function updatePaymentDetailsPaypal(invoice_amount) {

        var invoiceAmount = parseFloat(invoice_amount.value);

        var cardProcessingFee = (invoiceAmount / 100) * 3;
        $('#paypal_card_processing_fee_showing').val(cardProcessingFee.toFixed(2));

        var fullAmount = cardProcessingFee + invoiceAmount;
        $('.paypal_full_amount').val(fullAmount.toFixed(2));

    }

    function encodeFrontFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#check_front_preview").html(image);
        }

        reader.readAsDataURL(file);
    }
    function encodeBackFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#check_back_preview").html(image);
        }

        reader.readAsDataURL(file);
    }
    function encodeVenmoFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#venmo_receipt_preview").html(image);
        }

        reader.readAsDataURL(file);
    }
    function encodePaypalFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#paypal_receipt_preview").html(image);
        }

        reader.readAsDataURL(file);
    }
    function encodePOFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            var fileType = file.type;

            element.setAttribute('data-file-uri', reader.result);

            if (fileType.startsWith('image/')) {
                var image = "<img src='" + reader.result + "' style='width: 600px; height: 800px' alt='image_preview'/>";
                $("#purchase_order_receipt_preview").html(image);
            } else if (fileType === 'application/pdf') {
                var pdfData = atob(reader.result.split(',')[1]);
                var loadingTask = pdfjsLib.getDocument({data: pdfData});

                loadingTask.promise.then(function(pdf) {
                    pdf.getPage(1).then(function(page) {
                        var scale = 1.5;
                        var viewport = page.getViewport({scale: scale});
                        var canvas = document.createElement('canvas');
                        var context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };

                        page.render(renderContext).promise.then(function() {
                            $("#purchase_order_receipt_preview").html(canvas);
                        });
                    });
                }, function(reason) {
                    console.error(reason);
                });
            } else {
                $("#purchase_order_receipt_preview").html('<p>Unsupported file type</p>');
            }
        }

        reader.readAsDataURL(file);
    }
</script>

@endsection
