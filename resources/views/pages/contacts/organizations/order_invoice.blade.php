<div class="container-fluid mt-5" id="invoice_print">
    @foreach ($orders as $order)
        <input type="hidden" id="invoice_id" value="{{$order->id}}" />

        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    <img src="{{ asset('argon') }}/img/encore/logo1.png" height="150px">
                </div>

                <div class="col-lg-6">
                    <h3 class="page-title text-danger text-right">INVOICE</h3>
                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">Encore Custom</h5>
                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">891 4th st.</h5>
                    <h5 class="text-right encore-address" style="margin-bottom: 0rem;">San Rafael, CA 94901</h5>
                </div>

                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Organization :</th>
                            <td><h5>{{$order->organizationDetails['organization_name']}}</h5></td>
                            <input type="hidden" id="organization_name" value="{{$order->organizationDetails['organization_name']}}" />
                        </tr>
                        <tr>
                            <th>Order # :</th>
                            <td><h5>{{$order->order_no}}</h5></td>
                        </tr>
                        <tr>
                            <th>Status :</th>
                            <td><h5>{{$order->statusDetails['status_name']}}</h5></td>
                        </tr>
                        <tr>
                            <th>Sales Rep :</th>
                            <td><h5>{{$order->userDetails['name']}}</h5></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>

        <hr class="page-divider">

{{-- Address Details --}}
        <div class="col-lg-12 mb-1">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Shipping Address:</th>
                        </tr>
                        <tr><td style="text-wrap: balance;"><h5>{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}</h5></td></tr>
                        <tr><td style="text-wrap: balance;"><h5>{{$order->apartment}}</h5></td></tr>
                        <tr><td style="text-wrap: balance;"><h5>{{$order->street}}</h5></td></tr>
                        <tr><td style="text-wrap: balance;"><h5>{{$order->city}} {{$order->state}} {{$order->postal_code}}</h5></td></tr>
                        <tr><td style="text-wrap: balance;"><h5>{{$order->country}}</h5></td></tr>
                        <tr><td><h5>{{$order->phone_no}}</h5></td></tr>
                        <tr><td><h5>{{$order->email}}</h5></td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Billing Address:</th>
                        </tr>
                        <tr><td style="text-wrap: balance;"><h5>{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}</h5></td></tr>
                        <tr><td style="text-wrap: balance;"><h5>{{$order->apartment}}</h5></td></tr>
                        <tr><td style="text-wrap: balance;"><h5>{{$order->street}}</h5></td></tr>
                        <tr><td style="text-wrap: balance;"><h5>{{$order->city}} {{$order->state}} {{$order->postal_code}}</h5></td></tr>
                        <tr><td style="text-wrap: balance;"><h5>{{$order->country}}</h5></td></tr>
                        <tr><td><h5>{{$order->phone_no}}</h5></td></tr>
                        <tr><td><h5>{{$order->email}}</h5></td></tr>
                    </table>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-12">
                    <table class="table" id="invoice_items" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 40%;">ITEM</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">EST DELIVERY</th>
                                <th class="text-center">QTY</th>
                                <th class="text-right">UNIT PRICE($)</th>
                                <th class="text-right">TOTAL($)</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php $totalItemQty = 0; @endphp
                            @foreach ($order->orderItems as $orderItem)
                            @php $totalItemQty = $totalItemQty + $orderItem->qty; @endphp
                            <tr>
                                <td style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word;"><h5>{{$orderItem->display_name ?? $orderItem->productDetails['product_name']}}</h5></td>
                                <td><h5 class="text-center">{{$orderItem->statusDetails['status_name']}}</h5></td>
                                <td><h5 class="text-center">{{$orderItem->est_delivery_date}}</h5></td>
                                <td><h5 class="text-center">{{$orderItem->qty}}</h5></td>
                                <td><h5 class="text-right">{{number_format($orderItem->unit_price, 2)}}</h5></td>
                                <td><h5 class="text-right">{{number_format($orderItem->total, 2)}}</h5></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="row">
                @can('show order price')
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="main-htag mt-4">Thank you for your business!</h1>
                            </div>
                            <div class="col-md-12 mt-4 text-center ">
                                <img src="{{ asset('argon') }}/img/encore/logo_dark.png" class="navbar-brand-img imagesize" id="logo_large" alt="..." width="250px" >
                            </div>
                        </div>

                        {{-- <div class="mt-4">
                            <h4>Payment can be submitted via PayPal, Venmo, Debit/Credit Card or Check. If submitting via PayPal or
                                Venmo, please include the invoice #, as well as your team and contact information.</h4>
                        </div>
                        <div class="mt-4">
                            <table>
                                <tr>
                                    <td><h4 class="text-small">PayPal :</h4></td>
                                    <td><h4 class="text-small"><span class="text-muted">info@encorelacrosse.com</span></h4></td>
                                </tr>
                                <tr>
                                    <td><h4 class="text-small">Venmo :</h4></td>
                                    <td><h4 class="text-small">: <span class="text-muted">@encore-lacrosse</span></h4></td>
                                </tr>
                                <tr>
                                    <td><h4 class="text-small">Credit Card/Check :</h4></td>
                                    <td><h4 class="text-small"><span class="text-muted">Please make payment through sales rep or accounting dept.</span></h4></td>
                                </tr>
                            </table>
                        </div> --}}
                    </div>
                @endcan

                @can('show order price')
                    {{-- <div class="col-lg-5">
                        <table class="table" id="invoice_summery">
                            <tr>
                                <th class="text-left">SUBTOTAL ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->sub_total, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">SALES TAX ($) {{$order->organizationDetails['sales_tax']}}% RATE :</th>
                                <td><h5 class="text-right">{{number_format($order->sales_tax, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">SHIPPING ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->shipping, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">ARTWORK ($) :</th>
                                <td><h5 class="text-right">{{number_format($order->artwork, 2)}}</h5></td>
                            </tr>
                            <tr>
                                <th class="text-left">PROCESSING FEE ($) :</th>
                                <td><h5 class="text-right">{{number_format($processingFee, 2)}}</h5></td>
                            </tr>

                            @php
                                if ($order->discountType == 2) {
                                    $discountValue = $order->discount;
                                } else {
                                    $totalWithoutdisc = $order->sub_total + $order->sales_tax + $order->shipping + $order->artwork;
                                    $discountPercentage = $order->discount;
                                    $discountValue = ($totalWithoutdisc / 100) * $discountPercentage;
                                }
                            @endphp
                            @if ($order->discount_hidation == 1)
                                <tr>
                                    @if ($order->discountType == 2)
                                        <th class="text-left">DISCOUNT VALUE  ($) :</th>
                                        <td><h5 class="text-right">
                                            {{number_format($discountValue, 2)}}</h5>
                                        </td>
                                    @elseif ($order->discountType == 1)
                                        <th class="text-left">DISCOUNT VALUE  {{ $order->discount }}% ($) :</th>
                                        <td><h5 class="text-right">
                                            {{number_format($discountValue, 2)}}</h5>
                                        </td>
                                    @endif
                                </tr>
                            @endif

                            <br>
                            <tr>
                                <th class="total text-left">ORDER TOTAL ($) :</th>
                                <td><h5 class="text-right" style="font-weight: bold; font-size: large;">{{number_format($order->order_total + $processingFee, 2)}}</h5></td>
                            </tr>
                        </table>
                    </div> --}}
                    <div class="col-lg-7 lorderdate001 max_width01" @if(str_starts_with($order->order_no, 'TSR')) style="display:none" @endif>
                        <table id="invoice_summery_table" style="margin-left: auto;">
                            <tr>
                                <td class="header-style mb-4">Payment</td>
                            </tr>
                            <tr>
                                <th style="color: #717070">Total Item Qty </th>
                                <th><input class="invoice-inputs text-right item-table-border invoicein0001" type='text'
                                        id="order_summery_qty" style="color: #717070" value='{{ $totalItemQty }}'
                                        readonly /></th>
                            </tr>
                            <tr style="color: black">
                                <th style="font-weight: 100">Total invoice amount ($) </th>
                                <td><input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="sub_total"
                                        id="sub_total" value='{{ number_format($order->sub_total, 2) }}'
                                        readonly /></td>
                            </tr>
                            <tr style="color: #717070">
                                <th style="font-weight: 100">Shipping Fee ($) </th>
                                <td><input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="shipping"
                                        id="shipping" value='{{ number_format($order->shipping, 2) }}' style="color: #717070"  readonly/>
                                </td>
                            </tr>
                            <tr style="color: #717070">
                                <th style="font-weight: 100">Artwork & other fees ($) </th>
                                <td><input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="artwork"
                                        id="artwork" value='{{ number_format($order->artwork, 2) }}' style="color: #717070" readonly /></td>
                            </tr>
                            @can('view discount')
                                <tr style="color: #717070" class="discount_row">
                                    <th style="font-weight: 100">
                                        <span style="margin-right: 3%;">Discount</span>
                                        <input type="radio" id="percentage" name="discount" value="percentage" {{ $order->discountType == 1 ? 'checked' : '' }} disabled>
                                        <label for="percentage" style="margin-right: 3%;">%</label>
                                        <input type="radio" id="value" name="discount" value="value" {{ $order->discountType == 2 ? 'checked' : '' }} disabled>
                                        <label for="value">$</label>
                                    </th>
                                    <input type="hidden" id="discountType" name="discountType" value="{{ $order->discountType }}">
                                    <input type="hidden" id="isDiscountAvailable value="{{ $order->discount_hidation }}">

                                    <td style="width: 30%;">
                                        <input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="discount" id="discount_value" value='{{ $order->discount }}' readonly style="color: #717070" />
                                    </td>
                                </tr><br>
                            @endcan
                            @php
                            $order_total_amount = $order->sub_total + $order->shipping + $order->artwork;
                            if($order->discount_hidation == 1 ){

                                if($order->discountType == 1){

                                    $discountAmount = ($order_total_amount / 100) * $order->discount;

                                } elseif($order->discountType == 2) {

                                    $discountAmount = $order->discount;
                                }

                            }else{
                                $discountAmount = 0.00;
                            }
                            @endphp
                            <tr style="color: #717070;font-weight:100">
                                <th style="font-weight: 100">Total invoice amount ($)</th>
                                <td>
                                    <input class="invoice-inputs text-right item-table-border invoicein0001" type='text'style="color: #717070" id="total_invoice_amount" value='{{ number_format($order_total_amount - $discountAmount, 2) }}'
                                        readonly />
                                </td>
                            </tr>
                            <tr style="color: #717070;font-weight:100">
                                <th style="font-weight: 100">Sales Tax ($) <span id="sales_tax_display">{{ $order->organizationDetails['sales_tax'] }}</span>%  RATE </th>
                                <td>
                                    <input type="hidden" id="sales_tax_percentage item-table-border"
                                        value="{{ $order->organizationDetails['sales_tax'] }}" />
                                    <input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="sales_tax"
                                        id="sales_tax" style="color: #717070" value='{{ number_format($order->sales_tax, 2) }}'
                                        readonly />
                                </td>
                            </tr>

                            <tr>
                                <th class="total" style="font-size: .8rem !important;color:black">Invoice amount ($) + Sales Tax </th>
                                <td>
                                    <input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="order_total" id="order_total" value='{{ number_format($order->order_total, 2) }}' readonly style="font-weight: bold; font-size: 1rem;" />
                                </td>
                            </tr>

                            <tr style="color: #717070">
                                <th style="font-weight: 100">Paid amount ($)</th>
                                <td>
                                    <input class="invoice-inputs text-right item-table-border invoicein0001" style="color: #717070" type='text' id="paid_full_amount" value='{{ number_format($totalPayment, 2) }}' disabled/>
                                </td>
                            </tr>
                            <tr style="color: #717070">
                                <th style="font-weight: 100">Paid processing fees ($)</th>
                                <td>
                                    <input class="invoice-inputs text-right item-table-border invoicein0001" style="color: #717070" type='text' name="processing_fee" id="processing_fee" value='{{ number_format($processingFee, 2) }}' disabled/>
                                </td>
                            </tr><br>

                            @if ($paymentStatus == 1)
                                <tr>
                                    <th style="color: black">Balance Invoice amount ($)</th>
                                    <td  colspan="2"><input class="invoice-inputs text-right" type='text' name="balance_payment"
                                        id="balance_payment" value='{{ number_format($balnceToBePaid, 2) }}'
                                        readonly style="font-weight: bold; font-size: large;" /></td>
                                </tr>
                            @endif
                            <tr>
                                <th style="color: black">Payment Status </th>
                                @if ($paymentStatus == 0)
                                    <td style="text-align: end;">
                                        <input type="text" class="payment-lable-style" value="Pending" style="background-color: #adb5bd; color: #ffffff;" readonly>
                                    </td>
                                @elseif ($paymentStatus == 1)
                                    <td style="text-align: end;">
                                        <input type="text" class="payment-lable-style" value="Partial" style="background-color: #fb6340; color: #ffffff;" readonly></td>
                                @else
                                    <td style="text-align: end;">
                                        <input type="text" class="payment-lable-style" value="Paid" style="background-color: #2dce89; color: #ffffff;" readonly></td>
                                @endif
                            </tr>
                        </table>
                    </div>
                @endcan
            </div>
        </div>


    @endforeach
</div>
