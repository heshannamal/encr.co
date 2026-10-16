@extends('layouts.app', ['activePage' => 'user_groups', 'titlePage' => __('Employee Groups')])

@section('content')

<style>
    /* Minimal Custom Styles */
    :root {
        --primary-green: #10b981;
        --primary-green-hover: #059669;
    }

    /* Custom Button Colors */
    .btn-green {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
    }

    .btn-green:hover {
        background-color: var(--primary-green-hover);
        border-color: var(--primary-green-hover);
        color: white;
    }

    /* Table Header */
    .table thead th {
        background-color: #707070;
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: none;
        padding: 1rem 1.5rem;
    }

    /* Table Body */
    .table tbody td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f9fafb;
    }

    /* Action Icons */
    .action-icon {
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 1rem;
        margin: 0 0.375rem;
    }

    .action-icon:hover {
        color: var(--primary-green);
        transform: scale(1.1);
    }

    .action-icon.text-danger:hover {
        color: #dc2626 !important;
    }

    /* DataTables Overrides */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: none !important;
    }

    .dataTables_wrapper .dataTables_info {
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding: 0.75rem 1.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.2rem 0.4rem !important;
        margin: 0rem;
        border: 1px solid #e5e7eb !important;
        border-radius: 0.25rem;
        background: white !important;
        color: #1f2937 !important;
        font-size: 0.5rem;
        min-width: 32px;
        text-align: center;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #f9fafb !important;
        border-color: #e5e7eb !important;
        color: #1f2937 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: var(--primary-green) !important;
        border-color: var(--primary-green) !important;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background-color: var(--primary-green-hover) !important;
        border-color: var(--primary-green-hover) !important;
    }

    /* Search Input with Icon */
    .search-wrapper {
        position: relative;
    }

    .search-wrapper i {
        position: absolute;
        left: 0.875rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 0.875rem;
    }

    .search-wrapper input {
        padding-left: 2.5rem;
    }

    .mobile-search-top {
        display: none;
    }

    /* Card Shadow */
    .card {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        border: none;
    }
    
        @media (max-width: 767px) {

        /* ── Page padding ── */
        .container-fluid.pb-5.mb-5 {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        /* ── Mobile search bar shown above the buttons ── */
        .mobile-search-top {
            display: block;
            margin-bottom: 10px;
        }

        .mobile-search-top #table-search-mobile {
            width: 100%;
            box-sizing: border-box;
            border-radius: 10px;
            padding: 10px 14px 10px 36px;
            font-size: 14px;
        }

        /* ── Export CSV / Add User Group buttons ── */
        .container-fluid.pb-5.mb-5 > .d-flex.justify-content-end.mb-4.px-2 {
            flex-wrap: wrap;
            gap: 10px;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .container-fluid.pb-5.mb-5 > .d-flex.justify-content-end.mb-4.px-2 .btn {
            flex: 1 1 0;
            min-width: 0;
            margin: 0 !important;
            border-radius: 8px;
            padding: 10px 8px;
            font-size: 12px;
            white-space: nowrap;
        }

        /* ── Card shell becomes transparent — rows become their own cards ── */
        .container-fluid.pb-5.mb-5 > .card.rounded.mb-5 {
            background: transparent;
            box-shadow: none;
            border: none;
        }

        .card.rounded.mb-5 .card-body.bg-white.border-bottom {
            background: #f4f4f4 !important;
            border: none !important;
            padding: 0 0 10px;
        }

        .card.rounded.mb-5 .card-body.p-0 {
            padding: 0 !important;
        }

        /* ── Original rows-per-page + search row hidden — replaced by the mobile search bar above ── */
        .card.rounded.mb-5 .card-body.bg-white.border-bottom .row.align-items-center .col-md-6:first-child {
            display: none !important;
        }

        .card.rounded.mb-5 .card-body.bg-white.border-bottom .row.align-items-center .col-md-6:last-child {
            display: none !important;
        }

        /* ── Table becomes a stack of cards ── */
        .table-responsive {
            overflow: visible;
        }

        #user_roles_table thead {
            display: none;
        }

        #user_roles_table,
        #user_roles_table tbody {
            display: block;
            width: 100%;
        }

        #user_roles_table tbody tr {
            position: relative;
            display: block;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 14px;
            padding-right: 120px;
            margin-bottom: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        #user_roles_table tbody td {
            display: block;
            border: none !important;
            padding: 0 !important;
        }

        /* Group name — its own full-width line */
        #user_roles_table tbody td.user-role-name {
            display: block !important;
            width: 100%;
        }

        #user_roles_table tbody td.user-role-name a {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            display: block !important;
            width: 100%;
        }

        /* Narration — forced onto its own full-width line below the name */
        #user_roles_table tbody td.narration {
            display: block !important;
            width: 100%;
            font-size: 12px;
            color: #888888;
            margin-top: 4px;
            clear: both;
        }

        /* Created/Updated columns hidden on mobile */
        #user_roles_table tbody td.created-at,
        #user_roles_table tbody td.updated-at {
            display: none !important;
        }

        /* Action icons pinned to the right, vertically centered on the card */
        #user_roles_table tbody td.actions-column {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
        }

        #user_roles_table tbody td.actions-column .d-flex {
            gap: 6px;
        }

        #user_roles_table tbody td.actions-column .action-icon {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f2f3f4;
            font-size: 13px;
            color: #555555;
            margin: 0;
        }

        #user_roles_table tbody td.actions-column .action-icon.fa-user-plus {
            background: #eaf1ff;
            color: #2f6fed;
        }

        #user_roles_table tbody td.actions-column .action-icon.text-danger {
            background: #fdecea;
            color: #e53935 !important;
        }

        /* ── DataTables footer, compacted ── */
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 8px 0;
            font-size: 12px;
        }

        .dataTables_wrapper .dataTables_paginate {
            text-align: center;
        }

        i.fas.fa-download.mr-1 {
            padding-right: 16px;
        }

        i.fas.fa-plus.mr-1 {
            padding-right: 14px;
        }

        .back_home_mobile {
            margin-bottom: 12px;
        }

        .modal-content.rounded-0 {
            border-radius: 15px !important;
        }

        .btn-success {
            background: #1AA05A;
        }

        button.btn.btn-secondary.btn-sm.text-uppercase.px-4 {
            background: #9CA3AF;
        }

       

    }

    @media (min-width: 768px) {
        .back_home_mobile {
            display: none;
        }
    }

   
</style>

@if ($errors->any())
<div class="alert alert-danger">
    {{ $errors->first() }}
</div>
@endif

<!-- @if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif -->

<div class="container-fluid pb-5 mb-5">
    <div class="se-pre-con" style="display: none;">
        <div class="spinner-border text-success" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    @section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    @section('back-btn-Mobile')
    <a href="javascript:void(0);" onclick="goBackOnePage()" class="home-btn-color-mobile" title="Back">
        < BACK
    </a>
    @endsection

    <div class="back_home_mobile">
        <strong>
            @yield('back-btn-Mobile')
        </strong>
    </div>

    <div class="search-wrapper mobile-search-top">
        <i class="fas fa-search"></i>
        <input type="text" id="table-search-mobile" class="form-control form-control-sm" placeholder="Search by employee group">
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-end mb-4 px-2">
        @can('export usergroups')
        <button class="btn btn-secondary mr-2" onclick="exportReport()" title="Export CSV">
            <i class="fas fa-download mr-1"></i>
            EXPORT CSV
        </button>
        @endcan
        @can('add usergroups')
        <button class="btn btn-green mr-2" data-toggle="modal" data-target="#userrole_create_modal" title="Add New User Group">
            <i class="fas fa-plus mr-1"></i>
            ADD USER GROUP
        </button>
        @endcan
        <!-- <button class="btn btn-secondary" data-toggle="modal" data-target="#layout_modal" title="Table Layout">
            TABLE LAYOUT
        </button> -->
    </div>

    <!-- Main Card -->
    <div class="card rounded mb-5">
        <!-- Table Controls -->
        <div class="card-body bg-white border-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <label class="mb-0 mr-2 text-muted small">Show rows per page</label>
                        <select id="entries-select" class="form-control form-control-sm" style="width: auto;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50" selected>50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="table-search" class="form-control form-control-sm" placeholder="Search by employee group">
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="user_roles_table">
                    <thead>
                        <tr>
                            <th class="user-role-name">EMPLOYEE GROUPS</th>
                            <th class="narration">NARRATION</th>
                            <th class="created-at">CREATED AT</th>
                            <th class="updated-at">UPDATED AT</th>
                            <th class="actions-column">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userRoles as $userRole)
                        <tr>
                            <td class="user-role-name">
                                <a href="#" class="text-dark font-weight-medium" data-value="{{$userRole->id}}">{{$userRole->name}}</a>
                            </td>
                            <td class="narration">{{$userRole->narration}}</td>
                            <td class="created-at">{{$userRole->created_at}}</td>
                            <td class="updated-at">{{$userRole->updated_at}}</td>
                            <td class="actions-column">
                                <div class="d-flex align-items-center">
                                    @can('edit usergroups')
                                    <i class="fas fa-edit action-icon edit" data-value="{{$userRole->id}}" title="Edit"></i>
                                    @endcan
                                    @can('view usergroups')
                                    <i class="fas fa-user-plus action-icon" data-value="{{$userRole->id}}" title="View Members"></i>
                                    @endcan
                                    @can('delete usergroups')
                                    <i class="fas fa-trash action-icon text-danger delete-role" data-value="{{$userRole->id}}" title="Delete"></i>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('pages.users.user_roles.create')
@include('pages.users.user_roles.edit')
@include('pages.users.user_roles.delete')
@include('pages.users.user_roles.detailview')
@include('pages.users.user_roles.members')

<!-- User Roles Fields & Layouts Modal -->
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h3 class="modal-title">User Groups Fields & Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="layout_id" name="layout_id" value="{{$userRoleLayout['id'] ?? ''}}" />
                    <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                    <div class="col-md-6 mb-3">
                        <div class="custom-control custom-checkbox">
                            <input
                                type="checkbox" class="custom-control-input" id="user_role_name" name="user_role_name"
                                @if ($userRoleLayout !=null && $userRoleLayout['user_role_name']==1) checked @endif />
                            <label class="custom-control-label" for="user_role_name">User Groups Name</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="custom-control custom-checkbox">
                            <input
                                type="checkbox" class="custom-control-input" id="narration" name="narration"
                                @if ($userRoleLayout !=null && $userRoleLayout['narration']==1) checked @endif />
                            <label class="custom-control-label" for="narration">Narration</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="custom-control custom-checkbox">
                            <input
                                type="checkbox" class="custom-control-input" id="created_at" name="created_at"
                                @if ($userRoleLayout !=null && $userRoleLayout['created']==1) checked @endif />
                            <label class="custom-control-label" for="created_at">Created At</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="custom-control custom-checkbox">
                            <input
                                type="checkbox" class="custom-control-input" id="updated_at" name="updated_at"
                                @if ($userRoleLayout !=null && $userRoleLayout['updated']==1) checked @endif />
                            <label class="custom-control-label" for="updated_at">Updated At</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    let header = "EMPLOYEE GROUPS";
    if (document.getElementById("header")) {
        document.getElementById("header").innerHTML = header;
    }

    var searchIdx = '';
    var userRolesTable;

    $(document).ready(function() {
        // Initialize DataTable
        userRolesTable = $('#user_roles_table').DataTable({
            colReorder: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 50,
            "dom": '<"top">rt<"bottom"ip><"clear">',
            language: {
                search: '',
                searchPlaceholder: 'Search by employee group'
            }
        });

        searchIndex();

        // Custom search input
        $('#table-search').on('keyup', function() {
            userRolesTable.search(this.value).draw();
        });

        // Custom entries select
        $('#entries-select').on('change', function() {
            userRolesTable.page.len(parseInt(this.value)).draw();
        });

        // Save column order when moved
        userRolesTable.on('column-reorder', function(e, settings, details) {
            var colReorder = new $.fn.dataTable.ColReorder(userRolesTable);
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'UserRole';
            var interface_id = 10;

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name,
                    'interface_id': interface_id,
                    'column_order': column_order,
                    '_token': '{{csrf_token()}}'
                },
                success: function(data) {
                    searchIndex();
                }
            });
        });

        var columnId = $('#column_layout_id').val();
        if (columnId == 0) {
            var columnStr = localStorage.getItem("DataTables_user_roles_table_/user_roles");

            if (columnStr) {
                var columnObj = JSON.parse(columnStr);
                var column_order = JSON.stringify(columnObj.ColReorder);
            } else {
                var column_order = null;
            }
            var interface_name = 'UserRole';
            var interface_id = 10;

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name,
                    'interface_id': interface_id,
                    'column_order': column_order,
                    '_token': '{{csrf_token()}}'
                },
                success: function(data) {
                    if (window.location.href.indexOf('reload') == -1) {
                        window.location.replace(window.location.href + '?reload');
                    }
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        } else {
            var interfaceId = 10;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/' + interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    var columnStr = localStorage.getItem("DataTables_user_roles_table_/user_roles");

                    if (columnStr) {
                        var columnObj = JSON.parse(columnStr);
                        columnObj.ColReorder = JSON.parse(data.column_order);
                        localStorage.setItem('DataTables_user_roles_table_/user_roles', JSON.stringify(columnObj));
                    }
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        // Edit handler
        $('#user_roles_table').on('click', '.edit', function(e) {

            e.preventDefault();
            e.stopPropagation();

            var userRoleId = $(this).data('value');

            console.log("Clicked:", userRoleId);

            if (!userRoleId) {
                alert("No ID");
                return;
            }

            $('#edit_user_role_id').val(userRoleId);

            $.ajax({
                url: "{{ url('user_roles/edit') }}/" + userRoleId,
                type: 'GET',
                success: function(data) {

                    var obj = typeof data === 'string' ? JSON.parse(data) : data;
                    $('#edit_user_role_name').val(obj.name);
                    $('#edit_narration').val(obj.narration);

                    $('#userrole_edit_modal').modal('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert("Ajax error");
                }
            });

        });

        // Detail view handler (click group name link)
        $('#user_roles_table').on('click', 'a.text-dark', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var userRoleId = $(this).data('value');

            // Show modal immediately with loading state
            $('#detail_user_role_name').text('Loading...');
            $('#detail_narration').text('');
            $('#detail_user_count').text('');
            $('#detail_users_tbody').html('<tr><td colspan="2" class="text-center text-muted">Loading...</td></tr>');
            $('#userrole_detail_modal').modal('show');

            $.ajax({
                url: "{{ url('user_roles/detail') }}/" + userRoleId,
                type: 'GET',
                success: function(data) {
                    var obj = typeof data === 'string' ? JSON.parse(data) : data;

                    $('#detail_user_role_name').text(obj.name);
                    $('#detail_narration').text(obj.narration ?? 'N/A');
                    $('#detail_user_count').text('Total ' + obj.users.length + ' users');

                    if (obj.users.length > 0) {
                        var rows = '';
                        obj.users.forEach(function(user) {
                            rows += '<tr><td>' + user.name + '</td><td>' + user.email + '</td></tr>';
                        });
                        $('#detail_users_tbody').html(rows);
                    } else {
                        $('#detail_users_tbody').html('<tr><td colspan="2" class="text-center text-muted">No users in this group</td></tr>');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    $('#detail_users_tbody').html('<tr><td colspan="2" class="text-center text-danger">Failed to load data</td></tr>');
                }
            });
        });

        // Table Layout
        tableLayout();
        $('#user_role_name').on('change', function() {
            tableLayout();
        });
        $('#narration').on('change', function() {
            tableLayout();
        });
        $('#created_at').on('change', function() {
            tableLayout();
        });
        $('#updated_at').on('change', function() {
            tableLayout();
        });
    });

    function tableLayout() {
        var layout_id = $('#layout_id').val();
        var user_role_name = $('#user_role_name').val();
        var narration = $('#narration').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if ($('#user_role_name').is(':checked')) {
            $('.user-role-name').css('display', 'table-cell');
            user_role_name = 1;
        } else {
            $('.user-role-name').css('display', 'none');
            user_role_name = 0;
        }

        if ($('#narration').is(':checked')) {
            $('.narration').css('display', 'table-cell');
            narration = 1;
        } else {
            $('.narration').css('display', 'none');
            narration = 0;
        }

        if ($('#created_at').is(':checked')) {
            $('.created-at').css('display', 'table-cell');
            created_at = 1;
        } else {
            $('.created-at').css('display', 'none');
            created_at = 0;
        }

        if ($('#updated_at').is(':checked')) {
            $('.updated-at').css('display', 'table-cell');
            updated_at = 1;
        } else {
            $('.updated-at').css('display', 'none');
            updated_at = 0;
        }

        $.ajax({
            url: "user_roles/layout",
            type: "POST",
            data: {
                'layout_id': layout_id,
                'user_role_name': user_role_name,
                'narration': narration,
                'created_at': created_at,
                'updated_at': updated_at,
                '_token': '{{csrf_token()}}'
            },
            success: function(data) {
                console.log(data);
                if (data == '"Saved"') {
                    window.location.reload(true);
                }
            }
        });
    }

    function searchIndex() {
        $('#user_roles_table thead th').each(function() {
            if ($(this).text().includes('EMPLOYEE GROUPS')) {
                searchIdx = $('#user_roles_table thead th').index(this);
            }
        });
    }

    function exportReport() {
        $("#user_roles_table").tableExport();
    }

    document.addEventListener('DOMContentLoaded', function () {
        var mobileSearch = document.getElementById('table-search-mobile');
        var realSearch = document.getElementById('table-search');
        if (mobileSearch && realSearch) {
            mobileSearch.addEventListener('input', function () {
                realSearch.value = mobileSearch.value;
                if (typeof $ !== 'undefined') {
                    $(realSearch).trigger('keyup');
                }
            });
        }
    });

    function goBackOnePage() {
        if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
            window.history.back();
        } else {
            window.location.href = "{{ route('home') }}";
        }
    }
</script>

@endsection