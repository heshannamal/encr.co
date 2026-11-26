@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Pdf')])

@section('content')

<style>
    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
        background-color: transparent !important;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .bargraph_header {
        color: black;
        font-size: 17px;
    }
    .color_div {
        border: 1px solid rgb(189, 189, 189);
        margin-right: 15px;
        border-radius: 3px;
        margin-left: 10px;
        height: 17px;
        margin-top: 10px;
    }
    .row_padding {
        padding-bottom: 10px !important;
        padding-top: 10px !important;
    }
    .nav-item.active > .nav-link {
        border-left: unset !important;
    }
    .print_btn {
        padding-right: 3%;
        padding-left: 1%;
    }
    .top_button {
        font-size: 12px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .search_class {
        padding: 2px;
        border: unset;
        border-bottom: 2px solid rgb(212, 212, 212);
        margin-right: 30px;
        font-size: 14px;
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
    .nav-tabs {
        border-bottom: unset;
    }
    .today_color {
        background-color: rgba(25, 219, 125, 0.72);
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-top: 2px;
    }
    .past_color {
        background-color: rgba(255, 0, 0, 0.82);
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-top: 2px;
        margin-left: 25px;
    }
    .thisWeek_color {
        background-color: rgba(255, 117, 17, 0.76);
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-top: 2px;
        margin-left: 25px;
    }
    .fulfilled_color {
        background-color: rgb(205, 205, 205);
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-top: 2px;
        margin-left: 25px;
    }
    .cancel_color {
        background-color: rgba(255, 0, 0, 0.4);
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-top: 2px;
        margin-left: 25px;
    }
    .production_text {
        padding-left: 10px;
        color: rgb(94, 94, 94);
    }
    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid#DEDEDE;
        border-radius: 5px;
        padding-top: 2px;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: #B3B3B3;
        font-weight: 500;
    }
    .date_p:hover {
        color: #B3B3B3 !important;
    }
    .filter_btn {
        padding: 4px;
        text-align: center;
        width: 70px;
        padding-right: 6px;
        background-color: rgb(0, 254, 0);
        border-radius: 5px;
        cursor: pointer;
        color: white !important;
    }

/* Mobile View CSS*/
@media (max-width: 767.98px) {

    /* Prevents horizontal scrolling on the whole page in mobile view. */
    html, body {
        overflow-x: hidden !important;
    }

    /* ── Top Header ── */

    /* Makes the top header compact and removes its desktop background, shadow and border. */
    .bg-box.container-fluid.fix-nav.header-layout {
        height: auto !important;
        padding: 10px 15px !important;
        margin-bottom: 15px !important;
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* Stacks the "back" link and page title vertically instead of absolute positioning. */
    .div_nav_top {
        position: static !important;
        display: flex !important;
        flex-direction: column !important;
        padding: 0 !important;
    }

    /* Shows the back button wrapper above the title with a small gap. */
    .back-home-btn {
        display: block !important;
        margin-bottom: 4px !important;
    }

    /* Styles the "BACK TO HOME" link as small grey text. */
    .home-btn-color {
        font-size: 11px !important;
        color: #64748b !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
    }

    /* Adds a small left-chevron icon before the back link text. */
    .home-btn-color::before {
        content: "\f053" !important;
        font-family: "Font Awesome 5 Free", "FontAwesome" !important;
        font-weight: 900 !important;
        font-size: 9px !important;
        margin-right: 6px !important;
    }

    /* Makes sure the title wrapper is visible on mobile. */
    .header1 {
        display: block !important;
    }

    /* Styles the page title ("Encore Order Schedule") as bold dark text. */
    .header1 #header {
        font-size: 20px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        font-family: inherit !important;
        line-height: 1.2 !important;
    }

    /* ── Main Container ── */

    /* Sets side padding and transparent background for the main content area. */
    .content-position {
        padding-left: 14px !important;
        padding-right: 14px !important;
        background-color: transparent !important;
        margin-bottom: 20px !important;
    }

    /* Removes the default column padding so cards sit flush inside the container. */
    .content-position > .col-md-12 {
        padding: 0 !important;
    }

    /* ── Row 1: Year Select & Status Legends Card ── */

    /* Turns the first row (year + legends) into a white rounded card with stacked content. */
    .content-position .col-md-12 > .row:nth-of-type(1) {
        margin: 0 0 15px 0 !important;
        padding: 14px !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 16px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 12px !important;
    }

    /* Makes the year select column take the full card width. */
    .content-position .col-md-12 > .row:nth-of-type(1) > .col-md-2 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Styles the year dropdown as a full-width rounded input. */
    #yearSelect {
        width: 100% !important;
        height: 42px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        background-color: #ffffff !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #1e293b !important;
        padding: 0 12px !important;
        box-sizing: border-box !important;
        outline: none !important;
    }

    /* Makes the legend wrapper full width and removes its auto left margin. */
    .content-position .col-md-12 > .row:nth-of-type(1) .ml-auto {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Lays out the status legends in a wrapping row inside a light grey box. */
    .content-position .col-md-12 > .row:nth-of-type(1) .ml-auto > .row {
        margin: 0 !important;
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        gap: 8px 12px !important;
        padding: 10px 12px !important;
        background: #f8fafc !important;
        border-radius: 10px !important;
        border: 1px solid #f1f5f9 !important;
    }

    /* Styles each legend label as small grey text. */
    .production_text {
        font-size: 11px !important;
        font-weight: 500 !important;
        color: #475569 !important;
        padding-left: 4px !important;
        margin: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
    }

    /* Makes all legend color boxes small rounded squares with no margins. */
    .today_color, .past_color, .thisWeek_color, .fulfilled_color, .cancel_color {
        width: 10px !important;
        height: 10px !important;
        border-radius: 3px !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
        display: inline-block !important;
    }

    /* Sets the legend color for today's orders (green). */
    .today_color { background-color: #10b981 !important; }
    /* Sets the legend color for orders past the ex-factory date (red). */
    .past_color { background-color: #ef4444 !important; }
    /* Sets the legend color for this week's shipments (blue). */
    .thisWeek_color { background-color: #0ea5e9 !important; }
    /* Sets the legend color for fulfilled orders (grey). */
    .fulfilled_color { background-color: #94a3b8 !important; }
    /* Sets the legend color for canceled orders (amber). */
    .cancel_color { background-color: #f59e0b !important; }

    /* ── Row 2: Filters Card ── */

    /* Turns the filter row into a white rounded card with a 2-column grid. */
    .content-position .col-md-12 > .row:nth-of-type(2) {
        margin: 0 0 15px 0 !important;
        padding: 14px !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 16px !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 10px !important;
    }

    /* Styles each filter (Factory, Status, Test Print, Rep) as a small grey box filling its grid cell. */
    .content-position .col-md-12 > .row:nth-of-type(2) .filter_row {
        margin: 0 !important;
        padding: 4px 8px !important;
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        height: 40px !important;
        display: flex !important;
        align-items: center !important;
        box-sizing: border-box !important;
        width: 100% !important;
    }

    /* Styles the filter label text (e.g. "Factory |") as small grey text on one line. */
    .content-position .col-md-12 > .row:nth-of-type(2) .filter_row p {
        font-size: 11px !important;
        color: #64748b !important;
        margin: 0 !important;
        white-space: nowrap !important;
    }

    /* Makes the filter dropdowns borderless, transparent and full width inside their box. */
    .content-position .col-md-12 > .row:nth-of-type(2) .filter_row select,
    .content-position .col-md-12 > .row:nth-of-type(2) .filter_row .date_selection {
        font-size: 11px !important;
        color: #1e293b !important;
        background: transparent !important;
        border: none !important;
        outline: none !important;
        width: 100% !important;
    }

    /* Makes the Filter button wrapper span both grid columns. */
    .content-position .col-md-12 > .row:nth-of-type(2) > div:has(#pin-filter) {
        grid-column: 1 / -1 !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    /* Removes the inner row margin so the Filter button fills the full width. */
    .content-position .col-md-12 > .row:nth-of-type(2) > div:has(#pin-filter) .row {
        margin: 0 !important;
        width: 100% !important;
    }

    /* Styles the Filter button as a full-width dark rounded button with white text. */
    #pin-filter {
        width: 100% !important;
        height: 42px !important;
        background: #111827 !important;
        border: none !important;
        border-radius: 10px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 14px !important;
        box-sizing: border-box !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #ffffff !important;
        text-decoration: none !important;
    }

    /* Makes the filter icon white with a small gap before the text. */
    #pin-filter i {
        color: #ffffff !important;
        margin-right: 6px !important;
    }

    /* ── Row 3: Month Tabs (Pills with Scroll) ── */

    /* Removes the desktop bottom border and spacing from the month tabs row. */
    .content-position .col-md-12 > .row:nth-of-type(3) {
        margin: 0 0 15px 0 !important;
        padding: 0 !important;
        border-bottom: none !important;
        display: block !important;
    }

    /* Allows the month tabs wrapper to scroll horizontally with smooth touch scrolling. */
    .content-position .col-md-12 > .row:nth-of-type(3) > div {
        width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
        scrollbar-width: none !important;
    }

    /* Hides the scrollbar of the month tabs in WebKit browsers. */
    .content-position .col-md-12 > .row:nth-of-type(3) > div::-webkit-scrollbar {
        display: none !important;
    }

    /* Lays out the month tabs in a single non-wrapping row so they can be scrolled. */
    #myTabs {
        display: flex !important;
        flex-wrap: nowrap !important;
        gap: 8px !important;
        border-bottom: none !important;
        padding: 2px 0 6px 0 !important;
        margin: 0 !important;
        width: max-content !important;
    }

    /* Prevents each tab item from shrinking or growing. */
    #myTabs .nav-item {
        margin: 0 !important;
        flex: 0 0 auto !important;
    }

    /* Styles each month tab as a rounded pill and hides the full month name (font-size 0). */
    #myTabs .nav-link {
        border-radius: 20px !important;
        padding: 6px 16px !important;
        font-size: 0 !important;
        font-weight: 500 !important;
        color: #64748b !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 52px !important;
        height: 32px !important;
        box-sizing: border-box !important;
    }

    /* Highlights the active month pill with a dark background and white text. */
    #myTabs .nav-link.active {
        background-color: #111827 !important;
        border-color: #111827 !important;
        color: #ffffff !important;
        font-weight: 600 !important;
    }

    /* Applies the shared font size and color to the short month labels (Jan–Dec). */
    #tab-1::after, #tab-2::after, #tab-3::after, #tab-4::after,
    #tab-5::after, #tab-6::after, #tab-7::after, #tab-8::after,
    #tab-9::after, #tab-10::after, #tab-11::after, #tab-12::after {
        font-size: 12px !important;
        color: inherit !important;
    }

    /* Shows "Jan" instead of the full month name. */
    #tab-1::after { content: "Jan" !important; }
    /* Shows "Feb" instead of the full month name. */
    #tab-2::after { content: "Feb" !important; }
    /* Shows "Mar" instead of the full month name. */
    #tab-3::after { content: "Mar" !important; }
    /* Shows "Apr" instead of the full month name. */
    #tab-4::after { content: "Apr" !important; }
    /* Shows "May" instead of the full month name. */
    #tab-5::after { content: "May" !important; }
    /* Shows "Jun" instead of the full month name. */
    #tab-6::after { content: "Jun" !important; }
    /* Shows "Jul" instead of the full month name. */
    #tab-7::after { content: "Jul" !important; }
    /* Shows "Aug" instead of the full month name. */
    #tab-8::after { content: "Aug" !important; }
    /* Shows "Sep" instead of the full month name. */
    #tab-9::after { content: "Sep" !important; }
    /* Shows "Oct" instead of the full month name. */
    #tab-10::after { content: "Oct" !important; }
    /* Shows "Nov" instead of the full month name. */
    #tab-11::after { content: "Nov" !important; }
    /* Shows "Dec" instead of the full month name. */
    #tab-12::after { content: "Dec" !important; }

    /* ── Orders Summary Card Top Controls (Title, Select Color, Search, Export) ── */

    /* Removes the desktop card look so the summary section blends into the page. */
    .card.orders_summary {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
    }

    /* Arranges the title, color picker and search/export into a 2-row grid. */
    .card.orders_summary > .row:first-child {
        padding: 0 !important;
        margin: 0 0 15px 0 !important;
        display: grid !important;
        grid-template-columns: 1fr auto !important;
        grid-template-areas:
            "title color"
            "search search" !important;
        align-items: center !important;
        gap: 12px !important;
    }

    /* Places the "Order Schedule Sheet" title in the top-left grid area. */
    .card.orders_summary > .row:first-child > div:nth-child(1) {
        grid-area: title !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Styles the section title as bold dark text. */
    .bargraph_header {
        font-size: 16px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }

    /* Places the color picker block in the top-right grid area. */
    .card.orders_summary > .row:first-child > div:nth-child(2) {
        grid-area: color !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Aligns the "Select a Color" label and picker in one line. */
    .card.orders_summary > .row:first-child > div:nth-child(2) .row {
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }

    /* Styles the "Select a Color" label as small grey text on one line. */
    .card.orders_summary > .row:first-child > div:nth-child(2) label {
        margin: 0 !important;
        font-size: 12px !important;
        color: #64748b !important;
        white-space: nowrap !important;
    }

    /* Makes the color picker wrapper a small bordered square. */
    .color_div {
        width: 22px !important;
        height: 22px !important;
        margin: 0 !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 4px !important;
        overflow: hidden !important;
    }

    /* Enlarges the color input so it fills (and is clipped by) its small wrapper. */
    #favcolor {
        width: 30px !important;
        height: 30px !important;
        border: none !important;
        background: transparent !important;
        cursor: pointer !important;
    }

    /* Places the search and export block in the full-width bottom grid area. */
    .card.orders_summary > .row:first-child > .ml-auto.print_btn {
        grid-area: search !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Puts the search input and export button side by side with a gap. */
    .print_btn .row {
        margin: 0 !important;
        width: 100% !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
    }

    /* Styles the order search input as a flexible rounded white field. */
    #searchOrder {
        flex: 1 1 auto !important;
        width: auto !important;
        height: 42px !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 0 12px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        box-sizing: border-box !important;
    }

    /* Styles the export button as a green rounded button that keeps its own width. */
    .download_btn.export_btn {
        flex: 0 0 auto !important;
        height: 42px !important;
        background-color: #36D7B7 !important;
        border: none !important;
        color: #ffffff !important;
        border-radius: 10px !important;
        padding: 0 14px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        white-space: nowrap !important;
        text-decoration: none !important;
    }

    /* Removes the desktop margin from the download icon inside the export button. */
    .download_btn.export_btn i {
        margin: 0 !important;
    }

    /* Adds the "Export Report" text after the download icon. */
    .download_btn.export_btn::after {
        content: "Export Report" !important;
    }

    /* ── Order Schedule Cards (Table transformation) ── */

    /* Removes the horizontal scroll and padding of the table wrapper since rows become cards. */
    .order_shedule_table {
        width: 100% !important;
        overflow-x: visible !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Hides the table header because each card labels its own fields. */
    #order_shedule_table thead {
        display: none !important;
    }

    /* Converts the table and tbody into plain full-width blocks. */
    #order_shedule_table,
    #order_shedule_table tbody {
        display: block !important;
        width: 100% !important;
        border: none !important;
        background: transparent !important;
    }

        /* Turns each table row into a rounded grid card, with the 3 dates sharing one row on a 6-column grid. */
    #order_shedule_table tbody tr {
        display: grid !important;
        grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
        grid-template-areas:
            "orderno orderno orderno orderno status status"
            "org org org org org org"
            "conf_date conf_date req_date req_date due_date due_date"
            "type_box type_box type_box qty_box qty_box qty_box"
            "rep_box rep_box rep_box tp_need tp_need tp_need"
            "tp_due tp_due tp_due rec_date rec_date rec_date"
            "comment comment comment comment comment comment" !important;
        gap: 6px 8px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        margin-bottom: 12px !important;
        /* padding: 14px 44px 14px 18px !important; */
        padding: 14px 2px 2px 10px !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03) !important;
        position: relative !important;
        overflow: hidden !important;
        box-sizing: border-box !important;
        width: 100% !important;
        cursor: pointer !important;
        background-color: #ffffff;
    }

    /* Uses a wider 3-column card layout on larger phones (480px and up). */
    /* @media (min-width: 480px) and (max-width: 767.98px) {
        #order_shedule_table tbody tr {
            grid-template-columns: 1fr 1fr 1fr !important;
            grid-template-areas:
                "orderno orderno status"
                "org org org"
                "conf_date req_date due_date"
                "type_box qty_box rep_box"
                "tp_need tp_due rec_date"
                "comment comment comment" !important;
        }
    } */

    /* Covers the card with a white layer that leaves the left 4px of the row status color visible. */
    #order_shedule_table tbody tr::before {
        content: "" !important;
        position: absolute !important;
        top: 0 !important;
        left: 4px !important;
        right: 0 !important;
        bottom: 0 !important;
        background: #ffffff !important;
        border-radius: 0 14px 14px 0 !important;
        z-index: 0 !important;
    }

    /* Pins a right-chevron icon to the top right of each card to show it can be expanded. */
    #order_shedule_table tbody tr::after {
        content: "\f054" !important;
        font-family: "Font Awesome 5 Free", "FontAwesome" !important;
        font-weight: 900 !important;
        font-size: 13px !important;
        color: #64748b !important;
        position: absolute !important;
        top: 18px !important;
        right: 16px !important;
        z-index: 5 !important;
    }

    /* Switches the chevron to a down-arrow when the card is expanded. */
    #order_shedule_table tbody tr.expanded::after,
    #order_shedule_table tbody tr:focus-within::after {
        content: "\f078" !important;
    }

    /* Resets every cell to a plain block placed above the white card layer. */
    #order_shedule_table tbody tr td {
        display: block !important;
        padding: 0 !important;
        border: none !important;
        background: transparent !important;
        text-align: left !important;
        position: relative !important;
        z-index: 1 !important;
        box-sizing: border-box !important;
        min-width: 0 !important;
    }

    /* Hides the checkbox/flag cell (column 1) on mobile. */
    #order_shedule_table tbody tr td:nth-child(1) {
        display: none !important;
    }

    /* Shows the order number (column 2) as the bold card title, cut with ellipsis if long. */
    #order_shedule_table tbody tr td:nth-child(2) {
        grid-area: orderno !important;
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        align-self: center !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* Styles the order number link as bold dark text without underline. */
    #order_shedule_table tbody tr td:nth-child(2) a {
        color: #0f172a !important;
        text-decoration: none !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
        display: block !important;
    }

    /* Hides the factory cell (column 3) on mobile. */
    #order_shedule_table tbody tr td:nth-child(3) {
        display: none !important;
    }

    /* Shows the organization name (column 4) under the order number, cut with ellipsis if long. */
    #order_shedule_table tbody tr td:nth-child(4) {
        grid-area: org !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #334155 !important;
        margin-top: -2px !important;
        margin-bottom: 4px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* Places the Confirmed Ex-Factory date (column 5) in its grid area. */
    #order_shedule_table tbody tr td:nth-child(5) { grid-area: conf_date !important; }
    /* Places the Requested Ex-Factory date (column 6) in its grid area. */
    #order_shedule_table tbody tr td:nth-child(6) { grid-area: req_date !important; }
    /* Places the In Hand Due date (column 7) in its grid area. */
    #order_shedule_table tbody tr td:nth-child(7) { grid-area: due_date !important; }

    /* Styles the three date values (columns 5, 6, 7) as small bold dark text. */
    #order_shedule_table tbody tr td:nth-child(5),
    #order_shedule_table tbody tr td:nth-child(6),
    #order_shedule_table tbody tr td:nth-child(7) {
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #1e293b !important;
        white-space: normal !important;
        overflow-wrap: break-word !important;
    }

    /* Styles the Order Status cell (column 10) as a blue badge pinned to the top right. */
    #order_shedule_table tbody tr td:nth-child(10) {
        grid-area: status !important;
        justify-self: end !important;
        align-self: center !important;
        /* margin-right: 0 !important; */
        margin-right: 34px !important;
        background: #dbeafe !important;
        color: #2563eb !important;
        border-radius: 12px !important;
        padding: 3px 10px !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        line-height: 1.2 !important;
        white-space: nowrap !important;
        z-index: 3 !important;
    }

    /* Switches the status badge to grey for fulfilled (grey) rows. */
    #order_shedule_table tbody tr[style*="205, 205, 205"] td:nth-child(10) {
        background: #f1f5f9 !important;
        color: #475569 !important;
    }

    /* ── Detail Fields (Shown in expanded state) ── */

    /* Places Order Type (column 11) in its grid area. */
    #order_shedule_table tbody tr td:nth-child(11) { grid-area: type_box !important; }
    /* Places Order Qty (column 14) in its grid area. */
    #order_shedule_table tbody tr td:nth-child(14) { grid-area: qty_box !important; }
    /* Places Sales Rep (column 12) in its grid area. */
    #order_shedule_table tbody tr td:nth-child(12) { grid-area: rep_box !important; }
    /* Places Test Print Needed (column 8) in its grid area. */
    #order_shedule_table tbody tr td:nth-child(8)  { grid-area: tp_need !important; }
    /* Places Test Print Due Date (column 9) in its grid area. */
    #order_shedule_table tbody tr td:nth-child(9)  { grid-area: tp_due !important; }
    /* Places Received Date (column 13) in its grid area. */
    #order_shedule_table tbody tr td:nth-child(13) { grid-area: rec_date !important; }

    /* Styles the six detail cells as small light-grey boxes with ellipsis for long text. */
    #order_shedule_table tbody tr td:nth-child(11),
    #order_shedule_table tbody tr td:nth-child(14),
    #order_shedule_table tbody tr td:nth-child(12),
    #order_shedule_table tbody tr td:nth-child(8),
    #order_shedule_table tbody tr td:nth-child(9),
    #order_shedule_table tbody tr td:nth-child(13) {
        background: #f8fafc !important;
        border: 1px solid #f1f5f9 !important;
        border-radius: 8px !important;
        padding: 6px 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #1e293b !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }

    /* ── Field Labels (shared style for every small label shown above a value) ── */

    /* Styles all field labels as tiny grey text on their own line above the value. */
    #order_shedule_table tbody tr td:nth-child(5)::before,
    #order_shedule_table tbody tr td:nth-child(6)::before,
    #order_shedule_table tbody tr td:nth-child(7)::before,
    #order_shedule_table tbody tr td:nth-child(11)::before,
    #order_shedule_table tbody tr td:nth-child(14)::before,
    #order_shedule_table tbody tr td:nth-child(12)::before,
    #order_shedule_table tbody tr td:nth-child(8)::before,
    #order_shedule_table tbody tr td:nth-child(9)::before,
    #order_shedule_table tbody tr td:nth-child(13)::before {
        white-space: pre-wrap !important;
        display: block !important;
        font-size: 10px !important;
        font-weight: 400 !important;
        color: #94a3b8 !important;
        margin-bottom: 2px !important;
    }

    /* Adds the "Confirmed Ex-Factory" label above column 5. */
    #order_shedule_table tbody tr td:nth-child(5)::before  { content: "Confirmed Ex-Factory\A" !important; }
    /* Adds the "Requested Ex-Factory" label above column 6. */
    #order_shedule_table tbody tr td:nth-child(6)::before  { content: "Requested Ex-Factory\A" !important; }
    /* Adds the "In Hand Due" label above column 7. */
    #order_shedule_table tbody tr td:nth-child(7)::before  { content: "In Hand Due\A" !important; }
    /* Adds the "Order Type" label above column 11. */
    #order_shedule_table tbody tr td:nth-child(11)::before { content: "Order Type\A" !important; }
    /* Adds the "Order Qty" label above column 14. */
    #order_shedule_table tbody tr td:nth-child(14)::before { content: "Order Qty\A" !important; }
    /* Adds the "Sales Rep" label above column 12. */
    #order_shedule_table tbody tr td:nth-child(12)::before { content: "Sales Rep\A" !important; }
    /* Adds the "Test Print Need?" label above column 8. */
    #order_shedule_table tbody tr td:nth-child(8)::before  { content: "Test Print Need?\A" !important; }
    /* Adds the "Test Print Due Date" label above column 9. */
    #order_shedule_table tbody tr td:nth-child(9)::before  { content: "Test Print Due Date\A" !important; }
    /* Adds the "Received Date" label above column 13. */
    #order_shedule_table tbody tr td:nth-child(13)::before { content: "Received Date\A" !important; }

    /* ── Expand / Collapse ── */

    /* Hides the detail boxes and special comment while the card is collapsed. */
    #order_shedule_table tbody tr:not(.expanded) td:nth-child(11),
    #order_shedule_table tbody tr:not(.expanded) td:nth-child(14),
    #order_shedule_table tbody tr:not(.expanded) td:nth-child(12),
    #order_shedule_table tbody tr:not(.expanded) td:nth-child(8),
    #order_shedule_table tbody tr:not(.expanded) td:nth-child(9),
    #order_shedule_table tbody tr:not(.expanded) td:nth-child(13),
    #order_shedule_table tbody tr:not(.expanded) td:nth-child(15) {
        display: none !important;
    }

    /* Shows the detail boxes when the card is tapped and gets the "expanded" class. */
    #order_shedule_table tbody tr.expanded td:nth-child(11),
    #order_shedule_table tbody tr.expanded td:nth-child(14),
    #order_shedule_table tbody tr.expanded td:nth-child(12),
    #order_shedule_table tbody tr.expanded td:nth-child(8),
    #order_shedule_table tbody tr.expanded td:nth-child(9),
    #order_shedule_table tbody tr.expanded td:nth-child(13) {
        display: block !important;
    }

    /* ── Special Comments (column 15) ── */

    /* Places the special comment at the bottom of the card with a dotted divider above it. */
    #order_shedule_table tbody tr td:nth-child(15) {
        grid-area: comment !important;
        border-top: 1px dotted #e2e8f0 !important;
        margin-top: 8px !important;
        padding-top: 8px !important;
        font-size: 11px !important;
        color: #475569 !important;
        font-weight: 500 !important;
        text-align: left !important;
        align-items: center !important;
    }

    /* Shows the special comment as a flex row only when the card is expanded. */
    #order_shedule_table tbody tr.expanded td:nth-child(15) {
        display: flex !important;
    }

    /* Adds a small comment icon before the special comment text. */
    #order_shedule_table tbody tr td:nth-child(15)::before {
        content: "\f075" !important;
        font-family: "Font Awesome 5 Free", "FontAwesome" !important;
        font-weight: 400 !important;
        font-size: 12px !important;
        color: #475569 !important;
        margin-right: 6px !important;
    }

    /* Styles the special comment link as small grey text without underline. */
    #order_shedule_table tbody tr td:nth-child(15) a {
        color: #475569 !important;
        text-decoration: none !important;
        font-size: 11px !important;
        font-weight: 500 !important;
    }

    /* Adds the "View Special Comment" text after the add-comment icon link. */
    #order_shedule_table tbody tr td:nth-child(15) a.specialComment::after {
        content: " View Special Comment" !important;
        font-size: 11px !important;
        font-weight: 500 !important;
        color: #475569 !important;
    }
}
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
<div id="buffering_icon1" style="display: none;">
    <img src="{{ asset('argon') }}/img/icons/buffering_icon.gif" />
</div>

<div class=" mb-5 content-position ">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>Encore Order Schedule</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="padding-bottom: 25px !important;">
        <div class="row" style="margin-left: 5px; margin-right: 30px; padding-bottom: 7px;">
            <div class="col-md-2" style="margin-bottom: 10px;">
                <select class="form-control" id="yearSelect" style="height: 20px;">
                    @php
                        $currentYear = now()->year;
                        $startYear = $currentYear - 4;
                    @endphp
                    @for ($year = $startYear; $year <= $currentYear; $year++)
                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
            </div>
            <div class="ml-auto">
                {{-- <div class="ml-auto"> --}}
                    <div class="row">

                        <div class="today_color"></div>
                        <strong class="production_text">Today Orders</strong>

                        <div class="past_color"></div>
                        <strong class="production_text">Past The Ex Factory Date </strong>

                        <div class="thisWeek_color"></div>
                        <strong class="production_text"> This Week Shipment</strong>

                        <div class="fulfilled_color"></div>
                        <strong class="production_text">Fulfilled Orders </strong>

                        <div class="cancel_color"></div>
                        <strong class="production_text">Canceled Orders </strong>

                    </div>
                {{-- </div> --}}
            </div>
        </div>

        <div class="row" style="margin-left: 18px; margin-right: 30px; padding-bottom: 7px;">
            <div class="row filter_row " style="padding-bottom: 2px;">
                <p class="font_color date_p" style="padding-left: 5px;">Factory |  </p>
                <div class="paymen_type_div date_selection" style="padding-left: 10px;">
                    <select id="factory" class="date_selection">
                        <option value="all">All</option>
                        @foreach ($factories as $factory)
                            <option value="{{ $factory->id }}">{{ $factory->factory_code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row filter_row" style="padding-bottom: 2px;margin-left: 20px;">
                <p class="font_color date_p">Order Status |  </p>
                <div class="paymen_type_div date_selection" style="padding-left: 7px;">
                    <select id="orderStatus" class="date_selection">
                        <option value="all">All</option>
                        @foreach ($orderStatus as $orderStatuss)
                            <option value="{{ $orderStatuss->id }}">{{ $orderStatuss->status_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row filter_row" style="padding-bottom: 2px; margin-left: 20px;">
                <p class="font_color date_p" style="padding-left: 5px;">Test Pring |  </p>
                <div class="paymen_type_div date_selection" style="padding-left: 7px;">
                    <select id="testPrint" class="date_selection">
                        <option value="all">All</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="row filter_row" style="padding-bottom: 2px; margin-left: 20px;">
                <p class="font_color date_p">Rep |  </p>
                <div class="paymen_type_div date_selection" style="padding-left: 7px;">
                    <select id="usersSales" class="date_selection">
                        <option value="all">All</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-left: 45px;">
                <div class="row" style="padding-bottom: 2px;">
                    <a href="#" class="date_p filter_btn" id="pin-filter" title="Filter">
                        <i class="fa fa-filter " style="padding-left: 5px; padding-top: 4px; padding-right: 5px;"></i>
                        Filter
                    </a>
                </div>
            </div>

        </div>

        <div class="row" style="margin-left: 10px; margin-right: 10px; border-bottom: 3px solid #dee2e6; padding-bottom: 7px;">
            <div>
                <ul class="nav nav-tabs" id="myTabs" role="tablist">
                    @php
                        $currentMonth = now()->month;
                        $months = [
                            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
                        ];
                    @endphp

                    @foreach ($months as $monthNum => $monthName)
                        <li class="nav-item month-tab" id="month{{ $monthNum }}">
                            <a class="nav-link" id="tab-{{ $monthNum }}" data-toggle="tab" href="#content-{{ $monthNum }}"
                                role="tab" aria-controls="content-{{ $monthNum }}">
                                {{ $monthName }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>


        </div>




        <div class="card orders_summary print_content" style="border: unset; padding: 10px;">

            <div class="row" style="padding-left: 10px; padding-right: 10px;">
                <div style="padding: 5px;">
                    <b class="bargraph_header font_color">Order Schedule Sheet</b>
                </div>

                <div class="" style="padding-left: 40px;">
                    <div class="row">
                        <label for="" style="margin-bottom: unset; padding-top: 8px;">Select a Color</label>
                        <div class="color_div">
                            <input type="color" id="favcolor" name="favcolor" value="">
                        </div>
                    </div>
                </div>

                <div class="ml-auto print_btn" style="width: 32%;">
                    <div class="row">
                        <input class="search_class" id="searchOrder" type="text" placeholder="Order Search" style="width: 80%;">
                        <a class="top_button download_btn export_btn" href="#" title="Export CSV"><i class="fa fa-download" style="margin-right: 8px; margin-top: 8px;"></i></a>
                    </div>
                </div>
            </div>

            <div class="order_shedule_table" style="overflow-x: auto;">
                <table class="table align-items-center" id="order_shedule_table" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">FLAG</th>
                        <th scope="col" class="table_header_text">ORDER #</th>
                        <th scope="col" class="table_header_text">FACTORY</th>
                        <th scope="col" class="table_header_text">ORGANIZATION </th>
                        <th scope="col" class="table_header_text">CONFIRMED EX FACTORY </th>
                        <th scope="col" class="table_header_text">REQUESTED EX FACTORY </th>
                        <th scope="col" class="table_header_text">IN HAND</th>
                        <th scope="col" class="table_header_text">TEST PRINT NEEDED?</th>
                        <th scope="col" class="table_header_text">TEST PRINT DUE DATE</th>
                        <th scope="col" class="table_header_text">ORDER STATUS</th>
                        <th scope="col" class="table_header_text">ORDER TYPE </th>
                        <th scope="col" class="table_header_text">SALES REP</th>
                        <th scope="col" class="table_header_text">RECEIVED DATE </th>
                        <th scope="col" class="table_header_text">ORDER QTY </th>
                        <th scope="col" class="table_header_text">SPECIAL COMMENTS </th>
                    </thead>

                    <tbody id="table_body">

                    </tbody>
                </table>

            </div>
        </div>
    </div>


</div>

<!-- Special Comment Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('saveSpecialComment') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Special Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control special_comment" id="special_comment" name="special_comment" style="resize: vertical;"></textarea>
                    <input type="hidden" class="order_id" id="order_id" name="order_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>


<script>
    // function updateTabs() {
    //     var currentYear = new Date().getFullYear();
    //     var currentMonth = new Date().getMonth() + 1; // Months are zero-indexed
    //     var selectedYear = document.getElementById('yearSelect').value;

    //     var monthTabs = document.getElementsByClassName('month-tab');
    //     for (var i = 0; i < monthTabs.length; i++) {
    //         var monthTab = monthTabs[i];
    //         var monthNum = parseInt(monthTab.id.replace('month', ''));

    //         if (selectedYear == currentYear) {
    //             // Hide future months for the current year
    //             if (monthNum > currentMonth) {
    //                 monthTab.style.display = 'none';
    //             } else {
    //                 monthTab.style.display = '';
    //             }
    //         } else {
    //             // Show all months for past years
    //             monthTab.style.display = '';
    //         }
    //     }
    // }

    // // Initial call to set the correct tabs on page load
    // updateTabs();


    // default table load
    var transactionsArray = @json($orders);
    var ordersData = transactionsArray.data;

    var tableBody = document.getElementById('table_body');

    console.log(ordersData);

    // Collect rows with order_status_id 4 or 7
    let specialRows = [];

    // Process each transaction
    ordersData.forEach(transaction => {
        var uniqueFactories = Array.from(new Set(transaction.order_items.map(item => item.factory_details?.factory_code ?? '')));
        var factories = uniqueFactories.filter(code => code !== '').join(', ');

        var factoryConfirmedDate = transaction.factory_confirmation_date ? transaction.factory_confirmation_date : '';

        var dueDate = transaction.due_date ? transaction.due_date : '';

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


        var orderType;
        if (transaction.is_urgent == 1){
            orderType = 'Urgent Order'
        } else if (transaction.order_type == 0 && transaction.is_reordered == 0) {
            orderType = 'Bulk New Order'
        } else if (transaction.order_type == 1 && transaction.is_reordered == 0) {
            orderType = 'TS Order'
        } else if (transaction.is_reordered == 1) {
            orderType = 'Reorder'
        } else {
            orderType = 'New Order'
        }

        var orderItemCount = transaction.order_items.length;

        var row = tableBody.insertRow();

        var specialCommentCell;
        if (transaction.shedule_comment) {
            const comments = transaction.shedule_comment.split('\n');
            const firstComment = comments[0].trim();
            specialCommentCell = `<td class="font_color row_padding">${firstComment} <a href="#" class="specialCommentUpdate" id="specialCommentUpdate" data-value="${transaction.id}" data-schedule-comment="${transaction.shedule_comment}" style="margin-left: 13px;"><i class="fa fa-pen"></i></a></td>`;
        } else {
            specialCommentCell = `<td class="font_color row_padding" style="text-align: center;"><a href="#" class="specialComment" id="specialComment" data-value="${transaction.id}"><i class="fa fa-comment-dots"></i></a></td>`;
        }

        var receivedDate = transaction.production_date ? transaction.production_date : '';

        row.innerHTML = `
            <td class="font_color row_padding color_picker">
                <div class="" id="colorDisplay_${transaction.order_no}">
                    <input type="checkbox" class="order_checkbox" id="${transaction.order_no}" name="${transaction.id}" value="${transaction.id}">
                </div>
            </td>
            <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.id}">${transaction.order_no}</a></td>
            <td class="font_color row_padding">${factories}</td>
            <td class="font_color row_padding">${transaction.organization_details.organization_name}</td>
            <td class="font_color row_padding">${factoryConfirmedDate}</td>
            <td class="font_color row_padding">${transaction.ex_factory_date}</td>
            <td class="font_color row_padding">${dueDate}</td>
            <td class="font_color row_padding">${testPrintNeeded}</td>
            <td class="font_color row_padding">${formattedNearestTestPrintDueDate}</td>
            <td class="font_color row_padding">${transaction.status_details.status_name}</td>
            <td class="font_color row_padding">${orderType}</td>
            <td class="font_color row_padding">${transaction.user_details.name}</td>
            <td class="font_color row_padding">${receivedDate}</td>
            <td class="font_color row_padding">${orderItemCount}</td>
            ${specialCommentCell}
        `;

        const exFactoryDate = new Date(transaction.ex_factory_date);
        const currentDate = new Date();
        const oneDayInMillis = 24 * 60 * 60 * 1000;

        const startOfToday = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());

        const isToday = exFactoryDate.getFullYear() === currentDate.getFullYear() &&
                exFactoryDate.getMonth() === currentDate.getMonth() &&
                exFactoryDate.getDate() === currentDate.getDate();

        // Calculate start of the current week (Monday)
        const startOfCurrentWeek = new Date(currentDate);
        const day = startOfCurrentWeek.getDay();
        const diff = startOfCurrentWeek.getDate() - day + (day === 0 ? -6 : 1); // Adjust when day is Sunday
        startOfCurrentWeek.setDate(diff);

        // Calculate end of the current week (Sunday)
        const endOfCurrentWeek = new Date(startOfCurrentWeek);
        endOfCurrentWeek.setDate(startOfCurrentWeek.getDate() + 6);

        const isThisWeek = exFactoryDate >= startOfCurrentWeek && exFactoryDate <= endOfCurrentWeek;



         if (isToday && transaction.order_status_id == 3) { // today
            row.style.backgroundColor = 'rgba(25, 219, 125, 0.72)';
        } else  if (exFactoryDate < startOfToday && transaction.order_status_id == 3) { // past day delay
            row.style.backgroundColor = 'rgba(255, 0, 0, 0.82)';
        } else if (isThisWeek && transaction.order_status_id == 3) { // this week shipment from today
            row.style.backgroundColor = 'rgba(255, 117, 17, 0.76)';
        } else if (transaction.order_status_id == 4 ) { // Fulfilled
            row.style.backgroundColor = 'rgb(205, 205, 205)';
            specialRows.push(row);
        } else if (transaction.order_status_id == 7) { //Cancel
            row.style.backgroundColor = 'rgba(255, 0, 0, 0.4)';
            specialRows.push(row);
        // } else if (transaction.order_status_id == 3) {
        //     row.style.backgroundColor = 'rgba(251, 87, 121, 0.73)';
        } else if (transaction.shedule_color) {
            row.style.backgroundColor = transaction.shedule_color;
        }

        const colorInput = document.getElementById('favcolor');
        const checkboxes = document.querySelectorAll('.order_checkbox');

        colorInput.addEventListener('input', function() {
            const selectedColor = colorInput.value;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const row = checkbox.closest('tr');
                    row.style.backgroundColor = selectedColor;
                }
            });
        });

        // Special Comment Update
        document.addEventListener('DOMContentLoaded', function() {
            const specialCommentUpdateLinks = document.querySelectorAll('.specialCommentUpdate');

            specialCommentUpdateLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const orderId = this.getAttribute('data-value');
                    const scheduleComment = this.getAttribute('data-schedule-comment');
                    openUpdateModal(orderId, scheduleComment);
                });
            });

            function openUpdateModal(orderId, scheduleComment) {
                const modalTitle = document.getElementById('modalTitle');
                modalTitle.textContent = 'Special Comment - Order ID: ' + orderId;

                const orderIdInput = document.querySelector('.order_id');
                const specialCommentUpdate = document.querySelector('.special_comment');
                orderIdInput.value = orderId;
                specialCommentUpdate.value = scheduleComment;

                $('#myModal').modal('show');
            }
        });
        // End Special Comment Update
    });

    // Append special rows at the end of the table
    specialRows.forEach(row => tableBody.appendChild(row));

    // End default table load


    //Change color
    document.addEventListener('DOMContentLoaded', function() {
        const colorInput = document.getElementById('favcolor');

        // Function to send AJAX request
        function sendColorData(data) {
            $.ajax({
                url: '{{ route('orderSheduleColor') }}',
                method: 'POST',
                data: {
                    selectedOrders: data.selectedOrders,
                    selectedColor: data.selectedColor
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        }

        // Event listener for color input change
        colorInput.addEventListener('input', function() {
            const checkboxes = document.querySelectorAll('.order_checkbox');
            const selectedOrders = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
            const selectedColor = colorInput.value;
            const data = { selectedOrders, selectedColor };
            console.log(data);
            sendColorData(data);
        });
    });
    // End Change color


    //Month display change related selected year
    document.addEventListener('DOMContentLoaded', function () {
        // Function to toggle active class for tabs
        function toggleActiveTab(tabId) {
            var tabs = document.querySelectorAll('#myTabs .nav-link');
            tabs.forEach(function (tab) {
                tab.classList.remove('active');
            });
            var tabToActivate = document.querySelector('#tab-' + tabId);
            tabToActivate.classList.add('active');
        }

        var currentMonth = new Date().getMonth() + 1;
        toggleActiveTab(currentMonth);

        // document.getElementById('yearSelect').addEventListener('change', function () {
        //     var selectedYear = parseInt(this.value);
        //     var currentYear = new Date().getFullYear();
        //     var currentMonth = new Date().getMonth() + 1;

        //     if (selectedYear < currentYear) {
        //         for (var i = 1; i <= 12; i++) {
        //             document.getElementById('month' + i).style.display = 'block';
        //         }
        //     } else {
        //         for (var i = 1; i <= 12; i++) {
        //             if (i <= currentMonth) {
        //                 document.getElementById('month' + i).style.display = 'block';
        //             } else {
        //                 document.getElementById('month' + i).style.display = 'none';
        //             }
        //         }
        //         toggleActiveTab(currentMonth);
        //     }
        // });

        document.getElementById('yearSelect').dispatchEvent(new Event('change'));

        // Event listener for tab clicks
        var tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                var tabId = this.getAttribute('id').replace('tab-', '');
                toggleActiveTab(tabId);
            });
        });
    });
    // End Month display change related selected year

    // Update table data related selected month and year
    $(document).ready(function() {
        $('#myTabs a').on('click', function (e) {
            e.preventDefault();
            var month = $(this).attr('id').replace('tab-', '');
            var year = $('#yearSelect').val();
            const factory = document.getElementById('factory').value;
            const orderStatus = document.getElementById('orderStatus').value;
            const testPrint = document.getElementById('testPrint').value;
            const usersSales = document.getElementById('usersSales').value;
            fetchDataFromController(month, year, factory, orderStatus, testPrint, usersSales);
            // console.log(orderStatus);
        });

        var searchValue = null;

        function fetchDataFromController(month, year, factory, orderStatus, testPrint, usersSales) {
            var searchValue = $('#searchOrder').val().trim();
            $.ajax({
                url: '{{ route('filterOrdershedule') }}',
                method: 'GET',
                data: { month: month,
                        year: year,
                        searchValue: searchValue,
                        factory: factory,
                        orderStatus: orderStatus,
                        testPrint: testPrint,
                        usersSales: usersSales
                     },
                beforeSend: function () {
                    // Show loader if needed
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function(response) {
                    console.log(response);
                    updateTable(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                },
                complete: function () {
                    // Hide loader if needed
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }
    });
    // End Update table data related selected month and year

    // filter orders
    document.getElementById('pin-filter').addEventListener('click', function(event) {
        event.preventDefault();
        const factory = document.getElementById('factory').value;
        const orderStatus = document.getElementById('orderStatus').value;
        const testPrint = document.getElementById('testPrint').value;
        const usersSales = document.getElementById('usersSales').value;
        const year = document.getElementById('yearSelect').value;
        var activeTab = document.querySelector('.nav-link.active');
        if (activeTab) {
            var month = activeTab.id.replace('tab-', '');
            console.log(month);
        }
        $.ajax({
            url: '{{ route('filterOrdershedule') }}',
            method: 'GET',
            data: {
                factory: factory,
                orderStatus: orderStatus,
                testPrint: testPrint,
                usersSales: usersSales,
                year: year,
                month: month,
            },
            beforeSend: function () {
                // Show loader if needed
                $(".se-pre-con").fadeIn('slow');
            },
            success: function (response) {
                console.log(response);
                updateTable(response);
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

    //end filter orders

    // Update table
    function updateTable(response) {

        var ordersData = response.orders;

        var tableBody = document.getElementById('table_body');
        tableBody.innerHTML = '';

        console.log(ordersData);

        // Collect rows with order_status_id 4 or 7
        let specialRows = [];

        // Process each transaction
        ordersData.forEach(transaction => {
            var uniqueFactories = Array.from(new Set(transaction.order_items.map(item => item.factory_details && item.factory_details.factory_code)));

            var factories = uniqueFactories.join(', ');

            var factoryConfirmedDate = transaction.factory_confirmation_date ? transaction.factory_confirmation_date : '';

            var dueDate = transaction.due_date ? transaction.due_date : '';

            // Determine if testPrintNeeded is 'Yes' or 'No'
            // var testPrintNeeded = (transaction.order_items.filter(item => item.test_print_needed == 1).length == 1 && transaction.order_items.every(item => item.test_print_needed == 0 || item.test_print_needed == 1))
            //     ? 'Yes'
            //     : 'No';

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


            var orderType;

            if (transaction.is_urgent == 1){
                orderType = 'Urgent Order'
            } else if (transaction.order_type == 0 && transaction.is_reordered == 0) {
                orderType = 'Bulk New Order'
            } else if (transaction.order_type == 1 && transaction.is_reordered == 0) {
                orderType = 'TS Order'
            } else if (transaction.is_reordered == 1) {
                orderType = 'Reorder'
            } else {
                orderType = 'New Order'
            }

            var orderItemCount = transaction.order_items.length;

            var row = tableBody.insertRow();

            var specialCommentCell;
            if (transaction.shedule_comment) {
                specialCommentCell = `<td class="font_color row_padding">${transaction.shedule_comment} <a href="#" class="specialCommentUpdate" id="specialCommentUpdate" data-value="${transaction.id}" data-schedule-comment="${transaction.shedule_comment}" style="margin-left: 13px;"><i class="fa fa-pen"></i></a></td>`;
            } else {
                specialCommentCell = `<td class="font_color row_padding" style="text-align: center;"><a href="#" class="specialComment" id="specialComment" data-value="${transaction.id}"><i class="fa fa-comment-dots"></i></a></td>`;
            }

            var receivedDate = transaction.production_date ? transaction.production_date : '';

            row.innerHTML = `
                <td class="font_color row_padding color_picker">
                    <div class="" id="colorDisplay_${transaction.order_no}">
                        <input type="checkbox" class="order_checkbox" id="${transaction.order_no}" name="${transaction.id}" value="${transaction.id}">
                    </div>
                </td>
                <td class="font_color row_padding"><a href="#" class="edit-order" data-value="${transaction.id}">${transaction.order_no}</a></td>
                <td class="font_color row_padding">${factories}</td>
                <td class="font_color row_padding">${transaction.organization_details.organization_name}</td>
                <td class="font_color row_padding">${factoryConfirmedDate}</td>
                <td class="font_color row_padding">${transaction.ex_factory_date}</td>
                <td class="font_color row_padding">${dueDate}</td>
                <td class="font_color row_padding">${testPrintNeeded}</td>
                <td class="font_color row_padding">${formattedNearestTestPrintDueDate}</td>
                <td class="font_color row_padding">${transaction.status_details.status_name}</td>
                <td class="font_color row_padding">${orderType}</td>
                <td class="font_color row_padding">${transaction.user_details.name}</td>
                <td class="font_color row_padding">${receivedDate}</td>
                <td class="font_color row_padding">${orderItemCount}</td>
                ${specialCommentCell}
            `;


            const exFactoryDate = new Date(transaction.ex_factory_date);
            const currentDate = new Date();
            const oneDayInMillis = 24 * 60 * 60 * 1000;

            const startOfToday = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());

            const isToday = exFactoryDate.getFullYear() === currentDate.getFullYear() &&
                    exFactoryDate.getMonth() === currentDate.getMonth() &&
                    exFactoryDate.getDate() === currentDate.getDate();

            // Calculate start of the current week (Monday)
            const startOfCurrentWeek = new Date(currentDate);
            const day = startOfCurrentWeek.getDay();
            const diff = startOfCurrentWeek.getDate() - day + (day === 0 ? -6 : 1); // Adjust when day is Sunday
            startOfCurrentWeek.setDate(diff);

            // Calculate end of the current week (Sunday)
            const endOfCurrentWeek = new Date(startOfCurrentWeek);
            endOfCurrentWeek.setDate(startOfCurrentWeek.getDate() + 6);

            const isThisWeek = exFactoryDate >= startOfCurrentWeek && exFactoryDate <= endOfCurrentWeek;



            if (isToday && transaction.order_status_id == 3) { // today
                row.style.backgroundColor = 'rgba(25, 219, 125, 0.72)';
            } else  if (exFactoryDate < startOfToday && transaction.order_status_id == 3) { // past day delay
                row.style.backgroundColor = 'rgba(255, 0, 0, 0.82)';
            } else if (isThisWeek && transaction.order_status_id == 3) { // next week shipment from today
                row.style.backgroundColor = 'rgba(255, 117, 17, 0.76)';
            } else if (transaction.order_status_id == 4 ) { // Fulfilled
                row.style.backgroundColor = 'rgb(205, 205, 205)';
                specialRows.push(row);
            } else if (transaction.order_status_id == 7) { //Cancel
                row.style.backgroundColor = 'rgba(255, 0, 0, 0.4)';
                specialRows.push(row);
            // } else if (transaction.order_status_id == 3) {
            //     row.style.backgroundColor = 'rgba(251, 87, 121, 0.73)';
            } else if (transaction.shedule_color) {
                row.style.backgroundColor = transaction.shedule_color;
            }

            // Change color filtered
            const colorInput = document.getElementById('favcolor');
            const checkboxes = document.querySelectorAll('.order_checkbox');

            colorInput.addEventListener('input', function() {
                const selectedColor = colorInput.value;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const row = checkbox.closest('tr');
                        row.style.backgroundColor = selectedColor;
                    }
                });
            });
            // End Change color filtered

            // Special Comment Update filtered
            const specialCommentUpdateLinks = document.querySelectorAll('.specialCommentUpdate');

            specialCommentUpdateLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const orderId = this.getAttribute('data-value');
                    const scheduleComment = this.getAttribute('data-schedule-comment');
                    openUpdateModal1(orderId, scheduleComment);
                });
            });

            function openUpdateModal1(orderId, scheduleComment) {
                const modalTitle = document.getElementById('modalTitle');
                modalTitle.textContent = 'Special Comment - Order ID: ' + orderId;

                const orderIdInput = document.querySelector('.order_id');
                const specialCommentUpdate = document.querySelector('.special_comment');
                orderIdInput.value = orderId;
                specialCommentUpdate.value = scheduleComment;

                $('#myModal').modal('show');
            }
            // End Special Comment Update filtered
        });

        // Append special rows at the end of the table
        specialRows.forEach(row => tableBody.appendChild(row));

        // End update table


        //Special Comment filtered
        const specialCommentLinks = document.querySelectorAll('.specialComment');

        specialCommentLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                const orderId = this.getAttribute('data-value');
                openModal1(orderId);
            });
        });

        function openModal1(orderId) {

            const modalTitle = document.getElementById('modalTitle');
            modalTitle.textContent = 'Special Comment - Order ID: ' + orderId;

            const orderIdInput = document.querySelector('.order_id');
            orderIdInput.value = orderId;

            $('#myModal').modal('show');
        }
        // End Special Comment filtered

    }
    //end update table

    //Special Comment
    document.addEventListener('DOMContentLoaded', function() {
        const specialCommentLinks = document.querySelectorAll('.specialComment');

        specialCommentLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                const orderId = this.getAttribute('data-value');
                openModal(orderId);
            });
        });

        function openModal(orderId) {

            const modalTitle = document.getElementById('modalTitle');
            modalTitle.textContent = 'Special Comment - Order ID: ' + orderId;

            const orderIdInput = document.querySelector('.order_id');
            orderIdInput.value = orderId;

            $('#myModal').modal('show');
        }

    });
    //Special Comment End

    //Download CSV
    document.addEventListener('DOMContentLoaded', function () {
        var downloadBtn = document.querySelector('.download_btn');
        downloadBtn.addEventListener('click', function () {
            var selectedYear = document.getElementById('yearSelect').value;

            var selectedMonthElement = document.querySelector('.nav-link.active');
            var selectedMonthName = selectedMonthElement.textContent.trim();

            var months = {
                'January': 1, 'February': 2, 'March': 3, 'April': 4,
                'May': 5, 'June': 6, 'July': 7, 'August': 8,
                'September': 9, 'October': 10, 'November': 11, 'December': 12,
            };
            var selectedMonth = months[selectedMonthName];

            console.log('Selected Year:', selectedYear);
            console.log('Selected Month:', selectedMonth);

            var routeUrl = "{{ url('/orderShedule_CSV_download/') }}" + '/' + selectedYear  + '/' + selectedMonth;

            window.location.href = routeUrl;

        });
    });

    // order redirect
    $("body").on("click", ".edit-order", function(){
        // $(".se-pre-con").fadeIn('slow');
        var orderId = $(this).data('value');
        // window.location.replace('order_details/edit/'+orderId+'/order?active_tab=order');
        window.open('order_details/edit/'+orderId+'/order?active_tab=order', '_blank');
    });
    // End order redirect

     // Search order

     $(document).ready(function() {
            var searchValue = null; // Initialize searchValue as null

            $('#searchOrder').on('keyup', function(e) {
                if (e.key === 'Enter') {
                    if ($('#searchOrder').val().trim() === '') {
                    location.reload();
                } else {
                    performSearch();
                }
                }
            });

            $('#searchOrder').on('blur', function() {
                if ($('#searchOrder').val().trim() === '') {
                    location.reload();
                } else {
                    performSearch();
                }
            });

            function performSearch() {
                var inputValue = $('#searchOrder').val().trim();
                var selectedYear = $('#yearSelect').val();
                var selectedMonth = $('.nav-tabs .nav-link.active').attr('id').split('-')[1];

                if (inputValue !== searchValue) { // Check if the input value has changed
                    searchValue = inputValue;
                    $.ajax({
                        url: "{{ route('sheduleSearchOrder') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            searchValue: searchValue,
                            selectedYear: selectedYear,
                            selectedMonth: selectedMonth
                        },
                        beforeSend: function () {
                            // Show loader if needed
                            $(".se-pre-con").fadeIn('slow');
                        },
                        success: function(response) {
                            // Update your UI with the retrieved data
                            console.log(response);
                            updateTable(response);
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        },
                        complete: function () {
                            // Hide loader if needed
                            $(".se-pre-con").fadeOut('slow');
                        }
                    });
                }
            }

        });

        // End Search order


        $(document).ready(function(){
            $(".se-pre-con").fadeOut('slow');
            $('.panel').css('display', 'block');
        });

        // Mobile row card click expansion toggle
        $("body").on("click", "#order_shedule_table tbody tr", function(e) {
            if ($(window).width() <= 767.98) {
                if ($(e.target).is('a') || $(e.target).closest('a').length || $(e.target).is('input') || $(e.target).closest('.order_checkbox').length) {
                    return;
                }
                $(this).toggleClass('expanded');
            }
        });

</script>

@endsection
