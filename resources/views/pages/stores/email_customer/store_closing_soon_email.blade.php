<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'Store Closing Soon' }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f7f8fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .email-container {
            max-width: 640px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            overflow: hidden;
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

        .header h1 {
            font-size: 22px;
            margin: 0;
            font-weight: 600;
        }

        .content {
            padding: 30px;
            line-height: 1.7;
        }

        .content h2 {
            font-size: 20px;
            color: #111827;
            margin-bottom: 15px;
        }

        .content p {
            margin-bottom: 18px;
            color: #4b5563;
        }

        .button {
            display: inline-block;
            padding: 12px 28px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .button:hover {
            background: linear-gradient(135deg, #2563eb, #1e40af);
        }

        .footer {
            background-color: #f3f4f6;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #6b7280;
        }

        .footer a {
            color: #3b82f6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            @if(!empty($store->primary_logo))
                <img src="{{ asset($store->themeDetails->primary_logo) }}" alt="{{ $store->store_name }}">
            @endif
            <h2 style="color: white;">{{ $store->store_name }}</h2>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Hey {{ $customer_name ?? 'Valued Customer' }},</h2>
            <p>
                We wanted to remind you that your team store
                <strong>{{ $store->store_name }}</strong> is closing soon!
            </p>
            <p>
                This is your <strong>last chance</strong> to place your order before the store closes.
                Don’t miss out on getting your custom apparel and gear!
            </p>

            <div style="text-align:center; margin: 30px 0;">
                <a href="{{ makeStoreDomainRoute($store->direct_access_url) }}" class="button">Shop Now</a>
            </div>

            <p>
                Thank you for supporting your team and choosing Encore Custom.
                We can’t wait to see you represent in style!
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Encore Custom. All rights reserved.
            <br>
            <a href="https://encorecustom.com">encorecustom.com</a>
        </div>
    </div>
</body>
</html>
