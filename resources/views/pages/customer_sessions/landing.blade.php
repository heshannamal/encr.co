@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $landingPackages = isset($packages) ? collect($packages) : collect();
    $landingSessions = isset($sessions) ? collect($sessions) : collect();
    $children = isset($children) ? collect($children) : collect();

    $isCustomerLoggedIn = isset($customer) && !empty($customer);
    $cartCount = $cartCount ?? 0;
    $remainingCredits = $remainingCredits ?? 0;
    $usedCredits = $usedCredits ?? 0;
    $bookingsCount = $bookingsCount ?? 0;

    $customerDisplayName = 'Player';
    if ($isCustomerLoggedIn) {
        $customerDisplayName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));
        $customerDisplayName = $customerDisplayName ?: ($customer->name ?? $customer->email ?? 'Player');
    }

    $customerPhoto = $isCustomerLoggedIn ? ($customer->profile_photo ?? null) : null;
    $customerPhotoUrl = $customerPhoto
        ? (Str::startsWith($customerPhoto, ['http://', 'https://']) ? $customerPhoto : asset('storage/' . $customerPhoto))
        : null;

    $loginUrl = route('em.customer.login');
    $registerUrl = route('em.customer.register');
    $dashboardUrl = route('em.customer.dashboard');
    $packagesUrl = $isCustomerLoggedIn ? route('em.customer.packages') : $loginUrl;
    $cartUrl = $isCustomerLoggedIn ? route('em.customer.cart') : $loginUrl;

    $heroSlides = [
        [
            'eyebrow' => 'Train Harder',
            'title' => 'Book Elite Lacrosse Sessions Online',
            'subtitle' => 'Buy class packages, choose upcoming sessions, and manage player bookings from one modern portal.',
            'image' => 'https://images.unsplash.com/photo-1547347298-4074fc3086f0?auto=format&fit=crop&w=1800&q=80',
        ],
        [
            'eyebrow' => 'Build Skills',
            'title' => 'Stickwork, Speedwork & Fieldwork',
            'subtitle' => 'Find the right training type, coach, date, and location before you reserve your spot.',
            'image' => 'https://images.unsplash.com/photo-1526232761682-d26e03ac148e?auto=format&fit=crop&w=1800&q=80',
        ],
        [
            'eyebrow' => 'Easy Booking',
            'title' => 'Credits, Packages & Sessions Together',
            'subtitle' => 'Purchase credits once and use them to book sessions for your players anytime.',
            'image' => 'https://images.unsplash.com/photo-1518604666860-9ed391f76460?auto=format&fit=crop&w=1800&q=80',
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book My Sessions | BayTown Baddies Lacrosse</title>

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
        .font-swell { font-family: 'Swell', cursive; line-height: 0.95; }
        .hero-slide { opacity: 0; pointer-events: none; transform: scale(1.02); transition: opacity .8s ease, transform 1.2s ease; }
        .hero-slide.active { opacity: 1; pointer-events: auto; transform: scale(1); }
        .hero-bg::after { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(0,0,0,.82), rgba(0,0,0,.48), rgba(0,0,0,.15)); }
        .pink-btn { display: inline-flex; align-items: center; justify-content: center; gap: .55rem; background: #ff3eb5; color: #fff; font-weight: 900; border-radius: 999px; padding: .9rem 1.35rem; box-shadow: 0 16px 35px rgba(255,62,181,.30); transition: .2s ease; }
        .pink-btn:hover { transform: translateY(-2px); box-shadow: 0 20px 45px rgba(255,62,181,.40); }
        .dark-btn { display: inline-flex; align-items: center; justify-content: center; gap: .55rem; background: #050505; color: #fff; font-weight: 900; border-radius: 999px; padding: .9rem 1.35rem; transition: .2s ease; }
        .dark-btn:hover { transform: translateY(-2px); background: #ff3eb5; }
        .outline-btn { display: inline-flex; align-items: center; justify-content: center; gap: .55rem; border: 2px solid #050505; color: #050505; font-weight: 900; border-radius: 999px; padding: .78rem 1.15rem; transition: .2s ease; }
        .outline-btn:hover { background: #050505; color: #fff; transform: translateY(-2px); }
        .glass-card { background: rgba(255,255,255,.88); backdrop-filter: blur(18px); border: 1px solid rgba(255,255,255,.7); box-shadow: 0 24px 60px rgba(0,0,0,.12); }
        .section-title { font-family: 'Archivo Black', sans-serif; letter-spacing: -.05em; line-height: .95; }
        .card-hover { transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 24px 50px rgba(0,0,0,.12); border-color: rgba(255,62,181,.35); }
        .mobile-panel { transform: translateX(100%); transition: transform .25s ease; }
        .mobile-panel.active { transform: translateX(0); }
        .modal-backdrop { opacity: 0; pointer-events: none; transition: opacity .2s ease; }
        .modal-backdrop.active { opacity: 1; pointer-events: auto; }
        .modal-box { transform: translateY(24px) scale(.98); transition: transform .2s ease; }
        .modal-backdrop.active .modal-box { transform: translateY(0) scale(1); }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body class="font-raleway overflow-x-hidden">

<header class="fixed top-0 left-0 right-0 z-50 bg-white/92 backdrop-blur-xl border-b border-black/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-20 flex items-center justify-between">
            <a href="{{ route('em.customer.landing') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-baddie-pink flex items-center justify-center shadow-lg shadow-pink-200">
                    <span class="font-archivo text-white text-xl">B</span>
                </div>
                <div>
                    <p class="font-archivo text-lg sm:text-xl tracking-tight leading-none">BADDIES</p>
                    <p class="text-[11px] font-black tracking-[.25em] text-baddie-pink uppercase">Sessions</p>
                </div>
            </a>

            <nav class="hidden lg:flex items-center gap-9 font-black text-sm uppercase tracking-wide">
                <a href="#packages" class="hover:text-baddie-pink transition">Packages</a>
                <a href="#sessions" class="hover:text-baddie-pink transition">Sessions</a>
                <a href="#how" class="hover:text-baddie-pink transition">How It Works</a>
                @if($isCustomerLoggedIn)
                    <a href="{{ $dashboardUrl }}" class="hover:text-baddie-pink transition">Dashboard</a>
                @else
                    <a href="{{ $loginUrl }}" class="hover:text-baddie-pink transition">Login</a>
                @endif
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ $cartUrl }}" class="relative hidden sm:flex w-11 h-11 rounded-full border border-black/10 items-center justify-center hover:bg-black hover:text-white transition" title="Cart">
                    <i data-feather="shopping-bag" class="w-5 h-5"></i>
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-baddie-pink text-white text-[11px] font-black flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>

                @if($isCustomerLoggedIn)
                    <div class="relative hidden md:block" id="profileDropdownWrap">
                        <button type="button" id="profileDropdownBtn" class="flex items-center gap-3 rounded-full border border-black/10 py-1.5 pl-2 pr-4 hover:border-baddie-pink transition">
                            @if($customerPhotoUrl)
                                <img src="{{ $customerPhotoUrl }}" alt="{{ $customerDisplayName }}" class="w-9 h-9 rounded-full object-cover">
                            @else
                                <span class="w-9 h-9 rounded-full bg-black text-white flex items-center justify-center font-black">{{ strtoupper(substr($customerDisplayName, 0, 1)) }}</span>
                            @endif
                            <span class="font-black text-sm max-w-[130px] truncate">{{ $customerDisplayName }}</span>
                            <i data-feather="chevron-down" class="w-4 h-4"></i>
                        </button>

                        <div id="profileDropdown" class="hidden absolute right-0 mt-3 w-64 rounded-3xl bg-white shadow-2xl border border-black/5 p-3">
                            <a href="{{ $dashboardUrl }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-soft-pink font-bold"><i data-feather="grid" class="w-4 h-4"></i> Dashboard</a>
                            <a href="{{ route('em.customer.bookings') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-soft-pink font-bold"><i data-feather="calendar" class="w-4 h-4"></i> My Bookings</a>
                            <a href="{{ route('em.customer.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-soft-pink font-bold"><i data-feather="user" class="w-4 h-4"></i> Profile</a>
                            <form method="POST" action="{{ route('em.customer.logout') }}" class="mt-2 border-t border-black/5 pt-2">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-black hover:text-white font-bold text-left"><i data-feather="log-out" class="w-4 h-4"></i> Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ $registerUrl }}" class="hidden sm:inline-flex pink-btn py-3 px-5">Join Now</a>
                @endif

                <button type="button" id="openMobileMenu" class="lg:hidden w-11 h-11 rounded-full bg-black text-white flex items-center justify-center">
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
        <a href="#packages" class="mobile-link block rounded-2xl px-4 py-3 bg-soft-pink">Packages</a>
        <a href="#sessions" class="mobile-link block rounded-2xl px-4 py-3 bg-soft-pink">Sessions</a>
        <a href="#how" class="mobile-link block rounded-2xl px-4 py-3 bg-soft-pink">How It Works</a>
        @if($isCustomerLoggedIn)
            <a href="{{ $dashboardUrl }}" class="block rounded-2xl px-4 py-3 bg-black text-white">Dashboard</a>
            <a href="{{ route('em.customer.bookings') }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">My Bookings</a>
            <a href="{{ $cartUrl }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Cart @if($cartCount > 0)({{ $cartCount }})@endif</a>
        @else
            <a href="{{ $loginUrl }}" class="block rounded-2xl px-4 py-3 bg-soft-pink">Login</a>
            <a href="{{ $registerUrl }}" class="block rounded-2xl px-4 py-3 bg-black text-white">Register</a>
        @endif
    </nav>
</aside>

<main>
    <section class="relative min-h-screen overflow-hidden bg-black pt-20">
        <div class="absolute inset-0">
            @foreach($heroSlides as $index => $slide)
                <div class="hero-slide hero-bg absolute inset-0 {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                    <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="absolute inset-0 w-full h-full object-cover">
                </div>
            @endforeach
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-[calc(100vh-5rem)] flex items-center">
            <div class="max-w-4xl py-20 text-white">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/20 backdrop-blur px-4 py-2 mb-6">
                    <span class="w-2 h-2 rounded-full bg-baddie-pink"></span>
                    <span id="heroEyebrow" class="font-black uppercase tracking-[.25em] text-xs">{{ $heroSlides[0]['eyebrow'] }}</span>
                </div>

                <p class="font-swell text-baddie-pink text-5xl sm:text-7xl md:text-8xl mb-2">BayTown</p>
                <h1 id="heroTitle" class="font-archivo text-5xl sm:text-6xl md:text-8xl leading-[.88] tracking-[-.07em] max-w-4xl">{{ $heroSlides[0]['title'] }}</h1>
                <p id="heroSubtitle" class="mt-7 text-lg sm:text-xl text-white/85 max-w-2xl font-semibold leading-relaxed">{{ $heroSlides[0]['subtitle'] }}</p>

                <div class="mt-9 flex flex-col sm:flex-row gap-4">
                    <a href="#packages" class="pink-btn">View Packages <i data-feather="arrow-down" class="w-5 h-5"></i></a>
                    <a href="#sessions" class="inline-flex items-center justify-center gap-2 rounded-full bg-white text-black font-black px-6 py-4 hover:bg-baddie-pink hover:text-white transition">Browse Sessions <i data-feather="calendar" class="w-5 h-5"></i></a>
                </div>
            </div>
        </div>

        <div class="absolute z-20 left-4 right-4 bottom-6 sm:left-auto sm:right-8 sm:bottom-8 flex items-center justify-between sm:justify-end gap-4">
            <div class="flex items-center gap-2">
                @foreach($heroSlides as $index => $slide)
                    <button type="button" class="hero-dot w-10 h-2 rounded-full bg-white/40 data-[active=true]:bg-baddie-pink" data-hero-dot="{{ $index }}" data-active="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="flex gap-2">
                <button type="button" id="prevHero" class="w-11 h-11 rounded-full bg-white/15 border border-white/20 text-white backdrop-blur flex items-center justify-center hover:bg-baddie-pink transition"><i data-feather="chevron-left" class="w-5 h-5"></i></button>
                <button type="button" id="nextHero" class="w-11 h-11 rounded-full bg-white/15 border border-white/20 text-white backdrop-blur flex items-center justify-center hover:bg-baddie-pink transition"><i data-feather="chevron-right" class="w-5 h-5"></i></button>
            </div>
        </div>
    </section>

    <section class="relative -mt-10 z-30 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="glass-card rounded-3xl p-6">
                <p class="text-sm uppercase tracking-[.2em] font-black text-gray-500">Packages</p>
                <p class="font-archivo text-4xl mt-2">{{ $landingPackages->count() }}</p>
            </div>
            <div class="glass-card rounded-3xl p-6">
                <p class="text-sm uppercase tracking-[.2em] font-black text-gray-500">Sessions</p>
                <p class="font-archivo text-4xl mt-2">{{ $landingSessions->count() }}</p>
            </div>
            <div class="glass-card rounded-3xl p-6">
                <p class="text-sm uppercase tracking-[.2em] font-black text-gray-500">Credits Left</p>
                <p class="font-archivo text-4xl mt-2">{{ $isCustomerLoggedIn ? $remainingCredits : '—' }}</p>
            </div>
            <div class="glass-card rounded-3xl p-6">
                <p class="text-sm uppercase tracking-[.2em] font-black text-gray-500">Bookings</p>
                <p class="font-archivo text-4xl mt-2">{{ $isCustomerLoggedIn ? $bookingsCount : '—' }}</p>
            </div>
        </div>
    </section>

    <section id="packages" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-12">
                <div>
                    <p class="font-swell text-baddie-pink text-5xl mb-1">Pick your plan</p>
                    <h2 class="section-title text-4xl sm:text-6xl">TRAINING PACKAGES</h2>
                    <p class="mt-4 text-gray-600 max-w-2xl font-semibold">Buy a package first, then use your credits to reserve upcoming sessions.</p>
                </div>
                <a href="{{ $packagesUrl }}" class="outline-btn self-start lg:self-auto">View All Packages <i data-feather="arrow-right" class="w-5 h-5"></i></a>
            </div>

            @if($landingPackages->isEmpty())
                <div class="rounded-[2rem] border-2 border-dashed border-black/10 bg-gray-50 p-12 text-center">
                    <p class="font-archivo text-3xl">No packages available yet.</p>
                    <p class="mt-3 text-gray-600 font-semibold">Create packages from your schedule admin panel to show them here.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">
                    @foreach($landingPackages as $package)
                        @php
                            $packageDescription = $package->package_description ?? 'Flexible training credits for upcoming lacrosse sessions.';
                            $validDays = $package->valid_days ?? null;
                        @endphp
                        <article class="card-hover rounded-[2rem] border border-black/10 bg-white overflow-hidden">
                            <div class="p-7 border-b border-black/5 bg-gradient-to-br from-soft-pink to-white">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <span class="inline-flex rounded-full bg-black text-white px-3 py-1 text-xs font-black uppercase tracking-[.18em]">Package</span>
                                        <h3 class="mt-5 font-archivo text-3xl leading-none tracking-[-.04em]">{{ $package->package_name }}</h3>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs font-black uppercase tracking-[.2em] text-gray-500">Price</p>
                                        <p class="font-archivo text-3xl text-baddie-pink">${{ number_format((float) $package->package_price, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-7">
                                <p class="text-gray-600 font-semibold line-clamp-3 min-h-[72px]">{{ $packageDescription }}</p>
                                <div class="mt-7 grid grid-cols-2 gap-4">
                                    <div class="rounded-3xl bg-gray-50 p-4">
                                        <p class="text-xs font-black uppercase tracking-[.18em] text-gray-500">Classes</p>
                                        <p class="font-archivo text-3xl mt-1">{{ (int) $package->available_classes }}</p>
                                    </div>
                                    <div class="rounded-3xl bg-gray-50 p-4">
                                        <p class="text-xs font-black uppercase tracking-[.18em] text-gray-500">Valid</p>
                                        <p class="font-archivo text-3xl mt-1">{{ $validDays ? $validDays . 'D' : '30D' }}</p>
                                    </div>
                                </div>

                                <div class="mt-7 flex gap-3">
                                    @if($isCustomerLoggedIn)
                                        <a href="{{ route('em.customer.package.details', $package->id) }}" class="outline-btn flex-1 px-4">Details</a>
                                        <form method="POST" action="{{ route('em.customer.cart.add', $package->id) }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="pink-btn w-full px-4">Add Cart</button>
                                        </form>
                                    @else
                                        <a href="{{ $loginUrl }}" class="outline-btn flex-1 px-4">Login</a>
                                        <a href="{{ $registerUrl }}" class="pink-btn flex-1 px-4">Register</a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section id="sessions" class="py-24 bg-black text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-12">
                <div>
                    <p class="font-swell text-baddie-pink text-5xl mb-1">Choose a date</p>
                    <h2 class="section-title text-4xl sm:text-6xl">UPCOMING SESSIONS</h2>
                    <p class="mt-4 text-white/70 max-w-2xl font-semibold">Book sessions using your available package credits. Each booking uses one class credit.</p>
                </div>
                @if($isCustomerLoggedIn)
                    <a href="{{ $dashboardUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-white text-black font-black px-6 py-4 hover:bg-baddie-pink hover:text-white transition">Open Dashboard <i data-feather="grid" class="w-5 h-5"></i></a>
                @else
                    <a href="{{ $loginUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-white text-black font-black px-6 py-4 hover:bg-baddie-pink hover:text-white transition">Login to Book <i data-feather="log-in" class="w-5 h-5"></i></a>
                @endif
            </div>

            @if($landingSessions->isEmpty())
                <div class="rounded-[2rem] border-2 border-dashed border-white/15 bg-white/5 p-12 text-center">
                    <p class="font-archivo text-3xl">No upcoming sessions.</p>
                    <p class="mt-3 text-white/60 font-semibold">Create sessions from your schedule admin panel to show them here.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">
                    @foreach($landingSessions as $session)
                        @php
                            $sessionDate = $session->event_date ? Carbon::parse($session->event_date) : null;
                            $start = !empty($session->start_time) ? Carbon::parse($session->start_time)->format('g:i A') : '';
                            $end = !empty($session->end_time) ? Carbon::parse($session->end_time)->format('g:i A') : '';
                            $instructor = $session->instructor ?? $session->instructor_name ?? $session->coach_name ?? 'Coach';
                            $description = $session->description ?? 'A focused training session designed to improve player confidence, speed, and game IQ.';
                            $capacity = $session->capacity ?? null;
                        @endphp
                        <article class="card-hover rounded-[2rem] border border-white/10 bg-white text-black overflow-hidden">
                            <div class="p-7 bg-gradient-to-br from-baddie-pink to-pink-400 text-white">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-black uppercase tracking-[.2em] text-xs opacity-80">{{ $session->training_type ?? 'Training' }}</p>
                                        <h3 class="mt-3 font-archivo text-3xl leading-none tracking-[-.04em]">{{ $session->name }}</h3>
                                    </div>
                                    @if($sessionDate)
                                        <div class="w-20 shrink-0 rounded-3xl bg-white text-black p-3 text-center">
                                            <p class="font-archivo text-3xl leading-none">{{ $sessionDate->format('d') }}</p>
                                            <p class="font-black uppercase text-xs tracking-[.2em] text-baddie-pink">{{ $sessionDate->format('M') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="p-7">
                                <p class="text-gray-600 font-semibold line-clamp-2 min-h-[48px]">{{ $description }}</p>

                                <div class="mt-6 space-y-3 text-sm font-bold text-gray-700">
                                    <div class="flex items-center gap-3"><i data-feather="clock" class="w-4 h-4 text-baddie-pink"></i> {{ $start }} {{ $end ? ' - ' . $end : '' }}</div>
                                    <div class="flex items-center gap-3"><i data-feather="map-pin" class="w-4 h-4 text-baddie-pink"></i> <span class="line-clamp-1">{{ $session->location }}</span></div>
                                    <div class="flex items-center gap-3"><i data-feather="user-check" class="w-4 h-4 text-baddie-pink"></i> {{ $instructor }}</div>
                                </div>

                                <div class="mt-7 flex gap-3">
                                    <button type="button"
                                        class="outline-btn flex-1 px-4 session-info-btn"
                                        data-title="{{ e($session->name) }}"
                                        data-date="{{ $sessionDate ? $sessionDate->format('F d, Y') : '' }}"
                                        data-time="{{ trim($start . ($end ? ' - ' . $end : '')) }}"
                                        data-location="{{ e($session->location) }}"
                                        data-instructor="{{ e($instructor) }}"
                                        data-description="{{ e($description) }}">
                                        Details
                                    </button>

                                    @if($isCustomerLoggedIn)
                                        <button type="button"
                                            class="pink-btn flex-1 px-4 book-session-btn"
                                            data-action="{{ route('em.customer.session.book', $session->id) }}"
                                            data-title="{{ e($session->name) }}"
                                            data-date="{{ $sessionDate ? $sessionDate->format('F d, Y') : '' }}"
                                            data-time="{{ trim($start . ($end ? ' - ' . $end : '')) }}">
                                            Book
                                        </button>
                                    @else
                                        <a href="{{ $loginUrl }}" class="pink-btn flex-1 px-4">Login</a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section id="how" class="py-24 bg-soft-pink">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <p class="font-swell text-baddie-pink text-5xl">Simple flow</p>
                <h2 class="section-title text-4xl sm:text-6xl mt-1">HOW BOOKING WORKS</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
                <div class="rounded-[2rem] bg-white p-8 shadow-lg">
                    <div class="w-14 h-14 rounded-full bg-black text-white flex items-center justify-center font-archivo text-2xl">1</div>
                    <h3 class="font-archivo text-2xl mt-6">Create Account</h3>
                    <p class="mt-3 text-gray-600 font-semibold">Register or login to your customer portal.</p>
                </div>
                <div class="rounded-[2rem] bg-white p-8 shadow-lg">
                    <div class="w-14 h-14 rounded-full bg-baddie-pink text-white flex items-center justify-center font-archivo text-2xl">2</div>
                    <h3 class="font-archivo text-2xl mt-6">Buy Package</h3>
                    <p class="mt-3 text-gray-600 font-semibold">Choose a package and receive class credits.</p>
                </div>
                <div class="rounded-[2rem] bg-white p-8 shadow-lg">
                    <div class="w-14 h-14 rounded-full bg-black text-white flex items-center justify-center font-archivo text-2xl">3</div>
                    <h3 class="font-archivo text-2xl mt-6">Book Sessions</h3>
                    <p class="mt-3 text-gray-600 font-semibold">Use credits to book sessions for your players.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2.5rem] bg-black text-white p-8 sm:p-12 lg:p-16 overflow-hidden relative">
                <div class="absolute right-0 top-0 w-72 h-72 bg-baddie-pink/30 rounded-full blur-3xl"></div>
                <div class="relative z-10 max-w-3xl">
                    <p class="font-swell text-baddie-pink text-5xl">Ready?</p>
                    <h2 class="section-title text-4xl sm:text-6xl mt-1">START BOOKING YOUR TRAINING SESSIONS</h2>
                    <p class="mt-5 text-white/70 font-semibold text-lg">Get your package, reserve your class, and keep your schedule organized in one place.</p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        @if($isCustomerLoggedIn)
                            <a href="{{ $dashboardUrl }}" class="pink-btn">Go to Dashboard</a>
                            <a href="{{ route('em.customer.bookings') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-white text-black font-black px-6 py-4 hover:bg-baddie-pink hover:text-white transition">My Bookings</a>
                        @else
                            <a href="{{ $registerUrl }}" class="pink-btn">Create Account</a>
                            <a href="{{ $loginUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-white text-black font-black px-6 py-4 hover:bg-baddie-pink hover:text-white transition">Login</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="bg-black text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <p class="font-archivo text-2xl">BADDIES</p>
            <p class="text-white/50 font-semibold mt-1">Customer event booking system</p>
        </div>
        <div class="flex flex-wrap gap-5 font-bold text-white/70">
            <a href="#packages" class="hover:text-baddie-pink">Packages</a>
            <a href="#sessions" class="hover:text-baddie-pink">Sessions</a>
            @if($isCustomerLoggedIn)
                <a href="{{ $dashboardUrl }}" class="hover:text-baddie-pink">Dashboard</a>
            @else
                <a href="{{ $loginUrl }}" class="hover:text-baddie-pink">Login</a>
            @endif
        </div>
    </div>
</footer>

<div id="sessionInfoModal" class="modal-backdrop fixed inset-0 z-[100] bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="modal-box w-full max-w-2xl rounded-[2rem] bg-white text-black overflow-hidden shadow-2xl">
        <div class="p-6 sm:p-8 border-b border-black/5 flex items-start justify-between gap-4">
            <div>
                <p class="font-black uppercase tracking-[.2em] text-xs text-baddie-pink">Session Details</p>
                <h3 id="infoTitle" class="font-archivo text-3xl mt-2">Session</h3>
            </div>
            <button type="button" class="close-modal w-11 h-11 rounded-full bg-black text-white flex items-center justify-center"><i data-feather="x" class="w-5 h-5"></i></button>
        </div>
        <div class="p-6 sm:p-8 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-3xl bg-gray-50 p-4"><p class="text-xs font-black uppercase tracking-[.18em] text-gray-500">Date</p><p id="infoDate" class="font-bold mt-1"></p></div>
                <div class="rounded-3xl bg-gray-50 p-4"><p class="text-xs font-black uppercase tracking-[.18em] text-gray-500">Time</p><p id="infoTime" class="font-bold mt-1"></p></div>
                <div class="rounded-3xl bg-gray-50 p-4"><p class="text-xs font-black uppercase tracking-[.18em] text-gray-500">Location</p><p id="infoLocation" class="font-bold mt-1"></p></div>
                <div class="rounded-3xl bg-gray-50 p-4"><p class="text-xs font-black uppercase tracking-[.18em] text-gray-500">Instructor</p><p id="infoInstructor" class="font-bold mt-1"></p></div>
            </div>
            <p id="infoDescription" class="text-gray-600 font-semibold leading-relaxed"></p>
        </div>
    </div>
</div>

@if($isCustomerLoggedIn)
<div id="bookingModal" class="modal-backdrop fixed inset-0 z-[110] bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="modal-box w-full max-w-3xl rounded-[2rem] bg-white text-black overflow-hidden shadow-2xl max-h-[92vh] overflow-y-auto">
        <div class="p-6 sm:p-8 border-b border-black/5 flex items-start justify-between gap-4 sticky top-0 bg-white z-10">
            <div>
                <p class="font-black uppercase tracking-[.2em] text-xs text-baddie-pink">Book Session</p>
                <h3 id="bookingTitle" class="font-archivo text-3xl mt-2">Session</h3>
                <p id="bookingMeta" class="text-gray-500 font-bold mt-1"></p>
            </div>
            <button type="button" class="close-modal w-11 h-11 rounded-full bg-black text-white flex items-center justify-center"><i data-feather="x" class="w-5 h-5"></i></button>
        </div>

        <form id="bookingForm" method="POST" action="" class="p-6 sm:p-8">
            @csrf
            <div id="bookingAlert" class="hidden mb-5 rounded-2xl px-4 py-3 font-bold"></div>

            @if($remainingCredits <= 0)
                <div class="rounded-3xl bg-pink-50 border border-pink-100 p-5 mb-6">
                    <p class="font-archivo text-xl">No credits available</p>
                    <p class="text-gray-600 font-semibold mt-1">Please buy a package before booking a session.</p>
                    <a href="{{ route('em.customer.packages') }}" class="pink-btn mt-4">Buy Package</a>
                </div>
            @else
                <div class="rounded-3xl bg-gray-50 p-5 mb-6">
                    <p class="text-xs font-black uppercase tracking-[.18em] text-gray-500">Available Credits</p>
                    <p class="font-archivo text-4xl text-baddie-pink mt-1">{{ $remainingCredits }}</p>
                </div>
            @endif

            @if($children->isNotEmpty())
                <div class="mb-7">
                    <label class="block text-sm font-black uppercase tracking-[.18em] text-gray-500 mb-3">Choose Existing Player</label>
                    <select name="child_id" id="childSelect" class="w-full rounded-2xl border border-black/10 px-4 py-4 font-bold focus:outline-none focus:ring-4 focus:ring-pink-100">
                        <option value="">Add a new player</option>
                        @foreach($children as $child)
                            <option value="{{ $child->id }}">{{ $child->player_first }} {{ $child->player_last }}{{ $child->grad_year ? ' · ' . $child->grad_year : '' }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div id="newPlayerFields" class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-black uppercase tracking-[.18em] text-gray-500 mb-2">Player First Name</label>
                        <input type="text" name="player_first" class="w-full rounded-2xl border border-black/10 px-4 py-4 font-bold focus:outline-none focus:ring-4 focus:ring-pink-100">
                    </div>
                    <div>
                        <label class="block text-sm font-black uppercase tracking-[.18em] text-gray-500 mb-2">Player Last Name</label>
                        <input type="text" name="player_last" class="w-full rounded-2xl border border-black/10 px-4 py-4 font-bold focus:outline-none focus:ring-4 focus:ring-pink-100">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-black uppercase tracking-[.18em] text-gray-500 mb-2">Grad Year</label>
                    <input type="number" name="grad_year" min="2020" max="2100" class="w-full rounded-2xl border border-black/10 px-4 py-4 font-bold focus:outline-none focus:ring-4 focus:ring-pink-100">
                </div>

                <div>
                    <label class="block text-sm font-black uppercase tracking-[.18em] text-gray-500 mb-3">Positions</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach(['Attack', 'Middie', 'Defense', 'Goalie'] as $position)
                            <label class="rounded-2xl border border-black/10 px-4 py-3 font-bold flex items-center gap-2 cursor-pointer hover:border-baddie-pink">
                                <input type="checkbox" name="positions[]" value="{{ $position }}" class="accent-pink-500">
                                {{ $position }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-end">
                <button type="button" class="close-modal outline-btn">Cancel</button>
                <button type="submit" class="pink-btn" {{ $remainingCredits <= 0 ? 'disabled' : '' }}>Confirm Booking</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    const heroSlides = @json($heroSlides);
    let activeHero = 0;
    let heroTimer = null;

    function setHero(index) {
        activeHero = (index + heroSlides.length) % heroSlides.length;
        document.querySelectorAll('.hero-slide').forEach((slide, i) => slide.classList.toggle('active', i === activeHero));
        document.querySelectorAll('.hero-dot').forEach((dot, i) => dot.dataset.active = i === activeHero ? 'true' : 'false');
        const current = heroSlides[activeHero];
        document.getElementById('heroEyebrow').textContent = current.eyebrow;
        document.getElementById('heroTitle').textContent = current.title;
        document.getElementById('heroSubtitle').textContent = current.subtitle;
    }

    function startHeroTimer() {
        clearInterval(heroTimer);
        heroTimer = setInterval(() => setHero(activeHero + 1), 6500);
    }

    document.getElementById('nextHero')?.addEventListener('click', () => { setHero(activeHero + 1); startHeroTimer(); });
    document.getElementById('prevHero')?.addEventListener('click', () => { setHero(activeHero - 1); startHeroTimer(); });
    document.querySelectorAll('.hero-dot').forEach(dot => dot.addEventListener('click', () => { setHero(Number(dot.dataset.heroDot)); startHeroTimer(); }));
    startHeroTimer();

    const openMobileMenu = document.getElementById('openMobileMenu');
    const closeMobileMenu = document.getElementById('closeMobileMenu');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileOverlay = document.getElementById('mobileOverlay');

    function toggleMobileMenu(show) {
        mobileMenu?.classList.toggle('active', show);
        mobileOverlay?.classList.toggle('hidden', !show);
    }

    openMobileMenu?.addEventListener('click', () => toggleMobileMenu(true));
    closeMobileMenu?.addEventListener('click', () => toggleMobileMenu(false));
    mobileOverlay?.addEventListener('click', () => toggleMobileMenu(false));
    document.querySelectorAll('.mobile-link').forEach(link => link.addEventListener('click', () => toggleMobileMenu(false)));

    const profileBtn = document.getElementById('profileDropdownBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    profileBtn?.addEventListener('click', (event) => {
        event.stopPropagation();
        profileDropdown?.classList.toggle('hidden');
    });
    document.addEventListener('click', () => profileDropdown?.classList.add('hidden'));

    function openModal(modal) { modal?.classList.add('active'); document.body.style.overflow = 'hidden'; }
    function closeModals() {
        document.querySelectorAll('.modal-backdrop').forEach(modal => modal.classList.remove('active'));
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.close-modal').forEach(button => button.addEventListener('click', closeModals));
    document.querySelectorAll('.modal-backdrop').forEach(modal => {
        modal.addEventListener('click', event => { if (event.target === modal) closeModals(); });
    });

    document.querySelectorAll('.session-info-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('infoTitle').textContent = button.dataset.title || 'Session';
            document.getElementById('infoDate').textContent = button.dataset.date || '-';
            document.getElementById('infoTime').textContent = button.dataset.time || '-';
            document.getElementById('infoLocation').textContent = button.dataset.location || '-';
            document.getElementById('infoInstructor').textContent = button.dataset.instructor || '-';
            document.getElementById('infoDescription').textContent = button.dataset.description || '';
            openModal(document.getElementById('sessionInfoModal'));
        });
    });

    document.querySelectorAll('.book-session-btn').forEach(button => {
        button.addEventListener('click', () => {
            const form = document.getElementById('bookingForm');
            if (!form) return;
            form.action = button.dataset.action;
            document.getElementById('bookingTitle').textContent = button.dataset.title || 'Session';
            document.getElementById('bookingMeta').textContent = [button.dataset.date, button.dataset.time].filter(Boolean).join(' · ');
            const alert = document.getElementById('bookingAlert');
            alert?.classList.add('hidden');
            alert.textContent = '';
            openModal(document.getElementById('bookingModal'));
        });
    });

    const childSelect = document.getElementById('childSelect');
    const newPlayerFields = document.getElementById('newPlayerFields');
    function updatePlayerFields() {
        if (!childSelect || !newPlayerFields) return;
        const hasChild = !!childSelect.value;
        newPlayerFields.style.display = hasChild ? 'none' : 'block';
        newPlayerFields.querySelectorAll('input').forEach(input => {
            if (input.type !== 'checkbox') input.disabled = hasChild;
            if (input.type === 'checkbox') input.disabled = hasChild;
        });
    }
    childSelect?.addEventListener('change', updatePlayerFields);
    updatePlayerFields();

    const bookingForm = document.getElementById('bookingForm');
    bookingForm?.addEventListener('submit', async function(event) {
        event.preventDefault();

        const submitButton = bookingForm.querySelector('button[type="submit"]');
        const alert = document.getElementById('bookingAlert');
        const originalText = submitButton.textContent;

        alert.className = 'hidden mb-5 rounded-2xl px-4 py-3 font-bold';
        alert.textContent = '';
        submitButton.disabled = true;
        submitButton.textContent = 'Booking...';

        try {
            const response = await fetch(bookingForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new FormData(bookingForm)
            });

            const data = await response.json();

            if (!response.ok || !data.status) {
                alert.className = 'mb-5 rounded-2xl px-4 py-3 font-bold bg-red-50 text-red-700 border border-red-100';
                alert.textContent = data.message || 'Booking failed. Please try again.';

                if (data.needs_package && data.packages_url) {
                    setTimeout(() => window.location.href = data.packages_url, 1200);
                }
                return;
            }

            alert.className = 'mb-5 rounded-2xl px-4 py-3 font-bold bg-green-50 text-green-700 border border-green-100';
            alert.textContent = data.message || 'Session booked successfully.';
            setTimeout(() => window.location.href = data.redirect || '{{ route('em.customer.bookings') }}', 800);
        } catch (error) {
            alert.className = 'mb-5 rounded-2xl px-4 py-3 font-bold bg-red-50 text-red-700 border border-red-100';
            alert.textContent = 'Something went wrong. Please try again.';
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        }
    });

    feather.replace();
</script>
</body>
</html>
