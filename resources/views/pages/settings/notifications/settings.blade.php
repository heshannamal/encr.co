@extends('layouts.app', ['activePage' => 'Notification_settings', 'titlePage' => __('Notification Settings')])

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


    /* Notification users modal - reference layout */
    #EditTemplateusersModal {
        padding-right: 0 !important;
    }

    #EditTemplateusersModal .modal-dialog {
        width: calc(100% - 54px);
        margin: 34px auto;
    }

    #EditTemplateusersModal .modal-content {
        max-height: calc(100vh - 100px);
        overflow: hidden;
        border: 0;
        border-radius: 6px;
        box-shadow: 0 7px 28px rgba(0, 0, 0, 0.18);
    }

    #EditTemplateusersModal .modal-header {
        min-height: 58px;
        padding: 17px 20px 12px;
        border-bottom: 0;
    }

    #EditTemplateusersModal .modal-title {
        color: #263457;
        font-size: 14px;
        font-weight: 600;
    }

    #EditTemplateusersModal .modal-header .close {
        margin: -6px -4px -6px auto;
        padding: 8px;
        color: #8b8b8b;
        font-size: 22px;
        line-height: 1;
        opacity: .7;
    }

    #EditTemplateusersModal .modal-header .close:hover {
        opacity: 1;
    }

    #EditTemplateusersModal .modal-body {
        max-height: calc(100vh - 175px);
        padding: 10px 22px 20px;
        overflow-x: hidden;
        overflow-y: auto;
    }

    #EditTemplateusersModal #notificationUsersContainer > .col-md-12 {
        padding-right: 0;
        padding-left: 0;
    }

    .notification-user-card {
        margin-bottom: 16px !important;
        overflow: hidden;
        border: 1px solid #e4e7eb !important;
        border-radius: 5px !important;
        background: #fff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.025);
    }

    .notification-user-card .card-header {
        min-height: 35px;
        padding: 6px 5px 6px 2px;
        background: #fff;
        border-bottom: 0;
    }

    .notification-user-card .card-header strong {
        color: #111;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.2;
    }

    .notification-user-card .card-header label {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #111;
        font-size: 13px;
        font-weight: 400;
        white-space: nowrap;
    }

    .notification-user-card .card-header input[type="checkbox"] {
        width: 13px;
        height: 13px;
        margin: 0;
    }

    .notification-user-card .card-body {
        padding: 12px 14px;
        border-top: 1px solid #edf0f2;
        background: #fff;
    }

    .toggle-notification-card {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        min-width: 20px;
        height: 20px;
        margin-left: 8px;
        padding: 0 !important;
        border: 0 !important;
        color: #111 !important;
        text-decoration: none !important;
        box-shadow: none !important;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
    }

    .toggle-notification-card:hover,
    .toggle-notification-card:focus {
        color: #111 !important;
        text-decoration: none !important;
        background: transparent !important;
        box-shadow: none !important;
    }

    .collapse-symbol {
        display: block;
        transform: translateY(-1px);
    }

    .all-selected-users-card {
        margin-bottom: 17px !important;
        border-color: #d8e2f5 !important;
        border-radius: 7px !important;
        box-shadow: none;
    }

    .all-selected-users-card .card-header {
        min-height: 53px;
        padding: 13px 16px;
        background: #edf3ff;
    }

    .all-selected-users-card .card-header strong {
        display: inline-flex;
        align-items: center;
        gap: 11px;
    }

    .selected-recipient-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 25px;
        padding: 0 8px;
        border-radius: 999px;
        background: #304b82;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        line-height: 1;
    }

    .all-selected-users-card .card-body {
        padding: 13px 16px;
        border-top-color: #d8e2f5;
    }

    .selected-user-row {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 32px;
        margin-bottom: 3px;
    }

    .selected-user-row:last-child {
        margin-bottom: 0;
    }

    .selected-user-row input[type="checkbox"] {
        width: 14px;
        height: 14px;
        margin: 0;
    }

    .selected-user-name {
        margin: 0;
        color: #111;
        font-size: 14px;
        font-weight: 400;
    }

    .selected-users-empty {
        padding: 4px 0;
        color: #6c757d;
        font-size: 14px;
    }


    /* Two selected entries per row in the summary card */
    #allSelectedUsersContainer {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 7px 10px;
    }

    #allSelectedUsersContainer .selected-user-row {
        min-height: 38px;
        margin-bottom: 0;
        padding: 6px 9px;
        border: 1px solid #e6ebf2;
        border-radius: 5px;
        background: #fff;
    }

    #allSelectedUsersContainer .selected-users-empty {
        grid-column: 1 / -1;
    }

    #EditTemplateusersModal .modal-footer {
        margin: 18px -22px -20px;
        padding: 12px 22px;
        border-top: 1px solid #eceff2;
        background: #fff;
    }

    @media (max-width: 767.98px) {
        #EditTemplateusersModal .modal-dialog {
            width: calc(100% - 20px);
            margin: 10px auto;
        }

        #EditTemplateusersModal .modal-content {
            max-height: calc(100vh - 20px);
        }

        #EditTemplateusersModal .modal-body {
            max-height: calc(100vh - 78px);
            padding-right: 12px;
            padding-left: 12px;
        }

        #allSelectedUsersContainer {
            grid-template-columns: 1fr;
        }

        .notification-user-card .card-header {
            padding-left: 7px;
        }
    }

</style>

<div class="container-fluid mb-5 content-position" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Notification Settings</span>
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
                    <button type="button" class="btn-green-filled mt-2" data-toggle="modal" data-target="#AddTemplateModal">
                        <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;ADD TEMPLATE
                    </button>
                </div>

            </div>

            <div class="col-md-12 mt-2" style="padding-right: 19px;">
                <div class=" new-style-table">
                    <table class="table align-items-center cell-border table-responsive" id="notification_groups_table" style="width:100%;">
                        <thead class="header-style">
                            <th  style="color: white"></th>
                            <th  style="color: white">Name</th>
                            <th  style="color: white">Key</th>
                            <th  style="color: white">function Name</th>
                            <th  style="color: white">Controller</th>
                            <th  style="color: white">Users</th>
                            <th  style="color: white">Title</th>
                            <th  style="color: white">Modal Title</th>
                            <th  style="color: white">Notification Body</th>
                            <th  style="color: white">Description</th>
                            <th  style="color: white">Actions</th>
                        </thead>

                        <tbody id="notification_groups_table_tbody"></tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="AddTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Notification</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('notification_templates.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="function_name">Notification Key</label>
                    <input type="text" class="form-control" name="notification_key" id="notification_key" required>
                </div>
                <div class="form-group">
                    <label for="function_name">Notification Name</label>
                    <input type="text" class="form-control" name="notification_name" id="notification_name" required>
                </div>
                <div class="form-group">
                    <label for="function_name">Function Name</label>
                    <input type="text" class="form-control" name="function_name" id="function_name" required>
                </div>
                <div class="form-group">
                    <label for="controller">Controller</label>
                    <input type="text" class="form-control" name="controller" id="controller" required>
                </div>
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" name="title" id="title" required>
                </div>
                <div class="form-group">
                    <small class="form-text text-muted">
                        Common modal header title to use this field
                    </small>
                  <label for="title">Modal Title</label>
                  <input type="text" class="form-control" name="modal_title" id="modal_title" required>
                </div>
                <div class="form-group">
                    <label for="notification_body">Notification Body</label>
                    <div id="quill_editor" style="height: 150px;"></div>
                    <input type="hidden" name="notification_body" id="notification_body">
                </div>
                <div class="form-group">
                    <small class="form-text text-muted">
                        Common modal footer to use this field
                    </small>
                    <label for="modal_footer">Modal Footer</label>
                    <textarea class="form-control" id="modal_footer" name="modal_footer" rows="8"></textarea>
                </div>
                <div class="form-group">
                    <label for="modal_route">Confirm Route</label>
                    <small class="form-text text-muted">
                        Confirm route to use this field
                    </small>
                    <input type="text" class="form-control" name="confirm_route" id="confirm_route">
                </div>
                <div class="form-group">
                    <label for="modal_route">Reject Route</label>
                    <small class="form-text text-muted">
                        Reject route to use this field
                    </small>
                    <input type="text" class="form-control" name="reject_route" id="reject_route">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="description">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
          <button type="submit" class="btn btn-primary">Create Template</button>
            </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Edit Template Modal -->
<div class="modal fade" id="EditTemplateModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Notification</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editTemplateForm" method="POST">
              @csrf
              <input type="hidden" name="id" id="edit_template_id">
              <div class="form-group">
                  <label for="edit_notification_keylbl">Notification Key</label>
                  <input type="text" class="form-control" name="notification_key" id="edit_notification_key" required>
              </div>
              <div class="form-group">
                   <label for="function_name">Notification Name</label>
                   <input type="text" class="form-control" name="notification_name" id="edit_notification_name" required>
              </div>
              <div class="form-group">
                  <label for="edit_function_name">Function Name</label>
                  <input type="text" class="form-control" name="function_name" id="edit_function_name" required>
              </div>
              <div class="form-group">
                  <label for="edit_controller">Controller</label>
                  <input type="text" class="form-control" name="controller" id="edit_controller" required>
              </div>
              <div class="form-group">
                  <label for="edit_title">Title</label>
                  <input type="text" class="form-control" name="title" id="edit_title" required>
              </div>
                <div class="form-group">
                    <small class="form-text text-muted">
                        Common modal header title to use this field
                    </small>
                    <label for="title">Modal Title</label>
                    <input type="text" class="form-control" name="modal_title" id="edit_modal_title" required>
                </div>
              <div class="form-group">
                  <label for="edit_notification_body_lbl">Notification Body</label>
                  <div id="quill_editor_edit" style="height: 150px;"></div>
                    <input type="hidden" name="notification_body" id="edit_notification_body">
              </div>
              <div class="form-group">
                    <small class="form-text text-muted">
                        Common modal footer to use this field
                    </small>
                    <label for="modal_footer">Modal Footer</label>
                    <textarea class="form-control" id="edit_modal_footer" name="modal_footer" rows="8" required></textarea>
                </div>
                <div class="form-group">
                    <label for="modal_route">Confirm Route</label>
                    <small class="form-text text-muted">
                        Confirm route to use this field
                    </small>
                    <input type="text" class="form-control" name="confirm_route" id="edit_confirm_route">
                </div>
                <div class="form-group">
                    <label for="modal_route">Reject Route</label>
                    <small class="form-text text-muted">
                        Reject route to use this field
                    </small>
                    <input type="text" class="form-control" name="reject_route" id="edit_reject_route">
                </div>
              <div class="form-group">
                  <label for="edit_description">Description</label>
                  <input type="text" class="form-control" name="description" id="edit_description">
              </div>
              <div class="form-group">
                  <label for="edit_status">Status</label>
                  <select name="status" id="edit_status" class="form-control">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                  </select>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Update Template</button>
        </div>
        </form>
      </div>
    </div>
  </div>


   <!-- Edit Template users Modal -->
<div class="modal fade" id="EditTemplateusersModal" tabindex="-1" role="dialog" aria-labelledby="editNotificationUsersModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editNotificationUsersModalLabel">Edit Notification Users</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('notification_template.toggleUser') }}" method="POST">
                @csrf
            <div id="notificationUsersContainer"></div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Update </button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    $(document).ready(function() {
        var quill = new Quill('#quill_editor', {
        theme: 'snow'
        });
        var quill_edit = new Quill('#quill_editor_edit', {
        theme: 'snow'
        });

        // On form submit, copy HTML from Quill to the hidden input
        document.querySelector('#AddTemplateModal form').addEventListener('submit', function(e) {
            document.querySelector('#notification_body').value = quill.root.innerHTML;
        });
        document.querySelector('#editTemplateForm').addEventListener('submit', function(e) {
            document.querySelector('#edit_notification_body').value = quill_edit.root.innerHTML;
        });
        $('#notification_groups_table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            responsive: true,
            autoWidth: true,
            columnDefs: [
                { targets: 0, className: 'text-center' },
                { targets: 2, className: 'text-left' },
                { targets: 3, className: 'text-center', orderable: false },
                {targets: 7, className: 'notification-body-cell'},
                {
                    targets: [6,7,8], // 6th column (0-based index)
                    render: function (data, type, row) {
                        if (typeof data === 'string' && data.length > 20) {
                            return data.substring(0, 20) + '...';
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
                url: "{{ route('notification.get_table_data') }}",
                type: 'get',
                dataType: 'json',
                beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                success: function(response) {
                    console.log(response);
                    update_notification_groups_table(response.templates);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        function update_notification_groups_table(templates){
             var table = $('#notification_groups_table').DataTable(); // Get DataTable instance
            table.clear().draw(); // Clear existing data while keeping DataTable active

            if (!templates || templates.length == 0) {
                // Instead of adding a custom row, let DataTables handle the "No data available" message
                table.draw();
                $(".se-pre-con").fadeOut('slow');
                return;
            }



            $.each(templates, function(index, template) {
                var checked = template.status == 1 ? 'checked' : '';

                var row = [
                    `<input type="checkbox" class="togelcheck changeStatus" data-id="${template.id}" ${checked} />`,
                    template.name,
                    template.template_key,
                    template.function_name,
                    template.controller,
                    `<span class="view_users" data-id="${template.id}"><i class="fa-solid fa-users" style="color:#3a82ad;cursor:pointer"></i><span  class="mx-1" style="color:#3a82ad;cursor:pointer">view</span></span>`,
                    template.title,
                    template.modal_title,
                    template.notification_body,
                    template.description,
                    `<span class="edit_template" data-id="${template.id}"><i class="fa-solid fa-pen-to-square" style="color:#3bad3a;cursor:pointer"></i><span class="mx-1" style="color:#3bad3a;cursor:pointer">edit</span></span>`,
                ];

                table.row.add(row);
            });

            table.draw(); // Redraw table with new data
            $(".se-pre-con").fadeOut('slow');
            // Attach change event to checkboxes after table draw
            $('#notification_groups_table').off('change', '.changeStatus').on('change', '.changeStatus', function () {
                var templateId = $(this).data('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;

                // Send AJAX to update template status
                $.ajax({
                    url: "{{ route('notification_templates.change_status') }}", // Adjust route accordingly
                    method: 'POST',
                    data: {
                        id: templateId,
                        status: isChecked,
                        _token: $('meta[name="csrf-token"]').attr('content') // if CSRF is needed
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {
                        console.log('Status updated successfully');
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function () {
                        alert('Failed to update status');
                    }
                });
            });
            /*
             * Role select-all.
             */
            $('#notificationUsersContainer')
                .off('change.notificationSelectGroup', '.select-group')
                .on('change.notificationSelectGroup', '.select-group', function () {
                    const roleId = String($(this).data('role-id'));
                    const isChecked = $(this).is(':checked');

                    $(
                        `.role-user-checkbox[data-role-id="${roleId}"]`
                    ).each(function () {
                        $(this)
                            .prop('checked', isChecked)
                            .trigger('change.notificationUser');
                    });
                });

            /*
             * Open the user-selection modal.
             */
            $('#notification_groups_table')
                .off('click', '.view_users')
                .on('click', '.view_users', function () {
                    const templateId = $(this).data('id');

                    $.ajax({
                        url: `{{ url('notification_template/users') }}/${templateId}`,
                        method: 'GET',

                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },

                        success: function (data) {
                            renderUsersModal(
                                data.groups || [],
                                data.selectedUsers || [],
                                data.template_id,
                                data.template || {}
                            );

                            $('#EditTemplateusersModal').modal('show');
                            $(".se-pre-con").fadeOut('slow');
                        },

                        error: function () {
                            alert('Failed to load template data');
                            $(".se-pre-con").fadeOut('slow');
                        }
                    });
                });

            function escapeNotificationHtml(value) {
                return $('<div>')
                    .text(value == null ? '' : String(value))
                    .html();
            }

            function renderUsersModal(groups, selectedUsers, templateID, template) {
                const container = $('#notificationUsersContainer');
                const selectedUserIds = (selectedUsers || []).map(String);
                const notificationName = String(
                    template.name || template.notification_name || ''
                ).trim();

                $('#editNotificationUsersModalLabel').text(
                    notificationName
                        ? `Edit Notification Users for ${notificationName}`
                        : 'Edit Notification Users'
                );

                container.empty();
                container.append(`
                    <input
                        type="hidden"
                        value="${escapeNotificationHtml(templateID)}"
                        name="Template_id"
                    >
                `);

                /*
                 * This card is updated from every checked role-user checkbox.
                 */
                container.append(`
                    <div class="col-md-12">
                        <div class="card mb-3 notification-user-card all-selected-users-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <strong>
                                    <span>All Selected Users and Options</span>
                                    <span
                                        id="selectedUsersCount"
                                        class="selected-recipient-count"
                                    >0</span>
                                </strong>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                                    aria-expanded="true"
                                    title="Collapse selected users"
                                >
                                    <span class="collapse-symbol">−</span>
                                </button>
                            </div>

                            <div
                                class="card-body collapsible-card-body"
                                id="allSelectedUsersContainer"
                            ></div>
                        </div>
                    </div>
                `);

                groups.forEach(function (group) {
                    const roleId = String(group.id);
                    const roleName = escapeNotificationHtml(group.name || 'Users');
                    const users = Array.isArray(group.users) ? group.users : [];

                    let cardHtml = `
                        <div class="col-md-12">
                            <div class="card mb-3 notification-user-card role-users-card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <strong>${roleName}</strong>

                                    <div class="d-flex align-items-center">
                                        <label class="mb-0 mr-3">
                                            <input
                                                type="checkbox"
                                                class="select-group"
                                                data-role-id="${escapeNotificationHtml(roleId)}"
                                            >
                                            Select All
                                        </label>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                                            aria-expanded="false"
                                        >
                                            <span class="collapse-symbol">+</span>
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="card-body collapsible-card-body"
                                    style="display:none;"
                                >
                    `;

                    users.forEach(function (user) {
                        const userId = String(user.id);
                        const userName = user.name || `User #${userId}`;
                        const isChecked = selectedUserIds.includes(userId)
                            ? 'checked'
                            : '';

                        cardHtml += `
                            <div class="form-check mb-2">
                                <input
                                    class="form-check-input select-user role-user-checkbox"
                                    type="checkbox"
                                    value="${escapeNotificationHtml(userId)}"
                                    data-role-id="${escapeNotificationHtml(roleId)}"
                                    data-user-id="${escapeNotificationHtml(userId)}"
                                    data-user-name="${escapeNotificationHtml(userName)}"
                                    data-template_id="${escapeNotificationHtml(templateID)}"
                                    name="user_ids[]"
                                    id="user_${escapeNotificationHtml(roleId)}_${escapeNotificationHtml(userId)}"
                                    ${isChecked}
                                >

                                <label
                                    class="form-check-label"
                                    for="user_${escapeNotificationHtml(roleId)}_${escapeNotificationHtml(userId)}"
                                >
                                    ${escapeNotificationHtml(userName)}
                                </label>
                            </div>
                        `;
                    });

                    cardHtml += `
                                </div>
                            </div>
                        </div>
                    `;

                    container.append(cardHtml);
                });

                const orderProcessingRepChecked =
                    parseInt(template.proccessing_rep || 0) === 1
                        ? 'checked'
                        : '';

                const salesRepChecked =
                    parseInt(template.sales_rep || 0) === 1
                        ? 'checked'
                        : '';

                const relatedFactoriesChecked =
                    parseInt(template.related_fac || 0) === 1
                        ? 'checked'
                        : '';

                container.append(`
                    <div class="col-md-12">
                        <div class="card mb-3 notification-user-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <strong>Other Options</strong>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                                    aria-expanded="false"
                                >
                                    <span class="collapse-symbol">+</span>
                                </button>
                            </div>

                            <div
                                class="card-body collapsible-card-body"
                                style="display:none;"
                            >
                                <div class="form-check mb-2">
                                    <input
                                        class="form-check-input notification-summary-option"
                                        type="checkbox"
                                        name="OrderProssingRep"
                                        data-summary-key="option-order-processing-rep"
                                        data-summary-name="Order Processing Rep"
                                        id="notificationOrderProcessingRep"
                                        ${orderProcessingRepChecked}
                                    >
                                    <label
                                        class="form-check-label"
                                        for="notificationOrderProcessingRep"
                                    >
                                        Order Processing Rep
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input
                                        class="form-check-input notification-summary-option"
                                        type="checkbox"
                                        name="salesRep"
                                        data-summary-key="option-sales-rep"
                                        data-summary-name="Sales Rep"
                                        id="notificationSalesRep"
                                        ${salesRepChecked}
                                    >
                                    <label
                                        class="form-check-label"
                                        for="notificationSalesRep"
                                    >
                                        Sales Rep
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input
                                        class="form-check-input notification-summary-option"
                                        type="checkbox"
                                        name="Related_Factories"
                                        data-summary-key="option-related-factories"
                                        data-summary-name="Send Order Related Factories' Users"
                                        id="notificationRelatedFactories"
                                        ${relatedFactoriesChecked}
                                    >
                                    <label
                                        class="form-check-label"
                                        for="notificationRelatedFactories"
                                    >
                                        Send Order Related Factories' Users
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                `);

                updateAllRoleSelectCheckboxes();
                renderAllSelectedUsers();
            }

            function updateRoleSelectCheckbox(roleId) {
                if (!roleId) {
                    return;
                }

                const users = $(
                    `.role-user-checkbox[data-role-id="${roleId}"]`
                );

                const checkedUsers = users.filter(':checked').length;
                const allChecked =
                    users.length > 0 && checkedUsers === users.length;

                $(`.select-group[data-role-id="${roleId}"]`)
                    .prop('checked', allChecked)
                    .prop('indeterminate', checkedUsers > 0 && !allChecked);
            }

            function updateAllRoleSelectCheckboxes() {
                $('.select-group').each(function () {
                    updateRoleSelectCheckbox(
                        String($(this).data('role-id'))
                    );
                });
            }

            function renderAllSelectedUsers() {
                const summaryContainer = $('#allSelectedUsersContainer');

                if (!summaryContainer.length) {
                    return;
                }

                const selectedItems = {};

                /* Selected role users. */
                $('.role-user-checkbox:checked').each(function () {
                    const userId = String($(this).data('user-id'));
                    const key = `user-${userId}`;

                    if (!selectedItems[key]) {
                        selectedItems[key] = {
                            key: key,
                            type: 'user',
                            id: userId,
                            name: $(this).data('user-name') || `User #${userId}`
                        };
                    }
                });

                /* Other Options. */
                $('.notification-summary-option:checked').each(function () {
                    const optionKey = String($(this).data('summary-key') || $(this).attr('name'));
                    const optionName = String($(this).data('summary-name') || optionKey);

                    selectedItems[optionKey] = {
                        key: optionKey,
                        type: 'option',
                        id: optionKey,
                        name: optionName
                    };
                });

                const rows = Object.values(selectedItems).sort(function (a, b) {
                    return String(a.name).localeCompare(String(b.name));
                });

                $('#selectedUsersCount').text(rows.length);

                if (!rows.length) {
                    summaryContainer.html(`
                        <div class="selected-users-empty">
                            No users or options selected.
                        </div>
                    `);
                    return;
                }

                let html = '';

                rows.forEach(function (item) {
                    html += `
                        <div class="selected-user-row">
                            <input
                                type="checkbox"
                                class="selected-user-summary-checkbox"
                                data-summary-type="${escapeNotificationHtml(item.type)}"
                                data-summary-key="${escapeNotificationHtml(item.key)}"
                                data-user-id="${item.type === 'user' ? escapeNotificationHtml(item.id) : ''}"
                                checked
                            >

                            <label class="selected-user-name">
                                ${escapeNotificationHtml(item.name)}
                            </label>
                        </div>
                    `;
                });

                summaryContainer.html(html);
            }

            /* Refresh summary when an Other Option changes. */
            $('#notificationUsersContainer')
                .off('change.notificationSummaryOption', '.notification-summary-option')
                .on(
                    'change.notificationSummaryOption',
                    '.notification-summary-option',
                    function () {
                        renderAllSelectedUsers();
                    }
                );

            /*
             * Sync duplicate instances of the same user, update role
             * select-all states, and refresh the selected-users card.
             */
            $('#notificationUsersContainer')
                .off('change.notificationUser', '.role-user-checkbox')
                .on(
                    'change.notificationUser',
                    '.role-user-checkbox',
                    function () {
                        const userId = String($(this).data('user-id'));
                        const isChecked = $(this).is(':checked');

                        $(
                            `.role-user-checkbox[data-user-id="${userId}"]`
                        ).prop('checked', isChecked);

                        updateAllRoleSelectCheckboxes();
                        renderAllSelectedUsers();
                    }
                );

            /* Changing a summary item updates its original source. */
            $('#notificationUsersContainer')
                .off(
                    'change.notificationSummaryUser',
                    '.selected-user-summary-checkbox'
                )
                .on(
                    'change.notificationSummaryUser',
                    '.selected-user-summary-checkbox',
                    function () {
                        const summaryType = String($(this).data('summary-type') || 'user');
                        const summaryKey = String($(this).data('summary-key') || '');
                        const isChecked = $(this).is(':checked');

                        if (summaryType === 'option') {
                            $(`.notification-summary-option[data-summary-key="${summaryKey}"]`)
                                .prop('checked', isChecked)
                                .trigger('change.notificationSummaryOption');
                            return;
                        }

                        const userId = String($(this).data('user-id'));

                        $(`.role-user-checkbox[data-user-id="${userId}"]`)
                            .prop('checked', isChecked)
                            .first()
                            .trigger('change.notificationUser');
                    }
                );

            /*
             * Collapse or expand every user card.
             */
            $('#notificationUsersContainer')
                .off(
                    'click.notificationCardCollapse',
                    '.toggle-notification-card'
                )
                .on(
                    'click.notificationCardCollapse',
                    '.toggle-notification-card',
                    function (event) {
                        event.preventDefault();
                        event.stopPropagation();

                        const button = $(this);
                        const card = button.closest('.notification-user-card');
                        const cardBody = card.children(
                            '.collapsible-card-body'
                        );
                        const isExpanded =
                            button.attr('aria-expanded') === 'true';

                        cardBody.stop(true, true).slideToggle(180);
                        button.attr(
                            'aria-expanded',
                            isExpanded ? 'false' : 'true'
                        );
                        button
                            .find('.collapse-symbol')
                            .text(isExpanded ? '+' : '−');
                    }
                );

            $('#notification_groups_table').off('click', '.edit_template').on('click', '.edit_template', function () {
                var templateId = $(this).data('id');

                $.ajax({
                    url:`{{ url('notification_templates/edit')}}/${templateId}`,
                    method: 'GET',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $('#edit_template_id').val(data.id);
                        $('#edit_function_name').val(data.function_name);
                        $('#edit_notification_key').val(data.template_key);
                        $('#edit_notification_name').val(data.name);
                        $('#edit_title').val(data.title);
                        $('#edit_modal_title').val(data.modal_title);
                        $('#edit_controller').val(data.controller);
                        quill_edit.root.innerHTML = data.notification_body; // Be cautious with unescaped HTML

                        // $('#edit_notification_body').val(data.notification_body);
                        $('#edit_modal_footer').val(data.modal_footer);
                        $('#edit_confirm_route').val(data.confirm_route);
                        $('#edit_reject_route').val(data.reject_route);
                        $('#edit_description').val(data.description);
                        $('#edit_status').val(data.status);

                        // Set form action for update
                        $('#editTemplateForm').attr('action', `{{ url('notification_templates/update')}}/${data.id}`);

                        // Show the modal
                        $('#EditTemplateModal').modal('show');
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function () {
                        alert('Failed to load template data');
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            });

        }
    });


</script>
@endsection
