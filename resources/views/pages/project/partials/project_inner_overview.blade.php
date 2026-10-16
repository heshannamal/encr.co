<style>
    .overview-form-label {
        margin-bottom: 0.5rem;
        font-size: 14px;
    }
    .overview-color-dot {
        width: 1.2rem;
        height: 1.2rem;
        border-radius: 50%;
        display: inline-block;
        margin-right: 0.5rem;
        border: 2px solid #fff;
        cursor: pointer;
        box-shadow: 0 0 0 1px #bbb;
    }
    .overview-color-dot.selected {
        border: 2px solid #e91e63;
        box-shadow: 0 0 0 2px #e91e6333;
    }
    .overview-color-custom {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.8rem;
        margin-right: 0.7rem;
    }
    .overview-section-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.8rem;
    }
    .overview-assist-list {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .overview-assist-item {
        display: flex;
        align-items: center;
        background: #f4f4f4;
        border-radius: 8px;
        padding: 0.2rem 0.7rem 0.2rem 0.2rem;
        gap: 0.4rem;
        font-size: 0.8rem;
        margin-bottom: 0.2rem;
    }
    .overview-assist-avatar {
        width: 1.3rem;
        height: 1.3rem;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.3rem;
    }
    .overview-assist-role {
        font-size: 0.7rem;
        color: #888;
        margin-left: 0.2rem;
    }
    .overview-add-btn {
        background: #fff;
        border: 1.5px solid #bbb;
        border-radius: 50%;
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #888;
        cursor: pointer;
        margin-right: 0.3rem;
    }
    .overview-form-control, .overview-form-select, .overview-form-textarea {
        /* font-size: 0.8rem; */
        border-radius: 6px;
        border: 1px solid #e4e4e4;
        background: transparent;
        padding: 0.4rem 0.7rem;
        width: 100%;
        margin-bottom: 0.7rem;
        color: rgb(170, 170, 170);
        font-size: 11px;
    }
    .overview-form-textarea {
        min-height: 3.2rem;
        resize: vertical;
    }
    .overview-btn-group {
        display: flex;
        gap: 0.7rem;
        margin-top: 1.2rem;
    }
    .overview-btn {
        font-size: 0.8rem;
        border-radius: 6px;
        padding: 0.3rem 1.2rem;
        border: 1px solid #bbb;
        background: #fff;
        color: #222;
        transition: background 0.2s;
    }
    .overview-btn-primary {
        background: #222;
        color: #fff;
        border: 1px solid #222;
    }
    .overview-btn-primary:hover {
        background: #444;
        color: #fff;
    }
    .overview-btn:hover {
        background: #f5f5f5;
    }

    /* Icon Picker Styles */
    .icon-picker-wrapper {
        position: relative;
        border: 1px solid #e4e4e4;
        border-radius: 6px;
        padding: 0.4rem 0.7rem;
        background: #fff;
    }

    .icon-display-area {
        display: flex;
        align-items: center;
        min-height: 35px;
        flex: 1;
    }

    .selected-icon-img {
        width: 35px;
        height: 35px;
        object-fit: contain;
    }

    .icon-placeholder {
        color: #888;
        font-size: 11px;
        font-style: italic;
    }

    .icon-dropdown-trigger {
        cursor: pointer;
        padding: 4px;
        color: #888;
        margin-left: 8px;
    }

    .icon-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #e4e4e4;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        z-index: 1000;
        max-height: 200px;
        overflow-y: auto;
    }

    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(40px, 1fr));
        gap: 8px;
    }

    .icon-option {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid transparent;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .icon-option:hover {
        border-color: #e91e63;
        background: #f8f8f8;
    }

    .icon-option.selected {
        border-color: #e91e63;
        background: #e91e631a;
    }

    .icon-option img {
        width: 36px;
        height: 36px;
        object-fit: contain;
    }

    @media (max-width: 900px) {
        .project-inner-title, .project-inner-user-group {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }

    /* Hide ugly select2 selected tags */
/* Hide selected tags only */
.select2-selection__choice {
    display: none !important;
}

/* Fix search box */
.select2-search--inline {
    width: 100% !important;
}

/* Fix search input */
.select2-search__field {
    width: 100% !important;
    margin-top: 0 !important;
    padding-left: 8px !important;
}

/* Better container */
.select2-container--default .select2-selection--multiple {
    min-height: 44px !important;
    border: 1px solid #ddd !important;
    border-radius: 10px !important;
    display: flex !important;
    align-items: center !important;
    padding: 4px 8px !important;
}

/* Dropdown fix */
.select2-dropdown {
    border-radius: 10px !important;
    overflow: hidden;
    border: 1px solid #ddd !important;
}

/* Result item */
.select2-results__option {
    padding: 10px 14px !important;
}

/* Selected user preview */
.overview-assist-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 12px;
}

.overview-assist-item {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f3f4f6;
    border-radius: 30px;
    padding: 6px 12px 6px 6px;
    position: relative;
}

.overview-assist-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

/* Remove button */
.assist-remove-btn {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #ff4d4f;
    color: white;
    border: none;
    font-size: 12px;
    cursor: pointer;
    margin-left: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-picker-wrapper {
    position: relative;
    z-index: 1000;
}

.icon-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #fff;
    border: 1px solid #e4e4e4;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 9999 !important; /* Force high z-index */
    max-height: 250px;
    overflow-y: auto;
    margin-top: 5px;
}


.row.g-4,
.col-12.col-md-6,
.col-md-4,
.padding_bottom_5px {
    overflow: visible !important;
}


.col-md-4 {
    position: relative;
    z-index: 100;
}

.icon-dropdown {
    pointer-events: auto !important;
}


.icon-dropdown::-webkit-scrollbar {
    width: 6px;
}

.icon-dropdown::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.icon-dropdown::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

/* Mobile responsive enhancements */
@media (max-width: 767.98px) {
    form:has(.overview-form-label) {
        background: #ffffff !important;
        border-radius: 16px !important;
        padding: 1.25rem !important;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05) !important;
        border: 1px solid #eaeaea !important;
        margin: 10px 0 !important;
    }
    
    .overview-form-control, .overview-form-select, .overview-form-textarea {
        background: #f8fafc !important;
        border: 1.5px solid #eef2f5 !important;
        color: #333333 !important;
        border-radius: 10px !important;
        padding: 0.6rem 0.8rem !important;
        font-size: 13px !important;
        transition: all 0.25s ease !important;
    }
    
    .overview-form-control:focus, .overview-form-select:focus, .overview-form-textarea:focus {
        border-color: #47D6B6 !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(71, 214, 182, 0.15) !important;
        outline: none !important;
    }

    .overview-form-label {
        font-weight: 600 !important;
        color: #2c3e50 !important;
        font-size: 13px !important;
        margin-bottom: 0.4rem !important;
    }

    .color-picker-wrapper, .icon-picker-wrapper {
        border-radius: 10px !important;
        border: 1.5px solid #eef2f5 !important;
    }

    .overview-color-custom {
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.8) !important;
        font-weight: 500 !important;
    }
    
    .overview-color-custom .overview-add-btn {
        background: rgba(255, 255, 255, 0.2) !important;
        border-color: rgba(255, 255, 255, 0.4) !important;
        color: #ffffff !important;
    }

    .select2-container--default .select2-selection--multiple {
        background: #f8fafc !important;
        border: 1.5px solid #eef2f5 !important;
        border-radius: 10px !important;
        min-height: 40px !important;
    }

    .overview-btn-group {
        gap: 10px !important;
        margin-top: 1.5rem !important;
    }

    .overview-btn-group .overview-btn {
        flex: 1 !important;
        padding: 0.75rem 1rem !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        border-radius: 10px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    .padding_bottom_5px:has(#project-assist-select) .row.g-2.mb-1 {
        display: none !important;
    }
    
    .padding_bottom_5px:has(#project-assist-select) .row.align-items-stretch {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.75rem !important;
    }
    
    .padding_bottom_5px:has(#project-assist-select) .row.align-items-stretch > .col-7,
    .padding_bottom_5px:has(#project-assist-select) .row.align-items-stretch > .col-5 {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }

    .padding_bottom_5px:has(#project-assist-select) .select2-container {
        width: 100% !important;
    }

    .padding_bottom_5px:has(#project-assist-select) .row.align-items-stretch > .col-7::before {
        content: "Assist";
        display: block;
        font-weight: 600 !important;
        color: #2c3e50 !important;
        font-size: 13px !important;
        margin-bottom: 0.4rem !important;
    }

    .padding_bottom_5px:has(#project-assist-select) .row.align-items-stretch > .col-5::before {
        content: "Assign Group";
        display: block;
        font-weight: 600 !important;
        color: #2c3e50 !important;
        font-size: 13px !important;
        margin-bottom: 0.4rem !important;
    }

    .overview-assist-list {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 8px !important;
        margin-top: 12px !important;
    }

    .overview-assist-item {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        margin: 0 !important;
        box-sizing: border-box !important;
        min-width: 0 !important;
    }

    .overview-assist-item span {
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        flex: 1 !important;
        min-width: 0 !important;
        font-size: 11px !important;
    }
}
</style>

<form action="{{ route('projects.update') }}" method="post">
    @csrf
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="padding_bottom_5px">
                <label class="overview-form-label">Project Name</label>
                <input type="text" name="project_name" id="project_name" class="overview-form-control" value="{{ $project->project_name }}" placeholder="Project Name" />
            </div>
            <div class="padding_bottom_5px">
                <label class="overview-form-label">Project #</label>
                <input type="text" name="project_no" id="project_no" class="overview-form-control" value="{{ $project->project_no }}" placeholder="Project #"  readonly/>
            </div>
            <div class="row padding_bottom_5px">
                <div class="col-md-8">
                    {{-- <label class="overview-form-label">Color</label>
                    <div class="d-flex align-items-center mb-2">
                        <span class="overview-color-custom"><span class="overview-add-btn"><i class="fa fa-plus"></i></span>Custom<br>Add color</span>
                        <span class="overview-color-dot selected" style="background:#f7b6e6;"></span>
                        <span class="overview-color-dot" style="background:#ff7a7a;"></span>
                        <span class="overview-color-dot" style="background:#ffb74d;"></span>
                        <span class="overview-color-dot" style="background:#ffe066;"></span>
                        <span class="overview-color-dot" style="background:#6ee7b7;"></span>
                        <span class="overview-color-dot" style="background:#4fd1c5;"></span>
                        <span class="overview-color-dot" style="background:#7c5fff;"></span>
                    </div> --}}
                    <label class="overview-form-label">Color</label>
                    <div class="align-content-center color-picker-wrapper invoice-inputs" style="background-color: {{ $project->project_color }}; height: 4rem;">
                        <div class="d-flex align-items-center">
                            <!-- Custom Add Color -->
                            <span class="overview-color-custom" id="customColorTrigger">
                                <span class="overview-add-btn"><i class="fa fa-plus"></i></span>
                                Custom<br>Add color
                            </span>

                            <!-- Preset Colors -->
                            <span class="overview-color-dot {{ $project->project_color == '#f7b6e6' ? 'selected' : '' }}" data-color="#f7b6e6" style="background:#f7b6e6;"></span>
                            <span class="overview-color-dot {{ $project->project_color == '#ff7a7a' ? 'selected' : '' }}" data-color="#ff7a7a" style="background:#ff7a7a;"></span>
                            <span class="overview-color-dot {{ $project->project_color == '#ffb74d' ? 'selected' : '' }}" data-color="#ffb74d" style="background:#ffb74d;"></span>
                            <span class="overview-color-dot {{ $project->project_color == '#ffe066' ? 'selected' : '' }}" data-color="#ffe066" style="background:#ffe066;"></span>
                            <span class="overview-color-dot {{ $project->project_color == '#6ee7b7' ? 'selected' : '' }}" data-color="#6ee7b7" style="background:#6ee7b7;"></span>
                            <span class="overview-color-dot {{ $project->project_color == '#4fd1c5' ? 'selected' : '' }}" data-color="#4fd1c5" style="background:#4fd1c5;"></span>
                            <span class="overview-color-dot {{ $project->project_color == '#7c5fff' ? 'selected' : '' }}" data-color="#7c5fff" style="background:#7c5fff;"></span>
                        </div>

                        <!-- Hidden color input (used for form submission) -->
                        <input type="color" name="project_color" value="{{ $project->project_color }}" class="color-picker" id="customColorInput" style="display:none;">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="overview-form-label">Project Icon</label>

                    @php
                        $selectedIcon = $projectIcons->firstWhere('id', $project->project_icon_id);
                    @endphp

                    <div class="align-content-center icon-picker-wrapper invoice-inputs" style="height: 4rem;">

                        <div class="d-flex align-items-center justify-content-between h-100">

                            <!-- Selected Icon Display -->
                            <div class="icon-display-area justify-content-center" id="iconDisplayArea">

                                @if($selectedIcon)
                                    <img
                                        src="{{ asset($selectedIcon->icon) }}"
                                        alt="Selected Icon"
                                        class="selected-icon-img"
                                    >
                                @else
                                    <span class="icon-placeholder">
                                        Add Icon
                                    </span>
                                @endif

                            </div>

                            <!-- Dropdown Arrow -->
                            <div class="icon-dropdown-trigger" id="iconDropdownTrigger">
                                <i class="fa fa-chevron-down"></i>
                            </div>

                        </div>

                        <!-- Dropdown -->
                        <div class="icon-dropdown" id="iconDropdown" style="display: none;">

                            <div class="icon-grid">

                                @foreach ($projectIcons as $projectIcon)

                                    <div
                                        class="icon-option {{ $project->project_icon_id == $projectIcon->id ? 'selected' : '' }}"
                                        data-icon-id="{{ $projectIcon->id }}"
                                        data-icon-src="{{ asset($projectIcon->icon) }}"
                                    >

                                        <img
                                            src="{{ asset($projectIcon->icon) }}"
                                            alt="Project Icon"
                                        >

                                    </div>

                                @endforeach

                            </div>

                        </div>

                        <!-- Hidden Input -->
                        <input type="hidden" name="project_icon" id="projectIconInput" value="{{ $project->project_icon_id }}" >
                    </div>
                </div>
            </div>
            <div class="padding_bottom_5px">
                <label class="overview-form-label">Status</label>
                <select class="overview-form-select" name="project_status_id" id="project_status_id">
                    <option value="">Select a Status</option>
                    @foreach ($projectStatus as $projectStat)
                        <option value="{{ $projectStat->id }}" {{ $projectStat->id == $project->project_status_id ? 'selected' : '' }}>

                            {{ $projectStat->status_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="padding_bottom_5px">
                <label class="overview-form-label">Stage Status Update</label>
                <select class="overview-form-select" name="stage_status" id="stage_status">
                    @foreach($project->stage_status_options as $stage)
                        <option value="{{ $stage }}" {{ $project->stage_status == $stage ? 'selected' : '' }}>{{ $stage }}</option>
                    @endforeach
                </select>
            </div>
            <div class="padding_bottom_5px">
                <label class="overview-form-label">Type</label>
                <select class="overview-form-select" name="type_id" id="type_id">
                    <option value="">Select a Project Type</option>
                    @foreach ($type as $projectType)
                        <option value="{{ $projectType->id }}" @if ($projectType->id == $project->project_type_id ) selected @endif>
                            {{ $projectType->type_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
        </div>

        <div class="col-12 col-md-6">
            {{-- <div class="padding_bottom_5px">
                <label class="overview-form-label">Assist</label>
                <div class="overview-assist-list mb-2">
                    <span class="overview-add-btn" title="Add Assist"><i class="fa fa-plus"></i></span>
                    <span class="overview-assist-item"><img src="{{ asset('assets/img/user/team-4-800x800.jpg') }}" class="overview-assist-avatar"> Prasad Gunase... <span class="overview-assist-role">Project Admin</span></span>
                    <span class="overview-assist-item"><img src="{{ asset('assets/img/user/team-1-800x800.jpg') }}" class="overview-assist-avatar"> Haritha Wikram... <span class="overview-assist-role">Editor</span></span>
                    <span class="overview-assist-item"><img src="{{ asset('assets/img/user/team-2-800x800.jpg') }}" class="overview-assist-avatar"> Oshadhi <span class="overview-assist-role">Editor</span></span>
                </div> --}}

            {{-- ── Assist + Assign Group (same visual row) ── --}}
            <div class="padding_bottom_5px">

                {{-- Row: two labels --}}
                <div class="row g-2 mb-1">
                    <div class="col-7">
                        <label class="overview-form-label mb-0">Assist</label>
                    </div>
                    <div class="col-5">
                        <label class="overview-form-label mb-0">Assign Group</label>
                    </div>
                </div>

                {{-- Row: two inputs, same height --}}
                <div class="row g-2 align-items-stretch">

                    {{-- Assist Select2 --}}
                    <div class="col-7">
                        <select id="project-assist-select"
                                name="project_assignee_id[]"
                                class="form-control"
                                multiple
                                style="width:100%;">
                            @php
                                $assignedAssistIds = $project->project_assignee
                                    ? explode(',', $project->project_assignee)
                                    : [];
                            @endphp
                            @foreach($userInfo as $user)
                                <option
                                    value="{{ $user['id'] }}"
                                    data-name="{{ $user['name'] }}"
                                    data-avatar="{{ asset($user['profile_pic'] ?? 'assets/img/default-avatar.png') }}"
                                    @if(in_array($user['id'], $assignedAssistIds)) selected @endif>
                                    {{ $user['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Assign Group --}}
                    <div class="col-5">
                        <select class="overview-form-select mb-0 h-100"
                                id="project-group-select"
                                style="height:44px !important;">
                            <option value="">Select a Group</option>
                            @foreach($activeUserGroups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- Selected Assist chips --}}
                <div class="overview-assist-list mt-2" id="assist-preview-list"></div>

            </div>

            {{-- Project Description --}}
            <div class="padding_bottom_5px">
                <label class="overview-form-label">Project description</label>
                <textarea class="overview-form-textarea"
                        id="project_description"
                        name="project_description"
                        placeholder="Add description">{{ $project->project_description }}</textarea>
            </div>

            <div class="overview-btn-group">
                <button type="reset"   class="overview-btn"
                        style="background:#b3b3b3!important;color:white!important;">RESET</button>
                <button type="submit"  class="overview-btn"
                        style="background:#47D6B6!important;color:white!important;border:none!important">UPDATE</button>
            </div>

        </div>

    </div>
    <input class="invoice-inputs" name="project_id" type='hidden' value="{{ $project->id }}" />

</form>

<script>
    $(document).on('click', '.assist-remove-btn', function () {

        let userId = $(this).data('id');

        $("#project-assist-select option[value='" + userId + "']")
            .prop('selected', false);

        $('#project-assist-select')
            .trigger('change')
            .select2('close');
    });

    $(document).on('click', function(e) {

        if (
            !$(e.target).closest('.select2-container').length &&
            !$(e.target).closest('#project-assist-select').length
        ) {
            $('#project-assist-select').select2('close');
        }

    });
    
    $(document).ready(function () {
        var wrapper = $('.color-picker-wrapper');
        var hiddenInput = $('#customColorInput');

        // Handle preset color selection
        $('.overview-color-dot').on('click', function () {
            var color = $(this).data('color');

            // Update wrapper background and input value
            wrapper.css('background-color', color);
            hiddenInput.val(color);

            // Highlight the selected swatch
            $('.overview-color-dot').removeClass('selected');
            $(this).addClass('selected');
        });

        // Handle custom color button
        $('#customColorTrigger').on('click', function () {
            hiddenInput.trigger('click'); // Opens native color picker
        });

        // When a custom color is chosen
        hiddenInput.on('input', function () {
            var color = $(this).val();

            wrapper.css('background-color', color);

            // Remove selected from presets
            $('.overview-color-dot').removeClass('selected');
        });

        $('#project-assist-select').select2({
            placeholder: "Search and select users",
            templateResult: formatUserOption,
            closeOnSelect: true,
            allowClear: false,
            width: '100%'
        });

        // Initialize preview for preselected options
        renderSelectedAssistList();

        // On change, update the assist list
        $('#project-assist-select').on('change', function () {
            renderSelectedAssistList();
        });

        function renderSelectedAssistList() {
            var assistList = $('#assist-preview-list');
            assistList.empty();

            $('#project-assist-select option:selected').each(function () {

                const id = $(this).val();
                const avatar = $(this).data('avatar');
                const name = $(this).data('name');

                var item = `
                    <div class="overview-assist-item">
                        <img src="${avatar}" class="overview-assist-avatar">

                        <span>${name}</span>

                        <button 
                            type="button"
                            class="assist-remove-btn"
                            data-id="${id}">
                            ×
                        </button>
                    </div>
                `;

                assistList.append(item);
            });
        }
        

        function formatUserOption(user) {
            if (!user.id) return user.text;

            const avatar = $(user.element).data('avatar');
            const name = $(user.element).data('name');
            // const role = $(user.element).data('role');
            const role = 'Example';

            return $(`
                <span>
                    <img src="${avatar}" class="overview-assist-avatar" style="width: 24px; height: 24px; border-radius: 50%; margin-right: 8px;">
                    ${name}
                </span>
            `);
        }

       

        // Icon Picker Functionality
        var iconDropdown = $('#iconDropdown');
        var iconDropdownTrigger = $('#iconDropdownTrigger');
        var iconDisplayArea = $('#iconDisplayArea');
        var projectIconInput = $('#projectIconInput');

        // Toggle dropdown on trigger click
        iconDropdownTrigger.on('click', function(e) {
            e.stopPropagation();
            iconDropdown.toggle();
        });

        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.icon-picker-wrapper').length) {
                iconDropdown.hide();
            }
        });

        // Handle icon selection
        $('.icon-option').on('click', function() {
            var iconId = $(this).data('icon-id');
            var iconSrc = $(this).data('icon-src');

            // Update hidden input
            projectIconInput.val(iconId);

            // Update display area
            if (iconId) {
                iconDisplayArea.html('<img src="' + iconSrc + '" alt="Selected Icon" class="selected-icon-img">');
            } else {
                iconDisplayArea.html('<span class="icon-placeholder">Add Icon</span>');
            }

            // Update selected state
            $('.icon-option').removeClass('selected');
            $(this).addClass('selected');

            // Close dropdown
            iconDropdown.hide();
        });

        $('#project-group-select').on('change', function() {
            var groupId = $(this).val();
            if (!groupId) return;

            // Use Blade to generate the correct URL — avoids hardcoding issues
            var url = '{{ url("user_roles/detail") }}/' + groupId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(res) {
                    var users = res.users || [];

                    if (users.length === 0) {
                        swal({
                            title: 'Info',
                            text: 'This group has no users.',
                            icon: 'info'
                        });
                        return;
                    }

                    users.forEach(function(user) {
                        var defaultAvatar = '{{ asset("assets/img/default-avatar.png") }}';
                        var avatar = user.profile_pic ?
                            '{{ asset("") }}' + user.profile_pic :
                            defaultAvatar;

                        var $select = $('#project-assist-select');
                        var $existing = $select.find("option[value='" + user.id + "']");

                        if ($existing.length) {
                            $existing.prop('selected', true);
                        } else {
                            var $option = $('<option>', {
                                    value: user.id,
                                    text: user.name,
                                    selected: true
                                })
                                .attr('data-name', user.name)
                                .attr('data-avatar', avatar);

                            $select.append($option);
                        }
                    });

                    $('#project-assist-select').trigger('change');
                },
                error: function(xhr) {
                    // Show the real error in console so you can debug
                    console.error('Group users error:', xhr.status, xhr.responseText);
                    swal({
                        title: 'Error',
                        text: 'Could not load group users. (Status: ' + xhr.status + ')',
                        icon: 'error'
                    });
                }
            });
        });
    });
</script>
