<style>
    /* ── Modal Shell ── */
    #permission_edit_modal .modal-dialog {
        max-width: 640px;
        margin: 40px auto;
    }

    #permission_edit_modal .modal-content {
        border: none;
        border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        overflow: hidden;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ── Modal Header ── */
    #permission_edit_modal .modal-header {
        background: #ffffff;
        border-bottom: 1px solid #eeeeee;
        padding: 18px 22px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #permission_edit_modal .modal-header .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    #permission_edit_modal .modal-header .close {
        background: none;
        border: none;
        font-size: 20px;
        color: #888;
        padding: 0;
        line-height: 1;
        cursor: pointer;
        opacity: 1;
        margin: 0;
    }

    #permission_edit_modal .modal-header .close:hover {
        color: #333;
    }

    /* ── Modal Body ── */
    #permission_edit_modal .modal-body {
        background: #ffffff;
        padding: 20px 22px 6px;
    }

    /* Permission Name field */
    #permission_edit_modal .pem-field-label {
        font-size: 12px;
        font-weight: 600;
        color: #555555;
        margin-bottom: 6px;
        display: block;
        letter-spacing: 0.1px;
    }

    #permission_edit_modal .pem-name-input {
        width: 100%;
        border: 1px solid #dddddd;
        border-radius: 5px;
        padding: 9px 12px;
        font-size: 13.5px;
        color: #2a2a2a;
        background: #f9f9f9;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        margin-bottom: 20px;
    }

    #permission_edit_modal .pem-name-input:focus {
        border-color: #3ecf6e;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(62, 207, 110, 0.12);
    }

    /* Section heading */
    #permission_edit_modal .pem-section-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 3px;
    }

    #permission_edit_modal .pem-section-sub {
        font-size: 12px;
        color: #888888;
        margin-bottom: 12px;
    }

    /* Select All / Clear All bar */
    #permission_edit_modal .pem-select-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    #permission_edit_modal .pem-select-bar .pem-link {
        font-size: 12px;
        font-weight: 600;
        color: #555;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        text-decoration: none;
        letter-spacing: 0.2px;
        text-transform: uppercase;
        transition: color 0.15s;
    }

    #permission_edit_modal .pem-select-bar .pem-link:hover {
        color: #111;
    }

    #permission_edit_modal .pem-select-bar .pem-link+.pem-link {
        margin-left: 14px;
    }

    #permission_edit_modal .pem-selected-count {
        font-size: 12px;
        color: #888;
        white-space: nowrap;
    }

    /* Checkbox grid */
    #permission_edit_modal .pem-roles-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        border: 1px solid #e8e8e8;
        border-radius: 5px;
        overflow: hidden;
        max-height: 360px;
        overflow-y: auto;
    }

    #permission_edit_modal .pem-role-item {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 9px 12px;
        border-bottom: 1px solid #f0f0f0;
        border-right: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background 0.1s;
        min-width: 0;
    }

    #permission_edit_modal .pem-role-item:hover {
        background: #f7fdf9;
    }

    /* Remove right border on last column */
    #permission_edit_modal .pem-role-item:nth-child(4n) {
        border-right: none;
    }

    /* Scrollbar styling */
    #permission_edit_modal .pem-roles-grid::-webkit-scrollbar {
        width: 5px;
    }

    #permission_edit_modal .pem-roles-grid::-webkit-scrollbar-track {
        background: #f5f5f5;
    }

    #permission_edit_modal .pem-roles-grid::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    /* Checkbox */
    #permission_edit_modal .pem-role-item input[type="checkbox"] {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        accent-color: #3ecf6e;
        cursor: pointer;
        margin: 0;
    }

    #permission_edit_modal .pem-role-item label {
        font-size: 12.5px;
        color: #2a2a2a;
        cursor: pointer;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 400;
        line-height: 1.3;
    }

    /* ── Modal Footer ── */
    #permission_edit_modal .modal-footer {
        background: #ffffff;
        border-top: 1px solid #eeeeee;
        padding: 14px 22px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    #permission_edit_modal .pem-btn-cancel {
        background: #e8e8e8;
        color: #444444;
        border: none;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        padding: 9px 22px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.15s;
    }

    #permission_edit_modal .pem-btn-cancel:hover {
        background: #d8d8d8;
    }

    #permission_edit_modal .pem-btn-update {
        background: #3ecf6e;
        color: #ffffff;
        border: none;
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        padding: 9px 22px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.15s;
    }

    #permission_edit_modal .pem-btn-update:hover {
        background: #2db85b;
    }

    @media (max-width: 767px) {

        /* Modal fits the phone screen with small side margins */
        #permission_edit_modal .modal-dialog {
            margin: 10px;
            max-width: calc(100% - 20px);
        }

        #permission_edit_modal .modal-header {
            padding: 16px;
        }

        #permission_edit_modal .modal-body {
            padding: 16px 16px 4px;
        }

        /* Checkbox grid: 2 columns instead of 4, no outer box border */
        #permission_edit_modal .pem-roles-grid {
            grid-template-columns: repeat(2, 1fr);
            border: none;
            border-radius: 0;
            max-height: 340px;
            padding: 2px;
        }

        /* Each item becomes its own rounded gray "chip" */
        #permission_edit_modal .pem-role-item {
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            margin: 4px;
            padding: 10px 10px;
            background: #f7f7f7;
        }

        /* When checked, the whole chip turns blue with white text */
        #permission_edit_modal .pem-role-item:has(input:checked) {
            background: #eaf1ff;
            border-color: #2f6fed;
        }

        #permission_edit_modal .pem-role-item:has(input:checked) label {
            color: #2f6fed;
            font-weight: 600;
        }

        /* Round checkbox with a checkmark, like the design, instead of a plain square */
        #permission_edit_modal .pem-role-item input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            min-width: 18px;
            border-radius: 50%;
            border: 2px solid #c9c9c9;
            background-color: #fff;
            cursor: pointer;
        }

        #permission_edit_modal .pem-role-item input[type="checkbox"]:checked {
            background-color: #2f6fed;
            border-color: #2f6fed;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'><polyline points='20 6 9 17 4 12'></polyline></svg>");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 11px 11px;
        }

        /* Let labels wrap instead of getting cut off with "..." */
        #permission_edit_modal .pem-role-item label {
            white-space: normal;
            font-size: 12px;
            line-height: 1.3;
        }

        /* Cancel / Save buttons stack full-width, Save on top */
        #permission_edit_modal .modal-footer {
            padding: 12px 16px;
            flex-direction: row;
            gap: 10px;
        }

        #permission_edit_modal .pem-btn-cancel,
        #permission_edit_modal .pem-btn-update {
            flex: 1 1 0;
            width: auto;
            padding: 12px;
            text-align: center;
        }

        #permission_edit_modal .pem-search-wrapper {
            position: relative;
            margin-bottom: 12px;
        }

        #permission_edit_modal .pem-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaaaaa;
            font-size: 13px;
            pointer-events: none;
        }

        #permission_edit_modal .pem-search-input {
            width: 100%;
            border: 1px solid #dddddd;
            border-radius: 6px;
            padding: 9px 12px 9px 34px;
            font-size: 13px;
            color: #2a2a2a;
            background: #f9f9f9;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        #permission_edit_modal .pem-search-input:focus {
            border-color: #3ecf6e;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(62, 207, 110, 0.12);
        }

        #permission_edit_modal .pem-select-bar #pem-select-all {
            border: 1px solid #c9c9c9 !important;
            padding: 4px 10px !important;
            border-radius: 6px;
        }

        #permission_edit_modal .pem-select-bar #pem-clear-all {
            border: 1px solid #e53935 !important;
            color: #e53935;
            padding: 4px 10px !important;
            border-radius: 6px;
        }
        #permission_edit_modal .pem-btn-update{
            border-radius: 15px;
            background: #1AA05A;
        }

        #permission_edit_modal .pem-btn-cancel {
            border-radius: 15px;
            background: #9CA3AF;
        }

    }

</style>

<div class="modal fade" id="permission_edit_modal" tabindex="-1" role="dialog" aria-labelledby="pem-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">
                <h3 class="modal-title" id="pem-modal-title">Edit User Permission</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('user_permission.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="permission_id" name="permission_id" />

                {{-- Body --}}
                <div class="modal-body">

                    {{-- Permission Name --}}
                    <label class="pem-field-label" for="edit_permission_name">Permission Name</label>
                    <input
                        type="text"
                        class="pem-name-input"
                        id="edit_permission_name"
                        name="permission_name"
                        required
                        placeholder="Permission name" />

                    {{-- Grant section --}}
                    <div class="pem-section-title">Grant Permission to User Groups</div>
                    <div class="pem-section-sub">Select the user groups that should have this permission.</div>

                    {{-- NEW — Search box for user groups --}}
                    <div class="pem-search-wrapper">
                        <i class="fas fa-search pem-search-icon"></i>
                        <input type="text" class="pem-search-input" id="pem-role-search" placeholder="Search by User Groups" oninput="filterPemRoles(this.value)" />
                    </div>

                    {{-- Select All / Clear All bar --}}
                    <div class="pem-select-bar">
                        <div>
                            <button type="button" class="pem-link" id="pem-select-all">Select All</button>
                            <button type="button" class="pem-link" id="pem-clear-all">Clear All</button>
                        </div>
                        <span class="pem-selected-count" id="pem-count">Selected 0 user groups</span>
                    </div>

                    {{-- Roles checkbox grid --}}
                    <div class="pem-roles-grid" id="pem-roles-grid">
                        @foreach ($roles as $role)
                        <div class="pem-role-item">
                            <input
                                type="checkbox"
                                name="roles[{{ $role->id }}]"
                                id="edit_check-{{ $role->id }}"
                                value="{{ $role->id }}"
                                onchange="updateCount()" />
                            <label for="edit_check-{{ $role->id }}">{{ $role->name }}</label>
                        </div>
                        @endforeach
                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button type="button" class="pem-btn-cancel" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="pem-btn-update">Update Permission</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    /* ── Load permission data when modal opens ── */
    $('#permission_edit_modal').on('shown.bs.modal', function() {
        var permissionId = $('#permission_id').val();

        // Uncheck all
        $('#permission_edit_modal .pem-roles-grid input[type="checkbox"]').prop('checked', false);

        $.ajax({
            url: '{{ url("permission/edit") }}/' + permissionId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var permission = data[0];
                var roleArr = data[1];

                // Set permission name
                $('#edit_permission_name').val(permission.name);

                // Tick assigned roles
                if (roleArr && roleArr.length > 0) {
                    $.each(roleArr, function(i, role) {
                        $('#edit_check-' + role.id).prop('checked', true);
                    });
                }

                updateCount();
            }
        });
    });

    /* ── Select All ── */
    document.getElementById('pem-select-all').addEventListener('click', function() {
        document.querySelectorAll('#permission_edit_modal .pem-roles-grid input[type="checkbox"]')
            .forEach(function(cb) {
                cb.checked = true;
            });
        updateCount();
    });

    /* ── Clear All ── */
    document.getElementById('pem-clear-all').addEventListener('click', function() {
        document.querySelectorAll('#permission_edit_modal .pem-roles-grid input[type="checkbox"]')
            .forEach(function(cb) {
                cb.checked = false;
            });
        updateCount();
    });

    /* ── Update selected count label ── */
    function updateCount() {
        var count = document.querySelectorAll(
            '#permission_edit_modal .pem-roles-grid input[type="checkbox"]:checked'
        ).length;
        document.getElementById('pem-count').textContent =
            'Selected ' + count + ' user group' + (count !== 1 ? 's' : '');
    }

    $(document).ready(function() {
        $(document).off('click', '.delete');
        $('body').off('click', '.delete');
    });

    function filterPemRoles(query) {
        var q = query.toLowerCase().trim();
        document.querySelectorAll('#permission_edit_modal .pem-role-item').forEach(function(item) {
            var label = item.querySelector('label');
            var text = label ? label.textContent.toLowerCase() : '';
            item.style.display = text.indexOf(q) !== -1 ? '' : 'none';
        });
    }
</script>