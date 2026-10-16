@extends('layouts.app', ['activePage' => 'order_embellishments_report', 'titlePage' => __('Order Embellishments Report')])

@section('content')
<style>
    .content-position {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    .print_btn {
        padding-right: 3%;
        padding-left: 2%;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .order_sammary_table {
        padding-top: 5px;
        overflow-x: auto;
        padding-left: 15PX;
        padding-right: 15PX;
        padding-bottom: 15px;
    }
    .production_text {
        padding-left: 10px;
        color: rgb(94, 94, 94);
    }
    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid#DEDEDE;
        border-radius: 5px;
        padding-top: 2px;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: black;
        font-weight: 500;
    }
    .filter_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        background-color: #2dce89;
        border: none;
        cursor: pointer;
        color: white !important;
    }
    .excel_btn {
        padding: 5px;
        text-align: center;
        width: 70px;
        border: 1px solid#DEDEDE;
        /* background-color: #c9cecc; */
        cursor: pointer;
        color: rgb(0, 0, 0) !important;
    }

    .table-bottom-details2 {
        color: #020202
    }
    .header-layout {
        margin-bottom: 2rem !important;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .select-border-style{
        border: 1px solid #b3b3b3 !important;
        border-radius: 0rem !important;
    }
    .select2-selection--single{
        background-color: #F8F8F8 !important;
    }
    .d_flex_and_align_center{
        display: flex;
        align-items: center;
    }
    .select-width-style .select2.select2-container.select2-container--default{
        width: 8rem !important;
    }
    .select-width-style-item .select2.select2-container.select2-container--default{
        width: 10rem !important;
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
    .table thead th, .table tbody td {
        padding-top: 0;
        padding-bottom: 0;
    }
    .table tbody td {
        padding-top: 7.5px;
        padding-bottom: 7.5px;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
        bottom: 0.6rem !important;
    }
    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        right: .7rem !important;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
    bottom: .65em;
    }
    table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
</style>
<div class=" mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Order Embellishments Report</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="margin-top: 15px; margin-bottom: 25px; padding-bottom: 20px;">
        <div class="card" style="border: unset;">
            <div class="col-md-12 table-responsive order_sammary_table" style="padding-top: 0px;">
                <table class="table align-items-center" id="order_embellishments_report">

                    <thead style="background-color: rgba(50, 50, 50, 1) !important;">
                        <tr>
                            <th scope="col" class="table_header_text text-left">Order No</th>
                            <th scope="col" class="table_header_text text-left">Organization</th>
                            <th scope="col" class="table_header_text text-center">Sales Rep</th>
                            <th scope="col" class="table_header_text text-center">Ex-Factory Date</th>
                            <th scope="col" class="table_header_text text-left">Factory</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)

                            @php
                                $factoryNames = $order->orderItems
                                    ->pluck('factoryDetails.factory_code')
                                    ->filter()
                                    ->unique()
                                    ->implode(', ');
                            @endphp

                            <tr>
                                <td class="text-left" data-order="{{ $order->id }}">
                                    <a href="{{ url('/order_details/edit/' . $order->id . '/order?active_tab=order') }}" target="_blank" style="text-decoration: underline;color: #2dce89;">{{ $order->order_no ?? $order->id }}</a>
                                </td>

                                <td class="text-left">
                                    <a href="{{ route('organizations.info', ['id' => ($order->organizationDetails)->id]) }}" target="_blank" style="color: rgba(50, 50, 50, 1) !important" class="info" >{{ optional($order->organizationDetails)->organization_name ?? '-' }}</a>
                                </td>

                                <td class="text-center">
                                    @if($order->userDetails)
                                        {{ $order->userDetails->name
                                            ?? trim(
                                                ($order->userDetails->first_name ?? '') . ' ' .
                                                ($order->userDetails->last_name ?? '')
                                            )
                                        }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="text-center"
                                    data-order="{{ $order->ex_factory_date ?? '' }}">

                                    @if(!empty($order->ex_factory_date))
                                        {{ \Carbon\Carbon::parse($order->ex_factory_date)->format('m/d/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="text-left">
                                    {{ $factoryNames ?: '-' }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No embellished orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {
    $('#order_embellishments_report').DataTable({
        paging: true,
        pageLength: 50,
        searching: true,
        ordering: true,

        // First column, descending
        order: [[0, 'desc']],

        info: true,
        lengthChange: true,
        language: {
            search: 'Search:',
            paginate: {
                previous: '<',
                next: '>'
            }
        }
    });
});
</script>
@endsection
