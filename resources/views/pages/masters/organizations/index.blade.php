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
                                    '<a href="'+info+'" style="color: rgba(50, 50, 50, 1) !important" class="info" data-value="' + (organization.id) + '">' + (organization.organization_name) + '</a>' +
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


        });
    </script>
@endsection
