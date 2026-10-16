<style>
    @media (max-width: 767px) {
        div#userrole_delete_modal {
            margin-left: 12px;
        }
        .modal-body {
            margin-left: 9px;
        }
    }
</style>

<div class="modal fade" id="userrole_delete_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 400px; max-width: 400px;">
        <div class="modal-content rounded-0">
            <div class="modal-header border-bottom">
                <h2 class="modal-title font-weight-bold">Delete Employee Group</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="delete_user_role_id" name="delete_user_role_id" />

                {{-- Warning Message --}}
                <p class="mb-3" style="font-size: 0.875rem; color: #374151;">
                    Are you sure you want to delete this employee group?<br>
                    This action cannot be undone.
                </p>

                {{-- Permanent Remove Details --}}
                <p class="mb-2" style="font-size: 0.875rem; color: #374151;">
                    You are about to permanently remove:
                </p>
                <ul class="mb-3 pl-3" style="font-size: 0.875rem; color: #374151; list-style: disc;">
                    <li class="mb-1">
                        <span class="text-muted" style="display:inline-block; min-width: 150px;">Employee Group</span>
                        <span id="delete_group_name" class="font-weight-medium">—</span>
                    </li>
                    <li class="mb-1">
                        <span class="text-muted" style="display:inline-block; min-width: 150px;">Assigned Permissions</span>
                        <span id="delete_permission_count" class="font-weight-medium">—</span>
                    </li>
                    <li class="mb-1">
                        <span class="text-muted" style="display:inline-block; min-width: 150px;">Users in this Group</span>
                        <span id="delete_user_count" class="font-weight-medium">—</span>
                    </li>
                </ul>

                {{-- Danger Notice --}}
                <p class="mb-3" style="font-size: 0.875rem; color: #374151;">
                    Deleting this employee group will immediately remove all assigned permissions from its users.
                </p>

                {{-- Confirmation Input --}}
                <div class="form-group mb-0">
                    <label class="font-weight-normal p-2" style="font-size: 0.875rem;">
                        Type <strong>"delete employee group"</strong> to confirm.
                    </label>
                    <input
                        type="text"
                        class="form-control form-control-sm p-2"
                        id="delete_confirm_input"
                        placeholder=""
                        style="border: 1px solid #ced4da; width: 100%;"
                        autocomplete="off"
                    />
                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button
                    class="btn btn-secondary btn-sm text-uppercase px-4"
                    type="button"
                    data-dismiss="modal"
                >Cancel</button>

                <a
                    id="delete_confirm_btn"
                    href="#"
                    class="btn btn-danger btn-sm text-uppercase px-3 disabled"
                    style="pointer-events: none; opacity: 0.65;"
                >Delete Employee Group</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Enable/disable delete button based on confirmation input
    $('#delete_confirm_input').on('input', function () {
        var val = $(this).val().trim().toLowerCase();
        var $btn = $('#delete_confirm_btn');

        if (val === 'delete employee group') {
            $btn.removeClass('disabled').css({ 'pointer-events': 'auto', 'opacity': '1' });
        } else {
            $btn.addClass('disabled').css({ 'pointer-events': 'none', 'opacity': '0.65' });
        }
    });

    // Trigger delete modal from trash icon
    $('#user_roles_table').on('click', '.delete-role', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var userRoleId = $(this).data('value');
        if (!userRoleId) return;

        $('#delete_user_role_id').val(userRoleId);
        $('#delete_confirm_input').val('');
        $('#delete_confirm_btn')
            .addClass('disabled')
            .css({ 'pointer-events': 'none', 'opacity': '0.65' });

        // Fetch group details to populate the summary
        $.ajax({
            url: "{{ url('user_roles/edit') }}/" + userRoleId,
            type: 'GET',
            success: function (data) {
                var obj = typeof data === 'string' ? JSON.parse(data) : data;
                $('#delete_group_name').text(obj.name ?? '—');
                $('#delete_permission_count').text(obj.permission_count ?? '—');
                $('#delete_user_count').text(obj.user_count ?? '—');
            },
            error: function () {
                $('#delete_group_name').text('—');
                $('#delete_permission_count').text('—');
                $('#delete_user_count').text('—');
            }
        });

        // Set delete URL
        var deleteUrl = "{{ route('user_roles.delete', ['id' => ':id']) }}";
        deleteUrl = deleteUrl.replace(':id', userRoleId);
        $('#delete_confirm_btn').attr('href', deleteUrl);

        $('#userrole_delete_modal').modal('show');
    });
</script>