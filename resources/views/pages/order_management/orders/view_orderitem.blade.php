@php
    $activePage = ( $orderTrait->isInventoryOrder($order->organization_id) ) ? 'inventory_orders' : 'orders';
@endphp

@extends('layouts.app', ['activePage' => $activePage, 'titlePage' => __('Edit Order')])

@section('content')
    <style>
        .select2.select2-container {
            width: 100% !important;
        }
        #image_container {
            width: 100px;
            height: 100px;
            margin-left: 15px;
            margin-top: -30px;
            border-radius: 50%;
            overflow: hidden;
        }
        #image_preview {
            width: 100%;
            height: 100%;
        }

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
            font-size: 10px;
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
            /* padding: 6px 12px; */
            /* border-top: 1px solid #ccc; */
        }
        .tab-input {
            border: none;
            border-bottom: 1px solid #cad1d7;
        }

        /* .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; } */
        .se-pre-con {
            position: fixed;
            /* display: none; */
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        }
        /*messagebox*/
        #hiddenNotes
        {
            display:none;
            background-color: #eee;
            border-radius: 5px;
            border: 1px solid #aaa;
            position: fixed;
            width: 300px;
            left: 50%;
            margin-left: -150px;
            padding: 6px 8px 8px;
            box-sizing: border-box;
            text-align: center;
        }
        #hiddenNotes .button {
            background-color: #ccc;
            display: inline-block;
            border-radius: 3px;
            border: 1px solid #aaa;
            padding: 2px;
            text-align: center;
            width: 80px;
            cursor: pointer;
        }
        #hiddenNotes .button:hover
        {
            background-color: #ddd;
        }
        #hiddenNotes .message
        {
            text-align: left;
            margin-bottom: 8px;
        }
        .cusTab .tab {
            float: left;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            width: 30%;
            height: 300px;
        }

            /* Style the buttons inside the tab */
        .cusTab .tab button {
            display: block;
            background-color: inherit;
            color: black;
            padding: 22px 16px;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
            font-size: 17px;
        }

            /* Change background color of buttons on hover */
        .cusTab .tab button:hover {
            background-color: #ddd;
        }

            /* Create an active/current "tab button" class */
        .cusTab .tab button.active {
            background-color: #ccc;
        }

            /* Style the tab content */
        .cusTab .tabcontent {
            float: left;
            padding: 0px 12px;
            border: 1px solid #ccc;
            width: 70%;
            border-left: none;
            height: 300px;
        }

        .radio {
            width: 16%;
            height: calc(1rem + 5px);
        }

        /* For Chrome */
        .blankseq::-webkit-outer-spin-button,
        .blankseq::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* For Firefox */
        .blankseq {
        -moz-appearance: textfield;
        }

        @media (max-width: 1366px) {
            .roster-container {
                overflow: scroll;
            }
            .roster-table {
                width: 200%;
            }
        }

        .highlight{
            background-color: #ffff0082;
        }

        .item-table-inputs{
            width: auto !important;
        }
        .order-header {
            font-family: Helvetica, sans-serif;
            font-size: 25px;
            color: #fff;
            letter-spacing: 2px;
        }
        .second-nav-place {
            width: 100%;
            height: 50px;
            margin-top: 10px;
            position: relative;
            top: -35px;
            background-color: transparent
        }
        .btn-place {
            position: relative;
            top: 14px;
        }
        .back-btn-bg {
            background-color: #787878;
            width: 100%;
            height: 35px;
            position: relative;
            right: -2px;
            border-radius: 4px;
            border: 1px solid;
            border-color: red;
        }
        .back-btn-font {
            font-family: Helvetica, sans-serif;
            color: white;
            font-size: 58%;
            line-height: 14px;
        }
        .back-btn {
            padding: 0%;
        }
        .back-btn-f0nt-place {
            position: relative;
            top: 3px;
            right: 11px;
        }
        .back-btn-icon-place {
            position: relative;
            top: 9px;
            right: -11px;
        }
        .order-detail-btn {
            background-color: #f6f6f6;
            width: 95%;
            height: 35px;
            position: relative;
            top: 3%;
            right: -1%;;
        }
        .quotation-btn {
            width: 83px;
            height: 25px;
            background-color: #787878;
            position: relative;
            left: -25px;
            top: -12px;
            border: none;
        }
        .url-btn {
            width: 45px;
            height: 25px;
            background-color: #787878;
            position: relative;
            left: -24px;
            top: -12px;
            border: none;
        }
        .edit-btn {
            width: 43px;
            height: 25px;
            background-color: #787878;
            position: relative;
            left: -13px;
            top: -12px;
            border: none;
        }
        .re-order-btn {
            width: 94px;
            height: 25px;
            background-color: #787878;
            position: relative;
            left: -24px;
            top: -12px;
            border: none;
        }
        .quotation-btn-font {
            color: white;
            position: relative;
            font-size: 50%;
            line-height: 12px;
            left: 8px;
            top: -14px;
        }
        .btn-position {
            position: relative;
            right: -50px;
        }
        .btn-icon {
            position: relative;
            left: -22px;
            top: 2px;
        }
        .nav-btn {
            border-bottom: 2px solid #b2b2b2;
            position: relative;
            top: 0px;
            left: 16px;
        }
        .nav-btn-spec {
            height: 36px;
            width: 33%;
            position: relative;
            left: 2px;
            border-color: transparent;
            padding: 0;
            padding-top: 7px;
            color: white;
            font-size: 13px;
        }
        .card-position {
            width: 109%;
            position: relative;
            left: -6%;
        }
        .order-management-card {
            position: relative;
            top: -61px;
        }
        .div-right-position {
            position: relative;
            right: -6px;
        }
        .link-div {
            margin-top: 0px;
            position: relative;
            bottom: 21px;
            right: 1%;
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
        .btn-top {
            position: relative;
            top: -23px;
        }

        .btn-padding {
            padding-left: 0.2rem;
            padding-right: 0.2rem;
        }
        .btn-right {
            position: relative;
            right: 27px;
        }
        .url-position {
            position: relative;
            top: -4px;
        }
        .reorder-lable {
            position: relative;
            bottom: 4px;
            left: 11px;
        }
        @media only screen and (min-width: 1174px)  and (max-width: 1500px)  {
            .btnlink01{
                display: inline-block;
                width: 32%;
            }
            .btnlink02{
                display: inline-block;
                width: 36%;
            }
            .btnlink03{
                display: inline-block;
                width: 32%;
            }
        }
        @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
            .wrapper002 {
                display: grid;
                grid-template-columns: auto auto auto auto;
                grid-gap: 10px;
                padding: 20px;


            }
            .btnlink01{
                display: inline-block;
                top:-20px;
                width: 150px;
            }
            .btnlink02{
                display: inline-block;
                top:-20px;
                width: 150px;
            }
            .btnlink03{
                display: inline-block;
                top:-20px;
                width: 32%;
            }

            .btnsetor002{
                display:none;
            }
            .btnsetor001{
                display: grid;
                grid-template-columns: auto auto auto auto;
                grid-gap: 10px;
                padding: 20px;
            }
            .btnor001{
                display: inline-block;
                width:100px;
            }

        }
        @media screen and (min-width: 600px) and (max-width: 800px) {
            .div_borderbox_cls{

                top:-75%;
            }
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
            border-bottom: 0.1px solid black !important;
            background-color: unset;
            color:black;
        }
        .nav-fill .nav-item{
            color:#b2b2b2;
        }
        .nav-tabs .nav-link:hover{
            /* border-color: #f6f6f6; */
            border-bottom-color: black !important;
            color: black;

        }
        /* .nav-tabs .nav-link.active{
            border-color: #f6f6f6;
            border-bottom-color: black;

        } */
        .main-content{
            background-color: #ffffff;
        }
        .main-content{
            background-color: #ffffff;
        }
        .card-body{
            margin-top: 1rem;
        }
        .functionalityBtn:hover{
            color:black !important;
        }
        ..swal2-title{
            font-size: 1rem !important;
        }
        .swal2-confirm{
            padding: .2em 1.5em !important;
            font-size: 1rem;
            background-color: #0bd700;
            border: unset;
            outline: none;
        }
        .se-pre-con {
            color: #252525; /* Change text color */
            font-size: 20px; /* Change text size */
            text-align: center; /* Center text */
            padding-top: 10%;
            font-weight: bold;
        }
        .switch {
        position: relative;
        display: inline-block;
        width: 34px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 12px;
        width: 12px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:checked + .slider:before {
        transform: translateX(14px);
    }
    .p-tag-clz{
        font-size: 0.7rem;
        text-align: end;
        cursor: pointer;
        color: #b2b2b2;
    }
    .display-none-class{
        display: none;
    }
    /* Dark overlay */
    #progress-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1000;
    }

    /* Centered modal */
    #progress-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px 0px #000;
        z-index: 1001;
        width: 600px;
        text-align: center;
    }

    /* Progress bar container */
    #progress-bar-container {
        width: 100%;
        height: 20px;
        background-color: #f3f3f3;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 10px;
    }

    /* Progress bar itself */
    #progress-bar {
        width: 0%;
        height: 100%;
        background-color: green;
        transition: width 0.3s;
    }
    .form-card-position {
        width: 109%;
        position: relative;
        left: -65px;
        top: -10px;
    }

    .detail-card-margin {
        margin: 12px;
        padding: 12px !important;
    }

    .table-font-size {
        font-size: 13px;
    }

    .table-border {
        border: unset !important;
    }

    .form-position {
        position: relative;
        top: 10px;
    }

    .address-card {
        height: 100%;
    }

    .track-table-position {
        position: relative;
        bottom: -50%;
    }

    .roster-padding {
        padding-top: 0 !important;
    }

    .extra-size-font {
        font-size: small;
        font-weight: 600;
        color: #525f7f;
    }

    .control-btn-card {
        position: relative;
        left: -15px;
        width: 102.5%;
    }

    .control-btn-position {
        position: relative;
        right: 3.5%;
    }

    .mockup-btn {
        position: relative;
        right: 23px;
    }

    .table-width {
        width: 95%;
    }

    .copy-btn {
        position: relative;
        right: 16px;
    }
    .hide {
    display: none;
  }
  .order-roster {
    font-size: 20px;
    font-weight: 700;
    color: black;
    position: relative;
    left: 10px;
  }
  .order-roster-div {
    padding: 12px;
  }
  .item-details-font {
    font-size: 26px;
    font-weight: 700;
    color: black;
  }
  .item-details-div {
    padding-top: 5px;
    padding-bottom: 5px;
  }
  .item-topic.active {
    color: #000000 !important;
    font-weight: bold !important;
    border-bottom: 3px solid black !important;
    background-color: unset !important;
  }
  .item-topic {
    color: #525f7f;
    font-size: 14px;
  }
  .right-left-border {
    border-left: 1px solid #bbbbbb;
    border-right: 1px solid #bbbbbb;
  }
  .border-threeSide {
    border-left: 1px solid #bbbbbb;
    border-right: 1px solid #bbbbbb;
    border-bottom: 1px solid #bbbbbb;
  }
  .bottom-border{
    border-bottom: 1px solid #bbbbbb;
  }
  .tablinksCustom.active {
    color: #47D6B6 !important;
    background-color: transparent !important;
    border-left: 3px solid #47D6B6 !important;
  }

  .card{
    border: none;
    border-radius: 0rem;
  }
  .SpecificDiv .form-control[readonly]{
    background-color: #F8F8F8;
    border: none !important;
    line-height: 14px;
    border-radius: 0rem;
    color: #717070;
  }
  .contactDetailsDiv .form-control[readonly]{
    background-color: #ffffff;
    border: none !important;
    line-height: 14px;
    border-radius: 0rem;
    color: #717070;
  }
    .ForBorderStyles .form-control{
        line-height: 14px;
        border-radius: 0rem;
    }
    .ex-factory-address-line1 .form-control,
    .ex-factory-address-line2 .form-control,
    .ex-factory-address-line3 .form-control{
        background-color: transparent;
        border: none !important;
        line-height: 14px;
        border-radius: 0rem;
        color: #717070;
    }
    .custom-control-label{
        color: #717070;
        font-size: 0.8rem !important;
    }
    .label {
        margin-bottom: .2rem !important;
    }
    .custom-checkbox .custom-control-label::before, .custom-checkbox .custom-control-label::after {
        border-radius: 0rem;
    }
    .hasDatepicker{
        border-radius: 0rem !important;
    }
    .tablinks{
        font-weight: 700;
        text-align: left;
        width: 100%;
    }
    .for-style-paste .tab button.active{
        font-weight: 700;
        background-color: rgb(246, 246, 246);
        color: black;
        border-bottom: unset;
        border-right: 1px solid gray;
    }
    .for-style-paste .tab button:hover {
        background-color: rgb(246, 246, 246);
        border-bottom: unset;
        color: black;
    }
    .file-preview {
        border: none;
        padding: unset !important;
    }
    .fileinput-remove{
        display: none;
    }
    .clearfix{
        background-color: #FCFCFC;
        margin: unset;
    }
    .forStyles.nav-item.active, .forStyles .item-topic.active{
        font-size: .8rem;
        font-weight: 600 !important;
        border-bottom: 2px solid black !important;
    }
    .forStyles.nav-item:hover, .forStyles .item-topic:hover{
        font-size: .8rem;
        font-weight: 600 !important;
        border-bottom: 2px solid black !important;
        color: black;
    }
    .forStyles.nav-item, .forStyles .item-topic{
        font-size: .8rem;
        font-weight: 600 !important;
        border-bottom: none;
    }
    .forStyles.nav-item, .forStyles .item-topic{
        font-size: .8rem;
        font-weight: 600 !important;
        border-bottom: 2px solid #717070 !important;
        color: #717070;
    }
    .qty-container .form-control{
        /* border: none !important; */
        color: black !important;
    }

    .cardInsideBox .form-control{
        border: 1px solid #DEDEDE;
        border-radius: 0rem !important;
        color: #717070 !important;
        padding-left: 7px !important;
        font-size: 0.8rem !important;
        line-height: 23px !important;
    }

    .sub-header-style{
        font-size: .8rem;
    }
    .pdf-content .pdf-size {
        max-width: 100% !important;
        width: 98% !important;
        max-height: 60px !important;
        height: 60px !important;
    }
    .pdf-content .file-size-info {
        position: relative;
        top: -29px;
    }
    .pdf-content .file-caption-info {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }
    .pdf-content .progress {
        position: relative;
        left: -6px;
        top: -1px !important;
    }
    .img-content .file-caption-info {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
        height: 16px;
    }
    .select2-container--default .select2-results__option--disabled{
        color: red !important;
    }
    .file-preview-frame {
        width: 190px !important;
        height: 284px !important;
        border: unset !important;
        box-shadow: unset !important;
    }
    .upload_button {
        cursor: pointer;
        height: 26px;
        border: 1px solid rgb(209, 209, 209);
        background-color: rgb(242, 242, 242);
        font-size: 8px;
    }
    .file-drop-zone {
        border: unset;
    }
    .file-drop-zone.clickable:hover {
        border: unset !important;
    }
    .file-thumbnail-footer {
        position: relative;
        top: -37px !important;
        padding-left: 9px;
        padding-right: 9px;
    }
    .kv-file-content {
        height: 293px !important;
        width: 105% !important;
        margin: unset;
        width: 100%;
        text-align: center;
    }
    .file-footer-buttons {
        text-align: right !important;
    }
    .file-actions {
        position: relative !important;
        top: -50px !important;
    }
    .file-drop-zone .file-preview-thumbnails {
        max-height: 381px !important;
        height: 350px !important;
    }
    .pdf-content .kv-preview-data {
        display: table-cell !important;
    }
    .pdf-content .file-actions {
        position: relative !important;
        top: -24px !important;
    }
    .pdf-content .file-other-icon {
        font-size: 2.5rem !important;
    }
    .pdf-content .file-thumbnail-footer {
        position: relative !important;
        top: -38px !important;
    }
    .pdf-content .krajee-default .file-size-info {
        width: 80px !important;
    }
    .pdf-content .kv-file-content {
        height: 50px !important;
    }
    .file-drop-zone-title {
        padding: 0px 0px !important;
        position: relative;
        top: 60px;
    }
    .file-preview-image {
        width: 88% !important;
    }
    .btn-kv {
        background-color: #ffffff6e;
        color: #4d4d4d;
    }

    .img-content .file-thumbnail-footer{
        margin-top: 2rem;
    }
    .caption-info{
        display: block !important;
    }
    .btn-kv{
        border: 1px solid #b3b3b3 !important;
    }
    .img-content .file-caption-info {
        height: auto;
        white-space: unset;
    }
    .control-btn-position {
        position: relative;
        right: 0%;
    }
    .ui-datepicker {
        position: absolute !important;
    }
    .imagesize{
            max-width: 70%;
}
#customer_address_type:disabled + .select2-container .select2-selection--single .select2-selection__rendered {
    color: #c8c8c8 !important; /* Change the color to gray */
    border: 1px solid #c8c8c8 !important;

}
.card-position {
    width: 109%;
    position: relative;
    left: -6%;
}
.table-border {
    border: none;
    font-size: small;
    border-collapse: revert !important;
}
.order-no-color {
    color: #2dce89;
}
.status-width {
    color: #ffffff !important;
    background-color: #ffae35
}
.sales-rep-color {
    color: #ffffff !important;
    background-color: #2dce89
}
.shipping-table-width {
    width: 96%;
}
.description-width {
    width: 96%;
}
.item-table-top {
    position: relative;
    top: -38px;
}
.price-div-top {
    position: relative;
    top: 14px;
}
.cancel-btn {
    height: 26px;
    width: 24% !important;
    color: white;
    background-color: red;
}
.btn-text {
    font-size: 13px;
    position: relative;
    top: -6px;
    font-weight: 600;
}
.pay-btn {
    height: 26px;
    width: 24% !important;
    color: white !important;
    background-color: rgb(74, 50, 255);
}
.save-btn {
    height: 26px;
    width: 23% !important;
    color: white;
    background-color: rgb(0, 255, 81);
}
.pay-btns-tr{
    position: relative;
    top: 10px;
}
.remove-border {
    border: none;
}
.light-border {
    border-color: #f1f1f1;
    border-radius: 0.25rem;
}
.light-font {
    color: #b4b4b4
}
.date-color {
    color: #2dce89;
}
.date-td-width {
    width: 40%;
}
.date-div-position {
    width: 132%;
}
.date-div-padding {
    padding: unset;
}
.new-address-tx {
    font-size: 7px;
}
.item-add-btn {
    color: white;
    background-color: #3636ff;
    width: 8%;
    height: 25px;
    font-size: 9px;
    border-color: #3636ff;
}
.date-log-info {
    color: white;
    background-color: #3636ff;
    /* width: 68px;
    height: 22px; */
    font-size: 9px;
    border-color: #3636ff;
}
.item-table-border {
    border: none;
}
.view-icon {
    position: relative;
    top: 0px;
}
.icon-table-potision {
    position: relative;
    top: -1px;
}
.item-table-position {
    position: relative;
    left: -3%;
}
.table-width {
    width: 100%;
}
.content-position {
    position: relative;
    top: -75px;
}
.icon-button {
    background-color: transparent;
    border: none;
}
.organization-padding {
    padding: unset;
    padding-left: 21px;
}
.placeholder-color::placeholder {
      /* Change the color here */
      color: rgb(218, 218, 218);
    }
.align-right {
    text-align: right;
}
.item-view-icon {
    height: 2.04rem !important
}
.address-save-btn{
    height: 25px;

}

.eye-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    background-color: #1aff5f !important;
  }
  .swal2-close{
    outline: none !important;
  }


@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
    .ordetails001{
            flex-direction: column;
        }
    .orderdetails001{
        display: inline-block;
            width:100%;
    }
    .orderdate001 {
        max-width: none;
    }
    .orderdetails002{
        max-width: none;
    }
    .item-add-btn{
        width: 20%;
    }
    .invoicein0001{
        width:110px;
    }
    .organization-padding{
        padding-left: 15px;
    }
}
@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) {
    .lordetails001{
        flex-direction: column;
        }
    .lorderdate001 {
        max-width: none;
    }
}
.select2-selection__rendered{
    padding-left: 0px !important;
}
.card .table td, .card .table th{
    padding-right: 1rem !important;
}
.card .table td{
    width: fit-content !important;
    vertical-align: middle;
}
.card-updated{
    background-color: white;
    height: 100%;
}
.border-style{
    border: 1px solid #DEDEDE !important;
    border-radius: 0rem !important;
    color: #717070 !important;
}
.select2-selection__rendered{
    border: 1px solid #DEDEDE;
    border-radius: 0rem !important;
    color: #717070 !important;
    padding-left: 7px !important;
    font-size: 0.8rem !important;
    line-height: 23px !important;
}
.header-style{
    color: black;
    font-size: 1.2rem;
    font-weight: 600;
}
.form-label{
    margin-top: 0.5rem;
    color: black;
    font-size: 0.8rem;
    font-weight: 500;
}
.sub-header-style{
    color: black;
    font-size: 1rem;
    margin-top: 1rem;
    font-weight: 600;
}
.disabled-style{
    background-color: #F8F8F8;
    border: none !important;
    line-height: 14px;
}
.invoice-inputs{
    line-height: 16px;
}
.address-text{
    font-size: 0.8rem;
    color: #8d8d8d;
}
.table-header-style{
    background-color: #717070;
    color: white;
}
.table th, .table td{
    padding: 0rem;
    letter-spacing: 0px !important;
    font-size: 0.75rem;
}
.table td{
    font-weight: 100 !important;
}
tr .select2-selection__rendered {
    border: none !important;
    padding-left: 0px !important;
}
.status-lable{
    background-color: #FFF6CC;
    border-radius: 1rem;
    text-align: center !important;
    padding: 0.2rem;
}
/* .form-control{
    height: calc(1.5rem + 1px);
} */
.hasDatepicker{
    padding: 5px;
    padding-left: 6px;
}
.swal2-confirm{
    border: none !important;
    background-color: #47D6B6 !important;
    border-radius: 0rem !important;
    font-size: .8rem !important;
    padding: .2em 2em !important;
    color: white !important;
    cursor: pointer;
}
.swal2-cancel{
    border: none !important;
    background-color: #b3b3b3 !important;
    border-radius: 0rem !important;
    font-size: .8rem !important;
    padding: .2em 2em !important;
    color: white !important;
    cursor: pointer;
}
.new-dropdown-style{
    height: 25px;
    padding-top: 3px;
}
.swal2-title{
    font-size: 1rem !important;
}
.swal2-input, .swal-input-reason, .swal2-input1, .swal2-input2{
    font-size: 1rem !important;
}
#invoice_summery_table tr{
    height: 30px;
    font-size: .8rem !important;
}
.payment-lable-style{
    text-align: center;
    height: 30px;
    outline: unset;
    border: none;
}
.footer-button-styles{
    border: none !important;
    border-radius: 0rem !important;
    font-size: .8rem !important;
    padding: .7em 2em !important;
    color: white !important;
    cursor: pointer;
    margin: 1%;
}
.onclickAncTag:hover {
    text-decoration: underline #4E4C4C;
}
.modal-body tr .select2-selection__rendered {
    border: 1px solid #B3B3B3 !important;
    padding-left: 8px !important;
}


.discount_row {
            display: none; /* Initially hide the row */
        }

.remake_items_bg{
        background-color: #f8ff90
    }
.select2-container--default .select2-selection--single{
    background-color: unset;
}
.item_disable{
    pointer-events: none;
}


#product_table_body .select2-selection__rendered {
    color: rgba(22, 22, 23, 1) !important;
}
body {
    font-family: 'Open Sans', 'sans-serif' !important;
}
.visit-button{
    width: 100%;
    font-size: .7rem;
    background-color: #8be0ff;
    color: white;
    border: none;
    box-shadow: 2px 2px #e7e7e7;
    cursor: pointer;
    outline: unset;
    height: 77%;
}
.disable-cancel-btn {
    cursor: no-drop !important; /* Show that the button is disabled */
    opacity: 0.5; /* Make the button appear faded */

}
#footer-button-styles-save:disabled{
    background-color: #adb5bd;
}
#footer-button-styles-save{
    background-color: #47D6B6;
}
.swal2-popup {
    width: 38em;
}
.class-for-status-validation:hover{
    text-decoration: underline !important;
}
.swal2-popup .swal2-title {
    font-size: 1.5rem !important;
}
.hide_test_print_col{
    display: none;
}
#add_ex_factory_modal .modal-body .form-lable {
        width: 50%;
}

@media (min-width: 769px){
        .back_home_mobile {
            display:none !important;
        }


    }
    @media (max-width: 768px){
        .back_home_mobile {
            padding-bottom: 20px;
        }
        .home-btn-color-mobile {
            color: #475569 !important;
            font-size: 11px;
        }
        .home-btn-color-mobile:hover {
            color: #777777 !important;
        }
        .header-layout {
            margin-bottom: 20px !important;
        }
        .second-nav-place {
            margin-top: 30px;
        }
        .tab_bar_mobile {
            width: 100% !important;
        }
        .btn-place {
            top: unset;
        }
        .nav-btn {
            left: unset;
        }
        .second-nav-place .row.col-md-7.btn-place{
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            justify-content: center;
            margin: 0 auto;
        }

        .tab_bar_mobile{
            width: 100% !important;
            margin: 0 auto;
        }

        .tab_bar_mobile .nav-link{
            flex: 1 1 0;
            text-align: center;
            font-size: 11px !important;
        }

        .nav-btn{
            width: 100%;
            left: 0;
        }
        .mobile_nav_tab {
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 4px 12px 0 #0000001a;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
            border: unset;
            border-bottom: 1px solid black !important;
        }
        .tab_bar_mobile .nav-link {
            border-bottom: unset !important;
            font-size: 9px !important;
        }
    }
    @media (max-width:768px){

    .mobile-action-row{
        display:grid !important;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px 5px;
        align-items:center;
        padding: 0px 15px !important;
    }

    /* Row 1 */
    .mobile-action-row > div:nth-child(1){
        grid-column: 1 / 4;
        margin-left: unset !important;
        width: 100% !important;
        border-right: unset !important;
    }

    .mobile-action-row > div:nth-child(2){
        grid-column: 4/7;
        justify-self:start;
        /* padding-top: 10px; */
        width: 100% !important;
        border-right: unset !important;
    }

    /* Row 2 */
    .mobile-action-row > div:nth-child(3){
        grid-column: 1 / 3;
        width:100% !important;
        margin-left:0 !important;
        border-right:none !important;
    }

    .mobile-action-row > div:nth-child(4){
        grid-column: 3/5;
        width:100% !important;
        border-right:none !important;
    }

    /* Row 3 */
    .mobile-action-row > div:nth-child(5){
        grid-column:5/7;
        text-align: center;
        border-right: unset !important;
        width:100% !important;
    }

    .mobile-action-row > div:nth-child(6){
        grid-column:3/5;
        width: unset !important;
    }

    .mobile-action-row > div:nth-child(7){
        grid-column:5/7;
        width: unset !important;
    }

    .mobile-action-row button{
        width:100% !important;
        text-align:center !important;
        background-color: white !important;
        padding: 8px 0px;
        /* border: 1px solid #D1D5DB !important; */
    }

    .mobile-action-row .dropdown-toggle{
        position:static !important;
        right:auto !important;
        top:auto !important;
        margin-top:0 !important;
    }
    .dropdown_mobile {
        right: unset !important;
        top: unset !important;
        width: 100%;
    }
    .mobile_card_body {
        padding: 2rem 0px;
    }
    .mobile_12_col_1 {
        padding-left: unset;
        padding-right: unset;
    }
    .mobile_12_col_2 {
        padding-left: 13px;
        padding-right: 14px;
    }
    .mobile_12_col_3 {

    }
    .div-right-position {
        padding-left: unset !important;
        padding-right: unset !important;
    }
    .mobile_order_details_div {
        width: unset !important;
        left: unset !important;
        padding-left: unset !important;
        padding-right: unset !important;
    }
    .form-card-position {
        width: 100%;
        position: relative;
        left: unset;
        top: unset;
    }
    .card-body {
        padding: 1rem !important;
    }
    .padding_unset_mobile {
        padding-left: unset !important;
        padding-right: unset !important;
    }
    .padding_unset_mobile_l {
        padding-left: unset !important;
        /* padding-right: unset !important; */
    }
    .card {
        border-radius: .375rem;
    }
    .mobile_card_div {
        padding: unset !important;
        background-color: transparent;
    }
    .mobile_new_card_div {
        padding: 1rem;
        margin: unset;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0px 1px 3px 0px #0000000A;
        margin-bottom: 10px;
    }
    .mobile_card_div_1 {
        padding-bottom: unset !important;
    }
    .mobile_card_div_2 {
        padding-top: unset !important;
    }
    .mobile_timeline_div {
        margin-top: 10px !important;
    }
    .mobile_tracking_div {
        margin-top: 10px !important;
        padding-left: 15px !important;
    }
    .mobile_tracking_div_2 {
        border-radius: 8px;
    }
    .tab {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        white-space: nowrap;
        border-right: none !important;
        border-bottom: 1px solid #ddd;
        padding: 0 !important;
        margin-bottom: 15px;
        gap: 5px;
    }

    .tab button {
        flex: 1;
        min-width: fit-content;
        padding: 10px 15px;
        font-size: 11px;
        border: none;
        background: #f5f5f5;
        color: #555;
        transition: .3s;
        text-align: center !important;
    }

    .tab button.active {
        background-color: #e3e3e3 !important;
        color: #fff;
        font-weight: 600;
        border-radius: 5px;
        border: unset !important;
        border-right: unset !important;
        text-align: center;
    }
}
@media(max-width:768px){

    .desktop-player-table{
        border:0 !important;
        display: flex !important;
    }


    .desktop-player-table thead,
    .desktop-player-table tfoot{
        display:none;
    }


    /* Size card */
    .desktop-player-table tbody tr.player-size-row{
        background:white;
        /* margin-bottom:15px; */
        border-radius:12px;
        box-shadow:0 3px 12px rgba(0,0,0,0.12);
        /* border:1px solid #ddd; */
    }


    .desktop-player-table tbody tr.player-size-row th{
        width:80% !important;
        height:50px;
        background: transparent;
        padding-left:18px;
        font-size:15px;
        text-align: left;
    }
    .invoice_details th, .invoice_details td span {
        padding-top: 10px !important;
    }

    /* Hide all numbers initially */
    .mobile-number-row .mobile-player-cell{
        display:none;
    }


    /* Show numbers after expand */
    .mobile-number-row.active .mobile-player-cell{
        display:block;
    }


    /* 5 numbers per row */
    .mobile-number-row.active{
        display:flex !important;
        flex-wrap:wrap;
    }


    .mobile-number-row.active .mobile-player-cell{
        width:20% !important;
        padding:5px;
        border:0 !important;
    }


    .mobile-player-number{
        width:100%;
        height:40px;
        text-align:center;
    }
    .mobile-size-name{
        font-weight:600;
    }
    .mobile_row_width_100 {
        width: 100%;
        border-left: unset;
        border-right: unset;
    }
    .mobile_row_width_100 input {
        background-color: rgb(238, 238, 238);
    }
    .mobile-number-row {
        background: white;
        /* margin-bottom: 15px; */
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.12);
        /* border: 1px solid #ddd; */
    }
    .mobile-player-table {
        margin-left: unset;
    }
    .mobile-player-table tbody {
        width: 100%;
    }
}

@media (max-width:767px){

.roster-mobile-wrapper{

    height:auto !important;
    padding:10px !important;

}

.roster-size-sidebar{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:8px;

    max-width:100% !important;

    height:auto !important;

    background:#fff;

    padding:10px;

    border-radius:12px;

    box-shadow:0 2px 10px rgba(0,0,0,.08);
    width: 100% !important;

}

.roster-size-sidebar button{

    width:100% !important;

    margin:0 !important;

}

.roster-size-btn{

    width:100% !important;

    min-width:unset !important;

    border-radius:10px !important;

    padding:10px 6px !important;

    font-size:12px;

}

.roster-mobile-card{

    height:auto !important;

    /* overflow:visible !important; */

    background:#fff;

    border-radius:16px;

    padding:12px;

    margin-bottom:18px;

    box-shadow:0 4px 15px rgba(0,0,0,.08);

}

.roster-mobile-table{

    width:100%;

}

.roster-mobile-table thead{

    display:none;

}

.roster-mobile-table,

.roster-mobile-table tbody,

.roster-mobile-table tr,

.roster-mobile-table td{

    display:block;

    width:100%;

}

.roster-mobile-table tr{

    background:#fafafa;

    border-radius:14px;

    padding:12px;

    margin-bottom:14px;

    box-shadow:0 2px 8px rgba(0,0,0,.06);

}

.roster-mobile-table td{

    border:none !important;

    padding:6px 0 !important;

}

.roster-mobile-table td:nth-child(1)::before{

    content:"Size";

    display:block;

    font-size:11px;

    color:#777;

    font-weight:bold;

    margin-bottom:4px;

}

.roster-mobile-table td:nth-child(2)::before{

    content:"Number";

    display:block;

    font-size:11px;

    color:#777;

    font-weight:bold;

    margin-bottom:4px;

}

.roster-mobile-table td:nth-child(3)::before{

    content:"Player Name";

    display:block;

    font-size:11px;

    color:#777;

    font-weight:bold;

    margin-bottom:4px;

}

.roster-mobile-table input{

    width:100% !important;

}

.invoice-inputs,

.number_player,

.blank_players{

    border-radius:10px !important;

}
.card .table td {
    width: unset !important;
}
.container-fluid {
    margin-bottom: unset !important;
}

}
@media(max-width:575px){

    .roster-size-sidebar{

        grid-template-columns:repeat(2,1fr);

    }
    .control-btn-position {
        display: unset !important;
    }

}

@media(min-width:576px) and (max-width:767px){

    .roster-size-sidebar{

        grid-template-columns:repeat(3,1fr);

    }

}

@media (max-width: 768px) {

    .size-card-title {
        position: relative !important;
        padding-right: 28px !important;
        cursor: pointer;
    }

    .size-card-title::after {
        content: "❯";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        color: #999;
    }
}
    </style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
@media (max-width:768px){
    .flatpickr-calendar {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,.15);
        border: none;
    }
    .flatpickr-months {
        padding: 10px;
    }
    .flatpickr-weekday {
        font-weight: 600;
    }
    .flatpickr-day {
        border-radius: 50%;
    }
    .flatpickr-day.selected {
        background: #2563eb;
        border-color: #2563eb;
    }
    .flatpickr-day:hover {
        background: #e8f0ff;
    }
    /* @media(max-width:576px){ */
        .flatpickr-calendar {
            width: 320px;
            /* left: 2.5% !important; */
        }
    /* } */


}

@media (max-width: 768px){

    .mobile-number-row[class*="row1Hidden"],
    .mobile-number-row[class*="row2Hidden"],
    .mobile-number-row[class*="row3Hidden"],
    .mobile-number-row[class*="row4Hidden"] {
        display:none !important;
    }
    .numseq {
        text-align: center;
    }

    .order-roster-div{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .order-roster{
        font-size: 15px;
        white-space: nowrap;
    }

    .order-roster-div .TOTALqty{
        width: 55px;
        padding: 0 !important;
        font-size: 15px !important;
        font-weight: 700;
        text-align: center;
        background: transparent;
    }
    .functionalityBtn {
        border: unset !important;
    }
    .col-md-6.pdf-content {
        padding: unset;
    }
    .col-md-6.img-content {
        padding: unset;
    }
    .tabcontent {
        padding: unset;
    }
    .mobile_factory_photos_tab {
        padding: 15px 0px !important;
    }
    .detail-card-margin {
        margin: 15px 0px;
        padding: 15px 0px !important;
    }

}

@media (max-width:400px){
    .tab_bar_mobile .nav-link {
        border-bottom: unset !important;
        font-size: 8px !important;
    }
    .functionalityBtn {
        border: unset !important;
        font-size: 10px !important;
    }
}

@media (max-width: 767.98px) {

    /* =========================================
       CONTROL BUTTON CARD
       ========================================= */

    .modern-control-card {
        width: 100% !important;
        padding: 8px !important;
        margin: 10px 0 !important;

        border: none !important;
        border-radius: 14px !important;

        box-sizing: border-box !important;
        padding-right: unset !important;
    }


    /* =========================================
       BUTTON CONTAINER
       ========================================= */

    .modern-control-card .control-btns {
        width: 100% !important;

        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;

        gap: 8px !important;

        padding: 0 !important;
        margin: 0 !important;
    }


    /* =========================================
       MOBILE BUTTONS
       ========================================= */

    .modern-control-card .btn-custom {
        width: 100% !important;
        min-width: 0 !important;
        max-width: none !important;

        min-height: 46px !important;

        margin: 0 !important;
        padding: 8px 6px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        border-radius: 10px !important;

        font-size: 12px !important;
        font-weight: 600 !important;

        white-space: nowrap !important;

        box-sizing: border-box !important;

        transition: all 0.2s ease !important;
    }


    /* =========================================
       SUBTLE MOBILE HOVER / TOUCH EFFECT
       ========================================= */

    .modern-control-card .btn-custom:active {
        transform: scale(0.97) !important;
    }


    /* =========================================
       LIGHT BUTTONS
       Print / Download
       ========================================= */

    .modern-control-card .btn-light {
        border: 1px solid #dee2e6 !important;
    }


    /* =========================================
       DELETE
       Keep existing red color
       ========================================= */

    .modern-control-card .delete-order {
        border-radius: 10px !important;
    }


    /* =========================================
       SAVE
       Keep existing green color
       ========================================= */

    .modern-control-card #orderItemSaveBtn {
        border-radius: 10px !important;
    }
    .card.control-btn-card {
        width: 107%;
    }

}

@media (min-width: 1750px) {
    .form-card-position {
        width: 107%;
    }
}

</style>
<head>
    <link type="text/css" rel="stylesheet" href="{{ asset('argon') }}/file_inputs/css/fileinput.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" rel="stylesheet" type="text/css" />
</head>
    @section('back-btn')
        @if ($orderTrait->isInventoryOrder($order->organization_id))
            <a href="{{route('inventory_orders')}}" class="home-btn-color unsave_event_class" title="Back to Orders">BACK TO ORDERS</a>
        @else
            @if($order->plorder == 1)
                <a href="{{route('plorders')}}" class="home-btn-color unsave_event_class" title="Back to Orders">BACK TO ORDERS</a>
            @else
                <a href="{{route('orders')}}" class="home-btn-color unsave_event_class" title="Back to Orders">BACK TO ORDERS</a>
            @endif
        @endif
    @endsection

    @section('back-btn-Mobile')
        {{-- <a href="{{ route('home') }}" class="home-btn-color-mobile" title="Back to home">< BACK TO HOME</a> --}}
        {{-- @if ($orderTrait->isInventoryOrder($orders[0]->organization_id))
            <a href="{{route('inventory_orders')}}" class="home-btn-color home-btn-color-mobile unsave_event_class" title="Back to Orders">< BACK TO ORDERS</a>
        @else
            @if($orders[0]->plorder == 1)
                <a href="{{route('plorders')}}" class="home-btn-color home-btn-color-mobile unsave_event_class" title="Back to Orders">< BACK TO ORDERS</a>
            @else
            <a href="{{route('orders')}}" class="home-btn-color home-btn-color-mobile unsave_event_class" title="Back to Orders">< BACK TO ORDERS</a>
            @endif
        @endif --}}
        @if ($orderTrait->isInventoryOrder($order->organization_id))
            <a href="{{route('inventory_orders')}}" class="home-btn-color home-btn-color-mobile unsave_event_class" title="Back to Orders"> < BACK TO ORDERS</a>
        @else
            @if($order->plorder == 1)
                <a href="{{route('plorders')}}" class="home-btn-color home-btn-color-mobile unsave_event_class" title="Back to Orders"> < BACK TO ORDERS</a>
            @else
                <a href="{{route('orders')}}" class="home-btn-color home-btn-color-mobile unsave_event_class" title="Back to Orders"> < BACK TO ORDERS</a>
            @endif
        @endif
    @endsection

    <div class="col-md-12 back_home_mobile">
        <strong>
            @yield('back-btn-Mobile')
        </strong>
    </div>

    <div class="second-nav-place">
        <div class="col-md-12">
            <div class="row">
                <div class="row col-md-7 btn-place" id="nav-tab">
                    <div class="col-md-12">
                        <section id="tabs"  class="mobile_nav_tab">
                            <nav>
                                <div class="nav nav-btn nav-tabs nav-fill wrapper002 tab_bar_mobile" id="nav-tab" role="tablist" style="width: 65%;border:none !important">
                                    @if (request()->has('active_tab')) <input type="hidden" value="{{ request()->get('active_tab') }}" id="active_tab_id" /> @endif

                                    @if (request()->has('notify_field')) <input type="hidden" value="{{ request()->get('notify_field') }}" id="notify_field_id" /> @endif

                                    {{-- @can('manage orders' && 'view order details') --}}
                                    @can('manage orders')
                                        <a style="font-size: 0.7rem;border-bottom: 1px solid #b2b2b2" class="nav-btn-spec nav-item nav-link active btnlink01 unsave_event_class" id="invoice-tab" data-toggle="tab" href="#invoice_tab" role="tab" aria-controls="invoice" aria-selected="true"> ITEM DETAILS </a>
                                    @endcan

                                    @can('manage order management')
                                    <a style="font-size: 0.7rem;border-bottom: 1px solid #b2b2b2;" class="nav-btn-spec nav-item nav-link btnlink02 unsave_event_class" onclick="startLoading()" id="Management-tab" href="{{ url('order_details/edit',[$order->id,'management']) }}" aria-controls="Management" aria-selected="true">ORDER MANAGEMENT</a>
                                    @endcan

                                    @can('manage shipping')
                                        {{-- <a class="nav-btn-spec nav-item nav-link @if(!Gate::check('manage order management') && !Gate::check('manage orders') && Gate::check('manage shipping')) active @endif btnlink03" id="Shipping-tab" data-toggle="tab" href="#Shipping_tab" role="tab" aria-controls="Shipping" aria-selected="true">SHIPPING</a> --}}
                                        <a style="font-size: 0.7rem;border-bottom: 1px solid #b2b2b2;" class="nav-btn-spec nav-item nav-link btnlink03 unsave_event_class" onclick="startLoading()" id="Shipping-tab" href="{{ url('order_details/edit',[$order->id,'shipping']) }}" aria-controls="Shipping" aria-selected="true">SHIPPING</a>
                                    @endcan
                                </div>
                            </nav>
                        </section>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-12 btn-top btn-z container-fluid">

        <div class="row mobile-action-row" style="background-color: transparent;
                                    padding: 1%;
                                    border-radius: 1rem;
                                    margin: .1%;
                                    margin-right: .3%;">


                    <div class="ml-auto" style="border-right: 1px solid #b2b2b2;width:13%">
                        @can('generate url order detail')
                            <button class="btns-text btns-style btns-card btnor001 copy_credentials_btn functionalityBtn" value="{{ $order->id }}" id="copy_credentials_btn" title="Copy Customer Credentials" style="outline: unset;color: #b2b2b2;background: none;font-size: 0.7rem; text-align:end; cursor:pointer">
                                <i class="fa fa-key" aria-hidden="true"></i>&nbsp;&nbsp;COPY CREDENTIALS
                            </button>
                        @endcan

                    </div>
                    <div style="border-right: 1px solid #b2b2b2;width:8%">
                        @can('generate url order detail')
                            <button class="btns-text btns-style btns-card generate_link_btn btnor001 functionalityBtn" id="copy_link_btn" value="{{ $order->id }}"title="Copy URL" style="outline: unset;color: #b2b2b2;background: none;font-size: 0.7rem; text-align:end; cursor:pointer">
                                <i class="fa fa-clone" aria-hidden="true"></i>&nbsp;&nbsp;COPY URL
                            </button>
                        @endcan

                    </div>
                    <div style="border-right: 1px solid #b2b2b2">
                        <div class="dropdown dropdown_mobile">
                            <button class="btns-text btns-style btns-card dropdown-toggle functionalityBtn" type="button" id="generateDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 0.7rem;color: #b2b2b2;background: none;margin-top: 13%;outline:unset; cursor:pointer;position: relative;right:125%;top: 3px;" title="Export">
                                EXPORT
                            </button>
                            <div class="dropdown-menu" aria-labelledby="generateDropdown">
                                @can('generate quote order detail')
                                    <button class="dropdown-item generate_quote_btn" style="outline: unset;font-size: 0.7rem;" value="{{ $order->id }}" title="Download Quotation">QUOTATION</button>
                                @endcan
                                @can('generate invoice order detail')
                                    <button class="dropdown-item generate_invoice_btn" style="outline: unset;font-size: 0.7rem;" value="{{ $order->id }}" title="Download Invoice">INVOICE</button>
                                @endcan
                                @can('generate pdf order detail')
                                    <button class="dropdown-item generate_pdf_btn" style="outline: unset;font-size: 0.7rem;" value="{{ $order->id }}" title="Download PDF">PDF</button>
                                @endcan
                                @can('generate csv order detail')
                                    <button class="dropdown-item generate_csv_btn" style="outline: unset;font-size: 0.7rem;" value="{{ $order->id }}" title="Download CSV">CSV</button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div style="width: 8%;margin-left: 1%;">

                            <button type="button" class="btns-text btns-style btns-card btnor001 functionalityBtn" onclick="DownloadOrderItemFiles()"  style="position: relative; z-index: 0; outline: unset; color: #b2b2b2; background: none; font-size: 0.7rem; border: 1px solid #b2b2b2; cursor: pointer;">
                                <i class="fas fa-download"></i> All Files
                            </button>


                    </div>
                    <div style="width: 8%;margin-left: 1%;">
                        @can('re order')
                            <button class="btns-text btns-style btns-card btnor001 functionalityBtn" title="Re-order" data-toggle="modal" data-target="#re_order_modal" title="Re Order" style="position: relative; z-index: 0; outline: unset; color: #b2b2b2; background: none; font-size: 0.7rem; border: 1px solid #b2b2b2; cursor: pointer;">
                                RE-ORDER
                            </button>
                        @endcan

                    </div>

            </div>
        </div>
        <div class="row col-lg-12 card-head url-position" style="display:none">
            <div class="col-lg-5">
            </div>
            <div class="col-lg-7 control-btns link-div" style="margin-top: 0px;">
                <span id="link_container"></span>
                <button type="button" class="btn btn-sm btn-info btn-custom" style="display: none;"
                    id="copy_link_btn" title="Copy Link">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
        </div>
        <div class="container-fluid mb-5 btn-top">
            <div class="se-pre-con"></div>
            <div class="col-md-12 " style="margin-top: -12px;">
                <div class="">
                    <div class="card-body">
                        <section id="tabs">
                            <div class="  col-md-12 padding_unset_mobile">
                                <div class="row mt-4 ordetails001">
                                    <div class="col-md-12 padding_unset_mobile_l">
                                        <div class="tab-content py-3 px-3 px-sm-0 div-right-position" id="nav-tabContent">
                                            @can('manage orders')
                                                <div class="tab-pane fade show active" id="invoice_tab" role="tabpanel" aria-labelledby="invoice-tab">
                                                    {{-- @include('pages.order_management.orders.edit') --}}
                                                    <div class="tab-content py-3 px-3 px-sm-0 content-position padding_unset_mobile" id="nav-tabContent">
                                                        @can('view order items')
                                                        @php
                                                            $canChangeOrderItemStatus =  '0';
                                                            $orderItem = $order->orderItems[0];
                                                        @endphp
                                                        @can('change order item status')
                                                            @php
                                                                $canChangeOrderItemStatus =  '1';
                                                            @endphp
                                                        @endcan
                                                            <div class="tab-pane fade show active" id="tab_{{ $orderItem->id }}" role="tabpanel" aria-labelledby="tab_{{ $orderItem->id }}_link">
                                                                {{-- @include('pages.order_management.orders.edit_order_item_form') --}}
                                                                <div class="form-card-position">
                                                                    <form id="formItem{{ $orderItem->id }}" onsubmit="return orderItemUpdate();" method="POST" action="{{ route('order_sequence.update') }}" enctype="multipart/form-data" class="myForm form-position">
                                                                        @csrf
                                                                        <input type="hidden" id="order_id" name="id" value="{{ $order->id }}" />
                                                                        <input type="hidden" id="order_type" name="order_type" value="{{ $order->order_type }}" />
                                                                        <input type="hidden" id="address_type" name="address_type" value="{{ $order->address_type }}" />
                                                                        <input type="hidden" name="notify_changes" class="notify_changes" value="">

                                                                        <input type="hidden" name="address_type" value="{{ $order->address_type }}" />
                                                                        <input type="hidden" id="product_id_{{ $orderItem->product_id }}" name="product_id" value="{{ $orderItem->product_id }}" />
                                                                        <input type="hidden" name="item_id" value="{{ $order->id }}" />
                                                                        <input type="hidden" name="orderItem[{{ $orderItem->id }}][orderItemId]" value="{{ $orderItem->id }}" />
                                                                        <input type="hidden" name="order_id" value="{{ $order->id }}" id="order_id">
                                                                        <input type="hidden" name="order_item_id" id="orderItemId" value="{{ $orderItem->id }}">
                                                                        <input type="hidden" name="contact_id" value="{{ $order->contactDetails->id }}">
                                                                        <input type="hidden" name="organization_id" value="{{ $order->organizationDetails->id }}">
                                                                        <input type="hidden" class="item_is_urgent" name="item_is_urgent" id="item_is_urgent" value="">
                                                                        <input type="hidden" id="get_organization_name" value="{{ $order->organizationDetails->organization_name }}">

                                                                        <div class="row md-12 SpecificDiv">
                                                                            <div class="col-md-12">
                                                                                <span style="color: black;font-size: 1.4rem;font-weight: 700;">{{ $orderItem->is_studio_item == 1 ? 'Studio Item' : 'Item' }}&nbsp;</span> <span style="color: grey;font-size: 1.3rem;font-weight: 500;">|&nbsp;#{{ $orderItem->item_no }}</span>
                                                                            </div>
                                                                            <div class="col-md-6 mobile_card_div_1" style="padding: 8px;">
                                                                                <div class="card mobile_card_div" style="padding: 1rem;height: 100%;">
                                                                                    <div class="row mobile_new_card_div">
                                                                                        <div class="col-md-6">
                                                                                            <div class="col-md-12 sub_product_styles" style="padding-left: 0px;padding-right: 0px;">

                                                                                                <label for="order_no" class="form-label" style="margin-top:0rem">Style Name</label>
                                                                                                <select class="select2-edit-order"
                                                                                                    onchange="changeItemStyleName({{ $orderItem->id }})"
                                                                                                    name="orderItem[{{ $orderItem->id }}][styleName]" id="styleName" type='text'
                                                                                                    value='{{ $orderItem->sub_product_no }}'
                                                                                                    data-AlradySaved="{{ $orderItem->sub_product_no }}">
                                                                                                    @foreach ($subProducts as $subProduct)
                                                                                                    <option data-selected_price="{{$subProduct->default_price}}" data-attribute_on_price="{{$subProduct->attribute_on_price}}" value="{{ $subProduct->sub_product_no }}"
                                                                                                        @if ($subProduct->sub_product_no == $orderItem->sub_product_no) selected @php $displayName = $subProduct->product_name @endphp @endif @if($subProduct->active != 1) disabled @endif>
                                                                                                        {{ $subProduct->product_name }}
                                                                                                    </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;">
                                                                                                <label for="item_style_patter_code_{{ $orderItem->id }}" class="form-label">Pattern Code</label>
                                                                                                <input id="item_style_patter_code_{{ $orderItem->id }}" class="form-control"
                                                                                                        type="text"
                                                                                                        value="@if($orderItem->subProduct['pattern_code']) {{ $orderItem->subProduct['pattern_code'] }} @elseif ($orderItem->productDetails['pattern_code']) {{ $orderItem->productDetails['pattern_code'] }}  @else {{ '' }} @endif"
                                                                                                        readonly />
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            @can('show order price')
                                                                                            <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;">
                                                                                                <label for="unitprice_{{ $orderItem->id }}" class="form-label" style="margin-top: 0px;">Unit Price</label>
                                                                                                <input
                                                                                                            class="form-control"
                                                                                                            style="border: 1px solid #DEDEDE;border-radius:0rem"
                                                                                                            name="orderItem[{{ $orderItem->id }}][unitprice]"
                                                                                                            id="unitprice_{{ $orderItem->id }}" type='text'
                                                                                                            value="{{ number_format($orderItem->unit_price, 2) }}"
                                                                                                            data-AlradySaved="{{ $orderItem->unit_price }}" required />
                                                                                            </div>
                                                                                            @endcan
                                                                                            <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;">
                                                                                                <label for="order_status_id" class="form-label {{$canChangeOrderItemStatus}}">Item Status</label>
                                                                                                <select class=" select2-edit-order order-status-id order_item_status_id"
                                                                                                        name="orderItem[{{ $orderItem->id }}][order_status_id]" id="order_status_id"
                                                                                                        value="{{ $orderItem->order_status_id }}" data-item-id="{{ $orderItem->id }}"
                                                                                                        data-AlradySaved="{{ $orderItem->order_status_id }}">
                                                                                                        <option value="">Select Status</option>
                                                                                                        @foreach ($orderStatuses as $orderStatus)
                                                                                                            <option value="{{ $orderStatus->id }}"
                                                                                                                @if ($orderStatus->id == $orderItem->order_status_id) selected @endif
                                                                                                                @if (($orderStatus->id < $orderItem->order_status_id) && ($canChangeOrderItemStatus == '0')) disabled  @endif>
                                                                                                                {{ $orderStatus->status_name }}</option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mobile_new_card_div">
                                                                                        <div class="col-md-12 mt-1">
                                                                                            <label for="display_name" class="form-label">Display Name</label>
                                                                                            <input id="display_name" name="orderItem[{{ $orderItem->id }}][display_name]" class="form-control" type="text" value="@if (empty($orderItem->display_name))  @if(isset($displayName) && !empty($displayName)) {{$displayName}} @else {{" "}} @endif @else {{ $orderItem->display_name }} @endif" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mobile_new_card_div" style="padding-left: 0px;">
                                                                                        <div class="col-md-12 sub-header-style mt-3 mb-1">
                                                                                            Fabrics
                                                                                        </div>
                                                                                        <div class="col-md-6 col-6">
                                                                                            <label for="orderItem_primaryFabric_{{ $orderItem->id }}" class="form-label">Primary Fabric</label>
                                                                                            <select class="form-control select2-edit-order"
                                                                                            name="orderItem[{{ $orderItem->id }}][fabric]"
                                                                                            id="orderItem_primaryFabric_{{ $orderItem->id }}" type='text'
                                                                                            value='{{ $orderItem->fabric_id }}'
                                                                                            data-AlradySaved="{{ $orderItem->fabric_id }}">

                                                                                            @foreach ($fabrics as $fabric)
                                                                                                @if ($fabric->id == $orderItem->fabric_id)
                                                                                                    <option value="{{ $fabric->id }}"  selected >
                                                                                                        {{ $fabric->fabric_name }}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                        </div>
                                                                                        <div class="col-md-6 col-6">
                                                                                            <label for="secondary_fabric" class="form-label">Secondary Fabric</label>
                                                                                            <select class="form-control select2-edit-order"
                                                                                                name="orderItem[{{ $orderItem->id }}][secondary_fabric]" id="secondary_fabric"
                                                                                                type='text' value='{{ $orderItem->secondary_fabric_ic }}'
                                                                                                data-AlradySaved="{{ $orderItem->secondary_fabric_ic }}">
                                                                                                <option value="">Select Secondary Fabric</option>
                                                                                                @foreach ($fabrics as $fabric)
                                                                                                    <option value="{{ $fabric->id }}"
                                                                                                        @if ($fabric->id == $orderItem->secondary_fabric_id) selected @endif>
                                                                                                        {{ $fabric->fabric_name }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-6 col-6">
                                                                                            <label for="orderItem_estabilishment_{{ $orderItem->id }}" class="form-label">Embellishment</label>
                                                                                            @php
                                                                                                // $type_of_embellishment = str_replace(' ', '', $orderItem->subProduct->type_of_embellishment);
                                                                                                $embellishment_array = $orderItem->subProduct->embellishmentTypes->pluck('EmbellishmentDetails')->toArray();

                                                                                            @endphp
                                                                                            <select class="form-control select2-edit-order"
                                                                                                name="orderItem[{{ $orderItem->id }}][estabilishment]"
                                                                                                id="orderItem_estabilishment_{{ $orderItem->id }}"
                                                                                                value="{{ $orderItem->embellishment_type_id }}"
                                                                                                data-AlradySaved="{{ $orderItem->embellishment_type_id }}">
                                                                                                <option value="">Select Embellishment</option>
                                                                                                @foreach ($embellishment_array as $embellishmentType)
                                                                                                        <option value="{{ $embellishmentType['id'] }}"
                                                                                                            @if ($embellishmentType['id'] == $orderItem->embellishment_type_id) selected @endif>
                                                                                                            {{ $embellishmentType['embellishment_name'] }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-6 col-6">
                                                                                            <label for="factory" class="form-label">Factory</label>
                                                                                                    @php
                                                                                                        // Extract factory codes from $orderItem->productDetails->factory
                                                                                                        $product_factory = $orderItem->productDetails->productFactories;
                                                                                                        $product_factory_ids = [];

                                                                                                        foreach ($orderItem->productDetails->productFactories as $productFactory) {
                                                                                                            $product_factory_ids[] = $productFactory->product_factory_id;
                                                                                                        }
                                                                                                        // Convert $factories collection to array
                                                                                                        $factories_array = $factories->toArray();

                                                                                                        // Filter factories based on $product_factory_codes
                                                                                                        $filtered_factories = array_filter($factories_array, function ($factory) use ($product_factory_ids) {
                                                                                                            return in_array($factory['id'], $product_factory_ids);
                                                                                                        });
                                                                                                    @endphp
                                                                                            @if ($orderItem->factory_id)
                                                                                                    <select class=" select2-edit-order"
                                                                                                        name="orderItem[{{ $orderItem->id }}][factory]" id="factory"
                                                                                                        value="{{ $orderItem->factoryDetails['id'] }}"
                                                                                                        data-AlradySaved="{{ $orderItem->factoryDetails['id'] }}">
                                                                                                        <option value="">Select Factory</option>

                                                                                                        @foreach ($filtered_factories as $factory)
                                                                                                            <option value="{{ $factory['id'] }}"
                                                                                                                @if ($factory['id'] == $orderItem->factoryDetails['id']) selected @endif>
                                                                                                                {{ $factory['factory_code'] }}</option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                @else
                                                                                                    <select class=" select2-edit-order"
                                                                                                        name="orderItem[{{ $orderItem->id }}][factory]" id="factory"
                                                                                                        value="">
                                                                                                        <option value="">Select Factory</option>
                                                                                                        @foreach ($filtered_factories as $factory)
                                                                                                            <option value="{{ $factory['id'] }}">
                                                                                                                {{ $factory['factory_code'] }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                @endif
                                                                                        </div>
                                                                                        <div class="col-md-6 forClouser" style="display:{{!empty($orderItem->productDetails->id == 228) ? 'block':'none'}}" >
                                                                                            <label for="clouser_type_item" class="form-label">Closure Type</label>
                                                                                            <select class=" select2-edit-order"
                                                                                                name="orderItem[{{ $orderItem->id }}][clouser_type]" id="clouser_type_item" >
                                                                                                <option value="">Select Closure Type</option>
                                                                                                @foreach ($clouser_types as $clouser_type)
                                                                                                    <option value="{{$clouser_type->id}}" @if($orderItem->clouser_type == $clouser_type->id) selected @endif>{{$clouser_type->clouser_name}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mobile_new_card_div" style="margin: 0px">
                                                                                        <div class="col-md-12 sub-header-style mt-2 mb-2" style="padding-left: 0px">
                                                                                            Attributes
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <div class="row">
                                                                                                @foreach ($attributes as $attribute)
                                                                                                @php
                                                                                                    $is_chcked = App\Models\OrderItemAttribute::where('order_item_id' , $orderItem->id)->where('attribute_id' , $attribute->id)->exists();
                                                                                                @endphp
                                                                                                <div class="col-md-4 mb-2" style="padding: 0px;">
                                                                                                    <div class="custom-control custom-checkbox toggle-checkbox">
                                                                                                        <input data-attribute_price="{{$attribute->price}}" data-attribute_id="{{$attribute->id}}" name="orderItem[{{ $orderItem->id }}][item_attributes][{{$attribute->id}}]" type="checkbox" value="1"
                                                                                                        class="custom-control-input attribute_class_{{$attribute->id}} attribute_checkbox_change" id="attribute_no_{{$attribute->id}}_{{ $orderItem->id }}" {{ $is_chcked ? 'checked' : '' }} >
                                                                                                        <label class="custom-control-label" for="attribute_no_{{$attribute->id}}_{{ $orderItem->id }}">&nbsp;{{$attribute->attribute_name}}&nbsp;</label>
                                                                                                    </div>
                                                                                                </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                            @foreach ($attributeGroups as $attributeGroup)
                                                                                                <div class="row">
                                                                                                    @php
                                                                                                        $orderProductCategoryArr = optional($orderItem->productDetails->productCategories)->pluck('product_category_id')->toArray() ?? [];
                                                                                                    @endphp
                                                                                                    @if ( !empty( array_intersect($orderTrait->getProductCategoryIdInArray($attributeGroup->product_category_id), $orderProductCategoryArr) ) )
                                                                                                        @php
                                                                                                            $is_group_chcked = App\Models\OrderItemAttributeGroup::where('order_item_id' , $orderItem->id)->where('attribute_group_id' , $attributeGroup->id)->exists();
                                                                                                        @endphp
                                                                                                        <div class="col-md-4 mb-2" style="padding: 0px;">
                                                                                                            <div class="custom-control custom-checkbox toggle-checkbox">
                                                                                                                <input data-attribute_id="{{$attributeGroup->id}}" id="attribute_group_{{$attributeGroup->id}}_{{ $orderItem->id }}" name="orderItem[{{ $orderItem->id }}][item_attribute_groups][{{$attributeGroup->id}}]" type="checkbox" value="1"
                                                                                                                class="custom-control-input attribute_group_class" {{ $is_group_chcked ? 'checked' : '' }}>
                                                                                                                <label class="custom-control-label sub-header-style" for="attribute_group_{{$attributeGroup->id}}_{{ $orderItem->id }}">&nbsp;{{$attributeGroup->name}}&nbsp;</label>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                            @foreach ($attributeGroup->groupAttributes as $attribute)
                                                                                                                @php
                                                                                                                    $is_chcked = App\Models\OrderItemAttribute::where('order_item_id' , $orderItem->id)->where('attribute_id' , $attribute->attribute_id)->exists();
                                                                                                                @endphp
                                                                                                                <div class="col-md-4 mb-2 group-attribute-{{ $attributeGroup->id }}" style="padding: 0px; {{ $is_group_chcked ? '' : 'display: none;' }}">
                                                                                                                    <div class="custom-control custom-checkbox toggle-checkbox">
                                                                                                                        <input data-attribute_price="{{$attribute->attribute->price}}" data-attribute_id="{{$attribute->attribute_id}}" name="orderItem[{{ $orderItem->id }}][item_sub_attributes][{{$attributeGroup->id}}]" type="radio" value="{{$attribute->attribute_id}}"
                                                                                                                        class="custom-control-input attribute_class_{{$attribute->attribute_id}} attribute_group_class_{{$attributeGroup->id}} attribute_checkbox_change sub-attribute" id="attribute_no_{{$attribute->attribute_id}}_{{ $orderItem->id }}" {{ $is_chcked ? 'checked' : '' }} >
                                                                                                                        <label class="custom-control-label" for="attribute_no_{{$attribute->attribute_id}}_{{ $orderItem->id }}">&nbsp;{{$attribute->attribute->attribute_name ?? '' }}&nbsp;</label>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            @endforeach
                                                                                                </div>
                                                                                                    @else
                                                                                                        </div>
                                                                                                    @endif
                                                                                                {{-- </div> --}}
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="row mt-2 mobile_new_card_div">
                                                                                        <div class="col-md-6">
                                                                                            <div class="sub-header-style mt-1 mb-2">
                                                                                                Test print options
                                                                                            </div>
                                                                                            <div class="custom-control custom-checkbox">
                                                                                                <input type="checkbox" class="custom-control-input"
                                                                                                    id="test_print_needed_checkbox"
                                                                                                    name="orderItem[{{ $orderItem->id }}][test_print_needed]" {{ $orderItem->test_print_needed == 1 ? 'checked' : '' }}>
                                                                                                <label class="custom-control-label pt-1"
                                                                                                    for="test_print_needed_checkbox">&nbsp;Test Print Needed&nbsp;</label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 test_print_due_date" style="display: {{ $orderItem->test_print_needed == 1 ? 'block' : 'none' }}">
                                                                                            <div class="sub-header-style mt-1 mb-2">
                                                                                                Test Print Due Date
                                                                                            </div>
                                                                                                <input class="form-control datepicker" id="test_print_due_date_text" onchange="ShowErrorMessage()"
                                                                                                    name="orderItem[{{ $orderItem->id }}][test_print_due_date]"  type='text' @if($orderItem->test_print_due_date != NULL) value='{{$orderItem->test_print_due_date}}'  @endif />
                                                                                        </div>
                                                                                    </div>


                                                                                    <table class="table-font-size invoice_details table-border detail-card-margin table-width" style="display: none">
                                                                                        <tr>
                                                                                            <th>Unique Item # </th>
                                                                                            <th>:</th>
                                                                                            <td><input class="form-control" name="orderItem[{{ $orderItem->id }}][quality_control]"
                                                                                                    id="quality_control" type='text' value='{{ $orderItem->item_no }}' readonly />
                                                                                            </td>
                                                                                        </tr>

                                                                                    </table>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-6 mobile_card_div_2" style="padding: 8px;">
                                                                                <div class="card" style="padding: 1rem;">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 header-style mt-2 mb-1">
                                                                                            Customer
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <label for="team_name" class="form-label">Team Name</label>
                                                                                            <input class="form-control" name="team_name" id="team_name"
                                                                                                    type='text'
                                                                                                    value='{{ $order->organizationDetails['organization_name'] }}' readonly />
                                                                                        </div>
                                                                                        <div class="col-md-12">
                                                                                            <label for="shipping_recipient" class="form-label">Shipping Recipient</label>
                                                                                            <input class="form-control" type='text'
                                                                                                    value='{{ $order->contactDetails['title_name'] }} {{ $order->contactDetails['first_name'] }} {{ $order->contactDetails['last_name'] }}'
                                                                                                    readonly />
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="row" style="margin-top: .7rem;">
                                                                                        <div class="col-md-6 row">
                                                                                            <div class="col-md-12 sub-header-style mt-2 mb-1">
                                                                                                Ex-Factory Address
                                                                                            </div>
                                                                                            <div class="col-md-10">
                                                                                                {{-- <label for="shipping_recipient" class="form-label">Same as customer address</label> --}}
                                                                                                <select class=" ex-factory" id="exfactoryAddress" name="orderItem[{{ $orderItem->id }}][ex_factory_id]"
                                                                                                    required>
                                                                                                    <option value="0"  @if ($orderItem->ex_factory_id == 0) selected @endif>Same as Customer Address</option>
                                                                                                    <option value="add_new" data-type="add_new">+ Add New</option>
                                                                                                    {{-- <optgroup label="Contacts"> --}}
                                                                                                        {{-- @foreach ($order->organizationDetails->contactOrganizations as $contactdetails)
                                                                                                            @foreach ($contactdetails->contacts as $contact)
                                                                                                            <option value="{{ $contact->id }}" data-type="contact">
                                                                                                                    {{ $contact->first_name }} {{ $contact->last_name }} </option>
                                                                                                            @endforeach
                                                                                                        @endforeach --}}
                                                                                                    {{-- </optgroup> --}}
                                                                                                    <!-- Ex Factories Group -->
                                                                                                    {{-- <optgroup label="Ex Factories"> --}}
                                                                                                        @foreach ($exFactories as $exfactory)
                                                                                                            <option value="{{ $exfactory['id'] }}" data-type={{ $exfactory['type'] }} data-tableID={{ $exfactory['table_id'] }}
                                                                                                                @if (($orderItem->ex_factory_id == $exfactory['table_id']) && ($exfactory['type'] == 'exFactory')) selected @endif>
                                                                                                                {{ $exfactory['name'] }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    {{-- </optgroup> --}}
                                                                                                </select>
                                                                                                <input type="hidden" value="{{ $orderItem->id }}" class="item-id-by-ex-factory" />
                                                                                            </div>
                                                                                            <div class="col-md-12 ex-factory-address-line1 {{ $orderItem->id }} contactDetailsDiv" style="margin: 0px">
                                                                                                @if ($orderItem->ex_factory_id == 0)
                                                                                                        @if($order->is_new_shipping_address == 1)
                                                                                                            <input class="form-control" type='text' value='{{ $order->apartment }},{{ $order->street }}' readonly />
                                                                                                        @elseif($order->is_new_shipping_address == 3)
                                                                                                            <input class="form-control" type='text' value='{{ $order->contactDetails->apartment2 }},{{ $order->contactDetails->shipping_street_2 }}' readonly />
                                                                                                        @else
                                                                                                            <input class="form-control" type='text' value='{{ $order->contactDetails->apartment }},{{ $order->contactDetails->shipping_street }}' readonly />
                                                                                                        @endif

                                                                                                    @else
                                                                                                        <input class="form-control" type='text'
                                                                                                            value='{{ $orderItem->exFactoryDetails['apartment'] }},{{ $orderItem->exFactoryDetails['po_box'] }}' readonly />
                                                                                                    @endif
                                                                                            </div>
                                                                                            <div class="col-md-12 ex-factory-address-line2 {{ $orderItem->id }} contactDetailsDiv">
                                                                                                    @if ($orderItem->ex_factory_id == 0)
                                                                                                        @if($order->is_new_shipping_address == 1)
                                                                                                            <input class="form-control" type='text' value='{{ $order->city }} ,{{ $order->state }} ,{{ $order->postal_code }}'readonly />
                                                                                                        @elseif($order->is_new_shipping_address == 3)
                                                                                                            <input class="form-control" type='text' value='{{ $order->contactDetails->shipping_city_2 }} ,{{ $order->contactDetails->shipping_state_2 }} ,{{ $order->contactDetails->shipping_zip_2 }}'readonly />
                                                                                                        @else
                                                                                                        <input class="form-control" type='text' value='{{ $order->contactDetails->shipping_city }} ,{{ $order->contactDetails->shipping_state }}, {{ $order->contactDetails->shipping_zip }}'readonly />
                                                                                                        @endif

                                                                                                    @else
                                                                                                        <input class="form-control" type='text'
                                                                                                            value='{{ $orderItem->exFactoryDetails['city'] }}, {{ $orderItem->exFactoryDetails['state'] }},{{ $orderItem->exFactoryDetails['postal_code'] }}'
                                                                                                            readonly />
                                                                                                    @endif
                                                                                            </div>
                                                                                            <div class="col-md-12 ex-factory-address-line3 {{ $orderItem->id }} contactDetailsDiv">
                                                                                                @if ($orderItem->ex_factory_id == 0)
                                                                                                    @if($order->is_new_shipping_address == 1)
                                                                                                        <input class="form-control" type='text' value='{{ $order->country }}'readonly />
                                                                                                    @elseif($order->is_new_shipping_address == 3)
                                                                                                        <input class="form-control" type='text' value='{{ $order->contactDetails->shipping_country_2 }}'readonly />
                                                                                                    @else
                                                                                                        <input class="form-control" type='text' value='{{ $order->contactDetails->shipping_country }}'readonly />
                                                                                                    @endif
                                                                                                @else
                                                                                                    <input class="form-control" type='text'
                                                                                                        value='{{ $orderItem->exFactoryDetails['country'] }}'
                                                                                                        readonly />
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 row">

                                                                                            <div class="col-md-12 sub-header-style mt-2 mb-1">
                                                                                                Contact details
                                                                                                <table style="width: 100%;margin-top: 4%;">
                                                                                                    <tr>
                                                                                                        <td style="color: #717070"><i class="fa fa-phone" aria-hidden="true"></i></td>
                                                                                                        <td style="color: #717070">
                                                                                                            <input class="form-control" type='text' value='{{ $order->phone_no }}'
                                                                                                            style="background-color: transparent;"
                                                                                                            readonly />
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td style="color: #717070">
                                                                                                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                                                                                        </td>
                                                                                                        <td style="color: #717070">
                                                                                                            <input class="form-control" type='text' value='{{ $order->email }}'
                                                                                                            style="background-color: transparent;"
                                                                                                            readonly />
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="row mobile_timeline_div" style="margin-top: 16px;">
                                                                                        <div class="col-md-6" style="padding-right: 16px;">
                                                                                            <div class="card">
                                                                                                <div class="col-md-12 sub-header-style mt-2 mb-1">
                                                                                                    Timeline
                                                                                                </div>

                                                                                                <input class="form-control datepicker"
                                                                                                            name="orderItem[{{ $orderItem->id }}][open_date]" id="item_open_date" type='hidden'
                                                                                                            value='{{ $orderItem->open_date }}' readonly />


                                                                                                <div class="col-md-12" style="margin-bottom: 16px;">
                                                                                                    <label for="item_customer_InHand_date_{{ $orderItem->id }}" class="form-label">Customer In Hand Date</label>
                                                                                                    <input class="form-control datepicker item-in-hand-due-date"
                                                                                                            id="item_customer_InHand_date_{{ $orderItem->id }}"
                                                                                                            onchange="changeItemCustomerInHandDate({{ $orderItem->id }})"
                                                                                                            name="orderItem[{{ $orderItem->id }}][in_hand_by]" type='text'
                                                                                                            value='{{ $orderItem->in_hand_due_date }}'

                                                                                                            data-AlradySaved="{{ $orderItem->in_hand_due_date }}" />
                                                                                                </div>

                                                                                                <div class="col-md-12">
                                                                                                    <label for="item_ex_factory_date_{{ $orderItem->id }}" class="form-label">Ex-Factory Date</label>
                                                                                                    <i class="fa fa-info-circle ViewItemExFactoryDateLog"   style="color:#ebeb00; cursor:pointer"></i>
                                                                                                    <input class="form-control datepicker item-ex-factory-date"
                                                                                                            id="item_ex_factory_date_{{ $orderItem->id }}"
                                                                                                            onchange="comfirmchangeItemExFactoryDate({{ $orderItem->id }})"
                                                                                                            name="orderItem[{{ $orderItem->id }}][ex_factory_date]" type='text'
                                                                                                            value='{{ $orderItem->ex_factory_date }}'
                                                                                                            style="margin-bottom: 1.3rem;"
                                                                                                            data-AlradySaved="{{ $orderItem->ex_factory_date }}" />
                                                                                                </div>

                                                                                                <div class="col-md-12 mb-2"  @if ($order->order_type == 0 || ($order->order_type == 1 && $order->address_type == 2)) style="display: none" @endif>
                                                                                                    <label for="item_encore_packing_date_{{ $orderItem->id }}" class="form-label">Encore Packing Date</label>
                                                                                                    <input class="form-control datepicker item-encore-packing-date"
                                                                                                            id="item_encore_packing_date_{{ $orderItem->id }}"
                                                                                                            onchange="changeItemEncorePackingDate({{ $orderItem->id }})"
                                                                                                            name="orderItem[{{ $orderItem->id }}][encore_packing_date]" type='text'
                                                                                                            value='{{ $orderItem->encore_packing_date }}'
                                                                                                            data-AlradySaved="{{ $orderItem->encore_packing_date }}" />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 mobile_tracking_div" style="padding-left: 0px;">
                                                                                            <div class="mobile_tracking_div_2" style="height: 100%;background-color: white;">
                                                                                            <div class="card cardInsideBox">
                                                                                                <div class="col-md-12 sub-header-style mt-2 mb-1" style="padding-left: 16px;">
                                                                                                    Item tracking
                                                                                                </div>
                                                                                                <div class="col-md-12">
                                                                                                    <label for="factory" class="form-label">Tracking No</label>
                                                                                                    <input class="form-control"
                                                                                                                    name="orderItem[{{ $orderItem->id }}][tracking_no]"
                                                                                                                    id="tracking_no_{{ $orderItem->id }}" type='text'
                                                                                                                    value="{{ $orderItem->tracking_no }}"
                                                                                                                    data-AlradySaved="{{ $orderItem->tracking_no }}" @if(!Gate::check('show order price')) disabled @endif />
                                                                                                </div>
                                                                                                <div class="col-md-12" style="padding-bottom: 2.25rem;">
                                                                                                    <label for="factory" class="form-label">Tracking Link</label>
                                                                                                    <input class="form-control" name="orderItem[{{ $orderItem->id }}][tracking_link]"
                                                                                                                    id="tracking_link_{{ $orderItem->id }}" type='text'
                                                                                                                    value="{{ $orderItem->tracking_link }}"
                                                                                                                    data-AlradySaved="{{ $orderItem->tracking_link }}"  @if(!Gate::check('show order price')) disabled @endif />
                                                                                                                @if ($orderItem->tracking_link != null)
                                                                                                                    <a target="_blank" href="{{ $orderItem->tracking_link }}"
                                                                                                                        class="btn btn-custom btn-info">
                                                                                                                        <i class="fas fa-external-link-alt"></i>
                                                                                                                    </a>
                                                                                                                @endif
                                                                                                </div>
                                                                                            </div>
                                                                                            </div>
                                                                                        </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        {{-- order discription --}}
                                                                        <div class="row" style="padding-left: .5rem;padding-right: .5rem;">
                                                                            <div class="card col-md-12 ForBorderStyles">
                                                                                    <div class="col-md-12" style="padding: 0px;">
                                                                                        <label for="factory" class="form-label" style="font-size: 1rem;font-weight: 700;">Item Description</label>
                                                                                        <textarea class="form-control" name="orderItem[{{ $orderItem->id }}][item_description]"
                                                                                        style="margin-bottom:16px;height:55px"

                                                                                        id="item_description" type='text' value='{{ $orderItem->item_description }}'
                                                                                                    data-AlradySaved="{{ $orderItem->item_description }}"
                                                                                        placeholder="Is there anything else you want to let us know about this order?"
                                                                                                    >{{ $orderItem->item_description }}</textarea>

                                                                                    </div>
                                                                            </div>
                                                                        </div>

                                                                        {{-- design files --}}
                                                                        <div class="row mt-2 for-style-paste" style="margin-right: -7px; margin-left: -7px;">
                                                                            <div class="card col-md-12">
                                                                                <div class="col-md-12 detail-card-margin row" style="margin-left: 0px; padding-left:0px !important">
                                                                                    <div class="col-md-12 header-style mt-2 mb-1" style="padding-left:0px margin-bottom: 12px !important;">
                                                                                        Design files
                                                                                    </div>
                                                                                    <div class="tab col-lg-2" style="border-right: 1px solid rgb(204, 204, 204) !important; padding-right: unset; margin-bottom: 15px; padding-left: unset;">
                                                                                        {{-- <button type="button" class="tablinks active"
                                                                                            onclick="openTab(event, 'mock_up_tab_{{ $orderItem->id }}')">MOCK UP</button> --}}
                                                                                        <button type="button" class="tablinks"
                                                                                            onclick="openTab(event, 'teck_pack_tab_{{ $orderItem->id }}')">TECH PACK</button>
                                                                                        {{-- <button type="button" class="tablinks"
                                                                                            onclick="openTab(event, 'production_layout_tab_{{ $orderItem->id }}')">PRODUCTION LAYOUT</button> --}}
                                                                                        <button type="button" class="tablinks"
                                                                                            onclick="openTab(event, 'factory_photos_tab_{{ $orderItem->id }}')">TEST PRINT</button>
                                                                                        <button type="button" class="tablinks"
                                                                                            onclick="openTab(event, 'product_picture_tab_{{ $orderItem->id }}')">PRODUCT PHOTOS</button>
                                                                                    </div>
                                                                                    <div id="mock_up_tab_{{ $orderItem->id }}" class="tabcontent col-lg-10" style="display: none;">
                                                                                        <div class="card-body" style="padding: .4rem; margin-top:unset; padding-bottom: 1rem; padding-top: unset;">
                                                                                            <div class="row">
                                                                                                <div class="col-md-12 img-content">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-6">
                                                                                                            <label class="form-lable" style="display: contents; color:black; font-weight: 600;">Mockup Images</label><br>
                                                                                                            <label class="form-lable" style="display: contents; color:black; ">Accepted file format JPG. (Max size 10 MB)</label>
                                                                                                        </div>
                                                                                                        <div class="col-md-6" style="text-align: right">
                                                                                                            <button type="button" class="upload_button" onclick="triggerMockupImageInput('{{ $orderItem->id }}')">UPLOAD IMAGES</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <input id="mock_up_images_{{ $orderItem->id }}"
                                                                                                        name="mock_up_images[{{ $orderItem->id }}][]"
                                                                                                        class="no-notify file-insert-field" data-browse-on-zone-click="true"
                                                                                                        type="file" multiple>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="teck_pack_tab_{{ $orderItem->id }}" class="tabcontent col-lg-10" style="display: block;">
                                                                                        <div class="card-body" style="padding: .4rem; margin-top:unset; padding-bottom: 1rem;">
                                                                                            <div class="row">
                                                                                                <div class="col-md-6 pdf-content">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-9">
                                                                                                            <label class="form-lable" style="display: contents;color:black;  font-weight: 600;">Tech Pack Files</label><br>
                                                                                                            <label class="form-lable" style="display: contents;color:black;">Accepted file format PDF. (Max size 10 MB)</label>
                                                                                                        </div>
                                                                                                        <div class="col-md-3" style="text-align: right; padding:unset; padding-right: 15px;">
                                                                                                            <button type="button" class="upload_button" onclick="triggerTechPackFileInput('{{ $orderItem->id }}')">UPLOAD FILES</button>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <input id="teck_pack_files_{{ $orderItem->id }}" class="no-notify"
                                                                                                        name="teck_pack_files[{{ $orderItem->id }}][]"
                                                                                                        data-browse-on-zone-click="true" type="file" multiple>
                                                                                                </div>

                                                                                                <div class="col-md-6 img-content">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-9">
                                                                                                            <label class="form-lable" style="display: contents;color:black; font-weight: 600;">Tech Pack Images</label><br>
                                                                                                            <label class="form-lable" style="display: contents;color:black;">Accepted file format JPG. (Max size 10 MB)</label>
                                                                                                        </div>
                                                                                                        <div class="col-md-3" style="text-align: right; padding:unset; padding-right: 15px;">
                                                                                                            <button type="button" class="upload_button" onclick="triggerTechPackImageInput('{{ $orderItem->id }}')">UPLOAD IMAGES</button>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <input id="teck_pack_images_{{ $orderItem->id }}"
                                                                                                        name="teck_pack_images[{{ $orderItem->id }}][]" class="no-notify"
                                                                                                        data-browse-on-zone-click="true" type="file" multiple>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="production_layout_tab_{{ $orderItem->id }}" class="tabcontent col-lg-10">
                                                                                        <div class="card-body" style="padding: .4rem; margin-top:unset; padding-bottom: 1rem;">
                                                                                            <div class="row">
                                                                                                <div class="col-md-12 img-content">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-6">
                                                                                                            <label class="form-lable" style="display: contents;color:black; font-weight: 600;">Production Layout</label><br>
                                                                                                            <label class="form-lable" style="display: contents;color:black">Accepted file format JPG. (Max size 10 MB)</label>
                                                                                                        </div>
                                                                                                        <div class="col-md-6" style="text-align: right">
                                                                                                            <button type="button" class="upload_button" onclick="triggerProductionImageInput('{{ $orderItem->id }}')">UPLOAD IMAGES</button>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <input id="production_layout_images_{{ $orderItem->id }}"
                                                                                                        name="production_layout_images[{{ $orderItem->id }}][]"
                                                                                                        data-browse-on-zone-click="true" type="file" multiple
                                                                                                        class="no-disable-factory no-notify">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div id="factory_photos_tab_{{ $orderItem->id }}" class="tabcontent col-lg-10">
                                                                                        <div class="card-body mobile_factory_photos_tab" style="padding: .4rem; margin-top:unset; padding-bottom: 1rem;">
                                                                                            <div class="row">
                                                                                                <div class="col-md-12 img-content">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-6">
                                                                                                            <label class="form-lable" style="display: contents;color:black; font-weight: 600;">Test Print</label><br>
                                                                                                            <label class="form-lable" style="display: contents;color:black">Accepted file format JPG. (Max size 10 MB)</label>
                                                                                                        </div>
                                                                                                        <div class="col-md-6" style="text-align: right">
                                                                                                            <button type="button" class="upload_button" onclick="triggerTestImageInput('{{ $orderItem->id }}')">UPLOAD IMAGES</button>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <input id="test_print_images_{{ $orderItem->id }}"
                                                                                                        name="test_print_images[{{ $orderItem->id }}][]"
                                                                                                        class="no-disable-factory no-notify" data-browse-on-zone-click="true"
                                                                                                        type="file" multiple>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div id="product_picture_tab_{{ $orderItem->id }}" class="tabcontent col-lg-10">
                                                                                        <div class="card-body" style="padding: .4rem; margin-top:unset; padding-bottom: 1rem;">
                                                                                            <div class="row">
                                                                                                <div class="col-md-6 img-content">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-9">
                                                                                                            <label class="form-lable" style="display: contents;color:black; font-weight: 600;">Raw Photos</label><br>
                                                                                                            <label class="form-lable" style="display: contents;color:black">Accepted file format JPG. (Max size 10 MB)</label>
                                                                                                        </div>
                                                                                                        <div class="col-md-3" style="text-align: right; padding:unset; padding-right: 15px;">
                                                                                                            <button type="button" class="upload_button" onclick="triggerRowPhotosInput('{{ $orderItem->id }}')">UPLOAD PHOTOS</button>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <input id="product_picture_raw_images_{{ $orderItem->id }}"
                                                                                                        name="product_picture_raw_images[{{ $orderItem->id }}][]"
                                                                                                        class="no-disable-factory no-notify" data-browse-on-zone-click="true"
                                                                                                        type="file" multiple>
                                                                                                </div>

                                                                                                <div class="col-md-6 img-content">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-9">
                                                                                                            <label class="form-lable" style="display: contents;color:black; font-weight: 600;">Edited Photos</label><br>
                                                                                                            <label class="form-lable" style="display: contents;color:black">Accepted file format JPG. (Max size 10 MB)</label>
                                                                                                        </div>
                                                                                                        <div class="col-md-3" style="text-align: right; padding:unset; padding-right: 15px;">
                                                                                                            <button type="button" class="upload_button" onclick="triggerEditedPhotosInput('{{ $orderItem->id }}')">UPLOAD PHOTOS</button>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <input id="product_picture_edited_images_{{ $orderItem->id }}"
                                                                                                        name="product_picture_edited_images[{{ $orderItem->id }}][]"
                                                                                                        class="no-disable-factory no-notify" data-browse-on-zone-click="true"
                                                                                                        type="file" multiple>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        {{-- name number rosters --}}
                                                                        <div class="item-details-div forStyles" style="margin-right: -7px; margin-left: -7px;">
                                                                            {{-- <span class="item-details-font">Item Details</span> --}}
                                                                        </div>
                                                                        <div class="card" style="margin-right: -7px; margin-left: -7px;">
                                                                            <nav>
                                                                                <div class="order-roster-div">
                                                                                    <span class="order-roster">Item Roster - Total Quantity  -  </span>
                                                                                    <span><input type='text' class="TOTALqty"
                                                                                        style="padding: 10px; border:unset; font-size: 20px; font-weight: 700; color: black;"
                                                                                        name="orderItem[{{ $orderItem->id }}][TOTALqty]"
                                                                                        id="TOTALqty_{{ $orderItem->id }}" value=""
                                                                                        data-AlradySaved="" readonly /></span>

                                                                                </div>
                                                                                <div class="nav nav-tabs nav-fill" id="nav-tab4" role="tablist" style="margin-left: 13px; border-bottom: 1px solid #bbbbbb;">
                                                                                    <a style="max-width: 165px;" class="nav-item qty-summary item-topic without-blank" id="qtySummary_{{ $orderItem->id }}"
                                                                                        data-toggle="tab" href="#qtySummary_tab_{{ $orderItem->id }}" role="tab"
                                                                                        aria-controls="invoice" aria-selected="true">QUANTITY</a>

                                                                                    <a  style="max-width: 160px;"
                                                                                        class="nav-item rosterPlayerNumberSection item-topic"
                                                                                        id="orderRoster_{{ $orderItem->id }}"
                                                                                        data-toggle="tab"
                                                                                        href="#orderRoster_tab_{{ $orderItem->id }}"
                                                                                        role="tab"
                                                                                        aria-controls="invoice"
                                                                                        data-sectionLinks="formRosterPlayerNumber{{$orderItem->id}}"
                                                                                        data-section="rosterPlayerNumber"
                                                                                        aria-selected="true">NUMBER ROSTER</a>

                                                                                    <a  style="max-width: 135px;"
                                                                                        class="nav-item rosterPlayerNameSection item-topic"
                                                                                        id="orderRosterName_{{ $orderItem->id }}"
                                                                                        data-sectionLinks="formRosterPlayerNames{{$orderItem->id}}"
                                                                                        data-toggle="tab"
                                                                                        href="#orderRosterName_tab_{{ $orderItem->id }}"
                                                                                        role="tab"
                                                                                        aria-controls="invoice"
                                                                                        data-section="rosterPlayerNames"
                                                                                        aria-selected="true">NAME ROSTER</a>

                                                                                </div>
                                                                            </nav>
                                                                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                                                                <div class="tab-pane fade show container1 qtySumary{{$orderItem->id}} " id="qtySummary_tab_{{ $orderItem->id }}" role="tabpanel" aria-labelledby="qtySummary_{{ $orderItem->id }}">
                                                                                    @php $activeStatus = "active"; @endphp
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 mt-1 qty-container">
                                                                                            <table class=" table-font-size invoice_details table-border detail-card-margin"
                                                                                                id="product_qty_details_table">
                                                                                                <thead>

                                                                                                    <tr style="background-color: #878787; height: 35px; color: white;font-size: .75rem;">
                                                                                                        <th class="text-center" style="">SIZES</th>

                                                                                                        <th class="text-center">QUANTITY</th>
                                                                                                    </tr>
                                                                                                </thead>

                                                                                                @php
                                                                                                    $productSizes = [31, 1, 2, 3, 4, 5, 6, 7, 8, 9, 26, 17, 18, 19, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 25, 16, 28, 29];

                                                                                                    $orderItemDetails = $orderItem->orderItemDetails;

                                                                                                    $orderItemDetails = $orderItemDetails->sortBy(function ($item) use ($productSizes) {
                                                                                                        return array_search($item->sizeDetails['id'], $productSizes, true);
                                                                                                    });
                                                                                                @endphp
                                                                                                <tbody>
                                                                                                    @php
                                                                                                        $hasNA = $orderItemDetails->contains(function ($detail) {
                                                                                                            return $detail->sizeDetails['size_name'] == 'N/A';
                                                                                                        });
                                                                                                    @endphp

                                                                                                    @foreach ($orderItemDetails as $orderItemDetail)

                                                                                                            <tr id="orderRow_" style="height: 40px; @if( ($orderItemDetail->sizeDetails['size_name'] != 'N/A') && $hasNA)display: none; @endif">
                                                                                                                @if ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size One')
                                                                                                                    <th style="VERTICAL-ALIGN: MIDDLE; border-bottom: 1px solid #bbbbbb; border-left: 1px solid #bbbbbb;"
                                                                                                                        {{-- class=" {{ $orderItemDetail->id . 'rowspans' }}" --}}
                                                                                                                        >

                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            class="extra-size-font invoice-inputs hi-50 txtSizeName"
                                                                                                                            name="orderItem[{{ $orderItem->id }}][updated_extra_size]"
                                                                                                                            value="@if ($orderItem->extra_size == '1') {{ 'Extra Size One' }} @else {{ $orderItem->extra_size }} @endif"
                                                                                                                            data-AlradySaved="@if ($orderItem->extra_size == '1') {{ 'Extra Size One' }} @else {{ $orderItem->extra_size }} @endif" />
                                                                                                                    </th>
                                                                                                                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Two')
                                                                                                                    <th style="VERTICAL-ALIGN: MIDDLE; border-bottom: 1px solid #bbbbbb; border-left: 1px solid #bbbbbb;"
                                                                                                                        {{-- class=" {{ $orderItemDetail->id . 'rowspans' }}" --}}
                                                                                                                        ><input
                                                                                                                        type="text"
                                                                                                                        class="extra-size-font invoice-inputs hi-50 txtSizeName"
                                                                                                                        name="orderItem[{{ $orderItem->id }}][updated_extra_size_two]"
                                                                                                                        value="@if ($orderItem->extra_size_two == '1') {{ 'Extra Size Two' }} @else {{ $orderItem->extra_size_two }} @endif"
                                                                                                                        data-AlradySaved="@if ($orderItem->extra_size_two == '1') {{ 'Extra Size Two' }} @else {{ $orderItem->extra_size_two }} @endif" />
                                                                                                                    </th>
                                                                                                                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Three')
                                                                                                                    <th style="VERTICAL-ALIGN: MIDDLE;  border-bottom: 1px solid #bbbbbb; border-left: 1px solid #bbbbbb;"
                                                                                                                        {{-- class=" {{ $orderItemDetail->id . 'rowspans' }}" --}}
                                                                                                                        ><input
                                                                                                                        type="text"
                                                                                                                        class="extra-size-font invoice-inputs hi-50 txtSizeName"
                                                                                                                        name="orderItem[{{ $orderItem->id }}][updated_extra_size_three]"
                                                                                                                        value="@if ($orderItem->extra_size_three == '1') {{ 'Extra Size Three' }} @else {{ $orderItem->extra_size_three }} @endif"
                                                                                                                        data-AlradySaved="@if ($orderItem->extra_size_three == '1') {{ 'Extra Size Three' }} @else {{ $orderItem->extra_size_three }} @endif" />
                                                                                                                    </th>
                                                                                                                @else

                                                                                                                    <th style="VERTICAL-ALIGN: MIDDLE; position: relative; border-bottom: 1px solid #bbbbbb; border-left: 1px solid #bbbbbb;"
                                                                                                                        {{-- class="{{ $orderItemDetail->id . 'rowspans' }} " --}}
                                                                                                                        >
                                                                                                                        <span style="padding-left: 10px; ">{{ $orderItemDetail->sizeDetails['size_name'] }}</span>
                                                                                                                    </th>
                                                                                                                @endif


                                                                                                                <td class="size-specific" style="VERTICAL-ALIGN: MIDDLE; border-left: 1px solid #bbbbbb; border-bottom: 1px solid #bbbbbb; border-right: 1px solid #bbbbbb;"

                                                                                                                id="myElement" data-size="{{ $orderItemDetail->sizeDetails['size_name'] }}"
                                                                                                                    {{-- class="{{ $orderItemDetail->id . 'rowspans' }}" --}}
                                                                                                                    >
                                                                                                                    <input class="form-control text-center blankseq"


                                                                                                                        name="product[{{ $orderItemDetail->id }}][blanks]"
                                                                                                                        type='number' value="{{ $orderItemDetail->blanks }}"
                                                                                                                        data-AlradySaved="{{ $orderItemDetail->blanks }}"
                                                                                                                        data-size="{{ $orderItemDetail->sizeDetails['size_name'] }}" />
                                                                                                                    <input class="form-control text-center"
                                                                                                                        name="product[{{ $orderItemDetail->id }}][orderNo]"
                                                                                                                        value="{{ $orderItemDetail->id }}"
                                                                                                                        data-AlradySaved="{{ $orderItemDetail->id }}"
                                                                                                                        type='hidden' />
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                    @endforeach

                                                                                                </tbody>
                                                                                                <tfoot>
                                                                                                    <tr style=" background-color: #e4e4e4;">

                                                                                                        <th style="VERTICAL-ALIGN: MIDDLE; height:40px">

                                                                                                            <span style="padding-left: 10px; color: black">
                                                                                                                TOTAL QTY
                                                                                                            </span>
                                                                                                        </th>
                                                                                                       <td class="">
                                                                                                            <input class="form-control hi-69 text-center TOTALblanks"

                                                                                                            style="border: unset; background-color: transparent;"

                                                                                                                {{-- name="orderItem[{{ $orderItem->id }}][TOTALblanks]" --}}
                                                                                                                id="TOTALblanks_{{ $orderItem->id }}" type='text'
                                                                                                                value="" data-AlradySaved="" readonly />
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tfoot>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane container2 fade formRosterPlayerNumber{{ $orderItem->id }}" id="orderRoster_tab_{{ $orderItem->id }}" role="tabpanel" aria-labelledby="orderRoster_{{ $orderItem->id }}">

                                                                                    <div class="row">
                                                                                        <div class="col-md-12 text-right">
                                                                                            <button type="button"
                                                                                                class="btn btn-info btn-sm btn-secondary-custom roster-copy copy-btn"
                                                                                                value="{{ $orderItem->id }}">Copy</button>
                                                                                            <button type="button" class="btn btn-info btn-sm btn-secondary-custom roster-paste"
                                                                                                value="{{ $orderItem->id }}" style="display: none;">Paste</button>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-1 roster-container">
                                                                                            <table class="table-font-size invoice_details table-border detail-card-margin mobile-player-table desktop-player-table" id="product_details_table">
                                                                                                <thead>
                                                                                                    <tr  style="background-color: #878787; height: 45px; color: white;">
                                                                                                        {{-- <th class="text-center">BLANK<br>QTY</th> --}}
                                                                                                        {{-- <th class="text-center">QUANTITY</th> --}}
                                                                                                        <th style="width: 4%;" class="text-center">SIZES</th>
                                                                                                        <th style="width: 2%;" class="text-center">QTY</th>
                                                                                                        <th style="width: 80%;" colspan="25"> <span style="position: relative; left: 10px;">NUMBER SEQUENCE</span></th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                @php
                                                                                                    $productSizes = [31,1, 2, 3, 4, 5, 6, 7, 8, 9, 26, 17, 18, 19, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 25, 16, 28, 29];
                                                                                                    $sizeIdsToHide = [18, 19, 21, 22, 24, 25];
                                                                                                    $orderItemDetails = $orderItem->orderItemDetails;

                                                                                                    $orderItemDetails = $orderItemDetails->sortBy(function ($item) use ($productSizes) {
                                                                                                        return array_search($item->sizeDetails['id'], $productSizes, true);
                                                                                                    });

                                                                                                    function areFieldsEmpty($fields, $orderItemDetail) {
                                                                                                        foreach ($fields as $field) {
                                                                                                            if (!empty($orderItemDetail->{$field})) {
                                                                                                                return false;
                                                                                                            }
                                                                                                        }
                                                                                                        return true;
                                                                                                    }
                                                                                                    $numseqFields1 = [
                                                                                                        'numseq_one', 'numseq_two', 'numseq_three', 'numseq_four', 'numseq_five',
                                                                                                        'numseq_six', 'numseq_seven', 'numseq_eight', 'numseq_nine', 'numseq_ten',
                                                                                                        'numseq_eleven', 'numseq_twelve', 'numseq_thirteen', 'numseq_fourteen', 'numseq_fifteen',
                                                                                                        'numseq_sixteen', 'numseq_seventeen', 'numseq_eighteen', 'numseq_nineteen', 'numseq_twenty',
                                                                                                        'numseq_twenty_one', 'numseq_twenty_two', 'numseq_twenty_three', 'numseq_twenty_four', 'numseq_twenty_five'
                                                                                                    ];

                                                                                                    $numseqFields2 = [
                                                                                                        'numseq_twenty_six', 'numseq_twenty_seven', 'numseq_twenty_eight', 'numseq_twenty_nine', 'numseq_thirty',
                                                                                                        'numseq_thirty_one', 'numseq_thirty_two', 'numseq_thirty_three', 'numseq_thirty_four', 'numseq_thirty_five',
                                                                                                        'numseq_thirty_six', 'numseq_thirty_seven', 'numseq_thirty_eight', 'numseq_thirty_nine', 'numseq_forty',
                                                                                                        'numseq_forty_one', 'numseq_forty_two', 'numseq_forty_three', 'numseq_forty_four', 'numseq_forty_five',
                                                                                                        'numseq_forty_six', 'numseq_forty_seven', 'numseq_forty_eight', 'numseq_forty_nine', 'numseq_fifty'
                                                                                                    ];

                                                                                                    $numseqFields3 = [
                                                                                                        'numseq_fifty_one', 'numseq_fifty_two', 'numseq_fifty_three', 'numseq_fifty_four', 'numseq_fifty_five',
                                                                                                        'numseq_fifty_six', 'numseq_fifty_seven', 'numseq_fifty_eight', 'numseq_fifty_nine', 'numseq_sixty',
                                                                                                        'numseq_sixty_one', 'numseq_sixty_two', 'numseq_sixty_three', 'numseq_sixty_four', 'numseq_sixty_five',
                                                                                                        'numseq_sixty_six', 'numseq_sixty_seven', 'numseq_sixty_eight', 'numseq_sixty_nine', 'numseq_seventy',
                                                                                                        'numseq_seventy_one', 'numseq_seventy_two', 'numseq_seventy_three', 'numseq_seventy_four', 'numseq_seventy_five'
                                                                                                    ];

                                                                                                    $numseqFields4 = [
                                                                                                        'numseq_seventy_six', 'numseq_seventy_seven', 'numseq_seventy_eight', 'numseq_seventy_nine', 'numseq_eighty',
                                                                                                        'numseq_eighty_one', 'numseq_eighty_two', 'numseq_eighty_three', 'numseq_eighty_four', 'numseq_eighty_five',
                                                                                                        'numseq_eighty_six', 'numseq_eighty_seven', 'numseq_eighty_eight', 'numseq_eighty_nine', 'numseq_ninety',
                                                                                                        'numseq_ninety_one', 'numseq_ninety_two', 'numseq_ninety_three', 'numseq_ninety_four', 'numseq_ninety_five',
                                                                                                        'numseq_ninety_six', 'numseq_ninety_seven', 'numseq_ninety_eight', 'numseq_ninety_nine', 'numseq_hundred'
                                                                                                    ];

                                                                                                    $numseqFields5 = [
                                                                                                        'numseq_hundred_one', 'numseq_hundred_two', 'numseq_hundred_three', 'numseq_hundred_four', 'numseq_hundred_five',
                                                                                                        'numseq_hundred_six', 'numseq_hundred_seven', 'numseq_hundred_eight', 'numseq_hundred_nine', 'numseq_hundred_ten',
                                                                                                        'numseq_hundred_eleven', 'numseq_hundred_twelve', 'numseq_hundred_thirteen', 'numseq_hundred_fourteen', 'numseq_hundred_fifteen',
                                                                                                        'numseq_hundred_sixteen', 'numseq_hundred_seventeen', 'numseq_hundred_eighteen', 'numseq_hundred_nineteen', 'numseq_hundred_twenty',
                                                                                                        'numseq_hundred_twenty_one', 'numseq_hundred_twenty_two', 'numseq_hundred_twenty_three', 'numseq_hundred_twenty_four', 'numseq_hundred_twenty_five'
                                                                                                    ];

                                                                                                    $numseqFields6 = [
                                                                                                        'numseq_hundred_twenty_six', 'numseq_hundred_twenty_seven', 'numseq_hundred_twenty_eight', 'numseq_hundred_twenty_nine', 'numseq_hundred_thirty',
                                                                                                        'numseq_hundred_thirty_one', 'numseq_hundred_thirty_two', 'numseq_hundred_thirty_three', 'numseq_hundred_thirty_four', 'numseq_hundred_thirty_five',
                                                                                                        'numseq_hundred_thirty_six', 'numseq_hundred_thirty_seven', 'numseq_hundred_thirty_eight', 'numseq_hundred_thirty_nine', 'numseq_hundred_forty',
                                                                                                        'numseq_hundred_forty_one', 'numseq_hundred_forty_two', 'numseq_hundred_forty_three', 'numseq_hundred_forty_four', 'numseq_hundred_forty_five',
                                                                                                        'numseq_hundred_forty_six', 'numseq_hundred_forty_seven', 'numseq_hundred_forty_eight', 'numseq_hundred_forty_nine', 'numseq_hundred_fifty'
                                                                                                    ];
                                                                                                    $full_numseqFields = array_merge($numseqFields1,$numseqFields2,$numseqFields3,$numseqFields4,$numseqFields5,$numseqFields6);

                                                                                                @endphp
                                                                                                <tbody>
                                                                                                    @foreach ($orderItemDetails as $orderItemDetail)
                                                                                                        {{-- <div> --}}
                                                                                                            <tr class=" player-size-row mobile-number-row mobile_expand_tr {{ 'order-' . $orderItemDetail->order_item_id . '-' . $orderItemDetail->size_id }} {{ 'size-' . $orderItemDetail->size_id }}"
                                                                                                                @if (in_array($orderItemDetail->size_id, $sizeIdsToHide) && $orderItemDetail->qty == '' && $orderItemDetail->blanks == '')
                                                                                                                    style='display:none'
                                                                                                                @endif>
                                                                                                                @php
                                                                                                                    $rowsShowingNumbersequence = 2;
                                                                                                                    $hiddenTrueFalseRow3 = areFieldsEmpty($numseqFields3, $orderItemDetail) ? "hidden" : '';
                                                                                                                    $hiddenTrueFalseRow4 = areFieldsEmpty($numseqFields4, $orderItemDetail) ? "hidden" : '';
                                                                                                                    $hiddenTrueFalseRow5 = areFieldsEmpty($numseqFields5, $orderItemDetail) ? "hidden" : '';
                                                                                                                    $hiddenTrueFalseRow6 = areFieldsEmpty($numseqFields6, $orderItemDetail) ? "hidden" : '';
                                                                                                                @endphp

                                                                                                                @if($hiddenTrueFalseRow3 == '') @php $rowsShowingNumbersequence++; @endphp @endif
                                                                                                                @if($hiddenTrueFalseRow4 == '') @php $rowsShowingNumbersequence++; @endphp @endif
                                                                                                                @if($hiddenTrueFalseRow5 == '') @php $rowsShowingNumbersequence++; @endphp @endif
                                                                                                                @if($hiddenTrueFalseRow6 == '') @php $rowsShowingNumbersequence = 6; @endphp @endif
                                                                                                                @if ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size One')
                                                                                                                    <th style="VERTICAL-ALIGN: MIDDLE; margin-bottom: 10px; height: unset;"
                                                                                                                        class="wi-10 size-card-title {{ $orderItemDetail->id . 'rowspans' }}"
                                                                                                                        rowspan="{{ $rowsShowingNumbersequence }}"><input
                                                                                                                            type="text"
                                                                                                                            class="extra-size-font invoice-inputs hi-69 txtSizeName"
                                                                                                                            name="orderItem[{{ $orderItem->id }}][extra_size]"
                                                                                                                            value="@if ($orderItem->extra_size == '1') {{ 'Extra Size One' }} @else {{ $orderItem->extra_size }} @endif"
                                                                                                                            data-AlradySaved="@if ($orderItem->extra_size == '1') {{ 'Extra Size One' }} @else {{ $orderItem->extra_size }} @endif" />
                                                                                                                    </th>
                                                                                                                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Two')
                                                                                                                    <th style="VERTICAL-ALIGN: MIDDLE; margin-bottom: 10px; height: unset;"
                                                                                                                        class="wi-10 size-card-title {{ $orderItemDetail->id . 'rowspans' }}"
                                                                                                                        rowspan="{{ $rowsShowingNumbersequence }}"><input
                                                                                                                            type="text"
                                                                                                                            class="extra-size-font invoice-inputs hi-69 txtSizeName"
                                                                                                                            name="orderItem[{{ $orderItem->id }}][extra_size_two]"
                                                                                                                            value="@if ($orderItem->extra_size_two == '1') {{ 'Extra Size Two' }} @else {{ $orderItem->extra_size_two }} @endif"
                                                                                                                            data-AlradySaved="@if ($orderItem->extra_size_two == '1') {{ 'Extra Size Two' }} @else {{ $orderItem->extra_size_two }} @endif" />
                                                                                                                    </th>
                                                                                                                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Three')
                                                                                                                    <th style="VERTICAL-ALIGN: MIDDLE; margin-bottom: 10px; height: unset;"
                                                                                                                        class="wi-10 size-card-title {{ $orderItemDetail->id . 'rowspans' }} "
                                                                                                                        rowspan="{{ $rowsShowingNumbersequence }}"><input
                                                                                                                            type="text"
                                                                                                                            class="extra-size-font invoice-inputs hi-69 txtSizeName"
                                                                                                                            name="orderItem[{{ $orderItem->id }}][extra_size_three]"
                                                                                                                            value="@if ($orderItem->extra_size_three == '1') {{ 'Extra Size Three' }} @else {{ $orderItem->extra_size_three }} @endif"
                                                                                                                            data-AlradySaved="@if ($orderItem->extra_size_three == '1') {{ 'Extra Size Three' }} @else {{ $orderItem->extra_size_three }} @endif" />
                                                                                                                    </th>
                                                                                                                @else
                                                                                                                    <th style="VERTICAL-ALIGN: MIDDLE; position: relative; left: 10px;"
                                                                                                                        class="wi-10 size-card-title {{ $orderItemDetail->id . 'rowspans' }}"
                                                                                                                        rowspan="{{ $rowsShowingNumbersequence }}">

                                                                                                                        <span class="mobile-size-name">
                                                                                                                            {{ $orderItemDetail->sizeDetails['size_name'] }}
                                                                                                                        </span>

                                                                                                                    </th>
                                                                                                                @endif

                                                                                                                <td style="VERTICAL-ALIGN: MIDDLE;"
                                                                                                                    class="wi-2 {{ $orderItemDetail->id . 'rowspans' }} right-left-border mobile_row_width_100"
                                                                                                                    rowspan="{{ $rowsShowingNumbersequence }}">
                                                                                                                    <input
                                                                                                                    style=" border: unset;"
                                                                                                                        class="form-control hi-69 text-center qtyseq qtyseq{{ $orderItemDetail->id }} mobile-size-qty"
                                                                                                                        name="product[{{ $orderItemDetail->id }}][qty]"
                                                                                                                        type='text' value='{{ $orderItemDetail->qty }}'
                                                                                                                        data-AlradySaved="{{ $orderItemDetail->qty }}"
                                                                                                                        data-id="{{ $orderItemDetail->id }}" readonly />
                                                                                                                </td>


                                                                                                                @foreach ($numseqFields1 as $field)
                                                                                                                    <td class="wi-2 mobile-player-cell">
                                                                                                                        <input type='number'
                                                                                                                            class="form-control numseq numseqVal{{ $orderItemDetail->id }} mobile-player-number"
                                                                                                                            oninput="limitDigits(this, 6)"
                                                                                                                            name="product[{{ $orderItemDetail->id }}][{{ $field }}]"
                                                                                                                            data-orderItemDetailId="{{ $orderItemDetail->id }}"
                                                                                                                            value="{{ $orderItemDetail->$field }}"
                                                                                                                            data-AlradySaved="{{ $orderItemDetail->$field}}" />
                                                                                                                    </td>
                                                                                                                @endforeach
                                                                                                            </tr>
                                                                                                            <tr class=" mobile-number-row mobile_expand_tr {{ 'order-' . $orderItemDetail->order_item_id . '-' . $orderItemDetail->size_id }} {{ 'size-' . $orderItemDetail->size_id }}"
                                                                                                                @if (in_array($orderItemDetail->size_id, $sizeIdsToHide) && $orderItemDetail->qty == '' && $orderItemDetail->blanks == '')
                                                                                                                    style='display:none'
                                                                                                                @endif>


                                                                                                                @foreach($numseqFields2 as $field)
                                                                                                                    <td class="wi-2 mobile-player-cell">
                                                                                                                        <input type="number"
                                                                                                                            oninput="limitDigits(this, 6)"
                                                                                                                            class="form-control numseq below numseqVal{{ $orderItemDetail->id }}"
                                                                                                                            name="product[{{ $orderItemDetail->id }}][{{ $field }}]"
                                                                                                                            data-orderItemDetailId="{{ $orderItemDetail->id }}"
                                                                                                                            value="{{ $orderItemDetail->$field }}"
                                                                                                                            data-AlradySaved="{{ $orderItemDetail->$field }}" />
                                                                                                                    </td>
                                                                                                                @endforeach

                                                                                                            </tr>
                                                                                                            <tr class="mobile-number-row {{ 'order-' . $orderItemDetail->order_item_id . '-' . $orderItemDetail->size_id }} {{ 'size-' . $orderItemDetail->size_id }} {{ $orderItemDetail->id . 'row1Hidden' }}"
                                                                                                                @if (in_array($orderItemDetail->size_id, $sizeIdsToHide) && $orderItemDetail->qty == '' && $orderItemDetail->blanks == '')
                                                                                                                    style='display:none'
                                                                                                                @endif @php echo $hiddenTrueFalseRow3; @endphp>

                                                                                                                @foreach ($numseqFields3 as $field)
                                                                                                                    <td class="wi-2 mobile-player-cell">
                                                                                                                        <input type="number"
                                                                                                                        oninput="limitDigits(this, 6)"
                                                                                                                            class="form-control numseq below1 numseqVal{{ $orderItemDetail->id }}"
                                                                                                                            name="product[{{ $orderItemDetail->id }}][{{ $field }}]"
                                                                                                                            data-orderItemDetailId="{{ $orderItemDetail->id }}"
                                                                                                                            value="{{ $orderItemDetail->$field }}"
                                                                                                                            data-AlradySaved="{{ $orderItemDetail->$field }}" />
                                                                                                                    </td>
                                                                                                                @endforeach

                                                                                                            </tr>
                                                                                                            <tr class="mobile-number-row {{ 'order-' . $orderItemDetail->order_item_id . '-' . $orderItemDetail->size_id }} {{ 'size-' . $orderItemDetail->size_id }} {{ $orderItemDetail->id . 'row2Hidden' }}"
                                                                                                                @if (in_array($orderItemDetail->size_id, $sizeIdsToHide) && $orderItemDetail->qty == '' && $orderItemDetail->blanks == '')
                                                                                                                    style='display:none'
                                                                                                                @endif @php echo $hiddenTrueFalseRow4; @endphp>

                                                                                                                @foreach ($numseqFields4 as $field)
                                                                                                                    <td class="wi-2 mobile-player-cell">
                                                                                                                        <input type="number"
                                                                                                                        oninput="limitDigits(this, 6)"
                                                                                                                            class="form-control numseq below2 numseqVal{{ $orderItemDetail->id }}"
                                                                                                                            name="product[{{ $orderItemDetail->id }}][{{ $field }}]"
                                                                                                                            data-orderItemDetailId="{{ $orderItemDetail->id }}"
                                                                                                                            value="{{ $orderItemDetail->$field }}"
                                                                                                                            data-AlradySaved="{{ $orderItemDetail->$field }}" />
                                                                                                                    </td>
                                                                                                                @endforeach

                                                                                                            </tr>
                                                                                                            <tr class="mobile-number-row {{ 'order-' . $orderItemDetail->order_item_id . '-' . $orderItemDetail->size_id }} {{ 'size-' . $orderItemDetail->size_id }} {{ $orderItemDetail->id . 'row3Hidden' }}"
                                                                                                                @if (in_array($orderItemDetail->size_id, $sizeIdsToHide) && $orderItemDetail->qty == '' && $orderItemDetail->blanks == '')
                                                                                                                    style='display:none'
                                                                                                                @endif @php echo $hiddenTrueFalseRow5; @endphp>

                                                                                                                @foreach ($numseqFields5 as $field)
                                                                                                                    <td class="wi-2 mobile-player-cell">
                                                                                                                        <input type="number"
                                                                                                                        oninput="limitDigits(this, 6)"
                                                                                                                            class="form-control numseq below3 numseqVal{{ $orderItemDetail->id }}"
                                                                                                                            name="product[{{ $orderItemDetail->id }}][{{ $field }}]"
                                                                                                                            data-orderItemDetailId="{{ $orderItemDetail->id }}"
                                                                                                                            value="{{ $orderItemDetail->$field }}"
                                                                                                                            data-AlradySaved="{{ $orderItemDetail->$field }}" />
                                                                                                                    </td>
                                                                                                                @endforeach

                                                                                                            </tr>
                                                                                                            <tr class="mobile-number-row {{ 'order-' . $orderItemDetail->order_item_id . '-' . $orderItemDetail->size_id }} {{ 'size-' . $orderItemDetail->size_id }} {{ $orderItemDetail->id . 'row4Hidden' }}"
                                                                                                                @if (in_array($orderItemDetail->size_id, $sizeIdsToHide) && $orderItemDetail->qty == '' && $orderItemDetail->blanks == '')
                                                                                                                    style='display:none'
                                                                                                                @endif @php echo $hiddenTrueFalseRow6; @endphp>

                                                                                                                @foreach ($numseqFields6 as $field)
                                                                                                                    <td class="wi-2 mobile-player-cell">
                                                                                                                        <input type="number"
                                                                                                                        oninput="limitDigits(this, 6)"
                                                                                                                            class="form-control numseq below4 numseqVal{{ $orderItemDetail->id }}"
                                                                                                                            name="product[{{ $orderItemDetail->id }}][{{ $field }}]"
                                                                                                                            data-orderItemDetailId="{{ $orderItemDetail->id }}"
                                                                                                                            value="{{ $orderItemDetail->$field }}"
                                                                                                                            data-AlradySaved="{{ $orderItemDetail->$field }}" />
                                                                                                                    </td>
                                                                                                                @endforeach

                                                                                                            </tr>
                                                                                                            <tr class=" player-size-row mobile-number-row {{ 'order-' . $orderItemDetail->order_item_id . '-' . $orderItemDetail->size_id }} {{ 'size-' . $orderItemDetail->size_id }}"
                                                                                                                @if (in_array($orderItemDetail->size_id, $sizeIdsToHide) && $orderItemDetail->qty == '' && $orderItemDetail->blanks == '')
                                                                                                                    style='display:none'
                                                                                                                @endif>
                                                                                                                <td colspan="28" style="border-top: 1px solid #bbbbbb;"></td>
                                                                                                            </tr>
                                                                                                        {{-- </div> --}}
                                                                                                    @endforeach
                                                                                                </tbody>
                                                                                                <tfoot>
                                                                                                    <tr style="background-color: #e4e4e4">
                                                                                                        <th></th>
                                                                                                        <th class="wi-2" style="font-size: 11px; text-align: center;">TOTAL NUM</th>
                                                                                                        <th colspan="25" style="font-size: 11px;">
                                                                                                            @can('edit order
                                                                                                                items')
                                                                                                                <button type="button" class="btn btn-success btn-custom add-size"
                                                                                                                    value="{{ $orderItem->id }}">Add Size</button>
                                                                                                            @endcan
                                                                                                        </th>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td class="wi-10"></td>
                                                                                                        <td class="wi-2 border-threeSide">
                                                                                                            <input class="form-control hi-69 text-center TOTALnums"
                                                                                                            style="border:unset;"
                                                                                                                name="orderItem[{{ $orderItem->id }}][TOTALnums]"
                                                                                                                id="TOTALnums_{{ $orderItem->id }}" type='text'
                                                                                                                value='' data-AlradySaved="" readonly />
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tfoot>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div style=" padding: 3px; height: 607px;"
                                                                                    class="cusTab tab-pane fade detail-card-margin roster-mobile-wrapper" id="orderRosterName_tab_{{ $orderItem->id }}"
                                                                                    role="tabpanel" aria-labelledby="orderRosterName_{{ $orderItem->id }}">

                                                                                    <div class="tab formRosterPlayerNames{{ $orderItem->id }} roster-size-sidebar"
                                                                                        style="height: 600px; max-width: 200px; background-color: white; border: none;">
                                                                                        @php $activeStatus = "active"; @endphp
                                                                                        @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                                                                                            @if ($orderItemDetail->qty > 0 || $orderItemDetail->blanks > 0)
                                                                                                <button type="button"
                                                                                                    class="tablinksCustom {{ $activeStatus }} btn btn-secondary btn-custom roster-size-btn"
                                                                                                    style="width: 100% !important;"
                                                                                                    onclick="openSize(event, 'tab_sizes_{{ $orderItemDetail->id }}')">
                                                                                                    <small>
                                                                                                        <b>
                                                                                                            @if(($orderItemDetail->sizeDetails['size_name'] =='Extra Size One') && !($orderItem->extra_size =='1' || $orderItem->extra_size =='0'))
                                                                                                                {{ $orderItem->extra_size }}
                                                                                                            @elseif (($orderItemDetail->sizeDetails['size_name'] =='Extra Size Two') && !($orderItem->extra_size =='1' || $orderItem->extra_size =='0'))
                                                                                                                {{ $orderItem->extra_size_two }}
                                                                                                            @elseif(($orderItemDetail->sizeDetails['size_name'] =='Extra Size Three') && !($orderItem->extra_size =='1' || $orderItem->extra_size =='0'))
                                                                                                                {{ $orderItem->extra_size_three }}
                                                                                                            @else
                                                                                                                {{ $orderItemDetail->sizeDetails['size_name'] }}
                                                                                                            @endif
                                                                                                        </b>
                                                                                                    </small></button>
                                                                                                @php $activeStatus = ""; @endphp
                                                                                            @endif
                                                                                        @endforeach

                                                                                    </div>
                                                                                    @php
                                                                                        $productSizes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 26, 17, 18, 19, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 25, 16, 28, 29];

                                                                                        $orderItemDetails = $orderItem->orderItemDetails;

                                                                                        $orderItemDetails = $orderItemDetails->sortBy(function ($item) use ($productSizes) {
                                                                                            return array_search($item->sizeDetails['id'], $productSizes, true);
                                                                                        });
                                                                                    @endphp
                                                                                    @foreach ($orderItemDetails as $orderItemDetail)
                                                                                        @php
                                                                                            $playerNameArrayPosition = '';
                                                                                            if (array_search("$orderItemDetail->id", $arrayPlayerNamesPattern) !== false) {
                                                                                                $playerNameArrayPosition = array_search("$orderItemDetail->id", $arrayPlayerNamesPattern);
                                                                                            } else {
                                                                                                $playerNameArrayPosition = '';
                                                                                            }
                                                                                        @endphp

                                                                                        @if ($orderItemDetail->qty > 0 || $orderItemDetail->blanks > 0)
                                                                                            <div id="tab_sizes_{{ $orderItemDetail->id }}" class="tabcontentCustom mt-4 roster-mobile-card"
                                                                                                style="display: block; height: 550px;overflow: hidden;overflow-y: scroll;">
                                                                                                {{-- <h3 class="ml-1">{{ $orderItemDetail->sizeDetails['size_name'] }}</h3> --}}
                                                                                                <input type="hidden" name="playerName[{{ $orderItemDetail->id }}][itemId]"
                                                                                                    value="{{ $orderItemDetail->id }}" />

                                                                                                <table class="table ml-1 roster-mobile-table" id="playerName">
                                                                                                    <thead>
                                                                                                        <tr style="background-color: #878787; height: 45px; color: white;">
                                                                                                            <th ><span style="font-size: 0.8rem; font-weight: bold; position: relative; bottom: 5px;">Size Name</span></th>
                                                                                                            <th ><span style="font-size: 0.8rem; font-weight: bold; position: relative; bottom: 5px;">Number</span></th>
                                                                                                            <th ><span style="font-size: 0.8rem; font-weight: bold; position: relative; bottom: 5px;">Player Name</span></th>
                                                                                                        </tr>
                                                                                                    </thead>

                                                                                                    <tbody>
                                                                                                        @foreach ($full_numseqFields as $fieldKey => $field)
                                                                                                            @if (isset($orderItemDetail->$field) && $orderItemDetail->$field != '')
                                                                                                                <tr>
                                                                                                                    <td>
                                                                                                                        @php
                                                                                                                            if(($orderItemDetail->sizeDetails['size_name'] =='Extra Size One') && !($orderItem->extra_size =='1' || $orderItem->extra_size =='0')){
                                                                                                                                $sizeName = $orderItem->extra_size;
                                                                                                                            }

                                                                                                                            elseif (($orderItemDetail->sizeDetails['size_name'] =='Extra Size Two') && !($orderItem->extra_size =='1' || $orderItem->extra_size =='0')){
                                                                                                                                $sizeName = $orderItem->extra_size_two;
                                                                                                                            }
                                                                                                                            elseif(($orderItemDetail->sizeDetails['size_name'] =='Extra Size Three') && !($orderItem->extra_size =='1' || $orderItem->extra_size =='0')){
                                                                                                                                $sizeName = $orderItem->extra_size_three;
                                                                                                                            }

                                                                                                                            else{
                                                                                                                                $sizeName = $orderItemDetail->sizeDetails['size_name'];
                                                                                                                            }


                                                                                                                        @endphp
                                                                                                                        <input type="text" class="invoice-inputs"
                                                                                                                            value="{{ $sizeName }}"
                                                                                                                            readonly />
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <input type="text" class="invoice-inputs"
                                                                                                                            value="{{ $orderItemDetail->$field }}"
                                                                                                                            readonly />
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        @php
                                                                                                                        $cleanField = preg_replace('/^numseq_/', '', $field);
                                                                                                                        @endphp
                                                                                                                        <input type="text" class="form-control number_player"
                                                                                                                            name="playerName[{{ $orderItemDetail->id }}][player_{{ $cleanField}}]"
                                                                                                                            value="{{ $orderItemDetail->playerDetails['player_' . $cleanField] ?? '' }}"
                                                                                                                            placeholder="N" />
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                        @if ($orderItemDetail->blanks > 0)
                                                                                                            @if (!isset($orderItemDetail->playerDetails))
                                                                                                                @for ($i = 0; $i < $orderItemDetail->blanks; $i++)
                                                                                                                    <tr>
                                                                                                                        <td><input type="text" class="invoice-inputs"
                                                                                                                                value="{{ $orderItemDetail->sizeDetails['size_name'] }}"
                                                                                                                                readonly /></td>
                                                                                                                        <td><input type="text" class="invoice-inputs"
                                                                                                                                value="N" readonly /></td>
                                                                                                                        <td><input type="text" class="form-control blank_players"
                                                                                                                                name="playerName[{{ $orderItemDetail->id }}][blank_players][{{ $i }}]"
                                                                                                                                placeholder="N" /></td>
                                                                                                                    </tr>
                                                                                                                @endfor
                                                                                                            @elseif(isset($orderItemDetail->playerDetails) && $orderItemDetail->playerDetails->blank_player_names == '')
                                                                                                                @for ($i = 0; $i < $orderItemDetail->blanks; $i++)
                                                                                                                    <tr>
                                                                                                                        <td><input type="text" class="invoice-inputs"
                                                                                                                                value="{{ $orderItemDetail->sizeDetails['size_name'] }}"
                                                                                                                                readonly /></td>
                                                                                                                        <td><input type="text" class="invoice-inputs"
                                                                                                                                value="N" readonly /></td>
                                                                                                                        <td><input type="text" class="form-control blank_players"
                                                                                                                                name="playerName[{{ $orderItemDetail->id }}][blank_players][{{ $i }}]"
                                                                                                                                placeholder="N" /></td>
                                                                                                                    </tr>
                                                                                                                @endfor
                                                                                                            @elseif(isset($orderItemDetail->playerDetails) && $orderItemDetail->playerDetails->blank_player_names != '')
                                                                                                                @foreach (json_decode($orderItemDetail->playerDetails->blank_player_names) as $blankPlayerKey => $blankPlayer)
                                                                                                                    <tr>
                                                                                                                        <td><input type="text" class="invoice-inputs"
                                                                                                                                value="{{ $orderItemDetail->sizeDetails['size_name'] }}"
                                                                                                                                readonly /></td>
                                                                                                                        <td><input type="text" class="invoice-inputs"
                                                                                                                                value="N" readonly /></td>
                                                                                                                        <td><input type="text" class="form-control blank_players"
                                                                                                                                name="playerName[{{ $orderItemDetail->id }}][blank_players][{{ $blankPlayerKey }}]"
                                                                                                                                value="{{ $blankPlayer ?? '' }}" placeholder="N" />
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                @endforeach
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            @php $DisplayStatus = "display: none;"; @endphp
                                                                                        @else
                                                                                            <input type="hidden" name="playerName[{{ $orderItemDetail->id }}][itemId]"
                                                                                                value="{{ $orderItemDetail->id }}" />
                                                                                        @endif
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 modern-control-card" style="padding-left: 11px; margin-left: -3px;padding-right: 0px;">
                                                                            <div class="card control-btn-card " >
                                                                                <div class="col-md-12 control-btns control-btn-position" style="margin-top: unset;">
                                                                                    @can('delete order items')
                                                                                        {{-- <button type="button" class="btn btn-danger btn-custom delete-order"
                                                                                            value="{{ $orderItem->id }}">Delete</button> --}}
                                                                                        <button type="button" class="btn btn-danger btn-custom delete-order"
                                                                                            data-order-id="{{ $orderItem->id }}">Delete</button>

                                                                                    @endcan

                                                                                    <a href="{{ url('order_details/print_order_item') }}/{{ $orderItem->id }}"
                                                                                        class="btn btn-light btn-custom">Print Roster</a>

                                                                                        <a href="{{ route('download.excel', ['id' => $orderItem->id]) }}" class="btn btn-light btn-custom">Download Excel</a>




                                                                                    @if (Gate::check('edit order items') || Gate::check('edit order items - factory'))
                                                                                        <button id="orderItemSaveBtn" type="submit"
                                                                                            class="btn btn-success btn-custom no-disable-factory ">Save</button>
                                                                                    @endif
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </form>
                                                            </div>
                                                        @endcan
                                                    </div>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        {{-- @foreach ($orderDetails as $orderDetail) --}}
                            @if ($order->is_requested == 1)
                                <div class="col-lg-12 control-btns mt-2 mb-4">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            <h4>Edit Request Received!<br><small>Reasons : {{$order->request_reasons}}</small></h4>
                                        </div>

                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-success btn-custom" id="accept_request_btn" style="width: 31%" value="{{$order->id}}">Accept Request</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        {{-- @endforeach --}}
                    </div>
                    <div id="hiddenNotes">
                        <form>

                            <input type="text" id="orderItemName" style="width: 90%;margin-bottom: 5px;"><br>
                            <input type="hidden" value="" id="orderItemID">
                            <input type="hidden" value="" id="clickedNotebutton">
                            <textarea id="orderItemNotes" rows="5" style="width:90%;"> </textarea><br>

                            <span class="button Save">Save</span>
                            <span class="button Close">Close</span>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    {{-- modal set --}}

    <div class="modal fade" id="re_order_modal" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title-default">Re-Order</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form action="{{ route('new_orders.create_re_order') }}" method="POST" id="re_order_form">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="modal-title" id="modal-title-default" style="position: relative; left: 13px;">Do you want to re-order this order?</h3>

                                    <input type="hidden" name="exs_order_id" id="exs_order_id" value="{{$order->id}}" />

                            </div>
                        </div>
                        <div class="row mt-3" style="justify-content: space-evenly;">
                            <div class="col-md-4">
                                <input type="radio" class="radio" name="roster" id="no_roster" value="no" checked>
                                <label class="reorder-lable" for="no_roster">Without Roster</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="radio" name="roster" id="with_roster" value="yes">
                                <label class="reorder-lable" for="with_roster">With Roster</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="col-lg-12 control-btns">
                            <button type="submit" class="btn btn-success btn-custom">Re-Order</button>
                            <button type="reset" class="btn btn-secondary btn-custom" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="progress-modal" style="display:none;">
        <div id="progress-overlay"></div>
        <div id="progress-content">
            <h3 id="progress-headding">Archiving Files...</h3>
            <p id="progress-sub-headding">Please wait while your files are being archived into a folder.</p>
            <div id="progress-bar-container">
                <div id="progress-bar"></div>
            </div>
            <p id="progress-text"></p>
        </div>
    </div>
    <div class="modal fade" id="add_ex_factory_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-title-default">Add Ex-Factory Shipping Address</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="col-md-12 form-field">
                            <label class="form-lable">Name</label>
                            <input type="text" class="form-control" rows="4" id="ex_factory_name" name="ex_factory_name" />
                        </div>

                        <div class="col-md-12 form-field">
                            <label class="form-lable">Shipping PO Box</label>
                            <input type="text" class="form-control" id="ex_factory_po_box" name="ex_factory_po_box" />
                        </div>
                        <div class="col-md-12 form-field">
                            <label class="form-lable">Apartment</label>
                            <input type="text" class="form-control" id="ex_factory_apartment" name="ex_factory_apartment" />
                        </div>

                        <div class="col-md-12 form-field">
                            <label class="form-lable">Shipping City</label>
                            <input type="text" class="form-control" id="ex_factory_city" name="ex_factory_city" />
                        </div>

                        <div class="col-md-12 form-field">
                            <label class="form-lable">Shipping State</label>
                            <input type="text" class="form-control" id="ex_factory_state" name="ex_factory_state" />
                        </div>

                        <div class="col-md-12 form-field">
                            <label class="form-lable">Shipping Postal Code</label>
                            <input type="text" class="form-control" id="ex_factory_postal_code" name="ex_factory_postal_code" />
                        </div>

                        <div class="col-md-12 form-field">
                            <label class="form-lable">Shipping Country</label>
                            <input type="text" class="form-control" id="ex_factory_country" name="ex_factory_country" />
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button type="button" class="btn btn-success btn-custom" id="btn_add_ex_factory">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.order_management.order_quotation.copy_credentials_modal')
    @include('pages.order_management.orders.item_ex_factory_date_log')

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#item_customer_InHand_date_{{ $orderItem->id }}", {
        dateFormat: "m-d-Y",
        defaultDate: "{{ $orderItem->in_hand_due_date }}",
        altInput: true,
        altFormat: "m/d/Y",
        allowInput: true,
        monthSelectorType: "dropdown"
    });
    flatpickr("#item_ex_factory_date_{{ $orderItem->id }}", {
        dateFormat: "m-d-Y",
        defaultDate: "{{ $orderItem->ex_factory_date }}",
        altInput: true,
        altFormat: "m/d/Y",
        allowInput: true,
        monthSelectorType: "dropdown"
    });
    flatpickr("#item_encore_packing_date_{{ $orderItem->id }}", {
        dateFormat: "m-d-Y",
        defaultDate: "{{ $orderItem->encore_packing_date }}",
        altInput: true,
        altFormat: "m/d/Y",
        allowInput: true,
        monthSelectorType: "dropdown"
    });

});
document.addEventListener('change', function (e) {
    const fp = e.target._flatpickr;

    // Only run for Flatpickr inputs
    if (!fp) {
        return;
    }

    fp.close();

    // Remove focus from original input
    fp.input.blur();

    // Remove focus from visible altInput
    if (fp.altInput) {
        fp.altInput.blur();
    }
}, true);
</script>

    <script src="{{ asset('argon') }}/file_inputs/js/fileinput.js"></script>
    <script src="{{ asset('argon') }}/file_inputs/themes/fas/theme.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script>
        $(document).on('wheel', 'input[type="number"]', function () {
            $(this).blur();
        });
        function limitDigits(el, maxLength) {
            if (el.value.length > maxLength) {
                el.value = el.value.slice(0, maxLength);
            }
        }
        function ShowErrorMessage() {
            var selectedValue = $('#order_status_id').val();
            if(selectedValue == 1){

                Swal.fire({
                    icon: 'warning',
                    title: 'Item Status Quote',
                    html: 'To change the test print due date, the item must be in production. <br><span style="font-size: 12px; color: #666;">(By default, the test print due date is set to 10 days after the Sent to Production date)</span>',
                    confirmButtonText: 'OK',
                    showCloseButton: true,
                    focusConfirm: false
                });
                var testPrintDueDateInput = $('#test_print_due_date_text');

                // Reset the value
                testPrintDueDateInput.val('');
            }
        }
        function comfirmchangeItemExFactoryDate(itemID) {
            var atrExFactoryDate = $("#item_ex_factory_date_" + itemID);
            var new_ex_factory_date = atrExFactoryDate.val();
            var pre_ex_factory_date = atrExFactoryDate.data("alradysaved");

            (async () => {
                const { value: formValuesEx, isDismissed } = await Swal.fire({
                    icon: 'warning',
                    title: 'Please insert a reason!',
                    html:
                        '<input type="text" placeholder="Reason" id="swal-input-reason" class="swal2-input" required>',
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Change',
                    showLoaderOnConfirm: true,
                    showCloseButton: true,
                    showCloseButtonTooltip: "Close",
                    preConfirm: () => {
                        const reason = document.getElementById('swal-input-reason').value;
                        if (!reason) {
                            // Manually show an error and prevent confirm
                            Swal.fire({
                                icon: 'error',
                                title: 'Reason is mandatory!',
                                text: 'Please provide a reason before proceeding.'
                            });
                            atrExFactoryDate.val(pre_ex_factory_date);
                            return false; // Prevent modal from closing
                        }
                        return reason;
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                });

                // Reset to previous date if the modal is dismissed or closed
                if (isDismissed || !formValuesEx) {
                    atrExFactoryDate.val(pre_ex_factory_date);
                    return;
                }

                // If reason is provided and modal confirmed
                if (formValuesEx) {
                    $.ajax({
                        url: "{{ url('order_details/ex_factory_authenticate') }}",
                        method: 'POST',
                        data: { reason: formValuesEx, "_token": "{{ csrf_token() }}" },
                        dataType: 'json',
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function (data, textStatus, jqXHR) {
                            var authresponse = data[0];
                            var reason = data[1];

                            if (authresponse == 'success') {
                                changeItemExFactoryDate(itemID);
                                addItemExFactoryDatelog(itemID, new_ex_factory_date, pre_ex_factory_date, reason);
                            } else if (authresponse == 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Apologies',
                                    text: 'You do not possess the required authorization to carry out this action.'
                                });
                                atrExFactoryDate.val(pre_ex_factory_date);
                            }

                            // Trigger save button click
                            // $("#orderItemSaveBtn").click();
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An unexpected error occurred. Please try again.'
                            });
                            atrExFactoryDate.val(pre_ex_factory_date);
                        }
                    });
                }
            })();
        }

        function addItemExFactoryDatelog(itemID, new_ex_factory_date, pre_ex_factory_date, reason){
            $.ajax({
                url:"{{ url('order_details/add_item_ExFactoryDate_log') }}",
                method: 'POST',
                data: { 'new_ex_factory_date': new_ex_factory_date, 'pre_ex_factory_date': pre_ex_factory_date, 'itemID': itemID, 'reason': reason, '_token':'{{csrf_token()}}'},
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    return true
                }
            });
        }
        function changeItemCustomerInHandDate(itemID){
        var due_date = $("#item_customer_InHand_date_"+itemID).val();
        var order_type = $("#order_type").val();
        var address_type = $("#address_type").val();

        if(order_type == 0 || (order_type == 1 && address_type==2)){

            $.ajax({
                url:"{{ url('ex_factory_date/due_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'due_date': due_date,'typeID': 1, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    $('#item_ex_factory_date_'+itemID).val(data);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }else if(order_type == 1){

            $.ajax({
                url:"{{ url('ex_factory_date/due_date') }}",
                method:'POST',
                dataType:'json',
                data: {
                    'due_date': due_date,'typeID': 2, '_token':'{{csrf_token()}}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data){
                    $('#item_ex_factory_date_'+itemID).val(data[0]);
                    $('#item_encore_packing_date_'+itemID).val(data[1]);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }
    }
        function changeItemExFactoryDate(itemID){
            var ex_factory_date = $("#item_ex_factory_date_"+itemID).val();
            var exist_ex_factory_date =  $("#item_ex_factory_date_" + itemID).data("alradysaved");
            var order_type = $("#order_type").val();
            var address_type = $("#address_type").val();



            if(order_type == 0 || (order_type == 1 && address_type==2)){

                $.ajax({
                    url:"{{ url('due_date/ex_factory_date') }}",
                    method:'POST',
                    dataType:'json',
                    data: {
                        'ex_factory_date': ex_factory_date, 'typeID': 1, '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data){
                        $('#item_customer_InHand_date_'+itemID).val(data);
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });

            }else if(order_type == 1){

                $.ajax({
                    url:"{{ url('due_date/ex_factory_date') }}",
                    method:'POST',
                    dataType:'json',
                    data: {
                        'ex_factory_date': ex_factory_date, 'typeID': 2, '_token':'{{csrf_token()}}'
                    },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data){
                        $('#item_encore_packing_date_'+itemID).val(data[0]);
                        $('#item_customer_InHand_date_'+itemID).val(data[1]);
                    },
                    complete: function () {
                        $(".se-pre-con").fadeOut('slow');
                    }
                });

            }

        }
            $('body').on('keydown', '.numseq', function(e) {
                if (e.key == "e") {
                    return false;
                }
            });
            // $(".numseq").on("focus", function() {
            // $(this).on("keydown", function(event) {
            //         if (event.keyCode === 38 || event.keyCode === 40) {
            //             event.preventDefault();
            //         }
            //     });
            // });

            $('body').on('keyup', '.numseq', function(e) {

                if (!isNaN(e.key)) {
                    var orderItemDetailId = $(this).attr("data-orderItemDetailId");
                    var numQty = $(".qtyseq"+orderItemDetailId+"").val();
                    console.log(numQty);


                    if(numQty == 125){
                        if($(this).val().length == 1)
                        {

                            $("."+orderItemDetailId+"rowspans").prop("rowspan", "6");

                            $("."+orderItemDetailId+"row4Hidden").removeAttr('hidden');

                        }
                    }

                    if(numQty >= 100 && numQty < 125){
                        if($(this).val().length == 1)
                        {

                            $("."+orderItemDetailId+"rowspans").prop("rowspan", "5");

                            $("."+orderItemDetailId+"row3Hidden").removeAttr('hidden');

                        }
                    }

                    if(numQty >= 75 && numQty < 100){
                        console.log('75 if ekt awa');

                        if($(this).val().length == 1)
                        {

                            $("."+orderItemDetailId+"rowspans").prop("rowspan", "4");

                            $("."+orderItemDetailId+"row2Hidden").removeAttr('hidden');

                        }
                    }
                    if(numQty >= 50 && numQty < 75)
                    {
                        if($(this).val().length == 1)
                        {

                            $("."+orderItemDetailId+"rowspans").prop("rowspan", "3");

                            $("."+orderItemDetailId+"row1Hidden").removeAttr('hidden');

                        }

                        var below2Lenght = 0;
                        if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                            below2Lenght = $(this).closest('tr').next().next().next().find('.counted').length;
                        }else if($(this).closest('td').find('.below').length == 1){
                            below2Lenght = $(this).closest('tr').next().next().find('.counted').length;
                        }else if($(this).closest('td').find('.below1').length == 1){
                            below2Lenght = $(this).closest('tr').next().find('.counted').length;
                        }else if($(this).closest('td').find('.below2').length == 1){
                            below2Lenght = $(this).closest('tr').find('.counted').length;
                        }

                        if(below2Lenght == 0)
                        {
                            $("."+orderItemDetailId+"rowspans").prop("rowspan", "3");
                            $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                        }

                    }
                    if(numQty < 50){
                        console.log('print6');
                        var below1Lenght = 0;
                        if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                            below1Lenght = $(this).closest('tr').next().next().find('.counted').length;
                        }else if($(this).closest('td').find('.below').length == 1){
                            below1Lenght = $(this).closest('tr').next().find('.counted').length;
                        }else if($(this).closest('td').find('.below1').length == 1){
                            below1Lenght = $(this).closest('tr').find('.counted').length;
                        }else if($(this).closest('td').find('.below2').length == 1){
                            below1Lenght = $(this).closest('tr').prev().find('.counted').length;
                        }

                        var below2Lenght = 0;
                        if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                            below2Lenght = $(this).closest('tr').next().next().next().find('.counted').length;
                        }else if($(this).closest('td').find('.below').length == 1){
                            below2Lenght = $(this).closest('tr').next().next().find('.counted').length;
                        }else if($(this).closest('td').find('.below1').length == 1){
                            below2Lenght = $(this).closest('tr').next().find('.counted').length;
                        }else if($(this).closest('td').find('.below2').length == 1){
                            below2Lenght = $(this).closest('tr').find('.counted').length;
                        }

                        if(below1Lenght == 0 && below2Lenght == 0)
                        {
                            $("."+orderItemDetailId+"rowspans").prop("rowspan", "2");
                            $("."+orderItemDetailId+"row1Hidden").prop("hidden", true);
                            $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                        }
                    }
                }
                else{

                    var below1Lenght = 0;
                    if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                        below1Lenght = $(this).closest('tr').next().next().find('.counted').length;
                    }else if($(this).closest('td').find('.below').length == 1){
                        below1Lenght = $(this).closest('tr').next().find('.counted').length;
                    }else if($(this).closest('td').find('.below1').length == 1){
                        below1Lenght = $(this).closest('tr').find('.counted').length;
                    }else if($(this).closest('td').find('.below2').length == 1){
                        below1Lenght = $(this).closest('tr').prev().find('.counted').length;
                    }

                    var below2Lenght = 0;
                    if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0){
                        below2Lenght = $(this).closest('tr').next().next().next().find('.counted').length;
                    }else if($(this).closest('td').find('.below').length == 1){
                        below2Lenght = $(this).closest('tr').next().next().find('.counted').length;
                    }else if($(this).closest('td').find('.below1').length == 1){
                        below2Lenght = $(this).closest('tr').next().find('.counted').length;
                    }else if($(this).closest('td').find('.below2').length == 1){
                        below2Lenght = $(this).closest('tr').find('.counted').length;
                    }



                    var orderItemDetailId = $(this).attr("data-orderItemDetailId");
                    var numQty = $(".qtyseq"+orderItemDetailId+"").val();
                    if(numQty < 50)
                    {
                        if(below1Lenght == 0 && below2Lenght == 0)
                        {
                            $("."+orderItemDetailId+"rowspans").prop("rowspan", "2");
                            $("."+orderItemDetailId+"row1Hidden").prop("hidden", true);
                            $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                            $("."+orderItemDetailId+"row3Hidden").prop("hidden", true);
                            $("."+orderItemDetailId+"row4Hidden").prop("hidden", true);
                        }
                    }
                    else if(numQty >= 50 && numQty < 75)
                    {
                        if(below2Lenght == 0)
                        {
                            $("."+orderItemDetailId+"rowspans").prop("rowspan", "3");
                            $("."+orderItemDetailId+"row2Hidden").prop("hidden", true);
                            $("."+orderItemDetailId+"row3Hidden").prop("hidden", true);
                            $("."+orderItemDetailId+"row4Hidden").prop("hidden", true);
                        }

                    }
                }
            });
        $('#btn_add_ex_factory').on('click', function(){
            var order = @json($order);
            var order_items = order.order_items[0];
            var itemId = order_items.id;
            var ex_factory_name = $('#ex_factory_name').val();
            var ex_factory_po_box = $('#ex_factory_po_box').val();
            var ex_factory_city = $('#ex_factory_city').val();
            var ex_factory_state = $('#ex_factory_state').val();
            var ex_factory_postal_code = $('#ex_factory_postal_code').val();
            var ex_factory_country = $('#ex_factory_country').val();
            var ex_factory_apartment = $('#ex_factory_apartment').val();


            $.ajax({
                url: "{{route('itemex_factory.create')}}",
                type: "POST",
                data: {
                    'ex_factory_name': ex_factory_name, 'ex_factory_po_box': ex_factory_po_box, 'ex_factory_city':ex_factory_city, 'ex_factory_state':ex_factory_state,
                    'ex_factory_postal_code':ex_factory_postal_code, 'ex_factory_country':ex_factory_country, '_token':'{{csrf_token()}}','ItemId':itemId,'ex_factory_apartment':ex_factory_apartment
                },
                beforeSend: function(){
                    $(".se-pre-con").fadeIn();
                },
                success: function (response) {
                    $('#add_ex_factory_modal').modal('hide');
                    $('#ex_factory_name').val('');
                    $('#ex_factory_po_box').val('');
                    $('#ex_factory_city').val('');
                    $('#ex_factory_state').val('');
                    $('#ex_factory_postal_code').val('');
                    $('#ex_factory_country').val('');
                    $('#ex_factory_apartment').val('');
                    $(".se-pre-con").fadeOut();

                    var newOption = new Option(response.ex_factory_name, `ex_${response.id}`, false, true);
                    $(newOption)
                        .attr('data-type', 'exFactory')
                        .attr('data-tableid', response.id);

                    $('#exfactoryAddress')
                        .append(newOption)
                        .trigger('change');
                }
            });



        });
        function changeItemStyleName(itemID){

            var item_style_id = $("#styleName").val();

            var sub_products = @json($subProducts);

            var filteredSubProduct = sub_products.find(function(subProduct) {
                return subProduct.sub_product_no == item_style_id;
            });
            console.log(filteredSubProduct);

            $('#display_name').val(filteredSubProduct.product_name);

            changeProductName(filteredSubProduct.id , itemID , false);
        }
        function changeProductName(subProductId , itemID , isworking){
            var order = @json($order);
            var order_item = order.order_items[0];
            var isworking = isworking;
            console.log('order item');
            console.log(order_item);

            $.ajax({
                url:"{{ route('filter_sub_products') }}",
                method:'GET',
                dataType:'json',
                data:{ subProductId : subProductId},
                beforeSend: function(){
                    $(".se-pre-con").fadeIn();
                },
                success: function (response){
                    $(".se-pre-con").fadeOut();
                    console.log('product no :'+response.sub_product.sub_product_no);

                    $("#item_style_patter_code_"+itemID).val(response.sub_product.pattern_code);
                    $("#unitprice_"+itemID).val(response.sub_product.default_price);

                    console.log('is hat value'+response.is_hat);

                    if(response.is_hat == true){
                        $('.forClouser').show();
                    }else{
                        $('.forClouser').hide();
                        $('#clouser_type_item').val('').trigger('change');
                    }


                    $("#orderItem_primaryFabric_" + itemID).html('');
                    if(response.is_hat){
                        $("#orderItem_primaryFabric_" + itemID).prop('disabled', false);
                        var fabrics = @json($fabrics);
                        fabrics = fabrics.filter(function(fabric) {
                            return fabric.available_for_hats == 1;
                        });
                        if (fabrics.length > 0) {
                            $('<option value="" selected>Select Fabric</option>').appendTo($("#orderItem_primaryFabric_" + itemID));
                            for (var i = 0; i < fabrics.length; i++) {
                                if(fabrics[i].id == order_item.fabric_id && isworking){var isSelected = 'selected'}else{var isSelected = ''}
                                console.log('selected value: '+isSelected);
                                $('<option value="'+fabrics[i].id+'" '+isSelected+'>'+fabrics[i].fabric_name+'</option>').appendTo($("#orderItem_primaryFabric_" + itemID));
                            }
                        }

                    }else{
                        $("#orderItem_primaryFabric_" + itemID).prop('disabled', true);
                        console.log('fabric is : '+response.product_fabric);
                        if(response.product_fabric !== null){

                            $('<option value="" selected>'+response.product_fabric+'</option>').appendTo($("#orderItem_primaryFabric_" + itemID));

                        }else{
                            $('<option value="" selected>No fabric</option>').appendTo($("#orderItem_primaryFabric_" + itemID));
                        }
                    }

                    var embellishmentTypeList = response.product_embellishment_type;

                    $("#orderItem_estabilishment_"+itemID).html('');
                    if(embellishmentTypeList.length > 0){

                        $('<option value="">Select an Embellishment</option>').appendTo($("#orderItem_estabilishment_"+itemID));

                        for(var i = 0; i < embellishmentTypeList.length; i++){
                            if(embellishmentTypeList[i].id == order_item.embellishment_type_id && isworking){var isSelected = 'selected'}else{var isSelected = ''}
                            $('<option value="'+ embellishmentTypeList[i].id +'"'+isSelected+'>'+embellishmentTypeList[i].embellishment_name+'</option>').appendTo($("#orderItem_estabilishment_"+itemID));
                        }
                    } else {
                        $('<option value="">No Embellishment</option>').appendTo($("#orderItem_estabilishment_"+itemID));
                    }

                    var productFactory = response.product_factories;

                    $('#factory').html('');

                    if(productFactory.length > 0){
                        if(productFactory.length > 1){
                            for(var i = 0; i < productFactory.length; i++){
                                $('<option value="'+ productFactory[i].id +'">'+productFactory[i].factory_code+'</option>').appendTo($('#factory'));
                            }
                        }else{
                            $('<option value="'+ productFactory[0].id +'" selected>'+productFactory[0].factory_code+'</option>').appendTo($('#factory'));
                        }
                    }

                    if(isworking){
                        $('#secondary_fabric').val(order_item.secondary_fabric_id).trigger('change');
                    }else{
                        $('#secondary_fabric').val('').trigger('change');
                    }


                }
            });
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function orderItemUpdate() {

        }

        function DownloadOrderItemFiles() {
            var order_id = $('#order_id').val();
            var organization_name = $('#get_organization_name').val();
            console.log(order_id);
            console.log(organization_name);
            $.ajax({
                url: '{{ url("orders/items_design") }}/' + order_id,
                method: 'GET',
                success: function(response) {
                    if (response.message === 'Folder created') {
                        console.log(response.message);
                        console.log(response.folderPath);
                        console.log(response.organizationName);
                        console.log(response.orderItemIds);

                        addFilesToZip(order_id, response.folderPath, response.organizationName, response.orderItemIds);
                    }
                }
            });

        }
        function showProgressModal() {
            $('#progress-modal').show();
        }

        function hideProgressModal() {
            $('#progress-bar').css('width', 0 + '%');
            $('#progress-text').text(`Progress: 0%`);
            $('#progress-modal').hide();
        }

        function addFilesToZip(orderId, folderPath, organizationName, orderItemsArray) {
            let totalItems = orderItemsArray.length;
            let completedItems = 0;

            showProgressModal();

            orderItemsArray.forEach(function(orderItemId) {
                $.ajax({
                    url: '{{ url("orders/items_design/add-files-to-zip") }}/' + orderId + '/' + orderItemId,
                    method: 'POST',
                    data: {
                        folderPath: folderPath,
                        organizationName: organizationName,
                        orderItemId: orderItemId,
                        orderId: orderId,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.message === 'Files added to folder') {
                            completedItems++;
                            let progress = (completedItems / totalItems) * 100;
                            $('#progress-bar').css('width', progress + '%');
                            $('#progress-text').text(`Progress: ${Math.round(progress)}%`);

                            // If all items are added, download the folder
                            if (completedItems === totalItems) {
                                $('#progress-text').text(`Please be patient and wait a moment. Do not close this page.`);
                                downloadFolder(folderPath);
                            }
                        }
                    },
                    error: function() {
                        alert('Error processing order item ' + orderItemId);
                    }
                });
            });
        }
        function downloadFolder(folderPath) {
            $('#progress-headding').text('Downloading Files...');
            $('#progress-sub-headding').text('Please wait while your files are being downloaded.');
            $('#progress-bar').css('width', 0 + '%');
            $.ajax({
                url: '{{ url("/download-folder") }}',
                method: 'GET',
                data: {
                    folderPath: folderPath
                },
                xhrFields: {
                    responseType: 'blob'
                },
                xhr: function() {
                    let xhr = new XMLHttpRequest();
                    xhr.onprogress = function(event) {
                        if (event.lengthComputable) {
                            let percentComplete = (event.loaded / event.total) * 100;
                            let downloadedMB = (event.loaded / (1024 * 1024)).toFixed(2);
                            let totalMB = (event.total / (1024 * 1024)).toFixed(2);

                            // Update the progress bar and text
                            $('#progress-bar').css('width', percentComplete + '%');
                            $('#progress-text').text(`Downloaded ${downloadedMB} MB of ${totalMB} MB`);
                        }
                    };
                    return xhr;
                },
                success: function(blob) {
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = folderPath.split('/').pop() + '.zip';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    hideProgressModal();  // Hide the modal after the download is triggered
                },
                error: function() {
                    alert('Failed to download the folder.');
                    hideProgressModal();  // Hide the modal even if there's an error
                }
            });
        }
        $(document).ready(function(){
            $(".se-pre-con").fadeOut('slow');
            $('.ex-factory').on('change', function(){
                var order = @json($order);
                var order_items = order.order_items[0];
                var itemId = order_items.id;
                var exFactoryId =$(this).val();
                var selectedOption = $(this).find('option:selected');
                var selectedType = selectedOption.data('type');
                function safeValue(value) {
                    return value ? value : ''; // Replace null/undefined with an empty string
                }

                if(exFactoryId == 0){
                    if(order.is_new_shipping_address == 3){
                        $('.ex-factory-address-line1.' + itemId).html('');
                        $('.ex-factory-address-line1.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                            [safeValue(order.contact_details.apartment2), safeValue(order.contact_details.shipping_street_2)].filter(Boolean).join(', ')
                             + '" readonly/>'
                        );

                        // Set Address Line 2
                        $('.ex-factory-address-line2.' + itemId).html('');
                        $('.ex-factory-address-line2.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                            [safeValue(order.contact_details.shipping_city_2), safeValue(order.contact_details.shipping_state_2),safeValue(order.contact_details.shipping_zip_2)].filter(Boolean).join(', ') +
                            '" readonly/>'
                        );

                        // Set Address Line 3
                        $('.ex-factory-address-line3.' + itemId).html('');
                        $('.ex-factory-address-line3.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                            safeValue(order.contact_details.shipping_country_2) +
                            '" readonly/>'
                        );
                    }else if(order.is_new_shipping_address == 1){
                        $('.ex-factory-address-line1.' + itemId).html('');
                        $('.ex-factory-address-line1.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                            [safeValue(order.apartment), safeValue(order.street)].filter(Boolean).join(', ')
                             + '" readonly/>'
                        );

                        // Set Address Line 2
                        $('.ex-factory-address-line2.' + itemId).html('');
                        $('.ex-factory-address-line2.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                            [safeValue(order.city), safeValue(order.state),safeValue(order.postal_code)].filter(Boolean).join(', ') +
                            '" readonly/>'
                        );

                        // Set Address Line 3
                        $('.ex-factory-address-line3.' + itemId).html('');
                        $('.ex-factory-address-line3.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                             safeValue(order.country) +
                            '" readonly/>'
                        );
                    }else{
                        $('.ex-factory-address-line1.' + itemId).html('');
                        $('.ex-factory-address-line1.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                            [safeValue(order.contact_details.apartment), safeValue(order.contact_details.shipping_street)] + '" readonly/>'
                        );

                        // Set Address Line 2
                        $('.ex-factory-address-line2.' + itemId).html('');
                        $('.ex-factory-address-line2.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                            [safeValue(order.contact_details.shipping_city), safeValue(order.contact_details.shipping_state),safeValue(order.contact_details.shipping_zip)].filter(Boolean).join(', ') +
                            '" readonly/>'
                        );

                        // Set Address Line 3
                        $('.ex-factory-address-line3.' + itemId).html('');
                        $('.ex-factory-address-line3.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                            safeValue(order.contact_details.shipping_country)+
                            '" readonly/>'
                        );
                    }

                } else {

                    if(selectedType === 'add_new'){
                        // $('.ex-factory').val(null).trigger('change');
                        // Open a modal or form to add a new Ex Factory
                        openAddNewModal();
                    }else if(selectedType === 'contact'){
                        var contacts = order.contact_organizations;
                        var exFactoryId1 = exFactoryId.replace('con_', '');
                        var filtercontact = contacts.find(function(contact) {
                            return contact.contact_id == exFactoryId1;
                        });
                        console.log(filtercontact);
                        var details = filtercontact.contacts[0];
                        $('.ex-factory-address-line1.' + itemId).html('');
                        $('.ex-factory-address-line1.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                            [safeValue(details.apartment), safeValue(details.shipping_street)].filter(Boolean).join(', ')
                             + '" readonly/>'
                        );

                        // Set Address Line 2
                        $('.ex-factory-address-line2.' + itemId).html('');
                        $('.ex-factory-address-line2.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                            [safeValue(details.shipping_city), safeValue(details.shipping_state),safeValue(details.shipping_zip)].filter(Boolean).join(', ') +
                            '" readonly/>'
                        );

                        // Set Address Line 3
                        $('.ex-factory-address-line3.' + itemId).html('');
                        $('.ex-factory-address-line3.' + itemId).append(
                            '<input class="form-control" type="text" value="' +
                             safeValue(details.shipping_country) +
                            '" readonly/>'
                        );

                    }else if(selectedType === 'exFactory'){
                        var exFactories = @json($exFactoriesData);
                        var exFactoryId2 = exFactoryId.replace('ex_', '');
                        var exFactory = exFactories.find(function(factory) {
                            return factory.id == exFactoryId2;
                        });
                        console.log(exFactory);

                        if(exFactory){

                            // Set Address Line 1
                            $('.ex-factory-address-line1.' + itemId).html('');
                            $('.ex-factory-address-line1.' + itemId).append(
                                '<input class="form-control" type="text" value="' +
                                [safeValue(exFactory.apartment),safeValue(exFactory.po_box)].filter(Boolean).join(', ') + '" readonly/>'
                            );

                            // Set Address Line 2
                            $('.ex-factory-address-line2.' + itemId).html('');
                            $('.ex-factory-address-line2.' + itemId).append(
                                '<input class="form-control" type="text" value="' +
                                [safeValue(exFactory.city), safeValue(exFactory.state),safeValue(exFactory.postal_code)].filter(Boolean).join(', ') +
                                '" readonly/>'
                            );

                            // Set Address Line 3
                            $('.ex-factory-address-line3.' + itemId).html('');
                            $('.ex-factory-address-line3.' + itemId).append(
                                '<input class="form-control" type="text" value="' +
                                 safeValue(exFactory.country)+
                                '" readonly/>'
                            );
                        }else{
                            console.log('meek2');
                            var exFactoryIdInt = parseInt(exFactoryId2);
                            $.ajax({
                                type: "GET",
                                url: '{{ url("ex_factory/get_address") }}/'+itemId+'/'+exFactoryIdInt,
                                beforeSend: function(){
                                    $(".se-pre-con").fadeIn();
                                },
                                success: function(response) {
                                    $(".se-pre-con").fadeOut();
                                    response = response.data;
                                    console.log(response);

                                    // Set Address Line 1
                                    $('.ex-factory-address-line1.' + itemId).html('');
                                    $('.ex-factory-address-line1.' + itemId).append(
                                        '<input class="form-control" type="text" value="' +
                                        [safeValue(response.apartment),safeValue(response.po_box)].filter(Boolean).join(', ') + '" readonly/>'
                                    );

                                    // Set Address Line 2
                                    $('.ex-factory-address-line2.' + itemId).html('');
                                    $('.ex-factory-address-line2.' + itemId).append(
                                        '<input class="form-control" type="text" value="' +
                                        [safeValue(response.city), safeValue(response.state),safeValue(response.postal_code)].filter(Boolean).join(', ') +
                                        '" readonly/>'
                                    );

                                    // Set Address Line 3
                                    $('.ex-factory-address-line3.' + itemId).html('');
                                    $('.ex-factory-address-line3.' + itemId).append(
                                        '<input class="form-control" type="text" value="' +
                                        safeValue(response.country)+
                                        '" readonly/>'
                                    );

                                },
                                error: function(xhr, status, error) {
                                    $(".se-pre-con").fadeOut();
                                    console.error('Error:', error);
                                }
                            });
                        }
                    }

                }
            });
            function openAddNewModal() {
                // Example Bootstrap modal
                $('#add_ex_factory_modal').modal('show');
            }
            $('.myForm').on('submit', function(e){
                e.preventDefault();
                $(".se-pre-con").fadeIn('slow');
                $(".myForm :input:not(.tablinks):not(.tablinksCustom):not(.no-disable)").prop('disabled', false);
                $("#order_detail_form :input:not(.no-disable)").prop('disabled', false);
                $('.notify_changes').val($.unique(numberSequencesFilled));
                this.submit();
            });

            $('#re_order_form').on('submit', function(){
                $(".se-pre-con").fadeIn('slow');
            });

            var activeTabId = $('#active_tab_id').val();



            var notifyField = $('#notify_field_id').val();
            if(notifyField){
                // $("input[name='"+notifyField+"']").addClass('highlight');
                // $("input[name='"+notifyField+"']").focus();
                if(notifyField.includes("double_sided") || notifyField.includes("individual_no") || notifyField.includes("pockets") || notifyField.includes("individual_name") || notifyField.includes("zipper_pockets") || notifyField.includes("dynamic_details") || notifyField.includes("contrast_stratching") || notifyField.includes("printing_over_sems")){
                    $("[name='lbl_"+notifyField+"']").addClass("highlight");
                }else{
                    $("[name='"+notifyField+"']").removeClass("select2-edit-order").addClass("highlight");
                }
            }


        getFiles();

        $("body").on("click", ".delete-order", function(){
            var orderId = $(this).data('order-id');

            swal({
                title: "Confirm Delete?",
                text: "Do You Want to Delete This OrderItem?",
                type: "warning",
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                confirmButtonColor: '#2dce89',
                closeOnConfirm: false,
                closeOnCancel: true
            })
            .then(function(willDelete){
                if (willDelete.value) {
                    // Use the route() function to generate the URL
                    var deleteUrl = "{{ route('deleteOrder', ['id' => ':orderId']) }}";
                    deleteUrl = deleteUrl.replace(':orderId', orderId);
                    window.location.href = deleteUrl;
                } else if(willDelete.dismiss == 'cancel') {
                    console.log('cancel');
                }
            });
        });


        // Update Order
            $('.save_btn').on('click', function(){
                $("#order_update_btn").trigger("click");
            });

        // Cancel Option
            $('.cancel_btn').on('click', function(){
                location.reload();
            });

        // Generate Quote PDF
            // $('.generate_quote_btn').on('click', function(){
            //     $('#buffering_icon').attr('display', 'block');

            //     var orderId = $(this).val();
            //     window.location.replace('../../orders/quote/'+orderId);
            // });
            $('.generate_quote_btn').on('click', function(){
                var orderId = $(this).val();
                var routeUrl = '{{ route('quotePDF_Download', ['id' => ':id']) }}';
                routeUrl = routeUrl.replace(':id', orderId);
                window.location.replace(routeUrl);
            });

        // Generate Quote CSV
            // $('.generate_csv_btn').on('click', function(){
            //     $('#buffering_icon').attr('display', 'block');

            //     var orderId = $(this).val();
            //     window.location.replace('../../orders/csv/'+orderId);
            // });
            $('.generate_csv_btn').on('click', function(){
                var orderId = $(this).val();
                var routeUrl = '{{ route('quoteCSV_Download', ['id' => ':id']) }}';
                routeUrl = routeUrl.replace(':id', orderId);
                window.location.replace(routeUrl);
            });

        // Generate Invoice PDF
            // $('.generate_invoice_btn').on('click', function(){
            //     $('#buffering_icon').attr('display', 'block');

            //     var orderId = $(this).val();
            //     window.location.replace('../../orders/invoice/'+orderId);
            // });

            $('.generate_invoice_btn').on('click', function(){
                var orderId = $(this).val();
                var routeUrl = '{{ route('invoice_Download', ['id' => ':id']) }}';
                routeUrl = routeUrl.replace(':id', orderId);
                window.location.replace(routeUrl);
            });

        // Generate Link
            $('.generate_link_btn').on('click', function(){
                var orderId = $(this).val();

                $('#link_container').html('');
                $('#link_container').html('<input type="text" id="customer_roster_link" class="invoice-inputs" value="https://encr.co/customer_portal/order_view/'+orderId+'" style="width: 80%; background-color: white;" />');
                // $('#link_container').html('<input type="text" class="invoice-inputs" value="http://localhost/roster/'+orderId+'" style="width: 50%;" />');
                //$('#copy_link_btn').show();
                // $('html, body').animate({ scrollTop: $('#link_container').offset().top }, 'slow');
                urlCopyToClipboard();
            });

        // Generate Quote PDF
            $('.generate_pdf_btn').on('click', function(){
                var orderId = $(this).val();
                var routeUrl = '{{ route('PDF_Download', ['id' => ':id']) }}';
                routeUrl = routeUrl.replace(':id', orderId);
                window.location.replace(routeUrl);
            });

        // Accept Request
            $("body").on("click", "#accept_request_btn", function(){
                var orderId = $(this).val();

                swal({
                    title: "Accept Request?",
                    text: "Do You Want to Accept This Request?",
                    type: "warning",
                    buttons: true,
                    dangerMode: true,
                    confirmButtonColor: '#06c5ac',
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.replace('../../order_details/accept_request/'+orderId);
                    }
                });
            });
            function urlCopyToClipboard(){
                var customerRosterLinkValue = document.getElementById('customer_roster_link').value;
                //console.log(customerRosterLinkValue);
                navigator.clipboard.writeText(customerRosterLinkValue);
                Swal.fire({
                    title: "The URL has been successfully copied",
                    icon: "success",
                    buttonsStyling: false, // Disable default button styling
                    confirmButtonColor: '#0bd700', // Set the button color
                    confirmButtonText: 'OK', // Set the button text
                });
            }

            // Add Extra Sizes
            var action = 1;
            $("body").on("click", ".add-size", function(){
                var order_id = $(this).val();
                if ( action == 1 ) {
                    $(".order-"+order_id+"-18").show();
                    $(".order-"+order_id+"-21").show();
                    $(".order-"+order_id+"-24").show();
                    action = 2;

                } else {
                    $(".order-"+order_id+"-19").show();
                    $(".order-"+order_id+"-22").show();
                    $(".order-"+order_id+"-25").show();
                    action = 1;
                }
            });


        // adding classes to inserted no sequence
            $('body .numseq').filter(function() {
                return $(this).val() != "" && $(this);
            }).addClass("counted");

            calculateTOTALalQtys();
            calculateTOTALalQtysDefault();

        //calculate TOTALal qty When Adding No sequence
            $("body").on('input', '.numseq', function (){

                if($(this).val() != ''){
                    $(this).addClass("counted");
                }else if($(this).val() == ''){
                    $(this).removeClass("counted");
                }

                if($(this).closest('td').find('.below').length == 0 && $(this).closest('td').find('.below1').length == 0 && $(this).closest('td').find('.below2').length == 0 && $(this).closest('td').find('.below3').length == 0 && $(this).closest('td').find('.below4').length == 0) {
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 1
                    var countedBelow = $(this).closest('tr').next().find('.counted').length; // row 2
                    var countedBelow1 = $(this).closest('tr').next().next().find('.counted').length; // row 3
                    var countedBelow2 = $(this).closest('tr').next().next().next().find('.counted').length; // row 4
                    var countedBelow3 = $(this).closest('tr').next().next().next().next().find('.counted').length; // row 5
                    var countedBelow4 = $(this).closest('tr').next().next().next().next().next().find('.counted').length; // row 6
                    var TOTALal_count = countedThis + countedBelow + countedBelow1 + countedBelow2 + countedBelow3 + countedBelow4;
                    $(this).closest('tr').find('.qtyseq').val(TOTALal_count);
                } else if($(this).closest('td').find('.below').length == 1) {
                    var countedUpper = $(this).closest('tr').prev().find('.counted').length; // row 1
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 2
                    var countedBelow1 = $(this).closest('tr').next().find('.counted').length; // row 3
                    var countedBelow2 = $(this).closest('tr').next().next().find('.counted').length; // row 4
                    var countedBelow3 = $(this).closest('tr').next().next().next().find('.counted').length; // row 5
                    var countedBelow4 = $(this).closest('tr').next().next().next().next().find('.counted').length; // row 6
                    var TOTALal_count = countedThis + countedUpper + countedBelow1 + countedBelow2 + countedBelow3 + countedBelow4;
                    $(this).closest('tr').prev().find('.qtyseq').val(TOTALal_count);
                } else if($(this).closest('td').find('.below1').length == 1) {
                    var countedbelow2 = $(this).closest('tr').next().next().next().find('.counted').length; // row 6
                    var countedbelow1 = $(this).closest('tr').next().next().find('.counted').length; // row 5
                    var countedbelow = $(this).closest('tr').next().find('.counted').length; // row 4
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 3
                    var countedUpper1 = $(this).closest('tr').prev().find('.counted').length; // row 2
                    var countedUpper2 = $(this).closest('tr').prev().prev().find('.counted').length; // row 1
                    var TOTALal_count = countedThis + countedUpper1 + countedUpper2 + countedbelow + countedbelow1 + countedbelow2;
                    $(this).closest('tr').prev().prev().find('.qtyseq').val(TOTALal_count);
                } else if($(this).closest('td').find('.below2').length == 1) {
                    var countedbelow1 = $(this).closest('tr').next().next().find('.counted').length; // row 6
                    var countedbelow = $(this).closest('tr').next().find('.counted').length; // row 5
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 4
                    var countedUpper1 = $(this).closest('tr').prev().find('.counted').length; // row 3
                    var countedUpper2 = $(this).closest('tr').prev().prev().find('.counted').length; // row 2
                    var countedUpper3 = $(this).closest('tr').prev().prev().prev().find('.counted').length; // row 1
                    var TOTALal_count = countedbelow + countedbelow1 + countedThis + countedUpper1 + countedUpper2 + countedUpper3;
                    $(this).closest('tr').prev().prev().prev().find('.qtyseq').val(TOTALal_count);
                }
                else if ($(this).closest('td').find('.below3').length == 1) {
                    var countedbelow = $(this).closest('tr').next().find('.counted').length; // row 6
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 5
                    var countedUpper1 = $(this).closest('tr').prev().find('.counted').length; // row 4
                    var countedUpper2 = $(this).closest('tr').prev().prev().find('.counted').length; // row 3
                    var countedUpper3 = $(this).closest('tr').prev().prev().prev().find('.counted').length; // row 2
                    var countedUpper4 = $(this).closest('tr').prev().prev().prev().prev().find('.counted').length; // row 1
                    console.log('here');
                    console.log(countedbelow,countedThis,countedUpper1,countedUpper2,countedUpper3,countedUpper4);
                    var TOTALal_count = countedbelow + countedThis + countedUpper1 + countedUpper2 + countedUpper3 + countedUpper4;
                    $(this).closest('tr').prev().prev().prev().prev().find('.qtyseq').val(TOTALal_count);
                } else if ($(this).closest('td').find('.below4').length == 1) {
                    var countedThis = $(this).closest('tr').find('.counted').length; // row 6
                    var countedUpper1 = $(this).closest('tr').prev().find('.counted').length; // row 5
                    var countedUpper2 = $(this).closest('tr').prev().prev().find('.counted').length; // row 4
                    var countedUpper3 = $(this).closest('tr').prev().prev().prev().find('.counted').length; // row 3
                    var countedUpper4 = $(this).closest('tr').prev().prev().prev().prev().find('.counted').length; // row 2
                    var countedUpper5 = $(this).closest('tr').prev().prev().prev().prev().prev().find('.counted').length; // row 1
                    var TOTALal_count = countedThis + countedUpper1 + countedUpper2 + countedUpper3 + countedUpper4 + countedUpper5;
                    $(this).closest('tr').prev().prev().prev().prev().prev().find('.qtyseq').val(TOTALal_count);
                }

                calculateTOTALalQtys();
            });

        //calculate TOTALal qty When Adding Blanks
            $("body").on('input', '.blankseq', function () {
                calculateTOTALalQtys();
            });
        });
        getFiles();
        function calculateTOTALalQtys() {

            var order = @json($order);
            var order_items = order.order_items;

                for(var i = 0; i < order_items.length; i++){

                 // getting TOTALal number sequense count
                    var TOTALnums =$('#tab_'+order_items[i].id+' .numseq').filter(function() {
                        return $(this).val() != "" && $(this);
                    }).length;
                    $('#TOTALnums_'+order_items[i].id).val(TOTALnums);
                    console.log(TOTALnums);

                 // getting TOTALal blanks count
                    var TOTALblanks =$('#tab_'+order_items[i].id+' .blankseq').filter(function() {
                        return $(this).val() != "" && $(this);
                    });
                    var blankVals = 0;
                    for(var j = 0; j < TOTALblanks.length; j++){
                        blankVals += parseFloat(TOTALblanks[j].value);
                    }
                    $('#TOTALblanks_'+order_items[i].id).val(blankVals);

                 // getting TOTALal qty count
                    var TOTALqty = TOTALnums + blankVals;
                    $('#TOTALqty_'+order_items[i].id).val(TOTALqty);
                }

        }
        function calculateTOTALalQtysDefault() {

            var order = @json($order);
            var order_items = order.order_items;

                for(var i = 0; i < order_items.length; i++){
                    // console.log(order_items[i].id);
                    // getting TOTALal number sequense count
                    var TOTALnums =$('#tab_'+order_items[i].id+' .numseq').filter(function() {
                        return $(this).val() != "" && $(this);
                    }).length;
                    //$('#TOTALnums_'+order_items[i].id).val(TOTALnums);
                    $('#TOTALnums_'+order_items[i].id).attr("data-AlradySaved",TOTALnums);
                    console.log('#TOTALnums_'+order_items[i].id);

                    // getting TOTALal blanks count
                    var TOTALblanks =$('#tab_'+order_items[i].id+' .blankseq').filter(function() {
                        return $(this).val() != "" && $(this);
                    });
                    var blankVals = 0;
                    for(var j = 0; j < TOTALblanks.length; j++){
                        blankVals += parseFloat(TOTALblanks[j].value);
                    }
                    //$('#TOTALblanks_'+order_items[i].id).val(blankVals);
                    $('#TOTALblanks_'+order_items[i].id).attr("data-AlradySaved",blankVals);

                    // getting TOTALal qty count
                    var TOTALqty = TOTALnums + blankVals;
                    //$('#TOTALqty_'+order_items[i].id).val(TOTALqty);
                    $('#TOTALqty_'+order_items[i].id).attr("data-AlradySaved",TOTALqty);
                    console.log('#TOTALqty_'+order_items[i].id);
                }

        }
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
        var ItemForm = null;

        $(".nav-tab-item").click(function(){
            $("#"+$(this).attr("data-RosterForm")).click();

            if(numberSequencesFilled.length >= 1){
                var elementID = $(this).attr("id");

                if($(this).attr("data-section") == "rosterPlayerNames")  {
                    var buttons = $('<div>').append("There are unsaved changes. Are you sure that you want to leave this form?<br><br><button data-clickedItem='"+elementID+"' type='button' class='btn btn-secondary LeaveNotSave'>Leave & Don't Save</button>").append("<button data-clickedItem='"+elementID+"' type='button' class='btn btn-success onlySave'>Save</button>").append("<button type='button' class='btn btn-danger btnCancelSwal'>Cancel</button>");
                } else {
                    var buttons = $('<div>').append("There are unsaved changes. Are you sure that you want to leave this form?<br><br><button data-clickedItem='"+elementID+"' type='button' class='btn btn-secondary LeaveNotSave'>Leave & Don't Save</button>").append("<button data-clickedItem='"+elementID+"' type='button' class='btn btn-success saveAndLeave'>Save & Leave</button>").append("<button type='button' class='btn btn-danger btnCancelSwal'>Cancel</button>");
                }

                swal({
                    title: "Are you sure?",
                    text: "Do You Want to Delete This OrderItem?",
                    html: buttons,
                    type: "warning",
                    showConfirmButton: false,
                    showCancelButton: false
                });

                return false;
            } else {
                if($(this).attr("formid")) {
                    ItemForm = $(this).attr("formid");
                } else {
                    ItemForm = null;
                }
            }
        });

        $(document).on('click', '.LeaveNotSave', function() {
            //Some code 1
            var elementID = $(this).attr("data-clickedItem");

            $.unique(numberSequencesFilled).forEach(clearTextBoxes);

            $(".TOTALblanks").each(function() {
                $(this).val($( this ).attr("data-alradysaved"));
            });
            $(".TOTALnums").each(function() {
                $(this).val($( this ).attr("data-alradysaved"));
            });
            $(".TOTALqty").each(function() {
                $(this).val($( this ).attr("data-alradysaved"));
            });

            numberSequencesFilled.length = 0;

            $("#"+elementID).click();

            console.log(numberSequencesFilled);
            swal.clickConfirm();

            // window.location.reload();

        });

        $(document).on('click', '.btnCancelSwal', function() {
            //Some code 1

            swal.clickConfirm();

        });

        $(document).on('click', '.onlySave', function() {
            if(ItemForm == null)
            {
                let searchParams = new URLSearchParams(window.location.search)
                if(searchParams.has('active_tab'))
                {
                    ItemForm= searchParams.get('active_tab');
                }
            }
            console.log(ItemForm);
            $('.notify_changes').val($.unique(numberSequencesFilled));
            $("#formItem"+ItemForm).submit();

        });

        $(document).on('click', '.saveAndLeave', function() {
            var elementID = $(this).attr("data-clickedItem");

            //Some code 1
            if(ItemForm == null)
            {
                let searchParams = new URLSearchParams(window.location.search)
                if(searchParams.has('active_tab'))
                {
                    ItemForm= searchParams.get('active_tab');
                }
            }

            $('.notify_changes').val($.unique(numberSequencesFilled));

            var dataString = $("#formItem"+ItemForm).serialize();
            dataString = "saveLeave=yes&"+dataString;
            $.ajax({
                type: "POST",
                url: "{{ route('order_sequence.update') }}",
                data: dataString,
                beforeSend: function(){
                    $(".se-pre-con").fadeIn();
                },
                success: function(data) {
                    $(".se-pre-con").fadeOut();
                    console.log(data);
                    if(data == "DoneAjaxPost")
                    {
                        numberSequencesFilled.length = 0;
                        swal.clickConfirm();
                        swal({
                            title: "Saved Details",
                            type: "success",
                            timer: 1000,
                            showConfirmButton: false,
                            showCancelButton: false
                        });

                        $('.notify_changes').val('');
                        $("#"+elementID).click();
                    } else {
                        swal({
                            title: "The order cannot be edited!",
                            type: "error",
                            text:"Please review the modified field values.",
                            timer: 3000,
                            showConfirmButton: false,
                            showCancelButton: false
                        });
                    }

                },
                error: function(xhr, textStatus, error){
                    $(".se-pre-con").fadeOut();
                    swal({
                        title: "The order cannot be edited!",
                        type: "error",
                        text:"Please review the modified field values.",
                        // text:error,
                        showConfirmButton: true,
                        showCancelButton: false
                    });
                }

            });
            //alert(dataString);


        });


        function clearTextBoxes(item) {
            console.log(item);
            $("input[name='"+item+"']").val($("input[name='"+item+"']").attr("data-alradysaved"));
            var orderItemDetailId = $("input[name='"+item+"']").attr("data-orderitemdetailid");
            $("input[name='product["+orderItemDetailId+"][qty]']").val($("input[name='product["+orderItemDetailId+"][qty]']").attr("data-alradysaved"));//qtyseq
        }

        const numberSequencesFilled = [];

        $(".myForm :input:not(#ex_factory_date):not(#due_date)").on("input change", function() {
            numberSequencesFilled.push($(this).attr("name"));
            console.log(numberSequencesFilled);
        });

        //     $(".numseq").on( "input", function() {

        //         numberSequencesFilled.push($(this).attr("name"));
        //         //console.log(numberSequencesFilled);
        //     });
        //     $(".blankseq").on( "input", function() {

        //        numberSequencesFilled.push($(this).attr("name"));
        //        //console.log(numberSequencesFilled);
        //    });
        //    $(".txtSizeName").on( "input", function() {

        //        numberSequencesFilled.push($(this).attr("name"));
        //        //console.log(numberSequencesFilled);
        //    });

        function openSize(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontentCustom");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinksCustom");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";

            evt.currentTarget.className += " active";

        }


        $(document).on('click', '.kv-file-download', function() {
            //Some code 1
        var stringDownload = $(this).attr("href");
        var newString = stringDownload.replace("&export=media", "&export=download");
        $(this).attr("href", newString);

        });

        $(".rosterPlayerNameSection").click(function(){
            var sectionLinks =  $(this).attr("data-sectionLinks");
            var section = $(this).attr("href");
            $(""+section+" .tabcontentCustom"+":not(:first)").css( "display", "none" );
            $("."+sectionLinks+" .tablinksCustom"+":not(:first)").removeClass("active");
            $("."+sectionLinks+" .tablinksCustom").first().addClass("active");
            $(""+section+" .tabcontentCustom").first().css( "display", "block" );
        });
        function getFiles() {
        var order = @json($order);
        var order_items = order.order_items[0];
        var orderId = order.id;
        console.log(orderId);

            var mockupPreloadImages = [];
            var mockupPreloadImagedetails = [];

            var techPackPreloadFiles = [];
            var techPackPreloadFilesDetails = [];
            var techPackPreloadImages = [];
            var techPackPreloadImagesDetails = [];

            var productionLayoutPreloadImages = [];
            var productionLayoutPreloadImagesDetails = [];

            var testPrintPreloadImages = [];
            var testPrintPreloadImagesDetails = [];

            var productPicturePreloadEditedImages = [];
            var productPicturePreloadEditedImagesDetails = [];
            var productPicturePreloadRawImages = [];
            var productPicturePreloadRawImagesDetails = [];


            order_items.order_item_files.forEach(function(item_files, index) {
                console.log(item_files.mockup_images);
                if(item_files.mockup_images != null){
                    mockupPreloadImages.push(item_files.mockup_images);
                    let mockupImageArray = {caption: item_files.mockup_image_name, downloadUrl:  item_files.mockup_images, width: "120px", key: index, extra: {id: item_files.id}};
                    mockupPreloadImagedetails.push(mockupImageArray);
                }

                // tech pack images and files
                if(item_files.tech_pack_files != null){
                    techPackPreloadFiles.push(item_files.tech_pack_files);
                    let techPackFileArray = {caption: item_files.tech_pack_file_name, downloadUrl:  item_files.tech_pack_files, width: "120px", key: index, extra: {id: item_files.id}};
                    techPackPreloadFilesDetails.push(techPackFileArray);
                }

                if(item_files.tech_pack_images != null){
                    techPackPreloadImages.push(item_files.tech_pack_images);
                    let techPackImageArray = {caption: item_files.tech_pack_image_name, downloadUrl:  item_files.tech_pack_images, width: "120px", key: index, extra: {id: item_files.id}};
                    techPackPreloadImagesDetails.push(techPackImageArray);
                }

                if(item_files.production_layout_images != null){
                    productionLayoutPreloadImages.push(item_files.production_layout_images);
                    let productionLayoutImageArray = {caption: item_files.production_layout_image_name, downloadUrl:  item_files.production_layout_images, width: "120px", key: index, extra: {id: item_files.id}};
                    productionLayoutPreloadImagesDetails.push(productionLayoutImageArray);
                }

                if(item_files.test_print_images != null){
                    testPrintPreloadImages.push(item_files.test_print_images);
                    let productPictureImageArray = {caption: item_files.test_print_image_name, downloadUrl:  item_files.test_print_images, width: "120px", key: index, extra: {id: item_files.id}};
                    testPrintPreloadImagesDetails.push(productPictureImageArray);
                }

                // Product Picture images and files
                if(item_files.product_picture_raw_images != null){
                    productPicturePreloadRawImages.push(item_files.product_picture_raw_images);
                    let productFileArray = {caption: item_files.product_picture_raw_images, downloadUrl:  item_files.product_picture_raw_images, width: "120px", key: index, extra: {id: item_files.id}};
                    productPicturePreloadRawImagesDetails.push(productFileArray);
                }

                if(item_files.product_picture_edited_images != null){
                    productPicturePreloadEditedImages.push(item_files.product_picture_edited_images);
                    let productImageArray = {caption: item_files.product_picture_edited_image_name, downloadUrl:  item_files.product_picture_edited_images, width: "120px", key: index, extra: {id: item_files.id}};
                    productPicturePreloadEditedImagesDetails.push(productImageArray);
                }
            });

            console.log(mockupPreloadImages);
            console.log(mockupPreloadImagedetails);


            $("#mock_up_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: mockupPreloadImages,
                initialPreviewAsData: true,
                initialPreviewConfig: mockupPreloadImagedetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: false,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#mock_up_images_"+ order_items.id).fileinput("upload");
            });

            $("#teck_pack_files_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: techPackPreloadFiles,
                initialPreviewAsData: true,
                initialPreviewConfig: techPackPreloadFilesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: false,
                allowedFileExtensions: ["pdf"],
                browseOnZoneClick: true,
                fileActionSettings: {
                    showUpload: false,
                    showZoom: false,
                },
                preferIconicPreview: true,
                previewFileIconSettings: {
                    'doc': '<i class="fas fa-file-word text-primary"></i>',
                    'xls': '<i class="fas fa-file-excel text-success"></i>',
                    'ppt': '<i class="fas fa-file-powerpoint text-danger"></i>',
                    'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
                    'zip': '<i class="fas fa-file-archive text-muted"></i>',
                    'htm': '<i class="fas fa-file-code text-info"></i>',
                    'txt': '<i class="fas fa-file-alt text-info"></i>',
                    'mov': '<i class="fas fa-file-video text-warning"></i>',
                    'mp3': '<i class="fas fa-file-audio text-warning"></i>',
                    'jpg': '<i class="fas fa-file-image text-danger"></i>',
                    'gif': '<i class="fas fa-file-image text-muted"></i>',
                    'png': '<i class="fas fa-file-image text-primary"></i>',
                },
                previewFileExtSettings: {
                    'doc': function(ext) {
                        return ext.match(/(doc|docx)$/i);
                    },
                    'xls': function(ext) {
                        return ext.match(/(xls|xlsx)$/i);
                    },
                    'ppt': function(ext) {
                        return ext.match(/(ppt|pptx)$/i);
                    },
                    'zip': function(ext) {
                        return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
                    },
                    'htm': function(ext) {
                        return ext.match(/(htm|html)$/i);
                    },
                    'txt': function(ext) {
                        return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
                    },
                    'mov': function(ext) {
                        return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                    },
                    'mp3': function(ext) {
                        return ext.match(/(mp3|wav)$/i);
                    },
                    'jpg': function(ext) {
                        return ext.match(/(jpg|jpeg)$/i);
                    },
                    'pdf': function(ext) {
                        return ext.match(/(pdf)$/i);
                    },
                },
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#teck_pack_files_"+ order_items.id).fileinput("upload");
            });

            $("#teck_pack_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: techPackPreloadImages,
                initialPreviewAsData: true,
                initialPreviewConfig: techPackPreloadImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: false,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                uploadExtraData: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#teck_pack_images_"+ order_items.id).fileinput("upload");
            });

            $("#production_layout_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: productionLayoutPreloadImages,
                initialPreviewAsData: true,
                initialPreviewConfig: productionLayoutPreloadImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: false,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#production_layout_images_"+ order_items.id).fileinput("upload");
            });

            $("#test_print_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: testPrintPreloadImages,
                initialPreviewAsData: true,
                initialPreviewConfig: testPrintPreloadImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: false,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#test_print_images_"+ order_items.id).fileinput("upload");
            });

            $("#product_picture_raw_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: productPicturePreloadRawImages,
                initialPreviewAsData: true,
                initialPreviewConfig: productPicturePreloadRawImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: true,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#product_picture_raw_images_"+ order_items.id).fileinput("upload");
            });

            $("#product_picture_edited_images_"+ order_items.id).fileinput({
                uploadUrl: "{{ url('order_details/file_upload') }}/"+order_items.id+'/'+orderId,
                initialPreview: productPicturePreloadEditedImages,
                initialPreviewAsData: true,
                initialPreviewConfig: productPicturePreloadEditedImagesDetails,
                theme: 'fas',
                deleteUrl: "{{ url('order_details/file_delete') }}/"+orderId,
                overwriteInitial: true,
                browseOnZoneClick: true,
                maxFileSize: 5120000,
                allowedFileExtensions: ["jpeg", "jpg", "png", "gif"],
                fileActionSettings: {
                    showZoom: function(config) {
                        if (config.type === 'pdf' || config.type === 'image') {
                            return true;
                        }
                        return false;
                    },
                    showUpload: false,
                }
            }).on('filebeforedelete', function() {
                return new Promise(function(resolve, reject) {
                    $.confirm({
                        title: 'Confirmation!',
                        content: 'Are you sure you want to delete this file?',
                        type: 'red',
                        buttons: {
                            ok: {
                                btnClass: 'btn-primary text-white',
                                keys: ['enter'],
                                action: function(){
                                    resolve();
                                }
                            },
                            cancel: function(){
                                $.alert('File deletion was aborted! ');
                            }
                        }
                    });
                });
            }).on("filebatchselected", function(event, files) {
                $("#product_picture_edited_images_"+ order_items.id).fileinput("upload");
            });

    }
    $(document).ready(function () {
        $("#imageInput").fileinput({
                showUpload: false,  // Hide upload button
                showRemove: false,  // Hide remove button
                showDownload: true, // Show download button
                overwriteInitial: true,
                previewFileType: "image",
                allowedFileExtensions: ["jpg", "png", "gif"],

                // Remove zoom's default new tab behavior
                layoutTemplates: {
                    actionZoom: '',
                },

                fileActionSettings: {
                    showDownload: true, // Enable download button
                    showZoom: true, // Keep zoom enabled
                }
            });


        });


        // Prevent new tab opening when clicking zoom button
        $(document).on("click", ".kv-file-zoom", function (e) {
            e.preventDefault();  // Stop the default action (opening a new tab)
        });


        $(document).ready(function () {
        // Assuming orderItemId is set somewhere before this code
        var orderItemId = document.getElementById('orderItemId').value;

        // Handle file input change event
        $('#mockup_images_' + orderItemId).on('change', function (e) {
            // Get selected files
            var files = e.target.files;

            // Loop through selected files and display previews
            for (var i = 0; i < files.length; i++) {
                var imageUrl = URL.createObjectURL(files[i]);

                // Create an image element for the preview
                var image = $('<img>').attr('src', imageUrl).addClass('preview-image');

                // Create a cancel button with an 'x' symbol
                var cancelButton = $('<button>').html('&times;').addClass('cancel-button');

                // Create a preview container and append the image and cancel button
                var previewContainer = $('<div>').addClass('preview-container').append(image, cancelButton);
                $('#image-preview-container').append(previewContainer);

                // Attach a click event to the cancel button to remove the corresponding preview
                cancelButton.on('click', function () {
                    $(this).parent().remove(); // Remove the parent container when the cancel button is clicked
                });
            }
        });

    });
        function triggerMockupImageInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('mock_up_images_' + orderItemId).click();
        }
        // function triggerMockupImageInput(orderItemId) {
        //     // Trigger the click event on the corresponding file input
        //     document.getElementById('mockup_images_' + orderItemId).click();
        // }

        function triggerTechPackFileInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('teck_pack_files_' + orderItemId).click();
        }

        function triggerTechPackImageInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('teck_pack_images_' + orderItemId).click();
        }

        function triggerProductionImageInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('production_layout_images_' + orderItemId).click();
        }

        function triggerTestImageInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('test_print_images_' + orderItemId).click();
        }

        function triggerRowPhotosInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('product_picture_raw_images_' + orderItemId).click();
        }

        function triggerEditedPhotosInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('product_picture_edited_images_' + orderItemId).click();
        }
        document.addEventListener("DOMContentLoaded", function() {
        // Set a timer to check for the images every 100 milliseconds
        var interval = setInterval(function() {
            // Get all elements with the class '.file-preview-image'
            var imageElements = document.querySelectorAll(".file-preview-image");

            // Check if any image element exists
            if (imageElements.length > 0) {
                // Iterate over each image element
                imageElements.forEach(function(imageElement) {
                    // Get the current source of the image
                    var currentSrc = imageElement.src;

                    // Apply your modifications here
                    var correctedSrc = modifyImageSource(currentSrc);

                    // Update the image source with the corrected link
                    imageElement.src = correctedSrc;
                });

                // Clear the interval to stop checking
                clearInterval(interval);
            }
        }, 100);
    });

    function modifyImageSource(originalSrc) {
        // Check if the original source contains 'uc?id=' or '/file/d/'
        if (originalSrc.includes('uc?id=')) {
            // Replace 'uc?id=' with 'thumbnail?id='
            return originalSrc.replace('uc?id=', 'thumbnail?id=');
        } else if (originalSrc.includes('/file/d/')) {
            // Extract the file ID from the original source
            var fileId = extractFileId(originalSrc);

            // Construct the converted image source
            return "https://drive.google.com/thumbnail?id=" + fileId + "&export=media";
        }

        // If the source doesn't match either type, return the original source
        return originalSrc;
    }

    function extractFileId(originalSrc) {
        // Extract the file ID from the original source using a regular expression
        var match = originalSrc.match(/\/file\/d\/(.*?)\/view/);

        // Check if a match is found
        if (match && match[1]) {
            return match[1];
        }

        // If no match is found, return an empty string
        return "";
    }
        $(document).ready(function () {
            changeFileInputLayout();
            function changeFileInputLayout(){
                var htmlContent = `
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <i class="fa fa-cloud-upload fa-lg" style="color:#B3B3B3" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-12 text-center">
                            <p style="color: #B3B3B3;font-size: 11px;margin-bottom: 0px;">
                                Drag & drop your file here or <span style="color: #47D6B6;font-weight:600;">CLICK HERE</span> to upload images
                            </p>
                        </div>
                        <div class="col-md-12 text-center">
                            <p style="color: #B3B3B3;font-size: 11px;">We support .jpg file format</p>
                        </div>
                    </div>
                `;


                $('.file-drop-zone-title').each(function() {
                    $(this).html(htmlContent);
                });
            }

            $('#customer_address_type').change(function () {
                var addressType = $(this).val();
                if (addressType == 2) {
                    $('#shipping_address2').val('{{ $order->contactDetails['shipping_street'] ?? '--' }}');
                    $('#shipping_address1').val('{{ $order->contactDetails['apartment'] ?? '--' }}');
                    $('#shipping_address3').val('{{ $order->contactDetails['shipping_city'] ?? '' }} {{ $order->contactDetails['shipping_state'] ?? '' }} {{ $order->contactDetails['shipping_zip'] ?? '' }}');
                    $('#shipping_address4').val('{{ $order->contactDetails['shipping_country'] ?? '--' }}');
                } else if (addressType == 3) {
                    $('#shipping_address2').val('{{ $order->contactDetails['shipping_street_2'] ?? '--' }}');
                    $('#shipping_address1').val('{{ $order->contactDetails['apartment2'] ?? '--' }}');
                    $('#shipping_address3').val('{{ $order->contactDetails['shipping_city_2'] ?? '' }} {{ $order->contactDetails['shipping_state_2'] ?? '' }} {{ $order->contactDetails['shipping_zip_2'] ?? '' }}');
                    $('#shipping_address4').val('{{ $order->contactDetails['shipping_country_2'] ?? '--' }}');
                }
            });
        });

        $('input[name="discount"]').on('change', function () {
            $('#discountType').val($('input[name="discount"]:checked').val());
        });

        $('select').select2();

        function EyeIconClick(OrderItemID){
            const elementToClick = document.getElementById('eyeIconFunc_'+OrderItemID);
            if (elementToClick) {
            elementToClick.click();
            }
        }

        function CheckMyFnc(){
            //console.log('Here Working !');
            // addDefaultAddressDetails();
        }

        function edit_saved_items(sub_pro_no, order_item){
            update_product_details(sub_pro_no, order_item);
            $('#edit_item_modal').modal('show');
        }

        function delete_saved_item(order_item_no) {
                var orderId = order_item_no.id;

                swal({
                    title: "Confirm Delete?",
                    text: "Do You Want to Delete This Order Item?",
                    type: "warning",
                    buttons: true,
                    dangerMode: true,
                    showCancelButton: true,
                    confirmButtonColor: '#2dce89',
                    closeOnConfirm: false,
                    closeOnCancel: true
                })
                .then(function(willDelete){
                    if (willDelete.value) {
                        // Use the route() function to generate the URL
                        var deleteUrl = "{{ route('deleteOrder', ['id' => ':orderId']) }}";
                        deleteUrl = deleteUrl.replace(':orderId', orderId);
                        window.location.href = deleteUrl;
                    } else if(willDelete.dismiss == 'cancel') {
                        console.log('cancel');
                    }
                });
        };
        $(document).ready(function() {
            $('#test_print_needed_checkbox').change(function() {
                if(this.checked) {
                    $('.test_print_due_date').show();
                    $('#test_print_due_date_text').prop('disabled', false);
                    // $('#test_print_due_date_text').prop('required', true);
                    // var exFactoryDate = $('.item-ex-factory-date').val();

                    // var dateParts = exFactoryDate.split('/');
                    // var month = parseInt(dateParts[0]) - 1;
                    // var day = parseInt(dateParts[1]);
                    // var year = parseInt(dateParts[2]);
                    // var date = new Date(year, month, day);

                    // date.setDate(date.getDate() - 10);

                    // var newDay = ('0' + date.getDate()).slice(-2);
                    // var newMonth = ('0' + (date.getMonth() + 1)).slice(-2);
                    // var newYear = date.getFullYear();
                    // var newDateString = newMonth + '/' + newDay + '/' + newYear;

                    // $('#test_print_due_date_text').val(newDateString);

                } else {
                    $('.test_print_due_date').hide(); // Hide the input field
                    $('#test_print_due_date_text').prop('disabled', true); // Disable the input field
                    // $('#test_print_due_date_text').prop('required', false); // Remove the required attribute from the input field
                }
            });
        });

        $('.datepicker').datepicker({minDate: 0});

        $(document).ready(function() {
            setPatternCode();

            function updateTotalPrice() {
                let totalPrice = 0;

                var attributeOnPriceData = $('#styleName option:selected').data('attribute_on_price')

                if (attributeOnPriceData != undefined && attributeOnPriceData != null) {
                    var attribute_on_price = String(attributeOnPriceData).split(' / ').map(Number);
                    console.log('attribute_on_price:', attribute_on_price);
                }

                $('.attribute_checkbox_change:checked').each(function() {
                    var attribute_id = parseFloat($(this).data('attribute_id'));
                    if(!attribute_on_price.includes(attribute_id)){
                        totalPrice += parseFloat($(this).data('attribute_price'));
                    }
                });

                let selectedOptionPrice = parseFloat($('#styleName option:selected').data('selected_price'));
                if (!isNaN(selectedOptionPrice)) {
                    totalPrice += selectedOptionPrice;
                }

                $('#unitprice_{{ $orderItem->id }}').val(totalPrice.toFixed(2));
                setUnitPriceColor();
                setPatternCode();
            }
            function setUnitPriceColor() {
                var inputElement = $('#unitprice_{{ $orderItem->id }}');

                inputElement.css('background-color', 'rgb(255, 222, 0)');

                setTimeout(function() {
                    inputElement.css('background-color', 'white');
                }, 20000);
            }

            function setPatternCode() {
                $(".se-pre-con").fadeIn();

                var subAttributeIds = [];
                $('.sub-attribute:checked').each(function() {
                    subAttributeIds.push(parseFloat($(this).data('attribute_id')));
                });

                $.ajax({
                    url:'{{ route("order.get_pattern_code") }}',
                    type:'POST',
                    dataType:'json',
                    data:{'attribute_ids':subAttributeIds, 'sub_product_no':'{{ $orderItem->sub_product_no }}', '_token':'{{ csrf_token() }}'},
                    success:function(data){
                        // console.log(data);

                        $('#item_style_patter_code_{{ $orderItem->id }}').val(data);
                        $(".se-pre-con").fadeOut();
                    }
                });
            }

            $(document).on('change', '.attribute_checkbox_change', updateTotalPrice);
            // $(document).on('change', '#styleName', updateTotalPrice);

            $('.attribute_group_class').change(function(){

                var attributeGroupId = $(this).attr('data-attribute_id');
                if($(this).prop('checked') == true){
                    $('.group-attribute-'+attributeGroupId).show(200);
                    $('.attribute_group_class_'+attributeGroupId+':first').prop('checked', true);
                    updateTotalPrice();
                } else {
                    $('.group-attribute-'+attributeGroupId).hide(200);
                    $('.attribute_group_class_'+attributeGroupId).prop('checked', false);
                    updateTotalPrice();
                }
            });
        });

    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Set a timer to check for the images every 100 milliseconds
            var interval = setInterval(function() {
                // Get all elements with the class '.file-preview-image'
                var imageElements = document.querySelectorAll(".file-preview-image");

                // Check if any image element exists
                if (imageElements.length > 0) {
                    // Iterate over each image element
                    imageElements.forEach(function(imageElement) {
                        // Get the current source of the image
                        var currentSrc = imageElement.src;

                        // Apply your modifications here
                        var correctedSrc = modifyImageSource(currentSrc);

                        // Update the image source with the corrected link
                        imageElement.src = correctedSrc;
                    });

                    // Clear the interval to stop checking
                    clearInterval(interval);
                }
            }, 100);
        });

        function modifyImageSource(originalSrc) {
            // Check if the original source contains 'uc?id=' or '/file/d/'
            if (originalSrc.includes('uc?id=')) {
                // Replace 'uc?id=' with 'thumbnail?id='
                return originalSrc.replace('uc?id=', 'thumbnail?id=');
            } else if (originalSrc.includes('/file/d/')) {
                // Extract the file ID from the original source
                var fileId = extractFileId(originalSrc);

                // Construct the converted image source
                return "https://drive.google.com/thumbnail?id=" + fileId + "&export=media";
            }

            // If the source doesn't match either type, return the original source
            return originalSrc;
        }

        function extractFileId(originalSrc) {
            // Extract the file ID from the original source using a regular expression
            var match = originalSrc.match(/\/file\/d\/(.*?)\/view/);

            // Check if a match is found
            if (match && match[1]) {
                return match[1];
            }

            // If no match is found, return an empty string
            return "";
        }

        // $(document).ready(function() {
        //     $(document).on('click', '.kv-file-zoom', function() {
        //         setTimeout(function() {
        //             location.reload();
        //         }, 500);
        //     });
        // });

        $(document).ready(function() {
            // Add a click event listener to the element with class '.kv-file-zoom'
            // $(document).on('click', '.kv-file-zoom', function() {
            //     // Wait for 1 second before triggering a click on '.btn-close'
            //     setTimeout(function() {
            //         $('.btn-close').click();
            //     }, 1000); // 1000 milliseconds = 1 second
            // });

            // Add a click event listener to the close button
            $(document).on('click', '.btn-close', function() {
                // Perform the desired action when the close button is clicked
                console.log("Close button clicked");

                // Programmatically close the modal
                $('#kvFileinputModal').modal('hide');
            });

            $(document).on('click', '.ViewItemExFactoryDateLog', function() {

                var orderItemId =document.getElementById('orderItemId').value;
                console.log(orderItemId);


                $.ajax({
                url: '{{ url("order_details/get_item_ExFactoryDate_log") }}',
                type: "POST",
                dataType: 'json',
                data: {
                    'itemID': orderItemId,
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(data) {

                    console.log('fabrics / embellishments / attributes',data);
                var tbody = $('#item_ex_factory_log_table_tbody');
                tbody.empty(); // Clear existing rows

                if (data.length > 0) {
                    // If data is available, populate table rows
                    $.each(data, function(index, item) {
                        var row = $('<tr>').css({
                            'color': '#4E4C4C',
                            'height': '35px',
                            'border-bottom': '1px solid #b3b3b3'
                        });
                        var formattedDate = formatDate(item.created_at);
                        // Add table cells
                        row.append($('<td>').css('padding-left', '10px').text(formattedDate));
                        row.append($('<td>').text(item.order_item_id ?? ''));
                        row.append($('<td>').text( item.user_detail['name']));
                        row.append($('<td>').text(item.pre_date));
                        row.append($('<td>').text(item.new_date));
                        row.append($('<td>').text(item.reason));

                        tbody.append(row); // Append row to tbody
                    });
                } else {
                    // If no data available, show "No Logs" message
                    var emptyRow = $('<tr>').css({
                        'color': '#4E4C4C',
                        'height': '35px',
                        'border-bottom': '1px solid #b3b3b3'
                    }).append($('<td>').attr('colspan', 5).css('padding-left', '10px').text('No Logs'));

                    tbody.append(emptyRow); // Append empty row
                }


                },
                complete: function () {
                    $('#modal_item_ex_factory_date_log').modal('show');
                    $(".se-pre-con").fadeOut('slow');
                }
            });
            function formatDate(dateString) {
                var date = new Date(dateString);
                var formattedDate = ('0' + (date.getMonth() + 1)).slice(-2) + '/' + ('0' + date.getDate()).slice(-2) + '/' + date.getFullYear();
                return formattedDate;
            }
            });
        });

    </script>

    <script>


    $(document).ready(function () {
            // Assuming orderItemId is set somewhere before this code
            var orderItemId = document.getElementById('orderItemId').value;

            // Handle file input change event
            $('#mockup_images_' + orderItemId).on('change', function (e) {
                // Get selected files
                var files = e.target.files;

                // Loop through selected files and display previews
                for (var i = 0; i < files.length; i++) {
                    var imageUrl = URL.createObjectURL(files[i]);

                    // Create an image element for the preview
                    var image = $('<img>').attr('src', imageUrl).addClass('preview-image');

                    // Create a cancel button with an 'x' symbol
                    var cancelButton = $('<button>').html('&times;').addClass('cancel-button');

                    // Create a preview container and append the image and cancel button
                    var previewContainer = $('<div>').addClass('preview-container').append(image, cancelButton);
                    $('#image-preview-container').append(previewContainer);

                    // Attach a click event to the cancel button to remove the corresponding preview
                    cancelButton.on('click', function () {
                        $(this).parent().remove(); // Remove the parent container when the cancel button is clicked
                    });
                }
            });
        });

        function triggerMockupImageInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('mock_up_images_' + orderItemId).click();
        }
        // function triggerMockupImageInput(orderItemId) {
        //     // Trigger the click event on the corresponding file input
        //     document.getElementById('mockup_images_' + orderItemId).click();
        // }

        function triggerTechPackFileInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('teck_pack_files_' + orderItemId).click();
        }

        function triggerTechPackImageInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('teck_pack_images_' + orderItemId).click();
        }

        function triggerProductionImageInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('production_layout_images_' + orderItemId).click();
        }

        function triggerTestImageInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('test_print_images_' + orderItemId).click();
        }

        function triggerRowPhotosInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('product_picture_raw_images_' + orderItemId).click();
        }

        function triggerEditedPhotosInput(orderItemId) {
            // Trigger the click event on the corresponding file input
            document.getElementById('product_picture_edited_images_' + orderItemId).click();
        }

        $(document).ready(function () {
            var orderStatusSelect = $('.order_item_status_id');
            var itemIsUrgentInput = $('#item_is_urgent');

            orderStatusSelect.on('change', function () {
                var selectedValue = $(this).val();

                var orderItem = @json($orderItem);
                var orderItemFiles = @json($orderItem->orderItemFiles);

                var orderFolderExist = false;

                $.each(orderItemFiles, function(index, element) {
                    if (element.tech_pack_images != null || element.tech_pack_files != null) {
                        orderFolderExist = true;
                        return false;
                    }
                });

                var orderItemQtyExist = orderItem.qty != 0;
                var orderInhandExist = orderItem.in_hand_due_date != null && orderItem.in_hand_due_date != '';
                var orderExfactoryExist = orderItem.ex_factory_date != null && orderItem.ex_factory_date != '';
                var orderEmbellishmentExist = orderItem.embellishment_type_id != null && orderItem.embellishment_type_id != '';

                console.log('Order Folder Exists: ' + orderFolderExist);
                console.log('Order Item Quantity Exists: ' + orderItemQtyExist);
                console.log('Order In-hand Due Date Exists: ' + orderInhandExist);
                console.log('Order Ex-factory Date Exists: ' + orderExfactoryExist);
                console.log('Order embellishment_type_id Exists: ' + orderEmbellishmentExist);

                if (selectedValue == '3') {
                    if (!(orderFolderExist && orderItemQtyExist && orderInhandExist && orderExfactoryExist && orderEmbellishmentExist)) {
                        var alert_text = '<div class="text-left mt-2" <ul>';

                        if(!orderFolderExist){
                            alert_text += '<li>Please upload the tech pack.</li>'
                        }
                        if(!orderItemQtyExist){
                            alert_text += '<li>Please add the quantity.</li>'
                        }
                        if(!orderInhandExist){
                            alert_text += '<li>Please provide the in-hand due date.</li>'
                        }
                        if(!orderExfactoryExist){
                            alert_text += '<li>Please provide the EX-Factory date.</li>'
                        }
                        if(!orderEmbellishmentExist){
                            alert_text += '<li>Please provide the embellishment type.</li>'
                        }
                        alert_text += '</ul></div>';
                        Swal.fire({
                            icon: 'error',
                            title: 'Unable to send the order item to production:',
                            html: alert_text
                        }).then((result) => {
                                $(this).val('1').trigger('change');

                        });
                    }else{
                        var currentDate = new Date();

                        currentDate.setHours(0, 0, 0, 0);

                        var orderItemId = $(this).data('orderitemid');

                        var orderItemId = document.getElementById('orderItemId').value;
                        var exFactoryDateInputId = 'item_ex_factory_date_' + orderItemId;
                        var exFactoryDateInput = document.getElementById(exFactoryDateInputId);
                        var exFactoryDateValue = exFactoryDateInput.value;
                        var exFactoryDate = new Date(exFactoryDateValue);

                        var timeDifference = exFactoryDate - currentDate;

                        var daysDifference = timeDifference / (1000 * 3600 * 24);
                        swal({
                                title: " Attention",
                                text: "You are about to send only one item into production, not the entire order. Please! Confirm",
                                type: "warning",
                                buttons: true,
                                dangerMode: true,
                                showCancelButton: true,
                                confirmButtonColor: '#2dce89',
                                closeOnConfirm: false,
                                closeOnCancel: true
                            })
                            .then(function(result){
                                if (result.value) {
                                    if (daysDifference < 21) {
                                        $('#urgentMassege').modal('show');
                                        itemIsUrgentInput.val('1');
                                    }
                                }
                            });
                            var testPrintDueDateInput = $('#test_print_due_date_text');

                            // Get current date and add 10 days
                            var newDate = new Date();
                            newDate.setDate(newDate.getDate() + 10);

                            // Format the new date as MM/DD/YYYY
                            var formattedDate = ('0' + (newDate.getMonth() + 1)).slice(-2) + '/' +
                                                ('0' + newDate.getDate()).slice(-2) + '/' +
                                                newDate.getFullYear();

                            // Set the value of the test_print_due_date_text input
                            testPrintDueDateInput.val(formattedDate);

                    }
                }else if(selectedValue == '1'){
                    var testPrintDueDateInput = $('#test_print_due_date_text');
                    // Reset the value
                    testPrintDueDateInput.val('');

                }
            });

            $('.done').on('click', function () {
                $('#urgentMassege').modal('hide');
            });

            $('.cancel-button').on('click', function () {
                var dataAlreadySavedValue = orderStatusSelect.data('alradysaved');
                orderStatusSelect.val(dataAlreadySavedValue);

                orderStatusSelect.change();

                $('#urgentMassege').modal('hide');
            });

        });

        attributeUpdate();

        $(document).ready(function () {
            // Add change event listener to the checkboxes
            $('.toggle-checkbox').change(function () {
                // Check the state of both checkboxes
                attributeUpdate();

            });

            // Trigger the change event on page load to set initial visibility
            $('.toggle-checkbox').trigger('change');
        });

            function attributeUpdate(){
                var individualNumberChecked = $('.attribute_class_1').is(':checked');
                var individualNameChecked = $('.attribute_class_2').is(':checked');

                var nameSq = '.rosterPlayerNameSection';
                var numSq = '.rosterPlayerNumberSection';
                var blanks = '.without-blank';

                var orderItemId =$('#orderItemId').val();

                if(individualNameChecked && !individualNumberChecked){

                    $(blanks).text('SIZE QUANTITY');

                    $(nameSq).removeClass('active');
                    $(numSq).removeClass('active');
                    $(blanks).addClass('active');

                    $(nameSq).show();
                    $(blanks).show();
                    $(numSq).hide();

                    $('#qtySummary_tab_'+orderItemId).addClass('active show');
                    $('#orderRoster_tab_'+orderItemId).removeClass('active');
                    $('#orderRoster_tab_'+orderItemId).removeClass('show');
                    $('#orderRosterName_tab_'+orderItemId).removeClass('active');
                    $('#orderRosterName_tab_'+orderItemId).removeClass('show');



                }else if (individualNumberChecked && !individualNameChecked){

                    $(nameSq).removeClass('active');
                    $(numSq).addClass('active');
                    $(blanks).removeClass('active');

                    $(nameSq).hide();
                    $(blanks).hide();
                    $(numSq).show();

                    $('#qtySummary_tab_'+orderItemId).removeClass('active');
                    $('#qtySummary_tab_'+orderItemId).removeClass('show');
                    $('#orderRoster_tab_'+orderItemId).addClass('active show');
                    $('#orderRosterName_tab_'+orderItemId).removeClass('active');
                    $('#orderRosterName_tab_'+orderItemId).removeClass('show');

                }else if(individualNumberChecked && individualNameChecked){

                    $(nameSq).removeClass('active');
                    $(numSq).addClass('active');
                    $(blanks).removeClass('active');

                    $(nameSq).show();
                    $(blanks).hide();
                    $(numSq).show();

                    $('#qtySummary_tab_'+orderItemId).removeClass('active');
                    $('#qtySummary_tab_'+orderItemId).removeClass('show');
                    $('#orderRoster_tab_'+orderItemId).addClass('active show');
                    $('#orderRosterName_tab_'+orderItemId).removeClass('active');
                    $('#orderRosterName_tab_'+orderItemId).removeClass('show');



                } else if (!individualNameChecked && !individualNumberChecked){

                    $(blanks).text('QUANTITY');

                    $(nameSq).removeClass('active');
                    $(numSq).removeClass('active');
                    $(blanks).addClass('active');

                    $(nameSq).hide();
                    $(blanks).show();
                    $(numSq).hide();

                    $('#qtySummary_tab_'+orderItemId).addClass('active show');
                    $('#orderRoster_tab_'+orderItemId).removeClass('active');
                    $('#orderRoster_tab_'+orderItemId).removeClass('show');
                    $('#orderRosterName_tab_'+orderItemId).removeClass('active');
                    $('#orderRosterName_tab_'+orderItemId).removeClass('show');

                }
            }


            function openSize(evt, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontentCustom");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinksCustom");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";

                evt.currentTarget.className += " active";

            }

            $(document).on('click', '.player-size-row th', function () {

                var row = $(this).closest('tr');

                var sizeClass = row.attr('class')
                    .split(' ')
                    .find(function(c){
                        return c.indexOf('size-') === 0;
                    });

                var rows = $('.' + sizeClass);

                rows.toggleClass('active');

            });

            document.addEventListener("DOMContentLoaded", function () {

                if (window.innerWidth <= 768) {


                    // hide rows after first two rows initially
                    document.querySelectorAll('.player-size-row').forEach(function(row){

                        let sizeClass = [...row.classList]
                            .find(cls => cls.startsWith('size-'));

                        if(!sizeClass) return;


                        let rows = document.querySelectorAll('.' + sizeClass);


                        rows.forEach(function(item,index){

                            if(index > 1){
                                item.style.display = "none";
                            }

                        });

                    });



                    // input change check
                    document.querySelectorAll('input.numseq').forEach(function(input){


                        input.addEventListener('input',function(){


                            let currentRow = this.closest('tr');


                            let rows = currentRow.parentElement.querySelectorAll(
                                '.' + [...currentRow.classList]
                                .find(cls => cls.startsWith('size-'))
                            );


                            let rowArray = Array.from(rows);



                            rowArray.forEach(function(row,index){


                                let inputs = row.querySelectorAll('input.numseq');


                                if(inputs.length == 0){
                                    return;
                                }


                                let isFull = true;


                                inputs.forEach(function(field){

                                    if(field.value.trim() === ''){
                                        isFull = false;
                                    }

                                });



                                let nextRow = rowArray[index + 1];


                                if(nextRow){


                                    if(isFull){

                                        nextRow.style.setProperty('display', 'flex', 'important');


                                    }else{


                                        // hide only rows after current
                                        for(let x=index+1;x<rowArray.length;x++){

                                            rowArray[x].style.display="none";

                                        }

                                    }


                                }


                            });


                        });


                    });


                }

            });

    </script>



@endsection
