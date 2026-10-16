<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
    <div style="width: 700px; margin: 20px auto; background: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="font-size: 22px; margin: 0; color: #333;">Payment Receipt</h1>
        </div>

        <div style="margin: 20px 0;">
            <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Transaction Details</div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Date:</div>
                <div style="color: #333;">{{ $pdfdata['Date'] }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Order ID:</div>
                <div style="color: #333;">{{ $pdfdata['order_id'] }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Transaction ID:</div>
                <div style="color: #333;">{{ $pdfdata['transaction_id'] }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Customer Name:</div>
                <div style="color: #333;">{{ $pdfdata['Customer_name'] }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Payment Method:</div>
                <div style="color: #333;">{{ $pdfdata['Payment_method'] }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Amount Paid ($):</div>
                <div style="color: #333;">{{ number_format($pdfdata['amount_paid'], 2) }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Card Processing Fee (3%) ($):</div>
                <div style="color: #333;">{{ number_format(($pdfdata['amount_paid'] * 3) / 103, 2) }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Status:</div>
                <div style="color: #333;">{{ $pdfdata['status'] }}</div>
            </div>
        </div>

        <div style="margin: 20px 0;">
            <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Order Summary</div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Order Item Amount ($):</div>
                <div style="color: #333;">{{ number_format($order->sub_total, 2) }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Sales Tax ({{ $order->organizationDetails['sales_tax'] }}%) ($):</div>
                <div style="color: #333;">{{ number_format($order->sales_tax, 2) }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Shipping ($):</div>
                <div style="color: #333;">{{ number_format($order->shipping, 2) }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Artwork & Other Fees ($):</div>
                <div style="color: #333;">{{ number_format($order->artwork, 2) }}</div>
            </div>
            <?php
                $subTotal = $order->sub_total;
                $salesTax = $order->sales_tax;
                $shipping = $order->shipping;
                $artwork = $order->artwork;
                $discountType = $order->discountType;
                $discountValue = floatval($order->discount ?? 0);

                $totalWithoutDisc = $subTotal + $salesTax + $shipping + $artwork;
                $discountAmount = 0;

                if ($discountType === 1) {
                    $discountAmount = ($totalWithoutDisc / 100) * $discountValue;
                } elseif ($discountType === 2) {
                    $discountAmount = $discountValue;
                }
            ?>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Discount ($):</div>
                <div style="color: #333;">{{ number_format($discountAmount, 2) }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Amount to Pay ($):</div>
                <div style="color: #333;">{{ number_format($order->order_total, 2) }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Paid Amount ($):</div>
                <div style="color: #333;">{{ number_format($pdfdata['paymentReceived'], 2) }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Paid Processing Fee ($):</div>
                <div style="color: #333;">{{ number_format($pdfdata['processingFee'], 2) }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Balance to Pay ($):</div>
                <div style="color: #333;">{{ number_format($pdfdata['balnceToBePaid'], 2) }}</div>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                <div style="font-weight: bold; color: #555;">Order Status:</div>
                <div style="color: {{ $pdfdata['color'] }};">{{ $pdfdata['orderstatus'] }}</div>
            </div>
        </div>

        <div style="text-align: center; margin: 20px 0;">
            <h2 style="color: #333;">Thank you for your business!</h2>
            <img src="{{ asset('argon/img/encore/logo_dark.png') }}" alt="Logo" style="width: 350px;">
        </div>
    </div>
</body>
</html>
