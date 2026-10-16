<style>
    .task-attachments-section {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .task-attachments-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .task-attachments-title {
        font-weight: 600;
        color: #32325d;
        font-size: 0.9rem;
    }
    .task-attachments-count {
        background: #e9ecef;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.8rem;
        color: #525f7f;
    }
    .add-attachment-btn {
        cursor: pointer;
        color: #5e72e4;
        font-size: 1.1rem;
        transition: transform 0.2s;
    }
    .add-attachment-btn:hover {
        transform: scale(1.2);
    }
    .task-attachments-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .task-attachment-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 0;
        text-decoration: none !important;
        color: #525f7f;
        font-size: 0.85rem;
        transition: color 0.2s;
        cursor: pointer;
    }
    .task-attachment-item:hover {
        color: #5e72e4;
        text-decoration: underline !important;
    }
    .task-attachment-icon {
        font-size: 1rem;
        width: 20px;
        text-align: center;
    }
    .task-attachment-name {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 250px;
    }
    .attachment-download-btn {
        margin-left: 0;
        padding: 4px 8px;
        border-radius: 4px;
        background: #f0f2ff;
        transition: all 0.2s;
    }
    .attachment-download-btn:hover {
        background: #e0e3ff;
        color: #4c63d4 !important;
    }
    .attachment-delete-btn {
        margin-left: 0;
        padding: 4px 8px;
        border-radius: 4px;
        background: #ffebee;
        color: #c62828 !important;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.85rem;
    }
    .attachment-delete-btn:hover {
        background: #ffcdd2;
        color: #b71c1c !important;
    }

    /* Priority Dropdown Styling */
    #discussion_priority {
        background-color: transparent;
        border-top: 0;
        border-left: 0;
        border-right: 0;
        border-bottom: 1px solid #d2d2d2;
        padding: 4px 0;
        font-size: 14px;
        color: #333;
        transition: all 0.2s ease;
        width: auto;
    }

    #discussion_priority:focus {
        outline: none;
        border-color: #4f4f4f;
        box-shadow: none;
    }

    /* Priority Badge Styling for list view */
    .priority-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 8px;
    }

    .priority-critical {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ef5350;
    }

    .priority-high {
        background-color: #fff3e0;
        color: #e65100;
        border: 1px solid #ffb74d;
    }

    .priority-medium {
        background-color: #fff9c4;
        color: #f57f17;
        border: 1px solid #fdd835;
    }

    .priority-low {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #66bb6a;
    }

    .priority-display-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
    }

    .priority-display-wrapper select {
        flex: 0 1 auto;
        min-width: 120px;
    }

    .current-priority-badge {
        white-space: nowrap;
        min-width: 60px;
        text-align: center;
        font-size: 12px;
        padding: 4px 8px;
    }

    .inbox-tabs {
        display: flex;
        border-bottom: 1.5px solid #e0e0e0;
        background: rgba(50, 50, 50, 1) !important;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0;
    }
    .inbox-tab {
        color: #fff;
        background: none;
        border: none;
        padding: 0.7rem 1.5rem 0.7rem 1.5rem;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        transition: border-color 0.2s, color 0.2s;
    }
    .inbox-tab.active {
        border-bottom: 3px solid #fff;
        color: #fff;
        background: transparent;
    }
    .inbox-searchbar {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.2rem 0 0.5rem 0;
        background: #fff;
        border-bottom: 1.5px solid #e0e0e0;
    }
    .inbox-searchbar input {
        border-radius: 20px;
        border: 1px solid #bbb;
        padding: 0.4rem 1.2rem;
        font-size: 0.8rem;
        width: 220px;
        background: #fafafa;
        max-width: 100%;
    }
    .inbox-searchbar .btn {
        font-size: 0.8rem;
        border-radius: 8px;
        padding: 0.3rem 1.1rem;
    }
    .inbox-list {
        background: #fafafa;
        min-height: 60vh;
        padding: 0;
        margin: 0;
    }
    .inbox-item {
        background: #fff;
        border-bottom: 1px solid #e0e0e0;
        padding: 1.1rem 1.5rem;
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: background 0.1s;
        font-size: 0.8rem;
    }
    .inbox-item:hover {
        background: #f5f5f5;
    }
    .inbox-item-header {
        display: flex;
        align-items: center;
        gap: 1.2rem;
    }
    .inbox-item-date {
        color: #888;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .inbox-item-title {
        font-weight: 600;
        color: #222;
        font-size: 0.8rem;
        flex: 1;
    }
    @media (max-width: 600px) {
        .inbox-tabs { flex-direction: column; }
        .inbox-searchbar { flex-direction: column; align-items: stretch; gap: 0.5rem; }
        .inbox-item-header { flex-direction: column; align-items: flex-start; gap: 0.2rem; }
        .inbox-item { padding: 1rem 0.7rem; }
    }

    .border_radius_left_top {
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    /* .make_complete_div {
        border-bottom: 1px solid rgb(236, 236, 236);
    } */
    .inbox-item.expanded {
        box-shadow: 0 4px 4px 0 #00000026;
        background: #F5F5F5;
    }
    .project_details_div {
        padding: 0.2rem 1rem;
        width: 100% !important;
        height: 2rem;
    }
    .make_complete_btn {
        padding: 2px 10px;
        border-radius: 4px;
        border: 1px solid rgb(205, 205, 205);
        background-color: transparent;
        color: gray;
    }

    .completed_btn {
        padding: 2px 10px;
        border-radius: 4px;
    }
    .project_name {
        font-size: 16px;
        font-weight: 600;
    }
    .project_details_gray {
        color: gray;
    }
    .text_area {
        width: 100%;
        border-radius: 5px;
        padding: 5px 10px;
    }
    .text_area_comment {
        width: 100%;
        border-radius: 5px;
        padding: 5px 10px;
        border: unset;
        background-color: transparent;
    }
    .add_section_btn {
        padding: 5px 12px;
        border-radius: 5px;
        border: 1px solid rgb(191, 191, 191);
        background-color: transparent;
    }
    .user_icon_pink {
        font-size: 30px;
        color: rgb(255, 158, 175);
    }
    .user_icon_blue {
        font-size: 30px;
        color: #5E79FF;
    }
    .user-task-info {
        display: flex;
        align-items: center; /* Vertically centers the items */
        gap: 6px;
        width: 100%;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgb(222, 222, 222);
    }
    .comment_textarea_div {
        width: 90%;
        padding: 5px;
        border: 1px solid rgb(162, 162, 162);
        border-radius: 5px;
        text-align: right;
    }
    #discussion_assignee_name {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        border: none;
        color: #727272;
        background: transparent;
        font-size: 14px;
    }
    #discussion_due_date {
        border-top: 0;
        border-left: 0;
        border-right: 0;
        border-bottom: 1px solid #d2d2d2;
        color: #727272;
        font-size: 14px;
    }
    .chat-input .collaborators img {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        overflow: hidden;
    }
    .chat-textbox td:first-child img,
    .chat-user-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        overflow: hidden;
    }
    .Editor-editor img {
        width: 60%;
    }
    .previous-chats-tbody td:nth-child(2) img {
        width: 80%;
        cursor: pointer;
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


    .mention-dropdown-content2{
        display: none;

        position: absolute;
        left: 140px !important;
        top: -11rem !important;
        width: 260px;
        max-height: 220px;
        overflow-y: auto;

        background: #fff;
        border: 1px solid #dcdcdc;
        border-radius: 10px;

        box-shadow: 0 8px 24px rgba(0,0,0,0.12);

        z-index: 999999;

        padding: 6px 0;
    }

    .mention-dropdown-content2 a{
        display: flex;
        align-items: center;
        gap: 10px;

        padding: 8px 12px;

        color: #222;
        font-size: 14px;
        text-decoration: none;

        transition: background 0.15s ease;
    }

    .mention-dropdown-content2 a:hover{
        background: #f5f5f5;
    }

.products-dropdown-content {
    display: none;
    position: absolute;
    left: 0;
    bottom: calc(100% + 4px);
    width: 340px;
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
    background: #fff;
    border: 1px solid #dcdcdc;
    border-radius: 10px;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.15);  /* shadow on top since opens upward */
    z-index: 999999;
    padding: 6px 0;
    scroll-padding-top: 6px;
}

.dropdown.user-dropdown {
    position: relative;
    overflow: visible !important;
}

/* Empty / loading message */
.products-dropdown-content .mention-empty {
    padding: 10px 14px;
    font-size: 13px;
    color: #888;
}

.products-dropdown-content a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 14px;
    color: #222;
    font-size: 13px;
    text-decoration: none;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.12s ease;
    cursor: pointer;
}

.products-dropdown-content a:last-child {
    border-bottom: none;
}

.products-dropdown-content a:hover {
    background: #f0f4ff;
    color: #3a56d4;
}

.products-dropdown-content a::before {
    content: '#';
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    background: #e8ecff;
    color: #4c63d4;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
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
        box-shadow: none !important;
        z-index: 1;
    }

    .comment-dropdown-content button {
       width: 100%;
       font-size: 12px;
       padding: 5px;
    }
    .comment-dropdown-content a:hover {
        background-color: #f1f1f1;
        box-shadow: none !important;
    }
    .comment-dropdown:hover .comment-dropdown-content {
        display: block;
         box-shadow: none !important;
    }
    .comment-dropdown:hover .comment-dropbtn {
        background-color: #ffffff;
        border: unset;
         box-shadow: none !important;

    }
    .comment-dropdown-content .btn:hover {
          box-shadow: none !important;
          transform: none !important;
    }
    .comment-dropbtn {
        border: unset;
        color: #212529;
        border-color: #f7fafc;
        background-color: #f7fafc;
        box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
        border-radius: 5px;
        padding: .25rem .5rem;
    }

    /* #inbox-right {
        position: fixed;
        top: 109px;
        right: 3px;
        height: 70vh;
        overflow-y: auto;
        z-index: 1000;
        background-color: #fff;
        width: 42%;
        border-left: 1px solid #ececec;
        padding: 1.5rem;
    } */

    /* Floating right panel modal */
   #inbox-right.modal {
    position: fixed;
    top: 8%;
    right: 0;
    left: auto;
    width: min(900px, 95vw);
    height: 86%;

    margin: 0;
    padding: 0.5rem 1rem;

    background: #fff;
    overflow-y: hidden !important;
    overflow-x: hidden !important;
    touch-action: pan-y !important;
    -webkit-overflow-scrolling: touch;

    z-index: 9999;

    box-shadow: -6px 0 10px -8px rgba(0,0,0,0.2);
}

div#inbox-right.modal {
    position: fixed !important;
    top: 8% !important;
    right: 0 !important;
    left: auto !important;
    width: min(900px, 95vw) !important;
    max-width: min(900px, 95vw) !important;
    height: 85% !important;
    margin: 0 !important;
    padding: 0.5rem 1rem !important;
    background: #fff !important;
    overflow: hidden !important;
    overflow-y: hidden !important;
    overflow-x: hidden !important;
    touch-action: pan-y !important;
    -webkit-overflow-scrolling: touch;
    z-index: 9999 !important;
    box-shadow: -6px 0 10px -8px rgba(0,0,0,0.2) !important;
}

@media (max-width: 767px) {
    div#inbox-right.modal {
        position: fixed !important;
        top: 65px !important;
        top: var(--mobile-nav-top, 65px) !important;
        bottom: 0 !important;
        right: 0 !important;
        left: auto !important;
        height: auto !important;
        max-height: none !important;
        overflow: hidden !important;
        overflow-y: hidden !important;
        overflow-x: hidden !important;
        touch-action: pan-y !important;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }
    div#inbox-right.modal::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }
    
    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="password"],
    input[type="search"],
    input[type="tel"],
    input[type="url"],
    input[type="date"],
    input[type="datetime-local"],
    input[type="time"],
    select,
    textarea,
    .form-control,
    .form-select,
    .select2-container .select2-selection--single,
    .select2-container .select2-selection--multiple,
    .selectize-input input,
    .Editor-editor,
    .chat-input,
    [contenteditable="true"] {
        font-size: 16px !important;
    }

    /* Shift bottom-fixed container up on mobile so submit/update button is fully visible */
    .bottom-fixed {
        position: relative !important;
        bottom: 25px !important;
        margin-bottom: 25px !important;
    }
}

    .bottom-fixed{
    width:100%;
}

.chat-textbox{
    width:100%;
    margin:0;
}

.comment-input-layout{
    width:100%;
}

.comment-editor-side{
    width:100%;
    min-width:0;
}

.comment-action-bar {
    width:100%;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    /* gap:10px; */
    margin-top: 0;
}

    #inbox-right .modal-dialog {
        margin: 0;
        max-width: 100%;
        height: 100%;
    }

    #inbox-right .modal-content {
        min-height: 100%;
        border: none;
        border-radius: 0;
    }
    .modal-content {
        box-shadow: unset !important;
    }
    .modal.right  {
        transform: translateX(100%);
        transition: transform 1s ease-out; /* <- 2 second animation */
    }

    .modal.right.show  {
        transform: translateX(0);
    }
    .modal.right.hide-animation  {
        transform: translateX(100%);
    }
    .padding_left_unset {
        padding-left: unset;
    }
    #inbox-right .modal-content {
        display: flex;
        flex-direction: column;
        height: 100% !important;
        max-height: 100% !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
        touch-action: pan-y !important;
        -webkit-overflow-scrolling: touch;
    }

    #inbox-right .modal-content .scrollable-section {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden !important;
        touch-action: pan-y !important;
        -webkit-overflow-scrolling: touch;
        margin-top: 10px;
        padding-top: 10px;
        /* padding-right: 6px; */
        cursor: grab;
        /* Ensure Firefox & standard scrollbar is styled & clearly visible */
        scrollbar-width: thin;
        scrollbar-color: #8898aa #e9ecef;
    }

    #inbox-right .modal-content .scrollable-section.is-dragging {
        cursor: grabbing !important;
        user-select: none !important;
    }

    /* Prominent, easy-to-see and easy-to-drag vertical scrollbar for Webkit/Blink */
    .scrollable-section::-webkit-scrollbar {
        width: 12px !important;
        display: block !important;
    }

    .scrollable-section::-webkit-scrollbar-track {
        background: #f1f3f5 !important;
        border-radius: 6px !important;
    }

    .scrollable-section::-webkit-scrollbar-thumb {
        background: #a0aec0 !important;
        border-radius: 6px !important;
        border: 2px solid #f1f3f5 !important;
        min-height: 35px !important;
        transition: background 0.2s ease;
    }

    .scrollable-section::-webkit-scrollbar-thumb:hover {
        background: #718096 !important;
    }

    .scrollable-section::-webkit-scrollbar-thumb:active {
        background: #4a5568 !important;
    }

    /* Preserve interactive cursors inside scrollable section */
    .scrollable-section input,
    .scrollable-section textarea,
    .scrollable-section select,
    .scrollable-section button,
    .scrollable-section a,
    .scrollable-section label,
    .scrollable-section .btn {
        cursor: auto;
    }

    .scrollable-section textarea,
    .scrollable-section input {
        cursor: text;
    }

    .scrollable-section button,
    .scrollable-section a,
    .scrollable-section select,
    .scrollable-section .btn {
        cursor: pointer;
    }

    #inbox-right .modal-content .top-fixed {
        position: relative;
        flex-shrink: 0;
        background: white;
        z-index: 10;
        padding-bottom: 10px;
        border-bottom: 1px solid rgb(236, 236, 236);
    }

    #inbox-right .modal-content .bottom-fixed {
        position: relative;
        flex-shrink: 0;
        background: white;
        z-index: 10;
        padding-bottom: 10px;
    }
    .modal-backdrop {
        display: none !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0;
        width: 215px !important;
    }

    .Editor-editor {
        width: auto;
    }

    div#inbox-right {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
                 Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
    }


   /* ===============================
   COMMENT ROW
================================ */
.comment-row {
    background: #fafafa;
    border-bottom: 1px solid #e6e6e6;
}

.comment-row td {
    border: none;
}

/* ===============================
   AVATAR
================================ */
.comment-avatar {
    width: 56px;
    padding: 14px 10px;
    vertical-align: top;
}

.chat-user-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
}

/* ===============================
   COMMENT CONTENT
================================ */
.comment-content {
    padding: 10px 0;
    display: flex;
    flex-direction: column;
}

/* header: name + date */
.comment-header {
    padding-top: 5px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
    line-height: 1.2;
}

.comment-author {
    font-weight: 600;
    font-size: 14px;
    color: #111;
    white-space: nowrap;
}

.comment-date {
    font-size: 12px;
    color: #8a8a8a;
    white-space: nowrap;
}

/* message bubble */
.comment-text {
    background: #f6f7f9;
    border-radius: 10px;
    padding: 10px 12px;
    font-size: 14px;
    line-height: 1.45;
    color: #333;
    max-width: 95%;
    margin-top: 4px;
}

/* ===============================
   COMMENT ACTIONS
================================ */
.comment-actions {
    width: 90px;
    padding: 12px 8px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 6px;
}

/* like + menu buttons */
.like-btn,
.comment-dropbtn {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 5px 7px;
    cursor: pointer;
}

.like-btn:hover,
.comment-dropbtn:hover {
    background: #f0f0f0;
}

/* ===============================
   DROPDOWN MENU
================================ */
.comment-dropdown {
    position: relative;
    display: inline-block;
}

.comment-dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 100%; /* attach directly */
    margin-top: 0; /* remove gap */

    background: #fff;
    border-radius: 10px;
    border: 1px solid #ddd;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    min-width: 140px;
    z-index: 9999;
}




.comment-dropdown-content button {
    width: 100%;
    padding: 9px 12px;
    background: none;
    border: none;
    font-size: 13px;
    text-align: left;
    cursor: pointer;
}

.comment-dropdown-content button:hover {
    background: #f5f5f5;
}

.comment-dropdown:hover .comment-dropdown-content {
    display: block;
}
/* ===============================
   HOVER EFFECT (OPTIONAL)
================================ */
.comment-row:hover {
    background: #f5f7fa;
}


a[title="Insert Image"] {
    display: none !important;
}


/* =================================
   IMAGE PREVIEW MODAL
================================= */

.image-preview-modal {
    display: none;
    position: fixed;
    z-index: 99999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.88);

    justify-content: center;
    align-items: center;
    overflow: hidden;

    animation: fadeIn 0.2s ease;
}

/* Zoom controls toolbar */
.image-zoom-controls {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(20, 20, 20, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 30px;
    padding: 6px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 100001;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
}

.zoom-btn {
    background: rgba(255, 255, 255, 0.15);
    border: none;
    color: #ffffff;
    font-size: 14px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    outline: none !important;
}

.zoom-btn:hover {
    background: rgba(255, 255, 255, 0.35);
    transform: scale(1.1);
    color: #ffffff;
}

.zoom-btn.image-zoom-reset {
    width: auto;
    border-radius: 20px;
    padding: 0 12px;
    font-size: 12px;
    font-weight: 600;
    gap: 5px;
}

.zoom-level-text {
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    min-width: 42px;
    text-align: center;
    user-select: none;
}

.image-preview-wrapper {
    position: relative;
    max-width: 88vw;
    max-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: visible;
    user-select: none;
    cursor: grab;
}

.image-preview-wrapper.is-zoomed {
    cursor: grab;
}

.image-preview-wrapper.is-panning {
    cursor: grabbing !important;
}

.image-preview-content {
    max-width: 88vw;
    max-height: 85vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    transform-origin: center center;
    transition: transform 0.15s ease-out;
    will-change: transform;
}

.image-preview-wrapper.is-panning .image-preview-content {
    transition: none !important;
}

.image-preview-close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: white;
    font-size: 40px;
    cursor: pointer;
    font-weight: bold;
}

.image-preview-close:hover {
    opacity: 0.7;
}

.comment-text img {
    cursor: pointer;
    transition: 0.2s;
}

.comment-text img:hover {
    opacity: 0.9;
    transform: scale(1.01);
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.comment-details-container{
    position: relative;
    margin-bottom: 0;
}


#menuBarDiv_comment_details{
    padding:0 !important;
    margin:0 !important;
    border:0 !important;
    min-height:auto !important;
}

#menuBarDiv_comment_details ul{
    margin:0 !important;
    padding:0 !important;
}

#menuBarDiv_comment_details li{
    list-style:none !important;
}

#menuBarDiv_comment_details li:empty{
    display:none !important;
}


.comment-text a{
    color:#0d6efd;
    text-decoration:underline;
}

.project_details_div{
    height: auto !important;
    min-height: 2rem;
    margin-bottom: 10px;
}

#discussion_title{
    width: 100%;
    border: 0;
    background: transparent;

    font-size: 16px;
    font-weight: 700;
    line-height: 1.4;

    resize: none;
    overflow: hidden;

    white-space: pre-wrap;
    word-break: break-word;
    overflow-wrap: break-word;

    padding: 0;
    margin: 0 0 15px 0;

    min-height: 40px;
}

.discussion-divider{
    border: 0;
    border-top: 1px solid #e5e7eb;
    margin: 18px 0;
}

/* .comment-action-bar{
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:10px;

    justify-content:flex-end;
    width:100%;
} */

.attachment-footer,
.attachment-file-row{
    display:flex;
    align-items:center;
    gap:12px;
    margin-top:6px;
}

.chat-textbox table{
    width:100%;
}

.comment-details-container{
    width:100%;
}


.comment-input-layout{
    display:flex;
    align-items:flex-start;
    gap:12px;
    width:100%;
}

.comment-user-side{
    width:40px;
    flex-shrink:0;
}

.comment-editor-side{
    flex:1;
}


.Editor-container,
.Editor-editor{
    width:100% !important;
    max-width:100% !important;
    overflow:hidden;
    box-sizing:border-box;
    margin-bottom: 0 !important;
}

.chat-textbox td:last-child{
    width:auto;
}

.comment-editor-side{
    flex:1;
    min-width:0;
    overflow:hidden;
}

/* .comment-action-bar{
    width:100%;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
} */

.project_details_div .row,
.project_details_div.row {
    margin-left: 0;
    margin-right: 0;
}

.task-details-wrapper{
    width:100%;
    margin-top:15px;
}

.task-detail-row{
    display:flex;
    align-items:center;
    gap:12px; /* reduce space */
    margin-bottom:14px;
}

.task-label{
    width:80px; /* smaller label width */
    min-width:80px;
    font-size:14px;
    color:#111;
    font-weight:500;
}

.task-value{
    flex:1;
    min-width:0;
}

/* assignee select */
#discussion_assignee_name{
    border:none;
    background:transparent;
    padding:0;
    font-size:14px;
    width:auto;
}

/* due date */
#discussion_due_date{
    border:none;
    border-bottom:1px solid #d2d2d2;
    background:transparent;
    padding:2px 0;
    width: 215px;
}

/* project button */
#discussion_project_detail{
    max-width:250px;
    width: 215px;
    overflow:hidden;
    white-space:nowrap;
    text-overflow:ellipsis;
}

/* priority */
.priority-display-wrapper{
    display:flex;
    align-items:center;
    gap:10px;
}

#discussion_priority{
    width:140px;
}

/* description row */
.align-start{
    align-items:flex-start;
}

#discussion_description{
    width:100%;
}

/* remove old bootstrap spacing issue */
.project_details_div,
.project_details_div.row{
    margin:0 !important;
    padding:0 !important;
    height:auto !important;
}

.swal2-container{
    z-index: 999999999 !important;
}

.select2-container {
    width: 13rem !important;
}
/* Make sure mention tags are properly displayed and clickable */
.mention-tag,
.mention-user-tag,
.mention-group {
    display: inline;
    background: #e3f2fd;
    padding: 1px 4px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 500;
    margin: 0;
    color: #1565c0;
    text-decoration: none;
    vertical-align: baseline;
}

.mention-user-tag {
    cursor: pointer;
    transition: all 0.2s ease;
}

.mention-user-tag:hover {
    background: #bbdef5;
    transform: scale(1.02);
    text-decoration: underline;
}

/* Prevent any unwanted styling inside mention tags */
.mention-tag a,
.mention-user-tag a,
.mention-group a {
    display: none !important;
}

/* Ensure comment text doesn't interfere with mention tags */
.comment-text .mention-user-tag {
    display: inline-block !important;
}

.image-nav-btn{
    position:absolute;
    top:50%;
    transform:translateY(-50%);

    background:transparent;
    border:none;

    color:#ff3b30;
    font-size: 60px;

    cursor:pointer;

    z-index:100000;

    transition:0.2s;
}

.image-nav-btn:hover{
    opacity:0.7;
    transform:translateY(-50%) scale(1.05);
}

.image-prev-btn{
    left:40px;
}

.image-next-btn{
    right:40px;
}

@media(max-width:768px){

    .image-nav-btn{
        font-size:50px;
    }

    .image-prev-btn{
        left:10px;
    }

    .image-next-btn{
        right:10px;
    }

}

#InsertLink_comment_details.modal {
    z-index: 100000 !important;
}

/* Also raise its backdrop above the chat panel */
#InsertLink_comment_details + .modal-backdrop,
.modal-backdrop {
    z-index: 99999 !important;
    opacity: 0 !important;      /* invisible but still there */
}

/* Ensure the chat panel’s own modal stays unchanged */
#inbox-right.modal {
    z-index: 9999; /* keep original */
}

#InsertLink_comment_details {
    pointer-events: auto !important;
}

#InsertLink_comment_details .modal-dialog,
#InsertLink_comment_details .modal-content,
#InsertLink_comment_details input {
    pointer-events: auto !important;
}

.pdf-preview-content {
    width: 85%;
    height: 90%;
    max-width: 1100px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.4);
}
#h3_InsertLink_comment_details{
    display: none;
}

@media (max-width: 767px) {
    .attachment-footer,
    .attachment-file-row {
        flex-wrap: wrap !important;
        gap: 6px !important;
        align-items: center !important;
    }
    .attachment-footer .attachment-file-name,
    .attachment-file-row .attachment-file-name {
        width: 100% !important;
        word-break: break-all !important;
        white-space: normal !important;
        margin-bottom: 2px !important;
    }
    .attachment-footer .attachment-download-btn,
    .attachment-footer .attachment-delete-btn,
    .attachment-footer .attachment-view-btn,
    .attachment-file-row .attachment-download-btn,
    .attachment-file-row .attachment-delete-btn,
    .attachment-file-row .attachment-view-btn {
        flex: 1 1 auto !important;
        justify-content: center !important;
        text-align: center !important;
        padding: 5px 8px !important;
        font-size: 0.8rem !important;
        margin: 0 !important;
        max-width: fit-content !important;
        height: auto !important;
    }
}

</style>

<!-- Right Side (Initially Hidden) -->

<div class="modal right fade" id="inbox-right" tabindex="-1" aria-hidden="true" data-backdrop="false" style="padding-left: 18px !important;">
    <div class="modal-dialog">
        <div class="modal-content" style="padding-bottom: 50px;">
            <input type="hidden" id="chat_section_id" />
            <input type="hidden" id="chat_discussion_id" />
            <input type="hidden" id="chat_discussion_type" />

            <div class="top-fixed d-flex w-100 justify-content-between">
                <div class="make_complete_div">
                    {{-- <button class="make_complete_btn btn btn-success">Mark As Complete</button>
                    <button class="completed_btn btn btn-success">Completed</button> --}}
                </div>
                <div style="text-align: right;">
                    <button class="btn btn-sm btn-light float-end" onclick="hideRightPanel()">
                        <i class="fa fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <div class="scrollable-section">

                <div class="project_details_div row">
                    {{-- <span class="project_name fw-bold" id="discussion_title">Project</span> --}}
                    <textarea class="border-0 fw-bold project_name w-100" id="discussion_title" rows="2"></textarea>
                </div>

                <div class="task-details-wrapper">

                    <!-- Assignee -->
                    <div class="task-detail-row">
                        <div class="task-label">Assignee</div>

                        <div class="task-value" id="discussion_assignee_name_container">
                        </div>
                    </div>

                    <!-- Due Date -->
                    <div class="task-detail-row">
                        <div class="task-label">Due Date</div>

                        <div class="task-value">
                            <input type="date"
                                class="project_details_gray"
                                id="discussion_due_date" />
                        </div>
                    </div>

                    <!-- Project -->
                    <div class="task-detail-row">
                        <div class="task-label">Project</div>

                        <div class="task-value">
                            <input type="hidden" id="discussion_project_id">

                            <button type="button"
                                    class="btn btn-sm btn-secondary text-left"
                                    id="discussion_project_detail">

                            </button>
                        </div>
                    </div>

                    <!-- Priority -->
                    <div class="task-detail-row">
                        <div class="task-label">Priority</div>

                        <div class="task-value">
                            <div class="priority-display-wrapper">

                                <select class="form-control form-control-sm"
                                        id="discussion_priority">

                                    <option value="Low">Low</option>
                                    <option value="Medium" selected>Medium</option>
                                    <option value="High">High</option>
                                    <option value="Critical">Critical</option>

                                </select>

                                <span id="current_priority_badge"
                                    class="priority-badge priority-medium current-priority-badge">
                                    Medium
                                </span>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="project_details_div row">
                    <div class="col-lg-2 padding_left_unset"><span class="task-label">Description</span></div>
                </div>
                <div class="row" style="width: 100% !important; padding: 0.2rem 1rem;">
                    <textarea class="form-control discussion-control" rows="3" id="discussion_description"></textarea>
                    <div id="discussion_description_display"
                        style="display:none; width:100%; min-height:60px; padding:6px 12px;
                                border:1px solid #ced4da; border-radius:4px; font-size:14px;
                                line-height:1.6; cursor:text; word-break:break-all; color:#333; white-space: pre-wrap;"></div>
                </div>

                <div class="project_details_div row">
                    <div class="task-attachments-section">
                        <div class="task-attachments-header">
                            <span class="task-attachments-title">Attachments</span>
                            <span class="task-attachments-count" id="task_attachments_count">0</span>
                            <!-- <i class="fa fa-plus add-attachment-btn" id="add_task_attachment_btn" title="Add Attachment"></i>
                            <input type="file" id="task_attachment_input" style="display: none;" multiple> -->
                        </div>
                        <div class="task-attachments-list" id="task_attachments_list">
                            <!-- Attachments will be loaded here -->
                        </div>
                    </div>
                </div>

                <div class="project_details_div row">
                    <div class="mt-2 d-flex align-items-center gap-5">

                        <small class="text-muted" style="font-size:13px;">
                            Created By :
                            <span id="discussion_created_by_name"></span>
                        </small>

                        <small class="text-muted" style="font-size:13px; padding-left: 20px;">
                            Assigned By :
                            <span id="discussion_assigned_by_name"></span>
                        </small>

                    </div>
                </div>

                <hr class="discussion-divider">

                <table class="chat-details-table previous-chats mt-1" style="width: 96.8%; background-color: #f6f8f9; margin-bottom: 50px;">
                    <tbody class="previous-chats-tbody"></tbody>
                </table>
            </div>

            <div class="bottom-fixed">
                <div class="col-md-12 pt-2 chat-input" id="chat-input-div">
                    <div class="row mr-1 chat-textbox">
                        <div class="comment-input-layout">
                            <div class="comment-user-side">
                                <img src="{{ asset(auth()->user()->profile_pic) }}" class="mt-1 chat-user-icon" />
                            </div>
                            <div class="comment-editor-side">
                                <div class="comment-details-container">
                                    <textarea type="text" class="form-control discussion-control" name="comment_details" id="comment_details" rows="2"></textarea>

                                        <div class="image-upload-progress" style="display:none;">

                                            <div class="image-upload-progress-bar"></div>

                                            <div class="image-upload-progress-text">
                                                0%
                                            </div>

                                        </div>

                                        <div class="dropdown user-dropdown">
                                            <div class="mention-dropdown-content">
                                                <a href="javascript:void(0)" class="mention-user mention-all-users" data-mentioned-user-id="all" data-mentioned-user-name="all">
                                                    <span style="display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:#5e72e4;color:#fff;font-size:10px;font-weight:700;">@</span>
                                                    <strong>all</strong> <span style="font-size:11px;color:#888;">&mdash; All project members</span>
                                                </a>
                                                @foreach ($activeUsers as $user)
                                                    <a href="javascript:void(0)" class="mention-user" data-mentioned-user-id="{{$user->id}}" data-mentioned-user-name="{{$user->name}}">
                                                        @if ($user->profile_pic == null || $user->profile_pic == '')
                                                            <img src="{{asset('assets')}}/img/user/default.png" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                        @else
                                                            <img src="{{asset($user->profile_pic)}}" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                        @endif
                                                        {{ $user->name }}
                                                    </a>
                                                @endforeach
                                                @foreach ($activeUserGroups as $userGroup)
                                                    <a href="javascript:void(0)" class="mention-user" data-mentioned-user-id="0" data-mentioned-group-id="{{$userGroup->id}}" data-mentioned-group-name="{{$userGroup->name}}">
                                                        <img src="{{asset('assets')}}/img/user/group_muted.png" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                        {{ $userGroup->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                            <div class="mention-dropdown-content2">
                                                <a href="javascript:void(0)" class="mention-user2 mentags mention-all-users" data-mentioned-user-id="all" data-mentioned-user-name="all">
                                                    <span style="display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:#5e72e4;color:#fff;font-size:10px;font-weight:700;">@</span>
                                                    <strong>all</strong> <span style="font-size:11px;color:#888;">&mdash; All project members</span>
                                                </a>
                                                @foreach ($activeUsers as $user)
                                                    <a href="javascript:void(0)" class="mention-user2 mentags" data-mentioned-user-id="{{$user->id}}" data-mentioned-user-name="{{$user->name}}">
                                                        @if ($user->profile_pic == null || $user->profile_pic == '')
                                                            <img src="{{asset('assets')}}/img/user/default.png" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                        @else
                                                            <img src="{{asset($user->profile_pic)}}" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                        @endif
                                                        {{ $user->name }}
                                                    </a>
                                                @endforeach
                                                @foreach ($activeUserGroups as $userGroup)
                                                    <a href="javascript:void(0)" class="mention-user2 mentags" data-mentioned-user-id="0" data-mentioned-group-id="{{$userGroup->id}}" data-mentioned-group-name="{{$userGroup->name}}">
                                                        <img src="{{asset('assets')}}/img/user/group_muted.png" style="width: 20px; height: 20px; border-radius: 50%; overflow: hidden;" />
                                                        {{ $userGroup->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                            <div class="products-dropdown-content" style="display:none;">
                                                <div class="mention-empty">Type # and begin typing a product name or ID</div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="mentioned_users" />
                                        <input type="hidden" id="mentioned_groups" />

                                        <div class="comment-action-bar">
                                            <input type="file" id="comment-file" name="comment-file[]" multiple="multiple" hidden/>
                                            <!-- <label class="btn btn-info btn-sm mb-0 upload-comment-image" for="comment-file"><i class="fas fa-paperclip"></i></label> -->


                                            <button style="margin-right: 3px;" type="button" class="btn btn-info btn-sm submit-comment" title="Comment" data-type="newComment">Comment</button>
                                            <button type="button" style="display: none;" class="btn btn-danger btn-sm submit-cancelEDit" title="Comment">Cancel Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="imagePreviewModal" class="image-preview-modal">

    <!-- CLOSE -->
    <span class="image-preview-close">&times;</span>

    <!-- ZOOM CONTROLS -->
    <div class="image-zoom-controls">
        <button type="button" class="zoom-btn image-zoom-out" id="btnZoomOut" title="Zoom Out (-)">
            <i class="fa fa-minus"></i>
        </button>
        <span class="zoom-level-text" id="zoomLevelText">100%</span>
        <button type="button" class="zoom-btn image-zoom-in" id="btnZoomIn" title="Zoom In (+)">
            <i class="fa fa-plus"></i>
        </button>
        <button type="button" class="zoom-btn image-zoom-reset" id="btnZoomReset" title="Reset Zoom (100%)">
            <i class="fa fa-undo"></i> Reset
        </button>
    </div>

    <!-- PREVIOUS -->
    <button type="button" class="image-nav-btn image-prev-btn">
        &#10094;
    </button>

    <!-- IMAGE WRAPPER FOR ZOOM & PAN -->
    <div class="image-preview-wrapper" id="previewImageWrapper">
        <img class="image-preview-content" id="previewImage" alt="Preview Image">
    </div>

    <!-- NEXT -->
    <button type="button" class="image-nav-btn image-next-btn">
        &#10095;
    </button>

</div>

<div id="pdfPreviewModal" class="image-preview-modal">
    <span class="image-preview-close pdf-preview-close">&times;</span>
    <iframe id="pdfPreviewFrame" class="pdf-preview-content" src="" frameborder="0"></iframe>
</div>

<style>
    .inbox-item { cursor: pointer; padding: 1rem; border-bottom: 1px solid #e5e5e5; }
    .inbox-item.expanded { background-color: #f8f9fa; }
    .transition-all { transition: all 0.3s ease; }
.image-upload-progress{
    width:100%;
    height: 8px;
    background:#5feb4b;
    border-radius:30px;
    overflow:hidden;
    margin-top:10px;
    position:relative;
    z-index:9999;
}

.image-upload-progress-bar{
    width:0%;
    height:100%;
    background:#5feb4b;
    transition:none;
}

.image-upload-progress-text{
    position:absolute;
    left:50%;
    top:50%;
    transform:translate(-50%, -50%);
    font-size:8px;
    font-weight:600;
    color:#111;
}

/* Ensure mention tags are properly displayed and not escaped */
.comment-text .mention-user-tag,
.comment-text .mention-tag {
    display: inline-block !important;
    background: #e3f2fd !important;
    padding: 2px 8px !important;
    border-radius: 16px !important;
    font-size: 12px !important;
    font-weight: 500 !important;
    margin: 0 2px !important;
    color: #1565c0 !important;
    text-decoration: none !important;
    cursor: pointer !important;
}

.comment-text .mention-user-tag:hover {
    background: #bbdef5 !important;
    transform: scale(1.02);
    text-decoration: underline !important;
}

.comment-text img {
    max-width: 30rem !important;
    cursor: pointer;
    transition: none !important;
    -webkit-transition: none !important;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
}

.comment-text img:hover {
    opacity: 0.9;
    transform: none !important;
}

/* Pinned badge styling - Keep only this version */
.pinned-badge {
    display: inline-block;
    background: #fee2e2;
    color: #dc2626;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    margin-left: 8px;
}

.pinned-badge i {
    margin-right: 4px;
    font-size: 10px;
}

/* Pinned comment row styling - RED left border */
.comment-row.pinned-comment {
    background: #fef2f2;
    border-left: 3px solid #dc2626;
}



/* Reaction Picker Styles */
.like-btn-wrapper {
    position: relative;
    display: inline-block;
}

.reaction-picker {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-85%);
    background: #fff;
    border-radius: 40px;
    padding: 8px 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    display: none;
    gap: 8px;
    z-index: 10000;
    margin-bottom: 10px;
    border: 1px solid #e5e5e5;
    white-space: nowrap;
}

.reaction-picker.show {
    display: flex;
}

.reaction-picker-btn {
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 22px;
    padding: 6px;
    border-radius: 50%;
    transition: all 0.2s ease;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.reaction-picker-btn:hover {
    transform: scale(1.2);
    background: #f0f0f0;
}

/* Reaction Display Bubbles */
.reaction-display {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 8px;
}

.reaction-bubble {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #f3f4f6;
    padding: 3px 10px;
    border-radius: 30px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.reaction-bubble:hover {
    background: #e5e7eb;
    transform: scale(1.02);
}

.reaction-bubble.active {
    background: #e3f2fd;
    border-color: #90caf9;
}

.reaction-emoji {
    font-size: 14px;
}

.reaction-count {
    color: #6b7280;
    font-size: 11px;
    font-weight: 500;
}

.reaction-bubble.active .reaction-count {
    color: #1976d2;
}

/* Updated Like Button */
.like-btn {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 7px 7px;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
}

.like-btn.has-reaction {
    background: #e3f2fd;
    border-color: #90caf9;
    color: #1976d2;
}

.like-btn:hover {
    background: #f5f5f5;
}

.mention-space{
    display:inline;
}


.attachment-file-row{
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:4px;
}

.attachment-file-name{
    font-size:14px;
    font-weight:500;
}

.attachment-download-btn{
    margin-left:0;
    font-size:14px;
}


.comment-text {
    max-width: 100%;
    overflow-wrap: break-word;
    word-wrap: break-word;
    word-break: break-word;
    white-space: normal;
    overflow-x: hidden;
}

.comment-text a {
    overflow-wrap: break-word;
    word-wrap: break-word;
    word-break: break-all;
    white-space: normal;
}

.mention-dropdown-content2 a.keyboard-active,
.mention-dropdown-content a.keyboard-active {
    background: #e8eeff !important;
}

.attachment-view-btn {
    background: #eef7ff;
    color: #1565c0;
}
.attachment-view-btn:hover {
    background: #d9edff;
}

.task-attachment-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 0;
    text-decoration: none !important;
    color: #525f7f;
    font-size: 0.85rem;
    transition: color 0.2s;
    cursor: default;
    flex-wrap: wrap;
}

.toolbar-attachment-btn {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    align-self: center;
    margin: 0 4px;
    border-radius: 6px;
    background: #5e72e4;
    color: #fff !important;
    cursor: pointer;
    font-size: 13px;
    text-decoration: none !important;
    transition: background 0.15s ease;
    flex-shrink: 0;
}

.toolbar-attachment-btn:hover {
    background: #4c63d4;
    color: #fff !important;
}

.toolbar-attachment-btn i {
    pointer-events: none;
}


</style>
<style>
    .comment-text a.comment-hyperlink,
    .Editor-editor a.comment-hyperlink {
        color: #0d6efd !important;
        text-decoration: underline !important;
        cursor: pointer;
    }

    #InsertLink_comment_details.modal {
        z-index: 100000 !important;
    }

    #InsertLink_comment_details + .modal-backdrop,
    .modal-backdrop {
        z-index: 99999 !important;
        opacity: 0 !important;
    }

    #InsertLink_comment_details,
    #InsertLink_comment_details .modal-dialog,
    #InsertLink_comment_details .modal-content,
    #InsertLink_comment_details input,
    #InsertLink_comment_details button {
        pointer-events: auto !important;
    }
</style>

<script>


    var baseUrl = "{{ url('/') }}";

    // Function to open user profile with correct URL
    function openUserProfile(userId) {
        if(userId && userId > 0) {
            var profileUrl = baseUrl + '/view/employee/profile/' + userId;
            window.open(profileUrl, '_blank');
        }
    }

    function autoResizeDiscussionTitle(el){
        el.style.height = 'auto';
        el.style.height = el.scrollHeight + 'px';
    }

    $(document).on('input', '#discussion_title', function () {
        autoResizeDiscussionTitle(this);
    });




    let previewImages = [];
    let currentPreviewIndex = 0;

    // OPEN IMAGE
    $('body').on('click', '.comment-text img', function (e) {

        e.stopPropagation();

        previewImages = [];

        $('.comment-text img').each(function () {

            previewImages.push($(this).attr('src'));

        });

        let clickedSrc = $(this).attr('src');

        currentPreviewIndex = previewImages.indexOf(clickedSrc);

        $('#imagePreviewModal').css('display', 'flex');

        showPreviewImage(currentPreviewIndex);

    });

    // Image Zoom & Pan Logic
    let currentZoomScale = 1;
    let currentPanX = 0;
    let currentPanY = 0;
    let isImagePanning = false;
    let panStartX = 0;
    let panStartY = 0;

    function applyImageTransform(animate) {
        const $img = $('#previewImage');
        const $wrapper = $('#previewImageWrapper');
        if (!$img.length) return;

        if (animate === false) {
            $img.css('transition', 'none');
        } else {
            $img.css('transition', 'transform 0.15s ease-out');
        }

        $img.css('transform', `translate(${currentPanX}px, ${currentPanY}px) scale(${currentZoomScale})`);
        $('#zoomLevelText').text(Math.round(currentZoomScale * 100) + '%');

        if (currentZoomScale > 1) {
            $wrapper.addClass('is-zoomed');
        } else {
            $wrapper.removeClass('is-zoomed is-panning');
        }
    }

    function resetImageZoom() {
        currentZoomScale = 1;
        currentPanX = 0;
        currentPanY = 0;
        isImagePanning = false;
        applyImageTransform(true);
    }

    function setZoomScale(newScale, animate) {
        currentZoomScale = Math.min(5, Math.max(1, newScale));
        if (currentZoomScale === 1) {
            currentPanX = 0;
            currentPanY = 0;
        }
        applyImageTransform(animate);
    }

    // Zoom In
    $('body').on('click', '#btnZoomIn, .image-zoom-in', function(e) {
        e.stopPropagation();
        setZoomScale(currentZoomScale + 0.3, true);
    });

    // Zoom Out
    $('body').on('click', '#btnZoomOut, .image-zoom-out', function(e) {
        e.stopPropagation();
        setZoomScale(currentZoomScale - 0.3, true);
    });

    // Reset Zoom
    $('body').on('click', '#btnZoomReset, .image-zoom-reset', function(e) {
        e.stopPropagation();
        resetImageZoom();
    });

    // Double-click image to toggle zoom (100% <-> 200%)
    $('body').on('dblclick', '#previewImage, #previewImageWrapper', function(e) {
        e.stopPropagation();
        if (currentZoomScale > 1) {
            resetImageZoom();
        } else {
            setZoomScale(2, true);
        }
    });

    // Mouse Wheel Zoom
    $(document).on('wheel', '#imagePreviewModal', function(e) {
        if (!$('#imagePreviewModal').is(':visible')) return;
        e.preventDefault();

        const delta = e.originalEvent.deltaY;
        const zoomFactor = delta < 0 ? 0.2 : -0.2;
        setZoomScale(currentZoomScale + zoomFactor, false);
    });

    // Drag to Pan when Zoomed In
    $(document).on('mousedown', '#previewImageWrapper, #previewImage', function(e) {
        if (currentZoomScale <= 1 || e.button !== 0) return;
        e.preventDefault();
        e.stopPropagation();

        isImagePanning = true;
        panStartX = e.clientX - currentPanX;
        panStartY = e.clientY - currentPanY;

        $('#previewImageWrapper').addClass('is-panning');
    });

    $(document).on('mousemove', function(e) {
        if (!isImagePanning) return;
        e.preventDefault();

        currentPanX = e.clientX - panStartX;
        currentPanY = e.clientY - panStartY;

        applyImageTransform(false);
    });

    $(document).on('mouseup mouseleave', function() {
        if (isImagePanning) {
            isImagePanning = false;
            $('#previewImageWrapper').removeClass('is-panning');
        }
    });

    // SHOW IMAGE
    function showPreviewImage(index){

        if(previewImages.length === 0){
            return;
        }

        if(index < 0){
            return;
        }

        if(index >= previewImages.length){
            return;
        }

        currentPreviewIndex = index;

        resetImageZoom();

        $('#previewImage').attr(
            'src',
            previewImages[currentPreviewIndex]
        );
        if(currentPreviewIndex === 0){

            $('.image-prev-btn')
                .prop('disabled', true)
                .css({
                    opacity: '0.3',
                    cursor: 'not-allowed'
                });

        }else{

            $('.image-prev-btn')
                .prop('disabled', false)
                .css({
                    opacity: '1',
                    cursor: 'pointer'
                });
        }

        if(currentPreviewIndex === previewImages.length - 1){

            $('.image-next-btn')
                .prop('disabled', true)
                .css({
                    opacity: '0.3',
                    cursor: 'not-allowed'
                });

        }else{

            $('.image-next-btn')
                .prop('disabled', false)
                .css({
                    opacity: '1',
                    cursor: 'pointer'
                });
        }
    }

    // NEXT
    $('body').on('click', '.image-next-btn', function(e){

        e.stopPropagation();

        showPreviewImage(currentPreviewIndex + 1);

    });

    // PREVIOUS
    $('body').on('click', '.image-prev-btn', function(e){

        e.stopPropagation();

        showPreviewImage(currentPreviewIndex - 1);

    });

    // CLOSE BUTTON
    $('body').on('click', '.image-preview-close', function (e) {

        e.stopPropagation();

        resetImageZoom();
        $('#imagePreviewModal').hide();

    });

    // CLICK OUTSIDE
    $('body').on('click', '#imagePreviewModal', function (e) {

        if (e.target.id === 'imagePreviewModal' || e.target.id === 'previewImageWrapper') {

            resetImageZoom();
            $('#imagePreviewModal').hide();

        }

    });

    // KEYBOARD SUPPORT
    $(document).on('keydown', function(e){

        if(!$('#imagePreviewModal').is(':visible')){
            return;
        }

        // LEFT ARROW
        if(e.keyCode == 37){

            showPreviewImage(currentPreviewIndex - 1);

        }

        // RIGHT ARROW
        if(e.keyCode == 39){

            showPreviewImage(currentPreviewIndex + 1);

        }

        // ESC
        if(e.keyCode == 27){

            resetImageZoom();
            $('#imagePreviewModal').hide();

        }

        // KEYBOARD ZOOM SHORTCUTS (+ / - / R)
        if (e.keyCode == 187 || e.keyCode == 107) { // +
            setZoomScale(currentZoomScale + 0.3, true);
        }
        if (e.keyCode == 189 || e.keyCode == 109) { // -
            setZoomScale(currentZoomScale - 0.3, true);
        }
        if (e.keyCode == 82 || e.keyCode == 48) { // R or 0
            resetImageZoom();
        }

    });


    function setInboxTab(tab) {
        document.querySelectorAll('.inbox-tab').forEach(btn => btn.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
    }

    // function hideRightPanel() {
    //     document.getElementById('inbox-right').classList.add('d-none');
    //     document.getElementById('inbox-left').classList.replace('col-lg-6', 'col-lg-12');
    //     document.querySelectorAll('.inbox-item').forEach(i => i.classList.remove('expanded'));
    // }

    function hideRightPanel() {

        $('#inbox-right').addClass('hide-animation');

        setTimeout(function() {
            $('#inbox-right').modal('hide');
            $('#inbox-right').removeClass('hide-animation');
        }, 1000);
    }


    $(document).on('mousedown', function (e) {

        // Ignore image preview modal
        if (
            $(e.target).closest('#imagePreviewModal').length ||
            $('#imagePreviewModal').is(':visible')
        ) {
            return;
        }

        // Ignore PDF preview modal
        if (
            $(e.target).closest('#pdfPreviewModal').length ||
            $('#pdfPreviewModal').is(':visible')
        ) {
            return;
        }

        // Ignore SweetAlert
        if (
            $(e.target).closest('.swal2-container').length
        ) {
            return;
        }

        // Ignore delete buttons / image actions
        if (
            $(e.target).closest('.delete-image').length ||
            $(e.target).closest('.remove-image').length ||
            $(e.target).closest('.btn-delete-comment').length ||
            $(e.target).closest('.comment-attachment').length
        ) {
            return;
        }

        // Ignore select2
        if (
            $(e.target).closest('.select2-container').length ||
            $(e.target).closest('.select2-dropdown').length
        ) {
            return;
        }

        if (
            $(e.target).closest('.image-nav-btn').length ||
            $(e.target).closest('.image-preview-content').length
        ) {
            return;
        }

        if ($(e.target).closest('#InsertLink_comment_details').length ||
            ($(e.target).hasClass('modal-backdrop') && $('#InsertLink_comment_details').hasClass('show'))) {
            return;
        }

        $('.select2-hidden-accessible').each(function () {
            $(this).select2('close');
        });

        const $modal = $('#inbox-right .modal-dialog');

        if (
            $('#inbox-right').hasClass('show') &&
            !$modal.is(e.target) &&
            $modal.has(e.target).length === 0
        ) {
            hideRightPanel();
        }
    });



    var comment_mention_id="";

    $(document).ready(function(){
        if(!$('#comment_details').data('editor-initialized')){

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

            $('#comment_details').data('editor-initialized', true);

            // Move attachment icon into the toolbar (append to the end, right-aligned)
            if ($('#menuBarDiv_comment_details .toolbar-attachment-btn').length === 0) {
                var $attachBtn = $(
                    '<a href="javascript:void(0)" class="toolbar-attachment-btn" title="Attach File">' +
                        '<i class="fas fa-paperclip"></i>' +
                    '</a>'
                );

                $attachBtn.on('click', function(){
                    $('#comment-file').trigger('click');
                });

                $('#menuBarDiv_comment_details').append($attachBtn);
            }
        }

        $('#discussion_assignee_name').select2({
            dropdownParent: $('#inbox-right'),
            width: '100%',
            closeOnSelect: true
        });

        // File input -> preview inside editor (images inline, others as icons)
        $('body').on('change', '#comment-file', async function(){
            window.tempUploadedFiles = [];
            var files = this.files;

            if(!files || files.length === 0){
                return;
            }

            /* SHOW LOADER IMMEDIATELY */
            $('.image-upload-progress').show();

            $('.image-upload-progress-bar').css({
                width:'0%'
            });

            /* PREVIEW */
            for(var i=0; i<files.length; i++){

                var file = files[i];

                var ext = (file.name.split('.').pop() || '').toLowerCase();

                if(['jpg','jpeg','png','gif','webp'].indexOf(ext) !== -1){

                    var imgUrl = URL.createObjectURL(file);

                    $('.Editor-editor').append(
                        '<div class="comment-attachment temp-attachment" style="margin-top:6px;">'+
                            '<img src="'+imgUrl+'" data-blob-preview="1" style="width:60%; max-width:100%;" />'+
                        '</div>'
                    );

                }else{

                    var iconClass = getFileIconByExt(ext);

                    var safeName = escapeHtml(file.name);

                    $('.Editor-editor').append(
                        '<div class="comment-attachment temp-attachment" style="margin-top:6px;">'+
                            '<i class="'+iconClass+'" style="margin-right:6px;"></i>'+
                            safeName+
                        '</div>'
                    );
                }
            }

            try{

                window.tempUploadedFiles = await uploadMultipleTypeFiles();

            }catch(e){

                console.log(e);

            }

        });

        function cleanupTargetType(value) {
            return (value || '').replace(/^"|"$/g, '');
        }

        function highlightSharedTarget($target) {
            if (!$target || !$target.length) {
                return;
            }

            $target.css('background-color', '#fff3bf');
            setTimeout(function() {
                $target.css('background-color', '');
            }, 2200);
        }

        function ensureSectionLoaded(sectionId, callback) {
            var $sectionRow = $('#parent_section_' + sectionId);
            var $toggleButton = $('.parent-min[data-id="' + sectionId + '"]');

            if ($sectionRow.length && $('.parent-section-' + sectionId).length) {
                $toggleButton.find('i').removeClass('fa-caret-right').addClass('fa-caret-down');
                $sectionRow.data('section-loaded', true);
                if (callback) {
                    callback();
                }
                return;
            }

            $.ajax({
                url: '{{ url("get_project_management_section_by_id") }}/' + sectionId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // displaySectionDiscussions(data);
                    console.log('after displaySectionDiscussions');
                    $sectionRow.data('section-loaded', true);
                    $toggleButton.find('i').removeClass('fa-caret-right').addClass('fa-caret-down');
                    if (callback) {
                        callback();
                    }
                }
            });
        }

        function ensureDiscussionLoaded(discussionId, callback) {
            var $discussionRow = $('#discussion_' + discussionId);
            var $toggleButton = $('.parent-discussion-min[data-id="' + discussionId + '"]');

            if ($discussionRow.length && $('.parent-discussion-' + discussionId).length) {
                $toggleButton.find('i').removeClass('fa-caret-right').addClass('fa-caret-down');
                $discussionRow.data('discussion-loaded', true);
                if (callback) {
                    callback();
                }
                return;
            }

            $.ajax({
                url: '{{ url("get_project_management_section_sub_discussion_by_discussion_id") }}/' + discussionId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // displaySubDiscussions(data);
                    $discussionRow.data('discussion-loaded', true);
                    $toggleButton.find('i').removeClass('fa-caret-right').addClass('fa-caret-down');
                     console.log('after displaySubDiscussions');
                    if (callback) {
                        callback();
                    }
                }
            });
        }

        function openSharedSection(sectionId) {
            ensureSectionLoaded(sectionId, function() {
                var $target = $('#parent_section_' + sectionId);
                if ($target.length) {
                    $target[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    highlightSharedTarget($target);
                }
            });
        }

        function openSharedDiscussion(discussionId) {
            $.ajax({
                url: '{{ url("get_project_management_section_discussion_by_id") }}/' + discussionId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var sectionId = data && data[0] ? data[0].section_id : null;

                    if (sectionId) {
                        ensureSectionLoaded(sectionId, function() {
                            openChat(discussionId, 'discussion');
                            var $target = $('#discussion_' + discussionId);
                            if ($target.length) {
                                $target[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                                highlightSharedTarget($target);
                            }
                        });
                        return;
                    }

                    openChat(discussionId, 'discussion');
                }
            });
        }

        function openSharedSubDiscussion(subDiscussionId) {
            $.ajax({
                url: '{{ url("get_project_management_section_sub_discussion_by_id") }}/' + subDiscussionId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var payload = data && data[0] ? data[0] : {};
                    var sectionId = payload.section_id || null;
                    var discussionId = payload.discussion_id || null;

                    if (sectionId) {
                        ensureSectionLoaded(sectionId, function() {
                            if (discussionId) {
                                ensureDiscussionLoaded(discussionId, function() {
                                    openChat(subDiscussionId, 'sub_discussion');
                                    var $target = $('#sub_discussion_' + subDiscussionId);
                                    if ($target.length) {
                                        $target[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        highlightSharedTarget($target);
                                    }
                                });
                                return;
                            }
                            openChat(subDiscussionId, 'sub_discussion');
                        });
                        return;
                    }

                    openChat(subDiscussionId, 'sub_discussion');
                }
            });
        }

        function openSharedTarget(targetType, targetId) {
            if (!targetType || !targetId) {
                return;
            }

            if (targetType === 'section') {
                openSharedSection(targetId);
                return;
            }

            if (targetType === 'discussion') {
                openSharedDiscussion(targetId);
                return;
            }

            if (targetType === 'sub_discussion') {
                openSharedSubDiscussion(targetId);
            }
        }

        // Check if URL has open_chat=true or open_target=true and open the shared item automatically
        var urlParams = new URLSearchParams(window.location.search);
        var shareType = cleanupTargetType(urlParams.get('type'));
        var shareId = urlParams.get('discussion_id') || urlParams.get('section_id');

        if (urlParams.get('open_target') === 'true' && shareType && shareId) {
            openSharedTarget(shareType, shareId);
        } else if (urlParams.get('open_chat') === 'true' && shareType && shareId) {
            openSharedTarget(shareType, shareId);
        }

    });

    function escapeHtml(text) {
        if(!text) return '';
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function getFileIconByExt(ext){

        ext = (ext || '').toLowerCase();

        var map = {

            // PDF
            'pdf'  : 'far fa-file-pdf',

            // Word
            'doc'  : 'far fa-file-word',
            'docx' : 'far fa-file-word',

            // Excel
            'xls'  : 'far fa-file-excel',
            'xlsx' : 'far fa-file-excel',
            'csv'  : 'far fa-file-excel',

            // PowerPoint
            'ppt'  : 'far fa-file-powerpoint',
            'pptx' : 'far fa-file-powerpoint',

            // Text
            'txt'  : 'far fa-file-alt',
            'rtf'  : 'far fa-file-alt',

            // Archives
            'zip'  : 'far fa-file-archive',
            'rar'  : 'far fa-file-archive',
            '7z'   : 'far fa-file-archive',
            'tar'  : 'far fa-file-archive',
            'gz'   : 'far fa-file-archive',

            // Images
            'jpg'  : 'far fa-file-image',
            'jpeg' : 'far fa-file-image',
            'png'  : 'far fa-file-image',
            'gif'  : 'far fa-file-image',
            'bmp'  : 'far fa-file-image',
            'webp' : 'far fa-file-image',
            'svg'  : 'far fa-file-image',

            // Videos
            'mp4'  : 'far fa-file-video',
            'mov'  : 'far fa-file-video',
            'avi'  : 'far fa-file-video',
            'mkv'  : 'far fa-file-video',
            'wmv'  : 'far fa-file-video',
            'webm' : 'far fa-file-video',
            'flv'  : 'far fa-file-video',

            // Audio
            'mp3'  : 'far fa-file-audio',
            'wav'  : 'far fa-file-audio',
            'aac'  : 'far fa-file-audio',
            'ogg'  : 'far fa-file-audio',
            'flac' : 'far fa-file-audio',
            'm4a'  : 'far fa-file-audio',

            // CAD
            'dxf'  : 'far fa-file-code',
            'dwg'  : 'far fa-file-code',

            // 3D Files
            'stl'  : 'far fa-cube',
            'obj'  : 'far fa-cube',
            'fbx'  : 'far fa-cube',
            'glb'  : 'far fa-cube',
            'gltf' : 'far fa-cube',
            'blend': 'far fa-cube',
            '3ds'  : 'far fa-cube',

            // STEP / IGES
            'step' : 'far fa-cube',
            'stp'  : 'far fa-cube',
            'iges' : 'far fa-cube',
            'igs'  : 'far fa-cube',

            // Code
            'js'   : 'far fa-file-code',
            'ts'   : 'far fa-file-code',
            'php'  : 'far fa-file-code',
            'html' : 'far fa-file-code',
            'css'  : 'far fa-file-code',
            'json' : 'far fa-file-code',
            'xml'  : 'far fa-file-code',
            'sql'  : 'far fa-file-code'
        };

        return map[ext] || 'far fa-file';
    }

    function isImageExt(ext){
        return ['jpg','jpeg','png','gif','webp'].indexOf((ext||'').toLowerCase()) !== -1;
    }

    function updatePriorityBadge(priority){
        var badge = $('#current_priority_badge');

        // Remove all priority classes
        badge.removeClass('priority-critical priority-high priority-medium priority-low');

        // Add the appropriate class based on priority
        switch(priority) {
            case 'Critical':
                badge.addClass('priority-critical');
                break;
            case 'High':
                badge.addClass('priority-high');
                break;
            case 'Medium':
                badge.addClass('priority-medium');
                break;
            case 'Low':
                badge.addClass('priority-low');
                break;
        }

        // Update the text
        badge.text(priority || 'Medium');
    }

    function toggleCommentButton(disabled) {
        $('.submit-comment')
            .prop('disabled', disabled)
            .toggleClass('disabled', disabled);

        if (disabled) {
            $('.submit-comment').text('Uploading...');
        } else {
            $('.submit-comment').text('Comment');
        }
    }

    function uploadMultipleTypeFiles(){

        toggleCommentButton(true);

        var input = document.getElementById('comment-file');

        if(!input || !input.files || input.files.length === 0){

            return $.Deferred().resolve([]).promise();
        }

        var fd = new FormData();

        for(var i=0; i<input.files.length; i++){

            fd.append("upload_file[]", input.files[i]);

            fd.append("upload_file_name[]", input.files[i].name);
        }

        fd.append("project_id", $("#discussion_project_id").val());

        fd.append('_token', '{{ csrf_token() }}');

        $('.image-upload-progress').show();

        $('.image-upload-progress-bar').css('width', '0%');

        return $.ajax({

            url: '{{ route("project_management_section_discussion_comment.file_upload.temp") }}',

            type: 'POST',

            data: fd,

            contentType: false,

            processData: false,

            xhr: function () {

                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function (evt) {

                    if (evt.lengthComputable) {

                        var percent = Math.round((evt.loaded / evt.total) * 100);

                        $('.image-upload-progress').show();

                        $('.image-upload-progress-bar').css({
                            width: percent + '%'
                        });

                        $('.image-upload-progress-text').text(percent + '%');
                    }

                }, false);

                return xhr;
            },

            success:function(){

                $('.image-upload-progress-bar').css({
                    width:'100%'
                });

                $('.image-upload-progress-text').text('100%');

                $('.image-upload-progress').hide();

                $('.image-upload-progress-bar').css({
                    width:'0%'
                });

                $('.image-upload-progress-text').text('0%');
                 toggleCommentButton(false);

            },

            error:function(){
                $('.image-upload-progress').hide();
                $('.image-upload-progress-bar').css('width', '0%');
                toggleCommentButton(false);
            }
        });
    }

    function appendUploadedFilesToEditor(uploadResponse){
        if(!uploadResponse){ return; }

        // Remove temporary previews
        $('.Editor-editor .temp-attachment').remove();

        var items = [];
        // Flexible handling of various response shapes
        if(Array.isArray(uploadResponse)){
            items = uploadResponse;
        } else if(Array.isArray(uploadResponse.data)){
            items = uploadResponse.data;
        } else if(Array.isArray(uploadResponse.files)){
            items = uploadResponse.files;
        }

        for(var i=0; i<items.length; i++){
            var it = items[i];
            var url = it.url || it.path || it.location || it;
            var name = it.name || (typeof it === 'string' ? it.split('/').pop() : 'file');
            var ext = (name.split('.').pop() || '').toLowerCase();

            if(isImageExt(ext)){
                $('.Editor-editor').append('<div class="comment-attachment" style="margin-top:6px;"><img src="'+url+'" style="width:60%; max-width:100%;" /></div>');
            } else {
                var iconClass = getFileIconByExt(ext);
                var safeName = escapeHtml(name);
                $('.Editor-editor').append('<div class="comment-attachment" style="margin-top:6px;">'+
                    '<i class="'+iconClass+'" style="margin-right:6px;"></i>'+
                    '<a href="'+url+'" target="_blank">'+ safeName +'</a>'+
                '</div>');
            }
        }

        // Clear file input after upload
        var $input = $('#comment-file');
        $input.val('');
    }

    var discussionUpdateUrl = {
        'discussion': '{{ url("project_management_section_discussion/update") }}/',
        'sub_discussion': '{{ url("project_management_section_sub_discussion/update") }}/'
    };

    // Change Complete Status
    $('body').on('click', '#discussion_check', function(){

        var discussion_id = $('#chat_discussion_id').val();
        var discussion_type = $('#chat_discussion_type').val();
        var is_completed = $(this).attr('data-change-complete');

        $.ajax({
            url: discussionUpdateUrl[discussion_type]+discussion_id,
            method: 'POST',
            data: {
                is_completed:is_completed,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                if(discussion_type == 'discussion') {
                    if(is_completed == 1){
                        $('.discussion-check-id-'+discussion_id).prop('checked', true);
                        $('#my_task_check_'+discussion_id).prop('checked', true);
                    } else {
                        $('.discussion-check-id-'+discussion_id).prop('checked', false);
                        $('#my_task_check_'+discussion_id).prop('checked', false);
                    }
                } else {
                    if(is_completed == 1){
                        $('.sub-discussion-check-id-'+discussion_id).prop('checked', true);
                    } else {
                        $('.sub-discussion-check-id-'+discussion_id).prop('checked', false);
                    }
                }

                changeTaskCompletedBtn(is_completed);
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
        var discussion_type = $('#chat_discussion_type').val();

        if(discussion_name.length != 0){
            $.ajax({
                url: discussionUpdateUrl[discussion_type]+discussion_id,
                method: 'POST',
                data: {
                    'discussion_name': discussion_name,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    if(discussion_type == 'discussion'){
                        $('.discussion-name-id-'+discussion_id).val(discussion_name);
                    } else {
                        $('.sub-discussion-name-id-'+discussion_id).val(discussion_name);
                    }
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

    $('body').on('change', '#discussion_assignee_name', function(){
        var discussion_id = $('#chat_discussion_id').val();
        var discussion_type = $('#chat_discussion_type').val();
        var assignee_id = $(this).val();

        if(assignee_id != '' || assignee_id != null){

            changed = true;
            var assignee_name = $(this).find('option:selected').data('name');
            var assignee_image = $(this).find('option:selected').data('image');

            $.ajax({
                url: discussionUpdateUrl[discussion_type]+discussion_id,
                method: 'POST',
                data: {
                    assignee_id:assignee_id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    var taskAssigneeDetail = '<img src="{{ asset('') }}/'+assignee_image+'" class="project-inner-avatar" style="">'+
                                                '<span class="text-gray" style="padding-left: 15px;">'+assignee_name+'</span>';
                    if(discussion_type == 'discussion'){
                        $('.task-assignees-id-'+discussion_id).html(taskAssigneeDetail);
                    } else {
                        $('.sub-task-assignees-id-'+discussion_id).html(taskAssigneeDetail);
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
    });

    $('body').on('change', '#discussion_due_date', function(){
        var due_date = $(this).val();
        var discussion_id = $('#chat_discussion_id').val();
        var discussion_type = $('#chat_discussion_type').val();

        $.ajax({
            url: discussionUpdateUrl[discussion_type]+discussion_id,
            method: 'POST',
            data: {
                due_date:due_date,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                if(discussion_type == 'discussion'){
                    $('.discussion-due-date-id-'+discussion_id).val(due_date);
                } else {
                    $('.sub-discussion-due-date-id-'+discussion_id).val(due_date);
                }
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

    $('body').on('change', '#discussion_description', function(){
        var discussion_description = $(this).val();
        var discussion_id = $('#chat_discussion_id').val();
        var discussion_type = $('#chat_discussion_type').val();

        $.ajax({
            url: discussionUpdateUrl[discussion_type]+discussion_id,
            method: 'POST',
            data: {
                discussion_description:discussion_description,
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
    });

    // Handle Priority Change
    $('body').on('change', '#discussion_priority', function(){
        var priority = $(this).val();
        var discussion_id = $('#chat_discussion_id').val();
        var discussion_type = $('#chat_discussion_type').val();

        // Update priority badge color
        updatePriorityBadge(priority);

        $.ajax({
            url: discussionUpdateUrl[discussion_type]+discussion_id,
            method: 'POST',
            data: {
                priority:priority,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                // prefer server-returned priority if present
                var newPriority = (data && data.priority) ? data.priority : priority;

                // map to css class names used in list view
                function priorityToClass(p) {
                    if(!p) return 'medium';
                    var key = p.toString().toLowerCase();
                    if(key.indexOf('critical') !== -1) return 'critical';
                    if(key.indexOf('high') !== -1) return 'high';
                    if(key.indexOf('low') !== -1) return 'low';
                    return 'medium';
                }

                var cls = priorityToClass(newPriority);

                // Update discussion row in list view (discussion or sub_discussion)
                var rowSelector = (discussion_type === 'sub_discussion') ? '#sub_discussion_' + discussion_id : '#discussion_' + discussion_id;

                var $row = $(rowSelector);
                if($row.length) {
                    var $ind = $row.find('.priority-indicator');
                    if($ind.length) {
                        $ind.removeClass('critical high medium low').addClass(cls);
                        // update tooltip/title so hover shows the current priority
                        $ind.attr('title', newPriority);
                        $ind.find('.priority-text').text(newPriority); // keep for backward compat (hidden by CSS)
                    }
                }

                // Also update board cards if present
                var $board = $('#board_discussion_' + discussion_id);
                if($board.length) {
                    var $indb = $board.find('.priority-indicator');
                    if($indb.length) {
                        $indb.removeClass('critical high medium low').addClass(cls);
                        $indb.attr('title', newPriority);
                        $indb.find('.priority-text').text(newPriority);
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

    var taskCompletedBtn = {
        0: '<button class="make_complete_btn btn btn-success" data-change-complete="1" id="discussion_check">Mark As Complete</button>',
        1: '<button class="completed_btn btn btn-success" data-change-complete="0" id="discussion_check">Completed</button>'
    };

    function changeTaskCompletedBtn(is_completed){
        $('.make_complete_div').html(taskCompletedBtn[is_completed]);
    }

    var discussionGetUrl = {
        'discussion': '{{ url("get_project_management_section_discussion_by_id") }}/',
        'sub_discussion': '{{ url("get_project_management_section_sub_discussion_by_id") }}/'
    };




    let clickTimer = null;

    $('body').on('click', '.open-chatbox', function(e) {

        if ($(e.target).is('input, textarea, select, btn btn-primary arrow, button.btn.btn-primary.arrow i, i.fa-solid.fa-caret-down, .toggle-arrow button.btn.btn-primary.arrow, .parent-discussion-min, .drag-handle')) {
            return;
        }

        if ($(e.target).closest('input, textarea, select, button, .select2-container, .task-assignees').length) {
            return;
        }

        let currentTd = $(this);

        if (clickTimer) {
            clearTimeout(clickTimer);
            clickTimer = null;
        }

        clickTimer = setTimeout(() => {

            if (currentTd.data('dblclick-edit') === true) {

                currentTd.removeData('dblclick-edit');

                return;
            }

            clickTimer = null;

            $('#menuBarDiv_comment_details').hide();

            var discussion_id = currentTd.data('value');
            var discussion_type = currentTd.data('discussion-type');

            openChat(discussion_id, discussion_type);

        }, 200);

    });

    // Convert URLs to clickable links in a text string
    function linkifyText(text) {
        if (!text) return '';
        var escaped = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
        return escaped.replace(
            /(https?:\/\/[^\s<]+)/g,
            '<a href="$1" target="_blank" rel="noopener noreferrer" style="color:#5e72e4;">$1</a>'
        );
    }

    // Show display div (with links), hide textarea
    function showDescriptionDisplay(value) {
        var html = linkifyText(value);
        if (!html || html.trim() === '') {
            html = '<span style="color:#aaa;">No description</span>';
        }
        $('#discussion_description_display').html(html).show();
        $('#discussion_description').hide();
    }

    // Show textarea for editing, hide display
    function showDescriptionEdit() {
        $('#discussion_description_display').hide();
        $('#discussion_description').show().focus();
    }

    // Click display to edit
    $('body').on('click', '#discussion_description_display', function () {
        showDescriptionEdit();
    });

    // When textarea loses focus, switch back to display
    $('body').on('blur', '#discussion_description', function () {
        showDescriptionDisplay($(this).val());
    });


    function openChat(discussion_id, discussion_type) {

        $('#chat_discussion_type').val(discussion_type);
        $('#chat_discussion_id').val(discussion_id);

        loadDraftComment(discussion_id, discussion_type);

        $.ajax({
            url: discussionGetUrl[discussion_type]+discussion_id,
            method: 'GET',
            dataType: 'json',
            success: function(discussionData) {

                var data = discussionData[0];

                // Update projectAssigneeIds dynamically for @all mention
                if (discussionData[1] && Array.isArray(discussionData[1])) {
                    projectAssigneeIds = discussionData[1].map(function(u){ return u.id; });
                }


                var userOptions = '';

                @foreach($activeUsers as $user)
                    var isSelected = {{ $user->id }} == data.assignee_id ? 'selected' : '';
                    userOptions += `
                        <option
                            value="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            data-image="{{ $user->profile_pic }}"
                            ${isSelected}
                        >
                            {{ $user->name }}
                        </option>
                    `;
                @endforeach

                var discussionContainer = '<select name="project_details_gray discussion_assignee_name" id="discussion_assignee_name">'+
                                            '<option value=""> No Assignee</option>'+
                                            userOptions+
                                        '</select>';
                if ($('#discussion_assignee_name').hasClass("select2-hidden-accessible")) {
                    $('#discussion_assignee_name').select2('destroy');
                }

                $('#discussion_assignee_name_container').html(discussionContainer);
                $('#discussion_assignee_name').select2({
                    dropdownParent: $('#discussion_assignee_name_container'),
                    width: 'resolve'
                });

                changeTaskCompletedBtn(data.is_completed);
                $('#chat_section_id').val(data.section_id);

                $('#discussion_title').val(data.discussion_name);
                $('#discussion_description').val(data.discussion_description);
                showDescriptionDisplay(data.discussion_description);

                let assignedByName = '';
                let createdByName = '';

                if(discussion_type == 'discussion'){
                    @if(count($activeUsers) > 0)
                        @foreach($activeUsers as $user)
                            if(data.assigned_by == {{ $user->id }}){
                                assignedByName = '{{ $user->name }}';
                            }
                            if(data.user_id == {{ $user->id }}){
                                createdByName = '{{ $user->name }}';
                            }
                        @endforeach
                    @endif
                }

                if(discussion_type == 'sub_discussion'){
                    @if(count($activeUsers) > 0)
                        @foreach($activeUsers as $user)
                            if(data.assigned_by == {{ $user->id }}){
                                assignedByName = '{{ $user->name }}';
                            }
                            if(data.user_id == {{ $user->id }}){
                                createdByName = '{{ $user->name }}';
                            }
                        @endforeach
                    @endif

                }

                $('#discussion_assigned_by_name').text(assignedByName != '' ? assignedByName : 'N/A');
                $('#discussion_created_by_name').text(createdByName != '' ? createdByName : 'N/A');
                $('#discussion_assignee_name').val(data.assignee_id).trigger('change.select2');
                $('#discussion_due_date').val(data.due_date);

                var priority = data.priority || 'Medium';
                $('#discussion_priority').val(priority);
                updatePriorityBadge(priority);

                var projectDetailRow = '<i>Project Not Existing</i>'
                if(data.project_detail){
                    var projectDetailRow = '<i class="fas fa-circle" style="color: '+data.project_detail.project_color+'"></i> #'+data.project_detail.project_no+' '+data.project_detail.new_display_name;
                }
                $('#discussion_project_detail').html(projectDetailRow);
                $('#discussion_project_id').val(data.project_id);

                $('.previous-chats-tbody').html('');

                var comment_data = data.comments;
                comment_data.sort(function(a, b) {
                    if (a.is_pinned && !b.is_pinned) return -1;
                    if (!a.is_pinned && b.is_pinned) return 1;
                    if (a.is_pinned && b.is_pinned) {
                        return new Date(b.pinned_at) - new Date(a.pinned_at);
                    }
                    return new Date(a.created_at) - new Date(b.created_at);
                });

                var row = '';

                for(var i = 0; i < comment_data.length; i++){

                    var deleteCommentButton = '';
                    if (comment_data[i].can_delete_comment === true) {
                        deleteCommentButton =
                            '<button type="button" class="btn btn-delete-comment" ' +
                            'data-comment-order-id="' + data.project_id + '" ' +
                            'data-comment-section-id="' + data.section_id + '" ' +
                            'data-comment-discussion-id="' + discussion_id + '" ' +
                            'data-comment-id="' + comment_data[i].id + '">' +
                            '<i class="fa-regular fa-trash-can"></i> ' +
                            'Delete Comment' +
                            '</button>';
                    }

                    var pinButton = '';
                    if (comment_data[i].can_delete_comment === true || comment_data[i].user_id == {{ auth()->id() }}) {
                        var pinText = comment_data[i].is_pinned ? 'Unpin from top' : 'Pin to top';
                        pinButton = `
                            <button type="button" class="btn btn-pin-comment"
                                data-comment-id="${comment_data[i].id}"
                                data-is-pinned="${comment_data[i].is_pinned ? '1' : '0'}">
                                <i class="fa-solid fa-thumbtack"></i>
                                ${pinText}
                            </button>
                        `;
                    }

                    var editCommentButton = '';

                    if (comment_data[i].can_edit_comment === true) {

                        editCommentButton = `
                            <button type="button" class="btn btn-update-comment"
                                data-divid="discussion_comment_${comment_data[i].id}"
                                data-comment-order-id="${data.project_id}"
                                data-comment-section-id="${data.section_id}"
                                data-comment-discussion-id="${discussion_id}"
                                data-comment-id="${comment_data[i].id}">
                                <i class="fa-solid fa-pen-to-square"></i> Edit Comment
                            </button>
                        `;
                    }


                    var pinnedBadge = '';
                    if (comment_data[i].is_pinned) {
                        pinnedBadge = '<span class="pinned-badge"><i class="fa-solid fa-thumbtack"></i> Pinned</span>';
                    }

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

                    // ========== REACTION CODE ==========
                    var reactions = comment_data[i].reactions_grouped || {};
                    var userReaction = comment_data[i].user_reaction || null;
                    var reactionsDisplay = formatReactionsDisplay(reactions, userReaction, comment_data[i].id);

                    var likeButtonHtml = '';
                    if (userReaction && REACTION_TYPES[userReaction]) {
                        var config = REACTION_TYPES[userReaction];
                        likeButtonHtml = `<div class="like-btn-wrapper" data-comment-id="${comment_data[i].id}">
                                            <button class="like-btn has-reaction" data-current-reaction="${userReaction}">
                                                <i class="${config.iconActive}"></i>
                                            </button>
                                        </div>`;
                    } else {
                        likeButtonHtml = `<div class="like-btn-wrapper" data-comment-id="${comment_data[i].id}">
                                            <button class="like-btn" data-current-reaction="">
                                                <i class="fa-regular fa-thumbs-up"></i>
                                            </button>
                                        </div>`;
                    }

                    // Process mentions
                    let processedComment = comment_data[i].comment;
                    let userMentionMap = new Map();

                    if (comment_data[i].mentioned_users && comment_data[i].mentioned_users != '') {
                        let mentionedUserIds = comment_data[i].mentioned_users.toString().split(',');
                        @foreach($activeUsers as $user)
                            for(let idx = 0; idx < mentionedUserIds.length; idx++) {
                                let userId = mentionedUserIds[idx].trim();
                                if(userId == {{ $user->id }}) {
                                    userMentionMap.set('{{ $user->name }}', {{ $user->id }});
                                }
                            }
                        @endforeach
                    }

                    function replaceMentions(text, mentionMap) {
                        if (!text || mentionMap.size === 0) return text;
                        let tempDiv = document.createElement('div');
                        tempDiv.innerHTML = text;
                        let walker = document.createTreeWalker(
                            tempDiv,
                            NodeFilter.SHOW_TEXT,
                            {
                                acceptNode: function(node) {
                                    if (node.parentElement &&
                                        (node.parentElement.tagName === 'SCRIPT' ||
                                        node.parentElement.tagName === 'STYLE' ||
                                        node.parentElement.classList &&
                                        (node.parentElement.classList.contains('mention-user-tag') ||
                                        node.parentElement.classList.contains('mention-tag')))) {
                                        return NodeFilter.FILTER_REJECT;
                                    }
                                    return NodeFilter.FILTER_ACCEPT;
                                }
                            }
                        );
                        let textNodes = [];
                        while(walker.nextNode()) {
                            textNodes.push(walker.currentNode);
                        }
                        textNodes.forEach(function(textNode) {
                            let originalText = textNode.nodeValue;
                            let newHtml = originalText;
                            let mentionRegex = /@([a-zA-Z0-9_\s\u00C0-\u00FF]+?)(?=\s|$|\.|,|!|\?|;|:|&nbsp;|<|>)/g;
                            let matches = [];
                            let match;
                            while ((match = mentionRegex.exec(originalText)) !== null) {
                                matches.push({
                                    fullMatch: match[0],
                                    username: match[1].trim(),
                                    index: match.index
                                });
                            }
                            for (let j = matches.length - 1; j >= 0; j--) {
                                let match = matches[j];
                                let userId = null;
                                for (let [name, id] of mentionMap) {
                                    if (name.toLowerCase() === match.username.toLowerCase()) {
                                        userId = id;
                                        break;
                                    }
                                }
                                if (userId) {
                                    let mentionSpan = `<span class="mention-tag mention-user-tag"
                                                        data-user-id="${userId}"
                                                        data-mention-type="user"
                                                        data-profile-url="${baseUrl}/view/employee/profile/${userId}"
                                                        style="cursor: pointer; display: inline; background: #e3f2fd; padding: 2px 8px; border-radius: 16px; margin: 0; color: #1565c0; vertical-align: baseline;">
                                                    @${escapeHtml(match.username)}
                                                </span>`;
                                    newHtml = newHtml.substring(0, match.index) +
                                            mentionSpan +
                                            newHtml.substring(match.index + match.fullMatch.length);
                                }
                            }
                            if (newHtml !== originalText) {
                                let span = document.createElement('span');
                                span.innerHTML = newHtml;
                                textNode.parentNode.replaceChild(span, textNode);
                                while(span.firstChild) {
                                    textNode.parentNode.insertBefore(span.firstChild, span);
                                }
                                textNode.parentNode.removeChild(span);
                            }
                        });
                        return tempDiv.innerHTML;
                    }

                    if (!processedComment.includes('mention-user-tag') && userMentionMap.size > 0) {
                        processedComment = replaceMentions(processedComment, userMentionMap);
                    }

                    let hasAttachments = false;
                    try {
                        let tempCheck = $('<div>').html(processedComment);
                        hasAttachments = tempCheck.find('img, .comment-attachment, a[href]').length > 0;
                    } catch(e) {
                        hasAttachments = false;
                    }

                    // BUILD ROW WITH REACTIONS
                    row += `
                        <tr class="comment-row ${comment_data[i].is_pinned ? 'pinned-comment' : ''}" id="comment_row_${comment_data[i].id}">
                            <td class="comment-avatar">
                                <img src="${comment_profile_pic}" class="chat-user-icon" />
                            </td>

                            <td class="comment-body">
                                <div class="comment-header">
                                    <span class="comment-author">${escapeHtml(comment_user.name)}</span>
                                    ${pinnedBadge}
                                    ${hasAttachments ? '<span class="comment-attachment-badge"><i class="fa-solid fa-paperclip"></i> Attached</span>' : ''}
                                    <span class="comment-date">${comment_date}</span>
                                </div>

                                <div class="comment-text" id="discussion_comment_${comment_data[i].id}">
                                    ${processedComment}
                                </div>

                                <div class="reaction-display-container">
                                    ${reactionsDisplay}
                                </div>
                            </td>

                            <td class="comment-actions">
                                ${likeButtonHtml}
                                <div class="comment-dropdown">
                                    <button class="comment-dropbtn"><i class="fa-solid fa-ellipsis"></i></button>
                                    <div class="comment-dropdown-content">
                                        ${pinButton}
                                        ${editCommentButton}
                                        ${deleteCommentButton}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                }
                $('.previous-chats-tbody').append(row);

                // Initialize reaction pickers
                initReactionPickers();

                formatAttachmentFooters();
                updateTaskAttachmentsList();
                convertUrlsToLinks();
                scrollChatToBottom();
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
        $('#inbox-right').modal('show');
        $('#inbox-right').removeClass('d-none');
        $('#inbox-left').removeClass('col-lg-12').addClass('col-lg-12');
    }



    function scrollChatToBottom() {
        setTimeout(function () {
            var $scrollArea = $('#inbox-right .scrollable-section');
            if ($scrollArea.length) {
                $scrollArea.scrollTop($scrollArea[0].scrollHeight);
            }
        }, 100); // slight delay to ensure DOM is fully rendered
    }

    function appendNewComment(project_id, section_id, discussion_id, commentData) {
        var comment_user = commentData.user_info;

        if (comment_user.profile_pic == null || comment_user.profile_pic == '') {
            var comment_profile_pic = '{{asset("assets")}}/img/user/default.png';
        } else {
            var comment_profile_pic = '{{asset("assets")}}/../' + comment_user.profile_pic;
        }

        if (commentData.date == null || commentData.date == '' || commentData.date == undefined) {
            var comment_date = '';
        } else {
            var comment_date = fromatCommentDate(commentData.date);
        }

        var deleteCommentButton = '';
        if (commentData.can_delete_comment === true) {
            deleteCommentButton = '<button type="button" class="btn btn-delete-comment" ' +
                'data-comment-order-id="' + project_id + '" ' +
                'data-comment-section-id="' + section_id + '" ' +
                'data-comment-discussion-id="' + discussion_id + '" ' +
                'data-comment-id="' + commentData.id + '">' +
                '<i class="fa-regular fa-trash-can"></i> ' +
                'Delete Comment</button>';
        }

        var pinnedBadge = '';
        if (commentData.is_pinned) {
            pinnedBadge = '<span class="pinned-badge"><i class="fa-solid fa-thumbtack"></i> Pinned</span>';
        }

        var pinButton = '';
        var pinText = commentData.is_pinned ? 'Unpin from top' : 'Pin to top';
        pinButton = `
            <button type="button" class="btn btn-pin-comment"
                data-comment-id="${commentData.id}"
                data-is-pinned="${commentData.is_pinned ? '1' : '0'}">
                <i class="fa-solid fa-thumbtack"></i>
                ${pinText}
            </button>
        `;

        var editCommentButton = '';

        if (commentData.can_edit_comment === true) {
            editCommentButton = `
                <button type="button" class="btn btn-update-comment"
                    data-divid="discussion_comment_${commentData.id}"
                    data-comment-order-id="${project_id}"
                    data-comment-section-id="${section_id}"
                    data-comment-discussion-id="${discussion_id}"
                    data-comment-id="${commentData.id}">
                    <i class="fa-regular fa-pen-to-square"></i> Edit Comment
                </button>
            `;
        }

        // ========== REACTION CODE ==========
        var reactions = commentData.reactions_grouped || {};
        var userReaction = commentData.user_reaction || null;
        var reactionsDisplay = formatReactionsDisplay(reactions, userReaction, commentData.id);

        var likeButtonHtml = '';
        if (userReaction && REACTION_TYPES[userReaction]) {
            var config = REACTION_TYPES[userReaction];
            likeButtonHtml = `<div class="like-btn-wrapper" data-comment-id="${commentData.id}">
                                <button class="like-btn has-reaction" data-current-reaction="${userReaction}">
                                    <i class="${config.iconActive}"></i>
                                </button>
                            </div>`;
        } else {
            likeButtonHtml = `<div class="like-btn-wrapper" data-comment-id="${commentData.id}">
                                <button class="like-btn" data-current-reaction="">
                                    <i class="fa-regular fa-thumbs-up"></i>
                                </button>
                            </div>`;
        }

        // Process mentions
        let processedComment = commentData.comment;
        let userMentionMap = new Map();

        if (commentData.mentioned_users && commentData.mentioned_users != '') {
            let mentionedUserIds = commentData.mentioned_users.toString().split(',');

            @foreach($activeUsers as $user)
                for (let idx = 0; idx < mentionedUserIds.length; idx++) {
                    let userId = mentionedUserIds[idx].trim();
                    if (userId == {{ $user->id }}) {
                        userMentionMap.set('{{ $user->name }}', {{ $user->id }});
                    }
                }
            @endforeach
        }

        if (!processedComment.includes('mention-user-tag') && userMentionMap.size > 0) {
            processedComment = safelyReplaceMentions(processedComment, userMentionMap);
        }

        let hasAttachments = false;
        try {
            let tempCheck = $('<div>').html(processedComment);
            hasAttachments = tempCheck.find('img, .comment-attachment, a[href]').length > 0;
        } catch (e) {
            hasAttachments = false;
        }

        var row = '';
        row += `
            <tr class="comment-row ${commentData.is_pinned ? 'pinned-comment' : ''}" id="comment_row_${commentData.id}">
                <td class="comment-avatar">
                    <img src="${comment_profile_pic}" class="chat-user-icon" />
                </td>
                <td class="comment-body">
                    <div class="comment-header">
                        <span class="comment-author">${escapeHtml(comment_user.name)}</span>
                        ${pinnedBadge}
                        ${hasAttachments ? '<span class="comment-attachment-badge"><i class="fa-solid fa-paperclip"></i> Attached</span>' : ''}
                        <span class="comment-date">${comment_date}</span>
                    </div>
                    <div class="comment-text" id="discussion_comment_${commentData.id}">
                        ${processedComment}
                    </div>
                    <div class="reaction-display-container">
                        ${reactionsDisplay}
                    </div>
                </td>
                <td class="comment-actions">
                    ${likeButtonHtml}
                    <div class="comment-dropdown">
                        <button class="comment-dropbtn"><i class="fa-solid fa-ellipsis"></i></button>
                        <div class="comment-dropdown-content">
                            ${pinButton}
                            ${editCommentButton}
                            ${deleteCommentButton}
                        </div>
                    </div>
                </td>
            </tr>`;

        $('.previous-chats-tbody').append(row);
        initReactionPickers();
        formatAttachmentFooters();
        $('#chatbox').show(700);
        convertUrlsToLinks();
    }


    function updateExistingComment(project_id, section_id, discussion_id, commentData) {
        var comment_user = commentData.user_info;

        if (comment_user.profile_pic == null || comment_user.profile_pic == '') {
            var comment_profile_pic = '{{asset("assets")}}/img/user/default.png';
        } else {
            var comment_profile_pic = '{{asset("assets")}}/../' + comment_user.profile_pic;
        }

        if (commentData.date == null || commentData.date == '' || commentData.date == undefined) {
            var comment_date = '';
        } else {
            var comment_date = fromatCommentDate(commentData.date);
        }

        // Delete button - Use can_delete_comment from response
        var deleteCommentButton = '';
        if (commentData.can_delete_comment === true) {
            deleteCommentButton = '<button type="button" class="btn btn-delete-comment" ' +
                'data-comment-order-id="' + project_id + '" ' +
                'data-comment-section-id="' + section_id + '" ' +
                'data-comment-discussion-id="' + discussion_id + '" ' +
                'data-comment-id="' + commentData.id + '">' +
                '<i class="fa-regular fa-trash-can"></i> ' +
                'Delete Comment</button>';
        }

        // Pin button - Use can_delete_comment or user_id from response
        var pinButton = '';
        // Check if user can pin (admin or comment owner)
        var canPin = (commentData.can_delete_comment === true) || (commentData.user_id == {{ auth()->id() }});
        if (canPin) {
            var pinText = commentData.is_pinned ? 'Unpin from top' : 'Pin to top';
            pinButton = `
                <button type="button" class="btn btn-pin-comment"
                    data-comment-id="${commentData.id}"
                    data-is-pinned="${commentData.is_pinned ? '1' : '0'}">
                    <i class="fa-solid fa-thumbtack"></i>
                    ${pinText}
                </button>
            `;
        }

        // Edit button - Use can_edit_comment from response
        var editCommentButton = '';
        if (commentData.can_edit_comment === true) {
            editCommentButton = `
                <button type="button" class="btn btn-update-comment"
                    data-divid="discussion_comment_${commentData.id}"
                    data-comment-order-id="${project_id}"
                    data-comment-section-id="${section_id}"
                    data-comment-discussion-id="${discussion_id}"
                    data-comment-id="${commentData.id}">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Comment
                </button>
            `;
        }

        // Pinned badge
        var pinnedBadge = '';
        if (commentData.is_pinned) {
            pinnedBadge = '<span class="pinned-badge"><i class="fa-solid fa-thumbtack"></i> Pinned</span>';
        }

        // Check for attachments
        var hasAttachments = false;
        try {
            let tempCheck = $('<div>').html(commentData.comment);
            hasAttachments = tempCheck.find('img, .comment-attachment, a[href]').length > 0;
        } catch(e) {
            hasAttachments = false;
        }

        // Process mentions
        let processedComment = commentData.comment;
        let userMentionMap = new Map();

        if (commentData.mentioned_users && commentData.mentioned_users != '') {
            let mentionedUserIds = commentData.mentioned_users.toString().split(',');

            @foreach($activeUsers as $user)
                for (let idx = 0; idx < mentionedUserIds.length; idx++) {
                    let userId = mentionedUserIds[idx].trim();
                    if (userId == {{ $user->id }}) {
                        userMentionMap.set('{{ $user->name }}', {{ $user->id }});
                    }
                }
            @endforeach
        }

        if (!processedComment.includes('mention-user-tag') && userMentionMap.size > 0) {
            processedComment = safelyReplaceMentions(processedComment, userMentionMap);
        }

        // Reactions
        var reactions = commentData.reactions_grouped || {};
        var userReaction = commentData.user_reaction || null;
        var reactionsDisplay = formatReactionsDisplay(reactions, userReaction, commentData.id);

        // Like button
        var likeButtonHtml = '';
        if (userReaction && REACTION_TYPES[userReaction]) {
            var config = REACTION_TYPES[userReaction];
            likeButtonHtml = `<div class="like-btn-wrapper" data-comment-id="${commentData.id}">
                                <button class="like-btn has-reaction" data-current-reaction="${userReaction}">
                                    <i class="${config.iconActive}"></i>
                                </button>
                            </div>`;
        } else {
            likeButtonHtml = `<div class="like-btn-wrapper" data-comment-id="${commentData.id}">
                                <button class="like-btn" data-current-reaction="">
                                    <i class="fa-regular fa-thumbs-up"></i>
                                </button>
                            </div>`;
        }

        // Build the updated row HTML
        var row = `
            <td class="comment-avatar">
                <img src="${comment_profile_pic}" class="chat-user-icon" />
            </td>

            <td class="comment-body">
                <div class="comment-header">
                    <span class="comment-author">${escapeHtml(comment_user.name)}</span>
                    ${pinnedBadge}
                    ${hasAttachments ? '<span class="comment-attachment-badge"><i class="fa-solid fa-paperclip"></i> Attached</span>' : ''}
                    <span class="comment-date">${comment_date}</span>
                </div>

                <div class="comment-text" id="discussion_comment_${commentData.id}">
                    ${processedComment}
                </div>

                <div class="reaction-display-container">
                    ${reactionsDisplay}
                </div>
            </td>

            <td class="comment-actions">
                ${likeButtonHtml}
                <div class="comment-dropdown">
                    <button class="comment-dropbtn"><i class="fa-solid fa-ellipsis"></i></button>
                    <div class="comment-dropdown-content">
                        ${pinButton}
                        ${editCommentButton}
                        ${deleteCommentButton}
                    </div>
                </div>
            </td>
        `;

        // Replace the existing row content
        $('#comment_row_' + commentData.id).html(row);

        // Reinitialize reaction pickers for the updated comment
        initReactionPickers();

        // Re-format attachments if needed
        formatAttachmentFooters();

        // Convert URLs to links if needed
        convertUrlsToLinks();

        updateTaskAttachmentsList();
    }

    function formatAttachmentFooters(){

        $('.comment-text').each(function(){

            let container = $(this);
            let commentIdAttr = container.attr('id');
            let commentId = commentIdAttr ? commentIdAttr.replace('discussion_comment_', '') : '';

            // Heal existing footers
            container.find('.attachment-footer').each(function() {
                let $footer = $(this);
                if ($footer.find('.delete-task-attachment-btn').length === 0) {
                    let $dlBtn = $footer.find('.attachment-download-btn, a[download]');
                    let src = $dlBtn.attr('href');
                    if (src && commentId) {
                        let deleteBtn = '<button type="button" class="attachment-delete-btn delete-task-attachment-btn" ' +
                                        'data-url="' + src + '" ' +
                                        'data-source="comment" ' +
                                        'data-comment-id="' + commentId + '" ' +
                                        'title="Delete Attachment">' +
                                        '<i class="fa fa-trash"></i> Delete' +
                                        '</button>';
                        $footer.append(deleteBtn);
                    }
                }
            });

            container.find('.attachment-file-row').each(function() {
                let $row = $(this);
                if ($row.find('.delete-task-attachment-btn').length === 0) {
                    let $dlBtn = $row.find('.attachment-download-btn, a[download]');
                    let href = $dlBtn.attr('href');
                    if (href && commentId) {
                        let deleteBtn = '<button type="button" class="attachment-delete-btn delete-task-attachment-btn" ' +
                                        'data-url="' + href + '" ' +
                                        'data-source="comment" ' +
                                        'data-comment-id="' + commentId + '" ' +
                                        'title="Delete Attachment">' +
                                        '<i class="fa fa-trash"></i> Delete' +
                                        '</button>';
                        $row.append(deleteBtn);
                    }
                }
            });

            /* Skip if this container is inside a mention tag to avoid false positives */
            if($(this).closest('.mention-tag, .mention-user-tag, .mention-group').length){
                return;
            }

            /* IMAGE */
            container.find('img').each(function(){

                // Skip if inside mention tag
                if($(this).closest('.mention-tag, .mention-user-tag, .mention-group').length){
                    return;
                }

                if($(this).closest('.attachment-wrapper').length){
                    return;
                }

                let img = $(this);

                let src = img.attr('src');

                /* Skip if it's a mention avatar or inline mention image */
                if(src && (src.includes('profile_pic') || src.includes('user/default.png'))){
                    return;
                }

                let fileName = src.split('/').pop();

                let deleteBtn = commentId ? '<button type="button" class="attachment-delete-btn delete-task-attachment-btn" ' +
                                            'data-url="' + src + '" ' +
                                            'data-source="comment" ' +
                                            'data-comment-id="' + commentId + '" ' +
                                            'title="Delete Attachment">' +
                                            '<i class="fa fa-trash"></i> Delete' +
                                            '</button>' : '';

                img.wrap('<div class="attachment-wrapper"></div>');

                img.after(

                    '<div class="attachment-footer">'+

                        '<span class="attachment-file-name">'+fileName+'</span>'+

                        '<a href="'+src+'" target="_blank" download="'+fileName+'" class="attachment-download-btn">'+
                            'Download'+
                        '</a>'+
                        deleteBtn +

                    '</div>'

                );

            });

            /* FILE LINKS */
            container.find('a[href]').each(function(){

                if($(this).closest('.mention-tag, .mention-user-tag, .mention-group').length){
                    return;
                }

                // if($(this).closest('.attachment-footer').length){
                if($(this).closest('.attachment-footer, .attachment-file-row').length){
                    return;
                }

                let link = $(this);

                let href = link.attr('href');

                const isUploadedFile =
                    href &&
                    (
                        href.includes('/storage/') ||
                        href.includes('/uploads/') ||
                        /\.(pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar|csv|txt|webp)$/i.test(href)
                    );

                if (!isUploadedFile) {
                    return;
                }

                let fileName = link.text().trim();

                let ext = (fileName.split('.').pop() || '').toLowerCase();

                let canView = ['pdf','jpg','jpeg','png','gif','webp'].indexOf(ext) !== -1;
                let isPdf = ext === 'pdf';

                let viewBtn = canView ? '<a href="'+href+'" '+(isPdf ? 'class="attachment-download-btn attachment-view-btn pdf-view"' : 'target="_blank" class="attachment-download-btn attachment-view-btn"')+'>View</a>' : '';

                let deleteBtn = commentId ? '<button type="button" class="attachment-delete-btn delete-task-attachment-btn" ' +
                                            'data-url="' + href + '" ' +
                                            'data-source="comment" ' +
                                            'data-comment-id="' + commentId + '" ' +
                                            'title="Delete Attachment">' +
                                            '<i class="fa fa-trash"></i> Delete' +
                                            '</button>' : '';

                link.replaceWith(
                    '<div class="attachment-file-row">'+
                        '<span class="attachment-file-name">'+fileName+'</span>'+ viewBtn +
                        '<a href="'+href+'" target="_blank" download="'+fileName+'" class="attachment-download-btn">'+
                            'Download'+
                        '</a>'+
                        deleteBtn +
                    '</div>'
                );

            });

        });

    }

    function fromatCommentDate(commentDate)
    {
        var originalDate = new Date(commentDate);

        var months = [
            "January", "February", "March", "April",
            "May", "June", "July", "August",
            "September", "October", "November", "December"
        ];

        var month = months[originalDate.getMonth()];
        var day = originalDate.getDate();
        var year = originalDate.getFullYear();

        var hours = originalDate.getHours();
        var minutes = originalDate.getMinutes();

        var ampm = hours >= 12 ? 'pm' : 'am';

        hours = hours % 12;
        hours = hours ? hours : 12;

        return (
            (day < 10 ? '0' : '') + day + ' ' +
            month + ' ' +
            year + ' ' +
            ('0' + hours).slice(-2) + ':' +
            ('0' + minutes).slice(-2) +
            ampm
        );
    }

    var updateCommentDetails = [];
    var originalEditorHeight = '';
    var originalChatHeight = '';
    $('body').on('click', '.btn-update-comment', function () {

        $('.mention-dropdown-content2').hide();

        $(".Editor-editor").html(
            $("#" + $(this).attr("data-divid")).html()
        );

        if (originalEditorHeight === '') {
            originalEditorHeight = $('.Editor-editor').css('height');
        }

        if (originalChatHeight === '') {
            originalChatHeight = $('#chat-input-div').css('height');
        }

        $('#menuBarDiv_comment_details').show(500);
        $('.submit-comment').show(500);
        $('.upload-comment-image').show(500);
        $('.comment-mention').show(500);

        $('#chat-input-div').css('min-height', '400px');
        $('.Editor-editor').css('min-height', '320px');

        $(".submit-cancelEDit").show();
        $(".submit-comment").attr("data-type", "updateComment");

        updateCommentDetails = [];

        updateCommentDetails.push(
            $(this).data("comment-order-id"),
            $(this).data("comment-section-id"),
            $(this).data("comment-discussion-id"),
            $(this).data("comment-id")
        );
    });

    $('body').on('click', '.submit-cancelEDit', function () {

        $(".Editor-editor").html('');

        $('#chat-input-div').css({
            'height': '35px;',
            'min-height': ''
        });

        $('.Editor-editor').css({
            'height': '35px;',
            'min-height': ''
        });

        $(".submit-comment").attr("data-type", "newComment");
        $(".submit-cancelEDit").hide();

        updateCommentDetails = [];
    });

    $(document).mouseup(function(e)
    {
        /*
        |--------------------------------------------------------------------------
        | Do not shrink editor when hyperlink modal is open/clicked
        |--------------------------------------------------------------------------
        */
        if (
            $('#customCommentLinkModal').hasClass('show') ||
            $(e.target).closest('#customCommentLinkModal').length ||
            $(e.target).closest('#menuBarDiv_comment_details a[title="Insert Link"]').length ||
            $(e.target).closest('#menuBarDiv_comment_details .fa-link').length
        ) {
            keepCommentEditorOpen();
            return;
        }

        var container = $(".chat-input");

        if (
            !container.is(e.target) &&
            container.has(e.target).length === 0 &&
            $("#file_preview_modal").has(e.target).length === 0 &&
            e.target.getAttribute('class') !== "cGcvT"
        ) {
            $('.submit-comment').hide(500);
            $('#menuBarDiv_comment_details').hide(500);
            $('.upload-comment-image').hide(500);
            $('.comment-mention').hide(500);
            $('.chat-input').animate({'height': '50px'}, 'slow');
            $('.Editor-editor').animate({'height': '35px'}, 'slow');
        }
    });

    // Comment input display
    $('body').on('click', '.Editor-editor', function(){
        $('#menuBarDiv_comment_details').show(500);
        $('.submit-comment').show(500);
        $('.upload-comment-image').show(500);
        $('.comment-mention').show(500);
        $(this).animate({'height': '150px'}, 'slow');
        $('.chat-input').animate({'height': '250px'}, 'slow');
    });

    // Global function to safely replace mentions without breaking HTML
    function safelyReplaceMentions(text, mentionMap) {
        if (!text || !mentionMap || mentionMap.size === 0) return text;

        // Skip if already processed
        if (text.includes('mention-user-tag')) return text;

        try {
            let tempDiv = document.createElement('div');
            tempDiv.innerHTML = text;

            let walker = document.createTreeWalker(
                tempDiv,
                NodeFilter.SHOW_TEXT,
                {
                    acceptNode: function(node) {
                        if (node.parentElement &&
                            (node.parentElement.tagName === 'SCRIPT' ||
                            node.parentElement.tagName === 'STYLE' ||
                            (node.parentElement.classList &&
                            (node.parentElement.classList.contains('mention-user-tag') ||
                            node.parentElement.classList.contains('mention-tag'))))) {
                            return NodeFilter.FILTER_REJECT;
                        }
                        return NodeFilter.FILTER_ACCEPT;
                    }
                }
            );

            let textNodes = [];
            while (walker.nextNode()) {
                textNodes.push(walker.currentNode);
            }

            textNodes.forEach(function(textNode) {
                let originalText = textNode.nodeValue;
                let newHtml = originalText;

                let mentionRegex = /@([a-zA-Z0-9_\s\u00C0-\u00FF]+?)(?=\s|$|\.|,|!|\?|;|:|&nbsp;|<|>|\)|\(|\n)/g;
                let matches = [];
                let match;

                while ((match = mentionRegex.exec(originalText)) !== null) {
                    matches.push({
                        fullMatch: match[0],
                        username: match[1].trim(),
                        index: match.index
                    });
                }

                for (let j = matches.length - 1; j >= 0; j--) {
                    let match = matches[j];
                    let userId = null;

                    for (let [name, id] of mentionMap) {
                        if (name.toLowerCase() === match.username.toLowerCase()) {
                            userId = id;
                            break;
                        }
                    }

                    if (userId) {
                        let mentionSpan = `<span class="mention-tag mention-user-tag"
                                            data-user-id="${userId}"
                                            data-mention-type="user"
                                            data-profile-url="${baseUrl}/view/employee/profile/${userId}"
                                            style="cursor: pointer; display: inline; background: #e3f2fd; padding: 2px 8px; border-radius: 16px; margin: 0 2px; color: #1565c0;">
                                        @${escapeHtml(match.username)}
                                    </span>`;

                        newHtml = newHtml.substring(0, match.index) +
                                mentionSpan +
                                newHtml.substring(match.index + match.fullMatch.length);
                    }
                }

                if (newHtml !== originalText) {
                    let span = document.createElement('span');
                    span.innerHTML = newHtml;
                    textNode.parentNode.replaceChild(span, textNode);
                    while (span.firstChild) {
                        textNode.parentNode.insertBefore(span.firstChild, span);
                    }
                    textNode.parentNode.removeChild(span);
                }
            });

            return tempDiv.innerHTML;
        } catch (e) {
            console.error('Mention replacement error:', e);
            return text;
        }
    }
    // Project assignee IDs for @all mention — updated dynamically when a task is opened
    var projectAssigneeIds = [{{ implode(',', array_column($projectAssigneeInfo ?? [], 'id')) }}];

    function getMentionedUsers() {

        let userIds = [];

        $('.Editor-editor .mention-user-tag').each(function () {

            let userId = $(this).data('user-id');

            // @all tag — expand to all project assignee IDs (store actual IDs, not the word 'all')
            if (userId === 'all') {
                if (projectAssigneeIds && projectAssigneeIds.length > 0) {
                    projectAssigneeIds.forEach(function(pid) {
                        let pidNum = parseInt(pid);
                        if (pidNum && !userIds.includes(pidNum)) {
                            userIds.push(pidNum);
                        }
                    });
                }
                return; // continue .each()
            }

            if (userId && !userIds.includes(userId)) {
                userIds.push(userId);
            }
        });

        return userIds;
    }


   $('body').on('click', '.submit-comment', async function() {
        let $btn = $(this);
        let mentionedUsers = getMentionedUsers();

        if ($btn.prop('disabled')) {
            return;
        }

        $btn.prop('disabled', true);
        clearTimeout(commentDraftTimer);
        let originalBtn = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        try {
            let project_id = $('#discussion_project_id').val();
            let section_id = $('#chat_section_id').val();
            let discussion_id = $('#chat_discussion_id').val();
            let discussion_type = $('#chat_discussion_type').val();
            let mentioned_users = mentionedUsers.join(',');
            let mentioned_groups = $('#mentioned_groups').val();

            // Get editor content
            let originalHtml = $('.Editor-editor').html();

            // Check if content is empty
            if (!originalHtml || originalHtml.trim() === '' || originalHtml === '<br>' || originalHtml === '<div><br></div>') {
                swal({
                    title: "Warning!",
                    text: "Comment cannot be empty",
                    type: "warning"
                });
                $btn.prop('disabled', false);
                $btn.html(originalBtn);
                return;
            }

            let tempDiv = $('<div></div>');
            tempDiv[0].innerHTML = originalHtml;
            let files = $('#comment-file')[0].files;

            // =====================================
            // UPLOAD NORMAL SELECTED FILES
            // =====================================
            if (files && files.length > 0) {
                let uploadResponse = window.tempUploadedFiles || [];
                let items = [];

                if (Array.isArray(uploadResponse)) {
                    items = uploadResponse;
                } else if (Array.isArray(uploadResponse.data)) {
                    items = uploadResponse.data;
                } else if (Array.isArray(uploadResponse.files)) {
                    items = uploadResponse.files;
                }

                // Replace temp attachments
                tempDiv.find('.temp-attachment').each(function(index) {
                    if (!items[index]) {
                        return;
                    }

                    let it = items[index];
                    let url = it.url || it.path || it.location || it;
                    let name = it.name || url.split('/').pop();
                    let ext = (name.split('.').pop() || '').toLowerCase();

                    if (isImageExt(ext)) {
                        $(this).find('img').attr('src', url);
                        $(this).find('img').removeAttr('data-blob-preview');
                    } else {
                        let iconClass = getFileIconByExt(ext);
                        $(this).html('<a href="' + url + '" target="_blank" download="' + name + '" style="text-decoration:none;">' +
                            '<i class="' + iconClass + '" style="margin-right:6px;"></i>' +
                            name +
                            '</a>');
                    }
                    $(this).removeClass('temp-attachment');
                });
            }

            // =====================================
            // HANDLE PASTED SCREENSHOT IMAGES
            // =====================================
            let pastedImages = tempDiv.find('img[src^="blob:"], img[src^="data:image"]');

            for (let i = 0; i < pastedImages.length; i++) {
                let img = pastedImages[i];
                let src = ($(img).attr('src') || '').trim();

                if (src && (src.startsWith('blob:') || src.startsWith('data:image'))) {
                    try {
                        $('.image-upload-progress').show();
                        $('.image-upload-progress-bar').css({ width: '0%' });
                        $('.image-upload-progress-text').text('0%');

                        let response = await fetch(src);
                        let blob = await response.blob();
                        let fd = new FormData();

                        fd.append("upload_file[]", blob, Date.now() + ".png");
                        fd.append("project_id", project_id);
                        fd.append('_token', '{{ csrf_token() }}');

                        let uploadResp = await $.ajax({
                            url: '{{ route("project_management_section_discussion_comment.file_upload.temp") }}',
                            type: 'POST',
                            data: fd,
                            contentType: false,
                            processData: false,
                            xhr: function() {
                                let xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {
                                        let percent = Math.round((evt.loaded / evt.total) * 100);
                                        $('.image-upload-progress-bar').css({ width: percent + '%' });
                                        $('.image-upload-progress-text').text(percent + '%');
                                    }
                                }, false);
                                return xhr;
                            }
                        });

                        let uploadedUrl = '';
                        if (Array.isArray(uploadResp) && uploadResp[0]) {
                            uploadedUrl = uploadResp[0];
                        } else if (uploadResp.data && uploadResp.data[0]) {
                            uploadedUrl = uploadResp.data[0].url || uploadResp.data[0];
                        } else if (uploadResp.files && uploadResp.files[0]) {
                            uploadedUrl = uploadResp.files[0].url || uploadResp.files[0];
                        }

                        if (uploadedUrl !== '') {
                            $(img).attr('src', uploadedUrl);
                        }

                        $('.image-upload-progress-bar').css({ width: '100%' });
                        $('.image-upload-progress-text').text('100%');
                    } catch (e) {
                        console.log("Paste image upload failed", e);
                    }
                }
            }

            // =====================================
            // PROCESS MENTIONS IN EDITOR CONTENT
            // =====================================
            let editorHtml = tempDiv[0].innerHTML;

            // Create mention map from mentioned_users
            let mentionMap = new Map();
            if (mentioned_users && mentioned_users != '') {
                let userIds = mentioned_users.toString().split(',');
                @foreach($activeUsers as $user)
                    for (let idx = 0; idx < userIds.length; idx++) {
                        if (userIds[idx].trim() == {{ $user->id }}) {
                            mentionMap.set('{{ $user->name }}', {{ $user->id }});
                        }
                    }
                @endforeach
            }

            // Apply mention replacement if needed
            if (!editorHtml.includes('mention-user-tag') && mentionMap.size > 0) {
                editorHtml = safelyReplaceMentions(editorHtml, mentionMap);
            }

            // =====================================
            // SUBMIT COMMENT
            // =====================================
            if ($btn.attr('data-type') == 'updateComment') {
                let data = await $.ajax({
                    url: '{{ url("project_management_section_discussion_comment/update") }}/' + updateCommentDetails[3],
                    method: 'POST',
                    data: {
                        comment: editorHtml,
                        mentioned_users: mentioned_users,
                        mentioned_groups: mentioned_groups,
                        '_token': '{{ csrf_token() }}'
                    }
                });
                updateExistingComment(project_id, section_id, discussion_id, data);
            } else {
                let data = await $.ajax({
                    url: '{{ url("project_management_section_discussion_comment/store") }}',
                    method: 'POST',
                    data: {
                        project_id: project_id,
                        section_id: section_id,
                        section_discussion_id: discussion_id,
                        discussion_type: discussion_type,
                        comment: editorHtml,
                        mentioned_users: mentioned_users,
                        mentioned_groups: mentioned_groups,
                        '_token': '{{ csrf_token() }}'
                    }
                });
                appendNewComment(project_id, section_id, discussion_id, data);
                updateTaskAttachmentsList();
                scrollChatToBottom();
            }

            // =====================================
            // CLEAN UP AND RESET
            // =====================================
            // Clean blob URLs
            $('.Editor-editor img[data-blob-preview="1"]').each(function() {
                let src = $(this).attr('src');
                if (src && src.startsWith('blob:')) {
                    URL.revokeObjectURL(src);
                }
            });

            // Reset editor and form
            $('.Editor-editor').html('');
            $('#comment-file').val('');
            $('.image-upload-progress').hide();
            $('.image-upload-progress-bar').css({ width: '0%' });
            $('.image-upload-progress-text').text('0%');
            $('#mentioned_users').val('');
            $('#mentioned_groups').val('');
            $('.mention-dropdown-content2').hide();
            $(".submit-comment").attr("data-type", "newComment");
            $(".submit-cancelEDit").hide();
            updateCommentDetails.length = 0;

            // Hide editor UI
            $('.submit-comment').hide(500);
            $('#menuBarDiv_comment_details').hide(500);
            $('.upload-comment-image').hide(500);
            $('.comment-mention').hide(500);
            $('.chat-input').animate({ 'height': '50px' }, 'slow');
            $('.Editor-editor').animate({ 'height': '35px' }, 'slow');

        } catch (error) {
            console.error('Submit error:', error);
            swal({
                title: "Error!",
                text: error.responseJSON?.message || error.message || "Comment submit failed",
                type: "warning"
            });
        }

        $btn.prop('disabled', false);
        $btn.html(originalBtn);


        $('.Editor-editor').css({
            'height': '35px;',
            'min-height': ''
        });
        $('#chat-input-div').css('min-height', '50px');
    });

    // =====================================
    // COMMENT DRAFT SAVE (5s after edit)
    // =====================================
    let commentDraftTimer = null;

    $(document).on('input keyup', '.Editor-editor', function () {
        clearTimeout(commentDraftTimer);
        commentDraftTimer = setTimeout(function () {
            saveDraftComment();
        }, 5000);
    });

    async function saveDraftComment() {
        try {
            let project_id = $('#discussion_project_id').val();
            let section_id = $('#chat_section_id').val();
            let discussion_id = $('#chat_discussion_id').val();
            let discussion_type = $('#chat_discussion_type').val();
            let mentionedUsers = getMentionedUsers();
            let mentioned_users = mentionedUsers.join(',');
            let mentioned_groups = $('#mentioned_groups').val();

            // Get editor content
            let originalHtml = $('.Editor-editor').html();

            // Do not save empty content as draft
            if (!originalHtml || originalHtml.trim() === '' || originalHtml === '<br>' || originalHtml === '<div><br></div>') {
                return;
            }

            let tempDiv = $('<div></div>');
            tempDiv[0].innerHTML = originalHtml;

            let editorHtml = tempDiv[0].innerHTML;

            // Process mentions if needed
            let mentionMap = new Map();
            if (mentioned_users && mentioned_users != '') {
                let userIds = mentioned_users.toString().split(',');
                @foreach($activeUsers as $user)
                    for (let idx = 0; idx < userIds.length; idx++) {
                        if (userIds[idx].trim() == {{ $user->id }}) {
                            mentionMap.set('{{ $user->name }}', {{ $user->id }});
                        }
                    }
                @endforeach
            }

            if (!editorHtml.includes('mention-user-tag') && mentionMap.size > 0) {
                editorHtml = safelyReplaceMentions(editorHtml, mentionMap);
            }

            await $.ajax({
                url: '{{ route("project_management_section_discussion_comment.save_draft") }}',
                method: 'POST',
                data: {
                    project_id: project_id,
                    section_id: section_id,
                    section_discussion_id: discussion_id,
                    discussion_type: discussion_type,
                    comment: editorHtml,
                    mentioned_users: mentioned_users,
                    mentioned_groups: mentioned_groups,
                    '_token': '{{ csrf_token() }}'
                }
            });
        } catch (error) {
            console.error('Save draft error:', error);
        }
    }

    function loadDraftComment(discussion_id, discussion_type) {
        if (!discussion_id || !discussion_type) return;

        if (typeof commentDraftTimer !== 'undefined' && commentDraftTimer) {
            clearTimeout(commentDraftTimer);
        }

        $.ajax({
            url: '{{ url("project_management_section_discussion_comment/get_draft") }}/' + discussion_id + '/' + discussion_type,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response && response.success && response.data && response.data.comment) {
                    $('.Editor-editor').html(response.data.comment);
                    $('#mentioned_users').val(response.data.mentioned_users || '');
                    $('#mentioned_groups').val(response.data.mentioned_groups || '');
                } else {
                    $('.Editor-editor').html('');
                    $('#mentioned_users').val('');
                    $('#mentioned_groups').val('');
                }
            },
            error: function() {
                $('.Editor-editor').html('');
                $('#mentioned_users').val('');
                $('#mentioned_groups').val('');
            }
        });
    }

// OPEN PDF PREVIEW
$('body').on('click', '.attachment-view-btn.pdf-view', function(e){
    e.preventDefault();
    e.stopPropagation();

    let url = $(this).attr('href');
    $('#pdfPreviewFrame').attr('src', url);
    $('#pdfPreviewModal').css('display', 'flex');
});

// CLOSE PDF PREVIEW
$('body').on('click', '.pdf-preview-close', function(e){
    e.stopPropagation();
    $('#pdfPreviewModal').hide();
    $('#pdfPreviewFrame').attr('src', ''); // stop loading/free memory
});

// CLICK OUTSIDE TO CLOSE
$('body').on('click', '#pdfPreviewModal', function(e){
    if (e.target.id === 'pdfPreviewModal') {
        $('#pdfPreviewModal').hide();
        $('#pdfPreviewFrame').attr('src', '');
    }
});

// ESC TO CLOSE (extend your existing keydown handler, or add separately)
$(document).on('keydown', function(e){
    if ($('#pdfPreviewModal').is(':visible') && e.keyCode == 27){
        $('#pdfPreviewModal').hide();
        $('#pdfPreviewFrame').attr('src', '');
    }
});


    function getEditorTriggerKeyword(triggerChar) {
        const editor = document.querySelector('.Editor-editor');
        const selection = window.getSelection();

        if (!editor || !selection.rangeCount) {
            return null;
        }

        const range = selection.getRangeAt(0);
        const preRange = range.cloneRange();
        preRange.selectNodeContents(editor);
        preRange.setEnd(range.endContainer, range.endOffset);

        const text = preRange.toString();
        const regex = new RegExp('\\' + triggerChar + '([^\\s\\' + triggerChar + ']*)$');
        const match = text.match(regex);
        return match ? match[1] : null;
    }

    let productSearchTimeout = null;

    $(document).on('keyup', '.Editor-editor', function (e) {
        if (e.key === 'ArrowUp' || e.keyCode === 38 || e.key === 'ArrowDown' || e.keyCode === 40) {
            return;
        }

        const userKeyword = getEditorTriggerKeyword('@');
        const productKeyword = getEditorTriggerKeyword('#');

        if (productKeyword !== null) {
            const keyword = productKeyword.toLowerCase();
            $('.mention-dropdown-content2').hide();
            $('.products-dropdown-content').show();
            clearTimeout(productSearchTimeout);
            productSearchTimeout = setTimeout(function () {
                fetchProductSuggestions(keyword);
            }, 160);
        } else {
            $('.products-dropdown-content').hide();
        }

        if (userKeyword !== null) {
            const keyword = userKeyword.toLowerCase();
            $('.mention-dropdown-content2').show();
            $('.mention-dropdown-content2 a').each(function () {
                const userId = $(this).data('mentioned-user-id');
                // Always show @all when keyword is empty or starts with / matches 'all'
                if (userId === 'all') {
                    if (keyword === '' || 'all'.includes(keyword)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                    return;
                }
                const username = (
                    $(this).data('mentioned-user-name') || ''
                ).toLowerCase();
                if (username.includes(keyword)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            // Auto-highlight first visible item
            $('.mention-dropdown-content2 a').removeClass('keyboard-active');
            $('.mention-dropdown-content2 a:visible').first().addClass('keyboard-active');
        } else {
            $('.mention-dropdown-content2').hide();
        }
    });

    function fetchProductSuggestions(keyword) {
        const $dropdown = $('.products-dropdown-content');

        if (!keyword || keyword.length === 0) {
            $dropdown.html('<div class="mention-empty">Type # and begin typing a product name or ID</div>');
            return;
        }
        $dropdown.html('<div class="mention-empty">Loading products...</div>');

        $.ajax({
            url: '{{ route('products.comment_search') }}',
            method: 'GET',
            data: {
                keyword: keyword
            },
            success: function (response) {
                const items = [];

                if (Array.isArray(response.products)) {
                    response.products.forEach(function (product) {
                        items.push({
                            label: product.name + ' (' + product.no + ')' + (product.code ? ' - ' + product.code : ''),
                            name: product.name,
                            no: product.no,
                            id: product.id,
                            code: product.code,
                            type: product.type
                        });
                    });
                }

                if (Array.isArray(response.sub_products)) {
                    response.sub_products.forEach(function (subProduct) {
                        items.push({
                            label: subProduct.name + ' (' + subProduct.no + ')' + (subProduct.code ? ' - ' + subProduct.code : ''),
                            name: subProduct.name,
                            no: subProduct.no,
                            id: subProduct.id,
                            code: subProduct.code,
                            type: subProduct.type
                        });
                    });
                }

                renderProductSuggestions(items);
            },
            error: function (xhr, status, error) {
                console.error('Product search failed:', status, error, xhr.responseText);
                $('.products-dropdown-content').html('<div class="mention-empty">Unable to load products. Please try again.</div>');
            }
        });
    }

    function renderProductSuggestions(items) {
        const $dropdown = $('.products-dropdown-content');
        if (items.length === 0) {
            $dropdown.html('<div class="mention-empty">No products found.</div>');
            return;
        }

        const html = items.map(function (item) {
            var label = escapeHtml(item.name) + ' (' + escapeHtml(item.no) + ')';
            if (item.code) {
                label += ' - ' + escapeHtml(item.code);
            }
            return `<a href="javascript:void(0)" class="mention-product" data-product-id="${item.id}" data-product-no="${item.no}" data-product-code="${escapeHtml(item.code || '')}" data-product-name="${escapeHtml(item.name)}" data-product-type="${item.type}">${label}</a>`;
        }).join('');

        $dropdown.html(html);
    }


    $('body').on('click', '.mention-product', function (e) {
        e.preventDefault();

        const productId = $(this).data('product-id');
        const productNo = $(this).data('product-no');
        const productName = $(this).data('product-name');
        const productType = $(this).data('product-type');

        const url = productType === 'sub_product'
            ? baseUrl + '/sub_products/' + productNo
            : baseUrl + '/products/main_product/' + productId;

        const selection = window.getSelection();
        if (!selection.rangeCount) {
            return;
        }

        const range = selection.getRangeAt(0);
        let node = range.startContainer;

        if (node.nodeType === 3) {
            let text = node.textContent;
            let beforeText = text.substring(0, range.startOffset);
            beforeText = beforeText.replace(/#([^\s#]*)$/, '');
            let afterText = text.substring(range.startOffset);
            node.textContent = beforeText + afterText;
            range.setStart(node, beforeText.length);
            range.collapse(true);
            selection.removeAllRanges();
            selection.addRange(range);
        }

        const productLink = '<a href="' + url + '" class="mention-tag mention-product-tag" data-product-id="' + (productType === 'sub_product' ? productNo : productId) + '" data-product-type="' + productType + '" target="_blank">#' + escapeHtml(productName) + '</a>';

        document.execCommand('insertHTML', false, productLink);
        $('.products-dropdown-content').hide();
    });

    $(document).on('keydown', '.Editor-editor', function (e) {

    var $dropdown = $('.mention-dropdown-content2:visible');
    if ($dropdown.length === 0) {
        return; // dropdown not open, let normal typing happen
    }

    var $visibleItems = $dropdown.find('a:visible');
    if ($visibleItems.length === 0) {
        return;
    }

    var $current = $visibleItems.filter('.keyboard-active');
    var currentIndex = $current.length ? $visibleItems.index($current) : -1;

    if (e.key === 'ArrowDown' || e.keyCode === 40) {
        e.preventDefault();
        $visibleItems.removeClass('keyboard-active');
        var nextIndex = (currentIndex + 1) % $visibleItems.length;
        var $next = $visibleItems.eq(nextIndex).addClass('keyboard-active');
        if ($next[0].scrollIntoView) {
            try { $next[0].scrollIntoView({ block: 'nearest' }); } catch(err) { $next[0].scrollIntoView(); }
        }
        return;
    }

    if (e.key === 'ArrowUp' || e.keyCode === 38) {
        e.preventDefault();
        $visibleItems.removeClass('keyboard-active');
        var prevIndex = currentIndex <= 0 ? $visibleItems.length - 1 : currentIndex - 1;
        var $prev = $visibleItems.eq(prevIndex).addClass('keyboard-active');
        if ($prev[0].scrollIntoView) {
            try { $prev[0].scrollIntoView({ block: 'nearest' }); } catch(err) { $prev[0].scrollIntoView(); }
        }
        return;
    }

    if (e.key === 'Enter' || e.keyCode === 13) {
        e.preventDefault();
        var $target = $current.length ? $current : $visibleItems.first();
        $target.trigger('click');
        return;
    }

    if (e.key === 'Escape' || e.keyCode === 27) {
        $dropdown.hide();
        return;
    }

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

        var $editor = $('.Editor-editor');
        var $dropdown = $('.mention-dropdown-content2');

        var editorOffset = $editor.position();

        $dropdown.css({
            display: 'block',
            left: editorOffset.left + 10 + 'px',
            top: (editorOffset.top - $dropdown.outerHeight() - 10) + 'px',
            bottom: 'auto'
        });

    }

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

        // Handle @all — mention all project-assigned users
        if (user_id === 'all') {
            var mentioned_all = `<span class="mention-tag mention-user-tag mention-all-tag"
                data-user-id="all"
                data-mention-type="all"
                contenteditable="false">@all</span>`;

            // Insert at cursor position (or end if no cursor) + add a real trailing space
            var editor = document.querySelector('.Editor-editor');
            editor.focus();
            var sel = window.getSelection();
            var range;
            if (sel.rangeCount > 0 && editor.contains(sel.getRangeAt(0).startContainer)) {
                range = sel.getRangeAt(0);
            } else {
                range = document.createRange();
                range.selectNodeContents(editor);
                range.collapse(false);
            }
            range.deleteContents();
            var temp = document.createElement('div');
            temp.innerHTML = mentioned_all;
            var node = temp.firstChild;
            range.insertNode(node);
            var spacer = document.createTextNode('\u00A0');
            node.parentNode.insertBefore(spacer, node.nextSibling);
            var newRange = document.createRange();
            newRange.setStart(spacer, spacer.length);
            newRange.collapse(true);
            sel.removeAllRanges();
            sel.addRange(newRange);

            // Add all project assignee IDs to mentioned_users
            if (projectAssigneeIds && projectAssigneeIds.length > 0) {
                var currentMentioned = $('#mentioned_users').val();
                var existingIds = currentMentioned ? currentMentioned.split(',').map(function(x){ return x.trim(); }).filter(Boolean) : [];
                projectAssigneeIds.forEach(function(pid) {
                    var pidStr = String(pid);
                    if (existingIds.indexOf(pidStr) === -1) {
                        existingIds.push(pidStr);
                    }
                });
                $('#mentioned_users').val(existingIds.join(','));
            }

            $(".mention-dropdown-content").css("display", "none");
            $(".mention-dropdown-content2").css("display", "none");
            return;
        }

        if(user_id == 0){
            var group_name = $(this).data('mentioned-group-name');
            var group_id = $(this).data('mentioned-group-id');
            var mentioned_group = `
            <span class="mention-tag"
                data-group-id="${group_id}"
                contenteditable="false">
                @${group_name}
            </span>&nbsp;`;
            $('.Editor-editor').append(mentioned_group);

            // var group_id = $(this).data('mentioned-group-id');
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
            var mentioned_user = `
            <span class="mention-tag"
                data-user-id="${user_id}"
                contenteditable="false">
                @${user_name}
            </span>&nbsp;`;
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



    // Updated mention-user2 click handler
    function selectMentionDropdownItem($el) {

        const userId = $el.data('mentioned-user-id');
        const userName = $el.data('mentioned-user-name');

        const selection = window.getSelection();
        if (!selection.rangeCount) {
            return;
        }

        const range = selection.getRangeAt(0);
        let node = range.startContainer;

        // TEXT NODE — remove the typed @keyword
        if (node.nodeType === 3) {
            let text = node.textContent;
            let beforeText = text.substring(0, range.startOffset);
            beforeText = beforeText.replace(/@([^\s@]*)$/, '');
            let afterText = text.substring(range.startOffset);
            node.textContent = beforeText + afterText;
            range.setStart(node, beforeText.length);
            range.collapse(true);
            selection.removeAllRanges();
            selection.addRange(range);
        }

        // Handle @all — mention all project-assigned users
        if (userId === 'all') {
            const mentionHtml =
                '<span class="mention-tag mention-user-tag mention-all-tag" ' +
                'data-user-id="all" ' +
                'data-mention-type="all" ' +
                'contenteditable="false">' +
                '@all' +
                '</span>';

            var temp = document.createElement('div');
            temp.innerHTML = mentionHtml;
            var insertNode = temp.firstChild;

            var sel = window.getSelection();
            if (sel.rangeCount > 0) {
                var r = sel.getRangeAt(0);
                r.insertNode(insertNode);

                var spacer = document.createTextNode('\u00A0');
                insertNode.parentNode.insertBefore(spacer, insertNode.nextSibling);

                var newRange = document.createRange();
                newRange.setStart(spacer, spacer.length);
                newRange.collapse(true);
                sel.removeAllRanges();
                sel.addRange(newRange);
            }

            // Add all project assignee IDs to mentioned_users
            if (projectAssigneeIds && projectAssigneeIds.length > 0) {
                var currentMentioned = $('#mentioned_users').val();
                var existingIds = currentMentioned ? currentMentioned.split(',').map(function(x){ return x.trim(); }).filter(Boolean) : [];
                projectAssigneeIds.forEach(function(pid) {
                    var pidStr = String(pid);
                    if (existingIds.indexOf(pidStr) === -1) {
                        existingIds.push(pidStr);
                    }
                });
                $('#mentioned_users').val(existingIds.join(','));
            }

            $('.mention-dropdown-content2').hide();
            mentionDropdownItems = [];
            mentionActiveIndex = -1;
            return;
        }

        // Normal single user mention
        const mentionHtml =
            '<span class="mention-tag mention-user-tag" ' +
            'data-user-id="' + userId + '" ' +
            'data-mention-type="user" ' +
            'contenteditable="false">' +
            '@' + userName +
            '</span>';

        // insert mention
        var temp = document.createElement('div');
        temp.innerHTML = mentionHtml;
        var insertNode = temp.firstChild;

        var sel = window.getSelection();
        if (sel.rangeCount > 0) {
            var r = sel.getRangeAt(0);
            r.insertNode(insertNode);

            var spacer = document.createTextNode('\u00A0');
            insertNode.parentNode.insertBefore(spacer, insertNode.nextSibling);

            var newRange = document.createRange();
            newRange.setStart(spacer, spacer.length);
            newRange.collapse(true);
            sel.removeAllRanges();
            sel.addRange(newRange);
        }

        // Track mentioned user ID
        var currentMentioned = $('#mentioned_users').val();
        var existingIds = currentMentioned ? currentMentioned.split(',').map(function(x){ return x.trim(); }).filter(Boolean) : [];
        var userIdStr = String(userId);
        if (existingIds.indexOf(userIdStr) === -1) {
            existingIds.push(userIdStr);
            $('#mentioned_users').val(existingIds.join(','));
        }

        $('.mention-dropdown-content2').hide();
        mentionDropdownItems = [];
        mentionActiveIndex = -1;
    }

    $(document).on('click', '.mention-user2', function (e) {
        e.preventDefault();
        selectMentionDropdownItem($(this));
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
                            updateTaskAttachmentsList();
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
        });

    });



    function convertUrlsToLinks() {
        $('.comment-text').each(function () {
            const $container = $(this);

            if ($container.data('urls-processed')) {
                return;
            }

            $container
                .find('*')
                .addBack()
                .contents()
                .filter(function () {
                    return (
                        this.nodeType === Node.TEXT_NODE &&
                        this.parentNode &&
                        this.parentNode.nodeName !== 'A' &&
                        /(https?:\/\/[^\s<]+)/i.test(this.nodeValue)
                    );
                })
                .each(function () {
                    const textNode = this;
                    const text = textNode.nodeValue;

                    const html = text.replace(
                        /(https?:\/\/[^\s<]+)/gi,
                        function (url) {
                            const trailingMatch = url.match(/[.,!?;:)\]]+$/);
                            const trailingText = trailingMatch
                                ? trailingMatch[0]
                                : '';

                            const cleanUrl = trailingText
                                ? url.slice(0, -trailingText.length)
                                : url;

                            // Do not convert direct image URLs into links.
                            if (
                                /\.(jpg|jpeg|png|gif|webp|svg)(\?.*)?$/i.test(
                                    cleanUrl
                                )
                            ) {
                                return cleanUrl + trailingText;
                            }

                            return (
                                '<a href="' +
                                cleanUrl +
                                '" target="_blank" ' +
                                'rel="noopener noreferrer">' +
                                cleanUrl +
                                '</a>' +
                                trailingText
                            );
                        }
                    );

                    $(textNode).replaceWith(html);
                });

            $container.data('urls-processed', true);
        });
    }


    function updateTaskAttachmentsList() {

        let attachments = [];
        let seenUrls = new Set();

        // Scan Description display
        let $descDisplay = $('#discussion_description_display');
        if ($descDisplay.length) {
            $descDisplay.find('img').each(function() {
                let src = $(this).attr('src');
                if (!src || src.startsWith('blob:') || src.startsWith('data:')) return;
                if (!seenUrls.has(src)) {
                    seenUrls.add(src);
                    let name = src.split('/').pop();
                    attachments.push({
                        name: name,
                        url: src,
                        ext: (name.split('.').pop() || '').toLowerCase(),
                        source: 'description'
                    });
                }
            });
            $descDisplay.find('a').each(function() {
                let href = $(this).attr('href');
                if (!href || href.startsWith('javascript:') || href.startsWith('#')) return;
                if (!seenUrls.has(href)) {
                    seenUrls.add(href);
                    let name = $(this).text().trim() || href.split('/').pop();
                    attachments.push({
                        name: name,
                        url: href,
                        ext: (name.split('.').pop() || '').toLowerCase(),
                        source: 'description'
                    });
                }
            });
        }

        $('.previous-chats-tbody .comment-text').each(function() {

            let $comment = $(this);
            let commentId = $comment.attr('id') ? $comment.attr('id').replace('discussion_comment_', '') : null;

            $comment.find('img').each(function() {

            let src = $(this).attr('src');

            if (
                !src ||
                src.includes('profile_pic') ||
                src.includes('user/default.png') ||
                src.startsWith('blob:') ||
                src.startsWith('data:')
            ) {
                return;
            }

                if (!seenUrls.has(src)) {

                    seenUrls.add(src);

                    let name = src.split('/').pop();

                    attachments.push({
                        name: name,
                        url: src,
                        ext: (name.split('.').pop() || '').toLowerCase(),
                        source: 'comment',
                        commentId: commentId
                    });
                }
            });

            $comment.find('.attachment-file-row').each(function() {

                let fileName = $(this)
                    .find('.attachment-file-name')
                    .text()
                    .trim();

                let href = $(this)
                    .find('.attachment-download-btn')
                    .attr('href');

                if (!fileName || !href) {
                    return;
                }

                if (seenUrls.has(href)) {
                    return;
                }

                seenUrls.add(href);

                attachments.push({
                    name: fileName,
                    url: href,
                    ext: (fileName.split('.').pop() || '').toLowerCase(),
                    source: 'comment',
                    commentId: commentId
                });
            });

            $comment.find('a').each(function() {
                if ($(this).closest('.attachment-file-row').length) {
                    return;
                }
                let href = $(this).attr('href');
                if (!href || href.startsWith('javascript:') || href.startsWith('#')) return;
                if (seenUrls.has(href)) return;

                seenUrls.add(href);
                let name = $(this).text().trim() || href.split('/').pop();
                attachments.push({
                    name: name,
                    url: href,
                    ext: (name.split('.').pop() || '').toLowerCase(),
                    source: 'comment',
                    commentId: commentId
                });
            });

        });

        $('#task_attachments_list').empty();

        $('#task_attachments_count').text(attachments.length);

        attachments.forEach(function(file) {

        // let iconClass = getFileIconByExt(file.ext);

        //     $('#task_attachments_list').append(
        //         '<div class="task-attachment-item">' +
        //             '<i class="' + iconClass + ' task-attachment-icon"></i>' +
        //             '<span class="task-attachment-name">' +
        //                 file.name +
        //             '</span>' +
        //             '<a href="' + file.url + '" ' +
        //                 'class="attachment-download-btn" ' +
        //                 'target="_blank" ' +
        //                 'download>' +
        //                 '<i class="fa fa-download"></i> Download' +
        //             '</a>' +
        //         '</div>'
        //     );
        let iconClass = getFileIconByExt(file.ext);

        let canView = ['pdf','jpg','jpeg','png','gif','webp'].indexOf(file.ext) !== -1;
        let isPdf = file.ext === 'pdf';
        let isImg = ['jpg','jpeg','png','gif','webp'].indexOf(file.ext) !== -1;

        let viewBtn = '';
        if (canView) {
            if (isPdf) {
                viewBtn = '<a href="' + file.url + '" class="attachment-download-btn attachment-view-btn pdf-view">' +
                            '<i class="fa fa-eye"></i> View</a>';
            } else if (isImg) {
                viewBtn = '<a href="javascript:void(0)" class="attachment-download-btn attachment-view-btn task-attachment-view-img" data-url="' + file.url + '">' +
                            '<i class="fa fa-eye"></i> View</a>';
            }
        }

        let deleteBtn = '<button type="button" class="attachment-delete-btn delete-task-attachment-btn" ' +
                        'data-url="' + file.url + '" ' +
                        'data-source="' + file.source + '" ' +
                        (file.commentId ? 'data-comment-id="' + file.commentId + '" ' : '') +
                        'title="Delete Attachment">' +
                        '<i class="fa fa-trash"></i> Delete' +
                        '</button>';

        $('#task_attachments_list').append(
            '<div class="task-attachment-item">' +
                '<i class="' + iconClass + ' task-attachment-icon"></i>' +
                '<span class="task-attachment-name">' +
                    file.name +
                '</span>' +
                viewBtn +
                '<a href="' + file.url + '" ' +
                    'class="attachment-download-btn" ' +
                    'target="_blank" ' +
                    'download>' +
                    '<i class="fa fa-download"></i> Download' +
                '</a>' +
                deleteBtn +
            '</div>'
        );

    });

    }

    // Handle delete task attachment action
    $('body').on('click', '.delete-task-attachment-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();

        let url = $(this).attr('data-url');
        let source = $(this).attr('data-source');
        let commentId = $(this).attr('data-comment-id');

        Swal.fire({
            title: "Confirm Delete?",
            text: "Do you want to delete this attachment?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value == true) {
                if (source === 'comment') {
                    let $commentDiv = $('#discussion_comment_' + commentId);
                    if ($commentDiv.length) {
                        let found = false;

                        // 1. Remove standard images or wrapped comment images
                        $commentDiv.find('img').each(function() {
                            if ($(this).attr('src') === url) {
                                let $parent = $(this).closest('.comment-attachment');
                                if ($parent.length) {
                                    $parent.remove();
                                } else {
                                    $(this).remove();
                                }
                                found = true;
                            }
                        });

                        // 2. Remove standard attachment rows
                        $commentDiv.find('.attachment-file-row').each(function() {
                            let href = $(this).find('.attachment-download-btn').attr('href');
                            if (href === url) {
                                $(this).remove();
                                found = true;
                            }
                        });

                        // 3. Remove inline links
                        $commentDiv.find('a').each(function() {
                            let href = $(this).attr('href');
                            if (href === url) {
                                $(this).remove();
                                found = true;
                            }
                        });

                        if (found) {
                            let updatedHtml = $commentDiv.html();
                            $.ajax({
                                url: '{{ url("project_management_section_discussion_comment/update") }}/' + commentId,
                                method: 'POST',
                                data: {
                                    comment: updatedHtml,
                                    '_token': '{{ csrf_token() }}'
                                },
                                success: function(data) {
                                    swal({
                                        title: "Deleted!",
                                        text: "Attachment has been deleted.",
                                        type: "success",
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    updateTaskAttachmentsList();
                                },
                                error: function(xhr, status, error) {
                                    swal({
                                        title: "Error!",
                                        text: error,
                                        type: "warning",
                                        confirmButtonColor: '#5fb644',
                                    });
                                }
                            });
                        }
                    }
                } else if (source === 'description') {
                    let descVal = $('#discussion_description').val();
                    let newDescVal = descVal.replace(url, '').trim();

                    let discussion_id = $('#chat_discussion_id').val();
                    let discussion_type = $('#chat_discussion_type').val();

                    $.ajax({
                        url: discussionUpdateUrl[discussion_type] + discussion_id,
                        method: 'POST',
                        data: {
                            discussion_description: newDescVal,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#discussion_description').val(newDescVal);
                            showDescriptionDisplay(newDescVal);
                            swal({
                                title: "Deleted!",
                                text: "Attachment has been deleted from description.",
                                type: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            updateTaskAttachmentsList();
                        },
                        error: function(xhr, status, error) {
                            swal({
                                title: "Error!",
                                text: error,
                                type: "warning",
                                confirmButtonColor: '#5fb644',
                            });
                        }
                    });
                }
            }
        });
    });

    // ATTACHMENT LIST - IMAGE VIEW
    $('body').on('click', '.task-attachment-view-img', function(e){
        e.preventDefault();
        e.stopPropagation();

        let url = $(this).attr('data-url');
        previewImages = [url];
        currentPreviewIndex = 0;

        $('#previewImage').attr('src', url);
        $('#imagePreviewModal').css('display', 'flex');
        showPreviewImage(0);
    });

    /* HANDLE ATTACHMENT PREVIEW/CLICK */
    $('body').on('click', '.preview-task-attachment', function() {
        let url = $(this).attr('data-url');
        let isImg = $(this).attr('data-is-img') === '1';
        let name = $(this).attr('data-name');

        if (isImg) {
            $('#previewImage').attr('src', url);
            $('#imagePreviewModal').css('display', 'flex');
        } else {
            window.open(url, '_blank');
        }
    });

    /* HANDLE ATTACHMENT UPLOAD FROM + ICON */
    $('#add_task_attachment_btn').on('click', function() {
        $('#task_attachment_input').click();
    });

    $('#task_attachment_input').on('change', async function() {
        let files = this.files;
        if (!files || files.length === 0) return;

        let project_id = $('#discussion_project_id').val();
        let section_id = $('#chat_section_id').val();
        let discussion_id = $('#chat_discussion_id').val();

        let fd = new FormData();
        for (let i = 0; i < files.length; i++) {
            fd.append('upload_file[]', files[i]);
        }
        fd.append('project_id', project_id);
        fd.append('_token', '{{ csrf_token() }}');

        try {
            swal({
                title: "Uploading...",
                text: "Please wait while we upload your attachments.",
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    swal.showLoading();
                }
            });

            let uploadResp = await $.ajax({
                url: '{{ route("project_management_section_discussion_comment.file_upload.temp") }}',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false
            });

            let urls = [];
            if (Array.isArray(uploadResp)) {
                urls = uploadResp;
            } else if (uploadResp.data) {
                urls = uploadResp.data;
            } else if (uploadResp.files) {
                urls = uploadResp.files;
            }

            let commentHtml = '';
            urls.forEach(url => {
                let fileName = url.split('/').pop();
                let ext = fileName.split('.').pop().toLowerCase();

                if (isImageExt(ext)) {
                    commentHtml += `<p><img src="${url}" style="max-width:200px;"></p>`;
                } else {
                    let iconClass = getFileIconByExt(ext);
                    commentHtml += `
                        <p>
                            <a href="${url}" target="_blank" download="${fileName}" style="text-decoration:none;">
                                <i class="${iconClass}" style="margin-right:6px;"></i>
                                ${fileName}
                            </a>
                        </p>`;
                }
            });

            /* STORE AS A COMMENT */
            let storeResp = await $.ajax({
                url: '{{ url("project_management_section_discussion_comment/store") }}',
                method: 'POST',
                data: {
                    project_id: project_id,
                    section_id: section_id,
                    discussion_id: discussion_id,
                    comment: commentHtml,
                    '_token': '{{ csrf_token() }}'
                }
            });

            appendNewComment(project_id, section_id, discussion_id, storeResp);
            updateTaskAttachmentsList();
            swal.close();
            $('#task_attachment_input').val('');

        } catch (e) {
            console.error("Attachment upload failed", e);
            swal("Error!", "Failed to upload attachments.", "error");
        }
    });



    $(document).on('click', '.mention-user-tag', function(e) {
        e.stopPropagation();
        e.preventDefault();

        let userId = $(this).data('user-id');
        let profileUrl = $(this).data('profile-url');

        if(userId && userId > 0) {
            // Use the stored profile URL or construct it
            if(profileUrl) {
                window.open(profileUrl, '_blank');
            } else {
                var url = baseUrl + '/view/employee/profile/' + userId;
                window.open(url, '_blank');
            }
        }
        return false;
    });


    $('body').on('click', '.btn-pin-comment', function(e) {
        e.stopPropagation();
        e.preventDefault();

        let $btn = $(this);
        let commentId = $btn.data('comment-id');
        let isCurrentlyPinned = $btn.data('is-pinned') == 1;

        // Show loading
        $btn.prop('disabled', true);
        $btn.html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: '{{ url("comment/toggle-pin") }}/'+commentId,
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Reload the comments
                    let discussion_id = $('#chat_discussion_id').val();
                    let discussion_type = $('#chat_discussion_type').val();
                    openChat(discussion_id, discussion_type);
                } else {
                    alert(response.message || 'Failed to pin/unpin comment');
                    $btn.prop('disabled', false);
                    $btn.html('<i class="fa-solid fa-thumbtack"></i> ' + (isCurrentlyPinned ? 'Pin to top' : 'Unpin from top'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Pin error:', error);
                alert('Failed to pin/unpin comment. Please try again.');
                $btn.prop('disabled', false);
                $btn.html('<i class="fa-solid fa-thumbtack"></i> ' + (isCurrentlyPinned ? 'Pin to top' : 'Unpin from top'));
            }
        });


    });



    const REACTION_TYPES = {
        like: { emoji: '👍', label: 'Like', icon: 'fa-regular fa-thumbs-up', iconActive: 'fa-solid fa-thumbs-up' },
        heart: { emoji: '❤️', label: 'Love', icon: 'fa-regular fa-heart', iconActive: 'fa-solid fa-heart' },
        surprise: { emoji: '😲', label: 'Surprise', icon: 'fa-regular fa-face-surprise', iconActive: 'fa-solid fa-face-surprise' },
        sad: { emoji: '😢', label: 'Sad', icon: 'fa-regular fa-face-frown', iconActive: 'fa-solid fa-face-frown' },
        cry: { emoji: '😭', label: 'Cry', icon: 'fa-regular fa-face-sad-cry', iconActive: 'fa-solid fa-face-sad-cry' },
        sweat: { emoji: '😅', label: 'Sweat', icon: 'fa-regular fa-face-grin-beam-sweat', iconActive: 'fa-solid fa-face-grin-beam-sweat' },
        angry: { emoji: '😠', label: 'Angry', icon: 'fa-regular fa-face-angry', iconActive: 'fa-solid fa-face-angry' },
        tongue: { emoji: '😜', label: 'Silly', icon: 'fa-regular fa-face-grin-tongue-wink', iconActive: 'fa-solid fa-face-grin-tongue-wink' },
        tears: { emoji: '😂', label: 'Hysterical', icon: 'fa-regular fa-face-grin-tears', iconActive: 'fa-solid fa-face-grin-tears' }
    };

    function createReactionPicker(commentId) {
        let html = '<div class="reaction-picker" id="reaction-picker-' + commentId + '">';
        for (const [type, config] of Object.entries(REACTION_TYPES)) {
            html += `<button class="reaction-picker-btn" data-reaction-type="${type}" data-comment-id="${commentId}" title="${config.label}">
                        ${config.emoji}
                    </button>`;
        }
        html += '</div>';
        return html;
    }

    function formatReactionsDisplay(reactions, userReaction, commentId) {
        if (!reactions || Object.keys(reactions).length === 0) {
            return '';
        }

        let html = '<div class="reaction-display">';
        const sortedReactions = Object.entries(reactions).sort((a, b) => b[1] - a[1]);

        for (const [type, count] of sortedReactions) {
            const config = REACTION_TYPES[type];
            if (config && count > 0) {
                const activeClass = (userReaction === type) ? 'active' : '';
                html += `<div class="reaction-bubble ${activeClass}" data-reaction-type="${type}" data-comment-id="${commentId}">
                            <span class="reaction-emoji">${config.emoji}</span>
                            <span class="reaction-count">${count}</span>
                        </div>`;
            }
        }
        html += '</div>';
        return html;
    }

    function toggleReaction(commentId, reactionType) {
        // If reactionType is empty or null, we want to remove the reaction
        var dataToSend = {
            reaction_type: reactionType,
            '_token': '{{ csrf_token() }}'
        };

        // If no reactionType provided, send empty to remove
        if (!reactionType) {
            dataToSend.reaction_type = '';
        }

        $.ajax({
            url: '{{ url("comment/toggle-reaction/") }}/'+ commentId,
            method: 'POST',
            data: dataToSend,
            success: function(response) {
                if (response.success) {
                    updateCommentReactions(commentId, response.reactions, response.user_reaction);
                }
            },
            error: function(xhr) {
                console.error('Reaction error:', xhr);
                Swal.fire('Error!', 'Failed to add reaction', 'error');
            }
        });
    }

    function updateCommentReactions(commentId, reactions, userReaction) {
        const $row = $('#comment_row_' + commentId);
        const $existingDisplay = $row.find('.reaction-display-container');
        const reactionsHtml = formatReactionsDisplay(reactions, userReaction, commentId);

        if ($existingDisplay.length) {
            $existingDisplay.html(reactionsHtml);
        } else {
            $row.find('.comment-body').append('<div class="reaction-display-container">' + reactionsHtml + '</div>');
        }

        const $likeBtnWrapper = $row.find('.like-btn-wrapper');
        const $likeBtn = $likeBtnWrapper.find('.like-btn');

        if (userReaction && REACTION_TYPES[userReaction]) {
            const config = REACTION_TYPES[userReaction];
            $likeBtn.html(`<i class="${config.iconActive}"></i>`);
            $likeBtn.addClass('has-reaction');
            $likeBtn.data('current-reaction', userReaction);
        } else {
            $likeBtn.html(`<i class="fa-regular fa-thumbs-up"></i>`);
            $likeBtn.removeClass('has-reaction');
            $likeBtn.data('current-reaction', '');
        }
    }

    function initReactionPickers() {
        $('.like-btn-wrapper').each(function() {
            const $wrapper = $(this);
            const commentId = $wrapper.data('comment-id');
            if ($wrapper.find('.reaction-picker').length === 0) {
                $wrapper.append(createReactionPicker(commentId));
            }
        });
    }


    $(document).on('mouseenter', '.like-btn-wrapper', function() {
        const $wrapper = $(this);
        const $picker = $wrapper.find('.reaction-picker');
        if ($picker.length) {
            $picker.addClass('show');
        }
    });

    $(document).on('mouseleave', '.like-btn-wrapper', function() {
        const $wrapper = $(this);
        const $picker = $wrapper.find('.reaction-picker');
        setTimeout(function() {
            if (!$picker.is(':hover')) {
                $picker.removeClass('show');
            }
        }, 200);
    });

    $(document).on('mouseenter', '.reaction-picker', function() {
        $(this).addClass('show');
    });

    $(document).on('mouseleave', '.reaction-picker', function() {
        $(this).removeClass('show');
    });

    $(document).on('click', '.reaction-picker-btn', function(e) {
        e.stopPropagation();
        const commentId = $(this).data('comment-id');
        const reactionType = $(this).data('reaction-type');
        toggleReaction(commentId, reactionType);
        $(this).closest('.reaction-picker').removeClass('show');
    });

    $(document).on('click', '.reaction-bubble', function(e) {
        e.stopPropagation();
        const commentId = $(this).data('comment-id');
        const reactionType = $(this).data('reaction-type');
        toggleReaction(commentId, reactionType);
    });


    $(document).off('click', '.like-btn');
    $(document).on('click', '.like-btn', function(e) {
        e.stopPropagation();
        const $btn = $(this);
        const $wrapper = $btn.closest('.like-btn-wrapper');
        const commentId = $wrapper.data('comment-id');
        const currentReaction = $btn.data('current-reaction') || '';

        if (currentReaction) {
            // Remove the reaction - send empty string
            toggleReaction(commentId, '');
        } else {
            // Show reaction picker for new reaction
            const $picker = $wrapper.find('.reaction-picker');
            if ($picker.length) {
                $picker.addClass('show');
                setTimeout(function() {
                    $picker.removeClass('show');
                }, 3000);
            }
        }
    });




</script>
<script>
$(document).ready(function () {

    let savedRange = null;
    let editingLink = null;

    function getEditor() {
        return document.querySelector('.Editor-editor');
    }

    function saveEditorSelection() {
        let editor = getEditor();
        let selection = window.getSelection();

        savedRange = null;
        editingLink = null;

        if (!editor || !selection.rangeCount) {
            return;
        }

        if (!editor.contains(selection.anchorNode)) {
            return;
        }

        savedRange = selection.getRangeAt(0).cloneRange();

        let node = savedRange.commonAncestorContainer;

        if (node.nodeType === 3) {
            node = node.parentNode;
        }

        editingLink = $(node).closest('a')[0] || null;
    }

    function restoreEditorSelection() {
        let editor = getEditor();
        let selection = window.getSelection();

        if (!editor) {
            return;
        }

        editor.focus();

        selection.removeAllRanges();

        if (savedRange) {
            selection.addRange(savedRange);
        }
    }

    function cleanUrl(url) {
        url = $.trim(url || '');

        if (url === '') {
            return '';
        }

        if (/^(javascript|data|vbscript):/i.test(url)) {
            return '';
        }

        if (!/^(https?:\/\/|mailto:|tel:|ftp:\/\/|\/|#)/i.test(url)) {
            url = 'https://' + url;
        }

        return url;
    }

    function closeLinkModal() {
        $('#InsertLink_comment_details').modal('hide');

        $('#inputText_comment_details').val('');
        $('#inputUrl_comment_details').val('');
        $('#errMsg_comment_details').html('');

        setTimeout(function () {
            if (!$('.modal.show').length) {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css('padding-right', '');
            }
        }, 300);
    }

    function syncEditorToTextarea() {
        $('#comment_details').val($('.Editor-editor').html());
    }

    // Save selected text from editor
    $(document).on('mouseup keyup input', '.Editor-editor', function () {
        saveEditorSelection();
        syncEditorToTextarea();
    });

    // Open hyperlink modal
    $(document).on(
        'mousedown click',
        '#menuBarDiv_comment_details a[href="#InsertLink_comment_details"], #menuBarDiv_comment_details .fa-link',
        function (e) {
            e.preventDefault();
            e.stopPropagation();

            saveEditorSelection();

            let textToDisplay = '';
            let url = '';

            if (editingLink) {
                textToDisplay = $(editingLink).text();
                url = $(editingLink).attr('href') || '';
            } else if (savedRange) {
                textToDisplay = savedRange.toString();
            }

            $('#inputText_comment_details').val(textToDisplay);
            $('#inputUrl_comment_details').val(url);
            $('#errMsg_comment_details').html('');

            $('#InsertLink_comment_details').modal('show');

            setTimeout(function () {
                $('#inputText_comment_details').focus();
            }, 200);
        }
    );

    // Keep modal editable
    $(document).on(
        'mousedown click keydown',
        '#InsertLink_comment_details, #InsertLink_comment_details input, #InsertLink_comment_details button',
        function (e) {
            e.stopPropagation();
        }
    );

    // Done button
    $(document).on('click', '#InsertLink_comment_details .btn-success', function (e) {
        e.preventDefault();
        e.stopPropagation();

        let text = $.trim($('#inputText_comment_details').val());
        let url = cleanUrl($('#inputUrl_comment_details').val());

        if (url === '') {
            $('#errMsg_comment_details').html('<small class="text-danger">Please enter valid URL.</small>');
            return;
        }

        if (text === '') {
            text = url;
        }

        let editor = getEditor();

        if (!editor) {
            return;
        }

        // Edit selected existing link
        if (editingLink && editor.contains(editingLink)) {
            $(editingLink)
                .attr('href', url)
                .attr('target', '_blank')
                .attr('rel', 'noopener noreferrer')
                .removeAttr('download')
                .addClass('comment-hyperlink')
                .text(text);
        } else {
            // Create new link
            restoreEditorSelection();

            let selection = window.getSelection();
            let range;

            if (selection.rangeCount) {
                range = selection.getRangeAt(0);
            } else {
                range = document.createRange();
                range.selectNodeContents(editor);
                range.collapse(false);
            }

            range.deleteContents();

            let link = document.createElement('a');
            link.href = url;
            link.target = '_blank';
            link.rel = 'noopener noreferrer';
            link.className = 'comment-hyperlink';
            link.textContent = text;

            range.insertNode(link);

            let space = document.createTextNode(' ');
            link.after(space);

            range.setStartAfter(space);
            range.collapse(true);

            selection.removeAllRanges();
            selection.addRange(range);
        }

        syncEditorToTextarea();

        savedRange = null;
        editingLink = null;

        closeLinkModal();
    });

    // Cancel button
    $(document).on(
        'click',
        '#InsertLink_comment_details [data-dismiss="modal"], #InsertLink_comment_details .btn-secondary',
        function (e) {
            e.preventDefault();
            e.stopPropagation();

            savedRange = null;
            editingLink = null;

            closeLinkModal();
        }
    );

    // Open saved hyperlink in new tab
    $(document).on('click', '.comment-text a.comment-hyperlink', function (e) {
        e.preventDefault();
        e.stopPropagation();

        window.open(this.href, '_blank', 'noopener,noreferrer');
    });

    // Before submit/update comment, sync editor HTML
    $(document).on('click', '.submit-comment', function () {
        syncEditorToTextarea();
    });

});
</script>

<script>
function formatAttachmentFooters() {

    $('.comment-text').each(function () {

        let container = $(this);
        let commentIdAttr = container.attr('id');
        let commentId = commentIdAttr ? commentIdAttr.replace('discussion_comment_', '') : '';

        // Heal existing footers
        container.find('.attachment-footer').each(function() {
            let $footer = $(this);
            if ($footer.find('.delete-task-attachment-btn').length === 0) {
                let $dlBtn = $footer.find('.attachment-download-btn, a[download]');
                let src = $dlBtn.attr('href');
                if (src && commentId) {
                    let deleteBtn = '<button type="button" class="attachment-delete-btn delete-task-attachment-btn" ' +
                                    'data-url="' + src + '" ' +
                                    'data-source="comment" ' +
                                    'data-comment-id="' + commentId + '" ' +
                                    'title="Delete Attachment">' +
                                    '<i class="fa fa-trash"></i> Delete' +
                                    '</button>';
                    $footer.append(deleteBtn);
                }
            }
        });

        container.find('.attachment-file-row').each(function() {
            let $row = $(this);
            if ($row.find('.delete-task-attachment-btn').length === 0) {
                let $dlBtn = $row.find('.attachment-download-btn, a[download]');
                let href = $dlBtn.attr('href');
                if (href && commentId) {
                    let deleteBtn = '<button type="button" class="attachment-delete-btn delete-task-attachment-btn" ' +
                                    'data-url="' + href + '" ' +
                                    'data-source="comment" ' +
                                    'data-comment-id="' + commentId + '" ' +
                                    'title="Delete Attachment">' +
                                    '<i class="fa fa-trash"></i> Delete' +
                                    '</button>';
                    $row.append(deleteBtn);
                }
            }
        });

        /*
         * Normal hyperlinks
         * Keep as clickable <a> tag.
         * Do not convert to attachment.
         */
        container.find('a[href]').each(function () {

            let link = $(this);

            if (link.closest('.comment-attachment').length) {
                return;
            }

            if (link.closest('.attachment-footer, .attachment-file-row').length) {
                return;
            }

            if (link.closest('.mention-tag, .mention-user-tag, .mention-group').length) {
                return;
            }

            link
                .addClass('comment-hyperlink')
                .attr('target', '_blank')
                .attr('rel', 'noopener noreferrer')
                .removeAttr('download');
        });

        /*
         * Image attachments
         * Only format images inside .comment-attachment.
         */
        container.find('.comment-attachment img').each(function () {

            let img = $(this);

            if (img.closest('.attachment-wrapper').length) {
                return;
            }

            let src = img.attr('src') || '';

            if (src.includes('profile_pic') || src.includes('user/default.png')) {
                return;
            }

            let fileName = src.split('/').pop();

            let deleteBtn = commentId ? '<button type="button" class="attachment-delete-btn delete-task-attachment-btn" ' +
                                        'data-url="' + src + '" ' +
                                        'data-source="comment" ' +
                                        'data-comment-id="' + commentId + '" ' +
                                        'title="Delete Attachment">' +
                                        '<i class="fa fa-trash"></i> Delete' +
                                        '</button>' : '';

            img.wrap('<div class="attachment-wrapper"></div>');

            img.after(
                '<div class="attachment-footer">' +
                    '<span class="attachment-file-name">' + fileName + '</span>' +
                    '<a href="' + src + '" target="_blank" download="' + fileName + '" class="attachment-download-btn">Download</a>' +
                    deleteBtn +
                '</div>'
            );
        });

        /*
         * File attachments
         * Only links inside .comment-attachment become attachment rows.
         */
        container.find('.comment-attachment a[href]').each(function () {

            let link = $(this);

            if (link.closest('.attachment-footer, .attachment-file-row').length) {
                return;
            }

            let href = link.attr('href') || '';
            let fileName = link.text().trim();

            if (fileName === '' || fileName === 'Download') {
                fileName = href.split('/').pop();
            }

            let deleteBtn = commentId ? '<button type="button" class="attachment-delete-btn delete-task-attachment-btn" ' +
                                        'data-url="' + href + '" ' +
                                        'data-source="comment" ' +
                                        'data-comment-id="' + commentId + '" ' +
                                        'title="Delete Attachment">' +
                                        '<i class="fa fa-trash"></i> Delete' +
                                        '</button>' : '';

            link.replaceWith(
                '<div class="attachment-file-row">' +
                    '<span class="attachment-file-name">' + fileName + '</span>' +
                    '<a href="' + href + '" target="_blank" download="' + fileName + '" class="attachment-download-btn">Download</a>' +
                    deleteBtn +
                '</div>'
            );
        });

    });

    fixCommentAttachmentBadges();
}

function commentHasRealAttachmentsFromElement(commentTextElement) {

    let container = $(commentTextElement);

    if (container.find('.comment-attachment').length > 0) {
        return true;
    }

    if (container.find('.attachment-wrapper').length > 0) {
        return true;
    }

    if (container.find('.attachment-file-row').length > 0) {
        return true;
    }

    return false;
}

function fixCommentAttachmentBadges() {

    $('.comment-row').each(function () {

        let row = $(this);
        let commentText = row.find('.comment-text').first();
        let badge = row.find('.comment-attachment-badge');

        if (!commentText.length) {
            return;
        }

        if (commentHasRealAttachmentsFromElement(commentText)) {
            if (!badge.length) {
                row.find('.comment-author').after(
                    '<span class="comment-attachment-badge"><i class="fa-solid fa-paperclip"></i> Attached</span>'
                );
            }
        } else {
            badge.remove();
        }

    });
}
function keepCommentEditorOpen() {

    $('.chat-input, .Editor-editor').stop(true, true);

    $('#menuBarDiv_comment_details').show();
    $('.submit-comment').show();
    $('.upload-comment-image').show();
    $('.comment-mention').show();

    $('.Editor-editor').css({
        height: '150px',
        'min-height': '150px'
    });

    $('.chat-input').css({
        height: '250px',
        'min-height': '250px'
    });
}

/* Drag-to-scroll functionality for .scrollable-section */
(function() {
    let isMouseDown = false;
    let startY = 0;
    let startScrollTop = 0;
    let isDragging = false;
    let justDragged = false;
    let activeContainer = null;
    const dragThreshold = 4;

    document.addEventListener('mousedown', function(e) {
        if (e.button !== 0) return;

        const container = e.target.closest('.scrollable-section');
        if (!container) return;

        // Check if user clicked directly on the vertical scrollbar track/thumb on the right edge
        const rect = container.getBoundingClientRect();
        if (e.clientX >= rect.left + container.clientWidth) {
            return; // Let native browser scrollbar drag work seamlessly
        }

        // Skip drag-scrolling when clicking interactive elements (form fields, buttons, links, dropdowns)
        if (e.target.closest('input, textarea, select, button, a, .btn, .mention-user-tag, .mention-tag, .like-btn, .reaction-bubble, .reaction-picker-btn, .comment-dropbtn, [contenteditable="true"]')) {
            return;
        }

        isMouseDown = true;
        isDragging = false;
        activeContainer = container;
        startY = e.pageY;
        startScrollTop = container.scrollTop;
    });

    document.addEventListener('mousemove', function(e) {
        if (!isMouseDown || !activeContainer) return;

        const deltaY = e.pageY - startY;

        if (!isDragging && Math.abs(deltaY) > dragThreshold) {
            isDragging = true;
            activeContainer.classList.add('is-dragging');
            // Clear text selection range so blue highlight doesn't linger during drag-scroll
            if (window.getSelection) {
                window.getSelection().removeAllRanges();
            }
        }

        if (isDragging) {
            e.preventDefault();
            activeContainer.scrollTop = startScrollTop - deltaY;
        }
    });

    function endDrag() {
        if (isMouseDown) {
            isMouseDown = false;
            if (isDragging) {
                justDragged = true;
                setTimeout(function() {
                    justDragged = false;
                }, 100);
            }
            if (activeContainer) {
                activeContainer.classList.remove('is-dragging');
                activeContainer = null;
            }
            isDragging = false;
        }
    }

    document.addEventListener('mouseup', endDrag);
    window.addEventListener('blur', endDrag);

    // Dynamically align sideview modal top with navbar bottom on mobile screens (iOS & Android)
    function updateMobileNavTop() {
        if (window.innerWidth > 767) return;
        var nav = document.getElementById('sidenav-main') || document.querySelector('.responsive_top_bar') || document.querySelector('.navbar');
        if (nav) {
            var rect = nav.getBoundingClientRect();
            var navH = nav.offsetHeight || 65;
            var bottom = rect.bottom > 0 ? Math.max(rect.bottom, navH) : navH;
            if (bottom > 0) {
                document.documentElement.style.setProperty('--mobile-nav-top', Math.round(bottom) + 'px');
            }
        }
    }

    window.addEventListener('resize', updateMobileNavTop);
    window.addEventListener('orientationchange', updateMobileNavTop);
    document.addEventListener('DOMContentLoaded', updateMobileNavTop);
    setTimeout(updateMobileNavTop, 100);
    setTimeout(updateMobileNavTop, 500);

    if (typeof jQuery !== 'undefined') {
        jQuery(document).on('show.bs.modal shown.bs.modal', '#inbox-right', function() {
            updateMobileNavTop();
        });
    }
})();
</script>
