<style>
    /* ── Create Modal Shell ── */
    #permission_create_modal .modal-dialog {
        max-width: 640px;
        margin: 40px auto;
    }

    #permission_create_modal .modal-content {
        border: none;
        border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        overflow: hidden;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* ── Header ── */
    #permission_create_modal .modal-header {
        background: #ffffff;
        border-bottom: 1px solid #eeeeee;
        padding: 18px 22px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #permission_create_modal .modal-header .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    #permission_create_modal .modal-header .close {
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

    #permission_create_modal .modal-header .close:hover {
        color: #333;
    }

    /* ── Body ── */
    #permission_create_modal .modal-body {
        background: #ffffff;
        padding: 20px 22px 6px;
    }

    /* Permission Name field */
    #permission_create_modal .pcm-field-label {
        font-size: 12px;
        font-weight: 600;
        color: #555555;
        margin-bottom: 6px;
        display: block;
        letter-spacing: 0.1px;
    }

    #permission_create_modal .pcm-name-input {
        width: 100%;
        border: 1px solid #dddddd;
        border-radius: 5px;
        padding: 9px 12px;
        font-size: 13.5px;
        color: #2a2a2a;
        background: #ffffff;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        margin-bottom: 20px;
    }

    #permission_create_modal .pcm-name-input:focus {
        border-color: #3ecf6e;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(62, 207, 110, 0.12);
    }

    #permission_create_modal .pcm-name-input::placeholder {
        color: #cccccc;
    }

    /* Section heading */
    #permission_create_modal .pcm-section-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 3px;
    }

    #permission_create_modal .pcm-section-sub {
        font-size: 12px;
        color: #888888;
        margin-bottom: 12px;
    }

    /* Select All bar */
    #permission_create_modal .pcm-select-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    #permission_create_modal .pcm-link {
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

    #permission_create_modal .pcm-link:hover {
        color: #111;
    }

    /* Checkbox grid */
    #permission_create_modal .pcm-roles-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        border: 1px solid #e8e8e8;
        border-radius: 5px;
        overflow: hidden;
        max-height: 360px;
        overflow-y: auto;
    }

    #permission_create_modal .pcm-role-item {
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

    #permission_create_modal .pcm-role-item:hover {
        background: #f7fdf9;
    }

    #permission_create_modal .pcm-role-item:nth-child(4n) {
        border-right: none;
    }

    /* Scrollbar */
    #permission_create_modal .pcm-roles-grid::-webkit-scrollbar {
        width: 5px;
    }

    #permission_create_modal .pcm-roles-grid::-webkit-scrollbar-track {
        background: #f5f5f5;
    }

    #permission_create_modal .pcm-roles-grid::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    /* Checkbox */
    #permission_create_modal .pcm-role-item input[type="checkbox"] {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        accent-color: #3ecf6e;
        cursor: pointer;
        margin: 0;
    }

    #permission_create_modal .pcm-role-item label {
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

    /* ── Footer ── */
    #permission_create_modal .modal-footer {
        background: #ffffff;
        border-top: 1px solid #eeeeee;
        padding: 14px 22px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    #permission_create_modal .pcm-btn-cancel {
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

    #permission_create_modal .pcm-btn-cancel:hover {
        background: #d8d8d8;
    }

    #permission_create_modal .pcm-btn-save {
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

    #permission_create_modal .pcm-btn-save:hover {
        background: #2db85b;
    }

    @media (max-width: 767px) {

        #permission_create_modal .modal-dialog {
            margin: 10px;
            max-width: calc(100% - 20px);
        }

        #permission_create_modal .modal-header { padding: 16px; }
        #permission_create_modal .modal-body { padding: 16px 16px 4px; }

        #permission_create_modal .pcm-roles-grid {
            grid-template-columns: repeat(2, 1fr);
            border: none;
            border-radius: 0;
            max-height: 340px;
            padding: 2px;
        }

        #permission_create_modal .pcm-role-item {
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            margin: 4px;
            padding: 10px 10px;
            background: #f7f7f7;
        }

        #permission_create_modal .pcm-role-item:has(input:checked) {
            background: #eaf1ff;
            border-color: #2f6fed;
        }

        #permission_create_modal .pcm-role-item:has(input:checked) label {
            color: #2f6fed;
            font-weight: 600;
        }

        #permission_create_modal .pcm-role-item input[type="checkbox"] {
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

        #permission_create_modal .pcm-role-item input[type="checkbox"]:checked {
            background-color: #2f6fed;
            border-color: #2f6fed;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'><polyline points='20 6 9 17 4 12'></polyline></svg>");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 11px 11px;
        }

        #permission_create_modal .pcm-role-item label {
            white-space: normal;
            font-size: 12px;
            line-height: 1.3;
        }

        #permission_create_modal .pcm-select-bar #pcm-select-all {
            border: 1px solid #c9c9c9 !important;
            padding: 4px 10px !important;
            border-radius: 6px;
        }

        #permission_create_modal .modal-footer {
            padding: 12px 16px;
            flex-direction: row;
            gap: 10px;
        }

        #permission_create_modal .pcm-btn-cancel,
        #permission_create_modal .pcm-btn-save {
            flex: 1 1 0;
            width: auto;
            padding: 12px;
            text-align: center;
        }

        #permission_create_modal .pcm-search-wrapper {
            position: relative;
            margin-bottom: 12px;
        }

        #permission_create_modal .pcm-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaaaaa;
            font-size: 13px;
            pointer-events: none;
        }

        #permission_create_modal .pcm-search-input {
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

        #permission_create_modal .pcm-search-input:focus {
            border-color: #3ecf6e;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(62, 207, 110, 0.12);
        }

        #permission_create_modal .pcm-btn-save {
            border-radius: 15px;
            background: #1AA05A;
        }

        #permission_create_modal .pcm-btn-cancel {
            border-radius: 15px;
            background: #9CA3AF;
        }

    }
</style>

<div class="modal fade" id="permission_create_modal" tabindex="-1" role="dialog" aria-labelledby="pcm-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header">
                <h3 class="modal-title" id="pcm-modal-title">Create User Permission</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('user_permission.create') }}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- Body --}}
                <div class="modal-body">

                    {{-- Permission Name --}}
                    <label class="pcm-field-label" for="permission_name">Permission Name</label>
                    <input
                        type="text"
                        class="pcm-name-input"
                        id="permission_name"
                        name="permission_name"
                        required
                        placeholder="" />

                    {{-- Grant section --}}
                    <div class="pcm-section-title">Grant Permission to User Groups</div>
                    <div class="pcm-section-sub">Select the user groups that should have this permission.</div>

                    {{-- NEW — Search box for user groups --}}
                    <div class="pcm-search-wrapper">
                        <i class="fas fa-search pcm-search-icon"></i>
                        <input type="text" class="pcm-search-input" id="pcm-role-search" placeholder="Search by User Groups" oninput="filterPcmRoles(this.value)" />
                    </div>


                    {{-- Select All bar --}}
                    <div class="pcm-select-bar">
                        <button type="button" class="pcm-link" id="pcm-select-all">Select All</button>
                    </div>

                    {{-- Roles checkbox grid --}}
                    <div class="pcm-roles-grid" id="pcm-roles-grid">
                        @foreach ($roles as $role)
                        <div class="pcm-role-item">
                            <input
                                type="checkbox"
                                name="roles[]"
                                id="check-{{ $role->id }}"
                                value="{{ $role->id }}" />
                            <label for="check-{{ $role->id }}">{{ $role->name }}</label>
                        </div>
                        @endforeach
                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button type="button" class="pcm-btn-cancel" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="pcm-btn-save">Save Permission</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    /* ── Select All ── */
    document.getElementById('pcm-select-all').addEventListener('click', function() {
        document.querySelectorAll('#permission_create_modal .pcm-roles-grid input[type="checkbox"]')
            .forEach(function(cb) {
                cb.checked = true;
            });
    });

    /* ── Reset form when modal closes ── */
    $('#permission_create_modal').on('hidden.bs.modal', function() {
        document.getElementById('permission_name').value = '';
        document.querySelectorAll('#permission_create_modal .pcm-roles-grid input[type="checkbox"]')
            .forEach(function(cb) {
                cb.checked = false;
            });
    });

    function filterPcmRoles(query) {
        var q = query.toLowerCase().trim();
        document.querySelectorAll('#permission_create_modal .pcm-role-item').forEach(function(item) {
            var label = item.querySelector('label');
            var text = label ? label.textContent.toLowerCase() : '';
            item.style.display = text.indexOf(q) !== -1 ? '' : 'none';
        });
    }
</script>