@extends('layouts.customer_team_store.app')

@section('content')

<style>
    .top-navbar {
        background-color: white;
        z-index: 99;
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .cart_topic_text {
        font-size: 33px;
    }
    .cart_items {
        padding-top: 15px;
        padding-bottom: 15px !important;
        border-bottom: 1px solid rgb(231, 231, 231);
    }
    .cart_summary {
        max-width: 35%;
        width: 35%;
    }
    .text_input {
        font-size: 12px;
        border: 1px solid #DEDEDE !important;
        border-radius: 0rem !important;
        color: #717070 !important;
    }
    .text_input_div {
        margin-top: 5px;
        margin-bottom: 5px;
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
    .save_continue_btn {
        padding-top: unset !important;
        padding-bottom: unset !important;
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    .back_edit_btn {
        padding-top: unset !important;
        padding-bottom: unset !important;
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    .details_card {
        padding: 10px;
        background-color: rgb(236, 236, 236);
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .completed-section {
        background-color: transparent !important;
        border: unset !important;
    }

    /* =========================================================
   PAYMENT / CHECKOUT PAGE
   MODERN MOBILE RESPONSIVE UI
   Desktop remains unchanged
   ========================================================= */

@media (max-width: 767.98px) {

    .top-navbar {
        padding: unset;
    }

    /* =====================================================
       MAIN WRAPPER
       ===================================================== */

    .forPaymentStyles {
        width: 100% !important;
        padding: 15px;
        box-sizing: border-box !important;
        padding-top: 70px !important;
    }

    .forPaymentStyles > .row {
        width: 100% !important;
        margin: 0 !important;
        display: flex !important;
        flex-direction: column !important;
    }


    /* =====================================================
       LEFT PAYMENT CARD
       ===================================================== */

    .forPaymentStyles .col-md-9 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
    }

    .forPaymentStyles .col-md-9 > .card {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        border: 1px solid #e7e7e7 !important;
        border-radius: 8px !important;
        background: #fff !important;
        box-shadow: 0 4px 18px rgba(0,0,0,.06) !important;
        overflow: hidden !important;
    }


    /* =====================================================
       PAYMENT METHOD TITLE
       ===================================================== */

    .forPaymentStyles .col-md-9 > .card > .header-style {
        margin: 17px 16px 0 !important;
        padding: 0 !important;
        font-size: 19px !important;
        line-height: 1.3 !important;
        font-weight: 700 !important;
    }


    /* =====================================================
       TAB
       ===================================================== */

    .forPaymentStyles .tab-container {
        width: 100% !important;
        padding: 10px 14px 16px !important;
        box-sizing: border-box !important;
    }

    .forPaymentStyles .nav-tabs {
        margin: 0 !important;
        border-bottom: 1px solid #ededed !important;
    }

    .forPaymentStyles .nav-tabs .nav-item {
        margin: 0 !important;
    }

    .forPaymentStyles .nav-tabs .nav-link {
        padding: 9px 18px !important;
        margin: 0 !important;
        border: none !important;
        border-bottom: 2px solid transparent !important;
        border-radius: 0 !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        letter-spacing: .3px !important;
    }

    .forPaymentStyles .nav-tabs .nav-link.active {
        border-bottom-color: currentColor !important;
    }

    .forPaymentStyles #card-tab {
        min-height: auto !important;
    }


    /* =====================================================
       FORM
       ===================================================== */

    #payment-card-info {
        width: 100% !important;
    }

    #payment-card-info > .row {
        width: 100% !important;
        margin: 0 !important;
        padding-left: 0 !important;
    }


    /* =====================================================
       SECTION HEADINGS
       ===================================================== */

    #payment-card-info .header-style {
        padding-left: 0 !important;
        margin-top: 17px !important;
        margin-bottom: 12px !important;
        font-size: 16px !important;
        line-height: 1.3 !important;
        font-weight: 700 !important;
    }


    /* =====================================================
       BILLING DETAILS
       ===================================================== */

    .customer-shipping-section {
        width: 100% !important;
        padding: 0 !important;
    }

    .customer-shipping-section > .row {
        width: 100% !important;
        margin: 0 !important;
    }

    .customer-shipping-section .col-md-6,
    .customer-shipping-section .col-md-4 {
        /* width: 100% !important;
        max-width: 100% !important; */
        flex: 0 0 100% !important;
        padding: 0 !important;
        margin-bottom: 11px !important;
    }

    .customer-shipping-section .form-label {
        display: block !important;
        margin: 0 0 5px !important;
        color: #555 !important;
        font-size: 12px !important;
        line-height: 1.2 !important;
        font-weight: 600 !important;
    }

    .customer-shipping-section .form-control {
        width: 100% !important;
        height: 42px !important;
        min-height: 42px !important;
        padding: 8px 11px !important;
        border: 1px solid #dedede !important;
        border-radius: 8px !important;
        background: #fff !important;
        font-size: 16px !important;
        box-shadow: none !important;
        transition: border-color .2s ease, box-shadow .2s ease !important;
    }

    .customer-shipping-section .form-control:focus {
        border-color: #80bdff !important;
        box-shadow: 0 0 0 3px rgba(0,123,255,.08) !important;
    }


    /* =====================================================
       SHIPPING METHOD
       ===================================================== */

    .forPaymentStyles .shipping-method-radio {
        width: 17px !important;
        height: 17px !important;
        margin-top: 2px !important;
    }

    .forPaymentStyles .form-check-inline {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        margin: 0 0 9px !important;
        padding: 9px 11px !important;
        border: 1px solid #e5e5e5 !important;
        border-radius: 8px !important;
        background: #fafafa !important;
    }

    .forPaymentStyles .form-check-inline .form-check-label {
        margin-left: 7px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        line-height: 1.3 !important;
    }


    /* =====================================================
       SAME AS BILLING CHECKBOX
       ===================================================== */

    .same_as_billing_address {
        width: 100% !important;
        margin-top: 8px !important;
        margin-bottom: 10px !important;
        padding: 10px 11px !important;
        border: 1px solid #e6e6e6 !important;
        border-radius: 9px !important;
        background: #fafafa !important;
    }

    #use_same_as_billing_address {
        width: 17px !important;
        height: 17px !important;
        vertical-align: middle !important;
    }

    .same_as_billing_address .form-label-info {
        font-size: 12px !important;
        line-height: 1.3 !important;
        vertical-align: middle !important;
    }


    /* =====================================================
       SHIPPING ADDRESS
       ===================================================== */

    .shipping-details-area {
        width: 100% !important;
    }

    .shipping-details-area.header-style {
        margin-top: 15px !important;
    }


    /* =====================================================
       CUSTOM INFORMATION
       ===================================================== */

    .forPaymentStyles .section_0 .row {
        width: 100% !important;
        margin: 0 !important;
    }

    .forPaymentStyles .section_0 .col-md-4 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
        margin-bottom: 11px !important;
    }


    /* =====================================================
       SAVE & CONTINUE
       ===================================================== */

    .forPaymentStyles .save_continue_btn {
        width: 100% !important;
        height: 43px !important;
        margin-top: 4px !important;
        padding: 8px 15px !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
    }

    .forPaymentStyles .ml-auto.text-right {
        width: 100% !important;
        margin-left: 0 !important;
        padding: 0 !important;
        margin-top: 4px !important;
    }


    /* =====================================================
       CARD DETAILS
       ===================================================== */

    #card-detail-section {
        width: 100% !important;
        max-width: 100% !important;
        margin: 18px 0 0 !important;
        padding: 16px 0 0 !important;
        border-top: 1px solid #eeeeee !important;
        background-color: transparent !important;
    }

    #card-detail-section > .header-style {
        margin: 0 0 13px !important;
        padding: 0 !important;
        font-size: 16px !important;
    }

    #card_details_section {
        width: 100% !important;
        padding: 0 !important;
    }

    #card_details_section > .row {
        width: 100% !important;
        margin: 0 !important;
    }

    #card_details_section .col-md-6,
    #card_details_section .col-md-3 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
        margin-bottom: 11px !important;
    }

    #card_details_section .form-label,
    #card_details_section .form-lable {
        display: block !important;
        margin: 0 0 5px !important;
        color: #555 !important;
        font-size: 12px !important;
        line-height: 1.2 !important;
        font-weight: 600 !important;
    }

    #card_details_section .form-control {
        width: 100% !important;
        height: 42px !important;
        min-height: 42px !important;
        padding: 8px 11px !important;
        border: 1px solid #dedede !important;
        border-radius: 8px !important;
        font-size: 16px !important;
        box-shadow: none !important;
    }

    #card_details_section .form-control:focus {
        border-color: #80bdff !important;
        box-shadow: 0 0 0 3px rgba(0,123,255,.08) !important;
    }


    /* =====================================================
       EXPIRATION DATE
       ===================================================== */

    #card_details_section #expiration-month,
    #card_details_section #expiration-year {
        width: 50% !important;
        height: 42px !important;
        min-height: 42px !important;
        font-size: 16px !important;
    }

    #card_details_section #expiration-month {
        margin-right: 6px !important;
    }


    /* =====================================================
       PAYMENT AMOUNTS
       ===================================================== */

    #card_details_section .mt-2 {
        margin-top: 3px !important;
    }

    #card_details_section .mt-2 .form-control[readonly] {
        background: #f7f8fa !important;
        color: #555 !important;
        font-weight: 600 !important;
    }


    /* =====================================================
       HIDDEN CONFIRM BUTTON
       ===================================================== */

    #confirm-purchase-card {
        display: none !important;
    }


    /* =====================================================
       PAYMENT SUMMARY CARD
       ===================================================== */

    .forPaymentStyles > .row > .col-md-3 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        min-height: auto !important;
        margin: 16px 0 0 !important;
        padding: 0 !important;
        border: 1px solid #e7e7e7 !important;
        border-radius: 8px !important;
        background: #fff !important;
        box-shadow: 0 4px 18px rgba(0,0,0,.06) !important;
        overflow: hidden !important;
    }

    .forPaymentStyles > .row > .col-md-3 > .tab-pane {
        width: 100% !important;
        height: auto !important;
        padding: 16px !important;
    }


    /* Summary title */

    .forPaymentStyles > .row > .col-md-3 .header-style {
        margin: 0 !important;
        padding: 0 !important;
        font-size: 18px !important;
        line-height: 1.3 !important;
        font-weight: 700 !important;
    }


    /* =====================================================
       COUPON
       ===================================================== */

    #coupon_code {
        width: 100% !important;
        height: 40px !important;
        min-height: 40px !important;
        padding: 7px 10px !important;
        border-radius: 8px !important;
        font-size: 16px !important;
    }

    .coupon_apply_button {
        min-width: 70px !important;
        height: 38px !important;
        margin: 1px 1px 1px 6px !important;
        padding: 5px 10px !important;
        border-radius: 7px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
    }

    #coupon_error {
        font-size: 10px !important;
        bottom: -15px !important;
    }


    /* =====================================================
       SUMMARY TABLE
       ===================================================== */

    .forPaymentStyles > .row > .col-md-3 table {
        width: 100% !important;
        margin-top: 12px !important;
        font-size: 12px !important;
        line-height: 1.7 !important;
    }

    .forPaymentStyles > .row > .col-md-3 table td {
        padding: 4px 0 !important;
        vertical-align: middle !important;
    }

    .forPaymentStyles > .row > .col-md-3 table td:first-child {
        padding-right: 8px !important;
    }

    .forPaymentStyles > .row > .col-md-3 table td:last-child {
        white-space: nowrap !important;
        text-align: right !important;
    }


    /* Total rows */

    .forPaymentStyles > .row > .col-md-3 table tr[style*="height:40px"] {
        height: 34px !important;
    }

    .forPaymentStyles > .row > .col-md-3 #balance_invoice_td {
        font-size: 17px !important;
        font-weight: 700 !important;
    }

    .forPaymentStyles > .row > .col-md-3 #amount_to_pay {
        font-size: 19px !important;
        font-weight: 700 !important;
    }


    /* =====================================================
       CONFIRM & PAY
       ===================================================== */

    .forPaymentStyles > .row > .col-md-3 > .tab-pane > .col-md-12.text-right {
        width: 100% !important;
        padding: 0 !important;
        margin-top: 12px !important;
    }

    #pay_button {
        width: 100% !important;
        height: 45px !important;
        margin: 0 !important;
        padding: 8px 12px !important;
        border: none !important;
        border-radius: 9px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        letter-spacing: .2px !important;
        box-shadow: 0 3px 8px rgba(0,0,0,.08) !important;
    }


    /* =====================================================
       PAYMENT LOGOS
       ===================================================== */

    .forPaymentStyles > .row > .col-md-3 .form-field {
        width: 100% !important;
        padding: 0 !important;
    }

    .forPaymentStyles > .row > .col-md-3 .form-field > .row {
        width: 100% !important;
        margin: 15px 0 0 !important;
        padding: 12px 0 0 !important;
        border-top: 1px solid #eeeeee !important;
    }

    .forPaymentStyles .form-field .row > .col-md-12 {
        padding: 0 !important;
    }

    .forPaymentStyles .form-field img {
        height: 21px !important;
        width: auto !important;
        margin: 0 3px 4px 0 !important;
        object-fit: contain !important;
    }

    .forPaymentStyles .form-field img.ml-1 {
        margin-left: 3px !important;
    }


    /* =====================================================
       DISCLAIMER
       ===================================================== */

    .forPaymentStyles .form-field p {
        margin: 8px 0 0 !important;
        color: #666 !important;
        font-size: 10px !important;
        line-height: 1.4 !important;
    }

    .forPaymentStyles .form-field p b {
        font-size: 10px !important;
    }
    .mobile_padding_unset {
        padding: unset !important
    }
}


/* =========================================================
   EXTRA SMALL PHONES
   ========================================================= */

@media (max-width: 380px) {

    .forPaymentStyles {
        padding: 65px 7px 15px !important;
    }

    .forPaymentStyles .col-md-9 > .card,
    .forPaymentStyles > .row > .col-md-3 {
        border-radius: 13px !important;
    }

    .forPaymentStyles .col-md-9 > .card > .header-style {
        margin-left: 13px !important;
        font-size: 17px !important;
    }

    .forPaymentStyles .tab-container {
        padding: 9px 12px 14px !important;
    }

    #payment-card-info .header-style {
        font-size: 15px !important;
    }

    .customer-shipping-section .form-control,
    #card_details_section .form-control {
        height: 40px !important;
        min-height: 40px !important;
    }

    .forPaymentStyles > .row > .col-md-3 > .tab-pane {
        padding: 13px !important;
    }

    .forPaymentStyles > .row > .col-md-3 .header-style {
        font-size: 17px !important;
    }

    .forPaymentStyles > .row > .col-md-3 table {
        font-size: 11px !important;
    }

    #pay_button {
        height: 43px !important;
        font-size: 12px !important;
    }

    .forPaymentStyles .form-field img {
        height: 19px !important;
        margin-right: 2px !important;
    }

    .forPaymentStyles .form-field p {
        font-size: 9px !important;
    }


}

</style>
<div class="navbar top-navbar  col-12 col-lg-12 {{ $teamStore->theme == 1 ? 'top_nav_dark' : '' }}" style=" background-color:white; z-index:99;">

    @include('pages.customer_team_store.layouts.header')

</div>

<div class="col-lg-12 mt-4 forPaymentStyles" style="padding-top: 80px;">
    <div class="se-pre-con"></div>
    <div class="row" style="margin: unset;">
        <div class="col-md-9">
            <div class="card" style="border-radius: 0rem; border:none">
                <div class="col-md-12 header-style mt-3 ml-3">
                    Payment Method
                </div>
                <div class="tab-container" style="width:100%;padding: 1rem; font-size: 0.8rem;">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link nav-link2 active" id="tab-card" data-toggle="tab" href="#card-tab">CARD</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3">
                        <div class="tab-pane tab-pane2 active" id="card-tab" style="min-height: 30rem;">

                                <form id="payment-card-info" method="post" action="{{ makeStoreDomainRoute('storePaymentOnline') }}">
                                    @csrf
                                    <input type="hidden" name="total_item_qty" value="{{ $cartItemsCount }}">
                                    <input type="hidden" id="sub_total_original" name="sub_total" value="{{ number_format($cartItemSum, 2, '.', '') }}">
                                    <input type="hidden" id="shipping_original" name="shipping" value="{{ number_format($shippingFee, 2, '.', '') }}">
                                    <input type="hidden" id="sales_tax_original" name="sales_tax" value="{{ number_format($salesTax, 2, '.', '') }}">
                                    <input type="hidden" id="artwork_original" name="artwork" value="{{ number_format($otherFee, 2, '.', '') }}">

                                    @php
                                        $orderTotal = $salesTax + $cartItemSum + $shippingFee + $otherFee;
                                    @endphp

                                    <input type="hidden" id="order_total" name="order_total" value="{{ number_format($orderTotal, 2, '.', '') }}">
                                    <input type="hidden" id="balancePayment" name="balancePayment" value="{{ number_format($orderTotal, 2, '.', '') }}">

                                    <div class="row" style="padding-left: 15px;">
                                        <div class="col-md-12 header-style mt-2">
                                            Billing Details
                                        </div>
                                        <div class="col-md-12 customer-shipping-section mb-2 section_0">
                                            <div class="row">
                                                <input type="hidden" name="store_id" value="{{$store->id}}">
                                                <div class="col-md-6">
                                                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{$newStoreCustomer->first_name ?? ''}}" required />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{$newStoreCustomer->last_name ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="street" class="form-label">Street Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="street" name="street" value="{{$newStoreCustomer->street ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="city" name="city" value="{{$newStoreCustomer->city ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="state" name="state" value="{{$newStoreCustomer->state ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="country" name="country" value="{{$newStoreCustomer->country ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="zip_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{$newStoreCustomer->postal_code ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="phone" class="form-label">Phone No <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{$newStoreCustomer->phone_number ?? ''}}" required />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{$newStoreCustomer->email ?? ''}}" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 header-style mt-2 section_0">
                                            Shipping Details
                                        </div>
                                        <div class="col-md-12 mt-2 section_0 mobile_padding_unset">
                                            <label class="mt-1"><strong>Select Shipping Method:</strong></label><br>
                                            @foreach ($store->StoreAddedShippingMethods as $key => $addedMethod)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input shipping-method-radio"
                                                        type="radio"
                                                        name="selected_shipping_method"
                                                        id="shipping_method_{{ $addedMethod->shippingMethod->id }}"
                                                        value="{{ $addedMethod->shippingMethod->id }}" {{ $key == 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="shipping_method_{{ $addedMethod->shippingMethod->id }}">
                                                        {{ $addedMethod->shippingMethod->shipping_method_name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-12 mt-4 section_0 same_as_billing_address">
                                            <input type="checkbox" name="use_same_as_billing_address" id="use_same_as_billing_address" {{$newStoreCustomer && $newStoreCustomer->is_shipping_address_available == 1 ? '' : 'checked' }}>
                                            <lable class="form-label-info" for="use_same_as_billing_address" style="font-size: large;"><strong>&nbsp;Use billing address as Shipping address</strong></lable>
                                        </div>
                                        <div class="col-md-12 header-style mt-2 shipping-details-area" style="display: {{$newStoreCustomer && $newStoreCustomer->is_shipping_address_available == 1 ? 'block' : 'none' }}">
                                            Shipping Address
                                        </div>
                                        <div class="col-md-12 customer-shipping-section mb-2 section_0 shipping-details-area" style="display: {{$newStoreCustomer && $newStoreCustomer->is_shipping_address_available == 1 ? 'block' : 'none' }}">
                                            <div class="row">
                                                <input type="hidden" name="store_id" value="{{$store->id}}">
                                                <div class="col-md-6">
                                                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_first_name" name="shipping_first_name" value="{{$newStoreCustomer->shipping_first_name ?? ''}}" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_last_name" name="shipping_last_name" value="{{$newStoreCustomer->shipping_last_name ?? ''}}"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="street" class="form-label">Street Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_street" name="shipping_street" value="{{$newStoreCustomer->shipping_street ?? ''}}" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_city" name="shipping_city" value="{{$newStoreCustomer->shipping_city ?? ''}}" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_state" name="shipping_state" value="{{$newStoreCustomer->shipping_state ?? ''}}" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_country" name="shipping_country" value="{{$newStoreCustomer->shipping_country ?? ''}}" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="zip_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="shipping_zip_code" name="shipping_zip_code" value="{{$newStoreCustomer->shipping_postal_code ?? ''}}" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="phone" class="form-label">Phone No</label>
                                                    <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" value="{{$newStoreCustomer->shipping_phone ?? ''}}" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="shipping_email" name="shipping_email" value="{{$newStoreCustomer->shipping_email ?? ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        @if ($store->StoreAddedCustomInformations->count() > 0)
                                            <div class="col-md-12 header-style mt-3">
                                                Custom Information
                                            </div>
                                            <div class="col-md-12  section_0">
                                                <div class="row">
                                                    @foreach ($store->StoreAddedCustomInformations as $StoreAddedCustomInformation)
                                                        @php
                                                            $info = $StoreAddedCustomInformation->storeCustomInformationsDetails;
                                                        @endphp

                                                        @if ($info->type == 2)
                                                            <div class="col-md-4">
                                                                <label for="custom_info_{{ $StoreAddedCustomInformation->custom_information_id }}" class="form-label">
                                                                    {{ $info->custom_name }} <span class="text-danger">*</span>
                                                                </label>
                                                                <select name="custom_info[{{ $StoreAddedCustomInformation->custom_information_id }}]"
                                                                        class="form-control"
                                                                        id="custom_info_{{ $StoreAddedCustomInformation->custom_information_id }}"
                                                                        required
                                                                        style="height: calc(2rem + 1px) !important;">
                                                                    @foreach (json_decode($info->options, true) as $option)
                                                                        <option value="{{ $option }}"
                                                                            @if (!empty($newStoreCustomer) && optional($newStoreCustomer->customInformation->firstWhere('custom_information_id', $StoreAddedCustomInformation->custom_information_id))->value == $option)
                                                                                selected
                                                                            @endif>
                                                                            {{ $option }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @else
                                                            <div class="col-md-4">
                                                                <label for="custom_info_{{ $StoreAddedCustomInformation->custom_information_id }}" class="form-label">
                                                                    {{ $info->custom_name }} <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="{{ $info->type == 3 ? 'number' : 'text' }}"
                                                                    class="form-control"
                                                                    id="custom_info_{{ $StoreAddedCustomInformation->custom_information_id }}"
                                                                    name="custom_info[{{ $StoreAddedCustomInformation->custom_information_id }}]"
                                                                    value="{{ !empty($newStoreCustomer) ? optional($newStoreCustomer->customInformation->firstWhere('custom_information_id', $StoreAddedCustomInformation->custom_information_id))->value : '' }}"
                                                                    required />
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-12 ml-auto text-right">
                                            <button type="button" class="btn btn-success btn-custom mt-2 save_continue_btn">Save & Continue</button>
                                        </div>

                                        @php
                                            $processing_fee = ($salesTax + $cartItemSum + $shippingFee + $otherFee) * 3 / 100;
                                            $isZeroPayment = ($salesTax + $cartItemSum + $shippingFee + $otherFee) > 0;
                                        @endphp

                                            <div class="col-md-12 row details_card mt-4" style=" margin: unset;{{ $isZeroPayment ? 'display:block' : 'display:none' }}" id="card-detail-section">
                                                <div class="col-md-12 header-style mt-5" style="margin-top: .5rem!important; padding-left: unset;">
                                                    Card Details
                                                </div>
                                                <div class="col-md-12"  id="card_details_section" style="display:none;">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="owner" class="form-label">Name on Card <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="owner" name="owner" value="{{ old('owner') }}" placeholder="Card Owner's Name" {{ $isZeroPayment ? '' : 'required' }} />
                                                        </div>
                                                        <div class="col-md-6" style="padding-right: 0">
                                                            <label for="cardNumber" class="form-label">Card Number <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="{{ old('cardNumber') }}" placeholder="Card Number" {{ $isZeroPayment ? '' : 'required' }} />
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
                                                        <div class="col-md-3" style="padding-left: 0">
                                                            <label for="cvv" class="form-label">CVV: <span class="text-danger">*</span></label>
                                                            <input type="password" class="form-control" id="cvv" name="cvv" value="{{ old('cvv') }}" placeholder="CVV" {{ $isZeroPayment ? '' : 'required' }} />
                                                        </div>
                                                        <div class="col-md-6 form-field mt-3" style="display: none">
                                                            <label class="form-lable">Order #:</label>
                                                            <input type="hidden" class="form-control" name="order_id" value=""/>
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable">Payment Amount ($): <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="payment_amount" readonly value="{{number_format(($salesTax + $cartItemSum + $shippingFee + $otherFee), 2)}}"/>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable">Card Processing Fee (3%) ($):</label>
                                                            <input type="text" class="form-control card_processing_fee_to_pay" value="{{number_format($processing_fee, 2)}}" readonly />
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label class="form-lable">Amount ($): <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control card_payment_amount" value="{{number_format(($salesTax + $cartItemSum + $shippingFee + $otherFee + $processing_fee), 2)}}" readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>

                                    <input type="hidden" class="form-control" id="amount" name="amount" value="{{number_format(($salesTax + $cartItemSum + $shippingFee + $otherFee + $processing_fee), 2)}}" />
                                    <input type="hidden" class="form-control" id="card_processing_fee_to_pay" name="card_processing_fee" value="{{number_format($processing_fee, 2)}}" />
                                    <input type="hidden" name="cartItemSum" value="{{ $cartItemSum }}">
                                    <input type="hidden" name="storeId" value="{{ $teamStore->store_id }}">
                                    <input type="hidden" name="is_zero_payment" id="is_zero_payment" value="{{ ($salesTax + $cartItemSum + $shippingFee + $otherFee) > 0 ? 0 : 1 }}">

                                    <div class="col-lg-12 control-btns" style="background-color: white">
                                        <button style="display: none" type="submit" class="btn btn-success btn-custom" id="confirm-purchase-card">Confirm Payment</button>
                                    </div>

                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Summary --}}

        <div class="col-md-3 card tab-content" style="border: none;border-radius:0rem;min-height: 30rem;">
            <div class="tab-pane tab-pane2 active" id="card-tab" style="height: 100%;">
                <div class="col-md-12 header-style mt-3" style="padding: 0">
                    Payment Summary
                </div>
                @if ($store->StoreAddedCoupons->count() > 0)
                    <div class="col-md-12 mt-3" style="padding: 0">
                        <div class="input-group d-flex align-items-center position-relative">
                            <input type="text" id="coupon_code" name="coupon_code"
                                class="form-control"
                                style="border: 1px solid #DEDEDE;height: calc(2rem + 1px) !important;"
                                placeholder="Enter Code" />

                            <button class="btn btn-success btn-custom m-2 coupon_apply_button"
                                style="padding: .1rem .5rem !important;" type="button">
                                Apply
                            </button>

                            <div id="coupon_error" class="invalid-feedback" style="display:none; position:absolute; bottom:-12px; left:0; font-size: 12px;"></div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12 mt-3" style="padding: 0">
                    <table style="color: #717070; font-size:.8rem;width:100%; line-height: 2;border-bottom:1px solid #b3b3b3">
                        <tr>
                            <td>Total item qty</td>
                            <td class="text-right">{{$cartItemsCount}}</td>
                        </tr>
                        <tr>
                            <td>Order item amount ($)</td>
                            <td class="text-right" id="sub_total_display">{{number_format($cartItemSum, 2)}}</td>
                        </tr>
                        <tr>
                            <td>Sales tax fee {{$store->sales_tax}}% ($)</td>
                            <td class="text-right" id="sales_tax_display">{{number_format($salesTax , 2)}}</td>
                        </tr>
                        <tr>
                            <td>Shipping fee ($)</td>
                            <td class="text-right" id="shipping_fee_td">{{ number_format($shippingFee, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Artwork & other fees ($)</td>
                            <td class="text-right" id="other_fee_display">{{number_format($otherFee , 2)}}</td>
                        </tr>


                        <tr style="vertical-align: bottom;font-weight:700;height:40px">
                            <td>Total invoice amount ($)</td>
                            <td class="text-right" id="total_invoice_td">
                                {{ number_format(($salesTax + $cartItemSum + $shippingFee + $otherFee), 2) }}
                            </td>
                        </tr>
                        @if ($store->StoreAddedCoupons->count() > 0)
                            <tr style="vertical-align: bottom;font-weight:700;color:#2ec49f99" id="coupon_tr" class="d-none">
                                <td colspan="2" id="coupon_td"></td>
                            </tr>
                        @endif

                        <tr style="height: 10px;"></tr>
                        <tr style="color: black;line-height: 1.5;border-top:1px solid #b3b3b3">
                            <td style="font-size: .8rem;font-weight: 600;">Balance invoice amount ($)</td>
                            <td style="font-size:16px; font-weight: 700;" class="text-right" id="balance_invoice_td">
                                {{ number_format(($salesTax + $cartItemSum + $shippingFee + $otherFee), 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Processing fee 3% ($)</td>
                            <td class="text-right" id="processing_fee_td">{{ number_format($processing_fee, 2) }}</td>
                        </tr>
                        <tr style="color: black;">
                            <td style="font-size: .8rem;font-weight: 600;">Total amount to pay ($)</td>
                            <td style="font-size:16px; font-weight: 700; color:red" id="amount_to_pay" class="text-right">
                                {{ number_format(($salesTax + $cartItemSum + $shippingFee + $otherFee + $processing_fee), 2) }}
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="col-md-12 text-right" style="padding-right: 0px">
                    <button type="button" class="btn btn-success btn-custom mt-2" id="pay_button" style="display: none;" onclick="submitCardForm()" >CONFIRM & PAY</button>
                </div>
                <div class="col-md-12 form-field" style="padding: 0;">
                    <div class="row ml-1 mt-3" style="margin-bottom: 0rem !important;border-top: 1px solid #b3b3b3;margin-right:2rem">
                        <div class="col-md-12 mt-3" style="padding: 0px">
                            <img src="{{asset('argon')}}/img/icons/visa.png" style="height: 25px;" />
                            <img src="{{asset('argon')}}/img/icons/mastercard.png" class="ml-1" style="height: 25px;" />
                            <img src="{{asset('argon')}}/img/icons/discover.png" class="ml-1" style="height: 25px;" />
                            <img src="{{asset('argon')}}/img/icons/american_express.png" class="ml-1" style="height: 25px;" />
                        </div>

                        <div class="col-md-12 mt-2" style="padding: 0px"><p style="color: #5a5a5a;font-size:.7rem;line-height:1rem"><i style="color: blue" class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;<b style="font-weight: 700">DISCLAIMER</b> <br/> 3% processing fee will be added to all card payments.</p></div>


                    </div>
                </div>
            </div>

        </div>

        {{-- End Order Summary --}}
    </div>
</div>

@include('pages.customer_team_store.layouts.footer')

<script>

    // Function to submit the Card form
    function submitCardForm() {
        $('.se-pre-con').fadeIn('slow');
        $("#confirm-purchase-card").click();
    }

    $(document).ready(function() {

        var is_first_load = true;

        $('#use_same_as_billing_address').on('change', function () {
            toggleShippingArea();
        });

        function toggleShippingArea() {
            if ($('#use_same_as_billing_address').is(':checked')) {
                $('.shipping-details-area').hide();
            } else {
                $('.shipping-details-area').show();
            }
        }

        // Save & Continue button
        $('.save_continue_btn').on('click', function(e) {
            e.preventDefault();

            var currentSection = $('.section_0:visible');
            var clickedButton = $(this);

            var isValid = true;

            currentSection.each(function () {
                $(this).find('input, select').each(function () {

                    if (!this.checkValidity()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }

                });

            });

            if (!isValid) {
                return;
            }

            var formData = currentSection.find('input, select').serialize();
            formData += '&_token={{ csrf_token() }}';

            $('.se-pre-con').fadeIn('slow');

            $.ajax({
                url: "{{ makeStoreDomainRoute('customerTeamStorePersonalDetails') }}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('.se-pre-con').fadeOut('slow');
                    if (response.success) {
                        $('#card_details_section').show();
                        $('#pay_button').show();
                        updateShippingFee();
                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'warning',
                            title: response.message || 'There was an error, please try again.',
                            showConfirmButton: false,
                            timer: 2500,
                            toast: true
                        });
                    }
                },
                error: function(response) {
                    $('.se-pre-con').fadeOut('slow');
                    alert('There was an error, please try again.');
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: response.message || 'There was an error, please try again.',
                        showConfirmButton: false,
                        timer: 2500,
                        toast: true
                    });
                    updateShippingFee();
                }
            });

        });

        $(document).ready(function () {
            $('.shipping-method-radio').on('change', function () {
                updateShippingFee();
            });

            $(document).on('click', '.coupon_apply_button', function () {
                $('.se-pre-con').fadeIn('slow');
                let $input = $('#coupon_code');
                let $error = $('#coupon_error');
                let code = $input.val().trim();

                $error.hide().text('');
                $input.removeClass('is-invalid is-valid').css('border-color', '#DEDEDE');
                $(this).prop('disabled', true);

                if (code === '') {
                    $error.text('Please enter a coupon code.').show();
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    $(this).prop('disabled', false);
                    $('.se-pre-con').fadeOut('slow');
                    return;
                }

                $.ajax({
                    url: "{{ makeStoreDomainRoute('get_coupon_details') }}",
                    method: 'GET',
                    data: {
                        store_id: '{{ $store->id }}',
                        coupon_code: code,
                    },
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.status === 'success') {
                            let $form = $('#payment-card-info');
                            $form.find('input[name="coupon_code_apply"]').remove();

                            $('<input>', {
                                type: 'hidden',
                                name: 'coupon_code_apply',
                                value: code
                            }).appendTo($form);

                            $(this).prop('disabled', true);

                            $input.prop('disabled', true).addClass('is-valid').css('border-color', '#28a745');
                            $error.hide();
                            updateShippingFee();
                        } else {
                            showCouponError(response.message);
                        }
                    },
                    error: function (xhr) {
                        let errorMsg = 'Invalid coupon code.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showCouponError(errorMsg);
                    },
                    complete: function () {
                        $('.se-pre-con').fadeOut('slow');
                    }
                });

                function showCouponError(message) {
                    $input.addClass('is-invalid').css('border-color', '#dc3545');
                    $error.text(message).show();
                    $input.prop('disabled', false);
                    $('.coupon_apply_button').prop('disabled', false);
                }
            });
        });


        updateShippingFee();

        function updateShippingFee() {
            var shippingMethod = $('input[name="selected_shipping_method"]:checked').val();

            if(!is_first_load){
                if(parseFloat(shippingMethod) !== 1){
                    $('.shipping-details-area').hide();
                    $('.same_as_billing_address').hide();
                }else{
                    $('.same_as_billing_address').show();
                    $('#use_same_as_billing_address').prop('checked', true);
                    $('.shipping-details-area').hide();
                }
            }

            is_first_load = false;


            $.ajax({
                url: "{{ makeStoreDomainRoute('usps/get_shipping_fee') }}",
                method: 'GET',
                data: {
                    store_id: '{{ $store->id }}',
                    shipping_method: shippingMethod,
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (data) {
                    var shippingFee = 0;

                    if (data.success) {
                        shippingFee = parseFloat(data.rate.amount) || 0;
                    } else {
                        // Swal.fire({
                        //     icon: 'error',
                        //     title: 'Error',
                        //     text: data.message || 'Failed to retrieve shipping rate.',
                        //     confirmButtonColor: '#3085d6'
                        // });
                    }

                    var cartItemSum = parseFloat('{{ $cartItemSum }}');
                    var salesTax = parseFloat('{{ $salesTax }}');
                    var otherFee = parseFloat('{{ $otherFee }}');
                    var salesTaxRate = parseFloat('{{ $salesTaxRate }}');

                    var invoiceAmount = salesTax + cartItemSum + shippingFee + otherFee;

                    if ($('input[name="coupon_code_apply"]').length > 0 && $('#coupon_code').val().trim() != '') {
                        var couponCode = $('#coupon_code').val().trim();

                        $.ajax({
                            url: "{{ makeStoreDomainRoute('get_coupon_details') }}",
                            method: 'GET',
                            data: {
                                store_id: '{{ $store->id }}',
                                coupon_code: couponCode,
                            },
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (couponsData) {
                                if (couponsData.status === 'success' && couponsData.data) {
                                    var c = couponsData.data;

                                    if (c.type == 'free_shipping') {
                                        $('#coupon_td').html('You have received' + (c.amount > 0 ? ' $' + parseFloat(shippingFee).toFixed(2) : '') + ' off on shipping fee');
                                        $('#coupon_tr').removeClass('d-none');
                                        shippingFee = 0;
                                        invoiceAmount = salesTax + cartItemSum + shippingFee + otherFee;

                                    } else if (c.type == 'flat_from_sub') {
                                        $('#coupon_td').html('You have received $' + parseFloat(c.amount).toFixed(2) + ' off on subtotal');
                                        $('#coupon_tr').removeClass('d-none');
                                        cartItemSum = Math.max(0, cartItemSum - parseFloat(c.amount));
                                        salesTax = (cartItemSum * salesTaxRate) / 100;
                                        invoiceAmount = salesTax + cartItemSum + shippingFee + otherFee;

                                    } else if (c.type == 'percentage_from_sub') {
                                        $('#coupon_td').html('You have received ' + parseFloat(c.amount).toFixed(2) + '% ($' + parseFloat((cartItemSum * parseFloat(c.amount) / 100)).toFixed(2) + ') off on subtotal');
                                        $('#coupon_tr').removeClass('d-none');
                                        cartItemSum = cartItemSum - (cartItemSum * parseFloat(c.amount) / 100);
                                        salesTax = (cartItemSum * salesTaxRate) / 100;
                                        invoiceAmount = salesTax + cartItemSum + shippingFee + otherFee;

                                    } else if (c.type == 'flat_from_grand') {
                                        $('#coupon_td').html('You have received $' + parseFloat(c.amount).toFixed(2) + ' off on total amount');
                                        $('#coupon_tr').removeClass('d-none');
                                        invoiceAmount = Math.max(0, invoiceAmount - parseFloat(c.amount));

                                    } else if (c.type == 'percentage_from_grand') {
                                        $('#coupon_td').html('You have received ' + parseFloat(c.amount).toFixed(2) + '% ($' + parseFloat((invoiceAmount * parseFloat(c.amount) / 100)).toFixed(2) + ') off on total amount');
                                        $('#coupon_tr').removeClass('d-none');
                                        invoiceAmount = invoiceAmount - (invoiceAmount * parseFloat(c.amount) / 100);
                                    }

                                }

                                var processingFee = +(invoiceAmount * 0.03).toFixed(2);
                                var totalAmount = invoiceAmount + processingFee;

                                updateInvoiceUI(cartItemSum, salesTax, shippingFee, otherFee, invoiceAmount, processingFee, totalAmount);
                            }
                        });
                    } else {
                        var processingFee = +(invoiceAmount * 0.03).toFixed(2);
                        var totalAmount = invoiceAmount + processingFee;

                        updateInvoiceUI(cartItemSum, salesTax, shippingFee, otherFee, invoiceAmount, processingFee, totalAmount);
                    }
                },
                error: function (xhr) {
                    console.error('Error fetching data:', xhr);
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'Error',
                    //     text: 'An unexpected error occurred while fetching shipping fee.',
                    //     confirmButtonColor: '#3085d6'
                    // });
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }

        function updateInvoiceUI(cartItemSum, salesTax, shippingFee, otherFee, invoiceAmount, processingFee, totalAmount) {
            $('#shipping_fee_td').text(shippingFee.toFixed(2));
            $('#total_invoice_td').text(invoiceAmount.toFixed(2));
            $('#balance_invoice_td').text(invoiceAmount.toFixed(2));
            $('#sub_total_display').text(cartItemSum.toFixed(2));
            $('#sales_tax_display').text(salesTax.toFixed(2));
            $('#other_fee_display').text(otherFee.toFixed(2));
            $('#order_total').val(invoiceAmount.toFixed(2));
            $('#sub_total_original').val(invoiceAmount.toFixed(2));
            $('#balancePayment').val(invoiceAmount.toFixed(2));
            $('#processing_fee_td').text(processingFee.toFixed(2));
            $('#card_processing_fee_to_pay').val(processingFee.toFixed(2));
            $('.card_processing_fee_to_pay').val(processingFee.toFixed(2));
            $('.card_payment_amount').val(totalAmount.toFixed(2));
            $('#amount').val(totalAmount.toFixed(2));
            $('#amount_to_pay').text(totalAmount.toFixed(2));
            if (totalAmount.toFixed(2) > 0) {
                $('#card-detail-section').show();
                $('#is_zero_payment').val(0);
                $('#card-detail-section').find('input, select').each(function() {
                    $(this).prop('required', true);
                });
            }else {
                $('#card-detail-section').hide();
                $('#is_zero_payment').val(1);
                $('#card-detail-section').find('input, select').each(function() {
                    $(this).prop('required', false);
                });
            }
            $('#payment_amount').val(totalAmount.toFixed(2));
            $('#shipping_original').val(shippingFee.toFixed(2));
            $('#sales_tax_original').val(salesTax.toFixed(2));
            $('#artwork_original').val(otherFee.toFixed(2));
        }





        // Back & Edit button
        $('.back_edit_btn').on('click', function(e) {
            e.preventDefault();

            var sectionIndex = $(this).data('section');
            var prevSection = parseInt(sectionIndex) - 1;
            var currentSection = $('#section_' + sectionIndex);
            var prevSectionDiv = $('#section_' + prevSection);

            // Hide the current section
            currentSection.hide();

            // Show the previous section and remove readonly
            prevSectionDiv.show();
            prevSectionDiv.find('input, select').each(function() {
                $(this).removeClass('completed-section');
                $(this).prop('readonly', false); // Make inputs editable again
            });

            // Show the Save & Continue button for the previous section
            prevSectionDiv.find('.save_continue_btn').show();

            // Show only the Back & Edit button for the previous section
            prevSectionDiv.find('.back_edit_btn').show();
            updateShippingFee();
        });
    });

    $('.se-pre-con').fadeOut('slow');
</script>
@if(session('status'))
    <script>
        Swal.fire({
            icon: '{{ session("status") }}',
            title: '{{ session("status") === "success" ? "Success" : "Error" }}',
            text: '{{ session("message") }}',
            confirmButtonColor: '#3085d6',
        });
    </script>
@endif

@endsection
