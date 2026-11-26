@extends('layouts.app', ['activePage' => 'master_organizations', 'titlePage' => ('__Organizations')])

@section('content')
<div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection
    @section('order-header')
        ORGANIZATIONS
    @endsection
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
        table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
            bottom: 0.6rem !important;
        }
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            right: .7rem !important;
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
        .searchbox-layout{
            margin-top: 0 !important;
            width: 100% !important;
            height: 29px;
            font-size: .7rem;
            color: grey !important;
            border: unset;
            outline: unset;
        }
        .table-responsive .table tbody td , .table-responsive .table tbody td a {
            padding: 0.2rem 1rem !important;
            font-size: .9rem !important;
            color: rgba(22, 22, 23, 1) !important;
        }
        .table-responsive .select2.select2-container{
            min-width: 9rem;
        }
        
        @media (max-width: 767.98px) {
            #master_organization_table,
            #master_organization_table tbody { display: block !important; width: 100% !important; }
            #master_organization_table thead { display: none !important; }

            /* Card */
            #master_organization_table tbody tr {
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                grid-template-areas:
                    "name name"
                    "rep rep"
                    "size colors"
                    "lead sport"
                    "web web";
                column-gap: 16px;
                row-gap: 12px;
                background: #fff;
                border: 1px solid #e3e3e3;
                border-radius: 20px;
                box-shadow: 0 1px 3px rgba(0,0,0,.06);
                padding: 16px;
                margin-bottom: 16px;
            }
            #master_organization_table tbody tr td {
                display: block !important;
                padding: 0 !important;
                border: 0 !important;
                min-width: 0;
                font-size: .95rem !important;
                text-align: left !important;
            }

            /* Hide fields not in the design */
            #master_organization_table tbody tr td.email,
            #master_organization_table tbody tr td.shipping-street,
            #master_organization_table tbody tr td.shipping-city,
            #master_organization_table tbody tr td.shipping-state,
            #master_organization_table tbody tr td.shipping-postal-code,
            #master_organization_table tbody tr td.shipping-country,
            #master_organization_table tbody tr td.sales-tax,
            #master_organization_table tbody tr td.sales-tax-active,
            #master_organization_table tbody tr td.created-at,
            #master_organization_table tbody tr td.updated-at { display: none !important; }

            /* Areas */
            #master_organization_table tbody tr td.organization-name { grid-area: name; font-size: 1.05rem !important; }
            #master_organization_table tbody tr td.user-id { grid-area: rep; color: #777 !important; margin-top: -8px; }
            #master_organization_table tbody tr td.size-of-club { grid-area: size; }
            #master_organization_table tbody tr td.colors { grid-area: colors; }
            #master_organization_table tbody tr td.lead-source { grid-area: lead; }
            #master_organization_table tbody tr td.sport { grid-area: sport; }
            #master_organization_table tbody tr td.website { grid-area: web; }

            /* Labels */
            #master_organization_table tbody tr td.size-of-club::before,
            #master_organization_table tbody tr td.colors::before,
            #master_organization_table tbody tr td.lead-source::before,
            #master_organization_table tbody tr td.sport::before {
                display: block;
                color: #8a8a8a;
                font-size: .85rem;
                margin-bottom: 6px;
            }
            #master_organization_table tbody tr td.size-of-club::before { content: "Size of Club"; }
            #master_organization_table tbody tr td.colors::before { content: "Primary Colors"; }
            #master_organization_table tbody tr td.lead-source::before { content: "Lead Source"; }
            #master_organization_table tbody tr td.sport::before { content: "Sport"; }

            /* Empty values show "-" */
            #master_organization_table tbody tr td.size-of-club:empty::after,
            #master_organization_table tbody tr td.colors:empty::after { content: "-"; }

            /* Size of club pill */
            #master_organization_table tbody tr td.size-of-club { color: #222 !important; }

            /* Selects */
            #master_organization_table tbody tr td .select2.select2-container {
                width: 100% !important;
                min-width: 0 !important;
            }
            #master_organization_table tbody tr td .select2-container--default .select2-selection--single {
                height: 40px;
                background: #f6f6f6;
                border: 1px solid #e3e3e3;
                border-radius: 10px;
                box-shadow: 0 1px 2px rgba(0,0,0,.08);
            }
            #master_organization_table tbody tr td .select2-selection__rendered {
                line-height: 38px !important;
                color: #222 !important;
                font-size: .95rem;
                padding-left: 14px !important;
            }
            #master_organization_table tbody tr td .select2-selection__arrow { height: 38px !important; }

            /* Web link row */
            #master_organization_table tbody tr td.website {
                position: relative !important;
                display: block !important;
                margin: 4px 0 0 !important;
                height: 44px !important;
                line-height: 42px !important;
                padding: 0 92px 0 42px !important;
                border: 1px solid #e3e3e3 !important;
                border-radius: 12px !important;
                background: #fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23555' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='10'/><line x1='2' y1='12' x2='22' y2='12'/><path d='M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z'/></svg>") 14px center no-repeat !important;
                font-size: .8rem !important;
                color: #222 !important;
                min-width: 0 !important;
                max-width: 100% !important;
                overflow: hidden !important;
                white-space: nowrap !important;
                text-overflow: ellipsis !important;
                word-break: normal !important;
                box-sizing: border-box !important;
            }

            /* Copy + open icon buttons on the right */
            #master_organization_table tbody tr td.website::after {
                content: "" !important;
                position: absolute !important;
                right: 6px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                width: 76px !important;
                height: 30px !important;
                border: 1px solid #e3e3e3 !important;
                border-radius: 8px !important;
                background:
                    url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><rect x='9' y='9' width='13' height='13' rx='2'/><path d='M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1'/></svg>") 11px center no-repeat,
                    url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6'/><polyline points='15 3 21 3 21 9'/><line x1='10' y1='14' x2='21' y2='3'/></svg>") 49px center no-repeat,
                    linear-gradient(#e3e3e3, #e3e3e3) 37px 0 / 1px 100% no-repeat,
                    #fff !important;
            }

            /* Empty state */
            #master_organization_table tbody tr td.website:empty::before {
                content: "No web link" !important;
                color: #aaa !important;
            }

            /* Remove the gap between title row and sales rep row */
            /* #master_organization_table tbody tr {
                row-gap: 0 !important;
            } */

            /* Restore the spacing for the rows below the header */
            /* #master_organization_table tbody tr td.user-id {
                margin-bottom: 12px !important;
            } */

            /* Clip header background to the card's rounded corners */
            /* #master_organization_table tbody tr {
                overflow: hidden !important;
            } */

            /* Header background: title cell */
            /* #master_organization_table tbody tr td.organization-name {
                margin: -16px -16px 0 -16px !important;
                padding: 16px 112px 0 16px !important;
                background: #cdd2d7  !important;
                box-shadow: 0 1px 0 0 #cdd2d7 !important;
                position: relative !important;
            } */

            /* Header background: sales rep cell (ends at the divider line) */
            /* #master_organization_table tbody tr td.user-id {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                padding: 4px 16px 14px 16px !important;
                background: #cdd2d7  !important;
                margin-top: -1px !important;
                border-top: 0 !important;
            } */

            /* Pagination / info */
            .dataTables_info,
            .dataTables_wrapper .dataTables_info,
            .new-style-table .dataTables_info {
                font-size: 13.5px !important;
                font-weight: 500 !important;
                color: #64748b !important;
                padding: 0 4px 12px 4px !important;
                margin: 0 !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                float: none !important;
                text-align: left !important;
            }

            .container-fluid.mb-5 {
                background-color: transparent !important;
            }
            
            /* Hide inline border-bottom on search columns (mobile only) */
            .container-fluid.mb-5 > .col-md-12:first-child .col-lg-1,
            .container-fluid.mb-5 > .col-md-12:first-child .col-lg-10 {
                clip-path: inset(0 0 1px 0) !important;
            }

            /* Search wrapper */
            .container-fluid.mb-5 > .col-md-12:first-child { padding: 0 16px !important; }
            .container-fluid.mb-5 > .col-md-12:first-child .col-lg-3 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 12px 0 !important;
            }

            /* Pill */
            .container-fluid.mb-5 > .col-md-12:first-child .col-lg-3 > .row {
                display: flex;
                flex-wrap: nowrap;
                align-items: center;
                margin: 0 !important;
                height: 54px;
                background: #fff;
                border: 1px solid #e3e3e3;
                border-radius: 18px;
                box-shadow: 0 1px 2px rgba(0,0,0,.04);
                padding: 0 16px;
            }
            .container-fluid.mb-5 > .col-md-12:first-child .col-lg-1,
            .container-fluid.mb-5 > .col-md-12:first-child .col-lg-10 {
                border-bottom: 0 !important;
                padding: 0 !important;
                max-width: none !important;
                text-align: left !important;
            }
            .container-fluid.mb-5 > .col-md-12:first-child .col-lg-1 { flex: 0 0 34px; }
            .container-fluid.mb-5 > .col-md-12:first-child .col-lg-10 { flex: 1 1 auto; }
            .container-fluid.mb-5 > .col-md-12:first-child .col-lg-1 i {
                top: 0 !important;
                font-size: 18px !important;
                color: #777 !important;
            }

            /* Input */
            .searchbox-layout {
                height: 52px !important;
                font-size: 1.05rem !important;
                background: transparent !important;
                color: #222 !important;
                box-shadow: none !important;
            }
            .searchbox-layout::placeholder { color: #b3b3b3; }
            /* Same side spacing as the search pill */
            .container-fluid.mb-5 { padding-left: 0 !important; padding-right: 0 !important; }
            .container-fluid.mb-5 > .col-md-12.mt-3 { padding: 0 16px !important; }

            /* Remove scroll */
            .container-fluid.mb-5 .table-responsive,
            #master_organization_table,
            #master_organization_table_wrapper {
                overflow: visible !important;
                overflow-x: hidden !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            #master_organization_table_wrapper > .row { margin: 0 !important; }
            #master_organization_table_wrapper > .row > div { padding: 0 !important; max-width: 100%; flex: 0 0 100%; }

            /* Cards fill the width */
            #master_organization_table tbody tr {
                width: 100% !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            .container-fluid.mb-5 > .col-md-12:first-child {
                padding: 0 16px !important;
            }
            .container-fluid.mb-5 > .col-md-12:first-child > .row {
                margin: 0 !important;
            }
            .container-fluid.mb-5 > .col-md-12:first-child .col-lg-3 {
                padding: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: 100% !important;
            }
            /* Info text */
            .dataTables_info,
            .dataTables_wrapper .dataTables_info,
            .new-style-table .dataTables_info {
                float: none !important;
                text-align: left !important;
                font-size: 13.5px !important;
                font-weight: 500 !important;
                color: #64748b !important;
                padding: 0 4px 12px 4px !important;
                margin: 0 !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
            }

            /* Pagination container */
            .dataTables_paginate,
            .dataTables_wrapper .dataTables_paginate {
                display: flex !important;
                justify-content: center !important;
                margin-top: 16px !important;
                width: 100% !important;
                float: none !important;
                overflow: visible !important;
                padding: 0 0 16px !important;
            }
            .dataTables_paginate ul.pagination,
            .dataTables_wrapper .dataTables_paginate ul.pagination {
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                gap: 4px !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .dataTables_paginate .page-item,
            .dataTables_wrapper .dataTables_paginate .page-item { margin: 0 !important; }

            /* Buttons */
            .dataTables_paginate .page-item .page-link,
            .dataTables_paginate .page-item span,
            .dataTables_wrapper .dataTables_paginate .page-link {
                border-radius: 8px !important;
                border: 1px solid #e2e8f0 !important;
                color: #475569 !important;
                font-size: 13px !important;
                padding: 6px 12px !important;
                background: #ffffff !important;
                box-shadow: none !important;
                margin: 0 !important;
                min-width: auto !important;
                height: auto !important;
                line-height: normal !important;
            }

            /* Active page */
            .dataTables_paginate .page-item.active .page-link,
            .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
                background-color: #14B8A6 !important;
                border-color: #14B8A6 !important;
                color: #ffffff !important;
                font-weight: 700 !important;
                box-shadow: none !important;
            }

            /* Prev / next / disabled / ellipsis */
            .dataTables_wrapper .dataTables_paginate .page-item.disabled .page-link {
                opacity: .45;
                background: #f6f6f6 !important;
                box-shadow: none !important;
            }
            .dataTables_wrapper .dataTables_paginate .page-item.disabled:not(.previous):not(.next) .page-link {
                background: transparent !important;
                border-color: transparent !important;
                min-width: 20px;
                padding: 0 !important;
            }

            /* Remove link padding */
            #master_organization_table tbody tr td.organization-name a.info {
                padding: 0 !important;
                display: inline-block;
                white-space: normal !important;
            }

            /* Remove the text underline on the title */
            #master_organization_table tbody tr td.organization-name a.info {
                text-decoration: none !important;
            }

            /* Full-width divider under title + sales rep (edge to edge of the card) */
            #master_organization_table tbody tr td.user-id {
                margin-left: -16px !important;
                margin-right: -16px !important;
                padding: 0 16px 5px 16px !important;
                min-height: 24px !important;
                border-bottom: 1px solid #e3e3e3 !important;
            }

            /* Card needs to be the positioning parent for the View pill */
            #master_organization_table tbody tr {
                position: relative !important;
            }

            /* Keep the title clear of the View pill */
            #master_organization_table tbody tr td.organization-name {
                padding-right: 96px !important;
            }

            /* Title underline */
            /* #master_organization_table tbody tr td.organization-name a.info {
                text-decoration: underline !important;
                text-underline-offset: 4px !important;
                text-decoration-thickness: 1px !important;
            } */

            /* "View" pill, top-right of the card */
            #master_organization_table tbody tr td.organization-name a.info::after {
                content: "View" !important;
                position: absolute !important;
                top: 14px !important;
                right: 16px !important;
                height: 32px !important;
                display: inline-flex !important;
                align-items: center !important;
                margin: 0 !important;
                padding: 0 14px 0 36px !important;
                border: 1px solid #e3e3e3 !important;
                border-radius: 10px !important;
                background: #fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23222' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'/><circle cx='12' cy='12' r='3'/></svg>") 12px center no-repeat !important;
                font-family: 'Open Sans', sans-serif !important;
                font-size: .85rem !important;
                font-weight: 600 !important;
                color: #222 !important;
                text-decoration: none !important;
                box-shadow: 0 1px 2px rgba(0,0,0,.04) !important;
                vertical-align: baseline !important;
            }
        }
    </style>
    <div class="container-fluid mb-5" style="background-color: white;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-3 mt-3  ml-auto">
                    <div class="row">
                        <div class="col-lg-1" style="border-bottom: 1px solid #B3B3B3 !important;">
                            <i class="fa fa-search" aria-hidden="true" style="font-size: 19px;color: #B3B3B3;top: 23%;position: relative;"></i>
                        </div>
                        <div class="col-lg-10 text-center" style="border-bottom: 1px solid #B3B3B3 !important;">
                            <input class="searchbox-layout"  type="text" id="search-organizations" placeholder="Search Organizations">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-3">
            <div class="table-responsive">
                <div id="alphabet-filter"></div>


                <table class="table align-items-center table-responsive" style="display: table;" id="master_organization_table">
                    <thead style="background-color: #4a4a4a; color:white;height: 2.5rem;" class="header-style">
                        <th scope="col" class="organization-name">Organization Name</th>
                        <th scope="col" class="lead-source">Lead Source</th>
                        <th scope="col" class="user-id">Sales Rep</th>
                        <th scope="col" class="sport">Sport</th>
                        <th scope="col" class="website">Website</th>
                        <th scope="col" class="size-of-club">Size of Club</th>
                        <th scope="col" class="colors">Colors</th>
                        <th scope="col" class="email">Email</th>
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
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#master_organization_table').DataTable({
                "paging": true,
                "pageLength": 50,
                "lengthChange": false,
                "searching": false
            });

            $('#search-organizations').on('blur keydown', function(event) {
                if (event.type === 'blur' || (event.type === 'keydown' && event.key === 'Enter')) {
                    loadAllOrganizations();
                }
            });

            loadAllOrganizations();

            function makeSelect1(data, id, organization_id) {
                var select = '<select class="form-control lead-source-select">';

                    select += '<option data-organization_id="'+organization_id+'" value="" selected>No selected</option>';

                data.forEach(function(lead_source) {
                    select += '<option data-organization_id="'+organization_id+'" value="' + lead_source.id + '"' + (id == lead_source.id ? ' selected' : '') + '>' + lead_source.lead_source_name + '</option>';
                });

                select += '</select>';

                return select;
            }
            function makeSelect2(data, id, organization_id) {
                var select = '<select class="form-control sport-select">';

                    select += '<option data-organization_id="'+organization_id+'" value="" selected>No selected</option>';

                data.forEach(function(sport) {
                    select += '<option data-organization_id="'+organization_id+'" value="' + sport.sport_name + '"' + (id == sport.sport_name ? ' selected' : '') + '>' + sport.sport_name + '</option>';
                });

                select += '</select>';

                return select;
            }

            function appendRows(data) {

                var rows = '';

                data.organizations.forEach(function(organization) {
                    var info = '{{ route("organizations.info", ":id") }}'
                    info = info.replace(':id', organization.id);

                    var select_element1 = makeSelect1(data.lead_sources, organization.lead_source, organization.id);
                    var select_element2 = makeSelect2(data.sports, organization.sport, organization.id);

                    rows += '<tr>' +
                                '<td class="organization-name" style="font-weight: 600;">' +
                                    // '<a href="'+info+'" style="color: rgba(50, 50, 50, 1) !important" class="info" data-value="' + (organization.id) + '">' + (organization.organization_name) + '</a>' +
                                    '<a href="'+info+'" target="_blank" rel="noopener" style="color: rgba(50, 50, 50, 1) !important" class="info" data-value="' + (organization.id) + '">' + (organization.organization_name) + '</a>' +
                                '</td>' +
                                '<td class="lead-source">' + select_element1 + '</td>' +
                                '<td class="user-id">' + (organization.user_details ? organization.user_details.name : '') + '</td>' +
                                '<td class="sport">' + select_element2 + '</td>' +
                                '<td class="website">' + (organization.website || '') + '</td>' +
                                '<td class="size-of-club text-center">' + (organization.size_of_club || '') + '</td>' +
                                '<td class="colors">' + (organization.colors || '') + '</td>' +
                                '<td class="email">' + (organization.email || '') + '</td>' +
                                '<td class="shipping-street">' + (organization.shipping_street || '') + '</td>' +
                                '<td class="shipping-city">' + (organization.shipping_city || '') + '</td>' +
                                '<td class="shipping-state">' + (organization.shipping_state || '') + '</td>' +
                                '<td class="shipping-postal-code">' + (organization.shipping_postal_code || '') + '</td>' +
                                '<td class="shipping-country">' + (organization.shipping_country || '') + '</td>' +
                                '<td class="sales-tax text-right">' + (organization.sales_tax || '') + '</td>' +
                                '<td class="sales-tax-active text-center">' + (organization.sales_tax_active ? 'Yes' : 'No') + '</td>' +
                                '<td class="created-at">' + (organization.created_at ? new Date(organization.created_at).toLocaleDateString() : '') + '</td>' +
                                '<td class="updated-at">' + (organization.updated_at ? new Date(organization.updated_at).toLocaleDateString() : '') + '</td>'
                            '</tr>';
                });

                var table = $('#master_organization_table').DataTable();
                table.clear().draw();
                table.rows.add($(rows)).draw();
                $('.lead-source-select').select2();
                $('.sport-select').select2();
                $(".se-pre-con").fadeOut('slow');
            }


            function loadAllOrganizations() {
                $(".se-pre-con").fadeIn('slow');
                var searchValue = $('#search-organizations').val().trim();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route("organization.get_all_organizations") }}',
                    method: 'GET',
                    data: {
                        'text': searchValue,
                        "_token": csrfToken
                    },
                    success: function(response) {
                        console.log(response);
                        appendRows(response);
                    },
                    error: function(xhr) {
                        console.error('Failed to fetch organizations:', xhr.responseText);
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }
            function saveOrganizationsLead(lead_source, organization_id) {
                $(".se-pre-con").fadeIn('slow');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route("organization.update_lead_source") }}',
                    method: 'GET',
                    data: {
                        'lead_source': lead_source,
                        'organization_id': organization_id,
                        "_token": csrfToken
                    },
                    success: function(response) {
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function(xhr) {
                        console.error('Failed to fetch organizations:', xhr.responseText);
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }
            function saveOrganizationsSport(sport, organization_id) {
                $(".se-pre-con").fadeIn('slow');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route("organization.update_lead_source") }}',
                    method: 'GET',
                    data: {
                        'sport': sport,
                        'organization_id': organization_id,
                        "_token": csrfToken
                    },
                    success: function(response) {
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function(xhr) {
                        console.error('Failed to fetch organizations:', xhr.responseText);
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }

            $(document).on('change', '.lead-source-select', function() {
                var lead_source = $(this).val();
                var organization_id = $(this).find('option:selected').data('organization_id');

                saveOrganizationsLead(lead_source, organization_id);
            });
            $(document).on('change', '.sport-select', function() {
                var sport = $(this).val();
                var organization_id = $(this).find('option:selected').data('organization_id');

                saveOrganizationsSport(sport, organization_id);
            });

            // web link mobile view
            $(document).on('click', '#master_organization_table td.website', function (e) {
                if (window.innerWidth > 767) return;

                var text = $(this).text().trim();
                if (!text) return;

                // distance of the tap from the right edge of the link box
                var fromRight = this.getBoundingClientRect().right - e.clientX;
                if (fromRight > 82 || fromRight < 6) return;   // outside the icon box

                if (fromRight > 45) {
                    // COPY icon (left half)
                    var done = function () { showToast('Copied'); };
                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(text).then(done);
                    } else {
                        var $t = $('<textarea>').val(text).css({position: 'fixed', opacity: 0}).appendTo('body');
                        $t[0].select();
                        document.execCommand('copy');
                        $t.remove();
                        done();
                    }
                } else {
                    // OPEN icon (right half)
                    var url = /^https?:\/\//i.test(text) ? text : 'http://' + text;
                    window.open(url, '_blank', 'noopener');
                }
            });

            function showToast(msg) {
                $('.copy-toast').remove();
                $('<div class="copy-toast"></div>').text(msg).css({
                    position: 'fixed', left: '50%', bottom: '90px', transform: 'translateX(-50%)',
                    background: '#1e293b', color: '#fff', padding: '6px 14px', borderRadius: '8px',
                    fontSize: '12px', fontWeight: 600, zIndex: 10000, boxShadow: '0 2px 8px rgba(0,0,0,.25)'
                }).appendTo('body').delay(900).fadeOut(300, function () { $(this).remove(); });
            }
        });
    </script>
@endsection
