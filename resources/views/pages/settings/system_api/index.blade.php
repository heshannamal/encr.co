@extends('layouts.app', ['activePage' => 'system_api', 'titlePage' => __('API Settings')])

@section('content')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>

    .se-pre-con {
        position: fixed;
        display: none;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .btn-green-filled{
        outline: unset !important;
        padding: 8px;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
    }
    .card{
        border: none;
        border-radius: 0rem;
    }
    .header-style{
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }

    .togelcheck {
        position: relative;
        width: 20px;
        height: 10px;
        -webkit-appearance: none;
        background: #c6c6c6;
        outline: none;
        border-radius: 20px;
        box-shadow: inset 0 0 5px rgba(255, 0, 0, 0.2);
        transition: 0.7s;
    }

    .togelcheck:checked[type="checkbox"] {
    background: #03a9f4;
    }

    .togelcheck:before {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 20px;
        top: 0;
        left: 0;
        background: #ffffff;
        transform: scale(1.1);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: .5s;
    }

    .togelcheck:checked[type="checkbox"]:before {
        left: 10px;
    }
    .new-style-table table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .new-style-table table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .new-style-table table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .new-style-table table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
        border-top: 1px solid #e9ecef !important;
    }
    .new-style-table table tbody tr:hover{
        background-color: #f6f6ff;
    }
    .new-style-table th, .new-style-table td {
        padding: 10px;
        vertical-align: middle !important;
    }
    .new-style-table .dataTables_info {
        color:#b3b3b3;
    }
    .new-style-table .alphabet {
        padding-right: 1rem;
        padding-left: 1rem;
    }
    .new-style-table table thead tr{
        background-color: rgba(50, 50, 50, 1) !important;
        height: 40px;
    }
    .new-style-table .table tbody td , .new-style-table .table tbody td a {
        padding: 0.4rem 1rem !important;
        font-size: .9rem !important;
        color: rgba(22, 22, 23, 1) !important;
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
    .btn-green-generate {
        outline: unset !important;
        padding: 7px;
        color: white;
        background-color: #47d670;
        border: 2px solid #47d670;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        border-radius: 6px;
    }
    .btn-info-copy {
        outline: unset !important;
        padding: 6px 20px;
        color: white;
        background-color: #47caea;
        border: 2px solid #47caea;
        font-weight: 700;
        cursor: pointer;
        border-radius: 6px;
    }
</style>

<div class="container-fluid mb-5 content-position" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>API Settings</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="row m-1">
                <div class="col">
                        {{-- <div class="m-1">
                            <input type="checkbox" class="togelcheck" />
                          </div> --}}
                </div>
                <div class="col d-flex justify-content-end">
                    @can('manage system api')
                        <button type="button" class="btn-green-filled mt-2" data-toggle="modal" data-target="#AddAPIModal">
                            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD NEW API
                        </button>
                    @endcan
                </div>

            </div>

            <div class="col-md-12 mt-2" style="padding-right: 19px;">
                <div class="new-style-table">
                    <table class="table align-items-center cell-border" id="system_api_table" style="width:100%;">
                        <thead class="header-style">
                            <th style="color: white"></th>
                            <th style="color: white">Name</th>
                            <th class="text-center" style="color: white">Key</th>
                            <th class="text-center" style="color: white">Token</th>
                            <th style="color: white">Description</th>
                            <th class="text-center" style="color: white">Actions</th>
                        </thead>

                        <tbody id="system_api_table_tbody"></tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>

@can('create system api')
    @include('pages.settings.system_api.create')
@endcan
@can('edit system api')
    @include('pages.settings.system_api.edit')
@endcan
@include('pages.settings.system_api.view_api_token')

<!-- Quill JS -->
{{-- <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script> --}}
<script>
    $(document).ready(function() {
        $('#system_api_table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            responsive: true,
            autoWidth: true,
            columnDefs: [
                { targets: 0, className: 'text-center', orderable: false },
                { targets: 2, className: 'text-center' },
                { targets: 3, className: 'text-center', orderable: false },
                { targets: 5, className: 'text-center', orderable: false },
                {
                    targets: 4,
                    render: function (data, type, row) {
                        if (typeof data === 'string' && data.length > 130) {
                            return data.substring(0, 30) + '...';
                        }
                        return data;
                    }
                }
            ],
            pageLength: 10,
            lengthChange: true
        });
        get_template_data();
        function get_template_data(){

            $.ajax({
                url: "{{ route('system_api.get_table_data') }}",
                type: 'get',
                dataType: 'json',
                beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                success: function(response) {
                    update_system_api_table(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function update_system_api_table(templates){
             var table = $('#system_api_table').DataTable(); // Get DataTable instance
            table.clear().draw(); // Clear existing data while keeping DataTable active

            if (!templates || templates.length == 0) {
                // Instead of adding a custom row, let DataTables handle the "No data available" message
                table.draw();
                $(".se-pre-con").fadeOut('slow');
                return;
            }



            $.each(templates, function(index, template) {
                var checked = template.is_active == 1 ? 'checked' : '';

                var row = [
                    `<input type="checkbox" class="togelcheck changeStatus" data-id="${template.id}" ${checked} />`,
                    template.name,
                    template.api_type_key,
                    `<span class="view_token" data-token="${template.api_token}"><i class="fa fa-file-code-o" style="color:#3a82ad;cursor:pointer"></i><span  class="mx-1" style="color:#3a82ad;cursor:pointer">view</span></span>`,
                    template.description,
                    `<span class="edit_api" data-id="${template.id}"><i class="fa-solid fa-pen-to-square" style="color:#3bad3a;cursor:pointer"></i><span class="mx-1" style="color:#3bad3a;cursor:pointer">edit</span></span>
                    <button type="button" class="btn btn-sm delete_api ml-2" value="${template.id}"><i class="fa-solid fa-trash" style="color:#d74e4e;cursor:pointer"></i></button>`,
                ];

                table.row.add(row);
            });

            table.draw(); // Redraw table with new data
            $(".se-pre-con").fadeOut('slow');
            // Attach change event to checkboxes after table draw
            $('#system_api_table').off('change', '.changeStatus').on('change', '.changeStatus', function () {
                var templateId = $(this).data('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;

                // Send AJAX to update template status
                $.ajax({
                    url: "{{ url('system_api/update') }}/"+templateId, // Adjust route accordingly
                    method: 'POST',
                    data: {
                        is_active: isChecked,
                        is_json: true,
                        _token: $('meta[name="csrf-token"]').attr('content') // if CSRF is needed
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {
                        console.log(response.message);
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function (xhr) {
                        alert('Failed to update status');
                        let errorMsg = "Failed to update status";
                        if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        console.log(errorMsg);
                    }
                });
            });

            $('#system_api_table').off('click', '.edit_api').on('click', '.edit_api', function () {
                var templateId = $(this).data('id');

                $.ajax({
                    url:`{{ url('system_api/edit')}}/${templateId}`,
                    method: 'GET',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $('#edit_name').val(data.name);
                        $('#edit_api_type_key').val(data.api_type_key);
                        $('#edit_api_token').val(data.api_token);
                        $('#edit_description').val(data.description);
                        $('#edit_status').val(data.title);
                        $('#edit_description').val(data.description);
                        $('#edit_status').val(data.is_active);

                        // Set form action for update
                        $('#editAPIForm').attr('action', `{{ url('system_api/update')}}/${data.id}`);

                        // Show the modal
                        $('#EditAPIModal').modal('show');
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function () {
                        alert('Failed to load template data');
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            });

            $('#system_api_table').off('click', '.view_token').on('click', '.view_token', function () {
                var apiToken = $(this).data('token');
                $('#view_api_token').val(apiToken);
                $('#viewAPITokenModal').modal('show');
            });

            $('#system_api_table').off('click', '.delete_api').on('click', '.delete_api', function () {
                var apirow = $(this);
                var apiId = apirow.val();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:`{{ url('system_api/delete')}}/${apiId}`,
                            method: 'GET',
                            beforeSend: function () {
                                $(".se-pre-con").fadeIn('slow');
                            },
                            success: function (data) {
                                if(data.response == 'success'){
                                    apirow.closest('tr').fadeOut(function(){ $(this).remove(); });
                                }
                                $(".se-pre-con").fadeOut();
                                Swal.fire({
                                    type: data.response,
                                    title: data.title,
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            },
                            error: function (xhr) {
                                let errorMsg = "Failed to delete API";
                                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }
                                console.log(errorMsg);
                                $(".se-pre-con").fadeOut();
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error!',
                                    text: 'Failed to delete API',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });
            });
        }

        $('.generate-api-token').click(function(){
            var targetInput = $(this).data('for');
            $('#'+targetInput).val(generateApiToken());
        });

        $('#copy_api_token').click(function(){
            var targetApiToken = $('#view_api_token').val();
            navigator.clipboard.writeText(targetApiToken).then(function() {
                Swal.fire({
                    type: 'success',
                    title: 'Copied!',
                    text: 'API token has been copied to clipboard.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }, function(err) {
                Swal.fire({
                    type: 'error',
                    title: 'Error!',
                    text: 'API token has not been copied to clipboard.',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    });

    function generateApiToken(length = 40) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let token = '';
        for (let i = 0; i < length; i++) {
            token += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return token;
    }

</script>
@endsection
