<style>
    .calendar-container {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        isolation: isolate;
        position: relative;
        z-index: 0;
    }

    /* Ensure sticky navbar always sits above FullCalendar on mobile scroll */
    .fix-nav.header-layout {
        z-index: 1000 !important;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
    }

    .calendar-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
    }

    .calendar-controls {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .calendar-filter {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #fff;
        font-size: 14px;
    }

    .filter-btn {
        padding: 8px 16px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.2s;
    }

    .filter-btn:hover {
        background: #0056b3;
    }

    .fc-event {
        cursor: pointer;
        border-radius: 6px;
        padding: 4px 6px;
        font-size: 12px;
        font-weight: 500;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }

    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .fc-event.completed {
        background-color: #adb5bd !important;
        border-color: #868e96 !important;
        color: #1f2937 !important;
    }

    .fc-event.pending {
        background-color: #28a745 !important;
        border-color: #1e7e34 !important;
        color: #ffffff !important;
    }

    .fc-event.overdue {
        background-color: #dc3545 !important;
        border-color: #b02a37 !important;
        color: #ffffff !important;
    }

    .task-modal .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .task-modal .modal-title {
        color: #333;
        font-weight: 600;
    }

    .task-info {
        margin-bottom: 15px;
    }

    .task-info-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 5px;
    }

    .task-info-value {
        color: #333;
        margin-bottom: 10px;
    }

    .task-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
    }

    .task-status.completed {
        background: #d4edda;
        color: #155724;
    }

    .task-status.pending {
        background: #d1ecf1;
        color: #0c5460;
    }

    .task-status.overdue {
        background: #f8d7da;
        color: #721c24;
    }

    .calendar-legend {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        border: 2px solid #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .legend-text {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
    }
    /* Ensure modal appears above other UI */
    .modal {
        z-index: 2000;
    }
    .modal-backdrop {
        z-index: 1990;
    }

    @media (max-width: 767.98px) {
        .fc-header-toolbar {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            grid-template-rows: auto auto !important;
            gap: 12px !important;
            align-items: center !important;
            margin-bottom: 15px !important;
            position: relative !important;
            z-index: 0 !important;
        }
        
        .fc-header-toolbar .fc-toolbar-chunk:nth-child(2) {
            grid-column: 1 / span 2 !important;
            grid-row: 1 !important;
            display: flex !important;
            justify-content: center !important;
            order: 1 !important;
            z-index: 0 !important;
        }
        
        .fc-header-toolbar .fc-toolbar-chunk:nth-child(1) {
            grid-column: 1 !important;
            grid-row: 2 !important;
            display: flex !important;
            justify-content: flex-start !important;
            order: 2 !important;
            z-index: 0 !important;
        }
        
        .fc-header-toolbar .fc-toolbar-chunk:nth-child(3) {
            grid-column: 2 !important;
            grid-row: 2 !important;
            display: flex !important;
            justify-content: flex-end !important;
            order: 3 !important;
            z-index: 0 !important;
        }

        .fc-header-toolbar .fc-toolbar-title {
            font-size: 1.3rem !important;
            font-weight: 700 !important;
            text-align: center !important;
            margin: 0 !important;
        }

        .fc-header-toolbar .fc-button,
        .fc-header-toolbar .fc-button-group {
            padding: 6px 10px !important;
            font-size: 12px !important;
            line-height: 1.5 !important;
            position: relative !important;
            z-index: 0 !important;
        }
    }
</style>

<div class="calendar-container">
    {{-- <div class="calendar-header">
        <div class="calendar-title">My Tasks Calendar</div>
        <div class="calendar-controls">
            <button class="btn btn-outline-secondary btn-sm" id="today-btn">Today</button>
            <button class="btn btn-outline-secondary btn-sm" id="prev-btn">Previous</button>
            <button class="btn btn-outline-secondary btn-sm" id="next-btn">Next</button>
        </div>
    </div>

    <div class="calendar-filter">
        <select class="filter-select" id="task-type-filter">
            <option value="">All Tasks</option>
            <option value="upcoming">Upcoming</option>
            <option value="overdue">Overdue</option>
            <option value="completed">Completed</option>
        </select>

        <select class="filter-select" id="date-range-filter">
            <option value="">All Time</option>
            <option value="day">Today</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
        </select>

        <button class="filter-btn" id="apply-filters">Apply Filters</button>
    </div>

    <!-- Calendar Legend -->
    <div class="calendar-legend mb-3">
        <div class="d-flex align-items-center gap-3">
            <span class="legend-item">
                <span class="legend-color" style="background-color: #007bff;"></span>
                <span class="legend-text">Pending Tasks</span>
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #dc3545;"></span>
                <span class="legend-text">Overdue Tasks</span>
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #28a745;"></span>
                <span class="legend-text">Completed Tasks</span>
            </span>
        </div>
    </div> --}}

    <div id="calendar"></div>

    <!-- Loading indicator -->
    {{-- <div id="calendar-loading" class="text-center py-4" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Loading calendar events...</p>
    </div> --}}

    <!-- No events message -->
    {{-- <div id="calendar-no-events" class="text-center py-4" style="display: none;">
        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
        <p class="text-muted">No tasks found for the selected period.</p>
    </div> --}}
</div>

<!-- Task Details Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content task-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Task Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="taskModalBody">
                <h1>Example</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="toggleTaskStatus">Toggle Status</button>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar CSS and JS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<script>
let calendar; // Declare calendar in global scope
$(document).ready(function() {
    let currentFilters = {
        task_type: '',
        date_range: ''
    };

    // $('#taskModal').modal('show');

    // Initialize FullCalendar
    window.initializeMyTasksCalendar = function() {
        if (calendar) return; // Prevent multiple initializations

        const calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'title',
                right: 'prev,next'
            },
            height: 'auto',
            editable: false,
            selectable: true,
            selectMirror: true,
            dayMaxEvents: 3,
            weekends: true,
            firstDay: 1, // Start week on Monday
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5], // Monday - Friday
                startTime: '09:00',
                endTime: '17:00',
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                loadCalendarEvents(fetchInfo, successCallback, failureCallback);
            },
            eventClick: function(info) {
                // showTaskDetails(info.event);
            },
            eventDidMount: function(info) {
                // Ensure chatbox trigger class and data attribute are on the DOM element
                info.el.classList.add('open-chatbox');
                info.el.setAttribute('data-value', info.event.id);
                info.el.setAttribute('data-discussion-type', info.event.extendedProps.discussion_type || 'discussion');

                // Add custom styling based on task status
                const status = info.event.extendedProps.status || (info.event.extendedProps.completed ? 'completed' : 'pending');
                info.el.classList.add(status);

                if (info.event.backgroundColor) {
                    info.el.style.backgroundColor = info.event.backgroundColor;
                }
                if (info.event.borderColor) {
                    info.el.style.borderColor = info.event.borderColor;
                }
                if (info.event.textColor) {
                    info.el.style.color = info.event.textColor;
                }
            }
        });

        calendar.render();
    }

    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        if (calendar) {
            calendar.render();
        }
    });

    // Load calendar events
    function loadCalendarEvents(fetchInfo, successCallback, failureCallback) {
        // Show loading state
        $('#calendar-loading').fadeIn();
        $('#calendar-no-events').hide();

        // Get filter values from the main filter dropdowns
        let query = buildTaskFilterQuery({
            start: fetchInfo.startStr,
            end: fetchInfo.endStr
        });

        fetch(`{{ url('projects/get_my_task_calendar')}}${query}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {

                // Hide loading state
                $('#calendar-loading').fadeOut();

                if (!Array.isArray(data)) {
                    console.error('Invalid data format received:', data);
                    successCallback([]);
                    return;
                }

                const events = data.map(task => {
                    // Handle tasks without due dates
                    if (!task.start) {
                        return null; // Skip tasks without due dates
                    }

                    const dueDate = new Date(task.start);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const completed = task.completed === 1 || task.completed === '1' || task.completed === true;

                    let status = 'pending';
                    if (completed) {
                        status = 'completed';
                    } else if (dueDate < today) {
                        status = 'overdue';
                    }

                    const statusColors = {
                        completed: { backgroundColor: '#adb5bd', borderColor: '#868e96', textColor: '#1f2937' },
                        pending: { backgroundColor: '#28a745', borderColor: '#1e7e34', textColor: '#ffffff' },
                        overdue: { backgroundColor: '#dc3545', borderColor: '#b02a37', textColor: '#ffffff' }
                    };

                    const colors = statusColors[status];

                    return {
                        id: task.id,
                        title: task.title,
                        start: task.start,
                        end: task.start,
                        className: 'open-chatbox',
                        description: task.description,
                        completed: task.completed,
                        section_name: task.section_name,
                        project_name: task.project_name,
                        status: status,
                        backgroundColor: colors.backgroundColor,
                        borderColor: colors.borderColor,
                        textColor: colors.textColor,
                        extendedProps: {
                            description: task.description,
                            completed: task.completed,
                            section_name: task.section_name,
                            project_name: task.project_name,
                            status: status,
                            'data-value': task.id,
                            'data-discussion-type': task.discussion_type || 'discussion',
                            discussion_type: task.discussion_type || 'discussion'
                        }
                    };
                }).filter(event => event !== null); // Remove null events

                // Show no events message if no events found
                if (events.length === 0) {
                    $('#calendar-no-events').fadeIn();
                } else {
                    $('#calendar-no-events').fadeOut();
                }

                successCallback(events);
            })
            .catch(error => {
                // Hide loading state
                $('#calendar-loading').fadeOut();

                console.error('Error loading calendar events:', error);
                showAlert('error', 'Failed to load calendar events. Please try again.');
                failureCallback(error);
            });
    }

    // Show task details modal
    function showTaskDetails(event) {
        const task = event.extendedProps;
        const dueDate = new Date(event.start);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const completed = task.completed === 1 || task.completed === '1' || task.completed === true;
        let statusClass = 'pending';
        let statusText = 'Pending';

        if (completed) {
            statusClass = 'completed';
            statusText = 'Completed';
        } else if (dueDate < today) {
            statusClass = 'overdue';
            statusText = 'Overdue';
        }

        const modalId = `taskModal_${event.id}_${Date.now()}`; // unique ID for each modal

        // Create a new modal element
        const modalHtml = `
        <div class="modal fade event_modal" id="${modalId}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content task-modal">
            <div class="modal-header">
                <h5 class="modal-title">Task Details</h5>
                <button type="button" class="close" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <div class="task-info">
                <div><strong>Task Name:</strong> ${event.title}</div>
                <div><strong>Description:</strong> ${task.description || 'No description available'}</div>
                <div><strong>Project:</strong> ${task.project_name}</div>
                <div><strong>Section:</strong> ${task.section_name}</div>
                <div><strong>Due Date:</strong> ${dueDate.toLocaleDateString()}</div>
                <div><strong>Status:</strong> <span class="task-status ${statusClass}">${statusText}</span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="toggleStatusBtn_${event.id}">Toggle Status</button>
            </div>
            </div>
        </div>
        </div>
        `;

        $('body').append(modalHtml);

        const modalEl = document.getElementById(modalId);
        const bootstrapModal = new bootstrap.Modal(modalEl);
        bootstrapModal.show();

        // Close button
        modalEl.querySelector('.close').addEventListener('click', () => bootstrapModal.hide());

        // Remove modal from DOM after hidden
        modalEl.addEventListener('hidden.bs.modal', () => modalEl.remove());


        // Set up toggle status button
        $(`#toggleStatusBtn_${event.id}`).on('click', function() {
            toggleTaskStatus(event.id, !task.completed, bootstrapModal, modalEl);
        });

        // Remove modal from DOM after hidden to avoid clutter
        modalEl.addEventListener('hidden.bs.modal', function() {
            modalEl.remove();
        });
    }


    // Toggle task completion status
    function toggleTaskStatus(taskId, newStatus) {

        fetch(`/projects/change-my-task-status/${taskId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                is_completed: newStatus ? 1 : 0
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.response === 'success') {
                // Refresh calendar
                calendar.refetchEvents();

                // Hide modal using jQuery
                $('#taskModal').modal('hide');

                // Show success message
                showAlert('success', data.message);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error updating task status:', error);
            showAlert('error', 'An error occurred while updating the task status.');
        });
    }

    // Show alert message
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

        // Insert alert at the top of the calendar container
        const calendarContainer = document.querySelector('.calendar-container');
        calendarContainer.insertAdjacentHTML('afterbegin', alertHtml);

        // Auto-remove alert after 5 seconds
        setTimeout(() => {
            const alert = calendarContainer.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }

    // Calendar navigation
    $('#today-btn').on('click', function() {
        calendar.today();
    });

    $('#prev-btn').on('click', function() {
        calendar.prev();
    });

    $('#next-btn').on('click', function() {
        calendar.next();
    });

    // Filter handling
    $('#apply-filters').on('click', function() {
        currentFilters.task_type = $('#task-type-filter').val();
        currentFilters.date_range = $('#date-range-filter').val();

        calendar.refetchEvents();
    });

    // Initialize calendar
    // initializeCalendar(); // Deferred to tab click
});

</script>
