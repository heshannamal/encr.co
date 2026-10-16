@php
$primaryColor = $store->themeDetails->primary_color ?? '#d71920';
$secondaryColor = $store->themeDetails->secondary_color ?? $primaryColor;

if(isset($store->flyerDetails->logo_size)) {
    if($store->flyerDetails->logo_size == 1) $logoSizeClass = 'height:3rem;';
    elseif($store->flyerDetails->logo_size == 2) $logoSizeClass = 'height:5rem;';
    elseif($store->flyerDetails->logo_size == 3) $logoSizeClass = 'height:8rem;';
    else $logoSizeClass = 'height:5rem;';
} else {
    $logoSizeClass = 'height:5rem;';
}

$layoutType = $store->flyerDetails->layout_type ?? 1;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ $store->store_name }} Flyer</title>
<style>
@page { size: A4; margin: 0; }
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: #f6f7f9;
    color: #222;
}
.page {
    width: 210mm;
    min-height: 297mm;
    background: #fff;
    margin: 0 auto 20px;
    box-sizing: border-box;
    page-break-after: always;
}
.header {
    text-align: center;
    padding: 20px;
}
.instructions, .custom-message, .dates-section {
    margin: 15px;
    padding: 12px;
    border-radius: 6px;
    font-size: 0.9rem;
}
.instructions {
    background: {{ $primaryColor }};
    color: #fff;
}
.instructions ol {
    margin: 5px 0 0 20px;
}
.custom-message {
    background: #f3f3f3;
    border-left: 5px solid {{ $secondaryColor }};
}
.dates-section {
    background: #fafafa;
    border-left: 4px solid {{ $secondaryColor }};
}
.footer {
    background: {{ $primaryColor }};
    color: #fff;
    text-align: center;
    padding: 10px;
    font-size: 0.8rem;
}
.footer a {
    color: #fff;
    text-decoration: none;
}
.banner-image {
    position: relative;
    width: 100%;
    text-align: center;
}

.banner-image .banner-img {
    width: 100%;
    height: auto;
    display: block;
}

.banner-image .banner-logo {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 5rem;
    height: auto;
}

</style>
</head>
<body>
<div class="page">
    <div class="banner-image">
        @if(!empty($store->themeDetails->store_banner))
            <img src="{{ $store->themeDetails->store_banner }}" alt="Banner" class="banner-img">
        @endif

        {{-- @if(!empty($store->themeDetails->primary_logo))
            <img src="{{ $store->themeDetails->primary_logo }}" alt="Logo" class="banner-logo">
        @endif --}}
    </div>
    {{-- HEADER --}}
    {{-- <div class="header">
        @if(!empty($store->themeDetails->primary_logo))
            <img src="{{ $store->themeDetails->primary_logo }}" style="{{ $logoSizeClass }}">
        @endif
        <h1 style="color:{{ $primaryColor }};margin:10px 0 0;">{{ $store->store_name }}</h1>
    </div> --}}

    {{-- INSTRUCTIONS --}}
    {{-- @if(!empty($store->flyerDetails->show_instructions))
    <div style="padding: 15px;">
    <table width="100%" align="center" cellpadding="6" cellspacing="0" style="background:{{ $primaryColor }};color:#fff;border-radius:8px;">
        <tr>
            <td valign="top">
                <strong style="margin: 1rem;">How to order</strong>
                <ol>
                    <li>Scan QR code or visit <a href="https://encr.shop/{{ $store->direct_access_url }}" style="color:#fff;text-decoration:underline;">encr.shop/{{ $store->direct_access_url }}</a></li>
                    <li>Add items to cart</li>
                    <li>Checkout securely</li>
                </ol>
            </td>
            @if(!empty($store->flyerDetails->include_qr_code))
            <td align="center">
                <img src="{{ $qrCodeBase64 }}" alt="QR Code" width="100">
            </td>
            @endif
        </tr>
    </table>
    </div>
    @endif --}}

    {{-- MESSAGE --}}
    {{-- @if(!empty($store->flyerDetails->flyer_message))
    <div class="custom-message">
        <strong>Note:</strong> {!! nl2br(e($store->flyerDetails->flyer_message)) !!}
    </div>
    @endif --}}

    {{-- DATES --}}
    {{-- @if(!empty($store->flyerDetails->include_store_deadline) || !empty($store->flyerDetails->include_ship_date))
    <div class="dates-section">
        @if(!empty($store->flyerDetails->include_store_deadline))
            <strong>Store Deadline:</strong> {{ $store->close_date ?? 'TBD' }}<br>
        @endif
        @if(!empty($store->flyerDetails->include_ship_date))
            <strong>Est. Ship Date:</strong> {{ $store->ship_date ?? 'TBD' }}
        @endif
    </div>
    @endif --}}

    <div style="margin: 0;">
        <table width="100%" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;background-color:#f4f4f4;">
            <tr valign="top">
                <!-- Left Column: How to Order -->
                <td width="33.33%" style="vertical-align: top;">
                    <h3 style="margin: 0 0 10px; font-size: 1rem; color: {{ $store->themeDetails->primary_color ?? '#d71920' }};">
                        How to Order
                    </h3>
                    <ol style="margin: 0; padding-left: 20px; font-size: 0.9rem; line-height: 1.6; color: #333;">
                        <li>Scan the QR code or visit
                            <a href="https://encr.shop/{{ $store->direct_access_url }}"
                            style="color: {{ $store->themeDetails->primary_color ?? '#d71920' }}; text-decoration: underline;">
                            URL
                            </a>
                        </li>
                        <li>Add items to your cart</li>
                        <li>Checkout securely</li>
                    </ol>
                </td>

                <!-- Middle Column: Message & Deadline -->
                <td style="vertical-align: top; border-left: 1px solid #ddd;text-align:center">
                    @if(!empty($store->flyerDetails->include_store_deadline))
                        <p style="margin-top: 0; font-size: 1rem; color: #cc2626;">
                            <strong>Store Deadline: {{ $store->close_date ?? 'TBD' }}</strong>
                        </p>
                    @endif
                    @if(!empty($store->flyerDetails->flyer_message))
                        <div style="padding: 10px; border-radius: 6px; font-size: 0.9rem; color: #444;">
                            {!! nl2br(e($store->flyerDetails->flyer_message)) !!}
                        </div>
                    @endif
                </td>

                <!-- Right Column: QR Code -->
                @if(!empty($store->flyerDetails->include_qr_code))
                <td width="18%" align="center" style="vertical-align: middle; border-left: 1px solid #ddd;padding:0">
                    <img src="{{ $qrCodeBase64 }}" alt="QR Code" width="110" style="border: 2px solid #eee;height: 7rem;">
                    {{-- <div style="margin-top: 8px; font-size: 0.8rem; color: #666;">https://encr.shop/{{ $store->direct_access_url }}</div> --}}
                </td>
                @endif
            </tr>
        </table>
    </div>
    <div style="padding: .5rem;text-align: center;background-color: #ededed;">
        <a href="https://encr.shop/{{ $store->direct_access_url }}" style="color: black">
            https://encr.shop/{{ $store->direct_access_url }}
        </a>
    </div>


    {{-- PRODUCTS --}}
    <div style="padding: 15px;">
        @if($layoutType == 1)
        {{-- 3-column layout --}}
        <table width="100%" cellspacing="10" cellpadding="5">
            @foreach($store->StoreAddedProducts->chunk(3) as $chunk)
            <tr>
                @foreach($chunk as $product)
                <td width="33%" valign="top" align="center" style="border:1px solid #eee;padding:8px;">
                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->product_name }}" width="100%"><br>
                    <strong>{{ $product->product_name }}</strong><br>
                    @if(!empty($store->flyerDetails->show_description))
                        <small>{!! $product->style ?? '' !!}</small><br>
                    @endif
                    @if(!empty($store->flyerDetails->show_prices))
                        <strong>${{ number_format(($product->default_price + $product->priceAdditions->sum('addition_amount')),2) }}</strong>
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </table>

        @elseif($layoutType == 2)
        {{-- 2-column layout --}}
        <table width="100%" cellspacing="10" cellpadding="5">
            @foreach($store->StoreAddedProducts->chunk(2) as $chunk)
            <tr>
                @foreach($chunk as $product)
                <td width="50%" valign="top" align="center" style="border:1px solid #eee;padding:8px;">
                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->product_name }}" width="100%"><br>
                    <strong>{{ $product->product_name }}</strong><br>
                    @if(!empty($store->flyerDetails->show_description))
                        <small>{!! $product->style ?? '' !!}</small><br>
                    @endif
                    @if(!empty($store->flyerDetails->show_prices))
                        <strong>${{ number_format(($product->default_price +  + $product->priceAdditions->sum('addition_amount')),2) }}</strong>
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </table>

        @elseif($layoutType == 3)
        {{-- Table layout --}}
        <table width="100%" cellspacing="0" cellpadding="8">
            @foreach($store->StoreAddedProducts as $product)
            <tr>
                <td width="30%" align="center" valign="middle" style="border-bottom:1px solid #ddd;">
                    <img src="{{ $product->images->first()->url }}" alt="{{ $product->product_name }}" width="100%"><br>
                    @if(!empty($store->flyerDetails->show_prices))
                        <strong>${{ number_format(($product->default_price + $product->priceAdditions->sum('addition_amount')),2) }}</strong>
                    @endif
                </td>
                <td width="70%" valign="top" style="border-bottom:1px solid #ddd;">
                    <strong>{{ $product->product_name }}</strong><br>
                    @if(!empty($store->flyerDetails->show_description))
                        <small>{!! $product->style ?? '' !!}</small>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
        @endif
    </div>

    {{-- FOOTER --}}
    <div class="footer" style="background: {{ $store->themeDetails->primary_color ?? '#d71920' }}; color: #fff; padding: 18px 14px; font-size: 0.85rem;">
        <table width="100%" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <tr valign="middle">
                <!-- Left Column: Logo -->
                <td width="33%" align="left" style="vertical-align: middle;">
                    @if(!empty($store->themeDetails->primary_logo))
                        <img src="{{ $store->themeDetails->primary_logo }}" alt="Logo" style="height: 5rem;">
                    @endif
                </td>

                <!-- Center Column: Contact + Social -->
                <td width="34%" align="center" style="vertical-align: middle;">
                    <div>
                        <div style="font-weight: 600;">
                            {{ $store->flyerDetails->phone_number ?? '+1 888-501-4999' }}
                        </div>
                        <a href="mailto:{{ $store->flyerDetails->email ?? 'info@encorebrand.com' }}"
                        style="color: #fff; text-decoration: underline;">
                        {{ $store->flyerDetails->email ?? 'info@encorebrand.com' }}
                        </a>
                        <div style="margin-top: 6px;">
                            <a href="https://www.facebook.com/encrcstm" target="_blank"
                            style="color:#fff;text-decoration:none;margin:0 6px;">Facebook</a> |
                            <a href="https://www.instagram.com/encrcstm/" target="_blank"
                            style="color:#fff;text-decoration:none;margin:0 6px;">Instagram</a>
                        </div>
                    </div>
                </td>

                <!-- Right Column: QR Code -->
                <td width="33%" align="right" style="vertical-align: middle;">
                    @if(!empty($store->flyerDetails->include_qr_code))
                            <img src="{{ $qrCodeBase64 }}" alt="QR Code" width="70" style="height: 5rem;">
                    @endif
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>
