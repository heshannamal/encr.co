<style>
    .board-col-header {
        font-weight: 500;
        font-size: 0.85rem;
        /* border-bottom: 1px solid #bbb; */
        /* background: #323232; */
        color: #4E4C4C;
        letter-spacing: 0.01em;
        padding: 1rem 1rem 1rem 1rem;
        box-shadow: 0px 2px 4px 0px #00000026;
    }
    .board-col-header.dark {
        background: #2b2b2b;
        color: #fff;
        border-bottom: none;
    }
    .board-task-card {
        position: relative;
        min-height: 70px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        margin-bottom: 1.1rem;
    }
    .board-task-card .card-top-line {
        height: 3px;
        width: 40px;
        border-radius: 2px;
        background: #e91e63;
        position: absolute;
        top: 0.7rem;
        left: 1.1rem;
    }
    .board-task-card .card-top-line.purple { background: #e91e63; }
    .board-task-card .card-top-line.blue { background: #7c5fff; }
    .board-task-card .card-top-line.cyan { background: #2196f3; }
    .board-task-label {
        font-weight: 500;
        color: gray;
        margin-top: 0.5rem;
        margin-bottom: 0.2rem;
        font-size: 0.8rem;
    }
    .board-task-label .label-bold {
        font-weight: 700;
    }
    .board-task-label .label-blue { color: #7c5fff; }
    .board-task-label .label-cyan { color: #2196f3; }
    .board-task-desc {
        color: #222;
        font-size: 0.8rem;
        margin-bottom: 0.2rem;
    }
    .board-task-meta {
        color: #888;
        font-size: 0.75rem;
        margin-top: 0.1rem;
    }
    .board-add-section {
        color: #bbb;
        background: none;
        border: none;
        font-size: 1rem;
        margin-left: 1.2rem;
        margin-top: 1.5rem;
        cursor: pointer;
        text-align: left;
        font-weight: 500;
    }
    /* Hide board-specific date/priority elements on desktop */
    .board-task-card .board-task-date {
        display: none;
    }
    .board-task-card .priority-indicator {
        display: none;
    }
    @media (max-width: 767.98px) {
        /* Collapse the flex row so sections stack vertically */
        #board_tab_section {
            flex-direction: column !important;
            flex-wrap: wrap !important;
            overflow-x: hidden !important;
            gap: 10px !important;
        }

        /* Each section wrapper fills full width, no extra gap */
        #board_tab_section > div[id^="parent_board_section_"] {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            margin-bottom: 0 !important;
        }

        /* Remove Bootstrap card gap between header card and body card */
        #board_tab_section > div[id^="parent_board_section_"] > div.card.mb-3 {
            margin-bottom: 0 !important;
            box-shadow: none !important;
        }

        /* ---- Section header ---- */
        #board_tab_section .board-col-header {
            background: #ffffff !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 10px !important;       /* fully rounded when collapsed */
            box-shadow: 0 1px 3px rgba(0,0,0,0.06) !important;
            padding: 13px 16px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            color: #111827 !important;
            font-weight: 700 !important;
            font-size: 0.95rem !important;
            cursor: pointer !important;
            user-select: none;
            letter-spacing: -0.01em;
            transition: border-radius 0.15s, box-shadow 0.15s;
        }

        /* When section is expanded, flatten the bottom corners so it merges with the task list */
        #board_tab_section .board-col-header.expanded {
            border-radius: 10px 10px 0 0 !important;
            border-bottom-color: #f0f0f0 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 0 0 #f0f0f0 !important;
        }

        /* Chevron – right (collapsed) and down (expanded) */
        #board_tab_section .board-col-header::after {
            content: "\f054";  /* fa-chevron-right */
            font-family: "Font Awesome 5 Free", "FontAwesome";
            font-weight: 900;
            font-size: 0.8rem;
            color: #9ca3af;
            margin-left: auto;
            flex-shrink: 0;
            transition: transform 0.2s;
        }
        #board_tab_section .board-col-header.expanded::after {
            content: "\f078";  /* fa-chevron-down */
        }

        /* ---- Count badge in header ---- */
        .board-col-header-badge {
            background-color: #f3f4f6;
            color: #6b7280;
            padding: 2px 9px;
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1.4;
            border-radius: 999px;
            margin-left: 9px;
            flex-shrink: 0;
        }

        /* ---- Task-list container (dark_card) ---- */
        /* Hidden by default; shown when .show-mobile is toggled */
        #board_tab_section > div[id^="parent_board_section_"] > div.dark_card {
            display: none;
            border: 1px solid #e5e7eb !important;
            border-top: none !important;
            border-radius: 0 0 10px 10px !important;
            background: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06) !important;
            overflow: hidden;
            padding: 0 !important;
        }
        #board_tab_section > div[id^="parent_board_section_"] > div.dark_card.show-mobile {
            display: block !important;
        }

        /* Remove inner card-body padding to let task rows go edge-to-edge */
        #board_tab_section > div[id^="parent_board_section_"] > div.dark_card > div.card-body {
            padding: 0 !important;
        }

        /* ---- Individual task card ---- */
        #board_tab_section .board-task-card {
            background: #f9fafb !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            padding: 10px 16px !important;
            margin-bottom: 0 !important;
            /* Visible divider between tasks */
            border-bottom: 1px solid #d1d5db !important;
        }
        #board_tab_section .board-task-card:last-of-type {
            border-bottom: none !important;
        }

        /* Task name input – plain text style */
        #board_tab_section .board-task-card .discussion-name {
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            color: #111827 !important;
            background: transparent !important;
            width: 100% !important;
            flex: 1 !important;
            min-width: 0 !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Circle checkbox styling */
        #board_tab_section .board-task-card .circle_checkbox {
            width: 18px !important;
            height: 18px !important;
            flex-shrink: 0 !important;
            margin-right: 8px !important;
            margin-top: 1px !important;
        }

        /* Top row: checkbox + task name */
        #board_tab_section .board-task-card > div.d-flex:first-child {
            align-items: center !important;
            margin-bottom: 6px !important;
        }

        /* Bottom row: assignee + date + priority */
        #board_tab_section .board-task-card > div.d-flex.align-items-center.mt-3 {
            margin-top: 4px !important;
            align-items: center !important;
        }

        /* Hide assignee select dropdown on mobile */
        #board_tab_section .board-task-card select.discussion-assignee-name {
            display: none !important;
        }

        /* Assignee avatar + name */
        #board_tab_section .board-task-card .task-assignees {
            display: inline-flex !important;
            align-items: center !important;
            flex: 1 !important;
            min-width: 0 !important;
            gap: 5px !important;
        }
        #board_tab_section .board-task-card .task-assignees img.project-inner-avatar {
            width: 20px !important;
            height: 20px !important;
            border-radius: 50% !important;
            flex-shrink: 0 !important;
            margin-right: 0 !important;
        }
        #board_tab_section .board-task-card .task-assignees .text-gray {
            font-size: 0.75rem !important;
            color: #6b7280 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            max-width: 90px !important;
            padding-left: 0 !important;
        }

        /* Due date – calendar icon + formatted date */
        #board_tab_section .board-task-card .board-task-date {
            display: inline-flex !important;
            align-items: center !important;
            font-size: 0.73rem !important;
            color: #6b7280 !important;
            white-space: nowrap !important;
            margin-left: 8px !important;
            flex-shrink: 0 !important;
            gap: 3px !important;
        }
        #board_tab_section .board-task-card .board-task-date i {
            font-size: 0.7rem !important;
            color: #9ca3af !important;
        }

        /* Priority dot */
        #board_tab_section .board-task-card .priority-indicator {
            display: inline-flex !important;
            align-items: center !important;
            margin-left: 6px !important;
            flex-shrink: 0 !important;
        }
        /* #board_tab_section .board-task-card .priority-dot {
            width: 9px !important;
            height: 9px !important;
            min-width: 9px !important;
            flex-shrink: 0 !important;
            border-radius: 50% !important;
            display: inline-block !important;
        } */
        #board_tab_section .board-task-card .priority-dot {
            width: 9px !important;
            height: 9px !important;
            min-width: 9px !important;
            max-width: 9px !important;
            min-height: 9px !important;
            max-height: 9px !important;
            aspect-ratio: 1 / 1 !important;
            flex-shrink: 0 !important;
            border-radius: 50% !important;
            display: inline-block !important;
            box-sizing: border-box !important;
        }
        #board_tab_section .board-task-card .priority-indicator.low    .priority-dot { background: #2e7d32 !important; }
        #board_tab_section .board-task-card .priority-indicator.medium  .priority-dot { background: #f57f17 !important; }
        #board_tab_section .board-task-card .priority-indicator.high    .priority-dot { background: #e65100 !important; }
        #board_tab_section .board-task-card .priority-indicator.critical .priority-dot { background: #c62828 !important; }

    }
</style>
<div class="row gy-4 gx-3 mt-4 flex-nowrap overflow-auto" id="board_tab_section">
</div>

<script>
    $(document).ready(function(){
        // displayAllBoardSections(); // Eager loading disabled. Now loaded on tab click.
        
        // Added toggle collapse/expand behavior for mobile board view sections
        $('body').off('click', '.board-col-header').on('click', '.board-col-header', function() {
            if ($(window).width() < 768) {
                $(this).toggleClass('expanded');
                var targetBody = $(this).closest('.card').next('.card.dark_card');
                targetBody.toggleClass('show-mobile');
            }
        });
    });

    $('body').on('change', '#taskAssigneeFilter', function(){
        displayAllBoardSections();
    });

    // Add new discussion
    $('body').on('click', '.add-board-section-discussion', function(){

        var sectionId = $(this).data('id');
        var orderId = $(this).data('order');

        var row = '<div id="new_discussion_input" class="board-task-card card mb-3 p-3 dark_card">' +
                    '<input type="text" class="border-1" id="discussion_name" data-section-id="'+sectionId+'" data-order-id="'+orderId+'" style="height: 2rem; border-radius: 4px; border: 1px solid #d6d5d5;"> '+
                '</div>';
        $('#board_section_'+sectionId).append(row);
    });

    // Add new section
    $('body').on('click', '#board_add_section', function(){
        var parentRow =
            '<div class="col-12 col-sm-6 col-md-4 col-lg-3" id="new_section_row">' +
                '<div class="card mb-3">' +
                    '<div class="board-col-header rounded">' +
                        '<input type="text" class="border-1 w-100" id="section_name" style="height: 2rem; border-radius: 4px; border: 1px solid #d6d5d5;">'+
                    '</div>' +
                '</div>' +
            '</div>';
        $('#board_add_section').before(parentRow);
    });

    function displayAllBoardSections()
    {
        var assigneeId = $('#taskAssigneeFilter').val();
        var taskType   = $('#taskStatusFilter').val();
        var query = {};
        if (assigneeId) query.assignee_id = assigneeId;
        if (taskType) query.task_type = taskType;
        
        $.ajax({
            url: '{{ url("projects/get_my_task_sections") }}',
            method: 'GET',
            data: query,
            dataType: 'json',
            success: function(data) {
                $('#board_tab_section').empty();
                var section_data = data;
                for(var i = 0; i < section_data.length; i++){
                    displaySingleBoardSection(section_data[i]);
                }
            },
            error: function(xhr, status, error) {
                swal({
                    title: "Error!",
                    text: error,
                    type: "warning",
                    buttons: true,
                    dangerMode: true,
                    confirmButtonColor: '#5fb644',
                });
            }
        });
    }

    function displaySingleBoardSection(section_data) {
        var discussion_data_count = 0;

        if (section_data && Array.isArray(section_data.discussions)) {
            var discussion_data = section_data.discussions;
            var discussion_data_count = discussion_data.length;
        }

        // Custom mobile-friendly header layout with pill badge for counts and chevron support
        var headerHtml = section_data.section_name + ' | ' + discussion_data_count;
        if ($(window).width() < 768) {
            headerHtml = section_data.section_name + '<span class="board-col-header-badge">' + discussion_data_count + '</span>';
        }

        // Build the parent column structure first
        var parentRow =
            '<div class="col-12 col-sm-6 col-md-4 col-lg-3" id="parent_board_section_' + section_data.id + '">' +
                '<div class="card mb-3">' +
                    '<div class="board-col-header rounded">' +
                        // section_data.section_name + ' | '+discussion_data_count+
                        headerHtml +
                    '</div>' +
                '</div>' +
                '<div class="card dark_card">' +
                    '<div class="card-body p-2" id="board_section_' + section_data.id + '">' +
                    '</div>' +
                    // '<div class="card-footer bg-white border-0 add_task_btn_div">' +
                    //     '<button class="btn btn-outline-secondary w-100 board-add-task add_task_btn add-board-section-discussion" data-id="'+section_data.id+'" data-order="'+section_data.project_id+'">+ Add Task</button>' +
                    // '</div>' +
                '</div>' +
            '</div>';

        // Append parent row first so the section container exists
        $('#board_tab_section').append(parentRow);

        if (section_data && Array.isArray(section_data.discussions)) {
            displayBoardSectionDiscussions(section_data);
        }
    }

    function displayBoardSectionDiscussions(section_data)
    {
        var baseUrl = "{{ asset('') }}";
        var discussion_data = section_data.discussions;
        var discussionRows = '';

        for (var j = 0; j < discussion_data.length; j++) {
            var userOptions = '';
            for (let l = 0; l < userInfo.length; l++) {
                var isSelected = (discussion_data[j].assignee_id == userInfo[l].id) ? 'selected' : '';
                userOptions += '<option data-name="' + userInfo[l].name + '" data-image="' + userInfo[l].profile_pic + '" value="' + userInfo[l].id + '" ' + isSelected + '>' + userInfo[l].name + '</option>';
            }

            var isCompletedCheck = (discussion_data[j].is_completed == 1) ? 'checked' : '';

            var assigneeUserDetails = '<span class="text-gray" style="padding-left: 15px;"><i>No Assignee</i></span>';
            if (discussion_data[j].assignee_user) {
                assigneeUserDetails =
                    '<img src="' + baseUrl + discussion_data[j].assignee_user.profile_pic + '" class="project-inner-avatar" style="">' +
                    '<span class="text-gray" style="padding-left: 15px;">' + discussion_data[j].assignee_user.name + '</span>';
            }

            // Formatted task card structure including due date with calendar icon and priority dot support
            var dueDateHtml = '';
            if (discussion_data[j].due_date) {
                var dateParts = discussion_data[j].due_date.split('-');
                if (dateParts.length === 3) {
                    var formattedDate = parseInt(dateParts[1]) + '/' + parseInt(dateParts[2]) + '/' + dateParts[0];
                    dueDateHtml = '<span class="board-task-date"><i class="fas fa-calendar-alt me-1"></i>' + formattedDate + '</span>';
                }
            }

            var priorityDotHtml = '';
            if (discussion_data[j].priority) {
                var priorityClass = discussion_data[j].priority.toLowerCase();
                priorityDotHtml = '<span class="priority-indicator ' + priorityClass + '"><span class="priority-dot"></span></span>';
            }

            discussionRows +=
                '<div class="board-task-card card mb-3 p-3 dark_card open-chatbox" data-value="'+discussion_data[j].id+'" id="board_discussion_'+discussion_data[j].id+'">' +
                    '<div class="d-flex">' +
                        '<label class="board-task-label main_customer">' +
                            '<input type="checkbox" class="main-check margin_right circle_checkbox discussion-check discussion-check-id-'+discussion_data[j].id+'" ' + isCompletedCheck + ' value="'+discussion_data[j].id+'"> ' +
                        '</label>' +
                        '<input type="text" class="border-0 discussion-name discussion-name-id-'+discussion_data[j].id+'" data-discussion="'+discussion_data[j].id+'" value="' + discussion_data[j].discussion_name +'"> '+
                    '</div>' +
                    '<div class="d-flex align-items-center mt-3">' +
                        '<div class="d-flex align-items-center task-assignees task-assignees-id-'+discussion_data[j].id+' cursor_pointer">'+
                            assigneeUserDetails+
                        '</div>'+
                        '<select class="border-0 w-100 discussion-assignee-name" style="height: 1.5rem;" data-discussion="'+discussion_data[j].id+'">'+
                            userOptions+
                        '</select>'+
                        dueDateHtml +
                        priorityDotHtml +
                    '</div>' +
                '</div>';
        }

        // Now append discussions into the section container
        $('#board_section_' + section_data.id).append(discussionRows);
        updateSelec2s();
    }


    function displayNewSingleBoardSection(section_data) {
        var discussion_data_count = 0;

        // Build the parent column structure first
        var parentRow =
            '<div class="col-12 col-sm-6 col-md-4 col-lg-3">' +
                '<div class="card mb-3">' +
                    '<div class="board-col-header rounded">' +
                        '<input type="text" class="border-0 section-name section-name-id-'+section_data.id+'" data-id="'+section_data.id+'" value="' + section_data.section_name + '"> | '+discussion_data_count+
                    '</div>' +
                '</div>' +
                '<div class="card dark_card">' +
                    '<div class="card-body p-2" id="board_section_' + section_data.id + '">' +
                    '</div>' +
                    // '<div class="card-footer bg-white border-0 add_task_btn_div">' +
                    //     '<button class="btn btn-outline-secondary w-100 board-add-task add_task_btn add-board-section-discussion" data-id="'+section_data.id+'" data-order="'+section_data.project_id+'">+ Add Task</button>' +
                    // '</div>' +
                '</div>' +
            '</div>';

        // Append parent row first so the section container exists
        $('#board_add_section').before(parentRow);
        updateSelec2s();
    }

</script>
