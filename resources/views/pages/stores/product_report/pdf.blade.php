<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Product Report - {{ $store->store_name ?? '' }}</title>

    <style>
        @page { margin: 30px 20px; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #999;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .header-bar h1 {
            margin: 0;
            font-size: 16px;
        }

        .header-bar div {
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: auto;
        }

        thead {
            background-color: #717070;
            color: #fff;
        }

        th, td {
            border: 1px solid #DEDEDE;
            padding: 6px 5px;
            text-align: center;
            vertical-align: middle;
            word-break: break-word;
        }

        .group-row {
            background-color: #f3f3f3;
            font-weight: 600;
        }

        .text-left { text-align: left; }
        .text-right { text-align: right; }

        img.product-img {
            height: 45px;
            width: auto;
            vertical-align: middle;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="header-bar">
        <h1>{{ $store->store_name ?? 'Store' }} — Product Report</h1>
        <div>{{ now()->format('M d, Y h:i A') }}</div>
    </div>

    @php
        // Flatten all order items
        $orderItems = $store->StoreOrders->map->OrderItems->flatten();

        // Group them by productDetails->id
        $groupedItems = $orderItems->groupBy(function($item) {
            return optional($item->productDetails)->id;
        })->filter();
    @endphp

    @foreach ($groupedItems as $productId => $items)
        @php
            $product = optional($items->first())->productDetails;
            $productName = $product->product_name ?? 'Unnamed Product';
            $totalQty = $items->sum('qty');
        @endphp

        <div class="group-row" style="margin-top: 15px; padding: 5px 0;">
            <h3 style="margin: 0; font-size: 13px;">
                {{ $productName }} — (Total Qty: {{ $totalQty }})
            </h3>
        </div>

        <table style="margin-bottom: 1rem;">
            <thead>
                <tr>
                    <th style="width: 20%;">NAME</th>
                    <th style="width: 15%;">NUMBER</th>
                    <th style="width: 15%;">SIZE</th>
                    <th style="width: 10%;">QTY</th>
                    <th style="width: 20%;" class="text-right">TOTAL ($)</th>
                    <th style="width: 20%;" class="text-right">PAID ($)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $productSizes = [31, 1, 2, 3, 4, 5, 6, 7, 8, 9, 26, 17, 18, 19, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 25, 16, 28, 29];

                    $allDetails = $items->flatMap(function ($orderItem) {
                        return $orderItem->OrderItemDetails;
                    });

                    $sortedDetails = $allDetails
                        ->groupBy('size')
                        ->sortBy(function ($group, $size) use ($productSizes) {
                            $index = array_search($size, $productSizes, true);
                            return $index !== false ? $index : PHP_INT_MAX;
                        })
                        ->flatten(1)
                        ->values();
                @endphp
                @foreach ($sortedDetails as $detail)
                    <tr>
                        <td>{{ $detail->player_name ?? '-' }}</td>
                        <td>{{ $detail->player_number ?? '-' }}</td>
                        <td>{{ optional($detail->SizeDetails)->size_name ?? '-' }}</td>
                        <td>{{ $detail->qty ?? 0 }}</td>
                        <td class="text-right">{{ number_format($detail->total_amount ?? 0, 2) }}</td>
                        <td class="text-right">{{ number_format($detail->paid_amount ?? 0, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
