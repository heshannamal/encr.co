<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - {{ $receipt->store_order_no }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #pdf_print {
            width: 210mm;
            max-width: 100%;
            margin: 0 auto;
            background: #fff;
        }
        .card {
            border-radius: 0;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .receipt-header {
            background-color: #dddddd;
            padding: 0.75rem 1rem;
            font-weight: bold;
        }
        .download-btn {
            background-color: #17a2b8;
            color: black;
            border: none;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 14px;
            float: right;
        }
        .download-btn:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>
<div id="pdf_print" style="font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0;">
    <div style="max-width: 800px; margin: 20px 20px; padding: 20px; border: 1px solid #ccc;">
        <div style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center;">
                @if (!empty($store->themeDetails->secondary_logo))
                    <img src="{{ asset($store->themeDetails->secondary_logo) }}" alt="Store Logo" style="height: 60px; margin-right: 15px;">
                @endif
                <div>
                    <h2 style="margin: 0;">{{ $store->store_name }} - {{ $receipt->store_order_no }}</h2>
                    <p style="margin: 2px 0;">Date: {{ \Carbon\Carbon::parse($receipt->created_at)->setTimezone('America/Los_Angeles')->format('F jS, Y (g:i A)') }}</p>
                </div>
            </div>
        </div>

        {{-- Address Info --}}
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div style="width: 48%;">
                <h4 style="margin-bottom: 10px;">Billing Information:</h4>
                <p style="margin: 0;"><strong>{{ $receipt->customer_details['first_name'] ?? '' }} {{ $receipt->customer_details['last_name'] ?? '' }}</strong></p>
                <p style="margin: 0;">{{ $receipt->customer_details['street'] ?? '' }}</p>
                <p style="margin: 0;">{{ $receipt->customer_details['city'] ?? '' }}, {{ $receipt->customer_details['state'] ?? '' }} {{ $receipt->customer_details['postal_code'] ?? '' }}</p>
                <p style="margin: 0;">{{ $receipt->customer_details['country'] ?? '' }}</p>
                <p style="margin: 0;">Email: {{ $receipt->customer_details['email'] ?? '' }}</p>
                <p style="margin: 0;">Phone: {{ $receipt->customer_details['phone'] ?? '' }}</p>
            </div>

            <div style="width: 48%;">
                <h4 style="margin-bottom: 10px;">Shipping Information:</h4>
                <p style="margin: 0;margin-bottom: .5rem;">Shipping Method:<em>{{ '  '.$receipt->shipping_details['shipping_method'] ?? 'N/A' }}</em></p>
                <p style="margin: 0;"><strong>{{ $receipt->shipping_details['first_name'] ?? '' }} {{ $receipt->shipping_details['last_name'] ?? '' }}</strong></p>
                <p style="margin: 0;">{{ $receipt->shipping_details['street'] ?? '' }}</p>
                <p style="margin: 0;">{{ $receipt->shipping_details['city'] ?? '' }}, {{ $receipt->shipping_details['state'] ?? '' }} {{ $receipt->shipping_details['postal_code'] ?? '' }}</p>
                <p style="margin: 0;">{{ $receipt->shipping_details['country'] ?? '' }}</p>
                <p style="margin: 0;">Email: {{ $receipt->shipping_details['email'] ?? '' }}</p>
                <p style="margin: 0;">Phone: {{ $receipt->shipping_details['phone'] ?? '' }}</p>
            </div>
        </div>

        {{-- Order Items --}}
        <h4 style="margin-top: 30px; margin-bottom: 10px;">Order Items</h4>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px;">#</th>
                    <th style="border: 1px solid #ddd; padding: 8px;">Image</th>
                    <th style="border: 1px solid #ddd; padding: 8px;">Product Name</th>
                    <th style="border: 1px solid #ddd; padding: 8px;width:20%">Details</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">Unit Price</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">Qty</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($receipt->order_items) && is_array($receipt->order_items))
                    @foreach ($receipt->order_items as $index => $item)
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">
                            <img src="{{ $item['image_url'] }}" alt="Image" style="width: 60px;">
                        </td>
                        <td style="border: 1px solid #ddd; padding: 8px;">
                            {{ $item['product_name'] }}
                            <strong>{{ !empty(reset($item['item_sizes'])['sub_team']) ? ' (Team : '.reset($item['item_sizes'])['sub_team'].')' : '' }}</strong>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 8px;" class="text-left">
                            @if (!empty($item['item_sizes']))
                                <div style="font-size: 12px;">
                                    @foreach ($item['item_sizes'] as $sizeDetail)
                                        @php
                                            $playerName = $sizeDetail['player_name'] ?? null;
                                            $playerNumber = $sizeDetail['player_number'] ?? null;
                                        @endphp
                                        @if(($playerName !== null && $playerName !== '' && $playerName !== 'null') || ($playerNumber !== null && $playerNumber !== ''))
                                            <div style="display: flex; justify-content: space-between;">
                                                <span>
                                                    @if($playerName !== null && $playerName !== '' && $playerName !== 'null')
                                                    Name: {{ $sizeDetail['player_name'] ?? 'N/A' }}
                                                    @endif
                                                    @if($playerNumber !== null && $playerNumber !== '')
                                                    <br> Number: {{ $sizeDetail['player_number'] ?? 'N/A' }}
                                                    @endif
                                                </span>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">${{ number_format($item['price'], 2) }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                            @if (!empty($item['item_sizes']))
                                <small>
                                    @foreach ($item['item_sizes'] as $sizeDetail)
                                        {{ $sizeDetail['size'] }}: {{ $sizeDetail['qty'] }}
                                        <br>
                                    @endforeach
                                </small>
                            @else
                                {{ $item['qty'] }}
                            @endif
                        </td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">${{ number_format($item['total_price'], 2) }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No items found.</td>
                    </tr>
                @endif
                @if (!empty($receipt->order_details['coupon_details']))
                <tr style="border-bottom: 1px solid #DEDEDE;">
                    <td scope="col" colspan="6" class="table_body text-left" style="font-size: large;color: #0aa636;">
                        You have applied coupon code "<strong>{{ $receipt->order_details['coupon_code'] }}</strong>" with
                        @if($receipt->order_details['coupon_details']['type'] == 'free_shipping')
                            Free Shipping.
                        @elseif($receipt->order_details['coupon_details']['type'] == 'flat_from_sub')
                            ${{ number_format($receipt->order_details['coupon_details']['amount'], 2) }} Off from Sub Total.
                        @elseif($receipt->order_details['coupon_details']['type'] == 'percentage_from_sub')
                            {{ rtrim(rtrim(number_format($receipt->order_details['coupon_details']['amount'], 2), '0'), '.') }}% Off from Sub Total.
                        @elseif($receipt->order_details['coupon_details']['type'] == 'flat_from_grand')
                            ${{ number_format($receipt->order_details['coupon_details']['amount'], 2) }} Off from Grand Total.
                        @elseif($receipt->order_details['coupon_details']['type'] == 'percentage_from_grand')
                            {{ rtrim(rtrim(number_format($receipt->order_details['coupon_details']['amount'], 2), '0'), '.') }}% Off from Grand Total.
                        @else
                            Discount Applied
                        @endif
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        @if(isset($receipt->order_details['refund_details']) && !empty($receipt->order_details['refund_details']))
            <h4 style="margin-top: 30px; margin-bottom: 10px;color:rgb(245, 122, 122);">Refund Details</h4>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;color:rgb(245, 122, 122);">
                <tr>
                    <td style="padding: 5px;">Refunded Amount:</td>
                    <td style="text-align: right;">${{ number_format($receipt->order_details['refund_details']['refund_amount'], 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Refund Date:</td>
                    <td style="text-align: right;">{{ \Carbon\Carbon::parse($receipt->created_at)->setTimezone('America/Los_Angeles')->format('F jS, Y (g:i A)') }}</td>
                </tr>
            </table>
        @endif

        {{-- Totals --}}
        <table style="width: 300px; float: right; border-collapse: collapse;">
            <tr>
                <td style="padding: 5px;">Subtotal:</td>
                <td style="text-align: right;">${{ number_format($receipt->order_details['sub_total'], 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Shipping:</td>
                <td style="text-align: right;">${{ number_format($receipt->order_details['shipping'], 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Handling Fee:</td>
                <td style="text-align: right;">${{ number_format($receipt->order_details['handling_fee'], 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Sales Tax:</td>
                <td style="text-align: right;">${{ number_format($receipt->order_details['sales_tax'], 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px; font-weight: bold;">Total:</td>
                <td style="text-align: right; font-weight: bold;">${{ number_format($receipt->order_details['total'], 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Paid Amount:</td>
                <td style="text-align: right;">${{ isset($receipt->order_details['paid_invoice_amount']) ? number_format($receipt->order_details['paid_invoice_amount'], 2) : number_format($receipt->order_details['total'], 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;">Paid Processing Fee:</td>
                <td style="text-align: right;">${{ isset($receipt->order_details['paid_processing_fee']) ? number_format($receipt->order_details['paid_processing_fee'], 2) : number_format(($receipt->order_details['total'] * 3/100), 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 5px; font-weight: bold;">Total Paid Amount:</td>
                <td style="text-align: right; font-weight: bold;">${{ isset($receipt->order_details['paid_amount']) ? number_format($receipt->order_details['paid_amount'], 2) : number_format(($receipt->order_details['total'] * 103/100), 2) }}</td>
            </tr>
            @if(isset($receipt->order_details['paid_invoice_amount']) && $receipt->order_details['paid_invoice_amount'] > $receipt->order_details['total'])
            <tr>
                <td style="padding: 5px; font-weight: bold;color:rgb(150, 249, 125)">Overpaid Amount:</td>
                <td style="text-align: right; font-weight: bold;color:rgb(150, 249, 125);">${{ number_format($receipt->order_details['paid_invoice_amount'] - $receipt->order_details['total'], 2) }}</td>
            </tr>
            @endif

            @if(isset($receipt->order_details['paid_invoice_amount']) && $receipt->order_details['paid_invoice_amount'] < $receipt->order_details['total'])
            <tr>
                <td style="padding: 5px; font-weight: bold;color:rgb(245, 122, 122)">Amount Due:</td>
                <td style="text-align: right; font-weight: bold;color:rgb(245, 122, 122);">${{ number_format($receipt->order_details['total'] - $receipt->order_details['paid_invoice_amount'], 2) }}</td>
            </tr>
            @endif
        </table>

        <div style="clear: both;"></div>

        {{-- Notes --}}
        @if (!empty($receipt->order_details['notes']))
        <div style="margin-top: 30px;">
            <h5>Order Notes</h5>
            <p>{{ $receipt->order_details['notes'] }}</p>
        </div>
        @endif

        {{-- Tracking --}}
        @if (!empty($receipt->order_details['tracking_no']))
        <div style="margin-top: 20px;">
            <h5>Tracking Info</h5>
            <p>Tracking Number: {{ $receipt->order_details['tracking_no'] }}</p>
            @if (!empty($receipt->order_details['tracking_link']))
            <p><a href="{{ $receipt->order_details['tracking_link'] }}" target="_blank">Track Order</a></p>
            @endif
        </div>
        @endif

        <div style="margin-top: 40px; text-align: center;">
            <p>Thank you for your order!</p>
        </div>
    </div>
</div>

</body>
</html>
