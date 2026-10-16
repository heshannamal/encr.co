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
    
<div class="col-md-12 tab-container">
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
</div>

<div class="col-md-12 tab-container mt-3 pt-3">
    <div class="container bootstrap snippets bootdeys">
        <div class="col-md-12">
            <div class="timeline-centered timeline-sm">
                <article class="timeline-entry">
                    <div class="timeline-entry-inner">
                        <div class="timeline-icon bg-offwhite"><i class="far fa-clock"></i></div>

                        <div class="timeline-label bg-offwhite">
                            <div class="custom-control custom-checkbox timeline-checkbox">
                                <input type="checkbox" class="custom-control-input" id="task_title" name="task_title[]" title="Task">
                                <label class="custom-control-label" for="task_title"><b>Task</b></label>
                            </div>

                            <p class="timeline-sub-title">
                                <span class="text-danger">January 12</span>
                                &nbsp; - &nbsp;James Barker&nbsp;
                                <i class="fas fa-user-tie"></i> Jason Benoit&nbsp;
                                <i class="fas fa-city"></i> Motor City Knights Lacrosse&nbsp;
                            </p>
                        </div>
                    </div>

                    <div class="timeline-entry-inner">
                        <div style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);" class="timeline-icon"><i class="fa fa-plus"></i></div>
                    </div>  
                </article>
            </div>
        </div>
    </div>
</div>
    
<script>
    function openTab(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>