@extends('layouts.app', ['activePage' => 'all_omg_stores', 'titlePage' => __('All OMG Stores')])


@section('content')

<style>
    .export-btn {
        padding: 0.2rem;
        background-color: #787878;
        color: white;
        width: 85px;
        position: relative;
        right: -73px;
    }
    .btn-position {
        position: relative;
        top: -12px;
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
        right: 13px;
    }
    .btn-top {
        position: relative;
        top: 11px;
    }
    .content-position {
        position: relative;
        top: -46px;
    }
</style>

    <div class="container-fluid content-position">
        <div class="se-pre-con"></div>

        @section('back-btn')
            <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
        @endsection

        <div class="col-md-12 btn-top">
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3 btns-right-position">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6 btns-padding">
                                <button class="btns-text btns-style btns-card" style="outline: unset;" href="#" onclick="exportReport()" title="Export CSV">
                                   CSV Export
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
                        <h1 class="float-left header-title">All OMG Stores</h1>

                        <div class="float-right header-icons">
                            <span>
                                <a class="btn btn-round" href="#" onclick="exportReport()">
                                    <i class="fas fa-file-csv"></i>
                                </a>
                                <p>Export</p>
                            </span>


                        </div>
                    </div>
                </div> --}}

                <div class="card-body">
                    <div class="col-md-12">
                        {{-- <div class="row btn-position">
                            <div class="col-md-10">

                            </div>
                            <div class="col-md-2">
                                <span>
                                    <a class="btn export-btn" href="#" onclick="exportReport()">
                                        <i class="fas fa-file-csv">   Export</i>
                                    </a>
                                </span>
                            </div>
                        </div> --}}
                        <div class="table-responsive">
                            <table class="table align-items-center" id="user_roles_table">
                                <thead class="bg-theme">
                                    <tr>
                                        <th class="user-role-name" scope="col">OMG #</th>
                                        <th class="narration" scope="col">Store Name</th>
                                        <th class="created-at" scope="col">Organization</th>
                                        <th class="updated-at" scope="col">Store Sport</th>
                                        <th class="updated-at" scope="col">Created At</th>
                                        <th class="updated-at" scope="col">Updated At</th>
                                    </tr>
                                </thead>

                                <tbody class="list">
                                    @foreach ($OrganizationStores as $OrganizationStore)
                                    <tr>
                                        <td class="order-no"><a href={{ url('OMG/store/edit/'.$OrganizationStore->id.'') }} data-value="{{$OrganizationStore->id}}">@php echo sprintf("%05d", $OrganizationStore->id); @endphp</a></td>
                                        <td class="narration">{{$OrganizationStore->store_name}}</td>
                                        <td class="order-no"><a href={{ url('organizations/info/'.$OrganizationStore->organizationDetails['id'].'') }} data-value="{{$OrganizationStore->id}}">{{$OrganizationStore->organizationDetails['organization_name']}}</a></td>

                                        <td class="narration">{{$OrganizationStore->store_sport}}</td>
                                        <td class="created-at">{{$OrganizationStore->created_at}}</td>
                                        <td class="updated-at">{{$OrganizationStore->updated_at}}</td>
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





    <script>

        let header = "All OMG STORES";
            document.getElementById("header").innerHTML = header;

        var searchIdx = '';

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
