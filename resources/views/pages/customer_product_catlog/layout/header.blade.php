<style>
    .image_width {
        width: -webkit-fill-available;
        height: 80px;
    }
    @media (min-width: 2048px) {

        .image_width {
            width: 72% !important;
            max-width: 72% !important;
            min-width: 72% !important;
        }
    }
    .search_card {
        border: 1px solid rgb(228, 228, 228);
        border-radius: 23px;
    }
    .search_icon_div {
        background-color: rgb(245, 245, 245);
        padding-top: 38px;
        border-top-right-radius: 19px;
        border-bottom-right-radius: 19px;
    }
    .search_icon_position {
        position: relative;
        top: -29px;
        right: 11px;
    }
    .text-center {
        text-align: left !important;
    }
    @media (max-width: 992px) {

        .text-center {
            text-align: center !important;
        }
        .small_screen_search {
            padding-left: 45px !important;
        }
        .head_p {
            text-align: center;
        }
        .paddin_top_10 {
            padding-top: 10px;
        }
    }
    .text_dark_gray {
        color: rgb(80, 80, 80);
    }
    .text_dark_gray span {
        color: rgb(80, 80, 80) !important;
        font-weight: 400;
    }

     /* Default (small screens) → sidebar mode */
.filter-sidebar {
    position: fixed;
    top: 0;
    right: -300px;
    width: 300px;
    height: 100%;
    background: #fff;
    box-shadow: -2px 0 5px rgba(0,0,0,0.3);
    transition: right 0.3s ease-in-out;
    z-index: 1050;
    overflow-y: auto;
}

/* Show when active */
.filter-sidebar.active {
    right: 0;
    background: #fff;
}

/* Overlay (small screens) */
.filter-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    z-index: 1040;
}
.filter-overlay.active {
    display: block;
}

/* Sidebar header */
.filter-sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #ddd;
}

.close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
}

/* Large screens → normal view */
@media (min-width: 992px) {
    .filter-toggle { /* Hide hamburger */
        display: none;
    }
    .filter-sidebar {
        position: relative;
        right: 0;
        width: 100%;
        height: auto;
        box-shadow: none;
        overflow: visible;
        transition: none;
        z-index: 1 !important;
    }
    .filter-sidebar-header { /* Hide close button and title */
        display: none;
    }
    .filter-overlay {
        display: none !important;
    }
    .small_screen_search {
        padding-left: 45px !important;
    }

}

@media (max-width: 992px) {
    .filter_div_space {
        padding-left: unset !important;
    }
    .max_width_at_min {
        min-width: 90px;
    }
    .small_screen_search {
        padding-left: 45px !important;
    }
}
.filter-sidebar {
    background-color: transparent;
}
@media (min-width: 1536px){

    .product-link {
        font-size: 1.5rem;
        /* color: rgba(202, 201, 201, 1); */
    }
    .slider-img {
        width: 100% !important;
    }
    .image_class_link {
        width: 95% ;
    }
    .group_topic {
        font-size: 1.7rem;
        font-weight: 600;
    }
    .filter_text {
        font-size: 1rem;
        margin-bottom: 10px !important;
    }
    .custom-select-box {
        font-size: 1rem;
        width: 165px;
        height: 35px;
    }
    #mainCategories option {
    font-size: 1rem; /* dropdown options podi */
    }
    .image_width_logo {
        height: 100px !important;
    }
    .head_p {
        font-size: 30px;
    }
    .item_count {
        font-size: 20px;
    }
    .product_count {
        padding-right: 6.5rem;
    }
    .sub-header-style {
        font-size: 1.5rem;
    }
    .font_size_13 {
        font-size: 17px !important;
    }
    .flag_img {
        width: 30px;
    }
    .container_style {
        padding-top: 105px;
    }

}

@media (max-width: 768px) {
    .small_screen_search {
        display: none;
    }
}

/* =========================================================
   MOBILE HEADER ONLY
   Desktop remains completely unchanged
   ========================================================= */

/* =========================================================
   MOBILE HEADER
   Desktop completely unchanged
   ========================================================= */

@media (max-width: 768px) {

    /* ---------------------------------------------
       Sticky header
       --------------------------------------------- */

    .mobile-sticky-header {
        position: fixed !important;
        top: 0px !important;

        z-index: 1030 !important;

        width: 100% !important;

        background: #fff !important;

        padding: 0 10px 12px !important;

        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);

        /* Prevent content showing behind header */
        isolation: isolate;
    }


    /* ---------------------------------------------
       Main row
       --------------------------------------------- */

    .mobile-sticky-header .customer-header-row {
        position: relative !important;

        display: flex !important;
        flex-wrap: wrap !important;

        margin: 0 !important;
    }


    /* ---------------------------------------------
       ROW 1 - LOGO
       --------------------------------------------- */

    .mobile-logo {
        order: 1 !important;

        width: 100% !important;
        max-width: 100% !important;

        height: 58px;

        padding: 0 !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        position: relative !important;
    }

    .mobile-logo > * {
        margin-left: auto !important;
        margin-right: auto !important;
    }


    /* ---------------------------------------------
       TOGGLE - LEFT SIDE
       --------------------------------------------- */

    .mobile-header-actions {
        order: 0 !important;

        position: absolute !important;

        top: 0 !important;
        left: 0 !important;

        width: 100% !important;
        height: 58px !important;

        padding: 0 8px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;

        pointer-events: none;

        z-index: 10 !important;
    }

    .mobile-toggle-wrapper {
        padding: 0 !important;
        margin: 0 !important;
        padding-top: 50px !important;
        pointer-events: auto;
    }

    .mobile-toggle-button {
        width: 40px !important;
        height: 40px !important;

        padding: 0 !important;
        margin: 0 !important;

        border: 1px solid #e4e4e4 !important;
        border-radius: 12px !important;

        background: #f8f8f8 !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        font-size: 20px !important;
        line-height: 1 !important;

        color: #333 !important;

        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);

        transition: all 0.2s ease;
    }

    .mobile-toggle-button:active {
        transform: scale(0.94);
    }


    /* ---------------------------------------------
       ROW 2 - APPAREL CATALOG
       Actual <a> remains clickable
       --------------------------------------------- */

    .mobile-header-actions {
        height: 108px !important;
    }

    .mobile-catalog-link {
        position: absolute !important;

        top: 68px !important;
        left: 50% !important;

        transform: translateX(-50%) !important;

        display: block !important;

        width: max-content !important;

        padding: 7px 16px !important;

        text-decoration: none !important;

        z-index: 15 !important;

        pointer-events: auto !important;
    }

    .mobile-catalog-link .mobile-catalog-text,
    .mobile-catalog-link .head_p {
        margin: 0 !important;

        padding: 0 !important;

        display: block !important;

        font-size: 15px !important;

        font-weight: 700 !important;

        letter-spacing: 0.7px;

        line-height: 20px;

        color: #252525 !important;

        text-align: center !important;
    }

    .mobile-catalog-link:active {
        transform: translateX(-50%) scale(0.97) !important;
    }


    /* ---------------------------------------------
       Divider
       --------------------------------------------- */

    .mobile-header-actions::after {
        content: "";

        position: absolute;

        left: 0;
        right: 0;

        bottom: 0;

        height: 1px;

        background: #eeeeee;
    }


    /* ---------------------------------------------
       ROW 3 - SEARCH
       --------------------------------------------- */

    .mobile-search {
        order: 3 !important;

        width: 100% !important;
        max-width: 100% !important;

        padding: 10px 2px 0 !important;

        margin-top: 29px !important;

        display: block !important;
    }

    .mobile-search .customer-search-wrapper,
    .mobile-search .customer-search-column {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .mobile-search .customer-search-box {
        width: 100% !important;

        margin: 0 !important;

        background: transparent !important;
    }


    /* Search input box */

    .mobile-search .customer-search-input-wrapper {
        height: 46px !important;

        margin-top: 0 !important;

        padding: 5px 10px !important;

        background: #f7f7f7 !important;

        border: 1px solid #e1e1e1 !important;

        border-radius: 7px !important;

        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        width: 90%;
        margin-left: 5% !important;
    }


    /* Search input */

    .mobile-search .customer-search-input {
        height: 34px !important;

        padding-left: 6px !important;

        font-size: 16px !important;

        border: none !important;

        outline: none !important;

        box-shadow: none !important;

        background: transparent !important;
    }


    /* Search icon */

    .mobile-search .customer-search-icon {
        padding-left: 5px !important;
        padding-right: 3px !important;
    }
    .product_content {
        padding-top: 175px !important;
    }
    .enquary_attribute {
        width: 100%;
    }
    .image_width_logo {
        height: 70px !important;
    }

}

/* Mobile header buttons */
.mobile-back-wrapper {
    display: none;
}


</style>

<div class="col-lg-12 customer-header-modern mobile-sticky-header" style=" width:100%;padding-right: 1%;padding-left: 1%; border-bottom: rgb(235, 232, 232) solid 1.5px; padding-top: 5px; padding-bottom: 10px;">
    <div class="row customer-header-row mobile-header-layout">
        <div class="col-lg-4 text-center d-flex justify-content-center customer-header-logo mobile-logo" style="padding-left: 3%;">

            @yield('page-route')
            {{-- <a href="{{ route('customer_catlog') }}">
            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" alt="image" style="height: 80px; color:black" class="image_width">

            </a> --}}
        </div>

        <div class="col-lg-4 small_screen_search customer-header-search mobile-search"  style="padding-bottom: 10px;">
            <div class="enquary_attribute">
                <div class="col-lg-12 customer-search-wrapper" style="padding: unset; ">
                    <div class="row text-center">
                        <div class="col-lg-12 customer-search-column" style="padding-left: 10px; padding-right: 10px;">
                            {{-- <div class="search_box row ">
                                    <div class="col-lg-12" style="padding: unset; ">
                                        <div class="card search_div search_div2 row style-reset"
                                        >


                                            <div class="col-lg-2" style="text-align: right; margin-top: 7px;">
                                                <img src="{{ asset('argon') }}/img/icons/search.png" alt="image" style="width: 19px;">
                                            </div>
                                            <div class="col-lg-10 right-175" style="padding-left: 15px; margin-top: 3px;">
                                                <input type="text" class="form-control search_text" placeholder="Search">
                                            </div>

                                        </div>
                                        <hr class="hr_style hr-style">
                                    </div>
                            </div> --}}

                            <div class="card search_div row header_search customer-search-box" style="border: unset;">

                                <div class="col-12 col-lg-12 form-control customer-search-input-wrapper"
                                    style="padding: 6px 10px; margin-top: 3px; background-color: transparent; border-radius: 7px; border: 0.5px solid #c7c7c7;">

                                    <div class="input-group align-items-center">

                                        <!-- Search Icon FIRST -->
                                        <span class="input-group-text customer-search-icon"
                                            style="background: none; border: none; padding-left: 4px;">
                                            <i class="fas fa-search" style="color: #777;"></i>
                                        </span>

                                        <!-- Input NEXT -->
                                        <input type="text"
                                            class="form-control search_text customer-search-input"
                                            placeholder="Search"
                                            value="{{ request()->has('search') ? request()->search : '' }}"
                                            style="border: none; box-shadow: none; background: transparent;">

                                    </div>
                                </div>


                            </div>
                            {{-- <hr class="hr_style"> --}}

                            {{-- <div class="card search_div enquary_attribute_icon " style="border-radius: 1rem;">
                                <a href="#" class="search_icon" id="show-search-bar" style="text-align: left;">
                                    <img style="width: 26px;" src="{{ asset('argon') }}/img/icons/customer_portal/search.png" alt="image">
                                </a>
                            </div> --}}
                        </div>
                        <div class="col-lg-2 mt-1 enquary_attribute_icon hide-icon" style="display: none;">
                            <div class="card search_div">
                                <a href="#" class="search_icon">
                                    <img style="width: 26px;" src="{{ asset('argon') }}/img/icons/customer_portal/heart.png" alt="image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 mt-1 enquary_attribute_icon hide-icon"  style="display: none;">
                            <div class="card search_div">
                                <a href="#" class="search_icon">
                                    <img style="width: 26px;" src="{{ asset('argon') }}/img/icons/customer_portal/quotation.png" alt="image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 mt-1 mb-1 enquary_attribute_icon hide-icon"  style="display: none;">
                            <div class="card search_div">
                                <a href="#" class="search_icon">
                                    <img style="width: 26px;" src="{{ asset('argon') }}/img/icons/customer_portal/user.png" alt="image">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="paddin_top_10 col-lg-4 col-12 d-flex justify-content-center align-items-center justify-content-lg-end customer-header-actions mobile-header-actions" style="padding-right: 3.7%;">
            <div class="d-flex align-items-center customer-header-action-group">
                <a class="mobile-catalog-link" href="{{ route('product_filter1', [
                    'selectedGender' => 'All',
                    'selectedCategory' => '5',
                    'selectedSport' => '18',
                    'selectedStyle' => '0',
                    ]) }}">
                    <p class="head_p mb-0 customer-catalog-button mobile-catalog-text">APPAREL CATALOG</p>
                </a>
                <div class="filter-toggle d-lg-none ml-2 customer-filter-toggle mobile-toggle-wrapper" style="padding-left: 30px;">
                    <button id="filterToggleBtn" class="btn btn-light customer-filter-button mobile-toggle-button">
                        &#9776;
                    </button>
                </div>
            </div>
        </div> --}}
        <div class="paddin_top_10 col-lg-4 col-12 d-flex justify-content-center align-items-center justify-content-lg-end customer-header-actions mobile-header-actions"
            style="padding-right: 3.7%;">

            <div class="d-flex align-items-center customer-header-action-group">

                <a class="mobile-catalog-link"
                    href="{{ route('product_filter1', [
                        'selectedGender' => 'All',
                        'selectedCategory' => '5',
                        'selectedSport' => '18',
                        'selectedStyle' => '0',
                    ]) }}">
                    <p class="head_p mb-0 customer-catalog-button mobile-catalog-text">
                        APPAREL CATALOG
                    </p>
                </a>

                <!-- Back Button - DEFAULT DISPLAY -->
                <div class="mobile-back-wrapper ml-2">
                    <button type="button"
                        class="btn btn-light mobile-back-button"
                        onclick="window.history.back();">
                        &#8592;
                    </button>
                </div>

                <!-- Filter Toggle Button - DEFAULT HIDDEN -->
                <div class="filter-toggle d-lg-none ml-2 customer-filter-toggle mobile-toggle-wrapper"
                    style="padding-left: 30px;">
                    <button id="filterToggleBtn"
                        class="btn btn-light customer-filter-button mobile-toggle-button">
                        &#9776;
                    </button>
                </div>

            </div>
        </div>


    </div>

</div>

<form action="{{ route('product_filter1') }}" method="GET" id="filterForm">
    @csrf
    <input type="hidden" name="selectedCategory" id="selectedCategoryInput" value="">
    <input type="hidden" name="selectedGender" id="selectedGenderInput" value="">
    <input type="hidden" name="selectedSport" id="selectedSportInput" value="">
    <input type="hidden" name="selectedStyle" id="selectedStyleInput" value="">
    <!-- Remove the submit button -->
</form>

<script>

    document.getElementById('filterToggleBtn').addEventListener('click', function() {
        document.getElementById('filterSidebar').classList.add('active');
        document.getElementById('filterOverlay').classList.add('active');
    });

    document.getElementById('closeFilter').addEventListener('click', function() {
        document.getElementById('filterSidebar').classList.remove('active');
        document.getElementById('filterOverlay').classList.remove('active');
    });

    document.getElementById('filterOverlay').addEventListener('click', function() {
        document.getElementById('filterSidebar').classList.remove('active');
        document.getElementById('filterOverlay').classList.remove('active');
    });

</script>
