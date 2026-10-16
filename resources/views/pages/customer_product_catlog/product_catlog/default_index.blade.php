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

    @keyframes borderHover {
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
</style>

<div class="navbar" style=" background-color:white; z-index:99;">

    @section('page-route')

        <a href="">
            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" alt="image" style="color:black; width: auto !important;" class="image_width_logo">
        </a>

    @endsection

    @include('pages.customer_product_catlog.layout.header')

</div>


<div class="sec category-section" style="padding-top: 100px;">
    <div class="category-section" style="text-align: center; margin-top: 10px;">
        <p class="view_style animated-text" id="animated-text">I want to view</p>
    </div>

    <div class="col-lg-12 category-section row all_apparel" style="text-align: center; padding-left: 20%; padding-right: 16%;">
        @foreach ($main_categories as $main_categorie)
            @php
                $categoryId = $main_categorie->id;
                $categoryName = $main_categorie->category_name;
            @endphp

            @if ($categoryId == 5)
                <div class="col-lg-3 col-md-6 col-sm-12 cat-div mx-auto">
                    <div class="card view_card btn view_text" id="category" data-category="{{ $categoryId }}">
                        <a href="#" class="view_text hover-button-styles text_align_self" id="category" data-category="{{ $categoryId }}">
                            <input type="hidden" readonly value="{{ $categoryId }}">{{ $categoryName }}
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="col-lg-12 row category-section" style="text-align: center; padding-left: 20%; padding-right: 16%;">
            @foreach ($main_categories as $main_categorie)
                @php
                    $categoryId = $main_categorie->id;
                    $categoryName = $main_categorie->category_name;
                @endphp

                @if ($categoryId !== 5 && $categoryId !== 6)
                    <div class="col-lg-3 col-md-6 col-sm-12 cat-div">
                        <div class="card view_card btn view_text" id="category" data-category="{{ $categoryId }}">
                            <a href="#" class="view_text hover-button-styles text_align_self" id="category" data-category="{{ $categoryId }}">
                                <input type="hidden" readonly value="{{ $categoryId }}">{{ $categoryName }}
                            </a>
                        </div>
                    </div>
                @endif

                @if ($categoryId == 6)
                    <div class="col-lg-3 col-md-6 col-sm-12 cat-div">
                        <div class="card view_card btn view_text" id="category" data-category="{{ $categoryId }}">
                            <a href="#" class="view_text hover-button-styles text_align_self" id="category" data-category="{{ $categoryId }}">
                                <input type="hidden" readonly value="{{ $categoryId }}">{{ $categoryName }}
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach

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

@include('pages.customer_product_catlog.layout.footer')


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

<script>
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

            categorySection.style.display = 'none';
            genderSection.style.display = 'flex';

            selectedCategory = link.getAttribute('data-category');

            function animateGenderText() {
            const animatedText = document.querySelector('.gender-animated-text');
            const textContent = animatedText.textContent;
            animatedText.textContent = '';
            animatedText.style.color = 'gray';

            let textIndex = 0;
            const interval = 100;

            function animateText() {
                if (textIndex < textContent.length) {
                const letter = textContent[textIndex];
                const span = document.createElement('span');
                span.textContent = letter;
                span.style.transition = 'color 0.3s';
                span.style.color = 'black';
                animatedText.appendChild(span);
                textIndex++;
                setTimeout(animateText, interval);
                }
            }

            animateText();
            }

            animateGenderText();

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
                    if (selectedCategory==='3' || selectedCategory==='4' || selectedCategory==='6') {
                        genderSection.style.display = 'none';
                        styleSection.style.display = 'block';
                    }else{
                        genderSection.style.display = 'none';
                        sportSection.style.display = 'block';
                    }


                    // selectedGender = link.getAttribute('data-gender');

                    function animateGenderText() {
                    const animatedText = document.querySelector('.sport-animated-text');
                    const textContent = animatedText.textContent;
                    animatedText.textContent = '';
                    animatedText.style.color = 'gray';

                    let textIndex = 0;
                    const interval = 100;

                    function animateText() {
                        if (textIndex < textContent.length) {
                        const letter = textContent[textIndex];
                        const span = document.createElement('span');
                        span.textContent = letter;
                        span.style.transition = 'color 0.3s';
                        span.style.color = 'black';
                        animatedText.appendChild(span);
                        textIndex++;
                        setTimeout(animateText, interval);
                        }
                    }

                    animateText();
                    }

                    animateGenderText();

                    console.log('Selected gender:', selectedGender);


                });
            });
        }
        if(selectedCategory =='3' || selectedCategory =='4' || selectedCategory==='6'){
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
