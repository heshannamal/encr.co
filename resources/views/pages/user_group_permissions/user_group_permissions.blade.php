@extends('layouts.app', ['activePage' => 'user_group_permissions', 'titlePage' => __('User Group Permissions')])

@section('content')
<div class="container-fluid">
    <div class="se-pre-con"></div>

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <h1 class="float-left header-title header_size01">User Permissions</h1>

                    <div class="float-right header-icons">
                        <span>
                            <a class="btn btn-round" href="#" onclick="exportReport()">
                                <i class="fas fa-file-csv"></i>
                            </a>
                            <p>Export</p>
                        </span>

                        <span>
                            <a class="btn btn-round" href="#" data-toggle="modal" data-target="#permission_create_modal">
                                <i class="fas fa-plus"></i>
                            </a>
                            <p>Add User Permissions</p>
                        </span>

                        <span>
                            <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                <i class="fas fa-wrench"></i>
                            </a>
                            <p>Table Layout</p>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table align-items-center" id="user_permissions_table">
                            <thead class="bg-theme">
                                <tr>
                                    <th class="user-role-name" scope="col">User Permissions</th>
                                    <th class="created-at" scope="col">Created At</th>
                                    <th class="updated-at" scope="col">Updated At</th>
                                </tr>
                            </thead>

                            <tbody class="list">
                                @foreach ($userPermissions as $userPermission)
                                    <tr>
                                        {{-- <td class="user-role-name"><a href="#" class="edit" data-value="{{$userPermission->id}}">{{$userPermission->user_role_name}}</a></td> --}}
                                        <td class="user-permission-name"><a href="#" class="edit" data-value="{{$userPermission->id}}">{{$userPermission->name}}</a></td>
                                        <td class="created-at">{{$userPermission->created_at}}</td>
                                        <td class="updated-at">{{$userPermission->updated_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@include('pages.permissions.permission_create')
@include('pages.permissions.permission_edit')

{{-- User Permissions Fields & Layouts --}}
{{-- <div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">User Permissions Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{$userRoleLayout['id']}}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="user_role_name" name="user_role_name" title="User Role Name"
                                    @if ($userRoleLayout['user_role_name'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="user_role_name">User Role Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="narration" name="narration" title="Narration"
                                    @if ($userRoleLayout['narration'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="narration">Narration</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At"
                                    @if ($userRoleLayout['created'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At"
                                    @if ($userRoleLayout['updated'] == 1) checked @endif
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
</div> --}}

<script>
    var searchIdx = '';

    $(document).ready(function() {
        var userroleTable = $('#user_permissions_table').DataTable({
            colReorder: true,
            stateSave: true,
            "autoWidth": false,
            "pageLength": 50,
            language: {
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Search'
            }
        });

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

        var alphabet = $('<div class="alphabet"/>').append( '' );

        $('<span class="clear active"/>').data( 'letter', '' ).html( 'All' ).appendTo( alphabet );

        for ( var i=0 ; i<26 ; i++ ) {
            var letter = String.fromCharCode( 65 + i );

            $('<span/>').data( 'letter', letter ).html( letter ).appendTo( alphabet );
        }

        alphabet.insertBefore( userroleTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            userroleTable.draw(_alphabetSearch);
        });

        // save column order when move
        userroleTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_user_permissions_table_/user_permissions");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( userroleTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'UserRole';
            var interface_id = 10;

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                },
                success: function(data) {
                    // console.log(data);
                    searchIndex();
                }
            });
        });

        var columnId = $('#column_layout_id').val();
        if(columnId == 0){
            // save column order
            var columnStr = localStorage.getItem("DataTables_user_permissions_table_/user_permissions");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'UserRole';
            var interface_id = 10;

            $.ajax({
                url: '{{ route("datatable.column_order") }}',
                type: "POST",
                data: {
                    'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                },
                success: function(data) {
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
            var interfaceId = 10;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    var columnStr = localStorage.getItem("DataTables_user_permissions_table_/user_permissions");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_user_permissions_table_/user_permissions', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        // User Permissions Edit
        $("body").on("click", ".edit", function(){
            var permissionId = $(this).data('value');
            $('#permission_id').val(permissionId);
            $('#permission_edit_modal').modal('show');
            // window.location.replace("user_permissions/edit/"+userRoleId);
        });

        // User Permissions Table Layout
        // tableLayout();
        // $('#user_role_name').on('change', function(){ tableLayout(); });
        // $('#narration').on('change', function(){ tableLayout(); });
        // $('#created_at').on('change', function(){ tableLayout(); });
        // $('#updated_at').on('change', function(){ tableLayout(); });
    });

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var user_role_name = $('#user_role_name').val();
        var narration = $('#narration').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#user_role_name').is(':checked')) {
            $('.user-role-name').css('display', 'table-cell');
            user_role_name = 1;
        } else {
            $('.user-role-name').css('display', 'none');
            user_role_name = 0;
        }

        if($('#narration').is(':checked')) {
            $('.narration').css('display', 'table-cell');
            narration = 1;
        } else {
            $('.narration').css('display', 'none');
            narration = 0;
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
            url: "user_permissions/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'user_role_name':user_role_name, 'narration':narration, 'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
            },
            success: function (data) {
                console.log(data);
                if(data == '"Saved"') {
                    window.location.reload(true);
                }
            }
        });
    }

    function searchIndex(){
        $('#user_permissions_table thead th').each(function(){
            if($(this).text() == 'User Role') {
                searchIdx = $('#user_permissions_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    function exportReport() {
        $("#user_permissions_table").tableExport();
    }
</script>

@endsection
