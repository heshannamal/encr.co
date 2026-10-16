
<style>
    .group_name {
        width: 40%;
    }
    #edit_user_group_name,
    #edit_narration {
        width: 60%;
    }
    .form-input {
        width: 100%;
        height: 16px;
    }
    .form-input.select-all{
        width: 100%;
        height: 18px;
    }
    .table td {
        padding: 0.5rem;
    }

/* =========================================================
   USER GROUP MEMBERS MODAL - MOBILE RESPONSIVE
   ========================================================= */

@media (max-width: 767.98px) {

    /* Modal */
    #usergroup_members_modal .modal-dialog {
        width: calc(100% - 20px) !important;
        max-width: none !important;
        margin: 10px auto !important;
    }

    #usergroup_members_modal .modal-content {
        border: 0 !important;
        border-radius: 16px !important;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
    }

    /* Header */
    #usergroup_members_modal .modal-header {
        padding: 16px 18px !important;
        align-items: center;
        border-bottom: 1px solid #eeeeee !important;
    }

    #usergroup_members_modal .modal-title {
        font-size: 17px !important;
        font-weight: 700 !important;
        line-height: 1.3;
        margin: 0 !important;
        padding-right: 10px;
    }

    #usergroup_members_modal .modal-header .close {
        font-size: 25px !important;
        line-height: 1;
        padding: 0 !important;
        margin: 0 !important;
        opacity: .6;
    }

    /* Body */
    #usergroup_members_modal .modal-body {
        padding: 12px !important;
        max-height: calc(100vh - 180px);
        overflow-y: auto;
    }

    #usergroup_members_modal .modal-body > .col-md-12 {
        padding: 0 !important;
    }

    #usergroup_members_modal .flex01 {
        display: block !important;
        margin: 0 !important;
    }

    #usergroup_members_modal .flex01 > .form-field:first-child,
    #usergroup_members_modal .flex01 > .form-field:last-child {
        display: none !important;
    }

    #usergroup_members_modal .flex01 > .col-md-10 {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
    }

    /* Table wrapper */
    #usergroup_members_modal table {
        width: 100% !important;
        margin: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 8px !important;
    }

    /* Hide normal table header except select-all */
    #usergroup_members_modal thead {
        display: block !important;
        background: transparent !important;
    }

    #usergroup_members_modal thead tr {
        display: flex !important;
        align-items: center;
        background: #f7f8fa !important;
        border-radius: 10px;
        padding: 10px 12px;
        margin-bottom: 5px;
    }

    #usergroup_members_modal thead th {
        border: 0 !important;
        padding: 0 !important;
    }

    #usergroup_members_modal thead th:first-child {
        width: 35px !important;
        min-width: 35px !important;
    }

    #usergroup_members_modal thead th:not(:first-child) {
        display: none !important;
    }

    /* Select all checkbox */
    #usergroup_members_modal #select-all-check {
        width: 18px;
        height: 18px;
        margin: 0;
        cursor: pointer;
    }

    #usergroup_members_modal thead th:first-child::after {
        content: "Select all";
        font-size: 12px;
        font-weight: 600;
        color: #777;
        margin-left: 8px;
        vertical-align: 2px;
    }

    /* Table body */
    #usergroup_members_modal tbody {
        display: block !important;
        width: 100% !important;
    }

    /* Each user becomes a card */
    #usergroup_members_modal tbody tr {
        display: grid !important;
        grid-template-columns: 34px 1fr !important;
        grid-template-rows: auto auto !important;

        width: 100% !important;
        margin: 0 0 8px 0 !important;
        padding: 12px !important;

        background: #ffffff !important;
        border: 1px solid #eeeeee !important;
        border-radius: 12px !important;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.045);

        transition: all .2s ease;
    }

    #usergroup_members_modal tbody tr:active {
        transform: scale(.99);
    }

    /* Checkbox */
    #usergroup_members_modal tbody tr td:first-child {
        grid-column: 1;
        grid-row: 1 / span 2;

        display: flex !important;
        align-items: center;
        justify-content: flex-start;

        padding: 0 !important;
        border: 0 !important;
    }

    #usergroup_members_modal .check-user {
        width: 18px;
        height: 18px;
        margin: 0 !important;
        cursor: pointer;
    }

    /* User name */
    #usergroup_members_modal tbody tr td:nth-child(2) {
        grid-column: 2;
        grid-row: 1;

        padding: 0 0 3px 0 !important;
        border: 0 !important;

        font-size: 14px !important;
        font-weight: 600 !important;
        color: #303030 !important;
        line-height: 1.4;
    }

    /* Email */
    #usergroup_members_modal tbody tr td:nth-child(3) {
        grid-column: 2;
        grid-row: 2;

        padding: 0 !important;
        border: 0 !important;

        font-size: 12px !important;
        color: #8a8a8a !important;
        line-height: 1.4;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    #usergroup_members_modal tbody tr label {
        margin: 0 !important;
        cursor: pointer;
    }

    /* Footer */
    #usergroup_members_modal .modal-footer {
        padding: 12px 15px !important;
        border-top: 1px solid #eeeeee !important;
        background: #fafafa;
    }

    #usergroup_members_modal .modal-footer .control-btns {
        padding: 0 !important;
        display: flex !important;
        gap: 8px;
    }

    #usergroup_members_modal .modal-footer .btn-custom {
        flex: 1;
        min-height: 42px;
        margin: 0 !important;
        border-radius: 9px !important;
        font-size: 13px !important;
        font-weight: 600;
    }

}

</style>

<div class="modal fade" id="usergroup_members_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add/Remove CC Email Addresses</h3>
                <button type="button" class="close_usergroup_members_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row flex01">
                        <input type="hidden" id="user_group_members_group_id" name="user_group_members_group_id"/>
                        <div class="col-md-1 form-field"></div>
                        <div class="col-md-10 form-field">
                            <table class="table align-items-center">
                                <thead class="bg-theme" id="user_group_members_table">
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="form-input select-all" id="select-all-check" />
                                        </th>
                                        <th>User</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="user_group_members_table_tbody">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1 form-field"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-lg-12 control-btns">
                    <button type="button" class="btn btn-secondary btn-custom close_usergroup_members_modal" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-custom" id="cc_user_update">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#usergroup_members_modal').on('shown.bs.modal', function (e) {

        var orderId = $('#notify_order_id').val();


        $.ajax({
            url: '{{url("order_details/get_sales_team")}}/'+orderId,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                $('#user_group_members_table_tbody').html('');
                var members = data[0];
                var users = data[1];
                // var other_users = data[2];

                if(members.length > 0){
                    for (var i = 0; i < members.length; i++) {
                        var row = $('<tr>');
                        var col = '';
                            col = '<td><input type="checkbox" class="form-input check-user" name="users['+ members[i].id +']" id="check-'+ members[i].id +'" value="'+ members[i].id +'" data-user_email="'+ members[i].email +'" checked></td>';
                            col += '<td> <label for="check-'+ members[i].id +'"> '+ members[i].name +' </label></td>';
                            col += '<td> <label for="check-'+ members[i].id +'"> '+ members[i].email +' </label></td></tr>';
                            row.append(col);
                            row.appendTo('#user_group_members_table_tbody');
                    }
                }

                if(users.length > 0){
                    for (var i = 0; i < users.length; i++) {
                        var row = $('<tr>');
                        var col = '';
                            col = '<td><input type="checkbox" class="form-input check-user" name="users['+ users[i].id +']" id="check-'+ users[i].id +'" value="'+ users[i].id +'" data-user_email="'+ users[i].email +'"></td>';
                            col += '<td> <label for="check-'+ users[i].id +'"> '+ users[i].name +' </label></td>';
                            col += '<td> <label for="check-'+ users[i].id +'"> '+ users[i].email +' </label></td></tr>';
                            row.append(col);
                            row.appendTo('#user_group_members_table_tbody');
                    }
                }

                // if(other_users.length > 0){
                //     for (var i = 0; i < other_users.length; i++) {
                //         var row = $('<tr>');
                //         var col = '';
                //             col = '<td><input type="checkbox" class="form-input check-user" name="users['+ other_users[i].id +']" id="check-'+ other_users[i].id +'" value="'+ other_users[i].id +'" data-user_email="'+ other_users[i].email +'" ></td>';
                //             col += '<td> <label for="check-'+ other_users[i].id +'"> '+ other_users[i].name +' </label></td>';
                //             col += '<td> <label for="check-'+ other_users[i].id +'"> '+ other_users[i].email +' </label></td></tr>';
                //             row.append(col);
                //             row.appendTo('#user_group_members_table_tbody');
                //     }
                // }

                selectionCheck();
            }
        });
    });

    $("#select-all-check").click(function(){
        if($(".check-user:checked").length > 0){
            $("#select-all-check").prop("checked", false);
            $(".check-user").prop('checked', false).attr('checked', false);
        } else {
            if($("#select-all-check").is(':checked'))
            {
                $(".check-user").prop('checked', true).attr('checked', true);
            }else
            {
                $(".check-user").prop('checked', false).attr('checked', false);
            }
        }
    });

    $("body").on ('click', '.check-user', function(){
        selectionCheck();
    });

    $('body').on('click', '#cc_user_update', function(){
        var cc_users = [];
        $('.check-user:checkbox:checked').each(function () {
            cc_users.push($(this).data('user_email'));
        });

        var ccEmailArr = [];
        for (let i = 0; i < cc_users.length; i++) {
            if (i == (cc_users.length - 1)) {
                ccEmailArr += cc_users[i];
            } else {
                ccEmailArr += cc_users[i]+', ';
            }
        }

        $('#cc_email').val(ccEmailArr);
        $('#cc_email').attr('data-cc_emails', cc_users);
        $('#usergroup_members_modal').modal('hide');
        console.log(cc_users);
    });

    $('body').on('click', '.close_usergroup_members_modal', function () {
        $('#usergroup_members_modal').modal('hide');
    });

    function selectionCheck(){
        if($(".check-user:checked").length > 0){
            $("#select-all-check").prop("indeterminate", true);
        } else {
            $("#select-all-check").prop("indeterminate", false);
        }
    }
</script>
