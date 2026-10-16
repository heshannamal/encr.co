<style>
    /* ── Delete Modal Shell ── */
    #permission_delete_modal .modal-dialog {
        max-width: 460px;
        margin: 60px auto;
    }

    #permission_delete_modal .modal-content {
        border: none;
        border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.20);
        overflow: hidden;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ── Header ── */
    #permission_delete_modal .modal-header {
        background: #ffffff;
        border-bottom: 1px solid #eeeeee;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #permission_delete_modal .modal-header .modal-title {
        font-size: 15px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    #permission_delete_modal .modal-header .close {
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

    #permission_delete_modal .modal-header .close:hover {
        color: #333;
    }

    /* ── Body ── */
    #permission_delete_modal .modal-body {
        background: #ffffff;
        padding: 20px 22px;
    }

    /* Warning text */
    #permission_delete_modal .pdm-warning {
        font-size: 13.5px;
        color: #2a2a2a;
        line-height: 1.55;
        margin-bottom: 16px;
    }

    #permission_delete_modal .pdm-warning span {
        display: block;
        color: #666;
        font-size: 13px;
        margin-top: 2px;
    }

    /* Info box */
    #permission_delete_modal .pdm-info-box {
        background: #fafafa;
        border: 1px solid #e8e8e8;
        border-radius: 6px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }

    #permission_delete_modal .pdm-info-box p {
        font-size: 13px;
        color: #444;
        margin-bottom: 10px;
        font-weight: 500;
    }

    #permission_delete_modal .pdm-info-box ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    #permission_delete_modal .pdm-info-box ul li {
        font-size: 13px;
        color: #333;
        padding: 3px 0;
        display: flex;
        align-items: baseline;
        gap: 0;
    }

    #permission_delete_modal .pdm-info-box ul li::before {
        content: "•";
        color: #888;
        margin-right: 8px;
        flex-shrink: 0;
    }

    #permission_delete_modal .pdm-info-box ul li .pdm-li-key {
        color: #555;
        font-weight: 500;
        min-width: 160px;
        display: inline-block;
    }

    #permission_delete_modal .pdm-info-box ul li .pdm-li-sep {
        color: #aaa;
        margin: 0 8px;
    }

    #permission_delete_modal .pdm-info-box ul li .pdm-li-val {
        color: #1a1a1a;
        font-weight: 600;
    }

    /* Access warning */
    #permission_delete_modal .pdm-access-warn {
        font-size: 12.5px;
        color: #666;
        line-height: 1.5;
        margin-bottom: 18px;
    }

    /* Type to confirm */
    #permission_delete_modal .pdm-confirm-label {
        font-size: 12.5px;
        color: #444;
        margin-bottom: 7px;
        display: block;
    }

    #permission_delete_modal .pdm-confirm-label code {
        background: #f0f0f0;
        border-radius: 3px;
        padding: 1px 5px;
        font-size: 12px;
        color: #c0392b;
        font-family: monospace;
    }

    #permission_delete_modal .pdm-confirm-input {
        width: 100%;
        border: 1px solid #dddddd;
        border-radius: 5px;
        padding: 9px 12px;
        font-size: 13.5px;
        color: #2a2a2a;
        background: #fff;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    #permission_delete_modal .pdm-confirm-input:focus {
        border-color: #e53935;
        box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.10);
    }

    #permission_delete_modal .pdm-confirm-input.matched {
        border-color: #e53935;
    }

    /* ── Footer ── */
    #permission_delete_modal .modal-footer {
        background: #ffffff;
        border-top: 1px solid #eeeeee;
        padding: 14px 22px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    #permission_delete_modal .pdm-btn-cancel {
        background: #e0e0e0;
        color: #444444;
        border: none;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 9px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.15s;
    }

    #permission_delete_modal .pdm-btn-cancel:hover {
        background: #cecece;
    }

    #permission_delete_modal .pdm-btn-delete {
        background: #e53935;
        color: #ffffff;
        border: none;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 9px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.15s, opacity 0.15s;
        opacity: 0.4;
        pointer-events: none;
    }

    #permission_delete_modal .pdm-btn-delete.enabled {
        opacity: 1;
        pointer-events: auto;
    }

    #permission_delete_modal .pdm-btn-delete.enabled:hover {
        background: #c62828;
    }
</style>

{{-- ── DELETE CONFIRMATION MODAL ── --}}
<div class="modal fade" id="permission_delete_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">
                <h3 class="modal-title">Delete User Permission</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body">

                {{-- Warning --}}
                <div class="pdm-warning">
                    Are you sure you want to delete this permission?
                    <span>This action cannot be undone.</span>
                </div>

                {{-- Info box --}}
                <div class="pdm-info-box">
                    <p>You are about to permanently remove:</p>
                    <ul>
                        <li>
                            <span class="pdm-li-key">Permission Name</span>
                            <span class="pdm-li-sep">–</span>
                            <span class="pdm-li-val" id="pdm-perm-name">—</span>
                        </li>
                        <li>
                            <span class="pdm-li-key">Assigned User Groups</span>
                            <span class="pdm-li-sep">–</span>
                            <span class="pdm-li-val" id="pdm-perm-groups">—</span>
                        </li>
                        <li>
                            <span class="pdm-li-key">Total Affected Users</span>
                            <span class="pdm-li-sep">–</span>
                            <span class="pdm-li-val" id="pdm-perm-users">—</span>
                        </li>
                    </ul>
                </div>

                {{-- Access warning --}}
                <p class="pdm-access-warn">
                    Deleting this permission will immediately remove access from all assigned user group.
                </p>

                {{-- Type to confirm --}}
                <label class="pdm-confirm-label" for="pdm-confirm-input">
                    Type <code>delete permission</code> to confirm.
                </label>
                <input
                    type="text"
                    id="pdm-confirm-input"
                    class="pdm-confirm-input"
                    placeholder=""
                    autocomplete="off"
                    oninput="pdmCheckConfirm(this.value)" />

            </div>

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="pdm-btn-cancel" data-dismiss="modal">Cancel</button>
                <button type="button" class="pdm-btn-delete" id="pdm-btn-delete" onclick="pdmExecuteDelete()">
                    Delete Permission
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    (function() {
        var _deleteId = null;
        var _deleteUrl = '{{ url("permission/delete") }}';
        var CONFIRM_PHRASE = 'delete permission';

        /* ── Called from the trash icon in the table ── */
        window.confirmDelete = function(id, permName, groupCount, userCount) {
            _deleteId = id;

            // Populate modal info
            document.getElementById('pdm-perm-name').textContent = permName || '—';
            document.getElementById('pdm-perm-groups').textContent = groupCount !== undefined ? groupCount : '—';
            document.getElementById('pdm-perm-users').textContent = userCount !== undefined ? userCount : '—';

            // Reset confirm input & button
            var input = document.getElementById('pdm-confirm-input');
            input.value = '';
            input.classList.remove('matched');
            document.getElementById('pdm-btn-delete').classList.remove('enabled');

            $('#permission_delete_modal').modal('show');
        };

        /* ── Enable delete button only when phrase matches ── */
        window.pdmCheckConfirm = function(val) {
            var btn = document.getElementById('pdm-btn-delete');
            var input = document.getElementById('pdm-confirm-input');
            if (val.toLowerCase() === CONFIRM_PHRASE) {
                btn.classList.add('enabled');
                input.classList.add('matched');
            } else {
                btn.classList.remove('enabled');
                input.classList.remove('matched');
            }
        };

        /* ── Execute delete ── */
        window.pdmExecuteDelete = function() {
            if (!_deleteId) return;
            window.location.replace(_deleteUrl + '/' + _deleteId);
        };
    }());
</script>