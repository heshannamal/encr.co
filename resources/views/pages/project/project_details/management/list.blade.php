<style>
    ::-webkit-scrollbar {
        width: 0px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb {
        background: #d2d2d2;
        border-radius: 25px;
        transition: 0.4s;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    .accordion-header {
        width: 100%;
        border-bottom: 1px solid #d2d2d2;
    }
    .accordion {
        background-color: transparent;
        color: #444;
        cursor: pointer;
        padding: 10px 10px 0px;
        border: none;
        text-align: left;
        outline: none;
        font-size: 16px;
        transition: 0.4s;
    }
    .accordion:focus {
        outline: none;
    }
    .panel {
        padding: 0px 18px;
        display: none;
        background-color: transparent;
        overflow: hidden;
    }
    #order_management_table {
        width: 100%;
    }
    #order_management_table thead th {
        color: #b1b1b1;
        font-weight: 500;
    }
    #order_management_table th,
    #order_management_table td {
        border-top: 1px solid #efefef;
        height: 35px;
    }
    #order_management_table th {
        padding: 0px 5px;
    }
    #order_management_table th:not(:last-child),
    #order_management_table td:not(:last-child) {
        border-right: 1px solid #efefef;
    }
    .add-discussion-btn .btn {
        background-color: #fff;
        box-shadow: none;
        border: 1px solid #efefef;
        padding: 6px 10px;
        color: #565656;
        border-radius: .375rem;
    }
    .add-discussion-btn .btn:nth-child(2) {
        border-top-right-radius: 0.375rem !important;
        border-bottom-right-radius: 0.375rem !important;
    }
    .add-discussion-btn .btn.btn-secondary:active {
        background-color: #efefef !important;
    }
    .btn-secondary.min-btn,
    .btn-secondary.add-section-discussion,
    .btn-secondary.delete-section-discussion,
    .btn-secondary.delete-discussion{
        background-color: #fff;
        box-shadow: none;
        color: #b3b3b3;
        border: none;
        width: 26px;
        height: 26px;
        font-size: 12px;
    }
    .btn-secondary.open-chatbox-icon{
        background-color: #fff;
        box-shadow: none;
        color: #b3b3b3;
        border: none;
        height: 26px;
        width: 32px;
        font-size: 12px;
    }
    .btn-secondary.min-btn:hover,
    .btn-secondary.add-section-discussion:hover,
    .btn-secondary.delete-section-discussion:hover,
    .btn-secondary.delete-discussion:hover,
    .btn-secondary.open-chatbox-icon:hover {
        background-color: #efefef;
    }
    .btn-secondary.min-btn:active,
    .btn-secondary.add-section-discussion:active,
    .btn-secondary.delete-discussion:active,
    .btn-secondary.open-chatbox-icon:active,
    .btn-secondary.delete-section-discussion:active {
        background-color: #efefef !important;
    }
    .add-section-discussion,
    .delete-section-discussion,
    /* .open-chatbox-icon, */
    .delete-discussion{
    }

    .parent-row:hover .add-section-discussion,
    .parent-row:hover .delete-section-discussion,
    .first-child-row:hover .delete-discussion,
    .first-child-row:hover .open-chatbox-icon {
        display: inline-block;
    }
    .text-matte {
        color: #353535;
        font-weight: bold;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        top: 33px;
        left: 124px;
        background-color: #ffffff;
        min-width: 130px;
        overflow: auto;
        box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.1);
        z-index: 1;
    }
    .dropdown-content button {
        display: block;
        width: 100%;
        background-color: #fff;
        border: none;
        padding: 8px 10px;
        color: #565656;
        font-size: .75rem;
        font-weight: bold;
    }
    .dropdown-content button:hover {
        background-color: #efefef;
    }
    .dropdown-content button:not(:last-child) {
        border-bottom: 1px solid #eeee;
    }
    .dropdown-content button:focus {
        outline: none;
    }
    #new_section_row td:first-child,
    #new_discussion_input td:first-child {
        display: flex;
        padding: 8px 8px 8px 0px;
        height: auto !important;
    }
    #new_section_row td:first-child .min-btn,
    #new_discussion_input td:first-child .min-btn {
        margin-top: 4px;
    }
    .discussion-control:focus {
        border-color: rgb(211 50 50 / 25%);
    }
    .first-child-row td {
        color: #727272;
    }
    #new_discussion_input td:first-child,
    .first-child-row td:first-child {
        padding-left: 1rem;
    }
    .second-child-row td {
        color: #727272;
        padding-left: 5rem;
    }
    .first-child-row td:first-child,
    .second-child-row td:first-child {
        /* display: flex; */
        padding-top: 0.3rem
    }
    .discussion_ckeckbox {
        margin-top: -3px;
    }
    .discussion_ckeckbox .custom-control-label::before {
        border-radius: 1rem;
        width: 14px;
        height: 14px;
        position: relative;
        top: 8px;
        left: -19px;
    }
    .discussion_ckeckbox.custom-control-input:active~.custom-control-label::before {
        background-color: #2dce89;
    }
    .task-row {
        width: max-content;
        height: 26px;
        border: navajowhite;
        background-color: transparent;
        cursor: pointer;
    }
    .task-row:focus {
        outline: none;
    }
    #chatbox {
        background-color: #ffffff;
        height: 100%;
        position: fixed;
        top: 0rem;
        right: 0;
        width: 45%;
        box-shadow: 0px 0px 5px #0000002e;
        z-index: 1;
    }
    .control-btns {
        background-color: transparent;
    }
    .chat-controls .btn,
    .chat-details-table .btn,
    .chat-input .collaborators .btn {
        box-shadow: none;
        margin-right: 0;
        color: #d2d2d2;
        background-color: #ffffff;
    }
    .chat-details-table .btn {
        color: #aaaaaa;
    }
    .chat-controls .btn:hover,
    .chat-details-table .btn:hover,
    .chat-input .collaborators .btn {
        color: #999999;
        background-color: #eeeeee;
    }
    .chat-complete-btn {
        color: #d2d2d2;
        border-color: #d2d2d2;
        padding: .225rem .55rem;
        font-size: 12px;
    }
    .chat-details-table td h1 {
        color: #3b3b3b;
    }
    .chat-details-table td {
        font-size: 13px;
        padding: 5px;
    }
    .previous-chats td {
        font-size: 15px;
    }
    .bb-1-light {
        border-bottom: 1px solid #e7e7e7;
    }
    .discussion-subtask td {
        padding-top:7px;
        color: #999999;
    }
    .discussion-subtask td label {
        padding-top: 3px;
    }
    .chat-input .collaborators,
    .chat-input .join-discussion {
        font-size: 14px;
    }
    .chat-input .collaborators img {
        widows: 25px;
        height: 25px;
        border-radius: 50%;
        overflow: hidden;
    }
    .chat-textbox td:first-child img,
    .chat-user-icon {
        widows: 30px;
        height: 30px;
        border-radius: 50%;
        overflow: hidden;
    }
    .chat-input .collaborators .btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        overflow: hidden;
    }
    .text-light-blue {
        color: #0066ff;
    }
    .chat-details-container {
        height: 65%;
        overflow-y: scroll;
    }
    .comment-details-container {
        position: relative;
    }
    .submit-comment {
        position: absolute;
        right: 3px;
        bottom: 3px;
        display: none;
    }
    .upload-comment-image {
        position: absolute;
        right: 70px;
        bottom: 3px;
        display: none;
        margin-bottom: 0;
    }
    .user-dropdown {
        position: absolute;
        right: 104px;
        bottom: 3px;
        display: none;
    }
    .chat-input {
        border-top: 1px solid #d2d2d2;
        background-color: #f6f8f9;
        position: fixed;
        bottom: 30px;
        right: 0;
        width: 45%;
    }
    .rotate {
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
    }
    .line-control-menu-bar .dropdown-menu {
        min-width: 7rem;
    }
    .line-control-menu-bar .dropdown-menu li {
        font-size: 12px;
    }
    .line-control-menu-bar .dropdown-menu li a {
        display: inline-block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: #414141 !important;
        padding-left: .5rem;
    }
    .line-control-menu-bar .dropdown-menu li a:hover,
    .line-control-menu-bar .dropdown-menu li a:focus {
        text-decoration: none;
        background-image: none !important;
        background-color: #d2d2d2 !important;
    }
    .line-control-menu-bar .dropdown-menu li:not(:last-child) {
        border-bottom: 1px solid #d2d2d2;
    }
    .bg-selected {
        background-color: #efefef;
    }
    .Editor-editor img {
        width: 60%;
    }
    .previous-chats-tbody td:nth-child(2) img {
        width: 80%;
        cursor: pointer;
    }
    #comment_file_preview {
        width: 100%;
    }
    .user-dropdown {
        display: inline-block;
    }
    .user-dropdown1 {
        display: inline-block;
    }
    .dropdown-content1 {
        display: inline-block;
        position: absolute;
        bottom: 30px;
        background-color: #f1f1f1;
        min-width: 160px;
        min-height: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        height: 100px;
        overflow-y: scroll;
    }
    .dropdown-content1 a {
        color: black;
        font-size: 14px;
        padding: 2px 5px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content1 a:hover {
        background-color: #ddd;
        display: block;
    }
    .mention-dropdown-content {
        display: none;
        position: absolute;
        bottom: 30px;
        background-color: #f1f1f1;
        min-width: 160px;
        min-height: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        height: 100px;
        overflow-y: scroll;
    }
    .mention-dropdown-content a {
        color: black;
        font-size: 14px;
        padding: 2px 5px;
        text-decoration: none;
        display: block;
    }
    .mention-dropdown-content a:hover {
        background-color: #ddd;
        display: block;
    }
    .user-dropdown:hover .mention-dropdown-content {display: block;}
    .user-dropdown .mention-dropdown-content:hover {display: block;}

    .mention-dropdown-content2 {
        display: none;
        position: absolute;
        /* bottom: 30px; */
        background-color: #f1f1f1;
        /* min-width: 160px;
        min-height: 200px; */
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        /* height: 100px; */
        overflow-y: scroll;
    }
    .mention-dropdown-content2 a {
        color: black;
        font-size: 14px;
        padding: 2px 5px;
        text-decoration: none;
        display: block;
    }
    .mention-dropdown-content2 a:hover {
        background-color: #ddd;
        display: block;
    }
    .user-dropdown:hover .mention-dropdown-content2 {display: block;}
    .user-dropdown .mention-dropdown-content2:hover {display: block;}
    .discussion-due-date,
    #discussion_due_date {
        border-top: 0;
        border-left: 0;
        border-right: 0;
        border-bottom: 1px solid #d2d2d2;
        color: #727272;
        font-size: 14px;
    }
    .discussion-due-date:focus,
    #discussion_due_date:focus {
        border-top: 0;
        border-left: 0;
        border-right: 0;
        border-bottom: 1px solid #00a0ff7a;
        color: #727272;
        font-size: 14px;
        outline: none;
    }
    .discussion-assignee-name,
    #discussion_assignee_name {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        border: none;
        color: #727272;
        background: transparent;
        font-size: 14px;
    }
    .discussion-assignee-name:focus,
    #discussion_assignee_name:focus {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        border: none;
        color: #727272;
        background: transparent;
        font-size: 14px;
    }
    #discussion_title{
        border-radius: 0.375rem;
        border: none;
        color: #000000;
        font-size: 1.625rem;
        font-weight: 600;
    }
    .discussion-name{
        border-radius: 0.375rem;
        border: none;
        background: transparent;
        color: #727272;
        font-size: 14px;
    }
    .section-name{
        border-radius: 0.375rem;
        border: none;
    }
    select.discussion-assignee-name {
        max-width: 210px;
    }
    input.discussion-name {
        /* width: 180%; */
    }
    input.section-name {
        font-size: x-large;
        font-weight: 600;
        color: #606060;
        /* width: 71%; */
    }
    input#discussion_title {
        width: 100%;
    }

    .like-btn,
    .comment-dropbtn {
        background-color: #f6f8f9;
        box-shadow: none;
        color: #565656;
        border: none;
        width: 26px;
        height: 26px;
        font-size: 12px;
        cursor: pointer;
    }

    .comment-dropdown {
        position: relative;
        display: inline-block;
    }

    .comment-dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #f9f9f9;
        min-width: 100px;
        box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .comment-dropdown-content button {
       width: 100%;
       font-size: 12px;
       padding: 5px;
    }
    .td-position {
        padding-left: 42px !important;
    }

    .comment-dropdown-content a:hover {background-color: #f1f1f1;}
    .comment-dropdown:hover .comment-dropdown-content {display: block;}
    .comment-dropdown:hover .comment-dropbtn {background-color: #ffffff;}

    .Editor-editor .chat-download-icon{
        display: none;
    }
</style>

<input type="hidden" id="file_location" value="{{ asset('/') }}"/>
<input type="hidden" id="project_id" value="{{$project->id}}" />

<div class="col-md-12 pt-3">
    <div class="btn-group btn-group-sm add-discussion-btn">
        <button type="button" class="btn btn-secondary" id="add_section"><i class="fas fa-plus"></i> Add Section</button>
    </div>
</div>

<div class="col-md-12 mt-3 table-responsive">
    <table id="order_management_table table-responsive">
        <thead>
            <th width="80%">Section Name</th>
            <th width="10%">Assignee</th>
            <th width="10%">Due Date</th>
        </thead>

        <tbody id="new_section_row">
            <tr class="parent-row">
                <td>
                    <button type="button" class="btn btn-sm btn-secondary min-btn" data-id="1"><i class="fas fa-caret-right"></i></button>
                    <input type="text" class="form-control discussion-control" name="section_name" id="section_name" />
                    <input type="hidden" id="discussion_user_id" value="{{ Auth::user()->id }}" />

                    <input type="hidden" id="discussion_project_id" value="{{$project->id}}" />
                    <input type="hidden" id="discussion_order_type" value="{{$project->project_type_id}}" />
                </td>
                <td colspan="2"></td>
            </tr>
        </tbody>


        <tbody id="discussion_tbody"></tbody>
    </table>

</div>

{{-- Chatbox Interface --}}
<div class="col-md-12" id="chatbox">
    <input type="hidden" id="chat_section_id" />
    <input type="hidden" id="chat_discussion_id" />

    <div class="row pt-3 pb-3" style="border-bottom: 1px solid #d2d2d2;">
        <div class="col-md-4">
            <button type="button" class="btn btn-outline-success chat-complete-btn"><i class="far fa-check-circle"></i> Mark Complete</button>
        </div>

        <div class="col-md-8 text-right chat-controls">
            <button type="button" class="btn btn-sm btn-secondary" title="Like this"><i class="far fa-thumbs-up"></i></button>
            <button type="button" class="btn btn-sm btn-secondary" title="Attachments"><i class="fas fa-paperclip"></i></button>
            <button type="button" class="btn btn-sm btn-secondary" title="Subtasks"><i class="fas fa-share-alt"></i></button>
            <button type="button" class="btn btn-sm btn-secondary" title="Copy discussion link"><i class="fas fa-link"></i></button>
            <button type="button" class="btn btn-sm btn-secondary" title="More actions"><i class="fas fa-ellipsis-h"></i></button>
            <button type="button" class="btn btn-sm btn-secondary chat-close" title="Close details"><i class="fas fa-sign-in-alt"></i></button>
        </div>
    </div>

    <div class="col-md-12 mt-3 chat-details-container">
        <table class="chat-details-table" style="width: 100%;">
            <tbody>
                <tr>
                    <td colspan="2">
                        <input type="text" id="discussion_title"/>
                    </td>
                </tr>
                <tr>
                    <td>Assignee</td>
                    <td style="display: flex">
                            <img src="{{asset('argon')}}/img/icons/user.png" width="30px" style="margin-right: 10px;"/>
                        <select name="discussion_assignee_name" id="discussion_assignee_name">
                            <option value=""> No Assignee</option>
                            @foreach ($activeUsers as $user )
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Due Date</td>
                    <td>
                        <img src="{{asset('argon')}}/img/icons/calender.png" width="30px" style="margin-right: 10px;"/>
                        <input type="date" id="discussion_due_date" />
                    </td>
                </tr>
                <tr>
                    <td>Projects</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-secondary text-left" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; width: 100%;">
                            <i class="fas fa-circle" style="color: {{$project->project_color}}"></i> #{{$project->project_no}} {{$project->project_name}}
                        </button>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Description</td>
                    <td>
                        <div class="form-group" style="width: 100%;">
                            <textarea class="form-control discussion-control" rows="10" id="discussion_description"></textarea>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="chat-details-table previous-chats mb-5" style="width: 100%; background-color: #f6f8f9;">
            <tbody class="previous-chats-tbody"></tbody>
        </table>
    </div>

    <div class="col-md-12 pt-2 chat-input">
        <div class="row mb-1 mr-1 chat-textbox">
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td width="10%" class="text-center" style="vertical-align: top;">
                            <img src="{{ asset(auth()->user()->profile_pic) }}" class="mt-1" />
                        </td>
                        <td width="90%">
                            <div class="comment-details-container">
                                <textarea type="text" class="form-control discussion-control" name="comment_details" id="comment_details" rows="2"></textarea>

                                <div class="dropdown user-dropdown">
                                    <div class="mention-dropdown-content">
                                        @foreach ($activeUsers as $user)
                                            <a href="#" class="mention-user" data-mentioned-user-id="{{$user->id}}" data-mentioned-user-name="{{$user->name}}">
                                                @if ($user->profile_pic == null || $user->profile_pic == '')
                                                    <img src="{{asset('assets')}}/img/user/default.png" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                @else
                                                    <img src="{{asset($user->profile_pic)}}" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                @endif
                                                {{ $user->name }}
                                            </a>
                                        @endforeach
                                        @foreach ($activeUserGroups as $userGroup)
                                            <a href="#" class="mention-user" data-mentioned-user-id="0" data-mentioned-group-id="{{$userGroup->id}}" data-mentioned-group-name="{{$userGroup->name}}">
                                                <img src="{{asset('assets')}}/img/user/group_muted.png" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                {{ $userGroup->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="mention-dropdown-content2">
                                        @foreach ($activeUsers as $user)
                                            <a href="#" class="mention-user2 mentags" data-mentioned-user-id="{{$user->id}}" data-mentioned-user-name="{{$user->name}}">
                                                @if ($user->profile_pic == null || $user->profile_pic == '')
                                                    <img src="{{asset('assets')}}/img/user/default.png" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                @else
                                                    <img src="{{asset($user->profile_pic)}}" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                @endif
                                                {{ $user->name }}
                                            </a>
                                        @endforeach
                                        @foreach ($activeUserGroups as $userGroup)
                                            <a href="#" class="mention-user2 mentags" data-mentioned-user-id="0" data-mentioned-group-id="{{$userGroup->id}}" data-mentioned-group-name="{{$userGroup->name}}">
                                                <img src="{{asset('assets')}}/img/user/group_muted.png" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                {{ $userGroup->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" id="mentioned_users" />
                                <input type="hidden" id="mentioned_groups" />

                                <div style="height: 32px;">
                                    <input type="file" id="comment-file" multiple="multiple" hidden/>
                                    <label class="btn btn-info btn-sm upload-comment-image" for="comment-file"><i class="fas fa-paperclip"></i></label>


                                    <button style="margin-right: 3px;" type="button" class="btn btn-info btn-sm submit-comment" title="Comment" data-type="newComment">Comment</button>
                                    <button type="button" style="display: none;" class="btn btn-danger btn-sm submit-cancelEDit" title="Comment">Cancel Edit</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-8 collaborators">
                Collaborators
                <img src="{{asset('assets')}}/img/user/neil.png" />
                <img src="{{asset('assets')}}/img/user/team-4-800x800.jpg" />
                <button type="button" class="btn btn-sm btn-secondary" title="Add or Remove Collaborators"><i class="fas fa-plus"></i></button>
            </div>

            <div class="col-md-4 join-discussion text-right">
                <i class="far fa-bell"></i> Join Discussion
            </div>
        </div>
    </div>
</div>

{{-- File Preview --}}
<div class="modal fade" id="file_preview_modal" tabindex="-1" role="dialog" aria-labelledby="file_preview_modal_label" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <img id="comment_file_preview" src=""/>
            </div>

            <div class="modal-footer">
                <a href="#" id="comment_file_src" download="Encroms-media" class="btn btn-sm btn-success" title="Download"><i class="fas fa-download"></i> Download</a>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>  Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-database.js"></script>
<script>

    var SecDescutionSubTaskAvailable = 0;
    var SecProductionLayoutSubTaskAvailable = 0;
    var SecEstShippingDateSubTaskAvailable = 0;


//Test_ProjectManagement_firebase-EncrProjectTest


// var firebaseConfig = {
//                     apiKey: "AIzaSyDiOesdcl-nr33Bh_x7elxP88IPiwdJ55E",
//                     authDomain: "encrprojecttest.firebaseapp.com",
//                     databaseURL: "https://encrprojecttest-default-rtdb.firebaseio.com",
//                     projectId: "encrprojecttest",
//                     storageBucket: "encrprojecttest.appspot.com",
//                     messagingSenderId: "66705909680",
//                     appId: "1:66705909680:web:520ba7ab4403d00c8b1875",
//                     measurementId: "G-3M76J5CGW8"
//                     };




//Live_ProjectManagement_firebase-ENCRProjects

// var firebaseConfig = {
//                    apiKey: "AIzaSyC6nKHXbdmjFo7L-KbE03DM2ng-z5HAoDY",
//                    authDomain: "encrprojects.firebaseapp.com",
//                    databaseURL: "https://encrprojects-default-rtdb.firebaseio.com",
//                    projectId: "encrprojects",
//                    storageBucket: "encrprojects.appspot.com",
//                    messagingSenderId: "415018325140",
//                    appId: "1:415018325140:web:f8726e9f2196f99dc91081",
//                    measurementId: "G-6GNGV674H1"
//                    };

// var firebaseConfig = {
//         apiKey: "{{ env('PROJECT_FIREBASE_API_KEY') }}",
//         authDomain: "{{ env('PROJECT_FIREBASE_AUTH_DOMAIN') }}",
//         databaseURL: "{{ env('PROJECT_FIREBASE_DATABASE_URL') }}",
//         projectId: "{{ env('PROJECT_FIREBASE_PROJECT_ID') }}",
//         storageBucket: "{{ env('PROJECT_FIREBASE_STORAGE_BUCKET') }}",
//         messagingSenderId: "{{ env('PROJECT_FIREBASE_MESSAGING_SENDER_ID') }}",
//         appId: "{{ env('PROJECT_FIREBASE_APP_ID') }}",
//         measurementId: "{{ env('PROJECT_FIREBASE_MEASUREMENT_ID') }}"
//     };

//     firebase.initializeApp(firebaseConfig);

    var userInfo = <?php echo json_encode($userInfo); ?>;

    $(document).ready(function(){

        // Hide buffering icon
        $('#chatbox').hide();
        $("#comment_details").Editor({
            'block_quote':false,
            'undo':false,
            'redo':false,
            'unlink':false,
            'insert_img':true,
            'insert_table':false,
            'splchars':false,
            'hr_line':false,
            'print':false,
            'rm_format':false,
            'select_all':false,
            'source':false,
            'togglescreen':false,
        });

        $('.second-child-row').hide();
        $('#new_section_row').hide();

        displayAllSections();

        $(".se-pre-con").fadeOut('slow');
    });

    function displayAllSections() {
        var project_id = $('#discussion_project_id').val();
        var order_type = $('#discussion_order_type').val();
        $.ajax({
            url: '{{ url("get_project_management") }}/'+project_id,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var section_data = data;

                $('#discussion_tbody').html('');
                var notAvaibleDefaultDiscustionsinSecDescution = "0";
                var notAvaibleDefaultDiscustionsinSecEstShippingDate = "0";
                var notAvaibleDefaultDiscustionsinSecProductionLayout = "0";
                var arrDiscutionsinSecDescution = [];
                var arrDiscutionsinSecEstShippingDate = [];
                var arrDiscutionsinSecProductionLayout = [];

                var sectionNames = [];
                var readonly = "";
                for(var i = 0; i < section_data.length; i++){
                    // Create section row
                    var parentRow = '<tr class="parent-row" id="parent_section_'+section_data[i].id+'">'+
                            '<td colspan="3" class="text-matte pt-1">'+
                                '<button type="button" class="btn btn-sm btn-secondary parent-min min-btn" data-id="'+section_data[i].id+'"><i class="fas fa-caret-right"></i></button>'+
                                '<input class="section-name" type="text" data-id="'+section_data[i].id+'" '+readonly+' value="'+section_data[i].section_name+'" data-order="'+section_data[i].project_id+'"/>'+' '+
                                '<button type="button" class="btn btn-sm btn-secondary add-section-discussion" data-id="'+section_data[i].id+'" data-order="'+section_data[i].project_id+'" data-toggle="tooltip" data-placement="bottom" title="Add a discussion to this section"><i class="fas fa-plus"></i></button>'+
                                '@can("delete section")'+
                                '<button type="button" class="btn btn-sm btn-secondary delete-section-discussion" data-id="'+section_data[i].id+'" data-order="'+section_data[i].project_id+'" data-toggle="tooltip" data-placement="bottom" title="Delete this section"><i class="fas fa-times"></i></button>'+
                                '@endcan'+
                                '</td>'+
                            '</tr>';

                    $('#discussion_tbody').append(parentRow);
                    sectionNames.push(section_data[i].section_name);
                    // displaySectionDiscussions(section_data[i]);

                    setTimeout("clickTask()", 5000);
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

    function displaySingleSectionById(sectionId) {
        $.ajax({
            url: '{{ url("get_project_management_section_by_id") }}/'+sectionId,
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

        // for(var i = 0; i < section_data.length; i++){
            // Create section row
            var parentRow = '<tr class="parent-row" id="parent_section_'+section_data.id+'">'+
                    '<td colspan="3" class="text-matte pt-1">'+
                        '<button type="button" class="btn btn-sm btn-secondary parent-min min-btn" data-id="'+section_data.id+'"><i class="fas fa-caret-right"></i></button>'+
                        '<input class="section-name" type="text" data-id="'+section_data.id+'" value="'+section_data.section_name+'" data-order="'+section_data.project_id+'"/>'+' '+
                        '<button type="button" class="btn btn-sm btn-secondary add-section-discussion" data-id="'+section_data.id+'" data-order="'+section_data.project_id+'" data-toggle="tooltip" data-placement="bottom" title="Add a discussion to this section"><i class="fas fa-plus"></i></button>'+
                        '@can("delete section")'+
                        '<button type="button" class="btn btn-sm btn-secondary delete-section-discussion" data-id="'+section_data.id+'" data-order="'+section_data.project_id+'" data-toggle="tooltip" data-placement="bottom" title="Delete this section"><i class="fas fa-times"></i></button>'+
                        '@endcan'+
                        '</td>'+
                    '</tr>';

            $('#discussion_tbody').prepend(parentRow);
            setTimeout("clickTask()", 5000);
        // }
    }

    function displaySectionDiscussionsBySectionId(sectionId){
        $.ajax({
            url: '{{ url("get_project_management_section_by_id") }}/'+sectionId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('.parent-section-'+sectionId).remove();
                displaySectionDiscussions(data);
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

    function displaySectionDiscussions(sectionData){

        var discussions = sectionData.discussions;
        // var discussions = section_data[i].discussions;
        var discussionData = [];
        for(var key in discussions){
            var arr = [];
            arr.push(discussions[key]);
            arr.push(key);

            discussionData.push(arr);
        }

        var discussion_data = discussionData;

        // Create discussion row
        var discussionNamesDiscussion = [];
        var discussionNamesProductionLayouts = [];
        var discussionNamesEstimatedShipping = [];

        var childRow = [];
        for(var j = 0; j < discussion_data.length; j++){
            var userOptions = [];
            for (let l = 0; l < userInfo.length; l++) {
                if ((discussion_data[j])[0].assignee_id == userInfo[l].id) {
                    var isSelected = 'selected';
                } else {
                    var isSelected = '';
                }

                userOptions += '<option value="'+userInfo[l].id+'" '+isSelected+'>'+userInfo[l].name+'</option>';
            }


            var comments = (discussion_data[j])[0].comments;
            var commentsData = [];
            for(var key in comments){
                var arr = [];
                arr.push(comments[key]);
                arr.push(key);

                commentsData.push(arr);
            }

            var comments_data = commentsData;

            var mentionedGroups = [];
            for (var m = 0; m < comments_data.length; m++) {
                if ((comments_data[m])[0].mentioned_groups == null || (comments_data[m])[0].mentioned_groups == '' || (comments_data[m])[0].mentioned_groups == undefined) {
                    //
                } else {
                    var mentionedGroupArr = (comments_data[m])[0].mentioned_groups;
                    var groupArray = mentionedGroupArr.split(",");

                    for (let n = 0; n < groupArray.length; n++) {
                        mentionedGroups.push(groupArray[n]);
                    }
                }
            }
            // console.log(mentionedGroups);

            var mentionedUsers = '';
            if ((discussion_data[j])[0].mentioned_users == null || (discussion_data[j])[0].mentioned_users == '' || (discussion_data[j])[0].mentioned_users == undefined) {
                mentionedUsers = '';
            } else {
                mentionedUsers = (discussion_data[j])[0].mentioned_users;
            }

            var mentionedUsers = [];
            for (var m = 0; m < comments_data.length; m++) {
                if ((comments_data[m])[0].mentioned_users == null || (comments_data[m])[0].mentioned_users == '' || (comments_data[m])[0].mentioned_users == undefined) {
                    //
                } else {
                    var mentionedUserArr = (comments_data[m])[0].mentioned_users;
                    var userArray = mentionedUserArr.split(",");

                    for (let n = 0; n < userArray.length; n++) {
                        mentionedUsers.push(userArray[n]);
                    }
                }
            }
            // console.log(mentionedUsers);

                childRow += '<tr class="first-child-row parent-section-'+sectionData.id+'" id="discussion_'+(discussion_data[j])[0].id+'">'+
                                '<td class="open-chatbox first-child-td td-position" data-value="'+(discussion_data[j])[0].id+'" data-section="'+sectionData.id+'" data-order-id="'+project_id+'">'+
                                    '<div class="custom-control custom-checkbox discussion_ckeckbox" style="float:left"><input type="checkbox" com-name="discussion_checkbox" class="custom-control-input" id="custom_check_'+(discussion_data[j])[0].id+'_'+j+'"><label class="custom-control-label" com-name="discussion_checkbox" for="custom_check_'+(discussion_data[j])[0].id+'_'+j+'">&nbsp;</label></div>'+
                                    '<input type="text" com-name="discussion_text" class="discussion-name" style="border: none;float:left" onkeyup="message_text_change(this)" data-id="'+sectionData.id+'" data-order="'+sectionData.project_id+'" data-discussion="'+(discussion_data[j])[0].id+'" value="'+(discussion_data[j])[0].discussion_name+'" />'+
                                    '@can("delete discussion")'+
                                    '<button type="button" com-name="discussion_btn_delete" class="btn btn-sm btn-secondary delete-discussion ml-2" data-id="'+sectionData.id+'" data-order="'+sectionData.project_id+'" data-discussion="'+(discussion_data[j])[0].id+'" data-sectionName="'+sectionData.section_name+'" data-discussionName="'+(discussion_data[j])[0].discussion_name+'" data-toggle="tooltip" data-placement="bottom" title="Delete this discussion"><i com-name="discussion_btn_delete" class="fas fa-times"></i></button>'+
                                    '@endcan'+
                                    '<button type="button" class="btn btn-sm btn-secondary open-chatbox-icon open-chatbox" style="float:left" data-value="'+(discussion_data[j])[0].id+'" data-section="'+sectionData.id+'" data-order-id="'+project_id+'" data-toggle="tooltip" data-placement="bottom" title="Chat"><span id="discussion_comment_count_'+(discussion_data[j])[0].id+'">'+comments_data.length+'</span><i class="far fa-comments" style="margin-left:2px;"></i></button>'+
                                    // '<button type="button" class="open-chatbox task-row" data-value="'+(discussion_data[j])[0].id+'" data-section="'+sectionData.id+'" data-order-id="'+project_id+'"></button>'+
                                '</td>'+
                                '<td>'+
                                    '<select class="discussion-assignee-name" data-id="'+sectionData.id+'" data-order="'+sectionData.project_id+'" data-discussion="'+(discussion_data[j])[0].id+'">'+
                                        '<option value=""> No Assignee</option>'+
                                        userOptions+
                                    '</select>'+
                                '</td>'+
                                '<td>'+
                                    '<input type="date" class="discussion-due-date" data-id="'+sectionData.id+'" data-order="'+sectionData.project_id+'" data-discussion="'+(discussion_data[j])[0].id+'" value="'+(discussion_data[j])[0].due_date+'" />'+
                                '</td>'+
                            '</tr>';

        }

        // var row = parentRow + childRow;

        // Append childRow as the next tr after the parent section row
        $('#parent_section_' + sectionData.id).after(childRow);

        $( ".discussion-name" ).each(function() {
            var text_length = $(this).val().length;

            if(text_length > 50){
                text_length = 50;
            }else if(text_length < 10){
                text_length = 10;
            }
            $(this).width(text_length*8);
        });
    }

    function deleteSection(sectionId)
    {
        $('#parent_section_'+sectionId).fadeOut(300, function() { $(this).remove(); });
        $('.parent-section-'+sectionId).fadeOut(300, function() { $(this).remove(); });
    }

    function deleteSectionDiscussion(discussionId)
    {
        $('#discussion_'+discussionId).fadeOut(300, function() { $(this).remove(); });
    }

    // function defaultSections(section_name) {
    //     var project_id = $('#discussion_project_id').val();
    //     var user_id = $('#discussion_user_id').val();

    //     $sdhsdunjnj = firebase.database().ref('sections/' + project_id).push().set({
    //         project_id:project_id,
    //         section_name:section_name,
    //         assignee_id:'',
    //         due_date:'',
    //         user_id:user_id,

    //     }).catch(function(error){
    //         swal({
    //             title: "Error!",
    //             text: error.message,
    //             type: "warning",
    //             buttons: true,
    //             dangerMode: true,
    //             confirmButtonColor: '#5fb644',
    //         })
    //     });
    //     console.log($sdhsdunjnj);
    // }

    // function defaultDiscussions(discussion_name, section_id, project_id) {
    //     firebase.database().ref('sections/' + project_id + '/' + section_id + '/discussions').push().set({
    //         project_id:project_id,
    //         section_id:section_id,
    //         discussion_name:discussion_name,
    //         assignee_id:'',
    //         discussion_description:'',
    //         due_date:'',

    //     }).then(function(discussions){
    //         // alert("check ading sectiondiscuss");

    //     }).catch(function(error){
    //         swal({
    //             title: "Error!",
    //             text: error.message,
    //             type: "warning",
    //             buttons: true,
    //             dangerMode: true,
    //             confirmButtonColor: '#5fb644',
    //         })
    //     });
    // }

    var comment_mention_id="";

    function clickTask(){
        var hasTaskId  = new window.URLSearchParams(window.location.search).has('taskId');
        comment_mention_id  = new window.URLSearchParams(window.location.search).get('comment_mention_id');
        if (hasTaskId === true) {
            var taskId  = new window.URLSearchParams(window.location.search).get('taskId');
            // console.log(taskId);

            $('.open-chatbox').each(function() {
                // console.log($(this).val());
                if($(this).val() == taskId) {
                    $(this).click();
                }
            });
        }
    }

    $('body').on('click', '.parent-min', function(){
        var rowId = $(this).data('id');
        $(this).toggleClass('rotate');

        // Use a data attribute to track toggle state
        var $parentRow = $(this).closest('.parent-row');
        var isLoaded = $parentRow.data('section-loaded');

        if (!isLoaded) {
            // First toggle: load via AJAX
            $.ajax({
                url: '{{ url("get_project_management_section_by_id") }}/'+rowId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    displaySectionDiscussions(data);
                    $('.parent-section-'+rowId).siblings('.second-child-row').hide(700);
                    $parentRow.data('section-loaded', true); // Mark as loaded
                }
            });
        } else {
            // Second toggle: use commented lines (show/hide)
            $('.parent-section-'+rowId).toggle(700);
            $('.parent-section-'+rowId).siblings('.second-child-row').hide(700);
            $('.parent-section-'+rowId).find('.child-min').removeClass('rotate');
        }

    });

    // Chatbox open
    $('body').on('click', '.open-chatbox', function(e){

        var component_name = e.target.getAttribute('com-name');

        if(component_name !== "discussion_text" && component_name !== "discussion_checkbox" && component_name !== "discussion_btn_delete"){

            $('.first-child-row').removeClass('bg-selected');
            $('.first-child-td').removeClass('bg-selected');
            $(this).parent().addClass('bg-selected');

            $('#menuBarDiv_comment_details').hide();

            var project_id = $(this).data('order-id');
            var section_id = $(this).data('section');
            // var discussion_id = $(this).val();
            var discussion_id = $(this).data('value');

            $('#chat_section_id').val(section_id);
            $('#chat_discussion_id').val(discussion_id);

            $.ajax({
                url: '{{ url("get_project_management_section_discussion_by_id") }}/'+discussion_id,
                method: 'GET',
                dataType: 'json',
                success: function(data) {

                // Load discussion details
                // firebase.database().ref('sections/'+project_id+'/'+section_id+'/discussions/'+discussion_id).on('value', (snapshot) => {
                    $('#discussion_title').val(data.discussion_name);

                    // $('#discussion_description').html(data.discussion_description);
                    $('#discussion_description').val(data.discussion_description);

                    $('#discussion_assignee_name').val(data.assignee_id);
                    $('#discussion_due_date').val(data.due_date);
                // });

                // Load Comments
                // firebase.database().ref('sections/'+project_id+'/'+section_id+'/discussions/'+discussion_id+'/comments').on('value', (snapshot) => {
                    $('.previous-chats-tbody').html('');
                //     var commentData = [];
                //     snapshot.forEach(comments => {
                //         var temp = {
                //             key: comments.key,
                //             user_id: comments.val().user_id,
                //             comments: comments.val().comments,
                //             date: comments.val().date,
                //             liked: comments.val().liked,
                //             mentioned_users: comments.val().mentioned_users,
                //             mentioned_groups: comments.val().mentioned_groups,
                //             comment_mention_id: comments.val().comment_mention_id
                //         };
                //         commentData.push(temp);
                //         return false;
                //     });

                    // var comment_data = commentData.reverse();
                    var comment_data = data.comments;

                    var row = [];
                    for(var i = 0; i < comment_data.length; i++){

                        // var comment_user = userInfo.filter(function (person) { return person.id == comment_data[i].user_id });
                        var comment_user = comment_data[i].user_info;
                        if(comment_user.profile_pic == null || comment_user.profile_pic ==''){
                            var comment_profile_pic = '{{asset("assets")}}/img/user/default.png';
                        } else {
                            var comment_profile_pic = '{{asset("assets")}}/../'+comment_user.profile_pic;
                        }

                        if (comment_data[i].date == null || comment_data[i].date == '' || comment_data[i].date == undefined) {
                            var comment_date = '';
                        } else {
                            var comment_date = fromatCommentDate(comment_data[i].date);
                        }

                        if (comment_data[i].is_liked == null || comment_data[i].is_liked == '' || comment_data[i].is_liked == undefined || comment_data[i].is_liked == 0) {
                            var comment_liked = '<i class="far fa-thumbs-up"></i>';
                            var liked_status = 0;
                        } else {
                            var comment_liked = '<i class="fas fa-thumbs-up"></i>';
                            var liked_status = 1;
                        }

                        var mentionedGroups = '';
                        if (comment_data[i].mentioned_groups == null || comment_data[i].mentioned_groups == '' || comment_data[i].mentioned_groups == undefined) {
                            mentionedGroups = '';
                        } else {
                            mentionedGroups = comment_data[i].mentioned_groups;
                        }

                        var mentionedUsers = '';
                        if (comment_data[i].mentioned_users == null || comment_data[i].mentioned_users == '' || comment_data[i].mentioned_users == undefined) {
                            mentionedUsers = '';
                        } else {
                            mentionedUsers = comment_data[i].mentioned_users;
                        }

                        var css="";

                        if(comment_data[i].comment_mention_id==comment_mention_id && comment_mention_id!=null){
                            css="background-color:#a7d6ed;";
                        }

                        // if (orderSearch == 'all') {

                            row += '<tr class="bb-1-light" style="'+css+'" id="comment_row_'+comment_data[i].id+'">'+
                                    '<td style="vertical-align:top"><img src="'+comment_profile_pic+'" class="chat-user-icon" /></td>'+
                                    '<td class="comment-content pb-3">'+
                                        '<b>'+comment_user.name+'</b><br>'+
                                        '<b><small>'+comment_date+'</small></b><br><div id="discussion_comment_'+comment_data[i].id+'">'+
                                        comment_data[i].comment+'</div><br>'+
                                        // '<span class="text-light-blue">@Alissha Davis @Neil Butterfield</span><br>'+
                                    '</td>'+
                                    '<td class="text-right" style="display: flex; vertical-align: top;">'+
                                        '<button type="button" class="btn btn-sm btn-secondary like-btn" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+comment_data[i].id+'" value="'+liked_status+'">'+comment_liked+'</button>'+
                                        '<div class="comment-dropdown">'+
                                            '<button class="comment-dropbtn"><i class="fas fa-angle-down"></i></button>'+
                                            '<div class="comment-dropdown-content">'+
                                                '@can("delete comment")'+
                                                '<button type="button" class="btn btn-delete-comment" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+comment_data[i].id+'">Delete</button>'+
                                                '@endcan'+
                                                '<button type="button" class="btn btn-update-comment" data-divid="discussion_comment_'+comment_data[i].id+'" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+comment_data[i].id+'">Edit</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                            '</tr>';

                        // } else {
                        //         var groupArray = mentionedGroups.split(",");
                        //         var userArray = mentionedUsers.split(",");

                        //         if (($.inArray(String(userRoleId), groupArray) != -1) || ($.inArray(String(userId), userArray) != -1) || (comment_data[i].user_id == userId)) {
                        //             if (comment_data[i].user_id == userId) {
                        //                 var deleteBtn = '<button type="button" class="btn btn-delete-comment" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+comment_data[i].key+'">Delete</button>';
                        //             } else {
                        //                 var deleteBtn = '';
                        //             }

                        //             row += '<tr class="bb-1-light" style="'+css+'">'+
                        //                         '<td><img src="'+comment_profile_pic+'" class="chat-user-icon" /></td>'+
                        //                         '<td class="comment-content pb-3">'+
                        //                             '<b>'+comment_user[0].name+'</b><br>'+
                        //                             '<b><small>'+comment_date+'</small></b><br><div id="'+project_id+section_id+discussion_id+comment_data[i].key+'">'+
                        //                             comment_data[i].comments+'</div><br>'+
                        //                             // '<span class="text-light-blue">@Alissha Davis @Neil Butterfield</span><br>'+
                        //                         '</td>'+
                        //                         '<td class="text-right" style="display: flex; vertical-align: top;">'+
                        //                             '<button type="button" class="btn btn-sm btn-secondary like-btn" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+comment_data[i].key+'" value="'+liked_status+'">'+comment_liked+'</button>'+
                        //                             '<div class="comment-dropdown">'+
                        //                                 '<button class="comment-dropbtn"><i class="fas fa-angle-down"></i></button>'+
                        //                                 '<div class="comment-dropdown-content">'+
                        //                                     deleteBtn+
                        //                                     '<button type="button" class="btn btn-update-comment" data-divid="'+project_id+section_id+discussion_id+comment_data[i].key+'" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+comment_data[i].key+'">Edit</button>'+
                        //                                 '</div>'+
                        //                             '</div>'+
                        //                         '</td>'+
                        //                 '</tr>';
                        //         }
                        // }
                    }
                    $('.previous-chats-tbody').append(row);
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

            $('#chatbox').show(700);
        }
    });

    function appendNewComment(project_id, section_id, discussion_id, commentData)
    {
        var comment_user = commentData.user_info;
        if(comment_user.profile_pic == null || comment_user.profile_pic ==''){
            var comment_profile_pic = '{{asset("assets")}}/img/user/default.png';
        } else {
            var comment_profile_pic = '{{asset("assets")}}/../'+comment_user.profile_pic;
        }

        if (commentData.date == null || commentData.date == '' || commentData.date == undefined) {
            var comment_date = '';
        } else {
            var comment_date = fromatCommentDate(commentData.date);
        }

        if (commentData.is_liked == null || commentData.is_liked == '' || commentData.is_liked == undefined || commentData.is_liked == 0) {
            var comment_liked = '<i class="far fa-thumbs-up"></i>';
            var liked_status = 0;
        } else {
            var comment_liked = '<i class="fas fa-thumbs-up"></i>';
            var liked_status = 1;
        }

        var mentionedGroups = '';
        if (commentData.mentioned_groups == null || commentData.mentioned_groups == '' || commentData.mentioned_groups == undefined) {
            mentionedGroups = '';
        } else {
            mentionedGroups = commentData.mentioned_groups;
        }

        var mentionedUsers = '';
        if (commentData.mentioned_users == null || commentData.mentioned_users == '' || commentData.mentioned_users == undefined) {
            mentionedUsers = '';
        } else {
            mentionedUsers = commentData.mentioned_users;
        }

        var css="";

        if(commentData.comment_mention_id==comment_mention_id && comment_mention_id!=null){
            css="background-color:#a7d6ed;";
        }
        var row = '';

        row += '<tr class="bb-1-light comment-row comment-discussion-id-'+discussion_id+'" style="'+css+'" id="comment_row_'+commentData.id+'">'+
                '<td style="vertical-align:top"><img src="'+comment_profile_pic+'" class="chat-user-icon" /></td>'+
                '<td class="comment-content pb-3">'+
                    '<b>'+comment_user.name+'</b><br>'+
                    '<b><small>'+comment_date+'</small></b><br><div id="discussion_comment_'+commentData.id+'">'+
                    commentData.comment+'</div><br>'+
                    // '<span class="text-light-blue">@Alissha Davis @Neil Butterfield</span><br>'+
                '</td>'+
                '<td class="text-right" style="display: flex; vertical-align: top;">'+
                    '<button type="button" class="btn btn-sm btn-secondary like-btn" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+commentData.id+'" value="'+liked_status+'">'+comment_liked+'</button>'+
                    '<div class="comment-dropdown">'+
                        '<button class="comment-dropbtn"><i class="fas fa-angle-down"></i></button>'+
                        '<div class="comment-dropdown-content">'+
                            '@can("delete comment")'+
                            '<button type="button" class="btn btn-delete-comment" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+commentData.id+'">Delete</button>'+
                            '@endcan'+
                            '<button type="button" class="btn btn-update-comment" data-divid="discussion_comment_'+commentData.id+'" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+commentData.id+'">Edit</button>'+
                        '</div>'+
                    '</div>'+
                '</td>'+
        '</tr>';
        $('.previous-chats-tbody').prepend(row);
        $('#chatbox').show(700);
        updateCommentCount(discussion_id);
    }

    function updateCommentCount(discussion_id)
    {
        var commentCount = $('.comment-discussion-id-'+discussion_id).length;
        $('#discussion_comment_count_'+discussion_id).text(commentCount);
    }

    function updateExistingComment(project_id, section_id, discussion_id, commentData)
    {
        var comment_user = commentData.user_info;
        if(comment_user.profile_pic == null || comment_user.profile_pic ==''){
            var comment_profile_pic = '{{asset("assets")}}/img/user/default.png';
        } else {
            var comment_profile_pic = '{{asset("assets")}}/../'+comment_user.profile_pic;
        }

        if (commentData.date == null || commentData.date == '' || commentData.date == undefined) {
            var comment_date = '';
        } else {
            var comment_date = fromatCommentDate(commentData.date);
        }

        if (commentData.is_liked == null || commentData.is_liked == '' || commentData.is_liked == undefined || commentData.is_liked == 0) {
            var comment_liked = '<i class="far fa-thumbs-up"></i>';
            var liked_status = 0;
        } else {
            var comment_liked = '<i class="fas fa-thumbs-up"></i>';
            var liked_status = 1;
        }

        var mentionedGroups = '';
        if (commentData.mentioned_groups == null || commentData.mentioned_groups == '' || commentData.mentioned_groups == undefined) {
            mentionedGroups = '';
        } else {
            mentionedGroups = commentData.mentioned_groups;
        }

        var mentionedUsers = '';
        if (commentData.mentioned_users == null || commentData.mentioned_users == '' || commentData.mentioned_users == undefined) {
            mentionedUsers = '';
        } else {
            mentionedUsers = commentData.mentioned_users;
        }

        var css="";

        if(commentData.comment_mention_id==comment_mention_id && comment_mention_id!=null){
            css="background-color:#a7d6ed;";
        }
        var row = '';

        row += '<td style="vertical-align:top"><img src="'+comment_profile_pic+'" class="chat-user-icon" /></td>'+
                '<td class="comment-content pb-3">'+
                    '<b>'+comment_user.name+'</b><br>'+
                    '<b><small>'+comment_date+'</small></b><br><div id="discussion_comment_'+commentData.id+'">'+
                    commentData.comment+'</div><br>'+
                    // '<span class="text-light-blue">@Alissha Davis @Neil Butterfield</span><br>'+
                '</td>'+
                '<td class="text-right" style="display: flex; vertical-align: top;">'+
                    '<button type="button" class="btn btn-sm btn-secondary like-btn" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+commentData.id+'" value="'+liked_status+'">'+comment_liked+'</button>'+
                    '<div class="comment-dropdown">'+
                        '<button class="comment-dropbtn"><i class="fas fa-angle-down"></i></button>'+
                        '<div class="comment-dropdown-content">'+
                            '@can("delete comment")'+
                            '<button type="button" class="btn btn-delete-comment" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+commentData.id+'">Delete</button>'+
                            '@endcan'+
                            '<button type="button" class="btn btn-update-comment" data-divid="discussion_comment_'+commentData.id+'" data-comment-order-id="'+project_id+'" data-comment-section-id="'+section_id+'" data-comment-discussion-id="'+discussion_id+'" data-comment-id="'+commentData.id+'">Edit</button>'+
                        '</div>'+
                    '</div>'+
                '</td>';
        $('#comment_row_'+commentData.id).html(row);
    }

    function fromatCommentDate(commentDate)
    {
        var originalDate = new Date(commentDate);
        var month = originalDate.getMonth() + 1;
        var day = originalDate.getDate();
        var year = originalDate.getFullYear();
        var hours = originalDate.getHours();
        var minutes = originalDate.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12;

        return (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' + year + ' ' + ('0'+hours).slice(-2) + ":" + ('0'+minutes).slice(-2) + ampm;
    }

    // Chatbox close
    $('body').on('click', '.chat-close', function(){
        $('#chatbox').hide(700);
    });
    var updateCommentDetails = [];
    $('body').on('click', '.btn-update-comment', function(){
        //alert($(this).attr("data-divid"));
        $(".Editor-editor").html($("#"+$(this).attr("data-divid")).html());

        $('#menuBarDiv_comment_details').show(500);
        $('.submit-comment').show(500);
        $('.upload-comment-image').show(500);
        $('.comment-mention').show(500);
        $('.Editor-editor').animate({'height': '150px'}, 'slow');
        $('.chat-input').animate({'height': '300px'}, 'slow');
        $(".submit-cancelEDit").show();
        $(".submit-comment").attr("data-type","updateComment");
        updateCommentDetails.length = 0;
        updateCommentDetails.push($(this).attr("data-comment-order-id"),$(this).attr("data-comment-section-id"),$(this).attr("data-comment-discussion-id"),$(this).attr("data-comment-id"));
        // console.log(updateCommentDetails);
        // console.log(updateCommentDetails[1]);
        //$(".comment-details-container").append("<button type='button' class='btn btn-danger btn-sm submit-cancelEDit' title='Comment'>Cancel Edit</button>")
    });

    $('body').on('click', '.submit-cancelEDit', function(){
        $(".Editor-editor").html("");
        $(".submit-comment").attr("data-type","newComment");
        $('.submit-comment').hide(500);
        $('#menuBarDiv_comment_details').hide(500);
        $('.upload-comment-image').hide(500);
        $('.comment-mention').hide(500);
        $('.chat-input').animate({'height': '87px'}, 'slow');
        $('.Editor-editor').animate({'height': '35px'}, 'slow');
        updateCommentDetails.length = 0;
        $(this).hide();


    });


    $(document).mouseup(function(e)
    {
        var container = $(".chat-input");


        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0 && $("#file_preview_modal").has(e.target).length === 0 && e.target.getAttribute('class') !== "cGcvT")
        {
                $('.submit-comment').hide(500);
                $('#menuBarDiv_comment_details').hide(500);
                $('.upload-comment-image').hide(500);
                $('.comment-mention').hide(500);
                $('.chat-input').animate({'height': '87px'}, 'slow');
                $('.Editor-editor').animate({'height': '35px'}, 'slow');
        }
    });


    $('body').on('click', '.btn-discussion-expand', function(){
        var rowId = $(this).val();
        $('.second-child-row.'+rowId).toggle(700);
        $(this).toggleClass('rotate');
    });

    // Comment input display
    $('body').on('click', '.Editor-editor', function(){
        $('#menuBarDiv_comment_details').show(500);
        $('.submit-comment').show(500);
        $('.upload-comment-image').show(500);
        $('.comment-mention').show(500);
        $(this).animate({'height': '150px'}, 'slow');
        $('.chat-input').animate({'height': '300px'}, 'slow');
    });

    $('body').on('click', '.submit-comment', function(){
    console.log(document.getElementById("comment-file").files.length);
    if(document.getElementById("comment-file").files.length != 0){
            uploadMultipleTypeFiles();
        }

        var project_id = $('#discussion_project_id').val();
        var section_id = $('#chat_section_id').val();
        var discussion_id = $('#chat_discussion_id').val();
        var discussion_title = $('#discussion_title').val();
        var user_id = $('#discussion_user_id').val();
        var comments = $('.Editor-editor').html();
        var mentioned_users = $('#mentioned_users').val();
        var mentioned_groups = $('#mentioned_groups').val();

        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();

        var hours = d.getHours();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12;

        // var date = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' + d.getFullYear() + ' ' + hours + ":" + d.getMinutes() + ampm;
        var date = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' + d.getFullYear() + ' ' + ('0'+hours).slice(-2) + ":" + ('0'+d.getMinutes()).slice(-2) + ampm;

        //alert(updateCommentDetails[0][0]);
        if(comments != '' && comments != null){

            if($(this).attr("data-type") == "updateComment"){

                // firebase.database().ref('sections/'+updateCommentDetails[0]+'/'+updateCommentDetails[1]+'/discussions/'+updateCommentDetails[2]+'/comments/'+updateCommentDetails[3]).update({
                //     user_id:user_id,
                //     comments:comments,
                //     date:date,
                //     mentioned_users: mentioned_users,
                //     mentioned_groups: mentioned_groups,
                // })
                // .catch(function(error){
                //     swal({
                //         title: "Error!",
                //         text: error.message,
                //         type: "warning",
                //         buttons: true,
                //         dangerMode: true,
                //         confirmButtonColor: '#5fb644',
                //     })
                // });

                $.ajax({
                    url: '{{ url("project_management_section_discussion_comment/update") }}/'+updateCommentDetails[3],
                    method: 'POST',
                    data: {
                        comment:comments,
                        mentioned_users: mentioned_users,
                        mentioned_groups: mentioned_groups,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        updateExistingComment(project_id, section_id, discussion_id, data)
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

                $(".Editor-editor").html("");
                $(".submit-comment").attr("data-type","newComment");
                $('.submit-comment').hide(500);
                $('#menuBarDiv_comment_details').hide(500);
                $('.upload-comment-image').hide(500);
                $('.comment-mention').hide(500);
                $('.chat-input').animate({'height': '87px'}, 'slow');
                $('.Editor-editor').animate({'height': '35px'}, 'slow');
                updateCommentDetails.length = 0;
                $(".submit-cancelEDit").hide();

            }else if ($(this).attr("data-type") == "newComment"){
                var dt = new Date();
                var current_time_id = dt.getFullYear()+':'+(dt.getMonth()+1)+':'+dt.getDate()+":"+dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

                $('.Editor-editor').html('');
                $('.submit-comment').hide(500);
                $('#menuBarDiv_comment_details').hide(500);
                $('.upload-comment-image').hide(500);
                $('.comment-mention').hide(500);
                $('.chat-input').animate({'height': '87px'}, 'slow');
                $('.Editor-editor').animate({'height': '35px'}, 'slow');

                // firebase.database().ref('sections/'+project_id+'/'+section_id+'/discussions/'+discussion_id+'/comments').push().set({
                //     user_id:user_id,
                //     comments:comments,
                //     date:date,
                //     liked: 0,
                //     mentioned_users: mentioned_users,
                //     mentioned_groups: mentioned_groups,
                //     comment_mention_id:current_time_id

                // }).then(function(comments){
                //     // $('.Editor-editor').html('');
                //     // $('.submit-comment').hide(500);
                //     // $('#menuBarDiv_comment_details').hide(500);
                //     // $('.upload-comment-image').hide(500);
                //     // $('.comment-mention').hide(500);
                //     // $('.chat-input').animate({'height': '87px'}, 'slow');
                //     // $('.Editor-editor').animate({'height': '35px'}, 'slow');

                // }).catch(function(error){
                //     swal({
                //         title: "Error!",
                //         text: error.message,
                //         type: "warning",
                //         buttons: true,
                //         dangerMode: true,
                //         confirmButtonColor: '#5fb644',
                //     })
                // });

                $.ajax({
                    url: '{{ url("project_management_section_discussion_comment/store") }}',
                    method: 'POST',
                    data: {
                        section_id:section_id,
                        section_discussion_id:discussion_id,
                        comment:comments,
                        mentioned_users: mentioned_users,
                        mentioned_groups: mentioned_groups,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        appendNewComment(project_id, section_id, discussion_id, data)
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

            $.ajax({
                url: "{{ url('order_details/mention_users') }}",
                type: "POST",
                data: {
                    'project_id':project_id, 'mentioned_users':mentioned_users, 'mentioned_groups':mentioned_groups, 'discussion_id':discussion_id, 'discussion_title':discussion_title, 'comments':comments, '_token':'{{csrf_token()}}','comment_mention_id':current_time_id
                },
                success: function (data) {
                    // console.log(data);
                    $('#mentioned_users').val('');
                    $('#mentioned_groups').val('');
                }
            });
        }
    });

    // Toggle add discussion menu
    $('#discussion_dropdown_btn').on('click', function(){
        $('.discussion-dropdown').show();
    });

    // Create Section Name By Enter Key
    $('body').on('keypress', '#section_name', function (e) {
        if(e.which === 13){
            if ($('#section_name').val() == '') {
                $('#new_section_row').hide();
                $('#section_name').val('');
                $('#section_name').unbind('click');

            } else {

                var project_id = $('#discussion_project_id').val();
                var section_name = $('#section_name').val();
                var user_id = $('#discussion_user_id').val();
                var enterSection = 1;
                $( ".section-name" ).each(function() {
                    if($(this).val() == section_name)
                    {
                        enterSection = 0;
                    }
                });

                if(enterSection == 1)
                {
                    $.ajax({
                        url: '{{ url("project_management_section/store") }}',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            project_id: project_id,
                            section_name: section_name,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            console.log(data);

                            $('#new_section_row').hide();
                            $('#section_name').val('');
                            $('#section_name').unbind('click');
                            displaySingleSection(data);
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
                    // firebase.database().ref('sections/' + project_id).push().set({
                    //     project_id:project_id,
                    //     section_name:section_name,
                    //     assignee_id:'',
                    //     due_date:'',
                    //     user_id:user_id,

                    // }).then(function(sections){
                    //     $('#new_section_row').hide();
                    //     $('#section_name').val('');
                    //     $('#section_name').unbind('click');

                    // }).catch(function(error){
                    //     swal({
                    //         title: "Error!",
                    //         text: error.message,
                    //         type: "warning",
                    //         buttons: true,
                    //         dangerMode: true,
                    //         confirmButtonColor: '#5fb644',
                    //     })
                    // });
                }
                else{
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
        }
    });

    // Rename a Section
    $('body').on('change', '.section-name', function(){
        var section_name = $(this).val();
        var section_id = $(this).data('id');
        var project_id = $(this).data('order');

        $.ajax({
            url: '{{ url("project_management_section/update") }}/'+section_id,
            method: 'POST',
            // dataType: 'json',
            data: {
                section_name: section_name,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
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

        // firebase.database().ref('sections/' + project_id + '/' + section_id ).update({
        //     section_name:section_name
        // })
        // .catch(function(error){
        //     swal({
        //         title: "Error!",
        //         text: error.message,
        //         type: "warning",
        //         buttons: true,
        //         dangerMode: true,
        //         confirmButtonColor: '#5fb644',
        //     })
        // });
    });

    // Discussion Section Name By Enter Key
    $('body').on('keypress', '#discussion_name', function (e) {
        if(e.which === 13){
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
                $( ".discussion-name" ).each(function() {
                    if($(this).attr("data-id") == section_id && $(this).val() == discussion_name)
                    {
                        enterSectionDiscussion = 0;
                    }
                });

                if(enterSectionDiscussion == 1)
                {
                    $.ajax({
                        url: '{{ url("project_management_section_discussion/store") }}',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            project_id: project_id,
                            section_id: section_id,
                            discussion_name:discussion_name,
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
                                parentMinButton.toggleClass('rotate');
                                $parentRow.data('section-loaded', true); // Mark as loaded
                            }
                            displaySectionDiscussionsBySectionId(section_id);

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

                    // firebase.database().ref('sections/' + project_id + '/' + section_id + '/discussions').push().set({
                    //     project_id:project_id,
                    //     section_id:section_id,
                    //     discussion_name:discussion_name,
                    //     assignee_id:'',
                    //     discussion_description:'',
                    //     due_date:'',
                    //     user_id:user_id,

                    // }).then(function(discussions){
                    //     $('#discussion_name').val('');
                    //     $('#new_discussion_input').remove();
                    //     $('#discussion_name').unbind('click');

                    // }).catch(function(error){
                    //     swal({
                    //         title: "Error!",
                    //         text: error.message,
                    //         type: "warning",
                    //         buttons: true,
                    //         dangerMode: true,
                    //         confirmButtonColor: '#5fb644',
                    //     })
                    // });
                }
                    else
                {
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
        }
    });

    $(document).mouseup(function(e){
        if (!$('.discussion-dropdown').is(e.target) && $('.discussion-dropdown').has(e.target).length === 0) {
            $('.discussion-dropdown').hide();
            $('.discussion-dropdown').unbind('click');
        }

        // Save new section to Firebase
        // if(!$('#section_name').is(e.target) && $('#section_name').has(e.target).length === 0){
        //     if ($('#section_name').val() == '') {
        //         $('#new_section_row').hide();
        //         $('#section_name').val('');
        //         $('#section_name').unbind('click');

        //     } else {
        //         var project_id = $('#discussion_project_id').val();
        //         var section_name = $('#section_name').val();
        //         var user_id = $('#discussion_user_id').val();

        //         var enterSection = 1;
        //         $( ".section-name" ).each(function() {
        //             if($(this).val() == section_name)
        //             {
        //                 enterSection = 0;
        //                 return;
        //             }
        //         });
        //         if(enterSection == 1)
        //         {
        //             firebase.database().ref('sections/' + project_id).push().set({
        //                 project_id:project_id,
        //                 section_name:section_name,
        //                 assignee_id:'',
        //                 due_date:'',
        //                 user_id:user_id,

        //             }).then(function(sections){
        //                 $('#new_section_row').hide();
        //                 $('#section_name').val('');
        //                 $('#section_name').unbind('click');

        //             }).catch(function(error){
        //                 swal({
        //                     title: "Error!",
        //                     text: error.message,
        //                     type: "warning",
        //                     buttons: true,
        //                     dangerMode: true,
        //                     confirmButtonColor: '#5fb644',
        //                 })
        //             });
        //         }
        //         else{
        //             //$('#new_section_row').hide();
        //                 $('#section_name').val('');
        //                 $('#section_name').unbind('click');
        //                 swal({
        //                     title: "Section already available!",
        //                     text: "Note the sesction your are trying to create in already available.",
        //                     type: "info",
        //                     buttons: true,
        //                     dangerMode: true,
        //                     confirmButtonColor: '#5fb644',
        //                 })
        //         }
        //     }
        // }

        // Add a discussion to firebase
        // if(!$('#discussion_name').is(e.target) && $('#discussion_name').has(e.target).length === 0){
        //     if ($('#discussion_name').val() == '' || $('#discussion_name').val() == undefined) {
        //         $('#discussion_name').val('');
        //         $('#new_discussion_input').remove();
        //         $('#discussion_name').unbind('click');

        //     } else {
        //         var discussion_name = $('#discussion_name').val();
        //         var section_id = $('#discussion_name').data('section-id');
        //         var project_id = $('#discussion_name').data('order-id');
        //         var user_id = $('#discussion_user_id').val();

        //         var enterSectionDiscussion = 1;
        //         $( ".discussion-name" ).each(function() {
        //             if($(this).attr("data-id") == section_id && $(this).val() == discussion_name)
        //             {
        //                 enterSectionDiscussion = 0;
        //             }
        //         });
        //         if(enterSectionDiscussion == 1){
        //             firebase.database().ref('sections/' + project_id + '/' + section_id + '/discussions').push().set({
        //                 project_id:project_id,
        //                 section_id:section_id,
        //                 discussion_name:discussion_name,
        //                 assignee_id:'',
        //                 discussion_description:'',
        //                 due_date:'',
        //                 user_id:user_id,

        //             }).then(function(discussions){
        //                 $('#discussion_name').val('');
        //                 $('#new_discussion_input').remove();
        //                 $('#discussion_name').unbind('click');

        //             }).catch(function(error){
        //                 swal({
        //                     title: "Error!",
        //                     text: error.message,
        //                     type: "warning",
        //                     buttons: true,
        //                     dangerMode: true,
        //                     confirmButtonColor: '#5fb644',
        //                 })
        //             });
        //         }else{
        //             $('#new_discussion_input').remove();
        //             $('#discussion_name').unbind('click');
        //             swal({
        //                     title: "Discussion already available!",
        //                     text: "Note the discussion your are trying to create is already available in same section.",
        //                     type: "info",
        //                     buttons: true,
        //                     dangerMode: true,
        //                     confirmButtonColor: '#5fb644',
        //             })
        //         }


        //     }
        // }

        if(!$('#chatbox').is(e.target) && $('#chatbox').has(e.target).length === 0 && $("#file_preview_modal").has(e.target).length === 0 && e.target.getAttribute('class') !== "cGcvT"){
            if(!$('.swal2-modal').is(e.target) && $('.swal2-modal').has(e.target).length === 0){
                $('#menuBarDiv_comment_details').hide();
                $('.submit-comment').hide();
                $('.upload-comment-image').hide();
                $('.comment-mention').hide();
                $('.Editor-editor').animate({'height': '35px'}, 'slow');
                $('.chat-input').animate({'height': '87px'}, 'slow');
                $(".chat-close").click();
            }
        }

        // Add discussion description to database
        if(!$('#discussion_description').is(e.target) && $('#discussion_description').has(e.target).length === 0){
            if ($('#discussion_description').val() == '' || $('#discussion_description').val() == undefined) {
                $('#discussion_description').unbind('click');

            } else {

                var discussion_description = $('#discussion_description').val();
                var discussion_id = $('#chat_discussion_id').val();
                var section_id = $('#chat_section_id').val();
                var project_id = $('#discussion_project_id').val();

                // firebase.database().ref('sections/' + project_id + '/' + section_id + '/discussions/' + discussion_id).update({
                //     discussion_description:discussion_description,
                // }).catch(function(error){
                //     swal({
                //         title: "Error!",
                //         text: error.message,
                //         type: "warning",
                //         buttons: true,
                //         dangerMode: true,
                //         confirmButtonColor: '#5fb644',
                //     })
                // });
                $.ajax({
                    url: '{{ url("project_management_section_discussion/update") }}/'+discussion_id,
                    method: 'POST',
                    data: {
                        discussion_description:discussion_description,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
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
            }
        }
    });

    // Add a new section
    $('#add_section').on('click', function(){
        $('#new_section_row').show();
    });

    // Add a new discussion
    $('body').on('click', '.add-section-discussion', function(){
        var sectionId = $(this).data('id');
        var orderId = $(this).data('order');

        var row = '<tr id="new_discussion_input">'+
                  '<td>'+
                    // '<button type="button" class="btn btn-sm btn-secondary min-btn" data-id="1"><i class="fas fa-caret-right"></i></button>'+
                    '<input type="text" class="form-control discussion-control" name="discussion_name" id="discussion_name" data-section-id="'+sectionId+'" data-order-id="'+orderId+'" />'+
                  '</td><td></td><td></td></tr>';
        $('.parent-row#parent_section_'+sectionId).after(row);
    });

    // Upload image
    // $('body').on('change', '#comment-file', function(e) {
    //     for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {

    //         var file = e.originalEvent.srcElement.files[i];
    //         var img = document.createElement("img");
    //         var reader = new FileReader();
    //         reader.onloadend = function() {
    //             img.src = reader.result;
    //         }
    //         reader.readAsDataURL(file);
    //         $('.Editor-editor').append(img);
    //     }
    // });

    $('body').on('keydown', '.Editor-editor', function(e){
        //String.fromCharCode(e.which)
        //alert(e.key == "@");

        $(".mentags").each(function(){$(this).css({"display": "block"});});

        if(e.key == "@"){
           // $(".mention-dropdown-content").show().css({left:a,top:b});
            //$(".mention-dropdown-content").css({left:a,top:b});

            $(".mention-dropdown-content2").css({"display": "none"});
            $('.Editor-editor').after($(".mention-dropdown-content2"));
            setMenDivLocation();

            return true;
        }else{
            $(".mention-dropdown-content2").css("display", "none");
        }

        reloadMentionBox(e);
        return true;

    });

    function reloadMentionBox(e){
        var text;

        if(e.key.length==1){
            text=$('.Editor-editor').html()+e.key;
        }else{
            text=$('.Editor-editor').html();
        }

        // text=text.replaceAll("<div>","").replaceAll("</div>","");
        text=text.replace(/(<([^>]+)>)/ig,"").replaceAll("&nbsp;"," ");

        if(text.indexOf("@") >= 0){
            const name_array=text.split("@");
            const per_name = name_array[name_array.length-1];

            var showdiv=0;

            $(".mentags").each(function(){
                var $item = $(this);
                var itemAsText = $item.text().toLowerCase();

                if(itemAsText.indexOf(per_name.toLowerCase()) >= 0) {
                    showdiv=1;
                    $(this).css({"display": "block"});
                }else{
                    $(this).css({"display": "none"});
                }
            });

            if(showdiv==1){
                setMenDivLocation();
            }

        }

    }


    function setMenDivLocation(){
        var txt=$('.Editor-editor').html().replaceAll("<a href=\"#\">","").replaceAll("</a>","").replaceAll("&nbsp;"," ");

        var len=txt.length;
        var mar_lef=len*5;
        var hei=150;

        var arryDivTag=txt.split("<div>");

        if(arryDivTag.length>1){
            hei=hei-(arryDivTag.length*15);
            var lastDivText=arryDivTag[(arryDivTag.length)-1].replaceAll("</div>","");
            mar_lef=(lastDivText.length)*5;
        }

        $(".mention-dropdown-content2").css({"display": "block"});
        $('.mention-dropdown-content2').css({ 'margin-left': mar_lef+'px','margin-top': '10px','bottom':'1px','height':hei+'px','width':'200px' });
    }



    /*$(".Editor-editor").keydown(function (e) {
        alert("srre");
    });
*/
    // Mention Users
    $('body').on('click', '.mention-user', function(){

    /*
        var string = $('.Editor-editor').text();
        var last = string.charAt(string.length-1);
        if(last == "@")
        {
            alert("dfdg");
            $('.Editor-editor').text(string.substring(0, string.length-1));
        }
    */

        var user_id = $(this).data('mentioned-user-id');


        if(user_id == 0){
            var group_name = $(this).data('mentioned-group-name');
            var mentioned_group = '<a href="#">'+group_name+' </a>';
            $('.Editor-editor').append(mentioned_group);

            var group_id = $(this).data('mentioned-group-id');
            var mentioned_groups = $('#mentioned_groups').val();
            if(mentioned_groups == ''){
                var mentioned_group_ids = [];
                mentioned_group_ids.push(group_id);
                $('#mentioned_groups').val(mentioned_group_ids);

            } else {
                var mentioned_group_ids = [mentioned_groups];
                mentioned_group_ids.push(group_id);
                $('#mentioned_groups').val(mentioned_group_ids);
            }
        } else {
            var user_name = $(this).data('mentioned-user-name');
            var mentioned_user = '<a href="#">'+user_name+' </a>';
            $('.Editor-editor').append(mentioned_user);

            var mentioned_users = $('#mentioned_users').val();
            if(mentioned_users == ''){
                var mentioned_user_ids = [];
                mentioned_user_ids.push(user_id);
                $('#mentioned_users').val(mentioned_user_ids);

            } else {
                var mentioned_user_ids = [mentioned_users];
                mentioned_user_ids.push(user_id);
                $('#mentioned_users').val(mentioned_user_ids);
            }
        }
        $(".mention-dropdown-content2").css("display", "none");
    });

    $('body').on('click', '.mention-user2', function(){

    /*
        var string = $('.Editor-editor').text();
        var last = string.charAt(string.length-1);
        if(last == "@")
        {
            alert("dfdg");
            $('.Editor-editor').text(string.substring(0, string.length-1));
        }
    */

        var div_text=$('.Editor-editor').html();
        if(div_text.indexOf("@") >= 0){
            const name_array=div_text.split("@");
            const per_name = name_array[name_array.length-1];
            div_text=div_text.replace(("@"+per_name), "@");
            $('.Editor-editor').html(div_text);
        }

        var user_id = $(this).data('mentioned-user-id');
        // console.log(user_id);
        if(user_id == 0){
            var group_name = $(this).data('mentioned-group-name');
            var mentioned_group = '<a href="#">'+group_name+' </a>';

            // $('.Editor-editor').append(mentioned_group);

            var edTxt=$('.Editor-editor').html().split("@</div>");
            if(edTxt.length>1){
                $('.Editor-editor').html(edTxt[0]+"@"+mentioned_group+"</div>");
            }else{
                $('.Editor-editor').append(mentioned_group);
            }

            var group_id = $(this).data('mentioned-group-id');
            var mentioned_groups = $('#mentioned_groups').val();
            if(mentioned_groups == ''){
                var mentioned_group_ids = [];
                mentioned_group_ids.push(group_id);
                $('#mentioned_groups').val(mentioned_group_ids);

            } else {
                var mentioned_group_ids = [mentioned_groups];
                mentioned_group_ids.push(group_id);
                $('#mentioned_groups').val(mentioned_group_ids);
            }

        } else {
            var user_name = $(this).data('mentioned-user-name');
            var mentioned_user = '<a href="#">'+user_name+' </a>';

            // $('.Editor-editor').append(mentioned_user);

            var edTxt=$('.Editor-editor').html().split("@</div>");
            if(edTxt.length>1){
                $('.Editor-editor').html(edTxt[0]+"@"+mentioned_user+"</div>");
            }else{
                $('.Editor-editor').append(mentioned_user);
            }

            var mentioned_users = $('#mentioned_users').val();
            if(mentioned_users == ''){
                var mentioned_user_ids = [];
                mentioned_user_ids.push(user_id);
                $('#mentioned_users').val(mentioned_user_ids);

            } else {
                var mentioned_user_ids = [mentioned_users];
                mentioned_user_ids.push(user_id);
                $('#mentioned_users').val(mentioned_user_ids);
            }
        }
        $(".mention-dropdown-content2").css("display", "none");
    });

    $('body').on('click', '.comment-content img', function(){
        var file = $(this).attr('src');
        $('#file_preview_modal').modal('show');
        $('#comment_file_preview').attr('src', file);
        $('#comment_file_src').attr('href', file);

        var attr = $(this).attr('file_real_name');

        if(typeof attr !== 'undefined' && attr !== false) {
            $('#comment_file_src').attr('download', $(this).attr("file_real_name"));
        }else{
            $('#comment_file_src').attr('download', "Encroms-media");
        }

    });

    // Delete a Section
    $('body').on('click', '.delete-section-discussion', function(){
        var section_id = $(this).data('id');
        var project_id = $(this).data('order');

        Swal.fire({
            title: "Confirm Delete?",
            text: "Do You Want to Delete This Section Discussion?",
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
                    url: '{{ url("project_management_section/delete") }}/'+section_id,
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
    $('body').on('click', '.delete-discussion', function(){
        var section_id = $(this).data('id');
        var project_id = $(this).data('order');
        var discussion_id = $(this).data('discussion');


        //alert($(this).data('discussion') +" " + $(this).attr('data-discussionName') );

        // if($(this).attr('data-sectionName') == "Discussion" && $(this).attr('data-discussionName') == "Additional Notes") {

        // } else if($(this).attr('data-sectionName') == "Production Layouts" && $(this).attr('data-discussionName') == "Customer Approval") {

        // } else if($(this).attr('data-sectionName') == "Estimated Shipping Date" && $(this).attr('data-discussionName') == "Factory Confirmation") {

        // } else if($(this).attr('data-sectionName') == "Shipping Details" && $(this).attr('data-discussionName') == "For Packing Team") {

        // } else{
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


                    // firebase.database().ref('sections/' + project_id + '/' + section_id + '/discussions/' + discussion_id).remove()
                    // .catch(function(error){
                    //     swal({
                    //         title: "Error!",
                    //         text: error.message,
                    //         type: "warning",
                    //         buttons: true,
                    //         dangerMode: true,
                    //         confirmButtonColor: '#5fb644',
                    //     })
                    // });

                    $.ajax({
                        url: '{{ url("project_management_section_discussion/delete") }}/'+discussion_id,
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
        // }



    });

    // Delete a Comment
    $('body').on('click', '.btn-delete-comment', function(){
        var section_id = $(this).data('comment-section-id');
        var project_id = $(this).data('comment-order-id');
        var discussion_id = $(this).data('comment-discussion-id');
        var comment_id = $(this).data('comment-id');

        Swal.fire({
            title: "Confirm Delete?",
            text: "Do You Want to Delete This Comment?",
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
                    url: '{{ url("project_management_section_discussion_comment/delete") }}/'+comment_id,
                    method: 'GET',
                    success: function(data) {
                        $('#comment_row_'+comment_id).fadeOut(400, function() {
                            $(this).remove();
                        });
                        updateCommentCount(discussion_id);
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

    // var chatVisible = "false";
    // window.addEventListener('click', function(e){
    //     if(!$('#chatbox:visible').length == 0) {
    //         if (!document.getElementById('chatbox').contains(e.target) && chatVisible == "true"){
    //             $(".chat-close").click();
    //             chatVisible = "false";

    //         }else{
    //             if(e.target.title == "Close details" || e.target.className == "fas fa-sign-in-alt")  {
    //                 chatVisible = "false";
    //             } else{
    //                 chatVisible = "true";
    //             }
    //         }
    //     }
    // });

    // Add due date to a Discussion
    $('body').on('change', '.discussion-due-date', function(){
        var due_date = $(this).val();
        var section_id = $(this).data('id');
        var project_id = $(this).data('order');
        var discussion_id = $(this).data('discussion');

        $.ajax({
            url: '{{ url("project_management_section_discussion/update") }}/'+discussion_id,
            method: 'POST',
            data: {
                due_date:due_date,
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

    $('body').on('change', '#discussion_due_date', function(){
        var due_date = $(this).val();
        var discussion_id = $('#chat_discussion_id').val();
        var section_id = $('#chat_section_id').val();
        var project_id = $('#discussion_project_id').val();

        $.ajax({
            url: '{{ url("project_management_section_discussion/update") }}/'+discussion_id,
            method: 'POST',
            data: {
                due_date:due_date,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                $('.discussion-due-date[data-discussion="' + discussion_id + '"]').val(due_date);
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

    // Rename a Discussion
    $('body').on('change', '.discussion-name', function(){
        var discussion_name = $(this).val();
        var section_id = $(this).data('id');
        var project_id = $(this).data('order');
        var discussion_id = $(this).data('discussion');

        if(discussion_name.length != 0){
            $.ajax({
                url: '{{ url("project_management_section_discussion/update") }}/'+discussion_id,
                method: 'POST',
                data: {
                    'discussion_name': discussion_name,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
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
        }else{
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

    $('body').on('change', '#discussion_description', function(){
        var discussion_description = $(this).val();
        var discussion_id = $('#chat_discussion_id').val();

        $.ajax({
            url: '{{ url("project_management_section_discussion/update") }}/'+discussion_id,
            method: 'POST',
            data: {
                discussion_description:discussion_description,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
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

    $('body').on('change', '#discussion_title', function(){
        var discussion_name = $(this).val();
        var discussion_id = $('#chat_discussion_id').val();
        var section_id = $('#chat_section_id').val();
        // var project_id = $('#discussion_project_id').val();

        $.ajax({
            url: '{{ url("project_management_section_discussion/update") }}/'+discussion_id,
            method: 'POST',
            data: {
                'discussion_name': discussion_name,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                $(this).trigger('focusout');
                $('.discussion-name[data-discussion="' + discussion_id + '"]').val(discussion_name);
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

    // Add assignee to a Discussion
    $('body').on('change', '.discussion-assignee-name', function(){
        var assignee_id = $(this).val();
        var section_id = $(this).data('id');
        var project_id = $(this).data('order');
        var discussion_id = $(this).data('discussion');

        $.ajax({
            url: '{{ url("project_management_section_discussion/update") }}/'+discussion_id,
            method: 'POST',
            data: {
                assignee_id:assignee_id,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                $(this).trigger('focusout');
                // displayAllSections();
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

    $('body').on('change', '#discussion_assignee_name', function(){
        var assignee_id = $(this).val();
        var discussion_id = $('#chat_discussion_id').val();
        var section_id = $('#chat_section_id').val();
        var project_id = $('#discussion_project_id').val();

        $.ajax({
            url: '{{ url("project_management_section_discussion/update") }}/'+discussion_id,
            method: 'POST',
            data: {
                assignee_id:assignee_id,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                $('.discussion-assignee-name[data-discussion="' + discussion_id + '"]').val(assignee_id).trigger('change');
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

    // Like / Unlike a Comment
    $('body').on('click', '.like-btn', function(){
        var section_id = $(this).data('comment-section-id');
        var project_id = $(this).data('comment-order-id');
        var discussion_id = $(this).data('comment-discussion-id');
        var comment_id = $(this).data('comment-id');
        var liked_status = $(this).val();

        if (liked_status == 0) {
            var liked = 1;
            var comment_liked = '<i class="fas fa-thumbs-up"></i>';
        } else {
            var liked = 0;
            var comment_liked = '<i class="far fa-thumbs-up"></i>';
        }

        // firebase.database().ref('sections/'+project_id+'/'+section_id+'/discussions/'+discussion_id+'/comments/'+comment_id).update({
        //     liked: liked
        // })
        // .catch(function(error){
        //     swal({
        //         title: "Error!",
        //         text: error.message,
        //         type: "warning",
        //         buttons: true,
        //         dangerMode: true,
        //         confirmButtonColor: '#5fb644',
        //     })
        // });
        $.ajax({
            url: '{{ url("project_management_section_discussion_comment/update") }}/'+comment_id,
            method: 'POST',
            data: {
                is_liked: liked,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
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
        $(this).html(comment_liked);

    });

    function uploadMultipleTypeFiles(){
    console.log('calling');

        var file_location = $("#file_location").val();

        var dt = new Date();
        var fileID = dt.getMinutes() + "_" + dt.getSeconds();

        var file = document.querySelector("input[type=file]").files[0];

        var extension = file.name.substr( (file.name.lastIndexOf('.') +1) );

        // switch(extension) {
        //     case 'jpg':
        //     case 'jpeg':
        //     case 'png':
        //     case 'gif':

        //     break;

        //     default:

                var formData = new FormData();
                if($('#comment-file').val()) {
                    formData.append("upload_file", $("#comment-file")[0].files[0]);
                    // formData.append("upload_file_name", file.name.split('.')[0]);
                    formData.append("upload_file_name", file.name);
                    formData.append("project_id", $("#project_id").val());

                    var file_size = $("#comment-file")[0].files[0].size / 1048576; // size in mb

                    console.log('uploaded');

                    $.ajax({
                        url: '{{ route("project_management_section_discussion_comment.file_upload") }}',
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function(data) {
                            console.log(data);
                        },
                        complete: function() {
                            $(".se-pre-con").fadeOut('slow');
                        }
                    });
                }
        // }
    }

    // function uploadFile() {
    //     var file_location = $("#file_location").val();

    //     var file_count = document.querySelector("input[type=file]").files.length;

    //     for(var i = 0; i < file_count; i++){

    //         var dt = new Date();
    //         var fileID = dt.getMinutes() + "_" + dt.getSeconds() + "_" + dt.getMilliseconds();

    //         alert(fileID);

    //         var file = document.querySelector("input[type=file]").files[i];

    //         var extension = file.name.substr( (file.name.lastIndexOf('.') +1) );

    //         switch(extension) {
    //             case 'jpg':
    //             case 'jpeg':
    //             case 'png':
    //             case 'gif':

    //                 $('.Editor-editor').html($('.Editor-editor').html()+"<div><img id='tag_img_"+fileID+"' file_real_name='"+file.name.split('.')[0]+"'/></div><div></div>");
    //                 var image_preview = document.getElementById("tag_img_"+fileID);

    //                 var reader = new FileReader();
    //                 reader.onloadend = function () {
    //                     image_preview.src = reader.result;
    //                     document.getElementById("base64").value = reader.result;
    //                 };

    //                 alert($('.Editor-editor').html());

    //                 if (file) {
    //                     reader.readAsDataURL(file);
    //                 } else {
    //                     image_preview.src = "";
    //                 }
    //             break;

    //             default:

    //                 var icon;

    //                 if(extension == 'pdf'){
    //                     icon = file_location+"argon/img/icons/pdf_icon.png";
    //                 }else if(extension == 'zip'){
    //                     icon = file_location+"argon/img/icons/zip.png";
    //                 }else if(extension == 'mkv'){
    //                     icon = file_location+"argon/img/icons/mkv.png";
    //                 }else if(extension == 'mp3'){
    //                     icon = file_location+"argon/img/icons/mp3.png";
    //                 }else if(extension == 'mp4'){
    //                     icon = file_location+"argon/img/icons/mp4.png";
    //                 }else if(extension == 'sheets' || extension == 'ods'){
    //                     icon = file_location+"argon/img/icons/sheets.png";
    //                 }else if(extension == 'slides'){
    //                     icon = file_location+"argon/img/icons/slides.png";
    //                 }else{
    //                     icon = file_location+"argon/img/icons/docs.png";
    //                 }

    //                 // var formData = new FormData();
    //                 // if($('#comment-file').val()) {
    //                 //     formData.append("upload_file", $("#comment-file")[0].files[0]);
    //                 //     // formData.append("upload_file_name", file.name.split('.')[0]);
    //                 //     formData.append("upload_file_name", file.name);
    //                 //     formData.append("project_id", $("#project_id").val());
    //                 // }

    //                 var file_size = $("#comment-file")[0].files[0].size / 1048576; // size in mb
    //                 $('.Editor-editor').html($('.Editor-editor').html()+"<br/><div style='background-color:#E9E8E8;padding:8px;opacity: 0.8;'><img src='"+icon+"' style='width:30px; height:35px;'>"+file.name+" ("+file_size.toFixed(2)+"MB)<a href='"+file_location+"uploads/uploaded_files/"+$("#project_id").val()+"/"+file.name+"' style='float: right;margin-right:20px' title='download' download><i class='fas fa-download chat-download-icon' style='font-size:22px;margin-top:6px;'></i></a></div><br/>");

    //         }
    //     }
    // }

    const fileInput = document.getElementById('comment-file')

    fileInput.addEventListener('change', async (event) => {

        var files = event.srcElement.files;
        var file_location = $("#file_location").val();

        const filePromises = Object.entries(files).map(item => {
            return new Promise((resolve, reject) => {

                const [index, file] = item
                const reader = new FileReader();
                reader.readAsDataURL(file);

                reader.onload = function(event) {

                    var extension = file.name.substr( (file.name.lastIndexOf('.') +1) );

                    var dt = new Date();
                    var fileID = dt.getMinutes() + "_" + dt.getSeconds() + "_" + dt.getMilliseconds();

                    switch(extension) {
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                        case 'gif':

                            $('.Editor-editor').html($('.Editor-editor').html()+"<div><img id='tag_img_"+fileID+"' file_real_name='"+file.name.split('.')[0]+"'/></div><div></div>");
                            var image_preview = document.getElementById("tag_img_"+fileID);
                            image_preview.src = event.target.result;

                        break;

                        default:

                            var icon;

                            if(extension == 'pdf'){
                                icon = file_location+"argon/img/icons/pdf_icon.png";
                            }else if(extension == 'zip'){
                                icon = file_location+"argon/img/icons/zip.png";
                            }else if(extension == 'mkv'){
                                icon = file_location+"argon/img/icons/mkv.png";
                            }else if(extension == 'mp3'){
                                icon = file_location+"argon/img/icons/mp3.png";
                            }else if(extension == 'mp4'){
                                icon = file_location+"argon/img/icons/mp4.png";
                            }else if(extension == 'sheets' || extension == 'ods'){
                                icon = file_location+"argon/img/icons/sheets.png";
                            }else if(extension == 'slides'){
                                icon = file_location+"argon/img/icons/slides.png";
                            }else{
                                icon = file_location+"argon/img/icons/docs.png";
                            }

                            var file_size = file.size / 1048576; // size in mb
                            var donwloadName = (file.name).replace(/'/g, ' ');
                            $('.Editor-editor').html($('.Editor-editor').html()+"<br/><div style='background-color:#E9E8E8;padding:8px;opacity: 0.8;'><img src='"+icon+"' style='width:30px; height:35px;'>"+file.name+" ("+file_size.toFixed(2)+"MB)<a href='"+file_location+"uploads/uploaded_files/"+$("#project_id").val()+"/"+donwloadName+"' style='float: right;margin-right:20px' title='download' download><i class='fas fa-download chat-download-icon' style='font-size:22px;margin-top:6px;'></i></a></div><br/>");

                    }

                };

            })
        })

    })

    function message_text_change(e){
        var text_length = $(e).val().length;

        if(text_length > 50){
            text_length = 50;
        }else if(text_length < 10){
            text_length = 10;
        }
        $(e).width(text_length*8);
    }

</script>
