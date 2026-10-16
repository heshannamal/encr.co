<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Receipts - {{ $store->store_name }}</title>
    <style>
        .receipt-page {
            page-break-after: always;
        }

        .receipt-page:last-child {
            page-break-after: auto;
        }
    </style>
</head>

<body style="margin:0; padding:0; background:#ffffff; font-family:Arial, Helvetica, sans-serif;">

    @foreach($receipts as $receiptIndex => $receipt)
    @php
    $isRefund = isset($receipt->order_details['refund_details']) && !empty($receipt->order_details['refund_details']);
    $itemChangeLog = $receipt->order_details['item_change_log'] ?? [];
    $orderChangeNotes = $receipt->order_details['order_change_notes'] ?? [];
    @endphp
    <div class="receipt-page">

        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
            style="border-collapse:separate;background:#ffffff;">
            <tr>
                <td>

                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                        style="border-collapse:separate;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;">

                        <!-- BRAND HEADER -->
                        <tr>
                            <td style="background:#111827;padding:24px 20px;text-align:center;border-radius:11px 11px 0 0;" bgcolor="#111827">
                                <img src="https://encr.co/argon/img/encore/logo.png" alt="Encore Custom" width="200"
                                    style="display:block;margin:0 auto;max-width:200px;height:auto;">
                            </td>
                        </tr>

                        <!-- RECEIPT TITLE BAR -->
                        <tr>
                            <td align="center" style="background:{{ $isRefund ? '#b91c1c' : '#64748b' }};padding:18px 20px;" bgcolor="{{ $isRefund ? '#b91c1c' : '#64748b' }}">
                                <div style="font-size:19px;font-weight:700;color:#ffffff;">
                                    {{ $isRefund ? 'Refund Receipt' : 'Receipt' }} for Order #{{ $receipt->store_order_no }}
                                </div>
                                <div style="font-size:12px;color:{{ $isRefund ? '#fecaca' : '#e2e8f0' }};margin-top:4px;">
                                    {{ $isRefund ? 'Your refund has been processed' : 'Your Order has been successfully processed' }}
                                </div>
                            </td>
                        </tr>

                        <!-- STORE / ORDER TITLE -->
                        <tr>
                            <td style="padding:24px 30px 8px 30px;">
                                <div style="font-size:16px;font-weight:700;color:#111827;">{{ $store->store_name }} -
                                    {{ $receipt->store_order_no }}</div>
                                <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Generated: {{
                                    \Carbon\Carbon::parse($receipt->created_at)->setTimezone('America/Los_Angeles')->format('F
                                    jS, Y (g:i A)') }}</div>
                            </td>
                        </tr>

                        <!-- SHIPPING INFORMATION -->
                        <tr>
                            <td style="padding:14px 30px 0 30px;">
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                    style="border:1px solid #e5e7eb;">
                                    <tr>
                                        <td style="padding:16px 18px;">
                                            <div
                                                style="font-size:13px;font-weight:700;color:#111827;margin-bottom:10px;">
                                                Shipping Information:</div>
                                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                                style="font-size:12px;color:#374151;">
                                                <tr>
                                                    <td style="padding:4px 0;width:130px;color:#6b7280;">Shipping
                                                        Method</td>
                                                    <td style="padding:4px 0;font-weight:700;color:#111827;">{{
                                                        $receipt->shipping_details['shipping_method'] ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px 0;color:#6b7280;">Name</td>
                                                    <td style="padding:4px 0;font-weight:700;color:#111827;">{{
                                                        $receipt->shipping_details['first_name'] ?? '' }} {{
                                                        $receipt->shipping_details['last_name'] ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px 0;color:#6b7280;">Address</td>
                                                    <td style="padding:4px 0;color:#111827;">
                                                        {{ $receipt->shipping_details['street'] ?? '' }} {{
                                                        $receipt->shipping_details['city'] ?? '' }}, {{
                                                        $receipt->shipping_details['state'] ?? '' }} {{
                                                        $receipt->shipping_details['postal_code'] ?? '' }} {{
                                                        $receipt->shipping_details['country'] ?? '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px 0;color:#6b7280;">Email</td>
                                                    <td style="padding:4px 0;color:#111827;">{{
                                                        $receipt->shipping_details['email'] ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px 0;color:#6b7280;">Phone</td>
                                                    <td style="padding:4px 0;color:#111827;">{{
                                                        $receipt->shipping_details['phone'] ?? '' }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>


                        <!-- ORDER ITEMS TITLE -->
                        <tr>
                            <td style="padding:22px 30px 10px 30px;">
                                <div style="font-size:14px;font-weight:700;color:#111827;">Order Items</div>
                            </td>
                        </tr>

                        <!-- ORDER ITEMS TABLE (no image column — dompdf can't reliably render remote images) -->
                        <tr>
                            <td style="padding:0 30px 8px 30px;">
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                    style="border-collapse:collapse;border:1px solid #f0f0f0;">
                                    <tr style="background:#f9fafb;" bgcolor="#f9fafb">
                                        <td
                                            style="padding:10px;color:#6b7280;font-size:10px;font-weight:700;border-bottom:1px solid #f0f0f0;">
                                            #</td>
                                        <td
                                            style="padding:10px;color:#6b7280;font-size:10px;font-weight:700;border-bottom:1px solid #f0f0f0;">
                                            PRODUCT NAME</td>
                                        <td
                                            style="padding:10px;color:#6b7280;font-size:10px;font-weight:700;border-bottom:1px solid #f0f0f0;">
                                            DETAILS</td>
                                        <td align="right"
                                            style="padding:10px;color:#6b7280;font-size:10px;font-weight:700;border-bottom:1px solid #f0f0f0;">
                                            UNIT PRICE</td>
                                        <td align="left"
                                            style="padding:10px;color:#6b7280;font-size:10px;font-weight:700;border-bottom:1px solid #f0f0f0;white-space:nowrap;">
                                            SIZE / QTY</td>
                                        <td align="right"
                                            style="padding:10px;color:#6b7280;font-size:10px;font-weight:700;border-bottom:1px solid #f0f0f0;">
                                            TOTAL</td>
                                    </tr>

                                    @if (!empty($receipt->order_items) && is_array($receipt->order_items))
                                    @foreach ($receipt->order_items as $index => $item)
                                    <tr>
                                        <td
                                            style="padding:10px;color:#111827;font-size:11px;border-bottom:1px solid #f3f4f6;">
                                            {{ $index + 1 }}</td>
                                        <td
                                            style="padding:10px;color:#111827;font-size:11px;border-bottom:1px solid #f3f4f6;">
                                            {{ $item['product_name'] }}
                                            @php
                                            $subTeam = !empty($item['item_sizes']) ? (reset($item['item_sizes'])['sub_team'] ?? null) : null;
                                            @endphp
                                            <strong>{{ !empty($subTeam) ? ' (Team : '.$subTeam.')' : '' }}</strong>
                                        </td>
                                        <td
                                            style="padding:10px;color:#4b5563;font-size:10px;border-bottom:1px solid #f3f4f6;">
                                            @if (!empty($item['item_sizes']))
                                            @foreach ($item['item_sizes'] as $sizeDetail)
                                            @php
                                            $playerName = $sizeDetail['player_name'] ?? null;
                                            $playerNumber = $sizeDetail['player_number'] ?? null;
                                            @endphp
                                            @if(($playerName !== null && $playerName !== '' && $playerName !== 'null')
                                            || ($playerNumber !== null && $playerNumber !== ''))
                                            <div>
                                                @if($playerName !== null && $playerName !== '' && $playerName !==
                                                'null')
                                                Name: {{ $sizeDetail['player_name'] }}
                                                @endif
                                                @if($playerNumber !== null && $playerNumber !== '')
                                                Number: {{ $sizeDetail['player_number'] }}
                                                @endif
                                            </div>
                                            @else
                                            -
                                            @endif
                                            @endforeach
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td align="right"
                                            style="padding:10px;color:#111827;font-size:11px;border-bottom:1px solid #f3f4f6;">
                                            ${{ number_format($item['price'], 2) }}</td>
                                        <td
                                            style="padding:10px;color:#111827;font-size:10px;border-bottom:1px solid #f3f4f6;">
                                            @if (!empty($item['item_sizes']))
                                            @foreach ($item['item_sizes'] as $sizeIndex => $sizeDetail)
                                            <div
                                                style="{{ $sizeIndex > 0 ? 'margin-top:4px;padding-top:4px;border-top:1px dashed #e5e7eb;' : '' }}white-space:nowrap;">
                                                <span style="color:#4b5563;">{{ $sizeDetail['size'] }}</span>
                                                <span style="color:#9ca3af;"> x </span>
                                                <span
                                                    style="display:inline-block;background:#eef2ff;color:#1e3a8a;font-weight:700;padding:1px 6px;">{{
                                                    $sizeDetail['qty'] }}</span>
                                            </div>
                                            @endforeach
                                            @else
                                            <span
                                                style="display:inline-block;background:#eef2ff;color:#1e3a8a;font-weight:700;padding:1px 6px;">{{
                                                $item['qty'] }}</span>
                                            @endif
                                        </td>
                                        <td align="right"
                                            style="padding:10px;color:#111827;font-size:11px;font-weight:600;border-bottom:1px solid #f3f4f6;">
                                            ${{ number_format($item['total_price'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6"
                                            style="padding:14px 10px;color:#9ca3af;font-size:11px;text-align:center;">
                                            No items found.</td>
                                    </tr>
                                    @endif

                                    @if (!empty($receipt->order_details['coupon_details']))
                                    <tr>
                                        <td colspan="6"
                                            style="padding:10px;font-size:11px;color:#0aa636;background:#f0fdf4;">
                                            Coupon "<strong>{{ $receipt->order_details['coupon_code'] }}</strong>"
                                            applied.
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </td>
                        </tr>

                        @if(!empty($itemChangeLog))
                        <!-- ORDER ITEM CHANGES -->
                        <tr>
                            <td style="padding:18px 30px 0 30px;">
                                @if($isRefund)
                                <div style="font-size:10px;letter-spacing:0.5px;color:#b91c1c;font-weight:700;margin-bottom:8px;">
                                    ORDER ITEM CHANGES</div>
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                    style="background:#fef2f2;">
                                    <tr>
                                        <td style="padding:10px 16px 4px 16px;color:#b91c1c;font-size:10px;font-weight:700;">PRODUCT</td>
                                        <td align="center" style="padding:10px 16px 4px 16px;color:#b91c1c;font-size:10px;font-weight:700;">CHANGE</td>
                                        <td align="right" style="padding:10px 16px 4px 16px;color:#b91c1c;font-size:10px;font-weight:700;">QTY</td>
                                    </tr>
                                    @foreach($itemChangeLog as $change)
                                    <tr>
                                        <td style="padding:4px 16px;color:#b91c1c;font-size:11px;">{{ $change['product_name'] }}</td>
                                        <td align="center" style="padding:4px 16px;">
                                            <span style="font-size:9px;font-weight:700;color:#7f1d1d;background:#fecaca;padding:2px 8px;">
                                                {{ strtoupper($change['type']) }}
                                            </span>
                                        </td>
                                        <td align="right" style="padding:4px 16px 10px 16px;font-size:11px;font-weight:700;color:#b91c1c;">
                                            @if($change['type'] === 'removed')
                                            -{{ $change['qty'] }}
                                            @elseif($change['type'] === 'added')
                                            +{{ $change['qty'] }}
                                            @elseif($change['type'] === 'updated')
                                            {{ $change['old_qty'] }} -&gt; {{ $change['new_qty'] }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                @else
                                <div style="font-size:13px;font-weight:700;color:#111827;margin-bottom:8px;">Order
                                    Item Changes</div>
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                    style="border-collapse:collapse;border:1px solid #f0f0f0;">
                                    <tr style="background:#f9fafb;" bgcolor="#f9fafb">
                                        <td
                                            style="padding:8px 12px;color:#6b7280;font-size:10px;font-weight:700;border-bottom:1px solid #f0f0f0;">
                                            PRODUCT</td>
                                        <td align="center"
                                            style="padding:8px 12px;color:#6b7280;font-size:10px;font-weight:700;border-bottom:1px solid #f0f0f0;">
                                            CHANGE</td>
                                        <td align="right"
                                            style="padding:8px 12px;color:#6b7280;font-size:10px;font-weight:700;border-bottom:1px solid #f0f0f0;">
                                            QTY</td>
                                    </tr>
                                    @foreach($itemChangeLog as $change)
                                    <tr>
                                        <td
                                            style="padding:8px 12px;color:#111827;font-size:11px;border-bottom:1px solid #f3f4f6;">
                                            {{ $change['product_name'] }}</td>
                                        <td align="center" style="padding:8px 12px;border-bottom:1px solid #f3f4f6;">
                                            @if($change['type'] === 'removed')
                                            <span style="font-size:9px;font-weight:700;color:#b91c1c;background:#fee2e2;padding:2px 8px;">REMOVED</span>
                                            @elseif($change['type'] === 'added')
                                            <span style="font-size:9px;font-weight:700;color:#16a34a;background:#dcfce7;padding:2px 8px;">ADDED</span>
                                            @elseif($change['type'] === 'updated')
                                            <span style="font-size:9px;font-weight:700;color:#92400e;background:#fef3c7;padding:2px 8px;">UPDATED</span>
                                            @endif
                                        </td>
                                        <td align="right"
                                            style="padding:8px 12px;font-size:11px;font-weight:700;border-bottom:1px solid #f3f4f6;color:{{ $change['type'] === 'removed' ? '#b91c1c' : ($change['type'] === 'added' ? '#16a34a' : '#92400e') }};">
                                            @if($change['type'] === 'removed')
                                            -{{ $change['qty'] }}
                                            @elseif($change['type'] === 'added')
                                            +{{ $change['qty'] }}
                                            @elseif($change['type'] === 'updated')
                                            {{ $change['old_qty'] }} -&gt; {{ $change['new_qty'] }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                @endif
                            </td>
                        </tr>
                        @endif

                        @if(!empty($orderChangeNotes))
                        <!-- ORDER CHANGES (shipping) -->
                        <tr>
                            <td style="padding:14px 30px 0 30px;">
                                <div style="font-size:10px;letter-spacing:0.5px;color:#92400e;font-weight:700;margin-bottom:8px;">
                                    ORDER CHANGES</div>
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                    style="background:#fef3c7;">
                                    @foreach($orderChangeNotes as $note)
                                    <tr>
                                        <td style="padding:8px 16px;font-size:11px;color:#92400e;">{{ $note }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                        @endif

                        <!-- BILLING INFORMATION / PAYMENT SUMMARY -->
                        <tr>
                            <td style="padding:22px 30px 4px 30px;">
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="49%" valign="top"
                                            style="border:1px solid #e5e7eb;padding:16px 18px;">
                                            <div
                                                style="font-size:13px;font-weight:700;color:#111827;margin-bottom:10px;">
                                                Billing Information:</div>
                                            <div
                                                style="font-size:12px;color:#111827;font-weight:700;margin-bottom:6px;">
                                                {{ $receipt->customer_details['first_name'] ?? '' }} {{
                                                $receipt->customer_details['last_name'] ?? '' }}</div>
                                            <div
                                                style="font-size:12px;color:#4b5563;line-height:1.6;margin-bottom:12px;">
                                                {{ $receipt->customer_details['street'] ?? '' }}<br>
                                                {{ $receipt->customer_details['city'] ?? '' }}, {{
                                                $receipt->customer_details['state'] ?? '' }} {{
                                                $receipt->customer_details['postal_code'] ?? '' }}<br>
                                                {{ $receipt->customer_details['country'] ?? '' }}<br>
                                                Email: {{ $receipt->customer_details['email'] ?? '' }}<br>
                                                Phone: {{ $receipt->customer_details['phone'] ?? '' }}
                                            </div>
                                            @if ($receipt->paymentCard)
                                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                                style="font-size:11px;color:#374151;">
                                                <tr>
                                                    <td style="padding:3px 0;width:100px;">Date:</td>
                                                    <td style="padding:3px 0;font-weight:700;">{{
                                                        \Carbon\Carbon::parse($receipt->paymentCard->created_at)->format('m/d/Y')
                                                        }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:3px 0;">Name On Card:</td>
                                                    <td style="padding:3px 0;font-weight:700;">{{
                                                        $receipt->paymentCard->card_owner }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:3px 0;">Transaction ID:</td>
                                                    <td style="padding:3px 0;font-weight:700;">{{
                                                        $receipt->paymentCard->transaction_id }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:3px 0;">Payment method:</td>
                                                    <td style="padding:3px 0;font-weight:700;">Card</td>
                                                </tr>
                                                @if(!empty($receipt->paymentCard->card_last_digits))
                                                <tr>
                                                    <td style="padding:3px 0;">Card:</td>
                                                    <td style="padding:3px 0;">**** **** **** {{
                                                        $receipt->paymentCard->card_last_digits }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                            @else
                                            <span style="font-size:10px;font-weight:700;color:#b18d17;">Pending
                                                Payment</span>
                                            @endif
                                        </td>
                                        <td width="2%">&nbsp;</td>
                                        <td width="49%" valign="top"
                                            style="border:1px solid #e5e7eb;padding:16px 18px;">
                                            <div
                                                style="font-size:13px;font-weight:700;color:#111827;margin-bottom:10px;">
                                                Payment Summary</div>
                                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                                style="font-size:12px;color:#4b5563;">
                                                <tr>
                                                    <td style="padding:4px 0;">Subtotal:</td>
                                                    <td align="right" style="padding:4px 0;">${{
                                                        number_format($receipt->order_details['sub_total'], 2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px 0;">Handling Fee:</td>
                                                    <td align="right" style="padding:4px 0;">${{
                                                        number_format($receipt->order_details['handling_fee'], 2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px 0;">Sales Tax:</td>
                                                    <td align="right" style="padding:4px 0;">${{
                                                        number_format($receipt->order_details['sales_tax'], 2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px 0;">Shipping:</td>
                                                    <td align="right" style="padding:4px 0;">${{
                                                        number_format($receipt->order_details['shipping'], 2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"
                                                        style="padding:6px 0;border-top:1px dashed #d1d5db;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px 0;font-weight:700;color:#111827;">Total:
                                                    </td>
                                                    <td align="right"
                                                        style="padding:4px 0;font-weight:700;color:#111827;">${{
                                                        number_format($receipt->order_details['total'], 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:10px 0 4px 0;font-weight:700;color:#16a34a;">
                                                        Paid Amount:</td>
                                                    <td align="right"
                                                        style="padding:10px 0 4px 0;font-weight:700;color:#16a34a;">
                                                        ${{ isset($receipt->order_details['paid_invoice_amount']) ?
                                                        number_format($receipt->order_details['paid_invoice_amount'],
                                                        2) : number_format($receipt->order_details['total'], 2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:4px 0;">Paid Processing Fee:</td>
                                                    <td align="right" style="padding:4px 0;">${{
                                                        isset($receipt->order_details['paid_processing_fee']) ?
                                                        number_format($receipt->order_details['paid_processing_fee'],
                                                        2) : number_format(($receipt->order_details['total'] * 3/100),
                                                        2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"
                                                        style="padding:6px 0;border-top:1px dashed #d1d5db;"></td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding:4px 0 0 0;font-weight:700;color:#16a34a;font-size:13px;">
                                                        Total Paid Amount:</td>
                                                    <td align="right"
                                                        style="padding:4px 0 0 0;font-weight:700;color:#16a34a;font-size:13px;">
                                                        ${{ isset($receipt->order_details['paid_amount']) ?
                                                        number_format($receipt->order_details['paid_amount'], 2) :
                                                        number_format(($receipt->order_details['total'] * 103/100), 2)
                                                        }}</td>
                                                </tr>
                                                @if(isset($receipt->order_details['paid_invoice_amount']) &&
                                                $receipt->order_details['paid_invoice_amount'] >
                                                $receipt->order_details['total'])
                                                <tr>
                                                    <td
                                                        style="padding:10px 0 0 0;font-weight:700;color:#16a34a;">
                                                        Overpaid Amount:</td>
                                                    <td align="right"
                                                        style="padding:10px 0 0 0;font-weight:700;color:#16a34a;">
                                                        ${{
                                                        number_format($receipt->order_details['paid_invoice_amount']
                                                        - $receipt->order_details['total'], 2) }}</td>
                                                </tr>
                                                @endif
                                                @if(isset($receipt->order_details['paid_invoice_amount']) &&
                                                $receipt->order_details['paid_invoice_amount'] < $receipt->
                                                    order_details['total'])
                                                    <tr>
                                                        <td
                                                            style="padding:10px 0 0 0;font-weight:700;color:#dc2626;">
                                                            Amount Due:</td>
                                                        <td align="right"
                                                            style="padding:10px 0 0 0;font-weight:700;color:#dc2626;">
                                                            ${{ number_format($receipt->order_details['total'] -
                                                            $receipt->order_details['paid_invoice_amount'], 2) }}
                                                        </td>
                                                    </tr>
                                                    @endif
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        @if($isRefund)
                        <!-- REFUND DETAILS -->
                        <tr>
                            <td style="padding:18px 30px 0 30px;">
                                <div style="font-size:11px;color:#b91c1c;font-weight:700;margin-bottom:8px;">REFUND
                                    DETAILS</div>
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                    style="background:#fef2f2;">
                                    <tr>
                                        <td style="padding:10px 16px 4px 16px;font-size:12px;color:#b91c1c;">Refunded
                                            Amount:</td>
                                        <td align="right"
                                            style="padding:10px 16px 4px 16px;font-size:12px;color:#b91c1c;font-weight:700;">
                                            ${{
                                            number_format($receipt->order_details['refund_details']['refund_amount'],
                                            2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0 16px 4px 16px;font-size:12px;color:#b91c1c;">Refund
                                            Date:</td>
                                        <td align="right"
                                            style="padding:0 16px 4px 16px;font-size:12px;color:#b91c1c;">{{
                                            \Carbon\Carbon::parse($receipt->created_at)->setTimezone('America/Los_Angeles')->format('F
                                            jS, Y (g:i A)') }}</td>
                                    </tr>
                                    @if(!empty($receipt->order_details['refund_details']['refund_transaction_id']))
                                    <tr>
                                        <td style="padding:0 16px 4px 16px;font-size:12px;color:#b91c1c;">Refund
                                            Transaction ID:</td>
                                        <td align="right"
                                            style="padding:0 16px 4px 16px;font-size:12px;color:#b91c1c;">{{
                                            $receipt->order_details['refund_details']['refund_transaction_id'] }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td style="padding:0 16px 10px 16px;font-size:12px;color:#b91c1c;">Status:
                                        </td>
                                        <td align="right" style="padding:0 16px 10px 16px;">
                                            <span
                                                style="font-size:10px;font-weight:700;color:{{ ($receipt->order_details['refund_details']['is_success'] ?? false) ? '#16a34a' : '#b91c1c' }};">
                                                {{ ($receipt->order_details['refund_details']['is_success'] ?? false)
                                                ? 'SUCCESS' : 'FAILED' }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        @endif

                        @if (!empty($receipt->order_details['notes']))
                        <!-- ORDER NOTES -->
                        <tr>
                            <td style="padding:16px 30px 0 30px;">
                                <div style="font-size:11px;color:#9ca3af;font-weight:700;margin-bottom:6px;">ORDER
                                    NOTES</div>
                                <p style="margin:0;font-size:11px;color:#374151;">{{ $receipt->order_details['notes']
                                    }}</p>
                            </td>
                        </tr>
                        @endif

                        @if (!empty($receipt->order_details['tracking_no']))
                        <!-- TRACKING INFO -->
                        <tr>
                            <td style="padding:14px 30px 0 30px;">
                                <div style="font-size:11px;color:#9ca3af;font-weight:700;margin-bottom:6px;">TRACKING
                                    INFO</div>
                                <p style="margin:0;font-size:11px;color:#374151;">Tracking Number: {{
                                    $receipt->order_details['tracking_no'] }}</p>
                            </td>
                        </tr>
                        @endif

                        <!-- FOOTER -->
                        <tr>
                            <td style="padding:24px 20px 20px 20px;background:#ECEBE5;border-radius:0 0 11px 11px;" bgcolor="#ECEBE5">
                                <div style="text-align:center;">
                                    <img src="https://encr.co/argon/img/encore/logo_dark.png" alt="Encore Custom"
                                        width="160" style="display:block;margin:0 auto 8px auto;max-width:160px;">
                                    <p style="font-size:10px;color:#6b7280;font-style:italic;margin:0 0 10px 0;">The
                                        quality of your apparel reflects the quality of your brand.</p>
                                    <div style="font-size:10px;color:#374151;">
                                        Web: www.EncoreCustom.com Facebook: @ENCRSTM Instagram: @ENCRSTM
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>
        </table>

    </div>
    @endforeach

</body>

</html>