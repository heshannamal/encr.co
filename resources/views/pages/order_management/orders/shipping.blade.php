<style>
    #notification_body + .Editor-container .Editor-editor {
        height: 500px !important;
    }
    .shipping-group-text {
        width: 80px !important;
    }
    #shipping_notification .select2.select2-container.select2-container--default{
        width: 100%;
    }
    #shipping_notification .input-group {
        flex-direction: row;
        flex-wrap: nowrap !important;
    }
    .Editor-editor b,
    .Editor-editor strong {
        font-weight: bold;
    }
    .Editor-editor p {
        margin-bottom: 0rem;
    }
    .th{
        font-weight: 100 important!;
    }

    #shipping_items_table {
        width: 150%;
    }
    .emergency-edit-3 {
        opacity: 0.5; /* You can adjust the opacity to visually indicate it's disabled */
        pointer-events: none; /* Disable pointer events to prevent further clicks */
    }
    .remake-edit-3{
        background-color: #f789d85d !important;
    }
    .select2-selection__rendered{
        background-color: rgb(246, 246, 246) !important;
        color: black !important;
    }
    .select2-container--default .select2-selection--single{
        background-color: unset !important;
    }
    .notify-status {
        width: 70px;
        padding: 0.2rem 0rem;
        margin-bottom: 0rem;
        color: #ffffff;
        text-transform: uppercase;
        font-size: 10px;
        text-align: center;
        border-radius: 12px;
        margin-right: auto;
        margin-left: auto;
    }
    .notify-not-sent {
        background-color: #f5365c;
    }
    .notify-remake{
        background-color: #b536f5;
    }
    .notify-user {
        margin-bottom: 0rem;
        font-size: 14px;
    }
    .table-card-body{
        position: relative;
        top: -57px;
        left: -70px;
        width: 109.5%;
    }
    .parent-table-header{
        height: 36px;
        text-align: center;
        border-bottom: 2px solid #d7d7d7;
    }
    .expand-button{
        background-color: transparent;
        border: none;

    }
    .select2-container--default .select2-selection--single {
        text-align: center;
    }
    .btn-div {
        width: 118%;
        position: relative;
        left: -60px;
        top: -50px;
    }
    .status-span{
        background-color: red;
        position: relative;
        border-radius: 5px;
        left: 18px;
        height: 23px;
        width: 151px;
        top: 15px;
        font-size: 13px;
        color: white;
        vertical-align: middle;
    }
    .select2-selection__rendered{
        text-align: left;
    }
    .remake_items_bg{
        background-color: #f8ff90
    }

    /* .select2-selection__rendered{
        background-color: rgb(62, 167, 121);
        border-radius: 1rem;
        width: 63%;
        position: relative;
        left: 37px;
        color: white !important;
    } */

    input[type="number"] {
        background-color: transparent;
    }
    input[type="text"] {
        background-color: transparent;
    }
    <style>
    .select2-container {
        display: none !important;
    }
    .table-card-body{
        min-height: 18rem !important;
    }
    .product_details{
        min-height: 7rem !important;
    }
    .notify-sent {
        background-color: #2dce89;
    }

    .empty-notice {
        background-color: #ffff00 !important;
    }
    .swal2-styled.swal2-cancel{
        padding: .25rem 2.5rem;
    }
    .swal2-confirm{
        padding-left:  2em !important;
        padding-right:  2em !important;
    }


    @media only screen and (width: 1920px)   {

    .btn0 {
        display: none;
    }
    .btn1 {
        left: 25.5%;

    }
    .btn2 {

        left: 25%;
    }
    .btn3 {

        left: 16.5%;
    }
    .btn4 {

        left: 15%;
    }
    .btn5 {

        left: 12%;
    }
}

    @media only screen and (min-width: 1174px)  and (max-width: 1500px) {

    .btn0 {
    display: none;
    }
    .btn1 {
    left: 11%;

    }
    .btn2 {

    left: 11%;
    }
    .btn3 {

    left: 14%;
    }
    .btn4 {

    left: 17%;
    }
    .btn5 {

    left: 18% !important;
    }

}
@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
    .btngroup{
        flex-wrap: wrap;
    }
}
body {
        font-family: 'Open Sans', 'sans-serif' !important;
    }
.header-style{
    color: black;
    font-size: 1rem;
    font-weight: 600;
}

.mobile-field-label {
    display: none;
}
.mobile-expanded-label {
    display: none;
}
.mobile-child-label {
    display: none;
}

@media (max-width: 768px) {

    .mobile-field-label {
        display: block;
    }
    .mobile-expanded-label {
        display: block;
        display: block !important;
        margin-bottom: 6px !important;
        font-size: 10px !important;
        line-height: 1.2 !important;
        font-weight: 700 !important;
        letter-spacing: 0.5px !important;
        color: #8a8f98 !important;
        text-align: center !important;
    }
    .shipping-responsive-table {
        width: 100%;
        border: 0 !important;
    }

    .shipping-responsive-table thead {
        display: none;
    }

    .shipping-responsive-table tbody,
    .shipping-responsive-table tr {
        display: block;
        width: 100%;
    }


    /* Each row becomes card */
    .shipping-responsive-table tbody tr {
        background: #fff;
        margin-bottom: 15px;
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,.12);
        /* border: 1px solid #ddd !important; */
        margin-top: 28px;
    }


    /* Keep hidden collapse rows working */
    .shipping-responsive-table tr.collapse {
        display: none;
    }

    .shipping-responsive-table tr.collapse.show {
        display: block;
        margin: unset;
    }


    /* Each td */
    .shipping-responsive-table td,
    .shipping-responsive-table th {
        display: flex;
        width: 100% !important;
        padding: 8px !important;
        border:0 !important;
        align-items:center;
    }

    .mobile-expanded-field.mobile-expanded-size {
        width: 100%;
    }
    .expand-button.mr-1.ForClickFunc {
        position: relative;
        text-align: right;
        right: -80%;
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 !important;
        border: 1px solid #e1e1e1 !important;
        border-radius: 50% !important;
        background: #f7f7f7 !important;
        color: #333 !important;
        box-shadow: none !important;
    }

    /* Checkbox column */
    .shipping-responsive-table td:first-child {
        width:auto !important;
        display:flex;
        justify-content:flex-start;
        background-color: transparent !important;
        min-height: 78px !important;
        background: #f1f5f9 !important;
    }


    /* Inputs full width */
    .shipping-responsive-table input,
    .shipping-responsive-table select {
        width:100%;
        max-width:100%;
    }


    /* Product name */
    .shipping-responsive-table .invoice-inputs {
        background: rgba(255, 255, 255, 0.55);
        border-radius:6px;
        padding:8px;
    }


    /* Expand button */
    .shipping-responsive-table .expand-button {
        margin-right:8px;
        padding: 3px 8px;
        border-radius: 50%;
        background-color: white;
    }


    /* Hide empty columns */
    .shipping-responsive-table td:empty,
    .shipping-responsive-table th {
        display:none;
    }

    .shipping-responsive-table td::before{
        font-weight:600;
        min-width:110px;
        margin-right:10px;
    }


    /* Header table layout restore */
    #shipping_items_table thead{
        display: table-header-group !important;
        border-bottom: unset;
    }

    #shipping_items_table thead tr{
        display: table-row !important;
    }

    #shipping_items_table thead th{
        display:none !important;
    }

    /* Only first header cell (main checkbox) */
    #shipping_items_table thead th:first-child{
        display:table-cell !important;
        width:60px !important;
        padding:12px !important;
        background:#fff !important;
        text-align: left !important;
        vertical-align:middle !important;
    }

    #shipping_items_table thead th:first-child input[type="checkbox"]{
        display:inline-block !important;
        visibility:visible !important;
        opacity:1 !important;
        position:static !important;
        width:20px !important;
        height:20px !important;
        margin:0 !important;
        transform:scale(1.2);
        pointer-events:auto !important;
    }


    /* Make main checkbox slightly larger */
    #maincheckbox {
        transform: scale(1.2);
    }
    #shipping_items_table {
        width: 100% !important;
    }
    .table-card-body {
        width: 100% !important;
        margin-bottom: unset !important;
    }
    .mobile_table_overflow {
        overflow-x: unset !important;
    }
    .mobile_display_hide {
        display: none !important;
    }
    .chkItemMainChild {
        width: 25px;
        height: 25px;
    }

}
/* =========================================================
   MOBILE SHIPPING MAIN ITEM CARD
   ========================================================= */

@media (max-width: 767.98px) {

    /* =====================================================
       MAIN TABLE / CARD CONTAINER
       ===================================================== */

    .shipping-responsive-table {
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 12px !important;
        margin: 0 !important;
    }

    /* Hide desktop table header */
    .shipping-responsive-table > thead {
        display: none !important;
    }

    .mobile-main-child-card.show {

        display: grid !important;

        grid-template-columns:
            repeat(6, minmax(0, 1fr));

        width: 100% !important;

        box-sizing: border-box !important;

        background: #eeeeee !important;

        border: 1px solid #e5e7eb !important;

        border-radius: 12px !important;

        margin: 14px 0 1px 0 !important;

        padding: 12px !important;

        box-shadow:
            0 3px 10px rgba(0, 0, 0, 0.05) !important;

        overflow: hidden !important;

        position: relative;
        width: calc(100% - 12px) !important;
        right: -12px;
    }

    /* =====================================================
       MAIN ITEM CARD

       6 equal columns

       1st row:
       Checkbox | Product x4 | Expand

       ===================================================== */

    .shipping-responsive-table tbody tr.mobile-main-item-card {
        display: grid !important;

        grid-template-columns:
            repeat(6, minmax(0, 1fr));

        background: #e8e8e8;

        border: 1px solid #e5e7eb !important;
        border-radius: 14px !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        margin-bottom: 2px !important;
        margin-top: 28px;

        padding: 14px !important;

        overflow: hidden;
    }


    /* Remove normal table behavior */
    .shipping-responsive-table tbody tr.mobile-main-item-card > td {
        display: block !important;

        width: auto !important;

        padding: 0 !important;

        border: 0 !important;

        background: transparent !important;

        min-width: 0 !important;
    }


    /* =====================================================
       ROW 1

       Checkbox | Product Name x4 | Expand

       1 column |     4 columns | 1 column
       ===================================================== */

    .mobile-main-item-card .mobile-card-checkbox {
        grid-column: 1;
        grid-row: 1;

        display: flex !important;

        align-items: center;
        justify-content: flex-start;

        min-height: 42px;
    }


    .mobile-main-item-card .mobile-card-product {
        grid-column: 2 / 6;
        grid-row: 1;

        display: flex !important;

        align-items: center;

        min-width: 0 !important;

        padding: 0 6px !important;
    }


    .mobile-main-item-card .mobile-card-expand {
        grid-column: 6;
        grid-row: 1;

        display: flex !important;

        align-items: center;
        justify-content: flex-end;

        min-height: 42px;
    }


    /* =====================================================
       CHECKBOX
       ===================================================== */

    .mobile-main-item-card
    .mobile-card-checkbox
    input[type="checkbox"] {

        width: 18px !important;

        height: 18px !important;

        margin: 0 !important;

        cursor: pointer;
    }


    /* =====================================================
       PRODUCT NAME
       ===================================================== */

    .mobile-main-item-card
    .mobile-card-product
    .invoice-inputs {

        width: 100% !important;

        min-width: 0 !important;

        font-size: 15px !important;

        font-weight: 600 !important;

        text-align: left !important;

        border: 0 !important;

        background: transparent !important;

        padding: 0 !important;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    /* =====================================================
       EXPAND BUTTON
       ===================================================== */

    .mobile-main-item-card
    .mobile-card-expand
    .parent-expand-button {

        width: 34px;

        height: 34px;

        display: flex !important;

        align-items: center;

        justify-content: center;

        padding: 0 !important;

        border: 1px solid #e1e1e1 !important;

        border-radius: 50% !important;

        background: #f7f7f7 !important;

        color: #333 !important;

        box-shadow: none !important;
    }


    .mobile-main-item-card
    .mobile-card-expand
    .parent-expand-button i {

        font-size: 16px;
    }


    /* =====================================================
       ROW 2

       Order Qty | Shipped Qty | Backordered

       Each field = 2 columns
       ===================================================== */

    .mobile-main-item-card .mobile-order-qty {

        grid-column: 1 / 3;

        grid-row: 2;

        min-width: 0 !important;

        width: 100% !important;
    }


    .mobile-main-item-card .mobile-shipped-qty {

        grid-column: 3 / 5;

        grid-row: 2;

        min-width: 0 !important;

        width: 100% !important;
    }


    .mobile-main-item-card .mobile-backordered-qty {

        grid-column: 5 / 7;

        grid-row: 2;

        min-width: 0 !important;

        width: 100% !important;
    }


    /* =====================================================
       ROW 3

       Est Delivery | Courier Service

       Each field = 3 columns
       ===================================================== */

    .mobile-main-item-card .mobile-est-delivery {

        grid-column: 1 / 4;

        grid-row: 3;

        min-width: 0 !important;

        width: 100% !important;
    }


    .mobile-main-item-card .mobile-courier-service {

        grid-column: 4 / 7;

        grid-row: 3;

        min-width: 0 !important;

        width: 100% !important;
    }


    /* =====================================================
       ROW 4

       Tracking # | Tracking Link

       Each field = 3 columns
       ===================================================== */

    .mobile-main-item-card .mobile-tracking-no {

        grid-column: 1 / 4;

        grid-row: 4;

        min-width: 0 !important;

        width: 100% !important;
    }


    .mobile-main-item-card .mobile-tracking-link {

        grid-column: 4 / 7;

        grid-row: 4;

        min-width: 0 !important;

        width: 100% !important;
    }


    /* =====================================================
       ROW 5

       Notify | Notified By

       Each field = 3 columns
       ===================================================== */

    .mobile-main-item-card .mobile-notify {

        grid-column: 1 / 4;

        grid-row: 5;

        min-width: 0 !important;

        width: 100% !important;
    }


    .mobile-main-item-card .mobile-notified-by {

        grid-column: 4 / 7;

        grid-row: 5;

        min-width: 0 !important;

        width: 100% !important;
    }


    /* =====================================================
       COMMON FIELD STYLING
       ===================================================== */

    .mobile-main-item-card .mobile-card-field {

        min-width: 0 !important;

        width: 100% !important;

        padding: 10px 7px !important;

        margin-top: 6px;

        border-top: 1px solid #eeeeee !important;

        box-sizing: border-box;
    }


    .mobile-main-item-card .mobile-field-label {

        display: block !important;

        font-size: 10px !important;

        font-weight: 600 !important;

        color: #8a8a8a !important;

        text-transform: uppercase;

        letter-spacing: 0.3px;

        margin-bottom: 3px;
    }


    .mobile-main-item-card
    .mobile-card-field
    .invoice-inputs {

        width: 100% !important;

        min-width: 0 !important;

        max-width: 100% !important;

        height: auto !important;

        padding: 0 !important;

        border: 0 !important;

        background: transparent !important;

        font-size: 14px !important;

        font-weight: 600 !important;

        color: #222 !important;

        text-align: left !important;

        box-sizing: border-box;
    }


    /* =====================================================
       NOTIFY
       ===================================================== */

    .mobile-main-item-card
    .mobile-notify
    .notify-status {

        margin: 0 !important;

        font-size: 14px !important;

        text-align: left !important;
    }


    /* =====================================================
       NOTIFIED BY
       ===================================================== */

    .mobile-main-item-card
    .mobile-notified-by
    .notify-user {

        margin: 0 !important;

        font-size: 14px !important;

        text-align: left !important;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    /* =====================================================
       READONLY / DISABLED INPUTS
       ===================================================== */

    .mobile-main-item-card input[readonly],
    .mobile-main-item-card input[disabled] {

        opacity: 1 !important;

        -webkit-text-fill-color: #222 !important;
    }


    /* =====================================================
       EXISTING CHILD ROWS / COLLAPSE
       ===================================================== */

    .shipping-responsive-table tbody tr.collapse {

        width: 100%;
    }


    /* =====================================================
       REMAKE ITEM SEPARATOR
       ===================================================== */

    .shipping-responsive-table tbody tr td[colspan="14"] {

        width: 100% !important;
    }
    .mobile_table_header {
        background-color: transparent !important;
        border: unset !important;
        box-shadow: unset !important;
        padding: unset !important;
        height: 0px !important;
    }

    .shipping-responsive-table .mobile_remake_topic {
        background-color: transparent !important;
    }

    .mobile-detail-size {
        grid-column: 2 / 7;
        grid-row: 1;
        min-height: 78px !important;
        background: #f1f5f9 !important;
    }
    .mobile-detail-qty {
        grid-column: 1 / 3;
        grid-row: 2;
    }
    .mobile-detail-shipped {
        grid-column: 3 / 5;
        grid-row: 2;
    }
    .mobile-detail-backordered {
        grid-column: 5 / 7;
        grid-row: 2;
    }
    .mobile-detail-courier {
        grid-column: 1 / 4;
        grid-row: 3;
    }
    .mobile-detail-tracking {
        grid-column: 4 / 7;
        grid-row: 3;
        text-align: left;
    }
    .mobile-detail-tracking-link {
        grid-column: 1/7;
        grid-row: 4;
        text-align: left;
    }
    .mobile-detail-player-name {
        display: none !important;
    }
    .mobile-detail-player-number {
        display: none !important;
    }
    .mobile-detail-delivery {
        display: none !important;
    }
    .mobile-detail-notify {
        display: none !important;
    }
    .mobile-detail-notified-by {
        display: none !important;
    }
    .mobile-expanded-orderqty-value {
        text-align: center;
        padding-top: 8px;
        height: 40px;
    }
    .mobile-detail-qty .mobile-expanded-field {
        width: 100%;
    }
    .mobile-detail-courier .mobile-expanded-field {
        width: 100%;
    }
    .mobile-detail-tracking .mobile-expanded-field {
        width: 100%;
    }
    .mobile-detail-tracking-link .mobile-expanded-field {
        width: 100%;
    }
}



@media (max-width: 767.98px) {

    /* -----------------------------------------------------
       CHILD CARD
       ----------------------------------------------------- */

    .shipping-responsive-table tbody tr.mobile-child-card {

        display: grid;

        grid-template-columns:
            repeat(6, minmax(0, 1fr));

        width: 100% !important;

        box-sizing: border-box !important;

        background: #e4e4e4 !important;

        border: 1px solid #e5e7eb !important;

        border-radius: 12px !important;

        margin: -6px 0 14px 0 !important;

        padding: 12px !important;

        box-shadow:
            0 3px 10px rgba(0, 0, 0, 0.05) !important;

        overflow: hidden !important;

        position: relative;
        gap: 8px;
    }


    /* -----------------------------------------------------
       RESET TD
       ----------------------------------------------------- */

    .shipping-responsive-table
    tbody
    tr.mobile-child-card
    > td {

        display: block !important;

        width: auto !important;

        min-width: 0 !important;

        padding: 0 !important;

        margin: 0 !important;

        border: 0 !important;

        background: transparent !important;

        box-sizing: border-box !important;
    }


    /* =====================================================
       ROW 1
       Checkbox | Add | Size | Player | Number
       ===================================================== */

    .mobile-child-card .mobile-child-checkbox {

        grid-column: 1;
        grid-row: 1;

        display: flex !important;

        align-items: center;

        justify-content: flex-start;

        min-height: 42px;
    }


    .mobile-child-card .mobile-child-add {

        grid-column: 2;
        grid-row: 1;

        display: flex !important;

        align-items: center;

        justify-content: center;

        min-height: 42px;
    }


    .mobile-child-card .mobile-child-size {

        grid-column: 3 / 7;
        grid-row: 1;

        display: flex !important;

        flex-direction: column;

        justify-content: center;

        min-width: 0 !important;

        padding: 0 7px !important;
        text-align: left;
    }


    .mobile-child-card .mobile-child-player {

        grid-column: 1 / 4;
        grid-row: 2;

        display: flex !important;

        flex-direction: column;

        justify-content: center;

        min-width: 0 !important;

        padding: 0 7px !important;
    }


    .mobile-child-card .mobile-child-number {

        grid-column: 4 / 7;
        grid-row: 2;

        display: flex !important;

        flex-direction: column;

        justify-content: center;

        min-width: 0 !important;

        padding: 0 5px !important;
    }


    /* -----------------------------------------------------
       CHECKBOX
       ----------------------------------------------------- */

    .mobile-child-card
    .mobile-child-checkbox
    input[type="checkbox"] {

        width: 19px !important;

        height: 19px !important;

        margin: 0 !important;

        cursor: pointer;

        accent-color: #333;
    }


    /* -----------------------------------------------------
       ADD TO REMAKE ICON
       ----------------------------------------------------- */

    .mobile-child-card .mobile-child-add i {

        font-size: 20px !important;

        color: #a7a7a7 !important;

        cursor: pointer;

        transition: all .2s ease;
    }


    .mobile-child-card .mobile-child-add i:active {

        transform: scale(.88);
    }


    /* =====================================================
       LABEL
       ===================================================== */

    .mobile-child-card .mobile-child-label {

        display: block !important;

        width: 100% !important;

        margin-bottom: 3px !important;

        font-size: 9px !important;

        line-height: 1.2 !important;

        font-weight: 700 !important;

        letter-spacing: .45px !important;

        text-transform: uppercase !important;

        color: #8b8f96 !important;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    /* -----------------------------------------------------
       NORMAL VALUE
       ----------------------------------------------------- */

    .mobile-child-card .mobile-child-value {

        display: block !important;

        width: 100% !important;

        min-width: 0 !important;

        font-size: 14px !important;

        line-height: 1.3 !important;

        font-weight: 600 !important;

        color: #252525 !important;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    /* =====================================================
       ROW 2
       Order Qty | Shipped | Backordered
       2 columns each
       ===================================================== */

    .mobile-child-card .mobile-child-order-qty {

        grid-column: 1 / 3;

        grid-row: 3;
    }


    .mobile-child-card .mobile-child-shipped {

        grid-column: 3 / 5;

        grid-row: 3;
    }


    .mobile-child-card .mobile-child-backordered {

        grid-column: 5 / 7;

        grid-row: 3;
    }


    /* =====================================================
       ROW 3
       Delivery | Courier
       3 columns each
       ===================================================== */

    .mobile-child-card .mobile-child-delivery {

        grid-column: 1 / 4;

        grid-row: 4;
    }


    .mobile-child-card .mobile-child-courier {

        grid-column: 4 / 7;

        grid-row: 4;
    }


    /* =====================================================
       ROW 4
       Tracking | Tracking Link
       3 columns each
       ===================================================== */

    .mobile-child-card .mobile-child-tracking {

        grid-column: 1 / 4;

        grid-row: 5;
    }


    .mobile-child-card .mobile-child-tracking-link {

        grid-column: 4 / 7;

        grid-row: 5;
    }


    /* =====================================================
       ROW 5
       Notify | Notified By
       3 columns each
       ===================================================== */

    .mobile-child-card .mobile-child-notify {

        grid-column: 1 / 4;

        grid-row: 6;
    }


    .mobile-child-card .mobile-child-notified-by {

        grid-column: 4 / 7;

        grid-row: 6;
    }


    /* =====================================================
       COMMON FIELD
       ===================================================== */

    .mobile-child-card .mobile-child-field {

        min-width: 0 !important;

        width: 100% !important;

        box-sizing: border-box !important;

        padding: 10px 7px 8px 7px !important;

        margin-top: 7px !important;

        border-top: 1px solid #ececef !important;
    }


    /* -----------------------------------------------------
       INPUTS
       ----------------------------------------------------- */

    .mobile-child-card .mobile-child-field .invoice-inputs {

        width: 100% !important;

        max-width: 100% !important;

        min-width: 0 !important;

        height: 32px !important;

        padding: 4px 6px !important;

        margin: 0 !important;

        border: 1px solid #e5e7eb !important;

        border-radius: 7px !important;

        background: rgba(255, 255, 255, 0.68) !important;

        box-shadow: none !important;

        /* font-size: 13px !important; */

        font-weight: 600 !important;

        color: #222 !important;

        box-sizing: border-box !important;

    }


    /* -----------------------------------------------------
       Select
       ----------------------------------------------------- */

    .mobile-child-card
    .mobile-child-courier
    select {

        width: 100% !important;

        max-width: 100% !important;

        height: 32px !important;

        min-width: 0 !important;

        padding: 3px 5px !important;

        border: 1px solid #e5e7eb !important;

        border-radius: 7px !important;

        background: #fff !important;

        font-size: 12px !important;

        font-weight: 600 !important;

        color: #333 !important;

        box-sizing: border-box !important;
    }


    /* -----------------------------------------------------
       Readonly inputs
       ----------------------------------------------------- */

    .mobile-child-card input[readonly] {

        opacity: 1 !important;

        color: #222 !important;

        -webkit-text-fill-color: #222 !important;

        background: #f8f9fa !important;
    }


    /* =====================================================
       NOTIFY STATUS
       ===================================================== */

    .mobile-child-card .notify-status {

        display: inline-flex !important;

        align-items: center;

        justify-content: center;

        min-height: 25px;

        margin: 0 !important;

        padding: 4px 9px !important;

        border-radius: 20px !important;

        font-size: 11px !important;

        font-weight: 700 !important;

        white-space: nowrap;
    }


    .mobile-child-card .notify-sent {

        background: #eaf7ee !important;

        color: #198754 !important;
    }


    .mobile-child-card .notify-remake {

        background: #fff0f0 !important;

        color: #dc3545 !important;
    }


    /* .mobile-child-card .notify-not-sent {

        background: #f1f1f1 !important;

        color: #777 !important;
    } */


    /* =====================================================
       NOTIFIED BY
       ===================================================== */

    .mobile-child-card .notify-user {

        margin: 0 !important;

        /* font-size: 13px !important; */

        font-weight: 600 !important;

        color: #333 !important;

        text-align: left !important;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    /* =====================================================
       HIDDEN INPUTS
       ===================================================== */

    .mobile-child-card input[type="hidden"] {

        display: none !important;
    }


    /* =====================================================
       CHILD CARD VISUAL SEPARATOR
       ===================================================== */

    .mobile-child-card::before {

        content: "";

        grid-column: 1 / 7;

        grid-row: 1;

        height: 3px;

        width: 42px;

        margin-bottom: 2px;

        border-radius: 10px;

        /* background: #d8d8d8; */
    }


    /* =====================================================
       SMALL MOBILE DEVICES
       ===================================================== */

    @media (max-width: 380px) {

        .mobile-child-card {

            padding: 10px !important;
        }

        .mobile-child-card .mobile-child-label {

            font-size: 8px !important;

            letter-spacing: .25px !important;
        }

        .mobile-child-card .mobile-child-value {

            font-size: 12px !important;
        }

        .mobile-child-card
        .mobile-child-field
        .invoice-inputs {

            font-size: 12px !important;

            padding-left: 5px !important;

            padding-right: 5px !important;
        }

        .mobile-child-card
        .mobile-child-field {

            padding-left: 5px !important;

            padding-right: 5px !important;
        }
    }

    .mobile_total_qty {
        display: block !important;
    }
    .mobile_total_qty_shipped {
        display: block !important;
    }
}

/* =========================================================
   MOBILE BLANK DETAIL CARD
   Only affects order_item_detal_blank_row.blade.php
   ========================================================= */

@media (max-width: 768px) {

    /* -----------------------------------------------------
       MAIN CARD
       ----------------------------------------------------- */

    tr.mobile-blank-detail-card {
        /* display: block !important; */

        width: calc(100% - 16px) !important;
        margin: -1px 8px !important;

        padding: 0 !important;

        background: #eeeeee !important;

        border: 1px solid #e5e7eb !important;
        border-radius: 16px !important;

        box-shadow:
            0 2px 6px rgba(0, 0, 0, 0.06),
            0 8px 20px rgba(0, 0, 0, 0.04) !important;

        overflow: hidden !important;

        /* text-align: left !important; */
        position: relative;
        right: -8px;
    }


    /* -----------------------------------------------------
       ALL CELLS
       ----------------------------------------------------- */

    tr.mobile-blank-detail-card > td {
        display: block !important;

        width: 100% !important;

        box-sizing: border-box !important;

        border: 0 !important;

        background: transparent !important;

        padding: 0 !important;

        text-align: left !important;

        vertical-align: middle !important;
    }


    /* -----------------------------------------------------
       TOP ACTION AREA
       ----------------------------------------------------- */

    tr.mobile-blank-detail-card > td.mobile-blank-action-cell,
    tr.mobile-blank-detail-card > td.mobile-blank-remake-cell {

        display: inline-flex !important;

        width: auto !important;

        min-height: 48px;

        align-items: center !important;

        justify-content: center !important;

        padding: 10px 12px !important;

        background: transparent !important;

        /* border-bottom: 1px solid #eeeeee !important; */

    }


    tr.mobile-blank-detail-card > td.mobile-blank-action-cell {
        /* width: 50% !important; */

        float: left !important;

        justify-content: flex-start !important;

        padding-left: 16px !important;
    }


    tr.mobile-blank-detail-card > td.mobile-blank-remake-cell {
        /* width: 50% !important; */

        float: right !important;

        justify-content: flex-end !important;

        padding-right: 16px !important;
        width: 33.3% !important;
        min-height: 78px !important;
        background: #f1f5f9 !important;
    }


    /* checkbox */

    tr.mobile-blank-detail-card
    .mobile-blank-action-cell
    input[type="checkbox"] {

        width: 20px !important;
        height: 20px !important;

        margin: 0 !important;

        cursor: pointer;
    }


    /* remake icon */

    tr.mobile-blank-detail-card
    .mobile-blank-remake-cell
    .fa-plus-circle {

        font-size: 22px !important;

        color: #8b8b8b !important;

        cursor: pointer;

        transition: transform 0.2s ease;
    }


    tr.mobile-blank-detail-card
    .mobile-blank-remake-cell
    .fa-plus-circle:active {

        transform: scale(0.88);
    }


    /* clearfix */

    tr.mobile-blank-detail-card::after {
        content: "";
        display: block;
        clear: both;
    }


    /* -----------------------------------------------------
       SIZE HEADER
       ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-size-cell {

        clear: both !important;

        display: flex !important;

        align-items: center !important;

        justify-content: space-between !important;

        min-height: 58px !important;

        padding: 12px 16px !important;

        background: #f1f5f9 !important;

        border-bottom: 1px solid #e5e7eb !important;

        font-size: 18px !important;

        font-weight: 700 !important;

        color: #1f2937 !important;
        display: inline-flex !important;
        width: 33.33% !important;
        min-height: 78px !important;
    }


    /* Hide hidden inputs */

    tr.mobile-blank-detail-card
    > td.mobile-blank-size-cell
    input[type="hidden"] {

        display: none !important;
    }


    /* -----------------------------------------------------
       PLAYER / NUMBER
       ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-player-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-number-cell {

        display: none !important;
    }


    /* -----------------------------------------------------
       QUANTITY SECTION
       ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-order-qty-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-shipped-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-backordered-cell {

        display: inline-flex !important;

        width: 32.3333% !important;

        min-height: 78px !important;

        box-sizing: border-box !important;

        flex-direction: column !important;

        align-items: center !important;

        justify-content: center !important;

        padding: 12px 6px !important;

        /* background: #ffffff !important; */

        border-bottom: 1px solid #eeeeee !important;
    }


    /* Quantity labels */

    tr.mobile-blank-detail-card
    > td.mobile-blank-order-qty-cell::before {

        content: "ORDER QTY";
    }

    tr.mobile-blank-detail-card
    > td.mobile-blank-shipped-cell::before {

        content: "SHIPPED";
    }

    tr.mobile-blank-detail-card
    > td.mobile-blank-backordered-cell::before {

        content: "BACKORDERED";
    }


    tr.mobile-blank-detail-card
    > td.mobile-blank-order-qty-cell::before,
    tr.mobile-blank-detail-card
    > td.mobile-blank-shipped-cell::before,
    tr.mobile-blank-detail-card
    > td.mobile-blank-backordered-cell::before {

        display: block !important;

        margin-bottom: 6px !important;

        font-size: 10px !important;

        line-height: 1.2 !important;

        font-weight: 700 !important;

        letter-spacing: 0.5px !important;

        color: #8a8f98 !important;

        text-align: center !important;
    }


    /* Quantity inputs */

    tr.mobile-blank-detail-card
    .mobile-blank-order-qty-cell input,
    tr.mobile-blank-detail-card
    .mobile-blank-shipped-cell input,
    tr.mobile-blank-detail-card
    .mobile-blank-backordered-cell input {

        width: 100% !important;

        max-width: 80px !important;

        height: 36px !important;

        margin: 0 auto !important;

        padding: 4px 6px !important;

        border: 0 !important;

        background: transparent !important;

        font-size: 17px !important;

        font-weight: 700 !important;

        color: #202124 !important;

        box-shadow: none !important;
    }


    /* -----------------------------------------------------
       INFORMATION ROWS
       ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-delivery-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-courier-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-link-cell {

        display: flex !important;

        align-items: center !important;

        justify-content: space-between !important;

        gap: 12px !important;

        min-height: 58px !important;

        padding: 9px 16px !important;

        /* background: #ffffff !important; */

        border-bottom: 1px solid #eeeeee !important;
    }


    /* Labels */

    tr.mobile-blank-detail-card
    > td.mobile-blank-delivery-cell::before {

        content: "Est. Delivery";
    }

    tr.mobile-blank-detail-card
    > td.mobile-blank-courier-cell::before {

        content: "Courier";
    }

    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-cell::before {

        content: "Tracking No.";
    }

    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-link-cell::before {

        content: "Tracking Link";
    }


    tr.mobile-blank-detail-card
    > td.mobile-blank-delivery-cell::before,
    tr.mobile-blank-detail-card
    > td.mobile-blank-courier-cell::before,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-cell::before,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-link-cell::before {

        flex: 0 0 105px !important;

        font-size: 12px !important;

        font-weight: 600 !important;

        color: #6b7280 !important;

        white-space: nowrap !important;
    }


    /* Values / inputs */

    tr.mobile-blank-detail-card
    > td.mobile-blank-delivery-cell input,
    tr.mobile-blank-detail-card
    > td.mobile-blank-courier-cell select,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-cell input,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-link-cell input {

        flex: 1 !important;

        width: auto !important;

        min-width: 0 !important;

        height: 38px !important;

        margin: 0 !important;

        padding: 6px 10px !important;

        border: 1px solid #e5e7eb !important;

        border-radius: 8px !important;

        background: #f9fafb !important;

        font-size: 14px !important;

        text-align: right !important;

        box-shadow: none !important;
    }


    tr.mobile-blank-detail-card
    > td.mobile-blank-courier-cell select {

        appearance: auto !important;

        -webkit-appearance: auto !important;
    }


    /* -----------------------------------------------------
    NOTIFICATION SECTION - 2 COLUMNS
    ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-notify-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-notified-by-cell {

        display: inline-flex !important;

        vertical-align: top !important;

        width: 48% !important;

        min-height: 76px !important;

        box-sizing: border-box !important;

        flex-direction: column !important;

        align-items: flex-start !important;

        justify-content: center !important;

        gap: 6px !important;

        padding: 10px 12px !important;

        /* background: #fafafa !important; */

        /* border-top: 1px solid #eeeeee !important; */

        border-bottom: 0 !important;
    }


    /* -----------------------------------------------------
    NOTIFICATION LABELS
    ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-notify-cell::before {

        content: "Notify";
    }


    tr.mobile-blank-detail-card
    > td.mobile-blank-notified-by-cell::before {

        content: "Notified By";
    }


    tr.mobile-blank-detail-card
    > td.mobile-blank-notify-cell::before,
    tr.mobile-blank-detail-card
    > td.mobile-blank-notified-by-cell::before {

        display: block !important;

        width: 100% !important;

        font-size: 11px !important;

        line-height: 1.2 !important;

        font-weight: 600 !important;

        color: #6b7280 !important;

        text-align: left !important;
    }


    /* -----------------------------------------------------
    NOTIFICATION STATUS
    ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    .notify-status {

        display: inline-flex !important;

        align-items: center !important;

        justify-content: center !important;

        width: fit-content !important;

        max-width: 100% !important;

        margin: 0 !important;

        padding: 5px 11px !important;

        border-radius: 20px !important;

        font-size: 11px !important;

        font-weight: 700 !important;

        line-height: 1.2 !important;

        box-sizing: border-box !important;
    }


    /* -----------------------------------------------------
    NOTIFIED USER
    ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    .notify-user {

        display: block !important;

        width: 100% !important;

        max-width: 100% !important;

        margin: 0 !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;

        /* font-size: 13px !important; */

        font-weight: 600 !important;

        color: #374151 !important;

        text-align: left !important;
    }


    /* -----------------------------------------------------
       INPUT FOCUS
       ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    input:focus,
    tr.mobile-blank-detail-card
    select:focus {

        outline: none !important;

        border-color: #b8bec8 !important;

        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.04) !important;
    }


    /* -----------------------------------------------------
       REMOVE UNNECESSARY TABLE SPACING
       ----------------------------------------------------- */

    tr.mobile-blank-detail-card td {
        white-space: normal !important;
    }


    /* -----------------------------------------------------
       SMALL MOBILE
       ----------------------------------------------------- */

    @media (max-width: 480px) {

        tr.mobile-blank-detail-card {
            width: calc(100% - 12px) !important;

            margin: 1px 6px !important;

            border-radius: 14px !important;
            margin-right: unset !important;
            right: -6px;
            position: relative;
            background: #eeeeee !important;
        }


        tr.mobile-blank-detail-card
        > td.mobile-blank-size-cell {

            min-height: 54px !important;

            padding: 10px 14px !important;

            font-size: 17px !important;
        }


        tr.mobile-blank-detail-card
        > td.mobile-blank-delivery-cell::before,
        tr.mobile-blank-detail-card
        > td.mobile-blank-courier-cell::before,
        tr.mobile-blank-detail-card
        > td.mobile-blank-tracking-cell::before,
        tr.mobile-blank-detail-card
        > td.mobile-blank-tracking-link-cell::before {

            flex-basis: 88px !important;

            font-size: 11px !important;
        }


        tr.mobile-blank-detail-card
        > td.mobile-blank-delivery-cell,
        tr.mobile-blank-detail-card
        > td.mobile-blank-courier-cell,
        tr.mobile-blank-detail-card
        > td.mobile-blank-tracking-cell,
        tr.mobile-blank-detail-card
        > td.mobile-blank-tracking-link-cell {

            padding-left: 13px !important;

            padding-right: 13px !important;

            gap: 8px !important;
        }


        tr.mobile-blank-detail-card
        .mobile-blank-order-qty-cell input,
        tr.mobile-blank-detail-card
        .mobile-blank-shipped-cell input,
        tr.mobile-blank-detail-card
        .mobile-blank-backordered-cell input {

            font-size: 16px !important;
        }
    }
}

/* =========================================================
   BACKORDERED DETAIL MOBILE CARD
   Unique classes - does not affect other mobile cards
   ========================================================= */

@media (max-width: 768px) {

    /* -----------------------------------------------------
       MAIN BACKORDER CARD
       ----------------------------------------------------- */

    tr.mobile-backorder-detail-card {

        /* display: block !important; */

        width: calc(100% - 16px) !important;

        margin: 10px 8px !important;

        padding: 0 !important;

        background: #ffffff !important;

        border: 1px solid #e4e7eb !important;

        border-radius: 16px !important;

        overflow: hidden !important;

        box-sizing: border-box !important;

        box-shadow:
            0 2px 6px rgba(0, 0, 0, 0.05),
            0 8px 22px rgba(0, 0, 0, 0.04) !important;

        text-align: left !important;
    }


    /* -----------------------------------------------------
       ALL CELLS
       ----------------------------------------------------- */

    tr.mobile-backorder-detail-card > td {

        /* display: block !important; */

        width: 100% !important;

        box-sizing: border-box !important;

        padding: 0 !important;

        margin: 0 !important;

        border: 0 !important;

        background: transparent !important;

        text-align: left !important;

        vertical-align: middle !important;

        white-space: normal !important;
    }


    /* -----------------------------------------------------
       BACKORDER QUANTITY - HIGHLIGHT
       ----------------------------------------------------- */

    tr.mobile-backorder-detail-card
    > td.mobile-backorder-qty-cell {

        display: flex !important;

        align-items: center !important;

        justify-content: space-between !important;

        min-height: 62px !important;

        padding: 10px 16px !important;

        background: #fff8f5 !important;

        border-bottom: 1px solid #f1e6e1 !important;
    }


    tr.mobile-backorder-detail-card
    > td.mobile-backorder-qty-cell::before {

        content: "BACKORDERED QTY";

        font-size: 11px !important;

        font-weight: 700 !important;

        letter-spacing: 0.5px !important;

        color: #8a6d64 !important;
    }


    tr.mobile-backorder-detail-card
    .mobile-backorder-qty-cell input {

        width: 80px !important;

        height: 38px !important;

        margin: 0 !important;

        padding: 5px 10px !important;

        border: 1px solid #eadbd5 !important;

        border-radius: 9px !important;

        background: #ffffff !important;

        font-size: 17px !important;

        font-weight: 700 !important;

        text-align: center !important;

        color: #343434 !important;

        box-shadow: none !important;
    }


    /* -----------------------------------------------------
    INFORMATION FIELDS - 2 COLUMNS
    ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-delivery-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-courier-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-link-cell {

        display: inline-flex !important;

        vertical-align: top !important;

        width: 48% !important;

        min-height: 78px !important;

        box-sizing: border-box !important;

        flex-direction: column !important;

        align-items: stretch !important;

        justify-content: center !important;

        gap: 5px !important;

        padding: 10px 12px !important;

        /* background: #ffffff !important; */

        /* border-bottom: 1px solid #eeeeee !important; */
    }


    /* -----------------------------------------------------
    INFORMATION LABELS
    ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-delivery-cell::before {

        content: "Est. Delivery";
    }

    tr.mobile-blank-detail-card
    > td.mobile-blank-courier-cell::before {

        content: "Courier";
    }

    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-cell::before {

        content: "Tracking No.";
    }

    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-link-cell::before {

        content: "Tracking Link";
    }


    tr.mobile-blank-detail-card
    > td.mobile-blank-delivery-cell::before,
    tr.mobile-blank-detail-card
    > td.mobile-blank-courier-cell::before,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-cell::before,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-link-cell::before {

        display: block !important;

        flex: none !important;

        width: 100% !important;

        font-size: 11px !important;

        line-height: 1.2 !important;

        font-weight: 600 !important;

        color: #6b7280 !important;

        white-space: nowrap !important;

        text-align: left !important;
    }


    /* -----------------------------------------------------
    INFORMATION INPUTS
    ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-delivery-cell input,
    tr.mobile-blank-detail-card
    > td.mobile-blank-courier-cell select,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-cell input,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-link-cell input {

        display: block !important;

        width: 100% !important;

        min-width: 0 !important;

        height: 36px !important;

        box-sizing: border-box !important;

        margin: 0 !important;

        padding: 6px 9px !important;

        border: 1px solid #e5e7eb !important;

        border-radius: 8px !important;

        background: #f9fafb !important;

        /* font-size: 13px !important; */

        text-align: left !important;

        box-shadow: none !important;
    }


    tr.mobile-blank-detail-card
    > td.mobile-blank-courier-cell select {

        appearance: auto !important;

        -webkit-appearance: auto !important;
    }


    /* -----------------------------------------------------
    ROW PAIRING
    ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-delivery-cell,
    tr.mobile-blank-detail-card
    > td.mobile-blank-tracking-cell {

        /* border-right: 1px solid #eeeeee !important; */
    }


    tr.mobile-backorder-detail-card
    > td.mobile-backorder-notify-cell::before {

        content: "Notify";

        font-size: 12px !important;

        font-weight: 600 !important;

        color: #6b7280 !important;
    }


    /* -----------------------------------------------------
       NOTIFICATION STATUS
       ----------------------------------------------------- */

    tr.mobile-backorder-detail-card
    .notify-status {

        margin: 0 !important;

        padding: 5px 12px !important;

        border-radius: 20px !important;

        font-size: 11px !important;

        font-weight: 700 !important;

        line-height: 1.2 !important;

        white-space: nowrap !important;
    }


    /* -----------------------------------------------------
       NOTIFIED BY
       ----------------------------------------------------- */

    tr.mobile-backorder-detail-card
    > td.mobile-backorder-notified-by-cell {

        display: flex !important;

        align-items: center !important;

        justify-content: space-between !important;

        min-height: 54px !important;

        padding: 9px 16px !important;

        background: #fafafa !important;
    }


    tr.mobile-backorder-detail-card
    > td.mobile-backorder-notified-by-cell::before {

        content: "Notified By";

        font-size: 12px !important;

        font-weight: 600 !important;

        color: #6b7280 !important;
    }


    tr.mobile-backorder-detail-card
    .notify-user {

        max-width: 150px !important;

        margin: 0 !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;

        /* font-size: 13px !important; */

        font-weight: 600 !important;

        color: #374151 !important;
    }


    /* -----------------------------------------------------
       HIDDEN INPUTS
       ----------------------------------------------------- */

    tr.mobile-backorder-detail-card
    input[type="hidden"] {

        display: none !important;
    }


    /* -----------------------------------------------------
       FOCUS
       ----------------------------------------------------- */

    tr.mobile-backorder-detail-card
    input:focus,
    tr.mobile-backorder-detail-card
    select:focus {

        outline: none !important;

        border-color: #b9bec6 !important;

        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.04) !important;
    }

    /* -----------------------------------------------------
    BLANK ITEM LABEL
    ----------------------------------------------------- */

    tr.mobile-blank-detail-card
    > td.mobile-blank-action-cell::after {

        content: "Blank Item";

        display: block !important;

        font-size: 13px !important;

        font-size: 11px !important;

        line-height: 1.2 !important;

        font-weight: 700 !important;

        letter-spacing: 0.4px !important;

        color: #6b7280 !important;
        padding-top: 12px;
    }

    tr.mobile-blank-detail-card
    > td.mobile-blank-action-cell {

        display: flex !important;

        flex-direction: column !important;

        align-items: flex-start !important;

        justify-content: center !important;

        min-height: 65px !important;

        padding: 10px 16px !important;

        /* background: #ffffff !important; */
        display: inline-flex !important;
        width: 33.3% !important;
        min-height: 78px !important;
        background: #f1f5f9 !important;
    }
    .mobile-size-value {
        font-size: 18px !important;
        font-weight: 700 !important;
        color: #1f2937 !important;
    }
}

/* =========================================================
   MOBILE BLANK CHILD ROW CARD
   Only for:
   order_item_detal_blank_child_row.blade.php
   ========================================================= */

@media (max-width: 768px) {

    /* Main child row */
    tr.mobile-blank-child-card-row {
        /* display: block !important; */

        width: 95% !important;
        margin: 0px 0 !important;
        padding: 0 !important;

        background: #f4f4f4 !important;

        border: 1px solid #e4e7eb !important;
        border-radius: 14px !important;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07) !important;

        overflow: hidden !important;

        text-align: left !important;
        margin-left: 25px !important;
    }


    /* All cells */
    tr.mobile-blank-child-card-row > td.mobile-blank-child-cell {
        /* display: flex !important;

        width: 100% !important; */
        min-height: 78px !important;

        box-sizing: border-box !important;

        padding: 10px 14px !important;

        border: 0 !important;
        border-bottom: 1px solid #eef0f3 !important;

        background: #f4f4f4 !important;

        align-items: center !important;

        text-align: left !important;

    }


    /* Last cell */
    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-cell:last-child {
        border-bottom: 0 !important;
    }


    /* ---------------------------------------------------------
       CHECKBOX
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-checkbox {

        justify-content: flex-start !important;

        min-height: 78px !important;

        background: #f4f4f4 !important;
        float: left !important;
    }


    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-checkbox
        input[type="checkbox"] {

        width: 19px !important;
        height: 19px !important;

        margin: 0 5px 0 0 !important;

        flex-shrink: 0 !important;
    }


    /* ---------------------------------------------------------
       ADD TO REMAKE
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-remake {

        position: absolute !important;

        /* top: 10px !important; */
        right: 35px !important;

        width: auto !important;

        min-height: auto !important;

        padding: 0 !important;

        border: 0 !important;

        background: transparent !important;

        z-index: 5 !important;
        /* padding-top: 13px !important; */
        min-height: 78px !important;
    }


    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-remake
        .fa-plus-circle {

        font-size: 19px !important;

        cursor: pointer !important;

        color: #b6b6b6 !important;
    }


    /* ---------------------------------------------------------
       COMMON LABEL
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-cell::before {

        font-size: 11px !important;

        font-weight: 600 !important;

        color: #8a929c !important;

        text-transform: uppercase !important;

        letter-spacing: 0.4px !important;

        /* width: 42% !important; */

        min-width: 42% !important;

        flex-shrink: 0 !important;
    }


    /* ---------------------------------------------------------
       SIZE
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-size {

        padding-top: 15px !important;

        background: #f8f9fb !important;

        border-bottom: 1px solid #e8ebef !important;
    }

    /* tr.mobile-blank-child-card-row
        > td.mobile-blank-child-size::before {

        content: "SIZE";
    } */


    /* ---------------------------------------------------------
       PLAYER
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-player::before {

        content: "PLAYER";
    }


    /* ---------------------------------------------------------
       NUMBER
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-number::before {

        content: "NUMBER";
    }


    /* ---------------------------------------------------------
       ORDER QTY
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-order-qty::before {

        content: "ORDER QTY";
    }


    /* ---------------------------------------------------------
       SHIPPED
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-shipped::before {

        content: "SHIPPED";
    }


    /* ---------------------------------------------------------
       BACKORDERED
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-backordered::before {

        content: "BACKORDERED";
    }


    /* ---------------------------------------------------------
       DELIVERY
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-delivery::before {

        content: "EST. DELIVERY";
    }


    /* ---------------------------------------------------------
       COURIER
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-courier::before {

        content: "COURIER";
    }


    /* ---------------------------------------------------------
       TRACKING
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-tracking::before {

        content: "TRACKING #";
    }


    /* ---------------------------------------------------------
       TRACKING LINK
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-tracking-link::before {

        content: "TRACKING LINK";
    }


    /* ---------------------------------------------------------
       NOTIFY
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-notify::before {

        content: "NOTIFY";
    }


    /* ---------------------------------------------------------
       NOTIFIED BY
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-notified-by::before {

        content: "NOTIFIED BY";
    }


    /* ---------------------------------------------------------
       INPUTS
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        .invoice-inputs,
    tr.mobile-blank-child-card-row
        .shipping-input,
    tr.mobile-blank-child-card-row
        select {

        width: 100% !important;

        min-width: 0 !important;

        height: 36px !important;

        padding: 5px 9px !important;

        border: 1px solid #dfe3e8 !important;

        border-radius: 7px !important;

        background: #ffffff !important;

        font-size: 14px !important;

        box-sizing: border-box !important;

        margin: 0 !important;
    }


    /* Select2 / Courier */
    tr.mobile-blank-child-card-row
        .CourierService-select {

        /* width: 50% !important;

        max-width: 58% !important; */
    }


    /* Text values */
    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-cell
        > p.notify-user {

        width: 50% !important;

        margin: 0 !important;

        font-size: 14px !important;

        color: #252a31 !important;

        text-align: left !important;

        overflow-wrap: anywhere !important;
    }


    /* Notification status */
    tr.mobile-blank-child-card-row
        .notify-status {

        width: auto !important;

        margin: 0 !important;

        font-size: 12px !important;

        font-weight: 600 !important;
    }


    /* Size text */
    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-size {

        font-weight: 700 !important;

        font-size: 15px !important;
        min-height: 78px !important;
        background: #f1f5f9 !important;
        width: 50% !important;
        border-left: unset;
    }


    /* ---------------------------------------------------------
       HIDDEN INPUTS
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        input[type="hidden"] {

        display: none !important;
    }


    /* ---------------------------------------------------------
       REMOVE EMPTY CELLS VISUAL SPACE
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-number:empty {

        display: none !important;
    }


    /* ---------------------------------------------------------
       CARD TOP ACCENT
       --------------------------------------------------------- */

    /* tr.mobile-blank-child-card-row
        > td.mobile-blank-child-size::after {

        content: "";

        position: absolute;

        left: 0;

        top: 0;

        width: 4px;

        height: 100%;

        background: #6c757d;

        border-radius: 4px 0 0 4px;
    } */


    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-size {

        position: relative !important;

        padding-left: 18px !important;
    }


    /* ---------------------------------------------------------
       MOBILE CARD SPACING
       --------------------------------------------------------- */

    tr.mobile-blank-child-card-row
        > td.mobile-blank-child-cell:not(
            .mobile-blank-child-checkbox
        ):not(
            .mobile-blank-child-remake
        ) {

        position: relative;
    }

    .mobile-blank-child-cell.mobile-blank-child-order-qty,
    .mobile-blank-child-cell.mobile-blank-child-shipped,
    .mobile-blank-child-cell.mobile-blank-child-backordered {
        display: inline-flex !important;
        width: 32.3333% !important;
        min-height: 78px !important;
        box-sizing: border-box !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 12px 6px !important;
        background: #ffffff !important;
        border-bottom: 1px solid #eeeeee !important;
    }

    /* ---------------------------------------------------------
       SMALL DEVICES
       --------------------------------------------------------- */

    @media (max-width: 480px) {

        tr.mobile-blank-child-card-row
            > td.mobile-blank-child-cell {

            padding: 9px 12px !important;
        }


        tr.mobile-blank-child-card-row
            > td.mobile-blank-child-cell::before {

            /* width: 40% !important;

            min-width: 40% !important; */

            font-size: 10px !important;
        }


        tr.mobile-blank-child-card-row
            .invoice-inputs,
        tr.mobile-blank-child-card-row
            .shipping-input,
        tr.mobile-blank-child-card-row
            select {

            width: 100% !important;

            font-size: 14px !important;
        }
    }
}

/* =========================================================
   MOBILE CHILD BACKORDERED ROW
   Unique classes: mob-cbr-*
   ========================================================= */
tr.mob-cbr-row {
        /* display: none ; */

    }
tr.mob-cbr-row.show {
        /* display: block !important; */

    }
@media (max-width: 767.98px) {

    tr.mob-cbr-row {
        position: relative !important;
    }


    /* Hide remake cell from normal card flow */
    tr.mob-cbr-row
        > td.mob-cbr-cell.mobile-blank-child-remake {

        position: absolute !important;

        right: 14px !important;

        /* Adjust this depending on your row height */
        top: 50% !important;

        transform: translateY(-50%) !important;

        display: flex !important;

        align-items: center !important;

        justify-content: center !important;

        width: auto !important;

        min-width: auto !important;

        max-width: none !important;

        height: auto !important;

        min-height: 0 !important;

        margin: 0 !important;

        padding: 0 !important;

        background: transparent !important;

        border: 0 !important;

        z-index: 20 !important;
    }


    /* Remove CSS label from remake cell */
    tr.mob-cbr-row
        > td.mob-cbr-cell.mobile-blank-child-remake::before {

        display: none !important;

        content: none !important;
    }


    /* Icon */
    tr.mob-cbr-row
        > td.mob-cbr-cell.mobile-blank-child-remake
        .fa-plus-circle {

        display: inline-flex !important;

        align-items: center !important;

        justify-content: center !important;

        width: 32px !important;

        height: 32px !important;

        margin: 0 !important;

        padding: 0 !important;

        font-size: 19px !important;

        color: #a7adb5 !important;

        cursor: pointer !important;

        transition: all 0.2s ease !important;
    }


    /* Hover / tap */
    tr.mob-cbr-row
        > td.mob-cbr-cell.mobile-blank-child-remake
        .fa-plus-circle:hover {

        color: #555b63 !important;

        transform: scale(1.08) !important;
    }


    /* =========================================
       COURIER ROW
       ========================================= */

    tr.mob-cbr-row
        > td.mobile-blank-child-courier {

        position: relative !important;

        padding-right: 55px !important;
    }


    /* Courier select should not overlap icon */
    tr.mob-cbr-row
        > td.mobile-blank-child-courier
        select.CourierService {

        max-width: 100% !important;

        width: 100% !important;
    }

    .mob-cbr-checkbox {
        justify-content: flex-start !important;
        min-height: 78px !important;
        background: #f4f4f4 !important;
        float: left !important;
        min-height: 46px !important;
        box-sizing: border-box !important;
        padding: 10px 14px !important;
        border: 0 !important;
        border-bottom: 1px solid #eef0f3 !important;
        background: #f4f4f4 !important;
        align-items: center !important;
        text-align: left !important;
    }
    .mob-cbr-checkbox #subcheck {
        width: 24px !important;
        height: 24px !important;
        margin: 0 5px 0 0 !important;
        flex-shrink: 0 !important;
    }

    .mobile-blank-child-cell.mobile-blank-child-remake i {
        font-size: 15px !important;
    }
    .mobile-blank-child-cell.mobile-blank-child-remake {
        width: auto !important;
        text-align: right;
        position: absolute;
        right: 15px;
        margin-top: 10px;
        min-height: 78px !important;
    }

    /* Main card */
    tr.mob-cbr-row {
        /* display: block !important; */
        width: 95% !important;

        margin: 0 10px 14px 0 !important;
        padding: 0 !important;

        background: #f4f4f4 !important;

        border: 1px solid #e5e7eb !important;
        border-radius: 16px !important;

        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07) !important;

        overflow: hidden !important;

        /* Override table-row behavior */
        height: auto !important;
        position: relative !important;
        right: -24px;
    }


    /* Every cell becomes a card row */
    tr.mob-cbr-row > td.mob-cbr-cell {

        display: flex !important;

        align-items: center !important;
        justify-content: space-between !important;

        width: 100% !important;

        min-height: 54px !important;

        padding: 9px 2px !important;

        background: transparent !important;

        border: 0 !important;
        border-bottom: 1px solid #f0f1f3 !important;

        text-align: right !important;

        vertical-align: middle !important;

        box-sizing: border-box !important;
        display: inline-flex !important;
        vertical-align: top !important;
        width: 49% !important;
        flex-direction: column !important;
    }


    /* Last item */
    tr.mob-cbr-row > td.mob-cbr-cell:last-child {
        border-bottom: 0 !important;
    }


    /* Label */
    tr.mob-cbr-row > td.mob-cbr-cell::before {

        content: attr(data-label);

        flex: 0 0 42%;

        /* max-width: 42%; */

        margin-right: 12px;

        color: #a8a8a8;

        font-size: 12px;

        font-weight: 700;

        line-height: 1.3;

        text-align: left;

        text-transform: uppercase;

        letter-spacing: 0.35px;
    }


    /* Right side content */
    tr.mob-cbr-row > td.mob-cbr-cell > input,
    tr.mob-cbr-row > td.mob-cbr-cell > select {

        flex: 1 1 auto;

        width: auto !important;

        min-width: 0 !important;

        /* max-width: 58% !important; */

        margin: 0 !important;

        box-sizing: border-box !important;
    }


    /* Inputs */
    tr.mob-cbr-row .invoice-inputs {

        height: 38px !important;

        min-height: 38px !important;

        padding: 7px 10px !important;

        border: 1px solid #dfe3e8 !important;

        border-radius: 9px !important;

        background: #fafafa !important;

        font-size: 14px !important;

        /* text-align: right !important; */

        outline: none !important;
    }


    /* Focus */
    tr.mob-cbr-row .invoice-inputs:focus {

        background: #ffffff !important;

        border-color: #8b93a1 !important;

        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
    }


    /* Select */
    tr.mob-cbr-row select.CourierService {

        height: 38px !important;

        padding: 5px 28px 5px 10px !important;

        border-radius: 9px !important;

        /* font-size: 13px !important; */

        background-color: #fafafa !important;
    }


    /* Status cell */
    tr.mob-cbr-row > td.mob-cbr-status-cell {

        min-height: 58px !important;
    }


    /* Status */
    tr.mob-cbr-row .notify-status {

        display: inline-flex !important;

        align-items: center !important;

        justify-content: center !important;

        min-width: 82px !important;

        min-height: 30px !important;

        margin: 0 !important;

        padding: 5px 12px !important;

        border-radius: 20px !important;

        font-size: 12px !important;

        font-weight: 700 !important;

        white-space: nowrap !important;
    }


    /* Notified user */
    tr.mob-cbr-row .notify-user {

        margin: 0 !important;

        max-width: 58% !important;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: nowrap !important;

        font-size: 13px !important;

        font-weight: 600 !important;

        color: #374151 !important;

        text-align: right !important;
    }


    /* Hidden fields should remain hidden */
    tr.mob-cbr-row > td.mob-cbr-cell > input[type="hidden"] {

        display: none !important;
    }


    /* Slightly different look for tracking fields */
    tr.mob-cbr-row .txtTrackingNo,
    tr.mob-cbr-row .txtTrackingLink {

        font-size: 13px !important;
    }


    /* Backordered quantity */
    tr.mob-cbr-row .backed-qty {

        font-weight: 700 !important;

        color: #374151 !important;
    }


    /* Remove unnecessary table spacing */
    tr.mob-cbr-row td.mob-cbr-cell:first-child {
        border-radius: 16px 16px 0 0 !important;
    }

    tr.mob-cbr-row td.mob-cbr-cell:last-child {
        border-radius: 0 0 16px 16px !important;
    }
    .mobile_remake_topic {
        color: black !important;
    }
    .remake_items_bg {
        background-color: #f8ff90 !important;
    }
    /* tr.mob-cbr-row > td.mobile-blank-child-backorder-size::before {
        content: "SIZE";
    } */
    /* tr.mob-cbr-row > td.mobile-blank-child-backorder-size::after {
        content: "";
        position: absolute;
        left: 0;
        top: 46px;
        width: 4px;
        height: 46px;
        background: #6c757d;
        border-radius: 4px 0 0 4px;
    } */
     .mobile-blank-child-cell.mobile-blank-child-delivery,
     .mobile-blank-child-cell.mobile-blank-child-courier,
     .mobile-blank-child-cell.mobile-blank-child-tracking,
     .mobile-blank-child-cell.mobile-blank-child-tracking-link,
     .mobile-blank-child-cell.mobile-blank-child-notify,
     .mobile-blank-child-cell.mobile-blank-child-notified-by.text-center {
        display: inline-flex !important;

        vertical-align: top !important;

        width: 49% !important;

        flex-direction: column !important;
     }

     .mob-cbr-row .select2-container--default .select2-selection--single .select2-selection__rendered {
        height: 40px !important;
        border-radius: 5px !important;
        padding-top: 5px;
        background-color: #fbfbfbff !important;
     }
    .mobile-blank-child-cell-size.mobile-blank-child-backorder-size {
        padding-top: 15px !important;
        background: #f8f9fb !important;
        border-bottom: 1px solid #e8ebef !important;
        min-height: 46px !important;
        box-sizing: border-box !important;
        padding: 10px 14px !important;
        border: 0 !important;
        border-bottom: 1px solid #eef0f3 !important;
        background: #f8f9fb !important;
        align-items: center !important;
        text-align: left !important;
        min-height: 78px !important;
        background: #f1f5f9 !important;
        width: 50% !important;
        border-left: unset;
        font-weight: 700 !important;
        font-size: 15px !important;
    }
    .notify-status {
        padding: 0.2rem 0.5rem !important;
    }
    .mobile-blank-child-cell-backorder.mobile-blank-child-order-backorder-qty, .mobile-blank-child-cell-backorder.mobile-blank-child-order-backorder-shipped, .mobile-blank-child-cell-backorder.mobile-blank-child-order-backorder-backed {
        display: inline-flex !important;
        width: 32.3333% !important;
        min-height: 78px !important;
        box-sizing: border-box !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 12px 6px !important;
        background: transparent !important;
        border-bottom: 1px solid #eeeeee !important;
    }
    .mobile-blank-child-cell-backorder.mobile-blank-child-order-backorder-qty::before {
        content: "ORDER QTY";
        color: gray;
    }
    .mobile-blank-child-cell-backorder.mobile-blank-child-order-backorder-shipped::before {
        content: "SHIPPED";
        color: gray;
    }
    .mobile-blank-child-cell-backorder.mobile-blank-child-order-backorder-backed::before {
        content: "BACKORDERED";
        color: gray;
    }

}


@media (max-width: 767.98px) {

    .parent-table-header th {
        display: none !important;
    }

    .parent-table-header th.mobile-select-all-header {
        display: table-cell !important;
        width: 100% !important;
        text-align: left !important;
        padding-left: 15px !important;
    }

    .parent-table-header th.mobile-select-all-header::after {
        content: "All Select";
        margin-left: 10px;
        font-size: 14px;
        color: gray;
        vertical-align: middle;
    }

    .parent-table-header th.mobile-select-all-header input {
        vertical-align: middle;
        margin: 0;
    }

    input,
    textarea,
    select {
        font-size: 16px !important;
    }

    .form-control,
    .invoice-inputs,
    .select2-selection__rendered,
    .select2-selection {
        font-size: 16px !important;
    }
    .select2-container .select2-search__field {
        font-size: 16px !important;
    }
    .form-control,
    .invoice-inputs,
    textarea,
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple,
    .select2-search__field {
        font-size: 16px !important;
    }

}
@media (max-width: 767.98px) {

    .mobile_total_qty::before {
        content: "Order Qty";
        display: block;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 5px;
        color: gray;
    }

    .mobile_total_qty_shipped::before {
        content: "Shipped Qty";
        display: block;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 5px;
        color: gray;
    }

}
@media (max-width: 767.98px) {

    /* Button container */
    .col-lg-9.ml-auto {
        width: 100% !important;
        max-width: 100% !important;
        margin-left: 0 !important;
        padding: 8px 10px !important;

        display: flex !important;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: stretch;
    }

    /* All buttons */
    .col-lg-9.ml-auto .btn-custom {
        flex: 1 1 calc(50% - 4px);
        min-height: 42px;

        margin: 0 !important;
        padding: 8px 12px !important;

        font-size: 11px !important;
        font-weight: 600;

        border-radius: 12px !important;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        white-space: nowrap;
        transition: all 0.2s ease;
    }

    /* Back-order / Remake */
    .col-lg-9.ml-auto .remake_item_modal_btn {
        background: #f5f5f5 !important;
        color: #333 !important;
        border: 1px solid #d8d8d8 !important;
    }

    /* Save */
    .col-lg-9.ml-auto #updateShippingOrderToNotify {
        background: #f5fff4 !important;
        color: #0bd700 !important;
        border: 1px solid #0bd700 !important;
    }

    /* Notify */
    .col-lg-9.ml-auto #notify_shipping {
        background: #0bd700 !important;
        color: white !important;
        border: 1px solid #0bd700 !important;
    }

    /* Badge */
    .col-lg-9.ml-auto .remakecount {
        margin-left: 5px;
        font-size: 9px;
        min-width: 18px;
        height: 18px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Hidden fulfill button should remain hidden */
    .col-lg-9.ml-auto #fulfillButton[style*="display:none"] {
        display: none !important;
    }

}

@media (max-width: 767.98px) {

    .mobile-sticky-actions {
        position: relative !important;
        width: 100% !important;
        transition: none !important;
    }

    /* Fixed mobile state */
    .mobile-sticky-actions.mobile-fixed-actions {
        position: fixed !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;

        width: 100% !important;

        margin: 0 !important;
        padding: 10px 12px !important;

        background: rgba(255, 255, 255, 0.98) !important;

        border-top: 1px solid #e5e7eb !important;

        box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.12) !important;

        z-index: 99999 !important;

        transform: translateY(0) !important;

        transition: transform 0.25s ease,
                    opacity 0.25s ease !important;
    }


    .mobile-sticky-actions.mobile-fixed-actions .row,
    .mobile-sticky-actions.mobile-fixed-actions .col-lg-12,
    .mobile-sticky-actions.mobile-fixed-actions .col-lg-9 {
        margin: 0 !important;
        padding: 0 !important;

        width: 100% !important;
        max-width: 100% !important;
    }


    .mobile-sticky-actions.mobile-fixed-actions .col-lg-9 {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 6px !important;
    }


    .mobile-sticky-actions.mobile-fixed-actions .btn {
        margin: 0 !important;
        padding: 8px 11px !important;

        font-size: 11px !important;
        line-height: 1.2 !important;

        white-space: nowrap !important;
        border-radius: 9px !important;
    }


    /* Invisible placeholder while buttons are fixed */
    .mobile-sticky-placeholder {
        display: block;
        width: 100%;
        height: 0;
    }

}


/* Desktop */
@media (min-width: 768px) {

    .mobile-sticky-actions {
        position: relative !important;
    }

    .mobile-sticky-placeholder {
        display: none !important;
    }
}

</style>



{{-- {{dd($orderItem->orderItemDetails )}} --}}
{{-- <form action="{{ route('orders.update') }}" method="post" id="shipping_frm"> --}}
    <form action="" method="post" id="shipping_frm">
    @csrf

    @php
        $seqData = [];
        $seqArr = [];
    @endphp


    @foreach ($orders as $order)
        <input type="hidden" id="notify_order_id" name="order_id" value="{{ $order->id }}" />
        <div class="card mb-3 table-card-body desktop_table desktop-container"  style="overflow: hidden;">
            <div class="card-body" style="margin-top: -1rem;">
                <div class="row mt-1">

                    <div class="col-md-12 mobile_table_overflow" style="overflow-x: auto;padding-left: 0px;">
                        <table class="table-stripped shipping-responsive-table" id="shipping_items_table" style="margin: 2px; border: unset;">
                            <thead class="table-header parent-table-header" style="background-color: rgba(22, 22, 23, 1) !important; color: white;">
                                <th style="width: 3%;" class="text-center mobile-select-all-header"><input type="checkbox" name="maincheckbox" id="maincheckbox" onchange="mainCheckboxes(this)"></th>
                                <th class="text-center" style="width: 2%; font-weight: 500;"></th>
                                <th class="text-left" style="width: 20%; font-weight: 500;" colspan="3">&nbsp;&nbsp;Item&nbsp;({{count($order->orderItems)}})</th>
                                <th class="text-center" style="width: 6%; font-weight: 500;">Order Qty</th>
                                <th class="text-center" style="width: 6%; font-weight: 500;">Shipped Qty</th>
                                <th class="text-center" style="width: 10%; font-weight: 500;">Backordered Qty</th>
                                <th class="text-center" style="width: 9%; font-weight: 500;">Est Delivery Date</th>
                                <th class="text-center" style="width: 9%; font-weight: 500;">Courier Service</th>
                                <th class="text-center" style="width: 9%; font-weight: 500;">Tracking #</th>
                                <th class="text-center" style="width: 15%; font-weight: 500;">Tracking Link</th>
                                <th class="text-center" style="width: 10%; font-weight: 500;">Notify</th>
                                <th class="text-center" style="width: 10%; font-weight: 500;">Notified by</th>
                            </thead>

                            <tbody id="product_table_body" class="">
                                <tr class="mobile_display_hide"><input type="hidden" id="row_no" /></tr>
                                @php $loopCount = 0; @endphp
                                @php
                                $remakeDetected = false;
                                $emptyRowNotAdded = true;
                                @endphp
                                @foreach ($order->orderItems as $orderItem)
                                    @if ($orderItem->is_studio_item == 0)
                                        @php
                                            $Order_item_product = $subProducts->where('sub_product_no', $orderItem->sub_product_no)->first();
                                        @endphp

                                        @php $loopCount++; @endphp
                                        @php
                                        $product_name = empty($orderItem->display_name) ?
                                            ($Order_item_product ? $Order_item_product->product_name : $orderItem->productDetails['product_name']) :
                                            $orderItem->display_name;
                                        @endphp

                                        @php
                                            $class_remake = str_ends_with($product_name, '- Remake') ? 'remake_items_bg' : '';
                                        @endphp
                                        @if (Str::endsWith($product_name, ' - Remake') && $emptyRowNotAdded)
                                            @php $emptyRowNotAdded = false; @endphp
                                            <tr style="border-bottom: 2px solid #d7d7d7">
                                                <td class="mobile_remake_topic" colspan="14" style="height: 20px;text-align:center;background-color:black;color:#ffff"><strong>Remake Items </strong></td>
                                            </tr>
                                        @endif
                                        <tr class="main-item-card mobile-main-item-card row-item-{{ $orderItem->id }} {{$class_remake}}" style="border-bottom: 2px solid #d7d7d7; @if($orderItem->order_status_id == 4) background-color:#d0d0d0 @endif">

                                            <td class="mobile-card-checkbox" style="text-align: center; vertical-align: middle;">
                                                <input data-itemNumber="{{ $orderItem->id }}" class="chkItem" type="checkbox" id="parentcheckbox" value="{{ $orderItem->id }}" onchange="toggleCheckboxes(this, 'subcheckbox<?php echo $orderItem->id; ?>')">
                                            </td>

                                            <td class="mobile-card-expand" style="text-align: center; vertical-align: middle;">
                                                <button class="expand-button parent-expand-button" style="outline: unset !important;" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $orderItem->id; ?>" data-target-child=".collapse-child-{{ $orderItem->id }}" aria-expanded="false" aria-controls="collapse_<?php echo $orderItem->id; ?>" onclick="sub_row_hide_by_script({{$orderItem->id}})">
                                                    <i class="fas fa-angle-right"></i>
                                                </button>
                                            </td>

                                            @php
                                            if(!empty($orderItem->item_description)){

                                                $item_description_for_display = ' - '.$orderItem->item_description;
                                            }else{
                                                $item_description_for_display = '';
                                            }
                                            @endphp


                                            <td class="mobile-card-product" colspan="3">
                                                <input type="text" class="invoice-inputs" value="@if(empty($orderItem->display_name)) @if($Order_item_product) {{$Order_item_product->product_name.$item_description_for_display}} @else {{$orderItem->productDetails['product_name'].$item_description_for_display}} @endif @else {{$orderItem->display_name.$item_description_for_display}} @endif " title="{{ $product_name . $item_description_for_display }}" style="outline: unset" readonly />
                                            </td>

                                            <td class="mobile-card-field mobile-order-qty">
                                                <span class="mobile-field-label">Order Qty</span>
                                                <input type="text" class="invoice-inputs text-center item-qty"
                                                value="{{ $orderItem->qty }}"
                                                style="outline: unset" readonly />
                                            </td>
                                                @php
                                                    if(isset($orderItem->shipped_qty)){
                                                        $mainShipedQty = $orderItem->shipped_qty;
                                                    } else {
                                                        $mainShipedQty = $shipTrait->getMainShipQty($order->id, $orderItem->id);
                                                    }
                                                @endphp
                                            <td class="mobile-card-field mobile-shipped-qty">
                                                <span class="mobile-field-label">Shipped Qty</span>
                                                <input type="number" class="invoice-inputs text-center shipping-input item-main-shipped-{{ $orderItem->id }}"
                                                value="{{ $mainShipedQty }}"
                                                style="outline: unset" onchange="updateBackorderedQty1(this)" id="sum" readonly/>
                                            </td>

                                            <td class="mobile-card-field mobile-backordered-qty">
                                                <span class="mobile-field-label">Backordered</span>
                                                <input type="number" class="invoice-inputs text-center shipping-input item-main-backed-{{ $orderItem->id }}"
                                                value="@if(isset($orderItem->backordered_qty)) {{ $orderItem->backordered_qty }} @endif"
                                                style="outline: unset" readonly/>
                                            </td>

                                            <td class="mobile-card-field mobile-est-delivery">
                                                <span class="mobile-field-label">Est Delivery</span>
                                                <input type="text" class="invoice-inputs text-center datepicker shipping-input"
                                                value="@if(isset($orderItem->est_shipping_delivery_date))@php echo date_format(date_create($orderItem->est_shipping_delivery_date),"m/d/Y"); @endphp @endif"
                                                style="outline: unset" disabled/>
                                            </td>

                                            <td class="mobile-card-field mobile-courier-service" style="text-align: left">
                                                <span class="mobile-field-label">Courier Service</span>
                                                <input
                                                    type="text"
                                                    class="invoice-inputs text-center shipping-input"
                                                    data-itemNumber="{{ $orderItem->id }}"
                                                    id="CourierService{{ $orderItem->id  }}"
                                                    value="@if(isset($orderItem->CourierService)){{ $orderItem->CourierService }}@endif"
                                                    style="outline: unset"
                                                    readonly
                                                />
                                            </td>
                                            <td class="mobile-card-field mobile-tracking-no" style="text-align: left">
                                                <span class="mobile-field-label">Tracking #</span>
                                                <input
                                                    type="text"
                                                    class="invoice-inputs text-center shipping-input"
                                                    data-itemNumber="{{ $orderItem->id }}"
                                                    id="txtTrackNo{{ $orderItem->id  }}"
                                                    value="@if(isset($orderItem->tracking_no)){{ $orderItem->tracking_no }}@endif"
                                                    style="outline: unset"
                                                    readonly
                                                />
                                            </td>

                                            <td class="mobile-card-field mobile-tracking-link" style="text-align: left">
                                                <span class="mobile-field-label">Tracking Link</span>
                                                <input
                                                    type="text"
                                                    class="invoice-inputs text-center shipping-input"
                                                    data-itemNumber="{{ $orderItem->id }}"
                                                    id="txtTrackLink{{ $orderItem->id  }}"
                                                    value="@if(isset($orderItem->tracking_link)){{ $orderItem->tracking_link }}@endif"
                                                    style="outline: unset"
                                                    readonly
                                                />
                                            </td>

                                            <td class="mobile-card-field mobile-notify" style="vertical-align: middle;">
                                                <span class="mobile-field-label">Notify</span>

                                                @if ($orderItem->notify_status == 1)
                                                    <p class="notify-status notify-sent">Sent</p>
                                                @endif
                                            </td>

                                            <td class="mobile-card-field mobile-notified-by text-center" style="vertical-align: middle;">
                                                <span class="mobile-field-label">Notified By</span>

                                                @if ($orderItem->notified_user_id)
                                                    <p class="notify-user">{{$orderItem->notifiedUser->name}}</p>
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- sub table data --}}

                                        <tr class="table-header mobile_table_header parent-table-header collapse row-item-{{ $orderItem->id }}" style="rgba(22, 22, 23, 1) !important;color: white;background-color: rgb(22 22 23 / 60%) !important" id="collapse_<?php echo $orderItem->id; ?>">
                                            <th style="background-color: white"></th>
                                            <th style="background-color: white"></th>
                                            <th style="width: 7.5%; font-weight: 500;">Size</th>
                                            <th style="width: 7.5%; font-weight: 500;">Player Name</th>
                                            <th style="width: 6%; font-weight: 500;">Player Number</th>
                                            <th style="font-weight: 500;">Qty</th>
                                            <th style="font-weight: 500;"></th>
                                            <th style="font-weight: 500;"></th>
                                            <th style="font-weight: 500;"></th>
                                            <th style="font-weight: 500;"></th>
                                            <th style="font-weight: 500;"></th>
                                            <th style="font-weight: 500;"></th>
                                            <th style="width: 10%; font-weight: 500;"></th>
                                            <th style="width: 10%; font-weight: 500;"></th>
                                        </tr>

                                        @foreach ($orderItem->orderItemDetails as $orderItemDetail)

                                        @php
                                            $playerNameArrayPosition = '';
                                            if (array_search("$orderItemDetail->id", $arrayPlayerNamesPattern) !== false) {
                                                $playerNameArrayPosition = array_search("$orderItemDetail->id", $arrayPlayerNamesPattern);
                                            } else {
                                                $playerNameArrayPosition = '';
                                            }
                                        @endphp



                                        @if ( $orderItemDetail->blanks > 0 && ($orderItemDetail->qty == null || $orderItemDetail->qty == '' || $orderItemDetail->qty == 0) )
                                            @php
                                                $backOrderedShippings = [];
                                                $fullBackOrderedQty = 0;
                                                $getBackOrdered = $shipTrait->getBackOrderedShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', null);
                                                if( count($getBackOrdered) > 0){
                                                    $backOrderedShippings = $getBackOrdered;
                                                    $fullBackOrderedQty = $getBackOrdered->sum('order_qty');
                                                }
                                            @endphp
                                            @php
                                                $blankPlayerNamesArr = json_decode($orderItemDetail->playerDetails['blank_player_names'] ?? '');
                                                $blankPlayerNameCount = 0;
                                                if($blankPlayerNamesArr){
                                                    if(count($blankPlayerNamesArr) > 0){
                                                        $blankPlayerNullCount = count(array_filter($blankPlayerNamesArr, function($value) { return $value == null;  }));
                                                        $blankPlayerNames = $blankPlayerNamesArr;
                                                    } else {
                                                        $blankPlayerNullCount = 0;
                                                        $blankPlayerNames = [];
                                                    }
                                                } else {
                                                    $blankPlayerNullCount = 0;
                                                    $blankPlayerNames = [];
                                                }
                                            @endphp
                                            @if ($blankPlayerNullCount == count($blankPlayerNames) && count($blankPlayerNames) > 0)
                                                @if (count($backOrderedShippings) > 0)
                                                    @include('pages.order_management.orders.partials.order_item_detal_main_row')
                                                    @php
                                                        // $itemDetailOrderQty = $blankPlayerNameCount;
                                                        $orderQty = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', 'no', null, null, 'order_qty');
                                                        $playerName = null;
                                                        $hasPlayerName = 'no';
                                                        $seqName = null;
                                                        $blankPlNameIndex = 'blks';
                                                        $indexKey = 0;
                                                    @endphp
                                                    @include('pages.order_management.orders.partials.order_item_detal_blank_child_row')
                                                    @foreach ($backOrderedShippings as $key=>$backOrderedShipping)
                                                        @include('pages.order_management.orders.partials.order_item_detal_blank_child_backordered_row')
                                                    @endforeach
                                                @else
                                                    @include('pages.order_management.orders.partials.order_item_detal_blank_row')
                                                @endif
                                            @elseif (count($blankPlayerNames) == 0)

                                                @if (count($backOrderedShippings) > 0)
                                                    @include('pages.order_management.orders.partials.order_item_detal_main_row')
                                                    @php
                                                        // $itemDetailOrderQty = $blankPlayerNameCount;
                                                        $orderQty = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', 'no', null, null, 'order_qty');
                                                        $playerName = null;
                                                        $hasPlayerName = 'no';
                                                        $seqName = null;
                                                        $blankPlNameIndex = 'blks';
                                                        $indexKey = 0;
                                                    @endphp
                                                    @include('pages.order_management.orders.partials.order_item_detal_blank_child_row')
                                                    @foreach ($backOrderedShippings as $key=>$backOrderedShipping)
                                                        @include('pages.order_management.orders.partials.order_item_detal_blank_child_backordered_row')
                                                    @endforeach
                                                @else
                                                    @include('pages.order_management.orders.partials.order_item_detal_blank_row')
                                                @endif

                                            @else
                                                @include('pages.order_management.orders.partials.order_item_detal_main_row')

                                                @foreach ($blankPlayerNames as $key=>$blankPlayerName)
                                                    @if ($blankPlayerName != null)
                                                        @php
                                                            // $itemDetailOrderQty = 1;
                                                            $orderQty = 1;
                                                            $playerName = $blankPlayerName;
                                                            $hasPlayerName = 'yes';
                                                            $seqName = 'blank_player_'.((int)$key + 1);
                                                            $blankPlNameIndex = 'blkc';
                                                            $indexKey = $key;
                                                        @endphp
                                                        @include('pages.order_management.orders.partials.order_item_detal_blank_child_row')
                                                    @else
                                                        @php
                                                            $blankPlayerNameCount++;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if ($blankPlayerNameCount > 0)
                                                    @php
                                                        // $itemDetailOrderQty = $blankPlayerNameCount;
                                                        $orderQty = $blankPlayerNameCount - $fullBackOrderedQty;
                                                        $playerName = null;
                                                        $hasPlayerName = 'no';
                                                        $seqName = null;
                                                        $blankPlNameIndex = 'blks';
                                                        $indexKey = 0;
                                                    @endphp
                                                    @include('pages.order_management.orders.partials.order_item_detal_blank_child_row')
                                                @endif

                                                @foreach ($backOrderedShippings as $key=>$backOrderedShipping)

                                                    @include('pages.order_management.orders.partials.order_item_detal_blank_child_backordered_row')

                                                @endforeach
                                            @endif


                                            @php $DisplayStatus = "display: none;"; @endphp
                                            @elseif ($orderItemDetail->qty > 0)
                                            {{-- <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][item_detail_id]" value="{{ $orderItemDetail->id }}"> --}}
                                            @include('pages.order_management.orders.partials.order_item_detal_main_row')

                                            @php
                                                $backOrderedShippings = [];
                                                $fullBackOrderedQty = 0;
                                                $getBackOrdered = $shipTrait->getBackOrderedShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', null);
                                                if( count($getBackOrdered) > 0){
                                                    $backOrderedShippings = $getBackOrdered;
                                                    $fullBackOrderedQty = $getBackOrdered->sum('order_qty');
                                                }
                                            @endphp

                                            @if ($orderItemDetail->blanks > 0)
                                                @php
                                                    $blankPlayerNameArr = json_decode($orderItemDetail->playerDetails['blank_player_names']);
                                                    if ($blankPlayerNameArr) {
                                                        if(count($blankPlayerNameArr) > 0){
                                                            $blankPlayerNames = $blankPlayerNameArr;
                                                        } else {
                                                            $blankPlayerNames = [];
                                                        }
                                                    } else {
                                                        $blankPlayerNames = [];
                                                    }
                                                    $blankPlayerNameCount = 0;
                                                @endphp
                                                @if (count($blankPlayerNames) == 0)
                                                    @php
                                                        // $itemDetailOrderQty = 1;
                                                        // $orderQty = $orderItemDetail->blanks;
                                                        $orderQty = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', 'no', null, null, 'order_qty');
                                                        $playerName = null;
                                                        $hasPlayerName = 'no';
                                                        $seqName = null;
                                                        $blankPlNameIndex = 'blks';
                                                        $indexKey = 0;
                                                    @endphp
                                                    @include('pages.order_management.orders.partials.order_item_detal_blank_child_row')
                                                @endif
                                                @foreach ($blankPlayerNames as $key=>$blankPlayerName)
                                                    @if ($blankPlayerName != null)
                                                        @php
                                                            // $itemDetailOrderQty = 1;
                                                            $orderQty = 1;
                                                            $playerName = $blankPlayerName;
                                                            $hasPlayerName = 'yes';
                                                            $seqName = 'blank_player_'.((int)$key + 1);
                                                            $blankPlNameIndex = 'blkc';
                                                            $indexKey = $key;
                                                        @endphp
                                                        @include('pages.order_management.orders.partials.order_item_detal_blank_child_row')
                                                    @else
                                                        @php
                                                            $blankPlayerNameCount++;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if ($blankPlayerNameCount > 0)
                                                    @php
                                                        // $itemDetailOrderQty = $blankPlayerNameCount;
                                                        $orderQty = $blankPlayerNameCount - $fullBackOrderedQty;
                                                        $playerName = null;
                                                        $hasPlayerName = 'no';
                                                        $seqName = null;
                                                        $blankPlNameIndex = 'blks';
                                                        $indexKey = 0;
                                                    @endphp
                                                    @include('pages.order_management.orders.partials.order_item_detal_blank_child_row')
                                                @endif
                                            @endif


                                            @foreach ($backOrderedShippings as $key=>$backOrderedShipping)
                                                @include('pages.order_management.orders.partials.order_item_detal_blank_child_backordered_row')
                                            @endforeach

                                            @php
                                                $seqArr = [

                                                            'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen', 'twenty', 'twenty_one', 'twenty_two', 'twenty_three', 'twenty_four', 'twenty_five',
                                                            'twenty_six', 'twenty_seven', 'twenty_eight', 'twenty_nine', 'thirty', 'thirty_one', 'thirty_two', 'thirty_three', 'thirty_four', 'thirty_five', 'thirty_six', 'thirty_seven', 'thirty_eight', 'thirty_nine', 'forty', 'forty_one', 'forty_two', 'forty_three', 'forty_four', 'forty_five', 'forty_six', 'forty_seven', 'forty_eight', 'forty_nine', 'fifty',
                                                            'fifty_one', 'fifty_two', 'fifty_three', 'fifty_four', 'fifty_five', 'fifty_six', 'fifty_seven', 'fifty_eight', 'fifty_nine', 'sixty', 'sixty_one', 'sixty_two', 'sixty_three', 'sixty_four', 'sixty_five', 'sixty_six', 'sixty_seven', 'sixty_eight', 'sixty_nine', 'seventy', 'seventy_one', 'seventy_two', 'seventy_three', 'seventy_four', 'seventy_five',
                                                            'seventy_six', 'seventy_seven', 'seventy_eight', 'seventy_nine', 'eighty', 'eighty_one', 'eighty_two', 'eighty_three', 'eighty_four', 'eighty_five', 'eighty_six', 'eighty_seven', 'eighty_eight', 'eighty_nine', 'ninety', 'ninety_one', 'ninety_two', 'ninety_three', 'ninety_four', 'ninety_five', 'ninety_six', 'ninety_seven', 'ninety_eight', 'ninety_nine',
                                                            'hundred', 'hundred_one', 'hundred_two', 'hundred_three', 'hundred_four', 'hundred_five', 'hundred_six', 'hundred_seven', 'hundred_eight', 'hundred_nine', 'hundred_ten', 'hundred_eleven', 'hundred_twelve', 'hundred_thirteen', 'hundred_fourteen', 'hundred_fifteen', 'hundred_sixteen', 'hundred_seventeen', 'hundred_eighteen', 'hundred_nineteen', 'hundred_twenty', 'hundred_twenty_one', 'hundred_twenty_two', 'hundred_twenty_three', 'hundred_twenty_four', 'hundred_twenty_five',
                                                            'hundred_twenty_six', 'hundred_twenty_seven', 'hundred_twenty_eight', 'hundred_twenty_nine', 'hundred_thirty', 'hundred_thirty_one', 'hundred_thirty_two', 'hundred_thirty_three', 'hundred_thirty_four', 'hundred_thirty_five', 'hundred_thirty_six', 'hundred_thirty_seven', 'hundred_thirty_eight', 'hundred_thirty_nine', 'hundred_forty', 'hundred_forty_one', 'hundred_forty_two', 'hundred_forty_three', 'hundred_forty_four', 'hundred_forty_five', 'hundred_forty_six', 'hundred_forty_seven', 'hundred_forty_eight', 'hundred_forty_nine', 'hundred_fifty'
                                                            ];
                                            @endphp
                                            @foreach ( $seqArr as $key=>$seq )
                                                @php
                                                if( isset($orderItemDetail['numseq_'.$seq])  && $orderItemDetail['numseq_'.$seq] != '' ){
                                                    $shippedQty = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'shipped_qty');
                                                    $backOrderedQty = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'back_ordered_qty');
                                                    if($shippedQty != '' && ($backOrderedQty == null || $backOrderedQty == '')){
                                                        $backOrderedQty = 1 - $shippedQty;
                                                    } elseif($shippedQty === 0) {
                                                        $backOrderedQty = 1;
                                                    }

                                                    $rowSizeName = '';
                                                    if ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size One'){
                                                        if ($orderItem->extra_size == '1'){ $rowSizeName = 'Extra Size One'; }else{ $rowSizeName = $orderItem->extra_size; }
                                                    }elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Two'){
                                                        if ($orderItem->extra_size_two == '1'){ $rowSizeName = 'Extra Size Two'; }else{ $rowSizeName = $orderItem->extra_size_two; }
                                                    }elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Three'){
                                                        if ($orderItem->extra_size_three == '1'){ $rowSizeName = 'Extra Size Three'; }else{ $rowSizeName = $orderItem->extra_size_three; }
                                                    }else{
                                                        $rowSizeName = $orderItemDetail->sizeDetails['size_name'];
                                                    }

                                                    $orderQty = 0;
                                                    $itemDetailOrderQty = 1;
                                                    $shippingDetailOrderQty = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'order_qty');
                                                    if($shippingDetailOrderQty){
                                                        $orderQty = $shippingDetailOrderQty;
                                                    } else {
                                                        $orderQty = $itemDetailOrderQty;
                                                    }

                                                    $Notify_value = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'notify_status');
                                                    $CourierService_value = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'CourierService');
                                                    $tracking_link_value = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'tracking_link');
                                                    $tracking_no_value = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'tracking_no');
                                                    $sub_checkbox_value = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'id');
                                                    $notified_by_value = $shipTrait->getNotifiedBy($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null);
                                                    $est_delivery_date = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'est_delivery_date');
                                                    $is_saved = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'no', 'no', 'numseq_'.$seq, null, 'is_saved');

                                                    $seqData[$orderItem->id][$orderItemDetail->id][$seq] = [
                                                        'backOrderedQty' => $backOrderedQty,
                                                        'rowSizeName' => $rowSizeName,
                                                        'orderQty' => $orderQty,
                                                        'Notify_value' => $Notify_value,
                                                        'CourierService_value' => $CourierService_value,
                                                        'tracking_link_value' => $tracking_link_value,
                                                        'tracking_no_value' => $tracking_no_value,
                                                        'sub_checkbox_value' => $sub_checkbox_value,
                                                        'notified_by_value' => $notified_by_value,
                                                        'shippedQty' => $shippedQty,
                                                        'est_delivery_date' => $est_delivery_date,
                                                        'is_saved' => $is_saved
                                                    ];
                                                }
                                                @endphp
                                            @endforeach

                                            {{-- @foreach ($seqArr as $key=>$seq)
                                                @if( isset($orderItemDetail['numseq_'.$seq])  && $orderItemDetail['numseq_'.$seq] != '' )
                                                    @include('pages.order_management.orders.partials.order_item_detal_child_row')
                                                @endif
                                            @endforeach --}}

                                        @endif

                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                {{-- <tr style="background-color: rgb(108, 108, 108); color: white;">
                                    <th colspan="5"></th>
                                    <th class="text-center" style="width: 6%; font-weight: 500;"> Total Order Qty</th>
                                    <th class="text-center" style="width: 6%; font-weight: 500;">Total Shipped Qty</th>
                                    <th colspan="6"></th>
                                </tr> --}}
                                <tr style="color: rgba(22, 22, 23, 1) !important;font-size: 15px;background-color: #f0f0f0;">
                                    <td colspan="5" class="text-center">TOTAL QUANTITIES</td>
                                    <th class="text-center mobile_total_qty" style="font-weight: 500;">
                                        {{-- <span id="total_order_qty">12</span> --}}
                                        <input type="number" class="invoice-inputs text-center" value="" id="total_order_qty" readonly/>
                                    </th>
                                    <th class="text-center mobile_total_qty_shipped" style="font-weight: 500;">
                                        {{-- <span id="total_shipped_qty">5</span> --}}
                                        <input type="number" class="invoice-inputs text-center" value="" id="total_shipped_qty" readonly/>
                                    </th>
                                    <td colspan="7"></td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
            </div>
            <div class="col-lg-12 mt-3 mb-5 no-print text-right mobile-sticky-actions">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-9 ml-auto">
                                {{-- @can('') --}}
                                    <button type="button" class="btn btn-custom" style="display:none;font-size: 0.7rem; border: 1px solid transparent;border-radius: 1rem !important;" id="fulfillButton" disabled>Order has been  fullfilled</button>
                                {{-- @endcan --}}
                                {{-- @can('') --}}
                                    {{-- <button type="button" class="btn btn-custom btn-success shipment-btn" id="shipment_summery">Shipment Summery</button> --}}
                                {{-- @endcan --}}
                                {{-- @can('') --}}
                                    <button  type="button" class="btn btn-custom remake_item_modal_btn" style="color: white; background-color:grey"  >BACK-ORDER / REMAKE <span class="badge badge-pill badge-danger remakecount">0</span></button>
                                {{-- @endcan --}}
                                {{-- @can('save shipping')
                                    <button id="updateShippingOrder" type="button" class="btn btn-custom"
                                    style="background-color: unset;
                                    border: 1px solid #0bd700;
                                    color: #0bd700;">SAVE ONLY</button>
                                @endcan --}}
                                @can('save shipping')
                                    <button
                                    type="button"
                                    class="btn btn-custom"
                                    id="updateShippingOrderToNotify"
                                    style="background-color: unset;
                                    border: 1px solid #0bd700;
                                    color: #0bd700;">SAVE
                                </button>
                                @endcan
                                @can('notify shipping')
                                    <button
                                    type="button"
                                    class="btn btn-custom btn-danger"
                                    id="notify_shipping"
                                    style="background-color: #0bd700;
                                    border: 1px solid #0bd700;
                                    color: #white;">NOTIFY
                                </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</form>

<div class="modal fade" id="shipping_summery_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default" style="color: black;font-size: 25px;">Shipment Summary</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body" style="border-top: 2px solid #efefef;margin-left: 2%;margin-right: 2%;">
                <div class="col-md-12 mt-2" id="summery_body">
                </div>
            </div>
        </div>

            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-success btn-custom close" data-dismiss="modal"> Colse</button>
            </div> --}}
        </div>
    </div>
</div>

{{-- invoice example --}}

                {{-- <div class="row">
                    <div id="invoice_body" style="padding: 3%;background-color: white;padding-top: 5%;">
                        <div class="row">
                            <div class="col-lg-12">
                                <img style="width: 100%;" src="{{asset('public/images/Headerbanner.png')}}" alt="invoice header">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="color: black; margin-top:2%;margin-bottom:1%;margin-left: 3px;">
                                <span style="font-size: 17px">Hi Prasad,</span>
                            </div>
                            <div class="col-lg-12" style="margin-left: 3px;">
                                <span style="color: black;font-size:17px">
                                    We are pleased to announce that your order for Test Organization is on its way to you from our factory.
                                    Please let us know how your items sre once you receive them.
                                </span>
                            </div>
                        </div>
                        <div class="row mt-2" style="margin:.6%">
                            <table>
                                <tr style="height: 35px;">
                                    <td style="color: grey;font-size: 17px;"> Tracking Link</td>
                                    <td style="font-size: 17px;color: lightseagreen;cursor:pointer" onclick="clickhereFunc()">CLICK HERE</td>
                                </tr>
                                <tr style="height: 35px;">
                                    <td style="color: grey;font-size: 17px;">Tracking ID</td>
                                    <td style="color: black;font-size: 17px;">Test 1 - 123456</td>
                                </tr>
                                <tr style="height: 35px;">
                                    <td style="color: grey;font-size: 17px;">EST. Shipping Date&nbsp;&nbsp;</td>
                                    <td style="color: black;font-size: 17px;">11 Aug 2023</td>
                                </tr>
                            </table>
                        </div>
                        <div class="row" style="margin:.6%">
                            <span style="margin-top: 3%;color: black;font-size: 17px;font-weight: 700;">ITEMS IN THIS SHIPMENT</span>
                        </div>
                        <div class="row" style=" margin:.3%">

                            <table style="width: 100%;margin-top: 2%;">
                                <thead class="table-bordered" style="background-color: grey;color: white;font-size: 16px;height: 45px;">
                                    <th>&nbsp;&nbsp;ITEM</th>
                                    <th>&nbsp;&nbsp;SIZE</th>
                                    <th class="text-right">ORDERED QTY&nbsp;&nbsp;</th>
                                    <th class="text-right">SHIPPED QTY&nbsp;&nbsp;</th>
                                </thead>
                                <tbody>

                                    <tr style="height: 45px;background-color: #c7c7c7;color: black;font-size: 16px">
                                        <td>&nbsp;&nbsp;Men's Pro Lacrosse Shooter Shirt</td>
                                        <td class="text-center">Adult Medium</td>
                                        <td class="text-right">10&nbsp;&nbsp;</td>
                                        <td class="text-right">10&nbsp;&nbsp;</td>
                                    </tr>

                                    <tr style="color: black;font-size: 16px;height: 45px;background-color: #fcfcfc;    border-bottom: 1px solid #e4e4e4;">
                                        <td></td>
                                        <td class="text-right">Adult Large</td>
                                        <td class="text-right">5&nbsp;&nbsp;</td>
                                        <td class="text-right">5&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr style="color: black;font-size: 16px;height: 45px;background-color: #fcfcfc;    border-bottom: 1px solid #e4e4e4;">
                                        <td></td>
                                        <td class="text-right">Adult Large</td>
                                        <td class="text-right">5&nbsp;&nbsp;</td>
                                        <td class="text-right">5&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr style="color: black;font-size: 16px;height: 45px;background-color: #fcfcfc;    border-bottom: 1px solid #e4e4e4;">
                                        <td></td>
                                        <td class="text-right">Adult Large</td>
                                        <td class="text-right">5&nbsp;&nbsp;</td>
                                        <td class="text-right">5&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr style="height: 45px;color: black;font-size: 16px;font-weight: 700;background-color: #e2e2e2;">
                                        <td class="text-right">TOTAL</td>
                                        <td></td>
                                        <td class="text-right">15&nbsp;&nbsp;</td>
                                        <td class="text-right">15&nbsp;&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}


<div class="modal fade" id="shipping_notification" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Notification Body</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-button">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="order_item_array" name="order_item_array" />
                <input type="hidden" id="mistaken_order_item_array" name="mistaken_order_item_array" />
                <input type="hidden" id="shipment_editing_details" name="shipment_editing_details" />

                <div class="col-md-12">
                    <div class="input-group shipping-form-field">
                        <div class="input-group-prepend">
                            <span class="input-group-text shipping-group-text" id="basic-addon1">To: </span>
                        </div>
                        <select name="to_email[]" class="select2 form-control pl-1" id="to_email" multiple></select>
                    </div>
                </div>

                <div class="col-md-12 mt-1">
                    <div class="input-group shipping-form-field">
                        <div class="input-group-prepend">
                            <span class="input-group-text shipping-group-text" id="basic-addon1">CC: </span>
                        </div>
                        <input type="text" class="form-control pl-1" id="cc_email" readonly />
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary btn-sm" id="change_cc">Change</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-1">
                    <div class="input-group shipping-form-field">
                        <div class="input-group-prepend">
                            <span class="input-group-text shipping-group-text" id="basic-addon1">Subject: </span>
                        </div>
                        <input type="text" class="form-control pl-1" id="subject_email" />
                    </div>
                </div>

                <div class="col-md-12 mt-2">
                    <textarea type="text" class="form-control discussion-control" name="notification_body" id="notification_body" rows="10"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-custom" id="saveToDraft"> Save to Draft</button>
                <button type="button" class="btn btn-success btn-custom" id="sendNotification"><i class="fab fa-telegram-plane"></i> Send</button>
            </div>
        </div>
    </div>
</div>


@include('pages.order_management.orders.edit_members')
@include('pages.order_management.orders.modal_view_remakeitems')
@include('pages.order_management.orders.partials.order_item_detal_child_row')


{{-- script for checkboxes --}}

<script>
$(document).ready(function () {

    const $buttons = $('.mobile-sticky-actions');

    if (!$buttons.length) {
        return;
    }

    let lastScrollTop = $(window).scrollTop();

    let isFixed = false;


    /*
     * Create placeholder
     *
     * This keeps the original space of the buttons
     * when the buttons become fixed.
     */
    const $placeholder = $('<div class="mobile-sticky-placeholder"></div>');

    $buttons.after($placeholder);


    function setFixed() {

        if (isFixed) {
            return;
        }

        /*
         * Save current height
         */
        const buttonHeight = $buttons.outerHeight();

        $placeholder.css('height', buttonHeight + 'px');

        $buttons.addClass('mobile-fixed-actions');

        isFixed = true;
    }


    function setDefault() {

        if (!isFixed) {
            return;
        }

        /*
         * Remove fixed state.
         *
         * Placeholder keeps the layout stable,
         * so the buttons don't jump.
         */
        $buttons.removeClass('mobile-fixed-actions');

        $placeholder.css('height', '0px');

        isFixed = false;
    }


    function handleScroll() {

        /*
         * Desktop
         */
        if (window.innerWidth > 767.98) {

            setDefault();

            $placeholder.hide();

            lastScrollTop = $(window).scrollTop();

            return;
        }


        $placeholder.show();


        let scrollTop = $(window).scrollTop();

        let windowHeight = $(window).height();

        let documentHeight = $(document).height();

        let scrollBottom = scrollTop + windowHeight;


        /*
         * ==========================================
         * TOP
         * ==========================================
         */

        if (scrollTop <= 100) {

            setDefault();

            lastScrollTop = scrollTop;

            return;
        }


        /*
         * ==========================================
         * BOTTOM
         * ==========================================
         *
         * Give some tolerance so browser doesn't
         * repeatedly switch fixed/default state.
         */

        const bottomThreshold = 35;

        if (scrollBottom >= documentHeight - bottomThreshold) {

            setDefault();

            lastScrollTop = scrollTop;

            return;
        }


        /*
         * ==========================================
         * SCROLL DOWN
         * ==========================================
         */

        if (scrollTop > lastScrollTop) {

            setFixed();

        }


        /*
         * ==========================================
         * SCROLL UP
         * ==========================================
         */

        else if (scrollTop < lastScrollTop) {

            setDefault();

        }


        lastScrollTop = scrollTop;
    }


    $(window).on('scroll', handleScroll);

    $(window).on('resize', function () {

        if (window.innerWidth > 767.98) {

            setDefault();

            $placeholder.hide();

        } else {

            $placeholder.show();
        }

        handleScroll();
    });


    handleScroll();

});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    $('.new-dropdown-style').select2();
</script>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        var buttons = document.querySelectorAll('.ForClickFunc');

        buttons.forEach(function(button) {
            button.click();
        });
        buttons.forEach(function(button) {
            button.click();
        });
        Cal_remake_list();
        updateShippingOrderDetail([]);

    });
    function setInputValue(orderItemDetailId) {
        var selectId = '#CourierServiceSelect' + orderItemDetailId;
        var inputId = '#CourierService' + orderItemDetailId;
        var selectedValue = $(selectId).val();
        console.log(inputId);
        console.log(selectedValue);
        $(inputId).val(selectedValue);
    }
</script>
<script>
    function auto_fullfill() {

        var orderID = $("#notify_order_id").val();

        var checkboxes = $('#shipping_items_table input[type="checkbox"].chkItemChild');
        var shippingRecords = {};

        checkboxes.each(function() {
            var itemNumber = $(this).data('itemnumber');

            var tr = $(this).closest('tr');

            var itemEstDiliveryDate = tr.find('.itemEstDiliveryDate').val();
            var txtTrackingNo = tr.find('.txtTrackingNo').val();
            var txtTrackingLink = tr.find('.txtTrackingLink').val();
            var orderQty = tr.find('.order-qty').val();
            var notifyStatus = tr.find('.notified-row').length > 0 ? 1 : 0;

            var record = {
                itemEstDiliveryDate: itemEstDiliveryDate,
                txtTrackingNo: txtTrackingNo,
                txtTrackingLink: txtTrackingLink,
                orderQty: orderQty,
                notifyStatus: notifyStatus
            };

            if (!shippingRecords[itemNumber]) {
                shippingRecords[itemNumber] = [];
            }

            shippingRecords[itemNumber].push(record);
        });

        console.log(shippingRecords);

        $.ajax({
            url: "{{ route('auto_update_fullfill_status')}}",
            type: "post",
            dataType:'json',
            data: {
                '_token': '{{ csrf_token() }}',
                'shipping_records': shippingRecords,
                'orderID' : orderID
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {
                console.log('Data is : '+response.message);
            },

            });
    }



    $(document).ready(function() {
        auto_fullfill();
    });
</script>

<script>
    // Sent shipment editing Scripts
    //emergency-edit
    $(document).ready(function() {
        $('.CourierService-select').select2();
        $('#edit_sent_shipments').change(function() {
            if ($(this).is(':checked')) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to edit shipment details which have been successfully sent?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, edit it!'
                }).then((result) => {
                    if (result.value) {
                        $('#edit_sent_shipments_icon').removeClass('fa-square-o').addClass('fa-check-square-o');
                        $('.emergency-edit-1').prop('disabled', false);
                    }else{
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Do you want to continue?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    console.log(result);
                    if (result.value) {
                        location.reload();
                    } else {
                        $('#edit_sent_shipments').prop('checked', true);
                    }
                });
            }
        });
    });
</script>


<script>
    var shipping_order_detail_tbl_status = <?php echo json_encode($shippingTblStatus); ?>;


    $(document).ready(function() {

        $('.shipping-datepicker').datepicker({ minDate: 0});

        // Add a click event listener to the close button
        $('.modal .close').on('click', function() {
            // Programmatically close the modal
            $('#shipping_notification').modal('hide');
        });

        $('.notified-row').each(function(){
            $(this).closest("tr").find("input").prop("disabled", true);
        });


        $('#shipment_status').on('change', function() {
            var selectedOption = $(this).val();
            console.log(selectedOption);
            if (selectedOption === 'Pending shipment') {
                showDataAll();
                checkNotifiedAll();
            }else if (selectedOption === 'Data Added') {
                showDataAdded();
            }else if (selectedOption === 'Data Pending') {
                showDataPending();
            } else {
                // window.location.reload();
                var currentUrl = new URL(window.location.href);
                currentUrl.search = '';
                currentUrl.searchParams.append('flt', 'all');
                window.location.href = currentUrl;
            }
        });

        // $('#shipping_pending').click(function(){
        //     checkNotifiedAll();
        // });

        calSumShippedQtyAll();
        calSumOrderQty();
        calSumShippedQty();
        pendingShipmentCheck();

        $('.parent-expand-button').click(function() {
            var targetRows = $(this).data('target-child');
            $(targetRows).collapse('hide');
        });

        if(shipping_order_detail_tbl_status == 'no'){
            // Swal.fire(
            //     'Almost Closer!',
            //     'Please Wait untill it is being ready for the shipment',
            //     'info'
            // )
            updateShippingOrderDetail([]);
        } else {
            $(".se-pre-con").fadeOut('slow');
        }
    });

    function calSumOrderQty() {
        var sumOrderQty = 0
        $('.order-qty').each(function(){
            if($(this).val() != ''){
                sumOrderQty += parseFloat($(this).val());
            }
        });
        $('#total_order_qty').val(sumOrderQty);
    }

    function calSumShippedQty() {
        var sumShippedQty = 0
        $('.shipping-qty').each(function(){
            if($(this).val() != ''){
                sumShippedQty += parseFloat($(this).val());
            }
        });
        $('#total_shipped_qty').val(sumShippedQty);
    }

    function pendingShipmentCheck(){
        var unshippedRows = $('.unnotified-row');
        var totalOrderQty = $('#total_order_qty').val();
        if(unshippedRows.length == 0){
            if(totalOrderQty > 0){
                $('#shipping_pending').toggleClass('btn-danger btn-success');
                $('#shipping_pending').text('Shipment Completed');
            } else {
                $('#shipping_pending').text('Invalid Quantity');
            }
            $('#shipping_pending').prop('disabled', true);
        }
    }

    function calSumShippedQtyAll(){
        $('.chkItemMainChild').each(function(){
            calSumShippedQtyItemDetail($(this).val());
        });

        $('.chkItem').each(function(){
            calSumShippedQtyItem($(this).val());
        });
    }

    function calSumShippedQtyItemDetail(itemDetailId) {
        // Shipped Qty
        var sumShippedQty = 0
        $('.item-detail-shipped-qty-'+itemDetailId+'').each(function(){
            if($(this).val() != ''){
                sumShippedQty += parseFloat($(this).val());
            }
        });
        $('.item-detail-main-shipped-'+itemDetailId).val(sumShippedQty);

        // Backed Qty
        var sumBackedQty = 0
        $('.item-detail-backed-qty-'+itemDetailId+'').each(function(){
            if($(this).val() != ''){
                sumBackedQty += parseFloat($(this).val());
            }
        });
        $('.item-detail-main-backed-'+itemDetailId).val(sumBackedQty);
    }

    function calSumShippedQtyItem(itemId) {
        // Shipped Qty
        var sumShippedQty = 0
        $('.item-shipped-qty-'+itemId+'').each(function(){
            if($(this).val() != ''){
                sumShippedQty += parseFloat($(this).val());
            }
        });
        $('.item-main-shipped-'+itemId).val(sumShippedQty);

        // Backed Qty
        var sumBackedQty = 0
        $('.item-backed-qty-'+itemId+'').each(function(){
            if($(this).val() != ''){
                sumBackedQty += parseFloat($(this).val());
            }
        });
        $('.item-main-backed-'+itemId).val(sumBackedQty);
    }

    function checkNotifiedAll(){
        $('.notified-row').closest("tr").remove();

        $('.chkItemMainChild').each(function(){
            checkNotifiedItemDetail($(this).val());
        });

        $('.chkItem').each(function(){
            checkNotifiedItem($(this).val());
        });

        calSumShippedQtyAll();
        calSumOrderQty();
        calSumShippedQty();
    }

    function checkNotifiedItemDetail(itemId){
        var unNotifiedCount =  $('.unnotified-item-detail-'+itemId).length;
        if(unNotifiedCount == 0){
            $('.row-item-detail-'+itemId).remove();
        }
    }

    function checkNotifiedItem(itemId){
        var unNotifiedCount =  $('.unnotified-item-'+itemId).length;
        if(unNotifiedCount == 0){
            $('.row-item-'+itemId).remove();
        }
    }

    function showDataAll(){
        checkNotifiedAll();
        $('.unsaved-row').addClass("show");
        $('.saved-row').addClass("show");

        $('.unsaved-row').siblings('input.chkItemChild').addClass("show");
        $('.saved-row').siblings('input.chkItemChild').addClass("show");

        $('.unsaved-row').closest("tr").show(100);
        $('.saved-row').closest("tr").show(100);

        $('.chkItemMainChild').each(function(){
            showDataAllItemDetail($(this).val());
        });

        $('.chkItem').each(function(){
            showDataAllItem($(this).val());
        });
    }

    function showDataAllItemDetail(itemId){
            $('.row-item-detail-'+itemId).show(100);
    }

    function showDataAllItem(itemId){
            $('.row-item-'+itemId).show(100);
    }

    function showDataAdded(){
        checkNotifiedAll();

        $('.unsaved-row').removeClass("show");
        $('.saved-row').addClass("show");

        $('.unsaved-row').siblings('input.chkItemChild').removeClass("show");
        $('.saved-row').siblings('input.chkItemChild').addClass("show");

        $('.unsaved-row').closest("tr").hide(100);
        $('.saved-row').closest("tr").show(100);

        $('.chkItemMainChild').each(function(){
            showDataAddedItemDetail($(this).val());
        });

        $('.chkItem').each(function(){
            showDataAddedItem($(this).val());
        });
    }

    function showDataAddedItemDetail(itemId){
        var dataSavedCount =  $('.saved-item-detail-'+itemId).length;
        if(dataSavedCount > 0){
            $('.row-item-detail-'+itemId).show(100);
        } else {
            $('.row-item-detail-'+itemId).hide(100);
        }
    }

    function showDataAddedItem(itemId){
        var dataSavedCount =  $('.saved-item-'+itemId).length;
        if(dataSavedCount > 0){
            $('.row-item-'+itemId).show(100);
        } else {
            $('.row-item-'+itemId).hide(100);
        }
    }

    function showDataPending(){
        checkNotifiedAll();
        $('.saved-row').removeClass("show");
        $('.unsaved-row').addClass("show");

        $('.saved-row').siblings('input.chkItemChild').removeClass("show");
        $('.unsaved-row').siblings('input.chkItemChild').addClass("show");

        $('.saved-row').closest("tr").hide(100);
        $('.unsaved-row').closest("tr").show(100);

        $('.chkItemMainChild').each(function(){
            showDataPendingItemDetail($(this).val());
        });

        $('.chkItem').each(function(){
            showDataPendingItem($(this).val());
        });
    }

    function showDataPendingItemDetail(itemId){
        var dataSavedCount =  $('.unsaved-item-detail-'+itemId).length;
        if(dataSavedCount > 0){
            $('.row-item-detail-'+itemId).show(100);
        } else {
            $('.row-item-detail-'+itemId).hide(100);
        }
    }

    function showDataPendingItem(itemId){
        var dataSavedCount =  $('.unsaved-item-'+itemId).length;
        if(dataSavedCount > 0){
            $('.row-item-'+itemId).show(100);
        } else {
            $('.row-item-'+itemId).hide(100);
        }
    }

    function toggleCheckboxes(checkbox, targetCheckboxName) {
        var checkboxes = document.getElementsByName(targetCheckboxName);
        var fltType = $('#shipment_status').val();
            $.each(checkboxes, function(index, value){
                if(!$(this).prop('disabled')){
                    if(checkbox.checked == true){
                        if(fltType == 'Data Added' || fltType == 'Data Pending'){
                            if ($(this).hasClass('show')) {
                                $(this).prop('checked', true);
                                if($(this).attr('data-saved-status') == 0){
                                    autofillQtys($(this));
                                }
                            }
                        } else {
                            $(this).prop('checked', true);
                            if($(this).attr('data-saved-status') == 0){
                                autofillQtys($(this));
                            }
                        }
                    } else {
                        $(this).prop('checked', false);
                        if($(this).attr('data-saved-status') == 0){
                            autofillRemoveQtys($(this));
                        }
                    }

                }
            });
    }

    function mainCheckboxes(checkbox) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]:not(:disabled)');
        checkboxes.forEach(function(parentCheckbox) {
            // Only toggle if the parent checkbox is not disabled
            if (!parentCheckbox.disabled) {
                parentCheckbox.checked = checkbox.checked;
                // Trigger the change event to check/uncheck sub-checkboxes
                toggleCheckboxes(parentCheckbox, 'subcheckbox' + parentCheckbox.getAttribute('data-itemnumber'));
            }
        });
        var fltType = $('#shipment_status').val();
        $.each(checkboxes, function(index, value){
                if(checkbox.checked == true){
                    if(fltType == 'Data Added' || fltType == 'Data Pending'){
                        if ($(this).hasClass('show')) {
                            $(this).prop('checked', true);
                            if($(this).attr('data-saved-status') == 0){
                                autofillQtys($(this));
                            }
                        } else {
                            $(this).prop('checked', true);
                            if($(this).attr('data-saved-status') == 0){
                                autofillQtys($(this));
                            }
                        }
                    }
                } else {
                    $(this).prop('checked', false);
                    if($(this).attr('data-saved-status') == 0){
                        autofillRemoveQtys($(this));
                    }
                }
        });
    }

    function toggleSeqCheckboxes(checkbox, targetCheckboxName) {
        var checkboxes = document.getElementsByClassName(targetCheckboxName);
        var fltType = $('#shipment_status').val();
        $.each(checkboxes, function(index, value){
            if(!$(this).prop('disabled')){
                if(checkbox.checked == true){
                    if(fltType == 'Data Added' || fltType == 'Data Pending'){
                        if ($(this).hasClass('show')) {
                            $(this).prop('checked', true);
                            if($(this).attr('data-saved-status') == 0){
                                autofillQtys($(this));
                            }
                        }
                    } else {
                        $(this).prop('checked', true);
                        if($(this).attr('data-saved-status') == 0){
                            autofillQtys($(this));
                        }
                    }
                } else {
                    $(this).prop('checked', false);
                    if($(this).attr('data-saved-status') == 0){
                        autofillRemoveQtys($(this));
                    }
                }
            }
        });
    }

    $('body').on('click', '.chkItemChild', function(){
        if($(this).attr('data-saved-status') == 0){
            if( $(this).prop('checked') ){
                autofillQtys($(this));
            } else {
                autofillRemoveQtys($(this));
            }
        }
    });

    function autofillQtys(selectedCheckbox){
        var selectedOrderQtyInput = selectedCheckbox.closest('tr').find('.order-qty');
        if(selectedOrderQtyInput.length > 0){
            var shippinQtyInput = selectedCheckbox.closest('tr').find('.shipping-qty');
            shippinQtyInput.val(selectedOrderQtyInput.val());
            shippinInputFinalCal(shippinQtyInput, 0);
        }
    }

    function autofillRemoveQtys(selectedCheckbox){
        var shippinQtyInput = selectedCheckbox.closest('tr').find('.shipping-qty');
        shippinQtyInput.val(0);
        shippinInputFinalCal(shippinQtyInput, 0);
    }

    const expandButtons = document.querySelectorAll('.expand-button');

    expandButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const icon = button.querySelector('i');
            const isExpanded = button.getAttribute('aria-expanded') === 'true';

            if (isExpanded) {
            icon.classList.replace('fa-angle-right', 'fa-angle-down');

            } else {
            icon.classList.replace('fa-angle-down', 'fa-angle-right');
            }
        });
    });

    // auto set backordered qty
    function updateBackorderedQty1(input) {
        var shippedQty = parseFloat(input.value);
        var orderQty = parseFloat(input.parentNode.previousElementSibling.firstElementChild.value);
        var backorderedQtyInput = input.parentNode.nextElementSibling.firstElementChild;

        var backorderedQty = orderQty - shippedQty;
        backorderedQtyInput.value = backorderedQty;
    }

    function updateBackorderedQty(input) {
        // var shippedQty = parseFloat(input.value);
        // var totalQty = parseFloat(input.parentNode.previousElementSibling.innerText);
        // var backorderedQtyInput = input.parentNode.nextElementSibling.firstElementChild;

        // var backorderedQty = totalQty - shippedQty;
        // backorderedQtyInput.value = backorderedQty;
    }

    $(document).ready(function(){
        $("#notification_body").Editor({
            'block_quote':false,
            'undo':false,
            'redo':false,
            'unlink':false,
            'insert_img':false,
            'insert_table':false,
            'splchars':false,
            'hr_line':false,
            'print':false,
            'rm_format':false,
            'select_all':false,
            'source':false,
            'togglescreen':false,
        });

        $("#to_email").select2({
            dropdownParent: $("#shipping_notification"),
            tags: true,
            tokenSeparators: [',', ' '],
            width: 'resolve'
        });
    });


    $('html').bind('paste', function(e) {
        if(e.originalEvent.clipboardData){
            var text = e.originalEvent.clipboardData.getData("text/plain");

            if(text.indexOf("http") >= 0){
                text="<a href="+text+">"+text+"</a>";
            }

            document.execCommand("insertHTML", false, text);
            e.preventDefault();
        }
    });


    var shippingInputFilled = [];
    $('body').on('input', '.shipping-input', function(){
        var inputName = $(this).attr("name");
        shippingInputFilled.push(inputName);
    });

    $('body').on('input', '.shipping-qty', function(){
        var shippinQtyInput = $(this);
        var shippingQtyMin = parseInt( shippinQtyInput.attr("min") );
        var shippingQtyMax = parseInt( shippinQtyInput.attr("max") );
        var shippingQtyVal = parseInt( shippinQtyInput.val() );

        if(shippingQtyVal >= shippingQtyMax) {
            shippingQtyVal = shippingQtyMax;
        } else if(shippingQtyVal <= shippingQtyMin) {
            shippingQtyVal = shippingQtyMin;
        }

        shippinQtyInput.val(shippingQtyVal);
        var backorderedQty = shippingQtyMax - shippingQtyVal;
        shippinInputFinalCal(shippinQtyInput, backorderedQty)
    });

    function shippinInputFinalCal(shippinQtyInput, backorderedQty)
    {
        shippinQtyInput.closest('tr').find('.backed-qty').val(backorderedQty);


        if(shippinQtyInput.attr('data-item-detail-id')){
            calSumShippedQtyItemDetail(shippinQtyInput.attr('data-item-detail-id'));
        }
        if(shippinQtyInput.attr('data-item-id')){
            calSumShippedQtyItem(shippinQtyInput.attr('data-item-id'));
        }
        calSumShippedQty();
    }

    // Apply Est Delivery Date.
    $('body').on('change', '.itemEstDiliveryDate', function() {
        var delDate = $(this).val();
        if(delDate && delDate != ''){
            var thisCheckBox = $(this).closest('tr').find('.chkItemChild:checkbox:checked');
            if(thisCheckBox.length > 0){
                var checkBoxes = $('.chkItemChild:checkbox:checked');
                checkBoxes.each(function(){
                    $(this).closest('tr').find('.itemEstDiliveryDate').val(delDate);
                    shippingInputFilled.push( $(this).closest('tr').find('.itemEstDiliveryDate').attr("name") );
                });
            }
        }
    });

    // Apply CourierService.
    $('body').on('change', '.CourierService', function() {
    var CourierService = $(this).val();
    var checkBoxes = $(this).closest('table').find('.chkItemChild:checkbox:checked');

    if (checkBoxes.length > 0) {
        checkBoxes.each(function() {
            var courierServiceInput = $(this).closest('tr').find('.CourierService');
            courierServiceInput.val(CourierService).trigger('change.select2');

            // Store the corresponding itemEstDiliveryDate name in the array
            shippingInputFilled.push(courierServiceInput.closest('tr').find('.itemEstDiliveryDate').attr("name"));
        });
    }
});

    // Apply Tracking No.
    $('body').on('focusout', '.txtTrackingNo', function() {
        var trakingNo = $(this).val();
        var thisCheckBox = $(this).closest('tr').find('.chkItemChild:checkbox:checked');
        if(thisCheckBox.length > 0){
            var checkBoxes = $('.chkItemChild:checkbox:checked');
            checkBoxes.each(function(){
                $(this).closest('tr').find('.txtTrackingNo').val(trakingNo);
                shippingInputFilled.push( $(this).closest('tr').find('.itemEstDiliveryDate').attr("name") );
            });
        }
    });

    // Apply Tracking No.
    $('body').on('focusout', '.txtTrackingLink', function() {
        var trakingLink = $(this).val();
        var thisCheckBox = $(this).closest('tr').find('.chkItemChild:checkbox:checked');
        if(thisCheckBox.length > 0){
            var checkBoxes = $('.chkItemChild:checkbox:checked');
            checkBoxes.each(function(){
                $(this).closest('tr').find('.txtTrackingLink').val(trakingLink);
                shippingInputFilled.push( $(this).closest('tr').find('.itemEstDiliveryDate').attr("name") );
            });
        }
    });

    function update_resent(){

        var shipment_editing_details_value = JSON.parse($('#shipment_editing_details').val());

        if(shipment_editing_details_value.length > 0){

            $.ajax({
                url: "{{ url('order/mistaken_shipping_updates')}}",
                type: "post",
                dataType:'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'shipment_editing_details': shipment_editing_details_value,
                    'status':2
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (response) {
                    $('#mistaken_order_item_array').val('');
                    $('#shipment_editing_details').val('');
                },

            });
        }
    }


    $('#notify_shipping').on('click', function(event){
        $('.shipping-qty').removeClass('empty-notice');
        $('.txtTrackingNo').removeClass('empty-notice');
        $('.txtTrackingLink').removeClass('empty-notice');
        var checkBoxes = $('.chkItemChild:checkbox:checked');

        var count_of_resent = 0;

        checkBoxes.each(function() {
            var tr = $(this).closest('tr');
            var notifyStatus = tr.find('.notify-status');
            if (notifyStatus.text() == 'Sent') {
                count_of_resent++;
            }
        });

        $('#mistaken_order_item_array').val('');
        $('#shipment_editing_details').val('');

        if(checkBoxes.length > 0){
            var shipment_editing_details = [];
            var mistaken_order_item_array = [];

            checkBoxes.each(function() {
                var tr = $(this).closest('tr');
                var notifyStatus = tr.find('.notify-status');

                if (notifyStatus.text() == 'Sent') {
                    var shipping_qty = tr.find('.shipping-qty').val();
                    var backordered_qty = tr.find('.backed-qty').val();
                    var est_delivery_date = tr.find('.itemEstDiliveryDate').val();
                    var tracking_no = tr.find('.txtTrackingNo').val();
                    var tracking_link = tr.find('.txtTrackingLink').val();
                    var checkbox_value = $(this).val();

                    shipment_editing_details.push({
                        shipping_qty: shipping_qty,
                        backordered_qty: backordered_qty,
                        est_delivery_date: est_delivery_date,
                        tracking_no: tracking_no,
                        tracking_link: tracking_link,
                        checkbox_value: checkbox_value
                    });
                    mistaken_order_item_array.push(checkbox_value);
                }
            });

            $('#mistaken_order_item_array').val(mistaken_order_item_array);
            $('#shipment_editing_details').val(JSON.stringify(shipment_editing_details));

            // update_resent();

        }

        var orderItemArr = [];
        var orderNoShipItemArr = [];
        var orderNoTrackinNoArr = [];
        var orderNoTrackinLinkArr = [];

        $.each(checkBoxes, function(index, value){

        var tr_next = $(this).closest('tr');
            var notifyStatus_next = tr_next.find('.notify-status');

            if (notifyStatus_next.text() != 'Sent'){

                var orderItem = $(this).val();
                orderItemArr.push(orderItem);
                if ($(this).closest('tr').find('.shipping-qty').val() == '' || $(this).closest('tr').find('.shipping-qty').val() == 0) {
                    orderNoShipItemArr.push($(this));
                }
                if ($(this).closest('tr').find('.txtTrackingNo').val() == '') {
                    orderNoTrackinNoArr.push($(this));
                }
                if ($(this).closest('tr').find('.txtTrackingLink').val() == '') {
                    orderNoTrackinLinkArr.push($(this));
                }
            }

        });

        if (orderItemArr.length === 0) {

            if ($('#mistaken_order_item_array').val() != '') {
                displayMistakenNotification(true);
            }else{
                Swal.fire(
                    'Error!',
                    'Please select an item!',
                    'warning'
                )
            }
        } else {
            if(orderNoShipItemArr.length > 0){
                Swal.fire(
                    'Error!',
                    'Please Enter Shipped Quantity!',
                    'warning'
                );
                for(i=0; i < orderNoShipItemArr.length; i++){
                    orderNoShipItemArr[i].closest('tr').find('.shipping-qty').addClass('empty-notice');
                };
            } else if(orderNoTrackinNoArr.length > 0){
                Swal.fire(
                    'Error!',
                    'Please Enter Tracking Number!',
                    'warning'
                );
                for(i=0; i < orderNoTrackinNoArr.length; i++){
                    orderNoTrackinNoArr[i].closest('tr').find('.txtTrackingNo').addClass('empty-notice');
                };
            } else if(orderNoTrackinLinkArr.length > 0){
                Swal.fire(
                    'Error!',
                    'Please Enter Tracking Link!',
                    'warning'
                );
                for(i=0; i < orderNoTrackinLinkArr.length; i++){
                    orderNoTrackinLinkArr[i].closest('tr').find('.txtTrackingLink').addClass('empty-notice');
                };
            } else {
                if(shippingInputFilled.length >= 1){
                    Swal.fire(
                        'Error!',
                        'You Have Unsaved Data. Please Save Data First!',
                        'warning'
                    );
                    // var formData = $("#shipping_frm").serializeArray();
                    // var orderID = $("#notify_order_id").val();

                    // $.ajax({
                    //     url: "{{ url('order/shippingupdate')}}",
                    //     type: "post",
                    //     dataType:'json',
                    //     data: formData,
                    //     beforeSend: function () {
                    //         $(".se-pre-con").fadeIn('slow');
                    //     },
                    //     success: function (response) {
                    //         if(response[1] == "Shipping Details Updated") {
                    //             if(response[0] == 'yes'){
                    //                 location.reload();
                    //             } else {
                    //                 $('#order_item_array').val(orderItemArr);
                    //                 if($('#mistaken_order_item_array').val() != ''){
                    //                     displayMistakenNotification(false);
                    //                     displayNewNotification();
                    //                 }else{
                    //                     displayNewNotification();
                    //                 }
                    //             }
                    //         } else {
                    //             Swal.fire(
                    //                 'Error!',
                    //                 'Something Went Wrong!',
                    //                 'warning'
                    //             )
                    //         }


                    //     },
                    //     complete: function () {
                    //         shippingInputFilled = [];
                    //         $(".se-pre-con").fadeOut('slow');
                    //     }
                    // });
                } else {
                    $('#order_item_array').val(orderItemArr);

                    if($('#mistaken_order_item_array').val() != ''){
                        displayMistakenNotification(false);
                        displayNewNotification();
                    }else{
                        displayNewNotification();
                    }

                }
            }
        }

        return false;

    });

    function displayNewNotification(){
        $('#shipping_notification').modal('show');
        var order_id = $('#notify_order_id').val();
        var order_item_array = $('#order_item_array').val();
        var order_id_formatted = ("000000" + order_id).slice(-6);

        console.log("Original :"+order_item_array);

        $.ajax({
            url: '{{ url("order_details/shipping_details") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'order_id':order_id, 'order_item_array':order_item_array, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                var organizationName = data.order.organization_details.organization_name;
                var contactPerson = data.order.contact_details.first_name;
                var orderItems = data.orderItems;
                var orderEmail = data.order.email;
                var sub_products = data.sub_products;
                var destinationAddress = data.destination;
                var toEmail = data.to;
                $("#to_email").html('');
                var toEmailArr = [];
                for (var l = 0; l < toEmail.length; l++) {
                    if (toEmail[l] == orderEmail) {
                        var selectedText = 'selected';
                    } else {
                        var selectedText = '';
                    }
                    toEmailArr += '<option value="' + toEmail[l] + '" '+ selectedText +'>' + toEmail[l] + '</option>';
                }
                $("#to_email").append(toEmailArr);

                loadDefaultCcEmails(order_id);

                /* Get all currently selected To emails */
                var selectedToEmails = $('#to_email').val() || [];

                /* Display selected To emails in CC */
                var uniqueCcEmails = [];

                $.each(selectedToEmails, function(index, email) {
                    if (email && uniqueCcEmails.indexOf(email) === -1) {
                        uniqueCcEmails.push(email);
                    }
                });

                $('#cc_email').val(uniqueCcEmails.join(', '));
                $('#cc_email').attr('data-cc_emails', uniqueCcEmails);


                $("#subject_email").val('Tracking # - '+organizationName+' (Order #'+order_id_formatted+')');


                // var ccEmail = data.cc;

                // var uniqueCcEmailArr = [];
                // for (let n = 0; n < ccEmail.length; n++) {
                //     if (uniqueCcEmailArr.indexOf(ccEmail[n]) === -1 && ccEmail[n] !== '') {
                //         uniqueCcEmailArr.push(ccEmail[n]);
                //     }
                // }

                // var ccEmailArr = [];
                // for (let m = 0; m < uniqueCcEmailArr.length; m++) {
                //     if (m == (uniqueCcEmailArr.length - 1)) {
                //         ccEmailArr += uniqueCcEmailArr[m];
                //     } else {
                //         ccEmailArr += uniqueCcEmailArr[m]+', ';
                //     }
                // }
                // $('#cc_email').val(ccEmailArr);
                // $('#cc_email').attr('data-cc_emails', uniqueCcEmailArr);


                if (orderItems) {
                    var shippingItems = '';
                    for (var i = 0; i < orderItems.length; i++) {

                        //new UI

                        var detailUI ='<div class="row mt-2" style="margin: .3%;">' +
                                    '<table>' +
                                    // '<tr style="height: 35px;">' +
                                    // '<td style="color: grey; font-size: 15px;"> Order Number</td>' +

                                    // '<td><a href="https://encr.co/customer_portal/order_view/'+order_id+'" style="font-size: 15px; color: lightseagreen !important;" target="_blank">'+ order_id_formatted+'</a></td>' +

                                    // '</tr>' +

                                    '<tr style="height: 35px;">' +
                                        '<td style="color: grey; font-size: 15px;">Destination</td>' +
                                        '<td style="color: black; font-size: 15px;">' + destinationAddress +'</td>' +

                                    '</tr>' +

                                    '<tr style="height: 35px;">' +
                                        '<td style="color: grey; font-size: 15px;">Logistic Carrier</td>' +
                                        '<td style="color: black; font-size: 15px;">' + orderItems[i].CourierService +'</td>' +

                                    '</tr>' +
                                        '<tr style="height: 35px;">' +
                                        '<td style="color: grey; font-size: 15px;">Tracking #</td>' +
                                        '<td style="color: black; font-size: 15px;">' + orderItems[i].tracking_no + '</td>' +
                                    '</tr>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;"> Tracking Link</td>' +

                                    '<td><a href="' + orderItems[i].tracking_link + '" style="font-size: 15px; color: lightseagreen !important; cursor: pointer;" target="_blank">CLICK HERE</a></td>' +
                                    '</tr>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;">Est. Delivery Date&nbsp;&nbsp;</td>' +
                                    '<td style="color: black; font-size: 15px;">' + orderItems[i].display_est_delivery_date + '</td>' +
                                    '</tr>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;"> Shipment Summary</td>' +

                                    '<td><a href="https://encr.co/customer_portal/shipment_summary_view/'+order_id+'" style="font-size: 15px; color: lightseagreen !important; cursor: pointer;" target="_blank">CLICK HERE</a></td>' +
                                    '</tr>' +

                                    '</table>' +
                                    '</div>'+
                                    '<div class="row" style="margin: .3%;">'+
                                    '<span style="margin-top: 3%;color: black;font-size: 15px;font-weight: 700;">Items in this shipment</span>'+
                                    '</div>';


                        var shippingItemContent = '';

                        if (orderItems[i].products) {
                            var tableStart ='<div class="row" style="margin: .3%;"><table style="width: 100%;margin-top: 2%;">';
                            var tableEnd ='</table></div>';
                            var tableRowData = '';
                            var Headingrow = '<thead class="table-bordered" style="background-color: grey; color: white; font-size: 14px; height: 45px;">' +
                                            '<tr>' +
                                            '<th>&nbsp;&nbsp;ITEM</th>' +
                                            '<th>&nbsp;&nbsp;SIZE</th>' +
                                            '<th class="text-right">ORDERED QTY&nbsp;&nbsp;</th>' +
                                            '<th class="text-right">SHIPPED QTY&nbsp;&nbsp;</th>' +
                                            '</tr>' +
                                            '</thead>';
                            var products = orderItems[i].products;
                            var totalCountTotal = 0;
                            var totalCountShipped = 0;

                            products.sort(function(a, b) {
                                var productA = a.order_items.product_details.product_name.toUpperCase();
                                var productB = b.order_items.product_details.product_name.toUpperCase();
                                if (productA < productB) {
                                    return -1;
                                }
                                if (productA > productB) {
                                    return 1;
                                }
                                return 0;
                            });

                            var productNameReminder = null;

                            for (var j = 0; j < products.length; j++) {
                                var fullOrderQty = 0;

                                if(products[j].order_item_detail_qtys){
                                    if(products[j].order_item_detail_qtys.blanks){
                                        fullOrderQty += parseInt(products[j].order_item_detail_qtys.blanks);
                                    }
                                    if(products[j].order_item_detail_qtys.qty){
                                        fullOrderQty += parseInt(products[j].order_item_detail_qtys.qty);
                                    }
                                }

                                totalCountTotal += fullOrderQty;

                                totalCountShipped += parseInt(products[j].shipped_qty);


                                if(productNameReminder !== products[j].order_items.product_details.product_name){

                                    var foundSubProduct = sub_products.find(function(subProduct) {
                                        return subProduct.sub_product_no == products[j].order_items.sub_product_no;
                                    });

                                    var name_for_display = '';

                                    if (!products[j].order_items.display_name) {
                                        name_for_display = foundSubProduct.product_name;
                                    } else {
                                        name_for_display = products[j].order_items.display_name;
                                    }

                                    var MainDatarow = '<tr style="height: 45px; background-color: #c7c7c7; color: black; font-size: 14px; border-bottom: 1px solid #e4e4e4;">' +
                                        '<td>&nbsp;&nbsp;' + name_for_display + '</td>' +
                                        '<td class="text-center">' + products[j].size_name + '</td>' +
                                        '<td class="text-right">' + fullOrderQty + '&nbsp;&nbsp;</td>' +
                                        '<td class="text-right">' + products[j].shipped_qty + '&nbsp;&nbsp;</td>' +
                                        '</tr>';

                                    tableRowData = tableRowData + MainDatarow;

                                    productNameReminder = products[j].order_items.product_details.product_name;

                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem;">'+products[j].order_items.product_details.product_name+'</p>';
                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem; padding-bottom: 10px;">Size - '+products[j].size_name+' | Ordered Qty - '+fullOrderQty+' | Shipped Qty - '+products[j].shipped_qty+'</p>';

                                }else{

                                    var tableDatarow = '<tr style="color: black; font-size: 14px; height: 45px; background-color: #fcfcfc; border-bottom: 1px solid #e4e4e4;">' +
                                            '<td>&nbsp;</td>' +
                                            '<td class="text-center">' + products[j].size_name + '</td>' +
                                            '<td class="text-right">' + fullOrderQty + '&nbsp;&nbsp;</td>' +
                                            '<td class="text-right">' + products[j].shipped_qty + '&nbsp;&nbsp;</td>' +
                                            '</tr>';


                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem;">'+products[j].order_items.product_details.product_name+'</p>';
                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem; padding-bottom: 10px;">Size - '+products[j].size_name+' | Ordered Qty - '+fullOrderQty+' | Shipped Qty - '+products[j].shipped_qty+'</p>';

                                tableRowData = tableRowData + tableDatarow;

                                }
                            }
                            var TotalCountRow = '<tr style="height: 45px; color: black; font-size: 14px; font-weight: 700; background-color: #e2e2e2;">' +
                                                '<td class="text-right">TOTAL</td>' +
                                                '<td></td>' +
                                                '<td class="text-right">' + totalCountTotal + '&nbsp;&nbsp;</td>' +
                                                '<td class="text-right">' + totalCountShipped + '&nbsp;&nbsp;</td>' +
                                                '</tr>';

                            shippingItemContent =tableStart + Headingrow + tableRowData + TotalCountRow + tableEnd;

                        }


                        shippingItems = shippingItemContent;
                        break;

                    }
                }

                var emailBody = '<div class="row">' +
                    '<div id="invoice_body" style="padding: 3%; background-color: white; padding-top: 5%;">' +
                    '<div class="row mb-2">' +
                    '<div class="col-lg-12" style="color: black; margin-top: 2%; margin-bottom: 1%; margin-left: 3px;">' +

                    '<span style="font-size: 17px">Hi '+contactPerson+',</span>' +
                    '</div>' +
                    '<div class="col-lg-12" style="margin-left: 3px;">' +
                    '<span style="color: black; font-size: 17px;">' +
                    'We are pleased to announce that your order  <a href="https://encr.co/customer_portal/order_view/'+order_id+'" style="font-size: 15px; color: lightseagreen !important;" target="_blank">(<b>' + order_id_formatted + '</b>)</a> for <b>'+organizationName+'</b> is on its way to you from our factory.<br><br>' +

                    'Please let us know how your items are once you receive them.' +
                    '</span>' +
                    '</div>' +
                    '</div>' +

                    detailUI +
                    shippingItems+
                    '<div class="row mb-2 mt-4" style="color:black;margin: .3%;margin-top:2%"><p style="text-align: left; max-width: 600px; margin: 0rem;">' +

                    'Thank you for your order!<br><br>' +
                    'Encore Team<br><br>' +
                    '<img style="max-width: 250px;" src="https://encr.co/public/images/signature.png" /><br>' +
                    '</p></div>' +
                    '</div>' +
                    '</div>';

                var emailBodyNew = '<div class="ml-2">'+
                    detailUI +
                    shippingItems+
                    '<div class="row mb-2 mt-4" style="color:black;margin: .3%;margin-top:2%"><p style="text-align: left; max-width: 600px; margin: 0rem;">' +

                    'Thank you for your order!<br><br>' +
                    'Encore Team<br><br>' +
                    '<img style="max-width: 250px;" src="https://encr.co/public/images/signature.png" /><br>' +
                    '</p></div>' +
                    '</div>' +
                    '</div>';


                if($('#mistaken_order_item_array').val() != ''){

                    console.log('worked 1');

                    $('#tempory_footer').remove();
                    $('#notification_body + .Editor-container .Editor-editor').append(emailBodyNew);

                }else{
                    console.log('worked 2');
                    $('#notification_body + .Editor-container .Editor-editor').html(emailBody);
                }

            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    };

    function loadDefaultCcEmails(orderId) {

        $.ajax({
            url: '{{url("order_details/get_sales_team")}}/' + orderId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {

                var members = data[0] || [];

                var cc_users = [];

                // Default checked users only
                for (var i = 0; i < members.length; i++) {

                    if (members[i].email &&
                        cc_users.indexOf(members[i].email) === -1) {

                        cc_users.push(members[i].email);
                    }
                }

                // Display emails in CC field
                $('#cc_email').val(cc_users.join(', '));

                // Keep array for send/draft
                $('#cc_email').attr('data-cc_emails', cc_users);
            }
        });
    }

    function displayMistakenNotification(modal_display){

        if(modal_display){
            $('#shipping_notification').modal('show');
        }
        var order_id = $('#notify_order_id').val();
        var mistaken_order_item_array = $('#mistaken_order_item_array').val();
        var order_id_formatted = ("000000" + order_id).slice(-6);

        console.log("mistaken function :"+mistaken_order_item_array);

        $.ajax({
            url: '{{ url("order_details/shipping_details") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'order_id':order_id, 'order_item_array':mistaken_order_item_array, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                var organizationName = data.order.organization_details.organization_name;
                var contactPerson = data.order.contact_details.first_name;
                var orderItems = data.orderItems;
                var orderEmail = data.order.email;
                var sub_products = data.sub_products;
                var destinationAddress = data.destination;

                loadDefaultCcEmails(order_id);

                var toEmail = data.to;
                $("#to_email").html('');
                var toEmailArr = [];
                for (var l = 0; l < toEmail.length; l++) {
                    if (toEmail[l] == orderEmail) {
                        var selectedText = 'selected';
                    } else {
                        var selectedText = '';
                    }
                    toEmailArr += '<option value="' + toEmail[l] + '" '+ selectedText +'>' + toEmail[l] + '</option>';
                }
                $("#to_email").append(toEmailArr);

                $("#subject_email").val('Tracking # - '+organizationName+' (Order #'+order_id_formatted+')');

                // var ccEmail = data.cc;

                // var uniqueCcEmailArr = [];
                // for (let n = 0; n < ccEmail.length; n++) {
                //     if (uniqueCcEmailArr.indexOf(ccEmail[n]) === -1 && ccEmail[n] !== '') {
                //         uniqueCcEmailArr.push(ccEmail[n]);
                //     }
                // }

                // var ccEmailArr = [];
                // for (let m = 0; m < uniqueCcEmailArr.length; m++) {
                //     if (m == (uniqueCcEmailArr.length - 1)) {
                //         ccEmailArr += uniqueCcEmailArr[m];
                //     } else {
                //         ccEmailArr += uniqueCcEmailArr[m]+', ';
                //     }
                // }
                // $('#cc_email').val(ccEmailArr);
                // $('#cc_email').attr('data-cc_emails', uniqueCcEmailArr);

                console.log("Mistaken "+orderItems);

                if (orderItems) {
                    var shippingItems = '';
                    for (var i = 0; i < orderItems.length; i++) {

                        //new UI

                        var detailUI ='<div class="row mt-2" style="margin: .3%;">' +
                                    '<table>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;"> Order Number</td>' +

                                    '<td><a href="https://encr.co/customer_portal/order_view/'+order_id+'" style="font-size: 15px; color: lightseagreen !important;" target="_blank">'+ order_id_formatted+'</a></td>' +

                                    '</tr>' +

                                    '<tr style="height: 35px;">' +
                                        '<td style="color: grey; font-size: 15px;">Destination</td>' +
                                        '<td style="color: black; font-size: 15px;">' + destinationAddress +'</td>' +

                                    '</tr>' +

                                    '<tr style="height: 35px;">' +
                                        '<td style="color: grey; font-size: 15px;">Logistic Carrier</td>' +
                                        '<td style="color: black; font-size: 15px;">' + orderItems[i].CourierService +'</td>' +

                                    '</tr>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;"> Tracking Link</td>' +

                                    '<td><a href="' + orderItems[i].tracking_link + '" style="font-size: 15px; color: lightseagreen !important; cursor: pointer;" target="_blank">CLICK HERE</a></td>' +

                                    '</tr>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;">Tracking #</td>' +
                                    '<td style="color: black; font-size: 15px;">' + orderItems[i].tracking_no + '</td>' +
                                    '</tr>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;">Est. Delivery Date&nbsp;&nbsp;</td>' +
                                    '<td style="color: black; font-size: 15px;">' + orderItems[i].display_est_delivery_date + '</td>' +
                                    '</tr>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;"> Shipment Summary</td>' +

                                    '<td><a href="https://encr.co/customer_portal/shipment_summary_view/'+order_id+'" style="font-size: 15px; color: lightseagreen !important; cursor: pointer;" target="_blank">CLICK HERE</a></td>' +
                                    '</tr>' +
                                    '</table>' +
                                    '</div>'+
                                    '<div class="row" style="margin: .3%;">'+
                                    '<span style="margin-top: 3%;color: black;font-size: 15px;font-weight: 700;">Items in this shipment</span>'+
                                    '</div>';


                        var shippingItemContent = '';

                        if (orderItems[i].products) {
                            var tableStart ='<div class="row" style="margin: .3%;"><table style="width: 100%;margin-top: 2%;">';
                            var tableEnd ='</table></div>';
                            var tableRowData = '';
                            var Headingrow = '<thead class="table-bordered" style="background-color: grey; color: white; font-size: 14px; height: 45px;">' +
                                            '<tr>' +
                                            '<th>&nbsp;&nbsp;ITEM</th>' +
                                            '<th>&nbsp;&nbsp;SIZE</th>' +
                                            '<th class="text-right">ORDERED QTY&nbsp;&nbsp;</th>' +
                                            '<th class="text-right">SHIPPED QTY&nbsp;&nbsp;</th>' +
                                            '</tr>' +
                                            '</thead>';
                            var products = orderItems[i].products;
                            var totalCountTotal = 0;
                            var totalCountShipped = 0;

                            products.sort(function(a, b) {
                                var productA = a.order_items.product_details.product_name.toUpperCase();
                                var productB = b.order_items.product_details.product_name.toUpperCase();
                                if (productA < productB) {
                                    return -1;
                                }
                                if (productA > productB) {
                                    return 1;
                                }
                                return 0;
                            });

                            var productNameReminder = null;

                            for (var j = 0; j < products.length; j++) {
                                var fullOrderQty = 0;

                                if(products[j].order_item_detail_qtys){
                                    if(products[j].order_item_detail_qtys.blanks){
                                        fullOrderQty += parseInt(products[j].order_item_detail_qtys.blanks);
                                    }
                                    if(products[j].order_item_detail_qtys.qty){
                                        fullOrderQty += parseInt(products[j].order_item_detail_qtys.qty);
                                    }
                                }

                                totalCountTotal += fullOrderQty;

                                totalCountShipped += parseInt(products[j].shipped_qty);


                                if(productNameReminder !== products[j].order_items.product_details.product_name){

                                    var foundSubProduct = sub_products.find(function(subProduct) {
                                        return subProduct.sub_product_no == products[j].order_items.sub_product_no;
                                    });

                                    var name_for_display = '';

                                    if (!products[j].order_items.display_name) {
                                        name_for_display = foundSubProduct.product_name;
                                    } else {
                                        name_for_display = products[j].order_items.display_name;
                                    }

                                    var MainDatarow = '<tr style="height: 45px; background-color: #c7c7c7; color: black; font-size: 14px; border-bottom: 1px solid #e4e4e4;">' +
                                        '<td>&nbsp;&nbsp;' + name_for_display + '</td>' +
                                        '<td class="text-center">' + products[j].size_name + '</td>' +
                                        '<td class="text-right">' + fullOrderQty + '&nbsp;&nbsp;</td>' +
                                        '<td class="text-right">' + products[j].shipped_qty + '&nbsp;&nbsp;</td>' +
                                        '</tr>';

                                    tableRowData = tableRowData + MainDatarow;

                                    productNameReminder = products[j].order_items.product_details.product_name;

                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem;">'+products[j].order_items.product_details.product_name+'</p>';
                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem; padding-bottom: 10px;">Size - '+products[j].size_name+' | Ordered Qty - '+fullOrderQty+' | Shipped Qty - '+products[j].shipped_qty+'</p>';

                                }else{

                                    var tableDatarow = '<tr style="color: black; font-size: 14px; height: 45px; background-color: #fcfcfc; border-bottom: 1px solid #e4e4e4;">' +
                                            '<td>&nbsp;</td>' +
                                            '<td class="text-center">' + products[j].size_name + '</td>' +
                                            '<td class="text-right">' + fullOrderQty + '&nbsp;&nbsp;</td>' +
                                            '<td class="text-right">' + products[j].shipped_qty + '&nbsp;&nbsp;</td>' +
                                            '</tr>';


                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem;">'+products[j].order_items.product_details.product_name+'</p>';
                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem; padding-bottom: 10px;">Size - '+products[j].size_name+' | Ordered Qty - '+fullOrderQty+' | Shipped Qty - '+products[j].shipped_qty+'</p>';

                                tableRowData = tableRowData + tableDatarow;

                                }
                            }
                            var TotalCountRow = '<tr style="height: 45px; color: black; font-size: 14px; font-weight: 700; background-color: #e2e2e2;">' +
                                                '<td class="text-right">TOTAL</td>' +
                                                '<td></td>' +
                                                '<td class="text-right">' + totalCountTotal + '&nbsp;&nbsp;</td>' +
                                                '<td class="text-right">' + totalCountShipped + '&nbsp;&nbsp;</td>' +
                                                '</tr>';

                            shippingItemContent =tableStart + Headingrow + tableRowData + TotalCountRow + tableEnd;

                        }


                        shippingItems = shippingItemContent;
                        break;

                    }
                }

                var emailBody = '<div class="row">' +
                    '<div id="invoice_body" style="padding: 3%; background-color: white; padding-top: 5%;">' +
                    '<div class="row mb-2">' +
                    '<div class="col-lg-12" style="color: black; margin-top: 2%; margin-bottom: 1%; margin-left: 3px;">' +

                    '<span style="font-size: 17px">Hi '+contactPerson+',</span>' +
                    '</div>' +
                    '<div class="col-lg-12" style="margin-left: 3px;">' +
                    '<span style="color: black; font-size: 17px;">' +
                    'We sincerely apologize for any confusion caused by our previous email. <br> Please disregard the previous message.<br>'+
                    'We are pleased to announce that your order for <b>'+organizationName+'</b> is now on its way to you from our factory. <br>Thank you for choosing us, and we appreciate your patience.<br>' +

                    'Please let us know how your items are once you receive them.' +
                    '</span>' +
                    '</div>' +
                    '</div>' +

                    detailUI +
                    shippingItems+
                    '<div class="row mb-2 mt-4" id="tempory_footer" style="color:black;margin: .3%;margin-top:2%"><p style="text-align: left; max-width: 600px; margin: 0rem;">' +

                    'Thank you for your order!<br><br>' +
                    'Encore Team<br><br>' +
                    '<img style="max-width: 250px;" src="https://encr.co/public/images/signature.png" /><br>' +
                    '</p></div>' +
                    '</div>' +
                    '</div>';


                $('#notification_body + .Editor-container .Editor-editor').html(emailBody);

            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    };
    function formatDateTime(dateStr) {
        if (!dateStr) return '';
        return new Intl.DateTimeFormat('en-US', {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        }).format(new Date(dateStr));
    }


    $('#shipment_summery').on('click', function(){
        $('#shipping_summery_modal').modal('show');
        var order_id = $('#notify_order_id').val();
        // var order_item_array = $('#order_item_array').val();

        $.ajax({
            url:'{{ url("order_details/shipping_summery") }}',
            type:"POST",
            dataType:'json',
            data: {
                'order_id':order_id, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                var orderItems = data.orderItems;
                var sub_products = data.sub_products;


                console.log(orderItems);

                // var trackingNoArr = [];
                // var trackingNoDetails = [];
                // for (let k = 0; k < orderItems.length; k++) {
                //     if (orderItems[k].tracking_no) {
                //         var trackingNo = orderItems[k].tracking_no;

                //         if (orderItems[k].est_delivery_date) {
                //             var estShippingDate = orderItems[k].est_delivery_date;
                //             var estDate = new Date(estShippingDate);
                //             var etaDate = estDate.getDate();
                //             var etaMonth =  estDate.getMonth()+1;
                //             var etaYear = estDate.getFullYear().toString().substring(2);

                //             var etaShippingDate = etaMonth + '/' + + etaDate + '/' + etaYear;
                //         } else {
                //             var etaShippingDate = 'unavailable';
                //         }

                //         if(trackingNoArr.indexOf(trackingNo) === -1) {
                //             if (orderItems[k].tracking_link) {
                //                 var trackingLink = orderItems[k].tracking_link;
                //             } else {
                //                 var trackingLink = '#';
                //             }

                //             trackingNoArr.push(trackingNo);

                //             trackingNoDetails.push({
                //                 trackingNo: trackingNo,
                //                 trackingLink: trackingLink,
                //                 etaShippingDate: etaShippingDate
                //             });
                //         }
                //     }
                // }

                // if (trackingNoDetails) {
                //     var shippingItems = [];
                //     for (let j = 0; j < trackingNoDetails.length; j++) {

                //         var row = [];
                //         var productName = '';
                //         var sizeName = '';
                //         var orderQty = 0;
                //         var shippedQty = 0;

                //         var shippedItems = orderItems.filter(function (item) {
                //             return item.tracking_no == trackingNoDetails[j].trackingNo;
                //         });

                //         for (let i = 0; i < shippedItems.length; i++) {
                //             if (shippedItems[i].tracking_no == trackingNoDetails[j].trackingNo) {
                //                 if(i == 0){
                //                     sizeName = shippedItems[i].size_name;
                //                     productName = shippedItems[i].order_items.product_details.product_name;
                //                 }

                //                 if(sizeName == shippedItems[i].size_name && productName == shippedItems[i].order_items.product_details.product_name){
                //                     orderQty += parseInt(shippedItems[i].order_qty);
                //                     shippedQty += parseInt(shippedItems[i].shipped_qty);
                //                 } else {
                //                     row += '<p style="text-align: left; max-width: 600px; margin: 0rem;">'+productName+'</p>';
                //                     row += '<p style="text-align: left; max-width: 600px; margin: 0rem; padding-bottom: 10px;">Size - '+sizeName+' | Ordered Qty - '+orderQty+' | Shipped Qty - '+shippedQty+'</p>';

                //                     sizeName = shippedItems[i].size_name;
                //                     productName = shippedItems[i].order_items.product_details.product_name;

                //                     if(shippedItems[i].order_qty) {
                //                         orderQty = parseInt(shippedItems[i].order_qty);
                //                     } else {
                //                         orderQty = 0;
                //                     }

                //                     if(shippedItems[i].shipped_qty) {
                //                         shippedQty = parseInt(shippedItems[i].shipped_qty);
                //                     } else {
                //                         shippedQty = 0;
                //                     }

                //                 }

                //                 if(i == shippedItems.length-1){
                //                     row += '<p style="text-align: left; max-width: 600px; margin: 0rem;">'+productName+'</p>';
                //                     row += '<p style="text-align: left; max-width: 600px; margin: 0rem; padding-bottom: 10px;">Size - '+sizeName+' | Ordered Qty - '+orderQty+' | Shipped Qty - '+shippedQty+'</p>';
                //                 }

                //             }
                //         }

                //         if (trackingNoDetails[j].etaShippingDate == 'unavailable') {
                //             var eta = '';
                //         } else {
                //             var eta = '<p style="text-align: left; max-width: 600px; margin: 0rem;"> ETA '+trackingNoDetails[j].etaShippingDate+'</p>';
                //         }

                //         var trackingLink = '<p style="text-align: left; max-width: 600px; margin: 0rem;">Tracking Link - <a target="_blank" href="'+trackingNoDetails[j].trackingLink+'">Click Here</a></p>';
                //         var trackingNo = '<p style="text-align: left; max-width: 600px; margin: 0rem;">Tracking #: <a target="_blank" href="'+trackingNoDetails[j].trackingLink+'">'+trackingNoDetails[j].trackingNo+'</a></p>';
                //         // var shippingItemsTitle = '<p style="text-align: left; max-width: 600px; margin: 0rem;"><b>Items in this shipment: </b></p>';

                //         // shippingItems += trackingLink + trackingNo + eta + shippingItemsTitle + row + '<br>';
                //         shippingItems += trackingLink + trackingNo + eta + row + '<br>';
                //     }
                // }

                // <div class="row">
                //             <i class="fa fa-ship" aria-hidden="true" style="background-color: lightseagreen;border-radius: 50%;padding: 1%;color:white"></i><span style="color: black;font-size: 20px;font-weight: 600;">&nbsp;Shipment 1</span>
                //         </div>
                //         <div class="row mt-2">
                //             <table>
                //                 <tr style="height: 35px;">
                //                     <td style="color: grey;font-size: 15px;"> Tracking Link</td>
                //                     <td style="font-size: 15px;color: lightseagreen;cursor:pointer" onclick="clickhereFunc()">CLICK HERE</td>
                //                 </tr>
                //                 <tr style="height: 35px;">
                //                     <td style="color: grey;font-size: 15px;">Tracking ID</td>
                //                     <td style="color: black;font-size: 15px;">Test 1 - 123456</td>
                //                 </tr>
                //                 <tr style="height: 35px;">
                //                     <td style="color: grey;font-size: 15px;">EST. Shipping Date&nbsp;&nbsp;</td>
                //                     <td style="color: black;font-size: 15px;">11 Aug 2023</td>
                //                 </tr>
                //             </table>
                //         </div>
                //         <div class="row">
                //             <span style="margin-top: 3%;color: black;font-size: 15px;font-weight: 700;">ITEM LIST</span>
                //         </div>
                //         <div class="row">

                //             <table style="width: 100%;margin-top: 2%;">
                //                 <thead class="table-bordered" style="background-color: grey;color: white;font-size: 14px;height: 45px;">
                //                     <th>&nbsp;&nbsp;ITEM</th>
                //                     <th>&nbsp;&nbsp;SIZE</th>
                //                     <th class="text-right">ORDERED QTY&nbsp;&nbsp;</th>
                //                     <th class="text-right">SHIPPED QTY&nbsp;&nbsp;</th>
                //                 </thead>

                //                     <tr style="height: 45px;background-color: #c7c7c7;color: black;font-size: 14px">
                //                         <td>&nbsp;&nbsp;Men's Pro Lacrosse Shooter Shirt</td>
                //                         <td class="text-center">Adult Medium</td>
                //                         <td class="text-right">10&nbsp;&nbsp;</td>
                //                         <td class="text-right">10&nbsp;&nbsp;</td>
                //                     </tr>

                //                     <tr style="color: black;font-size: 14px;height: 45px;background-color: #fcfcfc;    border-bottom: 1px solid #e4e4e4;">
                //                         <td></td>
                //                         <td class="text-center">Adult Large</td>
                //                         <td class="text-right">5&nbsp;&nbsp;</td>
                //                         <td class="text-right">5&nbsp;&nbsp;</td>
                //                     </tr>
                //                     <tr style="color: black;font-size: 14px;height: 45px;background-color: #fcfcfc;    border-bottom: 1px solid #e4e4e4;">
                //                         <td></td>
                //                         <td class="text-center">Adult Large</td>
                //                         <td class="text-right">5&nbsp;&nbsp;</td>
                //                         <td class="text-right">5&nbsp;&nbsp;</td>
                //                     </tr>
                //                     <tr style="color: black;font-size: 14px;height: 45px;background-color: #fcfcfc;    border-bottom: 1px solid #e4e4e4;">
                //                         <td></td>
                //                         <td>&nbsp;&nbsp;Adult Large</td>
                //                         <td class="text-right">5&nbsp;&nbsp;</td>
                //                         <td class="text-right">5&nbsp;&nbsp;</td>
                //                     </tr>
                //                     <tr style="height: 45px;color: black;font-size: 14px;font-weight: 700;background-color: #e2e2e2;">
                //                         <td class="text-right">TOTAL</td>
                //                         <td></td>
                //                         <td class="text-right">15&nbsp;&nbsp;</td>
                //                         <td class="text-right">15&nbsp;&nbsp;</td>
                //                     </tr>
                //         </table>
                //     </div>

                if (orderItems) {
                    var shippingItems = '';
                    for (var i = 0; i < orderItems.length; i++) {

                        //new UI

                        var receivedRow = '';

                        if (orderItems[i].customer_received) {
                            receivedRow =
                                '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;">Status</td>' +
                                    '<td>' +
                                        '<span style="background-color: #e6f7f1; color: #198754; ' +
                                        'padding: 5px 10px; border-radius: 20px; font-size: 13px; font-weight: 600;">' +
                                        '✔ Received on ' + formatDateTime(orderItems[i].customer_received) +
                                        '</span>' +
                                    '</td>' +
                                '</tr>';
                        }

                        var detailUI = '<div class="row" style="margin: .4%;">' +
                                    '<i class="fa fa-ship" aria-hidden="true" style="background-color: lightseagreen; border-radius: 50%; padding: 1%; color: white;"></i>' +
                                    '<span style="color: black; font-size: 20px; font-weight: 600;">&nbsp;Shipment '+ (i + 1) +'</span>' +
                                    '</div>' +
                                    '<div class="row mt-4" style="margin: .4%;">' +
                                    '<table>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;">Tracking ID</td>' +
                                    '<td style="color: black; font-size: 15px;">' + orderItems[i].tracking_no + '</td>' +
                                    '</tr>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;"> Tracking Link</td>' +
                                    '<td><a href="' + orderItems[i].tracking_link + '" style="font-size: 15px; color: lightseagreen !important; cursor: pointer;" target="_blank">CLICK HERE</a></td>' +

                                    '</tr>' +
                                    '<tr style="height: 35px;">' +
                                    '<td style="color: grey; font-size: 15px;">EST. Shipping Date&nbsp;&nbsp;</td>' +
                                    '<td style="color: black; font-size: 15px;">' + orderItems[i].display_est_delivery_date + '</td>' +
                                    '</tr>' +
                                    receivedRow +
                                    '</table>' +
                                    '</div>'+

                                    '<div class="row" style="margin: .4%;">'+

                                    '<span style="margin-top: 3%;color: black;font-size: 15px;font-weight: 700;">ITEM LIST</span>'+
                                    '</div>';


                        var shippingItemContent = '';

                        if (orderItems[i].products) {

                            var tableStart ='<div class="row" style="margin: .4%;"><table style="width: 100%;margin-top: 2%;">';

                            var tableEnd ='</table></div>';
                            var tableRowData = '';
                            var Headingrow = '<thead class="table-bordered" style="background-color: grey; color: white; font-size: 14px; height: 45px;">' +
                                            '<tr>' +
                                            '<th>&nbsp;&nbsp;ITEM</th>' +
                                            '<th>&nbsp;&nbsp;SIZE</th>' +
                                            '<th class="text-right">ORDERED QTY&nbsp;&nbsp;</th>' +
                                            '<th class="text-right">SHIPPED QTY&nbsp;&nbsp;</th>' +
                                            '</tr>' +
                                            '</thead>';
                            var products = orderItems[i].products;
                            var totalCountTotal = 0;
                            var totalCountShipped = 0;

                            products.sort(function(a, b) {
                                var productA = a.order_items.product_details.product_name.toUpperCase();
                                var productB = b.order_items.product_details.product_name.toUpperCase();
                                if (productA < productB) {
                                    return -1;
                                }
                                if (productA > productB) {
                                    return 1;
                                }
                                return 0;
                            });

                            var productNameReminder = null;

                            for (var j = 0; j < products.length; j++) {
                                var fullOrderQty = 0;

                                if(products[j].order_item_detail_qtys){
                                    if(products[j].order_item_detail_qtys.blanks){
                                        fullOrderQty += parseInt(products[j].order_item_detail_qtys.blanks);
                                    }
                                    if(products[j].order_item_detail_qtys.qty){
                                        fullOrderQty += parseInt(products[j].order_item_detail_qtys.qty);
                                    }
                                }

                                totalCountTotal += fullOrderQty;

                                totalCountShipped += parseInt(products[j].shipped_qty);


                                if(productNameReminder !== products[j].order_items.product_details.product_name){

                                    var foundSubProduct = sub_products.find(function(subProduct) {
                                        return subProduct.sub_product_no == products[j].order_items.sub_product_no;
                                    });

                                    var name_for_display = '';

                                    if (!products[j].order_items.display_name) {
                                        name_for_display = foundSubProduct.product_name;
                                    } else {
                                        name_for_display = products[j].order_items.display_name;
                                    }

                                    var MainDatarow = '<tr style="height: 45px; background-color: #c7c7c7; color: black; font-size: 14px; border-bottom: 1px solid #e4e4e4;">' +
                                        '<td>&nbsp;&nbsp;' + name_for_display + '</td>' +
                                        '<td class="text-center">' + products[j].size_name + '</td>' +
                                        '<td class="text-right">' + fullOrderQty + '&nbsp;&nbsp;</td>' +
                                        '<td class="text-right">' + products[j].shipped_qty + '&nbsp;&nbsp;</td>' +
                                        '</tr>';

                                    tableRowData = tableRowData + MainDatarow;

                                    productNameReminder = products[j].order_items.product_details.product_name;

                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem;">'+products[j].order_items.product_details.product_name+'</p>';
                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem; padding-bottom: 10px;">Size - '+products[j].size_name+' | Ordered Qty - '+fullOrderQty+' | Shipped Qty - '+products[j].shipped_qty+'</p>';

                                }else{

                                    var tableDatarow = '<tr style="color: black; font-size: 14px; height: 45px; background-color: #fcfcfc; border-bottom: 1px solid #e4e4e4;">' +
                                            '<td>&nbsp;</td>' +
                                            '<td class="text-center">' + products[j].size_name + '</td>' +
                                            '<td class="text-right">' + fullOrderQty + '&nbsp;&nbsp;</td>' +
                                            '<td class="text-right">' + products[j].shipped_qty + '&nbsp;&nbsp;</td>' +
                                            '</tr>';


                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem;">'+products[j].order_items.product_details.product_name+'</p>';
                                //row += '<p style="text-align: left; max-width: 600px; margin: 0rem; padding-bottom: 10px;">Size - '+products[j].size_name+' | Ordered Qty - '+fullOrderQty+' | Shipped Qty - '+products[j].shipped_qty+'</p>';

                                tableRowData = tableRowData + tableDatarow;

                                }
                            }
                            var TotalCountRow = '<tr style="height: 45px; color: black; font-size: 14px; font-weight: 700; background-color: #e2e2e2;">' +
                                                '<td class="text-right">TOTAL</td>' +
                                                '<td></td>' +
                                                '<td class="text-right">' + totalCountTotal + '&nbsp;&nbsp;</td>' +
                                                '<td class="text-right">' + totalCountShipped + '&nbsp;&nbsp;</td>' +
                                                '</tr>';

                            shippingItemContent =tableStart + Headingrow + tableRowData + TotalCountRow + tableEnd;

                        }


                        shippingItems += detailUI + shippingItemContent + '<div class="row mt-5 mb-3" style="width:104%; border-bottom:1px solid #dbdbdb"></div>';

                    }
                }

                $('#summery_body').html(shippingItems);
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    });

    $('.close').on('click', function() {
        $('.modal').modal('hide');
    });

    $('#showDrafts').on('click', function(){
        displayDraftNotification();
    });

    function displayDraftNotification(){
        var order_id = $('#notify_order_id').val();
        $.ajax({
            url: '{{ url("order_details/drafted_shipping_details") }}/'+order_id,
            type: "GET",
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                if (data != null) {
                    $('#shipping_notification').modal('show');
                    $("#to_email").html('');
                    if(data.send_to != null){
                        var sendToArray = JSON.parse(data.send_to);
                        for (let i = 0; i < sendToArray.length; i++) {
                            $("#to_email").append("<option value=" + sendToArray[i] + " selected>" + sendToArray[i] + "</option>");
                        }
                    }
                    if(data.copy_to != null){
                        var copyTo = JSON.parse(data.copy_to);
                        var copyToArray = copyTo.split(',');

                        var ccEmailArr = [];
                        for (let m = 0; m < copyToArray.length; m++) {
                            if (m == (copyToArray.length - 1)) {
                                ccEmailArr += copyToArray[m];
                            } else {
                                ccEmailArr += copyToArray[m]+', ';
                            }
                        }
                        $('#cc_email').val(ccEmailArr);
                        $('#cc_email').attr('data-cc_emails', copyToArray);
                    }

                    if(data.items != null){
                        var items = JSON.parse(data.items);
                        var itemArray = items.split(',');
                        $('#order_item_array').val(itemArray);
                    }

                    $("#subject_email").val(data.subject);
                    $('#notification_body + .Editor-container .Editor-editor').html(data.message);
                } else {
                    Swal.fire(
                        'Error!',
                        'Please select an item!',
                        'warning'
                    );
                }
            },
            complete: function () {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }

    $("#sendNotification").click(function(){

        update_resent();

        var orderID = $("#notify_order_id").val();
        var notifyBody = $('#notification_body + .Editor-container .Editor-editor').html();
        var cc_emails = $('#cc_email').data('cc_emails');
        var to_emails = $('#to_email').val();
        var subject_email = $('#subject_email').val();
        var order_item_array = $('#order_item_array').val();

        $.ajax({
            url: "{{ url('order/shippingnotification')}}",
            type: "post",
            data:{ 'orderID': orderID, 'notifyBody': notifyBody, 'to_emails': to_emails, 'cc_emails': cc_emails, 'subject_email':subject_email, 'order_item_array':order_item_array,  "_token": "{{ csrf_token() }}" },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {
                if(response == "Mail Sent Successfully") {
                    Swal.fire({
                        title: "Done!",
                        text: "Shipping Notification Email Sent Successfully!",
                        type: "success",
                        buttons: true,
                        dangerMode: true,
                        showCancelButton: false,
                        confirmButtonColor: '#2dce89',
                        closeOnConfirm: false,
                        allowOutsideClick: false

                    }).then(function(isConfirm) {
                        window.location.reload(true);
                    });

                } else {
                    Swal.fire(
                        'Error!',
                        'Something Went Wrong!',
                        'warning'
                    )
                }
            },
            complete: function () {
                $('#shipping_notification').modal('hide');
                $('#notification_body + .Editor-container .Editor-editor').html('');
                $(".se-pre-con").fadeOut('slow');
            }
        });
    });

    $("#saveToDraft").click(function(){
        var orderID = $("#notify_order_id").val();
        var notifyBody = $('#notification_body + .Editor-container .Editor-editor').html();
        var cc_emails = $('#cc_email').data('cc_emails');
        var to_emails = $('#to_email').val();
        var subject_email = $('#subject_email').val();
        var order_item_array = $('#order_item_array').val();

        $.ajax({
            url: "{{ url('order/shippingnotification_saveDraft')}}",
            type: "post",
            data:{ 'orderID': orderID, 'notifyBody': notifyBody, 'to_emails': to_emails, 'cc_emails': cc_emails, 'subject_email':subject_email, 'order_item_array':order_item_array,  "_token": "{{ csrf_token() }}" },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {
                if(response == "Mail Drafted Successfully") {
                    Swal.fire({
                        title: "Done!",
                        text: "Shipping Notification Email Saved To Draft Successfully!",
                        type: "success",
                        buttons: true,
                        dangerMode: true,
                        showCancelButton: false,
                        confirmButtonColor: '#2dce89',
                        closeOnConfirm: false,
                        allowOutsideClick: false

                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Something Went Wrong!',
                        'warning'
                    )
                }
            },
            complete: function () {
                $('#shipping_notification').modal('hide');
                $('#notification_body + .Editor-container .Editor-editor').html('');
                $('#showDrafts').show(500);
                $(".se-pre-con").fadeOut('slow');
            }
        });
    });

    // function addTrackingNo(itemNo) {
    //     var itemVal = $(itemNo).val();
    //     $('.chkItem:checkbox:checked').each(function () {
    //         var itemNo = $(this).attr("data-itemNumber");
    //        document.getElementById("txtTrackNo"+itemNo).value = itemVal;
    //     });
    // }

    // function addTrackingLink(itemNo) {
    //     var itemVal = $(itemNo).val();
    //     $('.chkItem:checkbox:checked').each(function () {
    //         var itemNo = $(this).attr("data-itemNumber");
    //        document.getElementById("txtTrackLink"+itemNo).value = itemVal;
    //     });
    // }
    $("#updateShippingOrder").click(function(){
        $('#shipping_frm').submit();
    });


    // $("#updateShippingOrder").click(function(){
    $("#shipping_frm").on('submit',function(e){
        e.preventDefault();
        updateShippingOrderDetail([]);
    });


    function updateShippingOrderDetail(shipDetailIdArr, saveType = 'save'){

        var formData = $("#shipping_frm").serializeArray();
        var orderID = $("#notify_order_id").val();

        var shipDetailIds = JSON.stringify(shipDetailIdArr);
        console.log(shipDetailIds);

        // add checked items to formData
        formData.push({'name':'selected_ship_ids', 'value':shipDetailIds});
        formData.push({'name':'save_type', 'value':saveType});

        $.ajax({
            url: "{{ url('order/shippingupdate')}}",
            type: "post",
            dataType:'json',
            data: formData,
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {
                console.log(response);
                $(".se-pre-con").fadeOut('slow');
                if(response[1] == "Shipping Details Updated") {
                    // Swal.fire(
                    //     'Done!',
                    //     'Shipping Details Updated!',
                    //     'success'
                    // )
                } else {
                    Swal.fire(
                        'Error!',
                        'Something Went Wrong!',
                        'warning'
                    )
                }

                if(response[0] == 'yes'){
                    $(".se-pre-con").fadeIn();
                    location.reload();
                }
            },
            complete: function () {
                shippingInputFilled = [];
            }
        });
    }

    $("#updateShippingOrderToNotify").click(function(){
        var checkBoxes = $('.chkItemChild:checkbox:checked');

        // get checked items
        var shipDetailIdArr = [];
        if(checkBoxes.length > 0){
            checkBoxes.each(function() {
                shipDetailIdArr.push($(this).val());
            });
        }

        var orderItemArr = [];
        // var orderNoShipItemArr = [];
        // var orderNoTrackinNoArr = [];
        // var orderNoTrackinLinkArr = [];

        $.each(checkBoxes, function(index, value){

        var tr_next = $(this).closest('tr');
            var orderItem = $(this).val();
            orderItemArr.push(orderItem);
            // if ($(this).closest('tr').find('.shipping-qty').val() == '' || $(this).closest('tr').find('.shipping-qty').val() == 0) {
            //     orderNoShipItemArr.push($(this));
            // }
            // if ($(this).closest('tr').find('.txtTrackingNo').val() == '') {
            //     orderNoTrackinNoArr.push($(this));
            // }
            // if ($(this).closest('tr').find('.txtTrackingLink').val() == '') {
            //     orderNoTrackinLinkArr.push($(this));
            // }

        });

        if (orderItemArr.length === 0) {
            Swal.fire(
                'Error!',
                'Please select an item!',
                'warning'
            )
        } else {
            // if(orderNoShipItemArr.length > 0){
            //     Swal.fire(
            //         'Error!',
            //         'Please Enter Shipped Quantity!',
            //         'warning'
            //     );
            //     for(i=0; i < orderNoShipItemArr.length; i++){
            //         orderNoShipItemArr[i].closest('tr').find('.shipping-qty').addClass('empty-notice');
            //     };
            // }
            // else if(orderNoTrackinNoArr.length > 0){
            //     Swal.fire(
            //         'Error!',
            //         'Please Enter Tracking Number!',
            //         'warning'
            //     );
            //     for(i=0; i < orderNoTrackinNoArr.length; i++){
            //         orderNoTrackinNoArr[i].closest('tr').find('.txtTrackingNo').addClass('empty-notice');
            //     };
            // }
            // else if(orderNoTrackinLinkArr.length > 0){
            //     Swal.fire(
            //         'Error!',
            //         'Please Enter Tracking Link!',
            //         'warning'
            //     );
            //     for(i=0; i < orderNoTrackinLinkArr.length; i++){
            //         orderNoTrackinLinkArr[i].closest('tr').find('.txtTrackingLink').addClass('empty-notice');
            //     };
            // }
            // else {
                updateShippingOrderDetail(shipDetailIdArr, 'notify_save');
            // }
        }

    });

    $('#change_cc').on('click', function(){
        $('#usergroup_members_modal').modal('show');
    });

    $('body').on('click', function(){
        var dropOn = $('body ul.dropdown-menu.on');
        if(dropOn.length > 0){
            dropOn.removeClass('on');
        }
    });

//     #notify_status_select.select2 {
//     /* Remove styles applied by the select2 class */
//     all: initial;
//   }



  </script>

  <script>
    //remake order scripts Developer - Heshan Namal

    function addToRemake(shipping_order_details_id){
        console.log(shipping_order_details_id);
        Swal.fire({
        title: "Are you sure?",
        text: "This item will be added to remake list!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
        }).then((result) => {

            if (result.value) {

                $.ajax({
                    url: "{{ url('order/add_to_remake_list')}}",
                    type: "post",
                    data:{ 'shipping_order_details_id': shipping_order_details_id,  "_token": "{{ csrf_token() }}" },
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (response) {
                        console.log(response);
                        if(response) {
                            var element = document.getElementById('remake_item_'+shipping_order_details_id);

                            // Check if the element with the given ID was found
                            if (element) {
                                // Update the inner text of the element
                                element.innerText = 'RE-MAKE';
                                element.style.backgroundColor = '#b536f5';
                            } else {
                                console.error("No element found with the ID: " + elementId);
                            }
                            Swal.fire({
                                title: "Done!",
                                text: "Order item added to remake list Successfully!",
                                type: "success",
                                buttons: true,
                                dangerMode: true,
                                showCancelButton: false,
                                confirmButtonColor: '#2dce89',
                                closeOnConfirm: false,
                                allowOutsideClick: false

                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something Went Wrong1! shipping order details not updated yet',
                                'warning'
                            )
                        }
                    },
                    complete: function () {

                        $(".se-pre-con").fadeOut('slow');
                        Cal_remake_list();

                    }
                });
            }
        });

    }
    $(document).ready(function () {
        $('.remake_item_modal_btn').click(function(){
            var order_id = $('#notify_order_id').val();
            $.ajax({
                url: '{{ url("order/view_remake_list") }}/'+order_id,
                type: "GET",
                dataType: 'json',
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(data) {
                    console.log(data);
                    var tableHTML = '<table class="table table-responsive remakelisttable"><thead><tr><th class="text-center">#</th><th>Item Name</th><th>Player Number</th><th>Size</th><th>Qty</th><th class="text-center" style="width: 100%;">Reason</th><th class="text-right remake_datepicker">Est Delivery Date</th><th class="text-right remake_datepicker">Ex Factory Date</th><th class="text-right">Actions</th></tr></thead><tbody>';

                        for (var i = 0; i < data.length; i++) {
                            var status = data[i]['status'];
                            console.log(status);
                            var opacityStyle = (status == 0) ? 'opacity: 0.5;' : '';
                            var disabledAttribute = (status == 0) ? 'disabled' : '';
                            tableHTML += '<tr id="'+data[i]['id']+'" style="'+opacityStyle+'"">';
                            tableHTML += '<td class="text-center">'+(i+1)+'</td>';
                            tableHTML += '<td>'+data[i]['product_name']+'</td>';
                            tableHTML += '<td>' + (data[i]['player_nunmber'] !== null ? data[i]['player_nunmber'] : 'no') + '</td>';
                            tableHTML += '<td>'+data[i]['size_name']+'</td>';
                            tableHTML += '<td class="text-center"><input '+disabledAttribute+' class="form-control" style="width:35px" onchange="updateRemakeorderQty(this)" type="number" value="'+data[i]['qty']+'"></td>';
                            tableHTML += '<td class="text-right"><select '+disabledAttribute+' class="form-control select2_remake" onchange="updateRemakeorderReason(this)">';

                            // Conditionally add the selected option
                            if (data[i]['reason'] !== null) {
                                tableHTML += '<option selected="selected">'+data[i]['reason']+'</option>';
                            }

                            tableHTML += '</select></td>';
                            tableHTML += '<td class="text-right"><input '+disabledAttribute+' class="form-control datepicker estDelivarydate datepickerremake" onchange="updateRemakeorderDate(this)" id="datepicker_'+data[i]['id']+'" placeholder="Select date" type="text" value="'+data[i]['est_delivery_date']+'"></td>';
                            tableHTML += '<td class="text-right"><input '+disabledAttribute+' class="form-control exFactoryDate datepicker datepickerremake" onchange="updateExFactoryDate(this)" id="exFactoryDate_'+data[i]['id']+'" placeholder="Select date" type="text" value="'+data[i]['ex_factory_date']+'"></td>';
                            tableHTML += '<td class="td-actions text-right"><button '+disabledAttribute+' type="button" class="btn btn-danger btn-icon btn-sm btn-simple" onclick="remove_remake_item(this)"><i class="ni ni-fat-remove pt-1"></i></button></td>';
                            tableHTML += '</tr>';
                        }

                tableHTML += '</tbody></table>';
                $("#remake_item_modal .modal-body").html(tableHTML);
                $(document).ready(function () {
                    $(".select2_remake").select2({
                    tags: true,
                    dropdownParent: $('#remake_item_modal'),
                });

                    // Example array of options to add
                    var optionsArray = [
                        { id: 'Size need to be change', text: 'Size need to be change' },
                        { id: 'Item damaged', text: 'Item damaged' },
                        { id: 'item not sent', text: 'item not sent' },
                        { id: 'Color change required', text: 'Color change required' },
                        { id: 'Incorrect fabric', text: 'Incorrect fabric' },
                    ];

                    // Function to add options to Select2
                    function addOptionsToSelect2(optionsArray) {
                        // Loop through the array and add each option
                        for (var i = 0; i < optionsArray.length; i++) {
                            var option = optionsArray[i];
                            var newOption = new Option(option.text, option.id, false, false);
                            $('.select2_remake').append(newOption).trigger('change');
                        }
                    }

                    // Add options to Select2
                    addOptionsToSelect2(optionsArray);
                    $(function() {
                        $( ".datepickerremake" ).datepicker({
                            format: 'yyyy-mm-dd', // Format to match MySQL date format
                            autoclose: true
                        });
                    });
                });
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                    $('#remake_item_modal').modal('show');
                }
            });

        });

    });

    function Cal_remake_list(){
        var orderID = $("#notify_order_id").val();
        console.log(orderID);
        $.ajax({
            url: '{{ url("order/count_remake_items")}}/'+orderID,
            type: "GET",
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (data) {
                console.log(data);
                $('.remakecount').text(data);
            },
            complete: function () {

                $(".se-pre-con").fadeOut('slow');
            }
        });
}



</script>
<script>
    // Initialize Select2


    function updateRemakeorderQty(input) {
        var trId = $(input).closest('tr').attr('id');
        var qty = parseFloat(input.value);
        console.log("trId:", trId);
        $.ajax({
            url: "{{ url('order/remake/update/order_qty')}}",
            type: "post",
            data:{  'id': trId,
                    'qty' : qty,
                    "_token": "{{ csrf_token() }}" },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {

            },
            complete: function () {

                $(".se-pre-con").fadeOut('slow');


            }
        });
    }
    function updateRemakeorderDate(input) {
        var trId = $(input).closest('tr').attr('id');
        var date = $.datepicker.formatDate('yy-mm-dd', $.datepicker.parseDate('mm/dd/yy', input.value));
        $.ajax({
            url: "{{ url('order/remake/update/order_est_delivery_date')}}",
            type: "post",
            data:{  'id': trId,
                    'est_delivery_date' : date,
                    "_token": "{{ csrf_token() }}" },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {

            },
            complete: function () {

                $(".se-pre-con").fadeOut('slow');


            }
        });
    }
    function updateExFactoryDate(input) {
        var trId = $(input).closest('tr').attr('id');
        var date = $.datepicker.formatDate('yy-mm-dd', $.datepicker.parseDate('mm/dd/yy', input.value));
        $.ajax({
            url: "{{ url('order/remake/update/order_ex_factory_date')}}",
            type: "post",
            data:{  'id': trId,
                    'ex_factory_date' : date,
                    "_token": "{{ csrf_token() }}" },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {

            },
            complete: function () {

                $(".se-pre-con").fadeOut('slow');


            }
        });
    }
    function updateRemakeorderReason(input) {
        var trId = $(input).closest('tr').attr('id');
        var reason = input.value;
        $.ajax({
            url: "{{ url('order/remake/update/order_reason')}}",
            type: "post",
            data:{  'id': trId,
                    'reason' : reason,
                    "_token": "{{ csrf_token() }}" },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {

            },
            complete: function () {

                $(".se-pre-con").fadeOut('slow');


            }
        });
    }
    function remove_remake_item(input) {
        var trId = $(input).closest('tr').attr('id');
        Swal.fire({
        title: "Are you sure?",
        text: "This item will be remove from remake list !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
        }).then((result) => {
            console.log(result.value);
            if (result.value) {
                $.ajax({
                    url: '{{ url("order/remove_remake_items")}}/'+trId,
                    type: "GET",
                    dataType: 'json',
                    beforeSend: function () {
                        $(".se-pre-con").fadeIn('slow');
                    },
                    success: function (data) {
                       if(data){
                            Swal.fire({
                                title: "Done!",
                                text: "Remake item removed Successfully!",
                                type: "success",
                                buttons: true,
                                dangerMode: true,
                                showCancelButton: false,
                                confirmButtonColor: '#2dce89',
                                closeOnConfirm: false,
                                allowOutsideClick: false

                            });
                       }

                    },
                    complete: function () {

                        $(".se-pre-con").fadeOut('slow');
                        $('.remake_item_modal_btn').click();
                    }
                });

            }
        });
    }
    function remake_items() {
        var orderID = $("#notify_order_id").val();
        var allDatesSet = true; // Flag to track if all dates are set

        $('.remakelisttable tbody tr').each(function() {
            var exFactoryDateInput = $(this).find('.exFactoryDate'); // Find the ex_factory_date input field in the current row
            var estDeliveryDateInput = $(this).find('.estDelivarydate'); // Find the est_delivery_date input field in the current row

            if (exFactoryDateInput.length > 0 && estDeliveryDateInput.length > 0) { // Check if both fields exist in the row
                var exFactoryDateValue = exFactoryDateInput.val(); // Get the value of ex_factory_date input field
                var estDeliveryDateValue = estDeliveryDateInput.val(); // Get the value of est_delivery_date input field

                if (exFactoryDateValue === "" || estDeliveryDateValue === "") {
                    // If either ex_factory_date or est_delivery_date is not set for this row
                    allDatesSet = false; // Set the flag to false
                    console.log("Ex-factory date or estimated delivery date is not set for a row.");
                    // Optionally, you can show an alert or highlight the row to notify the user
                }
            }
        });

        // Proceed with the AJAX request only if all dates are set
        if (allDatesSet) {
            $.ajax({
                url: "{{ url('order/remake_items')}}",
                type: "post",
                data:{  'order_id': orderID,
                        "_token": "{{ csrf_token() }}" },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (response) {
                    console.log(response);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                    // Reload the current page
                    window.location.reload();
                }
            });
        } else {
            // If any date is not set, display an alert or take appropriate action
            alert("Please ensure both ex-factory date and estimated delivery date are set for all rows.");
        }
    }

</script>

@if(auth()->user()->hasRole(['PBS Factory', 'DWC Factory', 'BII Factory', 'UET Factory', 'ZYS Factory', 'Test Factory']) && !request()->get('flt') == 'all')
    <script>
        $(document).ready(function() {
            $('#shipment_status').val('Data Pending').trigger('change');
            // showDataPending();
        });
    </script>
@elseif(auth()->user()->hasRole(['Sales']) && !request()->get('flt') == 'all')
    <script>
        $(document).ready(function() {
            // $('#shipment_status').val('Data Added').trigger('change');
            // showDataAdded();
        });
    </script>
@endif
