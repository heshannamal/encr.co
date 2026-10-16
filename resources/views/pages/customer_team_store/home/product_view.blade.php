@extends('layouts.customer_team_store.app')

@section('content')

<style>
    .size-chart-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .size-chart-wrapper:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .size-chart-wrapper .size-chart-hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.25s ease;
        border-radius: 8px;
    }
    .size-chart-wrapper:hover .size-chart-hover-overlay {
        opacity: 1;
    }

    /* Size Chart Viewer Modal Styling */
    #sizeChartModal .modal-dialog {
        max-width: 90vw;
        margin: 1.5rem auto;
    }
    #sizeChartModal .modal-content {
        background-color: #18191a;
        color: #ffffff;
        border: 1px solid #333;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    #sizeChartModal .modal-header {
        border-bottom: 1px solid #2d2d2d;
        padding: 12px 20px;
    }
    #sizeChartModal .modal-body {
        position: relative;
        background-color: #0f0f10;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 450px;
        max-height: 80vh;
        user-select: none;
        padding: 20px;
    }
    #sizeChartModal .size-chart-full-img {
        max-width: 100%;
        max-height: 72vh;
        object-fit: contain;
        transition: transform 0.15s ease-out;
        cursor: grab;
    }
    #sizeChartModal .size-chart-full-img:active {
        cursor: grabbing;
    }
    .size-chart-controls .btn-zoom {
        width: 36px !important;
        height: 36px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 6px !important;
        font-size: 14px !important;
        background-color: #2a2b2d;
        color: #fff;
        border: 1px solid #3a3b3e;
        transition: all 0.2s ease;
    }
    .size-chart-controls .btn-zoom:hover {
        background-color: #3a3b3e;
        color: #fff;
    }
    .size-chart-controls .zoom-percentage {
        min-width: 60px;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        color: #e0e0e0;
    }

    .top-navbar {
        background-color: white;
        z-index: 99;
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .product_name {
        font-size: 22px;
    }
    .tab-topic.active {
        color: black !important;
        font-weight: 700;
        border-bottom: 1px solid;
        padding-bottom: 1px;
    }
    .tab-topic {
        color: gray !important;
        background-color: transparent;
        border-color: transparent !important;
        padding-left: unset;
        font-size: 13px;
        font-weight: 600;
    }

    .number-input-group {
        display: flex;
        align-items: center;
        width: 85%;
    }

    .input-group-prepend,
    .input-group-append {
        display: flex;
    }

    .btn {
        width: 33px;
        height: 33px;
        padding: unset;
    }

    .form-control {
        text-align: center;
    }
    .number_input {
        padding: unset;
        height: 31px;
    }
    .text_input {
        padding: unset;
        height: 31px;
    }
    .btn-outline-secondary {
        color: white;
        border-color: unset;
        background-color: #B3B3B3;
    }
    .font_size13 {
        font-size: 13px;
    }
    .gray_font {
        color: gray;
        font-size: 13px;
    }
    .size_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: gray;
        font-size: 12px;
        font-weight: 600;
        width: 100%;
    }
    .size_div {
        width: 230px;
    }
    .input_width {
        width: 230px;
    }
    .description_div {
        width: 100%;
        padding: 10px;
        background-color: rgb(246, 246, 246);
        border: unset;
    }
    .sub_btn {
        width: 100px;
        height: 38px;
    }
    .total_qty {
        padding-top: 10px;
        font-weight: 700;
    }
    .width250px {
        width: 31%;
    }
    .width50 {
        width: 50%;
    }
    .align_right {
        text-align: right;
    }
    .small_thumnail {
        max-width: 8%;
        min-width: 120px;
    }
    .item_details_div {
        width: 52%;
        max-width: 52%;
    }
    .small_img {
        width: 100px;
        margin-bottom: 10px;
        cursor: pointer;
        border-radius: 5px;
    }
    .carousel-inner {
        border-radius: 5px;
    }
    .sizewise_input {
        max-width: 40%;
    }
    .color-box {
        display: inline-block;
        cursor: pointer;
        width: 30px;
        height: 30px;
        border-radius: 5px;
        margin-right: 10px;
        transition: border 0.3s ease;
    }
    .color-box.active {
        border: 2px solid rgb(149, 224, 241);
        box-shadow: 0px 0px 10px 5px rgb(155 194 203 / 50%);
    }

    @media (max-width: 818px) {
        .large_thumnail_div {
            width: 70%;
            max-width: 70%;
            min-width: 70%;
        }
        .sizewise_input {
            max-width: 50%;
        }
        .item_details_div {
            width: 100%;
            max-width: 100%;
        }

    }
    @media (max-width: 574px) {
        .large_thumnail_div {
            width: 100%;
            max-width: 100%;
            min-width: 100%;
            margin-top: 10px;
        }
        #defaultThumbnail {
            display: flex;
            justify-content: center; /* Center the thumbnails horizontally */
        }

        #defaultThumbnail .carousel-thumbnails {
            flex-direction: row !important; /* Display thumbnails horizontally */
            justify-content: center; /* Center the thumbnails horizontally */
            overflow-x: auto; /* Allow horizontal scrolling */
            white-space: nowrap; /* Prevent wrapping of thumbnails */
            scrollbar-width: thin; /* For Firefox, make scrollbar thinner */
            max-width: 100%; /* Ensure the container does not exceed screen width */
        }

        #defaultThumbnail .carousel-thumbnails img {
            margin-bottom: 0 !important; /* Remove bottom margin for horizontal layout */
            margin-right: 10px; /* Add space between thumbnails */
        }

        /* Customize scrollbar for WebKit browsers (Chrome, Safari) */
        #defaultThumbnail .carousel-thumbnails::-webkit-scrollbar {
            height: 8px; /* Set height of the horizontal scrollbar */
        }

        #defaultThumbnail .carousel-thumbnails::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.3); /* Thumb color */
            border-radius: 10px; /* Rounded scrollbar */
        }
        .small_thumnail {
            max-width: 100%;
        }
        .small_img {
            width: 85px;
            margin-bottom: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    }


    /* Theme colour change */
    .store-light-theme {
        background-color: white !important;
        color: black !important;
    }

    /* Dark Theme */
    .store-dark-theme {
        background-color: #121212 !important;
        color: white !important;
    }
    .store_products_dark {
        background-color: rgb(37, 37, 37) !important;
    }
    .input_dark {
        background-color: transparent !important;
        color: white !important;
    }
    .tab-topic-dark.active {
        background-color: transparent !important;
        color: white !important;
    }
    .minPus_btn_dark {
        background-color: rgb(71, 71, 71) !important;
        border: unset;
    }
    .checkbox-container{
        font-size: .7rem;
        color: #717070;
        background-color: #fafafa;
        padding: 5px 0px;
        border-radius: 0.4rem;
        margin: .1rem .2rem;
    }
    .checkbox-container {
        display: inline-block;
        cursor: pointer;
        width: 2rem;
        height: 2rem;
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
    .product_name_txt{
        color: rgb(30 27 75 / var(--tw-text-opacity, 1));
        font-family: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
        font-size: 2rem;
        line-height: 2.5rem;
        font-weight: inherit;
    }
    .bg-indigo-50{
        --tw-bg-opacity: 1;
        background-color: rgb(238 242 255 / var(--tw-bg-opacity, 1));
    }
    .text-2xl {
        font-size: 1.5rem;
        line-height: 2rem;
    }
    .font-bold {
        font-weight: 700;
    }
    .duration-300 {
        transition-duration: 300ms;
    }
    .transition-all {
        transition-property: all;
        transition-timing-function:
    cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
    .shadow-lg {
        --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }
    .bg-white {
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1));
    }
    .rounded-xl {
        border-radius: 0.75rem;
    }
    .w-full {
        width: 100%;
    }
    .en-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        user-select: none;
        padding: 0.5rem 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        /* margin-bottom: 1rem; */
        border-radius: 8px;
        padding-left: 8px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        color: #334155;
        font-weight: 500;
        position: relative;
        overflow: hidden;
        transition: background-color 0.3s
    ease;
    }
    .zoom-container {
        position: relative;
        overflow: hidden;
        cursor: zoom-in;
    }

    .zoomed-img {
        transition: transform 0.2s ease;
        transform-origin: center center;
    }

    /* =========================================================
   MOBILE PRODUCT DETAILS - MODERN RESPONSIVE
   Desktop remains unchanged
   ========================================================= */

@media (max-width: 767.98px) {

    /* Main wrapper */
    .forPaymentStyles {
        /* no effect here - only if shared elsewhere */
    }

    /* Product page outer container */
    .col-lg-12[style*="padding-top: 120px"] {
        width: 100% !important;
        padding: 85px 20px 15px 20px !important;
        box-sizing: border-box !important;
    }

    /* Back button row */
    .col-lg-12[style*="padding-top: 120px"] > .row.mb-3 {
        padding-left: 0 !important;
        margin: 0 0 12px !important;
    }

    .col-lg-12[style*="padding-top: 120px"] > .row.mb-3 > .col-lg-12 {
        padding: 0 !important;
    }

    .col-lg-12[style*="padding-top: 120px"] .sub_btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 68px !important;
        height: 36px !important;
        padding: 6px 16px !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
    }


    /* =====================================================
       PRODUCT MAIN ROW
       ===================================================== */

    .col-lg-12[style*="padding-top: 120px"] > .row:not(.mb-3) {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        margin: 0 !important;
        background-color: white;
        padding: 10px;
        padding-left: 10px !important;
        border-radius: 8px;
    }


    /* =====================================================
       THUMBNAIL COLUMN
       Move thumbnails BELOW the main image
       ===================================================== */

    .small_thumbnail {
        order: 2 !important;

        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;

        padding: 0 !important;
        margin: 8px 0 0 !important;

        position: relative !important;
        z-index: 2 !important;
    }

    .small_thumbnail #defaultThumbnail {
        width: 100% !important;
    }

    .small_thumbnail .carousel-thumbnails {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: flex-start !important;

        width: 100% !important;
        max-width: 100% !important;

        overflow-x: auto !important;
        overflow-y: hidden !important;

        padding: 3px 2px 7px !important;
        margin: 0 !important;

        gap: 7px !important;

        scrollbar-width: none !important;
        -webkit-overflow-scrolling: touch !important;
    }

    .small_thumbnail .carousel-thumbnails::-webkit-scrollbar {
        display: none !important;
    }

    /* Small thumbnail images */
    .small_thumbnail .carousel-thumbnails .thumb-img {
        flex: 0 0 58px !important;

        width: 58px !important;
        height: 58px !important;

        min-width: 58px !important;
        min-height: 58px !important;

        padding: 2px !important;
        margin: 0 !important;

        object-fit: cover !important;

        border: 1px solid transparent !important;
        border-radius: 8px !important;

        background: #f7f7f7 !important;

        cursor: pointer !important;

        transition:
            border-color .2s ease,
            transform .2s ease,
            box-shadow .2s ease !important;
    }

    .small_thumbnail .carousel-thumbnails .thumb-img.active-thumb {
        border: 2px solid #222 !important;
        box-shadow: 0 2px 7px rgba(0,0,0,.12) !important;
    }

    .small_thumbnail .carousel-thumbnails .thumb-img:active {
        transform: scale(.95) !important;
    }


    /* =====================================================
       MAIN IMAGE
       ===================================================== */

    .large_thumnail_div {
        order: 1 !important;

        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;

        padding: 0 !important;
        margin: 0 !important;
    }

    .large_thumnail_div .carousel {
        width: 100% !important;
        max-width: 100% !important;

        margin: 0 auto !important;

        border-radius: 14px !important;
        overflow: hidden !important;

        background: #f7f7f7 !important;
    }

    .large_thumnail_div .carousel-inner {
        width: 100% !important;
        border-radius: 14px !important;
    }

    .large_thumnail_div .carousel-item {
        width: 100% !important;
        background: #f7f7f7 !important;
    }

    .large_thumnail_div .zoom-container {
        width: 100% !important;
        height: auto !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        overflow: hidden !important;
        border-radius: 14px !important;
        background: #f7f7f7 !important;
    }

    .large_thumnail_div .zoomed-img {
        display: block !important;

        width: 100% !important;
        height: auto !important;

        max-height: 390px !important;

        object-fit: contain !important;

        margin: 0 auto !important;
    }

    /* Hide zoom lens on mobile */
    .large_thumnail_div .zoom-lens {
        display: none !important;
    }


    /* =====================================================
       PRODUCT DETAILS
       ===================================================== */

    .item_details_div {
        order: 3 !important;

        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;

        padding: 0 !important;
        margin: 18px 0 0 !important;

        background: transparent !important;

        border-radius: 0 !important;
        box-shadow: none !important;
    }

    /* Product name */
    .item_details_div > .mt-3.mb-3 {
        margin: 0 0 10px !important;
        margin-bottom: unset !important;
    }

    .item_details_div > .mt-3.mb-3 br {
        display: none;
    }
    .item_details_div .product_name_txt {
        display: block !important;

        font-size: 21px !important;
        line-height: 1.35 !important;
        font-weight: 700 !important;

        color: #202020 !important;
    }


    /* =====================================================
       PRICE CARD
       ===================================================== */

    .item_details_div > .bg-indigo-50 {
        width: 100% !important;

        padding: 12px 0px !important;

        border-radius: 11px !important;

        box-sizing: border-box !important;
        background-color: transparent;
        /* padding-top: unset !important; */
    }

    .item_details_div > .bg-indigo-50 .text-2xl {
        font-size: 22px !important;
        line-height: 1.2 !important;
    }


    /* =====================================================
       PRICE ADDITIONS
       ===================================================== */

    .item_details_div > .row.mt-2 {
        margin: 7px 0 0 !important;
    }

    .item_details_div > .row.mt-2 > .col-md-12 {
        padding: 0 !important;
        margin: 0 !important;
    }

    .item_details_div > .row.mt-2 .mt-2 {
        width: 100% !important;

        margin-top: 6px !important;

        padding: 7px 10px !important;

        border-radius: 7px !important;

        font-size: 11px !important;
        line-height: 1.3 !important;
    }


    /* =====================================================
       COLOR VARIANTS
       ===================================================== */

    .item_details_div > div[style*="padding-top: 10px"] {
        padding-top: 13px !important;
        padding-bottom: 3px !important;
    }

    .item_details_div .color-box {
        display: inline-block !important;

        width: 27px !important;
        height: 27px !important;

        margin: 0 6px 5px 0 !important;

        border-radius: 50% !important;

        border: 2px solid #fff !important;

        box-shadow: 0 0 0 1px #d0d0d0 !important;

        vertical-align: middle !important;
    }


    /* =====================================================
       SUB TEAM
       ===================================================== */

    .item_details_div .font_size13 {
        font-size: 12px !important;
    }

    .item_details_div .size_div {
        width: 100% !important;

        padding: 0 !important;

        margin-top: 5px !important;

        border: 1px solid #dcdcdc !important;
        border-radius: 8px !important;

        overflow: hidden !important;

        background: #fff !important;
    }

    .item_details_div .size_selection {
        width: 100% !important;

        min-height: 42px !important;

        padding: 8px 10px !important;

        border: none !important;
        outline: none !important;

        font-size: 16px !important;

        background: #fff !important;
    }


    /* =====================================================
       SINGLE ITEM CARD
       ===================================================== */

    .item_details_div > .card {
        width: 100% !important;

        margin-top: 16px !important;

        padding: 0 !important;

        border: 1px solid #e6e6e6 !important;
        border-radius: 12px !important;

        background: #fff !important;

        box-shadow: 0 3px 14px rgba(0,0,0,.045) !important;
    }

    .item_details_div > .card > .nav-tabs {
        margin: 0 !important;

        padding: 0 12px !important;

        border-bottom: 1px solid #ededed !important;
    }

    .item_details_div > .card > .nav-tabs .nav-link {
        padding: 11px 3px !important;

        border: none !important;

        font-size: 12px !important;
        font-weight: 700 !important;
    }

    .item_details_div > .card > .nav-tabs .nav-item {
        border-bottom: 2px solid currentColor !important;
    }

    .item_details_div > .card > .tab-content {
        padding: 13px 12px 14px !important;
    }

    .item_details_div > .card .tab-pane {
        padding-top: 0 !important;
    }


    /* Size label */
    .item_details_div .tab-pane .font_size13 {
        display: inline-block !important;

        margin-bottom: 4px !important;

        font-size: 12px !important;
        font-weight: 600 !important;
    }


    /* =====================================================
       QUANTITY
       ===================================================== */

    .item_details_div .number-input-group {
        width: 100% !important;
        /* max-width: 230px !important; */

        height: 42px !important;

        margin-top: 5px !important;
    }

    .item_details_div .number-input-group .btn {
        width: 42px !important;
        height: 42px !important;

        padding: 0 !important;

        font-size: 18px !important;
        line-height: 42px !important;

        /* border-radius: 0 !important; */
    }

    .btn.btn-outline-secondary.minus-btn {
        border-radius: 5px 0px 0px 5px !important;
    }
    .btn.btn-outline-secondary.plus-btn {
        border-radius: 0px 5px 5px 0px !important;
    }
    .item_details_div .number_input_single {
        height: 42px !important;

        text-align: center !important;

        font-size: 16px !important;
        font-weight: 600 !important;

        border-radius: 0 !important;
    }


    /* MOQ / Max quantity */
    .item_details_div .gray_font {
        display: inline-block !important;

        font-size: 10px !important;
        line-height: 1.5 !important;
    }


    /* =====================================================
       TOTAL QUANTITY
       ===================================================== */

    .item_details_div .width250px {
        width: 100% !important;

        margin: 0 !important;
        padding: 11px !important;
    }

    .item_details_div .total_qty {
        font-size: 13px !important;
        font-weight: 700 !important;
    }


    /* =====================================================
       CUSTOMIZE ITEM
       ===================================================== */

    .item_details_div #customize_number_single,
    .item_details_div #customize_name_single {
        width: 100% !important;
        height: 42px !important;

        margin-top: 5px !important;

        border-radius: 8px !important;

        font-size: 16px !important;
    }

    .item_details_div .view_available_numbers {
        display: inline-block !important;

        margin-top: 4px !important;

        font-size: 10px !important;
    }


    /* =====================================================
       ADD TO CART
       ===================================================== */

    .item_details_div .add_to_cart_button {
        width: 100% !important;

        height: 46px !important;

        margin-top: 3px !important;

        padding: 8px 15px !important;

        border: none !important;
        border-radius: 9px !important;

        font-size: 13px !important;
        font-weight: 700 !important;

        box-shadow: 0 4px 10px rgba(0,0,0,.10) !important;
    }


    /* =====================================================
       PRODUCT DETAILS ACCORDION
       ===================================================== */

    .item_details_div .col-md-12.p-0 {
        padding-bottom: 10px !important;
    }

    .item_details_div .description_div {
        margin-top: 0 !important;

        border: 1px solid #e5e5e5 !important;
        border-radius: 10px !important;

        box-shadow: none !important;

        overflow: hidden !important;
    }

    .item_details_div .description_div .en-section-header {
        min-height: 46px !important;

        padding: 10px 12px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;

        font-size: 13px !important;
    }

    .item_details_div .description_div h2 {
        margin: 0 !important;

        font-size: 13px !important;
        font-weight: 700 !important;
    }

    .item_details_div .description-content {
        margin: 10px 12px !important;

        font-size: 12px !important;
        line-height: 1.6 !important;
    }


    /* =====================================================
       AVAILABLE NUMBERS MODAL
       ===================================================== */

    #display_available_numbers .modal-dialog {
        width: calc(100% - 24px) !important;

        max-width: none !important;

        margin: 12px auto !important;
    }

    #display_available_numbers .modal-content {
        border: none !important;
        border-radius: 14px !important;
        overflow: hidden !important;
    }

    #display_available_numbers .modal-header {
        padding: 13px 15px !important;
    }

    #display_available_numbers .modal-title {
        font-size: 16px !important;
        font-weight: 700 !important;
    }

    #display_available_numbers .modal-body {
        padding: 12px !important;
    }

    #display_available_numbers .modal-footer {
        padding: 10px 12px !important;
    }

    #display_available_numbers .modal-footer button {
        width: 70px !important;
        height: 36px !important;

        padding: 5px !important;

        border-radius: 7px !important;

        font-size: 12px !important;
    }

    #availableNumbersBody {
        max-height: 45vh !important;
        overflow-y: auto !important;
        overflow-x: auto !important;
    }
    .padding_l_r_10 {
        padding: 0px 10px !important;
    }
    .mobile_margin_top_10 {
        margin-top: 10px !important;
    }
}


/* =========================================================
   VERY SMALL PHONES
   ========================================================= */

@media (max-width: 380px) {

    .col-lg-12[style*="padding-top: 120px"] {
        padding-left: 8px !important;
        padding-right: 8px !important;
    }

    .large_thumnail_div .zoomed-img {
        max-height: 330px !important;
    }

    .small_thumbnail .carousel-thumbnails .thumb-img {
        width: 52px !important;
        height: 52px !important;
        min-width: 52px !important;
        min-height: 52px !important;
    }

    .item_details_div .product_name_txt {
        font-size: 19px !important;
    }

    .item_details_div > .bg-indigo-50 .text-2xl {
        font-size: 20px !important;
    }

    .item_details_div .number-input-group {
        max-width: 210px !important;
    }
}

/* =========================================================
   SIZE CHART MODAL
   ========================================================= */

#sizeChartModal .modal-dialog {
    max-width: 90vw;
    width: 90vw;
    margin: 1.5rem auto;
}

#sizeChartModal .modal-content {
    background-color: #18191a;
    color: #fff;
    border: 1px solid #333;
    border-radius: 12px;
    overflow: hidden;
}

#sizeChartModal .modal-header {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    border-bottom: 1px solid #333;
}

#sizeChartModal .modal-title {
    font-size: 16px;
    font-weight: 600;
    margin-right: auto;
}

#sizeChartModal .modal-header .close {
    color: #fff;
    opacity: .8;
    font-size: 25px;
    margin-left: 8px;
}

#sizeChartModal .modal-header .close:hover {
    color: #fff;
    opacity: 1;
}

#sizeChartModal .modal-body {
    position: relative;

    padding: 15px;

    background-color: #0f0f10;

    height: 78vh;
    min-height: 400px;

    overflow: hidden;

    display: flex;
    align-items: center;
    justify-content: center;

    user-select: none;
}

#sizeChartModal .size-chart-image-container {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    cursor: grab;
}

#sizeChartModal .size-chart-image-container:active {
    cursor: grabbing;
}

#sizeChartModal .size-chart-full-img {
    display: block;

    max-width: 100%;
    max-height: 100%;

    width: auto;
    height: auto;

    object-fit: contain;

    transform-origin: center center;

    transition: transform .15s ease-out;

    cursor: grab;
}

#sizeChartModal .size-chart-full-img:active {
    cursor: grabbing;
}


/* Zoom buttons */

#sizeChartModal .size-chart-controls {
    margin-left: 15px;
}

#sizeChartModal .btn-zoom {
    width: 36px !important;
    height: 36px !important;

    padding: 0 !important;

    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;

    border-radius: 6px !important;

    font-size: 13px !important;

    background-color: #2a2b2d !important;
    color: #fff !important;

    border: 1px solid #3a3b3e !important;

    transition: all .2s ease;
}

#sizeChartModal .btn-zoom:hover {
    background-color: #3a3b3e !important;
    color: #fff !important;
}

#sizeChartModal .zoom-percentage {
    min-width: 55px;

    text-align: center;

    font-size: 12px;
    font-weight: 600;

    color: #e0e0e0;
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 767.98px) {

    #sizeChartModal .modal-dialog {
        width: calc(100% - 16px) !important;
        max-width: none !important;

        margin: 8px auto !important;
    }

    #sizeChartModal .modal-content {
        border-radius: 10px !important;
    }

    #sizeChartModal .modal-header {
        padding: 8px 10px !important;
    }

    #sizeChartModal .modal-title {
        font-size: 14px !important;
    }

    #sizeChartModal .modal-body {
        height: 80vh !important;
        min-height: 300px !important;

        padding: 8px !important;
    }

    #sizeChartModal .size-chart-controls {
        margin-left: 5px !important;
    }

    #sizeChartModal .btn-zoom {
        width: 32px !important;
        height: 32px !important;

        font-size: 11px !important;
    }

    #sizeChartModal .zoom-percentage {
        min-width: 45px !important;

        font-size: 10px !important;
    }

    #sizeChartModal .modal-header .close {
        font-size: 22px !important;
    }

}

    /* End Theme colour change */

</style>

<div class="navbar top-navbar col-12 col-lg-12 {{ $teamStore->theme == 1 ? 'top_nav_dark' : '' }}" style=" background-color:white; z-index:99; padding:0">

    @include('pages.customer_team_store.layouts.header')

</div>

<div class="col-lg-12" style="padding-top: 120px;">
    <div class="row mb-3"style="padding-left: 6%">
        <div class="col-lg-12">
            <a href="{{ makeStoreDomainRoute($store->direct_access_url.(request()->has('view-only') && request()->query('view-only') == 'true' ? '?view-only=true' : '')) }}" class="btn btn-secondary sub_btn" style="background-color: {{ $teamStore->primary_color ?? 'black' }}; border: unset;height: auto;">Back</a>
        </div>

    </div>
    <div class="row" style="padding-left: 6%">
        <!-- Thumbnail Column -->
        <div class="col-lg-1 col-md-2 col-sm-2 image-position-small small_thumbnail">
            <div id="defaultThumbnail">
                <div class="carousel-thumbnails flex-column justify-content-center mt-2 thumbnail-style" style="width: fit-content">
                    {{-- @foreach ($product->images as $key => $item)
                        <img src="{{ asset(optional($item)->url ?? 'assets/img/products/default-loading.gif') }}" alt="Product Image" class="d-block w-100 img-fluid varients_img_{{$item->variant}}" onclick="goToSlide({{ $key }})" style="cursor: pointer;">
                    @endforeach --}}
                </div>
            </div>
        </div>

        <!-- Main Image Column -->
        <div class="col-lg-4 col-md-4 col-sm-4 image-position large_thumnail_div">
            <div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000" style="width: 100%;">
                <div id="crouselDefault">
                    <div class="carousel-inner">
                        {{-- @foreach ($product->images as $key => $item)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ asset(optional($item)->url ?? 'assets/img/products/default-loading.gif') }}" alt="Product Image" class="d-block w-100 img-fluid varients_img_{{$item->variant}}">
                            </div>
                        @endforeach --}}
                    </div>
                </div>
            </div>
        </div>

        @php
            $sumOfAddition = $product->priceAdditions->sum('addition_amount');
            $sumWithAddition = $sumOfAddition + $product->default_price;

            $sizeChart = null;
            if(isset($product->products) && !empty($product->products->size_chart)) {
                $sizeChart = asset($product->products->size_chart);
            }else if(isset($product->products->productDetails) && !empty($product->products->productDetails->size_chart)) {
                $sizeChart = asset('assets/'.$product->products->productDetails->size_chart);
            }
        @endphp


        <div class="col-lg-7 item_details_div w-full lg:mt-0 bg-white rounded-xl transition-all duration-300 hover:shadow-xl">
            <div class="mt-3 mb-3">
                <b class="product_name_txt">{{ $product->product_name }}</b><br>
            </div>
            <div class="bg-indigo-50 rounded-xl" style="padding: 1rem; width:100%;">
                <span class="text-2xl font-bold text-indigo-950">$ {{ number_format($sumWithAddition, 2) }}</span>
            </div>

            <div class="row mt-2">
                <div class="col-md-12 mb-2">
                    @foreach ($product->priceAdditions as $addition)
                        @if ($addition->hide_from_customer != 1)
                            <div class="mt-2" style="background-color:#f1f1f1;padding: .2rem 1rem;width: 81%;">{{$addition->addition_value}}{{$addition->is_addition_value == 1 ? '$' : '%'}} - {{$addition->price_addition_name}}</div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div style="padding-top: 10px;">
                @foreach ($productVariants as $productVariant)
                    <span class="color-box"
                          style="background-color: {{ $productVariant->variant->variant_value }};"
                          data-variant-value="{{ $productVariant->variant->variant_value }}">
                    </span>
                @endforeach
            </div>
            @if (!empty($sub_team_info))
                <div class="mb-2">
                    <span class="font_size13">Sub Team</span><br>
                    <div class="size_div" style="border: 1px solid #b3b3b3;padding:.1rem">
                        <select id="subTeam" class="size_selection">
                            <option value="">Select a sub team</option>
                            @foreach (json_decode($sub_team_info->options, true) as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <div class="card {{ $teamStore->theme == 1 ? 'store-dark-theme' : 'store-light-theme' }}" style="border: unset; width: 100%; padding: 10px; padding-left: unset;">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="border-bottom: 1px solid lightgray; margin-bottom: 5px;">
                    <li class="nav-item" style="border-bottom: 2px solid black;">
                        <a class="nav-link tab-topic active {{ $teamStore->theme == 1 ? 'tab-topic-dark' : '' }}" style="" id="single-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Single Item</a>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="single-tab" style="padding-top: 7px;">
                                <!-- Content for Tab 1 -->
                                <div>
                                    <span class="font_size13">Size</span><br>

                                    <div class="size_div" style="border: 1px solid #b3b3b3;padding:.1rem">
                                        <select id="productSize" class="size_selection">
                                            <option value="">Select a size</option>
                                            @foreach ($product->sizes as $storeProductSize)
                                                @if ($storeProductSize->size)
                                                    <option value="{{ $storeProductSize->size->id }}">{{ $storeProductSize->size->size_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <span style="padding-top: 7px;" class="font_size13">Quantity</span>

                                <div class="input-group number-input-group" style="width: 230px;">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary minus-btn {{ $teamStore->theme == 1 ? 'minPus_btn_dark' : '' }}">-</button>
                                    </div>
                                    <input type="number" class="form-control number_input number_input_single {{ $teamStore->theme == 1 ? 'input_dark' : '' }}" id="single_sizes" step="1" value="{{$product->moq}}" min="{{$product->moq}}" max="{{$product->maxoq ?? ''}}">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary plus-btn {{ $teamStore->theme == 1 ? 'minPus_btn_dark' : '' }}">+</button>
                                    </div>
                                </div>

                                <div>
                                    <span class="gray_font">Minimum order quantity : </span>
                                    <span class="gray_font"> {{$product->moq ?? 1}} Item</span>
                                </div>
                                <div>
                                    <span class="gray_font">Maximum order quantity : </span>
                                    <span class="gray_font"> {{$product->maxoq ?? 'Unlimited'}} Item</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-left: unset; padding-top: 10px;">
                            <div style="width: 100%">
                                <span class="total_qty">Total Quantity</span><span class="total_qty" id="total_qty"> - {{$product->moq}}</span>
                            </div>
                        </div>



                        <div class="padding_l_r_10" style="padding-top: 10px;">
                            @if ($product->set_individual_name == 1 || $product->set_individual_number == 1)
                                <span class="font_size13" style="font-weight: 700;">Customize Item</span><br>
                            @endif

                            @if ($product->set_individual_number == 1 && $product->IndividualNumberDetails)
                                <span class="font_size13" >Add Number</span><br>
                                <input title="Number Range : {{ optional($product->IndividualNumberDetails)->min_number }} to {{ optional($product->IndividualNumberDetails)->max_number }} <br>
                                Numer Count : {{ optional($product->IndividualNumberDetails)->min_number_count }} to {{ optional($product->IndividualNumberDetails)->max_number_count }}"
                                data-bs-toggle="tooltip"
                                data-bs-html="true"
                                type="{{ optional($product->IndividualNumberDetails)->number_type === 'custom' ? 'text' : 'number' }}" class="form-control number_input input_width {{ $teamStore->theme == 1 ? 'input_dark' : '' }}" id="customize_number_single"  maxlength="{{$product->IndividualNumberDetails->max_number_count ?? 5}}" min="0" {{$product->IndividualNumberDetails->number_required == 1 ? 'required' : ''}} >
                                <a href="" class="gray_font view_available_numbers">View number list</a>
                            @endif
                        </div>
                        <div class="padding_l_r_10 mobile_margin_top_10" style="padding-top: 10px;">
                            @if ($product->set_individual_name == 1 && $product->IndividualNameDetails)
                                <span class="font_size13" >Add Name</span><br>
                                <input title="Character Limit : {{ $product->IndividualNameDetails->name_character_limit }}"
                                data-bs-toggle="tooltip"
                                data-bs-html="true"
                                type="text" class="form-control text_input input_width {{ $teamStore->theme == 1 ? 'input_dark' : '' }}" id="customize_name_single" maxlength="{{$product->IndividualNameDetails->name_character_limit ?? 10}}" {{$product->IndividualNameDetails->name_required == 1 ? 'required' : ''}} >
                                @if ($product->IndividualNameDetails->name_not_for_printing == 1)
                                    <span class="text-danger" style="font-size: .8rem;">(Not for printing)</span>
                                @endif
                            @endif
                        </div>
                    </div>
                    {{-- <div class="col-md-8 mt-3">
                        @if (!empty($sizeChart))
                            <div class="size-chart-wrapper position-relative text-center" style="cursor: pointer; margin-left: 7%;" data-toggle="modal" data-target="#sizeChartModal" data-bs-toggle="modal" data-bs-target="#sizeChartModal" title="Click to view size chart">
                                <img src="{{ $sizeChart }}" alt="Size Chart" class="img-fluid w-100 rounded border size-chart-img-thumb">
                                <div class="size-chart-hover-overlay">
                                    <span class="badge badge-dark bg-dark text-white px-3 py-2 shadow">
                                        <i class="fas fa-search-plus mr-1"></i> Click to view & zoom
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div> --}}
                    <div class="col-md-8 mt-3">
                        @if (!empty($sizeChart))
                            <div class="size-chart-wrapper position-relative text-center"
                                style="cursor: pointer; margin-left: 7%;"
                                data-toggle="modal"
                                data-target="#sizeChartModal"
                                title="Click to view & zoom">

                                <img src="{{ $sizeChart }}"
                                    alt="Size Chart"
                                    class="img-fluid w-100 rounded border size-chart-img-thumb">

                                <div class="size-chart-hover-overlay">
                                    <span class="badge badge-dark bg-dark text-white px-3 py-2 shadow">
                                        <i class="fas fa-search-plus mr-1"></i>
                                        Click to view & zoom
                                    </span>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>

                @if(!(request()->has('view-only') && request()->query('view-only') == 'true'))
                    <div class="padding_l_r_10 mobile_margin_top_10" style="padding-top: 30px;">
                        <button class="btn btn-success input_width font_size13 add_to_cart_button" type="button" style="background-color: {{ $teamStore->primary_color ?? 'black' }}; border: unset;">{{ request()->query('item_id') ? 'Update Product' : 'Add To Cart' }}</button>
                    </div>
                </div>
                @endif

                <div class="col-md-12 p-0 padding_l_r_10">
                    <div style="padding-top: 30px;">
                            <div class="card description_div {{ $teamStore->theme == 1 ? 'store_products_dark' : '' }}">
                                <div class="en-section-header description-toggle" style="font-size: 16px;">
                                    <div class="d-flex align-items-center">
                                    <i class="fas fa-tags" style="font-size: 85%;" aria-hidden="true"></i>
                                    <h2 style="font-size: 1rem;"> &nbsp; Product Details</h2>
                                    </div>
                                    <div class="en-toggle-icon" id="en-toggle-icon-product-details">
                                        <i class="fa fas fa-plus" aria-hidden="true"></i>
                                    </div>
                                </div>

                                @php
                                    $description = $product->style;
                                    $cleanedDescription = preg_replace('/<p><br><\/p>/i', '', $description);
                                @endphp

                                @if (!empty(strip_tags($cleanedDescription)))
                                    <div class="description-content" style="font-size: 13px; margin: 0.8rem 1rem 0.8rem 1.5rem; color: grey;">
                                        {!! $cleanedDescription !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                </div>

            </div>
        </div>
    </div>
</div>
<input type="hidden" name="product_id" id="product-id-primary" value="{{ $product->id }}">
<input type="hidden" id="saved_cart_item_id" value="{{ request()->query('item_id') ?? '' }}">

<div class="modal fade" id="display_available_numbers" tabindex="-1" role="dialog" aria-labelledby="availableNumbersLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content {{ $teamStore->theme == 1 ? 'modal_dark' : '' }}">
            <div class="modal-header">
                <h5 class="modal-title {{ $teamStore->theme == 1 ? 'modal_dark' : '' }}" id="availableNumbersLabel">
                    Number List
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="{{ $teamStore->theme == 1 ? 'modal_dark' : '' }}" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row" style="margin: unset;">
                <div class="col-md-12 pl-1">
                    <label class="checkbox-container" style="width: 4rem;background-color: #f3d8d8;color: #e7a3a3;border: 1px solid #e7a3a3;">
                        Excluded
                    </label>
                    <label class="checkbox-container" style="width: 4rem;background-color: #d8f3db;color: #77db9f;border: 1px solid #77db9f;">
                        Ordered
                    </label>
                    <label class="checkbox-container" style="width: 4rem;">
                        Available
                    </label>
                </div>
                <div class="col-md-12 mt-2 mb-2 pl-2">
                    <input type="{{ optional($product->IndividualNumberDetails)->number_type === 'custom' ? 'text' : 'number' }}" id="input_custom_number" placeholder="Input Your Choise" @if ($product->set_individual_number == 1) maxlength="{{$product->IndividualNumberDetails->max_number_count ?? 5}}" @endif value="" class="form-control text-left" style="height: calc(1em + .75rem + 2px);" />
                </div>
                <div class="container" style="border: none !important;padding:5px">
                    <div class="card" style="border: 1px solid lightgrey;min-height: 10rem;display: inline-block;max-height: 25rem;overflow-x: scroll;min-width: 100%;" id="availableNumbersBody">

                    </div>
                </div>
            </div>
            <div class="modal-footer modal_footer">
                <button type="button" class="btn btn-secondary" style="width: 4rem;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@if (!empty($sizeChart))
<div class="modal fade"
     id="sizeChartModal"
     tabindex="-1"
     role="dialog"
     aria-labelledby="sizeChartModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="sizeChartModalLabel">
                    Size Chart
                </h5>

                <div class="size-chart-controls d-flex align-items-center">

                    <button type="button"
                            class="btn-zoom size-chart-zoom-out mr-1"
                            title="Zoom out">
                        <i class="fas fa-minus"></i>
                    </button>

                    <span class="zoom-percentage">
                        100%
                    </span>

                    <button type="button"
                            class="btn-zoom size-chart-zoom-in ml-1"
                            title="Zoom in">
                        <i class="fas fa-plus"></i>
                    </button>

                    <button type="button"
                            class="btn-zoom size-chart-zoom-reset ml-1"
                            title="Reset zoom">
                        <i class="fas fa-sync-alt"></i>
                    </button>

                </div>

                <button type="button"
                        class="close ml-2"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body size-chart-modal-body">

                <div class="size-chart-image-container">

                    <img src="{{ $sizeChart }}"
                         alt="Size Chart"
                         id="sizeChartFullImage"
                         class="size-chart-full-img">

                </div>

            </div>

        </div>

    </div>
</div>
@endif

@php
    $images = $product->images;
@endphp

@include('pages.customer_team_store.layouts.footer')

@if (request()->query('item_id'))

    <script>
        updateSavedProductDetails();
        function updateSavedProductDetails(){

            var cartItemId = $('#saved_cart_item_id').val();

            getCartProductDetails(cartItemId, function(cartDetails) {

                if ($('#subTeam').length && cartDetails) {
                    $('#subTeam').val(cartDetails.sub_team ?? '').trigger('change');
                }

                cartDetails.store_cart_items.forEach(element => {
                    if(element.type == 1){
                        $('#single_sizes').val(element.qty);
                        $('#productSize').val(element.size_id).trigger('change');
                    }

                    if(cartDetails.store_product && cartDetails.store_product.set_individual_name == 1){
                        $('#customize_name_single').val(cartDetails.store_cart_items[0].custom_name);
                    }
                    if(cartDetails.store_product && cartDetails.store_product.set_individual_number == 1){
                        $('#customize_number_single').val(cartDetails.store_cart_items[0].custom_number);
                    }
                });

            });
        }
        function getCartProductDetails(cartItemId, callback) {
            $.ajax({
                url: "{{ makeStoreDomainRoute('GetCustomerTeamStoreCart') }}",
                method: 'GET',
                data: {
                    store_id: '{{$store->id}}',
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {

                    var filteredItem = data.find(item => item.id == cartItemId);

                    if (callback) {
                        callback(filteredItem);
                    }
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    </script>

@endif

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

@if ($product->set_individual_number == 1)
    <script>

        $('[data-bs-toggle="tooltip"]').tooltip({
            html: true
        });

        function updateAvailableNumbers(){

            if ($('#subTeam').length && $('#subTeam').val() === '') {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Please select sub team first',
                    showConfirmButton: false,
                    timer: 4000,
                    toast: true
                });
                return;
            }
            $(".se-pre-con").fadeIn('slow');

            var subTeam = ($('#subTeam').length && $('#subTeam').val() !== '') ? $('#subTeam').val() : null;

            $.ajax({
                url: "{{ makeStoreDomainRoute('get_available_numbers') }}",
                method: 'GET',
                data: {
                    'store_product_id': '{{$product->id}}',
                    'sub_team': subTeam,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);

                    var availableNumbersBody = $('#availableNumbersBody');
                    availableNumbersBody.empty();

                    var numberList = response.number_list;
                    var orderedNumbers = response.orderedNumbers;
                    var exclusiveNumbers = response.exclusiveNumbers;
                    var productNumberDetails = response.store_product_details.individual_number_details;

                    $('#input_custom_number, #customize_number_single').attr('maxLength', response.max_number_count ?? 5);

                    if (productNumberDetails.number_type != "custom") {
                        $.each(numberList, function(index, number) {
                            var isOrderedExists = orderedNumbers.some(function(item) {
                                return String(item) === String(number) && response.numberExlusive == 1;
                            });

                            var isExclusive = exclusiveNumbers.some(function(item) {
                                return String(item) === String(number);
                            });

                            var styleText = ``;

                            if (isOrderedExists) {
                                styleText = `background-color: #d8f3db;color: #77db9f;border: 1px solid #77db9f;`;
                            }
                            if (isExclusive) {
                                styleText = `background-color: #f3d8d8;color: #e7a3a3;border: 1px solid #e7a3a3;`;
                            }

                            var className = isOrderedExists || isExclusive ? 'disabled' : '';

                            var content = `
                            <label class="checkbox-container ${className}" style="${styleText}" value="${number}">
                                <input type="checkbox" name="numbers[]" value="${number}" ${className}>
                                ${number}
                            </label>`;

                            $('#availableNumbersBody').append(content);
                        });
                    }else{
                        $.each([...orderedNumbers, ...exclusiveNumbers], function(index, number) {
                            var isOrderedExists = orderedNumbers.some(function(item) {
                                return String(item) === String(number) && response.numberExlusive == 1;
                            });

                            var isExclusive = exclusiveNumbers.some(function(item) {
                                return String(item) === String(number);
                            });

                            var styleText = ``;

                            if (isOrderedExists) {
                                styleText = `background-color: #d8f3db;color: #77db9f;border: 1px solid #77db9f;`;
                            }
                            if (isExclusive) {
                                styleText = `background-color: #f3d8d8;color: #e7a3a3;border: 1px solid #e7a3a3;`;
                            }

                            var className = isOrderedExists || isExclusive ? 'disabled' : '';

                            var content = `
                            <label class="checkbox-container ${className}" style="${styleText}" value="${number}">
                                <input type="checkbox" name="numbers[]" value="${number}" ${className}>
                                ${number}
                            </label>`;

                            $('#availableNumbersBody').append(content);
                        });
                    }

                    $(".se-pre-con").fadeOut('slow');


                    $('#availableNumbersBody input[type="checkbox"]').change(function() {
                        if ($(this).is(':checked')) {

                            $('#availableNumbersBody input[type="checkbox"]').not(this).prop('checked', false).closest('label').removeClass('checked');
                            $('#input_custom_number, #customize_number_single').val($(this).val()).trigger('change');
                            $(this).closest('label').addClass('checked');

                        } else {

                            $(this).closest('label').removeClass('checked');
                            $('#input_custom_number, #customize_number_single').val('');

                        }
                    });

                    $('#display_available_numbers').modal('show');
                },
                error: function(xhr) {
                    console.error('Failed to fetch available numbers:', xhr.responseText);
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }
        $(document).ready(function() {
            $(document).on('change', '#input_custom_number, #customize_number_single', function() {
                validateInputNumber($(this).val());
            });
        });

        function validateInputNumber(value) {

            if ($('#subTeam').length && $('#subTeam').val() === '') {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Please select sub team first',
                    showConfirmButton: false,
                    timer: 4000,
                    toast: true
                });
                return;
            }

            var subTeam = ($('#subTeam').length && $('#subTeam').val() !== '') ? $('#subTeam').val() : null;

            var inputData = {
                customNumber: value,
                team_name: subTeam,
                store_product_id: '{{$product->id}}',
                _token: "{{ csrf_token() }}"
            };

            $(".se-pre-con").fadeIn('slow');

            $.ajax({
                url: "{{ makeStoreDomainRoute('validateCustomerInputNumber') }}",
                method: 'POST',
                data: inputData,
                success: function(response) {
                    console.log(response);
                    $('.checkbox-container.checked').removeClass('checked');

                    $('#input_custom_number, #customize_number_single').removeClass('is-invalid').addClass('is-valid').val(value);
                    $(".se-pre-con").fadeOut('slow');
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    console.error('Validation failed:', response?.error || 'Unknown error');

                    $('#input_custom_number, #customize_number_single').removeClass('is-valid').addClass('is-invalid').val(value);
                    $(".se-pre-con").fadeOut('slow');

                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: response?.error || 'Invalid number',
                        showConfirmButton: false,
                        timer: 4000,
                        toast: true
                    });
                }
            });
        }

    </script>
@endif
@if ($product->set_individual_name == 1)
    <script>
        $(document).ready(function() {
            $(document).on('change', '#customize_name_single', function() {
                validateInputName($(this).val());
            });
        });

        function validateInputName(value) {

            if ($('#subTeam').length && $('#subTeam').val() === '') {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Please select sub team first',
                    showConfirmButton: false,
                    timer: 4000,
                    toast: true
                });

                return;
            }

            var subTeam = ($('#subTeam').length && $('#subTeam').val() !== '') ? $('#subTeam').val() : null;

            var inputData = {
                customName: value,
                sub_team: subTeam,
                store_product_id: '{{$product->id}}',
                _token: "{{ csrf_token() }}"
            };

            $(".se-pre-con").fadeIn('slow');

            $.ajax({
                url: "{{ makeStoreDomainRoute('validateCustomerInputName') }}",
                method: 'POST',
                data: inputData,
                success: function(response) {
                    $('#customize_name_single').removeClass('is-invalid').addClass('is-valid').val(value);
                    $(".se-pre-con").fadeOut('slow');
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    console.error('Validation failed:', response?.error || 'Unknown error');
                    $('#customize_name_single').removeClass('is-valid').addClass('is-invalid').val(value);
                    $(".se-pre-con").fadeOut('slow');

                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: response?.error || 'Invalid name',
                        showConfirmButton: false,
                        timer: 4000,
                        toast: true
                    });
                }
            });
        }

    </script>
@endif


<script>

    $(document).ready(function() {

            var images = @json($images);
            appendImages(images);

            $('.minus-btn').on('click', function () {
                const input = $(this).closest('.input-group').find('input');
                const value = parseInt(input.val(), 10) || 0;
                const min = parseInt(input.attr('min'), 10) || 0;

                if (value <= min) {
                    input.val(min);
                    return;
                }

                input.val(value - 1).trigger('input');
            });

            $('.plus-btn').on('click', function () {
                const input = $(this).closest('.input-group').find('input');
                const value = parseInt(input.val(), 10) || 0;
                const max = parseInt(input.attr('max'), 10);

                if (!isNaN(max) && value >= max) {
                    input.val(max);
                    return;
                }

                input.val(value + 1).trigger('input');
            });

            $('.number_input_single').on('input', function() {
                var totalQty = parseInt($(this).val()) || 0;
                var minQty = parseInt($(this).attr('min')) || 0;
                var maxQty = parseInt($(this).attr('max'));
                if (!isNaN(maxQty) && totalQty > maxQty) {
                    totalQty = maxQty;
                    $(this).val(maxQty);
                }
                if (totalQty < minQty) {
                    totalQty = minQty;
                    $(this).val(minQty);
                }

                $('#total_qty').text(' - '+totalQty);
            });

        $(document).on('click', '.color-box', function() {
            var variantValue = $(this).data('variant-value');

            var images = @json($images);

            if ($(this).hasClass('active')) {
                appendImages(images);
                $(this).removeClass('active');
            } else {
                var filteredImages = images.filter(function(item) {
                    return item.variant == variantValue;
                });
                appendImages(filteredImages);
                $('.color-box').removeClass('active');
                $(this).addClass('active');
            }
        });

        $(document).on('click', '.add_to_cart_button', function() {
            var multyValuesFilled = false;
            var singleValuesFilled = false;

            if ($('#subTeam').length && $('#subTeam').val() === '') {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Please select sub team first',
                    showConfirmButton: false,
                    timer: 4000,
                    toast: true
                });
                return;
            }
            if ($('#customize_number_single').length && $('#customize_number_single').prop('required') && $('#customize_number_single').val() === '') {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Please input number',
                    showConfirmButton: false,
                    timer: 4000,
                    toast: true
                });
                return;
            }
            if ($('#customize_name_single').length && $('#customize_name_single').prop('required') && $('#customize_name_single').val() === '') {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'Please input name',
                    showConfirmButton: false,
                    timer: 4000,
                    toast: true
                });
                return;
            }

            $('.number_input_single').each(function() {
                if ($(this).val() !== '' && $(this).val() !== 0) {
                    singleValuesFilled = true;
                }
            });

            if (singleValuesFilled) {
                saveCartSizes();
            }else {
                Swal.fire("Error", "Please fill in size quantities.", "error");
            }
        });

        $(document).on("click", ".view_available_numbers", function (e) {
            e.preventDefault();
            updateAvailableNumbers();
        });

        $(document).on('click', '.description-toggle', function() {
            const $icon = $(this).find('.toggle-description-icon');
            const $desc = $(this).siblings('.description-content');

            $desc.slideToggle(200);

            $icon.toggleClass('fa-chevron-down fa-chevron-up');
        });
        $(document).on('mousemove', '.zoom-container', function(e) {
            var $container = $(this);
            var $img = $container.find('.zoomed-img');
            var $lens = $container.find('.zoom-lens');
            var $carousel = $('#carouselExample');

            // Pause carousel while zooming
            $carousel.carousel('pause');

            var containerOffset = $container.offset();
            var x = e.pageX - containerOffset.left;
            var y = e.pageY - containerOffset.top;
            var containerWidth = $container.width();
            var containerHeight = $container.height();

            var zoomScale = 2;
            var lensSize = $lens.width() / 2;

            $lens.show();

            var lensX = x - lensSize;
            var lensY = y - lensSize;

            lensX = Math.max(0, Math.min(lensX, containerWidth - $lens.width()));
            lensY = Math.max(0, Math.min(lensY, containerHeight - $lens.height()));

            $lens.css({
                left: lensX + 'px',
                top: lensY + 'px'
            });

            var zoomX = ((x / containerWidth) * 100).toFixed(2);
            var zoomY = ((y / containerHeight) * 100).toFixed(2);

            $img.css({
                transform: `scale(${zoomScale})`,
                'transform-origin': `${zoomX}% ${zoomY}%`
            });
        });

        $(document).on('mouseleave', '.zoom-container', function() {
            var $img = $(this).find('.zoomed-img');
            var $lens = $(this).find('.zoom-lens');
            var $carousel = $('#carouselExample');

            $img.css('transform', 'scale(1)');
            $lens.hide();

            $carousel.carousel('cycle');
        });
    });

    function saveCartSizes() {

        let formData = new FormData();

        $(".se-pre-con").fadeIn('slow');

        let selectedSize = $('#productSize').val();
        if (selectedSize) {
            formData.append('sizes['+selectedSize+']', $('#single_sizes').val());
        }else{
            Swal.fire("Error", "Please select a size for single quantities.", "error");
            $(".se-pre-con").fadeOut('slow');
            return;
        }

        var subTeam = ($('#subTeam').length && $('#subTeam').val() !== '') ? $('#subTeam').val() : null;

        formData.append(`varient`, $('.color-box.active').data('variant-value') || null);
        formData.append(`store_product_id`, '{{$product->id}}');
        formData.append(`saved_cart_item_id`, $('#saved_cart_item_id').val());
        formData.append('customize_number', $('#customize_number_single').val() ?? '');
        formData.append('customize_name', $('#customize_name_single').val() ? $('#customize_name_single').val() : null);
        formData.append(`store_id`, '{{$store->id}}');
        formData.append(`sub_team`, subTeam);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ makeStoreDomainRoute('addCartFromProduct') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(".se-pre-con").fadeIn();
            },
            success: function(response) {
                if (response.status === "success") {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 4000,
                        toast: true
                    });
                } else {
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 4000,
                        toast: true
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = "Failed to add sizes to cart. Please try again.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: errorMessage,
                    showConfirmButton: false,
                    timer: 4000,
                    toast: true
                });
            },
            complete: function() {
                updateCart();
                $(".se-pre-con").fadeOut('slow');
            }
        });
    }
</script>
<script>
    function appendImages(images) {
        var thumbnailHtml = '';
        $.each(images, function(index, item) {
            var imageUrl = item.url ? "{{ asset('') }}/" + item.url : '{{ asset('assets/img/products/default-loading.gif') }}';

            thumbnailHtml += `
                <img
                    src="${imageUrl}"
                    alt="Product Image"
                    class="img-thumbnail mb-lg-2 me-lg-0 me-2 thumb-img cursor_pointer ${index === 0 ? 'active-thumb' : ''}"
                    data-index="${index}"
                    style="cursor: pointer; border: ${index === 0 ? '2px solid black' : '2px solid transparent'}; border-radius: 5px;"
                >
            `;
        });

        $('.carousel-thumbnails').html(thumbnailHtml);

        var carouselHtml = '';
        $.each(images, function(index, item) {
            var imageUrl = item.url ? "{{ asset('') }}/" + item.url : '{{ asset('assets/img/products/default-loading.gif') }}';

            carouselHtml += `
                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <div class="zoom-container">
                        <img src="${imageUrl}" alt="Product Image" class="d-block w-100 img-fluid zoomed-img varients_img_${item.variant}">
                        <div class="zoom-lens"></div>
                    </div>
                </div>
            `;
        });

        $('#carouselExample .carousel-inner').html(carouselHtml);

        $('#carouselExample').carousel({
            interval: 3000,
            ride: 'carousel',
            pause: false
        });

        $(document).on('click', '.carousel-thumbnails img', function() {
            var index = $(this).data('index');
            $('#carouselExample').carousel(index);
        });

        $('#carouselExample').on('slid.bs.carousel', function(e) {
            var index = $(e.relatedTarget).index();
            $('.carousel-thumbnails img')
                .removeClass('active-thumb')
                .css('border', '2px solid transparent');
            $('.carousel-thumbnails img').eq(index)
                .addClass('active-thumb')
                .css('border', '2px solid black');
        });
    }

    // Size Chart Modal Zoom & Pan Script
    (function() {
        let zoomScale = 1;
        let isDragging = false;
        let startX = 0, startY = 0;
        let translateX = 0, translateY = 0;
        let lastTranslateX = 0, lastTranslateY = 0;

        function applyTransform() {
            const $modalImg = $('#sizeChartModalImg');
            const $zoomText = $('#sizeChartZoomLevel');
            $modalImg.css('transform', `translate(${translateX}px, ${translateY}px) scale(${zoomScale})`);
            if ($zoomText.length) {
                $zoomText.text(Math.round(zoomScale * 100) + '%');
            }
        }

        function resetZoomState() {
            zoomScale = 1;
            translateX = 0;
            translateY = 0;
            lastTranslateX = 0;
            lastTranslateY = 0;
            applyTransform();
        }

        $(document).on('show.bs.modal shown.bs.modal', '#sizeChartModal', function() {
            resetZoomState();
        });

        $(document).on('click', '#btnSizeChartZoomIn', function(e) {
            e.preventDefault();
            if (zoomScale < 4) {
                zoomScale = Math.min(4, +(zoomScale + 0.25).toFixed(2));
                applyTransform();
            }
        });

        $(document).on('click', '#btnSizeChartZoomOut', function(e) {
            e.preventDefault();
            if (zoomScale > 0.5) {
                zoomScale = Math.max(0.5, +(zoomScale - 0.25).toFixed(2));
                if (zoomScale <= 1) {
                    translateX = 0;
                    translateY = 0;
                    lastTranslateX = 0;
                    lastTranslateY = 0;
                }
                applyTransform();
            }
        });

        $(document).on('click', '#btnSizeChartZoomReset', function(e) {
            e.preventDefault();
            resetZoomState();
        });

        $(document).on('wheel', '#sizeChartModal .modal-body', function(e) {
            e.preventDefault();
            const delta = e.originalEvent.deltaY;
            if (delta < 0) {
                if (zoomScale < 4) {
                    zoomScale = Math.min(4, +(zoomScale + 0.15).toFixed(2));
                }
            } else {
                if (zoomScale > 0.5) {
                    zoomScale = Math.max(0.5, +(zoomScale - 0.15).toFixed(2));
                    if (zoomScale <= 1) {
                        translateX = 0;
                        translateY = 0;
                        lastTranslateX = 0;
                        lastTranslateY = 0;
                    }
                }
            }
            applyTransform();
        });

        $(document).on('mousedown touchstart', '#sizeChartModalImg', function(e) {
            if (zoomScale > 1) {
                isDragging = true;
                const pageX = e.type === 'touchstart' ? e.originalEvent.touches[0].pageX : e.pageX;
                const pageY = e.type === 'touchstart' ? e.originalEvent.touches[0].pageY : e.pageY;
                startX = pageX - lastTranslateX;
                startY = pageY - lastTranslateY;
                $(this).css('cursor', 'grabbing');
            }
        });

        $(document).on('mousemove touchmove', function(e) {
            if (isDragging) {
                const pageX = e.type === 'touchmove' ? e.originalEvent.touches[0].pageX : e.pageX;
                const pageY = e.type === 'touchmove' ? e.originalEvent.touches[0].pageY : e.pageY;
                translateX = pageX - startX;
                translateY = pageY - startY;
                applyTransform();
            }
        });

        $(document).on('mouseup touchend', function() {
            if (isDragging) {
                isDragging = false;
                lastTranslateX = translateX;
                lastTranslateY = translateY;
                $('#sizeChartModalImg').css('cursor', zoomScale > 1 ? 'grab' : 'pointer');
            }
        });
    })();
</script>

<script>
$(document).ready(function () {

    let sizeChartZoom = 1;
    let sizeChartTranslateX = 0;
    let sizeChartTranslateY = 0;

    const minZoom = 1;
    const maxZoom = 4;
    const zoomStep = 0.25;

    function updateSizeChart() {

        const image = $('#sizeChartFullImage');

        image.css(
            'transform',
            'translate(' +
            sizeChartTranslateX +
            'px, ' +
            sizeChartTranslateY +
            'px) scale(' +
            sizeChartZoom +
            ')'
        );

        $('.zoom-percentage').text(
            Math.round(sizeChartZoom * 100) + '%'
        );
    }


    /* Zoom In */

    $(document).on('click', '.size-chart-zoom-in', function () {

        if (sizeChartZoom < maxZoom) {

            sizeChartZoom += zoomStep;

            updateSizeChart();
        }
    });


    /* Zoom Out */

    $(document).on('click', '.size-chart-zoom-out', function () {

        if (sizeChartZoom > minZoom) {

            sizeChartZoom -= zoomStep;

            if (sizeChartZoom < minZoom) {
                sizeChartZoom = minZoom;
            }

            if (sizeChartZoom === 1) {
                sizeChartTranslateX = 0;
                sizeChartTranslateY = 0;
            }

            updateSizeChart();
        }
    });


    /* Reset */

    $(document).on('click', '.size-chart-zoom-reset', function () {

        sizeChartZoom = 1;

        sizeChartTranslateX = 0;
        sizeChartTranslateY = 0;

        updateSizeChart();
    });


    /* Reset when modal opens */

    $('#sizeChartModal').on('shown.bs.modal', function () {

        sizeChartZoom = 1;

        sizeChartTranslateX = 0;
        sizeChartTranslateY = 0;

        updateSizeChart();
    });


    /* Reset when modal closes */

    $('#sizeChartModal').on('hidden.bs.modal', function () {

        sizeChartZoom = 1;

        sizeChartTranslateX = 0;
        sizeChartTranslateY = 0;

        updateSizeChart();
    });


    /* =========================================
       MOUSE DRAG
       ========================================= */

    let isDragging = false;

    let startX = 0;
    let startY = 0;

    let startTranslateX = 0;
    let startTranslateY = 0;


    $(document).on('mousedown', '#sizeChartFullImage', function (e) {

        if (sizeChartZoom <= 1) {
            return;
        }

        isDragging = true;

        startX = e.clientX;
        startY = e.clientY;

        startTranslateX = sizeChartTranslateX;
        startTranslateY = sizeChartTranslateY;

        e.preventDefault();
    });


    $(document).on('mousemove', function (e) {

        if (!isDragging) {
            return;
        }

        sizeChartTranslateX =
            startTranslateX + (e.clientX - startX);

        sizeChartTranslateY =
            startTranslateY + (e.clientY - startY);

        updateSizeChart();
    });


    $(document).on('mouseup', function () {

        isDragging = false;

    });


    /* =========================================
       MOBILE TOUCH DRAG
       ========================================= */

    let touchStartX = 0;
    let touchStartY = 0;

    let touchStartTranslateX = 0;
    let touchStartTranslateY = 0;


    $(document).on('touchstart', '#sizeChartFullImage', function (e) {

        if (sizeChartZoom <= 1) {
            return;
        }

        const touch = e.originalEvent.touches[0];

        touchStartX = touch.clientX;
        touchStartY = touch.clientY;

        touchStartTranslateX = sizeChartTranslateX;
        touchStartTranslateY = sizeChartTranslateY;
    });


    $(document).on('touchmove', '#sizeChartFullImage', function (e) {

        if (sizeChartZoom <= 1) {
            return;
        }

        const touch = e.originalEvent.touches[0];

        sizeChartTranslateX =
            touchStartTranslateX +
            (touch.clientX - touchStartX);

        sizeChartTranslateY =
            touchStartTranslateY +
            (touch.clientY - touchStartY);

        updateSizeChart();

        e.preventDefault();
    });


});
</script>

@endsection



