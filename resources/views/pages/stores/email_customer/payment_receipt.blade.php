<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
</head>

    <body style="margin:0; padding:0; background:#f3f4f6; font-family: Arial, Helvetica, sans-serif;">

        <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0; background:#f3f4f6;">
            <tr>
                <td align="center">

                    <table width="600" cellpadding="0" cellspacing="0"
                        style="background:#ffffff; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.08); overflow:hidden;">

                        <!-- HEADER -->
                        <tr>
                            <td align="center" style="padding:28px 30px;">
                                <div style="font-size:20px; font-weight:600; color:#333;">
                                    {{ $store->store_name ?? 'Encore Custom' }}
                                </div>
                            </td>
                        </tr>

                        <!-- TITLE BAR -->
                        <tr>
                            <td style="background:#0f5132; padding:20px 30px; color:#ffffff;">
                                <h2 style="margin:0; font-size:20px; font-weight:600;">
                                    Payment Receipt
                                </h2>
                                <p style="margin:6px 0 0; font-size:13px; opacity:0.9;">
                                    Your payment has been successfully processed
                                </p>
                            </td>
                        </tr>

                        <!-- CUSTOMER / ORDER INFO -->
                        <tr>
                            <td style="padding:24px 30px;">
                                <table width="100%" style="font-size:14px; color:#333;">
                                    <tr>
                                        <td>
                                            <strong>Order #:</strong>
                                            {{ $storeOrder->order_no ?? $storeOrder->id }}
                                        </td>
                                        <td align="right">
                                            <strong>Date:</strong>
                                            {{ now()->format('M d, Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding-top:8px;">
                                            <strong>Customer:</strong>
                                            {{ trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>Email:</strong>
                                            {{ $customer->email ?? 'N/A' }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- DIVIDER -->
                        <tr>
                            <td style="padding:0 30px;">
                                <hr style="border:none; border-top:1px solid #e5e7eb;">
                            </td>
                        </tr>

                        <!-- PAYMENT SUMMARY -->
                        <tr>
                            <td style="padding:22px 30px;">
                                <h3 style="margin:0 0 16px; font-size:16px; color:#111;">
                                    Payment Summary
                                </h3>

                                <table width="100%" style="font-size:14px; color:#444;">
                                    <tr>
                                        <td style="padding:8px 0;">
                                            Invoice Amount
                                        </td>
                                        <td align="right" style="padding:8px 0;">
                                            ${{ number_format($transactionRecord->payment_amount ?? 0, 2) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding:8px 0;">
                                            Processing Fee
                                        </td>
                                        <td align="right" style="padding:8px 0;">
                                            ${{ number_format($transactionRecord->processing_fee ?? 0, 2) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <hr style="border:none; border-top:1px dashed #d1d5db; margin:12px 0;">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding:10px 0; font-size:15px; font-weight:600;">
                                            Total Paid
                                        </td>
                                        <td align="right" style="padding:10px 0; font-size:15px; font-weight:600;">
                                            ${{ number_format($transactionRecord->total_amount ?? 0, 2) }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- PAYMENT DETAILS -->
                        <tr>
                            <td style="padding:0 30px 24px;">
                                <p style="margin:0; font-size:13px; color:#6b7280;">
                                    <strong>Payment Method:</strong>
                                    {{ strtoupper($transactionRecord->payment_method ?? 'CARD') }}<br>

                                    <strong>Transaction ID:</strong>
                                    {{ $transactionRecord->transaction_id ?? 'N/A' }}
                                </p>
                            </td>
                        </tr>

                        <!-- FOOTER -->
                        <tr>
                            <td align="center"
                                style="padding:16px 30px; background:#f9fafb; font-size:12px; color:#9ca3af;">
                                © {{ date('Y') }} {{ 'Encore Custom' }}.
                                All rights reserved.
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>
        </table>
    </body>
</html>
