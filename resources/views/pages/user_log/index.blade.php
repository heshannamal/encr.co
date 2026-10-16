@extends('layouts.app', ['activePage' => 'user_log', 'titlePage' => __('User Logs')])

@section('content')
<style>

#searchbox{
        border: 2px solid #ffffff;
        height: 35px;
        /* width: 250px; */
        width: 100%;
        border-radius: 30px;
        padding: 0px 5px;
        background-color: #ffffff1a;
        margin-top: 10px;
        color: #ffffff;
    }
    #searchbox::placeholder {
        color: #aaaaaa;
        opacity: 1; /* Firefox */
        font-size: 14px;
    }
    #searchbox:focus {
        outline: 0px;
    }
    #searchbox:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #aaaaaa;
    }
    #searchbox::-ms-input-placeholder { /* Microsoft Edge */
        color: #aaaaaa;
    }
    .searchbox-position {
        position: relative;
        top: -5px;
    }
    .content-position {
        position: relative;
        top: -25px;
    }
    .right-align {
        text-align: right;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .select2-container--default .select2-selection--single {
        background-color: #fff !important;
        border: 0.5px solid #eaeaea !important;
        border-radius: 5px !important;
    }
    img {
        max-width: 150px;
        max-height: 150px;
    }
</style>

<div class="container-fluid content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    {{-- <div class="col-md-12 mt-4">
        <div class="card">
            <div class="row searchbox-position">
                <div class="col-md-6"></div>
                <div class="col-md-6 right-align" >
                    <input type="text" id="searchbox" placeholder="Causer Name Search" style="width: 68%;margin-right: 20px; border-radius: 5px; border: 0.125rem solid #787878; color: #787878; position: relative; right: 20px;">
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user_log.index') }}" method="GET">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="start_date">Select Start Date</label>
                                {{-- <input type="date" class="form-control" name="std" id="std"
                                    value="{{ $std }}" max="<?= date('Y-m-d') ?>" required> --}}
                                    <input type="text" class="form-control datepicker" name="std" id="std" value="{{ Carbon\Carbon::parse($std)->format('m/d/Y') }}"
                                    max="<?= date('m/d/Y') ?>" required/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="end_date">Select End Date</label>
                                {{-- <input type="date" class="form-control" name="end" id="end"
                                    value="{{ $end }}" max="<?= date('Y-m-d') ?>" required> --}}
                                    <input type="text" class="form-control datepicker" name="end" id="end" value="{{ Carbon\Carbon::parse($end)->format('m/d/Y') }}"
                                    max="<?= date('m/d/Y') ?>" required/>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="user_id">Select a User</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">All User logs</option>
                                    <option value="customer" @if ($userId == 'customer') selected @endif>Customer</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if ($userId == $user->id) selected @endif>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sr_event">Search by Event</label>
                                <select name="sr_event" id="sr_event" class="form-control">
                                    <option value="">All</option>
                                    <option @if ($sr_event == "created") selected @endif value="created">Created</option>
                                    <option @if ($sr_event == "updated") selected @endif value="updated">Updated</option>
                                    <option @if ($sr_event == "deleted") selected @endif value="deleted">Deleted</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sr_module">Search by Module</label>
                                <select name="sr_module" id="sr_module" class="form-control">
                                    <option value="">All Modules</option>
                                    @foreach ($auditableModels as $auditableModel)
                                        <option value="{{ $auditableModel }}"
                                            @if ($sr_module == $auditableModel) selected @endif>
                                            {{ last(explode('\\', $auditableModel)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sr_id">Search by ID</label>
                                <input type="number" class="form-control" name="sr_id" id="sr_id" step="0"
                                    value="{{ $sr_id }}" placeholder="Enter text for serach">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sr_text">Search by Source</label>
                                <input type="text" class="form-control" name="sr_text" id="sr_text"
                                    value="{{ $sr_text }}" placeholder="Enter text for serach">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sr_update">Search by Updates</label>
                                <input type="text" class="form-control" name="sr_update" id="sr_update"
                                    value="{{ $sr_update }}" placeholder="Enter text for serach">
                            </div>
                        </div>

                    </div>
                    <div class="row justify-content-end">
                        <div class="col-md-2 mt-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control d-flex d-md-block"><i
                                        class="bi bi-search pe-2 px-1"></i> Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        @can('delete user logs')
                            <div class="col-md-2 col-sm-6 ">
                                <div class="form-group mb-0">
                                    <button type="button" class="btn btn-warning form-control d-flex d-md-block" id="delete_selected"> Delete Selected</button>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 ">
                                <div class="form-group mb-0">
                                    <button type="button" class="btn btn-google-plus form-control d-flex d-md-block" id="delete_filtered"> Delete Filtered</button>
                                </div>
                            </div>
                        @endcan
                        <div class="col-md-2 col-sm-6 ">
                            <div class="form-group mb-0">
                                <button type="button" class="btn btn-success form-control d-flex d-md-block" id="export">
                                    <i class="fa fa-download pe-2 px-1" ></i> Export</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form action="{{ route('user_log.export') }}" method="POST" id="export_form">
        @csrf
        <input type="hidden" name="user_id" id="export_user_id">
        <input type="hidden" name="std" id="export_std">
        <input type="hidden" name="end" id="export_end">
        <input type="hidden" name="sr_event" id="export_sr_event">
        <input type="hidden" name="sr_module" id="export_sr_module">
        <input type="hidden" name="sr_id" id="export_sr_id">
        <input type="hidden" name="sr_text" id="export_sr_text">
        <input type="hidden" name="sr_update" id="export_sr_update">
    </form>

    <div class="col-md-12 mt-4">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">Activity Logs</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            <div style="width: 100%;justify-content: flex-end;display: flex">
                                <input type="text" id="searchbox" placeholder="Causer Name Search" style="width: 50%;margin-right: 20px">
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
            </div> --}}

            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table align-items-center table-bordered" id="user_log_table">
                            <thead class="bg-theme">
                                <tr>
                                    <th scope="col" class="">
                                        <input type="checkbox" id='chk_all' class="chkAll">
                                    </th>
                                    <th scope="col" class="">Date & Time</th>
                                    <th scope="col" class="">User</th>
                                    <th scope="col" class="">Event</th>
                                    <th scope="col" class="">Module</th>
                                    <th scope="col" class="">ID</th>
                                    <th scope="col" class="">Source</th>
                                    <th scope="col" class="">Updates</th>
                                    <th scope="col" class="">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="tableBody">
                                @foreach ($audits as $audit)
                                    @if (!empty($audit->new_values))
                                        <tr>
                                            <td>
                                                <input type="checkbox" id='chk_item_{{ $audit->id }}' class="chkItemChild" value="{{ $audit->id }}">
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($audit->created_at)->format('m/d/Y - H:i') }}
                                            </td>
                                            <td>{{ $audit->user_id && $audit->user ? $audit->user->name : 'Customer' }}</td>
                                            <td>{{ ucfirst($audit->event) }}</td>
                                            <td>
                                                @php
                                                    $str = $audit->auditable_type;
                                                    $newstr = explode('\\', $str);
                                                @endphp
                                                {{ end($newstr) }}
                                            </td>
                                            <td>{{ $audit->auditable_id ?? '' }}</td>
                                            <td>
                                                @php
                                                    $sourceArr = [];
                                                    $sources = $audit->source;
                                                    if($sources){
                                                        $sourceArr = json_decode($sources);
                                                    }
                                                @endphp
                                                <ul>
                                                    @foreach ($sourceArr as $key=>$sr)
                                                        @if ($sr == 'Customer Changes')
                                                            <li>{{ $sr }}</li>
                                                        @else
                                                            <li>{{ $key.' - '.$sr }}</li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                @if ($audit->event == 'updated')
                                                    <ul>
                                                        @foreach ($audit->getModified() as $key => $auditUpdate)
                                                            <li>{{ ucfirst(str_replace('_', ' ', $key)) }}</li>
                                                        @endforeach
                                                    </ul>
                                                {{-- @elseif ($audit->event == 'created')
                                                    @foreach ($audit->getModified() as $key => $auditUpdate)
                                                        @if ($key == 'name' || $key == 'title' || $key == 'task_name')
                                                            {{ $auditUpdate['new'] }}
                                                        @endif
                                                    @endforeach
                                                @elseif ($audit->event == 'deleted')
                                                    @foreach ($audit->getModified() as $key => $auditUpdate)
                                                        @if ($key == 'name' || $key == 'title' || $key == 'task_name')
                                                            {{ $auditUpdate['old'] }}
                                                        @endif
                                                    @endforeach --}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($audit->event == 'updated')
                                                    @if (array_key_exists('password', $audit->getModified()) || array_key_exists('remember_token', $audit->getModified()))
                                                        <button type="button"
                                                            class="btn  btn-sm" disabled><i
                                                                class="fas fa-eye-slash"></i></button>
                                                    @else
                                                        <button type="button"
                                                            class="btn  btn-sm view"
                                                            value="{{ $audit->id }}"><i
                                                                class="fas fa-eye"></i></button>
                                                    @endif
                                                @elseif ($audit->event == 'created')
                                                <button type="button"
                                                            class="btn  btn-sm view_creted"
                                                            value="{{ $audit->id }}"><i
                                                                class="fas fa-eye"></i></button>
                                                    {{-- @php
                                                        $str = $audit->auditable_type;
                                                        $newstr = explode('\\', $str);
                                                    @endphp
                                                    @if (end($newstr) == 'DivisionPost')
                                                        <a href="{{ url('division-inner', $audit->auditable_id) }}"
                                                            target="_blank"
                                                            class="btn  btn-sm view"><i
                                                                class="fas fa-eye"></i></a>
                                                    @else
                                                        <a href="{{ $audit->url }}" target="_blank"
                                                            class="btn btn-sm view"><i
                                                                class="fas fa-eye"></i></a>
                                                    @endif --}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-md-12 mt-2">
                    <div style="float: right">
                        {{ $audits->onEachSide(5)->withQueryString()->links('layouts.paginationlinks') }}
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@include('pages.user_log.modals.view')

        <script>
            var userTable;

            function dismissModal() {
                $('.modal').modal('hide');
            }

            $(document).ready(function() {

                $(".se-pre-con").fadeOut();

                userTable = $('#user_log_table').DataTable({
                    "order": [1, 'desc'],
                    'columnDefs': [{
                        'targets': [5],
                        'orderable': false,
                    },{
                        'targets': [0],
                        'orderable': false,
                    }],
                    "searching": false,
                    "paging": false,
                    "info": false,
                    "lengthChange": false,
                    "pageLength": 50,
                });
                $('.datepicker').datepicker({ minDate: 0});

                $('#user_id').select2({
                    allowClear: true,
                    placeholder: 'All User logs'
                });

                $('#sr_module').select2({
                    allowClear: true,
                    placeholder: 'All Modules'
                });

                $('select').each(function() {
                    if ($(this).val()) {
                        $(this).trigger('change');
                    }
                });
            });

            // $('body').on('click', '.view', function(){
            //     $('#viewUserLogModal').modal('show');
            // });

            $('body').on('click', '.view', function() {
                var auditId = $(this).val();
                viewAuditDetail(auditId, 'view');
            });

            $('body').on('click', '.view_creted', function() {
                var auditId = $(this).val();
                viewAuditDetail(auditId, 'view_creted');
            });

            function viewAuditDetail(auditId, type){
                $.ajax({
                    url: "{{ url('user_log/get_detail') }}/" + auditId + "/" + type,
                    method: "GET",
                    // dataType: "json",
                    success: function(data) {
                        console.log(data);

                        $('#user_log_detail_modal_body').html('');
                        if (data) {
                            // $.each(data, function(field, value) {
                            //     field = field.replace(/_/g, " ");
                            //     var col = '';
                            //     if (type == 'view') {
                            //         col += '<div class="row">';
                            //         col += '<div class="col">';
                            //         col += '<h5 class="text-capitalize">' + field + '</h5>';
                            //         col += '<hr style="margin-top: inherit; margin-bottom: 0.5rem;"> ';
                            //         col += '<div class="row">';
                            //         col += '<div class="col-md-2 text-right" style="padding-right: 2rem; font-weight: bold;"> New : </div>';
                            //         col += '<div class="col-md-10" style="font-weight: bold;"> ' + value.new + ' </div>';
                            //         col += '</div>';
                            //         col += '<div class="row mb-5">';
                            //         col += '<div class="col-md-2 text-right" style="padding-right: 2rem;"> Previous : </div>';
                            //         col += '<div class="col-md-10"> ' + value.old + ' </div>';
                            //         col += '</div>';
                            //         col += '</div>';
                            //         col += '</div>';
                            //     } else {
                            //         // col += '<div class="row">';
                            //         // col += '<div class="col">';
                            //         // col += '<h5 class="text-capitalize">' + field + '</h5>';
                            //         // col += '<hr style="margin-top: inherit; margin-bottom: 0.5rem;"> ';
                            //         if(field != 'id'){
                            //             col += '<div class="row mb-1">';
                            //             col += '<div class="col-md-2 d-flex justify-content-end text-right" style="font-weight: bold;"><h5 class="text-capitalize">' + field + '</h5></div>';
                            //             col += '<div class="" style="font-weight: bold;">:</div>';
                            //             col += '<div class="col-md-9" style="font-weight: bold;"> ' + value.new + ' </div>';
                            //             col += '</div>';
                            //         }
                            //         // col += '</div>';
                            //         // col += '</div>';
                            //     }


                            //     $(col).appendTo('#user_log_detail_modal_body');
                            // });
                            $(data).appendTo('#user_log_detail_modal_body');
                            $('#viewUserLogModal').modal('show');
                        }
                    },
                });
            }

            $('#export').click(function(){
                console.log('export click');

                $('#export_user_id').val($('#user_id').val());
                $('#export_std').val($('#std').val());
                $('#export_end').val($('#end').val());
                $('#export_sr_event').val($('#sr_event').val());
                $('#export_sr_module').val($('#sr_module').val());
                $('#export_sr_id').val($('#sr_id').val());
                $('#export_sr_text').val($('#sr_text').val());
                $('#export_sr_update').val($('#sr_update').val());
                $('#export_form').submit();
            });

            $('#chk_all').click(function() {
                if($(this).prop('checked') == true){
                    $('.chkItemChild').prop('checked', true);
                } else {
                    $('.chkItemChild').prop('checked', false);
                }
            });

            $('.chkItemChild').click(function() {
                var checkedItemCount = $(".chkItemChild:checked").length;
                var itemCount = $(".chkItemChild").length;

                if(checkedItemCount > 0) {
                    if(checkedItemCount == itemCount){
                        $('#chk_all').prop('indeterminate', false);
                        $('#chk_all').prop('checked', true);
                    } else {
                        $('#chk_all').prop('indeterminate', true);
                    }
                } else {
                    $('#chk_all').prop('indeterminate', false);
                    $('#chk_all').prop('checked', false);
                }
            });

            $('#delete_selected').click(function() {
                console.log('slected');

                var checkedItem = $(".chkItemChild:checked");
                var auditIdArr = [];
                console.log(checkedItem);

                if(checkedItem.length > 0) {
                    checkedItem.each(function() {
                        auditIdArr.push($(this).val());
                    });
                    console.log(auditIdArr);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to delete? This can't be reverted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete!'
                    }).then((result) => {
                        if (result.value) {
                            deleteAudits(auditIdArr, null, null, null, null, 'selected');
                        }
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Please select at least one item!',
                        'error'
                    )
                }
            });

            $('#delete_filtered').click(function() {
                var fltUserId = $('#user_id').val();
                var fltStd = $('#std').val();
                var fltEnd = $('#end').val();
                var fltSrText = $('#sr_text').val();

                if(fltStd == ''){
                    Swal.fire(
                        'Error!',
                        'Please Select Start Date!',
                        'error'
                    );
                    return false;
                }

                if(fltEnd == ''){
                    Swal.fire(
                        'Error!',
                        'Please Select End Date!',
                        'error'
                    );
                    return false;
                }

                Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to delete? This can't be reverted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete!'
                    }).then((result) => {
                        if (result.value) {
                            deleteAudits([], fltUserId, fltStd, fltEnd, fltSrText, 'filtered');
                        }
                    });

            });

            function deleteAudits(auditIdArr, fltUserId, fltStd, fltEnd, fltSrText, actionType)
            {
                console.log(auditIdArr);
                console.log(fltUserId);
                console.log(fltStd);
                console.log(fltEnd);
                console.log(fltSrText);
                console.log(actionType);

                $.ajax({
                    url:"{{ url('user_log/delete') }}",
                    method:"POST",
                    dataType:"json",
                    data:{
                        'audit_ids':auditIdArr,
                        'action_type':actionType,
                        'user_id':fltUserId,
                        'start_date':fltStd,
                        'end_date':fltEnd,
                        'search_text':fltSrText,
                        '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn();
                    },
                    success: function (response) {
                        console.log(response);
                        if(response.response == 'success'){
                            location.reload();
                        } else {
                            $(".se-pre-con").fadeOut();
                            Swal.fire(
                                response.title,
                                response.message,
                                response.response
                            )
                        }
                    }
                })
            }

            //form validation
            function validateForm(form) {
                var isValid = new Boolean();
                isValid = true;

                var elems = $(form).find(':input');
                $.each(elems, function() {
                    var elem = $(this);

                    if (typeof $(elem).attr('required') != typeof undefined && $(elem).attr('required') != "false" && $(
                            elem).val().trim() == "") {
                        Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: $(elem).attr('data-empty-message'),
                            })
                            .then((value) => {
                                $("#" + $(elem).attr('data-focus')).focus();
                            });
                        isValid = false;

                        return false;
                    }
                });

                return isValid;
            }
        </script>

@endsection
