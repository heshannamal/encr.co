@extends('layouts.app', ['activePage' => $active_page, 'titlePage' => __($title)])

@section('content')
<style>
    .organization_logo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
   #searchbox {
    width: 100%;
    height: 35px;
    padding: 0 8px;

    border: none;
    outline: none;
    background: transparent;

    color: #323232 !important;
    caret-color: #323232;

    font-size: 14px;
    margin-top: 0;
}

#searchbox::placeholder {
    color: #b3b3b3;
    opacity: 1;
}

#searchbox:focus {
    outline: none;
    box-shadow: none;
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
    .select2 {
        height: 1.8rem;
        border-radius: 5px !important;
        border: 1px solid #cad1d7 !important;
    }
    .select2-selection.select2-selection--single {
        height: 1.6rem !important;
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

    #customer_id{
        height: 70px !important;
    }

    #customer_id + .select2.select2-container{
        min-height: 60px !important;
    }
    .btns {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .button {
        background-color: #787878;
        width: 95%;
        height: 108%;
        border-radius: 0.125rem;
    }
    .btn-position {
        position: relative;
        top: 10px;
        right: -9px;
    }
    .contect-position {
        position: relative;
        top: -33px;
    }
    .btn-top {
        top: 11px;
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
    .btns-position {
        position: relative;
        right: 51px;
    }
    .alphabet {
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
    border-radius: 3px;
    padding: 5px;
  }
  .alphabet .filter-item {
    cursor: pointer;
    padding: 0px;
    margin: 0 5px;
    color: #b3b3b3;
  }
  .alphabet .filter-item.active {
    color: #000000;
  }
  @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
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
   .search_orga{
    width:200% !important;
   }
   .pagina001{
        flex-wrap: wrap;
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
        padding: 4%;
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
        padding: 4%;
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
        padding: 5%;
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
        padding: 5%;
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
        padding: 0%;
        padding-left: 6%;
    }
    .-layout{
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
    .-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .7rem;
        color: grey !important;
        border: unset;
        outline: unset;
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

    @media (max-width: 768px) {
    #organization_table_wrapper {
        display: none !important;
    }
}
.org-mobile-cards {
    display: none;
    padding: 10px;
}
.org-card {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 16px;
    margin-bottom: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.org-header h5 {
    margin: 0;
    font-size: 16px;
}
.org-header small {
    color: #777;
}
.org-body p {
    margin: 3px 0;
    font-size: 13px;
}
.org-footer {
    display: flex;
    justify-content: space-between;
    margin-top: 8px;
    font-size: 12px;
    color: #555;
    padding-top: 10px;
    border-top: 1px solid rgb(227, 227, 227);
}
    @media (min-width: 769px){
        .back_home_mobile {
            display:none !important;
        }
    }
/* MOBILE ONLY */
@media (max-width: 768px) {
    .org-mobile-cards {
        display: block;
        padding: unset;
    }
    .table-responsive {
        display: none;
    }
    .back_home_mobile {
        /* padding-bottom: 20px; */
        display: block !important;
    }
    .mobile_display_none {
        display: none;
    }
    .mobile_card_unset {
        background-color: transparent;
    }
    .mobile_filter_search_div_1 {
        margin-top: unset !important;
    }
    .mobile_rows_per_page {
        margin: 5px 0px;
        background-color: white;
        padding: 10px;
        border-radius: 10px;
        margin-left: .25rem !important;
        /* border: 1px solid var(--color-azure-84-2, #D1D5DB); */
    }
    .mobile_border_unset {
        border-bottom: unset !important;
    }
    .mobile_main_buttons {
        /* margin: 5px 0px; */
        padding: 5px 0px;
        border-radius: 6px;
        margin-left: .25rem !important;
        margin-right: unset !important;
    }
    .mobile_main_div_1 {
        padding: 0px 10px;
    }
    .mobile_csv_btn {
        width: 50%;
        padding-right: 10px;
    }
    .mobile_csv {
        height: auto !important;
        border-radius: 8px;
    }
    .mobile_table_layout_btn {
        display: none !important;
    }
    .selectbox-div {
        border: unset !important;
    }
    .mobile_margin_unset {
        margin-right: unset !important;
        margin-left: unset !important;
    }
    .mobile_table_padding {
        padding: unset;
    }
    .org-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        /* padding-bottom: 10px; */
        border-bottom: 1px solid rgb(233, 233, 233);
        margin-bottom: 10px;
    }
    .org-info {
        flex: 1;
        min-width: 0;
    }
    .org-info h5 {
        margin: 0;
    }
    .org-info p a{
        margin: 4px 0 0;
        font-size: 0.875rem;
        color: #0D9488;
        word-break: break-word;
    }
    .org-header small {
        flex-shrink: 0;
        white-space: nowrap;
        color: #000000;
        font-size: 0.875rem;
        padding: 5px 13px;
        background-color: rgb(240, 240, 240);
        border-radius: 15px;
    }
    .mobile_organizatin_name {
        color: black;
    }
    .org-body span,
    .org-body strong {
        display: block;
    }
    .org-body span {
        font-size: 12px;
        color: #000000;
        margin-bottom: 4px;
        font-weight: 700;
    }
    .org-body strong {
        font-size: 15px;
        font-weight: 600;
        color: rgb(154, 154, 154);
    }
    .mobile_padding_unset {
        padding: unset !important;
        padding-bottom: 15px !important;
    }
    .mobile_display_block {
        display: block;
    }
    /* Tax Status Badge */
    .tax-badge{
        display:inline-block;
        padding: 4px 15px;
        border-radius: 13px;
        font-size:12px;
        font-weight:600;
        color:#15803D;
    }
    .tax-active{
        background:#cfffe0; /* Green */
    }
    .tax-inactive{
        background:#ef4444; /* Red */
    }
    /* Date Labels */
    .label-text{
        color:#9ca3af;
        font-size:11px;
        font-weight:500;
    }
    .value-text{
        color:#111827;
        font-size:12px;
        font-weight:600;
    }
    /* Info Button */
    .info-btn{
        display: inline-block;
        padding: 7px 12px;
        background: #EFF6FF;
        color: #2563EB !important;
        text-decoration: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        transition: all .25s ease;
        border: 1px solid #BFDBFE;
        width: 100%;
        text-align: center;
    }
    .info-btn:hover{
        background:#1d4ed8;
        color:#fff !important;
        text-decoration:none;
    }
    .contect-position {
        top: 0px;
    }
    .mobile_rows_per_page_2 {
        background-color: transparent;
        padding: 5px 10px;
        border-radius: 7px;
        text-align: right;
    }
    .mobile_per_row {
        display: none;
    }
}

</style>

<div class="container-fluid mb-5 contect-position">
    {{-- <div class="se-pre-con"></div> --}}

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection
    @section('order-header')
        @if( $active_page == 'organizations_customers') CUSTOMERS @else LEADS @endif
    @endsection

    @section('back-btn-Mobile')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">< BACK TO HOME</a>
    @endsection

    <div class="col-md-12 back_home_mobile">
        <strong>
            @yield('back-btn-Mobile')
        </strong>
    </div>

    <div class="col-md-12 mt-4 mobile_display_none">
        {{-- <div class="row">
            <div class="col-md-2 ml-auto text-right">
                @can('add organizations')
                    <button class="btn-green-filled" style="outline: unset;width:70%;margin-right: 1.2rem;" href="#" id="add_organization" title="Add Organization">
                        ADD ORG&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                @endcan
            </div>
        </div> --}}
        {{-- <div class="card" style="display: none">
            <div class="row">
                <div class="col-md-4" ></div>
                <div class="col-md-4 div_display"></div>
                <div class="col-md-4">
                    <input type="text" id="searchbox" placeholder="Organization Search" style="width: 90%;margin-right: 20px; border-color: #787878; border-radius: 4px; position: relative; top: -5px; color: #787878;" class="search_orga">

                    <div class="row btn-position">
                        <div class="col-md-3 btns">
                            @can('add organizations')
                                <div class="button">
                                    <span>
                                        <a href="#" id="add_organization"  style="color:#ffffff; position: relative; top: -1px; left: 7px;">
                                            <i class="fas fa-solid fa-plus fa-fade" style=" font-size: 11px;">   Organization</i>
                                        </a>
                                    </span>
                                </div>
                            @endcan
                        </div>
                        <div class="col-md-3 btns">
                                <div class="button">
                                    <span>
                                        <a  style="color:#ffffff; position: relative; top: -1px; left: 13px;" href="#" data-toggle="modal" data-target="#layout_modal">
                                            <i class="fas " style="font-size: 11px">Table Layout</i>
                                        </a>
                                    </span>
                                </div>
                        </div>
                        <div class="col-md-3 btns">
                            @can('export organizations')
                                <div class="button">
                                    <span>
                                        <a  style="color:#ffffff; position: relative; top: -1px; left: 22px;" href="#" id="export_csv" data-href="{{ route('organizations.export_csv') }}" onclick="exportTasks(event.target);">
                                            <i class="fas fa-file-csv" style=" font-size: 11px;">   Export</i>
                                        </a>
                                    </span>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    {{-- <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 btns-position btn_set">
                <div class="row div_align ">
                    <div class="col-md-3 div_display"></div>
                    <div class="col-md-3 btns-padding ">
                        @can('add organizations')
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" id="add_organization" title="Add Organization">
                                Add Organization
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3 btns-padding">
                        @can('export organizations')
                            <button class="btns-text btns-style btns-card" title="Export CSV" style="outline: unset;" onclick="exportReport()">
                               CSV Export
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3 btns-padding">
                        <button class="btns-text btns-style btns-card" title="Change Table Layout" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal">
                            Table Layout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-md-12 mobile_main_div_1">
        <div class="card mobile_card_unset" style="border-radius: 0rem">
            <div class="card-body" style="padding: 0">
                <div class="row mt-3 mobile_filter_search_div_1 mobile_margin_unset">
                    <div class="col-lg-3 mt-1 ml-1 row align-items-center mobile_rows_per_page mobile_rows_per_page_2">
                        <div class="col-lg-8 col-7 mobile_per_row" style="font-size: .8rem;color:#B3B3B3;font-weight: 500;">
                            Show rows per page
                        </div>
                        <div class="col-lg-4 col-12 selectbox-div">
                            <select class="dropdown-style-grey" name="row_per_page" id="row_per_page">
                                <option value="50">50</option>
                                <option value="75">75</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 mobile_rows_per_page ml-auto">
                        <div class="row">
                            <div class="col-lg-1 col-1 mobile_border_unset" style="border-bottom: 1px solid #B3B3B3;">
                                <i class="fa fa-search" aria-hidden="true" style="font-size: 19px;color: #B3B3B3;top: 23%;position: relative;"></i>
                            </div>
                            <div class="col-lg-10 col-10 mobile_border_unset text-center" style="border-bottom: 1px solid #B3B3B3;">
                                <input class="searchbox-layout"  type="text" id="searchbox" placeholder="@if( $active_page == 'organizations_customers') Search Customers @else Search Leads @endif">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ml-auto mr-3 mobile_main_buttons">
                        <table style="width: 100%;" class="btn-inside-table">
                            <tr>
                                <td class="mobile_table_layout_btn"></td>
                                <td class="mobile_csv_btn">
                                    @can('add orders')
                                        <button class="btn-grey-text mobile_csv" data-type="{{ $active_page }}" title="Export CSV" style="outline: unset;" onclick="exportReport(this)">
                                            CSV Export
                                        </button>
                                    @endcan
                                </td>
                                <td class="mobile_table_layout_btn">
                                    @can('view team store orders')
                                        <button class="btn-grey-filled" data-toggle="modal" data-target="#layout_modal">
                                            Table Layout
                                        </button>
                                    @endcan
                                </td>
                                <td>
                                    @can('add organizations')
                                        <button class="btn-green-filled mobile_csv" style="outline: unset;width:70%;margin-right: 1.2rem;" href="#" id="add_organization" title="Add Organization">
                                            @if( $active_page == 'organizations_customers')ADD ORG @else ADD LEAD @endif&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 mt-3 mobile_table_padding">
                    <div class="table-responsive">
                        <div id="alphabet-filter"></div>


                        <table class="table align-items-center table-responsive" style="display: table;" id="organization_table">
                            <thead style="background-color: #717070; color:white" class="header-style">
                                <th scope="col" class="organization-name">Organization Name</th>
                                <th scope="col" class="website">Website</th>
                                <th scope="col" class="email">Email</th>
                                <th scope="col" class="sport">Sport</th>
                                <th scope="col" class="user-id">Sales Rep</th>
                                <th scope="col" class="size-of-club">Size of Club</th>
                                <th scope="col" class="colors">Colors</th>
                                <th scope="col" class="shipping-street"> Street</th>
                                <th scope="col" class="shipping-city"> City</th>
                                <th scope="col" class="shipping-state"> State</th>
                                <th scope="col" class="shipping-postal-code"> Postal Code</th>
                                <th scope="col" class="shipping-country"> Country</th>
                                <th scope="col" class="sales-tax">Sales Tax</th>
                                <th scope="col" class="sales-tax-active">Sales Tax Status</th>
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>

                            {{-- {{dd($organizations)}} --}}

                            <tbody style="rgba(50, 50, 50, 1)">
                                @foreach ($organizations as $organization)
                                    <tr>
                                        <td class="organization-name" style="font-weight: 600;"><a href="{{ route('organizations.info', ['id' => $organization->id]) }}" style="color: rgba(50, 50, 50, 1) !important" class="info" data-value="{{$organization->id}}">{{$organization->organization_name}}</a></td>
                                        <td class="website">{{$organization->website}}</td>
                                        <td class="email">{{$organization->email}}</td>
                                        <td class="sport">{{$organization->sport}}</td>
                                        <td class="user-id">{{$organization->name}}</td>
                                        <td class="size-of-club text-center">{{$organization->size_of_club}}</td>
                                        <td class="colors">{{$organization->colors}}</td>
                                        <td class="shipping-street">{{$organization->shipping_street}}</td>
                                        <td class="shipping-city">{{$organization->shipping_city}}</td>
                                        <td class="shipping-state">{{$organization->shipping_state}}</td>
                                        <td class="shipping-postal-code">{{$organization->shipping_postal_code}}</td>
                                        <td class="shipping-country">{{$organization->shipping_country}}</td>
                                        <td class="sales-tax text-right">{{$organization->sales_tax}}</td>
                                        <td class="sales-tax-active text-center">@if ($organization->sales_tax_active ) Yes @else No @endif</td>
                                        <td class="created-at">{{$organization->created_at->format('m-d-Y')}}</td>
                                        <td class="updated-at">{{$organization->updated_at->format('m-d-Y')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="org-mobile-cards">
                        @foreach ($organizations as $organization)
                            <div class="org-card">
                                <div class="org-header">
                                    <div class="org-info">
                                        <h5>
                                            <a class="mobile_organizatin_name" href="{{ route('organizations.info', ['id' => $organization->id]) }}">
                                                {{ $organization->organization_name }}
                                            </a>
                                        </h5>
                                        @php
                                            $website = trim($organization->website);
                                            $url = preg_match('/^https?:\/\//i', $website)
                                                ? $website
                                                : 'https://' . $website;
                                        @endphp

                                        <p>
                                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">
                                                {{ $website }}
                                            </a>
                                        </p>
                                    </div>

                                    <small>{{ $organization->sport }}</small>
                                </div>

                                <div class="org-body">
                                    <div class="row" style="margin: unset;">
                                        <div class="col-6 mobile_padding_unset">
                                            <span>SALES REP</span>
                                            <strong>{{ $organization->name ?? '-'  }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <span>SIZE OF CLUB</span>
                                            <strong>{{$organization->size_of_club ?? '-' }}</strong>
                                        </div>
                                        <div class="col-6 mobile_padding_unset">
                                            <span>CITY</span>
                                            <strong>{{$organization->shipping_city ?? '-' }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <span>STATE</span>
                                            <strong>{{$organization->shipping_state ?? '-' }}</strong>
                                        </div>
                                        <div class="col-6 mobile_padding_unset">
                                            <span> POSTAL CODE</span>
                                            <strong>{{$organization->shipping_postal_code ?? '-' }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <span> COUNTRY</span>
                                            <strong>{{$organization->shipping_country ?? '-' }}</strong>
                                        </div>
                                        <div class="col-6 mobile_padding_unset">
                                            <span> COLORS</span>
                                            <strong>{{$organization->colors ?? '-' }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <span>SALES TAX</span>
                                            <strong>{{$organization->sales_tax ?? '-' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="org-footer">
                                    <div class="row" style="margin: unset; width: 100%;">

                                        <div class="col-3 mobile_padding_unset">
                                            <span class="mobile_display_block text-muted">TAX STATUS</span>

                                            @if($organization->sales_tax_active)
                                                <span class="tax-badge tax-active">Yes</span>
                                            @else
                                                <span class="tax-badge tax-inactive">No</span>
                                            @endif
                                        </div>

                                        <div class="col-6 mobile_padding_unset">
                                            <div>
                                                <span class="label-text">Created:</span>
                                                <span class="value-text">{{ $organization->created_at->format('m-d-Y') }}</span>
                                            </div>

                                            <div>
                                                <span class="label-text">Updated:</span>
                                                <span class="value-text">{{ $organization->updated_at->format('m-d-Y') }}</span>
                                            </div>
                                        </div>

                                        <div class="col-3 mobile_padding_unset text-end">
                                            <a href="{{ route('organizations.info', ['id' => $organization->id]) }}"
                                            class="info-btn">
                                                Info
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="col-md-12 mt-2">
                    <div style="float: right">
                        {{ $organizations->onEachSide(5)->withQueryString()->links('layouts.paginationlinks') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Organizations Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Organizations Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{$organizationLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="organization_name" name="organization_name" title="Organization Name" @isset($organizationLayout) @if ($organizationLayout['organization_name'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="organization_name">Organization Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="website" name="website" title="Website" @isset($organizationLayout) @if ($organizationLayout['website'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="website">Website</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="email" title="Email" @isset($organizationLayout) @if ($organizationLayout['email'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="email">Email</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="sport" title="Sport" @isset($organizationLayout) @if ($organizationLayout['sport'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="sport">Sport</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="user_id" title="Sales Rep" @isset($organizationLayout) @if ($organizationLayout['user'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="user_id">Sales Rep</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="size_of_club" title="Size of Club" @isset($organizationLayout) @if ($organizationLayout['size_of_club'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="size_of_club">Size of Club</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="colors" title="Colors" @isset($organizationLayout) @if ($organizationLayout['colors'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="colors">Colors</label>
                            </div>
                        </div>

                        {{-- <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="organization_logo" title="Organization Logo" @isset($organizationLayout) @if ($organizationLayout['organization_logo'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="organization_logo">Organization Logo</label>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="shipping_street" title="Shipping PO Box" @isset($organizationLayout) @if ($organizationLayout['shipping_street'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="shipping_street"> Street</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="shipping_city" title="Shipping City" @isset($organizationLayout) @if ($organizationLayout['shipping_city'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="shipping_city"> City</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="shipping_state" title="Shipping State" @isset($organizationLayout) @if ($organizationLayout['shipping_state'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="shipping_state"> State</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="shipping_postal_code" title="Shipping Postal Code" @isset($organizationLayout) @if ($organizationLayout['shipping_postal_code'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="shipping_postal_code"> Postal Code</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="shipping_country" title="Shipping Country" @isset($organizationLayout) @if ($organizationLayout['shipping_country'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="shipping_country"> Country</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="sales_tax" title="Sales Tax" @isset($organizationLayout) @if ($organizationLayout['sales_tax'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="sales_tax">Sales Tax</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="sales_tax_active" title="Sales Tax Status" @isset($organizationLayout) @if ($organizationLayout['sales_tax_active'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="sales_tax_active">Sales Tax Status</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" title="Created At" @isset($organizationLayout) @if ($organizationLayout['created'] == 1) checked @endif @endisset />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" title="Updated At" @isset($organizationLayout) @if ($organizationLayout['updated'] == 1) checked @endif @endisset />
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

@include('pages.contacts.organizations.organization_create_modal')
@include('pages.contacts.organizations.people_create_modal')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    //Alphabet filter
    document.addEventListener('DOMContentLoaded', function() {
      var alphabetLetters = Array.from(Array(26)).map((_, i) => String.fromCharCode(65 + i));

      var alphabetFilter = document.getElementById('alphabet-filter');
      alphabetFilter.innerHTML = '';
      var alphabetBox = document.createElement('div');
      alphabetBox.classList.add('alphabet');

      var allFilterItem = document.createElement('span');
      allFilterItem.textContent = 'All';
      allFilterItem.classList.add('filter-item');
      alphabetBox.appendChild(allFilterItem);

      alphabetLetters.forEach(function(letter) {
        var filterItem = document.createElement('span');
        filterItem.textContent = letter;
        filterItem.classList.add('filter-item');
        alphabetBox.appendChild(filterItem);
      });

      alphabetFilter.appendChild(alphabetBox);

      var filterItems = document.querySelectorAll('.filter-item');
      filterItems.forEach(function(item) {
        item.addEventListener('click', function() {
          filterItems.forEach(function(filterItem) {
            filterItem.classList.remove('active');
          });

          item.classList.add('active');

          var filterText = item.textContent;

          var rows = document.querySelectorAll('#organization_table tbody tr');

          rows.forEach(function(row) {
            var organizationNameCell = row.querySelector('.organization-name');
            var organizationName = organizationNameCell.textContent.trim();

            if (filterText === 'All' || organizationName.charAt(0).toUpperCase() === filterText) {
              row.style.display = '';
            } else {
              row.style.display = 'none';
            }
          });
        });
      });
    });
</script>


<script type="text/javascript" charset="utf-8">
    var searchIdx = '';

    $(document).ready(function() {
         $(document).on('keydown', '#searchbox', function (event) {
        console.log('Search key pressed:', event.key);

        if (event.key !== 'Enter' && event.keyCode !== 13) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        const searchValue = $(this).val().trim();

        console.log('Searching:', searchValue);

        setUrlParameter(searchValue);

        return false;
    });
    $('#searchbox').on('blur', function () {
        const currentSearch = getUrlParameter('org') || '';
        const newSearch = $(this).val().trim();

        if (currentSearch !== newSearch) {
            setUrlParameter(newSearch);
        }
    });
     function setUrlParameter(orgTxt){
        var type = @json($active_page);
        var params = {'org': orgTxt, 'type': type};
        var new_url = '{{ route("organizations")}}?' + jQuery.param(params);
        window.history.pushState('page2', 'Title', new_url);
        location.reload();
    }

        $(document).ready(function() {
            var allowClose = false;
            $('#organization_create_modal').on('hide.bs.modal', function(e) {
                var hasValue = false;
                if (allowClose) {
                    allowClose = false;
                    return true;
                }
                $('#organization_create_modal').find('input, select').each(function() {
                    if ($(this).attr('name') !== '_token') {
                        if ($(this).is('select')) {
                            if ($(this).val() && $(this).val().length > 0) {
                                hasValue = true;
                                return false;
                            }
                        } else if ($(this).val() && $(this).val() !== '') {
                            hasValue = true;
                            return false;
                        }
                    }
                })
                console.log(hasValue);
                if (hasValue) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Your changes are not saved, do you want to close?",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'No, keep editing',
                        cancelButtonText: 'Yes, close it!'
                    }).then((result) => {
                        if (result.dismiss == 'cancel') {
                            allowClose = true;
                            $('#organization_create_modal').modal('hide');
                        }
                    });
                }
            });
        });

        if(getUrlParameter('org')){
            $('#searchbox').val(getUrlParameter('org'));
        }

        // $('select').select2();
        $('.select2-add-remove-people').select2({
            dropdownParent: $('#add_remove_contacts_modal')
        });

        $('.select2-organization-modal').select2({
            dropdownParent: $('#organization_create_modal')
        });

        // Organization Table Layout
        tableLayout();

        // change columns
        var organizationTable = $('#organization_table').DataTable({
            colReorder: true,
            stateSave: true,
            "autoWidth": false,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search'
            },
            "pageLength": 50,
            "columnDefs": [{
                "searchable": false,
                "targets": ["website", "email", "sport", "user-id", "size-of-club", "colors", "shipping-street", "shipping-city", "shipping-state", "shipping-postal-code", "shipping-country", "sales-tax", "sales-tax-active", "created-at", "updated-at"]
            }],
            "paging":   false,
            "info":     false,
            searching: false,
        });

        searchIndex();

        // save column order when move
        organizationTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_organization_table_/organizations");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Organization';
            var interface_id = 2;
            console.log(column_order);

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                },
                success: function(data) {
                    console.log(data);
                    searchIndex();
                }
            });
        });

        var columnId = $('#column_layout_id').val();

        if(columnId == 0){
            // save column order
            var columnStr = localStorage.getItem("DataTables_organization_table_/organizations");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'Organization';
            var interface_id = 2;
            console.log(column_order);

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                },
                success: function(data) {
                    console.log(data);
                    if (window.location.href.indexOf('reload')==-1) {
                        window.location.replace(window.location.href+'?reload');
                    }
                }
            });

        } else {
            // refresh column order according to user
            var interfaceId = 2;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);
                    var columnStr = localStorage.getItem("DataTables_organization_table_/organizations");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_organization_table_/organizations', JSON.stringify(columnObj));
                }
            });
        }





        // View Organization
        $("body").on("click", ".info", function(){
            var organizationId = $(this).data('value');
            window.location.replace("organizations/info/"+organizationId);
        });

        $('#customCheck1').on('change', function(){
            if(this.checked == true){
                $('.check-people').prop('checked', true)
            }
            if(this.checked == false){
                $('.check-people').prop('checked', false)
            }
        });

        $('body').on('change', '.check-people', function(){
            var unchecked = $(".check-people:not(:checked)");
            if(unchecked.length == 0){
                $('#customCheck1').prop('checked', true);
            } else {
                $('#customCheck1').prop('checked', false);
            }
        });

        $('#add_organization').click(function(){
            $('#customer_id').val('');
            $('#organization_create_modal').modal('show');
        });

        $('#organization_name').on('change', function(){ tableLayout(); });
        $('#website').on('change', function(){ tableLayout(); });
        $('#email').on('change', function(){ tableLayout(); });
        $('#sport').on('change', function(){ tableLayout(); });
        $('#user_id').on('change', function(){ tableLayout(); });
        $('#size_of_club').on('change', function(){ tableLayout(); });
        $('#colors').on('change', function(){ tableLayout(); });
        $('#shipping_street').on('change', function(){ tableLayout(); });
        $('#shipping_city').on('change', function(){ tableLayout(); });
        $('#shipping_state').on('change', function(){ tableLayout(); });
        $('#shipping_postal_code').on('change', function(){ tableLayout(); });
        $('#shipping_country').on('change', function(){ tableLayout(); });
        $('#sales_tax').on('change', function(){ tableLayout(); });
        $('#sales_tax_active').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var organization_name = $('#organization_name').val();
        var website = $('#website').val();
        var email = $('#email').val();
        var sport = $('#sport').val();
        var user_id = $('#user_id').val();
        var size_of_club = $('#size_of_club').val();
        var colors = $('#colors').val();
        var shipping_street = $('#shipping_street').val();
        var shipping_city = $('#shipping_city').val();
        var shipping_state = $('#shipping_state').val();
        var shipping_postal_code = $('#shipping_postal_code').val();
        var shipping_country = $('#shipping_country').val();
        var sales_tax = $('#sales_tax').val();
        var sales_tax_active = $('#sales_tax_active').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#organization_name').is(':checked')) {
            $('.organization-name').css('display', 'table-cell');
            organization_name = 1;
        } else {
            $('.organization-name').css('display', 'none');
            organization_name = 0;
        }

        if($('#website').is(':checked')) {
            $('.website').css('display', 'table-cell');
            website = 1;
        } else {
            $('.website').css('display', 'none');
            website = 0;
        }

        if($('#email').is(':checked')) {
            $('.email').css('display', 'table-cell');
            email = 1;
        } else {
            $('.email').css('display', 'none');
            email = 0;
        }

        if($('#sport').is(':checked')) {
            $('.sport').css('display', 'table-cell');
            sport = 1;
        } else {
            $('.sport').css('display', 'none');
            sport = 0;
        }

        if($('#user_id').is(':checked')) {
            $('.user-id').css('display', 'table-cell');
            user_id = 1;
        } else {
            $('.user-id').css('display', 'none');
            user_id = 0;
        }

        if($('#size_of_club').is(':checked')) {
            $('.size-of-club').css('display', 'table-cell');
            size_of_club = 1;
        } else {
            $('.size-of-club').css('display', 'none');
            size_of_club = 0;
        }

        if($('#colors').is(':checked')) {
            $('.colors').css('display', 'table-cell');
            colors = 1;
        } else {
            $('.colors').css('display', 'none');
            colors = 0;
        }

        if($('#shipping_street').is(':checked')) {
            $('.shipping-street').css('display', 'table-cell');
            shipping_street = 1;
        } else {
            $('.shipping-street').css('display', 'none');
            shipping_street = 0;
        }

        if($('#shipping_city').is(':checked')) {
            $('.shipping-city').css('display', 'table-cell');
            shipping_city = 1;
        } else {
            $('.shipping-city').css('display', 'none');
            shipping_city = 0;
        }

        if($('#shipping_state').is(':checked')) {
            $('.shipping-state').css('display', 'table-cell');
            shipping_state = 1;
        } else {
            $('.shipping-state').css('display', 'none');
            shipping_state = 0;
        }

        if($('#shipping_postal_code').is(':checked')) {
            $('.shipping-postal-code').css('display', 'table-cell');
            shipping_postal_code = 1;
        } else {
            $('.shipping-postal-code').css('display', 'none');
            shipping_postal_code = 0;
        }

        if($('#shipping_country').is(':checked')) {
            $('.shipping-country').css('display', 'table-cell');
            shipping_country = 1;
        } else {
            $('.shipping-country').css('display', 'none');
            shipping_country = 0;
        }

        if($('#sales_tax').is(':checked')) {
            $('.sales-tax').css('display', 'table-cell');
            sales_tax = 1;
        } else {
            $('.sales-tax').css('display', 'none');
            sales_tax = 0;
        }

        if($('#sales_tax_active').is(':checked')) {
            $('.sales-tax-active').css('display', 'table-cell');
            sales_tax_active = 1;
        } else {
            $('.sales-tax-active').css('display', 'none');
            sales_tax_active = 0;
        }

        if($('#created_at').is(':checked')) {
            $('.created-at').css('display', 'table-cell');
            created_at = 1;
        } else {
            $('.created-at').css('display', 'none');
            created_at = 0;
        }

        if($('#updated_at').is(':checked')) {
            $('.updated-at').css('display', 'table-cell');
            updated_at = 1;
        } else {
            $('.updated-at').css('display', 'none');
            updated_at = 0;
        }

        $.ajax({
            url: '{{ url("organizations/layout") }}',
            type: "POST",
            data: {
                'layout_id':layout_id, 'organization_name':organization_name, 'website':website, 'email':email, 'sport':sport, 'user_id':user_id,
                'size_of_club':size_of_club, 'colors':colors, 'shipping_street':shipping_street,
                'shipping_city':shipping_city, 'shipping_state':shipping_state, 'shipping_postal_code':shipping_postal_code, 'shipping_country':shipping_country,
                'sales_tax':sales_tax, 'sales_tax_active':sales_tax_active, 'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
            },
            success: function (data) {
                console.log(data);
                if(data == '"Saved"') {
                    window.location.reload(true);
                }
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
                // if(window.location.search.substr(1) == "reload")
                // {
                //     $(".se-pre-con").fadeOut('slow');
                // }
            }
        });
    }

    $('#layout_modal').on('hidden.bs.modal', function () {
        $(".se-pre-con").fadeIn('slow');
        window.location.reload(true);
    });



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

    function searchIndex(){
        $('#organization_table thead th').each(function(){
            if($(this).text() == 'Organization Name') {
                searchIdx = $('#organization_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

//Export CSV
    function exportTasks(_this) {
        let _url = $(_this).data('href');
        window.location.href = _url;
    }
    function exportReport(button) {
        const type = button.getAttribute('data-type');
        const organizationName = $('#organization_search').val() || '';

        const params = new URLSearchParams();

        if (type) {
            params.set('type', type);
        }

        if (organizationName.trim() !== '') {
            params.set('org', organizationName.trim());
        }

        const exportUrl = "{{ route('organizations.export_csv') }}";

        window.location.href = exportUrl + '?' + params.toString();
    }
</script>
@endsection
