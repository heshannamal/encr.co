@extends('layouts.app', ['activePage' => 'inventory_orders', 'titlePage' => __('Inventory Orders')])

@section('content')
<style>
    .dataTables_filter {
        display: none;
    }
    #searchbox:focus {
        outline: 0px;
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
    .select2.select2-container {
        width: 100% !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        white-space: break-spaces;
    }
    .select2-container .select2-selection--single {
        overflow: hidden;
    }
    .filter-inputs {
        align-items: center;
    }
    .radio {
        width: 16%;
        height: calc(1rem + 5px);
    }
    .ts-form-field {
        align-items: center;
    }
    .ts-form-field .form-lable {
        width: 30%;
    }
    .btn-team-store-download {
        border-radius: 1rem;
        padding: 0.1rem 0.5rem;
        font-size: 10px;
    }
    .filter {
        padding-bottom: 0rem;
        position: relative;
        width: 98%;
        left: 1%;
        top: -2rem;
    }
    .search1 {
        position: relative;
        margin-top: -0.6rem;
        margin-bottom: 1rem;
    }
    .btns {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btn-add-order {
        padding-left: 8px;
        color: #787878;
    }
    .btn-div-left {
        left: -10px;
    }
    .btn-top {
        top: -1.2rem;
    }
    .btm-bottom {
        top: -1.9rem;
    }
    .filter-btn-padding {
        padding-left: unset;
    }
    .btns-position {
        position: relative;
        right: 42px;
    }
    .btn-text-size {
        font-size: 14px;
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
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
      .btn002{
        width:440px
      }
      .btnsub001{
        position: relative;
        width: 110px;
        height: 55px;
        left:-180px;
      }
      .btnsub002{
        position: relative;
        width: 110px;
        height: 55px;
        left:-120px;
      }
      .btnsub003{
        position: relative;
        width: 110px;
        height: 55px;
        left:-60px;
      }
      .btnsub004{
        position: relative;
        width: 110px;
        height: 55px;

      }
      .wrapper001 {
        display: grid;
        grid-template-columns: auto auto auto auto;
        grid-gap: 10px;
        padding: 20px;

     }
     .divitem1{
        position: relative;
        top:-20px;
        grid-column: 1 / 2;
        width:1000px;
     }
     .divitem2{
        position: relative;
        top:-25px;
        grid-column: 1 / 2;
        width:1000px;
     }
     .divitem3{
        position: relative;
        top:-50px;
        left: -725px;
     }
     .divitem4{
        position: relative;
        left: -935px;
        width:730px;
        top:40px;
     }
     .btnfil001{
        position: relative;
        top:-30px;
        width:35px;
        height:35px;
     }
     .btnfil002{
        position: relative;

        width:35px;
        height:35px;
     }
     .pagina001{
        flex-wrap: wrap;
     }
     .btn_set{
            max-width: none;
            flex:none;
            right:0px;

        }
        .div_display{
            display:none;
        }

        .div_align{
            justify-content: center;
        }
        .btns-position{
            right: unset;
            margin: unset;
        }

    }
    @media screen and (min-width: 600px) and (max-width: 800px) {
        .div_flexdir{
            flex-wrap: wrap;
            flex-direction: column;
        }
        .div_none{
            max-width: none;
        }
        .btn_set{
            max-width: none;
            flex:none;
            right:0px;

        }
        .div_display{
            display:none;
        }
        .div_align{
            justify-content: center;
        }
        .div_btn_size{
            width:200%;
        }
        .div_nav_top{
            top:-13%;
        }
        .th_width1{
            width:155px !important;
        }
        .th_width2{
            width:212px !important;
        }
        .headder_size{
            font-size: 15px;
        }
    }

    /* new layouts */
    .card{
        border: none;
        border-radius: 0rem;
    }
    .btn-green-outlined{
        outline: unset !important;
        width: 100%;
        padding: 7%;
        color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        background-color: transparent;
    }
    .btn-green-filled{
        outline: unset !important;
        width: 100%;
        padding: 7%;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
    }
    .btn-grey-text{
        outline: unset !important;
        width: 100%;
        padding: 6%;
        color: #B3B3B3;
        border: none;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        background-color: transparent;
        border: 1px solid #b3b3b3;
    }
    .btn-grey-filled{
        outline: unset !important;
        width: 100%;
        padding: 4%;
        color: white;
        background-color: #B3B3B3;
        border: 2px solid #B3B3B3;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
    }
    .dropdown-style-grey{
        border: none;
        color: #b3b3b3;
        outline: unset;
        align-content: center;
    }
    .selectbox-div{
        border: 1px solid #B3B3B3;
        border-radius: 1rem;
        padding: 1%;
        padding-left: 6%;
    }
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .7rem;
        color: #B3B3B3;
        border: unset;
    }
    .header-style{
        background-color: #717070;
        color: white;
        font-size: 0.7rem;
        /* height: 50px; */
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
    .edit-order{
        color:#717070 !important;
        font-size: 0.7rem !important;
    }
    .order-no{
        font-size: 0.7rem !important;
    }
    .organization-id{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .sorting_1{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .factory-id{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .due-date{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .open-date{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .est-ship-date{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .user-id{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .order-total{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .order-status-id{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .inventory-status{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .contact-person{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .order-description{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .sub-total{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .sales-tax{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .shipping{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .artwork{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .processing-fee{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .team-store-file{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .created-at{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .updated-at{
        color: #717070;
        font-size: 0.7rem !important;
    }
    .color-star{
        font-size: 16px;
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
    .filtering-div{
        border: 1px solid #B3B3B3;
        border-radius: 1rem;
        padding-top: .2rem;
        padding-bottom: .2rem;
        color: #B3B3B3;
        margin: 1%;
    }
    .filter-elements{
        background-color: transparent;
        border: none;
        cursor: pointer;
        color: #B3B3B3;
        outline: unset;
        border-radius: .5rem;
    }
    .filter-field{
        align-items: center;
        border: 1px solid #B3B3B3;
        border-radius: 1rem;
    }
    .left-border{
        border-left: 1px solid #B3B3B3;
        border-radius: 0;
    }
    .form-field{
        margin-bottom: 0%;
    }
    .custom-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: white;
        border: 1px solid #ccc;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }
    .custom-select:focus {
        outline: none;
        border-color: #ccc;
    }
    .header-layout{
        margin-bottom: 1rem !important;
    }
    .table-responsive .table tbody td , .table-responsive .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
    }
    .header-style{
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
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
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
        bottom: 0.6rem !important;
    }
    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        right: .7rem !important;
    }
    .badge {
        text-transform: uppercase;
        font-size: .7rem;
        border-radius: 1rem;
        padding: 0.4rem 0.9rem;
    }

    .pointer {
        cursor: pointer;
    }

    #success-message {
            display: none;
            position: fixed;
            left: 30%;
            top: 30%;

            z-index: 9999999;

        }
        .progress {
            display: none;
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 2rem;
            width: unset !important;
        }


    @media (min-width: 769px){
        #order_cards{
            display:none !important;
        }

        .back_home_mobile {
            display:none !important;
        }
        .mobile_search {
            display:none !important;
        }
        .mobile_badge {
            display:none !important;
        }
        .mobile_filters{
            display:none;
        }

    }

    @media (max-width: 768px){
        #orders_table_wrapper{
            display:none !important;
        }
        .desktop_filter {
            display:none !important;
        }
        .home-btn-color-mobile {
            color: #475569 !important;
            font-size: 11px;
        }
        .home-btn-color-mobile:hover {
            color: #777777 !important;
        }
        .back_home_mobile {
            padding-bottom: 10px;
        }
        .searchbox_layout {
            margin-top: 0 !important;
            width: 100% !important;
            height: 40px;
            font-size: .7rem;
            color: #B3B3B3;
            border: unset;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0px 1px 2px 0px #0000000D;
            border-top: 1px solid var(--color-grey-91, #E2E8F0);
        }
        .mobile_search {
            padding-bottom: 15px;
        }
        .mobile_search{
            position: relative;
            width: 100%;
        }

        .mobile_search .search-icon{
            position: absolute;
            left: 12px;
            top: 38%;
            transform: translateY(-50%);
            color: #B3B3B3;
            font-size: 16px;
            z-index: 2;
        }

        .mobile_search input{
            width: 100%;
            padding-left: 40px; /* icon එකට space එක */
            height: 40px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        .mobile_badge_card {
            width: 90%;
        }
        .mobile_badge{
            width: 100%;
        }
        .mobile_badge table{
            width: 100%;
            table-layout: fixed; /* IMPORTANT: 4 equal columns */
        }

        .mobile_badge td{
            width: 25%;
            text-align: center;
        }

        .status-box{
            display: flex;
            justify-content: center;
            gap: 4px;

            padding: 6px 8px;
            font-size: 8px;

            white-space: nowrap;
            overflow: hidden;
        }
        .status-text{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            min-width: 0; /* IMPORTANT for flex truncate */
        }

        .status-count{
            flex-shrink: 0; /* count NEVER truncates */
            font-weight: bold;
        }
        .mobile_badge {
            padding-bottom: 15px;
        }
        .production_badge {
            color: #16A34A;
            background-color: #F0FDF4;
            border: 1px solid #BBF7D0;
        }
        .quote_badge {
            border: 1px solid #1E3A5F;
            background-color: #1E3A5F;
            color: white;
        }
        .fullfilled_badge {
            border: 1px solid #C7D2FE;
            background-color: #EEF2FF;
            color: #4338CA;
        }
        .cancelled_badge {
            border: 1px solid #FECACA;
            color: #E02020;
            background-color: #FEF2F2;
        }
        .csv_btn {
            box-shadow: 0px 1px 6px 0px #0000000D;
            border: 1px solid #E2E8F0;
            color: #475569;
            padding: 5%;
            border-radius: 8px;
        }
        .add_ts_order_btn {
            background-color: #F0FDFA;
            padding: 6%;
            box-shadow: 0px 1px 6px 0px #0000000D;
            border-radius: 8px;
        }
        .add_order_btn {
            padding: 6%;
            box-shadow: 0px 1px 6px 0px #0000000D;
            border-radius: 8px;
        }

        .filter-inputs{
            width:20% !important;
            max-width:20% !important;
            flex:0 0 20%;
            padding:0 3px;
        }

        .filter-inputs label{
            width:100% !important;
            display:block;
            margin-bottom:4px;
            font-size:11px;
        }

        .filter-inputs select,
        .filter-inputs input{
            width:100% !important;
            font-size:11px;
            height:34px !important;
        }

        #filter_table,
        #filter_save_option{
            width:34px;
            height:34px;
            border: unset;
            background-color: transparent;
        }
        .mobile_filter_row{
            display:flex;
            flex-wrap:nowrap;
            overflow-x:auto;
            gap:5px;
        }
        /* .mobile_filter_item {
            flex: 0 0 15%;
            max-width: 15%;
            padding: 0 3px;
        } */
        .filter-row-mobile{
            flex-wrap: nowrap !important;
            overflow-x: auto;
            overflow-y: hidden;
            padding-bottom: 5px;
        }

        .filter-row-mobile::-webkit-scrollbar{
            height: 4px;
        }
        .filter-row-mobile{
            display:flex;
            width:100%;
            flex-wrap:nowrap;
            overflow-x:auto;
            gap:8px;
            padding:10px;
        }

        /* each filter equal width */
        .filter-row-mobile{
            display:flex;
            width:106%;
            flex-wrap:nowrap;
            gap:6px;
            padding-left: 15px;
        }

        /* 6 items → equal distribute */
        .mobile_filter_item{
            flex: 1;
            min-width: 0;   /* IMPORTANT for shrinking */
        }

        /* label */
        .mobile_filter_item label{
            display:block;
            font-size:11px;
            margin-bottom:4px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
            color: gray;
        }

        /* inputs */
        .mobile_filter_item select,
        .mobile_filter_item input{
            width:100% !important;
            height: 20px;
            font-size: 11px;
            border: 0.5px solid gray;
            border-radius: 4px;
        }

        /* buttons same width as others */
        .mobile_filter_item.buttons{
            display:flex;
            flex-direction:column;
            justify-content:flex-end;
        }

        .mobile_filter_item.buttons .btn-group{
            display:flex;
            gap:5px;
        }

        /* .filter-field{
            min-width: 120px;
            flex-shrink: 0;
        } */
         .card-body {
            background-color: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0px 2px 8px 0px #0000000F;
         }
         .card {
            background-color: transparent;
         }
         .text-muted{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 100%;
        }
        .organization-name{
            font-size:0.9rem;
            overflow:hidden;
            text-overflow:ellipsis;
            white-space:nowrap;
            font-weight: 600;
            color: black;
        }

        .status-section{
            min-width:110px;
            text-align: right;
        }

        .status-name{
            font-size:13px;
            font-weight:600;
        }

        .payment-status{
            margin-top:3px;
        }

        .flag-icon{
            width:18px;
            text-align:center;
        }
        .edit-order {
            color: black !important;
            font-size: 0.9rem !important;
            font-weight: 600;
        }
        .partial_badge {
            background-color: #ffc1076d !important;
            color: #ffc107 !important;
            font-weight: 600;
            width: 90%;
        }
        .paid_badge {
            background-color: #6de7b295 !important;
            color: #2dce89 !important;
            font-weight: 600;
            width: 90%;
        }
        .pending_badge {
            background-color: #f5365c54 !important;
            color: #f5365c !important;
            font-weight: 600;
            width: 90%;
        }
        .production_badge_card {
            color: #16A34A;
            background-color: #F0FDF4;
            width: 90%;
        }
        .quote_badge_card {
            background-color: rgba(30, 58, 96, 0.18);
            width: 90%;
            color: #1E3A5F;
        }
        .fullfilled_badge_card {
            background-color: #EEF2FF;
            color: #4338CA;
            width: 90%;
        }
        .cancelled_badge_card {
            color: #E02020;
            background-color: #FEF2F2;
            width: 90%;
        }
        .order_name_section {
            border-bottom: 0.5px solid rgba(128, 128, 128, 0.26);
            padding-bottom: 10px;
        }
        .detail-label {
            color: #000000;
            font-size: 13px;
            font-weight: 600;
        }
        .detail-value {
            color: #999;
            font-size: 13px;
        }
        .total_green_value {
            color: #13de5e !important;
        }
        .total_bolt {
            font-weight: 700!important;
        }
        .card_total_section {
            padding: 10px 0px;
            /* background-color: rgba(241, 245, 249, 0.33); */
            /* box-shadow: 0px 4px 4px 0px #0000000D inset; */
        }
        .sales-rep-row{
            padding-bottom: 5px;
            padding-top: 15px;
        }

        .sales-rep-image{
            width:32px;
            height:32px;
            border-radius:50%;
            object-fit:cover;
            margin-right:8px;
        }

        .sales-rep-name{
            font-size:13px;
            font-weight:600;
        }

        .date-text{
            font-size:11px;
            color:#6c757d;
            line-height:1.4;
        }
        .btn-team-store-download {
            border-radius: 6px;
            padding: 0.1rem 0.6rem;
            font-size: 10px;
            background-color: #11cdef;
        }
    }

    @media (max-width: 400px){
        .organization-name{
            font-size:0.7rem;
        }
        .detail-label {
            font-size: 10px;
        }
        .order_name_section {
                gap: unset !important;
        }
     }

</style>

<div class="container-fluid mb-5">
    <div class="se-pre-con"></div>


    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    @section('back-btn-Mobile')
        <a href="{{ route('home') }}" class="home-btn-color-mobile" title="Back to home">< BACK TO HOME</a>
    @endsection

    <div class="mb-5">
        {{-- <div class="row">
            <div class="col-lg-4 row ml-auto justify-content-end" style="margin-right: .49%;">
                <div class="col-lg-5" style="position: relative;left: 5%;">
                    @can('view team store orders')
                        <button class="btn-green-outlined" style="width: 117%;" href="#" data-toggle="modal" data-target="#import_modal" title="Import Team Store Orders">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;&nbsp;ADD TS ORDER
                        </button>
                    @endcan
                </div>
                <div class="col-lg-5">

                </div>
            </div>
        </div> --}}
    </div>
    {{-- <div class="card-header col-md-12 mt-4 card filter ">
        <div class="col-md-12 ">
            <div class="row wrapper001">
                <div class="col-md-3 form-field filter-inputs divitem1">
                    <label class="form-lable width-50">Factories  </label>
                    <select class="form-control" id="factory_id" style="position: relative; right: -6%;">
                        <option value="0">View All</option>
                        @foreach($factories as $factory)
                            <option @if(request()->get('fct') == $factory->id) selected @endif value="{{$factory->id}}">{{$factory->factory_code}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-3 form-field filter-inputs divitem2">
                    <label class="form-lable lbl001">Status</label>
                    <select class="form-control" id="status_id" style="position: relative; right: -6%;">
                        <option value="0">View All</option>
                        @foreach($orderStatus as $orderState)
                            <option @if(request()->get('sts') == $orderState->id) selected @endif value="{{$orderState->id}}">{{$orderState->status_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 filter-btn-padding divitem3">
                    <button type="button" class="btn btn-sm btn-secondary btnfil001" id="filter_table" title="Filter"><i class="fas fa-solid fa-filter fa-2xs" style="color: #787878;"></i></button>
                    <button type="button" class="btn btn-sm btn-secondary btnfil002" id="filter_save_option" title="Filter & Save"><i class="fas fa-solid fa-thumbtack" style="color: #787878;"></i> </button>
                </div>

                <div class="col-md-4 text-center search1 divitem4">
                    <input  type="text" id="searchbox" placeholder="Organization / Order Search" style="width: 90%;margin-right: 20px; border-color: #787878; position: relative; right: -27px;">
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="col-md-12 btn-top">
        <div class="row div_align">
            <div class="col-md-6 div_display">
            </div>
            <div class="col-md-6 btn-div-left btn_set">
                <div class="row btns-position r-42">
                    <div class="col-md-3 btns">
                        @can('add orders')
                            <button class="btns-text btns-style btns-card "  style="outline: unset;" href="#" id="export_csv" data-href="{{ route('orders.export_csv') }}" onclick="exportTasks(event.target);"  title="Export CSV">
                                CSV Export
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3 btns">
                        @can('view team store orders')
                            <button class="btns-text btns-style btns-card " style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-md-12 mt-4 btm-bottom">
        <div class="card mb-3 desktop_filter">
            <div class="row ml-4 mt-2 mb-2 align-items-center">
                <div class="col-md-2 mr-1 form-field filter-inputs filter-field">
                    <label class="form-lable width-50" style="margin-right: 4%;color:#B3B3B3;font-weight: 700;width:50%">Factories  </label>
                    <select class="form-control dropdown-style-grey left-border" id="factory_id" style="height: calc(1.5rem + 1px) !important;width:50%">
                        <option value="0">View All</option>
                        @foreach($factories as $factory)
                            <option @if(request()->get('fct') == $factory->id) selected @endif value="{{$factory->id}}">{{$factory->factory_code}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-2 ml-1 form-field filter-inputs filter-field">
                    <label class="form-lable width-50" style="margin-right: 4%;color:#B3B3B3;font-weight: 700;width:50%">Status</label>
                    <select class="form-control dropdown-style-grey left-border" id="status_id" style="height: calc(1.5rem + 1px) !important;width:50%">
                        <option value="0">View All</option>
                        @foreach($orderStatus as $orderState)
                            <option @if(request()->get('sts') == $orderState->id) selected @endif value="{{$orderState->id}}">{{$orderState->status_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 row">
                    <div class="col-lg-1">
                        <button type="button" class="filter-elements" id="filter_table" title="Filter"><i class="fas fa-solid fa-filter fa-2xs" style="color: #787878;"></i></button>
                    </div>
                    <div class="col-lg-8">
                        <button type="button" class="filter-elements" id="filter_save_option" title="Filter & Save"><i class="fas fa-solid fa-thumbtack fa-2xs" style="color: #787878;"></i></button>
                    </div>
                </div>
                <div class="col-lg-3 ml-auto">
                    <div class="row" style="width: 101%;">
                        <div class="col-lg-1" style="border-bottom: 1px solid #B3B3B3 !important;">
                            <i class="fa fa-search" aria-hidden="true" style="font-size: 19px;color: #B3B3B3;top: 23%;position: relative;"></i>
                        </div>
                        <div class="col-lg-10 text-center" style="border-bottom: 1px solid #B3B3B3 !important;">
                            <input class="searchbox-layout"  type="text" id="searchbox" placeholder="Order Search">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="back_home_mobile">
            <strong>
                @yield('back-btn-Mobile')
            </strong>
        </div>

        <div class="mobile_search">
            <i class="fa fa-search search-icon"></i>
            <input
                class="searchbox_layout"
                type="text"
                id="searchbox-mobile"
                placeholder="Organization or Order Search">
        </div>

        <div class="mobile_badge">
            <table style="width: 100%;">
                <tr>

                    <td>
                        <span class="badge production_badge mobile_badge_card status-box">
                            <span class="status-text">Production</span>
                            <span class="status-count"></span>
                        </span>
                    </td>

                    <td>
                        <span class="badge quote_badge mobile_badge_card status-box">
                            <span class="status-text">Quote</span>
                            <span class="status-count"></span>
                        </span>
                    </td>

                    <td>
                        <span class="badge fullfilled_badge mobile_badge_card status-box">
                            <span class="status-text">Fullfilled</span>
                            <span class="status-count"></span>
                        </span>
                    </td>

                    <td>
                        <span class="badge cancelled_badge mobile_badge_card status-box">
                            <span class="status-text">Cancelled</span>
                            <span class="status-count"></span>
                        </span>
                    </td>

                </tr>
            </table>
        </div>

        <div class="mobile_badge" style="padding-bottom: unset;">
            <div class="row" style="margin: unset; padding-bottom: 15px;">
                <div class="col-6" style="padding-left: unset;">
                    @can('add orders')
                        <button class="btn-grey-text csv_btn"  style="width: 100%;" href="#" id="export_csv" data-href="{{ route('orders.export_csv') }}" onclick="exportTasks(event.target);"  title="Export CSV">
                            <i class="fa-solid fa-download"></i>&nbsp;&nbsp;CSV Export
                        </button>
                    @endcan
                </div>
                <div class="col-6">

                </div>

            </div>
            <div class="row" style="margin: unset; padding-bottom: 15px;">
                <div class="col-6" style="padding-left: unset;">
                    @can('view team store orders')
                        <button class="btn-green-outlined add_ts_order_btn" style="" href="#" data-toggle="modal" data-target="#import_modal" title="Import Team Store Orders">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;ADD TS ORDER
                        </button>
                    @endcan
                </div>
                <div class="col-6" style="padding-right: unset;">
                    @can('create order')
                        <button class="btn-green-filled add_order_btn" style="" onclick="addNewOrder()" title="Add New Orders">
                            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD ORDER
                        </button>
                    @endcan
                </div>

            </div>
        </div>

        <div class="mobile_filters row  mt-2 mb-2 align-items-center filter-row-mobile">

            <div class="mobile_filter_item">
                <label>Factories</label>
                <select class="form-control dropdown-style-grey left-border" id="factory_id_mobile">
                    <option value="0">View All</option>
                    @foreach($factories as $factory)
                        <option @if(request()->get('fct') == $factory->id) selected @endif value="{{$factory->id}}">{{$factory->factory_code}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mobile_filter_item">
                <label>Status</label>
                <select class="form-control dropdown-style-grey left-border" id="status_id_mobile">
                    <option value="0">View All</option>
                    @foreach($orderStatus as $orderState)
                        <option @if(request()->get('sts') == $orderState->id) selected @endif value="{{$orderState->id}}">{{$orderState->status_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mobile_filter_item">
                <label>Sales Rep</label>
                <select class="form-control dropdown-style-grey left-border" id="sales_rep_id_mobile">
                    <option value="all" selected>all</option>
                    @foreach($sales_rep_users as $rep)
                        <option @if(request()->get('rep') == $rep->id) selected @endif value="{{$rep->id}}">{{$rep->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mobile_filter_item">
                <label>Base On</label>
                <select class="form-control dropdown-style-grey left-border" id="date_type_id_mobile">
                    <option value="0" selected>Ex-Factory Date</option>
                    <option value="1">Due Date</option>
                </select>
            </div>

            <div class="mobile_filter_item">
                <label>Date</label>
                <input type="text"
                    id="picked_date_mobile"
                    class="summary-datepicker invoice-inputs left-border dropdown-style-grey">
            </div>


            <div class="mobile_filter_item buttons">
                {{-- <label>Actions</label> --}}

                <div class="btn-group">
                    <button id="filter_table"><i class="fa fa-filter"></i></button>
                    <button id="filter_save_option"><i class="fa fa-thumbtack"></i></button>
                </div>
            </div>

        </div>


        <div class="card">
                <div class="row mt-3 desktop_filter">
                    <div class="col-lg-3 mt-1 ml-1 row align-items-center">
                        <table style="width: 100%;margin-left: 1rem;">
                            <tr>
                                <td><span class="badge badge-success">Production  ({{$orderForCount->where('order_status_id' , 3)->count()}})</span></td>
                                <td><span class="badge badge-info">Quote  ({{$orderForCount->where('order_status_id' , 1)->count()}})</span></td>
                                <td><span class="badge badge-default">Fullfilled  ({{$orderForCount->where('order_status_id' , 4)->count()}})</span></td>
                                <td><span class="badge badge-danger">Cancelled  ({{$orderForCount->where('order_status_id' , 7)->count()}})</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-9 pr-4">
                        <table style="width: 100%" class="btn-inside-table">
                            <tr>
                                <td style="width: 60%"></td>
                                <td>
                                    @can('add orders')
                                        <button class="btn-grey-text"  style="width: 100%;" href="#" id="export_csv" data-href="{{ route('inventory_orders.export_csv') }}" onclick="exportTasks(event.target);"  title="Export CSV">
                                            CSV Export
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('view team store orders')
                                        <button class="btn-grey-filled" style="width: 100%;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                            Table Layout
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('create order')
                                        <button class="btn-green-filled" style="width: 120%;" onclick="addNewOrder()" title="Add New Orders">
                                            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD ORDER
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        </table>
                    </div>
                    {{-- <div class="col-lg-3 ml-auto row mr-1 align-items-center">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div> --}}
                </div>
                <div class="col-md-12 mt-2 desktop_filter" style="padding-right: 19px;">
                    <div class="table-responsive">
                        <table class="table align-items-center cell-border table-responsive" id="orders_table">
                            <thead class="header-style">
                                <th class="flag">Flag</th>
                                <th class="order-no" style="color: white">Order #</th>
                                <th class="organization-id" style="color: white">Organization</th>
                                <th class="no-sort factory-id" style="color: white">Factories</th>
                                <th class="due-date" style="color: white">Due date</th>
                                <th class="open-date" style="color: white">Open date</th>
                                <th class="est-ship-date" style="color: white">Ex Factory Date</th>
                                <th class="user-id" style="color: white">Sales Rep</th>
                                {{-- <th class="order-total text-right" style="color: white">Total ($)</th> --}}
                                <th class="no-sort order-status-id" style="color: white">Status</th>
                                <th class="no-sort inventory-status text-center" style="color: white">Inventory Status</th>
                                <th class="contact-person" style="color: white">Contact Person</th>
                                <th class="order-description" style="color: white">Description</th>
                                {{-- <th class="sub-total text-right" style="color: white">Sub Total ($)</th> --}}
                                {{-- <th class="sales-tax text-right" style="color: white">Sales Tax ($)</th> --}}
                                {{-- <th class="shipping text-right" style="color: white">Shipping ($)</th> --}}
                                {{-- <th class="artwork text-rightk" style="color: white">Artwork ($)</th> --}}
                                {{-- <th class="processing-fee text-right" style="color: white">Processing Fee ($)</th> --}}
                                {{-- <th class="team-store-file" style="color: white">Team Store File</th> --}}
                                <th class="created-at" style="color: white">Created At</th>
                                <th class="updated-at" style="color: white">Updated At</th>
                            </thead>

                            <tbody id="order_table_body"></tbody>
                        </table>
                    </div>
                </div>

                <div class="d-block d-md-none" id="order_cards"></div>

                <div class="col-md-12 mt-2 ">
                    <div style="float: right " >
                        {{ $orders->onEachSide(5)->withQueryString()->links('layouts.paginationlinks') }}
                    </div>
                </div>
        </div>
    </div>
</div>

{{-- Orders Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Orders Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{ $orderLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_reorder" name="column_reorder" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_flag"
                                    title="Flag"
                                    @isset($orderLayout)
                                        @if ($orderLayout['order_flag'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="order_flag">Flag</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_no"
                                    title="Order No"
                                    @isset($orderLayout)
                                        @if ($orderLayout['order_no'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="order_no">Order #</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_organization"
                                    title="Organization"
                                    @isset($orderLayout)
                                        @if ($orderLayout['order_organization'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="order_organization">Organization</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_factories"
                                    title="Factories"
                                    @isset($orderLayout)
                                        @if ($orderLayout['order_factories'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="order_factories">Factories</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_due_date"
                                    title="Due date"
                                    @isset($orderLayout)
                                        @if ($orderLayout['order_due_date'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="order_due_date">Due date</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_open_date"
                                    title="Open date"
                                    @isset($orderLayout)
                                        @if ($orderLayout['order_open_date'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="order_open_date">Open date</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_est_sippping_date"
                                    title="EST Shipping date"
                                    @isset($orderLayout)
                                        @if ($orderLayout['est_sippping_date'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="order_est_sippping_date">EST Shipping date</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_sales_rep"
                                    title="Sales Rep"
                                    @isset($orderLayout)
                                        @if ($orderLayout['order_sales_rep'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="order_sales_rep">Sales Rep</label>
                            </div>
                        </div>

                        {{-- <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_total"
                                    title="Total"
                                    @can('show order price')
                                        @isset($orderLayout)
                                            @if ($orderLayout['order_total'] == 1) checked @endif
                                        @endisset

                                        @empty($orderLayout) checked @endempty
                                    @else
                                        disabled
                                    @endcan
                                />
                                <label class="custom-control-label" for="order_total">Total ($)</label>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_status"
                                    title="Status"
                                    @isset($orderLayout)
                                        @if ($orderLayout['order_status'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="order_status">Status</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="inventory_status"
                                    title="Inventory Status"
                                    @isset($orderLayout)
                                        @if ($orderLayout['inventory_status'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="inventory_status">Inventory Status</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="contact_person"
                                    title="Contact Person"
                                    @isset($orderLayout)
                                        @if ($orderLayout['contact_person'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="contact_person">Contact Person</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="order_description"
                                    title="Description"
                                    @isset($orderLayout)
                                        @if ($orderLayout['order_description'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="order_description">Description</label>
                            </div>
                        </div>

                        {{-- <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="sub_total"
                                    title="Sub Total"
                                    @can('show order price')
                                        @isset($orderLayout)
                                            @if ($orderLayout['sub_total'] == 1) checked @endif
                                        @endisset

                                        @empty($orderLayout) checked @endempty
                                    @else
                                        disabled
                                    @endcan
                                />
                                <label class="custom-control-label" for="sub_total">Sub Total</label>
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="sales_tax"
                                    title="Sales Tax"
                                    @can('show order price')
                                        @isset($orderLayout)
                                            @if ($orderLayout['sales_tax'] == 1) checked @endif
                                        @endisset

                                        @empty($orderLayout) checked @endempty
                                    @else
                                        disabled
                                    @endcan
                                />
                                <label class="custom-control-label" for="sales_tax">Sales Tax</label>
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="shipping"
                                    title="Shipping"
                                    @can('show order price')
                                        @isset($orderLayout)
                                            @if ($orderLayout['shipping'] == 1) checked @endif
                                        @endisset

                                        @empty($orderLayout) checked @endempty
                                    @else
                                        disabled
                                    @endcan
                                />
                                <label class="custom-control-label" for="shipping">Shipping</label>
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="artwork"
                                    title="Artwork"
                                    @can('show order price')
                                        @isset($orderLayout)
                                            @if ($orderLayout['artwork'] == 1) checked @endif
                                        @endisset

                                        @empty($orderLayout) checked @endempty
                                    @else
                                        disabled
                                    @endcan
                                />
                                <label class="custom-control-label" for="artwork">Artwork</label>
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="processing_fee"
                                    title="Processing Fee"
                                    @can('show order price')
                                        @isset($orderLayout)
                                            @if ($orderLayout['processing_fee'] == 1) checked @endif
                                        @endisset

                                        @empty($orderLayout) checked @endempty
                                    @else
                                        disabled
                                    @endcan
                                />
                                <label class="custom-control-label" for="processing_fee">Processing Fee</label>
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="team_store_file"
                                    title="Team Store File"
                                    @isset($orderLayout)
                                        @if ($orderLayout['team_store_file'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="team_store_file">Team Store File</label>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="created_at"
                                    title="Created At"
                                    @isset($orderLayout)
                                        @if ($orderLayout['created'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="updated_at"
                                    title="Updated At"
                                    @isset($orderLayout)
                                        @if ($orderLayout['updated'] == 1) checked @endif
                                    @endisset
                                    @empty($orderLayout) checked @endempty
                                />
                                <label class="custom-control-label" for="updated_at">Updated At</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer"></div>
        </div>
    </div>
</div>

{{-- Re Order Modal --}}
<div class="modal fade" id="re_order_modal" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Re-Order</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <form action="{{ route('new_orders.create_re_order') }}" method="POST" id="re_order_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-field">
                                    <label class="form-lable" for="order_flag">Existing Orders</label>
                                    <select class="form-control select2-exs-order" name="exs_order_id" id="exs_order_id" required>
                                        <option value="">Select an Order</option>
                                        @foreach($orders as $order)
                                            <option value="{{$order->id}}">{{$order->order_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3" style="justify-content: space-evenly;">
                            <div class="col-md-4">
                                <input type="radio" class="radio" name="roster" id="no_roster" value="no" checked>
                                <label for="no_roster">Without Roster</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="radio" name="roster" id="with_roster" value="yes">
                                <label for="with_roster">With Roster</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 control-btns mt-3">
                                <button type="submit" class="btn btn-success btn-custom">Re-Order</button>
                                <button type="reset" class="btn btn-secondary btn-custom" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Inventory Detail Modal --}}
<div class="modal fade" id="inventory_detail_modal" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Order Details</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body" id="inventory_detail_modal_body">

            </div>
        </div>
    </div>
</div>

{{-- <div class="modal fade" id="import_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Import Team Store Order</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('team_store.create')}}" method="post" enctype="multipart/form-data" id="team_store_import_form">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="col-md-12 form-field ts-form-field">
                            <label class="form-lable">Organization: <span class="text-danger">*</span></label>
                            <select class="invoice-inputs select2-add-item" id="organization_id" name="organization_id" required>
                                <option value="">Select an Organization</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row pl-4 pt-1 pb-3">
                            <div class="custom-control custom-checkbox shipping-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    name="shipping_direct_ship_to_customers"
                                    id="shipping_direct_ship_to_customers"
                                />
                                <label class="custom-control-label" for="shipping_direct_ship_to_customers">Direct Ship to Customers&nbsp;</label>
                            </div>

                            <div class="custom-control custom-checkbox shipping-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    name="shipping_bulk_ship_to_coach"
                                    id="shipping_bulk_ship_to_coach"
                                    checked
                                />
                                <label class="custom-control-label" for="shipping_bulk_ship_to_coach">Bulk Ship to Coach&nbsp;</label>
                            </div>

                            <div class="custom-control custom-checkbox shipping-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    name="shipping_pick_up"
                                    id="shipping_pick_up"
                                />
                                <label class="custom-control-label" for="shipping_pick_up">Pick Up&nbsp;</label>
                            </div>

                            <div class="custom-control custom-checkbox shipping-checkbox">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    name="shipping_direct_pick_up"
                                    id="shipping_direct_pick_up"
                                />
                                <label class="custom-control-label" for="shipping_direct_pick_up">Direct & Pick Up&nbsp;</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-12 form-field ts-form-field">
                            <label class="form-lable">Contact Person: <span class="text-danger">*</span></label>
                            <select class="invoice-inputs select2-add-item" id="customer_id" name="customer_id" required>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="col-md-12 form-field ts-form-field">
                            <label class="form-lable">Team Store Order Report (.xlsx): <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="team_store_report" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required />
                        </div>
                    </div>

                    <div class="col-md-12 mt-2">
                        <div class="custom-control custom-checkbox" style="padding-left:210px;">
                            <input type="checkbox" class="custom-control-input" id="checkBox_excel_up_ind_name" name="checkBox_excel_up_ind_name" checked>
                            <label class="custom-control-label" for="checkBox_excel_up_ind_name">Individual Name</label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button type="reset" class="btn btn-secondary btn-custom" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-custom">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<script>

    function addNewOrder() {
      window.location.href = '{{ route('new_inventory_orders') }}'; // Replace with your desired URL or route
    }

    var searchIdx = '';

    $(document).ready(function(){
        var paginateNo = getPaginateUrlParameter('page');
        console.log(paginateNo);
        $('.select2-exs-order').select2();
        $('.select2-add-item').select2({
            dropdownParent: $("#import_modal")
        });
        $('.select2-inventory-type').select2({
            dropdownParent: $("#inventory_detail_modal")
        });

        var layout_id = $('#layout_id').val();
        if (layout_id == 0) {
            $.ajax({
                url: "{{ url('inventory_orders/column_layout') }}",
                type: "POST",
                data: { '_token':'{{csrf_token()}}' },
                success: function (data) {
                    console.log(data);
                },
            });
        }

        var ordersFilter = '';
        var orgTxt = '';
        var factoryId = 0;
        var statusId = 0;

        var ordersFilterOptions = localStorage.getItem("inventory_orders_filter_options");
        if(ordersFilterOptions != null){
            ordersFilter = JSON.parse(ordersFilterOptions);

            if (ordersFilterOptions != '') {
                factoryId = ordersFilter.factory_id;
                statusId = ordersFilter.status_id;
                if(!getUrlParameter('fct') && !getUrlParameter('sts')){
                    if(factoryId != 0 || statusId != 0){
                        setUrlParameter(factoryId, statusId);
                    }
                }
                // filterTable(ordersFilter.factory_id, ordersFilter.status_id, paginateNo);
            }

        }
        // else {
        //     filterTable(0, 0, paginateNo);
        // }
        if(getUrlParameter('fct')){
            factoryId = getUrlParameter('fct');
        }
        if(getUrlParameter('sts')){
            statusId = getUrlParameter('sts');
        }
        if(getUrlParameter('org')){
            orgTxt = getUrlParameter('org');
        }

        $('#factory_id').val(factoryId);
        $('#status_id').val(statusId);
        $('#searchbox').val(orgTxt);

        // Order Table Layout
        filterTable(factoryId, statusId, orgTxt, paginateNo);

        // change columns
        var orderTable = $('#orders_table').DataTable({
            colReorder: true,
            stateSave: true,
            "autoWidth": false,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search'
            },
            "pageLength": 50,
            "drawCallback": function(settings){
                displayTable();
            },
            "paging":   false,
            "info":     false
        });

        orderTable.search('').draw();

        searchIndex();

        // Alphabet Search
        var _alphabetSearch = '';

        $.fn.dataTable.ext.search.push( function (settings, searchData) {

            if ( ! _alphabetSearch ) {
                return true;
            }

            if ( searchData[searchIdx].charAt(0) === _alphabetSearch ) {
                return true;
            }

            return false;
        });

        var alphabet = $('<div style="display:none" class="alphabet"/>').append( '' );

        $('<span class="clear active"/>').data( 'letter', '' ).html( 'All' ).appendTo( alphabet );

        for ( var i=0 ; i<26 ; i++ ) {
            var letter = String.fromCharCode( 65 + i );

            $('<span/>').data( 'letter', letter ).html( letter ).appendTo( alphabet );
        }

        alphabet.insertBefore( orderTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            orderTable.draw(_alphabetSearch);

            displayTable();
        });

        // save column order when move
        orderTable.on('column-reorder', function (e, settings, details) {
            var column_reorder = $('#column_reorder').val();

            if (column_reorder == 0) {
                var column_order = '[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]';

            } else {
                var columnStr = localStorage.getItem("DataTables_orders_table_/orders");
                var columnObj = JSON.parse(columnStr);
                var colReorder = new $.fn.dataTable.ColReorder( orderTable );
                var curr = colReorder.fnOrder();
                var column_order = JSON.stringify(curr);
            }

            console.log(column_order);

            var interface_name = 'Inventory Order';
            var interface_id = 17;

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(data) {
                    console.log(data);
                    searchIndex();
                    $('#column_reorder').val(column_order);
                },
                complete: function () {
                    displayTable();
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        $('.color-picker').on('change', function(){
            var orderId = $(this).data('value');
            var flagColor = $('.color-picker.'+orderId).val();

            //$('.color-picker-wrapper.'+orderId).css('background-color', flagColor);
            var colorValue = flagColor.replace('#', '')

            changeOrderFlag(orderId, colorValue);
        });

        function changeOrderFlag(orderId, colorValue){
            $.ajax({
                url:"{{ url('orders/change_flag') }}/"+orderId+"/"+colorValue,
                method:"GET",
                dataType:"json",
                beforeSend:function(){
                    $(".se-pre-con").fadeIn();
                },
                success:function(data){
                    $(".se-pre-con").fadeOut();
                    if(data == 'success'){
                        Swal.fire({
                            title: "Done!",
                            text: "Order Flag Changed  Successfully!",
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: data.errorInfo[2],
                            type: "error",
                        });
                    }
                }
            });
        }

        // var ordersTable = $('#orders_table').DataTable();
        $("#searchbox").on('focusout', function() {
            setFilterValues();
            // orderTable.search(this.value).draw();
            // displayTable();
        });

        $("#searchbox").on('keypress', function(event) {
		    if (event.keyCode == 13) {
                setFilterValues();
            }
        });

        // Edit Order
        $("body").on("click", ".edit-order", function(){
            $(".se-pre-con").fadeIn('slow');
            var orderId = $(this).data('value');
            window.location.replace('order_details/edit/'+orderId+'/order?active_tab=order');
        });

        // View Order
        $("body").on("click", ".view-order", function(){
            var orderId = $(this).val();
            window.location.replace('orders/info/'+orderId);
        });

        // View Organization
        $("body").on("click", ".view-organization", function(){
            $(".se-pre-con").fadeIn('slow');
            var organizationId = $(this).data('value');
            window.location.replace('organizations/info/'+organizationId);
        });

        // View Organization
        $("body").on("click", "#re_order_btn", function(){
            console.log('working');
            $('#re_order_modal').modal('show');
        });

        $('#re_order_form').on('submit', function(e){
            e.preventDefault();
            $(".se-pre-con").fadeIn('slow');
            this.submit();
        });

        // Filter Table
        $("body").on('click', '#filter_table', function(){
            setFilterValues();
        });

        $('#filter_save_option').on('click', function(){
            var factoryId = $('#factory_id').val();
            var statusId = $('#status_id').val();
            var filterObj = {};
                filterObj['factory_id'] = factoryId;
                filterObj['status_id'] = statusId;

            localStorage.setItem('inventory_orders_filter_options', JSON.stringify(filterObj));

            setUrlParameter(factoryId, statusId);
            // filterTable(factoryId, statusId, 1);
        });

        // View Inventory details
        $("body").on('click', '.add-inventory', function(){
            // var orderId = $(this).val();
            var orderId = $(this).data('value');

            $.ajax({
                url:"{{ url('inventory_orders/get_order_with_inventory_detail') }}/"+orderId,
                method:'GET',
                success: function (data){
                    $('#inventory_detail_modal_body').html(data);
                    $('#inventory_detail_modal').modal('show');
                }
            });
        });

        // View Inventory details
        $("body").on('click', '.cancel-add-inventory', function(){
            var orderId = $(this).val();

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to cancel adding this order to inventory?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    $(".se-pre-con").fadeIn();
                    window.location.href = "{{ url('inventory_orders/cancel_adding_order_to_inventory') }}/"+orderId;
                }
            });
        });

        $('body').on('submit', '#inventory_detail_form', function(){
            $(".se-pre-con").fadeIn('fast');
        });

        // Sort by Alphabet
        $("body").on('click', '.sort-by-alphabet', function(){
            var letterId = $(this).val();

            $.ajax({
                url:"{{ url('inventory_orders/sort_by_alphabet') }}/"+letterId,
                method:'GET',
                dataType:'json',
                success: function (data){
                    console.log(data);
                    makeTable(data);
                }
            });
        });

        function filterTable(factoryId, statusId, orgTxt, paginateNo){
            $.ajax({
                url:"{{ url('inventory_orders/filter_table') }}",
                method:'POST',
                data:{'factory_id':factoryId, 'status_id':statusId, 'org_txt':orgTxt, 'paginate_no':paginateNo, '_token':'{{csrf_token()}}' },
                dataType:'json',
                beforeSend:function(){
                    $(".se-pre-con").fadeIn('fast');
                },
                success: function (data){
                    makeTable(data[0]);
                    if(data[1]=="factory"){
                        $('#factory_id').val(data[2]);
                        $('#status_id').val(3);
                    }

                    let counts = data[3] || {
                        production: 0,
                        quote: 0,
                        fulfilled: 0,
                        cancelled: 0
                    };

                    updateStatusCounts(counts);

                },
                complete:function(){
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        function makeTable(data){
            orderTable.clear().draw();

            let mobileCardData = [];

            var columnStr = localStorage.getItem("DataTables_orders_table_/orders");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( orderTable );
            var curr = colReorder.fnOrder();

            var classArr = [];
            classArr.push(
                'flag', 'order-no', 'organization-id', 'factory-id', 'due-date', 'open-date', 'est-ship-date', 'user-id', 'order-status-id', 'inventory-status text-center',
                'contact-person', 'order-description', 'created-at', 'updated-at'
            );

            for (var i = 0; i < data.length; i++) { console.log(data[i]);
            if (data[i].active == 1) {

                mobileCardData.push(data[i]);

                var value = data[i].order_items;
                var factory = [];
                var est_shipping_date = 'N/A';
                for(var j = 0; j < value.length; j++) {
                    if(value[j].factory_details != null) {
                        factory.push(' '+value[j].factory_details.factory_code);
                    } else {

                    }

                    // if (value[j].est_shipping_delivery_date) {
                    //     est_shipping_date = value[j].est_shipping_delivery_date;
                    // }
                }

                if (data[i].ex_factory_date) {
                    est_shipping_date = data[i].ex_factory_date;
                }

                var factory_codes = [];
                $.each(factory, function(i, el){
                    if($.inArray(el, factory_codes) === -1) factory_codes.push(el);
                });

                // Format created at date
                var created_at = new Date(data[i].created_at);
                var created_date = created_at.getDate();
                var created_month = created_at.getMonth()+1;
                var created_year = created_at.getFullYear();

                // Format updated at date
                var updated_at = new Date(data[i].updated_at);
                var updated_date = updated_at.getDate();
                var updated_month = updated_at.getMonth()+1;
                var updated_year = updated_at.getFullYear();

                // var view_organization = '@if(Gate::check("view organization"))'+
                //                         '<a href="#" class="view-organization" data-value="'+data[i].organization_details.id+'">'+data[i].organization_details.organization_name+'</a>'+
                //                         '@else'+
                //                         data[i].organization_details.organization_name+
                //                         '@endif';
                var view_organization = data[i].organization_details.organization_name;
                if (view_organization) {
                    var view_organization = data[i].organization_details.organization_name;
                } else {
                    var view_organization = 'Test';
                }

                var inventory_details = data[i].inventory_details;
                console.log(inventory_details);

                var inventory_status = '';
                if (data[i].order_status_id == 4) {
                    // inventory_status = '<button type="button" class="btn btn-sm btn-info add-inventory" value="'+data[i].id+'">Add To Inventory</button>';
                    inventory_status = '<span class="badge badge-info add-inventory pointer" data-value="'+data[i].id+'"><i class="fas fa-plus"></i> Add To Inventory</button>';
                    if (inventory_details) {
                        if (inventory_details.status == 1) {
                            // inventory_status = '<button type="button" class="btn btn-sm btn-success add-inventory" value="'+data[i].id+'">Sent</button>';
                            inventory_status = '<span class="badge badge-success add-inventory pointer" data-value="'+data[i].id+'">Sent To Inventory</button>';
                        } else if (inventory_details.status == 2) {
                            // inventory_status = '<button type="button" class="btn btn-sm btn-default add-inventory" value="'+data[i].id+'">Added</button>';
                            inventory_status = '<span class="badge badge-light add-inventory pointer" data-value="'+data[i].id+'">In Inventory</button>';
                        } else if (inventory_details.status == 3) {
                            // inventory_status = '<button type="button" class="btn btn-sm btn-danger add-inventory" value="'+data[i].id+'">Rejected</button>';
                            inventory_status = '<span class="badge badge-danger add-inventory pointer" data-value="'+data[i].id+'">Rejected By Inventory</button>';
                        }
                    }
                }


                var color_picker ='<div class="color-picker-wrapper '+data[i].id+'" style="background-color: transparent;border: none;">'+
                                        '<input type="color" value="'+data[i].flag+'" class="color-picker '+data[i].id+'" list="presetColors" data-value="'+data[i].id+'" style="position: relative;right: -10px;top: 2px;z-index: 1;">'+
                                        '<datalist id="presetColors">'+
                                            '<option>#d7dadb</option>'+
                                            '<option>#fb5779</option>'+
                                            '<option>#ff7510</option>'+
                                            '<option>#ffa800</option>'+
                                            '<option>#ffd101</option>'+
                                            '<option>#ace610</option>'+
                                            '<option>#19db7d</option>'+
                                            '<option>#00D4CB</option>'+
                                            '<option>#48dafd</option>'+
                                            '<option>#0064fb</option>'+
                                            '<option>#6458f9</option>'+
                                            '<option>#A147E4</option>'+
                                            '<option>#ff78ff</option>'+
                                            '<option>#ff4ba6</option>'+
                                            '<option>#ff93af</option>'+
                                            '<option>#5a7896</option>'+
                                        '</datalist>'+
                                    '</div>'+
                                    '<i class="fa fa-star" style="color:'+data[i].flag+';font-size:16px;position: relative;right: 7px;" id="picker-star'+data[i].id+'" aria-hidden="true"></i>';

                var order_no = '<a href="#" class="edit-order" data-value="'+data[i].id+'">'+data[i].order_no+'</a>';

                if (data[i].order_type == 1) {
                    if (data[i].team_store_details == '' || data[i].team_store_details == null) {
                        var team_store_file = '';

                    } else {
                        var team_store_file = '<button type="button" class="btn btn-sm btn-info btn-team-store-download" value="'+data[i].team_store_details.id+'"><i class="fas fa-download"></i> download</button>';
                    }

                } else {
                    var team_store_file = '';
                }

                var column_data_arr = [];
                column_data_arr.push(
                    color_picker,
                    order_no,
                    view_organization,
                    factory_codes,
                    data[i].due_date,
                    data[i].open_date,
                    est_shipping_date,
                    data[i].user_details.name,
                    // parseFloat(data[i].order_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"),
                    data[i].status_details.status_name,
                    inventory_status,
                    data[i].contact_details.first_name +' '+ data[i].contact_details.last_name,
                    data[i].order_description,
                    // parseFloat(data[i].sub_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"),
                    // parseFloat(data[i].sales_tax).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"),
                    // parseFloat(data[i].shipping).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"),
                    // parseFloat(data[i].artwork).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"),
                    // parseFloat(data[i].processing_fee).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"),
                    // team_store_file,
                    ('0' + created_month).slice(-2)+'-'+('0' + created_date).slice(-2)+'-'+created_year,
                    ('0' + updated_month).slice(-2)+'-'+('0' + updated_date).slice(-2)+'-'+updated_year
                );

                var row = orderTable.row.add([
                    column_data_arr[curr[0]],
                    column_data_arr[curr[1]],
                    column_data_arr[curr[2]],
                    column_data_arr[curr[3]],
                    column_data_arr[curr[4]],
                    column_data_arr[curr[5]],
                    column_data_arr[curr[6]],
                    column_data_arr[curr[7]],
                    column_data_arr[curr[8]],
                    column_data_arr[curr[9]],
                    column_data_arr[curr[10]],
                    column_data_arr[curr[11]],
                    column_data_arr[curr[12]],
                    column_data_arr[curr[13]],
                    // column_data_arr[curr[14]],
                    // column_data_arr[curr[15]],
                    // column_data_arr[curr[16]],
                    // column_data_arr[curr[17]],
                    // column_data_arr[curr[18]],
                    // column_data_arr[curr[19]],
                ]);

                orderTable.row(row).column(0).nodes().to$().addClass(classArr[curr[0]]);
                orderTable.row(row).column(1).nodes().to$().addClass(classArr[curr[1]]);
                orderTable.row(row).column(2).nodes().to$().addClass(classArr[curr[2]]);
                orderTable.row(row).column(3).nodes().to$().addClass(classArr[curr[3]]);
                orderTable.row(row).column(4).nodes().to$().addClass(classArr[curr[4]]);
                orderTable.row(row).column(5).nodes().to$().addClass(classArr[curr[5]]);
                orderTable.row(row).column(6).nodes().to$().addClass(classArr[curr[6]]);
                orderTable.row(row).column(7).nodes().to$().addClass(classArr[curr[7]]);
                orderTable.row(row).column(8).nodes().to$().addClass(classArr[curr[8]]);
                orderTable.row(row).column(9).nodes().to$().addClass(classArr[curr[9]]);
                orderTable.row(row).column(10).nodes().to$().addClass(classArr[curr[10]]);
                orderTable.row(row).column(11).nodes().to$().addClass(classArr[curr[11]]);
                orderTable.row(row).column(12).nodes().to$().addClass(classArr[curr[12]]);
                orderTable.row(row).column(13).nodes().to$().addClass(classArr[curr[13]]);
                // orderTable.row(row).column(14).nodes().to$().addClass(classArr[curr[14]]);
                // orderTable.row(row).column(15).nodes().to$().addClass(classArr[curr[15]]);
                // orderTable.row(row).column(16).nodes().to$().addClass(classArr[curr[16]]);
                // orderTable.row(row).column(17).nodes().to$().addClass(classArr[curr[17]]);
                // orderTable.row(row).column(18).nodes().to$().addClass(classArr[curr[18]]);
                // orderTable.row(row).column(19).nodes().to$().addClass(classArr[curr[19]]);
                orderTable.row(row).draw();
            }}

            // Order Table Layout

            $('.color-picker').on('change', function(){
                var orderId = $(this).data('value');
                var flagColor = $('.color-picker.'+orderId).val();
                var flagStar = $('#picker-star'+orderId);

                //$('.color-picker-wrapper.'+orderId).css('background-color', flagColor);
                var colorValue = flagColor.replace('#', '');

                flagStar.css('color', flagColor);

                changeOrderFlag(orderId, colorValue);
                // window.location.replace('orders/change_flag/'+orderId+'/'+colorValue);
            });


            displayTable();
            renderMobileCards(mobileCardData);
        }
    });

    function updateStatusCounts(counts)
    {
        $('.production_badge .status-count').text('(' + (counts.production ?? 0) + ')');
        $('.quote_badge .status-count').text('(' + (counts.quote ?? 0) + ')');
        $('.fullfilled_badge .status-count').text('(' + (counts.fulfilled ?? 0) + ')');
        $('.cancelled_badge .status-count').text('(' + (counts.cancelled ?? 0) + ')');
    }

    function renderMobileCards(data){
        let html = '';

        data.forEach(item => {

            let payment = item.payment_status?.payment_status;

            let paymentStatus = '';
            if(payment == 0){
                paymentStatus = `<span class="badge pending_badge">Pending</span>`;
            } else if(payment == 1){
                paymentStatus = `<span class="badge partial_badge">Partial</span>`;
            } else {
                paymentStatus = `<span class="badge paid_badge">Paid</span>`;
            }

            let orderStatus2 = item.status_details.status_name;
            let orderStatusCard ='';

            if(orderStatus2 == "Production"){
                orderStatusCard = `<span class="badge production_badge_card">Production</span>`;
            } else if(orderStatus2 == "Quote"){
                orderStatusCard = `<span class="badge quote_badge_card">Quote</span>`;
            } else if(orderStatus2 == "Fulfilled"){
                orderStatusCard = `<span class="badge fullfilled_badge_card">Fulfilled</span>`;
            }
             else {
                orderStatusCard = `<span class="badge cancelled_badge_card">Cancell</span>`;
            }

            let factory = [];
            let est_shipping_date = 'N/A';
            let ordertotalQty = 0;

            if(item.order_items){
                item.order_items.forEach(orderItem => {

                    if(orderItem.factory_details){
                        factory.push(orderItem.factory_details.factory_code);
                    }
                    ordertotalQty += parseFloat(orderItem.qty) || 0;

                });
            }

            if(item.ex_factory_date){
                est_shipping_date = item.ex_factory_date;
            }

            let factory_codes = [...new Set(factory)].join(', ');

            let contactPerson = '';

            if(item.contact_details){
                contactPerson =
                    (item.contact_details.first_name ?? '') + ' ' +
                    (item.contact_details.last_name ?? '');
            }

            let team_store_file = '';

            if (
                item.order_type == 1 &&
                item.team_store_details &&
                item.team_store_details.id
            ){
                team_store_file = `
                    <button
                        type="button"
                        class="btn btn-sm btn-info btn-team-store-download"
                        value="${item.team_store_details.id}">
                        <i class="fas fa-download"></i> Download
                    </button>
                `;
            }

            let createdDate = '';
            let updatedDate = '';

            if(item.created_at){
                createdDate = new Date(item.created_at).toLocaleDateString('en-US');
            }

            if(item.updated_at){
                updatedDate = new Date(item.updated_at).toLocaleDateString('en-US');
            }

            let organizationName = item.organization_details?.organization_name ?? '';

            if(organizationName.length > 20){
                organizationName = organizationName.substring(0, 20) + '...';
            }

            let salesRep = item.user_details?.name ?? '';

            let color_picker ='<div class="color-picker-wrapper '+item.id+'" style="background-color: transparent;border: none;">'+
                                        '<input type="color" value="'+item.flag+'" class="color-picker '+item.id+'" list="presetColors" data-value="'+item.id+'" style="position: relative;right: -10px;top: 2px;z-index: 1;">'+
                                        '<datalist id="presetColors">'+
                                            '<option>#d7dadb</option>'+
                                            '<option>#fb5779</option>'+
                                            '<option>#ff7510</option>'+
                                            '<option>#ffa800</option>'+
                                            '<option>#ffd101</option>'+
                                            '<option>#ace610</option>'+
                                            '<option>#19db7d</option>'+
                                            '<option>#00D4CB</option>'+
                                            '<option>#48dafd</option>'+
                                            '<option>#0064fb</option>'+
                                            '<option>#6458f9</option>'+
                                            '<option>#A147E4</option>'+
                                            '<option>#ff78ff</option>'+
                                            '<option>#ff4ba6</option>'+
                                            '<option>#ff93af</option>'+
                                            '<option>#5a7896</option>'+
                                        '</datalist>'+
                                    '</div>'+
                                    '<i class="fa fa-star" style="color:'+item.flag+';font-size:16px;position: relative;right: 7px;" id="picker-star'+item.id+'" aria-hidden="true"></i>';


            html += `
            <div class="card mb-4 order-card" data-id="${item.id}">
                <div class="card-body">

                    <div class="d-flex align-items-center w-100 order_name_section" style="gap: 13px;">

                        <!-- Flag -->
                        <div class="pe-2">
                            ${color_picker}
                        </div>

                        <!-- Order No + Organization -->
                        <div class="flex-grow-1">
                            <div class="fw-bold">
                                <a href="#" class="edit-order" data-value="${item.id}">
                                    #${item.order_no}
                                </a>
                            </div>

                            <div class="organization-name">
                                <a href="{{url('organizations/info/${item.organization_details.id}')}}"
                                style="color: black; text-decoration: none;"
                                target="_blank">
                                    ${organizationName}
                                </a>
                            </div>
                        </div>

                        <!-- Status + Payment -->
                        <div class="text-end status-section">
                            <div class="status-name">
                                ${orderStatusCard}
                            </div>

                            <div class="payment-status">
                                ${paymentStatus}
                            </div>
                        </div>

                    </div>

                    <div class="d-flex align-items-center order_name_section" style="">

                        <div class="mobile-order-details w-100" style="padding-top: 15px;">
                            <div class="row">

                                <div class="col-6 mb-2">
                                    <div class="detail-label">FACTORY</div>
                                    <div class="detail-value">${factory_codes || '-'}</div>
                                </div>

                                <div class="col-6 mb-2">
                                    <div class="detail-label">IN HAND DUE</div>
                                    <div class="detail-value">${item.due_date}</div>
                                </div>

                                <div class="col-6 mb-2">
                                    <div class="detail-label">SENT TO PRODUCTION</div>
                                    <div class="detail-value">${item.production_date ?? '-'}</div>
                                </div>

                                <div class="col-6 mb-2">
                                    <div class="detail-label">EX FACTORY</div>
                                    <div class="detail-value">${est_shipping_date}</div>
                                </div>

                                <div class="col-6 mb-2">
                                    <div class="detail-label">FULL ITEM QTY</div>
                                    <div class="detail-value">${ordertotalQty}</div>
                                </div>

                                <div class="col-6 mb-2">
                                    <div class="detail-label">SUB TOTAL</div>
                                    <div class="detail-value">$${parseFloat(item.sub_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")}</div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="d-flex align-items-center order_name_section" style="padding-bottom: unset;">

                        <div class="mobile-order-details w-100" style="padding-top: 15px;">
                            <div class="row" style="padding-bottom: 10px;">

                                <div class="col-4 mb-2" style="text-align: center;">
                                    <div class="detail-label"> ARTWORK</div>
                                    <div class="detail-value">$${parseFloat(item.artwork).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")}</div>
                                </div>


                                <div class="col-4 mb-2" style="text-align: center;">
                                    <div class="detail-label">SALES TAX</div>
                                    <div class="detail-value">$${parseFloat(item.sales_tax).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")}</div>
                                </div>

                                <div class="col-4 mb-2" style="text-align: center;">
                                    <div class="detail-label">SHIPPING</div>
                                    <div class="detail-value">$${parseFloat(item.shipping).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")}</div>
                                </div>

                            </div>
                            <div class="row card_total_section">

                                <div class="col-4 mb-2" style="text-align: center;">
                                    <div class="detail-label">TOTAL</div>
                                    <div class="detail-value total_green_value total_bolt">$${Number(item.order_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")}</div>
                                </div>

                                <div class="col-4 mb-2" style="text-align: center;">
                                    <div class="detail-label"> PAID $</div>
                                    <div class="detail-value total_green_value">$${parseFloat(item.payment_status.total_payment).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")}</div>
                                </div>

                                <div class="col-4 mb-2" style="text-align: center;">
                                    <div class="detail-label"> PROCESSING</div>
                                    <div class="detail-value total_green_value">$${parseFloat(item.processing_fee).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")}</div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="d-flex justify-content-between align-items-center sales-rep-row">

                        <!-- Left Side -->
                        <div class="d-flex align-items-center">

                            <img
                                src="${item.user_details?.profile_pic_url ?? '/images/default-user.png'}"
                                class="sales-rep-image"
                                alt="Profile">

                            <span class="sales-rep-name">
                                ${salesRep}
                            </span>

                        </div>

                        <!-- Right Side -->
                        <div class="text-end">

                            <div class="date-text">
                                Created: ${createdDate}
                            </div>

                            <div class="date-text">
                                Updated: ${updatedDate}
                            </div>

                        </div>

                    </div>


                </div>
            </div>`;
        });

        document.getElementById('order_cards').innerHTML = html;


        $(document).off('change.mobileColorPicker')
        .on('change.mobileColorPicker', '.color-picker', function(){

            var orderId = $(this).data('value');
            var flagColor = $(this).val();
            var flagStar = $('#picker-star' + orderId);

            var colorValue = flagColor.replace('#', '');

            flagStar.css('color', flagColor);

            changeOrderFlag(orderId, colorValue);
        });

    }

    // Full card clickable
    $(document).on('click', '.order-card', function () {

        let orderId = $(this).data('id');

        // openOrderEditModal(id);
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });

    // Prevent card click when changing color
    $(document).on('click', '.color-picker', function(e){
        e.stopPropagation();
    });

    $(document).on('click', '.color-picker-wrapper', function(e){
        e.stopPropagation();
    });


    // $('body').on('click', '.page-item:not(.active):not(.disabled)', function(){
    //     $('.page-item').removeClass('active');
    //     $(this).addClass('active');
    //     console.log('clicked');
    // });

    $('body').on('click', '#order_flag', function(){
        if($(this).is(':checked')) {
            $('.flag').css('display', 'table-cell');
            var attribute_name = 'order_flag';
            showColumn(attribute_name);

        } else {
            $('.flag').css('display', 'none');
            var attribute_name = 'order_flag';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#order_no', function(){
        if($(this).is(':checked')) {
            $('.order-no').css('display', 'table-cell');
            var attribute_name = 'order_no';
            showColumn(attribute_name);

        } else {
            $('.order-no').css('display', 'none');
            var attribute_name = 'order_no';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#order_organization', function(){
        if($(this).is(':checked')) {
            $('.organization-id').css('display', 'table-cell');
            var attribute_name = 'order_organization';
            showColumn(attribute_name);

        } else {
            $('.organization-id').css('display', 'none');
            var attribute_name = 'order_organization';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#order_factories', function(){
        if($(this).is(':checked')) {
            $('.factory-id').css('display', 'table-cell');
            var attribute_name = 'order_factories';
            showColumn(attribute_name);

        } else {
            $('.factory-id').css('display', 'none');
            var attribute_name = 'order_factories';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#order_due_date', function(){
        if($(this).is(':checked')) {
            $('.due-date').css('display', 'table-cell');
            var attribute_name = 'order_due_date';
            showColumn(attribute_name);

        } else {
            $('.due-date').css('display', 'none');
            var attribute_name = 'order_due_date';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#order_open_date', function(){
        if($(this).is(':checked')) {
            $('.open-date').css('display', 'table-cell');
            var attribute_name = 'order_open_date';
            showColumn(attribute_name);

        } else {
            $('.open-date').css('display', 'none');
            var attribute_name = 'order_open_date';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#order_est_sippping_date', function(){
        if($(this).is(':checked')) {
            $('.est-ship-date').css('display', 'table-cell');
            var attribute_name = 'order_est_sippping_date';
            showColumn(attribute_name);

        } else {
            $('.est-ship-date').css('display', 'none');
            var attribute_name = 'order_est_sippping_date';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#order_sales_rep', function(){
        if($(this).is(':checked')) {
            $('.user-id').css('display', 'table-cell');
            var attribute_name = 'order_sales_rep';
            showColumn(attribute_name);

        } else {
            $('.user-id').css('display', 'none');
            var attribute_name = 'order_sales_rep';
            hideColumn(attribute_name);
        }
    });

    // $('body').on('click', '#order_total', function(){
    //     if($(this).is(':checked')) {
    //         $('.order-total').css('display', 'table-cell');
    //         var attribute_name = 'order_total';
    //         showColumn(attribute_name);

    //     } else {
    //         $('.order-total').css('display', 'none');
    //         var attribute_name = 'order_total';
    //         hideColumn(attribute_name);
    //     }
    // });

    $('body').on('click', '#order_status', function(){
        if($(this).is(':checked')) {
            $('.order-status-id').css('display', 'table-cell');
            var attribute_name = 'order_status';
            showColumn(attribute_name);

        } else {
            $('.order-status-id').css('display', 'none');
            var attribute_name = 'order_status';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#inventory_status', function(){
        if($(this).is(':checked')) {
            $('.inventory-status').css('display', 'table-cell');
            var attribute_name = 'inventory_status';
            showColumn(attribute_name);

        } else {
            $('.inventory-status').css('display', 'none');
            var attribute_name = 'inventory_status';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#contact_person', function(){
        if($(this).is(':checked')) {
            $('.contact-person').css('display', 'table-cell');
            var attribute_name = 'contact_person';
            showColumn(attribute_name);

        } else {
            $('.contact-person').css('display', 'none');
            var attribute_name = 'contact_person';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#order_description', function(){
        if($(this).is(':checked')) {
            $('.order-description').css('display', 'table-cell');
            var attribute_name = 'order_description';
            showColumn(attribute_name);

        } else {
            $('.order-description').css('display', 'none');
            var attribute_name = 'order_description';
            hideColumn(attribute_name);
        }
    });

    // $('body').on('click', '#sub_total', function(){
    //     if($(this).is(':checked')) {
    //         $('.sub-total').css('display', 'table-cell');
    //         var attribute_name = 'sub_total';
    //         showColumn(attribute_name);

    //     } else {
    //         $('.sub-total').css('display', 'none');
    //         var attribute_name = 'sub_total';
    //         hideColumn(attribute_name);
    //     }
    // });

    // $('body').on('click', '#sales_tax', function(){
    //     if($(this).is(':checked')) {
    //         $('.sales-tax').css('display', 'table-cell');
    //         var attribute_name = 'sales_tax';
    //         showColumn(attribute_name);

    //     } else {
    //         $('.sales-tax').css('display', 'none');
    //         var attribute_name = 'sales_tax';
    //         hideColumn(attribute_name);
    //     }
    // });

    // $('body').on('click', '#shipping', function(){
    //     if($(this).is(':checked')) {
    //         $('.shipping').css('display', 'table-cell');
    //         var attribute_name = 'shipping';
    //         showColumn(attribute_name);

    //     } else {
    //         $('.shipping').css('display', 'none');
    //         var attribute_name = 'shipping';
    //         hideColumn(attribute_name);
    //     }
    // });

    // $('body').on('click', '#artwork', function(){
    //     if($(this).is(':checked')) {
    //         $('.artwork').css('display', 'table-cell');
    //         var attribute_name = 'artwork';
    //         showColumn(attribute_name);

    //     } else {
    //         $('.artwork').css('display', 'none');
    //         var attribute_name = 'artwork';
    //         hideColumn(attribute_name);
    //     }
    // });

    // $('body').on('click', '#processing_fee', function(){
    //     if($(this).is(':checked')) {
    //         $('.processing-fee').css('display', 'table-cell');
    //         var attribute_name = 'processing_fee';
    //         showColumn(attribute_name);

    //     } else {
    //         $('.processing-fee').css('display', 'none');
    //         var attribute_name = 'processing_fee';
    //         hideColumn(attribute_name);
    //     }
    // });

    // $('body').on('click', '#team_store_file', function(){
    //     if($(this).is(':checked')) {
    //         $('.team-store-file').css('display', 'table-cell');
    //         var attribute_name = 'team_store_file';
    //         showColumn(attribute_name);

    //     } else {
    //         $('.team-store-file').css('display', 'none');
    //         var attribute_name = 'team_store_file';
    //         hideColumn(attribute_name);
    //     }
    // });

    $('body').on('click', '#created_at', function(){
        if($(this).is(':checked')) {
            $('.created-at').css('display', 'table-cell');
            var attribute_name = 'created_at';
            showColumn(attribute_name);

        } else {
            $('.created-at').css('display', 'none');
            var attribute_name = 'created_at';
            hideColumn(attribute_name);
        }
    });

    $('body').on('click', '#updated_at', function(){
        if($(this).is(':checked')) {
            $('.updated-at').css('display', 'table-cell');
            var attribute_name = 'updated_at';
            showColumn(attribute_name);

        } else {
            $('.updated-at').css('display', 'none');
            var attribute_name = 'updated_at';
            hideColumn(attribute_name);
        }
    });

    function showColumn(attribute_name) {
        $.ajax({
            url: "{{ url('inventory_orders/show_column') }}",
            type: "POST",
            data: {
                'attribute_name':attribute_name, '_token':'{{csrf_token()}}'
            },
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                console.log(data);
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function hideColumn(attribute_name) {
        $.ajax({
            url: "{{ url('inventory_orders/hide_column') }}",
            type: "POST",
            data: {
                'attribute_name':attribute_name, '_token':'{{csrf_token()}}'
            },
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                console.log(data);
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function displayTable() {
        if($('#order_flag').is(':checked')) {
            $('.flag').css('display', 'table-cell');
        } else {
            $('.flag').css('display', 'none');
        }

        if($('#order_no').is(':checked')) {
            $('.order-no').css('display', 'table-cell');
        } else {
            $('.order-no').css('display', 'none');
        }

        if($('#order_organization').is(':checked')) {
            $('.organization-id').css('display', 'table-cell');
        } else {
            $('.organization-id').css('display', 'none');
        }

        if($('#order_factories').is(':checked')) {
            $('.factory-id').css('display', 'table-cell');
        } else {
            $('.factory-id').css('display', 'none');
        }

        if($('#order_due_date').is(':checked')) {
            $('.due-date').css('display', 'table-cell');
        } else {
            $('.due-date').css('display', 'none');
        }

        if($('#order_open_date').is(':checked')) {
            $('.open-date').css('display', 'table-cell');
        } else {
            $('.open-date').css('display', 'none');
        }

        if($('#order_est_sippping_date').is(':checked')) {
            $('.est-ship-date').css('display', 'table-cell');
        } else {
            $('.est-ship-date').css('display', 'none');
        }

        if($('#order_sales_rep').is(':checked')) {
            $('.user-id').css('display', 'table-cell');
        } else {
            $('.user-id').css('display', 'none');
        }

        // if($('#order_total').is(':checked')) {
        //     $('.order-total').css('display', 'table-cell');
        // } else {
        //     $('.order-total').css('display', 'none');
        // }

        if($('#order_status').is(':checked')) {
            $('.order-status-id').css('display', 'table-cell');
        } else {
            $('.order-status-id').css('display', 'none');
        }

        if($('#inventory_status').is(':checked')) {
            $('.inventory-status').css('display', 'table-cell');
        } else {
            $('.inventory-status').css('display', 'none');
        }

        if($('#contact_person').is(':checked')) {
            $('.contact-person').css('display', 'table-cell');
        } else {
            $('.contact-person').css('display', 'none');
        }

        if($('#order_description').is(':checked')) {
            $('.order-description').css('display', 'table-cell');
        } else {
            $('.order-description').css('display', 'none');
        }

        // if($('#sub_total').is(':checked')) {
        //     $('.sub-total').css('display', 'table-cell');
        // } else {
        //     $('.sub-total').css('display', 'none');
        // }

        // if($('#sales_tax').is(':checked')) {
        //     $('.sales-tax').css('display', 'table-cell');
        // } else {
        //     $('.sales-tax').css('display', 'none');
        // }

        // if($('#shipping').is(':checked')) {
        //     $('.shipping').css('display', 'table-cell');
        // } else {
        //     $('.shipping').css('display', 'none');
        // }

        // if($('#artwork').is(':checked')) {
        //     $('.artwork').css('display', 'table-cell');
        // } else {
        //     $('.artwork').css('display', 'none');
        // }

        // if($('#processing_fee').is(':checked')) {
        //     $('.processing-fee').css('display', 'table-cell');
        // } else {
        //     $('.processing-fee').css('display', 'none');
        // }

        // if($('#team_store_file').is(':checked')) {
        //     $('.team-store-file').css('display', 'table-cell');
        // } else {
        //     $('.team-store-file').css('display', 'none');
        // }

        if($('#created_at').is(':checked')) {
            $('.created-at').css('display', 'table-cell');
        } else {
            $('.created-at').css('display', 'none');
        }

        if($('#updated_at').is(':checked')) {
            $('.updated-at').css('display', 'table-cell');
        } else {
            $('.updated-at').css('display', 'none');
        }
    }

    function searchIndex(){
        $('#orders_table thead th').each(function(){
            if($(this).text() == 'Organization') {
                searchIdx = $('#orders_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    //Export CSV
    function exportTasks(_this) {
        let _url = $(_this).data('href');
        window.location.href = _url;
    }

    // $('body').on('click', '.btn-team-store-download', function(e){
    //     var teamStoreId = $(this).val();

    //     $.ajax({
    //         url: '{{ url("team_store/get_team_store_report") }}/'+teamStoreId,
    //         type: "GET",
    //         dataType: 'json',
    //         beforeSend: function() {
    //             $(".se-pre-con").fadeIn('slow');
    //         },
    //         success: function(data) {
    //             console.log(data);
    //             e.preventDefault();
    //             window.location.href = data.team_store_report;
    //         },
    //         complete: function() {
    //             $(".se-pre-con").fadeOut('slow');
    //         }
    //     });
    // });

    // $('#team_store_import_form').on('submit', function(e){
    //     e.preventDefault();
    //     $(".se-pre-con").fadeIn('slow');
    //     this.submit();
    // });

    $('body').on('change', '#shipping_direct_ship_to_customers', function(){
        if(this.checked) {
            $('#shipping_bulk_ship_to_coach').prop('checked', false);
            $('#shipping_pick_up').prop('checked', false);
            $('#shipping_direct_pick_up').prop('checked', false);

            getDefaultPeople(3613);
        }
    });

    $('body').on('change', '#shipping_bulk_ship_to_coach', function(){
        if(this.checked) {
            $('#shipping_direct_ship_to_customers').prop('checked', false);
            $('#shipping_pick_up').prop('checked', false);
            $('#shipping_direct_pick_up').prop('checked', false);

            var organizationId = $('#organization_id').val();
            getPeople(organizationId);
        }
    });

    $('body').on('change', '#shipping_pick_up', function(){
        if(this.checked) {
            $('#shipping_direct_ship_to_customers').prop('checked', false);
            $('#shipping_bulk_ship_to_coach').prop('checked', false);
            $('#shipping_direct_pick_up').prop('checked', false);

            getDefaultPeople(3613);
        }
    });

    $('body').on('change', '#shipping_direct_pick_up', function(){
        if(this.checked) {
            $('#shipping_direct_ship_to_customers').prop('checked', false);
            $('#shipping_bulk_ship_to_coach').prop('checked', false);
            $('#shipping_pick_up').prop('checked', false);

            getDefaultPeople(3613);
        }
    });


    // $('#organization_id').on('change', function(){
    //     var organizationId = $(this).val();
    //     getPeople(organizationId);
    // });

    function getPeople(organizationId) {
        $.ajax({
            url:"{{ url('new_orders/customers') }}/"+organizationId,
            method:'GET',
            dataType:'json',
            success: function (data, textStatus, jqXHR){

                var contactList = data.contact_organizations;

                if(contactList.length > 0){

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

                } else {
                    $('#customer_id').html('');
                    $('<option value="">No Customers</option>').appendTo($('#customer_id'));
                }

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
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function getPaginateUrlParameter(sParam) {
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
        return 1;
    };

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
    };

    function setFilterValues(){
        var factoryId = $('#factory_id').val();
        var statusId = $('#status_id').val();
        setUrlParameter(factoryId, statusId);
    }

    function setUrlParameter(factoryId, statusId){
        var orgTxt = $("#searchbox").val();
        var params = { 'fct':factoryId, 'sts':statusId, 'org':orgTxt};
        // var new_url = '{{ route("orders")}}?' + jQuery.param(params);
        var new_url = window.location.href.split('?')[0] + '?' + jQuery.param(params);
        window.history.pushState('page2', 'Title', new_url);
        location.reload();
    }

    function loadingStart(){
        $(".se-pre-con").fadeIn();
    }

    $('#import_modal').on('shown.bs.modal', function (e) {
        $.ajax({
            url: '{{ url("people/get_organization_list") }}',
            type: "GET",
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                var org_options = '<option value="">Select an Organization</option>';
                for (let index = 0; index < data.length; index++) {
                    org_options += '<option value="'+data[index].id+'">'+data[index].organization_name+'</option>';
                }

                $('#organization_id').html(org_options);
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    });

    let header = "INVENTORY ORDERS";
        document.getElementById("header").innerHTML = header;

</script>
@endsection
