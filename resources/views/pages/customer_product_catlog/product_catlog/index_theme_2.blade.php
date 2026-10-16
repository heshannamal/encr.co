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
        padding: 10px;
        width: 100%;
        z-index: 1000;
    }

    .head_p {
        color: rgb(55, 55, 55) !important;
        font-weight: 600;
        font-size: 24px;
        text-align: right;
        margin-top: 1.5rem;
    }
    .search_div {
        height: 40px;
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
        font-weight: 400;
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
        max-width: 33% !important;
    }

    .sport_img_hover {
        display: none;
    }

    .search_bar_text:hover .search_bar_text {
        color: rgba(113, 112, 112, 1);
    }

    /* .sport_card {
        margin-right: -9px;
        margin-left: -9px;
        display: flex;
        align-items: center;
        justify-content: center;
    } */

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
        height: 100%;
        padding: 5px;
        background: none;
        position: relative;
        border: none;
        box-shadow: unset !important;
        transform: unset !important;
    }

    .hover-button-styles {
        display: inline-block;
        /* padding: 5%; */
        /* border: 2px solid #afafb0; */
        /* border-radius: 1.5rem; */
        position: relative;
        overflow: hidden;
        font-size: 0.9rem;
        width: 100%;
        transition: all 300ms ease;
        background-color: rgb(238, 238, 238);
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
        /* border: 2px solid #afafb0; */
        /* border-radius: 1.5rem; */
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

    @keyframes borderHover {
        0% {
            border-color: #d4d4d4;
            box-shadow: 0 0 10px rgba(100, 100, 100, 0);
        }

        50% {
            border-color: #d4d4d4;
            box-shadow: 0 0 10px rgba(99, 99, 99, 0.5);
        }

        100% {
            border-color: #d4d4d4;
            box-shadow: 0 0 10px rgba(100, 100, 100, 0);
        }
    }

    .sec.category-section,
    .sec.gender-section,
    .sec.sport-section,
    .sec.style-section {
        min-height: 64vh;
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
        padding-left: 3.5% !important;
        padding-right: 4% !important;
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
    @media (min-width: 2048px) {

        .image_width {
            height: 110px;
        }
    }
    @media (min-width: 992px) {

        .gender-section .product_div {
            max-width: 18.67% !important;
            flex: 0 0 17.67% !important;
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
    .div_padding {
        padding-left: 5px;
        padding-right: 5px;
    }

    .category-link {
        display: block;
        position: relative;
        overflow: hidden;
    }

    .image-container {
        position: relative;
    }

    .category-image {
        width: 100%;
        display: block;
    }

    .gradient_css {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50px;
        background: linear-gradient(to top, rgba(83, 83, 83, 0.5), transparent);
        z-index: 1;
    }

    .style_name {
        position: absolute;
        bottom: 9px;
        left: 10px;
        color: white;
        font-size: 1.2rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.95);
        z-index: 1;
        width: 92%;
    }
    .product_div {
        padding-left: 8px;
        padding-right: 8px;
        padding-bottom: 16px;
    }
    .sports-container {
        padding-bottom: 10px !important;
    }
    @media (min-width: 992px) {
        .col-lg-2_4 {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }
    .product_name {
        color: rgb(80, 80, 80) !important;
        padding-bottom: 10px;
    }
    .content-wrapper {
        flex: 1; /* This pushes the footer to the bottom */
    }
    html, body {
            height: 100%; /* Ensure the body takes the full viewport height */
            margin: 0; /* Remove any default margin */
            display: flex;
            flex-direction: column; /* Make the body a flex container */
        }

        .main-wrapper {
            flex: 1; /* Allows content to grow/shrink as needed */
            display: flex;
            flex-direction: column;
        }

</style>

<div class="navbar" style=" background-color:white; z-index:99; padding: unset;">

    @section('page-route')

        <a href="">
            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" alt="image" style="color:black; width: auto !important;" class="image_width_logo">
        </a>

    @endsection

    @section('apparel-catalog')
        <p class="head_p">APPAREL CATALOG</p>
    @endsection

    @include('pages.customer_product_catlog.layout.header')

</div>

<div class="content-wrapper" >
    <div class="sec category-section" style=" min-height: 0;">
        <div class="category-section" style="text-align: center; margin-top: 2%;">

        </div>


        <div class="col-lg-12 row category-section justify-content-center" style="text-align: center; padding: 0; margin: 0; padding-top: 4%;">

            @foreach ($main_categories as $main_categorie)
                @php
                    $categoryId = $main_categorie->id;
                    $categoryName = $main_categorie->category_name;
                    $categorImage = $main_categorie->style_image;
                @endphp

                @if ($categoryId == 5)


                    <div class="col-lg-2 col-md-4 col-sm-6 product_div">
                        <div class="card" style=" box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;" id="category" data-category="{{ $categoryId }}" >
                            <div>

                                <div class="image_card" style="padding: 10px;">

                                    <a href="#" data-category="{{ $categoryId }}">
                                        <img src="{{ asset($categorImage) }}" alt="{{ $categoryName }}" style="width: 100%; border: 0.3px solid rgb(227, 227, 227); background-color: rgba(246, 246, 246, 0.51);">
                                    </a>
                                </div>
                                <div class="product_name" style="text-align: center; font-size: 17px;">
                                    <input type="hidden" readonly value="{{ $categoryId }}">{{ $categoryName }}
                                </div>

                            </div>
                        </div>
                    </div>

                @endif
            @endforeach

            @foreach ($main_categories as $main_categorie)
                @php
                    $categoryId = $main_categorie->id;
                    $categoryName = $main_categorie->category_name;
                    $categorImage = $main_categorie->style_image;
                @endphp

                @if ($categoryId !== 5 && $categoryId !== 6)

                    <div class="col-lg-2 col-md-4 col-sm-6 product_div">
                        <div class="card" style=" box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;" id="category" data-category="{{ $categoryId }}">
                            <div>

                                <div class="image_card" style="padding: 10px;">

                                    <a href="#" data-category="{{ $categoryId }}">
                                        <img src="{{ asset($categorImage) }}" alt="{{ $categoryName }}" style="width: 100%; border: 0.3px solid rgb(227, 227, 227); background-color: rgba(246, 246, 246, 0.51);">
                                    </a>
                                </div>
                                <div class="product_name" style="text-align: center; font-size: 17px;">
                                    <input type="hidden" readonly value="{{ $categoryId }}">{{ $categoryName }}
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @foreach ($main_categories as $main_categorie)
                @php
                    $categoryId = $main_categorie->id;
                    $categoryName = $main_categorie->category_name;
                    $categorImage = $main_categorie->style_image;
                @endphp

                @if ($categoryId == 6)
                    <div class="col-lg-2 col-md-4 col-sm-6 product_div">
                        <div class="card" style=" box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;"  id="category" data-category="{{ $categoryId }}">
                            <div>

                                <div class="image_card" style="padding: 10px;">

                                    <a href="#" data-category="{{ $categoryId }}">
                                        <img src="{{ asset($categorImage) }}" alt="{{ $categoryName }}" style="width: 100%; border: 0.3px solid rgb(227, 227, 227); background-color: rgba(246, 246, 246, 0.51);">
                                    </a>
                                </div>
                                <div class="product_name" style="text-align: center; font-size: 17px;">
                                    <input type="hidden" readonly value="{{ $categoryId }}">{{ $categoryName }}
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    </div>

    <div class="sec row gender-section" style="margin: unset; padding-bottom: 50px; display: flex;justify-content: center;">
        <div class="gender-section col-lg-12 col-md-12 col-sm-12" style=" text-align: center; margin-top: 1%;">
        </div>

        <div class="col-lg-12 gender-section d-flex justify-content-center row" style=" margin: unset; text-align: center; padding-top: 1%;  padding-right: unset;">

                @foreach ($genders as $gender)
                    @if ($gender->id == 1)
                        <div class="col-lg-2 col-md-4 col-sm-6 product_div">
                            <div class="card" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;" id="gender" data-gender="Men">
                                <div>
                                    <div class="image_card" style="padding: 10px;">
                                        <a href="#" class="gender_card" data-gender="Men">
                                            <img src="{{ asset($gender->gender_image) }}" style="width: 100%;   border: 0.3px solid rgb(227, 227, 227); background-color: rgba(246, 246, 246, 0.51);">
                                        </a>
                                    </div>
                                    <div class="product_name" style="text-align: center; font-size: 17px;">
                                        <input type="hidden" value="Men">Men's
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($gender->id == 2)
                        <div class="col-lg-2 col-md-4 col-sm-6 product_div">
                            <div class="card" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;" id="gender" data-gender="Women">
                                <div>
                                    <div class="image_card" style="padding: 10px;">
                                        <a href="#" class="gender_card" data-gender="Women">
                                            <img src="{{ asset($gender->gender_image) }}" style="width: 100%;  border: 0.3px solid rgb(227, 227, 227); background-color: rgba(246, 246, 246, 0.51);">
                                        </a>
                                    </div>
                                    <div class="product_name" style="text-align: center; font-size: 17px;">
                                        <input type="hidden" value="Women">Women's
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($gender->id == 3)
                        <div class="col-lg-2 col-md-4 col-sm-6 product_div">
                            <div class="card" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;" id="gender" data-gender="All">
                                <div>
                                    <div class="image_card" style="padding: 10px;">
                                        <a href="#" class="gender_card" data-gender="All">
                                            <img src="{{ asset($gender->gender_image) }}" style="width: 100%;  border: 0.3px solid rgb(227, 227, 227); background-color: rgba(246, 246, 246, 0.51);">
                                        </a>
                                    </div>
                                    <div class="product_name" style="text-align: center; font-size: 17px;">
                                        <input type="hidden" value="All">All
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
        </div>


    </div>

    <div class="sec sport-section mb-3" style="  padding-bottom: 50px;">
        <div class="" style="text-align: center; margin-top: 2%;">
        </div>


        <div class="col-lg-12 padding_r_unset padding_l_unset row justify-content-center" style="text-align: center; padding-top: 2%;">

            <div class="col-lg-1"></div>

            <div class="col-lg-10 row justify-content-center">
                @foreach ($sports as $sport)
                    <div class="col-lg-2_4 col-md-4 col-sm-6 product_div sports-container">
                        <div class="card sport_card" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;"  id="sport" data-sport="{{ $sport->id }}">
                            <div>
                                <div class="image_card" style="padding: 10px;">
                                    <a href="#"  id="sport" data-sport="{{ $sport->id }}">
                                        <img src="{{ asset($sport->catalog_image) }}" style="width: 100%; padding-top: 35px;  border: 0.3px solid rgb(227, 227, 227); background-color: rgba(246, 246, 246, 0.51);">
                                    </a>
                                </div>
                                <div class="product_name" style="text-align: center; font-size: 17px;">
                                    {{$sport->sport_name}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-lg-1"></div>
        </div>


    </div>

    <div class="sec style-section" style=" padding-bottom: 50px;">
        <div class="" style="text-align: center; margin-top: 2%;">
        </div>

        <div class="col-lg-12 padding_r_unset padding_l_unset row justify-content-center" style="text-align: center; padding-top: 2%;">

            <div class="col-lg-1"></div>

            <div class="col-lg-10 row justify-content-center">

                <div class="col-lg-2_4 col-md-4 col-sm-6 product_div ">
                    <div class="card sport_card style_card" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;"  id="style" data-style="All">
                        <div class="">
                            <div class="image_card" style="padding: 10px;">
                                <a href="#"  id="style" data-style="All">
                                    <img src="{{ asset('') }}{{ 'assets/Master/category/all.png' }}" style="width: 100%; padding-top: 17px;  border: 0.3px solid rgb(227, 227, 227); background-color: rgba(246, 246, 246, 0.51);">
                                </a>
                            </div>
                            <div class="product_name" style="text-align: center; font-size: 17px;">
                                All
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($productCategories as $productCategory)
                    <div class="col-lg-2_4 col-md-4 col-sm-6 product_div ">
                        <div class="card sport_card style_card" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;"   id="style" data-style="{{ $productCategory->id }}">
                            <div>
                                <div class="image_card" style="padding: 10px;">
                                    <a href="#"   id="style" data-style="{{ $productCategory->id }}">
                                        <img src="{{ asset($productCategory->category_image) }}" style="width: 100%; padding-top: 17px;  border: 0.3px solid rgb(227, 227, 227); background-color: rgba(246, 246, 246, 0.51);">
                                    </a>
                                </div>
                                <div class="product_name" style="text-align: center; font-size: 17px;">
                                    {{$productCategory->product_category_name}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-1"></div>
        </div>
    </div>
</div>


<div class="" style=" z-index:99; padding: unset;">

    @include('pages.customer_product_catlog.layout.footer')

</div>


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

        window.location.href = url;
        return false;
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
    // JavaScript to adjust the layout
    window.addEventListener('load', function () {
        const sportsContainer = document.querySelector('.sports-container');
        const sports = sportsContainer.querySelectorAll('.col-lg-2');

        if (sports.length < 6) {
            const emptyColumns = 6 - sports.length;
            for (let i = 0; i < emptyColumns; i++) {
                const emptyColumn = document.createElement('div');
                emptyColumn.classList.add('col-lg-2');
                emptyColumn.style.visibility = 'hidden';
                sportsContainer.appendChild(emptyColumn);
            }
        }
    });
</script>
<script>
    // JavaScript to adjust the layout
    window.addEventListener('load', function () {
        const sportsContainer = document.querySelector('.style-container');
        const sports = sportsContainer.querySelectorAll('.col-lg-2');

        if (sports.length < 6) {
            const emptyColumns = 6 - sports.length;
            for (let i = 0; i < emptyColumns; i++) {
                const emptyColumn = document.createElement('div');
                emptyColumn.classList.add('col-lg-2');
                emptyColumn.style.visibility = 'hidden';
                sportsContainer.appendChild(emptyColumn);
            }
        }
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

{{-- <script>
    function startTextAnimation() {
        const animatedTextElements = document.querySelectorAll('.animated-text');

        animatedTextElements.forEach((animatedText) => {
            const textContent = animatedText.textContent;
            animatedText.textContent = ''; // Clear the text content
            animatedText.style.color = 'gray'; // Set the initial gray color

            let textIndex = 0;
            const interval = 100; // Adjust the interval (in milliseconds) for animation speed

            function animateText() {
                if (textIndex < textContent.length) {
                    const letter = textContent[textIndex];
                    const span = document.createElement('span');
                    span.textContent = letter;
                    span.style.transition = 'color 0.3s';
                    span.style.color = 'black'; // Change the color of the revealed letter to black
                    animatedText.appendChild(span);
                    textIndex++;
                    setTimeout(animateText, interval);
                }
            }

            animateText();
        });
    }

    document.addEventListener('DOMContentLoaded', startTextAnimation);
</script> --}}


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

            categorySection.style.display = 'none';
            genderSection.style.display = 'flex';

            selectedCategory = link.getAttribute('data-category');

            // function animateGenderText() {
            // const animatedText = document.querySelector('.gender-animated-text');
            // const textContent = animatedText.textContent;
            // animatedText.textContent = '';
            // animatedText.style.color = 'gray';

            // let textIndex = 0;
            // const interval = 100;

            // function animateText() {
            //     if (textIndex < textContent.length) {
            //     const letter = textContent[textIndex];
            //     const span = document.createElement('span');
            //     span.textContent = letter;
            //     span.style.transition = 'color 0.3s';
            //     span.style.color = 'black';
            //     animatedText.appendChild(span);
            //     textIndex++;
            //     setTimeout(animateText, interval);
            //     }
            // }

            // animateText();
            // }

            // animateGenderText();

            console.log('Selected category ID:', selectedCategory);
            doSomethingWithSelectedCategory(selectedCategory);
        });
    });

    function doSomethingWithSelectedCategory(selectedCategory) {
        if (selectedCategory=='5') {
            document.querySelectorAll('.gender_card').forEach((element) => {
                element.addEventListener('click', (event) => {
                    event.preventDefault();

                    // Retrieve data-gender from the clicked element
                    const selectedGender = element.getAttribute('data-gender');

                    console.log('Selected Category:', selectedCategory);
                    console.log('Selected Gender:', selectedGender);
                    console.log('Selected Sport:', selectedSport);
                    console.log('Selected Style:', selectedStyle);

                    const selectedCategoryInput = document.getElementById('selectedCategoryInput');
                    const selectedGenderInput = document.getElementById('selectedGenderInput');
                    const selectedSportInput = document.getElementById('selectedSportInput');
                    const selectedStyleInput = document.getElementById('selectedStyleInput');
                    const filterForm = document.getElementById('filterForm');

                    selectedCategoryInput.value = selectedCategory;
                    selectedGenderInput.value = selectedGender;
                    selectedSportInput.value = 18;
                    selectedStyleInput.value = 0;

                    filterForm.submit();
                });
            });

        }else{
            genderLinks.forEach((link) => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();

                    selectedGender = link.querySelector('input').value;
                    if (selectedCategory==='3' || selectedCategory==='4') {
                        genderSection.style.display = 'none';
                        styleSection.style.display = 'block';
                    }else{
                        genderSection.style.display = 'none';
                        sportSection.style.display = 'block';
                    }


                    // selectedGender = link.getAttribute('data-gender');

                    // function animateGenderText() {
                    // const animatedText = document.querySelector('.sport-animated-text');
                    // const textContent = animatedText.textContent;
                    // animatedText.textContent = '';
                    // animatedText.style.color = 'gray';

                    // let textIndex = 0;
                    // const interval = 100;

                    // function animateText() {
                    //     if (textIndex < textContent.length) {
                    //     const letter = textContent[textIndex];
                    //     const span = document.createElement('span');
                    //     span.textContent = letter;
                    //     span.style.transition = 'color 0.3s';
                    //     span.style.color = 'black';
                    //     animatedText.appendChild(span);
                    //     textIndex++;
                    //     setTimeout(animateText, interval);
                    //     }
                    // }

                    // animateText();
                    // }

                    // animateGenderText();

                    console.log('Selected gender:', selectedGender);


                });
            });
        }
        if(selectedCategory =='3' || selectedCategory =='4'){
            document.querySelectorAll('.style_card').forEach((element) => {
            element.addEventListener('click', (event) => {
                event.preventDefault();

                const selectedStyle = element.getAttribute('data-style');

                console.log('Selected Category:', selectedCategory);
                console.log('Selected Gender:', selectedGender);
                console.log('Selected Sport:', selectedSport);
                console.log('Selected Style:', selectedStyle);

                const selectedCategoryInput = document.getElementById('selectedCategoryInput');
                const selectedGenderInput = document.getElementById('selectedGenderInput');
                const selectedSportInput = document.getElementById('selectedSportInput');
                const selectedStyleInput = document.getElementById('selectedStyleInput');

                selectedCategoryInput.value = selectedCategory;
                selectedGenderInput.value = selectedGender;
                selectedSportInput.value = 18;
                selectedStyleInput.value = selectedStyle;

                const filterForm = document.getElementById('filterForm');
                filterForm.submit();
            });
        });
        }else{

            document.querySelectorAll('.sport_card').forEach((element) => {
                element.addEventListener('click', (event) => {
                    event.preventDefault();

                    const selectedSport = element.getAttribute('data-sport');

                    console.log('Selected Category:', selectedCategory);
                    console.log('Selected Gender:', selectedGender);
                    console.log('Selected Sport:', selectedSport);
                    console.log('Selected Style:', selectedStyle);

                    const selectedCategoryInput = document.getElementById('selectedCategoryInput');
                    const selectedGenderInput = document.getElementById('selectedGenderInput');
                    const selectedSportInput = document.getElementById('selectedSportInput');
                    const selectedStyleInput = document.getElementById('selectedStyleInput');
                    const filterForm = document.getElementById('filterForm');

                    selectedCategoryInput.value = selectedCategory;
                    selectedGenderInput.value = selectedGender;
                    selectedSportInput.value = selectedSport;
                    selectedStyleInput.value = 0;

                    filterForm.submit();
                });
            });
        }




        // sportLinks.forEach((link) => {
        //     link.addEventListener('click', (event) => {
        //         event.preventDefault();

        //         sportSection.style.display = 'none';
        //         styleSection.style.display = 'block';

        //         selectedSport = link.getAttribute('data-sport');

        //         function animateGenderText() {
        //         const animatedText = document.querySelector('.style-animated-text');
        //         const textContent = animatedText.textContent;
        //         animatedText.textContent = '';
        //         animatedText.style.color = 'gray';

        //         let textIndex = 0;
        //         const interval = 100;

        //         function animateText() {
        //             if (textIndex < textContent.length) {
        //             const letter = textContent[textIndex];
        //             const span = document.createElement('span');
        //             span.textContent = letter;
        //             span.style.transition = 'color 0.3s';
        //             span.style.color = 'black';
        //             animatedText.appendChild(span);
        //             textIndex++;
        //             setTimeout(animateText, interval);
        //             }
        //         }

        //         animateText();
        //         }

        //         animateGenderText();

        //         console.log('Selected Sport:', selectedSport);
        //     });
        // });

    }



</script>

@endsection
