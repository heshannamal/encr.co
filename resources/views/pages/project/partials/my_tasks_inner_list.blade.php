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

    .share_btn {
        color: #5e72e4;
        cursor: pointer;
    }

    #discussion_tbody .select2-container {
        max-width: 150px !important;
    }

    #discussion_tbody .select2-container--open .select2-dropdown--below {
        max-width: 150px !important;
    }

    td.align-content-center {
        border-right-style: none;
    }

    .my-task {
        position: relative;
        display: inline-flex;
        align-items: center;
        width: auto;
        flex: 1;
        min-width: 0;
    }

    .my-task-title.editing {
        border: 1px solid #bdbdbd !important;
        border-radius: 4px;
        padding: 2px 6px;
        background: #fff !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .my-task-title {
        width: 100%;
        background: transparent;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .my-task-title:disabled {
        cursor: pointer;
    }

    .my-task-title.editing {
        overflow: visible !important;
        text-overflow: unset !important;
        background: #fff !important;
        position: relative;
        z-index: 9999;
    }

    .task-input-overlay {
        position: absolute;
        inset: 0;
        cursor: pointer;
        background: transparent;
        color: transparent;
        overflow: hidden;
        user-select: none;
    }

    #my_tasks_table_wrapper .dataTables_filter {
        display: none !important;
    }

    #my_tasks_table_wrapper .dataTables_length {
        display: none !important;
    }

    #my_tasks_table_wrapper .dataTables_info {
        font-size: 0.75rem;
        color: #6c757d;
        padding-top: 12px;
    }
    .page-item .page-link, .page-item span {
        border-radius: 0 !important;
        font-size: 0.7rem;
    }
    .page-item.active .page-link {
        z-index: 1;
        color: grey;
        border-color: #cccccc;
        background-color: #e9e9e9;
        box-shadow:none;
    }
</style>

<div class="table-responsive">
    <table class="table table-bordered align-middle project-inner-table" id="my_tasks_table">
        <thead class="table-custom-dark">
            <tr>
                <th class="w-75">Name</th>

                <th style="width: 0px"></th>

                <th>Due Date</th>

                <th>Project</th>

                <th>Assigned By</th>

                <th></th>
            </tr>
        </thead>

        <tbody id="discussion_tbody">
        </tbody>
    </table>
</div>

<script>
    var userInfo = <?php echo json_encode($userInfo); ?>;
    var myProjects = <?php echo json_encode($myProjects); ?>;
    var myTasksDataTable = null;

    window.taskSortBy = window.taskSortBy || 'created_at';
    window.taskSortDir = window.taskSortDir || 'desc';

    $(document).ready(function () {
        initDatepickers();
        displayAllTasks();
        updateTaskSortIndicators();
    });

    function initDatepickers() {
        $('.datepicker').datepicker({
            minDate: 0
        });
    }

    function initMyTasksDataTable() {
    if ($.fn.DataTable.isDataTable('#my_tasks_table')) {
        $('#my_tasks_table').DataTable().clear().destroy();
    }

    var pageLength = parseInt($('#taskPerPageFilter').val() || 20);

    myTasksDataTable = $('#my_tasks_table').DataTable({
            paging: true,
            pageLength: pageLength,
            lengthChange: false,
            info: true,
            searching: false,
            ordering: true,
            autoWidth: false,
            destroy: true,
            retrieve: false,
            pagingType: 'simple_numbers',
            order: [],

            columnDefs: [
                {
                    // Name column - sort by input value
                    targets: 0,
                    orderable: true,
                    type: 'string',
                    render: function (data, type, row, meta) {
                        if (type === 'sort' || type === 'type' || type === 'filter') {
                            var inputValue = $(data).find('.my-task-title').val();

                            return inputValue ? inputValue.toLowerCase().trim() : '';
                        }

                        return data;
                    }
                },
                {
                    // Due Priority column - sort by priority
                    targets: 1,
                    orderable: true,
                    render: function(data, type) {

                        if (type === 'sort' || type === 'type') {

                            let html = $('<div>').html(data);

                            if (html.find('.critical').length) return 4;
                            if (html.find('.high').length) return 3;
                            if (html.find('.medium').length) return 2;
                            if (html.find('.low').length) return 1;

                            return 0;
                        }

                        return data;
                    }
                },
               {
                    targets: 2,
                    orderable: true,
                    render: function(data, type) {

                        if (type === 'sort' || type === 'type') {

                            var dateValue = $('<div>')
                                .html(data)
                                .find('input[type="date"]')
                                .val();

                            if (!dateValue) {
                                return '0000-00-00';
                            }

                            return dateValue; // YYYY-MM-DD format
                        }

                        return data;
                    }
                },
                {
                    // Project column - sort by visible project name
                    targets: 3,
                    orderable: true,
                    type: 'string',
                    render: function (data, type, row, meta) {
                        if (type === 'sort' || type === 'type' || type === 'filter') {
                            return $('<div>').html(data).text().replace(/\s+/g, ' ').trim().toLowerCase();
                        }

                        return data;
                    }
                },
                {
                    // Assigned By column - sort by user name
                    targets: 4,
                    orderable: true,
                    type: 'string',
                    render: function (data, type, row, meta) {
                        if (type === 'sort' || type === 'type' || type === 'filter') {
                            var userName = $(data).find('.text-gray').text();

                            return userName ? userName.trim().toLowerCase() : '';
                        }

                        return data;
                    }
                },
                {
                    // Action column - keep disabled
                    targets: 5,
                    orderable: false,
                    searchable: false
                }
            ],

            drawCallback: function () {
                initDatepickers();
                updateSelec2s();
                updateSubSelec2s();
            }
        });
    }

    $(document).on('change', '#taskPerPageFilter', function () {
        if (myTasksDataTable) {
            myTasksDataTable.page.len(parseInt($(this).val())).draw();
        }
    });

    function getMyTaskQuery() {
        var query = '';

        if (typeof buildTaskFilterQuery === 'function') {
            query = buildTaskFilterQuery({
                sort_by: window.taskSortBy,
                sort_dir: window.taskSortDir
            });
        } else {
            query = '?sort_by=' + encodeURIComponent(window.taskSortBy)
                + '&sort_dir=' + encodeURIComponent(window.taskSortDir);
        }

        return query;
    }

    function displayAllTasks()
    {
        var query = getMyTaskQuery();

        $.ajax({
            url: '{{ url("projects/get_my_all_tasks_list") }}' + query,
            method: 'GET',
            success: function(data) {               
                if ($.fn.DataTable.isDataTable('#my_tasks_table')) {
                    $('#my_tasks_table').DataTable().clear().destroy();
                    myTasksDataTable = null;
                }

                $('#discussion_tbody').html(data);

                initDatepickers();
                updateSelec2s();
                updateSubSelec2s();
                updateTaskSortIndicators();

                initMyTasksDataTable();
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

    function updateTaskSortIndicators() {
        $('.task-sort-indicator').text('↕');

        var indicator = window.taskSortDir === 'asc' ? '▲' : '▼';

        $('.task-sort-indicator[data-indicator-for="' + window.taskSortBy + '"]')
            .text(indicator);
    }

    $(document).on('click', '.task-sort', function() {
        var sortBy = $(this).data('sort-by');

        if (!sortBy) {
            return;
        }

        if (window.taskSortBy === sortBy) {
            window.taskSortDir = window.taskSortDir === 'asc' ? 'desc' : 'asc';
        } else {
            window.taskSortBy = sortBy;
            window.taskSortDir = 'asc';
        }

        updateTaskSortIndicators();
        displayAllTasks();
    });

    $(document).on('change', '#task_type, #assignee_id, #project_id, #priority, #status, .my-task-filter', function () {
        displayAllTasks();
    });

    $(document).on('keyup', '#task_search, .my-task-search', function () {
        clearTimeout(window.myTaskSearchTimer);

        window.myTaskSearchTimer = setTimeout(function () {
            displayAllTasks();
        }, 400);
    });

    $(document).on('click', '.filter_btn, #apply_task_filter, .apply-task-filter', function (e) {
        e.preventDefault();
        displayAllTasks();
    });

    $(document).on('click', '#reset_task_filter, .reset-task-filter', function (e) {
        e.preventDefault();

        $('#task_type').val('').trigger('change.select2');
        $('#assignee_id').val('').trigger('change.select2');
        $('#project_id').val('').trigger('change.select2');
        $('#priority').val('').trigger('change.select2');
        $('#status').val('').trigger('change.select2');
        $('#task_search').val('');

        $('.my-task-filter').val('').trigger('change.select2');
        $('.my-task-search').val('');

        window.taskSortBy = 'created_at';
        window.taskSortDir = 'desc';

        displayAllTasks();
    });

    $('body').on('change', '.discussion-check', function(){
        var discussion_id = $(this).val();
        var is_completed = $(this).prop('checked') == true ? 1 : 0;

        $.ajax({
            url: '{{ url("project_management_section_discussion/update") }}/' + discussion_id,
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

    $('body').on('change', '.sub-discussion-check', function(){
        var discussion_id = $(this).val();
        var is_completed = $(this).prop('checked') == true ? 1 : 0;

        $.ajax({
            url: '{{ url("project_management_section_sub_discussion/update") }}/' + discussion_id,
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

    $('body').on('change', '.discussion-name', function(){
        var input = $(this);
        var discussion_name = input.val();
        var discussion_id = input.data('discussion');

        if (discussion_name.length != 0) {
            $.ajax({
                url: '{{ url("project_management_section_discussion/update") }}/' + discussion_id,
                method: 'POST',
                data: {
                    discussion_name: discussion_name,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('.discussion-name-id-' + discussion_id).not(input).val(discussion_name);
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
                input.focus();
            });
        }
    });

    $('body').on('change', '.sub-discussion-name', function(){
        var input = $(this);
        var discussion_name = input.val();
        var discussion_id = input.data('discussion');

        if (discussion_name.length != 0) {
            $.ajax({
                url: '{{ url("project_management_section_sub_discussion/update") }}/' + discussion_id,
                method: 'POST',
                data: {
                    discussion_name: discussion_name,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('.sub-discussion-name-id-' + discussion_id).not(input).val(discussion_name);
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
                input.focus();
            });
        }
    });

    $('body').on('change', '.discussion-due-date', function(){
        var due_date = $(this).val();
        var discussion_id = $(this).data('discussion');

        $.ajax({
            url: '{{ url("project_management_section_discussion/update") }}/' + discussion_id,
            method: 'POST',
            data: {
                due_date: due_date,
                '_token': '{{ csrf_token() }}'
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

    $('body').on('change', '.sub-discussion-due-date', function(){
        var due_date = $(this).val();
        var discussion_id = $(this).data('discussion');

        $.ajax({
            url: '{{ url("project_management_section_sub_discussion/update") }}/' + discussion_id,
            method: 'POST',
            data: {
                due_date: due_date,
                '_token': '{{ csrf_token() }}'
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

    $('body').on('click', '.delete-discussion', function(){
        var discussion_id = $(this).data('discussion');

        Swal.fire({
            title: "Confirm Delete?",
            text: "Do You Want to Delete This Task?",
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
                    url: '{{ url("project_management_section_discussion/delete") }}/' + discussion_id,
                    method: 'GET',
                    success: function(data) {
                        deleteSectionDiscussion(discussion_id);
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

    $('body').on('click', '.delete-sub-discussion', function(){
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
                    url: '{{ url("project_management_section_sub_discussion/delete") }}/' + discussion_id,
                    method: 'GET',
                    success: function(data) {
                        deleteSectionSubDiscussion(discussion_id);
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

    function updateSelec2s()
    {
        $('.discussion-assignee-name').each(function () {
            if (!$(this).hasClass('select2-hidden-accessible')) {
                $(this).select2();
            }

            $(this).hide();
            $(this).next('.select2-container').hide();
        });
    }

    function updateSubSelec2s()
    {
        $('.sub-discussion-assignee-name').each(function () {
            if (!$(this).hasClass('select2-hidden-accessible')) {
                $(this).select2();
            }

            $(this).hide();
            $(this).next('.select2-container').hide();
        });
    }

    function deleteSectionDiscussion(discussionId)
    {
        $('#discussion_' + discussionId).fadeOut(300, function() {
            $(this).remove();

            if (myTasksDataTable) {
                myTasksDataTable.rows().invalidate().draw(false);
            }
        });

        $('#board_discussion_' + discussionId).fadeOut(300, function() {
            $(this).remove();
        });
    }

    function deleteSectionSubDiscussion(subDiscussionId)
    {
        $('#sub_discussion_' + subDiscussionId).fadeOut(300, function() {
            $(this).remove();

            if (myTasksDataTable) {
                myTasksDataTable.rows().invalidate().draw(false);
            }
        });
    }

    $(document).on('dblclick', '.task-input-overlay', function (e) {
        e.preventDefault();
        e.stopPropagation();

        let td = $(this).closest('.open-chatbox');
        td.data('dblclick-edit', true);

        let wrapper = $(this).closest('.input-wrapper');
        let input = wrapper.find('.my-task-title');

        $('.my-task-title')
            .prop('disabled', true)
            .removeClass('editing');

        $('.task-input-overlay').show();

        $(this).hide();

        input
            .prop('disabled', false)
            .addClass('editing')
            .focus();

        input[0].setSelectionRange(
            input.val().length,
            input.val().length
        );
    });

    $(document).on('blur', '.my-task-title', function () {
        $(this).trigger('change');

        let newVal = $(this).val();

        $(this)
            .prop('disabled', true)
            .removeClass('editing');

        $(this)
            .closest('.input-wrapper')
            .find('.task-input-overlay')
            .text(newVal)
            .show();
    });

    $(document).on('keydown', '.my-task-title', function (e) {
        if(e.key === 'Enter'){
            e.preventDefault();
            $(this).blur();
        }
    });
</script>
