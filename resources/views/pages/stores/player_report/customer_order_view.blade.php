<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Order #{{ $order->order_no ?? 'N/A' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

    <style>
        :root {
            --primary: #111827;
            --secondary: #6b7280;
            --muted: #f3f4f6;
            --border: #e5e7eb;
            --accent: #47D6B6;
            --danger: #ef4444;
            --success: #16a34a;
            --warning: #f59e0b;
            --white: #ffffff;
        }

        body {
            margin: 0;
            background: #eef1f5;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--primary);
            font-size: 14px;
        }

        .invoice-page {
            max-width: 1120px;
            margin: 30px auto;
            padding: 0 16px;
        }

        .invoice-card {
            background: var(--white);
            border-radius: 18px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .invoice-header {
            background: linear-gradient(135deg, #111827 0%, #374151 100%);
            color: #ffffff;
            padding: 34px;
        }

        .store-logo {
            max-height: 64px;
            max-width: 180px;
            object-fit: contain;
            background: #ffffff;
            border-radius: 12px;
            padding: 8px;
        }

        .invoice-title {
            font-size: 34px;
            font-weight: 800;
            letter-spacing: 1px;
            margin: 0;
            text-transform: uppercase;
        }

        .invoice-subtitle {
            color: #d1d5db;
            font-size: 13px;
            margin-top: 6px;
        }

        .invoice-body {
            padding: 34px;
        }

        .info-card {
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            height: 100%;
            background: #ffffff;
        }

        .info-card.light {
            background: #f9fafb;
        }

        .info-title {
            font-size: 12px;
            color: var(--secondary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 12px;
        }

        .info-main {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .info-line {
            color: #4b5563;
            margin-bottom: 4px;
            word-break: break-word;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            color: black;
            min-width: 90px;
        }

        .payment-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 18px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
        }

        .invoice-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 26px;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 16px;
        }

        .invoice-table thead th {
            background: #111827;
            color: #ffffff;
            padding: 14px 16px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .invoice-table tbody td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .invoice-table tbody tr:last-child td {
            border-bottom: none;
        }

        .product-box {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .product-img-wrap {
            width: 74px;
            height: 74px;
            border-radius: 12px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .product-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .product-name {
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 5px;
            font-size: 14px;
        }

        .product-meta {
            font-size: 12px;
            color: var(--secondary);
            margin-bottom: 2px;
        }

        .totals-wrapper {
            margin-top: 26px;
            display: flex;
            justify-content: flex-end;
        }

        .totals-card {
            width: 100%;
            max-width: 420px;
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 18px;
            border-bottom: 1px solid var(--border);
            color: #4b5563;
        }

        .total-row:last-child {
            border-bottom: none;
        }

        .total-row.grand {
            background: #111827;
            color: #ffffff;
            font-size: 20px;
            font-weight: 800;
            padding: 18px;
        }

        .total-row.payment-status {
            background: #f9fafb;
        }

        .section {
            margin-top: 30px;
        }

        .section-heading {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 16px;
            color: var(--primary);
        }

        .mini-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .mini-table th {
            background: #f3f4f6;
            color: #374151;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 12px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .mini-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            color: #4b5563;
            font-size: 13px;
            vertical-align: middle;
        }

        .mini-table tr:last-child td {
            border-bottom: none;
        }

        .receipt-box {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 14px;
            background: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .download-receipt-btn {
            background: var(--primary);
            color: #ffffff;
            border: none;
            padding: 7px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .download-receipt-btn:hover {
            background: #374151;
            color: #ffffff;
        }

        .empty-box {
            border: 1px dashed var(--border);
            border-radius: 14px;
            padding: 18px;
            color: var(--secondary);
            background: #f9fafb;
        }

        .coupon-alert {
            margin-top: 18px;
            padding: 14px 16px;
            border-radius: 14px;
            background: #ecfdf5;
            color: #047857;
            font-weight: 600;
            border: 1px solid #a7f3d0;
        }

        .footer-note {
            margin-top: 30px;
            padding: 18px;
            background: #f9fafb;
            border-radius: 14px;
            color: var(--secondary);
            font-size: 13px;
            text-align: center;
        }

        @media print {
            body {
                background: #ffffff;
            }

            .invoice-page {
                margin: 0;
                max-width: 100%;
                padding: 0;
            }

            .invoice-card {
                box-shadow: none;
                border-radius: 0;
            }

            .download-receipt-btn {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .invoice-header,
            .invoice-body {
                padding: 22px;
            }

            .invoice-title {
                font-size: 26px;
                margin-top: 20px;
            }

            .product-box {
                align-items: flex-start;
            }

            .totals-wrapper {
                justify-content: stretch;
            }

            .totals-card {
                max-width: 100%;
            }

            .invoice-table {
                min-width: 780px;
            }
        }
    </style>
</head>

<body>

@php
    $selectedStatus = null;

    if (!empty($store_order_statuses)) {
        $selectedStatus = collect($store_order_statuses)->firstWhere('id', $order->order_status ?? null);
    }

    $statusColor = $selectedStatus->color ?? '#717070';
    $statusName = $selectedStatus->status_name ?? 'Order Placed';

    $paymentDetails = $order->paymentDetails ?? collect();

    $totalPaid = $paymentDetails->count() > 0
        ? $paymentDetails->where('is_success', 1)->where('is_refund', 0)->sum('payment_amount')
        : 0.00;

    $totalProcessingFee = $paymentDetails->count() > 0
        ? $paymentDetails->where('is_success', 1)->sum('processing_fee')
        : 0.00;

    $totalRefund = $paymentDetails->count() > 0
        ? $paymentDetails->where('is_success', 1)->where('is_refund', 1)->sum('payment_amount')
        : 0.00;

    $totalPaidAmount = $totalPaid - $totalRefund;

    $paymentBgColor = '#f8d7da';
    $paymentTextColor = '#721c24';
    $paymentText = 'Pending';

    if (function_exists('bccomp')) {
        if (bccomp($totalPaidAmount, $order->total ?? 0, 2) === 0) {
            $paymentBgColor = '#d4edda';
            $paymentTextColor = '#155724';
            $paymentText = 'Paid';
        } elseif (bccomp($totalPaidAmount, $order->total ?? 0, 2) === 1) {
            $paymentBgColor = '#d4edda';
            $paymentTextColor = '#155724';
            $paymentText = 'Over Paid';
        } elseif ($totalPaidAmount > 0) {
            $paymentBgColor = '#fff3cd';
            $paymentTextColor = '#856404';
            $paymentText = 'Partial';
        }
    } else {
        if (round($totalPaidAmount, 2) == round($order->total ?? 0, 2)) {
            $paymentBgColor = '#d4edda';
            $paymentTextColor = '#155724';
            $paymentText = 'Paid';
        } elseif ($totalPaidAmount > ($order->total ?? 0)) {
            $paymentBgColor = '#d4edda';
            $paymentTextColor = '#155724';
            $paymentText = 'Over Paid';
        } elseif ($totalPaidAmount > 0) {
            $paymentBgColor = '#fff3cd';
            $paymentTextColor = '#856404';
            $paymentText = 'Partial';
        }
    }

    $amountToPay = round(($order->total ?? 0) - $totalPaidAmount, 2);
@endphp

<div class="invoice-page">
    <div class="invoice-card">

        <!-- Header -->
        <div class="invoice-header">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="d-flex align-items-center gap-3">
                        @if(!empty($store->themeDetails->primary_logo))
                            <img src="{{ asset($store->themeDetails->primary_logo) }}" alt="Store Logo" class="store-logo">
                        @endif

                        <div>
                            <div style="font-size: 22px; font-weight: 800;">
                                {{ $store->store_name ?? 'Store' }}
                            </div>
                            <div class="invoice-subtitle">
                                Customer Order Invoice
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 text-md-end">
                    <h1 class="invoice-title">Invoice</h1>
                    <div class="invoice-subtitle">
                        Order #{{ $order->order_no ?? 'N/A' }}
                    </div>
                    <div class="mt-3">
                        <span class="status-badge" style="background-color: {{ $statusColor }};">
                            {{ $statusName }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="invoice-body">

            <!-- Invoice Info Cards -->
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="info-card light">
                        <div class="info-title">Invoice Details</div>
                        <div class="info-line">
                            <strong>Order No:</strong> {{ $order->order_no ?? 'N/A' }}
                        </div>
                        <div class="info-line">
                            <strong>Order Date:</strong>
                            {{ !empty($order->created_at)
                                ? \Carbon\Carbon::parse($order->created_at)
                                    ->timezone('America/Los_Angeles')
                                    ->format('F j, Y g:i A')
                                : 'N/A'
                            }}
                        </div>
                        <div class="info-line">
                            <strong>Shipping Method:</strong>
                            {{ $order->shippingMethodDetails->shipping_method_name ?? 'N/A' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-card">
                        <div class="info-title">Bill To</div>
                        <div class="info-main">
                            {{ trim(($order->CustomerDetails->first_name ?? '') . ' ' . ($order->CustomerDetails->last_name ?? '')) ?: 'N/A' }}
                        </div>
                        <div class="info-line">{{ $order->CustomerDetails->email ?? 'N/A' }}</div>
                        <div class="info-line">{{ $order->CustomerDetails->phone_number ?? 'N/A' }}</div>
                        <div class="info-line">
                            {{ $order->CustomerDetails->street ?? '' }}
                            {{ $order->CustomerDetails->city ?? '' }}
                            {{ $order->CustomerDetails->state ?? '' }}
                            {{ $order->CustomerDetails->postal_code ?? '' }}
                            {{ $order->CustomerDetails->country ?? '' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-card">
                        <div class="info-title">Ship To</div>
                        <div class="info-main">
                            {{ trim(($order->first_name ?? '') . ' ' . ($order->last_name ?? '')) ?: 'N/A' }}
                        </div>
                        <div class="info-line">{{ $order->email ?? 'N/A' }}</div>
                        <div class="info-line">{{ $order->phone ?? 'N/A' }}</div>
                        <div class="info-line">
                            {{ $order->street ?? '' }}
                            {{ $order->city ?? '' }}
                            {{ $order->state ?? '' }}
                            {{ $order->postal_code ?? '' }}
                            {{ $order->country ?? '' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="table-responsive">
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th class="text-start">Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($order->OrderItems ?? [] as $orderItem)
                            @foreach ($orderItem->OrderItemDetails ?? [] as $itemDetail)
                                @php
                                    $product = $orderItem->ProductDetails ?? null;
                                    $productImage = 'assets/img/products/default-loading.gif';

                                    if (!empty($product) && !empty($product->images) && $product->images->count() > 0) {
                                        $productImage = $product->images->first()->url;
                                    }

                                    $itemStatus = null;

                                    if (!empty($store_order_statuses)) {
                                        $itemStatus = collect($store_order_statuses)->firstWhere('id', $itemDetail->item_status ?? null);
                                    }

                                    $itemStatusName = $itemStatus->status_name ?? 'Pending';
                                    $itemStatusColor = $itemStatus->color ?? '#717070';
                                @endphp

                                <tr>
                                    <td>
                                        <div class="product-box">
                                            <div class="product-img-wrap">
                                                <img src="{{ asset($productImage) }}" alt="Product Image" class="product-img">
                                            </div>

                                            <div>
                                                <div class="product-name">
                                                    {{ $product->product_name ?? 'N/A' }}
                                                    @if(!empty($product->product_id))
                                                        <span style="color:#6b7280; font-weight:600;">
                                                            (PRO - {{ $product->product_id }})
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="product-meta">
                                                    Size:
                                                    {{ $itemDetail->SizeDetails->size_name ?? $itemDetail->size_name ?? 'N/A' }}
                                                </div>

                                                @if(!empty($itemDetail->player_name) && $itemDetail->player_name !== 'null')
                                                    <div class="product-meta">
                                                        Name: {{ $itemDetail->player_name }}
                                                    </div>
                                                @endif

                                                @if(($itemDetail->player_number ?? null) !== null && ($itemDetail->player_number ?? '') !== '')
                                                    <div class="product-meta">
                                                        Number: {{ $itemDetail->player_number }}
                                                    </div>
                                                @endif
                                                @if(($itemDetail->sub_team != null) && ($itemDetail->sub_team !== '') && ($itemDetail->sub_team !== 'null'))
                                                    <div class="product-meta">
                                                        Sub Team: {{ $itemDetail->sub_team }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        {{ $itemDetail->qty ?? 0 }}
                                    </td>

                                    <td class="text-end">
                                        ${{ number_format($itemDetail->unit_price ?? 0, 2) }}
                                    </td>

                                    <td class="text-end">
                                        <strong>${{ number_format($itemDetail->total_amount ?? 0, 2) }}</strong>
                                    </td>

                                    <td class="text-center">
                                        <span class="status-badge" style="background-color: {{ $itemStatusColor }};">
                                            {{ $itemStatusName }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Coupon -->
            @if (!empty($order->coupon_code) && !empty($order->couponDetails))
                <div class="coupon-alert">
                    Coupon applied:
                    <strong>{{ $order->coupon_code }}</strong> —

                    @if($order->couponDetails->type == 'free_shipping')
                        Free Shipping.
                    @elseif($order->couponDetails->type == 'flat_from_sub')
                        ${{ number_format($order->couponDetails->amount, 2) }} off from Sub Total.
                    @elseif($order->couponDetails->type == 'percentage_from_sub')
                        {{ rtrim(rtrim(number_format($order->couponDetails->amount, 2), '0'), '.') }}% off from Sub Total.
                    @elseif($order->couponDetails->type == 'flat_from_grand')
                        ${{ number_format($order->couponDetails->amount, 2) }} off from Grand Total.
                    @elseif($order->couponDetails->type == 'percentage_from_grand')
                        {{ rtrim(rtrim(number_format($order->couponDetails->amount, 2), '0'), '.') }}% off from Grand Total.
                    @else
                        Discount applied.
                    @endif
                </div>
            @endif

            <!-- Totals -->
            <div class="totals-wrapper">
                <div class="totals-card">
                    <div class="total-row">
                        <span>Sub Total</span>
                        <strong>${{ number_format($order->sub_total ?? 0, 2) }}</strong>
                    </div>

                    <div class="total-row">
                        <span>Handling Fee</span>
                        <strong>${{ number_format($order->handling_fee ?? 0, 2) }}</strong>
                    </div>

                    <div class="total-row">
                        <span>Sales Tax {{ $store->sales_tax ?? 0 }}%</span>
                        <strong>${{ number_format($order->sales_tax ?? 0, 2) }}</strong>
                    </div>

                    <div class="total-row">
                        <span>Shipping</span>
                        <strong>${{ number_format($order->shipping ?? 0, 2) }}</strong>
                    </div>

                    <div class="total-row grand">
                        <span>Grand Total</span>
                        <span>${{ number_format($order->total ?? 0, 2) }}</span>
                    </div>

                    <div class="total-row payment-status">
                        <span>Payment Status</span>
                        <span class="payment-badge" style="background-color: {{ $paymentBgColor }}; color: {{ $paymentTextColor }};">
                            {{ $paymentText }}
                        </span>
                    </div>

                    <div class="total-row">
                        <span>Paid Invoice Amount</span>
                        <strong>${{ number_format($order->paid_invoice_amount ?? 0, 2) }}</strong>
                    </div>

                    <div class="total-row">
                        <span>Paid Processing Fee</span>
                        <strong>${{ number_format($order->paid_processing_fee ?? 0, 2) }}</strong>
                    </div>

                    <div class="total-row">
                        <span>Total Paid Amount</span>
                        <strong>${{ number_format($order->paid_amount ?? $totalPaidAmount, 2) }}</strong>
                    </div>

                    @if($amountToPay > 0)
                        <div class="total-row" style="background:#fff7ed;">
                            <span><strong>Amount to Pay</strong></span>
                            <strong style="color:#c2410c;">${{ number_format($amountToPay, 2) }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tracking / Notes -->
            <div class="section">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-card light">
                            <div class="info-title">Tracking Information</div>

                            <div class="info-line">
                                <strong>Tracking #:</strong>
                                {{ $order->ShipmentDetails->tracking_number ?? 'N/A' }}
                            </div>

                            <div class="info-line">
                                <strong>Tracking Link:</strong>
                                @if(!empty($order->ShipmentDetails->tracking_url))
                                    <a href="{{ $order->ShipmentDetails->tracking_url }}" target="_blank">
                                        View Tracking
                                    </a>
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card light">
                            <div class="info-title">Notes</div>

                            @if(!empty($order->notes))
                                <div class="info-line">
                                    {!! nl2br(e(trim($order->notes))) !!}
                                </div>
                            @else
                                <div class="info-line">No notes available.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Receipts -->
            <div class="section">
                <div class="section-heading">Receipt</div>

                @if (!empty($order->OrderReceipts) && $order->OrderReceipts->count())
                    @php
                        $latestReceipt = $order->OrderReceipts
                            ? $order->OrderReceipts->sortByDesc('updated_at')->first()
                            : null;
                    @endphp

                    @if ($latestReceipt)
                        @php
                            $pstTime = \Carbon\Carbon::parse($latestReceipt->created_at)
                                ->timezone('America/Los_Angeles');
                        @endphp

                        <div class="receipt-box">
                            <div>
                                @if ($latestReceipt->is_sent == 1)
                                    <i class="fa fa-check-circle text-success me-2" title="Mail sent"></i>
                                @else
                                    <i class="fa fa-times-circle text-danger me-2" title="Mail not sent"></i>
                                @endif

                                <strong>{{ $pstTime->format('F jS, Y (g:i A)') }} PST</strong>
                            </div>

                            <button type="button"
                                class="download-receipt-btn"
                                data-receipt-no="{{ $latestReceipt->id }}">
                                <i class="fa fa-download me-1"></i> Download
                            </button>
                        </div>
                    @else
                        <div class="empty-box">No receipts available.</div>
                    @endif
                @else
                    <div class="empty-box">No receipts available.</div>
                @endif
            </div>

            <!-- Payments -->
            <div class="section">
                <div class="section-heading">Payments</div>

                @if (!empty($order->paymentDetails) && $order->paymentDetails->count() > 0)
                    <div class="table-responsive">
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction ID</th>
                                    <th>Card Owner</th>
                                    <th class="text-end">Payment Amount</th>
                                    <th class="text-end">Processing Fee</th>
                                    <th class="text-end">Total Amount</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($order->paymentDetails as $item)
                                    <tr>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->created_at)
                                                ->timezone('America/Los_Angeles')
                                                ->format('F jS, Y (g:i A)') }} PST
                                        </td>

                                        <td>{{ $item->transaction_id ?? '-' }}</td>
                                        <td>{{ $item->card_owner ?? '-' }}</td>

                                        <td class="text-end">
                                            ${{ number_format($item->payment_amount ?? 0, 2) }}
                                        </td>

                                        <td class="text-end">
                                            ${{ number_format($item->processing_fee ?? 0, 2) }}
                                        </td>

                                        <td class="text-end">
                                            <strong>${{ number_format($item->total_amount ?? 0, 2) }}</strong>
                                        </td>

                                        <td>
                                            @if ($item->is_refund)
                                                <span style="color: #16a34a; font-weight: 700;">REFUND</span>
                                            @else
                                                <span style="color: #16a34a; font-weight: 700;">PAYMENT</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($item->is_success)
                                                <span style="color: #16a34a; font-weight: 700;">SUCCESS</span>
                                            @else
                                                <span style="color: #ef4444; font-weight: 700;">FAILED</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-box">No payments available.</div>
                @endif
            </div>

            <div class="footer-note">
                Thank you for your order. This page is a customer preview invoice and is read-only.
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).on('click', '.download-receipt-btn', function(e) {
        e.preventDefault();

        const receiptNo = $(this).data('receipt-no');

        if (!receiptNo) {
            return;
        }

        const storeId = "{{ $store->id ?? '' }}";

        $.ajax({
            url: "{{ route('store.download_order_receipt') }}",
            type: 'GET',
            data: {
                store_id: storeId,
                receipt_id: receiptNo
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(blob, status, xhr) {
                const disposition = xhr.getResponseHeader('Content-Disposition');

                let filename = 'receipt.pdf';

                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition.split('filename=')[1].replace(/"/g, '');
                }

                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function() {
                alert('Failed to download receipt.');
            }
        });
    });
</script>

</body>
</html>
