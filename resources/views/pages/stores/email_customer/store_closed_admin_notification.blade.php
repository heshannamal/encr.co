<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
                         Roboto, Helvetica, Arial, sans-serif;
            color: #1f2937;
        }

        .email-container {
            max-width: 720px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .header {
            padding: 28px 36px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header img {
            max-height: 42px;
        }

        .header-title {
            font-size: 18px;
            font-weight: 600;
        }

        .content {
            padding: 36px;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 15px;
            color: #6b7280;
            margin-bottom: 32px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .info-card {
            background: #f9fafb;
            border-radius: 10px;
            padding: 18px 20px;
        }

        .info-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 600;
        }

        .info-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .footer {
            margin-top: 40px;
            padding: 28px 36px;
            background: #f9fafb;
            font-size: 13px;
            color: #6b7280;
        }

        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="email-container">

    {{-- HEADER --}}
    <div class="header">
        @if(!empty($store->themeDetails->primary_logo))
            <img src="{{ asset($store->themeDetails->primary_logo) }}" alt="Logo">
        @endif
        <div class="header-title">
            {{ $store->store_name }}
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">

        <div class="title">Store Closed</div>
        <div class="subtitle">
            The team store has been successfully closed.
        </div>

        <div class="info-grid">

            <div class="info-card">
                <div class="info-label">Store Name</div>
                <div class="info-value">
                    {{ $store->store_name }}
                </div>
            </div>

            <div class="info-card">
                <div class="info-label">Closed On</div>
                <div class="info-value">
                    {{ $store->store_date
                        ? \Carbon\Carbon::parse($store->store_date)->format('F j, Y · h:i A')
                        : now()->format('F j, Y · h:i A') }}
                </div>
            </div>

            <div class="info-card">
                <div class="info-label">Sales Representative</div>
                <div class="info-value">
                    {{ optional($store->userDetails)->name ?? '—' }}
                </div>
            </div>

            <div class="info-card">
                <div class="info-label">Total Orders</div>
                <div class="info-value">
                    {{ $store->StoreOrders->count() }}
                </div>
            </div>

            <div class="info-card" style="grid-column: span 2;">
                <div class="info-label">Store Preview</div>
                <div class="info-value">
                    <a class="info-link"
                       href="{{ makeStoreDomainRoute($store->direct_access_url) }}">
                        View Closed Store →
                    </a>
                </div>
            </div>

        </div>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        This is an automated admin notification.
        <br>
        © {{ date('Y') }} Encore Custom. All rights reserved.
    </div>

</div>
</body>
</html>
