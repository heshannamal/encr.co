<style>
    .dropdown-menu-custom {
        /* left: 45% !important; */
        transform: translateX(-30%);
        width: 230% !important;
        max-height: 60vh;
        border-radius: 0rem;
    }
    .custom-tabs {
    display: flex;
    }

    .custom-tab-bar {
        flex: 0 0 auto;
        min-height: 60vh;
        border: none;
        background-color: rgb(247, 247, 247);
    }

    .custom-tab {
        display: block;
        padding: 0.8rem 3rem 0.8rem 0.8rem;
        text-decoration: none;
        color: #333;
        border: none;
        font-size: .8rem;
    }

    .custom-tab:hover {
        background-color: #0f101029;
        color: black;
    }
    .custom-tab.active{
        background-color: #d7eddd;
        color: #4c91e9;
    }

    .custom-tab-content {
        flex: 1 1 auto;
    }

    .custom-tab-pane {
        display: none;
    }

    .custom-tab-pane.active {
        display: block;
    }
    .peoples-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        margin-right: -8px;
        box-shadow: 0 0 0 1px #bbb;
    }
    .peoples-avatar-group {
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }
    .peoples-avatar-group .peoples-avatar {
        border: 2px solid #fff;
        margin-left: -3px;
    }

    .comment-row {
        gap: 14px;   
    }

    .comment-item {
        padding: 14px 16px;
        border: none;
        border-bottom: 1px solid #eee;
         margin-top: 2px;
    }

    .comment-icon {
        min-width: 32px;
        height: 32px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;
        background: #f4f6f8;
        color: #555;
    }

    .comment-icon i {
        font-size: 15px;
    }

    .comment-text {
        max-width: 100%;
        padding-top: 1px; 
    }

    .comment-text span {
        font-size: 0.95rem;
        font-weight: 500;
        color: #222;
        line-height: 1.5;
        display: inline-block;
        line-height: 1.6;
    }

    /* Hover UX */
    .comment-item:hover {
        background: #f9fafb;
    }

    .comment-item:hover .comment-icon {
        background: #e9ecef;
    }

    .advance-search {
        width: 100%;
        max-width: 420px;   /* 👈 controls size */
    }

    .input-group-alternative {
        border: 1px solid #b3b3b3;
        border-radius: 8px;
        padding-right: 6px;
    }

    .comment-text img {
        max-width: 30rem !important;
    }
    
@media (max-width: 767.98px) {
    .dropdown-menu-custom {
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        right: 0 !important;
        transform: none !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 8px 0 0 0 !important;
        border-radius: 16px !important;
        height: auto !important;
        max-height: 65vh !important;
        overflow: hidden !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        border: 1px solid #eef2f5 !important;
        background: #fff !important;
    }

    .dropdown-menu-custom .custom-tabs {
        flex-direction: column !important;
        height: 100% !important;
        max-height: 65vh !important;
        align-items: stretch !important;
    }

    .dropdown-menu-custom .custom-tab-bar {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        overflow-y: hidden !important;
        height: auto !important;
        min-height: auto !important;
        background-color: #fff !important;
        border-bottom: 1px solid #f1f3f5 !important;
        padding: 10px 12px !important;
        gap: 8px !important;
        -webkit-overflow-scrolling: touch;
    }

    /* Hide horizontal scrollbar but keep functionality */
    .dropdown-menu-custom .custom-tab-bar::-webkit-scrollbar {
        display: none;
    }

    .dropdown-menu-custom .custom-tab {
        display: inline-block !important;
        padding: 6px 14px !important;
        border-radius: 20px !important;
        font-size: 0.8rem !important;
        background-color: #f1f3f5 !important;
        color: #5c6873 !important;
        white-space: nowrap !important;
        border: none !important;
        transition: all 0.2s ease;
    }

    .dropdown-menu-custom .custom-tab i {
        display: none !important;
    }

    .dropdown-menu-custom .custom-tab.active {
        background-color: #e3faf2 !important;
        color: #0ca678 !important;
        font-weight: 600 !important;
    }

    /* Fix text truncation, wrapping, overflow and page scrolling on iOS */
    .dropdown-menu-custom * {
        max-width: 100%;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    .dropdown-menu-custom .list-group-item {
        word-break: break-word;
        overflow-wrap: break-word;
        white-space: normal !important;
    }

    .dropdown-menu-custom .comment-text span,
    .dropdown-menu-custom .heading-link,
    .dropdown-menu-custom small {
        white-space: normal !important;
        word-break: break-word;
        overflow-wrap: break-word;
        display: inline-block;
        max-width: 100%;
    }

    .dropdown-menu-custom .custom-tab-content {
        flex: 1 1 auto !important;
        overflow-y: auto !important;
        max-height: calc(65vh - 55px) !important;
        -webkit-overflow-scrolling: touch;
    }

    .dropdown-menu-custom .list-group {
        max-height: calc(65vh - 55px) !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch;
    }

    .dropdown-menu-custom .custom-tab-pane.active {
        height: auto !important;
        overflow: hidden !important;
    }
    
    /* Prevent iOS Safari from auto-zooming on focus */
    input[type="text"],
    input[type="number"],
    input[type="search"],
    input[type="email"],
    input[type="password"],
    input[type="tel"],
    input[type="url"],
    select,
    textarea,
    .form-control,
    .select2-selection,
    .select2-search__field,
    .select2-search input,
    .advance-search #search_input_text,
    .advance-search .form-control {
        font-size: 16px !important;
    }

}
</style>
<div class="advance-search">
    <div class="input-group input-group-alternative" style="border: 1px solid #b3b3b3; padding-right: 5px;">
        <div class="input-group-prepend">
            <span class="input-group-text" style="background-color: transparent;"><i class="ni ni-zoom-split-in"></i></span>
        </div>
        <input class="form-control" placeholder="Search by project name" type="text" id="search_input_text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <!-- Dropdown menu -->
        <div class="dropdown-menu dropdown-menu-custom mt-3" aria-labelledby="search_input_text" style="padding: 0px">
            <div class="custom-tabs">
                <div class="custom-tab-bar">
                    <a href="javascript:void(0);" class="custom-tab active" data-tab="all-tab-content">
                        <i class="fas fa-list"></i>&nbsp; All
                    </a>
                    <a href="javascript:void(0);" class="custom-tab" data-tab="project-tab-content">
                        <i class="fa-regular fa-copy"></i>&nbsp; Projects
                    </a>
                    <a href="javascript:void(0);" class="custom-tab" data-tab="task-tab-content">
                        <i class="fas fa-tasks"></i>&nbsp; Tasks
                    </a>
                    <a href="javascript:void(0);" class="custom-tab" data-tab="comment-tab-content">
                       <i class="fa-regular fa-comment"></i>&nbsp; Comments
                    </a>
                    <a href="javascript:void(0);" class="custom-tab" data-tab="peoples-tab-content">
                        <i class="fas fa-users"></i>&nbsp; Peoples
                    </a>
                </div>
                <div class="custom-tab-content">
                    <div class="custom-tab-pane active" id="all-tab-content">
                        <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                            <ul class="list-group list-group-flush search-result-list-ul" id="all-list-ul">
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                    <div class="text-center mt-8">
                                        <div class="spinner-border" role="status">
                                            <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;Searching Results...</span>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="custom-tab-pane" id="project-tab-content">
                        <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                            <ul class="list-group list-group-flush search-result-list-ul" id="project-list-ul">
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                    <div class="text-center mt-8">
                                        <div class="spinner-border" role="status">
                                            <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;Searching Results...</span>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="custom-tab-pane" id="task-tab-content">
                        <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                            <ul class="list-group list-group-flush search-result-list-ul" id="task-list-ul">
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                    <div class="text-center mt-8">
                                        <div class="spinner-border" role="status">
                                            <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;Searching Results...</span>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="custom-tab-pane" id="comment-tab-content">
                        <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                            <ul class="list-group list-group-flush search-result-list-ul" id="comment-list-ul">
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                    <div class="text-center mt-8">
                                        <div class="spinner-border" role="status">
                                            <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;Searching Results...</span>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="custom-tab-pane" id="peoples-tab-content">
                        <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                            <ul class="list-group list-group-flush search-result-list-ul" id="peoples-list-ul">
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                    <div class="text-center mt-8">
                                        <div class="spinner-border" role="status">
                                            <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;Searching Results...</span>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready( function(){
        $(".custom-tab").click(function(event) {
            event.preventDefault();
            var targetTabId = $(this).data("tab");
            var targetTab = $("#" + targetTabId);
            if (!targetTab.hasClass("active")) {
                $(".custom-tab-pane").removeClass("active");
                targetTab.addClass("active");
                $(".custom-tab").removeClass("active");
                $(this).addClass("active");
            }
        });
    });

    $(document).click(function(event) {
        var dropdownMenu = $('.dropdown-menu-custom');
        var searchInput = $('#search_input_text');
        if (!dropdownMenu.is(event.target) && dropdownMenu.has(event.target).length === 0 && !searchInput.is(event.target)) {
            dropdownMenu.removeClass('show');
        }
    });


    $('#search_input_text').focus(function() {
        $('.dropdown-menu-custom').addClass('show');
    });

    const no_result_found_content = `<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                        <div class="text-center mt-8">
                                            <div class="spinner-border" role="status">
                                                <span>No result found...</span>
                                            </div>
                                        </div>
                                    </div>`;

    let searchTimeout;
    $('#search_input_text').on('keyup', function() {
        var input_text = $(this).val();
        console.log(input_text);
        

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function () {
            if(input_text != '' && input_text.length > 2){
                $.ajax({
                    url: '{{ url("projects/filter_search_data") }}',
                    type: "GET",
                    dataType: 'json',
                    data: {
                        'input_text': input_text
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        var project_content = '';
                        var task_content = '';
                        var comment_content = '';
                        var people_content = '';

                        if(data[0].length > 0){
                            data[0].forEach(element => {
                                var ProjectId = element.id;
                                var route = '{{ route("projects.view", ['id' => ':id']) }}';
                                var url = route.replace(':id', ProjectId);
                                var project_description = '';
                                if(element.project_description != null && element.project_description != ''){
                                    project_description = ` - ${element.project_description}`;
                                }

                                project_content +=
                                                    `<li class="list-group-item d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa-regular fa-copy fa-lg mr-3" style="color: black;"></i>
                                                            <div>
                                                                <a href="${url}" target="blank" class="mb-1 heading-link activity-edit" data-activiy_id="${element.id}"  style="font-size: 1rem;color: black;font-weight: 500;">${element.project_name}</a><br>
                                                                <small>${element.project_no}${project_description}</small>
                                                            </div>
                                                        </div>
                                                    </li>`;
                            });
                        }else{
                            var project_content = no_result_found_content;
                        }

                        if(data[1].length > 0){
                            data[1].forEach(element => {
                                // var ProjectId = element.id;
                                // var route = '{{ route("projects.view", ['id' => ':id']) }}';
                                // var url = route.replace(':id', ProjectId);
                                var task_description = '';
                                if(element.discussion_description != null && element.discussion_description != ''){
                                    task_description = `<small>${element.discussion_description}</small>`;
                                }

                                task_content +=
                                                    `<li class="list-group-item d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-tasks fa-lg mr-3" style="color: black;"></i>
                                                            <div class="open-chatbox pointer" data-discussion-type="${element.discussion_type}" data-value="${element.id}">
                                                                <span class="mb-1 heading-link activity-edit" data-activiy_id="${element.id}"  style="font-size: 1rem;color: black;font-weight: 500;">${element.discussion_name}</span><br>
                                                                ${task_description}
                                                            </div>
                                                        </div>
                                                    </li>`;
                            });
                        }else{
                            var task_content = no_result_found_content;
                        }

                        if(data[2].length > 0){
                            data[2].forEach(element => {
                                if(element.is_sub_discussion == 1){
                                    var discussion_data = element.sub_discussion_info;
                                } else {
                                    var discussion_data = element.discussion_info;
                                }
                                // var ProjectId = element.id;
                                // var route = '{{ route("projects.view", ['id' => ':id']) }}';
                                // var url = route.replace(':id', ProjectId);

                                comment_content += `
                                                    <li class="list-group-item comment-item">
                                                        <div class="d-flex align-items-start comment-row">
                                                            <div class="comment-icon">
                                                                <i class="fa-regular fa-comment-dots"></i>
                                                            </div>

                                                            <div class="comment-text open-chatbox pointer"
                                                                data-discussion-type="${discussion_data.discussion_type}"
                                                                data-value="${discussion_data.id}">
                                                                <span class="heading-link activity-edit"
                                                                    data-activiy_id="${element.id}">
                                                                    ${element.comment}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </li>`;
                            });
                        }else{
                            var comment_content = no_result_found_content;
                        }

                        if(data[3].length > 0){
                            data[3].forEach(element => {
                                var peopleId = element.id;
                                var route = '{{ route('people.info', ['id' => ':id']) }}';
                                var url = route.replace(':id', peopleId);

                                var person_name = (element.name ? element.name : '');

                                var person_email = (element.email ? element.email : '');

                                var line1 = (person_email) ? `<small>${person_email}</small>` : '';

                                people_content +=
                                                `<li class="list-group-item d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="peoples-avatar-group mr-3">
                                                            <img src="${element.profile_pic_url}" class="peoples-avatar">
                                                        </div>
                                                        <div style="display: grid;line-height: normal;">
                                                            <a href="${url}" target="blank" class="heading-link" style="font-size: 1rem;color: black;font-weight: 500;">${person_name}</a>
                                                            ${line1}
                                                        </div>
                                                    </div>
                                                </li>`;
                            });
                        }else{
                            var people_content = no_result_found_content;
                        }

                        var highlighted_project_content = highlightSearchText(project_content, data[4]);
                        $('#project-list-ul').html(highlighted_project_content);

                        var highlighted_task_content = highlightSearchText(task_content, data[4]);
                        $('#task-list-ul').html(highlighted_task_content);

                        var highlighted_comment_content = highlightSearchText(comment_content, data[4]);
                        $('#comment-list-ul').html(highlighted_comment_content);

                        var highlighted_people_content = highlightSearchText(people_content, data[4]);
                        $('#peoples-list-ul').html(highlighted_people_content);

                        // Build the All tab content by concatenating non-empty sections
                        var allSections = [];
                        
                        if (data[0].length > 0) { allSections.push(highlighted_project_content); }
                        if (data[1].length > 0) { allSections.push(highlighted_task_content); }
                        if (data[2].length > 0) { allSections.push(highlighted_comment_content); }
                        if (data[3].length > 0) { allSections.push(highlighted_people_content); }

                        if (allSections.length > 0) {
                            $('#all-list-ul').html(allSections.join(''));
                        } else {
                            // If no results in any section, show all placeholders
                            // $('#all-list-ul').html(highlighted_project_content + highlighted_task_content + highlighted_comment_content + highlighted_people_content);
                            $('#all-list-ul').html(no_result_found_content);
                        }
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            } else {
                $('.search-result-list-ul').html(no_result_found_content);
            }
        }, 500);
    });

    function highlightSearchText(content, searchText) {
        var escapedSearchText = searchText.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        // Regular expression to exclude matches within attribute values
        var regex = new RegExp(`(?!<a[^>]*?>)(?![^<]*?(?:"|'))(${escapedSearchText})(?![^<]*?<\/a>)`, 'gi');
        var highlightedContent = content.replace(regex, '<span class="highlight">$1</span>');
        return highlightedContent;
    }
</script>
