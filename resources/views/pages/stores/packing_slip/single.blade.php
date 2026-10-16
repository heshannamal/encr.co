<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Packing Slip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 10px;
        }

        .title {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .subtitle {
            font-size: 18px;
            margin-bottom: 24px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th {
            background: #f0f0f0;
            font-size: 12px;
            text-transform: uppercase;
            text-align: left;
            padding: 8px 6px;
            border-bottom: 1px solid #ddd;
        }
        td {
            padding: 8px 6px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }

        .info-header td {
            font-size: 12px;
            border: 1px solid #e5e5e5;
            padding: 10px;
        }

        .info-label {
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            font-size: 11px;
            padding-bottom: 3px;
        }

        .product-image {
            width: 80px;
            height: auto;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 0px;
        }

        .small-grey {
            font-size: 11px;
            color: #777;
            display: block;
            margin-top: 2px;
        }

        .qty-box {
            border: 1px solid #999;
            width: 14px;
            height: 14px;
            display: inline-block;
            margin-left: 8px;
        }

        .item-count {
            font-size: 11px;
            color: #777;
            padding-top: 6px;
        }

        /* bottom three cells like screenshot */
        .footer-table td {
            background: #f0f0f0;
            font-size: 12px;
            text-transform: uppercase;
            padding: 8px 6px;
            border-top: 1px solid #ccc;
            font-weight: bold;
        }

        .dealer-info {
            font-size: 12px;
            margin-top: 8px;
            line-height: 1.5;
        }
    </style>
</head>

    <body>

        <div class="title">Packing Slip</div>
        <div class="subtitle">{{ $order->CustomerDetails->first_name }} {{ $order->CustomerDetails->last_name }}</div>

        <table style="width:100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background:#f0f0f0; text-transform:uppercase; font-size:12px; color:#555;">
                    <th style="text-align:left; padding:8px 6px; font-weight:bold;">Customer Details</th>
                    <th style="text-align:left; padding:8px 6px; font-weight:bold;">Order #</th>
                    <th style="text-align:left; padding:8px 6px; font-weight:bold;">Shipping Method</th>
                </tr>
            </thead>

            @php
                $CustomerPhone = trim((string) optional($order->CustomerDetails)->phone_number);
                $OrderPhone = trim((string) optional($order)->phone);
            @endphp

            <tbody>
                <tr style="border-bottom:1px solid #e5e5e5;">
                    <td style="padding:10px 6px;">
                        {{ $order->CustomerDetails->first_name }} {{ $order->CustomerDetails->last_name }}<br>
                        @if($CustomerPhone !== '' && strtolower($CustomerPhone) !== 'null') {{ $CustomerPhone }} <br> @endif
                        {{ $order->CustomerDetails->email }}
                    </td>

                    <td style="padding:10px 6px;">
                        {{ $order->order_no }}<br>
                        {{ $order->created_at->format('F d, Y') }}
                    </td>

                    <td style="padding:10px 6px;">
                        {{ $order->shippingMethodDetails->shipping_method_name ?? 'Direct Ship to Customers' }}
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="width:100%; border-collapse: collapse; margin-top: 25px;">
            <thead>
                <tr style="background:#f0f0f0; text-transform:uppercase; font-size:12px; color:#555;">
                    <th style="text-align:left; padding:8px 6px; font-weight:bold;">Shipping Details</th>
                    <th style="text-align:left; padding:8px 6px; font-weight:bold;">Billing Details</th>
                    <th style="text-align:left; padding:8px 6px; font-weight:bold;">Store Details</th>
                </tr>
            </thead>

            <tbody>
                <tr style="border-bottom:1px solid #e5e5e5;">
                    <td style="padding:10px 6px;">
                        {{ $order->first_name }} {{ $order->last_name }}<br>
                        {{ $order->street }}<br>
                        {{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}<br>
                        {{ $order->country }}<br>
                        @if($OrderPhone !== '' && strtolower($OrderPhone) !== 'null') {{ $OrderPhone }}<br> @endif
                        @if(!empty($order->email)) {{ $order->email }} @endif
                    </td>

                    <td style="padding:10px 6px;">
                        {{ $order->CustomerDetails->first_name }} {{ $order->CustomerDetails->last_name }}<br>
                        {{ $order->CustomerDetails->street }}<br>
                        {{ $order->CustomerDetails->city }}, {{ $order->CustomerDetails->state }} {{ $order->CustomerDetails->postal_code }}<br>
                        {{ $order->CustomerDetails->country }}<br>
                        @if($CustomerPhone !== '' && strtolower($CustomerPhone) !== 'null') {{ $CustomerPhone }}<br> @endif
                        @if(!empty($order->CustomerDetails->email)) {{ $order->CustomerDetails->email }} @endif
                    </td>

                    <td style="padding:10px 6px;">
                        {{ $order->storeDetails->store_name }}<br>
                        {{ $order->storeDetails->store_code ?? '' }}
                    </td>
                </tr>
            </tbody>
        </table>

        @php
            $sumOfItems = 0;
            foreach ($order->OrderItems as $item) {
                foreach ($item->OrderItemDetails as $detail) {
                    $sumOfItems ++;
                }
            }
            $countOfLoad = 0;
        @endphp


        <table>
            <thead>
                <tr>
                    <th width="15%"></th>
                    <th width="30%">DETAIL</th>
                    <th width="20%">SIZE</th>
                    <th width="20%">OPTIONS</th>
                    <th width="15%">QTY ({{ $sumOfItems }})</th>
                </tr>
            </thead>

            <tbody>

            @foreach ($order->OrderItems as $item)
                @foreach ($item->OrderItemDetails as $detail)

                <tr>
                    <td>
                        @if ($item->base64_image)
                            <img src="{{ $item->base64_image }}" alt="Product Image" style="width:80px; height:auto;">
                        @endif
                    </td>
                    <td>
                        {{ $item->productDetails->product_name ?? '' }}
                    </td>

                    <td>{{ $detail->SizeDetails->size_name ?? '-' }}</td>

                    <td>
                        @if($item->productDetails->set_individual_name == 1)
                            Name : {{ $detail->player_name }}
                        @endif
                        <br>
                        @if($item->productDetails->set_individual_number == 1)
                            Number : {{ $detail->player_number }}
                        @endif
                    </td>

                    <td>
                        {{ $detail->qty }} <br>
                        (Item {{ $countOfLoad + 1 }} of {{ $sumOfItems }})
                    </td>
                </tr>
                @php
                    $countOfLoad ++;
                @endphp
                @endforeach
            @endforeach

            </tbody>
        </table>

        <table class="footer-table" width="100%">
            <tr>
                <td width="33%">Dealer Info</td>
            </tr>
        </table>

        <div class="dealer-info">
            {{ $order->storeDetails->service_email ?? 'info@encr.co' }}<br>
            {{ $order->storeDetails->service_phone ?? '+1 888-501-4999' }}<br>
            {{ $order->storeDetails->service_website ?? 'www.encorecustom.com' }}<br>
        </div>

    </body>
</html>
