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
    .balance-amount {
        width: 120px;
        min-width: 120px;
        max-width: 120px;
    }
    .balance-amount2 {
        width: 220px;
        min-width: 220px;
        max-width: 220px;
    }
    @media (max-width: 768px) {

    table {
        border: 0;
    }

    table thead {
        display: none;
    }

    table tr {
        display: block;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none;
        padding: 6px 0;
        font-size: 14px;
    }

    table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #555;
    }

    table td:last-child {
        padding-top: 10px;
    }

    input.order_amounts {
        width: 120px;
        text-align: right;
    }
    .balance-amount2{
        width: 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
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
    @if(session('payment_success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Payment Submitted',
                text: 'Your payment has been successfully submitted. Our account department will now proceed with the approval process.',
                confirmButtonText: 'Ok',
            });
        </script>
    @endif
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">HOME</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">BULK PAYMENTS</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<div class="row">
    <div class="col-12 col-lg-12 d-flex mb-4">
        <div class="card mt-4 w-100">
            <div class="card-body">
                <div class="customer-table">
                    <div class="table-responsive white-space-nowrap">
                        <table class="table align-items-center ml-auto" >
                            <thead class="table-light">
                                <th scope="col" class="text-center">Order Number</th>
                                {{-- <th scope="col" class="text-center">Organization Name</th> --}}
                                <th scope="col" class="text-center">Total Items QTY</th>
                                <th scope="col" class="text-center">Order Status</th>
                                <th scope="col" class="text-center">Total Amount</th>
                                <th scope="col" class="text-center">Paid Amount</th>
                                <th scope="col" class="text-center">Balance to Pay</th>
                                <th scope="col" class="text-center balance-amount">Payment Amount</th>
                            </thead>
                            <tbody id="selectedInvoiceTr">
                                @foreach ($orders as $order)
                                    @php
                                        $payment = $order->payment_status;
                                        $balance = $payment['balance_to_be_paid'] ?? 0;
                                    @endphp
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

                                    <tr>
                                        <td class="text-center" data-label="Order No">
                                            <a href="#" class="edit-order" style="color:black">
                                                {{ $order->order_no }}
                                            </a>
                                        </td>
                                        <td class="text-center total-amount-to-pay" data-label="Total amount">
                                            {{ $order->total_item_qty }}
                                        </td>

                                        <td class="text-center total-amount-to-pay" data-label="Total amount"><span class="lable-table {{ $bg_color }} rounded border border-success-subtle font-text2 fw-bold">{{ $order_status }}</span>

                                        <td class="text-center total-amount-to-pay" data-label="Total amount">
                                            {{ number_format($order->order_total, 2) }}
                                        </td>

                                        <td class="text-center paid-amount-total" data-label="Paid amount">
                                            {{ number_format($payment['total_payment'] ?? 0, 2) }}
                                        </td>

                                        <td class="text-center balance-amount" data-label="Balance to pay">
                                            {{ number_format($balance, 2) }}
                                        </td>

                                        <td data-label="Payment amount">
                                            <input type="text"
                                                class="invoice_payment_amount order_amounts form-control text-end"
                                                name="payment_amount[{{ $order->id }}]"
                                                data-order-id="{{ $order->id }}"
                                                max="{{ $balance }}"
                                                value="{{ number_format($balance, 2, '.', '') }}">

                                            <input type="hidden"
                                                class="invoice_payment_amount_original"
                                                value="{{ number_format($balance, 2, '.', '') }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tbody class="no-top-border">

                                <tr>
                                    <td class="no-top-border" colspan="5" id="debit_acc_summary_line_1" ></td>
                                    <td class="text-right no-top-border balance-amount2" style="font-weight:800;font-size: 1rem;">Total Amount to Pay :  </td>
                                    <td class="no-top-border">
                                        <input type="text" name="total_sum_of_payment" id="total_sum_of_payment" value="{{$totalAmountToPay}}" class="form-control text-end" style="font-weight:800;" >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- </div>
<!--end row-->

<div class="row"> --}}
            <div class="col-12 col-lg-12 d-flex mb-4">
                <div class="card mt-4 w-100">
                    <div class="card-body">
                        <div class="row justify-content-end">
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
								</ul>
								<div class="tab-content py-3">
									<div class="tab-pane fade show active" id="Card_payments" role="tabpanel">

										<div class="row p-1">
                                            <div class="col-12 col-lg-12 d-flex px-1">
                                                <div class="card w-100 border">
                                                    <div class="card-body">
                                                            <form id="payment-card-info" method="post" action="{{ route("customer_payment_bulk") }}">
                                                                @csrf
                                                                <div class="order-payment-hidden-fields"></div>
                                                                <div class="row p-1 ">
                                                                    <h4>Billing Details</h4>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">First Name</label>
                                                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{$contact->first_name}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">Last Name</label>
                                                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{$contact->last_name}}" required >
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">Country</label>
                                                                        <input type="text" class="form-control" id="country" name="country" value="{{$organization->billing_country}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">State</label>
                                                                        <input type="text" class="form-control" id="state" name="state" value="{{$organization->billing_state}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">Street Address</label>
                                                                        <input type="text" class="form-control" id="street" name="street" value="{{$organization->billing_street}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">City</label>
                                                                        <input type="text" class="form-control" id="city" name="city" value="{{$organization->billing_city}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">Postal Code</label>
                                                                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{$organization->billing_postal_code}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">Email</label>
                                                                        <input type="email" class="form-control" id="email" name="email" value="{{$contact->email}}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="input1" class="form-label">Phone No</label>
                                                                        <input type="text" class="form-control" id="phone" name="phone" value="{{$contact->phone_no}}" required>
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
                                                                            <div class="col-md-8">
                                                                                <label for="input1" class="form-label">Expiration Date</label>
                                                                                <div class="row  ">
                                                                                    <div class="col-md-6">

                                                                                        <select class="form-control mr-2" id="expiration-month" name="expiration-month">
                                                                                            @foreach($months as $k=>$v)
                                                                                            <option value="{{ $k }}" {{ old('expiration-month') == $k ? 'selected' : '' }}>{{ $v }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <select class="form-control" id="expiration-year" name="expiration-year">
                                                                                            @for($i = date('Y'); $i <= (date('Y') + 15); $i++)
                                                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                                                            @endfor
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label for="input1" class="form-label">CVV</label>
                                                                                <input type="password" class="form-control" id="cvv" name="cvv" value="{{ old('cvv') }}" placeholder="CVV" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="input1" class="form-label">Payment Amount ($)</label>
                                                                        <input type="text" class="form-control" onchange="updatePaymentDetails(this.value)" id="total_sum_of_payment_card" value="" readonly>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="input1" class="form-label">Card Processing Fee (3%) ($)</label>
                                                                        <input type="text" class="form-control" name="card_fee" id="card_processing_fee_showing" value="" readonly />
                                                                        <input type="hidden" class="form-control" id="card_processing_fee" value="">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="input1" class="form-label">Amount ($)</label>
                                                                        <input type="number" class="form-control card_payment_amount" id="amount" name="amount" min="0" value="" readonly/>
                                                                    </div>

                                                                </div>
                                                                <div class="row p-1 flex-row-reverse ">
                                                                    <div class="col-md-3 ">
                                                                        <button type="submit" id="confirmPayBtn" class="btn btn-success w-100 px-5 confirm-pay" > Confirm & pay</button>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="payment_type" value="215sds2358">
                                                            </form>

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


                                                        <form id="payment-check-info" method="post" action="{{ route("customer_payment_bulk") }}" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="order-payment-hidden-fields"></div>
                                                            <div class="row p-1 ">
                                                                <div class="col-md-6">
                                                                    <label for="input1" class="form-label">Please indicate the amount that has been paid.*</label>
                                                                    <input type="number" class="form-control"  name="check_customer_paid_amount"  value="" id="total_sum_of_payment_check" step="0.01" readonly>
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
                                                            <div class="row p-1 flex-row-reverse ">
                                                                <div class="col-md-3 ">
                                                                    <button type="submit"  class="btn btn-success w-100 px-5 confirm-pay" > Confirm & pay</button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="payment_type" value="89421ssafs524">
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
									</div>
									<div class="tab-pane fade" id="venmo_payments" role="tabpanel">

                                                <form id="payment-venmo-info" method="post" action="{{ route("customer_payment_bulk") }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="order-payment-hidden-fields"></div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-12">
                                                            <h6 for="input1" class="form-label">Please Use Our Venmo Handle - "@Encore-custom"</h6>

                                                        </div>
                                                    </div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-6">
                                                            <label class="form-lable">Please indicate the amount that has been paid.<span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" name="venmo_customer_paid_amount" id="total_sum_of_payment_venmo" value="" step="0.01" readonly/>
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
                                                    <div class="row p-1 flex-row-reverse ">
                                                        <div class="col-md-3 ">
                                                            <button type="submit" class="btn btn-success w-100 px-5 confirm-pay" > Confirm & pay</button>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="payment_type" value="23565sdss58">
                                                </form>

                                    </div>
                                    <div class="tab-pane fade" id="paypal_payments" role="tabpanel">

                                                <form id="payment-paypal-info" method="post" action="{{ route("customer_payment_bulk") }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="order-payment-hidden-fields"></div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-12">
                                                            <h6 for="input1" class="form-label">Please Use Our PayPal Handle - "Info@encorelacrosse.com"</h6>

                                                        </div>
                                                    </div>
                                                    <div class="row p-1 ">
                                                        <div class="col-md-6">
                                                            <label class="form-lable">Payment Amount ($): <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" onchange="updatePaymentDetailsPaypal(this.value)" id="total_sum_of_payment_paypal" value="" readonly/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-lable">Card Processing Fee (3%) ($):</label>
                                                            <input type="text" class="form-control" id="paypal_card_processing_fee_showing" name="paypal_fee" value="" readonly>
                                                            <input type="hidden" class="form-control" id="paypal_card_processing_fee" value="" />
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
                                                    <div class="row p-1 flex-row-reverse ">
                                                        <div class="col-md-3 ">
                                                            <button type="submit" id="confirmPayBtn" class="btn btn-success w-100 px-5 confirm-pay" > Confirm & pay</button>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="payment_type" value="458665sfsf25">
                                                </form>

									</div>

								</div>
							</div>
                </div>
            </div>
        </div><!--end row-->


<script>
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
    document.addEventListener('input', function (e) {
    if (!e.target.classList.contains('invoice_payment_amount')) return;

    let input = e.target;
    let max = parseFloat(input.getAttribute('max')) || 0;

    // Remove invalid characters
    let value = input.value.replace(/[^0-9.]/g, '');

    // Prevent multiple dots
    if ((value.match(/\./g) || []).length > 1) {
        value = value.slice(0, -1);
    }

    let numericValue = parseFloat(value) || 0;

    // Auto-limit to balance
    if (numericValue > max) {
        numericValue = max;
    }

    // Update input value (2 decimals)
    input.value = numericValue.toFixed(2);

    recalculateTotal();
});

function recalculateTotal() {
    let total = 0;

    document.querySelectorAll('.invoice_payment_amount').forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    document.getElementById('total_sum_of_payment').value = total.toFixed(2);
    document.getElementById('total_sum_of_payment_card').value = total.toFixed(2);
    document.getElementById('total_sum_of_payment_paypal').value = total.toFixed(2);
    document.getElementById('total_sum_of_payment_venmo').value = total.toFixed(2);
    document.getElementById('total_sum_of_payment_check').value = total.toFixed(2);
    updatePaymentDetails(total);
    updatePaymentDetailsPaypal(total)
}
    function updatePaymentDetails(invoice_amount) {
console.log(invoice_amount);

        var invoiceAmount = parseFloat(invoice_amount);

        var cardProcessingFee = (invoiceAmount / 100) * 3;
        $('#card_processing_fee_showing').val(cardProcessingFee.toFixed(2));

        var fullAmount = cardProcessingFee + invoiceAmount;
        $('.card_payment_amount').val(fullAmount.toFixed(2));

    }

    function updatePaymentDetailsPaypal(invoice_amount) {

        var invoiceAmount = parseFloat(invoice_amount);

        var cardProcessingFee = (invoiceAmount / 100) * 3;
        $('#paypal_card_processing_fee_showing').val(cardProcessingFee.toFixed(2));

        var fullAmount = cardProcessingFee + invoiceAmount;
        $('.paypal_full_amount').val(fullAmount.toFixed(2));

    }

// Initial calculation on load
recalculateTotal();

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function () {

        // Remove old hidden inputs
        form.querySelectorAll('.dynamic-order-field').forEach(e => e.remove());

        document.querySelectorAll('.invoice_payment_amount').forEach(input => {
            let amount = parseFloat(input.value) || 0;
            let orderId = input.dataset.orderId;

            if (amount > 0) {
                let hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = `orders[${orderId}]`;
                hidden.value = amount.toFixed(2);
                hidden.classList.add('dynamic-order-field');

                form.querySelector('.order-payment-hidden-fields').appendChild(hidden);
            }
        });
    });
});
</script>

@endsection
