<style>
    .table-custom-dark {
        color: #f8f9fe;
        background-color: #323232;
    }

    .table-custom-dark th {
        border-color: #3c3c3c;
    }

    .trash_btn {
        color: rgb(255, 136, 136);
        cursor: pointer;
    }

    /* Drag and Drop Styles */
    .draggable-item {
        /* cursor: move; */
        transition: all 0.2s ease;
    }

    .draggable-item:hover {
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .draggable-item.dragging {
        opacity: 0.5;
        transform: rotate(2deg);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        z-index: 1000;
    }

    .drop-zone {
        min-height: 2px;
        background-color: #007bff;
        border-radius: 2px;
        margin: 2px 0;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .drop-zone.active {
        opacity: 1;
    }

    .drag-handle {
        cursor: move;
        color: #6c757d;
        margin-right: 8px;
        font-size: 14px;
    }

    .drag-handle:hover {
        color: #E8E8E8;
    }

    .section-drag-handle {
        cursor: move;
        color: #6c757d;
        margin-right: 8px;
        font-size: 16px;
    }

    .section-drag-handle:hover {
        color: #E8E8E8;
    }

    .section-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        margin-right: -8px;
        box-shadow: 0 0 0 1px #bbb;
    }

    .section-avatar-group {
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }

    .section-avatar-group .section-avatar {
        border: 2px solid #fff;
        margin-left: -3px;
    }

    .discussion-name,
    .sub-discussion-name,
    .section-name {
        width: 100% !important;
        min-width: 0;
        background-color: #f7f7f7 !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }



    .section-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        margin-left: 0 !important;
    }


    .select2-container {

        width: auto !important;
        height: auto !important;
        background: none !important;
        border: none !important;
    }

    .drag-handle,
    .section-drag-handle {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease;
        cursor: grab;
    }

    /* section rows */
    tr.project-inner-section:hover .section-drag-handle,
    /* task rows */
    tr.project-inner-task:hover .drag-handle {
        opacity: 1;
        visibility: visible;
    }





    /* hide by default */
    .toggle-arrow button.btn.btn-primary.arrow {
        opacity: 0;
        visibility: hidden;
        transform: scale(0.9);
        transition: all 0.2s ease;
    }

    /* show on hover of parent row / cell */
    .schedule-row:hover .toggle-arrow button.btn.btn-primary.arrow,
    tr:hover .toggle-arrow button.btn.btn-primary.arrow,
    td:hover .toggle-arrow button.btn.btn-primary.arrow {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    /* arrow button style */
    button.btn.btn-primary.arrow {
        width: 26px;
        height: 26px;
        padding: 0;
        border-radius: 6px;
        background-color: #D8D8D8 !important;
        border: none !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    button.btn.btn-primary.arrow i {
        font-size: 16px;
        color: #000000;
    }

    /* hover effect */
    button.btn.btn-primary.arrow:hover {
        background-color: #E8E8E8 !important;
    }

    button.btn.btn-primary.arrow:hover i {
        color: #000000;
    }


    span.discussion-count {
        font-size: 12px !important;
    }
    span.comment-count {
        font-size: 12px !important;
    }

   /* make the TD a flex row */
.project-inner-section td.border_left_unset {
    display: flex;
    align-items: center;
    gap: 8px;
}

/* drag + arrow should not grow */
.section-drag-handle,
.toggle-arrow {
    flex-shrink: 0;
}

.input-wrapper {
    flex: 1;
    min-width: 0;
}

.comment-div,
.discussion-div {
    display: inline-flex;
    align-items: center;
    gap: 4px;

}

.discussion-div {
    margin-left: auto;
}


span.comment-number {
    margin: 4px;
     font-size: 10.5px !important;
    color: #858585 ;
}

span.comment-number-section {
    margin: 4px;
    font-size: 10.5px !important;
    color: #858585 ;
}

span.discussion-number {
    font-size: 10.5px !important;
    margin: 4px;
    color: #858585;
}

span.discussion-number-section {
    font-size: 10.5px !important;
    margin: 4px;
    color: #858585;
}

i.fa-regular.fa-comment-dots {
    color: #858585;
}


i.fa-solid.fa-list-check {
    color: #858585;
}

.section-avatar-group {
    width: auto;
}

.project-inner-task td.border_left_unset {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 0;
}

.project-inner-task .input-wrapper {
    flex: 1;
    min-width: 0;
}

.project-inner-task .discussion-name,
.project-inner-task .sub-discussion-name {
    width: 100% !important;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.hierarchy-item {
    display: flex;
    align-items: center;
    width: 100%;
    position: relative;
}

.section-level {
    padding-left: 8px;
}

.discussion-level {
    padding-left: 55px;
}

.subdiscussion-level {
    padding-left: 105px;
}

/* vertical line */
.discussion-level::before,
.subdiscussion-level::before {
    content: "";
    position: absolute;
    left: 28px;
    top: -12px;
    bottom: -12px;
    width: 1px;
    background: #d8d8d8;
}

/* horizontal connector */
.discussion-level::after,
.subdiscussion-level::after {
    content: "";
    position: absolute;
    left: 28px;
    top: 50%;
    width: 20px;
    height: 1px;
    background: #d8d8d8;
}

/* sub discussion deeper line */
.subdiscussion-level::before {
    left: 78px;
}

.subdiscussion-level::after {
    left: 78px;
}

/* cleaner rows */
.project-inner-task td {
    vertical-align: middle;
}

/* better spacing */
.project-inner-task input[type="text"] {
    background: transparent !important;
}

/* Priority Indicator Styles */
.priority-indicator {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-left: 8px;
    flex-shrink: 0;
    padding: 4px 8px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 12px;
    font-weight: 600;
}

.priority-indicator:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.priority-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
    border: 2px solid;
}

.priority-indicator.critical {
    background-color: #ffebee;
    color: #c62828;
}

.priority-indicator.critical .priority-dot {
    background-color: #c62828;
    border-color: #ef5350;
}

.priority-indicator.high {
    background-color: #fff3e0;
    color: #e65100;
}

.priority-indicator.high .priority-dot {
    background-color: #e65100;
    border-color: #ffb74d;
}

.priority-indicator.medium {
    background-color: #fff9c4;
    color: #f57f17;
}

.priority-indicator.medium .priority-dot {
    background-color: #f57f17;
    border-color: #fdd835;
}

.priority-indicator.low {
    background-color: #e8f5e9;
    color: #2e7d32;
}

.priority-indicator.low .priority-dot {
    background-color: #2e7d32;
    border-color: #66bb6a;
}

@media(max-width:767px){
    .mobile-card-table{
        border:0 !important;
    }
    .mobile-card-table thead{
        display:none;
    }
    .mobile-card-table tbody,
    .mobile-card-table tr,
    .mobile-card-table td{
        display:block;
        width:100%;
    }
    /* Remove table spacing */
    .mobile-card-table tbody{
        margin-bottom:15px;
    }
    /* SECTION CARD */
    .mobile-card-table .parent-row{
        margin:15px 0 10px;
        overflow:hidden;
    }
    .mobile-card-table .parent-row td{
        width: 95%;
        padding:15px !important;
        border:0 !important;
    }
    .mobile-card-table .section-name{
        color: black !important;
        font-size: 16px !important;
        font-weight: 600;
        background-color: transparent !important;
    }
    .mobile-card-table .arrow{
        background:rgba(255,255,255,.2);
        border:0;
        width:32px;
        height:32px;
        border-radius:50%;
    }
    /* TASK CARD */
    .mobile-card-table .parent-discussion-row{
        background:white;
        margin:10px 0;
        border-radius:14px;
        border:1px solid #dbdbdb;
    }
    .mobile-card-table .parent-discussion-row td{
        width: 95%;
        padding:14px !important;
        border:0 !important;
    }
    /* SUB TASK */
    .mobile-card-table .sub-discussion-row{
        background:#f8f9ff;
        margin-left:15px;
        width:calc(100% - 15px);
        border-radius:12px;
        margin-top:8px;
        border: 1px solid #dbdbdb;
    }
    .mobile-card-table .sub-discussion-row td{
        padding:12px !important;
        border:0 !important;
    }
    /* Task title */
    .mobile-card-table input{
        font-size:15px !important;
    }
    .mobile-card-table .hierarchy-item{
        display:flex;
        align-items:center;
        gap:8px;
        width: 95%;
        padding-left: 0;
    }
    /* Hide empty cells */
    .mobile-card-table td[colspan="2"]{
        padding-top:0 !important;
    }
    /* Assignee */
    .task-assignees,
    .sub-task-assignees{
        margin-top:10px;
    }
    .project-inner-avatar{
        width:30px;
        height:30px;
        border-radius:50%;
    }
    /* Due date */
    .discussion-due-date,
    .sub-discussion-due-date{
        margin-top:10px;
        background:#f1f3f9;
        border-radius:8px;
        padding:6px;
    }
    /* Delete button */
    .delete-discussion,
    .delete-sub-discussion,
    .delete-section-discussion{
        position:absolute;
        right:10px;
        top:10px;
    }
    .parent-discussion-row,
    .sub-discussion-row,
    .parent-row{
        position:relative;
    }
    /* Count badges */
    .comment-div,
    .discussion-div{
        display:inline-flex;
        margin-top:8px;
    }
    .comment-count,
    .discussion-count,
    .subcomment-count,
    .subdiscussion-count{
        background:#f1f4ff;
        padding:5px 10px;
        border-radius:20px;
        font-size:12px;
    }
}
@media(max-width:767px){
    .mobile-card-table .task-assignees,
    .mobile-card-table .sub-task-assignees{
        background:#f7f8fc;
        padding:8px 12px;
        border-radius:10px;
        width:max-content;
    }
    .mobile-card-table td:nth-child(3)::before{
        content:"Due Date";
        display:block;
        font-size:12px;
        color:#999;
        margin-bottom:5px;
    }
    .mobile-card-table td:nth-child(2)::before{
        content:"Assignee";
        display:block;
        font-size:12px;
        color:#999;
        margin-bottom:5px;
    }
    .discussion-level::after, .subdiscussion-level::after {
        display: none;
    }
    .discussion-level::before, .subdiscussion-level::before {
        display: none;
    }
}
@media(max-width:767px){
    /* First column */
    .parent-discussion-row td:first-child,
    .sub-discussion-row td:first-child {
        display:block !important;
        width:100% !important;
    }
    /* Task name area */
    .parent-discussion-row td:first-child > .hierarchy-item,
    .sub-discussion-row td:first-child > .hierarchy-item {
        width:93%;
        display:flex;
        align-items:center;
    }
    /* Name input take remaining space */
    .discussion-name,
    .sub-discussion-name {
        flex:1;
        min-width:0;
    }
    /* Priority move to next line */
    .priority-indicator {
        margin-top:8px;
    }
    /* comments and subtask count next line */
    .comment-div,
    .discussion-div {
        display:inline-flex !important;
        margin-top:8px;
        margin-left:10px;
    }
    /* Force bottom section */
    .comment-div::before,
    .discussion-div::before {
        content:"";
        display:block;
    }
    /* Hide other columns */
    .parent-discussion-row td:nth-child(2),
    .parent-discussion-row td:nth-child(3),
    .parent-discussion-row td:nth-child(4),
    .sub-discussion-row td:nth-child(2),
    .sub-discussion-row td:nth-child(3),
    .sub-discussion-row td:nth-child(4) {
        /* display:none !important; */
    }
    .project-inner-task input[type="text"] {
        font-size: 12px !important;
    }
}
@media (max-width: 767px) {

    /* Section header */
    .mobile-card-table .parent-row .hierarchy-item{
        display:flex;
        flex-wrap:wrap;
        align-items:center;
        gap:8px;
    }

    /* Section name in its own row */
    .mobile-card-table .parent-row .input-wrapper{
        flex:0 0 100%;
        width:100%;
        order:2;
    }

    .mobile-card-table .parent-row .section-name{
        width:100% !important;
        display:block;
    }

    /* Arrow stays first */
    .mobile-card-table .parent-row .toggle-arrow{
        order:1;
    }

    /* Drag handle stays first */
    .mobile-card-table .parent-row .section-drag-handle{
        order:0;
    }

    /* Comment & discussion move below section name */
    .mobile-card-table .parent-row .comment-div,
    .mobile-card-table .parent-row .discussion-div{
        order:3;
        margin-top:8px;
    }
}
@media(max-width:767px){

    /* Main discussion row */
    .parent-discussion-row td:first-child .hierarchy-item{
        display:flex;
        flex-wrap:wrap;
        align-items:center;
        gap:8px;
    }


    /* Drag, arrow, checkbox stay first row */
    .parent-discussion-row .drag-handle,
    .parent-discussion-row .toggle-arrow,
    .parent-discussion-row .discussion-check{
        order:1;
    }


    /* Move input wrapper full row */
    .parent-discussion-row .input-wrapper{
        display:flex !important;
        flex-wrap:wrap;
        flex:0 0 100% !important;
        width:100%;
        order:3;
    }


    /* Discussion name goes next line */
    .parent-discussion-row .discussion-name{
        order:2;
        width:100% !important;
    }


    /* Priority stays beside checkbox row */
    .parent-discussion-row .priority-indicator{
        position:absolute;
        top: -130%;
        transform:translateY(-50%);
        left:100px;
        display:flex;
        align-items:center;
    }


    /* Make input wrapper not affect priority position */
    .parent-discussion-row .input-wrapper{
        position:relative !important;
    }


    /* Comment + subtask bottom row */
    .parent-discussion-row .comment-div,
    .parent-discussion-row .discussion-div{
        margin-top:8px;
    }
    .mobile_section_padding_reduce {
        padding: unset !important;
    }

}

@media (max-width: 767.98px) {

    .drag-handle,
    .parent-discussion-min,
    .btn-primary {
        opacity: 1 !important;
        visibility: visible !important;
    }
    .order-management-card div#inbox-right.modal {
        top: 14% !important;
    }

}

</style>


<div class="table-responsive">
    <table class="table table-bordered align-middle project-inner-table mobile-card-table">
        <thead class="table-custom-dark">
            <tr>
                <th class="w-75">Name</th>
                <th>Assignee</th>
                <th>Due Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="discussion_tbody">


        </tbody>
        <tbody id="add_section_row">
            <!-- Section: Add new Section -->
            <tr class="project-inner-section border_left_unset cursor_pointer">
                <td class="border_left_unset border_right_unset font_15px" colspan="3">

                    <input type="hidden" id="discussion_project_id" value="{{ $project->id }}" />
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>

    var userInfo = @json($userInfo);

    $('.datepicker').datepicker({
        minDate: 0
    });

    $(document).ready(function() {
        displayAllSections();

        $('#add_section_btn').click(function() {
            $('#add_section_row').hide(200);
            var sectionTextRow =
                '<tr class="project-inner-section border_left_unset" id="new_section_row">' +
                '<td class="border_left_unset border_right_unset font_15px" colspan="3">' +
                '<input type="text" id="section_name" placeholder="New Section" style="width: 40%; border-radius: 4px; border: 1px solid #a8a8a8;">' +
                '</td>' +
                '</tr>';
            $('#discussion_tbody').append(sectionTextRow);
        });
    });

    $('body').on('click', '.parent-min', function() {
        var rowId = $(this).data('id');
        const icon = $(this).find('i');
        icon.toggleClass('fa-caret-right fa-caret-down');

        // Use a data attribute to track toggle state
        var $parentRow = $(this).closest('.parent-row');
        var isLoaded = $parentRow.data('section-loaded');

        if (!isLoaded) {
            // First toggle: load via AJAX
            $.ajax({
                url: '{{ url('get_project_management_section_by_id') }}/' + rowId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    displaySectionDiscussions(data);
                    $('.parent-section-' + rowId).siblings('.second-child-row').hide(700);
                    $parentRow.data('section-loaded', true); // Mark as loaded
                }
            });
        } else {
            // Fade out and remove selected section
            $('.parent-section-' + rowId).fadeOut(300, function() {
                $(this).remove();
            });
            $parentRow.data('section-loaded', false); // Mark as not loaded
            $('.parent-section-' + rowId).siblings('.second-child-row').hide(700);
        }

    });

    $('body').on('click', '.parent-discussion-min', function() {
        var rowId = $(this).data('id');
        const icon = $(this).find('i');
        icon.toggleClass('fa-caret-right fa-caret-down');

        // Use a data attribute to track toggle state
        var $parentRow = $(this).closest('.parent-discussion-row');
        var isLoaded = $parentRow.data('discussion-loaded');

        if (!isLoaded) {
            // First toggle: load via AJAX
            $.ajax({
                url: '{{ url('get_project_management_section_sub_discussion_by_discussion_id') }}/' +
                    rowId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    displaySubDiscussions(data);
                    $('.parent-discussion-' + rowId).siblings('.second-child-row').hide(700);
                    $parentRow.data('discussion-loaded', true); // Mark as loaded
                }
            });
        } else {
            // Second toggle: use commented lines (show/hide)
            // $('.parent-discussion-'+rowId).toggle(700);
            $('.parent-discussion-' + rowId).fadeOut(300, function() {
                $(this).remove();
            });
            $parentRow.data('discussion-loaded', false); // Mark as not loaded
            $('.parent-discussion-' + rowId).siblings('.second-child-row').hide(700);
        }

    });

    $(document).on('blur', '#section_name', function(e) {

        if ($('#section_name').val() == '') {
            $('#new_section_row').remove();
            $('#add_section_row').show(200);
            $('#section_name').val('');
            $('#section_name').unbind('click');

            swal({
                title: "Untitled Section !",
                text: "Please Enter section name",
                type: "info",
                buttons: true,
                dangerMode: true,
                confirmButtonColor: '#5fb644',
            });

        } else {

            var project_id = $('#discussion_project_id').val();
            var section_name = $('#section_name').val();
            var enterSection = 1;
            $(".section-name").each(function() {
                if ($(this).val() == section_name) {
                    enterSection = 0;
                }
            });

            if (enterSection == 1) {
                $.ajax({
                    url: '{{ url('project_management_section/store') }}',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        project_id: project_id,
                        section_name: section_name,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {

                        $('#new_section_row').remove();
                        $('#add_section_row').show(200);
                        $('#section_name').val('');
                        $('#section_name').unbind('click');
                        displaySingleSection(data);
                        displayNewSingleBoardSection(data);
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
            } else {
                //$('#new_section_row').hide();
                $('#section_name').val('');
                $('#section_name').unbind('click');
                swal({
                    title: "Section already available!",
                    text: "Note the sesction your are trying to create in already available.",
                    type: "info",
                    buttons: true,
                    dangerMode: true,
                    confirmButtonColor: '#5fb644',
                })
            }


        }
        // }
    });



    // Rename a Section
    $('body').on('change', '.section-name', function() {
        var section_name = $(this).val();
        var section_id = $(this).data('id');

        $.ajax({
            url: '{{ url('project_management_section/update') }}/' + section_id,
            method: 'POST',
            // dataType: 'json',
            data: {
                section_name: section_name,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                $('.section-name-id-' + section_id).not(this).val(section_name);
                $(this).trigger('focusout');
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

    // Change Complete Status
    $('body').on('change', '.discussion-check', function() {
        var discussion_id = $(this).val();

        if ($(this).prop('checked') == true) {
            var is_completed = 1;
        } else {
            var is_completed = 0;
        }

        $.ajax({
            url: '{{ url('project_management_section_discussion/update') }}/' + discussion_id,
            method: 'POST',
            data: {
                is_completed: is_completed,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                if (is_completed == 1) {
                    $('.discussion-check-id-' + discussion_id).not(this).prop('checked', true);
                } else {
                    $('.discussion-check-id-' + discussion_id).not(this).prop('checked', false);
                }
                $(this).trigger('focusout');
                //
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

    // Change Complete Status
    $('body').on('change', '.sub-discussion-check', function() {
        var discussion_id = $(this).val();

        if ($(this).prop('checked') == true) {
            var is_completed = 1;
        } else {
            var is_completed = 0;
        }

        $.ajax({
            url: '{{ url('project_management_section_sub_discussion/update') }}/' + discussion_id,
            method: 'POST',
            data: {
                is_completed: is_completed,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                if (is_completed == 1) {
                    $('.sub-discussion-check-id-' + discussion_id).not(this).prop('checked', true);
                } else {
                    $('.sub-discussion-check-id-' + discussion_id).not(this).prop('checked', false);
                }
                $(this).trigger('focusout');
                //
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

    // Add a new discussion
    $('body').on('click', '.add-section-discussion', function() {
        var sectionId = $(this).data('id');
        var orderId = $(this).data('order');

        var row = '<tr id="new_discussion_input">' +
            '<td class="align-content-center border_left_unset">' +
            // '<button type="button" class="btn btn-sm btn-secondary min-btn" data-id="1"><i class="fas fa-caret-right"></i></button>'+
            '<input type="text" class="margin_left_15px" id="discussion_name" placeholder="Write a task name" data-section-id="' +
            sectionId + '" data-order-id="' + orderId +
            '" style="width: auto; border-radius: 4px; border: 1px solid #a8a8a8;" />' +
            '</td><td></td><td></td></tr>';
        $('.project-inner-task#add_section_discussion_' + sectionId).before(row);
    });

    // Add a new sub discussion
    $('body').on('click', '.add-section-sub-discussion', function() {
        var discussionId = $(this).data('discussion-id');
        var sectionId = $(this).data('section-id');
        var orderId = $(this).data('order');

        var row = '<tr id="new_sub_discussion_input">' +
            '<td class="align-content-center border_left_unset" style="padding-left: 3.5rem !important;">' +
            '<input type="text" class="margin_left_15px" id="sub_discussion_name" data-discussion-id="' +
            discussionId + '" data-section-id="' + sectionId + '" data-order-id="' + orderId +
            '" style="width: auto; border-radius: 4px; border: 1px solid #a8a8a8;" />' +
            '</td><td></td><td></td></tr>';
        $('.project-inner-task#add_section_sub_discussion_' + discussionId).before(row);
    });

    // Sub Discussion Name By Enter Key
    $(document).on('blur', '#sub_discussion_name', function(e) {

        // if(e.which === 13){
        if ($('#sub_discussion_name').val() == '' || $('#sub_discussion_name').val() == undefined) {
            $('#sub_discussion_name').val('');
            $('#new_discussion_input').remove();
            $('#sub_discussion_name').unbind('click');

        } else {
            var sub_discussion_name = $('#sub_discussion_name').val();
            var discussion_id = $('#sub_discussion_name').data('discussion-id');
            var section_id = $('#sub_discussion_name').data('section-id');
            var project_id = $('#sub_discussion_name').data('order-id');
            var user_id = $('#discussion_user_id').val();

            var enterSectionDiscussion = 1;
            $(".sub-discussion-name").each(function() {
                if ($(this).attr("discussion-id") == discussion_id && $(this).val() ==
                    sub_discussion_name) {
                    enterSectionDiscussion = 0;
                }
            });

            if (enterSectionDiscussion == 1) {
                $.ajax({
                    url: '{{ url('project_management_section_sub_discussion/store') }}',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        project_id: project_id,
                        section_id: section_id,
                        discussion_id: discussion_id,
                        discussion_name: sub_discussion_name,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#sub_discussion_name').val('');
                        $('#new_sub_discussion_input').remove();
                        $('#sub_discussion_name').unbind('click');

                        var parentMinButton = $('button.parent-min[data-id="' + section_id + '"]');
                        var $parentRow = parentMinButton.closest('.parent-row');
                        var isLoaded = $parentRow.data('section-loaded');
                        if (!isLoaded) {
                            // parentMinButton.toggleClass('rotate');
                            $parentRow.data('section-loaded', true); // Mark as loaded
                        }
                        displaySubDiscussionsByDiscussionId(discussion_id);
                        refreshDiscussionCounts(section_id, discussion_id);

                        // $('button.parent-min[data-id="' + section_id + '"]:not(.rotate)').addClass('rotate');
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
            } else {
                $('#new_discussion_input').remove();
                $('#sub_discussion_name').unbind('click');
                swal({
                    title: "Discussion already available!",
                    text: "Note the discussion your are trying to create is already available in same section.",
                    type: "info",
                    buttons: true,
                    dangerMode: true,
                    confirmButtonColor: '#5fb644',
                })
            }


        }
        // }
    });

    // Discussion Section Name By Enter Key
    $(document).on('blur', '#discussion_name', function(e) {

        // if(e.which === 13){
        if ($('#discussion_name').val() == '' || $('#discussion_name').val() == undefined) {
            $('#discussion_name').val('');
            $('#new_discussion_input').remove();
            $('#discussion_name').unbind('click');

        } else {
            var discussion_name = $('#discussion_name').val();
            var section_id = $('#discussion_name').data('section-id');
            var project_id = $('#discussion_name').data('order-id');
            var user_id = $('#discussion_user_id').val();

            var enterSectionDiscussion = 1;
            $(".discussion-name").each(function() {
                if ($(this).attr("data-id") == section_id && $(this).val() == discussion_name) {
                    enterSectionDiscussion = 0;
                }
            });

            if (enterSectionDiscussion == 1) {
                $.ajax({
                    url: '{{ url('project_management_section_discussion/store') }}',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        project_id: project_id,
                        section_id: section_id,
                        discussion_name: discussion_name,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#discussion_name').val('');
                        $('#new_discussion_input').remove();
                        $('#discussion_name').unbind('click');

                        var parentMinButton = $('button.parent-min[data-id="' + section_id + '"]');
                        var $parentRow = parentMinButton.closest('.parent-row');
                        var isLoaded = $parentRow.data('section-loaded');
                        if (!isLoaded) {
                            // parentMinButton.toggleClass('rotate');
                            $parentRow.data('section-loaded', true); // Mark as loaded
                        }
                        displaySectionDiscussionsBySectionId(section_id);
                        refreshDiscussionCounts(section_id, data.id);

                        // $('button.parent-min[data-id="' + section_id + '"]:not(.rotate)').addClass('rotate');
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
            } else {
                $('#new_discussion_input').remove();
                $('#discussion_name').unbind('click');
                swal({
                    title: "Discussion already available!",
                    text: "Note the discussion your are trying to create is already available in same section.",
                    type: "info",
                    buttons: true,
                    dangerMode: true,
                    confirmButtonColor: '#5fb644',
                })
            }


        }
        // }
    });

    // Rename a Discussion
    $('body').on('change', '.discussion-name', function() {
        var discussion_name = $(this).val();
        var discussion_id = $(this).data('discussion');

        if (discussion_name.length != 0) {
            $.ajax({
                url: '{{ url('project_management_section_discussion/update') }}/' + discussion_id,
                method: 'POST',
                data: {
                    'discussion_name': discussion_name,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('.discussion-name-id-' + discussion_id).not(this).val(discussion_name);
                    $(this).trigger('focusout');
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
        } else {
            swal({
                title: "Warning!",
                text: "Discussion name cannot be empty.",
                type: "info",
                buttons: true,
                dangerMode: true,
                confirmButtonColor: '#5fb644'
            }).then((result) => {
                $(this).focus();
            });
        }
    });

    // Rename a Sub Discussion
    $('body').on('change', '.sub-discussion-name', function() {
        var discussion_name = $(this).val();
        var discussion_id = $(this).data('discussion');

        if (discussion_name.length != 0) {
            $.ajax({
                url: '{{ url('project_management_section_sub_discussion/update') }}/' + discussion_id,
                method: 'POST',
                data: {
                    'discussion_name': discussion_name,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('.sub-discussion-name-id-' + discussion_id).not(this).val(discussion_name);
                    $(this).trigger('focusout');
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
        } else {
            swal({
                title: "Warning!",
                text: "Discussion name cannot be empty.",
                type: "info",
                buttons: true,
                dangerMode: true,
                confirmButtonColor: '#5fb644'
            }).then((result) => {
                $(this).focus();
            });
        }
    });

    $('body').on('click', '.task-assignees', function() {
        var assigneeDiv = $(this);
        var assigneeSelect = assigneeDiv.parent().find('.discussion-assignee-name');
        var changed = false;

        assigneeDiv.toggleClass('d-none d-flex');
        // assigneeSelect.prop('hidden', false).focus().trigger('click');
        assigneeSelect.show();
        assigneeSelect.next('.select2-container').show();
        assigneeSelect.select2('open');

        assigneeSelect.one('change', function() {

            var assignee_id = $(this).val();
            if (assignee_id != '' || assignee_id != null) {

                changed = true;
                var discussion_id = $(this).data('discussion');
                var assignee_name = $(this).find('option:selected').data('name');
                var assignee_image = $(this).find('option:selected').data('image');

                $.ajax({
                    url: '{{ url('project_management_section_discussion/update') }}/' +
                        discussion_id,
                    method: 'POST',
                    data: {
                        assignee_id: assignee_id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        displaySectionAssignees(data.section_id);

                        var taskAssigneeDetail = '<img src="{{ asset('') }}/' +
                            assignee_image + '" class="project-inner-avatar" style="">' +
                            '<span class="text-gray" style="padding-left: 15px;">' +
                            assignee_name + '</span>';
                        assigneeDiv.html(taskAssigneeDetail);
                        $('.task-assignees-id-' + discussion_id).not(this).html(
                            taskAssigneeDetail);
                        assigneeSelect.next('.select2-container').hide();
                        assigneeSelect.hide();
                        assigneeDiv.toggleClass('d-none d-flex');
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
        });

        assigneeSelect.one('focusout', function() {
            if (!changed) {
                assigneeSelect.next('.select2-container').hide();
                assigneeSelect.hide();
                assigneeDiv.toggleClass('d-none d-flex');
            }
        });
    });

    $('body').on('click', '.sub-task-assignees', function() {
        var assigneeDiv = $(this);
        var assigneeSelect = assigneeDiv.parent().find('.sub-discussion-assignee-name');
        var changed = false;

        assigneeDiv.toggleClass('d-none d-flex');
        // assigneeSelect.prop('hidden', false).focus().trigger('click');
        assigneeSelect.show();
        assigneeSelect.next('.select2-container').show();
        assigneeSelect.select2('open');

        assigneeSelect.one('change', function() {

            var assignee_id = $(this).val();
            if (assignee_id != '' || assignee_id != null) {

                changed = true;
                var discussion_id = $(this).data('discussion');
                var assignee_name = $(this).find('option:selected').data('name');
                var assignee_image = $(this).find('option:selected').data('image');

                $.ajax({
                    url: '{{ url('project_management_section_sub_discussion/update') }}/' +
                        discussion_id,
                    method: 'POST',
                    data: {
                        assignee_id: assignee_id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        displaySectionAssignees(data.section_id);
                        var taskAssigneeDetail = '<img src="{{ asset('') }}/' +
                            assignee_image + '" class="project-inner-avatar" style="">' +
                            '<span class="text-gray" style="padding-left: 15px;">' +
                            assignee_name + '</span>';
                        assigneeDiv.html(taskAssigneeDetail);
                        $('.sub-task-assignees-id-' + discussion_id).not(this).html(
                            taskAssigneeDetail);
                        assigneeSelect.next('.select2-container').hide();
                        assigneeSelect.hide();
                        assigneeDiv.toggleClass('d-none d-flex');
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
        });

        assigneeSelect.one('focusout', function() {
            if (!changed) {
                assigneeSelect.next('.select2-container').hide();
                assigneeSelect.hide();
                assigneeDiv.toggleClass('d-none d-flex');
            }
        });
    });

    // Add due date to a Discussion
    $('body').on('change', '.discussion-due-date', function() {
        var due_date = $(this).val();
        var discussion_id = $(this).data('discussion');

        $.ajax({
            url: '{{ url('project_management_section_discussion/update') }}/' + discussion_id,
            method: 'POST',
            data: {
                due_date: due_date,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                $(this).trigger('focusout');
                //
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

    // Add due date to a Discussion
    $('body').on('change', '.sub-discussion-due-date', function() {
        var due_date = $(this).val();
        var discussion_id = $(this).data('discussion');

        $.ajax({
            url: '{{ url('project_management_section_sub_discussion/update') }}/' + discussion_id,
            method: 'POST',
            data: {
                due_date: due_date,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                $(this).trigger('focusout');
                //
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

    // Delete a Section
    $('body').on('click', '.delete-section-discussion', function() {
        var section_id = $(this).data('id');
        var project_id = $(this).data('order');

        Swal.fire({
            title: "Confirm Delete?",
            text: "Do You Want to Delete This Section?",
            type: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            closeOnConfirm: false,
            closeOnCancel: true

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: '{{ url('project_management_section/delete') }}/' + section_id,
                    method: 'GET',
                    success: function(data) {
                        deleteSection(section_id);
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
        });


    });

    // Delete a Discussion
    $('body').on('click', '.delete-discussion', function() {
        var section_id = $(this).data('id');
        var project_id = $(this).data('order');
        var discussion_id = $(this).data('discussion');

        Swal.fire({
            title: "Confirm Delete?",
            text: "Do You Want to Delete This Discussion?",
            type: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            closeOnConfirm: false,
            closeOnCancel: true

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: '{{ url('project_management_section_discussion/delete') }}/' +
                        discussion_id,
                    method: 'GET',
                    success: function(data) {
                        deleteSectionDiscussion(discussion_id);
                        refreshDiscussionCounts(section_id, discussion_id);
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
        });
    });

    // Delete a Discussion
    $('body').on('click', '.delete-sub-discussion', function() {
        var section_id = $(this).data('id');
        var project_id = $(this).data('order');
        var discussion_id = $(this).data('discussion');

        Swal.fire({
            title: "Confirm Delete?",
            text: "Do You Want to Delete This Discussion?",
            type: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            closeOnConfirm: false,
            closeOnCancel: true

        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $.ajax({
                    url: '{{ url('project_management_section_sub_discussion/delete') }}/' +
                        discussion_id,
                    method: 'GET',
                    success: function(data) {
                        deleteSectionSubDiscussion(discussion_id);
                        refreshDiscussionCounts(section_id, discussion_id);
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
        });
    });

    function displayAllSections() {

        var project_id = $('#discussion_project_id').val();
        var orderID = '{{ $order->id }}';
        $.ajax({
            url: '{{ url("get_project_management_all") }}',
            method: 'GET',
            dataType: 'json',
            data: {
                project_id: project_id,
                order_id: orderID
            },
            success: function(data) {
                console.log(data);
                var filteredSections = data || [];

                for (var i = 0; i < filteredSections.length; i++) {
                    displaySingleSection(filteredSections[i]);
                }
                $('.parent-min').click();
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

    function displaySingleSectionById(sectionId) {
        $.ajax({
            url: '{{ url('get_project_management_section_by_id') }}/' + sectionId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                displaySingleSection(data)
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


    function displaySingleSection(section_data) {
        var parentRow =
            '<tr class="project-inner-section border_left_unset cursor_pointer parent-row draggable-item" ' +
            'data-toggle-section="parent-discussion-' + section_data.id + '" ' +
            'id="parent_section_' + section_data.id + '" ' +
            'data-section-id="' + section_data.id + '" draggable="true">' +

            '<td class="border_left_unset border_right_unset font_15px">'+
            '<div class="hierarchy-item section-level">' +
            '<span class="section-drag-handle">⋮⋮</span>' +
            '<span class="toggle-arrow parent-min" data-id="' + section_data.id + '">' +
            '<button type="button" class="btn btn-primary arrow"><i class="fa-solid fa-caret-right"></i></button>' +
            '</span> ' +

            '<span class="input-wrapper" style="position:relative; display:inline-block;">' +
            '<input type="text" class="border-0 section-name section-name-id-' + section_data.id + '" ' +
            'style="width:auto%; box-sizing:border-box;" ' +
            'data-id="' + section_data.id + '" ' +
            'value="' + section_data.section_name  + '" ' +
            'data-order="' + section_data.project_id + '" disabled>' +


            '<div class="input-overlay" data-id="' + section_data.id + '" ' +
            'style="position:absolute; inset:0; cursor:pointer; background:transparent;"></div>' +
            '</span>' +

            '<div class="comment-div">'+
                '<span class="comment-count section-id-' + section_data.id + '">' +
                    '<span class="comment-number-section">0</span>' +
                    '<i class="fa-regular fa-comment-dots"></i> ' +
                '</span>'+
            '</div>'+


            '<div class="discussion-div">'+
                '<span class="discussion-count section-id-' + section_data.id + '">' +
                    '<span class="discussion-number-section">0</span>' +
                    '<i class="fa-solid fa-list-check"></i> ' +
                '</span>'+
            '</div>'+
            '</div>'+
            '</td>' +

            '<td colspan="2">' +
            '<div class="section-avatar-group section-assignees" id="section_assignees_' + section_data.id +
            '"></div>' +
            '</td>' +

            '@can('delete section')' +
            '<td class="align-content-center">' +
            '<button type="button" class="btn btn-sm delete-section-discussion" style="background: none;" ' +
            'data-id="' + section_data.id + '" ' +
            'data-order="' + section_data.project_id + '" ' +
            'data-toggle="tooltip" data-placement="bottom" title="Delete this section">' +
            '<i class="fa fas fa-trash trash_btn"></i>' +
            '</button>' +
            '</td>' +
            '@endcan' +

            '</tr>';

        $('#discussion_tbody').append(parentRow);
        displaySectionAssignees(section_data.id);
        displayCommentCount(section_data.id);
        displayDiscussionCount(section_data.id);
    }



    function displaySectionAssignees(sectionId) {
        $('#section_assignees_' + sectionId).html('');

        $.ajax({
            url: '{{ url('get_project_management_section_assignees_by_id') }}/' + sectionId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {

                if (data.length === 0) {
                    return;
                }

                var row = '';
                for (let i = 0; i < data.length; i++) {
                    row += '<img src="' + data[i].profile_pic_url + '" class="section-avatar">';
                }

                $('#section_assignees_' + sectionId).html(row);
            }
        });
    }

    function displayCommentCount(sectionId) {

        $.ajax({
            url: '{{ url('section_comment_count') }}/' + sectionId,
            method: 'GET',
            success: function(data) {;
                $('span.comment-count.section-id-' + sectionId + ' .comment-number-section').text(data.count);
            }
        });
    }

    function displayDiscussionCount(sectionId) {
        $.ajax({
            url: '{{ url('discussion_count') }}/' + sectionId,
            method: 'GET',
            success: function(data) {
                $('span.discussion-count.section-id-' + sectionId + ' .discussion-number-section').text(data.count);
            }
        });
    }



    function displaySectionDiscussionsBySectionId(sectionId) {
        $.ajax({
            url: '{{ url('get_project_management_section_by_id') }}/' + sectionId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // List Display
                $('.parent-section-' + sectionId).remove();
                displaySectionDiscussions(data);

                // Board Display
                $('#board_section_' + sectionId).html('');
                displayBoardSectionDiscussions(data);
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

    function displaySubDiscussionsByDiscussionId(discussionId) {
        $.ajax({
            url: '{{ url('get_project_management_section_sub_discussion_by_discussion_id') }}/' + discussionId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // List Display
                $('.parent-discussion-' + discussionId).remove();
                displaySubDiscussions(data);

                // Board Display
                // $('#board_section_'+sectionId).html('');
                // displayBoardSectionDiscussions(data);
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


    function displaySectionDiscussions(sectionData) {

        var discussion_data = sectionData.discussions;

        var childRow = [];
        for (var j = 0; j < discussion_data.length; j++) {
            var userOptions = [];


            for (let l = 0; l < userInfo.length; l++) {
                var isSelected = (discussion_data[j].assignee_id == userInfo[l].id) ? 'selected' : '';
                userOptions += '<option data-name="' + userInfo[l].name + '" data-image="' + userInfo[l].profile_pic +
                    '" value="' + userInfo[l].id + '" ' + isSelected + '>' + userInfo[l].name + '</option>';
            }

            var isCompletedCheck = (discussion_data[j].is_completed == 1) ? 'checked' : '';

            var assigneeUserDetails = '<span class="text-gray" style="padding-left: 15px;"><i>No Assignee</i></span>';
            if (discussion_data[j].assignee_user) {
                assigneeUserDetails =
                    '<img src="{{ asset('') }}/' + discussion_data[j].assignee_user.profile_pic +
                    '" class="project-inner-avatar">' +
                    '<span class="text-gray" style="padding-left: 15px;">' + discussion_data[j].assignee_user.name +
                    '</span>';
            }
            displaySubDiscussionCount(sectionData.id, discussion_data[j].id);
            displaySubDiscussionCommentCount(sectionData.id, discussion_data[j].id);

            var discussionDueDate = discussion_data[j].due_date ? discussion_data[j].due_date : '';

            // Get priority
            var priority = discussion_data[j].priority || 'Medium';

            childRow +=
                '<tr class="project-inner-task parent-discussion-row section-parent-discussion-' + sectionData.id +
                ' parent-section-' + sectionData.id + ' draggable-item" ' +
                'id="discussion_' + discussion_data[j].id + '" data-discussion-id="' + discussion_data[j].id +
                '" data-section-id="' + sectionData.id + '" draggable="true">' +

                '<td class="align-content-center border_left_unset" data-discussion-type="discussion" data-value="' +
                discussion_data[j].id + '" >' +
                '<div class="hierarchy-item discussion-level open-chatbox gap-2" data-discussion-type="discussion" data-value="' +
                discussion_data[j].id + '">' +
                '<span class="drag-handle">⋮⋮</span>' +
                '<span class="toggle-arrow parent-discussion-min cursor_pointer" data-id="' + discussion_data[j].id +
                '">' +
                '<button type="button" class="btn btn-primary arrow"><i class="fa-solid fa-caret-right"></i></button>' +
                '</span>' +
                '<input type="checkbox" class="main-check-list margin_right circle_checkbox margin_left_15px discussion-check discussion-check-id-' +
                discussion_data[j].id + '" ' + isCompletedCheck + ' value="' + discussion_data[j].id + '">' +

                '<span class="input-wrapper" style="position:relative; flex:1; min-width:0; display:flex; align-items:center;">' +
                '<input type="text" class="border-0 w-100 discussion-name discussion-name-id-' + discussion_data[j].id +
                '" ' +
                'data-id="' + sectionData.id + '" data-order="' + sectionData.project_id + '" data-discussion="' +
                discussion_data[j].id + '" ' +
                'value="' + ((discussion_data[j].discussion_name || '').replace(/"/g, '&quot;')) + '" disabled>' +
                '<span class="priority-indicator ' + priority.toLowerCase() + ' discussion-priority-id-' + discussion_data[j].id + '" title="' + priority + '">' +
                '<span class="priority-dot"></span>' +
                '<span class="priority-text">' + priority + '</span>' +
                '</span>' +
                '<div class="input-overlay" data-type="discussion" data-discussion="' + discussion_data[j].id + '" ' +
                'style="position:absolute; inset:0; cursor:pointer; background:transparent;"></div>' +
                '</span>' +
                '</div>' +
                '<div class="comment-div">'+
                    '<span class="subcomment-count section-id-' + discussion_data[j].id + '">' +
                        '<span class="comment-number">0</span>' +
                        '<i class="fa-regular fa-comment-dots"></i> ' +
                    '</span>'+
                '</div>'+
                '<div class="discussion-div">'+
                    '<span class="subdiscussion-count section-id-' + discussion_data[j].id + '">' +
                        '<span class="discussion-number">0</span>' +
                        '<img src="{{ asset('assets/img/icons/project_icons/subtask_icon_1.png') }}" alt="Sub Tasks" style="width:15px; height:19px;  color: #858585;">' +
                    '</span>'+
                '</div>'+
                '</td>' +

                '<td class="align-content-center">' +
                '<div class="d-flex align-items-center task-assignees task-assignees-id-' + discussion_data[j].id +
                ' cursor_pointer">' +
                assigneeUserDetails +
                '</div>' +
                '<select class="border-0 w-100 discussion-assignee-name" style="height: 1.5rem;" data-id="' +
                sectionData.id + '" data-order="' + sectionData.project_id + '" data-discussion="' + discussion_data[j]
                .id + '">' +
                '<option data-name="" data-image="" value="">No Assignee</option>' +
                userOptions +
                '</select>' +
                '</td>' +

                '<td class="align-content-center">' +
                '<input type="date" class="border-0 discussion-due-date discussion-due-date-id-' + discussion_data[j]
                .id + ' datepicker" ' +
                'style="width: 6rem;" data-id="' + sectionData.id + '" data-order="' + sectionData.project_id +
                '" data-discussion="' + discussion_data[j].id + '" value="' + discussion_data[j].due_date + '">' +
                '</td>' +

                '@can('delete discussion')' +
                '<td class="align-content-center">' +
                '<button type="button" class="btn btn-sm delete-discussion" style="background: none;" ' +
                'data-id="' + sectionData.id + '" data-order="' + sectionData.project_id + '" data-discussion="' +
                discussion_data[j].id + '" ' +
                'data-sectionName="' + sectionData.section_name + '" data-discussionName="' + discussion_data[j]
                .discussion_name + '" ' +
                'data-toggle="tooltip" data-placement="bottom" title="Delete this discussion">' +
                '<i class="fa fas fa-trash trash_btn"></i>' +
                '</button>' +
                '</td>' +
                '@endcan' +
                '</tr>';
        }

        var addTaskRow =
            '<tr class="project-inner-task section-parent-discussion-' + sectionData.id + ' parent-section-' +
            sectionData.id + '" id="add_section_discussion_' + sectionData.id + '">' +
            '<td colspan="3" class="border_left_unset border_right_unset text-gray" style="padding-left: 1.8rem !important;">' +
            '<button type="button" class="btn btn-outline-secondary board-add-task add_task_btn add-section-discussion" data-id="' +
            sectionData.id + '" data-order="' + sectionData.project_id + '">+ Add Task</button>' +
            '</td>' +
            '</tr>';

        var discussionRows = childRow + addTaskRow;

        $('#parent_section_' + sectionData.id).after(discussionRows);

        updateSelec2s();
    }


    function displaySubDiscussionCount(id, discussion) {
        $.ajax({
            url: '{{ url('get_project_management_sub_section_discussion_count_by_id') }}/' + id + '/' + discussion,
            method: 'GET',
            success: function(data) {

                $('span.subdiscussion-count.section-id-' + data.discussion_id + ' .discussion-number').text(data.count);
            }
        });
    }

    function displaySubDiscussionCommentCount(id, discussion) {
        $.ajax({
            url: '{{ url('get_project_management_sub_section_discussion_comment_count_by_id') }}/' + id + '/' + discussion,
            method: 'GET',
            success: function(data) {

               $('span.subcomment-count.section-id-' + data.discussion_id + ' .comment-number').text(data.count);
            }
        });
    }



    function refreshDiscussionCounts(sectionId, discussionId) {
        displayDiscussionCount(sectionId);
        displayCommentCount(sectionId);

        displaySubDiscussionCount(sectionId, discussionId);
        displaySubDiscussionCommentCount(sectionId, discussionId);
    }




    function displaySubDiscussions(discussionData) {

        var discussion_data = discussionData.sub_discussions;

        var childRow = [];
        for (var j = 0; j < discussion_data.length; j++) {

            var userOptions = [];
            for (let l = 0; l < userInfo.length; l++) {
                var isSelected = (discussion_data[j].assignee_id == userInfo[l].id) ? 'selected' : '';
                userOptions += '<option data-name="' + userInfo[l].name + '" data-image="' + userInfo[l].profile_pic +
                    '" value="' + userInfo[l].id + '" ' + isSelected + '>' + userInfo[l].name + '</option>';
            }

            var isCompletedCheck = (discussion_data[j].is_completed == 1) ? 'checked' : '';

            var assigneeUserDetails = '<span class="text-gray" style="padding-left: 15px;"><i>No Assignee</i></span>';
            if (discussion_data[j].assignee_user) {
                assigneeUserDetails =
                    '<img src="{{ asset('') }}/' + discussion_data[j].assignee_user.profile_pic +
                    '" class="project-inner-avatar" style="">' +
                    '<span class="text-gray" style="padding-left: 15px;">' + discussion_data[j].assignee_user.name +
                    '</span>';
            }

            var discussionDueDate = discussion_data[j].due_date ?? '';

            // Get priority
            var priority = discussion_data[j].priority || 'Medium';

            childRow +=
                '<tr class="project-inner-task sub-discussion-row section-parent-discussion-' + discussion_data[j]
                .section_id + ' parent-section-' + discussion_data[j].section_id + ' parent-discussion-' +
                discussion_data[j].discussion_id + ' draggable-item" ' +
                'id="sub_discussion_' + discussion_data[j].id + '" data-sub-discussion-id="' + discussion_data[j].id +
                '" data-discussion-id="' + discussion_data[j].discussion_id + '" draggable="true">' +

                '<td class="align-content-center border_left_unset" data-discussion-type="sub_discussion" data-value="' +
                discussion_data[j].id + '">' +
                '<div class="hierarchy-item subdiscussion-level open-chatbox gap-2" data-discussion-type="sub_discussion" data-value="' +
                discussion_data[j].id + '">'+
                '<span class="drag-handle">⋮⋮</span>' +

                '<input type="checkbox" class="main-check-list margin_right circle_checkbox margin_left_15px sub-discussion-check sub-discussion-check-id-' +
                discussion_data[j].id + '" ' + isCompletedCheck + ' value="' + discussion_data[j].id + '">' +


                '<span class="input-wrapper" style="position:relative; flex:1; min-width:0; display:flex; align-items:center;">' +
                '<input type="text" class="border-0 w-100 sub-discussion-name sub-discussion-name-id-' +
                discussion_data[j].id + '" ' +
                'data-id="' + discussion_data[j].section_id + '" data-order="' + discussion_data[j].project_id +
                '" data-discussion="' + discussion_data[j].id + '" ' +
                'value="' + ((discussion_data[j].discussion_name || '').replace(/"/g, '&quot;')) + '" disabled>' +
                '<span class="priority-indicator ' + priority.toLowerCase() + ' sub-discussion-priority-id-' + discussion_data[j].id + '" title="' + priority + '">' +
                '<span class="priority-dot"></span>' +
                '<span class="priority-text">' + priority + '</span>' +
                '</span>' +
                '<div class="input-overlay" data-type="subdiscussion" data-id="' + discussion_data[j].id + '" ' +
                'style="position:absolute; inset:0; cursor:text; background:transparent;"></div>' +
                '</span>' +
                '</div>' +
                '</td>' +

                '<td class="align-content-center">' +
                '<div class="d-flex align-items-center sub-task-assignees sub-task-assignees-id-' + discussion_data[j]
                .id + ' cursor_pointer">' +
                assigneeUserDetails +
                '</div>' +
                '<select class="border-0 w-100 sub-discussion-assignee-name" style="height: 1.5rem;" ' +
                'data-id="' + discussion_data[j].section_id + '" data-order="' + discussion_data[j].project_id +
                '" data-discussion="' + discussion_data[j].id + '">' +
                '<option value="">No Assignee</option>' +
                userOptions +
                '</select>' +
                '</td>' +

                '<td class="align-content-center">' +
                '<input type="date" class="border-0 sub-discussion-due-date sub-discussion-due-date-id-' +
                discussion_data[j].id + ' datepicker" ' +
                'style="width: 6rem;" data-id="' + discussion_data[j].section_id + '" data-order="' + discussion_data[j]
                .project_id + '" data-discussion="' + discussion_data[j].id + '" value="' + discussion_data[j]
                .due_date + '">' +
                '</td>' +

                '@can('delete discussion')' +
                '<td class="align-content-center">' +
                '<button type="button" class="btn btn-sm delete-sub-discussion" style="background: none;" ' +
                'data-id="' + discussion_data[j].section_id + '" data-order="' + discussion_data[j].project_id +
                '" data-discussion="' + discussion_data[j].id + '" ' +
                'data-sectionName="' + discussion_data[j].section.section_name + '" data-discussionName="' +
                discussion_data[j].discussion_name + '" ' +
                'data-toggle="tooltip" data-placement="bottom" title="Delete this discussion">' +
                '<i class="fa fas fa-trash trash_btn"></i>' +
                '</button>' +
                '</td>' +
                '@endcan' +

                '</tr>';
        }

        var addTaskRow =
            '<tr class="project-inner-task section-parent-discussion-' + discussionData.section_id +
            ' parent-section-' + discussionData.section_id + ' parent-discussion-' + discussionData.id +
            '" id="add_section_sub_discussion_' + discussionData.id + '">' +
            '<td colspan="3" class="border_left_unset border_right_unset text-gray" style="padding-left: 3.5rem !important;">' +
            '<button type="button" class="btn btn-outline-secondary board-add-task add_task_btn add-section-sub-discussion" data-discussion-id="' +
            discussionData.id + '" data-section-id="' + discussionData.section_id + '" data-order="' + discussionData
            .project_id + '">+ Add Sub Task</button>' +
            '</td>' +
            '</tr>';

        $('#discussion_' + discussionData.id).after(childRow + addTaskRow);

        // $(".sub-discussion-name").each(function () {
        //     var len = $(this).val().length;
        //     len = Math.min(Math.max(len, 10), 50);
        //     $(this).width(len * 8);
        // });
        updateSubSelec2s();
    }


    function updateSelec2s() {
        $('.discussion-assignee-name').each(function() {
            $(this).select2(); // initialize select2

            // hide both the select and the select2 UI
            $(this).hide(); // hide the original select
            $(this).next('.select2-container').hide(); // hide the generated select2 UI
        });
    }

    function updateSubSelec2s() {
        $('.sub-discussion-assignee-name').each(function() {
            $(this).select2(); // initialize select2

            // hide both the select and the select2 UI
            $(this).hide(); // hide the original select
            $(this).next('.select2-container').hide(); // hide the generated select2 UI
        });
    }

    function deleteSection(sectionId) {
        $('#parent_section_' + sectionId).fadeOut(300, function() {
            $(this).remove();
        });
        $('.parent-section-' + sectionId).fadeOut(300, function() {
            $(this).remove();
        });
        $('#parent_board_section_' + sectionId).fadeOut(300, function() {
            $(this).remove();
        });
    }

    function deleteSectionDiscussion(discussionId) {
        $('#discussion_' + discussionId).fadeOut(300, function() {
            $(this).remove();
        });
        $('#board_discussion_' + discussionId).fadeOut(300, function() {
            $(this).remove();
        });
    }

    function deleteSectionSubDiscussion(subDiscussionId) {
        $('#sub_discussion_' + subDiscussionId).fadeOut(300, function() {
            $(this).remove();
        });
        // $('#board_sub_discussion_'+subDiscussionId).fadeOut(300, function() { $(this).remove(); });
    }

    // Drag and Drop Functionality
    let draggedElement = null;
    let draggedType = null;
    let draggedParentId = null;
    let currentDropTarget = null;

    // Initialize drag and drop after DOM is ready
    $(document).ready(function() {
        initializeDragAndDrop();
    });

    function initializeDragAndDrop() {
        // Section drag and drop
        $(document).on('dragstart', '.parent-row[draggable="true"]', function(e) {
            draggedElement = this;
            draggedType = 'section';
            draggedParentId = $(this).data('section-id');
            $(this).addClass('dragging');
        });

        // Discussion drag and drop
        $(document).on('dragstart', '.parent-discussion-row[draggable="true"]', function(e) {
            draggedElement = this;
            draggedType = 'discussion';
            draggedParentId = $(this).data('section-id');
            $(this).addClass('dragging');
        });

        // Sub-discussion drag and drop
        $(document).on('dragstart', '.sub-discussion-row[draggable="true"]', function(e) {
            draggedElement = this;
            draggedType = 'sub-discussion';
            draggedParentId = $(this).data('discussion-id');
            $(this).addClass('dragging');
        });

        // Drag end
        $(document).on('dragend', '.draggable-item', function(e) {
            $(this).removeClass('dragging');
            $('.drop-zone').remove();
            draggedElement = null;
            draggedType = null;
            draggedParentId = null;
            currentDropTarget = null;
        });

        // Drag over (restrict valid targets by hierarchy)
        $(document).on('dragover', '.draggable-item', function(e) {
            e.preventDefault();

            if (!draggedElement || draggedElement === this || currentDropTarget === this) {
                return;
            }

            const $target = $(this);

            // Enforce valid targets
            if (draggedType === 'section') {
                // Only allow over other section header rows
                if (!$target.hasClass('parent-row')) {
                    return;
                }
            } else if (draggedType === 'discussion') {
                // Only allow over discussion rows within same section
                if (!$target.hasClass('parent-discussion-row')) {
                    return;
                }
                const targetSectionId = $target.data('section-id');
                if (String(targetSectionId) !== String($(draggedElement).data('section-id'))) {
                    return;
                }
            } else if (draggedType === 'sub-discussion') {
                // Only allow over sub-discussion rows within same discussion
                if (!$target.hasClass('sub-discussion-row')) {
                    return;
                }
                const targetDiscussionId = $target.data('discussion-id');
                if (String(targetDiscussionId) !== String($(draggedElement).data('discussion-id'))) {
                    return;
                }
            }

            currentDropTarget = this;
            showDropZone(this);
        });

        // Drop
        $(document).on('drop', '.draggable-item', function(e) {
            e.preventDefault();
            if (draggedElement && draggedElement !== this) {
                handleDrop(this);
            }
        });

        // Drag leave
        $(document).on('dragleave', '.draggable-item', function(e) {
            if (currentDropTarget === this) {
                currentDropTarget = null;
                hideDropZone(this);
            }
        });
    }

    function showDropZone(target) {
        // Remove all existing drop zones first
        $('.drop-zone').remove();

        const $target = $(target);
        $target.after('<div class="drop-zone active"></div>');
    }

    function hideDropZone(target) {
        // Remove all drop zones when leaving
        $('.drop-zone').remove();
    }

    function handleDrop(target) {
        const $target = $(target);
        const $dragged = $(draggedElement);

        // Remove drop zone
        $('.drop-zone').remove();

        // Handle different types of drops
        if (draggedType === 'section') {
            handleSectionDrop($dragged, $target);
        } else if (draggedType === 'discussion') {
            handleDiscussionDrop($dragged, $target);
        } else if (draggedType === 'sub-discussion') {
            handleSubDiscussionDrop($dragged, $target);
        }
    }

    function handleSectionDrop($dragged, $target) {
        const targetSectionId = $target.data('section-id');
        const draggedSectionId = $dragged.data('section-id');

        if (targetSectionId && draggedSectionId && targetSectionId !== draggedSectionId) {
            // Build the dragged block: section header + all its visible children (discussions and sub-discussions belonging to it)
            const $rowsToMove = $();
            let $block = $dragged;
            // Collect contiguous rows until next section header or end/add section row
            const $following = $dragged.nextUntil('.parent-row, #add_section_row');
            $block = $block.add($following);

            // Move the entire block around the target section header
            if ($dragged.index() < $target.index()) {
                $target.after($block);
            } else {
                $target.before($block);
            }

            // Update sort order in database
            updateSectionOrder();
        }
    }

    function handleDiscussionDrop($dragged, $target) {
        const targetSectionId = $target.data('section-id');
        const draggedSectionId = $dragged.data('section-id');

        // Only allow reordering within the same section
        if (targetSectionId && draggedSectionId && targetSectionId === draggedSectionId) {
            const targetDiscussionId = $target.data('discussion-id');
            const draggedDiscussionId = $dragged.data('discussion-id');

            if (targetDiscussionId && draggedDiscussionId && targetDiscussionId !== draggedDiscussionId) {
                // Build the dragged block: discussion row + all its sub-discussion rows (that share parent-discussion-<id>)
                let $block = $dragged;
                const selector = '.parent-discussion-' + draggedDiscussionId;
                // Collect contiguous rows that belong to this discussion id (sub-discussions and the add row)
                const $following = $dragged.nextUntil('.parent-discussion-row, .parent-row', selector);
                $block = $block.add($following);

                // Move the entire block around the target discussion row
                if ($dragged.index() < $target.index()) {
                    $target.after($block);
                } else {
                    $target.before($block);
                }

                // Update sort order in database
                updateDiscussionOrder(targetSectionId);
            }
        }
    }

    function handleSubDiscussionDrop($dragged, $target) {
        const targetDiscussionId = $target.data('discussion-id');
        const draggedDiscussionId = $dragged.data('discussion-id');

        // Only allow reordering within the same discussion
        if (targetDiscussionId && draggedDiscussionId && targetDiscussionId === draggedDiscussionId) {
            const targetSubDiscussionId = $target.data('sub-discussion-id');
            const draggedSubDiscussionId = $dragged.data('sub-discussion-id');

            if (targetSubDiscussionId && draggedSubDiscussionId && targetSubDiscussionId !== draggedSubDiscussionId) {
                // Move the DOM element
                if ($dragged.index() < $target.index()) {
                    $target.after($dragged);
                } else {
                    $target.before($dragged);
                }

                // Update sort order in database
                updateSubDiscussionOrder(targetDiscussionId);
            }
        }
    }

    function updateSectionOrder() {
        const sectionIds = [];
        $('.parent-row[data-section-id]').each(function() {
            sectionIds.push($(this).data('section-id'));
        });

        if (sectionIds.length > 0) {
            $.ajax({
                url: '{{ url('project_management_sections/reorder') }}',
                method: 'POST',
                data: {
                    project_id: $('#discussion_project_id').val(),
                    section_ids: sectionIds,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                    } else {
                        console.error('Failed to reorder sections');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error reordering sections:', error);
                }
            });
        }
    }

    function updateDiscussionOrder(sectionId) {
        const discussionIds = [];
        $('.parent-discussion-row[data-section-id="' + sectionId + '"]').each(function() {
            discussionIds.push($(this).data('discussion-id'));
        });

        if (discussionIds.length > 0) {
            $.ajax({
                url: '{{ url('project_management_discussions/reorder') }}',
                method: 'POST',
                data: {
                    section_id: sectionId,
                    discussion_ids: discussionIds,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                    } else {
                        console.error('Failed to reorder discussions');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error reordering discussions:', error);
                }
            });
        }
    }

    function updateSubDiscussionOrder(discussionId) {
        const subDiscussionIds = [];
        $('.sub-discussion-row[data-discussion-id="' + discussionId + '"]').each(function() {
            subDiscussionIds.push($(this).data('sub-discussion-id'));
        });

        if (subDiscussionIds.length > 0) {
            $.ajax({
                url: '{{ url('project_management_sub_discussions/reorder') }}',
                method: 'POST',
                data: {
                    discussion_id: discussionId,
                    sub_discussion_ids: subDiscussionIds,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                    } else {
                        console.error('Failed to reorder sub-discussions');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error reordering sub-discussions:', error);
                }
            });
        }
    }


    $(document).on('dblclick', '.input-overlay', function() {
        let input = $(this).closest('.input-wrapper').find('input.section-name');
        $(this).hide();
        input.prop('disabled', false).focus().select();
    });

    $(document).on('blur', 'input.section-name', function() {
        let overlay = $(this).closest('.input-wrapper').find('.input-overlay');
        $(this).prop('disabled', true);
        overlay.show();
    });

    $(document).on('keydown', 'input.section-name', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $(this).blur();
        }
    });


    // $(document).on('dblclick', '.input-overlay', function () {
    //     let input = $(this).closest('.input-wrapper').find('input.section-name, input.discussion-name');
    //     if (input.length) {
    //         $(this).hide();
    //         input.prop('disabled', false);
    //         input.focus().select();
    //     }
    // });

    $(document).on('dblclick', '.input-overlay', function() {

        if (clickTimer) {
            clearTimeout(clickTimer);
            clickTimer = null;
        }

        let input = $(this).closest('.input-wrapper')
            .find('input.section-name, input.discussion-name');

        if (input.length) {
            $(this).hide();
            input.prop('disabled', false);
            input.focus().select();
        }
    });


    $(document).on('blur', 'input.section-name, input.discussion-name', function() {
        let overlay = $(this).closest('.input-wrapper').find('.input-overlay');
        $(this).prop('disabled', true);
        overlay.show();
    });


    $(document).on('keydown', 'input.section-name, input.discussion-name', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $(this).blur();
        }
    });



    // --------------------------------------

    $(document).on('dblclick', '.input-overlay', function() {

        if (clickTimer) {
            clearTimeout(clickTimer);
            clickTimer = null;
        }

        let input = $(this).closest('.input-wrapper')
            .find('input.section-name, input.discussion-name, input.sub-discussion-name');

        if (input.length) {
            $(this).hide();
            input.prop('disabled', false);
            input.focus().select();
        }
    });

    $(document).on('blur', 'input.section-name, input.discussion-name, input.sub-discussion-name', function() {
        let overlay = $(this).closest('.input-wrapper').find('.input-overlay');
        $(this).prop('disabled', true);
        overlay.show();
    });

    $(document).on('keydown', 'input.section-name, input.discussion-name, input.sub-discussion-name', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $(this).blur();
        }
    });
</script>
