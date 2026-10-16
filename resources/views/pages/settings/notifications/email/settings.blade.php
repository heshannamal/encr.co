@extends('layouts.app', ['activePage' => 'NotificationEmail_settings', 'titlePage' => __('Notification Email Settings')])

@section('content')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
/>
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
.card-header {
    padding: 2px;
}
.specific-org-item {
    margin: 18px 0 24px 26px;
}

.specific-org-name {
    position: relative;
    margin-bottom: 14px;
    padding-left: 16px;
    font-size: 15px;
    font-weight: 600;
}

.specific-org-name::before {
    content: "•";
    position: absolute;
    left: 0;
    top: -3px;
    font-size: 22px;
}

.specific-org-users {
    margin-left: 18px;
}

.recipient-header,
.recipient-row {
    display: grid;
    grid-template-columns: 45px 45px 45px minmax(140px, 1fr);
    align-items: center;
    gap: 8px;
}

.recipient-header {
    margin-bottom: 10px;
    font-size: 13px;
}

.recipient-row {
    margin-bottom: 10px;
}

.recipient-row input[type="checkbox"] {
    margin: 0;
}

.recipient-row .row-label {
    font-size: 14px;
}
.org-user-card {
    border: 1.5px solid #324b7c;
    border-radius: 48px;
    padding: 2px;
    background: #fff;
    margin-bottom: 20px;
}

.org-user-card .org-card-title {
    font-size: 22px;
    font-weight: 700;
    color: #111;
    margin-bottom: 10px;
}

.org-user-card .org-divider {
    border-top: 1px solid #5b84ff;
    margin: 12px 0 22px;
}

.org-user-card .org-section-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 12px;
    color: #111;
}

.org-user-card .org-check-line {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
}

.org-user-card .org-check-line input[type="checkbox"] {
    margin-top: 0;
}

.org-user-card .recipient-header,
.org-user-card .recipient-row {
    display: grid;
    grid-template-columns: 46px 46px 46px 1fr;
    align-items: center;
    column-gap: 10px;
}

.org-user-card .recipient-header {
    margin-bottom: 10px;
    font-size: 14px;
    color: #111;
}

.org-user-card .recipient-row {
    margin-bottom: 12px;
}

.org-user-card .recipient-row label,
.org-user-card .recipient-row .row-label {
    margin: 0;
    font-size: 15px;
    color: #111;
}

.org-user-card .org-sub-block {
    margin-top: 10px;
    margin-bottom: 20px;
}

.org-user-card .org-sub-block.hidden {
    display: none;
}

.org-user-card .org-select-wrap {
    max-width: 420px;
}

.org-user-card .org-select-wrap .select2-container {
    width: 100% !important;
}

.org-user-card .specific-org-list {
    margin-top: 8px;
}

.org-user-card .specific-org-item {
    margin-bottom: 22px;
}

.org-user-card .specific-org-name {
    font-size: 15px;
    font-weight: 600;
    color: #111;
    margin-bottom: 12px;
    position: relative;
    padding-left: 16px;
}

.org-user-card .specific-org-name::before {
    content: "•";
    position: absolute;
    left: 0;
    top: -1px;
    font-size: 22px;
    line-height: 1;
    color: #111;
}

.org-user-card .specific-org-users {
    margin-left: 18px;
}

.org-user-card .toggle-notification-card {
    text-decoration: none !important;
    box-shadow: none !important;
}
#EditTemplateusersModal .select2-container {
    width: 100% !important;
}

#EditTemplateusersModal .select2-selection--multiple {
    min-height: 38px;
    border: 1px solid #aaa;
    border-radius: 2px;
}

#EditTemplateusersModal .select2-search__field {
    width: 100% !important;
}

.select2-container--open {
    z-index: 9999999 !important;
}

.select2-dropdown {
    z-index: 9999999 !important;
}

.select2-results__options {
    max-height: 250px !important;
    overflow-y: auto !important;
}

.select2-results__option {
    display: block !important;
    padding: 7px 10px;
}
/* Allow Select2 dropdown to extend outside the card/modal sections */


/* Select2 input */
#EditTemplateusersModal .select2-container {
    display: block !important;
    width: 100% !important;
}

#EditTemplateusersModal .select2-selection--multiple {
    display: block !important;
    min-height: 38px !important;
    border: 1px solid #aaa !important;
    background: #fff !important;
}

/* Force the organization dropdown to be visible */
.notification-org-dropdown {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;

    min-width: 250px !important;
    background: #fff !important;
    border: 1px solid #aaa !important;
    z-index: 99999999 !important;
}

.notification-org-dropdown .select2-results {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.notification-org-dropdown .select2-results__options {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;

    max-height: 250px !important;
    overflow-x: hidden !important;
    overflow-y: auto !important;

    margin: 0 !important;
    padding: 0 !important;
    background: #fff !important;
}

.notification-org-dropdown .select2-results__option {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;

    padding: 8px 12px !important;
    color: #222 !important;
    background: #fff !important;
    cursor: pointer !important;
}

.notification-org-dropdown
.select2-results__option--highlighted[aria-selected] {
    color: #fff !important;
    background: #5897fb !important;
}

.select2-container--open {
    z-index: 99999999 !important;
}
/* Keep Bootstrap modal scroll working */
#EditTemplateusersModal {
    overflow-x: hidden !important;
    overflow-y: auto !important;
}

#EditTemplateusersModal .modal-dialog {
    width: calc(100% - 30px);
    max-width: 800px;
    margin: 28px auto;
}

#EditTemplateusersModal .modal-content {
    max-height: calc(100vh - 90px);
    overflow: hidden !important;
    border-radius: 8px;
}

#EditTemplateusersModal .modal-header {
    padding: 12px 18px;
}

#EditTemplateusersModal .modal-title {
    font-size: 15px;
    font-weight: 600;
}

#EditTemplateusersModal .modal-body {
    overflow-x: visible !important;
    overflow-y: auto !important;
    max-height: calc(100vh - 180px);
    padding: 12px 16px;
}

#EditTemplateusersModal .modal-footer {
    padding: 10px 16px;
}

/* Select2 field */
#EditTemplateusersModal .select2-container {
    width: 100% !important;
}

/* Dropdown remains visible */
.select2-container--open {
    z-index: 99999999 !important;
}

.notification-org-dropdown {
    z-index: 99999999 !important;
    background: #fff !important;
}

.notification-org-dropdown .select2-results__options {
    max-height: 250px !important;
    overflow-y: auto !important;
}
.specific-organization-block {
    padding-bottom: 15px;
}



.specific-organization-title {
    margin-bottom: 14px;
    font-size: 14px;
    font-weight: 600;
    color: #111;
}

.specific-organization-dot {
    margin-right: 7px;
    font-size: 20px;
    line-height: 1;
}

.specific-organization-users {
    margin-left: 22px;
}

.specific-recipient-header,
.specific-recipient-row {
    display: grid;
    grid-template-columns: 45px 45px 45px minmax(130px, 1fr);
    align-items: center;
    column-gap: 8px;
}

.specific-recipient-header {
    margin-bottom: 10px;
    font-size: 13px;
    color: #111;
}

.specific-recipient-row {
    margin-bottom: 11px;
}

.specific-recipient-row input[type="checkbox"] {
    margin: 0;
}

.specific-customer-name {
    font-size: 14px;
    color: #111;
}
.specific-organization-list {
    margin-top: 18px;
}

.specific-organization-block {
    padding: 16px 18px;
    background: #fff;
}

.specific-organization-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e5e7eb;
}

.specific-organization-title {
    display: flex;
    align-items: center;
    font-size: 15px;
    font-weight: 600;
    color: #111;
}

.specific-organization-dot {
    margin-right: 8px;
    font-size: 21px;
    line-height: 1;
}

.remove-specific-organization {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    padding: 0;
    border: 0;
    border-radius: 50%;
    background: #f3f4f6;
    color: #dc3545;
    font-size: 21px;
    line-height: 1;
    cursor: pointer;
}

.remove-specific-organization:hover {
    background: #dc3545;
    color: #fff;
}

.specific-recipient-header,
.specific-recipient-row {
    display: grid;
    grid-template-columns: 45px 45px 45px minmax(130px, 1fr);
    align-items: center;
    column-gap: 8px;
}

.specific-recipient-header {
    margin-bottom: 10px;
    font-size: 13px;
    font-weight: 500;
}

.specific-recipient-row {
    margin-bottom: 10px;
}

.specific-recipient-row input[type="checkbox"] {
    margin: 0;
}


/* Selected users and customers summary card */
.selected-recipient-summary-card {
    border: 1px solid #dbe3ef !important;
    border-radius: 10px !important;
    background: #f8fafc;
}

.selected-recipient-summary-card .card-header {
    padding: 12px 16px;
    background: #eef4ff;
    border-bottom: 1px solid #dbe3ef;
}

.selected-recipient-summary-card .selected-recipient-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 24px;
    padding: 0 8px;
    border-radius: 999px;
    background: #324b7c;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
}

.selected-recipient-summary-card .selected-recipient-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
}

.selected-recipient-summary-card .selected-recipient-table th,
.selected-recipient-summary-card .selected-recipient-table td {
    padding: 9px 8px;
    border-bottom: 1px solid #edf0f4;
    vertical-align: middle;
}

.selected-recipient-summary-card .selected-recipient-table th {
    font-size: 12px;
    font-weight: 600;
    color: #111827;
    text-align: left;
}

.selected-recipient-summary-card .selected-recipient-table th:nth-child(-n+3),
.selected-recipient-summary-card .selected-recipient-table td:nth-child(-n+3) {
    width: 36px;
    text-align: center;
}

.selected-recipient-summary-card .selected-recipient-table input[type="checkbox"] {
    margin: 0;
    cursor: pointer;
}

.selected-recipient-summary-card .selected-recipient-name {
    font-size: 14px;
    color: #111827;
}

.selected-recipient-summary-card .selected-recipient-email {
    display: block;
    margin-top: 2px;
    color: #6b7280;
    font-size: 11px;
    word-break: break-all;
}

.selected-recipient-summary-card .selected-recipient-empty {
    padding: 14px 8px;
    color: #6b7280;
    font-size: 13px;
}


/* Compact two-column layout for All Selected Users and Options */
.selected-recipient-summary-card .selected-recipient-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 8px 10px;
}

.selected-recipient-summary-card .selected-recipient-item {
    display: grid;
    grid-template-columns: auto minmax(0, 1fr);
    align-items: center;
    gap: 10px;
    min-height: 46px;
    padding: 7px 9px;
    border: 1px solid #e4e9f1;
    border-radius: 6px;
    background: #fff;
}

.selected-recipient-summary-card .selected-recipient-type-controls {
    display: flex;
    align-items: center;
    gap: 7px;
    white-space: nowrap;
}

.selected-recipient-summary-card .selected-recipient-type-control {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    margin: 0;
    color: #4b5563;
    font-size: 10px;
    font-weight: 600;
}

.selected-recipient-summary-card .selected-recipient-type-control input {
    margin: 0;
}

.selected-recipient-summary-card .selected-recipient-details {
    min-width: 0;
}

.selected-recipient-summary-card .selected-recipient-empty {
    grid-column: 1 / -1;
    padding: 10px;
}

@media (max-width: 767.98px) {
    #EditTemplateusersModal .modal-dialog {
        width: calc(100% - 16px);
        margin: 8px auto;
    }

    #EditTemplateusersModal .modal-content {
        max-height: calc(100vh - 16px);
    }

    #EditTemplateusersModal .modal-body {
        max-height: calc(100vh - 120px);
    }

    .selected-recipient-summary-card .selected-recipient-grid {
        grid-template-columns: 1fr;
    }
}

</style>

<div class="container-fluid mb-5 content-position" >
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Notification Email Settings</span>
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
                            <th  style="color: white">Subject</th>
                            <th  style="color: white">Notification Body</th>
                            <th  style="color: white">Description</th>
                            <th  style="color: white">Users</th>
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
          <h5 class="modal-title" id="exampleModalLabel">New Email Notification</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('NotificationEmail.store') }}" method="POST">
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
                  <label for="title">Subject</label>
                  <input type="text" class="form-control" name="title" id="title" required>
                </div>
                <div class="form-group">
                    <label for="notification_body"> Body</label>
                    {{-- <div id="quill_editor" style="height: 150px;"></div> --}}
                    <textarea class="form-control" id="notification_body" name="notification_body" style=" width:100%; height:300px;"></textarea>
                    {{-- <input type="hidden" name="notification_body" id="notification_body"> --}}
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
                  <label for="edit_title">Subject</label>
                  <input type="text" class="form-control" name="title" id="edit_title" required>
              </div>
              <div class="form-group">
                  <label for="edit_notification_body_lbl">Notification Body</label>
                  {{-- <div id="quill_editor_edit" style="height: 150px;"></div> --}}
                  <textarea class="form-control" id="edit_notification_body" name="notification_body" style=" width:100%; height:300px;"></textarea>
                    {{-- <input type="hidden" name="notification_body" id="edit_notification_body"> --}}
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
              <div class="form-group">
                  <label for="environment">Environment</label>
                  <select name="environment" id="environment" class="form-control">
                      <option value="1">Live</option>
                      <option value="0">Test</option>
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
    <div class="modal-dialog modal-dialog-centered notification-users-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editNotificationUsersModalLabel">Edit Notification Users</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('NotificationEmail.toggleUser') }}" method="POST">
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
<!-- DOMPurify to prevent XSS -->
<script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.5/dist/purify.min.js"></script>
<script>
    $(document).ready(function() {
        // var quill = new Quill('#quill_editor', {
        // theme: 'snow'
        // });
        var quill_edit = new Quill('#quill_editor_edit', {
        theme: 'snow'
        });

        // // On form submit, copy HTML from Quill to the hidden input
        // document.querySelector('#AddTemplateModal form').addEventListener('submit', function(e) {
        //     document.querySelector('#notification_body').value = quill.root.innerHTML;
        // });
        // document.querySelector('#editTemplateForm').addEventListener('submit', function(e) {
        //     document.querySelector('#edit_notification_body').value = quill_edit.root.innerHTML;
        // });
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
                    targets: [6,7,5], // 6th column (0-based index)
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
                url: "{{ route('NotificationEmail.get_table_data') }}",
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
                var checked = template.active == 1 ? 'checked' : '';

                var row = [
                    `<input type="checkbox" class="togelcheck changeStatus" data-id="${template.id}" ${checked} />`,
                    template.name,
                    template.template_key,
                    template.function_name,
                    template.controller,
                    template.subject,
                    template.body,
                    template.description,
                    `<span class="view_users" data-id="${template.id}"><i class="fa-solid fa-users" style="color:#3a82ad;cursor:pointer"></i><span  class="mx-1" style="color:#3a82ad;cursor:pointer">view</span></span>`,
                    `<span class="edit_template" data-id="${template.id}"><i class="fa-solid fa-pen-to-square" style="color:#3bad3a;cursor:pointer"></i><span class="mx-1" style="color:#3bad3a;cursor:pointer">edit</span></span>`
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
                    url: "{{ route('notification_templatesEmail.change_status') }}", // Adjust route accordingly
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
            // Toggle users when group checkbox is changed
            $('#notificationUsersContainer').on('change', '.select-group', function () {
            const roleId = $(this).data('role-id');
            const isChecked = $(this).is(':checked');

            $(`.select-user[data-role-id="${roleId}"]`).prop('checked', isChecked).trigger('change');
            });

            // Optional: Auto-check group box if all users are checked
            $('#notificationUsersContainer').on('change', '.select-user', function () {
            const roleId = $(this).data('role-id');
            const users = $(`.select-user[data-role-id="${roleId}"]`);
            const allChecked = users.length === users.filter(':checked').length;

            $(`.select-group[data-role-id="${roleId}"]`).prop('checked', allChecked);
            });
            $('.select-user').trigger('change');

            $('#notification_groups_table').off('click', '.view_users').on('click', '.view_users', function () {
                var templateId = $(this).data('id');
                console.log( templateId);
                $.ajax({
                    url:`{{ url('notification_template/email/users')}}/${templateId}`,
                    method: 'GET',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        console.log(
        'Saved organization customers:',
        data.template.specific_organization_customers
    );
                        renderUsersModal(data.groups, data.selectedUsers, data.template_id, data.template);


                        $('#EditTemplateusersModal').modal('show');
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function () {
                        alert('Failed to load template data');
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
                // Show the modal
                $('#EditTemplateusersModal').modal('show');

            });
            function renderUsersModal(groups, selectedUsers, templateID, template) {
                const container = $('#notificationUsersContainer');
                const notificationName = String(
                    template.name || template.notification_name || ''
                ).trim();

                $('#editNotificationUsersModalLabel').text(
                    notificationName
                        ? `Edit Notification Users for ${notificationName}`
                        : 'Edit Notification Users'
                );

                container.empty();
                let templateInput = `<input type="hidden" value ="${templateID}" name="Template_id">`;
                container.append(templateInput);


                const selectedRecipientsCard = `
                    <div class="col-md-12">
                        <div class="card mb-3 selected-recipient-summary-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>All Selected Users and Options</strong>
                                    <span
                                        id="selectedRecipientsCount_${templateID}"
                                        class="selected-recipient-count ml-2"
                                    >0</span>
                                </div>

                                <button type="button"
                                    class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                                    aria-expanded="true"
                                    title="Collapse selected users and options">
                                    <span class="collapse-symbol">−</span>
                                </button>
                            </div>

                            <div class="card-body collapsible-card-body p-3">
                                <div
                                    class="selected-recipient-grid"
                                    id="selectedRecipientsRows_${templateID}"
                                ></div>
                            </div>
                        </div>
                    </div>
                `;

                container.append(selectedRecipientsCard);
                groups.forEach(group => {
                var roleId = group.id;
                var roleName = group.name;

                let cardHtml = `
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <strong>${roleName}</strong>

                                <div class="d-flex align-items-center">
                                    <label class="mb-0 mr-3">
                                        <input type="checkbox"
                                            class="select-group"
                                            data-role-id="${roleId}">
                                        Select All
                                    </label>

                                    <button type="button"
                                        class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                                        aria-expanded="true">
                                        <span class="collapse-symbol">+</span>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body collapsible-card-body" style="display: none;">
                                <table style="width:100%">
                                    <tr class="form-check">
                                        <td class="p-2">TO</td>
                                        <td class="p-2">CC</td>
                                        <td class="p-2">BCC</td>
                                        <td></td>
                                    </tr>`;

                group.users.forEach(user => {
                    var userIdStr = user.id.toString();
                    var checkedTo = selectedUsers.to.includes(userIdStr) ? 'checked' : '';
                    var checkedCc = selectedUsers.cc.includes(userIdStr) ? 'checked' : '';
                    var checkedBcc = selectedUsers.bcc.includes(userIdStr) ? 'checked' : '';

                    cardHtml += `
                        <tr class="form-check">
                            <td class="p-2">
                                <input class="select-user" type="checkbox"
                                    value="${user.id}" data-role-id="${roleId}" data-type="to"
                                    data-user-id="${user.id}" data-template_id="${templateID}"
                                    data-recipient-kind="user" data-recipient-key="user-${user.id}"
                                    data-recipient-name="${escapeNotificationHtml(user.name)}"
                                    name="to_user_ids[]" id="to_user_${user.id}" ${checkedTo}>
                            </td>
                            <td class="p-2">
                                <input class="select-user" type="checkbox"
                                    value="${user.id}" data-role-id="${roleId}" data-type="cc"
                                    data-user-id="${user.id}" data-template_id="${templateID}"
                                    data-recipient-kind="user" data-recipient-key="user-${user.id}"
                                    data-recipient-name="${escapeNotificationHtml(user.name)}"
                                    name="cc_user_ids[]" id="cc_user_${user.id}" ${checkedCc}>
                            </td>
                            <td class="p-2">
                                <input class="select-user" type="checkbox"
                                    value="${user.id}" data-role-id="${roleId}" data-type="bcc"
                                    data-user-id="${user.id}" data-template_id="${templateID}"
                                    data-recipient-kind="user" data-recipient-key="user-${user.id}"
                                    data-recipient-name="${escapeNotificationHtml(user.name)}"
                                    name="bcc_user_ids[]" id="bcc_user_${user.id}" ${checkedBcc}>
                            </td>
                            <td>
                                <p class="m-auto" for="to_user_${user.id}">${user.name}</p>
                            </td>
                        </tr>`;
                });

                cardHtml += `</table></div></div></div>`;
                container.append(cardHtml);
            });

            // Organization Related Users

            // var OrgSetting = template.organization_user ? JSON.parse(template.organization_user) : null;

            // var OrgToArray  = OrgSetting ? OrgSetting.to || {} : {};
            // var OrgCcArray  = OrgSetting ? OrgSetting.cc || {} : {};
            // var OrgBccArray = OrgSetting ? OrgSetting.bcc || {} : {};

            // const OrganizationRelatedUsers = [
            //     { key: 'organization', label: 'Organization' },
            //     { key: 'sales_rep', label: 'Sales Rep' },
            //     { key: 'customers', label: 'Organization Customers' }
            // ];

            // let rows = OrganizationRelatedUsers.map(user => `
            //     <tr class="form-check">
            //         <td class="p-2">
            //             <input class="select-user" type="checkbox" name="to_org_related[${user.key}]" ${OrgToArray[user.key] == 1 ? 'checked' : ''}>
            //         </td>
            //         <td class="p-2">
            //             <input class="select-user" type="checkbox" name="cc_org_related[${user.key}]" ${OrgCcArray[user.key] == 1 ? 'checked' : ''}>
            //         </td>
            //         <td class="p-2">
            //             <input class="select-user" type="checkbox" name="bcc_org_related[${user.key}]" ${OrgBccArray[user.key] == 1 ? 'checked' : ''}>
            //         </td>
            //         <td>
            //             <p class="m-auto">${user.label}</p>
            //         </td>
            //     </tr>
            // `).join('');

            // let OrgCardHtml = `
            // <div class="col-md-12">
            //     <div class="card mb-3">
            //         <div class="card-header d-flex justify-content-between align-items-center">
            //             <strong>Organization Related Users</strong>

            //             <button type="button"
            //                 class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
            //                 aria-expanded="true">
            //                 <span class="collapse-symbol">+</span>
            //             </button>
            //         </div>

            //         <div class="card-body collapsible-card-body" style="display: none;">
            //             <table style="width:100%">
            //                 <tr class="form-check">
            //                     <td class="p-2">TO</td>
            //                     <td class="p-2">CC</td>
            //                     <td class="p-2">BCC</td>
            //                     <td></td>
            //                 </tr>
            //                 ${rows}
            //             </table>
            //         </div>
            //     </div>
            // </div>
            // `;

            // container.append(OrgCardHtml);
            var OrgSetting = template.organization_user
    ? JSON.parse(template.organization_user)
    : null;

var OrgToArray  = OrgSetting ? OrgSetting.to || {} : {};
var OrgCcArray  = OrgSetting ? OrgSetting.cc || {} : {};
var OrgBccArray = OrgSetting ? OrgSetting.bcc || {} : {};

const savedSpecificRows = Array.isArray(template.specific_organization_customers)
    ? template.specific_organization_customers
    : [];

const savedSpecificCustomers = {};
const savedOrganizations = {};

savedSpecificRows.forEach(function (row) {
    const organizationId = String(row.organization_id);
    const contactId = String(row.contact_id);

    if (!savedSpecificCustomers[organizationId]) {
        savedSpecificCustomers[organizationId] = {
            to: [],
            cc: [],
            bcc: []
        };
    }

    if (parseInt(row.type) === 0) {
        savedSpecificCustomers[organizationId].to.push(contactId);
    }

    if (parseInt(row.type) === 1) {
        savedSpecificCustomers[organizationId].cc.push(contactId);
    }

    if (parseInt(row.type) === 2) {
        savedSpecificCustomers[organizationId].bcc.push(contactId);
    }

    savedOrganizations[organizationId] =
        row.organization?.organization_name
        || row.organization_name
        || `Organization #${organizationId}`;
});

const specificOrganizationEnabled =
    parseInt(template.send_organization || 0) === 1;

const hasOrganizationCustomers =
    parseInt(OrgToArray.customers || 0) === 1 ||
    parseInt(OrgCcArray.customers || 0) === 1 ||
    parseInt(OrgBccArray.customers || 0) === 1;

/*
 * Specific Organizations takes priority.
 * Both cannot load as checked.
 */
const orgCustomersEnabled =
    !specificOrganizationEnabled &&
    hasOrganizationCustomers;



let OrgCardHtml = `
    <div class="col-md-12">
        <div class="card mb-3 org-user-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Organization Related Users</strong>

                <button type="button"
                    class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                    aria-expanded="false">
                    <span class="collapse-symbol">+</span>
                </button>
            </div>

            <div class="card-body collapsible-card-body" style="display:none;">
                <div class="org-divider"></div>

                <div class="recipient-header">
                    <div>To</div>
                    <div>CC</div>
                    <div>BCC</div>
                    <div></div>
                </div>

                <div class="recipient-row">
                    <div>
                        <input class="select-user" type="checkbox"
                            name="to_org_related[organization]"
                            ${OrgToArray.organization == 1 ? 'checked' : ''}>
                    </div>
                    <div>
                        <input class="select-user" type="checkbox"
                            name="cc_org_related[organization]"
                            ${OrgCcArray.organization == 1 ? 'checked' : ''}>
                    </div>
                    <div>
                        <input class="select-user" type="checkbox"
                            name="bcc_org_related[organization]"
                            ${OrgBccArray.organization == 1 ? 'checked' : ''}>
                    </div>
                    <div class="row-label">Organization</div>
                </div>

                <div class="recipient-row">
                    <div>
                        <input class="select-user" type="checkbox"
                            name="to_org_related[sales_rep]"
                            ${OrgToArray.sales_rep == 1 ? 'checked' : ''}>
                    </div>
                    <div>
                        <input class="select-user" type="checkbox"
                            name="cc_org_related[sales_rep]"
                            ${OrgCcArray.sales_rep == 1 ? 'checked' : ''}>
                    </div>
                    <div>
                        <input class="select-user" type="checkbox"
                            name="bcc_org_related[sales_rep]"
                            ${OrgBccArray.sales_rep == 1 ? 'checked' : ''}>
                    </div>
                    <div class="row-label">Sales Rep</div>
                </div>

                <div class="org-divider mt-4"></div>

                <div class="org-check-line">
                    <input type="checkbox"
                        class="org-customers-master"
                        id="orgCustomersMaster_${templateID}"
                        name="organization_customers_enabled"
                        data-template-id="${templateID}"
                        ${orgCustomersEnabled ? 'checked' : ''}>
                    <label for="orgCustomersMaster_${templateID}" class="mb-0">
                        Organization Customers
                    </label>
                </div>

                <div class="org-sub-block org-customers-body ${orgCustomersEnabled ? '' : 'hidden'}"
                    id="orgCustomersBody_${templateID}">
                    <div class="recipient-header">
                        <div>To</div>
                        <div>CC</div>
                        <div>BCC</div>
                        <div></div>
                    </div>

                    <div class="recipient-row">
                        <div>
                            <input class="select-user" type="checkbox"
                                name="to_org_related[customers]"
                                ${OrgToArray.customers == 1 ? 'checked' : ''}>
                        </div>
                        <div>
                            <input class="select-user" type="checkbox"
                                name="cc_org_related[customers]"
                                ${OrgCcArray.customers == 1 ? 'checked' : ''}>
                        </div>
                        <div>
                            <input class="select-user" type="checkbox"
                                name="bcc_org_related[customers]"
                                ${OrgBccArray.customers == 1 ? 'checked' : ''}>
                        </div>
                        <div class="row-label">All Customers</div>
                    </div>
                </div>

                <div class="org-check-line mt-4">
                    <input type="checkbox"
                        class="send-specific-organizations"
                        id="sendSpecificOrganizations_${templateID}"
                        name="send_organization"
                        value="1"
                        data-template-id="${templateID}"
                        ${specificOrganizationEnabled ? 'checked' : ''}>
                    <label for="sendSpecificOrganizations_${templateID}" class="mb-0">
                        Specific Organizations
                    </label>
                </div>

                <div id="specificOrganizationsSection_${templateID}"
                    class="org-sub-block ${specificOrganizationEnabled ? '' : 'hidden'}">
                    <div class="org-select-wrap">
                        <select
                            id="specificOrganizations_${templateID}"
                            class="form-control specific-organizations-select"
                            data-template-id="${templateID}"
                            style="width:100%;">
                            <option value=""></option>
                        </select>
                    </div>

                    <div id="specificOrganizationCustomers_${templateID}"
                        class="specific-org-list"></div>
                </div>
            </div>
        </div>
    </div>
`;

container.append(OrgCardHtml);

initializeSpecificOrganizationSelect(
    templateID,
    savedSpecificCustomers,
    savedOrganizations
);


            // HR Module Users

            var HRSetting = template.hr_users ? JSON.parse(template.hr_users) : null;

            var HRToArray  = HRSetting ? HRSetting.to || {} : {};
            var HRCcArray  = HRSetting ? HRSetting.cc || {} : {};
            var HRBccArray = HRSetting ? HRSetting.bcc || {} : {};

            const HRRelatedUsers = [
                { key: 'employee', label: 'Employee' },
            ];

            let HRrows = HRRelatedUsers.map(user => `
                <tr class="form-check">
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="to_hr_related[${user.key}]" ${HRToArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="cc_hr_related[${user.key}]" ${HRCcArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="bcc_hr_related[${user.key}]" ${HRBccArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td>
                        <p class="m-auto">${user.label}</p>
                    </td>
                </tr>
            `).join('');

            let HRCardHtml = `
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>HR Module Related Users</strong>
                        <button type="button"
                            class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                            aria-expanded="true">
                            <span class="collapse-symbol">+</span>
                        </button>
                    </div>
                    <div class="card-body collapsible-card-body" style="display: none;">
                        <table style="width:100%">
                            <tr class="form-check">
                                <td class="p-2">TO</td>
                                <td class="p-2">CC</td>
                                <td class="p-2">BCC</td>
                                <td></td>
                            </tr>
                            ${HRrows}
                        </table>
                    </div>
                </div>
            </div>
            `;

            container.append(HRCardHtml);

            // Store module Users

            var StoreSetting = template.store_users ? JSON.parse(template.store_users) : null;

            var StoreToArray  = StoreSetting ? StoreSetting.to || {} : {};
            var StoreCcArray  = StoreSetting ? StoreSetting.cc || {} : {};
            var StoreBccArray = StoreSetting ? StoreSetting.bcc || {} : {};

            const StoreRelatedUsers = [
                { key: 'sales_rep', label: 'Sales Rep' },
                { key: 'store_customers', label: 'Store Customers' },
            ];

            let StoreRows = StoreRelatedUsers.map(user => `
                <tr class="form-check">
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="to_store_related[${user.key}]" ${StoreToArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="cc_store_related[${user.key}]" ${StoreCcArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="bcc_store_related[${user.key}]" ${StoreBccArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td>
                        <p class="m-auto">${user.label}</p>
                    </td>
                </tr>
            `).join('');

            let StoreCardHtml = `
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Store Module Related Users</strong>
                        <button type="button"
                            class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                            aria-expanded="true">
                            <span class="collapse-symbol">+</span>
                        </button>
                    </div>
                    <div class="card-body collapsible-card-body" style="display: none;">
                        <table style="width:100%">
                            <tr class="form-check">
                                <td class="p-2">TO</td>
                                <td class="p-2">CC</td>
                                <td class="p-2">BCC</td>
                                <td></td>
                            </tr>
                            ${StoreRows}
                        </table>
                    </div>
                </div>
            </div>
            `;

            container.append(StoreCardHtml);

            // Project Managment Module Users

            var PMSetting = template.pm_users ? JSON.parse(template.pm_users) : null;

            var PMToArray  = PMSetting ? PMSetting.to || {} : {};
            var PMCcArray  = PMSetting ? PMSetting.cc || {} : {};
            var PMBccArray = PMSetting ? PMSetting.bcc || {} : {};

            const PMRelatedUsers = [
                { key: 'project_owner', label: 'Project Owner' },
                { key: 'task_assignees', label: 'Task Assignees' },
                { key: 'sub_task_assignees', label: 'Sub Task Assignees' },
            ];

            let PMrows = PMRelatedUsers.map(user => `
                <tr class="form-check">
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="to_pm_related[${user.key}]" ${PMToArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="cc_pm_related[${user.key}]" ${PMCcArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="bcc_pm_related[${user.key}]" ${PMBccArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td>
                        <p class="m-auto">${user.label}</p>
                    </td>
                </tr>
            `).join('');

            let PMCardHtml = `
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Project Management Related Users</strong>
                        <button type="button"
                            class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                            aria-expanded="true">
                            <span class="collapse-symbol">+</span>
                        </button>
                    </div>
                    <div class="card-body collapsible-card-body" style="display: none;">
                        <table style="width:100%">
                            <tr class="form-check">
                                <td class="p-2">TO</td>
                                <td class="p-2">CC</td>
                                <td class="p-2">BCC</td>
                                <td></td>
                            </tr>
                            ${PMrows}
                        </table>
                    </div>
                </div>
            </div>
            `;

            container.append(PMCardHtml);

            var OrderProssingRep_isChecked = template.proccessing_rep == 1 ? 'checked' : '';
            var salesRep_isChecked = template.sales_rep == 1 ? 'checked' : '';
            var Orderfac_isChecked = template.related_fac == 1 ? 'checked' : '';
            var orderCustomer_isChecked = template.order_customer == 1 ? 'checked' : '';

            otherhtml = `
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <strong>Other Options</strong>
                                <button type="button"
                                    class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                                    aria-expanded="true">
                                    <span class="collapse-symbol">+</span>
                                </button>
                            </div>
                            <div class="card-body collapsible-card-body" style="display: none;">
                                <div class="form-check">
                                    <input class="form-check-input select-user" type="checkbox" name="OrderProssingRep" ${OrderProssingRep_isChecked}>
                                    <label class="form-check-label" for="user_">Order Proccesing Rep</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input select-user" type="checkbox" name="salesRep" ${salesRep_isChecked}>
                                    <label class="form-check-label" for="user_">Sales rep</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input select-user" type="checkbox" name="Related_Factories" ${Orderfac_isChecked}>
                                    <label class="form-check-label" for="user_">Send Order Related Factorie's users</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input select-user" type="checkbox" name="order_customer" ${orderCustomer_isChecked}>
                                    <label class="form-check-label" for="user_">Send Order Customer</label>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            container.append(otherhtml);

            // Custom Emails

            var CustomSetting = template.custom_email ? JSON.parse(template.custom_email) : null;

            var CustomToArray  = CustomSetting ? CustomSetting.to || {} : {};
            var CustomCcArray  = CustomSetting ? CustomSetting.cc || {} : {};
            var CustomBccArray = CustomSetting ? CustomSetting.bcc || {} : {};

            const CustomRelatedUsers = [
                { key: 'custom_email', label: 'Custom Email' },
            ];

            let CustomRows = CustomRelatedUsers.map(user => `
                <tr class="form-check">
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="to_custom_related[${user.key}]" ${CustomToArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="cc_custom_related[${user.key}]" ${CustomCcArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td class="p-2">
                        <input class="select-user" type="checkbox" name="bcc_custom_related[${user.key}]" ${CustomBccArray[user.key] == 1 ? 'checked' : ''}>
                    </td>
                    <td>
                        <p class="m-auto">${user.label}</p>
                    </td>
                </tr>
            `).join('');

            let CustomCardHtml = `
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Custom Emails</strong>
                        <button type="button"
                            class="btn btn-sm btn-link text-dark p-1 toggle-notification-card"
                            aria-expanded="true">
                            <span class="collapse-symbol">+</span>
                        </button>
                    </div>
                    <div class="card-body collapsible-card-body" style="display: none;">
                        <table style="width:100%">
                            <tr class="form-check">
                                <td class="p-2">TO</td>
                                <td class="p-2">CC</td>
                                <td class="p-2">BCC</td>
                                <td></td>
                            </tr>
                            ${CustomRows}
                        </table>
                    </div>
                </div>
            </div>
            `;

            container.append(CustomCardHtml);

            // After rendering, trigger check logic
            $('.select-user').trigger('change');
            updateSelectedRecipientsSummary();
        }

function getNotificationRecipientType(input) {
    const explicitType = String(input.attr('data-type') || '').toLowerCase();

    if (['to', 'cc', 'bcc'].includes(explicitType)) {
        return explicitType;
    }

    const fieldName = String(input.attr('name') || '');

    if (/^to_/i.test(fieldName) || /\[to\]/i.test(fieldName)) {
        return 'to';
    }

    if (/^cc_/i.test(fieldName) || /\[cc\]/i.test(fieldName)) {
        return 'cc';
    }

    if (/^bcc_/i.test(fieldName) || /\[bcc\]/i.test(fieldName)) {
        return 'bcc';
    }

    /*
     * These are single boolean recipient options.
     * They do not have separate TO / CC / BCC fields in the form,
     * so show them in the summary as TO recipients.
     */
    const otherOptionFields = [
        'OrderProssingRep',
        'salesRep',
        'Related_Factories',
        'order_customer'
    ];

    if (otherOptionFields.includes(fieldName)) {
        return 'to';
    }

    return null;
}

function getNotificationRecipientDetails(input) {
    const row = input.closest(
        '.specific-recipient-row, .recipient-row, tr, .form-check'
    );

    let name = String(input.attr('data-recipient-name') || '').trim();
    let email = String(input.attr('data-recipient-email') || '').trim();

    if (!name && row.length) {
        const nameElement = row.find(
            '.specific-customer-name, .row-label, p, label'
        ).last();

        if (nameElement.length) {
            const nameClone = nameElement.clone();
            nameClone.find('small').remove();
            name = nameClone.text().replace(/\s+/g, ' ').trim();
        }
    }

    if (!email && row.length) {
        email = row.find('.specific-customer-name small').first().text().trim();
    }

    if (!name) {
        name = email || 'Selected recipient';
    }

    const fieldName = String(input.attr('name') || '');

    const otherOptionFields = [
        'OrderProssingRep',
        'salesRep',
        'Related_Factories',
        'order_customer'
    ];

    const kind = String(
        input.attr('data-recipient-kind')
        || (
            fieldName.includes('specific_customers')
                ? 'customer'
                : (otherOptionFields.includes(fieldName) ? 'other-option' : 'recipient')
        )
    );

    /*
     * IMPORTANT:
     * TO / CC / BCC versions of the same module option must use the SAME key.
     *
     * Examples:
     *   to_hr_related[employee]
     *   cc_hr_related[employee]
     *   bcc_hr_related[employee]
     *
     * all become:
     *   hr_related[employee]
     *
     * This makes Employee appear once in the first card with
     * TO / CC / BCC checked in the same row.
     */
    const normalizedFieldName = fieldName
        .replace(/^(to|cc|bcc)_/i, '')
        .replace(/\[(to|cc|bcc)\]/i, '[recipient]');

    const identifier = String(
        input.attr('data-recipient-key')
        || input.attr('data-user-id')
        || normalizedFieldName
        || input.val()
        || name
    );

    return {
        name: name,
        email: email,
        key: `${kind}:${identifier}`
    };
}

function renderSelectedRecipientsTable(templateID, recipients) {
    const target = $(`#selectedRecipientsRows_${templateID}`);

    if (!target.length) {
        return;
    }

    if (!recipients.length) {
        target.html(`
            <div class="selected-recipient-empty">
                No users, customers or options selected.
            </div>
        `);
        return;
    }

    const html = recipients.map(function (recipient) {
        return `
            <div class="selected-recipient-item">
                <div class="selected-recipient-type-controls">
                    <label class="selected-recipient-type-control">
                        <input
                            type="checkbox"
                            class="selected-recipient-summary-checkbox"
                            data-recipient-key="${escapeNotificationHtml(recipient.key)}"
                            data-recipient-type="to"
                            ${recipient.to ? 'checked' : ''}
                            ${recipient.availableTo ? '' : 'disabled'}
                        >
                        <span>TO</span>
                    </label>

                    <label class="selected-recipient-type-control">
                        <input
                            type="checkbox"
                            class="selected-recipient-summary-checkbox"
                            data-recipient-key="${escapeNotificationHtml(recipient.key)}"
                            data-recipient-type="cc"
                            ${recipient.cc ? 'checked' : ''}
                            ${recipient.availableCc ? '' : 'disabled'}
                        >
                        <span>CC</span>
                    </label>

                    <label class="selected-recipient-type-control">
                        <input
                            type="checkbox"
                            class="selected-recipient-summary-checkbox"
                            data-recipient-key="${escapeNotificationHtml(recipient.key)}"
                            data-recipient-type="bcc"
                            ${recipient.bcc ? 'checked' : ''}
                            ${recipient.availableBcc ? '' : 'disabled'}
                        >
                        <span>BCC</span>
                    </label>
                </div>

                <div class="selected-recipient-details">
                    <span class="selected-recipient-name">
                        ${escapeNotificationHtml(recipient.name)}
                    </span>
                    ${recipient.email ? `
                        <span class="selected-recipient-email">
                            ${escapeNotificationHtml(recipient.email)}
                        </span>
                    ` : ''}
                </div>
            </div>
        `;
    }).join('');

    target.html(html);
}

function updateSelectedRecipientsSummary() {
    const templateID = String(
        $('#notificationUsersContainer input[name="Template_id"]').val() || ''
    );

    if (!templateID || !$(`#selectedRecipientsCount_${templateID}`).length) {
        return;
    }

    const recipients = new Map();

    /*
     * Read ALL source inputs, not only checked inputs.
     * This lets the first card know which recipient types are available.
     * Example: Other Options only support TO, therefore CC/BCC are disabled.
     */
    $('#notificationUsersContainer input.select-user').each(function () {
        const input = $(this);
        const type = getNotificationRecipientType(input);

        if (!type) {
            return;
        }

        const details = getNotificationRecipientDetails(input);

        if (!recipients.has(details.key)) {
            recipients.set(details.key, {
                key: details.key,
                name: details.name,
                email: details.email,

                to: false,
                cc: false,
                bcc: false,

                availableTo: false,
                availableCc: false,
                availableBcc: false
            });
        }

        const recipient = recipients.get(details.key);

        if (type === 'to') {
            recipient.availableTo = true;
        }

        if (type === 'cc') {
            recipient.availableCc = true;
        }

        if (type === 'bcc') {
            recipient.availableBcc = true;
        }

        if (input.is(':checked')) {
            recipient[type] = true;
        }
    });

    /*
     * First card should contain only options that are actually selected.
     */
    const selectedRecipients = Array.from(recipients.values())
        .filter(function (recipient) {
            return recipient.to || recipient.cc || recipient.bcc;
        })
        .sort(function (first, second) {
            return first.name.localeCompare(second.name);
        });

    renderSelectedRecipientsTable(templateID, selectedRecipients);

    $(`#selectedRecipientsCount_${templateID}`).text(
        selectedRecipients.length
    );
}

$(document)
    .off(
        'change.selectedRecipientSummaryCheckbox',
        '#notificationUsersContainer .selected-recipient-summary-checkbox'
    )
    .on(
        'change.selectedRecipientSummaryCheckbox',
        '#notificationUsersContainer .selected-recipient-summary-checkbox',
        function () {
            const summaryCheckbox = $(this);
            const recipientKey = String(
                summaryCheckbox.data('recipient-key') || ''
            );
            const recipientType = String(
                summaryCheckbox.data('recipient-type') || ''
            );
            const checked = summaryCheckbox.is(':checked');

            $('#notificationUsersContainer input.select-user').each(function () {
                const sourceInput = $(this);

                if (getNotificationRecipientType(sourceInput) !== recipientType) {
                    return;
                }

                const sourceRecipient = getNotificationRecipientDetails(sourceInput);

                if (sourceRecipient.key === recipientKey) {
                    sourceInput.prop('checked', checked).trigger('change');
                }
            });
        }
    );

function clearOrganizationCustomers(templateID) {
    const checkbox = $(
        `#orgCustomersMaster_${templateID}`
    );

    const body = $(
        `#orgCustomersBody_${templateID}`
    );

    checkbox.prop('checked', false);

    body
        .find('input[type="checkbox"]')
        .prop('checked', false)
        .prop('disabled', true);

    body
        .stop(true, true)
        .hide()
        .addClass('hidden');

    updateSelectedRecipientsSummary();
}

function clearSpecificOrganizations(templateID) {
    const checkbox = $(
        `#sendSpecificOrganizations_${templateID}`
    );

    const section = $(
        `#specificOrganizationsSection_${templateID}`
    );

    const select = $(
        `#specificOrganizations_${templateID}`
    );

    const customerContainer = $(
        `#specificOrganizationCustomers_${templateID}`
    );

    checkbox.prop('checked', false);

    /*
     * Remove all selected organization blocks,
     * hidden organization IDs, and customer checkboxes.
     */
    customerContainer.empty();

    /*
     * Clear Select2 picker.
     */
    if (select.length) {
        select
            .val(null)
            .trigger('change.select2');

        /*
         * Remove AJAX-created options.
         */
        select
            .find('option')
            .not('[value=""]')
            .remove();

        select
            .prop('disabled', true)
            .trigger('change.select2');

        if (select.hasClass('select2-hidden-accessible')) {
            select.select2('close');
        }
    }

    section
        .stop(true, true)
        .hide()
        .addClass('hidden');

    updateSelectedRecipientsSummary();
}

/*
|--------------------------------------------------------------------------
| Organization Customers
|--------------------------------------------------------------------------
*/

$(document)
    .off(
        'change.notificationOrganizationCustomers',
        '.org-customers-master'
    )
    .on(
        'change.notificationOrganizationCustomers',
        '.org-customers-master',
        function () {
            const templateID = String(
                $(this).data('template-id')
            );

            const checked = $(this).is(':checked');

            const body = $(
                `#orgCustomersBody_${templateID}`
            );

            if (checked) {
                /*
                 * Specific Organizations cannot remain selected.
                 * Clear all its organizations and customer choices.
                 */
                clearSpecificOrganizations(templateID);

                $(this).prop('checked', true);

                body
                    .removeClass('hidden')
                    .stop(true, true)
                    .slideDown(150);

                body
                    .find('input[type="checkbox"]')
                    .prop('disabled', false);
            } else {
                /*
                 * Unchecking clears TO, CC and BCC.
                 */
                clearOrganizationCustomers(templateID);
            }
        }
    );

/*
|--------------------------------------------------------------------------
| Specific Organizations
|--------------------------------------------------------------------------
*/

$(document)
    .off(
        'change.notificationSpecificOrganizations',
        '.send-specific-organizations'
    )
    .on(
        'change.notificationSpecificOrganizations',
        '.send-specific-organizations',
        function () {
            const templateID = String(
                $(this).data('template-id')
            );

            const checked = $(this).is(':checked');

            const section = $(
                `#specificOrganizationsSection_${templateID}`
            );

            const select = $(
                `#specificOrganizations_${templateID}`
            );

            if (checked) {
                /*
                 * Organization Customers cannot remain selected.
                 * Clear All Customers TO, CC and BCC.
                 */
                clearOrganizationCustomers(templateID);

                $(this).prop('checked', true);

                section
                    .removeClass('hidden')
                    .stop(true, true)
                    .slideDown(150);

                select
                    .prop('disabled', false)
                    .val(null)
                    .trigger('change.select2');
            } else {
                /*
                 * Unchecking removes all organization blocks
                 * and selected organization customers.
                 */
                clearSpecificOrganizations(templateID);
            }
        }
    );
    function renderSpecificOrganizationCustomerTable(
    cardId,
    organizationId,
    customers,
    selectedCustomers
) {
    const container = $(`#${cardId}`);

    if (!customers.length) {
        container.html(`
            <div class="text-muted">No customers found.</div>
        `);
        return;
    }

    let rows = `
        <div class="recipient-header">
            <div>To</div>
            <div>CC</div>
            <div>BCC</div>
            <div></div>
        </div>
    `;

    customers.forEach(function (customer) {
        const contactId = String(customer.id);

        const checkedTo = selectedCustomers.to.includes(contactId) ? 'checked' : '';
        const checkedCc = selectedCustomers.cc.includes(contactId) ? 'checked' : '';
        const checkedBcc = selectedCustomers.bcc.includes(contactId) ? 'checked' : '';

        const customerName =
            customer.name
            || [customer.first_name || '', customer.last_name || ''].join(' ').trim()
            || customer.email
            || `Contact #${customer.id}`;

        rows += `
            <div class="recipient-row">
                <div>
                    <input class="select-user" type="checkbox"
                        name="specific_customers[${organizationId}][to][]"
                        value="${customer.id}" data-type="to"
                        data-recipient-kind="customer"
                        data-recipient-key="customer-${organizationId}-${customer.id}"
                        data-recipient-name="${escapeNotificationHtml(customerName)}"
                        data-recipient-email="${escapeNotificationHtml(customer.email || '')}"
                        ${checkedTo}>
                </div>

                <div>
                    <input class="select-user" type="checkbox"
                        name="specific_customers[${organizationId}][cc][]"
                        value="${customer.id}" data-type="cc"
                        data-recipient-kind="customer"
                        data-recipient-key="customer-${organizationId}-${customer.id}"
                        data-recipient-name="${escapeNotificationHtml(customerName)}"
                        data-recipient-email="${escapeNotificationHtml(customer.email || '')}"
                        ${checkedCc}>
                </div>

                <div>
                    <input class="select-user" type="checkbox"
                        name="specific_customers[${organizationId}][bcc][]"
                        value="${customer.id}" data-type="bcc"
                        data-recipient-kind="customer"
                        data-recipient-key="customer-${organizationId}-${customer.id}"
                        data-recipient-name="${escapeNotificationHtml(customerName)}"
                        data-recipient-email="${escapeNotificationHtml(customer.email || '')}"
                        ${checkedBcc}>
                </div>

                <div class="row-label">${escapeNotificationHtml(customerName)}</div>
            </div>
        `;
    });

    container.html(rows);
    updateSelectedRecipientsSummary();
}
function initializeSpecificOrganizationSelect(
    templateID,
    savedSpecificCustomers = {},
    savedOrganizations = {}
) {
    const select = $(`#specificOrganizations_${templateID}`);

    if (!select.length) {
        console.error(
            `Organization picker not found: #specificOrganizations_${templateID}`
        );
        return;
    }

    if (select.hasClass('select2-hidden-accessible')) {
        select.select2('destroy');
    }

    select.off('.specificOrganization');

    select.select2({
        width: '100%',
        placeholder: 'Search and add organization',
        allowClear: true,
        minimumInputLength: 1,
        closeOnSelect: true,

        dropdownParent: $('#EditTemplateusersModal'),
        dropdownCssClass: 'notification-org-dropdown',

        ajax: {
            url: "{{ route('admin.email-notifications.organizations.search') }}",
            type: 'GET',
            dataType: 'json',
            delay: 300,
            cache: true,

            data: function (params) {
                return {
                    search: params.term || ''
                };
            },

            processResults: function (response) {
                return {
                    results: response.results || []
                };
            }
        }
    });

    select.on(
        'select2:select.specificOrganization',
        function (event) {
            const organization = event.params.data;

            const organizationId = String(organization.id);
            const organizationName =
                organization.text || `Organization #${organizationId}`;

            const blockId =
                `specificOrganizationBlock_${templateID}_${organizationId}`;

            /*
            * Do not add the same organization twice.
            */
            if (!$(`#${blockId}`).length) {
                loadSpecificOrganizationCustomers(
                    templateID,
                    organizationId,
                    organizationName,
                    savedSpecificCustomers[organizationId] || {
                        to: [],
                        cc: [],
                        bcc: []
                    }
                );
            }

            /*
            * Remove the selected organization from the picker.
            * The organization remains in the list below.
            */
            select.find('option').filter(function () {
                return String($(this).val()) === organizationId;
            }).remove();

            select
                .val(null)
                .trigger('change.select2');

            select.select2('close');

            /*
            * Clear typed search text and remove active/highlight state.
            */
            setTimeout(function () {
                $('.select2-search__field')
                    .val('')
                    .trigger('input');

                $('.notification-org-dropdown')
                    .find('.select2-results__option')
                    .removeClass(
                        'select2-results__option--highlighted ' +
                        'select2-results__option--selected'
                    )
                    .attr('aria-selected', 'false');

                select
                    .next('.select2-container')
                    .find('.select2-selection')
                    .removeClass('select2-selection--focus')
                    .blur();
            }, 0);
        }
    );

    const enabled = $(
        `#sendSpecificOrganizations_${templateID}`
    ).is(':checked');

    select.prop('disabled', !enabled);

    /*
     * Load already saved organizations when editing.
     */
    if (enabled) {
        Object.entries(savedOrganizations || {}).forEach(
            function ([organizationId, organizationName]) {
                loadSpecificOrganizationCustomers(
                    templateID,
                    String(organizationId),
                    organizationName,
                    savedSpecificCustomers[
                        String(organizationId)
                    ] || {
                        to: [],
                        cc: [],
                        bcc: []
                    }
                );
            }
        );
    }
}
        $(document)
            .off('click.notificationCardCollapse', '#notificationUsersContainer .toggle-notification-card')
            .on(
                'click.notificationCardCollapse',
                '#notificationUsersContainer .toggle-notification-card',
                function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    const button = $(this);
                    const card = button.closest('.card');
                    const cardBody = card.children('.collapsible-card-body');
                    const symbol = button.find('.collapse-symbol');
                    const isVisible = cardBody.is(':visible');

                    cardBody.stop(true, true).slideToggle(200);

                    button.attr('aria-expanded', !isVisible);
                    symbol.text(isVisible ? '+' : '−');
                }
            );


            $(document)
                .off(
                    'change.notificationRecipientSummary',
                    '#notificationUsersContainer .select-user'
                )
                .on(
                    'change.notificationRecipientSummary',
                    '#notificationUsersContainer .select-user',
                    function () {
                        const userId = $(this).data('user-id');
                        const isChecked = $(this).is(':checked');
                        const type = $(this).data('type');

                        // Keep duplicate instances of the same user synchronized.
                        if (userId !== undefined && type) {
                            $(`.select-user[data-user-id="${userId}"][data-type="${type}"]`)
                                .prop('checked', isChecked);
                        }

                        updateSelectedRecipientsSummary();
                    }
                );
            $('#notification_groups_table').off('click', '.edit_template').on('click', '.edit_template', function () {
                var templateId = $(this).data('id');

                $.ajax({
                    url:`{{ url('notification_templates/email/edit')}}/${templateId}`,
                    method: 'GET',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        $('#edit_template_id').val(data.id);
                        $('#edit_function_name').val(data.function_name);
                        $('#edit_notification_key').val(data.template_key);
                        $('#edit_notification_name').val(data.name);
                        $('#edit_title').val(data.subject);
                        $('#edit_controller').val(data.controller);
                        // quill_edit.root.innerHTML = data.body; // Be cautious with unescaped HTML

                        $('#edit_notification_body').val(data.body);
                        $('#edit_description').val(data.description);
                        console.log(data.active);

                        $('#edit_status').val(data.active);
                        $('#environment').val(data.environment);

                        // Set form action for update
                        $('#editTemplateForm').attr('action', `{{ url('notification_templates/email/update')}}/${data.id}`);

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

function loadSpecificOrganizationCustomers(
    templateID,
    organizationId,
    organizationName,
    selectedCustomers = {}
) {
    const parentContainer = $(
        `#specificOrganizationCustomers_${templateID}`
    );

    if (!parentContainer.length) {
        console.error(
            `Customer container not found: #specificOrganizationCustomers_${templateID}`
        );
        return;
    }

    organizationId = String(organizationId);

    const blockId =
        `specificOrganizationBlock_${templateID}_${organizationId}`;

    /*
     * Prevent duplicate organizations.
     */
    if ($(`#${blockId}`).length) {
        return;
    }

    selectedCustomers = {
        to: (selectedCustomers.to || []).map(String),
        cc: (selectedCustomers.cc || []).map(String),
        bcc: (selectedCustomers.bcc || []).map(String)
    };

    parentContainer.append(`
        <div
            id="${blockId}"
            class="specific-organization-block"
            data-template-id="${templateID}"
            data-organization-id="${organizationId}"
        >
            <input
                type="hidden"
                name="specific_organization_ids[]"
                value="${organizationId}"
            >

            <div class="specific-organization-header">
                <div class="specific-organization-title">
                    <span class="specific-organization-dot">•</span>

                    ${escapeNotificationHtml(organizationName)}
                </div>

                <button
                    type="button"
                    class="remove-specific-organization"
                    data-template-id="${templateID}"
                    data-organization-id="${organizationId}"
                    title="Remove organization"
                >
                    &times;
                </button>
            </div>

            <div class="specific-organization-users">
                <div class="customer-loading text-muted py-2">
                    Loading customers...
                </div>
            </div>
        </div>
    `);

    const url = "{{ route(
        'admin.email-notifications.organization-customers',
        ['organization' => '__ORGANIZATION__']
    ) }}".replace(
        '__ORGANIZATION__',
        encodeURIComponent(organizationId)
    );

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',

        success: function (response) {
            let customers = [];

            if (Array.isArray(response.customers)) {
                customers = response.customers;
            } else if (Array.isArray(response.data)) {
                customers = response.data;
            } else if (Array.isArray(response)) {
                customers = response;
            }

            renderOrganizationCustomers(
                blockId,
                organizationId,
                customers,
                selectedCustomers
            );
        },

        error: function (xhr) {
            console.error(
                'Customer loading error:',
                xhr.status,
                xhr.responseText
            );

            $(`#${blockId} .specific-organization-users`).html(`
                <div class="text-danger py-2">
                    Unable to load organization customers.
                </div>
            `);
        }
    });
}
function renderOrganizationCustomers(
    blockId,
    organizationId,
    customers,
    selectedCustomers
) {
    const customerContainer = $(
        `#${blockId} .specific-organization-users`
    );

    if (!customers.length) {
        customerContainer.html(`
            <div class="text-muted py-2">
                No customers found for this organization.
            </div>
        `);

        return;
    }

    let html = `
        <div class="specific-recipient-header">
            <div>TO</div>
            <div>CC</div>
            <div>BCC</div>
            <div>Customer</div>
        </div>
    `;

    customers.forEach(function (customer) {
        const contactId = String(customer.id);

        const checkedTo = selectedCustomers.to.includes(contactId)
            ? 'checked'
            : '';

        const checkedCc = selectedCustomers.cc.includes(contactId)
            ? 'checked'
            : '';

        const checkedBcc = selectedCustomers.bcc.includes(contactId)
            ? 'checked'
            : '';

        const customerName =
            customer.name
            || [
                customer.first_name || '',
                customer.last_name || ''
            ].join(' ').trim()
            || customer.email
            || `Contact #${customer.id}`;

        html += `
            <div class="specific-recipient-row">
                <div>
                    <input
                        type="checkbox"
                        class="select-user"
                        name="specific_customers[${organizationId}][to][]"
                        value="${customer.id}"
                        data-type="to"
                        data-recipient-kind="customer"
                        data-recipient-key="customer-${organizationId}-${customer.id}"
                        data-recipient-name="${escapeNotificationHtml(customerName)}"
                        data-recipient-email="${escapeNotificationHtml(customer.email || '')}"
                        ${checkedTo}
                    >
                </div>

                <div>
                    <input
                        type="checkbox"
                        class="select-user"
                        name="specific_customers[${organizationId}][cc][]"
                        value="${customer.id}"
                        data-type="cc"
                        data-recipient-kind="customer"
                        data-recipient-key="customer-${organizationId}-${customer.id}"
                        data-recipient-name="${escapeNotificationHtml(customerName)}"
                        data-recipient-email="${escapeNotificationHtml(customer.email || '')}"
                        ${checkedCc}
                    >
                </div>

                <div>
                    <input
                        type="checkbox"
                        class="select-user"
                        name="specific_customers[${organizationId}][bcc][]"
                        value="${customer.id}"
                        data-type="bcc"
                        data-recipient-kind="customer"
                        data-recipient-key="customer-${organizationId}-${customer.id}"
                        data-recipient-name="${escapeNotificationHtml(customerName)}"
                        data-recipient-email="${escapeNotificationHtml(customer.email || '')}"
                        ${checkedBcc}
                    >
                </div>

                <div class="specific-customer-name">
                    ${escapeNotificationHtml(customerName)}

                    ${
                        customer.email
                            ? `
                                <small class="d-block text-muted">
                                    ${escapeNotificationHtml(
                                        customer.email
                                    )}
                                </small>
                            `
                            : ''
                    }
                </div>
            </div>
        `;
    });

    customerContainer.html(html);
    updateSelectedRecipientsSummary();
}
function escapeNotificationHtml(value) {
    return $('<div>')
        .text(value == null ? '' : String(value))
        .html();
}
$(document)
    .off(
        'click.removeSpecificOrganization',
        '.remove-specific-organization'
    )
    .on(
        'click.removeSpecificOrganization',
        '.remove-specific-organization',
        function () {
            const templateID = String(
                $(this).data('template-id')
            );

            const organizationId = String(
                $(this).data('organization-id')
            );

            $(
                `#specificOrganizationBlock_${templateID}_${organizationId}`
            ).slideUp(150, function () {
                $(this).remove();
                updateSelectedRecipientsSummary();
            });
        }
    );


</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
