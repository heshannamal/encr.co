@extends('layouts.app', ['activePage' => 'all_omg_stores', 'titlePage' => __('All OMG Stores')])


@section('content')
<style>

</style>
    <div class="container-fluid">
        <div class="se-pre-con"></div>

        @section('back-btn')
            <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
        @endsection

        <div class="col-md-12 mt-4">
            <div class="card">
                {{-- <div class="card-header">
                    <div class="card-header-danger col-md-12">
                        <h1 class="float-left header-title">Email Login</h1>

                        <div class="float-right header-icons">



                        </div>
                    </div>
                </div> --}}

                <div class="card-body">
                    <div class="col-md-12">
                        <div id="notificationDiv">

                        </div>

                        <form action="{{ route('saveEmailAccount') }}" method="post" style="text-align: center;">
                            @csrf
                            <div class="col-md-12 text-center">
                                <input class="form-control fadeIn second" type="email" id="email_username" name="email_username" placeholder="Email Username" style="width: 271px; display: inline;"><br><br>
                                <input class="form-control fadeIn third" type="password" id="email_password" name="email_password" placeholder="Email Password" style="width: 271px; display: inline;"><br>
                                <hr style="width: 400px;">
                                <input type="submit" class="fadeIn fourth btn btn-info btn-sm btn-custom" id="loginBtn" value="Log In" style="width: 271px !important;; display: inline; background-color: blue;">
                            </div>
                          </form>

                    </div>
                </div>

            </div>
        </div>

    </div>





    <script>

        let header = "EMAIL LOGIN";
                document.getElementById("header").innerHTML = header;

        var searchIdx = '';

        $("#loginBtn").click(function(){

            $("#notificationDiv").html("<div style='width: fit-content; margin: auto; margin-bottom: 15px;display:block !importatnt;' class='alert alert-warning show loginNotification' role='alert'><img src='https://cutewallpaper.org/21/loading-gif-transparent-background/Bee-Hollow-Farm-beekeeping-classes-and-events-near-Schodack-.gif' style='height: 30px;margin-top: -5px;'> It will take some time to connect an external mail server </div>");

            return true;
        });

        $(document).ready(function() {
            var userroleTable = $('#user_roles_table').DataTable({
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

            $.fn.dataTable.ext.search.push(function(settings, searchData) {

                if (!_alphabetSearch) {
                    return true;
                }

                if (searchData[searchIdx].charAt(0) === _alphabetSearch) {
                    return true;
                }

                return false;
            });

            var alphabet = $('<div class="alphabet"/>').append('');

            $('<span class="clear active"/>').data('letter', '').html('All').appendTo(alphabet);

            for (var i = 0; i < 26; i++) {
                var letter = String.fromCharCode(65 + i);

                $('<span/>').data('letter', letter).html(letter).appendTo(alphabet);
            }

            alphabet.insertBefore(userroleTable.table().container());

            alphabet.on('click', 'span', function() {
                alphabet.find('.active').removeClass('active');
                $(this).addClass('active');

                _alphabetSearch = $(this).data('letter');
                userroleTable.draw(_alphabetSearch);
            });

            // save column order when move
            userroleTable.on('column-reorder', function(e, settings, details) {
                var columnStr = localStorage.getItem("DataTables_user_roles_table_/user_roles");
                var columnObj = JSON.parse(columnStr);
                var colReorder = new $.fn.dataTable.ColReorder(userroleTable);
                var curr = colReorder.fnOrder();
                var column_order = JSON.stringify(curr);
                var interface_name = 'UserRole';
                var interface_id = 10;

                $.ajax({
                    url: '{{ route('datatable.column_order') }}',
                    type: "POST",
                    data: {
                        'interface_name': interface_name,
                        'interface_id': interface_id,
                        'column_order': column_order,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        // console.log(data);
                        searchIndex();
                    }
                });
            });

            var columnId = $('#column_layout_id').val();
            if (columnId == 0) {
                // save column order
                var columnStr = localStorage.getItem("DataTables_user_roles_table_/user_roles");
                var columnObj = JSON.parse(columnStr);
                var column_order = JSON.stringify(columnObj.ColReorder);
                var interface_name = 'UserRole';
                var interface_id = 10;

                $.ajax({
                    url: '{{ route('datatable.column_order') }}',
                    type: "POST",
                    data: {
                        'interface_name': interface_name,
                        'interface_id': interface_id,
                        'column_order': column_order,
                        '_token': '{{ csrf_token() }}'
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
                // refresh column order according to user
                var interfaceId = 10;
                $.ajax({
                    url: '{{ url('datatable/get_column_order') }}/' + interfaceId,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        var columnStr = localStorage.getItem("DataTables_user_roles_table_/user_roles");
                        var columnObj = JSON.parse(columnStr);
                        columnObj.ColReorder = JSON.parse(data.column_order);

                        localStorage.setItem('DataTables_user_roles_table_/user_roles', JSON.stringify(
                            columnObj));
                    },
                    complete: function() {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }

            // User Roles Edit
            $("body").on("click", ".edit", function() {
                var userRoleId = $(this).data('value');
                $('#user_role_id').val(userRoleId);
                $('#userrole_edit_modal').modal('show');
                // window.location.replace("user_roles/edit/"+userRoleId);
            });

            // User Roles Table Layout

        });



        function searchIndex() {
            $('#user_roles_table thead th').each(function() {
                if ($(this).text() == 'User Role') {
                    searchIdx = $('#user_roles_table thead th').index(this);
                    console.log(searchIdx);
                }
            });
        }

        function exportReport() {
            $("#user_roles_table").tableExport();
        }
    </script>

@endsection
