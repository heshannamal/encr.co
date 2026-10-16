<style>
    .project-inner-title {
        display: flex;
        align-items: center;
        font-size: 1.5rem;
        font-weight: 700;
        gap: 12px;
    }
    .project-inner-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        margin-right: -8px;
        box-shadow: 0 0 0 1px #bbb;
    }
    .project-inner-user-group {
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }
    .project-inner-user-group .project-inner-avatar {
        border: 2px solid #fff;
        margin-left: -8px;
    }
    .project-inner-back-btn {
        border: 1px solid #313131;
        border-radius: 20px;
        padding: 4px 18px;
        background: #fff;
        color: #313131;
        font-size: 13px;
        margin-left: 18px;
        transition: background 0.2s;
    }
    .project-inner-back-btn:hover {
        background: #f5f5f5;
    }
    .project-inner-add-task, .project-inner-add-section {
        color: #888;
        font-size: 1rem;
        cursor: pointer;
        padding: 6px 0 6px 32px;
        display: block;
    }
    .project-inner-add-section {
        font-size: 1.1rem;
        font-weight: 500;
        color: #bbb;
        padding-left: 0;
    }
    /* .project-inner-tabs {
        background-color: #323232;
    } */
    .inner_tab {
        border: none!important;
        background-color: transparent !important;
        color: Black;
        font-size: 1rem;
    }
    .project-management-nav .nav-item .nav-link.active {
        color: black !important;
        border-bottom: 2px solid black !important;
    }
    .project-management-nav .nav-tabs {
        border-bottom: unset;
        padding: 2px;
    }
    .project-management-nav .nav-tabs .nav-item {
        margin-bottom: unset;
    }
    .filter_btn {
        border: 1px solid gray;
        color: gray;
        font-weight: 600;
        padding: 5px 12px;
    }
    .table-responsive .table tbody td {
        padding: 0.4rem 1rem !important;
    }
    .border_left_unset {
        border-left: unset !important;
    }
    .border_right_unset {
        border-right: unset !important;
    }
    .dark_card {
        /* background: #323232; */
        color: #4E4C4C;
        box-shadow: 0px 2px 4px 0px #00000026;
    }
    .margin_right {
        margin-right: 5px;
    }
    .add_task_btn {
        border: unset;
        text-align: left;
        color: gray;
        font-weight: 100;
    }
    .add_task_btn:hover {
        border: unset;
        text-align: left;
        color: gray;
        font-weight: 100;
        background-color: transparent;
    }
    .add_task_btn_div {
        padding: unset;
        background-color: transparent !important;
        border: unset !important;
    }
    .add_task_btn_div:hover {
        padding: unset;
        background-color: transparent !important;
        border: unset !important;
    }
    .project-management-nav .project-inner-tabs .nav-link:focus,
    .project-management-nav .project-inner-tabs .nav-link:focus-visible {
        outline: none;
        box-shadow: none;
    }
    .padding_bottom_5px {
        padding-bottom: 5px;
    }
    .font_15px {
        font-size: 15px !important;
    }
    .margin_left_15px {
        margin-left: 15px;
    }
    /* Base circle style */
    .circle_checkbox {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 20px;
        height: 20px;
        border: 1px solid gray;
        border-radius: 50%;
        position: relative;
        cursor: pointer;
        vertical-align: middle;
        margin-right: 8px;
        display: inline-block;
    }
    .circle_checkbox:checked {
        border: unset;
        background-color: #27ae60
    }

    /* Checked state with right mark (✓) */
    .circle_checkbox:checked::before {
        content: "\2713"; /* Unicode for check mark */
        position: absolute;
        top: 0px;
        left: 5px;
        font-size: 14px;
        color: #ffffff;
        font-weight: bold;
    }
    /* Hide all section rows by default */
    .section-customer-portal {
    display: none;
    }
    .cursor_pointer {
        cursor: pointer;
    }
    .header-layout {
        margin-bottom: 1.5rem !important;
    }
    .content-position {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
    .input-group.input-group-alternative {
        background-color: white;
    }
    @media ((min-width: 768px)) {
        .content-position {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
    }

    .custom-breadcrumb {
        background: none !important;
        font-family: Roboto Condensed !important;
        font-size: 12px;
        margin-bottom: 0rem;
    }

    .custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        content: ">" !important;
        color: #999999;
    }

    .custom-breadcrumb .breadcrumb-item a {
        color: #000;
        font-weight: 600;
        text-decoration: none;
    }

    .custom-breadcrumb .breadcrumb-item.active {
        color: #B3B3B3;
    }

    .inner_tab:hover {
        color: Black;
        font-weight: 600;
        border-bottom: 2px solid black !important;
    }

</style>
        <div class="card-body py-2 px-4 mobile_section_padding_reduce">
            <div class="tab-content" id="projectTabContent">
                <!-- List Tab -->
                <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                    @include('pages.order_management.management.project_inner_list')
                </div>
            </div>
        </div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@include('pages.project.task_comment')
