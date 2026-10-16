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
    .background-container {
        position: relative;
        /* background-image: url("{{ asset('assets') }}/img/teamStore/top_banner.jpg"); */
        background-size: cover;
        background-position: center;
        width: 100%;
        height: 50%;
    }
    .overlay-text {
        text-align: center;
        padding-top: 20px;
    }
    .event_name {
        font-size: 25px;
        font-weight: 500;
    }
    .event_dis {
        margin-bottom: unset;
        font-size: 12px;
    }
    .timeline_div {
        background-color: #D00000;
        padding: 0.5rem 0rem;
    }
    .timeline_colon {
        padding-left: 10px;
        padding-right: 10px;
    }
    .sec_logo_width {
        width: auto;
        height: 4rem;
    }
    .store_name {
        padding-left: 2%;
    }
    .store_name_text {
        font-size: 22px;
    }
    .teamStore_div {
        padding-left: 5% !important;
        padding-right: 5% !important;
    }
    .product1_div {
        padding-left: 5%;
        padding-right: 5%;
        padding-top: 20px;
    }
    .product1_card {
        padding: .5% 2%;
        border: unset !important;
    }
    .product_div {
        padding-bottom: 20px;
        padding-right: 10px;
        padding-left: 10px;
    }
    .image_card {
        padding-left: 4%;
        padding-right: 4%;
        padding-top: 4%;
    }
    .products_topic_div {
        margin-left: 1.5%;
        font-size: 18px;
        margin-bottom: 10px;
    }
    .product_card:hover {
        border: 1px solid #b2d3eb;
    }
    .product_card {
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 12px;
        border: 1px solid #ededed;
    }
    .product_card_bundle:hover {
        border: 1px solid #b2d3eb;
    }
    .product_card_bundle {
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 12px;
        border: 1px solid #ededed;
    }

    /* Theme colour change */
    .store-light-theme {
        background-color: white !important;
        color: black !important;
    }

    /* Dark Theme */
    .top_nav_dark {
        background-color: #282828 !important;
        color: white !important;
    }
    .store-dark-theme {
        background-color: #121212 !important;
        color: white !important;
    }
    .store_products_dark {
        background-color: rgb(37, 37, 37) !important;
    }
    .store_products_light {
        background-color: rgb(240, 240, 240) !important;
    }
    .store_product_card_dark {
        background-color: rgb(92, 92, 92) !important;
    }
    .store_product_card_light {
        background-color: white !important;
    }
    .store_product_name_dark {
        color: rgb(255, 255, 255) !important;
    }
    .store_product_name_light {
        color: rgb(78, 78, 78) !important;
    }
    .d-none{
        display: none;
    }
    .add-bundle.badge.badge-pill.badge-info:hover{
        color: white;
        background-color: #b3b3b3;
    }
    .swiper-pagination-bullet-active {
        opacity: var(--swiper-pagination-bullet-opacity, 1);
        background: #7f7f7f !important;
    }
    .size-item {
        font-size: 11px;
    }
    .size_name_lable {
        padding-top: 2px;
        padding-right: 6px;
        width: 100px;
        margin: unset;
    }
    .btn-outline-secondary {
        color: white;
        border-color: unset;
        background-color: #B3B3B3;
    }
    .item_qty_div {
        padding-left: 25px;
    }
    .number-input-group {
        display: flex;
        align-items: center;
        width: 100px;
    }
    .input-group-prepend,
    .input-group-append {
        display: flex;
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
    /* PRODUCT IMAGE – responsive large size */
    .bundle-product-img {
        width: 100%;
        max-width: 260px; /* desktop size */
        height: auto;
        object-fit: cover;
    }

    /* PRODUCT BOX */
    .bundle-product-box {
        width: 260px;
        margin: 1.2rem;
        text-align: center;
    }

    /* PRODUCT TITLE */
    .bundle-product-title {
        font-size: 15px;
        font-weight: 600;
        display: block;
        height: 3.8rem;
        overflow: hidden;
    }

    /* PLUS SIGN */
    .plus-sign {
        font-size: 32px;
        font-weight: bold;
        color: #555;
        margin: 1rem;
    }

    /* MOBILE RESPONSIVE */
    @media (max-width: 768px) {
        .bundle-product-box {
            width: 100%;
            max-width: 320px;
            margin: 1rem auto;
        }

        .bundle-product-img {
            max-width: 320px;
        }

        .plus-sign {
            font-size: 26px;
            margin: 0.3rem;
        }
        .mobile_main_banner {
            padding: 15px 15px 0px 15px;
            border-radius: 20px 20px 0px 0px;
        }
        .mobile_second_banner_div {
            padding: 0px 15px;
        }
        .timeline_div {
            border-radius: 0px 0px 6px 6px;
        }
        .mobile_timeline_div {
            margin: unset;
            font-size: 13px;
        }
    }

    @media (max-width: 767.98px) {

    .teamStore_div {
        display: flex !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        width: 100%;
        margin: 10px 0 0 0 !important;
        background-color: white;
        gap: 8px;
        border-radius: 5px;
    }

    /* Secondary Logo */
    .teamStore_div .sec_logo {
        flex: 0 0 auto;
        width: auto;
        display: flex;
        align-items: center;
    }

    .teamStore_div .sec_logo_width {
        width: 45px !important;
        height: 45px !important;
        max-width: 45px;
        object-fit: contain;
    }


    /* Store Name */
    .teamStore_div .store_name {
        flex: 1 1 auto;
        min-width: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
    }

    .teamStore_div .store_name_text {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;

        width: 100%;
        line-height: 1.2;
        font-size: 15px;
        word-break: break-word;
    }


    /* Sizing Chart area */
    .teamStore_div > .ml-auto {
        flex: 0 0 auto !important;
        margin-left: auto !important;
        padding-right: 0 !important;
    }

    .teamStore_div > .ml-auto .row {
        margin: 0 !important;
    }

    .teamStore_div > .ml-auto a {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    /* Hide button text and show icon only */
    .teamStore_div > .ml-auto .btn {
        width: 40px;
        height: 40px;
        padding: 0 !important;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 0 !important;
        border-radius: 50%;
    }

    .teamStore_div > .ml-auto .btn i {
        margin: 0 !important;
        font-size: 18px !important;
    }
}

@media (max-width: 767.98px) {

    .teamStore_div > .ml-auto .btn {
        font-size: 0 !important;
    }

    .teamStore_div > .ml-auto .btn i {
        font-size: 0 !important;
        margin: 0 !important;
    }

    .teamStore_div > .ml-auto .btn i::before {
        content: "\f545";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 18px;
    }
    .mobile_padding_10_15 {
        padding: 8px 15px !important;
    }
    .product1_div {
        background-color: white;
        margin: 0px 15px;
        border-radius: 5px;
        padding-bottom: 15px;
    }
}

/* =========================================================
   Bundle Products - Mobile Responsive Only
   ========================================================= */

@media (max-width: 767.98px) {

    .product1_div {
        /* width: 100%; */
        margin-bottom: 1rem !important;
    }

    /* Bundle title */
    .product1_div .products_topic {
        font-size: 20px !important;
        line-height: 1.3;
    }

    .product1_div .text-center.mb-3 {
        padding: 0 10px;
    }

    /* Required */
    .product1_div .text-center.mb-3 > span {
        margin-left: 5px !important;
        padding: 3px 8px !important;
        font-size: 10px !important;
    }


    /* -----------------------------------------
       Main Card
       ----------------------------------------- */

    .product1_card {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .product_card_bundle {
        width: 100% !important;
        min-width: 100% !important;

        padding: 15px 8px !important;

        display: block !important;
        overflow: visible !important;
    }


    /* -----------------------------------------
       Products
       ----------------------------------------- */

    .product_card_bundle > .d-flex {
        display: grid !important;

        grid-template-columns: repeat(2, minmax(0, 1fr));

        width: 100%;
        margin: 0 !important;

        align-items: center;
        justify-items: center;

        column-gap: 8px;
        row-gap: 20px;
    }


    /* -----------------------------------------
       Product Box
       ----------------------------------------- */

    .bundle-product-box {
        width: 100% !important;
        min-width: 0;

        margin: 0 !important;

        display: flex;
        flex-direction: column;
        align-items: center;

        text-align: center;
    }


    /* -----------------------------------------
       Product Image
       ----------------------------------------- */

    .bundle-product-img {
        display: block;

        width: 100% !important;
        max-width: 150px;

        height: 150px;

        margin: 0 auto;

        object-fit: contain;
    }


    /* -----------------------------------------
       Product Name
       ----------------------------------------- */

    .bundle-product-box .product_name {
        width: 100%;

        margin-top: 8px !important;
        padding: 0 4px;

        text-align: center;
    }

    .bundle-product-title {
        display: block;

        width: 100%;

        font-size: 14px;
        line-height: 1.35;

        word-break: break-word;
        overflow-wrap: anywhere;
    }


    /* -----------------------------------------
       PLUS SIGN
       ----------------------------------------- */

    .product_card_bundle .plus-sign {
        display: flex !important;

        align-items: center;
        justify-content: center;

        width: 100%;
        margin: 0 !important;

        font-size: 24px !important;
        font-weight: bold;

        color: #555;
    }


    /* -----------------------------------------
       Price
       ----------------------------------------- */

    .product1_div > .text-center:last-child {
        padding: 0 10px;
    }

    .product1_div > .text-center:last-child p {
        font-size: 16px !important;

        margin-top: 15px;
        margin-bottom: 12px !important;
    }


    /* -----------------------------------------
       Add Bundle Button
       ----------------------------------------- */

    .product1_div .add-bundle {
        min-width: 190px;

        padding: 0.75rem 1.5rem !important;

        font-size: 15px !important;

        border-radius: 7px !important;
    }
}


/* =========================================================
   Small Mobile
   ========================================================= */

@media (max-width: 380px) {

    .product_card_bundle {
        padding: 12px 5px !important;
    }

    .product_card_bundle > .d-flex {
        column-gap: 5px;
        row-gap: 15px;
    }

    .bundle-product-img {
        max-width: 125px;
        height: 125px;
    }

    .bundle-product-title {
        font-size: 13px;
    }

    .product1_div .products_topic {
        font-size: 18px !important;
    }

    .product1_div .add-bundle {
        min-width: 175px;
        font-size: 14px !important;
    }
}
@media (max-width: 767.98px) {

    /* -----------------------------------------
       Bundle Products Container
       ----------------------------------------- */

    .product_card_bundle > .d-flex {
        display: flex !important;
        flex-wrap: wrap !important;

        width: 100%;
        margin: 0 !important;

        align-items: flex-start;
        justify-content: center;

        gap: 0 !important;

        overflow: visible !important;
    }


    /* -----------------------------------------
       Product Box
       ----------------------------------------- */

    .product_card_bundle .bundle-product-box {
        width: 45% !important;
        flex: 0 0 45% !important;

        min-width: 0;
        height: auto !important;

        margin: 0 !important;
        padding: 0 5px;

        display: flex;
        flex-direction: column;
        align-items: center;

        text-align: center;

        overflow: visible !important;
    }


    /* -----------------------------------------
       Plus Icon
       ----------------------------------------- */

    .product_card_bundle .plus-sign {
        width: 10% !important;
        flex: 0 0 10% !important;

        display: flex !important;

        align-items: center;
        justify-content: center;

        margin: 0 !important;
        padding: 0 !important;

        font-size: 25px !important;
        font-weight: bold;
        color: #555;

        text-align: center;

        flex-shrink: 0;
    }


    /* -----------------------------------------
       Product Image
       ----------------------------------------- */

    .product_card_bundle .bundle-product-img {
        display: block;

        width: 100% !important;
        max-width: 145px;

        height: 145px;

        object-fit: contain;

        margin: 0 auto;
    }


    /* -----------------------------------------
       Product Name Container
       ----------------------------------------- */

    .product_card_bundle .product_name {
        width: 100% !important;

        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;

        margin-top: 8px !important;
        margin-bottom: 0 !important;

        padding: 0 2px !important;

        text-align: center;

        overflow: visible !important;
    }


    /* -----------------------------------------
       Product Name
       ----------------------------------------- */

    .product_card_bundle .bundle-product-title {
        display: block !important;

        width: 100% !important;

        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;

        margin: 0 !important;
        padding: 0 !important;

        font-size: 14px;
        line-height: 1.4;

        white-space: normal !important;

        word-break: normal !important;
        overflow-wrap: anywhere !important;

        text-overflow: clip !important;

        overflow: visible !important;
    }


    /* -----------------------------------------
       Last Product - Center
       ----------------------------------------- */

    .product_card_bundle .bundle-product-box:last-child {
        margin-left: 27.5% !important;
        margin-right: 27.5% !important;
    }
}


/* =========================================================
   Small Mobile
   ========================================================= */

@media (max-width: 380px) {

    .product_card_bundle {
        padding: 12px 5px !important;
    }

    .product_card_bundle > .d-flex {
        gap: 0 !important;
    }

    .product_card_bundle .bundle-product-box {
        width: 45% !important;
        flex: 0 0 45% !important;

        padding: 0 3px;
    }

    .product_card_bundle .plus-sign {
        width: 10% !important;
        flex: 0 0 10% !important;

        font-size: 22px !important;
    }

    .product_card_bundle .bundle-product-img {
        max-width: 125px;
        height: 125px;
    }

    .product_card_bundle .product_name {
        width: 100% !important;
        padding: 0 !important;
        margin-top: 7px !important;
    }

    .product_card_bundle .bundle-product-title {
        font-size: 13px;
        line-height: 1.4;

        white-space: normal !important;
        overflow: visible !important;
        text-overflow: clip !important;
    }
}

/* =========================================================
   BUNDLE + NORMAL PRODUCTS
   MOBILE EXPANDABLE
   ========================================================= */

.bundle-expand-wrapper,
.normal-expand-wrapper {
    display: none;
}


/* =========================================================
   MOBILE ONLY
   ========================================================= */

@media (max-width: 767.98px) {

    /* =====================================================
       COMMON EXPAND BUTTON
       ===================================================== */

    .bundle-expand-wrapper,
    .normal-expand-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        padding: 5px 10px 15px;
    }

    .bundle-expand-btn,
    .normal-expand-btn {
        display: flex;
        align-items: center;
        justify-content: center;

        min-width: 130px;

        padding: 8px 15px;

        border: none;
        background: transparent;

        font-size: 14px;
        font-weight: 600;

        cursor: pointer;
    }

    .bundle-expand-btn i,
    .normal-expand-btn i {
        margin-left: 7px;
        font-size: 12px;

        transition: transform 0.25s ease;
    }

    .bundle-expand-btn.expanded i,
    .normal-expand-btn.expanded i {
        transform: rotate(180deg);
    }


    /* =====================================================
       BUNDLE
       ===================================================== */

    .bundle-category-block .product_card_bundle {
        overflow: hidden !important;
    }

    /*
     * Initially show only 4 products.
     *
     * Because bundle has:
     * Product + Product + Product + Product...
     */
    /* .bundle-category-block .bundle-products-wrapper {
        max-height: 520px;
        overflow: hidden;

        transition: max-height 0.35s ease;
    } */

    /* .bundle-category-block .bundle-products-wrapper.bundle-expanded {
        max-height: 5000px;
        overflow: visible;
    } */


    /* =====================================================
       NORMAL PRODUCTS
       ===================================================== */

    /* .normal-category-block .normal-products-wrapper {
        max-height: 720px;
        overflow: hidden;

        transition: max-height 0.35s ease;
    }

    .normal-category-block .normal-products-wrapper.normal-expanded {
        max-height: 10000px;
        overflow: visible;
    } */


    /* =====================================================
       NORMAL PRODUCT GRID
       ===================================================== */

    .normal-category-block .normal-product-item {
        width: 50% !important;
        flex: 0 0 50% !important;
        max-width: 50% !important;
    }

}

/* =========================================================
   CATEGORY EXPAND / COLLAPSE ICON
   ========================================================= */

.category-expand-icon {
    border: none;
    background: transparent;
    padding: 5px 8px;
    margin-left: 8px;

    cursor: pointer;

    font-size: 14px;
    color: #555;

    vertical-align: middle;

    transition: transform 0.25s ease;
}

.category-expand-icon i {
    transition: transform 0.25s ease;
}


/* Collapsed */
.category-expand-icon.collapsed i {
    transform: rotate(-90deg);
}


/* =========================================================
   MOBILE ONLY
   ========================================================= */

@media (max-width: 767.98px) {

    /* -----------------------------------------------------
       CATEGORY HEADER
       ----------------------------------------------------- */

    .bundle-category-header,
    .normal-category-header {
        position: relative;

        display: flex;
        align-items: center;
        justify-content: center;

        width: 100%;
    }

    .bundle-category-header .products_topic,
    .normal-category-header .products_topic {
        /* max-width: calc(100% - 45px); */
    }


    /* -----------------------------------------------------
       Expand Icon
       ----------------------------------------------------- */

    .category-expand-icon {
        position: absolute;

        right: -15px;
        top: 35%;

        transform: translateY(-50%);

        margin: 0;

        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        font-size: 13px;
    }

    .category-expand-icon i {
        transition: transform 0.25s ease;
    }

    .category-expand-icon.collapsed i {
        transform: rotate(-90deg);
    }


    /* =====================================================
       PRODUCT NAME - MAX 2 LINES
       ===================================================== */

    .bundle-product-title,
    .normal-category-block .product-link {
        display: -webkit-box !important;

        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;

        overflow: hidden !important;

        text-overflow: ellipsis;

        white-space: normal !important;

        word-break: normal;
        overflow-wrap: anywhere;

        line-height: 1.35;

        /*
         * Exactly enough space for 2 lines
         */
        min-height: calc(1.35em * 2);
        max-height: calc(1.35em * 2);
    }


    /* =====================================================
       BUNDLE PRODUCT NAME
       ===================================================== */

    .product_card_bundle .product_name {
        width: 100% !important;

        height: calc(1.35em * 2) !important;

        min-height: calc(1.35em * 2) !important;
        max-height: calc(1.35em * 2) !important;

        margin-top: 8px !important;
        margin-bottom: 0 !important;

        padding: 0 3px !important;

        text-align: center;

        overflow: hidden !important;

        display: flex;
        align-items: flex-start;
        justify-content: center;
    }

    .product_card_bundle .bundle-product-title {
        width: 100% !important;

        margin: 0 !important;
        padding: 0 !important;

        font-size: 14px;
        line-height: 1.35;

        min-height: calc(1.35em * 2);
        max-height: calc(1.35em * 2);

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        display: -webkit-box !important;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;

        white-space: normal !important;
    }


    /* =====================================================
       NORMAL PRODUCT NAME
       ===================================================== */

    .normal-category-block .product_name {
        height: calc(2.35em * 2) !important;

        min-height: calc(2.35em * 2) !important;
        max-height: calc(2.35em * 2) !important;

        overflow: hidden !important;

        display: flex;
        align-items: flex-start;
        justify-content: center;
    }

    .normal-category-block .product_name .product-link {
        width: 100%;

        font-size: 15px;

        line-height: 1.35;

        min-height: calc(1.35em * 2);
        max-height: calc(1.35em * 2);

        display: -webkit-box !important;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;

        overflow: hidden !important;

        text-overflow: ellipsis !important;

        white-space: normal !important;

        word-break: normal;
        overflow-wrap: anywhere;
    }


    /* =====================================================
       PRODUCT ITEM HEIGHT
       ===================================================== */

    .normal-category-block .normal-product-item {
        height: auto !important;
    }


    /* =====================================================
       BUNDLE SHOW MORE
       ===================================================== */

    .bundle-expand-wrapper,
    .normal-expand-wrapper {
        display: flex;

        justify-content: center;
        align-items: center;

        width: 100%;

        padding: 10px 10px 15px;
    }


    .bundle-expand-btn,
    .normal-expand-btn {
        display: flex;

        align-items: center;
        justify-content: center;

        min-width: 130px;

        padding: 8px 15px;

        border: none;
        background: transparent;

        font-size: 14px;
        font-weight: 600;

        cursor: pointer;
    }


    .bundle-expand-btn i,
    .normal-expand-btn i {
        margin-left: 7px;

        font-size: 12px;

        transition: transform 0.25s ease;
    }


    .bundle-expand-btn.expanded i,
    .normal-expand-btn.expanded i {
        transform: rotate(180deg);
    }


    /* =====================================================
       HIDDEN PRODUCTS
       ===================================================== */

    .bundle-product-box.mobile-hidden-product,
    .normal-product-item.mobile-hidden-product {
        display: none !important;
    }


    /* =====================================================
       BUNDLE PLUS SIGN
       ===================================================== */

    .product_card_bundle .plus-sign.mobile-hidden-product {
        display: none !important;
    }
}


/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 380px) {

    .product_card_bundle .bundle-product-title {
        font-size: 13px;

        line-height: 1.35;

        min-height: calc(1.35em * 2);
        max-height: calc(1.35em * 2);
    }

    .product_card_bundle .product_name {
        height: calc(1.35em * 2) !important;

        min-height: calc(1.35em * 2) !important;
        max-height: calc(1.35em * 2) !important;
    }

    .normal-category-block .product_name .product-link {
        font-size: 14px;

        line-height: 1.35;

        min-height: calc(1.35em * 2);
        max-height: calc(1.35em * 2);
    }

    .category-expand-icon {
        right: 4px;
        width: 30px;
        height: 30px;
    }
}

@media (max-width: 767.98px) {

    .normal-category-block .product_name {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: flex-start !important;

        height: auto !important;
        min-height: 4.2rem !important;

        text-align: center !important;
    }

    /* Product Name */
    .normal-category-block .product_name > a.product-link {
        display: -webkit-box !important;

        width: 100% !important;

        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;

        overflow: hidden !important;
        text-overflow: ellipsis !important;

        white-space: normal !important;

        line-height: 1.35 !important;

        min-height: calc(1.35em * 2);
        max-height: calc(1.35em * 2);

        margin: 0 !important;
        font-size: 13px !important;
    }

    /* Price - always below product name */
    .normal-category-block .product_name > p.product-link {
        display: block !important;

        width: 100% !important;

        margin-top: 5px !important;
        margin-bottom: 0 !important;

        font-size: 17px !important;

        line-height: 1.3 !important;

        text-align: center !important;

        white-space: nowrap !important;
        font-weight: 600;
    }

}
/* =========================================
   Mobile - Modern Sizes Modal
   ========================================= */
@media (max-width: 767.98px) {

    /* Modal wrapper */
    #sizesModal .modal-dialog {
        width: calc(100% - 24px) !important;
        max-width: none !important;
        margin: 12px auto !important;
        min-height: calc(100% - 24px) !important;
        display: flex !important;
        align-items: center !important;
    }

    /* Modal */
    #sizesModal .modal-content {
        width: 100% !important;
        border: none !important;
        border-radius: 18px !important;
        overflow: hidden !important;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18) !important;
        max-height: calc(100vh - 24px) !important;
        display: flex !important;
        flex-direction: column !important;
    }

    /* Header */
    #sizesModal .modal-header {
        padding: 16px 18px !important;
        border-bottom: 1px solid #eeeeee !important;
        min-height: 60px !important;
        display: flex !important;
        align-items: center !important;
    }

    /* Title */
    #sizesModal .modal-title {
        font-size: 18px !important;
        font-weight: 600 !important;
        line-height: 1.3 !important;
        margin: 0 !important;
        flex: 1 !important;
    }

    /* Close button */
    #sizesModal .modal-header .close {
        width: 34px !important;
        height: 34px !important;
        margin: 0 !important;
        padding: 0 !important;
        border-radius: 50% !important;
        background: #f3f3f3 !important;
        opacity: 1 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 24px !important;
        font-weight: 400 !important;
        line-height: 1 !important;
    }

    #sizesModal .modal-header .close span {
        color: #555 !important;
        line-height: 1 !important;
        display: block !important;
        margin-top: -2px !important;
    }

    /* Body */
    #sizesModal .modal-body {
        padding: 18px 16px !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        -webkit-overflow-scrolling: touch !important;
        flex: 1 1 auto !important;
    }

    /* Footer */
    #sizesModal .modal-footer {
        padding: 12px 16px 16px !important;
        border-top: 1px solid #eeeeee !important;
        background: #fff !important;
        display: block !important;
    }

    /* Add to cart button */
    #sizesModal .modal-footer .updateCartProductDetails {
        width: 100% !important;
        min-height: 48px !important;
        border-radius: 10px !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        letter-spacing: 0.3px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: none !important;
        transition: all 0.2s ease !important;
    }

    #sizesModal .modal-footer .updateCartProductDetails:active {
        transform: scale(0.98) !important;
    }

    /* Prevent horizontal overflow from dynamically loaded size content */
    #sizesModal #sizesModalBody > * {
        max-width: 100% !important;
    }

    #sizesModal #sizesModalBody input,
    #sizesModal #sizesModalBody select,
    #sizesModal #sizesModalBody textarea {
        max-width: 100% !important;
    }
    .margin_b_1rem {
        padding-bottom: 1rem !important;
    }
}


/* =========================================
   Very Small Screens
   ========================================= */
@media (max-width: 380px) {

    #sizesModal .modal-dialog {
        width: calc(100% - 16px) !important;
        margin: 8px auto !important;
        min-height: calc(100% - 16px) !important;
    }

    #sizesModal .modal-content {
        border-radius: 16px !important;
        max-height: calc(100vh - 16px) !important;
    }

    #sizesModal .modal-header {
        padding: 14px 15px !important;
    }

    #sizesModal .modal-title {
        font-size: 17px !important;
    }

    #sizesModal .modal-body {
        padding: 15px 12px !important;
    }

    #sizesModal .modal-footer {
        padding: 10px 12px 13px !important;
    }

    #sizesModal .modal-footer .updateCartProductDetails {
        min-height: 46px !important;
        font-size: 14px !important;
    }

    .category-expand-icon.bundle-category-toggle {
        display: none;
    }
}

@media (max-width: 767.98px) {
    .add_cart_btn {
        font-size: 0 !important;
    }

    .add_cart_btn::after {
        content: "Add To Cart";
        font-size: 13px !important;
    }
}

    /* End Theme colour change */

    .product-name-two-lines {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;

        line-height: 1.4;
        height: calc(1.4em * 2);

        text-overflow: ellipsis;
    }
</style>
<div class="navbar top-navbar col-12 col-lg-12  {{ $teamStore->theme == 1 ? 'top_nav_dark' : '' }}" style=" background-color:white; z-index:99;padding: 0;">

    @include('pages.customer_team_store.layouts.header')

</div>
@php
    $primaryColor = $teamStore->primary_color ? $teamStore->primary_color : '#47D6B6';
@endphp

<div style="padding-top: 4.4rem;">
    <img class="mobile_main_banner" src="{{ asset($teamStore->store_banner ? $teamStore->store_banner : 'assets/img/teamStore/banner_img_2.jpg') }}"  onerror="this.onerror=null; this.src='{{ asset('assets/img/teamStore/banner_img_2.jpg') }}';" alt="Store Banner" style="width: 100%; display: block;">

    @if ($store->set_store_deadline == 1 && !empty($store->close_date))
        <div class="row mobile_second_banner_div" style="margin: unset;">
            <img src="{{ asset($teamStore->fundraising ? $teamStore->fundraising : 'assets/img/teamStore/welcome_banner.jpg') }}"  onerror="this.onerror=null; this.src='{{ asset('assets/img/teamStore/welcome_banner.jpg') }}';" alt="Welcome Banner" style="width: 100%; display: block;">
            <div class="timeline_div col-md-12">
                <div class="row mobile_timeline_div" style="justify-content: center; color: white; width: 100%;">
                    <div>
                        <b style="margin-right: 1rem;color: white;">🎉 Hurry! Shop Now Before the Deadline Hits. ✨ </b>
                    </div>
                    <div>
                        <span>DAYS :</span>
                        <b class="days" id="days" style="margin-right: 1rem;">00</b>
                    </div>
                    <div>
                        <span>HRS :</span>
                        <b class="hrs" id="hrs" style="margin-right: 1rem;">00</b>
                    </div>
                    <div>
                        <span>MINS :</span>
                        <b class="mins" id="mins" style="margin-right: 1rem;">00</b>
                    </div>
                    <div>
                        <span>SEC :</span>
                        <b class="sec" id="sec" style="margin-right: 1rem;">00</b>
                    </div>
                </div>
            </div>

        </div>
    @endif


    <div class="mobile_padding_10_15 margin_b_1rem">
        <div class="row navbar navbar-expand-lg teamStore_div mt-3" style="margin: unset;">
            <div class="sec_logo">

                 <img src="{{ asset($teamStore->secondary_logo ? $teamStore->secondary_logo  : 'assets/img/teamStore/sec_logo.png') }}"   onerror="this.onerror=null; this.src='{{ asset('assets/img/teamStore/sec_logo.png') }}';" alt="image" style="color:black" class="sec_logo_width">

            </div>

            <div class="store_name">
                <b class="store_name_text">{{$store->store_name}}</b>
            </div>

            <div class="ml-auto"  style="padding-right: 5%;">
                <div class="row">
                    <a href="https://www.encorecustom.com/pages/sizing-fit" target="_blank" style="display: flex; align-items: center; text-decoration: none;">
                        <button class="btn btn-success font_size13" type="button" style="background-color: {{ $primaryColor }}; border: none; font-size: 1.2rem;">
                            <i class="fa fa-info-circle mr-1" aria-hidden="true"></i>
                            Sizing Chart
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>


    {{-- @if($storeProductCategory->is_bundle == 1)
        <button type="button"
            data-product-ids='@json($store_products[$storeProductCategory->id]->pluck("id"))'
            class="add-bundle badge badge-pill badge-info"
            style="position: absolute; top: -5px; right: -80px; font-size: 10px; border: none; cursor: pointer;">
            ADD TO CART
        </button>
    @endif --}}

    {{-- @foreach ($storeProductCategories as $storeProductCategory)
    @if ($storeProductCategory->is_bundle == 1 && isset($store_products[$storeProductCategory->id]) && $store_products[$storeProductCategory->id]->isNotEmpty())
        <div class="product1_div mb-5">

    <!-- BUNDLE TITLE (outside the card) -->
    <div class="text-center mb-3">
        <strong class="products_topic" style="font-size: 26px;">
            Bundle – {{ $storeProductCategory->category_name }}
        </strong>

        @if ($storeProductCategory->is_required)
            <span class="ml-2" style="
                background:#e51111;
                padding:4px 12px;
                font-size:12px;
                color:white;
                border-radius:5px;
            ">
                Required
            </span>
        @endif
    </div>

    <!-- CARD BLOCK -->
    <div class="card product1_card col-lg-12 {{ $teamStore->theme == 1 ? 'store_products_dark' : '' }}"
         style="border:none;">

        <div class="row justify-content-center">

            <div class="product_card_bundle {{ $teamStore->theme == 1 ? 'store_product_card_dark' : '' }}"
                 style="
                 padding: 1rem;
                 display: flex;
                 justify-content: center;
                 align-items: center;
                 min-width: 100%;
                 background: #fff;
                 border-radius: 0;
                 ">

                <div class="d-flex align-items-center justify-content-center flex-wrap">

                    @php
                        $categoryProducts = $store_products[$storeProductCategory->id] ?? collect();
                    @endphp

                    @foreach ($categoryProducts as $key => $product)

                        @if($key > 0)
                            <div class="plus-sign mx-3 mb-4"
                                 style="font-size: 30px; font-weight: bold; color:#555;">
                                +
                            </div>
                        @endif

                        <div class="bundle-product-box">

                            <a href="{{ makeStoreDomainRoute('TeamStoreProductDetails/'.$product->id.((request()->get('view-only') === 'true') ? '?view-only=true' : '')) }}">
                                <img class="bundle-product-img"
                                    src="{{ asset(optional($product->images->first())->url ?? 'assets/img/products/default-loading.gif') }}"
                                    alt=""
                                    onerror="this.src='{{ asset('assets/img/products/default-loading.gif') }}'">
                            </a>

                            <div class="product_name mt-2">
                                <span class="bundle-product-title {{ $teamStore->theme == 1 ? 'store_product_name_dark' : '' }}">
                                    {{ $product->product_name }}
                                </span>
                            </div>
                        </div>

                        @php
                            $bundleAdditions = $product->priceAdditions->sum('addition_amount');
                        @endphp

                    @endforeach

                </div>

            </div>
        </div>

    </div>

    <!-- PRICE + ADD TO CART (outside card bottom) -->
    <div class="text-center">

        <p class="product-link font_color {{ $teamStore->theme == 1 ? 'store_product_name_dark' : '' }}"
           style="font-size: 1.4rem; margin-bottom: 1rem;">
            Starting at
            <strong style="color:{{ $primaryColor }};">
                ${{ number_format($store_products[$storeProductCategory->id]->sum('default_price') + $bundleAdditions, 2) }}
            </strong>
        </p>

        @if(!(request()->has('view-only') && request()->get('view-only') == 'true'))
            <button class="btn btn-success add-bundle font_size13"
                    type="button"
                    style="
                        background-color: {{ $primaryColor }};
                        border:none;
                        padding: 0.9rem 3rem;
                        font-size: 17px;
                        border-radius: 8px;
                    "
                    data-product-ids='@json($store_products[$storeProductCategory->id]->pluck("id"))'>
                Add Bundle to Cart
            </button>
        @endif


    </div>

</div>

    @elseif(isset($store_products[$storeProductCategory->id]) && $store_products[$storeProductCategory->id]->isNotEmpty())

    <div class="product1_div">
        <div class="card product1_card col-lg-12 {{ $teamStore->theme == 1 ? 'store_products_dark' : '' }}">
            <div class="row">
                <div class="products_topic_div">
                    <b class="products_topic" style="position: relative; display: inline-block;">
                        {{ $storeProductCategory->category_name }}
                    </b>
                </div>
            </div>
            <div class="row">
                @if(isset($store_products[$storeProductCategory->id]) && $store_products[$storeProductCategory->id]->isNotEmpty())
                    @foreach ($store_products[$storeProductCategory->id] as $key => $product)
                        <div class="col-lg-4 col-md-6 col-sm-6 product_div px-1">
                            <div class="card {{ $teamStore->theme == 1 ? 'store_product_card_dark' : '' }}" style="border-radius: 12px; border: unset;">
                                <div>
                                    <div class="product_card">
                                        <div class="image_card p-1">
                                            <a href="{{ makeStoreDomainRoute('TeamStoreProductDetails/'.$product->id.((request()->get('view-only') === 'true') ? '?view-only=true' : '')) }}">
                                                <div class="swiper product-swiper">
                                                    <div class="swiper-wrapper">
                                                        @forelse($product->images as $img)
                                                            <div class="swiper-slide">
                                                                <img class="d-block w-100 product_image"
                                                                    src="{{ asset($img->url ?? 'assets/img/products/default-loading.gif') }}"
                                                                    alt="Product Image"
                                                                    onerror="this.src='{{ asset('assets/img/products/default-loading.gif') }}'">
                                                            </div>
                                                        @empty
                                                            <div class="swiper-slide">
                                                                <img class="d-block w-100 product_image"
                                                                    src="{{ asset('assets/img/products/default-loading.gif') }}"
                                                                    alt="Default Image">
                                                            </div>
                                                        @endforelse
                                                        <div class="swiper-pagination" style="bottom: 5px;"></div>
                                                    </div>
                                                </div>
                                            </a>
                                            @if ($product->mandotary == 1)
                                                <div class="required-badge" style="position: absolute;top: 6%;right: 8%;background-color: #e51111;color: white;padding: 2px 10px;font-size: 12px;border-radius: 5px;z-index:99">
                                                    Required
                                                </div>
                                            @endif
                                            <div class="like_tag" style="position: absolute; top: 12px; right: 20px; display:none;">
                                                <img style="width: 22px;" src="{{ asset('argon/img/icons/customer_portal/heart.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="product_name mt-1 p-1" style="text-align: center;min-height: 4.2rem;">
                                            <a href="{{ makeStoreDomainRoute('TeamStoreProductDetails/'.$product->id.((request()->get('view-only') === 'true') ? '?view-only=true' : '')) }}" tooltip="{{ $product->product_name }}"
                                               class="product-link {{ $teamStore->theme == 1 ? 'store_product_name_dark' : '' }}"
                                               style="overflow: hidden; text-overflow: ellipsis; max-width: 100%; font-size: 15px; color: rgb(78, 78, 78);">
                                                {{ $product->product_name }}
                                            </a>
                                            @php
                                                $additionSum = $product->priceAdditions->sum('addition_amount');
                                            @endphp
                                            <p class="product-link font_color mb-1 {{ $teamStore->theme == 1 ? 'store_product_name_dark' : '' }}" style="font-size: 1.5rem;">
                                                ${{ number_format(($product->default_price + $additionSum), 2) }}
                                            </p>
                                        </div>
                                        <div class="enquiry_tab mt-1 mb-3" style="text-align: center;">
                                            @if(!(request()->has('view-only') && request()->get('view-only') == 'true'))
                                                <button class="btn btn-success input_width font_size13 add_cart_btn" type="button" style="background-color: {{ $primaryColor }}; border: unset;" value="{{ $product->id }}">
                                                    Quick Add To Cart
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @else
                    <div class="col-12 text-center py-3">
                        <p class="text-muted">No products available in this category.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
@endforeach --}}


@foreach ($storeProductCategories as $storeProductCategory)

    {{-- =========================================================
         BUNDLE PRODUCTS
         ========================================================= --}}
    @if ($storeProductCategory->is_bundle == 1 &&
        isset($store_products[$storeProductCategory->id]) &&
        $store_products[$storeProductCategory->id]->isNotEmpty())

        <div class="product1_div mb-5 bundle-category-block">

            <!-- BUNDLE TITLE -->
            <div class="text-center mb-3 bundle-category-header">
                <strong class="products_topic" style="font-size: 26px;">
                    Bundle – {{ $storeProductCategory->category_name }}
                </strong>

                @if ($storeProductCategory->is_required)
                    <span class="ml-2" style="background:#e51111; padding:4px 12px; font-size:12px; color:white; border-radius:5px;">
                        Required
                    </span>
                @endif

            </div>

            @php
                $categoryProducts = $store_products[$storeProductCategory->id] ?? collect();
            @endphp

            <!-- CARD BLOCK -->
            <div class="card product1_card col-lg-12 {{ $teamStore->theme == 1 ? 'store_products_dark' : '' }}"
                 style="border:none;">

                <div class="row justify-content-center">

                    <div class="product_card_bundle {{ $teamStore->theme == 1 ? 'store_product_card_dark' : '' }}"
                         style="
                         padding: 1rem;
                         display: flex;
                         justify-content: center;
                         align-items: center;
                         min-width: 100%;
                         background: #fff;
                         border-radius: 0;
                         ">

                        <div class="d-flex align-items-center justify-content-center flex-wrap bundle-products-wrapper">

                            @foreach ($categoryProducts as $key => $product)

                                @if($key > 0)
                                    <div class="plus-sign mx-3 mb-4"
                                         style="font-size: 30px; font-weight: bold; color:#555;">
                                        +
                                    </div>
                                @endif

                                <div class="bundle-product-box">

                                    <a href="{{ makeStoreDomainRoute('TeamStoreProductDetails/'.$product->id.((request()->get('view-only') === 'true') ? '?view-only=true' : '')) }}">
                                        <img class="bundle-product-img"
                                            src="{{ asset(optional($product->images->first())->url ?? 'assets/img/products/default-loading.gif') }}"
                                            alt=""
                                            onerror="this.src='{{ asset('assets/img/products/default-loading.gif') }}'">
                                    </a>

                                    <div class="product_name mt-2">
                                        <span class="bundle-product-title {{ $teamStore->theme == 1 ? 'store_product_name_dark' : '' }}">
                                            {{ $product->product_name }}
                                        </span>
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

            {{-- Bundle Expand Button --}}
            @if($categoryProducts->count() > 4)
                <div class="bundle-expand-wrapper">
                    <button type="button"
                            class="bundle-expand-btn"
                            aria-expanded="false">
                        <span class="bundle-expand-text">Show More</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
            @endif


            <!-- PRICE + ADD TO CART -->
            <div class="text-center">

                @php
                    $bundleAdditions = 0;

                    foreach ($categoryProducts as $bundleProduct) {
                        $bundleAdditions += $bundleProduct->priceAdditions->sum('addition_amount');
                    }
                @endphp

                <p class="product-link font_color {{ $teamStore->theme == 1 ? 'store_product_name_dark' : '' }}"
                   style="font-size: 1.4rem; margin-bottom: 1rem;">

                    Starting at

                    <strong style="color:{{ $primaryColor }};">
                        ${{ number_format($categoryProducts->sum('default_price') + $bundleAdditions, 2) }}
                    </strong>

                </p>

                @if(!(request()->has('view-only') && request()->get('view-only') == 'true'))

                    <button class="btn btn-success add-bundle font_size13"
                            type="button"
                            style="
                                background-color: {{ $primaryColor }};
                                border:none;
                                padding: 0.9rem 3rem;
                                font-size: 17px;
                                border-radius: 8px;
                            "
                            data-product-ids='@json($categoryProducts->pluck("id"))'>

                        Add Bundle to Cart

                    </button>

                @endif

            </div>

        </div>


    {{-- =========================================================
         NORMAL PRODUCTS
         ========================================================= --}}
    @elseif(isset($store_products[$storeProductCategory->id]) &&
            $store_products[$storeProductCategory->id]->isNotEmpty())

        @php
            $normalCategoryProducts = $store_products[$storeProductCategory->id];
        @endphp

        <div class="product1_div normal-category-block">

            <div class="card product1_card col-lg-12 {{ $teamStore->theme == 1 ? 'store_products_dark' : '' }}">

                <div class="row normal-category-header">
                    <div class="products_topic_div">
                        <b class="products_topic" style="position: relative; display: inline-block;">
                            {{ $storeProductCategory->category_name }}
                        </b>

                        <button type="button"
                                class="category-expand-icon normal-category-toggle"
                                aria-expanded="true">
                            <i class="fa fa-chevron-down"></i>
                        </button>
                    </div>
                </div>

                <div class="row normal-products-wrapper">

                    @foreach ($normalCategoryProducts as $key => $product)

                        <div class="col-lg-3 col-md-6 col-sm-6 product_div px-1 normal-product-item">

                            <div class="card {{ $teamStore->theme == 1 ? 'store_product_card_dark' : '' }}"
                                 style="border-radius: 12px; border: unset;">

                                <div>

                                    <div class="product_card">

                                        <div class="image_card p-1">

                                            <a href="{{ makeStoreDomainRoute('TeamStoreProductDetails/'.$product->id.((request()->get('view-only') === 'true') ? '?view-only=true' : '')) }}">

                                                <div class="swiper product-swiper">

                                                    <div class="swiper-wrapper">

                                                        @forelse($product->images as $img)

                                                            <div class="swiper-slide">

                                                                <img class="d-block w-100 product_image"
                                                                    src="{{ asset($img->url ?? 'assets/img/products/default-loading.gif') }}"
                                                                    alt="Product Image"
                                                                    onerror="this.src='{{ asset('assets/img/products/default-loading.gif') }}'">

                                                            </div>

                                                        @empty

                                                            <div class="swiper-slide">

                                                                <img class="d-block w-100 product_image"
                                                                    src="{{ asset('assets/img/products/default-loading.gif') }}"
                                                                    alt="Default Image">

                                                            </div>

                                                        @endforelse

                                                        <div class="swiper-pagination"
                                                             style="bottom: 5px;">
                                                        </div>

                                                    </div>

                                                </div>

                                            </a>

                                            @if ($product->mandotary == 1)

                                                <div class="required-badge"
                                                     style="
                                                        position: absolute;
                                                        top: 6%;
                                                        right: 8%;
                                                        background-color: #e51111;
                                                        color: white;
                                                        padding: 2px 10px;
                                                        font-size: 12px;
                                                        border-radius: 5px;
                                                        z-index:99;
                                                     ">
                                                    Required
                                                </div>

                                            @endif

                                            <div class="like_tag"
                                                 style="
                                                    position: absolute;
                                                    top: 12px;
                                                    right: 20px;
                                                    display:none;
                                                 ">

                                                <img style="width: 22px;"
                                                     src="{{ asset('argon/img/icons/customer_portal/heart.png') }}"
                                                     alt="">

                                            </div>

                                        </div>


                                        <div class="product_name mt-1 p-1"
                                            style="text-align: center;">

                                            <a href="{{ makeStoreDomainRoute('TeamStoreProductDetails/'.$product->id.((request()->get('view-only') === 'true') ? '?view-only=true' : '')) }}"
                                            tooltip="{{ $product->product_name }}"
                                            class="product-link product-name-two-lines {{ $teamStore->theme == 1 ? 'store_product_name_dark' : '' }}"
                                            style="
                                                    display: -webkit-box;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;
                                                    -webkit-box-orient: vertical;
                                                    -webkit-line-clamp: 2;
                                                    line-height: 1.4;
                                                    height: 42px;
                                                    max-width: 100%;
                                                    font-size: 15px;
                                                    color: rgb(78, 78, 78);
                                            ">

                                                {{ $product->product_name }}

                                            </a>

                                            @php
                                                $additionSum = $product->priceAdditions->sum('addition_amount');
                                            @endphp

                                            <p class="product-link font_color mb-1 {{ $teamStore->theme == 1 ? 'store_product_name_dark' : '' }}"
                                               style="font-size: 1.5rem;">

                                                ${{ number_format(($product->default_price + $additionSum), 2) }}

                                            </p>

                                        </div>


                                        <div class="enquiry_tab mt-1 mb-3"
                                             style="text-align: center;">

                                            @if(!(request()->has('view-only') && request()->get('view-only') == 'true'))

                                                <button class="btn btn-success input_width font_size13 add_cart_btn"
                                                        type="button"
                                                        style="
                                                            background-color: {{ $primaryColor }};
                                                            border: unset;
                                                        "
                                                        value="{{ $product->id }}">

                                                    Quick Add To Cart

                                                </button>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- Normal Product Expand Button --}}
                @if($normalCategoryProducts->count() > 4)

                    <div class="normal-expand-wrapper">

                        <button type="button"
                                class="normal-expand-btn"
                                aria-expanded="false">

                            <span class="normal-expand-text">
                                Show More
                            </span>

                            <i class="fas fa-chevron-down"></i>

                        </button>

                    </div>

                @endif

            </div>

        </div>

    @endif

@endforeach


</div>
@include('pages.customer_team_store.layouts.footer')

<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content  {{ $teamStore->theme == 1 ? 'modal_dark' : '' }}">
            <div class="modal-header">
                <input type="hidden" id="modal_product_id" value="">
                <h5 class="modal-title  {{ $teamStore->theme == 1 ? 'modal_dark' : '' }}" id="sizesModalLabel">Set Sizes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class=" {{ $teamStore->theme == 1 ? 'modal_dark' : '' }}" aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body" id="sizesModalBody">
                </div>
            <div class="modal-footer modal_footer">
                <button type="button" class="btn btn-primary updateCartProductDetails" data-saving-type="size" style="background-color: {{ $teamStore->primary_color}}; border: unset;">ADD TO CART</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sizesModalBundle" tabindex="-1" role="dialog" aria-labelledby="sizesModalBundleLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content {{ $teamStore->theme == 1 ? 'modal_dark' : '' }}">
      <div class="modal-header">
        <h5 class="modal-title {{ $teamStore->theme == 1 ? 'modal_dark' : '' }}" id="sizesModalBundleLabel">
          Set Bundle Sizes
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="{{ $teamStore->theme == 1 ? 'modal_dark' : '' }}" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="sizesModalBundleBody" style="max-height: 75vh; overflow-y: auto;padding: 1rem !important;">
      </div>

      <div class="modal-footer modal_footer">
        <button type="button" class="btn btn-primary updateCartBundleProductDetails" style="background-color: {{ $teamStore->primary_color }}; border: unset;">
          ADD TO CART
        </button>
      </div>
    </div>
  </div>
</div>
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


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | BUNDLE PRODUCTS
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.bundle-category-block').forEach(function (category) {

        const wrapper = category.querySelector('.bundle-products-wrapper');
        const showMoreBtn = category.querySelector('.bundle-expand-btn');
        const categoryToggle = category.querySelector('.bundle-category-toggle');

        if (!wrapper) {
            return;
        }

        const products = Array.from(
            wrapper.querySelectorAll('.bundle-product-box')
        );

        const plusSigns = Array.from(
            wrapper.querySelectorAll('.plus-sign')
        );

        const expandWrapper = category.querySelector('.bundle-expand-wrapper');

        let expanded = false;

        /*
         * Show first 4 products only on mobile.
         */
        function updateBundleProducts() {

            const isMobile = window.innerWidth <= 767.98;

            if (!isMobile || expanded) {

                products.forEach(function (product) {
                    product.classList.remove('mobile-hidden-product');
                });

                plusSigns.forEach(function (plus) {
                    plus.classList.remove('mobile-hidden-product');
                });

                if (expandWrapper && products.length <= 4) {
                    expandWrapper.style.display = 'none';
                }

                return;
            }

            /*
             * Hide products after first 4.
             */
            products.forEach(function (product, index) {

                if (index >= 4) {
                    product.classList.add('mobile-hidden-product');
                } else {
                    product.classList.remove('mobile-hidden-product');
                }

            });


            /*
             * Hide PLUS signs that belong to hidden products.
             *
             * Plus signs are between products.
             * Therefore only keep the plus signs needed
             * for the first 4 products.
             */
            plusSigns.forEach(function (plus, index) {

                if (index >= 3) {
                    plus.classList.add('mobile-hidden-product');
                } else {
                    plus.classList.remove('mobile-hidden-product');
                }

            });
        }


        /*
         * Show More / Show Less
         */
        if (showMoreBtn) {

            if (products.length <= 4) {
                showMoreBtn.parentElement.style.display = 'none';
            }

            showMoreBtn.addEventListener('click', function () {

                expanded = !expanded;

                updateBundleProducts();

                showMoreBtn.classList.toggle('expanded', expanded);

                const text = showMoreBtn.querySelector('.bundle-expand-text');

                if (text) {
                    text.textContent = expanded
                        ? 'Show Less'
                        : 'Show More';
                }

                if (categoryToggle) {
                    categoryToggle.classList.toggle('collapsed', !expanded);

                    categoryToggle.setAttribute(
                        'aria-expanded',
                        expanded ? 'true' : 'false'
                    );
                }

            });
        }


        /*
         * Category header expand / collapse
         */
        if (categoryToggle) {

            categoryToggle.addEventListener('click', function () {

                const isExpanded =
                    categoryToggle.getAttribute('aria-expanded') === 'true';

                if (isExpanded) {

                    categoryToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                    categoryToggle.classList.add('collapsed');

                    wrapper.style.display = 'none';

                    if (expandWrapper) {
                        expandWrapper.style.display = 'none';
                    }

                } else {

                    categoryToggle.setAttribute(
                        'aria-expanded',
                        'true'
                    );

                    categoryToggle.classList.remove('collapsed');

                    wrapper.style.display = '';

                    if (expandWrapper && products.length > 4) {
                        expandWrapper.style.display = 'flex';
                    }

                    /*
                     * If category is opened again,
                     * keep current Show More state.
                     */
                    updateBundleProducts();
                }

            });
        }


        /*
         * Initial state
         */
        updateBundleProducts();


        /*
         * Handle screen resize
         */
        window.addEventListener('resize', function () {
            updateBundleProducts();
        });

    });



    /*
    |--------------------------------------------------------------------------
    | NORMAL PRODUCTS
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.normal-category-block').forEach(function (category) {

        const wrapper = category.querySelector('.normal-products-wrapper');
        const showMoreBtn = category.querySelector('.normal-expand-btn');
        const categoryToggle = category.querySelector('.normal-category-toggle');

        if (!wrapper) {
            return;
        }

        const products = Array.from(
            wrapper.querySelectorAll('.normal-product-item')
        );

        const expandWrapper = category.querySelector('.normal-expand-wrapper');

        let expanded = false;


        /*
         * Show first 4 products only on mobile.
         */
        function updateNormalProducts() {

            const isMobile = window.innerWidth <= 767.98;

            if (!isMobile || expanded) {

                products.forEach(function (product) {
                    product.classList.remove('mobile-hidden-product');
                });

                if (expandWrapper && products.length <= 4) {
                    expandWrapper.style.display = 'none';
                }

                return;
            }


            products.forEach(function (product, index) {

                if (index >= 4) {
                    product.classList.add('mobile-hidden-product');
                } else {
                    product.classList.remove('mobile-hidden-product');
                }

            });

        }


        /*
         * Show More / Show Less
         */
        if (showMoreBtn) {

            if (products.length <= 4) {
                showMoreBtn.parentElement.style.display = 'none';
            }

            showMoreBtn.addEventListener('click', function () {

                expanded = !expanded;

                updateNormalProducts();

                showMoreBtn.classList.toggle('expanded', expanded);

                const text = showMoreBtn.querySelector('.normal-expand-text');

                if (text) {
                    text.textContent = expanded
                        ? 'Show Less'
                        : 'Show More';
                }

            });
        }


        /*
         * Category header expand / collapse
         */
        if (categoryToggle) {

            categoryToggle.addEventListener('click', function () {

                const isExpanded =
                    categoryToggle.getAttribute('aria-expanded') === 'true';

                if (isExpanded) {

                    categoryToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                    categoryToggle.classList.add('collapsed');

                    wrapper.style.display = 'none';

                    if (expandWrapper) {
                        expandWrapper.style.display = 'none';
                    }

                } else {

                    categoryToggle.setAttribute(
                        'aria-expanded',
                        'true'
                    );

                    categoryToggle.classList.remove('collapsed');

                    wrapper.style.display = '';

                    if (expandWrapper && products.length > 4) {
                        expandWrapper.style.display = 'flex';
                    }

                    updateNormalProducts();
                }

            });
        }


        /*
         * Initial state
         */
        updateNormalProducts();


        /*
         * Handle resize
         */
        window.addEventListener('resize', function () {
            updateNormalProducts();
        });

    });

});
</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       BUNDLE EXPAND / COLLAPSE
       ===================================================== */

    document.querySelectorAll('.bundle-category-block').forEach(function (bundle) {

        const wrapper = bundle.querySelector('.bundle-products-wrapper');
        const button = bundle.querySelector('.bundle-expand-btn');

        if (!wrapper || !button) {
            return;
        }

        button.addEventListener('click', function () {

            const expanded =
                wrapper.classList.toggle('bundle-expanded');

            button.classList.toggle('expanded', expanded);

            button.setAttribute(
                'aria-expanded',
                expanded ? 'true' : 'false'
            );

            const text = button.querySelector('.bundle-expand-text');

            if (text) {
                text.textContent = expanded
                    ? 'Show Less'
                    : 'Show More';
            }

        });

    });


    /* =====================================================
       NORMAL PRODUCT EXPAND / COLLAPSE
       ===================================================== */

    document.querySelectorAll('.normal-category-block').forEach(function (category) {

        const wrapper =
            category.querySelector('.normal-products-wrapper');

        const button =
            category.querySelector('.normal-expand-btn');

        if (!wrapper || !button) {
            return;
        }

        button.addEventListener('click', function () {

            const expanded =
                wrapper.classList.toggle('normal-expanded');

            button.classList.toggle('expanded', expanded);

            button.setAttribute(
                'aria-expanded',
                expanded ? 'true' : 'false'
            );

            const text =
                button.querySelector('.normal-expand-text');

            if (text) {
                text.textContent = expanded
                    ? 'Show Less'
                    : 'Show More';
            }

        });

    });

});
</script> --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
        $(document).on('click', '.plus-btn3', function () {
            let sizeId = $(this).data('size-id');
            let $input = $(`#size-${sizeId}`);
            let currentVal = parseInt($input.val()) || 0;
            $input.val(currentVal + 1).trigger('change');
        });

        $(document).on('click', '.minus-btn3', function () {
            let sizeId = $(this).data('size-id');
            let $input = $(`#size-${sizeId}`);
            let currentVal = parseInt($input.val()) || 0;
            if (currentVal > 0) {
                $input.val(currentVal - 1).trigger('change');
            }
        });
        $(document).on('click', '.minus-btn4', function () {
            let sizeId = $(this).data('size-id');
            let $input = $(`#bundle-size-${sizeId}`);
            let currentVal = parseInt($input.val()) || 0;
            if (currentVal > 0) {
                $input.val(currentVal - 1).trigger('change');
            }
        });
        $(document).on('click', '.plus-btn4', function () {
            let sizeId = $(this).data('size-id');
            let $input = $(`#bundle-size-${sizeId}`);
            let currentVal = parseInt($input.val()) || 0;
            $input.val(currentVal + 1).trigger('change');
        });
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.product-swiper').forEach(function (el) {
            const swiper = new Swiper(el, {
                loop: true,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                pagination: {
                    el: el.querySelector('.swiper-pagination'),
                    clickable: true,
                },
                grabCursor: true,
                autoplay: false,
            });

            el.addEventListener('mouseenter', function () {
                swiper.params.autoplay = {
                    delay: 1000,
                    disableOnInteraction: false
                };
                swiper.autoplay.start();
            });

            el.addEventListener('mouseleave', function () {
                swiper.autoplay.stop();
                swiper.slideToLoop(0, 500);
            });
        });
    });
</script>



<script>
    $(document).ready(function () {

        $('.add_cart_btn').on('click', function (event) {
            event.preventDefault();

            const productId = $(this).val();

            $('#modal_product_id').val(productId);

            // Step 1: Fetch product sizes first
            $.ajax({
                url: "{{ makeStoreDomainRoute('getProductSizes') }}",
                method: 'POST',
                data: {
                    product_id: productId,
                    store_id: '{{ $store->id }}',
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (response) {

                let sizesHtml = ``;

                /* -----------------------------------------
                SUB TEAM DROPDOWN
                ------------------------------------------ */
                const subTeamInfo = @json($sub_team_info);
                let subTeamSelect = ``;

                if (subTeamInfo && subTeamInfo.options) {
                    let optionsArray = [];
                    try {
                        optionsArray = JSON.parse(subTeamInfo.options);
                    } catch (e) {
                        console.error("Invalid JSON in subTeamInfo.options:", e);
                    }

                    if (optionsArray.length > 0) {
                        subTeamSelect = `
                            <div class="px-3 pb-3">
                            <label class="size_name_lable fw-semibold">Sub Team</label>
                            <select class="form-control size-dropdown subTeam" id="subTeam" required>
                                <option value="">Select a sub team</option>
                                ${optionsArray.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                            </select>
                        </div>
                        `;
                    }
                }

                /* -----------------------------------------
                CUSTOMIZE NAME / NUMBER
                ------------------------------------------ */

                const IND_NAME = response.product.individual_name_details;
                const IND_NUM = response.product.individual_number_details;

                let commentSection = ``;
                let customizeName = ``;
                let customizeNumber = ``;

                if (response.product.set_individual_name == 1 || response.product.set_individual_number == 1) {
                    commentSection = `<span class="font_size13 fw-bold p-2 d-block">Customize Item</span>`;
                }

                // Name field
                if (response.product.set_individual_name == 1 && IND_NAME) {
                    customizeName = `
                        <div class="px-3 pb-2">
                            <span class="font_size13 fw-semibold">Add Name</span>
                            <input
                                type="text"
                                class="form-control text_input input_width customize_name_single ind-name mt-1
                                {{ $teamStore->theme == 1 ? 'input_dark' : '' }}"
                                data-product-id="${response.product.id}"
                                id="customize_name_single_${response.product.id}"
                                maxlength="${IND_NAME.name_character_limit ?? 10}"
                                title="Character Limit : ${(IND_NAME.name_character_limit ?? 10)}"
                                data-bs-toggle="tooltip"
                                data-bs-html="true"
                                ${IND_NAME.name_required == 1 ? 'required' : ''}
                            >
                            ${IND_NAME.name_not_for_printing == 1
                                ? `<span class="text-danger" style="font-size:.8rem;">(Not for printing)</span>`
                                : ''}
                        </div>
                    `;
                }

                // Number field
                if (response.product.set_individual_number == 1 && IND_NUM) {
                    customizeNumber = `
                        <div class="px-3 pb-3">
                            <span class="font_size13 fw-semibold">Add Number</span>
                            <input
                                type="${IND_NUM.number_type === 'custom' ? 'text' : 'number'}"
                                class="form-control number_input input_width customize_number_single ind-number mt-1
                                {{ $teamStore->theme == 1 ? 'input_dark' : '' }}"
                                data-product-id="${response.product.id}"
                                id="customize_number_single_${response.product.id}"
                                maxlength="${IND_NUM.max_number_count ?? 5}"
                                min="0"
                                data-bs-toggle="tooltip"
                                data-bs-html="true"
                                title="Number Range : ${(IND_NUM.min_number ?? 0)} to ${(IND_NUM.max_number ?? 0)}
                                    <br>Number Count : ${(IND_NUM.min_number_count ?? 0)} to ${(IND_NUM.max_number_count ?? 0)}"
                                ${IND_NUM.number_required == 1 ? 'required' : ''}
                            >
                            <a href="#" class="gray_font view_available_numbers" data-product-id="${response.product.id}">
                                View number list
                            </a>
                        </div>
                    `;
                }

                /* -----------------------------------------
                SIZE + QUANTITY SECTION
                ------------------------------------------ */

                let sizeQtySection = ``;

                if (response.product.sizes && response.product.sizes.length > 0) {

                    sizeQtySection = `
                        <div class="px-3 pb-3">
                            <label class="size_name_lable fw-semibold">Select Size</label>
                            <select class="form-control size-dropdown mt-1" id="size-dropdown-${response.product.id}">
                                <option value="">-- Select Size --</option>
                                ${response.product.sizes.map(el =>
                                    el.size ? `<option value="${el.size_id}">${el.size.size_name}</option>` : ``
                                ).join('')}
                            </select>
                        </div>

                        <div class="px-3 pb-3">
                            <label class="size_name_lable fw-semibold">Quantity</label>

                            <div class="input-group mt-1" style="max-width:160px;">
                                <button type="button"
                                    class="btn btn-outline-secondary single-minus {{ $teamStore->theme == 1 ? 'minPus_btn_dark' : '' }}">
                                    -
                                </button>

                                <input type="number"
                                    min="${response.product.moq}"
                                    max="${response.product.maxoq}"
                                    step="1"
                                    data-product-id="${response.product.id}"
                                    value="${response.product.moq}"
                                    class="form-control text-center single-qty sizes_inputs number_input {{ $teamStore->theme == 1 ? 'input_dark' : '' }}"
                                    style="height:38px;">

                                <button type="button"
                                    class="btn btn-outline-secondary single-plus {{ $teamStore->theme == 1 ? 'minPus_btn_dark' : '' }}">
                                    +
                                </button>
                            </div>
                        </div>
                    `;
                } else {
                    sizeQtySection = `<p class="text-danger px-3 pb-3">No sizes available for this product.</p>`;
                }

                /* -----------------------------------------
                COMBINE EVERYTHING
                ------------------------------------------ */
                sizesHtml =
                    subTeamSelect +
                    commentSection +
                    customizeName +
                    customizeNumber +
                    sizeQtySection;

                // Increase quantity
                $(document).on("click", ".single-plus", function () {
                    const input = $(this).siblings("input.single-qty");
                    const value = parseInt(input.val()) || 0;
                    const max = parseInt(input.attr("max"));

                    if (!isNaN(max) && value >= max) return;

                    input.val(value + 1).trigger("change");
                });

                // Decrease quantity
                $(document).on("click", ".single-minus", function () {
                    const input = $(this).siblings("input.single-qty");
                    const value = parseInt(input.val()) || 0;
                    const min = parseInt(input.attr("min")) || 0;

                    if (value <= min) {
                        input.val(min);
                        return;
                    }

                    input.val(value - 1).trigger("change");
                });

                $("#sizesModalBody").html(sizesHtml);
                $("#sizesModal").modal("show");
            },

                error: function (xhr) {
                    let errorMessage = "Failed to fetch product sizes. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: errorMessage,
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true
                    });
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            })
        });

        $(document).on('click', '.updateCartProductDetails', function() {

            let allValid = true;

            if($('#subTeam').length){
                if(!$('#subTeam').val()){
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: 'Please select a sub team.',
                        showConfirmButton: false,
                        timer: 2500,
                        toast: true
                    });
                    return;
                }
            }
            let allSizesSelected = true;

            $('.size-dropdown').each(function () {
                if ($(this).val() === "" || $(this).val() === null) {
                    allSizesSelected = false;
                    return false;
                }
            });

            if (!allSizesSelected) {
                Swal.fire({
                    position: 'top',
                    icon: 'warning',
                    title: 'Please select size for the product.',
                    showConfirmButton: false,
                    timer: 2500,
                    toast: true
                });
                return;
            }
            if($('.sizes_inputs').length === 0){
                Swal.fire({
                    position: 'top',
                    icon: 'warning',
                    title: 'No sizes available to add to cart.',
                    showConfirmButton: false,
                    timer: 2500,
                    toast: true
                });
                return;
            }
            if($('.sizes_inputs').length > 0){
                let totalQty = 0;
                $('.sizes_inputs').each(function() {
                    var qty = parseInt($(this).val()) || 0;
                    totalQty += qty;
                });
                if(totalQty === 0){
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: 'Please add selected size quantity to add to cart.',
                        showConfirmButton: false,
                        timer: 2500,
                        toast: true
                    });
                    return;
                }
            }

            $('#sizesModalBody').find('input[required], select[required], textarea[required]').each(function () {
                if ($(this).val().trim() == '') {
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: `Please fill required custom input fields.`,
                        showConfirmButton: false,
                        timer: 2500,
                        toast: true
                    });
                    $(this).focus();
                    allValid = false;
                    return false;
                }
            });

            if (!allValid) {
                return;
            }

            const productId = $('#modal_product_id').val();

            var sizesData = {};
            $('.sizes_inputs').each(function() {

                var productId = $(this).data('product-id');
                var sizeId = $('#size-dropdown-'+productId).val();
                var qty = parseInt($(this).val()) || 0;

                if (qty > 0) {
                    sizesData[sizeId] = qty;
                }
            });

            let bundleNumbers = {};

            $('.ind-number').each(function () {
                let productId = $(this).data('product-id');
                let value = $(this).val();

                if (productId) {
                    bundleNumbers[productId] = value;
                }
            });

            let bundleNames = {};

            $('.ind-name').each(function () {
                let productId = $(this).data('product-id');
                let value = $(this).val();

                if (productId) {
                    bundleNames[productId] = value;
                }
            });

            var subTeam = $('#subTeam').length ? $('#subTeam').val() : null;

            $.ajax({
                url: "{{ makeStoreDomainRoute('cartAddStore') }}",
                method: 'POST',
                data: {
                    product_id: productId,
                    store_id: '{{ $store->id }}',
                    sizes: sizesData,
                    sub_team: subTeam,
                    bundleNumbers: bundleNumbers,
                    bundleNames: bundleNames,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (response) {
                    updateCart();
                    $('#sizesModal').modal('hide');

                    Swal.fire({
                        position: 'top',
                        icon: response.success ? 'success' : 'warning',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 4000,
                        toast: true
                    });
                },
                error: function (xhr) {
                    let errorMessage = "Failed to add product to cart. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: errorMessage,
                        showConfirmButton: false,
                        timer: 2500,
                        toast: true
                    });
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });

        $(document).on('click', '.updateCartBundleProductDetails', function() {

            let allValid = true;

            let productGroups = {};

            if($('#subTeamBundle').length){
                if(!$('#subTeamBundle').val()){
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: 'Please select a sub team.',
                        showConfirmButton: false,
                        timer: 2500,
                        toast: true
                    });
                    return;
                }
            }

            let allSizesSelected = true;

            $('.bundle-size-select').each(function () {
                if ($(this).val() === "" || $(this).val() === null) {
                    allSizesSelected = false;
                    return false; // stop loop immediately
                }
            });

            if (!allSizesSelected) {
                Swal.fire({
                    position: 'top',
                    icon: 'warning',
                    title: 'Please select size for all products.',
                    showConfirmButton: false,
                    timer: 2500,
                    toast: true
                });
                return;
            }

            if ($('.bundle-size-qty').length === 0) {
                Swal.fire({
                    position: 'top',
                    icon: 'warning',
                    title: 'No sizes available to add to cart.',
                    showConfirmButton: false,
                    timer: 2500,
                    toast: true
                });
                return;
            }

            $('.bundle-size-qty').each(function() {
                const productId = $(this).data('product-id');
                if (!productGroups[productId]) {
                    productGroups[productId] = [];
                }
                productGroups[productId].push($(this));
            });

            for (const [productId, inputs] of Object.entries(productGroups)) {
                let hasValidSize = false;

                inputs.forEach(input => {
                    const qty = parseInt($(input).val(), 10);
                    if (qty && qty > 0) {
                        hasValidSize = true;
                    }
                });

                if (!hasValidSize) {
                    allValid = false;
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: `You must select at least one size quantity for product each product in the bundle.`,
                        showConfirmButton: false,
                        timer: 2500,
                        toast: true
                    });
                    break;
                }
            }

            if (!allValid) return;

            $('#sizesModalBundleBody').find('input[required], select[required], textarea[required]').each(function () {
                if ($(this).val().trim() == '') {
                    Swal.fire({
                        position: 'top',
                        icon: 'warning',
                        title: `Please fill required custom input fields.`,
                        showConfirmButton: false,
                        timer: 2500,
                        toast: true
                    });
                    $(this).focus();
                    allValid = false;
                    return false;
                }
            });

            if (!allValid) {
                return;
            }

            var sizesData = {};

            $('.bundle-size-qty').each(function() {
                var productId = $(this).data('product-id');
                var sizeId = $('#bundle-size-select-'+productId).val();
                var qty = parseInt($(this).val()) || 0;
                if (qty > 0){
                    if (!sizesData[productId]) {
                        sizesData[productId] = {};
                    }
                    sizesData[productId][sizeId] = qty;
                }
            });

            let bundleNumbers = {};

            $('.bundle-numbers').each(function () {
                let productId = $(this).data('product-id');
                let value = $(this).val();

                if (productId) {
                    bundleNumbers[productId] = value;
                }
            });

            let bundleNames = {};

            $('.bundle-names').each(function () {
                let productId = $(this).data('product-id');
                let value = $(this).val();

                if (productId) {
                    bundleNames[productId] = value;
                }
            });

            var subTeam = $('#subTeamBundle').length ? $('#subTeamBundle').val() : null;

            $.ajax({
                url: "{{ makeStoreDomainRoute('cartAddBundleStore') }}",
                method: 'POST',
                data: {
                    store_id: '{{ $store->id }}',
                    bundle_sizes: sizesData,
                    bundleNumbers: bundleNumbers,
                    bundleNames: bundleNames,
                    sub_team: subTeam,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (response) {
                    updateCart();
                    $('#sizesModalBundle').modal('hide');

                    Swal.fire({
                        position: 'top',
                        icon: response.success ? 'success' : 'warning',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 4000,
                        toast: true
                    });
                },
                error: function (xhr) {
                    let errorMessage = "Failed to add bundle to cart. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: errorMessage,
                        showConfirmButton: false,
                        timer: 2500,
                        toast: true
                    });
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });


        $(document).on('click', '.add-bundle', function() {
            let productIds = $(this).data('product-ids');
            $.ajax({
                url: "{{ makeStoreDomainRoute('getBundleProductSizes') }}",
                method: 'POST',
                data: {
                    product_ids: productIds,
                    store_id: '{{ $store->id }}',
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (response) {
                    const assetBase = "{{ asset('') }}";

                    if (response.products && response.products.length > 0) {
                        let sizesHtml = ``;

                        var subTeamInfo = @json($sub_team_info);
                        var subTeamSelect = '';

                        // Build sub-team dropdown
                        if (subTeamInfo && subTeamInfo.options) {
                            let optionsArray = [];
                            try {
                                optionsArray = JSON.parse(subTeamInfo.options);
                            } catch (e) {
                                console.error("Invalid JSON in subTeamInfo.options:", e);
                            }

                            if (optionsArray.length > 0) {
                                subTeamSelect += `
                                    <div class="bundle-product-section mb-2" style="border-bottom: 1px solid #e4e4e4;">
                                        <div class="mb-3">
                                            <span class="font_size13">Sub Team</span><br>
                                            <div class="size_div" style="border: 1px solid #b3b3b3; padding: .1rem;">
                                                <select class="size_selection subTeam" id="subTeamBundle" required>
                                                    <option value="">Select a sub team</option>
                                                    ${optionsArray.map(option => `
                                                        <option value="${option}">${option}</option>
                                                    `).join('')}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                        }

                        sizesHtml += subTeamSelect;

                        // Loop products
                        response.products.forEach(product => {

                            let customizeName = '';
                            let customizeNumber = '';
                            let commentSection = '';

                            commentSection = (product.set_individual_name == 1 || product.set_individual_number == 1)
                                ? `<div class="col-md-12"><span class="font_size13" style="font-weight: 700;">Customize Item</span></div>`
                                : '';

                            // Customize Name
                            if (product.individual_name_details && product.set_individual_name == 1) {
                                customizeName = `
                                    <div class="col-md-3">
                                        <span class="font_size13">Add Name</span><br>
                                        <input
                                            title="Character Limit : ${(product.individual_name_details.name_character_limit ?? 10)}"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            type="text"
                                            data-product-id="${product.id}"
                                            id="customize_name_single_${product.id}"
                                            class="form-control text_input input_width customize_name_single bundle-names"
                                            maxlength="${(product.individual_name_details.name_character_limit ?? 10)}"
                                            ${(product.individual_name_details.name_required == 1) ? 'required' : ''}
                                        >
                                        ${(product.individual_name_details.name_not_for_printing == 1)
                                            ? `<span class="text-danger" style="font-size: .8rem;">(Not for printing)</span>`
                                            : ''}
                                    </div>
                                `;
                            }

                            // Customize Number
                            if (product.individual_number_details && product.set_individual_number == 1) {
                                customizeNumber = `
                                    <div class="col-md-3">
                                        <span class="font_size13">Add Number</span><br>
                                        <input
                                            title="Number Range : ${(product.individual_number_details.min_number ?? 0)} to ${(product.individual_number_details.max_number ?? 0)} <br>
                                            Number Count : ${(product.individual_number_details.min_number_count ?? 0)} to ${(product.individual_number_details.max_number_count ?? 0)}"
                                            data-bs-toggle="tooltip"
                                            data-bs-html="true"
                                            data-product-id="${product.id}"
                                            type="${(product.individual_number_details.number_type === 'custom') ? 'text' : 'number'}"
                                            class="form-control number_input input_width customize_number_single bundle-numbers"
                                            id="customize_number_single_${product.id}"
                                            maxlength="${(product.individual_number_details.max_number_count ?? 5)}"
                                            min="0"
                                            ${(product.individual_number_details.number_required == 1) ? 'required' : ''}
                                        >
                                        <a href="#" data-product-id="${product.id}" class="gray_font view_available_numbers">View number list</a>
                                    </div>
                                `;
                            }

                            // Product image
                            let imageUrl = (product.images && product.images.length > 0)
                                ? assetBase + product.images[0].url
                                : assetBase + 'assets/img/products/default-loading.gif';

                            // PRODUCT BLOCK
                            sizesHtml += `
                                <div class="bundle-product-section mb-2" style="border-bottom: 1px solid #e4e4e4;">
                                    <div class="d-flex align-items-center mb-2" style="padding-bottom: 8px;">
                                        <img src="${imageUrl}"
                                            alt="${product.product_name}"
                                            style="width: auto; height: 4rem; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                        <h5 class="mb-0" style="font-size: 15px;">${product.product_name}</h5>
                                    </div>

                                    <div class="row mb-3">
                                        ${commentSection}
                                        ${customizeName}
                                        ${customizeNumber}
                                        ${product.sizes && product.sizes.length > 0 ? `
                                            <div class="col-md-3">
                                                <label class="font_size13 mb-1">Select Size</label>
                                                <select class="form-control bundle-size-select" id="bundle-size-select-${product.id}">
                                                    <option value="">Choose size</option>
                                                    ${product.sizes.map(s => `
                                                        <option value="${s.size_id}">${s.size.size_name}</option>
                                                    `).join('')}
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="font_size13 mb-1">Quantity</label>

                                                <div class="input-group mt-1" style="max-width:160px;">
                                                    <button type="button"
                                                        class="btn btn-outline-secondary bundle-qty-minus {{ $teamStore->theme == 1 ? 'minPus_btn_dark' : '' }}">
                                                        -
                                                    </button>

                                                    <input type="number"
                                                        min="${product.moq}"
                                                        max="${product.maxoq}"
                                                        step="1"
                                                        value="${product.moq}"
                                                        data-product-id="${product.id}"
                                                        class="form-control text-center bundle-size-qty sizes_inputs number_input {{ $teamStore->theme == 1 ? 'input_dark' : '' }}"
                                                        style="height:38px;">

                                                    <button type="button"
                                                        class="btn btn-outline-secondary bundle-qty-plus {{ $teamStore->theme == 1 ? 'minPus_btn_dark' : '' }}">
                                                        +
                                                    </button>
                                                </div>
                                            </div>
                                        ` : `<p style="color:red;">No sizes available for this product.</p>`}
                                    </div>
                                </div>
                            `;
                        });

                        $('#sizesModalBundleBody').html(sizesHtml);
                    } else {
                        $('#sizesModalBundleBody').html(`<p style="color:red;">No products or sizes available in this bundle.</p>`);
                    }

                    // Increase bundle quantity
                    $(document).on("click", ".bundle-qty-plus", function () {
                        const input = $(this).siblings("input");
                        const value = parseInt(input.val(), 10) || 0;
                        const max = parseInt(input.attr("max"), 10);

                        if (!isNaN(max) && value >= max) return;

                        input.val(value + 1).trigger('change');
                    });

                    // Decrease bundle quantity
                    $(document).on("click", ".bundle-qty-minus", function () {
                        const input = $(this).siblings("input");
                        const value = parseInt(input.val(), 10) || 0;
                        const min = parseInt(input.attr("min"), 10) || 0;

                        if (value <= min) {
                            input.val(min);
                            return;
                        }

                        input.val(value - 1).trigger('change');
                    });


                    $('#sizesModalBundle').modal('show');
                },

                error: function (xhr) {
                    let errorMessage = "Failed to fetch product sizes. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: errorMessage,
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true
                    });
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        });


        var closeDateUTC = new Date('{{ $store->close_date }}');

        var closeDatePST = new Date(closeDateUTC.toLocaleString('en-US', { timeZone: 'America/Los_Angeles' }));

        function updateCountdown() {
            var nowUTC = new Date();
            var nowPST = new Date(nowUTC.toLocaleString('en-US', { timeZone: 'America/Los_Angeles' }));

            var distance = closeDatePST - nowPST;

            if (distance < 0) {
                $('#days').text('00');
                $('#hrs').text('00');
                $('#mins').text('00');
                $('#sec').text('00');
                return;
            }

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $('#days').text(String(days).padStart(2, '0'));
            $('#hrs').text(String(hours).padStart(2, '0'));
            $('#mins').text(String(minutes).padStart(2, '0'));
            $('#sec').text(String(seconds).padStart(2, '0'));
        }


            updateCountdown();

            setInterval(updateCountdown, 1000);

    });

    $(document).on('change', '.customize_name_single', function() {
        validateInputName($(this));
    });
    $(document).on('change','.customize_number_single', function() {
        validateInputNumber($(this));
    });
    $(document).on("click", ".view_available_numbers", function (e) {
        updateAvailableNumbers($(this));
    });
    $(document).on('change', 'input[type="number"]', function() {
        var min = parseInt($(this).attr('min')) || 0;
        var max = parseInt($(this).attr('max')) || Infinity;
        var value = parseInt($(this).val()) || 0;

        if (value < min) {
            $(this).val(min);
        } else if (value > max) {
            $(this).val(max);
        }
    });
    function updateAvailableNumbers(inputElement) {

        var $subTeamInput = inputElement.closest('.modal-body').find('.subTeam');
        var productId = inputElement.data('product-id');

        if ($subTeamInput.length && $subTeamInput.val() === '') {
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

        var subTeam = ($subTeamInput.length && $subTeamInput.val() !== '') ? $subTeamInput.val() : null;

        $.ajax({
            url: "{{ makeStoreDomainRoute('get_available_numbers') }}",
            method: 'GET',
            data: {
                'store_product_id': productId,
                'sub_team': subTeam,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {

                var availableNumbersBody = $('#availableNumbersBody');
                availableNumbersBody.empty();

                var numberList = response.number_list;
                var orderedNumbers = response.orderedNumbers;
                var exclusiveNumbers = response.exclusiveNumbers;
                var productNumberDetails = response.store_product_details.individual_number_details;

                // $('#customize_number_single').attr('maxLength', response.max_number_count ?? 5);

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
                        $('#customize_number_single_'+productId).val($(this).val()).trigger('change');
                        // $(this).closest('label').addClass('checked');
                        $('#display_available_numbers').modal('hide');

                    } else {

                        // $(this).closest('label').removeClass('checked');
                        $('#customize_number_single_'+productId).val('');
                        $('#display_available_numbers').modal('hide');

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
    function validateInputName(inputElement) {

        var value = inputElement.val();
        var subTeamInput = inputElement.closest('.modal-body').find('.subTeam');
        var productId = inputElement.data('product-id');

        if (subTeamInput.length && subTeamInput.val() === '') {
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

        var subTeam = (subTeamInput.length && subTeamInput.val() !== '') ? subTeamInput.val() : null;

        var inputData = {
            customName: value,
            sub_team: subTeam,
            store_product_id: productId,
            _token: "{{ csrf_token() }}"
        };

        $(".se-pre-con").fadeIn('slow');

        $.ajax({
            url: "{{ makeStoreDomainRoute('validateCustomerInputName') }}",
            method: 'POST',
            data: inputData,
            success: function(response) {
                $('#customize_name_single_'+productId).removeClass('is-invalid').addClass('is-valid').val(value);
                $(".se-pre-con").fadeOut('slow');
            },
            error: function(xhr) {
                var response = xhr.responseJSON;
                console.error('Validation failed:', response?.error || 'Unknown error');
                $('#customize_name_single_'+productId).removeClass('is-valid').addClass('is-invalid').val(value);
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
    function validateInputNumber(inputElement) {

        var value = inputElement.val();
        var subTeamInput = inputElement.closest('.modal-body').find('.subTeam');
        var productId = inputElement.data('product-id');

        if (subTeamInput.length && subTeamInput.val() === '') {
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

        var subTeam = (subTeamInput.length && subTeamInput.val() !== '') ? subTeamInput.val() : null;

        var inputData = {
            customNumber: value,
            team_name: subTeam,
            store_product_id: productId,
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

                $('#customize_number_single_'+productId).removeClass('is-invalid').addClass('is-valid').val(value);
                $(".se-pre-con").fadeOut('slow');
            },
            error: function(xhr) {
                var response = xhr.responseJSON;
                console.error('Validation failed:', response?.error || 'Unknown error');

                $('#customize_number_single_'+productId).removeClass('is-valid').addClass('is-invalid').val(value);
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

@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: "success",
                title: "Success!",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000
            });
        });
    </script>
@endif
