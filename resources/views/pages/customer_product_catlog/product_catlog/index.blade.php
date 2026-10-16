@extends('layouts.customer_portal.app')

@section('content')

<style>
    /* General Styles */
    body {
        background-color: transparent !important;
        min-width: 320px;
    }

    .navbar {
        background-color: white;
        padding: unset;
        width: 100%;
        z-index: 1000;
    }

    .head_p {
        color: rgb(55, 55, 55) !important;
        font-weight: 600;
        font-size: 24px;
        text-align: right;
        /* margin-top: 1.5rem; */
    }

    .search_div {
        height: 40px;
        /* box-shadow: 10px 10px 30px 0px rgba(0, 0, 0, 0.05); */
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
        border: 1px solid rgba(222, 222, 222, 1);
        width: 88%;
    }

    .search_text::placeholder {
        font-size: 13px;
        text-align: left;
        color: rgba(202, 201, 201, 1);
    }


    .view_style {
        font-size: 33px;
        font-weight: 600;
        margin-bottom: 0rem;
    }

    .view_card {
        height: 75px;
        background: #f6f6f6;
        justify-content: center;
        border: none;
        box-shadow: unset !important;
        transform: unset !important;
        overflow: hidden;
        position: relative;
    }

    .view_text {
        color: rgba(113, 112, 112, 1);
        text-align: center;
    }

    .view_card:hover .view_text {
        color: gray;
    }

    .sport_img {
        /* max-width: 33% !important; */
    }

    .sport_img_hover {
        display: none;
    }

    .search_bar_text:hover .search_bar_text {
        color: rgba(113, 112, 112, 1);
    }

    .sport_card {
        margin-right: -9px;
        margin-left: -9px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sports_card {
        height: 100px;
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

    .search_box_visible {
        display: none;
    }

    .sports-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
        gap: 6px;
    }

    .sports-container .row {
        width: 100%;
        justify-content: center;
    }

    .style-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
        gap: 6px;
    }

    .style-container .row {
        width: 110%;
        justify-content: center;
    }

    .sub-header-style {
        font-size: 1rem;
        color: rgb(55, 55, 55) !important;
    }

    .btn {
        height: 100px;
        padding: 5px;
        background: none;
        position: relative;
        border: none;
        box-shadow: unset !important;
        transform: unset !important;
    }

    .hover-button-styles {
        display: inline-block;
        padding: 5%;
        border: 2px solid #afafb0;
        border-radius: 1.5rem;
        position: relative;
        overflow: hidden;
        font-size: 0.9rem;
        width: 100%;
        transition: all 300ms ease;
    }

    .hover-button-styles:hover {
        animation: borderHover 2s infinite;
    }

    .hover-button-styles::before,
    .hover-button-styles::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: none;
        border: 2px solid #afafb0;
        border-radius: 1.5rem;
        z-index: -1;
        transition: transform 0.3s ease-in-out;
    }

    .hover-button-styles::before {
        top: 0;
        left: -100%;
        transform-origin: left bottom;
    }

    .hover-button-styles::after {
        bottom: 0;
        right: -100%;
        transform-origin: right top;
    }

    .hover-button-styles:hover::before {
        transform: translateX(100%);
    }

    .hover-button-styles:hover::after {
        transform: translateX(-100%);
    }

    /* @keyframes borderHover {
        0% {
            border-color: #afafb0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0);
        }

        50% {
            border-color: #7f8c8d;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        100% {
            border-color: #afafb0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0);
        }
    } */

    .sec.category-section,
    .sec.gender-section,
    .sec.sport-section,
    .sec.style-section,
    .category-section {
        /* min-height: 80vh; */
    }

    .search_text:focus {
        background-color: transparent;
    }

    .body_class {
        background-color: transparent !important;
    }

    .all_apparel {
        max-width: 98% !important;
    }

    .text_align_self {
        align-self: center;
    }

    .font_size {
        font-size: 4vw !important;
    }

    .height-250 {
        height: 250px;
    }

    .height-200 {
        height: 120px !important;
    }

    .width-150 {
        width: 150px;
    }

    .margin_t_unset {
        margin-top: unset !important;
    }

    .padding_l_unset {
        padding-left: unset !important;
    }

    .padding_r_unset {
        padding-right: unset !important;
    }

    .hover-button-styles-setup {
        font-size: 0.85rem !important;
        /* width: 110% !important; */
    }

    .set-padding {
        padding-left: 5% !important;
        padding-right: 7% !important;
    }

    .image_width_logo {
        width: -webkit-fill-available;
        height: 85px;
    }

    @media (max-width: 768px) {
        .hover-button-styles {
            font-size: 0.8rem;
        }

        .text_align_self {
            text-align: center;
        }
    }

    @media (max-width: 576px) {

        .hover-button-styles {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 420px) {

        .hover-button-styles {
            font-size: 0.65rem;
        }
    }

    .enquary_attribute {
        /* margin-left: 26px;
        padding-left: 32px; */
        padding-top: 23px;
        /* margin-right: 26px;
        padding-right: 32px; */
        /* width: 93%; */
    }
    .text_align_left {
        text-align: left;
    }
    .text_position {
        top: -40px;
        position: relative;
        text-align: left;
        left: 76px;
    }
.category-card {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    filter: grayscale(100%);
    width: 100%;

    /* ❌ remove this */
    /* height: 50vh; */
    /* min-height: 300px; */
}


    .category-card:hover {
        filter:unset;
    }
    /* Dark overlay ekak denna nam */
    .category-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.23);
    }

    .category-card a {
        position: relative;
        z-index: 2;
        color: white !important;
        font-weight: 600;
    }
    .category-card {
        position: relative;
        background-size: cover;
        background-position: center;
        overflow: hidden;
        cursor: pointer;
    }

    /* Overlay container */
    .category-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0%;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding-bottom: 20px;
        transition: all 0.4s ease;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0) 46.64%);
        opacity: 0;
    }

    /* Category name */
    .category-name {
        color: #fff;
        font-weight: 600;
        transform: translateY(20px);
        transition: all 0.4s ease;
    }

    /* 🔥 Hover Effect */
    .category-card:hover .category-overlay {
        height: 100%;
        opacity: 1;
    }

    .category-card:hover .category-name {
        transform: translateY(0);
    }

.slider-card {
    width: 100%;
    position: relative;
    min-height: 100%;
    height: 100%;
    padding: unset;
}

.slider-card img {
    width: 100%;
    height: auto;
    display: none;
}

.slider-card img.active {
    display: block;
}

.slider-card img.active {
    opacity: 1;
}
.search_main_div {
    padding: 30px 35%;
    text-align: center;
}
.header_search {
    display: none;
}
.view_fabric {
    color: gray;
    font-size: 12px;
}
.btm_padding_20 {
    padding-bottom: 20px;
}
.category-section{
    display: flex;
    flex-wrap: wrap;
}

/* Mobile layout fix */
@media (max-width: 576px){

    .category-section .cat-div{
        /* width: 50%; */
    }

    /* last card center */
    .category-section .cat-div:last-child{
        margin-left: auto;
        margin-right: auto;
    }

}
.slider-card {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.slider-card img {
    width: 100%;
    height: auto; /* keep image ratio */
    display: none;
}

.slider-card img.active {
    display: block;
}
.cat-div {
    height: 100%;
    min-height: 100%;
}
.main_card_category {
     padding-left: 10%;
     padding-right: 10%;
}
@media (min-width: 1536px){
    .main_card_category {
        padding-left: 20%;
        padding-right: 20%;
    }
}

@media (max-width: 768px) {
    .customer-filter-toggle {
        display: none;
    }
}


/* ---------------------------------------------------------
   Mobile
   --------------------------------------------------------- */

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

@media (max-width: 768px) {

    /* Target the OUTER category section */
    .sec.category-section:has(.search_main_div) {
        display: flex !important;
        flex-direction: column !important;
        padding-top: 8rem !important;
    }

    /* Search */
    .sec.category-section:has(.search_main_div) > .search_main_div {
        order: 1 !important;
    }

    /* Category cards */
    .sec.category-section:has(.search_main_div) > .main_card_category {
        order: 2 !important;
    }

    /* Bottom links */
    .sec.category-section:has(.search_main_div) > div:last-child {
        order: 3 !important;
    }
    .mobile_footer_gap {
        gap: 10px 0px;
    }
}

/* Mobile - Always show category name */
@media (max-width: 768px) {

    .category-card .category-overlay {
        height: 100% !important;
        opacity: 1 !important;
        bottom: 0;
        align-items: flex-end;
        padding-bottom: 15px;
        background: linear-gradient(
            to top,
            rgba(0, 0, 0, 0.75),
            rgba(0, 0, 0, 0) 60%
        );
    }

    .category-card .category-name {
        transform: translateY(0) !important;
        opacity: 1 !important;
        color: #fff !important;
        font-weight: 600;
        font-size: 16px;
    }
    .mobile_padding_unset {
        padding: unset !important;
    }

}

.category-card.slider-card {
    width: 100%;
    height: 33em !important;
    min-height: 33em !important;
    overflow: hidden;
    position: relative;
}

.category-card.slider-card img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: none;
}

.category-card.slider-card img.active {
    display: block !important;
}

</style>

<div class="navbar" style=" background-color:white; z-index:99;">

    @section('page-route')

        <a href="">
            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" alt="image" style="color:black; width: auto !important;" class="image_width_logo">
        </a>

    @endsection

    @include('pages.customer_product_catlog.layout.header')

</div>


<div class="sec category-section" style="padding-top: 50px;">


    <div class="row category-section justify-content-center main_card_category"
     style="text-align:center;">
            @foreach ($main_categories as $main_categorie)
                @php
                    $categoryId = $main_categorie->id;
                    $categoryName = $main_categorie->category_name;
                @endphp

                @if ($categoryId !== 5 && $categoryId !== 6 && $categoryId == 1)

                    <div class="col-lg-4 col-md-6 col-sm-12 cat-div btm_padding_20">
                        <div class="card view_card btn view_text category-card slider-card"
                            id="category"
                            data-category="{{ $categoryId }}">
                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/game_uni.jpg" class="active">
                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/game_uni_1.jpg">
                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/game_uni_2.jpg">
                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/game_uni_3.jpg">

                            <input type="hidden" readonly value="{{ $categoryId }}">

                            <div class="category-overlay">
                                <span class="category-name">{{ $categoryName }}</span>
                            </div>

                        </div>
                    </div>

                @elseif ($categoryId !== 5 && $categoryId !== 6 && $categoryId == 2)
                    <div class="col-lg-4 col-md-6 col-sm-12 cat-div btm_padding_20">
                        <div class="card view_card btn view_text category-card slider-card"
                            id="category"
                            data-category="{{ $categoryId }}">

                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/training_apparel.jpg" class="active">
                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/training_apparel_3.jpg">
                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/training_apparel_1.jpg">
                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/training_apparel_2.jpg">

                            <input type="hidden" readonly value="{{ $categoryId }}">

                            <div class="category-overlay">
                                <span class="category-name">{{ $categoryName }}</span>
                            </div>

                        </div>
                    </div>
                @elseif ($categoryId !== 5 && $categoryId !== 6 && $categoryId == 3)
                    <div class="col-lg-4 col-md-6 col-sm-12 cat-div btm_padding_20">
                        <div class="card view_card btn view_text category-card slider-card"
                            id="category"
                            data-category="{{ $categoryId }}">

                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/lifestyle_apparel_main.jpg" class="active">
                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/lifestyle_apparel_1.jpg">
                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/lifestyle_apparel_2.jpg">
                            <img src="{{ asset('assets') }}/img/customer_catalog/main_page/lifestyle_apparel_3.jpg">

                            <input type="hidden" readonly value="{{ $categoryId }}">

                            <div class="category-overlay">
                                <span class="category-name">{{ $categoryName }}</span>
                            </div>

                        </div>
                    </div>
                @endif

            @endforeach

    </div>

    <div class="search_main_div">
        <div class="card search_div row" style="border: unset;">

            <div class="col-12 col-lg-12 form-control"
                style="padding: 6px 10px; margin-top: 3px; background-color: transparent; border-radius: 7px; border: 0.5px solid #c7c7c7;">

                <div class="input-group align-items-center">

                    <!-- Search Icon FIRST -->
                    <span class="input-group-text"
                        style="background: none; border: none; padding-left: 4px;">
                        <i class="fas fa-search" style="color: #777;"></i>
                    </span>

                    <!-- Input NEXT -->
                    <input type="text"
                        class="form-control search_text"
                        placeholder="Search"
                        style="border: none; box-shadow: none; background: transparent;">

                </div>
            </div>


        </div>
    </div>

    <div class="mobile_padding_unset" style="padding: 0px 30%;">
        <div class="row mobile_footer_gap" style="text-align: center; padding-bottom: 20px;">
            <div class="col-lg-4">
                <div>
                    @foreach ($main_categories as $main_categorie)
                        @php
                            $categoryId = $main_categorie->id;
                            $categoryName = $main_categorie->category_name;
                        @endphp

                        @if ($categoryId == 5)
                        <a href="#" class="" id="category" data-category="{{ $categoryId }}">
                            <input type="hidden" readonly value="{{ $categoryId }}">

                            <span class="view_fabric">View All Apparel</span>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4">
                <div>
                <a href="{{ route('commonFabricPage') }}"
                    target="_blank"
                    class="view-all-fabrics">
                        <span class="view_fabric">View Our Fabrics</span>
                </a>
                </div>
            </div>
            <div class="col-lg-4">
                <div>
                    <a href="{{ route('embellishmentPage') }}"
                        target="_blank"
                        class="view-all-embellishment">
                            <span class="view_fabric">View Our Embellishments</span>
                    </a>
                </div>
            </div>

        </div>
    </div>


</div>

<div class="sec row gender-section" style="padding-top: 100px;display: flex;justify-content: center;">
    <div class="gender-section col-lg-12 col-md-12 col-sm-12" style=" text-align: center; margin-top: 10px;">
        <p class="view_style gender-animated-text" id="animated-text">For</p>
    </div>

    <div class="col-lg-12 col-sm-8 col-md-6 gender-section" style="text-align: center;display: flex;justify-content: center;">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="row">

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card view_card btn view_text"  id="gender" id="gender" data-gender="Men" style="vertical-align: middle; height: 75px;">
                        <a href="#" class="view_text gender_card hover-button-styles" id="gender" data-gender="Men" style="z-index: 1;">
                            <input type="hidden" value="Men">Men's</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card view_card btn view_text " id="gender" data-gender="Women" style="vertical-align: middle; height: 75px;">
                        <a href="#" class="view_text gender_card hover-button-styles" data-gender="Women" style="z-index: 1;">
                            <input type="hidden" value="Women">Women's</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card view_card btn view_text" id="gender" data-gender="All" style="vertical-align: middle; height: 75px;">
                        <a href="#" class="view_text gender_card hover-button-styles" data-gender="All" style="z-index: 1;">
                            <input type="hidden" value="All">All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="sec sport-section mb-3" style="">
    <div class="" style="text-align: center; margin-top: 10px;">
        <p class="view_style sport-animated-text" id="animated-text">Specifically used / wear in the sport of</p>
    </div>


    <div class="col-lg-12 padding_r_unset padding_l_unset" style="text-align: center; padding-left: 20%; padding-right: 20%;">
            <div class="sports-container" style="padding:1% 5%;">
                <div class="row padding-l-15">
                    @foreach ($sports as $sport)

                        <div class="col-lg-2 col-md-3 col-sm-4 sport-div width-150 padding-unset">
                            <div class="card view_card sport_card sports_card btn view_text"  id="sport"  data-sport="{{ $sport->id }}" style="vertical-align: middle;">


                                    <a href="#" class="view_text hover-button-styles margin_t_unset width-unset text_align_left" style="z-index: 1; border: unset; padding: 3%;" id="sport"  data-sport="{{ $sport->id }}">
                                        <img class="sport_img" src="{{ asset('assets') . '/' . $sport->sport_image }}" alt="{{ $sport->sport_image }}" style="max-width: 100%;height:4rem; width:auto">
                                        {{-- <br> --}}
                                        <span class="font_size text_position" style="font-size: .8rem !important;">{{$sport->sport_name}}</span>
                                    </a>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
    </div>

</div>

<div class="sec style-section" style="padding-top: 100px;">
    <div class="" style="text-align: center; margin-top: 10px;">
        <p class="view_style style-animated-text" id="animated-text">In those product styles</p>
    </div>


    <div class="col-lg-12 set-padding" style="text-align: center; padding-left: 23%; padding-right: 23%;">
            <div class="style-container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-6">
                        <div style="height:75px;" class="card view_card row sport_card style btn view_text" id="style" data-style="All" style="vertical-align: middle; height: 75px;">
                            <a href="#" class="view_text style_card hover-button-styles hover-button-styles-setup " id="style" data-style="All">
                                All
                            </a>
                        </div>
                    </div>
                    @foreach ($productCategories as $productCategory)

                    <div class="col-lg-3 col-md-3 col-6">
                        <div style="height:75px;" class="card view_card row sport_card style btn view_text" id="style" data-style="{{ $productCategory->id }}" style="vertical-align: middle; height: 75px;">
                            <a href="#" class="view_text style_card hover-button-styles hover-button-styles-setup " id="style" data-style="{{ $productCategory->id }}">
                                {{$productCategory->product_category_name}}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
    </div>

</div>

{{-- @include('pages.customer_product_catlog.layout.footer') --}}


<script>
    function submitFilterForm() {
        const selectedCategory = document.querySelector('input[name="selectedCategory"]').value;
        const selectedGender = document.querySelector('input[name="selectedGender"]').value;
        const selectedSport = document.querySelector('input[name="selectedSport"]').value;
        const selectedStyle = document.querySelector('input[name="selectedStyle"]').value;

        const url = "{{ route('product_filter1') }}" +
            "?selectedCategory=" + encodeURIComponent(selectedCategory) +
            "&selectedGender=" + encodeURIComponent(selectedGender) +
            "&selectedSport=" + encodeURIComponent(selectedSport) +
            "&selectedStyle=" + encodeURIComponent(selectedStyle);

        window.location.href = url; // Update the URL without triggering a page reload
        return false; // Prevent the form from submitting normally
    }
</script>

<form action="{{ route('product_filter1') }}" method="GET" id="filterForm" onsubmit="return submitFilterForm()">
    @csrf
    <input type="hidden" name="selectedCategory" id="selectedCategoryInput" value="">
    <input type="hidden" name="selectedGender" id="selectedGenderInput" value="">
    <input type="hidden" name="selectedSport" id="selectedSportInput" value="">
    <input type="hidden" name="selectedStyle" id="selectedStyleInput" value="">
    <button style="display: none;" type="submit">Submit</button>
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

</script>

<script>
    document.getElementById("show-search-bar").addEventListener("click", function() {
        document.querySelector(".searchBar_text").classList.add("search_box_visible");
        document.querySelector(".search_box").classList.remove("search_box_visible");
    });

    document.getElementById("close-search").addEventListener("click", function() {
        document.querySelector(".search_box").classList.add("search_box_visible");
        document.querySelector(".searchBar_text").classList.remove("search_box_visible");
    });


</script>



<script>
    const categoryLinks = document.querySelectorAll('[id="category"]');
    const genderLinks = document.querySelectorAll('[id="gender"]');
    const sportLinks = document.querySelectorAll('[id="sport"]');
    const styletLinks = document.querySelectorAll('[id="style"]');

    const categorySection = document.querySelector('.category-section');
    const genderSection = document.querySelector('.gender-section');
    const sportSection = document.querySelector('.sport-section');
    const styleSection = document.querySelector('.style-section');

    let selectedCategory = null;
    let selectedGender = null;
    let selectedSport = null;
    let selectedStyle = null;

    categorySection.style.display = 'block';
    genderSection.style.display = 'none';
    sportSection.style.display = 'none';
    styleSection.style.display = 'none';

    categoryLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            selectedCategory = link.getAttribute('data-category');

            const selectedCategoryInput = document.getElementById('selectedCategoryInput');
            const selectedGenderInput = document.getElementById('selectedGenderInput');
            const selectedSportInput = document.getElementById('selectedSportInput');
            const selectedStyleInput = document.getElementById('selectedStyleInput');

            // ✅ Set default values
            selectedCategoryInput.value = selectedCategory;
            selectedGenderInput.value = 'All';   // default gender
            selectedSportInput.value = 18;       // default sport
            selectedStyleInput.value = 0;        // default style

            // ✅ Submit form immediately
            document.getElementById('filterForm').submit();
        });
    });


const sliders = document.querySelectorAll('.slider-card');

sliders.forEach(slider => {
    const imgs = slider.querySelectorAll('img');
    let index = 0;
    let interval;
    let timeout;

    function changeImage() {
        imgs[index].classList.remove('active');
        index = (index + 1) % imgs.length;
        imgs[index].classList.add('active');
    }

    slider.addEventListener('mouseenter', () => {

        // wait 1 second before first change
        timeout = setTimeout(() => {
            changeImage();

            // then continue every 1 second
            interval = setInterval(changeImage, 1300);
        }, 300);

    });

    slider.addEventListener('mouseleave', () => {
        clearTimeout(timeout);
        clearInterval(interval);

        imgs.forEach(img => img.classList.remove('active'));
        index = 0;
        imgs[0].classList.add('active');
    });
});



</script>

@endsection
