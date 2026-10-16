@extends('layouts.app', ['activePage' => 'schedules', 'titlePage' => __('Events and Meeting Schedules')])

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    .em-wrap{padding:0;margin:0}.em-card{background:#fff;border-radius:18px;padding:25px;box-shadow:0 12px 38px rgba(15,23,42,.06);min-height:650px}.em-tabs{display:flex;gap:22px;border-bottom:1px solid #e5e7eb;margin-top:18px}.em-tab{padding:12px 0;color:#64748b;font-weight:800;cursor:pointer}.em-tab.active{color:#0d6efd;border-bottom:3px solid #0d6efd}.em-panel{display:none}.em-panel.active{display:block}.em-create-menu{position:absolute;right:0;top:48px;width:330px;background:#fff;border:1px solid #e5e7eb;border-radius:16px;box-shadow:0 18px 45px rgba(15,23,42,.16);padding:12px;display:none;z-index:10}.em-create-item{display:flex;gap:15px;align-items:center;padding:18px;border-radius:14px;text-decoration:none;color:#172033}.em-create-item:hover{background:#f5f7ff;text-decoration:none;color:#172033}.em-create-icon{width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px}.em-icon-package{background:#dbeafe;color:#0d6efd}.em-icon-event{background:#fee2e2;color:#ef4444}.em-list-card{border:1px solid #e5e7eb;border-radius:16px;padding:18px;margin-bottom:14px;transition:.2s}.em-list-card:hover{border-color:#0d6efd;box-shadow:0 12px 28px rgba(37,99,235,.10)}.em-badge{font-size:12px;font-weight:800;padding:6px 10px;border-radius:999px;background:#eef2ff;color:#2563eb}.em-muted{color:#64748b}.empty-state{height:430px;display:flex;align-items:center;justify-content:center;text-align:center;color:#64748b}.empty-icon{width:110px;height:110px;border-radius:28px;background:linear-gradient(135deg,#eef2ff,#dbeafe);display:flex;align-items:center;justify-content:center;font-size:48px;color:#2563eb;margin:0 auto 18px}#emCalendar{min-height:570px}.action-btn{border:0;background:#f8fafc;width:36px;height:36px;border-radius:50%;color:#64748b}.action-btn:hover{background:#eef2ff;color:#0d6efd}
    .bg-box.container-fluid.fix-nav.header-layout{
        margin-bottom: .0 !important;
    }
    .accounting-hero{
        background:linear-gradient(135deg,#0f172a,#1e293b 55%,#2563eb);
        border-radius:22px;
        padding:26px;
        color:#fff;
        position:relative;
        overflow:hidden;
        box-shadow:0 22px 55px rgba(15,23,42,.22);
    }
    .accounting-hero:before{
        content:"";
        position:absolute;
        width:280px;
        height:280px;
        border-radius:50%;
        right:-90px;
        top:-120px;
        background:rgba(255,255,255,.10);
    }
    .accounting-hero:after{
        content:"";
        position:absolute;
        width:180px;
        height:180px;
        border-radius:50%;
        right:100px;
        bottom:-110px;
        background:rgba(37,99,235,.45);
    }
    .accounting-hero > *{position:relative;z-index:2}

    .accounting-stat{
        border:1px solid #e5e7eb;
        border-radius:20px;
        padding:20px;
        background:#fff;
        box-shadow:0 14px 38px rgba(15,23,42,.06);
        height:100%;
    }
    .accounting-stat-icon{
        width:46px;
        height:46px;
        border-radius:15px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#eef2ff;
        color:#2563eb;
        font-size:20px;
    }
    .accounting-stat-label{
        color:#64748b;
        font-size:12px;
        font-weight:900;
        text-transform:uppercase;
        letter-spacing:.06em;
    }
    .accounting-stat-value{
        color:#0f172a;
        font-size:28px;
        line-height:1;
        font-weight:900;
        margin-top:8px;
    }
    .accounting-stat-note{
        color:#64748b;
        font-size:13px;
        font-weight:700;
        margin-top:8px;
    }

    .accounting-section{
        border:1px solid #e5e7eb;
        border-radius:22px;
        background:#fff;
        box-shadow:0 14px 38px rgba(15,23,42,.06);
        overflow:hidden;
    }
    .accounting-section-head{
        padding:20px 22px;
        border-bottom:1px solid #e5e7eb;
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:15px;
    }
    .accounting-section-body{
        padding:22px;
    }
    .accounting-title{
        font-size:17px;
        font-weight:900;
        color:#0f172a;
        margin:0;
    }
    .accounting-subtitle{
        color:#64748b;
        font-size:13px;
        font-weight:700;
        margin-top:3px;
    }

    .package-sale-row{
        padding:15px 0;
        border-bottom:1px solid #eef2f7;
    }
    .package-sale-row:last-child{border-bottom:0}
    .package-progress{
        height:8px;
        border-radius:999px;
        background:#e5e7eb;
        overflow:hidden;
        margin-top:10px;
    }
    .package-progress span{
        display:block;
        height:100%;
        border-radius:999px;
        background:linear-gradient(90deg,#2563eb,#0ea5e9);
    }

    .accounting-table{
        margin:0;
    }
    .accounting-table thead th{
        background:#f8fafc;
        color:#64748b;
        font-size:11px;
        font-weight:900;
        text-transform:uppercase;
        letter-spacing:.06em;
        border-bottom:1px solid #e5e7eb;
        white-space:nowrap;
    }
    .accounting-table tbody td{
        vertical-align:middle;
        border-bottom:1px solid #eef2f7;
        color:#334155;
        font-weight:700;
    }
    .accounting-table tbody tr:hover{
        background:#f8fafc;
    }
    .accounting-pill{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:6px 10px;
        border-radius:999px;
        background:#dcfce7;
        color:#15803d;
        font-size:12px;
        font-weight:900;
    }
    .accounting-pill-blue{
        background:#dbeafe;
        color:#1d4ed8;
    }
    .accounting-pill-dark{
        background:#f1f5f9;
        color:#334155;
    }
    .payment-avatar{
        width:42px;
        height:42px;
        border-radius:14px;
        background:linear-gradient(135deg,#2563eb,#0ea5e9);
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:900;
    }
    .transaction-text{
        max-width:150px;
        display:inline-block;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }
</style>

@section('back-btn')
    <a href="{{ route('schedules.index') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection
@section('order-header')
    Events & Meetings
@endsection
<div class="em-wrap">
    <div class="em-card">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 position-relative">
            <h5 class="mb-0 fw-bold">Scheduling</h5>
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <button type="button" class="btn btn-primary px-4 rounded-pill shadow-sm" id="openCreateMenu">
                        <i class="fa-solid fa-plus me-2"></i>Create
                    </button>
                    <div class="em-create-menu" id="createMenu">
                        <a href="{{ route('em.packages.create') }}" class="em-create-item">
                            <span class="em-create-icon em-icon-package"><i class="fa-solid fa-gift"></i></span>
                            <span><strong>Create Package</strong><br><small class="em-muted">Create package with classes.</small></span>
                        </a>
                        <a href="{{ route('em.sessions.create') }}" class="em-create-item">
                            <span class="em-create-icon em-icon-event"><i class="fa-regular fa-calendar-days"></i></span>
                            <span><strong>Create Event</strong><br><small class="em-muted">Create a class/session event.</small></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="em-tabs">
            <div class="em-tab {{ $activeTab === 'packages' ? 'active' : '' }}" data-tab="packages">Packages</div>
            <div class="em-tab {{ $activeTab === 'sessions' ? 'active' : '' }}" data-tab="sessions">Sessions</div>
            <div class="em-tab {{ $activeTab === 'calendar' ? 'active' : '' }}" data-tab="calendar">Booked Calendar</div>
            <div class="em-tab {{ $activeTab === 'accounting' ? 'active' : '' }}" data-tab="accounting">Accounting</div>
        </div>

        <div class="pt-4 em-panel {{ $activeTab === 'packages' ? 'active' : '' }}" id="packagesPanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Packages</h5>
            </div>
            @forelse($packages as $package)
                <div class="em-list-card d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="fw-bold fs-5">{{ $package->package_name }}</div>
                        <div class="em-muted">{{ Str::limit($package->package_description, 120) ?: 'No description' }}</div>
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            <span class="em-badge">${{ number_format($package->package_price, 2) }}</span>
                            <span class="em-badge">{{ $package->available_classes }} Classes</span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('em.packages.edit', $package->id) }}" class="action-btn d-inline-flex align-items-center justify-content-center" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <button type="button" class="action-btn text-danger delete-package" data-id="{{ $package->id }}" title="Delete"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            @empty
                <div class="empty-state"><div><div class="empty-icon"><i class="fa-solid fa-gift"></i></div><h4 class="fw-bold">No Packages Yet</h4><p>Create your first package to show it here.</p></div></div>
            @endforelse
        </div>

        <div class="pt-4 em-panel {{ $activeTab === 'sessions' ? 'active' : '' }}" id="sessionsPanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Sessions</h5>
            </div>
            @forelse($sessions as $session)
                <div class="em-list-card d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <div class="fw-bold fs-5">{{ $session->training_type ?: 'Training' }}</div>
                        <div class="em-muted">{{ Str::limit($session->description, 120) ?: 'No description' }}</div>
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            <span class="em-badge"><i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($session->event_date)->format('l, M d, Y') }}</span>
                            <span class="em-badge"><i class="fa-regular fa-clock me-1"></i>{{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('h:i A') }}</span>
                            {{-- <span class="em-badge"><i class="fa-solid fa-dumbbell me-1"></i>{{ $session->training_type ?: 'Training' }}</span> --}}
                            <span class="em-badge"><i class="fa-solid fa-user me-1"></i>{{ $session->instructor ?: '' }}</span>
                            <span class="em-badge"><i class="fa-solid fa-location-dot me-1"></i>{{ $session->location }}</span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('em.sessions.edit', $session->id) }}" class="action-btn d-inline-flex align-items-center justify-content-center" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <button type="button" class="action-btn text-danger delete-session" data-id="{{ $session->id }}" title="Delete"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            @empty
                <div class="empty-state"><div><div class="empty-icon"><i class="fa-regular fa-calendar-days"></i></div><h4 class="fw-bold">No Sessions Yet</h4><p>Create your first event session to show it here.</p></div></div>
            @endforelse
        </div>

        <div class="pt-4 em-panel {{ $activeTab === 'calendar' ? 'active' : '' }}" id="calendarPanel">
            <h5 class="fw-bold mb-3">Booked Calendar</h5>
            <div id="emCalendar"></div>
        </div>
        @php
            $accountingItems = collect($accountingItems ?? []);
            $salesByPackage = collect($salesByPackage ?? []);

            $totalOrders = $accountingSummary['total_orders'] ?? 0;
            $packageRevenue = $accountingSummary['package_revenue'] ?? 0;
            $grossCollected = $accountingSummary['gross_collected'] ?? 0;
            $processingFees = $accountingSummary['processing_fees'] ?? 0;
            $creditsSold = $accountingSummary['total_credits_sold'] ?? 0;
            $netRevenue = max($grossCollected - $processingFees, 0);
            $avgOrder = $totalOrders > 0 ? ($grossCollected / $totalOrders) : 0;

            $maxPackageRevenue = $salesByPackage->max('revenue') ?: 1;

            $recentPayments = $accountingItems->take(8);
        @endphp

        <div class="pt-4 em-panel {{ $activeTab === 'accounting' ? 'active' : '' }}" id="accountingPanel">

            <div class="accounting-hero mb-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-4">
                    <div>
                        <div class="text-white-50 fw-bold text-uppercase" style="letter-spacing:.12em;font-size:12px;">
                            Accounting Dashboard
                        </div>

                        <h3 class="fw-bold mt-2 mb-2">
                            Package Payment Overview
                        </h3>

                        <p class="mb-0 text-white-50 fw-semibold">
                            Track customer payments, package revenue, processing fees, and credits sold.
                        </p>
                    </div>

                    <div class="text-start text-md-end">
                        <div class="text-white-50 fw-bold text-uppercase" style="letter-spacing:.12em;font-size:12px;">
                            Gross Collected
                        </div>

                        <div class="fw-black mt-1" style="font-size:36px;font-weight:900;line-height:1;">
                            ${{ number_format($grossCollected, 2) }}
                        </div>

                        <div class="text-white-50 fw-semibold mt-2">
                            {{ number_format($totalOrders) }} paid orders
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="accounting-stat">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="accounting-stat-label">Package Revenue</div>
                                <div class="accounting-stat-value">
                                    ${{ number_format($packageRevenue, 2) }}
                                </div>
                                <div class="accounting-stat-note">
                                    Sales value before fees.
                                </div>
                            </div>

                            <div class="accounting-stat-icon">
                                <i class="fa-solid fa-sack-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="accounting-stat">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="accounting-stat-label">Net Revenue</div>
                                <div class="accounting-stat-value">
                                    ${{ number_format($netRevenue, 2) }}
                                </div>
                                <div class="accounting-stat-note">
                                    Gross minus processing fees.
                                </div>
                            </div>

                            <div class="accounting-stat-icon">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="accounting-stat">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="accounting-stat-label">Processing Fees</div>
                                <div class="accounting-stat-value">
                                    ${{ number_format($processingFees, 2) }}
                                </div>
                                <div class="accounting-stat-note">
                                    3% card processing.
                                </div>
                            </div>

                            <div class="accounting-stat-icon">
                                <i class="fa-solid fa-percent"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="accounting-stat">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="accounting-stat-label">Credits Sold</div>
                                <div class="accounting-stat-value">
                                    {{ number_format($creditsSold) }}
                                </div>
                                <div class="accounting-stat-note">
                                    Average order ${{ number_format($avgOrder, 2) }}.
                                </div>
                            </div>

                            <div class="accounting-stat-icon">
                                <i class="fa-solid fa-ticket"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-xl-8">
                    <div class="accounting-section">
                        <div class="accounting-section-head">
                            <div>
                                <h5 class="accounting-title">Recent Payments</h5>
                                <div class="accounting-subtitle">
                                    Latest successful payments for your packages.
                                </div>
                            </div>

                            <span class="accounting-pill accounting-pill-blue">
                                <i class="fa-solid fa-receipt"></i>
                                {{ $accountingItems->count() }} payment items
                            </span>
                        </div>

                        @if($recentPayments->count())
                            <div class="table-responsive">
                                <table class="table accounting-table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Customer</th>
                                            <th>Package</th>
                                            <th>Credits</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Transaction</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($recentPayments as $item)
                                            @php
                                                $order = $item->order;
                                                $paymentLog = $order->latestPaymentLog ?? null;
                                                $customer = $order->customer ?? null;

                                                $customerName = $customer
                                                    ? trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''))
                                                    : 'Customer';

                                                $customerName = $customerName ?: ($customer->name ?? $customer->email ?? 'Customer');
                                                $customerInitial = strtoupper(substr($customerName, 0, 1));

                                                $paidDate = $order->paid_at ?? $order->created_at;
                                                $credits = (int) $item->classes_per_package * (int) $item->quantity;
                                            @endphp

                                            <tr>
                                                <td>
                                                    <div class="fw-bold text-dark">
                                                        {{ $paidDate ? \Carbon\Carbon::parse($paidDate)->format('M d, Y') : '-' }}
                                                    </div>
                                                    <div class="small text-muted">
                                                        {{ $paidDate ? \Carbon\Carbon::parse($paidDate)->format('h:i A') : '' }}
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="payment-avatar">
                                                            {{ $customerInitial }}
                                                        </div>

                                                        <div>
                                                            <div class="fw-bold text-dark">
                                                                {{ $customerName }}
                                                            </div>

                                                            @if($customer && $customer->email)
                                                                <div class="small text-muted">
                                                                    {{ $customer->email }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="fw-bold text-dark">
                                                        {{ $item->package_name }}
                                                    </div>

                                                    <div class="small text-muted">
                                                        Order #{{ $order->order_no ?? '-' }}
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="accounting-pill accounting-pill-dark">
                                                        {{ $credits }} credits
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="fw-bold text-dark">
                                                        ${{ number_format($item->total_price, 2) }}
                                                    </div>

                                                    <div class="small text-muted">
                                                        Qty {{ $item->quantity }}
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="accounting-pill">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Paid
                                                    </span>
                                                </td>

                                                <td>
                                                    @if($paymentLog && $paymentLog->transaction_id)
                                                        <span class="transaction-text fw-bold text-dark" title="{{ $paymentLog->transaction_id }}">
                                                            {{ $paymentLog->transaction_id }}
                                                        </span>
                                                        <div class="small text-muted">
                                                            {{ strtoupper($paymentLog->gateway ?? 'CARD') }}
                                                        </div>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <div>
                                    <div class="empty-icon">
                                        <i class="fa-solid fa-file-invoice-dollar"></i>
                                    </div>
                                    <h4 class="fw-bold">No Payments Yet</h4>
                                    <p>Payments for your packages will appear here after customers purchase packages.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="accounting-section mb-4">
                        <div class="accounting-section-head">
                            <div>
                                <h5 class="accounting-title">Sales by Package</h5>
                                <div class="accounting-subtitle">
                                    Best performing packages.
                                </div>
                            </div>

                            <span class="accounting-stat-icon">
                                <i class="fa-solid fa-chart-simple"></i>
                            </span>
                        </div>

                        <div class="accounting-section-body">
                            @if($salesByPackage->count())
                                @foreach($salesByPackage as $row)
                                    @php
                                        $percent = $maxPackageRevenue > 0
                                            ? round(($row['revenue'] / $maxPackageRevenue) * 100)
                                            : 0;
                                    @endphp

                                    <div class="package-sale-row">
                                        <div class="d-flex justify-content-between gap-3">
                                            <div>
                                                <div class="fw-bold text-dark">
                                                    {{ $row['package_name'] }}
                                                </div>

                                                <div class="small text-muted">
                                                    {{ $row['orders'] }} orders · {{ $row['quantity'] }} sold · {{ $row['credits'] }} credits
                                                </div>
                                            </div>

                                            <div class="fw-bold text-primary">
                                                ${{ number_format($row['revenue'], 2) }}
                                            </div>
                                        </div>

                                        <div class="package-progress">
                                            <span style="width: {{ $percent }}%"></span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-chart-line fa-2x mb-3"></i>
                                    <p class="mb-0 fw-semibold">No package sales yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="accounting-section">
                        <div class="accounting-section-head">
                            <div>
                                <h5 class="accounting-title">Quick Breakdown</h5>
                                <div class="accounting-subtitle">
                                    Payment totals.
                                </div>
                            </div>
                        </div>

                        <div class="accounting-section-body">
                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted fw-bold">Paid Orders</span>
                                <strong>{{ number_format($totalOrders) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted fw-bold">Package Revenue</span>
                                <strong>${{ number_format($packageRevenue, 2) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted fw-bold">Gross Collected</span>
                                <strong>${{ number_format($grossCollected, 2) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between py-2">
                                <span class="text-muted fw-bold">Processing Fees</span>
                                <strong class="text-danger">${{ number_format($processingFees, 2) }}</strong>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark">Estimated Net</span>
                                <strong class="fs-5 text-success">
                                    ${{ number_format($netRevenue, 2) }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function(){
    $('#openCreateMenu').on('click', function(e){ e.stopPropagation(); $('#createMenu').toggle(); });
    $(document).on('click', function(){ $('#createMenu').hide(); });

    $('.em-tab').on('click', function(){
        let tab = $(this).data('tab');
        $('.em-tab').removeClass('active');
        $(this).addClass('active');
        $('.em-panel').removeClass('active');
        $('#' + tab + 'Panel').addClass('active');
        history.replaceState(null, '', '{{ route('schedules.index') }}?tab=' + tab);
        if(tab === 'calendar') initCalendar();
    });

    let calendarLoaded = false;
    function initCalendar(){
        if(calendarLoaded) return;
        calendarLoaded = true;
        let el = document.getElementById('emCalendar');
        let calendar = new FullCalendar.Calendar(el, {
            initialView: 'dayGridMonth',
            height: 620,
            events: '{{ route('em.calendar.events') }}',
            eventClick: function(info){
                Swal.fire(info.event.title, (info.event.extendedProps.location || ''), 'info');
            }
        });
        calendar.render();
    }
    @if($activeTab === 'calendar') initCalendar(); @endif

    $('.delete-package').on('click', function(){
        let id = $(this).data('id');
        Swal.fire({title:'Delete package?', text:'This package will be removed.', icon:'warning', showCancelButton:true}).then(function(r){
            if(!r.value && !r.isConfirmed) return;
            $.ajax({url:'{{ url('/schedules/packages') }}/'+id, type:'DELETE', data:{_token:'{{ csrf_token() }}'}, success:function(){ location.reload(); }});
        });
    });
    $('.delete-session').on('click', function(){
        let id = $(this).data('id');
        Swal.fire({title:'Delete session?', text:'This event will be removed.', icon:'warning', showCancelButton:true}).then(function(r){
            if(!r.value && !r.isConfirmed) return;
            $.ajax({url:'{{ url('/schedules/sessions') }}/'+id, type:'DELETE', data:{_token:'{{ csrf_token() }}'}, success:function(){ location.reload(); }});
        });
    });
});
</script>
@endsection
