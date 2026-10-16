@php $pageTitle = ($package->package_name ?? 'Package') . ' | Book My Sessions'; @endphp
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
        .section-title { font-family: 'Archivo Black', sans-serif; letter-spacing: -.055em; line-height: .95; }
        .pink-btn { display: inline-flex; align-items: center; justify-content: center; gap: .55rem; background: #ff3eb5; color: #fff; font-weight: 900; border-radius: 999px; padding: .9rem 1.35rem; box-shadow: 0 16px 35px rgba(255,62,181,.30); transition: .2s ease; }
        .pink-btn:hover { transform: translateY(-2px); box-shadow: 0 20px 45px rgba(255,62,181,.42); }
        .dark-btn { display: inline-flex; align-items: center; justify-content: center; gap: .55rem; background: #050505; color: #fff; font-weight: 900; border-radius: 999px; padding: .9rem 1.35rem; transition: .2s ease; }
        .dark-btn:hover { transform: translateY(-2px); background: #ff3eb5; }
        .outline-btn { display: inline-flex; align-items: center; justify-content: center; gap: .55rem; border: 2px solid #050505; color: #050505; font-weight: 900; border-radius: 999px; padding: .78rem 1.15rem; transition: .2s ease; }
        .outline-btn:hover { background: #050505; color: #fff; transform: translateY(-2px); }
        .soft-card { background: rgba(255,255,255,.92); border: 1px solid rgba(0,0,0,.07); box-shadow: 0 24px 60px rgba(0,0,0,.08); }
        .card-hover { transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
        .card-hover:hover { transform: translateY(-7px); box-shadow: 0 28px 60px rgba(0,0,0,.12); border-color: rgba(255,62,181,.45); }
        .mobile-panel { transform: translateX(100%); transition: transform .25s ease; }
        .mobile-panel.active { transform: translateX(0); }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .qty-input::-webkit-outer-spin-button, .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .qty-input { -moz-appearance: textfield; }
    </style>
</head>
<body class="font-raleway overflow-x-hidden bg-white">
<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-black/10 shadow-[0_10px_35px_rgba(0,0,0,0.08)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-24 flex items-center justify-between">

            {{-- Logo --}}
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

            {{-- Desktop Navigation --}}
            <nav class="hidden lg:flex items-center gap-2 rounded-full bg-gray-100 p-2 font-black text-sm uppercase tracking-wide">
                <a href="{{ route('em.customer.landing.index') }}"
                   class="px-6 py-3 rounded-full text-black hover:bg-black hover:text-white transition">
                    Home
                </a>

                <a href="{{ route('em.customer.landing.packages') }}"
                   class="px-6 py-3 rounded-full text-black hover:bg-black hover:text-white transition">
                    Packages
                </a>

                <a href="{{ route('em.customer.landing.index') }}#sessions"
                   class="px-6 py-3 rounded-full text-black hover:bg-black hover:text-white transition">
                    Sessions
                </a>
            </nav>

            {{-- Right Actions --}}
            <div class="flex items-center gap-3">

                {{-- Cart --}}
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

                    {{-- Profile Dropdown --}}
                    <div class="relative hidden md:block" id="profileDropdownWrap">
                        <button type="button"
                                id="profileDropdownBtn"
                                class="flex items-center gap-3 rounded-2xl bg-gray-100 py-2 pl-2 pr-4 text-black hover:bg-black hover:text-white transition shadow-sm">

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
                    <button type="button" class="hidden sm:inline-flex items-center gap-2 rounded-2xl bg-baddie-pink px-6 py-3 text-sm font-black uppercase tracking-wide text-white shadow-lg hover:bg-black transition" onclick="openBuyLoginModal()"> Join Now<i data-feather="arrow-right" class="w-4 h-4"></i> </button>
                @endif

                {{-- Mobile Menu --}}
                <button type="button"
                        id="openMobileMenu"
                        class="lg:hidden w-12 h-12 rounded-2xl bg-baddie-pink text-white flex items-center justify-center shadow-lg">
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
        <button type="button" id="closeMobileMenu" class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center"><i data-feather="x" class="w-5 h-5"></i></button>
    </div>
    <nav class="space-y-3 font-black text-lg">
        <a href="{{ route('em.customer.landing.index') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Home</a>
        <a href="{{ route('em.customer.landing.packages') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Packages</a>
        <a href="{{ route('em.customer.landing.index') }}#sessions" class="block rounded-2xl px-4 py-3 bg-soft-pink">Sessions</a>
    </nav>
</aside>

@include('pages.customer_sessions.landing.login_modal')

@php
    $packageImage = 'https://baddieslacrosse.com/ui_8/at1.jpg';
    $packageImageUrl = $packageImage
        ? (Str::startsWith($packageImage, ['http://', 'https://']) ? $packageImage : asset('storage/' . $packageImage))
        : null;
    $validDays = $package->valid_days ?? 30;
@endphp
<main class="pt-20">
    <section class="py-12 lg:py-20 bg-[radial-gradient(circle_at_top_left,#fff0fa,#ffffff_45%,#f8f8f8)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('em.customer.landing.packages') }}" class="outline-btn mb-8"><i data-feather="arrow-left" class="w-4 h-4"></i> Back to Packages</a>

            @if(session('success'))
                <div class="mb-8 rounded-3xl border border-green-200 bg-green-50 px-6 py-4 text-green-800 font-bold">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 px-6 py-4 text-red-800 font-bold">{{ session('error') }}</div>
            @endif

            <div class="grid lg:grid-cols-2 gap-10 lg:gap-14 items-start">
                <div class="rounded-[2.5rem] overflow-hidden bg-black shadow-2xl min-h-[420px] relative">
                    @if($packageImageUrl)
                        <img src="{{ $packageImageUrl }}" alt="{{ $package->package_name }}" class="w-full h-full min-h-[420px] object-cover">
                    @else
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,#ff3eb5,transparent_45%),linear-gradient(135deg,#050505,#151515)]"></div>
                        <div class="relative min-h-[420px] flex items-center justify-center text-baddie-pink">
                            <i data-feather="award" class="w-24 h-24"></i>
                        </div>
                    @endif
                    <div class="absolute top-6 left-6 rounded-full bg-baddie-pink text-white px-5 py-2 text-xs font-black uppercase tracking-widest">Training Package</div>
                </div>

                <div>
                    <p class="font-swell text-baddie-pink text-6xl mb-2">Package</p>
                    <h1 class="section-title text-2xl sm:text-4xl lg:text-5xl">{{ $package->package_name }}</h1>
                    <div class="flex flex-wrap items-end gap-4 mt-7">
                        <p class="font-archivo text-6xl text-baddie-pink">${{ number_format($package->package_price, 2) }}</p>
                        <p class="font-black text-black/50 pb-2">one-time package purchase</p>
                    </div>
                    <p class="text-black/65 text-lg font-semibold mt-7 leading-relaxed">{{ $package->package_description ?: 'Purchase this package to receive class credits. Use those credits to book upcoming training sessions from your customer dashboard.' }}</p>

                    <div class="grid sm:grid-cols-3 gap-4 my-8">
                        <div class="rounded-3xl bg-white border border-black/10 p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-widest text-black/50">Credits</p>
                            <p class="font-archivo text-4xl mt-2">{{ $package->available_classes }}</p>
                        </div>
                        {{-- <div class="rounded-3xl bg-white border border-black/10 p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-widest text-black/50">Valid Days</p>
                            <p class="font-archivo text-4xl mt-2">{{ $validDays }}</p>
                        </div> --}}
                        {{-- <div class="rounded-3xl bg-white border border-black/10 p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-widest text-black/50">Type</p>
                            <p class="font-archivo text-3xl mt-2">Credits</p>
                        </div> --}}
                    </div>

                    <div class="rounded-[2rem] bg-white border border-black/10 p-6 lg:p-7 shadow-xl">
                        @if($isCustomerLoggedIn)
                            <form method="POST" action="{{ route('em.customer.landing.cart.add', $package->id) }}">
                                @csrf
                                <label class="block font-black uppercase tracking-widest text-xs text-black/50 mb-3">Quantity</label>
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <input type="number" min="1" value="1" name="quantity" class="qty-input w-full sm:w-36 rounded-full border-2 border-black/10 px-5 py-4 font-black focus:outline-none focus:border-baddie-pink">
                                    <button type="submit" class="pink-btn flex-1"><i data-feather="shopping-cart" class="w-5 h-5"></i> Add to Cart</button>
                                </div>
                            </form>
                        @else
                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('em.customer.login') }}" class="pink-btn flex-1">Login to Buy</a>
                                <a href="{{ route('em.customer.register') }}" class="outline-btn flex-1">Create Account</a>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8 grid sm:grid-cols-2 gap-4">
                        <div class="rounded-3xl bg-soft-pink p-5 flex gap-4">
                            <i data-feather="check-circle" class="w-6 h-6 text-baddie-pink shrink-0"></i>
                            <div>
                                <p class="font-black">Credits added after payment</p>
                                <p class="text-sm text-black/60 font-semibold mt-1">Your account balance updates after checkout.</p>
                            </div>
                        </div>
                        <div class="rounded-3xl bg-gray-100 p-5 flex gap-4">
                            <i data-feather="calendar" class="w-6 h-6 text-baddie-pink shrink-0"></i>
                            <div>
                                <p class="font-black">Use for session booking</p>
                                <p class="text-sm text-black/60 font-semibold mt-1">Reserve upcoming events from the dashboard.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="bg-black text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <p class="font-archivo text-2xl">BADDIES</p>
            <p class="text-white/60 font-semibold mt-1">Book packages, manage credits, and reserve training sessions.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('em.customer.landing.packages') }}" class="outline-btn border-white text-white hover:bg-white hover:text-black">Packages</a>
            @if($isCustomerLoggedIn)
                <a href="{{ route('em.customer.dashboard') }}" class="pink-btn">Dashboard</a>
            @else
                <a href="{{ route('em.customer.register') }}" class="pink-btn">Create Account</a>
            @endif
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
