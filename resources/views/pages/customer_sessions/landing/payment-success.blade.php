@php $pageTitle = 'Payment Successful | Book My Sessions'; @endphp
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

    $paymentLog = $order->latestPaymentLog ?? null;
    $items = collect($order->items ?? []);

    $subtotal = $order->subtotal ?? 0;
    $processingFee = $paymentLog->processing_fee ?? $order->processing_fee ?? 0;
    $tax = $order->tax ?? 0;
    $total = $order->total ?? 0;

    $totalCredits = $items->sum(function ($item) {
        return (int)($item->classes_per_package ?? 0) * (int)($item->quantity ?? 0);
    });
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>

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
            text-decoration: none;
        }

        .pink-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 45px rgba(255,62,181,.42);
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
            text-decoration: none;
        }

        .outline-btn:hover {
            background: #050505;
            color: #fff;
            transform: translateY(-2px);
        }

        .mobile-panel {
            transform: translateX(100%);
            transition: transform .25s ease;
        }

        .mobile-panel.active {
            transform: translateX(0);
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
        <a href="{{ route('em.customer.dashboard') }}" class="block rounded-2xl px-4 py-3 bg-black text-white">Dashboard</a>
        <a href="{{ route('em.customer.landing.cart') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">
            Cart @if($cartCount > 0)({{ $cartCount }})@endif
        </a>
    </nav>
</aside>

<main class="pt-24">
    <section class="relative bg-black text-white overflow-hidden">
        <div class="absolute inset-0 opacity-35">
            <img src="https://baddieslacrosse.com/images/nb35.jpg"
                 alt="Training"
                 class="w-full h-full object-cover">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/85 to-black/50"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 text-center">
            <div class="w-24 h-24 rounded-full bg-green-100 text-green-600 flex items-center justify-center mx-auto mb-7 shadow-xl">
                <i data-feather="check" class="w-12 h-12"></i>
            </div>

            <p class="text-baddie-pink font-black uppercase tracking-[.25em] text-xs">
                Payment Successful
            </p>

            <h1 class="section-title text-2xl sm:text-4xl lg:text-6xl mt-5">
                You're All Set
            </h1>

            <p class="text-white/75 text-lg sm:text-xl max-w-3xl mx-auto mt-6 font-semibold">
                Your package purchase was successful and your training credits have been added to your account.
            </p>
        </div>
    </section>

    <section class="py-14 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid lg:grid-cols-[1fr_390px] gap-8 items-start">

                <div class="space-y-6">
                    <div class="rounded-[2rem] bg-white border border-black/10 shadow-xl p-6 lg:p-8">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <p class="text-baddie-pink font-black uppercase tracking-[.25em] text-xs">
                                    Receipt
                                </p>
                                <h2 class="font-archivo text-3xl lg:text-4xl mt-2">
                                    Order Details
                                </h2>
                            </div>

                            <span class="w-12 h-12 rounded-full bg-soft-pink text-baddie-pink flex items-center justify-center">
                                <i data-feather="receipt" class="w-6 h-6"></i>
                            </span>
                        </div>

                        <div class="rounded-[1.5rem] bg-gray-50 border border-black/5 overflow-hidden">
                            <div class="flex justify-between gap-4 border-b border-black/10 p-4">
                                <span class="font-bold text-black/60">Order Number</span>
                                <span class="font-black text-black text-right">{{ $order->order_no }}</span>
                            </div>

                            @if($paymentLog && $paymentLog->transaction_id)
                                <div class="flex justify-between gap-4 border-b border-black/10 p-4">
                                    <span class="font-bold text-black/60">Transaction ID</span>
                                    <span class="font-black text-black text-right">{{ $paymentLog->transaction_id }}</span>
                                </div>
                            @endif

                            @if($paymentLog && $paymentLog->auth_id)
                                <div class="flex justify-between gap-4 border-b border-black/10 p-4">
                                    <span class="font-bold text-black/60">Auth Code</span>
                                    <span class="font-black text-black text-right">{{ $paymentLog->auth_id }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between gap-4 border-b border-black/10 p-4">
                                <span class="font-bold text-black/60">Payment Status</span>
                                <span class="font-black text-green-600 text-right">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>

                            <div class="flex justify-between gap-4 border-b border-black/10 p-4">
                                <span class="font-bold text-black/60">Payment Method</span>
                                <span class="font-black text-black text-right">
                                    {{ ucfirst($order->payment_method ?? 'Card') }}
                                    @if($order->card_last_four)
                                        •••• {{ $order->card_last_four }}
                                    @endif
                                </span>
                            </div>

                            <div class="flex justify-between gap-4 p-4">
                                <span class="font-bold text-black/60">Credits Added</span>
                                <span class="font-black text-baddie-pink text-right">
                                    {{ $totalCredits }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] bg-white border border-black/10 shadow-xl p-6 lg:p-8">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <p class="text-baddie-pink font-black uppercase tracking-[.25em] text-xs">
                                    Packages
                                </p>
                                <h2 class="font-archivo text-3xl lg:text-4xl mt-2">
                                    Purchased Packages
                                </h2>
                            </div>

                            <span class="w-12 h-12 rounded-full bg-soft-pink text-baddie-pink flex items-center justify-center">
                                <i data-feather="package" class="w-6 h-6"></i>
                            </span>
                        </div>

                        <div class="space-y-4">
                            @forelse($items as $item)
                                @php
                                    $itemCredits = (int)($item->classes_per_package ?? 0) * (int)($item->quantity ?? 0);
                                @endphp

                                <div class="rounded-[1.7rem] bg-gray-50 border border-black/5 p-5">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div>
                                            <h3 class="font-archivo text-2xl leading-none">
                                                {{ $item->package_name }}
                                            </h3>

                                            <p class="text-black/50 font-bold mt-3">
                                                Qty {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}
                                            </p>

                                            <span class="inline-flex mt-3 rounded-full bg-soft-pink px-4 py-2 text-sm font-black text-baddie-pink">
                                                {{ $itemCredits }} credits added
                                            </span>
                                        </div>

                                        <div class="text-left sm:text-right">
                                            <p class="text-black/50 text-xs font-black uppercase tracking-widest">
                                                Line Total
                                            </p>
                                            <p class="font-archivo text-3xl text-baddie-pink mt-1">
                                                ${{ number_format($item->total_price, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-[1.7rem] bg-red-50 border border-red-100 p-5 text-red-700 font-bold">
                                    No package items found for this order.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <aside class="rounded-[2rem] bg-black text-white shadow-xl p-6 lg:p-7 sticky top-28">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h2 class="font-archivo text-3xl">
                            Payment Summary
                        </h2>

                        <span class="w-12 h-12 rounded-full bg-baddie-pink text-white flex items-center justify-center">
                            <i data-feather="credit-card" class="w-6 h-6"></i>
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between font-bold text-white/70">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>

                        <div class="flex items-center justify-between font-bold text-white/70">
                            <span>Processing Fee 3%</span>
                            <span>${{ number_format($processingFee, 2) }}</span>
                        </div>

                        <div class="flex items-center justify-between font-bold text-white/70">
                            <span>Tax</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                    </div>

                    <div class="border-t border-white/15 mt-6 pt-6 flex items-end justify-between gap-4">
                        <span class="font-black text-xl">Total Paid</span>
                        <span class="font-archivo text-4xl text-baddie-pink">
                            ${{ number_format($total, 2) }}
                        </span>
                    </div>

                    @if($paymentLog && $paymentLog->message_text)
                        <div class="mt-6 rounded-3xl bg-white/10 p-5">
                            <p class="font-black flex items-center gap-2">
                                <i data-feather="shield" class="w-4 h-4 text-baddie-pink"></i>
                                Gateway Message
                            </p>

                            <p class="text-sm text-white/65 font-semibold mt-2">
                                {{ $paymentLog->message_text }}
                            </p>
                        </div>
                    @endif

                    <div class="mt-7 flex flex-col gap-3">
                        <a href="{{ route('em.customer.dashboard') }}" class="pink-btn w-full">
                            Go to My Profile
                        </a>

                        <a href="{{ route('em.customer.landing.index') }}"
                           class="outline-btn w-full border-white text-white hover:bg-white hover:text-black">
                            Back to Home
                        </a>

                        <a href="{{ route('em.customer.landing.packages') }}"
                           class="outline-btn w-full border-white text-white hover:bg-white hover:text-black">
                            Buy More Packages
                        </a>
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

            <a href="{{ route('em.customer.dashboard') }}" class="pink-btn">
                Dashboard
            </a>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.feather) feather.replace();

        const openMobileMenu = document.getElementById('openMobileMenu');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const profileDropdownBtn = document.getElementById('profileDropdownBtn');
        const profileDropdown = document.getElementById('profileDropdown');

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
    });
</script>

</body>
</html>
