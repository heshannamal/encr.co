<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Team Store Orders Delivered / Project Complete' }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f5f7;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .header {
            background-color: #0a2540;
            text-align: center;
            padding: 30px 10px 20px;
        }
        .header img {
            max-width: 120px;
            height: auto;
            display: block;
            margin: 0 auto 10px;
        }
        .header h2 {
            color: #ffffff;
            font-size: 20px;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 30px 40px;
            text-align: left;
            line-height: 1.6;
        }
        .content h1 {
            font-size: 22px;
            color: #0a2540;
            margin-bottom: 16px;
        }
        .content p {
            margin: 0 0 14px 0;
            font-size: 16px;
        }
        .highlight-box {
            background-color: #f4f5f7;
            border-left: 4px solid #0a2540;
            padding: 12px 16px;
            margin: 20px 0;
            border-radius: 6px;
        }
        .footer {
            background-color: #f4f5f7;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }
        .footer a {
            color: #0a2540;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            @if(!empty($store->themeDetails->primary_logo))
                <img src="{{ asset($store->themeDetails->primary_logo) }}" alt="{{ $store->store_name }}">
            @endif
            <h2>{{ $store->store_name }}</h2>
        </div>

        <div class="content">
            <h1>Team Store Orders Delivered / Project Complete</h1>

            <p>Hi {{ $customer_name ?? 'everyone' }},</p>

            <p>
                All team store orders have now been completed and delivered or shipped.
                We hope you love your new gear — thank you for being part of this season’s project with
                <strong>Encore Custom</strong>!
            </p>

            <div class="highlight-box">
                <p>
                    Please feel free to reach out if you have any questions or need any help with your order.
                </p>
            </div>

            <p style="margin-top: 30px;">— Encore Custom Team</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Encore Custom. All rights reserved.</p>
            <p><a href="{{ makeStoreDomainRoute($store->direct_access_url) }}">Visit Store</a></p>
        </div>
    </div>
</body>
</html>
