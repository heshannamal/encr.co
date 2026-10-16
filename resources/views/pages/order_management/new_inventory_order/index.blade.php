@extends('layouts.app', ['activePage' => 'new_inventory_orders', 'titlePage' => __('New Inventory Orders')])

@section('content')
<style>
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .select2.select2-container {
        width: 100% !important;
    }
    .table.invoice_details.arange th{
        width: 40%;
    }
    @media (min-width: 992px){
        .modal-lg {
            max-width: 900px !important;
        }
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        white-space: break-spaces;
    }
    .select2-container .select2-selection--single {
        overflow: hidden;
    }
    .product_table_body td:nth-child(3) {
        width: 20%;
    }

    #item_attribute+.select2 {
        width: 100% !important;
    }
    #item_attribute+a {
        display: flex;
    }

    #item_attribute{
        height: 110px !important;
    }

    #item_attribute + .select2.select2-container{
        min-height: 100px !important;
    }

    .item-table-inputs{
        /* width: auto !important; */
    }
    .back-btn-font {
        font-size: x-small;
        font-weight: 900;
    }
    .back-btn-div {
        padding: 0.5rem;
        background-color: #787878;
        border-radius: 0.125rem;
    }
    .back-btn-div-position {
        padding: 0.5rem;
    }
    .btn-right {
        position: relative;
        right: 10px;
    }
    .table-border {
        border: unset !important;
    }
    .table-font-size {
        font-size: 13px;
    }
    .table-size {
        width: 97%;
        position: relative;
        left: 10px;
    }
    .th-width {
        width: 185px;
    }
    .address-card-height {
        height: 22rem;
    }
    .details-card-height {
        height: 8rem;
    }
    .product-add-btn {
        background-color: blue;
        border: none;
        color: #ffffff;
    }
    .invoice-table-size {
        width: 92%;
        position: relative;
        top: -5%;
    }
    .print-btn {
        width: 88px !important;
        background-color: blue;
        color: white;
    }
    .save-btn {
        width: 89px !important;
    }
    .content-position {
        position: relative;
        top: -25px;
    }
    .form-style {
        border: 0.05rem solid #c4c4c4;
        background-color: white !important;
    }
    .table-content-position {
        position: relative;
        top: 9px;
    }
    .field-height {
        height: 25px;
    }
    .plus-icon {
        position: relative;
        left: -6px;
    }
    .outline-border {
        border-radius: 5px !important;
        border: 1px #e4e4e4b8 solid !important;
    }

    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
        .addneworset001{
            flex-direction: column;
        }
        .addnewor001{
            width:210%;
        }
        .addnewor002{
            max-width: none;
        }
        .dispnone{
            display:none;
        }
        .tableinvo001{
            width:210%;
        }
        /* .total_font{
            font-size: 16px !important;
        } */
        .btn_responsive_002{
            flex-wrap: nowrap;
        }
        .btn_responsive_001{
            max-width: none;
            display: inline-block;
            left:50%;
        }
    }

    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
        .header1{
            display: inline !important;
        }
        .headder_size{
            font-size:15px;
        }


        .pagina001{
        flex-wrap: wrap;
        }
        .flex_set{
            flex-direction: column !important;
        }
        .max_width01{
            max-width: none !important;
        }
    }
      .select2-container--default.select2-container--disabled .select2-selection--single {
        background-color: unset !important;
    }
    .custom-select2 + .select2-container .select2-selection--single .select2-selection__arrow {
        display: none;
    }
    @media screen and (min-width: 600px) and (max-width: 800px) {
        .div_flexdir01{
            flex-wrap: wrap;
            flex-direction: column;
        }
        .div_none01{
            max-width: none;
        }
        .btn_set12{
            max-width: none;
            flex:none;
            right:0px;

        }
        .div_display12{
            display:none;
        }
        .div_align11{
            justify-content: center;
        }

    }
    .header-style{
        color: black;
        font-size: 1.2rem;
        font-weight: 600;
    }
    .newOrderStyles .card{
        border: none;
        border-radius: 0rem;
        padding: 1rem;
        height: 100%;
    }
    .newOrderStyles .form-label{
    margin-top: 0.5rem;
    color: black;
    font-size: 0.8rem;
    font-weight: 500;
    }
    .newOrderStyles .form-control{
        height: calc(1.5rem + 1px);
        border-radius: 0rem;
        color: #717070;
    }
    .newOrderStyles .form-control [readonly]{
        height: calc(1.5rem + 1px);
        border-radius: 0rem;
        background-color: #f9f8f8;
        border: none;
        color: #dedede;
    }
    .newOrderStyles .select2-selection__rendered{
        border: 1px solid #DEDEDE;
        border-radius: 0rem !important;
        color: #717070 !important;
        padding-left: 7px !important;
        font-size: 0.8rem !important;
        line-height: 23px !important;
    }
    .newOrderStyles .hasDatepicker{
        padding: 5px;
        padding-left: 6px;
        height: calc(1.5rem + 1px);
        border-radius: 0rem !important;
        color: #717070;
    }
    .swal2-confirm{
        border: none !important;
        background-color: #47D6B6 !important;
        border-radius: 0rem !important;
        font-size: .8rem !important;
        padding: .2em 2em !important;
        color: white !important;
        cursor: pointer;
        outline: unset;
    }
    .swal2-cancel{
        border: none !important;
        background-color: #b3b3b3 !important;
        border-radius: 0rem !important;
        font-size: .8rem !important;
        padding: .2em 2em !important;
        color: white !important;
        cursor: pointer;
        outline: unset;
    }
    .select2-container--default .select2-selection--single{
        border-radius: 0rem;
    }
    .sub-header-style{
        color: black;
        font-size: 1rem;
        font-weight: 600;
    }
    .newOrderStyles .form-control {
        height: calc(1.5rem + 1px);
        border-radius: 0rem;
        color: #717070;
    }
    .status-lable{
        background-color: #FFF6CC;
        border-radius: 1rem;
        text-align: center !important;
        padding: 0.2rem;
        width: 100;
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
    /* tr .select2-selection__rendered {
        border: none !important;
        padding-left: 0px !important;
    } */
    .add-text-button{
        border: none;
        padding: 2px;
        color: #b3b3b3;
        background-color: unset;
        cursor: pointer;
        outline: unset;
        font-weight: 500;
        font-size: .8rem;
    }
    .btn-green-filled{
        outline: unset !important;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
    }
    #invoice_summery_table tr{
        height: 26px;
        font-size: .7rem !important;
        color: grey;
    }
    #invoice_summery_table tr input{
        color: grey;
    }


</style>

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{route('inventory_orders')}}" class="home-btn-color" title="Back to Orders">BACK TO ORDERS</a>
    @endsection


    {{-- <div class="col-md-12 mt-2">
        <div class="row">
            <div class="col-md-2">
                <div class="">
                    <a class="btn back-btn-div" href="{{route('orders')}}" title="Add New Orders">
                        <i class="fas fa-solid fa-reply-all back-btn-font" style="color: #ffffff;">   BACK TO ORDER</i>
                    </a>
                </div>
            </div>

        </div>
    </div> --}}

    <form action="{{ route('new_inventory_orders.create') }}" method="post">
        @csrf
        <div class="col-md-12 mt-2 newOrderStyles">
            <div class="row">
                <div class="col-md-12 header-style">
                    Add New Order
                </div>
                <div class="col-md-6" style="padding-right:8px">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12 sub-header-style">
                                Order
                            </div>
                            <div class="col-md-6">
                                <label for="order_no" class="form-label">Order #</label>
                                <input class="form-control " name="order_no" type='text' value='{{$orderNo}}' readonly />
                            </div>
                            <div class="col-md-6">
                                <label for="order_status_id" class="form-label">Order Status</label>
                                <input type="hidden" name="order_status_id" id="order_status_id" class="form-control" value="1">
                                <input type="text"  class="form-control" value="Quote" readonly>
                            </div>
                            <div class="col-md-12">
                                <label for="organization_id" class="form-label">Organization</label>
                                <select class="invoice-inputs select2-new-order" name="organization_id" id="organization_id" required>
                                    <option value="">Select an Organization</option>
                                    @foreach($organizations as $organization)
                                    <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-md-12">
                                <button type="button" id="btn_organization_create_modal" class="add-text-button" data-toggle="modal" data-target="#organization_create_modal">
                                    ADD NEW ORGANIZATION
                                </button>
                            </div> --}}
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">Sales Rep</label>
                                <select class="invoice-inputs select2-new-order" name="user_id" id="user_id" required>
                                    <option value="">Select a Sales Rep</option>
                                    @foreach($users as $user)
                                        @if ($user->user_role_id == 3)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="due_date" class="form-label">Customer In-Hand Date</label>
                                <input type="text" class="form-control invoice-inputs datepicker outline-border" name="due_date" id="due_date" required />
                            </div>
                        </div>

                    </div>
                    {{-- <div class="card details-card-height addnewor001">
                        <table class="table-font-size invoice_details table-border table-size table-content-position">
                            <tr>
                                <th style="width: 38%">Order # </th>
                                <th>:</th>
                                <td></td>
                                <td><input class="form-control " name="order_no" type='text' value='{{$orderNo}}' readonly /></td>
                            </tr>
                            <tr>
                                <th>Organization </th>
                                <th>:</th>
                                <td style="width: 4%">
                                    <button type="button" id="btn_organization_create_modal" class="btn btn-sm input-group-text" data-toggle="modal" data-target="#organization_create_modal" style="width: 8px;">
                                        <i class="fas fa-plus plus-icon"></i>
                                    </button>
                                </td>
                                <td style="display: flex;" class="form-control">
                                    <select class="invoice-inputs select2-new-order" name="organization_id" id="organization_id" required>
                                        <option value="">Select an Organization</option>
                                        @foreach($organizations as $organization)
                                        <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Order Status </th>
                                <th>:</th>
                                <td></td>
                                <td class="form-control">
                                    <input type="hidden" name="order_status_id" id="order_status_id" class="form-control" value="1">
                                    <input type="text"  class="form-control" value="Quote" readonly>

                                </td>
                            </tr>
                        </table>
                        <table class="table-font-size invoice_details table-border table-size table-content-position">
                            <tr>
                                <th style="width: 32%;">Sales Rep </th>
                                <th>:</th>
                                <td class="form-control">
                                    <select class="invoice-inputs select2-new-order" name="user_id" id="user_id" required>
                                        <option value="">Select a Sales Rep</option>
                                        @foreach($users as $user)
                                            @if ($user->user_role_id == 3)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Customer In-Hand Date </th>
                                <th>:</th>
                                <td>
                                    <input type="text" class="form-control invoice-inputs datepicker outline-border" name="due_date" id="due_date" required />
                                </td>
                            </tr>
                        </table>
                    </div> --}}
                </div>
                <div class="col-md-6" style="padding-left: 8px">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-8 sub-header-style">
                                Customer
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="button" class="add-text-button" data-toggle="modal" id="add_people_create_modal">
                                    ADD CUSTOMER
                                </button>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="customer_id" class="form-label">Customer Name</label>
                                <select name="customer_id" id="customer_id" class="invoice-inputs select2-new-order" required>
                                    <option value="">Select Customer</option>
                                </select>
                            </div>
                            <div class="col-md-8 sub-header-style" style="font-size: .8rem;">
                                Shipping Address
                            </div>
                            <div class="col-md-4 text-right">
                                <input type="checkbox" style="display: none" class="custom-control-input" id="new_shipping_address" name="new_shipping_address" value="0">
                                <label class="add-text-button" style="color: #b3b3b3;cursor:pointer" for="new_shipping_address">NEW ADDRESS</label>
                            </div>
                            {{-- Default Address --}}
                            <div class="col-md-6 default-address">
                                <input class="form-control" id="shipping_address3" type='text' value='' style="border: none;height: 25px;" readonly/>
                                <input class="form-control" id="shipping_address_postal" type='text' value='' style="border: none;height: 25px;" readonly/>
                                <input class="form-control" id="shipping_address4" type='text' value='' style="border: none;height: 25px;" readonly/>

                            </div>
                            <div class="col-md-6 new-address">
                                <label for="new_street" class="form-label">Street</label>
                                <input class="form-control" id="new_street" name="new_street" type='text' placeholder="Type Street"/>
                            </div>
                            <div class="col-md-6 new-address">
                                <label for="new_city" class="form-label">City</label>
                                <input class="form-control" id="new_city" name="new_city" type='text' placeholder="Type City"/>
                            </div>
                            <div class="col-md-6 new-address">
                                <label for="new_state" class="form-label">State</label>
                                <input class="form-control" id="new_state" name="new_state" type='text' placeholder="Type State"/>
                            </div>
                            <div class="col-md-6 new-address">
                                <label for="new_postal_code" class="form-label">Postal Code</label>
                                <input class="form-control" id="new_postal_code" name="new_postal_code" type='text' placeholder="Type Postal Code"/>
                            </div>
                            <div class="col-md-6 new-address">
                                <label for="new_country" class="form-label">Country</label>
                                <input class="form-control" id="new_country" name="new_country" type='text' placeholder="Type Country"/>
                            </div>
                            <div class="col-md-12 sub-header-style mt-3" style="font-size: .8rem;">
                                Contact Details
                            </div>
                            {{-- Default Contact --}}
                            <div class="col-md-12 default-address">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" style="border: none;"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input class="form-control" id="shipping_address5" type='text' value='' style="border: none; height: 25px;" readonly />
                                  </div>

                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" style="border: none;"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input class="form-control" id="shipping_address6" type='text' value='' style="border: none; height: 25px;" readonly />
                                  </div>

                            </div>
                            <div class="col-md-6 new-address">
                                <label for="new_phone_no" class="form-label">Phone no</label>
                                <input class="form-control" id="new_phone_no" name="new_phone_no" type='text' placeholder="Type Phone Number"/>
                            </div>
                            <div class="col-md-6 new-address">
                                <label for="new_email" class="form-label">E mail</label>
                                <input class="form-control" id="new_email" name="new_email" type='text' placeholder="Type E mail"/>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12 header-style">
                                Order Description
                            </div>
                            <div class="col-md-12">
                                <textarea  class="invoice-inputs light-border orderdetails001"
                                    id="order_description" name="order_description" type='text' rows="4" value=''
                                    style="margin-top: 5px;margin-bottom: 7px; border: 0.1rem solid #f1f1f1"
                                    placeholder="Is there anything else you want to let us know about this order?"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 mt-2">
            <div class="card" style="border: none; border-radius:0rem">
                <div class="row" >
                    <div class="col-md-12 text-right mt-2">
                        <button type="button" class="btn-green-filled mr-3" id="add_item"><i class="fas fa-plus"></i> Add Item</button>
                    </div>
                    <div class="col-md-12" style="margin: .5rem;" >
                        <table class="table table-responsive" id="order_item_table" style="width: 96.8%;margin-left: .5rem;">
                            <thead>
                                <tr class="table-header-style">
                                    <th class="text-left" style="min-width: 250px;padding-left: 7px !important;">ITEM</th>
                                    <th class="text-left" style="min-width: 110px;">PATTERN CODE</th>
                                    <th class="text-left" style="min-width: 90px;">STATUS</th>
                                    <th class="text-left" style="min-width: 100px;">EST DELIVERY</th>
                                    <th class="text-left" style="min-width: 85px;">TRACKING</th>
                                    <th class="text-left" style="min-width: 70px;">FABRIC</th>
                                    <th class="text-left" style="min-width: 110px;">EMBLISHMENT</th>
                                    <th class="text-left" style="min-width: 80px;">ATTRIBUTES</th>
                                    <th class="text-right" style="min-width: 25px;">QTY</th>
                                    {{-- <th class="text-right" style="min-width: 100px;">UNIT PRICE($)</th> --}}
                                    {{-- <th class="text-right" style="min-width: 75px;">TOTAL($)</th> --}}
                                    <th class="text-right">ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="product_table_body">
                                <tr><input type="hidden" value="1" id="row_no"/></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-2">
            <div class="card" style="border: none; border-radius:0rem">
                <div class="row">
                    <div class="col-md-7 dispnone"></div>
                    {{-- <div class="col-md-5">
                        <table class="ml-auto mr-2" id="invoice_summery_table">
                            <tr style="color:black !important">
                                <th>SUBTOTAL ($) :</th>
                                <td><input style="color: black" class="invoice-inputs text-right" name="sub_total" id="sub_total" type='text' value='0.00' readonly/></td>
                            </tr>
                            <tr>
                                <th>SALES TAX ($) <span id="sales_tax_display"></span>% RATE :</th>
                                <td>
                                    <input type="hidden" id="sales_tax_percentage" />
                                    <input class="invoice-inputs text-right" name="sales_tax" id="sales_tax" type='text' value='0' readonly />
                                </td>
                            </tr>
                            <tr>
                                <th>SHIPPING ($) :</th>
                                <td><input class="invoice-inputs text-right" name="shipping" id="shipping" type='text' value='0'/></td>
                            </tr>
                            <tr>
                                <th>ARTWORK ($) :</th>
                                <td><input class="invoice-inputs text-right" name="artwork" id="artwork" type='text' value='0'/></td>
                            </tr>
                            <tr>
                                <th>PROCESSING FEE ($) :</th>
                                <td><input class="invoice-inputs text-right" name="processing_fee" id="processing_fee" type='text' value='0' readonly /></td>
                            </tr><br>
                            <tr style="font-size: .8rem !important; color:black">
                                <th class="total_font">ORDER TOTAL ($) :</th>
                                <td><input class="invoice-inputs text-right" style="font-weight: bold; font-size: .8rem;color:black" name="order_total" id="order_total" type='text' value='0.00' readonly/></td>
                            </tr>
                        </table>
                    </div> --}}
                    <div class="col-md-12 text-right mb-3 mt-3">
                        <button type="submit" class="save-btn swal2-confirm">Save</button>
                        <button type="button" class="print-btn mr-3 swal2-cancel">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header back-btn-div-position">
                <div class=" col-md-12">
                    <div class="float-right btn-right">
                            <a class="btn back-btn-div" href="{{route('orders')}}" title="Add New Orders">
                                <i class="fas fa-solid fa-reply-all back-btn-font" style="color: #ffffff;">   SWITCH TO ORDER</i>
                            </a>
                    </div>
                </div>
            </div>

            <div class="card-body back-btn-div-position">
                <form action="{{ route('new_inventory_orders.create') }}" method="post">
                    @csrf
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-6">
                                    <table class="table invoice_details">
                                        <tr>
                                            <th>Organization :</th>
                                            <td style="display: flex;">
                                                <select class="invoice-inputs select2-new-order" name="organization_id" id="organization_id" required>
                                                    <option value="">Select an Organization</option>
                                                    @foreach($organizations as $organization)
                                                    <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" id="btn_organization_create_modal" class="btn btn-sm input-group-text" data-toggle="modal" data-target="#organization_create_modal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Order # :</th>
                                            <td><input class="invoice-inputs" name="order_no" id="order_no" type='text' value='{{$orderNo}}' readonly /></td>
                                        </tr>
                                        <tr>
                                            <th>Order Status :</th>
                                            <td>
                                                <select class="invoice-inputs select2-new-order" name="order_status_id" id="order_status_id" required>
                                                    <option value="">Select a Status</option>
                                                    @foreach($orderStatuses as $orderStatus)
                                                    <option value="{{$orderStatus->id}}">{{$orderStatus->status_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>

                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <table class="table invoice_details">
                                        <tr>
                                            <th>Sales Rep :</th>
                                            <td>
                                                <select class="invoice-inputs select2-new-order" name="user_id" id="user_id" required>
                                                    <option value="">Select a Sales Rep</option>
                                                    @foreach($users as $user)
                                                        @if ($user->user_role_id == 3)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Ex Factory Date :</th>
                                            <td>
                                                <input type="hidden" class="invoice-inputs datepicker open-date" name="open_date" id="open_date" />
                                                <input type="text" class="invoice-inputs datepicker" name="ex_factory_date" id="ex_factory_date" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Encore Packing Date :</th>
                                            <td>
                                                <input type="text" class="invoice-inputs datepicker" name="encore_packing_date" id="encore_packing_date" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Customer In-Hand Date :</th>
                                            <td>
                                                <input type="text" class="invoice-inputs datepicker" name="due_date" id="due_date" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    Address Details
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table shipping_details">
                                        <tr>
                                            <th colspan="4">Customer Shipping Address:</th>
                                        </tr>
                                        <tr>
                                            <td class="text-center" width="25px"><i class="fas fa-user-circle"></i></td>
                                            <td style="display: flex;">
                                                <select name="customer_id" id="customer_id" class="invoice-inputs select2-new-order" required>
                                                    <option value="">Select Customer</option>
                                                </select>
                                                <button type="button" class="btn btn-sm input-group-text" data-toggle="modal" id="add_people_create_modal">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="custom-control custom-checkbox pt-1 pb-1">
                                                    <input type="checkbox" class="custom-control-input" id="new_shipping_address" name="new_shipping_address" value="0">
                                                    <label class="custom-control-label pt-1" for="new_shipping_address">New Shipping Address</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="default-address">
                                            <td class="text-center" width="25px"><i class="fas fa-align-left"></i></td>
                                            <td><input class="invoice-inputs" id="shipping_address2" type='text' value='' readonly/></td>
                                        </tr>
                                        <tr class="default-address">
                                            <td style="border-top: 1px solid transparent"></td>
                                            <td><input class="invoice-inputs" id="shipping_address3" type='text' value='' readonly/></td>
                                        </tr>
                                        <tr class="default-address">
                                            <td style="border-top: 1px solid transparent"></td>
                                            <td><input class="invoice-inputs" id="shipping_address_postal" type='text' value='' readonly/></td>
                                        </tr>
                                        <tr class="default-address">
                                            <td style="border-top: 1px solid transparent"></td>
                                            <td><input class="invoice-inputs" id="shipping_address4" type='text' value='' readonly/></td>
                                        </tr>
                                        <tr class="default-address">
                                            <td class="text-center"><i class="fas fa-phone-alt"></i></td>
                                            <td><input class="invoice-inputs" id="shipping_address5" type='text' value='' readonly/></td>
                                        </tr>
                                        <tr class="default-address">
                                            <td class="text-center"><i class="fas fa-envelope"></i></td>
                                            <td><input class="invoice-inputs" id="shipping_address6" type='text' value='' readonly/></td>
                                        </tr>

                                        New Shipping Address
                                         <tr class="new-address">
                                            <td width="25px">Street: </td>
                                            <td><input class="invoice-inputs" id="new_street" name="new_street" type='text'/></td>
                                        </tr>
                                        <tr class="new-address">
                                            <td>City: </td>
                                            <td><input class="invoice-inputs" id="new_city" name="new_city" type='text'/></td>
                                        </tr>
                                        <tr class="new-address">
                                            <td>State: </td>
                                            <td><input class="invoice-inputs" id="new_state" name="new_state" type='text'/></td>
                                        </tr>
                                        <tr class="new-address">
                                            <td>Postal Code: </td>
                                            <td><input class="invoice-inputs" id="new_postal_code" name="new_postal_code" type='text'/></td>
                                        </tr>
                                        <tr class="new-address">
                                            <td>Country: </td>
                                            <td><input class="invoice-inputs" id="new_country" name="new_country" type='text'/></td>
                                        </tr>
                                        <tr class="new-address">
                                            <td class="text-center"><i class="fas fa-phone-alt"></i></td>
                                            <td><input class="invoice-inputs" id="new_phone_no" name="new_phone_no" type='text'/></td>
                                        </tr>
                                        <tr class="new-address">
                                            <td class="text-center"><i class="fas fa-envelope"></i></td>
                                            <td><input class="invoice-inputs" id="new_email" name="new_email" type='text'/></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table shipping_details">
                                        <tr>
                                            <th colspan="4">Order Description:</th>
                                        </tr>
                                        <tr>
                                            <td class="text-center" width="25px"><i class="fas fa-file-signature"></i></td>
                                            <td><textarea class="invoice-inputs" id="order_description" name="order_description" type='text' rows="10" value='' style="margin-top: 5px; margin-bottom: 7px;"></textarea></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 mb-2 text-right">
                                    <button type="button" class="btn btn-info btn-sm" id="add_item"><i class="fas fa-plus"></i> Add Item</button>
                                </div>

                                <div class="col-md-12">
                                    <table class="table Product_details table-responsive" id="order_item_table" >
                                        <thead>
                                            <tr>
                                                <th class="text-center">ITEM</th>
                                                <th class="text-center">PATTERN CODE</th>
                                                <th class="text-center" style="width: 10%;">STATUS</th>
                                                <th class="text-center">EST DELIVERY</th>
                                                <th class="text-center">TRACKING</th>
                                                <th class="text-center">Fabric</th>
                                                <th class="text-center" style="width: 20%;">Embellishment</th>
                                                <th class="text-center">Attributes</th>
                                                <th class="text-center">QTY</th>
                                                <th class="text-center">UNIT PRICE($)</th>
                                                <th class="text-center">TOTAL($)</th>
                                                <th class="text-center">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody id="product_table_body">
                                            <tr><input type="hidden" value="1" id="row_no"/></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row text-right">
                                <div class="col-lg-12">
                                    <div class="col-lg-6 float-right">
                                        <table id="invoice_summery_table" class="table invoice_summery">
                                            <tr>
                                                <th>SUBTOTAL ($) :</th>
                                                <td><input class="invoice-inputs text-right" name="sub_total" id="sub_total" type='text' value='0.00' readonly/></td>
                                            </tr>
                                            <tr>
                                                <th>SALES TAX ($) <span id="sales_tax_display"></span>% RATE :</th>
                                                <td>
                                                    <input type="hidden" id="sales_tax_percentage" />
                                                    <input class="invoice-inputs text-right" name="sales_tax" id="sales_tax" type='text' value='0' readonly />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>SHIPPING ($) :</th>
                                                <td><input class="invoice-inputs text-right" name="shipping" id="shipping" type='text' value='0'/></td>
                                            </tr>
                                            <tr>
                                                <th>ARTWORK ($) :</th>
                                                <td><input class="invoice-inputs text-right" name="artwork" id="artwork" type='text' value='0'/></td>
                                            </tr>
                                            <tr>
                                                <th>PROCESSING FEE ($) :</th>
                                                <td><input class="invoice-inputs text-right" name="processing_fee" id="processing_fee" type='text' value='0' readonly /></td>
                                            </tr><br>
                                            <tr>
                                                <th class="total">ORDER TOTAL ($) :</th>
                                                <td><input class="invoice-inputs text-right" style="font-weight: bold; font-size: large;" name="order_total" id="order_total" type='text' value='0.00' readonly/></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 control-btns mt-3 no-print">
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        <button type="button" class="btn btn-secondary btn-custom">Print</button>
                    </div>
                </form>
            </div>

        </div>
    </div> --}}
</div>

<input type="hidden" id="from_order_create_page" value="1"/>
<input type="hidden" id="organization_id_from_contact" value="{{app('request')->input('organization_id')}}"/>

@include('pages.order_management.new_inventory_order.add_item_modal')
@include('pages.contacts.modals.people_create_modal')
{{-- @include('pages.contacts.modals.organization_create_modal') --}}
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    $(document).ready(function(){
        $('body').on('submit', function() {
            $(".se-pre-con").fadeIn();
        });

        if($("#organization_id_from_contact").val() != ""){
            $('#organization_id').val($("#organization_id_from_contact").val());
            organizationChange($("#organization_id_from_contact").val());
        }

        $('.new-address').hide();
        $(".se-pre-con").fadeOut('slow');
        $('.select2-new-order').select2();

        $('.select2-add-item').select2({
            dropdownParent: $('.select-container')
        });

        // USA Date Fomat
        var today = ("0" +(new Date().getMonth()+1)).slice(-2) +'/'+ ("0" + new Date().getDate()).slice(-2) +'/'+ new Date().getFullYear();
        $('.open-date').val(today);
        $('.open-date').datepicker();

        $('.datepicker').datepicker();

        $('.modal-datepicker').val(today);
        $('.modal-datepicker').datepicker();

        $('#ex_factory_date').on('change', function(){
            var ex_factory_date = $(this).val();

            $.ajax({
                url:"{{ url('due_date/ex_factory_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'ex_factory_date': ex_factory_date,'typeID': 1, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    // $('#encore_packing_date').val(data[0]);
                    $('#due_date').val(data);

                    $('#item_due_date').val(data);
                    $('#item_delivery_date').val(ex_factory_date);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        $('#organization_id').val(1377);
        organizationChange(1377);

        // $('#encore_packing_date').on('change', function(){
        //     var encore_packing_date = $(this).val();

        //     $.ajax({
        //         url:"{{ url('encore_packing_date') }}",
        //         method:'POST',
        //         dataType:'json',
        //         data: {
        //             'encore_packing_date': encore_packing_date, '_token':'{{csrf_token()}}'
        //         },
        //         beforeSend: function () {
        //             $(".se-pre-con").fadeIn('slow');
        //         },
        //         success: function (data){
        //             $('#ex_factory_date').val(data[0]);
        //             $('#due_date').val(data[1]);
        //         },
        //         complete: function () {
        //             $(".se-pre-con").fadeOut('slow');
        //         }
        //     });
        // });

        $('#due_date').on('change', function(){
            var due_date = $(this).val();

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
                    $('#ex_factory_date').val(data);
                    // $('#encore_packing_date').val(data[1]);

                    $('#item_due_date').val(due_date);
                    $('#item_delivery_date').val(data);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        $('#order_status_id').on('change', function(){
            $('#status_id').val($(this).val()).change();
        });

        $('#organization_id').on('change', function(){
            var organizationId = $(this).val();
            organizationChange(organizationId);
        });

        function organizationChange(organizationId){

            $.ajax({
                url:"{{ url('new_inventory_orders/customers') }}/"+organizationId,
                method:'GET',
                dataType:'json',
                success: function (data, textStatus, jqXHR){

                    var contactList = data.contact_organizations;

                    if(contactList.length > 0){
                        var organization = data.contact_organizations[0].organizations[0];

                        $('#customer_id').html('');
                        $('<option value="">Select Customer</option>').appendTo($('#customer_id'));

                        for(var i = 0; i < contactList.length; i++){

                            var contact=contactList[i].contacts[0];

                            var firstName = '';
                            var lastName = '';
                            if(contact.first_name != null){
                                firstName = contact.first_name;
                            }
                            if(contact.last_name != null){
                                lastName = contact.last_name;
                            }
                            $('<option value="'+ contact.id +'">'+ firstName +' '+ lastName +'</option>').appendTo($('#customer_id'));

                        }

                        if(organization.sales_tax_active == 1){
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

                    if(data.user_id != ""){
                        $('#user_id').val(data.user_id).change();
                        $('#item_support_agent').val(data.user_id).change();
                    }

                    $('#shipping_address2').val('');
                    $('#shipping_address3').val('');
                    $('#shipping_address_postal').val('');
                    $('#shipping_address4').val('');
                    $('#shipping_address5').val('');
                    $('#shipping_address6').val('');
                }
            });

            $('#item_organization').val(organizationId).trigger('change');
        }

        $('#customer_id').on('change', function(){
            var customerId = $(this).val();
            console.log(customerId);

            $('#shipping_address2').val("");
            $('#shipping_address3').val("");
            $('#shipping_address_postal').val("");
            $('#shipping_address4').val("");
            $('#shipping_address5').val("");
            $('#shipping_address6').val("");

            $.ajax({
                url:"{{ url('new_inventory_orders/address') }}/"+customerId,
                method:'GET',
                dataType:'json',
                success: function (data){
                    if(data.shipping_city == null){
                        var shipping_city = '';
                    } else {
                        var shipping_city = data.shipping_city + ', ';
                    }

                    if(data.shipping_state == null){
                        var shipping_state = '';
                    } else {
                        var shipping_state = data.shipping_state + ', ';
                    }

                    $('#shipping_address2').val(data.shipping_street);
                    $('#shipping_address3').val(shipping_city + shipping_state);
                    $('#shipping_address_postal').val(data.shipping_zip);
                    $('#shipping_address4').val(data.shipping_country);
                    $('#shipping_address5').val(data.phone_no);
                    $('#shipping_address6').val(data.email);
                }
            });
        });

        $('#user_id').on('change', function(){
            var userId = $(this).val();
            $('#item_support_agent').val(userId).trigger('change');
        });

        // Add Items
        $('#add_item').on('click', function (){
            // var itemNo = $('#row_no').val();
            // $('#item_id').val(itemNo);

            // var orderNo = $('#order_no').val();
            // $('#item_no').val(orderNo+'-'+itemNo);
            // $('#add_item_modal').modal('show');
            addItemReset();
            addItemStart();
            $('#add_item_modal').modal({backdrop: 'static', keyboard: false});
        });

        // Editd new Item
        $('#order_item_table').on('click', '.edit-item', function(){
            var itemTr = $(this).closest('tr');
            var itemNo = $(this).val();
            addItemReset();
            editItemStart(itemNo, itemTr);
            $('#add_item_modal').modal({backdrop: 'static', keyboard: false});
        });

        // Remove Item
        $('#order_item_table').on('click', '.remove-item', function(){
            $(this).closest('tr').remove();
        });

        // Calculate Order Amount
        $('#product_table_body').on('input', '.item-qty', function(){
            var itemQty = $(this).val();
            var itemPrice = $(this).closest('td').next().find('.item-price').val();
            var total = parseFloat(itemQty) * parseFloat(itemPrice);

            $(this).closest('td').next().next().find('.item-total').val(total);

            var sum = 0;
            $('.item-total').each(function(){
                sum += parseFloat(this.value);
            });
            $('#sub_total').val(sum);

            var subTotal = $('#sub_total').val();
            var salesTaxPre = $('#sales_tax_percentage').val();

            var saleTaxAmount = parseFloat(subTotal)/100*parseFloat(salesTaxPre);
            $('#sales_tax').val(saleTaxAmount);

            var salesTax = $('#sales_tax').val();
            var shipping = $('#shipping').val();
            var artwork = $('#artwork').val();
            var processingFee = $('#processing_fee').val();

            totalAmount = parseFloat(subTotal) + parseFloat(salesTax) + parseFloat(shipping) + parseFloat(artwork) + parseFloat(processingFee);
            var orderTotal = $('#order_total').val(totalAmount);
        });

        $('#product_table_body').on('input', '.item-price', function(){
            var itemQty = $(this).closest('td').prev().find('.item-qty').val();
            var itemPrice = $(this).val();
            var total = parseFloat(itemQty) * parseFloat(itemPrice);

            $(this).closest('td').next().find('.item-total').val(total);

            var sum = 0;
            $('.item-total').each(function(){
                sum += parseFloat(this.value);
            });
            $('#sub_total').val(sum);

            var subTotal = $('#sub_total').val();
            var salesTaxPre = $('#sales_tax_percentage').val();

            var saleTaxAmount = parseFloat(subTotal)/100*parseFloat(salesTaxPre);
            $('#sales_tax').val(saleTaxAmount);

            var salesTax = $('#sales_tax').val();
            var shipping = $('#shipping').val();
            var artwork = $('#artwork').val();
            var processingFee = $('#processing_fee').val();

            totalAmount = parseFloat(subTotal) + parseFloat(salesTax) + parseFloat(shipping) + parseFloat(artwork) + parseFloat(processingFee);
            var orderTotal = $('#order_total').val(totalAmount);
        });

        $('#invoice_summery_table').on('input', '#shipping', function(){
            var subTotal = $('#sub_total').val();
            var salesTax = $('#sales_tax').val();
            var shipping = $(this).val();
            var artwork = $('#artwork').val();
            var processingFee = $('#processing_fee').val();

            totalAmount = parseFloat(subTotal) + parseFloat(salesTax) + parseFloat(shipping) + parseFloat(artwork) + parseFloat(processingFee);
            var orderTotal = $('#order_total').val(totalAmount);
        });

        $('#invoice_summery_table').on('input', '#artwork', function(){
            var subTotal = $('#sub_total').val();
            var salesTax = $('#sales_tax').val();
            var shipping = $('#shipping').val();
            var artwork = $(this).val();
            var processingFee = $('#processing_fee').val();

            totalAmount = parseFloat(subTotal) + parseFloat(salesTax) + parseFloat(shipping) + parseFloat(artwork) + parseFloat(processingFee);
            var orderTotal = $('#order_total').val(totalAmount);
        });

        $('#invoice_summery_table').on('input', '#processing_fee', function(){
            var subTotal = $('#sub_total').val();
            var salesTax = $('#sales_tax').val();
            var shipping = $('#shipping').val();
            var artwork = $('#artwork').val();
            var processingFee = $(this).val();

            totalAmount = parseFloat(subTotal) + parseFloat(salesTax) + parseFloat(shipping) + parseFloat(artwork) + parseFloat(processingFee);
            var orderTotal = $('#order_total').val(totalAmount);
        });

        $('body').on('click', '#new_shipping_address', function(){
            if($(this).is(':checked')){
                $(this).val(1);
                $('.default-address').hide();
                $('.new-address').show();
            } else {
                $(this).val(0);
                $('.default-address').show();
                $('.new-address').hide();
            }
        });

        $('#add_people_create_modal').click(function(){
            var organizationId = $('#organization_id').val();
            if(organizationId == ''){
                Swal.fire(
                    'Error!',
                    'Please Select an Organization!',
                    'warning'
                );
                return;
            }

            clear_people_create_modal();

            $('#people_organization_id').val(organizationId).trigger('change');
            $('#people_organization_id_hide').val(organizationId);
            $('#people_create_modal').modal('show');
        });

        let header = "NEW ORDER";
            document.getElementById("header").innerHTML = header;
    });


</script>
