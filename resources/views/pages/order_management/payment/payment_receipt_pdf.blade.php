<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt - Order #{{ $order_number }}</title>
    <style>
        @page { margin: 18px; }

        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #111827;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
        }

        table { border-collapse: collapse; }

        .page { width: 100%; }

        .brand {
            background: #111827;
            padding: 14px 20px;
            text-align: center;
        }

        .brand img {
            width: 175px;
            max-width: 175px;
        }

        .title-bar {
            background: #64748b;
            color: #ffffff;
            text-align: center;
            padding: 10px 20px;
        }

        .title-main {
            font-size: 17px;
            font-weight: 700;
        }

        .title-sub {
            margin-top: 3px;
            color: #e2e8f0;
            font-size: 10px;
        }

        .section { padding: 12px 34px 0 34px; }

        .order-title {
            font-size: 16px;
            font-weight: 700;
        }

        .muted { color: #6b7280; }

        .box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .box-title {
            margin-bottom: 7px;
            color: #111827;
            font-size: 12px;
            font-weight: 700;
        }

        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .label {
            width: 105px;
            color: #6b7280;
        }

        .items {
            width: 100%;
            border: 1px solid #eeeeee;
        }

        .items th {
            padding: 7px 8px;
            color: #6b7280;
            background: #f9fafb;
            border-bottom: 1px solid #eeeeee;
            font-size: 9px;
            text-align: left;
        }

        .items td {
            padding: 7px 8px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
        }

        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }

        .summary-table { width: 100%; }

        .summary-table td { padding: 3px 0; }

        .summary-label { color: #4b5563; }

        .dash {
            border-top: 1px dashed #d1d5db;
            height: 1px;
        }

        .green {
            color: #16a34a;
            font-weight: 700;
        }

        .orange {
            color: #b45309;
            font-weight: 700;
        }

        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 14px;
            color: #ffffff;
            font-size: 9px;
            font-weight: 700;
        }

        .receipt-image {
            max-width: 230px;
            max-height: 145px;
            border: 1px solid #e5e7eb;
        }

        .check-image {
            width: 150px;
            max-height: 100px;
            border: 1px solid #e5e7eb;
        }

        .footer {
            margin-top: 14px;
            padding: 12px 20px;
            text-align: center;
            background: #ECEBE5;
            color: #6b7280;
            font-size: 9px;
        }

        .footer img {
            width: 135px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<table class="page" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td class="brand">
            @if($logo)
                <img src="{{ $logo }}" alt="Encore Custom">
            @endif
        </td>
    </tr>

    <tr>
        <td class="title-bar">
            <div class="title-main">Payment Receipt</div>
            <div class="title-sub">Payment record for Order #{{ $order_number }}</div>
        </td>
    </tr>

    <tr>
        <td class="section">
            <div class="order-title">
                {{ $organization_name ? $organization_name . ' - ' : '' }}Order #{{ $order_number }}
            </div>
            <div class="muted" style="margin-top:3px;">
                {{ $customer_name ? 'Customer: ' . $customer_name : '' }}
            </div>
        </td>
    </tr>

    <tr>
        <td class="section">
            <table width="100%" cellpadding="0" cellspacing="0" class="box">
                <tr>
                    <td style="padding:12px 14px;">
                        <div class="box-title">Shipping Information</div>

                        <table width="100%" class="info-table">
                            <tr>
                                <td class="label">Name</td>
                                <td><strong>{{ $customer_name }}</strong></td>
                            </tr>
                            <tr>
                                <td class="label">Address</td>
                                <td>
                                    {{ $customer_street }}
                                    {{ $customer_city }}
                                    @if($customer_city && $customer_state),@endif
                                    {{ $customer_state }}
                                    {{ $customer_postal }}
                                    {{ $customer_country }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Email</td>
                                <td>{{ $customer_email }}</td>
                            </tr>
                            <tr>
                                <td class="label">Phone</td>
                                <td>{{ $customer_phone }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    @if(!empty($order_items))
        <tr>
            <td class="section">
                <div class="box-title">Order Items</div>

                <table class="items">
                    <thead>
                        <tr>
                            <th style="width:28px;">#</th>
                            <th>PRODUCT NAME</th>
                            <th class="text-right" style="width:92px;">UNIT PRICE</th>
                            <th class="text-center" style="width:48px;">QTY</th>
                            <th class="text-right" style="width:92px;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order_items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ $item['product_name'] }}
                                    @if(!empty($item['size']))
                                        <div class="muted" style="font-size:9px;margin-top:2px;">
                                            Size: {{ $item['size'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-right">${{ number_format((float) $item['price'], 2) }}</td>
                                <td class="text-center">{{ $item['qty'] }}</td>
                                <td class="text-right"><strong>${{ number_format((float) $item['total'], 2) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    @endif

    <tr>
        <td class="section">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="49%" valign="top" class="box" style="padding:12px 14px;">
                        <div class="box-title">Payment Details</div>

                        <table width="100%" class="info-table">
                            <tr>
                                <td class="label">Method</td>
                                <td><strong>{{ $payment_method }}</strong></td>
                            </tr>
                            <tr>
                                <td class="label">Transaction ID</td>
                                <td><strong>{{ $transaction_id }}</strong></td>
                            </tr>
                            <tr>
                                <td class="label">Date</td>
                                <td>{{ $payment_date }}</td>
                            </tr>
                            <tr>
                                <td class="label">Time</td>
                                <td>{{ $payment_time }}</td>
                            </tr>
                            <tr>
                                <td class="label">Paid Amount</td>
                                <td><strong>${{ number_format((float) $paid_amount, 2) }}</strong></td>
                            </tr>

                            @if((float) $processing_fee > 0)
                                <tr>
                                    <td class="label">Processing Fee</td>
                                    <td>${{ number_format((float) $processing_fee, 2) }}</td>
                                </tr>
                            @endif

                            @if($card_owner)
                                <tr>
                                    <td class="label">Name on Card</td>
                                    <td>{{ $card_owner }}</td>
                                </tr>
                            @endif

                            @if($card_last_digits)
                                <tr>
                                    <td class="label">Card</td>
                                    <td>**** **** **** {{ $card_last_digits }}</td>
                                </tr>
                            @endif
                        </table>

                        <div style="margin-top:8px;">
                            <span class="status" style="background:{{ $payment_status_color }};">
                                {{ strtoupper($payment_status) }}
                            </span>
                        </div>

                        @if($check_front || $check_back)
                            <div class="box-title" style="margin-top:12px;">Check Images</div>
                            <table width="100%">
                                <tr>
                                    <td width="49%" class="text-center">
                                        @if($check_front)
                                            <img src="{{ $check_front }}" class="check-image" alt="Check Front">
                                            <div class="muted" style="margin-top:3px;">Front</div>
                                        @endif
                                    </td>
                                    <td width="2%"></td>
                                    <td width="49%" class="text-center">
                                        @if($check_back)
                                            <img src="{{ $check_back }}" class="check-image" alt="Check Back">
                                            <div class="muted" style="margin-top:3px;">Back</div>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        @endif

                        @if($payment_receipt_image)
                            <div class="box-title" style="margin-top:12px;">{{ $payment_method }} Receipt</div>
                            <div class="text-center">
                                <img src="{{ $payment_receipt_image }}"
                                     class="receipt-image"
                                     alt="{{ $payment_method }} Receipt">
                            </div>
                        @endif
                    </td>

                    <td width="2%"></td>

                    <td width="49%" valign="top" class="box" style="padding:12px 14px;">
                        <div class="box-title">Payment Summary</div>

                        <table class="summary-table">
                            <tr>
                                <td class="summary-label">Invoice amount:</td>
                                <td class="text-right">${{ number_format((float) $sub_total, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="summary-label">Artwork & other fees:</td>
                                <td class="text-right">${{ number_format((float) $artwork, 2) }}</td>
                            </tr>

                            @if((float) $discount_amount > 0)
                                <tr>
                                    <td class="summary-label">Discount:</td>
                                    <td class="text-right">-${{ number_format((float) $discount_amount, 2) }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td class="summary-label"><strong>Total invoice amount:</strong></td>
                                <td class="text-right"><strong>${{ number_format((float) $total_invoice_amount, 2) }}</strong></td>
                            </tr>

                            @if($sales_tax_rate !== null && $sales_tax_rate !== '')
                                <tr>
                                    <td class="summary-label">Sales Tax ({{ $sales_tax_rate }}%):</td>
                                    <td class="text-right">${{ number_format((float) $sales_tax, 2) }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td class="summary-label">Shipping Fee:</td>
                                <td class="text-right">${{ number_format((float) $shipping_fee, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="summary-label"><strong>Grand Total:</strong></td>
                                <td class="text-right"><strong>${{ number_format((float) $order_total, 2) }}</strong></td>
                            </tr>

                            <tr>
                                <td colspan="2" style="padding:6px 0;"><div class="dash"></div></td>
                            </tr>

                            <tr>
                                <td class="green">This Payment:</td>
                                <td class="text-right green">${{ number_format((float) $paid_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="green">Total Payments Received:</td>
                                <td class="text-right green">${{ number_format((float) $total_paid, 2) }}</td>
                            </tr>

                            @if((float) $balance_remaining > 0)
                                <tr>
                                    <td class="orange">Balance Remaining:</td>
                                    <td class="text-right orange">${{ number_format((float) $balance_remaining, 2) }}</td>
                                </tr>
                            @endif
                        </table>

                        <div style="margin-top:10px;">
                            <span class="status" style="background:{{ $order_payment_status_color }};">
                                ORDER {{ strtoupper($order_payment_status) }}
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td class="section text-center" style="padding-top:14px;">
            <div style="font-size:13px;font-weight:700;">Thank you for your business!</div>
        </td>
    </tr>

    <tr>
        <td class="footer">
            @if($footer_logo)
                <img src="{{ $footer_logo }}" alt="Encore Custom">
            @endif
            <div style="font-style:italic;margin-bottom:4px;">
                The quality of your apparel reflects the quality of your brand.
            </div>
            <div>www.EncoreCustom.com</div>
        </td>
    </tr>
</table>
</body>
</html>
