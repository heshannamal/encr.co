<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Refund Receipt</title>
</head>

<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6; padding:40px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0"
                   style="background-color:#ffffff; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.08); overflow:hidden;">

                <!-- STORE NAME -->
                <tr>
                    <td align="center" style="padding:26px 30px;">
                        <div style="font-size:20px; font-weight:600; color:#1f2937;">
                            {{ $store->store_name ?? 'Encore Custom' }}
                        </div>
                    </td>
                </tr>

                <!-- HEADER -->
                <tr>
                    <td style="background-color:#b45309; padding:20px 30px; color:#ffffff;">
                        <div style="font-size:20px; font-weight:600;">
                            Refund Receipt
                        </div>
                        <div style="margin-top:6px; font-size:13px; opacity:0.9;">
                            Your refund has been successfully processed
                        </div>
                    </td>
                </tr>

                <!-- ORDER & CUSTOMER INFO -->
                <tr>
                    <td style="padding:24px 30px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#374151;">
                            <tr>
                                <td style="padding-bottom:6px;">
                                    <strong>Order #:</strong>
                                    {{ $storeOrder->order_no ?? $storeOrder->id }}
                                </td>
                                <td align="right" style="padding-bottom:6px;">
                                    <strong>Refund Date:</strong>
                                    {{ now()->format('M d, Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-top:4px;">
                                    <strong>Customer:</strong>
                                    {{ trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-top:4px;">
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

                <!-- REFUND SUMMARY -->
                <tr>
                    <td style="padding:22px 30px;">
                        <div style="font-size:16px; font-weight:600; color:#111827; margin-bottom:12px;">
                            Refund Summary
                        </div>

                        <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#4b5563;">
                            <tr>
                                <td style="padding:10px 0; font-weight:600; font-size:15px;">
                                    Total Refunded
                                </td>
                                <td align="right" style="padding:10px 0; font-weight:600; font-size:15px;">
                                    ${{ number_format($transactionRecord->payment_amount ?? 0, 2) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- REFUND DETAILS -->
                <tr>
                    <td style="padding:0 30px 24px;">
                        <div style="font-size:13px; color:#6b7280; line-height:1.6;">
                            <strong>Refund Method:</strong>
                            {{ strtoupper($transactionRecord->payment_method ?? 'CARD') }}<br>

                            <strong>Refund Transaction ID:</strong>
                            {{ $transactionRecord->transaction_id ?? 'N/A' }}<br>

                            <strong>Reason:</strong>
                            Excess amount from order
                            {{ $storeOrder->order_no ?? $storeOrder->id }}
                            returned.
                        </div>
                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td align="center"
                        style="background-color:#f9fafb; padding:16px 30px; font-size:12px; color:#9ca3af;">
                        © {{ date('Y') }} Encore Custom. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
