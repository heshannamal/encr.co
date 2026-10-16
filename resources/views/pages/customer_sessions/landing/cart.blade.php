@php $pageTitle = 'Cart | Book My Sessions'; @endphp
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

            {{-- Right Actions --}}
            <div class="flex items-center gap-3">

                @if($isCustomerLoggedIn)
                    {{-- Cart --}}
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
                    <button type="button" class="hidden sm:inline-flex items-center gap-2 rounded-2xl bg-baddie-pink px-6 py-3 text-sm font-black uppercase tracking-wide text-white shadow-lg hover:bg-black transition" onclick="openBuyLoginModal()"> Join Now<i data-feather="arrow-right" class="w-4 h-4"></i> </button>
                @endif

                {{-- Mobile Menu --}}
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
        <button type="button" id="closeMobileMenu" class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center"><i data-feather="x" class="w-5 h-5"></i></button>
    </div>
    <nav class="space-y-3 font-black text-lg">
        <a href="{{ route('em.customer.landing.index') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Home</a>
        <a href="{{ route('em.customer.landing.packages') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Packages</a>
        <a href="{{ route('em.customer.landing.index') }}#sessions" class="block rounded-2xl px-4 py-3 bg-soft-pink">Sessions</a>
        @if($isCustomerLoggedIn)
            <a href="{{ route('em.customer.dashboard') }}" class="block rounded-2xl px-4 py-3 bg-black text-white">Dashboard</a>
            <a href="{{ route('em.customer.landing.cart') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Cart @if($cartCount > 0)({{ $cartCount }})@endif</a>
        @else
            <a href="{{ route('em.customer.login') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Login</a>
            <a href="{{ route('em.customer.register') }}" class="block rounded-2xl px-4 py-3 bg-black text-white">Register</a>
        @endif
    </nav>
</aside>

@php
    $items = collect($items ?? []);
    $subtotal = $subtotal ?? $items->sum('total_price');
    $tax = $tax ?? 0;
    $processingFee = $processingFee ?? round($subtotal * 0.03, 2);
    $total = $subtotal + $tax + $processingFee;
    $totalCredits = $items->sum(function ($item) {
        return (int)($item->package->available_classes ?? 0) * (int)($item->quantity ?? 0);
    });
@endphp
<main class="pt-20">
    <section class="relative bg-black text-white overflow-hidden">
        <div class="absolute inset-0 opacity-45">
            <img src="https://baddieslacrosse.com/images/nb35.jpg" alt="Training" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/80 to-black/30"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <span class="inline-flex bg-baddie-pink text-white rounded-full px-5 py-2 font-black uppercase tracking-[.22em] text-xs">Checkout Step 1</span>
            <h1 class="section-title text-2xl sm:text-4xl lg:text-6xl mt-7">Your Cart</h1>
            <p class="text-white/75 text-lg sm:text-xl max-w-2xl mt-6 font-semibold">Review selected packages before payment. After checkout, class credits will be added to your account.</p>
        </div>
    </section>

    <section class="py-14 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-8 rounded-3xl border border-green-200 bg-green-50 px-6 py-4 text-green-800 font-bold">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 px-6 py-4 text-red-800 font-bold">{{ session('error') }}</div>
            @endif

            <div class="grid lg:grid-cols-[1fr_390px] gap-8 items-start">
                <div class="space-y-5">
                    @forelse($items as $item)
                        @php
                            $package = $item->package;
                            $packageImage = $package->package_image ?? null;
                            $packageImageUrl = $packageImage
                                ? (Str::startsWith($packageImage, ['http://', 'https://']) ? $packageImage : asset('storage/' . $packageImage))
                                : null;
                            $itemCredits = (int)($package->available_classes ?? 0) * (int)($item->quantity ?? 0);
                        @endphp
                        <article class="rounded-[2rem] bg-white border border-black/10 shadow-sm overflow-hidden">
                            <div class="p-5 lg:p-6 grid md:grid-cols-[140px_1fr] gap-5">
                                <div class="h-36 rounded-[1.5rem] bg-black overflow-hidden relative">
                                    @if($packageImageUrl)
                                        <img src="{{ $packageImageUrl }}" alt="{{ $package->package_name ?? 'Package' }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,#ff3eb5,transparent_45%),linear-gradient(135deg,#050505,#151515)]"></div>
                                        <div class="relative h-full flex items-center justify-center text-baddie-pink"><i data-feather="package" class="w-11 h-11"></i></div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-4">
                                        <div>
                                            <h2 class="font-archivo text-2xl lg:text-3xl leading-none">{{ $package->package_name ?? 'Package' }}</h2>
                                            <p class="text-black/55 font-semibold mt-2 line-clamp-2">{{ $package->package_description ?? 'Training package credits.' }}</p>
                                            <div class="flex flex-wrap gap-2 mt-4">
                                                <span class="rounded-full bg-soft-pink px-4 py-2 text-sm font-black text-baddie-pink">{{ $package->available_classes ?? 0 }} credits / package</span>
                                                <span class="rounded-full bg-gray-100 px-4 py-2 text-sm font-black text-black/60">{{ $itemCredits }} total credits</span>
                                            </div>
                                        </div>
                                        <div class="text-left xl:text-right shrink-0">
                                            <p class="text-black/50 text-xs font-black uppercase tracking-widest">Line Total</p>
                                            <p class="font-archivo text-3xl text-baddie-pink mt-1">${{ number_format($item->total_price, 2) }}</p>
                                            <p class="text-sm text-black/50 font-semibold mt-1">${{ number_format($item->unit_price, 2) }} each</p>
                                        </div>
                                    </div>

                                    <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-t border-black/5 pt-5">
                                        <form method="POST" action="{{ route('em.customer.landing.cart.update', $item->id) }}" class="flex items-center gap-3">
                                            @csrf
                                            <label class="font-black text-sm text-black/55">Qty</label>
                                            <input type="number" name="quantity" min="1" value="{{ $item->quantity }}" class="qty-input w-24 rounded-full border-2 border-black/10 px-4 py-3 font-black focus:outline-none focus:border-baddie-pink">
                                            <button type="submit" class="outline-btn py-3 px-5">Update</button>
                                        </form>
                                        <form method="POST" action="{{ route('em.customer.landing.cart.remove', $item->id) }}" onsubmit="return confirm('Remove this package from cart?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-2 text-red-600 font-black hover:text-black transition">
                                                <i data-feather="trash-2" class="w-4 h-4"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-[2rem] bg-white border border-dashed border-black/15 p-12 text-center shadow-sm">
                            <div class="w-20 h-20 rounded-full bg-soft-pink text-baddie-pink mx-auto flex items-center justify-center mb-5">
                                <i data-feather="shopping-bag" class="w-9 h-9"></i>
                            </div>
                            <h2 class="font-archivo text-3xl">Your Cart Is Empty</h2>
                            <p class="text-black/60 font-semibold mt-3">Choose a package first, then continue to checkout.</p>
                            <a href="{{ route('em.customer.landing.packages') }}" class="pink-btn mt-7">Browse Packages</a>
                        </div>
                    @endforelse
                </div>

                <aside class="rounded-[2rem] bg-white border border-black/10 shadow-xl p-6 lg:p-7 sticky top-28">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h2 class="font-archivo text-3xl">Summary</h2>
                        <span class="w-12 h-12 rounded-full bg-soft-pink text-baddie-pink flex items-center justify-center"><i data-feather="receipt" class="w-6 h-6"></i></span>
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
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between font-bold text-black/65">
                            <span>Processing Fee 3%</span>
                            <span>${{ number_format($processingFee, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between font-bold text-black/65">
                            <span>Tax</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                    </div>

                    <div class="border-t border-black/10 mt-6 pt-6 flex items-end justify-between gap-4">
                        <span class="font-black text-xl">Total</span>
                        <span class="font-archivo text-4xl text-baddie-pink">${{ number_format($total, 2) }}</span>
                    </div>

                    @if($items->isNotEmpty())
                        <a href="{{ route('em.customer.landing.checkout') }}" class="pink-btn w-full mt-7">
                            Proceed to Checkout
                        </a>
                    @else
                        <button type="button" disabled class="w-full mt-7 rounded-full bg-gray-200 text-gray-400 font-black py-4 cursor-not-allowed">Proceed to Checkout</button>
                    @endif
                    <a href="{{ route('em.customer.landing.packages') }}" class="outline-btn w-full mt-3">Continue Shopping</a>

                    <div class="mt-6 rounded-3xl bg-soft-pink p-5">
                        <p class="font-black flex items-center gap-2"><i data-feather="info" class="w-4 h-4 text-baddie-pink"></i> Credit Note</p>
                        <p class="text-sm text-black/60 font-semibold mt-2">Credits are created only after successful payment on checkout.</p>
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
