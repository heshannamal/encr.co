@php
    /*
    |--------------------------------------------------------------------------
    | Blade-only lazy tab rows
    |--------------------------------------------------------------------------
    | This uses the current page URL as the AJAX endpoint, so no route or
    | controller change is required. The controller still supplies the same
    | variables; only the requested table rows are rendered by this Blade.
    */
    $lazyOrganizationTab = request()->ajax()
        ? request()->query('lazy_tab')
        : null;
@endphp

@if ($lazyOrganizationTab === 'contacts')
    @foreach ($contacts as $contact)
        <tr>
            <td class="text-center"><a href="#" class="edit-contact" data-value="{{ $contact->id }}">{{ $contact->first_name }}</a></td>
            <td class="text-center"><a href="#" class="edit-contact" data-value="{{ $contact->id }}">{{ $contact->last_name }}</a></td>
            <td class="text-center">{{ $contact->phone_no }}</td>
            <td class="text-center">{{ $contact->email }}</td>
            <td class="text-center">{{ $contact->title }}</td>
            <td class="text-center">{{ $contact->name }}</td>
            <td class="text-center">{{ $contact->shipping_city }}</td>
            <td class="text-center">{{ $contact->shipping_country }}</td>
        </tr>
    @endforeach
    @php return; @endphp
@endif

@if ($lazyOrganizationTab === 'orders')
    @foreach ($orders as $order)
        <tr>
            <td class="text-center"><a href="#" class="edit-order" data-value="{{ $order->id }}">{{ $order->order_no }}</a></td>
            <td class="text-center">{{ $order->name }}</td>
            <td class="text-right">{{ number_format($order->order_total, 2) }}</td>
            <td class="text-center">
                <span
                    class="badge badge-pill"
                    style="width: 50%;
                        @if($order->status_name == 'Production') color:#47D6B6;background-color:#d7ffcc;
                        @elseif($order->status_name == 'Quote') color:#FFB916;background-color:#ffffcc;
                        @elseif($order->status_name == 'Canceled') color:#d65a47;background-color:#ffcccc;
                        @elseif($order->status_name == 'Fulfilled') color:#717070;background-color:#f8f8f8;
                        @endif"
                >
                    {{ $order->status_name }}
                </span>
            </td>
            <td class="text-center" data-order="{{ \Carbon\Carbon::parse($order->due_date)->format('Y-m-d') }}">
                {{ \Carbon\Carbon::parse($order->due_date)->format('m/d/Y') }}
            </td>
        </tr>
    @endforeach
    @php return; @endphp
@endif

@if ($lazyOrganizationTab === 'emails')
    @foreach ($orgnizationEmails as $orgnizationEmail)
        <tr>
            <td class="sender-name">{{ $orgnizationEmail->sender }}</td>
            <td class="email-subject">{{ $orgnizationEmail->subject }}</td>
            <td class="email-type">{{ $orgnizationEmail->type }}</td>
            <td class="email-date-sent" data-order="{{ \Carbon\Carbon::parse($orgnizationEmail->date)->format('Y-m-d') }}">
                {{ \Carbon\Carbon::parse($orgnizationEmail->date)->format('m/d/Y') }}
            </td>
            <td class="email-time-sent">{{ \Carbon\Carbon::parse($orgnizationEmail->date)->format('H:i:s') }}</td>
            <td class="email-action">
                <a data-org_email_id="{{ $orgnizationEmail }}" class="view-email" style="cursor: pointer">View</a>
            </td>
        </tr>
    @endforeach
    @php return; @endphp
@endif

@extends('layouts.app', ['activePage' => $orders->count() > 0 ? 'organizations_customers' : 'organizations_leads','titlePage' => $orders->count() > 0 ? __('Customers') : __('Leads')])


@section('content')

<style>
    .btn-green-filled{
        outline: unset !important;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        padding: .4rem;
        padding-left: 1rem;
        padding-right: 1rem;
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
        display: block;
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

    .organization-navbar .nav-link{
        color: grey !important;
        border-bottom: 2px solid #70717171 !important;
        font-size: .7rem;
    }

    .styled-nav-item .nav-link.active , .styled-nav-item .nav-link:hover {
        color: black !important;
        border-bottom: 2px solid black !important;
        font-size: .7rem;
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
    .mail_mail-button_2:hover{
        background: #f3f4f6;
        border-color: #9ca3af;
        color: #374151;
    }
    .mail_mail-button_2{
        background: none;
        border: 1px solid #d1d5db;
        border-radius: 5px;
        color: #6b7280;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
        padding: 8.6px 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 7px;
        transition: background .12s, border-color .12s, color .12s;
        white-space: nowrap;
        margin: 2px;
        height: stretch;
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
    .organization-unique-styles table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .organization-unique-styles table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .organization-unique-styles table thead tr{
        background-color: rgba(50, 50, 50, 1);
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .organization-unique-styles table tr{
        background-color: white;
        color: rgba(22, 22, 23, 1);
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .organization-unique-styles th, .organization-unique-styles td {
        padding: 10px;
    }
    .organization-unique-styles .dataTables_info {
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
    .select2-selection__rendered {
        color: #717070 !important;
        border: none;
    }
    .select2 {
        border: 1px #e4e4e4b8 solid !important;
    }
    .activity-bar-new-tab-bar{
        color: grey !important;
        border: none;
        font-size: .9rem;
        background-color: transparent;
        width: 5rem;
        font-weight: 600;
    }
    .activity-bar-new-tab-bar:hover , .activity-bar-new-tab-bar.active{
        color: black !important;
        border-bottom: 2px solid black !important;
        width: 5rem;
    }
    .swal2-actions button.swal2-styled {
        border-radius: 0rem !important;
        padding: .3rem 1.5rem !important;
        font-size: .9rem !important;
    }

    /* timeline */

.cbp_tmtimeline {
    margin: 0;
    padding: 0;
    list-style: none;
    position: relative
}

.cbp_tmtimeline:before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 3px;
    background: #eee;
    left: 20%;
    margin-left: -6px
}

.cbp_tmtimeline>li {
    position: relative
}

.cbp_tmtimeline>li:first-child .cbp_tmtime span.large {
    color: #444;
    font-size: 17px !important;
    font-weight: 700
}

.cbp_tmtimeline>li:first-child .cbp_tmicon {
    background: #fff;
    color: #666
}

.cbp_tmtimeline>li:nth-child(odd) .cbp_tmtime span:last-child {
    color: #444;
    font-size: 13px
}

.cbp_tmtimeline>li:nth-child(odd) .cbp_tmlabel {
    background: #f0f1f3
}

.cbp_tmtimeline>li:nth-child(odd) .cbp_tmlabel:after {
    border-right-color: #f0f1f3
}

.cbp_tmtimeline>li .empty span {
    color: #777
}

.cbp_tmtimeline>li .cbp_tmtime {
    display: block;
    width: 24%;
    padding-right: 70px;
    position: absolute
}

.cbp_tmtimeline>li .cbp_tmtime span {
    display: block;
    text-align: right
}

.cbp_tmtimeline>li .cbp_tmtime span:first-child {
    font-size: 12px;
    color: #3d4c5a;
    font-weight: 700
}

.cbp_tmtimeline>li .cbp_tmtime span:last-child {
    font-size: 14px;
    color: #444
}

.cbp_tmtimeline>li .cbp_tmlabel {
    margin: 0 0 15px 25%;
    background: #f0f1f3;
    padding: 1.2em;
    position: relative;
    border-radius: 5px
}

.cbp_tmtimeline>li .cbp_tmlabel:after {
    right: 100%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-right-color: #f0f1f3;
    border-width: 10px;
    top: 10px
}

.cbp_tmtimeline>li .cbp_tmlabel blockquote {
    font-size: 16px
}

.cbp_tmtimeline>li .cbp_tmlabel .map-checkin {
    border: 5px solid rgba(235, 235, 235, 0.2);
    -moz-box-shadow: 0px 0px 0px 1px #ebebeb;
    -webkit-box-shadow: 0px 0px 0px 1px #ebebeb;
    box-shadow: 0px 0px 0px 1px #ebebeb;
    background: #fff !important
}

.cbp_tmtimeline>li .cbp_tmlabel h2 {
    margin: 0px;
    padding: 0 0 10px 0;
    line-height: 26px;
    font-size: 16px;
    font-weight: normal
}

.cbp_tmtimeline>li .cbp_tmlabel h2 a {
    font-size: 15px
}

.cbp_tmtimeline>li .cbp_tmlabel h2 a:hover {
    text-decoration: none
}

.cbp_tmtimeline>li .cbp_tmlabel h2 span {
    font-size: 15px
}

.cbp_tmtimeline>li .cbp_tmlabel p {
    color: #444
}

.cbp_tmtimeline>li .cbp_tmicon {
    width: 40px;
    height: 40px;
    speak: none;
    font-style: normal;
    font-weight: normal;
    font-variant: normal;
    text-transform: none;
    font-size: 1.4em;
    line-height: 40px;
    -webkit-font-smoothing: antialiased;
    position: absolute;
    color: #fff;
    background: #46a4da;
    border-radius: 50%;
    box-shadow: 0 0 0 5px #f5f5f6;
    text-align: center;
    left: 20%;
    top: 0;
    margin: 0 0 0 -25px
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
    .date_p {
        margin: unset;
        font-size: 11px;
        color: black;
        font-weight: 500;
    }
    .d_flex_and_align_center{
        display: flex;
        align-items: center;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    #payments-tab .select2-container--default .select2-selection--single{
        background-color: #F8F8F8;
    }
    #payments-tab .select2 {
        border: unset !important;
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
    #payment_received_btn{
        border-color: #1a3a2c;
        background-color: #0cda51;
        box-shadow: unset;
    }
    #payMultipleModal .table td {
        padding: .2rem 1.5rem;
    }

@media screen and (max-width: 992px) and (min-width: 768px) {
    .cbp_tmtimeline>li .cbp_tmtime {
        padding-right: 60px
    }
}

@media screen and (max-width: 65.375em) {
    .cbp_tmtimeline>li .cbp_tmtime span:last-child {
        font-size: 12px
    }
}

@media screen and (max-width: 47.2em) {
    .cbp_tmtimeline:before {
        display: none
    }
    .cbp_tmtimeline>li .cbp_tmtime {
        width: 100%;
        position: relative;
        padding: 0 0 20px 0
    }
    .cbp_tmtimeline>li .cbp_tmtime span {
        text-align: left
    }
    .cbp_tmtimeline>li .cbp_tmlabel {
        margin: 0 0 30px 0;
        padding: 1em;
        font-weight: 400;
        font-size: 95%
    }
    .cbp_tmtimeline>li .cbp_tmlabel:after {
        right: auto;
        left: 20px;
        border-right-color: transparent;
        border-bottom-color: #f5f5f6;
        top: -20px
    }
    .cbp_tmtimeline>li .cbp_tmicon {
        position: relative;
        float: right;
        left: auto;
        margin: -64px 5px 0 0px
    }
    .cbp_tmtimeline>li:nth-child(odd) .cbp_tmlabel:after {
        border-right-color: transparent;
        border-bottom-color: #f5f5f6
    }
}
.cbp_tmlabel small{
    color: #525f7f;
    font-size: .7rem;
}
.bg-custom-color{
    background-color: #cbcbcb !important;
}
.heading-link:hover {
    text-decoration: underline;
}
.heading-link {
    font-size: 1rem;
    color: black;
    font-weight: 500;
}
.hidden{
    display: none !important;
}
button#focus_button:focus, button#history_button:focus{
    border: none !important;
}
.badge::before{
    display: none;
}
.custom_select_area .select2-selection.select2-selection--multiple{
    border: 1px solid #b3b3b3 !important;
    overflow-y: scroll;
    height: 6rem;
}
.custom_select_area_1 .select2-selection.select2-selection--multiple{
    border: 1px solid #b3b3b3 !important;
    overflow-y: scroll;
    height: 4rem;
}
.custom_select_area .select2.select2-container.select2-container--default.select2-container--below{
    height: 6rem;
}
.custom_select_area .select2-selection.select2-selection--multiple{
    height: 6rem;
}
.custom_select_area_1 .select2.select2-container.select2-container--default.select2-container--below{
    height: 4rem;
}
.custom_select_area_1 .select2-selection.select2-selection--multiple{
    height: 4rem;
}
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f6f6f6;
    min-width: 230px;
    border: 1px solid #ddd;
    z-index: 1;
    height: 200px;
    overflow-y: scroll;
}

/* Links inside the dropdown */
.dropdown-content p {
  color: black;
  text-decoration: none;
  display: block;
  cursor: pointer;
}
.email-body-html p, .ql-editor p{
    line-height: 1.5;
}
.tableIcons{
    color: #B3B3B3;
    cursor: pointer;
}
.showorderpayments{
    cursor: pointer;
}
.notshoworderpayments{
    cursor: no-drop;
}
.no-top-border{
    border-top: none !important;
}
.styled-button{
        outline: unset;
        color: #d3d3d3;
        background-color: #fafafa;;
        border: 1px solid #d3d3d3;
        /* padding: .399rem; */
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
        /* padding: 5px; */
    text-align: center;
    width: 70px;
    cursor: pointer;
    }

@media (max-width: 768px) {
    .navbar {
        max-width: 100% !important;
    }
    #logo_large {
            display: block !important;
    }
    #logo_samll {
        display: none !important;
    }
    .main-content {
        margin-left: unset !important;
    }
    .navbar-minimize.fixed-left+.main-content {
        margin-left: unset !important;
    }

}

@media (max-width: 767.98px) {

    /* =====================================================
       ORGANIZATION MOBILE CONTAINER
       ===================================================== */

    .organization-mobile-wrapper {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .organization-mobile-table {
        width: 100% !important;
        display: block !important;
        border-collapse: separate !important;
    }

    .organization-mobile-table tbody {
        display: block !important;
        width: 100% !important;
    }

    .organization-mobile-row {
        display: block !important;
        width: 100% !important;
    }


    /* =====================================================
       ORGANIZATION NAME + DATE
       ===================================================== */

    .organization-logo-cell {
        display: none !important;
    }

    .organization-info-cell {
        display: block !important;
        width: 100% !important;
        padding: 0.75rem 0.75rem 0.5rem !important;
    }

    .organization-info-cell .row {
        margin: 0 !important;
    }

    .organization-info-cell .col-md-12 {
        width: 100% !important;
        padding: 0 !important;
    }

    .organization-info-cell .col-md-12:first-child span {
        display: block;
        font-size: 1.25rem !important;
        line-height: 1.4;
        font-weight: 600 !important;
        color: #222 !important;
        word-break: break-word;
    }

    .organization-info-cell .col-md-12:last-child {
        margin-top: 0.15rem;
        font-size: 0.85rem;
        color: #999 !important;
    }


    /* =====================================================
       SALES REP
       Label
       Select
       ===================================================== */

    .organization-sales-rep-cell {
        display: block !important;
        width: 100% !important;
        padding: 0.5rem 0.75rem !important;
    }

    .organization-sales-rep {
        display: block !important;
        width: 100% !important;
        height: auto !important;
        border: 1px solid #d3d3d3 !important;
        border-radius: 0.65rem !important;
        overflow: hidden;
        background: #fff;
    }

    /* Sales rep label */
    .organization-sales-rep-label {
        display: block !important;
        width: 100% !important;
        height: auto !important;

        margin: 0 !important;
        padding: 0.5rem 0.75rem !important;

        color: #999 !important;
        font-size: 0.75rem;
        font-weight: 500;

        border-right: none !important;
        border-bottom: 1px solid #e5e5e5 !important;

        background: #fafafa;
    }

    /* Select box BELOW label */
    .organization-sales-rep select {
        display: block !important;
        width: 100% !important;
        height: 2.6rem !important;

        margin: 0 !important;
        padding: 0.35rem 0.75rem !important;

        border: none !important;
        border-radius: 0 !important;

        background-color: #fff !important;

        font-size: 0.9rem !important;
        color: #333 !important;
        text-align: left !important;
    }


    /* =====================================================
       PASSWORD
       ===================================================== */

    .organization-password-cell {
        display: block !important;
        width: 100% !important;
        padding: 0.5rem 0.75rem !important;
    }

    .organization-password-wrapper {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
    }

    .organization-password-generate {
        width: 42px !important;
        min-width: 42px !important;
        height: 2.6rem !important;

        padding: 0 !important;
        margin: 0 !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .organization-password-input-group {
        flex: 1 !important;
        width: auto !important;
        height: 2.6rem !important;
    }

    .organization-password-input-group #unique_password {
        width: calc(100% - 42px) !important;
        height: 2.6rem !important;

        font-size: 0.9rem !important;

        border-radius: 0.55rem 0 0 0.55rem !important;
    }

    .organization-password-input-group .input-group-append {
        width: 42px !important;
    }

    .organization-password-input-group .input-group-append button {
        width: 42px !important;
        height: 2.6rem !important;

        border-radius: 0 0.55rem 0.55rem 0 !important;
    }


    /* =====================================================
       ACTION BUTTONS
       ===================================================== */

    .organization-action-cell {
        display: block !important;
        width: 100% !important;
        padding: 0.5rem 0.75rem 0.75rem !important;
    }

    .organization-action-buttons {
        display: flex !important;
        width: 100% !important;
        gap: 0.5rem !important;
    }

    .organization-action-buttons .mail_mail-button_2 {
        flex: 1 1 0 !important;
        /* width: 50% !important; */
        min-width: 0 !important;
        height: 2.6rem !important;

        margin: 0 !important;
        padding: 0.4rem 0.5rem !important;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .organization-unique-styles table tr {
        border-radius: 5px;
        border-bottom: unset !important;
    }
    .mail_mail-button_2.organization-customer-portal {
        width: 20% !important;
    }
    .mail_mail-button_2.compose-btn-to-log {
        width: 40% !important;
    }
    #show_map {
        width: 40% !important;
    }

    .organization-navbar {
        margin: 10px 0px;
        background-color: white;
        padding: 10px;
    }
    .styled-nav-item {
        padding-bottom: 5px;
    }
    .styled-nav-item .nav-link.active, .styled-nav-item .nav-link:hover {
        font-size: .6rem;
    }
    .organization-navbar .nav-link {
        border-bottom: unset !important;
    }
    .mobile_padding_right_10 {
        padding-right: 10px;
    }
    #sample_received_on {
        width: 100% !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
            height: calc(1.9rem + 40px) !important;
    }

}

@media (max-width: 767.98px) {

    /* =====================================================
       ORGANIZATION ADDRESS - MOBILE
       ===================================================== */

    .organization-address-mobile {
        width: 100% !important;
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }

    .organization-address-mobile table {
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        margin-bottom: 0.65rem !important;
    }

    .organization-address-mobile tr {
        display: block !important;
        width: 100% !important;
        border: none !important;
        margin-bottom: 0.65rem !important;
    }

    /* =====================================================
       LABEL
       ===================================================== */

    .organization-address-mobile td {
        display: block !important;
        width: 100% !important;
        padding: 0 !important;
        border: none !important;
    }

    .organization-address-mobile .form-lable-info {
        display: block !important;

        width: 100% !important;

        margin: 0 0 0.3rem 0 !important;

        font-size: 0.78rem !important;
        font-weight: 500 !important;

        line-height: 1.2 !important;

        color: #777 !important;
    }

    /* =====================================================
       INPUT / SELECT
       ===================================================== */

    .organization-address-mobile .info-form-input {
        display: block !important;

        width: 100% !important;

        min-height: 2.45rem !important;

        margin: 0 !important;

        padding: 0.4rem 0.7rem !important;

        font-size: 0.85rem !important;

        border-radius: 0.45rem !important;

        box-sizing: border-box !important;
    }

    .mobile_organization_note {
        padding-right: 5px;
    }
    .sub-header-style {
        margin-left: unset !important;
    }
    .mobile_margin_l_unset {
        margin-left: unset !important;
    }

}

@media (max-width: 767.98px) {

    /* =====================================================
       ORGANIZATION CONTROL BUTTONS
       ===================================================== */

    .organization-control-buttons {
        display: flex !important;
        align-items: center !important;

        width: 100% !important;

        padding: 0.75rem !important;
        margin: 0 !important;

        gap: 0.5rem !important;

        background-color: #fff !important;

        text-align: center !important;
    }


    /* =====================================================
       ALL BUTTONS
       ===================================================== */

    .organization-control-buttons .btn-custom {
        flex: 1 1 0 !important;

        width: auto !important;
        min-width: 0 !important;

        height: 2.7rem !important;

        margin: 0 !important;
        padding: 0.45rem 0.65rem !important;

        border: none !important;
        border-radius: 0.65rem !important;

        font-size: 0.85rem !important;
        font-weight: 600 !important;

        line-height: 1 !important;

        white-space: nowrap;

        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);

        transition:
            transform 0.15s ease,
            box-shadow 0.15s ease;
    }


    /* =====================================================
       BUTTON PRESS EFFECT
       ===================================================== */

    .organization-control-buttons .btn-custom:active {
        transform: scale(0.97);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }


    /* =====================================================
       SAVE
       ===================================================== */

    .organization-control-buttons #saveForm {
        background-color: #47D6B6 !important;
        color: #fff !important;
    }


    /* =====================================================
       DELETE
       ===================================================== */

    .organization-control-buttons #delete_form {
        background-color: #b3b3b3 !important;
        color: #fff !important;
    }


    /* =====================================================
       CANCEL
       ===================================================== */

    .organization-control-buttons button[type="reset"] {
        background-color: #d27070 !important;
        color: #fff !important;
    }

}

@media (max-width: 767.98px) {

    /* =========================================================
       CONTACTS MOBILE CONTAINER
       ========================================================= */

    .organization-contacts-mobile {
        width: 100% !important;
        padding: 0 !important;
    }

    .organization-contacts-mobile > .col-md-12 {
        width: 100% !important;
        margin: 0 !important;
        padding: 0.75rem !important;

        border: none !important;
        border-radius: 0.75rem !important;

        background: #fff !important;
        box-shadow: none !important;
    }


    /* =========================================================
       ADD / REMOVE BUTTON
       ========================================================= */

    .organization-contacts-mobile #addOrRemoveContactsBtn {
        width: auto !important;
        min-height: 2.4rem;

        padding: 0.45rem 0.85rem !important;

        border: 1px solid #e5e5e5 !important;
        border-radius: 0.6rem !important;

        background: #f6f6f6 !important;
        color: #555 !important;

        font-size: 0.8rem !important;
        font-weight: 500;

        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
    }

    .organization-contacts-mobile
    .ml-auto.mb-3.mt-3 {
        width: 100% !important;

        display: flex !important;
        justify-content: flex-end !important;

        margin: 0 0 0.75rem 0 !important;
    }


    /* =========================================================
       TABLE WRAPPER
       ========================================================= */

    .organization-contacts-mobile .table-responsive {
        width: 100% !important;

        overflow: visible !important;

        margin: 0 !important;
        padding: 0 !important;
    }


    /* =========================================================
       REMOVE TABLE LOOK
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_table {

        display: block !important;

        width: 100% !important;

        margin: 0 !important;

        border: none !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;

        background: transparent !important;
    }


    /* =========================================================
       HIDE TABLE HEADER
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_table thead {

        display: none !important;
    }


    /* =========================================================
       TBODY
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_tbody {

        display: block !important;

        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;
    }


    /* =========================================================
       EACH CONTACT = CARD
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) {

        display: grid !important;

        grid-template-columns: 1fr 1fr;

        column-gap: 0.75rem;
        row-gap: 0.75rem;

        width: 100% !important;

        margin: 0 0 0.75rem 0 !important;
        padding: 0.9rem !important;

        background: #fff !important;

        border: 1px solid #ededed !important;
        border-radius: 0.8rem !important;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);

        box-sizing: border-box;
    }


    /* =========================================================
       EACH CELL
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td {

        display: block !important;

        width: 100% !important;

        padding: 0 !important;

        margin: 0 !important;

        border: none !important;

        background: transparent !important;

        vertical-align: top !important;
        text-align: left !important;
    }


    /* =========================================================
       LABEL

       Uses table header text automatically
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td::before {

        display: block;

        margin-bottom: 0.25rem;

        color: #000000;

        font-size: 0.68rem;

        font-weight: 600;

        line-height: 1.2;

        text-transform: uppercase;

        letter-spacing: 0.02em;
    }


    /* =========================================================
       LABELS
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:nth-child(1)::before {
        content: "First Name";
    }

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:nth-child(2)::before {
        content: "Last Name";
    }

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:nth-child(3)::before {
        content: "Office Phone";
    }

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:nth-child(4)::before {
        content: "Email";
    }

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:nth-child(5)::before {
        content: "Title";
    }

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:nth-child(6)::before {
        content: "Assigned To";
    }

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:nth-child(7)::before {
        content: "Shipping City";
    }

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:nth-child(8)::before {
        content: "Shipping Country";
    }


    /* =========================================================
       FIELD VALUE
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td {

        color: #9c9c9c;

        font-size: 0.82rem;

        line-height: 1.35;

        word-break: break-word;
    }


    /* =========================================================
       EMAIL
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:nth-child(4) {

        overflow-wrap: anywhere;
    }


    /* =========================================================
       EMPTY CELLS

       Hide empty field + label
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:empty {

        display: none !important;
    }


    /* Empty cells containing only whitespace */
    .organization-contacts-mobile
    #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td:has(> span:empty) {

        display: none !important;
    }


    /* =========================================================
       PLACEHOLDER
       ========================================================= */

    .organization-contacts-mobile
    #organization_contacts_tbody .lazy-tab-placeholder {

        display: block !important;

        width: 100% !important;

        margin: 0 !important;

        padding: 1.5rem 0.75rem !important;

        border: 1px dashed #ddd !important;

        border-radius: 0.7rem !important;

        background: #fafafa !important;
    }

    .organization-contacts-mobile
    #organization_contacts_tbody .lazy-tab-placeholder td {

        display: block !important;

        width: 100% !important;

        padding: 0 !important;

        border: none !important;

        text-align: center !important;
    }

    .organization-contacts-mobile
    #organization_contacts_tbody .lazy-tab-placeholder td::before {

        display: none !important;
    }


    /* =========================================================
       SMALL MOBILE
       ========================================================= */

    @media (max-width: 400px) {

        .organization-contacts-mobile
        #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) {

            padding: 0.75rem !important;

            column-gap: 0.6rem;
            row-gap: 0.65rem;
        }

        .organization-contacts-mobile
        #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td {

            font-size: 0.78rem;
        }

        .organization-contacts-mobile
        #organization_contacts_tbody > tr:not(.lazy-tab-placeholder) > td::before {

            font-size: 0.63rem;
        }
    }

    #organization_contacts_table_length {
        text-align: left !important;
    }
    #organization_contacts_table_filter {
        text-align: left !important;
    }
    #organization_contacts_table_wrapper .row .col-sm-12 {
            padding-left: unset;
    }
    #organization_contacts_table_filter label {
        width: 100%;
    }
    #organization_contacts_table_filter label input {
        width: 80%;
    }

}

@media (max-width: 767.98px) {

    /* =====================================================
       ORDERS MOBILE CONTAINER
       ===================================================== */

    .organization-orders-mobile {
        width: 100% !important;
        padding: 0 !important;
    }

    .organization-orders-mobile > .col-md-12 {
        width: 100% !important;

        margin: 0 !important;
        padding: 0.75rem !important;

        border: none !important;
        border-radius: 0.75rem !important;

        background: #fff !important;
        box-shadow: none !important;
    }


    /* =====================================================
       ADD NEW ORDER BUTTON
       ===================================================== */

    .organization-orders-mobile
    .ml-auto.mb-3.mt-3 {

        width: 100% !important;

        display: flex !important;
        justify-content: flex-end !important;

        margin: 0 0 0.75rem 0 !important;
    }

    .organization-orders-mobile
    .ml-auto.mb-3.mt-3 .mail_mail-button {

        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

        min-height: 2.45rem;

        padding: 0.45rem 0.85rem !important;

        border: 1px solid #e5e5e5 !important;
        border-radius: 0.6rem !important;

        background: #f6f6f6 !important;
        color: #555 !important;

        font-size: 0.8rem !important;
        font-weight: 500;

        text-decoration: none !important;

        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);

        transition: all 0.15s ease;
    }


    /* =====================================================
       TABLE WRAPPER
       ===================================================== */

    .organization-orders-mobile .table-responsive {

        width: 100% !important;

        overflow: visible !important;

        margin: 0 !important;
        padding: 0 !important;
    }


    /* =====================================================
       TABLE -> BLOCK
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_table {

        display: block !important;

        width: 100% !important;

        margin: 0 !important;

        border: none !important;

        border-collapse: separate !important;
        border-spacing: 0 !important;

        background: transparent !important;
    }


    /* =====================================================
       HIDE HEADER
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_table thead {

        display: none !important;
    }


    /* =====================================================
       TBODY
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_tbody {

        display: block !important;

        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;
    }


    /* =====================================================
       EACH ORDER = CARD
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder) {

        display: grid !important;

        grid-template-columns: 1fr 1fr;

        column-gap: 0.75rem;
        row-gap: 0.8rem;

        width: 100% !important;

        margin: 0 0 0.75rem 0 !important;

        padding: 0.9rem !important;

        background: #fff !important;

        border: 1px solid #ededed !important;

        border-radius: 0.8rem !important;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);

        box-sizing: border-box;
    }


    /* =====================================================
       TABLE CELLS
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder) > td {

        display: block !important;

        width: 100% !important;

        padding: 0 !important;
        margin: 0 !important;

        border: none !important;

        background: transparent !important;

        vertical-align: top !important;

        color: #9c9c9c;

        font-size: 0.82rem;

        line-height: 1.35;

        word-break: break-word;
        text-align: left !important;
    }


    /* =====================================================
       LABEL
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder) > td::before {

        display: block;

        margin-bottom: 0.25rem;

        color: #000000;

        font-size: 0.68rem;

        font-weight: 600;

        line-height: 1.2;

        text-transform: uppercase;

        letter-spacing: 0.02em;
    }

    table a {
        color: #9c9c9c !important;
    }

    #organization_payments_table .edit-order {
        color: #000000 !important;
    }
    /* =====================================================
       LABELS
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder)
    > td:nth-child(1)::before {

        content: "Order #";
    }

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder)
    > td:nth-child(2)::before {

        content: "Sales Rep";
    }

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder)
    > td:nth-child(3)::before {

        content: "Total ($)";
    }

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder)
    > td:nth-child(4)::before {

        content: "Status";
    }

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder)
    > td:nth-child(5)::before {

        content: "Due Date";
    }


    /* =====================================================
       TOTAL
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder)
    > td:nth-child(3) {

        /* text-align: center !important; */
    }


    /* =====================================================
       EMPTY FIELDS
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder)
    > td:empty {

        display: none !important;
    }


    /* =====================================================
       DUE DATE

       Make it full width
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_tbody > tr:not(.lazy-tab-placeholder)
    > td:nth-child(5) {

        grid-column: 1 / -1;
    }


    /* =====================================================
       PLACEHOLDER
       ===================================================== */

    .organization-orders-mobile
    #organization_orders_tbody .lazy-tab-placeholder {

        display: block !important;

        width: 100% !important;

        margin: 0 !important;

        padding: 1.5rem 0.75rem !important;

        border: 1px dashed #ddd !important;

        border-radius: 0.7rem !important;

        background: #fafafa !important;
    }

    .organization-orders-mobile
    #organization_orders_tbody .lazy-tab-placeholder td {

        display: block !important;

        width: 100% !important;

        padding: 0 !important;

        border: none !important;

        text-align: center !important;
    }

    .organization-orders-mobile
    #organization_orders_tbody .lazy-tab-placeholder td::before {

        display: none !important;
    }


    /* =====================================================
       SMALL MOBILE
       ===================================================== */

    @media (max-width: 400px) {

        .organization-orders-mobile
        #organization_orders_tbody > tr:not(.lazy-tab-placeholder) {

            padding: 0.75rem !important;

            column-gap: 0.6rem;
            row-gap: 0.65rem;
        }

        .organization-orders-mobile
        #organization_orders_tbody > tr:not(.lazy-tab-placeholder) > td {

            font-size: 0.78rem;
        }

        .organization-orders-mobile
        #organization_orders_tbody > tr:not(.lazy-tab-placeholder) > td::before {

            font-size: 0.63rem;
        }
    }

}

@media (max-width: 767.98px) {

    /* ==========================================
       MAIN FILTER CONTAINER
       ========================================== */

    .payment-filter-mobile {
        display: flex !important;
        flex-wrap: wrap !important;

        width: 100% !important;

        margin: 0 !important;
        padding: 0.6rem !important;

        row-gap: 0.7rem !important;
        column-gap: 0 !important;
    }


    /* ==========================================
       FIRST ROW
       Start Date + End Date
       ========================================== */

    .payment-filter-mobile > .filter_row {
        display: block !important;

        width: 50% !important;

        margin: 0 !important;
        padding: 0 0.35rem !important;

        box-sizing: border-box !important;
        background: transparent !important;
        border: unset !important;
    }


    /* Start / End label */

    .payment-filter-mobile .date_p {
        display: block !important;

        width: 100% !important;

        margin: 0 0 0.3rem 0 !important;
        padding: 0 !important;

        font-size: 0.72rem !important;
        font-weight: 600 !important;

        color: #777 !important;

        line-height: 1.2 !important;
    }


    /* ==========================================
       DATE INPUT
       ========================================== */

    .payment-filter-mobile .date_selection {
        display: block !important;

        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;
    }

    .payment-filter-mobile .invoice-inputs {
        display: block !important;

        width: 100% !important;

        height: 2.55rem !important;

        margin: 0 !important;

        padding: 0.4rem 0.65rem !important;

        background-color: #f8f8f8 !important;

        border: 1px solid #dedede !important;

        border-radius: 0.55rem !important;

        font-size: 0.82rem !important;

        box-sizing: border-box !important;

        outline: none !important;
    }


    .payment-filter-mobile .invoice-inputs:focus {
        background-color: #fff !important;

        border-color: #47d6b6 !important;

        box-shadow: 0 0 0 3px rgba(71, 214, 182, 0.12) !important;
    }


    /* ==========================================
       SECOND ROW
       Filter Column + Filter Button
       ========================================== */

    .payment-filter-mobile > .row:not(.filter_row) {

        display: flex !important;

        width: 50% !important;

        margin: 0 !important;

        padding: 0 0.35rem !important;

        box-sizing: border-box !important;
    }


    /* ==========================================
       FILTER SELECT
       ========================================== */

    .payment-filter-mobile
    .select-width-style {

        display: block !important;

        width: 100% !important;

        padding: 0 !important;

        margin: 0 !important;
    }


    .payment-filter-mobile .summary-select2 {

        width: 100% !important;

        height: 2.55rem !important;

        min-height: 2.55rem !important;

        padding: 0.4rem 0.65rem !important;

        border: 1px solid #dedede !important;

        border-radius: 0.55rem !important;

        background-color: #f8f8f8 !important;

        font-size: 0.82rem !important;

        color: #555 !important;
    }


    /* ==========================================
       FILTER BUTTON
       ========================================== */

    .payment-filter-mobile > .row:last-child {

        display: block !important;

        width: 50% !important;

        margin: 0 !important;

        padding: 0 0.35rem !important;

        box-sizing: border-box !important;
    }


    .payment-filter-mobile .filter_btn {

        display: flex !important;

        align-items: center !important;

        justify-content: center !important;

        width: 100% !important;

        height: 2.55rem !important;

        min-height: 2.55rem !important;

        margin: 0 !important;

        padding: 0.4rem 0.6rem !important;

        border: none !important;

        border-radius: 0.55rem !important;

        background-color: #47d6b6 !important;

        color: #fff !important;

        font-size: 0.82rem !important;

        font-weight: 600 !important;

        box-shadow: 0 2px 6px rgba(71, 214, 182, 0.2);

        transition: transform 0.15s ease;
    }


    .payment-filter-mobile .filter_btn:active {
        transform: scale(0.97);
    }


    /* ==========================================
       SELECT2
       ========================================== */

    .payment-filter-mobile .select2-container {
        width: 100% !important;
    }

    .payment-filter-mobile
    .select2-container .select2-selection--single {

        height: 2.55rem !important;

        border: 1px solid #dedede !important;

        border-radius: 0.55rem !important;

        background: #f8f8f8 !important;
    }

    .payment-filter-mobile
    .select2-selection__rendered {

        line-height: 2.5rem !important;

        padding-left: 0.65rem !important;

        font-size: 0.82rem !important;
    }

    .payment-filter-mobile
    .select2-selection__arrow {

        height: 2.5rem !important;
    }

}

@media (max-width: 767.98px) {

    /* =========================================
       MAIN TABLE
       ========================================= */

    #organization_payments_table {
        display: block !important;
        width: 100% !important;
        border: none !important;
        background: transparent !important;
    }

    #organization_payments_table thead {
        display: block !important;
        width: 100% !important;
    }

    #organization_payments_table thead tr {
        display: block !important;
        width: 100% !important;
        margin-bottom: 0.75rem !important;
        padding: 0.7rem 0.9rem !important;
        background: #f8f8f8 !important;
        border: 1px solid #e5e5e5 !important;
        border-radius: 0.7rem !important;
    }

    /* Hide all header cells */
    #organization_payments_table thead th {
        display: none !important;
    }

    /* Show only Select All */
    #organization_payments_table thead th:first-child {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        padding: 0 !important;
        border: none !important;
        text-align: left !important;
    }

    /* All Select checkbox */
    #checkbox_of_invoice_all {
        display: inline-block !important;
        width: 1rem !important;
        height: 1rem !important;
        margin: 0 0.5rem 0 0 !important;
        flex-shrink: 0 !important;
    }

    /* All Select text */
    #organization_payments_table thead th:first-child::after {
        content: "All Select";
        display: inline-block !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: #666 !important;
        top: 0px;
        left: 30px;
    }


    /* =========================================
       TBODY
       ========================================= */

    #organization_payments_table tbody {
        display: block !important;
        width: 100% !important;
    }


    /* =========================================
       EACH ROW = CARD
       3 COLUMNS
       ========================================= */

    #organization_payments_table tbody > tr {

        display: grid !important;

        /*
         * Checkbox | Order Details | Status
         */
        grid-template-columns: 1.6rem minmax(0, 1fr) auto !important;

        grid-template-rows: auto auto auto !important;

        column-gap: 0.45rem !important;
        row-gap: 0 !important;

        width: 100% !important;

        margin-bottom: 0.8rem !important;

        padding: 0.9rem !important;

        background: #ffffff !important;

        border: 1px solid #e7e7e7 !important;

        border-radius: 0.8rem !important;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;

        box-sizing: border-box !important;
    }


    /* =========================================
       RESET ALL TD
       ========================================= */

    #organization_payments_table tbody > tr > td {

        display: block !important;

        width: auto !important;

        min-width: 0 !important;

        margin: 0 !important;
        padding: 0 !important;

        border: none !important;

        background: transparent !important;

        font-size: 0.82rem !important;

        line-height: 1.35 !important;

        box-sizing: border-box !important;
    }


    /* =========================================
       COLUMN 1 - CHECKBOX
       ========================================= */

    #organization_payments_table tbody > tr > td:nth-child(1) {

        grid-column: 1 !important;
        grid-row: 1 / 3 !important;

        display: flex !important;

        align-items: flex-start !important;

        padding-top: 0.12rem !important;
    }

    #organization_payments_table
    tbody > tr > td:nth-child(1) input[type="checkbox"] {

        width: 1rem !important;
        height: 1rem !important;

        margin: 0 !important;
    }


    /* =========================================
       COLUMN 2 - HIDE EMPTY COLUMN
       ========================================= */

    #organization_payments_table tbody > tr > td:nth-child(2) {
        display: none !important;
    }


    /* =========================================
       COLUMN 3 - ORDER NUMBER
       ========================================= */

    #organization_payments_table tbody > tr > td:nth-child(3) {

        grid-column: 2 !important;
        grid-row: 1 !important;

        font-size: 0.9rem !important;
        font-weight: 600 !important;

        color: #333 !important;

        text-align: left !important;
    }


    /* =========================================
       COLUMN 8 - CREATED DATE
       ========================================= */

    #organization_payments_table tbody > tr > td:nth-child(8) {

        grid-column: 2 !important;
        grid-row: 2 !important;

        margin-top: 0.2rem !important;

        color: #888 !important;

        font-size: 0.72rem !important;

        text-align: left !important;
    }

    #organization_payments_table tbody > tr > td:nth-child(8)::before {

        content: "Created";

        margin-right: 0.35rem !important;

        color: #aaa !important;

        font-weight: 500 !important;
    }


    /* =========================================
       COLUMN 7 - STATUS
       ========================================= */

    #organization_payments_table tbody > tr > td:nth-child(7) {

        grid-column: 3 !important;
        grid-row: 1 !important;

        align-self: start !important;

        padding: 0.25rem 0.5rem !important;

        border-radius: 1rem !important;

        font-size: 0.68rem !important;

        font-weight: 600 !important;

        text-transform: uppercase !important;

        white-space: nowrap !important;

        text-align: center !important;
    }


    /* =========================================
       TOTAL / PAID / BALANCE
       SECOND SECTION - 3 COLUMNS
       ========================================= */

    #organization_payments_table tbody > tr > td:nth-child(4),
    #organization_payments_table tbody > tr > td:nth-child(5),
    #organization_payments_table tbody > tr > td:nth-child(6) {

        display: block !important;

        margin-top: 0.9rem !important;

        padding-top: 0.75rem !important;

        border-top: 1px solid #eeeeee !important;

        font-size: 0.85rem !important;

        font-weight: 600 !important;
        color: #a7a7a7;
    }


    /* Total */
    #organization_payments_table tbody > tr > td:nth-child(4) {
        grid-column: 1 !important;
        grid-row: 3 !important;
    }

    /* Paid */
    #organization_payments_table tbody > tr > td:nth-child(5) {
        grid-column: 2 !important;
        grid-row: 3 !important;
    }

    /* Balance */
    #organization_payments_table tbody > tr > td:nth-child(6) {
        grid-column: 3 !important;
        grid-row: 3 !important;
    }


    /* Labels */

    #organization_payments_table tbody > tr > td:nth-child(4)::before,
    #organization_payments_table tbody > tr > td:nth-child(5)::before,
    #organization_payments_table tbody > tr > td:nth-child(6)::before {

        display: block !important;

        margin-bottom: 0.25rem !important;

        color: black !important;

        font-size: 0.62rem !important;

        font-weight: 600 !important;

        text-transform: uppercase !important;
    }

    #organization_payments_table tbody > tr > td:nth-child(4)::before {
        content: "Total";
    }

    #organization_payments_table tbody > tr > td:nth-child(5)::before {
        content: "Paid";
    }

    #organization_payments_table tbody > tr > td:nth-child(6)::before {
        content: "Balance";
    }


    /* =========================================
       INVOICE BUTTONS
       LAST ROW
       ========================================= */

    #organization_payments_table tbody > tr > td:nth-child(9) {

        grid-column: 1 / -1 !important;
        grid-row: 4 !important;

        display: flex !important;

        align-items: center !important;
        justify-content: flex-start !important;

        flex-wrap: wrap !important;

        gap: 0.5rem !important;

        margin-top: 0.9rem !important;

        padding-top: 0.8rem !important;

        border-top: 1px solid #eeeeee !important;
    }


    #organization_payments_table tbody > tr > td:nth-child(9) a,
    #organization_payments_table tbody > tr > td:nth-child(9) button {

        display: inline-flex !important;

        align-items: center !important;
        justify-content: center !important;

        min-height: 2.2rem !important;

        padding: 0.4rem 0.75rem !important;

        margin: 0 !important;

        border-radius: 0.5rem !important;

        font-size: 0.72rem !important;

        white-space: nowrap !important;
    }


    /* =========================================
       EMPTY TD
       ========================================= */

    #organization_payments_table tbody > tr > td:empty {
        display: none !important;
    }


    /* Keep important cells visible */
    #organization_payments_table tbody > tr > td:nth-child(1),
    #organization_payments_table tbody > tr > td:nth-child(3),
    #organization_payments_table tbody > tr > td:nth-child(4),
    #organization_payments_table tbody > tr > td:nth-child(5),
    #organization_payments_table tbody > tr > td:nth-child(6),
    #organization_payments_table tbody > tr > td:nth-child(7),
    #organization_payments_table tbody > tr > td:nth-child(8),
    #organization_payments_table tbody > tr > td:nth-child(9) {
        display: block !important;
    }

    #organization_payments_table_length {
        text-align: left !important;
    }
    #organization_payments_table_wrapper .row .col-sm-12 {
        padding-left: unset !important;
    }
    #organization_payments_table_filter {
        text-align: left !important;
    }
    #organization_payments_table_filter label{
            width: 100% !important;
    }
    #organization_payments_table_filter label input{
            width: 85% !important;
    }
}

@media (max-width: 767.98px) {

    /* =========================================
       ACTIVITY TABLE
       ========================================= */

    #activity_table {
        display: block !important;
        width: 100% !important;
        border: none !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    #activity_table thead {
        display: none !important;
    }

    #activity_table tbody {
        display: block !important;
        width: 100% !important;
    }


    /* =========================================
       IMPORTANT
       Do NOT use display:grid !important here
       because JS uses .show() / .hide()
       for TO DO / DONE filtering.
       ========================================= */

    #activity_table tbody tr {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;

        width: 100%;

        margin: 0 0 0.8rem 0;
        padding: 0.9rem;

        background: #fff;

        border: 1px solid #e8e8e8;
        border-radius: 0.8rem;

        box-shadow: 0 2px 8px rgba(0,0,0,0.05);

        box-sizing: border-box;

        overflow: hidden;
    }


    /* =========================================
       TD RESET
       ========================================= */

    #activity_table tbody tr td {
        display: block !important;

        width: auto !important;
        min-width: 0 !important;

        margin: 0 !important;
        padding: 0 !important;

        border: none !important;

        background: transparent !important;

        text-align: left !important;

        font-size: 0.8rem !important;
        line-height: 1.4 !important;

        word-break: break-word !important;
        box-sizing: border-box !important;
    }


    /* =========================================
       1 - CHECKBOX
       ========================================= */

    #activity_table tbody tr td:nth-child(1) {
        grid-column: 1 / 3 !important;
        grid-row: 1 !important;

        display: flex !important;
        align-items: center !important;
    }

    #activity_table tbody tr td:nth-child(1) input[type="checkbox"] {
        width: 1rem !important;
        height: 1rem !important;
        margin: 0 !important;
    }


    /* =========================================
       2 - DONE
       ========================================= */

    #activity_table tbody tr td:nth-child(2) {
        grid-column: 3 !important;
        grid-row: 1 !important;

        display: flex !important;
        justify-content: flex-end !important;
        align-items: center !important;

        text-align: right !important;
    }

    #activity_table tbody tr td:nth-child(2) .badge {
        font-size: 0.65rem !important;
        padding: 0.3rem 0.6rem !important;
        border-radius: 1rem !important;
        white-space: nowrap !important;
    }


    /* =========================================
       3 - START DATE
       ========================================= */

    #activity_table tbody tr td:nth-child(3) {
        grid-column: 1 / 2 !important;
        grid-row: 2 !important;

        margin-top: 1rem !important;
        padding-top: 0.7rem !important;
        padding-right: 0.5rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #activity_table tbody tr td:nth-child(3)::before {
        content: "Start Date";

        display: block !important;
        margin-bottom: 0.25rem !important;

        color: black !important;
        font-size: 0.62rem !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
    }


    /* =========================================
       4 - ASSIGN TO
       ========================================= */

    #activity_table tbody tr td:nth-child(4) {
        grid-column: 2 / 4 !important;
        grid-row: 2 !important;

        margin-top: 1rem !important;
        padding-top: 0.7rem !important;
        padding-left: 0.5rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #activity_table tbody tr td:nth-child(4)::before {
        content: "Assign To";

        display: block !important;
        margin-bottom: 0.25rem !important;

        color: black !important;
        font-size: 0.62rem !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
    }


    /* =========================================
       5 - SUBJECT
       ========================================= */

    #activity_table tbody tr td:nth-child(5) {
        grid-column: 1 / 4 !important;
        grid-row: 3 !important;

        margin-top: 0.8rem !important;
        padding-top: 0.7rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #activity_table tbody tr td:nth-child(5)::before {
        content: "Subject";

        display: block !important;
        margin-bottom: 0.25rem !important;

        color: black !important;
        font-size: 0.62rem !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
    }

    #activity_table tbody tr td:nth-child(5) a {
        color: #999 !important;
        font-weight: 600 !important;
        text-decoration: none !important;
    }


    /* =========================================
       6 - NOTE
       ========================================= */

    #activity_table tbody tr td:nth-child(6) {
        grid-column: 1 / 4 !important;
        grid-row: 4 !important;

        margin-top: 0.8rem !important;
        padding-top: 0.7rem !important;

        border-top: 1px solid #eeeeee !important;

        color: #666 !important;
    }

    #activity_table tbody tr td:nth-child(6)::before {
        content: "Note";

        display: block !important;
        margin-bottom: 0.25rem !important;

        color: black !important;
        font-size: 0.62rem !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
    }


    /* =========================================
       7 - START TIME
       ========================================= */

    #activity_table tbody tr td:nth-child(7) {
        display: none !important;
    }


    /* =========================================
       8 - ORDER NO
       ========================================= */

    #activity_table tbody tr td:nth-child(8) {
        grid-column: 1 / 2 !important;
        grid-row: 5 !important;

        margin-top: 0.8rem !important;
        padding-top: 0.7rem !important;
        padding-right: 0.5rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #activity_table tbody tr td:nth-child(8)::before {
        content: "Order No";

        display: block !important;
        margin-bottom: 0.25rem !important;

        color: black !important;
        font-size: 0.62rem !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
    }


    /* =========================================
       9 - CONTACT PERSON
       ========================================= */

    #activity_table tbody tr td:nth-child(9) {
        grid-column: 2 / 4 !important;
        grid-row: 5 !important;

        margin-top: 0.8rem !important;
        padding-top: 0.7rem !important;
        padding-left: 0.5rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #activity_table tbody tr td:nth-child(9)::before {
        content: "Contact Person";

        display: block !important;
        margin-bottom: 0.25rem !important;

        color: black !important;
        font-size: 0.62rem !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
    }


    /* =========================================
       10 - CREATED BY
       ========================================= */

    #activity_table tbody tr td:nth-child(10) {
        grid-column: 1 / 4 !important;
        grid-row: 6 !important;

        margin-top: 0.8rem !important;
        padding-top: 0.7rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #activity_table tbody tr td:nth-child(10)::before {
        content: "Created By";

        display: block !important;
        margin-bottom: 0.25rem !important;

        color: black !important;
        font-size: 0.62rem !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
    }


    /* =========================================
       EMPTY DATA
       ========================================= */

    #activity_table tbody tr td:empty {
        display: none !important;
    }
    #activity_table_length {
        text-align: left !important;
    }
    #activity_table_filter {
        text-align: left !important;
    }
    #activity_table_wrapper .col-sm-12 {
        padding-left: unset !important;
    }

}

/* =========================================================
   ACCOUNT STATEMENTS - MOBILE RESPONSIVE
   ========================================================= */

@media (max-width: 767.98px) {

    /* -----------------------------------------------------
       MAIN CARD
       ----------------------------------------------------- */

    #Account_Statements .card {
        margin: 0 !important;
        padding: 0.75rem !important;
        border: none !important;
        border-radius: 0.9rem !important;
        background: #f7f8fa !important;
        box-shadow: none !important;
    }


    /* -----------------------------------------------------
       FILTER AREA
       ----------------------------------------------------- */

    #Account_Statements > .card > .row:first-child {
        display: grid !important;

        grid-template-columns: 1fr 1fr !important;

        gap: 0.6rem !important;

        margin: 0 !important;
        width: 100% !important;
    }


    /* Remove Bootstrap .row behaviour from filter rows */
    #Account_Statements .filter_row,
    #Account_Statements > .card > .row:first-child > .row {
        display: block !important;

        width: auto !important;

        margin: 0 !important;
        padding: 0 !important;

        height: auto !important;

        min-height: 0 !important;
    }


    /* -----------------------------------------------------
       START / END DATE
       50% / 50%
       ----------------------------------------------------- */

    #Account_Statements .filter_row:nth-child(1),
    #Account_Statements .filter_row:nth-child(2) {
        display: flex !important;

        flex-direction: column !important;

        width: 100% !important;

        padding: 0.7rem !important;

        margin: 0 !important;

        min-height: 4.8rem !important;

        background: transparent !important;

        border: none !important;

        border-radius: 0.65rem !important;

        box-sizing: border-box !important;
    }


    #Account_Statements .filter_row:nth-child(1) .date_p,
    #Account_Statements .filter_row:nth-child(2) .date_p {

        display: block !important;

        width: 100% !important;

        padding: 0 !important;

        margin: 0 0 0.3rem 0 !important;

        font-size: 0.68rem !important;

        font-weight: 600 !important;

        color: #888 !important;

        line-height: 1 !important;

        text-transform: uppercase !important;

        letter-spacing: 0.03rem !important;
    }


    /*
     * Remove the "|" visually from:
     *
     * Start Date |
     * End Date   |
     */

    #Account_Statements .filter_row:nth-child(1) .date_p,
    #Account_Statements .filter_row:nth-child(2) .date_p {
        font-size: 0 !important;
    }

    #Account_Statements .filter_row:nth-child(1) .date_p::after {
        content: "Start Date";
        font-size: 0.68rem !important;
    }

    #Account_Statements .filter_row:nth-child(2) .date_p::after {
        content: "End Date";
        font-size: 0.68rem !important;
    }


    #Account_Statements .date_selection {

        width: 100% !important;

        padding: 0 !important;

        display: block !important;
    }


    #Account_Statements .invoice-inputs {

        width: 100% !important;

        height: 2.2rem !important;

        margin: 0 !important;

        padding: 0.35rem 0.55rem !important;

        background: #fafafa !important;

        border: 1px solid #dedede !important;

        border-radius: 0.45rem !important;

        font-size: 0.78rem !important;

        box-sizing: border-box !important;
    }


    /* -----------------------------------------------------
       BUTTONS
       Filter / Export / PDF
       3 BUTTONS IN ONE ROW
       ----------------------------------------------------- */

    #Account_Statements > .card > .row:first-child > .row:nth-child(3),
    #Account_Statements > .card > .row:first-child > .row:nth-child(4),
    #Account_Statements > .card > .row:first-child > .row:nth-child(5) {

        display: block !important;

        width: 100% !important;

        margin: 0 !important;

        padding: 0 !important;

        height: 2.35rem !important;

        align-self: center !important;
    }


    #Account_Statements > .card > .row:first-child > .row:nth-child(3) {
        grid-column: 1 !important;
        grid-row: 2 !important;
    }

    #Account_Statements > .card > .row:first-child > .row:nth-child(4) {
        grid-column: 2 !important;
        grid-row: 2 !important;
    }

    #Account_Statements > .card > .row:first-child > .row:nth-child(5) {
        grid-column: 1 / 3 !important;
        grid-row: 3 !important;

        width: calc(33.333% - 0.4rem) !important;

        justify-self: center !important;
    }


    #Account_Statements > .card > .row:first-child > .row:nth-child(3) .date_selection,
    #Account_Statements > .card > .row:first-child > .row:nth-child(4) .date_selection,
    #Account_Statements > .card > .row:first-child > .row:nth-child(5) .date_selection {

        width: 100% !important;

        height: 100% !important;

        padding: 0 !important;
    }


    #Account_Statements #pin-filter2,
    #Account_Statements #export_button,
    #Account_Statements #pdf_export_button {

        display: flex !important;

        align-items: center !important;

        justify-content: center !important;

        width: 100% !important;

        height: 100% !important;

        padding: 0.4rem 0.5rem !important;

        border: 1px solid #dedede !important;

        border-radius: 0.5rem !important;

        background: #fff !important;

        color: #555 !important;

        font-size: 0.72rem !important;

        font-weight: 600 !important;

        white-space: nowrap !important;

        box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;
    }


    #Account_Statements #pin-filter2 i,
    #Account_Statements #export_button i,
    #Account_Statements #pdf_export_button i {

        margin-right: 0.25rem !important;
    }


    /* -----------------------------------------------------
       HIDE TABLE LAYOUT
       ----------------------------------------------------- */

    #Account_Statements > .card > .row:first-child > .row:nth-child(6) {
        display: none !important;
    }


    /* -----------------------------------------------------
       HIDE DEBIT ENTRIES
       ----------------------------------------------------- */

    #Account_Statements > .card > .row:first-child > .row:nth-child(7) {

        grid-column: 1 / 3 !important;
        grid-row: 4 !important;

        display: flex !important;

        align-items: center !important;

        width: 100% !important;

        height: auto !important;

        min-height: 2rem !important;

        margin: 0 !important;

        padding: 0.35rem 0.5rem !important;

        background: #fff !important;

        border: 1px solid #e7e9ed !important;

        border-radius: 0.5rem !important;

        box-sizing: border-box !important;
    }


    #Account_Statements #hide_debit_entries {

        margin: 0 0.4rem 0 0 !important;
    }


    #Account_Statements #hide_debit_entries + label {

        margin: 0 !important;

        font-size: 0.72rem !important;

        color: #666 !important;
    }


    /* -----------------------------------------------------
       SUMMARY BALANCE
       ----------------------------------------------------- */

    #Account_Statements > .card > .row:first-child > .justify-content-end {

        grid-column: 1 / 3 !important;
        grid-row: 5 !important;

        width: 100% !important;

        margin: 0.25rem 0 0 0 !important;

        padding: 0 !important;

        display: block !important;
    }


    #Account_Statements > .card > .row:first-child > .justify-content-end table {

        width: 100% !important;

        margin: 0 !important;

        border-collapse: separate !important;

        border-spacing: 0 !important;

        border-radius: 0.6rem !important;

        overflow: hidden !important;
    }


    #Account_Statements > .card > .row:first-child > .justify-content-end td {

        padding: 0.55rem !important;

        font-size: 0.68rem !important;

        border: 1px solid #ddd !important;
    }


    #Account_Statements > .card > .row:first-child > .justify-content-end td:first-child {

        width: 65% !important;

        font-size: 0.63rem !important;
    }

    #Account_Statements > .card > .row:first-child > .justify-content-end td:last-child {

        width: 35% !important;

        font-size: 0.72rem !important;
    }


    /* -----------------------------------------------------
       STATEMENT TABLE
       ----------------------------------------------------- */

    #Account_Statements .table-responsive {

        width: 100% !important;

        overflow: visible !important;

        margin-top: 0.8rem !important;
    }


    #organization_Account_statment_table {

        display: block !important;

        width: 100% !important;

        border: none !important;

        border-collapse: separate !important;

        border-spacing: 0 !important;
    }


    #organization_Account_statment_table thead {

        display: none !important;
    }


    #organization_Account_statment_table tbody {

        display: block !important;

        width: 100% !important;
    }


    /* -----------------------------------------------------
       STATEMENT CARD
       ----------------------------------------------------- */

    #organization_Account_statment_table tbody tr {

        display: grid !important;

        grid-template-columns: 1fr 1fr 1fr !important;

        width: 100% !important;

        margin: 0 0 0.8rem 0 !important;

        padding: 0.9rem !important;

        background: #fff !important;

        border: 1px solid #e7e9ed !important;

        border-radius: 0.8rem !important;

        box-shadow: 0 2px 8px rgba(0,0,0,0.045) !important;

        box-sizing: border-box !important;

        overflow: hidden !important;
    }


    #organization_Account_statment_table tbody td {

        display: block !important;

        width: auto !important;

        min-width: 0 !important;

        margin: 0 !important;

        padding: 0 !important;

        border: none !important;

        background: transparent !important;

        text-align: left !important;

        word-break: break-word !important;

        font-size: 0.77rem !important;

        line-height: 1.35 !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       1. ORDER ID
       ===================================================== */

    #organization_Account_statment_table tbody td:nth-child(2) {

        grid-column: 1 / 6 !important;

        grid-row: 1 !important;

        padding-bottom: 0.7rem !important;

        margin-bottom: 0.1rem !important;

        border-bottom: 1px solid #eeeeee !important;

        font-size: 0.88rem !important;

        font-weight: 700 !important;

        color: #333 !important;
    }


    /*
     * No label for Order ID
     */


    /* =====================================================
       COMMON LABEL
       ===================================================== */

    #organization_Account_statment_table tbody td:nth-child(1)::before,
    #organization_Account_statment_table tbody td:nth-child(3)::before,
    #organization_Account_statment_table tbody td:nth-child(4)::before,
    #organization_Account_statment_table tbody td:nth-child(5)::before,
    #organization_Account_statment_table tbody td:nth-child(6)::before,
    #organization_Account_statment_table tbody td:nth-child(7)::before,
    #organization_Account_statment_table tbody td:nth-child(8)::before,
    #organization_Account_statment_table tbody td:nth-child(9)::before,
    #organization_Account_statment_table tbody td:nth-child(10)::before,
    #organization_Account_statment_table tbody td:nth-child(11)::before {

        display: block !important;

        margin-bottom: 0.25rem !important;

        color: black !important;

        font-size: 0.6rem !important;

        font-weight: 600 !important;

        text-transform: uppercase !important;

        letter-spacing: 0.03rem !important;
    }

    .organization-unique-styles table tr {
        color: #999 !important;
    }
    /* =====================================================
       2. DATE
       3. TRANSACTION TYPE
       4. PAYMENT TYPE
       ===================================================== */

    #organization_Account_statment_table tbody td:nth-child(1) {

        grid-column: 1 / 3 !important;

        grid-row: 2 !important;

        padding-right: 0.4rem !important;

        margin-top: 0.7rem !important;
    }

    #organization_Account_statment_table tbody td:nth-child(1)::before {
        content: "Date";
    }


    #organization_Account_statment_table tbody td:nth-child(4) {

        grid-column: 2 / 4 !important;

        grid-row: 2 !important;

        padding: 0 0.2rem !important;

        margin-top: 0.7rem !important;
        text-align: center;
    }

    #organization_Account_statment_table tbody td:nth-child(4)::before {
        content: "Transaction Type";
    }


    #organization_Account_statment_table tbody td:nth-child(3) {

        grid-column: 4 / 6 !important;

        grid-row: 2 !important;

        padding-left: 0.4rem !important;

        margin-top: 0.7rem !important;
    }

    #organization_Account_statment_table tbody td:nth-child(3)::before {
        content: "Payment Type";
    }


    /* =====================================================
       3. NOTE
       ===================================================== */

    #organization_Account_statment_table tbody td:nth-child(5) {

        grid-column: 1 / 6 !important;

        grid-row: 3 !important;

        margin-top: 0.8rem !important;

        padding-top: 0.7rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #organization_Account_statment_table tbody td:nth-child(5)::before {
        content: "Note";
    }


    /* =====================================================
       4. AMOUNT + PAYMENT
       ===================================================== */

    #organization_Account_statment_table tbody td:nth-child(6) {

        grid-column: 1 / 3 !important;

        grid-row: 4 !important;

        margin-top: 0.8rem !important;

        padding-top: 0.7rem !important;

        padding-right: 0.4rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #organization_Account_statment_table tbody td:nth-child(6)::before {
        content: "Amount";
    }


    #organization_Account_statment_table tbody td:nth-child(7) {

        grid-column: 3 / 6 !important;

        grid-row: 4 !important;

        margin-top: 0.8rem !important;

        padding-top: 0.7rem !important;

        padding-left: 0.4rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #organization_Account_statment_table tbody td:nth-child(7)::before {
        content: "Payment";
    }


    /* =====================================================
       5. PROCESSING FEE + TOTAL PAID
       ===================================================== */

    #organization_Account_statment_table tbody td:nth-child(8) {

        grid-column: 1 / 3 !important;

        grid-row: 5 !important;

        margin-top: 0.8rem !important;

        padding-top: 0.7rem !important;

        padding-right: 0.4rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #organization_Account_statment_table tbody td:nth-child(8)::before {
        content: "Paid Processing Fee";
    }


    #organization_Account_statment_table tbody td:nth-child(9) {

        grid-column: 3 / 6 !important;

        grid-row: 5 !important;

        margin-top: 0.8rem !important;

        padding-top: 0.7rem !important;

        padding-left: 0.4rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #organization_Account_statment_table tbody td:nth-child(9)::before {
        content: "Total Paid Amount";
    }


    /* =====================================================
       6. DEBIT ENTRY + BALANCE
       ===================================================== */

    #organization_Account_statment_table tbody td:nth-child(10) {

        grid-column: 1 / 3 !important;

        grid-row: 6 !important;

        margin-top: 0.8rem !important;

        padding-top: 0.7rem !important;

        padding-right: 0.4rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #organization_Account_statment_table tbody td:nth-child(10)::before {
        content: "Debit Entry";
    }


    #organization_Account_statment_table tbody td:nth-child(11) {

        grid-column: 3 / 6 !important;

        grid-row: 6 !important;

        margin-top: 0.8rem !important;

        padding-top: 0.7rem !important;

        padding-left: 0.4rem !important;

        border-top: 1px solid #eeeeee !important;
    }

    #organization_Account_statment_table tbody td:nth-child(11)::before {
        content: "Balance";
    }


    /* =====================================================
       EMPTY FIELD
       ===================================================== */

    #organization_Account_statment_table tbody td:empty {
        display: none !important;
    }


    /* Hide cells containing only whitespace */
    #organization_Account_statment_table tbody td:has(:only-child:empty) {
        display: none !important;
    }


    /* =====================================================
       SMALL MOBILE
       ===================================================== */

    @media (max-width: 400px) {

        #Account_Statements .invoice-inputs {
            font-size: 0.72rem !important;
        }

        #Account_Statements #pin-filter2,
        #Account_Statements #export_button,
        #Account_Statements #pdf_export_button {
            font-size: 0.66rem !important;
        }

        #organization_Account_statment_table tbody tr {
            padding: 0.75rem !important;
        }

        #organization_Account_statment_table tbody td {
            font-size: 0.72rem !important;
        }

        #organization_Account_statment_table tbody td::before {
            font-size: 0.57rem !important;
        }
    }
    #Account_Statements thead {
        display: none;
    }

    #organization_Account_statment_table tbody td:empty {
        display: none !important;
    }

    #organization_Account_statment_table tbody td:has(span:empty),
    #organization_Account_statment_table tbody td:has(div:empty),
    #organization_Account_statment_table tbody td:has(a:empty) {
        display: none !important;
    }
    #organization_Account_statment_table_length,
    #organization_Account_statment_table_filter {
        text-align: left !important;
    }
    #organization_Account_statment_table_wrapper .row .col-sm-12{
        padding-left: unset !important;
    }
    #organization_Account_statment_table_filter label,
    #organization_Account_statment_table_filter label input {
        width: 90% !important;
    }

    .mobile_padding_10 {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

}


/* =====================================================
   MOBILE FLOATING SCROLL DOWN BUTTON
   ===================================================== */

.mobile-scroll-down-btn{
    display: none;
}

@media (max-width: 767.98px){

    .mobile-scroll-down-btn{

        display: flex;

        position: fixed;

        right: 18px;
        bottom: 22px;

        width: 52px;
        height: 52px;

        border: none;
        border-radius: 50%;

        align-items: center;
        justify-content: center;

        background: linear-gradient(135deg,#222,#444);

        color: #fff;

        font-size: 1.1rem;

        cursor: pointer;

        z-index: 9999;

        box-shadow:
            0 8px 25px rgba(0,0,0,.25),
            0 2px 8px rgba(0,0,0,.15);

        transition: all .25s ease;

        animation: scrollBounce 2s infinite;
    }

    .mobile-scroll-down-btn:active{
        transform: scale(.92);
    }

    .mobile-scroll-down-btn i{
        pointer-events: none;
    }


    @keyframes scrollBounce{

        0%,100%{
            transform: translateY(0);
        }

        50%{
            transform: translateY(6px);
        }

    }


    /* Hide button when bottom reached */

    .mobile-scroll-down-btn.hide-scroll-btn{

        opacity: 0;

        visibility: hidden;

        transform: translateY(20px);

        pointer-events: none;
    }

}

@media (max-width: 767.98px) {

    .organization-customer-portal::after {
        content: "C Portal";
        margin-left: 5px;
        vertical-align: middle;
        color: #6b7280;
        font-size: 11px;
        font-weight: 700;
    }

}


    /* Organization Samples & Swatches */
    .sample-workflow-wrap {
        padding: 14px 4px 24px;
    }
    .sample-workflow-card {
        background: #ffffff;
        border: 1px solid #e4e7eb;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
        padding: 20px;
    }
    .sample-workflow-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #eceff2;
        margin-bottom: 18px;
    }
    .sample-workflow-title {
        color: #161617;
        font-size: 1rem;
        font-weight: 700;
        margin: 0 0 4px;
    }
    .sample-workflow-subtitle {
        color: #8a8f98;
        font-size: .72rem;
        margin: 0;
    }
    .sample-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-width: 92px;
        justify-content: center;
        padding: 6px 12px;
        border-radius: 14px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .35px;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .sample-status-badge.status-received {
        color: #9a6b00;
        background: #fff7dc;
        border: 1px solid #f3d579;
    }
    .sample-status-badge.status-delivered {
        color: #16775f;
        background: #e6fbf5;
        border: 1px solid #9ce5d3;
    }
    .sample-status-badge.status-empty {
        color: #6b7280;
        background: #f3f4f6;
        border: 1px solid #d9dde2;
    }
    .sample-field-label {
        display: block;
        color: #323232;
        font-size: .72rem;
        font-weight: 700;
        margin-bottom: 6px;
    }
    .sample-field-help {
        color: #a0a4aa;
        font-size: .66rem;
        margin-top: 4px;
    }
    .sample-control {
        border: 1px solid #dfe3e8 !important;
        border-radius: 3px !important;
        color: #5f6368 !important;
        font-size: .76rem !important;
        min-height: 34px;
        background-color: #fff !important;
    }
    .sample-control[readonly],
    .sample-control:disabled {
        background-color: #f4f6f8 !important;
        cursor: not-allowed;
    }
    .sample-section {
        border: 1px solid #e8ebee;
        margin-bottom: 16px;
        background: #fbfbfc;
    }
    .sample-section-header {
        padding: 11px 14px;
        border-bottom: 1px solid #e8ebee;
        background: #f5f6f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .sample-section-title {
        color: #222;
        font-size: .78rem;
        font-weight: 700;
        margin: 0;
    }
    .sample-section-body {
        padding: 14px;
    }
    .sample-two-column-row {
        margin-left: -6px;
        margin-right: -6px;
    }
    .sample-two-column-col {
        display: flex;
        padding-left: 6px;
        padding-right: 6px;
    }
    .sample-equal-section {
        width: 100%;
        display: flex;
        flex-direction: column;
    }
    .sample-equal-section .sample-section-body {
        flex: 1;
    }
    .sample-two-column-row .sample-product-row {
        grid-template-columns: minmax(0, 1fr) minmax(100px, 140px) 34px;
    }
    .sample-notes-body {
        display: flex;
        flex-direction: column;
    }
    .sample-note-textarea {
        flex: 1 1 auto;
        min-height: 215px;
        height: 100%;
        resize: vertical !important;
        overflow-y: auto;
        box-sizing: border-box;
    }
    .sample-note-editor-wrapper {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        width: 100%;
        position: relative;
        min-height: 215px;
        height: 215px;
        resize: vertical;
        overflow: auto;
        box-sizing: border-box;
    }
    .sample-note-editor-wrapper .Editor-container {
        max-width: 100% !important;
        width: 100% !important;
        border: 1px solid #e3e5e8 !important;
        border-radius: 4px !important;
        background: #fff;
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        height: 100%;
        min-height: 100%;
        box-sizing: border-box;
    }
    .sample-note-editor-wrapper .line-control-menu-bar {
        background: #f8f9fa !important;
        border: 0 !important;
        border-bottom: 1px solid #e5e7eb !important;
        padding: 5px 8px !important;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 3px;
        min-height: auto !important;
        flex: 0 0 auto !important;
    }
    .sample-note-editor-wrapper .line-control-menu-bar .btn-group {
        margin: 1px 2px !important;
    }
    .sample-note-editor-wrapper .line-control-menu-bar .btn {
        padding: 3px 7px !important;
        font-size: 12px !important;
        border-radius: 3px !important;
        background: #fff;
        border: 1px solid #dee2e6;
        color: #495057;
    }
    .sample-note-editor-wrapper .line-control-menu-bar .btn:hover {
        background: #e9ecef;
    }
    .sample-note-editor-wrapper .toolbar-image-btn {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        padding: 3px 9px !important;
        border-radius: 4px;
        background: #5e72e4;
        color: #fff !important;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        border: none;
        transition: background 0.15s ease, transform 0.15s ease;
    }
    .sample-note-editor-wrapper .toolbar-image-btn:hover {
        background: #4c63d4;
        color: #fff !important;
        transform: scale(1.03);
    }
    .sample-note-editor-wrapper .Editor-editor {
        flex: 1 1 auto !important;
        min-height: 0 !important;
        height: auto !important;
        max-height: none !important;
        padding: 10px 12px !important;
        font-size: 13px !important;
        color: #374151 !important;
        line-height: 1.55 !important;
        overflow-y: auto !important;
        outline: none !important;
        word-break: break-word;
        background: #fff;
        resize: none !important;
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .sample-note-editor-wrapper .Editor-editor.drag-hover {
        background: #f0f7ff !important;
        border: 2px dashed #5e72e4 !important;
    }
    .sample-note-editor-wrapper .Editor-editor img,
    .zoomable-sample-image {
        max-width: 100% !important;
        max-height: 280px;
        height: auto;
        border-radius: 6px;
        margin: 6px 4px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        transition: transform 0.15s ease, opacity 0.15s ease;
        vertical-align: middle;
        border: 1px solid #e5e7eb;
    }
    .sample-note-editor-wrapper .Editor-editor img:hover,
    .zoomable-sample-image:hover {
        transform: scale(1.02);
        opacity: 0.95;
        box-shadow: 0 4px 12px rgba(0,0,0,0.18);
    }
    .sample-note-editor-wrapper .line-control-status-bar {
        display: none !important;
    }
    .sample-image-upload-progress {
        width: 100%;
        height: 6px;
        background: #e9ecef;
        border-radius: 20px;
        overflow: hidden;
        margin-top: 6px;
        position: relative;
    }
    .sample-image-upload-progress .image-upload-progress-bar {
        width: 0%;
        height: 100%;
        background: #2dce89;
        transition: width 0.1s ease;
    }
    .sample-image-upload-progress .image-upload-progress-text {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        font-size: 8px;
        font-weight: 700;
        color: #212529;
    }
    .image-preview-modal {
        display: none;
        position: fixed;
        z-index: 105000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.88);
        justify-content: center;
        align-items: center;
        overflow: hidden;
        animation: fadeIn 0.2s ease;
    }
    .image-zoom-controls {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(20, 20, 20, 0.75);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-radius: 30px;
        padding: 6px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 105002;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    }
    .zoom-btn {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: #ffffff;
        font-size: 14px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        outline: none !important;
    }
    .zoom-btn:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: scale(1.1);
        color: #ffffff;
    }
    .zoom-btn.image-zoom-reset {
        width: auto;
        border-radius: 20px;
        padding: 0 12px;
        font-size: 12px;
        font-weight: 600;
        gap: 5px;
    }
    .zoom-level-text {
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        min-width: 42px;
        text-align: center;
        user-select: none;
    }
    .image-preview-wrapper {
        position: relative;
        max-width: 88vw;
        max-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: visible;
        user-select: none;
        cursor: grab;
    }
    .image-preview-wrapper.is-zoomed {
        cursor: grab;
    }
    .image-preview-wrapper.is-panning {
        cursor: grabbing !important;
    }
    .image-preview-content {
        max-width: 88vw;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        transform-origin: center center;
        transition: transform 0.15s ease-out;
        will-change: transform;
    }
    .image-preview-wrapper.is-panning .image-preview-content {
        transition: none !important;
    }
    .image-preview-close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: white;
        font-size: 40px;
        cursor: pointer;
        font-weight: bold;
        z-index: 105002;
        line-height: 1;
    }
    .image-preview-close:hover {
        opacity: 0.7;
    }
    .image-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        border: none;
        font-size: 28px;
        width: 46px;
        height: 46px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 105001;
        transition: all 0.2s ease;
        outline: none !important;
    }
    .image-nav-btn:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: translateY(-50%) scale(1.1);
    }
    .image-prev-btn {
        left: 25px;
    }
    .image-next-btn {
        right: 25px;
    }
    .sample-product-row {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) minmax(130px, 220px) 36px;
        gap: 10px;
        align-items: end;
        margin-bottom: 10px;
    }
    .sample-product-row:last-child {
        margin-bottom: 0;
    }
    .sample-remove-row {
        height: 34px;
        width: 34px;
        border: 1px solid #e3e5e8;
        background: #fff;
        color: #a0a4aa;
        cursor: pointer;
        border-radius: 3px;
    }
    .sample-remove-row:hover {
        color: #d75d62;
        border-color: #efb5b8;
        background: #fff7f7;
    }
    .sample-add-row {
        border: 0;
        background: transparent;
        color: #47D6B6;
        font-size: .7rem;
        font-weight: 700;
        cursor: pointer;
        outline: none !important;
    }
    .sample-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding-top: 4px;
    }
    .sample-save-btn,
    .sample-deliver-btn {
        border: 0;
        padding: 8px 18px;
        font-size: .72rem;
        font-weight: 700;
        cursor: pointer;
        min-width: 125px;
    }
    .sample-save-btn {
        background: #47D6B6;
        color: #fff;
    }
    .sample-save-btn:disabled {
        background: #ababab !important;
        color: #fff;
        cursor: not-allowed;
        opacity: 0.5;
    }
    .sample-save-btn:hover:not(:disabled) {
        background: #38c5a7;
    }
    .sample-save-btn:disabled:hover {
        background: #75918b !important;
        color: #fff;
        cursor: not-allowed;
        opacity: 0.5;
    }
    .sample-deliver-btn {
        background: #33383e;
        color: #fff;
    }
    .sample-deliver-btn:hover {
        background: #202428;
    }
    .sample-tracking-group {
        display: flex;
        width: 100%;
    }
    .sample-tracking-group .sample-control {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
    .sample-copy-btn {
        background-color: #47D6B6;
        border: 1px solid #47D6B6 !important;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-top-right-radius: 3px !important;
        border-bottom-right-radius: 3px !important;
        color: #fff !important;
        font-size: .74rem !important;
        font-weight: 700 !important;
        padding: 0 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 34px;
        min-height: 34px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        line-height: 1;
        z-index: inherit !important;
    }
    .sample-copy-btn:hover {
        background-color: #38c5a7;
        border-color: #38c5a7 !important;
        color: #fff !important;
    }
    .sample-copy-btn.copied {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        color: #fff !important;
    }
    .sample-copy-btn:focus {
        box-shadow: none !important;
        outline: none !important;
    }
    #sample_fabric_swatches + .select2 {
        width: 100% !important;
        min-height: 34px !important;
    }
    #sample_fabric_swatches + .select2 .select2-selection--multiple {
        min-height: 34px !important;
        border: 1px solid #dfe3e8 !important;
        border-radius: 3px !important;
        background: #fff !important;
    }
    .sample-product-row .select2-container {
        width: 100% !important;
    }
    .sample-product-row .select2-selection--single {
        min-height: 34px !important;
        border: 1px solid #dfe3e8 !important;
        border-radius: 3px !important;
        background: #fff !important;
    }
    .sample-product-row .select2-selection__rendered {
        line-height: 32px !important;
        font-size: .76rem !important;
    }
    .sample-product-row .select2-selection__arrow {
        height: 32px !important;
    }
    @media (max-width: 767px) {
        .sample-workflow-header {
            flex-direction: column;
        }
        .sample-two-column-col {
            display: block;
        }
        .sample-note-textarea {
            min-height: 130px;
        }
        .sample-product-row {
            grid-template-columns: 1fr;
        }
        .sample-remove-row {
            width: 100%;
        }
        .sample-actions {
            flex-direction: column-reverse;
        }
        .sample-save-btn,
        .sample-deliver-btn {
            width: 100%;
        }
    }

</style>

@section('back-btn')
    <a @if($orders->count() > 0) href="{{ route('organizations', ['type' => 'organizations_customers']) }}" class="home-btn-color" title="Back to customers">BACK TO CUSTOMERS</a> @else <a href="{{ route('organizations', ['type' => 'organizations_leads']) }}" class="home-btn-color" title="Back to leads">BACK TO LEADS</a> @endif
@endsection

<button type="button" id="mobileScrollDownBtn" class="mobile-scroll-down-btn" title="Scroll to bottom">
    <i class="fas fa-chevron-down"></i>
</button>

<div class="container-fluid mb-5 content-position organization-unique-styles">
    <div class="se-pre-con"></div>

    @foreach ($organizations as $organization)


    <div class="col-md-12 btn-top" style="display: none">
        <div class="row ">
            <div class="col-md-3 div_display1 div_display"></div>
            <div class="col-md-9 btn-right set_width1">
                <div class="row btn_set1">
                    <div class="col-md-2 div_display1"></div>
                    <div class="col-md-2 btns-padding">
                        <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" id="add_organization" title="Add Organization">
                            Add Organization
                        </button>
                    </div>
                    <div class="col-md-2 btns-padding">

                    </div>
                    <div class="col-md-2 btns-padding">

                    </div>
                    <div class="col-md-2 btns-padding">
                        <button class="btns-text btns-style btns-card" title="CSV Export" style="outline: unset;" href="#" id="export_csv" data-href="{{ route('people.export_csv') }}" onclick="exportTasks(event.target);">
                           CSV Export
                        </button>
                    </div>
                    <div class="col-md-2 btns-padding">
                        <button class="btns-text btns-style btns-card" title="Change Table Layout" style="outline: unset;"  href="#"  data-toggle="modal" data-target="#layout_modal">
                            Fields &amp; Layouts
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <form action="{{ route('organizations.update') }}" id="organization_update" method="post" enctype="multipart/form-data">
            @csrf

            {{-- @section('order-header')
                <div class="col-md-12 ">
                    <div class="row details-position fl-nowrap header-img-position">
                        <div>
                            @if (isset($organization->organization_logo) && $organization->organization_logo != '')
                                <img class="pic-size btn-round" alt="Image placeholder" src="{{ asset('') }}/{{ $organization->organization_logo }}" id="image_preview" />
                            @else
                                <img class="pic-size btn-round" alt="Image placeholder" src="{{ asset('assets') }}/img/organization/default.png" id="image_preview" />
                            @endif
                        </div>
                        @if (isset($organization->sportDetails->sport_image) && $organization->sportDetails->sport_image != '')
                            <div class="pic2-position btn-round">
                                    <img class=" btn-round sport-icon" alt="Image placeholder" src="{{ asset('assets') }}/{{ $organization->sportDetails->sport_image }}" style="width: 40px; height: 40px;" />
                            </div>
                        @endif
                        <div class="name-position">
                            <h4 class="mb-0 w-200 w-set" style="text-align: left; font-size: 13px; position: relative; top: 0.7rem;">
                                <span class="d-block details-name text-color">{{$organization->organization_name}}</span>
                                <span class="d-block details-email text-color">{{$organization->website}}</span>
                            </h4>
                        </div>
                    </div>
                </div>
            @endsection --}}
            {{-- @section('order-header')

            <span style="font-size: 1rem;">{{$organization->organization_name}}</span>

            @endsection --}}

                {{-- <div class="col-md-12">
                <div class="row ">
                    <div class="col-md-5"></div>
                    <div  class="col-md-7">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-2 add-btn-padding btn-position-right">
                                    <div class="card btn-add-order">
                                            <span>
                                                <a class="btn-txt-size btn-text-top add-btn-right" style="color: #787878" href="#"  id="add_organization">
                                                    <i class="fas fa-solid fa-plus fa-fade" style="color: #787878;">   Organization</i>
                                                </a>
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-2 btn-position-right">
                                        <div class="card">
                                                <span>
                                                    <button type="button" class="btn-txt-size btn-text-top map-btn-right" style="color: #787878; background-color: transparent; border: unset;" href="#" id="show_map" value="{{$organization->id}}">
                                                        <i class="fas fa-map-marker-alt" style="color: #808080;">  Show Map</i>
                                                    </button>
                                                </span>
                                        </div>
                                </div>
                                <div class="col-md-2">
                                        <div class="card">
                                                <span>
                                                    <a type="button" class="btn-txt-size btn-text-top add-btn-right" style="color: #787878" href="#">
                                                        <i class="fas fa-envelope" style="color: #808080;">  Send Mail</i>
                                                    </a>
                                                </span>
                                        </div>
                                </div>
                                <div class="col-md-2 btn-position-left">
                                        <div class="card">
                                                <span>
                                                    <a type="button" class="btn-txt-size btn-text-top export-btn-right" style="color: #787878" href="#" id="export_csv" data-href="{{ route('people.export_csv') }}" onclick="exportTasks(event.target);">
                                                        <i class="fas fa-envelope" style="color: #808080;">  Export</i>
                                                    </a>
                                                </span>
                                        </div>
                                </div>
                                <div class="col-md-2 layout-btn-padding btn-position-left">
                                        <div class="card">
                                                <span>
                                                    <a type="button" class="btn-txt-size btn-text-top" style="color: #787878" href="#"  data-toggle="modal" data-target="#layout_modal">
                                                        <i class="fas fa-wrench" style="color: #808080;">  Fields &amp; Layouts</i>
                                                    </a>
                                                </span>
                                        </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div> --}}


            <input type="hidden" id="organization_id" name="organization_id" value="{{$organization->id}}" />
            <input type="hidden" id="organization_name" name="organization_name" value="{{$organization->organization_name}}" />

            <div class="col-md-12 content-position mobile_padding_10">
                <div style="border-radius: 0rem; background-color:transparent;border:none">
                    {{-- <div class="card-header rep-div-padding">
                        <div class="card-header-danger col-md-12">
                            <div class="row">
                                <div class="col-md-5 float-left header-details">

                                    @if (isset($organization->organization_logo) && $organization->organization_logo != '')
                                        <img alt="Image placeholder" src="{{ asset('') }}/{{ $organization->organization_logo }}" id="image_preview" />
                                    @else
                                        <img alt="Image placeholder" src="{{ asset('assets') }}/img/organization/default.png" id="image_preview" />
                                    @endif

                                    <div class="sport-ico-container align-middle text-center">
                                        @if (isset($organization->sportDetails->sport_image) && $organization->sportDetails->sport_image != '')
                                            <img alt="Image placeholder" src="{{ asset('assets') }}/{{ $organization->sportDetails->sport_image }}" style="width: 100%; height: 100%;" />
                                        @endif
                                    </div>

                                    <h4 class="mb-0">
                                        <span class="d-block details-name">{{$organization->organization_name}}</span>
                                        <span class="d-block details-email">{{$organization->website}}</span>
                                    </h4>
                                </div>

                                <div class="col-md-7 header-icons justify-content-end">
                                    <div class="row">
                                        <div class="col-md-2 text-center">
                                            <span>
                                                <button type="button" class="btn btn btn-round" id="show_map" value="{{$organization->id}}">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </button>
                                                <p>Show Map</p>
                                            </span>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <span>
                                                <button type="button" class="btn btn-round">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                                <p>Send Mail</p>
                                            </span>
                                        </div>
                                        @can('export organizations')
                                            <div class="col-md-2 text-center">
                                                <span>
                                                    <a class="btn btn-round" href="#" id="export_csv" data-href="{{ route('people.export_csv') }}" onclick="exportTasks(event.target);">
                                                        <i class="fas fa-file-csv"></i>
                                                    </a>
                                                    <p>Export</p>
                                                </span>
                                            </div>
                                        @endcan
                                        @can('add organizations')
                                            <div class="col-md-2 text-center">
                                                <span>
                                                    <button type="button" class="btn btn-round" id="add_organization">
                                                        <i class="fas fa-city"></i>
                                                    </button>
                                                    <p>Add Organization</p>
                                                </span>
                                            </div>
                                        @endcan
                                        <div class="col-md-2 text-center">
                                            <span>
                                                <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                                    <i class="fas fa-wrench"></i>
                                                </a>
                                                <p>Fields &amp; Layouts</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4 text-right">
                            <label><h5 for="user_id_info">Sales Rep</h5></label>
                            <select class="btn btn-secondary btn-secondary-custom select2-organization" style="display: inline;" class="form-control form-input" id="user_id_info" name="user_id" value="{{$organization->user_id}}">
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}"  {{ ($organization->user_id == $user->id) ? 'selected' : '' }} >{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                    <div>
                        <div class="row organization-mobile-wrapper">
                            <table style="width: 100%;" class="organization-mobile-table">
                                <tr class="organization-mobile-row">
                                    <td style="width: 1rem;">
                                        {{-- @if (isset($organization->organization_logo) && $organization->organization_logo != '')
                                            <img src="{{ asset('') }}/{{ $organization->organization_logo }}" style="width:100%;height:auto" id="image_previewe_info_header" />
                                        @else
                                            <img src="{{ asset('assets') }}/img/organization/default.png" style="width:100%;height:auto" id="image_previewe_info_header" />
                                        @endif --}}
                                    </td>
                                    <td class="organization-info-cell">
                                        <div class="row">
                                            <div class="col-md-12"><span style="font-size: 1.5rem;color: black;font-weight: 600;">{{$organization->organization_name}}</span></div>
                                            <div class="col-md-12" style="color: grey">{{$organization->created_at->format('Y-m-d')}}</div>
                                        </div>
                                    </td>
                                    <td class="organization-sales-rep-cell">
                                        <div class="d-flex align-items-center sales-rep-style" style="border: 1px solid #d3d3d3;border-radius: 1rem;height: 2rem;">
                                            <div style="margin-right: 10px;width: 6rem;color:#d3d3d3;border-right: 1px solid #d3d3d3;">&nbsp;&nbsp;Sales rep</div>
                                            <select class="btn btn-secondary btn-secondary-custom select2-organization form-control form-input" id="user_id_info" name="user_id" value="{{$organization->user_id}}">
                                                @foreach ($Sales_rep_users as $user)
                                                    <option value="{{$user->id}}" {{ ($organization->user_id == $user->id) ? 'selected' : '' }}>{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    @can('view organization password')
                                    <td style="width: 15rem;" class="organization-password-cell">
                                        <div style="display: flex; align-items: center;" class="organization-password-wrapper">
                                            <button type="button" class="organization-password-generate" style="border: none; padding: 0.54rem 0.8rem; color: black;cursor:pointer" onclick="GenerateRandomPassword()"><i class="fa fa-key" aria-hidden="true"></i></button>
                                            <div class="input-group organization-password-input-group" style="flex-grow: 1;">
                                                <input type="password" style="width: 75% !important; font-size: 1rem;border-radius:0rem" name="unique_password" id="unique_password" value="{{$organization->password_text}}" class="form-control" required>
                                                <div class="input-group-append">
                                                    <button type="button" title="Show & hide" style="color: grey; border: 0.5px solid #eaeaea; outline: unset; background-color: unset;" onclick="togglePasswordVisibility()">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @endcan
                                    <td class="organization-action-cell" style="width:17rem;">
                                        <div class="organization-action-buttons" style="display: flex; align-items: center;">
                                            <button class="mail_mail-button_2"  href="#" id="show_map" value="{{$organization->id}}" title="Show Map">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;Show Map
                                            </button>
                                            <button class="mail_mail-button_2  {{ empty($azure_logged_email) ? 'compose-btn-to-log' : 'compose-btn' }}"  type="button" title="Send Email">
                                                Send Mail
                                            </button>
                                            @can('admin login customer portal')
                                                <button
                                                    type="button"
                                                    class="mail_mail-button_2 organization-customer-portal"
                                                    title="Open Customer Portal"
                                                    onclick="openCustomerPortal({{ $organization->id }})"

                                                >
                                                    <i class="fa fa-external-link-alt" aria-hidden="true"></i>

                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="nav-wrapper organization-navbar">
                            <ul class="nav" id="tabs-icons-text" role="tablist">
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link active" id="tabs-icons-text-1-tab" data-toggle="tab" id="summery_tab" href="#summary" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">GENERAL INFO</a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" id="contactsTab" data-lazy-tab="contacts" href="#contacts" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Contacts">CONTACT PEOPLE
                                        ({{$contactCount}})
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" id="ordersTab" data-lazy-tab="orders" href="#quotes" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Orders">ORDERS
                                        ({{$orderCount}})
                                        <input type="hidden" id="orderCount" value="{{$orderCount}}"/>
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" id="Samples_SwatchesTab" href="#Samples_Swatches" role="tab" aria-controls="Samples_Swatches" aria-selected="false" title="Samples & Fabric Swatches">SAMPLES </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" id="paymentsTab" href="#payments-tab" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="PAYMENTS">INVOICE & PAYMENTS


                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#activities" id="activity_tab" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Activities">ACTIVITIES
                                        ({{$activityCount}})
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" id="emailsTab" data-lazy-tab="emails" href="#emails" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Emails">EMAILS
                                        ({{__($orgnizationEmailCount)}})
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" id="documentsTab" data-lazy-tab="documents" href="#documents" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Files">FILES</a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Projects">PROJECTS
                                        ({{__('0')}})
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" id="Account_StatementsTab" href="#Account_Statements" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Account Statements">ACCOUNT STATEMENTS

                                    </a>
                                </li>

                                {{-- <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" id="all_tab" href="#all-tab" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Files">ALL</a>
                                </li> --}}
                            </ul>
                        </div>

                        {{-- Summary Tab --}}
                        <div class="tab-content detail-section" id="myTabContent">
                            <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <div id="accordionExample">

                                    <div class="row mobile_padding_right_10">
                                        <div class="col-md-4 mb-2" style="padding-right: 5px">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-8 sub-header-style mb-3">
                                                            Organization
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-lable-info"><span style="font-size: .8rem;background-color: #b3b3b3;padding: 0.3rem 0.7rem;border-radius: 0.7rem;color: white;">{{$organization_status}}</span></label>
                                                        </div>
                                                        <div class="col-md-12 organization-mobile-info-block">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:25%"><label class="form-lable-info">Name</label></td>
                                                                    <td><input type="text" class="form-control info-form-input" id="organization_name" name="organization_name" value="{{$organization->organization_name}}" required></td>
                                                                </tr>
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em"><label class="form-lable-info">Website</label></td>
                                                                    <td><input type="text" class="form-control info-form-input" id="website" name="website" value="{{$organization->website}}" /></td>
                                                                </tr>
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em"><label class="form-lable-info">Club size</label></td>
                                                                    <td><input type="text" class="form-control info-form-input" id="size_of_club" name="size_of_club" value="{{$organization->size_of_club}}" /></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-12 organization-mobile-info-block">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:25%"><label class="form-lable-info">Sales Tax (%)</label></td>
                                                                    <td style="width:25%"><input type="text" class="form-control info-form-input" name="sales_tax" value="{{number_format($organization->sales_tax, 3)}}" /></td>
                                                                    <td style="line-height: 1.3em;width:25%"><label class="form-lable-info">Tax Active</label></td>
                                                                    <td style="width:25%"><select class="form-control info-form-input select2-organization" id="sales_tax_active_info" style="color: #717070" name="sales_tax_active">
                                                                            <option value="1" {{ ($organization->sales_tax_active == 1) ? 'selected' : '' }}>Yes</option>
                                                                            <option value="2" {{ ($organization->sales_tax_active == 2) ? 'selected' : '' }}>No</option>
                                                                        </select>
                                                                </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-12 organization-mobile-info-block">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width: 40%;"><label class="form-lable-info">Lead Source  <span class="text-danger">*</span></label></td>
                                                                    <td>
                                                                        <select class="form-control info-form-input select2-organization" id="lead_source" name="lead_source" style="color: #717070;border-radius: 0rem;" required>
                                                                            <option value="">Select lead source</option>
                                                                            @foreach ($lead_sources as $lead_source)
                                                                                <option value="{{$lead_source->id}}" {{ ($organization->lead_source == $lead_source->id) ? 'selected' : '' }}>{{$lead_source->lead_source_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width: 60%;"><label class="form-lable-info">Customer with White Labeling</label></td>
                                                                    <td>
                                                                        <input type="hidden" name="pl_status" value="0">
                                                                        <input type="checkbox" class="pl_status" id="pl_status" name="pl_status" value="1" {{ ($organization->pl_status) == 1 ? 'checked' : '' }}>
                                                                    </td>
                                                                </tr>
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width: 60%;"><label class="form-lable-info">Mark as Internal Team</label></td>
                                                                    <td>
                                                                        <input type="hidden" name="Internal_team_status" value="0">
                                                                        <input type="checkbox" class="Internal_team_status" id="Internal_team_status" name="Internal_team_status" value="1" {{ ($organization->internal_team) == 1 ? 'checked' : '' }}>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-8 sub-header-style mt-3">
                                                            Ordering Timeline
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <table class="custom_select_area_1" style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td>
                                                                        <select name="ordering_timeline[]" class="form-control form-input" id="ordering_timeline" multiple="multiple">
                                                                            @php
                                                                                $orderingTimeline = json_decode($organization->ordering_timeline, true) ?? [];
                                                                            @endphp
                                                                            <option value="1"{{ in_array('1', $orderingTimeline) ? ' selected' : '' }}>Fall Season</option>
                                                                            <option value="2"{{ in_array('2', $orderingTimeline) ? ' selected' : '' }}>Winter Season</option>
                                                                            <option value="3"{{ in_array('3', $orderingTimeline) ? ' selected' : '' }}>Spring Season</option>
                                                                            <option value="4"{{ in_array('4', $orderingTimeline) ? ' selected' : '' }}>Summer Season</option>
                                                                            <option value="5"{{ in_array('5', $orderingTimeline) ? ' selected' : '' }}>Year Around</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-12 mt-3" id="teamColor" data-toggle="collapse" data-target="#team-color" aria-expanded="false" aria-controls="collapseTwo">
                                                            <div class="row" style="padding-left: 15px;padding-right: 15px;">
                                                                <div class="sub-header-style">Team Colors</div>
                                                                <button type="button" class="add-text-button ml-auto" id="addColor" data-toggle="modal" data-target="#colorModal">ADD COLOR</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12  color-selection-box">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td class="custom_select_area">
                                                                        <select name="team_color[]" class="form-control form-input multy-selection" id="team_color" multiple="multiple">
                                                                            @foreach($colorMasters as $colorMaster)
                                                                                @php
                                                                                    $selected = in_array($colorMaster->id, $organizationColors->pluck('color_id')->toArray());
                                                                                @endphp
                                                                                <option value="{{ $colorMaster->id }}" data-hex="{{ $colorMaster->hex }}" @if($selected) selected @endif>{{ $colorMaster->pantone_code }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-12 sub-header-style mb-1 mt-3">
                                                            Organization Contacts
                                                        </div>

                                                        <div class="col-md-12" style="display: none">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:25%">
                                                                        <label class="form-lable-info">Email</label>
                                                                    </td>
                                                                    <td>
                                                                        <input type="email" class="form-control info-form-input" id="email" name="email" value="{{$organization->email}}" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-12 sub-header-style mt-2" style="font-size: .9rem">
                                                            Shipping Address
                                                        </div>
                                                        <div class="col-md-12 organization-address-mobile">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:40%">
                                                                        <label class="form-lable-info"> Country</label>
                                                                    </td>
                                                                    <td style="width:60%">
                                                                        <select class="form-control info-form-input" id="shipping_country" name="shipping_country">
                                                                            <option value="">Select a Country</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:40%">
                                                                        <label class="form-lable-info"> State</label>
                                                                    </td>
                                                                    <td style="width:60%">
                                                                        <input type="text" class="form-control info-form-input" id="shipping_state" name="shipping_state" value="{{$organization->shipping_state ??  ''}}" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table style="width:100%">

                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:30%">
                                                                        <label class="form-lable-info">Street Address</label>
                                                                    </td>
                                                                    <td style="width:70%">
                                                                        <input type="text" class="form-control info-form-input" id="shipping_street" name="shipping_street" value="{{$organization->shipping_street ??  ''}}" />
                                                                    </td>
                                                                </tr>

                                                            </table>
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:25%">
                                                                        <label class="form-lable-info"> City</label>
                                                                    </td>
                                                                    <td style="width:25%">
                                                                        <input type="text" class="form-control info-form-input" id="shipping_city" name="shipping_city" value="{{$organization->shipping_city ??  ''}}" />
                                                                    </td>
                                                                    <td style="line-height: 1.3em;width:25%">
                                                                        <label class="form-lable-info"> Postal Code</label>
                                                                    </td>
                                                                    <td style="width:25%">
                                                                        <input type="text" class="form-control info-form-input" id="shipping_postal_code" name="shipping_postal_code" value="{{$organization->shipping_postal_code ?? ''}}" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-12 sub-header-style mt-3" style="font-size: .9rem">
                                                            Billing Address
                                                        </div>
                                                        <div class="col-md-12 mt-2 mb-2 same-as-shipping-address">
                                                            <label class="d-flex align-items-center mb-0" for="same_as_shipping_address">
                                                                <input
                                                                    type="checkbox"
                                                                    class="same_as_shipping_address mr-2"
                                                                    id="same_as_shipping_address"
                                                                    name="same_as_shipping_address"
                                                                    value="1"
                                                                    {{ ($organization->same_as_shipping_address ?? 0) == 1 ? 'checked' : '' }}
                                                                >
                                                                <span class="form-lable-info mb-0" style="font-size: .9rem">Same as shipping address</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12 billing-address-details">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:40%">
                                                                        <label class="form-lable-info"> Country</label>
                                                                    </td>
                                                                    <td style="width:60%">
                                                                        <select class="form-control info-form-input" id="billing_country" name="billing_country">
                                                                            <option value="">Select a Country</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:40%">
                                                                        <label class="form-lable-info"> State</label>
                                                                    </td>
                                                                    <td style="width:60%">
                                                                        <input type="text" class="form-control info-form-input" id="billing_state" name="billing_state" value="{{$organization->billing_state ??  ''}}" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table style="width:100%">

                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:30%">
                                                                        <label class="form-lable-info">Street Address</label>
                                                                    </td>
                                                                    <td style="width:70%">
                                                                        <input type="text" class="form-control info-form-input" id="billing_street" name="billing_street" value="{{$organization->billing_street ??  ''}}" />
                                                                    </td>
                                                                </tr>

                                                            </table>
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:25%">
                                                                        <label class="form-lable-info"> City</label>
                                                                    </td>
                                                                    <td style="width:25%">
                                                                        <input type="text" class="form-control info-form-input" id="billing_city" name="billing_city" value="{{$organization->billing_city ??  ''}}" />
                                                                    </td>
                                                                    <td style="line-height: 1.3em;width:25%">
                                                                        <label class="form-lable-info"> Postal Code</label>
                                                                    </td>
                                                                    <td style="width:25%">
                                                                        <input type="text" class="form-control info-form-input" id="billing_postal_code" name="billing_postal_code" value="{{$organization->billing_postal_code ??  ''}}" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-12 sub-header-style mb-1 mt-3">
                                                            Sport
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:50%">
                                                                        <select class="form-control info-form-input select2-organization" onchange="set_sport_image({{$sports}},this.value)" id="sport_info" name="sport" value="{{$organization->sport}}" required>
                                                                            <option value="">Select a Sport</option>
                                                                            @foreach ($sports as $sport)
                                                                                <option value="{{$sport->sport_name}}" @if ($organization->sport == $sport->sport_name) selected @endif>{{$sport->sport_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <div id="image_container" style="width: 75%;height: auto;;border-radius: 0rem;padding: 1.5rem;">
                                                                            <img src="{{ !empty($organization->sport) ? asset('assets/' . optional($sports->where('sport_name', $organization->sport)->first())->sport_image) : asset('assets/img/organization/default.png') }}" id="sport-display-image" style="width:100%;height:auto" />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-12 sub-header-style mb-1 mt-3">
                                                            Organization Logo
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="line-height: 1.3em;width:50%">
                                                                        <input type="file" class="form-control form-input" id="organization_logoe_info" name="organization_logo" onchange="uploadFileInfo()" accept=".jpg,.jpeg,.png" style="width:100%; overflow: hidden;height: calc(1.8rem + 1px);border-radius: 0rem;" />
                                                                    </td>
                                                                    <td>
                                                                        <div id="image_container" style="width: 75%;height: auto;;border-radius: 0rem;padding: 1.5rem;">
                                                                            @if (isset($organization->organization_logo) && $organization->organization_logo != '')
                                                                                <img src="{{ asset('') }}/{{ $organization->organization_logo }}" style="width:100%;height:auto" id="image_previewe_info" />
                                                                            @else
                                                                                <img src="{{ asset('assets') }}/img/organization/default.png" style="width:100%;height:auto" id="image_previewe_info" />
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        {{-- <div class="col-md-12 sub-header-style mb-1 mt-3">
                                                            Organization Note
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="width: 30rem;">
                                                                        <textarea class="form-control info-form-input" id="organization_note" name="organization_note" cols="30" rows="6">{{ $organization->organization_note }}</textarea>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mb-2 mobile_organization_note">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="col-md-12 sub-header-style mb-1 mt-3 ml-4">
                                                            Organization Note
                                                        </div>
                                                        <div class="col-md-12 ml-4 mobile_margin_l_unset">
                                                            <table style="width:100%">
                                                                <tr style="border: none;">
                                                                    <td style="width: 30rem;">
                                                                        <textarea class="form-control info-form-input" id="organization_note" name="organization_note" cols="30" rows="6">{{ $organization->organization_note }}</textarea>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    <div class="row mt-4 pr-3">
                                                        <div class="col-md-12" id="scrolling_activities" style="max-height: 25rem;overflow-y: scroll;">
                                                            <div class="row mb-4">
                                                                <div class="col-md-6">
                                                                    <button type="button" id="focus_button" class="ml-4" style="font-size: 1rem;font-weight: 600;border: none;background-color: transparent;">Focus &nbsp;<i class="fa fa-chevron-down" aria-hidden="true"></i></button>
                                                                </div>
                                                            </div>
                                                            <ul class="cbp_tmtimeline" id="timeline_content_focus">

                                                            </ul>
                                                            <div class="row mb-4 mt-3">
                                                                <div class="col-md-6">
                                                                    <button type="button" id="history_button" class="ml-4" style="font-size: 1rem;font-weight: 600;border: none;background-color: transparent;">History &nbsp;<i class="fa fa-chevron-down" aria-hidden="true"></i></button>
                                                                </div>
                                                            </div>
                                                            <ul class="cbp_tmtimeline" id="timeline_content_history">

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="colorModal" tabindex="-1" role="dialog" aria-labelledby="colorModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="colorModalLabel">Add Color</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="addColorForm">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="pantoneCode">Pantone Code</label>
                                                            <input type="text" class="form-control" id="pantoneCode" name="pantoneCode" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary done">Add Color</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="colorModalNotExist" tabindex="-1" role="dialog" aria-labelledby="colorModalNotExistLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="colorModalNotExistLabel">Color does not exist. Please check.</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-lg-12 control-btns mb-5 organization-control-buttons" style="background-color: white;padding-top:0px;text-align:left">
                                @can('edit organizations')
                                    <button type="button" id="saveForm" style="background-color: #47D6B6" class="styled-button-decoration btn btn-success btn-custom mt-2">Save</button>
                                @endcan

                                @can('delete organizations')
                                    <button type="button" id="delete_form" style="background-color: #b3b3b3" class="styled-button-decoration btn btn-danger btn-custom mt-2" value="{{$organization->id}}">Delete</button>
                                @endcan
                                    <button type="reset" style="background-color: #d27070;color:white" class="styled-button-decoration btn btn-secondary btn-custom mt-2">Cancel</button>
                                </div>
                            </div>

{{--============================== Contacts ==================================== --}}
                            <div class="tab-pane fade organization-contacts-mobile" id="contacts" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                <div class="col-md-12 mt-3 card">

                                    <div class="ml-auto mb-3 mt-3">
                                        {{-- <a href="{{ route('people.add', ['organization_id'=>$organization->id]) }}" class="btn btn-secondary btn-secondary-custom" title="Add Contact"><i class="fas fa-plus"></i> Add Contact</a> --}}
                                        {{-- <a id="addOrRemoveContactsBtn" class="btn btn-secondary btn-secondary-custom" title="Add Contact"></a> --}}
                                        <button type="button" style="background-color: #f6f6f6;" class="mail_mail-button" id="addOrRemoveContactsBtn" title="Add Contact">Add / Remove Contacts</button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table align-items-center table-responsive organization-table" id="organization_contacts_table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">First Name</th>
                                                    <th scope="col" class="text-center">Last Name</th>
                                                    <th scope="col" class="text-center">Office Phone</th>
                                                    <th scope="col" class="text-center">Email</th>
                                                    <th scope="col" class="text-center">Title</th>
                                                    <th scope="col" class="text-center">Assigned To</th>
                                                    <th scope="col" class="text-center">Shipping City</th>
                                                    <th scope="col" class="text-center">Shipping Country</th>
                                                </tr>
                                            </thead>

                                            <tbody class="list" id="organization_contacts_tbody">
                                                <tr class="lazy-tab-placeholder">
                                                    <td colspan="8" class="text-center text-muted py-4">
                                                        Contact people will load when this tab is opened.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

{{--================================ Orders ======================================== --}}
                            <div class="tab-pane fade organization-orders-mobile" id="quotes" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                <div class="col-md-12 mt-3 card">

                                    <div class="ml-auto mb-3 mt-3">
                                        <a href="{{ route('new_orders', ['organization_id'=>$organization->id]) }}" style="background-color: #f6f6f6;" class="mail_mail-button"><i class="fas fa-plus"></i> Add New Orders</a>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table align-items-center organization-table" id="organization_orders_table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Order #</th>
                                                    <th scope="col" class="text-center">Sales Rep</th>
                                                    <th scope="col" class="text-right">Total ($)</th>
                                                    <th scope="col" class="text-center">Status</th>
                                                    <th scope="col" class="text-center">Due Date</th>
                                                </tr>
                                            </thead>

                                            <tbody class="list" id="organization_orders_tbody">
                                                <tr class="lazy-tab-placeholder">
                                                    <td colspan="5" class="text-center text-muted py-4">
                                                        Orders will load when this tab is opened.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
{{--================================ PAYMENTS ======================================== --}}
                            <div class="tab-pane fade" id="payments-tab" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                <div class="col-md-12 mt-3 card">
                                    <div class="row payment-filter-mobile" style="margin: 1px;">

                                        <div class="row filter_row" style="padding-bottom: 2px;margin:5px;margin-left:unset">
                                            <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Start Date |  </p>
                                            <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                                                <input type="text" name="start_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" id="payment_start_date">
                                            </div>
                                        </div>
                                        <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                                            <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">End Date |  </p>
                                            <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                                                <input type="text" name="end_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" id="payment_end_date">
                                            </div>
                                        </div>
                                        <div class="row filter_row" style="padding-bottom: 2px;margin:5px">
                                            <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                                                <select id="filterColumn" name="filterColumn" class=" summary-select2">
                                                    <option value="all" selected>All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                                    <option value="production_date">Based on Production Date</option>
                                                    <option value="ex_factory_date">Based on Ex-factory Date</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row " style="padding-bottom: 2px;margin:5px">
                                            <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                                                <button class="date_p filter_btn" type="button" id="pin-filter" title="Filter" style="height: 100%;">
                                                    <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="table-responsive">
                                        @if(Gate::check('create bulk invoice'))
                                            <div class="col-md-2 mt-2 mb-2" style="display:flex;padding-left: unset;">
                                                <input type="hidden" id="pay_multiple_invoices" name="pay_multiple_invoices[]" value="" />
                                                <button type="submit" class="btn multiple-pay-button btn-secondary btn-sm" title="Mark as paid" style="background-color: rgb(94 145 105);color:white;display:none" id="pay_multiple"><i class="far fa-check-circle"></i><small>Mark as paid (<span id="invoice_checked_count"></span>)</small></button>

                                            </div>
                                        @endif
                                        <table class="table align-items-center " id="organization_payments_table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">
                                                        <input type="checkbox" class="checkbox_of_invoice_all" id="checkbox_of_invoice_all" />
                                                    </th>
                                                    <th scope="col" class="text-center"></th>
                                                    <th scope="col" class="text-center">Order #</th>
                                                    <th scope="col" class="text-center">Total ($)</th>
                                                    <th scope="col" class="text-center">Paid ($)</th>
                                                    <th scope="col" class="text-center">Balance to Pay ($)</th>
                                                    <th scope="col" class="text-center">Status</th>
                                                    <th scope="col" class="text-center">Create Date</th>
                                                    <th scope="col" class="text-center">Invoice</th>
                                                </tr>
                                            </thead>

                                            <tbody class="list">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
{{--================================ Account Statements ======================================== --}}
                            <div class="tab-pane fade" id="Account_Statements" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                <div class="col-md-12 mt-3 card">
                                    <div class="row" style="margin: 1px;">

                                        <div class="row filter_row" style="padding-bottom: 2px;margin:5px;margin-left:unset;height: 40px;">
                                            <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">Start Date |  </p>
                                            <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                                                <input type="text" name="statment_start_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" id="sta_start_date">
                                            </div>
                                        </div>
                                        <div class="row filter_row" style="padding-bottom: 2px;margin:5px;height: 40px;">
                                            <p class="font_color date_p d_flex_and_align_center" style="padding-left: 5px;">End Date |  </p>
                                            <div class="paymen_type_div date_selection d_flex_and_align_center" style="padding-left: 7px;">
                                                <input type="text" name="statment_end_date" class="summary-datepicker invoice-inputs" style="height: 2rem;background-color:#F8F8F8;border: 1px solid #DEDEDE;" id="sta_end_date">
                                            </div>
                                        </div>
                                        <div class="row " style="padding-bottom: 2px;margin:5px;height: 40px;">
                                            <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                                                <button class="date_p filter_btn" type="button" id="pin-filter2" title="Filter" style="height: 100%;">
                                                    <i class="fa fa-filter"></i>&nbsp;&nbsp;Filter
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row " style="padding-bottom: 2px;margin:5px;height: 40px;">
                                            <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                                                <button class="date_p filter_btn" type="button" id="export_button" title="Export csv" style="height: 100%;">
                                                    <i class="fa fa-download"></i>&nbsp;&nbsp;Export
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row " style="padding-bottom: 2px;margin:5px;height: 40px;">
                                            <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                                                <button class="date_p filter_btn" type="button" id="pdf_export_button" title="Download pdf" style="height: 100%;">
                                                    <i class="fa fa-download"></i>&nbsp;&nbsp;PDF
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row " style="padding-bottom: 2px;margin:5px;height: 40px;">
                                            <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                                                <button class="styled-button" style="outline: unset;width: 95%;" href="#" data-toggle="modal" data-target="#statmetlayout_modal" title="Change Table Layout">
                                                    Table Layout
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-bottom: 2px; margin: 5px; height: 40px;">
                                            <div class="paymen_type_div date_selection d_flex_and_align_center select-width-style" style="padding-left: 7px;">
                                                <input type="checkbox" id="hide_debit_entries" name="hide_debit_entries" style="margin-right: 5px;color:grey" checked>
                                                <label for="hide_debit_entries" style="margin-bottom: 0;">Hide debit entries</label>
                                            </div>
                                        </div>

                                        <div class="row justify-content-end" style="margin: 1px;margin-left: auto;">
                                            <table class="table-bordered mb-1" style="" >
                                                {{-- <tr>
                                                    <td class="p-2 text-right" style="background-color: #d9d9d9;border: 1px solid #a7a7a7;"><p class="mb-0" style="font-size: 0.8rem;font-weight: 800;">CREDIT BALANCE</p></td>
                                                    <td class="p-2 text-right" style="border: 1px solid #a7a7a7;"><P class="mb-0 " style="font-size: 0.8rem;font-weight: 800;">$5500</P></td>
                                                </tr> --}}
                                                <tr>
                                                    <td class="p-2 text-right" style="background-color: #d9d9d9;border: 1px solid #a7a7a7;"> <p class="mb-0" style="font-size: 0.8rem;font-weight: 800;">CUSTOMER DEBIT BALANCE</p></td>
                                                    <td class="p-2 text-right" style="border: 1px solid #a7a7a7;"><P class="mb-0" id="DebitBalanceOfOrg" style="font-size: 0.8rem;font-weight: 800;">$000</P></td>
                                                </tr>
                                                <tr>
                                                    <td class="p-2 text-right" style="background-color: #d9d9d9;border: 1px solid #a7a7a7;"> <p class="mb-0" style="font-size: 0.8rem;font-weight: 800;">TOTAL OUTSTANDING</p></td>
                                                    <td class="p-2 text-right" style="border: 1px solid #a7a7a7;"><P class="mb-0" id="creditBalanceOfOrg" style="font-size: 0.8rem;font-weight: 800;">$000</P></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>



                                    <div class="table-responsive">

                                        <table class="table align-items-center " id="organization_Account_statment_table">
                                            <thead>
                                                <tr>

                                                    <th scope="col" class="statement-date text-center">Date</th>
                                                    {{-- <th scope="col" class="text-center">Transaction Id</th> --}}
                                                    <th scope="col" class="statement-order-no text-center">Order #</th>
                                                    <th scope="col" class="statement-payment-type text-center">Payment Type</th>
                                                    <th scope="col" class="statement-transaction-type text-center">Transaction Type</th>
                                                    <th scope="col" class="statement-note text-center">Note</th>
                                                    <th scope="col" class="statement-amount text-center">Amount ($)</th>
                                                    <th scope="col" class="statement-payment text-center">Payment ($)</th>
                                                    <th scope="col" class="statement-paid-processing-fee text-center">Paid Processing Fee ($)</th>
                                                    <th scope="col" class="statement-total-paid-amount text-center">Total Paid Amount ($)</th>
                                                    <th scope="col" class="statement-debit-entry text-center">Debit Entry ($)</th>
                                                    <th scope="col" class="statement-balance text-center">Balance ($)</th>
                                                    {{-- <th scope="col" class="text-center">Handled by</th> --}}
                                                </tr>
                                            </thead>

                                            <tbody class="list">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>


{{--================================ Samples & Fabric Swatches ======================================== --}}
                            <div class="tab-pane fade" id="Samples_Swatches" role="tabpanel" aria-labelledby="Samples_SwatchesTab">
                                @php
                                    $sampleProducts = $sampleShipment && is_array($sampleShipment->products)
                                        ? $sampleShipment->products
                                        : [];

                                    if (count($sampleProducts) === 0) {
                                        $sampleProducts = [['product_id' => null, 'size_id' => null]];
                                    }

                                    $selectedFabricSwatches = $sampleShipment && is_array($sampleShipment->fabric_swatches)
                                        ? $sampleShipment->fabric_swatches
                                        : [];

                                    $sampleHasData = !empty($sampleShipment);
                                    // $samplePersisted = $sampleShipment && $sampleShipment->exists;
                                    $sampleRequested = $sampleShipment && $sampleShipment->status === 'requested';
                                    $sampleDelivered = $sampleShipment && $sampleShipment->status === 'delivered';
                                    $sampleStatusText = $sampleHasData
                                        ? ($sampleDelivered ? 'Delivered' : 'Requested')
                                        : 'Not Added';

                                    // Use the saved sample shipping address when available.
                                    // If a sample address field has not been saved yet, fall back to the
                                    // organization's shipping address without changing the organization.
                                    $sampleShippingStreet = $sampleShipment && trim((string) $sampleShipment->shipping_street) !== ''
                                        ? $sampleShipment->shipping_street
                                        : ($organization->shipping_street ?? '');
                                    $sampleShippingCity = $sampleShipment && trim((string) $sampleShipment->shipping_city) !== ''
                                        ? $sampleShipment->shipping_city
                                        : ($organization->shipping_city ?? '');
                                    $sampleShippingState = $sampleShipment && trim((string) $sampleShipment->shipping_state) !== ''
                                        ? $sampleShipment->shipping_state
                                        : ($organization->shipping_state ?? '');
                                    $sampleShippingPostalCode = $sampleShipment && trim((string) $sampleShipment->shipping_postal_code) !== ''
                                        ? $sampleShipment->shipping_postal_code
                                        : ($organization->shipping_postal_code ?? '');
                                    $sampleShippingCountry = $sampleShipment && trim((string) $sampleShipment->shipping_country) !== ''
                                        ? $sampleShipment->shipping_country
                                        : ($organization->shipping_country ?? '');
                                @endphp

                                <div class="sample-workflow-wrap">
                                    <div class="sample-workflow-card">
                                        <div class="sample-workflow-header">
                                            <div>
                                                <h4 class="sample-workflow-title">Samples &amp; Fabric Swatches</h4>
                                                <p class="sample-workflow-subtitle">Track the one-time sample package for this organization, including products, sizes, fabric swatches, dates and delivery status.</p>
                                            </div>
                                            <span
                                                id="sampleShipmentStatus"
                                                class="sample-status-badge {{ !$sampleHasData ? 'status-empty' : ($sampleDelivered ? 'status-delivered' : 'status-received') }}"
                                            >
                                                <i class="fa {{ !$sampleHasData ? 'fa-minus-circle' : ($sampleDelivered ? 'fa-check-circle' : 'fa-clock-o') }}"></i>
                                                <span id="sampleShipmentStatusText">{{ $sampleStatusText }}</span>
                                            </span>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-6 col-sm-12 mb-3  pl-3 pr-2">
                                                <div class="row p-0">
                                                    <div class="col-md-3 col-sm-12">
                                                        <label class="sample-field-label" for="sample_received_date">Requested Date</label>
                                                        <input
                                                            type="text"
                                                            id="sample_received_date"
                                                            class="form-control sample-control summary-datepicker"
                                                            autocomplete="off"
                                                            placeholder="MM/DD/YYYY"
                                                            value="{{ $sampleShipment && $sampleShipment->received_date ? \Carbon\Carbon::parse($sampleShipment->received_date)->format('m/d/Y') : \Carbon\Carbon::now()->format('m/d/Y') }}"
                                                            @if($sampleRequested || $sampleDelivered)
                                                                readonly
                                                                style="pointer-events: none; background-color: #f4f6f8 !important; cursor: not-allowed;"
                                                                tabindex="-1"
                                                            @endif
                                                        >
                                                        {{-- <div class="sample-field-help">Date the sample package was requested.</div> --}}
                                                    </div>
                                                    <div class="col-md-3 col-sm-12">
                                                        <label class="sample-field-label" for="sample_delivered_date">Est. Delivered Date</label>
                                                        <input
                                                            type="text"
                                                            id="sample_delivered_date"
                                                            class="form-control sample-control {{ $sampleRequested ? 'summary-datepicker' : '' }}"
                                                            autocomplete="off"
                                                            placeholder="MM/DD/YYYY"
                                                            value="{{ $sampleShipment && $sampleShipment->delivered_date ? \Carbon\Carbon::parse($sampleShipment->delivered_date)->format('m/d/Y') : '' }}"
                                                            @if(!$sampleRequested)
                                                                readonly
                                                                style="pointer-events: none; background-color: #f4f6f8 !important; cursor: not-allowed;"
                                                                tabindex="-1"
                                                            @endif
                                                        >
                                                        {{-- <div class="sample-field-help">Optional until the package is confirmed delivered.</div> --}}
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <label class="sample-field-label" for="sample_tracking_number">Tracking Number</label>
                                                        <input
                                                            type="text"
                                                            id="sample_tracking_number"
                                                            class="form-control sample-control"
                                                            autocomplete="off"
                                                            placeholder="Tracking Number"
                                                            value="{{ $sampleShipment ? $sampleShipment->tracking_number : '' }}"
                                                            @if(!$sampleRequested)
                                                                readonly
                                                                style="pointer-events: none; background-color: #f4f6f8 !important; cursor: not-allowed;"
                                                                tabindex="-1"
                                                            @endif
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-3 pl-1">
                                                <label class="sample-field-label" for="sample_tracking_link">Tracking Link</label>
                                                <div class="input-group sample-tracking-group flex-nowrap">
                                                    <input
                                                        type="text"
                                                        id="sample_tracking_link"
                                                        class="form-control sample-control"
                                                        autocomplete="off"
                                                        placeholder="Tracking Link"
                                                        value="{{ $sampleShipment ? $sampleShipment->tracking_link : '' }}"
                                                        @if(!$sampleRequested)
                                                            readonly
                                                            style="pointer-events: none; background-color: #f4f6f8 !important; cursor: not-allowed;"
                                                            tabindex="-1"
                                                        @endif
                                                    >
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn sample-copy-btn" id="copySampleTrackingLink" title="Copy tracking link">
                                                            <i class="fa fa-clone mr-1"></i> Copy
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row sample-two-column-row">
                                            <div class="col-md-6 sample-two-column-col">
                                                <div class="sample-section sample-equal-section">
                                                    <div class="sample-section-header">
                                                        <h5 class="sample-section-title"><i class="fa fa-cube mr-2"></i>Product Samples</h5>
                                                        <button type="button" class="sample-add-row" id="addSampleProductRow">
                                                            <i class="fa fa-plus mr-1"></i> ADD PRODUCT
                                                        </button>
                                                    </div>
                                                    <div class="sample-section-body" id="sampleProductRows">
                                                        @foreach($sampleProducts as $sampleProduct)
                                                            <div class="sample-product-row">
                                                                <div>
                                                                    <label class="sample-field-label">Product</label>
                                                                    <select class="form-control sample-control sample-product-select">
                                                                        <option value="">Select product</option>
                                                                        @foreach($sub_products as $sub_product)
                                                                            <option
                                                                                value="{{ $sub_product->id }}"
                                                                                {{ (string)($sampleProduct['product_id'] ?? '') === (string)$sub_product->id ? 'selected' : '' }}
                                                                            >
                                                                                {{ $sub_product->product_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <label class="sample-field-label">Size</label>
                                                                    <select class="form-control sample-control sample-size-select">
                                                                        <option value="">Select size</option>
                                                                        @foreach($sizes as $size)
                                                                            <option
                                                                                value="{{ $size->id }}"
                                                                                {{ (string)($sampleProduct['size_id'] ?? '') === (string)$size->id ? 'selected' : '' }}
                                                                            >
                                                                                {{ $size->size_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <button type="button" class="sample-remove-row" title="Remove product">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 sample-two-column-col">
                                                <div class="sample-section sample-equal-section">
                                                    <div class="sample-section-header">
                                                        <h5 class="sample-section-title"><i class="fa fa-th-large mr-2"></i>Fabric Swatches</h5>
                                                    </div>
                                                    <div class="sample-section-body">
                                                        <label class="sample-field-label" for="sample_fabric_swatches">Select Fabric Swatches</label>
                                                        <select id="sample_fabric_swatches" class="form-control sample-control" multiple="multiple">
                                                            @foreach($fabrics as $fabric)
                                                                <option
                                                                    value="{{ $fabric->id }}"
                                                                    {{ in_array((string)$fabric->id, array_map('strval', $selectedFabricSwatches), true) ? 'selected' : '' }}
                                                                >
                                                                    {{ $fabric->fabric_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="sample-field-help">You can select multiple fabric swatches for the same organization package.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row sample-two-column-row">
                                            <div class="col-md-6 sample-two-column-col">
                                                <div class="sample-section sample-equal-section">
                                                    <div class="sample-section-header">
                                                        <h5 class="sample-section-title"><i class="fa fa-sticky-note mr-2"></i>Notes</h5>
                                                    </div>
                                                    <div class="sample-section-body sample-notes-body">
                                                        <label class="sample-field-label" for="sample_shipment_note">Sample / Delivery Note</label>
                                                        <div class="sample-note-editor-wrapper" style="min-height: 215px; resize: vertical; overflow: auto;">
                                                            <textarea
                                                                id="sample_shipment_note"
                                                                class="form-control sample-control sample-note-textarea"
                                                                style="resize: vertical;"
                                                                placeholder="Add sample details, swatch instructions, tracking note, contact note, etc."
                                                            >{{ $sampleShipment ? $sampleShipment->note : '' }}</textarea>

                                                            <input type="file" id="sample-note-file" name="sample_note_file[]" accept="image/*" multiple hidden />

                                                            <div class="sample-image-upload-progress image-upload-progress" style="display:none;">
                                                                <div class="image-upload-progress-bar"></div>
                                                                <div class="image-upload-progress-text">0%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 sample-two-column-col">
                                                <div class="sample-section sample-equal-section">
                                                    <div class="sample-section-header">
                                                        <h5 class="sample-section-title"><i class="fa fa-map-marker mr-2"></i>Shipping Address</h5>
                                                    </div>
                                                    <div class="sample-section-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="sample-field-label" for="sample_contact_id">Customer Name</label>
                                                                <select id="sample_contact_id" class="form-control sample-control">
                                                                    @php
                                                                        $sampleShipmentContactId = $sampleShipment->contact_id ?? null;
                                                                    @endphp
                                                                    @foreach($contacts as $key=>$contact)
                                                                        <option value="{{ $contact->id }}" {{ $contact->id == $sampleShipmentContactId || (!$sampleShipmentContactId && $key == 0) ? 'selected' : '' }}>{{ $contact->first_name }} {{ $contact->last_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="sample-field-label" for="sample_shipping_street">Street Address</label>
                                                                <input
                                                                    type="text"
                                                                    id="sample_shipping_street"
                                                                    class="form-control sample-control"
                                                                    maxlength="255"
                                                                    value="{{ $sampleShippingStreet }}"
                                                                    placeholder="Street address"
                                                                >
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="sample-field-label" for="sample_shipping_city">City</label>
                                                                <input
                                                                    type="text"
                                                                    id="sample_shipping_city"
                                                                    class="form-control sample-control"
                                                                    maxlength="255"
                                                                    value="{{ $sampleShippingCity }}"
                                                                    placeholder="City"
                                                                >
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="sample-field-label" for="sample_shipping_state">State</label>
                                                                <input
                                                                    type="text"
                                                                    id="sample_shipping_state"
                                                                    class="form-control sample-control"
                                                                    maxlength="255"
                                                                    value="{{ $sampleShippingState }}"
                                                                    placeholder="State"
                                                                >
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="sample-field-label" for="sample_shipping_postal_code">Postal Code</label>
                                                                <input
                                                                    type="text"
                                                                    id="sample_shipping_postal_code"
                                                                    class="form-control sample-control"
                                                                    maxlength="100"
                                                                    value="{{ $sampleShippingPostalCode }}"
                                                                    placeholder="Postal code"
                                                                >
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="sample-field-label" for="sample_shipping_country">Country</label>
                                                                <input
                                                                    type="text"
                                                                    id="sample_shipping_country"
                                                                    class="form-control sample-control"
                                                                    maxlength="255"
                                                                    value="{{ $sampleShippingCountry }}"
                                                                    placeholder="Country"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="sample-field-help">
                                                            Defaults to the organization's shipping address. You can change it for this sample package without changing the organization's main address.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sample-actions">
                                            @can('confirm sample package')
                                                <button
                                                    type="button"
                                                    class="sample-deliver-btn"
                                                    id="confirmSampleDelivered"
                                                    style="{{ (!$sampleRequested) ? 'display:none;' : '' }}"
                                                >
                                                    <i class="fa fa-check mr-1"></i> Confirm Sample
                                                </button>
                                            @endcan

                                            <button type="button" class="sample-save-btn" id="saveSampleShipment" {{ ($sampleRequested || $sampleDelivered) ? 'disabled' : '' }}>
                                                <i class="fa fa-paper-plane mr-1"></i> Request Samples
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

{{--================================== Activities ===================================== --}}
                            <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                                <div class="col-md-12 mt-3 card">



                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="drive-controls activity-top-controls mt-2 float-right" style="display: none;">
                                                    <form action="{{ route('activities.mark_as_done') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" id="mark_as_done_activites" name="mark_as_done_activites[]" />
                                                        <button type="submit" class="btn btn-secondary btn-sm mr-1" title="Mark as Done" id="mark_as_done"><i class="far fa-check-circle"></i><small>Mark as Done</small></button>
                                                    </form>

                                                    <form action="{{ route('activities.mark_as_todo') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" id="mark_as_todo_activites" name="mark_as_todo_activites[]" />
                                                        <button type="submit" class="btn btn-secondary btn-sm" title="Mark as To Do" id="mark_as_todo"><i class="far fa-times-circle"></i><small>Mark as To Do</small></button>
                                                    </form>
                                                    <form action="{{ route('activities.mark_as_delete') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" id="mark_to_delete_activites" name="mark_to_delete_activites[]" />
                                                        <button type="submit" class="btn btn-secondary btn-sm ml-1" title="Delete Selected" style="background-color: rgb(255 121 116);color:white" id="mark_as_deleted"><i class="fa fa-times-circle" aria-hidden="true"></i><small>Delete Selected</small></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-4 ml-auto">
                                                <div class="ml-auto mb-3 mt-3 text-right">
                                                    <button type="button" style="outline: unset;" class="btn-green-filled" id="add_new_activity" title="Add Activity">
                                                        <i class="fas fa-plus"></i> Add Activity
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 mb-3" style="padding-left: 0px;border-bottom: 2px solid #b3b3b3;">
                                                <button type="button" id="activity-tab-active-button" class="activity-bar-new-tab-bar active">TO DO</button>
                                                <button type="button" class="activity-bar-new-tab-bar">DONE</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-responsive" id="activity_table">
                                            <thead>
                                                <th scope="col" class="activity-checkbox">#</th>
                                                <th scope="col" class="activity-done">Done</th>
                                                <th scope="col" class="activity-start-date">Start Date</th>
                                                <th scope="col" class="activity-assign-to">Assign To</th>
                                                <th scope="col" class="activity-description">Subject</th>
                                                <th scope="col" class="activity-start-time">Start Time</th>
                                                {{-- <th scope="col" class="activity-due-date">Due Date</th> --}}
                                                <th scope="col" class="activity-notes">Notes</th>
                                                <th scope="col" class="activity-order-no">Order No</th>
                                                <th scope="col" class="activity-contact-person">Contact Person</th>
                                                <th scope="col" class="activity-created-by">Created By</th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </div>

{{--================================ Emails ===================================== --}}
                            <div class="tab-pane fade" id="emails" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                                <div class="col-md-12 mt-3 card">
                                    <div class="ml-auto mb-3 mt-3" style="display: none">
                                        <button type="button" style="background-color: #f6f6f6;"  class="mail_mail-button compose-btn" title="Add Email">Add Email</button>
                                    </div>

                                    <div class="table-responsive mt-3">
                                        <table class="table align-items-center" id="organization_emails_table">
                                            <thead>
                                                <tr>
                                                    <th class="sender-name" scope="col">Sender Name</th>
                                                    <th class="email-subject" scope="col">Subject</th>
                                                    <th class="email-type" scope="col">Type</th>
                                                    <th class="email-date-sent" scope="col">Date Sent</th>
                                                    <th class="email-time-sent" scope="col">Time Sent</th>
                                                    <th class="email-action" scope="col">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody class="list" id="organization_emails_tbody">
                                                <tr class="lazy-tab-placeholder">
                                                    <td colspan="6" class="text-center text-muted py-4">
                                                        Emails will load when this tab is opened.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

{{--================================ Documents =================================== --}}
                            <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" id="oms_id" data-oms-id="{{env('GOOGLE_DRIVE_FOLDER_ID')}}" />
                                            <div class="col-md-6 breadcrumbs" id="breadcrumb_id"></div>

                                            <div class="col-md-6 mb-3 text-right drive-controls">
                                                <button type="button" class=" btn btn-secondary btn-sm" title="Get Link"><i class="fas fa-link"></i></button>
                                                <button type="button" class="btn btn-secondary btn-sm" title="Share Sample"><i class="fas fa-user-plus"></i></button>
                                                <button type="button" class="btn btn-secondary btn-sm" title="Remove"><i class="fas fa-trash-alt"></i></button>
                                                <button type="button" class="btn btn-secondary btn-sm" title="More Action"><i class="fas fa-ellipsis-v"></i></button>
                                                <button type="button" class="btn btn-secondary btn-sm" title="List View"><i class="fas fa-list-alt"></i></button>
                                                <button type="button" class="btn btn-secondary btn-sm" title="View Details"><i class="fas fa-info-circle"></i></button>
                                            </div>
                                        </div>

                                        {{-- Folders card --}}
                                        <div class="card">
                                            <div class="card-header custom-card-header">
                                                <h4 class="float-left" id="content_title">Folders</h4>
                                            </div>

                                            <div class="card-body">
                                                <div class="row" id="folder_content"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

{{--================================ All =================================== --}}

                            {{-- <div class="tab-pane fade" id="all-tab" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                                <div class="card">

                                </div>

                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiptModalLabel">Payment Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="receiptImage" src="" alt="Receipt" class="img-fluid" />
            </div>
        </div>
    </div>
</div>

<!-- Large Modal -->
<div class="modal fade" id="orderInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="orderInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="orderInvoiceModalLabel">Order Invoice</h5> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="invoiceContent">
                <!-- Invoice content will be loaded here via AJAX -->
            </div>
        </div>
    </div>
</div>
  <!-- Modal -->
  <div class="modal fade" id="comfirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="padding-bottom: unset;">
          {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col" style="display: flex;flex-wrap: wrap;justify-content: center;">
            <h2>Payment Options</h2>
            <p>Choose the appropriate action for payment:</p>
          </div>
        </div>
        <div class="modal-footer" style="padding-top: unset;display: flex;flex-wrap: wrap;justify-content: center;">


          <button type="button" class="btn btn-primary" id="payment_received_btn">Payment Received</button>
        </div>
      </div>
    </div>
  </div>

    <!-- Pay multile modal -->
<div class="modal fade" id="payMultipleModal" tabindex="-1" role="dialog" aria-labelledby="payMultipleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width:1125px !important;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payMultipleModalLabel" style="font-size: 1.2rem;">TRANSACTION </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="multiplePayForm" action="{{ route('do_pay_multiple_orders') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="org_id" name="org_id" value="{{$organization->id}}" />
                <div class="modal-body">
                    <table class="table align-items-center ml-auto">
                        <thead style="background-color: grey;color: white;">
                            <th scope="col" class="text-center">Order Number</th>
                            <th scope="col" class="text-center">Organization Name</th>
                            <th scope="col" class="text-center">Total amount</th>
                            <th scope="col" class="text-center">Paid amount</th>
                            <th scope="col" class="text-center">Balance to pay</th>
                            <th scope="col" class="text-center">Payment amount</th>
                        </thead>
                        <tbody id="selectedInvoiceTr">

                        </tbody>
                        <tbody class="no-top-border">
                            <tr>
                                <td class="no-top-border" colspan="4" id="debit_acc_summary_line_0" ></td>
                                <td class="text-right no-top-border" style="font-weight:800;">Settle From Debit :  </td>
                                <td class="no-top-border">
                                    <input type="text" name="Settle_From_Debit_payment" id="Settle_From_Debit_payment" value="0.00" class="form-control text-right" style="font-weight:800;" >
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border" colspan="4" id="debit_acc_summary_line_00" ></td>
                                <td class="text-right no-top-border" style="font-weight:800;">Customer paid :  </td>
                                <td class="no-top-border">
                                    <input type="text" name="customer_paid_payment" id="customer_paid_payment" value="0.00" class="form-control text-right" style="font-weight:800;" >
                                </td>
                            </tr>
                            <tr>
                                <td class="no-top-border" colspan="4" id="debit_acc_summary_line_1" ></td>
                                <td class="text-right no-top-border" style="font-weight:800;font-size: 1rem;">Total Paid Amount :  </td>
                                <td class="no-top-border">
                                    <input type="text" name="total_sum_of_payment" id="total_sum_of_payment" value="0.00" class="form-control text-right" style="font-weight:800;" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="transaction_id" value="001">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-1 mt-3" style="padding: 0rem 1rem;">
                                    <label for="upload_image">Upload Image for payment reference front</label>
                                    <input type="file" id="upload_image" name="other_front" accept="image/png, image/jpeg" class="form-control" style="width: auto;height: auto;" onchange="previewImage(event)">
                                </div>

                                <div class="form-group" id="imagePreview2" style="display:none;padding: 0rem 1rem;">
                                    <img id="uploaded_image" src="" alt="Uploaded Image" style="width: auto; height: 5rem;">
                                    <button type="button" id="removeImage">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-1 mt-3" style="padding: 0rem 1rem;">
                                    <label for="upload_image">Upload Image for payment reference back</label>
                                    <input type="file" id="upload_image2" name="other_back" accept="image/png, image/jpeg" class="form-control" style="width: auto;height: auto;" onchange="previewImage2(event)">
                                </div>

                                <div class="form-group" id="imagePreview22" style="display:none;padding: 0rem 1rem;">
                                    <img id="uploaded_image2" src="" alt="Uploaded Image" style="width: auto; height: 5rem;">
                                    <button type="button" id="removeImage2">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="payment_reference text">Payment reference text</label><br>
                                <textarea name="payment_reference" class="form-control" id="payment_reference" cols="30" rows="3" style="width: 100%;"></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmGroupPay">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="receiptModalView" class="modal" tabindex="-1" role="dialog" style="display:none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
        <div class="modal-header">
            <h5 class="modal-title">Payment Receipt</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:none; background:none;">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="receiptModalViewBody" style="padding: 20px; max-height: 80vh; overflow-y: auto;">
        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="statmetlayout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Statement Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <input type="hidden" id="layout_id" name="layout_id" value="{{$statementLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_date"
                                    name="statement_date"
                                    title="Date"
                                    @isset($statementLayout)
                                        @if ($statementLayout['date'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_date">Date</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_order_no"
                                    name="statement_order_no"
                                    title="Mark as Done"
                                    @isset($statementLayout)
                                        @if ($statementLayout['order_no'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_order_no">Order No</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_payment_type"
                                    name="statement_payment_type"
                                    title="Mark as Done"
                                    @isset($statementLayout)
                                        @if ($statementLayout['payment_type'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_payment_type">Payment Type</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_transaction_type"
                                    name="statement_transaction_type"
                                    title="Mark as Done"
                                    @isset($statementLayout)
                                        @if ($statementLayout['transaction_type'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_transaction_type">Transaction Type</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_note"
                                    name="statement_note"
                                    title="Mark as Done"
                                    @isset($statementLayout)
                                        @if ($statementLayout['note'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_note">Note</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_amount"
                                    name="statement_amount"
                                    title="Mark as Done"
                                    @isset($statementLayout)
                                        @if ($statementLayout['amount'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_amount">Amount</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_payment"
                                    name="statement_payment"
                                    title="Mark as Done"
                                    @isset($statementLayout)
                                        @if ($statementLayout['payment'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_payment">Payment</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_paid_processing_fee"
                                    name="statement_paid_processing_fee"
                                    title="Mark as Done"
                                    @isset($statementLayout)
                                        @if ($statementLayout['paid_processing_fee'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_paid_processing_fee">Paid Processing Fee</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_total_paid_amount"
                                    name="statement_total_paid_amount"
                                    title="Mark as Done"
                                    @isset($statementLayout)
                                        @if ($statementLayout['total_paid_amount'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_total_paid_amount">Total Paid Amount</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_debit_entry"
                                    name="statement_debit_entry"
                                    title="Mark as Done"
                                    @isset($statementLayout)
                                        @if ($statementLayout['debit_entry'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_debit_entry">Debit Entry</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="statement_balance"
                                    name="statement_balance"
                                    title="Mark as Done"
                                    @isset($statementLayout)
                                        @if ($statementLayout['balance'] == 1) checked @endif
                                    @endisset
                                    @empty($statementLayout) checked @endempty
                                />
                                <label class="custom-control-label show-hide-label" for="statement_balance">Balance</label>
                            </div>
                        </div>




                    </div>
                </div>
            </div>

            <div class="modal-footer"></div>
        </div>
    </div>
</div>
@include('pages.contacts.organizations.map_view_model')
@include('pages.contacts.organizations.organization_create_modal')
@include('pages.contacts.organizations.add_remove_contacts_modal')
@include('pages.contacts.organizations.add_activity')
@include('pages.contacts.organizations.info_create_people')
@include('pages.contacts.organizations.email_view_modal')
@include('pages.contacts.organizations.email_reply_modal')
@include('pages.contacts.organizations.compose_email_modal')

<div id="imagePreviewModal" class="image-preview-modal">
    <!-- CLOSE -->
    <span class="image-preview-close">&times;</span>

    <!-- ZOOM CONTROLS -->
    <div class="image-zoom-controls">
        <button type="button" class="zoom-btn image-zoom-out" id="btnZoomOut" title="Zoom Out (-)">
            <i class="fa fa-minus"></i>
        </button>
        <span class="zoom-level-text" id="zoomLevelText">100%</span>
        <button type="button" class="zoom-btn image-zoom-in" id="btnZoomIn" title="Zoom In (+)">
            <i class="fa fa-plus"></i>
        </button>
        <button type="button" class="zoom-btn image-zoom-reset" id="btnZoomReset" title="Reset Zoom (100%)">
            <i class="fa fa-undo"></i> Reset
        </button>
    </div>

    <!-- PREVIOUS -->
    <button type="button" class="image-nav-btn image-prev-btn" title="Previous Image">
        &#10094;
    </button>

    <!-- IMAGE WRAPPER FOR ZOOM & PAN -->
    <div class="image-preview-wrapper" id="previewImageWrapper">
        <img class="image-preview-content" id="previewImage" alt="Preview Image">
    </div>

    <!-- NEXT -->
    <button type="button" class="image-nav-btn image-next-btn" title="Next Image">
        &#10095;
    </button>
</div>
<script>

    $(document).ready(function () {

        const scrollBtn = $('#mobileScrollDownBtn');

        scrollBtn.on('click', function () {

            $('html, body').animate({
                scrollTop: $(document).height()
            }, 700);

        });

        $(window).on('scroll', function () {

            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();
            const documentHeight = $(document).height();

            if (scrollTop + windowHeight >= documentHeight - 80) {
                scrollBtn.addClass('hide-scroll-btn');
            } else {
                scrollBtn.removeClass('hide-scroll-btn');
            }

        });

    });

    function openCustomerPortal(organizationId) {

        // Create temporary form
        const form = document.createElement('form');

        form.method = 'POST';
        form.action = "{{ url('organizations') }}/"
            + organizationId
            + "/open-customer-portal";

        // Open Customer Portal in new tab
        form.target = '_blank';

        form.style.display = 'none';

        // CSRF token
        const csrfInput = document.createElement('input');

        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = "{{ csrf_token() }}";

        form.appendChild(csrfInput);

        document.body.appendChild(form);

        form.submit();

        // Remove temporary form after submit
        setTimeout(function () {
            form.remove();
        }, 1000);
    }
</script>
<script>
    let debitBalance = 0;

    function initializeOrganizationPaymentsTable() {
        if (!$('#organization_payments_table').length) {
            return null;
        }

        if ($.fn.DataTable.isDataTable('#organization_payments_table')) {
            return $('#organization_payments_table').DataTable();
        }

        return $('#organization_payments_table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthMenu: [[25, 50, -1], [25, 50, "All"]],
            order: [[7, "desc"]],
            columnDefs: [
                { targets: "_all", className: "text-center" },
                {
                    targets: 7,
                    render: function (data, type, row) {
                        if (!data) return '';

                        var parts = data.split('/');
                        if (parts.length !== 3) return data;

                        var month = parts[0].padStart(2, '0');
                        var day = parts[1].padStart(2, '0');
                        var year = parts[2];
                        var normalized = `${year}-${month}-${day}`;

                        if (type === 'sort' || type === 'type') {
                            return normalized;
                        }

                        if (type === 'filter') {
                            return normalized + ' ' + data;
                        }

                        return data;
                    }
                }
            ]
        });
    }

    function initializeOrganizationStatementTable() {
        if (!$('#organization_Account_statment_table').length) {
            return null;
        }

        if ($.fn.DataTable.isDataTable('#organization_Account_statment_table')) {
            return $('#organization_Account_statment_table').DataTable();
        }

        return $('#organization_Account_statment_table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            pageLength: 25,
            scrollX: true,
            scrollCollapse: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [[0, "asc"]],
            columnDefs: [
                { targets: 0, className: 'statement-date text-center' },
                { targets: 1, className: 'statement-order-no text-center' },
                { targets: 2, className: 'statement-payment-type text-center' },
                { targets: 3, className: 'statement-transaction-type text-center' },
                { targets: 4, className: 'statement-note text-left' },
                { targets: 5, className: 'statement-amount text-right' },
                { targets: 6, className: 'statement-payment text-right' },
                { targets: 7, className: 'statement-paid-processing-fee text-right' },
                { targets: 8, className: 'statement-total-paid-amount text-right' },
                { targets: 9, className: 'statement-debit-entry text-right' },
                { targets: 10, className: 'statement-balance text-right' },
                {
                    targets: [0],
                    type: 'date',
                    render: function (data, type, row) {
                        if (type === 'sort') {
                            if (!data) return '';

                            var dateParts = data.split('/');
                            if (dateParts.length !== 3) return '';

                            var year = parseInt(dateParts[2], 10);
                            var month = parseInt(dateParts[0], 10) - 1;
                            var day = parseInt(dateParts[1], 10);
                            var parsedDate = new Date(year, month, day);

                            return isNaN(parsedDate) ? '' : parsedDate.toISOString();
                        }

                        return data;
                    }
                }
            ],
            drawCallback: function () {
                displayStatementTable();
            }
        });
    }

    function displayStatementTable() {
        var table = $('#organization_Account_statment_table').DataTable();

        table.column(0).visible($('#statement_date').is(':checked'));
        table.column(1).visible($('#statement_order_no').is(':checked'));
        table.column(2).visible($('#statement_payment_type').is(':checked'));
        table.column(3).visible($('#statement_transaction_type').is(':checked'));
        table.column(4).visible($('#statement_note').is(':checked'));
        table.column(5).visible($('#statement_amount').is(':checked'));
        table.column(6).visible($('#statement_payment').is(':checked'));
        table.column(7).visible($('#statement_paid_processing_fee').is(':checked'));
        table.column(8).visible($('#statement_total_paid_amount').is(':checked'));
        table.column(9).visible($('#statement_debit_entry').is(':checked'));
        table.column(10).visible($('#statement_balance').is(':checked'));

        // Replace 0.00 with blank
        $('#organization_Account_statment_table td').each(function () {
            if ($.trim($(this).text()) === '0.00') {
                $(this).text(' ');
            }
        });
    }
    const columnMap = {
        'statement_date': 0,
        'statement_order_no': 1,
        'statement_payment_type': 2,
        'statement_transaction_type': 3,
        'statement_note': 4,
        'statement_amount': 5,
        'statement_payment': 6,
        'statement_paid_processing_fee': 7,
        'statement_total_paid_amount': 8,
        'statement_debit_entry': 9,
        'statement_balance': 10
    };

    // Bind a single event handler for all relevant checkboxes
    $('body').on('click', 'input[type="checkbox"][id^="statement_"]', function () {
        const checkboxId = $(this).attr('id');
        const columnIndex = columnMap[checkboxId];
        const table = $('#organization_Account_statment_table').DataTable();

        if (typeof columnIndex !== 'undefined') {
            const isChecked = $(this).is(':checked');
            table.column(columnIndex).visible(isChecked);

            // Call your AJAX sync functions
            if (isChecked) {
                showstatementColumn(checkboxId);
            } else {
                hidestatementColumn(checkboxId);
            }
        }
    });
    function showstatementColumn(attribute_name) {
        $.ajax({
            url: "{{ url('statement/show_column') }}",
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

    function hidestatementColumn(attribute_name) {
        $.ajax({
            url: "{{ url('statement/hide_column') }}",
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
    $('#export_button').on('click', function() {
        var organization_id = $('#organization_id').val();
        var start_date = $('#sta_start_date').val();
        var end_date = $('#sta_end_date').val();
        var hide_debit_entries = $('#hide_debit_entries').is(':checked');

         // Dynamically create a download link
    var url = "{{ route('organizations.exportAccountStatment') }}" +
        '?start_date=' + encodeURIComponent(start_date) +
        '&end_date=' + encodeURIComponent(end_date) +
        '&hide_debit_entries=' + encodeURIComponent(hide_debit_entries) +
        '&organization_id=' + encodeURIComponent(organization_id);

    // Open the link for download
    window.location.href = url;

    });
    $('#pdf_export_button').on('click', function() {
        var organization_id = $('#organization_id').val();
        var start_date = $('#sta_start_date').val();
        var end_date = $('#sta_end_date').val();
        var hide_debit_entries = $('#hide_debit_entries').is(':checked');

         // Dynamically create a download link
    var url = "{{ route('organizations.exportAccountStatmentPDF') }}" +
        '?start_date=' + encodeURIComponent(start_date) +
        '&end_date=' + encodeURIComponent(end_date) +
        '&hide_debit_entries=' + encodeURIComponent(hide_debit_entries) +
        '&organization_id=' + encodeURIComponent(organization_id);

    // Open the link for download
    window.location.href = url;

    });
    $('.summary-datepicker').datepicker();
    $('.summary-select2').select2();
    $('#confirmGroupPay').click(function(e) {
        e.preventDefault(); // Prevent default button action
        $(".se-pre-con").fadeIn('slow'); // Show loading animation

        // Submit the form
        $('#multiplePayForm').submit();
    });
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploaded_image');
            output.src = reader.result;
            document.getElementById('imagePreview2').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]); // Preview the image
    }
    function previewImage2(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('uploaded_image2');
            output.src = reader.result;
            document.getElementById('imagePreview22').style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]); // Preview the image
    }
    // Remove image functionality
    document.getElementById('removeImage').addEventListener('click', function() {
        document.getElementById('upload_image').value = ''; // Clear file input
        document.getElementById('uploaded_image').src = ''; // Clear image preview
        document.getElementById('imagePreview2').style.display = 'none'; // Hide image preview area
    });
    document.getElementById('removeImage2').addEventListener('click', function() {
        document.getElementById('upload_image2').value = ''; // Clear file input
        document.getElementById('uploaded_image2').src = ''; // Clear image preview
        document.getElementById('imagePreview22').style.display = 'none'; // Hide image preview area
    });
    $(document).ready(function() {
        $(document).on('change', '#total_sum_of_payment', function() {
            handlePaymentValues();
        });
        function handlePaymentValues() {
            $(".se-pre-con").fadeIn('slow');
            var total_paid_amount = parseFloat($('#total_sum_of_payment').val()) || 0;
            var total_invoice_amount = parseFloat($('#total_paid_amount').val()) || 0;


            if (total_paid_amount > total_invoice_amount) {
                $('#debit_acc_summary_line_1').html('');
                var overPayment = (total_paid_amount - total_invoice_amount).toFixed(2);
                var htmlContent1 = '<p style="margin: 0;font-weight: 600;color: grey;">Excess payment for this transaction = $' + overPayment + '</p>';
                $('#debit_acc_summary_line_1').html(htmlContent1);
            }

            if (total_paid_amount < total_invoice_amount) {
                $('#debit_acc_summary_line_1').html('');
                var remaining_payment = (total_invoice_amount - total_paid_amount ).toFixed(2);
                var htmlContent1 = '<p style="margin: 0;font-weight: 600;color: grey;">Remaining payment for this transaction = $' + remaining_payment + '</p>';

                $('#debit_acc_summary_line_1').html(htmlContent1);

            }
            if (total_paid_amount > 0) {

                let total = 0;
                let is_exeed = false;

                $('#selectedInvoiceTr').find('tr').each(function () {
                    let $row = $(this);
                    let $input = $row.find('td .invoice_payment_amount');
                    let $originalInput = $row.find('td .invoice_payment_amount_orginal');

                    let originalBalance = parseFloat($originalInput.val()) || 0;
                    let value = parseFloat($input.val()) || 0;

                    total += originalBalance;

                    if(!is_exeed){
                        if(total >  (total_paid_amount)){
                            $($input).val((originalBalance - total + (total_paid_amount)).toFixed(2)).trigger('change');
                            is_exeed = true;
                        }else{
                            $($input).val((originalBalance).toFixed(2)).trigger('change');
                        }
                    }else{
                        $($input).val((0).toFixed(2)).trigger('change');
                    }
                });

            }

            if (total_paid_amount == total_invoice_amount) {
                console.log('Payment settled');
                // $('#transaction_amount_debit').prop('readonly', true);
                $('#debit_acc_summary_line_1, #debit_acc_summary_line_2').html('');
            }

            $(".se-pre-con").fadeOut('slow');
        }

        $('#receiptModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var receiptUrl = button.data('receipt'); // Extract info from data-* attributes

            var modal = $(this);

            modal.find('#receiptImage').attr('src', receiptUrl); // Set image source
        });


        $(document).on("click", ".vieworderInvoice", function (){
            var orderId = $(this).data('value');

            // Show loader
            // $('#invoiceContent').html('<div class="text-center"><img src="{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif"></div>');

            $.ajax({
                url: "{{ route('order.get_order_invoice') }}",
                type: "GET",
                data: { order_id: orderId },
                success: function(response) {
                    $('#invoiceContent').html(response); // Load the invoice inside modal
                    $('#orderInvoiceModal').modal('show'); // Show the modal
                },
                error: function() {
                    $('#invoiceContent').html('<p class="text-danger">Failed to load invoice.</p>');
                }
            });
        });
        $(document).on("click", ".downloadorderInvoice", function() {
            var orderId = $(this).data('value');
            var organization_name = $('#organization_name').val();
            // Show loader
            // $('#invoiceContent').html('<div class="text-center"><img src="{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif"></div>');

            $.ajax({
                url: "{{ route('order.get_order_invoice') }}",
                type: "GET",
                data: { order_id: orderId },
                success: function(response) {
                    $('#invoiceContent').html(response); // Load the invoice inside modal
                    // $('#orderInvoiceModal').modal('show'); // Show the modal
                    var element = document.getElementById('invoice_print');
                    var opt = {
                        filename: organization_name+'_Invoice_'+orderId+'.pdf',
                        jsPDF: { format: 'a4', orientation: 'portrait' },
                    };
                    html2pdf().set(opt).from(element).save();


                },
                error: function() {
                    $('#invoiceContent').html('<p class="text-danger">Failed to load invoice.</p>');
                }
            });
        });



        function get_org_payments_data(){
            var organization_id = $('#organization_id').val();
            var start_date = $('#payment_start_date').val();
            var end_date = $('#payment_end_date').val();
            var filterColumn = $('#filterColumn').val();

            $(".se-pre-con").fadeOut('slow');

            $.ajax({
                url: "{{ route('Organization.get_payment_table_data') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    start_date:start_date,
                    end_date:end_date,
                    filterColumn:filterColumn,
                    organization_id: organization_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    updatePaymentsTable(response.orders);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            $(".se-pre-con").fadeOut('slow');
        }
        function get_org_account_Statement_data(){
            var organization_id = $('#organization_id').val();
            var start_date = $('#sta_start_date').val();
            var end_date = $('#sta_end_date').val();
            var hide_debit_entries = $('#hide_debit_entries').is(':checked');

            $(".se-pre-con").fadeIn('slow');

            $.ajax({
                url: "{{ route('Organization.get_statement_table_data') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    start_date:start_date,
                    end_date:end_date,
                    organization_id: organization_id,
                    hide_debit_entries: hide_debit_entries,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    updateaccountTable(response.statements);
                    $('#DebitBalanceOfOrg').text(
                        response.debit_balance == null || isNaN(response.debit_balance.replace(/,/g, ''))
                            ? '0.00'
                            : parseFloat(response.debit_balance.replace(/,/g, '')).toFixed(2)
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    );
                    $('#creditBalanceOfOrg').text(
                        response.total_balance_to_pay == null || isNaN(response.total_balance_to_pay.replace(/,/g, ''))
                            ? '0.00'
                            : parseFloat(response.total_balance_to_pay.replace(/,/g, '')).toFixed(2)
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    );
                    $(".se-pre-con").fadeOut('slow');

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        function updateaccountTable(logs) {
            var table = $('#organization_Account_statment_table').DataTable(); // Get DataTable instance
            table.clear().draw(); // Clear existing data while keeping DataTable active

            if (!logs || logs.length === 0) {
                // Instead of adding a custom row, let DataTables handle the "No data available" message
                table.draw();
                return;
            }

            console.log(logs);

            $.each(logs, function(index, log) {
                var display_id= ('000000' + log.Transaction_Id).slice(-6);
                var typebadge;
                if(log.Type == 0){
                    typebadge = 'Credited';
                }else if(log.Type == 1){
                    typebadge = 'Debited';
                }
                var orderLink = log.Order_id ?
                    `<a href="#" class="edit-order" data-value="${log.Order_id}">${log.Order_no}</a>` :
                    `-`;
                var date = new Date(log.created_at);
                var formattedCreatedDate = ('0' + (date.getMonth() + 1)).slice(-2) + '/' + ('0' + date.getDate()).slice(-2) + '/' + date.getFullYear();

                var row = [
                    // display_id,
                    formattedCreatedDate,
                    orderLink,
                    log.payment_Type,
                    log.Transaction_Type,
                    log.Note,
                    `${isNaN(parseFloat(log.amount)) ? '0.00' : log.amount}`,
                    `${isNaN(parseFloat(log.invoice_paid_amount)) ? '0.00' : log.invoice_paid_amount}`,
                    `${isNaN(parseFloat(log.processingFee)) ? '0.00' : log.processingFee}`,
                    `${isNaN(parseFloat(log.paid.toString().replace(/,/g, ''))) ? '0.00' : parseFloat(log.paid.toString().replace(/,/g, '')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`,
                    `${isNaN(parseFloat(log.debitentry.toString().replace(/,/g, ''))) ? '0.00' : parseFloat(log.debitentry.toString().replace(/,/g, '')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`,
                    `${isNaN(parseFloat(log.balance.toString().replace(/,/g, ''))) ? '0.00' : parseFloat(log.balance.toString().replace(/,/g, '')).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`,



                    log.Handledby,



                ];

                table.row.add(row);
            });

            table.draw(); // Redraw table with new data
        }
        $(document).on('change', '#hide_debit_entries', function () {
            get_org_account_Statement_data();
        });
        $('#paymentsTab').on('shown.bs.tab', function () {
            initializeOrganizationPaymentsTable();
            get_org_payments_data();
        });
        $('#Account_StatementsTab').on('shown.bs.tab', function () {
            initializeOrganizationStatementTable();
            get_org_account_Statement_data();
        });
        $('#pin-filter2').on('click', function () {
            get_org_account_Statement_data()
        });
        $('#pin-filter').on('click', function () {
            get_org_payments_data()
        });
        $('#checkbox_of_invoice_all').change(function() {
            var checked = $(this).is(':checked');
            $('.checkbox_of_invoice').prop('checked', checked).trigger('change');
        });
        $('body').on('click', '.multiple-pay-button', function(e) {
            e.preventDefault();

            $('.only_for_payment').hide();
            $('#imagePreview').attr('src', '');
            $('#payment_image').val('');

            $('#comfirm_modal').modal('show');
        });
        $('body').on('click', '#payment_received_btn', function(e) {
            e.preventDefault();
            $('#comfirm_modal').modal('hide');
            $('#paymentReceivedModalLabel').text('RECEIVED PAYMENTS');
            $('.only_for_payment').show();
            $('#imagePreview').hide();

            $(".se-pre-con").fadeIn('slow');

            var arrayData = $('#pay_multiple_invoices').val();

            var invoiceArray = arrayData.split(',');

            invoiceArray = invoiceArray.map(function(item) {
                return item.trim();
            });
            var organization_id = $('#organization_id').val();
            $.ajax({
                    url:"{{ route('get_multiple_order_details') }}",
                    type: "POST",
                    data: {
                        'order_ids': invoiceArray,
                        'org_id': organization_id,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $(".se-pre-con").fadeOut('slow');

                        $('#selectedInvoiceTr').empty();

                        var orders = data.data;
                        orders.sort((a, b) => a.id - b.id);

                        if (orders && orders.length > 0) {
                            var totalAmount = 0.00;
                            orders.forEach(function(invoice) {

                                let organizationName = invoice.organization_details.organization_name;
                                if (organizationName.length > 50) {
                                    organizationName = organizationName.substring(0, 50) + '...';
                                }
                                var row = `
                                            <tr>
                                                <td class="text-center"><a style="color:black !important" href="#" class="edit-order" data-value="${invoice.id}">${invoice.order_no}</a></td>
                                                <td class="text-left">${organizationName}</td>
                                                <td class="text-right total-amount-to-pay">${parseFloat(invoice.order_total).toFixed(2)}</td>
                                                <td class="text-right paid-amount-total">${invoice.payment_status.total_payment}</td>
                                                <td class="text-right paid-amount-total">${parseFloat(invoice.payment_status.balance_to_be_paid).toFixed(2)}</td>
                                                <td>
                                                    <input type="text" max="${invoice.payment_status.balance_to_be_paid}" class="invoice_payment_amount form-control text-right" name="payment_amount[${invoice.id}]" value="${parseFloat(invoice.payment_status.balance_to_be_paid).toFixed(2)}">
                                                    <input type="hidden" max="${invoice.payment_status.balance_to_be_paid}" class="invoice_payment_amount_orginal form-control text-right" value="${parseFloat(invoice.payment_status.balance_to_be_paid).toFixed(2)}">
                                                </td>
                                            </tr>
                                        `;
                                        $('#selectedInvoiceTr').append(row);

                                        totalAmount += invoice.payment_status.balance_to_be_paid;
                            });

                            var totalRow = `
                                            <tr>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="hard-top-border"></td>
                                                <td class="text-right hard-top-border" style="font-weight:800">Invoice Total : </td>
                                                <td class="hard-top-border">
                                                    <input type="hidden" name="total_amount" id="total_paid_amount" value="${parseFloat(totalAmount).toFixed(2)}">
                                                    <input type="text" value="${parseFloat(totalAmount).toFixed(2)}" class="form-control text-right" style="font-weight:800" readonly>
                                                </td>
                                            </tr>
                                        `;
                            $('#selectedInvoiceTr').append(totalRow);
                            debitBalance = data.debit_balance !== null ? parseFloat(data.debit_balance) || 0 : 0;
                            var formattedBalance = debitBalance.toFixed(2);
                            var htmlContent0 = '<p style="margin: 0;font-weight: 600;color: grey;">Current debit account balace = $' + formattedBalance + '</p>';
                            $('#debit_acc_summary_line_0').html(htmlContent0);

                            $('#transaction_amount_cash,#total_sum_of_payment').val(parseFloat(totalAmount).toFixed(2));
                            document.getElementById('upload_image').value = ''; // Clear file input
                            document.getElementById('uploaded_image').src = ''; // Clear image preview
                            document.getElementById('imagePreview2').style.display = 'none'; // Hide image preview area
                            $('#payMultipleModal').modal('show');
                        }
                    }
                });

                $(".se-pre-con").fadeOut('slow');

        });
        $(document).on('change', '#customer_paid_payment', function() {
            var customerpaidvalue = parseFloat($('#customer_paid_payment').val()) || 0;
            var debitevalue = parseFloat($('#Settle_From_Debit_payment').val()) || 0;

            var val = customerpaidvalue + debitevalue; // Proper numerical addition
            $('#total_sum_of_payment').val(val.toFixed(2)).trigger('change');
        });
        $(document).on('change', '#Settle_From_Debit_payment', function() {
            let inputValue = $(this).val();

            // Ensure only valid numbers and one decimal
            inputValue = inputValue.replace(/[^0-9.]/g, ''); // Remove invalid characters
            inputValue = inputValue.replace(/(\..*)\./g, '$1'); // Allow only one decimal point

            // Restrict to 2 decimal places
            let parts = inputValue.split('.');
            if (parts.length > 1) {
                parts[1] = parts[1].substring(0, 2); // Keep only 2 decimal places
                inputValue = parts.join('.');
            }


            // Convert to float and validate against balance
            let enteredAmount = parseFloat(inputValue) || 0;
            if (enteredAmount > debitBalance) {
                enteredAmount = debitBalance.toFixed(2); // Set to max allowed balance
                alert('Amount cannot exceed available debit balance: $' + debitBalance.toFixed(2));
            }

            $(this).val(enteredAmount);

            let customerpaidvalue = parseFloat($('#customer_paid_payment').val()) || 0;

            let newValue = customerpaidvalue + enteredAmount; // Proper numerical addition
            $('#total_sum_of_payment').val(newValue.toFixed(2)).trigger('change'); // Ensure two decimal places
        });
        $(document).on('input', '.invoice_payment_amount', function() {
            calculateTotalAmount();
        });


        function calculateTotalAmount() {
            var totalAmount = 0;
            $('.invoice_payment_amount').each(function() {
                var amount = parseFloat($(this).val());
                if (!isNaN(amount)) {
                    totalAmount += amount;
                }
            });
            $('#total_sum_of_payment').val(totalAmount.toFixed(2));

        }
        var invoice_array = [];
        function is_same_org_selected() {
            let is_same_organization = true;
            let organization_name = null;

            // Get all selected checkboxes across pages
            let table = $('#order_summary').DataTable();
            let selectedRows = table.$('.checkbox_of_invoice:checked', { page: 'all' });

            selectedRows.each(function() {
                var current_org_name = $(this).closest('tr').find('.org-name').text().trim();

                if (organization_name === null) {
                    organization_name = current_org_name;
                } else if (organization_name !== current_org_name) {
                    is_same_organization = false;
                    return false; // Break loop
                }
            });

            return is_same_organization;
        }
        $('body').on('change', '.checkbox_of_invoice', function() {
            var value = $(this).val();

            if ($(this).is(':checked')) {
                if (!invoice_array.includes(value)) {
                    invoice_array.push(value);
                }
            } else {
                var index = invoice_array.indexOf(value);
                if (index > -1) {
                    invoice_array.splice(index, 1);
                }
            }





            $('#invoice_checked_count').text(invoice_array.length);

            if (invoice_array.length > 0) {
                $('#pay_multiple').show();
                $('#pay_multiple_invoices').val(invoice_array);

            } else {
                $('#pay_multiple').hide();
                $('#pay_multiple_invoices').val('');

            }
        });
        // Function to update the table
        function updatePaymentsTable(orders) {
    var table = $('#organization_payments_table').DataTable();
    table.clear().draw();

    if (!orders || orders.length === 0) {
        table.draw();
        return;
    }

    $.each(orders, function(index, order) {
        var orderStatusBadge;
        var balanceOfpayment = order.payment_status.balance_to_be_paid;

        if (order.payment_status.payment_status == 2 || order.order_no.startsWith('TSR')) {
            orderStatusBadge = '<span class="badge badge-pill showorderpayments" data-value="'+order.id+'" style="color:#47D6B6;background-color:#d7ffcc;width:100%"><i class="fa-solid fa-eye mx-2"></i> Paid</span>';
        } else if (order.payment_status.payment_status == 1) {
            orderStatusBadge = '<span class="badge badge-pill showorderpayments" data-value="'+order.id+'" style="color:#023E8A;background-color:#D4E6FD;width:100%"><i class="fa-solid fa-eye mx-2"></i> Partial</span>';
        } else if (order.payment_status.payment_status == 0) {
            orderStatusBadge = '<span class="badge badge-pill notshoworderpayments" style="color:#FFB916;background-color:#FFF6CC;width:100%">Pending</span>';
        } else {
            orderStatusBadge = 'unavailable';
        }

        if (order.order_no.startsWith('TSR')) {
            balanceOfpayment = 0;
        }
        var toggleIcon = (order.payments && order.payments.length > 0)
            ? `<i class="arrow-toggle fa fa-chevron-right" style="cursor: pointer;"></i>`
            : '';
        var rowData = [
            '<input type="checkbox" class="checkbox_of_invoice" value="'+order.id+'" id="checkbox_of_invoice_'+order.id+'"  />',
            toggleIcon, // Toggle icon for subtable
            `<a href="#" class="edit-order" data-value="${order.id}">${order.order_no}</a>`,
            `${parseFloat(order.order_total).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")}`,
            `${parseFloat(order.payment_status.total_payment).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")}`,
            `${parseFloat(balanceOfpayment).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,")}`,
            orderStatusBadge,
            order.open_date,
            `<i class="fa-solid fa-eye tableIcons vieworderInvoice" data-value="${order.id}"></i>
             <i class="fa-solid fa-cloud-arrow-down ml-3 tableIcons downloadorderInvoice" data-value="${order.id}"></i>`
        ];

        var rowNode = table.row.add(rowData).draw(false).node();
        $(rowNode).attr('data-order-id', order.id);

        // Attach payments data as child rows
        if (order.payments && order.payments.length > 0) {
            var paymentDetails = formatSubTable(order.payments);
            table.row(rowNode).child(paymentDetails).hide();
        }
    });

    // Handle expand/collapse for payment details
    $('#organization_payments_table tbody').off('click', 'i.arrow-toggle').on('click', 'i.arrow-toggle', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            $(this).removeClass('fa-chevron-down').addClass('fa-chevron-right');
            tr.removeClass('shown');
        } else {
            var orderId = tr.attr('data-order-id');
            var order = orders.find(o => o.id == orderId);
            row.child(formatSubTable(order.payments)).show();
            $(this).removeClass('fa-chevron-right').addClass('fa-chevron-down');
            tr.addClass('shown');
        }
    });

    table.draw();
}

// Function to format payment subtable
function formatSubTable(payments) {
    var storagePath = "{{ url('/') }}/"; // Get base URL dynamically

    var subtableHTML = `
        <table class="table table-bordered sub-payments-table">
            <thead>
                <tr style="background-color: #8b8b8b;color: #ffffff;height: 30px;">
                    <th>#</th>
                    <th class="text-center">Payment Type</th>
                    <th class="text-right">Amount</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Receipt</th>
                    <th class="text-center">Supporting Document</th>
                </tr>
            </thead>
            <tbody>
                ${payments.map((payment, index) => {
                    let receipt = 'No document available'; // Default

                    if (payment.payment_type === 'Check') {
                        if (payment.receipt || payment.receiptBack) {
                            receipt = `
                                <button type="button" style="padding:unset" class="btn btn-link" data-toggle="modal" data-target="#receiptModal" data-receipt="${storagePath + payment.receipt}">
                                    View Front
                                </button> |
                                <button type="button" style="padding:unset" class="btn btn-link" data-toggle="modal" data-target="#receiptModal" data-receipt="${storagePath + payment.receiptBack}">
                                    View Back
                                </button>
                            `;
                        }
                    } else if (['Paypal', 'Venmo'].includes(payment.payment_type) && payment.receipt) {
                        receipt = `<button type="button" class="btn btn-link" data-toggle="modal" data-target="#receiptModal" data-receipt="${storagePath + payment.receipt}">View Receipt</button>`;
                    } else if (payment.payment_type === 'Other') {
                        if (payment.receipt || payment.receiptBack) {
                            receipt = `
                                <button type="button" style="padding:unset" class="btn btn-link" data-toggle="modal" data-target="#receiptModal" data-receipt="${storagePath + payment.receipt}">
                                    View Front
                                </button> |
                                <button type="button" style="padding:unset" class="btn btn-link" data-toggle="modal" data-target="#receiptModal" data-receipt="${storagePath + payment.receiptBack}">
                                    View Back
                                </button>
                            `;
                        }
                    }

                    return `
                        <tr>
                            <td>${index + 1}</td>
                            <td class="text-center">${payment.payment_type}</td>
                            <td class="text-right">${parseFloat(payment.amount).toFixed(2)}</td>
                            <td class="text-center">${new Date(payment.date).toLocaleDateString()}</td>
                            <td class="text-center invoice_data_td" data-transaction-id='${payment.id}' data-transaction-method='${payment.payment_type}' data-order-id='${payment.order_id}'><i class="fa fa-eye view-payment-receipt" title="View Receipt" style="cursor:pointer !important" aria-hidden="true"></i>&nbsp;&nbsp;<i class="fa fa-download download-payment-receipt" title="Download Receipt" style="cursor:pointer !important" aria-hidden="true"></i></td>
                            <td class="text-center">${receipt}</td>
                        </tr>
                    `;
                }).join('')}
            </tbody>
        </table>
    `;

    return subtableHTML;
}



            // Initialize Select2
            $('#shipping_country').select2({
                placeholder: 'Select a Country',
                allowClear: true,
                width: '100%'
            });

            // Fetch country data
            $.ajax({
                url: 'https://countriesnow.space/api/v0.1/countries',
                method: 'GET',
                success: function(data) {
                    const countries = data.data.map(country => ({
                        id: country.country,
                        text: country.country
                    }));
                    $('#shipping_country').select2({
                        data: countries,
                        placeholder: 'Select a Country',
                        allowClear: true,
                        width: '100%'
                    });
                    $('#billing_country').select2({
                        data: countries,
                        placeholder: 'Select a Country',
                        allowClear: true,
                        width: '100%'
                    });
                    // Pre-select the current country (if any)
                    const currentCountry = "{{ $organization->shipping_country }}";
                    if (currentCountry) {
                        $('#shipping_country').val(currentCountry).trigger('change');
                    }

                    const currentBCountry = "{{ $organization->billing_country ?? $organization->shipping_country }}";
                    if (currentBCountry) {
                        $('#billing_country').val(currentBCountry).trigger('change');
                    }
                },
                error: function(error) {
                    console.error('Error fetching countries:', error);
                }
            });

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
                                            <div style="color: #333;">${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal' ? (paymentDetails['Amount'] * 100 / 103) : paymentDetails['Amount']).toFixed(2)}</div>
                                        </div>
                                        ` : ``}

                                        ${(paymentDetails['Method'] == 'Card' || paymentDetails['Method'] == 'Paypal') ? `
                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Processing Fee Paid (3%) ($):</div>
                                            <div style="color: #333;">${parseFloat((paymentDetails['Amount'] * 3 / 103) || 0).toFixed(2)}</div>
                                        </div>
                                        ` : ``}

                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Total amount Paid ($):</div>
                                            <div style="color: #333;">${parseFloat((paymentDetails['Amount']) || 0)}</div>
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
                                            <div style="color: black;">${parseFloat((orderDetails.sub_total) || 0).toFixed(2)}</div>
                                        </div>

                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Artwork & Other Fees ($):</div>
                                            <div style="color: #333;">${parseFloat((orderDetails.artwork) || 0).toFixed(2)}</div>
                                        </div>

                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Discount ($):</div>
                                            <div style="color: #333;">${parseFloat(discountAmount).toFixed(2)}</div>
                                        </div>

                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: black;">Total invoice amount ($):</div>
                                            <div style="color: black;">${(parseFloat(orderDetails.artwork) + parseFloat(orderDetails.sub_total) - parseFloat(discountAmount)).toFixed(2)}</div>
                                        </div>

                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Sales Tax (${orderDetails.organization_details.sales_tax}%) ($):</div>
                                            <div style="color: #333;">${parseFloat((orderDetails.sales_tax) || 0).toFixed(2)}</div>
                                        </div>

                                        <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                            <div style="font-weight: bold; color: #555;">Shipping ($):</div>
                                            <div style="color: #333;">${parseFloat((orderDetails.shipping) || 0).toFixed(2)}</div>
                                        </div>

                                        <div style="display: flex; justify-content: space-between; padding: 10px 0; font-size: .9rem;">
                                            <div style="font-weight: bold; color: black;">Grand total ($):
                                                <p style="color: grey; font-weight: 100; font-size: .7rem; margin: 0;">(Invoice amount + Sales Tax + shipping)</p>
                                            </div>
                                            <div style="color: black; font-weight: bold;">${parseFloat(orderDetails.order_total).toFixed(2)}</div>
                                        </div>

                                        ${paymentDetails['total_payment'] > 0 ? `
                                            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                                <div style="font-weight: bold; color: #555;">Paid Amount ($):</div>
                                                <div style="color: #333;">${parseFloat((paymentDetails['total_payment']) || 0).toFixed(2)}</div>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; padding: 5px 0;">
                                                <div style="font-weight: bold; color: #555;">Paid Processing Fee ($):</div>
                                                <div style="color: #333;">${(parseFloat(paymentDetails['ProcessingFee']) || 0).toFixed(2)}</div>
                                            </div>
                                        ` : ``}

                                        ${paymentDetails['balance_to_be_paid'] > 0 ? `
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
                                $('#receiptModalViewBody').html(receiptHTML);

                                // Show the modal
                                $('#receiptModalView').modal('show');
                            }
                    $(".se-pre-con").fadeOut('slow');
                },
                complete: function () {
                }
            });



        }

    $(document).ready(function() {

        $(document).on('click', '.email-body-html a', function(e) {
            // Ensure the link opens in a new tab
            e.preventDefault();
            window.open($(this).attr('href'), '_blank');
        });
        $(document).on('click', '#email_view_modal a', function(e) {
            // Ensure the link opens in a new tab
            e.preventDefault();
            window.open($(this).attr('href'), '_blank');
        });

        let hoverTimeout;

        if ($('#minimize_icon').css('display') != 'none') {
            $('#minimize_icon')[0].click();
        }

        $('#sidenav-main').hover(
            function() {
                hoverTimeout = setTimeout(function() {
                    if ($('#maximize_icon').css('display') != 'none') {
                        $('#maximize_icon').click();
                    }
                }, 500);
            },
            function() {
                clearTimeout(hoverTimeout);
                if ($('#minimize_icon').css('display') != 'none') {
                    $('#minimize_icon')[0].click();
                }
            }
        );
    });
    function modalShowReply(){
        $('#modal-reply').modal('show');
    }
    $(document).on('click', '.compose-btn-to-log', function() {
    Swal.fire({
        title: 'Access Your Email',
        html: "<b>You are currently not logged in.</b><br><br>To continue composing your email, please log in first.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Log In Now',
        cancelButtonText: 'Not Now',
    }).then((result) => {
        console.log(result);
        if (result.value) {
            window.open('{{ route('indexemail') }}', '_blank');
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        $('#mark_as_deleted').click(function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    // If user confirms, submit the form
                    $('#mark_to_delete_activites').closest('form').submit();
                }
            });
        });
    });
</script>



<script>
    function GenerateRandomPassword(){
        var uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
        var numberChars = '0123456789';
        var symbolChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';

        var allChars = uppercaseChars + lowercaseChars + numberChars + symbolChars;

        var randomPassword = '';
        for (var i = 0; i < 10; i++) {
            var randomIndex = Math.floor(Math.random() * allChars.length);
            randomPassword += allChars[randomIndex];
        }
        $('#unique_password').val(randomPassword);
    }
    function togglePasswordVisibility() {
        var passwordField = document.getElementById('unique_password');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    }
    function set_sport_image(sports, img) {
        const foundSport = sports.find(sport => sport.sport_name === img);
        const imageElement = document.getElementById('sport-display-image');

        if (foundSport) {
            const sportImage = foundSport.sport_image;
            if(foundSport.sport_image !== null){
                const imagePath = '{{ asset('assets') }}/' + sportImage;
                imageElement.src = imagePath;
            }else{
                imageElement.src = '{{ asset('assets') }}/img/organization/updated-image.png';
            }
        }else{
            imageElement.src = '{{ asset('assets') }}/img/organization/updated-image.png';
        }
    }


    $(document).ready(function() {
        $('#ordering_timeline').select2();
        $('#team_color').select2({
            templateSelection: function(selectedOption) {
                var hex = $(selectedOption.element).data('hex');
                var optionText = selectedOption.text;

                var optionHTML = $('<div class="row align-items-center" >');
                optionHTML.append('<div class="col-md-8" style="background-color: #' + hex + '; color: white; padding: 2px;font-size: .6rem;padding: 5.5px;">' + optionText + '</div>');
                optionHTML.append('<div class="col-md-4" style="background-color: #' + hex + '; color: #ffffffcc; font-size: 10px; padding: 2px;font-size: .5rem;padding: 5.5px;">' + hex + '</div>');

                return optionHTML;
            }
        });

        $('.done').on('click', function() {
            var pantoneCode = $('#pantoneCode').val().toLowerCase();

            var optionExists = false;

            $('#team_color option').each(function() {
                var optionText = $(this).text().toLowerCase();
                if (optionText === pantoneCode) {
                    $(this).prop('selected', true);

                    $('#team_color').trigger('change');
                    $('#colorModal').modal('hide');

                    optionExists = true;
                }
            });

            if (!optionExists) {
                $('#colorModalNotExist').modal('show');
            }
        });

        $('#colorModal').on('show.bs.modal', function() {
            $('#pantoneCode').val('');
        });

    });



    var breadcrumbId = 0;
    var contact_ids = <?php echo json_encode($contact_ids) ?>;

    $(document).ready( function () {
        var activityTable = null;

        function initializeActivityTable() {
            if (activityTable) {
                return activityTable;
            }

            if (!$('#activity_table').length) {
                return null;
            }

            activityTable = $('#activity_table').DataTable({
                "pageLength": 50,
                "columnDefs": [
                    { "type": "date", "targets": 2 }
                ]
            });

            return activityTable;
        }

        $('.select2-add-remove-people').select2({
            dropdownParent: $('#add_remove_contacts_modal')
        });

        $("#customer_id").select2();

        $('#organization_id_in_model').val($('#organization_id').val());
        $('#addRemoveContactsList').val(contact_ids).trigger('change');

        var loadedOrganizationTabs = {
            contacts: false,
            orders: false,
            emails: false,
            documents: false
        };

        var loadingOrganizationTabs = {
            contacts: false,
            orders: false,
            emails: false,
            documents: false
        };

        function organizationLazyTabUrl(tabName) {
            var url = new URL(window.location.href);
            url.hash = '';
            url.searchParams.set('lazy_tab', tabName);
            return url.toString();
        }

        function initializeLazyOrganizationTable(tabName) {
            if (tabName === 'contacts' && !$.fn.DataTable.isDataTable('#organization_contacts_table')) {
                $('#organization_contacts_table').DataTable({
                    pageLength: 25
                });
            }

            if (tabName === 'orders' && !$.fn.DataTable.isDataTable('#organization_orders_table')) {
                $('#organization_orders_table').DataTable({
                    pageLength: 25
                });
            }

            if (tabName === 'emails' && !$.fn.DataTable.isDataTable('#organization_emails_table')) {
                $('#organization_emails_table').DataTable({
                    pageLength: 25,
                    order: [],
                    columnDefs: [
                        {
                            type: 'date',
                            targets: 3
                        }
                    ]
                });
            }
        }

        function loadOrganizationTableTab(tabName, tbodySelector, columnCount) {
            if (loadedOrganizationTabs[tabName]) {
                initializeLazyOrganizationTable(tabName);
                return;
            }

            if (loadingOrganizationTabs[tabName]) {
                return;
            }

            loadingOrganizationTabs[tabName] = true;

            $.ajax({
                url: organizationLazyTabUrl(tabName),
                type: 'GET',
                dataType: 'html',
                cache: false,
                beforeSend: function () {
                    $('.se-pre-con').stop(true, true).fadeIn(100);
                },
                success: function (html) {
                    $(tbodySelector).html($.trim(html));
                    loadedOrganizationTabs[tabName] = true;
                    initializeLazyOrganizationTable(tabName);
                },
                error: function () {
                    $(tbodySelector).html(
                        '<tr>' +
                            '<td colspan="' + columnCount + '" class="text-center text-danger py-4">' +
                                'Unable to load this tab. Please click the tab again.' +
                            '</td>' +
                        '</tr>'
                    );
                },
                complete: function () {
                    loadingOrganizationTabs[tabName] = false;
                    $('.se-pre-con').stop(true, true).fadeOut(100);
                }
            });
        }

        $('#contactsTab').on('shown.bs.tab', function () {
            loadOrganizationTableTab('contacts', '#organization_contacts_tbody', 8);
        });

        $('#ordersTab').on('shown.bs.tab', function () {
            loadOrganizationTableTab('orders', '#organization_orders_tbody', 5);
        });

        $('#emailsTab').on('shown.bs.tab', function () {
            loadOrganizationTableTab('emails', '#organization_emails_tbody', 6);
        });

        $('#documentsTab').on('shown.bs.tab', function () {
            if (loadedOrganizationTabs.documents || loadingOrganizationTabs.documents) {
                return;
            }

            loadingOrganizationTabs.documents = true;

            var folderId = $('#oms_id').data('oms-id');
            var organizationId = $('#organization_id').val();
            var request = folderContent(folderId, organizationId);

            if (request && typeof request.done === 'function') {
                request
                    .done(function () {
                        loadedOrganizationTabs.documents = true;
                    })
                    .always(function () {
                        loadingOrganizationTabs.documents = false;
                    });
            } else {
                loadedOrganizationTabs.documents = true;
                loadingOrganizationTabs.documents = false;
            }
        });

        $('.select2-organization').select2();

        $('.select2-organization-modal').select2({
            dropdownParent: $('#organization_create_modal')
        });

        $('.select2-activity-modal').select2({
            dropdownParent: $('#create_activity_modal')
        });

        $('body').on('submit', function(e){
            $(".se-pre-con").fadeIn('slow');
        });

        // Add Organization
        $('#add_organization').click(function(){
            $('#organization_create_modal').modal('show');
        });

        // Edit Order
        $("body").on("click", ".edit-order", function(){
            var orderId = $(this).data('value');
            window.open('../../order_details/edit/' + orderId + '/order?active_tab=order', '_blank');
        });

        // Edit Contact
        $("body").on("click", ".edit-contact", function(){
            var contactId = $(this).data('value');
            window.location.replace('../../people/info/'+contactId);
        });

        // Update Organization
        $("body").on("click", "#saveForm", function(){
            // $('#organization_update').submit();
            //Check if Select2 input is filled
            if (!$('#lead_source').val()) {
                alert("Please select a lead source.");
            } else {
                $('#organization_update').submit(); // Submit the form if validation passes
            }
        });

        $('body').on('click', '#add_activity', function(){
            var organizationId = $('#organization_id').val();
            $.ajax({
                url:"{{ url('activities/filter_by_organization') }}/"+organizationId,
                method:'GET',
                dataType:'json',
                success: function (data, textStatus, jqXHR){
                    var orders = data.orders;
                    $('#activity_organization_id').val(organizationId).trigger('change')
                    $('#order_id').html('');
                    if(orders == null || orders == '') {
                        $('#order_id').append('<option value=""><i class=""></i> Orders</option>');

                    } else {
                        for (var i = 0; i < orders.length; i++) {
                            $('#order_id').append('<option value="'+orders[i].id+'">'+orders[i].order_no+' - '+orders[i].order_description+'</option>');
                        }
                    }

                    var contacts = data.contacts;
                    $('#contact_id').html('');
                    if(contacts == null || contacts == '') {
                        $('#contact_id').append('<option value="">People</option>');

                    } else {
                        for (var i = 0; i < contacts.length; i++) {
                            $('#contact_id').append('<option value="'+contacts[i].id+'">'+contacts[i].first_name+' '+contacts[i].last_name+'</option>');
                        }
                    }
                    $('#existing_organization').val(organizationId);
                    $('#create_activity_modal').modal('show');
                }
            });
        });

        $('#activity_tab').on('shown.bs.tab', function(){
            initializeActivityTable();

            var organization_id = $('#organization_id').val();
            getActivities(organization_id);
        });

        function getActivities(organization_id) {
            $.ajax({
                url: '{{ url("activities/get_activities_by_organization") }}/'+organization_id,
                type: "GET",
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    makeActivityTable(data);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        function makeActivityTable(data) {
            initializeActivityTable();

            if (!activityTable) {
                return;
            }

            activityTable.clear().draw();

            var classArr = [];
            classArr.push(
                'activity-checkbox', 'activity-done', 'activity-start-date', 'activity-assign-to', 'activity-description', 'activity-start-time', 'activity-notes',
                'activity-order-no', 'activity-contact-person', 'activity-created-by'
            );

            for (let i = 0; i < data.length; i++) {
                var start_date = moment(data[i].start_date).format('L');
                var start_time = moment(data[i].start_date).format('LT');
                // var due_date = moment(data[i].due_date).format('L');

                if (data[i].order_details) {
                    var order_no = data[i].order_details.order_no
                } else {
                    var order_no = '';
                }

                if (data[i].organization_details) {
                    var organization_name = data[i].organization_details.organization_name
                } else {
                    var organization_name = '';
                }

                if (data[i].contact_details) {
                    var contact_name = data[i].contact_details.first_name + ' ' + data[i].contact_details.last_name;
                } else {
                    var contact_name = '';
                }

                if (data[i].assignee_details) {
                    var assignee_name = data[i].assignee_details.name;
                } else {
                    var assignee_name = '';
                }

                if (data[i].user_details) {
                    var user_name = data[i].user_details.name;
                } else {
                    var user_name = '';
                }

                if (data[i].is_done == 1) {
                    var mark_as_done = '<span class="badge badge-pill badge-success">Done</span>';
                } else {
                    var mark_as_done = '<span class="badge badge-pill badge-danger">To Do</span>';
                }

                var checkbox = '<div class="custom-control custom-checkbox activity-chechbox-div">'+
                                    '<input type="checkbox" class="custom-control-input activity-chechbox" id="activity_chechbox_'+data[i].id+'" value="'+data[i].id+'" />'+
                                    '<label class="custom-control-label" for="activity_chechbox_'+data[i].id+'"></label>'+
                                '</div>';

                var column_data_arr = [];
                column_data_arr.push(
                    checkbox,
                    mark_as_done,
                    start_date,
                    assignee_name,
                    '<a href="#" class="activity-edit" data-activity_id="'+data[i].id+'">'+data[i].activity_subject+'</a>',
                    data[i].activity_note,
                    start_time,
                    // due_date,
                    order_no,
                    contact_name,
                    user_name
                );

                var row = activityTable.row.add([
                    column_data_arr[0],
                    column_data_arr[1],
                    column_data_arr[2],
                    column_data_arr[3],
                    column_data_arr[4],
                    column_data_arr[5],
                    column_data_arr[6],
                    column_data_arr[7],
                    column_data_arr[8],
                    column_data_arr[9],
                    // column_data_arr[10]
                ]);

                activityTable.row(row).draw();
                activityTable.row(row).column(0).nodes().to$().addClass(classArr[0]);
                activityTable.row(row).column(1).nodes().to$().addClass(classArr[1]);
                activityTable.row(row).column(2).nodes().to$().addClass(classArr[2]);
                activityTable.row(row).column(3).nodes().to$().addClass(classArr[3]);
                activityTable.row(row).column(4).nodes().to$().addClass(classArr[4]);
                activityTable.row(row).column(6).nodes().to$().addClass(classArr[5]);
                activityTable.row(row).column(5).nodes().to$().each(function() {
                                                                        var $this = $(this);
                                                                        var text = $this.text();
                                                                        if (text.length > 20) {
                                                                            text = text.substring(0, 20) + '...'; // Truncate text to 20 characters and add ellipsis
                                                                        }
                                                                        $this.text(text).addClass(classArr[6]); // Add class to the element
                                                                    });
                // activityTable.row(row).column(6).nodes().to$().addClass(classArr[6]);
                activityTable.row(row).column(7).nodes().to$().addClass(classArr[7]);
                activityTable.row(row).column(8).nodes().to$().addClass(classArr[8]);
                activityTable.row(row).column(9).nodes().to$().addClass(classArr[9]);
                // activityTable.row(row).column(9).nodes().to$().addClass(classArr[10]);
                activityTable.row(row).draw();
            }
            $('#activity-tab-active-button').click();
            $('.activity-start-time').hide();
        }
    });
    $(document).ready(function() {
        // Initial state: show 'To Do' tasks and hide 'Done' tasks
        $('#activity_table tbody tr').each(function() {
            var status = $(this).find('.activity-done').text().trim();
            if (status === 'To Do') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Click event handler for 'TO DO' button
        $('.activity-bar-new-tab-bar:eq(0)').click(function() {
            $('#activity_table tbody tr').each(function() {
                var status = $(this).find('.activity-done').text().trim();
                if (status === 'To Do') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            // Update button states
            $(this).addClass('active');
            $('.activity-bar-new-tab-bar:eq(1)').removeClass('active');
        });

        // Click event handler for 'DONE' button
        $('.activity-bar-new-tab-bar:eq(1)').click(function() {
            $('#activity_table tbody tr').each(function() {
                var status = $(this).find('.activity-done').text().trim();
                if (status === 'Done') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            // Update button states
            $(this).addClass('active');
            $('.activity-bar-new-tab-bar:eq(0)').removeClass('active');
        });
    });


    //Activity Done
    $('body').on('click', '.is-done', function(){
        var activityId = $(this).val();
        if($(this).prop('checked') ==  true){
            var chek = 1;
        } else {
            var chek = 0;
        }
        $.ajax({
            url:"{{ url('organizations/is_done') }}/"+activityId+'/'+chek,
            method:'GET',
            dataType:'json',
            success: function (data, textStatus, jqXHR){
                if(data == 'done'){
                    Swal.fire(
                    'Activity has done!',
                    'You clicked the button!',
                    'success'
                    )
                } else if(data == 'not_done'){
                    Swal.fire(
                    'Activity has not done!',
                    'You clicked the button!',
                    'warning'
                    )
                } else if(data == 'error'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Apologies',
                        text: 'Something went wrong!',
                    })
                }
            }
        });
    });

    // Change Organization Image
    $('#logo_image').on('click', function(){
        $('#organization_logo').trigger('click');
    });

    $('#show_map').on('click', function(){
        var organizationId = $(this).val();
        $.ajax({
            url:"{{ url('organizations/address') }}/"+organizationId,
            method:'GET',
            dataType:'json',
            success: function (data, textStatus, jqXHR){
                var address_for_map = [];

                    if(data.organization_name != null){
                        var org_name = data.organization_name;
                        var spl_name = org_name.split(' ');
                        spl_name.forEach(name => {
                            address_for_map += '%20'+name;
                        });
                    }
                    if(data.shipping_street != null){
                        var org_street = data.shipping_street;
                        var spl_street = org_street.split(' ');
                        spl_street.forEach(street => {
                            address_for_map += '%20'+street;
                        });
                    }
                    if(data.shipping_city != null){
                        var org_city = data.shipping_city;
                        var spl_city = org_city.split(' ');
                        spl_city.forEach(city => {
                            address_for_map += '%20'+city;
                        });
                    }
                    if(data.shipping_state != null){
                        var org_state = data.shipping_state;
                        var spl_state = org_state.split(' ');
                        spl_state.forEach(state => {
                            address_for_map += '%20'+state;
                        });
                    }
                    if(data.shipping_country != null){
                        var org_country = data.shipping_country;
                        var spl_country = org_country.split(' ');
                        spl_country.forEach(country => {
                            address_for_map += '%20'+country;
                        });
                    }

                $('#modal-title-default').append(org_name);
                $('<iframe width="1000" height="620" id="gmap_canvas" src="https://maps.google.com/maps?q='+ address_for_map +'&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-to.org"></a><br><a href="https://www.embedgooglemap.net"></a>').appendTo($('#frame_container'));

                $('#map_view_modal').modal('show');
            }
        });
    });

    function  image_previewe_info() {
        var image_preview = document.getElementById("image_previewe_info");
        var image_preview_header = document.getElementById("image_previewe_info_header");
        var file = document.querySelector("input[type=file]").files[0];

        var reader = new FileReader();
        reader.onloadend = function () {
            image_preview.src = reader.result;
            image_preview_header.src = reader.result;
            document.getElementById("base64").value = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            image_preview.src = "";

        }
    }

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

    $("#delete_form").on("click", function(){
        var fabricId = $(this).val();

        var orderCount = $("#orderCount").val();

        if(orderCount == 0){

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
                    window.location.replace("../../organizations/delete/"+fabricId);
                }
            });

        } else {

            Swal.fire({
                icon: 'error',
                title: 'Can`t delete this organization',
                text: 'There are some orders regarding with this organization.'
            })

        }

    });

    function folderContent(folderId, organization_id) {
        return $.ajax({
            url: '{{ url("organizations/oms/folders") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'folderId': folderId, 'organization_id':organization_id, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(values) {
                var data = values['folders'];
                var breadcrumbs = values['breadcrumbs'];

                var breadcrumbRow = [];
                var breadcrumbPath = [];
                for (let j = 0; j < breadcrumbs.length; j++) {
                    breadcrumbPath += breadcrumbs[j].path+'/';

                    breadcrumbFirst = '<a href="#"> Encore Drive </a>';
                    breadcrumbRow += '<i class="fas fa-angle-right"></i><a href="#" class="folder-id" data-folder-id="'+breadcrumbPath+'"> '+breadcrumbs[j].name+' </a>';
                }
                $('#breadcrumb_id').html(breadcrumbFirst + breadcrumbRow);

                if (data) {
                    var row = [];
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].display == 1) {
                            if (data[i].organization == '') {
                                var organization = '';
                            } else {
                                var organization = '<br><span class="oms-country-name">'+data[i].organization+'</span>';
                            }

                            row += '<div class="col-md-3 mb-2">'+
                                        '<button type="button" class="btn btn-outline-default text-left custom-btn-outline-default btn-folder-menu w-100" value="'+(data[i].name).replace(/ /g,"")+'">'+
                                            '<i class="fas fa-folder"></i> '+ data[i].name + organization +
                                        '</button>'+

                                        '<div class="folder-dropdown-content folder-menu '+(data[i].name).replace(/ /g,"")+'">'+
                                            '<button type="button" class="btn-folder-open" value="'+data[i].path+'" data-folder-name="'+data[i].name+'"><i class="fas fa-arrows-alt"></i> Open</button>'+
                                            '<button type="button"><i class="fas fa-info-circle"></i> View Details</button>'+
                                            '<button type="button"><i class="fas fa-user-plus"></i> Share</button>'+
                                            '<button type="button"><i class="fas fa-link"></i> Get Link</button>'+
                                        '</div>'+
                                    '</div>';
                        }
                    }

                    $('#content_title').html('Folder');
                    $('#folder_content').html(row);

                } else {
                    allFiles(folderId);
                }
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });

        function allFiles(folderId) {
            $.ajax({
                url: '{{ url("organizations/oms/files") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    'folderId': folderId, '_token':'{{csrf_token()}}'
                },
                success: function(data) {
                    if (data) {
                        var row = [];
                        for (let i = 0; i < data.length; i++) {
                            if (data[i].extension == 'jpg' || data[i].extension == 'jpeg' || data[i].extension == 'png') {
                                var fileContent = '<div class="card-body file-bg-img" style="background-image: url('+data[i].url+')"></div>';
                            } else if (data[i].extension == 'pdf') {
                                var fileContent = '<img src="{{asset("argon")}}/img/icons/pdf_icon.png" class="file-img mb-2" />';
                            } else {
                                var fileContent = '<img src="{{asset("argon")}}/img/icons/placeholder.png" class="file-img mb-2" />';
                            }

                            row += '<div class="col-md-3 file-conatiner">'+
                                        '<a class="open-file-details-modal" href="#" data-toggle="modal" data-target="#view_file_details">'+
                                            '<div class="card">'+
                                                '<div class="card-body">'+fileContent+'</div>'+

                                                '<div class="card-footer">'+
                                                    '<p class="file-name">'+data[i].name+'</p>'+
                                                '</div>'+
                                            '</div>'+
                                        '</a>'+
                                    '</div>';
                        }

                        $('#content_title').html('Files');
                        $('#folder_content').html(row);

                    } else {
                        var row = '<div class="col-md-3 file-conatiner"></div>';
                        $('#content_title').html('Files');
                        $('#folder_content').html(row);
                    }
                },
            });
        }

        // Open Folder Menu
        $('body').on('click', '.btn-folder-menu', function(){
            $('.folder-menu').hide();
            var folderId = $(this).val();
            $('.folder-menu.'+folderId).show(300);
        });

        $(document).mouseup(function(e){
            if (!$('.folder-menu').is(e.target) && $('.folder-menu').has(e.target).length === 0) {
                $('.folder-menu').hide();
                $('.folder-menu').unbind('click');
            }
        });
    }

    $('body').on('click', '.btn-folder-open', function(){
        var folderId = $(this).val();
        var organization_id = $('#organization_id').val();
        folderContent(folderId, organization_id);
    });

    $('body').on('click', '.folder-id', function() {
        var folderId = $(this).data('folder-id').slice(0, -1);
        var organization_id = $('#organization_id').val();
        folderContent(folderId, organization_id);
    });

    $('#addOrRemoveContactsBtn').click(function(){
        $('#add_remove_contacts_modal').modal('show');
    });

    function uploadFileInfo() {
        var image_preview = document.getElementById("image_previewe_info");
        var image_preview_header = document.getElementById("image_previewe_info_header");
        var file = document.querySelector("input[type=file]").files[0];

        var reader = new FileReader();
        reader.onloadend = function () {
            image_preview.src = reader.result;
            image_preview_header.src = reader.result;
            document.getElementById("base64").value = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            image_preview.src = "";

        }
    }

    $('body').on('click', '.activity-edit', function(e){
        e.preventDefault();
        var activity_id = $(this).data('activity_id');
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
                        $('.ql-editor').html(data.activity_note);
                        $('#start_date').val(start_date);
                        if(moment(data.start_date).format('HH:mm:ss') !== '00:00:00'){
                            $('#start_time').val(start_time);
                        }else{
                            $('#start_time').val('');
                        }
                        $('#activity_priority').val(data.priority).trigger('change');
                        $('#due_date').val(due_date);
                        $('#activity_user_id').val(data.assigned_to).trigger('change');
                        $('#is_done').prop('checked', data.is_done == 1);

                        $('#activity_organization_id').val(data.organization_id).trigger('change');
                        activity_order_id = data.order_id;
                        activity_contact_id = data.contact_id;

                        $('#submit_btn_text').html('Update');
                        // $('#activity_form_title').html('Edit');
                        $('#new_activity_form_title').html('Edit Activity');
                        $('#is_done_div').removeAttr('hidden');
                        $('#add_activity_form').attr('action', '{{ route("activities.update") }}');

                        var assignedUserName = '';
                        var modifiedUserName = '';


                        var all_users = @json($allusers);
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

                        $('#created_at_tr').html(`<td></td><td style="color: grey;padding-top: .5rem;">Created : ${formatDate1(data.created_at)}  ${assignedUserName} </td>`);
                        $('#modified_at_tr').html(`<td></td><td style="color: grey;">Last Modified : ${formatDate1(data.updated_at)}  ${modifiedUserName} </td>`);

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

    const formatDate1 = (datetime) => {
        const date = new Date(datetime);
        const options = {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true,
            timeZoneName: 'short'
        };

        return new Intl.DateTimeFormat('en-US', options).format(date);
    };

    $('body').on('click', '.activity-chechbox', function() {
        var activity_array = [];
        $('.activity-chechbox:checked').each(function () {
            activity_array.push($(this).val());
        });

        if (activity_array.length > 0) {
            $('#mark_as_done_activites').val(activity_array);
            $('#mark_as_todo_activites').val(activity_array);
            $('#mark_to_delete_activites').val(activity_array);
            $('.activity-top-controls').show(700);
        } else {
            $('#mark_as_done_activites').val('');
            $('#mark_as_todo_activites').val('');
            $('#mark_to_delete_activites').val('');
            $('.activity-top-controls').hide(700);
        }
    });
    $(document).ready(function(){

        loadAllTab(true);

        if ($('#minimize_icon').css('display') != 'none') {
            $('#minimize_icon')[0].click();
        }

        $('#scrolling_activities').on('scroll', function () {
            let $this = $(this);

            if ($this.scrollTop() + $this.innerHeight() >= this.scrollHeight - 10) {
                loadAllTab(false);
            }
        });
    });
    function isEmailInArray(email, emailArray) {
        return emailArray.includes(email);
    }
    function extractEmails(recipientsJson , all_email_arr) {
        if (recipientsJson) {
            try {
                var recipients = JSON.parse(recipientsJson);
                if (Array.isArray(recipients)) {
                    recipients.forEach(function(recipient) {
                        if (recipient.emailAddress && recipient.emailAddress.address) {
                            all_email_arr.push(recipient.emailAddress.address);
                        }
                    });
                }
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
        }
    }

var loadedCount = 0;
var pageSize = 10;
var all_element_arr_length = 0;

function loadAllTab(is_first_loads) {

    if(loadedCount >= all_element_arr_length && all_element_arr_length > 0) {
        return;
    }
    var organization_id = $('#organization_id').val();
        $.ajax({
            url: '{{ url("activities/get_activities_by_organization") }}/' + organization_id,
            type: "GET",
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                var persons = @json($contacts);
                var organization_email_raw = @json($orgnizationEmails);

                var draftEmails = [];
                var otherEmails = [];
                var azure_logged_email = @json($azure_logged_email);
                var organization_email = Array.isArray(organization_email_raw) ? organization_email_raw : [];

                if(organization_email.length > 0) {
                    organization_email.forEach(function(email) {
                        if (email.type === 'Draft') {
                            if(email.sender_email == azure_logged_email ){

                                draftEmails.push(email);
                            }
                        } else {
                            if(email.type !== 'backup'){
                                otherEmails.push(email);
                            }
                        }
                    });
                }
                var all_element_arr = [];

                let today = new Date();
                today = normalizeDate(today);

                otherEmails.forEach(element => {
                    let transformedElement = {
                        date: element.date,
                        data: element,
                        type: 'email'
                    };
                    all_element_arr.push(transformedElement);
                });
                draftEmails.forEach(element => {
                    let transformedElement = {
                        date: element.date,
                        data: element,
                        type: 'draft'
                    };
                    all_element_arr.push(transformedElement);
                });

                data.forEach(element => {
                    let transformedElement = {
                        date: element.start_date,
                        data: element,
                        type: 'activity'
                    };
                    all_element_arr.push(transformedElement);
                });

                all_element_arr.sort((a, b) => new Date(b.date) - new Date(a.date));

                if (is_first_loads) {
                    all_element_arr = all_element_arr.slice(0, 20);
                }

                var activity_content_history = '';
                var activity_content_focus = '';
                var email_content_history = '';
                var email_content_focus = '';

                console.log(loadedCount, pageSize);

                all_element_arr_length = all_element_arr.length;

            if (loadedCount < all_element_arr_length) {

                const remaining = all_element_arr_length - loadedCount;
                const countToLoad = Math.min(pageSize, remaining);

                const batch = all_element_arr.slice(loadedCount, loadedCount + countToLoad);

                batch.forEach(arr_elements => {
                    if (arr_elements.type == "activity") {

                        var activity_arr = arr_elements.data;

                        var act_person = persons.find(person => person.id === activity_arr.contact_id);

                        var personName = act_person ? ((act_person.first_name ? act_person.first_name : '') + ' ' + (act_person.last_name ? act_person.last_name : '')) : '';

                        var activitySubject = activity_arr.activity_subject;
                        if (activitySubject && activitySubject.length > 45) {
                            activitySubject = activitySubject.substring(0, 45) + "..";
                        }

                        var activity_note = activity_arr.activity_note ? activity_arr.activity_note.replace(/<[^>]*>/g, '') : '';

                        if (activity_note && activity_note.length > 200) {
                            activity_note = activity_note.substring(0, 200) + "...";
                        }

                        var checkbox_text = activity_arr.is_done == 1 ? `<i class="fa fa-check-circle" aria-hidden="true" style="font-size: 1rem;color:green" ></i>&nbsp;` : `<i class="fa fa-circle-o" aria-hidden="true" style="font-size: 1rem;color:#b3b3b3" ></i>&nbsp;`;

                        var relativeDate = getRelativeDate(activity_arr.start_date, activity_arr.is_done);

                        if(arr_elements.type == "activity"){

                            var act_badge = '';

                            if(relativeDate.relativeDate == 'Today'){
                                act_badge = '<span class="badge bg-success mr-3">TODAY</span>';
                            }else if(normalizeDate(activity_arr.start_date) < today && relativeDate.isFuture){
                                act_badge = '<span class="badge bg-danger mr-3">OVERDUE</span>';
                            }else{
                                act_badge = '';
                            }

                            var content = `
                                <li>
                                    <time class="cbp_tmtime"><span>${formatDate(activity_arr.start_date)}</span> <span style="font-size: 12px;">${formatTime(activity_arr.start_date)}</span> <span style="font-size: 11px;">${relativeDate.relativeDate}</span></time>
                                    <div class="cbp_tmicon bg-custom-color"><i class="fa fa-clock" aria-hidden="true"></i></div>
                                    <div class="cbp_tmlabel">
                                        <div class="row">
                                            <div class="col-md-8">
                                                ${checkbox_text}
                                                <a href="#" class="mb-1 heading-link activity-edit" data-activity_id="${activity_arr.id}" style="font-size: 1rem;color: black;font-weight: 500;">${activitySubject}</a>
                                            </div>
                                            <div class="col-md-4 text-right" style="padding: 0;padding-right:10px"><small class="text-right">${personName}</small></div>
                                        </div>
                                        <div>${act_badge}<small style="font-size:.7rem">${activity_note}</small></div>
                                    </div>
                                </li>`;

                            if (relativeDate.isFuture) {
                                $('#timeline_content_focus').prepend(content);
                            } else {
                                $('#timeline_content_history').append(content);
                            }
                        }
                    } else if (arr_elements.type == "email") {
                        var email_arr = arr_elements.data;

                        var email_body = '';

                        var email_subject = email_arr.subject;
                        if (email_subject && email_subject.length > 45) {
                            email_subject = email_subject.substring(0, 45) + "...";
                        }

                        var arr_data = JSON.stringify(email_arr);
                        var escaped_data = escapeHtml(arr_data);

                        var relativeDate = getRelativeDate(email_arr.date, 1);

                        var azure_logged_email = @json($azure_logged_email);
                        var all_email_arr = [];

                        extractEmails(email_arr.toRecipients , all_email_arr);
                        extractEmails(email_arr.ccRecipients , all_email_arr);

                        if(azure_logged_email && (isEmailInArray(azure_logged_email, all_email_arr) || email_arr.sender_email == azure_logged_email)){
                        var reply_all_content = `
                                                <div class="btn-group">
                                                    <button type="button" style="border: 1px solid white;"  data-messageid = "`+email_arr.message_no+`" class="btn custom-btn btn-outline-secondary btn-sm reply-all-head"><i class="fas fa-reply-all" style="padding-right: 5px;"></i>Reply All</button>
                                                    <button type="button" style="border: 1px solid white;" class="btn btn-outline-secondary custom-btn btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item reply-head" data-messageid = "`+email_arr.message_no+`" href="#">Reply</a>
                                                        <a class="dropdown-item reply-all-head" data-messageid = "`+email_arr.message_no+`" href="#">Reply All</a>
                                                        <a class="dropdown-item forward-head" data-messageid = "`+email_arr.message_no+`" href="#">Forward</a>
                                                        <a style="color:#ff9e9e" class="dropdown-item unlink-head" data-messageid = "`+email_arr.message_no+`" href="#">Unlink</a>

                                                    </div>
                                                </div>`;
                        }else{
                            var reply_all_content = email_arr.sender_email;
                        }
                        var content = `
                            <li>
                                <time class="cbp_tmtime "><span>${formatDate(email_arr.date)}</span> <span style="font-size: 12px;">${formatTime(email_arr.date)}</span> <span style="font-size: 11px;">${relativeDate.relativeDate}</span></time>
                                <div class="cbp_tmicon bg-custom-color"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                <div class="cbp_tmlabel">
                                    <div class="row mb-2">
                                        <div class="col-md-8">
                                            <a href="#" data-org_email_id='${escaped_data}' class="mb-1 heading-link view-email" style="font-size: 1rem;color: black;font-weight: 500;">${email_subject}</a>
                                        </div>
                                        <div class="col-md-4 text-right" style="padding-right: 0;"><small class="text-right" style="padding: 0;padding-right:10px">${reply_all_content}</small></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11">
                                            <small class="email-body-temp-text" title="Click here to view email" style="font-size:.7rem;">${email_body}</small>
                                        </div>
                                        <div class="col-md-1">
                                            <i class="fa fa-sort email-body-text" data-email-id="${email_arr.id}" style="cursor: pointer" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="email-body-html" id="email_body" style="max-height: 30rem;overflow-y: auto;display:none">
                                    </div>
                                </div>
                            </li>`;

                        if (relativeDate.isFuture) {
                            $('#timeline_content_focus').append(content);
                        } else {
                            $('#timeline_content_history').append(content);
                        }
                    }else if (arr_elements.type == "draft") {
                        var email_arr = arr_elements.data;

                        var email_body = '';

                        var email_subject = email_arr.subject;
                        if (email_subject && email_subject.length > 45) {
                            email_subject = email_subject.substring(0, 45) + "...";
                        }

                        var arr_data = JSON.stringify(email_arr);
                        var escaped_data = escapeHtml(arr_data);

                        var relativeDate = getRelativeDate(email_arr.date, 1);
                        var reply_all_content = `<i class="fa fa-trash email-draft-delete mr-2" data-draft_id_to_delete="${email_arr.message_no}" style="cursor: pointer;color: #edb5b5;font-size: .8rem;" aria-hidden="true"></i>`;

                        var content = `
                            <li>
                                <time class="cbp_tmtime "><span>${formatDate(email_arr.date)}</span> <span style="font-size: 12px;">${formatTime(email_arr.date)}</span> <span style="font-size: 11px;">${relativeDate.relativeDate}</span></time>
                                <div class="cbp_tmicon bg-custom-color"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                <div class="cbp_tmlabel">
                                    <div class="row mb-2">
                                        <div class="col-md-8">
                                            <a href="#" data-org_email_id='${escaped_data}' class="mb-1 heading-link draft-email" style="font-size: 1rem;color: black;font-weight: 500;">${email_subject}</a>
                                        </div>
                                        <div class="col-md-4 text-right" style="padding-right: 0;"><small class="text-right" style="padding: 0;padding-right:10px">${reply_all_content}</small></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11">
                                            <span style="background-color: #8aedfb !important;" class="badge bg-success mr-3">DRAFT</span><small class="email-body-temp-text" title="Click here to view email" style="font-size:.7rem;">${email_body}</small>
                                        </div>
                                        <div class="col-md-1">
                                            <i class="fa fa-sort email-body-text" data-email-id="${email_arr.id}" style="cursor: pointer" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="email-body-html" id="email_body" style="max-height: 30rem;overflow-y: auto;display:none">
                                    </div>
                                </div>
                            </li>`;

                        $('#timeline_content_focus').prepend(content);
                    }
                });

                loadedCount += batch.length;
                var scrollHeight = loadedCount * 5;
                if(loadedCount == 1){
                    scrollHeight = 10;
                }
                if (scrollHeight > 100) {
                    scrollHeight = 100;
                }
                $('#scrolling_activities').css('max-height', scrollHeight + 'rem');
            }
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
}
function sanitizeHTML(htmlString) {
    const container = document.createElement('div');

    container.innerHTML = `<div>${htmlString}</div>`;

    container.querySelectorAll('script').forEach(el => el.remove());

    container.querySelectorAll('style').forEach(el => el.remove());

    return container.innerHTML;
}
function normalizeDate(date) {
    let normalized = new Date(date);
    normalized.setHours(0, 0, 0, 0);
    return normalized;
}
function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

    $(document).on('click', '.email-body-text', function() {
        var $button = $(this);
        var $row = $button.closest('.row');
        var $preview = $row.find('.email-body-temp-text');
        var $body = $row.next('.email-body-html');

        if ($body.data('loaded')) {
            $body.toggle();
            $preview.toggle();
            return;
        }

        if ($button.data('loading')) {
            return;
        }

        $button.data('loading', true);

        $.ajax({
            url: '{{ url("activities/get_organization_email_body") }}/' + $button.data('email-id'),
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $body.html(sanitizeHTML(data.body || ''));
                $body.data('loaded', true).show();
                $preview.hide();
            },
            complete: function() {
                $button.data('loading', false);
            }
        });
    });
    function formatDate(dateTimeString) {
        var user_timezone = @json($user_timezone);
        const date = new Date(dateTimeString + 'Z');
        date.toUTCString();
        const options = { year: 'numeric', month: 'long', day: 'numeric', timeZone: user_timezone };
        return date.toLocaleDateString('en-US', options);
    }

    function formatTime(dateTimeString) {
        var user_timezone = @json($user_timezone); // Assuming user_timezone is passed from the server
        const date = new Date(dateTimeString + 'Z');

        date.toUTCString();
        const options = { hour: '2-digit', minute: '2-digit', timeZone: user_timezone };

        // Convert to user's local time
        const userTimeString = new Intl.DateTimeFormat('en-US', options).format(date);

        // Check if the time is exactly midnight
        if (userTimeString === '12:00 AM') {
            return '---';
        } else {
            return userTimeString;
        }
    }
    function getRelativeDate(dateTimeString, is_done) {
        var date = new Date(dateTimeString);
        date = normalizeDate(date);
        var today = new Date();
        today = normalizeDate(today);

        if (date >= today) {
            const diffTime = date - today;
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            const diffYears = date.getFullYear() - today.getFullYear();

            if (diffYears === 0) {
                if (diffDays === 0) {
                    return { relativeDate: 'Today', isFuture: true };
                } else if (diffDays === 1) {
                    return { relativeDate: 'Tomorrow', isFuture: true };
                } else if (diffDays < 7) {
                    return { relativeDate: `${diffDays} days from now`, isFuture: true };
                } else if (diffDays < 14) {
                    return { relativeDate: 'A week from now', isFuture: true };
                } else if (diffDays < 21) {
                    return { relativeDate: '2 weeks from now', isFuture: true };
                } else if (diffDays < 28) {
                    return { relativeDate: '3 weeks from now', isFuture: true };
                } else {
                    const diffWeeks = Math.floor(diffDays / 7);
                    return { relativeDate: `${diffWeeks} weeks from now`, isFuture: true };
                }
            } else if (diffYears === 1) {
                return { relativeDate: '1 year from now', isFuture: true };
            } else {
                return { relativeDate: `${Math.abs(diffYears)} years from now`, isFuture: true };
            }
        } else {
            const diffTime = today - date;
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            const diffYears = today.getFullYear() - date.getFullYear();

            var future_val = false;

            if(is_done == 0){
                future_val = true;
            }else{
                future_val = false;
            }

            if (diffYears === 0) {
                if (diffDays === 0) {
                    return { relativeDate: 'Today', isFuture: true };
                } else if (diffDays === 1) {
                    return { relativeDate: 'Yesterday', isFuture: future_val };
                } else if (diffDays < 7) {
                    return { relativeDate: `${diffDays} days ago`, isFuture: future_val };
                } else if (diffDays < 14) {
                    return { relativeDate: 'A week ago', isFuture: future_val };
                } else if (diffDays < 21) {
                    return { relativeDate: '2 weeks ago', isFuture: future_val };
                } else if (diffDays < 28) {
                    return { relativeDate: '3 weeks ago', isFuture: future_val };
                } else {
                    const diffWeeks = Math.floor(diffDays / 7);
                    return { relativeDate: `${diffWeeks} weeks ago`, isFuture: future_val };
                }
            } else if (diffYears === 1) {
                return { relativeDate: '1 year ago', isFuture: future_val };
            } else {
                return { relativeDate: `${Math.abs(diffYears)} years ago`, isFuture: future_val };
            }
        }
    }
    $(document).ready(function() {

        $('#focus_button').click(function() {
            $('#timeline_content_focus').toggleClass('hidden');
            $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
        });
        $('#history_button').click(function() {
            $('#timeline_content_history').toggleClass('hidden');
            $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
        });
    });
    $(document).ready(function () {

        function toggleBillingAddress() {
            if ($('#same_as_shipping_address').is(':checked')) {
                $('.billing-address-details').slideUp(200);
            } else {
                $('.billing-address-details').slideDown(200);
            }
        }
        toggleBillingAddress();

        $('#same_as_shipping_address').on('change', function () {
            toggleBillingAddress();
        });

    });


    // Organization Samples & Fabric Swatches
    (function () {
        var sampleSaveUrl = @json(route('organizations.sample_shipment.save', ['id' => $organization->id]));
        var sampleDeliverUrl = @json(route('organizations.sample_shipment.deliver', ['id' => $organization->id]));
        var sampleImageUploadUrl = @json(route('organizations.sample_shipment.upload_image', ['id' => $organization->id]));
        var csrfToken = @json(csrf_token());

        function getSampleNoteContent() {
            var $note = $('#sample_shipment_note');
            if ($note.data('editor-initialized')) {
                var html = $note.siblings('.Editor-container').find('.Editor-editor').html() || '';
                if ($.trim($('<div>').html(html).text()) === '' && html.indexOf('<img') === -1) {
                    return '';
                }
                return html;
            }
            return $note.val() || '';
        }

        function showSampleAlert(message, type) {
            Swal.fire({
                icon: type === 'success' ? 'success' : 'error',
                title: type === 'success' ? 'Success' : 'Error',
                text: message,
                confirmButtonText: 'OK',
                confirmButtonColor: type === 'success' ? '#47D6B6' : '#d33'
            });
        }

        function updateSampleWorkflowFieldState(status) {
            var $delDate = $('#sample_delivered_date');
            var $trackingFields = $('#sample_tracking_number, #sample_tracking_link');
            var isRequested = (status === 'requested' || status === 'received');

            if (isRequested) {
                $delDate.prop('readonly', false)
                    .removeAttr('tabindex')
                    .css({ 'pointer-events': '', 'background-color': '', 'cursor': '' });

                if (!$delDate.hasClass('summary-datepicker')) {
                    $delDate.addClass('summary-datepicker');
                }

                if ($delDate.hasClass('hasDatepicker')) {
                    $delDate.datepicker('enable');
                } else if ($.fn.datepicker) {
                    $delDate.datepicker();
                }

                $trackingFields.prop('readonly', false)
                    .removeAttr('tabindex')
                    .css({ 'pointer-events': '', 'background-color': '', 'cursor': '' });
            } else {
                $delDate.prop('readonly', true)
                    .attr('tabindex', '-1')
                    .css({ 'pointer-events': 'none', 'background-color': '#f4f6f8', 'cursor': 'not-allowed' });

                if ($delDate.hasClass('hasDatepicker')) {
                    $delDate.datepicker('disable');
                }

                $trackingFields.prop('readonly', true)
                    .attr('tabindex', '-1')
                    .css({ 'pointer-events': 'none', 'background-color': '#f4f6f8', 'cursor': 'not-allowed' });
            }
        }

        function setSampleStatus(status) {
            var $badge = $('#sampleShipmentStatus');
            var $icon = $badge.find('i');
            var $text = $('#sampleShipmentStatusText');

            $badge.removeClass('status-empty status-received status-delivered');
            $icon.removeClass('fa-minus-circle fa-clock-o fa-check-circle');

            if (status === 'delivered') {
                $badge.addClass('status-delivered');
                $icon.addClass('fa-check-circle');
                $text.text('Delivered');
                $('#confirmSampleDelivered').hide();
            } else {
                $badge.addClass('status-received');
                $icon.addClass('fa-clock-o');
                $text.text('Requested');
                $('#confirmSampleDelivered').show();
            }

            updateSampleWorkflowFieldState(status);
        }

        function collectSampleProducts() {
            var products = [];

            $('#sampleProductRows .sample-product-row').each(function () {
                var productId = $(this).find('.sample-product-select').val();
                var sizeId = $(this).find('.sample-size-select').val();

                if (productId || sizeId) {
                    products.push({
                        product_id: productId || '',
                        size_id: sizeId || ''
                    });
                }
            });

            return products;
        }

        function initSampleProductSelects($scope) {
            if (!$.fn.select2) {
                return;
            }

            var $selects = $scope
                ? $scope.find('.sample-product-select')
                : $('.sample-product-select');

            $selects.each(function () {
                var $select = $(this);

                if ($select.hasClass('select2-hidden-accessible')) {
                    return;
                }

                $select.select2({
                    width: '100%',
                    placeholder: 'Select product',
                    allowClear: true
                });
            });
        }

        function resetClonedSampleRow($row) {
            var $productSelect = $row.find('.sample-product-select');

            // Remove Select2 markup copied from the source row before initializing the clone.
            $row.find('.select2-container').remove();
            $productSelect
                .removeClass('select2-hidden-accessible')
                .removeAttr('data-select2-id aria-hidden tabindex')
                .find('option')
                .removeAttr('data-select2-id');

            $productSelect.val('');
            $row.find('.sample-size-select').val('');
        }

        $('#addSampleProductRow').on('click', function () {
            var $firstRow = $('#sampleProductRows .sample-product-row:first');
            var $newRow = $firstRow.clone(false, false);

            resetClonedSampleRow($newRow);
            $('#sampleProductRows').append($newRow);
            initSampleProductSelects($newRow);
        });

        $(document).on('click', '.sample-remove-row', function () {
            var $rows = $('#sampleProductRows .sample-product-row');
            var $row = $(this).closest('.sample-product-row');

            if ($rows.length === 1) {
                $row.find('.sample-product-select').val(null).trigger('change');
                $row.find('.sample-size-select').val('');
                return;
            }

            var $productSelect = $row.find('.sample-product-select');
            if ($.fn.select2 && $productSelect.hasClass('select2-hidden-accessible')) {
                $productSelect.select2('destroy');
            }

            $row.remove();
        });

        if ($.fn.select2) {
            initSampleProductSelects();

            $('#sample_fabric_swatches').select2({
                width: '100%',
                placeholder: 'Select fabric swatches'
            });
        }

        $('#saveSampleShipment').on('click', function () {
            var $button = $(this);
            var originalHtml = $button.html();

            $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Requesting...');

            $.ajax({
                url: sampleSaveUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: csrfToken,
                    received_date: $('#sample_received_date').val(),
                    tracking_number: $('#sample_tracking_number').val(),
                    tracking_link: $('#sample_tracking_link').val(),
                    products: collectSampleProducts(),
                    fabric_swatches: $('#sample_fabric_swatches').val() || [],
                    shipping_contact_id: $('#sample_contact_id').val(),
                    shipping_street: $('#sample_shipping_street').val(),
                    shipping_city: $('#sample_shipping_city').val(),
                    shipping_state: $('#sample_shipping_state').val(),
                    shipping_postal_code: $('#sample_shipping_postal_code').val(),
                    shipping_country: $('#sample_shipping_country').val(),
                    note: getSampleNoteContent()
                },
                success: function (response) {
                    setSampleStatus(response.status || 'received');

                    if (response.received_date) {
                        $('#sample_received_date').val(response.received_date);
                    }

                    // if (response.delivered_date) {
                    //     $('#sample_delivered_date').val(response.delivered_date);
                    // }

                    showSampleAlert(response.message || 'Sample request saved successfully.', 'success');

                    $button.prop('disabled', true).html('Sample Requested');
                    $('#confirmSampleDelivered').show();
                    $('#sample_received_date').prop('readonly', true);
                    $('#sample_delivered_date').prop('readonly', false);
                    $('#sample_tracking_number').prop('readonly', false);
                    $('#sample_tracking_link').prop('readonly', false);
                },
                error: function (xhr) {
                    var message = 'Unable to request samples.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    showSampleAlert(message, 'error');
                    $button.prop('disabled', false).html(originalHtml);
                }
            });
        });

        $('#confirmSampleDelivered').on('click', function () {
            var $button = $(this);
            var originalHtml = $button.html();

            Swal.fire({
                title: 'Confirm Delivery',
                text: 'Confirm that this sample package has been delivered?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Confirm Delivered',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#47D6B6',
                cancelButtonColor: '#6c757d'
            }).then(function (result) {
                if (!result.value) {
                    return;
                }

                $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Confirming...');

                $.ajax({
                    url: sampleDeliverUrl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: csrfToken,
                        delivered_date: $('#sample_delivered_date').val(),
                        received_date: $('#sample_received_date').val(),
                        tracking_number: $('#sample_tracking_number').val(),
                        tracking_link: $('#sample_tracking_link').val(),
                        products: collectSampleProducts(),
                        fabric_swatches: $('#sample_fabric_swatches').val() || [],
                        shipping_contact_id: $('#sample_contact_id').val(),
                        shipping_street: $('#sample_shipping_street').val(),
                        shipping_city: $('#sample_shipping_city').val(),
                        shipping_state: $('#sample_shipping_state').val(),
                        shipping_postal_code: $('#sample_shipping_postal_code').val(),
                        shipping_country: $('#sample_shipping_country').val(),
                        note: getSampleNoteContent()
                    },
                    success: function (response) {
                        setSampleStatus('delivered');

                        if (response.delivered_date) {
                            $('#sample_delivered_date').val(response.delivered_date);
                        }

                        showSampleAlert(response.message || 'Sample shipment marked as delivered.', 'success');

                        $button.hide();
                        $('#saveSampleShipment').prop('disabled', true);
                        $('#sample_received_date').prop('readonly', true);
                        $('#sample_delivered_date').prop('readonly', true);
                        $('#sample_tracking_number').prop('readonly', true);
                        $('#sample_tracking_link').prop('readonly', true);
                    },
                    error: function (xhr) {
                        var message = 'Unable to confirm delivery.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        showSampleAlert(message, 'error');
                        $button.prop('disabled', false).html(originalHtml);
                    }
                });
            });
        });

        $('#copySampleTrackingLink').on('click', function () {
            var trackingLink = ($('#sample_tracking_link').val() || '').trim();
            if (!trackingLink) {
                showSampleAlert('Tracking link is empty. Please enter a tracking link first.', 'error');
                return;
            }

            var $btn = $(this);
            var originalHtml = $btn.html();

            function doCopy(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    return navigator.clipboard.writeText(text);
                } else {
                    return new Promise(function (resolve, reject) {
                        try {
                            var $temp = $('<textarea>');
                            $('body').append($temp);
                            $temp.val(text).select();
                            var successful = document.execCommand('copy');
                            $temp.remove();
                            if (successful) {
                                resolve();
                            } else {
                                reject(new Error('Copy failed'));
                            }
                        } catch (err) {
                            reject(err);
                        }
                    });
                }
            }

            doCopy(trackingLink).then(function () {
                $btn.html('<i class="fa fa-check mr-1"></i> Copied!').addClass('copied');
                setTimeout(function () {
                    $btn.html(originalHtml).removeClass('copied');
                }, 2000);
            }).catch(function (err) {
                console.error('Failed to copy: ', err);
                showSampleAlert('Failed to copy tracking link to clipboard.', 'error');
            });
        });

        // Initialize Rich Text Editor for Sample / Delivery Note
        if (!$('#sample_shipment_note').data('editor-initialized')) {
            $("#sample_shipment_note").Editor({
                'block_quote': false,
                'undo': true,
                'redo': true,
                'unlink': true,
                'insert_img': false,
                'insert_table': false,
                'splchars': false,
                'hr_line': true,
                'print': false,
                'rm_format': true,
                'select_all': false,
                'source': false,
                'togglescreen': false
            });
            $('#sample_shipment_note').data('editor-initialized', true);

            var initialNote = @json($sampleShipment ? $sampleShipment->note : '');
            if (initialNote) {
                $('#sample_shipment_note').Editor("setText", initialNote);
            }

            // Append custom image upload button to toolbar
            if ($('#menuBarDiv_sample_shipment_note .toolbar-image-btn').length === 0) {
                var $attachBtn = $(
                    '<div class="btn-group" style="margin-left:auto;">' +
                        '<button type="button" class="toolbar-image-btn" title="Upload & Insert Image">' +
                            '<i class="fa fa-image mr-1"></i> Image' +
                        '</button>' +
                    '</div>'
                );

                $attachBtn.on('click', function (e) {
                    e.preventDefault();
                    $('#sample-note-file').trigger('click');
                });

                $('#menuBarDiv_sample_shipment_note').append($attachBtn);
            }
        }

        // Handle Image File Selection & Upload
        $('body').on('change', '#sample-note-file', async function () {
            var files = this.files;
            if (!files || files.length === 0) return;

            var validFiles = [];
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var ext = (file.name.split('.').pop() || '').toLowerCase();
                if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].indexOf(ext) !== -1) {
                    validFiles.push(file);
                }
            }

            if (validFiles.length === 0) {
                showSampleAlert('Please select valid image files (JPG, PNG, GIF, WEBP, SVG).', 'error');
                $(this).val('');
                return;
            }

            $('.sample-image-upload-progress').show();
            $('.sample-image-upload-progress .image-upload-progress-bar').css('width', '0%');
            $('.sample-image-upload-progress .image-upload-progress-text').text('0%');

            var $editor = $('#sample_shipment_note').siblings('.Editor-container').find('.Editor-editor');
            var tempIds = [];

            for (var i = 0; i < validFiles.length; i++) {
                var tempId = 'temp_note_img_' + Date.now() + '_' + i;
                tempIds.push(tempId);
                var blobUrl = URL.createObjectURL(validFiles[i]);

                $editor.append(
                    '<div class="sample-note-image-box temp-sample-img-box" id="' + tempId + '" style="margin:6px 4px; display:inline-block; vertical-align:top; max-width:100%;">' +
                        '<img src="' + blobUrl + '" class="zoomable-sample-image" alt="Sample Note Image" />' +
                    '</div>'
                );
            }

            try {
                var fd = new FormData();
                for (var i = 0; i < validFiles.length; i++) {
                    fd.append('upload_file[]', validFiles[i]);
                }
                fd.append('_token', csrfToken);

                var response = await $.ajax({
                    url: sampleImageUploadUrl,
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function (evt) {
                            if (evt.lengthComputable) {
                                var percent = Math.round((evt.loaded / evt.total) * 100);
                                $('.sample-image-upload-progress .image-upload-progress-bar').css('width', percent + '%');
                                $('.sample-image-upload-progress .image-upload-progress-text').text(percent + '%');
                            }
                        }, false);
                        return xhr;
                    }
                });

                if (response && response.data && Array.isArray(response.data)) {
                    for (var i = 0; i < response.data.length; i++) {
                        var item = response.data[i];
                        var permUrl = item.url || item.path || item;
                        if (tempIds[i] && $('#' + tempIds[i]).length) {
                            var $box = $('#' + tempIds[i]);
                            $box.removeClass('temp-sample-img-box');
                            $box.find('img').attr('src', permUrl);
                        }
                    }
                }

                $('.sample-image-upload-progress .image-upload-progress-bar').css('width', '100%');
                $('.sample-image-upload-progress .image-upload-progress-text').text('100%');
                setTimeout(function () {
                    $('.sample-image-upload-progress').hide();
                    $('.sample-image-upload-progress .image-upload-progress-bar').css('width', '0%');
                    $('.sample-image-upload-progress .image-upload-progress-text').text('0%');
                }, 400);

            } catch (err) {
                console.error('Image upload failed', err);
                $('.sample-image-upload-progress').hide();
                $('.temp-sample-img-box').remove();
                showSampleAlert('Failed to upload image. Please try again.', 'error');
            }

            $('#sample-note-file').val('');
        });

        // Paste screenshots/images from clipboard
        $(document).on('paste', '.sample-note-editor-wrapper .Editor-editor', async function (e) {
            var clipboardData = (e.originalEvent || e).clipboardData;
            if (!clipboardData || !clipboardData.items) return;

            var imageFiles = [];
            for (var i = 0; i < clipboardData.items.length; i++) {
                var item = clipboardData.items[i];
                if (item.type.indexOf('image') !== -1) {
                    var blob = item.getAsFile();
                    if (blob) imageFiles.push(blob);
                }
            }

            if (imageFiles.length > 0) {
                e.preventDefault();
                var fd = new FormData();
                var tempIds = [];
                var $editor = $(this);

                $('.sample-image-upload-progress').show();
                $('.sample-image-upload-progress .image-upload-progress-bar').css('width', '0%');
                $('.sample-image-upload-progress .image-upload-progress-text').text('0%');

                for (var i = 0; i < imageFiles.length; i++) {
                    var file = imageFiles[i];
                    fd.append('upload_file[]', file, 'screenshot_' + Date.now() + '_' + i + '.png');
                    var tempId = 'temp_paste_' + Date.now() + '_' + i;
                    tempIds.push(tempId);
                    var blobUrl = URL.createObjectURL(file);

                    $editor.append(
                        '<div class="sample-note-image-box temp-sample-img-box" id="' + tempId + '" style="margin:6px 4px; display:inline-block; vertical-align:top; max-width:100%;">' +
                            '<img src="' + blobUrl + '" class="zoomable-sample-image" alt="Pasted Image" />' +
                        '</div>'
                    );
                }
                fd.append('_token', csrfToken);

                try {
                    var response = await $.ajax({
                        url: sampleImageUploadUrl,
                        type: 'POST',
                        data: fd,
                        contentType: false,
                        processData: false,
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function (evt) {
                                if (evt.lengthComputable) {
                                    var percent = Math.round((evt.loaded / evt.total) * 100);
                                    $('.sample-image-upload-progress .image-upload-progress-bar').css('width', percent + '%');
                                    $('.sample-image-upload-progress .image-upload-progress-text').text(percent + '%');
                                }
                            }, false);
                            return xhr;
                        }
                    });

                    if (response && response.data && Array.isArray(response.data)) {
                        for (var i = 0; i < response.data.length; i++) {
                            var item = response.data[i];
                            var permUrl = item.url || item.path || item;
                            if (tempIds[i] && $('#' + tempIds[i]).length) {
                                var $box = $('#' + tempIds[i]);
                                $box.removeClass('temp-sample-img-box');
                                $box.find('img').attr('src', permUrl);
                            }
                        }
                    }

                    $('.sample-image-upload-progress .image-upload-progress-bar').css('width', '100%');
                    $('.sample-image-upload-progress .image-upload-progress-text').text('100%');
                    setTimeout(function () {
                        $('.sample-image-upload-progress').hide();
                        $('.sample-image-upload-progress .image-upload-progress-bar').css('width', '0%');
                        $('.sample-image-upload-progress .image-upload-progress-text').text('0%');
                    }, 400);

                } catch (err) {
                    console.error('Paste upload failed', err);
                    $('.sample-image-upload-progress').hide();
                    $('.temp-sample-img-box').remove();
                    showSampleAlert('Failed to upload pasted image.', 'error');
                }
            }
        });

        // Drag & Drop image files onto editor
        $(document).on('dragover dragenter', '.sample-note-editor-wrapper .Editor-editor', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('drag-hover');
        });
        $(document).on('dragleave drop', '.sample-note-editor-wrapper .Editor-editor', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('drag-hover');
        });
        $(document).on('drop', '.sample-note-editor-wrapper .Editor-editor', function (e) {
            var dt = (e.originalEvent || e).dataTransfer;
            if (dt && dt.files && dt.files.length) {
                var input = document.getElementById('sample-note-file');
                if (input) {
                    input.files = dt.files;
                    $('#sample-note-file').trigger('change');
                }
            }
        });

        // =====================================
        // IMAGE PREVIEW MODAL ZOOM & PAN
        // =====================================
        var previewImages = [];
        var currentPreviewIndex = 0;
        var currentZoomScale = 1;
        var currentPanX = 0;
        var currentPanY = 0;
        var isImagePanning = false;
        var panStartX = 0;
        var panStartY = 0;

        function applyImageTransform(animate) {
            var $img = $('#previewImage');
            var $wrapper = $('#previewImageWrapper');
            if (!$img.length) return;

            if (animate === false) {
                $img.css('transition', 'none');
            } else {
                $img.css('transition', 'transform 0.15s ease-out');
            }

            $img.css('transform', 'translate(' + currentPanX + 'px, ' + currentPanY + 'px) scale(' + currentZoomScale + ')');
            $('#zoomLevelText').text(Math.round(currentZoomScale * 100) + '%');

            if (currentZoomScale > 1) {
                $wrapper.addClass('is-zoomed');
            } else {
                $wrapper.removeClass('is-zoomed is-panning');
            }
        }

        function resetImageZoom() {
            currentZoomScale = 1;
            currentPanX = 0;
            currentPanY = 0;
            isImagePanning = false;
            applyImageTransform(true);
        }

        function setZoomScale(newScale, animate) {
            currentZoomScale = Math.min(5, Math.max(1, newScale));
            if (currentZoomScale === 1) {
                currentPanX = 0;
                currentPanY = 0;
            }
            applyImageTransform(animate);
        }

        function showPreviewImage(index) {
            if (previewImages.length === 0 || index < 0 || index >= previewImages.length) return;
            currentPreviewIndex = index;
            resetImageZoom();
            $('#previewImage').attr('src', previewImages[currentPreviewIndex]);

            if (currentPreviewIndex === 0) {
                $('.image-prev-btn').prop('disabled', true).css({ opacity: '0.3', cursor: 'not-allowed' });
            } else {
                $('.image-prev-btn').prop('disabled', false).css({ opacity: '1', cursor: 'pointer' });
            }

            if (currentPreviewIndex === previewImages.length - 1) {
                $('.image-next-btn').prop('disabled', true).css({ opacity: '0.3', cursor: 'not-allowed' });
            } else {
                $('.image-next-btn').prop('disabled', false).css({ opacity: '1', cursor: 'pointer' });
            }
        }

        // Open preview when clicking any image in the editor or sample notes
        $(document).on('click', '.sample-note-editor-wrapper .Editor-editor img, .zoomable-sample-image', function (e) {
            e.preventDefault();
            e.stopPropagation();

            previewImages = [];
            var $allImages = $('.sample-note-editor-wrapper .Editor-editor img, .zoomable-sample-image');
            $allImages.each(function () {
                var src = $(this).attr('src');
                if (src && previewImages.indexOf(src) === -1) {
                    previewImages.push(src);
                }
            });

            var clickedSrc = $(this).attr('src');
            currentPreviewIndex = previewImages.indexOf(clickedSrc);
            if (currentPreviewIndex === -1) {
                currentPreviewIndex = 0;
                previewImages.unshift(clickedSrc);
            }

            $('#imagePreviewModal').css('display', 'flex');
            showPreviewImage(currentPreviewIndex);
        });

        // Zoom controls
        $(document).on('click', '#btnZoomIn, .image-zoom-in', function (e) {
            e.stopPropagation();
            setZoomScale(currentZoomScale + 0.3, true);
        });

        $(document).on('click', '#btnZoomOut, .image-zoom-out', function (e) {
            e.stopPropagation();
            setZoomScale(currentZoomScale - 0.3, true);
        });

        $(document).on('click', '#btnZoomReset, .image-zoom-reset', function (e) {
            e.stopPropagation();
            resetImageZoom();
        });

        // Double click to toggle zoom
        $(document).on('dblclick', '#previewImage, #previewImageWrapper', function (e) {
            e.stopPropagation();
            if (currentZoomScale > 1) {
                resetImageZoom();
            } else {
                setZoomScale(2, true);
            }
        });

        // Mouse wheel zoom
        $(document).on('wheel', '#imagePreviewModal', function (e) {
            if (!$('#imagePreviewModal').is(':visible')) return;
            e.preventDefault();
            var delta = e.originalEvent.deltaY;
            var zoomFactor = delta < 0 ? 0.2 : -0.2;
            setZoomScale(currentZoomScale + zoomFactor, false);
        });

        // Drag to Pan when zoomed
        $(document).on('mousedown', '#previewImageWrapper, #previewImage', function (e) {
            if (currentZoomScale <= 1 || e.button !== 0) return;
            e.preventDefault();
            e.stopPropagation();

            isImagePanning = true;
            panStartX = e.clientX - currentPanX;
            panStartY = e.clientY - currentPanY;
            $('#previewImageWrapper').addClass('is-panning');
        });

        $(document).on('mousemove', function (e) {
            if (!isImagePanning) return;
            e.preventDefault();
            currentPanX = e.clientX - panStartX;
            currentPanY = e.clientY - panStartY;
            applyImageTransform(false);
        });

        $(document).on('mouseup mouseleave', function () {
            if (isImagePanning) {
                isImagePanning = false;
                $('#previewImageWrapper').removeClass('is-panning');
            }
        });

        // Next / Prev navigation
        $(document).on('click', '.image-next-btn', function (e) {
            e.stopPropagation();
            showPreviewImage(currentPreviewIndex + 1);
        });

        $(document).on('click', '.image-prev-btn', function (e) {
            e.stopPropagation();
            showPreviewImage(currentPreviewIndex - 1);
        });

        // Close modal
        $(document).on('click', '.image-preview-close', function (e) {
            e.stopPropagation();
            resetImageZoom();
            $('#imagePreviewModal').hide();
        });

        $(document).on('click', '#imagePreviewModal', function (e) {
            if (e.target.id === 'imagePreviewModal' || e.target.id === 'previewImageWrapper') {
                resetImageZoom();
                $('#imagePreviewModal').hide();
            }
        });

        $(document).on('keydown', function (e) {
            if (!$('#imagePreviewModal').is(':visible')) return;
            if (e.key === 'Escape') {
                resetImageZoom();
                $('#imagePreviewModal').hide();
            } else if (e.key === 'ArrowRight') {
                showPreviewImage(currentPreviewIndex + 1);
            } else if (e.key === 'ArrowLeft') {
                showPreviewImage(currentPreviewIndex - 1);
            } else if (e.key === '+' || e.key === '=') {
                setZoomScale(currentZoomScale + 0.3, true);
            } else if (e.key === '-') {
                setZoomScale(currentZoomScale - 0.3, true);
            } else if (e.key === '0') {
                resetImageZoom();
            }
        });

        $(document).ready(function () {
            var urlParams = new URLSearchParams(window.location.search);
            var tabParam = urlParams.get('tab');
            if (tabParam && tabParam.toLowerCase() === 'sample') {
                $('#Samples_SwatchesTab').tab('show');
            }
        });
    })();

</script>

@endsection
