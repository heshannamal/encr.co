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
    .priority-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        flex-shrink: 0;
        border: 2px solid;
    }
</style>
<div class="row gy-4 gx-3 mt-4 flex-nowrap overflow-auto" id="board_tab_section">
    {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="">
        <div class="card mb-3">
            <div class="board-col-header rounded"><input type="text" class="border-0" value="Customer Portal"> | 4</div>
        </div>
        <div class="card dark_card">
            <div class="card-body p-2">
                <div class="board-task-card card mb-3 p-3 dark_card">
                    <div>
                        <label class="board-task-label  main_customer">
                            <input type="checkbox" class="main-check margin_right circle_checkbox"> Customer
                        </label>
                    </div>

                    <div class="d-flex align-items-center mt-3">
                        <img src="{{ asset('assets/img/user/team-4-800x800.jpg') }}" class="project-inner-avatar" style="">
                        <span class="" style="padding-left: 15px;">Haritha Wikram...</span>
                    </div>

                </div>
                <div class="board-task-card card mb-3 p-3 dark_card">
                    <div>
                        <label class="board-task-label  main_admin">
                            <input type="checkbox" class="main-check-admin margin_right circle_checkbox"> Admin
                        </label>
                    </div>

                    <div class="d-flex align-items-center mt-3">
                        <img src="{{ asset('assets/img/user/team-1-800x800.jpg') }}" class="project-inner-avatar">
                        <span class="" style="padding-left: 15px;">Prasad Gunase...</span>
                    </div>

                </div>

            </div>
            <div class="card-footer bg-white border-0 add_task_btn_div">
                <button class="btn btn-outline-secondary w-100 board-add-task add_task_btn">+ Add Task</button>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="">
        <div class="card mb-3">
            <div class="board-col-header rounded">Disc Golf web | 1</div>
        </div>
        <div class="card dark_card">
            <div class="card-body p-2">

                <div class="board-task-card card mb-3 p-3 dark_card">
                    <div>
                        <label class="board-task-label  main_disk">
                            <input type="checkbox" class="main-check-disk margin_right circle_checkbox"> Disc Golf Web
                        </label>
                    </div>

                    <div class="d-flex align-items-center mt-3">
                        <img src="{{ asset('assets/img/user/team-1-800x800.jpg') }}" class="project-inner-avatar">
                        <span class="text-white" style="padding-left: 15px;">Prasad Gunase...</span>
                    </div>

                </div>

            </div>
            <div class="card-footer bg-white border-0 add_task_btn_div">
                <button class="btn btn-outline-secondary w-100 board-add-task add_task_btn">+ Add Task</button>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="">
        <div class="card mb-3">
            <div class="board-col-header rounded">Project Management UI | 0</div>
        </div>
        <div class="card dark_card">

            <div class="card-footer bg-white border-0 add_task_btn_div">
                <button class="btn btn-outline-secondary w-100 board-add-task add_task_btn">+ Add Task</button>
            </div>
        </div>
    </div> --}}

    {{-- <div class=" align-items-center">
        <button class="board-add-section ms-2">+ Add Section</button>
    </div> --}}
</div>

<script>
    var stageStatusOptions = @json($project->stage_status_options);

    $(document).ready(function(){
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
        var project_id = $('#discussion_project_id').val();
        $.ajax({
            url: '{{ url("get_project_management") }}/'+project_id,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var section_data = data;
                // $('#discussion_tbody').html('');
                var sectionNames = [];
                for(var i = 0; i < section_data.length; i++){
                    displaySingleBoardSection(section_data[i]);
                }
                var addBoardSection = '<div class=" align-items-center" id="board_add_section">'+
                                '<button class="board-add-section ms-2">+ Add Section</button>'+
                            '</div>';
                $('#board_tab_section').append(addBoardSection);
                
                // Initialize stage select colors
                $('.section-stage-status').each(function() {
                    updateStageSelectColor(this);
                });
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

        // Build the parent column structure first
        var parentRow =
            '<div class="col-12 col-sm-6 col-md-4 col-lg-3" id="parent_board_section_' + section_data.id + '">' +
                '<div class="card mb-3">' +
                    '<div class="board-col-header rounded">' +
                        '<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">' +
                            '<input type="text" class="border-0 section-name section-name-id-'+section_data.id+'" data-id="'+section_data.id+'" value="' + section_data.section_name + '" style="flex: 1; min-width: 0; background: transparent; font-weight: 400;"> | '+discussion_data_count+
                        '</div>' +
                        '<div>' +
                            '<select class="section-stage-status modern-stage-select" data-id="' + section_data.id + '" style="width: 100%;">' +
                                '<option value="" ' + (!section_data.stage_status ? 'selected' : '') + '>-</option>' +
                                stageStatusOptions.map(function(stage) {
                                    return '<option value="' + stage + '" ' + (section_data.stage_status == stage ? 'selected' : '') + '>' + stage + '</option>';
                                }).join('') +
                            '</select>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="card dark_card">' +
                    '<div class="card-body p-2" id="board_section_' + section_data.id + '">' +
                    '</div>' +
                    '<div class="card-footer bg-white border-0 add_task_btn_div">' +
                        '<button class="btn btn-outline-secondary w-100 board-add-task add_task_btn add-board-section-discussion" data-id="'+section_data.id+'" data-order="'+section_data.project_id+'">+ Add Task</button>' +
                    '</div>' +
                '</div>' +
            '</div>';

        // Append parent row first so the section container exists
        $('#board_tab_section').append(parentRow);

        if (section_data && Array.isArray(section_data.discussions)) {
            displayBoardSectionDiscussions(section_data);
        }

        // Update the color for this select
        updateStageSelectColor($('#parent_board_section_' + section_data.id).find('.section-stage-status'));
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

            discussionRows +=
                '<div class="board-task-card card mb-3 p-3 dark_card open-chatbox" data-value="'+discussion_data[j].id+'" data-discussion-type="discussion" data-value="' +
                discussion_data[j].id + '" id="board_discussion_'+discussion_data[j].id+'">' +
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
                    '</div>' +
                    '<div class="board-task-meta d-flex align-items-center justify-content-between mt-2">' +
                        '<span class="text-gray" style="font-size:0.8rem;">Due: ' + (discussion_data[j].due_date ? discussion_data[j].due_date : 'No due date') + '</span>' +
                        '<span class="priority-indicator ' + (discussion_data[j].priority ? discussion_data[j].priority.toLowerCase() : 'low') + '" style="font-size:0.8rem;">' +
                        '<span class="priority-dot"></span>' +
                    '</div>' +
                '</div>';
        }

        // Now append discussions into the section container
        $('#board_section_' + section_data.id).append(discussionRows);
        updateSelec2s();
    }

    function updateStageSelectColor(selectElement) {
        const val = $(selectElement).val();
        $(selectElement).removeClass('stage-discussion stage-ui-ux-design stage-planning stage-under-development stage-sampling stage-testing stage-live stage-default');
        if (val === 'Discussion') {
            $(selectElement).addClass('stage-discussion');
        } else if (val === 'UI/UX Design') {
            $(selectElement).addClass('stage-ui-ux-design');
        } else if (val === 'Planning') {
            $(selectElement).addClass('stage-planning');
        } else if (val === 'Development') {
            $(selectElement).addClass('stage-under-development');
        } else if (val === 'Sampling') {
            $(selectElement).addClass('stage-sampling');
        } else if (val === 'Testing') {
            $(selectElement).addClass('stage-testing');
        } else if (val === 'Live') {
            $(selectElement).addClass('stage-live');
        } else {
            $(selectElement).addClass('stage-default');
        }
    }

    // Change Section Stage Status
    $('body').on('change', '.section-stage-status', function() {
        var section_id = $(this).data('id');
        var stage_status = $(this).val();
        var boardSelectElement = this;
        
        // Update color immediately
        updateStageSelectColor(this);

        $.ajax({
            url: '{{ url('project_management_section/update') }}/' + section_id,
            method: 'POST',
            data: {
                stage_status: stage_status,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                // Successfully updated in board view
                // Sync to list view - update the corresponding dropdown
                var listSelect = $('.section-stage-status[data-id="' + section_id + '"]').not(boardSelectElement);
                if (listSelect.length > 0) {
                    listSelect.val(stage_status);
                    // Trigger updateStageSelectColor if available in list view context
                    if (typeof updateStageSelectColor !== 'undefined') {
                        updateStageSelectColor(listSelect[0]);
                    }
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
    });

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
                    '<div class="card-footer bg-white border-0 add_task_btn_div">' +
                        '<button class="btn btn-outline-secondary w-100 board-add-task add_task_btn add-board-section-discussion" data-id="'+section_data.id+'" data-order="'+section_data.project_id+'">+ Add Task</button>' +
                    '</div>' +
                '</div>' +
            '</div>';

        // Append parent row first so the section container exists
        $('#board_add_section').before(parentRow);
        updateSelec2s();
    }

</script>
