<style>
    /* ── View Modal Shell ── */
    #permission_view_modal .modal-dialog {
        max-width: 640px;
        margin: 40px auto;
    }

    #permission_view_modal .modal-content {
        border: none;
        border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        overflow: hidden;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ── Header ── */
    #permission_view_modal .modal-header {
        background: #ffffff;
        border-bottom: 1px solid #eeeeee;
        padding: 18px 22px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #permission_view_modal .modal-header .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    #permission_view_modal .modal-header .close {
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

    #permission_view_modal .modal-header .close:hover {
        color: #333;
    }

    /* ── Body ── */
    #permission_view_modal .modal-body {
        background: #ffffff;
        padding: 20px 22px 22px;
    }

    /* Section heading */
    #permission_view_modal .pvm-section-title {
        font-size: 13px;
        font-weight: 600;
        color: #555555;
        margin-bottom: 14px;
    }

    /* Checkbox grid — read-only */
    #permission_view_modal .pvm-roles-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        border: 1px solid #e8e8e8;
        border-radius: 5px;
        overflow: hidden;
        max-height: 400px;
        overflow-y: auto;
    }

    #permission_view_modal .pvm-role-item {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 9px 12px;
        border-bottom: 1px solid #f0f0f0;
        border-right: 1px solid #f0f0f0;
        min-width: 0;
        background: #ffffff;
    }

    /* Highlight assigned rows */
    #permission_view_modal .pvm-role-item.is-assigned {
        background: #f0fbf5;
    }

    #permission_view_modal .pvm-role-item:nth-child(4n) {
        border-right: none;
    }

    /* Scrollbar */
    #permission_view_modal .pvm-roles-grid::-webkit-scrollbar {
        width: 5px;
    }

    #permission_view_modal .pvm-roles-grid::-webkit-scrollbar-track {
        background: #f5f5f5;
    }

    #permission_view_modal .pvm-roles-grid::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    /* Checkbox — disabled, pointer-events none */
    #permission_view_modal .pvm-role-item input[type="checkbox"] {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        accent-color: #3ecf6e;
        cursor: default;
        margin: 0;
        pointer-events: none;
    }

    #permission_view_modal .pvm-role-item label {
        font-size: 12.5px;
        color: #2a2a2a;
        cursor: default;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 400;
        line-height: 1.3;
        pointer-events: none;
        user-select: none;
    }

    /* Assigned label bold */
    #permission_view_modal .pvm-role-item.is-assigned label {
        color: #1a6e3c;
        font-weight: 600;
    }

    /* Loading state */
    #permission_view_modal .pvm-loading {
        text-align: center;
        padding: 30px 0;
        color: #aaa;
        font-size: 13px;
    }
</style>

{{-- ── VIEW PERMISSION DETAILS MODAL ── --}}
<div class="modal fade" id="permission_view_modal" tabindex="-1" role="dialog" aria-labelledby="pvm-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            {{-- Header — title = permission name --}}
            <div class="modal-header">
                <h3 class="modal-title" id="pvm-modal-title">—</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                <div class="pvm-section-title">Grant Permission to the Following Selected User Groups</div>

                {{-- Loading placeholder --}}
                <div class="pvm-loading" id="pvm-loading">Loading...</div>

                {{-- Roles grid (populated by JS) --}}
                <div class="pvm-roles-grid" id="pvm-roles-grid" style="display:none;">
                    {{-- All roles rendered here, checked ones highlighted --}}
                    @foreach ($roles as $role)
                    <div class="pvm-role-item" id="pvm-item-{{ $role->id }}">
                        <input
                            type="checkbox"
                            id="pvm-check-{{ $role->id }}"
                            value="{{ $role->id }}"
                            disabled />
                        <label for="pvm-check-{{ $role->id }}">{{ $role->name }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    (function() {
        /* ── Open view modal when permission name link is clicked ── */
        window.openPermissionView = function(id) {
            // Reset state
            var grid = document.getElementById('pvm-roles-grid');
            var loading = document.getElementById('pvm-loading');
            var title = document.getElementById('pvm-modal-title');

            title.textContent = '—';
            loading.style.display = 'block';
            grid.style.display = 'none';

            // Uncheck all & remove highlight
            document.querySelectorAll('#pvm-roles-grid .pvm-role-item').forEach(function(item) {
                item.classList.remove('is-assigned');
                item.querySelector('input[type="checkbox"]').checked = false;
            });

            // Show modal immediately (loading state)
            $('#permission_view_modal').modal('show');

            // Fetch permission data (reuse existing edit endpoint)
            $.ajax({
                url: '{{ url("permission/edit") }}/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var permission = data[0];
                    var roleArr = data[1];

                    // Set title to permission name
                    title.textContent = permission.name ?
                        permission.name.charAt(0).toUpperCase() + permission.name.slice(1) :
                        '—';

                    // Tick & highlight assigned roles
                    if (roleArr && roleArr.length > 0) {
                        roleArr.forEach(function(role) {
                            var item = document.getElementById('pvm-item-' + role.id);
                            var cb = document.getElementById('pvm-check-' + role.id);
                            if (item && cb) {
                                cb.checked = true;
                                item.classList.add('is-assigned');
                            }
                        });
                    }

                    loading.style.display = 'none';
                    grid.style.display = '';
                },
                error: function() {
                    loading.textContent = 'Failed to load permission details.';
                }
            });
        };
    }());
</script>