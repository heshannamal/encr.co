
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

</style>

<div class="modal fade" id="usergroup_members_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title headder_size headder_size1" id="modal-title-default">Edit <span id="group_name">User Group</span> Members</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('user_groups.update_members') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
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
                        <button class="btn btn-secondary btn-custom" type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn btn-success btn-custom">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#usergroup_members_modal').on('shown.bs.modal', function (e) {
        var userGroupId = $('#user_group_members_group_id').val();

        $.ajax({
            url: '{{url("user_groups/get_members")}}/'+userGroupId,
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
                            col = '<td><input type="checkbox" class="form-input check-user" name="users['+ members[i].id +']" id="check-'+ members[i].id +'" value="'+ members[i].id +'" checked></td>';
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
                            col = '<td><input type="checkbox" class="form-input check-user" name="users['+ users[i].id +']" id="check-'+ users[i].id +'" value="'+ users[i].id +'" ></td>';
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
                //             col = '<td><input type="checkbox" class="form-input check-user" name="users['+ other_users[i].id +']" id="check-'+ other_users[i].id +'" value="'+ other_users[i].id +'" ></td>';
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

    function selectionCheck(){
        if($(".check-user:checked").length > 0){
            $("#select-all-check").prop("indeterminate", true);
        } else {
            $("#select-all-check").prop("indeterminate", false);
        }
    }

    // $(".delete").on("click", function(){
    //     var userGroupId = $('#user_group_id').val();
    //     window.location.replace("../../user_groups/delete/"+userGroupId);
    // });

</script>
