@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('Users')])

@section('content')
<style>
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 33%;
    }
    .form-input,
    .select2.select2-container {
        width: 100% !important;
    }
    /* .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    } */
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
    .user_dp {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    .btn-font {
        font-size: small;
    }
    .table-btn-width {
        padding: unset;
    }
    .export-btn-width {
        padding-left: 12px;
    }
    .add-btn-width {
        padding-right: 12px;
    }
    .add-btn-text {
        position: relative;
        top: -2px;
        right: -10px;
    }
    .content-position {
        position: relative;
        top: -47px;
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
     .pagination{
        flex-wrap: wrap;
     }
  }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 btn-top">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 btns-right-position btn_set">
                <div class="row div_align">
                    <div class="col-md-3 btns-padding"></div>
                    <div class="col-md-3 btns-padding ">
                        @can('add users')
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" data-toggle="modal" data-target="#user_create_modal" title="Add New User">
                                Add User
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3 btns-padding">
                        @can('export users')
                            <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" onclick="exportReport()" title=" Export CSV">
                                CSV Export
                            </button>
                        @endcan
                    </div>
                    <div class="col-md-3 btns-padding">
                            <button class="btns-text btns-style btns-card" style="outline: unset;" data-toggle="modal" data-target="#layout_modal" title="Change Table Layout" >
                                Table Layout
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-12 mt-4">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">users</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            @can('export users')
                            <span>
                                <a class="btn btn-round" href="#" onclick="exportReport()">
                                    <i class="fas fa-file-csv"></i>
                                </a>
                                <p>Export</p>
                            </span>
                            @endcan

                            @can('add users')
                            <span>
                                <a class="btn btn-round" href="#" data-toggle="modal" data-target="#user_create_modal">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <p>Add users</p>
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
            </div> --}}

            <div class="card-body">
                <div class="col-md-12">
                    <div >
                        <table class="table align-items-center cell-border table-bordered table-responsive" id="users_table">
                            <thead class="bg-theme">
                                <th class="profile-pic" scope="col">Profile Pic</th>
                                <th class="name" scope="col">User Name</th>
                                <th class="email" scope="col">Email</th>
                                <th class="user-role-id" scope="col">User Role</th>
                                <th class="user-group-id" scope="col">User Group</th>
                                <th class="created-at" scope="col">Created At</th>
                                <th class="updated-at" scope="col">Updated At</th>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td class="profile-pic">
                                        @if ($user->profile_pic == null || $user->profile_pic == '')
                                            <img src="{{ asset('assets') }}/img/user/default.png" class="user_dp" />
                                        @else
                                            <img src="{{ asset($user->profile_pic) }}" class="user_dp" />
                                        @endif
                                    </td>
                                    <td class="name"><a href="#" class="edit" data-value="{{$user->id}}">{{$user->name}}</a></td>
                                    <td class="email">{{$user->email}}</td>
                                    <td class="user-role-id">{{$user->userRoleDetails->user_role_name ?? ''}}</td>
                                    <td class="user-group-id">
                                        @foreach ($user->roles as $key=>$role)
                                            @if ($key != 0) <br> @endif
                                            {{ $role->name }}
                                        @endforeach
                                        {{-- {{$user->userGroupDetails->user_group_name ?? ''}} --}}
                                    </td>
                                    <td class="created-at">{{$user->created_at}}</td>
                                    <td class="updated-at">{{$user->updated_at}}</td>
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

@include('pages.users.users.create')
@include('pages.users.users.edit')

{{-- Users Fields & Layouts --}}
<div class="modal fade" id="layout_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">User Fields &amp; Layouts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <input type="hidden" id="layout_id" name="layout_id" value="{{$userLayout['id'] ?? '' }}" />
                        <input type="hidden" id="column_layout_id" name="column_layout_id" value="{{$columnLayout['id'] ?? 0}}" />

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="profile_pic" name="profile_pic" title="Profile Picture"
                                    @if ($userLayout != null && $userLayout['profile_pic'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="profile_pic">Profile Picture</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="name" name="name" title="User Name"
                                    @if ($userLayout != null && $userLayout['name'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="name">User Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="email" name="email" title="Email"
                                    @if ($userLayout != null && $userLayout['email'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="email">Email</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="user_role_name" name="user_role_name" title="User Role"
                                    @if ($userLayout != null && $userLayout['user_role_name'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="user_role_name">User Role</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="user_group_name" name="user_group_name" title="User Group"
                                    @if ($userLayout != null && $userLayout['user_group_name'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="user_group_name">User Group</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="created_at" name="created_at" title="Created At"
                                    @if ($userLayout != null && $userLayout['created'] == 1) checked @endif
                                />
                                <label class="custom-control-label" for="created_at">Created At</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox mb-2">
                                <input
                                    type="checkbox" class="custom-control-input" id="updated_at" name="updated_at" title="Updated At"
                                    @if ($userLayout != null && $userLayout['updated'] == 1) checked @endif
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

<script>

    let header = "USERS";
        document.getElementById("header").innerHTML = header;

    var searchIdx = '';

    $(document).ready(function() {
        $('select').select2();

        // Users Table Layout
        tableLayout();

        var usersTable = $('#users_table').DataTable({
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

        alphabet.insertBefore( usersTable.table().container() );

        alphabet.on('click', 'span', function () {
            alphabet.find( '.active' ).removeClass( 'active' );
            $(this).addClass( 'active' );

            _alphabetSearch = $(this).data('letter');
            usersTable.draw(_alphabetSearch);
        });

        // save column order when move
        usersTable.on('column-reorder', function (e, settings, details) {
            var columnStr = localStorage.getItem("DataTables_users_table_/users");
            var columnObj = JSON.parse(columnStr);
            var colReorder = new $.fn.dataTable.ColReorder( usersTable );
            var curr = colReorder.fnOrder();
            var column_order = JSON.stringify(curr);
            var interface_name = 'User';
            var interface_id = 12;

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
            var columnStr = localStorage.getItem("DataTables_users_table_/users");
            var columnObj = JSON.parse(columnStr);
            var column_order = JSON.stringify(columnObj.ColReorder);
            var interface_name = 'User';
            var interface_id = 12;

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
            var interfaceId = 12;
            $.ajax({
                url: '{{ url("datatable/get_column_order") }}/'+interfaceId,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    var columnStr = localStorage.getItem("DataTables_users_table_/users");
                    var columnObj = JSON.parse(columnStr);
                    columnObj.ColReorder = JSON.parse(data.column_order);

                    localStorage.setItem('DataTables_users_table_/users', JSON.stringify(columnObj));
                },
                complete: function() {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }


        // Users Edit
        $("body").on("click", ".edit", function(){
            var UserId = $(this).data('value');
            $('#user_id').val(UserId);
            $('#user_edit_modal').modal('show');
        });

        $('#profile_pic').on('change', function(){ tableLayout(); });
        $('#name').on('change', function(){ tableLayout(); });
        $('#email').on('change', function(){ tableLayout(); });
        $('#user_role_name').on('change', function(){ tableLayout(); });
        $('#user_group_name').on('change', function(){ tableLayout(); });
        $('#created_at').on('change', function(){ tableLayout(); });
        $('#updated_at').on('change', function(){ tableLayout(); });
    });

    function tableLayout(){
        var layout_id = $('#layout_id').val();
        var profile_pic = $('#profile_pic').val();
        var name = $('#name').val();
        var email = $('#email').val();
        var user_role_name = $('#user_role_name').val();
        var user_group_name = $('#user_group_name').val();
        var created_at = $('#created_at').val();
        var updated_at = $('#updated_at').val();

        if($('#profile_pic').is(':checked')) {
            $('.profile-pic').css('display', 'table-cell');
            profile_pic = 1;
        } else {
            $('.profile-pic').css('display', 'none');
            profile_pic = 0;
        }

        if($('#name').is(':checked')) {
            $('.name').css('display', 'table-cell');
            name = 1;
        } else {
            $('.name').css('display', 'none');
            name = 0;
        }

        if($('#email').is(':checked')) {
            $('.email').css('display', 'table-cell');
            email = 1;
        } else {
            $('.email').css('display', 'none');
            email = 0;
        }

        if($('#user_role_name').is(':checked')) {
            $('.user-role-name').css('display', 'table-cell');
            user_role_name = 1;
        } else {
            $('.user-role-name').css('display', 'none');
            user_role_name = 0;
        }

        if($('#user_group_name').is(':checked')) {
            $('.user-group-name').css('display', 'table-cell');
            user_group_name = 1;
        } else {
            $('.user-group-name').css('display', 'none');
            user_group_name = 0;
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
            url: "users/layout",
            type: "POST",
            data: {
                'layout_id':layout_id, 'profile_pic':profile_pic, 'name':name, 'email':email, 'user_role_name':user_role_name, 'user_group_name':user_group_name,
                'created_at':created_at, 'updated_at':updated_at, '_token':'{{csrf_token()}}'
            },
            success: function (data) {
                if(data == '"Saved"') {
                    window.location.reload(true);
                }
            }
        });
    }

    function searchIndex(){
        $('#users_table thead th').each(function(){
            if($(this).text() == 'User Name') {
                searchIdx = $('#users_table thead th').index(this);
                console.log(searchIdx);
            }
        });
    }

    function exportReport() {
        $("#users_table").tableExport();
    }
</script>
@endsection
