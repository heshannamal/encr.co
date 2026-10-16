@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('content')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
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
        padding: 6px 12px;
        border-top: 1px solid #ccc;
    }
    .tab-input {
        border: none;
        border-bottom: 1px solid #cad1d7;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }
    .select2 {
        height: 1.8rem;
        border-radius: 5px !important;
        border: 1px #e4e4e4b8 solid !important;
    }
    .select2-selection.select2-selection--single {
        height: 1.6rem !important;
    }
    .is-done{
        margin-left: -25px;
        margin-top: -5px;
    }
    #image_previewe_info {
        height: 100px;
        width: 100px;
    }
    .sport-ico-container {
        margin-left: -26px;
        margin-top: 22px;
        margin-right: 6px;
        width: 40px;
        height: 40px;
        /* background-color: #565656; */
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .sport-ico {
        font-size: 22px;
        color: #b8b8b8;
    }

    #customer_id{
        height: 70px !important;
    }

    #customer_id + .select2.select2-container{
        min-height: 60px !important;
        border: 1px #e4e4e4 solid !important;
        margin-right: 2px;
    }

    #addRemoveContactsList{
        height: 100px !important;
    }

    #addRemoveContactsList + .select2.select2-container{
        min-height: 100px !important;
    }
    .pic-size {
        width: 41px;
        height: 41px;
    }
    .btn-div-height {
        height: 50px;
    }
    .pic-position {
        position: relative;
        top: -2px;
    }
    .text-color {
        color: #ffffff
    }
    .btn-txt-size {
        font-size: small;
    }
    .add-btn-padding {
        padding-right: unset;
    }
    .layout-btn-padding {
        padding: unset;
    }
    .btn-position-right {
        position: relative;
        right: -15px;
    }
    .btn-position-left {
        position: relative;
        left: -15px;
    }
    .btn-text-top {
        position: relative;
        top: -2px;
    }
    .add-btn-right {
        position: relative;
        right: -5px;
    }
    .export-btn-right {
        position: relative;
        right: -15px;
    }
    .content-position {
        position: relative;
        top: -15px;
    }
    .rep-div-padding {
        padding: unset;
    }
    .name-position {
        position: relative;
        left: 10%;
    }
    .pic2-position {
        position: relative;
        left: 5%;
        background-color: #ffffff;
        width: 42px;
        height: 41px;
    }
    .map-btn-right {
        width: 100%;
        padding: unset;
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
    .btn-top {
        position: relative;
        top: -20px;
    }
    .btn-right {
        position: relative;
        right: 13px;
    }
    .details-position {
        position: relative;
        left: 54px;
    }
    .content-position {
        position: relative;
        top: -5px;
    }
    .sport-icon {
        width: 35px !important;
        height: 35px !important;
        position: relative;
        top: 3px;
    }
    .select2 {
        height: 1.8rem;
        border-radius: 5px !important;
        border: 1px solid #cad1d7 !important;
    }

    .store-navbar .nav-link{
        color: grey !important;
        font-size: .8rem;
    }
    .store-navbar .nav{
        color: grey !important;
        font-size: .8rem;
        border-bottom: 2px solid #70717171 !important;
    }

    .styled-nav-item .nav-link.active , .styled-nav-item .nav-link:hover {
        color: black !important;
        border-bottom: 2px solid black !important;
        font-size: .8rem;
    }
    .card{
        border-radius: 0rem !important;
        border: none !important;
    }
    .form-lable-info{
        color: black;
    }
    .detail-section input[type="text"], .detail-section input[type="email"], .select2.select2-container.select2-container--default{
        border-radius: 0rem !important;
        color: #717070 !important;
        /* border: 0.5px solid #eaeaea !important; */
        width: 100% !important;
    }
    .card-body {
        padding: 1rem;

    }
    .card{
        height: 100%;
    }
    .header-style{
        color: black;
        font-size: 1.2rem;
        font-weight: 600;
    }
    .sub-header-style{
        color: black;
        font-size: 1rem;
        font-weight: 600;
    }
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
    .color-selection-box .select2-container--default .select2-selection--multiple{
        background-color: transparent;
    }
    .color-selection-box .select2-container--below .select2-container--focus, .color-selection-box .select2-container--default{
        min-height: 93px;
    }
    .styled-button-decoration{
        border: none !important;
        border-radius: 0rem !important;
        font-size: .8rem !important;
        padding: .2em 2em !important;
        cursor: pointer;
    }
    .color-selection-box .select2-selection__rendered .row{
        position: relative !important;
        left: 13px !important;
        width: 136px;
        height: 18px !important;
    }
    .color-selection-box .select2-selection__choice{
        display: inline-flex !important;
        width: 155px !important;
        border-radius: 0rem !important;
        height: 20px !important;
    }
    .color-selection-box .select2-container--default .select2-selection--multiple .select2-selection__choice {
        margin-top: 0px !important;
        line-height: 7px !important;
        background-color: #ffffff !important;
    }
    .mail_mail-button{
        outline: unset;
        color: #d3d3d3;
        background-color: transparent;
        border: 1px solid #d3d3d3;
        padding: .2rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: .3rem;
        cursor: pointer;
    }
    .sales-rep-style .select2-selection--single{
        background-color: transparent;
        color: #d3d3d3;
    }
    .sales-rep-style .select2-container--default{
        border: none !important;
    }
    .sales-rep-style .select2-selection__rendered{
        line-height: 25px !important;
        color:#47D6B6 !important;
    }
    .sales-rep-style .select2{
        height: 1.5rem !important;
    }
    .store-unique-styles table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .store-unique-styles table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .store-unique-styles table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .store-unique-styles table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .store-unique-styles th, .store-unique-styles td {
        padding: 10px;
    }
    .store-unique-styles .dataTables_info {
        color:#b3b3b3;
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
    .datepicker{
        border-radius: 0rem;
    }
    .btn-green-outlined{
        border: 2px solid #47D6B6;
        background-color: transparent;
        color: #47D6B6;
        padding: .6rem .5rem;
        font-size: .7rem;
        cursor: pointer;
    }
    .grey-text-btn{
        background-color: transparent;
        border: none;
        font-size: .7rem;
        outline: unset;
        color: grey;
        font-weight: 600;
        cursor: pointer;
    }
    .img-thumbnail{
        border: none;
        border-radius: 0px;
        padding: 0px;
    }
    .available-lable{
        padding: 3px 10px;
        background-color: #E0F9D4;
        border-radius: .5rem;
        color: #55A630;
    }
    .unavailable-lable{
        padding: 3px 10px;
        background: #FFEDEE;
        border-radius: .5rem;
        color: #D00000;
    }
    .hidden-tab{
        display: none;
    }
    .nav-item-new{
        font-size: .7rem;
    }
    .nav-item-new :hover , .nav-item-new .active{
        border-bottom: 2px solid black;
        font-size: .7rem;
    }
    .nav-item-new .nav-link{
        color: grey;
    }
    .nav-item-new .active , .nav-item-new .nav-link :hover{
        color: black;
    }
    .checkbox-container{
        font-size: 1rem;
        color: #717070;
        background-color: #fafafa;
        padding: 5px 15px;
        border-radius: 1rem;
        margin: .6rem .25rem;
        /* border: 1px solid #47D6B6; */
    }
    .image-upload-area {
        border: 2px dashed #ddd;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        background-color: #fafafa;
    }

    .upload-icon {
        font-size: 48px;
        color: #aaa;
    }

    .file-input {
        display: none;
    }
    .icon-button{
        border: none;
        background-color: unset;
        color: #b3b3b3;
        font-size: 1rem;
        outline: unset;
        padding:1px 10px
    }
    .grey-color-button{
        padding: .3rem .5rem;
        font-size: .7rem;
        border: 1px solid #b3b3b3;
        color: grey;
        background-color: #f8f8f8;
        margin-left: .5rem;
    }



</style>

@section('back-btn')
    <a href="" class="home-btn-color" title="Back to home">BACK TO STORES</a>
@endsection

<div class="container-fluid mb-5 content-position store-unique-styles">
    <div class="se-pre-con"></div>
            <div class="col-md-12 content-position">
                <div style="border-radius: 0rem; background-color:transparent;border:none">
                    <div>
                        <div class="row">
                            <div class="col-md-4 d-flex align-items-center">
                                <span style="font-size: 1.5rem;color: black;font-weight: 600;">Test Store</span>
                            </div>
                        </div>
                        <div class="nav-wrapper store-navbar">
                            <ul class="nav" id="tabs-icons-text" role="tablist">
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">GENERAL INFO</a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#paymentInfo" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Payment and Info">PAYMENT & INFO
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#taxes_and_fees" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Taxes and fees">TAXES & FEES
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#products_tab" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Products">PRODUCTS
                                        <input type="hidden" id="orderCount" value=""/>
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#rewards" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Rewards">REWARDS
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#store_design" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Store Design">STORE DESIGN</a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#bulk_action" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Bulk Action">BULK ACTIONS
                                    </a>
                                </li>
                            </ul>
                        </div>

                        {{-- Summary Tab --}}
                        <div class="tab-content detail-section" id="myTabContent">

                            <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <form action="{{ route('store.create') }}" id="store_update" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="store_id" name="store_id" value="{{$store_id}}" />
                                    <div class="row">
                                        <div class="col-md-6 mb-2" style="padding-right: 7px">
                                            <div class="col-md-12" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-2">
                                                                Store Info
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-lable-info">Organization</label>
                                                                <select class="form-control info-form-input store-select2-dropdown" id="organization_id" name="organization_id" required>
                                                                    <option value="">Select an Organization</option>
                                                                    @foreach ($organizations as $organization)
                                                                    <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-lable-info">Sport</label>
                                                                <select class="form-control info-form-input store-select2-dropdown" id="sport_id" name="sport_id" required>
                                                                    <option value="">Select a sport</option>
                                                                    @foreach ($sports as $sport)
                                                                    <option value="{{$sport->id}}">{{$sport->sport_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Store Type</label>
                                                                <select class="form-control info-form-input store-select2-dropdown" id="store_type" name="store_type" required>
                                                                    <option value="">Select a store type</option>
                                                                    @foreach ($store_types as $store_type)
                                                                    <option value="{{$store_type->id}}">{{$store_type->store_type_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Store Name</label>
                                                                <input type="text" class="form-control info-form-input" id="store_name" name="store_name" value="" required />
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Sales Person</label>
                                                                <select class="form-control info-form-input store-select2-dropdown" id="sales_person" name="sales_person" required>
                                                                    <option value="">Select a user</option>
                                                                    @foreach ($users as $user)
                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Salese Code</label>
                                                                <input type="text" class="form-control info-form-input" id="sales_code" name="sales_code" value="" />
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Direct Access URL</label>
                                                                <input type="text" class="form-control info-form-input" id="url" name="url" value="" required>
                                                            </div>

                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Estimate Ship Date</label>
                                                                <input class="form-control info-form-input datepicker" name="est_ship_date" id="est_ship_date" required />
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Store Prefix For Products</label>
                                                                <input type="text" class="form-control info-form-input" id="store_prefix_for_products" name="store_prefix_for_products" value="" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-2">
                                                                Store Deadline
                                                            </div>
                                                            <div class="col-md-12 mt-2 mb-2 d-flex align-items-center">
                                                                <p class="m-0" style="font-size: .8rem;">Set Store Deadline</p>
                                                                <label class="custom-toggle ml-2 mb-0">
                                                                    <input type="checkbox" name="set_store_deadline" checked>
                                                                    <span class="custom-toggle-slider rounded-circle"></span>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-lable-info">Open Store On</label>
                                                                <input class="form-control info-form-input datepicker" name="open_date" id="open_date" required />
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-lable-info">Close Store On</label>
                                                                <input class="form-control info-form-input datepicker" name="close_date" id="close_date" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-1">
                                                                Contact Coaches
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="form-lable-info mb-2">Coach Email</label>
                                                                <input type="email" class="form-control info-form-input" name="coach_email" id="coach_email" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-2">
                                                                Customer Service
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-lable-info mb-1" style="font-size: .8rem;font-weight: 500;">Service Email</label>
                                                                <select class="form-control info-form-input store-select2-dropdown" id="service_email_sales_person" name="service_email_sales_person" required>
                                                                    <option value="">Select a user</option>
                                                                    @foreach ($users as $user)
                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="form-lable-info mb-1" style="font-size: .8rem;font-weight: 500;">Service Phone</label>
                                                                <input class="form-control info-form-input datepicker" name="open_date" id="open_date" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-2">
                                                                Order Tracker
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-lable-info mb-2" style="color: grey">Give your customer insight on their orders.</label>
                                                            </div>
                                                            <div class="col-md-12 mt-2 mb-2 d-flex align-items-center">
                                                                <p class="m-0" style="font-size: .8rem;">Enable Order Tracking</p>
                                                                <label class="custom-toggle ml-2 mb-0">
                                                                    <input type="checkbox" name="enable_order_tracking" checked>
                                                                    <span class="custom-toggle-slider rounded-circle"></span>
                                                                </label>
                                                            </div>

                                                            <table>
                                                                <tr style="border: none; font-size: .8rem;color:black">
                                                                    <td>
                                                                        <input type="radio" value="1" name="track_by" checked> Track by Order
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2" style="padding-left: 7px">
                                            <div class="col-md-12" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-1">
                                                                Messaging
                                                            </div>
                                                            <div class="col-md-12 mt-2" style="height: fit-content;">
                                                                <label class="sub-header-style">Store Welcome</label>
                                                                <label class="form-lable-info mb-2" style="color: grey">Display when a customer visits the store.</label>
                                                                <textarea name="welcome_message" id="welcome_message" class="form-control info-form-input" cols="30" rows="3" style="border-radius: 0rem;"></textarea>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <label class="sub-header-style">Store Welcome Message Type</label>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <label class="sub-header-style">Sale Expired</label>
                                                                <label class="form-lable-info mb-2" style="color: grey">Display to those trying to access the store once it's closed.</label>
                                                                <textarea name="sale_expired" id="sale_expired" class="form-control info-form-input" cols="30" rows="3" style="border-radius: 0rem;"></textarea>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <label class="sub-header-style">Checkout</label>
                                                                <label class="form-lable-info mb-2" style="color: grey">Display throughout the checkout process.</label>
                                                                <textarea name="checkout" id="checkout" class="form-control info-form-input" cols="30" rows="3" style="border-radius: 0rem;"></textarea>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <label class="sub-header-style">User Terms</label>
                                                                <label class="form-lable-info mb-2" style="color: grey">Display during the final checkout review, prior to finalizing an order.</label>
                                                                <textarea name="user_terms" id="user_terms" class="form-control info-form-input" cols="30" rows="3" style="border-radius: 0rem;"></textarea>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <label class="sub-header-style">Order Success</label>
                                                                <label class="form-lable-info mb-2" style="color: grey">Display on the order confirmation page.</label>
                                                                <textarea name="order_success" id="order_success" class="form-control info-form-input" cols="30" rows="3" style="border-radius: 0rem;"></textarea>
                                                            </div>
                                                            <div class="col-md-12 mt-3">
                                                                <label class="sub-header-style">Receipt Header</label>
                                                                <label class="form-lable-info mb-2" style="color: grey">Display on the customer recipt.</label>
                                                                <textarea name="receipt_header" id="receipt_header" class="form-control info-form-input" cols="30" rows="3" style="border-radius: 0rem;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-8 header-style mb-1">
                                                                Store Template
                                                            </div>
                                                            <div class="col-md-4 mb-1 text-right">
                                                                <button type="button" class="grey-text-btn">MANAGE TEMPLATE</button>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="form-lable-info mb-2" style="color: grey">This store will be saved as atemplate and be used as a starting point for your next store.</label>
                                                                <label class="form-lable-info mb-2"><i class="fa fa-info-circle" style="color: orange" aria-hidden="true"></i>&nbsp; If your store has a deadline, it can not be saved as a template.</label>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <button type="button" class="btn-green-outlined" onclick="save_as_template('{{$store_id}}')">SAVE AS TEMPLATE</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 control-btns mb-5" style="background-color: white;padding-top:0px">
                                        {{-- @can('edit organizations') --}}
                                            <button type="submit" style="background-color: #47D6B6" class="styled-button-decoration btn btn-success btn-custom mt-2">Save</button>
                                        {{-- @endcan --}}

                                        {{-- @can('delete organizations') --}}
                                            <button type="button" id="delete_form" style="background-color: #b3b3b3" class="styled-button-decoration btn btn-danger btn-custom mt-2" value="">Delete</button>
                                        {{-- @endcan --}}
                                            <button type="reset" style="background-color: #d27070;color:white" class="styled-button-decoration btn btn-secondary btn-custom mt-2">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            {{--================================ paymentInfo ===================================== --}}
                            <div class="tab-pane fade" id="paymentInfo" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                                <div class="row">
                                    <div class="col-md-4" style="padding-right: 7px;padding-left:0px">
                                        <div class="col-md-12" style="padding: 0px;height: 100%;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 header-style mb-2">
                                                            Payments
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-lable-info">How do you want to handle payments?</label>
                                                        </div>
                                                        <div class="col-md-12 mb-2 mt-2">
                                                            <input type="radio" name="Available"> Customer Credit Card
                                                            <label class="form-lable-info" style="color: grey">&nbsp;&nbsp;&nbsp;The customer pays immediately.</label>
                                                        </div>
                                                        <div class="col-md-12 mt-1 mb-2">
                                                            <input type="radio" name="Available"> Custom
                                                            <label class="form-lable-info" style="color: grey">&nbsp;&nbsp;&nbsp;The customer does not pay. (PO, school check, etc.)</label>
                                                        </div>
                                                        <div class="col-md-12 mt-1 mb-2">
                                                            <input type="radio" name="Available"> Redemption Store
                                                            <label class="form-lable-info" style="color: grey">&nbsp;&nbsp;&nbsp;Product prices are hidden from the storefront and payment <br> &nbsp;&nbsp;&nbsp; will not
                                                                be collected at checkout.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding-right: 0px; padding-left:7px">
                                        <div class="col-md-12" style="padding: 0px;height: 100%;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-8 header-style mb-1">
                                                            Shipping Methods
                                                        </div>
                                                        <div class="col-md-4 mb-1 text-right">
                                                            <button type="button" class="grey-text-btn">MANAGE</button>
                                                        </div>
                                                        <div class="col-md-12 mt-2 mb-3">
                                                            <label class="form-lable-info">Add Shipping Method</label>
                                                            <select class="form-control info-form-input store-select2" required>
                                                                <option value="">Select a shipping method</option>
                                                                {{-- @foreach ($users as $user)
                                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="container mb-2" style="background-color: #fafafac4; position: relative;">
                                                                <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;font-size: .8rem;">Direct To Customer Shipping</p>
                                                                <p style="color: #b3b3b3;margin-bottom:.1rem;padding-bottom: .5rem;    font-size: .75rem;">$15.00 - Handling Fee</p>
                                                            </div>
                                                            <div class="container mb-2" style="background-color: #fafafac4; position: relative;">
                                                                <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;font-size: .8rem;">Direct To Customer Shipping</p>
                                                                <p style="color: #b3b3b3;margin-bottom:.1rem;padding-bottom: .5rem;    font-size: .75rem;">$15.00 - Handling Fee</p>
                                                            </div>
                                                            <div class="container mb-2" style="background-color: #fafafac4; position: relative;">
                                                                <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;font-size: .8rem;">Direct To Customer Shipping</p>
                                                                <p style="color: #b3b3b3;margin-bottom:.1rem;padding-bottom: .5rem;    font-size: .75rem;">$15.00 - Handling Fee</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding-right: 0px">
                                        <div class="col-md-12" style="padding-left:0px;padding-right:0px;height: 100%;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-8 header-style mb-1">
                                                            Custom Information
                                                        </div>
                                                        <div class="col-md-4 mb-1 text-right">
                                                            <button type="button" class="grey-text-btn">MANAGE</button>
                                                        </div>
                                                        <div class="col-md-12 mt-2 mb-2">
                                                            <label class="form-lable-info" style="color: grey">If you wish to collect custom information, insert custom fields here.</label>
                                                        </div>
                                                        <div class="col-md-12 mt-2 mb-3">
                                                            <label class="form-lable-info">Add a Field</label>
                                                            <select class="form-control info-form-input store-select2" required>
                                                                <option value="">Select a field</option>
                                                                {{-- @foreach ($users as $user)
                                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="container mb-2" style="background-color: #fafafac4; position: relative;">
                                                                <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                <p style="color: grey;margin-bottom:.5rem;padding-top: .5rem;padding-bottom: .5rem;font-size: .8rem;">First Name and Last Name</p>
                                                            </div>
                                                            <div class="container mb-2" style="background-color: #fafafac4; position: relative;">
                                                                <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                <p style="color: grey;margin-bottom:.5rem;padding-top: .5rem;padding-bottom: .5rem;font-size: .8rem;">Shipping Address</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


{{--============================== taxes & fees ==================================== --}}
                            <div class="tab-pane fade" id="taxes_and_fees" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                <div class="row">
                                    <div class="col-md-4" style="padding-right: 7px">
                                        <div class="col-md-12" style="padding: 0px;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 header-style mb-2">
                                                            Taxes
                                                        </div>
                                                        <div class="col-md-12 mt-2 mb-2 d-flex align-items-center">
                                                            <p class="m-0" style="font-size: .8rem;">Calculate taxes automatically</p>
                                                            <label class="custom-toggle ml-2 mb-0">
                                                                <input type="checkbox" checked>
                                                                <span class="custom-toggle-slider rounded-circle"></span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-lable-info mb-2" style="color: grey;font-size: .8rem;">When you enable this feature, it will automatically calculate taxes per customer based on your business nexuses, product tax categories and customer information</label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-lable-info mb-2" style="color: grey;font-size: .8rem;"> <span style="font-size: .9rem; font-weight:600">Please Note:</span> This feature will replace any manually-added taxes. When this feature is on, you won’t be able to add manual taxes to this store.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding-right: 0px; padding-left:7px">
                                        <div class="col-md-12" style="padding: 0px;height: 100%;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-8 header-style mb-1">
                                                            Fees
                                                        </div>
                                                        <div class="col-md-4 mb-1 text-right">
                                                            <button type="button" class="grey-text-btn">MANAGE</button>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-lable-info">Add Fees</label>
                                                            <select class="form-control info-form-input store-select2" id="organization_id" name="organization_id" required>
                                                                <option value="">Select Fee</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-12" style="padding-left:0px;height: 100%;">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-8 header-style mb-1">
                                                            Coupons
                                                        </div>
                                                        <div class="col-md-4 mb-1 text-right">
                                                            <button type="button" class="grey-text-btn">MANAGE</button>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-lable-info">Add Coupons</label>
                                                            <select class="form-control info-form-input store-select2" id="organization_id" name="organization_id" required>
                                                                <option value="">Select Fee</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

{{--================================ Products ======================================== --}}
                            <div class="tab-pane fade" id="products_tab" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                <div class="row">
                                    <div class="col-md-4" style="padding-right:7px">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 header-style mb-1">
                                                        Products
                                                    </div>
                                                    <div class="col-md-6 mb-1 text-right">
                                                        <button type="button" class="grey-text-btn">CEATE NEW PRODUCT</button>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-lable-info" style="color: grey">Showing all <span>153</span> products</label>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <div style="position: relative;">
                                                            <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%);">
                                                                <i class="fas fa-search" style="color: #adadad;"></i>
                                                            </span>
                                                            <input type="text" class="form-control" style="border: none; border-bottom: 1px solid #adadad; padding-left: 30px;" placeholder="Products, stores or catalog search">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 sub-header-style mb-1 mt-3">
                                                        Product Bundles
                                                    </div>
                                                    <div class="col-md-6 mb-1 text-right mt-3">
                                                        <button type="button" class="grey-text-btn">SELECT ALL PRODUCTS</button>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-lable-info" style="color: rgb(126, 126, 126)">To edit and unbundle go to the Bulk Action tab.</label>
                                                    </div>
                                                    <div class="col-md-12 ml-auto mb-1 mt-2 text-right">
                                                        <button type="button" class="grey-text-btn">SORT CATEGORIES</button>
                                                    </div>
                                                    <div id="store_product_list" style="height: 50rem;overflow-y: scroll;">
                                                        {{-- products here --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8" style="padding: 0px">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 header-style mb-1">
                                                        Products Info
                                                    </div>
                                                    <div class="col-md-12">
                                                        <ul class="nav" role="tablist" style="border-bottom: 2px solid #bebebe;">
                                                            <li class=" nav-item-new" role="presentation">
                                                                <a class="nav-link active nav-link-new" id="general_tab-new" href="#" onclick="showTab('general_tab')">GENERAL</a>
                                                            </li>
                                                            <li class=" nav-item-new" role="presentation">
                                                                <a class="nav-link nav-link-new" id="size_options-new" href="#" onclick="showTab('size_options')">SIZE & OPTIONS</a>
                                                            </li>
                                                            <li class=" nav-item-new" role="presentation">
                                                                <a class="nav-link nav-link-new" id="images_tab-new" href="#" onclick="showTab('images_tab')">IMAGES</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content mt-2">
                                                            <div class="tab-pane-new fade show active" id="general_tab" role="tabpanel">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-md-12 sub-header-style mb-1">
                                                                                Basic Info
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <label class="form-lable-info">Name</label>
                                                                                <input type="text" class="form-control info-form-input" id="store_name" name="store_name" value="" required />
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <label class="form-lable-info">Category</label>
                                                                                <select class="form-control info-form-input store-select2" id="sales_person" name="sales_person" required>
                                                                                    <option value="">Select a category</option>
                                                                                    {{-- @foreach ($users as $user)
                                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                                    @endforeach --}}
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <label class="form-lable-info">Sub Category</label>
                                                                                <select class="form-control info-form-input store-select2" id="sales_person" name="sales_person" required>
                                                                                    <option value="">Select a sub category</option>
                                                                                    {{-- @foreach ($users as $user)
                                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                                    @endforeach --}}
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <label class="form-lable-info">Manufacturer</label>
                                                                                <select class="form-control info-form-input store-select2" id="sales_person" name="sales_person" required>
                                                                                    <option value="">Select a manufacturer</option>
                                                                                    {{-- @foreach ($users as $user)
                                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                                    @endforeach --}}
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-12 mt-2" style="height: fit-content;">
                                                                                <label class="form-lable-info mb-2">Style</label>
                                                                                <textarea name="style_text" id="style_text" class="form-control info-form-input" cols="30" rows="3" style="border-radius: 0rem;"></textarea>
                                                                            </div>
                                                                            <div class="col-md-12 sub-header-style mt-3">
                                                                                Product Availability
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <table>
                                                                                    <tr style="border: none; font-size: .8rem;color:black">
                                                                                        <td>
                                                                                            <input type="radio" name="Available"> Available
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="radio" name="Unavailable"> Unavailable
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            {{-- <div class="col-md-12 sub-header-style mb-2">
                                                                                Multiple Quantities Tab
                                                                            </div>
                                                                            <div class="col-md-12 mt-2 mb-2 d-flex align-items-center">
                                                                                <p class="m-0" style="font-size: .8rem;">Enable multiple quantities tab</p>
                                                                                <label class="custom-toggle ml-2 mb-0">
                                                                                    <input type="checkbox" checked>
                                                                                    <span class="custom-toggle-slider rounded-circle"></span>
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-md-12 mt-2 mb-2">
                                                                                <label class="form-lable-info mb-2" style="color: grey; font-size: .7rem;">When you enable this feature, it allows consumers to quickly place bulk <br> orders in the storefront product pages. <br>
                                                                                    If disabled, consumers will only see the single item ordering tab.</label>
                                                                            </div>
                                                                            <div class="col-md-12 sub-header-style mb-2">
                                                                                Min / Max Quantities
                                                                            </div>
                                                                            <div class="col-md-6 mt-2">
                                                                                <label class="form-lable-info">Minimum Quantity</label>
                                                                                <input type="number" class="form-control info-form-input" value="" required />
                                                                            </div>
                                                                            <div class="col-md-6 mt-2">
                                                                                <label class="form-lable-info">Maximum Quantity</label>
                                                                                <input type="number" class="form-control info-form-input" value="" required />
                                                                            </div>
                                                                            <div class="col-md-12 mt-3">
                                                                                <label class="form-lable-info mb-2" style="color: grey;font-size: .8rem;"> <span style="font-size: .9rem; font-weight:600">Please Note:</span> Minimums and maximums apply to individual orders. To define the maximum number of units sold across all orders, use “Track Quantity Limits.”</label>
                                                                            </div> --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="row">
                                                                            {{-- <div class="col-md-12 sub-header-style mb-2">
                                                                                Payment Method
                                                                            </div>
                                                                            <div class="col-md-12 mt-1 mb-2">
                                                                                <input type="radio" name="Available"> Customer Credit Card
                                                                                <label class="form-lable-info" style="color: grey">&nbsp;&nbsp;&nbsp;The customer pays immediately.</label>
                                                                            </div>
                                                                            <div class="col-md-12 mt-1 mb-2">
                                                                                <input type="radio" name="Available"> Custom
                                                                                <label class="form-lable-info" style="color: grey">&nbsp;&nbsp;&nbsp;The customer does not pay. (purchase order, etc.)</label>
                                                                            </div>
                                                                            <div class="col-md-6 sub-header-style mb-1 mt-3">
                                                                                Prices
                                                                            </div>
                                                                            <div class="col-md-6 mb-1 text-right mt-3">
                                                                                <button type="button" class="grey-text-btn">ADD PRICE ADDITIONS</button>
                                                                            </div> --}}
                                                                            <div class="col-md-12 sub-header-style mb-2 mt-2">
                                                                                Price Analytics
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="form-lable-info">Primary Analytics Results</label>
                                                                                <table>
                                                                                    <tr style="border: none">
                                                                                        <td style="font-size:.8rem">Account Average Price :</td>
                                                                                        <td style="font-size:.8rem">$22.00</td>
                                                                                    </tr>
                                                                                    <tr style="border: none">
                                                                                        <td style="font-size:.8rem">Sales Rep Average Price :</td>
                                                                                        <td style="font-size:.8rem">$22.00</td>
                                                                                    </tr>
                                                                                </table>
                                                                                <label class="form-lable-info" style="color: grey">There is not enough data available for this  product to provide more
                                                                                    pricing analytics.</label>
                                                                            </div>
                                                                            <div class="col-md-12 mt-2 mb-2">
                                                                                <label class="form-lable-info">Upgrade to Beta Release for more pricing analytics!</label>
                                                                            </div>
                                                                            {{-- <div class="col-md-12 mt-3 mb-3">
                                                                                <button type="button" style="width: 100%;font-size:.8rem" class="btn-green-outlined">UPGRADE PRICE ANALYTICS</button>
                                                                            </div> --}}
                                                                            {{-- <div class="col-md-6 sub-header-style mb-1 mt-3">
                                                                                Volume Pricing
                                                                            </div>
                                                                            <div class="col-md-6 mb-1 text-right mt-3">
                                                                                <button type="button" class="grey-text-btn">CREATE TABLE</button>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="form-lable-info" style="color: grey">This feature provides a table with quantity breaks based on the number of units purchased. </label>
                                                                                <label class="form-lable-info mt-1" style="color: grey">This table will display on the product page for  consumers.</label>
                                                                            </div> --}}
                                                                            <div class="col-md-6 sub-header-style mb-1 mt-3">
                                                                                Tax Category
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="form-lable-info mt-1" style="color: grey">Please select your tax category here.</label>
                                                                            </div>
                                                                            <div class="col-md-6 mt-2 mb-3">
                                                                                <label class="form-lable-info">Tax Category</label>
                                                                                <select class="form-control info-form-input store-select2" required>
                                                                                    <option value="">Select a category</option>
                                                                                    {{-- @foreach ($users as $user)
                                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                                    @endforeach --}}
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-12 sub-header-style mb-1 mt-2">
                                                                                Product Shipping Weight
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="form-lable-info mt-1" style="color: grey">Please enter this product shipping weight here.</label>
                                                                            </div>
                                                                            <div class="col-md-6 mt-2 mb-3">
                                                                                <label class="form-lable-info">Shipping Weight (OZ)</label>
                                                                                <select class="form-control info-form-input store-select2" required>
                                                                                    <option value="">Select a weight</option>
                                                                                    {{-- @foreach ($users as $user)
                                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                                    @endforeach --}}
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane-new fade hidden-tab" id="size_options" role="tabpanel">
                                                                <div class="row">
                                                                    <div class="col-md-8 sub-header-style mb-2 mt-1">
                                                                        Product Sizes
                                                                    </div>
                                                                    <div class="col-md-4 text-right mb-2 mt-1">
                                                                        <button type="button" style="font-size: .8rem;" class="grey-text-btn">ADD SIZE OPTIONS</button>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-lable-info mt-1" style="color: grey; font-size: .8rem;">Please select the all the size options available for this product.</label>
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <div class="container" style="border: 1px solid lightgrey;min-height: 18rem;">
                                                                            <label class="checkbox-container">Youth Small
                                                                                <input type="checkbox" style="display: none">
                                                                            </label>
                                                                            <label class="checkbox-container">Youth Medium
                                                                                <input type="checkbox" style="display: none">
                                                                            </label>
                                                                            <label class="checkbox-container">Adult XXX-Large
                                                                                <input type="checkbox" style="display: none">
                                                                            </label>
                                                                            <label class="checkbox-container">Adult Medium
                                                                                <input type="checkbox" style="display: none">
                                                                            </label>
                                                                            <label class="checkbox-container">Adult Large
                                                                                <input type="checkbox" style="display: none">
                                                                            </label>
                                                                            <label class="checkbox-container">Adult X-Large
                                                                                <input type="checkbox" style="display: none">
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane-new fade hidden-tab" id="images_tab" role="tabpanel">
                                                                <div class="row">
                                                                    <div class="col-md-12 sub-header-style mb-2 mt-1">
                                                                        Product Images
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-lable-info mt-1" style="color: grey; font-size: .8rem;">Upload, sort and edit product images here. </label>
                                                                    </div>
                                                                    <div class="col-md-12 sub-header-style mb-2 mt-3" style="color: grey">
                                                                        Upload Images
                                                                    </div>
                                                                    <div class="col-md-12 mb-2">
                                                                        <div id="image-upload-area" class="image-upload-area">
                                                                            <div class="upload-icon">
                                                                                <i class="fas fa-cloud-upload-alt"></i>
                                                                            </div>
                                                                            <p style="color: grey">Drag & drop your file here or <span style="font-weight: 600">CLICK HERE</span>  to upload product images <br> We support .gif, .jpg & .png file formats </p>
                                                                            <input type="file" id="file-input" class="file-input" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 sub-header-style mb-2 mt-3" style="color: #B3B3B3">
                                                                        Gallery of Product Images
                                                                    </div>
                                                                    <div class="col-md-6 text-right mb-3 mt-3">
                                                                        <button type="button" style="font-size: .8rem;" class="grey-text-btn"><i class="fa fa-recycle" aria-hidden="true"></i>&nbsp;RECOVER DELETED IMAGES</button>
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <table style="width: 100%;">
                                                                            <tr style="height: 50px;border-top: 1px solid #eeeeee;border-bottom: 1px solid #eeeeee;background-color: #fafafa;font-size: .75rem;">
                                                                                <th>PRODUCT IMAGE</th>
                                                                                <th>IMAGE CAPTIONS </th>
                                                                                <th>CORRESPONDING COLOR OPTIONS</th>
                                                                                <th class="text-center">ACTIONS</th>
                                                                            </tr>
                                                                            <tr style="min-height: 50px;border-bottom: 1px solid #eeeeee;border-top: none;">
                                                                                <td>
                                                                                    <img style="height: 5rem;width: auto;" src="https://drive.google.com/uc?id=1cG4YzuQR8PnJrwijiK0E7k_nUapqg_zj&export=media" alt="Your Image" class="img-thumbnail">
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td class="text-center">
                                                                                    <button type="button" class="icon-button"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                                                                    <button type="button" class="icon-button" style="border-right: 1px solid #dcdcdc;border-left: 1px solid #dcdcdc;"><i class="fa fa-clone" aria-hidden="true"></i></button>
                                                                                    <button type="button" class="icon-button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                            <tr style="min-height: 50px;border-bottom: 1px solid #eeeeee;border-top: none;">
                                                                                <td>
                                                                                    <img style="height: 5rem;width: auto;" src="https://drive.google.com/uc?id=1TwCrBQSjod4Qs6xSFZ71fVLOqbm3gOIf&export=media" alt="Your Image" class="img-thumbnail">
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td class="text-center">
                                                                                    <button type="button" class="icon-button"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                                                                    <button type="button" class="icon-button" style="border-right: 1px solid #dcdcdc;border-left: 1px solid #dcdcdc;"><i class="fa fa-clone" aria-hidden="true"></i></button>
                                                                                    <button type="button" class="icon-button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

{{--================================== Rewards ===================================== --}}
                            <div class="tab-pane fade" id="rewards" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                <div class="row">
                                    <div class="card" style="width: 100%; min-height: 20rem;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 header-style mb-2 mt-1">
                                                    Gift Cards
                                                </div>
                                                <div class="col-md-12 text-center mb-2">
                                                    <div class="icon-text">
                                                        <i class="fa fa-gift mb-3" style="font-size: 5rem; color: #b3b3b3;"></i>
                                                        <p style="color: grey;font-size: .8rem;">
                                                            With gift cards, you have the ability to give your customers a unique gift code <br> containing a balance that is able to be used multiple times on a store until depleted.
                                                        </p>
                                                        <p style="color: #b3b3b3;font-size: .8rem;">
                                                            You currently have no gift cards created for store name <br> Get started by creating a gift card.
                                                        </p>
                                                        <button type="button" class="btn-green-outlined mt-2 mb-2">CREATE GIFT CARD</button>
                                                        <p class="mt-2 mb-2" style="color: #e1e1e1">Or</p>
                                                        <button type="button" style="font-weight: 100;color: #b3b3b3;" class="grey-text-btn">IMPORT GIFT CARD</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--================================ store design =================================== --}}
                            <div class="tab-pane fade" id="store_design" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Store design
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

{{--================================ Bulk action =================================== --}}
                            <div class="tab-pane fade" id="bulk_action" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row" style="margin-left: 0px">
                                                    <div class="col-md-6 row">
                                                        <div class="col-md-5" style="display: flex; align-items: center;color:#b3b3b3;border-right: 1px solid #b3b3b3">
                                                            Showing all &nbsp;<span> 153 </span>&nbsp; products
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div style="position: relative;">
                                                                <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%);">
                                                                    <i class="fas fa-search" style="color: #adadad;"></i>
                                                                </span>
                                                                <input type="text" class="form-control" style="border: none; border-bottom: 1px solid #adadad; padding-left: 30px;" placeholder="Products, stores or catalog search">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-right" style="padding-right: 0px">
                                                        <button type="button" class="icon-button" style="border-right: 1px solid #dcdcdc;border-left: 1px solid #dcdcdc;"><i class="fa fa-clone" aria-hidden="true"></i></button>
                                                        <button type="button" class="grey-color-button">BULK ACTIONS&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                                <hr style="margin-top: .8rem;margin-bottom: 0rem;">
                                                <div class="row mt-2">
                                                    <div class="col-md-8 mb-2 sub-header-style">
                                                        Men's Tops
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <button type="button" class="grey-text-btn">SHOW MORE &nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></button>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <table style="width: 100%;">
                                                            <tr style="height: 50px;border-top: 1px solid #eeeeee;border-bottom: 1px solid #eeeeee;background-color: #fafafa;font-size: .75rem;">
                                                                <th><input type="checkbox" id="myCheckbox" name="myCheckbox" value="checked" style="margin-top: .3rem;"></th>
                                                                <th style="width:22%" class="text-left">PRODUCT</th>
                                                                <th style="width:15%">STATUS</th>
                                                                <th class="text-center">SUB CATEGORY</th>
                                                                <th class="text-center">TAX CATEGORY</th>
                                                                <th class="text-center">COLORS</th>
                                                                <th class="text-center">SIZES</th>
                                                                <th class="text-center">CUSTOM OPTIONS</th>
                                                                <th class="text-center">WEIGHT (OZ)</th>
                                                                <th class="text-right">PRICE ($)</th>
                                                            </tr>
                                                            <tr style="min-height: 50px;border-bottom: 1px solid #eeeeee;border-top: none;">
                                                                <td><input type="checkbox" id="myCheckbox" name="myCheckbox" value="checked"></td>
                                                                <td>
                                                                    <div style="display: flex; align-items: center; justify-content: flex-start;">
                                                                        <img style="height: 5rem; width: auto;" src="https://drive.google.com/uc?id=1cG4YzuQR8PnJrwijiK0E7k_nUapqg_zj&export=media" alt="Your Image" class="img-thumbnail">
                                                                        <div style="margin-left: 10px; text-align: left;">
                                                                            <p style="margin: 0;font-size: .8rem;color:grey">Pro Game Jersey</p>
                                                                            <p style="margin: 0;font-size: .8rem;color:#b3b3b3">PRO-50</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center"><div class="col-md-8" style="padding: 5px;text-align: left;"><span class="available-lable">Available</span></div></td>
                                                                <td class="text-center"> - </td>
                                                                <td class="text-center">Clothing (20010)</td>
                                                                <td class="text-center">3 Colors</td>
                                                                <td class="text-center">10 Sizes</td>
                                                                <td class="text-center">0</td>
                                                                <td class="text-center">5</td>
                                                                <td class="text-right">34</td>
                                                            </tr>
                                                            <tr style="min-height: 50px;border-bottom: 1px solid #eeeeee;border-top: none;">
                                                                <td><input type="checkbox" id="myCheckbox" name="myCheckbox" value="checked"></td>
                                                                <td>
                                                                    <div style="display: flex; align-items: center; justify-content: flex-start;">
                                                                        <img style="height: 5rem; width: auto;" src="https://drive.google.com/uc?id=1cG4YzuQR8PnJrwijiK0E7k_nUapqg_zj&export=media" alt="Your Image" class="img-thumbnail">
                                                                        <div style="margin-left: 10px; text-align: left;">
                                                                            <p style="margin: 0;font-size: .8rem;color:grey">Pro Game Jersey</p>
                                                                            <p style="margin: 0;font-size: .8rem;color:#b3b3b3">PRO-50</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center"><div class="col-md-8" style="padding: 5px;text-align: left;"><span class="available-lable">Available</span></div></td>
                                                                <td class="text-center"> - </td>
                                                                <td class="text-center">Clothing (20010)</td>
                                                                <td class="text-center">3 Colors</td>
                                                                <td class="text-center">10 Sizes</td>
                                                                <td class="text-center">0</td>
                                                                <td class="text-center">5</td>
                                                                <td class="text-right">34</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-md-8 mb-2 sub-header-style">
                                                        Men's Tops
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <button type="button" class="grey-text-btn">SHOW MORE &nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></button>
                                                    </div>
                                                    <div class="col-md-12 mt-2">
                                                        <table style="width: 100%;">
                                                            <tr style="height: 50px;border-top: 1px solid #eeeeee;border-bottom: 1px solid #eeeeee;background-color: #fafafa;font-size: .75rem;">
                                                                <th><input type="checkbox" id="myCheckbox" name="myCheckbox" value="checked" style="margin-top: .3rem;"></th>
                                                                <th style="width:22%" class="text-left">PRODUCT</th>
                                                                <th style="width:15%">STATUS</th>
                                                                <th class="text-center">SUB CATEGORY</th>
                                                                <th class="text-center">TAX CATEGORY</th>
                                                                <th class="text-center">COLORS</th>
                                                                <th class="text-center">SIZES</th>
                                                                <th class="text-center">CUSTOM OPTIONS</th>
                                                                <th class="text-center">WEIGHT (OZ)</th>
                                                                <th class="text-right">PRICE ($)</th>
                                                            </tr>
                                                            <tr style="min-height: 50px;border-bottom: 1px solid #eeeeee;border-top: none;">
                                                                <td><input type="checkbox" id="myCheckbox" name="myCheckbox" value="checked"></td>
                                                                <td>
                                                                    <div style="display: flex; align-items: center; justify-content: flex-start;">
                                                                        <img style="height: 5rem; width: auto;" src="https://drive.google.com/uc?id=1cG4YzuQR8PnJrwijiK0E7k_nUapqg_zj&export=media" alt="Your Image" class="img-thumbnail">
                                                                        <div style="margin-left: 10px; text-align: left;">
                                                                            <p style="margin: 0;font-size: .8rem;color:grey">Pro Game Jersey</p>
                                                                            <p style="margin: 0;font-size: .8rem;color:#b3b3b3">PRO-50</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center"><div class="col-md-8" style="padding: 5px;text-align: left;"><span class="available-lable">Available</span></div></td>
                                                                <td class="text-center"> - </td>
                                                                <td class="text-center">Clothing (20010)</td>
                                                                <td class="text-center">3 Colors</td>
                                                                <td class="text-center">10 Sizes</td>
                                                                <td class="text-center">0</td>
                                                                <td class="text-center">5</td>
                                                                <td class="text-right">34</td>
                                                            </tr>
                                                            <tr style="min-height: 50px;border-bottom: 1px solid #eeeeee;border-top: none;">
                                                                <td><input type="checkbox" id="myCheckbox" name="myCheckbox" value="checked"></td>
                                                                <td>
                                                                    <div style="display: flex; align-items: center; justify-content: flex-start;">
                                                                        <img style="height: 5rem; width: auto;" src="https://drive.google.com/uc?id=1cG4YzuQR8PnJrwijiK0E7k_nUapqg_zj&export=media" alt="Your Image" class="img-thumbnail">
                                                                        <div style="margin-left: 10px; text-align: left;">
                                                                            <p style="margin: 0;font-size: .8rem;color:grey">Pro Game Jersey</p>
                                                                            <p style="margin: 0;font-size: .8rem;color:#b3b3b3">PRO-50</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center"><div class="col-md-8" style="padding: 5px;text-align: left;"><span class="available-lable">Available</span></div></td>
                                                                <td class="text-center"> - </td>
                                                                <td class="text-center">Clothing (20010)</td>
                                                                <td class="text-center">3 Colors</td>
                                                                <td class="text-center">10 Sizes</td>
                                                                <td class="text-center">0</td>
                                                                <td class="text-center">5</td>
                                                                <td class="text-right">34</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

{{-- tab bar scripts --}}

<script>
    function showTab(tabId) {
        document.querySelectorAll('.tab-pane-new').forEach(function (tab) {
            tab.classList.remove('show', 'active');
            tab.classList.add('hidden-tab');
        });

        document.querySelectorAll('.nav-link-new').forEach(function (tab) {
            tab.classList.remove('show', 'active');
        });

        var activeTab = document.getElementById(tabId);
        activeTab.classList.remove('hidden-tab');
        activeTab.classList.add('show', 'active');
        document.getElementById(tabId + '-new').classList.add('show', 'active');
    }

    $('.store-select2-dropdown').select2();
    $('.datepicker').datepicker();

    $('.task-tab').on('click', function(){
        $(this).addClass('active');
    });

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

    function openTaskTab(evt, taskTabName) {
        var i, tablinks;
        tablinks = document.getElementsByClassName("task-tab");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        evt.currentTarget.className += " active";
    }
</script>

{{-- save templates --}}

<script>
    function save_as_template(store_id){
        Swal.fire({
            title: 'Enter Template Name',
            input: 'text',
            inputPlaceholder: 'Name',
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ url('store/save_as_template') }}",
                    type: "get",
                    data: {
                        'template_name': result.value,
                        'store_id' : store_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {
                        console.log('works......');
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Template successfully saved.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });

            }
        });
    }
</script>

{{-- Products --}}

<script>
    $(document).ready(function() {
            $.ajax({
                url: '{{ route("store.get_store_products") }}',
                method: 'GET',
                data: {
                    store_id: $('#store_id').val()
                },
                success: function(response) {
                    console.log(response);
                    $('#store_product_list').empty();
                    $('#store_product_count').text(response.products.length);

                    response.categories.forEach(category_element => {
                            let categoryProducts = response.products.filter(product_element =>
                                product_element.product_categories.some(category => category.product_category_id === category_element.id)
                            );

                            let productContent = `
                                            <div class="col-md-12 mb-4">
                                                <div class="sub-header-style mb-1 mt-1" style="color: grey;font-size:.8rem">
                                                    ${category_element.product_category_name}
                                                </div>
                                                <table style="width: 100%;">
                                                    ${categoryProducts.map(product_element => {
                                                        let storeProduct = response.srore_products.find(store_product => store_product.product_id === product_element.id);

                                                        if (storeProduct) {
                                                            // if already exist to display saved details
                                                            return `
                                                                <tr class="product-list-tr">
                                                                    <td>
                                                                        <input type="checkbox" id="checkbox${product_element.id}" class="store_product_checkbox" value="${product_element.id}" checked>
                                                                    </td>
                                                                    <td class="view_store_product_detail" value="${storeProduct.id}" style="width: 5rem;">
                                                                        <img src="${product_element.mockup_img_1 ? '{{ asset('assets') }}' + product_element.mockup_img_1 : '{{ asset('assets/img/products/product defaul image.jpg') }}'}" alt="Product Image" class="img-thumbnail" onerror="this.onerror=null; this.src='{{ asset('assets/img/products/product defaul image.jpg') }}';">
                                                                    </td>
                                                                    <td class="view_saved_store_product_detail" value="${storeProduct.id}">${product_element.product_name}</td>
                                                                    <td class="view_saved_store_product_detail" value="${storeProduct.id}" style="width: 5rem;">${product_element.product_no}</td>
                                                                    <td class="view_saved_store_product_detail" value="${storeProduct.id}">
                                                                        <span class="available-label">Available</span>
                                                                    </td>
                                                                    <td class="view_saved_store_product_detail" value="${storeProduct.id}">$${product_element.default_price}</td>
                                                                </tr>
                                                            `;
                                                        } else {
                                                            return `
                                                                <tr class="product-list-tr">
                                                                    <td>
                                                                        <input type="checkbox" id="checkbox${product_element.id}" class="store_product_checkbox" value="${product_element.id}">
                                                                    </td>
                                                                    <td class="view_store_product_detail"  value="${product_element.id}" style="width: 5rem;">
                                                                        <img src="${product_element.mockup_img_1 ? '{{ asset('assets') }}' + product_element.mockup_img_1 : '{{ asset('assets/img/products/product defaul image.jpg') }}'}" alt="Product Image" class="img-thumbnail" onerror="this.onerror=null; this.src='{{ asset('assets/img/products/product defaul image.jpg') }}';">
                                                                    </td>
                                                                    <td class="view_store_product_detail" value="${product_element.id}">${product_element.product_name}</td>
                                                                    <td class="view_store_product_detail" value="${product_element.id}" style="width: 5rem;">${product_element.product_no}</td>
                                                                    <td class="view_store_product_detail" value="${product_element.id}">
                                                                        <span class="available-label">Available</span>
                                                                    </td>
                                                                    <td class="view_store_product_detail" value="${product_element.id}">$${product_element.default_price}</td>
                                                                </tr>
                                                            `;
                                                        }
                                                    }).join('')}
                                                </table>
                                            </div>`;


                            $('#store_product_list').append(productContent);
                    });
                },
                error: function(xhr) {
                    console.error('Failed to fetch products:', xhr.responseText);
                }
            });
            $('.product-update-button').on('click', function() {
                event.preventDefault();

                var formData = $('#store_product_update').serializeArray();

                var formDataArray = {};

                $.each(formData, function(i, field) {
                    formDataArray[field.name] = field.value;
                });

                $.ajax({
                    url: "{{ route('store.save_store_products') }}",
                    type: "post",
                    data: {
                        'formData' : formDataArray,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {
                        console.log('works......');
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            });
            $('.save-product-changes').on('click', function() {
                let checkedValues = $('.store_product_checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                $.ajax({
                    url: "{{ route('store.save_store_products_all') }}",
                    type: "POST",
                    data: {
                        'product_ids': checkedValues,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {
                        console.log('Request succeeded:', response);
                    },
                    error: function (xhr) {
                        console.error('Request failed:', xhr.responseText);
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            });

            function reset_product_view() {
                var $element = $('#product_display_card');
                if (!$element.hasClass('product-area-spinner')) {
                    $element.addClass('product-area-spinner');
                }
                $('#store_product_name').val('');
                $('#store_product_min_qty').val('');
                $('#store_product_max_qty').val('');
                $('#store_product_style').val('');

                // Reset all select elements to their default options
                $('#store_product_category').val('');
                $('#store_product_sub_category').val('');
                $('#store_product_manufacture').val('');
                $('#store_product_tax_category').val('');
                $('#store_product_shipping_weight').val('');

                // Uncheck all radio buttons
                $('input[name="store_product_availability"]').prop('checked', false);
                $('input[name="store_product_payment_method"]').prop('checked', false);

                // Reset the checkbox
                $('#store_product_multiple_qty').prop('checked', false);
            }

            $(document).on('click', '.view_saved_store_product_detail', function() {
                let id = $(this).attr('value');

                $.ajax({
                    url: "{{ route('store.get_store_product_by_id') }}",
                    type: "GET",
                    data: {
                        'id' : id,
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {
                        $('#store_product_id').val(response.product_id || '');
                        $('#store_product_name').val(response.product_name || '');
                        $('#store_product_min_qty').val(response.minimum_quantity || '');
                        $('#store_product_max_qty').val(response.maximum_quantity || '');
                        $('#store_product_style').val(response.style || '');

                        $('#store_product_category').val(response.category_id || '').trigger('change');
                        $('#store_product_sub_category').val(response.sub_category_id || '').trigger('change');
                        $('#store_product_manufacture').val(response.Manufacturer || '').trigger('change');
                        $('#store_product_tax_category').val(response.tax_category || '').trigger('change');
                        $('#store_product_shipping_weight').val(response.shipping_weight || '').trigger('change');

                        // Set radio buttons
                        $('input[name="store_product_availability"][value="' + (response.product_availability || '0') + '"]').prop('checked', true);
                        $('input[name="store_product_payment_method"][value="' + (response.payment_method || '0') + '"]').prop('checked', true);

                        // Set checkbox
                        $('#store_product_multiple_qty').prop('checked', response.multiple_quantity == 1);
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                        $('#product_display_card').removeClass('product-area-spinner');
                    }
                });
            });

            $(document).on('click', '.view_store_product_detail', function() {

                let id = $(this).attr('value');

                $.ajax({
                    url: "{{ route('store.get_product_by_id') }}",
                    type: "GET",
                    data: {
                        'id' : id,
                        "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {

                        $('#store_product_id').val(response.id);
                        $('#store_product_name').val(response.product_name);
                        $('#store_product_min_qty').val(0);
                        $('#store_product_max_qty').val(10);
                        $('#store_product_style').val('Test');

                        $('#store_product_category').val(1).trigger('change');
                        $('#store_product_sub_category').val(2).trigger('change');
                        $('#store_product_manufacture').val(2).trigger('change');
                        $('#store_product_tax_category').val(2).trigger('change');
                        $('#store_product_shipping_weight').val(2).trigger('change');

                        $('input[name="store_product_availability"][value="1"]').prop('checked', true);
                        $('input[name="store_product_payment_method"][value="1"]').prop('checked', true);

                        $('#store_product_multiple_qty').prop('checked', true);

                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                        $('#product_display_card').removeClass('product-area-spinner');
                    }
                });
            });
    });

</script>

@endsection
