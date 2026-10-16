@extends('layouts.app', ['activePage' => 'home', 'titlePage' => __('Dashboard')])
@section('content')
<style>
#encore-dashboard {
    --dashboard-ink: #32325d; --dashboard-muted: #8898aa; --dashboard-line: #e9ecef;
    --dashboard-green: #55a630; --dashboard-red: #d00000;
    font-family: inherit; font-size: 13px; color: var(--dashboard-ink);
    background: #f7f7f7; padding: 20px;
    padding-bottom: calc(20px + var(--dashboard-footer-space, 60px));
    margin: 0; min-width: 0;
}
#encore-dashboard * { box-sizing: border-box; }
#encore-dashboard .dashboard-metrics { display: grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap: 12px; margin-bottom: 16px; }
#encore-dashboard .dashboard-metric { --card-accent: #2879e8; --card-tint: #f0f6ff; --card-icon: #e0edff; background: #fff; border: 1px solid #e9edf3; border-radius: 12px; padding: 8px; min-width: 0; box-shadow: 0 3px 12px rgba(30,50,80,.035); align-self: start; }
#encore-dashboard .dashboard-metric--cart { --card-accent: #8157dc; --card-tint: #f6f2ff; --card-icon: #ece3ff; }
#encore-dashboard .dashboard-metric { position: relative; display: flex; flex-direction: column; min-height: 0; align-self: stretch; background: var(--card-tint); padding: 12px; }
#encore-dashboard .dashboard-metric-summary { flex-wrap: wrap; min-height: 0; }
#encore-dashboard .dashboard-type-totals { flex: 0 1 155px; min-width: 135px; margin: 0 0 0 auto; font-size: 12px; }
#encore-dashboard .dashboard-type-totals div { display: flex; justify-content: space-between; gap: 8px; padding: 1px 0; line-height: 20px; }
#encore-dashboard .dashboard-type-totals dt { font-weight: 400; color: #68778e; }
#encore-dashboard .dashboard-type-totals dd { margin: 0; font-weight: 700; color: var(--card-accent); }
#encore-dashboard .dashboard-card-amount { display: block; margin-top: 6px; font-size: 26px; line-height: 30px; overflow-wrap: anywhere; font-variant-numeric: tabular-nums; }
#encore-dashboard .dashboard-metric-body { margin-top: auto; padding: 6px 0; }

#encore-dashboard .dashboard-metric--production { --card-accent: #ce8500; --card-tint: #fff8ec; --card-icon: #ffedca; }
#encore-dashboard .dashboard-metric--receivable { --card-accent: #078896; --card-tint: #edfafa; --card-icon: #d7f2f3; }
#encore-dashboard .dashboard-metric-summary { display: flex; align-items: flex-start; gap: 8px; padding: 0; border-radius: 8px; background: var(--card-tint); list-style: none; min-width: 0; }
#encore-dashboard .dashboard-icon-box { width: 32px; height: 34px; border-radius: 9px; background: var(--card-icon); color: var(--card-accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 19px; }
#encore-dashboard .dashboard-metric-copy { flex: 1; min-width: 0; overflow-wrap: anywhere; }
#encore-dashboard .dashboard-metric-count { display: block; font-size: 12px; color: #68778e; margin-top: 4px; }
#encore-dashboard .dashboard-metric-footer { display: flex; align-items: center; flex-wrap: wrap; gap: 6px; padding: 0; font-size: 12px; color: #68778e; }
#encore-dashboard .dashboard-controls > .select2-container { max-width: 100%; }
#encore-dashboard .select2-selection--single { min-height: 34px; border-color: var(--dashboard-line); border-radius: 6px; }
#encore-dashboard .dashboard-metric-label { font-size: 13px; line-height: 19px; margin: 0 0 6px; font-weight: 400; }
#encore-dashboard .dashboard-metric-label span { white-space: nowrap; font-weight: 600; }
#encore-dashboard .dashboard-metric-value { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
#encore-dashboard .dashboard-metric-value strong { font-size: 20px; line-height: 25px; font-weight: 700; }
#encore-dashboard .dashboard-change { background: #ecffe3; color: var(--dashboard-green); border-radius: 150px; display: inline-flex; align-items: center; gap: 5px; padding: 0 8px; height: 22px; font-size: 12px; white-space: nowrap; }
#encore-dashboard .dashboard-change.is-negative { background: #ffedee; color: var(--dashboard-red); }
#encore-dashboard .dashboard-metric-previous { font-size: 12px; line-height: 18px; margin: 6px 0 0; color: var(--dashboard-muted); }
#encore-dashboard .dashboard-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 20px; }
#encore-dashboard .dashboard-panel { --panel-tint: #fff; --panel-accent: #717070; min-width: 0; padding: 16px; border: 1px solid #e5eaf1; cursor: pointer; border-radius: 8px; background: var(--panel-tint); min-height: 0; align-self: start; }
#encore-dashboard .dashboard-panel .dashboard-table thead th { background: var(--panel-accent); }
#encore-dashboard .dashboard-panel .dashboard-table-scroll { background: #fff; border-radius: 5px; }
#encore-dashboard .dashboard-panel.is-collapsed .dashboard-table-scroll { display: none; }
#encore-dashboard .dashboard-panel:not(.is-collapsed) { align-self: stretch; }
#encore-dashboard .dashboard-panel.is-collapsed .dashboard-panel-header { margin-bottom: 0; }
#encore-dashboard .dashboard-panel.is-collapsed .dashboard-panel-header > :not(h2) { display: none !important; }
#encore-dashboard .dashboard-panel .dashboard-panel-toggle:focus { outline: none; box-shadow: none; border: 0; }
#encore-dashboard .dashboard-panel .dashboard-panel-toggle:focus-visible { text-decoration: underline; text-underline-offset: 4px; }
#encore-dashboard .dashboard-panel .dashboard-panel-toggle { display: inline-flex; align-items: center; gap: 7px; border: 0; background: transparent; color: inherit; font: inherit; font-weight: inherit; padding: 0; margin: 0; text-align: left; }
#encore-dashboard .dashboard-panel-toggle span { font-size: 12px; color: var(--panel-accent); }
#encore-dashboard .dashboard-panel-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; flex-wrap: wrap; }
#encore-dashboard h2 { font-family: inherit; color: var(--dashboard-ink); font-size: 16px; line-height: 24px; font-weight: 600; margin: 0; min-width: 0; overflow-wrap: anywhere; }
#encore-dashboard .dashboard-panel-header h2 { display: block; width: auto; }
#encore-dashboard .dashboard-header-total { display: block; font-size: 13px; line-height: 20px; font-weight: 700; color: #525f7f; white-space: nowrap; }
#encore-dashboard .dashboard-panel.is-collapsed .dashboard-panel-header h2 { display: flex; align-items: center; gap: 12px; width: 100%; }
#encore-dashboard .dashboard-panel.is-collapsed .dashboard-header-total { display: inline-block; margin-left: auto; text-align: right; }
#encore-dashboard .dashboard-controls { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; max-width: 100%; }
#encore-dashboard input, #encore-dashboard select, #encore-dashboard button { font-family: inherit; }
#encore-dashboard select, #encore-dashboard .dashboard-date { font-size: 13px; line-height: 20px; color: #525f7f; border: 1px solid var(--dashboard-line); border-radius: 6px; background: #fff; min-height: 34px; max-width: 100%; }
#encore-dashboard select { appearance: none; padding: 5px 32px 5px 8px; background: #fff url('{{ asset('assets/dashboard-figma/e3a8b.svg') }}') right 8px center / 20px 20px no-repeat; width: auto; }
#encore-dashboard .dashboard-date { display: inline-flex; align-items: center; padding: 0 8px; gap: 8px; margin: 0; }
#encore-dashboard .dashboard-date input { border: 0; color: #525f7f; background: transparent; font-size: 13px; width: 132px; max-width: 100%; min-width: 0; }
#encore-dashboard :is(input,select,button,summary,a):focus-visible { outline: 2px solid #717070; outline-offset: 3px; }
#encore-dashboard .dashboard-table-scroll { overflow: auto; max-height: 280px; max-width: 100%; overscroll-behavior: contain; }
#encore-dashboard .table { width: 100%; margin: 0; color: var(--dashboard-ink); }
#encore-dashboard .dashboard-table { table-layout: fixed; min-width: 440px; }
#encore-dashboard .dashboard-table thead { background: #717070; color: #fff; }
#encore-dashboard .dashboard-table thead th { position: sticky; top: 0; z-index: 1; background: #717070; }
#encore-dashboard .dashboard-table th { font-family: inherit; font-size: 12px; line-height: 18px; font-weight: 600; text-transform: none; letter-spacing: 0; padding: 10px 12px; border: 0; white-space: normal; vertical-align: middle; }
#encore-dashboard .dashboard-table td { font-size: 13px; line-height: 20px; font-weight: 400; padding: 10px 12px; border-top: 0; border-bottom: 1px solid var(--dashboard-line); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
#encore-dashboard .dashboard-table th:first-child, #encore-dashboard .dashboard-table td:first-child { width: 34%; }
#encore-dashboard .dashboard-table a { color: inherit; }
#encore-dashboard .dashboard-table a:hover { text-decoration: underline; }
#encore-dashboard .dashboard-positive { color: var(--dashboard-green); }
#encore-dashboard .dashboard-negative { color: var(--dashboard-red); }
#encore-dashboard #activity_dashboard_table { table-layout: fixed; }
#encore-dashboard #activity_dashboard_table td { font-size: 13px; line-height: 20px; padding: 8px 0; vertical-align: middle; overflow-wrap: anywhere; white-space: normal; }
#encore-dashboard #activity_dashboard_table td:first-child:not([colspan]) { width: 32px; }
#encore-dashboard #activity_dashboard_table td:nth-child(2) { width: 42%; padding-right: 12px; }
#encore-dashboard #activity_dashboard_table a { color: var(--dashboard-ink); font-weight: 500; }
#encore-dashboard #activity_dashboard_table .note_p { color: #717070; padding-left: 12px; }
#encore-dashboard .dashboard-payment-dates { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; max-width: 100%; }
#encore-dashboard .dashboard-payment-dates input { font-family: inherit; font-size: 13px; line-height: 20px; font-weight: 400; width: 150px; max-width: 100%; min-width: 0; min-height: 34px; padding: 5px 8px; border: 1px solid var(--dashboard-line); border-radius: 6px; color: #525f7f; background: #fff; }
#encore-dashboard .dashboard-payment-dates > img { display: none; }
#encore-dashboard .dashboard-search { display: flex; align-items: center; gap: 8px; width: 180px; max-width: 100%; margin: 0 0 0 auto; border-bottom: 1px solid var(--dashboard-line); }
#encore-dashboard .dashboard-search input { font-size: 13px; min-width: 0; width: 100%; padding: 6px 0; border: 0; background: transparent; }
#encore-dashboard .dashboard-search input::placeholder { color: var(--dashboard-muted); }
#encore-dashboard .dashboard-payment-table { min-width: 460px; }
#encore-dashboard .dashboard-payment-table th:nth-child(1), #encore-dashboard .dashboard-payment-table td:nth-child(1) { width: 18%; }
#encore-dashboard .dashboard-payment-table th:nth-child(2) { width: 30%; }
#encore-dashboard .dashboard-payment-table th:nth-child(3), #encore-dashboard .dashboard-payment-table th:nth-child(4) { width: 26%; }
#encore-dashboard button { border: 1px solid var(--dashboard-line); border-radius: 4px; background: #fff; color: #717070; padding: 5px 10px; margin: 2px; cursor: pointer; font-size: 13px; }
#encore-dashboard button:disabled { opacity: .4; cursor: default; }
#encore-dashboard .dashboard-pagination { text-align: right; margin-top: 10px; font-size: 12px; }
#encore-dashboard .dashboard-empty { text-align: center; color: #717070; padding: 20px !important; white-space: normal !important; }
#encore-dashboard .dashboard-sample-row { cursor: pointer; }
#encore-dashboard .activity-owner-editor { position: relative; width: 180px; max-width: 100%; }
#encore-dashboard #activity-owner-options { position: absolute; top: calc(100% + 5px); left: 0; width: 100%; max-height: 230px; overflow-y: auto; overscroll-behavior: contain; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 8px 24px rgba(30,50,80,.12); z-index: 30; padding: 5px; color: #68778e; font-size: 13px; }
#encore-dashboard #activity-owner-options button { display: block; width: 100%; min-height: 34px; margin: 0; border: 0; border-radius: 4px; background: transparent; color: #525f7f; text-align: left; padding: 7px 9px; font: inherit; line-height: 20px; white-space: normal; overflow-wrap: anywhere; box-shadow: none; text-transform: none; letter-spacing: normal; }
#encore-dashboard #activity-owner-options button:hover, #encore-dashboard #activity-owner-options button:focus-visible { background: #edf4ff; color: #2868ba; outline-offset: -2px; }
#encore-dashboard #activity-owner-name { width: 180px; max-width: 100%; min-height: 34px; border: 1px solid var(--dashboard-line); border-radius: 6px; background: #fff; padding: 6px 9px; margin: 0; color: #68778e; font: inherit; line-height: 20px; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; box-shadow: none; text-transform: none; letter-spacing: normal; }
#encore-dashboard #activity-owner-name:hover { background: #f5f7fa; color: #32325d; }
#encore-dashboard #activity-owner-edit { display: block; width: 100%; min-height: 34px; border: 1px solid #b7cbed; border-radius: 6px; padding: 6px 9px; font: inherit; line-height: 20px; color: #32325d; background: #fff; outline: none; box-shadow: 0 0 0 2px rgba(40,121,232,.08); }
#encore-dashboard #activity-owner-edit::placeholder { color: #8898aa; }
#encore-dashboard #activity-owner-name:focus { outline: none; }
#encore-dashboard #activity-owner-name:focus-visible { outline: none; border-color: #b7cbed; background: #f5f8fd; box-shadow: 0 0 0 2px rgba(40,121,232,.08); }
#encore-dashboard #activity-owner-edit:focus-visible { outline: none; outline-offset: 0; }
#encore-dashboard [hidden] { display: none !important; }
#encore-dashboard .dashboard-sample-row:hover { background: #f0f6ff; }
#encore-dashboard .dashboard-sample-detail[hidden] { display: none !important; }
#encore-dashboard .dashboard-sample-detail td { background: #f5f7fa; white-space: normal; text-align: left; }
#encore-dashboard .dashboard-sample-detail ul { margin: 4px 0 12px; padding-left: 18px; }
@media (max-width: 1450px) {
    #encore-dashboard .dashboard-metrics { grid-template-columns: repeat(2,minmax(0,1fr)); }
}
@media (max-width: 1250px) {
    #encore-dashboard .dashboard-grid { grid-template-columns: minmax(0,1fr); }
}
@media (max-width: 767px) {
    #encore-dashboard { padding: 14px; padding-bottom: calc(14px + var(--dashboard-footer-space, 60px)); }
    #encore-dashboard .dashboard-panel { padding: 16px; min-height: 0; }
    #encore-dashboard .dashboard-panel-header { align-items: flex-start; }
    #encore-dashboard .dashboard-controls { width: 100%; }
    #encore-dashboard .dashboard-payment-dates { width: 100%; }
    #encore-dashboard .dashboard-payment-dates input { width: 138px; min-height: 40px; }
    #encore-dashboard .dashboard-date input { width: 140px; }
    #encore-dashboard .dashboard-search { margin-left: 0; width: 100%; }
    #encore-dashboard select, #encore-dashboard .dashboard-date { min-height: 40px; }
    #encore-dashboard button { min-width: 40px; min-height: 40px; }
}
@media (max-width: 575px) {
    #encore-dashboard .dashboard-metrics { grid-template-columns: minmax(0,1fr); }
    #encore-dashboard .dashboard-grid { gap: 14px; }
    #encore-dashboard .dashboard-table, #encore-dashboard .dashboard-payment-table { display: block; min-width: 0; }
    #encore-dashboard .dashboard-table thead { position: absolute; width: 1px; height: 1px; padding: 0; overflow: hidden; clip: rect(0,0,0,0); }
    #encore-dashboard .dashboard-table tbody { display: block; }
    #encore-dashboard .dashboard-table tbody tr { display: block; padding: 8px 0; border-bottom: 1px solid var(--dashboard-line); }
    #encore-dashboard .dashboard-table td { display: grid; grid-template-columns: minmax(0,2fr) minmax(0,3fr); gap: 8px; width: 100% !important; padding: 4px 0; border: 0; white-space: normal; overflow-wrap: anywhere; text-align: right; }
    #encore-dashboard .dashboard-table td::before { content: attr(data-label); text-align: left; color: #717070; font-size: 12px; font-weight: 600; }
    #encore-dashboard .dashboard-table td[colspan] { display: block; text-align: center; }
    #encore-dashboard .dashboard-table td[colspan]::before { content: none; }
    #encore-dashboard .dashboard-table-scroll { max-height: 360px; }
}
</style>
<div id="encore-dashboard">
@php
    $metrics = [
        ['sales', 'This Month Sales', $currentMonthOrderCount, $currentMonthTotal, $changeType, $newPercentageChange, $lastYearLastMonthTotal],
        ['cart', 'This Month Quote', $currentMonthQuoteCount, $currentMonthQuote, $changeQuoteType, $newpercentageQuote, $lastYearLastMonthQuote],
        ['production', 'Orders in Production', $currentMonthProductionCount, $currentMonthProduction, null, null, null],
        ['receivable', 'Payment Receivable', $receivableBreakdown['count'], $receivableBreakdown['total'], null, null, null],
    ];
    $breakdowns = ['sales' => $salesBreakdown, 'cart' => $quoteBreakdown, 'production' => $productionBreakdown, 'receivable' => $receivableBreakdown];
    $typeLabels = ['tsr' => 'Team Store', 'bulk' => 'Bulk', 'internal' => 'Internal', 'wl' => 'White Label'];
@endphp
<div class="dashboard-metrics" id="dataContainer">
    @foreach ($metrics as [$icon, $label, $count, $amount, $direction, $change, $previous])
        <article class="dashboard-metric dashboard-metric--{{ $icon }}">
            <div class="dashboard-metric-summary">
                <span class="dashboard-icon-box" aria-hidden="true"><i class="fas {{ ['sales' => 'fa-chart-bar', 'cart' => 'fa-file-alt', 'production' => 'fa-cog', 'receivable' => 'fa-wallet'][$icon] }}"></i></span>
                <span class="dashboard-metric-copy">
                    <span class="dashboard-metric-label d-block">{{ $label }}</span>
                    <span class="dashboard-metric-count">{{ number_format($count) }} {{ $icon === 'cart' ? 'quotes' : 'orders' }}</span>
                    <strong class="dashboard-card-amount">$ {{ number_format($amount, 2) }}</strong>
                </span>
                @if (isset($breakdowns[$icon]))
                    <dl class="dashboard-type-totals" aria-label="{{ $label }} order type totals">
                        @foreach ($breakdowns[$icon]['types'] as $type => $typeTotal)
                            <div><dt>{{ $typeLabels[$type] }}</dt><dd>$ {{ number_format($typeTotal['amount'], 2) }}</dd></div>
                        @endforeach
                    </dl>
                @endif
            </div>
            <div class="dashboard-metric-body">
            @if ($previous !== null)
                <div class="dashboard-metric-footer">
                    @if (in_array($direction, ['in', 'de']))
                        <span class="dashboard-change {{ $direction === 'de' ? 'is-negative' : '' }}">
                            <span aria-hidden="true">{{ $direction === 'de' ? '↓' : '↑' }}</span>
                            {{ rtrim((string) $change, '%') }}%
                        </span>
                    @endif
                    <span>Last year this month: $ {{ number_format($previous, 2) }}</span>
                </div>
            @endif
            </div>
        </article>
    @endforeach
</div>
<div class="dashboard-grid">
    <section class="dashboard-panel is-collapsed dashboard-activities" aria-labelledby="activities-heading">
        <header class="dashboard-panel-header">
            <h2 id="activities-heading">Activities</h2>
            <div class="dashboard-controls">
                <button type="button" id="activity-owner-name" title="Click to change activity user">{{ auth()->user()->name }}</button>
                <div class="activity-owner-editor" id="activity-owner-editor" hidden>
                    <input id="activity-owner-edit" aria-label="Edit activity user" aria-controls="activity-owner-options" autocomplete="off" placeholder="Search users">
                    <div id="activity-owner-options" aria-label="Matching users"></div>
                </div>
                <select id="selected_user_id" aria-label="Activity owner" hidden>
                    @if (!$users->contains('id', auth()->id()))<option value="{{ auth()->id() }}" selected>{{ auth()->user()->name }}</option>@endif
                    @foreach ($users as $user)<option value="{{ $user->id }}" @if ($user->id == auth()->id()) selected @endif>{{ $user->name }}</option>@endforeach
                </select>
                <label class="dashboard-date"><img src="{{ asset('assets/dashboard-figma/1cab2.svg') }}" alt=""><input type="date" id="dashboard-activity-date" aria-label="Activity date" value="{{ now()->format('Y-m-d') }}"></label>
            </div>
        </header>
        <div class="dashboard-table-scroll"><table class="table" id="activity_dashboard_table"><tbody id="activity_table_dashboard"><tr><td colspan="3" class="dashboard-empty">Loading activities…</td></tr></tbody></table></div>
    </section>
    <section class="dashboard-panel is-collapsed" aria-labelledby="leads-heading">
        <header class="dashboard-panel-header"><h2 id="leads-heading">New Leads <span class="dashboard-header-total" id="total-leads" aria-live="polite">Total: —</span></h2>
            <div class="dashboard-controls">
            <select id="dashboard-lead-month" aria-label="New Leads month">
                @for ($month = 1; $month <= 12; $month++)
                    <option value="{{ $month }}" @if ($month == now()->month) selected @endif>{{ \Carbon\Carbon::create(now()->year, $month, 1)->format('F Y') }}</option>
                @endfor
            </select>
            <select id="dashboard-lead-source" aria-label="Lead source"><option value="">All Lead Sources</option>
                @foreach ($dashboardLeadSources as $source)<option value="{{ $source->id }}">{{ $source->lead_source_name }}</option>@endforeach
            </select>
            </div>
        </header>
        <div class="dashboard-table-scroll"><table class="table dashboard-table"><thead><tr><th>Organization</th><th>Sales Person</th><th>Lead Source</th></tr></thead>
            <tbody id="dashboard-leads">
                <tr><td colspan="3" class="dashboard-empty">Loading leads…</td></tr>
            </tbody>
        </table><div class="dashboard-pagination" id="pagination-leads"></div></div>
    </section>
    <section class="dashboard-panel is-collapsed" aria-labelledby="monthly-heading">
        <header class="dashboard-panel-header"><h2 id="monthly-heading">Monthly Sales <span class="dashboard-header-total" id="total-monthly" aria-live="polite">Total: —</span></h2>
            <div class="dashboard-payment-dates"><input type="date" id="start-date-monthly" value="{{ now()->startOfMonth()->format('Y-m-d') }}" aria-label="Monthly Sales start date"><span>→</span><input type="date" id="end-date-monthly" value="{{ now()->endOfMonth()->format('Y-m-d') }}" aria-label="Monthly Sales end date"></div>
        </header>
        <div class="dashboard-table-scroll"><table class="table dashboard-table"><thead><tr><th>Sales Rep</th><th class="text-right">Selected Period ($)</th><th class="text-right">Prior Year Period ($)</th><th class="text-right">Differences</th></tr></thead><tbody id="dashboard-monthly-sales"><tr><td colspan="4" class="dashboard-empty">Loading sales…</td></tr></tbody></table></div>
    </section>
    <section class="dashboard-panel is-collapsed" aria-labelledby="samples-heading">
        <header class="dashboard-panel-header"><h2 id="samples-heading">Samples Sent <span class="dashboard-header-total" id="total-samples" aria-live="polite">Total: —</span></h2>
            <div class="dashboard-payment-dates"><img src="{{ asset('assets/dashboard-figma/1cab2.svg') }}" alt=""><input type="date" id="start-date-samples" value="{{ now()->startOfMonth()->format('Y-m-d') }}" aria-label="Samples Sent start date"><span>→</span><input type="date" id="end-date-samples" value="{{ now()->endOfMonth()->format('Y-m-d') }}" aria-label="Samples Sent end date"></div>
        </header>
        <div class="dashboard-table-scroll"><table class="table dashboard-table"><thead><tr><th>Organization</th><th>Date Sent</th><th>Product Name</th><th class="text-right">Samples</th></tr></thead><tbody id="dashboard-samples"><tr><td colspan="4" class="dashboard-empty">Loading samples…</td></tr></tbody></table><div class="dashboard-pagination" id="pagination-samples"></div></div>
    </section>
    @foreach (['received' => 'Received Payments', 'pending' => 'Pending Payments'] as $paymentKind => $paymentTitle)
        <section class="dashboard-panel is-collapsed dashboard-payments" aria-labelledby="{{ $paymentKind }}-heading">
            <header class="dashboard-panel-header"><h2 id="{{ $paymentKind }}-heading">{{ $paymentTitle }} <span class="dashboard-header-total" id="total-{{ $paymentKind }}" aria-live="polite">Total: —</span></h2>
                <div class="dashboard-payment-dates"><img src="{{ asset('assets/dashboard-figma/1cab2.svg') }}" alt=""><input type="date" id="start-date-{{ $paymentKind }}" value="{{ now()->startOfMonth()->format('Y-m-d') }}" aria-label="{{ $paymentTitle }} start date"><span>→</span><input type="date" id="end-date-{{ $paymentKind }}" value="{{ now()->endOfMonth()->format('Y-m-d') }}" aria-label="{{ $paymentTitle }} end date"></div>
                <label class="dashboard-search"><img src="{{ asset('assets/dashboard-figma/250ac.svg') }}" alt=""><input id="search-{{ $paymentKind }}" type="search" placeholder="Payment search" aria-label="Search {{ strtolower($paymentTitle) }}"></label>
            </header>
            <div class="dashboard-table-scroll"><table class="table dashboard-table dashboard-payment-table"><thead><tr><th>Order ID</th><th>Organization</th><th class="text-right">Order Amount ($)</th><th class="text-right">{{ $paymentKind === 'received' ? 'Received Amount ($)' : 'Pending Amount ($)' }}</th></tr></thead><tbody id="dashboard-{{ $paymentKind }}"><tr><td colspan="4" class="dashboard-empty">Loading payments…</td></tr></tbody></table><div class="dashboard-pagination" id="pagination-{{ $paymentKind }}"></div></div>
        </section>
    @endforeach
</div></div>
{{-- Keep the shared activity editor outside the dashboard styles. --}}
@include('pages.settings.activity.add_new_activity')
<script>
function formatDate(value) { return value ? moment(value).format('DD/MM/YYYY') : ''; }
$(function () {
    $('.date-picker').datepicker({dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, onSelect: function() { $(this).trigger('change'); }});
                $('body').on('click', '.activity-edit', function(e){
                    e.preventDefault();
                    var activity_id = $(this).data('activiy_id');
                    $('#activity_delete_button').show();

                    $.ajax({
                        url:"{{ url('activities/get_organizations') }}",
                        method:'GET',
                        dataType:'json',
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function (data){
                            var organizations = data;

                            var org_options = '<option value="">Select an Organization</option>';
                            for (let i = 0; i < organizations.length; i++) {
                                org_options += '<option value="'+organizations[i].id+'">'+organizations[i].organization_name+'</option>';
                            }
                            $('#activity_organization_id').html(org_options);
                        },
                        complete: function () {
                            $.ajax({
                                url:"{{ url('activities/get_activity_by_id') }}/"+activity_id,
                                method:'GET',
                                dataType:'json',
                                success: function (data){
                                    console.log(data);
                                    var start_date = moment(data.start_date).format('L');
                                    var start_time = moment(data.start_date).format('LT');
                                    var due_date = moment(data.due_date).format('L');

                                    var today_day = moment().format('dddd, MMMM Do');
                                    var today_date = moment().format('L');
                                    $('#selected_day').html(today_day);
                                    $('#selected_date').val(today_date);

                                    var today_date = today_date.replace(/\//g, '-');
                                    getActivitiesByDate(today_date);

                                    $('#activity_note').val('');
                                    $('#activity_order_id').val('').trigger('change');
                                    $('#activity_organization_id').val('').trigger('change');
                                    $('#activity_contact_id').val('').trigger('change');

                                    $('#activity_id').val(activity_id);
                                    $('#activity_subject').val(data.activity_subject);
                                    $('#activity_note').val(data.activity_note);
                                    quill.clipboard.dangerouslyPasteHTML(data.activity_note || '');
                                    $('#activity_priority').val(data.priority).trigger('change');
                                    $('#start_date').val(start_date);
                                    if(moment(data.start_date).format('HH:mm:ss') !== '00:00:00'){
                                        $('#start_time').val(start_time);
                                    }else{
                                        $('#start_time').val('');
                                    }
                                    $('#due_date').val(due_date);
                                    $('#activity_user_id').val(data.assigned_to).trigger('change');

                                    $('#activity_organization_id').val(data.organization_id).trigger('change');
                                    activity_order_id = data.order_id;
                                    activity_contact_id = data.contact_id;

                                    $('#submit_btn_text').html('Update');
                                    $('#new_activity_form_title').html('Edit Activity');
                                    $('#is_done_div').removeAttr('hidden');
                                    $('#add_activity_form').attr('action', '{{ route("activities.update") }}');


                                    var assignedUserName = '';
                                    var modifiedUserName = '';


                                    var all_users = @json($users);
                                    var auth_user = @json(auth()->user()->id);

                                    if(data.created_by !== null){
                                        var assignedUser = all_users.find(user => user.id == data.created_by);
                                    }else{
                                        var assignedUser = all_users.find(user => user.id == data.assigned_to);
                                    }
                                    if(assignedUser){
                                        if(assignedUser.id == auth_user){
                                            assignedUserName = assignedUser.name + ' (You)'
                                        }else{
                                            assignedUserName = assignedUser.name
                                        }
                                    }else{
                                        assignedUserName = '';
                                    }
                                    if(data.modified_by !== null){
                                        var modifiedUser = all_users.find(user => user.id == data.modified_by);
                                        if(modifiedUser){
                                            if(modifiedUser.id == auth_user){
                                                modifiedUserName = modifiedUser.name + ' (You)'
                                            }else{
                                                modifiedUserName = modifiedUser.name
                                            }
                                        }else{
                                            modifiedUserName = '';
                                        }
                                    }

                                    $('#created_at_tr').html(`<td style="color: grey;padding-top: .5rem;">Created : ${formatDate(data.created_at)}  ${assignedUserName} </td>`);
                                    $('#modified_at_tr').html(`<td style="color: grey;">Last Modified : ${formatDate(data.updated_at)}  ${modifiedUserName} </td>`);


                                },
                                complete: function () {
                                    // $('#activity_popup').show(700);
                                    $('#activity_modal_new').modal('show');
                                    $(".se-pre-con").fadeOut('slow');
                                }
                            });

                        }
                    });


                });


});
</script>
<script>
(function () {
    const endpoint = @json(route('dashboard.overview-data'));
    const orderUrl = @json(url('order_details/edit'));
    const organizationUrl = @json(url('organizations/info'));
    const requests = {}, pages = {};
    const money = value => Number(value || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    const bodyFor = panel => document.getElementById(panel === 'monthly' ? 'dashboard-monthly-sales' : 'dashboard-' + panel);
    const columns = panel => panel === 'leads' ? 3 : 4;
    function message(body, count, text, retry) {
        body.replaceChildren();
        const row = body.insertRow(), cell = row.insertCell();
        cell.colSpan = count; cell.className = 'dashboard-empty'; cell.textContent = text;
        if (retry) { const button = document.createElement('button'); button.type = 'button'; button.textContent = 'Retry'; button.onclick = retry; cell.appendChild(button); }
    }
    function cell(row, text, numeric = false) {
        const td = row.insertCell(); td.textContent = text ?? '—'; td.title = td.textContent;
        const heading = row.closest('table').querySelectorAll('thead th')[row.cells.length - 1];
        if (heading) td.dataset.label = heading.textContent.trim();
        if (numeric) td.classList.add('text-right');
        return td;
    }
    function paginate(panel, response) {
        const target = document.getElementById('pagination-' + panel);
        if (!target) return;
        target.replaceChildren();
        if (response.pages <= 1) return;
        [['‹', -1, response.page <= 1], ['›', 1, response.page >= response.pages]].forEach(([label, step, disabled], index) => {
            if (index === 1) { const count = document.createElement('span'); count.textContent = ` ${response.page} / ${response.pages} `; target.appendChild(count); }
            const button = document.createElement('button'); button.type = 'button'; button.textContent = label; button.disabled = disabled;
            button.setAttribute('aria-label', `${step < 0 ? 'Previous' : 'Next'} ${panel} page`);
            button.onclick = () => load(panel, response.page + step); target.appendChild(button);
        });
    }
    function load(panel, page = 1) {
        if (requests[panel]) requests[panel].abort();
        pages[panel] = page;
        const body = bodyFor(panel), data = {panel, page};
        if (panel === 'leads') {
            data.source = document.getElementById('dashboard-lead-source').value;
            data.month = document.getElementById('dashboard-lead-month').value;
        }
        if (['received', 'pending', 'samples', 'monthly'].includes(panel)) {
            if (['received', 'pending'].includes(panel)) data.search = document.getElementById('search-' + panel).value;
            data.start = document.getElementById('start-date-' + panel).value;
            data.end = document.getElementById('end-date-' + panel).value;
        }
        const totalLabel = document.getElementById('total-' + panel);
        if (totalLabel) totalLabel.textContent = 'Total: …';
        message(body, columns(panel), 'Loading…');
        body.setAttribute('aria-busy', 'true');
        requests[panel] = $.ajax({url: endpoint, data, dataType: 'json',
            success: response => {
                if (totalLabel) totalLabel.textContent = ['leads', 'samples'].includes(panel)
                    ? `Total: ${Number(response.total || 0).toLocaleString('en-US')}`
                    : `Total: $ ${money(response.total)}`;
                body.replaceChildren();
                response.data.forEach(item => {
                    const row = body.insertRow();
                    if (panel === 'leads') [item.organization, item.owner, item.source].forEach(value => cell(row, value));
                    else if (panel === 'samples') {
                        const organizationCell = cell(row, '');
                        const toggle = document.createElement('span'); row.tabIndex = 0;
                        toggle.textContent = '▸ ' + item.organization;
                        row.setAttribute('aria-expanded', 'false');
                        row.setAttribute('aria-controls', 'sample-detail-' + item.id);
                        organizationCell.appendChild(toggle);
                        [item.date, item.products].forEach(value => cell(row, value)); cell(row, item.count, true);
                        row.classList.add('dashboard-sample-row');
                        const detail = body.insertRow(); detail.id = 'sample-detail-' + item.id;
                        detail.className = 'dashboard-sample-detail'; detail.hidden = true;
                        const content = detail.insertCell(); content.colSpan = 4;
                        const list = (title, entries, empty) => {
                            const heading = document.createElement('strong'); heading.textContent = title; content.appendChild(heading);
                            const ul = document.createElement('ul');
                            (entries.length ? entries : [empty]).forEach(text => { const li = document.createElement('li'); li.textContent = text; ul.appendChild(li); });
                            content.appendChild(ul);
                        };
                        list('Products and sizes', item.items.map(product => `${product.product} — Size: ${product.size}`), 'No product samples');
                        list('Fabric swatches', item.swatches, 'No fabric swatches');
                        row.onkeydown = event => { if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); row.click(); } };
                        row.onclick = () => {
                            detail.hidden = !detail.hidden;
                            row.setAttribute('aria-expanded', String(!detail.hidden));
                            toggle.textContent = (detail.hidden ? '▸ ' : '▾ ') + item.organization;
                        };
                    }
                    else if (panel === 'monthly') {
                        cell(row, item.name); cell(row, money(item.current), true); cell(row, money(item.previous), true);
                        cell(row, money(item.difference), true).classList.add(item.difference >= 0 ? 'dashboard-positive' : 'dashboard-negative');
                    } else {
                        const link = document.createElement('a'); link.href = `${orderUrl}/${item.id}/order?active_tab=order`; link.textContent = item.order_no;
                        link.target = '_blank'; link.rel = 'noopener noreferrer';
                        cell(row, '').appendChild(link);
                        const organizationCell = cell(row, '');
                        if (item.organization_id) {
                            const organizationLink = document.createElement('a');
                            organizationLink.href = `${organizationUrl}/${item.organization_id}`;
                            organizationLink.textContent = item.organization_name;
                            organizationLink.target = '_blank'; organizationLink.rel = 'noopener noreferrer';
                            organizationCell.appendChild(organizationLink);
                        } else organizationCell.textContent = item.organization_name || '—';
                        [item.order_total, panel === 'received' ? item.received_amount : item.pending_amount].forEach(value => cell(row, money(value), true));
                    }
                });
                if (!response.data.length) message(body, columns(panel), 'No records match these filters.');
                paginate(panel, response);
            },
            error: (xhr, status) => { if (status !== 'abort') { if (totalLabel) totalLabel.textContent = 'Total: —'; message(body, columns(panel), 'Unable to load data. ', () => load(panel, page)); } },
            complete: () => body.setAttribute('aria-busy', 'false')
        });
    }
    document.getElementById('dashboard-lead-source').addEventListener('change', () => load('leads'));
    document.getElementById('dashboard-lead-month').addEventListener('change', () => load('leads'));
    ['received', 'pending', 'samples', 'monthly'].forEach(panel => {
        let timer;
        if (['received', 'pending'].includes(panel)) document.getElementById('search-' + panel).addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(() => load(panel), 250); });
        ['start-date-', 'end-date-'].forEach(prefix => document.getElementById(prefix + panel).addEventListener('change', () => load(panel)));
    });
    let activityRequest;
    window.fetchDataFromController = function () {
        if (activityRequest) activityRequest.abort();
        const body = document.getElementById('activity_table_dashboard');
        message(body, 3, 'Loading activities…');
        activityRequest = $.ajax({url: @json(route('filterActivities')), data: {
            userId: document.getElementById('selected_user_id').value, date: document.getElementById('dashboard-activity-date').value
        }, success: response => {
            body.replaceChildren();
            response.activity.forEach(activity => {
                const row = body.insertRow();
                const icon = document.createElement('img'); icon.src = @json(asset('assets/dashboard-figma/2499b.svg')); icon.alt = 'Edit activity';
                const eye = document.createElement('a'); eye.href = '#'; eye.className = 'activity-edit'; eye.dataset.activiy_id = activity.id; eye.appendChild(icon); cell(row, '').appendChild(eye);
                const title = eye.cloneNode(false); title.textContent = activity.activity_subject; cell(row, '').appendChild(title);
                const note = new DOMParser().parseFromString(activity.activity_note || '', 'text/html').body.textContent;
                cell(row, note).className = 'note_p';
            });
            if (!response.activity.length) message(body, 3, 'No activities for this date.');
        }, error: (xhr, status) => { if (status !== 'abort') message(body, 3, 'Unable to load activities. ', window.fetchDataFromController); }});
    };
    document.getElementById('dashboard-activity-date').addEventListener('change', window.fetchDataFromController);
    $(function () {
        document.querySelectorAll('#encore-dashboard .dashboard-panel').forEach((panel, index) => {
            const heading = panel.querySelector('h2');
            const content = panel.querySelector('.dashboard-table-scroll');
            if (!heading || !content) return;
            content.id = content.id || 'dashboard-panel-content-' + index;
            const title = heading.firstChild;
            const button = document.createElement('button');
            button.type = 'button'; button.className = 'dashboard-panel-toggle';
            const arrow = document.createElement('span'); arrow.textContent = '▸'; arrow.setAttribute('aria-hidden', 'true');
            button.appendChild(arrow); button.appendChild(document.createTextNode(title.textContent.trim()));
            button.setAttribute('aria-expanded', 'false'); button.setAttribute('aria-controls', content.id);
            heading.replaceChild(button, title);
            panel.addEventListener('click', event => {
                if (!event.target.closest('.dashboard-panel-toggle') &&
                    event.target.closest('a, button, input, select, textarea, label, .activity-owner-editor, .dashboard-sample-row, .dashboard-sample-detail, .select2-container')) return;
                const collapsed = panel.classList.toggle('is-collapsed');
                button.setAttribute('aria-expanded', String(!collapsed)); arrow.textContent = collapsed ? '▸' : '▾';
            });
        });
        const ownerSelect = document.getElementById('selected_user_id');
        const ownerName = document.getElementById('activity-owner-name');
        const ownerEdit = document.getElementById('activity-owner-edit');
        const ownerEditor = document.getElementById('activity-owner-editor');
        const ownerOptions = document.getElementById('activity-owner-options');
        const renderOwners = () => {
            const search = ownerEdit.value.trim().toLowerCase();
            ownerOptions.replaceChildren();
            Array.from(ownerSelect.options).filter(option => option.text.toLowerCase().includes(search)).forEach(option => {
                const button = document.createElement('button');
                button.type = 'button'; button.textContent = option.text;
                button.addEventListener('mousedown', event => event.preventDefault());
                button.addEventListener('click', () => {
                    ownerSelect.value = option.value;
                    finishOwnerEdit(false);
                    window.fetchDataFromController();
                    ownerName.focus();
                });
                ownerOptions.appendChild(button);
            });
            if (!ownerOptions.childElementCount) ownerOptions.textContent = 'No users found';
        };
        const finishOwnerEdit = save => {
            const match = save && Array.from(ownerSelect.options).find(option => option.text.trim().toLowerCase() === ownerEdit.value.trim().toLowerCase());
            const changed = match && ownerSelect.value !== match.value;
            if (match) ownerSelect.value = match.value;
            ownerName.textContent = ownerSelect.selectedOptions[0].text;
            ownerEditor.hidden = true; ownerName.hidden = false;
            if (changed) window.fetchDataFromController();
        };
        ownerName.addEventListener('click', () => {
            ownerEdit.value = '';
            ownerName.hidden = true; ownerEditor.hidden = false; renderOwners();
            ownerEdit.focus(); ownerEdit.select();
        });
        ownerEdit.addEventListener('input', renderOwners);
        ownerEditor.addEventListener('focusout', event => { if (!ownerEditor.contains(event.relatedTarget)) finishOwnerEdit(true); });
        ownerEdit.addEventListener('keydown', event => {
            if (event.key === 'Enter' || event.key === 'Escape') {
                event.preventDefault(); finishOwnerEdit(event.key === 'Enter'); ownerName.focus();
            }
        });
        const dashboard = document.getElementById('encore-dashboard');
        const footer = document.querySelector('footer.footer');
        if (footer) {
            const reserveFooterSpace = () => {
                const style = getComputedStyle(footer);
                const height = style.position === 'fixed'
                    ? footer.getBoundingClientRect().height + Math.max(0, parseFloat(style.bottom) || 0)
                    : 0;
                dashboard.style.setProperty('--dashboard-footer-space', `${Math.ceil(height)}px`);
            };
            reserveFooterSpace();
            new ResizeObserver(reserveFooterSpace).observe(footer);
            window.addEventListener('resize', reserveFooterSpace);
        }
        ['leads', 'samples', 'monthly', 'received', 'pending'].forEach(panel => load(panel));
        window.fetchDataFromController();
        const heading = document.getElementById('header'); if (heading) heading.textContent = 'Dashboard';
    });
})();
</script>
@endsection
