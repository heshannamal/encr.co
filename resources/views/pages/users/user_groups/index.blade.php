@extends('layouts.app', ['activePage' => 'user_group_members', 'titlePage' => __('User Group Members')])

@section('content')

<style>
    .table-btn-width {
        width: 115px;
    }
    .btn-table {
        position: relative;
        right: -45px;
    }
    .table-btn-text {
        position: relative;
        right: -10px;
    }
    .content-position {
        position: relative;
        top: -45px;
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
        right: 14px;
    }
    .btn-top {
        position: relative;
        top: 11px;
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

   .pagina001{
        flex-wrap: wrap;
     }
     .flex_set{
        flex-direction: column;
     }
     .max_width01{
        max-width: none;
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
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
        .header1{
            display: inline !important;
        }
        .headder_size{
            font-size:14px !important;
        }
        .pagination{
            flex-wrap: wrap;
        }
    }
    .permissions-list {
        column-count: 3;
        column-gap: 20px;
        list-style-position: inside;
    }
</style>

<div class="container-fluid content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 btn-top">
        <div class="row div_align">
            <div class="col-md-9 "></div>
            <div class="col-md-3 btns-right-position btn_set">
                <div class="row">
                    <div class="col-md-6 btns-padding">
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" onclick="exportReport()" title="Export CSV">
                                CSV Export
                            </button>
                    </div>
                    <div class="col-md-6 btns-padding">
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout">
                                Table Layout
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  --}}

    <div class="col-md-12 mt-4">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">user group members</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            @can('export usergroup members')
                            <span>
                                <a class="btn btn-round" href="#" onclick="exportReport()">
                                    <i class="fas fa-file-csv"></i>
                                </a>
                                <p>Export</p>
                            </span>
                            @endcan

                            <span>
                                <a class="btn btn-round" href="#" data-toggle="modal" data-target="#usergroup_create_modal">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <p>Add User Groups</p>
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
            </div> --}}

            <div class="card-body">
                <div class="col-md-12">
                    <div>
                        <table class="table align-items-center table-bordered table-responsive" id="user_groups_table">
                            <thead class="bg-theme">
                                <tr>
                                    <th class="user-group-name width-200" scope="col">User Group</th>
                                    <th class="narration" scope="col">Narration</th>
                                    <th class="permissions" scope="col">Permissions</th>
                                    <th class="created-at" scope="col">Created At</th>
                                    <th class="updated-at" scope="col">Updated At</th>
                                </tr>
                            </thead>

                            <tbody class="list">
                                @foreach ($userGroups as $userGroup)
                                    <tr>
                                        <td class="user-group-name"><a href="#" class="edit-member" data-value="{{$userGroup->id}}" data-name="{{$userGroup->name}}">{{$userGroup->name}}</a></td>
                                        <td class="narration">{{$userGroup->narration}}</td>
                                        <td class="permissions">
                                            <div class="d-flex view_Group_permissions" data-group-id="{{$userGroup->id}}" style="align-items: baseline;">
                                                <i class="mx-2 arrow-toggle fa fa-eye" style="cursor: pointer;"></i>
                                                <p style="cursor: pointer;font-size:15px;">View</p>
                                            </div>
                                        </td>
                                        <td class="created-at">{{$userGroup->created_at}}</td>
                                        <td class="updated-at">{{$userGroup->updated_at}}</td>
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

{{-- @include('pages.users.user_groups.create') --}}
{{-- @include('pages.users.user_groups.edit') --}}
@include('pages.users.user_groups.edit_members')

{{-- User Groups Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">User Groups Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{$userGroupLayout['id'] ?? '' }}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="user_group_name" name="user_group_name" title="User Group Name"
                                    @if ($userGroupLayout != null && $userGroupLayout['user_group_name'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="user_group_name">User Group Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="narration" name="narration" title="Narration"
                                    @if ($userGroupLayout != null && $userGroupLayout['narration'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="narration">Narration</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="permissions" name="permissions" title="permissions"
                                    @if ($userGroupLayout != null && $userGroupLayout['permissions'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="permissions">Permissions</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At"
                                    @if ($userGroupLayout != null && $userGroupLayout['created'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At"
                                    @if ($userGroupLayout != null && $userGroupLayout['updated'] == 1) checked @endif
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
<div class="modal fade" id="view_group_permissions"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Employee Groups Permissions</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <div class="col-12">
                <h4>Permissions</h4>
            </div>
            <div class="row">
                <ol class="permissions-list"></ol>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script>

    let header = "USER GROUP MEMBERS";
        document.getElementById("header").innerHTML = header;

    var searchIdx = '';

    $(document).ready(function() {
        var usergroupTable = $('#user_groups_table').DataTable({
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

        alphabet.insertBefore( usergroupTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            usergroupTable.draw(_alphabetSearch);
        });

        // save column order when move
        usergroupTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_user_groups_table_/user_groups");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( usergroupTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'UserGroup';
            var interface_id = 11;

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
            var columnStr = localStorage.getItem("DataTables_user_groups_table_/user_groups");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'UserGroup';
            var interface_id = 11;

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
            var interfaceId = 11;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    var columnStr = localStorage.getItem("DataTables_user_groups_table_/user_groups");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_user_groups_table_/user_groups', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        // User Group Edit
        $("body").on("click", ".edit", function(){
            var userGroupId = $(this).data('value');
            $('#user_group_id').val(userGroupId);
            $('#usergroup_edit_modal').modal('show');
            // window.location.replace("user_groups/edit/"+userGroupId);
        });

        // User Group Members
        $("body").on("click", ".edit-member", function(){
            var userGroupId = $(this).data('value');
            var userGroupName = $(this).data('name');
            $('#user_group_members_group_id').val(userGroupId);
            $('#group_name').html(userGroupName);
            $('#usergroup_members_modal').modal('show');
            // window.location.replace("user_groups/edit/"+userGroupId);
        });

        // User Groups Table Layout
        tableLayout();
        $('#user_group_name').on('change', function(){ tableLayout(); });
        $('#narration').on('change', function(){ tableLayout(); });
        $('#permissions').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var user_group_name = $('#user_group_name').val();
        var narration = $('#narration').val();
        var permissions = $('#permissions').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#user_group_name').is(':checked')) {
            $('.user-group-name').css('display', 'table-cell');
            user_group_name = 1;
        } else {
            $('.user-group-name').css('display', 'none');
            user_group_name = 0;
        }

        if($('#narration').is(':checked')) {
            $('.narration').css('display', 'table-cell');
            narration = 1;
        } else {
            $('.narration').css('display', 'none');
            narration = 0;
        }
        if($('#permissions').is(':checked')) {
            $('.permissions').css('display', 'table-cell');
            permissions = 1;
        } else {
            $('.permissions').css('display', 'none');
            permissions = 0;
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
            url: "user_groups/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'user_group_name':user_group_name, 'permissions':permissions, 'narration':narration, 'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
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
        $('#user_groups_table thead th').each(function(){
            if($(this).text() == 'User Group') {
                searchIdx = $('#user_groups_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    function exportReport() {
        $("#user_groups_table").tableExport();
    }
    $(document).on('click', '.view_Group_permissions', function() {
        var groupId = $(this).data('group-id');
        $('#view_group_permissions').modal('show');

        $.ajax({
            url: "{{ url('user_groups/userGroupPermissionList') }}",
            type: "GET",
            data: {
                groupId: groupId,
                _token: $('meta[name="csrf-token"]').attr("content")
            },
            success: function(response) {
                console.log(response);

                var permissionsList = $('.permissions-list');
                permissionsList.empty();

                if (response.permission.length > 0) {
                    response.permission.forEach(function(permission) {
                        permissionsList.append('<li>' + permission.name + '</li>');
                    });
                } else {
                    permissionsList.append('Group have no permission added');
                }
            },
            error: function() {
                swal("Error occurred while fetching data.");
            }
        });
    });

</script>

@endsection
