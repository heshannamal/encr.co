@php $pageTitle = 'Checkout | Book My Sessions'; @endphp
@php
    use Illuminate\Support\Str;

    $customer = $customer ?? null;
    $isCustomerLoggedIn = !empty($customer);
    $cartCount = $cartCount ?? 0;

    $customerDisplayName = 'Player';
    if ($isCustomerLoggedIn) {
        $customerDisplayName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));
        $customerDisplayName = $customerDisplayName ?: ($customer->name ?? $customer->email ?? 'Player');
    }

    $customerPhoto = $isCustomerLoggedIn ? ($customer->profile_photo ?? null) : null;
    $customerPhotoUrl = $customerPhoto
        ? (Str::startsWith($customerPhoto, ['http://', 'https://']) ? $customerPhoto : asset('storage/' . $customerPhoto))
        : null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Book My Sessions | BayTown Baddies Lacrosse' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Raleway:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'baddie-pink': '#ff3eb5',
                        'baddie-blue': '#6cace4',
                        'baddie-black': '#050505',
                        'soft-pink': '#fff0fa'
                    },
                    fontFamily: {
                        'archivo': ['Archivo Black', 'sans-serif'],
                        'raleway': ['Raleway', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        @font-face {
            font-family: 'Swell';
            src: url('https://baddieslacrosse.com/fonts/Swell/Swell-Regular.otf') format('opentype'),
                 url('https://baddieslacrosse.com/fonts/Swell/._Swell-Regular.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        html { scroll-behavior: smooth; }
        body { font-family: 'Raleway', sans-serif; background: #fff; color: #050505; }

        .font-swell { font-family: 'Swell', cursive; line-height: .92; }

        .section-title {
            font-family: 'Archivo Black', sans-serif;
            letter-spacing: -.055em;
            line-height: .95;
        }

        .pink-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            background: #ff3eb5;
            color: #fff;
            font-weight: 900;
            border-radius: 999px;
            padding: .9rem 1.35rem;
            box-shadow: 0 16px 35px rgba(255,62,181,.30);
            transition: .2s ease;
        }

        .pink-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 45px rgba(255,62,181,.42);
        }

        .dark-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            background: #050505;
            color: #fff;
            font-weight: 900;
            border-radius: 999px;
            padding: .9rem 1.35rem;
            transition: .2s ease;
        }

        .dark-btn:hover {
            transform: translateY(-2px);
            background: #ff3eb5;
        }

        .outline-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            border: 2px solid #050505;
            color: #050505;
            font-weight: 900;
            border-radius: 999px;
            padding: .78rem 1.15rem;
            transition: .2s ease;
        }

        .outline-btn:hover {
            background: #050505;
            color: #fff;
            transform: translateY(-2px);
        }

        .soft-card {
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(0,0,0,.07);
            box-shadow: 0 24px 60px rgba(0,0,0,.08);
        }

        .mobile-panel {
            transform: translateX(100%);
            transition: transform .25s ease;
        }

        .mobile-panel.active {
            transform: translateX(0);
        }

        .payment-input {
            width: 100%;
            border-radius: 1rem;
            border: 2px solid rgba(0,0,0,.10);
            padding: 1rem 1.25rem;
            font-weight: 800;
            outline: none;
            background: #fff;
            transition: .2s ease;
        }

        .payment-input:focus {
            border-color: #ff3eb5;
            box-shadow: 0 0 0 4px rgba(255,62,181,.10);
        }

        .error-text {
            color: #dc2626;
            font-size: .875rem;
            font-weight: 800;
            margin-top: .35rem;
        }
    </style>
</head>

<body class="font-raleway overflow-x-hidden bg-white">

<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-black/10 shadow-[0_10px_35px_rgba(0,0,0,0.08)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-24 flex items-center justify-between">

            <a href="{{ route('em.customer.landing.index') }}" class="flex items-center gap-4 group">
                <div class="relative">
                    <div class="absolute -inset-1 rounded-3xl bg-baddie-pink/25 blur-md group-hover:bg-baddie-pink/40 transition"></div>

                    <div class="relative w-16 h-16 rounded-3xl bg-black flex items-center justify-center shadow-xl">
                        <img src="https://baddieslacrosse.com/ui_8/logo2.svg"
                             alt="BADDIES Logo"
                             class="w-11 h-11">
                    </div>
                </div>

                <div>
                    <p class="font-archivo text-2xl sm:text-3xl tracking-tight leading-none text-black">
                        Training
                    </p>
                    <p class="mt-1 text-[12px] font-black tracking-[.35em] text-baddie-pink uppercase">
                        Sessions
                    </p>
                </div>
            </a>

            <nav class="hidden lg:flex items-center gap-2 rounded-full bg-gray-100 p-2 font-black text-sm uppercase tracking-wide">
                <a href="{{ route('em.customer.landing.index') }}"
                   class="px-5 py-3 rounded-full text-black hover:bg-black hover:text-white transition">
                    Home
                </a>

                <a href="{{ route('em.customer.landing.packages') }}"
                   class="px-5 py-3 rounded-full text-black hover:bg-black hover:text-white transition">
                    Packages
                </a>

                <a href="{{ route('em.customer.landing.index') }}#sessions"
                   class="px-5 py-3 rounded-full text-black hover:bg-black hover:text-white transition">
                    Sessions
                </a>
            </nav>

            <div class="flex items-center gap-3">
                @if($isCustomerLoggedIn)
                    <a href="{{ route('em.customer.landing.cart') }}"
                       class="relative hidden sm:flex w-12 h-12 rounded-2xl bg-black text-white items-center justify-center hover:bg-baddie-pink transition shadow-lg"
                       title="Cart">
                        <i data-feather="shopping-bag" class="w-5 h-5"></i>

                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 min-w-6 h-6 px-1 rounded-full bg-baddie-pink text-white text-[11px] font-black flex items-center justify-center border-2 border-white">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <div class="relative hidden md:block" id="profileDropdownWrap">
                        <button type="button"
                                id="profileDropdownBtn"
                                class="flex items-center gap-3 rounded-2xl bg-gray-100 py-2 pl-2 pr-4 text-black hover:bg-black hover:text-white transition shadow-sm border border-black/5">

                            @if($customerPhotoUrl)
                                <img src="{{ $customerPhotoUrl }}"
                                     alt="{{ $customerDisplayName }}"
                                     class="w-10 h-10 rounded-2xl object-cover">
                            @else
                                <span class="w-10 h-10 rounded-2xl bg-baddie-pink text-white flex items-center justify-center font-black">
                                    {{ strtoupper(substr($customerDisplayName, 0, 1)) }}
                                </span>
                            @endif

                            <span class="font-black text-sm max-w-[130px] truncate">
                                {{ $customerDisplayName }}
                            </span>

                            <i data-feather="chevron-down" class="w-4 h-4"></i>
                        </button>

                        <div id="profileDropdown"
                             class="hidden absolute right-0 mt-4 w-72 rounded-[1.7rem] bg-white shadow-2xl border border-black/10 p-3">

                            <div class="px-4 py-3 border-b border-black/5">
                                <p class="text-xs font-black uppercase tracking-[.25em] text-baddie-pink">
                                    Customer Account
                                </p>
                                <p class="mt-1 font-black text-black truncate">
                                    {{ $customerDisplayName }}
                                </p>
                            </div>

                            <a href="{{ route('em.customer.dashboard') }}"
                               class="mt-2 flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-pink-50 font-bold text-black">
                                <i data-feather="grid" class="w-4 h-4 text-baddie-pink"></i>
                                My Profile
                            </a>

                            <form method="POST" action="{{ route('em.customer.logout') }}" class="mt-2 border-t border-black/5 pt-2">
                                @csrf

                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-black hover:text-white font-bold text-left">
                                    <i data-feather="log-out" class="w-4 h-4"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <button type="button"
                            class="hidden sm:inline-flex items-center gap-2 rounded-2xl bg-baddie-pink px-6 py-3 text-sm font-black uppercase tracking-wide text-white shadow-lg hover:bg-black transition"
                            onclick="openBuyLoginModal()">
                        Join Now
                        <i data-feather="arrow-right" class="w-4 h-4"></i>
                    </button>
                @endif

                <button type="button"
                        id="openMobileMenu"
                        class="lg:hidden w-12 h-12 rounded-2xl bg-baddie-pink text-white flex items-center justify-center shadow-lg hover:bg-black transition">
                    <i data-feather="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<div id="mobileOverlay" class="fixed inset-0 bg-black/60 z-[80] hidden"></div>

<aside id="mobileMenu" class="mobile-panel fixed top-0 right-0 bottom-0 w-[86%] max-w-sm bg-white z-[90] p-6 shadow-2xl lg:hidden">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="font-archivo text-xl">BADDIES</p>
            <p class="text-xs text-baddie-pink font-black uppercase tracking-[.25em]">Book Sessions</p>
        </div>

        <button type="button"
                id="closeMobileMenu"
                class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center">
            <i data-feather="x" class="w-5 h-5"></i>
        </button>
    </div>

    <nav class="space-y-3 font-black text-lg">
        <a href="{{ route('em.customer.landing.index') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Home</a>
        <a href="{{ route('em.customer.landing.packages') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Packages</a>
        <a href="{{ route('em.customer.landing.index') }}#sessions" class="block rounded-2xl px-4 py-3 bg-soft-pink">Sessions</a>

        @if($isCustomerLoggedIn)
            <a href="{{ route('em.customer.dashboard') }}" class="block rounded-2xl px-4 py-3 bg-black text-white">Dashboard</a>
            <a href="{{ route('em.customer.landing.cart') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">
                Cart @if($cartCount > 0)({{ $cartCount }})@endif
            </a>
        @else
            <a href="{{ route('em.customer.login') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Login</a>
            <a href="{{ route('em.customer.register') }}" class="block rounded-2xl px-4 py-3 bg-black text-white">Register</a>
        @endif
    </nav>
</aside>

@php
    $items = collect($items ?? []);

    $subtotal = $totals['subtotal'] ?? $items->sum('total_price');
    $processingFee = $totals['processing_fee'] ?? round($subtotal * 0.03, 2);
    $tax = $totals['tax'] ?? 0;
    $total = $totals['total'] ?? round($subtotal + $processingFee + $tax, 2);

    $totals = [
        'subtotal' => $subtotal,
        'processing_fee' => $processingFee,
        'tax' => $tax,
        'total' => $total,
    ];

    $totalCredits = $items->sum(function ($item) {
        return (int)($item->package->available_classes ?? 0) * (int)($item->quantity ?? 0);
    });

    $fullName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));
@endphp

<main class="pt-20">
    <section class="relative bg-black text-white overflow-hidden">
        <div class="absolute inset-0 opacity-45">
            <img src="https://baddieslacrosse.com/images/nb35.jpg" alt="Training" class="w-full h-full object-cover">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/80 to-black/30"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <span class="inline-flex bg-baddie-pink text-white rounded-full px-5 py-2 font-black uppercase tracking-[.22em] text-xs">
                Checkout Step 2
            </span>

            <h1 class="section-title text-2xl sm:text-4xl lg:text-6xl mt-7">
                Secure Payment
            </h1>

            <p class="text-white/75 text-lg sm:text-xl max-w-2xl mt-6 font-semibold">
                Complete payment to activate your training credits instantly.
            </p>
        </div>
    </section>

    <section class="py-14 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-8 rounded-3xl border border-green-200 bg-green-50 px-6 py-4 text-green-800 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 px-6 py-4 text-red-800 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 px-6 py-4 text-red-800 font-bold">
                    Please check the highlighted fields and try again.
                </div>
            @endif

            <div class="grid lg:grid-cols-[1fr_410px] gap-8 items-start">

                <div class="rounded-[2rem] bg-white border border-black/10 shadow-xl p-6 lg:p-8">
                    <div class="mb-8">
                        <p class="text-baddie-pink font-black uppercase tracking-[.25em] text-xs">
                            Card Details
                        </p>

                        <h2 class="font-archivo text-4xl mt-3">
                            Payment Information
                        </h2>

                        <p class="text-black/55 font-semibold mt-3">
                            Your card will be charged the package total plus a 3% processing fee.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('em.customer.landing.pay') }}" id="landingPaymentForm">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block font-black text-sm mb-2">First Name</label>
                                <input type="text"
                                       name="first_name"
                                       value="{{ old('first_name', $customer->first_name ?? '') }}"
                                       class="payment-input"
                                       required>
                                @error('first_name')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-black text-sm mb-2">Last Name</label>
                                <input type="text"
                                       name="last_name"
                                       value="{{ old('last_name', $customer->last_name ?? '') }}"
                                       class="payment-input">
                                @error('last_name')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-5 mt-5">
                            <div>
                                <label class="block font-black text-sm mb-2">Email</label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email', $customer->email ?? '') }}"
                                       class="payment-input"
                                       required>
                                @error('email')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-black text-sm mb-2">Phone</label>
                                <input type="text"
                                       name="phone"
                                       value="{{ old('phone', $customer->phone ?? '') }}"
                                       class="payment-input">
                                @error('phone')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5">
                            <label class="block font-black text-sm mb-2">Street Address</label>
                            <input type="text"
                                   name="street"
                                   value="{{ old('street') }}"
                                   class="payment-input"
                                   required>
                            @error('street')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-4 gap-5 mt-5">
                            <div class="md:col-span-2">
                                <label class="block font-black text-sm mb-2">City</label>
                                <input type="text"
                                       name="city"
                                       value="{{ old('city') }}"
                                       class="payment-input"
                                       required>
                                @error('city')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-black text-sm mb-2">State</label>
                                <input type="text"
                                       name="state"
                                       value="{{ old('state') }}"
                                       class="payment-input"
                                       required>
                                @error('state')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-black text-sm mb-2">Zip</label>
                                <input type="text"
                                       name="zip_code"
                                       value="{{ old('zip_code') }}"
                                       class="payment-input"
                                       required>
                                @error('zip_code')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5">
                            <label class="block font-black text-sm mb-2">Country</label>
                            <input type="text"
                                   name="country"
                                   value="{{ old('country', 'USA') }}"
                                   class="payment-input"
                                   required>
                            @error('country')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-8 pt-8 border-t border-black/10">
                            <h3 class="font-archivo text-3xl mb-5">Card</h3>

                            <div>
                                <label class="block font-black text-sm mb-2">Name on Card</label>
                                <input type="text"
                                       name="owner"
                                       value="{{ old('owner', $fullName) }}"
                                       class="payment-input"
                                       required>
                                @error('owner')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-5">
                                <label class="block font-black text-sm mb-2">Card Number</label>
                                <input type="text"
                                       name="cardNumber"
                                       value="{{ old('cardNumber') }}"
                                       placeholder="1234 1234 1234 1234"
                                       class="payment-input"
                                       autocomplete="cc-number"
                                       required>
                                @error('cardNumber')
                                    <p class="error-text">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-5">
                                <div>
                                    <label class="block font-black text-sm mb-2">Month</label>
                                    <select name="expiration-month"
                                            class="payment-input"
                                            autocomplete="cc-exp-month"
                                            required>
                                        <option value="">MM</option>
                                        @for($m = 1; $m <= 12; $m++)
                                            @php $month = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                                            <option value="{{ $month }}" {{ old('expiration-month') == $month ? 'selected' : '' }}>
                                                {{ $month }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('expiration-month')
                                        <p class="error-text">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block font-black text-sm mb-2">Year</label>
                                    <select name="expiration-year"
                                            class="payment-input"
                                            autocomplete="cc-exp-year"
                                            required>
                                        <option value="">YYYY</option>
                                        @for($y = now()->year; $y <= now()->year + 15; $y++)
                                            <option value="{{ $y }}" {{ old('expiration-year') == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('expiration-year')
                                        <p class="error-text">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block font-black text-sm mb-2">CVV</label>
                                    <input type="text"
                                           name="cvv"
                                           value="{{ old('cvv') }}"
                                           class="payment-input"
                                           autocomplete="cc-csc"
                                           required>
                                    @error('cvv')
                                        <p class="error-text">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="pink-btn w-full mt-8 text-lg" id="payButton">
                            Pay ${{ number_format($totals['total'], 2) }}
                        </button>

                        <p class="text-center text-sm text-black/50 font-semibold mt-4">
                            Secure card payment powered by Authorize.net.
                        </p>
                    </form>
                </div>

                <aside class="rounded-[2rem] bg-white border border-black/10 shadow-xl p-6 lg:p-7 sticky top-28">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h2 class="font-archivo text-3xl">Order Summary</h2>
                        <span class="w-12 h-12 rounded-full bg-soft-pink text-baddie-pink flex items-center justify-center">
                            <i data-feather="credit-card" class="w-6 h-6"></i>
                        </span>
                    </div>

                    <div class="space-y-4 mb-6">
                        @forelse($items as $item)
                            <div class="rounded-3xl bg-gray-50 p-4">
                                <div class="flex justify-between gap-4">
                                    <div>
                                        <p class="font-black text-black">
                                            {{ $item->package->package_name ?? 'Package' }}
                                        </p>
                                        <p class="text-sm text-black/50 font-bold mt-1">
                                            Qty {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}
                                        </p>
                                    </div>

                                    <p class="font-archivo text-xl text-baddie-pink">
                                        ${{ number_format($item->total_price, 2) }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-3xl bg-red-50 border border-red-100 p-4 text-red-700 font-bold">
                                Cart is empty.
                            </div>
                        @endforelse
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between font-bold text-black/65">
                            <span>Items</span>
                            <span>{{ $items->count() }}</span>
                        </div>

                        <div class="flex items-center justify-between font-bold text-black/65">
                            <span>Total Credits</span>
                            <span>{{ $totalCredits }}</span>
                        </div>

                        <div class="flex items-center justify-between font-bold text-black/65">
                            <span>Subtotal</span>
                            <span>${{ number_format($totals['subtotal'], 2) }}</span>
                        </div>

                        <div class="flex items-center justify-between font-bold text-black/65">
                            <span>Processing Fee 3%</span>
                            <span>${{ number_format($totals['processing_fee'], 2) }}</span>
                        </div>

                        <div class="flex items-center justify-between font-bold text-black/65">
                            <span>Tax</span>
                            <span>${{ number_format($totals['tax'], 2) }}</span>
                        </div>
                    </div>

                    <div class="border-t border-black/10 mt-6 pt-6 flex items-end justify-between gap-4">
                        <span class="font-black text-xl">Total</span>
                        <span class="font-archivo text-4xl text-baddie-pink">
                            ${{ number_format($totals['total'], 2) }}
                        </span>
                    </div>

                    <a href="{{ route('em.customer.landing.cart') }}" class="outline-btn w-full mt-7">
                        Back to Cart
                    </a>

                    <div class="mt-6 rounded-3xl bg-soft-pink p-5">
                        <p class="font-black flex items-center gap-2">
                            <i data-feather="shield" class="w-4 h-4 text-baddie-pink"></i>
                            Secure Checkout
                        </p>
                        <p class="text-sm text-black/60 font-semibold mt-2">
                            Credits are added only after payment is approved.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</main>

<footer class="bg-black text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <p class="font-archivo text-2xl">BADDIES</p>
            <p class="text-white/60 font-semibold mt-1">
                Book packages, manage credits, and reserve training sessions.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('em.customer.landing.packages') }}"
               class="outline-btn border-white text-white hover:bg-white hover:text-black">
                Packages
            </a>

            @if($isCustomerLoggedIn)
                <a href="{{ route('em.customer.dashboard') }}" class="pink-btn">
                    Dashboard
                </a>
            @else
                <a href="{{ route('em.customer.register') }}" class="pink-btn">
                    Create Account
                </a>
            @endif
        </div>
    </div>
</footer>

@include('pages.customer_sessions.landing.login_modal')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.feather) feather.replace();

        const openMobileMenu = document.getElementById('openMobileMenu');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const profileDropdownBtn = document.getElementById('profileDropdownBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        const landingPaymentForm = document.getElementById('landingPaymentForm');
        const payButton = document.getElementById('payButton');

        function openMenu() {
            mobileMenu.classList.add('active');
            mobileOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        openMobileMenu?.addEventListener('click', openMenu);
        closeMobileMenu?.addEventListener('click', closeMenu);
        mobileOverlay?.addEventListener('click', closeMenu);

        profileDropdownBtn?.addEventListener('click', function (event) {
            event.stopPropagation();
            profileDropdown?.classList.toggle('hidden');
        });

        document.addEventListener('click', function () {
            profileDropdown?.classList.add('hidden');
        });

        landingPaymentForm?.addEventListener('submit', function () {
            if (payButton) {
                payButton.disabled = true;
                payButton.classList.add('opacity-70', 'cursor-not-allowed');
                payButton.innerHTML = 'Processing Payment...';
            }
        });
    });
</script>

</body>
</html>
