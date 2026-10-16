@extends('layouts.app', ['activePage' => 'people', 'titlePage' => __('People')])

@section('content')
<style>
    .profile-pic img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    /* #searchbox{
        border: 2px solid #ffffff;
        height: 35px;
        width: 100%;
        border-radius: 30px;
        padding: 0px 5px;
        background-color: #ffffff1a;
        margin-top: 10px;
        color: #ffffff;
    }
    #searchbox::placeholder {
        color: #aaaaaa;
        font-size: 14px;
    }
    #searchbox:focus {
        outline: 0px;
    }
    #searchbox:-ms-input-placeholder {
        color: #aaaaaa;
    }
    #searchbox::-ms-input-placeholder {
        color: #aaaaaa;
    } */
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
    .h4.mb-0.text-gray.text-uppercase.d-none.d-lg-inline-block.page-title{
        display: none !important;
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

    #new_organization_id{
        height: 70px !important;
    }

    #new_organization_id + .select2.select2-container{
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
        right: -54px;
    }
    .contect-position {
        position: relative;
        top: -33px;
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
        right: 52px;
    }
    .btn-top {
        position: relative;
        top: 11px;
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
    .card{
        border: none;
        border-radius: 0rem;
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
    .selectbox-div{
        border: 1px solid #B3B3B3;
        border-radius: 1rem;
        padding: 0%;
        padding-left: 6%;
    }
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
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
    /* .table-responsive {
        display: none;
    } */
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
        margin-left: unset !important;
        /* border: 1px solid var(--color-azure-84-2, #D1D5DB); */
    }
    .mobile_border_unset {
        border-bottom: unset !important;
    }
    .mobile_main_buttons {
        /* margin: 5px 0px; */
        padding: 5px 0px;
        border-radius: 6px;
        margin-left: unset !important;
        margin-right: unset !important;
    }
    .mobile_main_div_1 {
        padding: 0px 20px;
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
        color: #6c757d;
        margin-bottom: 4px;
    }
    .org-body strong {
        font-size: 15px;
        font-weight: 600;
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
}

/* =========================================================
   PEOPLE TABLE - MOBILE CARD VIEW
   ========================================================= */

@media (max-width: 767.98px) {

    /* -----------------------------------------------------
       TABLE CONTAINER
       ----------------------------------------------------- */

    #alphabet-filter {
        display: none;
    }

    #people_table {
        width: 100% !important;
        margin: 0 !important;

        border: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 14px !important;

        display: table !important;
    }

    /* -----------------------------------------------------
       HIDE TABLE HEADER
       ----------------------------------------------------- */

    #people_table thead {
        display: none !important;
    }

    #people_table tbody {
        display: block !important;
        width: 100% !important;
    }


    /* =====================================================
       EACH TR = CARD
       ===================================================== */

    #people_table tbody tr {
        position: relative !important;

        display: grid !important;

        grid-template-columns: 1fr 1fr !important;

        grid-template-areas:
            "name name"
            "title lead-source"
            "organization organization"
            "email email"
            "work personal"
            "street zip" !important;

        width: 100% !important;

        margin: 0 0 14px 0 !important;
        padding: 0 !important;

        background: #ffffff !important;

        border: 1px solid #e4e7eb !important;
        border-radius: 14px !important;

        overflow: hidden !important;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06) !important;

        color: #717070 !important;
    }


    /* =====================================================
       COMMON TD
       ===================================================== */

    #people_table tbody tr td {
        position: relative !important;

        min-width: 0 !important;

        display: flex !important;
        align-items: flex-start !important;

        border: 0 !important;

        background: transparent !important;

        color: #999 !important;

        font-size: 13px !important;
        line-height: 1.35 !important;

        white-space: normal !important;
        word-break: break-word !important;
    }


    /* =====================================================
       1ST ROW
       FIRST NAME + LAST NAME
       ===================================================== */

    /* =====================================================
    1ST ROW - FIRST NAME + LAST NAME
    ===================================================== */

    #people_table tbody tr td.first-name {
        grid-area: name !important;

        display: inline-flex !important;
        width: auto !important;

        padding: 15px 3px 11px 14px !important;

        font-size: 15px !important;
        font-weight: 700 !important;

        color: #252525 !important;

        align-items: center !important;

        border-bottom: 1px solid #e5e7eb !important;
    }


    /* Last name comes immediately after first name */

    #people_table tbody tr td.last-name {
        grid-area: name !important;

        display: inline-flex !important;
        width: auto !important;

        padding: 15px 14px 11px 15px !important;

        font-size: 15px !important;
        font-weight: 700 !important;

        color: #252525 !important;

        align-items: center !important;

        border-bottom: 1px solid #e5e7eb !important;
    }


    /* -----------------------------------------------------
       BORDER BELOW FIRST ROW
       ----------------------------------------------------- */

    #people_table tbody tr td.first-name,
    #people_table tbody tr td.last-name {
        border-bottom: unset !important;
    }


    /* =====================================================
       2ND ROW
       TITLE + LEAD SOURCE
       ===================================================== */

    #people_table tbody tr td.title {
        grid-area: title !important;

        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;

        padding: 10px 7px 11px 14px !important;

        font-size: 13px !important;
        color: #999 !important;
        display: none !important;
    }

    #people_table tbody tr td.title::before {
        /* content: "Title" !important; */

        display: block !important;

        margin-bottom: 3px !important;

        font-size: 10px !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
        letter-spacing: 0.3px !important;

        color: #000000 !important;
    }


    #people_table tbody tr td.lead-source {
        grid-area: lead-source !important;

        display: flex !important;
        flex-direction: column !important;
        align-items: flex-end !important;

        padding: 0px 14px 11px 7px !important;

        font-size: 13px !important;
        color: #999 !important;

        text-align: right !important;
        top: -10px;
    }

    #people_table tbody tr td.lead-source::before {
        /* content: "Lead Source" !important; */

        display: block !important;

        margin-bottom: 3px !important;

        font-size: 10px !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
        letter-spacing: 0.3px !important;

        color: #000000 !important;
    }


    /* =====================================================
       3RD ROW
       ORGANIZATION
       ===================================================== */

    #people_table tbody tr td.organization-id {
        grid-area: organization !important;

        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;

        padding: 11px 14px 10px 14px !important;

        border-top: 1px solid #f2f2f2 !important;

        font-size: 13px !important;
        font-weight: 500 !important;

        color: #999 !important;
    }

    #people_table tbody tr td.organization-id::before {
        content: "Organization" !important;

        display: block !important;

        margin-bottom: 4px !important;

        font-size: 10px !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
        letter-spacing: 0.3px !important;

        color: #000000 !important;
    }


    /* =====================================================
       4TH ROW
       EMAIL
       ===================================================== */

    #people_table tbody tr td.email {
        grid-area: email !important;

        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;

        margin: 3px 10px 9px 10px !important;

        padding: 10px 12px !important;

        background: #f4f5f6 !important;

        border-radius: 8px !important;

        font-size: 13px !important;

        color: #555 !important;

        overflow: hidden !important;
    }

    /* -----------------------------------------------------
       EMAIL ICON
       ----------------------------------------------------- */

    #people_table tbody tr td.email::before {
        content: "✉" !important;

        flex: 0 0 auto !important;

        margin-right: 8px !important;

        font-size: 15px !important;

        color: #777 !important;
    }


    /* =====================================================
       5TH ROW
       WORK NO
       ===================================================== */

    #people_table tbody tr td.phone-no:nth-child(6) {
        grid-area: work !important;

        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;

        padding: 8px 7px 12px 14px !important;

        font-size: 13px !important;
        color: #999 !important;
    }

    #people_table tbody tr td.phone-no:nth-child(6)::before {
        content: "Work No" !important;

        display: block !important;

        margin-bottom: 3px !important;

        font-size: 10px !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
        letter-spacing: 0.3px !important;

        color: #000000 !important;
    }


    /* =====================================================
       5TH ROW
       PERSONAL NO
       ===================================================== */

    #people_table tbody tr td.phone-no:nth-child(7) {
        grid-area: personal !important;

        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;

        padding: 8px 14px 12px 7px !important;

        font-size: 13px !important;
        color: #999 !important;
    }

    #people_table tbody tr td.phone-no:nth-child(7)::before {
        content: "Personal No" !important;

        display: block !important;

        margin-bottom: 3px !important;

        font-size: 10px !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
        letter-spacing: 0.3px !important;

        color: #000000 !important;
    }


    /* =====================================================
       6TH ROW
       SHIPPING STREET
       ===================================================== */

    #people_table tbody tr td.shipping-street {
        grid-area: street !important;

        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;

        padding: 8px 7px 14px 14px !important;

        font-size: 13px !important;
        color: #999 !important;
    }

    #people_table tbody tr td.shipping-street::before {
        content: "Shipping Street" !important;

        display: block !important;

        margin-bottom: 3px !important;

        font-size: 10px !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
        letter-spacing: 0.3px !important;

        color: #000000 !important;
    }


    /* =====================================================
       6TH ROW
       SHIPPING ZIP
       ===================================================== */

    #people_table tbody tr td.shipping-zip {
        grid-area: zip !important;

        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;

        padding: 8px 14px 14px 7px !important;

        font-size: 13px !important;
        color: #999 !important;
    }

    #people_table tbody tr td.shipping-zip::before {
        content: "Shipping ZIP" !important;

        display: block !important;

        margin-bottom: 3px !important;

        font-size: 10px !important;
        font-weight: 600 !important;

        text-transform: uppercase !important;
        letter-spacing: 0.3px !important;

        color: #000000 !important;
    }


    /* =====================================================
       HIDE OTHER FIELDS ON MOBILE
       ===================================================== */

    #people_table tbody tr td.shipping-city,
    #people_table tbody tr td.shipping-state,
    #people_table tbody tr td.shipping-country,
    #people_table tbody tr td.created-at,
    #people_table tbody tr td.updated-at,
    #people_table tbody tr td.user-id {
        display: none !important;
    }


    /* =====================================================
       WHOLE CARD CLICKABLE
       ===================================================== */

    #people_table tbody tr td.first-name {
        position: static !important;
    }

    #people_table tbody tr td.first-name .info {
        position: absolute !important;

        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;

        z-index: 999 !important;

        display: block !important;

        width: 100% !important;
        height: 100% !important;

        font-size: 0 !important;

        color: transparent !important;

        text-decoration: none !important;

        cursor: pointer !important;
    }


    /* =====================================================
       KEEP CARD TEXT ABOVE NORMAL LAYERS
       ===================================================== */

    #people_table tbody tr td {
        z-index: 1 !important;
    }

    #people_table tbody tr td.first-name .info {
        z-index: 999 !important;
    }


    /* =====================================================
       FIRST NAME LINK - NO DEFAULT STYLING
       ===================================================== */

    #people_table tbody tr td.first-name .info:hover,
    #people_table tbody tr td.first-name .info:focus,
    #people_table tbody tr td.first-name .info:active {
        text-decoration: none !important;
        color: transparent !important;
    }


    /* =====================================================
       CARD TOUCH EFFECT
       ===================================================== */

    #people_table tbody tr {
        transition:
            transform 0.15s ease,
            box-shadow 0.15s ease !important;
    }

    #people_table tbody tr:active {
        transform: scale(0.99) !important;
    }
    .container-fluid {
        padding-right: 5px;
        padding-left: 5px;
    }
    /* Empty fields -> show "-" */
    #people_table tbody tr td.organization-id:empty::after,
    #people_table tbody tr td.phone-no:empty::after,
    #people_table tbody tr td.shipping-street:empty::after,
    #people_table tbody tr td.shipping-zip:empty::after {
        content: "-" !important;
        color: #999 !important;
        font-size: 13px !important;
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
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    @section('order-header')
        <span>PEOPLES</span>
    @endsection

     @section('back-btn-Mobile')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">< BACK TO HOME</a>
    @endsection

    <div class="col-md-12 back_home_mobile">
        <strong>
            @yield('back-btn-Mobile')
        </strong>
    </div>

    <div class="col-md-12 mt-4 mobile_per_row">
        {{-- <div class="row">
            <div class="col-md-2 ml-auto text-right">
                @can('create people')
                    <button class="btn-green-filled" style="outline: unset;width:80%;margin-right: 1.2rem;" id="add_people" title="Add New People">
                        ADD PEOPLE&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                @endcan
            </div>
        </div> --}}
        {{-- <div class="card" style="display: none">
            <div class="row">
                <div class="col-md-4" ></div>
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    <input type="text" id="searchbox" placeholder="People Search" style="width: 90%;margin-right: 20px; border-color: #787878; border-radius: 4px; position: relative; top: -5px; color: #787878;">
                    <div class="row btn-position">
                        <div class="col-md-3 btns">
                            @can('add organizations')
                                <div class="button">
                                    <span>
                                        <a href="#" id="add_people"  style="color:#ffffff; position: relative; top: -1px; left: 20px;">
                                            <i class="fas fa-solid fa-plus fa-fade" style=" font-size: 11px;">   People</i>
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
                                        <a  style="color:#ffffff; position: relative; top: -1px; left: 22px;" href="#" id="export_csv" data-href="{{ route('people.export_csv') }}" onclick="exportTasks(event.target);">
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

    {{-- <div class="col-md-12 btn-top" style="display: none">
        <div class="row ">
            <div class="col-md-6"></div>
            <div class="col-md-6 btns-right-position btn_set">
                <div class="row div_align">
                    <div class="col-md-3 div_display"></div>
                    <div class="col-md-3 btns-padding">
                        @can('create people')
                            <button class="btns-text btns-style btns-card" style="outline: unset;" id="add_people" title="Add New People">
                                Add People
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3 btns-padding">
                        @can('export people')
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" id="export_csv" data-href="{{ route('people.export_csv') }}" onclick="exportTasks(event.target);" title="Export CSV People">
                                CSV Export
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3 btns-padding">
                        <button class="btns-text btns-style btns-card" style="outline: unset;"  href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                            Table Layout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-md-12 mobile_main_div_1">
        <div class="card mobile_card_unset">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <h1 class="float-left header-title">People</h1>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12 justify-content-center header-icons">
                                <div style="width: 100%;justify-content: flex-end;display: flex">
                                    <input type="text" id="searchbox" placeholder="Organization Search" style="width: 50%;margin-right: 20px">
                                    @can('export people')
                                        <span>
                                            <a class="btn btn-round" href="#" id="export_csv" data-href="{{ route('people.export_csv') }}" onclick="exportTasks(event.target);">
                                                <i class="fas fa-file-csv"></i>
                                            </a>
                                            <p>Export</p>
                                        </span>
                                    @endcan

                                    <!-- @can('create people')
                                        <span>
                                            <button type="button" class="btn btn-round" id="add_people">
                                                <i class="fas fa-user-plus"></i>
                                            </button>
                                            <p>Add People</p>
                                        </span>
                                    @endcan -->

                                    @can('add people')
                                        <span>
                                            <button type="button" class="btn btn-round" id="add_people">
                                                <i class="fas fa-user-plus"></i>
                                            </button>
                                            <p>Add People</p>
                                        </span>
                                    @endcan

                                    <span>
                                        <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                            <i class="fas fa-wrench"></i>
                                        </a>
                                        <p>Table Layout</p>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="card-body" style="padding: 0rem;">
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
                                <input class="searchbox-layout"  type="text" id="searchbox" placeholder="Search People">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ml-auto mr-3  mobile_main_buttons">
                        <table style="width: 100%" class="btn-inside-table">
                            <tr>
                                <td class="mobile_table_layout_btn" style="width: 15%"></td>
                                <td class="mobile_csv_btn">
                                    @can('export people')
                                        <button class="btn-grey-text mobile_csv"  title="Export CSV" id="export_csv" data-href="{{ route('people.export_csv') }}" onclick="exportTasks(event.target);">
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
                                    @can('create people')
                                        <button class="btn-green-filled mobile_csv" style="outline: unset;width:80%;margin-right: 1.2rem;" id="add_people" title="Add New People">
                                            ADD PEOPLE&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        </table>
                    </div>
                    {{-- <div class="col-lg-3 ml-auto row mr-1 align-items-center">
                        <div class="col-lg-6">
                            @can('export people')
                                <button class="btn-grey-text"  title="Export CSV" id="export_csv" data-href="{{ route('people.export_csv') }}" onclick="exportTasks(event.target);">
                                    CSV Export
                                </button>
                            @endcan
                        </div>
                        <div class="col-lg-6">
                            @can('view team store orders')
                                <button class="btn-grey-filled" data-toggle="modal" data-target="#layout_modal">
                                    Table Layout
                                </button>
                            @endcan
                        </div>
                    </div> --}}
                </div>
                <div class="col-md-12 mt-3 mobile_table_padding">
                    <div class="table-responsive">
                        <div id="alphabet-filter"></div>
                        <table class="table align-items-center cell-border table-responsive" id="people_table">
                            <thead style="color:white" class="header-style">
                                <th scope="col" class="first-name">First Name</th>
                                <th scope="col" class="last-name">Last Name</th>
                                <th scope="col" class="title">Title</th>
                                <th scope="col" class="organization-id">Organization Name</th>
                                <th scope="col" class="lead-source">Lead Source</th>
                                <th scope="col" class="phone-no">Work No</th>
                                <th scope="col" class="phone-no">Personal No</th>
                                <th scope="col" class="email">Email</th>
                                <th scope="col" class="user-id">Assign To</th>
                                <th scope="col" class="shipping-street">Shipping Street</th>
                                <th scope="col" class="shipping-city">Shipping City</th>
                                <th scope="col" class="shipping-state">Shipping State</th>
                                <th scope="col" class="shipping-zip">Shipping Zip</th>
                                <th scope="col" class="shipping-country">Shipping Country</th>
                                <th scope="col" class="created-at">Created At</th>
                                <th scope="col" class="updated-at">Updated At</th>
                            </thead>

                            <tbody id="people_table_body">
                                @foreach ($peoples as $people)
                                <tr style="color: #717070" class="info" data-value="{{$people->id}}">
                                    <td class="first-name"><a href="#" style="rgba(50, 50, 50, 1) !important" class="info" data-value="{{$people->id}}">{{$people->first_name}}</a></td>
                                    <td class="last-name">{{$people->last_name}}</td>
                                    <td class="title">{{$people->title}}</td>
                                    {{-- <td class="organization-id"><a href="#" class="view-organization" data-value="{{$people->organization_id}}">{{$people->organization_name}}</a></td> --}}
                                    <td class="organization-id">
                                        @foreach($people->contactOrganizations as $contactOrganization)
                                            @foreach($contactOrganization->organizations as $organization)
                                                {{$organization->organization_name.","}}
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td class="lead-source">{{$people->leadSourceDetails ? $people->leadSourceDetails->lead_source_name : ''}}</td>
                                    <td class="phone-no">{{$people->phone_no}}</td>
                                    <td class="phone-no">{{$people->personal_phone_no}}</td>
                                    <td class="email">{{$people->email}}</td>
                                    <td class="user-id">{{$people->name}}</td>
                                    <td class="shipping-street">{{$people->shipping_street}}</td>
                                    <td class="shipping-city">{{$people->shipping_city}}</td>
                                    <td class="shipping-state">{{$people->shipping_state}}</td>
                                    <td class="shipping-zip">{{$people->shipping_zip}}</td>
                                    <td class="shipping-country">{{$people->shipping_country}}</td>
                                    <td class="created-at">{{$people->created_at->format('m-d-Y')}}</td>
                                    <td class="updated-at">{{$people->updated_at->format('m-d-Y')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <div style="float: right" class="mobile_pagination_float">
                        {{ $peoples->onEachSide(5)->withQueryString()->links('layouts.paginationlinks') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- People Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rmwidth001">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">People Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <input type="hidden" id="layout_id" name="layout_id" value="{{$peopleLayout['id'] ?? ''}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="first_name" name="first_name" @isset($peopleLayout) @if ($peopleLayout['first_name'] == 1) checked @endif @endisset title="First Name" />
                                <label class="custom-control-label" for="first_name">First Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="last_name" name="last_name" @isset($peopleLayout) @if ($peopleLayout['last_name'] == 1) checked @endif @endisset title="Last Name" />
                                <label class="custom-control-label" for="last_name">Last Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="title" name="title" @isset($peopleLayout) @if ($peopleLayout['title'] == 1) checked @endif @endisset title="Title" />
                                <label class="custom-control-label" for="title">Title</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="organization_id" name="organization_id" @isset($peopleLayout) @if ($peopleLayout['organization_id'] == 1) checked @endif @endisset title="Organization Name" />
                                <label class="custom-control-label" for="organization_id">Organization Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="lead_source" name="lead_source" @isset($peopleLayout) @if ($peopleLayout['lead_source'] == 1) checked @endif @endisset title="Lead Source" />
                                <label class="custom-control-label" for="lead_source">Lead Source</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="phone_no" name="phone_no" @isset($peopleLayout) @if ($peopleLayout['phone_no'] == 1) checked @endif @endisset title="Mobile Phone" />
                                <label class="custom-control-label" for="phone_no">Work No</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="personal_phone_no" name="personal_phone_no" @isset($peopleLayout) @if ($peopleLayout['personal_phone_no'] == 1) checked @endif @endisset title="Mobile Phone" />
                                <label class="custom-control-label" for="personal_phone_no">Personal No</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="email" name="email" @isset($peopleLayout) @if ($peopleLayout['email'] == 1) checked @endif @endisset title="Email" />
                                <label class="custom-control-label" for="email">Email</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="user_id" name="user_id" @isset($peopleLayout) @if ($peopleLayout['user'] == 1) checked @endif @endisset title="Assign To" />
                                <label class="custom-control-label" for="user_id">Assign To</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="shipping_street" name="shipping_street" @isset($peopleLayout) @if ($peopleLayout['shipping_street'] == 1) checked @endif @endisset title="Shipping Street" />
                                <label class="custom-control-label" for="shipping_street">Shipping Street</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="shipping_city" name="shipping_city" @isset($peopleLayout) @if ($peopleLayout['shipping_city'] == 1) checked @endif @endisset title="Shipping City" />
                                <label class="custom-control-label" for="shipping_city">Shipping City</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="shipping_state" name="shipping_state" @isset($peopleLayout) @if ($peopleLayout['shipping_state'] == 1) checked @endif @endisset title="Shipping State" />
                                <label class="custom-control-label" for="shipping_state">Shipping State</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="shipping_zip" name="shipping_zip" @isset($peopleLayout) @if ($peopleLayout['shipping_zip'] == 1) checked @endif @endisset title="Shipping Zip" />
                                <label class="custom-control-label" for="shipping_zip">Shipping Zip</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="shipping_country" name="shipping_country" @isset($peopleLayout) @if ($peopleLayout['shipping_country'] == 1) checked @endif @endisset title="Shipping Country" />
                                <label class="custom-control-label" for="shipping_country">Shipping Country</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="created_at" name="created_at" @isset($peopleLayout) @if ($peopleLayout['created'] == 1) checked @endif @endisset title="Created At" />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" @isset($peopleLayout) @if ($peopleLayout['updated'] == 1) checked @endif @endisset title="Updated At" />
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

@can('create people')
    @include('pages.contacts.people.people_create_modal')
    @include('pages.contacts.modals.organization_create_modal')
@endcan

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

          var rows = document.querySelectorAll('#people_table tbody tr');

          rows.forEach(function(row) {
            var organizationNameCell = row.querySelector('.first-name');
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
    var searchIdx1 = '';
    var searchIdx2 = '';

    $(document).ready(function() {

        if(getUrlParameter('org')){
            $('#searchbox').val(getUrlParameter('org'));
        }

        $('.select2-people-modal').select2({
            dropdownParent: $('#people_create_modal')
        });

        // People Table Layout
        tableLayout();

        // change columns
        var peopleTable = $('#people_table').DataTable({
            colReorder: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 50,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search'
            },
            "columnDefs": [{
                "searchable": false,
                "targets": ["title", "lead-source", "phone-no", "email", "user-id", "shipping-street", "shipping-city", "shipping-state", "shipping-zip", "shipping-country", "created-at", "updated-at"]
            }],
            "paging":   false,
            "info":     false,
            searching: false,
        });

        searchIndex();

        // Alphabet Search
        // var _alphabetSearch = '';

        // $.fn.dataTable.ext.search.push( function (settings, searchData) {

        //     if ( ! _alphabetSearch ) {
        //         return true;
        //     }

        //     if ( searchData[searchIdx1].charAt(0) === _alphabetSearch || searchData[searchIdx2].charAt(0) === _alphabetSearch ) {
        //         return true;
        //     }

        //     return false;
        // });

        // var alphabet = $('<div class="alphabet"/>').append( '' );

        // $('<span class="clear active"/>').data( 'letter', '' ).html( 'All' ).appendTo( alphabet );

        // for ( var i=0 ; i<26 ; i++ ) {
        //     var letter = String.fromCharCode( 65 + i );

        //     $('<span/>').data( 'letter', letter ).html( letter ).appendTo( alphabet );
        // }

        // alphabet.insertBefore( peopleTable.table().container() );

        // alphabet.on('click', 'span', function () {
        //     alphabet.find( '.active' ).removeClass( 'active' );
        //     $(this).addClass( 'active' );

        //     _alphabetSearch = $(this).data('letter');
        //     peopleTable.draw(_alphabetSearch);
        // });

        // peopleTable.columns().search('').draw();

        // save column order when move
        peopleTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_people_table_/people");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( peopleTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'People';
            var interface_id = 1;
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
            var columnStr = localStorage.getItem("DataTables_people_table_/people");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'People';
            var interface_id = 1;
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
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        } else {
            // refresh column order according to user
            var interfaceId = 1;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    console.log(data.column_order);
                    var columnStr = localStorage.getItem("DataTables_people_table_/people");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_fabric_table_/fabrics', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        // Seach by Organization Name
        $("#searchbox").on('focusout', function() {
            setUrlParameter($(this).val());
        });

        $("#searchbox").on('keypress', function(event) {
		    if (event.keyCode == 13) {
                setUrlParameter($(this).val());
            }
        });

        //edit
        $("body").on("click", ".edit", function(){
            var peopleId = $(this).data('value');
            window.location.replace("people/edit/"+peopleId);
        });

        //info
        $("body").on("click", ".info", function(){
            var peopleId = $(this).data('value');
            window.location.replace("people/info/"+peopleId);
        });

        // View Organization
        $("body").on("click", ".view-organization", function(){
            var organizationId = $(this).data('value');
            window.location.replace('organizations/info/'+organizationId);
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

        $('#add_people').click(function(){
var errorMessageSpan = document.getElementById('email-error-message');
            if (errorMessageSpan) {
            errorMessageSpan.parentNode.removeChild(errorMessageSpan);
            }
            $('#people_create_modal').modal('show');
        });

        $('#first_name').on('change', function(){ tableLayout(); });
        $('#last_name').on('change', function(){ tableLayout(); });
        $('#title').on('change', function(){ tableLayout(); });
        $('#organization_id').on('change', function(){ tableLayout(); });
        $('#lead_source').on('change', function(){ tableLayout(); });
        $('#phone_no').on('change', function(){ tableLayout(); });
        $('#personal_phone_no').on('change', function(){ tableLayout(); });
        $('#email').on('change', function(){ tableLayout(); });
        $('#user_id').on('change', function(){ tableLayout(); });
        $('#shipping_street').on('change', function(){ tableLayout(); });
        $('#shipping_city').on('change', function(){ tableLayout(); });
        $('#shipping_state').on('change', function(){ tableLayout(); });
        $('#shipping_zip').on('change', function(){ tableLayout(); });
        $('#shipping_country').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var title = $('#title').val();
        var organization_id = $('#organization_id').val();
        var lead_source = $('#lead_source').val();
        var phone_no = $('#phone_no').val();
        var personal_phone_no = $('#personal_phone_no').val();
        var email = $('#email').val();
        var user_id = $('#user_id').val();
        var shipping_street = $('#shipping_street').val();
        var shipping_city = $('#shipping_city').val();
        var shipping_state = $('#shipping_state').val();
        var shipping_zip = $('#shipping_zip').val();
        var shipping_country = $('#shipping_country').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#first_name').is(':checked')) {
            $('.first-name').css('display', 'table-cell');
            first_name = 1;
        } else {
            $('.first-name').css('display', 'none');
            first_name = 0;
        }

        if($('#last_name').is(':checked')) {
            $('.last-name').css('display', 'table-cell');
            last_name = 1;
        } else {
            $('.last-name').css('display', 'none');
            last_name = 0;
        }

        if($('#title').is(':checked')) {
            $('.title').css('display', 'table-cell');
            title = 1;
        } else {
            $('.title').css('display', 'none');
            title = 0;
        }

        if($('#organization_id').is(':checked')) {
            $('.organization-id').css('display', 'table-cell');
            organization_id = 1;
        } else {
            $('.organization-id').css('display', 'none');
            organization_id = 0;
        }

        if($('#lead_source').is(':checked')) {
            $('.lead-source').css('display', 'table-cell');
            lead_source = 1;
        } else {
            $('.lead-source').css('display', 'none');
            lead_source = 0;
        }

        if($('#phone_no').is(':checked')) {
            $('.phone-no').css('display', 'table-cell');
            phone_no = 1;
        } else {
            $('.phone-no').css('display', 'none');
            phone_no = 0;
        }

        if($('#personal_phone_no').is(':checked')) {
            $('.personal-phone-no').css('display', 'table-cell');
            personal_phone_no = 1;
        } else {
            $('.personal-phone-no').css('display', 'none');
            personal_phone_no = 0;
        }

        if($('#email').is(':checked')) {
            $('.email').css('display', 'table-cell');
            email = 1;
        } else {
            $('.email').css('display', 'none');
            email = 0;
        }

        if($('#user_id').is(':checked')) {
            $('.user-id').css('display', 'table-cell');
            user_id = 1;
        } else {
            $('.user-id').css('display', 'none');
            user_id = 0;
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

        if($('#shipping_zip').is(':checked')) {
            $('.shipping-zip').css('display', 'table-cell');
            shipping_zip = 1;
        } else {
            $('.shipping-zip').css('display', 'none');
            shipping_zip = 0;
        }

        if($('#shipping_country').is(':checked')) {
            $('.shipping-country').css('display', 'table-cell');
            shipping_country = 1;
        } else {
            $('.shipping-country').css('display', 'none');
            shipping_country = 0;
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
            url: "people/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'first_name':first_name, 'last_name':last_name, 'organization_id':organization_id, 'lead_source':lead_source, 'phone_no':phone_no, 'personal_phone_no':personal_phone_no, 'email':email,
                'title':title, 'user_id':user_id, 'shipping_street':shipping_street, 'shipping_city':shipping_city,
                'shipping_state':shipping_state, 'shipping_zip':shipping_zip, 'shipping_country':shipping_country, 'created_at':created_at,
                'updated_at':updated_at, '_token':'{{csrf_token()}}'
            },
            success: function (data) {
                console.log(data);
                if(data == '"Saved"') {
                    window.location.reload(true);
                }
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    function searchIndex(){
        $('#people_table thead th').each(function(){
            if($(this).text() == 'First Name') {
                searchIdx1 = $('#people_table thead th').index(this);
                console.log(searchIdx1);
            }
            if($(this).text() == 'Last Name') {
                searchIdx2 = $('#people_table thead th').index(this);
                console.log(searchIdx2);
            }
        });
    }

    function setUrlParameter(orgTxt){
        var params = {'org':orgTxt};
        var new_url = '{{ route("people")}}?' + jQuery.param(params);
        window.history.pushState('page2', 'Title', new_url);
        location.reload();
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
    };

    $('#layout_modal').on('hidden.bs.modal', function () {
        $(".se-pre-con").fadeIn('slow');
        window.location.reload(true);
    });

    // Export CSV
    function exportTasks(_this) {
        let _url = $(_this).data('href');
        window.location.href = _url;
    }

    let header = "PEOPLE";
        document.getElementById("header").innerHTML = header;
</script>

@endsection
