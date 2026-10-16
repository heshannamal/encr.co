<style>

.imagesize{
            max-width: 70%;
}
#customer_address_type:disabled + .select2-container .select2-selection--single .select2-selection__rendered {
    color: #c8c8c8 !important; /* Change the color to gray */
    border: 1px solid #c8c8c8 !important;

}
.card-position {
    width: 109%;
    position: relative;
    left: -6%;
}
.table-border {
    border: none;
    font-size: small;
    border-collapse: revert !important;
}
.order-no-color {
    color: #2dce89;
}
.status-width {
    color: #ffffff !important;
    background-color: #ffae35
}
.sales-rep-color {
    color: #ffffff !important;
    background-color: #2dce89
}
.shipping-table-width {
    width: 96%;
}
.description-width {
    width: 96%;
}
.item-table-top {
    position: relative;
    top: -38px;
}
.price-div-top {
    position: relative;
    top: 14px;
}
.cancel-btn {
    height: 26px;
    width: 24% !important;
    color: white;
    background-color: red;
}
.btn-text {
    font-size: 13px;
    position: relative;
    top: -6px;
    font-weight: 600;
}
.pay-btn {
    height: 26px;
    width: 24% !important;
    color: white !important;
    background-color: rgb(74, 50, 255);
}
.save-btn {
    height: 26px;
    width: 23% !important;
    color: white;
    background-color: rgb(0, 255, 81);
}
.pay-btns-tr{
    position: relative;
    top: 10px;
}
.remove-border {
    border: none;
}
.light-border {
    border-color: #f1f1f1;
    border-radius: 0.25rem;
}
.light-font {
    color: #b4b4b4
}
.date-color {
    color: #2dce89;
}
.date-td-width {
    width: 40%;
}
.date-div-position {
    width: 132%;
}
.date-div-padding {
    padding: unset;
}
.new-address-tx {
    font-size: 7px;
}
.item-add-btn {
    color: white;
    background-color: #3636ff;
    width: 8%;
    height: 25px;
    font-size: 9px;
    border-color: #3636ff;
}
.date-log-info {
    color: white;
    background-color: #3636ff;
    /* width: 68px;
    height: 22px; */
    font-size: 9px;
    border-color: #3636ff;
}
.item-table-border {
    border: none;
}
.view-icon {
    position: relative;
    top: 0px;
}
.icon-table-potision {
    position: relative;
    top: -1px;
}
.item-table-position {
    position: relative;
    left: -3%;
}
.table-width {
    width: 100%;
}
.content-position {
    position: relative;
    top: -75px;
}
.icon-button {
    background-color: transparent;
    border: none;
}
.organization-padding {
    padding: unset;
    padding-left: 21px;
}
.placeholder-color::placeholder {
      /* Change the color here */
      color: rgb(218, 218, 218);
    }
.align-right {
    text-align: right;
}
.item-view-icon {
    height: 2.04rem !important
}
.address-save-btn{
    height: 25px;

}

.eye-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    background-color: #1aff5f !important;
  }
  .swal2-close{
    outline: none !important;
  }


@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
    .ordetails001{
            flex-direction: column;
        }
    .orderdetails001{
        display: inline-block;
            width:100%;
    }
    .orderdate001 {
        max-width: none;
    }
    .orderdetails002{
        max-width: none;
    }
    .item-add-btn{
        width: 20%;
    }
    .invoicein0001{
        width:110px;
    }
    .organization-padding{
        padding-left: 15px;
    }
}
@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) {
    .lordetails001{
        flex-direction: column;
        }
    .lorderdate001 {
        max-width: none;
    }
}
.select2-selection__rendered{
    padding-left: 0px !important;
}
.card .table td, .card .table th{
    padding-right: 1rem !important;
}
.card .table td{
    width: fit-content !important;
    vertical-align: middle;
}
.card-updated{
    background-color: white;
    height: 100%;
}
.border-style{
    border: 1px solid #DEDEDE !important;
    border-radius: 0rem !important;
    color: #717070 !important;
}
.select2-selection__rendered{
    border: 1px solid #DEDEDE;
    border-radius: 0rem !important;
    color: #717070 !important;
    padding-left: 7px !important;
    font-size: 0.8rem !important;
    line-height: 23px !important;
}
.header-style{
    color: black;
    font-size: 1.2rem;
    font-weight: 600;
}
.form-label{
    margin-top: 0.5rem;
    color: black;
    font-size: 0.8rem;
    font-weight: 500;
}
.sub-header-style{
    color: black;
    font-size: 1rem;
    margin-top: 1rem;
    font-weight: 600;
}
.disabled-style{
    background-color: #F8F8F8;
    border: none !important;
    line-height: 14px;
}
.invoice-inputs{
    line-height: 16px;
}
.address-text{
    font-size: 0.8rem;
    color: #8d8d8d;
}
.table-header-style{
    background-color: #717070;
    color: white;
}
.table th, .table td{
    padding: 0rem;
    letter-spacing: 0px !important;
    font-size: 0.75rem;
}
.table td{
    font-weight: 100 !important;
}
tr .select2-selection__rendered {
    border: none !important;
    padding-left: 0px !important;
}
.status-lable{
    background-color: #FFF6CC;
    border-radius: 1rem;
    text-align: center !important;
    padding: 0.2rem;
}
/* .form-control{
    height: calc(1.5rem + 1px);
} */
.hasDatepicker{
    padding: 5px;
    padding-left: 6px;
}
.swal2-confirm{
    border: none !important;
    background-color: #47D6B6 !important;
    border-radius: 0rem !important;
    font-size: .8rem !important;
    padding: .2em 2em !important;
    color: white !important;
    cursor: pointer;
}
.swal2-cancel{
    border: none !important;
    background-color: #b3b3b3 !important;
    border-radius: 0rem !important;
    font-size: .8rem !important;
    padding: .2em 2em !important;
    color: white !important;
    cursor: pointer;
}
.new-dropdown-style{
    height: 25px;
    padding-top: 3px;
}
.swal2-title{
    font-size: 1rem !important;
}
.swal2-input, .swal-input-reason, .swal2-input1, .swal2-input2{
    font-size: 1rem !important;
}
#invoice_summery_table tr{
    height: 30px;
    font-size: .8rem !important;
}
.payment-lable-style{
    text-align: center;
    height: 30px;
    outline: unset;
    border: none;
}
.footer-button-styles{
    border: none !important;
    border-radius: 0rem !important;
    font-size: .8rem !important;
    padding: .7em 2em !important;
    color: white !important;
    cursor: pointer;
    margin: 1%;
}
.onclickAncTag:hover {
    text-decoration: underline #4E4C4C;
}
.modal-body tr .select2-selection__rendered {
    border: 1px solid #B3B3B3 !important;
    padding-left: 8px !important;
}
.ui-datepicker {
    position: fixed !important;
}

.discount_row {
            display: none; /* Initially hide the row */
        }

.remake_items_bg{
        background-color: #f8ff90
    }
.select2-container--default .select2-selection--single{
    background-color: unset;
}
.item_disable{
    pointer-events: none;
}


#product_table_body .select2-selection__rendered {
    color: rgba(22, 22, 23, 1) !important;
}
body {
    font-family: 'Open Sans', 'sans-serif' !important;
}
.visit-button{
    width: 100%;
    font-size: .7rem;
    background-color: #8be0ff;
    color: white;
    border: none;
    box-shadow: 2px 2px #e7e7e7;
    cursor: pointer;
    outline: unset;
    height: 77%;
}
.disable-cancel-btn {
    cursor: no-drop !important; /* Show that the button is disabled */
    opacity: 0.5; /* Make the button appear faded */

}
#footer-button-styles-save:disabled{
    background-color: #adb5bd;
}
#footer-button-styles-save{
    background-color: #47D6B6;
}
.swal2-popup {
    width: 40em;
}
.class-for-status-validation:hover{
    text-decoration: underline !important;
}
.swal2-popup .swal2-title {
    font-size: 1.5rem !important;
}
.hide_test_print_col{
    display: none;
}
    .Mobile_roster_import {
        display: none;
    }
    .mobile_add_item_btn {
        display: none;
    }
    .desktop_add_item_btn {
        display: block;
    }

@media (max-width:768px){
    .mobile_card_div {
        box-shadow: 0px 4px 12px 0px #0000000D;
        border-radius: 8px !important;
        border: 1px solid #E5E7EB !important;
    }
    .mobile_shiping_div_1 {
        padding: 20px 0px !important;
    }
    .mobile_shiping_div_2 {
        margin-right: 10px !important;
        margin-left: unset !important;
    }
    .mobile_card_header {
        padding-bottom: 8px;
        border-bottom: 0.5px solid rgba(128, 128, 128, 0.19);
    }
    .mobile_text_left {
        text-align: left !important;
        padding-left: unset;
    }
    .monile_phone_div {
        left: 30px;
        margin-top: unset !important;
        width: 93%;
        max-width: 93%;
    }
    .mobile_phone_index_div {
        padding-top: 8px !important;
    }
    .mobile_timeline_div {
        margin-left: unset !important;
        margin-right: 10px;
    }
    .mobile_description_div {
        margin-right: 10px;
    }

    .mobile-item-card{
        background:#fff;
        /* border-radius:12px; */
        padding:15px;
        margin-bottom:12px;
        box-shadow:0 2px 8px rgba(0,0,0,.08);
    }

    .mobile-item-header{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        margin-bottom:12px;
    }

    .mobile-status{
        /* padding:4px 10px; */
        border-radius:20px;
        font-size:12px;
        font-weight:600;
    }

    .mobile-row{
        display:flex;
        justify-content:space-between;
        gap:15px;
        padding:8px 0;
        border-bottom:1px solid #eee;
    }

    .mobile-row span{
        color:#777;
        font-size:13px;
    }

    .mobile-row strong{
        text-align:right;
        max-width:55%;
    }

    .mobile-item-actions{
        display:flex;
        justify-content:flex-end;
        gap:15px;
    }

    .mobile-item-actions button,
    .mobile-item-actions a{
        border:none;
        background:none;
        color:#333;
        font-size:16px;
    }
    .mobile-item-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:10px;
    }

    .mobile-item-header > div:first-child{
        flex:1;
    }

    .mobile-item-actions{
        display:flex;
        align-items:center;
        gap:3px;
        flex-shrink:0;
    }

    .mobile-item-actions a,
    .mobile-item-actions button{
        width:32px;
        height:32px;
        display:flex;
        align-items:center;
        justify-content:center;
        border:none;
        background:none;
        padding:0;
    }
    .mobile_product_name {
        font-size: 14px;
    }
    .mobile_product_color {
        color: gray;
    }
    .mobile-label {
        color: #9CA3AF;
        font-size: 11px;
    }
    .mobile_total_price {
        padding: 7px 10px;
        background-color: rgba(196, 196, 196, 0.17);
        border-radius: 5px;
    }
    .mobile_roster_upload_div_1 {
        padding-left: unset;
        padding-right: 10px;
    }
    .mobile_roster_upload_div_2 {
        margin-right: unset;
        background-color: white;
        padding: 15px;
    }
    .Mobile_roster_import {
        display: block;
    }
    .mobile_roster_upload_div_3 {
        padding-top: 15px;
    }
    .mobile_roster_upload_div_4 {
        width: 100% !important;
    }
    .mobile_import_roster_text {
        float: unset !important;
        margin-left: unset !important;
        padding-top: 15px;
        color: gray;
    }
    .mobile_roster_download_btn {
        background-color: #F3F4F6 !important;
        color: #374151;
        border: 0.5px solid #D1D5DB !important;
        border-radius: 5px !important;
    }
    .mobile_margin_top_unset {
        margin-top: unset !important;
        font-size: 20px;
    }
    .footer-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .footer-btn {
        width: 22%;
        font-size: 10px !important;
        margin: unset;
        padding: .7em !important;
        border-radius: 4px !important;
    }
    .footer-button-styles {
        /* padding: unset !important; */
        font-size: 10px !important;
    }
    .mobile_invoice_summery_table {
        width: 100%;
    }
    .mobile_add_item_btn {
        display: block;
    }
    .desktop_add_item_btn {
        display: none;
    }
    .ui-datepicker,
    .datepicker-dropdown {
        z-index: 999999 !important;
        top: 55% !important;
        right: 10% !important;
        transform: translateY(5px) !important;
    }
    .datepicker-dropdown {
        top: auto !important;
        left: 0 !important;
        transform: translateY(5px) !important;
    }
    .mobile_12_col_3 {
        padding: 0px 13px;
    }
    .visit-button .visit-text {
        display: none;
    }

    .visit-button {
        padding: 6px 10px;
    }
}

#product_table_body .order-item-row {
    cursor: move;
}

#product_table_body .order-item-row.dragging {
    opacity: 0.6;
}

.item-reorder-cell {
    width: 28px;
    text-align: center;
    padding: 0 4px !important;
}

.item-reorder-handle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    cursor: grab;
    font-size: 0.95rem;
    line-height: 1;
    user-select: none;
}

.item-reorder-handle:active {
    cursor: grabbing;
}

#product_table_body .item-drop-zone td {
    padding: 0 !important;
    border: 0 !important;
}

#product_table_body .item-drop-zone-line {
    height: 4px;
    margin: 2px 0;
    border-radius: 999px;
    background: #47D6B6;
}
.toggle-studio-items-btn {
    background-color: #67cce3 !important;
    border-color: #67cce3 !important;
    margin-right: 8px;
 }

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
@media (max-width:768px){
    .flatpickr-calendar {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,.15);
        border: none;
    }

    .flatpickr-months {
        padding: 10px;
    }

    .flatpickr-weekday {
        font-weight: 600;
    }

    .flatpickr-day {
        border-radius: 50%;
    }

    .flatpickr-day.selected {
        background: #2563eb;
        border-color: #2563eb;
    }

    .flatpickr-day:hover {
        background: #e8f0ff;
    }

    /* @media(max-width:576px){ */
        .flatpickr-calendar {
            width: 320px;
            /* left: 2.5% !important; */
        }
    /* } */
}
</style>
{{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" id="jquery"></script> --}}

{{-- <script>
    var jq = jQuery.noConflict();
    // From this point onward, use "jq" instead of "$" for jQuery code

    jq(document).ready(function() {
      // Your jQuery code here
      jq("#myElement").fadeIn();
    });
</script> --}}


{{-- <nav>
    <div class="nav nav-tabs nav-fill" id="nav-tab2" role="tablist">

        @can('view order details')
            <a class="nav-item nav-link @if(Gate::check('view order details') && request()->get('item') == null) active @endif nav-tab-item" id="invoice-tab2" data-toggle="tab" href="#invoice_tab2" role="tab"
                aria-controls="invoice" aria-selected="true">Order Details</a>
        @endcan

        @can('view order items')
            @foreach ($orderDetails as$orderDetail)
                @foreach ($orderDetail->orderItems as $key=>$orderItem)
                    @if (request()->get('item') != null && $key == request()->get('item'))
                        <a class="nav-item nav-link  @if(Gate::check('view order items') && request()->get('item') != null && $key == request()->get('item')) active @endif nav-tab-item" id="tab_{{ $orderItem->id }}_link" data-toggle="tab" formID="{{ $orderItem->id }}"
                            href="#tab_{{ $orderItem->id }}" role="tab" aria-controls="tab_{{ $orderItem->product_id }}" data-RosterForm="orderRoster_{{ $orderItem->id }}" aria-selected="true"

                            onclick="itemTabClick({{ $orderItem->id }});">

                            {{ $orderItem->productDetails['product_name'] }}
                        </a>
                    @else
                        <a class="nav-item nav-link nav-tab-item" formID="{{ $orderItem->id }}"
                            href="{{ url()->current().'?item='.$key.'&iid='.$orderItem->id }}" role="tab" aria-controls="tab_{{ $orderItem->product_id }}" aria-selected="true" onclick="loadingStart()">
                            {{ $orderItem->productDetails['product_name'] }}
                        </a>
                    @endif

                    <input type="hidden" id="productID_{{ $orderItem->id }}" value="{{$orderItem->product_id}}"/>
                    <input type="hidden" id="selectedFabricID_{{ $orderItem->id }}" value="{{$orderItem->fabric_id}}"/>
                    <input type="hidden" id="selectedEmbellishmentID_{{ $orderItem->id }}" value="{{$orderItem->embellishment_type_id}}"/>
                    <input type="hidden" id="selectedAttributeIDs_{{ $orderItem->id }}" value="{{$orderItem->orderItemAttributes}}"/>

                @endforeach
            @endforeach
        @endcan

    </div>
</nav> --}}



<div class="tab-content py-3 px-3 px-sm-0 content-position" id="nav-tabContent">
    {{-- Invoice Tab --}}
    @can('view order details')

    <div class="tab-pane fade @if(Gate::check('view order details') && request()->get('item') == null) show active @endif" id="invoice_tab" role="tabpanel" aria-labelledby="invoice-tab">
        <form action="{{ route('orders.update') }}" method="post" id="order_detail_form">
            @csrf


            @foreach ($orders as $order)
                <input type="hidden" id="order_id" name="id" value="{{ $order->id }}" />
                <input type="hidden" id="order_type" name="order_type" value="{{ $order->order_type }}" />
                <input type="hidden" id="address_type" name="address_type" value="{{ $order->address_type }}" />

                @section('order-header')
                    <span style="font-size: 17px;">{{ $order->order_no }} -
                    @foreach ($organizations as $organization)
                        @if ($organization->id == $order->organizationDetails['id'])
                        {{ $organization->organization_name }}
                        <input type="hidden" id="get_organization_name" value="{{ $organization->organization_name }}">
                        @endif
                    @endforeach
                    @php $breakAll = false; @endphp
                    @foreach ($order->orderItems as $orderItem)
                        @foreach ($orderDetails as $orderDetail)
                            @foreach ($orderDetail->orderItems as $key=>$orderItem1)
                                @if ($orderItem1->id == $orderItem->id)
                                    @if ($orderItem1->has_remake_item == 1)
                                        - Remake
                                        @php $breakAll = true; @endphp
                                        @break(2)
                                    @endif
                                @endif
                            @endforeach
                            @if ($breakAll) @break @endif
                        @endforeach
                        @if ($breakAll) @break @endif
                    @endforeach
                </span>
                @endsection

                <div class="row mb-1 mobile_order_details_div" style="width: 109%;left: -4%;position: relative;">
                    <div class="col-lg-4" style="padding: 0%">
                        <div class="card-updated mobile_card_div" style="margin-right:10px">
                            <div class="row" style="padding: 1rem;min-height: 18.9rem;">
                                <div class="col-md-12 header-style mobile_card_header">
                                    Order
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="order_no" class="form-label">Order #</label>
                                    <input class="form-control border-style disabled-style"  name="order_no" id="order_no" type='text' data-AlradySaved="{{ $order->order_no }}" value='{{ $order->order_no }}' readonly />
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="order_status_id" class="form-label">Status</label>
                                    <select class="invoice-inputs border-style" name="order_status_id" data-AlradySaved="{{ $order->statusDetails['id'] }}"  data-AlradySave="{{ $order->statusDetails['id'] }}" @if($order->statusDetails['id'] == 8 || $order->statusDetails['id'] == 4) disabled @endif
                                        id="order_status_id" required>
                                        <option value="">Select a Status</option>
                                        @foreach ($orderStatuses as $orderStatus)
                                            <option value="{{ $orderStatus->id }}" @if ($orderStatus->id == $order->statusDetails['id']) selected @endif  {{ ( $orderTrait->isStatusEditable($orderStatus->id, $order->statusDetails['id']) ) ? '' : 'disabled' }}>
                                                {{ $orderStatus->status_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-12 row">
                                    <label for="organization_id" class="form-label ml-3">Organization</label>
                                    <div class="col-10 col-md-10">
                                        <select class="invoice-inputs border-style" name="organization_id" data-AlradySaved="{{ $order->organizationDetails['id'] }} "
                                            id="organization_id" required>
                                            <option value="">Select an Organization</option>
                                            @foreach ($organizations as $organization)
                                                <option value="{{ $organization->id }}" data-plstatus="{{$organization->pl_status}}" @if ($organization->id == $order->organizationDetails['id']) selected @endif>
                                                    {{ $organization->organization_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2 col-md-2" style="padding:0px">
                                        {{-- <button class="visit-button" type="button" onclick="window.open('{{ route('organizations.info', ['id' => $order->organizationDetails['id']]) }}', '_blank');">VISIT <i class="fa fa-external-link" aria-hidden="true"></i></button> --}}
                                        <button class="visit-button" type="button"
                                            onclick="window.open('{{ route('organizations.info', ['id' => $order->organizationDetails['id']]) }}', '_blank');">
                                            <span class="visit-text">VISIT</span>
                                            <i class="fa fa-external-link" aria-hidden="true"></i>
                                        </button>
                                        {{-- <a style="color: #909090" href="{{ route('organizations.info', ['id' => $order->organizationDetails['id']]) }}" target="_blank"><i class="fa fa-external-link mt-1" aria-hidden="true"></i></a> --}}
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="user_id" class="form-label">Sales rep</label>
                                    {{-- <input type="hidden" name="user_id" value="{{ $order->userDetails['id'] }}" id="user_id"> --}}
                                    <select class="invoice-inputs border-style" name="user_id" id="user_id" required>
                                        <option value="">Select a Sales Rep</option>
                                        @foreach ($Sales_rep_users as $user)
                                                <option value="{{ $user->id }}" @if ($user->id == $order->userDetails['id']) selected @endif>
                                                    {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 col-md-6">
                                    <label for="order_procesing_user_id" class="form-label">Order Procesing rep</label>
                                    <select class="invoice-inputs border-style" name="order_procesing_user_id"
                                        id="order_procesing_user_id" required>
                                        <option value="">Select a Order Processing Rep</option>
                                        @foreach ($Sales_rep_users as $user)
                                                <option value="{{ $user->id }}" @if ($user->id == $order->order_procesing_user_id) selected @endif>
                                                    {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($order->is_reordered == 1)
                                <div class="col-md-6 mt-2">
                                    <label for="order_reference" class="form-label">Order Reference #</label>
                                    <input class="invoice-inputs border-style" type='text' value="{{ $order->order_ref_no }}" data-AlradySaved="{{ $order->order_ref_no }}" readonly/></td>
                                </div>
                                @endif
                                <div class="col-md-5 mt-2">
                                    <label for="add_discount" class="form-label" style="margin-right: 5px;">Add Discount</label>
                                    <input type="checkbox" class="add_discount" id="add_discount" name="add_discount" value="1" onchange="toggleDiscountRow(true)" {{ $order->discount_hidation == 1 ? 'checked' : '' }}>
                                </div>
                                <div class="col-md-7 mt-2" title="Mark as White Labeling Order">
                                    <label for="add_plorder" class="form-label" style="margin-right: 5px;">White Labeling Orders</label>
                                    <input type="hidden" name="add_plorder" value="0">
                                    <input type="checkbox" class="add_plorder" id="add_plorder" name="add_plorder" value="1" {{ $order->plorder == 1 ? 'checked' : '' }}>
                                </div>
                                <div class="col-md-7 mt-2" title="Mark as Write-Off Order">
                                    <label for="add_plorder" class="form-label" style="margin-right: 5px;">Write-Off Order</label>
                                    <input type="hidden" name="write_off_order" value="0">
                                    <input type="checkbox" class="add_plorder" id="write_off_order" name="write_off_order" value="1" {{ $order->write_off_order == 1 ? 'checked' : '' }}>
                                </div>
                                {{-- @if (str_starts_with($order->order_no, 'TSR'))
                                    <div class="col-md-12 mt-2" title="Collect Payment via EC">
                                        <label for="collect_payment_via_ec" class="form-label" style="margin-right: 5px;">Collect Payment via EC</label>
                                        <input type="checkbox" class="collect_payment_via_ec" id="collect_payment_via_ec" name="collect_payment_via_ec" {{ $order->collect_payment_via_ec == 1 ? 'checked' : '' }}>
                                    </div>
                                @endif --}}
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 mobile_shiping_div_1" style="padding: 0%">
                        <div class="card-updated mobile_shiping_div_2 mobile_card_div" style="margin-left: 5px;margin-right:5px">
                            <div class="row" style="padding: 1rem;min-height: 18.9rem;">
                                <div class="col-md-12 header-style mobile_card_header">
                                    Shipping Details
                                </div>
                                @if ($order->order_type == 1)
                                <div class="col-md-7 mt-3">
                                    <div class="custom-control custom-checkbox shipping-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            name="shipping_direct_ship_to_customers"
                                            id="shipping_direct_ship_to_customers"
                                            @if ($order->address_type == 1) checked @endif
                                        />
                                        <label class="custom-control-label" for="shipping_direct_ship_to_customers">Direct Ship to Customers&nbsp;</label>
                                    </div>
                                </div>
                                <div class="col-md-5 mt-3">
                                    <div class="custom-control custom-checkbox shipping-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            name="shipping_pick_up"
                                            id="shipping_pick_up"
                                            @if ($order->address_type == 3) checked @endif
                                        />
                                        <label class="custom-control-label" for="shipping_pick_up">Pick Up&nbsp;</label>
                                    </div>
                                </div>
                                <div class="col-md-7 mb-2">
                                    <div class="custom-control custom-checkbox shipping-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            name="shipping_bulk_ship_to_coach"
                                            id="shipping_bulk_ship_to_coach"
                                            @if ($order->address_type == 2) checked @endif
                                        />
                                        <label class="custom-control-label" for="shipping_bulk_ship_to_coach">Bulk Ship to Coach&nbsp;</label>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-2">
                                    <div class="custom-control custom-checkbox shipping-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            name="shipping_direct_pick_up"
                                            id="shipping_direct_pick_up"
                                            @if ($order->address_type == 4) checked @endif
                                        />
                                        <label class="custom-control-label" for="shipping_direct_pick_up">Direct & Pick Up&nbsp;</label>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12 row">
                                    <label for="customer_id" class="form-label ml-3">Customer name</label>
                                        <div class="col-10 col-md-10">
                                            <select name="customer_id" id="customer_id" data-AlradySaved="{{ $order->contactDetails }}"
                                                class="invoice-inputs border-style new-dropdown-style"  required>
                                                <option value="0"  disabled>Select Customer</option>

                                                @foreach ($order->contactOrganizations as $contactOrgs)
                                                    @foreach ($contactOrgs->contacts as $contact)
                                                        <option value="{{ $contact->id }}" @if ($contact->id == $order->contactDetails->id) selected @endif>
                                                            {{ $contact->first_name ?? '' }}
                                                            {{ $contact->last_name ?? '' }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2 col-md-2" style="padding: 0px">
                                            <button class="visit-button" type="button" onclick="window.open('{{ route('people.info', ['id' => $order->contactDetails->id]) }}', '_blank');">
                                                <span class="visit-text">VISIT</span>
                                                &nbsp;<i class="fa fa-external-link" aria-hidden="true"></i></button>
                                        </div>
                                </div>
                                <div class="col-md-5 form-label mt-2">
                                    Shipping Address
                                </div>
                                {{-- <div class="col-md-5" style="color: #717070;text-align: end;font-size: .7rem;font-weight: 700;margin-top: 1.2rem;cursor: pointer;" onclick="mynewscripy()">
                                    SHIPPING DETAIL
                                </div> --}}
                                <div class="col-md-7 form-label">
                                    <select name="customer_address_type" id="customer_address_type" class="invoice-inputs border-style new-dropdown-style"  required>
                                        <option value="2"@if ($order->is_new_shipping_address == 2) selected  @endif>Primary</option>
                                        <option value="3" @if ($order->is_new_shipping_address == 3) selected  @endif >Secondary</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mt-2">

                                    <div class="row">
                                        <div class="col-6 mb-1">
                                            <div class="row pl-2 pt-1">
                                                <div class="custom-control custom-checkbox shipping-checkbox"><input
                                                    type="checkbox"
                                                    class="custom-control-input"
                                                    id="new_shipping_address" name="new_shipping_address"
                                                    @if ($order->is_new_shipping_address == 1)
                                                        value="1" checked
                                                    @else
                                                        value="0"
                                                    @endif
                                                />
                                                    <label class="custom-control-label " style="font-size: 9px !important" for="new_shipping_address">New Address</label>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-1 d-flex flex-row-reverse">
                                            <button type="button" style="display:none;font-size: .54rem !important" id="address_save_btn" class="swal2-confirm address-save-btn" >Save Address</button>
                                        </div>
                                    </div>


                                </div>
                                {{-- Showing address --}}
                                {{-- <div class="col-md-12 address-text mt-1">
                                    <span id="address_text_1"></span>
                                </div>
                                <div class="col-md-12 address-text">
                                    <span id="address_text_2"></span>&nbsp;<span id="address_text_3"></span>
                                </div> --}}


                                <input type="hidden" id="shipping_existing_custmer" value="{{$order->contact_id}}" />
                                <input type="hidden" id="shipping_existing_address" value="{{$order->is_new_shipping_address}}" />
                                <input type="hidden" id="shipping_address_type" value="{{$order->address_type}}" />

                                {{-- <div class="col-md-12 form-label mb-2">
                                    Contact Details
                                </div>
                                <div class="col-md-12 address-text">
                                    <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;&nbsp;<span id="phone_text_1"></span>
                                </div>
                                <div class="col-md-12 address-text">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;&nbsp;<span id="email_text_1"></span>
                                </div> --}}

                                            {{-- Defaul address --}}

                                <div class="col-md-12 default-address">
                                    <label for="receiver_name" class="form-label ml-1">Receiver name</label>
                                    <input class="invoice-inputs light-border light-font border-style" id="receiver_name" type='text'
                                            @if ($order->is_new_shipping_address == 3)
                                                value="{{ !empty(trim($order->contactDetails->receiver_name2 ?? '')) ? $order->contactDetails->receiver_name2 : trim(($order->contactDetails->first_name ?? '') . ' ' . ($order->contactDetails->last_name ?? '')) }}"
                                            @else
                                                value="{{ !empty(trim($order->contactDetails->receiver_name ?? '')) ? $order->contactDetails->receiver_name : trim(($order->contactDetails->first_name ?? '') . ' ' . ($order->contactDetails->last_name ?? '')) }}"
                                            @endif
                                            readonly style="border: none !important" />
                                </div>
                                <div class="col-md-12 default-address">
                                    <input class="invoice-inputs light-border light-font border-style" id="shipping_address1" type='text'

                                            @if ($order->is_new_shipping_address == 3)
                                                value='{{ $order->contactDetails['apartment2'] ?? '--' }}'
                                            @else
                                                    value='{{ $order->contactDetails['apartment'] ?? '--' }}'
                                            @endif
                                            readonly style="border: none !important" />

                                </div>
                                <div class="col-md-12 default-address">
                                    <input class="invoice-inputs light-border light-font border-style" id="shipping_address2" type='text'

                                            @if ($order->is_new_shipping_address == 3)
                                                value='{{ $order->contactDetails['shipping_street_2'] ?? '--' }}'
                                            @else
                                                    value='{{ $order->contactDetails['shipping_street'] ?? '--' }}'
                                            @endif
                                            readonly style="border: none !important" />

                                </div>
                                <div class="col-md-12 default-address">
                                    <input class="invoice-inputs light-border light-font border-style" id="shipping_address3" type='text'

                                            @if ($order->is_new_shipping_address == 3)
                                                value='{{ $order->contactDetails['shipping_city_2'] ?? '' }} {{ $order->contactDetails['shipping_state_2'] ?? '' }} {{ $order->contactDetails['shipping_zip_2'] ?? '' }}'
                                            @else
                                                value='{{ $order->contactDetails['shipping_city'] ?? '' }} {{ $order->contactDetails['shipping_state'] ?? '' }} {{ $order->contactDetails['shipping_zip'] ?? '' }}'
                                            @endif
                                            readonly style="border: none !important" />

                                </div>
                                <div class="col-md-12 default-address">
                                    <input class="invoice-inputs light-border light-font border-style" id="shipping_address4" type='text'

                                            @if ($order->is_new_shipping_address == 3)
                                                value='{{ $order->contactDetails['shipping_country_2'] ?? '--' }}'
                                            @else
                                                value='{{ $order->contactDetails['shipping_country'] ?? '--' }}'
                                            @endif
                                            readonly style="border: none !important" />

                                </div>
                                <div class="col-md-12 row default-address mt-3 monile_phone_div" style="padding: 0px;">
                                    <div class="col-12 col-md-3 form-label text-right mobile_text_left">
                                        Phone
                                    </div>
                                    <div class="col-12 col-md-9 mobile_phone_index_div" style="padding: 0px;">
                                        <input class="invoice-inputs light-border light-font border-style" id="shipping_address5" type='text'
                                            value='{{ $order->contactDetails['phone_no'] ?? '--' }}' readonly />
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 row default-address mt-1 monile_phone_div" style="padding: 0px;">
                                    <div class="col-md-3 form-label text-right mobile_text_left">
                                        E mail
                                    </div>
                                    <div class="col-12 col-md-9 mobile_phone_index_div" style="padding: 0px;">
                                        <input class="invoice-inputs light-border light-font border-style"  id="shipping_address6" type='text'
                                            value='{{ $order->contactDetails['email'] ?? '--' }}' readonly />
                                    </div>
                                </div>
                                {{-- New address --}}
                                <div class="col-md-12 new-address">
                                    <label for="receiver_name" class="form-label ml-1">Receiver name</label>
                                    @php
                                        $defaultReceiverName = trim(($order->contactDetails->first_name ?? '') . ' ' . ($order->contactDetails->last_name ?? ''));
                                        if ($order->is_new_shipping_address == 1 && !empty(trim($order->receiver_name ?? ''))) {
                                            $receiverNameVal = $order->receiver_name;
                                        } elseif ($order->is_new_shipping_address == 3 && !empty(trim($order->contactDetails->receiver_name2 ?? ''))) {
                                            $receiverNameVal = $order->contactDetails->receiver_name2;
                                        } elseif ($order->is_new_shipping_address == 2 && !empty(trim($order->contactDetails->receiver_name ?? ''))) {
                                            $receiverNameVal = $order->contactDetails->receiver_name;
                                        } else {
                                            $receiverNameVal = $defaultReceiverName;
                                        }
                                        $receiverNameVal = preg_replace('/\s+/', ' ', trim($receiverNameVal));
                                    @endphp
                                    <input class="invoice-inputs light-border light-font placeholder-color border-style" id="receiver_name" name="receiver_name" type='text'
                                        value="{{ $receiverNameVal }}"
                                        placeholder="Receiver Name" />
                                </div>
                                <!-- @if(str_starts_with($order->order_no, 'WL'))
                                    <div class="col-md-12 new-address">
                                        <input class="invoice-inputs light-border light-font placeholder-color border-style" id="wl_receiver_name" name="wl_receiver_name" type='text' value="{{ $order->wl_receiver_name }}"
                                        placeholder="WL Receiver Name" />

                                    </div>
                                @endif -->
                                <div class="col-md-6 new-address mt-1">
                                    <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_Apartment" name="new_Apartment" type='text' value="{{ $order->apartment }}"
                                            placeholder="Apartment/Unit #" />

                                </div>
                                <div class="col-md-6 new-address mt-1">
                                    <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_street" name="new_street" type='text' value="{{ $order->street }}"
                                            placeholder="Street" />

                                </div>
                                <div class="col-md-6 new-address mt-1">
                                    <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_city" name="new_city" type='text' value="{{ $order->city }}"
                                            placeholder="City" />

                                </div>
                                <div class="col-md-6 new-address mt-1">
                                    <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_state" name="new_state" type='text' value="{{ $order->state }}"
                                            placeholder="State" />

                                </div>
                                <div class="col-md-6 new-address mt-1">
                                    <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_postal_code" name="new_postal_code" value="{{ $order->postal_code }}"
                                            type='text' placeholder="Postal Code" />

                                </div>
                                <div class="col-md-6 new-address mt-1">
                                    <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_country" name="new_country" value="{{ $order->country }}"
                                            type='text' placeholder="Country" />

                                </div>
                                {{-- {{dd($order)}} --}}

                                <div class="col-md-12 row new-address mt-3 monile_phone_div" style="padding: 0px;">
                                    <div class="col-md-3 form-label text-right mobile_text_left">
                                        Phone
                                    </div>
                                    <div class="col-md-9" style="padding: 0px;">
                                        <input class="invoice-inputs light-border light-font border-style" id="new_phone_no" name="new_phone_no" value="{{ $order->phone_no }}"
                                                type='text' placeholder='Type Phone number' />
                                    </div>
                                </div>
                                <div class="col-md-12 row new-address mt-1 monile_phone_div" style="padding: 0px;">
                                    <div class="col-md-3 form-label text-right mobile_text_left">
                                        E mail
                                    </div>
                                    <div class="col-md-9" style="padding: 0px;">
                                        <input class="invoice-inputs light-border light-font border-style" id="new_email" name="new_email" type='text' value="{{ $order->email }}"
                                                placeholder='Type Email Address' />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" style="padding: 0%">
                        <div class="card-updated mobile_card_div mobile_timeline_div" style="margin-left: 10px;">
                            <div class="row" style="padding: 1rem;min-height: 18.9rem;">
                                <div class="col-md-12 header-style mobile_card_header">
                                    Timeline
                                </div>
                                <div class="col-md-6 col-6">
                                    <label for="open_date" class="form-label">Quote Created Date</label>
                                    <input type="text" style="outline-color: #e9e9e9;" class="invoice-inputs disabled-style border-style" name="open_date" id="open_date" value='{{ $order->open_date }}' data-AlradySaved="{{ $order->open_date }}" readonly />

                                </div>
                                <div class="col-md-6 col-6">
                                    <label for="due_date" class="form-label">In-Hand Due Date</label>
                                    <i class="fa fa-info-circle" data-toggle="modal" data-target="#modal_inhand_due_date_log" title="In-Hand Due Date Change Log" aria-hidden="true" style="color:#ebeb00; cursor:pointer"></i>
                                    <input type="text" style="outline-color: #e9e9e9;" class="invoice-inputs border-style datepicker" name="due_date" id="due_date" value="{{ $order->due_date }}" data-AlradySaved="{{ $order->due_date }}" />

                                </div>
                                <div class="col-md-6 col-6">
                                    <label for="est_delivery_date" class="form-label">Est Delivery Date</label>
                                    <input type="text" style="outline-color: #e9e9e9;" class="invoice-inputs border-style disabled-style datepicker" name="est_delivery_date" id="est_delivery_date" value='{{ $order->est_delivery_date }}' data-AlradySaved="{{ $order->est_delivery_date }}" readonly />

                                </div>
                                <div class="col-md-6 col-6">
                                    <label for="ex_factory_date" class="form-label">Ex Factory Date</label>
                                    <i class="fa fa-info-circle" data-toggle="modal" data-target="#modal_ex_factory_date_log" title="Ex Factory Date Change Log" aria-hidden="true" style="color:#ebeb00; cursor:pointer"></i>
                                    <input type="text" style="outline-color: #e9e9e9;" class="invoice-inputs border-style datepicker" name="ex_factory_date" id="ex_factory_date" value='{{ $order->ex_factory_date }}' data-AlradySaved="{{ $order->ex_factory_date }}" @if(!Gate::check('edit exfactory')) disabled @endif />
                                </div>



                                <div class="col-md-6 col-6">
                                        @php
                                        if($order->production_date != null){
                                                $orderProductionDate = $order->production_date;
                                            } else {
                                                $orderProductionDate = 'Not in Production';
                                            }
                                            @endphp

                                    <label for="production_date" class="form-label">Sent to Production</label>

                                    <input type="text" class="invoice-inputs border-style disabled-style" name="production_date" id="production_date" value="{{ $orderProductionDate }}" data-AlradySaved="{{ $order->production_date }}" disabled/>

                                </div>
                                <div class="col-md-6 col-6">
                                    <label for="test_print_due_date" class="form-label">Test Print Due Date</label>
                                    <input type="text" style="outline-color: #e9e9e9;" class="invoice-inputs border-style disabled-style datepicker" value="{{ $Order_test_print_due_date }}" disabled />
                                </div>
                                <div class="col-md-6 col-6">
                                    <label for="ex_factory_date" class="form-label">Factory Confirmation</label>
                                    <input type="text" style="outline-color: #e9e9e9;" class="invoice-inputs border-style disabled-style datepicker" @if ($order->factory_confirmation_date != NULL) value='{{ $order->factory_confirmation_date }}' @else value='Not in production'   @endif disabled />
                                </div>
                                <div class="col-md-6 col-6">
                                    <label for="ex_factory_date" class="form-label">Actual Delivery Date</label>
                                    <input type="text" style="outline-color: #e9e9e9;" class="invoice-inputs border-style datepicker" name="actual_delivery_date" id="actual_delivery_date" value='{{ $order->actual_delivery_date }}' data-AlradySaved="{{ $order->actual_delivery_date }}" @if(!Gate::check('edit actual delivery date')) disabled @endif />
                                </div>
                                <div class="col-md-6" @if($order->order_type == 0 || ($order->order_type == 1 && $order->address_type == 2)) style="display: none" @endif>
                                    <label for="encore_packing_date" class="form-label">Encore Packing Date</label>
                                    <input type="text" style="outline-color: #e9e9e9;" class="invoice-inputs date-color remove-border border-style" name="encore_packing_date" id="encore_packing_date" value='{{ $order->encore_packing_date }}' data-AlradySaved="{{ $order->encore_packing_date }}"/>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-3 mb-3" style="padding: 0px;">
                        <div class="card-updated mobile_card_div mobile_description_div">
                            <div class="row" style="padding: 1rem;">
                                <div class="col-md-12 header-style mobile_card_header">
                                    Order Description
                                </div>
                                <div class="col-md-12">
                                    <textarea  class="invoice-inputs light-border orderdetails001" id="order_description" data-AlradySaved="{{ $order->order_description }}"
                                        name="order_description" type='text' rows="4" value=''
                                        style="margin-top: 5px;margin-bottom: 7px; border: 0.1rem solid #f1f1f1"
                                        placeholder="Is there anything else you want to let us know about this order?">{{ $order->order_description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-2 mobile_add_item_btn" style="padding: 0px;">
                        <div class="card-updated card mobile_card_div mobile_description_div" style="border-radius: 0rem; border:none">
                            <div class="row" style="padding: 1rem;">
                                <div class="col-md-12 mb-2 text-right">
                                    @can('view studio item')
                                        <button type="button" class="swal2-confirm toggle-studio-items-btn" onclick="toggleStudioItems()">
                                            <i class="fa fa-eye-slash toggle-studio-icon" aria-hidden="true"></i>&nbsp;&nbsp;<span class="toggle-studio-text">Hide Studio Items</span>
                                        </button>
                                    @endcan
                                    @can('add item to order')
                                        <!-- <button type="button" class="swal2-confirm" id="add_item" onclick="modalShow()"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp; Add Item</button> -->
                                        <button type="button" class="swal2-confirm" id="add_item" data-target="#add_item_modal"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp; Add Item</button>

                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-2" style="padding: 0px;">
                        <div class="card-updated card mobile_card_div mobile_description_div" style="border-radius: 0rem; border:none">
                            <div class="row" style="padding: 1rem;">
                                <div class="col-md-12 mb-2 text-right desktop_add_item_btn">
                                    @can('view studio item')
                                        <button type="button" class="swal2-confirm toggle-studio-items-btn" onclick="toggleStudioItems()">
                                            <i class="fa fa-eye-slash toggle-studio-icon" aria-hidden="true"></i>&nbsp;&nbsp;<span class="toggle-studio-text">Hide Studio Items</span>
                                        </button>
                                    @endcan
                                    @can('add item to order')
                                        <!-- <button type="button" class="swal2-confirm" id="add_item" onclick="modalShow()"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp; Add Item</button> -->
                                        <button type="button" class="swal2-confirm" id="mobile_add_item" data-target="#add_item_modal"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp; Add Item</button>

                                    @endcan
                                </div>
                                <div class="col-md-12 d-none d-md-block">
                                    @php
                                        $class_test_print = 'hide_test_print_col';
                                        foreach ($order->orderItems as $thisItesm) {
                                            if ($thisItesm->test_print_due_date) {
                                                $class_test_print = '';
                                                break;
                                            }
                                        }
                                    @endphp
                                    <table class="table table-responsive table-width" id="order_item_table" style="font-size: 0.7rem !important">
                                    <thead>
                                        <tr class="table-header-style" style="height: 35px;background-color:rgba(22, 22, 23, 1) !important">
                                            <th class="item-reorder-cell"></th>
                                            <th style="display: none">
                                                <div style="background-color: #3636ff;width: 10px;height: 19px; position: relative; left: 10px;"></div>
                                            </th>
                                            <th class="text-left" style="width: 40%;padding-left: 7px !important;">ITEM</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-left">EST DELIVERY</th>
                                            <th class="text-left {{$class_test_print}}">TEST PRINT DUE DATE</th>
                                            <th class="text-left">FACTORY</th>

                                            <th class="text-left">FABRIC</th>
                                            <th class="text-left">EMBELLISHMENT</th>

                                            <th class="text-right">QTY</th>
                                            @if (Gate::check('show order price') && $orderTrait->isNotInventoryOrder($orders[0]->organization_id))
                                                <th class="text-right">UNIT PRICE($)</th>
                                            @endif
                                            @if (Gate::check('show order price') && $orderTrait->isNotInventoryOrder($orders[0]->organization_id))
                                                <th class="text-right">TOTAL($)</th>
                                            @endif
                                            <th class="text-center" style="min-width: 65px;">ACTION</th>
                                        </tr>
                                    </thead>
                                    @php $totalItemQty = 0; @endphp
                                    @php $totalStudioItemQty = 0; @endphp

                                    <!-- <tbody id="product_table_body"> -->
                                    <tbody id="product_table_body" data-order-id="{{ $order->id }}">
                                        <tr><input type="hidden" id="row_no" value="{{count($order->orderItems)}}"/></tr>
                                        @foreach ($order->orderItems as $orderItem)

                                            @foreach ($orderDetails as $orderDetail)
                                                @foreach ($orderDetail->orderItems as $key=>$orderItem1)
                                                    @if ($orderItem1->id == $orderItem->id)
                                                        @php
                                                            if($orderItem->is_studio_item == 0){
                                                                $totalItemQty = $totalItemQty + $orderItem->qty;
                                                            }elseif($orderItem->is_studio_item == 1){
                                                                $totalStudioItemQty = $totalStudioItemQty + $orderItem->qty;
                                                            }
                                                        @endphp

                                                        @php
                                                            $item_attributes = "";

                                                            if(isset($orderItem->orderItemAttributes)){
                                                                foreach ($orderItem->orderItemAttributes as $attribute) {
                                                                    if($item_attributes == ""){
                                                                        $item_attributes = $attribute['attribute']['attribute_name'];
                                                                    }else{
                                                                        $item_attributes = $item_attributes.", ".$attribute['attribute']['attribute_name'];
                                                                    }
                                                                }
                                                            }

                                                        @endphp
                                                        @php
                                                                $Order_item_product = $subProducts->where('sub_product_no', $orderItem->sub_product_no)->first();
                                                                @endphp
                                                        @php
                                                        $product_name = empty($orderItem->display_name) ?
                                                            ($Order_item_product ? $Order_item_product->product_name : $orderItem->productDetails['product_name']) :
                                                            $orderItem->display_name;

                                                        $class_remake = str_ends_with($product_name, '- Remake') ? 'remake_items_bg' : '';
                                                        @endphp
                                                        @php
                                                            $user = auth()->user();

                                                        @endphp
                                                        <!-- <tr class="{{$class_remake}} @if ($user && $user->user_role_id == 6 && $orderItem1->has_remake_item == 1) hidden @endif " @if($orderItem->active == 0) style="background-color: #f3efef;" @endif> -->

                                                        <tr class="order-item-row {{$class_remake}} @if(isset($orderItem->is_studio_item) && $orderItem->is_studio_item == 1) studio-item-row @endif @if ($user && $user->user_role_id == 6 && $orderItem1->has_remake_item == 1) hidden @endif " data-item-id="{{ $orderItem->id }}" draggable="true" @if(isset($orderItem->is_studio_item) && $orderItem->is_studio_item == 1) style="background-color: #d4e9ff;" @elseif($orderItem->active == 0) style="background-color: #f3efef;" @endif>
                                                            <td class="item-reorder-cell">
                                                                <span class="item-reorder-handle" title="Drag to reorder">⋮⋮</span>
                                                            </td>
                                                            <input type="hidden" name="orderItems[{{ $orderItem->id }}][item_id]" value="{{ $orderItem->id }}" />

                                                            <td style="margin:0px;box-sizing:border-box;color:rgba(22, 22, 23, 1) !important;display:none" class="item-view-icon">
                                                                @can('view order items')
                                                                            @if (request()->get('item') != null && $key == request()->get('item'))
                                                                            <a href="http://" ></a>
                                                                                {{-- <button type="button" class="icon-button" data-toggle="modal" data-target="#item_view"> --}}
                                                                                    <a class="eye-btn nav-item nav-link   @if(Gate::check('view order items') && request()->get('item') != null && $key == request()->get('item')) active @endif nav-tab-item" id="tab_{{ $orderItem1->id }}_link" data-toggle="tab" formID="{{ $orderItem1->id }}"
                                                                                        href="#tab_{{ $orderItem1->id }}" role="tab" aria-controls="tab_{{ $orderItem1->product_id }}" data-RosterForm="orderRoster_{{ $orderItem1->id }}" aria-selected="true"
                                                                                        target="_blank" rel="noopener noreferrer"
                                                                                        onclick="itemTabClick({{ $orderItem1->id }});"
                                                                                        id="eyeIconFunc_{{ $orderItem1->id }}"
                                                                                        style="background-color: #909090;
                                                                                            border-radius: 5px;
                                                                                            top: 7px;
                                                                                            width: 30px;
                                                                                            height: 19px;" >
                                                                                        <i class="fas fa-solid fa-eye view-icon" style="color: #ffffff;
                                                                                            position: relative;
                                                                                            top: -2px;
                                                                                            left: -4px;"></i>
                                                                                    </a>
                                                                                {{-- </button> --}}

                                                                            @else
                                                                            {{-- <button type="button" class="icon-button" data-toggle="modal" data-target="#item_view"> --}}
                                                                                <a class="eye-btn nav-item nav-link nav-tab-item" formID="{{ $orderItem1->id }}"
                                                                                    target="_blank" rel="noopener noreferrer"
                                                                                    href="{{ url()->current().'?item='.$key.'&iid='.$orderItem1->id }}" role="tab" aria-controls="tab_{{ $orderItem1->product_id }}" aria-selected="true"
                                                                                    id="eyeIconFunc_{{ $orderItem1->id }}"
                                                                                    style="background-color: #909090;
                                                                                            border-radius: 5px;
                                                                                            top: 7px;
                                                                                            width: 30px;
                                                                                            height: 19px;" >
                                                                                    <i class="fas fa-solid fa-eye view-icon" style="color: #ffffff;
                                                                                        position: relative;
                                                                                        top: -2px;
                                                                                        left: -4px;"></i>
                                                                                </a>
                                                                            {{-- </button> --}}

                                                                            @endif

                                                                            <input type="hidden" id="productID_{{ $orderItem1->id }}" value="{{$orderItem1->product_id}}"/>
                                                                            <input type="hidden" id="sub_roductID{{ $orderItem1->id }}" value="{{$orderItem1->sub_product_no}}"/>
                                                                            <input type="hidden" id="selectedFabricID_{{ $orderItem1->id }}" value="{{$orderItem1->fabric_id}}"/>
                                                                            <input type="hidden" id="selectedEmbellishmentID_{{ $orderItem1->id }}" value="{{$orderItem1->embellishment_type_id}}"/>
                                                                            <input type="hidden" id="selectedAttributeIDs_{{ $orderItem1->id }}" value="{{$orderItem1->orderItemAttributes}}"/>

                                                                @endcan

                                                            </td>

                                                            <td style="padding:6px !important;margin:0px;box-sizing:border-box;color: rgba(22, 22, 23, 1) !important;">

                                                                <input
                                                                    style="width: auto"
                                                                    type="hidden" class="invoice-inputs item-table-border"
                                                                    name="product[{{ $orderItem->id }}][item_name]"
                                                                    value="{{ $orderItem->productDetails['product_name'] }}@if (isset($orderItem->item_description) && ($orderItem->item_description != null || $orderItem->item_description != '')) {{ '- ' . $orderItem->item_description}} @endif"
                                                                    readonly
                                                                />

                                                                @if ($orderItem->active == 1)
                                                                    <a href="{{ route('orderitem.info', ['orderid' => $orderDetail->id, 'orderItemId' => $orderItem->id]) }}" target="_blank" style="background-color: transparent;border:none;outline:unset;cursor: pointer;color:rgba(22, 22, 23, 1) !important;" ><span style="color: #4E4C4C;" class="onclickAncTag">@if(empty($orderItem->display_name)) @if($Order_item_product) {{$Order_item_product->product_name}} @else {{$orderItem->productDetails['product_name']}} @endif @else {{$orderItem->display_name}} @endif</span></a> @if (isset($orderItem->item_description) && ($orderItem->item_description != null || $orderItem->item_description != '')) {{ '- ' . $orderItem->item_description }} @endif
                                                                @else
                                                                <a href="{{ route('missing.products', ['item_ids' => json_encode([$orderItem->id]),'order_id' => json_encode([$orderItem->order_id])]) }}" style="background-color: transparent;border:none;outline:unset;cursor: pointer;color:rgba(22, 22, 23, 1) !important;"><span style="color: #4E4C4C;">@if(empty($orderItem->display_name)) @if($Order_item_product) {{$Order_item_product->product_name}} @else {{$orderItem->productDetails['product_name']}} @endif @else {{$orderItem->display_name}} @endif</span></a> @if (isset($orderItem->item_description) && ($orderItem->item_description != null || $orderItem->item_description != '')) {{ '- ' . $orderItem->item_description }} @endif
                                                                @endif


                                                            </td>




                                                            <td style="width: 80px;">
                                                                @php
                                                                    $statusValue = isset($orderItem->statusDetails['status_name']) ? $orderItem->statusDetails['status_name'] : '';

                                                                    $bgColor = '';
                                                                    $textColor = '';

                                                                    switch ($statusValue) {
                                                                        case 'Quote':
                                                                            $textColor = '#FFB916';
                                                                            $bgColor = '#ffffcc';
                                                                            break;
                                                                        case 'Production':
                                                                            $textColor = '#47D6B6';
                                                                            $bgColor = '#d7ffcc';
                                                                            break;
                                                                        case 'Fulfilled':
                                                                            $textColor = '#717070';
                                                                            $bgColor = '#f8f8f8';
                                                                            break;
                                                                        case 'Canceled':
                                                                            $textColor = '#d65a47';
                                                                            $bgColor = '#ffcccc';
                                                                            break;
                                                                    }
                                                                @endphp
                                                                <input type="text" class="invoice-inputs text-left item-table-border status-lable" style="width: 100px;padding-left: 0px !important; color: {{ $textColor }} !important;background-color:{{$bgColor}} !important;"
                                                                    name="product[{{ $orderItem->id }}][status]"
                                                                    value="@if (isset($orderItem->statusDetails['status_name'])){{ $orderItem->statusDetails['status_name'] }}@endif" readonly />
                                                            </td>
                                                            <td ><input type="text" class="invoice-inputs est-delivery-date item-table-border {{$class_remake}}" style="background-color: transparent;"
                                                                    name="product[{{ $orderItem->id }}][est_delivery_date]"
                                                                    value="{{ $orderItem->est_delivery_date }}" style="text-align: left;padding-left: 0px !important;color: rgba(22, 22, 23, 1) !important;" readonly /></td>
                                                            <td class="{{$class_test_print}}"><input type="text" class="invoice-inputs test_print_due_date item-table-border  {{$class_remake}}"
                                                                        name="product[{{ $orderItem->id }}][test_print_due_date]"
                                                                        value="{{ $orderItem->test_print_due_date }}" style="text-align: left;padding-left: 0px !important;color: rgba(22, 22, 23, 1) !important;" readonly /></td>
                                                            <td style="min-width: 30px;padding-left: .39rem;">
                                                                @php
                                                                    // Extract factory codes from $orderItem->productDetails->factory
                                                                    $product_factory = $orderItem->productDetails->productFactories;
                                                                    $product_factory_ids = [];

                                                                    foreach ($orderItem->productDetails->productFactories as $productFactory) {
                                                                        $product_factory_ids[] = $productFactory->product_factory_id;
                                                                    }
                                                                    // Convert $factories collection to array
                                                                    $factories_array = $factories->toArray();

                                                                    // Filter factories based on $product_factory_codes
                                                                    $filtered_factories = array_filter($factories_array, function ($factory) use ($product_factory_ids) {
                                                                        return in_array($factory['id'], $product_factory_ids);
                                                                    });
                                                                @endphp
                                                                <select class="invoice-inputs select2-edit-order item-table-border item-factory" data-AlradySaved="{{ $orderItem->factory_id }}"
                                                                    name="orderItems[{{ $orderItem->id }}][factory_id]">
                                                                    <option value="">Select Factory</option>
                                                                    @foreach ($filtered_factories as $factory)
                                                                        <option value="{{ $factory['id'] }}" @if ($factory['id'] == $orderItem->factory_id) selected @endif>{{ $factory['factory_code'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>

                                                            <td>

                                                                <input type="text" class="invoice-inputs text-left item-fabric item-table-border {{$class_remake}}" name="product[{{ $orderItem->id }}][fabric]" style="width: fit-content;background-color: transparent;padding-left: 0px !important;color: rgba(22, 22, 23, 1) !important;" value="{{($orderItem->fabricDetails==null)?'':$orderItem->fabricDetails['fabric_name']}}" readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="invoice-inputs text-left item-embellishment item-table-border {{$class_remake}}" style="padding-left: 0px !important;background-color: transparent;color: rgba(22, 22, 23, 1) !important;width:8rem" name="product[{{ $orderItem->id }}][embellishment]" value="{{($orderItem->embellishmentDetails==null)?'':$orderItem->embellishmentDetails['embellishment_name']}}" readonly />

                                                            </td>



                                                            <td><input type="text" style="padding-right: 0px !important;min-width: 30px;background-color: transparent;" class="invoice-inputs text-right {{ $orderItem->is_studio_item == 1 ? 'studio-item-qty' : 'item-qty' }} item-table-border {{$class_remake}}"
                                                                    name="product[{{ $orderItem->id }}][qty]"
                                                                    value="{{ $orderItem->qty }}" readonly /></td>


                                                            @if ($orderTrait->isNotInventoryOrder($order->organization_id))
                                                                @can('show order price')
                                                                    <td><input type="text" class="invoice-inputs text-right {{ $orderItem->is_studio_item == 1 ? 'studio-item-price' : 'item-price' }} item-table-border {{$class_remake}}"  style="width: 100px;padding-right: 0px !important;min-width: 100px;background-color: transparent;"
                                                                            name="product[{{ $orderItem->id }}][unit_price]"
                                                                            value="{{ $orderItem->unit_price }}" readonly /></td>
                                                                @endcan
                                                                @can('show order price')
                                                                    <td><input type="text" class="invoice-inputs text-right item-total item-table-border {{$class_remake}}"  style="width: 100px;padding-right: 0px !important;background-color: transparent;"
                                                                            name="product[{{ $orderItem->id }}][total]"
                                                                            value="{{ $orderItem->total }}" readonly /></td>
                                                                @endcan
                                                            @endif

                                                            <td>
                                                                <button type="button" @if($Order_item_product) onclick="edit_saved_items('{{$Order_item_product->id}}' , {{$orderItem}})" @endif title="Edit" @if(auth()->user()->can('edit_saved_item_directly'))  style="border: none;color: black;background-color: transparent;outline: unset;cursor:pointer" @else  style="border: none;color: #e3e1e1;background-color: transparent;outline: unset;cursor:pointer" disabled  @endif><i class="fas fa-edit"></i></button>
                                                                <button type="button" title="Remake as Studio Item" onclick="remake_as_studio_item({{$orderItem->id}})" @if(auth()->user()->can('edit_saved_item_directly')) style="border: none;color: #17a2b8;background-color: transparent;outline: unset;cursor:pointer" @else style="border: none;color: #e3e1e1;background-color: transparent;outline: unset;cursor:pointer" disabled @endif><i class="fas fa-store"></i></button>
                                                                <button type="button" title="Delete" onclick="delete_saved_item({{$orderItem}})" @if(auth()->user()->can('edit_saved_item_directly'))  style="border: none;color: black;background-color: transparent;outline: unset;cursor:pointer" @else  style="border: none;color: #e3e1e1;background-color: transparent;outline: unset;cursor:pointer" disabled  @endif><i class="fas fa-trash-alt"></i></button>
                                                            </td>

                                                            <input type="hidden"
                                                                name="product[{{ $orderItem->id }}][organization_id]"
                                                                value="{{ $orderItem->organization_id }}" />
                                                            <input type="hidden"
                                                                name="product[{{ $orderItem->id }}][support_agent_id]"
                                                                value="{{ $orderItem->support_agent_id }}" />
                                                            <input type="hidden"
                                                                name="product[{{ $orderItem->id }}][designer_id]"
                                                                value="{{ $orderItem->designer_id }}" />
                                                            <input type="hidden"
                                                                name="product[{{ $orderItem->id }}][shipping_method]"
                                                                value="{{ $orderItem->shipping_method }}" />
                                                            <input type="hidden"
                                                                name="product[{{ $orderItem->id }}][ex_factory_id]"
                                                                value="{{ $orderItem->ex_factory_id }}" />
                                                            <input type="hidden" name="product[{{ $orderItem->id }}][item_no]"
                                                                value="{{ $orderItem->item_no }}" />
                                                            <input type="hidden" name="product[{{ $orderItem->id }}][order_id]"
                                                                value="{{ $orderItem->order_id }}" />
                                                            <input type="hidden"
                                                                name="product[{{ $orderItem->id }}][in_hand_due_date]"
                                                                value="{{ $orderItem->in_hand_due_date }}" />
                                                            <input type="hidden" name="product[{{ $orderItem->id }}][status_id]"
                                                                value="{{ $orderItem->order_status_id }}" />
                                                            <input type="hidden" name="product[{{ $orderItem->id }}][product_id]"
                                                                value="{{ $orderItem->product_id }}" />
                                                            <input type="hidden" name="product[{{ $orderItem->id }}][fabric_id]"
                                                                value="{{ $orderItem->fabric_id }}" />
                                                            <input type="hidden"
                                                                name="product[{{ $orderItem->id }}][embellishment_id]"
                                                                value="{{ $orderItem->embellishment_type_id }}" />
                                                            <input type="hidden" name="product[{{ $orderItem->id }}][sport]"
                                                                value="{{ $orderItem->sport }}" />
                                                            <input type="hidden" name="product[{{ $orderItem->id }}][gender]"
                                                                value="{{ $orderItem->gender }}" />
                                                            <input type="hidden" name="product[{{ $orderItem->id }}][factory_id]"
                                                                value="{{ $orderItem->factory_id }}" />
                                                        </tr>
                                                    @endif

                                                @endforeach
                                            @endforeach
                                        @endforeach
                                        @if (!empty($order->studioOrderItems))
                                            @foreach ($order->studioOrderItems as $orderItem)

                                                @foreach ($orderDetails as $orderDetail)
                                                    @foreach ($orderDetail->studioOrderItems as $key=>$orderItem1)
                                                        @if ($orderItem1->id == $orderItem->id)
                                                            @php
                                                                if($orderItem->is_studio_item == 0){
                                                                    $totalItemQty = $totalItemQty + $orderItem->qty;
                                                                }elseif($orderItem->is_studio_item == 1){
                                                                    $totalStudioItemQty = $totalStudioItemQty + $orderItem->qty;
                                                                }
                                                            @endphp

                                                            @php
                                                                $item_attributes = "";

                                                                if(isset($orderItem->orderItemAttributes)){
                                                                    foreach ($orderItem->orderItemAttributes as $attribute) {
                                                                        if($item_attributes == ""){
                                                                            $item_attributes = $attribute['attribute']['attribute_name'];
                                                                        }else{
                                                                            $item_attributes = $item_attributes.", ".$attribute['attribute']['attribute_name'];
                                                                        }
                                                                    }
                                                                }

                                                            @endphp
                                                            @php
                                                                    $Order_item_product = $subProducts->where('sub_product_no', $orderItem->sub_product_no)->first();
                                                                    @endphp
                                                            @php
                                                            $product_name = empty($orderItem->display_name) ?
                                                                ($Order_item_product ? $Order_item_product->product_name : $orderItem->productDetails['product_name']) :
                                                                $orderItem->display_name;

                                                            $class_remake = str_ends_with($product_name, '- Remake') ? 'remake_items_bg' : '';
                                                            @endphp
                                                            @php
                                                                $user = auth()->user();

                                                            @endphp
                                                            <!-- <tr class="{{$class_remake}} @if ($user && $user->user_role_id == 6 && $orderItem1->has_remake_item == 1) hidden @endif " @if($orderItem->active == 0) style="background-color: #f3efef;" @endif> -->

                                                            <tr class="order-item-row {{$class_remake}} @if(isset($orderItem->is_studio_item) && $orderItem->is_studio_item == 1) studio-item-row @endif @if ($user && $user->user_role_id == 6 && $orderItem1->has_remake_item == 1) hidden @endif " data-item-id="{{ $orderItem->id }}" draggable="true" @if(isset($orderItem->is_studio_item) && $orderItem->is_studio_item == 1) style="background-color: #d4e9ff;" @elseif($orderItem->active == 0) style="background-color: #f3efef;" @endif>
                                                                <td class="item-reorder-cell">
                                                                    <span class="item-reorder-handle" title="Drag to reorder">⋮⋮</span>
                                                                </td>
                                                                <input type="hidden" name="orderItems[{{ $orderItem->id }}][item_id]" value="{{ $orderItem->id }}" />

                                                                <td style="margin:0px;box-sizing:border-box;color:rgba(22, 22, 23, 1) !important;display:none" class="item-view-icon">
                                                                    @can('view order items')
                                                                                @if (request()->get('item') != null && $key == request()->get('item'))
                                                                                <a href="http://" ></a>
                                                                                    {{-- <button type="button" class="icon-button" data-toggle="modal" data-target="#item_view"> --}}
                                                                                        <a class="eye-btn nav-item nav-link   @if(Gate::check('view order items') && request()->get('item') != null && $key == request()->get('item')) active @endif nav-tab-item" id="tab_{{ $orderItem1->id }}_link" data-toggle="tab" formID="{{ $orderItem1->id }}"
                                                                                            href="#tab_{{ $orderItem1->id }}" role="tab" aria-controls="tab_{{ $orderItem1->product_id }}" data-RosterForm="orderRoster_{{ $orderItem1->id }}" aria-selected="true"
                                                                                            target="_blank" rel="noopener noreferrer"
                                                                                            onclick="itemTabClick({{ $orderItem1->id }});"
                                                                                            id="eyeIconFunc_{{ $orderItem1->id }}"
                                                                                            style="background-color: #909090;
                                                                                                border-radius: 5px;
                                                                                                top: 7px;
                                                                                                width: 30px;
                                                                                                height: 19px;" >
                                                                                            <i class="fas fa-solid fa-eye view-icon" style="color: #ffffff;
                                                                                                position: relative;
                                                                                                top: -2px;
                                                                                                left: -4px;"></i>
                                                                                        </a>
                                                                                    {{-- </button> --}}

                                                                                @else
                                                                                {{-- <button type="button" class="icon-button" data-toggle="modal" data-target="#item_view"> --}}
                                                                                    <a class="eye-btn nav-item nav-link nav-tab-item" formID="{{ $orderItem1->id }}"
                                                                                        target="_blank" rel="noopener noreferrer"
                                                                                        href="{{ url()->current().'?item='.$key.'&iid='.$orderItem1->id }}" role="tab" aria-controls="tab_{{ $orderItem1->product_id }}" aria-selected="true"
                                                                                        id="eyeIconFunc_{{ $orderItem1->id }}"
                                                                                        style="background-color: #909090;
                                                                                                border-radius: 5px;
                                                                                                top: 7px;
                                                                                                width: 30px;
                                                                                                height: 19px;" >
                                                                                        <i class="fas fa-solid fa-eye view-icon" style="color: #ffffff;
                                                                                            position: relative;
                                                                                            top: -2px;
                                                                                            left: -4px;"></i>
                                                                                    </a>
                                                                                {{-- </button> --}}

                                                                                @endif

                                                                                <input type="hidden" id="productID_{{ $orderItem1->id }}" value="{{$orderItem1->product_id}}"/>
                                                                                <input type="hidden" id="sub_roductID{{ $orderItem1->id }}" value="{{$orderItem1->sub_product_no}}"/>
                                                                                <input type="hidden" id="selectedFabricID_{{ $orderItem1->id }}" value="{{$orderItem1->fabric_id}}"/>
                                                                                <input type="hidden" id="selectedEmbellishmentID_{{ $orderItem1->id }}" value="{{$orderItem1->embellishment_type_id}}"/>
                                                                                <input type="hidden" id="selectedAttributeIDs_{{ $orderItem1->id }}" value="{{$orderItem1->orderItemAttributes}}"/>

                                                                    @endcan

                                                                </td>

                                                                <td style="padding:6px !important;margin:0px;box-sizing:border-box;color: rgba(22, 22, 23, 1) !important;">

                                                                    <input
                                                                        style="width: auto"
                                                                        type="hidden" class="invoice-inputs item-table-border"
                                                                        name="product[{{ $orderItem->id }}][item_name]"
                                                                        value="{{ $orderItem->productDetails['product_name'] }}@if (isset($orderItem->item_description) && ($orderItem->item_description != null || $orderItem->item_description != '')) {{ '- ' . $orderItem->item_description}} @endif"
                                                                        readonly
                                                                    />

                                                                    @if ($orderItem->active == 1)
                                                                        <a href="{{ route('orderitem.info', ['orderid' => $orderItem->order_id, 'orderItemId' => $orderItem->id]) }}" target="_blank" style="background-color: transparent;border:none;outline:unset;cursor: pointer;color:rgba(22, 22, 23, 1) !important;" ><span style="color: #4E4C4C;" class="onclickAncTag">@if(empty($orderItem->display_name)) @if($Order_item_product) {{$Order_item_product->product_name}} @else {{$orderItem->productDetails['product_name']}} @endif @else {{$orderItem->display_name}} @endif</span></a> @if (isset($orderItem->item_description) && ($orderItem->item_description != null || $orderItem->item_description != '')) {{ '- ' . $orderItem->item_description }} @endif
                                                                    @else
                                                                    <a href="{{ route('missing.products', ['item_ids' => json_encode([$orderItem->id]),'order_id' => json_encode([$orderItem->order_id])]) }}" style="background-color: transparent;border:none;outline:unset;cursor: pointer;color:rgba(22, 22, 23, 1) !important;"><span style="color: #4E4C4C;">@if(empty($orderItem->display_name)) @if($Order_item_product) {{$Order_item_product->product_name}} @else {{$orderItem->productDetails['product_name']}} @endif @else {{$orderItem->display_name}} @endif</span></a> @if (isset($orderItem->item_description) && ($orderItem->item_description != null || $orderItem->item_description != '')) {{ '- ' . $orderItem->item_description }} @endif
                                                                    @endif


                                                                </td>




                                                                <td style="width: 80px;">
                                                                    @php
                                                                        $statusValue = isset($orderItem->statusDetails['status_name']) ? $orderItem->statusDetails['status_name'] : '';

                                                                        $bgColor = '';
                                                                        $textColor = '';

                                                                        switch ($statusValue) {
                                                                            case 'Quote':
                                                                                $textColor = '#FFB916';
                                                                                $bgColor = '#ffffcc';
                                                                                break;
                                                                            case 'Production':
                                                                                $textColor = '#47D6B6';
                                                                                $bgColor = '#d7ffcc';
                                                                                break;
                                                                            case 'Fulfilled':
                                                                                $textColor = '#717070';
                                                                                $bgColor = '#f8f8f8';
                                                                                break;
                                                                            case 'Canceled':
                                                                                $textColor = '#d65a47';
                                                                                $bgColor = '#ffcccc';
                                                                                break;
                                                                        }
                                                                    @endphp
                                                                    <input type="text" class="invoice-inputs text-left item-table-border status-lable" style="width: 100px;padding-left: 0px !important; color: {{ $textColor }} !important;background-color:{{$bgColor}} !important;"
                                                                        name="product[{{ $orderItem->id }}][status]"
                                                                        value="@if (isset($orderItem->statusDetails['status_name'])){{ $orderItem->statusDetails['status_name'] }}@endif" readonly />
                                                                </td>
                                                                <td ><input type="text" class="invoice-inputs est-delivery-date item-table-border {{$class_remake}}" style="background-color: transparent;"
                                                                        name="product[{{ $orderItem->id }}][est_delivery_date]"
                                                                        value="{{ $orderItem->est_delivery_date }}" style="text-align: left;padding-left: 0px !important;color: rgba(22, 22, 23, 1) !important;" readonly /></td>
                                                                <td class="{{$class_test_print}}"><input type="text" class="invoice-inputs test_print_due_date item-table-border  {{$class_remake}}"
                                                                            name="product[{{ $orderItem->id }}][test_print_due_date]"
                                                                            value="{{ $orderItem->test_print_due_date }}" style="text-align: left;padding-left: 0px !important;color: rgba(22, 22, 23, 1) !important;" readonly /></td>
                                                                <td style="min-width: 30px;padding-left: .39rem;">
                                                                    @php
                                                                        // Extract factory codes from $orderItem->productDetails->factory
                                                                        $product_factory = $orderItem->productDetails->productFactories;
                                                                        $product_factory_ids = [];

                                                                        foreach ($orderItem->productDetails->productFactories as $productFactory) {
                                                                            $product_factory_ids[] = $productFactory->product_factory_id;
                                                                        }
                                                                        // Convert $factories collection to array
                                                                        $factories_array = $factories->toArray();

                                                                        // Filter factories based on $product_factory_codes
                                                                        $filtered_factories = array_filter($factories_array, function ($factory) use ($product_factory_ids) {
                                                                            return in_array($factory['id'], $product_factory_ids);
                                                                        });
                                                                    @endphp
                                                                    <select class="invoice-inputs select2-edit-order item-table-border item-factory" data-AlradySaved="{{ $orderItem->factory_id }}"
                                                                        name="orderItems[{{ $orderItem->id }}][factory_id]">
                                                                        <option value="">Select Factory</option>
                                                                        @foreach ($filtered_factories as $factory)
                                                                            <option value="{{ $factory['id'] }}" @if ($factory['id'] == $orderItem->factory_id) selected @endif>{{ $factory['factory_code'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>

                                                                <td>

                                                                    <input type="text" class="invoice-inputs text-left item-fabric item-table-border {{$class_remake}}" name="product[{{ $orderItem->id }}][fabric]" style="width: fit-content;background-color: transparent;padding-left: 0px !important;color: rgba(22, 22, 23, 1) !important;" value="{{($orderItem->fabricDetails==null)?'':$orderItem->fabricDetails['fabric_name']}}" readonly />
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="invoice-inputs text-left item-embellishment item-table-border {{$class_remake}}" style="padding-left: 0px !important;background-color: transparent;color: rgba(22, 22, 23, 1) !important;width:8rem" name="product[{{ $orderItem->id }}][embellishment]" value="{{($orderItem->embellishmentDetails==null)?'':$orderItem->embellishmentDetails['embellishment_name']}}" readonly />

                                                                </td>



                                                                <td><input type="text" style="padding-right: 0px !important;min-width: 30px;background-color: transparent;" class="invoice-inputs text-right {{ $orderItem->is_studio_item == 1 ? 'studio-item-qty' : 'item-qty' }} item-table-border {{$class_remake}}"
                                                                        name="product[{{ $orderItem->id }}][qty]"
                                                                        value="{{ $orderItem->qty }}" readonly /></td>


                                                                @if ($orderTrait->isNotInventoryOrder($order->organization_id))
                                                                    @can('show order price')
                                                                        <td><input type="text" class="invoice-inputs text-right {{ $orderItem->is_studio_item == 1 ? 'studio-item-price' : 'item-price' }} item-table-border {{$class_remake}}"  style="width: 100px;padding-right: 0px !important;min-width: 100px;background-color: transparent;"
                                                                                name="product[{{ $orderItem->id }}][unit_price]"
                                                                                value="{{ $orderItem->unit_price }}" readonly /></td>
                                                                    @endcan
                                                                    @can('show order price')
                                                                        <td><input type="text" class="invoice-inputs text-right item-total item-table-border {{$class_remake}}"  style="width: 100px;padding-right: 0px !important;background-color: transparent;"
                                                                                name="product[{{ $orderItem->id }}][total]"
                                                                                value="{{ $orderItem->total }}" readonly /></td>
                                                                    @endcan
                                                                @endif

                                                                <td>
                                                                    <button type="button" @if($Order_item_product) onclick="edit_saved_items('{{$Order_item_product->id}}' , {{$orderItem}})" @endif title="Edit" @if(auth()->user()->can('edit_saved_item_directly'))  style="border: none;color: black;background-color: transparent;outline: unset;cursor:pointer" @else  style="border: none;color: #e3e1e1;background-color: transparent;outline: unset;cursor:pointer" disabled  @endif><i class="fas fa-edit"></i></button>
                                                                    <button type="button" title="Remake as Studio Item" onclick="remake_as_studio_item({{$orderItem->id}})" @if(auth()->user()->can('edit_saved_item_directly')) style="border: none;color: #17a2b8;background-color: transparent;outline: unset;cursor:pointer" @else style="border: none;color: #e3e1e1;background-color: transparent;outline: unset;cursor:pointer" disabled @endif><i class="fas fa-store"></i></button>
                                                                    <button type="button" title="Delete" onclick="delete_saved_item({{$orderItem}})" @if(auth()->user()->can('edit_saved_item_directly'))  style="border: none;color: black;background-color: transparent;outline: unset;cursor:pointer" @else  style="border: none;color: #e3e1e1;background-color: transparent;outline: unset;cursor:pointer" disabled  @endif><i class="fas fa-trash-alt"></i></button>
                                                                </td>

                                                                <input type="hidden"
                                                                    name="product[{{ $orderItem->id }}][organization_id]"
                                                                    value="{{ $orderItem->organization_id }}" />
                                                                <input type="hidden"
                                                                    name="product[{{ $orderItem->id }}][support_agent_id]"
                                                                    value="{{ $orderItem->support_agent_id }}" />
                                                                <input type="hidden"
                                                                    name="product[{{ $orderItem->id }}][designer_id]"
                                                                    value="{{ $orderItem->designer_id }}" />
                                                                <input type="hidden"
                                                                    name="product[{{ $orderItem->id }}][shipping_method]"
                                                                    value="{{ $orderItem->shipping_method }}" />
                                                                <input type="hidden"
                                                                    name="product[{{ $orderItem->id }}][ex_factory_id]"
                                                                    value="{{ $orderItem->ex_factory_id }}" />
                                                                <input type="hidden" name="product[{{ $orderItem->id }}][item_no]"
                                                                    value="{{ $orderItem->item_no }}" />
                                                                <input type="hidden" name="product[{{ $orderItem->id }}][order_id]"
                                                                    value="{{ $orderItem->order_id }}" />
                                                                <input type="hidden"
                                                                    name="product[{{ $orderItem->id }}][in_hand_due_date]"
                                                                    value="{{ $orderItem->in_hand_due_date }}" />
                                                                <input type="hidden" name="product[{{ $orderItem->id }}][status_id]"
                                                                    value="{{ $orderItem->order_status_id }}" />
                                                                <input type="hidden" name="product[{{ $orderItem->id }}][product_id]"
                                                                    value="{{ $orderItem->product_id }}" />
                                                                <input type="hidden" name="product[{{ $orderItem->id }}][fabric_id]"
                                                                    value="{{ $orderItem->fabric_id }}" />
                                                                <input type="hidden"
                                                                    name="product[{{ $orderItem->id }}][embellishment_id]"
                                                                    value="{{ $orderItem->embellishment_type_id }}" />
                                                                <input type="hidden" name="product[{{ $orderItem->id }}][sport]"
                                                                    value="{{ $orderItem->sport }}" />
                                                                <input type="hidden" name="product[{{ $orderItem->id }}][gender]"
                                                                    value="{{ $orderItem->gender }}" />
                                                                <input type="hidden" name="product[{{ $orderItem->id }}][factory_id]"
                                                                    value="{{ $orderItem->factory_id }}" />
                                                            </tr>
                                                        @endif

                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                </div>

                                <div class="mobile-order-cards d-block d-md-none">

                                    @foreach ($order->orderItems as $orderItem)

                                        @php

                                            $Order_item_product = $subProducts
                                                ->where('sub_product_no', $orderItem->sub_product_no)
                                                ->first();

                                            $product_name = empty($orderItem->display_name)
                                                ? ($Order_item_product
                                                    ? $Order_item_product->product_name
                                                    : $orderItem->productDetails['product_name'])
                                                : $orderItem->display_name;

                                            $statusValue = $orderItem->statusDetails['status_name'] ?? '';

                                            $bgColor = '';
                                            $textColor = '';

                                            switch ($statusValue) {
                                                case 'Quote':
                                                    $textColor = '#FFB916';
                                                    $bgColor = '#ffffcc';
                                                    break;
                                                case 'Production':
                                                    $textColor = '#47D6B6';
                                                    $bgColor = '#d7ffcc';
                                                    break;
                                                case 'Fulfilled':
                                                    $textColor = '#717070';
                                                    $bgColor = '#f8f8f8';
                                                    break;
                                                case 'Canceled':
                                                    $textColor = '#d65a47';
                                                    $bgColor = '#ffcccc';
                                                    break;
                                            }

                                        @endphp

                                        <div class="mobile-item-card @if(isset($orderItem->is_studio_item) && $orderItem->is_studio_item == 1) studio-item-row @endif" @if(isset($orderItem->is_studio_item) && $orderItem->is_studio_item == 1) style="display: none;" @endif>

                                            <div class="mobile-item-header">
                                                <div>
                                                    @can('view order items')
                                                        <a href="{{ route('orderitem.info',
                                                            ['orderid' => $orderItem->order_id,
                                                            'orderItemId' => $orderItem->id]) }}"
                                                            target="_blank"
                                                            class="mobile_product_link">

                                                            <h6 class="mb-1 mobile_product_name">
                                                                {{ $product_name }}
                                                            </h6>

                                                        </a>
                                                    @else
                                                        <h6 class="mb-1 mobile_product_name">
                                                            {{ $product_name }}
                                                        </h6>
                                                    @endcan

                                                    @if($orderItem->item_description)
                                                        <small class="mobile_product_color">
                                                            {{ $orderItem->item_description }}
                                                        </small>
                                                    @endif
                                                </div>

                                                <div class="mobile-item-actions">

                                                    @can('edit_saved_item_directly')
                                                        @if($Order_item_product)
                                                            <button type="button"
                                                                onclick="edit_saved_items('{{ $Order_item_product->id }}', {{ $orderItem }})">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        @endif

                                                        <button type="button"
                                                            title="Remake as Studio Item"
                                                            onclick="remake_as_studio_item({{ $orderItem->id }})">
                                                            <i class="fas fa-store"></i>
                                                        </button>

                                                        <button type="button"
                                                            onclick="delete_saved_item({{ $orderItem }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endcan

                                                </div>

                                            </div>

                                            <div class="mobile-item-body">

                                                <div class="row">

                                                    <div class="col-6 mb-3">
                                                        <label class="mobile-label">Status</label>
                                                        <div class="mobile-value">
                                                            <span class="mobile-status" style="color:{{$textColor}}">
                                                                {{ $statusValue }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 mb-3">
                                                        <label class="mobile-label">Est Delivery</label>
                                                        <div class="mobile-value">
                                                            {{ $orderItem->est_delivery_date ?: '-' }}
                                                        </div>
                                                    </div>

                                                    <div class="col-6 mb-3">
                                                        <label class="mobile-label">Factory</label>
                                                        <div class="mobile-value">
                                                            {{ optional($orderItem->factoryDetails)->factory_code ?? '-' }}
                                                        </div>
                                                    </div>

                                                    <div class="col-6 mb-3">
                                                        <label class="mobile-label">Fabric</label>
                                                        <div class="mobile-value">
                                                            {{ optional($orderItem->fabricDetails)->fabric_name ?? '-' }}
                                                        </div>
                                                    </div>

                                                    <div class="col-6 mb-3">
                                                        <label class="mobile-label">Embellishment</label>
                                                        <div class="mobile-value">
                                                            {{ optional($orderItem->embellishmentDetails)->embellishment_name ?? '-' }}
                                                        </div>
                                                    </div>

                                                    <div class="col-6 mb-3">
                                                        <label class="mobile-label">Qty</label>
                                                        <div class="mobile-value">
                                                            {{ $orderItem->qty }}
                                                        </div>
                                                    </div>

                                                    @if (Gate::check('show order price')
                                                        && $orderTrait->isNotInventoryOrder($orders[0]->organization_id))

                                                        <div class="col-6 mb-3">
                                                            <label class="mobile-label">Unit Price</label>
                                                            <div class="mobile-value">
                                                                ${{ number_format($orderItem->unit_price,2) }}
                                                            </div>
                                                        </div>

                                                        <div class="col-12">

                                                            <div class="d-flex justify-content-between align-items-center mobile_total_price">

                                                                <label class="mobile-label mb-0">Total</label>

                                                                <div class="mobile-value">
                                                                    ${{ number_format($orderItem->total,2) }}
                                                                </div>

                                                            </div>

                                                        </div>

                                                    @endif

                                                </div>

                                            </div>

                                            {{-- <div class="mobile-item-actions">

                                                @can('view order items')
                                                    <a href="{{ route('orderitem.info',
                                                        ['orderid' => $orderItem->order_id,
                                                        'orderItemId' => $orderItem->id]) }}"
                                                        target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan

                                                @can('edit_saved_item_directly')
                                                    @if($Order_item_product)
                                                        <button type="button"
                                                            onclick="edit_saved_items('{{ $Order_item_product->id }}', {{ $orderItem }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    @endif

                                                    <button type="button"
                                                        onclick="delete_saved_item({{ $orderItem }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endcan

                                            </div> --}}

                                        </div>

                                    @endforeach

                                    @if (!empty($orders->studioOrderItems))
                                        @foreach ($order->studioOrderItems as $orderItem)

                                            @php

                                                $Order_item_product = $subProducts
                                                    ->where('sub_product_no', $orderItem->sub_product_no)
                                                    ->first();

                                                $product_name = empty($orderItem->display_name)
                                                    ? ($Order_item_product
                                                        ? $Order_item_product->product_name
                                                        : $orderItem->productDetails['product_name'])
                                                    : $orderItem->display_name;

                                                $statusValue = $orderItem->statusDetails['status_name'] ?? '';

                                                $bgColor = '';
                                                $textColor = '';

                                                switch ($statusValue) {
                                                    case 'Quote':
                                                        $textColor = '#FFB916';
                                                        $bgColor = '#ffffcc';
                                                        break;
                                                    case 'Production':
                                                        $textColor = '#47D6B6';
                                                        $bgColor = '#d7ffcc';
                                                        break;
                                                    case 'Fulfilled':
                                                        $textColor = '#717070';
                                                        $bgColor = '#f8f8f8';
                                                        break;
                                                    case 'Canceled':
                                                        $textColor = '#d65a47';
                                                        $bgColor = '#ffcccc';
                                                        break;
                                                }

                                            @endphp

                                            <div class="mobile-item-card @if(isset($orderItem->is_studio_item) && $orderItem->is_studio_item == 1) studio-item-row @endif" @if(isset($orderItem->is_studio_item) && $orderItem->is_studio_item == 1) style="display: none;" @endif>

                                                <div class="mobile-item-header">
                                                    <div>
                                                        @can('view order items')
                                                            <a href="{{ route('orderitem.info',
                                                                ['orderid' => $orderItem->order_id,
                                                                'orderItemId' => $orderItem->id]) }}"
                                                                target="_blank"
                                                                class="mobile_product_link">

                                                                <h6 class="mb-1 mobile_product_name">
                                                                    {{ $product_name }}
                                                                </h6>

                                                            </a>
                                                        @else
                                                            <h6 class="mb-1 mobile_product_name">
                                                                {{ $product_name }}
                                                            </h6>
                                                        @endcan

                                                        @if($orderItem->item_description)
                                                            <small class="mobile_product_color">
                                                                {{ $orderItem->item_description }}
                                                            </small>
                                                        @endif
                                                    </div>

                                                    <div class="mobile-item-actions">

                                                        @can('edit_saved_item_directly')
                                                            @if($Order_item_product)
                                                                <button type="button"
                                                                    onclick="edit_saved_items('{{ $Order_item_product->id }}', {{ $orderItem }})">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            @endif

                                                            <button type="button"
                                                                title="Remake as Studio Item"
                                                                onclick="remake_as_studio_item({{ $orderItem->id }})">
                                                                <i class="fas fa-store"></i>
                                                            </button>

                                                            <button type="button"
                                                                onclick="delete_saved_item({{ $orderItem }})">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        @endcan

                                                    </div>

                                                </div>

                                                <div class="mobile-item-body">

                                                    <div class="row">

                                                        <div class="col-6 mb-3">
                                                            <label class="mobile-label">Status</label>
                                                            <div class="mobile-value">
                                                                <span class="mobile-status" style="color:{{$textColor}}">
                                                                    {{ $statusValue }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 mb-3">
                                                            <label class="mobile-label">Est Delivery</label>
                                                            <div class="mobile-value">
                                                                {{ $orderItem->est_delivery_date ?: '-' }}
                                                            </div>
                                                        </div>

                                                        <div class="col-6 mb-3">
                                                            <label class="mobile-label">Factory</label>
                                                            <div class="mobile-value">
                                                                {{ optional($orderItem->factoryDetails)->factory_code ?? '-' }}
                                                            </div>
                                                        </div>

                                                        <div class="col-6 mb-3">
                                                            <label class="mobile-label">Fabric</label>
                                                            <div class="mobile-value">
                                                                {{ optional($orderItem->fabricDetails)->fabric_name ?? '-' }}
                                                            </div>
                                                        </div>

                                                        <div class="col-6 mb-3">
                                                            <label class="mobile-label">Embellishment</label>
                                                            <div class="mobile-value">
                                                                {{ optional($orderItem->embellishmentDetails)->embellishment_name ?? '-' }}
                                                            </div>
                                                        </div>

                                                        <div class="col-6 mb-3">
                                                            <label class="mobile-label">Qty</label>
                                                            <div class="mobile-value">
                                                                {{ $orderItem->qty }}
                                                            </div>
                                                        </div>

                                                        @if (Gate::check('show order price')
                                                            && $orderTrait->isNotInventoryOrder($orders[0]->organization_id))

                                                            <div class="col-6 mb-3">
                                                                <label class="mobile-label">Unit Price</label>
                                                                <div class="mobile-value">
                                                                    ${{ number_format($orderItem->unit_price,2) }}
                                                                </div>
                                                            </div>

                                                            <div class="col-12">

                                                                <div class="d-flex justify-content-between align-items-center mobile_total_price">

                                                                    <label class="mobile-label mb-0">Total</label>

                                                                    <div class="mobile-value">
                                                                        ${{ number_format($orderItem->total,2) }}
                                                                    </div>

                                                                </div>

                                                            </div>

                                                        @endif

                                                    </div>

                                                </div>

                                                {{-- <div class="mobile-item-actions">

                                                    @can('view order items')
                                                        <a href="{{ route('orderitem.info',
                                                            ['orderid' => $orderItem->order_id,
                                                            'orderItemId' => $orderItem->id]) }}"
                                                            target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan

                                                    @can('edit_saved_item_directly')
                                                        @if($Order_item_product)
                                                            <button type="button"
                                                                onclick="edit_saved_items('{{ $Order_item_product->id }}', {{ $orderItem }})">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        @endif

                                                        <button type="button"
                                                            onclick="delete_saved_item({{ $orderItem }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endcan

                                                </div> --}}

                                            </div>

                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    @can('roster manual upload')
                        @if ($order->order_type == 0)
                            <div class="col-lg-12 mb-3 mobile_roster_upload_div_1">
                                <div class="mobile_card_div mobile_description_div mobile_roster_upload_div_2" style="border-radius: 0rem; border:none">
                                    <div class="row">
                                        <div class="col-md-12 header-style Mobile_roster_import mobile_card_header">
                                            Roster Import
                                        </div>
                                        <div class="col-md-4 col-12 mobile_roster_upload_div_3">
                                            <a href="{{ route('orders.export_order_roster_template', $order->id) }}" class="btn btn-info w-75 py-2 mobile_roster_upload_div_4 mobile_roster_download_btn" style="background-color: #b3b3b3; border-radius: 0rem; border: none;">
                                                Download Roster Template
                                            </a>
                                        </div>
                                        <div class="col-md-8 row col-12">
                                            <div class="align-content-center col-md-3">
                                                <label for="importNameFile" class="float-right form-row mobile_import_roster_text">Import Order Roster Excel :</label>
                                            </div>
                                            <div class="col-md-6 col-7">
                                                <input type="file" id="importNameFile" class="align-content-center form-control">
                                            </div>
                                            <div class="col-md-3 col-3">
                                                <button type="button" class="btn btn-info py-2 mobile_roster_download_btn" onclick="uploadFile('{{ $order->id }}')" style="background-color: #b3b3b3; border-radius: 0rem; border: none;">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endcan

                    @can('show order price')
                    <div class="col-lg-12 mb-3" style="padding: 0px;">
                        <div class="card-updated mobile_card_div mobile_description_div">
                            <div class="row" style="padding: 1rem;">
                                <div class="col-md-12 price-div-top">
                                    <div class="row lordetails001">
                                        @can('show order price')
                                                <div class="col-md-4 ml-auto" style="display: none;">
                                                    <table style="width: 100%">i
                                                        <tr>
                                                            <th style="color: #717070">Total Item Qty </th>
                                                            <th><input class="invoice-inputs text-right item-table-border invoicein0001" type='text' style="color: #717070" value='{{ $totalItemQty }}'
                                                                    readonly /></th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="{{!$orderTrait->isNotInventoryOrder($order->organization_id) ? 'col-md-12' : 'col-md-7' }} lorderdate001 max_width01" id="thanks_div">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h1 class="main-htag mt-4 mobile_margin_top_unset">Thank you for your business!</h1>
                                                        </div>
                                                        <div class="col-md-12 mt-4 text-center mobile_margin_top_unset">
                                                            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" class="navbar-brand-img imagesize" id="logo_large" alt="...">
                                                        </div>
                                                    </div>

                                                    {{-- <div class="mt-4">
                                                        <h4>Payment can be submitted via PayPal, Venmo, Debit/Credit Card or Check. If
                                                            submitting via PayPal or
                                                            Venmo, please include the invoice #, as well as your team and contact
                                                            information.</h4>
                                                    </div>
                                                    <div class="mt-4">
                                                        <table>
                                                            <tr>
                                                                <td>
                                                                    <h4 class="text-small">PayPal :</h4>
                                                                </td>
                                                                <td>
                                                                    <h4 class="text-small"><span
                                                                            class="text-muted">info@encorelacrosse.com</span></h4>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h4 class="text-small">Venmo :</h4>
                                                                </td>
                                                                <td>
                                                                    <h4 class="text-small"><span
                                                                            class="text-muted">@encore-lacrosse</span></h4>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h4 class="text-small">Credit Card/Check :</h4>
                                                                </td>
                                                                <td>
                                                                    <h4 class="text-small"><span class="text-muted">Please make
                                                                            payment through sales rep or accounting dept.</span></h4>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div> --}}
                                                </div>
                                        @endcan

                                        @can('show order price')
                                                <div class="col-lg-5 lorderdate001 max_width01" style="{{!$orderTrait->isNotInventoryOrder($order->organization_id) ? 'display: none;' : '' }}" id="order_sum_of_payments">
                                                    <table id="invoice_summery_table" class="mobile_invoice_summery_table" style="margin-left: auto;">
                                                        <tr>
                                                            <td class="header-style mb-4">Payment</td>
                                                        </tr>
                                                        <tr id="studio_item_summery_qty_tr">
                                                            <th style="color: #717070">Total Studio Item Qty </th>
                                                            <th><input class="invoice-inputs text-right item-table-border invoicein0001" type='text'
                                                                    id="studio_item_summery_qty" style="color: #717070" value='{{ $totalStudioItemQty }}'
                                                                    readonly /></th>
                                                        </tr>
                                                        <tr>
                                                            <th style="color: #717070">Total Item Qty </th>
                                                            <th><input class="invoice-inputs text-right item-table-border invoicein0001" type='text'
                                                                    id="order_summery_qty" style="color: #717070" value='{{ $totalItemQty }}'
                                                                    readonly /></th>
                                                        </tr>
                                                        <tr style="color: black">
                                                            <th style="font-weight: 100">Invoice amount ($) </th>
                                                            <td><input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="sub_total"
                                                                    id="sub_total" value='{{ number_format($order->sub_total, 2) }}'
                                                                    readonly /></td>
                                                        </tr>

                                                        <tr style="color: #717070">
                                                            <th style="font-weight: 100">Artwork & other fees ($) </th>
                                                            <td><input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="artwork"
                                                                    id="artwork" value='{{ number_format($order->artwork, 2) }}' style="color: #717070" /></td>
                                                        </tr>
                                                        @can('view discount')
                                                            <tr style="color: #717070" class="discount_row">
                                                                <th style="font-weight: 100">
                                                                    <span style="margin-right: 3%;">Discount</span>
                                                                    <input type="radio" id="percentage" name="discount" value="percentage" {{ $order->discountType == 1 ? 'checked' : '' }}>
                                                                    <label for="percentage" style="margin-right: 3%;">%</label>
                                                                    <input type="radio" id="value" name="discount" value="value" {{ $order->discountType == 2 ? 'checked' : '' }}>
                                                                    <label for="value">$</label>
                                                                </th>
                                                                <input type="hidden" id="discountType" name="discountType" value="{{ $order->discountType }}">
                                                                <input type="hidden" id="isDiscountAvailable" value="{{ $order->discount_hidation }}">

                                                                <td style="width: 30%;">
                                                                    <input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="discount" id="discount_value" value='{{ $order->discount }}' style="color: #717070" />
                                                                </td>
                                                            </tr><br>
                                                        @endcan
                                                        @php
                                                        $order_total_amount = $order->sub_total + $order->artwork;
                                                        if($order->discount_hidation == 1 ){

                                                            if($order->discountType == 1){

                                                                $discountAmount = ($order_total_amount / 100) * $order->discount;

                                                            } elseif($order->discountType == 2) {

                                                                $discountAmount = $order->discount;
                                                            }else{
                                                                $discountAmount = 0.00;
                                                            }

                                                        }else{
                                                            $discountAmount = 0.00;
                                                        }
                                                        @endphp
                                                        <tr style="color: black;font-weight: 600;">
                                                            <th>Total invoice amount ($)</th>
                                                            <td>
                                                                <input class="invoice-inputs text-right item-table-border invoicein0001" type='text'style="color: black;font-weight: 600;" id="total_invoice_amount" value='{{ number_format($order_total_amount - $discountAmount, 2) }}'
                                                                    readonly />
                                                            </td>
                                                        </tr>
                                                        <tr style="color: #717070;font-weight:100">
                                                            <th style="font-weight: 100">Sales Tax ($) <span id="sales_tax_display">{{ $order->organizationDetails['sales_tax'] }}</span>%  RATE </th>
                                                            <td>
                                                                <input type="hidden" id="sales_tax_percentage"
                                                                    value="{{ $order->organizationDetails['sales_tax'] }}" />
                                                                <input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="sales_tax"
                                                                    id="sales_tax" style="color: #717070" value='{{ number_format($order->sales_tax, 2) }}'
                                                                     />
                                                            </td>
                                                        </tr>

                                                        <tr style="color: #717070;">
                                                            <th style="font-weight: 100">Shipping Fee ($) </th>
                                                            <td><input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="shipping"
                                                                    id="shipping" value='{{ number_format($order->shipping, 2) }}' style="color: #717070" />
                                                            </td>
                                                        </tr>

                                                        <tr style="border-top: 1px solid #e3e3e3">
                                                            <th class="total" style="font-size: 1rem !important;color:black">Grand Total <p style="color: grey;font-weight: 100;font-size: .6rem;margin:0">(Invoice amount + Sales Tax + shipping)</p> </th>
                                                            <td>
                                                                <input class="invoice-inputs text-right item-table-border invoicein0001" type='text' name="order_total" id="order_total" value='{{ number_format($order->order_total, 2) }}' readonly style="font-weight: bold; font-size: 1rem;" />
                                                            </td>
                                                        </tr>

                                                        <tr style="color: #717070">
                                                            <th style="font-weight: 100">Paid amount ($)</th>
                                                            <td>
                                                                <input class="invoice-inputs text-right item-table-border invoicein0001" style="color: #717070" type='text' id="paid_full_amount" value='{{ number_format($payment, 2) }}' disabled/>
                                                            </td>
                                                        </tr>
                                                        <tr style="color: #717070">
                                                            <th style="font-weight: 100">Paid processing fees ($)</th>
                                                            <td>
                                                                <input class="invoice-inputs text-right item-table-border invoicein0001" style="color: #717070" type='text' name="processing_fee" id="processing_fee" value='{{ number_format($processingFee, 2) }}' disabled/>
                                                            </td>
                                                        </tr><br>

                                                        @if ($paymentStatus == 1)
                                                            <tr>
                                                                <th style="color: black;border-top: 1px solid #e3e3e3">Balance Invoice amount ($)</th>
                                                                <td  colspan="2" style="border-top: 1px solid #e3e3e3"><input class="invoice-inputs text-right" type='text' name="balance_payment"
                                                                    id="balance_payment" value='{{ number_format($balnceToBePaid, 2) }}'
                                                                    readonly style="font-weight: bold; font-size: large;" /></td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <th style="color: black">Payment Status </th>
                                                            @if ($paymentStatus == 0)
                                                                <td style="text-align: end;">
                                                                    <input type="text" class="payment-lable-style" value="Pending" style="background-color: #adb5bd; color: #ffffff;" readonly>
                                                                </td>
                                                            @elseif ($paymentStatus == 1)
                                                                <td style="text-align: end;">
                                                                    <input type="text" class="payment-lable-style" value="Partial" style="background-color: #fb6340; color: #ffffff;" readonly></td>
                                                            @else
                                                                <td style="text-align: end;">
                                                                    <input type="text" class="payment-lable-style" value="Paid" style="background-color: #2dce89; color: #ffffff;" readonly></td>
                                                            @endif
                                                        </tr>
                                                    </table>
                                                </div>
                                            <div class="col-12 col-lg-8 mb-3 ml-auto footer-actions" style="margin-top: 3rem;text-align:end">
                                                <button type="button" class=" footer-button-styles footer-btn  {{$order->statusDetails['id'] != 1 ? 'disable-cancel-btn' : ''}} cancel-btn-action"  {{ $order->statusDetails['id'] != 1 ? 'disabled' : '' }} style="background-color:#717070" value="{{ $orderDetail->id }}">Cancel</button>
                                                @can('delete order detail')
                                                <button type="button" style="background-color: #d65a47" class="deleteMainorder footer-button-styles footer-btn"
                                                    value="{{ $orderDetail->id }}">Delete</button>
                                                @endcan

                                                    @can('payment order detail')
                                                        <button class="footer-button-styles footer-btn" style="background-color: #4791d6; {{!$orderTrait->isNotInventoryOrder($order->organization_id) ? 'display: none;' : '' }}" id="go_to_payments_btn">
                                                            {{-- <a href="{{ route('payment', ['orderId' => $orderDetail->id]) }}" style="color: white">Payment</a> --}}
                                                            <a href="{{ route('payment', [
                                                            'orderId' => $orderDetail->id,
                                                            'totalItemQty' => $totalItemQty,
                                                            'sub_total' => number_format($order->sub_total, 2),
                                                            'salesTax' => number_format($order->sales_tax, 2),
                                                            'shipping' => number_format($order->shipping, 2),
                                                            'artwork' => number_format($order->artwork, 2),
                                                            'processingFee' => number_format($processingFee, 2),
                                                            'orderTotal' => number_format($order->order_total + $processingFee, 2),
                                                            'paymentStatus' => $paymentStatus,
                                                            'balancePayment' => $paymentStatus == 1 ? number_format($balnceToBePaid, 2) : null,
                                                        ]) }}" class="footer-button-styles footer-btn" style="background-color: #4791d6; color: white;"> Payment</a>
                                                        </button>
                                                    @endcan

                                                @can('save order detail')
                                                <button type="button" id="footer-button-styles-save" class="save_btn footer-button-styles footer-btn" style="margin-right: 0px;">Save</button>
                                                @endcan
                                            </div>

                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan
                </div>


                {{-- Address Details --}}
                <div class="card mb-3 card-position" style="display: none">
                    <div class="card-body item-table-top">

                        <div class="row mt-4">


                            <div class="row col-md-12">
                                {{-- <div class="col-md-1">
                                    <table class="table Product_details table-responsive table-border icon-table-potision">
                                        <tr>
                                            <th>
                                                <div style="background-color: #3636ff;width: 10px;height: 19px; position: relative; left: 21px;"></div>
                                            </th>
                                        </tr>
                                        <tr></tr>
                                        <tbody>
                                            @foreach ($orderDetails as $orderDetail)
                                            @foreach ($orderDetail->orderItems as $key=>$orderItem1)
                                            <tr>
                                                <td style="  margin:0px;box-sizing:border-box;color:black" class="item-view-icon">
                                                    @can('view order items')
                                                                @if (request()->get('item') != null && $key == request()->get('item'))
                                                                <a href="http://" ></a>
                                                                    comment <button type="button" class="icon-button" data-toggle="modal" data-target="#item_view">
                                                                        <a class="nav-item nav-link  @if(Gate::check('view order items') && request()->get('item') != null && $key == request()->get('item')) active @endif nav-tab-item" id="tab_{{ $orderItem1->id }}_link" data-toggle="tab" formID="{{ $orderItem1->id }}"
                                                                            href="#tab_{{ $orderItem1->id }}" role="tab" aria-controls="tab_{{ $orderItem1->product_id }}" data-RosterForm="orderRoster_{{ $orderItem1->id }}" aria-selected="true"
                                                                            target="_blank" rel="noopener noreferrer"

                                                                            onclick="itemTabClick({{ $orderItem1->id }});" >




                                                                            <i class="fas fa-solid fa-eye view-icon" style="color: #949494;"></i>
                                                                        </a>
                                                                        comment</button>

                                                                @else
                                                                comment <button type="button" class="icon-button" data-toggle="modal" data-target="#item_view">
                                                                    <a class="nav-item nav-link nav-tab-item" formID="{{ $orderItem1->id }}"
                                                                        target="_blank" rel="noopener noreferrer"
                                                                        href="{{ url()->current().'?item='.$key.'&iid='.$orderItem1->id }}" role="tab" aria-controls="tab_{{ $orderItem1->product_id }}" aria-selected="true">
                                                                        <i class="fas fa-solid fa-eye view-icon" style="color: #949494;"></i>
                                                                    </a>
                                                                    comment  </button>

                                                                @endif

                                                                <input type="hidden" id="productID_{{ $orderItem1->id }}" value="{{$orderItem1->product_id}}"/>
                                                                <input type="hidden" id="selectedFabricID_{{ $orderItem1->id }}" value="{{$orderItem1->fabric_id}}"/>
                                                                <input type="hidden" id="selectedEmbellishmentID_{{ $orderItem1->id }}" value="{{$orderItem1->embellishment_type_id}}"/>
                                                                <input type="hidden" id="selectedAttributeIDs_{{ $orderItem1->id }}" value="{{$orderItem1->orderItemAttributes}}"/>

                                                    @endcan

                                                </td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div> --}}


                            </div>


                        </div>
                    </div>
                </div>

                <input type="hidden" class="is_urgent" name="is_urgent" id="is_urgent" value="">

                <div class="col-md-12 control-btns mt-3 no-print" style="display: none;">
                    <button type="submit" class="btn btn-success btn-custom" id="order_update_btn" onclick="loadingStart()">Save</button>
                </div>

                {{-- <div class="card">
                    <div class="card-head">
                        <div class="col-md-12">
                            <div class="col-md-12 control-btns">
                                <button type="button" class="btn btn-danger btn-custom cancel_btn mb-1 mr-1">Cancel</button>
                                @can('delete order detail')
                                <button type="button" class="btn btn-danger btn-custom deleteMainorder mb-1 mr-1"
                                    value="{{ $orderDetail->id }}">Delete</button>
                                @endcan
                                @can('generate quote order detail')
                                <button type="button" class="btn btn-light btn-custom generate_quote_btn mb-1 mr-1 no-disable"
                                    value="{{ $orderDetail->id }}">Generate Quote</button>
                                @endcan
                                @can('generate invoice order detail')
                                <button type="button" class="btn btn-light btn-custom generate_invoice_btn mb-1 mr-1 no-disable"
                                    value="{{ $orderDetail->id }}">Generate Invoice</button>
                                @endcan
                                @can('generate url order detail')
                                <button type="button" class="btn btn-light btn-custom generate_link_btn mb-1 mr-1 no-disable"
                                    value="{{ $orderDetail->id }}">Generate URL</button>
                                @endcan

                                @can('generate pdf order detail')
                                <button type="button" class="btn btn-light btn-custom generate_pdf_btn mb-1 mr-1 no-disable"
                                    value="{{ $orderDetail->id }}">Generate PDF</button>
                                @endcan
                                @can('generate csv order detail')
                                <button type="button" class="btn btn-light btn-custom generate_csv_btn mb-1 mr-1 no-disable"
                                    value="{{ $orderDetail->id }}">Generate CSV</button>
                                @endcan
                                @can('payment order detail')
                                    <a href="{{ route('payment', ['orderId' => $orderDetail->id]) }}" class="btn btn-success btn-custom mb-1 mr-1">Payment</a>
                                @endcan
                                @can('save order detail')
                                    <button type="button" class="btn btn-success btn-custom save_btn mb-1 mr-1">Save</button>
                                @endcan
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="col-lg-12 control-btns" style="margin-top: 0px;">
                                <span id="link_container"></span>
                                <button type="button" class="btn btn-sm btn-info btn-custom" style="display: none;"
                                    id="copy_link_btn" title="Copy Link" onclick="copyLink()">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div> --}}
            @endforeach
        </form>


    </div>
    @endcan

    {{-- Product Category Tab --}}
    @can('view order items')
        @foreach ($orderDetails as $orderDetail)

            @if( request()->get('item') != null )
            @php
                $orderItem = $orderDetail->orderItems[request()->get('item')];
            @endphp
            {{-- @foreach ($orderDetail->orderItems as $key=>$orderItem) --}}
                {{-- <div class="tab-pane fade @if(!Gate::check('view order details') && Gate::check('view order items') && $key == 0) show active @endif" id="tab_{{ $orderItem->id }}" role="tabpanel" --}}
                <div class="tab-pane fade show active" id="tab_{{ $orderItem->id }}" role="tabpanel"
                    aria-labelledby="tab_{{ $orderItem->id }}_link">
                    @include('pages.order_management.orders.edit_order_item_form')
                </div>
            {{-- @endforeach --}}
            @endif
        @endforeach
    @endcan
</div>


@include('pages.order_management.orders.modal_copy')
@include('pages.order_management.orders.modal_view_mockup_images')
@include('pages.order_management.orders.ex_factory_date_log')
@include('pages.order_management.orders.item_ex_factory_date_log')
@include('pages.order_management.orders.inhand_due_date_log')

@if((Gate::check('Production confirmation') && in_array(17, json_decode(Auth::user()->role_id, true)) && (Auth::id() == 116 || Auth::id() == 62)) || (Gate::check('Production confirmation') && !in_array(6, json_decode(Auth::user()->role_id, true)) && in_array(17, json_decode(Auth::user()->role_id, true))))

@if (!empty($Notifications))
        <div class="modal fade show d-block" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationModalLabel">
                            <i class="fas fa-exclamation-triangle text-warning mr-2"></i>Please confirm the order first.
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert-warning" style="padding: 0.8rem;border-radius: 0.5rem;">
                            <strong>This action requires confirmation:</strong> You have not confirmed it yet. Please confirm the order to proceed further.
                        </div>

                        @php
                            $notification_order_items = explode(',', $Notifications->order_item_id);

                            $sub_products_names = [];

                            foreach ($notification_order_items as $notification_order_item) {
                                $order_item_found = App\Models\OrderItem::find($notification_order_item);
                                if($order_item_found){
                                    $item_description = ($order_item_found->item_description ? ' - '.$order_item_found->item_description : '').' - (Qty '.$order_item_found->qty.')';
                                    $sub_product_found = App\Models\SubProduct::where('sub_product_no', $order_item_found->sub_product_no)->first()->product_name.$item_description;
                                    array_push($sub_products_names, $sub_product_found);
                                }
                            }
                        @endphp

                        <div class="col-md-12">
                            <div class="row mt-1">
                                <div class="col-md-12 mt-2" style="font-size: .95rem;font-weight: 600;">
                                    Items in this order:
                                </div>
                                <div class="col-md-12">
                                    @foreach ($sub_products_names as $sub_products_name)
                                        <p style="margin-bottom: 0px;font-size: .9rem;color: grey;">{{ $sub_products_name }}</p>
                                    @endforeach
                                </div>
                                <div class="col-md-6 mt-2" style="font-size: .9rem;">
                                    Ex Factory Date : <p style="margin-bottom: 0px;color: grey;">{{ $Notifications->order_ex_fac_date ? : 'No available' }}</p>
                                </div>
                                <div class="col-md-6 mt-2" style="font-size: .9rem;">
                                    In Hand Due Date : <p style="margin-bottom: 0px;color: grey;">{{ $Notifications->order_in_hand_due_date ? : 'No available' }}</p>
                                </div>
                                <div class="col-md-12 mt-2" style="font-size: .9rem;">
                                    To Check Techpack - <a href="{{ url('orders/DownloadTestPrint/') }}/{{{ urlencode($Notifications->order_item_id) }}}">Click Here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-toggle="modal" data-target="#order_rejectModal">
                            <button type="button" class="btn btn-secondary">Reject</button>
                        </a>
                        <a href="#" data-toggle="modal" data-target="#order_confirmModal">
                            <button type="button" class="btn btn-success">Confirm</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- reject modal --}}

        <div class="modal fade" id="order_rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Reason</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('reject_or_confirm_order_directly') }}" method="post">
                        <input type="hidden" name="notification_id" value="{{$Notifications->id}}">
                    <div class="modal-body">
                        <p>Please enter the reason for reject this order</p>
                        <input type="text" name="reject_reason" class="form-control" required>
                        <p>Suggested Date</p>
                        <input type="text" name="ex_fac_date" class="form-control datepicker">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="submit_or_reject_modal(this)">Reject</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- confirm modal --}}

        <div class="modal fade" id="order_confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('reject_or_confirm_order_directly') }}" method="post">
                        <input type="hidden" name="notification_id" value="{{$Notifications->id}}">
                    <div class="modal-body">
                        <p>Please enter the "Confirm" for confirm this order</p>
                        <input type="text" name="confirm_text" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success" onclick="submit_or_reject_modal(this)">Confirm</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @elseif(($order->factory_confirmation_date == 'Waiting for factory Confirmation'))
        <div class="modal fade show d-block" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationModalLabel">
                            <i class="fas fa-exclamation-triangle text-warning mr-2"></i>Confirmation is required before proceeding with the order.
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert-warning" style="padding: 0.8rem;border-radius: 0.5rem;">
                            <strong>This action requires confirmation:</strong> The order is not yet confirmed. Please wait for confirm it before proceeding.
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @endif
@elseif(Gate::check('Production confirmation') && in_array(17, json_decode(Auth::user()->role_id, true)) && in_array(6, json_decode(Auth::user()->role_id, true)))
    @if (!empty($Notifications))
        <div class="modal fade show d-block" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationModalLabel">
                            <i class="fas fa-exclamation-triangle text-warning mr-2"></i>Confirmation is required before proceeding with the order.
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert-warning" style="padding: 0.8rem;border-radius: 0.5rem;">
                            <strong>This action requires confirmation:</strong> The order is not yet confirmed. Please wait for Sooriyag or Danushka to confirm it before proceeding.
                        </div>

                        @php
                            $notification_order_items = explode(',', $Notifications->order_item_id);

                            $sub_products_names = [];

                            foreach ($notification_order_items as $notification_order_item) {
                                $order_item_found = App\Models\OrderItem::find($notification_order_item);
                                if($order_item_found){
                                    $item_description = ($order_item_found->item_description ? ' - '.$order_item_found->item_description : '').' - (Qty '.$order_item_found->qty.')';
                                    $sub_product_found = App\Models\SubProduct::where('sub_product_no', $order_item_found->sub_product_no)->first()->product_name.$item_description;
                                    array_push($sub_products_names, $sub_product_found);
                                }
                            }
                        @endphp

                        <div class="col-md-12">
                            <div class="row mt-1">
                                <div class="col-md-12 mt-2" style="font-size: .95rem;font-weight: 600;">
                                    Items in this order:
                                </div>
                                <div class="col-md-12">
                                    @foreach ($sub_products_names as $sub_products_name)
                                        <p style="margin-bottom: 0px;font-size: .9rem;color: grey;">{{ $sub_products_name }}</p>
                                    @endforeach
                                </div>
                                <div class="col-md-6 mt-2" style="font-size: .9rem;">
                                    Ex Factory Date : <p style="margin-bottom: 0px;color: grey;">{{ $Notifications->order_ex_fac_date ? : 'No available' }}</p>
                                </div>
                                <div class="col-md-6 mt-2" style="font-size: .9rem;">
                                    In Hand Due Date : <p style="margin-bottom: 0px;color: grey;">{{ $Notifications->order_in_hand_due_date ? : 'No available' }}</p>
                                </div>
                                <div class="col-md-12 mt-2" style="font-size: .9rem;">
                                    To Check Techpack - <a href="{{ url('orders/DownloadTestPrint/') }}/{{{ urlencode($Notifications->order_item_id) }}}">Click Here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        @elseif(($order->factory_confirmation_date == 'Waiting for factory Confirmation'))
            <div class="modal fade show d-block" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="notificationModalLabel">
                                <i class="fas fa-exclamation-triangle text-warning mr-2"></i>Confirmation is required before proceeding with the order.
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="alert-warning" style="padding: 0.8rem;border-radius: 0.5rem;">
                                <strong>This action requires confirmation:</strong> The order is not yet confirmed. Please wait for Sooriyag or Danushka to confirm it before proceeding.
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
    @endif
@endif






<!--done-->

<div class="modal fade" id="item_view" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Re-Order</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Address modal --}}

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content row" style="padding: .5rem;padding-bottom: 1.5rem;">
            <div class="modal-header col-md-12" style="border-bottom: 1px solid #f4f4f4;padding-bottom:5px">
                <h3 class="header-style" id="modal-title-default">Add New Address</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="col-md-8 mt-3 mb-3 sub-header-style">
                Shipping Address
            </div>

            {{-- <div class="col-md-12">
                <label for="customer_id" class="form-label">Customer name</label>
                <select name="customer_id" class="new-dropdown-style" id="customer_id" data-AlradySaved="{{ $order->contactDetails }}"
                    class="invoice-inputs border-style" required>
                    <option value="">Select Customer</option>

                    @foreach ($order->contactOrganizations as $contactOrgs)
                        @foreach ($contactOrgs->contacts as $contact)
                            <option value="{{ $contact->id }}" @if ($contact->id == $order->contactDetails->id) selected @endif>
                                {{ $contact->first_name ?? '' }}
                                {{ $contact->last_name ?? '' }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div> --}}
                        {{-- Defaul address --}}

            <div class="col-md-6 default-address">
                <label for="shipping_address1" class="form-label">Apartment</label>
                <input class="invoice-inputs light-border light-font border-style" id="shipping_address1" type='text'
                        value='{{ $order->contactDetails['apartment'] ?? '--' }}'
                        readonly />

            </div>
            <div class="col-md-6 default-address">
                <label for="shipping_address2" class="form-label">Street</label>
                <input class="invoice-inputs light-border light-font border-style" id="shipping_address2" type='text'
                        value='{{ $order->contactDetails['shipping_street'] ?? '--' }}'
                        readonly />

            </div>
            <div class="col-md-6 default-address">
                <label for="shipping_address3" class="form-label">City</label>
                <input class="invoice-inputs light-border light-font border-style" id="shipping_address3" type='text'
                        value='{{ $order->contactDetails['shipping_city'] ?? '' }} {{ $order->contactDetails['shipping_state'] ?? '' }} {{ $order->contactDetails['shipping_zip'] ?? '' }}'
                        readonly />

            </div>
            <div class="col-md-6 default-address">
                <label for="shipping_address4" class="form-label">Country</label>
                <input class="invoice-inputs light-border light-font border-style" id="shipping_address4" type='text'
                        value='{{ $order->contactDetails['shipping_country'] ?? '--' }}'
                        readonly />

            </div>
            <div class="col-md-12 default-address">
                <label for="shipping_address5" class="form-label">Phone</label>
                <input class="invoice-inputs light-border light-font border-style" id="shipping_address5" type='text'
                        value='{{ $order->contactDetails['phone_no'] ?? '--' }}' readonly />
            </div>
            <div class="col-md-12 default-address">
                <label for="shipping_address6" class="form-label">E mail</label>
                <input class="invoice-inputs light-border light-font border-style"  id="shipping_address6" type='text'
                        value='{{ $order->contactDetails['email'] ?? '--' }}' readonly />
            </div>

            {{-- New address --}}
            <!-- @if(str_starts_with($order->order_no, 'WL'))
                <div class="col-md-6 new-address">
                    <input class="invoice-inputs light-border light-font placeholder-color border-style" id="wl_receiver_name" name="wl_receiver_name" type='text' value="{{ $order->wl_receiver_name }}"
                    placeholder="WL Receiver Name" />

                </div>
            @endif -->

            <div class="col-md-6 new-address">
                    <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_receiver_name" name="new_receiver_name" type='text' value="{{ $order->receiver_name }}"
                    placeholder="Receiver Name" />

            </div>

            <div class="col-md-6 new-address">
                <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_Apartment" name="new_Apartment" type='text' value="{{ $order->Apartment }}"
                        placeholder="Apartment/Unit #" />

            </div>
            <div class="col-md-6 new-address">
                <label for="new_street" class="form-label">Street</label>
                <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_street" name="new_street" type='text' value="{{ $order->street }}"
                        placeholder="Type Street" />

            </div>
            <div class="col-md-6 new-address">
                <label for="new_city" class="form-label">City</label>
                <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_city" name="new_city" type='text' value="{{ $order->city }}"
                        placeholder="Type City" />

            </div>
            <div class="col-md-6 new-address">
                <label for="new_state" class="form-label">State</label>
                <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_state" name="new_state" type='text' value="{{ $order->state }}"
                        placeholder="Type State" />

            </div>
            <div class="col-md-6 new-address">
                <label for="new_postal_code" class="form-label">Postal code</label>
                <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_postal_code" name="new_postal_code" value="{{ $order->postal_code }}"
                        type='text' placeholder="Type Postal Code" />

            </div>
            <div class="col-md-6 new-address">
                <label for="new_country" class="form-label">Country</label>
                <input class="invoice-inputs light-border light-font placeholder-color border-style" id="new_country" name="new_country" value="{{ $order->country }}"
                        type='text' placeholder="Type Country" />

            </div>
            <div class="col-md-8 mt-3 mb-3 sub-header-style">
                Contact Info
            </div>
            <div class="col-md-12 new-address">
                <label for="shipping_address5" class="form-label">Phone</label>
                <input class="invoice-inputs light-border light-font border-style" id="new_phone_no" type='text'
                        value='{{ $order->contactDetails['phone_no'] ?? '--' }}'/>
            </div>
            <div class="col-md-12 new-address">
                <label for="shipping_address6" class="form-label">E mail</label>
                <input class="invoice-inputs light-border light-font border-style"  id="new_email" type='text'
                        value='{{ $order->contactDetails['email'] ?? '--' }}'/>
            </div>
            <div class="col-md-6 row mt-4 mb-4">
                <div class="col-md-6">
                    <button class="swal2-confirm" onclick="addNewAddressDetails()">Add</button>
                </div>

                <div class="col-md-6">
                    <button class="swal2-cancel" onclick="cancelAddAddress()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="urgentMassege" tabindex="-1" role="dialog" aria-labelledby="urgentMassegeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cancel-button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <h4 style="text-align: center;">Please be aware that this is an urgent order, and we require confirmation from the factory on the ex-factory date.</h4>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger cancel-button" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success done">Okay</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="order-cancel-modal" tabindex="-1" role="dialog" aria-labelledby="urgentMassegeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cancel-button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <h4 style="text-align: center;">Please be aware that this is an urgent order, and we require confirmation from the factory on the ex-factory date.</h4>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control info-form-input color-set" id="template_title_get" name="title" value="" style="width:100%;height: 2.5rem;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger cancel-button" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success done">Okay</button>
            </div>
        </div>
    </div>
</div>

@include('pages.order_management.orders.edit_item_modal')
{{-- @include('pages.order_management.orders.invoices.create') --}}
@include('pages.order_management.orders.add_item_modal')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    flatpickr("#due_date", {
        dateFormat: "m/d/Y",
        defaultDate: "{{ $order->due_date }}",
        altInput: true,
        altFormat: "m/d/Y",
        allowInput: true,
        monthSelectorType: "dropdown"
    });
    flatpickr("#est_delivery_date", {
        dateFormat: "m/d/Y",
        defaultDate: "{{ $order->est_delivery_date }}",
        altInput: true,
        altFormat: "m/d/Y",
        allowInput: true,
        monthSelectorType: "dropdown"
    });
    flatpickr("#ex_factory_date", {
        dateFormat: "m/d/Y",
        defaultDate: "{{ $order->ex_factory_date }}",
        altInput: true,
        altFormat: "m/d/Y",
        allowInput: true,
        monthSelectorType: "dropdown"
    });

});
document.addEventListener('change', function (e) {
    const fp = e.target._flatpickr;

    // Only run for Flatpickr inputs
    if (!fp) {
        return;
    }

    fp.close();

    // Remove focus from original input
    fp.input.blur();

    // Remove focus from visible altInput
    if (fp.altInput) {
        fp.altInput.blur();
    }
}, true);
</script>

<script>
    // $('.cancel-btn-action').on('click', function (event) {
    //     if ($(this).hasClass('disable-cancel-btn')) {
    //         return; // Stop the event from continuing
    //     }
    //     $('#order-cancel-modal').modal('show');
    // });

    $('.cancel-btn-action').on('click', function (event) {
        var orderId = $(this).val();
        event.preventDefault();  // Prevent any default action
        event.stopPropagation(); // Stop the event from bubbling up

        if ($(this).hasClass('disable-cancel-btn')) {
            return false; // Stop the execution if button is disabled
        }

        // Show SweetAlert with input for reason
        Swal.fire({
            title: 'Are you sure?',
            text: 'Please provide a reason for canceling the order:',
            input: 'textarea',
            inputPlaceholder: 'Enter your reason here...',
            inputAttributes: {
                'aria-label': 'Enter your reason here'
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            console.log(result);

            if (result.value) {
                // Retrieve the reason from the input field
                const reason = result.value;

                if (reason) {
                    // Proceed with the cancel action, e.g., send the reason to the server
                    // $('#order-cancel-modal').modal('show');

                    // Optionally, make an AJAX request to submit the reason
                    $.ajax({
                        url: "{{ url('orders/cancel') }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        data: {
                            reason: reason,
                            order_id: orderId,
                            // other data if needed
                        },
                            beforeSend: function() {
                                $(".se-pre-con").fadeIn('slow');
                            },
                            success: function(response) {
                            // Handle success
                            console.log('Order canceled:', response);
                            location.reload();
                        },
                        error: function(error) {
                            // Handle error
                            console.error('Error canceling order:', error);
                        }
                    });
                }
            }else if(result.dismiss == 'cancel'){

            }else {
                    // Handle case where no reason is provided if needed
                    Swal.fire({

                        title: 'Oops...',
                        text: 'You need to provide a reason for cancellation!'
                    });
                }
        });
    });




    function submit_or_reject_modal(button) {
        var form = $(button).closest('form');

        var formData = {};

        form.find(':input').each(function() {
            var name = $(this).attr('name');
            var value = $(this).val();

            formData[name] = value;
        });

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                if(response.status == 200){
                    window.location.reload();
                }
                if (response.status == 201) {
                    window.location.href = "{{ route('orders') }}";
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

</script>

<script>
    $(document).ready(function () {
        $('#customer_address_type').change(function () {
            var addressType = $(this).val();
            if (addressType == 2) {
                $('#receiver_name').val('{{ !empty(trim($order->contactDetails->receiver_name ?? '')) ? $order->contactDetails->receiver_name : trim(($order->contactDetails->first_name ?? '') . ' ' . ($order->contactDetails->last_name ?? '')) }}');
                $('#shipping_address2').val('{{ $order->contactDetails['shipping_street'] ?? '--' }}');
                $('#shipping_address1').val('{{ $order->contactDetails['apartment'] ?? '--' }}');
                $('#shipping_address3').val('{{ $order->contactDetails['shipping_city'] ?? '' }} {{ $order->contactDetails['shipping_state'] ?? '' }} {{ $order->contactDetails['shipping_zip'] ?? '' }}');
                $('#shipping_address4').val('{{ $order->contactDetails['shipping_country'] ?? '--' }}');
                // $('#shipping_address2').val('{{ $order->contactDetails->shipping_street ?? '--' }}');
                // $('#shipping_address1').val('{{ $order->contactDetails->apartment ?? '--' }}');
                // $('#shipping_address3').val('{{ trim(($order->contactDetails->shipping_city ?? '') . ' ' . ($order->contactDetails->shipping_state ?? '') . ' ' . ($order->contactDetails->shipping_zip ?? '')) }}');
                // $('#shipping_address4').val('{{ $order->contactDetails->shipping_country ?? '--' }}');
            } else if (addressType == 3) {
                $('#receiver_name').val('{{ !empty(trim($order->contactDetails->receiver_name2 ?? '')) ? $order->contactDetails->receiver_name2 : trim(($order->contactDetails->first_name ?? '') . ' ' . ($order->contactDetails->last_name ?? '')) }}');
                $('#shipping_address2').val('{{ $order->contactDetails['shipping_street_2'] ?? '--' }}');
                $('#shipping_address1').val('{{ $order->contactDetails['apartment2'] ?? '--' }}');
                $('#shipping_address3').val('{{ $order->contactDetails['shipping_city_2'] ?? '' }} {{ $order->contactDetails['shipping_state_2'] ?? '' }} {{ $order->contactDetails['shipping_zip_2'] ?? '' }}');
                $('#shipping_address4').val('{{ $order->contactDetails['shipping_country_2'] ?? '--' }}');
                // $('#shipping_address2').val('{{ $order->contactDetails->shipping_street_2 ?? '--' }}');
                // $('#shipping_address1').val('{{ $order->contactDetails->apartment2 ?? '--' }}');
                // $('#shipping_address3').val('{{ trim(($order->contactDetails->shipping_city_2 ?? '') . ' ' . ($order->contactDetails->shipping_state_2 ?? '') . ' ' . ($order->contactDetails->shipping_zip_2 ?? '')) }}');
                // $('#shipping_address4').val('{{ $order->contactDetails->shipping_country_2 ?? '--' }}');
            }
        });

        $("#collect_payment_via_ec").change(function () {
            if ($(this).is(":checked")) {
                $("#thanks_div").removeClass("col-md-12").addClass("col-md-7");
                $("#order_sum_of_payments").css("display", "block");
                $("#go_to_payments_btn").css("display", "");
            } else {
                $("#thanks_div").removeClass("col-md-7").addClass("col-md-12");
                $("#order_sum_of_payments").css("display", "none");
                $("#go_to_payments_btn").css("display", "none");
            }
        });
    });

    $('input[name="discount"]').on('change', function () {
        $('#discountType').val($('input[name="discount"]:checked').val());
    });

    $('select').select2();

    function EyeIconClick(OrderItemID){
        const elementToClick = document.getElementById('eyeIconFunc_'+OrderItemID);
        if (elementToClick) {
        elementToClick.click();
        }
    }

    function CheckMyFnc(){
        //console.log('Here Working !');
        // addDefaultAddressDetails();
    }

    function edit_saved_items(sub_pro_no, order_item){
        update_product_details(sub_pro_no, order_item);
        $('#edit_item_modal').modal('show');
    }

    function delete_saved_item(order_item_no) {
            var orderId = order_item_no.id;

            swal({
                title: "Confirm Delete?",
                text: "Do You Want to Delete This Order Item?",
                type: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: '#2dce89',
                closeOnConfirm: false,
                closeOnCancel: true
            })
            .then(function(willDelete){
                if (willDelete.value) {
                    // Use the route() function to generate the URL
                    var deleteUrl = "{{ route('deleteOrder', ['id' => ':orderId']) }}";
                    deleteUrl = deleteUrl.replace(':orderId', orderId);
                    window.location.href = deleteUrl;
                } else if(willDelete.dismiss == 'cancel') {
                    console.log('cancel');
                }
            });
        };

        function remake_as_studio_item(orderItem) {
            var itemId = orderItem;

            swal({
                title: "Add as Studio Item?",
                text: "Are you sure you want to add this item as a Studio Item? It will be delivered to the studio and billed separately as an inventory order.",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                confirmButtonText: 'Yes, Add as Studio Item',
                closeOnConfirm: false,
                closeOnCancel: true
            })
            .then(function(result){
                if (result.value) {
                    $.ajax({
                        url: "{{ route('order.remake_studio_item') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order_item_id: itemId
                        },
                        success: function(response) {
                            if (response.success) {
                                swal({
                                    title: "Success!",
                                    text: response.message,
                                    type: "success"
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal("Error", response.message || "Failed to remake item.", "error");
                            }
                        },
                        error: function(xhr) {
                            var errMsg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : "An error occurred while creating studio remake item.";
                            swal("Error", errMsg, "error");
                        }
                    });
                }
            });
        }

        function toggleStudioItems() {
            var $studioRows = $('.studio-item-row');
            var $icons = $('.toggle-studio-icon');
            var $texts = $('.toggle-studio-text');

            if ($studioRows.is(':visible')) {
                $studioRows.hide();
                $icons.removeClass('fa-eye-slash').addClass('fa-eye');
                $texts.text('Show Studio Items');
                $('#studio_item_summery_qty_tr').hide(200);
            } else {
                $studioRows.show();
                $icons.removeClass('fa-eye').addClass('fa-eye-slash');
                $texts.text('Hide Studio Items');
                $('#studio_item_summery_qty_tr').show(200);
            }
        }

</script>

<script>

    function updateTotal() {
        var shipping = parseFloat($('#shipping').val().replace(/,/g, '')) || 0;
        var subTotal = parseFloat($('#sub_total').val().replace(/,/g, '')) || 0;
        var artwork = parseFloat($('#artwork').val().replace(/,/g, '')) || 0;
        var isDiscountAvailable= $('#add_discount').is(':checked') || false;
        var sales_tax_display = parseFloat($('#sales_tax_display').text()) || 0;
        var discountType = $('input[name="discount"]:checked').val();
        var discountValue = parseFloat($('#discount_value').val()) || 0;
        var paid_full_amount = parseFloat($('#paid_full_amount').val().replace(/,/g, '')) || 0;

        totalWithoutDisc = subTotal + artwork ;

        var discountAmount = 0;
        if( isDiscountAvailable){
            if (discountType == 'percentage') {
                discountAmount = (totalWithoutDisc / 100) * discountValue;
            } else if (discountType == 'value') {
                discountAmount = discountValue;
            }
        }

        $('#total_invoice_amount').val((totalWithoutDisc - discountAmount).toFixed(2));

        var salesTax = (totalWithoutDisc - discountAmount) * (sales_tax_display / 100);

        $('#sales_tax').val(salesTax.toFixed(2));

        var totalAmount = totalWithoutDisc - discountAmount + salesTax + shipping;

        $('#order_total').val(totalAmount.toFixed(2));
        if ($('#balance_payment').length) {
            $('#balance_payment').val((totalAmount - paid_full_amount).toFixed(2));
        }
    }

    function toggleDiscountRow(IsWork) {
        var checkbox = document.getElementById("add_discount");
        var discountRows = document.querySelectorAll(".discount_row");

        if (checkbox.checked) {
            discountRows.forEach(function(row) {
                row.style.display = "table-row"; // Show each row
            });
        } else {
            discountRows.forEach(function(row) {
                row.style.display = "none"; // Hide each row
        });
        }
        if (IsWork) {
            updateTotal();
        }
    }

    toggleDiscountRow(false);

    $(document).ready(function () {
        var orderStatusSelect = $('#order_status_id');
        var isUrgentInput = $('#is_urgent');

        var orderFolderExist = @json($orderFolderExist);
        var orderItemQtyExist = @json($orderItemQtyExist);
        var orderInhandExist = @json($orderInhandExist);
        var orderExfactoryExist = @json($orderExfactoryExist);
        var orderEmbellishmentExist = @json($orderEmbellishmentExist);
        var orderItemActive = @json($orderItemActive);

        var dataAlreadySaved = orderStatusSelect.data('alradysaved');

        orderStatusSelect.on('change', function () {
            var selectedValue = $(this).val();

            if (selectedValue == '3') {
                if (orderFolderExist.trim() != '' || orderItemQtyExist.trim() != '' || orderInhandExist.trim() != '' || orderExfactoryExist.trim() != '' || orderEmbellishmentExist.trim() != '' || orderItemActive.trim() != '') {
                    var alert_text = '<div class="text-left mt-2" <ul>';

                    if(orderFolderExist.trim() != ''){
                        alert_text += '<li class="mt-2">Please upload the tech packs for the items below.'+orderFolderExist+'</li>'
                    }
                    if(orderItemQtyExist.trim() != ''){
                        alert_text += '<li class="mt-2">Please add the quantities for the items below.'+orderItemQtyExist+'</li>'
                    }
                    if(orderExfactoryExist.trim() != ''){
                        alert_text += '<li class="mt-2">Please provide the EX-Factory dates for the items below.'+orderExfactoryExist+'</li>'
                    }
                    if(orderInhandExist.trim() != ''){
                        alert_text += '<li class="mt-2">Please provide the in-hand due dates for the items below.'+orderInhandExist+'</li>'
                    }
                    if(orderEmbellishmentExist.trim() != ''){
                        alert_text += '<li class="mt-2">Please provide the embellishment types for the items below.'+orderEmbellishmentExist+'</li>'
                    }
                    if(orderItemActive.trim() != ''){
                        alert_text += '<li class="mt-2">Please add active products for the items below.'+orderItemActive+'</li>'
                    }
                    alert_text += '</ul></div>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Unable to send the order to production',
                        html: alert_text
                    }).then((result) => {
                        $('#order_status_id').val('1').trigger('change');
                    });
                }else{
                    var currentDate = new Date();

                    currentDate.setHours(0, 0, 0, 0);

                    var openDateValue = $('#open_date').val();
                    var exFactoryDateValue = $('#ex_factory_date').val();

                    var openDate = new Date(openDateValue);
                    var exFactoryDate = new Date(exFactoryDateValue);

                    var timeDifference = exFactoryDate - currentDate;

                    var daysDifference = timeDifference / (1000 * 3600 * 24);

                    if (daysDifference < 21) {
                        $('#urgentMassege').modal('show');
                        isUrgentInput.val('1');
                    }
                }
            } else {
                isUrgentInput.val('');
            }
        });

        $('.done').on('click', function () {
            $('#urgentMassege').modal('hide');
        });

        $('.cancel-button').on('click', function () {
            var dataAlreadySavedValue = orderStatusSelect.data('alradysaved');
            orderStatusSelect.val(dataAlreadySavedValue);

            orderStatusSelect.change();

            $('#urgentMassege').modal('hide');
        });
    });

    $('body').on('keydown', '.numseq', function(e) {
        if (e.key == "e") {
            return false;
        }
    });

    $('body').on('keyup', '.numseq', function(e) {

        if (!isNaN(e.key)) {
            var orderItemDetailId = $(this).attr("data-orderItemDetailId");
            var numQty = $(".qtyseq"+orderItemDetailId+"").val();

            if(numQty == 125){
                if($(this).val().length == 1)
                {

                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "6");

                    $("."+orderItemDetailId+"row4Hidden").removeAttr('hidden');

                }
            }

            if(numQty >= 100 && numQty < 125){
                if($(this).val().length == 1)
                {

                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "5");

                    $("."+orderItemDetailId+"row3Hidden").removeAttr('hidden');

                }
            }

            if(numQty >= 75 && numQty < 100){
                if($(this).val().length == 1)
                {

                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "4");

                    $("."+orderItemDetailId+"row2Hidden").removeAttr('hidden');

                }
            }
            if(numQty >= 50 && numQty < 75)
            {
                if($(this).val().length == 1)
                {

                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "3");

                    $("."+orderItemDetailId+"row1Hidden").removeAttr('hidden');

                }

                var below2Lenght = 0;
                if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                    below2Lenght = $(this).closest('tr').next().next().next().find('.counted').length;
                }else if($(this).closest('td').find('.below').length == 1){
                    below2Lenght = $(this).closest('tr').next().next().find('.counted').length;
                }else if($(this).closest('td').find('.below1').length == 1){
                    below2Lenght = $(this).closest('tr').next().find('.counted').length;
                }else if($(this).closest('td').find('.below2').length == 1){
                    below2Lenght = $(this).closest('tr').find('.counted').length;
                }

                if(below2Lenght == 0)
                {
                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "3");
                    $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                }

            }
            if(numQty < 50){
                console.log('print6');
                var below1Lenght = 0;
                if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                    below1Lenght = $(this).closest('tr').next().next().find('.counted').length;
                }else if($(this).closest('td').find('.below').length == 1){
                    below1Lenght = $(this).closest('tr').next().find('.counted').length;
                }else if($(this).closest('td').find('.below1').length == 1){
                    below1Lenght = $(this).closest('tr').find('.counted').length;
                }else if($(this).closest('td').find('.below2').length == 1){
                    below1Lenght = $(this).closest('tr').prev().find('.counted').length;
                }

                var below2Lenght = 0;
                if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                    below2Lenght = $(this).closest('tr').next().next().next().find('.counted').length;
                }else if($(this).closest('td').find('.below').length == 1){
                    below2Lenght = $(this).closest('tr').next().next().find('.counted').length;
                }else if($(this).closest('td').find('.below1').length == 1){
                    below2Lenght = $(this).closest('tr').next().find('.counted').length;
                }else if($(this).closest('td').find('.below2').length == 1){
                    below2Lenght = $(this).closest('tr').find('.counted').length;
                }

                if(below1Lenght == 0 && below2Lenght == 0)
                {
                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "2");
                    $("."+orderItemDetailId+"row1Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                }
            }
        }
        else{

            var below1Lenght = 0;
            if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                below1Lenght = $(this).closest('tr').next().next().find('.counted').length;
            }else if($(this).closest('td').find('.below').length == 1){
                below1Lenght = $(this).closest('tr').next().find('.counted').length;
            }else if($(this).closest('td').find('.below1').length == 1){
                below1Lenght = $(this).closest('tr').find('.counted').length;
            }else if($(this).closest('td').find('.below2').length == 1){
                below1Lenght = $(this).closest('tr').prev().find('.counted').length;
            }

            var below2Lenght = 0;
            if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                below2Lenght = $(this).closest('tr').next().next().next().find('.counted').length;
            }else if($(this).closest('td').find('.below').length == 1){
                below2Lenght = $(this).closest('tr').next().next().find('.counted').length;
            }else if($(this).closest('td').find('.below1').length == 1){
                below2Lenght = $(this).closest('tr').next().find('.counted').length;
            }else if($(this).closest('td').find('.below2').length == 1){
                below2Lenght = $(this).closest('tr').find('.counted').length;
            }



            var orderItemDetailId = $(this).attr("data-orderItemDetailId");
            var numQty = $(".qtyseq"+orderItemDetailId+"").val();
            if(numQty < 50)
            {
                if(below1Lenght == 0 && below2Lenght == 0)
                {
                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "2");
                    $("."+orderItemDetailId+"row1Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row3Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row4Hidden").prop("hidden", true);
                }
            }
            else if(numQty >= 50 && numQty < 75)
            {
                if(below2Lenght == 0)
                {
                    $("."+orderItemDetailId+"rowspans").prop("rowspan", "3");
                    $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row3Hidden").prop("hidden", true);
                    $("."+orderItemDetailId+"row4Hidden").prop("hidden", true);
                }

            }
        }
    });


    $(document).ready(function() {
        function toggleSelect2DisabledState() {
            var isChecked = $('#new_shipping_address').is(':checked');
            $('#customer_address_type').prop('disabled', isChecked).trigger('change');
        };
        toggleSelect2DisabledState();
        if ($('#new_shipping_address').val() == 1) {
            $('.default-address').hide();
            $('.new-address').show();
            //mynewscripy();
        } else {
            $('.default-address').show();
            $('.new-address').hide();
        }

        var shipping_address_type = $('#shipping_address_type').val();
        if (shipping_address_type == 2) {
            $('.shipping-bulk-address').show();
        } else {
            $('.shipping-bulk-address').hide();
            getDefaultPeople(3613);
        }

        // USA Date Fomat
        // $('#open_date').datepicker();
        $('#due_date').datepicker({
  minDate: 0 // Setting minDate to 0 ensures that today's date is the minimum selectable date
});
        // $('#encore_packing_date').datepicker({ minDate: 0});
        // $('#ex_factory_date').datepicker({ minDate: 0});
        $('.datepicker').datepicker({ minDate: 0});
        // $('.item-datepicker').datepicker({ minDate: 0});

        // var itemCount = $('#product_table_body tr').length;
        // $('#row_no').val(itemCount);

        var itemCount = parseInt($('#row_no').val())+1;
        $('#row_no').val(itemCount);

        // item tab click function call i
        if(getUrlParameter('iid')){
            itemTabClick(getUrlParameter('iid'));
        }

        $('#organization_id').on('change', function() {
            var organizationId = $(this).val();
            var selectedOption = $('#organization_id option:selected');
            var plstatus = selectedOption.data('plstatus'); // Retrieve the plstatus attribute

            // Toggle the checkbox based on plstatus
            $('#add_plorder').prop('checked', plstatus === 1);
            console.log('Selected Organization ID:', organizationId);
            console.log('plstatus:', plstatus);

            getPeople(organizationId);

            $('#item_organization').val(organizationId);
        });

        $('#customer_id').on('change', function() {
            var customerId = $(this).val();
            if(customerId){
                getCustomerAddress(customerId);
            }
        });

        $('#user_id').on('change', function() {
            var userId = $(this).val();
            $('#item_support_agent').val(userId);
        });

        // Add Items
        $('#add_item, #mobile_add_item').on('click', function() {
            // var itemNo = $('#row_no').val();
            // $('#item_id').val(itemNo);

            // var orderNo = $('#order_no').val();
            // $('#item_no').val(orderNo + '-' + itemNo);
            addItemReset();
            addItemStart();
            $('#add_item_modal').modal('show');
        });

        // Editd new Item
        $('#order_item_table').on('click', '.edit-item', function(){
            var itemTr = $(this).closest('tr');
            var itemNo = $(this).val();
            addItemReset();
            editItemStart(itemNo, itemTr);
            $('#add_item_modal').modal('show');
        });

        // Editd new Item
        $('#order_item_table').on('click', '.edit-item1', function(){
            var itemTr = $(this).closest('tr');
            console.log(itemTr);
            var itemNo = $(this).val();
            console.log(itemNo);
            addItemReset();
            editItemStart(itemNo, itemTr);
            $('#add_item_modal').modal('show');
            $('#item_product').prop('disabled', true);

        });

        // Remove Item
        // $('#order_item_table').on('click', '.remove-item', function() {
        //     $(this).closest('tr').remove();
        // });
        $(document).on('click', '.remove-item', function () {

            var itemNo = $(this).val();

            // Remove desktop row
            $('tr[data-item-no="' + itemNo + '"]').remove();

            // Remove mobile card
            $('.mobile-item-card[data-item-no="' + itemNo + '"]').remove();

        });

        // Calculate Order Amount
        $('#product_table_body').on('input', '.item-qty', function() {
            var itemQty = $(this).val();
            var itemPrice = $(this).closest('td').next().find('.item-price').val();
            var total = parseFloat(itemQty) * parseFloat(itemPrice);

            $(this).closest('td').next().next().find('.item-total').val(total);

            var qty = 0;
            var sum = 0;

            $('.item-qty').each(function() {
                qty += parseFloat(this.value);
            });
            $('.item-total').each(function() {
                sum += parseFloat(this.value);
            });
            $('#order_summery_qty').val(qty);
            $('#sub_total').val(sum.toFixed(2));

            updateTotal();
        });

        $('#product_table_body').on('input', '.item-price', function() {
            var itemQty = $(this).closest('td').prev().find('.item-qty').val();
            var itemPrice = $(this).val();
            var total = parseFloat(itemQty) * parseFloat(itemPrice);

            $(this).closest('td').next().find('.item-total').val(total);

            var qty = 0;
            var sum = 0;

            $('.item-qty').each(function() {
                qty += parseFloat(this.value);
            });
            $('.item-total').each(function() {
                sum += parseFloat(this.value);
            });
            $('#order_summery_qty').val(qty);
            $('#sub_total').val(sum.toFixed(2));

            updateTotal();
        });

        $('#invoice_summery_table').on('input', '#shipping', function() {

            var shipping = parseFloat($(this).val().replace(/,/g, '')) || 0;
            var subTotal = parseFloat($('#sub_total').val().replace(/,/g, '')) || 0;
            var artwork = parseFloat($('#artwork').val().replace(/,/g, '')) || 0;
            var isDiscountAvailable= $('#add_discount').is(':checked') || false;
            var sales_tax_display = parseFloat($('#sales_tax_display').text()) || 0;
            var discountType = $('input[name="discount"]:checked').val();
            var discountValue = parseFloat($('#discount_value').val()) || 0;
            var paid_full_amount = parseFloat($('#paid_full_amount').val()) || 0;

            totalWithoutDisc = subTotal + artwork ;

            var discountAmount = 0;
            if( isDiscountAvailable){
                if (discountType == 'percentage') {
                    discountAmount = (totalWithoutDisc / 100) * discountValue;
                } else if (discountType == 'value') {
                    discountAmount = discountValue;
                }
            }

            $('#total_invoice_amount').val((totalWithoutDisc - discountAmount).toFixed(2));

            var salesTax = (totalWithoutDisc - discountAmount) * (sales_tax_display / 100);

            $('#sales_tax').val(salesTax.toFixed(2));

            var totalAmount = totalWithoutDisc - discountAmount + salesTax + shipping;

            $('#order_total').val(totalAmount.toFixed(2));
            if ($('#balance_payment').length) {
                $('#balance_payment').val((totalAmount - paid_full_amount).toFixed(2));
            }


        });

        $('#invoice_summery_table').on('input', '#artwork', function() {

            var artwork = parseFloat($(this).val().replace(/,/g, '')) || 0;
            var shipping = parseFloat($('#shipping').val().replace(/,/g, '')) || 0;
            var subTotal = parseFloat($('#sub_total').val().replace(/,/g, '')) || 0;
            var isDiscountAvailable= $('#add_discount').is(':checked') || false;
            var sales_tax_display = parseFloat($('#sales_tax_display').text()) || 0;
            var discountType = $('input[name="discount"]:checked').val();
            var discountValue = parseFloat($('#discount_value').val()) || 0;
            var paid_full_amount = parseFloat($('#paid_full_amount').val().replace(/,/g, '')) || 0;

            totalWithoutDisc = subTotal + artwork ;

            var discountAmount = 0;
            if( isDiscountAvailable){
                if (discountType == 'percentage') {
                    discountAmount = (totalWithoutDisc / 100) * discountValue;
                } else if (discountType == 'value') {
                    discountAmount = discountValue;
                }
            }

            $('#total_invoice_amount').val((totalWithoutDisc - discountAmount).toFixed(2));

            var salesTax = (totalWithoutDisc - discountAmount) * (sales_tax_display / 100);

            $('#sales_tax').val(salesTax.toFixed(2));

            var totalAmount = totalWithoutDisc - discountAmount + salesTax + shipping;

            $('#order_total').val(totalAmount.toFixed(2));
            if ($('#balance_payment').length) {
                $('#balance_payment').val((totalAmount - paid_full_amount).toFixed(2));
            }
        });

        $('#invoice_summery_table').on('input', '#processing_fee', function() {

            var shipping = parseFloat($('#shipping').val().replace(/,/g, '')) || 0;
            var subTotal = parseFloat($('#sub_total').val().replace(/,/g, '')) || 0;
            var artwork = parseFloat($('#artwork').val().replace(/,/g, '')) || 0;
            var isDiscountAvailable= $('#add_discount').is(':checked') || false;
            var sales_tax_display = parseFloat($('#sales_tax_display').text()) || 0;
            var discountType = $('input[name="discount"]:checked').val();
            var discountValue = parseFloat($('#discount_value').val()) || 0;
            var paid_full_amount = parseFloat($('#paid_full_amount').val().replace(/,/g, '')) || 0;

            totalWithoutDisc = subTotal + artwork ;

            var discountAmount = 0;
            if( isDiscountAvailable){
                if (discountType == 'percentage') {
                    discountAmount = (totalWithoutDisc / 100) * discountValue;
                } else if (discountType == 'value') {
                    discountAmount = discountValue;
                }
            }

            $('#total_invoice_amount').val((totalWithoutDisc - discountAmount).toFixed(2));

            var salesTax = (totalWithoutDisc - discountAmount) * (sales_tax_display / 100);

            $('#sales_tax').val(salesTax.toFixed(2));

            var totalAmount = totalWithoutDisc - discountAmount + salesTax + shipping;

            $('#order_total').val(totalAmount.toFixed(2));
            if ($('#balance_payment').length) {
                $('#balance_payment').val((totalAmount - paid_full_amount).toFixed(2));
            }
        });

        $('#invoice_summery_table').on('input', '#discount_value', updateTotal);

        // Update total when the discount type changes
        $('input[name="discount"]').on('change', updateTotal);

        $('body').on('click', '#new_shipping_address', function() {
            if ($(this).is(':checked')) {
                $(this).val(1);
                // $('#customer_address_type').prop('disabled', true); // Disable the select element
                $('#customer_address_type').attr('disabled', 'disabled');
                $('.default-address').hide();
                $('.new-address').show();
                $('#receiver_name').removeAttr('readonly');
                var button = document.getElementById("address_save_btn");
                button.style.display = "block";
                //mynewscripy();

                // Clear all new address fields when user manually checks
                $('#new_receiver_name').val('');
                $('#new_Apartment').val('');
                $('#new_street').val('');
                $('#new_city').val('');
                $('#new_state').val('');
                $('#new_postal_code').val('');
                $('#new_country').val('');
                $('#new_phone_no').val('');
                $('#new_email').val('');
            } else {
                $(this).val(0);
                // $('#customer_address_type').prop('disabled', false); // Enable the select element
                $('#customer_address_type').removeAttr('disabled');
                $('.default-address').show();
                $('.new-address').hide();
                $('#receiver_name').attr('readonly', true);
                var button = document.getElementById("address_save_btn");
                button.style.display = "none";
            }
        });

        $('body').on('click', '#address_save_btn', function() {

            var orderID = $('#order_id').val();
            var selectedAddressType = $('#customer_address_type').val() ?? 3;

            var selectedCustomerId = $('#customer_id').val();
            var new_street = document.getElementById("new_street").value;
            var new_Apartment = document.getElementById("new_Apartment").value;
            var new_city = document.getElementById("new_city").value;
            var new_state = document.getElementById("new_state").value;
            var new_postal_code = document.getElementById("new_postal_code").value;
            var new_country = document.getElementById("new_country").value;

            // var receiver_name = document.getElementById("receiver_name") ? document.getElementById("receiver_name").value : null;
            var receiverNameInput = document.querySelector('.new-address input[name="receiver_name"]');
            var receiver_name = receiverNameInput ? receiverNameInput.value : null;

            // AJAX request to save the data
            $.ajax({
                url: "{{ url('people/update/address') }}", // Replace 'your_save_url' with the actual URL to save the data
                type: 'POST', // or 'GET', 'PUT', 'DELETE', etc. depending on your backend endpoint
                data: {
                    "_token": "{{ csrf_token() }}", // Include CSRF token for Laravel
                    order_id: orderID,
                    customer_id: selectedCustomerId,
                    new_street: new_street,
                    new_Apartment:new_Apartment,
                    new_city: new_city,
                    new_state: new_state,
                    new_postal_code: new_postal_code,
                    new_country: new_country,
                    receiver_name: receiver_name,
                    address_type: selectedAddressType
                },
                dataType: 'json',
                beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                },
                success: function(response) {
                    // Handle success response
                    console.log('Data saved successfully:', response.success);
                    Swal.fire({
                            title: "Done!",
                            text: response.success,
                            type: "success",
                            allowOutsideClick: false,
                        })
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error occurred while saving data:', error);
                    Swal.fire({
                            type: 'error',
                            title: 'Apologies',
                            text: response.error
                        });
                },
                complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
            });
        });
    });

    function copyLink() {
        var copyText = document.getElementById("customer_roster_link");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        navigator.clipboard.writeText(copyText.value);
    }

    $('.deleteMainorder').on('click', function() {
        var orderId = $(this).val();

        Swal.fire({
            title: "Confirm Delete?",
            text: "Do You Want to Delete This Order?",
            type: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            closeOnConfirm: false,
            closeOnCancel: true

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                window.location.href = "{{ url('orders/deleteMainOrder') }}/" + orderId;
            }
        });
    });

    $('body').on('change', '#ex_factory_date', function () {
    var atrExFactoryDate = $(this);
    var new_ex_factory_date = $(this).val();
    var pre_ex_factory_date = $(this).attr('data-AlradySaved');
    var order_id = $('#order_id').val();
    var order_type = $("#order_type").val();
    var address_type = $("#address_type").val();
    var in_hand_due_date = $("#due_date").val();

    // Calculate difference in days
    var start = new Date(new_ex_factory_date),
        end   = new Date(in_hand_due_date),
        diff = new Date(end - start);
    var days = diff / 1000 / 60 / 60 / 24;

    console.log(days);

    if (in_hand_due_date == '') {
        Swal.fire({
            icon: 'error',
            title: 'Please Select In Hand Date!',
            text: 'You need to select the in-hand due date first.'
        });
        atrExFactoryDate.val(pre_ex_factory_date);
        return;
    }

    (async () => {
        const { value: formValuesEx, isConfirmed, isDismissed } = await Swal.fire({
            icon: 'warning',
            title: 'Please insert a reason!',
            html: '<input type="text" placeholder="Reason" id="swal-input-reason" class="swal2-input" required>',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Change',
            showLoaderOnConfirm: true,
            showCloseButton: true,
            showCloseButtonTooltip: "Close",
            preConfirm: () => {
                const reason = document.getElementById('swal-input-reason').value;
                if (!reason) {
                    Swal.showValidationMessage('Reason is mandatory!');
                }
                return reason;
            },
            allowOutsideClick: () => !Swal.isLoading()
        });

        // If modal is closed or canceled
        if (isDismissed || !formValuesEx) {
            atrExFactoryDate.val(pre_ex_factory_date);
            return;
        }

        // Proceed if the reason is provided
        if (formValuesEx) {
            $.ajax({
                url: "{{ url('order_details/ex_factory_authenticate') }}",
                method: 'POST',
                data: { reason: formValuesEx, "_token": "{{ csrf_token() }}" },
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    var authresponse = data[0];
                    var reason = data[1];
                    if (authresponse == 'success') {
                        exFactoryDateChange(new_ex_factory_date, order_id, order_type, address_type, pre_ex_factory_date, atrExFactoryDate, reason);
                    } else if (authresponse == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Apologies',
                            text: 'You do not possess the required authorization to carry out this action.'
                        });
                        atrExFactoryDate.val(pre_ex_factory_date);
                    }
                }
            });
        }
    })();
});


    function exFactoryDateChange(new_ex_factory_date, order_id, order_type, address_type, pre_ex_factory_date, atrExFactoryDate, reason){
        Swal.fire({
            title: "Confirm Ex Factory Date Change?",
            text: "Do You Want to Change Ex Factory Date?",
            type: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "In All Order Items",
            cancelButtonText: "Only on Order Details",
            allowOutsideClick: false,

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: '{{ url("order_details/change_ex_factory_date") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'new_ex_factory_date': new_ex_factory_date, 'order_id': order_id, 'order_type':order_type, 'address_type':address_type, 'reason':reason, 'change_type': 1, '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(data) {
                        console.log(data);
                        Swal.fire({
                            title: "Done!",
                            text: "Ex Factory Date Change Successfully!",
                            type: "success",
                            allowOutsideClick: false,
                        })

                        if(order_type == 0 || (order_type == 1 && address_type == 2)){
                            $('#ex_factory_date').val(new_ex_factory_date);
                            $('#est_delivery_date').val(data[0]);
                            // $('#due_date').val(data);

                            // $('.item-ex-factory-date').val(new_ex_factory_date);
                            // $('.item-in-hand-due-date').val(data);
                            // $('.est-delivery-date').val(data);
                        }else if(order_type == 1){
                            $('#ex_factory_date').val(new_ex_factory_date);
                            $('#est_delivery_date').val(data[0]);
                            $('#encore_packing_date').val(data[1]);
                            // $('#due_date').val(data[1]);

                            // $('.item-ex-factory-date').val(new_ex_factory_date);
                            // $('.item-encore-packing-date').val(data[1]);
                            // $('.item-in-hand-due-date').val(data[1]);
                            // $('.est-delivery-date').val(data[1]);
                        }

                        addExFactoryLog(data[2]);
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });

            } else {
                $.ajax({
                    url: '{{ url("order_details/change_ex_factory_date") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'new_ex_factory_date': new_ex_factory_date, 'order_id': order_id, 'order_type':order_type, 'address_type':address_type, 'reason':reason, 'change_type': 2, '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(data) {
                        console.log(data);
                        Swal.fire({
                            title: "Done!",
                            text: "Ex Factory Date Change Successfully!",
                            type: "success",
                            allowOutsideClick: false,
                        })

                        if(order_type == 0 || (order_type == 1 && address_type == 2)){
                            $('#ex_factory_date').val(new_ex_factory_date);
                            $('#est_delivery_date').val(data[0]);
                            // $('#due_date').val(data);
                        }else if(order_type == 1){
                            $('#ex_factory_date').val(new_ex_factory_date);
                            $('#est_delivery_date').val(data[0]);
                            $('#encore_packing_date').val(data[1]);
                            // $('#due_date').val(data[1]);
                        }

                        addExFactoryLog(data[2]);

                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }
        });
    }

    function addExFactoryLog(data)
    {
        if(data){
            $('#ex_factory_log_table tr:last').after(
                                                    "<tr>"+
                                                        "<td>"+ formatDate(data.created_at) +"</td>" +
                                                        "<td>"+ data.order_detail.order_no +"</td>" +
                                                        "<td>"+ data.user_detail.name +"</td>" +
                                                        "<td>"+ data.pre_date +"</td>" +
                                                        "<td>"+ data.new_date +"</td>" +
                                                        "<td>"+ data.reason +"</td>" +
                                                    "</tr>"
                                                );
        }
    }

    function formatDate(date) {
     var d = new Date(date),
         month = '' + (d.getMonth() + 1),
         day = '' + d.getDate(),
         year = d.getFullYear();

     if (month.length < 2) month = '0' + month;
     if (day.length < 2) day = '0' + day;

     return [month, day, year].join('/');
 }


    $('body').on('change', '#encore_packing_date', function () {
        var new_encore_packing_date = $(this).val();
        var order_id = $('#order_id').val();
        var order_type = $("#order_type").val();
        var address_type = $("#address_type").val();

        Swal.fire({
            title: "Confirm Encore Packing Date Change?",
            text: "Do You Want to Change Encore Packing Date?",
            type: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "In All Order Items",
            cancelButtonText: "Only on Order Details",
            allowOutsideClick: false,

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: '{{ url("order_details/change_encore_packing_date") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'new_encore_packing_date': new_encore_packing_date, 'order_id': order_id, 'order_type':order_type, 'address_type':address_type, 'change_type': 1, '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(data) {
                        console.log(data);
                        Swal.fire({
                            title: "Done!",
                            text: "Encore Packing Date Change Successfully!",
                            type: "success",
                            allowOutsideClick: false,
                        })
                        $('#ex_factory_date').val(data[0]);
                        $('#encore_packing_date').val(new_encore_packing_date);
                        // $('#due_date').val(data[1]);

                        $('.item-ex-factory-date').val(data[0]);
                        $('.item-encore-packing-date').val(new_encore_packing_date);
                        $('.item-in-hand-due-date').val(data[1]);
                        $('.est-delivery-date').val(data[1]);

                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });

            } else {
                $.ajax({
                    url: '{{ url("order_details/change_encore_packing_date") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'new_encore_packing_date': new_encore_packing_date, 'order_id': order_id, 'order_type':order_type, 'address_type':address_type, 'change_type': 2, '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(data) {
                        console.log(data);
                        Swal.fire({
                            title: "Done!",
                            text: "Encore Packing Date Change Successfully!",
                            type: "success",
                            allowOutsideClick: false,
                        })

                        $('#ex_factory_date').val(data[0]);
                        $('#encore_packing_date').val(new_encore_packing_date);
                        // $('#due_date').val(data[1]);

                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }
        });
    });

    $('body').on('change', '#due_date', function () {
        var atrDeuDate = $(this);
        var new_due_date = $(this).val();
        var pre_due_date = $(this).attr('data-AlradySaved');
        var order_id = $('#order_id').val();
        var order_type = $("#order_type").val();
        var order_status = $("#order_status_id").attr('data-AlradySaved');
        var address_type = $("#address_type").val();

        if(order_status == 1){
            dueDateChange(new_due_date, order_id, order_type, address_type, atrDeuDate, pre_due_date, 'not_approved','');
        } else {
            (async () => {
                const { value: formValues } = await Swal.fire({
                    type: 'warning',
                    title: 'Authenication Needed!',
                    html:
                        '<input type="text" placeholder="Reason" id="swal-input-reason" class="swal2-input" required>' +
                        '<input type="text" placeholder="E mail" id="swal-input1" class="swal2-input">' +
                        '<input type="password" placeholder="Password" id="swal-input2" class="swal2-input">',
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Look up',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return [
                        document.getElementById('swal-input1').value,
                        document.getElementById('swal-input2').value,
                        document.getElementById('swal-input-reason').value
                        ]
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })

                if (formValues) {

                    $.ajax({
                        url:"{{ url('order_details/authenticate') }}",
                        method: 'POST',
                        data: { login_details: formValues, "_token": "{{ csrf_token() }}"},
                        dataType: 'json',
                        success: function(data, textStatus, jqXHR){
                            var authresponse = data[0];
                            var reason = data[1];
                            if(authresponse == 'success'){
                                dueDateChange(new_due_date, order_id, order_type, address_type, atrDeuDate, pre_due_date, 'approved',reason);
                            } else if(authresponse == 'email_error'){
                                Swal.fire({
                                    type: 'error',
                                    title: 'Apologies',
                                    text: 'The email address you entered is not correct. Please check your email address!'
                                });
                                atrDeuDate.val(pre_due_date);
                            } else if(authresponse == 'user_error'){
                                Swal.fire({
                                    type: 'error',
                                    title: 'Apologies',
                                    text: 'You do not possess the required authorization to carry out this action.'
                                });
                                atrDeuDate.val(pre_due_date);
                            } else if(authresponse == 'password_error'){
                                Swal.fire({
                                    type: 'error',
                                    title: 'Apologies',
                                    text: 'The password you entered is not correct!'
                                });
                                atrDeuDate.val(pre_due_date);
                            }
                        }
                    });
                }
            })()
        }
    });

    function dueDateChange(new_due_date, order_id, order_type, address_type, atrDeuDate, pre_due_date, authenticate_status, reason){
        Swal.fire({
            title: "Confirm In Hand Due Date Change?",
            html:
                '<p>Do You Want to Change In Hand Due Date? <br> (Ex Factory Date will Change Accordingly)</p>',
            type: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "In All Order Items",
            cancelButtonText: "Only on Order Details",
            allowOutsideClick: false,
            showCloseButton: true,

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: '{{ url("order_details/change_due_date") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'new_due_date': new_due_date, 'order_id': order_id, 'order_type': order_type, 'address_type':address_type, 'authenticate_status':authenticate_status, 'reason':reason, 'change_type': 1, '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(data) {
                        console.log(data);
                        if(data == 'auth_error'){
                            Swal.fire({
                                    type: 'error',
                                    title: 'Apologies',
                                    text: 'You do not possess the required authorization to carry out this action.'
                                });
                            atrDeuDate.val(pre_due_date);
                            return;
                        }

                        Swal.fire({
                            title: "Done!",
                            text: "In Hand Due Date Change Successfully!",
                            type: "success",
                            allowOutsideClick: false,
                        })

                        if(order_type == 0 || (order_type == 1 && address_type == 2)){
                            $('#ex_factory_date').val(data[0]);
                            $('#due_date').val(new_due_date);
                            $('#est_delivery_date').val(data[1]);

                            $('.item-ex-factory-date').val(data[0]);
                            $('.item-in-hand-due-date').val(new_due_date);
                            $('.est-delivery-date').val(new_due_date);
                        }else if(order_type == 1){
                            $('#ex_factory_date').val(data[0]);
                            $('#est_delivery_date').val(data[1]);
                            $('#encore_packing_date').val(data[2]);
                            $('#due_date').val(new_due_date);

                            $('.item-ex-factory-date').val(data[0]);
                            $('.item-encore-packing-date').val(data[2]);
                            $('.item-in-hand-due-date').val(new_due_date);
                            $('.est-delivery-date').val(new_due_date);
                        }
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });

            } else {
                $.ajax({
                    url: '{{ url("order_details/change_due_date") }}',
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'new_due_date': new_due_date, 'order_id': order_id, 'order_type':order_type, 'address_type':address_type, 'authenticate_status':authenticate_status, 'reason':reason, 'change_type': 2, '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function(data) {
                        console.log(data);
                        if(data == 'auth_error'){
                            Swal.fire({
                                    type: 'error',
                                    title: 'Apologies',
                                    text: 'You do not possess the required authorization to carry out this action.'
                                });
                            atrDeuDate.val(pre_due_date);
                            return;
                        }

                        Swal.fire({
                            title: "Done!",
                            text: "In Hand Due Date Change Successfully!",
                            type: "success",
                            allowOutsideClick: false,
                        })
                        if(order_type == 0 || (order_type == 1 && address_type == 2)){
                            $('#ex_factory_date').val(data[0]);
                            $('#est_delivery_date').val(data[1]);
                            $('#due_date').val(new_due_date);
                        }else if(order_type == 1){
                            $('#ex_factory_date').val(data[0]);
                            $('#est_delivery_date').val(data[1]);
                            $('#encore_packing_date').val(data[2]);
                            $('#due_date').val(new_due_date);
                        }
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }
        });
    }

    $('body').on('change', '#order_status_id', function(){
        var newstatus = $(this).val();
        var prestatus = $(this).attr('data-AlradySaved');
        var inHandDDate = $('#due_date').val();

        var orderFactory = true;

        if(newstatus == 3 && inHandDDate == ''){
            Swal.fire({
                title: "Error!",
                text: "In Hand Due Date must be selected first!",
                type: "error",
            });
            $(this).val(prestatus);
            return;
        }

        $('.item-factory').each(function(ind){
            if($(this).val() == ''){
                orderFactory = false;
                return false;
            }
        });

        if(newstatus == 3 && !orderFactory){
            Swal.fire({
                title: "Error!",
                text: "Factory must be selected first!",
                type: "error",
            });
            $(this).val(prestatus);
            return;
        }
    });

    $('body').on('change', '.individual-name', function(){
        var orderItemId = $(this).data('order_item_id');
        if(this.checked) {
            $('#orderRosterName_'+orderItemId).show();
        } else {
            $('#orderRosterName_'+orderItemId).hide();
        }
    });

    $(".numseq").on("focus", function() {
        $(this).on("keydown", function(event) {
            if (event.keyCode === 38 || event.keyCode === 40) {
                event.preventDefault();
            }
        });
    });

    $('body').on('change', '#shipping_direct_ship_to_customers', function(){
        if(this.checked) {
            $('#shipping_bulk_ship_to_coach').prop('checked', false);
            $('#shipping_pick_up').prop('checked', false);
            $('#shipping_direct_pick_up').prop('checked', false);

            $('.shipping-bulk-address').hide();
            getDefaultPeople(3613);

            handleEncorePackingDateField(1);
        }
    });

    $('body').on('change', '#shipping_bulk_ship_to_coach', function(){
        if(this.checked) {
            $('#shipping_direct_ship_to_customers').prop('checked', false);
            $('#shipping_pick_up').prop('checked', false);
            $('#shipping_direct_pick_up').prop('checked', false);

            $('.shipping-bulk-address').show();

            var organizationId = $('#organization_id').val();
            getPeople(organizationId);

            handleEncorePackingDateField(2);
        }
    });

    $('body').on('change', '#shipping_pick_up', function(){
        if(this.checked) {
            $('#shipping_direct_ship_to_customers').prop('checked', false);
            $('#shipping_bulk_ship_to_coach').prop('checked', false);
            $('#shipping_direct_pick_up').prop('checked', false);

            $('.shipping-bulk-address').hide();
            getDefaultPeople(3613);

            handleEncorePackingDateField(3);
        }
    });

    $('body').on('change', '#shipping_direct_pick_up', function(){
        if(this.checked) {
            $('#shipping_direct_ship_to_customers').prop('checked', false);
            $('#shipping_bulk_ship_to_coach').prop('checked', false);
            $('#shipping_pick_up').prop('checked', false);

            $('.shipping-bulk-address').hide();
            getDefaultPeople(3613);

            handleEncorePackingDateField(4);
        }
    });

    function decodeHtml(value) {
        const textarea = document.createElement('textarea');
        textarea.innerHTML = value ?? '';
        return textarea.value;
    }

    function getCustomerAddress(customerId) {
        $.ajax({
            url: "{{ url('new_orders/address') }}/" + customerId,
            method: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data, textStatus, jqXHR) {
                $('#new_shipping_address').prop('checked', false);
                $('.default-address').show();
                $('.new-address').hide();

                $('#shipping_address2').val(data.shipping_street);
                $('#shipping_address1').val(data.apartment);
                $('#shipping_address3').val(data.shipping_city + ', ' + data.shipping_state + ', ' + data.shipping_zip);
                $('#shipping_address4').val(data.shipping_country);
                $('#shipping_address5').val(data.phone_no);
                $('#shipping_address6').val(data.email);
                $('#receiver_name').val(decodeHtml(data.first_name + ' ' + data.last_name).replace(/\s+/g, ' ').trim());
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
                CheckMyFnc();
            }
        });
    }

    function getDefaultPeople(customerId) {
        $.ajax({
            url: "{{ url('new_orders/address') }}/" + customerId,
            method: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data, textStatus, jqXHR) {
                var people_options = '<option value="' + data.id + '">' + data.first_name + ' ' + data.last_name + '</option>';
                $('#customer_id').html(people_options);

                $('#new_shipping_address').prop('checked', false);
                $('.default-address').show();
                $('.new-address').hide();

                $('#shipping_address2').val(data.shipping_street);
                $('#shipping_address1').val(data.apartment);
                $('#shipping_address3').val(data.shipping_city + ', ' + data.shipping_state + ', ' + data.shipping_zip);
                $('#shipping_address4').val(data.shipping_country);
                $('#shipping_address5').val(data.phone_no);
                $('#shipping_address6').val(data.email);
                $('#receiver_name').val(decodeHtml(data.first_name + ' ' + data.last_name).replace(/\s+/g, ' ').trim());
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
                CheckMyFnc();
            }
        });
    }

    function getPeople(organizationId) {
        var shipping_existing_custmer = $('#shipping_existing_custmer').val();
        var shipping_existing_address = $('#shipping_existing_address').val();

        $.ajax({
            url: "{{ url('new_orders/customers') }}/" + organizationId,
            method: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data, textStatus, jqXHR) {
                console.log(data);
                var contactList = data.contact_organizations;
                if (contactList.length > 0) {
                    var organization = data.contact_organizations[0].organizations[0];

                    $('#customer_id').html('');
                    $('<option value="">Select Customer</option>').appendTo($('#customer_id'));

                    for (var i = 0; i < contactList.length; i++) {
                        var contact=contactList[i].contacts[0];

                        var firstName = '';
                        var lastName = '';
                        if (contact.first_name != null) {
                            firstName = contact.first_name;
                        }
                        if (contact.last_name != null) {
                            lastName = contact.last_name;
                        }

                        $('<option value="' + contact.id + '">' + firstName + ' ' + lastName + '</option>').appendTo($('#customer_id'));

                        if(data.user_id != ""){

                            $('#user_id').val(data.user_id).trigger('change');
                            // $('#user_id_display').val(organization.user_id).change();
                            $('#order_procesing_user_id').val(organization.user_id).change();
                            $('#item_support_agent').val(organization.user_id).change();
                        }else{
                            swal({
                            title: "Warning!",
                            text: "Organization you selected does not have a sales rep. Please add a sales rep before choosing this organization.",
                            icon: "warning",
                            buttons: {
                                confirm: {
                                    text: "OK",
                                    value: true,
                                    visible: true,
                                    className: "btn-warning",
                                    closeModal: true
                                }
                            }
                            }).then((value) => {
                                if (value) {
                                    location.reload();
                                }
                            });
                        }

                    }



                    if (organization.sales_tax_active == 1) {
                        $('#sales_tax_display').html(organization.sales_tax);
                        $('#sales_tax_percentage').val(organization.sales_tax);
                    } else {
                        $('#sales_tax_display').html(0);
                        $('#sales_tax_percentage').val(0);
                    }

                } else {
                    $('#customer_id').html('');
                    $('<option value="">No Customers</option>').appendTo($('#customer_id'));
                }

                $('#receiver_name').val('');
                $('#shipping_address2').val('');
                $('#shipping_address1').val('');
                $('#shipping_address3').val('');
                $('#shipping_address4').val('');
                $('#shipping_address5').val('');
                $('#shipping_address6').val('');

                $('#shipping_direct_ship_to_customers').prop('checked', false);
                $('#shipping_bulk_ship_to_coach').prop('checked', true);
                $('#shipping_pick_up').prop('checked', false);
                $('#shipping_direct_pick_up').prop('checked', false);
            },
            complete: function () {
                if (shipping_existing_address == 1) {
                    if (shipping_existing_custmer) {
                        var $option = $('#customer_id').find('option[value="' + shipping_existing_custmer + '"]');
                        if ($option.length > 0) {
                            $('#customer_id').val(shipping_existing_custmer).trigger('change');
                            // $('#customer_id').val(shipping_existing_custmer);
                        } else {
                            $('#customer_id').val('').trigger('change');
                            // $('#customer_id').val('');
                        }
                    } else {
                        $('#customer_id').val('').trigger('change');
                        // $('#customer_id').val('');
                    }

                    $('#new_shipping_address').prop('checked', true);
                    // $('#customer_id').val('').trigger('change');
                    // $('#new_shipping_address').prop('checked', true).val(1);
                    $('.default-address').hide();
                    $('.new-address').show();
                    //mynewscripy();

                } else {
                    if (shipping_existing_custmer) {
                        var $option = $('#customer_id').find('option[value="' + shipping_existing_custmer + '"]');
                        if ($option.length > 0) {
                            $('#customer_id').val(shipping_existing_custmer).trigger('change');
                        } else {
                            $('#customer_id').val('').trigger('change');
                        }
                    } else {
                        $('#customer_id').val('').trigger('change');
                    }

                    $('#new_shipping_address').prop('checked', false);
                    $('.default-address').show();
                    $('.new-address').hide();
                }

                $(".se-pre-con").fadeOut('slow');
                CheckMyFnc();
            }
        });
    }
    // function comfirmchangeItemExFactoryDate(itemID){
    //     var atrExFactoryDate = $("#item_ex_factory_date_"+itemID);
    //     var new_ex_factory_date = $("#item_ex_factory_date_"+itemID).val();
    //     var pre_ex_factory_date = $("#item_ex_factory_date_"+itemID).data("alradysaved");
    //     (async () => {
    //             const { value: formValuesEx } = await Swal.fire({
    //                 type: 'warning',
    //                 title: 'Please insert a reason!',
    //                 html:
    //                     '<input type="text" placeholder="Reason" id="swal-input-reason" class="swal2-input" required>',
    //                 focusConfirm: false,
    //                 showCancelButton: true,
    //                 confirmButtonText: 'Change',
    //                 showLoaderOnConfirm: true,
    //                 showCloseButton: true,
    //                 showCloseButtonTooltip: "Close" ,
    //                 preConfirm: () => {
    //                     return [
    //                     document.getElementById('swal-input-reason').value
    //                     ]
    //                 },
    //                 allowOutsideClick: () => !Swal.isLoading()
    //             })

    //             if (formValuesEx) {
    //                 if(formValuesEx[0] == ''){
    //                     Swal.fire({
    //                         type: 'error',
    //                         title: 'Apologies',
    //                         text: 'Reason is mandatory!'
    //                     });
    //                     atrExFactoryDate.val(pre_ex_factory_date);
    //                     return false;
    //                 }
    //                 $.ajax({
    //                     url:"{{ url('order_details/ex_factory_authenticate') }}",
    //                     method: 'POST',
    //                     data: { reason: formValuesEx[0], "_token": "{{ csrf_token() }}"},
    //                     dataType: 'json',
    //                     success: function(data, textStatus, jqXHR){
    //                         var authresponse = data[0];
    //                         var reason = data[1];
    //                         if(authresponse == 'success'){
    //                             changeItemExFactoryDate(itemID);
    //                             addItemExFactoryDatelog(itemID, new_ex_factory_date, pre_ex_factory_date, reason);
    //                         } else if(authresponse == 'error'){
    //                             Swal.fire({
    //                                 type: 'error',
    //                                 title: 'Apologies',
    //                                 text: 'You do not possess the required authorization to carry out this action.'
    //                             });
    //                             atrExFactoryDate.val(pre_ex_factory_date);
    //                         }
    //                         $("#orderItemSaveBtn").click();
    //                     }
    //                 });
    //             }
    //         })()
    // }
    function addItemExFactoryDatelog(itemID, new_ex_factory_date, pre_ex_factory_date, reason){
        $.ajax({
            url:"{{ url('order_details/add_item_ExFactoryDate_log') }}",
            method: 'POST',
            data: { 'new_ex_factory_date': new_ex_factory_date, 'pre_ex_factory_date': pre_ex_factory_date, 'itemID': itemID, 'reason': reason, '_token':'{{csrf_token()}}'},
            dataType: 'json',
            success: function(data){
                console.log(data);
                return true
            }
        });
    }
    function changeItemExFactoryDate(itemID){
        var ex_factory_date = $("#item_ex_factory_date_"+itemID).val();
        var exist_ex_factory_date =  $("#item_ex_factory_date_" + itemID).data("alradysaved");
        var order_type = $("#order_type").val();
        var address_type = $("#address_type").val();



        if(order_type == 0 || (order_type == 1 && address_type==2)){

            $.ajax({
                url:"{{ url('due_date/ex_factory_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'ex_factory_date': ex_factory_date, 'typeID': 1, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    $('#item_customer_InHand_date_'+itemID).val(data);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }else if(order_type == 1){

            $.ajax({
                url:"{{ url('due_date/ex_factory_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'ex_factory_date': ex_factory_date, 'typeID': 2, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    $('#item_encore_packing_date_'+itemID).val(data[0]);
                    $('#item_customer_InHand_date_'+itemID).val(data[1]);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }

    }

    function changeItemEncorePackingDate(itemID){
        var encore_packing_date = $("#item_encore_packing_date_"+itemID).val();

        $.ajax({
            url:"{{ url('encore_packing_date') }}",
            method:'POST',
            dataType:'json',
            data: {
                'encore_packing_date': encore_packing_date, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data){
                $('#item_ex_factory_date_'+itemID).val(data[0]);
                $('#item_customer_InHand_date_'+itemID).val(data[1]);
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function changeItemCustomerInHandDate(itemID){
        var due_date = $("#item_customer_InHand_date_"+itemID).val();
        var order_type = $("#order_type").val();
        var address_type = $("#address_type").val();

        if(order_type == 0 || (order_type == 1 && address_type==2)){

            $.ajax({
                url:"{{ url('ex_factory_date/due_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'due_date': due_date,'typeID': 1, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    $('#item_ex_factory_date_'+itemID).val(data);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }else if(order_type == 1){

            $.ajax({
                url:"{{ url('ex_factory_date/due_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'due_date': due_date,'typeID': 2, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    $('#item_ex_factory_date_'+itemID).val(data[0]);
                    $('#item_encore_packing_date_'+itemID).val(data[1]);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }
    }
</script>
@if(isset($orderItem))
<script>

    function changeProductName(subProductId , itemID , isworking){

            var order_item = @json($orderItem);
            var isworking = isworking;
            console.log('order item'+order_item);

            $.ajax({
                url:"{{ route('filter_sub_products') }}",
                method:'GET',
                dataType:'json',
                data:{ subProductId : subProductId},
                success: function (response){

                    console.log('product no :'+response.sub_product.sub_product_no);

                    $("#item_style_patter_code_"+itemID).val(response.sub_product.pattern_code);
                    $("#unitprice_"+itemID).val(order_item.unit_price);

                    console.log('is hat value'+response.is_hat);

                    if(response.is_hat == true){
                        $('.forClouser').show();
                    }else{
                        $('.forClouser').hide();
                        $('#clouser_type_item').val('').trigger('change');
                    }


                    $("#orderItem_primaryFabric_" + itemID).html('');
                    if(response.is_hat){
                        $("#orderItem_primaryFabric_" + itemID).prop('disabled', false);
                        var fabrics = @json($fabrics);
                        fabrics = fabrics.filter(function(fabric) {
                            return fabric.available_for_hats == 1;
                        });
                        if (fabrics.length > 0) {
                            $('<option value="" selected>Select Fabric</option>').appendTo($("#orderItem_primaryFabric_" + itemID));
                            for (var i = 0; i < fabrics.length; i++) {
                                if(fabrics[i].id == order_item.fabric_id && isworking){var isSelected = 'selected'}else{var isSelected = ''}
                                console.log('selected value: '+isSelected);
                                $('<option value="'+fabrics[i].id+'" '+isSelected+'>'+fabrics[i].fabric_name+'</option>').appendTo($("#orderItem_primaryFabric_" + itemID));
                            }
                        }

                    }else{
                        $("#orderItem_primaryFabric_" + itemID).prop('disabled', true);
                        console.log('fabric is : '+response.product_fabric);
                        if(response.product_fabric !== null){

                            $('<option value="" selected>'+response.product_fabric+'</option>').appendTo($("#orderItem_primaryFabric_" + itemID));

                        }else{
                            $('<option value="" selected>No fabric</option>').appendTo($("#orderItem_primaryFabric_" + itemID));
                        }
                    }

                    var embellishmentTypeList = response.product_embellishment_type;

                    $("#orderItem_estabilishment_"+itemID).html('');
                    if(embellishmentTypeList.length > 0){

                        $('<option value="">Select an Embellishment</option>').appendTo($("#orderItem_estabilishment_"+itemID));

                        for(var i = 0; i < embellishmentTypeList.length; i++){
                            if(embellishmentTypeList[i].id == order_item.embellishment_type_id && isworking){var isSelected = 'selected'}else{var isSelected = ''}
                            $('<option value="'+ embellishmentTypeList[i].id +'"'+isSelected+'>'+embellishmentTypeList[i].embellishment_name+'</option>').appendTo($("#orderItem_estabilishment_"+itemID));
                        }
                    } else {
                        $('<option value="">No Embellishment</option>').appendTo($("#orderItem_estabilishment_"+itemID));
                    }

                    var productFactory = response.product_factories;

                    $('#factory').html('');

                    if(productFactory.length > 0){
                        if(productFactory.length > 1){
                            for(var i = 0; i < productFactory.length; i++){
                                $('<option value="'+ productFactory[i].id +'">'+productFactory[i].factory_code+'</option>').appendTo($('#factory'));
                            }
                        }else{
                            $('<option value="'+ productFactory[0].id +'" selected>'+productFactory[0].factory_code+'</option>').appendTo($('#factory'));
                        }
                    }

                    if(isworking){
                        $('#secondary_fabric').val(order_item.secondary_fabric_id).trigger('change');
                    }else{
                        $('#secondary_fabric').val('').trigger('change');
                    }


                }
            });
    }
</script>
@endif
<script>

    function changeItemStyleName(itemID){

        var item_style_id = $("#styleName").val();

        var sub_products = @json($subProducts);

        var filteredSubProduct = sub_products.find(function(subProduct) {
            return subProduct.sub_product_no == item_style_id;
        });
        console.log(filteredSubProduct);

        $('#display_name').val(filteredSubProduct.product_name);

        changeProductName(filteredSubProduct.id , itemID , false);
    }

    function handleEncorePackingDateField(new_address_type){
        var address_type = $("#address_type").val();
        $("#address_type").val(new_address_type);

        if(address_type == 2 && new_address_type !=2){
            $("#tr_encore_packing_date").show();
            $(".item_tr_encore_packign_date").show();
            $("#add_item_tr_encore_packing_date").show();
        }else if(address_type != 2 && new_address_type ==2){
            $("#tr_encore_packing_date").hide();
            $(".item_tr_encore_packign_date").hide();
            $("#add_item_tr_encore_packing_date").hide();
        }else if(address_type == 2 && new_address_type ==2){
            $("#tr_encore_packing_date").hide();
            $(".item_tr_encore_packign_date").hide();
            $("#add_item_tr_encore_packing_date").hide();
        }else if(address_type != 2 && new_address_type !=2){
            $("#tr_encore_packing_date").show();
            $(".item_tr_encore_packign_date").show();
            $("#add_item_tr_encore_packing_date").show();
        }
        saveAndCalDatesFields(new_address_type);
    }

    function saveAndCalDatesFields(address_type){

        var new_ex_factory_date = $("#ex_factory_date").val();
        var order_id = $('#order_id').val();
        var order_type = $("#order_type").val();

        $.ajax({
            url: '{{ url("order_details/change_ex_factory_date") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'new_ex_factory_date': new_ex_factory_date, 'order_id': order_id, 'order_type':order_type, 'address_type':address_type, 'change_type': 1, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);
                if(address_type == 2){
                    $('#ex_factory_date').val(new_ex_factory_date);
                    // $('#due_date').val(data);

                    $('.item-ex-factory-date').val(new_ex_factory_date);
                    $('.item-in-hand-due-date').val(data);
                    $('.est-delivery-date').val(data);
                }else{
                    $('#ex_factory_date').val(new_ex_factory_date);
                    $('#encore_packing_date').val(data[0]);
                    // $('#due_date').val(data[1]);

                    $('.item-ex-factory-date').val(new_ex_factory_date);
                    $('.item-encore-packing-date').val(data[0]);
                    $('.item-in-hand-due-date').val(data[1]);
                    $('.est-delivery-date').val(data[1]);
                }
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function itemTabClick(itemID){

        var item_style_id = $("#styleName").val();
        console.log('this is test 1'+item_style_id);

        var sub_products = @json($subProducts);

        var filteredSubProduct = sub_products.find(function(subProduct) {
            return subProduct.sub_product_no == item_style_id;
        });

        // changeProductName(filteredSubProduct.id , itemID , true);


        // $.ajax({
        //     url: '{{ url("order_details/get_item_product_details") }}',
        //     type: "POST",
        //     dataType: 'json',
        //     data: {
        //         'itemID': itemID, 'productID': productID, 'selectedFabricID': selectedFabricID, 'selectedEmbellishmentID': selectedEmbellishmentID, 'selectedAttributeIDs': selectedAttributeIDs, 'sub_productID': sub_productID
        //     },
        //     beforeSend: function () {
        //         $(".se-pre-con").fadeIn('slow');
        //     },
        //     success: function(data) {

        //         $("#orderItem_primaryFabric_"+itemID).html(data[0]);
        //         if(data[3] == false){
        //             $('.forClouser').hide();
        //             $('#clouser_type').val('').trigger('change');
        //         }else{
        //             $('.forClouser').show();
        //         }

        //         $("#orderItem_estabilishment_"+itemID).html(data[1]);
        //         $("#attribute_tbody_"+itemID).html(data[2]);

        //     },
        //     complete: function () {
        //         $(".se-pre-con").fadeOut('slow');
        //     }
        // });
    }

    function attribute_select(e){
        var id = $(e). attr('id');
        var isChecked = $(e).is(':checked');

        var id_split = id.split("_");
        var itemID = id_split[1];
        var attrID = id_split[2];

        $.ajax({
            url: '{{ url("order_details/update_item_attributes") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'itemID': itemID, 'attrID': attrID, 'isChecked': isChecked
            },
            success: function(data) {
            }
        });
    }

    function view_mockup_images(productID){
        $('#modal_view_mockup_images').modal('show');
        $.ajax({
            url: '{{ url("order_details/get_product_mockup_images") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'productID': productID
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {

                $("#preview_mockup_img_1").removeAttr('src');
                $("#preview_mockup_img_2").removeAttr('src');
                $("#preview_mockup_img_3").removeAttr('src');

                if(data[0] != "" && data[0] != null){
                    $("#preview_mockup_img_1").attr("src", window.location.origin+"/uploads/products/"+productID+"/"+data[0]);
                }else{
                    $("#preview_mockup_img_1").attr("src", window.location.origin+"/uploads/default_img.jpg");
                }
                if(data[1] != "" && data[1] != null){
                    $("#preview_mockup_img_2").attr("src", window.location.origin+"/uploads/products/"+productID+"/"+data[1]);
                }else{
                    $("#preview_mockup_img_2").attr("src", window.location.origin+"/uploads/default_img.jpg");
                }
                if(data[2] != "" && data[2] != null){
                    $("#preview_mockup_img_3").attr("src", window.location.origin+"/uploads/products/"+productID+"/"+data[2]);
                }else{
                    $("#preview_mockup_img_3").attr("src", window.location.origin+"/uploads/default_img.jpg");
                }

            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function loadingStart() {
        var allFieldsNotEmpty = true;
        $('#order_detail_form [required]').each(function() {
            if ($(this).val() === '') {
                allFieldsNotEmpty = false;
                return false;
            }
        });

        if (allFieldsNotEmpty) {
            $(".se-pre-con").fadeIn();
        }
    }


    function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    }

    function uploadFile(orderId) {

        // Get the file from the input element
        const fileInput = document.getElementById('importNameFile');
        const file = fileInput.files[0];

        if (!file) {
            swal({
                type: 'error',
                title: 'Please select a file to upload.',
                showConfirmButton: false,
                timer: 3000
            });
            return;
        }

        var orderStatusCheck = $('#order_status_id').val();
        if (orderStatusCheck != 1) {
            swal({
                type: 'error',
                title: 'Oder cannot be updated!',
                text: 'Order status must be in Quote.',
                showConfirmButton: false,
                timer: 3000
            });
            return;
        }

        var importUrl = '{{ url("orders/import_order_roster") }}';

        // Create FormData object
        const formData = new FormData();
        formData.append('order_id', orderId);
        formData.append('import_file', file);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: importUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            processData: false,
            contentType: false,
            beforeSend: function(){
                swal.fire({
                    title: 'Loading...',
                    text: 'Please wait while importing.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        swal.showLoading();
                    }
                });
            },
            success: function(response) {

                if(response.response == 'success'){
                    swal({
                        type: response.response,
                        title: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    location.reload();
                } else {
                    const responseMessage = response.message;

                    const messageArray = responseMessage.split('\n'); // Split by newline
                    const htmlMessage = `<ul>${messageArray.map(msg => `<li style="text-align: left; font-size: 11pt;">${msg}</li>`).join('')}</ul>`;

                    swal({
                        // type: response.response,
                        title: 'Roster file mismatch!',
                        html: htmlMessage, // Use 'html' instead of 'text'
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText); // Check for more details here
            }
        });
    }


</script>

@if (!Gate::check('edit order items'))
    @if (Gate::check('edit order items - factory'))
        <script>
            $(document).ready(function(){
                $(".myForm :input:not(.tablinks):not(.tablinksCustom):not(.no-disable):not(.no-disable-factory)").prop('disabled', true);
                $("#order_detail_form :input:not(.no-disable)").prop('disabled', true);
            });
        </script>

    @else
        <script>
            $(document).ready(function(){
                $(".myForm :input:not(.tablinks):not(.tablinksCustom):not(.no-disable)").prop('disabled', true);
                $("#order_detail_form :input:not(.no-disable)").prop('disabled', true);
            });
        </script>
    @endif
@else
    @if (!Auth::user()->hasRole('Super Admin') && !Auth::user()->hasRole('Admin'))
        <script>
            $(document).ready(function(){
                $('.order-status-id').each(function() {
                    if(this.value != 1){
                        $("#formItem"+this.getAttribute('data-item-id')+" :input:not(.tablinks):not(.tablinksCustom):not(.no-disable):not(.no-disable-factory)").prop('disabled', true);
                    }
                });
                if($('#order_status_id').val() != 1){
                    $("#order_detail_form :input:not(.no-disable)").prop('disabled', true);
                }
            });
        </script>
    @endif
@endif

<script>
    function getOrderItemRows() {
        return $('#product_table_body').children('tr.order-item-row');
    }

    function persistOrderItemOrder() {
        const orderId = $('#product_table_body').data('order-id');
        const itemIds = getOrderItemRows().map(function () {
            return $(this).data('item-id');
        }).get();

        if (!orderId || !itemIds.length) {
            return;
        }

        $.ajax({
            url: '{{ route('order_details.reorder_items') }}',
            method: 'POST',
            data: {
                order_id: orderId,
                item_ids: itemIds,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (!response || !response.success) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Reorder failed',
                        text: (response && response.message) ? response.message : 'Unable to save the new item order.'
                    });
                }
            },
            error: function (xhr) {
                let message = 'Unable to save the new item order.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Reorder failed',
                    text: message
                });
            }
        });
    }

    function initializeOrderItemReorder() {
        const $tbody = $('#product_table_body');
        if (!$tbody.length || typeof $tbody.sortable !== 'function') {
            return;
        }

        if ($tbody.data('ui-sortable')) {
            $tbody.sortable('destroy');
        }

        $tbody.sortable({
            items: '> tr.order-item-row',
            handle: '.item-reorder-handle',
            axis: 'y',
            helper: function (e, tr) {
                const $originals = tr.children();
                const $helper = tr.clone();
                $helper.children().each(function (index) {
                    $(this).width($originals.eq(index).outerWidth());
                });
                return $helper;
            },
            start: function (event, ui) {
                ui.item.addClass('dragging');
            },
            stop: function (event, ui) {
                ui.item.removeClass('dragging');
                persistOrderItemOrder();
            }
        }).disableSelection();
    }

    $(document).ready(function(){
        $('.visit-button').removeAttr('disabled');
    });
    $(document).ready(function() {
            initializeOrderItemReorder();
            let formChanged = false;
            let changedForm = null;
            let customAlertShown = false;


            $('#footer-button-styles-save').prop('disabled', true);

            function enableSaveButton(form) {
                $('#footer-button-styles-save').prop('disabled', false);
                formChanged = true;
                changedForm = form;
            }

            $('select, textarea, input[type="text"], input[type="checkbox"], input[type="radio"]').on('change input', function() {
                const form = $(this).closest('form').attr('id');
                enableSaveButton(form);
            });


            const forms = document.querySelectorAll("form");
            forms.forEach(form => {
                form.addEventListener("submit", () => {
                    formChanged = false;
                    changedForm = null;
                });
            });

            document.querySelectorAll('a.unsave_event_class').forEach(anchor => {
                anchor.addEventListener('click', function (event) {
                    // Check if form has changed
                    $(".se-pre-con").fadeOut('fast');
                    if (formChanged) {
                        // Prevent default navigation
                        event.preventDefault();

                        // Show SweetAlert confirmation dialog
                        Swal.fire({
                            title: 'You have unsaved changes!',
                            text: 'Do you want to leave this page?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                            cancelButtonText: 'Leave'
                        }).then((result) => {
                            console.log(result);
                            if (result.value) {
                                // User clicked "Leave", navigate away
                                $(".se-pre-con").fadeIn(); // Example: Show loading spinner
                                $(`#${changedForm}`).submit(); // Submit the changed form
                            }else if(result.dismiss == 'cancel'){
                                $(".se-pre-con").fadeIn();
                                window.location.href = anchor.href;
                            }
                            // Optionally handle cancel action if needed
                        });
                    }
                });
            });



        });
</script>

{{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> --}}


