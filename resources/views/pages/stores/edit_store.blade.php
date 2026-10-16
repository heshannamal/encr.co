@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('content')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }
    .select2 {
        height: 1.8rem;
        border-radius: 5px !important;
        border: 1px #e4e4e4b8 solid !important;
    }
    .select2-selection.select2-selection--single {
        height: 1.6rem !important;
    }
    .is-done{
        margin-left: -25px;
        margin-top: -5px;
    }
    #image_previewe_info {
        height: 100px;
        width: 100px;
    }
    .sport-ico-container {
        margin-left: -26px;
        margin-top: 22px;
        margin-right: 6px;
        width: 40px;
        height: 40px;
        /* background-color: #565656; */
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .sport-ico {
        font-size: 22px;
        color: #b8b8b8;
    }

    #customer_id{
        height: 70px !important;
    }

    #customer_id + .select2.select2-container{
        min-height: 60px !important;
        border: 1px #e4e4e4 solid !important;
        margin-right: 2px;
    }

    #addRemoveContactsList{
        height: 100px !important;
    }

    #addRemoveContactsList + .select2.select2-container{
        min-height: 100px !important;
    }
    .pic-size {
        width: 41px;
        height: 41px;
    }
    .btn-div-height {
        height: 50px;
    }
    .pic-position {
        position: relative;
        top: -2px;
    }
    .text-color {
        color: #ffffff
    }
    .btn-txt-size {
        font-size: small;
    }
    .add-btn-padding {
        padding-right: unset;
    }
    .layout-btn-padding {
        padding: unset;
    }
    .btn-position-right {
        position: relative;
        right: -15px;
    }
    .btn-position-left {
        position: relative;
        left: -15px;
    }
    .btn-text-top {
        position: relative;
        top: -2px;
    }
    .add-btn-right {
        position: relative;
        right: -5px;
    }
    .export-btn-right {
        position: relative;
        right: -15px;
    }
    .content-position {
        position: relative;
        top: -15px;
    }
    .rep-div-padding {
        padding: unset;
    }
    .name-position {
        position: relative;
        left: 10%;
    }
    .pic2-position {
        position: relative;
        left: 5%;
        background-color: #ffffff;
        width: 42px;
        height: 41px;
    }
    .map-btn-right {
        width: 100%;
        padding: unset;
    }
    .add-btn-text {
        position: relative;
        right: -13px;
    }
    .btns-text {
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }
    .btns-text:hover {
        color: #909090 ;
    }
    .btns-style {
        width: 100%;
        height: 100%;
        background-color: #909090;
        border: unset;
        border-radius: 5px;
    }
    .btns-card:hover {
        background-color: #ffffff
    }
    .btns-padding {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btn-top {
        position: relative;
        top: -20px;
    }
    .btn-right {
        position: relative;
        right: 13px;
    }
    .details-position {
        position: relative;
        left: 54px;
    }
    .content-position {
        position: relative;
        top: -5px;
    }
    .sport-icon {
        width: 35px !important;
        height: 35px !important;
        position: relative;
        top: 3px;
    }
    .select2 {
        height: 1.8rem;
        border-radius: 5px !important;
        border: 1px solid #cad1d7 !important;
    }

    .store-navbar .nav-link{
        color: grey !important;
        font-size: .8rem;
    }
    .store-navbar .nav{
        color: grey !important;
        font-size: .8rem;
        border-bottom: 2px solid #70717171 !important;
    }

    .styled-nav-item .nav-link.active , .styled-nav-item .nav-link:hover {
        color: black !important;
        border-bottom: 2px solid black !important;
        font-size: .8rem;
    }
    .card{
        border-radius: 0rem !important;
        border: none !important;
    }
    .form-lable-info{
        color: black;
    }
    .detail-section input[type="text"], .detail-section input[type="email"], .select2.select2-container.select2-container--default{
        border-radius: 0rem !important;
        color: #717070 !important;
        /* border: 0.5px solid #eaeaea !important; */
        width: 100% !important;
    }
    .card-body {
        padding: 1rem;

    }
    .card{
        height: 100%;
    }
    .header-style{
        color: black;
        font-size: 1.2rem;
        font-weight: 600;
    }
    .sub-header-style{
        color: black;
        font-size: 1rem;
        font-weight: 600;
    }
    .add-text-button{
        border: none;
        padding: 2px;
        color: #b3b3b3;
        background-color: unset;
        cursor: pointer;
        outline: unset;
        font-weight: 500;
        font-size: .8rem;
    }
    .color-selection-box .select2-container--default .select2-selection--multiple{
        background-color: transparent;
    }
    .color-selection-box .select2-container--below .select2-container--focus, .color-selection-box .select2-container--default{
        min-height: 93px;
    }
    .styled-button-decoration{
        border: none !important;
        border-radius: 0rem !important;
        font-size: .8rem !important;
        padding: .2em 2em !important;
        cursor: pointer;
    }
    .color-selection-box .select2-selection__rendered .row{
        position: relative !important;
        left: 13px !important;
        width: 136px;
        height: 18px !important;
    }
    .color-selection-box .select2-selection__choice{
        display: inline-flex !important;
        width: 155px !important;
        border-radius: 0rem !important;
        height: 20px !important;
    }
    .color-selection-box .select2-container--default .select2-selection--multiple .select2-selection__choice {
        margin-top: 0px !important;
        line-height: 7px !important;
        background-color: #ffffff !important;
    }
    .mail_mail-button{
        outline: unset;
        color: #d3d3d3;
        background-color: transparent;
        border: 1px solid #d3d3d3;
        padding: .2rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: .3rem;
        cursor: pointer;
    }
    .sales-rep-style .select2-selection--single{
        background-color: transparent;
        color: #d3d3d3;
    }
    .sales-rep-style .select2-container--default{
        border: none !important;
    }
    .sales-rep-style .select2-selection__rendered{
        line-height: 25px !important;
        color:#47D6B6 !important;
    }
    .sales-rep-style .select2{
        height: 1.5rem !important;
    }
    .store-unique-styles table.dataTable thead .sorting:before,table.dataTable thead .sorting_asc:before,table.dataTable thead .sorting_desc:before,table.dataTable thead .sorting_asc_disabled:before,table.dataTable thead .sorting_desc_disabled:before {
        content: "\f0de";
        font-family: FontAwesome;
    }
    .store-unique-styles table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after,table.dataTable thead .sorting_asc_disabled:after,table.dataTable thead .sorting_desc_disabled:after {
        content: "\f0dd";
        font-family: FontAwesome;
        right: .65rem !important;
    }
    .store-unique-styles table thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .store-unique-styles table tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .store-unique-styles th, .store-unique-styles td {
        padding: 10px;
    }
    .store-unique-styles .dataTables_info {
        color:#b3b3b3;
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
    .datepicker{
        border-radius: 0rem;
    }

    @media (max-width: 767px) {
        body.datepicker-open-mobile {
            overflow: hidden !important;
        }

        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }

        /* Backdrop for the datepicker */
        .ui-datepicker-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            display: none;
        }

        /* Make the datepicker a beautiful centered modal on mobile */
        #ui-datepicker-div {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            width: 90% !important;
            max-width: 320px !important;
            height: auto !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
            border: none !important;
            border-radius: 12px !important;
            background: #ffffff !important;
            padding: 15px !important;
            z-index: 9999 !important;
            box-sizing: border-box !important;
        }

        .ui-datepicker-header {
            background: #f8f9fa !important;
            border: none !important;
            border-bottom: 1px solid #e9ecef !important;
            padding: 8px 0 !important;
            margin-bottom: 10px !important;
            position: relative;
        }

        .ui-datepicker-title {
            color: #333 !important;
            font-weight: bold !important;
            font-size: 1.05rem !important;
        }

        .ui-datepicker-prev, .ui-datepicker-next {
            top: 5px !important;
            cursor: pointer !important;
            background: #e9ecef !important;
            border-radius: 50% !important;
            width: 28px !important;
            height: 28px !important;
        }
        .ui-datepicker-prev:hover, .ui-datepicker-next:hover {
            background: #dee2e6 !important;
        }
        .ui-datepicker-prev span, .ui-datepicker-next span {
            margin-top: -8px !important;
            margin-left: -8px !important;
        }

        .ui-datepicker-calendar {
            width: 100% !important;
            margin: 0 !important;
        }

        .ui-datepicker-calendar th {
            font-size: 0.75rem !important;
            color: #6c757d !important;
            padding: 6px 0 !important;
            text-transform: uppercase;
            font-weight: 600;
        }

        .ui-datepicker-calendar td {
            padding: 2px !important;
        }

        .ui-datepicker-calendar td a,
        .ui-datepicker-calendar td span {
            display: block !important;
            text-align: center !important;
            padding: 8px 0 !important;
            border-radius: 8px !important;
            font-size: 0.9rem !important;
            color: #495057 !important;
            border: none !important;
            background: none !important;
            text-decoration: none !important;
        }

        .ui-datepicker-calendar td a:hover {
            background: #f1f3f5 !important;
        }

        .ui-datepicker-calendar td.ui-datepicker-today a {
            background: #e7f5ff !important;
            color: #1c7ed6 !important;
            font-weight: bold !important;
        }

        .ui-datepicker-calendar td.ui-datepicker-current-day a {
            background: #1c7ed6 !important;
            color: #ffffff !important;
        }

        /* Timepicker specific styling on mobile */
        .ui-timepicker-div {
            border-top: 1px solid #e9ecef !important;
            margin-top: 12px !important;
            padding-top: 12px !important;
        }

        .ui-timepicker-div dl {
            margin: 0 !important;
            text-align: left;
        }

        .ui-timepicker-div dt {
            font-size: 0.8rem !important;
            color: #495057 !important;
            font-weight: 600 !important;
            margin-bottom: 4px !important;
            float: none !important;
            width: auto !important;
        }

        .ui-timepicker-div dd {
            margin: 0 0 10px 0 !important;
            float: none !important;
            width: auto !important;
        }

        .ui-timepicker-div .ui_tpicker_hour_slider,
        .ui-timepicker-div .ui_tpicker_minute_slider {
            height: 8px !important;
            background: #e9ecef !important;
            border: none !important;
            border-radius: 4px !important;
            margin: 5px 0 !important;
        }

        .ui-timepicker-div .ui-slider-handle {
            width: 18px !important;
            height: 18px !important;
            background: #1c7ed6 !important;
            border: none !important;
            border-radius: 50% !important;
            top: -5px !important;
            cursor: pointer !important;
            outline: none !important;
        }

        /* Done / Now Button pane styling */
        .ui-datepicker-buttonpane {
            border-top: 1px solid #e9ecef !important;
            margin-top: 12px !important;
            padding-top: 10px !important;
            display: flex !important;
            justify-content: space-between !important;
        }

        .ui-datepicker-buttonpane button {
            float: none !important;
            margin: 0 !important;
            width: 48% !important;
            padding: 8px 0 !important;
            border-radius: 6px !important;
            font-size: 0.85rem !important;
            font-weight: bold !important;
            border: 1px solid #dee2e6 !important;
            background: #f8f9fa !important;
            color: #495057 !important;
            cursor: pointer !important;
            height: auto !important;
        }

        .ui-datepicker-buttonpane button.ui-datepicker-close {
            background: #1c7ed6 !important;
            color: #ffffff !important;
            border-color: #1c7ed6 !important;
        }

        /* Hide the native calendar icon on the input while typing/tapping on mobile */
        input.datepicker::-webkit-calendar-picker-indicator {
            display: none !important;
        }

        /* Force the hour/minute slider handle to actually render visibly —
        jQuery UI's own theme specificity was likely beating your override */
        .ui-timepicker-div .ui_tpicker_hour .ui-slider .ui-slider-handle,
        .ui-timepicker-div .ui_tpicker_minute .ui-slider .ui-slider-handle {
            width: 18px !important;
            height: 18px !important;
            background: #1c7ed6 !important;
            border: 2px solid #ffffff !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
            border-radius: 50% !important;
            top: -6px !important;
            margin-left: -9px !important;
            cursor: pointer !important;
            outline: none !important;
            z-index: 2;
        }
    }
    .btn-green-outlined{
        border: 2px solid #47D6B6;
        background-color: transparent;
        color: #47D6B6;
        padding: .6rem .5rem;
        font-size: .7rem;
        cursor: pointer;
    }
    .grey-text-btn{
        background-color: transparent;
        border: none;
        font-size: .7rem;
        outline: unset;
        color: grey;
        font-weight: 600;
        cursor: pointer;
    }
    .img-thumbnail{
        border: none;
        border-radius: 0px;
        padding: 0px;
        min-width: 4rem;
    }
    .available-lable{
        padding: 3px 10px;
        background-color: #E0F9D4;
        border-radius: .5rem;
        color: #55A630;
    }
    .unavailable-lable{
        padding: 3px 10px;
        background: #FFEDEE;
        border-radius: .5rem;
        color: #D00000;
    }
    .hidden-tab{
        display: none;
    }
    .nav-item-new{
        font-size: .7rem;
    }
    .nav-item-new :hover , .nav-item-new .active{
        border-bottom: 2px solid black;
        font-size: .7rem;
    }
    .nav-item-new .nav-link{
        color: grey;
    }
    .nav-item-new .active , .nav-item-new .nav-link :hover{
        color: black;
    }
    .checkbox-container{
        font-size: .7rem;
        color: #717070;
        background-color: #fafafa;
        padding: 5px 0px;
        border-radius: 0.4rem;
        margin: .1rem .2rem;
    }
    .image-upload-area {
        border: 2px dashed #ddd;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        background-color: #fafafa;
    }

    .upload-icon {
        color: #aaa;
    }

    .file-input {
        display: none;
    }
    .icon-button{
        border: none;
        background-color: unset;
        color: #b3b3b3;
        font-size: 1rem;
        outline: unset;
        padding:1px 10px;
        cursor: pointer;
    }
    .grey-color-button{
        padding: .3rem .5rem;
        font-size: .7rem;
        border: 1px solid #b3b3b3;
        color: grey;
        background-color: #f8f8f8;
        margin-left: .5rem;
    }
    .product-area-spinner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        z-index: 1000;
        pointer-events: none;
    }
    .checkbox-container {
        display: inline-block;
        cursor: pointer;
        width: 30%;
        text-align: center;
        border: 1px solid #b3b3b3;
    }

    .checkbox-container input[type="checkbox"] {
        display: none;
    }

    .checkbox-container.checked {
        background-color: green;
        color: white;
        text-align: center;
    }
    .drag-handle {
        cursor: move;
        text-align: center;
        padding: 10px;
        color: #888;
    }

    .drag-handle i {
        font-size: 1rem; /* Adjust size as needed */
    }
    .available-label{
        background-color: #aaf1aa;
        color: white;
        padding: .2rem .5rem;
        border-radius: .5rem;
    }
    .unavailable-label{
        background-color: #f5a2a2;
        color: white;
        padding: .2rem .5rem;
        border-radius: .5rem;
    }
    .upload-area {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 95px;
        border: 2px dashed #ccc;
        text-align: center;
        padding: 10px;
        cursor: pointer;
    }
    .upload-area-view {
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 95px;
        border: 2px dashed #ccc;
        text-align: center;
        padding: 5px;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #007bff;
        cursor: pointer;
    }
    .upload-area-view {
        position: relative; /* Ensure the label is the reference for absolute positioning */
        display: inline-block; /* Ensures the label wraps around the image */
    }

    .close-button {
        position: absolute;
        top: 5px;
        right: 5px;
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        color: #b3b3b3;
        font-size: 12px;
        z-index: 10;
    }
    .icon-container-responsive {
        display: flex;
        justify-content: space-around;
        height: 100%;
    }

    .icon-container-responsive i {
        cursor: pointer;
        font-size: 1.5rem;
        padding: 0.5rem;
    }
    .theme_update_button{
        margin: 5px;
        color: white;
        padding: 3px 14px;
        border: none;
        cursor: pointer;
    }

    .view_store_btn {
        background-color: #47D6B6;
        color: white;
        border: unset;
        width: 110px;
        height: 33px;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
    }
    .draggable-image {
        cursor: move;
        max-width: 100%;
        height: auto;
        min-width: 4rem;
    }
    .close-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        padding: 0;
        border: 1px solid #e38787;
        color: #e38787;
    }
    .hidden-important {
        display: none !important;
    }

    .flex-important {
        display: flex !important;
    }
    .add-new-category, .edit-category, .sort_category {
        background-color: #d1d1d1;
        font-size: .7rem;
        color: white;
        border-radius: .3rem;
    }
    .swal2-title{
        font-size: 1.5em !important;
    }
    .ui-sortable-helper {
        display: table;
        background: #fff;
        border: 1px solid #ccc;
        position: absolute !important;
        z-index: 9999 !important;
    }

    .sortable-placeholder {
        background: #f0f0f0;
        visibility: visible !important;
        height: 40px;
        border: 1px dashed #aaa;
    }

    /* By default, hide mobile elements */
    .mobile-sub-tab-wrapper {
        display: none;
    }
    .catalog-product-checkbox-col {
        display: none;
    }
    .desktop-only-cell {
        display: table-cell;
    }
    .mobile-only-cell {
        display: none !important;
    }
    .mobile-only-availability {
        display: none !important;
    }
    .mobile-modal-header {
        display: none !important;
    }

    @media (max-width: 767px) {
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
        .select2-search input {
            font-size: 16px !important;
        }

    /* Custom Informations modal - mobile responsive fix */
    #manage-custom-informations-modal .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
        width: auto;
    }

    #manage-custom-informations-modal .modal-content {
        min-height: auto !important;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    #manage-custom-informations-modal .modal-header {
        flex-shrink: 0;
    }

    #manage-custom-informations-modal .modal-body {
        flex: 1 1 auto;
        overflow-y: auto;
        max-height: calc(90vh - 130px); /* leaves room for header + footer */
    }

    #manage-custom-informations-modal #custom_information-container .container {
        padding-left: 10px;
        padding-right: 10px;
    }

    #manage-custom-informations-modal #custom_information-container .row {
        margin-left: 0;
        margin-right: 0;
    }

    #manage-custom-informations-modal .modal-footer {
        flex-shrink: 0;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
        padding: 0.75rem;
    }

    #manage-custom-informations-modal .modal-footer .btn {
        flex: 1 1 auto;
        min-width: 100px;
        font-size: 0.75rem;
        padding: 0.5rem 0.5rem;
        white-space: nowrap;
    }

    #manage-custom-informations-modal #use_custom_information_template {
        width: 100% !important;
        max-width: 100%;
        display: block !important;
        margin-left: 0 !important;
    }

    #manage-custom-informations-modal .mt-2.mb-3 {
        padding: 0 15px;
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100%;
        box-sizing: border-box;
    }

    #manage-custom-informations-modal .mt-2.mb-3 label.form-lable-info {
        margin-left: 0 !important;
        display: block;
    }

    /* Add custom input modal - mobile fix */
    #informations-add-modal .modal-dialog,
    #save-as-template-modal .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
        width: auto;
    }

    #informations-add-modal .form-check-label {
        font-size: 0.85rem;
    }

        .bg-box.container-fluid.fix-nav.header-layout{
            margin-bottom: 0 !important;
        }

        .sd-mobile-wrap {
            background: #f7f7f7;
            min-height: 100vh;
        }
        .sd-m-section {
            background: #fff;
            padding: 14px 16px 12px;
            border-bottom: 1px solid #e8e8e8;
        }
        .sd-m-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 8px;
        }
        .sd-m-device-seg {
            display: flex;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        .sd-m-dev-btn {
            flex: 1;
            background: #fff;
            border: none;
            border-right: 1px solid #e0e0e0;
            padding: 8px 4px;
            font-size: 0.8rem;
            color: #555;
            cursor: pointer;
            transition: background .15s;
        }
        .sd-m-dev-btn:last-child { border-right: none; }
        .sd-m-dev-btn.active {
            background: #1E2129;
            color: #fff;
            font-weight: 700;
        }
        /* Accordion */
        .sd-m-accordion {
            background: #fff;
            margin-top: 8px;
            border-top: 1px solid #e8e8e8;
            border-bottom: 1px solid #e8e8e8;
        }
        .sd-m-acc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            font-size: 1rem;
            font-weight: 600;
            color: #1E2129;
            cursor: pointer;
        }
        .sd-m-acc-body {
            padding: 4px 16px 16px;
            border-top: 1px solid #f0f0f0;
        }
        .sd-m-sub-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
        }
        /* Theme cards */
        .sd-m-theme-row {
            display: flex;
            gap: 10px;
        }
        .sd-m-theme-card {
            flex: 1;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            transition: border-color .2s;
        }
        .sd-m-theme-card:has(input:checked) {
            border-color: #47D6B6;
        }
        .sd-m-theme-swatch {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            flex-shrink: 0;
        }
        .sd-m-theme-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: #1E2129;
            flex: 1;
        }
        .sd-m-theme-check {
            color: #47D6B6;
            font-size: 1.1rem;
        }
        /* Color rows */
        .sd-m-color-list { display: flex; flex-direction: column; gap: 0; }
        .sd-m-color-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
        }
        .sd-m-color-row:last-child { border-bottom: none; }
        .sd-m-color-swatch {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            flex-shrink: 0;
        }
        .sd-m-color-info { flex: 1; }
        .sd-m-color-name { font-size: 0.88rem; font-weight: 600; color: #1E2129; }
        .sd-m-color-hex { font-size: 0.75rem; color: #aaa; }
        .sd-m-edit-btn {
            background: #f5f5f5;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 6px 10px;
            color: #555;
            font-size: 0.8rem;
            cursor: pointer;
        }
        /* Image upload */
        .sd-m-img-preview {
            margin-bottom: 10px;
        }
        .sd-m-upload-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed #d0d0d0;
            border-radius: 10px;
            padding: 20px;
            color: #b0b0b0;
            font-size: 0.85rem;
            gap: 6px;
            cursor: pointer;
            background: #fafafa;
        }
        .sd-m-upload-area i { font-size: 1.8rem; }
        .sd-m-img-view {
            display: block;
            text-align: center;
            padding: 8px;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            background: #fafafa;
        }
        /* Action grid */
        .sd-m-action-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 4px;
        }
        .sd-m-act-btn {
            background: #f0f0f0;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 8px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        .sd-m-act-danger {
            background: #fff0f0;
            border-color: #f5c0c0;
            color: #c0392b;
        }
        /* Save button */
        .sd-m-save-wrap {
            padding: 16px;
            margin-top: 8px;
        }
        .sd-m-save-btn {
            width: 100%;
            background: #47D6B6;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .sd-m-chevron { font-size: 0.9rem; color: #aaa; }
        .sd-m-preview-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #454e64;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            height: 35px;
        }
        .sd-m-preview-btn:hover,
        .sd-m-preview-btn:focus {
            color: #fff;
            text-decoration: none;
            opacity: 0.9;
        }
        /* General Info page layout */
        .container-fluid.store-unique-styles {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        .container-fluid.store-unique-styles .row {
            margin-left: 0px !important;
            margin-right: 0px !important;
        }

        #summary .row > [class*="col-"] {
            padding-left: 0px !important;
            padding-right: 0px !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        #summary .card {
            border-radius: 0.5rem !important;
            margin-bottom: 1rem !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05) !important;
        }

        /* Mobile-specific segmented control sub-tab bar */
        .mobile-sub-tab-wrapper {
            display: flex !important;
            background-color: #f1f3f5;
            border-radius: 0.5rem;
            padding: 4px;
            margin-bottom: 1rem;
            width: 100%;
        }
        .mobile-sub-tab-wrapper button {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            padding: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #717070;
            border-radius: 0.35rem;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }
        .mobile-sub-tab-wrapper button.active {
            background-color: #ffffff;
            color: #000000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Products tab columns visibility */
        #all_products_div, #store_products_div {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding-left: 0px !important;
            padding-right: 0px !important;
        }

        /* Toggle display based on active mobile sub-tab */
        #all_products_div {
            display: block;
        }
        #store_products_div {
            display: none;
        }

        .products_collapse_button {
            display: none !important;
        }

        .catalog-product-checkbox-col {
            display: table-cell !important;
        }
        .desktop-only-cell {
            display: none !important;
        }
        .mobile-only-cell {
            display: table-cell !important;
        }
        .mobile-only-availability {
            display: block !important;
        }
        .mobile-modal-header {
            display: flex !important;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        /* Modal slide-up overlay style for product info */
        #store_products_info {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ffffff;
            z-index: 1060;
            overflow-y: auto;
            padding: 15px;
        }
        #store_products_info.mobile-modal-active {
            display: block !important;
        }

        /* Bottom action bar on mobile */
        .mobile-bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #ffffff;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1);
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            padding: 15px;
            z-index: 1050;
            display: none;
            align-items: center;
            justify-content: space-between;
        }
        .mobile-bottom-bar .btn-cancel {
            background-color: #ffffff;
            color: #717070;
            border: 1px solid #dcdcdc;
            border-radius: 0.75rem;
            padding: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            flex: 1;
            margin-right: 8px;
            max-width: 48%;
            cursor: pointer;
            text-align: center;
        }
        .mobile-bottom-bar .btn-add-store {
            background-color: #E8F7F0;
            color: #2D9C75;
            border: 1px solid #2D9C75;
            border-radius: 0.75rem;
            padding: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            flex: 1;
            margin-left: 8px;
            max-width: 48%;
            cursor: pointer;
            text-align: center;
        }

        .store-product-mobile-row-expanded {
            background-color: #fcfcfc;
        }

        /* Rotate chevron */
        .store-product-row-toggle.expanded .toggle-chevron {
            transform: rotate(180deg);
        }
        .toggle-chevron {
            display: inline-block;
            transition: transform 0.2s ease;
        }

        /* Adjust alignment */
        .text-left-mobile {
            text-align: left !important;
        }

        /* Mobile-only bottom action bar for General Info (Delete/Cancel/Save) */
        #summary .control-btns {
            display: none !important;
        }
        .mobile-summary-bottom-bar {
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #ffffff;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1);
            padding: 12px 15px;
            z-index: 1050;
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .mobile-summary-bottom-bar button {
            flex: 1;
            border: none;
            border-radius: 0.6rem;
            padding: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            color: #ffffff;
            cursor: pointer;
            text-align: center;
        }
        .mobile-summary-bottom-bar .btn-mobile-delete {
            background-color: #e5342f;
        }
        .mobile-summary-bottom-bar .btn-mobile-cancel {
            background-color: #a6acb7;
        }
        .mobile-summary-bottom-bar .btn-mobile-save {
            background-color: #1fa25a;
        }

        /* Prevent content from being hidden behind the fixed bar, and remove any gap under it */
        #summary {
            padding-bottom: 70px !important;
        }
        /* Product Info panel - Update Product button (mobile only) */
        #store_products_info .control-btns {
            display: block !important;
            /* position: sticky; */
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #ffffff;
            /* box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1); */
            padding: 12px 15px !important;
            margin-top: 10px;
            margin-bottom: 0 !important;
            text-align: center;
        }

        #store_products_info .control-btns .product-update-button {
            display: block;
            width: 100%;
            max-width: 100%;
            margin: 0 auto !important;
            padding: 12px !important;
            font-size: 0.95rem !important;
            font-weight: 700 !important;
            border-radius: 0.6rem !important;
            background-color: #47aed6 !important;
            box-shadow: 0 2px 6px rgba(71, 174, 214, 0.35);
        }

        #store_update {
            margin-bottom: 0 !important;
        }
        body {
            margin-bottom: 0 !important;
        }/* Keep the three tabs on one line on mobile */
        .store-navbar #tabs-icons-text {
            flex-wrap: nowrap !important;
            display: flex !important;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .store-navbar #tabs-icons-text .nav-item {
            flex: 1 1 auto;
            white-space: nowrap;
            text-align: center;
        }
        .store-navbar #tabs-icons-text .nav-link {
            padding: 8px 4px !important;
            font-size: 0.7rem !important;
            white-space: nowrap;
        }
        .container-fluid.store-unique-styles.mb-5 {
                margin-bottom: 0 !important;
        }

        /* Auto increase height for select2 multiple on mobile */
        .select2.select2-container,
        .select2.select2-container.select2-container--focus,
        .select2.select2-container.select2-container--open {
            height: auto !important;
            min-height: 1.8rem !important;
        }
        .select2-container--default .select2-selection--multiple,
        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default.select2-container--open .select2-selection--multiple {
            height: auto !important;
            min-height: 1.8rem !important;
            border: 1px solid #cad1d7 !important;
            border-radius: 5px !important;
        }
        .select2-selection.select2-selection--multiple,
        .select2-container .select2-selection--multiple,
        .select2-container--focus .select2-selection--multiple,
        .select2-container--open .select2-selection--multiple {
            height: auto !important;
            min-height: 1.8rem !important;
        }
        /* Space out choices/tags on mobile */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            margin-top: 5px !important;
            margin-bottom: 5px !important;
            margin-left: 5px !important;
            padding: 3px 8px !important;
            display: inline-flex !important;
            align-items: center;
        }
        /* Ensure the search field aligns nicely on mobile */
        .select2-container--default .select2-selection--multiple .select2-search--inline {
            margin-top: 5px !important;
            margin-bottom: 5px !important;
            margin-left: 5px !important;
        }
        .select2-container--default .select2-selection--multiple .select2-search__field {
            margin-top: 0 !important;
            height: 1.8rem !important;
            line-height: 1.8rem !important;
        }
        /* Ensure spacing inside the input area is neat */
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding-bottom: 5px !important;
        }

        /* Fix: select2 dropdown z-index must be above the mobile product info modal overlay (z-index: 1060) */
        .select2-dropdown {
            z-index: 1070 !important;
        }

        /* Also ensure the select2 container itself renders on top when open */
        .select2-container--open {
            z-index: 1070 !important;
        }

        /* Modal: make absolutely sure it's on top of everything */
        .modal {
            z-index: 1080 !important;
        }
        .modal-backdrop {
            z-index: 1070 !important;
        }
        .modal-dialog {
            position: relative;
            z-index: 1085 !important;
        }
    }

    /* Desktop: always hide the mobile bar, regardless of load order */
    @media (min-width: 768px) {
        .mobile-summary-bottom-bar {
            display: none !important;
        }
        #mobile_catalog_actions.mobile-bottom-bar {
        display: none !important;
    }
    }

</style>

@section('back-btn')
    @if(isset($is_new) && $is_new)
        <a href="{{ route('stores') }}" class="home-btn-color" title="Back to stores">BACK TO STORES</a>
    @else
        <a href="{{ route('store.overview', ['id' => $store->id]) }}" class="home-btn-color" title="Back to overview">BACK TO STORE OVERVIEW</a>
    @endif
@endsection

@section('order-header')
    <span>{{ isset($is_new) && $is_new ? 'Create Team Store' : 'Edit Team Store' }}</span>
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid mb-5 content-position store-unique-styles">
    <div class="se-pre-con"></div>

            <div class="col-md-12 content-position">
                <div style="border-radius: 0rem; background-color:transparent;border:none">
                    <div>
                        <div class="row">
                            <div class="col-md-8">
                                <span style="font-size: 1.5rem;color: black;font-weight: 600;">{{$store->store_name}}</span>
                            </div>
                            <div class="col-md-4 text-right">
                                <button class="view_store_btn" id="view_store_button_id" @if(!empty($store->direct_access_url)) onclick="window.open('{{ makeStoreDomainRoute($store->direct_access_url) }}?is-authenticated=true', '_blank')" @endif>
                                    <i class="fa fa-arrow-up-from-bracket" aria-hidden="true"></i> VIEW STORE
                                </button>
                            </div>
                        </div>
                        <div class="nav-wrapper store-navbar store_edit_main_tabbar">
                            <ul class="nav" id="tabs-icons-text" role="tablist">
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">GENERAL INFO
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#products_tab" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Products">PRODUCTS
                                    </a>
                                </li>
                                <li class="nav-item styled-nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#store_design" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false" title="Store Design">STORE DESIGN
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content detail-section" id="myTabContent">
{{--================================ summery ===================================== --}}

                            <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                <form action="{{ route('store.create') }}" id="store_update" method="post" enctype="multipart/form-data">
                                    @csrf
                                <input type="hidden" id="store_id" name="store_id" value="{{$store->id}}" />
                                    <div class="row">
                                        <div class="col-md-6 mb-2" style="padding-right: 7px">
                                            <div class="col-md-12" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-2">
                                                                Store Info
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-lable-info">Organization</label>
                                                                <select class="form-control info-form-input store-select2-dropdown" id="organization_id" name="organization_id" required>
                                                                    <option value="">Select an Organization</option>
                                                                    @foreach ($organizations as $organization)
                                                                    <option data-contacts="{{ json_encode($organization->contactOrganizations) }}" data-sales-rep="{{$organization->user_id}}" data-sales-tax="{{number_format($organization->sales_tax, 2) ?? 0.00}}" value="{{$organization->id}}" @if($store->organization_id == $organization->id) selected @endif>{{$organization->organization_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-lable-info">Sport</label>
                                                                <select class="form-control info-form-input store-select2-dropdown" id="sport_id" name="sport_id" required>
                                                                    <option value="">Select a sport</option>
                                                                    @foreach ($sports as $sport)
                                                                    <option value="{{$sport->id}}" @if($store->sport_id == $sport->id) selected @endif>{{$sport->sport_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Store Name</label>
                                                                <input type="text" class="form-control info-form-input" id="store_name" name="store_name" value="{{$store->store_name}}" required />
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Sales Person</label>
                                                                <select class="form-control info-form-input store-select2-dropdown" id="sales_person" name="sales_person" required>
                                                                    <option value="">Select a user</option>
                                                                    @foreach ($users as $user)
                                                                    <option value="{{$user->id}}" @if($store->salese_person == $user->id) selected @endif>{{$user->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Customer Store URL</label>
                                                                <div class="d-flex">
                                                                    <input type="text" class="form-control info-form-input" style="border-right: none;padding-right: 0;max-width: 6.1rem;" value="https://encr.shop/" disabled>
                                                                    <input type="text" class="form-control info-form-input" style="border-left: none;padding-left: 0;" id="url" name="url" value="{{$store->direct_access_url}}" required>
                                                                </div>
                                                                <small id="url_feedback" class="text-danger d-none">This store name already exists.</small>
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <label class="form-lable-info">Store Prefix For Products</label>
                                                                <input type="text" class="form-control info-form-input" id="store_prefix_for_products" name="store_prefix_for_products" value="{{$store->product_prefix}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-2">
                                                                Store Deadline
                                                            </div>
                                                            <div class="col-md-12 mt-2 mb-2 d-flex align-items-center">
                                                                <p class="m-0" style="font-size: .8rem;">Set Store Deadline</p>
                                                                <label class="custom-toggle ml-2 mb-0">
                                                                    <input type="checkbox" name="set_store_deadline" @if($store->set_store_deadline == 1) checked @endif>
                                                                    <span class="custom-toggle-slider rounded-circle"></span>
                                                                </label>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="form-lable-info">Open Store On (PST)</label>
                                                                <input class="form-control info-form-input datepicker" name="open_date" id="open_date" value="{{$store->open_date}}" required/>
                                                            </div>

                                                            <div class="col-md-6 set-store-deadline" @if($store->set_store_deadline != 1) style="display:none" @endif>
                                                                <label class="form-lable-info">Close Store On (PST)</label>
                                                                <input class="form-control info-form-input datepicker" name="close_date" id="close_date" value="{{$store->close_date}}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-1">
                                                                Contact Coaches
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control info-form-input store-select2-dropdown" id="contact_coach_id" name="contact_coach_id" readonly>
                                                                    <option value="">Select a coach</option>
                                                                    @foreach ($contacts as $contact)
                                                                    <option value="{{$contact->id}}" data-user-name="{{$contact->first_name}} {{$contact->last_name}}" data-email="{{$contact->email}}" @if($store->contact_coach_id == $contact->id) selected @endif>{{$contact->first_name}} {{$contact->last_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 text-right">
                                                                <button type="button" class="grey-text-btn" onclick="handleAddContactClick()">ADD NEW</button>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="form-lable-info mb-2">Coach Details</label>
                                                                <input type="text" class="form-control info-form-input mb-2" name="coach_name" id="coach_name" value="{{$store->coach_name}}" required readonly/>
                                                                <input type="email" class="form-control info-form-input" name="coach_email" id="coach_email" value="{{$store->coach_email}}" required readonly/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-2">
                                                                Customer Service
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-lable-info mb-1" style="font-size: .8rem;font-weight: 500;">Salse assistant</label>
                                                                <select class="form-control info-form-input store-select2-dropdown" id="sales_assistant" name="sales_assistant" required>
                                                                    <option value="">Select a user</option>
                                                                    @foreach ($users as $user)
                                                                    <option value="{{$user->id}}" @if($store->sales_assistant == $user->id) selected @endif>{{$user->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="form-lable-info mb-1" style="font-size: .8rem;font-weight: 500;">Service Phone</label>
                                                                <input class="form-control info-form-input" name="service_phone" id="service_phone" value="{{$store->service_phone ? $store->service_phone : '+1 888-501-4999'}}"/>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="form-lable-info mb-1" style="font-size: .8rem;font-weight: 500;">Service Website</label>
                                                                <input class="form-control info-form-input" name="service_website" id="service_website" value="{{$store->service_website ? $store->service_website : 'www.encorecustom.com'}}"/>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="form-lable-info mb-1" style="font-size: .8rem;font-weight: 500;">Service Email</label>
                                                                <input class="form-control info-form-input" name="service_email" id="service_email" value="{{$store->service_email ? $store->service_email : 'teamstore@encr.co'}}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 header-style mb-2">
                                                                Order Tracker
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-lable-info mb-2" style="color: grey">Give your customer insight on their orders.</label>
                                                            </div>
                                                            <div class="col-md-12 mt-2 mb-2 d-flex align-items-center">
                                                                <p class="m-0" style="font-size: .8rem;">Enable Order Tracking</p>
                                                                <label class="custom-toggle ml-2 mb-0">
                                                                    <input type="checkbox" name="enable_order_tracking" @if($store->enable_tracking == 1) checked @endif>
                                                                    <span class="custom-toggle-slider rounded-circle"></span>
                                                                </label>
                                                            </div>

                                                            <table>
                                                                <tr style="border: none; font-size: .8rem;color:black">
                                                                    <td>
                                                                        <input type="radio" value="1" name="track_by" checked> Track by Order
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="col-md-6 mb-2" style="padding-left: 7px">
                                            <div class="col-md-12" style="padding: 0px;">
                                                <div class="col-md-12" style="padding: 0px;height: 100%;">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-8 header-style mb-1">
                                                                    Shipping Methods
                                                                </div>
                                                                <div class="col-md-12 mt-2 mb-3">
                                                                    <label class="form-lable-info">Select Shipping Method</label>
                                                                    <select class="form-control info-form-input store-select2" name="shipping_method[]" id="shipping_method" multiple required>
                                                                        @foreach ($store_shipping_methods as $store_shipping_method)
                                                                            <option value="{{ $store_shipping_method->id }}"
                                                                                @if($store->StoreAddedShippingMethods->pluck('shipping_method')->contains($store_shipping_method->id)) selected @endif>
                                                                                {{ $store_shipping_method->shipping_method_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="col-md-12" style="padding-left:0px;padding-right:0px;height: 100%;">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-8 header-style mb-1">
                                                                    Custom Information
                                                                </div>
                                                                <div class="col-md-4 mb-1 text-right">
                                                                    <button type="button" class="grey-text-btn manage-custom-informations">MANAGE</button>
                                                                </div>
                                                                <div class="col-md-12 mt-2 mb-2">
                                                                    <label class="form-lable-info" style="color: grey">If you wish to collect custom information, insert custom fields here.</label>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                                                        <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;">
                                                                        </button>
                                                                        <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;padding-bottom: .5rem;font-size: .8rem;">First name & Last name</p>
                                                                    </div>
                                                                    <div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                                                        <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;">
                                                                        </button>
                                                                        <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;padding-bottom: .5rem;font-size: .8rem;">Email, Phone & Address</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" id="manage-custom-informations-area">
                                                                    @foreach ($store->StoreAddedCustomInformations as $custom_information)
                                                                        @if (isset($custom_information->storeCustomInformationsDetails))
                                                                            <div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                                                                <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;" onclick="remove_custom_information({{$custom_information->storeCustomInformationsDetails->id}})">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                                <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;padding-bottom: .5rem;font-size: .8rem;">{{$custom_information->storeCustomInformationsDetails->custom_name}}</p>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="col-md-12" style="padding-left:0px;padding-right:0px;height: 100%;">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-8 header-style mb-1">
                                                                    Coupons
                                                                </div>
                                                                <div class="col-md-4 mb-1 text-right">
                                                                    <button type="button" class="grey-text-btn manage-coupons">MANAGE</button>
                                                                </div>
                                                                <div class="col-md-12" id="manage-coupons-area">
                                                                    @foreach ($store->StoreAddedCoupons as $coupon)
                                                                        @if($store->id == $coupon->store_id && isset($coupon->storeCouponsDetails))
                                                                            <div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                                                                <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                                <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;font-size: .8rem;">{{$coupon->storeCouponsDetails->coupon_name}}</p>
                                                                                <p style="color:#b3b3b3;margin-bottom:0;padding-bottom:0;font-size:.75rem;">
                                                                                    {{
                                                                                        $coupon->storeCouponsDetails->type === 'free_shipping' ? 'Free Shipping' :
                                                                                        ($coupon->storeCouponsDetails->type === 'flat_from_sub' ? '$'.$coupon->storeCouponsDetails->amount.' Off From Sub total' :
                                                                                        ($coupon->storeCouponsDetails->type === 'percentage_from_sub' ? $coupon->storeCouponsDetails->amount.'% Off From Sub total' :
                                                                                        ($coupon->storeCouponsDetails->type === 'flat_from_grand' ? '$'.$coupon->storeCouponsDetails->amount.' Off From Grand total' :
                                                                                        ($coupon->storeCouponsDetails->type === 'percentage_from_grand' ? $coupon->storeCouponsDetails->amount.'% Off From Grand total' : '')
                                                                                        )))
                                                                                    }}
                                                                                </p>
                                                                                <p style="color:#b3b3b3;margin-bottom:.1rem;padding-bottom:.5rem;font-size:.75rem;">{{$coupon->storeCouponsDetails->coupon_code}} &nbsp;&nbsp; <i class="fa fa-clone" aria-hidden="true" style="cursor: pointer" onclick="copyCouponCode('{{$coupon->storeCouponsDetails->coupon_code}}')"></i></p>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="col-md-12" style="padding-left:0px;padding-right:0px;height: 100%;">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-8 header-style mb-1">
                                                                    Taxes and Other Fees (%)
                                                                </div>
                                                                <div class="col-md-12 mt-2 mb-3">
                                                                    <label class="form-lable-info">Select Tax Categories</label>
                                                                    <select class="form-control info-form-input store-select2" name="tax_category[]" id="tax_category" multiple required>
                                                                        @foreach ($store_tax_categories as $store_tax_category)
                                                                            <option value="{{ $store_tax_category->id }}" {{ $store->StoreAddedTaxCategories->pluck('tax_category_id')->contains($store_tax_category->id) ? 'selected' : '' }}>
                                                                                {{ $store_tax_category->tax_category_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12 section_1 mt-2">
                                                                    <label class="form-lable-info mb-1" style="font-size: .8rem;font-weight: 500;">Sales Tax (%)</label>
                                                                    <input type="number" class="mt-1 form-control info-form-input" step="0.01" name="sales_tax" id="sales_tax" value="{{$store->sales_tax}}">
                                                                </div>
                                                                <div class="col-md-12 section_2 mt-2">
                                                                    <label class="form-lable-info mb-1" style="font-size: .8rem;font-weight: 500;">Handling Fee (%)</label>
                                                                    <input type="number" class="mt-1 form-control info-form-input" step="0.01" name="handling_fee" id="handling_fee" value="{{$store->handling_fee}}">
                                                                </div>
                                                                <div class="col-md-12 section_3 mt-2">
                                                                    <label class="form-lable-info mb-1" style="font-size: .8rem;font-weight: 500;">Service Charge (%)</label>
                                                                    <input type="number" class="mt-1 form-control info-form-input" step="0.01" name="service_charge" id="service_charge" value="{{$store->service_charge}}">
                                                                </div>
                                                                <div class="col-md-12 section_4 mt-2">
                                                                    <label class="form-lable-info mb-1" style="font-size: .8rem;font-weight: 500;">Other (%)</label>
                                                                    <input type="number" class="mt-1 form-control info-form-input" step="0.01" name="other" id="other" value="{{$store->other}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-12 mt-3" style="padding: 0px;">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-8 header-style mb-1">
                                                                Store Template
                                                            </div>
                                                            <div class="col-md-4 mb-1 text-right">
                                                                <button type="button" class="grey-text-btn">MANAGE TEMPLATE</button>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label class="form-lable-info mb-2" style="color: grey">This store will be saved as atemplate and be used as a starting point for your next store.</label>
                                                                <label class="form-lable-info mb-2"><i class="fa fa-info-circle" style="color: orange" aria-hidden="true"></i>&nbsp; If your store has a deadline, it can not be saved as a template.</label>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <button type="button" class="btn-green-outlined" onclick="saveAsTemplate('{{$store->id}}')">SAVE AS TEMPLATE</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-12 control-btns mb-5" style="background-color: white;padding-top:0px">
                                        {{-- @can('edit organizations') --}}
                                            <button type="submit" style="background-color: #47D6B6" id="submit_store_main_data" class="styled-button-decoration btn btn-success btn-custom mt-2">Save</button>
                                        {{-- @endcan --}}

                                        {{-- @can('delete organizations') --}}
                                            <button type="button" id="delete_form" style="background-color: #b3b3b3" class="styled-button-decoration btn btn-danger btn-custom mt-2" value="">Delete</button>
                                        {{-- @endcan --}}
                                            <button type="reset" style="background-color: #d27070;color:white" class="styled-button-decoration btn btn-secondary btn-custom mt-2">Cancel</button>
                                    </div>
                                    <div class="mobile-summary-bottom-bar">
    <button type="button" class="btn-mobile-delete" id="mobile_delete_store_btn">Delete</button>
    <button type="button" class="btn-mobile-cancel" id="mobile_cancel_store_btn">Cancel</button>
    <button type="button" class="btn-mobile-save" id="mobile_save_store_btn">Save</button>
</div>
                                </form>
                            </div>

{{--================================ Products ======================================== --}}
                            <div class="tab-pane fade" id="products_tab" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                                <!-- Mobile Sub-Tab Switcher -->
                                <div class="mobile-sub-tab-wrapper">
                                    <button type="button" class="mobile-sub-tab-btn active" data-target="#all_products_div">Products</button>
                                    <button type="button" class="mobile-sub-tab-btn" data-target="#store_products_div">Products in store</button>
                                </div>

                                <!-- Mobile Bottom Action Bar -->
                                <div class="mobile-bottom-bar" id="mobile_catalog_actions">
                                    <button type="button" class="btn-cancel" id="btn_cancel_catalog_select"><i class="fa fa-times"></i> Cancel</button>
                                    <button type="button" class="btn-add-store" id="btn_add_catalog_to_store"><i class="fa fa-plus"></i> Add to store</button>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <button class="btn products_collapse_button">
                                            <i class="fa fa-align-left"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4" style="padding-right:7px" id="all_products_div">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 header-style mb-1">
                                                        Products
                                                    </div>
                                                    <div class="col-md-6 text-right d-flex align-items-center">
                                                        <label class="form-lable-info" style="color: grey">Showing all <span id="store_product_count"></span> products</label>
                                                    </div>
                                                    <div class="col-md-12 mt-2 mb-2">
                                                        <div style="position: relative;">
                                                            <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%);">
                                                                <i class="fas fa-search" style="color: #adadad;"></i>
                                                            </span>
                                                            <input type="text" id="search-input" class="form-control" style="border: none; border-bottom: 1px solid #adadad; padding-left: 30px;" placeholder="Products, stores or catalog search">
                                                        </div>
                                                    </div>

                                                    {{--  style="height: 60rem;overflow-y: scroll;" --}}

                                                    <div id="sub_product_list" style="height: 60rem;overflow-y: scroll;-webkit-overflow-scrolling: touch;touch-action: pan-y;">
                                                        {{-- products here --}}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding-right:7px" id="store_products_div">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 d-flex justify-content-center align-items-center dropping-area hidden-important" id="delete_products_area" style="top: -5%;position: absolute;" value="delete" data-is_saved="1">
                                                        <div class="close-circle">
                                                            <i class="fa fa-trash"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 header-style mb-1">
                                                        Products in store
                                                    </div>
                                                    <div class="col-md-6 text-right d-flex align-items-center">
                                                        <label class="form-lable-info" style="color: grey">Showing all <span id="store_saved_product_count"></span> products</label>
                                                    </div>
                                                    <div class="col-md-12 mt-2 mb-2">
                                                        <button type="button" class="grey-text-btn add-new-category">ADD NEW CATEGORY</button>
                                                        <button type="button" class="grey-text-btn edit-category">EDIT CATEGORY</button>
                                                        <button type="button" class="grey-text-btn sort_category">SORT CATEGORIES</button>
                                                    </div>

                                                    <div id="store_product_list" style="height: 60rem;overflow-y: scroll;width: 100%;-webkit-overflow-scrolling: touch;touch-action: pan-y;">
                                                        {{-- products here --}}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 0px;" id="store_products_info">
                                        <form id="store_product_update" style="height: 100%">
                                        <input type="hidden" name="store_product_id" id="store_product_id">
                                        <input type="hidden" name="product_id" id="product_id">
                                        <input type="hidden" name="size_type_id" id="size_type_id">
                                        <div class="card product-area-spinner" id="product_display_card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <!-- Mobile Modal Header -->
                                                    <div class="col-md-12 mobile-modal-header justify-content-between align-items-center mb-3">
                                                        <h5 class="m-0" style="font-weight: 600; color: black; font-size: 1.1rem;">Products Info</h5>
                                                        <button type="button" class="close-mobile-product-modal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #999;">&times;</button>
                                                    </div>
                                                    <div class="col-md-12 header-style mb-1 desktop-only-cell">
                                                        Products Info
                                                    </div>
                                                    <div class="col-md-12">
                                                        <ul class="nav" role="tablist" style="border-bottom: 2px solid #bebebe;">
                                                            <li class=" nav-item-new" role="presentation">
                                                                <a class="nav-link active nav-link-new" id="general_tab-new" href="#" onclick="showTab('general_tab')">GENERAL</a>
                                                            </li>
                                                            <li class=" nav-item-new" role="presentation">
                                                                <a class="nav-link nav-link-new" id="size_options-new" href="#" onclick="showTab('size_options')">SIZE & OPTIONS</a>
                                                            </li>
                                                            <li class=" nav-item-new" role="presentation">
                                                                <a class="nav-link nav-link-new" id="images_tab-new" href="#" onclick="showTab('images_tab')">IMAGES</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content mt-2">
                                                            <div class="tab-pane-new fade show active" id="general_tab" role="tabpanel">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12 sub-header-style mb-1">
                                                                                Basic Info
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <label class="form-lable-info">Default Name</label>
                                                                                <input type="text" class="form-control info-form-input" id="store_product_default_name" name="store_product_default_name" style="background-color: #f1f1f1;" value="" disabled />
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <label class="form-lable-info">Name</label>
                                                                                <input type="text" class="form-control info-form-input" id="store_product_name" name="store_product_name" value="" required />
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <label class="form-lable-info">Category</label>
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <select class="form-control info-form-input store-select2" id="store_product_category" name="store_product_category" required>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <label class="form-lable-info" for="store_product_embellishment">Embellishment option</label>
                                                                                <select class="form-control info-form-input store-select2" id="store_product_embellishment" name="store_product_embellishment">
                                                                                    <option value="">Select Embellishment</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-12 mt-3 d-flex align-items-center">
                                                                                <input type="checkbox" name="mandotary" id="mandotary" class="mr-1">
                                                                                <label for="mandotary" class="form-label-info mt-1 mb-0">Required ?</label>
                                                                            </div>
                                                                            <div class="col-md-12 mt-2" style="height: fit-content;">
                                                                                <label class="form-lable-info mb-2">Description</label>
                                                                                <div id="store_product_style_editor" class="form-control info-form-input" style="border-radius: 0rem; min-height: 100px;"></div>
                                                                                <input type="hidden"  name="store_product_style" id="store_product_style">
                                                                            </div>
                                                                            <div class="col-md-12 sub-header-style mt-3">
                                                                                Product Availability
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <table>
                                                                                    <tr style="border: none; font-size: .8rem;color:black">
                                                                                        <td>
                                                                                            <input type="radio" value="1" name="store_product_availability" id="store_product_available"> Available
                                                                                        </td>
                                                                                        <td style="color: red">
                                                                                            <input type="radio" value="0" name="store_product_availability" id="store_product_unavailable"> Unavailable
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <div class="col-md-12 sub-header-style mb-2 mt-2">
                                                                                Price Analytics
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="form-lable-info">Default Price ($)</label>
                                                                                <input type="number" step="0.01" min="0" class="form-control info-form-input"  id="store_product_default_price" name="store_product_default_price" value="0.00">
                                                                                <label class="form-lable-info mt-2">Added price additions</label>
                                                                                <table style="width: 100%;" id="price_addition_table">
                                                                                    <tr style="border: none">
                                                                                        <td style="font-size:.8rem"></td>
                                                                                        <td style="font-size:.8rem"></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <button type="button" class="view_store_btn add_price_addition">Add Price Addition</button>
                                                                            </div>

                                                                            {{-- <div class="col-md-6 sub-header-style mb-1 mt-3">
                                                                                Tax Category
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="form-lable-info mt-1" style="color: grey">Please select your tax category here.</label>
                                                                            </div> --}}
                                                                            {{-- <div class="col-md-6 mt-2 mb-3">
                                                                                <label class="form-lable-info">Tax Category</label>
                                                                                <select id="store_product_tax_category" name="store_product_tax_category" class="form-control info-form-input store-select2" required>
                                                                                    <option value="">Select a category</option>
                                                                                    <option value="1">Select 1</option>
                                                                                    <option value="2">Select 2</option>
                                                                                </select>
                                                                            </div> --}}
                                                                            <div class="col-md-6 sub-header-style mt-3">
                                                                                Minimum Order Quantity
                                                                                <input type="number" min="1" step="1" class="form-control info-form-input"  id="store_product_moq" name="store_product_moq">
                                                                            </div>
                                                                            <div class="col-md-6 sub-header-style mt-3">
                                                                                Maximum Order Quantity
                                                                                <input type="number" min="1" step="1" class="form-control info-form-input"  id="store_product_maxoq" name="store_product_maxoq">
                                                                            </div>

                                                                            <div class="col-md-12 sub-header-style mb-1 mt-3">
                                                                                Product Shipping Weight
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label class="form-lable-info mt-1" style="color: grey">Please enter this product shipping weight here.</label>
                                                                            </div>
                                                                            <div class="col-md-6 mt-2 mb-3">
                                                                                <label class="form-lable-info">Shipping Weight (OZ)</label>
                                                                                <input type="text" class="form-control info-form-input"  id="store_product_shipping_weight" name="store_product_shipping_weight">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane-new fade hidden-tab" id="size_options" role="tabpanel">
                                                                <div class="row">
                                                                    <div class="col-md-8 sub-header-style mb-2 mt-1">
                                                                        Product Sizes
                                                                    </div>
                                                                    {{-- <div class="col-md-4 text-right mb-2 mt-1">
                                                                        <button type="button" style="font-size: .8rem;" class="grey-text-btn">ADD SIZE OPTIONS</button>
                                                                    </div> --}}
                                                                    <div class="col-md-8">
                                                                        <label class="form-lable-info mt-1" style="color: grey; font-size: .8rem;">Please select the all the size options available for this product.</label>
                                                                    </div>
                                                                    <div class="col-md-4 text-right">
                                                                        <button type="button" style="font-size: .8rem;" class="grey-text-btn select-all-sizes">SELECT ALL</button>
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <div class="container" style="border: 1px solid #b3b3b3;padding:10px">
                                                                            <div class="card" style="border: 1px solid lightgrey; min-height: 10rem;display: inline-block;" id="store_product_sizes_content">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="collapse-class col-md-12 mt-3">
                                                                        <div class="container" style="border: 1px solid #b3b3b3;">
                                                                            <div class="col-md-12 mt-2 mb-2 icon-for-collapse-roster d-flex justify-content-between align-items-center" style="cursor: pointer;">
                                                                                <span class="sub-header-style" style="font-weight: 400;">Individual name</span>
                                                                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                                                            </div>
                                                                            <div class="col-md-12 mb-2 header-content-div-roster mt-3">
                                                                                <label class="custom-toggle mb-2">
                                                                                    <input type="checkbox" class="roster-elements" name="set_individual_name" id="set_individual_name">
                                                                                    <span class="custom-toggle-slider rounded-circle"></span>
                                                                                </label>
                                                                                <div class="row">
                                                                                    <div class="col-md-6 d-flex align-items-center mb-2" style="padding-left: 2.1rem;">
                                                                                        <input type="checkbox" name="name_required" class="form-check-input" style="margin-top: -0.1rem;" disabled/>
                                                                                        <label id="name_required" class="form-check-label ms-2 mb-0">Make Required?</label>
                                                                                    </div>

                                                                                    <div class="col-md-6 d-flex align-items-center mb-2" style="padding-left: 2.1rem;">
                                                                                        <input type="checkbox" name="name_exlusive" class="form-check-input" style="margin-top: -0.1rem;" disabled/>
                                                                                        <label id="name_exlusive" class="form-check-label ms-2 mb-0">Make Exclusive?</label>
                                                                                    </div>
                                                                                    <div class="col-md-6 d-flex align-items-center mb-2" style="padding-left: 2.1rem;">
                                                                                        <input type="checkbox" name="name_not_for_printing" class="form-check-input" style="margin-top: -0.1rem;" disabled/>
                                                                                        <label id="name_not_for_printing" class="form-check-label ms-2 mb-0">Not For Printing</label>
                                                                                    </div>

                                                                                    <div class="col-md-6 mb-2">
                                                                                        <label for="extraPriceInput" class="form-lable-info">Extra Price:</label>
                                                                                        <input type="text" id="extraPriceInput" name="name_extra_price" value="0.00" class="form-control" style="width: 5rem !important;" disabled/>
                                                                                    </div>

                                                                                    <div class="col-md-6 mb-2">
                                                                                        <label for="characterLimitInput" class="form-lable-info">Character Limit:</label>
                                                                                        <input type="text" id="characterLimitInput" name="name_character_limit" value="6" class="form-control" style="width: 5rem !important;" disabled/>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="collapse-class col-md-12 mt-3">
                                                                        <div class="container" style="border: 1px solid #b3b3b3;">
                                                                            <div class="col-md-12 mt-2 mb-2 icon-for-collapse-roster d-flex justify-content-between align-items-center" style="cursor: pointer;">
                                                                                <span class="sub-header-style" style="font-weight: 400;">Individual number</span>
                                                                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                                                            </div>
                                                                            <div class="col-md-12 mb-2 header-content-div-roster mt-3">
                                                                                <label class="custom-toggle mb-2">
                                                                                    <input type="checkbox" class="roster-elements" name="set_individual_number" id="set_individual_number">
                                                                                    <span class="custom-toggle-slider rounded-circle"></span>
                                                                                </label>
                                                                                <div class="row">
                                                                                    <div class="col-md-6 d-flex align-items-center mb-2" style="padding-left: 2.1rem;">
                                                                                        <input type="checkbox" name="number_required" class="form-check-input" style="margin-top: -0.1rem;" disabled/>
                                                                                        <label class="form-check-label ms-2 mb-0">Make Required?</label>
                                                                                    </div>

                                                                                    <div class="col-md-6 d-flex align-items-center mb-2" style="padding-left: 2.1rem;">
                                                                                        <input type="checkbox" name="number_exlusive" class="form-check-input" style="margin-top: -0.1rem;" disabled/>
                                                                                        <label class="form-check-label ms-2 mb-0">Make Exclusive?</label>
                                                                                    </div>

                                                                                    <div class="col-md-6 mb-2">
                                                                                        <label class="form-lable-info">Extra Price:</label>
                                                                                        <input type="text" name="number_extra_price" value="0.00" class="form-control" style="width: 5rem !important;" disabled/>
                                                                                    </div>
                                                                                    <div class="col-md-12 mb-2">
                                                                                        <label  class="form-lable-info">Select Numbers</label>
                                                                                        <select name="number_type" id="number_type" class="form-control info-form-input store-select2">
                                                                                                <option value="0-99">0 - 99</option>
                                                                                                <option value="3-digits">3 Digits</option>
                                                                                                <option value="custom">Custom Numbers</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-12 mb-2" id="number-count-div">
                                                                                        <label class="form-lable-info">Add Number of digits</label>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <input type="number" id="min_number_count" name="min_number_count" class="form-control me-2" placeholder="Min Count" style="width: 100px;">
                                                                                            <span class="mr-1 ml-1">to</span>
                                                                                            <input type="number" id="max_number_count" name="max_number_count" class="form-control me-2" placeholder="Max Count" style="width: 100px;">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12 mb-2" id="number-range-div">
                                                                                        <label class="form-lable-info">Add Number Range</label>
                                                                                        <div class="d-flex align-items-center">
                                                                                            <input type="number" id="min_number" name="min_number" class="form-control me-2" placeholder="Min" style="width: 100px;">
                                                                                            <span class="mr-1 ml-1">to</span>
                                                                                            <input type="number" id="max_number" name="max_number" class="form-control me-2" placeholder="Max" style="width: 100px;">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12 mb-2" style="min-height: 5rem">
                                                                                        <label class="form-lable-info">Add numbers to be excluded</label>
                                                                                        <select name="exclude_numbers[]" id="exclude_numbers" class="form-control info-form-input store-select2-add" multiple></select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane-new fade hidden-tab" id="images_tab" role="tabpanel">
                                                                <div class="row">
                                                                    <div class="col-md-12 sub-header-style mt-1">
                                                                        Product Images
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-lable-info mt-1" style="color: grey; font-size: .8rem;">Upload, sort and edit product images here. </label>
                                                                    </div>
                                                                    <div class="col-md-12 sub-header-style mb-2 mt-3" style="color: grey">
                                                                        Upload Images
                                                                    </div>
                                                                    <div class="col-md-12 mb-2">
                                                                        <label class="form-label-info" for="file-input-product" style="width: 100%;">
                                                                            <div class="image-upload-area" style="border: 2px dashed #ccc; padding: 20px; text-align: center;">
                                                                                <div class="upload-icon">
                                                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                                                </div>
                                                                                <p style="color: grey">
                                                                                    Drag & drop your files here or <span style="font-weight: 600">CLICK HERE</span> to upload product images.<br>
                                                                                    We support .gif, .jpg, .png .jpeg file formats. You can select multiple files.
                                                                                </p>
                                                                            </div>
                                                                        </label>
                                                                        <input type="file" name="file-input-product" id="file-input-product" class="file-input" multiple accept=".jpg, .png, .jpeg, .gif" />
                                                                    </div>
                                                                    <div class="col-md-6 sub-header-style mb-2 mt-3" style="color: #B3B3B3">
                                                                        Gallery of Product Images
                                                                    </div>
                                                                    <div class="col-md-6 text-right mb-3 mt-3">
                                                                        <button type="button" style="font-size: .8rem;" class="grey-text-btn"><i class="fa fa-recycle" aria-hidden="true"></i>&nbsp;RECOVER DELETED IMAGES</button>
                                                                    </div>
                                                                    <div class="col-md-12 variant-manage-div" style="display: none">
                                                                        {{-- <button type="button" style="font-size: .8rem;background-color: antiquewhite;" class="grey-text-btn manage-variants">MANAGE VARIANT</button> --}}
                                                                    </div>
                                                                    <div class="col-md-12 mt-2">
                                                                        <table style="width: 100%;">
                                                                            <thead>
                                                                                <tr style="height: 50px;border-top: 1px solid #eeeeee;border-bottom: 1px solid #eeeeee;background-color: #fafafa;font-size: .75rem;color:grey !important">
                                                                                    <th></th>
                                                                                    <th>PRODUCT IMAGE</th>
                                                                                    <th>IMAGE CAPTIONS </th>
                                                                                    <th>VARIANT</th>
                                                                                    <th class="text-center">ACTIONS</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="uploaded_product_table_tbody">
                                                                                {{-- tbody here --}}
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 control-btns mb-5" style="background-color: white;padding-top:0px">
                                                        <button type="button" style="background-color: #47aed6" class="styled-button-decoration product-update-button btn btn-success btn-custom mt-2">Update Product</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

{{--================================ store design =================================== --}}
                            <div class="tab-pane fade" id="store_design" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">

                                {{-- ===== DESKTOP / TABLET VIEW (md and up) – unchanged original ===== --}}
                                <div class="d-none d-md-block">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3" style="border: 1px solid #b3b3b3 !important;">
                                                            <div class="row">
                                                                <div class="col-md-12" style="border-bottom: 1px solid #b3b3b3 !important;min-height: 5rem;">
                                                                    <div class="card">
                                                                        <div class="icon-container-responsive">
                                                                            <i class="fa fa-desktop d-flex align-items-center icon-for-change-responsive" data-device="desktop"></i>
                                                                            <i class="fa fa-tablet d-flex align-items-center icon-for-change-responsive" data-device="tablet"></i>
                                                                            <i class="fa fa-mobile d-flex align-items-center icon-for-change-responsive" data-device="mobile"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <form id="store_design_data" style="width: 100%">
                                                                @csrf
                                                                <div class="col-md-12" style="border-bottom: 1px solid #b3b3b3 !important;min-height: 5rem;">
                                                                    <div class="card">
                                                                        <div class="row">
                                                                            <div class="col-md-12 d-flex justify-content-between align-items-center" style="font-size: 1.3rem; height: 4rem;">
                                                                                <span>Branding</span>
                                                                                <i class="fa fa-chevron-right icon-for-collapse" style="cursor: pointer;" aria-hidden="true"></i>
                                                                            </div>
                                                                            <div class="col-md-12 header-content-div" style="display: none">
                                                                                {{-- <label class="form-lable-info mb-2" style="color: grey;">Event Name</label>
                                                                                <textarea style="border-radius: 0rem;" class="form-control info-form-input mb-3"  id="event_name" name="event_name" cols="30" rows="3"></textarea> --}}
                                                                                <label class="form-lable-info" style="color: grey;">Select Theme</label>
                                                                                <table style="width: 100%;">
                                                                                    <tr style="border: none; font-size: .8rem;color:black">
                                                                                        <td>
                                                                                            <input type="radio" value="0" name="selected_theme" id="selected_theme_light" checked> Light
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="radio" value="1" name="selected_theme" id="selected_theme_dark"> Dark
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <label class="form-lable-info mt-2 mb-2" style="color: grey;">Colors</label>
                                                                                <table style="width: 100%;margin-bottom: 1rem;">
                                                                                    <tr style="border: none; font-size: .8rem; color: black;">
                                                                                        <td style="padding: 5px">
                                                                                            <button class="btn btn-secondary-color" type="button" style="background-color: white; border: 1px solid #b3b3b3; padding: 5px 10px;margin:0px;width:100%;">Primary Color</button>
                                                                                            <input type="color" name="color_picker_secondary" class="color-picker-secondary">
                                                                                        </td>
                                                                                        <td style="padding: 5px">
                                                                                            <button class="btn btn-primary-color" type="button" style="background-color: white; border: 1px solid #b3b3b3; padding: 5px 10px;margin:0px;width:100%;">Buttons Color</button>
                                                                                            <input type="color" name="color_picker_primary" class="color-picker-primary">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="border: none; font-size: .8rem; color: black;">
                                                                                        <td style="padding: 5px">
                                                                                            <button class="btn btn-header-color" type="button" style="background-color: white; border: 1px solid #b3b3b3; padding: 5px 10px;margin:0px;width:100%;">Header Text</button>
                                                                                            <input type="color" name="color_picker_header" class="color-picker-header">
                                                                                        </td>
                                                                                        <td style="padding: 5px">
                                                                                            <button class="btn btn-footer-color" type="button" style="background-color: white; border: 1px solid #b3b3b3; padding: 5px 10px;margin:0px;width:100%;">Footer Text</button>
                                                                                            <input type="color" name="color_picker_footer" class="color-picker-footer">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr style="border: none; font-size: .8rem; color: black;">
                                                                                        <td style="padding: 5px">
                                                                                            <button class="btn btn-buttons-color" type="button" style="background-color: white; border: 1px solid #b3b3b3; padding: 5px 10px;margin:0px;width:100%;">Button Text</button>
                                                                                            <input type="color" name="color_picker_buttons" class="color-picker-buttons">
                                                                                        </td>
                                                                                        <td></td>
                                                                                    </tr>
                                                                                </table>
                                                                                <label class="form-lable-info" style="color: grey;">Primary Logo</label>
                                                                                <div class="container mt-2 mb-4">
                                                                                    <label for="primary_logo_image" id="primary_logo_image_upload_area" class="upload-area">
                                                                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                                                                        <div class="upload-icon"><i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"></i>&nbsp;UPLOAD IMAGE</div>
                                                                                    </label>
                                                                                    <label for="primary_logo_image" id="primary_logo_image_display_area" class="upload-area-view" style="display: none;">
                                                                                        <img src="{{ asset('public/images/default.png') }}" id="primary_logo_image_uploaded" alt="Image" style="width: auto;height: 5rem;border: 2px solid #f9f9f9;max-width:15rem">
                                                                                        <button type="button" onclick="removeImagePreview('primary_logo_image')" id="primary_logo_image_close_button" class="close-button" style="display:none">X</button>
                                                                                    </label>
                                                                                    <input type="file" id="primary_logo_image" name="primary_logo_image" onchange="imageDisplay(this,'primary_logo_image')" class="file-select" accept="image/*" style="display: none">
                                                                                </div>
                                                                                <label class="form-lable-info" style="color: grey;">Secondary Logo</label>
                                                                                <div class="container mt-2 mb-4">
                                                                                    <label for="secondary_logo_image" id="secondary_logo_image_upload_area" class="upload-area">
                                                                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                                                                        <div class="upload-icon"><i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"></i>&nbsp;UPLOAD IMAGE</div>
                                                                                    </label>
                                                                                    <label for="secondary_logo_image" id="secondary_logo_image_display_area" class="upload-area-view" style="display: none;">
                                                                                        <img src="{{ asset('public/images/default.png') }}" id="secondary_logo_image_uploaded" alt="Image" style="width: auto;height: 5rem;border: 2px solid #f9f9f9;max-width:15rem">
                                                                                        <button type="button" onclick="removeImagePreview('secondary_logo_image')" id="secondary_logo_image_close_button" class="close-button" style="display:none">X</button>
                                                                                    </label>
                                                                                    <input type="file" id="secondary_logo_image" name="secondary_logo_image" onchange="imageDisplay(this,'secondary_logo_image')" class="file-select" accept="image/*" style="display: none">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" style="border-bottom: 1px solid #b3b3b3 !important;min-height: 5rem;">
                                                                    <div class="card">
                                                                        <div class="row">
                                                                            <div class="col-md-12 d-flex justify-content-between align-items-center" style="font-size: 1.3rem; height: 4rem;">
                                                                                <span>Header</span>
                                                                                <i class="fa fa-chevron-right icon-for-collapse" style="cursor: pointer;" aria-hidden="true"></i>
                                                                            </div>
                                                                            <div class="col-md-12 header-content-div" style="display: none">
                                                                                <label class="form-lable-info" style="color: grey;">Banner Image</label>
                                                                                <div class="container mt-2 mb-4">
                                                                                    <label for="banner_image" id="banner_image_upload_area" class="upload-area">
                                                                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                                                                        <div class="upload-icon"><i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"></i>&nbsp;UPLOAD IMAGE</div>
                                                                                    </label>
                                                                                    <label for="banner_image" id="banner_image_display_area" class="upload-area-view" style="display: none;">
                                                                                        <img src="{{ asset('public/images/default.png') }}" id="banner_image_uploaded" alt="Image" style="width: 100%;height: auto;border: 2px solid #f9f9f9;">
                                                                                        <button type="button" onclick="removeImagePreview('banner_image')" id="banner_image_close_button" class="close-button" style="display:none">X</button>
                                                                                    </label>
                                                                                    <input type="file" id="banner_image" name="banner_image" onchange="imageDisplay(this,'banner_image')" class="file-select" accept="image/*" style="display: none">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" style="border-bottom: 1px solid #b3b3b3 !important;min-height: 5rem;">
                                                                    <div class="card">
                                                                        <div class="row">
                                                                            <div class="col-md-12 d-flex justify-content-between align-items-center" style="font-size: 1.3rem; height: 4rem;">
                                                                                <span>Welcome Banner</span>
                                                                                <i class="fa fa-chevron-right icon-for-collapse" style="cursor: pointer;" aria-hidden="true"></i>
                                                                            </div>
                                                                            <div class="col-md-12 header-content-div" style="display: none">
                                                                                <label class="form-lable-info" style="color: grey;">Welcome Banner image</label>
                                                                                <div class="container mt-2 mb-2">
                                                                                    <label for="fundraising_image" id="fundraising_image_upload_area" class="upload-area">
                                                                                        <i class="fa fa-cloud-upload" aria-hidden="true" style="font-size: 2rem; color:#b3b3b3"></i>
                                                                                        <div class="upload-icon"><i class="fa fa-upload" style="font-size: .7rem;color: #b3b3b3;"></i>&nbsp;UPLOAD IMAGE</div>
                                                                                    </label>
                                                                                    <label for="fundraising_image" id="fundraising_image_display_area" class="upload-area-view" style="display: none;">
                                                                                        <img src="{{ asset('public/images/default.png') }}" id="fundraising_image_uploaded" alt="Image" style="width: 12rem;height: auto;border: 2px solid #f9f9f9;max-width:15rem">
                                                                                        <button type="button" onclick="removeImagePreview('fundraising_image')" id="fundraising_image_close_button" class="close-button" style="display:none">X</button>
                                                                                    </label>
                                                                                    <input type="file" id="fundraising_image" name="fundraising_image" onchange="imageDisplay(this,'fundraising_image')" class="file-select" accept="image/*" style="display: none">
                                                                                </div>
                                                                                {{-- <label class="form-lable-info" style="color: grey;">Fundraising text</label>
                                                                                <input class="form-control info-form-input mt-2" id="fundraising_text" name="fundraising_text" type="text" placeholder="Fundraising text" style="width: 100%;">
                                                                                <label class="form-lable-info mt-2" style="color: grey;">Fundraising font color</label>
                                                                                <button class="btn btn-fundraising-color mt-2" type="button" style="background-color: white; border: 1px solid #b3b3b3; padding: 5px 10px;margin:0px">Fundraising font</button>
                                                                                <input type="color" name="color_picker_fundraising" class="color-picker-fundraising"> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" style="border-bottom: 1px solid #b3b3b3 !important;min-height: 5rem;">
                                                                    <div class="card">
                                                                        <div class="row">
                                                                            <div class="col-md-12 d-flex justify-content-between align-items-center" style="font-size: 1rem; height: 4rem;">
                                                                                <button class="theme_update_button update_theme_settings" data-form="store_design_data" style="background-color: #5ba76f;" type="button"><i class="fa fa-floppy" aria-hidden="true"></i>&nbsp;UPDATE</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card d-flex align-items-center" style="border: 1px solid #b3b3b3 !important; height: 30rem; overflow-x: scroll;">
                                                                <div class="card-body" id="responsive-iframe-content" style="width: 100%">
                                                                    <iframe id="responsive-iframe" @if(!empty($store->direct_access_url)) src="{{ makeStoreDomainRoute($store->direct_access_url) }}" @endif style="width: 100%; height: 100%; border: 1px solid grey;transform: scale(0.5);transform-origin: 0 0;width: 200%;height: 200%;"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ===== MOBILE VIEW ONLY (below md) – premium UI ===== --}}
                                <div class="d-block d-md-none sd-mobile-wrap">
                                    <form id="store_design_data_mobile">
                                    @csrf

                                    <!-- {{-- Device preview selector + View Store link --}}
                                    <div class="sd-m-section">
                                        <div class="sd-m-label">Preview Device</div>
                                        <div class="sd-m-device-seg">
                                            <button type="button" class="sd-m-dev-btn icon-for-change-responsive-mob active" data-device="desktop"><i class="fa fa-desktop"></i> Desktop</button>
                                            <button type="button" class="sd-m-dev-btn icon-for-change-responsive-mob" data-device="tablet"><i class="fa fa-tablet"></i> Tablet</button>
                                            <button type="button" class="sd-m-dev-btn icon-for-change-responsive-mob" data-device="mobile"><i class="fa fa-mobile"></i> Mobile</button>
                                        </div>
                                        @if(!empty($store->direct_access_url))
                                        <a href="{{ makeStoreDomainRoute($store->direct_access_url) }}" target="_blank" class="sd-m-preview-btn mt-2">
                                            <i class="fa fa-eye"></i> View Store Preview
                                        </a>
                                        @endif
                                    </div> -->
                                    {{-- Device preview selector + View Store link --}}
                                    <div class="sd-m-section" style="text-align:center;">
                                        <div class="sd-m-label">Preview Device</div>
                                        <div class="sd-m-device-seg">
                                            <button type="button" class="sd-m-dev-btn icon-for-change-responsive-mob active" data-device="desktop"><i class="fa fa-desktop"></i> Desktop</button>
                                            <button type="button" class="sd-m-dev-btn icon-for-change-responsive-mob" data-device="tablet"><i class="fa fa-tablet"></i> Tablet</button>
                                            <button type="button" class="sd-m-dev-btn icon-for-change-responsive-mob" data-device="mobile"><i class="fa fa-mobile"></i> Mobile</button>
                                        </div>
                                        @if(!empty($store->direct_access_url))
                                        <a href="{{ makeStoreDomainRoute($store->direct_access_url) }}" target="_blank" class="sd-m-preview-btn mt-2">
                                            <i class="fa fa-eye"></i> View Store Preview
                                        </a>
                                        @endif

                                        <div class="sd-m-preview-frame-wrap mt-2" style="border:1px solid #b3b3b3;height:22rem;overflow:hidden;border-radius:8px;display:flex;justify-content:center;">
                                        <div id="sd-m-responsive-iframe-content" style="width:100%;height:100%;margin:0 auto;">
                                            <iframe id="sd-m-responsive-iframe"
                                                @if(!empty($store->direct_access_url)) src="{{ makeStoreDomainRoute($store->direct_access_url) }}" @endif
                                                style="width:200%;height:200%;border:none;transform: scale(0.5);transform-origin: 0 0;"></iframe>
                                        </div>
                                    </div>
                                    </div>

                                    {{-- Branding accordion --}}
                                    <div class="sd-m-accordion">
                                        <div class="sd-m-acc-header" data-target="sd-m-branding">
                                            <span>Branding</span>
                                            <i class="fa fa-chevron-right sd-m-chevron"></i>
                                        </div>
                                        <div class="sd-m-acc-body" id="sd-m-branding" style="display:none;">
                                            <div class="sd-m-sub-label">Select Theme</div>
                                            <div class="sd-m-theme-row">
                                                <label class="sd-m-theme-card" id="sd-m-theme-light">
                                                    <input type="radio" value="0" name="selected_theme" class="d-none sd-m-theme-radio" checked>
                                                    <div class="sd-m-theme-swatch" style="background:#F5F5F5;"></div>
                                                    <span class="sd-m-theme-name">Light</span>
                                                    <i class="fa fa-check-circle sd-m-theme-check"></i>
                                                </label>
                                                <label class="sd-m-theme-card" id="sd-m-theme-dark">
                                                    <input type="radio" value="1" name="selected_theme" class="d-none sd-m-theme-radio">
                                                    <div class="sd-m-theme-swatch" style="background:#1E2129;"></div>
                                                    <span class="sd-m-theme-name">Dark</span>
                                                    <i class="fa fa-check-circle sd-m-theme-check" style="display:none;"></i>
                                                </label>
                                            </div>

                                            <div class="sd-m-sub-label mt-3">Colors</div>
                                            <div class="sd-m-color-list">
                                                <label for="cp_secondary_m" class="sd-m-color-row" style="cursor:pointer;display:flex;align-items:center;margin:0;">
                                                    <div class="sd-m-color-swatch btn-secondary-color-m" style="background:#ffffff;"></div>
                                                    <div class="sd-m-color-info">
                                                        <div class="sd-m-color-name">Primary Color</div>
                                                        <div class="sd-m-color-hex sd-m-hex-secondary">#FFFFFF</div>
                                                    </div>
                                                    <input type="color" id="cp_secondary_m" name="color_picker_secondary" class="color-picker-secondary-m" style="opacity:0;position:absolute;width:1px;height:1px;pointer-events:none;" value="#ffffff">
                                                    <span class="sd-m-edit-btn"><i class="fa fa-pencil"></i></span>
                                                </label>

                                                <label for="cp_primary_m" class="sd-m-color-row" style="cursor:pointer;display:flex;align-items:center;margin:0;">
                                                    <div class="sd-m-color-swatch btn-primary-color-m" style="background:#ffffff;"></div>
                                                    <div class="sd-m-color-info">
                                                        <div class="sd-m-color-name">Buttons Color</div>
                                                        <div class="sd-m-color-hex sd-m-hex-primary">#FFFFFF</div>
                                                    </div>
                                                    <input type="color" id="cp_primary_m" name="color_picker_primary" class="color-picker-primary-m" style="opacity:0;position:absolute;width:1px;height:1px;pointer-events:none;" value="#ffffff">
                                                    <span class="sd-m-edit-btn"><i class="fa fa-pencil"></i></span>
                                                </label>

                                                <label for="cp_header_m" class="sd-m-color-row" style="cursor:pointer;display:flex;align-items:center;margin:0;">
                                                    <div class="sd-m-color-swatch btn-header-color-m" style="background:#717070;"></div>
                                                    <div class="sd-m-color-info">
                                                        <div class="sd-m-color-name">Header Text</div>
                                                        <div class="sd-m-color-hex sd-m-hex-header">#717070</div>
                                                    </div>
                                                    <input type="color" id="cp_header_m" name="color_picker_header" class="color-picker-header-m" style="opacity:0;position:absolute;width:1px;height:1px;pointer-events:none;" value="#717070">
                                                    <span class="sd-m-edit-btn"><i class="fa fa-pencil"></i></span>
                                                </label>

                                                <label for="cp_footer_m" class="sd-m-color-row" style="cursor:pointer;display:flex;align-items:center;margin:0;">
                                                    <div class="sd-m-color-swatch btn-footer-color-m" style="background:#000000;"></div>
                                                    <div class="sd-m-color-info">
                                                        <div class="sd-m-color-name">Footer Text</div>
                                                        <div class="sd-m-color-hex sd-m-hex-footer">#000000</div>
                                                    </div>
                                                    <input type="color" id="cp_footer_m" name="color_picker_footer" class="color-picker-footer-m" style="opacity:0;position:absolute;width:1px;height:1px;pointer-events:none;" value="#000000">
                                                    <span class="sd-m-edit-btn"><i class="fa fa-pencil"></i></span>
                                                </label>

                                                <label for="cp_buttons_m" class="sd-m-color-row" style="cursor:pointer;display:flex;align-items:center;margin:0;">
                                                    <div class="sd-m-color-swatch btn-buttons-color-m" style="background:#ffffff;"></div>
                                                    <div class="sd-m-color-info">
                                                        <div class="sd-m-color-name">Button Text</div>
                                                        <div class="sd-m-color-hex sd-m-hex-buttons">#FFFFFF</div>
                                                    </div>
                                                    <input type="color" id="cp_buttons_m" name="color_picker_buttons" class="color-picker-buttons-m" style="opacity:0;position:absolute;width:1px;height:1px;pointer-events:none;" value="#ffffff">
                                                    <span class="sd-m-edit-btn"><i class="fa fa-pencil"></i></span>
                                                </label>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- Logos accordion --}}
                                    <div class="sd-m-accordion">
                                        <div class="sd-m-acc-header" data-target="sd-m-logos">
                                            <span>Logos</span>
                                            <i class="fa fa-chevron-right sd-m-chevron"></i>
                                        </div>
                                        <div class="sd-m-acc-body" id="sd-m-logos" style="display:none;">
                                            <div class="sd-m-sub-label">Primary Logo</div>
                                            <div class="sd-m-img-preview" id="sd-m-primary_logo_image-wrap">
                                                <label for="primary_logo_image_m" class="sd-m-upload-area" id="primary_logo_image_m_upload_area">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    <span>Tap to upload</span>
                                                </label>
                                                <label for="primary_logo_image_m" class="sd-m-img-view" id="primary_logo_image_m_display_area" style="display:none;">
                                                    <img id="primary_logo_image_m_uploaded" src="{{ asset('public/images/default.png') }}" alt="Primary Logo" style="max-height:6rem;max-width:100%;border-radius:6px;">
                                                </label>
                                                <input type="file" id="primary_logo_image_m" name="primary_logo_image" onchange="imagDisplayMobile(this,'primary_logo_image_m')" accept="image/*" class="d-none">
                                            </div>
                                            <div class="sd-m-action-grid">
                                                <button type="button" class="sd-m-act-btn" onclick="$('#primary_logo_image_m').click()"><i class="fa fa-upload"></i> Upload</button>
                                                <button type="button" class="sd-m-act-btn" onclick="$('#primary_logo_image_m').click()"><i class="fa fa-retweet"></i> Replace</button>
                                                <button type="button" class="sd-m-act-btn" onclick="$('#primary_logo_image_m').attr('capture','environment').click()"><i class="fa fa-camera"></i> Camera</button>
                                                <button type="button" class="sd-m-act-btn sd-m-act-danger" onclick="imagRemoveMobile('primary_logo_image_m')"><i class="fa fa-trash"></i> Remove</button>
                                            </div>

                                            <div class="sd-m-sub-label mt-3">Secondary Logo</div>
                                            <div class="sd-m-img-preview" id="sd-m-secondary_logo_image-wrap">
                                                <label for="secondary_logo_image_m" class="sd-m-upload-area" id="secondary_logo_image_m_upload_area">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    <span>Tap to upload</span>
                                                </label>
                                                <label for="secondary_logo_image_m" class="sd-m-img-view" id="secondary_logo_image_m_display_area" style="display:none;">
                                                    <img id="secondary_logo_image_m_uploaded" src="{{ asset('public/images/default.png') }}" alt="Secondary Logo" style="max-height:6rem;max-width:100%;border-radius:6px;">
                                                </label>
                                                <input type="file" id="secondary_logo_image_m" name="secondary_logo_image" onchange="imagDisplayMobile(this,'secondary_logo_image_m')" accept="image/*" class="d-none">
                                            </div>
                                            <div class="sd-m-action-grid">
                                                <button type="button" class="sd-m-act-btn" onclick="$('#secondary_logo_image_m').click()"><i class="fa fa-upload"></i> Upload</button>
                                                <button type="button" class="sd-m-act-btn" onclick="$('#secondary_logo_image_m').click()"><i class="fa fa-retweet"></i> Replace</button>
                                                <button type="button" class="sd-m-act-btn" onclick="$('#secondary_logo_image_m').attr('capture','environment').click()"><i class="fa fa-camera"></i> Camera</button>
                                                <button type="button" class="sd-m-act-btn sd-m-act-danger" onclick="imagRemoveMobile('secondary_logo_image_m')"><i class="fa fa-trash"></i> Remove</button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Header Banner accordion --}}
                                    <div class="sd-m-accordion">
                                        <div class="sd-m-acc-header" data-target="sd-m-header">
                                            <span>Header Banner</span>
                                            <i class="fa fa-chevron-right sd-m-chevron"></i>
                                        </div>
                                        <div class="sd-m-acc-body" id="sd-m-header" style="display:none;">
                                            <div class="sd-m-sub-label">Banner Image <small style="color:#aaa;font-size:.75rem;">(1280 × 420 px)</small></div>
                                            <div class="sd-m-img-preview" id="sd-m-banner_image-wrap">
                                                <label for="banner_image_m" class="sd-m-upload-area" id="banner_image_m_upload_area">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    <span>Tap to upload</span>
                                                </label>
                                                <label for="banner_image_m" class="sd-m-img-view" id="banner_image_m_display_area" style="display:none;">
                                                    <img id="banner_image_m_uploaded" src="{{ asset('public/images/default.png') }}" alt="Banner" style="width:100%;border-radius:6px;">
                                                </label>
                                                <input type="file" id="banner_image_m" name="banner_image" onchange="imagDisplayMobile(this,'banner_image_m')" accept="image/*" class="d-none">
                                            </div>
                                            <div class="sd-m-action-grid">
                                                <button type="button" class="sd-m-act-btn" onclick="$('#banner_image_m').click()"><i class="fa fa-upload"></i> Upload</button>
                                                <button type="button" class="sd-m-act-btn" onclick="$('#banner_image_m').click()"><i class="fa fa-retweet"></i> Replace</button>
                                                <button type="button" class="sd-m-act-btn" onclick="$('#banner_image_m').attr('capture','environment').click()"><i class="fa fa-camera"></i> Camera</button>
                                                <button type="button" class="sd-m-act-btn sd-m-act-danger" onclick="imagRemoveMobile('banner_image_m')"><i class="fa fa-trash"></i> Remove</button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Welcome Banner accordion --}}
                                    <div class="sd-m-accordion">
                                        <div class="sd-m-acc-header" data-target="sd-m-welcome">
                                            <span>Welcome Banner</span>
                                            <i class="fa fa-chevron-right sd-m-chevron"></i>
                                        </div>
                                        <div class="sd-m-acc-body" id="sd-m-welcome" style="display:none;">
                                            <div class="sd-m-sub-label">Welcome Banner Image <small style="color:#aaa;font-size:.75rem;">(1280 × 158 px)</small></div>
                                            <div class="sd-m-img-preview" id="sd-m-fundraising_image-wrap">
                                                <label for="fundraising_image_m" class="sd-m-upload-area" id="fundraising_image_m_upload_area">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    <span>Tap to upload</span>
                                                </label>
                                                <label for="fundraising_image_m" class="sd-m-img-view" id="fundraising_image_m_display_area" style="display:none;">
                                                    <img id="fundraising_image_m_uploaded" src="{{ asset('public/images/default.png') }}" alt="Welcome Banner" style="width:100%;border-radius:6px;">
                                                </label>
                                                <input type="file" id="fundraising_image_m" name="fundraising_image" onchange="imagDisplayMobile(this,'fundraising_image_m')" accept="image/*" class="d-none">
                                            </div>
                                            <div class="sd-m-action-grid">
                                                <button type="button" class="sd-m-act-btn" onclick="$('#fundraising_image_m').click()"><i class="fa fa-upload"></i> Upload</button>
                                                <button type="button" class="sd-m-act-btn" onclick="$('#fundraising_image_m').click()"><i class="fa fa-retweet"></i> Replace</button>
                                                <button type="button" class="sd-m-act-btn" onclick="$('#fundraising_image_m').attr('capture','environment').click()"><i class="fa fa-camera"></i> Camera</button>
                                                <button type="button" class="sd-m-act-btn sd-m-act-danger" onclick="imagRemoveMobile('fundraising_image_m')"><i class="fa fa-trash"></i> Remove</button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Save button --}}
                                    <div class="sd-m-save-wrap">
                                        <button type="button" class="sd-m-save-btn update_theme_settings" data-form="store_design_data_mobile">
                                            <i class="fa fa-save"></i> Save Design
                                        </button>
                                    </div>

                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>
<!-- Modal Structure -->
<div class="modal fade" id="product_category_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem; background-color: #f1f1f1;">
                <h5 class="modal-title" id="modalTitle" style="font-size: 1.3rem; color: grey;">Add Product Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="product_category_form">
                <input type="hidden" id="category_id" name="category_id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-control info-form-input store-select2" id="store_edit_product_category" name="store_edit_product_category" required>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">Category Name</label>
                            <input type="text" class="form-control info-form-input" name="category_name" id="category_name" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_category_btn" class="btn btn-success" style="padding: .2rem .8rem;border-radius: 0rem;">Save</button>
                    <button type="button" id="delete_category_btn" class="btn btn-danger" style="padding: .2rem .8rem;border-radius: 0rem;">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: .2rem .8rem;border-radius: 0rem;">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_product_image" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem; background-color: #f1f1f1;">
                <h5 class="modal-title" style="font-size: 1.3rem; color: grey;">Edit Product Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('store.edit_product_image')}}" id="edit_product_image_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="editing_product_image_id" id="editing_product_image_id" value="">
                        <div class="col-md-12 mt-2">
                            <label for="product_image_edit" style="cursor: pointer;">
                                <img id="product_image_preview" src="" alt="Product Image" style="width: 100%; height: auto;">
                            </label>
                            <input type="file" id="product_image_edit" name="product_image_edit" accept="image/*" style="display: none;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="background-color: #8cef94; color: white;display:none" class="btn btn-secondary edit_product_image">Save Image</button>
                    <button type="button" style="background-color: #8cd4ef; color: white;" class="btn btn-secondary" data-dismiss="modal">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>


@include('pages.stores.modals.coupons_modal')
@include('pages.stores.modals.custom_informations_modal')
@include('pages.stores.modals.variants_modal')
@include('pages.stores.modals.sort_category_modal')
@include('pages.stores.modals.price_addition_modal')
@include('pages.stores.modals.bulk_price_addition_modal')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- jQuery UI Datepicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui/1.12.1/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<!-- Timepicker Addon -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">



<script>
    $(document).on('click', '#mobile_save_store_btn', function () {
    $('#submit_store_main_data').click();
});
$(document).on('click', '#mobile_cancel_store_btn', function () {
    $('.tab-pane#summary [type="reset"]').click();
});
$(document).on('click', '#mobile_delete_store_btn', function () {
    $('#delete_form').click();
});
    var can_save = true;

    $('#store_product_update').on('change', 'select, input, checkbox, radio', function () {
        can_save = false;
    });

    $("#submit_store_main_data").on("click", function (e) {
        const form = document.querySelector("#store_update"); // Replace with actual form ID

        if (form.checkValidity()) {
            $(".se-pre-con").fadeIn("slow");
        } else {
            e.preventDefault();
            form.reportValidity(); // Show built-in browser error messages
        }
    });

    $(document).ready(function() {

        $('.select2-multiple').select2();

        var quill = createQuillInstance('store_product_style_editor');

        quill.on('text-change', function() {
            var quillContent = quill.root.innerHTML;
            $('#store_product_style').val(quillContent);
        });

        function toggleSections() {
            $('.section_1, .section_2, .section_3, .section_4').hide();

            var selected = $('#tax_category').val();

            if(selected) {
                selected.forEach(function(id) {
                    $('.section_' + id).show();
                });
            }
        }

        toggleSections();

        $('#tax_category').on('change', function() {
            toggleSections();
        });
    });
    $(document).ready(function() {
        $('.btn.btn-primary-color').on('click', function() {
            $('.color-picker-primary').click();
        });

        $('.btn.btn-secondary-color').on('click', function() {
            $('.color-picker-secondary').click();
        });
        $('.btn.btn-header-color').on('click', function() {
            $('.color-picker-header').click();
        });
        $('.btn.btn-footer-color').on('click', function() {
            $('.color-picker-footer').click();
        });
        $('.btn.btn-buttons-color').on('click', function() {
            $('.color-picker-buttons').click();
        });
        $('.btn.btn-fundraising-color').on('click', function() {
            $('.color-picker-fundraising').click();
        });

        $('.color-picker-primary').on('input', function() {
            $('.btn.btn-primary-color').css('background-color', $(this).val());
        });

        $('.color-picker-secondary').on('input', function() {
            $('.btn.btn-secondary-color').css('background-color', $(this).val());
        });
        $('.color-picker-header').on('input', function() {
            $('.btn.btn-header-color').css('background-color', $(this).val());
        });
        $('.color-picker-footer').on('input', function() {
            $('.btn.btn-footer-color').css('background-color', $(this).val());
        });
        $('.color-picker-buttons').on('input', function() {
            $('.btn.btn-buttons-color').css('background-color', $(this).val());
        });
        $('.color-picker-fundraising').on('input', function() {
            $('.btn.btn-fundraising-color').css('background-color', $(this).val());
        });
    });

    $(document).on('click', '.icon-for-collapse', function() {
        var $icon = $(this);
        var $contentDiv = $icon.closest('.row').find('.header-content-div');

        $icon.toggleClass('fa-chevron-down fa-chevron-right');

        $contentDiv.slideToggle();
    });
    $(document).on('click', '.icon-for-collapse-roster', function() {
        var $icon = $(this).find('i');
        var $contentDiv = $(this).closest('.collapse-class').find('.header-content-div-roster');

        $icon.toggleClass('fa-chevron-down fa-chevron-right');
        $contentDiv.slideToggle();
    });
    $(document).on('click', '.icon-for-change-responsive', function() {
        var deviceType = $(this).data('device');

        if (deviceType == 'desktop') {
            $('#responsive-iframe-content').css('width', '100%');
        } else if (deviceType == 'tablet') {
            $('#responsive-iframe-content').css('width', '55%');
        } else if (deviceType == 'mobile') {
            $('#responsive-iframe-content').css('width', '35%');
        }
    });

    /* Mobile device preview segmented control */
    $(document).on('click', '.icon-for-change-responsive-mob', function() {
        $('.icon-for-change-responsive-mob').removeClass('active');
        $(this).addClass('active');
     var deviceType = $(this).data('device');
    if (deviceType == 'desktop') {
        $('#sd-m-responsive-iframe-content').css('width', '100%');
    } else if (deviceType == 'tablet') {
        $('#sd-m-responsive-iframe-content').css('width', '70%');
    } else if (deviceType == 'mobile') {
        $('#sd-m-responsive-iframe-content').css('width', '45%');
    }
});

    /* Mobile accordion toggle */
    $(document).on('click', '.sd-m-acc-header', function() {
        var targetId = $(this).data('target');
        var $body = $('#' + targetId);
        var $icon = $(this).find('.sd-m-chevron');
        $body.slideToggle(180, function() {
            $icon.toggleClass('fa-chevron-right fa-chevron-down');
        });
    });

    /* Mobile theme card toggle */
    $(document).on('change', '.sd-m-theme-radio', function() {
        var $cards = $('.sd-m-theme-card');
        $cards.find('.sd-m-theme-check').hide();
        $(this).closest('.sd-m-theme-card').find('.sd-m-theme-check').show();
    });

    /* Mobile color picker live update — 'input' fires on Android/Chrome/desktop,
       'change' fires on iOS Safari (when the picker is dismissed). Both are needed. */
    $(document).on('input change', '.color-picker-secondary-m', function() {
        var v = $(this).val();
        $('.btn-secondary-color-m').css('background', v);
        $(this).closest('.sd-m-color-row').find('.sd-m-color-hex').text(v.toUpperCase());
    });
    $(document).on('input change', '.color-picker-primary-m', function() {
        var v = $(this).val();
        $('.btn-primary-color-m').css('background', v);
        $(this).closest('.sd-m-color-row').find('.sd-m-color-hex').text(v.toUpperCase());
    });
    $(document).on('input change', '.color-picker-header-m', function() {
        var v = $(this).val();
        $('.btn-header-color-m').css('background', v);
        $(this).closest('.sd-m-color-row').find('.sd-m-color-hex').text(v.toUpperCase());
    });
    $(document).on('input change', '.color-picker-footer-m', function() {
        var v = $(this).val();
        $('.btn-footer-color-m').css('background', v);
        $(this).closest('.sd-m-color-row').find('.sd-m-color-hex').text(v.toUpperCase());
    });
    $(document).on('input change', '.color-picker-buttons-m', function() {
        var v = $(this).val();
        $('.btn-buttons-color-m').css('background', v);
        $(this).closest('.sd-m-color-row').find('.sd-m-color-hex').text(v.toUpperCase());
    });

    $(document).ready(function() {
        $('#organization_id').on('change', function() {
            $(".se-pre-con").fadeIn('slow');
            handleOrganizationChange();
            $(".se-pre-con").fadeOut('slow');
        });
        $('#contact_coach_id').on('change', function() {
            $(".se-pre-con").fadeIn('slow');
            var selectedOption = $(this).find('option:selected');
            if (selectedOption.val() == "") {
                $('#coach_name').val('');
                $('#coach_email').val('');
            } else {
                var coachName = selectedOption.data('user-name');
                var coachEmail = selectedOption.data('email');

                $('#coach_name').val(coachName);
                $('#coach_email').val(coachEmail);
                $('#coach_name').attr('readonly', true);
                $('#coach_email').attr('readonly', true);
            }
            $(".se-pre-con").fadeOut('slow');
        });
    });

    function handleAddContactClick() {
        $('#coach_name').val('');
        $('#coach_email').val('');
        $('#coach_name').attr('readonly', false);
        $('#coach_email').attr('readonly', false);
    }

    function handleOrganizationChange() {
        var orgId = $('#organization_id').val();
        var contacts = JSON.parse($('#organization_id').find('option:selected').attr('data-contacts'));
        var salesTax = $('#organization_id').find('option:selected').data('sales-tax');

        var salesRep = $('#organization_id').find('option:selected').data('sales-rep');
        if (salesRep) {
            $('#sales_person').val(salesRep).trigger('change');
            $('#sales_assistant').val(salesRep).trigger('change');
        } else {
            $('#sales_person').val('').trigger('change');
            $('#sales_assistant').val('').trigger('change');
        }

        $('#sales_tax').val(salesTax ? salesTax : 0);

        $('#contact_coach_id').empty();
        $('#contact_coach_id').attr('readonly', false);

        var store = @json($store);

        var allContacts = @json($contacts);

        $('#contact_coach_id').append(`<option value="">Select a coach</option>`);

        if (contacts.length > 0) {
            contacts.forEach(function(contact) {

                if (contact.contacts.length > 0) {
                    var filteredContact = contact.contacts[0];
                    var selected = (store.contact_coach_id == filteredContact.id) ? 'selected' : '';

                    var contactOptionsHtml = `<option data-user-name="${filteredContact.first_name ? filteredContact.first_name : ''} ${filteredContact.last_name ? filteredContact.last_name : ''}" data-email="${filteredContact.email ? filteredContact.email : ''}" value="${filteredContact.id}" ${selected}>
                                                    ${filteredContact.first_name ? filteredContact.first_name : ''} ${filteredContact.last_name ? filteredContact.last_name : ''}
                                                </option>`;

                    $('#contact_coach_id').append(contactOptionsHtml);
                }

            });
        }else{
            $('#contact_coach_id').append(`<option value="" selected>No contact person added</option>`);
        }

    }

    $('.roster-elements').on('change', function() {
        const isUnchecked = !this.checked;
        const $container = $(this).closest('.container');

        $container.find('.header-content-div-roster').find('input, select').not(this).prop('disabled', isUnchecked);
    });

    function imageDisplay(input, imageId) {
        const uploadArea = $(`#${imageId}_upload_area`);
        const displayArea = $(`#${imageId}_display_area`);
        const imgElement = $(`#${imageId}_uploaded`);
        const closeButton = $(`#${imageId}_close_button`);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.src = e.target.result;

                img.onload = function () {
                    const width = img.width;
                    const height = img.height;

                    if (imageId === 'fundraising_image') {
                        if (width !== 1280 || height !== 158) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Invalid Image Size',
                                text: 'Welcome banner image must be exactly 1280 × 158 pixels.',
                            });
                            input.value = '';
                            return;
                        }
                    }
                    if (imageId === 'banner_image') {
                        if (width !== 1280 || height !== 420) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Invalid Image Size',
                                text: 'Banner image must be exactly 1280 × 420 pixels.',
                            });
                            input.value = '';
                            return;
                        }
                    }

                    imgElement.attr('src', e.target.result);
                    uploadArea.hide();
                    displayArea.show();
                    closeButton.show();
                };
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImagePreview(imageId) {
        const uploadArea = $(`#${imageId}_upload_area`);
        const displayArea = $(`#${imageId}_display_area`);
        const imgElement = $(`#${imageId}_uploaded`);
        const fileInput = $(`#${imageId}`);

        imgElement.attr('src', '{{ asset("public/images/default.png") }}');
        uploadArea.show();
        displayArea.hide();
        fileInput.val('');
    }

    /* Mobile-only image helpers (use _m suffix IDs) */
    function imagDisplayMobile(input, imageId) {
        var uploadArea = $('#' + imageId + '_upload_area');
        var displayArea = $('#' + imageId + '_display_area');
        var imgEl = $('#' + imageId + '_uploaded');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = new Image();
                img.src = e.target.result;
                img.onload = function() {
                    var w = img.width, h = img.height;
                    var baseId = imageId.replace('_m', '');
                    if (baseId === 'fundraising_image' && (w !== 1280 || h !== 158)) {
                        Swal.fire({ icon:'warning', title:'Invalid Image Size', text:'Welcome banner must be 1280 \u00d7 158 px.' });
                        input.value = ''; return;
                    }
                    if (baseId === 'banner_image' && (w !== 1280 || h !== 420)) {
                        Swal.fire({ icon:'warning', title:'Invalid Image Size', text:'Banner must be 1280 \u00d7 420 px.' });
                        input.value = ''; return;
                    }
                    imgEl.attr('src', e.target.result);
                    uploadArea.hide();
                    displayArea.show();
                    /* remove capture attr after use */
                    $('#' + imageId).removeAttr('capture');
                };
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function imagRemoveMobile(imageId) {
        $('#' + imageId + '_upload_area').show();
        $('#' + imageId + '_display_area').hide();
        $('#' + imageId + '_uploaded').attr('src', '{{ asset("public/images/default.png") }}');
        $('#' + imageId).val('');
    }


    function createQuillInstance(editorContainer) {
        var quill = new Quill('#' + editorContainer, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['clean']
                ]
            }
        });

        return quill;
    }
</script>

{{-- tab bar scripts --}}

<script>
    $(document).ready(function () {
        let sessionKey = 'team_store_main_tabbar_active_tab';
        let defaultTab = '#summary';

        function setActiveTab() {
            let activeTab = sessionStorage.getItem(sessionKey) || defaultTab;

            if ($(`a[href="${activeTab}"]`).length) {
                $('.store_edit_main_tabbar .nav-link').removeClass('active');
                $('#myTabContent .tab-pane').removeClass('show active');

                $(`a[href="${activeTab}"]`).addClass('active');
                $(activeTab).addClass('show active');
            }
        }

        $('.store_edit_main_tabbar .nav-link').on('click', function () {
            let tabId = $(this).attr('href');
            sessionStorage.setItem(sessionKey, tabId);
        });

        setActiveTab();
    });


    function showTab(tabId) {
        document.querySelectorAll('.tab-pane-new').forEach(function (tab) {
            tab.classList.remove('show', 'active');
            tab.classList.add('hidden-tab');
        });

        document.querySelectorAll('.nav-link-new').forEach(function (tab) {
            tab.classList.remove('show', 'active');
        });

        var activeTab = document.getElementById(tabId);
        activeTab.classList.remove('hidden-tab');
        activeTab.classList.add('show', 'active');
        document.getElementById(tabId + '-new').classList.add('show', 'active');
    }

    $('.store-select2-dropdown').select2();
    $('.store-select2').select2();
    $(".store-select2-add").select2({
        tags: true,
        tokenSeparators: [',', ' '],
        createTag: function(params) {
            var typedValue = $.trim(params.term);
            if (typedValue === '' || isNaN(typedValue)) {
                return null;
            }
            return {
                id: typedValue,
                text: typedValue,
                newTag: true
            };
        }
    });
    $('.datepicker').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm',
        beforeShow: function(input, inst) {
            if ($(window).width() < 768) {
                if ($('.ui-datepicker-backdrop').length === 0) {
                    $('body').append('<div class="ui-datepicker-backdrop"></div>');
                }
                $('.ui-datepicker-backdrop').fadeIn(200);
                $('body').addClass('datepicker-open-mobile');

                $(input).css('visibility', 'hidden');
            }
        },
        onClose: function(dateText, inst) {
            $('.ui-datepicker-backdrop').fadeOut(200);
            $('body').removeClass('datepicker-open-mobile');

            // $('body').removeClass('datepicker-open-mobile');
            $(inst.input).css('visibility', 'visible');

        }
    });


</script>

{{-- Products --}}

<script>
    $(document).ready(function () {
        $(".products_collapse_button").click(function () {
            $("#all_products_div").toggle();

            $("#store_products_info, #store_products_div").toggleClass("col-md-4 col-md-6");

            $(this).find("i").toggleClass("fa-align-left fa-align-right");
        });

        $(document).on("change", "#number_type", function () {
            var selectedValue = $(this).val();

            if (selectedValue == "0-99") {
                $("#min_number").val(0).attr("min", 0).attr("max", 99);
                $("#max_number").val(99).attr("min", 0).attr("max", 99);

                $("#min_number_count").val(1).attr("min", 1).attr("max", 2).prop('disabled', false);
                $("#max_number_count").val(2).attr("min", 1).attr("max", 2).prop('disabled', false);
                $("#number-count-div").hide();

            } else if (selectedValue == "3-digits") {
                $("#min_number").val(0).attr("min", 0).attr("max", 999);
                $("#max_number").val(999).attr("min", 0).attr("max", 999);

                $("#min_number_count").val(1).attr("min", 1).attr("max", 3).prop('disabled', false);
                $("#max_number_count").val(3).attr("min", 1).attr("max", 3).prop('disabled', false);
                $("#number-count-div").hide();

            } else if (selectedValue == "custom") {
                $("#min_number").val(0);
                $("#max_number").val(9999);

                $("#min_number_count").val(1).attr("min", 1).attr("max", 10).prop('disabled', false);
                $("#max_number_count").val(5).attr("min", 1).attr("max", 10).prop('disabled', false);
                $("#number-count-div").show();
            }
        });
    });

    $(document).on('click', '.make_bundle', function() {
        var categoryId = $(this).data('category-id');

        $(".se-pre-con").fadeIn('slow');

        $.ajax({
            url: "{{ route('store.make_bundle') }}",
            method: 'POST',
            data: {
                category_id: categoryId,
                store_id: $('#store_id').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: true
                    });
                    loadProducts();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });
            }
        });

        $(".se-pre-con").fadeOut('slow');
    });

    $(document).on('click', '.remove_bundle', function() {
        var categoryId = $(this).data('category-id');

        $(".se-pre-con").fadeIn('slow');

        $.ajax({
            url: "{{ route('store.remove_bundle') }}",
            method: 'POST',
            data: {
                category_id: categoryId,
                store_id: $('#store_id').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: true
                    });
                    loadProducts();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });
            }
        });

        $(".se-pre-con").fadeOut('slow');
    });
    $(document).on('click', '.required_bundle', function() {
        var categoryId = $(this).data('category-id');

        $(".se-pre-con").fadeIn('slow');

        $.ajax({
            url: "{{ route('store.not_required_bundle') }}",
            method: 'POST',
            data: {
                category_id: categoryId,
                store_id: $('#store_id').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: true
                    });
                    loadProducts();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });
            }
        });

        $(".se-pre-con").fadeOut('slow');
    });
    $(document).on('click', '.not_required_bundle', function() {
        var categoryId = $(this).data('category-id');

        $(".se-pre-con").fadeIn('slow');

        $.ajax({
            url: "{{ route('store.required_bundle') }}",
            method: 'POST',
            data: {
                category_id: categoryId,
                store_id: $('#store_id').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: true
                    });
                    loadProducts();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });
            }
        });

        $(".se-pre-con").fadeOut('slow');
    });

    var isFirstChange = true;
    function UpdateCommonCategoryArray(){

        $.ajax({
            url: '{{ route("store.get_product_categories") }}',
            method: 'GET',
            data: {
                'store_id': $('#store_id').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {

                product_category_common = response.product_categories;
            },
            error: function(xhr) {
                console.error('Failed to fetch product categories:', xhr.responseText);
            }
        });
    }
    function loadProducts() {
        $.ajax({
            url: '{{ route("store.get_store_products") }}',
            method: 'GET',
            data: {
                store_id: $('#store_id').val()
            },
            success: function(response) {
                appendProducts(response);

            },
            error: function(xhr) {
                console.error('Failed to fetch products:', xhr.responseText);
            }
        });
    }
    function loadSubProducts(){
        $(".se-pre-con").fadeIn('slow');
        $.ajax({
                url: '{{ route("store.get_store_sub_products") }}',
                method: 'GET',
                data: {
                    store_id: $('#store_id').val(),
                },
                success: function(response) {
                    appendSubProducts(response);
                },
                error: function(xhr) {
                    console.error('Failed to fetch products:', xhr.responseText);
                }
        });
    }
    function searchProducts(text){
        $(".se-pre-con").fadeIn('slow');
        $.ajax({
                url: '{{ route("store.get_store_search_products") }}',
                method: 'GET',
                data: {
                    store_id: $('#store_id').val(),
                    text: text,
                },
                success: function(response) {
                    appendSubProducts(response);
                },
                error: function(xhr) {
                    console.error('Failed to fetch products:', xhr.responseText);
                }
        });
    }
    function append_embellishment_options(product_id, embellishment_id){

        if (product_id) {
            $.ajax({
                url: '{{ route("store.get_product_embellishment_options") }}',
                method: 'GET',
                data: {
                    product_id: product_id,
                    token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.length > 0) {
                        $('#store_product_embellishment').empty();
                        $('#store_product_embellishment').append('<option value="">Select Embellishment</option>');
                        response.forEach(function(option) {
                            var selected = (option.id == embellishment_id) ? 'selected' : '';
                            $('#store_product_embellishment').append('<option value="' + option.id + '" ' + selected + '>' + option.embellishment_name + '</option>');
                        });

                    }else{
                        $('#store_product_embellishment').empty();
                        $('#store_product_embellishment').append('<option value="">No Embellishment</option>');
                    }
                },
                error: function(xhr) {
                    console.error('Failed to fetch products:', xhr.responseText);
                }
            });
        }
    }
    function appendSubProducts(response){
        $('#sub_product_list').empty();
        $('#store_product_count').text(response.products.length);

            if(response.products.length > 0){

                let productContent = `
                    <div class="col-md-12 mb-4">
                        <table class="sortable-table" id="all_sub_product_list" style="width: 100%;">

                            ${response.products.map(product_element => {

                                var imageURL = '{{ asset('assets/img/products/product default image.jpg') }}';

                                if (product_element.mockup_img_1) {
                                    imageURL = `{{ asset('assets') }}/${product_element.mockup_img_1}`;
                                }else{
                                    if (product_element.product_details.mockup_img_1) {
                                        imageURL = `{{ asset('assets') }}/${product_element.product_details.mockup_img_1}`;
                                    }
                                }

                               return `
                                    <tr class="product-list-tr draggable-image selected_product_tr_${product_element.id}" value="${product_element.id}" data-is_saved="${0}">
                                        <td class="catalog-product-checkbox-col text-center" style="width: 2.5rem; vertical-align: middle;">
                                            <input type="checkbox" class="catalog-product-checkbox" value="${product_element.id}" style="width: 1.2rem; height: 1.2rem;">
                                        </td>
                                        <td style="width: 5rem;">
                                            <img src="${imageURL}" alt="Product Image" class="img-thumbnail" onerror="this.onerror=null; this.src='{{ asset('assets/img/products/product default image.jpg') }}';">
                                        </td>
                                        <td>${product_element.product_name}</td>
                                        <td style="width: 5rem;">${product_element.sub_product_no}</td>
                                        <td>$${product_element.default_price}</td>
                                    </tr>
                                `;
                            }).join('')}
                        </table>
                    </div>`;

                $('#sub_product_list').append(productContent);
            }
            draggingInitializing();

        $(".se-pre-con").fadeOut('slow');
    }
    function appendProducts(response){
        UpdateCommonCategoryArray();
        $('#store_product_list').empty();

        var bulkActionContent = `
                                <div class="col-md-12 mb-2 mt-3 bulk_action_div text-left" style="display:none">
                                    <div class="d-inline-flex flex-wrap justify-content-center gap-2">
                                        <i class="fa fa-trash m-1 bulk_delete_action"
                                        title="Delete Selected"
                                        aria-hidden="true"
                                        style="cursor:pointer; background-color:#f19494; padding:0.5rem 0.8rem; color:#000; border-radius:0.75rem; min-width:40px; text-align:center;">
                                        </i>

                                        <i class="fa fa-clone m-1 bulk_clone_action"
                                        title="Clone Selected"
                                        aria-hidden="true"
                                        style="cursor:pointer; background-color:#69b169; padding:0.5rem 0.8rem; color:#000; border-radius:0.75rem; min-width:40px; text-align:center;">
                                        </i>

                                        <i class="fa fa-list m-1 bulk_change_category_action"
                                        title="Change Category"
                                        aria-hidden="true"
                                        style="cursor:pointer; background-color:#c5cbc5; padding:0.5rem 0.8rem; color:#000; border-radius:0.75rem; min-width:40px; text-align:center;">
                                        </i>

                                        <i class="fa fa-usd m-1 add_bulk_fundraising"
                                        title="Add Fundraising"
                                        aria-hidden="true"
                                        style="cursor:pointer; background-color:#c5cbc5; padding:0.5rem 0.8rem; color:#000; border-radius:0.75rem; min-width:40px; text-align:center;">
                                        </i>

                                        <i class="fa fa-check-circle m-1 bulk_active_action"
                                        title="Set as Available"
                                        aria-hidden="true"
                                        style="cursor:pointer; background-color:#8cd98c; padding:0.5rem 0.8rem; color:#000; border-radius:0.75rem; min-width:40px; text-align:center;">
                                        </i>

                                        <i class="fa fa-ban m-1 bulk_inactive_action"
                                        title="Set as Unavailable"
                                        aria-hidden="true"
                                        style="cursor:pointer; background-color:#f2c26b; padding:0.5rem 0.8rem; color:#000; border-radius:0.75rem; min-width:40px; text-align:center;">
                                        </i>
                                    </div>
                                </div>`;



        $('#store_product_list').append(bulkActionContent);

        let selectAllCheckbox = `<div class="col-md-12 d-flex align-items-center mb-1 mt-2">
                                    <input type="checkbox" class="select-all-category-products" style="margin-right: 10px;">
                                    <label style="margin:0">Select All Products</label>
                                </div>
                                `;
        $('#store_product_list').append(selectAllCheckbox);

        $('#store_saved_product_count').text(response.srore_products.length);

        var all_category_product_order = response.all_category_product_order;

        // console.log(all_category_product_order);

        product_category_common.forEach(category_element => {
            let categoryProducts = response.srore_products.filter(product_element =>
                product_element.category_id == category_element.id
            );

            // console.log('Category ID:', category_element.id, 'Products:', categoryProducts);

            if (all_category_product_order) {
                // ✅ Find saved order for this category
                let savedCategoryOrder = all_category_product_order.find(order =>
                    order.category_id == category_element.id
                );

                // console.log('Saved Order for Category ID', category_element.id, ':', savedCategoryOrder);

                if (savedCategoryOrder && Array.isArray(savedCategoryOrder.products)) {
                    // Convert array of {product_id, position} into a map for quick lookup
                    let positionMap = {};
                    savedCategoryOrder.products.forEach(p => {
                        positionMap[p.product_id] = parseInt(p.position);
                    });

                    // ✅ Sort categoryProducts based on saved order
                    categoryProducts.sort((a, b) => {
                        let posA = positionMap[a.id] ?? 9999; // if not found, push to end
                        let posB = positionMap[b.id] ?? 9999;
                        return posA - posB;
                    });
                }
            }


            var productBundle = response.product_bundles.find(bundleElement => bundleElement.category_id == category_element.id);

            var bundleContent = ``;
            var requiredContent = ``;

            if (productBundle) {
                bundleContent = `<span class="badge badge-success remove_bundle" style="cursor:pointer" title="Remove Bundle" data-category-id="${category_element.id}">Bundle</span>`;
                requiredContent = productBundle.is_required == 1 ?
                                            `<span class="badge badge-danger required_bundle ml-auto mr-1" style="cursor:pointer" title="Remove required" data-category-id="${category_element.id}">Required</span>`:
                                            `<span class="badge badge-danger not_required_bundle ml-auto mr-1" style="cursor:pointer" title="Make required" data-category-id="${category_element.id}">Not Required</span>`;

            }else{
                bundleContent = `<span class="badge badge-info make_bundle" style="cursor:pointer" title="Make As Bundle" data-category-id="${category_element.id}">Make as bundle</span>`;
            }

            if(categoryProducts.length > 0){
                let productContent = `
                    <div class="col-md-12 mb-4 dropping-area" value="${category_element.id}">
                        <table class="sortable-table" style="width: 100%;">
                            <tr class="sub-header-style mb-1 mt-1" style="color: grey; font-size: .8rem;">
                                <td colspan="8">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span class="d-flex align-items-center"><input type="checkbox" class="saved-category-checkbox mr-2" value="${category_element.id}">${category_element.category_name}</span>
                                        ${requiredContent}${bundleContent}
                                    </div>
                                </td>
                            </tr>
                            ${categoryProducts.map(product_element => {

                                var imageURL = '{{ asset('assets/img/products/product default image.jpg') }}';

                                if (product_element.images.length > 0) {
                                    imageURL = `{{ asset('') }}/${product_element.images[0].url}`;
                                }else{
                                    if (product_element.products.mockup_img_1) {
                                        imageURL = `{{ asset('assets') }}/${product_element.products.mockup_img_1}`;
                                    }else{
                                        if (product_element.products.product_details) {
                                            imageURL = `{{ asset('assets') }}/${product_element.products.product_details.mockup_img_1}`;
                                        }
                                    }
                                }

                                if (product_element.price_additions.length > 0) {
                                    var sumOfAdditions = 0;
                                    product_element.price_additions.forEach(element => {
                                        sumOfAdditions = sumOfAdditions + parseFloat(element.addition_amount);
                                    });

                                    var additionText  = `<br>+ $${sumOfAdditions.toFixed(2)}`;
                                }else{
                                    var additionText  = '';
                                }

                               return `
                                    <tr class="product-list-tr selected_product_tr_${product_element.id} draggable-image store-product-row-toggle" value="${product_element.id}" data-is_saved="${1}">
                                        <td style="width: 2rem; vertical-align: middle;">
                                            <input type="checkbox" class="saved-product-checkbox category-product-checkbox-${category_element.id}" value="${product_element.id}">
                                        </td>
                                        <td class="view_store_product text-left-mobile" style="width: 5rem; vertical-align: middle;">
                                            <img src="${imageURL}" alt="Product Image" class="img-thumbnail draggable-image">
                                        </td>
                                        <td class="view_store_product" style="vertical-align: middle;">
                                            <div>${product_element.product_name}</div>
                                            <div class="mobile-only-availability mt-1" style="display: none;">
                                                ${product_element.product_availability == 1 ? '<span class="badge badge-success" style="background-color: #E0F9D4; color: #55A630;">Available</span>' : '<span class="badge badge-danger" style="background-color: #FFEDEE; color: #D00000;">Unavailable</span>'}
                                            </div>
                                        </td>
                                        <td class="desktop-only-cell">${product_element.product_availability == 1 ? '<span style="color: green;background-color: #ddffdd;padding: 0.25rem;border-radius: 0.25rem;">Available</span>' : '<span style="color: red;background-color: #ffcfcf;padding: 0.25rem;border-radius: 0.25rem;">Unavailable</span>'}</td>
                                        <td class="view_store_product text-center desktop-only-cell"><span style="font-size: .86rem;">$${product_element.default_price}</span><span>${additionText}</span></td>
                                        <td class="desktop-only-cell">
                                            <i class="fa fa-trash remove_store_product" value="${product_element.id}" aria-hidden="true" style="cursor: pointer; color:#f19494"></i> <br>
                                            <i class="fa fa-clone clone_store_product" value="${product_element.id}" aria-hidden="true" style="cursor: pointer; color:#69b169"></i>
                                        </td>
                                        <td class="mobile-only-cell text-center" style="display: none; vertical-align: middle; width: 3rem;">
                                            <i class="fa fa-chevron-down toggle-chevron" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                    <tr class="store-product-mobile-row-expanded mobile-expanded-row-${product_element.id}" style="display: none;">
                                        <td colspan="5">
                                            <div class="d-flex justify-content-between align-items-center p-2" style="background-color: #fafafa; border-radius: 0.25rem;">
                                                <div style="font-size: 0.85rem; font-weight: 600; color: #000;">Price: $${product_element.default_price}${additionText}</div>
                                                <div class="d-flex gap-3 align-items-center">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm edit-product-mobile-btn" value="${product_element.id}" style="border-radius: 0.25rem; padding: 4px 8px; border-color: #b3b3b3; color: #555;"><i class="fa fa-pencil" aria-hidden="true" style="color: #3bafda;"></i></button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm clone_store_product" value="${product_element.id}" style="border-radius: 0.25rem; padding: 4px 8px; border-color: #b3b3b3; color: #555; margin-left: 8px;"><i class="fa fa-clone" aria-hidden="true" style="color: #69b169;"></i></button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm remove_store_product" value="${product_element.id}" style="border-radius: 0.25rem; padding: 4px 8px; border-color: #b3b3b3; color: #555; margin-left: 8px;"><i class="fa fa-trash" aria-hidden="true" style="color: #f19494;"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            }).join('')}
                        </table>
                    </div>`;

                $('#store_product_list').append(productContent);
            }else{
                let productContent = `
                    <div class="col-md-12 mb-4 dropping-area" value="${category_element.id}">
                        <table class="sortable-table" style="width: 100%;">
                            <tr class="sub-header-style mb-1 mt-1" style="color: grey; font-size: .8rem;">
                                <td colspan="7">${category_element.category_name}</td>
                            </tr>
                            <tr class="product-list-tr" style="height: 4rem;">
                            </tr>
                        </table>
                    </div>`;

                $('#store_product_list').append(productContent);
            }
        });
        draggingInitializing();
        $('#store_product_id').trigger('product_value_trigger');

        $(".se-pre-con").fadeOut('slow');
    }
    function draggingInitializing() {
        $(document).ready(function () {
            // On mobile, skip drag-and-drop entirely so native scroll works
            if (window.innerWidth <= 767) {
                return;
            }
            $(".sortable-table tbody").sortable({
                connectWith: ".sortable-table tbody",
                opacity: 0.8,
                cursor: "move",
                placeholder: "sortable-placeholder",
                appendTo: "body",
                containment: "document",
                zIndex: 9999,
                scroll: false,

                helper: function (e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function (index) {
                        $(this).width($originals.eq(index).outerWidth());
                    });
                    return $helper;
                },

                start: function (event, ui) {
                    console.log("Dragging started");
                    if ($(ui.item).data("is_saved") == 1) {
                        $('#delete_products_area')
                            .removeClass('hidden-important')
                            .addClass('flex-important');
                    }
                },

                stop: function (event, ui) {
                    $('#delete_products_area')
                        .removeClass('flex-important')
                        .addClass('hidden-important');
                },

                update: function (event, ui) {
                    if (this === ui.item.parent()[0]) {
                        $(".se-pre-con").fadeIn('slow');

                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        var store_id = $('#store_id').val();
                        var product_id = ui.item.attr("value");
                        var is_save = ui.item.data("is_saved");
                        var category_id = $(this).closest(".dropping-area").attr("value");

                        if (category_id === undefined || category_id === null || category_id === '') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'You cannot drop the product here. Please drop it in a valid category area.'
                            });
                            $(".se-pre-con").fadeOut('slow');
                        }else{
                            var allCategoryOrders = [];

                            $(".dropping-area").each(function () {
                                var category_id = $(this).attr("value");
                                if (category_id != 'delete') {

                                    var orderedProducts = [];

                                    $(this).find("tr.product-list-tr").each(function (index) {
                                        orderedProducts.push({
                                            product_id: $(this).attr("value"),
                                            position: index
                                        });
                                    });

                                    allCategoryOrders.push({
                                        category_id: category_id,
                                        products: orderedProducts
                                    });
                                }
                            });

                            var formData = {
                                _token: csrfToken,
                                product_id: product_id,
                                is_save: is_save,
                                category_id: category_id,
                                store_id: store_id,
                                all_category_order: allCategoryOrders
                            };

                            $.ajax({
                                url: '{{ route("store.dragging_product") }}',
                                type: 'POST',
                                data: formData,
                                success: function(response) {
                                    if ($('#search-input').val().trim() === '') {
                                        loadProducts();
                                    } else {
                                        searchProducts($('#search-input').val().trim());
                                        loadProducts();
                                    }
                                },
                                error: function(xhr) {
                                    $(".se-pre-con").fadeOut('slow');
                                    console.error('Form submission error:', xhr.responseText);
                                }
                            });
                        }
                    }
                }
            }).disableSelection();
        });
    }


    function assetUrl(path) {
        return '{{ asset('') }}' + path;
    }
    function reset_product_view() {

        var $element = $('#product_display_card');
        if (!$element.hasClass('product-area-spinner')) {
            $element.addClass('product-area-spinner');
        }
        $('#store_product_name').val('');
        $('#store_product_style').val('');
        $('#store_product_style_editor .ql-editor').html('');

        // $('#store_product_tax_category').val('');
        $('#store_product_shipping_weight').val('');
        $('#store_product_moq').val('');
        $('#store_product_maxoq').val('');
        $('#store_product_default_price').val('0.00');

        $('input[name="store_product_availability"]').prop('checked', false);

        $('#mandotary').prop('checked', false);

        $('#uploaded_product_table_tbody').empty();
        $('#store_product_sizes_content').empty();

        $('#img_upload_validations').show();
        $('.variant-manage-div').hide();
        $('#editing_product_image_id').val('');
        $('.edit_product_image').hide();
    }
    function appendSizes(size_type_id) {
        $.ajax({
            url: "{{ route('store.get_sizes') }}",
            type: "GET",
            data: {
                'store_product_id': $('#store_product_id').val(),
                'size_type_id': size_type_id,
                "_token": "{{ csrf_token() }}"
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {
                $('#store_product_sizes_content').empty();

                var temp_variable = $('#store_product_id').val();

                // console.log(response);

                response.store_sizes_all.forEach(element => {
                    if (!element.size_name.startsWith("Extra Size")) {
                        var className = response.store_sizes.map(String).includes(String(element.id)) ? 'checked' : '';

                        var content = `
                            <label class="checkbox-container ${className}">
                                <input type="checkbox" name="size[]" value="${element.id}" ${className}>
                                ${element.size_name}
                            </label>`;

                        $('#store_product_sizes_content').append(content);
                    }
                });
                response.store_sizes_all.forEach(element => {
                    if(element.size_name.startsWith("Extra Size")){
                        var className = response.store_sizes.map(String).includes(String(element.id)) ? 'checked' : '';

                        var extra = response.extra_size_details.find(es => es.size_id == element.id);
                        var extraSizeName = extra ? extra.size_name : element.size_name;

                        var content = `
                            <label class="checkbox-container ${className}">
                                <input type="checkbox" name="size[]" value="${element.id}" ${className}>
                                <input type="text" class="form-control editable-size-name" value="${extraSizeName}" style="font-size: .7rem;height: 1rem;padding: 0;text-align: center;" data-size-id="${element.id}">
                            </label>`;

                        $('#store_product_sizes_content').append(content);
                    }
                });

                $('#store_product_sizes_content input[type="checkbox"]').change(function() {
                    if ($(this).is(':checked')) {
                        $(this).closest('label').addClass('checked');
                    } else {
                        $(this).closest('label').removeClass('checked');
                    }
                });
            },
            complete: function () {
                can_save = true;
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }
    function appendProductCategories(){

        id = $('#store_product_category').val();

        isFirstChange = true;

        $.ajax({
            url: '{{ route("store.get_product_categories") }}',
            method: 'GET',
            data: {
                'store_id': $('#store_id').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                var $select = $('#store_product_category');
                var $select2 = $('#store_edit_product_category');
                $select.empty();
                $select2.empty();

                response.product_categories.forEach(function(category) {
                    var selected = (id == category.id) ? 'selected' : '';
                    $select.append('<option data-category_name="' + category.category_name + '" value="' + category.id + '" ' + selected + '>' + category.category_name + '</option>');
                });
                response.product_categories.forEach(function(category) {
                    $select2.append('<option data-category_name="' + category.category_name + '" value="' + category.id + '">' + category.category_name + '</option>');
                });
                $(".se-pre-con").fadeOut('slow');
            },
            error: function(xhr) {
                console.error('Failed to fetch product categories:', xhr.responseText);
                $(".se-pre-con").fadeOut('slow');
            }
        });

        isFirstChange = false;
    }

    function image_table_tr(element){

        var tr = `<tr style="min-height: 50px;border-bottom: 1px solid #eeeeee;border-top: none;" value="${element.id}" id="closet_tr_to_action_${element.id}">
                    <td class="drag-handle text-center" style="cursor: grab; width: 1rem;">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </td>
                    <td>
                        <img style="height: 5rem;width: auto;max-width: 5rem;" id="saved_product_images_${element.id}" src="${assetUrl(element.url)}" alt="Your Image" class="img-thumbnail">
                    </td>
                    <td>
                        <input type="text" name="product_images[${element.id}][caption]" value="${element.image_caption ? element.image_caption : ''}" style="height: 2rem;border-radius: .5rem !important;border: 1px solid #b3b3b3;">
                    </td>
                    <td>
                        <select name="product_images[${element.id}][variant]" id="store_product_variant_${element.id}" class="form-control variant-select info-form-input store-product-select2">
                        </select>
                    </td>
                    <td class="text-center">
                        <input type="hidden" id="hidden_image_src_${element.id}" value="${assetUrl(element.url)}"/>
                        <button type="button" style="cursor:pointer" onclick="edit_product_image(${element.id})" class="icon-button"><i class="fa fa-pencil" title="EDIT" aria-hidden="true"></i></button>
                        <button type="button" style="cursor:pointer" onclick="copy_product_image(${element.id})" class="icon-button" style="border-right: 1px solid #dcdcdc;border-left: 1px solid #dcdcdc;"><i class="fa fa-clone" title="COPY" aria-hidden="true"></i></button>
                        <button type="button" style="cursor:pointer" onclick="delete_product_image(${element.id})" class="icon-button"><i class="fa fa-trash" title="DELETE" aria-hidden="true"></i></button>
                    </td>
                </tr>`;

        return tr;
    }

    function edit_product_image(img_id) {
        var src = $('#hidden_image_src_'+img_id).val();
        $('#product_image_preview').attr('src', src);
        $('#editing_product_image_id').val(img_id);
        $('.edit_product_image').hide();
        $('#edit_product_image').modal('show');
    }
    function copy_product_image(img_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to copy this image?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, copy it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.value) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                var formData = new FormData();
                formData.append('product_image_id', img_id);
                formData.append('_token', csrfToken);

                $.ajax({
                    url: '{{ route("store.copy_product_image") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {

                            var tr = image_table_tr(response.data);

                            var existingRow = $('#closet_tr_to_action_'+img_id);

                            if (existingRow.length > 0) {
                                existingRow.after(tr);
                            } else {
                                $('#uploaded_product_table_tbody').append(tr);
                            }
                            $('.store-product-select2').select2();
                            appendVariants();
                        }
                    },
                    error: function(xhr) {
                        console.error('Failed to copy image:', xhr.responseText);
                    }
                });
            }
        });

    }

    function delete_product_image(img_id) {

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this image?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.value) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                var formData = new FormData();
                formData.append('product_image_id', img_id);
                formData.append('_token', csrfToken);

                $.ajax({
                    url: '{{ route("store.delete_product_image") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            var existingRow = $('#closet_tr_to_action_'+img_id);
                            if (existingRow.length > 0) {
                                existingRow.remove();
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Failed to delete image:', xhr.responseText);
                    }
                });
            }
        });

    }

    $(document).ready(function() {

        var product_category_common = [];

        // Mobile Sub-Tab Switcher
        $(document).on('click', '.mobile-sub-tab-btn', function() {
            $('.mobile-sub-tab-btn').removeClass('active');
            $(this).addClass('active');

            var target = $(this).data('target');
            if (target === '#all_products_div') {
                $('#all_products_div').show();
                $('#store_products_div').hide();
            } else {
                $('#all_products_div').hide();
                $('#store_products_div').show();
            }
        });

        // Catalog checkbox selection & bottom action bar on mobile
        $(document).on('change', '.catalog-product-checkbox', function() {
            var checkedCount = $('.catalog-product-checkbox:checked').length;
            if (checkedCount > 0) {
                $('#mobile_catalog_actions').css('display', 'flex');
            } else {
                $('#mobile_catalog_actions').hide();
            }
        });

        // Cancel catalog selection
        $(document).on('click', '#btn_cancel_catalog_select', function() {
            $('.catalog-product-checkbox').prop('checked', false);
            $('#mobile_catalog_actions').hide();
        });

        // Add selected catalog products to store
        $(document).on('click', '#btn_add_catalog_to_store', function() {
            var selectedProducts = [];
            $('.catalog-product-checkbox:checked').each(function() {
                selectedProducts.push($(this).val());
            });

            if (selectedProducts.length === 0) {
                Swal.fire("No Selection", "Please select at least one product.", "warning");
                return;
            }

            // Fetch categories to show in dropdown
            $.ajax({
                url: '{{ route("store.get_product_categories") }}',
                method: 'GET',
                data: {
                    'store_id': $('#store_id').val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (!response.product_categories || !Array.isArray(response.product_categories)) {
                        Swal.fire("Error", "Invalid category data received.", "error");
                        return;
                    }

                    let categoryOptions = response.product_categories.map(category =>
                        `<option value="${category.id}">${category.category_name}</option>`
                    ).join("");

                    Swal.fire({
                        title: "Select a Category",
                        text: "Which category would you like to add the selected products to?",
                        html: `
                            <select id="selected_add_category" class="form-control info-form-input mt-2">
                                ${categoryOptions}
                            </select>
                        `,
                        showCancelButton: true,
                        confirmButtonText: "Add to Store",
                        cancelButtonText: "Cancel",
                        preConfirm: () => {
                            return {
                                category_id: document.getElementById("selected_add_category").value
                            };
                        }
                    }).then((result) => {
                        if (result.value && result.value.category_id) {
                            $(".se-pre-con").fadeIn('slow');

                            var category_id = result.value.category_id;
                            var store_id = $('#store_id').val();
                            var csrfToken = $('meta[name="csrf-token"]').attr('content');

                            var ajaxCalls = selectedProducts.map(function(productId) {
                                return $.ajax({
                                    url: '{{ route("store.dragging_product") }}',
                                    type: 'POST',
                                    data: {
                                        _token: csrfToken,
                                        product_id: productId,
                                        is_save: 0,
                                        category_id: category_id,
                                        store_id: store_id
                                    }
                                });
                            });

                            $.when.apply($, ajaxCalls).then(function() {
                                Swal.fire("Success", "Products added to store successfully.", "success");
                                $('.catalog-product-checkbox').prop('checked', false);
                                $('#mobile_catalog_actions').hide();
                                loadProducts();
                                loadSubProducts();
                            }).fail(function() {
                                Swal.fire("Error", "Failed to add some products.", "error");
                                loadProducts();
                                loadSubProducts();
                            }).always(function() {
                                $(".se-pre-con").fadeOut('slow');
                            });
                        }
                    });
                },
                error: function () {
                    Swal.fire("Error", "Failed to load store categories.", "error");
                }
            });
        });

        // Accordion expand/collapse on mobile view
        $(document).on('click', '.store-product-row-toggle', function(e) {
            // Ignore click if user clicked on checkbox or image view
            if ($(e.target).is('input[type="checkbox"]') || $(e.target).closest('.view_store_product').length || $(e.target).is('i.remove_store_product') || $(e.target).is('i.clone_store_product')) {
                return;
            }

            var productId = $(this).attr('value');
            var expandedRow = $('.mobile-expanded-row-' + productId);

            $(this).toggleClass('expanded');
            expandedRow.slideToggle(200);

            // Toggle chevron icon
            var icon = $(this).find('.toggle-chevron');
            if (icon.hasClass('fa-chevron-down')) {
                icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else {
                icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }
        });

        // Edit button on mobile view opens the products info panel as modal
        $(document).on('click', '.edit-product-mobile-btn', function() {
            var productId = $(this).val();
            // Trigger standard open logic
            var fakeTr = $('<tr value="' + productId + '" data-is_saved="1"></tr>');
            openProduct(fakeTr);

            // Add class to activate mobile modal view
            $('#store_products_info').addClass('mobile-modal-active');
        });

        // Close mobile products info modal
        $(document).on('click', '.close-mobile-product-modal', function() {
            $('#store_products_info').removeClass('mobile-modal-active');
        });

        loadProducts();
        loadSubProducts();
        appendProductCategories();
        appendVariants();
        get_theme_details();

        $('#search-input').on('input', function() {
            let value = $(this).val().trim();
            if (value === '') {
                loadSubProducts();
            } else {
                searchProducts(value);
            }
        });

        let debounceTimer;

        $('#url').on('input', function () {
            clearTimeout(debounceTimer);
            const input = $(this);
            const storeURL = input.val().trim();

            input.removeClass('is-invalid is-valid');
            $('#url_feedback').addClass('d-none');

            if (storeURL.length === 0) return;

            debounceTimer = setTimeout(function () {
                $.ajax({
                    url: '{{ route("stores.get_all_urls") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (storeURLs) {
                        const exists = storeURLs.includes(storeURL);

                        if (exists && storeURL !== '{{ $store->direct_access_url }}') {
                            input.addClass('is-invalid');
                            $('#url_feedback').removeClass('d-none');
                        } else {
                            input.addClass('is-valid');
                        }
                    },
                    error: function (err) {
                        console.error('Error checking store names:', err);
                    }
                });
            }, 400);
        });

        // Delete Store Product with SweetAlert
        $(document).on("click", ".remove_store_product", function () {
            let productId = $(this).attr("value");

            Swal.fire({
                title: "Are you sure?",
                text: "This product will be permanently deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('store.delete_store_product') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_id: productId
                        },
                        success: function (response) {
                            Swal.fire("Deleted!", response.message, "success");
                            loadProducts();
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", xhr.responseJSON.message, "error");
                        }
                    });
                }
            });
        });

        // Clone Store Product with SweetAlert
        $(document).on("click", ".clone_store_product", function () {
            let productId = $(this).attr("value");

            Swal.fire({
                title: "Are you sure?",
                text: "This product will be cloned!",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, clone it!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('store.clone_store_product') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_id: productId
                        },
                        success: function (response) {
                            Swal.fire("Cloned!", response.message, "success");
                            loadProducts();
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", xhr.responseJSON.message, "error");
                        }
                    });
                }
            });
        });

        // Function to get all checked checkbox values
        function getCheckedProducts() {
            let selectedProducts = [];
            $(".saved-product-checkbox:checked").each(function () {
                selectedProducts.push($(this).val());
            });
            return selectedProducts;
        }

        // Bulk Delete Action
        $(document).on("click", ".bulk_delete_action", function () {
            let selectedProducts = getCheckedProducts();
            if (selectedProducts.length === 0) {
                Swal.fire("No Selection", "Please select at least one product.", "warning");
                return;
            }

            Swal.fire({
                title: "Are you sure?",
                text: "This action will delete the selected products permanently!",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.value) {
                    $(".se-pre-con").fadeIn('slow');
                    $.ajax({
                        url: "{{ route('store.bulk_delete_store_product') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_ids: selectedProducts
                        },
                        success: function (response) {
                            Swal.fire("Deleted!", "Products deleted successfully.", "success");
                            loadProducts();
                        },
                        error: function () {
                            Swal.fire("Error", "Something went wrong.", "error");
                            loadProducts();
                        }
                    });
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        // Bulk Add fundraising
        $(document).on("click", ".add_bulk_fundraising", function () {
            let selectedProducts = getCheckedProducts();
            if (selectedProducts.length === 0) {
                Swal.fire("No Selection", "Please select at least one product.", "warning");
                return;
            }

            $("#bulk_price_addition").modal("show");

            $(".save_bulk_price_addition").on("click", function (e) {
                e.preventDefault();

                $(".se-pre-con").fadeIn('slow');

                let formData = {
                    _token: $("input[name=_token]").val(),
                    price_addition_name: $("#price_bulk_addition_name").val(),
                    is_addition_value: $("input[name='is_bulk_addition_value']:checked").val(),
                    addition_value: $("#bulk_addition_value").val(),
                    hide_from_customer: $("#bulk_mandotary").is(":checked") ? 1 : 0,
                    addition_description: $("#bulk_addition_description").val(),
                    store_product_id: selectedProducts,
                };

                $.ajax({
                    url: "{{ route('store.save_bulk_price_addition') }}",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        // console.log("Success:", response);

                        if (response.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: "Price addition saved successfully!",
                                timer: 2000,
                                showConfirmButton: false
                            });

                            $("#bulk_price_addition").modal("hide");
                            price_addition_append();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: response.message
                            });
                        }
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function (xhr) {
                        console.error("Error:", xhr.responseText);

                        $(".se-pre-con").fadeOut('slow');

                        let errorMessage = "Something went wrong. Please try again.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: errorMessage
                        });
                    }
                });

            });
        });

        // Bulk Change Category Action
        $(document).on("click", ".bulk_change_category_action", function () {
            let selectedProducts = getCheckedProducts();
            if (selectedProducts.length === 0) {
                Swal.fire("No Selection", "Please select at least one product.", "warning");
                return;
            }

            $.ajax({
                url: '{{ route("store.get_product_categories") }}',
                method: 'GET',
                data: {
                    'store_id': $('#store_id').val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (!response.product_categories || !Array.isArray(response.product_categories)) {
                        Swal.fire("Error", "Invalid category data received.", "error");
                        return;
                    }

                    let categoryOptions = response.product_categories.map(category =>
                        `<option value="${category.id}">${category.category_name}</option>`
                    ).join("");

                    Swal.fire({
                        title: "Select a category",
                        html: `
                            <select id="selected_category_swal_1" class="sform-control info-form-input">
                                ${categoryOptions}
                            </select>
                        `,
                        showCancelButton: true,
                        confirmButtonText: "Change Category",
                        cancelButtonText: "Cancel",
                        preConfirm: () => {
                            return {
                                category_id: document.getElementById("selected_category_swal_1").value
                            };
                        }
                    }).then((categoryResult) => {
                        if (categoryResult.value && categoryResult.value.category_id) {
                            $(".se-pre-con").fadeIn('slow');
                            $.ajax({
                                url: "{{ route('store.bulk_change_category_action') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    product_ids: selectedProducts,
                                    category_id: categoryResult.value.category_id
                                },
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire("Updated!", response.message, "success");
                                        loadProducts();
                                    } else {
                                        Swal.fire("Error", response.message, "error");
                                    }
                                },
                                error: function () {
                                    Swal.fire("Error", "Something went wrong.", "error");
                                }
                            });
                            $(".se-pre-con").fadeOut('slow');
                        }
                    });
                },
                error: function () {
                    Swal.fire("Error", "Failed to fetch categories.", "error");
                }
            });
        });

        // Bulk Clone Action
        $(document).on("click", ".bulk_clone_action", function () {
            let selectedProducts = getCheckedProducts();
            if (selectedProducts.length === 0) {
                Swal.fire("No Selection", "Please select at least one product.", "warning");
                return;
            }

            Swal.fire({
                title: "Are you sure?",
                text: "This will create duplicates of the selected products!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Keep Category",
                cancelButtonText: "Select Category",
                showDenyButton: true,
                denyButtonColor: "#d33",
                denyButtonText: "Cancel"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('store.bulk_clone_store_product') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_ids: selectedProducts
                        },
                        success: function (response) {
                            Swal.fire("Cloned!", "Products cloned successfully.", "success");
                            loadProducts();
                        },
                        error: function () {
                            Swal.fire("Error", "Something went wrong.", "error");
                            loadProducts();
                        }
                    });
                } else if (result.dismiss == 'cancel') {
                    $.ajax({
                        url: '{{ route("store.get_product_categories") }}',
                        method: 'GET',
                        data: {
                            store_id: $('#store_id').val(),
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                        if (!response.product_categories || !Array.isArray(response.product_categories)) {
                            Swal.fire("Error", "Invalid category data received.", "error");
                            return;
                        }

                        let categoryOptions = response.product_categories.map(category =>
                            `<option value="${category.id}">${category.category_name}</option>`
                        ).join("");

                        Swal.fire({
                            title: "Select Category",
                            html: `
                                <select id="selected_category_swal_2" class="form-control info-form-input">
                                    ${categoryOptions}
                                </select>
                            `,
                            showCancelButton: true,
                            confirmButtonText: "Clone",
                            cancelButtonText: "Cancel",
                            preConfirm: () => {
                                return {
                                    category_id: document.getElementById("selected_category_swal_2").value
                                };
                            }
                        }).then((categoryResult) => {
                            if (categoryResult.value && categoryResult.value.category_id) {
                                $(".se-pre-con").fadeIn('slow');
                                $.ajax({
                                    url: "{{ route('store.bulk_clone_store_product') }}",
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        product_ids: selectedProducts,
                                        selected_category_id: categoryResult.value.category_id
                                    },
                                    success: function () {
                                        Swal.fire("Cloned!", "Products cloned successfully into the selected category.", "success");
                                        loadProducts();
                                    },
                                    error: function () {
                                        Swal.fire("Error", "Something went wrong.", "error");
                                        loadProducts();
                                    }
                                });
                                $(".se-pre-con").fadeOut('slow');
                            }
                        });
                    },
                        error: function () {
                            Swal.fire("Error", "Failed to load categories.", "error");
                        }
                    });
                }
            });
        });
        $(document).on("click", ".bulk_active_action", function () {
            let selectedProducts = getCheckedProducts();
            if (selectedProducts.length === 0) {
                Swal.fire("No Selection", "Please select at least one product.", "warning");
                return;
            }

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to make the selected products available?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, make available",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.value) {
                    $(".se-pre-con").fadeIn('slow');
                    $.ajax({
                        url: "{{ route('store.bulk_active_product') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_ids: selectedProducts,
                            active: 1
                        },
                        success: function (response) {
                            Swal.fire("Updated!", "Selected products have been set to available.", "success");
                            loadProducts();
                        },
                        error: function () {
                            Swal.fire("Error", "Something went wrong.", "error");
                            loadProducts();
                        }
                    });
                }
            });
        });
        $(document).on("click", ".bulk_inactive_action", function () {
            let selectedProducts = getCheckedProducts();
            if (selectedProducts.length === 0) {
                Swal.fire("No Selection", "Please select at least one product.", "warning");
                return;
            }

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to make the selected products unavailable?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, make unavailable",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.value) {
                    $(".se-pre-con").fadeIn('slow');
                    $.ajax({
                        url: "{{ route('store.bulk_active_product') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            product_ids: selectedProducts,
                            active: 0
                        },
                        success: function (response) {
                            Swal.fire("Updated!", "Selected products have been set to unavailable.", "success");
                            loadProducts();
                        },
                        error: function () {
                            Swal.fire("Error", "Something went wrong.", "error");
                            loadProducts();
                        }
                    });
                }
            });
        });

        $("#uploaded_product_table_tbody").sortable({
            handle: ".drag-handle",
            axis: "y",
            opacity: 0.7,
            update: function (event, ui) {

                $(".se-pre-con").fadeIn('slow');

                let sortedData = [];

                $("#uploaded_product_table_tbody tr").each(function (index) {
                    let productId = $(this).attr("value");
                    sortedData.push({ index: index + 1, product_id: productId });
                });

                $.ajax({
                    url: "{{ route('store.update_product_order') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        sorted_products: sortedData
                    },
                    success: function (response) {
                        loadProducts();
                        $(".se-pre-con").fadeOut('slow');
                    },
                    error: function () {
                        loadProducts();
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }
        });


        $(document).on('change', '#store_product_sizes_content input[type="checkbox"]', function() {
            if ($(this).is(':checked')) {
                $(this).closest('label').addClass('checked');
            } else {
                $(this).closest('label').removeClass('checked');
            }
        });

        $(document).on('blur', '.editable-size-name', function() {
            let sizeId = $(this).data('size-id');
            let size_name = $(this).val().trim();

            if (size_name !== '') {
                $('.spre-con').fadeIn('slow');
                $.ajax({
                    url: "{{ route('store.update_extra_size_name') }}",
                    type: "POST",
                    data: {
                        size_id: sizeId,
                        extra_size_name: size_name,
                        store_product_id: $('#store_product_id').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                    },
                    error: function(xhr) {
                        Swal.fire("Error", "Failed to update size name.", "error");
                    },
                    complete: function() {
                        $('.spre-con').fadeOut('slow');
                    }
                });
            }else{
                Swal.fire("Error", "Size name cannot be empty.", "error");
            }
        });

        $(document).on('click', '.select-all-sizes', function() {
            $('#store_product_sizes_content input[type="checkbox"]').prop('checked', true);
            $('#store_product_sizes_content label').addClass('checked');
        });
        $(document).on('click', '.add-new-category', function() {
            $('#modalTitle').text('Add Product Category');
            $('#category_id').val('');
            $('#category_name').val('');
            $('#store_edit_product_category').closest('.col-md-12').hide();
            $('#save_category_btn').text('Add');
            $('#delete_category_btn').hide();
            $('#product_category_modal').modal('show');
        });

        $(document).on('click', '.edit-category', function() {
            var categorySelected = $('#store_edit_product_category').val();
            var categorySelectedName = $('#store_edit_product_category option:selected').attr('data-category_name');

            $('#modalTitle').text('Edit Product Category');
            $('#category_id').val(categorySelected);
            $('#category_name').val(categorySelectedName);
            $('#store_edit_product_category').closest('.col-md-12').show();
            $('#save_category_btn').text('Save');
            $('#delete_category_btn').show();
            $('#product_category_modal').modal('show');
        });

        $('#save_category_btn').click(function() {
            $(".se-pre-con").fadeIn('slow');

            var formData = $('#product_category_form').serialize();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var storeId = $('#store_id').val();
            var productId = $('#product_id').val();
            formData += '&_token=' + encodeURIComponent(csrfToken) + '&store_id=' + encodeURIComponent(storeId) + '&product_id=' + encodeURIComponent(productId);

            $.ajax({
                url: '{{ route("store.add_new_product_category") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $(".se-pre-con").fadeOut('slow');
                    $('#product_category_modal').modal('hide');
                    UpdateCommonCategoryArray();
                    appendProductCategories();
                    loadProducts();
                },
                error: function(xhr) {
                    $(".se-pre-con").fadeOut('slow');
                    console.error('Form submission error:', xhr.responseText);
                    appendProductCategories();
                }
            });
        });

        $('#delete_category_btn').click(function() {
            Swal.fire({
                title: "Are you sure?",
                text: "This action will delete all products in this category from your store. Do you want to continue?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.value) {
                    $(".se-pre-con").fadeIn('slow');

                    var formData = $('#product_category_form').serialize();
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var storeId = $('#store_id').val();
                    var productId = $('#product_id').val();
                    var categoryId = $('#category_id').val();
                    formData += '&_token=' + encodeURIComponent(csrfToken) + '&category_id=' + encodeURIComponent(categoryId) + '&store_id=' + encodeURIComponent(storeId) + '&product_id=' + encodeURIComponent(productId);

                    $.ajax({
                        url: '{{ route("store.delete_product_category") }}',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            $(".se-pre-con").fadeOut('slow');
                            $('#product_category_modal').modal('hide');
                            UpdateCommonCategoryArray();
                            loadProducts();
                            appendProductCategories();

                            Swal.fire({
                                title: "Deleted!",
                                text: "The category and its products have been deleted.",
                                icon: "success"
                            });
                        },
                        error: function(xhr) {
                            $(".se-pre-con").fadeOut('slow');
                            console.error('Form submission error:', xhr.responseText);
                            appendProductCategories();

                            Swal.fire({
                                title: "Error",
                                text: "Something went wrong while deleting the category.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });

        function bulkActions() {
            if ($('.saved-product-checkbox:checked').length > 0) {
                $('.bulk_action_div').show();
            } else {
                $('.bulk_action_div').hide();
            }
        }

        $(document).on('change', '.saved-product-checkbox', function() {
            bulkActions();
        });

        $(document).on('change', '.saved-category-checkbox', function() {
            var categoryId = $(this).val();
            var isChecked = $(this).is(':checked');

            $(`.category-product-checkbox-${categoryId}`).prop('checked', isChecked);
            bulkActions();
        });
        $(document).on('change', '.select-all-category-products', function() {
            var categoryId = $(this).val();
            var isChecked = $(this).is(':checked');

            $(`.saved-category-checkbox`).prop('checked', isChecked);
            $(`.saved-product-checkbox`).prop('checked', isChecked);
            bulkActions();
        });

        $('#store_edit_product_category').on('change', function() {

            var categorySelected = $(this).val();
            var categorySelectedName = $('#store_edit_product_category option:selected').attr('data-category_name');

            $('#category_id').val(categorySelected);
            $('#category_name').val(categorySelectedName);


        });
        $('#store_product_category').on('change', function() {

            if(!isFirstChange){
                $(".se-pre-con").fadeIn('slow');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var category_id = $(this).val();
                var product_id = $('#product_id').val();
                var store_id = $('#store_id').val();

                var formData = '&_token=' + encodeURIComponent(csrfToken) + '&category_id=' + encodeURIComponent(category_id) + '&product_id=' + encodeURIComponent(product_id) + '&store_id=' + encodeURIComponent(store_id);

                $.ajax({
                    url: '{{ route("store.product_category_onchange") }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        UpdateCommonCategoryArray();
                        appendProductCategories();
                        loadProducts();
                    },
                    error: function(xhr) {
                        $(".se-pre-con").fadeOut('slow');
                        console.error('Form submission error:', xhr.responseText);
                    }
                });
            }
            loadProducts();


        });

        // $('select[name="number_selected_values[]"]').on('change', function() {
        //     const selectedValues = $(this).val();

        //     if (selectedValues.includes("any")) {
        //         $(this).find('option:not([value="any"])').prop('disabled', true);
        //         $(this).find('option:not([value="any"])').prop('selected', false);
        //     } else {
        //         $(this).find('option').prop('disabled', false);
        //     }

        //     $(this).trigger('change.select2');
        // });


        $('input[name="set_store_deadline"]').change(function() {
            toggleStoreDeadline();
        });

        function toggleStoreDeadline() {
            if ($('input[name="set_store_deadline"]').is(':checked')) {
                $('.set-store-deadline').show();
            } else {
                $('.set-store-deadline').hide();
            }
        }
        function get_theme_details() {
            $.ajax({
                url: '{{ route("store.get_theme_settings") }}',
                method: 'GET',
                data: {
                    'store_id': $('#store_id').val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {

                    reloadIframe();

                    if(response){
                        // Set Event Name
                        $('#event_name').val(response.event_name || '');
                        $('#fundraising_text').val(response.fundraising_text || '');

                        // Set Theme (Dark or Light)
                        if (response.theme == 1) {
                            $('#selected_theme_dark').prop('checked', true);
                        } else {
                            $('#selected_theme_light').prop('checked', true);
                        }

                        // Set Colors
                        $('.color-picker-primary').val(response.primary_color || '#ffffff'); // default color if not set
                        $('.color-picker-secondary').val(response.secondary_color || '#ffffff');
                        $('.color-picker-header').val(response.header_text_color || '#717070');
                        $('.color-picker-footer').val(response.footer_text_color || '#000000');
                        $('.color-picker-buttons').val(response.button_text_color || '#ffffff');
                        $('.color-picker-fundraising').val(response.fundraising_font_color || '#ffffff');

                        $('.btn-primary-color').css('background-color', response.primary_color || '#ffffff');
                        $('.btn-secondary-color').css('background-color', response.secondary_color || '#ffffff');
                        $('.btn-header-color').css('background-color', response.header_text_color || '#717070');
                        $('.btn-footer-color').css('background-color', response.footer_text_color || '#000000');
                        $('.btn-buttons-color').css('background-color', response.button_text_color || '#ffffff');
                        $('.btn-fundraising-color').css('background-color', response.fundraising_font_color || '#ffffff');

                        // Set Primary Logo
                        if (response.primary_logo) {
                            $('#primary_logo_image_uploaded').attr('src', '{{ asset('') }}' + response.primary_logo);
                            $('#primary_logo_image_upload_area').hide();
                            $('#primary_logo_image_display_area').show();
                            $('#primary_logo_image_close_button').show();
                            /* mobile */
                            $('#primary_logo_image_m_uploaded').attr('src', '{{ asset('') }}' + response.primary_logo);
                            $('#primary_logo_image_m_upload_area').hide();
                            $('#primary_logo_image_m_display_area').show();
                        }

                        // Set Secondary Logo
                        if (response.secondary_logo) {
                            $('#secondary_logo_image_uploaded').attr('src', '{{ asset('') }}' + response.secondary_logo);
                            $('#secondary_logo_image_upload_area').hide();
                            $('#secondary_logo_image_display_area').show();
                            $('#secondary_logo_image_close_button').show();
                            /* mobile */
                            $('#secondary_logo_image_m_uploaded').attr('src', '{{ asset('') }}' + response.secondary_logo);
                            $('#secondary_logo_image_m_upload_area').hide();
                            $('#secondary_logo_image_m_display_area').show();
                        }

                        // Set Fundraising
                        if (response.fundraising) {
                            $('#fundraising_image_uploaded').attr('src', '{{ asset('') }}' + response.fundraising);
                            $('#fundraising_image_upload_area').hide();
                            $('#fundraising_image_display_area').show();
                            $('#fundraising_image_close_button').show();
                            /* mobile */
                            $('#fundraising_image_m_uploaded').attr('src', '{{ asset('') }}' + response.fundraising);
                            $('#fundraising_image_m_upload_area').hide();
                            $('#fundraising_image_m_display_area').show();
                        }

                        // Set Banner Image
                        if (response.store_banner) {
                            $('#banner_image_uploaded').attr('src', '{{ asset('') }}' + response.store_banner);
                            $('#banner_image_upload_area').hide();
                            $('#banner_image_display_area').show();
                            $('#banner_image_close_button').show();
                            /* mobile */
                            $('#banner_image_m_uploaded').attr('src', '{{ asset('') }}' + response.store_banner);
                            $('#banner_image_m_upload_area').hide();
                            $('#banner_image_m_display_area').show();
                        }

                        /* Sync mobile color pickers + swatches */
                        var mc = {
                            secondary: response.secondary_color || '#ffffff',
                            primary:   response.primary_color   || '#ffffff',
                            header:    response.header_text_color || '#717070',
                            footer:    response.footer_text_color || '#000000',
                            buttons:   response.button_text_color || '#ffffff'
                        };
                        $('.color-picker-secondary-m').val(mc.secondary); $('.btn-secondary-color-m').css('background', mc.secondary); $('.sd-m-hex-secondary').text(mc.secondary.toUpperCase());
                        $('.color-picker-primary-m').val(mc.primary);     $('.btn-primary-color-m').css('background', mc.primary);     $('.sd-m-hex-primary').text(mc.primary.toUpperCase());
                        $('.color-picker-header-m').val(mc.header);       $('.btn-header-color-m').css('background', mc.header);       $('.sd-m-hex-header').text(mc.header.toUpperCase());
                        $('.color-picker-footer-m').val(mc.footer);       $('.btn-footer-color-m').css('background', mc.footer);       $('.sd-m-hex-footer').text(mc.footer.toUpperCase());
                        $('.color-picker-buttons-m').val(mc.buttons);     $('.btn-buttons-color-m').css('background', mc.buttons);     $('.sd-m-hex-buttons').text(mc.buttons.toUpperCase());

                        /* Sync mobile theme selection */
                        if (response.theme == 1) {
                            $('.sd-mobile-wrap .sd-m-theme-radio[value="1"]').prop('checked', true).trigger('change');
                        } else {
                            $('.sd-mobile-wrap .sd-m-theme-radio[value="0"]').prop('checked', true).trigger('change');
                        }

                    }else{
                        reset_theme_details();
                    }


                    $(".se-pre-con").fadeOut('slow');
                },
                error: function(xhr) {
                    console.error('Failed to fetch theme settings:', xhr.responseText);
                    reset_theme_details();
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        function reset_theme_details() {
            var defaultColor = '#ffffff';

            $('.color-picker-primary').val(defaultColor);
            $('.color-picker-secondary').val(defaultColor);
            $('.color-picker-header').val(defaultColor);
            $('.color-picker-footer').val(defaultColor);
            $('.color-picker-buttons').val(defaultColor);

            $('.btn-primary-color').css('background-color', defaultColor);
            $('.btn-secondary-color').css('background-color', defaultColor);
            $('.btn-header-color').css('background-color', defaultColor);
            $('.btn-footer-color').css('background-color', defaultColor);
            $('.btn-buttons-color').css('background-color', defaultColor);

            $('#primary_logo_image_uploaded').attr('src', '{{ asset("public/images/default.png") }}');
            $('#secondary_logo_image_uploaded').attr('src', '{{ asset("public/images/default.png") }}');
            $('#fundraising_image_uploaded').attr('src', '{{ asset("public/images/default.png") }}');
            $('#banner_image_uploaded').attr('src', '{{ asset("public/images/default.png") }}');

            $('#primary_logo_image_close_button').hide();
            $('#secondary_logo_image_close_button').hide();
            $('#fundraising_image_close_button').hide();
            $('#banner_image_close_button').hide();

            $('#primary_logo_image_upload_area').show();
            $('#primary_logo_image_display_area').hide();

            $('#secondary_logo_image_upload_area').show();
            $('#secondary_logo_image_display_area').hide();

            $('#fundraising_image_upload_area').show();
            $('#fundraising_image_display_area').hide();

            $('#banner_image_upload_area').show();
            $('#banner_image_display_area').hide();

            $('#event_name').val('');
            $('#selected_theme_light').prop('checked', true);
            $('#selected_theme_dark').prop('checked', false);
        }
        function reloadIframe() {
            var iframe = $('#responsive-iframe');
            var src = iframe.attr('src');
            iframe.attr('src', src);
            var mIframe = $('#sd-m-responsive-iframe');
    var mSrc = mIframe.attr('src');
    if (mSrc) { mIframe.attr('src', mSrc); }
        }

        $(document).on('product_value_trigger', '#store_product_id', function() {
            var productId = $(this).val().trim();

            if (productId !== '') {
                var selectedTr = $('.selected_product_tr_' + productId);
                $('.product-list-tr').css('background-color', 'rgb(255 255 255)');
                selectedTr.css('background-color', 'rgb(247 247 247)');
            }
        });


        $(document).on('click', '.update_theme_settings', function() {
            /* Pick the correct form – mobile form if on mobile viewport, else desktop form */
            var formId = $(this).data('form') || 'store_design_data';
            var formData = new FormData($('#' + formId)[0]);
            formData.append('store_id', $('#store_id').val());

            $(".se-pre-con").fadeIn('slow');

            $.ajax({
                url: '{{ route("store.update_store_theme") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    get_theme_details();
                    $(".se-pre-con").fadeOut('slow');
                },
                error: function(xhr, status, error) {
                    console.error('Form submission error:', xhr.responseText);
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });




            $('.product-update-button').on('click', function(event) {
                event.preventDefault();
                save_store_product_form_data();
            });

            $(document).on('click', '.view_store_product', function() {

                if (!can_save) {
                    Swal.fire({
                        title: "Unsaved Changes Detected",
                        text: "You have unsaved changes. Would you like to save them before opening a new product?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Save & Continue",
                        cancelButtonText: "Stay Here"
                    }).then((result) => {
                        if (result.value) {
                            save_store_product_form_data();
                            openProduct($(this));
                        }
                    });
                } else {
                    openProduct($(this));
                }


            });

            function save_store_product_form_data(){
                var formData = new FormData($('#store_product_update')[0]);

                formData.append('store_id', $('#store_id').val());
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('store.save_store_products') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            can_save = true;
                            Swal.fire({
                                title: "Success",
                                text: "Product has been saved successfully.",
                                icon: "success"
                            });
                            loadProducts();
                        } else {
                            can_save = true;
                            Swal.fire({
                                title: "Error",
                                text: "Something went wrong while saving the product.",
                                icon: "error"
                            });
                        }
                        loadProducts();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    },
                    complete: function () {
                        price_addition_append();
                        $(".se-pre-con").fadeOut('slow');
                    }
                });
            }

            function openProduct(button) {
                isFirstChange = true;
                let $row = button.closest('tr');

                let store_id = $('#store_id').val();
                let id = $row.attr('value');
                let isSaved = $row.data('is_saved');

                showTab('general_tab');

                if(isSaved == 1){
                    $.ajax({
                        url: "{{ route('store.get_store_product_by_id') }}",
                        type: "GET",
                        data: {
                            'id' : id,
                            "_token": "{{ csrf_token() }}"
                        },
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function (response) {
                            $('#store_product_id').val(response.id || '').trigger('product_value_trigger');
                            $('#product_id').val(response.product_id || '');
                            // $('#store_product_default_name').val(response.product_default_name || response.products.product_name);
                            $('#store_product_default_name').val(
                                response?.product_default_name || response?.products?.product_name || ''
                            );
                            $('#store_product_name').val(response.product_name || '');
                            $('#mandotary').prop('checked', response.mandotary == 1);

                            $('#store_product_style').val(response.style || '');

                            $('#store_product_style_editor .ql-editor').html(response.style);

                            $('#store_product_category').val(response.category_id || '').trigger('change');
                            // $('#store_product_tax_category').val(response.tax_category || '').trigger('change');
                            $('#store_product_shipping_weight').val(response.shipping_weight || '');
                            $('#store_product_moq').val(response.moq || 1);
                            $('#store_product_maxoq').val(response.maxoq || '');
                            let priceValue = Number(response.default_price) || 0;
                            $('#store_product_default_price').val(priceValue.toFixed(2));

                            $('#price_addition_table').empty();

                            price_addition_append();
                            append_embellishment_options(response.product_id, response.embellishment_option);

                            $('#set_individual_name').prop('checked', response.set_individual_name == 1).trigger('change');
                            $('#set_individual_number').prop('checked', response.set_individual_number == 1).trigger('change');

                            if (response.set_individual_name == 1 && response.individual_name_details) {
                                const nameDetails = response.individual_name_details;

                                $('input[name="name_required"]').prop('checked', nameDetails.name_required == 1).prop('disabled', false);
                                $('input[name="name_exlusive"]').prop('checked', nameDetails.name_exlusive == 1).prop('disabled', false);
                                $('input[name="name_not_for_printing"]').prop('checked', nameDetails.name_not_for_printing == 1).prop('disabled', false);
                                $('input[name="name_extra_price"]').val(nameDetails.name_extra_price || "0.00").prop('disabled', false);
                                $('input[name="name_character_limit"]').val(nameDetails.name_character_limit || "6").prop('disabled', false);
                            } else {
                                $('input[name="name_required"]').prop('checked', false).prop('disabled', true);
                                $('input[name="name_exlusive"]').prop('checked', false).prop('disabled', true);
                                $('input[name="name_not_for_printing"]').prop('checked', false).prop('disabled', true);
                                $('input[name="name_extra_price"]').val("0.00").prop('disabled', true);
                                $('input[name="name_character_limit"]').val("6").prop('disabled', true);
                            }

                            if (response.set_individual_number == 1 && response.individual_number_details) {
                                const numberDetails = response.individual_number_details;

                                $('input[name="number_required"]').prop('checked', numberDetails.number_required == 1).prop('disabled', false);
                                $('input[name="number_exlusive"]').prop('checked', numberDetails.number_exlusive == 1).prop('disabled', false);
                                $('input[name="number_extra_price"]').val(numberDetails.number_extra_price || "0.00").prop('disabled', false);

                                $('#number_type').val(numberDetails.number_type).prop('disabled', false).trigger("change");

                                const $numberSelect = $('select[name="exclude_numbers[]"]');

                                const numberList = JSON.parse(numberDetails.exclude_numbers || '[]');
                                $numberSelect.empty();
                                numberList.forEach(num => {
                                    if ($numberSelect.find(`option[value="${num}"]`).length === 0) {
                                        $numberSelect.append(new Option(num, num, true, true));
                                    }
                                })

                                $numberSelect.prop('disabled', false);

                                if (numberDetails.number_type == "0-99") {
                                    $("#min_number").val(numberDetails.min_number || 0).prop('disabled', false);
                                    $("#max_number").val(numberDetails.max_number|| 99).prop('disabled', false);

                                    $("#min_number_count").val(numberDetails.min_number_count || 1).attr("min", 1).attr("max", 2).prop('disabled', false);
                                    $("#max_number_count").val(numberDetails.max_number_count || 2).attr("min", 1).attr("max", 2).prop('disabled', false);
                                    $("#number-count-div").hide();

                                } else if (numberDetails.number_type == "3-digits") {
                                    $("#min_number").val(numberDetails.min_number || 1).prop('disabled', false);
                                    $("#max_number").val(numberDetails.max_number|| 999).prop('disabled', false);

                                    $("#min_number_count").val(numberDetails.min_number_count || 1).attr("min", 1).attr("max", 3).prop('disabled', false);
                                    $("#max_number_count").val(numberDetails.max_number_count || 3).attr("min", 1).attr("max", 3).prop('disabled', false);
                                    $("#number-count-div").hide();

                                } else if (numberDetails.number_type == "custom") {
                                    $("#min_number").val(numberDetails.min_number || 0).prop('disabled', false);
                                    $("#max_number").val(numberDetails.max_number|| 9999).prop('disabled', false);

                                    $("#min_number_count").val(numberDetails.min_number_count || 1).attr("min", 1).attr("max", 10).prop('disabled', false);
                                    $("#max_number_count").val(numberDetails.max_number_count || 5).attr("min", 1).attr("max", 10).prop('disabled', false);
                                    $("#number-count-div").show();

                                }

                            } else {
                                $('input[name="number_required"]').prop('checked', false).prop('disabled', true);
                                $('input[name="number_exlusive"]').prop('checked', false).prop('disabled', true);
                                $('input[name="number_extra_price"]').val("0.00").prop('disabled', true);
                                $('#number_type').prop('disabled', true);

                                const $numberSelect = $('select[name="exclude_numbers[]"]');
                                $numberSelect.empty();
                                $numberSelect.prop('disabled', true);

                                $("#min_number").val('').prop('disabled', true);
                                $("#max_number").val('').prop('disabled', true);

                                $("#min_number_count").val('').prop('disabled', true);
                                $("#max_number_count").val('').prop('disabled', true);
                                $("#number-count-div").hide();
                            }


                            $('input[name="store_product_availability"][value="' + (response.product_availability || '0') + '"]').prop('checked', true);

                            $('#size_type_id').val(response.size_type_id);
                            appendSizes(response.size_type_id);
                            isFirstChange = false;

                            $.ajax({
                                url: "{{ route('store.get_store_product_images') }}",
                                type: "GET",
                                data: {
                                    'id' : id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    $('#uploaded_product_table_tbody').html('');
                                    if (response.length > 0) {
                                        $('.variant-manage-div').show();

                                        response.forEach(element => {

                                            var tr = image_table_tr(element);

                                            $('#uploaded_product_table_tbody').append(tr);
                                        });
                                    }
                                    $('.store-product-select2').select2();
                                    appendVariants();
                                }

                            });
                        },
                        complete: function () {
                            $(".se-pre-con").fadeOut('slow');
                            can_save = true;
                            $('#product_display_card').removeClass('product-area-spinner');
                        }
                    });
                }
            }

            // images

            var uploadArea = $('.image-upload-area');
            var fileInput = $('#file-input-product');

            // Handle dragover event
            uploadArea.on('dragover', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragging'); // Add visual feedback if desired
            });

            // Handle dragleave event
            uploadArea.on('dragleave', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragging');
            });

            // Handle drop event
            uploadArea.on('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragging');

                // Get the dropped files from the event
                var files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    // Create a new DataTransfer object (supported in modern browsers)
                    var dataTransfer = new DataTransfer();
                    // Add each file to the DataTransfer object
                    Array.from(files).forEach(function(file) {
                        dataTransfer.items.add(file);
                    });
                    // Assign the files to the file input element
                    fileInput[0].files = dataTransfer.files;
                    // Trigger the change event to run your upload logic
                    fileInput.trigger('change');
                }
            });


            $('#file-input-product').on('change', function() {
                var files = $(this)[0].files;
                var storeId = $('#store_id').val();
                var storeProductId = $('#store_product_id').val() ? $('#store_product_id').val() : '';
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                if (files.length > 0) {
                    var formData = new FormData();
                    formData.append('store_id', storeId);
                    formData.append('store_product_id', storeProductId);
                    formData.append('_token', csrfToken);

                    Array.from(files).forEach(function(file) {
                        formData.append('product_images[]', file);
                    });

                    $.ajax({
                        url: '{{ route("store.upload_product_images") }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status === 'success') {
                                response.uploaded_files.forEach(function(element) {

                                    var tr = image_table_tr(element);
                                    $('#uploaded_product_table_tbody').append(tr);


                                });

                                $('#store_product_id').val(response.store_product_id);
                            } else {
                                console.error('Upload error:', response.message);
                            }
                            $('.store-product-select2').select2();
                            appendVariants();
                        },
                        error: function(xhr) {
                            console.error('Failed to upload images:', xhr.responseText);
                        }
                    });

                    $('.variant-manage-div').show();
                }
                loadProducts();
            });
            $('#product_image_edit').on('change', function(event) {
                var input = event.target;
                var file = input.files[0];

                if (file) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#product_image_preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);

                    $('.edit_product_image').show();
                }
                loadProducts();
            });
            $('.edit_product_image').on('click', function(e) {
                e.preventDefault();

                var formData = new FormData($('#edit_product_image_form')[0]);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                formData.append('_token', csrfToken);

                $.ajax({
                    url: '{{ route("store.edit_product_image") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#saved_product_images_' + response.data.id).attr('src', '{{ asset('') }}' + response.data.url);
                        $('#hidden_image_src_'+response.data.id).val('{{ asset('') }}' + response.data.url);
                        $('#edit_product_image').modal('hide');
                    },
                    error: function(xhr) {
                        console.log('Failed to edit image:', xhr.responseText);
                    }
                });
            });
            $('#delete_form').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action will delete the store and all its associated data. This action cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.value) {
                        delete_store();
                    }
                });
            });

            function delete_store() {
                var storeId = $('#store_id').val();
                $('.se-pre-con').fadeIn('slow');
                $.ajax({
                    url: '{{ route("store.delete_store") }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'store_id': storeId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = '{{ route("stores") }}';
                        } else {
                            $('.se-pre-con').fadeOut('slow');
                            Swal.fire({
                                title: "Error",
                                text: "Something went wrong while deleting the store.",
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr) {
                        $('.se-pre-con').fadeOut('slow');
                        console.error('Error deleting store:', xhr.responseText);
                        Swal.fire({
                            title: "Error",
                            text: "Something went wrong while deleting the store.",
                            icon: "error"
                        });
                    }
                });
            }



    });

</script>

@if(isset($is_new) && $is_new)
    <script>
        $(document).ready(function() {
            $('#view_store_button_id').hide();
        });
    </script>
@endif

@endsection
