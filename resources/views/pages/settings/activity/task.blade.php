<style>
    .tab-container {
        border-radius: 6px;
        box-shadow: 0px 2px 6px #0000002e
    }
    .tab {
        overflow: hidden;
        background-color: #ffffff;
    }
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 8px 18px;
        transition: 0.3s;
        font-size: 12px;
        color: #989898;
        border-bottom: 2px solid transparent;
    }
    .tab button.task-tab {
        padding: 0.4rem 0.95rem;
    }
    .tab button:hover {
        background-color: #dbe6fd;
        border-bottom: 2px solid #457bdb;
    }
    .tab button.active {
        background-color: #f1f5fe;
        color: #457bdb;
        border-bottom: 2px solid #457bdb;
    }
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border-top: 1px solid #ccc;
    }
    .tab-input {
        border: none;
        border-bottom: 1px solid #cad1d7;
    }
</style>

{{-- <div class="col-md-12 tab-container">
    <div class="tab">
        <button type="button" class="tablinks active" onclick="openTab(event, 'tab_notes')"><i class="fas fa-sticky-note"></i>&nbsp; Notes</button>
        <button type="button" class="tablinks" onclick="openTab(event, 'tab_activity')"><i class="far fa-calendar-alt"></i>&nbsp; Activity</button>
        <button type="button" class="tablinks" onclick="openTab(event, 'tab_email')"><i class="fas fa-envelope"></i>&nbsp; Email</button>
        <button type="button" class="tablinks" onclick="openTab(event, 'tab_files')"><i class="fas fa-paperclip"></i>&nbsp; Files</button>
        <button type="button" class="tablinks" onclick="openTab(event, 'tab_documents')"><i class="fas fa-file-alt"></i>&nbsp; Documents</button>
        <button type="button" class="tablinks" onclick="openTab(event, 'tab_invoice')"><i class="fas fa-receipt"></i>&nbsp; Invoice</button>
    </div>

    <div id="tab_notes" class="tabcontent" style="display: block;">
        <input type="text" class="form-control tab-input mt-3" placeholder="Take a note, &#64;name..." />
    </div>

    <div id="tab_activity" class="tabcontent">
        <input type="text" class="form-control tab-input mt-3" placeholder="Add a Activity, &#64;name..." />
    </div>

    <div id="tab_email" class="tabcontent">
        <input type="text" class="form-control tab-input mt-3" placeholder="Add a Email, &#64;name..." />
    </div>

    <div id="tab_files" class="tabcontent">
        <input type="text" class="form-control tab-input mt-3" placeholder="Add a Files, &#64;name..." />
    </div>

    <div id="tab_documents" class="tabcontent">
        <input type="text" class="form-control tab-input mt-3" placeholder="Add a Documents, &#64;name..." />
    </div>

    <div id="tab_invoice" class="tabcontent">
        <input type="text" class="form-control tab-input mt-3" placeholder="Add a Invoice, &#64;name..." />
    </div>
</div> --}}

<div class="col-md-12 tab-container pt-3">
    {{-- <div class="col-md-12 text-center">
        <div class="row">
            <p class="task-main-filters">DONE</p>
        </div>
    </div>

    <div class="tab mb-3 task-filters">
        <button type="button" class="task-tab active" onclick="openTaskTab(event, 'task_tab_all')">All</button>
        <button type="button" class="task-tab" onclick="openTaskTab(event, 'task_tab_activities')">Activities</button>
        <button type="button" class="task-tab" onclick="openTaskTab(event, 'task_tab_notes')">Notes</button>
        <button type="button" class="task-tab" onclick="openTaskTab(event, 'task_tab_emails')">Emails</button>
        <button type="button" class="task-tab" onclick="openTaskTab(event, 'task_tab_invoices')">Invoices</button>
        <button type="button" class="task-tab" onclick="openTaskTab(event, 'task_tab_documents')">Documents</button>
        <button type="button" class="task-tab" onclick="openTaskTab(event, 'task_tab_files')">Files</button>
        <button type="button" class="task-tab" onclick="openTaskTab(event, 'task_tab_changelog')">Changelog</button>
    </div> --}}

    <div class="container bootstrap snippets bootdeys">

        <div class="col-md-12">
            <div class="timeline-centered timeline-sm">
                <article class="timeline-entry">

                    @foreach ($activities as $activity)
                        <div class="timeline-entry-inner mb-2">
                            <div class="timeline-icon bg-offwhite"><i class="far fa-clock"></i></div>

                            <div class="timeline-label bg-offwhite">
                                <div class="custom-control custom-checkbox timeline-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="task_{{$activity->id}}" name="task[{{$activity->id}}][selected]" title="Task" />
                                    <label class="custom-control-label" for="task_{{$activity->id}}"><b>Task</b></label>

                                    <button class="btn btn-sm btn-round btn-secondary btn-icon float-right"><i class="fas fa-ellipsis-h"></i></button>
                                </div>

                                <p class="timeline-sub-title mb-2">
                                    <span class="text-danger task-date">{{$activity->start_date}}</span>&nbsp;&nbsp;-&nbsp;&nbsp;{{$activity->userDetails['name']}}&nbsp;

                                    @if ($activity->user_id)
                                        <i class="fas fa-user-tie"></i> {{$activity->assigneeDetails['name']}}&nbsp;
                                    @endif

                                    @if ($activity->organization_id)
                                        <i class="fas fa-city"></i> {{$activity->organizationDetails['organization_name']}}&nbsp;
                                    @endif
                                </p>

                                <div>
                                    <textarea class="form-control task-comments" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="timeline-entry-inner">
                        <div style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);" class="timeline-icon"><i class="fa fa-plus"></i></div>
                    </div>

                </article>
            </div>
        </div>
    </div>
</div>

<script>
    $('.task-tab').on('click', function(){
        $(this).addClass('active');
    });

    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function openTaskTab(evt, taskTabName) {
        var i, tablinks;
        tablinks = document.getElementsByClassName("task-tab");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        evt.currentTarget.className += " active";
    }
</script>

