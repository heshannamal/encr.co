@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Payment')])

@section('content')
<style>
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .form-field {
        display: flex;
        margin-bottom: 1rem;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
    }
    .form-lable {
        width: 12rem;
    }
    fieldset {
        min-width: 0px;
        margin: 0;
        padding: 1rem;
        border: 1px solid #e4e4e4;
    }
    legend {
        font-size: 0.8rem;
        font-weight: bold;
        line-height: inherit;
        display: block;
        width: 100%;
        max-width: 120px;
        margin-bottom: 0rem;
        padding: 0;
        white-space: normal;
        color: inherit;
        padding: .5rem;
    }
    .disclaimer {
        width: 100%;
        margin-bottom: 0rem;
        font-size: 14px;
        font-weight: bold;
    }
    .payment-status {
        font-size: 14px;
        color: #ffffff;
        text-align: center;
        padding: 0.1rem 1rem;
        width: 100px;
        text-transform: uppercase;
        float: right;
    }
    .uploaded-checks {
        width: 130px !important;
        height: 100px;
        overflow: hidden;
    }
    .uploaded-checks img {
        max-width: 100%;
        max-height: 100%;
    }
    .back-btn-div-position {
        padding: 0.5rem;
    }
    .btn-right {
        position: relative;
        right: 15px;
    }
    .back-btn-div {
        padding: 0.5rem;
        background-color: #787878;
        border-radius: 0.125rem;
        font-size: xx-small;
    }
    .content-div {
        position: relative;
        top: -20px;
    }
    .forPaymentStyles .nav-link2{
        background-color: white !important;
        color: grey !important;
        font-weight: 600 !important;
        border: none !important;
        border-bottom: 2px solid #b3b3b3 !important;
    }
    .forPaymentStyles .nav-link2.active, .forPaymentStyles .nav-link2:hover{
        background-color: white !important;
        color: black !important;
        font-weight: 600 !important;
        border: none !important;
        border-bottom: 2px solid black !important;
    }
    .border-style{
    border: 1px solid #DEDEDE !important;
    border-radius: 0rem !important;
    color: #717070 !important;
    }
    .forPaymentStyles .form-control{
        border: 1px solid #DEDEDE;
        border-radius: 0rem !important;
        color: #717070 !important;
        padding-left: 7px !important;
        font-size: 0.8rem !important;
        height: calc(1.5rem + 1px) !important;
        margin-bottom: 0rem !important;
    }
    .forPaymentStyles label {
        margin-bottom: 0rem ;
        color: black;
    }
    .header-style{
        color: black;
        font-size: 1.1rem;
        font-weight: 600;
    }
    .forPaymentStyles .form-label{
        margin-top: 0.5rem;
        color: black;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .sub-header-style{
        color: black;
        font-size: .8rem;
        margin-top: 1rem;
        font-weight: 600;
    }
    .disabled-style{
        background-color: #F8F8F8;
        border: none !important;
        line-height: 14px;
    }
    .forPaymentStyles .custom-file-input-label:hover{
        border: 2px dashed #b3b3b3 !important;
    }
    .paymentSummaryTable thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .paymentSummaryTable tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .paymentSummaryTable{
        width: 100%;
    }
    .paymentSummaryTable th, .paymentSummaryTable td {
        padding: 10px;
    }
    .btn-success:disabled {
    color: #fff;
    border-color: #787878;
    background-color: #787878;
    }

    .back_home_mobile {
        display: none !important;
    }

    @media (max-width: 768px){
        #orders_table_wrapper{
            display:none !important;
        }
        .desktop_filter {
            display:none !important;
        }
        .home-btn-color-mobile {
            color: #475569 !important;
            font-size: 11px;
        }
        .home-btn-color-mobile:hover {
            color: #777777 !important;
        }
        .back_home_mobile {
            padding-top: 15px;
            padding-left: 15px;
            display: block !important;
        }

    }



/* =========================================================
   MOBILE RESPONSIVE
   ========================================================= */

@media (max-width: 767.98px) {

    /* -----------------------------------------
       MAIN CARD
       ----------------------------------------- */

    .payment-method-header {
        width: auto !important;
        margin-left: 0 !important;
        margin-right: 0 !important;

        display: inline-block;
        vertical-align: middle;

        margin-top: 0.75rem !important;

        font-size: 16px;
        line-height: 1.4;
    }


    /* -----------------------------------------
       PAYMENT HISTORY BUTTON
       ----------------------------------------- */

    .payment-history-btn {
        position: absolute !important;

        right: 0;
        top: 0 !important;

        margin: 0 !important;
        padding: 5px 0 !important;

        font-size: 12px !important;
        font-weight: 600 !important;

        white-space: nowrap;

        color: #888 !important;
    }


    /* -----------------------------------------
       TAB CONTAINER
       ----------------------------------------- */

    .tab-container {
        width: 100% !important;

        padding: 0.75rem 0 !important;

        overflow: hidden;
    }


    /* -----------------------------------------
       TABS
       ----------------------------------------- */

    .tab-container > .nav-tabs {
        width: 100% !important;

        margin-left: 0 !important;
        margin-right: 0 !important;

        display: flex;

        flex-wrap: nowrap;

        overflow-x: auto;
        overflow-y: hidden;

        -webkit-overflow-scrolling: touch;

        scrollbar-width: none;
    }

    .tab-container > .nav-tabs::-webkit-scrollbar {
        display: none;
    }


    /* -----------------------------------------
       EACH TAB
       ----------------------------------------- */

    .tab-container .nav-tabs .nav-item {
        flex: 0 0 auto;
    }

    .tab-container .nav-tabs .nav-link {
        padding: 8px 14px !important;

        font-size: 12px !important;

        white-space: nowrap;
    }


    /* -----------------------------------------
       TAB CONTENT
       ----------------------------------------- */

    .tab-content {
        width: 100% !important;

        margin-top: 1rem !important;

        overflow: hidden;
    }


    .tab-pane2 {
        width: 100% !important;
    }


    /* -----------------------------------------
       PAYMENT HISTORY ROW
       ----------------------------------------- */

    .tab-pane2 > .row:first-child {
        height: auto !important;

        min-height: 0 !important;

        margin-left: 0 !important;
        margin-right: 0 !important;

        position: relative;

        top: 0;
        right: -18px;

        width: auto;
    }

    .tab-pane2 > .row:first-child .col-md-3 {
        width: auto !important;

        padding: 0 !important;

        margin-left: 0 !important;
    }


    /* -----------------------------------------
       CARD TAB
       ----------------------------------------- */

    #card-tab {
        min-height: 20rem !important;

        position: relative;
    }


    /* ==========================================
       PAYMENT METHOD HEADER
       ========================================== */

    .payment-method-header {
        width: 100% !important;

        margin: 12px 0 0 0 !important;

        height: 32px !important;

        line-height: 32px !important;

        position: relative !important;

        font-size: 16px !important;

        box-sizing: border-box !important;
    }


    /* ==========================================
       PAYMENT HISTORY
       ========================================== */

    .payment-history-btn {
        position: absolute !important;

        top: 0 !important;
        right: 15px !important;

        transform: none !important;

        margin: 0 !important;

        padding: 0 !important;

        height: 32px !important;

        line-height: 32px !important;

        font-size: 11px !important;

        font-weight: 600 !important;

        white-space: nowrap !important;

        color: #888 !important;

        z-index: 10;
    }


    /* ==========================================
       PAYMENT TABS
       ========================================== */

    .tab-container {
        width: 100% !important;

        padding: 10px 0 0 0 !important;

        overflow: hidden !important;
    }


    .tab-container > .nav-tabs {
        width: 100% !important;

        margin: 0 !important;

        display: flex !important;

        flex-wrap: nowrap !important;

        overflow-x: auto !important;
        overflow-y: hidden !important;

        -webkit-overflow-scrolling: touch;

        scrollbar-width: none;
    }


    .tab-container > .nav-tabs::-webkit-scrollbar {
        display: none;
    }


    .tab-container .nav-tabs .nav-item {
        flex: 0 0 auto !important;
    }


    .tab-container .nav-tabs .nav-link {
        padding: 8px 13px !important;

        font-size: 11px !important;

        white-space: nowrap !important;
    }
}
@media (max-width: 767.98px) {

    .tab-container > .nav-tabs {
        display: flex !important;

        flex-wrap: wrap !important;

        width: 100% !important;

        margin-left: 0 !important;
        margin-right: 0 !important;

        overflow: visible !important;

        row-gap: 5px !important;
    }

    .tab-container > .nav-tabs .nav-item {
        flex: 0 0 auto !important;
    }

    .tab-container > .nav-tabs .nav-link {
        padding: 8px 12px !important;

        font-size: 11px !important;

        white-space: nowrap !important;

        margin-right: 3px !important;
    }
    .forPaymentStyles {
        margin: unset;
        padding: unset;
    }
    .mobile_card_div {
        border-radius: 5px !important;
        padding: 10px !important;
    }
    .mobile_card_details {
        margin: unset !important;
        padding: unset !important;
    }
    .mobile_CVV {
        padding-left: 15px !important;
    }
    .mobile_payment_summery {
        min-height: 36rem !important;
        margin-left: 15px !important;
        margin-right: 15px !important;
    }
    .mobile_form_field {
        height: 85px !important;
    }
}

@media (max-width: 767.98px) {

    .payment-history-btn {
        position: relative !important;
        top: 0 !important;

        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

        min-height: 40px !important;
        padding: 9px 17px !important;

        /* Creative gradient */
        background: linear-gradient(to bottom right, #96d19c, #54d572, #b5dabc) !important;
        color: #ffffff !important;

        border: 1px solid rgba(255, 255, 255, 0.9) !important;
        border-radius: 50px !important;

        font-size: 11px !important;
        font-weight: 700 !important;
        letter-spacing: 0.8px !important;

        cursor: pointer !important;
        white-space: nowrap !important;

        box-shadow:
            0 5px 15px rgba(70, 80, 100, 0.12),
            inset 0 1px 0 rgba(255, 255, 255, 0.9) !important;

        transition: all 0.25s ease !important;

        outline: none !important;
    }


    /* Accent dot */
    .payment-history-btn::before {
        content: "" !important;

        width: 7px !important;
        height: 7px !important;

        margin-right: 8px !important;

        border-radius: 50% !important;

        background: linear-gradient(
            135deg,
            #667eea,
            #764ba2
        ) !important;

        box-shadow:
            0 0 0 3px rgba(102, 126, 234, 0.12) !important;

        transition: all 0.25s ease !important;
    }


    /* Hover */
    .payment-history-btn:hover {
        background: linear-gradient(
            135deg,
            #e9edf5 0%,
            #dfe5ef 50%,
            #f2f4f8 100%
        ) !important;

        color: #4d5664 !important;

        transform: translateY(-2px) !important;

        box-shadow:
            0 8px 20px rgba(70, 80, 100, 0.16),
            inset 0 1px 0 rgba(255, 255, 255, 0.95) !important;

        text-decoration: none !important;
    }


    .payment-history-btn:hover::before {
        transform: scale(1.25) !important;

        box-shadow:
            0 0 0 4px rgba(102, 126, 234, 0.15) !important;
    }


    /* Click */
    .payment-history-btn:active {
        transform: scale(0.96) !important;

        box-shadow:
            0 3px 9px rgba(70, 80, 100, 0.12) !important;
    }


    .payment-history-btn:focus {
        outline: none !important;
    }

}

/* =========================================================
   CHECK PAYMENT TABLES
   MOBILE CARD VIEW ONLY
   ========================================================= */

@media (max-width: 767.98px) {

    /* -----------------------------------------------------
       TABLE WRAPPER
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve,
    .mobile_check_payment_table {
        width: 100% !important;
        border: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;

        background: transparent !important;

        display: block !important;
        overflow: visible !important;
    }


    /* -----------------------------------------------------
       HIDE TABLE HEADER
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve thead,
    .mobile_check_payment_table thead {
        display: none !important;
    }


    /* -----------------------------------------------------
       TABLE BODY
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve tbody,
    .mobile_check_payment_table tbody {
        display: block !important;
        width: 100% !important;
    }


    /* -----------------------------------------------------
       EACH ROW = CARD
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve tbody tr,
    .mobile_check_payment_table tbody tr {

        display: grid !important;

        width: 100% !important;

        margin: 0 0 14px 0 !important;
        padding: 14px !important;

        background: #ffffff !important;

        border: 1px solid #eeeeee !important;
        border-radius: 14px !important;

        box-shadow:
            0 4px 14px rgba(0, 0, 0, 0.07) !important;

        overflow: hidden !important;

        box-sizing: border-box !important;

        position: relative !important;
    }


    /* -----------------------------------------------------
       NORMAL CELLS
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve tbody td,
    .mobile_check_payment_table tbody td {

        display: flex !important;

        align-items: center !important;

        width: 100% !important;

        min-height: 42px !important;

        padding: 7px 0 !important;

        border: 0 !important;

        box-sizing: border-box !important;

        text-align: right !important;

        vertical-align: middle !important;
    }


    /* -----------------------------------------------------
       LABELS
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve tbody td::before,
    .mobile_check_payment_table tbody td::before {

        content: attr(data-label);

        flex: 0 0 48%;

        margin-right: 10px;

        color: #8a8f98;

        font-size: 10px;

        font-weight: 700;

        letter-spacing: 0.5px;

        text-transform: uppercase;

        text-align: left;

        line-height: 1.3;
    }


    /* -----------------------------------------------------
       CHECK IMAGE CELLS
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve tbody td.uploaded-checks,
    .mobile_check_payment_table tbody td.uploaded-checks {

        display: block !important;

        width: 100% !important;

        padding: 5px !important;

        text-align: center !important;

        background: #f8f9fb !important;

        border-radius: 10px !important;

        margin-bottom: 8px !important;
    }


    /* Don't show normal label for image area */
    .mobile_check_payment_table_to_approve tbody td.uploaded-checks::before,
    .mobile_check_payment_table tbody td.uploaded-checks::before {
        display: none !important;
    }


    /* -----------------------------------------------------
       CHECK IMAGE
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve tbody td.uploaded-checks img,
    .mobile_check_payment_table tbody td.uploaded-checks img {

        display: block !important;

        width: auto !important;

        max-width: 100% !important;

        height: 95px !important;

        object-fit: contain !important;

        margin: auto !important;

        border-radius: 7px !important;
    }


    /* -----------------------------------------------------
       DATE / TIME
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve tbody td:nth-child(3)::before,
    .mobile_check_payment_table tbody td:nth-child(3)::before {
        content: "DATE";
    }

    .mobile_check_payment_table_to_approve tbody td:nth-child(4)::before,
    .mobile_check_payment_table tbody td:nth-child(4)::before {
        content: "TIME";
    }


    /* -----------------------------------------------------
       AMOUNTS
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve tbody td:nth-child(5)::before,
    .mobile_check_payment_table tbody td:nth-child(5)::before {
        content: "PAID AMOUNT";
    }

    .mobile_check_payment_table_to_approve tbody td:nth-child(6)::before,
    .mobile_check_payment_table tbody td:nth-child(6)::before {
        content: "TOTAL AMOUNT";
    }


    /* -----------------------------------------------------
       APPROVAL
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve tbody td:nth-child(7)::before,
    .mobile_check_payment_table tbody td:nth-child(7)::before {
        content: "PAYMENT APPROVAL";
    }


    /* -----------------------------------------------------
       ACTION
       Only second table has ACTION
       ----------------------------------------------------- */

    .mobile_check_payment_table tbody td:nth-child(8)::before {
        content: "ACTION";
    }


    /* -----------------------------------------------------
       APPROVE BUTTON
       ----------------------------------------------------- */

    .mobile_check_payment_table_to_approve .approve-check,
    .mobile_check_payment_table .approve-check {

        margin-left: auto !important;

        min-width: 90px !important;

        padding: 7px 14px !important;

        border-radius: 8px !important;

        font-size: 11px !important;

        font-weight: 600 !important;

        box-shadow:
            0 3px 8px rgba(0, 123, 255, 0.15) !important;
    }


    /* -----------------------------------------------------
       APPROVED / REJECTED BUTTON
       ----------------------------------------------------- */

    .mobile_check_payment_table tbody td:nth-child(7) button:not(.approve-check) {

        margin-left: auto !important;

        font-size: 11px !important;

        padding: 4px 0 !important;

        white-space: nowrap !important;
    }


    /* -----------------------------------------------------
       ACTION DOWNLOAD BUTTONS
       ----------------------------------------------------- */

    .mobile_check_payment_table tbody td:nth-child(8) {

        display: flex !important;

        flex-wrap: wrap !important;

        justify-content: flex-end !important;

        gap: 5px !important;
    }


    .mobile_check_payment_table tbody td:nth-child(8) a {

        margin: 0 !important;

        min-width: 38px !important;

        height: 34px !important;

        display: inline-flex !important;

        align-items: center !important;

        justify-content: center !important;

        border-radius: 8px !important;

        font-size: 11px !important;
    }


    /* -----------------------------------------------------
       FOOTER / TOTAL
       ----------------------------------------------------- */

    .mobile_check_payment_table tfoot {
        display: table !important;

        width: 100% !important;

        margin-top: 5px !important;

        background: #ffffff !important;

        border-radius: 12px !important;
    }


    .mobile_check_payment_table tfoot tr {
        display: table-row !important;
    }


    .mobile_check_payment_table tfoot th,
    .mobile_check_payment_table tfoot td {
        display: table-cell !important;

        padding: 12px 10px !important;

        border: 0 !important;

        font-size: 12px !important;
    }


    .mobile_check_payment_table tfoot th {
        font-weight: 700 !important;

        color: #555 !important;
    }


    .mobile_check_payment_table tfoot th.text-right {
        text-align: right !important;
    }


    /* -----------------------------------------------------
       REMOVE EMPTY CELLS VISUAL SPACE
       ----------------------------------------------------- */

    .mobile_check_payment_table tbody td:empty {
        display: none !important;
    }
    .mobile_check_payment_table .d-md-inline,
    .mobile_venmo_payment_table .d-md-inline,
    .mobile_paypal_table .d-md-inline,
    .mobile_po_table .d-md-inline
     {
        display: block !important;
    }

}

@media (max-width: 767.98px) {

    /* =====================================================
       VENMO PAYMENT TABLES
       MOBILE CARD VIEW
       ===================================================== */

    .mobile_venmo_payment_table_to_approve,
    .mobile_venmo_payment_table,
    .mobile_venmo_payment_table_2 {

        width: 100% !important;

        display: block !important;

        border: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;

        background: transparent !important;

        overflow: visible !important;
    }


    /* =====================================================
       HIDE TABLE HEADER
       ===================================================== */

    .mobile_venmo_payment_table_to_approve thead,
    .mobile_venmo_payment_table thead,
    .mobile_venmo_payment_table_2 thead {

        display: none !important;
    }


    /* =====================================================
       TABLE BODY
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody,
    .mobile_venmo_payment_table tbody,
    .mobile_venmo_payment_table_2 tbody {

        display: block !important;

        width: 100% !important;
    }


    /* =====================================================
       EACH ROW = CARD
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody tr,
    .mobile_venmo_payment_table tbody tr,
    .mobile_venmo_payment_table_2 tbody tr {

        display: grid !important;

        width: 100% !important;

        margin: 0 0 14px 0 !important;

        padding: 14px !important;

        background: #ffffff !important;

        border: 1px solid #eeeeee !important;

        border-radius: 14px !important;

        box-shadow:
            0 4px 14px rgba(0, 0, 0, 0.07) !important;

        overflow: hidden !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       NORMAL DATA CELLS
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody td,
    .mobile_venmo_payment_table tbody td,
    .mobile_venmo_payment_table_2 tbody td {

        display: flex !important;

        align-items: center !important;

        width: 100% !important;

        min-height: 42px !important;

        padding: 7px 0 !important;

        border: 0 !important;

        box-sizing: border-box !important;

        text-align: right !important;

        vertical-align: middle !important;
    }


    /* =====================================================
       LABELS
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody td::before,
    .mobile_venmo_payment_table tbody td::before,
    .mobile_venmo_payment_table_2 tbody td::before {

        flex: 0 0 48%;

        margin-right: 10px;

        color: #8a8f98;

        font-size: 10px;

        font-weight: 700;

        letter-spacing: 0.5px;

        text-transform: uppercase;

        text-align: left;

        line-height: 1.3;

        content: attr(data-label);
    }


    /* =====================================================
       RECEIPT
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody td.uploaded-checks,
    .mobile_venmo_payment_table tbody td.uploaded-checks,
    .mobile_venmo_payment_table_2 tbody td.uploaded-checks {

        display: block !important;

        width: 100% !important;

        padding: 6px !important;

        margin-bottom: 8px !important;

        background: #f8f9fb !important;

        border-radius: 10px !important;

        text-align: center !important;
    }


    /* Hide label for receipt */
    .mobile_venmo_payment_table_to_approve tbody td.uploaded-checks::before,
    .mobile_venmo_payment_table tbody td.uploaded-checks::before,
    .mobile_venmo_payment_table_2 tbody td.uploaded-checks::before {

        display: none !important;
    }


    /* =====================================================
       RECEIPT IMAGE
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody td.uploaded-checks img,
    .mobile_venmo_payment_table tbody td.uploaded-checks img,
    .mobile_venmo_payment_table_2 tbody td.uploaded-checks img {

        display: block !important;

        width: auto !important;

        max-width: 100% !important;

        height: 120px !important;

        object-fit: contain !important;

        margin: auto !important;

        border-radius: 7px !important;
    }


    /* =====================================================
       DATE
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody td:nth-child(2)::before,
    .mobile_venmo_payment_table tbody td:nth-child(2)::before,
    .mobile_venmo_payment_table_2 tbody td:nth-child(2)::before {

        content: "DATE";
    }


    /* =====================================================
       TIME
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody td:nth-child(3)::before,
    .mobile_venmo_payment_table tbody td:nth-child(3)::before,
    .mobile_venmo_payment_table_2 tbody td:nth-child(3)::before {

        content: "TIME";
    }


    /* =====================================================
       CUSTOMER PAID AMOUNT
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody td:nth-child(4)::before,
    .mobile_venmo_payment_table tbody td:nth-child(4)::before,
    .mobile_venmo_payment_table_2 tbody td:nth-child(4)::before {

        content: "CUST. PAID AMOUNT";
    }


    /* =====================================================
       AMOUNT
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody td:nth-child(5)::before,
    .mobile_venmo_payment_table tbody td:nth-child(5)::before,
    .mobile_venmo_payment_table_2 tbody td:nth-child(5)::before {

        content: "AMOUNT";
    }


    /* =====================================================
       APPROVAL
       ===================================================== */

    .mobile_venmo_payment_table_to_approve tbody td:nth-child(6)::before,
    .mobile_venmo_payment_table tbody td:nth-child(6)::before,
    .mobile_venmo_payment_table_2 tbody td:nth-child(6)::before {

        content: "PAYMENT APPROVAL";
    }


    /* =====================================================
       DOWNLOAD
       ===================================================== */

    .mobile_venmo_payment_table tbody td:nth-child(7)::before,
    .mobile_venmo_payment_table_2 tbody td:nth-child(7)::before {

        content: "DOWNLOAD";
    }


    /* =====================================================
       APPROVE BUTTON
       ===================================================== */

    .mobile_venmo_payment_table_to_approve .approve-venmo,
    .mobile_venmo_payment_table .approve-venmo,
    .mobile_venmo_payment_table_2 .approve-venmo {

        margin-left: auto !important;

        min-width: 90px !important;

        padding: 7px 14px !important;

        border-radius: 8px !important;

        font-size: 11px !important;

        font-weight: 600 !important;

        box-shadow:
            0 3px 8px rgba(0, 123, 255, 0.15) !important;
    }


    /* =====================================================
       APPROVED / REJECTED
       ===================================================== */

    .mobile_venmo_payment_table tbody td:nth-child(6) button:not(.approve-venmo),
    .mobile_venmo_payment_table_2 tbody td:nth-child(6) button:not(.approve-venmo) {

        margin-left: auto !important;

        padding: 4px 0 !important;

        font-size: 11px !important;

        white-space: nowrap !important;
    }


    /* =====================================================
       DOWNLOAD BUTTON
       ===================================================== */

    .mobile_venmo_payment_table tbody td:nth-child(7),
    .mobile_venmo_payment_table_2 tbody td:nth-child(7) {

        display: flex !important;

        justify-content: flex-end !important;

        align-items: center !important;
    }


    .mobile_venmo_payment_table tbody td:nth-child(7) a,
    .mobile_venmo_payment_table_2 tbody td:nth-child(7) a {

        margin: 0 !important;

        min-width: 42px !important;

        height: 34px !important;

        display: inline-flex !important;

        align-items: center !important;

        justify-content: center !important;

        border-radius: 8px !important;

        font-size: 11px !important;
    }


    /* =====================================================
       TOTAL FOOTER
       ===================================================== */

    .mobile_venmo_payment_table tfoot,
    .mobile_venmo_payment_table_2 tfoot {

        display: table !important;

        width: 100% !important;

        margin-top: 5px !important;

        background: #ffffff !important;

        border-radius: 12px !important;
    }


    .mobile_venmo_payment_table tfoot tr,
    .mobile_venmo_payment_table_2 tfoot tr {

        display: table-row !important;
    }


    .mobile_venmo_payment_table tfoot th,
    .mobile_venmo_payment_table tfoot td,
    .mobile_venmo_payment_table_2 tfoot th,
    .mobile_venmo_payment_table_2 tfoot td {

        display: table-cell !important;

        padding: 12px 10px !important;

        border: 0 !important;

        font-size: 12px !important;
    }


    .mobile_venmo_payment_table tfoot th,
    .mobile_venmo_payment_table_2 tfoot th {

        font-weight: 700 !important;

        color: #555 !important;
    }


    .mobile_venmo_payment_table tfoot .text-right,
    .mobile_venmo_payment_table_2 tfoot .text-right {

        text-align: right !important;
    }
    #venmo_receipt_preview img {
        width: 100% !important;
    }

}

@media (max-width: 767.98px) {

    /* =====================================================
       PAYPAL PAYMENT TABLES
       MOBILE CARD VIEW ONLY
       ===================================================== */

    .mobile_paypal_to_approve,
    .mobile_paypal_table,
    .mobile_paypal_table_2 {

        width: 100% !important;

        display: block !important;

        border: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;

        background: transparent !important;

        overflow: visible !important;
    }


    /* =====================================================
       HIDE DESKTOP TABLE HEADER
       ===================================================== */

    .mobile_paypal_to_approve thead,
    .mobile_paypal_table thead,
    .mobile_paypal_table_2 thead {

        display: none !important;
    }


    /* =====================================================
       TABLE BODY
       ===================================================== */

    .mobile_paypal_to_approve tbody,
    .mobile_paypal_table tbody,
    .mobile_paypal_table_2 tbody {

        display: block !important;

        width: 100% !important;
    }


    /* =====================================================
       EACH ROW = MODERN CARD
       ===================================================== */

    .mobile_paypal_to_approve tbody tr,
    .mobile_paypal_table tbody tr,
    .mobile_paypal_table_2 tbody tr {

        display: grid !important;

        width: 100% !important;

        margin: 0 0 14px 0 !important;

        padding: 14px !important;

        background: #ffffff !important;

        border: 1px solid #eeeeee !important;

        border-radius: 14px !important;

        box-shadow:
            0 4px 14px rgba(0, 0, 0, 0.07) !important;

        overflow: hidden !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       NORMAL CELLS
       ===================================================== */

    .mobile_paypal_to_approve tbody td,
    .mobile_paypal_table tbody td,
    .mobile_paypal_table_2 tbody td {

        display: flex !important;

        align-items: center !important;

        width: 100% !important;

        min-height: 42px !important;

        padding: 7px 0 !important;

        border: 0 !important;

        box-sizing: border-box !important;

        text-align: right !important;

        vertical-align: middle !important;
    }


    /* =====================================================
       MOBILE LABELS
       ===================================================== */

    .mobile_paypal_to_approve tbody td::before,
    .mobile_paypal_table tbody td::before,
    .mobile_paypal_table_2 tbody td::before {

        flex: 0 0 48% !important;

        margin-right: 10px !important;

        color: #8a8f98 !important;

        font-size: 10px !important;

        font-weight: 700 !important;

        letter-spacing: 0.5px !important;

        text-transform: uppercase !important;

        text-align: left !important;

        line-height: 1.3 !important;

        content: attr(data-label);
    }


    /* =====================================================
       PAYPAL RECEIPT
       ===================================================== */

    .mobile_paypal_to_approve tbody td.uploaded-checks,
    .mobile_paypal_table tbody td.uploaded-checks,
    .mobile_paypal_table_2 tbody td.uploaded-checks {

        display: block !important;

        width: 100% !important;

        padding: 6px !important;

        margin-bottom: 8px !important;

        background: #f8f9fb !important;

        border-radius: 10px !important;

        text-align: center !important;

        box-sizing: border-box !important;
    }


    /* Hide receipt label */
    .mobile_paypal_to_approve tbody td.uploaded-checks::before,
    .mobile_paypal_table tbody td.uploaded-checks::before,
    .mobile_paypal_table_2 tbody td.uploaded-checks::before {

        display: none !important;
    }


    /* =====================================================
       RECEIPT IMAGE
       ===================================================== */

    .mobile_paypal_to_approve tbody td.uploaded-checks img,
    .mobile_paypal_table tbody td.uploaded-checks img,
    .mobile_paypal_table_2 tbody td.uploaded-checks img {

        display: block !important;

        width: auto !important;

        max-width: 100% !important;

        height: 120px !important;

        object-fit: contain !important;

        margin: auto !important;

        border-radius: 7px !important;
    }


    /* =====================================================
       DATE
       ===================================================== */

    .mobile_paypal_to_approve tbody td:nth-child(2)::before,
    .mobile_paypal_table tbody td:nth-child(2)::before,
    .mobile_paypal_table_2 tbody td:nth-child(2)::before {

        content: "DATE";
    }


    /* =====================================================
       TIME
       ===================================================== */

    .mobile_paypal_to_approve tbody td:nth-child(3)::before,
    .mobile_paypal_table tbody td:nth-child(3)::before,
    .mobile_paypal_table_2 tbody td:nth-child(3)::before {

        content: "TIME";
    }


    /* =====================================================
       AMOUNT
       ===================================================== */

    .mobile_paypal_to_approve tbody td:nth-child(4)::before,
    .mobile_paypal_table tbody td:nth-child(4)::before,
    .mobile_paypal_table_2 tbody td:nth-child(4)::before {

        content: "AMOUNT";
    }


    /* =====================================================
       APPROVAL
       ===================================================== */

    .mobile_paypal_to_approve tbody td:nth-child(5)::before,
    .mobile_paypal_table tbody td:nth-child(5)::before,
    .mobile_paypal_table_2 tbody td:nth-child(5)::before {

        content: "PAYMENT APPROVAL";
    }


    /* =====================================================
       DOWNLOAD
       ===================================================== */

    .mobile_paypal_table tbody td:nth-child(6)::before,
    .mobile_paypal_table_2 tbody td:nth-child(6)::before {

        content: "DOWNLOAD";
    }


    /* =====================================================
       APPROVE BUTTON
       ===================================================== */

    .mobile_paypal_to_approve .approve-paypal,
    .mobile_paypal_table .approve-paypal,
    .mobile_paypal_table_2 .approve-paypal {

        margin-left: auto !important;

        min-width: 90px !important;

        padding: 7px 14px !important;

        border-radius: 8px !important;

        font-size: 11px !important;

        font-weight: 600 !important;

        box-shadow:
            0 3px 8px rgba(0, 123, 255, 0.15) !important;
    }


    /* =====================================================
       APPROVED / REJECTED
       ===================================================== */

    .mobile_paypal_table tbody td:nth-child(5) button:not(.approve-paypal),
    .mobile_paypal_table_2 tbody td:nth-child(5) button:not(.approve-paypal) {

        margin-left: auto !important;

        padding: 4px 0 !important;

        font-size: 11px !important;

        white-space: nowrap !important;
    }


    /* =====================================================
       DOWNLOAD BUTTON
       ===================================================== */

    .mobile_paypal_table tbody td:nth-child(6),
    .mobile_paypal_table_2 tbody td:nth-child(6) {

        display: flex !important;

        justify-content: flex-end !important;

        align-items: center !important;
    }


    .mobile_paypal_table tbody td:nth-child(6) a,
    .mobile_paypal_table_2 tbody td:nth-child(6) a {

        margin: 0 !important;

        min-width: 42px !important;

        height: 34px !important;

        display: inline-flex !important;

        align-items: center !important;

        justify-content: center !important;

        border-radius: 8px !important;

        font-size: 11px !important;
    }


    /* =====================================================
       TOTAL FOOTER
       ===================================================== */

    .mobile_paypal_to_approve tfoot,
    .mobile_paypal_table tfoot,
    .mobile_paypal_table_2 tfoot {

        display: table !important;

        width: 100% !important;

        margin-top: 5px !important;

        background: #ffffff !important;

        border-radius: 12px !important;
    }


    .mobile_paypal_to_approve tfoot tr,
    .mobile_paypal_table tfoot tr,
    .mobile_paypal_table_2 tfoot tr {

        display: table-row !important;
    }


    .mobile_paypal_to_approve tfoot th,
    .mobile_paypal_to_approve tfoot td,
    .mobile_paypal_table tfoot th,
    .mobile_paypal_table tfoot td,
    .mobile_paypal_table_2 tfoot th,
    .mobile_paypal_table_2 tfoot td {

        display: table-cell !important;

        padding: 12px 10px !important;

        border: 0 !important;

        font-size: 12px !important;
    }


    .mobile_paypal_to_approve tfoot th,
    .mobile_paypal_table tfoot th,
    .mobile_paypal_table_2 tfoot th {

        font-weight: 700 !important;

        color: #555 !important;
    }


    .mobile_paypal_to_approve tfoot .text-right,
    .mobile_paypal_table tfoot .text-right,
    .mobile_paypal_table_2 tfoot .text-right {

        text-align: right !important;
    }
    #paypal_receipt_preview img {
        width: 100% !important;
    }

}

@media (max-width: 767.98px) {

    /* =====================================================
       PURCHASE ORDER RECEIPT TABLE
       MOBILE CARD VIEW ONLY
       ===================================================== */

    .mobile_po_table {

        width: 100% !important;

        display: block !important;

        border: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;

        background: transparent !important;

        overflow: visible !important;
    }


    /* =====================================================
       HIDE DESKTOP HEADER
       ===================================================== */

    .mobile_po_table thead {
        display: none !important;
    }


    /* =====================================================
       TABLE BODY
       ===================================================== */

    .mobile_po_table tbody {

        display: block !important;

        width: 100% !important;
    }


    /* =====================================================
       EACH ROW = CARD
       ===================================================== */

    .mobile_po_table tbody tr {

        display: grid !important;

        width: 100% !important;

        margin: 0 0 14px 0 !important;

        padding: 14px !important;

        background: #ffffff !important;

        border: 1px solid #eeeeee !important;

        border-radius: 14px !important;

        box-shadow:
            0 4px 14px rgba(0, 0, 0, 0.07) !important;

        overflow: hidden !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       NORMAL CELLS
       ===================================================== */

    .mobile_po_table tbody td {

        display: flex !important;

        align-items: center !important;

        width: 100% !important;

        min-height: 42px !important;

        padding: 7px 0 !important;

        border: 0 !important;

        box-sizing: border-box !important;

        text-align: right !important;

        vertical-align: middle !important;
    }


    /* =====================================================
       MOBILE LABELS
       ===================================================== */

    .mobile_po_table tbody td::before {

        flex: 0 0 48% !important;

        margin-right: 10px !important;

        color: #8a8f98 !important;

        font-size: 10px !important;

        font-weight: 700 !important;

        letter-spacing: 0.5px !important;

        text-transform: uppercase !important;

        text-align: left !important;

        line-height: 1.3 !important;

        content: attr(data-label);
    }


    /* =====================================================
       PO RECEIPT PREVIEW
       ===================================================== */

    .mobile_po_table tbody td.uploaded-checks {

        display: block !important;

        width: 100% !important;

        padding: 6px !important;

        margin-bottom: 8px !important;

        background: #f8f9fb !important;

        border-radius: 10px !important;

        text-align: center !important;

        box-sizing: border-box !important;
    }


    /* Hide label for receipt */
    .mobile_po_table tbody td.uploaded-checks::before {

        display: none !important;
    }


    /* =====================================================
       RECEIPT IMAGE
       ===================================================== */

    .mobile_po_table tbody td.uploaded-checks img {

        display: block !important;

        width: auto !important;

        max-width: 100% !important;

        height: 120px !important;

        object-fit: contain !important;

        margin: auto !important;

        border-radius: 7px !important;
    }


    /* =====================================================
       DATE
       ===================================================== */

    .mobile_po_table tbody td:nth-child(2)::before {

        content: "DATE";
    }


    /* =====================================================
       TIME
       ===================================================== */

    .mobile_po_table tbody td:nth-child(3)::before {

        content: "TIME";
    }


    /* =====================================================
       ORDER AMOUNT
       ===================================================== */

    .mobile_po_table tbody td:nth-child(4)::before {

        content: "ORDER AMOUNT";
    }


    /* =====================================================
       PAYMENT APPROVAL
       ===================================================== */

    .mobile_po_table tbody td:nth-child(5)::before {

        content: "PAYMENT APPROVAL";
    }


    /* =====================================================
       DOWNLOAD
       ===================================================== */

    .mobile_po_table tbody td:nth-child(6)::before {

        content: "DOWNLOAD";
    }


    /* =====================================================
       APPROVE BUTTON
       ===================================================== */

    .mobile_po_table .approve-po {

        margin-left: auto !important;

        min-width: 90px !important;

        padding: 7px 14px !important;

        border-radius: 8px !important;

        font-size: 11px !important;

        font-weight: 600 !important;

        box-shadow:
            0 3px 8px rgba(0, 123, 255, 0.15) !important;
    }


    /* =====================================================
       APPROVED / REJECTED
       ===================================================== */

    .mobile_po_table tbody td:nth-child(5) button:not(.approve-po) {

        margin-left: auto !important;

        padding: 4px 0 !important;

        font-size: 11px !important;

        white-space: nowrap !important;
    }


    /* =====================================================
       DOWNLOAD AREA
       ===================================================== */

    .mobile_po_table tbody td:nth-child(6) {

        display: flex !important;

        justify-content: flex-end !important;

        align-items: center !important;
    }


    /* =====================================================
       DOWNLOAD BUTTON
       ===================================================== */

    .mobile_po_table tbody td:nth-child(6) a {

        margin: 0 !important;

        min-width: 42px !important;

        height: 34px !important;

        display: inline-flex !important;

        align-items: center !important;

        justify-content: center !important;

        padding: 6px 12px !important;

        border-radius: 8px !important;

        font-size: 11px !important;

        box-sizing: border-box !important;
    }

}

/* =========================================================
   OTHER PAYMENTS - MOBILE CARD VIEW
   Desktop layout remains completely unchanged
   ========================================================= */

@media (max-width: 767.98px) {

    /* -----------------------------------------------------
       TABLE CONTAINER
       ----------------------------------------------------- */

    .mobile_other_table,
    .mobile_other_table_2 {
        width: 100% !important;
        display: block !important;
        border: none !important;
        border-collapse: separate !important;
        background: transparent !important;
        margin: 10px 0 15px !important;
    }

    /* -----------------------------------------------------
       HIDE NORMAL TABLE HEADER
       ----------------------------------------------------- */

    .mobile_other_table thead,
    .mobile_other_table_2 thead {
        display: none !important;
    }

    /* -----------------------------------------------------
       TBODY
       ----------------------------------------------------- */

    .mobile_other_table tbody,
    .mobile_other_table_2 tbody {
        display: block !important;
        width: 100% !important;
    }

    /* -----------------------------------------------------
       EACH PAYMENT = CARD
       ----------------------------------------------------- */

    .mobile_other_table tbody tr,
    .mobile_other_table_2 tbody tr {
        display: grid !important;

        grid-template-columns: 1fr 1fr !important;

        width: 100% !important;

        margin-bottom: 14px !important;
        padding: 14px !important;

        background: #ffffff !important;

        border: 1px solid #eeeeee !important;
        border-radius: 14px !important;

        box-shadow:
            0 3px 12px rgba(0, 0, 0, 0.06) !important;

        position: relative !important;

        box-sizing: border-box !important;

        transition: all 0.2s ease !important;
    }

    .mobile_other_table tbody tr:active,
    .mobile_other_table_2 tbody tr:active {
        transform: scale(0.99);
    }


    /* -----------------------------------------------------
       ALL CELLS
       ----------------------------------------------------- */

    .mobile_other_table tbody td,
    .mobile_other_table_2 tbody td {
        display: flex !important;

        align-items: center !important;

        min-width: 0 !important;

        padding: 9px 7px !important;

        border: none !important;

        text-align: left !important;

        vertical-align: middle !important;

        font-size: 12px !important;

        color: #333 !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       DOCUMENT / RECEIPT
       ===================================================== */

    .mobile_other_table tbody td:nth-child(1),
    .mobile_other_table_2 tbody td:nth-child(1) {

        grid-column: 1 / -1 !important;

        min-height: 110px !important;

        justify-content: center !important;

        background: #fafafa !important;

        border-radius: 10px !important;

        margin-bottom: 7px !important;

        padding: 10px !important;

        border: 1px solid #f0f0f0 !important;
    }

    .mobile_other_table tbody td:nth-child(1)::before,
    .mobile_other_table_2 tbody td:nth-child(1)::before {

        content: "DOCUMENT";

        position: absolute;

        align-self: flex-start;

        margin-top: -82px;

        margin-left: -4px;

        font-size: 9px;

        font-weight: 700;

        letter-spacing: 0.8px;

        color: #999;
    }


    /* Document image */

    .mobile_other_table tbody td:nth-child(1) img,
    .mobile_other_table_2 tbody td:nth-child(1) img {

        width: auto !important;

        max-width: 100% !important;

        height: 85px !important;

        max-height: 85px !important;

        object-fit: contain !important;

        border-radius: 7px !important;

        display: block !important;
    }


    .mobile_other_table tbody td:nth-child(1) a,
    .mobile_other_table_2 tbody td:nth-child(1) a {

        display: flex !important;

        align-items: center !important;

        justify-content: center !important;

        width: 100% !important;

        height: 100% !important;
    }


    /* =====================================================
       DATE
       ===================================================== */

    .mobile_other_table tbody td:nth-child(2)::before,
    .mobile_other_table_2 tbody td:nth-child(2)::before {

        content: "DATE";

        display: block;

        margin-right: 7px;

        font-size: 9px;

        font-weight: 700;

        letter-spacing: 0.7px;

        color: #999;
    }


    /* =====================================================
       TIME
       ===================================================== */

    .mobile_other_table tbody td:nth-child(3)::before,
    .mobile_other_table_2 tbody td:nth-child(3)::before {

        content: "TIME";

        display: block;

        margin-right: 7px;

        font-size: 9px;

        font-weight: 700;

        letter-spacing: 0.7px;

        color: #999;
    }


    /* =====================================================
       DESCRIPTION
       ===================================================== */

    .mobile_other_table tbody td:nth-child(4),
    .mobile_other_table_2 tbody td:nth-child(4) {

        grid-column: 1 / -1 !important;

        display: block !important;

        padding: 10px 7px !important;

        margin-top: 3px !important;

        background: #fafafa !important;

        border-radius: 8px !important;

        line-height: 1.5 !important;

        word-break: break-word !important;
    }

    .mobile_other_table tbody td:nth-child(4)::before,
    .mobile_other_table_2 tbody td:nth-child(4)::before {

        content: "DESCRIPTION";

        display: block;

        margin-bottom: 3px;

        font-size: 9px;

        font-weight: 700;

        letter-spacing: 0.7px;

        color: #999;
    }


    /* =====================================================
       PAID AMOUNT
       ===================================================== */

    .mobile_other_table tbody td:nth-child(5),
    .mobile_other_table_2 tbody td:nth-child(5) {

        grid-column: 1 !important;

        display: block !important;

        padding-top: 12px !important;
    }

    .mobile_other_table tbody td:nth-child(5)::before,
    .mobile_other_table_2 tbody td:nth-child(5)::before {

        content: "PAID AMOUNT";

        display: block;

        margin-bottom: 2px;

        font-size: 9px;

        font-weight: 700;

        letter-spacing: 0.6px;

        color: #999;
    }


    .mobile_other_table tbody td:nth-child(5),
    .mobile_other_table_2 tbody td:nth-child(5) {

        font-size: 15px !important;

        font-weight: 700 !important;

        color: #333 !important;

        text-align: left !important;
    }


    /* =====================================================
       DOWNLOAD
       ===================================================== */

    .mobile_other_table tbody td:nth-child(6),
    .mobile_other_table_2 tbody td:nth-child(6) {

        grid-column: 2 !important;

        justify-content: flex-end !important;

        padding-top: 12px !important;
    }


    .mobile_other_table tbody td:nth-child(6)::before,
    .mobile_other_table_2 tbody td:nth-child(6)::before {

        content: none !important;
    }


    /* Download button */

    .mobile_other_table tbody td:nth-child(6) a,
    .mobile_other_table_2 tbody td:nth-child(6) a {

        display: inline-flex !important;

        align-items: center !important;

        justify-content: center !important;

        min-width: 42px !important;

        height: 38px !important;

        padding: 0 12px !important;

        border-radius: 9px !important;

        font-size: 12px !important;

        border: 1px solid #dfe3e8 !important;

        background: #f8f9fa !important;

        color: #555 !important;

        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;

        transition: all 0.2s ease !important;
    }

    .mobile_other_table tbody td:nth-child(6) a:active,
    .mobile_other_table_2 tbody td:nth-child(6) a:active {

        transform: scale(0.96);

        background: #f0f2f4 !important;
    }


    .mobile_other_table tbody td:nth-child(6) a i,
    .mobile_other_table_2 tbody td:nth-child(6) a i {

        font-size: 14px !important;

        margin: 0 !important;
    }


    /* -----------------------------------------------------
       REMOVE EMPTY FOOTER ON MOBILE
       ----------------------------------------------------- */

    .mobile_other_table tfoot,
    .mobile_other_table_2 tfoot {

        display: block !important;

        width: 100% !important;

        margin-top: 5px !important;

        background: #f8f9fa !important;

        border-radius: 10px !important;

        overflow: hidden !important;
    }

    .mobile_other_table tfoot tr,
    .mobile_other_table_2 tfoot tr {

        display: flex !important;

        align-items: center !important;

        justify-content: space-between !important;

        width: 100% !important;

        padding: 10px 12px !important;

        box-sizing: border-box !important;
    }

    .mobile_other_table tfoot th,
    .mobile_other_table_2 tfoot th {

        display: block !important;

        border: none !important;

        font-size: 11px !important;

        font-weight: 700 !important;

        color: #777 !important;

        padding: 0 !important;
    }

    .mobile_other_table tfoot th.text-right,
    .mobile_other_table_2 tfoot th.text-right {

        font-size: 15px !important;

        color: #222 !important;

        margin-left: auto !important;
    }

    .mobile_other_table tfoot td,
    .mobile_other_table_2 tfoot td {

        display: none !important;
    }


    /* =====================================================
       VERY SMALL SCREENS
       ===================================================== */

    @media (max-width: 380px) {

        .mobile_other_table tbody tr,
        .mobile_other_table_2 tbody tr {

            padding: 11px !important;

            border-radius: 12px !important;
        }

        .mobile_other_table tbody td,
        .mobile_other_table_2 tbody td {

            font-size: 11px !important;

            padding: 7px 5px !important;
        }

        .mobile_other_table tbody td:nth-child(5),
        .mobile_other_table_2 tbody td:nth-child(5) {

            font-size: 14px !important;
        }

        .mobile_other_table tbody td:nth-child(6) a,
        .mobile_other_table_2 tbody td:nth-child(6) a {

            height: 35px !important;

            padding: 0 10px !important;
        }
    }

    #purchase_order_receipt_preview img {
        width: 100% !important;
    }
}

/* =========================================================
   PAYMENT HISTORY - MOBILE CARD LAYOUT
   ========================================================= */

@media (max-width: 767.98px) {

    #PaymentHistoryModal .modal-dialog {
        margin: 10px;
        max-width: none;
        width: auto;
    }

    #PaymentHistoryModal .modal-content {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.16);
    }

    #PaymentHistoryModal .modal-header {
        padding: 16px 18px;
        border-bottom: 1px solid #eeeeee;
        background: linear-gradient(135deg, #ffffff, #f7f9fc);
    }

    #PaymentHistoryModal .modal-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        color: #20242a;
    }

    #PaymentHistoryModal .modal-header .close {
        width: 34px;
        height: 34px;
        padding: 0;
        margin: 0;
        border-radius: 50%;
        background: #f1f3f6;
        opacity: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #PaymentHistoryModal .modal-body {
        padding: 12px;
        background: #f6f7f9;
        max-height: 75vh;
        overflow-y: auto;
    }

    #PaymentHistoryModal .modal-body > .col-md-12 {
        padding: 0 !important;
    }

    /* TABLE */
    #PaymentHistoryModal .paymentSummaryTable {
        width: 100%;
        border: none !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        background: transparent !important;
    }

    #PaymentHistoryModal .paymentSummaryTable thead {
        display: none;
    }

    #PaymentHistoryModal .paymentSummaryTable tbody {
        display: block;
        width: 100%;
    }

    /* =====================================================
       CARD
       ===================================================== */

    #PaymentHistoryModal .paymentSummaryTable tbody tr {
        display: grid !important;

        /*
           2-column grid:
           Transaction ID = full
           Type + Status = half
           Date + Time = half
           Amount = full
        */
        grid-template-columns: 1fr 1fr;

        width: 100%;
        margin: 0 0 12px 0;
        padding: 5px 16px 10px 16px;

        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 16px;

        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);

        box-sizing: border-box;
    }

    /* =====================================================
       ALL TD
       ===================================================== */

    #PaymentHistoryModal .paymentSummaryTable tbody td {
        display: flex !important;
        flex-direction: column;

        width: auto !important;
        min-width: 0;

        padding: 11px 8px !important;

        border: none !important;

        text-align: left !important;
        vertical-align: middle !important;

        font-size: 14px;
        font-weight: 600;
        color: #252a31;
        box-sizing: border-box;
    }

    /* =====================================================
       FIELD POSITIONS
       ===================================================== */

    /* Transaction ID - Full Width */
    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(1) {
        grid-column: 1 / -1;
        border-bottom: 1px solid #f0f0f0 !important;
    }

    /* Payment Type */
    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(2) {
        grid-column: 1;
        border-bottom: 1px solid #f0f0f0 !important;
    }

    /* Payment Status */
    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(3) {
        grid-column: 2;
        border-bottom: 1px solid #f0f0f0 !important;
    }

    /* Date */
    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(4) {
        grid-column: 1;
    }

    /* Time */
    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(5) {
        grid-column: 2;
    }

    /* Amount - Full Width */
    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(6) {
        grid-column: 1 / -1;

        margin-top: 2px;
        padding-top: 13px !important;

        border-top: 1px solid #f0f0f0 !important;
    }

    /* =====================================================
       LABELS
       ===================================================== */

    #PaymentHistoryModal .paymentSummaryTable tbody td::before {
        display: block;

        margin-bottom: 5px;

        font-size: 9px;
        line-height: 1.2;
        font-weight: 800;

        letter-spacing: 0.8px;
        text-transform: uppercase;

        color: #9aa0a8;
    }

    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(1)::before {
        content: "TRANSACTION ID";
    }

    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(2)::before {
        content: "PAYMENT TYPE";
    }

    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(3)::before {
        content: "PAYMENT STATUS";
    }

    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(4)::before {
        content: "DATE";
    }

    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(5)::before {
        content: "TIME";
    }

    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(6)::before {
        content: "AMOUNT";
    }

    /* =====================================================
       VALUES
       ===================================================== */

    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(1) {
        font-size: 14px;
        font-weight: 700;
        color: #242830;
    }

    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(2),
    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(4),
    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(5) {
        font-size: 13px;
        font-weight: 600;
        color: #4d5560;
    }

    /* =====================================================
       STATUS
       ===================================================== */

    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(3) span {
        display: inline-flex;
        align-items: center;

        width: fit-content;

        padding: 4px 9px;

        border-radius: 20px;

        font-size: 10px;
        line-height: 1.2;
        font-weight: 700;

        background: #eaf8f1;
    }

    /* =====================================================
       AMOUNT
       ===================================================== */

    #PaymentHistoryModal .paymentSummaryTable tbody td:nth-child(6) {
        font-size: 18px;
        font-weight: 800;
        color: #20242a;
    }

    /* =====================================================
       NO HISTORY
       ===================================================== */

    #PaymentHistoryModal .paymentSummaryTable tbody tr:has(td:only-child) {
        display: block !important;
        padding: 25px 15px;
        text-align: center;
    }

    #PaymentHistoryModal .paymentSummaryTable tbody td:only-child {
        display: block !important;
        text-align: center !important;
        border: none !important;
    }

    #PaymentHistoryModal .paymentSummaryTable tbody td:only-child::before {
        display: none;
    }
}

@media (max-width: 767.98px) {

    /* =====================================================
       CARD PAYMENT - MOBILE CARD
       ===================================================== */

    .mobile_card_payment_table_1,
    .mobile_card_payment_table_2 {
        width: 100% !important;
        border: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        background: transparent !important;
    }

    /* Hide original table header */
    .mobile_card_payment_table_1 thead,
    .mobile_card_payment_table_2 thead {
        display: none !important;
    }

    /* =====================================================
       PAYMENT CARD
       ===================================================== */

    .mobile_card_payment_table_1 tbody tr,
    .mobile_card_payment_table_2 tbody tr {
        display: block !important;

        position: relative !important;

        width: 100% !important;

        margin: 0 0 18px 0 !important;
        padding: 20px 18px 18px 18px !important;

        background: #ffffff !important;

        border: 1px solid #e9edf5 !important;
        border-radius: 18px !important;

        box-shadow:
            0 8px 25px rgba(50, 50, 93, 0.08) !important;

        overflow: hidden !important;
    }

    /* Creative top line */
    .mobile_card_payment_table_1 tbody tr::before,
    .mobile_card_payment_table_2 tbody tr::before {
        content: "" !important;

        position: absolute !important;

        top: 0 !important;
        left: 0 !important;

        width: 100% !important;
        height: 4px !important;

        background: linear-gradient(
            90deg,
            #5e72e4 0%,
            #825ee4 50%,
            #11cdef 100%
        ) !important;
    }

    /* =====================================================
       ALL TD
       ===================================================== */

    .mobile_card_payment_table_1 tbody td,
    .mobile_card_payment_table_2 tbody td {

        display: block !important;

        width: 100% !important;

        padding: 0 !important;
        margin: 0 !important;

        border: 0 !important;

        text-align: left !important;

        color: #32325d !important;

        font-size: 14px !important;
        font-weight: 600 !important;
    }

    /* =====================================================
       LABEL
       ===================================================== */

    .mobile_card_payment_table_1 tbody td::before,
    .mobile_card_payment_table_2 tbody td::before {

        content: attr(data-label) !important;

        display: block !important;

        margin-bottom: 5px !important;

        color: #8898aa !important;

        font-size: 10px !important;
        font-weight: 700 !important;

        letter-spacing: 0.9px !important;

        line-height: 1.2 !important;

        text-transform: uppercase !important;
    }

    /* =====================================================
       TRANSACTION ID
       ===================================================== */

    .mobile_card_payment_table_1 tbody td[data-label="TRANSACTION ID"],
    .mobile_card_payment_table_2 tbody td[data-label="TRANSACTION ID"] {

        padding-top: 2px !important;

        margin-bottom: 20px !important;

        font-size: 16px !important;

        font-weight: 700 !important;

        color: #32325d !important;
    }

    /* =====================================================
       NAME
       ===================================================== */

    .mobile_card_payment_table_1 tbody td[data-label="NAME"],
    .mobile_card_payment_table_2 tbody td[data-label="NAME"] {

        margin-bottom: 20px !important;

        font-size: 14px !important;

        font-weight: 600 !important;

        color: #525f7f !important;
    }

    /* =====================================================
       DATE + TIME
       ===================================================== */

    .mobile_card_payment_table_1 tbody td[data-label="DATE"],
    .mobile_card_payment_table_1 tbody td[data-label="TIME"],
    .mobile_card_payment_table_2 tbody td[data-label="DATE"],
    .mobile_card_payment_table_2 tbody td[data-label="TIME"] {

        display: inline-block !important;

        vertical-align: top !important;

        width: 50% !important;

        margin-bottom: 20px !important;
    }

    .mobile_card_payment_table_1 tbody td[data-label="TIME"],
    .mobile_card_payment_table_2 tbody td[data-label="TIME"] {

        padding-left: 10px !important;
    }

    /* =====================================================
       AMOUNT
       ===================================================== */

    .mobile_card_payment_table_1 tbody td[data-label="AMOUNT"],
    .mobile_card_payment_table_2 tbody td[data-label="AMOUNT"] {

        display: block !important;

        width: 100% !important;

        padding-top: 15px !important;

        border-top: 1px solid #edf0f5 !important;

        font-size: 19px !important;

        font-weight: 800 !important;

        color: #2dce89 !important;
    }

    .mobile_card_payment_table_1 tbody td[data-label="AMOUNT"]::before,
    .mobile_card_payment_table_2 tbody td[data-label="AMOUNT"]::before {

        margin-bottom: 5px !important;

        color: #8898aa !important;

        font-size: 10px !important;
    }

    /* Remove text-right from Amount */
    .mobile_card_payment_table_1 tbody td.text-right,
    .mobile_card_payment_table_2 tbody td.text-right {

        /* text-align: left !important; */
    }


    /* =====================================================
       TOTAL
       ===================================================== */

    .mobile_card_payment_table_1 tfoot,
    .mobile_card_payment_table_2 tfoot {

        display: flex !important;

        align-items: center !important;
        justify-content: space-between !important;

        width: 100% !important;

        margin-top: 2px !important;

        padding: 15px 18px !important;

        background: #f8f9fe !important;

        border: 1px solid #e9edf5 !important;

        border-radius: 14px !important;
    }

    .mobile_card_payment_table_1 tfoot th,
    .mobile_card_payment_table_2 tfoot th {

        display: block !important;

        width: auto !important;

        padding: 0 !important;

        border: 0 !important;

        font-size: 13px !important;

        font-weight: 700 !important;

        color: #525f7f !important;
    }

    .mobile_card_payment_table_1 tfoot th.text-right,
    .mobile_card_payment_table_2 tfoot th.text-right {

        margin-left: auto !important;

        font-size: 16px !important;

        color: #32325d !important;
    }

}

@media (max-width: 767.98px) {

    /* ================================
       DATE + TIME SAME ROW
       50% / 50%
       ================================ */

    .mobile_card_payment_table_1 tbody tr,
    .mobile_card_payment_table_2 tbody tr {
        display: block !important;
        width: 100% !important;
    }

    /* DATE */
    .mobile_card_payment_table_1 tbody td[data-label="DATE"],
    .mobile_card_payment_table_2 tbody td[data-label="DATE"] {
        display: inline-block !important;
        vertical-align: top !important;

        width: 40% !important;
        max-width: 50% !important;

        box-sizing: border-box !important;

        margin: 0 !important;
        padding: 0 8px 20px 0 !important;

        text-align: left !important;
    }

    /* TIME */
    .mobile_card_payment_table_1 tbody td[data-label="TIME"],
    .mobile_card_payment_table_2 tbody td[data-label="TIME"] {
        display: inline-block !important;
        vertical-align: top !important;

        width: 40% !important;
        max-width: 50% !important;

        box-sizing: border-box !important;

        margin: 0 !important;
        padding: 0 0 20px 8px !important;

        text-align: left !important;
    }

}
</style>

<div class="container-fluid mb-5 content-div">
    <div class="se-pre-con"></div>

    @if(session('success_msg'))
        <div class="alert alert-success fade in alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="font-size:20px">×</span>
            </button>
            {{ session('success_msg') }}
        </div>
    @endif

    @if(session('error_msg'))
        <div class="alert alert-danger fade in alert-dismissible show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="font-size:20px">×</span>
            </button>
            {{ session('error_msg') }}
        </div>
    @endif

    @section('back-btn')
        <a href="javascript:void(0);" class="home-btn-color goToHome" title="Back to Orders" data-value="{{$orderDetails->order_no}}">BACK TO ORDER {{$orderDetails->order_no}}</a>
    @endsection

    @section('back-btn-Mobile')
        <a href="javascript:void(0);" class="home-btn-color goToHome" title="Back to Orders" data-value="{{$orderDetails->order_no}}">< BACK TO ORDER {{$orderDetails->order_no}}</a>
    @endsection

    <div class="back_home_mobile">
        <strong>
            @yield('back-btn-Mobile')
        </strong>
    </div>

    <div class="col-md-12 row mt-4 forPaymentStyles col-12">
        <div class="col-md-8 col-12">
            <div class="card mobile_card_div" style="border-radius: 0rem; border:none">
                <div class="col-md-12 header-style mt-3 ml-3 payment-method-header">
                    Payment Method
                </div>
                <div class="tab-container" style="width:100%;padding: 1rem;">
                    <ul class="nav nav-tabs ml-3" style="border: none">
                        <li class="nav-item">
                            <a class="nav-link nav-link2 active" id="tab-card" href="#card-tab" @if (!($paymentStatus == 0 || $paymentStatus == 1))  @if($cardAmount < 1) style="pointer-events: none;" @endif @endif>CARD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link2"  id="tab-check" href="#check-tab" @if (!($paymentStatus == 0 || $paymentStatus == 1))  @if($checkAmount < 1) style="pointer-events: none;" @endif @endif>CHECK</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link2" id="tab-venmo" href="#venmo-tab" @if (!($paymentStatus == 0 || $paymentStatus == 1))  @if($venmoAmount < 1) style="pointer-events: none;" @endif @endif>VENMO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link2" id="tab-paypal" href="#paypal-tab" @if (!($paymentStatus == 0 || $paymentStatus == 1))  @if($paypalAmount < 1) style="pointer-events: none;" @endif @endif>PAYPAL</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link2" id="tab-po" href="#po-tab" @if (!($paymentStatus == 0 || $paymentStatus == 1))  @if($paypalAmount < 1) style="pointer-events: none;" @endif @endif>PO</a>
                        </li>
                        @if(Gate::check('view Other Payments'))
                            <li class="nav-item">
                                <a class="nav-link nav-link2"  id="tab-other" href="#other-tab" @if (!($paymentStatus == 0 || $paymentStatus == 1))  @if($otherAmount < 1) style="pointer-events: none;" @endif @endif>OTHER</a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content mt-3">
                        <div class="tab-pane tab-pane2 active" id="card-tab" style="min-height: 30rem;">
                            <div class="row" style="height: 1px">
                                <div class="col-md-3 ml-auto text-right">
                                    <button class="payment-history-btn" data-toggle="modal" data-target="#PaymentHistoryModal" style="color: #b3b3b3;background-color:white;border:none;outline:unset; font-weight: 600;cursor:pointer;position: relative;top: -5rem;" >PAYMENT HISTORY</button>
                                </div>
                            </div>
                            @if ($paymentStatus == 0 || $paymentStatus == 1)
                                @if($cardPayments->count()  > 0)
                                    <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                        Card Payments
                                    </div>

                                    <table class="paymentSummaryTable mobile_card_payment_table_1">
                                        <thead>
                                            <th>TRANSACTION ID</th>
                                            <th>NAME</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th class="text-right">AMOUNT</th>
                                        </thead>
                                        @if ($cardPayments->isEmpty())
                                        @else
                                        <tbody>
                                            @foreach ($cardPayments as $cardPayment)
                                                <tr>
                                                    <td data-label="TRANSACTION ID">{{$cardPayment->transaction_id}}</td>
                                                    <td data-label="NAME">{{$cardPayment->name_on_card}}</td>
                                                    <td data-label="DATE">{{$cardPayment->created_at->format('m/d/Y')}}</td>
                                                    <td data-label="TIME">{{$cardPayment->created_at->format('H:m:s')}}</td>
                                                    <td data-label="AMOUNT" class="text-right">$ {{number_format($cardPayment->amount, 2)}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                        <tfoot>
                                            <th colspan="3">Total Amount</th>
                                            <th class="text-right">$ {{number_format($cardAmount, 2)}}</th>
                                        </tfoot>
                                    </table>
                                    @endif
                                <form id="payment-card-info" method="post" action="{{ route("dopay.online") }}">
                                    @csrf
                                    <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                    <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                                    <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                    <input type="hidden" name="artwork" value="{{ $artwork }}">
                                    <input type="hidden"  value="{{number_format((($orderDetails->order_total - $payment)/100*3), 2)}}">
                                    <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                    <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                    <div class="col-md-12 sub-header-style mt-2">
                                        Billing Details
                                    </div>
                                    <div class="row" style="padding-left: 15px;">
                                        <div class="col-md-4 col-6">
                                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{$orderDetails->contactDetails['first_name']}}" required />
                                        </div>

                                        <div class="col-md-4 col-6">
                                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{$orderDetails->contactDetails['last_name']}}" required />
                                        </div>

                                        {{-- <div class="col-md-6">
                                            <label for="company" class="form-label">Company</label>
                                            <input type="text" class="form-control" id="company" name="company" value="{{$orderDetails->organizationDetails['organization_name']}}" />
                                        </div> --}}
                                        <div class="col-md-4 col-6">
                                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="country" name="country" value="{{$orderDetails->country}}" required />
                                        </div>

                                        <div class="col-md-4 col-6">
                                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="state" name="state" value="{{$orderDetails->state}}" required />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="street" class="form-label">Street Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="street" name="street" value="{{$orderDetails->street}}" required />
                                        </div>

                                        <div class="col-md-4 col-6">
                                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="city" name="city" value="{{$orderDetails->city}}" required />
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <label for="zip_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{$orderDetails->postal_code}}" required />
                                        </div>
                                        <div class="col-md-4">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{$orderDetails->email}}" required />
                                        </div>

                                        <div class="col-md-4">
                                            <label for="phone" class="form-label">Phone No <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{$orderDetails->phone_no}}" required />
                                        </div>
                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Company: </label>
                                            <input type="text" class="form-control" id="company" name="company" value="{{$orderDetails->organizationDetails['organization_name']}}"/>
                                        </div>

                                        <div class="col-md-12 sub-header-style mt-5">
                                            Card Details
                                        </div>
                                    </div>
                                    <div class="col-md-12 row mobile_card_details" style="padding-right: 0px;">
                                        <div class="col-md-6">
                                            <label for="owner" class="form-label">Name on Card <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="owner" name="owner" value="{{ old('owner') }}" placeholder="Card Owner's Name" required />
                                        </div>
                                        <div class="col-md-6" style="padding-right: 0">
                                            <label for="cardNumber" class="form-label">Card Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="{{ old('cardNumber') }}" placeholder="Card Number" required />
                                        </div>
                                        <div class="col-md-3">
                                            <label for="expiration-month" class="form-label">Expiration Date <span class="text-danger">*</span></label>
                                            <div style="display: flex; width: 100%;">
                                                <select class="form-control mr-2" id="expiration-month" name="expiration-month">
                                                    @foreach($months as $k=>$v)
                                                    <option value="{{ $k }}" {{ old('expiration-month') == $k ? 'selected' : '' }}>{{ $v }}</option>
                                                    @endforeach
                                                </select>
                                                <select class="form-control" id="expiration-year" name="expiration-year">
                                                    @for($i = date('Y'); $i <= (date('Y') + 15); $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mobile_CVV" style="padding-left: 0">
                                            <label for="cvv" class="form-label">CVV: <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="cvv" name="cvv" value="{{ old('cvv') }}" placeholder="CVV" required />
                                        </div>
                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Order #:</label>
                                            <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                            <input type="text" class="form-control" name="order_no" value="{{$orderDetails->order_no}}" readonly />
                                        </div>

                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Invoice Amount ($):</label>
                                            <input type="text" class="form-control" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" readonly />
                                            <input type="hidden" class="form-control" id="invoice_amount" value="{{$orderDetails->order_total - $payment}}" />
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-lable">Payment Amount ($): <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" onchange="updatePaymentDetails(this)" value="{{number_format(($orderDetails->order_total - $payment), 2)}}"/>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label class="form-lable">Card Processing Fee (3%) ($):</label>
                                            <input type="text" class="form-control" name="card_fee" id="card_processing_fee_showing" value="{{number_format((($orderDetails->order_total - $payment)/100*3), 2)}}" readonly />
                                            <input type="hidden" class="form-control" id="card_processing_fee" value="{{($orderDetails->order_total - $payment)/100*3}}" />
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-lable">Amount ($): <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control card_payment_amount" id="amount" name="amount" min="0" step='0.01' readonly/>
                                        </div>

                                    </div>

                                    <div class="col-lg-12 control-btns" style="background-color: white">
                                        <button style="display: none" type="submit" class="btn btn-success btn-custom" id="confirm-purchase-card">Confirm Payment</button>
                                    </div>
                                </form>
                            @else
                            <div>
                                <div class="col-md-12">
                                    @if($cardPayments->count()  > 0)
                                    <div class="row mt-2 mb-2" style="font-size: 1.2rem; color:green; font-weight:600; margin-left:1px">
                                        <i class="fas fa-check-circle">  Order Already Paid</i>

                                    </div>
                                    <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                        Card Payments
                                    </div>

                                    <table class="paymentSummaryTable mobile_card_payment_table_2">
                                        <thead>
                                            <th>TRANSACTION ID</th>
                                            <th>NAME</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th class="text-right">AMOUNT</th>
                                        </thead>
                                        @if ($cardPayments->isEmpty())
                                        @else
                                        <tbody>
                                            @foreach ($cardPayments as $cardPayment)
                                                <tr>
                                                    <td  data-label="TRANSACTION ID">{{$cardPayment->transaction_id}}</td>
                                                    <td data-label="NAME">{{$cardPayment->name_on_card}}</td>
                                                    <td data-label="DATE">{{$cardPayment->created_at->format('m/d/Y')}}</td>
                                                    <td data-label="TIME">{{$cardPayment->created_at->format('H:m:s')}}</td>
                                                    <td data-label="AMOUNT" class="text-right">$ {{number_format($cardPayment->amount, 2)}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                        <tfoot>
                                            <th colspan="3">Total Amount</th>
                                            <th class="text-right">$ {{number_format($cardAmount, 2)}}</th>
                                        </tfoot>
                                    </table>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane tab-pane2" id="check-tab" style="min-height: 30rem;">
                            <div class="row" style="height: 1px">
                                <div class="col-md-3 ml-auto text-right">
                                    <button data-toggle="modal" data-target="#PaymentHistoryModal" style="color: #b3b3b3;background-color:white;border:none;outline:unset; font-weight: 600;cursor:pointer;position: relative;top: -5rem;" >PAYMENT HISTORY</button>
                                </div>
                            </div>



                            @if ($paymentStatus == 0 || $paymentStatus == 1)
                                @if($checkPayments->where('is_approved', 0)->count() > 0)
                                <div style="padding-left: 1rem;padding-right: 1rem;">
                                <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                    Check Payments to approve
                                </div>
                                <table class="paymentSummaryTable mobile_check_payment_table_to_approve">
                                    <thead>
                                        <th>CHECK FRONT</th>
                                        <th>CHECK BACK</th>
                                        <th>DATE</th>
                                        <th>TIME</th>
                                        <th>PAID AMOUNT ($)</th>
                                        <th>TOTAL AMOUNT ($)</th>
                                        <th>PAYMENT APPROVAL</th>
                                    </thead>
                                    <tbody>
                                    @foreach ($checkPayments as $checkPayment)
                                                    @if($checkPayment->is_approved == 0)
                                                    <tr>
                                                        <td class="uploaded-checks">
                                                            <a href="{{asset('uploads')}}/../{{$checkPayment->check_front}}" download="{{$orderDetails->order_no}}-check-front.{{ pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) }}">
                                                                @if(pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) == 'pdf')
                                                                    <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                @else
                                                                    <img src="{{asset('uploads')}}/../{{$checkPayment->check_front}}" />
                                                                @endif
                                                            </a>
                                                        </td>
                                                        <td class="uploaded-checks">
                                                            <a href="{{asset('uploads')}}/../{{$checkPayment->check_back}}" download="{{$orderDetails->order_no}}-check-back.{{ pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) }}">
                                                                @if(pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) == 'pdf')
                                                                    <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                @else
                                                                    <img src="{{asset('uploads')}}/../{{$checkPayment->check_back}}" />
                                                                @endif
                                                            </a>
                                                        </td>
                                                        <td style="vertical-align: middle;">{{$checkPayment->created_at->format('m/d/Y')}}</td>
                                                        <td style="vertical-align: middle;">{{$checkPayment->created_at->format('H:m:s')}}</td>
                                                        <td style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->customer_paid_amount, 2)}}</td>
                                                        <td style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->amount, 2)}}</td>
                                                        <td style="vertical-align: middle;" class="text-center">
                                                            @if ($checkPayment->is_approved == 0)
                                                                <button type="button" class="btn btn-info btn-sm btn-custom approve-check" value="{{$checkPayment->id}}" data-toggle="modal" data-target="#exampleModalCheck">Approve</button>
                                                                @elseif($checkPayment->is_approved == 1)
                                                                <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true">&nbsp;&nbsp;Approved</i></button>
                                                                @else
                                                                <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true">&nbsp;&nbsp;Rejected</i></button>
                                                                @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                </div>
                                @else
                                @if($checkPayments->where('is_approved', '!=', 0)->count()  > 0)
                                    <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                        Check Payments
                                    </div>
                                    <table class="paymentSummaryTable mobile_check_payment_table">
                                        <thead>
                                            <th>CHECK FRONT</th>
                                            <th>CHECK BACK</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th>PAID AMOUNT ($)</th>
                                            <th>TOTAL AMOUNT ($)</th>
                                            <th>PAYMENT APPROVAL</th>
                                            <th>ACTION</th>
                                        </thead>
                                        @if ($checkPayments->isEmpty())
                                        @else
                                        <tbody>
                                        @foreach ($checkPayments as $checkPayment)
                                                        @if($checkPayment->is_approved !== 0)
                                                        <tr>
                                                            <td class="uploaded-checks">
                                                                <a href="{{ asset('uploads') }}/../{{$checkPayment->check_front}}" target="_blank">
                                                                    @if(pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) == 'pdf')
                                                                        <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                    @else
                                                                        <img src="{{ asset('uploads') }}/../{{$checkPayment->check_front}}" />
                                                                    @endif
                                                                </a>
                                                            </td>

                                                            <td class="uploaded-checks">
                                                                <a href="{{ asset('uploads') }}/../{{$checkPayment->check_back}}" target="_blank">
                                                                    @if(pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) == 'pdf')
                                                                        <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                    @else
                                                                        <img src="{{ asset('uploads') }}/../{{$checkPayment->check_back}}" />
                                                                    @endif
                                                                </a>
                                                            </td>
                                                            <td style="vertical-align: middle;">{{$checkPayment->created_at->format('m/d/Y')}}</td>
                                                            <td style="vertical-align: middle;">{{$checkPayment->created_at->format('H:m:s')}}</td>
                                                            <td style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->customer_paid_amount, 2)}}</td>
                                                            <td style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->amount, 2)}}</td>
                                                            <td style="vertical-align: middle;" class="text-center">
                                                                @if ($checkPayment->is_approved == 0)
                                                                    <button type="button" class="btn btn-info btn-sm btn-custom approve-check" value="{{$checkPayment->id}}" data-toggle="modal" data-target="#exampleModalCheck">Approve</button>
                                                                    @elseif($checkPayment->is_approved == 1)
                                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true">&nbsp;&nbsp;Approved</i></button>
                                                                    @else
                                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true">&nbsp;&nbsp;Rejected</i></button>
                                                                    @endif
                                                            </td>
                                                            <td class="uploaded-checks text-center align-middle">
                                                                <a href="{{ asset($checkPayment->check_front) }}"
                                                                download="{{$orderDetails->order_no}}-check-front.{{ pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) }}"
                                                                class="btn btn-sm btn-outline-primary m-1"
                                                                title="Download Front">
                                                                    <i class="fa fa-download"></i>
                                                                    <span class="d-none d-md-inline"> Front</span>
                                                                </a>

                                                                <a href="{{ asset($checkPayment->check_back) }}"
                                                                download="{{$orderDetails->order_no}}-check-back.{{ pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) }}"
                                                                class="btn btn-sm btn-outline-success m-1"
                                                                title="Download Back">
                                                                    <i class="fa fa-download"></i>
                                                                    <span class="d-none d-md-inline"> Back</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endif
                                        @endforeach
                                        </tbody>
                                        @endif
                                        <tfoot>
                                            <th colspan="4">Total Amount</th>
                                            <th class="text-right">$ {{number_format($checkAmount, 2)}}</th>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                    @endif
                                <form id="payment-check-info" method="post" action="{{ route("payment.check") }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                    <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                                    <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                    <input type="hidden" name="artwork" value="{{ $artwork }}">
                                    <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                                    <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                    <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                    <div class="col-md-12 row">
                                        <div class="col-md-12 mt-3">
                                            <label class="form-lable">Please indicate the amount that has been paid.<span class="text-danger">*</span></label>
                                            <input style="width: 50%;" type="number" class="form-control" name="check_customer_paid_amount" id="check_customer_paid_amount" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" step="0.01" required/>
                                        </div>
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="form-lable">Front Side Of Your Check Uploaded</label>
                                            <div id="check_front_preview">
                                                <img src="{{asset('argon')}}/img/icons/check.png" style="width: 100%; opacity: 0.5;" />
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="form-lable">Back Side Of Your Check Uploaded</label>
                                            <div id="check_back_preview">
                                                <img src="{{asset('argon')}}/img/icons/check.png" style="width: 100%; opacity: 0.5;" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-lable">Front Side Of Your Check <span class="text-danger">*</span></label>
                                            <input type="file" style="display: none" class="form-control" name="check_front" id="check_front" onchange="encodeFrontFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />

                                            <label for="check_front" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3; background-color: #FCFCFC;">
                                                <i class="fas fa-cloud-upload-alt" style="font-size: 30px;"></i><br>
                                                Drag & drop your file here or <b>CLICK HERE</b>  to upload the front side of your check
                                            </label>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label class="form-lable">Back Side Of Your Check <span class="text-danger">*</span></label>
                                            <input type="file"style="display: none" class="form-control" name="check_back" id="check_back" onchange="encodeBackFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />


                                            <label for="check_back" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3; background-color: #FCFCFC;">
                                                <i class="fas fa-cloud-upload-alt" style="font-size: 30px;"></i><br>
                                                Drag & drop your file here or <b>CLICK HERE</b>  to upload the back side of your check
                                            </label>
                                        </div>

                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Order #:</label>
                                            <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                            <input type="text" class="form-control" name="order_no" value="{{$orderDetails->order_no}}" readonly/>
                                        </div>

                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Amount ($):</label>
                                            <input type="text" class="form-control" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" readonly>
                                            <input type="hidden" class="form-control" id="check_amount" value="{{($orderDetails->order_total - $payment)}}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 control-btns" style="background-color: white">
                                        <button style="display: none" type="submit" class="btn btn-success btn-custom" id="confirm-purchase-check">Confirm Payment</button>
                                    </div>
                                </form>
                                @endif
                            @else
                            <div>
                                <div class="col-md-12">

                                    @if($checkPayments->count()  > 0)
                                    <div class="row mt-2 mb-2" style="font-size: 1.2rem; color:green; font-weight:600; margin-left:1px">
                                        <i class="fas fa-check-circle">  Order Already Paid</i>
                                    </div>
                                    <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                        Check Payments
                                    </div>
                                    <table class="paymentSummaryTable">
                                        <thead>
                                            <th>CHECK FRONT</th>
                                            <th>CHECK BACK</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th>PAID AMOUNT ($)</th>
                                            <th>TOTAL AMOUNT ($)</th>
                                            <th>PAYMENT APPROVAL</th>
                                            <th>ACTION</th>
                                        </thead>
                                        @if ($checkPayments->isEmpty())
                                        @else
                                        <tbody>
                                        @foreach ($checkPayments as $checkPayment)
                                                        @if($checkPayment->is_approved !== 0)
                                                        <tr>
                                                            <td class="uploaded-checks">
                                                                <a href="{{ asset('uploads') }}/../{{$checkPayment->check_front}}" target="_blank">
                                                                    @if(pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) == 'pdf')
                                                                        <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                    @else
                                                                        <img src="{{ asset('uploads') }}/../{{$checkPayment->check_front}}" />
                                                                    @endif
                                                                </a>
                                                            </td>

                                                            <td class="uploaded-checks">
                                                                <a href="{{ asset('uploads') }}/../{{$checkPayment->check_back}}" target="_blank">
                                                                    @if(pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) == 'pdf')
                                                                        <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                    @else
                                                                        <img src="{{ asset('uploads') }}/../{{$checkPayment->check_back}}" />
                                                                    @endif
                                                                </a>
                                                            </td>
                                                            <td style="vertical-align: middle;">{{$checkPayment->created_at->format('m/d/Y')}}</td>
                                                            <td style="vertical-align: middle;">{{$checkPayment->created_at->format('H:m:s')}}</td>
                                                            <td style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->customer_paid_amount, 2)}}</td>
                                                            <td style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->amount, 2)}}</td>
                                                            <td style="vertical-align: middle;" class="text-center">
                                                                @if ($checkPayment->is_approved == 0)
                                                                    <button type="button" class="btn btn-info btn-sm btn-custom approve-check" value="{{$checkPayment->id}}" data-toggle="modal" data-target="#exampleModalCheck">Approve</button>
                                                                    @elseif($checkPayment->is_approved == 1)
                                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true">&nbsp;&nbsp;Approved</i></button>
                                                                    @else
                                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true">&nbsp;&nbsp;Rejected</i></button>
                                                                    @endif
                                                            </td>
                                                            <td class="uploaded-checks text-center align-middle">
                                                                <a href="{{ asset($checkPayment->check_front) }}"
                                                                download="{{$orderDetails->order_no}}-check-front.{{ pathinfo(storage_path($checkPayment->check_front), PATHINFO_EXTENSION) }}"
                                                                class="btn btn-sm btn-outline-primary m-1"
                                                                title="Download Front">
                                                                    <i class="fa fa-download"></i>
                                                                    <span class="d-none d-md-inline"> Front</span>
                                                                </a>

                                                                <a href="{{ asset($checkPayment->check_back) }}"
                                                                download="{{$orderDetails->order_no}}-check-back.{{ pathinfo(storage_path($checkPayment->check_back), PATHINFO_EXTENSION) }}"
                                                                class="btn btn-sm btn-outline-success m-1"
                                                                title="Download Back">
                                                                    <i class="fa fa-download"></i>
                                                                    <span class="d-none d-md-inline"> Back</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endif
                                        @endforeach
                                        </tbody>
                                        @endif
                                        <tfoot>
                                            <th colspan="4">Total Amount</th>
                                            <th class="text-right">$ {{number_format($checkAmount, 2)}}</th>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                    @endif

                                </div>
                            </div>
                            @endif
                        </div>
                        @if(Gate::check('view Other Payments'))
                        <div class="tab-pane tab-pane2" id="other-tab" style="min-height: 30rem;">
                            <div class="row" style="height: 1px">
                                <div class="col-md-3 ml-auto text-right">
                                    <button data-toggle="modal" data-target="#PaymentHistoryModal" style="color: #b3b3b3;background-color:white;border:none;outline:unset; font-weight: 600;cursor:pointer;position: relative;top: -5rem;" >PAYMENT HISTORY</button>
                                </div>
                            </div>



                            @if ($paymentStatus == 0 || $paymentStatus == 1)
                                @if($otherPayments->where('is_approved', '!=', 0)->count()  > 0)
                                    <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                        Other Payments
                                    </div>
                                    <table class="paymentSummaryTable mobile_other_table">
                                        <thead>
                                            <th class="text-center">DOCUMENT</th>
                                            <th class="text-center">DATE</th>
                                            <th class="text-center">TIME</th>
                                            <th class="text-center">DESCRIPTION</th>
                                            <th class="text-center">PAID AMOUNT ($)</th>
                                            <th class="text-center">DOWNLOAD</th>
                                        </thead>
                                        @if ($otherPayments->isEmpty())
                                        @else
                                        <tbody>
                                        @foreach ($otherPayments as $otherPayment)
                                                    @if($otherPayment->is_approved !== 0)
                                                        <tr>
                                                            <td class="uploaded-checks">
                                                                <a href="{{asset('uploads')}}/../{{$otherPayment->document_url}}" target="_blank">
                                                                    @if(pathinfo(storage_path($otherPayment->document_url), PATHINFO_EXTENSION) == 'pdf')
                                                                        <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                    @else
                                                                        <img src="{{asset('uploads')}}/../{{$otherPayment->document_url}}" />
                                                                    @endif
                                                                </a>
                                                            </td>
                                                            <td style="vertical-align: middle;">{{$otherPayment->created_at->format('m/d/Y')}}</td>
                                                            <td style="vertical-align: middle;">{{$otherPayment->created_at->format('H:m:s')}}</td>
                                                            <td style="vertical-align: middle;">{{$otherPayment->description}}</td>
                                                            <td style="vertical-align: middle;" class="text-right">$ {{number_format($otherPayment->amount, 2)}}</td>
                                                            <td style="vertical-align: middle;" class="text-center">
                                                                <a href="{{ asset($otherPayment->document_url) }}"
                                                                download="{{$orderDetails->order_no}}-other-payment.{{ pathinfo(storage_path($otherPayment->document_url), PATHINFO_EXTENSION) }}"
                                                                class="btn btn-sm btn-outline-primary"
                                                                title="Download Document">
                                                                    <i class="fa fa-download"></i>
                                                                    <span class="d-none d-md-inline"> Document</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                        @endforeach
                                        </tbody>
                                        @endif
                                        <tfoot>
                                            <th colspan="4">Total Amount</th>
                                            <th class="text-right">$ {{number_format($otherAmount, 2)}}</th>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                    @endif
                                <form id="payment-other-info" method="post" action="{{ route("payment.other") }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                    <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                                    <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                    <input type="hidden" name="artwork" value="{{ $artwork }}">
                                    <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                                    <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                    <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                    <div class="col-md-12 row">
                                        <div class="col-md-12 mt-3">
                                            <label class="form-lable">Please indicate the amount that has been paid.<span class="text-danger">*</span></label>
                                            <input style="width: 50%;" type="number" class="form-control" name="other_customer_paid_amount" id="other_customer_paid_amount" step="0.01" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" required/>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label class="form-lable">Description<span class="text-danger">*</span></label>
                                            <textarea style="width: 100%;border: 1px solid #DEDEDE;" name="payment_description" id="payment_description" cols="30" rows="3" required></textarea>
                                        </div>
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="form-lable">Front Side Of Your proofment</label>
                                            <div id="other_front_preview">
                                                <img src="{{asset('argon')}}/img/icons/check.png" style="width: 100%; opacity: 0.5;" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-lable">Front Side Of Your proofment </label>

                                            <input type="file" style="display: none" class="form-control" name="other_front" id="other_front" onchange="encodeOtherFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf"/>


                                            <label for="other_front" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3; background-color: #FCFCFC;">
                                                <i class="fas fa-cloud-upload-alt" style="font-size: 30px;"></i><br>
                                                Drag & drop your file here or <b>CLICK HERE</b>  to upload the front side of your proofment
                                            </label>
                                        </div>
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="form-lable">Back Side Of Your proofment</label>
                                            <div id="other_back_preview">
                                                <img src="{{asset('argon')}}/img/icons/check.png" style="width: 100%; opacity: 0.5;" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-lable">Back Side Of Your proofment </label>

                                            <input type="file" style="display: none" class="form-control" name="other_back" id="other_back" onchange="encodeOtherFileAsURL2(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf"/>


                                            <label for="other_back" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3; background-color: #FCFCFC;">
                                                <i class="fas fa-cloud-upload-alt" style="font-size: 30px;"></i><br>
                                                Drag & drop your file here or <b>CLICK HERE</b>  to upload the back side of your proofment
                                            </label>
                                        </div>

                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Order #:</label>
                                            <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                            <input type="text" class="form-control" name="order_no" value="{{$orderDetails->order_no}}" readonly/>
                                        </div>

                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Amount ($):</label>
                                            <input type="text" class="form-control" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" readonly>
                                            <input type="hidden" class="form-control" id="other_amount" value="{{($orderDetails->order_total - $payment)}}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 control-btns" style="background-color: white">
                                        <button style="display: none" type="submit" class="btn btn-success btn-custom" id="confirm-purchase-other">Confirm Payment</button>
                                    </div>
                                </form>
                            @else
                            <div>
                                <div class="col-md-12">

                                    @if($otherPayments->count()  > 0)
                                    <div class="row mt-2 mb-2" style="font-size: 1.2rem; color:green; font-weight:600; margin-left:1px">
                                        <i class="fas fa-check-circle">  Order Already Paid</i>
                                    </div>
                                    <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                        Other Payments
                                    </div>
                                    <table class="paymentSummaryTable mobile_other_table_2">
                                        <thead>
                                            <th class="text-center">DOCUMENT</th>
                                            <th class="text-center">DATE</th>
                                            <th class="text-center">TIME</th>
                                            <th class="text-center">DESCRIPTION</th>
                                            <th class="text-center">PAID AMOUNT ($)</th>
                                            <th class="text-center">DOWNLOAD</th>
                                        </thead>
                                        @if ($otherPayments->isEmpty())
                                        @else
                                        <tbody>
                                        @foreach ($otherPayments as $otherPayment)
                                                    @if($otherPayment->is_approved !== 0)
                                                        <tr>
                                                            <td class="uploaded-checks">
                                                                <a href="{{asset('uploads')}}/../{{$otherPayment->document_url}}" target="_blank">
                                                                    @if(pathinfo(storage_path($otherPayment->document_url), PATHINFO_EXTENSION) == 'pdf')
                                                                        <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                                    @else
                                                                        <img src="{{asset('uploads')}}/../{{$otherPayment->document_url}}" />
                                                                    @endif
                                                                </a>
                                                            </td>
                                                            <td style="vertical-align: middle;">{{$otherPayment->created_at->format('m/d/Y')}}</td>
                                                            <td style="vertical-align: middle;">{{$otherPayment->created_at->format('H:m:s')}}</td>
                                                            <td style="vertical-align: middle;">{{$otherPayment->description}}</td>
                                                            <td style="vertical-align: middle;" class="text-right">$ {{number_format($otherPayment->amount, 2)}}</td>
                                                            <td style="vertical-align: middle;" class="text-center">
                                                                <a href="{{ asset($otherPayment->document_url) }}"
                                                                download="{{$orderDetails->order_no}}-other-payment.{{ pathinfo(storage_path($otherPayment->document_url), PATHINFO_EXTENSION) }}"
                                                                class="btn btn-sm btn-outline-primary"
                                                                title="Download Document">
                                                                    <i class="fa fa-download"></i>
                                                                    <span class="d-none d-md-inline"> Document</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                        @endforeach
                                        </tbody>
                                        @endif
                                        <tfoot>
                                            <th colspan="4">Total Amount</th>
                                            <th class="text-right">$ {{number_format($otherAmount, 2)}}</th>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                    @endif

                                </div>
                            </div>
                            @endif
                        </div>
                        @endif
                        <div class="tab-pane tab-pane2" id="venmo-tab" style="min-height: 30rem;">
                            <div class="row" style="height: 1px">
                                <div class="col-md-3 ml-auto text-right">
                                    <button data-toggle="modal" data-target="#PaymentHistoryModal" style="color: #b3b3b3;background-color:white;border:none;outline:unset; font-weight: 600;cursor:pointer;position: relative;top: -5rem;" >PAYMENT HISTORY</button>
                                </div>
                            </div>

                            @if ($paymentStatus == 0 || $paymentStatus == 1)
                                @if($venmoPayments->where('is_approved', 0)->count() > 0)
                                <div style="padding-left: 1rem;padding-right: 1rem;">
                                <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                    Venmo Payments to approve
                                </div>
                                <table class="paymentSummaryTable mobile_venmo_payment_table_to_approve">
                                    <thead>
                                        <th>VENMO RECIPT</th>
                                        <th>DATE</th>
                                        <th>TIME</th>
                                        <th class="text-right">CUST. PAID AMOUNT</th>
                                        <th class="text-right">AMOUNT</th>
                                        <th class="text-center">APPROVE</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($venmoPayments as $venmoPayment)
                                            @if($venmoPayment->is_approved == 0)
                                            <tr>
                                                <td class="uploaded-checks">
                                                    <a href="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}" download="{{$orderDetails->order_no}}-venmo-receipt.{{ pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) }}">
                                                        @if(pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                            <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                        @else
                                                            <img src="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}" />
                                                        @endif
                                                    </a>
                                                </td>
                                                <td style="vertical-align: middle;">{{$venmoPayment->created_at->format('m/d/Y')}}</td>
                                                <td style="vertical-align: middle;">{{$venmoPayment->created_at->format('H:m:s')}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->customer_paid_amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-center">
                                                    @if ($venmoPayment->is_approved == 0)
                                                        <button type="button" class="btn btn-info btn-sm btn-custom approve-venmo" value="{{$venmoPayment->id}}" data-toggle="modal" data-target="#exampleModalVenmo">Approve</button>
                                                    @elseif($venmoPayment->is_approved == 1)
                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true">&nbsp;&nbsp;Approved</i></button>
                                                    @else
                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true">&nbsp;&nbsp;Rejected</i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                @else
                                @if($venmoPayments->where('is_approved', '!=', 0)->count()  > 0)
                                    <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                        Venmo Payments
                                    </div>
                                    <table class="paymentSummaryTable mobile_venmo_payment_table">
                                        <thead>
                                            <th>VENMO RECIPT</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th class="text-right">CUST. PAID AMOUNT</th>
                                            <th class="text-right">AMOUNT</th>
                                            <th class="text-center">APPROVE</th>
                                            <th class="text-center">DOWNLOAD</th>
                                        </thead>
                                        <tbody>
                                        @foreach ($venmoPayments as $venmoPayment)
                                            @if($venmoPayment->is_approved !== 0)
                                            <tr>
                                                <td class="uploaded-checks">
                                                    <a target="_blank" href="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}">
                                                        @if(pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                            <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                        @else
                                                            <img src="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}" />
                                                        @endif
                                                    </a>
                                                </td>
                                                <td style="vertical-align: middle;">{{$venmoPayment->created_at->format('m/d/Y')}}</td>
                                                <td style="vertical-align: middle;">{{$venmoPayment->created_at->format('H:m:s')}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->customer_paid_amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-center">
                                                    @if ($venmoPayment->is_approved == 0)
                                                        <button type="button" class="btn btn-info btn-sm btn-custom approve-venmo" value="{{$venmoPayment->id}}" data-toggle="modal" data-target="#exampleModalVenmo">Approve</button>
                                                    @elseif($venmoPayment->is_approved == 1)
                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;&nbsp;Approved</button>
                                                    @else
                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;&nbsp;Rejected</button>
                                                    @endif
                                                </td>
                                                <td class="uploaded-checks text-center align-middle">
                                                    <a href="{{ asset($venmoPayment->venmo_receipt) }}"
                                                    download="{{$orderDetails->order_no}}-venmo-receipt.{{ pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Download Receipt">
                                                        <i class="fa fa-download"></i>
                                                        <span class="d-none d-md-inline"> Receipt</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <th colspan="3">Total Amount</th>
                                            <th class="text-right">$ {{number_format($venmoAmount, 2)}}</th>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                    @endif
                                <form id="payment-venmo-info" method="post" action="{{ route("payment.venmo") }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                    <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                                    <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                    <input type="hidden" name="artwork" value="{{ $artwork }}">
                                    <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                                    <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                    <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                    <div class="col-md-12 row">
                                        <div class="col-md-12 mt-3">
                                            <label class="form-lable" style="width: 100%;font-size:16px"><b>Please Use Our Venmo Handle - "@Encore-custom"</b></label>

                                        </div>
                                        <div class="col-md-6 mt-3 d-flex align-items-center">
                                            <label class="form-lable">Please indicate the amount that has been paid.<span class="text-danger">*</span></label>
                                            <input style="width: 50%;margin-left:10px" type="number" class="form-control" name="venmo_customer_paid_amount" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" id="venmo_customer_paid_amount" step="0.01" required/>
                                        </div>
                                        <div class="col-md-6 mt-3 mb-3">
                                            <label class="form-lable">Uploaded Venmo Receipt</label>
                                            <div id="venmo_receipt_preview">
                                                <img src="{{asset('argon')}}/img/icons/check.png" style="width: auto; opacity: 0.5;max-height: 200px;" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-lable">Upload Venmo Receipt<span class="text-danger">*</span></label>
                                            <input type="file" style="display: none" class="form-control" style="height: calc(7.5rem + 1px) !important;" name="venmo_receipt" id="venmo_receipt" onchange="encodeVenmoFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                                            <label for="venmo_receipt" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3; background-color: #FCFCFC;">
                                                <i class="fas fa-cloud-upload-alt" style="font-size: 36px;"></i><br>
                                                Drag & drop your file here or <b>CLICK HERE</b>  to upload venmo recipt
                                            </label>

                                        </div>

                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Order #:</label>
                                            <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                            <input type="text" class="form-control" name="order_no" value="{{$orderDetails->order_no}}" readonly/>
                                        </div>

                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Amount ($):</label>
                                            <input type="text" class="form-control" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" readonly>
                                            <input type="hidden" class="form-control" id="venmo_amount" value="{{($orderDetails->order_total - $payment)}}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 control-btns" style="background-color: white">
                                        <button style="display: none" type="submit" class="btn btn-success btn-custom" id="confirm-purchase-venmo">Confirm Payment</button>
                                    </div>
                                </form>
                                @endif
                            @else
                                <div>
                                <div class="col-md-12">

                                    @if($venmoPayments->count()  > 0)
                                    <div class="row mt-2 mb-2" style="font-size: 1.2rem; color:green; font-weight:600; margin-left:1px">
                                        <i class="fas fa-check-circle">  Order Already Paid</i>
                                    </div>
                                    <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                        Venmo Payments
                                    </div>
                                    <table class="paymentSummaryTable mobile_venmo_payment_table_2">
                                        <thead>
                                            <th>VENMO RECIPT</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th class="text-right">CUST. PAID AMOUNT</th>
                                            <th class="text-right">AMOUNT</th>
                                            <th class="text-center">APPROVE</th>
                                            <th class="text-center">DOWNLOAD</th>
                                        </thead>
                                        <tbody>
                                        @foreach ($venmoPayments as $venmoPayment)
                                            @if($venmoPayment->is_approved !== 0)
                                            <tr>
                                                <td class="uploaded-checks">
                                                    <a target="_blank" href="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}">
                                                        @if(pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                            <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                        @else
                                                            <img src="{{asset('uploads')}}/../{{$venmoPayment->venmo_receipt}}" />
                                                        @endif
                                                    </a>
                                                </td>
                                                <td style="vertical-align: middle;">{{$venmoPayment->created_at->format('m/d/Y')}}</td>
                                                <td style="vertical-align: middle;">{{$venmoPayment->created_at->format('H:m:s')}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->customer_paid_amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-center">
                                                    @if ($venmoPayment->is_approved == 0)
                                                        <button type="button" class="btn btn-info btn-sm btn-custom approve-venmo" value="{{$venmoPayment->id}}" data-toggle="modal" data-target="#exampleModalVenmo">Approve</button>
                                                    @elseif($venmoPayment->is_approved == 1)
                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;&nbsp;Approved</button>
                                                    @else
                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;&nbsp;Rejected</button>
                                                    @endif
                                                </td>
                                                <td class="uploaded-checks text-center align-middle">
                                                    <a href="{{ asset($venmoPayment->venmo_receipt) }}"
                                                    download="{{$orderDetails->order_no}}-venmo-receipt.{{ pathinfo(storage_path($venmoPayment->venmo_receipt), PATHINFO_EXTENSION) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Download Receipt">
                                                        <i class="fa fa-download"></i>
                                                        <span class="d-none d-md-inline"> Receipt</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <th colspan="3">Total Amount</th>
                                            <th class="text-right">$ {{number_format($venmoAmount, 2)}}</th>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                    @endif

                                </div>
                            </div>
                            @endif
                        </div>
                        {{-- po tab --}}
                        <div class="tab-pane tab-pane2" id="po-tab" style="min-height: 30rem;">

                            <div style="padding-left: 1rem;padding-right: 1rem;">
                                <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                    Purchase Order{{ $PurchaseorderReceipts->count() > 1 ? 's' : '' }}
                                </div>

                                @if($PurchaseorderReceipts->isNotEmpty())
                                <table class="paymentSummaryTable mobile_po_table">
                                    <thead>
                                        <th>PO receipt</th>
                                        <th>DATE</th>
                                        <th>TIME</th>
                                        <th class="text-center">ORDER AMOUNT ($)</th>
                                        <th class="text-center">PAYMENT APPROVAL</th>
                                        <th class="text-center">DOWNLOAD</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($PurchaseorderReceipts as $PurchaseorderReceipt)
                                        <tr>
                                            <td class="uploaded-checks">
                                                <a href="{{asset('uploads')}}/../{{$PurchaseorderReceipt->receipt}}" target="_blank">
                                                    @if(pathinfo(storage_path($PurchaseorderReceipt->receipt), PATHINFO_EXTENSION) == 'pdf')
                                                        <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                    @else
                                                        <img src="{{asset('uploads')}}/../{{$PurchaseorderReceipt->receipt}}" />
                                                    @endif
                                                </a>
                                            </td>

                                            <td style="vertical-align: middle;">{{$PurchaseorderReceipt->created_at->format('m/d/Y')}}</td>
                                            <td style="vertical-align: middle;">{{$PurchaseorderReceipt->created_at->format('H:m:s')}}</td>
                                            <td style="vertical-align: middle;" class="text-center">$ {{number_format($PurchaseorderReceipt->amount, 2)}}</td>
                                            <td style="vertical-align: middle;" class="text-center">
                                                @if ($PurchaseorderReceipt->is_approved == 0)
                                                    <button type="button" class="btn btn-info btn-sm btn-custom approve-po" value="{{$PurchaseorderReceipt->id}}" data-toggle="modal" data-target="#exampleModalPO">Approve</button>
                                                @elseif($PurchaseorderReceipt->is_approved == 1)
                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true">&nbsp;&nbsp;Approved</i></button>
                                                @else
                                                    <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true">&nbsp;&nbsp;Rejected</i></button>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ asset($PurchaseorderReceipt->receipt) }}"
                                                download="{{$orderDetails->order_no}}-purchase-order-receipt.{{ pathinfo(storage_path($PurchaseorderReceipt->receipt), PATHINFO_EXTENSION) }}"
                                                class="btn btn-sm btn-outline-primary"
                                                title="Download Receipt">
                                                    <i class="fa fa-download"></i>
                                                    <span class="d-none d-md-inline"> Receipt</span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </div>

                            @php
                                $lastPO = $PurchaseorderReceipts->last();
                                $showPOForm = !$lastPO || (int) $lastPO->is_approved !== 1;
                            @endphp

                            @if($showPOForm)
                            <form method="post" action="{{ route("customer_payment.PO") }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                <input type="hidden" name="shipping" value="{{ $shipping }}">
                                <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                <input type="hidden" name="artwork" value="{{ $artwork }}">
                                <input type="hidden" name="processingFee" value="{{ $processingFee }}">
                                <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                <div class="col-md-12 row">
                                    <div class="col-md-12">
                                        <label class="form-lable">Upload Purchase Order Receipt<span class="text-danger">*</span></label>
                                        <input type="file" style="display: none" class="form-control" style="height: calc(7.5rem + 1px) !important;" name="PurchaseOrder_Receipt" id="PurchaseOrder_Receipt" onchange="encodePOFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                                        <label for="PurchaseOrder_Receipt" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3; background-color: #FCFCFC;">
                                            <i class="fas fa-cloud-upload-alt" style="font-size: 36px;"></i><br>
                                            Drag & drop your file here or <b>CLICK HERE</b> to upload purchase order receipt
                                        </label>
                                    </div>
                                    <div class="col-md-12 mt-3 mb-3">
                                        <label class="form-lable">Uploaded Purchase Order Receipt</label>
                                        <div id="purchase_order_receipt_preview">
                                            <img src="{{asset('argon')}}/img/icons/check.png" style="width: auto;opacity: 0.5;max-height: 200px;" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-field mt-3" style="display: none">
                                        <label class="form-lable">Order #:</label>
                                        <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                        <input type="text" class="form-control" name="order_no" value="{{$orderDetails->order_no}}" readonly/>
                                    </div>

                                    <div class="col-md-6 form-field mt-3" style="display: none">
                                        <label class="form-lable">Amount ($):</label>
                                        <input type="text" class="form-control" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" readonly>
                                        <input type="hidden" class="form-control" id="venmo_amount" value="{{($orderDetails->order_total - $payment)}}" />
                                    </div>
                                </div>

                                <div class="col-lg-12 control-btns" style="background-color: white">
                                    <button style="display: none" type="submit" class="btn btn-success btn-custom" id="confirm-purchase-po">Confirm Payment</button>
                                </div>
                            </form>
                            @endif
                        </div>
                                                {{-- end tab --}}

                        <div class="tab-pane tab-pane2" id="paypal-tab" style="min-height: 30rem;">
                            <div class="row" style="height: 1px">
                                <div class="col-md-3 ml-auto text-right">
                                    <button data-toggle="modal" data-target="#PaymentHistoryModal" style="color: #b3b3b3;background-color:white;border:none;outline:unset; font-weight: 600;cursor:pointer;position: relative;top: -5rem;">PAYMENT HISTORY</button>
                                </div>
                            </div>


                            @if ($paymentStatus == 0 || $paymentStatus == 1)
                                @if($paypalPayments->where('is_approved', 0)->count() > 0)
                                <div style="padding-left: 1rem;padding-right: 1rem;">
                                <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                    Paypal Payments to approve
                                </div>
                                <table class="paymentSummaryTable mobile_paypal_to_approve">
                                    <thead>
                                        <th>PAYPAL RECIPT</th>
                                        <th>DATE</th>
                                        <th>TIME</th>
                                        <th class="text-right">AMOUNT</th>
                                        <th class="text-center">APPROVE</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($paypalPayments as $paypalPayment)
                                        @if($paypalPayment->is_approved == 0)
                                            <tr>
                                                <td class="uploaded-checks">
                                                    <a href="{{asset('uploads')}}/../{{$paypalPayment->paypal_receipt}}" download="{{$orderDetails->order_no}}-paypal-receipt.{{ pathinfo(storage_path($paypalPayment->paypal_receipt), PATHINFO_EXTENSION) }}">
                                                        @if(pathinfo(storage_path($paypalPayment->paypal_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                            <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                        @else
                                                            <img src="{{asset('uploads')}}/../{{$paypalPayment->paypal_receipt}}" />
                                                        @endif
                                                    </a>
                                                </td>
                                                <td style="vertical-align: middle;">{{$paypalPayment->created_at->format('m/d/Y')}}</td>
                                                <td style="vertical-align: middle;">{{$paypalPayment->created_at->format('H:m:s')}}</td>
                                                <td style="vertical-align: middle;" class="text-right">$ {{number_format($paypalPayment->amount, 2)}}</td>
                                                <td style="vertical-align: middle;" class="text-center">
                                                    @if ($paypalPayment->is_approved == 0)
                                                        <button type="button" class="btn btn-info btn-sm btn-custom approve-paypal" value="{{$paypalPayment->id}}" data-toggle="modal" data-target="#exampleModalPaypal">Approve</button>
                                                        @elseif($paypalPayment->is_approved == 1)
                                                        <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true">&nbsp;&nbsp;Approved</i></button>
                                                        @else
                                                        <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true">&nbsp;&nbsp;Rejected</i></button>
                                                        @endif
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th colspan="2">Total Amount</th>
                                        <th class="text-right">$ {{number_format($paypalAmount, 2)}}</th>
                                        <td></td>
                                    </tfoot>
                                </table>
                                </div>
                                @else
                                @if($paypalPayments->where('is_approved', '!=', 0)->count() > 0)
                                    <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                        Paypal Payments
                                    </div>
                                    <table class="paymentSummaryTable mobile_paypal_table">
                                        <thead>
                                            <th>PAYPAL RECIPT</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th class="text-right">AMOUNT</th>
                                            <th class="text-center">APPROVE</th>
                                            <th class="text-center">DOWNLOAD</th>
                                        </thead>
                                        @if ($paypalPayments->isEmpty())
                                        @else
                                        <tbody>
                                            @foreach ($paypalPayments as $paypalPayment)
                                            @if($paypalPayment->is_approved !== 0)
                                                <tr>
                                                    <td class="uploaded-checks">
                                                        <a href="{{asset('uploads')}}/../{{$paypalPayment->paypal_receipt}}" target="_blank">
                                                            @if(pathinfo(storage_path($paypalPayment->paypal_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                                <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                            @else
                                                                <img src="{{asset('uploads')}}/../{{$paypalPayment->paypal_receipt}}" />
                                                            @endif
                                                        </a>
                                                    </td>
                                                    <td style="vertical-align: middle;">{{$paypalPayment->created_at->format('m/d/Y')}}</td>
                                                    <td style="vertical-align: middle;">{{$paypalPayment->created_at->format('H:m:s')}}</td>
                                                    <td style="vertical-align: middle;" class="text-right">$ {{number_format($paypalPayment->amount, 2)}}</td>
                                                    <td style="vertical-align: middle;" class="text-center">
                                                        @if ($paypalPayment->is_approved == 0)
                                                            <button type="button" class="btn btn-info btn-sm btn-custom approve-paypal" value="{{$paypalPayment->id}}" data-toggle="modal" data-target="#exampleModalPaypal">Approve</button>
                                                            @elseif($paypalPayment->is_approved == 1)
                                                            <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true">&nbsp;&nbsp;Approved</i></button>
                                                            @else
                                                            <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true">&nbsp;&nbsp;Rejected</i></button>
                                                            @endif
                                                    </td>
                                                    <td class="uploaded-checks text-center align-middle">
                                                        <a href="{{ asset($paypalPayment->paypal_receipt) }}"
                                                        download="{{$orderDetails->order_no}}-paypal-receipt.{{ pathinfo(storage_path($paypalPayment->paypal_receipt), PATHINFO_EXTENSION) }}"
                                                        class="btn btn-sm btn-outline-primary"
                                                        title="Download Receipt">
                                                            <i class="fa fa-download"></i>
                                                            <span class="d-none d-md-inline"> Receipt</span>
                                                        </a>
                                                    </td>

                                                </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                        @endif
                                        <tfoot>
                                            <th colspan="2">Total Amount</th>
                                            <th class="text-right">$ {{number_format($paypalAmount, 2)}}</th>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                    @endif
                                <form id="payment-paypal-info" method="post" action="{{ route("payment.paypal") }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="totalItemQty" value="{{ $totalItemQty }}">
                                    <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                                    <input type="hidden" name="shipping" value="{{ $shipping }}">
                                    <input type="hidden" name="salesTax" value="{{ $salesTax }}">
                                    <input type="hidden" name="artwork" value="{{ $artwork }}">
                                    <input type="hidden"  value="{{number_format((($orderDetails->order_total - $payment)/100*3), 2)}}">
                                    <input type="hidden" name="orderTotal" value="{{ $orderTotal }}">
                                    <input type="hidden" name="balancePayment" value="{{ $balancePayment }}">
                                    <div class="col-md-12 row">
                                        <div class="col-md-12 mt-2">
                                            <label class="form-lable" style="width: 100%;font-size:16px"><b>Please Use Our PayPal Handle - "Info@encorelacrosse.com"</b></label>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label class="form-lable">Payment Amount ($): <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" onchange="updatePaymentDetailsPaypal(this)" value="{{number_format(($orderDetails->order_total - $payment), 2)}}"/>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label class="form-lable">Card Processing Fee (3%) ($):</label>
                                            <input type="text" class="form-control" id="paypal_card_processing_fee_showing" name="paypal_fee" value="{{number_format((($orderDetails->order_total - $payment)/100*3), 2)}}" readonly>
                                            <input type="hidden" class="form-control" id="paypal_card_processing_fee" value="{{($orderDetails->order_total - $payment)/100*3}}" />
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <label class="form-lable">Amount</label>
                                            <input style="width: 50%;" type="number" class="form-control paypal_full_amount" id="paypal_amount" name="amount" min="0" step='0.01' readonly>
                                        </div>
                                        <div class="col-md-12 mt-3 mb-3">
                                            <label class="form-lable">Paypal Recipt Uploaded</label>
                                            <div id="paypal_receipt_preview">
                                                <img src="{{asset('argon')}}/img/icons/check.png" style="width: auto; opacity: 0.5;max-height: 200px;" />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-lable">Upload PayPal Receipt <span class="text-danger">*</span></label>
                                            <input type="file" style="display:none;" class="form-control" name="paypal_receipt" id="paypal_receipt" onchange="encodePaypalFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                                            <label for="paypal_receipt" class="custom-file-input-label mt-2" style="font-size: .7rem;height: calc(7.5rem + 1px) !important; border: 1px dotted #b3b3b3; width: 100%; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; cursor: pointer; color: #b3b3b3; background-color: #FCFCFC;">
                                                <i class="fas fa-cloud-upload-alt" style="font-size: 36px;"></i><br>
                                                Drag & drop your file here or <b>CLICK HERE</b>  to upload the paypal recipt
                                            </label>
                                        </div>

                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Order #:</label>
                                            <input type="hidden" class="form-control" name="order_id" value="{{$orderDetails->id}}"/>
                                            <input type="text" class="form-control" name="order_no" value="{{$orderDetails->order_no}}" readonly/>
                                        </div>

                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                            <label class="form-lable">Invoice Amount ($):</label>
                                            <input type="text" class="form-control" value="{{number_format(($orderDetails->order_total - $payment), 2)}}" readonly>
                                            <input type="hidden" class="form-control" id="paypal_invoice_amount" value="{{($orderDetails->order_total - $payment)}}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-12 control-btns" style="background-color: white">
                                        <button style="display: none" type="submit" class="btn btn-success btn-custom" id="confirm-purchase-paypal">Confirm Payment</button>
                                    </div>
                                </form>
                                @endif
                            @else
                            <div>
                                <div class="col-md-12">

                                    @if($paypalPayments->count() > 0)
                                    <div class="row mt-2 mb-2" style="font-size: 1.2rem; color:green; font-weight:600; margin-left:1px">
                                        <i class="fas fa-check-circle">  Order Already Paid</i>
                                    </div>
                                    <div class="row mt-2 mb-2" style="font-size: 1rem; color:black; font-weight:600; margin-left:1px">
                                        Paypal Payments
                                    </div>
                                    <table class="paymentSummaryTable mobile_paypal_table_2">
                                        <thead>
                                            <th>PAYPAL RECIPT</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th class="text-right">AMOUNT</th>
                                            <th class="text-center">APPROVE</th>
                                            <th class="text-center">DOWNLOAD</th>
                                        </thead>
                                        @if ($paypalPayments->isEmpty())
                                        @else
                                        <tbody>
                                            @foreach ($paypalPayments as $paypalPayment)
                                            @if($paypalPayment->is_approved !== 0)
                                                <tr>
                                                    <td class="uploaded-checks">
                                                        <a href="{{asset('uploads')}}/../{{$paypalPayment->paypal_receipt}}" target="_blank">
                                                            @if(pathinfo(storage_path($paypalPayment->paypal_receipt), PATHINFO_EXTENSION) == 'pdf')
                                                                <img src="{{ asset('argon') }}/img/icons/pdf_icon.png" class="navbar-brand-img" alt="PDF">
                                                            @else
                                                                <img src="{{asset('uploads')}}/../{{$paypalPayment->paypal_receipt}}" />
                                                            @endif
                                                        </a>
                                                    </td>
                                                    <td style="vertical-align: middle;">{{$paypalPayment->created_at->format('m/d/Y')}}</td>
                                                    <td style="vertical-align: middle;">{{$paypalPayment->created_at->format('H:m:s')}}</td>
                                                    <td style="vertical-align: middle;" class="text-right">$ {{number_format($paypalPayment->amount, 2)}}</td>
                                                    <td style="vertical-align: middle;" class="text-center">
                                                        @if ($paypalPayment->is_approved == 0)
                                                            <button type="button" class="btn btn-info btn-sm btn-custom approve-paypal" value="{{$paypalPayment->id}}" data-toggle="modal" data-target="#exampleModalPaypal">Approve</button>
                                                            @elseif($paypalPayment->is_approved == 1)
                                                            <button type="button" style="background-color: unset;border: none;outline: unset;color: #55A630;" disabled><i class="fa fa-check-circle" aria-hidden="true">&nbsp;&nbsp;Approved</i></button>
                                                            @else
                                                            <button type="button" style="background-color: unset;border: none;outline: unset;color: red;" disabled><i class="fa fa-times-circle" aria-hidden="true">&nbsp;&nbsp;Rejected</i></button>
                                                            @endif
                                                    </td>
                                                    <td class="uploaded-checks text-center align-middle">
                                                        <a href="{{ asset($paypalPayment->paypal_receipt) }}"
                                                        download="{{$orderDetails->order_no}}-paypal-receipt.{{ pathinfo(storage_path($paypalPayment->paypal_receipt), PATHINFO_EXTENSION) }}"
                                                        class="btn btn-sm btn-outline-primary"
                                                        title="Download Receipt">
                                                            <i class="fa fa-download"></i>
                                                            <span class="d-none d-md-inline"> Receipt</span>
                                                        </a>
                                                    </td>

                                                </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                        @endif
                                        <tfoot>
                                            <th colspan="2">Total Amount</th>
                                            <th class="text-right">$ {{number_format($paypalAmount, 2)}}</th>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 card tab-content mobile_payment_summery" style="border: none;border-radius:0rem;min-height: 30rem;">
            <div class="tab-pane tab-pane2 active" id="card-tab" style="height: 100%;">
                <div class="col-md-12 header-style mt-3" style="padding: 0">
                    Payment Summary - #{{$orderDetails->order_no}}
                </div>
                <div class="col-md-12 mt-3" style="padding: 0">
                    <table style="color: #717070; font-size:.8rem;width:100%; line-height: 2;border-bottom:1px solid #b3b3b3">
                        <tr>
                            <td>Invoice amount ($)</td>
                            <td class="text-right">{{number_format($orderDetails->sub_total, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Artwork & other fees ($)</td>
                            <td class="text-right">{{number_format($orderDetails->artwork, 2)}}</td>
                        </tr>
                        @php
                            if ($orderDetails->discountType == 2) {
                                $discountValue = $orderDetails->discount;
                            } else {
                                $totalWithoutdisc = $orderDetails->sub_total + $orderDetails->artwork;
                                $discountPercentage = $orderDetails->discount;
                                $discountValue = ($totalWithoutdisc / 100) * $discountPercentage;
                            }
                        @endphp

                        @if ($orderDetails->discount_hidation == 1)
                            <tr>
                                @if ($orderDetails->discountType == 2)
                                    <td>Discount value ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @elseif ($orderDetails->discountType == 1)
                                    <td>Discount value {{ $orderDetails->discount }}% ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @endif
                            </tr>
                        @endif
                        @php
                            if ($orderDetails->sub_total > 0)
                                $sales_tax = $orderDetails->sales_tax;
                            else
                                $sales_tax = 0;
                        @endphp
                        <tr style="vertical-align: bottom;font-weight:700;height:40px">
                            <td>Total invoice amount ($)</td>
                            <td class="text-right">{{number_format(($orderDetails->sub_total + $orderDetails->artwork - $discountValue),2)}}</td>
                        </tr>
                        <tr>
                            <td>Sales tax fee {{number_format(($orderDetails['organizationDetails']->sales_tax), 2)}}% ($)</td>
                            <td class="text-right">{{number_format($sales_tax, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Shipping fee ($)</td>
                            <td class="text-right">{{number_format($orderDetails->shipping, 2)}}</td>
                        </tr>
                        <tr style="line-height: 2;border-top: 1px solid #b3b3b3;">
                            <td style="color: black;font-weight: 700;">Grand Total <p style="color: grey;font-weight: 100;font-size: .6rem;margin:0">(Invoice amount + Sales Tax + shipping)</p></td>
                            <td class="text-right" style="color: black;font-weight: 700;">{{number_format($orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - $discountValue, 2)}}</td>
                        </tr>
                        @if($cardAmount || $checkAmount || $venmoAmount || $paypalAmount || $otherAmount)
                        <tr style="color: black;line-height: 1.5;">
                            <td style="font-size: .8rem;font-weight: 600;">Paid amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;color:green" class="text-right">{{number_format((($cardAmount/103*100) + $checkAmount  + $otherAmount + $venmoAmount + ($paypalAmount/103*100)), 2)}}</td>
                        </tr>
                        <tr>
                            <td>Paid processing fees ($)</td>
                            <td class="text-right">{{number_format((($cardAmount/103*3) + ($paypalAmount/103*3)), 2)}}</td>
                        </tr>
                        @endif
                        <tr style="height: 10px;"></tr>
                        <tr style="color: black;line-height: 1.5;border-top:1px solid #b3b3b3">
                            <td style="font-size: .8rem;font-weight: 600;">Balance invoice amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;" class="text-right">{{number_format($balnceToBePaid, 2)}} </td>
                        </tr>

                        @php
                            if ($orderDetails->sub_total > 0)
                                $balanceDue = $orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - ($cardAmount/103*100) - $checkAmount - $otherAmount - $venmoAmount - ($paypalAmount/103*100) - $discountValue;
                            else
                                $balanceDue = 0;
                        @endphp

                        @php
                            if ($orderDetails->sub_total > 0)
                                $processing_fee = $balanceDue * 3 / 100;
                            else
                                $processing_fee = 0;
                        @endphp

                        @if(number_format(($balanceDue), 2) > 0)
                        <tr>
                            <td>Processing fee 3% ($)</td>
                            <td class="text-right">{{number_format($processing_fee, 2)}}</td>
                        </tr>
                        <tr style="color: black;">
                            <td style="font-size: .8rem;font-weight: 600;">Total amount to pay ($)</td>
                            <td style="font-size:16px; font-weight: 700; color:red" id="amount" class="text-right">{{number_format(($balanceDue + $processing_fee), 2)}}</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-12 text-right" style="padding-right: 0px">
                    <button type="button" class="btn btn-success btn-custom mt-2" onclick="submitCardForm()" @if($paymentStatus !== 0 && $paymentStatus !== 1) disabled @endif @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) disabled @endif> @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) <i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp; @endif CONFIRM & PAY</button>
                </div>
                <div class="col-md-12 form-field mobile_form_field" style="padding: 0; position: absolute; bottom: 0;height: 60px;">
                    <div class="row ml-1 mt-3" style="margin-bottom: 0rem !important;border-top: 1px solid #b3b3b3;margin-right:2rem">
                        <div class="col-md-12 mt-3" style="padding: 0px">
                            <img src="{{asset('argon')}}/img/icons/visa.png" style="height: 30px;" />
                            <img src="{{asset('argon')}}/img/icons/mastercard.png" class="ml-1" style="height: 30px;" />
                            <img src="{{asset('argon')}}/img/icons/american_express.png" class="ml-1" style="height: 30px;" />
                            <img src="{{asset('argon')}}/img/icons/discover.png" class="ml-1" style="height: 30px;" />
                        </div>

                        <div class="col-md-12 mt-2" style="padding: 0px"><p style="color: #5a5a5a;font-size:.7rem;line-height:1rem"><i style="color: blue" class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;<b style="font-weight: 700">DISCLAIMER</b> <br/> 3% processing fee will be added to all card payments.</p></div>


                    </div>
                </div>
            </div>
            <div class="tab-pane tab-pane2" id="check-tab" style="height: 100%;min-height: 30rem;">
                <div class="col-md-12 header-style mt-3" style="padding: 0">
                    Payment Summary - #{{$orderDetails->order_no}}
                </div>
                <div class="col-md-12 mt-3" style="padding: 0">
                    <table style="color: #717070; font-size:.8rem;width:100%;line-height: 2;border-bottom:1px solid #b3b3b3">
                        <tr>
                            <td>Invoice amount ($)</td>
                            <td class="text-right">{{number_format($orderDetails->sub_total, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Artwork & other fees ($)</td>
                            <td class="text-right">{{number_format($orderDetails->artwork, 2)}}</td>
                        </tr>
                        @php
                            if ($orderDetails->discountType == 2) {
                                $discountValue = $orderDetails->discount;
                            } else {
                                $totalWithoutdisc = $orderDetails->sub_total + $orderDetails->artwork;
                                $discountPercentage = $orderDetails->discount;
                                $discountValue = ($totalWithoutdisc / 100) * $discountPercentage;
                            }
                        @endphp

                        @if ($orderDetails->discount_hidation == 1)
                            <tr>
                                @if ($orderDetails->discountType == 2)
                                    <td>Discount value ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @elseif ($orderDetails->discountType == 1)
                                    <td>Discount value {{ $orderDetails->discount }}% ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @endif
                            </tr>
                        @endif
                        @php
                            if ($orderDetails->sub_total > 0)
                                $sales_tax = $orderDetails->sales_tax;
                            else
                                $sales_tax = 0;
                        @endphp
                        <tr style="vertical-align: bottom;font-weight:700;height:40px">
                            <td>Total invoice amount ($)</td>
                            <td class="text-right">{{number_format(($orderDetails->sub_total + $orderDetails->artwork - $discountValue),2)}}</td>
                        </tr>
                        <tr>
                            <td>Sales tax fee {{number_format(($orderDetails['organizationDetails']->sales_tax), 2)}}% ($)</td>
                            <td class="text-right">{{number_format($sales_tax, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Shipping fee ($)</td>
                            <td class="text-right">{{number_format($orderDetails->shipping, 2)}}</td>
                        </tr>
                        <tr style="line-height: 2;border-top: 1px solid #b3b3b3;">
                            <td style="color: black;font-weight: 700;">Grand Total <p style="color: grey;font-weight: 100;font-size: .6rem;margin:0">(Invoice amount + Sales Tax + shipping)</p></td>
                            <td class="text-right" style="color: black;font-weight: 700;">{{number_format($orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - $discountValue, 2)}}</td>
                        </tr>

                        @if($cardAmount || $checkAmount || $venmoAmount || $paypalAmount || $otherAmount)
                        <tr style="color: black;line-height: 1.5;">
                            <td style="font-size: .8rem;font-weight: 600;">Paid amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;color:green" class="text-right">{{number_format((($cardAmount/103*100) + $checkAmount + $otherAmount + $venmoAmount + ($paypalAmount/103*100)), 2)}}</td>
                        </tr>
                        @endif
                        <tr style="height: 10px;"></tr>
                        <tr style="color: black;line-height: 1.5;border-top:1px solid #b3b3b3">
                            <td style="font-size: .8rem;font-weight: 600;">Balance invoice amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;" class="text-right">{{number_format($balnceToBePaid, 2)}} </td>
                        </tr>

                        @php
                            if ($orderDetails->sub_total > 0)
                                $balanceDue = $orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - ($cardAmount/103*100) - $checkAmount - $otherAmount - $venmoAmount - ($paypalAmount/103*100) - $discountValue;
                            else
                                $balanceDue = 0;
                        @endphp
                        @if(number_format(($balanceDue), 2) > 0)
                        <tr style="color: black;">
                            <td style="font-size: .8rem;font-weight: 600;">Total amount to pay ($)</td>
                            <td style="font-size:16px; font-weight: 700; color:red" id="amount" class="text-right">{{number_format(($balanceDue), 2)}}</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-12 text-right" style="padding-right: 0px">
                    <button type="button" class="btn btn-success btn-custom mt-2" onclick="submitCheckForm()" @if($paymentStatus !== 0 && $paymentStatus !== 1) disabled @endif @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) disabled @endif> @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) <i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp; @endif CONFIRM & PAY</button>
                </div>

            </div>
            <div class="tab-pane tab-pane2" id="other-tab" style="height: 100%;min-height: 30rem;">
                <div class="col-md-12 header-style mt-3" style="padding: 0">
                    Payment Summary - #{{$orderDetails->order_no}}
                </div>
                <div class="col-md-12 mt-3" style="padding: 0">
                    <table style="color: #717070; font-size:.8rem;width:100%;line-height: 2;border-bottom:1px solid #b3b3b3">
                        <tr>
                            <td>Invoice amount ($)</td>
                            <td class="text-right">{{number_format($orderDetails->sub_total, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Artwork & other fees ($)</td>
                            <td class="text-right">{{number_format($orderDetails->artwork, 2)}}</td>
                        </tr>
                        @php
                            if ($orderDetails->discountType == 2) {
                                $discountValue = $orderDetails->discount;
                            } else {
                                $totalWithoutdisc = $orderDetails->sub_total + $orderDetails->artwork;
                                $discountPercentage = $orderDetails->discount;
                                $discountValue = ($totalWithoutdisc / 100) * $discountPercentage;
                            }
                        @endphp

                        @if ($orderDetails->discount_hidation == 1)
                            <tr>
                                @if ($orderDetails->discountType == 2)
                                    <td>Discount value ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @elseif ($orderDetails->discountType == 1)
                                    <td>Discount value {{ $orderDetails->discount }}% ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @endif
                            </tr>
                        @endif
                        @php
                            if ($orderDetails->sub_total > 0)
                                $sales_tax = $orderDetails->sales_tax;
                            else
                                $sales_tax = 0;
                        @endphp
                        <tr style="vertical-align: bottom;font-weight:700;height:40px">
                            <td>Total invoice amount ($)</td>
                            <td class="text-right">{{number_format(($orderDetails->sub_total + $orderDetails->artwork - $discountValue),2)}}</td>
                        </tr>
                        <tr>
                            <td>Sales tax fee {{number_format(($orderDetails['organizationDetails']->sales_tax), 2)}}% ($)</td>
                            <td class="text-right">{{number_format($sales_tax, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Shipping fee ($)</td>
                            <td class="text-right">{{number_format($orderDetails->shipping, 2)}}</td>
                        </tr>
                        <tr style="line-height: 2;border-top: 1px solid #b3b3b3;">
                            <td style="color: black;font-weight: 700;">Grand Total <p style="color: grey;font-weight: 100;font-size: .6rem;margin:0">(Invoice amount + Sales Tax + shipping)</p></td>
                            <td class="text-right" style="color: black;font-weight: 700;">{{number_format($orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - $discountValue, 2)}}</td>
                        </tr>


                        @if($cardAmount || $checkAmount || $venmoAmount || $paypalAmount || $otherAmount)
                        <tr style="color: black;line-height: 1.5;">
                            <td style="font-size: .8rem;font-weight: 600;">Paid amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;color:green" class="text-right">{{number_format((($cardAmount/103*100) + $checkAmount + $otherAmount + $venmoAmount + ($paypalAmount/103*100)), 2)}}</td>
                        </tr>
                        @endif
                        <tr style="height: 10px;"></tr>
                        <tr style="color: black;line-height: 1.5;border-top:1px solid #b3b3b3">
                            <td style="font-size: .8rem;font-weight: 600;">Balance invoice amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;" class="text-right">{{number_format($balnceToBePaid, 2)}} </td>
                        </tr>

                        @php
                            if ($orderDetails->sub_total > 0)
                                $balanceDue = $orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - ($cardAmount/103*100) - $checkAmount - $otherAmount - $venmoAmount - ($paypalAmount/103*100) - $discountValue;
                            else
                                $balanceDue = 0;
                        @endphp
                        @if(number_format(($balanceDue), 2) > 0)
                        <tr style="color: black;">
                            <td style="font-size: .8rem;font-weight: 600;">Total amount to pay ($)</td>
                            <td style="font-size:16px; font-weight: 700; color:red" id="amount" class="text-right">{{number_format(($balanceDue), 2)}}</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-12 text-right" style="padding-right: 0px">
                    <button type="button" class="btn btn-success btn-custom mt-2" onclick="submitOtherForm()" @if($paymentStatus !== 0 && $paymentStatus !== 1) disabled @endif @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) disabled @endif> @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) <i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp; @endif CONFIRM & PAY</button>
                </div>

            </div>
            <div class="tab-pane tab-pane2" id="venmo-tab" style="height: 100%;min-height: 30rem;">
                <div class="col-md-12 header-style mt-3" style="padding: 0">
                    Payment Summary - #{{$orderDetails->order_no}}
                </div>
                <div class="col-md-12 mt-3" style="padding: 0">
                    <table style="color: #717070; font-size:.8rem;width:100%;line-height: 2;border-bottom:1px solid #b3b3b3">
                        <tr>
                            <td>Invoice amount ($)</td>
                            <td class="text-right">{{number_format($orderDetails->sub_total, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Artwork & other fees ($)</td>
                            <td class="text-right">{{number_format($orderDetails->artwork, 2)}}</td>
                        </tr>
                        @php
                            if ($orderDetails->discountType == 2) {
                                $discountValue = $orderDetails->discount;
                            } else {
                                $totalWithoutdisc = $orderDetails->sub_total + $orderDetails->artwork;
                                $discountPercentage = $orderDetails->discount;
                                $discountValue = ($totalWithoutdisc / 100) * $discountPercentage;
                            }
                        @endphp

                        @if ($orderDetails->discount_hidation == 1)
                            <tr>
                                @if ($orderDetails->discountType == 2)
                                    <td>Discount value ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @elseif ($orderDetails->discountType == 1)
                                    <td>Discount value {{ $orderDetails->discount }}% ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @endif
                            </tr>
                        @endif
                        @php
                            if ($orderDetails->sub_total > 0)
                                $sales_tax = $orderDetails->sales_tax;
                            else
                                $sales_tax = 0;
                        @endphp
                        <tr style="vertical-align: bottom;font-weight:700;height:40px">
                            <td>Total invoice amount ($)</td>
                            <td class="text-right">{{number_format(($orderDetails->sub_total + $orderDetails->artwork - $discountValue),2)}}</td>
                        </tr>
                        <tr>
                            <td>Sales tax fee {{number_format(($orderDetails['organizationDetails']->sales_tax), 2)}}% ($)</td>
                            <td class="text-right">{{number_format($sales_tax, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Shipping fee ($)</td>
                            <td class="text-right">{{number_format($orderDetails->shipping, 2)}}</td>
                        </tr>
                        <tr style="line-height: 2;border-top: 1px solid #b3b3b3;">
                            <td style="color: black;font-weight: 700;">Grand Total <p style="color: grey;font-weight: 100;font-size: .6rem;margin:0">(Invoice amount + Sales Tax + shipping)</p></td>
                            <td class="text-right" style="color: black;font-weight: 700;">{{number_format($orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - $discountValue, 2)}}</td>
                        </tr>

                        @if($cardAmount || $checkAmount || $venmoAmount || $paypalAmount || $otherAmount)
                        <tr style="color: black;line-height: 1.5;">
                            <td style="font-size: .8rem;font-weight: 600;">Paid amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;color:green" class="text-right">{{number_format((($cardAmount/103*100) + $checkAmount + $otherAmount + $venmoAmount + ($paypalAmount/103*100)), 2)}}</td>
                        </tr>
                        @endif
                        <tr style="height: 10px;"></tr>
                        <tr style="color: black;line-height: 1.5;border-top:1px solid #b3b3b3">
                            <td style="font-size: .8rem;font-weight: 600;">Balance invoice amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;" class="text-right">{{number_format($balnceToBePaid, 2)}} </td>
                        </tr>

                        @php
                            if ($orderDetails->sub_total > 0)
                                $balanceDue = $orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - ($cardAmount/103*100) - $checkAmount - $otherAmount - $venmoAmount - ($paypalAmount/103*100) - $discountValue;
                            else
                                $balanceDue = 0;
                        @endphp
                        @if(number_format(($balanceDue), 2) > 0)
                        <tr style="color: black;">
                            <td style="font-size: .8rem;font-weight: 600;">Total amount to pay ($)</td>
                            <td style="font-size:16px; font-weight: 700; color:red" id="amount" class="text-right">{{number_format(($balanceDue), 2)}}</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-12 text-right" style="padding-right: 0px">
                    <button type="button" class="btn btn-success btn-custom mt-2" onclick="submitVenmoForm()" @if($paymentStatus !== 0 && $paymentStatus !== 1) disabled @endif @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) disabled @endif> @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) <i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp; @endif CONFIRM & PAY</button>
                </div>

            </div>

             {{-- po-tab --}}
             <div class="tab-pane tab-pane2" id="po-tab" style="height: 100%;min-height: 30rem;">
                <div class="col-md-12 title-header-style mt-3" style="padding: 0">
                    Payment Summary - #{{$orderDetails->order_no}}
                </div>
                <div class="col-md-12 mt-3" style="padding: 0">
                    <table style="color: #717070; font-size:.8rem;width:100%;line-height: 2;border-bottom:1px solid #b3b3b3">
                        <tr>
                            <td>Invoice amount ($)</td>
                            <td class="text-right">{{number_format($orderDetails->sub_total, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Artwork & other fees ($)</td>
                            <td class="text-right">{{number_format($orderDetails->artwork, 2)}}</td>
                        </tr>
                        @php
                            if ($orderDetails->discountType == 2) {
                                $discountValue = $orderDetails->discount;
                            } else {
                                $totalWithoutdisc = $orderDetails->sub_total + $orderDetails->artwork;
                                $discountPercentage = $orderDetails->discount;
                                $discountValue = ($totalWithoutdisc / 100) * $discountPercentage;
                            }
                        @endphp

                        @if ($orderDetails->discount_hidation == 1)
                            <tr>
                                @if ($orderDetails->discountType == 2)
                                    <td>Discount value ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @elseif ($orderDetails->discountType == 1)
                                    <td>Discount value {{ $orderDetails->discount }}% ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @endif
                            </tr>
                        @endif
                        @php
                            if ($orderDetails->sub_total > 0)
                                $sales_tax = $orderDetails->sales_tax;
                            else
                                $sales_tax = 0;
                        @endphp
                        <tr style="vertical-align: bottom;font-weight:700;height:40px">
                            <td>Total invoice amount ($)</td>
                            <td class="text-right">{{number_format(($orderDetails->sub_total + $orderDetails->artwork - $discountValue),2)}}</td>
                        </tr>
                        <tr>
                            <td>Sales tax fee {{number_format(($orderDetails['organizationDetails']->sales_tax), 2)}}% ($)</td>
                            <td class="text-right">{{number_format($sales_tax, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Shipping fee ($)</td>
                            <td class="text-right">{{number_format($orderDetails->shipping, 2)}}</td>
                        </tr>
                        <tr style="line-height: 2;border-top: 1px solid #b3b3b3;">
                            <td style="color: black;font-weight: 700;">Grand Total <p style="color: grey;font-weight: 100;font-size: .6rem;margin:0">(Invoice amount + Sales Tax + shipping)</p></td>
                            <td class="text-right" style="color: black;font-weight: 700;">{{number_format($orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - $discountValue, 2)}}</td>
                        </tr>

                        @if($cardAmount || $checkAmount || $venmoAmount || $paypalAmount || $otherAmount)
                        <tr style="color: black;line-height: 1.5;">
                            <td style="font-size: .8rem;font-weight: 600;">Paid amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;color:green" class="text-right">{{number_format((($cardAmount/103*100) + $checkAmount + $otherAmount + $venmoAmount + ($paypalAmount/103*100)), 2)}}</td>
                        </tr>
                        @endif
                        <tr style="height: 10px;"></tr>
                        <tr style="color: black;line-height: 1.5;border-top:1px solid #b3b3b3">
                            <td style="font-size: .8rem;font-weight: 600;">Balance invoice amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;" class="text-right">{{number_format(($orderDetails->sub_total - $discountValue + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - ($cardAmount/103*100) - $checkAmount - $otherAmount - $venmoAmount - ($paypalAmount/103*100) ), 2)}} </td>
                        </tr>

                        @php
                            if ($orderDetails->sub_total > 0)
                                $balanceDue = $orderDetails->sub_total - $discountValue + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - ($cardAmount/103*100) - $checkAmount - $otherAmount - $venmoAmount - ($paypalAmount/103*100) ;
                            else
                                $balanceDue = 0;
                        @endphp
                        @if(number_format(($balanceDue), 2) > 0)
                        {{-- <tr style="color: black;">
                            <td style="font-size: .8rem;font-weight: 600;">Total amount to pay ($)</td>
                            <td style="font-size:16px; font-weight: 700; color:red" id="amount" class="text-right">{{number_format(($balanceDue), 2)}}</td>
                        </tr> --}}
                        @endif
                    </table>
                </div>
                <div class="col-md-12 text-right" style="padding-right: 0px">
                    @php
                        $lastPO = $PurchaseorderReceipts->last();
                        $poStatus = $lastPO ? (int) $lastPO->is_approved : null;

                        $isDisabled = $paymentStatus !== 0 && $paymentStatus !== 1;
                        $isPendingApproval = $checkPayments->where('is_approved', 0)->count() > 0 ||
                                            $venmoPayments->where('is_approved', 0)->count() > 0 ||
                                            $paypalPayments->where('is_approved', 0)->count() > 0 ||
                                            $poStatus === 0;
                    @endphp

                    <button type="button" class="btn btn-success btn-custom mt-2" onclick="submitPOForm()"
                        @if($isDisabled || $poStatus === 0 || $poStatus === 1) disabled @endif>
                        @if($poStatus === 0)
                            <i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;
                        @endif
                        @if($poStatus === 1)
                            CONFIRMED
                        @else
                            CONFIRM PO
                        @endif
                    </button>
                </div>

            </div>
            {{-- po-tab --}}
            <div class="tab-pane tab-pane2" id="paypal-tab" style="height: 100%;min-height: 30rem;">
                <div class="col-md-12 header-style mt-3" style="padding: 0">
                    Payment Summary - #{{$orderDetails->order_no}}
                </div>
                <div class="col-md-12 mt-3" style="padding: 0">
                    <table style="color: #717070; font-size:.8rem;width:100%;line-height: 2;border-bottom:1px solid #b3b3b3">
                        <tr>
                            <td>Invoice amount ($)</td>
                            <td class="text-right">{{number_format($orderDetails->sub_total, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Artwork & other fees ($)</td>
                            <td class="text-right">{{number_format($orderDetails->artwork, 2)}}</td>
                        </tr>
                        @php
                            if ($orderDetails->discountType == 2) {
                                $discountValue = $orderDetails->discount;
                            } else {
                                $totalWithoutdisc = $orderDetails->sub_total + $orderDetails->artwork;
                                $discountPercentage = $orderDetails->discount;
                                $discountValue = ($totalWithoutdisc / 100) * $discountPercentage;
                            }
                        @endphp

                        @if ($orderDetails->discount_hidation == 1)
                            <tr>
                                @if ($orderDetails->discountType == 2)
                                    <td>Discount value ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @elseif ($orderDetails->discountType == 1)
                                    <td>Discount value {{ $orderDetails->discount }}% ($)</td>
                                    <td class="text-right">{{number_format($discountValue, 2)}}</td>
                                @endif
                            </tr>
                        @endif
                        @php
                            if ($orderDetails->sub_total > 0)
                                $sales_tax = $orderDetails->sales_tax;
                            else
                                $sales_tax = 0;
                        @endphp
                        <tr style="vertical-align: bottom;font-weight:700;height:40px">
                            <td>Total invoice amount ($)</td>
                            <td class="text-right">{{number_format(($orderDetails->sub_total + $orderDetails->artwork - $discountValue),2)}}</td>
                        </tr>
                        <tr>
                            <td>Sales tax fee {{number_format(($orderDetails['organizationDetails']->sales_tax), 2)}}% ($)</td>
                            <td class="text-right">{{number_format($sales_tax, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Shipping fee ($)</td>
                            <td class="text-right">{{number_format($orderDetails->shipping, 2)}}</td>
                        </tr>
                        <tr style="line-height: 2;border-top: 1px solid #b3b3b3;">
                            <td style="color: black;font-weight: 700;">Grand Total <p style="color: grey;font-weight: 100;font-size: .6rem;margin:0">(Invoice amount + Sales Tax + shipping)</p></td>
                            <td class="text-right" style="color: black;font-weight: 700;">{{number_format($orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - $discountValue, 2)}}</td>
                        </tr>

                        @if($cardAmount || $checkAmount || $venmoAmount || $paypalAmount || $otherAmount)
                        <tr style="color: black;line-height: 1.5;">
                            <td style="font-size: .8rem;font-weight: 600;">Paid amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;color:green" class="text-right">{{number_format((($cardAmount/103*100) + $checkAmount + $otherAmount + $venmoAmount + ($paypalAmount/103*100)), 2)}}</td>
                        </tr>
                        <tr>
                            <td>Paid processing fees ($)</td>
                            <td class="text-right">{{number_format((($cardAmount/103*3) + ($paypalAmount/103*3)), 2)}}</td>
                        </tr>
                        @endif
                        <tr style="height: 10px;"></tr>
                        <tr style="color: black;line-height: 1.5;border-top:1px solid #b3b3b3">
                            <td style="font-size: .8rem;font-weight: 600;">Balance invoice amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;" class="text-right">{{number_format($balnceToBePaid, 2)}} </td>
                        </tr>

                        @php
                            if ($orderDetails->sub_total > 0)
                                $balanceDue = $orderDetails->sub_total + $sales_tax + $orderDetails->shipping + $orderDetails->artwork - ($cardAmount/103*100) - $checkAmount - $otherAmount - $venmoAmount - ($paypalAmount/103*100) - $discountValue;
                            else
                                $balanceDue = 0;
                        @endphp

                        @php
                            if ($orderDetails->sub_total > 0)
                                $processing_fee = $balanceDue * 3 / 100;
                            else
                                $processing_fee = 0;
                        @endphp

                        @if(number_format(($balanceDue), 2) > 0)
                        <tr>
                            <td>Processing fee 3% ($)</td>
                            <td class="text-right">{{number_format($processing_fee, 2)}}</td>
                        </tr>
                        <tr style="color: black;">
                            <td style="font-size: .8rem;font-weight: 600;">Total amount to pay ($)</td>
                            <td style="font-size:16px; font-weight: 700; color:red" id="amount" class="text-right">{{number_format(($balanceDue + $processing_fee), 2)}}</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-12 text-right" style="padding-right: 0px">
                    <button type="button" class="btn btn-success btn-custom mt-2" onclick="submitPayPalForm()" @if($paymentStatus !== 0 && $paymentStatus !== 1) disabled @endif @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) disabled @endif> @if($checkPayments->where('is_approved', 0)->count() > 0 || $venmoPayments->where('is_approved', 0)->count() > 0 || $paypalPayments->where('is_approved', 0)->count() > 0) <i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp; @endif CONFIRM & PAY</button>
                </div>
                <div class="col-md-12 form-field mt-3" style="padding: 0; position: absolute; bottom: 0;">
                    <div class="row ml-1"  style="margin-bottom: 0rem !important;height: 60px;border-top: 1px solid #b3b3b3;margin-right:2rem">
                        <div class="col-md-12 mt-3">
                            <img src="{{asset('argon')}}/img/icons/payment-paypal.png" style="height: 23px;" />
                            {{-- <img src="{{asset('argon')}}/img/icons/mastercard.png" class="ml-1" style="height: 30px;" />
                            <img src="{{asset('argon')}}/img/icons/american_express.png" class="ml-1" style="height: 30px;" />
                            <img src="{{asset('argon')}}/img/icons/discover.png" class="ml-1" style="height: 30px;" /> --}}
                        </div>
                        <div class="col-md-12">

                            <p style="color: #5a5a5a;font-size:.7rem;line-height:1rem;margin-top:5px"><i style="color: blue" class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;<b style="font-weight: 700">DISCLAIMER</b> <br/> 3% processing fee will be added to all card payments.</p><br>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="position:fixed; z-index: 1070;" class="modal fade" id="exampleModalCheck" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title header-style" id="exampleModalLabel">Approve Check</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route("payment.check_approve") }}" id="approve_check_payment_form" class="col-md-12 mt-3">
                @csrf
                <input type="hidden" id="check_payment_id" name="check_payment_id">
                <input type="hidden" class="form-control" id="set_check_reject_status" name="is_approved" value="1">

                <div class="modal-body">
                    <div class="col-md-12 mt-2 mb-2" style="color: #787878">
                        Approve this check payment by entering the paid amount here.
                    </div>
                    <div class="col-md-12">
                        <input style="border-radius: 0rem" type="number" class="form-control" id="approve_check_amount" step="0.01" name="approve_amount" placeholder="" required />
                    </div>
                    <div class="row" style="padding: 1rem;">
                        <div class="col-md-12 mt-4 mb-2" id="reject_check_title" style="color: black;font-weight: 600; cursor: pointer;">
                            REJECT CHECK&nbsp;&nbsp;<i class="fa fa-chevron-right" id="reject_check_icon" aria-hidden="true"></i>
                        </div>
                        <div id="check_rejecting_div" style="display: none;">
                            <div class="col-md-12" style="color: #787878">
                                If you can't accept this check, please provide the reason for check rejecting.
                            </div>
                            <div class="col-md-12 form-field text-center">
                                <input style="border-radius: 0rem" type="text" class="form-control" name="reject_reason" placeholder="Reject reason" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: white">
                    <div class="col-lg-12 control-btns">
                        <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">Close</button>
                        <button type="button" id="reject_check_amount" class="btn btn-danger btn-custom">Reject</button>
                        <button type="submit" class="btn btn-success btn-custom">Approve</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div style="position:fixed; z-index: 1070;" class="modal fade" id="exampleModalPO" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title header-style" id="exampleModalLabel">Approve PO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route("po_approve_reject_payment") }}" id="approve_po_payment_form" class="col-md-12 mt-3">
                @csrf
                <input type="hidden" id="purchase_order_id" name="purchase_order_id">
                <input type="hidden" class="form-control" id="set_po_reject_status" name="is_approved" value="1">

                <div class="modal-body">
                    <div class="col-md-12 mt-2 mb-2" style="color: #787878">
                        Approve this purchase order by clicking approve button.
                    </div>

                    <div class="row" style="padding: 1rem;">
                        <div class="col-md-12 mt-4 mb-2" id="reject_po_title" style="color: black;font-weight: 600; cursor: pointer;">
                            REJECT PO&nbsp;&nbsp;<i class="fa fa-chevron-right" id="reject_po_icon" aria-hidden="true"></i>
                        </div>
                        <div id="po_rejecting_div" style="display: none;">
                            <div class="col-md-12" style="color: #787878">
                                If you can't accept this purchase order, please provide the reason for rejecting it.
                            </div>
                            <div class="col-md-12 form-field text-center">
                                <input style="border-radius: 0rem" type="text" class="form-control" name="reject_reason" placeholder="Reject reason"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: white">
                    <div class="col-lg-12 control-btns">
                        <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">Close</button>
                        <button type="button" id="reject_po_amount" class="btn btn-danger btn-custom">Reject</button>
                        <button type="submit" class="btn btn-success btn-custom">Approve</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div style="position:fixed; z-index: 1070;" class="modal fade" id="exampleModalVenmo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title header-style" id="exampleModalLabel">Approve venmo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route("payment.venmo_approve") }}" id="approve_venmo_payment_form" class="col-md-12 mt-3">
                @csrf
                <input type="hidden" id="venmo_payment_id" name="venmo_payment_id">
                <input type="hidden" class="form-control" id="set_venmo_reject_status" name="is_approved" value="1">
                <div class="modal-body">
                    <div class="col-md-12 mt-2 mb-2" style="color: #787878">
                        Approve this Venmo payment by entering the paid amount here.
                    </div>
                    <div class="col-md-12">
                        <input style="border-radius: 0rem" type="number" step="0.01" class="form-control" id="approve_venmo_amount" name="approve_amount" placeholder="" required />
                    </div>
                    <div class="row" style="padding: 1rem;">
                        <div class="col-md-12 mt-4 mb-2" id="reject_venmo_title" style="color: black;font-weight: 600;cursor:pointer">
                            REJECT VENMO&nbsp;&nbsp;<i class="fa fa-chevron-right" id="reject_venmo_icon" aria-hidden="true"></i>
                        </div>
                        <div id="venmo_rejecting_div" style="display: none">
                            <div class="col-md-12" style="color: #787878">
                                If you can't accept this Venmo payment, please provide the reason for rejecting it.
                            </div>
                            <div class="col-md-12 form-field text-center">
                                <input style="border-radius: 0rem" type="text" class="form-control" name="reject_reason" placeholder="Reject reason"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns" style="background-color: white">
                        <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">Close</button>
                        <button type="button" id="reject_venmo_amount" class="btn btn-danger btn-custom">Reject</button>
                        <button type="submit" class="btn btn-success btn-custom">Approve</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div style="position: fixed; z-index: 1070;" class="modal fade" id="exampleModalPaypal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title header-style" id="exampleModalLabel">
                    Approve PayPal
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route("payment.paypal_approve") }}" id="approve_paypal_payment_form" class="col-md-12 mt-3">
                @csrf
                <input type="hidden" id="paypal_payment_id" name="paypal_payment_id">
                <input type="hidden" class="form-control" id="set_paypal_reject_status" name="is_approved" value="1">

                <div class="modal-body">
                    <div class="col-md-12 mt-2 mb-2" style="color: #787878">
                        Approve this PayPal payment by clicking approve button.
                    </div>

                    <div class="col-md-12">
                        <label for="approve_paypal_amount" class="form-label" style="color: black;font-size: .8rem;">Paid Amount ($)</label>
                        <input style="border-radius: 0rem" type="number" step="0.01" class="form-control" id="approve_paypal_amount" name="approve_amount" placeholder="" required />
                    </div>

                    <div class="row" style="padding: 1rem;">
                        <div class="col-md-12 mt-4 mb-2" id="reject_paypal_title" style="color: black;font-weight: 600; cursor: pointer;">
                            REJECT PAYPAL&nbsp;&nbsp;<i class="fa fa-chevron-right" id="reject_paypal_icon" aria-hidden="true"></i>
                        </div>
                        <div id="paypal_rejecting_div" style="display: none">
                            <div class="col-md-12" style="color: #787878">
                                If you can't accept this PayPal payment, please provide the reason for rejecting it.
                            </div>
                            <div class="col-md-12">
                                <input style="border-radius: 0rem" type="text" class="form-control" name="reject_reason" placeholder="Reject reason" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="background-color: white">
                    <div class="col-lg-12 control-btns">
                        <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal">Close</button>
                        <button type="button" id="reject_paypal_amount" class="btn btn-danger btn-custom">Reject</button>
                        <button type="submit" class="btn btn-success btn-custom">Approve</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="PaymentHistoryModal" tabindex="-1" role="dialog" aria-labelledby="PaymentHistoryModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title header-style" id="exampleModalLabel">Payment History</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <table class="paymentSummaryTable">
                        <thead>
                            <th>TRANSACTION ID</th>
                            <th>PAYMENT TYPE</th>
                            <th>PAYMENT STATUS</th>
                            <th>DATE</th>
                            <th>TIME</th>
                            <th class="text-right">AMOUNT</th>
                        </thead>
                        @if($cardPayments->count() > 0 || $checkPayments->where('is_approved', 3)->count() > 0 || $venmoPayments->where('is_approved', 3)->count() > 0 || $paypalPayments->where('is_approved', 3)->count() > 0 || $checkPayments->where('is_approved', 1)->count() > 0 || $venmoPayments->where('is_approved', 1)->count() > 0 || $paypalPayments->where('is_approved', 1)->count() > 0 || $otherPayments->where('is_approved', 1)->count() > 0)
                        <tbody>
                            @foreach ($cardPayments as $cardPayment)
                                @if($cardPayment->is_approved !== 0)
                                <tr>
                                    <td>{{$cardPayment->transaction_id}}</td>
                                    <td>CARD</td>
                                    <td><span style="color: #2dce89">Completed</span></td>
                                    <td>{{$cardPayment->created_at->format('m/d/Y')}}</td>
                                    <td>{{$cardPayment->created_at->format('H:m:s')}}</td>
                                    <td class="text-right">$ {{number_format($cardPayment->amount, 2)}}</td>
                                </tr>
                                @endif
                            @endforeach
                            @foreach ($checkPayments as $checkPayment)
                                @if($checkPayment->is_approved !== 0)
                                                <tr>
                                                    <td>CHECK{{$checkPayment->id}}</td>
                                                    <td>CHECK</td>
                                                    <td>@if($checkPayment->is_approved == 1) <span style="color: #2dce89">Completed</span> @else <span style="color: #fb6340">Rejected</span> @endif </td>
                                                    <td style="vertical-align: middle;">{{$checkPayment->created_at->format('m/d/Y')}}</td>
                                                    <td style="vertical-align: middle;">{{$checkPayment->created_at->format('H:m:s')}}</td>
                                                    <td style="vertical-align: middle;" class="text-right">$ {{number_format($checkPayment->amount, 2)}}</td>
                                                </tr>
                                @endif
                            @endforeach
                            @foreach ($otherPayments as $otherPayment)
                                <tr>
                                    <td>OTHER{{$otherPayment->id}}</td>
                                    <td>OTHER</td>
                                    <td><span style="color: #2dce89">Completed</span></td>
                                    <td style="vertical-align: middle;">{{$otherPayment->created_at->format('m/d/Y')}}</td>
                                    <td style="vertical-align: middle;">{{$otherPayment->created_at->format('H:m:s')}}</td>
                                    <td style="vertical-align: middle;" class="text-right">$ {{number_format($otherPayment->amount, 2)}}</td>
                                </tr>
                            @endforeach
                            @foreach ($venmoPayments as $venmoPayment)
                            @if($venmoPayment->is_approved !== 0)
                                <tr>
                                    <td>VENMO{{$venmoPayment->id}}</td>
                                    <td>VENMO</td>
                                    <td>@if($venmoPayment->is_approved == 1) <span style="color: #2dce89">Completed</span> @else <span style="color: #fb6340">Rejected</span> @endif </td>
                                    <td style="vertical-align: middle;">{{$venmoPayment->created_at->format('m/d/Y')}}</td>
                                    <td style="vertical-align: middle;">{{$venmoPayment->created_at->format('H:m:s')}}</td>
                                    <td style="vertical-align: middle;" class="text-right">$ {{number_format($venmoPayment->amount, 2)}}</td>
                                </tr>
                            @endif
                            @endforeach
                            @foreach ($paypalPayments as $paypalPayment)
                            @if($paypalPayment->is_approved !== 0)
                                <tr>
                                    <td>PAYPAL{{$paypalPayment->id}}</td>
                                    <td>PAYPAL</td>
                                    <td>@if($paypalPayment->is_approved == 1) <span style="color: #2dce89">Completed</span> @else <span style="color: #fb6340">Rejected</span> @endif </td>
                                    <td style="vertical-align: middle;">{{$paypalPayment->created_at->format('m/d/Y')}}</td>
                                    <td style="vertical-align: middle;">{{$paypalPayment->created_at->format('H:m:s')}}</td>
                                    <td style="vertical-align: middle;" class="text-right">$ {{number_format($paypalPayment->amount, 2)}}</td>
                                </tr>
                            @endif
                            @endforeach
                        </tbody>
                        @else
                        <tbody>
                            <tr>
                                <td>No History Found</td>
                            </tr>
                        </tbody>

                        @endif
                    </table>
                </div>
                {{-- @if ($cardPayments->isEmpty())
                <div class="col-md-12"></div>
                @else
                    <div class="col-md-12 row">

                        <fieldset class="mt-3">
                            <legend>Payment Details</legend>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>Transaction Id</th>
                                        <th>Name</th>
                                        <th>Date / Time</th>
                                        <th class="text-right">Amount</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($cardPayments as $cardPayment)
                                            <tr>
                                                <td>{{$cardPayment->transaction_id}}</td>
                                                <td>{{$cardPayment->name_on_card}}</td>
                                                <td>{{$cardPayment->created_at->format('m-d-Y H:m:s')}}</td>
                                                <td class="text-right">$ {{number_format($cardPayment->amount, 2)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th colspan="3">Total Amount</th>
                                        <th class="text-right">$ {{number_format($cardAmount, 2)}}</th>
                                    </tfoot>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
</div>
{{-- <script>
    $(document).ready(function() {
        $('#POApprove').click(function() {
            var poId = $(this).data('poid'); // Get the data-poId attribute value
            $.ajax({
                url: "{{ url('Approve/po') }}/"+ poId, // Replace with your API endpoint
                type: 'get', // or 'GET' depending on your endpoint
                data: {
                    poId: poId
                },
                success: function(response) {
                    // Handle the response from the server
                    if(response.success){

                        Swal.fire({
                        icon: 'success',
                        title: 'Approved',
                        text: response.message
                    }).then((result) => {
                        // Reload the page after the alert is closed
                        if (result.value) {
                            window.location.reload();
                        }
                    });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any errors that occurred during the request
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while approving the purchase order.'
                    });
                }
            });
        });
    });
    </script> --}}
<script>
    function updatePaymentDetails(invoice_amount) {

    var invoiceAmount = parseFloat(invoice_amount.value);

    var cardProcessingFee = (invoiceAmount / 100) * 3;
    $('#card_processing_fee_showing').val(cardProcessingFee.toFixed(2)).trigger('change');

    var fullAmount = cardProcessingFee + invoiceAmount;
    $('.card_payment_amount').val(fullAmount.toFixed(2));

    }

    function updatePaymentDetailsPaypal(invoice_amount) {

    var invoiceAmount = parseFloat(invoice_amount.value);

    var cardProcessingFee = (invoiceAmount / 100) * 3;
    $('#paypal_card_processing_fee_showing').val(cardProcessingFee.toFixed(2));

    var fullAmount = cardProcessingFee + invoiceAmount;
    $('.paypal_full_amount').val(fullAmount.toFixed(2));

    }


    // Function to submit the PayPal form
    function submitPayPalForm() {
        $("#confirm-purchase-paypal").click();
    }

    // Function to submit the Venmo form
    function submitVenmoForm() {
        $("#confirm-purchase-venmo").click();
    }

    // Function to submit the Check form
    function submitCheckForm() {
        $("#confirm-purchase-check").click();
    }
    function submitOtherForm() {
        $("#confirm-purchase-other").click();
    }

    // Function to submit the Card form
    function submitCardForm() {
        $("#confirm-purchase-card").click();
    }
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
    const tabLinks = document.querySelectorAll('.nav-link2');
    const tabContents = document.querySelectorAll('.tab-pane2');

    tabLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            tabLinks.forEach(function (tabLink) {
                tabLink.classList.remove('active');
            });

            tabContents.forEach(function (tabContent) {
                tabContent.classList.remove('active');
            });

            const targetHref = this.getAttribute('href');
            const targetContents = document.querySelectorAll(targetHref);

            this.classList.add('active');
            targetContents.forEach(function (targetContent) {
                targetContent.classList.add('active');
            });
        });
    });
});


    function goBack() {
        window.history.back();
    }

    let header = "PAYMENT";
        document.getElementById("header").innerHTML = header;

    $(document).ready(function(){
        $('body').on('submit', function() {
            $(".se-pre-con").fadeIn();
        });

        $('.check-payment').hide();
        $('.venmo-payment').hide();
        $('.paypal-payment').hide();

        if(localStorage.getItem("showInvoice") == "Done")
        {
            localStorage.setItem("showInvoice", "NotDone");
            location.reload();
        }
        else{
            $(".se-pre-con").fadeOut('slow');
        }

        var invoice_amount = $('#invoice_amount').val();
        var card_processing_fee = $('#card_processing_fee').val();
        var total = parseFloat(invoice_amount) + parseFloat(card_processing_fee);
        console.log(total);
        $('#amount').val(total.toFixed(2));

        var invoice_amount = $('#paypal_invoice_amount').val();
        var card_processing_fee = $('#paypal_card_processing_fee').val();
        var total = parseFloat(invoice_amount) + parseFloat(card_processing_fee);
        $('#paypal_amount').val(total.toFixed(2));
    });

    function encodeFrontFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#check_front_preview").html(image);
        }

        reader.readAsDataURL(file);
    }

    function encodeBackFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#check_back_preview").html(image);
        }

        reader.readAsDataURL(file);
    }
    function encodeOtherFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#other_front_preview").html(image);
        }

        reader.readAsDataURL(file);
    }
    function encodeOtherFileAsURL2(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#other_back_preview").html(image);
        }

        reader.readAsDataURL(file);
    }

    function encodeVenmoFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#venmo_receipt_preview").html(image);
        }

        reader.readAsDataURL(file);
    }

    function encodePaypalFileAsURL(element) {
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            element.setAttribute('data-img-uri', reader.result);

            var image = "<img src='" + reader.result + "' style='max-width: 200px; max-height: 200px' alt='image_preview'/>";

            $("#paypal_receipt_preview").html(image);
        }

        reader.readAsDataURL(file);
    }

    $('.payment-type').on('change', function(){
        var paymentType = $(this).val();
        if (paymentType == 'card') {
            $('.check-payment').hide();
            $('.venmo-payment').hide();
            $('.paypal-payment').hide();
            $('.card-payment').show(700);

        } else if (paymentType == 'cash') {
            $('.card-payment').hide();
            $('.venmo-payment').hide();
            $('.paypal-payment').hide();
            $('.check-payment').show(700);
        } else if (paymentType == 'venmo') {
            $('.card-payment').hide();
            $('.check-payment').hide();
            $('.paypal-payment').hide();
            $('.venmo-payment').show(700);
        } else if (paymentType == 'paypal') {
            $('.card-payment').hide();
            $('.check-payment').hide();
            $('.venmo-payment').hide();
            $('.paypal-payment').show(700);
        }
    });

    $('.approve-check').on('click', function(){
        var checkId = $(this).val();
        // $('#approve_payment_form').attr('action', '{{ route("payment.check_approve") }}');
        // $('#approve_amount').attr('placeholder', 'Check Amount ($)');
        $('#check_payment_id').val(checkId);
    });

    $('.approve-venmo').on('click', function(){
        var checkId = $(this).val();
        // $('#approve_payment_form').attr('action', '{{ route("payment.venmo_approve") }}');
        // $('#approve_amount').attr('placeholder', 'Paid Amount ($)');
        $('#venmo_payment_id').val(checkId);
    });

    $('.approve-paypal').on('click', function(){
        var checkId = $(this).val();
        // $('#approve_payment_form').attr('action', '{{ route("payment.paypal_approve") }}');
        // $('#approve_amount').attr('placeholder', 'Paid Amount ($)');
        $('#paypal_payment_id').val(checkId);
    });

    $('.approve-po').on('click', function(){
        var poId = $(this).val();
        $('#purchase_order_id').val(poId);
    });

    $('#payment-card-info').on('submit', function(e){
        e.preventDefault();
        $(".se-pre-con").fadeIn('slow');
        this.submit();
    });
    $(document).ready(function () {
        $("#reject_check_amount").click(function () {
            $("#set_check_reject_status").val(3);
            $("#approve_check_payment_form").submit();
        });
    });
    $(document).ready(function () {
        $("#reject_venmo_amount").click(function () {
            $("#set_venmo_reject_status").val(3);
            $("#approve_venmo_payment_form").submit();
        });
    });
    $(document).ready(function () {
        $("#reject_paypal_amount").click(function () {
            $("#set_paypal_reject_status").val(3);
            $("#approve_paypal_payment_form").submit();
        });
    });
    $(document).ready(function () {
        $("#reject_po_amount").click(function () {
            var reasonVal = $("#approve_po_payment_form input[name='reject_reason']").val().trim();

            if (!reasonVal) {
                $("#po_rejecting_div").show();
                $("#reject_po_icon").removeClass("fa-chevron-right").addClass("fa-chevron-down");
                $("#approve_po_payment_form input[name='reject_reason']").focus();
                return;
            }

            $("#set_po_reject_status").val(3);
            $("#approve_po_payment_form").submit();
        });
    });
    $(document).ready(function () {
        $("#reject_venmo_title").click(function () {
            $("#venmo_rejecting_div").toggle();
            // Toggle the icon as well (if needed)
            $("#reject_venmo_icon").toggleClass("fa-chevron-right fa-chevron-down");
        });
    });
    $(document).ready(function () {
        $("#reject_paypal_title").click(function () {
            $("#paypal_rejecting_div").toggle();
            // Toggle the icon as well (if needed)
            $("#reject_paypal_icon").toggleClass("fa-chevron-right fa-chevron-down");
        });
    });
    $(document).ready(function () {
        $("#reject_po_title").click(function () {
            $("#po_rejecting_div").toggle();
            $("#reject_po_icon").toggleClass("fa-chevron-right fa-chevron-down");
        });
    });
    $(document).ready(function () {
        $("#reject_check_title").click(function () {
            $("#check_rejecting_div").toggle();
            // Toggle the icon as well (if needed)
            $("#reject_check_icon").toggleClass("fa-chevron-right fa-chevron-down");
        });
    });
    function encodePOFileAsURL(element) {
    var file = element.files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        var fileType = file.type;

        element.setAttribute('data-file-uri', reader.result);

        if (fileType.startsWith('image/')) {
            var image = "<img src='" + reader.result + "' style='width: 600px; height: 800px' alt='image_preview'/>";
            $("#purchase_order_receipt_preview").html(image);
        } else if (fileType === 'application/pdf') {
            var pdfData = atob(reader.result.split(',')[1]);
            var loadingTask = pdfjsLib.getDocument({data: pdfData});

            loadingTask.promise.then(function(pdf) {
                pdf.getPage(1).then(function(page) {
                    var scale = 1.5;
                    var viewport = page.getViewport({scale: scale});
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };

                    page.render(renderContext).promise.then(function() {
                        $("#purchase_order_receipt_preview").html(canvas);
                    });
                });
            }, function(reason) {
                console.error(reason);
            });
        } else {
            $("#purchase_order_receipt_preview").html('<p>Unsupported file type</p>');
        }
    }

    reader.readAsDataURL(file);
}
function submitPOForm() {
        Swal.fire({
        icon: 'success',
        title: 'Purchase Order Confirmed',
        text: 'Your purchase order has been successfully submitted. Our accounts department will now proceed with the approval process.',
        confirmButtonText: 'Ok',
        onClose: () => {
            // $(".se-pre-con").fadeIn();
            $("#confirm-purchase-po").click();
        }
    });}
</script>

<script>
    $(document).ready(function(){
        $("body").on("click", ".goToHome", function(){
            var orderId = $(this).data('value');
            window.open('order_details/edit/' + orderId + '/order?active_tab=order', '_self');
        });
    });


</script>
@endsection
