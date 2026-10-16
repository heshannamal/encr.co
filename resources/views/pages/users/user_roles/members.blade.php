<style>
    @media (max-width: 767px) {

    #userrole_members_modal .modal-dialog {
        margin: 30px 10px 30px !important;
        max-width: calc(100% - 20px) !important;
        width: calc(100% - 20px) !important;
        max-height: calc(100vh - 90px);
        display: flex;
    }

    #userrole_members_modal .modal-content {
        max-height: calc(100vh - 90px);
        display: flex;
        flex-direction: column;
    }

    #userrole_members_modal .modal-body {
        overflow-y: auto;
        flex: 1 1 auto;
    }

    /* Hide the USER / EMAIL header row on mobile */
    #userrole_members_modal .table thead {
        display: none;
    }

    #userrole_members_modal .table,
    #userrole_members_modal .table tbody {
        display: block;
        width: 100%;
        border: none !important;
    }

    /* Each user becomes its own rounded card */
    #userrole_members_modal .table tbody tr {
        display: block;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 10px 12px;
        margin-bottom: 8px;
    }

    #userrole_members_modal .table tbody tr td {
        display: block;
        border: none !important;
        padding: 0 !important;
    }

    #userrole_members_modal .table tbody tr td .custom-control-label {
        font-size: 14px !important;
        font-weight: 600;
        color: #1a1a1a;
    }

    /* Email — its own line, indented to sit under the name text */
    #userrole_members_modal .table tbody tr td:nth-child(2) {
        padding-left: 26px !important;
        margin-top: 2px;
        font-size: 12px !important;
        color: #888888 !important;
    }

    /* Round checkbox, blue with white checkmark when checked — matches the Figma */
    #userrole_members_modal .custom-control-label::before {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        top: 2px;
    }

    #userrole_members_modal .custom-control-label::after {
        width: 18px;
        height: 18px;
        top: 2px;
    }

    #userrole_members_modal .custom-control-input:checked~.custom-control-label::before {
        background-color: #2f6fed;
        border-color: #2f6fed;
    }

    /* Footer buttons side by side, full width */
    #userrole_members_modal .modal-footer {
        display: flex;
        padding: 10px 12px;
        gap: 10px;
    }

    #userrole_members_modal .modal-footer .btn {
        flex: 1 1 0;
        min-width: 0 !important;
    }
    #userrole_members_modal .row {
        display: flex;
        margin-right: 4px;
        margin-left: -10px;
        flex-wrap: wrap;
    }

       #userrole_members_modal .modal-content {
        overflow: hidden;
    }

    #userrole_members_modal .modal-header,
    #userrole_members_modal .modal-footer {
        flex-shrink: 0;
    }

    #userrole_members_modal .modal-footer {
        padding-bottom: calc(14px + env(safe-area-inset-bottom, 0px)) !important;
    }

    button#save_members_btn {
        background: #1AA05A !important;
    }
    .members-search-wrap {
        position: relative;
        margin-bottom: 12px;
    }

    .members-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaaaaa;
        font-size: 13px;
        pointer-events: none;
    }

    .members-search-wrap {
    position: relative;
    margin-bottom: 12px;
    flex: 0 0 100% !important;   /* take the entire row on its own line */
    max-width: 100% !important;
    width: 100%;
    padding: 0 10px;             /* cancels out .row's -10px margin so it lines up with the cards below */
    box-sizing: border-box;
}

    .members-search-input:focus {
        border-color: #2f6fed !important;
        box-shadow: 0 0 0 3px rgba(47, 111, 237, 0.12);
    }

    #userrole_members_modal .custom-control-label {
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }

    #userrole_members_modal .member-name {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
        line-height: 1.3;
    }

    #userrole_members_modal .member-email {
        font-size: 12px;
        color: #888888;
        line-height: 1.3;
        margin-top: 2px;
    }

    .members-search-input {
        width: 100%;
        border: 1px solid #dddddd !important;
        border-radius: 20px !important;
        padding: 8px 14px 8px 34px !important;   /* the 34px left padding is what pushes text past the icon */
        font-size: 13px !important;
        outline: none;
    }

    .members-search-input:focus {
        border-color: #2f6fed !important;
        box-shadow: 0 0 0 3px rgba(47, 111, 237, 0.12);
    }

    



}
</style>

<div class="modal fade" id="userrole_members_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 900px;" role="document">
        <div class="modal-content" style="border-radius: 8px; border: none;">

            <div class="modal-header" style="padding: 1.25rem 1.5rem 0.75rem;">
                <h5 class="modal-title font-weight-bold" id="members_modal_title" style="font-size: 1.1rem;"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body" style="padding: 0.5rem 1.5rem 1rem;">
                <input type="hidden" id="members_role_id" value="">

                <div class="row">
                    <div class="members-search-wrap">
                        <i class="fas fa-search members-search-icon"></i>
                        <input
                            type="text"
                            id="members_search_input"
                            class="form-control members-search-input"
                            placeholder="Search by name or email" />
                    </div>
                    <!-- Left Column -->
                    <div class="col-md-6 pr-1">
                        <table class="table mb-0" style="border: 1px solid #dee2e6;">
                            <thead>
                                <tr>
                                    <th style="background-color:#707070; color:white; font-size:0.72rem; text-transform:uppercase; padding:0.6rem 1rem; border:none; width: 40%;">USER</th>
                                    <th style="background-color:#707070; color:white; font-size:0.72rem; text-transform:uppercase; padding:0.6rem 1rem; border:none;">EMAIL</th>
                                </tr>
                            </thead>
                            <tbody id="members_left_col" style="font-size: 0.82rem;">
                            </tbody>
                        </table>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6 pl-1">
                        <table class="table mb-0" style="border: 1px solid #dee2e6;">
                            <thead>
                                <tr>
                                    <th style="background-color:#707070; color:white; font-size:0.72rem; text-transform:uppercase; padding:0.6rem 1rem; border:none; width: 40%;">USER</th>
                                    <th style="background-color:#707070; color:white; font-size:0.72rem; text-transform:uppercase; padding:0.6rem 1rem; border:none;">EMAIL</th>
                                </tr>
                            </thead>
                            <tbody id="members_right_col" style="font-size: 0.82rem;">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="padding: 0.75rem 1.5rem; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="min-width: 100px;">CANCEL</button>
                <button type="button" class="btn btn-green" id="save_members_btn" style="min-width: 140px;">SAVE PERMISSION</button>
            </div>

        </div>
    </div>
</div>

<style>
    #userrole_members_modal .table tbody tr td {
        padding: 0.5rem 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
    }

    #userrole_members_modal .table tbody tr:hover {
        background-color: #f9fafb;
    }

    #userrole_members_modal .custom-control-input:checked~.custom-control-label::before {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
    }
</style>

<script>
    // View Members handler
    $('#user_roles_table').on('click', '.fa-user-plus', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var userRoleId = $(this).data('value');
        var roleName = $(this).closest('tr').find('a.text-dark').text();

        $('#members_role_id').val(userRoleId);
        $('#members_modal_title').text('Edit ' + roleName + ' Group Users');
        $('#members_left_col').html('<tr><td colspan="2" class="text-center text-muted py-3">Loading...</td></tr>');
        $('#members_right_col').html('');
        $('#userrole_members_modal').modal('show');

        $.ajax({
            // Correct route: user_groups/get_members/{id}
            url: "{{ url('user_groups/get_members') }}/" + userRoleId,
            type: 'GET',
            success: function(data) {
                var obj = typeof data === 'string' ? JSON.parse(data) : data;

                // getMember() returns [usersHaveGrouped, usersHaveNoGroup]
                var memberUsers = obj[0]; // already in the group (checked)
                var nonMemberUsers = obj[1]; // not in the group (unchecked)

                // Combine all users: members first (checked), then non-members (unchecked)
                var allUsers = [];
                memberUsers.forEach(function(user) {
                    allUsers.push({
                        id: user.id,
                        name: user.name,
                        email: user.email,
                        isMember: true
                    });
                });
                nonMemberUsers.forEach(function(user) {
                    allUsers.push({
                        id: user.id,
                        name: user.name,
                        email: user.email,
                        isMember: false
                    });
                });

                var half = Math.ceil(allUsers.length / 2);
                var leftUsers = allUsers.slice(0, half);
                var rightUsers = allUsers.slice(half);

                function buildRow(user) {
                    var checked = user.isMember ? 'checked' : '';
                    return '<tr>' +
                        '<td>' +
                        '<div class="custom-control custom-checkbox d-flex align-items-start">' +
                        '<input type="checkbox" class="custom-control-input member-checkbox" ' +
                        'id="user_' + user.id + '" data-id="' + user.id + '" ' + checked + '>' +
                        '<label class="custom-control-label ml-1" for="user_' + user.id + '">' +
                        '<span class="member-name">' + user.name + '</span>' +
                        '<span class="member-email">' + user.email + '</span>' +
                        '</label>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                }

                var leftHtml = leftUsers.map(buildRow).join('');
                var rightHtml = rightUsers.map(buildRow).join('');

                $('#members_left_col').html(leftHtml || '<tr><td colspan="2" class="text-muted text-center">No users</td></tr>');
                $('#members_right_col').html(rightHtml || '');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                $('#members_left_col').html('<tr><td colspan="2" class="text-center text-danger">Failed to load</td></tr>');
            }
        });
    });

    // Save members — POST to user_groups/update_members
    $('#save_members_btn').on('click', function() {
        var roleId = $('#members_role_id').val();
        var selectedIds = [];

        $('.member-checkbox:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });

        $.ajax({
            url: "{{ url('user_groups/update_members') }}",
            type: 'POST',
            data: {
                'user_group_members_group_id': roleId,
                'users': selectedIds,
                '_token': '{{ csrf_token() }}'
            },
            success: function() {
                $('#userrole_members_modal').modal('hide');
            },
            error: function() {
                alert('Failed to save. Please try again.');
            }
        });
    });

    $(document).on('input', '#members_search_input', function() {
        var q = $(this).val().toLowerCase().trim();
        $('#members_left_col tr, #members_right_col tr').each(function() {
            var name = $(this).find('.member-name').text().toLowerCase();
            var email = $(this).find('.member-email').text().toLowerCase();
            var match = name.indexOf(q) !== -1 || email.indexOf(q) !== -1;
            $(this).toggle(match);
        });
    });
</script>