@php
    $activePage = ( $orderTrait->isInventoryOrder($orders[0]->organization_id) ) ? 'inventory_orders' : 'orders';
@endphp

@extends('layouts.app', ['activePage' => $activePage, 'titlePage' => __('Edit Order')])

@section('content')
<head>
    <link type="text/css" rel="stylesheet" href="{{ asset('argon') }}/file_inputs/css/fileinput.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" rel="stylesheet" type="text/css" />
</head>
<style>
    #image_container {
        width: 100px;
        height: 100px;
        margin-left: 15px;
        margin-top: -30px;
        border-radius: 50%;
        overflow: hidden;
    }
    #image_preview {
        width: 100%;
        height: 100%;
    }

    .tab-container {
        border-radius: 6px;
        box-shadow: 0px 2px 6px #0000002e
    }
    .tab {
        overflow: hidden;
        background-color: #ffffff;
    }
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 8px 18px;
        transition: 0.3s;
        font-size: 12px;
        color: #989898;
        border-bottom: 2px solid transparent;
    }
    .tab button.task-tab {
        padding: 0.4rem 0.95rem;
    }
    .tab button:hover {
        background-color: #dbe6fd;
        border-bottom: 2px solid #457bdb;
    }
    .tab button.active {
        background-color: #f1f5fe;
        color: #457bdb;
        border-bottom: 2px solid #457bdb;
    }
    .tabcontent {
        display: none;
        /* padding: 6px 12px; */
        border-top: 1px solid #ccc;
    }
    .tab-input {
        border: none;
        border-bottom: 1px solid #cad1d7;
    }

    /* .no-js #loader { display: none;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; } */
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    /*messagebox*/
    #hiddenNotes
    {
        display:none;
        background-color: #eee;
        border-radius: 5px;
        border: 1px solid #aaa;
        position: fixed;
        width: 300px;
        left: 50%;
        margin-left: -150px;
        padding: 6px 8px 8px;
        box-sizing: border-box;
        text-align: center;
    }
    #hiddenNotes .button {
        background-color: #ccc;
        display: inline-block;
        border-radius: 3px;
        border: 1px solid #aaa;
        padding: 2px;
        text-align: center;
        width: 80px;
        cursor: pointer;
    }
    #hiddenNotes .button:hover
    {
        background-color: #ddd;
    }
    #hiddenNotes .message
    {
        text-align: left;
        margin-bottom: 8px;
    }
    .cusTab .tab {
        float: left;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
        width: 30%;
        height: 300px;
    }

        /* Style the buttons inside the tab */
    .cusTab .tab button {
        display: block;
        background-color: inherit;
        color: black;
        padding: 22px 16px;
        width: 100%;
        border: none;
        outline: none;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        font-size: 17px;
    }

        /* Change background color of buttons on hover */
    .cusTab .tab button:hover {
        background-color: #ddd;
    }

        /* Create an active/current "tab button" class */
    .cusTab .tab button.active {
        background-color: #ccc;
    }

        /* Style the tab content */
    .cusTab .tabcontent {
        float: left;
        padding: 0px 12px;
        border: 1px solid #ccc;
        width: 70%;
        border-left: none;
        height: 300px;
    }

    .radio {
        width: 16%;
        height: calc(1rem + 5px);
    }

    /* For Chrome */
    .blankseq::-webkit-outer-spin-button,
    .blankseq::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* For Firefox */
    .blankseq {
    -moz-appearance: textfield;
    }

    @media (max-width: 1366px) {
        .roster-container {
            overflow: scroll;
        }
        .roster-table {
            width: 200%;
        }
    }

    .highlight{
        background-color: #ffff0082;
    }

    .item-table-inputs{
        width: auto !important;
    }
    .order-header {
        font-family: Helvetica, sans-serif;
        font-size: 25px;
        color: #fff;
        letter-spacing: 2px;
    }
    .second-nav-place {
        background-color: transparent;
        width: 100%;
        height: 50px;
        margin-top: 10px;
        position: relative;
        top: -35px;
    }
    .btn-place {
        position: relative;
        top: 14px;
    }
    .back-btn-bg {
        background-color: #787878;
        width: 100%;
        height: 35px;
        position: relative;
        right: -2px;
        border-radius: 4px;
        border: 1px solid;
        border-color: red;
    }
    .back-btn-font {
        font-family: Helvetica, sans-serif;
        color: white;
        font-size: 58%;
        line-height: 14px;
    }
    .back-btn {
        padding: 0%;
    }
    .back-btn-f0nt-place {
        position: relative;
        top: 3px;
        right: 11px;
    }
    .back-btn-icon-place {
        position: relative;
        top: 9px;
        right: -11px;
    }
    .order-detail-btn {
        background-color: #f6f6f6;
        width: 95%;
        height: 35px;
        position: relative;
        top: 3%;
        right: -1%;;
    }
    .quotation-btn {
        width: 83px;
        height: 25px;
        background-color: #787878;
        position: relative;
        left: -25px;
        top: -12px;
        border: none;
    }
    .url-btn {
        width: 45px;
        height: 25px;
        background-color: #787878;
        position: relative;
        left: -24px;
        top: -12px;
        border: none;
    }
    .edit-btn {
        width: 43px;
        height: 25px;
        background-color: #787878;
        position: relative;
        left: -13px;
        top: -12px;
        border: none;
    }
    .re-order-btn {
        width: 94px;
        height: 25px;
        background-color: #787878;
        position: relative;
        left: -24px;
        top: -12px;
        border: none;
    }
    .quotation-btn-font {
        color: white;
        position: relative;
        font-size: 50%;
        line-height: 12px;
        left: 8px;
        top: -14px;
    }
    .btn-position {
        position: relative;
        right: -50px;
    }
    .btn-icon {
        position: relative;
        left: -22px;
        top: 2px;
    }
    .nav-btn {
        border-bottom: none;
        position: relative;
        top: 0px;
        left: 16px;
    }
    .nav-btn-spec {
        height: 36px;
        width: 33%;
        position: relative;
        left: 2px;
        border-color: transparent;
        padding: 0;
        padding-top: 7px;
        color: white;
        font-size: 13px;
    }
    .card-position {
        width: 109%;
        position: relative;
        left: -6%;
    }
    .order-management-card {
        position: relative;
        top: -61px;
    }
    .div-right-position {
        position: relative;
        right: -6px;
    }
    .link-div {
        margin-top: 0px;
        position: relative;
        bottom: 21px;
        right: 1%;
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
    .btn-top {
        position: relative;
        top: -23px;
    }

    .btn-padding {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btn-right {
        position: relative;
        right: 27px;
    }
    .url-position {
        position: relative;
        top: -4px;
    }
    .reorder-lable {
        position: relative;
        bottom: 4px;
        left: 11px;
    }
    @media only screen and (min-width: 1174px)  and (max-width: 1500px)  {
        .btnlink01{
            display: inline-block;
            width: 32%;
        }
        .btnlink02{
            display: inline-block;
            width: 36%;
        }
        .btnlink03{
            display: inline-block;
            width: 32%;
        }
    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
        .wrapper002 {
            display: grid;
            grid-template-columns: auto auto auto auto;
            grid-gap: 10px;
            padding: 20px;


        }
        .btnlink01{
            display: inline-block;
            top:-20px;
            width: 150px;
        }
        .btnlink02{
            display: inline-block;
            top:-20px;
            width: 150px;
        }
        .btnlink03{
            display: inline-block;
            top:-20px;
            width: 32%;
        }

        .btnsetor002{
            display:none;
        }
        .btnsetor001{
            display: grid;
            grid-template-columns: auto auto auto auto;
            grid-gap: 10px;
            padding: 20px;
        }
        .btnor001{
            display: inline-block;
            width:100px;
        }

    }
    @media screen and (min-width: 600px) and (max-width: 800px) {
        .div_borderbox_cls{

            top:-75%;
        }
    }
    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
        border-bottom: 0.1px solid black !important;
        background-color: unset;
        color:black;
    }
    .nav-fill .nav-item{
        color:#b2b2b2;
    }
    .nav-tabs .nav-link:hover{
        /* border-color: #f6f6f6; */
        border-bottom-color: black !important;
        color: black;
    }
    /* .nav-tabs .nav-link.active{
        border-color: #f6f6f6;
        border-bottom-color: black;

    } */
    .main-content{
        background-color: #ffffff;
    }
    .select2-selection__rendered{
        background-color: #ffffff;
        font-size: 0.7rem !important;
    }
    .card-body{
        margin-top: 1rem;
    }
    .functionalityBtn:hover{
        color:black !important;
    }
    .swal2-title{
        font-size: 1rem !important;
    }
    .swal2-confirm{
        padding: .2em 1.5em !important;
        font-size: 1rem;
        background-color: #0bd700;
        border: unset;
        outline: none;
    }
    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
                box-shadow:  0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
    }

    .desktop_filter_div {
        border-radius: 1rem !important;
    }
    /* .mobile_all_select {
        display: none;
    }
    .mobile_all_select_div {
        display: none;
    } */
    @media (min-width: 769px){
        .back_home_mobile {
            display:none !important;
        }
    }
    @media (max-width: 768px){
        .back_home_mobile {
            padding-bottom: 20px;
        }
        .home-btn-color-mobile {
            color: #475569 !important;
            font-size: 11px;
        }
        .home-btn-color-mobile:hover {
            color: #777777 !important;
        }
        .header-layout {
            margin-bottom: 20px !important;
        }
        .second-nav-place {
            margin-top: 30px;
        }
        .tab_bar_mobile {
            width: 100% !important;
        }
        .btn-place {
            top: unset;
        }
        .nav-btn {
            left: unset;
        }
        .second-nav-place .row.col-md-7.btn-place{
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            justify-content: center;
            margin: 0 auto;
        }
        .tab_bar_mobile{
            width: 100% !important;
            margin: 0 auto;
        }
        .tab_bar_mobile .nav-link{
            flex: 1 1 0;
            text-align: center;
            font-size: 11px !important;
        }
        .nav-btn{
            width: 100%;
            left: 0;
        }
        .mobile_nav_tab {
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 4px 12px 0 #0000001a;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
            border: unset;
            border-bottom: 1px solid black !important;
        }
        .tab_bar_mobile .nav-link {
            border-bottom: unset !important;
            font-size: 9px !important;
        }
        .shipping-details-section {
            order: 2;
            margin-bottom: 15px;
            padding: 0px 30px;
        }
        .shipping-actions-section {
            order: 1;
            margin-top: 0 !important;
            margin-bottom: 15px;
            padding: 0px 30px;
        }
        .mobile_buttons_div_1 {
            /* padding: 0px 30px; */
            padding-bottom: 10px;
        }
        .mobile_buttons_div_2 {
            padding: 0px 30px;
            padding-bottom: 10px;
        }
        .mobile_buttons {
            padding: 5px;
            background-color: white !important;
            border-radius: 5px;
            border: unset !important;
            text-align: center !important;
            /* width: 100%; */
            height: 93%;
        }
        .mobile_right_padding {
            padding-right: 5px;
        }
        .mobile_left_padding {
            padding-left: 5px;
        }
        .mobile_reorder_btn {
            border: unset !important;
        }
        .mobile_dropdown {
            width: 100%;
        }
        .mobile_mt_unset {
            margin-top: unset !important;
        }
        .mobile_width_100 {
            width: 100% !important;
            padding-left: unset !important;
        }
        .mobile_filter_div_1 {
            margin-left: unset !important;
        }
        .mobile_filter_div_2 {
            border: unset !important;
            border-radius: 5px !important;
            width: 100% !important;
            margin-left: unset !important;
            margin-right: unset !important;
            background-color: white !important;
            padding: 5px !important;
        }
        .mobile_filter_div_3 {
            margin-bottom: unset !important;
            border-right: unset !important;
            margin-top: unset !important;
        }
        .scheduler-border{
            background-color: transparent !important;
            padding: 15px !important;
            border-radius: 8px;
        }
        .scheduler-border legend{
            background-color: transparent !important;
            padding: unset !important;
        }
        .mobile_shipping_address {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 1px 2px 0px #14141E0A;
        }
        fieldset.scheduler-border {
            border: unset !important;
            background-color: transparent !important;
            padding: 0 0.4em 0.4em 0.4em !important;
        }
        .mobile_pending_shipment_btn {
            margin-left: 10% !important;
        }
        .shipping-contact-table {
            width: 100% !important;
            background: #f8f9fa;
            border-radius: 12px;
            overflow: hidden;
            margin-top: 10px !important;
        }
        .shipping-contact-table tr {
            display: block;
            padding: 10px 15px;
            border-bottom: 1px solid #e9ecef;
        }
        .shipping-contact-table tr:last-child {
            border-bottom: none;
        }
        .shipping-contact-table td {
            display: block;
            width: 100% !important;
            font-size: 14px;
            color: #495057;
            padding: 0;
            word-break: break-word;
        }
        .name_padding_mobile {
            padding-right: 35px;
        }
        .phone_padding_mobile {
            padding-right: 10px;
        }
        .email_padding_mobile {
            padding-right: 40px;
        }
        .name_font_weight_mobile {
            font-weight: 600;
        }
        .shipping-address-table {
            width: 100% !important;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 10px 12px;
        }
        .shipping-address-table tr {
            display: flex;
            flex-direction: column;
            padding: 8px 15px;
            border-bottom: 1px solid #e9ecef;
        }
        .shipping-address-table tr:last-child {
            border-bottom: none;
        }
        .shipping-address-table td {
            width: 100% !important;
            display: block;
            padding: 0;
            font-size: 14px;
            color: #495057;
        }
        /* Address label line (first td) */
        .shipping-address-table tr:first-child td:first-child {
            font-weight: 600;
            color: #212529;
            margin-bottom: 4px;
        }
        /* keep Address : aligned left same level look */
        .shipping-address-table td:first-child {
            text-align: left;
        }
        .mobile_item_table_div_1 {
            margin-left: unset !important;
        }
        .mobile_item_table_div_2 {
            padding: 13px;
        }
        .mobile_item_table_padding_unset {
            padding: unset !important;
        }
        .mobile_margin_unset {
            margin-top: unset !important;
        }
        .div-right-position {
            right: unset !important;
            padding-left: unset !important;
            padding-right: unset !important;
            padding-top: unset !important;
            padding-bottom: unset !important;
        }
        .table-card-body {
            left: unset !important;
        }
        .mobile_all_select {
            background-color: transparent;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: unset;
            display: block;
        }
        .mobile_all_select_div {
            padding: 0px 30px;
            top: -22px;
            position: relative;
            display: block;
        }
        .mobile_padding_u_top_2 {
            padding: unset !important;
            padding-top: 2rem !important;
        }
        .mobile_padding_unset {
            padding: unset !important;
        }
        .mobile_margin_left_unset {
            margin-left: unset !important;
        }
    }
    @media (max-width:400px){
        .tab_bar_mobile .nav-link {
            border-bottom: unset !important;
            font-size: 8px !important;
        }
        .mobile_buttons,
        .mobile_reorder_btn,
        .dropdown-toggle,
        #copy_link_btn {
            font-size: 10px !important;
            font-weight: 600;
        }
        #shipment_status {
            width: 100%;
        }
    }

</style>

@section('back-btn')
    @if ($orderTrait->isInventoryOrder($orders[0]->organization_id))
        <a href="{{route('inventory_orders')}}" class="home-btn-color unsave_event_class" title="Back to Orders">BACK TO ORDERS</a>
    @else
        <a href="{{route('orders')}}" class="home-btn-color unsave_event_class" title="Back to Orders">BACK TO ORDERS</a>
    @endif
@endsection

@section('back-btn-Mobile')
    {{-- <a href="{{ route('home') }}" class="home-btn-color-mobile" title="Back to home">< BACK TO HOME</a> --}}
    @if ($orderTrait->isInventoryOrder($orders[0]->organization_id))
        <a href="{{route('inventory_orders')}}" class="home-btn-color home-btn-color-mobile unsave_event_class" title="Back to Orders">< BACK TO ORDERS</a>
    @else
        @if($orders[0]->plorder == 1)
            <a href="{{route('plorders')}}" class="home-btn-color home-btn-color-mobile unsave_event_class" title="Back to Orders">< BACK TO ORDERS</a>
        @else
        <a href="{{route('orders')}}" class="home-btn-color home-btn-color-mobile unsave_event_class" title="Back to Orders">< BACK TO ORDERS</a>
        @endif
    @endif
@endsection

<div class="col-md-12 back_home_mobile">
    <strong>
        @yield('back-btn-Mobile')
    </strong>
</div>

<div class="second-nav-place">
    <div class="col-md-12">
        <div class="row">
            @if($emptyInvoice != 0)
                    <div class="row col-md-7 btn-place" id="nav-tab">
                        {{-- <div class="col-md-2 back-btn-bg">
                            <span>
                                <a class="back-btn-font" href="{{route('orders')}}" title="Add New Orders">
                                    <div class="row">
                                        <div class="col-md-6 back-btn back-btn-icon-place">
                                            <i class="fas fa-arrow-left mt-1"></i>
                                        </div>
                                        <div class="col-md-6 back-btn back-btn-f0nt-place">
                                            BACK TO ORDERS
                                        </div>
                                    </div>
                                </a>
                            </span>
                        </div> --}}
                        <div class="col-md-12">
                            <section id="tabs" class="mobile_nav_tab">
                                <nav>
                                    <div class="nav nav-btn nav-tabs nav-fill wrapper002 tab_bar_mobile" id="nav-tab" role="tablist" style="width: 65%;">
                                        @if (request()->has('active_tab')) <input type="hidden" value="{{ request()->get('active_tab') }}" id="active_tab_id" /> @endif

                                        @if (request()->has('notify_field')) <input type="hidden" value="{{ request()->get('notify_field') }}" id="notify_field_id" /> @endif

                                        {{-- @can('manage orders' && 'view order details') --}}
                                        @can('manage orders')
                                            {{-- <a class="nav-btn-spec nav-item nav-link btnlink01" id="invoice-tab" data-toggle="tab" href="#invoice_tab" role="tab" aria-controls="invoice" aria-selected="true">@if (request()->get('iid')) ITEM DETAILS @else ORDER DETAILS @endif</a> --}}
                                            <a style="font-size: 0.7rem;border-bottom: 0.1px solid #b2b2b2" class="nav-btn-spec nav-item nav-link btnlink01 unsave_event_class" onclick="startLoading()" id="invoice-tab" href="{{ url('order_details/edit',[$orderId,'order']) }}?active_tab=order" aria-controls="invoice" aria-selected="true">@if (request()->get('iid')) ITEM DETAILS @else ORDER DETAILS @endif</a>
                                        @endcan

                                        @can('manage order management')
                                            {{-- <a class="nav-btn-spec nav-item nav-link btnlink02" id="order-mangement-tab" data-toggle="tab" href="#order_mangement_tab" role="tab" aria-controls="order_mangement" aria-selected="true">ORDER MANAGEMENT</a> --}}
                                            <a style="font-size: 0.7rem;border-bottom: 0.1px solid #b2b2b2" class="nav-btn-spec nav-item nav-link btnlink02 unsave_event_class" onclick="startLoading()" id="order-mangement-tab" href="{{ url('order_details/edit',[$orderId,'management']) }}" aria-controls="order_mangement" aria-selected="true">ORDER MANAGEMENT</a>
                                        @endcan

                                        @can('manage shipping')
                                            <a style="font-size: 0.7rem;border-bottom: 0.1px solid #b2b2b2" class="nav-btn-spec nav-item nav-link active btnlink03 unsave_event_class" id="Shipping-tab" data-toggle="tab" href="#Shipping_tab" role="tab" aria-controls="Shipping" aria-selected="true">SHIPPING</a>
                                        @endcan
                                    </div>
                                </nav>
                            </section>
                        </div>
                        {{-- <div class="col-md-1">

                        </div> --}}
                    </div>
            @endif


            @foreach ($orderDetails as $orderDetail)
            @foreach ($orderDetail->orderItems as $key=>$orderItem)

            @endforeach
            @endforeach
            <div class="row col-md-5 btn-place">
            </div>
        </div>

    </div>
</div>

<div class="col-md-12 btn-top btn-z container-fluid">
    <div class="row">
        <div class="col-md-8 shipping-details-section">
            <div class="mobile_shipping_address">
                <fieldset class="scheduler-border" style="margin: 0rem !important">
                    <legend class="scheduler-border">&nbsp;&nbsp;Shipping Details
                        <button
                        type="button"
                        class="btn-custom mobile_pending_shipment_btn"
                        id="shipping_pending"
                        style="color: #ffbf49;background-color: #fff7e9; font-size: 0.7rem; border: 1px solid transparent;border-radius: 1rem !important;"
                        disabled>Pending Shipments</button>
                    </legend>
                    <div class="control-group">
                        <div class="row">
                            <div class="col-md-6">
                                <table style="width: 100%" class="mt-2 shipping-contact-table">
                                    <tr>
                                        <td style="width: 100%">
                                            <span class="name_padding_mobile">Name :</span>
                                            <span class="name_font_weight_mobile">
                                                @foreach ($orders[0]->contactOrganizations as $contactOrgs)
                                                    @foreach ($contactOrgs->contacts as $contact)
                                                        @if ($contact->id == $orders[0]->contactDetails->id)
                                                            {{ $contact->first_name ?? '' }}
                                                            {{ $contact->last_name ?? '' }}
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100%">
                                            <span class="phone_padding_mobile">Phone No :</span>
                                            <span class="name_font_weight_mobile">{{ $orders[0]->contactDetails['phone_no'] ?? '--' }}</span>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td style="width: 100%">
                                            <span class="email_padding_mobile">Email :</span>
                                            <span class="name_font_weight_mobile">{{ $orders[0]->contactDetails['email'] ?? '--' }}</span>
                                        </td>
                                    </tr>
                                </table>

                        </div>
                        <div class="col-md-6">
                            <table style="width: 100%" class="mt-2 shipping-address-table">
                                <tr>
                                    <td style="width: 18%">Address :
                                        {{-- @if ($orders[0]->is_new_shipping_address == 3)
                                                {{ $orders[0]->contactDetails['shipping_street_2'] ?? '--' }},
                                                {{ $orders[0]->contactDetails['shipping_city_2'] ?? '' }} {{ $orders[0]->contactDetails['shipping_state_2'] ?? '' }} {{ $orders[0]->contactDetails['shipping_zip_2'] ?? '' }},
                                                {{ $orders[0]->contactDetails['shipping_country_2'] ?? '--' }}
                                            @else
                                                    {{ $orders[0]->contactDetails['shipping_street'] ?? '--' }},
                                                    {{ $orders[0]->contactDetails['shipping_city'] ?? '' }} {{ $orders[0]->contactDetails['shipping_state'] ?? '' }} {{ $orders[0]->contactDetails['shipping_zip'] ?? '' }},
                                                    {{ $orders[0]->contactDetails['shipping_country'] ?? '--' }}
                                            @endif --}}
                                    </td>
                                    <td>
                                        @if($orders[0]->is_new_shipping_address == 1) {{ $orders[0]->apartment ?? '--' }}, @elseif ($orders[0]->is_new_shipping_address == 3) {{ $orders[0]->contactDetails['apartment2'] ?? '--' }}, @else {{ $orders[0]->contactDetails['apartment'] ?? '--' }}, @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        @if ($orders[0]->is_new_shipping_address == 1) {{ $orders[0]->street ?? '--' }}, @elseif ($orders[0]->is_new_shipping_address == 3) {{ $orders[0]->contactDetails['shipping_street_2'] ?? '--' }}, @else {{ $orders[0]->contactDetails['shipping_street'] ?? '--' }}, @endif
                                    </td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        @if ($orders[0]->is_new_shipping_address == 1) {{ $orders[0]->city ?? '' }} {{ $orders[0]->state ?? '' }} {{ $orders[0]->postal_code ?? '' }}, @elseif ($orders[0]->is_new_shipping_address == 3) {{ $orders[0]->contactDetails['shipping_city_2'] ?? '' }} {{ $orders[0]->contactDetails['shipping_state_2'] ?? '' }} {{ $orders[0]->contactDetails['shipping_zip_2'] ?? '' }}, @else {{ $orders[0]->contactDetails['shipping_city'] ?? '' }} {{ $orders[0]->contactDetails['shipping_state'] ?? '' }} {{ $orders[0]->contactDetails['shipping_zip'] ?? '' }}, @endif
                                    </td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        @if ($orders[0]->is_new_shipping_address == 1) {{ $orders[0]->country ?? '--' }}. @elseif ($orders[0]->is_new_shipping_address == 3) {{ $orders[0]->contactDetails['shipping_country_2'] ?? '--' }}. @else {{ $orders[0]->contactDetails['shipping_country'] ?? '--' }}. @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="col-md-4  shipping-actions-section" style="margin-top: 1.5%;">
            <div class="row">
                <div class="col-md-4 mobile_buttons_div_1">
                    <div style="border-right: 1px solid #b2b2b2;" class="mobile_buttons">
                        @can('generate url order detail')
                            <button class="btns-text btns-style btns-card generate_link_btn btnor001 functionalityBtn" id="copy_link_btn" value="{{ $orderDetail->id }}"title="Copy URL" style="outline: unset;color: #b2b2b2;background: none;font-size: 0.7rem; cursor:pointer">
                                <i class="fa fa-clone" aria-hidden="true"></i>&nbsp;&nbsp;COPY URL
                            </button>
                        @endcan

                    </div>
                </div>
                <div class="col-md-4 col-6 mobile_buttons_div_1 mobile_right_padding">
                    <div style="border-right: 1px solid #b2b2b2" class="mobile_buttons">
                        <div class="dropdown dropdown_mobile" style="position: unset;">
                            <button class="btns-text btns-style btns-card dropdown-toggle functionalityBtn" type="button" id="generateDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 0.7rem;color: #b2b2b2;background: none;outline:unset; cursor:pointer;" title="Export">
                                EXPORT
                            </button>
                            <div class="dropdown-menu" aria-labelledby="generateDropdown">
                                @can('generate quote order detail')
                                    <button class="dropdown-item generate_quote_btn" style="outline: unset;font-size: 0.7rem;" value="{{ $orderDetail->id }}" title="Download Quotation">QUOTATION</button>
                                @endcan
                                @can('generate invoice order detail')
                                    <button class="dropdown-item generate_invoice_btn" style="outline: unset;font-size: 0.7rem;" value="{{ $orderDetail->id }}" title="Download Invoice">INVOICE</button>
                                @endcan
                                @can('generate pdf order detail')
                                    <button class="dropdown-item generate_pdf_btn" style="outline: unset;font-size: 0.7rem;" value="{{ $orderDetail->id }}" title="Download PDF">PDF</button>
                                @endcan
                                @can('generate csv order detail')
                                    <button class="dropdown-item generate_csv_btn" style="outline: unset;font-size: 0.7rem;" value="{{ $orderDetail->id }}" title="Download CSV">CSV</button>
                                @endcan
                                @can('generate csv order detail')
                                    @if (str_starts_with($orderDetail->order_no, 'TSR'))
                                        <button class="dropdown-item generate_store_player" style="outline: unset;font-size: 0.7rem;" value="{{ $orderDetail->id }}" title="Player Report">PLAYER REPORT</button>
                                    @endif
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6  mobile_buttons_div_1 mobile_left_padding">
                    <div style="margin-left: 1%;" class="mobile_buttons">
                        @can('re order')
                            <button class="btns-text btns-style btns-card btnor001 functionalityBtn mobile_reorder_btn" title="Re-order" data-toggle="modal" data-target="#re_order_modal" title="Re Order" style="position: relative; z-index: 0; outline: unset; color: #b2b2b2; background: none; font-size: 0.7rem; border: 1px solid #b2b2b2; cursor: pointer;">
                                RE-ORDER
                            </button>
                        @endcan

                    </div>
                </div>
            </div>
            <div class="row mt-3 mobile_mt_unset">
                <div class="col-md-6 col-6 text-left align-self-center mobile_buttons_div_1 mobile_right_padding">
                    <input type="checkbox" id="edit_sent_shipments" style="display: none">
                    <label class="mobile_buttons mobile_width_100" for="edit_sent_shipments" style="margin-bottom: 0px;color: #b3b3b3;margin-top: 1%;padding-left: 10%;"><i class="fa fa-square-o" id="edit_sent_shipments_icon" aria-hidden="true"></i>&nbsp;&nbsp;Edit Shipments</label>
                </div>
                <div class="col-lg-6 col-6 mobile_buttons_div_1 mobile_left_padding" style="text-align: right;">
                    <button class="btns-text functionalityBtn mobile_buttons" title="Summery" id="shipment_summery" style="outline: unset;margin-top: 1%;width: 100%;color: #b2b2b2;background: none;font-size: 0.7rem; cursor:pointer;border:unset;text-align: right;padding-right: 0px;">
                        <i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;&nbsp;SHIPMENT SUMMERY
                    </button>

                </div>
            </div>
            <div class="row mt-3 mobile_mt_unset">
                <div class="col-lg-12 ml-2 mt-1 mobile_filter_div_1 d-flex justify-content-center">
                    <div class="ml-2 row mobile_filter_div_2 desktop_filter_div"style="color: #b2b2b2;background-color: transparent; border: 1px solid #b2b2b2; width: 96%;">
                        <div class="col-lg-4 col-6 mobile_filter_div_3" style="font-size:0.7rem;margin-bottom: 1.5%;border-right:1px solid;margin-top: 0.45rem;">Filter Items</div>
                        <div class="col-lg-8 col-6">
                            <select id="shipment_status">
                                <option>All</option>
                                <option>Pending shipment</option>
                                <option>Data Added</option>
                                <option>Data Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row col-lg-12 card-head url-position" style="display: none;">
    <div class="col-lg-5">
    </div>
    <div class="col-lg-7 control-btns link-div" style="margin-top: 0px;background-color:#f6f6f6">
        <span id="link_container"></span>
        <button type="button" class="btn btn-sm btn-info btn-custom" style="display: none;"
            id="copy_link_btn" title="Copy Link">
            <i class="fas fa-copy"></i>
        </button>
    </div>
</div>

    <div class="container-fluid mb-5 ml-2 btn-top mobile_margin_left_unset">
        <div class="se-pre-con"></div>

        @if($emptyInvoice != 0)

            <div class="col-md-12">
                <div class="">

                    <div class="card-body mobile_padding_u_top_2" style="margin-top: 0rem;">
                        <section id="tabs">
                            <div class="  col-md-12 mobile_padding_unset">
                                <div class="row mt-4 ordetails001">
                                    <div class="col-md-12 ">
                                            {{-- <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                @if (request()->has('active_tab')) <input type="hidden" value="{{ request()->get('active_tab') }}" id="active_tab_id" /> @endif

                                                @if (request()->has('notify_field')) <input type="hidden" value="{{ request()->get('notify_field') }}" id="notify_field_id" /> @endif

                                                @can('manage order management')
                                                    <a class="nav-item nav-link @if(Gate::check('manage order management')) active @endif" id="order-mangement-tab" data-toggle="tab" href="#order_mangement_tab" role="tab" aria-controls="order_mangement" aria-selected="true">Order Mangement</a>
                                                @endcan

                                                @can('manage orders')
                                                    <a class="nav-item nav-link @if(!Gate::check('manage order management') && Gate::check('manage orders')) active @endif" id="invoice-tab" data-toggle="tab" href="#invoice_tab" role="tab" aria-controls="invoice" aria-selected="true">Order</a>
                                                @endcan

                                                @can('manage shipping')
                                                    <a class="nav-item nav-link @if(!Gate::check('manage order management') && !Gate::check('manage orders') && Gate::check('manage shipping')) active @endif" id="Shipping-tab" data-toggle="tab" href="#Shipping_tab" role="tab" aria-controls="Shipping" aria-selected="true">Shipping</a>
                                                @endcan



                                            </div> --}}

                                        <div class="tab-content py-3 px-3 px-sm-0 div-right-position" id="nav-tabContent">
                                            {{-- Order Mangement Tab --}}
                                            @can('manage order management')
                                                <div class="tab-pane fade card card-position order-management-card" id="order_mangement_tab" role="tabpanel" aria-labelledby="invoice-tab" style="padding: 10px; padding-bottom: 36px;">
                                                    {{-- @include('pages.order_management.management.index') --}}
                                                </div>
                                            @endcan

                                            {{-- Invoice Tab --}}
                                            @can('manage orders')
                                                <div class="tab-pane fade" id="invoice_tab" role="tabpanel" aria-labelledby="invoice-tab">
                                                    {{-- @include('pages.order_management.orders.edit') --}}
                                                </div>
                                            @endcan

                                            @can('manage shipping')
                                                <div class="tab-pane fade show active" id="Shipping_tab" role="tabpanel" aria-labelledby="Shipping-tab">
                                                    @include('pages.order_management.orders.shipping')
                                                </div>
                                            @endcan
                                            {{-- Product Category Tab --}}


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        @foreach ($orderDetails as $orderDetail)
                            @if ($orderDetail->is_requested == 1)
                                <div class="col-lg-12 control-btns mt-2 mb-4">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            <h4>Edit Request Received!<br><small>Reasons : {{$orderDetail->request_reasons}}</small></h4>
                                        </div>

                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-success btn-custom" id="accept_request_btn" style="width: 31%" value="{{$orderDetail->id}}">Accept Request</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                    <div id="hiddenNotes">
                        <form>

                            <input type="text" id="orderItemName" style="width: 90%;margin-bottom: 5px;"><br>
                            <input type="hidden" value="" id="orderItemID">
                            <input type="hidden" value="" id="clickedNotebutton">
                            <textarea id="orderItemNotes" rows="5" style="width:90%;"> </textarea><br>

                            <span class="button Save">Save</span>
                            <span class="button Close">Close</span>
                        </form>

                    </div>
                </div>
            </div>
        @else

        @endif
    </div>

    <div class="modal fade" id="re_order_modal" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title-default">Re-Order</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form action="{{ route('new_orders.create_re_order') }}" method="POST" id="re_order_form">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="modal-title" id="modal-title-default" style="position: relative; left: 13px;">Do you want to re-order this order?</h3>
                                @foreach ($orderDetails as $orderDetail)
                                    <input type="hidden" name="exs_order_id" id="exs_order_id" value="{{$orderDetail->id}}" />
                                @endforeach
                            </div>
                        </div>
                        <div class="row mt-3" style="justify-content: space-evenly;">
                            <div class="col-md-4">
                                <input type="radio" class="radio" name="roster" id="no_roster" value="no" checked>
                                <label class="reorder-lable" for="no_roster">Without Roster</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="radio" name="roster" id="with_roster" value="yes">
                                <label class="reorder-lable" for="with_roster">With Roster</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="col-lg-12 control-btns">
                            <button type="submit" class="btn btn-success btn-custom">Re-Order</button>
                            <button type="reset" class="btn btn-secondary btn-custom" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @php
        $remakeStatus = false;
        foreach ($orders[0]->orderItems as $orderItem) {
            if($orderItem->has_remake_item){
                $remakeStatus = true;
                break;
            }
        }
    @endphp
    @section('order-header')
        <span style="font-size: 17px;">{{ $orders[0]->order_no }} - {{$orders[0]->organizationDetails['organization_name']}} @if($remakeStatus) - Remake @endif</span>
    @endsection

    @include('pages.order_management.orders.add_item_modal')
    @include('pages.order_management.order_quotation.image_view_modal')

    {{-- <script src="{{ asset('argon') }}/file_inputs/js/plugins/sortable.min.js" type="text/javascript"></script> --}}
    <script src="{{ asset('argon') }}/file_inputs/js/fileinput.js"></script>
    <script src="{{ asset('argon') }}/file_inputs/themes/fas/theme.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script> --}}
    <script>
        function updateButtonStyles() {
            var buttonText = $('#shipping_pending').text();

            if (buttonText == 'Shipment Completed') {
                $('#shipping_pending').css({
                    'color': 'rgb(38 173 0)',
                    'background-color': 'rgb(197 255 181)'
                });
                enableFulfillButton();
            } else if (buttonText == 'Invalid Quantity') {
                $('#shipping_pending').css({
                    'color': 'rgb(255 79 79)',
                    'background-color': '#ffb9b9'
                });
            } else if (buttonText == 'Pending Shipments') {
                $('#shipping_pending').css({
                    'color': '#ffbf49',
                    'background-color': '#fff7e9'
                });
            } else {
                $('#shipping_pending').css({
                    'color': 'grey',
                    'background-color': 'rgb(237 237 237)'
                });
            }
        }
        $(document).ready(function() {
            updateButtonStyles();
            $('#shipping_pending').on('DOMSubtreeModified', updateButtonStyles);
        });

        function enableFulfillButton() {
            var fulfillButton = document.getElementById('fulfillButton');

            fulfillButton.style.display = 'unset';
            fulfillButton.style.backgroundColor = 'rgb(197 255 181)';
            fulfillButton.style.color = 'rgb(38 173 0)';
        }
        $('#fulfillButton').click(function() {
            var orderId = document.getElementById("notify_order_id").value;
            console.log(orderId);
            $.ajax({
                type: "GET",
                url: "{{ route('fulfill_order') }}",
                data: {
                    orderId: orderId,
                },
                success: function(response) {
                    //console.log(response.message);
                    swal({
                        title: "Order Fulfilled",
                        text: "Order #00" + orderId + " has been successfully fulfilled",
                        buttonsStyling: false,
                        icon: "success",
                        button: "OK"
                    });


                },
                error: function(error) {
                    console.error("Error fulfilling order:", error);
                }
            });
        });

        //copy link to clipboard

        function urlCopyToClipboard(){
            var customerRosterLinkValue = document.getElementById('customer_roster_link').value;
            //console.log(customerRosterLinkValue);
            navigator.clipboard.writeText(customerRosterLinkValue);
            Swal.fire({
                title: "The URL has been successfully copied",
                icon: "success",
                buttonsStyling: false, // Disable default button styling
                confirmButtonColor: '#0bd700', // Set the button color
                confirmButtonText: 'OK', // Set the button text
            });
        }
    </script>
    <script>
        // var orderNum = document.getElementById("notify_order_id").value;
        // var headerSpan = document.getElementById("header");
        // headerSpan.textContent = orderNum+" - ";

        var order_details = <?php echo json_encode($orderDetails) ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        function trigerNotes(btnClicked)
        {
            var orderItemId = $(btnClicked).attr("data-orderItemId");
            var orderItemName = $(btnClicked).attr("data-orderItemName");
            var orderItemNotes = $(btnClicked).attr("data-orderItemNotes");
            var btnID = $(btnClicked).attr("data-btnID");

            document.getElementById("orderItemName").value = "";
            document.getElementById("orderItemID").value = "";
            document.getElementById("orderItemNotes").value = "";
            document.getElementById("clickedNotebutton").value = "";


            doConfirm(orderItemId,orderItemName, orderItemNotes, btnID, function save() {
                $(".se-pre-con").css("display", "block");
                $.ajax({
                    url: "../../order/itemNotesSave",
                    type: "post",
                    data:{
                        //orderItemId: document.getElementById("orderItemName").value,
                        //orderItemName: document.getElementById("orderItemID").value,
                        //orderItemNotes: document.getElementById("orderItemNotes").value
                        orderItemId: document.getElementById("orderItemID").value,
                        orderItemName: document.getElementById("orderItemName").value,
                        orderItemNotes: document.getElementById("orderItemNotes").value,
                        orderItemNotesbtn: document.getElementById("clickedNotebutton").value
                    },
                    dataType: 'json',
                    success: function (response) {
                        if(response[0] == "Done Save Item Note")
                        {
                            $("#"+response[1]+"").attr("data-orderItemNotes",document.getElementById("orderItemNotes").value);
                            alert("Note Saved");
                        }
                        $(".se-pre-con").css("display", "none");
                        //alert(response[0]);
                    }
                });

            }, function cancel(){
                // do something when cancel
            });
        }


        function doConfirm(orderItemID, itemName, orderItemNotes, btnID, saveFn, cancelFn) {
            var confirmBox = $("#hiddenNotes");

            document.getElementById("orderItemName").value = itemName;
            document.getElementById("orderItemID").value = orderItemID;
            document.getElementById("orderItemNotes").value = orderItemNotes;
            document.getElementById("clickedNotebutton").value = btnID;

            confirmBox.find(".Save,.Close").unbind().click(function () {
                confirmBox.hide();
            });
            confirmBox.find(".Save").click(saveFn);
            confirmBox.find(".Close").click(cancelFn);


            confirmBox.show();
        }

        function startLoading(){
            $(".se-pre-con").fadeIn();
        }

        $(document).ready(function(){
            // $(".se-pre-con").fadeOut('slow');

            $('.myForm').on('submit', function(e){
                e.preventDefault();
                $(".se-pre-con").fadeIn('slow');
                $(".myForm :input:not(.tablinks):not(.tablinksCustom):not(.no-disable)").prop('disabled', false);
                $("#order_detail_form :input:not(.no-disable)").prop('disabled', false);
                $('.notify_changes').val($.unique(numberSequencesFilled));
                this.submit();
            });

            $('#re_order_form').on('submit', function(){
                $(".se-pre-con").fadeIn('slow');
            });

            var activeTabId = $('#active_tab_id').val();

            // if(activeTabId == 'order'){
            //     $('#invoice-tab').tab('show');
            // }else if(activeTabId == 'order_mangement_tab'){
            //     $('#order-mangement-tab').tab('show');
            // }else{
            //     $('#invoice-tab').tab('show');
            //     $('#tab_'+activeTabId+'_link').tab('show');
            //     itemTabClick(activeTabId);
            // }

            var notifyField = $('#notify_field_id').val();
            if(notifyField){
                // $("input[name='"+notifyField+"']").addClass('highlight');
                // $("input[name='"+notifyField+"']").focus();
                if(notifyField.includes("double_sided") || notifyField.includes("individual_no") || notifyField.includes("pockets") || notifyField.includes("individual_name") || notifyField.includes("zipper_pockets") || notifyField.includes("dynamic_details") || notifyField.includes("contrast_stratching") || notifyField.includes("printing_over_sems")){
                    $("[name='lbl_"+notifyField+"']").addClass("highlight");
                }else{
                    $("[name='"+notifyField+"']").removeClass("select2-edit-order").addClass("highlight");
                }
            }

            $('.select2-add-item').select2({
                dropdownParent: $('.select-container')
            });

            $('.select2-edit-order').select2();

        console.log(order_details);
        getFiles();

            $("body").on("click", ".delete-order", function(){
                var orderId = $(this).val();

                swal({
                    title: "Confirm Delete?",
                    text: "Do You Want to Delete This OrderItem?",
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
                        window.location.replace('../../orders/delete/'+orderId);
                    } else if(willDelete.dismiss == 'cancel') {
                        console.log('cancel');
                    }
                });
            });

        // Update Order
            $('.save_btn').on('click', function(){
                $("#order_update_btn").trigger("click");
            });

        // Cancel Option
            $('.cancel_btn').on('click', function(){
                location.reload();
            });

        // Generate Quote PDF
            // $('.generate_quote_btn').on('click', function(){
            //     $('#buffering_icon').attr('display', 'block');

            //     var orderId = $(this).val();
            //     window.location.replace('../../orders/quote/'+orderId);
            // });
            $('.generate_quote_btn').on('click', function(){
                var orderId = $(this).val();
                var routeUrl = '{{ route('quotePDF_Download', ['id' => ':id']) }}';
                routeUrl = routeUrl.replace(':id', orderId);
                window.location.replace(routeUrl);
            });

        // Generate Quote CSV
            // $('.generate_csv_btn').on('click', function(){
            //     $('#buffering_icon').attr('display', 'block');

            //     var orderId = $(this).val();
            //     window.location.replace('../../orders/csv/'+orderId);
            // });
            $('.generate_csv_btn').on('click', function(){
                var orderId = $(this).val();
                var routeUrl = '{{ route('quoteCSV_Download', ['id' => ':id']) }}';
                routeUrl = routeUrl.replace(':id', orderId);
                window.location.replace(routeUrl);
            });
            $('.generate_store_player').on('click', function(){
                $('.se-pre-con').fadeIn('slow');
                var orderId = $(this).val();
                var routeUrl = '{{ route('store.generatePlayerCSV', ['id' => ':id']) }}';
                routeUrl = routeUrl.replace(':id', orderId);
                window.location.replace(routeUrl);
            });

        // Generate Invoice PDF
            // $('.generate_invoice_btn').on('click', function(){
            //     $('#buffering_icon').attr('display', 'block');

            //     var orderId = $(this).val();
            //     window.location.replace('../../orders/invoice/'+orderId);
            // });

            $('.generate_invoice_btn').on('click', function(){
                var orderId = $(this).val();
                var routeUrl = '{{ route('invoice_Download', ['id' => ':id']) }}';
                routeUrl = routeUrl.replace(':id', orderId);
                window.location.replace(routeUrl);
            });

        // Generate Link
            $('.generate_link_btn').on('click', function(){
                var orderId = $(this).val();

                $('#link_container').html('');
                $('#link_container').html('<input type="text" id="customer_roster_link" class="invoice-inputs" value="https://encr.co/roster/'+orderId+'" style="width: 80%; background-color: white;" />');
                // $('#link_container').html('<input type="text" class="invoice-inputs" value="http://localhost/roster/'+orderId+'" style="width: 50%;" />');
                //$('#copy_link_btn').show();
                // $('html, body').animate({ scrollTop: $('#link_container').offset().top }, 'slow');
                urlCopyToClipboard();
            });

        // Generate Quote PDF
            $('.generate_pdf_btn').on('click', function(){
                var orderId = $(this).val();
                var routeUrl = '{{ route('PDF_Download', ['id' => ':id']) }}';
                routeUrl = routeUrl.replace(':id', orderId);
                window.location.replace(routeUrl);
            });

        // Accept Request
            $("body").on("click", "#accept_request_btn", function(){
                var orderId = $(this).val();

                swal({
                    title: "Accept Request?",
                    text: "Do You Want to Accept This Request?",
                    type: "warning",
                    buttons: true,
                    dangerMode: true,
                    confirmButtonColor: '#06c5ac',
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.replace('../../order_details/accept_request/'+orderId);
                    }
                });
            });

            // Add Extra Sizes
            var action = 1;
            $("body").on("click", ".add-size", function(){
                var order_id = $(this).val();
                if ( action == 1 ) {
                    $(".order-"+order_id+"-18").show();
                    $(".order-"+order_id+"-21").show();
                    $(".order-"+order_id+"-24").show();
                    action = 2;

                } else {
                    $(".order-"+order_id+"-19").show();
                    $(".order-"+order_id+"-22").show();
                    $(".order-"+order_id+"-25").show();
                    action = 1;
                }
            });


        // adding classes to inserted no sequence
            $('body .numseq').filter(function() {
                return $(this).val() != "" && $(this);
            }).addClass("counted");

            calculateTOTALalQtys();
            calculateTOTALalQtysDefault();

        //calculate TOTALal qty When Adding No sequence
            $("body").on('input', '.numseq', function (){
                console.log($(this).val());
                if($(this).val() != ''){
                    $(this).addClass("counted");
                }else if($(this).val() == ''){
                    $(this).removeClass("counted");
                }

                console.log($(this).closest('td').find('.below1').length + " val-"+ $(this).closest('td').find('.below1').val());

                if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){

                    var countedThis = $(this).closest('tr').find('.counted').length;//row 1
                    var countedBelow = $(this).closest('tr').next().find('.counted').length; // row 2
                    var countedBelow1 = $(this).closest('tr').next().next().find('.counted').length; // row 3
                    var countedBelow2 = $(this).closest('tr').next().next().next().find('.counted').length; // row 4
                    var TOTALal_count = countedThis + countedBelow + countedBelow1 + countedBelow2;
                    $(this).closest('tr').find('.qtyseq').val(TOTALal_count);

                }else if($(this).closest('td').find('.below').length == 1){
                    var countedUpper = $(this).closest('tr').prev().find('.counted').length;//row 1
                    var countedThis = $(this).closest('tr').find('.counted').length;//row 2
                    var countedBelow1 = $(this).closest('tr').next().find('.counted').length; //row 3
                    var countedBelow2 = $(this).closest('tr').next().next().find('.counted').length; //row 4
                    var TOTALal_count = countedThis + countedUpper + countedBelow1 + countedBelow2;
                    $(this).closest('tr').prev().find('.qtyseq').val(TOTALal_count);
                }
                else if($(this).closest('td').find('.below1').length == 1){
                    var countedbelow = $(this).closest('tr').next().find('.counted').length;//row 4
                    var countedThis = $(this).closest('tr').find('.counted').length;//row 3
                    var countedUpper1 = $(this).closest('tr').prev().find('.counted').length;//row 2
                    var countedUpper2 = $(this).closest('tr').prev().prev().find('.counted').length; // row 1
                    var TOTALal_count = countedThis + countedUpper1 + countedUpper2 + countedbelow;
                    $(this).closest('tr').prev().prev().find('.qtyseq').val(TOTALal_count);
                }
                else if($(this).closest('td').find('.below2').length == 1){

                    var countedThis = $(this).closest('tr').find('.counted').length;//row 4
                    var countedUpper1 = $(this).closest('tr').prev().find('.counted').length;//row 3
                    var countedUpper2 = $(this).closest('tr').prev().prev().find('.counted').length;//row 2
                    var countedUpper3 = $(this).closest('tr').prev().prev().prev().find('.counted').length;//row 1
                    var TOTALal_count = countedThis + countedUpper1 + countedUpper2 + countedUpper3;
                    $(this).closest('tr').prev().prev().prev().find('.qtyseq').val(TOTALal_count);
                }

                calculateTOTALalQtys();
            });

        //calculate TOTALal qty When Adding Blanks
            $("body").on('input', '.blankseq', function () {
                calculateTOTALalQtys();
            });
        });

        // $('body').on('click', '.view-image', function(){
        //     console.log('works');
        // });

        $('.ex-factory').on('change', function(){
            var itemId = $(this).closest('tr').find('.item-id-by-ex-factory').val();
            var exFactoryId = $(this).val();

            if(exFactoryId == 0){
                $.ajax({
                    url: "../../ex_factory/get_address/"+itemId+"/"+exFactoryId,
                    type: "GET",
                    success: function(data, textStatus, jqXHR) {
                        var exFactory = JSON.parse(data);
                        // console.log(exFactory);

                        $('.ex-factory-address-line1.'+itemId).html('');
                        $('.ex-factory-address-line1.'+itemId).append('<input class="invoice-inputs" type="text" value="'+exFactory[0].shipping_address+'" readonly/>');

                        $('.ex-factory-address-line2.'+itemId).html('');
                        $('.ex-factory-address-line2.'+itemId).append('<input class="invoice-inputs" type="text" value="'+exFactory[0].shipping_po_box+'" readonly/>');

                        $('.ex-factory-address-line3.'+itemId).html('');
                        $('.ex-factory-address-line3.'+itemId).append('<input class="invoice-inputs" type="text" value="'+exFactory[0].shipping_city+', '+exFactory[0].shipping_state+', '+exFactory[0].shipping_postal_code+', '+exFactory[0].shipping_country+'" readonly/>');
                    },
                });

            } else {
                $.ajax({
                    url: "../../ex_factory/get_address/"+itemId+"/"+exFactoryId,
                    type: "GET",
                    success: function(data, textStatus, jqXHR) {
                        var exFactory = JSON.parse(data);

                        $('.ex-factory-address-line1.'+itemId).html('');
                        $('.ex-factory-address-line1.'+itemId).append('<input class="invoice-inputs" type="text" value="'+exFactory[0].po_box+'" readonly/>');

                        $('.ex-factory-address-line2.'+itemId).html('');
                        $('.ex-factory-address-line2.'+itemId).append('<input class="invoice-inputs" type="text" value="'+exFactory[0].city+', '+exFactory[0].state+'" readonly/>');

                        $('.ex-factory-address-line3.'+itemId).html('');
                        $('.ex-factory-address-line3.'+itemId).append('<input class="invoice-inputs" type="text" value="'+exFactory[0].postal_code+', '+exFactory[0].country+'" readonly/>');
                    },
                });
            }
        });

        function orderItemUpdate() {

        }

        function calculateTOTALalQtys() {
            if(order_details != ''){
                var order_items = order_details[0].order_items;

                for(var i = 0; i < order_items.length; i++){

                 // getting TOTALal number sequense count
                    var TOTALnums =$('#tab_'+order_items[i].id+' .numseq').filter(function() {
                        return $(this).val() != "" && $(this);
                    }).length;
                    $('#TOTALnums_'+order_items[i].id).val(TOTALnums);
                    console.log(TOTALnums);

                 // getting TOTALal blanks count
                    var TOTALblanks =$('#tab_'+order_items[i].id+' .blankseq').filter(function() {
                        return $(this).val() != "" && $(this);
                    });
                    var blankVals = 0;
                    for(var j = 0; j < TOTALblanks.length; j++){
                        blankVals += parseFloat(TOTALblanks[j].value);
                    }
                    $('#TOTALblanks_'+order_items[i].id).val(blankVals);

                 // getting TOTALal qty count
                    var TOTALqty = TOTALnums + blankVals;
                    $('#TOTALqty_'+order_items[i].id).val(TOTALqty);
                }
            }
        }

        function calculateTOTALalQtysDefault() {
        if(order_details != ''){
            var order_items = order_details[0].order_items;

            for(var i = 0; i < order_items.length; i++){
                // console.log(order_items[i].id);
                // getting TOTALal number sequense count
                var TOTALnums =$('#tab_'+order_items[i].id+' .numseq').filter(function() {
                    return $(this).val() != "" && $(this);
                }).length;
                //$('#TOTALnums_'+order_items[i].id).val(TOTALnums);
                $('#TOTALnums_'+order_items[i].id).attr("data-AlradySaved",TOTALnums);
                console.log(TOTALnums);

                // getting TOTALal blanks count
                var TOTALblanks =$('#tab_'+order_items[i].id+' .blankseq').filter(function() {
                    return $(this).val() != "" && $(this);
                });
                var blankVals = 0;
                for(var j = 0; j < TOTALblanks.length; j++){
                    blankVals += parseFloat(TOTALblanks[j].value);
                }
                //$('#TOTALblanks_'+order_items[i].id).val(blankVals);
                $('#TOTALblanks_'+order_items[i].id).attr("data-AlradySaved",blankVals);

                // getting TOTALal qty count
                var TOTALqty = TOTALnums + blankVals;
                //$('#TOTALqty_'+order_items[i].id).val(TOTALqty);
                $('#TOTALqty_'+order_items[i].id).attr("data-AlradySaved",TOTALqty);
            }
        }
    }

    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }



    // function uploadFile() {
    //     var image_preview = document.getElementById("image_preview");
    //     var file = document.querySelector("input[type=file]").files[0];

    //     var reader = new FileReader();
    //     reader.onloadend = function () {
    //         image_preview.src = reader.result;
    //         document.getElementById("base64").value = reader.result;
    //     };

    //     if (file) {
    //         reader.readAsDataURL(file);

    //     } else {
    //         image_preview.src = "";

    //     }
    // }

    // function previewImage(img){
    //     $('#image_view_container').html('');
    //     var cloneImg = $(img).clone();
    //     $(cloneImg).removeClass('view-image');
    //     $(cloneImg).addClass('view-modal-image');
    //     $(cloneImg).appendTo('#image_view_container');
    //     $('#image_view_modal').modal('show');
    // }

        /*$.ajax({
                    url: "../../ex_factory/get_address/"+itemId+"/"+exFactoryId,
                    type: "GET",
                    success: function(data, textStatus, jqXHR) {
                        var exFactory = JSON.parse(data);

                        $('.ex-factory-address-line1.'+itemId).html('');
                        $('.ex-factory-address-line1.'+itemId).append('<input class="invoice-inputs" type="text" value="'+exFactory[0].po_box+'" readonly/>');

                        $('.ex-factory-address-line2.'+itemId).html('');
                        $('.ex-factory-address-line2.'+itemId).append('<input class="invoice-inputs" type="text" value="'+exFactory[0].city+', '+exFactory[0].state+'" readonly/>');

                        $('.ex-factory-address-line3.'+itemId).html('');
                        $('.ex-factory-address-line3.'+itemId).append('<input class="invoice-inputs" type="text" value="'+exFactory[0].postal_code+', '+exFactory[0].country+'" readonly/>');
                    },
                });*/


    $("#saveShippingOrder").click(function(){

        var shippedQtyEmpty = 0;
        $("input[name='itemShippedQty[]']").each(function() {
            if($(this).val() == "" && shippedQtyEmpty == 0)
            {
                alert("Please enter the shipped qty of all products");
                shippedQtyEmpty = 1;
            }
        });
        var itemBackOrderedQty = 0;
        $("input[name='itemBackOrderedQty[]']").each(function() {
            if($(this).val() == "" && shippedQtyEmpty == 0 && itemBackOrderedQty == 0)
            {
                alert("Please enter the backordered qty of all products");
                itemBackOrderedQty = 1;
            }
        });

        var itemEstDiliveryDate = 0;
        $("input[name='itemEstDiliveryDate[]']").each(function() {
            if($(this).val() == "" && shippedQtyEmpty == 0 && itemBackOrderedQty == 0 && itemEstDiliveryDate == 0)
            {
                alert("Please enter the estimate dolivery date of all products");
                itemEstDiliveryDate = 1;
            }
        });

        var itemtrackingNo = 0;
        $("input[name='itemtrackingNo[]']").each(function() {
            if($(this).val() == "" && shippedQtyEmpty == 0 && itemBackOrderedQty == 0 && itemEstDiliveryDate == 0 && itemtrackingNo == 0)
            {
                alert("Please enter the tracking numbers of all products");
                itemtrackingNo = 1;
            }
        });

        if(shippedQtyEmpty == 0 &&  itemBackOrderedQty == 0 &&  itemEstDiliveryDate == 0 &&  itemtrackingNo == 0)
        {
            $.ajax({
                url: "../../order/shippingsave",
                type: "post",
                data:{
                    orderID:$("input[name=id]").val(),
                    itemID:$("input[name='itemID[]']") .map(function(){return $(this).val();}).get(),
                    itemName:$("input[name='itemName[]']") .map(function(){return $(this).val();}).get(),
                    itemOrderQty:$("input[name='itemOrderQty[]']") .map(function(){return $(this).val();}).get(),
                    itemShippedQty:$("input[name='itemShippedQty[]']") .map(function(){return $(this).val();}).get(),
                    itemBackOrderedQty:$("input[name='itemBackOrderedQty[]']") .map(function(){return $(this).val();}).get(),
                    itemEstDiliveryDate:$("input[name='itemEstDiliveryDate[]']") .map(function(){return $(this).val();}).get(),
                    itemtrackingNo:$("input[name='itemtrackingNo[]']") .map(function(){return $(this).val();}).get()
                    },
                success: function (response) {

                    if(response == "Shipping Details Saved")
                    {
                        document.getElementById("saveShippingOrder").disabled = true;
                        document.getElementById("updateShippingOrder").disabled = false;

                        alert(response);
                    }else{
                        alert("Something Went Wrong");
                    }
                }
            });
        }



    });

    var ItemForm = null;

    $(".nav-tab-item").click(function(){
        $("#"+$(this).attr("data-RosterForm")).click();

        if(numberSequencesFilled.length >= 1){
            var elementID = $(this).attr("id");

            if($(this).attr("data-section") == "rosterPlayerNames")  {
                var buttons = $('<div>').append("There are unsaved changes. Are you sure that you want to leave this form?<br><br><button data-clickedItem='"+elementID+"' type='button' class='btn btn-secondary LeaveNotSave'>Leave & Don't Save</button>").append("<button data-clickedItem='"+elementID+"' type='button' class='btn btn-success onlySave'>Save</button>").append("<button type='button' class='btn btn-danger btnCancelSwal'>Cancel</button>");
            } else {
                var buttons = $('<div>').append("There are unsaved changes. Are you sure that you want to leave this form?<br><br><button data-clickedItem='"+elementID+"' type='button' class='btn btn-secondary LeaveNotSave'>Leave & Don't Save</button>").append("<button data-clickedItem='"+elementID+"' type='button' class='btn btn-success saveAndLeave'>Save & Leave</button>").append("<button type='button' class='btn btn-danger btnCancelSwal'>Cancel</button>");
            }

            swal({
                title: "Are you sure?",
                text: "Do You Want to Delete This OrderItem?",
                html: buttons,
                type: "warning",
                showConfirmButton: false,
                showCancelButton: false
            });

            return false;
        } else {
            if($(this).attr("formid")) {
                ItemForm = $(this).attr("formid");
            } else {
                ItemForm = null;
            }
        }
    });

    $(document).on('click', '.LeaveNotSave', function() {
        //Some code 1
        var elementID = $(this).attr("data-clickedItem");

        $.unique(numberSequencesFilled).forEach(clearTextBoxes);

        $(".TOTALblanks").each(function() {
            $(this).val($( this ).attr("data-alradysaved"));
        });
        $(".TOTALnums").each(function() {
            $(this).val($( this ).attr("data-alradysaved"));
        });
        $(".TOTALqty").each(function() {
            $(this).val($( this ).attr("data-alradysaved"));
        });

        numberSequencesFilled.length = 0;

        $("#"+elementID).click();

        console.log(numberSequencesFilled);
        swal.clickConfirm();

        // window.location.reload();

    });

    $(document).on('click', '.btnCancelSwal', function() {
        //Some code 1

        swal.clickConfirm();

    });

    $(document).on('click', '.onlySave', function() {
        if(ItemForm == null)
        {
            let searchParams = new URLSearchParams(window.location.search)
            if(searchParams.has('active_tab'))
            {
                ItemForm= searchParams.get('active_tab');
            }
        }
        console.log(ItemForm);
        $('.notify_changes').val($.unique(numberSequencesFilled));
        $("#formItem"+ItemForm).submit();

    });

    $(document).on('click', '.saveAndLeave', function() {
        var elementID = $(this).attr("data-clickedItem");

        //Some code 1
        if(ItemForm == null)
        {
            let searchParams = new URLSearchParams(window.location.search)
            if(searchParams.has('active_tab'))
            {
                ItemForm= searchParams.get('active_tab');
            }
        }

        $('.notify_changes').val($.unique(numberSequencesFilled));

        var dataString = $("#formItem"+ItemForm).serialize();
        dataString = "saveLeave=yes&"+dataString;
        $.ajax({
            type: "POST",
            url: "{{ route('order_sequence.update') }}",
            data: dataString,
            beforeSend: function(){
                $(".se-pre-con").fadeIn();
            },
            success: function(data) {
                $(".se-pre-con").fadeOut();
                console.log(data);
                if(data == "DoneAjaxPost")
                {
                    numberSequencesFilled.length = 0;
                    swal.clickConfirm();
                    swal({
                        title: "Saved Details",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false,
                        showCancelButton: false
                    });

                    $('.notify_changes').val('');
                    $("#"+elementID).click();
                } else {
                    swal({
                        title: "The order cannot be edited!",
                        type: "error",
                        text:"Please review the modified field values.",
                        timer: 3000,
                        showConfirmButton: false,
                        showCancelButton: false
                    });
                }

            },
            error: function(xhr, textStatus, error){
                $(".se-pre-con").fadeOut();
                swal({
                    title: "The order cannot be edited!",
                    type: "error",
                    text:"Please review the modified field values.",
                    // text:error,
                    showConfirmButton: true,
                    showCancelButton: false
                });
            }

        });
        //alert(dataString);


    });


    function clearTextBoxes(item) {
        console.log(item);
        $("input[name='"+item+"']").val($("input[name='"+item+"']").attr("data-alradysaved"));
        var orderItemDetailId = $("input[name='"+item+"']").attr("data-orderitemdetailid");
        $("input[name='product["+orderItemDetailId+"][qty]']").val($("input[name='product["+orderItemDetailId+"][qty]']").attr("data-alradysaved"));//qtyseq
    }

    const numberSequencesFilled = [];

    $(".myForm :input:not(#ex_factory_date):not(#due_date)").on("input change", function() {
        numberSequencesFilled.push($(this).attr("name"));
        console.log(numberSequencesFilled);
    });

//     $(".numseq").on( "input", function() {

//         numberSequencesFilled.push($(this).attr("name"));
//         //console.log(numberSequencesFilled);
//     });
//     $(".blankseq").on( "input", function() {

//        numberSequencesFilled.push($(this).attr("name"));
//        //console.log(numberSequencesFilled);
//    });
//    $(".txtSizeName").on( "input", function() {

//        numberSequencesFilled.push($(this).attr("name"));
//        //console.log(numberSequencesFilled);
//    });

    function openSize(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontentCustom");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinksCustom");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";

        evt.currentTarget.className += " active";

    }


    $(document).on('click', '.kv-file-download', function() {
        //Some code 1
       var stringDownload = $(this).attr("href");
       var newString = stringDownload.replace("&export=media", "&export=download");
       $(this).attr("href", newString);

    });

    $(".rosterPlayerNameSection").click(function(){
        var sectionLinks =  $(this).attr("data-sectionLinks");
        var section = $(this).attr("href");
        $(""+section+" .tabcontentCustom"+":not(:first)").css( "display", "none" );
        $("."+sectionLinks+" .tablinksCustom"+":not(:first)").removeClass("active");
        $("."+sectionLinks+" .tablinksCustom").first().addClass("active");
        $(""+section+" .tabcontentCustom").first().css( "display", "block" );
    });

        function getFiles() {
        order_details[0].order_items.forEach(order_items => {
            var mockupPreloadImages = [];
            var mockupPreloadImagedetails = [];

            var techPackPreloadFiles = [];
            var techPackPreloadFilesDetails = [];
            var techPackPreloadImages = [];
            var techPackPreloadImagesDetails = [];

            var productionLayoutPreloadImages = [];
            var productionLayoutPreloadImagesDetails = [];

            var testPrintPreloadImages = [];
            var testPrintPreloadImagesDetails = [];

            var productPicturePreloadEditedImages = [];
            var productPicturePreloadEditedImagesDetails = [];
            var productPicturePreloadRawImages = [];
            var productPicturePreloadRawImagesDetails = [];

            order_items.order_item_files.forEach(function(item_files, index) {
                console.log(item_files.mockup_images);
                if(item_files.mockup_images != null){
                    mockupPreloadImages.push(item_files.mockup_images);
                    let mockupImageArray = {caption: item_files.mockup_image_name, downloadUrl:  item_files.mockup_images, width: "120px", key: index, extra: {id: item_files.id}};
                    mockupPreloadImagedetails.push(mockupImageArray);
                }

                // tech pack images and files
                if(item_files.tech_pack_files != null){
                    techPackPreloadFiles.push(item_files.tech_pack_files);
                    let techPackFileArray = {caption: item_files.tech_pack_file_name, downloadUrl:  item_files.tech_pack_files, width: "120px", key: index, extra: {id: item_files.id}};
                    techPackPreloadFilesDetails.push(techPackFileArray);
                }

                if(item_files.tech_pack_images != null){
                    techPackPreloadImages.push(item_files.tech_pack_images);
                    let techPackImageArray = {caption: item_files.tech_pack_image_name, downloadUrl:  item_files.tech_pack_images, width: "120px", key: index, extra: {id: item_files.id}};
                    techPackPreloadImagesDetails.push(techPackImageArray);
                }

                if(item_files.production_layout_images != null){
                    productionLayoutPreloadImages.push(item_files.production_layout_images);
                    let productionLayoutImageArray = {caption: item_files.production_layout_image_name, downloadUrl:  item_files.production_layout_images, width: "120px", key: index, extra: {id: item_files.id}};
                    productionLayoutPreloadImagesDetails.push(productionLayoutImageArray);
                }

                if(item_files.test_print_images != null){
                    testPrintPreloadImages.push(item_files.test_print_images);
                    let productPictureImageArray = {caption: item_files.test_print_image_name, downloadUrl:  item_files.test_print_images, width: "120px", key: index, extra: {id: item_files.id}};
                    testPrintPreloadImagesDetails.push(productPictureImageArray);
                }

                // Product Picture images and files
                if(item_files.product_picture_raw_images != null){
                    productPicturePreloadRawImages.push(item_files.product_picture_raw_images);
                    let productFileArray = {caption: item_files.product_picture_raw_images, downloadUrl:  item_files.product_picture_raw_images, width: "120px", key: index, extra: {id: item_files.id}};
                    productPicturePreloadRawImagesDetails.push(productFileArray);
                }

                if(item_files.product_picture_edited_images != null){
                    productPicturePreloadEditedImages.push(item_files.product_picture_edited_images);
                    let productImageArray = {caption: item_files.product_picture_edited_image_name, downloadUrl:  item_files.product_picture_edited_images, width: "120px", key: index, extra: {id: item_files.id}};
                    productPicturePreloadEditedImagesDetails.push(productImageArray);
                }
            });

            console.log(mockupPreloadImages);
            console.log(mockupPreloadImagedetails);
            var orderId = $('#order_id').val();

            $("#mock_up_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: mockupPreloadImages,
                initialPreviewAsData: true,
                initialPreviewConfig: mockupPreloadImagedetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: false,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#mock_up_images_"+ order_items.id).fileinput("upload");
            });

            $("#teck_pack_files_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: techPackPreloadFiles,
                initialPreviewAsData: true,
                initialPreviewConfig: techPackPreloadFilesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: false,
                allowedFileExtensions: ["pdf"],
                browseOnZoneClick: true,
                fileActionSettings: {
                    showUpload: false,
                    showZoom: false,
                },
                preferIconicPreview: true,
                previewFileIconSettings: {
                    'doc': '<i class="fas fa-file-word text-primary"></i>',
                    'xls': '<i class="fas fa-file-excel text-success"></i>',
                    'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
                    'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
                    'zip': '<i class="fas fa-file-archive text-muted"></i>',
                    'htm': '<i class="fas fa-file-code text-info"></i>',
                    'txt': '<i class="fas fa-file-alt text-info"></i>',
                    'mov': '<i class="fas fa-file-video text-warning"></i>',
                    'mp3': '<i class="fas fa-file-audio text-warning"></i>',
                    'jpg': '<i class="fas fa-file-image text-danger"></i>',
                    'gif': '<i class="fas fa-file-image text-muted"></i>',
                    'png': '<i class="fas fa-file-image text-primary"></i>',
                },
                previewFileExtSettings: {
                    'doc': function(ext) {
                        return ext.match(/(doc|docx)$/i);
                    },
                    'xls': function(ext) {
                        return ext.match(/(xls|xlsx)$/i);
                    },
                    'ppt': function(ext) {
                        return ext.match(/(ppt|pptx)$/i);
                    },
                    'zip': function(ext) {
                        return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
                    },
                    'htm': function(ext) {
                        return ext.match(/(htm|html)$/i);
                    },
                    'txt': function(ext) {
                        return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
                    },
                    'mov': function(ext) {
                        return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                    },
                    'mp3': function(ext) {
                        return ext.match(/(mp3|wav)$/i);
                    },
                    'jpg': function(ext) {
                        return ext.match(/(jpg|jpeg)$/i);
                    },
                    'pdf': function(ext) {
                        return ext.match(/(pdf)$/i);
                    },
                },
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#teck_pack_files_"+ order_items.id).fileinput("upload");
            });

            $("#teck_pack_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: techPackPreloadImages,
                initialPreviewAsData: true,
                initialPreviewConfig: techPackPreloadImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: false,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#teck_pack_images_"+ order_items.id).fileinput("upload");
            });

            $("#production_layout_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: productionLayoutPreloadImages,
                initialPreviewAsData: true,
                initialPreviewConfig: productionLayoutPreloadImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: false,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#production_layout_images_"+ order_items.id).fileinput("upload");
            });

            $("#test_print_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: testPrintPreloadImages,
                initialPreviewAsData: true,
                initialPreviewConfig: testPrintPreloadImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: false,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#test_print_images_"+ order_items.id).fileinput("upload");
            });

            $("#product_picture_raw_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: productPicturePreloadRawImages,
                initialPreviewAsData: true,
                initialPreviewConfig: productPicturePreloadRawImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: true,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#product_picture_raw_images_"+ order_items.id).fileinput("upload");
            });

            $("#product_picture_edited_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: productPicturePreloadEditedImages,
                initialPreviewAsData: true,
                initialPreviewConfig: productPicturePreloadEditedImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: true,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#product_picture_edited_images_"+ order_items.id).fileinput("upload");
            });
        });
    }

    var header = document.getElementById('orders-container');

    // $(document).on('click', '.btn-close', function() {
    //     // Perform the desired action when the close button is clicked
    //     console.log("Close button clicked");
    //     // Add your code here to close or hide the element, etc.

    //     // Programmatically close the modal
    //     $('#preview-modal').modal('hide');
    // });

    $(document).ready(function() {
    // Add a click event listener to the close button
    $(document).on('click', '.btn-close', function() {
        // Perform the desired action when the close button is clicked
        console.log("Close button clicked");

        // Programmatically close the modal
        $('#kvFileinputModal').modal('hide');
    });
});


    </script>
@endsection
