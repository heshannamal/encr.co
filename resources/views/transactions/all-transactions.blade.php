@extends('layouts.app', ['activePage' => 'allTransactions', 'titlePage' => __('Payments')])

@section('content')
<style>
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 33%;
    }
    .form-input,
    .select2.select2-container {
        width: 100% !important;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    div.alphabet {
        display: table;
        width: 100%;
        margin-bottom: 1em;
    }
    div.alphabet span {
        display: table-cell;
        color: #b3b3b3;
        cursor: pointer;
        text-align: center;
        width: 3.5%;
        border: 1px solid #e8e8e8;
    }
    div.alphabet span:hover {
        box-shadow: 2px 2px 5px #e8e8e8;
    }
    div.alphabet span.active {
        color: black;
    }
    .user_dp {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    .check-image {
        width: 50%;
        height: 200px;
        padding: 5px;
        overflow: hidden;
    }
    .check-image img {
        width: 70%;
        transition: all 1s;
    }
    .check-image img:hover  {
        opacity: 0.5;
    }
    .venmo-image {
        width: auto;
        height: 200px;
        padding: 5px;
        overflow: hidden;
    }
    .venmo-image img {
        width: auto;
        height: 200px;
        transition: all 1s;
    }
    .venmo-image img:hover  {
        opacity: 0.5;
    }
    .export-btn {
        padding: 0.2rem;
        background-color: #787878;
        color: white;
        width: 85px;
        position: relative;
        right: -73px;
    }
    .btn-position {
        position: relative;
        top: -12px;
    }
    .add-btn-text {
        position: relative;
        right: -13px;
    }
    .btns-text {
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }
    .btns-text:hover {
        color: #909090 ;
    }
    .btns-style {
        width: 100%;
        height: 100%;
        background-color: #909090;
        border: unset;
        border-radius: 5px;
    }
    .btns-card:hover {
        background-color: #ffffff
    }
    .btns-padding {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btns-right-position {
        position: relative;
        right: 14px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    .content-position {
        position: relative;
        top: -45px;
    }
    .new-style-table table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .new-style-table table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .new-style-table table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
        border-top: 1px solid #e9ecef !important;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
        vertical-align: middle !important;
    }
    .new-style-table .dataTables_info {
        color:#b3b3b3;
    }
    .card{
        background-color: white;
        border: none;
        border-radius: 0rem;
    }
    .styled-button{
        outline: unset;
        color: #d3d3d3;
        background-color: #fafafa;;
        border: 1px solid #d3d3d3;
        padding: .3rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
    }
    .page-item .page-link, .page-item span {
        border-radius: 0 !important;
        font-size: 0.7rem;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: grey;
        border-color: #cccccc;
        background-color: #e9e9e9;
        box-shadow:none;
    }
    .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .btn-inside-table button{
        width: 100% !important;
        padding: 5% 3% !important;
        font-size: .7rem !important;
        height: 2.1rem;
        font-size: .7rem !important;
    }
    body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
    .new-style-table table thead tr {
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }
    .color_div {
        width: 12px;
        height: 7px;
        margin-top: 5px;
        margin-right: 10px;
        border-radius: 3px;
    }
    .filter_div {
        margin-top: 15px;
        margin-bottom: 15px;
        border-radius: 2px;
        border: unset;
        padding: 10px;
    }
    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid#DEDEDE;
        border-radius: 16px;
        padding-top: 2px;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: #B3B3B3;
        font-weight: 500;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .date_p:hover {
        color: #B3B3B3 !important;
    }
    .row_padding {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    .filter_btn {
        padding: 4px;
        text-align: center;
        width: 5rem;
        padding-right: 6px;
        background-color: rgb(0, 254, 0);
        border-radius: 5px;
        cursor: pointer;
        color: white !important;
        margin: 0rem .5rem;
    }
    .content-position {
        padding-left: 15px !important;
        padding-right: 15px !important;
        color: white;
    }
    .top_button {
        font-size: 12px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .print_btn {
        padding-right: 1%;
        padding-left: 1%;
    }
    .order_list_topic {
        color: black;
        font-size: 19px;
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="row" style="padding-left: 1rem;padding-right: 1rem;">
                <div class="col-md-12">
                    <div class="card filter_div">
                        <div class="row" style="padding-left: 25px;">
                            <div style="margin-right: 20px;">
                                <div class="row filter_row">
                                    <p class="font_color date_p">Date Range | </p>

                                    <input class="date_selection"
                                        type="date"
                                        id="start-date"
                                        name="start-date"
                                        value="{{ request('start_date') ?? '' }}">

                                    <p class="font_color date_p">&nbsp; &nbsp; &nbsp;</p>

                                    <input class="date_selection"
                                        type="date"
                                        id="end-date"
                                        name="end-date"
                                        value="{{ request('end_date') ?? '' }}">
                                </div>
                            </div>

                            <div style="margin-right: 20px;">
                                <div class="row filter_row" style="padding-bottom: 2px;">
                                    <p class="font_color date_p">Payment Type |</p>
                                    <div class="paymen_type_div date_selection">
                                        <select id="paymentType" class="date_selection" name="payment_type">
                                            <option value="all"     {{ request('payment_type') == 'all' ? 'selected' : '' }}>All</option>
                                            <option value="Card"    {{ request('payment_type') == 'Card' ? 'selected' : '' }}>Card</option>
                                            <option value="Check"   {{ request('payment_type') == 'Check' ? 'selected' : '' }}>Check</option>
                                            <option value="Venmo"   {{ request('payment_type') == 'Venmo' ? 'selected' : '' }}>Venmo</option>
                                            <option value="Paypal"  {{ request('payment_type') == 'Paypal' ? 'selected' : '' }}>Paypal</option>
                                            <option value="Other"   {{ request('payment_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div style="margin-right: 20px;">
                                <div class="row filter_row" style="padding-bottom: 2px;">
                                    <p class="font_color date_p">Payment Status |</p>
                                    <div class="paymen_type_div date_selection">
                                        <select id="paymentStatus" class="date_selection" name="payment_status">
                                            <option value="all"     {{ request('payment_status') == 'all' ? 'selected' : '' }}>All</option>
                                            <option value="2"    {{ request('payment_status') == '2' ? 'selected' : '' }}>Paid</option>
                                            <option value="1" {{ request('payment_status') == '1' ? 'selected' : '' }}>Partial</option>
                                            <option value="3" {{ request('payment_status') == '3' ? 'selected' : '' }}>Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-right: 20px;">
                                <div class="row filter_row" style="padding-bottom: 2px;">
                                    <p class="font_color date_p">Order Type |</p>
                                    <div class="paymen_type_div date_selection">
                                        <select id="order_type" class="date_selection" name="order_type">
                                            <option value="all" {{ request('order_type') == 'ALL' ? 'selected' : '' }}>All</option>
                                            <option value="WL" {{ request('order_type') == 'WL' ? 'selected' : '' }}>WL Orders</option>
                                            <option value="TSR" {{ request('order_type') == 'TSR' ? 'selected' : '' }}>TSR Orders</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div style="margin-right: 20px; padding-top: 2px;">

                            </div>

                            <div style="margin-left: 20px;">
                                <div class="row" style="padding-bottom: 2px;">
                                    <a href="#" class="date_p filter_btn" id="pin-filter" title="Filter">
                                        <i class="fa fa-filter" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                                        Filter
                                    </a>
                                </div>
                            </div>
                            <div style="margin-left: 20px;">
                                <div class="row" style="padding-bottom: 2px;">
                                    <a href="#" class="date_p filter_btn" id="reset-filter" title="Filter" style="background-color:#b3b3b3">
                                        <i class="fa fa-times" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                                        Clear
                                    </a>
                                </div>
                            </div>
                            @can('create people')
                                <button class="styled-button ml-auto" style="outline: unset;" href="#" onclick="exportReport()" title="Export CSV">
                                    CSV Export
                                </button>
                            @endcan
                        </div>
                        <div class="row" style="padding-left: 25px; padding-top: 10px;">
                            <button class="import-to-quickbooks styled-button" style="outline: unset; background-color: #47D6B6; color: white;display:none" href="#" title="Import to Quickbooks">
                                Import to Quickbooks <i class="fa fa-upload" style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 new-style-table">
                    <div class="table-responsive">

                        <table class="table align-items-center" id="transactions_table">
                            <thead class="header-style">
                            <tr>
                                <th style="text-align: center;" scope="col"></th>
                                <th style="text-align: center;" class="payment-id" scope="col">Transaction id</th>
                                <th style="text-align: center;" class="order-no" scope="col">Order #</th>
                                <th style="text-align: center;" class="payment-type" scope="col">Payment Type</th>
                                <th style="text-align: center;" class="team-name" scope="col">Team Name</th>
                                <th style="text-align: center;" class="name-on-card" scope="col">Name on Card</th>
                                <th style="text-align: center;" class="customer-name" scope="col">Customer Name</th>
                                <th style="text-align: center;" class="check-status" scope="col">check Status</th>
                                <th style="text-align: center;" class="amount" scope="col">Amount</th>
                                <th style="text-align: center;" class="order-status" scope="col">Order Payment Status</th>
                                <th style="text-align: center;" class="transaction-id" scope="col">Transaction ID</th>
                                <th style="text-align: center;" class="payment-date" scope="col">Payment Date</th>
                                <th style="text-align: center;" class="payment-type" scope="col">Time</th>
                                <th style="text-align: center;" class="payment-refund" scope="col">Refund</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach ($TrasnsactionsArray as $key => $Trasnsaction)
                                @php
                                    $qbStatus = $Trasnsaction['QBStatus'] ?? null;

                                    /*
                                     * QBStatus = synced can now belong to:
                                     * 1. a normal/direct payment, or
                                     * 2. an auto-generated StorePayment parent when
                                     *    every eligible collapsed child is synced.
                                     */
                                    $isQuickBooksSynced =
                                        $qbStatus === 'synced';
                                @endphp

                                <tr data-payment-log-id="{{ $Trasnsaction['ID'] }}"
                                    data-auto-generated="{{ $Trasnsaction['auto_generated'] ? 1 : 0 }}">
                                    <td style="text-align: center;">
                                        <div style="display:flex;align-items:center;justify-content:center;gap:8px;white-space:nowrap;">
                                            {{-- QuickBooks state appears before the checkbox.
                                                 Keep this in the FIRST column; your current
                                                 Transaction/Order/etc. column order is unchanged. --}}
                                            @if($Trasnsaction['auto_generated'])

                                                {{-- Empty span is intentional. AJAX updates it
                                                     when the collapsed children are loaded. --}}
                                                <span
                                                    class="parent-qb-status-icon"
                                                    data-parent-qb-status="{{ $Trasnsaction['ID'] }}"
                                                >
                                                    @if($qbStatus === 'synced')
                                                        <i
                                                            class="fa fa-check-circle"
                                                            title="All StoreOrder payments synced to QuickBooks"
                                                            aria-label="All StoreOrder payments synced to QuickBooks"
                                                            style="color:#28a745;font-size:17px;"
                                                        ></i>
                                                    @endif
                                                </span>

                                            @else

                                                @if($qbStatus === 'synced')
                                                    <i
                                                        class="fa fa-check-circle"
                                                        title="Synced to QuickBooks"
                                                        aria-label="Synced to QuickBooks"
                                                        style="color:#28a745;font-size:17px;"
                                                    ></i>
                                                @elseif($qbStatus === 'saved')
                                                    <i
                                                        class="fa fa-save"
                                                        title="Saved for QuickBooks"
                                                        aria-label="Saved for QuickBooks"
                                                        style="color:#6c757d;font-size:15px;"
                                                    ></i>
                                                @elseif($qbStatus === 'failed')
                                                    <i
                                                        class="fa fa-exclamation-circle"
                                                        title="QuickBooks sync failed"
                                                        aria-label="QuickBooks sync failed"
                                                        style="color:#dc3545;font-size:17px;"
                                                    ></i>
                                                @endif

                                            @endif

                                            <input
                                                type="checkbox"
                                                class="transaction-checkbox"
                                                data-value="{{ $Trasnsaction['ID'] }}"
                                                data-type="{{ $Trasnsaction['PaymentType'] }}"
                                                data-auto-generated="{{ $Trasnsaction['auto_generated'] ? 1 : 0 }}"
                                                {{ $isQuickBooksSynced ? 'disabled' : '' }}
                                                title="{{ $isQuickBooksSynced
                                                    ? ($Trasnsaction['auto_generated']
                                                        ? 'All StoreOrder payments are already synced to QuickBooks'
                                                        : 'Already synced to QuickBooks')
                                                    : 'Select for QuickBooks import'
                                                }}"
                                            />
                                        </div>
                                    </td>
                                    <td style="text-align-last: left;" class="payment-id">
                                        @if($Trasnsaction['auto_generated'] == true)
                                            <i class="fa fa-chevron-right show_store_payments" data-payment-log-id="{{ $Trasnsaction['ID'] }}" style="font-size: 10px;color: black;margin-right: 5px;cursor:pointer"></i>
                                            <a
                                                style="rgba(22, 22, 23, 1) !important"
                                                data-orderNo="{{ $Trasnsaction['Order'] }}"
                                                @isset($Trasnsaction['checkFImage']) data-checkFImage="{{ $Trasnsaction['checkFImage'] }}" @endisset
                                                @isset($Trasnsaction['checkBImage']) data-checkBImage="{{ $Trasnsaction['checkBImage'] }}" @endisset
                                                href="javascript:void(0)"
                                                class="edit payID"
                                                data-value="{{$Trasnsaction['TransactionID']}}">
                                                {{ $Trasnsaction['TransactionID'] }}
                                            </a>

                                        @else
                                            <a
                                                style="rgba(22, 22, 23, 1) !important"
                                                data-orderNo="{{ $Trasnsaction['Order'] }}"
                                                @isset($Trasnsaction['checkFImage']) data-checkFImage="{{ $Trasnsaction['checkFImage'] }}" @endisset
                                                @isset($Trasnsaction['checkBImage']) data-checkBImage="{{ $Trasnsaction['checkBImage'] }}" @endisset
                                                href="javascript:void(0)"
                                                class="edit payID"
                                                data-value="{{$Trasnsaction['TransactionID']}}">
                                                {{ $Trasnsaction['TransactionID'] }}
                                            </a>
                                        @endif
                                    </td>
                                    <td style="text-align-last: left;" class="order-no">
                                        <a href="#" class="edit-order" data-value="{{$Trasnsaction['Order']}}">{{ str_pad($Trasnsaction['Order'], 6, '0', STR_PAD_LEFT) }}</a>
                                    </td>
                                    <td style="text-align-last: left;" class="payment-type">{{ $Trasnsaction['PaymentType'] }}</td>
                                    <td style="text-align-last: left;" class="team-name">{{ $Trasnsaction['TeamName'] }}</td>
                                    <td style="text-align-last: left;" class="name-on-card">{{ $Trasnsaction['NameonCard'] }}</td>
                                    <td style="text-align-last: left;" class="customer-name">
                                        {{ $Trasnsaction['CustomerName'] ?? '' }}
                                    </td>
                                    <td style="text-align-last: center;" class="check-status">
                                        @if($Trasnsaction['checkStatus'] == 'Not Approved' )
                                            <span class="badge badge-pill" style="color:#d381ff;background-color:#f9dfff;width:100%">Not Approved</span>
                                        @elseif($Trasnsaction['checkStatus'] == 'Pending Approval')
                                            <span class="badge badge-pill" style="color:#717070;background-color:#f8f8f8;width:100%">Pending Approval</span>

                                        @elseif($Trasnsaction['checkStatus'] == 'Approved')
                                            <span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Approved</span>
                                        @elseif($Trasnsaction['checkStatus'] == 'Rejected')
                                            <span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Rejected</span>
                                        @else
                                            <span class="badge badge-pill" style="color:#FFB916;background-color:#ffffcc;width:100%">Payed</span>
                                        @endif
                                    </td>
                                    <td style="text-align-last: right;" class="amount">$ {{ number_format($Trasnsaction['Amount'], 2) }}</td>
                                    <td style="text-align-last: center;" class="order-status">
                                        @if($Trasnsaction['OrderStatus'] == 2)
                                            <span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:100%">Paid</span>
                                        @elseif($Trasnsaction['OrderStatus'] == 1)
                                            <span class="badge badge-pill" style="color:#d65a47;background-color:#ffcccc;width:100%">Partial</span>
                                        @else
                                            <span class="badge badge-pill" style="color:#FFB916;background-color:#ffffcc;width:100%">Pending</span>
                                        @endif
                                    </td>
                                    <td style="text-align-last: center;" class="transaction-id">{{ $Trasnsaction['TransactionID'] }}</td>
                                    <td style="text-align-last: center;" class="payment-date">{{ $Trasnsaction['PaymentDate']->format('m/d/Y') }}</td>
                                    <td style="text-align-last: center;" class="payment-type">{{ $Trasnsaction['PaymentDate']->format('H:i:s') }}</td>

                                    <td style="text-align: center;" class="payment-refund">
                                        @if(
                                            strcasecmp((string) ($Trasnsaction['PaymentType'] ?? ''), 'Card') === 0
                                            && empty($Trasnsaction['auto_generated'])
                                        )
                                            <button type="button"
                                                    class="btn btn-sm btn-success payment-refund-open"
                                                    data-payment-log-id="{{ $Trasnsaction['ID'] }}"
                                                    data-order-id="{{ $Trasnsaction['Order'] }}"
                                                    data-gateway-transaction-id="{{ $Trasnsaction['TransactionID'] }}"
                                                    title="Refund card payment">
                                                <i class="fa fa-undo"></i>
                                            </button>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
{{-- Notification Modal --}}
<div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" style="background-color: white;border-radius:0rem">
            <div class="modal-header">
                <h6 class="modal-title" id="modal_title_notification" style="color: black;font-size: 13px;">2</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: black;">×</span>
                </button>
                <input type="hidden" id="refresh_required" value="0" />
            </div>

            <div class="modal-body">
                <div class="py-3 text-center new-style-table">
                    <div class="col-md-12 table-responsive">
                        <div class="row" id="check_payment">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer" id="modal-footer">

            </div>
        </div>
    </div>
</div>

<div id="receiptModal" class="modal" tabindex="-1" role="dialog" style="display:none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
        <div class="modal-header" style="padding-bottom: 0px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:none; background:none;">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="receiptModalBody" style="padding: 20px; max-height: 80vh; overflow-y: auto;">
        </div>
        </div>
    </div>
</div>
<div id="redundModal" class="modal" tabindex="-1" role="dialog" style="display:none;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
        <div class="modal-header" style="padding-bottom: 0px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:none; background:none;">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="redundModalBody" style="padding: 20px; max-height: 80vh; overflow-y: auto;">
        </div>
        </div>
    </div>
</div>


{{-- Card Refund Modal --}}
<div class="modal fade" id="cardRefundModal" tabindex="-1" role="dialog" aria-labelledby="cardRefundModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius:10px;overflow:hidden;">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="cardRefundModalLabel" style="margin-bottom:3px;">
                        Card Payment Refund
                    </h5>
                    <div id="cardRefundModalSubtitle" style="font-size:12px;color:#8898aa;"></div>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="cardRefundContent" class="p-3" style="display:none;">
                    <div class="row mb-3">
                        <div class="col-md-4 mb-2">
                            <div style="font-size:11px;color:#8898aa;text-transform:uppercase;font-weight:700;">
                                Transaction ID
                            </div>
                            <div id="refundGatewayTransaction" style="font-size:13px;font-weight:600;color:#32325d;"></div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div style="font-size:11px;color:#8898aa;text-transform:uppercase;font-weight:700;">
                                Total Amount
                            </div>
                            <div id="refundOriginalGross" style="font-size:13px;font-weight:600;color:#32325d;"></div>
                        </div>

                        <div class="col-md-4 mb-2">
                            <div style="font-size:11px;color:#8898aa;text-transform:uppercase;font-weight:700;">
                                Refundable Amount
                            </div>
                            <div id="refundRemainingBase" style="font-size:13px;font-weight:700;color:#2dce89;"></div>
                        </div>
                    </div>

                    <div class="card mb-3" style="box-shadow:none;border:1px solid #e9ecef;">
                        <div class="card-body" style="padding:16px;">
                            <form id="cardRefundForm">
                                @csrf

                                <input type="hidden" id="refundPaymentLogId" name="payment_log_id">
                                <input type="hidden" id="refundOrderId" name="order_id">
                                <input type="hidden" name="transaction_method" value="Card">

                                <div class="form-group mb-2">
                                    <label for="refundAmount" style="font-size:12px;font-weight:600;">
                                        Refund Amount ($)
                                    </label>

                                    <input type="number"
                                           class="form-control"
                                           id="refundAmount"
                                           name="amount"
                                           min="0.01"
                                           step="0.01"
                                           required>
                                </div>

                                <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
                                    <div style="font-size:12px;color:#525f7f;">
                                        Total Cost:
                                        <strong id="refundGatewayAmount">$0.00</strong>
                                    </div>

                                    <button type="submit"
                                            class="btn btn-success btn-sm"
                                            id="submitCardRefundBtn">
                                        <i class="fa fa-undo"></i>
                                        Refund
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong style="font-size:13px;">Refund History</strong>
                            <span id="refundHistoryCount" class="badge badge-secondary">0</span>
                        </div>

                        <div class="table-responsive" style="max-height:260px;overflow:auto;">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th class="text-right">Refund</th>
                                        <th class="text-right">Full Amount</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="refundHistoryBody">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No refund records.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    /*
     * Search nested StoreCardPayment rows whenever this page actually contains
     * expandable auto-generated payment parents.
     *
     * The previous code checked order_type == 'TSRM', but this page/filter uses
     * 'TSR'. That meant the custom nested-row search never ran.
     */
    const hasStorePaymentParents = @json($hasStorePaymentParents ?? false);
    const storeQuickBooksStatusMap = @json($storeQuickBooksStatusMap ?? []);
    const storeCustomerNameMap = @json($storeCustomerNameMap ?? []);
    const storeCustomerSearchIndex = @json($storeCustomerSearchIndex ?? []);

    function getStoreCustomerName(payment) {
        return storeCustomerNameMap[String(payment.id)] || '';
    }

    function getStoreQuickBooksStatus(payment) {
        const recordId = String(payment.id);
        const refundKey = String(parseInt(payment.is_refund || 0, 10));
        const recordMap = storeQuickBooksStatusMap[recordId] || {};

        return recordMap[refundKey] || null;
    }

    function getQuickBooksStatusIcon(status) {
        if (status === 'synced') {
            return '<i class="fa fa-check-circle" title="Synced to QuickBooks" aria-label="Synced to QuickBooks" style="color:#28a745;font-size:17px;"></i>';
        }

        if (status === 'saved') {
            return '<i class="fa fa-save" title="Saved for QuickBooks" aria-label="Saved for QuickBooks" style="color:#6c757d;font-size:15px;"></i>';
        }

        if (status === 'failed') {
            return '<i class="fa fa-exclamation-circle" title="QuickBooks sync failed" aria-label="QuickBooks sync failed" style="color:#dc3545;font-size:17px;"></i>';
        }

        return '';
    }

    let storeSearchMatches = [];
    let activeStoreSearch = '';
    let storeSearchTimer = null;
    let storeSearchRequest = null;

    /*
     * When a collapsed PaymentLog parent is expanded because one of its
     * StoreCardPayment children matched the DataTables search, render ONLY the
     * matching child payment(s), not every child under that parent.
     */
    function storePaymentMatchesActiveSearch(payment) {
        const search = String(activeStoreSearch || '')
            .toLowerCase()
            .replace(/\s+/g, ' ')
            .trim();

        if (!search) {
            return true;
        }

        const createdAt = payment.created_at
            ? new Date(payment.created_at)
            : null;

        const dateText = (
            createdAt
            && !Number.isNaN(createdAt.getTime())
        )
            ? createdAt.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            })
            : '';

        const timeText = (
            createdAt
            && !Number.isNaN(createdAt.getTime())
        )
            ? createdAt.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            })
            : '';

        const paymentTypeText =
            parseInt(payment.is_refund || 0, 10) === 1
                ? 'refund'
                : 'payment';

        let statusText = 'failed';

        if (
            parseInt(payment.is_success || 0, 10) === 1
            && parseInt(payment.is_refund || 0, 10) === 0
        ) {
            statusText = 'successful';
        }

        if (
            parseInt(payment.is_success || 0, 10) === 1
            && parseInt(payment.is_refund || 0, 10) === 1
        ) {
            statusText = 'refunded';
        }

        const qbStatus =
            getStoreQuickBooksStatus(payment) || '';

        const searchableText = [
            payment.id,
            payment.store_order_no,
            payment.card_owner,
            getStoreCustomerName(payment),
            payment.transaction_id,
            payment.payment_amount,
            payment.processing_fee,
            payment.total_amount,
            paymentTypeText,
            statusText,
            qbStatus,
            dateText,
            timeText,
            payment.created_at
        ]
        .map(function(value) {
            return String(value ?? '').toLowerCase();
        })
        .join(' ')
        .replace(/\s+/g, ' ')
        .trim();

        // Match every word entered in the DataTables search box.
        return search
            .split(' ')
            .filter(Boolean)
            .every(function(term) {
                return searchableText.indexOf(term) !== -1;
            });
    }

    let header = "PAYMENTS";
    const headerElement = document.getElementById("header");

    if (headerElement) {
        headerElement.innerHTML = header;
    }

    var searchIdx = '';

    $(document).ready(function() {
        const today = new Date().toISOString().split('T')[0];

        // Set the maximum value for both date inputs to today
        $('#start-date').attr('max', today);
        $('#end-date').attr('max', today);

        /*
        |--------------------------------------------------------------------------
        | DataTables search + collapsed StoreCardPayment rows
        |--------------------------------------------------------------------------
        |
        | DataTables cannot search rows that do not exist in its internal data.
        | The nested StoreCardPayment <tr> elements are loaded only after clicking
        | the chevron, so we search those child records on the server and map any
        | match back to its visible PaymentLog parent row.
        */

        function normalizeTransactionSearch(value) {
            return String(value || '')
                .toLowerCase()
                .replace(/\s+/g, ' ')
                .trim();
        }

        function transactionTextMatches(text, search) {
            const normalizedText = normalizeTransactionSearch(text);
            const normalizedSearch = normalizeTransactionSearch(search);

            if (!normalizedSearch) {
                return true;
            }

            // Match all entered words, similar to DataTables smart-search behavior.
            const terms = normalizedSearch
                .split(' ')
                .filter(Boolean);

            return terms.every(function(term) {
                return normalizedText.indexOf(term) !== -1;
            });
        }

        if (hasStorePaymentParents) {
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (
                    !settings.nTable
                    || settings.nTable.id !== 'transactions_table'
                ) {
                    return true;
                }

                if (!activeStoreSearch) {
                    return true;
                }

                /*
                 * First search the normal parent-row DataTables data.
                 */
                const rowText = data.join(' ');

                if (
                    transactionTextMatches(
                        rowText,
                        activeStoreSearch
                    )
                ) {
                    return true;
                }

                /*
                 * If the visible parent itself does not match, keep it when one
                 * of its collapsed StoreCardPayment children matched the AJAX
                 * search endpoint.
                 */
                const rowData = settings.aoData[dataIndex];
                const rowNode = rowData
                    ? rowData.nTr
                    : null;

                if (!rowNode) {
                    return false;
                }

                const paymentLogId = parseInt(
                    $(rowNode).attr('data-payment-log-id'),
                    10
                );

                return (
                    !Number.isNaN(paymentLogId)
                    && storeSearchMatches.includes(paymentLogId)
                );
            });
        }

        if ($.fn.DataTable.isDataTable('#transactions_table')) {
            $('#transactions_table').DataTable().destroy();
        }

        var usersTable = $('#transactions_table').DataTable({
            colReorder: false,
            stateSave: false,
            autoWidth: false,
            pageLength: 50,
            bSort: false,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search'
            }
        });

        if (hasStorePaymentParents) {

            function collapseStorePaymentRows() {
                $('#transactions_table tbody tr.payment-log-detail-row')
                    .remove();

                $('#transactions_table .show_store_payments')
                    .removeClass('expanded fa-chevron-down')
                    .addClass('fa-chevron-right');
            }

            function expandMatchedStorePaymentRows() {
                if (
                    !activeStoreSearch
                    || !storeSearchMatches.length
                ) {
                    return;
                }

                /*
                 * Only auto-expand parents whose CHILD records matched.
                 * A normal match in the visible parent row can remain collapsed.
                 */
                $('#transactions_table tbody > tr').each(function() {
                    const $row = $(this);

                    if (
                        $row.hasClass('payment-log-detail-row')
                    ) {
                        return;
                    }

                    const paymentLogId = parseInt(
                        $row.attr('data-payment-log-id'),
                        10
                    );

                    if (
                        Number.isNaN(paymentLogId)
                        || !storeSearchMatches.includes(paymentLogId)
                    ) {
                        return;
                    }

                    const $icon =
                        $row.find('.show_store_payments');

                    if (
                        $icon.length
                        && !$icon.hasClass('expanded')
                    ) {
                        $icon.trigger('click');
                    }
                });
            }

            usersTable.on(
                'draw.collapsedStoreSearch',
                function() {
                    expandMatchedStorePaymentRows();
                }
            );

            const $searchInput =
                $('#transactions_table_filter input');

            /*
             * Remove only DataTables' built-in global-search events.
             * Our handler searches BOTH the visible parent rows and the
             * collapsed AJAX child records.
             */
            $searchInput.off(
                'keyup.DT input.DT search.DT'
            );

            $searchInput.off(
                '.collapsedStoreSearch'
            );

            $searchInput.on(
                'keyup.collapsedStoreSearch input.collapsedStoreSearch search.collapsedStoreSearch',
                function() {
                    const rawSearch =
                        $(this).val().trim();

                    activeStoreSearch =
                        normalizeTransactionSearch(rawSearch);

                    clearTimeout(storeSearchTimer);

                    if (storeSearchRequest) {
                        storeSearchRequest.abort();
                        storeSearchRequest = null;
                    }

                    /*
                     * Child rows inserted manually are not DataTables rows and can
                     * become stale after a search/draw. Remove them first.
                     */
                    collapseStorePaymentRows();

                    if (!activeStoreSearch) {
                        storeSearchMatches = [];

                        /*
                         * Keep DataTables' own global search empty. Filtering is
                         * handled by the ext.search callback above.
                         */
                        usersTable.search('').draw();

                        return;
                    }

                    storeSearchTimer = setTimeout(
                        function() {
                            storeSearchRequest = $.ajax({
                                url: "{{ route('transaction.search_store_payment_logs') }}",
                                method: 'GET',
                                dataType: 'json',
                                data: {
                                    search: rawSearch
                                },

                                success: function(response) {
                                    const serverMatches = (
                                        response.payment_log_ids
                                        || []
                                    )
                                    .map(function(id) {
                                        return parseInt(
                                            id,
                                            10
                                        );
                                    })
                                    .filter(function(id) {
                                        return !Number.isNaN(
                                            id
                                        );
                                    });

                                    /*
                                     * StoreCardPayment Customer Name lives in the
                                     * StoreOrder map supplied by the controller.
                                     * Include matching parent PaymentLog IDs here
                                     * so searching by customer name works even
                                     * before the collapsed child rows are opened.
                                     */
                                    const customerSearchTerms =
                                        normalizeTransactionSearch(
                                            rawSearch
                                        )
                                        .split(' ')
                                        .filter(Boolean);

                                    const customerMatches =
                                        storeCustomerSearchIndex
                                            .filter(function(item) {
                                                const customerName =
                                                    normalizeTransactionSearch(
                                                        item.customer_name
                                                    );

                                                return customerSearchTerms
                                                    .every(function(term) {
                                                        return customerName
                                                            .indexOf(term)
                                                            !== -1;
                                                    });
                                            })
                                            .map(function(item) {
                                                return parseInt(
                                                    item.parent_id,
                                                    10
                                                );
                                            })
                                            .filter(function(id) {
                                                return !Number.isNaN(
                                                    id
                                                );
                                            });

                                    storeSearchMatches = [
                                        ...new Set([
                                            ...serverMatches,
                                            ...customerMatches
                                        ])
                                    ];

                                    /*
                                     * DataTables' own text search stays empty.
                                     * ext.search decides whether each parent is
                                     * visible based on:
                                     *   1. parent-row text, OR
                                     *   2. collapsed-child server match.
                                     */
                                    usersTable
                                        .search('')
                                        .draw();
                                },

                                error: function(xhr, status) {
                                    if (status === 'abort') {
                                        return;
                                    }

                                    console.error(
                                        'Store payment search failed.',
                                        xhr.responseText
                                    );

                                    /*
                                     * Parent-row searching must still work even
                                     * if the nested search endpoint fails.
                                     */
                                    storeSearchMatches = [];

                                    usersTable
                                        .search('')
                                        .draw();
                                },

                                complete: function() {
                                    storeSearchRequest = null;
                                }
                            });
                        },
                        250
                    );
                }
            );
        }

        $('#pin-filter').click(function(e) {
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            // Get filter values
            var startDate = $('#start-date').val();
            var endDate = $('#end-date').val();
            var paymentType = $('#paymentType').val();
            var paymentStatus = $('#paymentStatus').val();
            var order_type = $('#order_type').val();

            // Build URL with query params
            let url = "{{ route('allTransactions') }}" +
                    "?start_date=" + encodeURIComponent(startDate) +
                    "&end_date=" + encodeURIComponent(endDate) +
                    "&payment_type=" + encodeURIComponent(paymentType) +
                    "&payment_status=" + encodeURIComponent(paymentStatus)+
                    "&order_type=" + encodeURIComponent(order_type);

            // Redirect page to filtered URL
            window.location.href = url;
        });
        $('#reset-filter').click(function(e) {
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            // Redirect to base route to show all transactions
            window.location.href = "{{ route('allTransactions') }}";
        });

        $(".se-pre-con").fadeOut('slow');
    });



    function exportReport() {
    $("#transactions_table").tableExport({
        type: 'csv',            // 'csv', 'xlsx', 'pdf', etc.
        escape: false,           // Don't escape HTML
        ignoreCols: [],          // Columns to ignore
        exportHiddenCells: true, // Export hidden cells
        htmlContent: false,      // IMPORTANT: get plain text instead of HTML
        fileName: 'transactions_report',
    });
}


    $(".payID").click(function() {
        $(".se-pre-con").fadeIn('slow');

        var paymentType = $(this).attr('data-transactionType');
        var orderNo = $(this).attr('data-orderNo');
        var display_order_no = ('000000' + orderNo).slice(-6);

        var imageContent = "";
        var paymentUrl = "payment?orderId=" + orderNo;

        // Title and images based on payment type
        if (paymentType === "Card") {
            $("#modal_title_notification").html("All Card Payments | Order #" + display_order_no);
        }
        if (paymentType === "Check") {
            $("#modal_title_notification").html("All Check Payments | Order #" + display_order_no);
            var frontImage = $(this).attr('data-checkfimage');
            var backImage = $(this).attr('data-checkbimage');
            imageContent = `
                <a class='check-image' download='${display_order_no}-check-front.jpg' href='{{asset('uploads')}}/../${frontImage}' title='Check Front'>
                    <img src='{{asset('uploads')}}/../${frontImage}'>
                </a>
                <a class='check-image' download='${display_order_no}-check-back.jpg' href='{{asset('uploads')}}/../${backImage}' title='Check Back'>
                    <img src='{{asset('uploads')}}/../${backImage}'>
                </a>
            `;
        }
        if (paymentType === "Venmo") {
            $("#modal_title_notification").html("All Venmo Payments | Order #" + display_order_no);
            var frontImage = $(this).attr('data-checkfimage');
            imageContent = `
                <a class='venmo-image' download='${display_order_no}-venmo.jpg' href='{{asset('uploads')}}/../${frontImage}' title='Venmo'>
                    <img src='{{asset('uploads')}}/../${frontImage}'>
                </a>
            `;
        }
        if (paymentType === "PO") {
            $("#modal_title_notification").html("All PO Payments | Order #" + display_order_no);
            var frontImage = $(this).attr('data-checkfimage');
            imageContent = `
                <a class='venmo-image' download='${display_order_no}-purchase_order.jpg' href='{{asset('uploads')}}/../${frontImage}' title='PO'>
                    <img src='{{asset('uploads')}}/../${frontImage}'>
                </a>
            `;
        }
        if (paymentType === "Other") {
            $("#modal_title_notification").html("All Other Payments | Order #" + display_order_no);
            var frontImage = $(this).attr('data-checkfimage');
            imageContent = `
                <a class='venmo-image' download='${display_order_no}-other_order.jpg' href='{{asset('uploads')}}/../${frontImage}' title='Other'>
                    <img src='{{asset('uploads')}}/../${frontImage}'>
                </a>
            `;
        }

        tableBodyPayments = "";
        rowNo = 1;
        totalPayments = 0;
        var clickedElement = $(this);

        $.ajax({
            url: "{{ url('transaction/get_order_payments') }}/",
            data : {
                orderID: orderNo,
                _token : "{{ csrf_token() }}"
            },
            method: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(response) {

                if (response.order_payments.length > 0) {

                    response.order_payments.forEach(function(item) {

                        totalPayments += parseFloat(item['Amount']) || 0;

                        var isClickedTransaction = '';

                        if (item['TransactionId'] == clickedElement.attr('data-value')) {
                            isClickedTransaction = 'style="background-color: #9cc775;"';
                        }

                        var datetimeString = item['PaymentDate'] || "";
                        var paidDate = datetimeString ? new Date(datetimeString) : null;

                        var date = "-";
                        var time = "-";

                        if (paidDate && !isNaN(paidDate)) {
                            var year = paidDate.getFullYear();
                            var month = String(paidDate.getMonth() + 1).padStart(2, '0');
                            var day = String(paidDate.getDate()).padStart(2, '0');
                            var hour = String(paidDate.getHours()).padStart(2, '0');
                            var minute = String(paidDate.getMinutes()).padStart(2, '0');
                            var second = String(paidDate.getSeconds()).padStart(2, '0');

                            date = `${month}-${day}-${year}`;
                            time = `${hour}:${minute}:${second}`;
                        }

                        tableBodyPayments += `
                            <tr ${isClickedTransaction}>
                                <td>${rowNo}</td>
                                <td>${item['Method'] || '-'}</td>
                                <td>${item['NameonCard'] || '-'}</td>
                                <td>${item['TransactionId'] || '-'}</td>
                                <td style="text-align:right;">$ ${parseFloat(item['Amount'] || 0).toFixed(2)}</td>
                                <td style="text-align:right;${item['is_approve'] == 1 ? 'color:green !important' : 'color:red !important'}">${item['is_approve'] == 1 ? 'Approved' : 'Not Approved'}</td>
                                <td>${date}</td>
                                <td style="border-bottom: 1px solid #e9ecef;">${time}</td>
                                <td style="border-bottom: 1px solid #e9ecef;" class="invoice_data_td" data-transaction-id='${item['id']}' data-transaction-method='${item['Method']}' data-order-id='${orderNo}'><i class="fa fa-eye view-payment-receipt" title="View Receipt" style="cursor:pointer !important" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-download download-payment-receipt" title="Download Receipt" style="cursor:pointer !important" aria-hidden="true"></i></td>
                            </tr>
                        `;
                        rowNo++;
                    });

                    var table = `
                        <table style="margin: 0rem 2rem;" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Method</th>
                                    <th>Name on Card</th>
                                    <th>Transaction Id</th>
                                    <th class="text-right">Amount</th>
                                    <th>Approval</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Receipt</th>
                                </tr>
                            </thead>
                            <tbody>${tableBodyPayments}</tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7" style="font-size: 15px; text-align: right;">Total Amount</th>
                                    <th class="text-right" style="font-size: 15px; padding-right: 36px;">$ ${totalPayments.toFixed(2)}</th>
                                </tr>
                            </tfoot>
                        </table>
                    `;

                    $("#check_payment").html(imageContent + table);

                    var modalFooter = `
                        <a style="background-color:#47D6B6;color:white" type="button" class="styled-button" target="_blank" href='{{ url("transaction/payments/invoice/") }}/${orderNo}'>Download Invoice</a>
                        <button style="color:white;background-color:#d65a47" type="button" class="styled-button ml-auto" data-dismiss="modal">Close</button>
                    `;
                    $("#modal-footer").html(modalFooter);

                    $('#notification_modal').modal('show');
                    $(".se-pre-con").fadeOut('slow');

                }
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    });

    $(document).on('click', '.show_store_payments', function () {

        let $icon = $(this);
        let paymentLogId = $icon.data('payment-log-id');
        let $closestTr = $icon.closest('tr');

        if ($icon.hasClass('expanded')) {
            $closestTr.nextAll('.payment-log-row-' + paymentLogId).remove();
            $icon.removeClass('expanded');
            $icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
            return;
        }

        $.ajax({
            url: "{{ route('transaction.store_payment_log_details') }}",
            method: "GET",
            data: {
                paymentLogId: paymentLogId
            },
            dataType: "json",
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {

                let contentHtml = '';

                const indPlayerBaseUrl = "{{ url('store/individual_player') }}";

                const allPayments = Array.isArray(response)
                    ? response
                    : [];

                /*
                 * During DataTables search, the AJAX endpoint tells us which
                 * PaymentLog parent contains a match. The detail endpoint still
                 * returns ALL children for that parent, so filter them here.
                 *
                 * When there is no search, keep the original behavior and show
                 * every child payment.
                 */
                const paymentsToRender = activeStoreSearch
                    ? allPayments.filter(function(payment) {
                        return storePaymentMatchesActiveSearch(payment);
                    })
                    : allPayments;

                if (paymentsToRender.length > 0) {

                    let rows = '';

                    /*
                     * Parent sync state must be based on all ELIGIBLE child
                     * payments, not only the currently searched/visible rows.
                     *
                     * Only successful StoreCardPayment rows are eligible for QBO
                     * import. Failed card attempts must not keep a parent from
                     * becoming fully synced.
                     */
                    const eligiblePayments = allPayments.filter(function(payment) {
                        return parseInt(payment.is_success || 0, 10) === 1;
                    });

                    const allChildrenSynced = (
                        eligiblePayments.length > 0
                        && eligiblePayments.every(function(payment) {
                            return getStoreQuickBooksStatus(payment) === 'synced';
                        })
                    );

                    paymentsToRender.forEach(function(payment) {

                        let statusBadge = '<span class="badge bg-danger">Failed</span>';

                        if (payment.is_success == 1 && payment.is_refund == 0) {
                            statusBadge = '<span class="badge bg-success">Successful</span>';
                        }

                        if (payment.is_success == 1 && payment.is_refund == 1) {
                            statusBadge = '<span class="badge bg-warning text-dark">Refunded</span>';
                        }

                        let createdAt = payment.created_at
                            ? new Date(payment.created_at)
                            : null;

                        let formattedDate = (
                            createdAt
                            && !Number.isNaN(createdAt.getTime())
                        )
                            ? createdAt.toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric',
                                year: 'numeric'
                            })
                            : '';

                        let formattedTime = (
                            createdAt
                            && !Number.isNaN(createdAt.getTime())
                        )
                            ? createdAt.toLocaleTimeString('en-US', {
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: false
                            })
                            : '';

                        const qbStatus = getStoreQuickBooksStatus(payment);
                        const isQuickBooksSynced = qbStatus === 'synced';

                        let checkStatus = '';
                        let disabledStatus = '';
                        let qbStatusIcon = getQuickBooksStatusIcon(qbStatus);

                        let parentCheckbox = $('.transaction-checkbox[data-value="' + paymentLogId + '"]');

                        // A successfully synced payment must never be selected again.
                        if (isQuickBooksSynced) {
                            disabledStatus = 'disabled';
                        } else if (
                            parentCheckbox.length
                            && parentCheckbox.is(':checked')
                        ) {
                            checkStatus = 'checked';
                        }

                        rows += `
                            <tr data-store-payment-id="${payment.id}">
                                <td style="text-align: center;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:8px;white-space:nowrap;">
                                        ${qbStatusIcon}
                                        <input
                                            type="checkbox"
                                            class="store-transaction-checkbox-${paymentLogId} store_transaction_record"
                                            data-parent-record="${paymentLogId}"
                                            data-value="${payment.id}"
                                            ${checkStatus}
                                            ${disabledStatus}
                                            title="${isQuickBooksSynced ? 'Already synced to QuickBooks' : 'Select for QuickBooks import'}"
                                        />
                                    </div>
                                </td>

                                <td>${payment.transaction_id ?? ''}</td>

                                <td>${payment.store_order_no
                                    ? `<a href="${indPlayerBaseUrl}/${payment.store_order_no}"
                                        target="_blank"
                                        class="text-decoration-none fw-semibold">
                                        ${payment.store_order_no}
                                    </a>`
                                    : ''
                                }</td>

                                <td>${payment.card_owner ?? ''}</td>

                                <td>${getStoreCustomerName(payment)}</td>

                                <td class="text-end">
                                    $${parseFloat(payment.payment_amount || 0).toFixed(2)}
                                </td>

                                <td class="text-end">
                                    $${parseFloat(payment.processing_fee || 0).toFixed(2)}
                                </td>

                                <td class="text-end">
                                    $${parseFloat(payment.total_amount || 0).toFixed(2)}
                                </td>

                                <td class="text-center">
                                    ${payment.is_refund == 1
                                        ? '<span class="badge bg-warning text-dark">Refund</span>'
                                        : '<span class="badge bg-info">Payment</span>'
                                    }
                                </td>

                                <td class="text-center">
                                    ${statusBadge}
                                </td>

                                <td>${formattedDate}</td>

                                <td class="text-center">
                                    ${formattedTime}
                                </td>
                            </tr>
                        `;
                    });

                    /*
                     * Keep the collapsed parent QuickBooks status correct.
                     *
                     * This updates the same FIRST-column icon regardless of your
                     * current Transaction ID / Order # / Payment Type column order.
                     */
                    const $parentQbStatusIcon = $(
                        '[data-parent-qb-status="' + paymentLogId + '"]'
                    );

                    const $parentCheckbox = $(
                        '.transaction-checkbox[data-value="' + paymentLogId + '"]'
                    );

                    if (allChildrenSynced) {

                        $parentQbStatusIcon.html(
                            '<i '
                            + 'class="fa fa-check-circle" '
                            + 'title="All StoreOrder payments synced to QuickBooks" '
                            + 'aria-label="All StoreOrder payments synced to QuickBooks" '
                            + 'style="color:#28a745;font-size:17px;"'
                            + '></i>'
                        );

                        $parentCheckbox
                            .prop('checked', false)
                            .prop('disabled', true)
                            .attr(
                                'title',
                                'All StoreOrder payments are already synced to QuickBooks'
                            );

                        /*
                         * If the parent had been selected before the child state
                         * was loaded, remove it from the QBO selection now.
                         */
                        removeSelectedTransaction(paymentLogId);

                    } else {

                        $parentQbStatusIcon.empty();

                        /*
                         * Only undo the disabled state if it was caused by the
                         * "all children synced" condition. Do not override another
                         * business rule that may have disabled the checkbox.
                         */
                        if (
                            $parentCheckbox.attr('title')
                            === 'All StoreOrder payments are already synced to QuickBooks'
                        ) {
                            $parentCheckbox
                                .prop('disabled', false)
                                .attr(
                                    'title',
                                    'Select for QuickBooks import'
                                );
                        }
                    }

                    contentHtml = `
                        <div class="p-1">
                            ${activeStoreSearch
                                ? `<div class="small text-muted mb-1">
                                    Showing ${paymentsToRender.length} matching payment record${paymentsToRender.length === 1 ? '' : 's'}
                                   </div>`
                                : ''
                            }

                            <table class="table table-sm table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="min-width:135px;">QuickBooks / Select</th>
                                        <th>Transaction ID</th>
                                        <th>Store Order #</th>
                                        <th>Card Owner</th>
                                        <th>Customer Name</th>
                                        <th class="text-end">Payment</th>
                                        <th class="text-end">Fee</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Payment Type</th>
                                        <th class="text-center">Status</th>
                                        <th>Date</th>
                                        <th class="text-center">Time</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    ${rows}
                                </tbody>
                            </table>
                        </div>
                    `;

                } else {

                    contentHtml = `
                        <div class="p-4 text-center text-muted">
                            ${activeStoreSearch
                                ? 'No matching payment records found under this log.'
                                : 'No payment records found for this log.'
                            }
                        </div>
                    `;
                }

                let newRow = `
                    <tr class="payment-log-detail-row payment-log-row-${paymentLogId}">
                        <td colspan="13" style="background:#f8f9fa;">
                            ${contentHtml}
                        </td>
                    </tr>
                `;

                $closestTr.after(newRow);

                $icon.addClass('expanded');
                $icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');

                updateStoreTransaction();
            },

            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });

    });

    var selectedTransactions = [];
    var selectedStoreTransactions = [];

    function addSelectedTransaction(transactionId, paymentType, isAutoGenerated) {
        if (!selectedTransactions.some(function(item) {
            return String(item.id) === String(transactionId)
                && String(item.type) === String(paymentType)
                && parseInt(item.auto_generated, 10) === parseInt(isAutoGenerated, 10);
        })) {
            selectedTransactions.push({
                id: transactionId,
                type: paymentType,
                auto_generated: isAutoGenerated
            });
        }
    }

    function removeSelectedTransaction(transactionId) {
        selectedTransactions = selectedTransactions.filter(function(item) {
            return String(item.id) !== String(transactionId);
        });
    }

    $(document).on('click', '.transaction-checkbox', function() {
        if ($(this).is(':disabled')) {
            return;
        }

        var transactionId = $(this).data('value');
        var paymentType = $(this).data('type');
        var isAutoGenerated = parseInt($(this).data('auto-generated'), 10);

        let $childCheckboxes = $('.store-transaction-checkbox-' + transactionId + ':not(:disabled)');

        if ($(this).is(':checked')) {
            if (isAutoGenerated === 1 && !$childCheckboxes.length) {
                // Do not make the parent importable until its actual StoreCardPayment
                // children have loaded. This prevents a parent-only request with an
                // empty store_transactions payload.
                removeSelectedTransaction(transactionId);

                const $icon = $('.show_store_payments[data-payment-log-id="' + transactionId + '"]');
                if ($icon.length && !$icon.hasClass('expanded')) {
                    $icon.trigger('click');
                }
            } else {
                addSelectedTransaction(transactionId, paymentType, isAutoGenerated);

                if (isAutoGenerated === 1) {
                    $childCheckboxes.prop('checked', true);
                }
            }
        } else {
            removeSelectedTransaction(transactionId);

            if (isAutoGenerated === 1 && $childCheckboxes.length) {
                $childCheckboxes.prop('checked', false);
            }
        }

        updateStoreTransaction();
    });

    function ShowImportButton() {
        if(selectedTransactions.length > 0 || selectedStoreTransactions.length > 0){
            $('.import-to-quickbooks').show();
        }else{
            $('.import-to-quickbooks').hide();
        }
    }

    $(document).on('click', '.store_transaction_record', function(){
        updateStoreTransaction();
    });

    function updateStoreTransaction() {
        // Rebuild the child selection list every time.  The old code only added
        // items and did not remove them when a child checkbox was unchecked.
        selectedStoreTransactions = [];

        $('.store_transaction_record:checked:not(:disabled)').each(function () {
            selectedStoreTransactions.push({
                id: $(this).data('value'),
                parentId: $(this).data('parent-record')
            });
        });

        // Synchronize each loaded StoreOrder parent checkbox/selection with its
        // currently selected, unsynced child records.
        $('.transaction-checkbox[data-auto-generated="1"]').each(function () {
            const $parent = $(this);
            const parentId = $parent.data('value');
            const paymentType = $parent.data('type');
            const $loadedChildren = $('.store-transaction-checkbox-' + parentId);

            // Do not alter a parent before its nested records have loaded.
            if (!$loadedChildren.length) {
                return;
            }

            const selectedChildCount = $loadedChildren.filter(':checked:not(:disabled)').length;
            const selectableChildCount = $loadedChildren.filter(':not(:disabled)').length;

            if (selectedChildCount > 0) {
                $parent.prop('checked', true);
                addSelectedTransaction(parentId, paymentType, 1);
            } else {
                $parent.prop('checked', false);
                removeSelectedTransaction(parentId);
            }

            if (selectableChildCount === 0) {
                $parent.prop('disabled', true);
                removeSelectedTransaction(parentId);
            }
        });

        ShowImportButton();
    }

    $(document).on('click', '.import-to-quickbooks', function () {

        if (selectedTransactions.length === 0 && selectedStoreTransactions.length === 0) {
            swal("No transactions selected",
                "Please select at least one transaction to import.",
                "warning");
            return;
        }

        var exportURL = '{{ route("quickbooks.import_to_quickbooks") }}'
            + '?transactions=' + encodeURIComponent(JSON.stringify(selectedTransactions))
            + '&store_transactions=' + encodeURIComponent(JSON.stringify(selectedStoreTransactions));

        window.location.href = exportURL;
    });

    $("body").on("click", ".edit-order", function(){
        var orderId = $(this).data('value');
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });

    $("body").on("click", ".download-payment-receipt", function() {
        var transactionID = $(this).closest('.invoice_data_td').data('transaction-id');
        var transactionMethod = $(this).closest('.invoice_data_td').data('transaction-method');
        var orderID = $(this).closest('.invoice_data_td').data('order-id');
        downloadPaymentReceipt(transactionID, transactionMethod, orderID, true);

    });
    $("body").on("click", ".view-payment-receipt", function() {
        var transactionID = $(this).closest('.invoice_data_td').data('transaction-id');
        var transactionMethod = $(this).closest('.invoice_data_td').data('transaction-method');
        var orderID = $(this).closest('.invoice_data_td').data('order-id');

        downloadPaymentReceipt(transactionID, transactionMethod, orderID, false);

    });

    function downloadPaymentReceipt(transactionID, transactionMethod, orderID, is_download) {

        $.ajax({
            url: "{{ url('transaction/get_payment_receipt_data') }}/",
            data : {
                orderID: orderID,
                transactionID: transactionID,
                transactionMethod: transactionMethod,
                _token : "{{ csrf_token() }}"
            },
            method: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(response) {

                var paymentDetails = response.payment_receipt[0];
                var orderDetails = response.orderDetails;

                let paymentDate = paymentDetails['PaymentDate'];
                let formattedDate = '';

                if (paymentDate) {
                    let dateObj = new Date(paymentDate);
                    let month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
                    let day = ('0' + dateObj.getDate()).slice(-2);
                    let year = dateObj.getFullYear();
                    let hours = ('0' + dateObj.getHours()).slice(-2);
                    let minutes = ('0' + dateObj.getMinutes()).slice(-2);
                    let seconds = ('0' + dateObj.getSeconds()).slice(-2);

                    formattedDate = `${month}-${day}-${year} ${hours}:${minutes}:${seconds}`;
                }

                var discountAmount = 0.00;
                var order_total_amount = parseFloat(orderDetails.sub_total) + parseFloat(orderDetails.artwork);

                if (orderDetails.discount_hidation == 1) {
                    if (orderDetails.discountType == 1) {
                        discountAmount = (order_total_amount / 100) * parseFloat(orderDetails.discount);
                    } else if (orderDetails.discountType == 2) {
                        discountAmount = parseFloat(orderDetails.discount);
                    }
                }

                var receiptHTML = `
                        <!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Payment Receipt</title>
                        </head>
                        <body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
                            <div style="width: 700px; margin: 20px auto; background: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                <div style="text-align: center; margin-bottom: 20px;">
                                    <h1 style="font-size: 22px; margin: 0; color: #333;">Payment Receipt</h1>
                                </div>

                                <div style="margin: 20px 0;">
                                    <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Transaction Details</div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Date:</div>
                                        <div style="color: #333;">${formattedDate}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Order ID:</div>
                                        <div style="color: #333;">#${orderDetails.order_no}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Transaction ID:</div>
                                        <div style="color: #333;">${paymentDetails['TransactionId']}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Customer Name:</div>
                                        <div style="color: #333;">${paymentDetails['NameonCard']}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Payment Method:</div>
                                        <div style="color: #333;">${paymentDetails['Method']}</div>
                                    </div>

                                    ${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal') ? `
                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Amount Paid ($):</div>
                                        <div style="color: #333;">${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal' ? (parseFloat(paymentDetails['Amount']) * 100 / 103) : parseFloat(paymentDetails['Amount'])).toFixed(2)}</div>
                                    </div>
                                    ` : ``}

                                    ${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal') ? `
                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Processing Fee Paid (3%) ($):</div>
                                        <div style="color: #333;">${(parseFloat(paymentDetails['Amount']) * 3 / 103 || 0).toFixed(2)}</div>
                                    </div>
                                    ` : ``}

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Total amount Paid ($):</div>
                                        <div style="color: #333;">${(parseFloat(paymentDetails['Amount']) || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Status:</div>
                                        <div style="${paymentDetails['is_approve'] == 1 ? 'color:green' : 'color:red'};">${paymentDetails['is_approve'] == 1 ? 'Approved' : 'Not Approved'}</div>
                                    </div>
                                </div>

                                <div style="margin: 20px 0;">
                                    <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Order Summary</div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: black;">Invoice Amount ($):</div>
                                        <div style="color: black;">${(parseFloat(orderDetails.sub_total) || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Artwork & Other Fees ($):</div>
                                        <div style="color: #333;">${(parseFloat(orderDetails.artwork) || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Discount ($):</div>
                                        <div style="color: #333;">${discountAmount.toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: black;">Total invoice amount ($):</div>
                                        <div style="color: black;">${(parseFloat(orderDetails.artwork) + parseFloat(orderDetails.sub_total) - discountAmount).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Sales Tax (${orderDetails.organization_details.sales_tax}%) ($):</div>
                                        <div style="color: #333;">${(orderDetails.sales_tax || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Shipping ($):</div>
                                        <div style="color: #333;">${(orderDetails.shipping || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 10px 0; font-size: .9rem;">
                                        <div style="font-weight: bold; color: black;">Grand total ($):
                                            <p style="color: grey; font-weight: 100; font-size: .7rem; margin: 0;">(Invoice amount + Sales Tax + shipping)</p>
                                        </div>
                                        <div style="color: black; font-weight: bold;">${orderDetails.order_total.toFixed(2)}</div>
                                    </div>

                                    ${parseFloat(paymentDetails['total_payment']) > 0 ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Paid Amount ($):</div>
                                            <div style="color: #333;">${(parseFloat(paymentDetails['total_payment']) || 0).toFixed(2)}</div>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Paid Processing Fee ($):</div>
                                            <div style="color: #333;">${(parseFloat(paymentDetails['ProcessingFee']) || 0).toFixed(2)}</div>
                                        </div>
                                    ` : ``}

                                    ${parseFloat(paymentDetails['balance_to_be_paid']) > 0 ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: black;">Balance to Pay ($):</div>
                                            <div style="color: black;">${parseFloat(paymentDetails['balance_to_be_paid']).toFixed(2)}</div>
                                        </div>
                                    ` : ``}

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Order Status:</div>
                                        <div style="color: ${paymentDetails['paymentStatus'] == 'Pending' ? 'grey' : paymentDetails['paymentStatus'] == 'Partial' ? 'red' : paymentDetails['paymentStatus'] == 'Paid' ? 'green' : 'grey'};">${paymentDetails['paymentStatus']}</div>
                                    </div>
                                </div>

                                <div style="text-align: center; margin: 20px 0;">
                                    <h2 style="color: #333;">Thank you for your business!</h2>
                                    <img src="{{ asset('argon/img/encore/logo_dark.png') }}" alt="Logo" style="width: 350px;">
                                </div>
                            </div>
                        </body>
                        </html>
                        `;

                        if (is_download) {

                        var opt = {
                            margin: 0.5,
                            filename: 'payment-receipt-' + orderDetails.order_no + '.pdf',
                            image: { type: 'jpeg', quality: 0.98 },
                            html2canvas: { scale: 2 },
                            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
                        };

                        // Create a temporary element
                        var element = document.createElement('div');
                        element.innerHTML = receiptHTML;
                        document.body.appendChild(element);

                        // Use html2pdf to generate PDF
                        html2pdf().from(element).set(opt).save().then(() => {
                            document.body.removeChild(element); // Clean up
                        });

                        } else {

                            // Insert the receiptHTML inside modal body
                            $('#receiptModalBody').html(receiptHTML);

                            // Show the modal
                            $('#receiptModal').modal('show');
                        }
                $(".se-pre-con").fadeOut('slow');
            },
            complete: function () {
            }
        });



    }
    $("body").on("click", ".payment-refund", function() {
        var transactionID = $(this).data('transaction-id');
        var transactionMethod = $(this).data('transaction-method');
        var orderID = $(this).data('order-id');


        $.ajax({
            url: "{{ url('transaction/get_payment_receipt_data') }}/",
            data : {
                orderID: orderID,
                transactionID: transactionID,
                transactionMethod: transactionMethod,
                _token : "{{ csrf_token() }}"
            },
            method: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(response) {

                var paymentDetails = response.payment_receipt[0];
                var orderDetails = response.orderDetails;

                let paymentDate = paymentDetails['PaymentDate'];
                let formattedDate = '';

                if (paymentDate) {
                    let dateObj = new Date(paymentDate);
                    let month = ('0' + (dateObj.getMonth() + 1)).slice(-2);
                    let day = ('0' + dateObj.getDate()).slice(-2);
                    let year = dateObj.getFullYear();
                    let hours = ('0' + dateObj.getHours()).slice(-2);
                    let minutes = ('0' + dateObj.getMinutes()).slice(-2);
                    let seconds = ('0' + dateObj.getSeconds()).slice(-2);

                    formattedDate = `${month}-${day}-${year} ${hours}:${minutes}:${seconds}`;
                }

                var discountAmount = 0.00;
                var order_total_amount = orderDetails.sub_total + orderDetails.artwork;

                if (orderDetails.discount_hidation == 1) {
                    if (orderDetails.discountType == 1) {
                        discountAmount = (order_total_amount / 100) * orderDetails.discount;
                    } else if (orderDetails.discountType == 2) {
                        discountAmount = orderDetails.discount;
                    }
                }

                var receiptHTML = `
                            <div style="width: auto; background: #fff; padding: 0px 20px;">
                                <div style="text-align: center; margin-bottom: 20px;">
                                    <h1 style="font-size: 22px; margin: 0; color: #333;">Payment Details</h1>
                                </div>

                                <div style="margin: 20px 0;">
                                    <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Transaction Details</div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Date:</div>
                                        <div style="color: #333;">${formattedDate}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Order ID:</div>
                                        <div style="color: #333;">#${orderDetails.order_no}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Transaction ID:</div>
                                        <div style="color: #333;">${paymentDetails['TransactionId']}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Customer Name:</div>
                                        <div style="color: #333;">${paymentDetails['NameonCard']}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Payment Method:</div>
                                        <div style="color: #333;">${paymentDetails['Method']}</div>
                                    </div>

                                    ${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal') ? `
                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Amount Paid ($):</div>
                                        <div style="color: #333;">${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal' ? (paymentDetails['Amount'] * 100 / 103) : paymentDetails['Amount']).toFixed(2)}</div>
                                    </div>
                                    ` : ``}

                                    ${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal') ? `
                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Processing Fee Paid (3%) ($):</div>
                                        <div style="color: #333;">${(paymentDetails['Amount'] * 3 / 103 || 0).toFixed(2)}</div>
                                    </div>
                                    ` : ``}

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Total amount Paid ($):</div>
                                        <div style="color: #333;">${(paymentDetails['Amount'] || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Status:</div>
                                        <div style="${paymentDetails['is_approve'] == 1 ? 'color:green' : 'color:red'};">${paymentDetails['is_approve'] == 1 ? 'Approved' : 'Not Approved'}</div>
                                    </div>
                                </div>

                                <div style="margin: 20px 0;">
                                    <div style="font-size: 16px; font-weight: bold; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 15px;">Order Summary</div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: black;">Invoice Amount ($):</div>
                                        <div style="color: black;">${(orderDetails.sub_total || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Artwork & Other Fees ($):</div>
                                        <div style="color: #333;">${(orderDetails.artwork || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Discount ($):</div>
                                        <div style="color: #333;">${discountAmount.toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: black;">Total invoice amount ($):</div>
                                        <div style="color: black;">${(orderDetails.artwork + orderDetails.sub_total - discountAmount).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Sales Tax (${orderDetails.organization_details.sales_tax}%) ($):</div>
                                        <div style="color: #333;">${(orderDetails.sales_tax || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Shipping ($):</div>
                                        <div style="color: #333;">${(orderDetails.shipping || 0).toFixed(2)}</div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; padding: 10px 0; font-size: .9rem;">
                                        <div style="font-weight: bold; color: black;">Grand total ($):
                                            <p style="color: grey; font-weight: 100; font-size: .7rem; margin: 0;">(Invoice amount + Sales Tax + shipping)</p>
                                        </div>
                                        <div style="color: black; font-weight: bold;">${orderDetails.order_total.toFixed(2)}</div>
                                    </div>

                                    ${paymentDetails['total_payment'] > 0 ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Paid Amount ($):</div>
                                            <div style="color: #333;">${(paymentDetails['total_payment'] || 0).toFixed(2)}</div>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Paid Processing Fee ($):</div>
                                            <div style="color: #333;">${(paymentDetails['ProcessingFee'] || 0).toFixed(2)}</div>
                                        </div>
                                    ` : ``}

                                    ${paymentDetails['balance_to_be_paid'] > 0 ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: black;">Balance to Pay ($):</div>
                                            <div style="color: black;">${paymentDetails['balance_to_be_paid'].toFixed(2)}</div>
                                        </div>
                                    ` : ``}

                                    <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                        <div style="font-weight: bold; color: #555;">Order Status:</div>
                                        <div style="color: ${paymentDetails['paymentStatus'] == 'Pending' ? 'grey' : paymentDetails['paymentStatus'] == 'Partial' ? 'red' : paymentDetails['paymentStatus'] == 'Paid' ? 'green' : 'grey'};">${paymentDetails['paymentStatus']}</div>
                                    </div>

                                    ${(paymentDetails['total_payment'] - orderDetails.order_total)  > 0 ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;border-top: 1px solid #707070;border-bottom: 1px solid #707070;">
                                            <div style="font-weight: bold; color: black;">For Refund ($):</div>
                                            <div style="color: black;">
                                                <button type="button" class="btn btn-success btn-sm payment-refund-btn" data-transaction-id="${transactionID}"
                                                data-transaction-method="${transactionMethod}"
                                                data-order-id="${orderID}">
                                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                                </button>
                                                ${(paymentDetails['total_payment'] - orderDetails.order_total).toFixed(2)}
                                            </div>
                                        </div>
                                    ` : ``}

                                </div>

                                <div style="text-align: center; margin: 20px 0;">

                                </div>
                            </div>
                        `;

                        $('#redundModalBody').html(receiptHTML);

                        $('#redundModal').modal('show');
                        $(".se-pre-con").fadeOut('slow');
            },
            complete: function () {
            }
        });


        const cardRefundDetailsUrl = '{{ route("transaction.refund_details") }}';
        const cardRefundSubmitUrl = '{{ route("transaction.refund_excess") }}';

        function formatRefundMoney(value) {
            const amount = parseFloat(value || 0);

            if (Number.isNaN(amount)) {
                return '$0.00';
            }

            return '$' + amount.toFixed(2);
        }

        function escapeRefundHtml(value) {
            return $('<div>')
                .text(value === null || value === undefined ? '' : String(value))
                .html();
        }

        function renderRefundHistory(refunds) {
            const $body = $('#refundHistoryBody');

            if (!Array.isArray(refunds) || !refunds.length) {
                $('#refundHistoryCount').text('0');

                $body.html(
                    '<tr>' +
                        '<td colspan="5" class="text-center text-muted">' +
                            'No refund records.' +
                        '</td>' +
                    '</tr>'
                );

                return;
            }

            $('#refundHistoryCount').text(refunds.length);

            let html = '';

            refunds.forEach(function (refund) {
                const badge =
                    parseInt(refund.is_success || 0, 10) === 1
                        ? '<span class="badge badge-success">Successful</span>'
                        : '<span class="badge badge-danger">Failed</span>';

                html +=
                    '<tr>' +
                        '<td>' + escapeRefundHtml(refund.created_at || '') + '</td>' +
                        '<td>' + escapeRefundHtml(refund.user_name || '') + '</td>' +
                        '<td class="text-right">' + formatRefundMoney(refund.refund_amount) + '</td>' +
                        '<td class="text-right">' + formatRefundMoney(refund.gateway_amount) + '</td>' +
                        '<td class="text-center">' + badge + '</td>' +
                    '</tr>';
            });

            $body.html(html);
        }

        function applyRefundDetails(response) {
            const details = response.payment || {};

            $('#refundPaymentLogId').val(details.payment_log_id || '');
            $('#refundOrderId').val(details.order_id || '');

            $('#cardRefundModalSubtitle').text(
                'Order #' + (details.order_number || details.order_id || '')
            );

            $('#refundGatewayTransaction').text(
                details.gateway_transaction_id || 'N/A'
            );

            $('#refundOriginalGross').text(
                formatRefundMoney(details.original_gross_amount)
            );

            $('#refundRemainingBase').text(
                formatRefundMoney(details.max_refund_amount)
            );

            $('#refundAmount').attr('placeholder', 'Max: ' + formatRefundMoney(details.max_refund_amount));
            $('#refundAmount').attr('max', details.max_refund_amount || 0);

            $('#refundAmount')
                .val('')
                .attr('max', details.max_refund_amount || 0);

            $('#refundGatewayAmount').text('$0.00');

            const maxRefund = parseFloat(details.max_refund_amount || 0);
            const disabled = !maxRefund || maxRefund <= 0;

            $('#refundAmount').prop('disabled', disabled);
            $('#submitCardRefundBtn').prop('disabled', disabled);

            renderRefundHistory(response.refunds || []);

            $('#cardRefundContent').show();
        }

        function loadCardRefundDetails(paymentLogId, orderId) {
            $('#cardRefundContent').hide();
            $(".se-pre-con").fadeIn('slow');

            return $.ajax({
                url: cardRefundDetailsUrl,
                type: 'GET',
                dataType: 'json',
                data: {
                    payment_log_id: paymentLogId,
                    order_id: orderId
                }
            }).done(function (response) {
                if (!response.success) {
                    $('#cardRefundModal').modal('hide');

                    Swal.fire({
                        icon: 'error',
                        title: 'Refund Details',
                        text: response.message || 'Unable to load refund details.'
                    });

                    return;
                }

                applyRefundDetails(response);
            }).fail(function (xhr) {
                const message =
                    xhr.responseJSON && xhr.responseJSON.message
                        ? xhr.responseJSON.message
                        : 'Unable to load refund details.';

                $('#cardRefundModal').modal('hide');

                Swal.fire({
                    icon: 'error',
                    title: 'Refund Details',
                    text: message
                });
            }).always(function () {
                $(".se-pre-con").fadeOut('slow');
            });
        }

        $(document).on('click', '.payment-refund-open', function () {
            const paymentLogId = $(this).data('payment-log-id');
            const orderId = $(this).data('order-id');

            if (!paymentLogId || !orderId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Refund',
                    text: 'Payment or order information is missing.'
                });

                return;
            }

            $('#cardRefundModal').modal('show');

            loadCardRefundDetails(
                paymentLogId,
                orderId
            );
        });

        $(document).on('input', '#refundAmount', function () {
            const baseAmount = parseFloat($(this).val() || 0);

            const grossAmount = Number.isNaN(baseAmount)
                ? 0
                : Math.round((baseAmount * 103 / 100) * 100) / 100;

            $('#refundGatewayAmount').text(
                formatRefundMoney(grossAmount)
            );
        });

        $(document).on('submit', '#cardRefundForm', function (e) {
            e.preventDefault();

            const amount = parseFloat($('#refundAmount').val() || 0);
            const maxAmount = parseFloat($('#refundAmount').attr('max') || 0);

            if (!amount || amount <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Refund Amount',
                    text: 'Enter a refund amount greater than $0.00.'
                });

                return false;
            }

            if (maxAmount > 0 && amount > maxAmount + 0.001) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Refund Amount',
                    text:
                        'Refund amount cannot exceed ' +
                        formatRefundMoney(maxAmount) +
                        '.'
                });

                return false;
            }

            const grossAmount =
                Math.round((amount * 103 / 100) * 100) / 100;

            Swal.fire({
                title: 'Confirm Card Refund',
                html:
                    '<div style="text-align:left;">' +
                        'Refund amount: <strong>' +
                            formatRefundMoney(amount) +
                        '</strong><br>' +
                        'Card refund including 3% fee: <strong>' +
                            formatRefundMoney(grossAmount) +
                        '</strong>' +
                    '</div>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Refund'
            }).then(function (result) {
                if (!(result.isConfirmed || result.value)) {
                    return;
                }

                const $button = $('#submitCardRefundBtn');

                $button.prop('disabled', true);
                $(".se-pre-con").fadeIn('slow');

                $.ajax({
                    url: cardRefundSubmitUrl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        payment_log_id: $('#refundPaymentLogId').val(),
                        order_id: $('#refundOrderId').val(),
                        transaction_method: 'Card',
                        amount: amount
                    }
                }).done(function (response) {
                    if (!response.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Refund Failed',
                            text:
                                response.message ||
                                'Unable to process the refund.'
                        });

                        return;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Refund Successful',
                        text:
                            response.message ||
                            'The card refund was processed successfully.'
                    });

                    if (response.remaining_gross_amount !== undefined) {
                        const paymentLogId =
                            String($('#refundPaymentLogId').val());

                        const $row =
                            $('#transactions_table tbody tr[data-payment-log-id="' +
                                paymentLogId +
                            '"]');

                        if ($row.length) {
                            $row
                                .find('td.amount')
                                .first()
                                .text(
                                    formatRefundMoney(
                                        response.remaining_gross_amount
                                    )
                                );
                        }
                    }

                    loadCardRefundDetails(
                        $('#refundPaymentLogId').val(),
                        $('#refundOrderId').val()
                    );
                }).fail(function (xhr) {
                    const message =
                        xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'An unexpected error occurred while processing the refund.';

                    Swal.fire({
                        icon: 'error',
                        title: 'Refund Failed',
                        text: message
                    });
                }).always(function () {
                    $(".se-pre-con").fadeOut('slow');

                    $button
                        .prop('disabled', false)
                        .html('<i class="fa fa-undo"></i> Refund');
                });
            });

            return false;
        });

    });

</script>
@endsection
