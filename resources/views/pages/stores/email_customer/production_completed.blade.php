<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Order Has Shipped</title>
</head>

<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0"
                   style="background:#ffffff;border-radius:14px;overflow:hidden;
                          box-shadow:0 10px 28px rgba(0,0,0,0.08);">

                <!-- HEADER -->
                <tr>
                    <td align="center" style="padding:28px 24px 18px;">
                        @if(!empty($store->themeDetails->primary_logo))
                            <img src="{{ asset($store->themeDetails->primary_logo) }}"
                                 alt="{{ $store->store_name }}"
                                 style="max-height:52px;display:block;margin-bottom:12px;">
                        @endif

                        <div style="font-size:18px;font-weight:600;color:#111827;">
                            {{ $store->store_name }}
                        </div>
                    </td>
                </tr>

                <!-- STATUS BAR -->
                <tr>
                    <td style="background:#065f46;padding:20px 30px;color:#ffffff;">
                        <h1 style="margin:0;font-size:22px;font-weight:600;">
                            Your Order Has Shipped
                        </h1>
                        <p style="margin:6px 0 0;font-size:13px;opacity:0.9;">
                            Order #{{ $order->order_no }}
                        </p>
                    </td>
                </tr>

                <!-- CONTENT -->
                <tr>
                    <td style="padding:28px 30px;font-size:15px;line-height:1.6;">
                        <p style="margin:0 0 14px;">
                            Hi {{ $customer_name ?? 'there' }},
                        </p>

                        <p style="margin:0 0 14px;">
                            Great news! Your order from <strong>{{ $store->store_name }}</strong>
                            is on its way.
                        </p>

                        <p style="margin:0 0 18px;color:#4b5563;font-size:14px;">
                            If your order ships in multiple packages, you may receive more than one tracking email.
                        </p>

                        @if ($order->shipping_method == 3)
                            <!-- PICKUP -->
                            <div style="background:#f9fafb;border-left:4px solid #065f46;
                                        padding:14px 18px;border-radius:8px;margin:20px 0;">
                                <p style="margin:0 0 6px;font-weight:600;">
                                    Local Pickup Details
                                </p>
                                <p style="margin:0;font-size:14px;color:#374151;">
                                    Encore Custom<br>
                                    891 4th Street, San Rafael, CA 94901<br>
                                    <strong>Hours:</strong> Mon–Fri 10am–6pm, Sat 10am–4pm
                                </p>
                            </div>
                        @else
                            <!-- TRACKING -->
                            <div style="background:#ecfdf5;border:1px solid #d1fae5;
                                        padding:18px;border-radius:10px;margin:22px 0;">

                                <p style="margin:0 0 6px;font-weight:600;">
                                    Tracking Number
                                </p>

                                <p style="margin:0 0 14px;font-size:14px;color:#065f46;">
                                    {{ $shipment->tracking_number ?? 'N/A' }}
                                </p>

                                @if(!empty($shipment->tracking_url))
                                    <a href="{{ $shipment->tracking_url }}"
                                       target="_blank"
                                       style="display:inline-block;background:#065f46;
                                              color:#ffffff;text-decoration:none;
                                              padding:12px 22px;border-radius:8px;
                                              font-size:14px;">
                                        Track Your Package
                                    </a>
                                @endif
                            </div>
                        @endif

                        <p style="margin:22px 0 0;">
                            Thank you for shopping with us!
                        </p>

                        <p style="margin:16px 0 0;font-weight:600;">
                            — Encore Custom Team
                        </p>
                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td align="center"
                        style="background:#f9fafb;padding:18px;font-size:12px;color:#9ca3af;">
                        © {{ date('Y') }} Encore Custom. All rights reserved.<br>
                        <a href="{{ makeStoreDomainRoute($store->direct_access_url) }}"
                           style="color:#065f46;text-decoration:none;">
                            Visit Store
                        </a>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
