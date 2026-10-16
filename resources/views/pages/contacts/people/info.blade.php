@extends('layouts.app', ['activePage' => 'people', 'titlePage' => __('People Info')])

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
        display: none;
    }
    .select2 {
        height: 1.8rem;
        border-radius: 5px !important;
    }
    #lead_source_info+.select2,
    #user_id_info+.select2 {
        width: 100% !important;
        border: 1px #e4e4e4b8 solid !important;
    }
    #organization_id_info+.select2 {
        width: 100% !important;
    }
    #organization_id_info+a {
        display: flex;
    }
    .select2-selection.select2-selection--single {
        height: 1.6rem !important;
    }

    /* .select2.select2-container {
        width: 100% !important;
    } */

    #organization_id_info{
        height: 180px !important;
    }

    #new_organization_id{
        height: 70px !important;
    }

    #organization_id_info + .select2.select2-container{
        min-height: 100px !important;
        border: 1px #e4e4e4 solid !important;
    }

    #new_organization_id + .select2.select2-container{
        min-height: 60px !important;
    }
    .name-txt-color {
        color: #ffffff;
    }
    .btn-text-size {
        font-size: small;
    }
    .btn-padding {
        padding: unset;
    }
    .add-btn-text-position {
        position: relative;
        top: -2px;
        right: -13px;
    }
    .email-btn-text-position {
        position: relative;
        top: -2px;
        right: -9px;
    }
    .pic-size {
        width: 42px;
    }
    .pic-div {
        width: 60px;
    }
    .content-position {
        position: relative;
        top: -46px;
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
        right: 13px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    .outline-border {
        border: 1px #e4e4e4b8 solid !important;
        border-radius: 5px !important;
    }
    /* .nav-item .nav-link.active {
        color: white !important;
    } */
    .people-navbar .nav-link{
        color: grey !important;
        border-bottom: 2px solid #70717171 !important;
    }

    .styled-nav-item .nav-link.active , .styled-nav-item .nav-link:hover {
        color: black !important;
        border-bottom: 2px solid black !important;
    }
    .card {
        border-radius: 0rem;
        border: none;
    }
    .form-lable-info{
        color: black;
    }
    .detail-section input[type="text"], .detail-section input[type="email"], .select2.select2-container.select2-container--default{
        border-radius: 0rem !important;
        color: #717070 !important;
        border: 0.5px solid #eaeaea !important;
        width: 100% !important;
    }
    .mail_mail-button{
        outline: unset;
        color: #d3d3d3;
        background-color: transparent;
        border: 1px solid #d3d3d3;
        padding: .5rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
    }
    .sub-header-style{
        color: black;
        font-size: 1rem;
        font-weight: 600;
    }
    .new-button-layouts {
        border: none !important;
        border-radius: 0rem !important;
        font-size: .8rem !important;
        padding: .2em 2em !important;
        cursor: pointer;
    }
    .people-unique-styles table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .people-unique-styles table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .people-unique-styles table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .people-unique-styles table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .people-unique-styles th, .people-unique-styles td {
        padding: 10px;
    }
    .people-unique-styles .dataTables_info {
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

    @media (max-width: 768px) {

        input:focus,
        textarea:focus,
        select:focus,
        .form-control:focus,
        .invoice-inputs:focus,
        .select2-selection:focus,
        .select2-selection__rendered:focus,
        .select2-search__field:focus {
            font-size: 16px !important;
        }

    }
    @media (min-width: 769px){
        .back_home_mobile {
            display:none !important;
        }
    }

    @media (max-width: 768px) {
        .mobile_padding_unset {
            padding: unset !important;
        }
        .back_home_mobile {
            /* padding-bottom: 20px; */
            display: block !important;
        }
        .content-position {
            top: 0px;
        }
        .mobile_margin_unset {
            margin: unset !important;
        }
        .mobile_card {
            padding: 5px 10px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0px 2px 10px 0px #14141E0F;
        }
    }
    @media (max-width: 767.98px) {

        /* -------------------------------------------------
        PEOPLE MOBILE TAB NAVIGATION
        ------------------------------------------------- */

        .people-navbar {
            width: 100% !important;
            padding: 6px !important;
            margin: 10px 0 15px 0 !important;

            background: #f4f5f7 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 14px !important;

            overflow-x: auto !important;
            overflow-y: hidden !important;

            -webkit-overflow-scrolling: touch !important;
            scrollbar-width: none !important;
        }

        .people-navbar::-webkit-scrollbar {
            display: none !important;
        }

        .people-navbar ul.nav {
            display: flex !important;
            flex-wrap: nowrap !important;

            width: max-content !important;
            min-width: 100% !important;

            margin: 0 !important;
            padding: 0 !important;

            gap: 5px !important;
        }

        .people-navbar .styled-nav-item {
            flex: 0 0 auto !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .people-navbar .styled-nav-item .nav-link {
            position: relative !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;

            min-height: 42px !important;
            padding: 9px 15px !important;

            border-radius: 10px !important;
            border: 0 !important;

            background: transparent !important;
            color: #777 !important;

            font-size: 12px !important;
            font-weight: 600 !important;

            line-height: 1.2 !important;
            white-space: nowrap !important;

            transition: all 0.25s ease !important;
        }

        /* Active tab */
        .people-navbar .styled-nav-item .nav-link.active {
            background: #ffffff !important;
            color: #222 !important;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.08) !important;

            font-weight: 700 !important;
        }

        /* Small active indicator */
        .people-navbar .styled-nav-item .nav-link.active::after {
            content: "" !important;

            position: absolute !important;
            left: 50% !important;
            bottom: 4px !important;

            width: 18px !important;
            height: 3px !important;

            transform: translateX(-50%) !important;

            border-radius: 10px !important;
            background: #222 !important;
        }

        /* Touch feedback */
        .people-navbar .styled-nav-item .nav-link:active {
            transform: scale(0.96) !important;
        }
    }

    /* =========================================================
    MOBILE ACTION BUTTONS
    Desktop remains completely unchanged
    ========================================================= */

    @media (max-width: 767.98px) {

        .control-btns {
            position: relative !important;

            display: flex !important;
            align-items: center !important;

            gap: 10px !important;

            /* width: calc(100% - 20px) !important; */

            /* margin: 18px auto 25px auto !important; */
            padding: 10px !important;

            background: rgba(255, 255, 255, 0.96) !important;

            border: 1px solid #e9ecef !important;
            border-radius: 5px !important;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, 0.06),
                0 1px 3px rgba(0, 0, 0, 0.04) !important;

            backdrop-filter: blur(10px);

            overflow: hidden !important;
        }


        /* =====================================================
        ALL BUTTONS
        ===================================================== */

        .control-btns .new-button-layouts {
            position: relative !important;

            flex: 1 1 0 !important;

            min-width: 0 !important;
            width: auto !important;

            height: 46px !important;

            margin: 0 !important;

            padding: 0 8px !important;

            border: none !important;
            border-radius: 12px !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;

            font-size: 0.78rem !important;
            font-weight: 600 !important;

            letter-spacing: .15px !important;

            transition:
                transform .18s ease,
                box-shadow .18s ease,
                filter .18s ease !important;

            box-shadow: none !important;
        }


        /* =====================================================
        SAVE
        ===================================================== */

        .control-btns #saveForm {

            background: linear-gradient(
                135deg,
                #20b26b 0%,
                #159957 100%
            ) !important;

            color: #fff !important;

            box-shadow:
                0 5px 12px rgba(25, 155, 91, .20) !important;
        }


        /* =====================================================
        DELETE
        ===================================================== */

        .control-btns #deletePeople {

            background: #f4f5f7 !important;

            color: #555b63 !important;

            border: 1px solid #e4e7eb !important;

            box-shadow: none !important;
        }


        /* =====================================================
        CANCEL
        ===================================================== */

        .control-btns .btn-secondary {

            background: linear-gradient(
                135deg,
                #ef5350 0%,
                #d9363e 100%
            ) !important;

            color: #fff !important;

            box-shadow:
                0 5px 12px rgba(217, 54, 62, .18) !important;
        }


        /* =====================================================
        TOUCH EFFECT
        ===================================================== */

        .control-btns .new-button-layouts:active {

            transform: scale(.94) !important;

            filter: brightness(.94) !important;
        }


        /* =====================================================
        REMOVE BOOTSTRAP FOCUS EFFECT
        ===================================================== */

        .control-btns .new-button-layouts:focus {
            outline: none !important;
        }


        /* =====================================================
        OPTIONAL: SMALL SCREEN
        ===================================================== */

        @media (max-width: 380px) {

            .control-btns {
                gap: 7px !important;
                padding: 8px !important;
                border-radius: 15px !important;
            }

            .control-btns .new-button-layouts {
                height: 43px !important;

                font-size: .72rem !important;

                border-radius: 10px !important;
            }
        }

    }

    /* =========================================================
    PEOPLE ORDERS TABLE - MOBILE CARD VIEW
    Desktop remains completely unchanged
    ========================================================= */

    @media (max-width: 767.98px) {

        /* ---------------------------------------------------------
        CARD CONTAINER
        --------------------------------------------------------- */

        #quotes > .card {
            /* margin-left: 8px !important; */
            /* margin-right: 8px !important; */

            padding: 12px !important;

            border-radius: 14px !important;

            border: 1px solid #e8eaed !important;

            box-shadow: 0 3px 12px rgba(0, 0, 0, .05) !important;

            background: #fff !important;
        }


        /* ---------------------------------------------------------
        ADD NEW ORDER
        --------------------------------------------------------- */

        #quotes > .card > .ml-auto {
            width: 100% !important;

            margin: 0 0 12px 0 !important;
        }

        #quotes .mail_mail-button {
            display: flex !important;

            width: 100% !important;

            min-height: 42px !important;

            align-items: center !important;
            justify-content: center !important;

            border-radius: 10px !important;

            border: 1px solid #e5e7eb !important;

            font-size: .76rem !important;
            font-weight: 600 !important;

            text-decoration: none !important;

            letter-spacing: .2px !important;

            box-shadow: 0 2px 7px rgba(0, 0, 0, .04) !important;
        }


        /* ---------------------------------------------------------
        REMOVE TABLE RESPONSIVE BEHAVIOUR
        --------------------------------------------------------- */

        #quotes .table-responsive {
            width: 100% !important;

            overflow: visible !important;
        }


        /* ---------------------------------------------------------
        TABLE
        --------------------------------------------------------- */

        #people_orders_table {
            width: 100% !important;

            display: block !important;

            border-collapse: separate !important;
            border-spacing: 0 !important;

            margin: 0 !important;
        }


        /* ---------------------------------------------------------
        HIDE HEADER
        --------------------------------------------------------- */

        #people_orders_table thead {
            display: none !important;
        }


        /* ---------------------------------------------------------
        TBODY
        --------------------------------------------------------- */

        #people_orders_table tbody {
            display: block !important;

            width: 100% !important;
        }


        /* ---------------------------------------------------------
        EACH ORDER = CARD
        --------------------------------------------------------- */

        #people_orders_table tbody tr {
            display: grid !important;

            width: 100% !important;

            grid-template-columns: 1fr 1fr !important;

            grid-template-areas:
                "order status"
                "organization organization"
                "total salesrep" !important;

            gap: 0 18px !important;

            margin: 0 0 12px 0 !important;

            padding: 13px 12px !important;

            background: #ffffff !important;

            border: 1px solid #e8eaed !important;

            border-radius: 13px !important;

            box-shadow: 0 2px 8px rgba(0, 0, 0, .04) !important;

            box-sizing: border-box !important;
        }


        /* ---------------------------------------------------------
        REMOVE DEFAULT TABLE CELL STYLES
        --------------------------------------------------------- */

        #people_orders_table tbody td {
            display: block !important;

            width: auto !important;

            padding: 0 !important;

            margin: 0 !important;

            border: none !important;

            text-align: left !important;

            vertical-align: middle !important;
        }


        /* ---------------------------------------------------------
        1ST ROW
        ORDER ID
        --------------------------------------------------------- */

        #people_orders_table tbody td:nth-child(1) {
            grid-area: order !important;

            display: flex !important;

            align-items: center !important;

            min-height: 30px !important;

            padding-bottom: 10px !important;

            font-size: .82rem !important;

            font-weight: 600 !important;
        }


        #people_orders_table tbody td:nth-child(1) a {
            color: #333 !important;

            font-weight: 600 !important;

            text-decoration: none !important;
        }


        /* ---------------------------------------------------------
        STATUS
        --------------------------------------------------------- */

        #people_orders_table tbody td:nth-child(4) {
            grid-area: status !important;

            display: flex !important;

            align-items: center !important;

            justify-content: flex-end !important;

            min-height: 30px !important;

            padding-bottom: 10px !important;
        }


        #people_orders_table tbody td:nth-child(4) .badge {
            width: auto !important;

            min-width: 70px !important;

            padding: 5px 9px !important;

            font-size: .67rem !important;

            line-height: 1.2 !important;

            text-align: center !important;
        }


        /* ---------------------------------------------------------
        BORDER UNDER FIRST ROW
        --------------------------------------------------------- */

        #people_orders_table tbody td:nth-child(1)::after {

            content: "";

            position: absolute;

            left: 12px;
            right: 12px;

            margin-top: 42px;

            height: 1px;

            background: #edf0f2;
        }


        /* ---------------------------------------------------------
        2ND ROW - ORGANIZATION
        --------------------------------------------------------- */

        #people_orders_table tbody td:nth-child(2) {
            grid-area: organization !important;

            padding-top: 13px !important;

            padding-bottom: 13px !important;
        }


        /* ---------------------------------------------------------
        3RD ROW - TOTAL
        --------------------------------------------------------- */

        #people_orders_table tbody td:nth-child(5) {
            grid-area: total !important;

            padding-top: 5px !important;

            padding-bottom: 3px !important;
        }


        /* ---------------------------------------------------------
        3RD ROW - SALES REP
        --------------------------------------------------------- */

        #people_orders_table tbody td:nth-child(3) {
            grid-area: salesrep !important;

            padding-top: 5px !important;

            padding-bottom: 3px !important;
        }


        /* ---------------------------------------------------------
        LABELS
        --------------------------------------------------------- */

        #people_orders_table tbody td:nth-child(2)::before {
            content: "Organization";

            display: block !important;

            margin-bottom: 4px !important;

            font-size: .68rem !important;

            font-weight: 600 !important;

            color: #000000 !important;

            text-transform: uppercase !important;

            letter-spacing: .35px !important;
        }


        #people_orders_table tbody td:nth-child(5)::before {
            content: "Total ($)";

            display: block !important;

            margin-bottom: 4px !important;

            font-size: .68rem !important;

            font-weight: 600 !important;

            color: #000000 !important;

            text-transform: uppercase !important;

            letter-spacing: .35px !important;
        }


        #people_orders_table tbody td:nth-child(3)::before {
            content: "Sales Rep";

            display: block !important;

            margin-bottom: 4px !important;

            font-size: .68rem !important;

            font-weight: 600 !important;

            color: #000000 !important;

            text-transform: uppercase !important;

            letter-spacing: .35px !important;
        }


        /* ---------------------------------------------------------
        FIELD VALUES
        --------------------------------------------------------- */

        #people_orders_table tbody td:nth-child(2),
        #people_orders_table tbody td:nth-child(3),
        #people_orders_table tbody td:nth-child(5) {

            font-size: .80rem !important;

            font-weight: 600 !important;

            color: #999 !important;

            line-height: 1.35 !important;

            word-break: break-word !important;
        }


        /* ---------------------------------------------------------
        ORGANIZATION VALUE
        --------------------------------------------------------- */

        #people_orders_table tbody td:nth-child(2) {
            border-bottom: 1px solid #f1f2f4 !important;
        }


        /* ---------------------------------------------------------
        LAST CARD
        --------------------------------------------------------- */

        #people_orders_table tbody tr:last-child {
            margin-bottom: 0 !important;
        }

        #people_orders_table_length {
            text-align: left !important;
        }

        #people_orders_table_filter {
            text-align: left !important;
        }

        /* ---------------------------------------------------------
        SMALL MOBILE
        --------------------------------------------------------- */

        @media (max-width: 380px) {

            #people_orders_table tbody tr {
                padding: 11px 10px !important;

                gap: 0 12px !important;
            }

            #people_orders_table tbody td:nth-child(4) .badge {
                min-width: 60px !important;

                font-size: .62rem !important;
            }

            #people_orders_table tbody td:nth-child(2),
            #people_orders_table tbody td:nth-child(3),
            #people_orders_table tbody td:nth-child(5) {
                font-size: .75rem !important;
            }
        }

    }

</style>

<div class="container-fluid mb-5 people-unique-styles content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('people') }}" class="home-btn-color" title="Back to home">BACK TO PEOPLES</a>
    @endsection

    @section('back-btn-Mobile')
        <a href="{{ route('people') }}" class="home-btn-color" title="Back to home"> < BACK TO PEOPLES</a>
    @endsection

    <div class="col-md-12 back_home_mobile">
        <strong>
            @yield('back-btn-Mobile')
        </strong>
    </div>

    <div class="col-md-12 btn-top" style="display: none">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 btns-right-position btn_set1">
                <div class="row">
                    <div class="col-md-3 btns-padding">
                        @can('create people')
                            <button class="btns-text btns-style btns-card" style="outline: unset;" id="add_people" title="Add New People">
                                Add People
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3 btns-padding">
                        <button class="btns-text btns-style btns-card" style="outline: unset;"  title="Send Email">
                            Send Mail
                        </button>
                    </div>
                    <div class="col-md-3 btns-padding">
                        @can('export people')
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" id="export_csv" data-href="{{ route('people.export_csv') }}" onclick="exportTasks(event.target);" title="Export CSV People">
                                CSV Export
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3 btns-padding">
                        <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                            Fields &amp; Layouts
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('people.update') }}" id="people_update" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="people_id" name="people_id" value="{{$peoples->id}}" />

        {{-- @section('order-header')
        <div class="row nowrapdiv">
            <div class="pic-div">
                <img class="pic-size" alt="Image placeholder" id="image_preview" src="{{ asset('assets') }}/img/people/default.png" />
            </div>
            <div>
                <h4 class="mb-0 name-txt-color">
                    <span class="d-block details-name">{{$peoples->first_name." ".$peoples->last_name}}</span>
                    <span class="d-block details-email">{{$peoples->email}}</span>
                </h4>
            </div>
        </div>

        @endsection --}}

        <div class="col-md-12 mt-4 detail-section">
            <div class="card" style="border: none; background-color:transparent;">
                {{-- <div class="card-header">
                    <div class="card-header-danger col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="float-left header-details">
                                    <img alt="Image placeholder" id="image_preview" src="{{ asset('assets') }}/img/people/default.png" />

                                    <h4 class="mb-0">
                                        <span class="d-block details-name">{{$peoples->first_name." ".$peoples->last_name}}</span>
                                        <span class="d-block details-email">{{$peoples->email}}</span>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-6 header-icons justify-content-center">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <span>
                                            <button type="button" class="btn btn-round">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <p>Send Mail</p>
                                        </span>
                                    </div>
                                    @can('export people')
                                        <div class="col-md-3 text-center">
                                            <span>
                                                <a class="btn btn-round" href="#" id="export_csv" data-href="{{ route('people.export_csv') }}" onclick="exportTasks(event.target);">
                                                    <i class="fas fa-file-csv"></i>
                                                </a>
                                                <p>Export</p>
                                            </span>
                                        </div>
                                    @endcan
                                    @can('add people')
                                        <div class="col-md-3 text-center">
                                            <span>
                                                <button type="button" class="btn btn-round" id="add_people">
                                                    <i class="fas fa-user-plus"></i>
                                                </button>
                                                <p>Add People</p>
                                            </span>
                                        </div>
                                    @endcan
                                    <div class="col-md-3 text-center">
                                        <span>
                                            <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                                <i class="fas fa-wrench"></i>
                                            </a>
                                            <p>Fields &amp; Layouts</p>
                                        </span>
                                    </div>
                                </div>
                                @can('create people')
                                    <span>
                                        <button type="button" class="btn btn-round" id="add_people">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                        <p>Add People</p>
                                    </span>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="card-body" style="padding: 0rem">
                    <div class="row mt-4 justify-content-center align-items-center mobile_margin_unset mobile_card">
                        <div class="col-md-1 col-2">
                            <img src="{{ asset('assets') }}/img/people/default.png" style="width:100%;height:auto" id="image_preview" />
                        </div>
                        <div class="col-md-4 d-flex align-items-center col-7 mobile_padding_unset">
                            <span style="font-size: 1.5rem;color: black;font-weight: 600;">{{$peoples->first_name." ".$peoples->last_name}}</span>
                        </div>

                        <div class="col-md-7 d-flex justify-content-end align-items-center col-3">
                            <button class="mail_mail-button" style="outline: unset;padding:.3rem;padding-right:.5rem;padding-left:.5rem;" href="#" title="Send Email">
                                Send Mail
                            </button>
                        </div>
                    </div>
                    <div class="nav-wrapper people-navbar">
                        <ul class="nav" id="tabs-icons-text" role="tablist">
                            <li class="nav-item styled-nav-item">
                                <a class="nav-link active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">Details</a>
                            </li>
                            <li class="nav-item styled-nav-item">
                                <a class="nav-link" id="tabs-icons-text-3-tab" data-toggle="tab" href="#quotes" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Orders">Orders
                                    ({{$orderCount}})
                                    <input type="hidden" id="orderCount" value="{{$orderCount}}"/>
                                </a>
                            </li>
                            <li class="nav-item styled-nav-item">
                                <a class="nav-link" id="tabs-icons-text-3-tab" data-toggle="tab" href="#emails" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Emails">Emails
                                    ({{__('0')}})
                                </a>
                            </li>
                            <li class="nav-item styled-nav-item">
                                <a class="nav-link" id="tabs-icons-text-3-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Files">Files
                                    ({{$fileCount}})
                                </a>
                            </li>
                            <li class="nav-item styled-nav-item">
                                <a class="nav-link" id="tabs-icons-text-3-tab" data-toggle="tab" href="#" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Projects">Projects
                                    ({{__('0')}})
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                            <div id="accordionExample">
                                <div class="row div_flexdir1">
                                    <div class="col-md-6 div_none1">

                                        <div class="card mobile_card" style="height: 100%">
                                            {{-- <div id="organization-details" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample"> --}}
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 sub-header-style">
                                                            People
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">First Name <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control info-form-input" id="first_name" name="first_name" value="{{$peoples->first_name}}" required />
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Last Name <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->last_name}}" id="last_name" name="last_name" required />
                                                        </div>

                                                        <div class="col-md-12 mt-2">
                                                            <label class="form-lable-info">Organization Name <span class="text-danger">*</span></label>
                                                            <select class="form-control form-input select2-people" id="organization_id_info" name="organization_id[]"  multiple="multiple" required>
                                                                <option value="">Select an Organization</option>
                                                                @foreach ($organizations as $organization)
                                                                <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <a href="#organization_create_modal" id="btn_add_people_organizations" data-target="#organization_create_modal" data-toggle="modal" class="input-group-text" style="border: none;padding-left: 0px;font-size: .8rem;">ADD NEW ORGANIZATION</a>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Work No </label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->phone_no}}" id="phone_no" name="phone_no" />
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Personal No </label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->personal_phone_no}}" id="personal_phone_no" name="personal_phone_no" />
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Email <span class="text-danger">*</span></label>
                                                            <input type="email" class="form-control info-form-input people-email-class-update" value="{{$peoples->email}}" id="email" name="email" required/>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Secondary Email </label>
                                                            <input type="email" class="form-control info-form-input" value="{{$peoples->email_two}}" id="email_two" name="email_two" />
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Title </label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->title}}" id="title" name="title" />
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Lead Source</label>
                                                            <select class="form-control info-form-input select2-people" id="lead_source_info" name="lead_source">
                                                                <option value="">Select lead source</option>
                                                                @foreach ($lead_sources as $lead_source)
                                                                    <option value="{{$lead_source->id}}" {{ ($peoples->lead_source == $lead_source->id) ? 'selected' : '' }}>{{$lead_source->lead_source_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Assigned To <span class="text-danger">*</span></label>
                                                            <select class="form-control info-form-input select2-people" id="user_id_info" name="user_id" required>
                                                                <optgroup label="Users">
                                                                    @foreach ($users as $user)
                                                                    <option value="{{$user->id}}" {{$peoples->user_id == $user->id  ? 'selected' : ''}}>{{$user->name}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                                <optgroup label="Groups">
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6 div_none1">
            <!-- ================================ Shipping Address ===================================== -->
                                        <div class="card" style="height: 100%">

                                            {{-- <div id="shipping-address" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample"> --}}
                                                <div class="card-body" style="min-height: 257px;">
                                                    <div class="row">
                                                        <div class="col-md-12 sub-header-style">
                                                            Shipping Address
                                                        </div>
                                                        <div class="col-md-12 sub-header-style mt-2" style="font-size: .8rem;">
                                                            Primary Address
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Country</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_country}}" id="shipping_country" name="shipping_country" />
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Street</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_street}}" id="shipping_street" name="shipping_street" />
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">City</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_city}}" id="shipping_city" name="shipping_city" />
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">State</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_state}}" id="shipping_state" name="shipping_state" />
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Postal Code</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_zip}}" id="shipping_postal_code" name="shipping_zip" />
                                                        </div>

                                                        <div class="col-md-12 sub-header-style mt-3" style="font-size: .8rem;">
                                                            Secondary Address
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Country</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_country_2}}" id="shipping_country_2" name="shipping_country_2" />
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Street</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_street_2}}" id="shipping_street_2" name="shipping_street_2" />
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">City</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_city_2}}" id="shipping_city_2" name="shipping_city_2" />
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">State</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_state_2}}" id="shipping_state_2" name="shipping_state_2" />
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable-info">Postal Code</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_zip_2}}" id="shipping_postal_code_2" name="shipping_zip_2" />
                                                        </div>

                                                    </div>
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        <br/>

                                        <div class="card outline-border" style="display: none">
                                            <div class="card-header">
                                                <h5 class="mb-0">Secondary Shipping Address</h5>
                                            </div>

                                            {{-- <div id="shipping-address" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample"> --}}
                                                <div class="card-body" style="min-height: 257px;">
                                                    {{-- <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-lable-info">Street</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_street_2}}" id="shipping_street_2" name="shipping_street_2" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-lable-info">City</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_city_2}}" id="shipping_city_2" name="shipping_city_2" />
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-lable-info">State</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_state_2}}" id="shipping_state_2" name="shipping_state_2" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-lable-info">Postal Code</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_zip_2}}" id="shipping_postal_code_2" name="shipping_zip_2" />
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-lable-info">Country</label>
                                                            <input type="text" class="form-control info-form-input" value="{{$peoples->shipping_country_2}}" id="shipping_country_2" name="shipping_country_2" />
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            {{-- </div> --}}
                                        </div>


                                    </div>
                                </div>
                            </div>

                                {{-- <div class="card">
                                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#organization-details" aria-expanded="true" aria-controls="organization-details">
                                        <h5 class="mb-0">People Details</h5>
                                    </div>

                                    <div id="organization-details" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-input" id="first_name" name="first_name" value="{{$peoples->first_name}}" required />
                                                </div>

                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">Organization Name <span class="text-danger">*</span></label>
                                                    <select class="form-control form-input" id="organization_id" name="organization_id" style="width: 34%;" required>
                                                        <option value="">Select an Organization</option>
                                                        @foreach ($organizations as $organization)
                                                        <option value="{{$organization->id}}" {{$peoples->organization_id == $organization->id  ? 'selected' : ''}}>{{$organization->organization_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" class="btn btn-sm input-group-text"><i class="fas fa-plus"></i></button>
                                                </div>

                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-input" value="{{$peoples->last_name}}" id="last_name" name="last_name" required />
                                                </div>

                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">Lead Source</label>
                                                    <select class="form-control form-input" id="lead_source" name="lead_source">
                                                        <option value="">Select a Lead Source</option>
                                                        <option value="Cold Call" {{$peoples->lead_source == "Cold Call"  ? 'selected' : ''}}>Cold Call</option>
                                                        <option value="Existing Customer" {{$peoples->lead_source == "Existing Customer"  ? 'selected' : ''}}>Existing Customer</option>
                                                        <option value="Self Generated" {{$peoples->lead_source == "Self Generated"  ? 'selected' : ''}}>Self Generated</option>
                                                        <option value="Employee" {{$peoples->lead_source == "Employee"  ? 'selected' : ''}}>Employee</option>
                                                        <option value="Partner" {{$peoples->lead_source == "Partner"  ? 'selected' : ''}}>Partner</option>
                                                        <option value="Public Relations" {{$peoples->lead_source == "Public Relations"  ? 'selected' : ''}}>Public Relations</option>
                                                        <option value="Direct Mail" {{$peoples->lead_source == "Direct Mail"  ? 'selected' : ''}}>Direct Mail</option>
                                                        <option value="Conference" {{$peoples->lead_source == "Conference"  ? 'selected' : ''}}>Conference</option>
                                                        <option value="Trade Show" {{$peoples->lead_source == "Trade Show"  ? 'selected' : ''}}>Trade Show</option>
                                                        <option value="Web Site" {{$peoples->lead_source == "Web Site"  ? 'selected' : ''}}>Web Site</option>
                                                        <option value="Word of Mouth" {{$peoples->lead_source == "Word of Mouth"  ? 'selected' : ''}}>Word of Mouth</option>
                                                        <option value="Other" {{$peoples->lead_source == "Other"  ? 'selected' : ''}}>Other</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">Phone No </label>
                                                    <input type="text" class="form-control form-input" value="{{$peoples->phone_no}}" id="phone_no" name="phone_no" />
                                                </div>

                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">Email </label>
                                                    <input type="email" class="form-control form-input " value="{{$peoples->email}}" id="email" name="email" />
                                                </div>

                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">Title </label>
                                                    <input type="text" class="form-control form-input" value="{{$peoples->title}}" id="title" name="title" />
                                                </div>

                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">Assigned To <span class="text-danger">*</span></label>
                                                    <select class="form-control form-input" class="form-control form-input" id="user_id" name="user_id" required>
                                                        <optgroup label="Users">
                                                            @foreach ($users as $user)
                                                            <option value="{{$user->id}}" {{$peoples->user_id == $user->id  ? 'selected' : ''}}>{{$user->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                        <optgroup label="Groups">
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

    <!-- ================================ Shipping Address ===================================== -->
                                <div class="card">
                                    <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#shipping-address" aria-expanded="false" aria-controls="collapseTwo">
                                        <h5 class="mb-0">Postal Address</h5>
                                    </div>

                                    <div id="shipping-address" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">Street</label>
                                                    <input type="text" class="form-control form-input" value="{{$peoples->shipping_street}}" id="shipping_street" name="shipping_street" />
                                                </div>
                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">City</label>
                                                    <input type="text" class="form-control form-input" value="{{$peoples->shipping_city}}" id="shipping_city" name="shipping_city" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">State</label>
                                                    <input type="text" class="form-control form-input" value="{{$peoples->shipping_state}}" id="shipping_state" name="shipping_state" />
                                                </div>
                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">Postal Code</label>
                                                    <input type="text" class="form-control form-input" value="{{$peoples->shipping_zip}}" id="shipping_postal_code" name="shipping_postal_code" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 form-field">
                                                    <label class="form-lable">Country</label>
                                                    <input type="text" class="form-control form-input" value="{{$peoples->shipping_country}}" id="shipping_country" name="shipping_country" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

    {{-- ============================================== Key Fields ============================================== --}}
                            {{-- <div class="row">
                                <div class="col-md-5 mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mb-3">Key Fields</h4>
                                            <ul class="list-group list-group-flush list">
                                                <li class="list-group-item px-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6">
                                                            <h5 class="mb-0">Name</h5>
                                                        </div>
                                                        <div class="col-md-6 organization_name"><small>{{$peoples->first_name." ".$peoples->last_name}}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item px-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6">
                                                            <h5 class="mb-0">Assigned To</h5>
                                                        </div>
                                                        <div class="col-md-6 assigned_to"><small>admin Ivey</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item px-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6">
                                                            <h5 class="mb-0">Billing City</h5>
                                                        </div>
                                                        <div class="col-md-6 billing_city"><small>{{$peoples->mailing_city}}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item px-0">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6">
                                                            <h5 class="mb-0">Billing Country</h5>
                                                        </div>
                                                        <div class="col-md-6 billing_country"><small>{{$peoples->mailing_country}}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div> --}}

    {{-- ============================================== Files ============================================== --}}
                                    {{-- <div class="card mt-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4>Files</h4>
                                                </div>
                                                <div class="col">
                                                    <button type="button" class="btn btn-secondary btn-secondary-custom dropdown-toggle float-right" title="Customize" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i> New File</button>
                                                    <div class="dropdown-menu organiztions-dropdown-menu info-dropdown-menu">
                                                        <a class="dropdown-item" href="#"><i class="fas fa-upload"></i>File Upload</a>
                                                        <a class="dropdown-item" href="#">To Vtiger</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#"><i class="fas fa-link"></i>Link External File</a>
                                                        <a class="dropdown-item" href="#"><i class="fas fa-external-link-alt"></i>From File URL</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#"><i class="fas fa-file-alt"></i> Create New File</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="list-group list-group-flush">
                                                    <a class="list-group-item list-group-item-action flex-column align-items-start py-4 px-4">
                                                        <small>No Related Files</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

    {{-- ============================================== Activities ============================================== --}}
                                {{-- <div class="col-md-7 mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="mb-3">Activities</h4>
                                                </div>
                                                <div class="col">
                                                    <button type="button" class="btn btn-secondary btn-secondary-custom" title="Add Activity"><i class="fas fa-plus"></i> Add Activity</button>
                                                    <button type="button" class="btn btn-secondary btn-secondary-custom float-right" title="Add Event"><i class="fas fa-plus"></i> Add Event</button>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">
                                                    <div class="timeline-block">
                                                        <span class="timeline-step badge-warning">
                                                            <i class="far fa-check-square"></i>
                                                        </span>
                                                        <div class="timeline-content">
                                                            <div class="d-flex justify-content-between pt-1">
                                                                <div>
                                                                    <span class="text-muted text-sm font-weight-bold">Test Activity</span>
                                                                </div>
                                                                <div class="text-right">
                                                                    <small class="text-muted">Not Started</small>
                                                                </div>
                                                            </div>
                                                            <h6 class="text-sm mt-1 mb-0">Fri 23 Oct</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

    {{-- ============================================== Comments ============================================== --}}
                                    {{-- <div class="card mt-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="mb-3">Comments</h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Post your comment here"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8 single-row">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFileLang" lang="en">
                                                        <label class="custom-file-label" for="customFileLang">Select file</label>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary btn-sm btn-sm-custom" data-container="body" data-toggle="popover" data-color="secondary" data-placement="top" data-content="Maximum upload size is 3 MB.">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                </div>
                                                <div class="col-lg-4">
                                                    <button type="submit" class="btn btn-success btn-custom float-right">Post</button>
                                                </div>
                                            </div>

                                            <hr /> --}}

    {{-- ============================================== Recent Comments ============================================== --}}
                                            {{-- <div class="row">
                                                <div class="col">
                                                    <h4 class="mb-3">Recent Comments</h4>
                                                </div>

                                                <div class="col group-set float-right">
                                                    <small>Roll up </small>
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary btn-sm btn-sm-custom"
                                                        data-container="body"
                                                        data-toggle="popover"
                                                        data-color="secondary"
                                                        data-placement="top"
                                                        data-content="If Roll up is set to 'On' comments on related records will be shown. For example, if
                                                        you are viewing comments on an Organization record, comments added to related Contacts, Opportunities,
                                                        Tickets, ..etc would also be displayed."
                                                    >
                                                        <i class="fas fa-question-circle"></i>
                                                    </button>
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" checked>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="Off" data-label-on="On"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="list-group list-group-flush">
                                                    <a class="list-group-item list-group-item-action flex-column align-items-start py-4 px-4">
                                                        <small>No Comments</small>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-lg-12 control-btns mb-5" style="background-color: transparent">
                                @can('edit people')
                                    <button type="button" id="saveForm" class="btn btn-success btn-custom new-button-layouts" onclick="people_update_Submit('{{$peoples->email}}')">Save</button>
                                @endcan
                                @can('delete people')
                                    <button type="button" id="deletePeople" value="{{ $peoples->id }}" class="btn btn-danger btn-custom new-button-layouts">Delete</button>
                                @endcan
                                <button type="reset" class="btn btn-secondary btn-custom new-button-layouts">Cancel</button>
                            </div>
                        </div>

    <!--=================================== Updates ====================================-->
                        <div class="tab-pane fade" id="updates" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 mt-3">
                                        <div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">
                                            <div class="timeline-block">
                                                <span class="timeline-step badge-warning">
                                                    <i class="far fa-check-square"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <div class="d-flex justify-content-between pt-1">
                                                        <div>
                                                            <span class="text-muted text-sm font-weight-bold">Calendar Linked</span>
                                                        </div>
                                                        <div class="text-right">
                                                            <small class="text-muted">5 days ago</small>
                                                        </div>
                                                    </div>
                                                    <h6 class="text-sm mt-1 mb-0">Test Activity</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- ================================== Quotes ====================================== -->
                        <div class="tab-pane fade" id="quotes" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                            <div class="col-md-12 mt-3 card">
                                <div class="ml-auto mb-3 mt-3">
                                    {{-- <a href="{{ route('new_orders') }}/{{$peoples->organization_id}}" class="btn btn-secondary btn-secondary-custom" title="Add Contact"><i class="fas fa-plus"></i> Add Orders</a> --}}
                                    <a href="{{ route('new_orders') }}" style="background-color: #fafafa;" class="mail_mail-button" title="Add Contact">ADD NEW ORDER</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center people-table" id="people_orders_table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Order #</th>
                                                <th scope="col" class="text-center">Organization Name</th>
                                                <th scope="col" class="text-center">Sales Rep</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-right">Total ($)</th>
                                            </tr>
                                        </thead>

                                        <tbody class="list">
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td class="text-center"><a href="#" class="edit-order" data-value="{{$order->id}}">{{$order->order_no}}</a></td>
                                                    <td class="text-center">{{$order->organization_name}}</td>
                                                    <td class="text-center">{{$order->name}}</td>
                                                    <td class="text-center"><span style="width: 50%;
                                                        @if($order->status_name == 'Production') color:#47D6B6;background-color:#d7ffcc;
                                                        @elseif($order->status_name == 'Quote') color:#FFB916;background-color:#ffffcc;
                                                        @elseif($order->status_name == 'Canceled') color:#d65a47;background-color:#ffcccc;
                                                        @elseif($order->status_name == 'Fulfilled') color:#717070;background-color:#f8f8f8 @endif " class="badge badge-pill">{{$order->status_name}}</span></td>
                                                    <td class="text-right">{{number_format($order->order_total, 2)}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

<!-- ================================= Sales Orders ================================= -->
                        <div class="tab-pane fade" id="sales-orders" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            <div class="col-md-12 mt-3 card">

                                <div class="mt-3 mb-3 ml-auto">
                                    <a href="" class="mail_mail-button" style="background-color: #fafafa;" title="Add Sales Order"><i class="fas fa-plus"></i> Add Sales Order</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center table-responsive people-table" id="organizations_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Subject</th>
                                                <th scope="col">Contact Name</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Organization Name</th>
                                                <th scope="col">Assigned To</th>
                                                <th scope="col">Sales Order Number</th>
                                                <th scope="col">Quote Name</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" id="subject" name="subject"></td>
                                                <td></td>
                                                <td><input type="text" class="form-control" id="status" name="status"></td>
                                                <td></td>
                                                <td><input type="text" class="form-control" id="assigned_to" name="assigned_to"></td>
                                                <td><input type="text" class="form-control" id="sales_order_number" name="sales_order_number"></td>
                                                <td></td>
                                                <td><input type="text" class="form-control" id="total" name="total"></td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm" id="search" name="search">Search</button>
                                                </td>
                                            </tr>
                                        </thead>

                                        <tbody class="list"></tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

    <!-- ==================================== Invoices ===================================== -->
                        <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            <div class="col-md-12 mt-3 card">

                                <div class="mt-3 mb-3 ml-auto">
                                    <a href="" style="background-color: #fafafa;" class="mail_mail-button" title="Add Sales Order"><i class="fas fa-plus"></i> Add Invoice</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center table-responsive people-table" id="organizations_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Subject</th>
                                                <th scope="col">Contact Name</th>
                                                <th scope="col">Organization Name</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Assigned To</th>
                                                <th scope="col">Sales Order</th>
                                                <th scope="col">Invoice No</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" id="subject" name="subject"></td>
                                                <td></td>
                                                <td></td>
                                                <td><input type="text" class="form-control" id="status" name="status"></td>
                                                <td><input type="text" class="form-control" id="assigned_to" name="assigned_to"></td>
                                                <td></td>
                                                <td><input type="text" class="form-control" id="invoice_no" name="invoice_no"></td>
                                                <td><input type="text" class="form-control" id="total" name="total"></td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm" id="search" name="search">Search</button>
                                                </td>
                                            </tr>
                                        </thead>

                                        <tbody class="list"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

    <!-- ================================= Activities ====================================== -->
                        <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            <div class="col-md-12 mt-3 card">

                                <div class="mt-3 mb-3">
                                    <a href="" style="background-color: #fafafa;" class="mail_mail-button" title="Add Event"><i class="fas fa-plus"></i> Add Event</a>
                                    <a href="" style="background-color: #fafafa;" class="mail_mail-button" title="Add Task"><i class="fas fa-plus"></i> Add Task</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center table-responsive people-table" id="organizations_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Status</th>
                                                <th scope="col">Activity Type</th>
                                                <th scope="col">Subject</th>
                                                <th scope="col">Related To</th>
                                                <th scope="col">Start date &amp; Time</th>
                                                <th scope="col">Due Date</th>
                                                <th scope="col">Repeat</th>
                                                <th scope="col">Assigned To</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            <tr>
                                                <td><input type="text" class="form-control" id="status" name="status"></td>
                                                <td><input type="text" class="form-control" id="activity_type" name="activity_type"></td>
                                                <td><input type="text" class="form-control" id="subject" name="subject"></td>
                                                <td></td>
                                                <td><input type="text" class="form-control" id="start_date_time" name="start_date_time"></td>
                                                <td><input type="text" class="form-control" id="due_date" name="due_date"></td>
                                                <td><input type="text" class="form-control" id="repeat" name="repeat"></td>
                                                <td><input type="text" class="form-control" id="assigned_to" name="assigned_to"></td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm" id="search" name="search">Search</button>
                                                </td>
                                            </tr>
                                        </thead>

                                        <tbody class="list"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

    <!-- ================================== Emails =================================== -->
                        <div class="tab-pane fade" id="emails" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            <div class="col-md-12 mt-3 card">

                                <div class="mt-3 mb-3 ml-auto">
                                    <a href="" style="background-color: #fafafa;" class="mail_mail-button" title="Add Email"><i class="fas fa-plus"></i> Add Email</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center table-responsive people-table" id="organizations_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sender Name</th>
                                                <th scope="col">Subject</th>
                                                <th scope="col">Parent Record</th>
                                                <th scope="col">Date Sent</th>
                                                <th scope="col">Time Sent</th>
                                                <th scope="col">Assigned To</th>
                                                <th scope="col">Click Count</th>
                                                <th scope="col">Access Account</th>
                                                <th scope="col">Origin</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody class="list"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

    <!-- ================================= Documents ==================================-->
                        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            <div class="col-md-12 mt-3 card">

                                <div class="mt-3 mb-3 ml-auto">
                                    <a href="" style="background-color: #fafafa;" class="mail_mail-button" title="Select Document">SELECT FILE</a>
                                    <button type="button" style="background-color: #fafafa;padding: .38rem;" class="mail_mail-button" title="Customize" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">NEW FILE</button>
                                    <div class="dropdown-menu organiztions-dropdown-menu info-dropdown-menu">
                                        <a class="dropdown-item" href="#"><i class="fas fa-upload"></i>File Upload</a>
                                        <a class="dropdown-item" href="#">To Vtiger</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"><i class="fas fa-link"></i>Link External Document</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-external-link-alt"></i>From File URL</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"><i class="fas fa-file-alt"></i> Create New File</a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center people-table" id="organizations_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Folder Name</th>
                                                <th scope="col">Assigned To</th>
                                                <th scope="col">Modified Time</th>
                                                <th scope="col">File Name</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody class="list"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <input type="hidden" value="0" id="from_people_create_organizations"/>
</div>

@can('create people')
    @include('pages.contacts.people.people_create_modal')
@endcan

@can('add organizations')
    @include('pages.contacts.people.organization_create_modal')
@endcan

<script>
    var contact_organizations = <?php echo json_encode($contact_organizations) ?>;

    $(document).ready(function(){

        // $('select').select2();
        $('.select2-organization-modal').select2({
            dropdownParent: $('#organization_create_modal')
        });

        $('#new_organization_id').select2();

        $('.people-table').DataTable({"pageLength": 25});
        $('.select2-people').select2();

        $('.select2-people-modal').select2({
            dropdownParent: $('#people_create_modal')
        });

        $('body').on('submit', function(e){
            $(".se-pre-con").fadeIn('slow');
        });

    // Add People
        $('#add_people').click(function(){
            $('#people_create_modal').modal('show');
        });

    // Edit Order
        $("body").on("click", ".edit-order", function(){
            var orderId = $(this).data('value');
            window.location.replace('../../order_details/edit/'+orderId+'/order?active_tab=order');
        });

    // Update People
        // $("body").on("click", "#saveForm", function(){
            //     $('#people_update').submit();
        // });

        $("body").on("click", "#deletePeople", function(){
            var peopleId = $(this).val();

            var orderCount = $("#orderCount").val();

            if(orderCount == 0){

                swal({
                    title: "Confirm Delete?",
                    text: "Do You Want to Delete This Person?",
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
                        $(".se-pre-con").fadeIn('slow');
                        window.location.replace('../../people/delete/'+peopleId);
                    } else if(willDelete.dismiss == 'cancel') {
                        console.log('cancel');
                    }
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Can`t delete this contact',
                    text: 'There are some orders regarding with this contact.'
                })

            }
        });

        $('#organization_id_info').val(contact_organizations).trigger('change');

        $("#btn_add_people_organizations").on("click",function(){
            $("#from_people_create_organizations").val(1);
        });
    });

// Change Organization Image
    $('#logo_image').on('click', function(){
        $('#profile_pic').trigger('click');
    });

    function  uploadFile() {
        var image_preview = document.getElementById("image_preview");
        var file = document.querySelector("input[type=file]").files[0];

        var reader = new FileReader();
        reader.onloadend = function () {
            image_preview.src = reader.result;
            document.getElementById("base64").value = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            image_preview.src = "";

        }
    }
</script>

<script>
    function people_update_Submit(current_mail) {
        var emailInput = document.querySelector('.people-email-class-update');
        var email = emailInput.value;
        console.log(email);
        console.log(current_mail);
        var errorMessageSpan = document.getElementById('email-error-message');
        if (errorMessageSpan) {
            errorMessageSpan.parentNode.removeChild(errorMessageSpan);
        }
        // Check if the email is not empty
        if (email.trim() === '') {
            showErrorMessage('Email is required.', emailInput);

        }else if(email == current_mail )
        {
            submitForm();
        }
        else{
            // Check if the email already exists asynchronously
        $.ajax({
            url: '{{ url("people/checkemailexists") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: { email: email },
            dataType: 'json',
            success: function (response) {
                var errorMessageSpan = document.getElementById('email-error-message');

                if (response.exists) {
                    if (!errorMessageSpan) {
                        errorMessageSpan = document.createElement('span');
                        errorMessageSpan.id = 'email-error-message';
                        errorMessageSpan.className = 'text-danger';
                        errorMessageSpan.innerText = 'Email already exists. Please use a different email address.';
                        emailInput.parentNode.appendChild(errorMessageSpan);
                    }

                    // Prevent form submission when there's an error

                } else {
                    // Remove the error message if it exists
                    removeErrorMessage(errorMessageSpan);
                    // Proceed with form submission
                    submitForm();
                }
            },
            error: function () {
                showErrorMessage('Error checking email existence. Please try again.', emailInput);
                // Prevent form submission when there's an error

            }
        });

        // Prevent the default form submission
        return false;
        }


    }

    function removeErrorMessage(errorMessageSpan) {
        if (errorMessageSpan) {
            errorMessageSpan.parentNode.removeChild(errorMessageSpan);
        }
    }

    function showErrorMessage(message, targetElement) {
        var errorMessageSpan = document.createElement('span');
        errorMessageSpan.id = 'email-error-message';
        errorMessageSpan.className = 'text-danger';
        errorMessageSpan.innerText = message;

        // Append the error message span next to the target element
        targetElement.parentNode.appendChild(errorMessageSpan);
    }

    function submitForm() {
        document.getElementById('people_update').submit();
    }
</script>
@endsection
