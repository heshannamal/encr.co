@extends('layouts.customer_portal.app')

@section('content')

<style>
    @media only screen and (min-width: 320px) and (max-width: 420px )
    {
        .style-reset{
            width:145% !important;
            left: -7% !important;
        }
        .hr-style{
            width: 125% !important;
            left: -7% !important;
        }
        .right-175{
            right: 100%;
            margin-top: 8px !important;
        }
        .width-75{
            width:75px !important;
        }
        .hide-icon{
            display: none !important;
        }
        .padding-none{
            padding-left:unset !important;
            padding-right:unset !important;
        }
        .filter-style{
            display: flex;
            gap: 10px;
        }
        .filter-row{
            padding-left:unset !important;
            margin-left:unset !important;
            margin-right:unset !important;
        }
        .filter_text{
            width: 80px;
        }
        .image_width_logo{
            width: -webkit-fill-available;
            height: 85px;
        }
        .product_count{
            margin-top:unset !important;
            text-align:center !important;
            padding-right: 20% !important;
            padding-left: 20% !important;
        }

    }
    .close-button {
        position: absolute;
        top: -15px; /* Adjust the top position as needed */
        right: -12px; /* Adjust the right position as needed */
    }

    .close-button button {
        border: none;
        outline: none;
        cursor: pointer;
        border-radius: 50%;
        background-color: gray;
        height: 20px;
        width: 20px;
        line-height: 3px;
        font-size: 7px;
        color: white;
    }
    .search_div {
        height: 40px;
        box-shadow: 10px 10px 30px 0px rgba(0, 0, 0, 0.05);
    }
    .search_text {
        font-size: 14px;
        text-align: left;
        color: rgba(202, 201, 201, 1);
        background-color: transparent;
        border: unset;
        height: 95%;
    }
    .search_bar_text {
        font-size: 14px;
        text-align: left;
        color: rgba(202, 201, 201, 1);
        background-color: transparent;
        border: unset;
        height: 95%;
    }
    .hr_style {
        margin: unset;
        position: relative;
        top: -8px;
        /* width: 171%;
        left: -65%; */
        border: 1px solid rgba(222, 222, 222, 1)
    }
    .search_text::placeholder {
        font-size: 13px;
        text-align: left;
        color: rgba(202, 201, 201, 1);
    }
    .search_bar_text:hover .search_bar_text {
        color: rgba(113, 112, 112, 1);
    }
    .close-button {
        position: absolute;
        top: 8px;
        right: -33px;
    }

    .close-button button {
        border: none;
        outline: none;
        cursor: pointer;
        border-radius: 50%;
        background-color: gray;
        height: 25px;
        width: 25px;
        line-height: 3px;
        font-size: 10px;
        color: white;
        font-weight: 900;
    }
    .search_box {
        margin-right: 26px;
        padding-right: 25px;
    }
    .filter_attribute {
        margin-left: 26px;
        padding-left: 25px;
        padding-top: 30px;
        margin-right: 26px;
        padding-right: 25px;
    }
    .filter_attribute1 {
        padding-left: 25px;
        padding-right: 25px;
        /* padding-bottom: 25px; */
    }
    .enquary_attribute {
        /* margin-left: 26px;
        padding-left: 32px; */
        padding-top: 23px;
        /* margin-right: 26px;
        padding-right: 32px; */
        width: 93%;
    }
    .search_box_visible {
        display: none;
    }
    .product_content {
        padding-left: 4%;
        padding-right: 4%;
        padding-top: 40px;
    }
    .image_card {
        height: fit-content;
        width: 100%;
        /* padding: 10px; */
        border-radius: 5px;
    }
    .product_image {
        width: 100%;
        height: auto;
        padding-left: 10px;
        padding-right: 10px;
    }
    .product_div {
        padding-bottom: 20px;
        padding-right: 10px;
        padding-left: 10px;
    }
    .filter_text {
        margin-bottom: unset;
        font-size: 13px;
        border-radius: 5px;
        color: gray;
        height: 22px;
        padding-right: 10px;
    }
    .search_icon {
        padding-top: 6px;
        /* padding-left: 7px; */
        text-align: center;
    }
    .enquary_attribute_icon {
        padding-left: 10px;
        padding-right: 10px;
    }
    .product-link {
        font-size: 1rem;
        color: rgb(48, 48, 48);
    }
    .product-link:hover {
        color: rgb(105, 105, 105);
    }
    .enquiry_tab {
        font-size: 14px;
        color: white;
        padding-left: 20%;
    }
    .enquiry_box {
        background-color: rgb(0, 255, 164);
        width: 75%;
        border-radius: 5px;
        height: auto;
        /* padding-top: 7px; */
        padding: 1%
    }
    .enquiry_tab {
    display: none;
}
.product_name .hide {
    display: none;
    transition: opacity 0.5s;
    opacity: 0;
}

.product_name:hover .hide {
    display: block;
    opacity: 1;
}

.enquiry_tab .hide {
    display: block;
    transition: opacity 0.5s;
    opacity: 1;
}

.enquiry_tab:hover .hide {
    display: none;
    opacity: 0;
}
.filter_select {
    background-color: transparent;
    border: unset;
    padding-top: 4px;
    color: gray;
    text-align: center;
    outline-color: unset;
    height: 25px;
    width: 100%;
    border: 1px solid #c2c2c2;
    border-radius: 5px;
    text-align: left;
}
.filter_card {
    margin-bottom: unset;
    font-size: 11px;
    border: 1px solid #d4d4d4;
    border-radius: 5px;
    color: gray;
    background-color: #f9f9f9;
    height: 22px;
}
.head_p {
    color: rgb(55, 55, 55) !important;
    font-weight: 500;
    font-size: 24px;
    text-align: right;
    /* margin-top: 1rem; */
    }
    .hide {
    display: none;
}
.page-item.active .page-link {
    background-color: rgb(214, 214, 214) !important;
    color: gray;
    box-shadow: unset;
    border-radius: unset !important;
}
.navbar {
    background-color: white;
    padding: 10px;
    width: 100%;
    /* position: fixed; */
    z-index: 1000;
    padding-top: unset;
}

@media (min-width: 992px) {
    .navbar {
        position: fixed;
    }
    .container {
    margin-top: 150px;
    }

}
.scroll-to-top {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    padding: .4rem .7rem;
    background-color: white;
    border: 1px solid #b3b3b3;
    border-radius: .3rem;
    color: grey;
    cursor: pointer;
}
.scroll-to-top {
    position: fixed;
    bottom: 20px;
    right: 40px;
    z-index: 1000;
    padding: .4rem .7rem;
    background-color: white;
    border: 1px solid #b3b3b3;
    border-radius: .3rem;
    color: grey;
    cursor: pointer;
}
.sub-header-style{
        font-size: 1rem;
        color: rgb(55, 55, 55) !important;
    }
    .category_row {
        margin: unset !important;
        padding-top: 20px !important;
    }
    .filter_div_space {
        /* padding-left: 30px; */
    }
    .custom-select-box {
        width: 120px;
        padding: 3px;
        /* font-size: 16px; */
        border: unset;
        border-radius: 5px;
        background-color: #f7f7f7;
        color: #a3a3a3;
        -moz-appearance: none;
        /* appearance: none; */
        padding-left: 8px;
    }

    .custom-select-box:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        outline: none;
    }

    .custom-select-box option {
        padding: 10px;
        background-color: #fff;
        color: #333;
    }
    .body_class {
        max-width: 100%;
    }
    .group_topic {
        padding-left: 10px;
        background-color: rgb(251 251 251);
        color: rgb(80, 80, 80);
        font-size: 1.2rem;
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
.show_more_button {
    font-weight: 500;
    padding-left: .5rem .7rem;
    color: red;
    border: 1px solid red;
}
.slider-container {
  position: relative;
  overflow: hidden;
}
.slider-container img {
  position: absolute;
  top: 0; left: 0;
  width: 100%;
  opacity: 0;
  transition: opacity 0.6s ease-in-out;
  border-radius: 5px 5px 0 0;
}
.slider-container img.active {
  opacity: 1;
  position: relative;
}
.card_div {
    display: flex;
    flex-direction: column;       /* stack image and bottom section */
    min-height: 355px;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    border: unset;
}

.image_card {
    /* flex: 1; */
    /* display: flex; */
    justify-content: center;
    align-items: center;
    width: 100%;
}

.product_bottom {
    padding: 10px;
    text-align: center;
    border-top: 1px solid #f0f0f0; /* optional separator */
}
.item_count {
    font-size: 13px;
}
.product_count {
     padding-right: 2.5rem;
}
@media (min-width: 1785px){
    .card_div {
        /* min-height: 1050px; */
    }
}
@media (min-width: 1600px){
    .container {
    max-width: 100%;
    }
    img, video {
    max-width: 100%;
    }
    .card_div {
        /* min-height: 650px; */
    }
}
@media (min-width: 1024px){
    .card_div {
        /* min-height: 453px; */
    }
}
@media (min-width: 1280px){
    .card_div {
        /* min-height: 605px; */
    }
}
@media (min-width: 1536px) and (max-width: 1600px){
    .card_div {
        /* min-height: 600px; */
    }
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


}
@media (min-width: 1785px){
    .card_div {
        /* min-height: 750px; */
    }
}
.two-line-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;   /* limit to 2 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;     /* allow wrapping */
    max-width: 100%;
}
.breadcrumb-wrapper {
    padding: 10px 0;
    padding-left: 60px;
}

.breadcrumb-nav {
    font-size: 14px;
    color: #3e3e3e;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
}

.breadcrumb-nav a {
    color: #3e3e3e;
    text-decoration: none;
}

.breadcrumb-nav a:hover {
    color: #111827;
    text-decoration: underline;
}

.breadcrumb-current {
    color: #111827;
    font-weight: 500;
}

/* Mobile */
@media (max-width: 768px) {
    .breadcrumb-nav {
        font-size: 12px;
    }
}
.selected-filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #acacac;
}

.selected-filter-tag .clear-filter {
    text-decoration: none;
    font-size: 15px;
    color: #999;
    cursor: pointer;
}

.selected-filter-tag .clear-filter:hover {
    color: #000;
}
.filter-column {
    min-height: 62px; /* adjust if needed */
}
.filter-placeholder {
    height: 22px; /* same height */
    padding: 12px 0px;
    margin-top: 4px;
}
/* Slider container – fixed ratio */
.slider-container {
    position: relative;
    width: 100%;
    /* aspect-ratio: 1 / 1;  */
    overflow: hidden;
}

/* Active image */
.slider-container img.active {
    display: block;
}
/* Mobile screens */
@media (max-width: 991px) {

    .filter-wrapper {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 15px !important;
        width: 100%;
    }

    .filter-wrapper > div {
        width: 100%;
    }

    .filter-wrapper .d-flex.align-items-center {
        justify-content: space-between;
    }

    .filter_select {
        width: 100%;
    }

    .product_count {
        align-items: flex-start !important;
    }
    .filter_text {
        width: 50%;
    }
    .selected-filter-tag {
        padding-right: 20px;
    }
    .card_div {
        /* min-height: 675px; */
    }
}

@media (max-width: 1138px) and (min-width: 992px){
    .container {
        margin-top: 200px !important;
    }
}
@media (max-width: 1200px) and (min-width: 992px){
    .custom-select-box {
        font-size: 0.7rem;
        width: 80px;
        height: 25px;
    }
}
@media (min-width: 2275px) {
    .card_div {
        /* min-height: 835px; */
    }
}
.product_name {
    /* min-height: 75px; */
    padding: 0px 20px;
}
.two-line-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;   /* max lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
    line-height: 1.4em;
    height: 2.8em; /* line-height × 2 */
}
.product_price {
    /* font-weight: 600; */
}
.custom-select-box:disabled {
    background-color: #d3d3d3;
    color: #6c757d;
    cursor: not-allowed;
}
.card_div {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card_div:hover {
    transform: scale(1.02);
    box-shadow: rgba(0, 0, 0, 0.25) 0px 8px 20px;
    z-index: 10;
}
.product_div {
    overflow: visible;
}
.card_div {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.enquiry_tab {
    margin-top: auto;
}
.shine-text {
    font-size: 12px;
    color: #555;
    margin-top: 5px;
    padding: 0px 20px 10px;

    position: relative;
    display: inline-block;

    background: linear-gradient(
        80deg,
        #555 0%,
        #555 40%,
        #ffffff 50%,
        #555 60%,
        #555 100%
    );

    background-size: 200% auto;
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;

    transition: background-position 1.6s ease;
}

/* Hover effect */
.shine-text:hover {
    background-position: -200% center;
}

@media (max-width: 768px) {

    html,
    body {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden !important;
    }

    .sec {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    /* Remove negative Bootstrap row overflow */
    .sec > .row,
    .sec .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    /* Percentage padding was creating oversized content */
    .sport-section > .col-lg-12 {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    .sport-section .sports-container {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .style-section > .col-lg-12 {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    /* Category section */
    .category-section .cat-div {
        padding-left: 10px;
        padding-right: 10px;
    }

    /* Gender */
    .gender-section > .col-lg-12 {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    /* Prevent fixed-width elements from expanding screen */
    .width-150 {
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Sport images */
    .sport_img {
        max-width: 100% !important;
    }

    /* Search */
    .search_main_div {
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

}

/* =========================================================
   MODERN MOBILE FILTER DRAWER
   CSS ONLY - EXISTING FUNCTIONALITY UNCHANGED
   ========================================================= */

@media (max-width: 991px) {

    /* Main side drawer */
    .filter-sidebar {
        position: fixed !important;
        top: 0 !important;
        right: -100% !important;
        width: min(88vw, 390px) !important;
        height: 100vh !important;
        height: 100dvh !important;
        background: #ffffff !important;
        z-index: 1055 !important;

        padding: 0 !important;
        border: none !important;
        border-radius: 24px 0 0 24px !important;

        overflow-y: auto !important;
        overflow-x: hidden !important;

        box-shadow: -15px 0 45px rgba(0, 0, 0, 0.15) !important;

        transition:
            right 0.38s cubic-bezier(0.4, 0, 0.2, 1),
            box-shadow 0.38s ease !important;

        -webkit-overflow-scrolling: touch;
    }


    /* Open state - YOUR EXISTING JS ALREADY ADDS .active */
    .filter-sidebar.active {
        right: 0 !important;
    }


    /* ---------------------------------------------------------
       FILTER HEADER
       --------------------------------------------------------- */

    .filter-sidebar-header {
        position: sticky !important;
        top: 0 !important;
        z-index: 10 !important;

        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;

        min-height: 72px !important;
        padding: 18px 20px !important;

        background: rgba(255, 255, 255, 0.96) !important;
        border-bottom: 1px solid #eeeeee !important;

        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }


    .filter-sidebar-header h5 {
        margin: 0 !important;

        font-size: 20px !important;
        font-weight: 700 !important;
        letter-spacing: -0.3px !important;

        color: #171717 !important;
    }


    /* Close button */
    .filter-sidebar-header .close-btn {
        width: 38px !important;
        height: 38px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        padding: 0 !important;
        margin: 0 !important;

        border: 1px solid #e8e8e8 !important;
        border-radius: 50% !important;

        background: #f7f7f7 !important;
        color: #333333 !important;

        font-size: 25px !important;
        font-weight: 300 !important;
        line-height: 1 !important;

        cursor: pointer;

        transition: all 0.2s ease !important;
    }


    .filter-sidebar-header .close-btn:active {
        transform: scale(0.92);
        background: #eeeeee !important;
    }


    /* ---------------------------------------------------------
       MAIN FILTER CONTENT
       --------------------------------------------------------- */

    .filter-sidebar > .row {
        display: block !important;

        margin: 0 !important;
        padding: 20px !important;

        gap: 0 !important;
    }


    /* ---------------------------------------------------------
       BREADCRUMB
       --------------------------------------------------------- */

    .breadcrumb-wrapper {
        width: 100% !important;
        margin-bottom: 22px !important;
        padding-left: unset;
    }


    .breadcrumb-nav {
        display: flex !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 8px !important;

        padding: 12px 14px !important;

        background: #f7f7f7 !important;
        border-radius: 12px !important;
    }


    .breadcrumb-nav a {
        color: #555 !important;
        text-decoration: none !important;

        font-size: 13px !important;
        font-weight: 500 !important;

        transition: color 0.2s ease;
    }


    .breadcrumb-nav a:last-of-type {
        color: #111 !important;
        font-weight: 650 !important;
    }


    .breadcrumb-nav span {
        color: #b5b5b5 !important;
        font-size: 13px !important;
    }


    /* ---------------------------------------------------------
       FILTER WRAPPER
       --------------------------------------------------------- */

    .filter-wrapper {
        width: 100% !important;

        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;

        gap: 14px !important;
    }


    /* ---------------------------------------------------------
       EACH FILTER
       --------------------------------------------------------- */

    .filter-wrapper > .d-flex.flex-column {
        width: 100% !important;

        padding: 15px !important;

        background: #fafafa !important;
        border: 1px solid #eeeeee !important;
        border-radius: 15px !important;

        box-sizing: border-box !important;

        transition:
            border-color 0.2s ease,
            background 0.2s ease !important;
    }


    .filter-wrapper > .d-flex.flex-column:focus-within {
        background: #ffffff !important;
        border-color: #d5d5d5 !important;
    }


    /* Label + select row */
    .filter-wrapper > .d-flex.flex-column > .d-flex.align-items-center {
        width: 100% !important;

        display: flex !important;
        align-items: center !important;

        gap: 10px !important;
    }


    /* Filter labels */
    .filter_text {
        min-width: 62px !important;

        margin: 0 !important;

        color: #555 !important;

        font-size: 13px !important;
        font-weight: 600 !important;
        letter-spacing: 0.1px !important;
    }


    /* ---------------------------------------------------------
       SELECT BOX
       --------------------------------------------------------- */

    .custom-select-box {
        flex: 1 !important;
        width: 100% !important;

        height: 30px;

        padding: 8px 38px 8px 12px !important;

        border: 1px solid #dddddd !important;
        border-radius: 10px !important;

        background-color: #ffffff !important;
        color: #222 !important;

        font-size: 14px !important;
        font-weight: 500 !important;

        outline: none !important;

        cursor: pointer;

        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease !important;
    }


    .custom-select-box:focus {
        border-color: #999999 !important;

        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
    }


    .custom-select-box:disabled {
        opacity: 0.5 !important;
        cursor: not-allowed !important;
        background: #f1f1f1 !important;
    }


    /* ---------------------------------------------------------
       SELECTED FILTER TAG
       --------------------------------------------------------- */

    .selected-filter-tag {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

        width: fit-content !important;

        margin-top: 9px !important;
        margin-left: auto !important;

        padding: 5px 9px !important;

        border: 1px solid #e3e3e3 !important;
        border-radius: 20px !important;

        background: #ffffff !important;

        color: #444 !important;

        font-size: 11px !important;
        font-weight: 500 !important;

        line-height: 1.2 !important;
    }


    .selected-filter-tag span {
        margin-right: 4px !important;
    }


    .selected-filter-tag .clear-filter {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

        width: 18px !important;
        height: 18px !important;

        margin-left: 3px !important;

        border-radius: 50% !important;

        color: #777 !important;
        text-decoration: none !important;

        font-size: 14px !important;
        line-height: 1 !important;

        transition:
            background 0.2s ease,
            color 0.2s ease !important;
    }


    .selected-filter-tag .clear-filter:active {
        background: #eeeeee !important;
        color: #111 !important;
    }


    /* ---------------------------------------------------------
       CLEAR ALL
       --------------------------------------------------------- */

    .product_count {
        width: 100% !important;

        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;

        padding: 16px 4px 4px !important;

        border-top: 1px solid #eeeeee !important;
    }


    .item_count {
        font-size: 13px !important;
        color: #777 !important;
    }


    .product_count .clear-all-filters {
        margin-top: 0 !important;
        margin-left: auto !important;

        padding: 7px 12px !important;

        border: none !important;
        background: #f2f2f2 !important;

        color: #333 !important;

        font-size: 11px !important;
        font-weight: 600 !important;

        text-decoration: none !important;
    }


    /* ---------------------------------------------------------
       EMPTY PLACEHOLDER
       --------------------------------------------------------- */

    .filter-placeholder {
        display: none !important;
    }


    /* ---------------------------------------------------------
       SCROLLBAR
       --------------------------------------------------------- */

    .filter-sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .filter-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .filter-sidebar::-webkit-scrollbar-thumb {
        background: #d5d5d5;
        border-radius: 10px;
    }
    .show_more_button {
        color: white;
        border: 1px solid red;
        background-color: red;
        font-weight: 600;
    }
    .filter-sidebar-header {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 50px;
    }

    /* Filters - always center */
    .filter-sidebar-header h5 {
        margin: 0;
        text-align: center;
        width: 100%;
    }

    /* Back button - left */
    .filter-back-btn {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);

        border: none;
        background: transparent;
        font-size: 24px;
        line-height: 1;
        padding: 5px 10px;
        cursor: pointer;
        z-index: 2;
    }

    /* Close button - right */
    .filter-sidebar-header .close-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
    }

}


/* =========================================================
   SMALL PHONES
   ========================================================= */

@media (max-width: 400px) {

    .filter-sidebar {
        width: 92vw !important;
        border-radius: 20px 0 0 20px !important;
    }

    .filter-sidebar > .row {
        padding: 16px !important;
    }

    .filter-wrapper {
        gap: 11px !important;
    }

    .filter-wrapper > .d-flex.flex-column {
        padding: 13px !important;
    }

    .filter-sidebar-header {
        min-height: 66px !important;
        padding: 15px 16px !important;
    }

}

@media (max-width: 768px) {

    .product_name {
        display: block !important;
    }

    .product_name .product-link.two-line-text {
        display: -webkit-box !important;
        -webkit-box-orient: vertical !important;
        -webkit-line-clamp: 2 !important;
        overflow: hidden !important;

        width: 100% !important;
        max-width: 100% !important;

        text-align: left !important;
        white-space: normal !important;

        line-height: 1.4 !important;
    }

    .product_name .product_price {
        display: block !important;

        width: 100% !important;

        margin-top: 5px !important;
        margin-left: 0 !important;

        text-align: left !important;
        white-space: nowrap !important;
    }

}

/* Desktop - hidden */
.mobile-filter-apply-wrapper {
    display: none;
}


/* Mobile only */
@media (max-width: 768px) {

    .mobile-filter-apply-wrapper {
        display: block;
        width: 100%;
        margin-top: 15px;
    }

    .mobile-filter-apply-btn {
        width: 100%;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        background-color: #222;
        color: #fff;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
    }

    .mobile-filter-apply-btn:active {
        transform: scale(0.98);
    }
}

</style>

<div class="navbar" style=" background-color:white; z-index:99; padding: unset;">


    @section('page-route')
        <a href="{{ route('customer_catlog') }}">
            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" alt="image" style="width:auto !important; color:black;height: 85px;" class="image_width_logo">
        </a>
    @endsection

    @section('apparel-catalog')
        {{-- <a href="{{ route('customer_catlog') }}"> --}}
            <p class="head_p">APPAREL CATALOG</p>
        {{-- </a> --}}
    @endsection

    @include('pages.customer_product_catlog.layout.header')


    {{-- <hr style="margin: unset; width: 90%; margin-left: 5%;"> --}}

    {{-- <div class="filter_attribute1 col-lg-9 padding-none" style=""> --}}
        <div class="col-lg-12 filter-sidebar" id="filterSidebar"  style="padding: unset; border-bottom: 1px solid rgb(235, 235, 235);">



            <div class="filter-sidebar-header">

                <!-- Back Button -->
                <button type="button"
                    class="filter-back-btn"
                    onclick="window.history.back();">
                    &#8592;
                </button>

                <!-- Center Title -->
                <h5>Filters</h5>

                <!-- Close Button -->
                <button id="closeFilter" class="close-btn">&times;</button>

            </div>

            <div class="row align-items-center"
                style="margin: unset; padding: 15px 3.5% 15px; gap: 20px;">

                <!-- LEFT : Breadcrumb -->
                <div class="breadcrumb-wrapper">
                    <nav class="breadcrumb-nav">
                        <a href="{{ route('customer_catlog') }}" style="font-size: 15px; font-weight: 500;">Home</a>
                        <span>/</span>

                        <a href="{{ route('product_filter1', [
                            'selectedGender' => 'All',
                            'selectedCategory' => '5',
                            'selectedSport' => '18',
                            'selectedStyle' => '0',
                        ]) }}">
                            Catalog
                        </a>
                    </nav>
                </div>


                <!-- RIGHT : Filters + Count -->
                <div class="d-flex align-items-center ms-auto filter-wrapper" style="gap: 20px;">

                    <!-- Category -->
                    <div class="d-flex flex-column">

                        @php
                            $selectedMainCategory = $selectedMainCategory ?? 5;
                            $selectedGender = $selectedGender ?? 'All';
                            $selectedSport = $selectedSport ?? 18;
                            $selectedStyle = $selectedStyle ?? 0;
                        @endphp

                        @php
                            $hasAnyFilter =
                                (!empty($selectedMainCategory) && $selectedMainCategory != 5) ||
                                (!empty($selectedGender) && $selectedGender !== 'All') ||
                                (!empty($selectedSport) && $selectedSport != 18) ||
                                (!empty($selectedStyle) && $selectedStyle != 0);
                        @endphp

                        <!-- Label + Select (ROW) -->
                        <div class="d-flex align-items-center">
                            <p class="filter_text mb-0 me-2">Category</p>

                            <select id="mainCategories" class="filter_select custom-select-box">
                                @foreach ($mainCategory as $mainCat)
                                    <option value="{{ $mainCat->id }}"
                                        {{ $selectedMainCategory == $mainCat->id ? 'selected' : '' }}>
                                        {{ $mainCat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selected value (BELOW SELECT) -->
                        @if(!empty($selectedMainCategory) && $selectedMainCategory != 5 && !empty($hasAnyFilter))
                            @php
                                $cat = $mainCategory->firstWhere('id', $selectedMainCategory);
                            @endphp

                            @if($cat)
                                <div class="selected-filter-tag mt-1 ms-auto">
                                    <span>{{ $cat->category_name }}</span>

                                    <a href="{{ route('product_filter1', [
                                        'selectedCategory' => 5,
                                        'selectedGender' => $selectedGender ?? 'All',
                                        'selectedSport' => $selectedSport ?? 18,
                                        'selectedStyle' => $selectedStyle ?? 0,
                                    ]) }}"
                                    class="clear-filter">×</a>
                                </div>
                            @endif
                        @elseif ($hasAnyFilter)
                            <div class="filter-placeholder"></div>
                        @endif


                    </div>


                    <!-- Gender -->
                    <div class="d-flex flex-column">

                        <div class="d-flex align-items-center">
                            <p class="filter_text mb-0 me-2">Gender</p>
                            <select id="genderSelect" class="filter_select custom-select-box">
                                <option value="Men" {{ $selectedGender == 'Men' ? 'selected' : '' }}>Men's</option>
                                <option value="Women" {{ $selectedGender == 'Women' ? 'selected' : '' }}>Women's</option>
                                <option value="All" {{ $selectedGender == 'All' ? 'selected' : '' }}>All</option>
                            </select>
                        </div>

                        @if(!empty($selectedGender) && $selectedGender !== 'All'  && !empty($hasAnyFilter))
                            <div class="selected-filter-tag mt-1 ms-auto">
                                <span>{{ $selectedGender }}</span>
                                <a href="{{ route('product_filter1', [
                                    'selectedGender' => 'All',
                                    'selectedCategory' => $selectedMainCategory ?? 5,
                                    'selectedSport' => $selectedSport ?? 18,
                                    'selectedStyle' => $selectedStyle ?? 0,
                                ]) }}" class="clear-filter">×</a>
                            </div>
                        @elseif ($hasAnyFilter)
                            <div class="filter-placeholder"></div>
                        @endif

                    </div>

                    <!-- Sport -->
                    <div class="d-flex flex-column">

                        <!-- Label + Select -->
                        <div class="d-flex align-items-center">
                            <p class="filter_text mb-0 me-2">Sport</p>
                            <select id="sportSelect" class="filter_select custom-select-box" {{ $selectedMainCategory == 3 ? 'disabled' : '' }}>
                                @foreach ($sports as $sport)
                                    <option value="{{ $sport->id }}"
                                        {{ $selectedSport == $sport->id ? 'selected' : '' }}>
                                        {{ $sport->sport_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selected sport BELOW -->
                        @if(!empty($selectedSport) && $selectedSport != 18  && !empty($hasAnyFilter))
                            @php
                                $sportObj = $sports->firstWhere('id', $selectedSport);
                            @endphp

                            @if($sportObj)
                                <div class="selected-filter-tag mt-1 ms-auto">
                                    <span>{{ $sportObj->sport_name }}</span>

                                    <a href="{{ route('product_filter1', [
                                        'selectedSport' => 18,
                                        'selectedCategory' => $selectedMainCategory ?? 5,
                                        'selectedGender' => $selectedGender ?? 'All',
                                        'selectedStyle' => $selectedStyle ?? 0,
                                    ]) }}"
                                    class="clear-filter">×</a>
                                </div>
                            @endif
                        @elseif ($hasAnyFilter)
                            <div class="filter-placeholder"></div>
                        @endif

                    </div>

                    <!-- Style -->
                    <div class="d-flex flex-column">

                        <!-- Label + Select -->
                        <div class="d-flex align-items-center">
                            <p class="filter_text mb-0 me-2">Style</p>
                            <select id="styleSelect" class="filter_select custom-select-box" {{ $selectedMainCategory == 1 ? 'disabled' : '' }}>
                                <option value="0">All</option>
                                @foreach ($productCategories as $productStyle)
                                    <option value="{{ $productStyle->id }}"
                                        {{ $selectedStyle == $productStyle->id ? 'selected' : '' }}>
                                        {{ $productStyle->product_category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selected style BELOW -->
                        @if(!empty($selectedStyle) && $selectedStyle != 0  && !empty($hasAnyFilter))
                            @php
                                $styleObj = $productCategories->firstWhere('id', $selectedStyle);
                            @endphp

                            @if($styleObj)
                                <div class="selected-filter-tag mt-1 ms-auto">
                                    <span>{{ $styleObj->product_category_name }}</span>

                                    <a href="{{ route('product_filter1', [
                                        'selectedStyle' => 0,
                                        'selectedCategory' => $selectedMainCategory ?? 5,
                                        'selectedGender' => $selectedGender ?? 'All',
                                        'selectedSport' => $selectedSport ?? 18,
                                    ]) }}"
                                    class="clear-filter">×</a>
                                </div>
                            @endif
                        @elseif ($hasAnyFilter)
                            <div class="filter-placeholder"></div>
                        @endif

                    </div>


                    <!-- Item count -->

                    <!-- Mobile Apply Filter Button -->
                    <div class="mobile-filter-apply-wrapper">
                        <button type="button" id="applyMobileFilters" class="mobile-filter-apply-btn">
                            Apply Filters
                        </button>
                    </div>

                    <!-- Item count -->
                    <div class="product_count d-flex flex-column align-items-end">

                        <p class="item_count mb-0" style="color: grey;"></p>

                        @if($hasAnyFilter)
                            <a href="{{ route('product_filter1', [
                                'selectedCategory' => 5,
                                'selectedGender' => 'All',
                                'selectedSport' => 18,
                                'selectedStyle' => 0,
                            ]) }}"
                            class="clear-all-filters selected-filter-tag mt-1 clear-filter">
                                Clear ×
                            </a>
                        @elseif (!empty($hasAnyFilter))
                            <div class="filter-placeholder"></div>
                        @endif

                    </div>


                    {{-- <div class="product_count d-flex flex-column align-items-end">

                        <p class="item_count mb-0" style="color: grey;"></p>

                        @if($hasAnyFilter)
                            <a href="{{ route('product_filter1', [
                                'selectedCategory' => 5,
                                'selectedGender' => 'All',
                                'selectedSport' => 18,
                                'selectedStyle' => 0,
                            ]) }}"
                            class="clear-all-filters selected-filter-tag mt-1 clear-filter">
                                Clear ×
                            </a>
                        @elseif (!empty($hasAnyFilter))
                            <div class="filter-placeholder"></div>
                        @endif

                    </div> --}}


                </div>
            </div>


        </div>
    {{-- </div> --}}


    {{-- <div class="col-lg-3 product_count" style="text-align: right; margin-top: 1.8rem; padding-right: 2.5rem;">

        <p class="item_count" style="font-size: 13px; color: grey;"></p>
    </div> --}}
</div>

<hr style="margin: unset; width: 90%; margin-left: 5%;">
{{-- <div class="container col-lg-12 product_content">
    <div class="row">
        @foreach ($matchingData as $matchingProduct)
            <div class="col-lg-3 product_div">
                <div class="card">
                    <div style="height: 300px;">
                        <div class="image_card">
                            @php
                            $defaultSearchValue = ''; // Define a default value
                        @endphp

                        <a href="{{ route('product.show', ['id' => $matchingProduct->id, 'searchValue' => $searchValue ?? $defaultSearchValue]) }}">
                            <img class="product_image" src="{{ $matchingProduct->mockup_img_1 }}" alt="" onerror="setDefaultImage()">
                        </a>
                            <div class="like_tag" style="position: absolute; top: 12px; right: 20px;">
                                <img style="width: 22px;" src="{{ asset('argon') }}/img/icons/customer_portal/heart.png" alt="">
                            </div>
                        </div>
                        <div class="product_name" style="text-align: center;">
                            <a href="#" class="product-link">{{ $matchingProduct->product_name}}</a>
                        </div>
                        <div class="enquiry_tab hide" style="text-align: center;">
                            <div class="enquiry_box">
                                ADD TO ENQUIRY
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div> --}}

<div class="container col-lg-12 product_content" style="min-height: 70vh; max-width: 100%;">
    <div id="paste_container" class="row">
        <!-- Products will be dynamically displayed here -->
    </div>
</div>
<div>
    <div id="paginationbar" class="row justify-content-center" style="width: 103%;">
      {{-- pagination bar paste here --}}
    </div>
</div>

<button class="scroll-to-top" id="copyButton"><i class="fa fa-clone" aria-hidden="true" title="Copy Page URL"></i></button>

<button class="scroll_up scroll-to-top " style="right: 90px;" id="scroll_up"><i class="fa fa-arrow-up" aria-hidden="true" title="Copy Page URL"></i></button>

@include('pages.customer_product_catlog.layout.footer')

{{-- <footer style="background-color: #f4f4f4; z-index: 100; border-top: rgb(235, 232, 232) solid 0.5px;">
    <div class="section_new" style="margin-left: 10%;margin-right: 10%;">
        <div class="row">
            <div class="col-md-4" style="border-right: 2px solid #e6e6e6;margin-top: 1rem;margin-bottom: 1rem;">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <img src="{{ asset('argon') }}/img/encore/logo_dark.png" alt="image" style="height: 3rem; color:black" class="image_width">
                    </div>
                    <div class="col-md-12 mt-3" style="color: grey">
                        Custom made sportwear for teams, <br> training and lifestyle.
                    </div>
                    <div class="col-md-12 mt-3" style="color: grey">
                        © Encore Custom 2024. All Rights Reserved.
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-top: 1rem;margin-bottom: 1rem;padding-left: 10%;">
                <div class="row">
                    <div class="col-md-12 sub-header-style mt-3">
                        Contact
                    </div>
                    <div class="col-md-12 mt-3" style="color: grey">
                        <i class="fa fa-envelope-o" aria-hidden="true" style="font-size: 1rem;"></i>&nbsp;&nbsp;info@encorecustom.com
                    </div>
                    <div class="col-md-12 mt-3" style="color: grey">
                        <i class="fa fa-phone" aria-hidden="true" style="font-size: 1rem;"></i>&nbsp;&nbsp;+1 888-501-4999
                    </div>
                    <div class="col-md-12 mt-3" style="color: grey">
                        <i class="fa fa-map-marker" aria-hidden="true" style="font-size: 1rem;"></i>&nbsp;&nbsp;891 4th St, San Rafael, <br> &nbsp;&nbsp;&nbsp;&nbsp;CA 94901, USA
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="border-left: 2px solid #e6e6e6;margin-top: 1rem;margin-bottom: 1rem;padding-left: 10%;">
                <div class="row">
                    <div class="col-md-12 sub-header-style mt-3">
                        Explore
                    </div>
                    <div class="col-md-12 mt-3">
                        <a href="http://www.encorecustom.com" target="_blank" style="color: grey">
                            <i class="fa fa-safari" aria-hidden="true" style="font-size: 1rem;color: grey"></i>&nbsp;&nbsp;www.EncoreCustom.com
                        </a>
                    </div>
                    <div class="col-md-12 sub-header-style mt-3">
                        Connect
                    </div>
                    <div class="col-md-12 mt-3" style="color: grey">
                        <a href="http://www.encorecustom.com" target="_blank" style="color: grey">
                            <i class="fa fa-facebook-square" aria-hidden="true" style="font-size: 2rem;"></i>
                        </a>
                        <a href="http://www.encorecustom.com" target="_blank" style="color: grey">
                            <i class="fa fa-instagram ml-3" aria-hidden="true" style="font-size: 2rem;"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</footer> --}}

{{-- <form action="{{ route('product_filter1') }}" method="POST" id="filterForm">
    @csrf
    <input type="hidden" name="selectedCategory" id="selectedCategoryInput" value="">
    <input type="hidden" name="selectedGender" id="selectedGenderInput" value="">
    <input type="hidden" name="selectedSport" id="selectedSportInput" value="">
    <input type="hidden" name="selectedStyle" id="selectedStyleInput" value="">
    <button style="display: none;" type="submit">Submit</button>
</form>


<form action="{{ route('search.products') }}" method="POST" id="searchForm">
    @csrf
    <input type="hidden" name="search" id="searchInput" value="">
    <button style="display: none;" type="submit">Submit</button>
</form> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<!-- Add SweetAlert stylesheet -->

<!-- Add SweetAlert script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>


<script>
    document.getElementById("scroll_up").addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
       var clipboard = new ClipboardJS('#copyButton', {
          text: function () {
             return window.location.href;
          }
       });

       clipboard.on('success', function (e) {
        Swal.fire({
                title: 'Link copied',
                icon: 'success',
                confirmButtonText: 'OK',
            });
       });

       clipboard.on('error', function (e) {
        Swal.fire({
            title: 'Copy failed',
            text: 'An error occurred while copying the link.',
            icon: 'error',
            confirmButtonText: 'OK',
        });
       });
    });
 </script>


{{-- <script>
    function handleDropdownChange() {
        updateHiddenInput('mainCategories', 'selectedCategoryInput');
        updateHiddenInput('genderSelect', 'selectedGenderInput');
        updateHiddenInput('sportSelect', 'selectedSportInput');
        updateHiddenInput('styleSelect', 'selectedStyleInput');

        const selectedCategory = document.querySelector('input[name="selectedCategory"]').value;
        const selectedGender = document.querySelector('input[name="selectedGender"]').value;
        const selectedSport = document.querySelector('input[name="selectedSport"]').value;
        const selectedStyle = document.querySelector('input[name="selectedStyle"]').value;

        const url = "{{ route('product_filter1') }}" +
            "?selectedCategory=" + encodeURIComponent(selectedCategory) +
            "&selectedGender=" + encodeURIComponent(selectedGender) +
            "&selectedSport=" + encodeURIComponent(selectedSport) +
            "&selectedStyle=" + encodeURIComponent(selectedStyle);

        history.pushState(null, null, url);

    }

    function updateHiddenInput(selectId, hiddenInputId) {
        var selectedValue = $('#' + selectId).val();
        var hiddenInput = $('#' + hiddenInputId);
        hiddenInput.val(selectedValue);
    }

    $(document).ready(function () {
        $('.filter_select').change(handleDropdownChange);
    });
</script>

<form action="{{ route('product_filter1') }}" method="GET" id="filterForm">
    @csrf
    <input type="hidden" name="selectedCategory" id="selectedCategoryInput" value="">
    <input type="hidden" name="selectedGender" id="selectedGenderInput" value="">
    <input type="hidden" name="selectedSport" id="selectedSportInput" value="">
    <input type="hidden" name="selectedStyle" id="selectedStyleInput" value="">
    <!-- Remove the submit button -->
</form> --}}

<script>

    $(document).ready(function () {

        $('.filter_select').change(function () {

            // Update hidden inputs
            updateHiddenInput('mainCategories', 'selectedCategoryInput');
            updateHiddenInput('genderSelect', 'selectedGenderInput');
            updateHiddenInput('sportSelect', 'selectedSportInput');
            updateHiddenInput('styleSelect', 'selectedStyleInput');

            /*
             * MOBILE
             * Do NOT submit automatically.
             */
            if (window.innerWidth <= 768) {
                return;
            }

            /*
             * DESKTOP
             * Existing behavior - AUTO SUBMIT
             */
            $('#filterForm').submit();
        });


        /*
         * MOBILE APPLY BUTTON
         */
        $('#applyMobileFilters').click(function () {

            if (window.innerWidth <= 768) {

                // Update all hidden inputs
                updateHiddenInput(
                    'mainCategories',
                    'selectedCategoryInput'
                );

                updateHiddenInput(
                    'genderSelect',
                    'selectedGenderInput'
                );

                updateHiddenInput(
                    'sportSelect',
                    'selectedSportInput'
                );

                updateHiddenInput(
                    'styleSelect',
                    'selectedStyleInput'
                );

                // Submit only after button click
                $('#filterForm').submit();
            }

        });

    });


    function updateHiddenInput(selectId, hiddenInputId) {

        var selectedValue = $('#' + selectId).val();

        $('#' + hiddenInputId).val(selectedValue);
    }

</script>


<form action="{{ route('product_filter1') }}"
      method="GET"
      id="filterForm">

    @csrf

    <input type="hidden"
           name="selectedCategory"
           id="selectedCategoryInput"
           value="">

    <input type="hidden"
           name="selectedGender"
           id="selectedGenderInput"
           value="">

    <input type="hidden"
           name="selectedSport"
           id="selectedSportInput"
           value="">

    <input type="hidden"
           name="selectedStyle"
           id="selectedStyleInput"
           value="">

</form>


<form action="{{ route('search.products') }}" method="GET" id="searchForm" onsubmit="return submitSearchForm()">
    @csrf
    <input type="hidden" name="search" id="searchInput" value="">
    <button style="display: none;" type="submit">Submit</button>
</form>

<script>
    function submitSearchForm() {
        var searchValue = document.getElementById('searchInput').value;
        var form = document.getElementById('searchForm');
        form.action = "{{ route('search.products') }}" + "?search=" + encodeURIComponent(searchValue);
        return true;
    }
</script>

<script>
  function setDefaultImage(id) {
    console.log(id);
    var imgElement = document.getElementById(id);

    if (imgElement) {
      imgElement.src = 'assets/img/products/def.jpg';
    }
  }
</script>

<script>

// $('.filter_select').select2();

// $(document).ready(function () {
//     // Triggered when the value of any select element changes
//     $('.filter_select').change(function () {
//         // Update the corresponding hidden input value
//         updateHiddenInput('mainCategories', 'selectedCategoryInput');
//         updateHiddenInput('genderSelect', 'selectedGenderInput');
//         updateHiddenInput('sportSelect', 'selectedSportInput');
//         updateHiddenInput('styleSelect', 'selectedStyleInput');

//         // Submit the form
//         $('#filterForm').submit();
//     });

//     // Function to update the hidden input value based on the selected option
//     function updateHiddenInput(selectId, hiddenInputId) {
//         var selectedValue = $('#' + selectId).val();
//         var hiddenInput = $('#' + hiddenInputId)[0]; // Get the DOM element

//         // Add your specific condition here
//         // if (selectId === 'mainCategories' && selectedValue === '5') {
//         //     hiddenInput.value = ""; // Set it to an empty string
//         // } else {
//             hiddenInput.value = selectedValue;
//         // }
//     }
// });


    const matchingData = @json($matchingData);

    let totalValues1;

    // Check if matchingData is an array
    if (Array.isArray(matchingData)) {
        totalValues1 = matchingData.length;
    } else if (typeof matchingData === 'object') {
        // Check if matchingData is an object
        totalValues1 = Object.keys(matchingData).length;
    } else {
        console.error('matchingData is not an array or object.');
    }

    // Set the value of the <p> element
    const itemCountElement = document.querySelector('.item_count');
    if (itemCountElement) {
        itemCountElement.textContent = ` ${totalValues1} Items`;
    } else {
        console.error('Element with class "item_count" not found.');
    }

    @php
        $searchValue = $searchValue ?? '';
        $selectedGender = $selectedGender ?? '';
        $selectedCategory = $selectedCategory ?? '';
        $selectedSport = $selectedSport ?? '';
        $selectedStyle = $selectedStyle ?? '';
    @endphp

    const searchValue = @json($searchValue);
    const selectedGender = @json($selectedGender);
    const selectedCategory = @json($selectedCategory);
    const selectedSport = @json($selectedSport);
    const selectedStyle = @json($selectedStyle);
    const products = (matchingData && matchingData) ? matchingData : [];
    const productCategories = @json($productCategories);

    var customOrder = [20, 8, 11, 21, 9, 2, 7, 1, 17, 5, 3];
    // var customOrder = [21, 8, 20, 11, 9, 2, 7, 1, 17, 5, 3];

    if (selectedSport == 2 || selectedSport == 15) {
        customOrder = [20, 2, 11, 21, 8, 9, 7, 1, 17, 5, 3];
    }

    if (selectedSport == 25) {
        // customOrder = [21, 8, 20, 11, 9, 2, 7, 1, 17, 5, 3];
        customOrder = [20, 8, 22, 23, 11, 9, 2, 7, 1, 17, 5, 3];
    }

    const sortedCategories = productCategories.sort((a, b) => {
        let aIndex = customOrder.indexOf(Number(a.id));
        let bIndex = customOrder.indexOf(Number(b.id));

        if (aIndex === -1) aIndex = Infinity;
        if (bIndex === -1) bIndex = Infinity;

        return aIndex - bIndex;
    });

    productCategories.forEach(productCategory => {

            var filteredProducts = products.filter(item =>
                item.category.some(cat => cat == productCategory.id)
            );

            // if(selectedStyle != 0 && selectedStyle != productCategory.id){
            //     filteredProducts = [];
            // }

            if (filteredProducts.length > 0) {
                var headerContent = `
                                    <div class="col-lg-12 col-md-12 col-sm-12 mt-3 mb-3" style="padding: 0px 7px;">
                                        <div class="group_topic" style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.3rem; padding-bottom: 0.3rem;">
                                            <span>${productCategory.product_category_name}</span>
                                            <i class="fa fa-chevron-down catagory_chevron mr-3" style="cursor:pointer" data-category-id="${productCategory.id}" aria-hidden="true"></i>
                                        </div>
                                    </div>`;

                $('#paste_container').append(headerContent);

                filteredProducts.forEach((item, index) => {
                    var product = item.data;

                    let extraContent = '';

                    console.log(item.data);

                    let hasSublimation = false;

                    if (item.relatedEmbellishments && item.relatedEmbellishments.length > 0) {
                        hasSublimation = item.relatedEmbellishments.some(e =>
                            e.embellishment_name &&
                            e.embellishment_name.toLowerCase().includes('sublimation')
                        );
                    }

                    if (hasSublimation) {

                        extraContent = `
                            <div class="shine-text">
                                This Product Can Be Sublimated In Any Color
                            </div>
                        `;

                    } else {

                        let colorCircles = '';

                        if (item.relatedFabric && item.relatedFabric.length > 0) {

                            const colors = item.relatedFabric[0].fabric_detail.colors;

                            if (colors) {
                                try {
                                    const parsedColors = JSON.parse(colors);

                                    parsedColors.forEach(color => {
                                        colorCircles += `
                                            <div style="
                                                width:18px;
                                                height:18px;
                                                border-radius:50%;
                                                background:${color.code};
                                                border:1px solid #ccc;
                                            " title="${color.name}"></div>
                                        `;
                                    });

                                } catch (e) {
                                    console.log('Color parse error', e);
                                }
                            }
                        }

                        if (colorCircles) {
                            extraContent = `
                                <div style="display:flex; gap: 13px; padding: 0px 20px;padding-bottom: 10px; align-items:center; margin-top:5px;">
                                    <span style="font-size: 12px; color:#555;">Available In</span>
                                    <div style="display:flex; gap:4px;">
                                        ${colorCircles}
                                    </div>
                                </div>
                            `;
                        }
                        // else {
                        //     // 🔥 IMPORTANT PART (empty case)
                        //     extraContent = `
                        //         <div style="min-height:20px;"></div>
                        //     `;
                        // }
                    }

                    var maxIndex = filteredProducts.length - 1;
                    if (item.type == 'product') {
                        const productId = product.product_id !== undefined ? product.product_id : product.id;
                        const imageURL = product.mockup_img_1 ? product.mockup_img_1 : 'assets/img/products/product_default_image.jpg';

                        let queryParams = [];


                        let sliderImages = '';

                        // ✅ Always show mockup_img_1 first
                        if (product.mockup_img_1) {
                            sliderImages += `<img class="slider-img active"
                                src="https://encr.co/assets/${product.mockup_img_1}"
                                alt="mockup 1"
                                onerror="this.src='assets/img/products/default-loading.gif'">`;
                        }

                        // ✅ Check studio images
                        if (item.studio_images && item.studio_images.length > 0) {

                            // 👉 Add studio images after mockup 1
                            item.studio_images.forEach((img) => {
                                sliderImages += `<img class="slider-img"
                                    src="{{ asset('') }}${img.image_link}"
                                    alt="studio image"
                                    onerror="this.src='assets/img/products/default-loading.gif'">`;
                            });

                        } else {

                            // 👉 Only if NO studio images → add mockup 2 & 3
                            if (product.mockup_img_2) {
                                sliderImages += `<img class="slider-img"
                                    src="https://encr.co/assets/${product.mockup_img_2}"
                                    alt="mockup 2"
                                    onerror="this.src='assets/img/products/default-loading.gif'">`;
                            }

                            if (product.mockup_img_3) {
                                sliderImages += `<img class="slider-img"
                                    src="https://encr.co/assets/${product.mockup_img_3}"
                                    alt="mockup 3"
                                    onerror="this.src='assets/img/products/default-loading.gif'">`;
                            }
                        }

                        // ✅ Final fallback
                        if (!sliderImages) {
                            sliderImages = `<img class="slider-img active"
                                src="https://encr.co/assets/img/products/product_default_image.jpg"
                                alt="default"
                                onerror="this.src='assets/img/products/default-loading.gif'">`;
                        }

                        queryParams.push(`type=${encodeURIComponent('product')}`);
                        if (searchValue) queryParams.push(`search=${encodeURIComponent(searchValue)}`);
                        if (selectedGender) queryParams.push(`selectedGender=${encodeURIComponent(selectedGender)}`);
                        if (selectedCategory) queryParams.push(`selectedCategory=${encodeURIComponent(selectedCategory)}`);
                        if (selectedSport) queryParams.push(`selectedSport=${encodeURIComponent(selectedSport)}`);
                        if (selectedStyle) queryParams.push(`selectedStyle=${encodeURIComponent(selectedStyle)}`);

                        const productUrl = `productDetails/${productId}${queryParams.length ? '?' + queryParams.join('&') : ''}`;

                        const cardDisplay = index < 8 ? 'block' : 'none';
                        const category_class = index >= 8 ? `show_more_category_${productCategory.id}` : '';

                        const productCard = `
                            <div class="col-lg-3 col-md-6 col-sm-6 col-6 product_div div_by_category_${productCategory.id} ${category_class}" style="display: ${cardDisplay};">
                                <div class="card card_div" style=" box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;">


                                        <div class="image_card" style="background-image: url('https://encr.co/assets/img/customer_catalog/catalog_background.jpg');
                                                background-size: cover;
                                                background-position: center;
                                                position: relative;
                                                margin-bottom: 10px;">

                                            <a href="${productUrl}" class="image_class_link">
                                                <div class="slider-container">
                                                    ${sliderImages}
                                                </div>
                                            </a>

                                            <div class="like_tag" style="position: absolute; top: 12px; right: 20px; display:none;">
                                                <img style="width: 22px;" src="{{ asset('argon') }}/img/icons/customer_portal/heart.png" alt="">
                                            </div>
                                        </div>
                                        <div class="product_name" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">

                                            <a href="#" class="product-link two-line-text" style="
                                                text-align: left;
                                                flex: 1;
                                                display: -webkit-box;
                                                -webkit-line-clamp: 2;
                                                -webkit-box-orient: vertical;
                                                overflow: hidden;
                                                font-weight: 500;
                                            ">
                                                ${product.show_in_catalog_name || product.product_name}
                                            </a>

                                            <p class="product-link product_price" style="
                                                white-space: nowrap;
                                                text-align: right;
                                                margin: 0;
                                                font-weight: 500;
                                            ">
                                                $${product.default_price}
                                            </p>

                                        </div>

                                        ${extraContent}

                                        <div class="enquiry_tab hide" style="text-align: center;">
                                            <div class="enquiry_box mb-3 mt-2">
                                                ADD TO ENQUIRY
                                            </div>
                                        </div>

                                </div>
                            </div>

                        `;

                        $('#paste_container').append(productCard);

                        if(index >= 8 && index == maxIndex){
                            var moreContent = `<div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0px 10px;">
                                        <div style="text-align: center;"><button data-category-value="${productCategory.id}" id="show_more_button_${productCategory.id}" class="btn show_more_button" style="padding: .5rem .7rem;">Show more <i class="fa fa-chevron-down catagory_chevron" style="padding-left: 5px;"></i> </button></div>
                                    </div>`;

                            $('#paste_container').append(moreContent);
                        }
                    }else{
                        const productId = product.sub_product_id !== undefined ? product.sub_product_id : product.id;
                        const imageURL = product.mockup_img_1 ? product.mockup_img_1 : 'assets/img/products/product_default_image.jpg';


                        // let sliderImages = '';

                        // // --- Step 1: Add mockup images if available ---
                        // if (product.mockup_img_1) {
                        //     sliderImages += `<img class="slider-img active"
                        //                         src="https://encr.co/assets/${product.mockup_img_1}"
                        //                         alt="mockup 1"
                        //                         onerror="this.src='assets/img/products/default-loading.gif'">`;
                        // }
                        // if (product.mockup_img_2) {
                        //     sliderImages += `<img class="slider-img"
                        //                         src="https://encr.co/assets/${product.mockup_img_2}"
                        //                         alt="mockup 2"
                        //                         onerror="this.src='assets/img/products/default-loading.gif'">`;
                        // }
                        // if (product.mockup_img_3) {
                        //     sliderImages += `<img class="slider-img"
                        //                         src="https://encr.co/assets/${product.mockup_img_3}"
                        //                         alt="mockup 3"
                        //                         onerror="this.src='assets/img/products/default-loading.gif'">`;
                        // }

                        // // --- Step 2: Add studio images if available ---
                        // if (item.studio_images && item.studio_images.length > 0) {
                        //     item.studio_images.forEach((img) => {
                        //         sliderImages += `<img class="slider-img"
                        //                             src="{{ asset('') }}${img.image_link}"
                        //                             alt="studio image"
                        //                             onerror="this.src='assets/img/products/default-loading.gif'">`;
                        //     });
                        // }

                        // // --- Step 3: If nothing, show default image ---
                        // if (!sliderImages) {
                        //     sliderImages = `<img class="slider-img active"
                        //                         src="https://encr.co/assets/img/products/product_default_image.jpg"
                        //                         alt="default"
                        //                         onerror="this.src='assets/img/products/default-loading.gif'">`;
                        // }

                        let sliderImages = '';

                        // ✅ Always show mockup_img_1 first
                        if (product.mockup_img_1) {
                            sliderImages += `<img class="slider-img active"
                                src="https://encr.co/assets/${product.mockup_img_1}"
                                alt="mockup 1"
                                onerror="this.src='assets/img/products/default-loading.gif'">`;
                        }

                        // ✅ Check studio images
                        if (item.studio_images && item.studio_images.length > 0) {

                            // 👉 Add studio images after mockup 1
                            item.studio_images.forEach((img) => {
                                sliderImages += `<img class="slider-img"
                                    src="{{ asset('') }}${img.image_link}"
                                    alt="studio image"
                                    onerror="this.src='assets/img/products/default-loading.gif'">`;
                            });

                        } else {

                            // 👉 Only if NO studio images → add mockup 2 & 3
                            if (product.mockup_img_2) {
                                sliderImages += `<img class="slider-img"
                                    src="https://encr.co/assets/${product.mockup_img_2}"
                                    alt="mockup 2"
                                    onerror="this.src='assets/img/products/default-loading.gif'">`;
                            }

                            if (product.mockup_img_3) {
                                sliderImages += `<img class="slider-img"
                                    src="https://encr.co/assets/${product.mockup_img_3}"
                                    alt="mockup 3"
                                    onerror="this.src='assets/img/products/default-loading.gif'">`;
                            }
                        }

                        // ✅ Final fallback
                        if (!sliderImages) {
                            sliderImages = `<img class="slider-img active"
                                src="https://encr.co/assets/img/products/product_default_image.jpg"
                                alt="default"
                                onerror="this.src='assets/img/products/default-loading.gif'">`;
                        }

                        let queryParams = [];

                        queryParams.push(`type=${encodeURIComponent('sub_product')}`);
                        if (searchValue) queryParams.push(`search=${encodeURIComponent(searchValue)}`);
                        if (selectedGender) queryParams.push(`selectedGender=${encodeURIComponent(selectedGender)}`);
                        if (selectedCategory) queryParams.push(`selectedCategory=${encodeURIComponent(selectedCategory)}`);
                        if (selectedSport) queryParams.push(`selectedSport=${encodeURIComponent(selectedSport)}`);
                        if (selectedStyle) queryParams.push(`selectedStyle=${encodeURIComponent(selectedStyle)}`);

                        const productUrl = `productDetails/${productId}${queryParams.length ? '?' + queryParams.join('&') : ''}`;

                        const cardDisplay = index < 8 ? 'block' : 'none';
                        const category_class = index >= 8 ? `show_more_category_${productCategory.id}` : '';

                        const productCard = `
                            <div class="col-lg-3 col-md-6 col-sm-6 col-6 product_div div_by_category_${productCategory.id} ${category_class}" onmouseover="showEnquiryTab(this)" onmouseout="hideEnquiryTab(this)" style="display: ${cardDisplay};">
                                <div class="card card_div" style=" box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;">

                                        <div class="image_card"  style="background-image: url('https://encr.co/assets/img/customer_catalog/catalog_background.jpg');
                                                background-size: cover;
                                                background-position: center;
                                                position: relative;
                                                margin-bottom: 10px;">

                                            <a href="${productUrl}">
                                                <div class="slider-container">
                                                    ${sliderImages}
                                                </div>
                                            </a>

                                            <div class="like_tag" style="position: absolute; top: 12px; right: 20px; display:none;">
                                                <img style="width: 22px;" src="{{ asset('argon') }}/img/icons/customer_portal/heart.png" alt="">
                                            </div>
                                        </div>
                                        <div class="product_name" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">

                                            <a href="#" class="product-link two-line-text" style="
                                                text-align: left;
                                                flex: 1;
                                                display: -webkit-box;
                                                -webkit-line-clamp: 2;
                                                -webkit-box-orient: vertical;
                                                overflow: hidden;
                                                font-weight: 500;
                                            ">
                                                ${product.show_in_catalog_name || product.product_name}
                                            </a>

                                            <p class="product-link product_price" style="
                                                white-space: nowrap;
                                                text-align: right;
                                                margin: 0;
                                                font-weight: 500;
                                            ">
                                                $${product.default_price}
                                            </p>

                                        </div>

                                        ${extraContent}

                                        <div class="enquiry_tab hide" style="text-align: center;">
                                            <div class="enquiry_box mb-3 mt-2">
                                                ADD TO ENQUIRY
                                            </div>
                                        </div>

                                </div>
                            </div>

                        `;

                        $('#paste_container').append(productCard);

                        if(index >= 8 && index == maxIndex){
                            var moreContent = `<div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0px 10px;">
                                        <div style="text-align: center;"><button data-category-value="${productCategory.id}" id="show_more_button_${productCategory.id}" class="btn show_more_button" style="padding: .5rem .7rem;">Show more <i class="fa fa-chevron-down catagory_chevron" style="padding-left: 5px;"></i> </button></div>
                                    </div>`;

                            $('#paste_container').append(moreContent);
                        }
                    }
                });
            }
    });

    // let sliderTimers = new WeakMap();

    // document.addEventListener('mouseover', function (e) {
    //     const container = e.target.closest('.slider-container');
    //     if (!container) return;

    //     const images = container.querySelectorAll('.slider-img');
    //     if (images.length <= 1) return;

    //     let index = 0;
    //     const timer = setInterval(() => {
    //         images[index].classList.remove('active');
    //         index = (index + 1) % images.length;
    //         images[index].classList.add('active');
    //     }, 1200);

    //     sliderTimers.set(container, timer);
    // });

    // document.addEventListener('mouseout', function (e) {
    //     const container = e.target.closest('.slider-container');
    //     if (!container) return;

    //     const timer = sliderTimers.get(container);
    //     if (timer) {
    //         clearInterval(timer);
    //         sliderTimers.delete(container);
    //     }

    //     // Reset back to first image
    //     const images = container.querySelectorAll('.slider-img');
    //     if (images.length > 0) {
    //         images.forEach(img => img.classList.remove('active'));
    //         images[0].classList.add('active');
    //     }
    // });

    let activeSliderContainer = null;
    let activeSliderTimer = null;

    function stopActiveSlider() {

        if (activeSliderTimer) {
            clearInterval(activeSliderTimer);
            activeSliderTimer = null;
        }

        if (activeSliderContainer) {
            const images = activeSliderContainer.querySelectorAll('.slider-img');

            images.forEach(img => img.classList.remove('active'));

            if (images.length > 0) {
                images[0].classList.add('active');
            }

            activeSliderContainer = null;
        }
    }


    function startSlider(container) {

        // Same product එක already running නම් නැවත start කරන්න එපා
        if (activeSliderContainer === container) {
            return;
        }

        // කලින් product එක stop කරන්න
        stopActiveSlider();

        const images = container.querySelectorAll('.slider-img');

        if (images.length <= 1) {
            return;
        }

        activeSliderContainer = container;

        let index = 0;

        // First image active
        images.forEach(img => img.classList.remove('active'));
        images[0].classList.add('active');

        activeSliderTimer = setInterval(() => {

            // Safety check
            if (activeSliderContainer !== container) {
                clearInterval(activeSliderTimer);
                activeSliderTimer = null;
                return;
            }

            images[index].classList.remove('active');

            index = (index + 1) % images.length;

            images[index].classList.add('active');

        }, 1200);
    }


    // Desktop hover
    document.addEventListener('mouseover', function (e) {

        const container = e.target.closest('.slider-container');

        if (!container) return;

        // Child element එකකින් parent එකට move වෙනකොට
        // unnecessarily restart නොකරන්න
        if (e.relatedTarget && container.contains(e.relatedTarget)) {
            return;
        }

        startSlider(container);
    });


    // Desktop mouse leave
    document.addEventListener('mouseout', function (e) {

        const container = e.target.closest('.slider-container');

        if (!container) return;

        // Container ඇතුළේ element එකකට move වෙනවා නම් stop කරන්න එපා
        if (e.relatedTarget && container.contains(e.relatedTarget)) {
            return;
        }

        if (activeSliderContainer === container) {
            stopActiveSlider();
        }
    });


    // Mobile / touch
    document.addEventListener('touchstart', function (e) {

        const container = e.target.closest('.slider-container');

        if (!container) return;

        startSlider(container);
    }, {
        passive: true
    });

    $(document).on('click', '.show_more_button', function () {
        var categoryId = $(this).data('category-value');
        var targetDivs = $(`.show_more_category_${categoryId}`);

        targetDivs.toggle();

        if (targetDivs.is(':visible')) {
            $(this).text('Show less');
        } else {
            $(this).text('Show more');
        }
    });

    $(document).on('click', '.catagory_chevron', function () {
        var categoryId = $(this).data('category-id');
        var targetDivs = $('.div_by_category_' + categoryId);

        var targetHideDivs = $(`.show_more_category_${categoryId}`);

        $(this).toggleClass('fa-chevron-down fa-chevron-right');

        if (targetDivs.is(':visible')) {
            targetDivs.hide();
            $('#show_more_button_'+categoryId).text('Show more');
            $('#show_more_button_'+categoryId).hide();
        } else {
            targetDivs.show();
            targetHideDivs.hide();
            $('#show_more_button_'+categoryId).show();
        }
    });

</script>



<script>
    $(document).ready(function () {
        var searchInput = $('#searchInput');
        var searchForm = $('#searchForm');

        $('.search_text').on('input', function () {
            var searchValue = $(this).val();
            searchInput.val(searchValue);
        });

        $('.search_text').on('blur', function () {
            var searchValue = $(this).val();
            searchInput.val(searchValue);

            // Trigger form submission only if the input is not empty
            if (searchValue.trim() !== '') {
                searchForm.submit();
            }
        });

        $('.search_text').on('keydown', function (event) {
            if (event.key === 'Enter') {
                // Enter key is pressed
                var searchValue = $(this).val();
                searchInput.val(searchValue);

                // Trigger form submission only if the input is not empty
                if (searchValue.trim() !== '') {
                    searchForm.submit();
                }
            }
        });
    });


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


{{-- Enquary button temparary hide --}}
<script>

    // function showEnquiryTab(element) {
    //     // Hide product_name div
    //     element.querySelector('.product_name').style.display = 'none';

    //     // Show enquiry_tab div
    //     element.querySelector('.enquiry_tab').style.display = 'block';
    // }

    // function hideEnquiryTab(element) {
    //     // Show product_name div
    //     element.querySelector('.product_name').style.display = 'block';

    //     // Hide enquiry_tab div
    //     element.querySelector('.enquiry_tab').style.display = 'none';
    // }

</script>

<script>
    // document.getElementById("show-search-bar").addEventListener("click", function() {
    //     document.querySelector(".enquary_attribute_icon").classList.add("search_box_visible");
    //     document.querySelector(".search_box").classList.remove("search_box_visible");
    // });

    // document.getElementById("close-search").addEventListener("click", function() {
    //     document.querySelector(".search_box").classList.add("search_box_visible");
    //     document.querySelector(".enquary_attribute_icon").classList.remove("search_box_visible");
    // });

    // Listen for clicks anywhere on the page
    // document.addEventListener("click", function(event) {
    //     if (!document.querySelector(".search_box").contains(event.target)) {
    //         // Click was outside of the search_box, hide it
    //         document.querySelector(".search_box").classList.add("search_box_visible");
    //         document.querySelector(".filter_attribute").classList.remove("search_box_visible");
    //     }
    // });
</script>

{{-- <script>
    const input = document.querySelector('.search_text');
    const placeholderText = "Search Products By; Category, Sport, Style, Gender, Name";
    let index = 0;

    function updatePlaceholder() {
      input.setAttribute('placeholder', placeholderText.substring(0, index));

      if (index < placeholderText.length) {
        index++;
        setTimeout(updatePlaceholder, 100); // Adjust the delay (in milliseconds) between each letter
      } else {
        index = 0;
        setTimeout(updatePlaceholder, 1000); // Adjust the delay (in milliseconds) before it starts over
      }
    }

    updatePlaceholder();


  </script> --}}

@endsection
