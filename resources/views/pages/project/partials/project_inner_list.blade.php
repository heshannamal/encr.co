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

    .section-drag-handle {
        cursor: move;
        color: #6c757d;
        margin-right: 8px;
        font-size: 16px;
    }

    .section-drag-handle:hover {
        color: #E8E8E8;
    }

   .section-drag-handle,
    .drag-handle {
        color: #F1F1F1 !important;
        font-size: 16px;
        margin-right: 8px;
        cursor: grab;

        opacity: 1 !important;
        visibility: visible !important;

        transition: color 0.2s ease;
    }

    tr.project-inner-section:hover .section-drag-handle,
    tr.project-inner-task:hover .drag-handle {
        color: #202020 !important;
    }



    /* hide by default */
.toggle-arrow button.btn.btn-primary.arrow {
    width: 26px;
    height: 26px;
    padding: 0;
    border-radius: 6px;
    border: none !important;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    background-color: #F8F8F8 !important;
    transition: all 0.2s ease;
}

/* Default icon */
.toggle-arrow button.btn.btn-primary.arrow i {
    font-size: 16px;
    color: #F1F1F1;
    transition: color 0.2s ease;
}

/* Hover row */
.schedule-row:hover .toggle-arrow button.btn.btn-primary.arrow,
tr:hover .toggle-arrow button.btn.btn-primary.arrow {
    background-color: #DEDEDE !important;
}

/* Hover row icon */
.schedule-row:hover .toggle-arrow button.btn.btn-primary.arrow i,
tr:hover .toggle-arrow button.btn.btn-primary.arrow i {
    color: #202020;
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
    /* margin-left: 8px; */
    flex-shrink: 0;
    /* padding: 4px 8px; */
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 12px;
    font-weight: 600;
}

/* .priority-indicator:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
} */

.priority-dot {
    width: 14px;
    height: 14px;
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
}

.priority-indicator.high {
    color: #e65100;
}

.priority-indicator.high .priority-dot {
    background-color: #e65100;
}

.priority-indicator.medium {
    color: #f57f17;
}

.priority-indicator.medium .priority-dot {
    background-color: #f57f17;
}

.priority-indicator.low {
    color: #2e7d32;
}

.priority-indicator.low .priority-dot {
    background-color: #2e7d32;
}

.select2-container {
    width: 8rem !important;
}

.btn-primary {
    box-shadow: none !important;
}

@media (max-width: 767.98px) {

    /* Force every section card to stand alone — no visual merging with 
       whatever is above/below it (including the header card) */
    .table-responsive {
        margin-top: 12px !important;
    }

    /* NEW TASK / SUB-TASK INPUT ROWS (mobile) Standalone cards, don't disturb siblings */
    .project-inner-table tr#new_discussion_input,
    .project-inner-table tr#new_sub_discussion_input {
        display: block !important;
        box-sizing: border-box !important;
        background: #ffffff !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
    }

    .project-inner-table tr#new_discussion_input > td,
    .project-inner-table tr#new_sub_discussion_input > td {
        display: block !important;
        width: 100% !important;
        border: none !important;
        padding: 0 !important;
        background: transparent !important;
    }

    /* New Task input card */
    .project-inner-table tr#new_discussion_input {
        border: 1px solid #e8eaed !important;
        border-radius: 12px !important;
        padding: 10px !important;
        margin: 8px 0 !important;
    }

    /* New Sub Task input card — indented like a sub-task */
    .project-inner-table tr#new_sub_discussion_input {
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        padding: 10px !important;
        margin: 8px 0 8px 20px !important;
        width: calc(100% - 20px) !important;
    }

    .project-inner-table tr#new_discussion_input input#discussion_name,
    .project-inner-table tr#new_sub_discussion_input input#sub_discussion_name {
        width: 100% !important;
        padding: 9px 12px !important;
        font-size: 14px !important;
        border-radius: 8px !important;
        border: 1px solid #e5e7eb !important;
        box-sizing: border-box !important;
        background-color: #fff !important;
        margin-left: 0 !important;
        outline: none !important;
    }

    .project-inner-table tr#new_sub_discussion_input > td:first-child {
        margin-left: -3.5rem !important;
        width: calc(100% + 3.5rem) !important;
    }
    
    .project-inner-table tr.parent-row {
        margin-bottom: 20px !important;
        border-radius: 14px !important;
        border-bottom-left-radius: 14px !important;
        border-bottom-right-radius: 14px !important;
        border: 1px solid #e8eaed !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06) !important;
    }

    /* Cancel the "merge with expanded content" override */
    .project-inner-table tr.parent-row:has(+ tr[class*="parent-section-"]) {
        margin-bottom: 20px !important;
        border-bottom-left-radius: 14px !important;
        border-bottom-right-radius: 14px !important;
        border-bottom-color: #e8eaed !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06) !important;
    }

    /* Expanded section becomes its own separate card too, not attached to the header */
    .project-inner-table tr[class*="parent-section-"]:not(.parent-row) {
        border-left: 1px solid #e0e0e0 !important;
        border-radius: 14px !important;
        margin: -4px 0 12px 0 !important;
        padding: 6px 8px 6px 6px !important;
    }

    .project-inner-table tr[class*="parent-section-"]:not(.parent-row):has(+ tr.parent-row),
    .project-inner-table tr[class*="parent-section-"]:not(.parent-row):last-child {
        margin-bottom: 12px !important;
    }

    /* ── Wrapper & table skeleton ── */
    .table-responsive {
        border: none !important;
        overflow-x: hidden !important;
        padding: 0 !important;
    }

    .project-inner-table {
        display: block !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        width: 100% !important;
    }

    .project-inner-table thead {
        display: none !important;
    }

    .project-inner-table tbody {
        display: block !important;
        border: none !important;
        width: 100% !important;
    }

    .project-inner-table tr {
        box-sizing: border-box !important;
        width: 100% !important;
    }

    .project-inner-table tr td {
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    /* Hide desktop connector lines */
    .discussion-level::before,
    .discussion-level::after,
    .subdiscussion-level::before,
    .subdiscussion-level::after {
        display: none !important;
    }

    .discussion-level,
    .subdiscussion-level {
        padding-left: 20px !important;
    }

    .section-level {
        padding-left: 0 !important;
    }

    /* Hide share + hidden assignee selects on mobile */
    /* .project-inner-table td:has(.share-project),
    .project-inner-table .discussion-assignee-name,
    .project-inner-table .sub-discussion-assignee-name {
        display: none !important;
    } */

    /* Drag handles – always visible */
    .drag-handle,
    .section-drag-handle {
        display: inline-flex !important;
        align-items: center !important;
        color: #747373 !important;
        font-size: 16px !important;
        margin-right: 4px !important;
        flex-shrink: 0 !important;
        cursor: grab !important;
    }

    /* Expand/collapse chevron */
    .toggle-arrow button.btn.btn-primary.arrow {
        width: 22px !important;
        height: 22px !important;
        min-width: 22px !important;
        padding: 0 !important;
        border: none !important;
        border-radius: 4px !important;
        background-color: transparent !important;
        box-shadow: none !important;
    }

    .toggle-arrow button.btn.btn-primary.arrow i {
        font-size: 16px !important;
        color: #666 !important;
    }

    /* Circle checkbox */
    .circle_checkbox {
        width: 18px !important;
        height: 18px !important;
        min-width: 18px !important;
        margin: 0 6px 0 0 !important;
        flex-shrink: 0 !important;
    }

    /* Trash icon */
    .trash_btn {
        color: #ef5350 !important;
        font-size: 14px !important;
    }

    /* ══════════════════════════════════════
       SECTION CARD (collapsed / header)
       ══════════════════════════════════════ */
    .project-inner-table tr.parent-row {
        position: relative !important;
        display: grid !important;
        grid-template-columns: 1fr auto auto !important;
        grid-template-rows: auto auto !important;
        gap: 8px 6px !important;
        align-items: start !important;
        background: #ffffff !important;
        border: 1px solid #e8eaed !important;
        border-radius: 14px !important;
        padding: 14px 10px 12px 4px !important;
        margin-bottom: 10px !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06) !important;
    }

    /* Section expanded – connect to nested area */
    .project-inner-table tr.parent-row:has(+ tr[class*="parent-section-"]) {
        margin-bottom: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        border-bottom-color: transparent !important;
        box-shadow: none !important;
    }

    .project-inner-table tr.parent-row > td:first-child {
        grid-column: 1 !important;
        grid-row: 1 / 3 !important;
        display: block !important;
        min-width: 0 !important;
        padding-left: 0 !important;
        margin-left: 0 !important;
    }

    .project-inner-table tr.parent-row > td:nth-child(2) {
        position: absolute !important;
        top: 14px !important;
        right: 14px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
        z-index: 5 !important;
    }

    .project-inner-table tr.parent-row > td:has(.share-project) {
        grid-column: 3 !important;
        grid-row: 2 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        align-self: center !important;
        margin-right: 68px !important;
    }

    .project-inner-table tr.parent-row > td:has(.delete-section-discussion) {
        grid-column: 3 !important;
        grid-row: 2 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        align-self: center !important;
        margin-right: 28px !important;
    }

    .project-inner-table tr.parent-row .share-project,
    .project-inner-table tr.parent-row .delete-section-discussion {
        padding: 0 2px !important;
    }

    .project-inner-table tr.parent-row .hierarchy-item,
    .project-inner-table tr.parent-row .section-level {
        position: static !important;
        display: grid !important;
        grid-template-columns: auto auto auto 1fr !important;
        grid-template-rows: auto auto !important;
        gap: 10px 6px !important;
        align-items: center !important;
        width: 100% !important;
        padding-left: 0 !important;
        margin-left: 0 !important;
    }

    .project-inner-table tr.parent-row .toggle-arrow {
        position: absolute !important;
        right: 8px !important;
        bottom: 17px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 10 !important;
    }

    .project-inner-table tr.parent-row .section-drag-handle {
        grid-column: 1 !important;
        grid-row: 1 / span 2 !important;
        align-self: center !important;
        justify-self: start !important;
        margin-left: 0 !important;
        margin-right: 2px !important;
    }

    .project-inner-table tr.parent-row .input-wrapper {
        grid-column: 2 / -1 !important;
        grid-row: 1 !important;
        min-width: 0 !important;
        margin-left: 0 !important;
    }

    .project-inner-table tr.parent-row .section-name {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #1a1a1a !important;
        background: transparent !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        width: 100% !important;
        border: none !important;
        padding: 0 !important;
    }

    /* Section meta row: comments, tasks, stage pill */
    .project-inner-table tr.parent-row .comment-div {
        grid-column: 2 !important;
        grid-row: 2 !important;
        margin-left: 0 !important;
    }

    .project-inner-table tr.parent-row .discussion-div {
        grid-column: 3 !important;
        grid-row: 2 !important;
        margin-left: 0 !important;
    }

    .project-inner-table tr.parent-row .section-stage-status {
        grid-column: 4 !important;
        grid-row: 2 !important;
        justify-self: start !important;
        margin: 0 !important;
        width: auto !important;
    }

    /* Section avatar stack */
    .project-inner-table .section-avatar-group {
        display: flex !important;
        align-items: center !important;
        flex-direction: row !important;
    }

    .project-inner-table .section-avatar {
        width: 26px !important;
        height: 26px !important;
        margin-left: -7px !important;
        margin-right: 0 !important;
        border: 2px solid #fff !important;
        border-radius: 50% !important;
        box-shadow: 0 0 0 1px #ccc !important;
    }

    .project-inner-table .section-avatar:first-child {
        margin-left: 0 !important;
    }

    /* Stage / Discussion pill */
    .project-inner-table tr select.modern-stage-select,
    .project-inner-table tr.parent-row .section-stage-status {
        appearance: none !important;
        -webkit-appearance: none !important;
        background-color: #e3f2fd !important;
        color: #1565c0 !important;
        border: 1px solid #bbdefb !important;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2210%22%20height%3D%2210%22%20fill%3D%22%231565c0%22%20viewBox%3D%220%200%2016%2016%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M1.646%204.646a.5.5%200%200%201%20.708%200L8%2010.293l5.646-5.647a.5.5%200%200%201%20.708.708l-6%206a.5.5%200%200%201-.708%200l-6-6a.5.5%200%200%201%200-.708z%22%2F%3E%3C%2Fsvg%3E') !important;
        background-repeat: no-repeat !important;
        background-position: right 8px center !important;
        background-size: 9px !important;
        padding: 4px 22px 4px 10px !important;
        border-radius: 20px !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        box-shadow: none !important;
        height: auto !important;
    }

    /* ══════════════════════════════════════
       EXPANDED SECTION – nested gray area
       ══════════════════════════════════════ */
    .project-inner-table tr[class*="parent-section-"]:not(.parent-row) {
        display: block !important;
        /* background: #f0f1f3 !important; */
        /* border-left: 4px solid #2d2d2d !important; */
        border-left: 0 solid #e0e0e0 !important;
        border-right: 0 solid #e0e0e0 !important;
        /* border-right: 1px solid #e0e0e0 !important; */
        border-top: none !important;
        border-bottom: none !important;
        border-radius: 0 !important;
        margin: 0 !important;
        margin-left: 10px !important;
        padding: 6px 8px 6px 6px !important;
        box-shadow: none !important;
    }

    .table-responsive {
        margin-top: 12px !important;
        background-color: #ffffff !important;
        border-radius: 14px !important;
    }

    .project-inner-table tbody {
        display: block !important;
        border: none !important;
        width: 100% !important;
        background-color: #ffffff !important;
    }

    /* Close expanded section container at bottom */
    .project-inner-table tr[class*="parent-section-"]:not(.parent-row):has(+ tr.parent-row),
    .project-inner-table tr[class*="parent-section-"]:not(.parent-row):last-child {
        border-bottom: 1px solid #e0e0e0 !important;
        border-bottom-left-radius: 14px !important;
        border-bottom-right-radius: 14px !important;
        margin-bottom: 20px !important;
        margin-left: 0 !important;
        padding-bottom: 10px !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05) !important;
    }

    /* ══════════════════════════════════════
       TASK ROW (inside expanded section)
       ══════════════════════════════════════ */
    .project-inner-table tr.parent-discussion-row {
        position: relative !important;
        display: block !important;
        background: #ffffff !important;
        border: 1px solid #e8eaed !important;
        border-radius: 12px !important;
        padding: 10px 10px 34px 4px !important;
        margin: 8px 0 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
    }

    .project-inner-table tr.parent-discussion-row[class*="parent-section-"]:not(.parent-row) {
        border-top: 2px solid #dcdcdc !important;
        border-bottom: 1px solid #dcdcdc !important;
    }

    .project-inner-table tr.parent-discussion-row > td:first-child {
        display: block !important;
        width: 100% !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    .project-inner-table tr.parent-discussion-row .hierarchy-item {
        display: flex !important;
        align-items: center !important;
        gap: 4px !important;
        width: calc(100% - 130px) !important;
        position: static !important;
    }

    .project-inner-table tr.parent-discussion-row .drag-handle {
        position: absolute !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        left: 4px !important;
        margin-right: 0 !important;
    }

    .project-inner-table tr.parent-discussion-row .discussion-name {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #1a1a1a !important;
        background: transparent !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        width: 100% !important;
        border: none !important;
        padding: 0 !important;
    }

    .project-inner-table tr.parent-discussion-row .toggle-arrow {
        position: absolute !important;
        bottom: 6px !important;
        right: 8px !important;
        top: auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        z-index: 10 !important;
    }

    .project-inner-table tr.parent-discussion-row .comment-div {
        position: absolute !important;
        top: 12px !important;
        right: 120px !important;
        display: inline-flex !important;
        align-items: center !important;
    }

    .project-inner-table tr.parent-discussion-row .discussion-div {
        position: absolute !important;
        top: 12px !important;
        right: 88px !important;
        display: inline-flex !important;
        align-items: center !important;
    }

    .project-inner-table tr.parent-discussion-row > td:has(.share-project) {
        position: absolute !important;
        top: 6px !important;
        right: 52px !important;
        display: flex !important;
        align-items: center !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    .project-inner-table tr.parent-discussion-row > td:has(.delete-discussion) {
        position: absolute !important;
        top: 6px !important;
        right: 30px !important;
        display: flex !important;
        align-items: center !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    /* Task meta row: priority, date, assignee */
    .project-inner-table tr.parent-discussion-row .priority-indicator {
        position: absolute !important;
        bottom: 10px !important;
        left: 28px !important;
        display: inline-flex !important;
        align-items: center !important;
    }

    .project-inner-table tr.parent-discussion-row .priority-dot {
        width: 10px !important;
        height: 10px !important;
    }

    .project-inner-table tr.parent-discussion-row > td:has(.discussion-due-date) {
        position: absolute !important;
        bottom: 8px !important;
        left: 50px !important;
        display: flex !important;
        align-items: center !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    .project-inner-table tr.parent-discussion-row > td:has(.task-assignees) {
        grid-column: 5 / -1 !important;
        grid-row: 2 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
    }

    /* ══════════════════════════════════════
       SUB-TASK CARD (white nested card)
       ══════════════════════════════════════ */
    .project-inner-table tr.sub-discussion-row,
    .project-inner-table tr.sub-discussion-row[class*="parent-section-"]:not(.parent-row) {
        position: relative !important;
        display: block !important;
        background: #ffffff !important;
        /* border: 1px solid #e5e7eb !important; */
        border-top: 1px solid #e5e7eb !important;
        /* border-bottom: 1px solid #e5e7eb !important; */
        /* border-left: 1px solid #e5e7eb !important; */
        /* border-radius: 12px !important; */
        padding: 10px 10px 34px 4px !important;
        /* margin: 6px 0 6px 8px !important; */
        margin-left: 20px !important;
        margin-right: 0 !important;
        width: auto !important;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05) !important;
        box-sizing: border-box !important;
    }

    .project-inner-table tr.sub-discussion-row > td:first-child {
        display: block !important;
        width: 100% !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    .project-inner-table tr.sub-discussion-row .hierarchy-item {
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        width: calc(100% - 130px) !important;
        position: static !important;
    }

    .project-inner-table tr.sub-discussion-row .drag-handle {
        position: absolute !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        left: 4px !important;
        margin-right: 0 !important;
    }

    .project-inner-table tr.sub-discussion-row .input-wrapper {
        position: relative !important;
        flex: 1 !important;
        min-width: 0 !important;
        display: flex !important;
        align-items: center !important;
    }

    .project-inner-table tr.sub-discussion-row .circle_checkbox {
        /* styled normally */
    }

    .project-inner-table tr.sub-discussion-row .sub-discussion-name {
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #1a1a1a !important;
        background: transparent !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        width: 100% !important;
        border: none !important;
        padding: 0 !important;
    }

    .project-inner-table tr.sub-discussion-row .input-overlay {
        position: absolute !important;
        inset: 0 !important;
        cursor: text !important;
        background: transparent !important;
    }

    .project-inner-table tr.sub-discussion-row > td:has(.share-project) {
        position: absolute !important;
        top: 6px !important;
        right: 34px !important;
        display: flex !important;
        align-items: center !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    .project-inner-table tr.sub-discussion-row > td:has(.delete-sub-discussion) {
        position: absolute !important;
        top: 6px !important;
        right: 10px !important;
        display: flex !important;
        align-items: center !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    .project-inner-table tr.sub-discussion-row .priority-indicator {
        position: absolute !important;
        bottom: 10px !important;
        left: 28px !important;
        display: inline-flex !important;
        align-items: center !important;
    }

    .project-inner-table tr.sub-discussion-row .priority-dot {
        width: 10px !important;
        height: 10px !important;
    }

    .project-inner-table tr.sub-discussion-row > td:has(.sub-discussion-due-date) {
        position: absolute !important;
        bottom: 8px !important;
        left: 50px !important;
        display: flex !important;
        align-items: center !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    .project-inner-table tr.sub-discussion-row > td:has(.sub-task-assignees) {
        position: absolute !important;
        bottom: 8px !important;
        right: 12px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
    }

    /* ── Comment / task count icons ── */
    .comment-div,
    .discussion-div {
        display: inline-flex !important;
        align-items: center !important;
        gap: 3px !important;
        margin-left: 0 !important;
    }

    span.comment-number,
    span.comment-number-section,
    span.discussion-number,
    span.discussion-number-section {
        font-size: 11px !important;
        color: #888 !important;
        margin: 0 2px 0 0 !important;
    }

    i.fa-regular.fa-comment-dots,
    i.fa-solid.fa-list-check {
        font-size: 12px !important;
        color: #aaa !important;
    }

    /* ── Assignee & date meta ── */
    .project-inner-table tr .task-assignees:not(.d-none),
    .project-inner-table tr .sub-task-assignees:not(.d-none) {
        display: flex !important;
        align-items: center !important;
        font-size: 12px !important;
        color: #6b7280 !important;
        white-space: nowrap !important;
    }

    .project-inner-table tr .task-assignees .project-inner-avatar,
    .project-inner-table tr .sub-task-assignees .project-inner-avatar {
        display: none !important;
    }

    .project-inner-table tr .task-assignees span.text-gray,
    .project-inner-table tr .sub-task-assignees span.text-gray {
        display: inline !important;
        padding-left: 0 !important;
        font-size: 12px !important;
        color: #6b7280 !important;
        font-style: normal !important;
        padding-right: 20px !important;
    }

    .project-inner-table tr input[type="date"] {
        font-size: 12px !important;
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        width: auto !important;
        max-width: 110px !important;
        color: #6b7280 !important;
        box-shadow: none !important;
    }

    /* ── Add Task / Add Sub Task – proper outlined buttons ── */
    .project-inner-table tr[id^="add_section_discussion_"],
    .project-inner-table tr[id^="add_section_sub_discussion_"] {
        display: block !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 4px 0 !important;
        margin: 4px 0 !important;
        text-align: left !important;
    }

    .project-inner-table tr[id^="add_section_sub_discussion_"] {
        margin-left: 8px !important;
        margin-right: 0 !important;
        width: auto !important;
    }

    .project-inner-table tr[id^="add_section_discussion_"] td,
    .project-inner-table tr[id^="add_section_sub_discussion_"] td {
        display: block !important;
        width: 100% !important;
        border: none !important;
        padding: 0 !important;
    }

    .project-inner-table tr[id^="add_section_discussion_"] button,
    .project-inner-table tr[id^="add_section_sub_discussion_"] button {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: auto !important;
        background: transparent !important;
        border: 1.5px solid #9ca3af !important;
        border-radius: 8px !important;
        padding: 6px 16px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #374151 !important;
        cursor: pointer !important;
        transition: background 0.15s ease !important;
    }

    .project-inner-table tr[id^="add_section_discussion_"] button:hover,
    .project-inner-table tr[id^="add_section_sub_discussion_"] button:hover {
        background: #f3f4f6 !important;
        color: #111827 !important;
    }

    /* ── Add Section (black dashed button) ── */
    #add_section_row tr {
        display: block !important;
        background: #111111 !important;
        border: 2px dashed rgba(255, 255, 255, 0.55) !important;
        border-radius: 14px !important;
        padding: 0 !important;
        margin: 14px 0 20px !important;
        box-shadow: none !important;
    }

    #add_section_row tr td {
        display: block !important;
        width: 100% !important;
        border: none !important;
        padding: 14px !important;
        background: transparent !important;
        text-align: center !important;
    }

    #add_section_row .add-section-btn {
        width: 100% !important;
        background: transparent !important;
        border: none !important;
        color: #ffffff !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        padding: 0 !important;
    }

    /* ── Load more row ── */
    #load_more_sections_row tr {
        display: block !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 8px 0 !important;
        margin-bottom: 8px !important;
    }

    #load_more_sections_row td {
        display: block !important;
        border: none !important;
        padding: 0 !important;
        text-align: center !important;
    }

    /* Styles for new section name input card on mobile */
    #new_section_row {
        display: block !important;
        background: #ffffff !important;
        border: 1px solid #e8eaed !important;
        border-radius: 12px !important;
        padding: 10px 12px !important;
        margin: 10px 0 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
    }

    #new_section_row td {
        display: block !important;
        width: 100% !important;
        padding: 0 !important;
    }

    #new_section_row #section_name {
        width: 100% !important;
        padding: 8px 12px !important;
        font-size: 14px !important;
        border-radius: 8px !important;
        border: 1px solid #e5e7eb !important;
        box-sizing: border-box !important;
        background-color: #ffffff !important;
    }

    /* ── Task / Sub-Task name input rows on mobile ── */
    .project-inner-table tr[id^="new_discussion_"],
    .project-inner-table tr[id^="new_sub_discussion_"] {
        display: block !important;
        /* background: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        padding: 8px 10px !important;
        margin: 6px 0 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important; */
    }

    .project-inner-table tr[id^="new_sub_discussion_"] {
        margin-left: 8px !important;
    }

    .project-inner-table tr[id^="new_discussion_"] td,
    .project-inner-table tr[id^="new_sub_discussion_"] td {
        display: block !important;
        width: 100% !important;
        border: none !important;
        padding: 0 !important;
    }

    .project-inner-table tr[id^="new_discussion_"] input[type="text"],
    .project-inner-table tr[id^="new_sub_discussion_"] input[type="text"] {
        width: 100% !important;
        padding: 9px 12px !important;
        font-size: 14px !important;
        border-radius: 8px !important;
        /* border: 1px solid #e5e7eb !important; */
        box-sizing: border-box !important;
        background-color: #ffffff !important;
        color: #374151 !important;
        outline: none !important;
    }
}
</style>


<div class="table-responsive">
    <table class="table table-bordered align-middle project-inner-table">
        <thead class="table-custom-dark">
            <tr>
                <th class="w-75">Name</th>
                <th>Assignee</th>
                <th>Due Date</th>
                @can('share project')
                    <th></th>
                @endcan
                @canany(['delete section', 'delete discussion'])
                    <th></th>
                @endcanany
            </tr>
        </thead>
        <tbody id="discussion_tbody">


        </tbody>
        <tbody id="load_more_sections_row" style="display:none;">
            <tr>
                <td colspan="5" class="text-center py-2">
                    <button type="button" id="load_more_sections_btn"
                        class="btn btn-outline-secondary btn-sm"
                        style="min-width:160px;">
                        <i class="fa-solid fa-chevron-down me-1"></i> Load More Sections
                    </button>
                </td>
            </tr>
        </tbody>
        <tbody id="add_section_row">
            <!-- Section: Add new Section -->
            <tr class="project-inner-section border_left_unset cursor_pointer">
                <td class="border_left_unset border_right_unset font_15px" colspan="3">
                    <button type="button" class="btn btn-outline-secondary board-add-task add-section-btn"
                        id="add_section_btn"><i class="fa-solid fa-plus"></i> Add Section</button>
                    <input type="hidden" id="discussion_project_id" value="{{ $project->id }}" />
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>

    var userInfo = @json($userInfo);
    var stageStatusOptions = @json($project->stage_status_options);

    $('.datepicker').datepicker({
        minDate: 0
    });

    $(document).ready(function() {
        displayAllSections();

        $('#add_section_btn').click(function(e) {
            e.stopPropagation();
            if ($('#new_section_row').length > 0) {
                $('#new_section_row').remove();
                $('#add_section_row').show(200);
            } else {
                $('#add_section_row').hide(200);
                var sectionTextRow =
                    '<tr class="project-inner-section border_left_unset" id="new_section_row">' +
                    '<td class="border_left_unset border_right_unset font_15px" colspan="3">' +
                    '<input type="text" id="section_name" placeholder="New Section" style="width: 40%; border-radius: 4px; border: 1px solid #a8a8a8;">' +
                    '</td>' +
                    '</tr>';
                $('#discussion_tbody').append(sectionTextRow);
                $('#section_name').focus();
            }
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
                    console.log(data);
                    if($('#hide_completed_tasks').is(':checked')) {
                        data.discussions = data.discussions.filter(function(discussion) {
                            return discussion.is_completed == 0;
                        });
                    }
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
                    if($('#hide_completed_tasks').is(':checked')) {
                        data.sub_discussions = data.sub_discussions.filter(function(sub_discussion) {
                            return sub_discussion.is_completed == 0;
                        });
                    }
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
    $('body').on('click', '.add-section-discussion', function(e) {
        e.stopPropagation();
        var sectionId = $(this).data('id');
        var orderId = $(this).data('order');

        var $existingInput = $('.project-inner-task#add_section_discussion_' + sectionId).prev('#new_discussion_input');
        if ($existingInput.length > 0) {
            $existingInput.remove();
        } else {
            $('#new_discussion_input').remove(); // remove any other open task input
            var row = '<tr id="new_discussion_input">' +
                '<td class="align-content-center border_left_unset">' +
                '<input type="text" class="margin_left_15px" id="discussion_name" placeholder="Write a task name" data-section-id="' +
                sectionId + '" data-order-id="' + orderId +
                '" style="width: auto; border-radius: 4px; border: 1px solid #a8a8a8;" />' +
                '</td><td></td><td></td></tr>';
            $('.project-inner-task#add_section_discussion_' + sectionId).before(row);
            $('#discussion_name').focus();
        }
    });

    // Add a new sub discussion
    $('body').on('click', '.add-section-sub-discussion', function(e) {
        e.stopPropagation();
        var discussionId = $(this).data('discussion-id');
        var sectionId = $(this).data('section-id');
        var orderId = $(this).data('order');

        var $existingSubInput = $('.project-inner-task#add_section_sub_discussion_' + discussionId).prev('#new_sub_discussion_input');
        if ($existingSubInput.length > 0) {
            $existingSubInput.remove();
        } else {
            $('#new_sub_discussion_input').remove(); // remove any other open sub task input
            var row = '<tr id="new_sub_discussion_input">' +
                '<td class="align-content-center border_left_unset" style="padding-left: 3.5rem !important;">' +
                '<input type="text" class="margin_left_15px" id="sub_discussion_name" placeholder="Write a sub task name" data-discussion-id="' +
                discussionId + '" data-section-id="' + sectionId + '" data-order-id="' + orderId +
                '" style="width: auto; border-radius: 4px; border: 1px solid #a8a8a8;" />' +
                '</td><td></td><td></td></tr>';
            $('.project-inner-task#add_section_sub_discussion_' + discussionId).before(row);
            $('#sub_discussion_name').focus();
        }
    });

    // Stop propagation on clicking inside the new input fields so outside-click handler doesn't trigger
    $(document).on('click', '#section_name, #discussion_name, #sub_discussion_name', function(e) {
        e.stopPropagation();
    });

    // Hide inputs when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#new_section_row, #add_section_btn').length) {
            if ($('#new_section_row').length > 0) {
                if ($('#section_name').val() === '') {
                    $('#new_section_row').remove();
                    $('#add_section_row').show(200);
                }
            }
        }
        if (!$(e.target).closest('#new_discussion_input, .add-section-discussion').length) {
            if ($('#new_discussion_input').length > 0) {
                if ($('#discussion_name').val() === '') {
                    $('#new_discussion_input').remove();
                }
            }
        }
        if (!$(e.target).closest('#new_sub_discussion_input, .add-section-sub-discussion').length) {
            if ($('#new_sub_discussion_input').length > 0) {
                if ($('#sub_discussion_name').val() === '') {
                    $('#new_sub_discussion_input').remove();
                }
            }
        }
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
                var sectionId = $(this).data('id');
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
                        displaySectionAssignees(sectionId);

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
                var sectionId = $(this).data('id');
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
                        displaySectionAssignees(sectionId);
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

    // function displayAllSections() {
    // --- Section pagination state ---
    var _sectionCurrentPage = 0;
    var _sectionLastPage    = 1;
    var _sectionLoading     = false;

    function displayAllSections(page) {
        if (_sectionLoading) return;
        _sectionLoading = true;

        page = page || 1;
        var project_id = $('#discussion_project_id').val();

        // Show spinner text on the button while loading
        $('#load_more_sections_btn').html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Loading…').prop('disabled', true);

        $.ajax({
            // url: '{{ url('get_project_management') }}/' + project_id,
            url: '{{ url('get_project_management') }}/' + project_id + '?page=' + page,
            method: 'GET',
            dataType: 'json',
            // success: function(data) {
            //     var section_data = data;
            //     // $('#discussion_tbody').html('');
            //     var sectionNames = [];
            success: function(response) {
                // Laravel paginate() returns { data: [...], current_page, last_page, ... }
                var section_data    = response.data;
                _sectionCurrentPage = response.current_page;
                _sectionLastPage    = response.last_page;

                for (var i = 0; i < section_data.length; i++) {
                    displaySingleSection(section_data[i]);
                }

                // Show / hide the Load More button
                if (_sectionCurrentPage < _sectionLastPage) {
                    $('#load_more_sections_row').show();
                    $('#load_more_sections_btn')
                        .html('<i class="fa-solid fa-chevron-down me-1"></i> Load More Sections')
                        .prop('disabled', false);
                } else {
                    $('#load_more_sections_row').hide();
                }
            },
            error: function(xhr, status, error) {
                $('#load_more_sections_btn')
                    .html('<i class="fa-solid fa-chevron-down me-1"></i> Load More Sections')
                    .prop('disabled', false);
                swal({
                    title: "Error!",
                    text: error,
                    type: "warning",
                    buttons: true,
                    dangerMode: true,
                    confirmButtonColor: '#5fb644',
                });
            },
            complete: function() {
                _sectionLoading = false;
            }
        });
    }

    // Load next page when the button is clicked
    $(document).on('click', '#load_more_sections_btn', function() {
        displayAllSections(_sectionCurrentPage + 1);
    });

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

        var deleteButton = '';      

        if (section_data.can_delete_section) {

            deleteButton =
                '<td class="align-content-center">' +
                '<button type="button" class="btn btn-sm delete-section-discussion" style="background: none;" ' +
                'data-id="' + section_data.id + '" ' +
                'data-order="' + section_data.project_id + '" ' +
                'data-toggle="tooltip" data-placement="bottom" title="Delete this section">' +
                '<i class="fa fas fa-trash trash_btn"></i>' +
                '</button>' +
                '</td>';
        }
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

            '<span class="input-wrapper" style="position:relative; display:inline-block; margin-left: 10px;">' +
            '<input type="text" class="border-0 section-name section-name-id-' + section_data.id + '" ' +
            'style="width:auto%; box-sizing:border-box;" ' +
            'data-id="' + section_data.id + '" ' +
            'value="' + section_data.section_name  + '" ' +
            'data-order="' + section_data.project_id + '" disabled>' +


            '<div class="input-overlay" data-id="' + section_data.id + '" ' +
            'style="position:absolute; inset:0; cursor:pointer; background:transparent;"></div>' +
            '</span>' +

            '<select class="section-stage-status modern-stage-select" data-id="' + section_data.id + '" style="margin-left:10px;">' +
            '<option value="" ' + (!section_data.stage_status ? 'selected' : '') + '>-</option>' +
            stageStatusOptions.map(function(stage) {
                return '<option value="' + stage + '" ' + (section_data.stage_status == stage ? 'selected' : '') + '>' + stage + '</option>';
            }).join('') +
            '</select>' +

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

            '@can('share project')' +
            '<td class="align-content-center">' +
            '<button type="button" class="btn btn-sm share-project" style="background: none;" ' +
            'data-id="{{ $project->id }}" data-assignees="{{ $project->project_assignee }}" ' +
            'data-target-type="section" data-target-id="' + section_data.id + '" ' +
            'data-toggle="tooltip" data-placement="bottom" title="Share this project">' +
            '<i class="fa fa-share-alt share_btn"></i>' +
            '</button>' +
            '</td>' +
            '@endcan' +

            deleteButton +

            '</tr>';

        $('#discussion_tbody').append(parentRow);

        // Apply stage color to the newly added section select
        $('#parent_section_' + section_data.id + ' .modern-stage-select').each(function() {
            updateStageSelectColor(this);
        });

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
                // Filter out completed tasks if hide is checked
                if($('#hide_completed_tasks').is(':checked')) {
                    data.discussions = data.discussions.filter(function(discussion) {
                        return discussion.is_completed == 0;
                    });
                }

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
                // Filter out completed sub-tasks if hide is checked
                if($('#hide_completed_tasks').is(':checked')) {
                    data.sub_discussions = data.sub_discussions.filter(function(sub_discussion) {
                        return sub_discussion.is_completed == 0;
                    });
                }

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

        var childRow = '';
        for (var j = 0; j < discussion_data.length; j++) {
            var userOptions = [];

            var deleteDiscussionButton = '';

            if (discussion_data[j].can_delete_discussion) {

                deleteDiscussionButton =
                    '<td class="align-content-center">' +
                    '<button type="button" class="btn btn-sm delete-discussion" style="background: none;" ' +
                    'data-id="' + sectionData.id + '" ' +
                    'data-order="' + sectionData.project_id + '" ' +
                    'data-discussion="' + discussion_data[j].id + '" ' +
                    'data-sectionName="' + sectionData.section_name + '" ' +
                    'data-discussionName="' + discussion_data[j].discussion_name + '" ' +
                    'data-toggle="tooltip" data-placement="bottom" title="Delete this discussion">' +
                    '<i class="fa fas fa-trash trash_btn"></i>' +
                    '</button>' +
                    '</td>';
            }


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
                                '<span class="priority-indicator ' + priority.toLowerCase() + ' discussion-priority-id-' + discussion_data[j].id + '" title="' + priority + '">' +
                '<span class="priority-dot"></span>' +
                '</span>' +

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

                '@can('share project')' +
                '<td class="align-content-center">' +
                '<button type="button" class="btn btn-sm share-project" style="background: none;" ' +
                'data-id="{{ $project->id }}" data-assignees="{{ $project->project_assignee }}" ' +
                'data-target-type="discussion" data-target-id="' + discussion_data[j].id + '" ' +
                'data-toggle="tooltip" data-placement="bottom" title="Share this project">' +
                '<i class="fa fa-share-alt share_btn"></i>' +
                '</button>' +
                '</td>' +
                '@endcan' +

                deleteDiscussionButton +

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

        var childRow = '';
        for (var j = 0; j < discussion_data.length; j++) {

            var userOptions = [];
            var deleteSubDiscussionButton = '';

            var deleteSubDiscussionButton = '';

            if (discussion_data[j].can_delete_sub_discussion === true) {

                deleteSubDiscussionButton =
                    '<td class="align-content-center">' +
                    '<button type="button" class="btn btn-sm delete-sub-discussion" style="background: none;" ' +
                    'data-id="' + discussion_data[j].section_id + '" ' +
                    'data-order="' + discussion_data[j].project_id + '" ' +
                    'data-discussion="' + discussion_data[j].id + '" ' +
                    'data-sectionName="' + (discussion_data[j].section ? discussion_data[j].section.section_name : '') + '" ' +
                    'data-discussionName="' + discussion_data[j].discussion_name + '" ' +
                    'data-toggle="tooltip" data-placement="bottom" title="Delete this discussion">' +
                    '<i class="fa fas fa-trash trash_btn"></i>' +
                    '</button>' +
                    '</td>';
            }
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
                '<div class="input-overlay" data-type="subdiscussion" data-id="' + discussion_data[j].id + '" ' +
                'style="position:absolute; inset:0; cursor:text; background:transparent;"></div>' +
                '</span>' +
                '</div>' +
                '<span class="priority-indicator ' + priority.toLowerCase() + ' sub-discussion-priority-id-' + discussion_data[j].id + '" title="' + priority + '">' +
                '<span class="priority-dot"></span>' +
                '</span>' +
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

                '@can('share project')' +
                '<td class="align-content-center">' +
                '<button type="button" class="btn btn-sm share-project" style="background: none;" ' +
                'data-id="{{ $project->id }}" data-assignees="{{ $project->project_assignee }}" ' +
                'data-target-type="sub_discussion" data-target-id="' + discussion_data[j].id + '" ' +
                'data-toggle="tooltip" data-placement="bottom" title="Share this project">' +
                '<i class="fa fa-share-alt share_btn"></i>' +
                '</button>' +
                '</td>' +
                '@endcan' +

                deleteSubDiscussionButton +

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

        $('.drop-zone').remove();

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

            // update database
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

        // SECTION ENTER
    $(document).on('keydown', '#section_name', function(e){

        if(e.key === 'Enter'){

            e.preventDefault();

            $(this).blur();
        }

    });


    // DISCUSSION ENTER
    $(document).on('keydown', '#discussion_name', function(e){

        if(e.key === 'Enter'){

            e.preventDefault();

            $(this).blur();
        }

    });


    // SUB DISCUSSION ENTER
    $(document).on('keydown', '#sub_discussion_name', function(e){

        if(e.key === 'Enter'){

            e.preventDefault();

            $(this).blur();
        }

    });
    // Change Section Stage Status
    $('body').on('change', '.section-stage-status', function() {
        var section_id = $(this).data('id');
        var stage_status = $(this).val();
        var listSelectElement = this;

        $.ajax({
            url: '{{ url('project_management_section/update') }}/' + section_id,
            method: 'POST',
            data: {
                stage_status: stage_status,
                '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
                // Successfully updated in list view
                // Sync to board view - update the corresponding dropdown
                var boardSelect = $('.section-stage-status[data-id="' + section_id + '"]').not(listSelectElement);
                if (boardSelect.length > 0) {
                    boardSelect.val(stage_status);
                    // Trigger updateStageSelectColor if available in board view context
                    if (typeof updateStageSelectColor !== 'undefined') {
                        updateStageSelectColor(boardSelect[0]);
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

    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('taskId')) {
            var taskId = urlParams.get('taskId');
            var sectionId = urlParams.get('sectionId');
            
            setTimeout(function() {
                if (sectionId) {
                    var sectionBtn = $('.parent-min[data-id="' + sectionId + '"]');
                    if (sectionBtn.length && !sectionBtn.closest('.parent-row').data('section-loaded')) {
                        sectionBtn.click();
                    }
                }
                
                var checkTask = setInterval(function() {
                    var taskBtn = $('.open-chatbox[data-value="' + taskId + '"]');
                    if (taskBtn.length) {
                        clearInterval(checkTask);
                        taskBtn.click();
                    }
                }, 500);
                
                setTimeout(function() { clearInterval(checkTask); }, 10000);
            }, 1000);
        }
    });

</script>
