@extends('layouts.app', ['activePage' => 'home', 'titlePage' => __('Dashboard')])

@section('content')
<style>
    .dropdown-content {
        display: none;
        position: absolute;
        top: 31px;
        left: 128px;
        background-color: #ffffff;
        min-width: 125px;
        overflow: auto;
        box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.1);
        z-index: 1;
        padding: 10px 10px;
    }
    .dropdown-content button {
        padding: 5px 5px;
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 1px solid #eeeeee;
        border-radius: 3px;
    }
    .dropdown-content button:focus {
        outline: none;
    }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .total_sales {
        margin: 9px;
    }
    .total_sale_p1 {
        margin: unset;
        font-size: 12px;
        font-weight: 400;
    }
    .total_sale_b {
        font-size: 17px;
    }
    .difference_div {
        background-color: #E0F9D4;
        color: #55A630;
        margin-left: 12px;
        width: 45px;
        font-size: 10px;
        text-align: center;
        margin-top: 5px;
        margin-bottom: 4px;
        border-radius: 10px;
    }
    .difference_div2 {
        background-color: #FFEDEE;
        color: #D00000;
        margin-left: 12px;
        width: 45px;
        font-size: 10px;
        text-align: center;
        margin-top: 5px;
        margin-bottom: 4px;
        border-radius: 10px;
    }
    .total_sale_img_size {
        width: 40px;
    }
    .total_sale_p2 {
        margin: unset;
        font-size: 12px;
        font-weight: 500;
        color: #B3B3B3;
    }
    .detail_card_padding {
        padding-left: 5px;
        padding-right: 5px;
        padding-right: 5px;
        padding-bottom: 5px;
    }
    .main-content {
        background-color: #f5f5f5 !important;
    }
    .content_position {
        top: -20px;
        position: relative;
    }
    .dropdown-menu-custom {
        left: 45% !important;
        transform: translateX(-50%) !important;
        width: 150% !important;
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
    .heading-link:hover {
        text-decoration: underline;
    }
    .highlight {
        background-color: yellow !important;
    }
    .list-group-item{
        min-height: 3.5rem;
    }
    .table_header_text {
        color: white;
        height: 40px;
        font-size: 10px !important;
        padding-right: unset !important;
        padding-left: 10px !important;
    }
    .page-item.active .page-link {
        color: #4e4e4e;
    }
    .note_p p {
        margin: unset;
        font-size: 13px;
        color: #525f7f;
    }
    .log_email {
        text-align: center;
        width: 100%;
        margin-top: 20px;
        background-color: red;
        margin-left: 100px;
        margin-right: 100px;
        height: 30px;
        padding-top: 5px;
        color: white;
        border-radius: 9px;
    }
    .log_email:hover {
        text-align: center;
        width: 100%;
        margin-top: 20px;
        background-color: rgb(0, 255, 85);
        margin-left: 100px;
        margin-right: 100px;
        height: 30px;
        padding-top: 5px;
        color: white;
        border-radius: 9px;
    }
    .email_table_row {
        background-color: rgb(191, 255, 191);
        border-bottom: 2px solid white;
    }
    .email_table_row:hover {
        background-color: rgb(240, 240, 240);
        border-bottom: 2px solid white;
    }
    .select2-container {
        text-align: left;
    }
    .class_for_repDashboard {
        text-align: left;
    }
    .email-message {
        font-size: 30px;
        color: rgb(0, 205, 0);
        cursor: pointer;
    }
    .email-message:hover {
        font-size: 30px;
        color: rgb(51, 255, 51);
        cursor: pointer;
    }
    #created_at_tr {
        text-align: left;
    }
    #modified_at_tr {
        text-align: left;
    }
    .check-image {
        width: 50%;
        height: 200px;
        padding: 5px;
        overflow: hidden;
    }
    .styled-button{
        outline: unset;
        color: #d3d3d3;
        background-color: #fafafa;;
        border: 1px solid #d3d3d3;
        padding: .3rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
    }
    .tab-topic.active {
        background-color: transparent;
        border-color: transparent;
    }
    .tab-topic.active {
        color: black !important;
        font-weight: 600;
        border-bottom: 1px solid;
        padding-bottom: 1px;
    }
    .fc .fc-daygrid-day-frame {
        max-height: 100%;
        overflow-y: auto;
    }
    .fc-daygrid-event {
        margin: 2px 0;
    }

    @media (max-width: 767.98px) {

        .content_position {
            padding-right: 20px;
            padding-left: 20px;
        }

        /* Equal height for all dashboard cards */
        .detail_card_padding {
            padding: 5px !important;
        }

        .detail_card_padding > .card {
            height: 100% !important;
            min-height: 105px !important;
            margin-bottom: 0 !important;
        }

        /* Main card content */
        .total_sales {
            min-height: 105px !important;
            height: 100% !important;

            display: flex !important;
            align-items: center !important;

            margin: 0 !important;
            padding: 12px !important;

            flex-wrap: nowrap !important;
        }

        /* Image section */
        .total_sales > div:first-child {
            flex: 0 0 45px !important;
            width: 45px !important;
            height: 45px !important;

            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        .total_sale_img_size {
            width: 40px !important;
            height: 40px !important;
            object-fit: contain !important;
        }

        /* Details section */
        .total_sales > div:last-child {
            flex: 1 !important;
            min-width: 0 !important;

            padding-left: 8px !important;
        }

        .total_sale_p1 {
            margin: 0 0 5px 0 !important;

            font-size: 13px !important;
            line-height: 16px !important;

            white-space: normal !important;
        }

        .total_sale_b {
            font-size: 13px !important;
            line-height: 16px !important;
        }

        .total_sale_p2 {
            margin: 4px 0 0 0 !important;

            font-size: 12px !important;
            line-height: 15px !important;
        }
    }

    @media (max-width: 767.98px) {

    .recent_order {
        padding: 10px 8px 15px !important;
        overflow-x: hidden !important;
    }

    #order_table {
        width: 100% !important;
        min-width: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    #order_table thead {
        display: none !important;
    }

    #order_table tbody {
        display: block !important;
        width: 100% !important;
    }

    /* =====================================================
       ORDER CARD
       8 TDs -> 4 rows x 2 columns
       ===================================================== */

    #order_table tbody tr {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 0 !important;

        width: 100% !important;

        margin: 0 0 12px 0 !important;
        padding: 12px !important;

        background: #fff !important;

        border: 1px solid #e8eaed !important;
        border-radius: 14px !important;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06) !important;

        box-sizing: border-box !important;
    }

    /* =====================================================
       EACH FIELD = 50%
       LABEL ABOVE VALUE
       ===================================================== */

    #order_table tbody td {
        display: flex !important;
        flex-direction: column !important;

        width: auto !important;
        min-width: 0 !important;

        padding: 8px 7px !important;
        margin: 0 !important;

        border: 0 !important;

        text-align: left !important;

        word-break: break-word !important;
        overflow-wrap: anywhere !important;

        box-sizing: border-box !important;
    }

    /* Vertical separator between left/right columns */
    #order_table tbody td:nth-child(odd) {
        border-right: 1px solid #eeeeee !important;
        padding-right: 10px !important;
    }

    #order_table tbody td:nth-child(even) {
        padding-left: 10px !important;
    }

    /* Horizontal separators */
    #order_table tbody td:nth-child(1),
    #order_table tbody td:nth-child(2),
    #order_table tbody td:nth-child(3),
    #order_table tbody td:nth-child(4),
    #order_table tbody td:nth-child(5),
    #order_table tbody td:nth-child(6) {
        border-bottom: 1px solid #eeeeee !important;
    }

    /* =====================================================
       LABELS
       ===================================================== */

    #order_table tbody td::before {
        display: block !important;

        margin-bottom: 4px !important;

        font-size: 9px !important;
        line-height: 12px !important;

        font-weight: 700 !important;
        letter-spacing: 0.6px !important;

        color: #9298a1 !important;
    }

    #order_table tbody td:nth-child(1)::before {
        content: "ORDER ID";
    }

    #order_table tbody td:nth-child(2)::before {
        content: "ORGANIZATION";
    }

    #order_table tbody td:nth-child(3)::before {
        content: "FACTORY";
    }

    #order_table tbody td:nth-child(4)::before {
        content: "DESCRIPTION";
    }

    #order_table tbody td:nth-child(5)::before {
        content: "EX FACTORY DATE";
    }

    #order_table tbody td:nth-child(6)::before {
        content: "IN-HAND DATE";
    }

    #order_table tbody td:nth-child(7)::before {
        content: "TEST PRINT DUE";
    }

    #order_table tbody td:nth-child(8)::before {
        content: "ORDERED QTY";
    }

    /* =====================================================
       VALUES
       ===================================================== */

    #order_table tbody td {
        font-size: 12px !important;
        line-height: 16px !important;

        font-weight: 500 !important;
        color: #343a40 !important;
        overflow-x: hidden;
    }

    /* Order ID */
    #order_table tbody td:first-child a {
        font-size: 13px !important;
        font-weight: 700 !important;

        color: #343a40 !important;
        text-decoration: none !important;
    }

    /* Quantity */
    #order_table tbody td:nth-child(8) {
        font-weight: 700 !important;
    }

    /* Last row has no bottom border */
    #order_table tbody td:nth-child(7),
    #order_table tbody td:nth-child(8) {
        border-bottom: 0 !important;
    }

    /* =====================================================
       PAGINATION
       ===================================================== */

    #paginationbarUrgent {
        width: 100% !important;

        margin-top: 10px !important;

        display: flex !important;
        justify-content: center !important;
    }

    #paginationbarUrgent .pagination {
        margin: 0 !important;

        display: flex !important;
        justify-content: center !important;
        align-items: center !important;

        gap: 3px !important;
    }

    #paginationbarUrgent .page-link {
        min-width: 34px !important;
        height: 34px !important;

        padding: 6px 9px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        border: 0 !important;
        border-radius: 8px !important;

        background: transparent !important;

        font-size: 12px !important;
        font-weight: 600 !important;

        color: #555 !important;
    }

    #paginationbarUrgent .page-item.active .page-link {
        background: #717070 !important;
        color: #fff !important;
    }

    #paginationbarUrgent .page-link:hover {
        background: #f1f2f4 !important;
    }

    /* =====================================================
       IMPORTANT:
       Pagination visibility classes
       ===================================================== */

    #order_table tbody tr.mobile-order-hidden {
        display: none !important;
    }

    #order_table tbody tr.mobile-order-visible {
        display: grid !important;
    }
}

/* =========================================================
   PAYMENT TABLE - MOBILE CARD VIEW
   HTML CHANGE NOT REQUIRED
   ========================================================= */

@media (max-width: 767.98px) {

    #payment_table {
        width: 100% !important;
        min-width: 0 !important;
        margin: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    #payment_table thead {
        display: none !important;
    }

    #payment_table tbody {
        display: block !important;
        width: 100% !important;
    }

    /* CARD */
    #payment_table tbody tr {
        display: grid !important;

        grid-template-columns: 50% 50% !important;

        grid-template-areas:
            "payment_id order_id"
            "organization organization"
            "payment_type status"
            "amount payment_date" !important;

        width: 100% !important;

        margin: 0 0 12px 0 !important;
        padding: 8px !important;

        background: #fff !important;

        border: 1px solid #e5e7eb !important;
        border-radius: 14px !important;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06) !important;

        box-sizing: border-box !important;
    }

    /* ALL TD */
    #payment_table tbody tr td {
        display: flex !important;
        flex-direction: column !important;

        width: 100% !important;
        min-width: 0 !important;
        min-height: 48px !important;

        margin: 0 !important;
        padding: 8px 7px !important;

        border: 0 !important;

        box-sizing: border-box !important;

        text-align: left !important;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;

        font-size: 12px !important;
        line-height: 16px !important;

        color: #343a40 !important;
    }

    /* =========================================
       GRID ORDER
       ========================================= */

    /* 1 - Payment ID */
    #payment_table tbody tr td:nth-child(1) {
        grid-area: payment_id !important;

        border-right: 1px solid #eeeeee !important;
        border-bottom: 1px solid #eeeeee !important;

        padding-right: 10px !important;
    }

    /* 2 - Order ID */
    #payment_table tbody tr td:nth-child(2) {
        grid-area: order_id !important;

        border-bottom: 1px solid #eeeeee !important;

        padding-left: 10px !important;
    }

    /* 4 - Organization */
    #payment_table tbody tr td:nth-child(4) {
        grid-area: organization !important;

        border-bottom: 1px solid #eeeeee !important;

        padding-left: 7px !important;
        padding-right: 7px !important;
    }

    /* 3 - Payment Type */
    #payment_table tbody tr td:nth-child(3) {
        grid-area: payment_type !important;

        border-right: 1px solid #eeeeee !important;
        border-bottom: 1px solid #eeeeee !important;

        padding-right: 10px !important;
    }

    /* 5 - Status */
    #payment_table tbody tr td:nth-child(5) {
        grid-area: status !important;

        border-bottom: 1px solid #eeeeee !important;

        padding-left: 10px !important;
    }

    /* 6 - Amount */
    #payment_table tbody tr td:nth-child(6) {
        grid-area: amount !important;

        border-right: 1px solid #eeeeee !important;

        padding-right: 10px !important;
    }

    /* 7 - Payment Date */
    #payment_table tbody tr td:nth-child(7) {
        grid-area: payment_date !important;

        padding-left: 10px !important;
    }


    /* =========================================
       LABELS
       ========================================= */

    #payment_table tbody td::before {
        display: block !important;

        margin-bottom: 4px !important;

        font-size: 9px !important;
        line-height: 12px !important;

        font-weight: 700 !important;
        letter-spacing: 0.55px !important;

        color: #9298a1 !important;
    }

    #payment_table tbody td:nth-child(1)::before {
        content: "PAYMENT ID";
    }

    #payment_table tbody td:nth-child(2)::before {
        content: "ORDER ID";
    }

    #payment_table tbody td:nth-child(3)::before {
        content: "PAYMENT TYPE";
    }

    #payment_table tbody td:nth-child(4)::before {
        content: "ORGANIZATION";
    }

    #payment_table tbody td:nth-child(5)::before {
        content: "STATUS";
    }

    #payment_table tbody td:nth-child(6)::before {
        content: "AMOUNT";
    }

    #payment_table tbody td:nth-child(7)::before {
        content: "PAYMENT DATE";
    }


    /* =========================================
       LINKS
       ========================================= */

    #payment_table tbody td:nth-child(1) a,
    #payment_table tbody td:nth-child(2) a {
        font-size: 12px !important;
        font-weight: 700 !important;

        color: #343a40 !important;

        text-decoration: none !important;
    }


    /* =========================================
       STATUS BADGE
       ========================================= */

    #payment_table tbody td:nth-child(5) .badge {
        width: auto !important;
        min-width: 70px !important;
        max-width: 100px !important;

        align-self: flex-start !important;

        padding: 4px 8px !important;

        font-size: 9px !important;
        line-height: 13px !important;

        text-align: center !important;
    }


    /* =========================================
       PAGINATION
       ========================================= */

    #paginationbarPayment {
        width: 100% !important;

        display: flex !important;
        justify-content: center !important;
        align-items: center !important;

        margin-top: 8px !important;
        margin-bottom: 5px !important;
    }

    #paginationbarPayment .pagination {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;

        gap: 3px !important;

        margin: 0 !important;
    }

    #paginationbarPayment .page-link {
        width: 34px !important;
        height: 34px !important;

        padding: 0 !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        border: 0 !important;
        border-radius: 8px !important;

        background: transparent !important;

        color: #555 !important;

        font-size: 12px !important;
        font-weight: 600 !important;
    }

    #paginationbarPayment .page-item.active .page-link {
        background-color: #717070 !important;
        color: #fff !important;
    }

    #paginationbarPayment .page-item.disabled .page-link {
        opacity: 0.35 !important;
        pointer-events: none !important;
    }
}

@media (max-width: 767.98px) {

    /* =========================================
       TODAY'S ACTIVITIES - MOBILE CARD
       ========================================= */

    #activity_dashboard_table {
        width: 100% !important;
        min-width: 0 !important;
        margin: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
    }

    #activity_table_dashboard_salesRep {
        display: block !important;
        width: 100% !important;
    }


    /* =========================================
       ACTIVITY CARD
       ========================================= */

    #activity_table_dashboard_salesRep tr {
        display: grid !important;

        grid-template-columns: 38px 1fr !important;
        grid-template-areas:
            "icon subject"
            "icon organization" !important;

        width: 100% !important;

        margin: 0 0 10px 0 !important;
        padding: 8px !important;

        background: #ffffff !important;

        border: 1px solid #e6e8eb !important;
        border-radius: 12px !important;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;

        box-sizing: border-box !important;
    }


    /* =========================================
       ALL CELLS
       ========================================= */

    #activity_table_dashboard_salesRep tr th,
    #activity_table_dashboard_salesRep tr td {

        width: auto !important;
        min-width: 0 !important;

        margin: 0 !important;

        padding: 5px 7px !important;

        border: unset !important;

        box-sizing: border-box !important;

        vertical-align: middle !important;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }


    /* =========================================
       VIEW ICON
       ========================================= */

    #activity_table_dashboard_salesRep tr th:nth-child(1) {

        grid-area: icon !important;

        display: flex !important;

        align-items: flex-start !important;
        justify-content: center !important;

        padding: 7px 4px !important;
    }


    #activity_table_dashboard_salesRep tr th:nth-child(1) a {

        width: 30px !important;
        height: 30px !important;

        display: flex !important;

        align-items: center !important;
        justify-content: center !important;

        border-radius: 9px !important;

        background: #f1f3f5 !important;

        color: #555 !important;

        text-decoration: none !important;

        font-size: 12px !important;

        transition: all 0.2s ease !important;
    }


    #activity_table_dashboard_salesRep tr th:nth-child(1) a:active {
        transform: scale(0.94) !important;
    }


    /* =========================================
       ACTIVITY SUBJECT
       ========================================= */

    #activity_table_dashboard_salesRep tr th:nth-child(2) {

        grid-area: subject !important;

        display: flex !important;

        align-items: center !important;

        padding-left: 7px !important;
        padding-right: 5px !important;
    }


    #activity_table_dashboard_salesRep tr th:nth-child(2) a {

        display: block !important;

        width: 100% !important;

        font-size: 12px !important;

        line-height: 17px !important;

        font-weight: 700 !important;

        color: #343a40 !important;

        text-decoration: none !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;
    }


    /* =========================================
       ORGANIZATION
       ========================================= */

    #activity_table_dashboard_salesRep tr td:nth-child(1) {

        grid-area: organization !important;

        display: flex !important;

        flex-direction: column !important;

        padding-left: 7px !important;
        padding-top: 0 !important;

        font-size: 11px !important;

        line-height: 16px !important;

        color: #6c757d !important;
    }


    #activity_table_dashboard_salesRep tr td:nth-child(1)::before {

        content: "ORGANIZATION" !important;

        display: block !important;

        margin-bottom: 2px !important;

        font-size: 8px !important;

        line-height: 11px !important;

        font-weight: 700 !important;

        letter-spacing: 0.6px !important;

        color: #9aa0a6 !important;
    }


    /* =========================================
       REMOVE EXTRA TABLE STYLING
       ========================================= */

    #activity_dashboard_table tbody tr:hover {
        background: transparent !important;
    }

}

/* =========================================================
   CALENDAR - MOBILE RESPONSIVE
   CSS ONLY
   ========================================================= */

@media (max-width: 767.98px) {

    /* =====================================================
       MAIN TAB CONTAINER
       ===================================================== */

    #myTab {
        display: flex !important;
        width: 100% !important;

        margin: 0 0 10px 0 !important;
        padding: 4px !important;

        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;

        background: #f5f6f8 !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       TAB ITEMS
       ===================================================== */

    #myTab .nav-item {
        flex: 1 1 50% !important;
        width: 50% !important;

        margin: 0 !important;
        padding: 0 !important;
    }


    /* =====================================================
       TAB BUTTON
       ===================================================== */

    #myTab .nav-link {
        display: flex !important;

        align-items: center !important;
        justify-content: center !important;

        width: 100% !important;
        min-height: 38px !important;

        margin: 0 !important;
        padding: 7px 5px !important;

        border: 0 !important;
        border-radius: 9px !important;

        background: transparent !important;

        color: #73777d !important;

        font-size: 9px !important;
        font-weight: 700 !important;

        letter-spacing: .35px !important;

        line-height: 13px !important;

        white-space: nowrap !important;

        transition: all .2s ease !important;
    }


    /* =====================================================
       ACTIVE TAB
       ===================================================== */

    #myTab .nav-link.active {
        background: #ffffff !important;

        color: #343a40 !important;

        box-shadow:
            0 2px 7px rgba(0, 0, 0, .08) !important;
    }


    /* =====================================================
       TAB CONTENT
       ===================================================== */

    #myTabContent {
        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;
    }


    /* =====================================================
       TAB PANE
       ===================================================== */

    #myTabContent .tab-pane {
        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;
    }


    /* =====================================================
       CALENDAR CARD
       ===================================================== */

    .card-calendar {
        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;

        border: 0 !important;

        border-radius: 14px !important;

        background: #ffffff !important;

        overflow: hidden !important;
    }


    .card-calendar .card-body {
        width: 100% !important;

        margin: 0 !important;

        padding: 8px !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       FULL CALENDAR
       ===================================================== */

    #calendar,
    #calendarMeeting {
        width: 100% !important;

        max-width: 100% !important;

        font-size: 10px !important;

        overflow: hidden !important;
    }


    /* =====================================================
       CALENDAR TOOLBAR
       ===================================================== */

    #calendar .fc-header-toolbar,
    #calendarMeeting .fc-header-toolbar {

        display: flex !important;

        align-items: center !important;

        justify-content: space-between !important;

        width: 100% !important;

        margin-bottom: 8px !important;

        gap: 5px !important;
    }


    /* Toolbar chunks */
    #calendar .fc-toolbar-chunk,
    #calendarMeeting .fc-toolbar-chunk {

        display: flex !important;

        align-items: center !important;

        min-width: 0 !important;
    }


    /* =====================================================
       CALENDAR TITLE
       ===================================================== */

    #calendar .fc-toolbar-title,
    #calendarMeeting .fc-toolbar-title {

        font-size: 15px !important;

        font-weight: 700 !important;

        line-height: 20px !important;

        color: #343a40 !important;

        white-space: nowrap !important;
    }


    /* =====================================================
       CALENDAR BUTTONS
       ===================================================== */

    #calendar .fc-button,
    #calendarMeeting .fc-button {

        min-width: 30px !important;
        height: 30px !important;

        padding: 0 8px !important;

        border: 0 !important;

        border-radius: 8px !important;

        background: #f1f3f5 !important;

        color: #555 !important;

        box-shadow: none !important;

        font-size: 10px !important;

        font-weight: 600 !important;
    }


    #calendar .fc-button:hover,
    #calendarMeeting .fc-button:hover {

        background: #e9ecef !important;
    }


    #calendar .fc-button:focus,
    #calendarMeeting .fc-button:focus {

        box-shadow: none !important;
    }


    /* Today button */
    #calendar .fc-today-button,
    #calendarMeeting .fc-today-button {

        font-size: 9px !important;

        padding: 0 7px !important;
    }


    /* =====================================================
       WEEK HEADER
       ===================================================== */

    #calendar .fc-col-header-cell,
    #calendarMeeting .fc-col-header-cell {

        padding: 5px 0 !important;

        background: #f7f8fa !important;

        border-color: #eeeeee !important;
    }


    #calendar .fc-col-header-cell-cushion,
    #calendarMeeting .fc-col-header-cell-cushion {

        font-size: 8px !important;

        font-weight: 700 !important;

        letter-spacing: .3px !important;

        color: #858a91 !important;

        text-decoration: none !important;
    }


    /* =====================================================
       CALENDAR DAY CELLS
       ===================================================== */

    #calendar .fc-daygrid-day,
    #calendarMeeting .fc-daygrid-day {

        min-height: 58px !important;

        border-color: #eeeeee !important;
    }


    #calendar .fc-daygrid-day-frame,
    #calendarMeeting .fc-daygrid-day-frame {

        min-height: 58px !important;

        padding: 2px !important;
    }


    /* =====================================================
       DAY NUMBER
       ===================================================== */

    #calendar .fc-daygrid-day-number,
    #calendarMeeting .fc-daygrid-day-number {

        padding: 3px 4px !important;

        /* font-size: 9px !important; */

        font-weight: 600 !important;

        color: #62676d !important;

        text-decoration: none !important;
    }


    /* =====================================================
       TODAY CELL
       ===================================================== */

    #calendar .fc-day-today,
    #calendarMeeting .fc-day-today {

        background: rgba(113, 112, 112, .06) !important;
    }


    #calendar .fc-day-today .fc-daygrid-day-number,
    #calendarMeeting .fc-day-today .fc-daygrid-day-number {

        font-weight: 800 !important;
    }


    /* =====================================================
       EVENTS
       ===================================================== */

    #calendar .fc-daygrid-event,
    #calendarMeeting .fc-daygrid-event {

        margin: 1px 2px !important;

        padding: 2px 4px !important;

        border: 0 !important;

        border-radius: 5px !important;

        min-height: 16px !important;

        line-height: 12px !important;

        overflow: hidden !important;
    }


    #calendar .fc-event-title,
    #calendarMeeting .fc-event-title {

        font-size: 8px !important;

        font-weight: 600 !important;

        line-height: 11px !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;
    }


    /* =====================================================
       MEETING + BUTTON
       ===================================================== */

    #calendarMeeting .add-button {

        display: flex !important;

        align-items: center !important;
        justify-content: center !important;

        width: 17px !important;
        height: 17px !important;

        padding: 0 !important;

        /* top: -1px !important;
        right: 2px !important; */

        border: 0 !important;

        border-radius: 50% !important;

        background: #717070 !important;

        color: #ffffff !important;

        font-size: 12px !important;

        line-height: 17px !important;

        font-weight: 500 !important;

        box-shadow: 0 2px 5px rgba(0, 0, 0, .15) !important;

        z-index: 5 !important;
    }


    #calendarMeeting .add-button:active {

        transform: scale(.9) !important;
    }


    /* =====================================================
       EVENT MORE LINK
       ===================================================== */

    #calendar .fc-daygrid-more-link,
    #calendarMeeting .fc-daygrid-more-link {

        font-size: 8px !important;

        font-weight: 700 !important;

        color: #666 !important;
    }


    /* =====================================================
       PRODUCTION COLOR LEGEND
       ===================================================== */

    #color-legend {

        /* display: none !important; */
    }


    /* =====================================================
       HIDE EXCESS CALENDAR EVENTS ON VERY SMALL SCREENS
       ===================================================== */

    #calendar .fc-daygrid-day-events,
    #calendarMeeting .fc-daygrid-day-events {

        margin-top: 1px !important;
    }

}

/* =========================================================
   MOBILE - CALENDAR TOOLBAR + LEGEND SEPARATE ROWS
   ========================================================= */

@media (max-width: 767.98px) {

    /* -----------------------------------------------------
       CALENDAR HEADER AREA
       ----------------------------------------------------- */

    #calendar .fc-header-toolbar,
    #calendarMeeting .fc-header-toolbar {

        display: flex !important;

        flex-wrap: wrap !important;

        width: 100% !important;

        margin-bottom: 8px !important;

        gap: 0 !important;
    }


    /* -----------------------------------------------------
       MONTH TITLE
       ----------------------------------------------------- */

    #calendar .fc-toolbar-chunk:first-child,
    #calendarMeeting .fc-toolbar-chunk:first-child {

        flex: 1 1 auto !important;

        display: flex !important;

        align-items: center !important;

        justify-content: flex-start !important;

        min-width: 0 !important;

        order: 1 !important;
    }


    #calendar .fc-toolbar-title,
    #calendarMeeting .fc-toolbar-title {

        margin: 0 !important;

        font-size: 15px !important;

        font-weight: 700 !important;

        white-space: nowrap !important;
    }


    /* -----------------------------------------------------
       PREVIOUS / TODAY / NEXT
       ----------------------------------------------------- */

    #calendar .fc-toolbar-chunk:last-child,
    #calendarMeeting .fc-toolbar-chunk:last-child {

        flex: 0 0 auto !important;

        display: flex !important;

        align-items: center !important;

        justify-content: flex-end !important;

        order: 2 !important;

        gap: 3px !important;
    }


    #calendar .fc-button,
    #calendarMeeting .fc-button {

        height: 30px !important;

        min-width: 30px !important;

        margin: 0 !important;

        padding: 0 7px !important;

        border: 0 !important;

        border-radius: 8px !important;

        font-size: 9px !important;

        box-shadow: none !important;
    }


    #calendar .fc-prev-button,
    #calendar .fc-next-button,
    #calendarMeeting .fc-prev-button,
    #calendarMeeting .fc-next-button {

        width: 30px !important;

        min-width: 30px !important;

        padding: 0 !important;
    }


    #calendar .fc-today-button,
    #calendarMeeting .fc-today-button {

        min-width: 48px !important;

        padding: 0 7px !important;

        font-size: 9px !important;
    }


    /* =====================================================
       COLOR LEGEND
       FORCE IT TO A SEPARATE ROW
       ===================================================== */

    #color-legend {

        display: flex !important;

        flex-basis: 100% !important;

        width: 100% !important;

        flex: 0 0 100% !important;

        clear: both !important;

        order: 3 !important;

        box-sizing: border-box !important;

        align-items: center !important;

        justify-content: flex-start !important;

        margin: 8px 0 0 0 !important;

        padding: 6px 8px !important;

        background: #f8f9fa !important;

        border: 1px solid #eeeeee !important;

        border-radius: 8px !important;

        overflow-x: auto !important;

        overflow-y: hidden !important;

        white-space: nowrap !important;

        scrollbar-width: none !important;
    }


    #color-legend::-webkit-scrollbar {
        display: none !important;
    }


    /* -----------------------------------------------------
       KEEP ORIGINAL LEGEND COLORS
       ----------------------------------------------------- */

    #color-legend > * {

        flex: 0 0 auto !important;

        margin-top: 0 !important;

        margin-bottom: 0 !important;
    }
}


/* =========================================================
   EXTRA SMALL MOBILE
   ========================================================= */

@media (max-width: 380px) {

    #calendar .fc-toolbar-title,
    #calendarMeeting .fc-toolbar-title {
        font-size: 13px !important;
    }


    #calendar .fc-button,
    #calendarMeeting .fc-button {
        height: 28px !important;

        min-width: 27px !important;

        padding: 0 5px !important;

        font-size: 8px !important;
    }


    #calendar .fc-prev-button,
    #calendar .fc-next-button,
    #calendarMeeting .fc-prev-button,
    #calendarMeeting .fc-next-button {

        width: 27px !important;

        min-width: 27px !important;
    }


    #calendar .fc-today-button,
    #calendarMeeting .fc-today-button {

        min-width: 43px !important;
    }


    #color-legend {

        margin-top: 7px !important;

        padding: 5px 7px !important;
    }
}
/* =========================================================
   EXTRA SMALL MOBILE
   ========================================================= */

@media (max-width: 380px) {

    #myTab .nav-link {

        font-size: 8px !important;

        letter-spacing: .15px !important;
    }


    #calendar .fc-toolbar-title,
    #calendarMeeting .fc-toolbar-title {

        font-size: 13px !important;
    }


    #calendar .fc-button,
    #calendarMeeting .fc-button {

        min-width: 27px !important;

        height: 28px !important;

        padding: 0 6px !important;

        font-size: 8px !important;
    }


    #calendar .fc-daygrid-day,
    #calendarMeeting .fc-daygrid-day {

        min-height: 52px !important;
    }


    #calendar .fc-daygrid-day-frame,
    #calendarMeeting .fc-daygrid-day-frame {

        min-height: 52px !important;
    }


    #calendar .fc-event-title,
    #calendarMeeting .fc-event-title {

        font-size: 7px !important;
    }
}

/* =========================================================
   MOBILE SEARCH DROPDOWN
   IMPORTANT:
   - Original dropdown position is NOT changed
   - No position: fixed
   - No top / left / right changes
   - Tabs = TOP
   - Results = BELOW TABS
   ========================================================= */

@media (max-width: 767.98px) {

    /* -----------------------------------------------------
       DROPDOWN
       Keep its ORIGINAL Bootstrap/dropdown position
       ----------------------------------------------------- */

    .dropdown-menu-custom {
        width: calc(100vw - 45px) !important;
        max-width: calc(100vw - 20px) !important;

        /* DO NOT change its position */
        position: absolute !important;

        /* Override your inline desktop transform ONLY */
        transform: none !important;

        padding: 0 !important;

        overflow: hidden;

        border-radius: 14px;
        left: 50% !important;
    }


    /* -----------------------------------------------------
       MAIN CONTAINER
       Tabs first, results second
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tabs {
        display: flex !important;
        flex-direction: column !important;

        width: 100% !important;
        height: auto !important;
        min-height: 0 !important;

        overflow: hidden;
    }


    /* -----------------------------------------------------
       TABS
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tab-bar {
        order: 1;

        width: 100% !important;
        height: 50px !important;

        flex: 0 0 auto !important;

        /* display: flex !important; */
        flex-direction: row !important;

        align-items: center;

        padding: 8px 8px;

        gap: 5px;

        overflow-x: auto !important;
        overflow-y: hidden !important;

        background: #f8fafc;

        border-right: 0 !important;
        border-bottom: 1px solid #e5e7eb;

        white-space: nowrap;

        scrollbar-width: none;

        -webkit-overflow-scrolling: touch;
        min-height: 50px;
    }

    .dropdown-menu-custom .custom-tab-bar::-webkit-scrollbar {
        display: none;
    }


    /* -----------------------------------------------------
       INDIVIDUAL TAB
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tab {
        position: relative;

        flex: 0 0 auto !important;

        width: auto !important;
        min-width: max-content !important;

        height: 38px;
        min-height: 38px;

        display: inline-flex !important;
        align-items: center;
        justify-content: center;

        padding: 7px 12px;

        margin: 0 !important;

        border-radius: 8px;

        font-size: 11px;
        font-weight: 500;

        white-space: nowrap;

        transform: none !important;
    }


    .dropdown-menu-custom .custom-tab i {
        width: auto !important;

        margin-right: 4px;

        font-size: 11px;
    }


    /* -----------------------------------------------------
       ACTIVE TAB
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tab.active {
        background: #ffffff;

        color: #111827;

        font-weight: 600;

        box-shadow: 0 2px 7px rgba(0, 0, 0, 0.07);
    }


    .dropdown-menu-custom .custom-tab.active::before {
        content: "";

        position: absolute;

        left: 10px;
        right: 10px;

        top: auto;
        bottom: 0;

        width: auto;
        height: 2px;

        border-radius: 4px 4px 0 0;

        background: #111827;
    }


    /* -----------------------------------------------------
       RESULTS CONTAINER
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tab-content {
        order: 2;

        width: 100% !important;

        flex: 0 0 auto !important;

        min-width: 0 !important;
        min-height: 0 !important;

        height: auto !important;

        overflow: hidden;
    }


    /* -----------------------------------------------------
       TAB PANE
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tab-pane {
        width: 100% !important;

        height: auto !important;
        min-height: 0 !important;

        overflow: hidden;
    }


    /* -----------------------------------------------------
       RESULT SCROLL AREA

       This is the important part.
       Results get their own scroll area instead of
       occupying the whole dropdown height.
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tab-pane > .list-group {
        width: 100% !important;

        height: auto !important;

        max-height: 55vh !important;

        overflow-x: hidden !important;
        overflow-y: auto !important;

        padding: 5px 0;

        margin: 0 !important;
    }


    /* -----------------------------------------------------
       RESULT CARD
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tab-pane .list-group-item {
        display: flex !important;
        align-items: center !important;

        width: calc(100% - 12px);

        min-height: 65px;

        margin: 5px 6px;

        padding: 10px !important;

        border: 1px solid #edf0f4 !important;

        border-radius: 11px;

        background: #ffffff;

        box-shadow:
            0 2px 7px rgba(15, 23, 42, 0.04);

        transition:
            box-shadow 0.2s ease,
            transform 0.2s ease;
    }


    .dropdown-menu-custom .custom-tab-pane
    .list-group-item:hover {

        padding-left: 10px !important;

        transform: translateY(-1px);

        box-shadow:
            0 4px 12px rgba(15, 23, 42, 0.08);
    }


    /* -----------------------------------------------------
       RESULT ICON
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tab-pane
    .list-group-item > div > i {

        width: 38px !important;
        height: 38px !important;

        flex: 0 0 38px;

        display: flex !important;
        align-items: center;
        justify-content: center;

        margin-right: 9px !important;

        border-radius: 10px;

        background: #f1f5f9;

        color: #334155 !important;

        font-size: 14px !important;
    }


    /* -----------------------------------------------------
       RESULT TEXT
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tab-pane
    .list-group-item > div {

        min-width: 0;
    }


    .dropdown-menu-custom .custom-tab-pane
    .list-group-item > div > div {

        min-width: 0;

        overflow: hidden;
    }


    .dropdown-menu-custom .custom-tab-pane
    .list-group-item a {

        display: inline-block;

        max-width: 100%;

        font-size: 12px !important;
        line-height: 1.35;

        font-weight: 600 !important;

        white-space: normal;

        overflow-wrap: anywhere;
    }


    .dropdown-menu-custom .custom-tab-pane
    .list-group-item small {

        display: block;

        max-width: 100%;

        margin-top: 2px;

        font-size: 10px;

        line-height: 1.4;

        color: #64748b;

        white-space: normal;

        overflow-wrap: anywhere;
    }


    /* -----------------------------------------------------
       SEARCH HIGHLIGHT
       ----------------------------------------------------- */

    .dropdown-menu-custom .highlight {
        padding: 1px 3px;

        border-radius: 3px;

        background: #fef3c7;

        color: #92400e;

        font-weight: 600;
    }


    /* -----------------------------------------------------
       LOADING / NO RESULT AREA
       ----------------------------------------------------- */

    .dropdown-menu-custom .custom-tab-pane
    .d-flex.justify-content-center {

        min-height: 120px;

        padding: 20px 10px;
    }

    .dropdown-menu-custom .spinner-border span {

        font-size: 10px;
    }
}


/* =========================================================
   VERY SMALL MOBILE
   ========================================================= */

@media (max-width: 420px) {

    .dropdown-menu-custom {
        width: calc(100vw - 12px) !important;
        max-width: calc(100vw - 12px) !important;
    }

    .dropdown-menu-custom .custom-tab-bar {
        padding: 7px 6px;
    }

    .dropdown-menu-custom .custom-tab {
        height: 36px;
        min-height: 36px;

        padding: 6px 9px;

        font-size: 10px;
    }

    .dropdown-menu-custom .custom-tab i {
        font-size: 10px;
    }

    .dropdown-menu-custom .custom-tab-pane > .list-group {
        max-height: 52vh !important;
    }
}

/* =========================================================
   DESKTOP PAGINATION
   ========================================================= */

#orders_body tr.mobile-order-hidden {
    display: none !important;
}

#orders_body tr.mobile-order-visible {
    display: table-row !important;
}


/* =========================================================
   MOBILE PAGINATION
   ========================================================= */

@media (max-width: 767.98px) {

    /* Hidden rows */
    #orders_body tr.mobile-order-hidden {
        display: none !important;
    }

    /* Visible rows */
    #orders_body tr.mobile-order-visible {
        display: block !important;
    }
}

</style>

<div style="display: none;">
    <select class="form-control ml-2" id="loggedin_user_id">
        @foreach ($users as $user)
        <option value="{{$user->id}}" @if ($user->id == auth()->user()->id) selected @endif>{{$user->name}}</option>
        @endforeach
    </select>
</div>
    <div class="container-fluid mb-5 content_position">
        <div class="se-pre-con"></div>

        <div class="col-md-12 d-flex justify-content-center text-center card" style="padding: unset; padding-left: 10px; padding-right: 10px; border: unset; margin-bottom: 10px;">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 ">

                </div>
                <div class="col-lg-6 col-md-6 col-sm-12" style="padding-left: 4px; padding-right: 4px; padding-top: 15px;">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <div class="input-group input-group-alternative" style="border: 1px solid #b3b3b3;">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background-color: transparent;"><i class="ni ni-zoom-split-in"></i></span>
                            </div>
                            <input class="form-control" placeholder="Input more than 2 characters" type="text" id="search_input_text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- Dropdown menu -->
                            <div class="dropdown-menu dropdown-menu-custom mt-3" aria-labelledby="search_input_text" style="padding: 0px; transform: translateX(-50%) !important;">
                                <div class="custom-tabs">
                                    <div class="custom-tab-bar">
                                        <a href="#" class="custom-tab active" data-tab="all-tab-content">
                                            <i class="fas fa-list"></i>&nbsp; All
                                        </a>
                                        <a href="#" class="custom-tab" data-tab="organization-tab-content">
                                            <i class="fas fa-building"></i>&nbsp; Organizations
                                        </a>
                                        <a href="#" class="custom-tab" data-tab="peoples-tab-content">
                                            <i class="fas fa-users"></i>&nbsp; Peoples
                                        </a>
                                        <a href="#" class="custom-tab" data-tab="activities-tab-content">
                                            <i class="fas fa-tasks"></i>&nbsp; Activities
                                        </a>
                                        <a href="#" class="custom-tab" data-tab="orders-tab-content">
                                            <i class="fas fa-tasks"></i>&nbsp; Orders
                                        </a>
                                    </div>
                                    <div class="custom-tab-content">
                                        <div class="custom-tab-pane fade show active" id="all-tab-content">
                                            <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                                                <ul class="list-group list-group-flush" id="all-list-ul">
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
                                        <div class="custom-tab-pane" id="organization-tab-content">
                                            <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                                                <ul class="list-group list-group-flush" id="organization-list-ul">
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
                                                <ul class="list-group list-group-flush" id="peoples-list-ul">
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
                                        <div class="custom-tab-pane" id="activities-tab-content">
                                            <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                                                <ul class="list-group list-group-flush" id="activities-list-ul">
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
                                        <div class="custom-tab-pane" id="orders-tab-content">
                                            <div class="list-group" style="max-height: 59vh; overflow-y: auto;">
                                                <ul class="list-group list-group-flush" id="orders-list-ul">
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
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">

                </div>
            </div>
            @include('pages.settings.activity.add_new_activity')
        </div>

        <div class="col-md-12" style="padding: unset; padding-left: 10px; padding-right: 10px;">

            <div class="row" id="dataContainer">

                <div class="col-lg-3 col-md-6 col-sm-6 detail_card_padding col-6">
                    <div class="card" style="border: unset; cursor: pointer;">
                        <div class="row total_sales" id="new_orders">
                            <div style="display: flex; justify-content: center; align-items: center;;">
                                <img src="{{ asset('assets') }}/img/dashboard/cart.png" class="total_sale_img_size" alt="image">
                            </div>
                            <div style="padding-left: 10px;">
                                <div><p class="total_sale_p1" >New Quote</p></div>
                                <div class="row" style="margin: unset;">
                                    <b class="total_sale_b">Total  {{ $orderQuoteCount }}</b>

                                </div>
                                <div>
                                    <p class="total_sale_p2">Own  {{ $orderQuoteCountOwn }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 detail_card_padding col-6">
                    <div class="card" style="border: unset; cursor: pointer;">
                        <div class="row total_sales"  id="production_orders">
                            <div style="display: flex; justify-content: center; align-items: center;;">
                                <img src="{{ asset('assets') }}/img/dashboard/production.png" class="total_sale_img_size" alt="image">
                            </div>
                            <div style="padding-left: 10px;">
                                <div><p class="total_sale_p1" >Orders in Production</p></div>
                                <div class="row" style="margin: unset;">
                                    <b class="total_sale_b">Total {{ $orderProductionCount }}</b>

                                </div>
                                <div>
                                    <p class="total_sale_p2">Own {{ $orderProductionCountOwn }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 detail_card_padding col-6">
                    <div class="card" style="border: unset; cursor: pointer;">
                        <div class="row total_sales" id="pending_shipment">
                            <div style="display: flex; justify-content: center; align-items: center;;">
                                <img src="{{ asset('assets') }}/img/dashboard/shipping.png" class="total_sale_img_size" alt="image">
                            </div>
                            <div style="padding-left: 10px;">
                                <div><p class="total_sale_p1" >This week Shipment</p></div>
                                <div class="row" style="margin: unset;">
                                    <b class="total_sale_b">Total {{ $orderShipmentCount }}</b>

                                </div>
                                <div>
                                    <p class="total_sale_p2">Own {{ $orderShipmentCountOwn }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 detail_card_padding col-6">
                    <div class="card" style="border: unset; cursor: pointer;">
                        <div class="row total_sales"  id="fulfilled_orders">
                            <div style="display: flex; justify-content: center; align-items: center;;">
                                <img src="{{ asset('assets') }}/img/dashboard/sales.png" class="total_sale_img_size" alt="image">
                            </div>
                            <div style="padding-left: 10px;">
                                <div><p class="total_sale_p1" >Fulfilled Orders</p></div>
                                <div class="row" style="margin: unset;">
                                    <b class="total_sale_b">Total {{ $orderFulfilledCount }}</b>


                                </div>
                                <div>
                                    <p class="total_sale_p2">Own {{ $orderFulfilledCountOwn }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-12 col-lg-12" style="padding: unset; margin-top: 5px; border: unset; margin-bottom: 5px;">
            <div class="" style="margin: unset; width: 100%;">
                <div class="card" style="border: unset; width: 100%; padding: 10px;">

                    <b style="font-size: 16px;" id="order_topic"></b>
                    <div class="recent_order" style=" padding-top: 15px; overflow-x: auto;">
                        <table class="table align-items-center" id="order_table" style="min-width: 100%;">
                            <thead style="background-color: #717070;">
                                <th scope="col" class="table_header_text" style="">ORDER ID  </th>
                                <th scope="col" class="table_header_text">ORGANIZATION </th>
                                <th scope="col" class="table_header_text" style="">FACTORY </th>
                                <th scope="col" class="table_header_text" style="">ORDER DESCRIPTION</th>
                                <th scope="col" class="table_header_text" style="">EX FACTORY DATE</th>
                                <th scope="col" class="table_header_text" style="">IN-HAND DATE</th>
                                <th scope="col" class="table_header_text" style="">TEST PRINT DUE DATE</th>
                                <th scope="col" class="table_header_text" style="">ORDERED QTY</th>
                                {{-- <th scope="col" class="table_header_text" style="">SALES REP</th> --}}
                            </thead>

                            <tbody id="orders_body">

                            </tbody>

                        </table>

                        <div>
                            <div id="paginationbarUrgent" class="row justify-content-center" style="width: 100%;">
                              {{-- pagination bar paste here --}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-12" style="padding: unset; padding-left: 15px; padding-right: 15px; border: unset;">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3 mb-lg-0" style="padding: unset; padding-right: 5px; margin-top: 5px;">
                    <div class="card" style="border: unset; height: 100%; max-height: 407px; min-height: 407px;">
                        <div class="row" style="padding-left: 10px; padding-top: 10px; margin:unset;">
                            <b style="font-size: 16px;">Today's Activities</b>
                            <div>
                                <select class="form-control ml-2" id="selected_user_id" style="height: 25px; margin-left: 25px !important;">
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}" @if ($user->id == auth()->user()->id) selected @endif>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- <div class="background-date" id="backgroundDate"></div> --}}
                        <div class="row" style="margin-left: 20px; padding-top: 20px; width: 90%; max-width: 90%; overflow-y: auto;">
                            <table class="table align-items-center" id="activity_dashboard_table" style="min-width: 100%;">
                                <tbody id="activity_table_dashboard_salesRep">
                                    <!-- Data will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 mb-3 mb-lg-0" style="padding: unset; margin-top: 5px; padding-left: 5px;">
                    <div class="card" style="border: unset; height: 100%; max-height: 407px; min-height: 407px;">
                        <div id="titleRow" class="row" style="padding-left: 10px; padding-top: 10px; margin:unset; padding-right: 10px;  overflow-y: auto; height: 11%; min-height: 11%; max-height: 11%;">
                            <b style="font-size: 16px; padding-bottom: 11px;">Unread Emails</b>
                        </div>
                        <div class="row" style="margin-left: 20px; padding-top: 20px; width: 90%; max-width: 90%; overflow-y: auto;">
                            @if(session('azure_access_token') && session('azure_refresh_token'))

                                <table class="table align-items-center" id="email_dashboard_table" style="min-width: 50%; cursor: pointer;">
                                    <tbody id="email_table_dashboard_salesRep">

                                    </tbody>
                                </table>

                                <div id="emailContainer" style="width: 100%; text-align: center;"></div>
                            @else
                                <a href="{{ url('/callbackmail') }}" class="log_email">Please log in first to view your emails.</a>

                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- calendars --}}
        @if(session('success') == 'Meeting Updated Successfully!')
            <div id="scroll-target"></div>
        @endif
        @if(session('success') == 'Meeting Saved Successfully!')
            <div id="scroll-target"></div>
        @endif

        <div class="col-lg-12" id="calendar-section" style="padding: unset; padding-top: 10px;">
            <div class="row" style="margin: unset;">
                <div class="card" style="border: unset; width: 100%; padding: 10px;">
                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="border-bottom: 1px solid lightgray; margin-bottom: 5px;">
                        <li class="nav-item">
                            <a class="nav-link tab-topic active"  style="color: black !important; background-color: transparent; border-color: transparent;" id="production_calender_tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">PRODUCTION CALENDER </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tab-topic" style="color: black !important; background-color: transparent; border-color: transparent;"  id="meeting_calender_tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">MEETING CALENDER</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <!-- Card body -->
                        <div class="tab-pane fade show active" id="tab2" role="tabpanel" aria-labelledby="production_calender_tab">
                            <div class="card-calendar">
                                <div class="card-body p-3">
                                    <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="meeting_calender_tab">
                            <div class="card-calendar">
                                <div class="card-body p-3">
                                    <div class="calendar" data-bs-toggle="calendarMeeting" id="calendarMeeting"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var successMessage = "{{ session('success') }}";
                if(successMessage === 'Meeting Updated Successfully!' || successMessage === 'Meeting Saved Successfully!') {

                    var scrollTarget = document.getElementById('scroll-target');
                    if(scrollTarget) {

                        scrollTarget.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            });
        </script>
        {{-- End calendars --}}

        <div class="col-md-12 col-lg-12" style="padding: unset; margin-top: 10px; border: unset; margin-bottom: 5px;">
            <div class="" style="margin: unset; width: 100%;">
                <div class="card" style="border: unset; width: 100%; padding: 10px;">

                    <b style="font-size: 16px;" id="payment_topic">Payment Details</b>
                    <div class="recent_order" style=" padding-top: 15px; overflow-x: auto;">
                        <table class="table align-items-center" id="payment_table" style="min-width: 100%;">
                            <thead style="background-color: #717070;">
                                <th scope="col" class="table_header_text" style="">PAYMENT ID</th>
                                <th scope="col" class="table_header_text" style="">ORDER ID  </th>
                                <th scope="col" class="table_header_text">PAYMENT TYPE </th>
                                <th scope="col" class="table_header_text">ORGANIZATION </th>
                                <th scope="col" class="table_header_text" style="">STATUS</th>
                                <th scope="col" class="table_header_text" style="">AMOUNT</th>
                                <th scope="col" class="table_header_text" style="">PAYMENT DATE</th>
                            </thead>

                            <tbody id="payment_details">

                            </tbody>

                        </table>

                        <div>
                            <div id="paginationbarPayment" class="row justify-content-center" style="width: 100%;">
                              {{-- pagination bar paste here --}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        {{-- Notification Modal --}}
        <div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-lg" role="document">
                <div class="modal-content" style="background-color: white;border-radius:0rem">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal_title_notification" style="color: black;font-size: 13px;">2</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: black;">×</span>
                        </button>
                        <input type="hidden" id="refresh_required" value="0" />
                    </div>

                    <div class="modal-body">
                        <div class="py-3 text-center new-style-table">
                            <div class="col-md-12 table-responsive">
                                <div class="row" id="check_payment">
                                    <table class='table' style='color: rgb(51, 48, 48);'><thead><th>#</th><th>Method</th><th>Name on Card</th><th>Transaction Id</th><th class="text-right">Amount</th><th>Date</th><th>Time</th></thead><tbody></tbody><br><tfoot><th style='font-size: 15px;' colspan='3'>Total Amount</th><th style='font-size: 15px;' class='text-right'>$ {{number_format('454', 2)}}</th></tfoot></table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" id="modal-footer">

                    </div>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" id="mailboxId" value="">
    <input type="hidden" id="message_no_opened" value="">
{{-- <div style="display: none !important;">
    @include('pages.mail.view')
</div> --}}

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js"></script>


    <script>

        document.addEventListener('DOMContentLoaded', function() {

            // production calendar

            var productionOrdersThisMonth = @json($productionOrdersThisMonth);
            var factoriesCalendar = @json($factoriesCalendar);

            // console.log(productionOrdersThisMonth);

            function getEventsForDateRange(startDate, endDate) {
                return productionOrdersThisMonth.filter(function(order) {
                    var orderDate = moment(order.ex_factory_date, 'MM/DD/YYYY');
                    return orderDate.isBetween(startDate, endDate, 'day', '[]');
                }).map(function(order) {
                    var organizationName = order.organization_details.organization_name;
                    var orderNumber = order.order_no;
                    var shortName = organizationName.length > 20 ? organizationName.substring(0, 17) + '...' : organizationName;

                    var factoryColors = order.order_items
                        .map(function(item) {
                            return item.factory_details ? item.factory_details.factory_color : '#FFFFFF';
                        });

                    function mixColors(colors) {
                        var uniqueColors = colors.filter(function(item, index) {
                            return colors.indexOf(item) === index;
                        });

                        if (uniqueColors.length === 0) {
                            return '#FFFFFF';
                        } else if (uniqueColors.length === 1) {
                            return uniqueColors[0];
                        } else {
                            var segmentWidth = 100 / uniqueColors.length;
                            var segments = [];

                            for (var i = 0; i < uniqueColors.length; i++) {
                                segments.push(`${uniqueColors[i]} ${i * segmentWidth}% ${((i + 1) * segmentWidth)}%`);
                            }

                            var gradient = segments.join(', ');

                            return gradient;
                        }
                    }

                    var backgroundColor = mixColors(factoryColors);

                    return {
                        title: shortName,
                        fullTitle: `Order # :  ${orderNumber},  ${organizationName}`,
                        start: moment(order.ex_factory_date, 'MM/DD/YYYY').format('YYYY-MM-DD'),
                        backgroundColor: backgroundColor,
                        organizationName: organizationName,
                        orderId: order.id
                    };
                });
            }

            function createColorLegend(factories) {
                var legendContainer = document.createElement('div');
                legendContainer.id = 'color-legend';
                legendContainer.style.display = 'inline-block';
                legendContainer.style.verticalAlign = 'middle';
                legendContainer.style.margin = '0 10px';

                factories.forEach(factory => {
                    var colorTag = document.createElement('div');
                    colorTag.style.backgroundColor = factory.factory_color;
                    colorTag.style.display = 'inline-block';
                    colorTag.style.width = '50px';
                    colorTag.style.height = '20px';
                    colorTag.style.marginRight = '5px';
                    colorTag.style.position = 'relative';
                    colorTag.style.textAlign = 'center';
                    colorTag.style.lineHeight = '20px';
                    colorTag.style.color = '#fff';
                    colorTag.style.fontSize = '10px';
                    colorTag.title = factory.factory_code;
                    colorTag.style.cursor = 'pointer';

                    var colorText = document.createElement('span');
                    colorText.textContent = factory.factory_code;
                    colorText.style.position = 'absolute';
                    colorText.style.top = '50%';
                    colorText.style.left = '50%';
                    colorText.style.transform = 'translate(-50%, -50%)';
                    colorText.style.whiteSpace = 'nowrap';

                    colorTag.appendChild(colorText);
                    legendContainer.appendChild(colorTag);
                });

                return legendContainer;
            }

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'title',
                    center: '',
                    right: 'today prev,next'
                },
                datesSet: function(info) {
                    var events = getEventsForDateRange(info.start, info.end);
                    calendar.removeAllEvents();
                    events.forEach(function(event) {
                        calendar.addEvent(event);
                    });
                },
                eventDidMount: function(info) {
                    info.el.setAttribute('title', info.event.extendedProps.fullTitle);
                    info.el.style.cursor = 'pointer';

                    var backgroundColor = info.backgroundColor;
                    info.el.style.background = `linear-gradient(to right, ${backgroundColor})`;
                    info.el.style.border = `unset`;

                    $(info.el).on("click", function() {
                        var orderId = info.event.extendedProps.orderId;
                        window.open('order_details/edit/' + orderId + '/order?active_tab=order', '_blank');
                    });
                }
            });

            calendar.render();

            var headerCenter = calendarEl.querySelector('.fc-toolbar-chunk:nth-child(2)');
            var colorLegend = createColorLegend(factoriesCalendar);
            headerCenter.appendChild(colorLegend);

            // End  production calendar


            // Meeting calendar

            var activitiesMeetingCalendar = @json($activitiesMeetingCalendar);

            function truncateText(text, maxLength) {
                if (text.length > maxLength) {
                    return text.substring(0, maxLength) + '...';
                }
                return text;
            }

            function mapEvents(data) {
                return data.map(function(activity) {
                    const event = {
                        fullTitle: activity.activity_subject,
                        title: truncateText(activity.activity_subject, 20),
                        start: moment(activity.start_date).format('YYYY-MM-DD'),
                        className: 'activity-edit',
                        extendedProps: {
                            'data-activity_id': activity.id
                        }
                    };
                    return event;
                });
            }

            var calendarMeeting;
            var openedByPlusButton = false;
            var eventColors = ['#008cff', 'orange', '#09DD00', '#9b32eb', '#c70000', '#8C0000', '#9e9e9e', '#FFE600']; // Define the colors you want to use
            var eventColorCounters = {}; // To keep track of event count per day

            $('#meeting_calender_tab').on('shown.bs.tab', function(e) {
                if (!calendarMeeting) {
                    var calendarMeetingEl = document.getElementById('calendarMeeting');
                    calendarMeeting = new FullCalendar.Calendar(calendarMeetingEl, {
                        initialView: 'dayGridMonth',
                        events: mapEvents(activitiesMeetingCalendar),
                        eventContent: function(arg) {
                            const eventClass = arg.event.classNames.join(' ');
                            const dataActivityId = arg.event.extendedProps['data-activity_id'];
                            return {
                                html: `<a href="#" class="${eventClass}" data-activity_id="${dataActivityId}" style="color: white !important;">${arg.event.title}</a>`
                            };
                        },
                        dayCellContent: function(arg) {
                            const dayCellContainer = document.createElement('div');
                            dayCellContainer.style.position = 'relative';

                            const dayNumber = document.createElement('span');
                            dayNumber.innerHTML = arg.dayNumberText;
                            dayCellContainer.appendChild(dayNumber);

                            const addButton = document.createElement('button');
                            addButton.innerHTML = '+';
                            addButton.className = 'add-button';
                            addButton.style.position = 'absolute';
                            addButton.style.top = '-3px';
                            addButton.style.right = '18px';
                            addButton.style.cursor = 'pointer';

                            addButton.addEventListener('click', function(e) {
                                e.stopPropagation();
                                var date = moment(arg.date).format('L');
                                openedByPlusButton = true; // Set the flag to true
                                openModalWithStartDate(date);
                            });

                            addButton.addEventListener('mouseenter', function(e) {
                                e.stopPropagation();
                                addButton.setAttribute('title', 'Add New Meeting');
                            });

                            addButton.addEventListener('mouseleave', function(e) {
                                e.stopPropagation();
                                addButton.removeAttribute('title');
                            });

                            dayCellContainer.appendChild(addButton);

                            return { domNodes: [dayCellContainer] };
                        },
                        eventDidMount: function(info) {
                            const eventTitle = info.event.title;
                            const eventDate = moment(info.event.start).format('YYYY-MM-DD');

                            if (!eventColorCounters[eventDate]) {
                                eventColorCounters[eventDate] = 0;
                            }
                            const eventColor = eventColors[eventColorCounters[eventDate] % eventColors.length];
                            eventColorCounters[eventDate]++;

                            info.el.setAttribute('title', eventTitle);
                            info.el.style.cursor = 'pointer';
                            info.el.style.backgroundColor = eventColor;
                            info.el.style.border = `unset`;
                            openedByPlusButton = true;

                            $(info.el).on('click', function(e) {
                                e.preventDefault();
                                var activity_id = info.event.extendedProps['data-activity_id'];
                                $('#activity_delete_button').show();

                                $.ajax({
                                    url: "{{ url('activities/get_organizations') }}",
                                    method: 'GET',
                                    dataType: 'json',
                                    beforeSend: function() {
                                        $(".se-pre-con").fadeIn('slow');
                                    },
                                    success: function(data) {
                                        var organizations = data;

                                        var org_options = '<option value="">Select an Organization</option>';
                                        for (let i = 0; i < organizations.length; i++) {
                                            org_options += '<option value="' + organizations[i].id + '">' + organizations[i].organization_name + '</option>';
                                        }
                                        $('#activity_organization_id').html(org_options);
                                    },
                                    complete: function() {
                                        $.ajax({
                                            url: "{{ url('activities/get_activity_by_id') }}/" + activity_id,
                                            method: 'GET',
                                            dataType: 'json',
                                            success: function(data) {
                                                var start_date = moment(data.start_date).format('L');
                                                var start_time = moment(data.start_date).format('LT');
                                                var due_date = moment(data.due_date).format('L');

                                                var today_day = moment().format('dddd, MMMM Do');
                                                var today_date = moment().format('L');
                                                $('#selected_day').html(today_day);
                                                $('#selected_date').val(today_date);

                                                var today_date = today_date.replace(/\//g, '-');
                                                getMeetingsByDate(today_date);

                                                $('#activity_note').val('');
                                                $('#activity_order_id').val('').trigger('change');
                                                $('#activity_organization_id').val('').trigger('change');
                                                $('#activity_contact_id').val('').trigger('change');

                                                $('#activity_id').val(activity_id);
                                                $('#activity_subject').val(data.activity_subject);
                                                $('#activity_note').val(data.activity_note);
                                                quill.clipboard.dangerouslyPasteHTML(data.activity_note);
                                                $('#activity_priority').val(data.priority).trigger('change');
                                                $('#start_date').val(start_date);
                                                if (moment(data.start_date).format('HH:mm:ss') !== '00:00:00') {
                                                    $('#start_time').val(start_time);
                                                } else {
                                                    $('#start_time').val('');
                                                }
                                                $('#due_date').val(due_date);
                                                $('#activity_user_id').val(data.assigned_to).trigger('change');

                                                $('#activity_organization_id').val(data.organization_id).trigger('change');
                                                activity_order_id = data.order_id;
                                                activity_contact_id = data.contact_id;

                                                $('#submit_btn_text').html('Update');
                                                $('#new_activity_form_title').html('Edit Meeting');
                                                $('#is_done_div').removeAttr('hidden');
                                                $('#add_activity_form').attr('action', '{{ route("activities.updateMeeting") }}');

                                                $('#open_from_calendar').val('Calendar');

                                                var assignedUserName = '';
                                                var modifiedUserName = '';

                                                var all_users = @json($users);
                                                var auth_user = @json(auth()->user()->id);

                                                if (data.created_by !== null) {
                                                    var assignedUser = all_users.find(user => user.id == data.created_by);
                                                } else {
                                                    var assignedUser = all_users.find(user => user.id == data.assigned_to);
                                                }
                                                if (assignedUser) {
                                                    if (assignedUser.id == auth_user) {
                                                        assignedUserName = assignedUser.name + ' (You)'
                                                    } else {
                                                        assignedUserName = assignedUser.name
                                                    }
                                                } else {
                                                    assignedUserName = '';
                                                }
                                                if (data.modified_by !== null) {
                                                    var modifiedUser = all_users.find(user => user.id == data.modified_by);
                                                    if (modifiedUser) {
                                                        if (modifiedUser.id == auth_user) {
                                                            modifiedUserName = modifiedUser.name + ' (You)'
                                                        } else {
                                                            modifiedUserName = modifiedUser.name
                                                        }
                                                    } else {
                                                        modifiedUserName = '';
                                                    }
                                                }

                                                $('#created_at_tr').html(`<td style="color: grey;padding-top: .5rem;">Created : ${formatDate(data.created_at)}  ${assignedUserName} </td>`);
                                                $('#modified_at_tr').html(`<td style="color: grey;">Last Modified : ${formatDate(data.updated_at)}  ${modifiedUserName} </td>`);

                                            },
                                            complete: function() {
                                                // Show modal after all data is fetched and set
                                                $('#activity_modal_new').modal('show');
                                                $(".se-pre-con").fadeOut('slow');
                                            }
                                        });
                                        if (openedByPlusButton) {
                                            $('#activity_organization_id').removeAttr('required');
                                            openedByPlusButton = false; // reset the flag
                                        }

                                    }
                                });
                            });
                        }
                    });
                    calendarMeeting.render();
                }
            });


            function openModalWithStartDate(startDate) {
                $.ajax({
                    url: "{{ url('activities/get_organizations') }}",
                    method: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                        var organizations = data;

                        var today_day = moment().format('dddd, MMMM Do');
                        var today_date = moment().format('L').replace(/\//g, '-');

                        $('#selected_day').val(today_day);
                        $('#selected_date').val(moment().format('L'));

                        getMeetingsByDate(today_date);

                        $('#activity_subject').val('');
                        $('.ql-editor').html('');
                        $('#activity_note').val('');
                        $('#start_date').val(startDate);
                        $('#activity_priority').val(0).trigger('change');
                        $('#start_time').val('');
                        $('#is_done').prop('checked', false);

                        $('.activity-type-label').removeClass('active');
                        $('#activity_call').addClass('active');
                        $('.activity-type').prop('checked', false);
                        $('#activity_call .activity-type').prop('checked', true);

                        $('#submit_btn_text').html('Save');
                        $('#new_activity_form_title').html('Add Meeting');
                        $('#is_done_div').prop('hidden', true);
                        $('#add_activity_form').attr('action', '{{ route("activities.createMeeting") }}');

                        var org_options = '<option value="">Select an Organization</option>';
                        for (let i = 0; i < organizations.length; i++) {
                            org_options += '<option value="' + organizations[i].id + '">' + organizations[i].organization_name + '</option>';
                        }
                        $('#activity_organization_id').html(org_options);

                        $('#created_at_tr').html('');
                        $('#modified_at_tr').html('');
                        $('#open_from_calendar').val('Calendar');
                    },
                    complete: function () {
                        $('#activity_modal_new').modal('show');
                        $(".se-pre-con").fadeOut('slow');
                    }
                });

                if (openedByPlusButton) {
                    $('#activity_organization_id').removeAttr('required');
                    openedByPlusButton = false; // reset the flag
                }
            }



            // End  Meeting calendar

        });

        function getMeetingsByDate(due_date) {
            var user_id = $('#loggedin_user_id').val();
            var activityListTDElements = document.querySelectorAll('[id^="activity_list_"]');

            // Loop through each selected <td> element and set its inner HTML to an empty string
            activityListTDElements.forEach(function(td) {
            td.innerHTML = '';
            });

            $.ajax({
                url: '{{ url("meetings/get_meetings_by_date") }}/'+user_id+'/'+due_date,
                type: "GET",
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    var activity_list = [];
                    // console.log(data);
                    for (let i = 0; i < data.length; i++) {
                        var startHour = parseInt(data[i].start_date.split(' ')[1].split(':')[0]);

                        var activity_list = '<button type="button" class="btn btn-sm activity-list-btn random-button mt-1" value="'+data[i].id+'"><span style="color: red;">Meeting</span><br>'+data[i].activity_subject+'</button>';
                        var timeSlotId = '#activity_list_' + startHour;
                        // console.log(timeSlotId);
                        $(timeSlotId).append(activity_list);
                    }
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });

        }



    </script>

        <script>

            $(document).ready(function(){
                $(".se-pre-con").fadeOut('slow');
            });


            $(document).ready(function() {

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

                $('#search_input_text').on('input', function() {

                    var input_text = $(this).val();

                    if(input_text != '' && input_text.length > 2){
                        $.ajax({
                            url: '{{ url("repDashboard/filter_search_data") }}',
                            type: "GET",
                            dataType: 'json',
                            data: {
                                'input_text': input_text, '_token':'{{csrf_token()}}'
                            },
                            beforeSend: function () {
                                $(".se-pre-con").fadeIn('slow');
                            },
                            success: function (data) {
                                var persons = @json($all_persons);
                                var organizations = @json($all_organizations);
// console.log(data);
                                var activity_content = '';

                                if(data[0].length > 0){
                                    data[0].forEach(element => {

                                        var activity_org = organizations.find(organization => organization.id == element.organization_id);
                                        var orgName = (activity_org) ? activity_org.organization_name + ', ' : '';

                                        var act_person = persons.find(person => person.id == element.contact_id);

                                        var personName = (act_person) ? ((act_person.first_name ? act_person.first_name : '') + ' ' + (act_person.last_name ? act_person.last_name : '')) : '';

                                        activity_content +=
                                                            `<li class="list-group-item d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fas fa-tasks fa-lg mr-3" style="color: black;"></i>
                                                                    <div>
                                                                        <a href="#" class="mb-1 heading-link activity-edit" data-activiy_id="${element.id}"  style="font-size: 1rem;color: black;font-weight: 500;">${element.activity_subject}</a><br>
                                                                        <small>${orgName} ${personName}</small>
                                                                    </div>
                                                                </div>
                                                            </li>`;
                                    });
                                }else{
                                    var activity_content = `<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                                <div class="text-center mt-8">
                                                                    <div class="spinner-border" role="status">
                                                                        <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;No result found...</span>
                                                                    </div>
                                                                </div>
                                                            </div>`;
                                }
                                var org_content = '';
                                if(data[1].length > 0){
                                    data[1].forEach(element => {
                                        var organizationId = element.id;
                                        var route = '{{ route('organizations.info', ['id' => ':id']) }}';
                                        var url = route.replace(':id', organizationId);

                                        var org_shipping_street = (element.shipping_street) ? element.shipping_street + ', ' : '';
                                        var org_shipping_city = (element.shipping_city) ? element.shipping_city + ', ' : '';
                                        var org_shipping_state = (element.shipping_state) ? element.shipping_state + ', ' : '';
                                        var org_shipping_postal_code = (element.shipping_postal_code) ? element.shipping_postal_code + ', ' : '';
                                        var org_shipping_country = (element.shipping_country) ? element.shipping_country : '';

                                        var full_address =  org_shipping_street + org_shipping_city + org_shipping_state + org_shipping_postal_code + org_shipping_country;

                                        if(full_address.length > 60){
                                            full_address = full_address.substring(0, 60) + '...';
                                        }

                                        var org_website = (element.website) ? element.website + ', ' : '';

                                        if(org_website.length > 60){
                                            org_website = org_website.substring(0, 60) + '...';
                                        }

                                        var org_email = (element.email) ? element.email : '';

                                        var line1 = (full_address) ? `<small>${full_address}</small><br>` : '';
                                        var line2 = (org_website || org_email) ? `<small>${org_website} ${org_email}</small>` : '';


                                        org_content +=
                                                        `<li class="list-group-item d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-building fa-lg mr-3" style="color: black;"></i>
                                                                <div>
                                                                    <a href="${url}" target="blank" class="mb-1 heading-link" style="font-size: 1rem;color: black;font-weight: 500;">${element.organization_name}</a><br>
                                                                    ${line1}
                                                                    ${line2}
                                                                </div>
                                                            </div>
                                                        </li>`;
                                    });
                                }else{
                                    var org_content = `<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                                <div class="text-center mt-8">
                                                                    <div class="spinner-border" role="status">
                                                                        <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;No result found...</span>
                                                                    </div>
                                                                </div>
                                                            </div>`;
                                }
                                var people_content = '';
                                if(data[2].length > 0){
                                    data[2].forEach(element => {
                                        var peopleId = element.id;
                                        var route = '{{ route('people.info', ['id' => ':id']) }}';
                                        var url = route.replace(':id', peopleId);

                                        var person_name = (element.first_name ? element.first_name : '') + ' ' + (element.last_name ? element.last_name : '')

                                        var person_email = (element.email ? element.email : '')

                                        var people_shipping_street = (element.shipping_street) ? element.shipping_street + ', ' : '';
                                        var people_shipping_city = (element.shipping_city) ? element.shipping_city + ', ' : '';
                                        var people_shipping_state = (element.shipping_state) ? element.shipping_state + ', ' : '';
                                        var people_shipping_zip = (element.shipping_zip) ? element.shipping_zip + ', ' : '';
                                        var people_shipping_country = (element.shipping_country) ? element.shipping_country : '';

                                        var full_address =  people_shipping_street + people_shipping_city + people_shipping_state + people_shipping_zip + people_shipping_country;

                                        if(full_address.length > 60){
                                            full_address = full_address.substring(0, 60) + '...';
                                        }

                                        var line1 = (full_address) ? `<small>${full_address}</small><br>` : '';
                                        var line2 = (person_email) ? `<small>${person_email}</small>` : '';

                                        people_content +=
                                                        `<li class="list-group-item d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-user fa-lg mr-3" style="color: black;"></i>
                                                                <div>
                                                                    <a href="${url}" target="blank" class="mb-1 heading-link" style="font-size: 1rem;color: black;font-weight: 500;">${person_name}</a><br>
                                                                    ${line1}
                                                                    ${line2}
                                                                </div>
                                                            </div>
                                                        </li>`;
                                    });
                                }else{
                                    var people_content = `<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                                <div class="text-center mt-8">
                                                                    <div class="spinner-border" role="status">
                                                                        <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;No result found...</span>
                                                                    </div>
                                                                </div>
                                                            </div>`;
                                }
                                var order_content = '';
                                if(data[3].length > 0){
                                    data[3].forEach(element => {
                                        // var peopleId = element.id;
                                        // var route = '{{ route('people.info', ['id' => ':id']) }}';
                                        // var url = route.replace(':id', peopleId);

                                        // var person_name = (element.first_name ? element.first_name : '') + ' ' + (element.last_name ? element.last_name : '')

                                        // var person_email = (element.email ? element.email : '')

                                        // var people_shipping_street = (element.shipping_street) ? element.shipping_street + ', ' : '';
                                        // var people_shipping_city = (element.shipping_city) ? element.shipping_city + ', ' : '';
                                        // var people_shipping_state = (element.shipping_state) ? element.shipping_state + ', ' : '';
                                        // var people_shipping_zip = (element.shipping_zip) ? element.shipping_zip + ', ' : '';
                                        // var people_shipping_country = (element.shipping_country) ? element.shipping_country : '';

                                        // var full_address =  people_shipping_street + people_shipping_city + people_shipping_state + people_shipping_zip + people_shipping_country;

                                        // if(full_address.length > 60){
                                        //     full_address = full_address.substring(0, 60) + '...';
                                        // }

                                        var orderNo = element.order_no;
                                        var organization = element.organization_details.organization_name


                                        var line1 = (orderNo) ? `<small>${orderNo}</small><br>` : '';
                                        var line2 = (organization) ? `<small>${organization}</small>` : '';

                                        order_content +=
                                                        `<li class="list-group-item d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-user fa-lg mr-3" style="color: black;"></i>
                                                                <div>
                                                                    <a href="#" class="edit-order" data-value="${element.id}" style="font-size: 1rem;color: black;font-weight: 500;">${orderNo}</a><br>
                                                                    ${line1}
                                                                    ${line2}
                                                                </div>
                                                            </div>
                                                        </li>`;
                                    });
                                }else{
                                    var order_content = `<div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                                <div class="text-center mt-8">
                                                                    <div class="spinner-border" role="status">
                                                                        <span><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>&nbsp;&nbsp;No result found...</span>
                                                                    </div>
                                                                </div>
                                                            </div>`;
                                }


                                var highlighted_activity_content = highlightSearchText(activity_content, data[4]);
                                $('#activities-list-ul').html(highlighted_activity_content);

                                var highlighted_people_content = highlightSearchText(people_content, data[4]);
                                $('#peoples-list-ul').html(highlighted_people_content);

                                var highlighted_org_content = highlightSearchText(org_content, data[4]);
                                $('#organization-list-ul').html(highlighted_org_content);

                                var highlighted_order_content = highlightSearchText(order_content, data[4]);
                                $('#orders-list-ul').html(highlighted_order_content);

                                if (data[0].length == 0) {
                                    if (data[1].length == 0) {
                                        if (data[2].length == 0) {
                                            $('#all-list-ul').html(highlighted_order_content);
                                        } else if (data[3].length == 0) {
                                            $('#all-list-ul').html(highlighted_people_content);
                                        } else {
                                            $('#all-list-ul').html(highlighted_people_content + highlighted_order_content);
                                        }
                                    } else if (data[2].length == 0) {
                                        if (data[3].length == 0) {
                                            $('#all-list-ul').html(highlighted_org_content);
                                        } else {
                                            $('#all-list-ul').html(highlighted_org_content + highlighted_order_content);
                                        }
                                    } else if (data[3].length == 0) {
                                        $('#all-list-ul').html(highlighted_org_content + highlighted_people_content);
                                    } else {
                                        $('#all-list-ul').html(highlighted_org_content + highlighted_people_content + highlighted_order_content);
                                    }
                                } else if (data[1].length == 0) {
                                    if (data[2].length == 0) {
                                        if (data[3].length == 0) {
                                            $('#all-list-ul').html(highlighted_activity_content);
                                        } else {
                                            $('#all-list-ul').html(highlighted_activity_content + highlighted_order_content);
                                        }
                                    } else if (data[3].length == 0) {
                                        $('#all-list-ul').html(highlighted_people_content + highlighted_activity_content);
                                    } else {
                                        $('#all-list-ul').html(highlighted_people_content + highlighted_activity_content + highlighted_order_content);
                                    }
                                } else if (data[2].length == 0) {
                                    if (data[3].length == 0) {
                                        $('#all-list-ul').html(highlighted_activity_content);
                                    } else {
                                        $('#all-list-ul').html(highlighted_org_content + highlighted_activity_content + highlighted_order_content);
                                    }
                                } else if (data[3].length == 0) {
                                    $('#all-list-ul').html(highlighted_org_content + highlighted_people_content + highlighted_activity_content);
                                } else {
                                    $('#all-list-ul').html(highlighted_org_content + highlighted_people_content + highlighted_activity_content + highlighted_order_content);
                                }

                            },
                            complete: function () {
                                $(".se-pre-con").fadeOut('slow');
                            }
                        });
                    }



                });
                });
                function highlightSearchText(content, searchText) {
                var escapedSearchText = searchText.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                // Regular expression to exclude matches within attribute values
                var regex = new RegExp(`(?!<a[^>]*?>)(?![^<]*?(?:"|'))(${escapedSearchText})(?![^<]*?<\/a>)`, 'gi');
                var highlightedContent = content.replace(regex, '<span class="highlight">$1</span>');
                return highlightedContent;
                }

                $("body").on("click", ".edit-order", function(){
                    // $(".se-pre-con").fadeIn('slow');
                    var orderId = $(this).data('value');
                    // window.location.replace('order_details/edit/'+orderId+'/order?active_tab=order');
                    window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
                });

        </script>

    {{-- email table --}}
    <script>

        var email = @json($email);
        console.log(email);

        var tableBody = document.getElementById('email_table_dashboard_salesRep');
        var emailTable = document.getElementById('email_dashboard_table');

        function truncateText(text, maxLength) {
            if (typeof text !== 'string') {
                if (text === null || text === undefined) {
                    return '';
                }

                return text;
            }
            if (text.length > maxLength) {
                return text.substring(0, maxLength) + '...';
            } else {
                return text;
            }
        }

        var hasFalseStatus = email.some(transaction => transaction.Status == false);

        if (hasFalseStatus) {
            email.forEach(transaction => {
                if (transaction.Status == false) {
                    var row = tableBody.insertRow();
                    row.classList.add('email_table_row');

                    var truncatedFrom = truncateText(transaction.From, 15);
                    var truncatedSubject = truncateText(transaction.Subject, 40);

                    var messageId = transaction.Message_ID;

                    row.innerHTML = `
                        <th style="width: 45px; border: unset; padding: 0.4rem;">
                            <a href="#" class="activity-edit" data-activiy_id="${transaction.id}"></th>
                        <th class="inbox_msg_row" data-message_id="${messageId}" style="width: 30%; border: unset; padding: 0.4rem;">
                            ${truncatedFrom}
                        </th>
                        <td class="inbox_msg_row" data-message_id="${messageId}" style="border: unset; padding: 0.4rem;" class="note_p">
                            ${truncatedSubject}
                        </td>
                    `;
                }
            });
        } else {
            document.getElementById('emailContainer').innerHTML = `
                <div class="email-message clear_inbox">
                    No new Emails. You're all set!
                </div>
            `;
        }


        $(document).on('click', '.inbox_msg_row', function() {
            var messageId = $(this).data('message_id');
            var mailbox_id = $('#mailboxId').val();
            console.log('works 1');

            window.open('emailLoadFromDashboard/' +messageId , '_blank');
        });

        $(document).on('click', '.clear_inbox', function() {
            var callbackMailUrl = "{{ route('indexemail') }}";

            window.open(callbackMailUrl, '_blank');
        });



    </script>
    {{-- End email table --}}

    {{-- Activities table  --}}
    <script>

        var activities = @json($activities);
        console.log(activities);

        var tableBody = document.getElementById('activity_table_dashboard_salesRep');

        // Function to truncate text
        function truncateText(text, maxLength) {
            if (typeof text !== 'string') {
                if (text === null || text === undefined) {
                    return '';
                }

                return text;
            }
            if (text.length > maxLength) {
                return text.substring(0, maxLength) + '...';
            } else {
                return text;
            }
        }

        activities.forEach(transaction => {
            var row = tableBody.insertRow();

            // Truncate activity_subject and activity_note
            var truncatedSubject = truncateText(transaction.activity_subject, 30);
            var truncatedNote = truncateText(transaction.activity_note, 25);
            var truncatedOrganization = truncateText(transaction.organization_details.organization_name, 25);

            row.innerHTML = `
            <th style="width: 45px; border: unset; padding: 0.4rem;"><a href="#" class="activity-edit" data-activiy_id="${transaction.id}"><i class="fa fa-eye"></i></a></th>
                <th style="width: 50%; border: unset; padding: 0.4rem;">
                    <a href="#" class="activity-edit" data-activiy_id="${transaction.id}">${truncatedSubject}</a>
                </th>
                <td style="border: unset; padding: 0.4rem;" class="note_p">
                    ${truncatedOrganization}
                </td>
            `;
        });

        function fetchDataFromController() {
            var userId = document.getElementById('selected_user_id').value;

            $.ajax({
                url: '{{ route('filterActivities') }}',
                method: 'GET',
                data: {
                    userId: userId
                },
                beforeSend: function () {

                },
                success: function (data) {
                    console.log(data);

                    if (!Array.isArray(data.activity)) {
                        return;
                    }

                    var activities = data.activity;
                    var tableBody = document.getElementById('activity_table_dashboard_salesRep');
                    tableBody.innerHTML = '';

                    function truncateText1(text, maxLength) {
                        if (typeof text !== 'string') {
                            if (text === null || text === undefined) {
                                return '';
                            }

                            return text;
                        }
                        if (text.length > maxLength) {
                            return text.substring(0, maxLength) + '...';
                        } else {
                            return text;
                        }
                    }

                    activities.forEach(transaction => {
                        var row = tableBody.insertRow();

                        var truncatedSubject = truncateText1(transaction.activity_subject, 30);
                        var truncatedNote = truncateText1(transaction.activity_note, 25);
                        var truncatedOrganization = truncateText(transaction.organization_details.organization_name, 25);

                        row.innerHTML = `
                            <th style="width: 45px; border: unset; padding: 0.4rem;"><a href="#" class="activity-edit" data-activiy_id="${transaction.id}"><i class="fa fa-eye"></i></a></th>
                            <th style="width: 50%; border: unset; padding: 0.4rem;">
                                <a href="#" class="activity-edit" data-activiy_id="${transaction.id}">${truncatedSubject}</a>
                            </th>
                            <td style="border: unset; padding: 0.4rem;" class="note_p">
                                ${truncatedOrganization}
                            </td>
                        `;
                    });

                },
                error: function (error) {
                    console.log('Error fetching data:', error);
                },
                complete: function() {

                }
            });
        }

        // Add change event listeners to select box
        document.getElementById('selected_user_id').addEventListener('change', fetchDataFromController);


        $(document).ready( function () {

                $('.date-picker').datepicker({
                    dateFormat: 'mm/dd/yy', // Date picker format
                    showAnim: 'slideDown',
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function(dateText) {
                        $(this).trigger('change');
                    }
                });

                var activityTable = $('#activity_table').DataTable({
                    colReorder: true,
                    stateSave: true,
                    "autoWidth": false,
                    "pageLength": 50,
                    "columnDefs": [
                        { "type": "date", "targets": 1 }
                    ],
                    "drawCallback": function(settings) {
                        // displayTable();
                    }
                });

                // save column order when move
                activityTable.on('column-reorder', function (e, settings, details) {
                    var column_reorder = $('#column_reorder').val();

                    if (column_reorder == 0) {
                        var column_order = '[0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]';

                    } else {
                        var columnStr = localStorage.getItem("DataTables_activity_table_/activities");
                        var columnObj = JSON.parse(columnStr);
                        var colReorder = new $.fn.dataTable.ColReorder( activityTable );
                        var curr = colReorder.fnOrder();
                        var column_order = JSON.stringify(curr);
                    }

                    console.log(column_order);

                    var interface_name = 'Activity';
                    var interface_id = 14;

                    $.ajax({
                        url: '{{ route("datatable.column_order") }}',
                        type: "POST",
                        data: {
                            'interface_name': interface_name, 'interface_id': interface_id, 'column_order':column_order, '_token':'{{csrf_token()}}'
                        },
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function(data) {
                            console.log(data);
                            $('#column_reorder').val(column_order);
                        },
                        complete: function () {
                            // displayTable();
                            $(".se-pre-con").fadeOut('slow');
                        }
                    });
                });

                var user_id = $('#loggedin_user_id').val();
                var filter = $('input:radio.activity-filter:checked').val();
                var from_date = '01-01-2000';
                var to_date = '01-01-2050';
                getActivities(user_id, filter, from_date, to_date);

                function getActivities(user_id, filter, from_date, to_date) {
                    console.log(user_id, filter, from_date, to_date);
                    $.ajax({
                        url: '{{ url("activities/get_activities") }}/'+user_id+'/'+filter+'/'+from_date+'/'+to_date,
                        type: "GET",
                        dataType: 'json',
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function (data) {
                            if (data[1] < 10) {
                                var activity_count = '0'+data[1];
                            } else {
                                var activity_count = data[1];
                            }
                            $('#activity_count').html(activity_count);

                            // makeTable(data[0]);
                            $('#search_input_text').val('');
                        },
                        complete: function () {
                            // displayTable();
                            $(".se-pre-con").fadeOut('slow');
                        }
                    });
                }



                $('#loggedin_user_id').on('change', function() {
                    var user_id = $(this).val();
                    var filter = $('.active .activity-filter').val();
                    var from_date = '01-01-2000';
                    var to_date = '01-01-2050';

                    getActivities(user_id, filter, from_date, to_date);
                });

                $('input:radio.activity-filter').on('change', function() {
                    var user_id = $('#loggedin_user_id').val();
                    var filter = $(this).val();
                    var from_date = '01-01-2000';
                    var to_date = '01-01-2050';

                    if (filter == 3) {
                        $('#select_date_range').modal('show');
                    } else {
                        getActivities(user_id, filter, from_date, to_date);
                    }
                });

                $('#activity_select_period').on('focus', function() {
                    $('#select_date_range').modal('show');
                });

                $('#filter_data').on('click', function() {
                    var user_id = $('#loggedin_user_id').val();
                    var filter = 3;
                    var from_date = '01-01-2000';
                    var to_date = '01-01-2050';

                    $('#select_date_range').modal('hide');

                    getActivities(user_id, filter, from_date, to_date);
                });

                $('body').on('click', '.activity-edit', function(e){
                    e.preventDefault();
                    var activity_id = $(this).data('activiy_id');
                    $('#activity_delete_button').show();
console.log(activity_id);
                    $.ajax({
                        url:"{{ url('activities/get_organizations') }}",
                        method:'GET',
                        dataType:'json',
                        beforeSend: function () {
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function (data){
                            var organizations = data;

                            var org_options = '<option value="">Select an Organization</option>';
                            for (let i = 0; i < organizations.length; i++) {
                                org_options += '<option value="'+organizations[i].id+'">'+organizations[i].organization_name+'</option>';
                            }
                            $('#activity_organization_id').html(org_options);
                        },
                        complete: function () {
                            $.ajax({
                                url:"{{ url('activities/get_activity_by_id') }}/"+activity_id,
                                method:'GET',
                                dataType:'json',
                                success: function (data){
                                    console.log(data);
                                    var start_date = moment(data.start_date).format('L');
                                    var start_time = moment(data.start_date).format('LT');
                                    var due_date = moment(data.due_date).format('L');

                                    var today_day = moment().format('dddd, MMMM Do');
                                    var today_date = moment().format('L');
                                    $('#selected_day').html(today_day);
                                    $('#selected_date').val(today_date);

                                    var today_date = today_date.replace(/\//g, '-');
                                    getActivitiesByDate(today_date);

                                    $('#activity_note').val('');
                                    $('#activity_order_id').val('').trigger('change');
                                    $('#activity_organization_id').val('').trigger('change');
                                    $('#activity_contact_id').val('').trigger('change');

                                    $('#activity_id').val(activity_id);
                                    $('#activity_subject').val(data.activity_subject);
                                    $('#activity_note').val(data.activity_note);
                                    quill.clipboard.dangerouslyPasteHTML(data.activity_note);
                                    $('#activity_priority').val(data.priority).trigger('change');
                                    $('#start_date').val(start_date);
                                    if(moment(data.start_date).format('HH:mm:ss') !== '00:00:00'){
                                        $('#start_time').val(start_time);
                                    }else{
                                        $('#start_time').val('');
                                    }
                                    $('#due_date').val(due_date);
                                    $('#activity_user_id').val(data.assigned_to).trigger('change');

                                    $('#activity_organization_id').val(data.organization_id).trigger('change');
                                    activity_order_id = data.order_id;
                                    activity_contact_id = data.contact_id;

                                    $('#submit_btn_text').html('Update');
                                    $('#new_activity_form_title').html('Edit Activity');
                                    $('#is_done_div').removeAttr('hidden');
                                    $('#add_activity_form').attr('action', '{{ route("activities.update") }}');


                                    var assignedUserName = '';
                                    var modifiedUserName = '';


                                    var all_users = @json($users);
                                    var auth_user = @json(auth()->user()->id);

                                    if(data.created_by !== null){
                                        var assignedUser = all_users.find(user => user.id == data.created_by);
                                    }else{
                                        var assignedUser = all_users.find(user => user.id == data.assigned_to);
                                    }
                                    if(assignedUser){
                                        if(assignedUser.id == auth_user){
                                            assignedUserName = assignedUser.name + ' (You)'
                                        }else{
                                            assignedUserName = assignedUser.name
                                        }
                                    }else{
                                        assignedUserName = '';
                                    }
                                    if(data.modified_by !== null){
                                        var modifiedUser = all_users.find(user => user.id == data.modified_by);
                                        if(modifiedUser){
                                            if(modifiedUser.id == auth_user){
                                                modifiedUserName = modifiedUser.name + ' (You)'
                                            }else{
                                                modifiedUserName = modifiedUser.name
                                            }
                                        }else{
                                            modifiedUserName = '';
                                        }
                                    }

                                    $('#created_at_tr').html(`<td style="color: grey;padding-top: .5rem;">Created : ${formatDate(data.created_at)}  ${assignedUserName} </td>`);
                                    $('#modified_at_tr').html(`<td style="color: grey;">Last Modified : ${formatDate(data.updated_at)}  ${modifiedUserName} </td>`);

                                },
                                complete: function () {
                                    // $('#activity_popup').show(700);
                                    $('#activity_modal_new').modal('show');
                                    $(".se-pre-con").fadeOut('slow');
                                }
                            });

                        }
                    });


                });

                $('body').on('click', '.activity-chechbox', function() {
                    var activity_array = [];
                    $('.activity-chechbox:checked').each(function () {
                        activity_array.push($(this).val());
                    });

                    if (activity_array.length > 0) {
                        $('#mark_as_done_activites').val(activity_array);
                        $('#mark_to_delete_activites').val(activity_array);
                        $('.activity-top-controls').show(700);
                    } else {
                        $('#mark_as_done_activites').val('');
                        $('#mark_to_delete_activites').val('');
                        $('.activity-top-controls').hide(700);
                    }
                });
            });

            function formatDate(dateString) {
                // Create a new Date object from the dateString
                var date = new Date(dateString);

                // Extract the day, month, and year
                var day = String(date.getDate()).padStart(2, '0');
                var month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
                var year = date.getFullYear();

                // Format the date as DD/MM/YYYY
                return `${day}/${month}/${year}`;
            }


    </script>
    {{--End Activities table  --}}

    {{-- orders table --}}
    <script>


        var ordersPerPage = 10;
        var currentPage = 1;
        var maxPaginationLinks = 10;

        function updatePaginationSettings() {
            if (window.innerWidth <= 767.98) {
                ordersPerPage = 5;
                maxPaginationLinks = 5;
            } else {
                ordersPerPage = 10;
                maxPaginationLinks = 10;
            }
        }

        updatePaginationSettings();

        var urgentOrders = @json($urgentOrders);

        console.log('ordersPerPage', ordersPerPage);
        console.log('maxPaginationLinks', maxPaginationLinks);

        function renderUrgentTable(data, labelText = 'Your Orders') {
            var tableBody = document.getElementById('orders_body');
            tableBody.innerHTML = '';
            console.log(data);
            data.forEach(transaction => {
                var row = tableBody.insertRow();

                var orderType;

                if (transaction.is_urgent == 1){
                    orderType = 'Urgent Order';
                } else if (transaction.order_type == 0 && transaction.is_reordered == 0) {
                    orderType = 'Bulk New Order';
                } else if (transaction.order_type == 1 && transaction.is_reordered == 0) {
                    orderType = 'TS Order';
                } else if (transaction.is_reordered == 1) {
                    orderType = 'Reorder';
                } else {
                    orderType = 'New Order';
                }

                var exFactoryDate = transaction.ex_factory_date ? transaction.ex_factory_date : '';

                var inHandDueDate = transaction.due_date ? transaction.due_date : '';

                var totalQty = transaction.order_items.reduce((sum, item) => sum + Number(item.qty), 0);

                var uniqueFactories = Array.from(new Set(transaction.order_items.map(item => item.factory_details?.factory_code ?? '')));
                var factories = uniqueFactories.filter(code => code !== '').join(', ');

                var truncatedOrderDescription = truncateText(transaction.order_description, 40);

                var testPrintNeeded = transaction.order_items.some(item => item.test_print_needed == 1) &&
                            transaction.order_items.every(item => item.test_print_needed == 0 || item.test_print_needed == 1)
                            ? 'Yes'
                            : 'No';

                var formattedNearestTestPrintDueDate = null;

                if (testPrintNeeded === 'Yes') {
                    orderItem = transaction.order_items;
                    let currentDate = new Date().getTime(); // Current date in milliseconds
                    let nearestDate = Infinity; // Initialize nearestDate to a large value

                    orderItem.forEach(transactions => {
                        let testPrintDueDate = new Date(transactions.test_print_due_date).getTime();
                        if (!isNaN(testPrintDueDate)) { // Check if the date is valid
                            let diff = Math.abs(testPrintDueDate - currentDate);
                            if (diff < nearestDate) {
                                nearestDate = diff;
                                formattedNearestTestPrintDueDate = transactions.test_print_due_date;
                            }
                        }
                    });

                    // If no valid date was found, set formattedNearestTestPrintDueDate to an empty string
                    if (nearestDate === Infinity) {
                        formattedNearestTestPrintDueDate = '';
                    }
                } else {
                    formattedNearestTestPrintDueDate = '';
                }


// console.log(totalQty);
                row.innerHTML = `
                    <td style="padding: 0.4rem;" class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.id}">${transaction.order_no}</a></td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${transaction.organization_details.organization_name}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${factories}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${truncatedOrderDescription}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${exFactoryDate}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${inHandDueDate}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${formattedNearestTestPrintDueDate}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${totalQty}</td>
                `;
            });

            var urgentOrderLabel = document.getElementById('order_topic');
            urgentOrderLabel.innerHTML = labelText;

            setupPaginationUrgent(data);
        }

        // Initial call with the default label text
        renderUrgentTable(urgentOrders);

        document.getElementById('new_orders').addEventListener('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('newOrdersRepDashboard') }}',
                method: 'GET',
                data: {},
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    // console.log(data);
                    urgentOrders = data.urgentOrders; // Update the global orders variable
                    currentPage = 1; // Reset to the first page
                    renderUrgentTable(urgentOrders, 'Your Orders');
                },
                error: function (error) {
                    console.log('Error fetching data:', error);
                },
                complete: function () {
                    // Hide loader if needed
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });


        document.getElementById('production_orders').addEventListener('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('productionOrdersRepDashboard') }}',
                method: 'GET',
                data: {},
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    // console.log(data);
                    urgentOrders = data.productionOrders; // Update the global orders variable
                    currentPage = 1; // Reset to the first page
                    renderUrgentTable(urgentOrders, 'Production Orders');
                },
                error: function (error) {
                    console.log('Error fetching data:', error);
                },
                complete: function () {
                    // Hide loader if needed
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        document.getElementById('fulfilled_orders').addEventListener('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('fulfiledOrdersRepDashboard') }}',
                method: 'GET',
                data: {},
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    // console.log(data);
                    urgentOrders = data.fulfiledOrders; // Update the global orders variable
                    currentPage = 1; // Reset to the first page
                    renderUrgentTable(urgentOrders, 'Fulfilled Orders');
                },
                error: function (error) {
                    console.log('Error fetching data:', error);
                },
                complete: function () {
                    // Hide loader if needed
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        document.getElementById('pending_shipment').addEventListener('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '{{ route('PendingShipOrdersRepDashboard') }}',
                method: 'GET',
                data: {},
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    console.log(data);
                    urgentOrders = data.commonOrdersArray; // Update the global orders variable
                    currentPage = 1; // Reset to the first page
                    renderUrgentTable(urgentOrders, 'Pending Shipment Orders');
                },
                error: function (error) {
                    console.log('Error fetching data:', error);
                },
                complete: function () {
                    // Hide loader if needed
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        function setupPaginationUrgent(data) {

            var totalPages = Math.ceil(data.length / ordersPerPage);

            console.log('Total Records:', data.length);
            console.log('Orders Per Page:', ordersPerPage);
            console.log('Total Pages:', totalPages);

            var paginationBar = $('#paginationbarUrgent');

            if (totalPages <= 1) {
                paginationBar.empty();

                showPageUrgent(1, data);

                return;
            }

            function renderPagination() {

                var pagination = `
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                `;

                // Previous
                pagination += `
                    <li class="page-item">
                        <a class="page-link"
                        href="#"
                        data-page="prev"
                        style="border-radius:unset;background-color:transparent;border:unset;">
                            &laquo;
                        </a>
                    </li>
                `;

                var startPagination = 1;
                var endPagination = Math.min(maxPaginationLinks, totalPages);

                if (totalPages > maxPaginationLinks) {

                    startPagination =
                        currentPage - Math.floor(maxPaginationLinks / 2);

                    endPagination =
                        currentPage + Math.ceil(maxPaginationLinks / 2) - 1;

                    if (startPagination < 1) {
                        startPagination = 1;
                        endPagination = maxPaginationLinks;
                    }

                    if (endPagination > totalPages) {
                        endPagination = totalPages;
                        startPagination =
                            Math.max(1, totalPages - maxPaginationLinks + 1);
                    }
                }

                // Page numbers
                for (var i = startPagination; i <= endPagination; i++) {

                    pagination += `
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link"
                            href="#"
                            data-page="${i}"
                            style="border-radius:unset;background-color:transparent;border:unset;">
                                ${i}
                            </a>
                        </li>
                    `;
                }

                // Next
                pagination += `
                    <li class="page-item">
                        <a class="page-link"
                        href="#"
                        data-page="next"
                        style="border-radius:unset;background-color:transparent;border:unset;">
                            &raquo;
                        </a>
                    </li>
                `;

                pagination += `
                        </ul>
                    </nav>
                `;

                paginationBar.html(pagination);
            }

            // First render
            renderPagination();

            // Show current page
            showPageUrgent(currentPage, data);

            /*
            * Important:
            * Remove previous click event before adding new one.
            */
            paginationBar.off('click', '.page-link');

            paginationBar.on('click', '.page-link', function(e) {

                e.preventDefault();

                var page = $(this).data('page');

                if (page === 'prev') {

                    currentPage = Math.max(1, currentPage - 1);

                } else if (page === 'next') {

                    currentPage = Math.min(totalPages, currentPage + 1);

                } else {

                    currentPage = parseInt(page);
                }

                renderPagination();

                showPageUrgent(currentPage, data);
            });
        }

        // function showPageUrgent(pageNum, data) {
        //     var startIndex = (pageNum - 1) * ordersPerPage;
        //     var endIndex = startIndex + ordersPerPage;

        //     // Hide all rows
        //     $('#orders_body tr').hide();

        //     // Show only the relevant rows
        //     $('#orders_body tr').slice(startIndex, endIndex).show();

        //     // Update active page in pagination bar
        //     $('#paginationbarUrgent .page-item').removeClass('active');
        //     $('#paginationbarUrgent .page-link[data-page="' + pageNum + '"]').parent().addClass('active');
        // }

        function showPageUrgent(pageNum, data) {

            var startIndex = (pageNum - 1) * ordersPerPage;
            var endIndex = startIndex + ordersPerPage;

            var rows = $('#orders_body tr');

            rows.each(function(index) {

                if (index >= startIndex && index < endIndex) {

                    $(this)
                        .removeClass('mobile-order-hidden')
                        .addClass('mobile-order-visible');

                } else {

                    $(this)
                        .removeClass('mobile-order-visible')
                        .addClass('mobile-order-hidden');
                }
            });

            // Active page
            $('#paginationbarUrgent .page-item')
                .removeClass('active');

            $('#paginationbarUrgent .page-link[data-page="' + pageNum + '"]')
                .parent()
                .addClass('active');
        }

        $(document).ready(function(){
            $(".se-pre-con").fadeOut('slow');
        });

        var lastIsMobile = window.innerWidth <= 767.98;

        $(window).on('resize', function() {

            var isMobile = window.innerWidth <= 767.98;

            if (isMobile !== lastIsMobile) {

                lastIsMobile = isMobile;

                updatePaginationSettings();

                currentPage = 1;

                renderUrgentTable(urgentOrders);
            }
        });

    </script>
    {{-- END orders table --}}


    {{-- payment details table --}}
    <script>

        var ordersPerPage = 10;
        var maxPaginationLinks = 10;
        var currentPage = 1;

        function updatePaymentPaginationSettings() {
            if (window.innerWidth <= 767.98) {
                ordersPerPage = 5;
                maxPaginationLinks = 5;
            } else {
                ordersPerPage = 10;
                maxPaginationLinks = 10;
            }

            console.log('Screen Width:', window.innerWidth);
            console.log('ordersPerPage:', ordersPerPage);
            console.log('maxPaginationLinks:', maxPaginationLinks);
        }

        updatePaymentPaginationSettings();
        var TrasnsactionsArray = @json($TrasnsactionsArray);

        console.log(TrasnsactionsArray);

        function renderPaymentTable(data) {
            var tableBody = document.getElementById('payment_details');
            tableBody.innerHTML = '';

            // Custom sorting function
            data.sort((a, b) => {
                if (a.OrderStatus === 'Partial' && b.OrderStatus !== 'Partial') {
                    return -1;
                }
                if (a.OrderStatus === 'Pending' && b.OrderStatus !== 'Partial' && b.OrderStatus !== 'Pending') {
                    return -1;
                }
                return 0;
            });

            data.forEach(transaction => {
                var row = tableBody.insertRow();
                var amount = transaction.Amount ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.Amount) : "0.00";
                var subTotal = transaction.SubTotal ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.SubTotal) : "0.00";
                var shipping = transaction.Shipping ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.Shipping) : "0.00";
                var artWork = transaction.ArtWork ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.ArtWork) : "0.00";
                var salesTax = transaction.SalesTax ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.SalesTax) : "0.00";
                var processingFee = transaction.processingFee ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.processingFee) : "0.00";
                var balnceToBePaid = transaction.balnceToBePaid ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.balnceToBePaid) : "0.00";

                var paymentDate = new Date(transaction.PaymentDate);
                var formattedDate = paymentDate.toLocaleDateString('en-US', {
                    month: '2-digit',
                    day: '2-digit',
                    year: 'numeric'
                });

                var orderStatusBadge;
                if (transaction.OrderStatus === 'Paid') {
                    orderStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:90%">Paid</span>';
                } else if (transaction.OrderStatus === 'Partial') {
                    orderStatusBadge = '<span class="badge badge-pill" style="color:#023E8A;background-color:#D4E6FD; width:90%">Partial</span>';
                } else if (transaction.paymentStatus2 == 0 && transaction.PaymentType =='Check' || transaction.PaymentType =='Venmo') {
                    orderStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:90%">Approval Pending</span>';
                } else {
                    orderStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:90%">Pending</span>';
                }

                var checkFImageAttr = transaction.checkFImage ? `data-checkFImage="${transaction.checkFImage}"` : '';
                var checkBImageAttr = transaction.checkBImage ? `data-checkBImage="${transaction.checkBImage}"` : '';

                var transactionIDContent = transaction.TransactionID == '0' ? 'N/A' : transaction.TransactionID;

                var transactionIDAnchor = `
                    <a style="rgba(22, 22, 23, 1) !important"
                    data-orderNo="${transaction.Order}"
                    data-transactionType="${transaction.PaymentType}"
                    ${checkFImageAttr}
                    ${checkBImageAttr}
                    href="javascript:void(0)"
                    class="edit payID payIDFromSales"
                    data-value="${transaction.Order}">
                    ${transactionIDContent}
                    </a>
                `;

                var paymentRoute = "{{ route('payment') }}";

                var paymentLink = `
                    <a href="${paymentRoute}?orderId=${transaction.Order}&totalItemQty=${transaction.TotalQty}&sub_total=${subTotal}&salesTax=${salesTax}&shipping=${shipping}&artwork=${artWork}&processingFee=${processingFee}&orderTotal=${amount}&paymentStatus=${transaction.paymentStatus2}&balancePayment=${transaction.paymentStatus2 == 1 ? balnceToBePaid : ''}" target="_blank">${transaction.OrderNo}</a>
                `;

                row.innerHTML = `
                    <td style="padding: 0.4rem;" class="font_color row_padding">${transactionIDAnchor}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${paymentLink}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${transaction.PaymentType}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${transaction.TeamName}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${orderStatusBadge}</td>
                    <td style="padding: 0.4rem; text-align-last: right;" class="font_color row_padding">$ ${amount}</td>
                    <td style="padding: 0.4rem; padding-left: 10px;" class="font_color row_padding">${formattedDate}</td>
                `;
            });

            setupPaginationPayment(data);
        }

        // Initial call with the default label text
        renderPaymentTable(TrasnsactionsArray);

        function setupPaginationPayment(data) {

            var totalPages = Math.ceil(data.length / ordersPerPage);
            var paginationBar = document.getElementById('paginationbarPayment');

            if (totalPages <= 1) {
                paginationBar.innerHTML = '';
                showPagePayment(1, data);
                return;
            }

            function renderPagination() {

                var pagination = '<nav aria-label="Page navigation"><ul class="pagination">';

                pagination += `
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="prev">&laquo;</a>
                    </li>
                `;

                var startPagination = 1;
                var endPagination = Math.min(maxPaginationLinks, totalPages);

                if (totalPages > maxPaginationLinks) {

                    startPagination =
                        Math.max(
                            1,
                            currentPage - Math.floor(maxPaginationLinks / 2)
                        );

                    endPagination =
                        startPagination + maxPaginationLinks - 1;

                    if (endPagination > totalPages) {
                        endPagination = totalPages;
                        startPagination =
                            Math.max(1, endPagination - maxPaginationLinks + 1);
                    }
                }

                for (var i = startPagination; i <= endPagination; i++) {

                    pagination += `
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">
                                ${i}
                            </a>
                        </li>
                    `;
                }

                pagination += `
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="next">&raquo;</a>
                    </li>
                `;

                pagination += '</ul></nav>';

                paginationBar.innerHTML = pagination;
            }

            renderPagination();

            showPagePayment(currentPage, data);

            paginationBar.onclick = function(e) {

                var link = e.target.closest('.page-link');

                if (!link) {
                    return;
                }

                e.preventDefault();

                var page = link.getAttribute('data-page');

                if (page === 'prev') {

                    currentPage = Math.max(1, currentPage - 1);

                } else if (page === 'next') {

                    currentPage = Math.min(totalPages, currentPage + 1);

                } else {

                    currentPage = parseInt(page);
                }

                renderPagination();
                showPagePayment(currentPage, data);
            };
        }

        function showPagePayment(pageNum, data) {
            var startIndex = (pageNum - 1) * ordersPerPage;
            var endIndex = startIndex + ordersPerPage;

            var tableBody = document.getElementById('payment_details');
            tableBody.innerHTML = '';

            var paginatedData = data.slice(startIndex, endIndex);

            paginatedData.forEach(transaction => {
                var row = tableBody.insertRow();
                var amount = transaction.Amount ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.Amount) : "0.00";
                var subTotal = transaction.SubTotal ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.SubTotal) : "0.00";
                var shipping = transaction.Shipping ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.Shipping) : "0.00";
                var artWork = transaction.ArtWork ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.ArtWork) : "0.00";
                var salesTax = transaction.SalesTax ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.SalesTax) : "0.00";
                var processingFee = transaction.processingFee ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.processingFee) : "0.00";
                var balnceToBePaid = transaction.balnceToBePaid ? new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(transaction.balnceToBePaid) : "0.00";

                var paymentDate = new Date(transaction.PaymentDate);
                var formattedDate = paymentDate.toLocaleDateString('en-US', {
                    month: '2-digit',
                    day: '2-digit',
                    year: 'numeric'
                });

                var orderStatusBadge;
                if (transaction.OrderStatus === 'Paid') {
                    orderStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:90%">Paid</span>';
                } else if (transaction.OrderStatus === 'Partial') {
                    orderStatusBadge = '<span class="badge badge-pill" style="color:#023E8A;background-color:#D4E6FD; width:90%">Partial</span>';
                } else if (transaction.paymentStatus2 == 0 && transaction.PaymentType =='Check' || transaction.PaymentType =='Venmo') {
                    orderStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:90%">Approval Pending</span>';
                }else if (transaction.PaymentType =='PO' && transaction.checkStatus =='Pending Approval') {
                    orderStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:90%">Approval Pending</span>';
                }else if (transaction.PaymentType =='PO' && transaction.checkStatus =='Approved') {
                    orderStatusBadge = '<span class="badge badge-pill" style="color:#47D6B6;background-color:#d7ffcc;width:90%">Approved</span>';
                }else {
                    orderStatusBadge = '<span class="badge badge-pill" style="color:#FFB916;background-color:#FFF6CC;width:90%">Pending</span>';
                }

                var checkFImageAttr = transaction.checkFImage ? `data-checkFImage="${transaction.checkFImage}"` : '';
                var checkBImageAttr = transaction.checkBImage ? `data-checkBImage="${transaction.checkBImage}"` : '';

                var transactionIDContent = transaction.TransactionID == '0' ? 'N/A' : transaction.TransactionID;

                var transactionIDAnchor = `
                    <a style="rgba(22, 22, 23, 1) !important"
                    data-orderNo="${transaction.Order}"
                    data-transactionType="${transaction.PaymentType}"
                    ${checkFImageAttr}
                    ${checkBImageAttr}
                    href="javascript:void(0)"
                    class="edit payID payIDFromSales"
                    data-value="${transaction.Order}">
                    ${transactionIDContent}
                    </a>
                `;


                var paymentRoute = "{{ route('payment') }}";

                var paymentLink = `
                    <a href="${paymentRoute}?orderId=${transaction.Order}&totalItemQty=${transaction.TotalQty}&sub_total=${subTotal}&salesTax=${salesTax}&shipping=${shipping}&artwork=${artWork}&processingFee=${processingFee}&orderTotal=${amount}&paymentStatus=${transaction.paymentStatus2}&balancePayment=${transaction.paymentStatus2 == 1 ? balnceToBePaid : ''}" target="_blank">${transaction.OrderNo}</a>
                `;

                row.innerHTML = `
                    <td style="padding: 0.4rem;" class="font_color row_padding">${transactionIDAnchor}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${paymentLink}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${transaction.PaymentType}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${transaction.TeamName}</td>
                    <td style="padding: 0.4rem;" class="font_color row_padding">${orderStatusBadge}</td>
                    <td style="padding: 0.4rem; text-align-last: right;" class="font_color row_padding">$ ${amount}</td>
                    <td style="padding: 0.4rem; padding-left: 10px;" class="font_color row_padding">${formattedDate}</td>
                `;
            });

            // Update active page in pagination bar
            document.querySelectorAll('#paginationbarPayment .page-item').forEach(item => item.classList.remove('active'));
            document.querySelector('#paginationbarPayment .page-link[data-page="' + pageNum + '"]').parentElement.classList.add('active');
        }



        document.addEventListener('click', function(event) {
            if (event.target.closest('.payIDFromSales')) {
                var clickedElement = event.target.closest('.payIDFromSales');
                var paymentType = clickedElement.getAttribute('data-transactionType');
                var host = window.location.host;


                if (paymentType == "Check") {
                    var orderNo = clickedElement.getAttribute('data-orderNo');
                    var display_order_no = ('000000' + orderNo).slice(-6);

                    $("#modal_title_notification").text("Payment Checks");
                    var frontImage = clickedElement.getAttribute('data-checkfimage');
                    var backImage = clickedElement.getAttribute('data-checkbimage');
                    var check_images = `<a class='check-image' download='${display_order_no}-check-front.jpg' href='{{asset('uploads')}}/../${frontImage}' title='Check Front'><img src='{{asset('uploads')}}/../${frontImage}'></a>
                                        <a class='check-image' download='${display_order_no}-check-back.jpg' href='{{asset('uploads')}}/../${backImage}' title='Check Back'><img src='{{asset('uploads')}}/../${backImage}'></a>`;
                    $("#check_payment").removeClass('justify-content-center');
                    $("#check_payment").html(check_images);

                    var paymentUrl = `payment?orderId=${orderNo}`;

                    var modalFooter = `<button style='color:white;background-color:#d65a47' type='button' class='styled-button ml-auto' data-dismiss='modal'>Close</button>`;
                    $("#modal-footer").html(modalFooter);

                    $('#notification_modal').modal('show');
                } else if (paymentType == "Venmo") {
                    var orderNo = clickedElement.getAttribute('data-orderNo');
                    var display_order_no = ('000000' + orderNo).slice(-6);

                    $("#modal_title_notification").text("Payment Venmo");
                    var frontImage = clickedElement.getAttribute('data-checkfimage');
                    var check_images = `<a class='venmo-image' download='${display_order_no}-venmo.jpg' href='{{asset('uploads')}}/../${frontImage}' title='Venmo'><img src='{{asset('uploads')}}/../${frontImage}'></a>`;
                    $("#check_payment").addClass('justify-content-center');
                    $("#check_payment").html(check_images);

                    var paymentUrl = `payment?orderId=${orderNo}`;

                    var modalFooter = `<button style='color:white;background-color:#d65a47' type='button' class='styled-button ml-auto' data-dismiss='modal'>Close</button>`;
                    $("#modal-footer").html(modalFooter);

                    $('#notification_modal').modal('show');
                }else if (paymentType == "PO") {
                    var orderNo = clickedElement.getAttribute('data-orderNo');
                    var display_order_no = ('000000' + orderNo).slice(-6);

                    $("#modal_title_notification").text("Purchase order receipt");
                    var frontImage = clickedElement.getAttribute('data-checkfimage');
                    var check_images = `<a class='venmo-image' download='${display_order_no}-Purchase_order.jpg' href='{{asset('uploads')}}/../${frontImage}' title='Purchase_order'><img src='{{asset('uploads')}}/../${frontImage}'></a>`;
                    $("#check_payment").addClass('justify-content-center');
                    $("#check_payment").html(check_images);

                    var paymentUrl = `payment?orderId=${orderNo}`;

                    var modalFooter = `<button style='color:white;background-color:#d65a47' type='button' class='styled-button ml-auto' data-dismiss='modal'>Close</button>`;
                    $("#modal-footer").html(modalFooter);

                    $('#notification_modal').modal('show');
                }
            }
        });

        window.addEventListener('resize', function () {

            var isMobile = window.innerWidth <= 767.98;

            var newOrdersPerPage = isMobile ? 5 : 10;
            var newMaxPaginationLinks = isMobile ? 5 : 10;

            if (
                ordersPerPage !== newOrdersPerPage ||
                maxPaginationLinks !== newMaxPaginationLinks
            ) {

                ordersPerPage = newOrdersPerPage;
                maxPaginationLinks = newMaxPaginationLinks;

                currentPage = 1;

                renderPaymentTable(TrasnsactionsArray);
            }
        });

    </script>
    {{-- END payment details table --}}

@endsection
