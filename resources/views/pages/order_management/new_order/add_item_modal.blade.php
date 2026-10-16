<style>
    .modal-content .table th, .modal-content .table td{
        border: none;
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    .invoice_details {
        border: none !important;
    }
    .modal-body .styleUnique .select2-selection__rendered{
        border: none !important;
    }
    .modal-body .styleUnique .select2-selection--single{
        border: 1px solid #B3B3B3 !important;
        border-radius: 0rem !important;
        height: 25px !important;
    }
    .modal-body .item-datepicker{
        border: 1px solid #B3B3B3;
        color: #717070;
    }
    /* .styleUnique .select2-selection--single{
        border: 1px solid !important;
        border-radius: 0rem;
    } */
    #select2-item_attribute-container{
        border: none !important;
    }
    /* .modal-body .select2-selection--multiple{
        border: 1px solid black;
    } */
    /* .select2-container--below{
        border: 1px solid black !important;
        border-radius: 0rem !important;
    } */
    .specialStyles .select2-container--default .select2-selection--multiple {
        border: 1px solid #B3B3B3 !important;
        border-radius: 0rem;
        min-height: 25px;
    }
    .styleUnique .select2-selection__rendered{
        border: none !important;
    }
    .uniqueStylePast .select2-container--default{
        /* margin-top: .5rem; */
    }
    .newOrderStyles .select2-selection__rendered{
        border: 1px solid #DEDEDE;
        border-radius: 0rem !important;
        color: #717070 !important;
        padding-left: 7px !important;
        font-size: 0.8rem !important;
        height: calc(1.5rem + 1px) !important;
    }
    .newOrderStyles #item_attribute + .select2.select2-container {
        min-height: 10px !important;
    }
    .newOrderStyles .select2-selection.select2-selection--multiple {
        border: 1px solid #e9ecef!important;
        height: 20px !important;
    }
    .newOrderStyles .modal-datepicker.hasDatepicker{
        padding: 5px;
        padding-left: 6px;
        height: calc(1.5rem + 1px);
        border-radius: 0rem !important;
        color: #717070;
        border: 1px solid #DEDEDE;
        margin-top: 5px;
    }
    .input-container {
    width: 100% !important;
    }

    .invoice-inputs.modal-datepicker {
    padding-right: 30px; /* Adjust the value to set the icon's position */
    }

    .calendar-icon {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
    color: #717070;
    }
    .select2-container--default.select2-container--disabled .select2-selection--single {
    background-color: transparent;
    }

/* =========================================================
   ADD ITEM MODAL - MOBILE RESPONSIVE
   No existing class / id / name changes required
   ========================================================= */

@media (max-width: 767.98px) {

    /* =========================================================
       MODAL
       ========================================================= */

    #add_item_modal .modal-dialog {
        width: calc(100% - 20px) !important;
        max-width: none !important;
        margin: 10px auto !important;
        min-height: calc(100vh - 20px) !important;

        display: flex !important;
        align-items: center !important;
    }

    #add_item_modal .modal-content {
        width: 100% !important;
        max-height: calc(100vh - 20px) !important;

        border: none !important;
        border-radius: 14px !important;

        overflow: hidden !important;
    }


    /* =========================================================
       MODAL HEADER
       ========================================================= */

    #add_item_modal .modal-header {
        padding: 15px 16px !important;
        min-height: 58px !important;

        border-bottom: 1px solid #eeeeee !important;
        
    }

    #add_item_modal .modal-title {
        font-size: 17px !important;
        line-height: 24px !important;
        padding-right: 10px !important;
    }

    #add_item_modal .modal-title span {
        font-size: 11px !important;
    }

    #add_item_modal .modal-header .close {
        font-size: 26px !important;
        margin: 0 !important;
        padding: 0 4px !important;
        outline: none !important;
    }


    /* =========================================================
       MODAL BODY
       ========================================================= */

    #add_item_modal .modal-body {
        padding: 12px !important;

        max-height: calc(100vh - 135px) !important;

        overflow-y: auto !important;
        overflow-x: hidden !important;

        -webkit-overflow-scrolling: touch;
    }


    /* =========================================================
       REMOVE BOOTSTRAP SIDE SPACING
       ========================================================= */

    #add_item_modal .modal-body > .col-md-12,
    #add_item_modal .modal-body .row,
    #add_item_modal .modal-body .col-md-12,
    #add_item_modal .modal-body .col-md-8 {

        width: 100% !important;
        max-width: 100% !important;

        margin-left: 0 !important;
        margin-right: 0 !important;

        padding-left: 0 !important;
        padding-right: 0 !important;
    }


    /* =========================================================
       CARD
       ========================================================= */

    #add_item_modal .card-updated {
        width: 100% !important;

        margin: 0 !important;
        padding: 0 2px !important;

        border: none !important;
        box-shadow: none !important;
    }


    /* =========================================================
       SECTION HEADERS
       ========================================================= */

    #add_item_modal .sub-header-style {
        width: 100% !important;

        margin: 18px 0 7px 0 !important;
        padding: 0 3px !important;

        font-size: 13px !important;
        font-weight: 700 !important;

        line-height: 20px !important;
    }


    /* =========================================================
       FILTER BUTTON
       ========================================================= */

    #add_item_modal #FilterFieldsDiv {
        width: 100% !important;

        margin: 4px 0 10px 0 !important;
    }

    #add_item_modal #FilterFieldsDiv tr {
        display: block !important;
        width: 100% !important;
    }

    #add_item_modal #FilterFieldsDiv th,
    #add_item_modal #FilterFieldsDiv td {
        display: block !important;

        width: 100% !important;

        padding: 5px 3px !important;

        border: none !important;
    }

    #add_item_modal #FilterFieldsDiv th {
        font-size: 11px !important;
    }

    #add_item_modal #FilterFieldsDiv tr:first-child th {
        font-size: 14px !important;
        margin-bottom: 5px !important;
    }

    #add_item_modal #FilterFieldsDiv td:last-child {
        text-align: right !important;
    }

    #add_item_modal #FilterFieldsDiv td:last-child button {
        margin-right: 0 !important;
    }

    #add_item_modal > .modal-dialog .col-md-12[style*="text-align: end"] {
        text-align: right !important;

        margin: 0 !important;
        padding: 0 !important;
    }


    /* =========================================================
       ALL TABLES
       ========================================================= */

    #add_item_modal .invoice_details {
        width: 100% !important;

        margin: 0 0 8px 0 !important;

        table-layout: fixed !important;

        border: none !important;
    }

    #add_item_modal .invoice_details > tbody {
        width: 100% !important;
    }


    /* =========================================================
       HIDE EMPTY SPACING ROW
       ========================================================= */

    #add_item_modal .invoice_details tr[style*="height:10px"] {
        display: none !important;
    }


    /* =========================================================
       IMPORTANT

       Hide original TH labels on mobile.
       We will create labels using TD::before.
       ========================================================= */

    #add_item_modal .invoice_details:not(#FilterFieldsDiv) tr:has(th) th {
        display: none !important;
    }


    /* =========================================================
       FIELD ROW

       Maximum 2 fields per row.
       ========================================================= */

    #add_item_modal .invoice_details:not(#FilterFieldsDiv) tr:has(th) + tr {

        /* display: grid !important; */

        grid-template-columns:
            repeat(2, minmax(0, 1fr)) !important;

        column-gap: 10px !important;

        row-gap: 0 !important;

        width: 100% !important;

        margin: 0 !important;
    }


    /* =========================================================
       FIELD TD
       ========================================================= */

    #add_item_modal .invoice_details:not(#FilterFieldsDiv)
    tr:has(th) + tr td {

        display: block !important;

        width: 100% !important;

        min-width: 0 !important;

        padding: 2px 3px 10px 3px !important;

        border: none !important;

        box-sizing: border-box !important;
    }


    /* =========================================================
       HIDDEN TD

       If a field is display:none, don't reserve its space.
       ========================================================= */

    #add_item_modal .invoice_details
    tr:has(th) + tr td[style*="display: none"] {

        display: none !important;
    }


    /* =========================================================
       LABEL CREATED BY CSS

       Label appears directly ABOVE its field.
       ========================================================= */

    #add_item_modal .invoice_details:not(#FilterFieldsDiv)
    tr:has(th) + tr td::before {

        display: block !important;

        margin: 0 0 4px 0 !important;

        padding: 0 !important;

        font-size: 11px !important;

        line-height: 16px !important;

        color: #555 !important;

        font-weight: 600 !important;

        text-align: left !important;
    }


    /* =========================================================
       EX-FACTORY ADDRESS
       ========================================================= */

    #add_item_modal .invoice_details td[style*="display: flex"] {
        display: block !important;

        width: 100% !important;

        padding: 5px 3px !important;
    }

    #add_item_modal .invoice_details a.btn {
        width: 100% !important;

        display: flex !important;

        align-items: center !important;
        justify-content: center !important;

        margin-top: 5px !important;

        font-size: 11px !important;
    }


    /* =========================================================
       LABELS
       ========================================================= */

    #add_item_modal .form-label {
        font-size: 11px !important;

        color: #555 !important;

        font-weight: 600 !important;

        white-space: normal !important;
    }


    /* =========================================================
       INPUTS

       IMPORTANT:
       NO HEIGHT CHANGE HERE.
       ========================================================= */

    #add_item_modal input.invoice-inputs,
    #add_item_modal select.invoice-inputs,
    #add_item_modal textarea.invoice-inputs,
    #add_item_modal .form-input {

        width: 100% !important;

        min-width: 0 !important;

        /* font-size: 16px !important; */

        box-sizing: border-box !important;
    }


    /* =========================================================
       SELECT CONTAINERS
       ========================================================= */

    #add_item_modal .select-container,
    #add_item_modal .styleUnique,
    #add_item_modal .specialStyles {

        width: 100% !important;

        min-width: 0 !important;

        padding-left: 3px !important;
        padding-right: 3px !important;

        box-sizing: border-box !important;
    }

    #add_item_modal .select2-container {

        width: 100% !important;

        max-width: 100% !important;

        min-width: 0 !important;
    }


    /* =========================================================
       SELECT2 SINGLE

       Height is NOT changed.
       ========================================================= */

    #add_item_modal .select2-container
    .select2-selection--single {

        border: 1px solid #b3b3b3 !important;

        border-radius: 5px !important;
        border-radius: 3px !important;
        height: 32px !important;
    }

    #add_item_modal .select2-container
    .select2-selection--single
    .select2-selection__rendered {

        /* font-size: 16px !important; */

        padding-left: 10px !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;
        height: 31px !important;
        line-height: 31px !important;

    }


    /* =========================================================
       MULTIPLE SELECT - ATTRIBUTES

       Selected items remain inside the field.
       Height grows naturally only when necessary.
       ========================================================= */

    #add_item_modal .specialStyles
    .select2-container--default
    .select2-selection--multiple {

        border: 1px solid #b3b3b3 !important;

        border-radius: 5px !important;

        padding: 3px 5px !important;

        box-sizing: border-box !important;

        overflow: hidden !important;
    }

    #add_item_modal .specialStyles
    .select2-selection--multiple
    .select2-selection__rendered {

        display: flex !important;

        flex-wrap: wrap !important;

        align-items: center !important;

        gap: 3px !important;

        width: 100% !important;

        margin: 0 !important;

        padding: 0 !important;

        box-sizing: border-box !important;
    }

    #add_item_modal .specialStyles
    .select2-selection--multiple
    .select2-selection__choice {

        float: none !important;

        display: inline-flex !important;

        align-items: center !important;

        max-width: 100% !important;

        margin: 2px 0 !important;

        padding: 3px 7px !important;

        font-size: 13px !important;

        line-height: 20px !important;

        border-radius: 4px !important;

        box-sizing: border-box !important;
    }

    #add_item_modal .specialStyles
    .select2-selection__choice__display {

        max-width: calc(100vw - 100px) !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;
    }

    #add_item_modal .specialStyles
    .select2-selection__choice__remove {

        flex-shrink: 0 !important;

        margin-right: 4px !important;
    }

    #add_item_modal .specialStyles
    .select2-search--inline {

        display: inline-flex !important;

        max-width: 100% !important;

        margin: 2px 0 !important;
    }

    #add_item_modal .specialStyles
    .select2-search--inline
    .select2-search__field {

        width: auto !important;

        max-width: 100% !important;

        margin: 0 !important;

        padding: 2px !important;

        /* font-size: 16px !important; */

        box-sizing: border-box !important;
    }


    /* =========================================================
       DATE INPUT
       ========================================================= */

    #add_item_modal .input-container {

        width: 100% !important;

        position: relative !important;
    }

    #add_item_modal .input-container input {

        width: 100% !important;

        /* font-size: 16px !important; */
    }

    #add_item_modal .calendar-icon {

        right: 10px !important;

        font-size: 15px !important;
    }


    /* =========================================================
       PRODUCT SELECT
       ========================================================= */

    #add_item_modal #item_product {
        width: 100% !important;
    }

    #add_item_modal #product_display_name {

        width: 100% !important;

        /* font-size: 16px !important; */
    }


    /* =========================================================
       EX-FACTORY SELECT
       ========================================================= */

    #add_item_modal #item_ex_factory_id {
        width: 100% !important;
    }


    /* =========================================================
       HIDDEN SETTINGS TABLE
       ========================================================= */

    #add_item_modal .invoice_details[style*="display: none"] {
        display: none !important;
    }


    /* =========================================================
       MODAL FOOTER
       ========================================================= */

    #add_item_modal .modal-footer {

        padding: 10px 12px !important;

        border-top: 1px solid #eeeeee !important;

        background: #fff !important;
    }

    #add_item_modal .modal-footer .control-btns {

        width: 100% !important;

        padding: 0 !important;

        display: grid !important;

        grid-template-columns: repeat(3, 1fr) !important;

        gap: 6px !important;
    }

    #add_item_modal .modal-footer button {

        width: 100% !important;

        margin: 0 !important;

        padding: 7px 4px !important;

        font-size: 11px !important;

        white-space: nowrap !important;
    }

    #add_item_modal .modal-footer button i {

        font-size: 10px !important;

        margin-right: 2px !important;
    }


    /* =========================================================
       SMALL MOBILE
       ========================================================= */

    @media (max-width: 380px) {

        #add_item_modal .modal-dialog {

            width: calc(100% - 10px) !important;

            margin: 5px auto !important;
        }

        #add_item_modal .modal-content {

            max-height: calc(100vh - 10px) !important;
        }

        #add_item_modal .modal-body {

            max-height: calc(100vh - 125px) !important;

            padding: 9px !important;
        }

        #add_item_modal .modal-title {

            font-size: 15px !important;
        }

        #add_item_modal .modal-footer .control-btns {

            gap: 4px !important;
        }

        #add_item_modal .modal-footer button {

            font-size: 10px !important;
        }
    }
}
@media (max-width: 767.98px) {

    #add_item_modal .specialStyles .select2-container {
        width: 100% !important;
    }

    #add_item_modal .specialStyles
    .select2-container--default
    .select2-selection--multiple {

        min-height: 38px !important;

        height: auto !important;

        padding: 3px 5px !important;

        box-sizing: border-box !important;

        overflow: hidden !important;
    }

    /* Selected items stay INSIDE the field */
    #add_item_modal .specialStyles
    .select2-selection--multiple
    .select2-selection__rendered {

        display: flex !important;

        flex-wrap: wrap !important;

        align-items: center !important;

        gap: 3px !important;

        width: 100% !important;

        margin: 0 !important;

        padding: 0 !important;

        box-sizing: border-box !important;
    }

    /* Selected item/tag */
    #add_item_modal .specialStyles
    .select2-selection--multiple
    .select2-selection__choice {

        float: none !important;

        display: inline-flex !important;

        align-items: center !important;

        max-width: 100% !important;

        margin: 2px 0 !important;

        padding: 3px 7px !important;

        font-size: 13px !important;

        line-height: 20px !important;

        border-radius: 4px !important;

        box-sizing: border-box !important;
    }

    /* Text inside selected item */
    #add_item_modal .specialStyles
    .select2-selection__choice__display {

        max-width: calc(100vw - 100px) !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;
    }

    /* Remove button */
    #add_item_modal .specialStyles
    .select2-selection__choice__remove {

        flex-shrink: 0 !important;

        margin-right: 4px !important;
    }

    /* Search input stays inside field */
    #add_item_modal .specialStyles
    .select2-search--inline {

        display: inline-flex !important;

        max-width: 100% !important;

        margin: 2px 0 !important;
    }

    #add_item_modal .specialStyles
    .select2-search--inline .select2-search__field {

        width: auto !important;

        max-width: 100% !important;

        margin: 0 !important;

        padding: 2px !important;

        /* font-size: 16px !important; */

        box-sizing: border-box !important;
    }
}

@media (max-width: 767.98px) {

    /* ==========================================
       HIDE ORIGINAL LABEL ROW
       ========================================== */

    #add_item_modal .invoice_details:not(#FilterFieldsDiv)
    tr:has(th) {
        display: none !important;
    }


    /* ==========================================
       TWO FIELDS PER ROW
       ========================================== */

    #add_item_modal .invoice_details:not(#FilterFieldsDiv)
    tr:has(th) + tr {

        /* display: grid !important; */

        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;

        column-gap: 10px !important;

        width: 100% !important;

        margin: 0 !important;
    }


    /* ==========================================
       FIELD
       ========================================== */

    #add_item_modal .invoice_details:not(#FilterFieldsDiv)
    tr:has(th) + tr td {

        display: block !important;

        width: 100% !important;

        min-width: 0 !important;

        padding: 2px 3px 10px 3px !important;

        border: none !important;

        box-sizing: border-box !important;
    }


    /* ==========================================
       MOBILE LABEL
       ========================================== */

    #add_item_modal .invoice_details
    tr:has(th) + tr td[data-mobile-label]::before {

        content: attr(data-mobile-label) !important;

        display: block !important;

        width: 100% !important;

        margin: 0 0 4px 0 !important;

        padding: 0 !important;

        font-size: 11px !important;

        line-height: 16px !important;

        color: #555 !important;

        font-weight: 600 !important;

        text-align: left !important;

        box-sizing: border-box !important;
    }


    /* ==========================================
       HIDDEN FIELDS
       ========================================== */

    #add_item_modal .invoice_details
    tr:has(th) + tr td[style*="display: none"] {

        display: none !important;
    }


    /* ==========================================
       INPUTS

       HEIGHT NOT CHANGED
       ========================================== */

    #add_item_modal input.invoice-inputs,
    #add_item_modal select.invoice-inputs,
    #add_item_modal textarea.invoice-inputs,
    #add_item_modal .form-input {

        width: 100% !important;

        min-width: 0 !important;

        /* font-size: 16px !important; */

        box-sizing: border-box !important;
    }


    /* ==========================================
       SELECT2
       ========================================== */

    #add_item_modal .select-container,
    #add_item_modal .styleUnique,
    #add_item_modal .specialStyles {

        width: 100% !important;

        min-width: 0 !important;

        padding-left: 3px !important;
        padding-right: 3px !important;

        box-sizing: border-box !important;
    }

    #add_item_modal .select2-container {

        width: 100% !important;

        max-width: 100% !important;

        min-width: 0 !important;
    }


    /* ==========================================
       SELECT2 SINGLE

       DO NOT CHANGE HEIGHT
       ========================================== */

    #add_item_modal .select2-container
    .select2-selection--single {

        border: 1px solid #b3b3b3 !important;

        border-radius: 2px !important;
    }


    #add_item_modal .select2-container
    .select2-selection--single
    .select2-selection__rendered {

        /* font-size: 16px !important; */

        padding-left: 10px !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;
    }


    /* ==========================================
       MULTIPLE SELECT
       ========================================== */

    #add_item_modal .specialStyles
    .select2-container--default
    .select2-selection--multiple {

        border: 1px solid #b3b3b3 !important;

        border-radius: 5px !important;

        padding: 3px 5px !important;

        box-sizing: border-box !important;

        overflow: hidden !important;
    }

    #add_item_modal .specialStyles
    .select2-selection--multiple
    .select2-selection__rendered {

        display: flex !important;

        flex-wrap: wrap !important;

        align-items: center !important;

        gap: 3px !important;

        width: 100% !important;

        margin: 0 !important;

        padding: 0 !important;

        box-sizing: border-box !important;
    }

    #add_item_modal .specialStyles
    .select2-selection--multiple
    .select2-selection__choice {

        float: none !important;

        display: inline-flex !important;

        align-items: center !important;

        max-width: 100% !important;

        margin: 2px 0 !important;

        padding: 3px 7px !important;

        font-size: 13px !important;

        line-height: 20px !important;

        border-radius: 4px !important;

        box-sizing: border-box !important;
    }

    #add_item_modal .specialStyles
    .select2-selection__choice__display {

        max-width: calc(100vw - 100px) !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;
    }


    /* ==========================================
       DATE
       ========================================== */

    #add_item_modal .input-container {

        width: 100% !important;

        position: relative !important;
    }

    #add_item_modal .input-container input {

        width: 100% !important;

        /* font-size: 16px !important; */
    }

    #add_item_modal .calendar-icon {

        right: 10px !important;

        font-size: 15px !important;
    }


    /* ==========================================
       EX-FACTORY
       ========================================== */

    #add_item_modal .invoice_details td[style*="display: flex"] {

        display: block !important;

        width: 100% !important;

        padding: 5px 3px !important;
    }

    #add_item_modal .invoice_details a.btn {

        width: 100% !important;

        display: flex !important;

        align-items: center !important;

        justify-content: center !important;

        margin-top: 5px !important;

        font-size: 11px !important;
    }


    /* ==========================================
       HIDDEN SETTINGS TABLE
       ========================================== */

    #add_item_modal .invoice_details[style*="display: none"] {

        display: none !important;
    }


    /* ==========================================
       EMPTY ROW
       ========================================== */

    #add_item_modal .invoice_details
    tr[style*="height:10px"] {

        display: none !important;
    }


    /* ==========================================
       FOOTER
       ========================================== */

    #add_item_modal .modal-footer {

        padding: 10px 12px !important;

        border-top: 1px solid #eeeeee !important;

        background: #fff !important;
    }

    #add_item_modal .modal-footer .control-btns {

        width: 100% !important;

        padding: 0 !important;

        display: grid !important;

        grid-template-columns: repeat(3, 1fr) !important;

        gap: 6px !important;
    }

    #add_item_modal .modal-footer button {

        width: 100% !important;

        margin: 0 !important;

        padding: 7px 4px !important;

        font-size: 11px !important;

        white-space: nowrap !important;
    }


    /* ==========================================
       SMALL MOBILE
       ========================================== */

    @media (max-width: 380px) {

        #add_item_modal .modal-dialog {

            width: calc(100% - 10px) !important;

            margin: 5px auto !important;
        }

        #add_item_modal .modal-content {

            max-height: calc(100vh - 10px) !important;
        }

        #add_item_modal .modal-body {

            max-height: calc(100vh - 125px) !important;

            padding: 9px !important;
        }

        #add_item_modal .modal-title {

            font-size: 15px !important;
        }

        #add_item_modal .modal-footer .control-btns {

            gap: 4px !important;
        }

        #add_item_modal .modal-footer button {

            font-size: 10px !important;
        }
    }
}

/* =========================================================
   ADD ITEM MODAL - MOBILE (continuous 2 fields per row)
   ========================================================= */
@media (max-width: 767.98px) {

    /* ---------- Modal shell ---------- */
    
    #add_item_modal .modal-dialog {
        width: calc(100% - 20px) !important;
        max-width: none !important;
        margin: 10px auto !important;
    }
    #add_item_modal .modal-content {
        border: none !important;
        border-radius: 14px !important;
        max-height: calc(100vh - 20px) !important;
        overflow: hidden !important;
    }
    #add_item_modal .modal-header { padding: 15px 16px !important; }
    #add_item_modal .modal-title  { font-size: 17px !important; }
    #add_item_modal .modal-body {
        padding: 12px !important;
        max-height: calc(100vh - 135px) !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        -webkit-overflow-scrolling: touch;
    }
    #add_item_modal .modal-body > .col-md-12,
    #add_item_modal .modal-body .row,
    #add_item_modal .modal-body .col-md-12,
    #add_item_modal .modal-body .col-md-8 {
        width: 100% !important;
        max-width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* ---------- THE MAIN GRID ---------- */
    #add_item_modal .card-updated {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        column-gap: 10px !important;
        align-items: start !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
    }
    /* every direct child is full width by default */
    #add_item_modal .card-updated > * {
        grid-column: 1 / -1 !important;
        width: 100% !important;
        max-width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    #add_item_modal .sub-header-style {
        margin-top: 14px !important;
        margin-bottom: 4px !important;
        padding: 0 3px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
    }

    /* full width tables (Select Product / Display name / Address) */
    #add_item_modal .invoice_details {
        border: none !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }

    /* ---------- Field tables 1, 2, 3 -> their cells join the main grid ---------- */
    #add_item_modal .mobile-field-table-1,
    #add_item_modal .mobile-field-table-1 tbody,
    #add_item_modal .mobile-field-table-1 tr,
    #add_item_modal .mobile-field-table-2,
    #add_item_modal .mobile-field-table-2 tbody,
    #add_item_modal .mobile-field-table-2 tr,
    #add_item_modal .mobile-field-table-3,
    #add_item_modal .mobile-field-table-3 tbody,
    #add_item_modal .mobile-field-table-3 tr {
        display: contents !important;
    }

    /* hide original label cells (labels are drawn above each field instead) */
    #add_item_modal .mobile-field-table-1 th,
    #add_item_modal .mobile-field-table-2 th,
    #add_item_modal .mobile-field-table-3 th {
        display: none !important;
    }

    /* each field */
    #add_item_modal .mobile-field-table-1 td,
    #add_item_modal .mobile-field-table-2 td,
    #add_item_modal .mobile-field-table-3 td {
        display: block !important;
        grid-column: auto !important;
        width: 100% !important;
        min-width: 0 !important;
        border: none !important;
        padding: 2px 3px 10px 3px !important;
        box-sizing: border-box !important;
    }

    /* hidden / empty cells must not take a grid slot */
    #add_item_modal .mobile-field-table-1 td[style*="display: none"],
    #add_item_modal .mobile-field-table-2 td[style*="display: none"],
    #add_item_modal .mobile-field-table-3 td[style*="display: none"],
    #add_item_modal .mobile-field-table-3 td:empty {
        display: none !important;
    }

    /* label above each field */
    #add_item_modal .mobile-field-table-1 td[data-mobile-label]::before,
    #add_item_modal .mobile-field-table-2 td[data-mobile-label]::before,
    #add_item_modal .mobile-field-table-3 td[data-mobile-label]::before {
        content: attr(data-mobile-label);
        display: block;
        margin: 0 0 4px 0;
        font-size: 11px;
        line-height: 16px;
        font-weight: 600;
        color: #555;
        text-align: left;
    }

    /* ---------- Filters table (toggle keeps working) ---------- */
    #add_item_modal #FilterFieldsDiv[style*="display: block"] {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        column-gap: 10px !important;
    }
    #add_item_modal #FilterFieldsDiv tbody,
    #add_item_modal #FilterFieldsDiv tr { display: contents !important; }
    /* title "Product Filters" spans both columns */
    #add_item_modal #FilterFieldsDiv tr:first-child th {
        grid-column: 1 / -1 !important;
        height: auto !important;
        width: auto !important;
        padding: 2px 3px 6px !important;
        border: none !important;
    }
    /* label row hidden, labels drawn above fields */
    #add_item_modal #FilterFieldsDiv tr:nth-child(2) th { display: none !important; }
    #add_item_modal #FilterFieldsDiv td {
        display: block !important;
        width: 100% !important;
        min-width: 0 !important;
        border: none !important;
        padding: 2px 3px 10px 3px !important;
    }
    #add_item_modal #FilterFieldsDiv td[data-mobile-label]::before {
        content: attr(data-mobile-label);
        display: block;
        margin-bottom: 4px;
        font-size: 11px;
        line-height: 16px;
        font-weight: 600;
        color: #555;
    }
    #add_item_modal #FilterFieldsDiv td:last-child { text-align: right !important; }

    /* ---------- Inputs / selects ---------- */
    #add_item_modal input.invoice-inputs,
    #add_item_modal select.invoice-inputs,
    #add_item_modal textarea.invoice-inputs,
    #add_item_modal .form-input {
        width: 100% !important;
        min-width: 0 !important;
        margin-top: 0 !important;
        /* font-size: 16px !important;   */
        box-sizing: border-box !important;
    }
    #add_item_modal .input-container {
        position: relative !important;
        width: 100% !important;
        margin-top: 0 !important;
    }
    #add_item_modal .select2-container {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
    }
    #add_item_modal .select2-container .select2-selection--single {
        height: 32px !important;
        border: 1px solid #b3b3b3 !important;
        border-radius: 3px !important;
    }
    #add_item_modal .select2-container .select2-selection--single .select2-selection__rendered {
        font-size: 14px !important;
        line-height: 30px !important;
        height: 30px !important;
        padding-left: 8px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* Attributes multi-select: grows only when needed */
    #add_item_modal .select2-selection--multiple {
        height: auto !important;
        min-height: 32px !important;
        border: 1px solid #b3b3b3 !important;
        border-radius: 3px !important;
        padding: 2px 4px !important;
        box-sizing: border-box !important;
    }
    #add_item_modal .select2-selection--multiple .select2-selection__rendered {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 3px !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    #add_item_modal .select2-selection--multiple .select2-selection__choice {
        float: none !important;
        margin: 2px 0 !important;
        font-size: 12px !important;
        max-width: 100% !important;
    }

    /* ---------- Ex-Factory address (full width) ---------- */
    #add_item_modal .mobile-field-table-5 th,
    #add_item_modal .mobile-field-table-5 td {
        display: block !important;
        width: 100% !important;
        border: none !important;
        padding: 2px 3px 6px !important;
    }
    #add_item_modal .mobile-field-table-5 th {
        font-size: 11px !important;
        font-weight: 600 !important;
        color: #555 !important;
    }
    #add_item_modal .mobile-field-table-5 a.btn {
        width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        font-size: 11px !important;
    }

    /* ---------- Footer ---------- */
    #add_item_modal .modal-footer { padding: 10px 12px !important; }
    #add_item_modal .modal-footer .control-btns {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 6px !important;
        width: 100% !important;
        padding: 0 !important;
    }
    #add_item_modal .modal-footer button {
        width: 100% !important;
        margin: 0 !important;
        padding: 7px 4px !important;
        font-size: 11px !important;
        white-space: nowrap !important;
    }
    
    .mobile_padding_bottom_40 {
        padding: 2px 3px 40px 3px !important;
    }
    .top_20 {
        top: 20%;
    }

    /* NORMAL */
    input,
    textarea,
    select,
    .form-control,
    .invoice-inputs,
    .select2-selection__rendered,
    .select2-selection,
    .select2-container .select2-search__field,
    .select2-search__field,
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        font-size: 10px !important;
    }

    /* FOCUS / TYPING */
    input:focus,
    textarea:focus,
    select:focus,
    .form-control:focus,
    .invoice-inputs:focus,
    .select2-search__field:focus {
        font-size: 16px !important;
    }

    /* SELECT2 */
    .select2-container--focus .select2-selection,
    .select2-container--open .select2-selection,
    .select2-container--open .select2-search__field {
        font-size: 16px !important;
    }

}


</style>
<div class="modal fade newOrderStyles" id="add_item_modal" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding-left: 2.5rem;">
                <h3 class="modal-title" id="modal-title-default" style="color: black">Add New Item <span style="color: #b3b3b3;font-weight: 100;font-size: .8rem;">&nbsp;|&nbsp;#{{$orderNo}}</span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form id="add_modal_form">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row div_flexdir">
                            <div class="col-md-12">
                                <div class="card-updated row">
                                    {{-- <div class="card-header">Section 1 - Product</div> --}}
                                        <div class="col-md-12 row" style="border: none;margin-left: 1%;margin-right: 2%;">
                                            <div class="col-md-12" style="text-align: end">
                                                <button type="button" onclick="filterFielsdOptions()" style="color: #B3B3B3;cursor:pointer; margin-top:1rem;background-color: transparent;border: none;outline: unset;font-size: .8rem;">FILTERS&nbsp;&nbsp;<i id="FilterHideIcon" class="fa fa-chevron-right" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                        <table id="FilterFieldsDiv" class="table invoice_details mt-1 arange" style="border: none;margin-left: 2%;margin-right: 2%;display:none">
                                            <tr>
                                                <th style="color: black;font-size: 1rem;font-weight: 600 !important;height:40px">Product Filters</th>
                                            </tr>
                                            <tr>
                                                <th style="width: 30%" class="form-label">Sport</th>
                                                <th style="width: 30%" class="form-label">Gender</th>
                                                <th style="width: 30%" class="form-label">Category</th>
                                                <th style="width: 10%"></th>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_sport" id="item_sport" required>
                                                        <option value="all">Select Sport</option>
                                                        @foreach ($sports as $sport)
                                                            <option value="{{$sport->id}}">{{$sport->sport_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>


                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_gender" id="item_gender" required>
                                                        <option value="all">Select Gender</option>
                                                        <option value="Men">Men's</option>
                                                        <option value="Women">Women's</option>
                                                        <option value="Uni">Uni</option>
                                                    </select>
                                                </td>


                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_category" id="item_category" required>
                                                        <option value="all">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value='{{$category->id}}'>{{$category->product_category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="border-top-color: white;text-align:left">
                                                    <button type="button" class="btn btn-info btn-sm m-1" style="font-size: 14px; background-color:white; color:grey; border-color:transparent;" id="all_conditions1" title="Filter Product">
                                                        <i class="fas fa-solid fa-filter fa-2xs" style="color: #787878;" aria-hidden="true"></i>
                                                    </button>
                                                </td>

                                            </tr>

                                        </table>
                                        <div class="col-md-12 sub-header-style ml-2 mb-1">
                                            Select Product
                                        </div>

                                        <table class="table invoice_details mt-1 arange" style="border: none;margin-left: 1%;margin-right: 2%;">
                                            <tr>
                                                <td class="select-container styleUnique" style="padding-left: .7rem !important;">
                                                    <select class="invoice-inputs select2-add-item" onchange="changeDisplayName()" name="item_product" id="item_product" required>
                                                        <option disabled>Select Product</option>
                                                        {{-- @foreach($products as $product)
                                                            @if ($product->gender == 'Men' && $product->sport == 'Lacrosse')
                                                                <option value="{{$product->id}}">
                                                                    {{$product->product_name}}
                                                                    @if ($product->pattern_code)
                                                                        {{' ('.$product->pattern_code.')'}}
                                                                    @endif
                                                                </option>
                                                            @endif
                                                        @endforeach --}}
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="col-md-12 sub-header-style ml-2 mb-2 mt-2">
                                            Display name
                                        </div>
                                        <table class="table invoice_details arange" style="border: none;margin-left: 1%;margin-right: 2%;">
                                            <tr>
                                                <td class="select-container styleUnique" style="padding-left: .7rem !important;">
                                                    <input class="invoice-inputs" type="text" value="" id="product_display_name" name="product_display_name" style="border: 1px solid #B3B3B3 !important;">
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="col-md-8 sub-header-style mt-3" style="border: none;margin-left: 1%;margin-right: 2%;">
                                            Product Details
                                        </div>
                                        <table class="table invoice_details mt-1 arange mobile-field-table-1" style="border: none;margin-left: 2%;margin-right: 2%;">
                                            <tr>
                                                <th class="form-label" style="width:33.33%">Product Price</th>
                                                <th class="form-label" style="width:33.33%">Item Status</th>
                                                <th class="form-label" style="width:33.33%">Factory</th>

                                            </tr>
                                            <tr>
                                                <td>
                                                    {{-- <input type="hidden" name="product_price" id="product_price" value='' /> --}}
                                                    <div class="input-container mt-2">
                                                        <input style="margin-top: -3px;border: 1px solid #B3B3B3 !important;" class="invoice-inputs" name="product_price" id="product_price" type='number' value='' />
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="status_id" id="status_id" required>
                                                        <option value="">Select Status</option>
                                                        @foreach($orderStatuses as $orderStatus)
                                                        <option value="{{$orderStatus->id}}">{{$orderStatus->status_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="factory_id" id="factory_id" required>
                                                        <option value="">Select Factory</option>
                                                        @foreach($factories as $factory)
                                                        <option value="{{$factory->id}}">{{$factory->factory_code}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table invoice_details mt-1 arange mobile-field-table-2" style="border: none;margin-left: 2%;margin-right: 2%;">
                                            <input class="invoice-inputs" name="product_no" id="product_no" type='hidden' value='' readonly />
                                            <input type="hidden" name="product_name" id="product_name" value='' />
                                            <input type="hidden" name="pattern_code" id="pattern_code" value='' />
                                            {{-- <input type="hidden" name="product_price" id="product_price" value='' /> --}}
                                            {{-- <tr id="product_selection">
                                                <th>Product Name :</th>
                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_product" id="item_product" required>
                                                        <option value="">Select a Product</option>
                                                        @foreach($products as $product)
                                                        <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr> --}}


                                            <tr>

                                                <th class="form-label" style="width:33.33%">Primary Fabric</th>
                                                <th class="form-label" style="width:33.33%">Embellishment Type</th>
                                                <th class="form-label" style="width:33.33%">Shipping Method</th>
                                            </tr>
                                            <tr>


                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_fabric" id="item_fabric" required disabled>
                                                        <option value="">Select Primary Fabric</option>
                                                        @foreach($fabrics as $fabric)
                                                        <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_embellishment" id="item_embellishment" required>
                                                        <option value="">Select Embellishment</option>
                                                        {{-- @foreach($embellishments as $embellishment)
                                                        <option value="{{$embellishment->id}}">{{$embellishment->embellishment_name}}</option>
                                                        @endforeach --}}
                                                    </select>
                                                </td>
                                                <td class="uniqueStylePast">
                                                    <select class="invoice-inputs select2-add-item" name="item_shipping_method" id="item_shipping_method" required>
                                                        <option value="">Select Shipping Method</option>
                                                        <option value="Bulk">Bulk</option>
                                                        <option value="Bulk Sorted">Bulk Sorted</option>
                                                        <option value="DTD">DTD</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr style="height:10px"></tr>

                                            <tr>

                                                <th class="form-label" style="width:33.33%">Ex Factory Date</th>
                                                <th class="form-label" style="width:33.33%">Attributes</th>
                                                <th class="form-label" style="width:33.33%">Secondary Fabric</th>
                                            </tr>
                                            <tr>

                                                <td class="">
                                                    <div class="input-container mobile_padding_bottom_40">
                                                        <input style="margin-top: -3px" class="invoice-inputs modal-datepicker" name="item_delivery_date" id="item_delivery_date" onchange="changeAddItemExFactoryDate()" type="text" value='' required />
                                                        <i class="fas fa-calendar-alt calendar-icon top_20"></i>
                                                    </div>
                                                </td>
                                                <td class="specialStyles">
                                                    <select class="form-control form-input select2-people" id="item_attribute" name="item_attribute[]"  multiple="multiple">
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_secondary_fabric" id="item_secondary_fabric">
                                                        <option value="">Select Secondary Fabric</option>
                                                        @foreach($fabrics as $fabric)
                                                        <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>

                                        <table class="table invoice_details mt-1 arange mobile-field-table-3" style="border: none;margin-left: 2%;margin-right: 2%;">

                                            <tr>

                                                <th class="form-label" style="width:33.33%">Customer In-Hand Date</th>
                                                <th class="form-label clouserForHats"  style="display: none">Clouser Type</th>
                                                <th></th>

                                            </tr>
                                            <tr>


                                                <td>
                                                    <div class="input-container mt-1">
                                                        <input style="margin-top: -3px" class="invoice-inputs modal-datepicker" name="item_due_date" id="item_due_date" onchange="changeAddItemCustomerInHandDate()" type='text' value='' required />
                                                        <i class="fas fa-calendar-alt calendar-icon"></i>
                                                    </div>
                                                </td>
                                                <td class="clouserForHats mt-1" style="display: none">
                                                    <select class="invoice-inputs" name="clouser_type" id="clouser_type_edit">
                                                        <option value="">Select Clouser Type</option>
                                                        @foreach ($clouser_types as $clouser_type)
                                                        <option value="{{$clouser_type->id}}">{{$clouser_type->clouser_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </table>

                                        <table class="table invoice_details mobile-field-table-4" style="display: none">
                                            <tr>
                                                <th>Organization :</th>
                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_organization" id="item_organization" disabled>
                                                        <option value="">Select Organization</option>
                                                        @foreach($organizations as $organization)
                                                        <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <th>Support Agent :</th>
                                                <td>
                                                    <select class="invoice-inputs select2-add-item" name="item_support_agent" id="item_support_agent" disabled>
                                                        <option value="">Select Support Agent</option>
                                                        @foreach($users as $user)
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Unique Item # :</th>
                                                <td>
                                                    <input class="invoice-inputs" name="item_no" id="item_no" type='text' readonly />
                                                    <input type="hidden" id="item_id" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Order # :</th>
                                                <td><input class="invoice-inputs" name="item_order_no" id="item_order_no" type='text' value='{{$orderNo}}' readonly /></td>
                                            </tr>

                                            <tr>
                                                <th>Ex Factory Date :</th>
                                                <td>
                                                    <input class="invoice-inputs modal-datepicker" name="item_delivery_date" id="item_delivery_date" onchange="changeAddItemExFactoryDate()" type='text' value='' required />
                                                </td>
                                            </tr>


                                            {{-- <tr id="add_item_tr_encore_packing_date" @if($order->order_type == 0 || ($order->order_type == 1 && $order->address_type == 2)) style="display: none" @endif>
                                                <th>Encore Packing Date :</th>
                                                <td><input class="invoice-inputs item-datepicker" name="item_encore_packing_date" id="item_encore_packing_date" type='text' value='' onchange="changeAddItemEncorePackingDate()" required /></td>
                                            </tr> --}}
                                        </table>
                                        <table class="table invoice_details mobile-field-table-5" style="border: none;margin-left: 2%;margin-right: 2%;">
                                            <tr>
                                                <th class="form-label">Ex-Factory Address</th>
                                            </tr>
                                            <tr>
                                                <td style="display: flex;">
                                                    <select class="invoice-inputs select2-add-item" name="item_ex_factory_id" id="item_ex_factory_id" required>
                                                        <option value="0">Same as Customer Address</option>
                                                        @foreach ($exFactories as $exFactory)
                                                            <option value="{{$exFactory->id}}">{{$exFactory->ex_factory_name}} | {{$exFactory->po_box}}, {{$exFactory->city}}, {{$exFactory->state}}, {{$exFactory->postal_code}}, {{$exFactory->country}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="#" class="btn input-group-text" style="border: 1px solid #B3B3B3;width: 27%;color:#B3B3B3 !important" data-toggle="modal" data-target="#add_ex_factory_modal">
                                                        <i class="fas fa-plus"></i>&nbsp;ADD NEW ADDRESS
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                </div>

                            </div>


                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns" style="background-color: white">
                        <button type="button" class="swal2-confirm" id="btn_add_item"><i class="fas fa-plus"></i> Add</button>
                        <button type="button" style="background-color: rgb(125, 125, 206) !important" class="swal2-confirm" id="btn_edit_item"><i class="fas fa-edit"></i> Edit</button>
                        <button type="button" class="swal2-cancel" id="btn_cancel_item"><i class="fas fa-eraser"></i> Clear</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@include('pages.settings.ex_factory.create_modal')

<script>

    $(document).ready(function () {

    function setMobileFieldLabels() {

        $('#add_item_modal .invoice_details').each(function () {

            var table = $(this);

            table.find('tr').each(function () {

                var labelRow = $(this);

                var labels = labelRow.children('th');

                if (!labels.length) {
                    return;
                }

                var fieldRow = labelRow.next('tr');

                if (!fieldRow.length) {
                    return;
                }

                var fields = fieldRow.children('td');

                labels.each(function (index) {

                    var label = $.trim($(this).text());

                    var field = fields.eq(index);

                    if (field.length && label !== '') {

                        field.attr('data-mobile-label', label);
                    }
                });
            });
        });
    }

    setMobileFieldLabels();

    $('#add_item_modal').on('shown.bs.modal', function () {
        setMobileFieldLabels();
    });

});

    function changeDisplayName(){

        var sub_product = @json($subProducts);

        var selected_item = $('#item_product').val();

        var filteredSubProduct = sub_product.find(function(subProduct) {
            return subProduct.id == selected_item;
        });

        if(filteredSubProduct){

            $('#product_display_name').val(filteredSubProduct.product_name);

        }


    }
</script>

<script>
    function filterFielsdOptions() {
            var filterFieldsDiv = document.getElementById("FilterFieldsDiv");
            var filterHideIcon = document.getElementById("FilterHideIcon");

            if (filterFieldsDiv.style.display == "none") {
                // Display the filter fields div
                filterFieldsDiv.style.display = "block";
                // Change the icon to "chevron-down"
                filterHideIcon.className = "fa fa-chevron-down";
            } else {
                // Hide the filter fields div
                filterFieldsDiv.style.display = "none";
                // Change the icon to "chevron-right"
                filterHideIcon.className = "fa fa-chevron-right";
            }
        }
    document.addEventListener("DOMContentLoaded", function() {
        var style = document.createElement("style");
        style.textContent = ".select2-selection.select2-selection--multiple { border: 1px solid #e9ecef!important;height: 100px !important; }";
        document.head.appendChild(style);
    });


    function populateProductOptions() {
        var sportSelect = document.getElementById('item_sport');
        var genderSelect = document.getElementById('item_gender');
        var categorySelect = document.getElementById('item_category');
        var selectedSport = sportSelect.value;
        var selectedGender = genderSelect.value;
        var selectedCategory = categorySelect.value;

        var mainProducts = @json($products);
        var products = @json($subProducts);
        var product_sports = @json($product_sports);
        var product_category = @json($product_category);


        var productSelect = document.getElementById('item_product');
        productSelect.innerHTML = ''; // Clear existing options

        var filteredProducts = [];

        // Filter the sportProduct array to get all matching sport products
        var matchingSportProducts = product_sports.filter(function (sportProduct) {
            return sportProduct.sport_id == selectedSport;
        });

        // Filter the categoryProduct array to get all matching sport products
        var matchingCategoryProducts = product_category.filter(function (categoryProduct) {
            return categoryProduct.	product_category_id == selectedCategory;
        });



        // Get an array of product IDs from the matching sport products
        var matchingProductIDs = matchingSportProducts.map(function (sportProduct) {
            return sportProduct.product_id;
        });

        // Get an array of product IDs from the matching category products
        var matchingProductCategory = matchingCategoryProducts.map(function (categoryProduct) {
            return categoryProduct.product_id;
        });

        // Iterate over the products array
        for (var i = 0; i < products.length; i++) {
            var product = products[i];
            var mainProduct = mainProducts.find(mainProd => mainProd.id == product.parent_product_id);

            if (!mainProduct) {
                // If no mainProduct is found for the product, skip it
                continue;
            }

            var mainProductGender = mainProduct.gender; // Gender from mainProduct

            if (
                (selectedGender == 'all' || mainProductGender == selectedGender) &&
                (selectedSport == 'all' || matchingProductIDs.includes(product.id)) &&
                (selectedCategory == 'all' || matchingProductCategory.includes(product.id))
            ) {
                // Create a new option element
                var option = document.createElement('option');
                option.value = product.id;
                option.textContent = product.product_name;

                if (product.pattern_code) {
                    option.textContent += ' (' + product.pattern_code + ')';
                }

                // Append the new option to the select box
                productSelect.appendChild(option);

                // Add the filtered product to the array
                filteredProducts.push(product);
            }
        }

        // Now you have the filtered products in the filteredProducts array
        console.log('Filtered Products:', filteredProducts);
    }

    // Call the function initially when the page loads
    populateProductOptions();

    // Get the filter button element
    var filterButton1 = document.getElementById('all_conditions1');

    // Add click event listener to the filter button
    filterButton1.addEventListener('click', function() {
        populateProductOptions();
    });

    // Reset the select elements to their default values
    // function resetSelectElements() {
    //     sportSelect.value = sportSelect.getAttribute('data-default');
    //     genderSelect.value = genderSelect.getAttribute('data-default');
    //     categorySelect.value = categorySelect.getAttribute('data-default');
    // }

    // Add event listener to reset the select elements
    document.addEventListener('DOMContentLoaded', resetSelectElements);


</script>

<script>
    $(document).ready(function (){

        // $('#add_item_modal').on('shown.bs.modal', function (e) {
        //     addItemStart();
        // });

        // $('#item_product').select2({
        //     dropdownParent: $("#product_selection")
        // });

    // Filter Products by Sport
        // $('#item_sport').on('change', function(){
        //     var sport = $(this).val();
        //     var gender = $('#item_gender').val();
        //     var category = $('#item_category').val();

        //     $.ajax({
        //         url:"{{ url('new_orders/product_filter') }}/"+sport+"/"+gender+"/"+category,
        //         method:'GET',
        //         dataType:'json',
        //         success: function (data, textStatus, jqXHR){
        //             $('#item_product').html('<option value="">Select a Product</option>');

        //             for (var i = 0; i < data.length; i++) {
        //                 $('#item_product').append('<option value="'+data[i].id+'">'+data[i].product_name+'</option>');
        //             }
        //         }
        //     });
        // });

    // Filter Products by Gender
        // $('#item_gender').on('change', function(){
        //     var sport = $('#item_sport').val();
        //     var gender = $(this).val();
        //     var category = $('#item_category').val();

        //     $.ajax({
        //         url:"{{ url('new_orders/product_filter') }}/"+sport+"/"+gender+"/"+category,
        //         method:'GET',
        //         dataType:'json',
        //         success: function (data, textStatus, jqXHR){
        //             console.log(data);
        //             $('#item_product').html('<option value="">Select a Product</option>');

        //             for (var i = 0; i < data.length; i++) {
        //                 $('#item_product').append('<option value="'+data[i].id+'">'+data[i].product_name+'</option>');
        //             }
        //         }
        //     });
        // });

    // Filter Products by Category
        // $('#item_category').on('change', function(){
        //     var sport = $('#item_sport').val();
        //     var gender = $('#item_gender').val();
        //     var category = $(this).val();

        //     $.ajax({
        //         url:"{{ url('new_orders/product_filter') }}/"+sport+"/"+gender+"/"+category,
        //         method:'GET',
        //         dataType:'json',
        //         success: function (data, textStatus, jqXHR){
        //             console.log(data);
        //             $('#item_product').html('<option value="">Select a Product</option>');


        //             for (var i = 0; i < data.length; i++) {
        //                 $('#item_product').append('<option value="'+data[i].id+'">'+data[i].product_name+'</option>');
        //             }
        //         }
        //     });
        // });

        // $("#add_item_modal").on('shown.bs.modal', function (e) {
        //     // USA Date Fomat
        //     var today = (new Date().getMonth()+1)+'/'+new Date().getDate()+'/'+new Date().getFullYear();
        //     $('.modal-datepicker').val(today);
        //     $('.modal-datepicker').datepicker();
        // });

        $('select').select2();

        $('#item_product').on('change', function(){
            var subProductId = $(this).val();

            $.ajax({
                url:"{{ route('filter_sub_products') }}",
                method:'GET',
                dataType:'json',
                data:{ subProductId : subProductId},
                success: function (response){


                    $('#product_no').val(response.sub_product.sub_product_no);
                    $('#product_name').val(response.sub_product.product_name);
                    $('#pattern_code').val(response.sub_product.pattern_code);
                    $('#product_price').val(response.sub_product.default_price);

                    if(response.is_hat){
                        $('.clouserForHats').show();
                    }else{
                        $('.clouserForHats').hide();
                    }


                    $('#item_fabric').html('');
                    if(response.is_hat){
                        $('#item_fabric').prop('disabled', false);
                        var fabrics = @json($fabrics);
                        console.log(fabrics);
                        fabrics = fabrics.filter(function(fabric) {
                            return fabric.available_for_hats == 1;
                        });
                        if (fabrics.length > 0) {
                            $('<option value="" selected>Select Fabric</option>').appendTo($('#item_fabric'));
                            for (var i = 0; i < fabrics.length; i++) {
                                var option = $('<option>', {
                                    value: fabrics[i].id,
                                    text: fabrics[i].fabric_name
                                });

                                option.appendTo($('#item_fabric'));
                            }
                        }

                    }else{
                        $('#item_fabric').prop('disabled', true);
                        if(response.product_fabric !== null){

                            $('<option value="" selected>'+response.product_fabric+'</option>').appendTo($('#item_fabric'));

                        }else{
                            $('<option value="" selected>No fabric</option>').appendTo($('#item_fabric'));
                        }
                    }

                    var embellishmentTypeList = response.product_embellishment_type;

                    $('#item_embellishment').html('');
                    if(embellishmentTypeList.length > 0){

                        $('<option value="">Select an Embellishment</option>').appendTo($('#item_embellishment'));

                        for(var i = 0; i < embellishmentTypeList.length; i++){
                            $('<option value="'+ embellishmentTypeList[i].id +'">'+embellishmentTypeList[i].embellishment_name+'</option>').appendTo($('#item_embellishment'));
                        }
                    } else {
                        $('<option value="">No Embellishment</option>').appendTo($('#item_embellishment'));
                    }

                    var productAttribute = response.product_attributes;

                    $('#item_attribute').html('');

                    if(productAttribute.length > 0){
                        if(productAttribute.length > 1){
                            for(var i = 0; i < productAttribute.length; i++){
                                $('<option value="'+ productAttribute[i].id +'">'+productAttribute[i].attribute_name+'</option>').appendTo($('#item_attribute'));
                            }
                        }else{
                            $('<option value="'+ productAttribute[0].id +'" selected>'+productAttribute[0].attribute_name+'</option>').appendTo($('#item_attribute'));
                        }
                    }

                    var productFactory = response.product_factories;

                    $('#factory_id').html('');

                    if(productFactory.length > 0){
                        if(productFactory.length > 1){
                            for(var i = 0; i < productFactory.length; i++){
                                $('<option value="'+ productFactory[i].id +'">'+productFactory[i].factory_code+'</option>').appendTo($('#factory_id'));
                            }
                        }else{
                            $('<option value="'+ productFactory[0].id +'" selected>'+productFactory[0].factory_code+'</option>').appendTo($('#factory_id'));
                        }
                    }

                    doesEditButtonClick = 0;
                }
            });
        });

        $('#btn_add_item').on('click', function(){
            var itemOrganization = $('#item_organization').val();
            var itemSupportAgent = $('#item_support_agent').val();
            var itemDesigner = $('#item_designer').val() || '';
            var itemShippingMethod = $('#item_shipping_method').val();
            var itemExFactory = $('#item_ex_factory_id').val();
            var itemNo = $('#item_id').val();
            var itemUniqueNo = $('#item_no').val();
            var itemOrderNo = $('#item_order_no').val();
            var itemName = $('#product_name').val();
            var displayName = $('#product_display_name').val();
            var patternCode = $('#pattern_code').val();
            var clouser_type = $('#clouser_type_edit').val();
            var itemStatusId = $('#status_id').val();
            var itemStatus = $('#status_id option:selected').text();
            var itemPrice = $('#product_price').val();
            var itemDeliveryDate = $('#item_delivery_date').val();
            var itemEncorePackingDate = $('#item_encore_packing_date').val();
            var itemDueDate = $('#item_due_date').val();
            var itemProduct = $('#item_product').val();
            var itemFabric = $('#item_fabric').val();
            var itemSecondaryFabric = $('#item_secondary_fabric').val();
            var itemEmbellishment = $('#item_embellishment').val();
            var itemSport = $('#item_sport').val();
            var itemGender = $('#item_gender').val();
            var itemFactory = $('#factory_id').val();

            var itemFabric_text = ($('#item_fabric option:selected').text()=='Select Primary Fabric')? '' : $('#item_fabric option:selected').text();
            var itemEmbellishment_text = ($('#item_embellishment option:selected').text()=='Select an Embellishment')? '' : $('#item_embellishment option:selected').text();
            var itemAttributes = $("#item_attribute").val();

            var itemAttributes_text="";

            $("#item_attribute option:selected").each(function () {
                var $this = $(this);
                if ($this.length) {
                    var selText = $this.text();
                    if(itemAttributes_text==""){
                        itemAttributes_text=selText;
                    }else{
                        itemAttributes_text=itemAttributes_text+", "+selText;
                    }
                }
            });

            if(itemProduct == ""){
                swal({title: "Invalid Input?", text: 'Please Select a Product', type: "error", confirmButtonColor: "#ce0029",})
                .then((value) => {$($('#item_product').attr('data-focus')).focus();});

            } else {
                var itemStatus = itemStatus;

                var bgColor = '';
                var textColor = '';

                switch (itemStatus) {
                    case 'Quote':
                        textColor = '#FFB916';
                        bgColor = '#ffffcc';
                        break;
                    case 'Production':
                        textColor = '#47D6B6';
                        bgColor = '#d7ffcc';
                        break;
                    case 'Fulfilled':
                        textColor = '#717070';
                        bgColor = '#f8f8f8';
                        break;
                    case 'Canceled':
                        textColor = '#d65a47';
                        bgColor = '#ffcccc';
                        break;
                }

                $row = '<tr>'+
                    '<td><input type="text" class="invoice-inputs item-table-inputs item_name" name="item['+itemNo+'][item_name]" value="'+displayName+'" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+
                    '<td><input type="text" class="invoice-inputs item-table-inputs pattern_code" value="'+patternCode+'" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+
                    '<td style="width: 75px;vertical-align: middle;"><input type="text" class="invoice-inputs text-left status status-lable" style="color: '+textColor+' !important;background-color:'+bgColor+' !important;" name="item['+itemNo+'][status]" value="'+itemStatus+'" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+
                    '<td><input type="text" class="invoice-inputs delivery_date" name="item['+itemNo+'][est_delivery_date]" value="'+itemDeliveryDate+'" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+
                    '<td style="display:none"><input type="text" class="invoice-inputs tracking" name="item['+itemNo+'][tracking]" value="" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+

                    '<td><input type="text" class="invoice-inputs item-table-inputs fabric" name="item['+itemNo+'][fabric]" value="'+itemFabric_text+'" style="width: 60px; text-align: left;padding-left: 0px !important;" readonly /></td>'+
                    '<td><input type="text" class="invoice-inputs item-table-inputs embellishment" name="item['+itemNo+'][embellishment]" value="'+itemEmbellishment_text+'" readonly style="text-align: left;padding-left: 0px !important;" /></td>'+
                    '<td style="display:none"><input type="text" class="invoice-inputs item-table-inputs attributes" name="item['+itemNo+'][attributes]" value="'+itemAttributes_text+'" style="text-align: left;padding-left: 0px !important;" readonly /></td>'+

                    '<td><input type="text" class="invoice-inputs item-qty text-right" name="item['+itemNo+'][qty]" value="0" style="padding-right: 0px !important;" readonly /></td>'+
                    '<td><input type="text" class="invoice-inputs item-price text-right" name="item['+itemNo+'][unit_price]" value="'+itemPrice+'" style="text-align: right;padding-right: 0px !important;" readonly /></td>'+
                    '<td><input type="text" class="invoice-inputs item-total text-right" name="item['+itemNo+'][total]" value="0" style="text-align: right;padding-right: 0px !important;" readonly /></td>'+
                    '<td  style="vertical-align: middle;width:62px">'+
                        // '<button type="button" value="'+itemNo+'" class="btn btn-success btn-sm btn-sm-custom btn-gray" title="Edit"><i class="fas fa-eye"></i></button>'+
                        '<button type="button" value="'+itemNo+'" style="border: none;background-color: transparent;outline: unset;cursor:pointer; color:#B3B3B3" class="edit-item" id="edit_item_'+itemNo+'" title="Edit"><i class="fas fa-edit"></i></button>'+
                        '<button type="button" value="'+itemNo+'" style="border: none;background-color: transparent;outline: unset;cursor:pointer;color:#D00000" class="remove-item" title="Delete"><i class="fas fa-trash-alt"></i></button>'+
                    '</td>'+
                    '<input type="hidden" name="item['+itemNo+'][organization_id]" class="organization_id" value="'+itemOrganization+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][support_agent_id]" class="support_agent_id" value="'+itemSupportAgent+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][designer_id]" class="designer_id" value="'+itemDesigner+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][shipping_method]" class="shipping_method" value="'+itemShippingMethod+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][ex_factory_id]" class="ex_factory_id" value="'+itemExFactory+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][item_no]" class="item_no" value="'+itemUniqueNo+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][order_id]" class="order_id" value="'+itemOrderNo+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][encore_packing_date]" class="encore_packing_date" value="'+itemEncorePackingDate+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][in_hand_due_date]" class="in_hand_due_date" value="'+itemDueDate+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][status_id]" class="status_id" value="'+itemStatusId+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][product_id]" class="product_id" value="'+itemProduct+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][fabric_id]" class="fabric_id" value="'+itemFabric+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][secondary_fabric_id]" class="secondary_fabric_id" value="'+itemSecondaryFabric+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][embellishment_id]" class="embellishment_id" value="'+itemEmbellishment+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][sport]" class="sport" value="'+itemSport+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][gender]" class="gender" value="'+itemGender+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][factory_id]" class="factory_id" value="'+itemFactory+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][itemAttribute_ids]" class="itemAttribute_ids" value="'+itemAttributes+'" />'+
                    '<input type="hidden" name="item['+itemNo+'][clouser_type]" class="clouser_type" value="'+clouser_type+'" />'+
                    '</tr>';

                $('#product_table_body tr:last').after($row);
                $('#add_item_modal').modal('hide');

                $('#item_designer').val('');
                $('#item_shipping_method').val('');
                $('#item_ex_factory_id').val(0);
                $('#product_name').val('');
                $('#status_id').val('');
                $('#product_price').val('');
                $('#item_product').val('');
                $('#item_fabric').val('');
                $('#item_secondary_fabric').val('');
                $('#item_embellishment').val('');
                $('#product_no').val('');
                $('#item_sport').val('all');
                $('#item_gender').val('all');
                $('#item_category').val('all');
                $('#factory_id').val('');
                $('#row_no').val(parseInt(itemNo)+1);
            }
        });

        $('#btn_edit_item').on('click', function(){

            var itemOrganization = $('#item_organization').val();
            var itemSupportAgent = $('#item_support_agent').val();
            var itemDesigner = $('#item_designer').val() || '';
            var itemShippingMethod = $('#item_shipping_method').val();
            var itemExFactory = $('#item_ex_factory_id').val();
            var itemNo = $('#item_id').val();
            var itemUniqueNo = $('#item_no').val();
            var itemOrderNo = $('#item_order_no').val();
            var itemName = $('#product_name').val();
            var displayName = $('#product_display_name').val();
            var patternCode = $('#pattern_code').val();
            var clouser_type = $('#clouser_type_edit').val();
            var itemStatusId = $('#status_id').val();
            var itemStatus = $('#status_id option:selected').text();
            var itemPrice = $('#product_price').val();
            var itemDeliveryDate = $('#item_delivery_date').val();
            var itemDueDate = $('#item_due_date').val();
            var itemProduct = $('#item_product').val();
            var itemFabric = $('#item_fabric').val();
            var itemSecondaryFabric = $('#item_secondary_fabric').val();
            var itemEmbellishment = $('#item_embellishment').val();
            var itemSport = $('#item_sport').val();
            var itemGender = $('#item_gender').val();
            var itemFactory = $('#factory_id').val();

            var itemFabric_text = ($('#item_fabric option:selected').text()=='Select Primary Fabric')? '' : $('#item_fabric option:selected').text();
            var itemEmbellishment_text = ($('#item_embellishment option:selected').text()=='Select an Embellishment')? '' : $('#item_embellishment option:selected').text();
            var itemAttributes = $("#item_attribute").val();

            var itemAttributes_text="";

            $("#item_attribute option:selected").each(function () {
                var $this = $(this);
                if ($this.length) {
                    var selText = $this.text();
                    if(itemAttributes_text==""){
                        itemAttributes_text=selText;
                    }else{
                        itemAttributes_text=itemAttributes_text+", "+selText;
                    }
                }
            });

            var itemTr = $('#edit_item_'+itemNo).closest('tr');

            if(itemProduct == ""){
                swal({title: "Invalid Input?", text: 'Please Select a Product', type: "error", confirmButtonColor: "#ce0029",})
                .then((value) => {$($('#item_product').attr('data-focus')).focus();});

            } else {

                itemTr.find('.organization_id').val(itemOrganization);
                itemTr.find('.support_agent_id').val(itemSupportAgent);
                itemTr.find('.designer_id').val(itemDesigner);
                itemTr.find('.shipping_method').val(itemShippingMethod);
                itemTr.find('.ex_factory_id').val(itemExFactory);
                itemTr.find('.item_name').val(displayName);
                itemTr.find('.pattern_code').val(patternCode);
                itemTr.find('.clouser_type').val(clouser_type);
                itemTr.find('.status_id').val(itemStatusId);
                itemTr.find('.status').val(itemStatus);
                itemTr.find('.item-price').val(itemPrice);
                itemTr.find('.delivery_date').val(itemDeliveryDate);
                itemTr.find('.in_hand_due_date').val(itemDueDate);
                itemTr.find('.product_id').val(itemProduct);
                itemTr.find('.fabric_id').val(itemFabric);
                itemTr.find('.secondary_fabric_id').val(itemSecondaryFabric);
                itemTr.find('.embellishment_id').val(itemEmbellishment);
                itemTr.find('.sport').val(itemSport);
                itemTr.find('.gender').val(itemGender);
                itemTr.find('.factory_id').val(itemFactory);
                itemTr.find('.fabric').val(itemFabric_text);
                itemTr.find('.embellishment').val(itemEmbellishment_text);

                itemTr.find('.itemAttribute_ids').val(itemAttributes);
                itemTr.find('.attributes').val(itemAttributes_text);

                $('#add_item_modal').modal('hide');

                $('#item_designer').val('');
                $('#item_shipping_method').val('');
                $('#item_ex_factory_id').val(0);
                $('#product_name').val('');
                $('#status_id').val('');
                $('#product_price').val('');
                $('#item_product').val('');
                $('#item_fabric').val('');
                $('#clouser_type_edit').val('');
                $('#item_secondary_fabric').val('');
                $('#item_embellishment').val('');
                $('#product_no').val('');
                $('#item_sport').val('all');
                $('#item_gender').val('all');
                $('#item_category').val('all');
                $('#factory_id').val('');
            }
        });

        $('#all_conditions').on('click', function(){
            $('#item_sport').val('all');
            $('#item_gender').val('all');
            $('#item_category').val('all');
        });

        $('#btn_cancel_item').on('click', function(){
            addItemReset();
            addItemStart();
        });
    });

    function addItemStart(){
        $('#btn_edit_item').hide();
        $('#btn_add_item').show();

        var itemNo = $('#row_no').val();
        $('#item_id').val(itemNo);

        var orderNo = $('#order_no').val();
        $('#item_no').val(orderNo+'-'+itemNo);

        var dueDate = $('#due_date').val();
        // var encore_packing_date = $('#encore_packing_date').val();
        var ex_factory_date = $('#ex_factory_date').val();
        var orderStatusId = $('#order_status_id').val();
        if(orderStatusId == 8){
            orderStatusId = 3;
        }

        $('#item_due_date').val(dueDate);
        // $('#item_encore_packing_date').val(encore_packing_date);
        $('#item_delivery_date').val(ex_factory_date);
        $('#status_id').val(orderStatusId).change();
    }

    var doesEditButtonClick = 0;
    var local_itemFabric = "";
    var local_itemEmbellishment = "";
    var local_itemAttributes = "";

    function editItemStart(itemNo, itemTr){
        $('#btn_add_item').hide();
        $('#btn_edit_item').show();

        var itemOrganization = itemTr.find('.organization_id').val();
        var itemSupportAgent = itemTr.find('.support_agent_id').val();
        var itemDesigner = itemTr.find('.designer_id').val() || '';
        var itemShippingMethod = itemTr.find('.shipping_method').val();
        var itemExFactory = itemTr.find('.ex_factory_id').val();
        var itemUniqueNo = itemTr.find('.item_no').val();
        var itemOrderNo = itemTr.find('.order_id').val();
        var itemStatusId = itemTr.find('.status_id').val();
        var clouser_type = itemTr.find('.clouser_type').val();
        var itemDeliveryDate = itemTr.find('.delivery_date').val();
        var itemEncorePackingDate = itemTr.find('.encore_packing_date').val();
        var itemDueDate = itemTr.find('.in_hand_due_date').val();
        var itemProduct = itemTr.find('.product_id').val();
        var itemFabric = itemTr.find('.fabric_id').val();
        var itemSecondaryFabric = itemTr.find('.secondary_fabric_id').val();
        var itemEmbellishment = itemTr.find('.embellishment_id').val();
        var itemSport = itemTr.find('.sport').val();
        var itemGender = itemTr.find('.gender').val();
        var itemFactory = itemTr.find('.factory_id').val();
        var DisplayName = itemTr.find('.item_name').val();
        var itemPrice = itemTr.find('.item-price').val();

        var itemAttributes = itemTr.find('.itemAttribute_ids').val();

        $('#item_organization').val(itemOrganization).trigger('change');
        $('#item_support_agent').val(itemSupportAgent).trigger('change');
        $('#item_designer').val(itemDesigner).trigger('change');
        $('#item_shipping_method').val(itemShippingMethod).trigger('change');
        $('#item_ex_factory_id').val(itemExFactory).trigger('change');
        $('#item_id').val(itemNo);
        $('#item_no').val(itemUniqueNo);
        $('#item_order_no').val(itemOrderNo);
        $('#status_id').val(itemStatusId).trigger('change');
        $('#item_delivery_date').val(itemDeliveryDate);
        $('#item_encore_packing_date').val(itemEncorePackingDate);
        $('#item_due_date').val(itemDueDate);
        $('#item_product').val(itemProduct).trigger('change');
        // $('#item_fabric').val(itemFabric).trigger('change');
        $('#item_secondary_fabric').val(itemSecondaryFabric).trigger('change');
        $('#clouser_type_edit').val(clouser_type).trigger('change');
        // $('#item_embellishment').val(itemEmbellishment).trigger('change');
        $('#item_sport').val(itemSport).trigger('change');
        $('#item_gender').val(itemGender).trigger('change');
        $('#factory_id').val(itemFactory).trigger('change');

        $('#product_display_name').val(DisplayName);
        $('#product_price').val(itemPrice);

        doesEditButtonClick = 1;
        local_itemFabric = itemFabric;
        local_itemEmbellishment = itemEmbellishment;
        local_itemAttributes = JSON.parse("["+itemAttributes+"]");
    }

    function addItemReset(){
        $('#item_designer').val('').trigger('change');
        $('#item_shipping_method').val('').trigger('change');
        $('#item_ex_factory_id').val(0).trigger('change');
        $('#product_name').val('');
        $('#status_id').val('').trigger('change');
        $('#pattern_code').val('');
        $('#clouser_type_edit').val('');
        $('#product_price').val('');
        $('#item_product').val('').trigger('change');
        $('#item_fabric').val('').trigger('change');
        $('#item_secondary_fabric').val('').trigger('change');
        $('#item_embellishment').val('').trigger('change');
        $('#product_no').val('');
        $('#item_sport').val('all').trigger('change');
        $('#item_gender').val('all').trigger('change');
        $('#item_category').val('all').trigger('change');
        $('#factory_id').val('').trigger('change');
        $('#item_attribute').val('').trigger('change');
        $('#product_display_name').val('');
    }

    function changeAddItemExFactoryDate(){
        var ex_factory_date = $("#item_delivery_date").val();

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
                $('#item_due_date').val(data);
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });

    }

    function changeAddItemCustomerInHandDate(){
        var due_date = $("#item_due_date").val();

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
                $('#item_delivery_date').val(data);
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }
</script>
