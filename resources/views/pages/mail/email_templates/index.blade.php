@extends('layouts.app', ['activePage' => 'Template', 'titlePage' => __('Email Templates')])

@section('content')
<style>
    .table-style{
        width: 100% !important;
    }
    .ql-picker{
    margin-bottom: .25rem;
}
.ql-formats .selection{
    display: none;
}
.ql-formats .select2-hidden-accessible{
    display: none;
}
.ql-formats .select2-container{
    display: none;
}
    .btn-green-filled{
        outline: unset !important;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        padding: .4rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .toggle-container {
  width: 40px; /* Width of the toggle button */
  height: 24px; /* Height of the toggle button */
  background-color: rgb(165, 32, 32); /* Default color */
  border-radius: 50px; /* Half of the height */
  position: relative;
  cursor: pointer;
}
input:checked + .toggle-container {
  background-color: green;
}

/* Toggle button circle */
.toggle-circle {
  width: 20px; /* Diameter of the circle */
  height: 20px; /* Diameter of the circle */
  background-color: #fff;
  border-radius: 50%;
  position: absolute;
  top: 1px; /* Position vertically centered */
  left: 1px; /* Position horizontally centered */
  transition: transform 0.3s ease;
}

/* Styling when the toggle is switched on */
input:checked + .toggle-container .toggle-circle {
  transform: translateX(100%);
}
.select2-selection__rendered {
    /* font-size: 13px !important; */
    color: #000000 !important;
    line-height: 30px !important;
    background-color: rgb(252, 89, 89);
    border: 1px solid #b5bfb5;
    border-radius: 5px;
}
.form-label{
    font-size: 15px;
}
.info-form-input {
    width: 100%;
    height: 1.95rem;
    border-radius: 5px;
    padding-left: 5px;
    padding-right: 5px;
    font-size: 15px;
}
.template-unique-styles table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .template-unique-styles table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .template-unique-styles table thead tr{
        background-color: rgba(50, 50, 50, 1);
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .template-unique-styles table tr{
        background-color: white;
        color: rgba(22, 22, 23, 1);
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .template-unique-styles th, .template-unique-styles td {
        padding: 5px;
    }
    .template-unique-styles .dataTables_info {
        color:#b3b3b3;
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
    .searchbox-layout{
        margin-top: 0 !important;
        width: 100% !important;
        height: 29px;
        font-size: .7rem;
        color: grey !important;
        border: unset;
        outline: unset;
    }
    .template-bar-new-tab-bar{
        color: grey !important;
        border: none;
        font-size: .9rem;
        background-color: transparent;
        width: 10rem;
        font-weight: 600;
    }
    .template-bar-new-tab-bar:hover , .template-bar-new-tab-bar.active{
        color: black !important;
        border-bottom: 2px solid black !important;
        width: 10rem;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }
    .template-table-layouts.table th, .template-table-layouts.table td, .template-table-layouts.table thead th {
        vertical-align: middle !important;
    }
    .template-checkbox {
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        border: 1px solid #b3b3b3;
        background-color: white;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
        position: relative;
        display: inline-block;
        text-align: center;
        line-height: 1rem;
        font-size: 1rem;
    }

    .template-checkbox:checked {
        background-color: #5db491;
        border-color: #5db491;
    }

    .template-checkbox:checked::before {
        content: '\f058'; /* Font Awesome check circle icon */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.75rem;
    }
    .ql-editor ol li {
        list-style-type: decimal !important;
        /* margin-left: 20px; Adjust as necessary */
    }

        .ql-editor ul li {
        list-style-type: disc !important;
        /* margin-left: 20px; Adjust as necessary */
    }

/* ================================
   MOBILE TEMPLATE RESPONSIVE VIEW
================================ */

@media(max-width:768px){


    /* Top Search + Create Button */
    .btn-inside-table{
        display:block !important;
        width:100% !important;
    }


    .btn-inside-table tr{
        display:flex;
        flex-direction:column;
        width:100%;
    }


    .btn-inside-table td{
        width:100% !important;
        padding:8px 0 !important;
        text-align:center !important;
    }


    .btn-inside-table td:first-child{
        display:none;
    }


    .btn-inside-table .row{
        margin:0 !important;
        display:flex;
        align-items:center;
    }


    .btn-inside-table .col-lg-1{
        width:15%;
        padding:0;
    }


    .btn-inside-table .col-lg-10{
        width:85%;
        padding:0;
    }


    #create_template_btn{
        width:100%;
        height:38px;
        font-size:.75rem;
    }



    /* Action buttons top */
    .drive-controls{
        float:none !important;
        display:flex;
        flex-wrap:wrap;
        gap:5px;
    }


    .drive-controls button{
        flex:1;
        font-size:11px !important;
    }



    /* Tabs */
    .template-bar-new-tab-bar,
    .template-bar-new-tab-bar:hover,
    .template-bar-new-tab-bar.active{

        width:50% !important;
        font-size:.75rem;
        padding:10px 5px;
    }


    .col-md-12[style*="border-bottom"]{
        display:flex;
    }




    /* =====================
       DATATABLE CARD VIEW
    ======================*/


    .mobile-card-table{
        border:none !important;
        width:100% !important;
    }



    /* Header checkbox area */
    .mobile-card-table thead{
        display:block !important;
    }


    .mobile-card-table thead tr{
        display:block;
        background:white !important;
        color:#333 !important;
        height:auto !important;
        border:none !important;
        margin-bottom:15px;
    }


    .mobile-card-table thead th{
        display:none;
    }


    .mobile-card-table thead th:first-child{
        display:block;
        width:100% !important;
        text-align:left !important;
        padding:10px !important;
        /* border-radius:10px;
        background:#f8f9fa; */
        border-top: 1px solid rgb(218, 218, 218);
    }


    /* .mobile-card-table thead th:first-child:after{
        content:"Select All Templates";
        margin-left:10px;
        font-size:14px;
        color:#555;
        font-weight:600;
    } */




    /* Body */

    .mobile-card-table tbody{
        display:block;
        width:100%;
    }


    .mobile-card-table tbody tr{

        display:block !important;
        background:white;
        border-radius:15px;
        padding:15px;
        margin-bottom:15px;

        box-shadow:0 3px 12px rgba(0,0,0,.08);

        border:1px solid #eeeeee;

    }



    .mobile-card-table tbody td{

        display:block !important;

        width:100% !important;

        border:none !important;

        padding:8px 0 !important;

        text-align:left !important;

        font-size:13px;

    }





    /* checkbox left */

    .mobile-card-table tbody td:first-child{

        display:block !important;

        position:absolute;
        top: 0px;
    }


    .mobile-card-table tbody tr{

        position:relative;

    }


    .mobile-card-table tbody td:first-child .form-check{

        margin:0;

    }




    /* All other content */

    .mobile-card-table tbody td:not(:first-child){

        padding-left:0;

    }




    /* Label */

    .mobile-card-table tbody td:before{

        display:block;

        font-size:12px;

        font-weight:700;

        color:#9CA3AF;

        margin-bottom:4px;

        text-align:left;

    }




    .mobile-card-table tbody td:nth-child(2):before{
        content:"Title";
    }


    .mobile-card-table tbody td:nth-child(3):before{
        content:"Email Subject";
    }




    /* Bottom information row */


    .mobile-card-table tbody td:nth-child(4),
    .mobile-card-table tbody td:nth-child(5),
    .mobile-card-table tbody td:nth-child(6),
    .mobile-card-table tbody td:nth-child(7){

        width:50% !important;

        display:inline-block !important;

        vertical-align:top;

    }



    .mobile-card-table tbody td:nth-child(4):before{
        content:"Status";
    }


    .mobile-card-table tbody td:nth-child(5):before{
        content:"Created Date";
    }


    .mobile-card-table tbody td:nth-child(6):before{
        content:"Created By";
    }


    .mobile-card-table tbody td:nth-child(7):before{
        content:"Action";
    }



    /* make bottom section flex */

    .mobile-card-table tbody tr{

        display:flex !important;

        flex-wrap:wrap;
        padding-top: 30px;

    }



    .mobile-card-table tbody td:nth-child(1),
    .mobile-card-table tbody td:nth-child(2),
    .mobile-card-table tbody td:nth-child(3){

        width:100% !important;

    }



    .mobile-card-table tbody td:nth-child(4),
    .mobile-card-table tbody td:nth-child(5),
    .mobile-card-table tbody td:nth-child(6),
    .mobile-card-table tbody td:nth-child(7){

        width:50% !important;

    }




    /* Long text */

    .mobile-card-table a{

        display:block;

        max-width:90%;

        overflow:hidden;

        text-overflow:ellipsis;

        white-space:nowrap;

    }



    /* Buttons */

    .mobile-card-table button{

        font-size:11px !important;

        padding:5px 8px !important;

    }



    /* Remove datatable overflow */

    .dataTables_wrapper{
        overflow:hidden !important;
        background-color: white;
        padding: 10px;
        border-radius: 8px;
    }
    .template-table-layouts tbody {
        display: block;
        width: 100%;
    }
    .mobile_search_icon {
        border-bottom: unset !important;
    }
    .mobile_search_main_div {
        background-color: white;
        margin-bottom: 5px;
        border-radius: 7px;
        padding-right: 10px !important;
    }
    .card {
        background-color: transparent;
    }
    .mobile_search_input {
        border-bottom: unset !important;
    }
    .mobile_margin_lr_5rem {
        margin-left: .5rem !important;
        margin-right: .5rem !important;
    }
    .mobile_delete_btn {
        margin-left: unset !important;
    }
    .mobile_selected_btn_div {
        padding-left: 15px !important;
    }
    .mobile_tab_div_row {
        margin: unset !important;
        padding-left: .5rem;
        padding-right: .5rem;
    }
    .mobile_template_tab {
        padding: unset;
    }
    .mobile_template_tab_2 {
        padding: unset;
    }
    .mobile_check_box {
        text-align: left !important;
    }
    #my_list_table_wrapper .row .col-md-6{
        width: 50% !important;
    }
    #public_list_table_wrapper .row .col-md-6{
        width: 50% !important;
    }
    #public_template_tab_content {
        padding: unset;
    }
    .select2 {
        width: 25% !important;
    }
    .dataTables_length {
        width: 50%;
    }

}

</style>


<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Email Templates</span>
    @endsection

    @section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="card" style="border: none;border-radius: 0rem;">
        <input type="hidden" value="" id="publicCheckboxes">
        <input type="hidden" value="" id="myTemplateCheckboxes">
        <input type="hidden" value="" id="myListAddedCheckboxes">
    <div class="row mx-4 mobile_margin_lr_5rem">
        <div class="col-12 ml-auto text-right  mt-3">
            <table class="btn-inside-table template-table-layouts" style="width: 100%">
                <tr>
                    <td style="width: 33.33%"></td>
                    <td class="mobile_search_main_div" style="width: 33.33%">
                        <div class="row">
                            <div class="col-lg-1 mobile_search_icon" style="border-bottom: 1px solid #B3B3B3">
                                <i class="fa fa-search" aria-hidden="true" style="font-size: 19px;color: #B3B3B3;top: 23%;position: relative;"></i>
                            </div>
                            <div class="col-lg-10 text-center mobile_search_input" style="border-bottom: 1px solid #B3B3B3;">
                                <input class="searchbox-layout"  type="text" id="searchbox" placeholder="Search Template">
                            </div>
                        </div>
                    </td>
                    <td style="width: 33.33%">
                        <button id="create_template_btn" class="btn-green-filled" style="outline: unset;" title="Add New Template">
                            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;CREATE TEMPLATE
                        </button>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-12 mobile_selected_btn_div" style="padding-left: 0px">
            <div class="drive-controls activity-top-controls mt-3 mb-3 float-left">
                    <button type="submit" onclick="deleteSelected()" class="btn btn-secondary btn-sm ml-1 mobile_delete_btn" title="Delete Selected" style="background-color: rgb(255 121 116);color:white;display:none" id="delete_selected"><i class="fa fa-times-circle" aria-hidden="true"></i><small>Delete Selected</small></button>
                    <button type="submit" onclick="removeFromList()" class="btn btn-secondary btn-sm mr-1" title="Remove From List" id="remove_from_list" style="background-color: #fb9e7c;color: white;display:none"><i class="far fa-times-circle"></i><small>Remove From List</small></button>
                    <button type="submit" onclick="addToMyList()" class="btn btn-secondary btn-sm" title="Add To My List" id="add_to_my_lists" style="background-color: #7caafb;color: white;display:none"><i class="far fa-check-circle"></i><small>Add To My List</small></button>
            </div>
        </div>
    </div>
        <div class="col-md-12" style="padding: 1rem;">
            <div class="row mobile_tab_div_row">
                <div class="col-md-12 mb-3" style="padding-left: 0px;border-bottom: 2px solid #b3b3b3;">
                    <button type="button" id="activity-tab-active-button" class="template-bar-new-tab-bar">MY TEMPLATES</button>
                    <button type="button" class="template-bar-new-tab-bar active">PUBLIC TEMPLATES</button>
                </div>
            </div>
        </div>
    <div class="row mx-4">
    <div class="col-md-12 template_tab mobile_template_tab" id="my_template_tab_content">
        <div class="col-12 mt-1 mb-1 template-unique-styles mobile_template_tab_2" style="border-bottom: 1px solid #c5c5c5;">
            <table class="table table-responsive table-style template-table-layouts mobile-card-table" id="my_list_table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 10%;" class="text-center template-no">
                            <div class="form-check text-center mobile_check_box">
                                <input type="checkbox" class="form-check-input template-checkbox" id="template_checkbox_my">
                                <label class="form-check-label" for="template_checkbox_my"></label>
                            </div>
                        </th>
                        <th style= "width: 25%;" class="template-title">Title</th>
                        <th style= "width: 25%;" class="template-subject">Email subject</th>
                        <th style="width: 10%;"class="text-center template-status">status</th>
                        <th style="width: 10%;">Date created</th>
                        <th style="width: 10%;">Created By</th>
                        <th style="width: 10%;" class="text-center template-action">Action</th>
                    </tr>
                </thead>
              </table>
        </div>
    </div>
    <div class="col-md-12 template_tab mobile_template_tab" id="public_template_tab_content">
        <div class="col-12 mt-1 mb-1 template-unique-styles mobile_template_tab_2" style="border-bottom: 1px solid #c5c5c5;">
            <table class="table table-responsive table-style mobile-card-table" id="public_list_table">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 10%;" class="text-center template-no">
                            <div class="form-check text-center mobile_check_box">
                                <input type="checkbox" class="form-check-input template-checkbox" id="template_checkbox_public">
                                <label class="form-check-label" for="template_checkbox_public"></label>
                            </div>
                        </th>
                        <th style= "width: 25%;" class="template-title">Title</th>
                        <th style= "width: 25%;" class="template-subject">Email subject</th>
                        <th style="width: 10%;"class="text-center template-status">status</th>
                        <th style="width: 10%;">Date created</th>
                        <th style="width: 10%;">Created By</th>
                        <th style="width: 10%;" class="text-center template-action">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
</div>
</div>

@include('pages.mail.email_templates.create')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    makeTables();
    function makeTables() {

        $('#delete_selected').hide();
        $('#remove_from_list').hide();
        $('#add_to_my_lists').hide();

        $.ajax({
                url: '{{ url("email/templates/getAllTableData") }}',
                type: "GET",
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    console.log(data);
                    var publicEmailTemplates = data.PublicEmailTemplates;
                    var emailTemplates = data.emailTemplates;
                    var addedEmailTemplates = data.AddedEmailTemplates;
                    createPublicEmailTemplatesTbody(publicEmailTemplates);
                    createMyEmailTemplatesTbody(emailTemplates, addedEmailTemplates);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

    }

    function createPublicEmailTemplatesTbody(data) {
        var all_users = @json($all_users);
        if ($.fn.DataTable.isDataTable('#public_list_table')) {
            $('#public_list_table').DataTable().clear().destroy();
        }
        var table = $('#public_list_table').DataTable({
            columnDefs: [
                { targets: 'template-no', orderable: false }
            ]
        });
        table.clear().draw();

        var templatesArray = Object.values(data);
        templatesArray.forEach((item) => {
            var checkbox = '<div class="form-check text-center mobile_check_box">'+
                                '<input type="checkbox" class="form-check-input template-checkbox" data-is_public="true" data-is_my_template="false" data-is_my_list_added="false" id="template_checkbox_' + item.id + '" value="' + item.id + '">'+
                                '<label class="form-check-label" for="template_checkbox_' + item.id + '"></label>'+
                            '</div>';
            var user_details = all_users.find(user => user.id == item.user_id);
            var status = item.publish_type == 0 ? '<span class="badge badge-pill badge-danger">Private</span>' : '<span class="badge badge-pill badge-success">Public</span>';
            var button = '<button type="button" class="btn btn-info btn-sm template-add" data-template_id="' + item.id + '">Add to My List</button>';
            table.row.add([checkbox, '<a href="#" class="template_id-edit" data-template_id="' + item.id + '">' + truncateString(item.title, 55) + '</a>', truncateString(item.subject, 30), status, formatDate(item.created_at), user_details ? user_details.name : '', button]).draw();
        });
    }

    function createMyEmailTemplatesTbody(emailTemplates, addedEmailTemplates) {
        var all_users = @json($all_users);
        if ($.fn.DataTable.isDataTable('#my_list_table')) {
            $('#my_list_table').DataTable().clear().destroy();
        }
        var table = $('#my_list_table').DataTable({
            columnDefs: [
                { targets: 'template-no', orderable: false }
            ]
        });
        table.clear().draw();
        emailTemplates.forEach((item) => {
            var checkbox = '<div class="form-check text-center mobile_check_box">'+
                                '<input type="checkbox" class="form-check-input template-checkbox" data-is_public="false" data-is_my_template="true" data-is_my_list_added="false" id="template_checkbox_' + item.id + '" value="' + item.id + '">'+
                                '<label class="form-check-label" for="template_checkbox_' + item.id + '"></label>'+
                            '</div>';
            var user_details = all_users.find(user => user.id == item.user_id);
            var status = item.publish_type == 0 ? '<span class="badge badge-pill badge-danger">Private</span>' : '<span class="badge badge-pill badge-success">Public</span>';
            var button = '<button type="button" class="btn btn-danger btn-sm my-template-remove" data-template_id="' + item.id + '" style="font-size: .55rem;padding: .15rem .3rem;">Delete</button>';
            table.row.add([checkbox, '<a href="#" class="template_id-edit" data-template_id="' + item.id + '">' + truncateString(item.title, 55) + '</a>', truncateString(item.subject, 30), status, formatDate(item.created_at), user_details ? user_details.name : '', button]).draw();
        });

        addedEmailTemplates.forEach((item) => {
            var checkbox = '<div class="form-check text-center mobile_check_box">'+
                                '<input type="checkbox" class="form-check-input template-checkbox" data-is_public="false" data-is_my_template="false" data-is_my_list_added="true" id="template_checkbox_' + item.email_template.id + '" value="' + item.email_template.id + '">'+
                                '<label class="form-check-label" for="template_checkbox_' + item.email_template.id + '"></label>'+
                            '</div>';
            var user_details = all_users.find(user => user.id == item.email_template.user_id);
            var status = item.email_template.publish_type == 0 ? '<span class="badge badge-pill badge-danger">Private</span>' : '<span class="badge badge-pill badge-success">Public</span>';
            var button = '<button type="button" class="btn btn-danger btn-sm template-remove" data-template_id="' + item.id + '">Remove from List</button>';
            table.row.add([checkbox, '<a href="#" class="template_id-edit" data-template_id="' + item.email_template.id + '">' + truncateString(item.email_template.title, 55) + '</a>', truncateString(item.email_template.subject, 30), status, formatDate(item.created_at), user_details ? user_details.name : '', button]).draw();
        });
    }
    const formatDate = (datetime) => {
        const date = new Date(datetime);
        const options = {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
        };

        return date.toLocaleString('en-US', options);
    };
    function deleteSelected(){
        var myTemplateCheckboxes = $('#myTemplateCheckboxes').val();
            $.ajax({
                url: '{{ url("email/templates/do_with_selected") }}',
                type: "POST",
                dataType: 'json',
                data:{
                    'array_data': myTemplateCheckboxes,
                    'type': 'delete_item',
                    '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    console.log(data);
                },
                complete: function () {
                    location.reload();
                }
            });
    }
    function truncateString(str, num) {
        if (!str) {
            return '';
        }
        if (str.length <= num) {
            return str;
        }
        return str.slice(0, num) + '...';
    }
    function removeFromList(){
        var myListAddedCheckboxes = $('#myListAddedCheckboxes').val();
        $.ajax({
                url: '{{ url("email/templates/do_with_selected") }}',
                type: "POST",
                dataType: 'json',
                data:{
                    'array_data': myListAddedCheckboxes,
                    'type': 'remove_from_list',
                    '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    console.log(data);
                },
                complete: function () {
                    location.reload();
                }
            });
    }
    function addToMyList(){
        var publicCheckboxes = $('#publicCheckboxes').val();
        $.ajax({
                url: '{{ url("email/templates/do_with_selected") }}',
                type: "POST",
                dataType: 'json',
                data:{
                    'array_data': publicCheckboxes,
                    'type': 'add_to_my_list',
                    '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    console.log(data);
                },
                complete: function () {
                    location.reload();
                }
            });
    }

</script>
<script>
$(document).ready(function() {
    var selectedCheckboxes = [];

    $(document).on('change', '.template-checkbox', function() {
        checkboxOptions(this);
    });

    function checkboxOptions(selected_check) {
        var checkboxValue = $(selected_check).val();
        var isChecked = $(selected_check).is(':checked');
        var isPublic = $(selected_check).data('is_public');
        var isMyTemplate = $(selected_check).data('is_my_template');
        var isMyListAdded = $(selected_check).data('is_my_list_added');

        var index = selectedCheckboxes.findIndex(item => item.value === checkboxValue);

        if (isChecked) {
            if (index === -1) {
                selectedCheckboxes.push({
                    value: checkboxValue,
                    is_public: isPublic,
                    is_my_template: isMyTemplate,
                    is_my_list_added: isMyListAdded
                });
            }
        } else {
            if (index !== -1) {
                selectedCheckboxes.splice(index, 1);
            }
        }

        var publicCheckboxes = [];
        var myTemplateCheckboxes = [];
        var myListAddedCheckboxes = [];

        selectedCheckboxes.forEach(element => {
            if (element.is_public) {
                publicCheckboxes.push(element.value);
            }
            if (element.is_my_template) {
                myTemplateCheckboxes.push(element.value);
            }
            if (element.is_my_list_added) {
                myListAddedCheckboxes.push(element.value);
            }
        });

        $('#publicCheckboxes').val(JSON.stringify(publicCheckboxes));
        $('#myTemplateCheckboxes').val(JSON.stringify(myTemplateCheckboxes));
        $('#myListAddedCheckboxes').val(JSON.stringify(myListAddedCheckboxes));

        // Show or hide buttons based on checkbox state
        $('#delete_selected').toggle(myTemplateCheckboxes.length > 0);
        $('#remove_from_list').toggle(myListAddedCheckboxes.length > 0);
        $('#add_to_my_lists').toggle(publicCheckboxes.length > 0);
    }
    $('.template-bar-new-tab-bar:eq(0)').click(function() {
        $(this).addClass('active');
        $('.template-bar-new-tab-bar:eq(1)').removeClass('active');

        $('#my_template_tab_content').show();
        $('#public_template_tab_content').hide();
    });

    // Click event handler for 'PUBLIC TEMPLATES' button
    $('.template-bar-new-tab-bar:eq(1)').click(function() {
        $(this).addClass('active');
        $('.template-bar-new-tab-bar:eq(0)').removeClass('active');

        $('#my_template_tab_content').hide();
        $('#public_template_tab_content').show();
    });

    $('#template_checkbox_public').on('click', function() {
        var isChecked = $(this).is(':checked');
        $('#public_list_table').find('input.template-checkbox').prop('checked', isChecked).each(function() {
            checkboxOptions(this);
        });
    });

    $('#template_checkbox_my').on('click', function() {
        var isChecked = $(this).is(':checked');
        $('#my_list_table').find('input.template-checkbox').prop('checked', isChecked).each(function() {
            checkboxOptions(this);
        });
    });
});
$(document).ready(function() {
    $("#searchbox").on('focusout', function() {
        setUrlParameter($(this).val());
    });

    $("#searchbox").on('keypress', function(event) {
		if (event.keyCode == 13) {
            setUrlParameter($(this).val());
        }
    });
    function setUrlParameter(orgTxt){
        $.ajax({
                url: '{{ url("email/templates/getSearchTableData") }}',
                type: "POST",
                dataType: 'json',
                data:{
                    'search_key': orgTxt,
                    '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    var publicEmailTemplates = data.PublicEmailTemplates;
                    var emailTemplates = data.emailTemplates;
                    var addedEmailTemplates = data.AddedEmailTemplates;
                    createPublicEmailTemplatesTbody(publicEmailTemplates);
                    createMyEmailTemplatesTbody(emailTemplates, addedEmailTemplates);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
    }
        $('#create_template_btn').on('click', function() {
            // Clear modal content
        $('#template_title').val('');
        $('#template_subject').val('');
        quill.setContents([]);// Assuming 'editor-container' is the ID of the Quill editor container
        // Set modal title and button text for creating a new template
        $('#new_template_form_title').html('Create Template');
        $('#submit_btn_text').html('Save');
        $('#email_template_create_form').attr('action', '{{ route("email.templates.store") }}');
        $('#template_title').prop('disabled', false);
        $('#template_subject').prop('disabled', false);
        quill.enable();
        $('#publish_type').prop('disabled', false).trigger('change');
        $('#submit_btn_text').prop('disabled', false);
        // Show the modal
        $('#template_create_modal').modal('show');
    });

    // Your code that depends on DeltaToHtmlConverter class goes here
    $('body').on('click', '.template-add', function(e) {
        e.preventDefault();
        var template_id = $(this).data('template_id');
        console.log(template_id);

        $.ajax({
            url: "{{ url('email/templates/add') }}/" + template_id,
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                $(".se-pre-con").fadeOut('slow');
                makeTables();
            },

        });
    });
    $('body').on('click', '.template-remove', function(e) {
        e.preventDefault();
        var template_id = $(this).data('template_id');
        console.log(template_id);
        Swal.fire({
                title: "Are you sure?",
                text: "Remove the template from your list!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Remove it!"
                }).then((result) => {
                if (result.value) {

                    $.ajax({
                        url: "{{ url('email/templates/remove') }}/" + template_id,
                        method: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function(data) {
                            $(".se-pre-con").fadeOut('slow');
                            makeTables();
                        },

                    });
                }
        });
    });
    $('body').on('click', '.my-template-remove', function(e) {
        e.preventDefault();
        var template_id = $(this).data('template_id');
        console.log(template_id);
        Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.value) {

                    $.ajax({
                            url: "{{ url('email/my/templates/remove') }}/" + template_id,
                            method: 'GET',
                            dataType: 'json',
                            beforeSend: function() {
                                $(".se-pre-con").fadeIn('slow');
                            },
                            success: function(data) {
                                $(".se-pre-con").fadeOut('slow');
                                makeTables();
                            },

                        });
                }
        });
    });
    $('#activity-tab-active-button').click();
});
document.addEventListener('DOMContentLoaded', function() {
    $('body').on('click', '.template_id-edit', function(e) {
        e.preventDefault();
        var template_id = $(this).data('template_id');
        var authenticatedUserId = "{{ Auth::id() }}";
        var authenticatedUserIdInt = parseInt(authenticatedUserId);

        $.ajax({
            url: "{{ url('email/templates/edit') }}/" + template_id,
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                if (data.body) {
                    try {
                        var bodyData = JSON.parse(data.body); // Parse the body string as JSON
                        if (bodyData.ops) {
                            console.log(data);
                            quill.setContents(bodyData.ops);

                        } else {
                            console.error("Invalid data format: ops property missing");
                            // Handle invalid data format
                        }
                    } catch (error) {
                        console.error("Error parsing body data:", error);
                        // Handle parsing error
                    }

                    $('#template_title').val(data.title);
                    $('#template_subject').val(data.subject);
                    $('#template_id').val(template_id);
                    $('#publish_type').val(data.publish_type).trigger('change');



                        if (authenticatedUserIdInt !== parseInt(data.user_id)) {
                            $('#submit_btn_text').hide();
                            $('#template_privacy_section').hide();
                        } else {
                            $('#submit_btn_text').show().html('Update');
                            $('#template_privacy_section').show();
                        }
                        $('#new_template_form_title').html('Edit Template');
                        $('#email_template_create_form').attr('action', '{{ route("email.templates.update") }}');
                    } else {
                        console.error("Invalid data format: body property missing");
                        // Handle invalid data format
                    }

            },
            complete: function() {
                $('#template_create_modal').modal('show');
                $(".se-pre-con").fadeOut('slow');
            }
        });
});
});

// templateConvert();
// function htmlToQuillDelta(htmlString) {
//     var tempDiv = document.createElement('div');
//     tempDiv.innerHTML = htmlString;

//     var quill = new Quill(document.createElement('div'));
//     var editorHtml = tempDiv.innerHTML;

//     return quill.clipboard.convert(editorHtml);
// }
// function templateConvert() {
//     var templates = @json($PublicEmailTemplates);
//     console.log(templates);
//     for (var key in templates) {
//         if (templates.hasOwnProperty(key)) {
//             var element = templates[key];
//             var bodyContent = element.body;
//             var htmlContent = htmlToQuillDelta(bodyContent);
//             console.log(JSON.stringify(htmlContent));
//             var stringfy_quill = JSON.stringify(htmlContent)
//             $.ajax({
//                 url: "{{ url('email/update_html_to_quill') }}/",
//                 method: 'GET',
//                 data: {
//                     'template_id': element.id,
//                     'template_body': stringfy_quill,
//                     'token': '{{ csrf_token() }}'
//                 },
//                 dataType: 'json',
//                 beforeSend: function() {
//                     $(".se-pre-con").fadeIn('fast');
//                 },
//                 success: function(data) {
//                     console.log(data);
//                     $(".se-pre-con").fadeOut('fast');
//                 }
//             });
//         }
//     }
// }
</script>

@endsection
