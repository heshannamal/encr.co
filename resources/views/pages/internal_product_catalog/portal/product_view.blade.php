@extends('layouts.app', ['activePage' => 'product_catalog', 'titlePage' => __('Product Catalog')])

@section('content')
{{-- @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection --}}
@section('back-btn')
        <a href="{{ route('admin_product_catlog') }}" class="home-btn-color" title="Back to home"><i class="fa fa-arrow-left" aria-hidden="true" style="margin: 10px;"></i> BACK</a>
@endsection
<style>

    .filterbtn:hover {
        box-shadow: 0 6px 6px rgba(0, 0, 0, 0.2);
    }
    .filterbtn{
        box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.1);
        border-radius: .3rem;
        font-size: 11px;
        width: 127%;
        height: 120%;
        font-weight: 700;
        }
    .custom-control-input:checked ~ .custom-control-label::before {
            background-color: red !important;
            border-color: red !important;
        }
        .card {
    border: none;
    box-shadow: none;
    width: 107%;
    }

    .card-img-top {
    border-radius: 0;
    }

    .card-body {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    }

    .heart-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    color: rgb(255, 0, 0);
    z-index: 1;
    background-color: transparent;
    border: none;
    cursor: pointer;
    }
    .card-title{
        width: 100%;
        font-size: 17px;
        font-weight:500;
        color: black;
        position: relative;
        left: -5%;
    }

    /* crousal thumbnail */
    .thumbnail {
    width: 80px;
    height: 80px;
    border-radius: unset;
    background: none;
    border: 1px solid transparent;
    }

    .thumbnail.active {
    width: 90px !important;
    height: 90px !important;
    position: relative !important;
    top: -5px !important;
    }


    /* clicked images */
    .image-container {
    position: relative;
    }

    .image-container input[type="radio"] {
    display: none;
    }

    .image-container img {
    cursor: pointer;
    }

    .image-container input[type="radio"]:checked + label {
    border: 3px solid black;
    }
    .number-input {
    display: flex;
    align-items: center;
    }

    input[type="number"] {
    height: 40px;
    text-align: center;
    width: 40%;
    margin-left: 5%;
    margin-right: 5%;
    outline: unset;
    border: none;
    }

    .circle-button {
    width: 30px;
    height: 30px;
    background-color: transparent;
    color: black;
    font-weight: bold;
    cursor: pointer;
    outline: unset;
    border: none;
    }
    .main-content{
        background-color: #F8F8F8;
    }
    .thumbnail-container {
    position: relative;
    display: inline-block;
    }
    .imageList:hover{
        opacity: 30%;
    }
    @media only screen and (min-width: 320px) and (max-width: 421px )
    {
        .hide-icon{
            display: none;
        }
        .image_width{
            width: -webkit-fill-available;
        }
        .breadcumbs-width{
            width:90%;
            font-size:9px;
        }
        .image-position{
            position: relative !important;
        }
        .image-position-small{
            display: none;
            position: absolute !important;
            top: 542px;
            z-index:unset !important;
        }
        .container_style {
            margin-left: unset !important;
            margin-right: unset !important;

        }
        .thumbmail-style{
            flex-direction:row !important;
        }
        .product-details{
            margin-left: unset !important;
            top: 30px;

        }
        .width-unset{
            width:unset !important;
        }
        .favourite-btn{
            padding-left: 25%;
            padding-right: 25%;
            margin-left:unset !important;
        }
        .product-discriptiopn-title{
            width: 70% !important;
            font-size: 18px !important;
        }
        .container_style {
            /* min-height: 210vh !important; */
            padding-top: 240px !important;
        }
    }
    @media only screen and (min-width: 420px) and (max-width: 991px )
    {
        .product-details{
            margin-left: unset !important;
            /* top: 79vh; */
        }
        .container_style {
            /* min-height: 210vh !important; */
        }
        .image-position {
            /* width: 85%; */
            /* max-width: 76vh; */
            /* margin-left: 100px !important; */
        }
        .container_style {
            padding-top: 240px !important;
        }
    }
    .card {
    border: none;
    box-shadow: none;
    width: 100%;
    }

    .card-img-top {
    border-radius: 0;
    }

    .card-body {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    }

    .heart-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    color: rgb(255, 0, 0);
    z-index: 1;
    background-color: transparent;
    border: none;
    cursor: pointer;
    }
    .card-title{
        width: 100%;
        font-size: 17px;
        font-weight:500;
        color: black;
        position: relative;
        left: -5%;
    }

    /* crousal thumbnail */
    .thumbnail {
    width: 80px;
    height: 80px;
    border-radius: unset;
    background: none;
    border: 1px solid transparent;
    }

    .thumbnail.active {
    width: 90px !important;
    height: 90px !important;
    position: relative !important;
    top: -5px !important;
    }


    /* clicked images */
    .image-container {
    position: relative;
    }

    .image-container input[type="radio"] {
    display: none;
    }

    .image-container img {
    cursor: pointer;
    }

    .image-container input[type="radio"]:checked + label {
    border: 3px solid black;
    }
    .container_style {
        /* max-width: 93%;
        margin-left: 50px;
        margin-right: 50px; */
        /* margin-top: 100px; */
    }
    .enquary_attribute_icon {
        padding-left: 10px;
        padding-right: 10px;
    }
    .enquary_attribute {
        /* margin-left: 26px;
        padding-left: 32px; */
        padding-top: 23px;
        /* margin-right: 26px;
        padding-right: 32px; */
    }
    .search_div {
        height: 40px;
        /* box-shadow: 10px 10px 30px 0px rgba(0, 0, 0, 0.05); */
    }
    .search_icon {
        padding-top: 6px;
        /* padding-left: 7px; */
        text-align: center;
    }
    .card_position {
        position: relative;
        padding-top: 7px;
        /* padding-left: 30px; */
    }
    .customizable_product {
        color: #167A92;
        font-size: 12px;
        height: 27px;
        width: 284px;
        text-align: left;
        font-weight: 500;
        margin-bottom: 0.2rem;
    }
    .reversible_product {
        color: #1DB276;;
        font-size: 12px;
        height: 27px;
        width: fit-content;
        text-align: left;
        font-weight: 500;
        margin-bottom: 0.2rem;
        padding: .5rem .8rem;
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
    .search_box_visible {
        display: none;
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
        width: 91%;
        /* width: 155%; */
        /* left: -60%; */
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
        margin-right: 5px;
        padding-right: 25px;
    }
    body {
        background-color: white !important;
    }
    .hr_margin {
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
    .checkbox-cards {
        display: flex;
        flex-wrap: wrap;
        padding-bottom: 15px;
    }

    .checkbox-cards input[type="checkbox"] {
        display: none; /* Hide the actual checkboxes */
    }

    .checkbox-cards label {
        position: relative;
        width: 80px; /* Adjust the width as needed */
        height: 80px; /* Adjust the height as needed */
        background-color: #ededed;
        margin: 5px;
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 5px;
    }

    .checkbox-cards img {
        display: block;
        margin: 0 auto; /* Center the image */
        max-width: 72%;
        max-height: 100%;
        border-radius: 5px;
    }

    .checkbox-cards input[type="checkbox"]:checked + label {
        border-color: #7d7d7d;
        border: 1px solid gray;
    }
    .size-cards {
        display: flex;
        flex-wrap: wrap;
        padding-bottom: 15px;
    }

    .size-cards input[type="checkbox"] {
        display: none; /* Hide the actual checkboxes */
    }

    .size-cards label {
        position: relative;
        width: 55px; /* Adjust the width as needed */
        height: 55px; /* Adjust the height as needed */
        background-color: #ffffff;
        margin: 5px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 11px;
        text-align: center;
        display: flex;
        align-items: center;
    }

    .size-cards input[type="checkbox"]:checked + label {
        border-color: #7d7d7d;
        border: 1px solid gray;
    }

    .enquiry_tab {
        font-size: 14px;
        color: white;
        margin-bottom: 0.8rem;
        margin-top: 0.8rem;
    }
    .enquiry_box {
        background-color:#47D6B6;
        width: 40%;
        border-radius: 5px;
        height: 35px;
        padding-top: 7px;
    }
    .size_visible{
        display: none;
    }
    .description_visible, .made_visible, .features_visible{
        display: none;
    }
    .fabric_visible{
        display: none;
    }
    .fabric_visible{
        display: none;
    }
    .fit_visible{
        display: none;
    }
    .attribute_visible{
        display: none;
    }
    .embellishment_visible{
        display: none;
    }
    .file_download_visible{
        display: none;
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
    .sub-header-style{
        font-size: 1rem;
        color: rgb(55, 55, 55) !important;
    }
    .description_topic {
        border: 1px solid rgb(227, 227, 227);
        margin: unset;
        border-radius: 10px;
        margin-bottom: 5px;
    }
    .size_topic {
        border: 1px solid rgb(227, 227, 227);
        margin: unset;
        border-radius: 10px;
    }
    .head_p {
    color: rgb(55, 55, 55) !important;
    font-weight: 600;
    font-size: 24px;
    text-align: right;
    margin-top: 1rem;
    }

    @media only screen and (min-width: 320px) and (max-width: 991px )
    {

    }
    @media only screen and (min-width: 428px) and (max-width: 587px )
    {
        .image-position-small{
            display: none;
        }
    }

    .container_style {
        /* padding-top: 90px; */
        margin-left: 29px;
        margin-right: 37px;
    }
    .filter_text {
        margin-bottom: unset;
        font-size: 15px;
        border-radius: 5px;
        color: black;
        height: 22px;
        /* font-weight: 100; */
    }
    .category_row {
        margin: unset !important;
        padding-top: 20px !important;
    }
    .custom-select-box {
        width: 120px;
        padding: 3px;
        /* font-size: 16px; */
        border: unset;
        border-radius: 5px;
        background-color: #f7f7f7;
        color: #a3a3a3;
        height: 24px;
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
    .filter_div_space {
        padding-left: 30px;
    }
    .filter_selecte {
        padding-bottom: 17px;
        border-bottom: rgb(235, 232, 232) solid 1px;
    }
    .customizable_product_background {
        background-color: rgba(17, 186, 226, 0.16);
        text-align: center;
        border-radius: 20px;
        padding-top: 4px;
        cursor: pointer;
    }
    .reversible_product_background {
        background-color: #00ff993c;
        text-align: center;
        border-radius: 20px;
        padding-top: 4px;
        cursor: pointer;
    }
    .details_div_style {
        padding-top: 13px;
        margin: unset;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-left: 5px;
    }
    .details_div_style2 {
        padding-top: 13px;
        margin: unset;
        display: flex;
        align-items: center;
    }
    .color_cercle {
        height: 30px;
        width: 30px;
        border-radius: 20px;
        margin-right: 16px;
    }
    .color_cercle:hover {
        border: 1px solid gray;
    }
    .fit_sections {
        font-size: 12px;
        color: rgb(172, 172, 172);
        padding: 5px;
        padding-top: 2px;
        border: 1px solid rgb(233, 233, 233);
        border-radius: 5px;
        padding-bottom: unset;
        margin-right: 10px;
        cursor: default;
    }
    .fit_sections:hover {
        border: 1px solid rgb(169, 169, 169);
    }
    .fit_sections.active {
        border: 1px solid rgb(124, 124, 124);
    }
    .size_tag {
        font-size: 12px;
        color: white;
        padding: 5px;
        background-color: gray;
        border-radius: 13px;
        padding-left: 7px;
        padding-right: 7px;
    }
    .size_tag:hover {
        font-size: 12px;
        color: white;
        padding: 5px;
        background-color: rgb(43, 43, 43);
        border-radius: 13px;
        padding-left: 7px;
        padding-right: 7px;
        text-decoration: underline;
    }
    .sizing_link:hover {
        text-decoration: underline;
    }
    .description_content p span, .made_content p span, .features_content p span {
        font-size: 12px;
        color: gray !important;
    }
    .description_content ul li, .made_content ul li, .features_content ul li {
        font-size: 12px;
        color: gray !important;
    }
    .description_content p, .made_content p, .features_content p {
        font-size: 12px;
        color: gray !important;
    }
    .description_content p strong, .made_content p strong, .features_content p strong {
        font-size: 14px;
    }
    .fit_content p span {
        font-size: 12px;
        color: gray !important;
    }
    .fit_content p {
        font-size: 12px;
        color: gray !important;
    }
    .fit_content p strong {
        font-size: 14px;
    }
    .fabric_content p span {
        font-size: 12px;
        color: gray !important;
    }
    .fabric_content p {
        font-size: 12px;
        color: gray !important;
    }
    .fabric_content p strong {
        font-size: 14px;
    }
    .close_btn_style {
        font-size: 20px;
        font-weight: 600;
        padding-bottom: 0px;
        background-color: transparent;
        border: unset;
        border-radius: 5px;
        padding-left: 8px;
        padding-right: 8px;
        cursor: pointer;
        color: white;
    }
    .cursor_pointer {
        cursor: pointer;
    }
    .display_hide {
        display: none !important;
    }
    .image_modal_css {
        background-color: #000000e3;
    }
    .next_button {
        background-color: transparent;
        border: unset;
        box-shadow: unset;
        font-size: 20px;
    }
    .next_button:hover {
        background-color: transparent;
        border: unset;
        box-shadow: unset;
    }
    .image-section img {
        /* width: 100%; */
        /* max-width: 50rem; */
        object-fit: contain;
    }

    .text-section {
        max-width: 400px;
    }

    @media (max-width: 768px) {
        /* For small screens, stack text below the image */
        .container-fluid {
            flex-direction: column;
        }

        .text-section {
            margin-top: 1rem;
        }
    }
    .info_icon {
        color: rgb(176, 176, 176);
    }
    .group_topic {
        padding-left: 10px;
        background-color: rgb(244, 244, 244);
    }
    .horizontal-line-container {
        position: relative;
        width: 100%;
        height: 30px; /* Increase height to give space for labels */
    }

    .horizontal-line {
        position: relative;
        width: 100%;
        height: 2px;
        background-color: rgb(235, 232, 232);
        display: flex;
        justify-content: space-between;
        margin-top: 10px; /* Adjust to add spacing above the line */
    }

    .horizontal-line::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: rgb(80, 80, 80);
    }

    .vertical-line {
        position: absolute;
        top: -4px;
        width: 2px;
        height: 10px;
        background-color: rgb(80, 80, 80);
    }

    /* Positioning for labels */
    .label-left, .label-right {
        position: absolute;
        font-size: 12px;
        color: rgb(80, 80, 80);
        top: 20px; /* Position labels below the line */
    }

    .label-left {
        left: 0;
    }

    .label-right {
        right: 0;
    }

    .label-center {
        position: absolute;
        font-size: 12px;
        color: rgb(80, 80, 80);
        top: 20px; /* Position True to Size below the line */
        transform: translateX(-50%);
    }

    .main-image-container {
        position: relative;
        overflow: hidden;
    }

    .small-images-row {
        position: absolute;
        bottom: 10px;
        right: 10px;
        display: flex;
        gap: 5px;
    }

    .small-img {
        width: 50px;
        height: 50px;
        border-radius: 5px;
        object-fit: cover;
        cursor: pointer;
    }
    .small_img_background {
        padding: 5px;
        background-color: rgba(130, 130, 130, 0.41);
        border-radius: 4px;
    }
    ..page-item.active {
        z-index: 1000;
    }

</style>

{{-- <div class="row ml-4 mr-4" style="margin-top: 4%;border-bottom: 3px solid #ededed; margin:2%">
    <div class="col-lg-6" style="margin-bottom: .5%;">
        <a href="{{route('admin_product_catlog')}}">
            <button style="font-size: 14px;font-weight: 700;background: none; outline:unset; border:none;cursor:pointer"><i class="fa fa-arrow-left" aria-hidden="true" style="margin: 10px;"></i>BACK TO PRODUCT CATALOG</button>

        </a>
    </div>
</div> --}}
{{-- <div class="col-lg-2 ml-auto mr-4">
    <a href="{{route('quotation')}}">
    <button class="filterbtn" type="button" id="filterButton_call" style="height: 50px; width: 100%; font-size: 15px; background-color: red; border: none; color: white; cursor: pointer; border-radius:.3rem">
        VIEW QUOTATION
    </button>
</a>
</div> --}}
@php
// default images
$imageUrl='assets/img/products/product defaul image.jpg';
@endphp
{{-- <div class="row" style="margin-top: 2%; margin-bottom: 2%">
    <div class="col-lg-5 ml-6">

        <div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="{{ $product->mockup_img_1 ? asset('assets').$product->mockup_img_1 : asset($imageUrl)}}" class="d-block w-100" alt="Image 1">
              </div>
              @if ($product->mockup_img_2)
                <div class="carousel-item">
                    <img src="{{ asset('assets') }}{{ $product->mockup_img_2 }}" class="d-block w-100" alt="Image 2">
                </div>
              @endif
              @if ($product->mockup_img_3)
                <div class="carousel-item">
                    <img src="{{ asset('assets') }}{{ $product->mockup_img_3 }}" class="d-block w-100" alt="Image 3">
                </div>
              @endif
            </div>
            <div class="carousel-thumbnails d-flex justify-content-center mt-2">
                <img src="{{ $product->mockup_img_1 ? asset('assets').$product->mockup_img_1 : asset($imageUrl) }}" class="img-thumbnail mx-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="0" alt="Thumbnail 1" onclick="goToSlide(0)">
                @if ($product->mockup_img_2)
                    <img src="{{ asset('assets') }}{{ $product->mockup_img_2 }}" class="img-thumbnail mx-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="1" alt="Thumbnail 2" onclick="goToSlide(1)">
                @endif

                @if ($product->mockup_img_3)
                    <img src="{{ asset('assets') }}{{ $product->mockup_img_3 }}" class="img-thumbnail mx-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="2" alt="Thumbnail 3" onclick="goToSlide(2)">
                @endif

              </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" style="background-color: transparent;border: none;">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" style="background-color: transparent;border: none;">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>

              <span class="visually-hidden"></span>
            </button>
        </div>

          <script>
            function goToSlide(slideIndex) {
              var carousel = document.getElementById("carouselExample");
              var carouselInstance = bootstrap.Carousel.getInstance(carousel);
              carouselInstance.to(slideIndex);
            }
          </script>
    </div>
    <div class="col-lg-6">
        <div class="row" style="margin-left: 1%">
            <p style="color: black;font-size: 25px;font-weight: 600;">PRO-{{$product->id}}&nbsp;&nbsp;</p><p style="color: grey;font-size: 24px;">{{$product->product_name}}</p>
        </div>
        <div class="row" style="margin-left: 1%">
            <p style="color: black;font-size: 24px;font-weight: 400;">${{$product->default_price}}</p>
        </div>
        <div class="col-lg-12 ml-2">
            <div class="row"><p  style="font-size: 16px; color: black; font-weight: 700;">DESCRIPTION</p></div>
            <div>{!! $product->description !!}</div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-left: 2%;"><p style="font-size: 16px; color: black; font-weight: 700;">AVAILABLE SIZES :</p></div>
        </div>
        <div class="row ml-3">
            @php
                $sizetypeid = $product->size_id;
                $sizeNames = $size->where('size_type', $sizetypeid)->pluck('size_name')->toArray();
            @endphp

        @foreach($sizeNames as $sizeName)
        @if($sizeName !== 'Extra Size One' && $sizeName !== 'Extra Size Two' && $sizeName !== 'Extra Size Three')
            <div style="border-left: 2px solid black; text-align: center; margin-top: 10px;">
                <span style="font-size: 15px; color: black; font-weight: 500; margin: 10px;">{{ $sizeName }}</span>
            </div>
        @endif
        @endforeach

        </div>

        <div class="row ml-3 mt-4">
            <i class="fa fa-bar-chart" style="margin-right: 7px;font-size: 14px;color: rgb(84, 186, 231);"></i>
            <p style="color: rgb(84, 186, 231);font-size: 13px;font-weight: 600;">SIZE GUIDE</p>
        </div>

        <div class="row">
            <div class="col-lg-12" style="margin-left: 2%; padding-top: 15px;"><p style="font-size: 16px; color: black; font-weight: 700;">AVAILABLE FABRICS :</p></div>
        </div>

        <div class="row ml-3" style="padding-bottom: 15px;">
            @php
                $displayedFabrics = [];
            @endphp

            @foreach ($subProducts as $subProduct)
                @if (!in_array($subProduct->standard_fabric, $displayedFabrics))
                    <div style="border-left: 2px solid black; text-align: center; margin-top: 10px;">
                        <span style="font-size: 15px; color: black; font-weight: 500; margin: 10px;">{{ $subProduct->standard_fabric }}</span>
                    </div>
                    @php
                        $displayedFabrics[] = $subProduct->standard_fabric;
                    @endphp
                @endif
            @endforeach

        </div>

        <div class="row">
            <div class="col-lg-12" style="margin-left: 2%; padding-top: 15px;"><p style="font-size: 16px; color: black; font-weight: 700;">AVAILABLE EMBELLISHMENT :</p></div>
        </div>

        <div class="row ml-3" style="padding-bottom: 15px;">
            @foreach ($uniqueEmbellishments as $embellishment)
                <div style="border-left: 2px solid black; text-align: center; margin-top: 10px;">
                    <span style="font-size: 15px; color: black; font-weight: 500; margin: 10px;">{{ $embellishment }}</span>
                </div>
            @endforeach
        </div>


        @can('view design files')
            <div class="row mb-3">
                <div class="col-lg-12">
                    <h4 style="margin-left: 1%; margin-top:2%; font-weight: 700;">DESIGN RELATED FILES</h4>
                </div>
                <table class="ml-4 mt-4" style="background-color: white;width: 80%;">
                    <tr style="background-color: grey; height: 40px;font-size:14px;">
                        <th style="color:white;">&nbsp;&nbsp;FILE NAME</th>
                        <th style="text-align: center; color:white;">ACTION</th>
                    </tr>
                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                        <td style="color: black;">&nbsp;&nbsp;2D Mockup Template</td>
                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['2D_mockup'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                    </tr>
                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                        <td style="color: black">&nbsp;&nbsp;3D Mockup Template</td>
                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['3D_mockup'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                    </tr>
                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                        <td style="color: black">&nbsp;&nbsp;Design Tech Pack</td>
                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['tech_pack'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                    </tr>
                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                        <td style="color: black">&nbsp;&nbsp;Technical Tech Pack</td>
                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['technical_tech_pack'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                    </tr>
                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                        <td style="color: black">&nbsp;&nbsp;Measurement Chart</td>
                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['measurement'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                    </tr>
                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                        <td style="color: black">&nbsp;&nbsp;Production Layout</td>
                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['product_layout'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                    </tr>
                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                        <td style="color: black">&nbsp;&nbsp;Pattern File</td>
                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['pattern'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                    </tr>
                </table>
            </div>
        @endcan
    </div>
</div>


@if($product->mockup_img_1 || $product->mockup_img_1 || $product->mockup_img_1)
<div class="row" style="margin-left: 2%">
    <div class="col-lg-12">
        <h3>2D IMAGES</h3>
    </div>
    <div class="carousel-thumbnails d-flex justify-content-center mt-2" style="margin-bottom: 5%">
        <div class="thumbnail-container" style="position: relative; cursor:pointer" onclick="viewImage('{{asset('assets').$product->mockup_img_1}}')">
            <img src="{{ $product->mockup_img_1 ? asset('assets').$product->mockup_img_1 : asset($imageUrl) }}" class="img-thumbnail mx-2 thumbnail imageList" data-bs-target="#carouselExample" alt="Thumbnail 1">
            <i class="fa fa-expand" aria-hidden="true" style="position: absolute; top: 10px; right: 15px;color:white;"></i>

        </div>
        <div class="thumbnail-container" style="position: relative; cursor:pointer" onclick="viewImage('{{asset('assets').$product->mockup_img_2}}')">
            <img src="{{ $product->mockup_img_2 ? asset('assets').$product->mockup_img_2 : asset($imageUrl) }}" class="img-thumbnail mx-2 thumbnail imageList" data-bs-target="#carouselExample" alt="Thumbnail 1">
            <i class="fa fa-expand" aria-hidden="true" style="position: absolute; top: 10px; right: 15px;color:white;"></i>

        </div>
        <div class="thumbnail-container" style="position: relative; cursor:pointer" onclick="viewImage('{{asset('assets').$product->mockup_img_3}}')">
            <img src="{{ $product->mockup_img_3 ? asset('assets').$product->mockup_img_3 : asset($imageUrl) }}" class="img-thumbnail mx-2 thumbnail imageList" data-bs-target="#carouselExample" alt="Thumbnail 1">
            <i class="fa fa-expand" aria-hidden="true" style="position: absolute; top: 10px; right: 15px;color:white;"></i>

        </div>

    </div>

</div>
@endif
@if (count($lifestyleImages) > 0 )
    <div class="row" style="margin-left: 2%">
        <div class="col-lg-12">
            <h3>LIFE STYLE IMAGES</h3>
        </div>

        <div class="carousel-thumbnails d-flex justify-content-center mt-2" style="margin-bottom: 5%">
                @foreach ($lifestyleImages as $index => $lifestyleImage)
                <div class="thumbnail-container" style="position: relative; cursor:pointer" onclick="viewImageBlank('{{$lifestyleImage}}')">
                    <img src="{{ $lifestyleImage }}" onerror="this.src='{{ asset($imageUrl) }}';" class="img-thumbnail mx-2 thumbnail imageList" data-bs-target="#carouselExample" alt="Thumbnail {{$index+1}}">
                    <i class="fa fa-expand" aria-hidden="true" style="position: absolute; top: 10px; right: 15px;color:white"></i>
                </div>
                @endforeach
            </div>
    </div>

 @endif
 @if (count($Images3D) > 0 )
<div class="row" style="margin-left: 2%">
    <div class="col-lg-12">
        <h3>3D IMAGES</h3>
    </div>

    <div class="carousel-thumbnails d-flex justify-content-center mt-2" style="margin-bottom: 5%">
            @foreach ($Images3D as $index => $Image3D)
            <div class="thumbnail-container" style="position: relative; cursor:pointer" onclick="viewImageBlank('{{$Image3D}}')">
                <img src="{{ $Image3D }}" onerror="this.src='{{ asset($imageUrl) }}';" class="img-thumbnail mx-2 thumbnail imageList" data-bs-target="#carouselExample" alt="Thumbnail {{$index+1}}">
                <i class="fa fa-expand" aria-hidden="true" style="position: absolute; top: 10px; right: 15px;color:white"></i>
            </div>
            @endforeach
        </div>

    </div>
@endif --}}

{{-- Modal --}}

{{-- <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="background: transparent; border: none; position: relative;">
            <div class="position-absolute" style="top: 15px; right: 15px; z-index: 1050;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" id="modalImage" class="img-fluid" alt="Image">
            </div>
        </div>
    </div>
</div>

<div id="user-info" style="display:none;" data-user-id="{{ auth()->user()->id }}"></div>
<input type="hidden" id="productId" value="{{ $product->id }}"> --}}
{{-- <script>
    function viewImage(link) {
        var img = new Image();
        img.src = link;
        img.onload = function() {
            var modalImage = document.getElementById('modalImage');
            modalImage.src = img.src;
        };
        $('#imageModal').modal('show');
    }
    function viewImageBlank(link){
        window.open(link, '_blank');
    }
    function downloadFile(linkReceived) {
        var linkReceived = linkReceived;

        console.log(linkReceived);

        window.open(linkReceived);
    }

    // Close modal when the close button is clicked
    $(document).on('click', '.modal .close', function() {
        $('#imageModal').modal('hide');
    });
</script>

    <script>
        $(document).ready(function() {
            // Click event for the cart icon
            $('#cartDropdown').click(function(e) {
                e.preventDefault();

                // Toggle the dropdown menu
                $(this).next('.dropdown-menu').toggleClass('show');
            });
        });

    </script>


    <script>
        buttontext();
        function buttontext() {

            findQuotesCount();

            var userId = {{ Session::get('loggedInUser') }};

            var productId = $('#productId').val();
            // console.log(userId);
            //console.log(productId);

            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('buttontext') }}",
            method: "GET",
            data: {
                user_id: userId,
                product_id: productId,
                    },
            success: function(response) {

                var button = document.getElementById('Quotebtn_call');

                if(response.message_exist){
                    //console.log(response.message_exist);
                    button.innerText = 'REMOVE FROM QUOTE';
                }else{
                    button.innerText = 'ADD TO QUOTE';
                };

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
        }

        function toggleQuote(productId) {
            var button = document.getElementById('Quotebtn_call');

            if (button.innerText === 'ADD TO QUOTE') {

                addToQuote(productId); // Call your add to quote function

            }
            if(button.innerText === 'REMOVE FROM QUOTE') {

                removeFromQuote(productId); // Call your remove from quote function
            }
        }

        function addToQuote(productId) {

            var userId = {{ Session::get('loggedInUser') }};
            const quantityInput = document.getElementById('quantity');
            const qty = quantityInput.value;
            //console.log(userId);
            //console.log(productId);

            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('product_addto_quotes') }}",
            method: "GET",
            data: {
                user_id: userId,
                product_id: productId,

                qty: qty,

                    },
            success: function(response) {

                var button = document.getElementById('Quotebtn_call');

                if(response.message_success){
                    console.log(response.message_success);
                    button.innerText = 'REMOVE FROM QUOTE';
                };
                if(response.message_exist){
                    console.log(response.message_exist);
                };
                findQuotesCount();
                view_user_quotes();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
        }

        function removeFromQuote(productId) {


            var userId = {{ Session::get('loggedInUser') }};

            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('product_removefrom_quotes') }}",
            method: "GET",
            data: {
                user_id: userId,
                product_id: productId,
                    },
            success: function(response) {

                var button = document.getElementById('Quotebtn_call');

                findQuotesCount();
                view_user_quotes();

                if(response.message_notfound){
                    console.log(response.message_notfound);
                };

                if(response.message_remove){
                    console.log(response.message_remove);
                    button.innerText = 'ADD TO QUOTE';
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
        }


        find_quote();

        function find_quote() {
            var userId = {{ Session::get('loggedInUser') }};
            var product_id = $('#productId').val();
            //console.log(userId);
            //console.log(productId);

            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('find_quote') }}",
            method: "GET",
            data: {
                user_id: userId,
                product_id: productId,
                    },
            success: function(response) {

                var button = document.getElementById('Quotebtn_call');

                if(response.status == 200){
                    button.innerText = 'ADD TO QUOTE';
                };
                if(response.status == 200){
                    button.innerText = 'REMOVE FROM QUOTE';
                };

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
        }


        //view_user_quotes();

        function view_user_quotes() {


            var userId = {{ Session::get('loggedInUser') }};

            var subtotal=0;

            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('view_user_quotes') }}",
            method: "GET",
            data: {
                user_id: userId,
                    },
            success: function(response) {

                //console.log(response.quotes)

                //console.log(response.products)

                var item = response.products;

                var cartItemsHtml = '';

            // Iterate over each cart item and generate the HTML
            item.forEach(function(item) {

                var imageURL = "{{asset('assets/img/products/product defaul image.jpg')}}";

                //console.log(imageURL);

                if (item.mockup_img_1) {
                imageURL = item.mockup_img_1;
                //console.log(imageURL);
                }

                subtotal = parseInt(subtotal) + parseInt(item.default_price);
                //console.log(subtotal);

                cartItemsHtml += '<div class="row">' +
                '<div class="col-lg-3">' +
                '<img src="' + imageURL+ '" alt="Item Image" style="height: 80px; width: 80px;margin: 15%;">' +
                '</div>' +
                '<div class="col-lg-7" style="margin-top: 3%">' +
                '<span style="color: grey;font-size: 16px;display: table-row;">' + item.product_name + '</span>' +
                '<span style="color: black;padding: 1%;font-size: 15px;">$ ' + item.default_price + '</span>' +
                '</div>' +
                '<div class="col-lg-2">' +
                '<button style="background: none;border: none;outline: unset;cursor: pointer;position: relative;top: 8%;"><i class="fa fa-trash" aria-hidden="true" style="color: black;" onclick="removeFromQuote('+item.id+')"></i></button>' +
                '</div>' +
                '</div>' +
                '<div class="dropdown-divider"></div>';
            });



            $('#totalvalue').text(subtotal+'.00');

            // Update the HTML of the cart items section
            $('#dropdown-menu-content').html(cartItemsHtml);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
        }

        function findQuotesCount() {


        var userId = {{ Session::get('loggedInUser') }};

        // Send an AJAX request to the server
        $.ajax({
        url: "{{ route('count_records') }}",
        method: "GET",
        data: {
            user_id: userId,
                },
        success: function(response) {

            var count = response.count;
            //console.log(count);
            $('#quoteCountBadge').text(count);

            var generateQuoteCount = document.querySelector("#generateQotecount");

            //console.log(generateQuoteCount);

            generateQuoteCount.textContent = count;

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error:", textStatus, errorThrown);
        }
        });
        }
    </script>

    <script>
        $(document).ready(function() {
        $('.image-container input').click(function() {
            // Remove the border from all images
            $('.image-container label').css('border', 'none');

            // Add the border to the selected image
            $(this).siblings('label').css('border', '3px solid black');

            // Update the text based on the selected image
            var imageId = $(this).attr('id');
            if (imageId === 'image1') {
            $('#imageText').text('3D Image');
            } else if (imageId === 'image2') {
            $('#imageText').text('Lifestyle');
            }
        });
        });
    </script>
    <script>
        function goToSlide(slideIndex) {
        $('.thumbnail').removeClass('active');
        $('.thumbnail').eq(slideIndex).addClass('active');
        $('#carouselExample').carousel(slideIndex);
        }

    </script>
    <script>
                var headerSpan = document.getElementById('header');
                headerSpan.textContent = 'PRODUCT CATALOG';
            </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
 --}}


 @php
 // default images
 $imageUrl='assets/img/products/product defaul image.jpg';
@endphp

<div class="container_style" style="padding-bottom: 30px;">


 <div class="col-lg-12" style="padding: unset; ">
     <div class="row" style="margin: unset;">
         <div class="{{ !isset($images_3d[0]) ? 'col-lg-5' : 'col-lg-7' }}"
             style="padding: unset; padding-left: 5px;">

             <div class="row" style="margin: unset;">
                 <div class="{{ !isset($images_3d[0]) ? 'col-lg-12' : 'col-lg-6' }}" style="padding: 7px;">
                     <div class="card main-image-container" style="border-radius: unset; background-color: rgb(241, 241, 241); position: relative;">

                         <img id="mainImage" src="{{ asset('assets') }}{{ $product->mockup_img_1 }}" class="d-block w-100 img-fluid cursor_pointer" alt="Main Image" onclick="openModal('{{ asset('assets') }}{{ $product->mockup_img_1 }}')">

                         <div class="small-images-row bottom-right small_img_background">
                             @if (!empty($product->mockup_img_1))
                                 <img src="{{ asset('assets') }}{{ $product->mockup_img_1 }}" class="small-img cursor_pointer" alt="Thumbnail 1" onclick="changeMainImage('{{ asset('assets') }}{{ $product->mockup_img_1 }}')">
                             @endif
                             @if (!empty($product->mockup_img_2))
                                 <img src="{{ asset('assets') }}{{ $product->mockup_img_2 }}" class="small-img cursor_pointer" alt="Thumbnail 2" onclick="changeMainImage('{{ asset('assets') }}{{ $product->mockup_img_2 }}')">
                             @endif
                             @if (!empty($product->mockup_img_3))
                                 <img src="{{ asset('assets') }}{{ $product->mockup_img_3 }}" class="small-img cursor_pointer" alt="Thumbnail 3" onclick="changeMainImage('{{ asset('assets') }}{{ $product->mockup_img_3 }}')">
                             @endif
                         </div>
                     </div>
                 </div>

                 <div class="col-lg-6" style="padding: 7px;">
                     <div class="card main-image-container" style="border-radius: unset; background-color: rgb(241, 241, 241); position: relative;">

                         @if (!empty($images_3d) && isset($images_3d[0]))

                             <img id="3DImage" src="{{ asset('') }}/{{ $images_3d[0]->image_link }}" class="d-block w-100 img-fluid cursor_pointer" alt="Main Image" onclick="openModal('{{ asset('') }}/{{ $images_3d[0]->image_link }}')">


                             <div class="small-images-row bottom-right small_img_background">
                                 @foreach ($images_3d as $index => $image_3d)
                                     @if (!empty($image_3d))
                                         <img src="{{ asset('') }}/{{ $image_3d->image_link }}" class="small-img cursor_pointer" alt="Thumbnail {{ $index + 1 }}" onclick="change3DImage('{{ asset('') }}/{{ $image_3d->image_link }}')">
                                     @endif
                                 @endforeach
                             </div>
                         @endif
                     </div>
                 </div>

             </div>


             <div class="row" style="margin: unset;">

                @if (!empty($studio_images && isset($studio_images[0])))
                    <div class="{{ (isset($studio_images[0]) && isset($lifeStyle_images[0])) ? 'col-lg-6' : 'col-lg-12' }}" style="padding: 7px;">
                        <div class="card main-image-container" style="border-radius: unset; background-color: rgb(241, 241, 241); position: relative;">

                            <img id="studioImage" src="{{ asset('') }}/{{ $studio_images[0]->image_link }}" class="d-block w-100 img-fluid cursor_pointer" alt="Main Image" onclick="openModal('{{ asset('') }}/{{ $studio_images[0]->image_link }}')">

                            <div class="small-images-row bottom-right small_img_background" style="width: 98%;">
                                @if (!empty($studio_images))
                                    @foreach ($studio_images as $index => $studio_image)
                                        @if (!empty($studio_image))
                                            <img src="{{ asset('') }}/{{ $studio_image->image_link }}" class="small-img cursor_pointer" alt="Thumbnail {{ $index + 1 }}" onclick="changeStudioImage('{{ asset('') }}/{{ $studio_image->image_link }}')">
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @if (!empty($lifeStyle_images && isset($lifeStyle_images[0])))
                    <div class="{{ (isset($studio_images[0]) && isset($lifeStyle_images[0])) ? 'col-lg-6' : 'col-lg-12' }}" style="padding: 7px;">
                        <div class="card main-image-container" style="border-radius: unset; background-color: rgb(241, 241, 241); position: relative;">

                            <img id="lifeStyleImage" src="{{ asset('') }}/{{ $lifeStyle_images[0]->image_link }}" class="d-block w-100 img-fluid cursor_pointer" alt="Main Image" onclick="openModal('{{ asset('') }}/{{ $lifeStyle_images[0]->image_link }}')">

                            <div class="small-images-row bottom-right small_img_background" style="width: 98%;">
                                @if (!empty($lifeStyle_images))
                                    @foreach ($lifeStyle_images as $index => $lifestyle_image)
                                        @if (!empty($lifestyle_image))
                                            <img src="{{ asset('') }}/{{ $lifestyle_image->image_link }}" class="small-img cursor_pointer" alt="Thumbnail {{ $index + 1 }}" onclick="changelifeStyleImage('{{ asset('') }}/{{ $lifestyle_image->image_link }}')">
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

             </div>

             <div class="row" style="margin: unset; padding-bottom: 15px;">
                 <div class="col-lg-6" style="padding: 7px;">
                     <div class="card main-image-container" style="border-radius: unset; background-color: rgb(241, 241, 241); position: relative;">

                         @if (!empty($closeUp_images) && isset($closeUp_images[0]))

                             <img id="closeUpImage" src="{{ asset('') }}/{{ $closeUp_images[0]->image_link }}" class="d-block w-100 img-fluid cursor_pointer" alt="Main Image" onclick="openModal('{{ asset('') }}/{{ $closeUp_images[0]->image_link }}')">


                             <div class="small-images-row bottom-right small_img_background">
                                 @foreach ($closeUp_images as $index => $closeUp_image)
                                     @if (!empty($closeUp_image))
                                         <img src="{{ asset('') }}/{{ $closeUp_image->image_link }}" class="small-img cursor_pointer" alt="Thumbnail {{ $index + 1 }}" onclick="changeCloseUpImage('{{ asset('') }}/{{ $closeUp_image->image_link }}')">
                                     @endif
                                 @endforeach
                             </div>
                         @endif
                     </div>
                 </div>

                 <div class="col-lg-6" style="padding: 7px;">
                     <div class="card main-image-container" style="border-radius: unset; background-color: rgb(241, 241, 241); position: relative;">

                         @if (!empty($branding_images) && isset($branding_images[0]))

                             <img id="brandingImage" src="{{ asset('') }}/{{ $branding_images[0]->image_link }}" class="d-block w-100 img-fluid cursor_pointer" alt="Main Image" onclick="openModal('{{ asset('') }}/{{ $branding_images[0]->image_link }}')">


                             <div class="small-images-row bottom-right small_img_background">
                                 @foreach ($branding_images as $index => $branding_image)
                                     @if (!empty($branding_image))
                                         <img src="{{ asset('') }}/{{ $branding_image->image_link }}" class="small-img cursor_pointer" alt="Thumbnail {{ $index + 1 }}" onclick="changeBrandingImage('{{ asset('') }}/{{ $branding_image->image_link }}')">
                                     @endif
                                 @endforeach
                             </div>
                         @endif
                     </div>
                 </div>

             </div>

         </div>

         <div class="{{ !isset($images_3d[0]) ? 'col-lg-7' : 'col-lg-5' }}"
             style="padding: unset; padding-top: 10px; padding-left: 20px;">
         {{-- <div class="col-lg-5"  style="padding: unset; padding-top: 10px; padding-left: 20px;"> --}}
             <div class="row" style="margin: unset;">

                     @foreach ($relatedTaglines as $relatedTagline)

                         <div style="margin-right: 15px;">
                             <p class="reversible_product reversible_product_background tagline_details" data-value="{{ $relatedTagline->id }}" style="">
                                 <i class="fa fas fa-tag" style="padding-right: 6px;"></i>
                                 {{ $relatedTagline->tagline_name }}
                             </p>
                         </div>
                     @endforeach
             </div>

             <div class="row details_div_style" style="">
                 <div style="padding: unset; max-width: 84%; width: 84%;">
                     <p style="font-size: 20px; color: rgb(80, 80, 80); font-weight: 500; margin-bottom: 0.2rem;">{{ $product->product_name }}</p>
                 </div>


             </div>

             <div class="row details_div_style" style="padding-bottom: 10px; border-bottom: rgb(235, 232, 232) solid 1px;">
                 <div style="padding: unset;">
                    <p style="font-size: 12px; margin-bottom: 0.2rem; color: grey;">Product # : {{ str_replace('-', '  ', $product->product_no) }}</p>

                     <p style="font-size: 12px; margin-bottom: 0.2rem; color: grey;">1 Piece (MOQ)</p>
                 </div>

                 <div>
                     <p style="font-size: 20px; color: rgb(80, 80, 80); font-weight: 500; margin-bottom: 0.2rem;">${{ $product->default_price }}</p>
                 </div>
             </div>
             @if (!empty($product->description))
                    <div class="row details_div_style2" style="padding-bottom: 13px; border-bottom: rgb(235, 232, 232) solid 1px;">
                        <div class="row group_topic" style="cursor: pointer; margin: unset; width: 100%;" id="description-topic">
                            <p class="product-discriptiopn-title" style="font-size: 15px; color: rgb(80, 80, 80); font-weight: 400; margin-bottom: 0.5rem; margin-top:0.5rem; width: 95%;">
                                Product Description
                            </p>
                            <i class="fa fa-angle-down fa-1x" style="font-size: 21px; color: rgb(80, 80, 80); margin-top:0.5rem;"></i>
                        </div>
                        <div class="description_content" style="padding-left: 20px; padding-right: 20px;">
                            <p class="" style="font-size: 14px; margin-bottom: 0.8rem; margin-left: 1.5rem; margin-right: 1rem; color: grey;">{!! $product->description !!}</p>
                        </div>
                    </div>
                @endif
             @if (!empty($product->who_we_made_this_for))
                    <div class="row details_div_style2" style="padding-bottom: 13px; border-bottom: rgb(235, 232, 232) solid 1px;">
                        <div class="row group_topic" style="cursor: pointer; margin: unset; width: 100%;" id="made-topic">
                            <p class="product-discriptiopn-title" style="font-size: 15px; color: rgb(80, 80, 80); font-weight: 400; margin-bottom: 0.5rem; margin-top:0.5rem; width: 95%;">
                                Who We Made This For
                            </p>
                            <i class="fa fa-angle-down fa-1x" style="font-size: 21px; color: rgb(80, 80, 80); margin-top:0.5rem;"></i>
                        </div>
                        <div class="made_content made_visible" style="padding-left: 20px; padding-right: 20px;">
                            <p class="" style="font-size: 14px; margin-bottom: 0.8rem; margin-left: 1.5rem; margin-right: 1rem; color: grey;">{!! $product->who_we_made_this_for !!}</p>
                        </div>
                    </div>
            @endif
            @if (!empty($product->product_features))
                    <div class="row details_div_style2" style="padding-bottom: 13px; border-bottom: rgb(235, 232, 232) solid 1px;">
                        <div class="row group_topic" style="cursor: pointer; margin: unset; width: 100%;" id="features-topic">
                            <p class="product-discriptiopn-title" style="font-size: 15px; color: rgb(80, 80, 80); font-weight: 400; margin-bottom: 0.5rem; margin-top:0.5rem; width: 95%;">
                                Product Features
                            </p>
                            <i class="fa fa-angle-down fa-1x" style="font-size: 21px; color: rgb(80, 80, 80); margin-top:0.5rem;"></i>
                        </div>
                        <div class="features_content features_visible" style="padding-left: 20px; padding-right: 20px;">
                            <p class="" style="font-size: 14px; margin-bottom: 0.8rem; margin-left: 1.5rem; margin-right: 1rem; color: grey;">{!! $product->product_features !!}</p>
                        </div>
                    </div>
            @endif


             @php
                 $sizetypeid = $product->size_id;
                 $sizeNames = $size->where('size_type', $sizetypeid)->pluck('size_name')->toArray();

                 function getShortenedSizeName($sizeName) {
                     $sizeMap = [
                         'Youth' => 'Y',
                         'Adult' => 'A',
                         'Small' => 'S',
                         'Medium' => 'M',
                         'Large' => 'L',
                         'XLarge' => 'XL',
                         'XXLarge' => 'XXL',
                         '3XLarge' => '3XL',
                         '4XLarge' => '4XL'
                     ];

                     foreach ($sizeMap as $fullWord => $abbreviation) {
                         $sizeName = str_replace($fullWord, $abbreviation, $sizeName);
                     }

                     return str_replace(' ', '', $sizeName);
                 }

                 // Define the custom order for sorting
                 $sizeOrder = [
                     'YXS', 'YS', 'YM', 'YL', 'YXL', // Youth sizes
                     'AXS', 'AS', 'AM', 'AL', 'AXL', 'AXXL', // Adult sizes
                     'A2XL', 'A3XL', 'A4XL'          // Additional adult sizes
                 ];

                 // Convert size names to their shortened form
                 $shortenedSizeNames = array_map('getShortenedSizeName', $sizeNames);

                 // Sort sizes based on the defined order
                 usort($shortenedSizeNames, function ($a, $b) use ($sizeOrder) {
                     $indexA = array_search($a, $sizeOrder);
                     $indexB = array_search($b, $sizeOrder);

                     return $indexA <=> $indexB;
                 });
             @endphp


             @if (!empty($relatedFits) || !empty($product->fits_true_to_size) || !empty($shortenedSizeNames))
                 <div class="row details_div_style2" style="padding-bottom: 13px; border-bottom: rgb(235, 232, 232) solid 1px;">
                     <div class="row group_topic" style="cursor: pointer; margin: unset; width: 100%;" id="fit-topic">
                         <p class="product-discriptiopn-title" style="font-size: 15px; color: rgb(80, 80, 80); font-weight: 400; margin-bottom: 0.5rem; margin-top:0.5rem; width: 95%;">
                            Fit & Sizes Options
                         </p>
                         <i class="fa fa-angle-down fa-1x" style="font-size: 21px; color: rgb(80, 80, 80); margin-top:0.5rem;"></i>
                     </div>
                     <div class="fit_content fit_visible" style="padding-left: 20px; padding-right: 20px; width: 100%;">

                        @if (!empty($shortenedSizeNames))
                            <div class="row details_div_style" style="">
                                <div style="padding: unset;">
                                    <p style="font-size: 15px; color: rgb(80, 80, 80); font-weight: 400; margin-bottom: 0.2rem;">Available Sizes</p>
                                </div>

                                <div class="row" style="margin: unset;">
                                    @if(!empty($product->size_chart))
                                        <a id="open-size-chart"
                                            href="javascript:void(0);"
                                            class="sizing_link size_tag"
                                            data-chart="{{ asset($product->size_chart) }}"
                                            style="">
                                                <i class="fa fas fa-chevron-right"></i><i class="fa fas fa-chevron-right"></i> Size Chart
                                        </a>
                                    @else
                                            <a href="https://encr.co/customerSizing"
                                            class="sizing_link size_tag"
                                            target="_blank"
                                            style="">
                                                <i class="fa fas fa-chevron-right"></i><i class="fa fas fa-chevron-right"></i> Size Chart
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="row details_div_style2" style="padding-bottom: 20px;">
                                @foreach ($shortenedSizeNames as $sizeName)
                                    <div class="fit_sections" style="" title="{{ $sizeName }}">
                                        {{ $sizeName }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if (!empty($relatedFits) || !empty($product->fits_true_to_size))
                            <div class="row details_div_style2" style="padding-top: 15px;">
                                @foreach ($relatedFits as $relatedFit )
                                    <div class="fit_sections" style="" title="">{{ $relatedFit->fit_name }}</div>
                                @endforeach
                            </div>

                            <div class="row details_div_style" style="">
                                <div style="padding: unset;">
                                    <p style="font-size: 15px; color: rgb(80, 80, 80); font-weight: 400; margin-bottom: 0.2rem;">Fits  True to Size</p>
                                </div>
                            </div>

                            <div class="row details_div_style" style="padding-bottom: 13px; border-bottom: rgb(235, 232, 232) solid 1px;">
                                <div class="horizontal-line-container">
                                    <div class="horizontal-line">
                                        <!-- Vertical line position based on fits_true_to_size value -->
                                        <span class="vertical-line" style="left: calc(({{ $product->fits_true_to_size - 1 }} * 25%) - {{ $product->fits_true_to_size == 1 ? '-13' : ($product->fits_true_to_size == 5 ? '13' : '0') }}px);"></span>
                                    </div>
                                    <!-- Labels -->
                                        <div class="label-left">Smaller</div>
                                        <div class="label-right">Larger</div>
                                    <div class="label-center"
                                        style="position: absolute; left: 50%; transform: translateX(-50%);
                                                font-size: 13px; color: black; font-weight: 500;">
                                        True to Size
                                    </div>

                                </div>
                            </div>
                        @endif



                     </div>
                 </div>
             @endif

             <div class="row details_div_style2" style="padding-bottom: 13px; border-bottom: rgb(235, 232, 232) solid 1px;">
                 <div class="row group_topic" style="cursor: pointer; margin: unset; width: 100%;" id="fabric-topic">
                     <p class="product-discriptiopn-title" style="font-size: 15px; color: rgb(80, 80, 80); font-weight: 400; margin-bottom: 0.5rem; margin-top:0.5rem; width: 95%;">
                         Fabric Options
                     </p>
                     <i class="fa fa-angle-down fa-1x" style="font-size: 21px; color: rgb(80, 80, 80); margin-top:0.5rem;"></i>
                 </div>
                 <div class="fabric_content fabric_visible" style="padding-left: 20px; padding-right: 20px;">
                     <div class="row details_div_style2" style="padding-bottom: 13px;">

                        @foreach ($relatedFabric as $relatedFabrics)
                            <div class="fit_sections fabric-option" data-subProduct-id="{{ $relatedFabrics['subproduct_id'] }}" style="margin-right: 7px;">
                                <span>{{ $relatedFabrics['fabric_detail']->fabric_name }}</span>
                            </div>

                            @if (isset($relatedFabrics['fabric_detail']->description) || isset($relatedFabrics['fabric_detail']->image_1))
                                <a href="#" class="sizing_link fabricInfoLink" data-subProduct-id="{{ $relatedFabrics['subproduct_id'] }}" style="font-size: 16px; padding-right: 16px;">
                                    <i class="fa fas fa-circle-info info_icon"></i>
                                </a>
                            @endif

                        @endforeach
                     </div>

                     <div class="row details_div_style display_hide" id="embellishmentTypeTopic"  style="">
                         <div style="padding: unset;">
                             <p style="font-size: 14px; color: rgb(80, 80, 80); font-weight: 300; margin-bottom: 0.2rem;">Embellishment Types </p>
                         </div>

                         {{-- <div class="row" style="margin: unset;">
                             <a id="embellishmentInfoLink"  href="#" class="sizing_link" style="font-size: 12px; margin-bottom: 0.2rem; color: grey; padding-left: 9px;"></a>
                         </div> --}}
                     </div>

                     <div class="row details_div_style2 " style="padding-bottom: 13px;">
                         {{-- <div class="details_div_style2 display_hide" style="" id="embellishmentTypeInfo">
                             <a id="embellishmentInfoLink"  href="#" class="sizing_link" style="font-size: 16px; padding-right: 10px;"></a>
                         </div> --}}
                         <div class="details_div_style2 display_hide" id="embellishmentType">

                         </div>
                     </div>

                     <div class="row details_div_style display_hide" id="colorTopic" style="">
                         <div style="padding: unset;">
                             <p style="font-size: 14px; color: rgb(80, 80, 80); font-weight: 300; margin-bottom: 0.2rem;">Available Colors</p>
                         </div>
                     </div>

                     <div class="row details_div_style2 display_hide" id="colorInfo" style="padding-bottom: 13px;">

                     </div>

                     <div class="row details_div_style2 display_hide" id="colorAllColor" style="padding-bottom: 13px;">
                         <div style="padding: unset;">
                             <p style="font-size: 13px; color: rgb(95, 95, 95); font-weight: 500; margin-bottom: 0.2rem;">Customizable in any color</p>
                         </div>
                     </div>
                 </div>
             </div>


             @if (!empty($relatedAttributes))
                 <div class="row details_div_style2" style="padding-bottom: 13px; border-bottom: rgb(235, 232, 232) solid 1px;">
                     <div class="row group_topic" style="cursor: pointer; margin: unset; width: 100%;" id="attribute-topic">
                         <p class="product-discriptiopn-title" style="font-size: 15px; color: rgb(80, 80, 80); font-weight: 400; margin-bottom: 0.5rem; margin-top:0.5rem; width: 95%;">
                             Product Features
                         </p>
                         <i class="fa fa-angle-down fa-1x" style="font-size: 21px; color: rgb(80, 80, 80); margin-top:0.5rem;"></i>
                     </div>
                     <div class="attribute_content attribute_visible" style="padding-left: 20px; padding-right: 20px; width: 100%;">
                         <div class="row" style="margin:unset;">
                             @foreach ($relatedAttributes as $relatedAttribute)
                                 <div class="col-lg-6">
                                     <div>
                                         <span>{{ $relatedAttribute->attribute_name }}</span>
                                     </div>
                                     <div style="padding: 10px;">
                                         <img src="{{ asset('') }}/{{ $relatedAttribute->image_1 }}" style="width: 200px;" alt="" class="cursor_pointer"  onclick="openModal('{{ asset('') }}/{{ $relatedAttribute->image_1 }}')">
                                     </div>
                                     <div>
                                         <span style="color: gray;">{{ $relatedAttribute->description }}</span>
                                     </div>
                                 </div>
                         @endforeach
                         </div>
                     </div>
                 </div>
             @endif

             @can('view design files')
                @if (!empty($product['2D_mockup']) || !empty($product['3D_mockup']) || !empty($product['tech_pack']) || !empty($product['technical_tech_pack']) || !empty($product['measurement']) || !empty($product['product_layout']) || !empty($product['pattern']))
                    <div class="row details_div_style2" style="padding-bottom: 30px; border-bottom: rgb(235, 232, 232) solid 1px;">
                        <div class="row group_topic" style="cursor: pointer; margin: unset; width: 100%;" id="file-download-topic">
                            <p class="product-discriptiopn-title" style="font-size: 15px; color: rgb(80, 80, 80); font-weight: 400; margin-bottom: 0.5rem; margin-top:0.5rem; width: 95%;">
                                Design Related Files
                            </p>
                            <i class="fa fa-angle-down fa-1x" style="font-size: 21px; color: rgb(80, 80, 80); margin-top:0.5rem;"></i>
                        </div>
                        <div class="file_download_content file_download_visible" style="padding-left: 20px; padding-right: 20px; width: 100%;">
                            <table class="col-lg-12" style="background-color: white;">
                                <tr style="background-color: grey; height: 40px;font-size:14px;">
                                    <th style="color:white;">&nbsp;&nbsp;FILE NAME</th>
                                    <th style="text-align: center; color:white;">ACTION</th>
                                </tr>
                                @if (!empty($product['2D_mockup']) && Gate::allows('view_2D_Mockup_Template'))
                                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                                        <td style="color: black;">&nbsp;&nbsp;2D Mockup Template</td>
                                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['2D_mockup'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                                    </tr>
                                @endif
                                @if (!empty($product['3D_mockup']) && Gate::allows('view_3D_Mockup_Template'))
                                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                                        <td style="color: black">&nbsp;&nbsp;3D Mockup Template</td>
                                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['3D_mockup'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                                    </tr>
                                @endif
                                @if (!empty($product['tech_pack']) && Gate::allows('view_Design_Tech_Pack'))
                                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                                        <td style="color: black">&nbsp;&nbsp;Design Tech Pack</td>
                                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['tech_pack'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                                    </tr>
                                @endif
                                @if (!empty($product['technical_tech_pack']) && Gate::allows('view_Technical_Tech_Pack'))
                                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                                        <td style="color: black">&nbsp;&nbsp;Technical Tech Pack</td>
                                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['technical_tech_pack'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                                    </tr>
                                @endif
                                @if (!empty($product['measurement']) && Gate::allows('view_Measurement_Chart'))
                                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                                        <td style="color: black">&nbsp;&nbsp;Measurement Chart</td>
                                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['measurement'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                                    </tr>
                                @endif
                                @if (!empty($product['product_layout']) && Gate::allows('view_Production_Layout'))
                                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                                        <td style="color: black">&nbsp;&nbsp;Production Layout</td>
                                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['product_layout'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                                    </tr>
                                @endif
                                @if (!empty($product['pattern']) && Gate::allows('view_Pattern_Files'))
                                    <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                                        <td style="color: black">&nbsp;&nbsp;Pattern File</td>
                                        <td onclick="downloadFile('{{ asset('assets') }}{{ $product['pattern'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                @endif
             @endcan

             {{-- @can('view design files')
                <div class="row details_div_style2">
                    <div class="col-lg-12">
                        <h4 style="margin-left: 1%; margin-top:2%; font-weight: 700;">DESIGN RELATED FILES</h4>
                    </div>
                    <table class="col-lg-12" style="background-color: white;width: 80%;">
                        <tr style="background-color: grey; height: 40px;font-size:14px;">
                            <th style="color:white;">&nbsp;&nbsp;FILE NAME</th>
                            <th style="text-align: center; color:white;">ACTION</th>
                        </tr>
                        <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                            <td style="color: black;">&nbsp;&nbsp;2D Mockup Template</td>
                            <td onclick="downloadFile('{{ asset('assets') }}{{ $product['2D_mockup'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                        </tr>
                        <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                            <td style="color: black">&nbsp;&nbsp;3D Mockup Template</td>
                            <td onclick="downloadFile('{{ asset('assets') }}{{ $product['3D_mockup'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                        </tr>
                        <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                            <td style="color: black">&nbsp;&nbsp;Design Tech Pack</td>
                            <td onclick="downloadFile('{{ asset('assets') }}{{ $product['tech_pack'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                        </tr>
                        <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                            <td style="color: black">&nbsp;&nbsp;Technical Tech Pack</td>
                            <td onclick="downloadFile('{{ asset('assets') }}{{ $product['technical_tech_pack'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                        </tr>
                        <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                            <td style="color: black">&nbsp;&nbsp;Measurement Chart</td>
                            <td onclick="downloadFile('{{ asset('assets') }}{{ $product['measurement'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                        </tr>
                        <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                            <td style="color: black">&nbsp;&nbsp;Production Layout</td>
                            <td onclick="downloadFile('{{ asset('assets') }}{{ $product['product_layout'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                        </tr>
                        <tr style="height: 40px;font-size:14px; border-bottom: 1px solid rgb(212, 212, 212)">
                            <td style="color: black">&nbsp;&nbsp;Pattern File</td>
                            <td onclick="downloadFile('{{ asset('assets') }}{{ $product['pattern'] }}')" style="text-align: center; color:grey;cursor:pointer"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;DOWNLOAD FILE</td>
                        </tr>
                    </table>
                </div>
            @endcan --}}
         </div>

     </div>
 </div>

 <!-- Modal Structure -->
 <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-fullscreen" style="max-width: 80%;">
         <div class="modal-content image_modal_css">
             <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center position-relative"
                 style="min-height: 85vh; overflow: hidden;">

                 <!-- Close Button -->
                 <button type="button" class="btn-close position-absolute close_btn_style"
                         style="top: 20px; right: 20px; z-index: 10;"
                         data-bs-dismiss="modal" aria-label="Close">&#10005;
                 </button>

                 <!-- Title -->
                 <div id="" class="position-relative d-flex justify-content-center align-items-center mt-2"
                     style="width: 40%; max-width: 40%; padding-bottom: 20px;">
                     <b style="font-size: 25px; margin-bottom: unset; color: #ffffff; text-align: center;">
                         {{ $product->product_name }}
                     </b>
                 </div>

                 <!-- Image and Details Section -->
                 <div class="container-fluid d-flex flex-column flex-md-row align-items-center mt-2 justify-content-center">

                     <!-- Image Section -->
                     <div class="image-section mb-3 mb-md-0 text-center" style="background-color: rgba(255, 255, 255, 0.44); padding: 2px;">
                         <img id="modalImage" src="" alt="Image" class="img-fluid"
                             style="height: 80vh;">
                     </div>

                     <!-- Text Section -->
                     <div class="text-section d-flex flex-column align-items-center align-items-md-start ms-md-3 mt-3 mt-md-0 text-center text-md-start" style="padding-left: 42px;">

                         <div id="relatedAttributeName" class="position-relative d-flex justify-content-center align-items-center mt-2"
                             style="display: none;">
                             <p id="relatedName" style="font-size: 14px; margin-bottom: unset; color: #ffffff; padding-top: 3px;">

                             </p>
                         </div>

                         <div id="relatedAttributeDescription" class="position-relative d-flex justify-content-center align-items-center mt-2"
                             style="display: none;">
                             <p id="relatedAttributeText" style="font-size: 12px; margin-bottom: unset; color: #ffffff; padding-top: 3px;">

                             </p>
                         </div>

                     </div>
                 </div>

                 <!-- Navigation Buttons -->
                 <button id="prevButton" class="btn btn-light position-absolute next_button"
                         style="left: 20px; top: 50%; transform: translateY(-50%);"
                         onclick="changeImage(-1)">
                     &#10094;
                 </button>

                 <button id="nextButton" class="btn btn-light position-absolute next_button"
                         style="right: 20px; top: 50%; transform: translateY(-50%);"
                         onclick="changeImage(1)">
                     &#10095;
                 </button>
             </div>
         </div>
     </div>
 </div>


<div class="modal fade" id="imageModalFabric" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered modal-fullscreen" style="max-width: 80%;">
     <div class="modal-content image_modal_css">
         <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center position-relative"
              style="min-height: 85vh; overflow: hidden;">

             <button type="button" class="btn-close position-absolute close_btn_style"
                     style="top: 20px; right: 20px; z-index: 10;"
                     data-bs-dismiss="modal" aria-label="Close">&#10005;
             </button>


             <div id="" class="position-relative d-flex justify-content-center align-items-center mt-2"
                 style="width: 40%; max-width: 40%; padding-bottom: 20px;">
                 <b style="font-size: 25px; margin-bottom: unset; color: #b3b3b3; text-align: center;">
                     {{ $product->product_name }}
                 </b>
             </div>

             <div class="container-fluid d-flex flex-column flex-md-row align-items-center mt-2 justify-content-center">

                 <div class="image-section mb-3 mb-md-0 text-center" style="background-color: rgba(255, 255, 255, 0.44); padding: 2px;">
                     <img id="modalImageFabric" src="" alt="Image" class="img-fluid"
                         style="height: 80vh;">
                 </div>

                 <div class="text-section d-flex flex-column align-items-center align-items-md-start ms-md-3 mt-3 mt-md-0 text-center text-md-start" style=" padding-left: 42px;">

                     <div id="relatedAttributeNameFabric" class="position-relative d-flex justify-content-center align-items-center mt-2"
                         style="  display: none;">
                         <p id="relatedNameFabric" style="font-size: 14px; margin-bottom: unset; color: #ffffff; padding-top: 3px;">

                         </p>
                     </div>

                     <div id="relatedAttributeDescriptionFabric" class="position-relative d-flex justify-content-center align-items-center mt-2"
                         style="  display: none;">
                         <p id="relatedAttributeTextFabric" style="font-size: 12px; margin-bottom: unset; color: #ffffff; padding-top: 3px;">

                         </p>
                     </div>
                 </div>
             </div>

         </div>
     </div>
 </div>
</div>

<div class="modal fade" id="videoModalTagline" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered modal-fullscreen" style="max-width: 80%;">
     <div class="modal-content image_modal_css">
         <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center position-relative"
              style="min-height: 85vh; overflow: hidden;">

             <button type="button" class="btn-close position-absolute close_btn_style"
                     style="top: 20px; right: 20px; z-index: 10;"
                     data-bs-dismiss="modal" aria-label="Close">&#10005;
             </button>

             <div id="" class="position-relative d-flex justify-content-center align-items-center mt-2"
                 style="width: 40%; max-width: 40%; padding-bottom: 20px; font-size: 25px; color: #ffffff; text-align: center;">
                        {{ $product->product_name }}
             </div>

             <div class="container-fluid d-flex flex-column flex-md-row align-items-center mt-2 justify-content-center">

                 <div class="image-section mb-3 mb-md-0 text-center" style="background-color: rgba(255, 255, 255, 0.44); padding: 2px;">

                     <video id="modalVideoTagline" class="video-fluid" controls
                         style="">
                         <source src="" type="video/mp4">
                     </video>
                 </div>

                 <div class="text-section d-flex flex-column align-items-center align-items-md-start ms-md-3 mt-3 mt-md-0 text-center text-md-start" style=" padding-left: 42px;">
                     <!-- Related Name -->
                     <div id="relatedTaglinename" class="position-relative d-flex justify-content-center align-items-center mt-2"
                         style="display: none;">
                         <p id="relatedNameTagline" style="font-size: 14px; color: #ffffff; padding-top: 3px;"></p>
                     </div>

                     <!-- Related Description -->
                     <div id="relatedDescriptionTagline" class="position-relative d-flex justify-content-center align-items-center mt-2"
                         style="display: none;">
                         <p id="relatedTextTagline" style="font-size: 12px; color: #ffffff; padding-top: 3px;"></p>
                     </div>

                 </div>
             </div>

         </div>
     </div>
 </div>
</div>
<!-- XL Modal -->
<div class="modal fade" id="sizeChartModal" tabindex="-1" aria-labelledby="sizeChartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-white">
      <div class="modal-header">
        <h5 class="modal-title" id="sizeChartModalLabel">Size Chart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body">
        <img id="sizeChartImage" src="" alt="Size Chart" style="max-width:100%; height:auto;">
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
    const $modal = $('#sizeChartModal');
    const $modalImage = $('#sizeChartImage');

    $('#open-size-chart').on('click', function (e) {
        e.preventDefault();

        const chartUrl = $(this).data('chart');

        // If it's an image, show in modal; else open in new tab
        if (/\.(jpeg|jpg|png|gif|webp|svg)$/i.test(chartUrl)) {
            $modalImage.attr('src', chartUrl);
            $modal.modal('show');
        } else {
            window.open(chartUrl, '_blank');
        }
    });
     $('.filter_select').change(handleDropdownChange);
 });

 $(document).ready(function () {
     // Triggered when the value of any select element changes
     $('.filter_select').change(function () {
         // Update the corresponding hidden input value
         updateHiddenInput('mainCategories', 'selectedCategoryInput');
         updateHiddenInput('genderSelect', 'selectedGenderInput');
         updateHiddenInput('sportSelect', 'selectedSportInput');
         updateHiddenInput('styleSelect', 'selectedStyleInput');

         // Submit the form
         $('#filterForm').submit();
     });

     // Function to update the hidden input value based on the selected option
     function updateHiddenInput(selectId, hiddenInputId) {
         var selectedValue = $('#' + selectId).val();
         var hiddenInput = $('#' + hiddenInputId)[0]; // Get the DOM element

         // Add your specific condition here
         // if (selectId === 'mainCategories' && selectedValue === '5') {
         //     hiddenInput.value = ""; // Set it to an empty string
         // } else {
             hiddenInput.value = selectedValue;
         // }
     }
 });
</script>

<script>
    function viewImage(link) {
        var img = new Image();
        img.src = link;
        img.onload = function() {
            var modalImage = document.getElementById('modalImage');
            modalImage.src = img.src;
        };
        $('#imageModal').modal('show');
    }
    function viewImageBlank(link){
        window.open(link, '_blank');
    }
    function downloadFile(linkReceived) {
        var linkReceived = linkReceived;

        console.log(linkReceived);

        window.open(linkReceived);
    }

    // Close modal when the close button is clicked
    $(document).on('click', '.modal .close', function() {
        $('#imageModal').modal('hide');
    });
</script>

<script>

 function changeMainImage(imageSrc) {

     document.getElementById('mainImage').src = imageSrc;


     document.getElementById('mainImage').setAttribute('onclick', 'openModal("' + imageSrc + '")');
 }

 function change3DImage(imageSrc) {
     document.getElementById('3DImage').src = imageSrc;

     document.getElementById('3DImage').onclick = function() {
         openModal(imageSrc);
     };
 }

 function changelifeStyleImage(imageSrc) {
     document.getElementById('lifeStyleImage').src = imageSrc;

     document.getElementById('lifeStyleImage').onclick = function() {
         openModal(imageSrc);
     };
 }

 function changeStudioImage(imageSrc) {
        document.getElementById('studioImage').src = imageSrc;

        document.getElementById('studioImage').onclick = function() {
            openModal(imageSrc);
        };
 }

 function changeCloseUpImage(imageSrc) {
     document.getElementById('closeUpImage').src = imageSrc;

     document.getElementById('closeUpImage').onclick = function() {
         openModal(imageSrc);
     };
 }
 function changestudioImage(imageSrc) {
     document.getElementById('studioImage').src = imageSrc;

     document.getElementById('studioImage').onclick = function() {
         openModal(imageSrc);
     };
 }

 function changeBrandingImage(imageSrc) {
     document.getElementById('brandingImage').src = imageSrc;

     document.getElementById('brandingImage').onclick = function() {
         openModal(imageSrc);
     };
 }

 document.addEventListener("DOMContentLoaded", function() {
     const mockups = [];
     let currentIndex = 0;
     let showAdditionalInfo = false;

     // Populate mockups array with data
     @if (!empty($product->mockup_img_1))
     mockups.push({
         url: "{{ asset('assets') }}{{ $product->mockup_img_1 }}",
         description: {!! json_encode(nl2br($product->mockup_caption_1 ?? '')) !!},
         name: ""
     });
     showAdditionalInfo = true;
     @endif

     @if (!empty($product->mockup_img_2))
     mockups.push({
         url: "{{ asset('assets') }}{{ $product->mockup_img_2 }}",
         description: {!! json_encode(nl2br($product->mockup_caption_2 ?? '')) !!},
         name: ""
     });
     showAdditionalInfo = true;
     @endif

     @if (!empty($product->mockup_img_3))
     mockups.push({
         url: "{{ asset('assets') }}{{ $product->mockup_img_3 }}",
         description: {!! json_encode(nl2br($product->mockup_caption_3 ?? '')) !!},
         name: ""
     });
     showAdditionalInfo = true;
     @endif

     @foreach ($images_3d as $image_3d)
     mockups.push({
         url: "{{ asset('') }}/{{ $image_3d->image_link }}",
         description: {!! json_encode(nl2br($image_3d->image_caption ?? '')) !!},
         name: ""
     });
     @endforeach

     @foreach ($lifeStyle_images as $lifeStyle_image)
     mockups.push({
         url: "{{ asset('') }}/{{ $lifeStyle_image->image_link }}",
         description: {!! json_encode(nl2br($lifeStyle_image->image_caption ?? '')) !!},
         name: ""
     });
     @endforeach

    @foreach ($studio_images as $studio_image)
    mockups.push({
        url: "{{ asset('') }}/{{ $studio_image->image_link }}",
        description: {!! json_encode(nl2br($studio_image->image_caption ?? '')) !!},
        name: ""
    });
    @endforeach

     @foreach ($closeUp_images as $closeUp_image)
     mockups.push({
         url: "{{ asset('') }}/{{ $closeUp_image->image_link }}",
         description: {!! json_encode(nl2br($closeUp_image->image_caption ?? '')) !!},
         name: ""
     });
     @endforeach

     @foreach ($branding_images as $branding_image)
     mockups.push({
         url: "{{ asset('') }}/{{ $branding_image->image_link }}",
         description: {!! json_encode(nl2br($branding_image->image_caption ?? '')) !!},
         name: ""
     });
     @endforeach

     @foreach ($relatedAttributes as $relatedAttribute)
     mockups.push({
         url: "{{ asset('') }}/{{ $relatedAttribute->image_1 }}",
         description: {!! json_encode(nl2br($relatedAttribute->description ?? '')) !!},
         name: "{{ $relatedAttribute->attribute_name ?? '' }}"
     });
     @endforeach

     @foreach ($relatedFabric as $relatedFabrics)
     mockups.push({
         url: "{{ asset('') }}/{{ $relatedFabrics['fabric_detail']->image_1 }}",
         description: {!! json_encode(nl2br($relatedFabrics['fabric_detail']->description ?? '')) !!},
         name: "{{ $relatedFabrics['fabric_detail']->fabric_name ?? '' }}"
     });
     @endforeach

     @foreach ($relatedEmbellishments as $relatedEmbellishment)
     mockups.push({
         url: "{{ asset('') }}/{{ $relatedEmbellishment->video_path }}",
         description: {!! json_encode(nl2br($relatedEmbellishment->description ?? '')) !!} ,
         name: "{{ $relatedEmbellishment->embellishment_name ?? '' }}"
     });
     @endforeach

     // Define openModal function
     window.openModal = function(selectedImage) {
         currentIndex = mockups.findIndex(img => img.url === selectedImage);
         updateModalImage();

         const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
         imageModal.show();
     };

     function updateModalImage() {
         const modalImage = document.getElementById('modalImage');
         modalImage.src = mockups[currentIndex].url;

         const relatedAttributeDescription = document.getElementById('relatedAttributeDescription');
         const relatedAttributeText = document.getElementById('relatedAttributeText');

         const relatedAttributeName = document.getElementById('relatedAttributeName');
         const relatedName = document.getElementById('relatedName');

         if (mockups[currentIndex].description) {
             relatedAttributeDescription.style.display = "flex";
             relatedAttributeText.innerHTML = mockups[currentIndex].description;
         } else {
             relatedAttributeDescription.style.display = "none";
             relatedAttributeText.innerHTML = "";
         }

         if (mockups[currentIndex].name) {
             relatedAttributeName.style.display = "flex";
             relatedName.innerText = mockups[currentIndex].name;
         } else {
             relatedAttributeName.style.display = "none";
             relatedName.innerText = "";
         }

         document.getElementById('prevButton').disabled = currentIndex === 0;
         document.getElementById('nextButton').disabled = currentIndex === mockups.length - 1;
     }

     window.changeImage = function(direction) {
         currentIndex += direction;
         updateModalImage();
     };
 });
</script>




 {{-- <div class="row">
     <!-- Thumbnail Column -->
     <div class="col-lg-1 col-md-2 col-sm-2 image-position-small">
         <div id="defaultThumbnail">
             <div class="carousel-thumbnails d-flex flex-column justify-content-center mt-2 thumbmail-style ml-auto" style="width: fit-content">
                 <img src="{{ asset('assets') }}{{ $product->mockup_img_1 ? $product->mockup_img_1 : asset($imageUrl) }}" class="img-thumbnail my-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="0" alt="Thumbnail 1" onclick="goToSlide(0)">
                 @if ($product->mockup_img_2)
                     <img src="{{ asset('assets') }}{{ $product->mockup_img_2 }}" class="img-thumbnail my-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="1" alt="Thumbnail 2" onclick="goToSlide(1)">
                 @endif
                 @if ($product->mockup_img_3)
                     <img src="{{ asset('assets') }}{{ $product->mockup_img_3 }}" class="img-thumbnail my-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="2" alt="Thumbnail 3" onclick="goToSlide(2)">
                 @endif
             </div>
         </div>
     </div>

     <!-- Main Image Column -->
     <div class="col-lg-5 col-md-8 col-sm-8 image-position mb-4">
         <div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel" style="width: 100%;">
             <div id="crouselDefault">
                 <div class="carousel-inner">
                     <div class="carousel-item active">
                         <img src="{{ asset('assets') }}{{ $product->mockup_img_1 ? $product->mockup_img_1 : asset($imageUrl)}}" class="d-block w-100 img-fluid" alt="Image 1">
                     </div>
                     @if ($product->mockup_img_2)
                         <div class="carousel-item">
                             <img src="{{ asset('assets') }}{{ $product->mockup_img_2 }}" class="d-block w-100 img-fluid" alt="Image 2">
                         </div>
                     @endif
                     @if ($product->mockup_img_3)
                         <div class="carousel-item">
                             <img src="{{ asset('assets') }}{{ $product->mockup_img_3 }}" class="d-block w-100 img-fluid" alt="Image 3">
                         </div>
                     @endif
                 </div>
             </div>
         </div>
     </div>

     <!-- Product Details Column -->
     <div class="col-lg-6 col-md-12 product-details">
         <div class="card_position">
             <div class="product_name">
                 <p class="customizable_product">
                     <img src="{{ asset('assets/img/icons/catlog/label_new.png') }}" alt="label" style="padding-right: 7px; width:17px;">
                     Customizable Product
                 </p>

                 <div class="row">
                     <p style="font-size: 25px; color: black; font-weight: 600; padding-left: 15px; margin-bottom: 0.2rem;">{{ $product->product_name }}</p>
                 </div>

                 <p style="font-size: 12px; margin-bottom: 0.2rem; color: grey;">Product # : PRO  {{ $product->id }}</p>
                 <p style="font-size: 20px; margin-bottom: 0.2rem; color: grey; font-weight: 600;">${{ $product->default_price }}</p>

                 <hr class="hr_margin">

                 <div class="ml-3">
                     <div class="row">
                         <p style="font-size: 14px; margin-bottom: 0.2rem; color: rgb(61, 60, 60);"><b>Fabric options : </b></p>
                         <p class="" style="font-size: 14px; margin-bottom: 0.8rem; margin-left:0.5rem; color: grey;">{{ $productFabric }}</p>
                     </div>

                     <div class="row">
                         <p style="font-size: 14px; margin-bottom: 0.2rem; color: rgb(61, 60, 60);"><b>Embellishment options : </b></p>
                         <p class="" style="font-size: 14px; margin-bottom: 0.8rem; margin-left:0.5rem; color: grey;">{{ $productEmblishment }}</p>
                     </div>

                     @if (!empty($displayedAttributes))
                         <div class="row">
                             <p style="font-size: 14px; margin-bottom: 0.2rem; color: rgb(61, 60, 60);"><b>Attributes : </b></p>
                             <div class="attribute-group">
                                 <p class="attribute-value" style="font-size: 14px; margin-bottom: 0.8rem; margin-left:0.5rem; color: grey;">
                                     {{ $displayedAttributes }}
                                 </p>
                             </div>
                         </div>
                     @endif

                     <div class="row">
                         <p style="font-size: 14px; margin-bottom: 0.8rem; color: rgb(61, 60, 60);"><b>Minimum order quantity : </b></p>
                         <p class="" style="font-size: 14px; margin-bottom: 0.2rem; margin-left:0.5rem; color: grey;">@if(empty($product->MOQ)) No available @else {{ $product->MOQ }} Item @endif</p>
                     </div>
                 </div>

                 <div class="card mb-3" style="border-radius: 10px;height: fit-content;">
                     <div class="description_topic">
                         <div class="row" style="cursor: pointer; margin-right: unset;" id="description-topic">
                             <p class="product-discriptiopn-title" style="font-size: 18px; font-weight: 700; margin-bottom: 0.8rem; color: rgb(61, 60, 60); margin-left: 2rem; margin-top:0.5rem; width: 85%;">
                                 Description
                             </p>
                             <i class="fa fa-angle-down fa-1x" style="font-size: 21px; color: rgb(61, 60, 60); margin-top:1rem;"></i>
                         </div>

                         <div class="description_content description_visible" style="padding-left: 20px; padding-right: 20px;">
                             <p class="" style="font-size: 14px; margin-bottom: 0.8rem; margin-left: 1.5rem; margin-right: 1rem; color: grey;">{!! $product->description !!}</p>
                         </div>
                     </div>

                     <div class="size_topic">
                         <div class="row" style="cursor: pointer; margin-right: unset;" id="size-topic">
                             <p class="product-discriptiopn-title" style="font-size: 18px; font-weight: 700; margin-bottom: 0.8rem; color: rgb(61, 60, 60); margin-left: 2rem; margin-top:0.5rem; width: 85%;">
                                 Size & Fit
                             </p>
                             <i class="fa fa-angle-down fa-1x" style="font-size: 21px; color: rgb(61, 60, 60); margin-top:1rem;"></i>
                         </div>

                         <div class="size_content size_visible">
                             <div class="row" style="margin-left: 20px;">
                                 <p style="font-size: 14px; margin-bottom: 0.2rem; color: rgb(61, 60, 60);"><b>Fit : </b></p>
                                 <p class="" style="font-size: 14px; margin-bottom: 0.8rem; margin-left:0.5rem; color: grey;">Modern Athletic Cut</p>
                             </div>

                             @php
                                 $sizetypeid = $product->size_id;
                                 $sizeNames = $size->where('size_type', $sizetypeid)->pluck('size_name')->toArray();
                             @endphp

                             <div style="margin-left: 20px;">
                                 <p style="font-size: 14px; margin-bottom: 0.2rem; color: rgb(61, 60, 60);"><b>Sizes : </b></p>
                                 <div class="size-cards">
                                     @foreach($sizeNames as $index => $sizeName)
                                         <input type="checkbox" id="checkboxSize{{ $index }}" name="sizes[]" value="{{ $sizeName}}">
                                         <label for="checkboxSize{{ $index }}">
                                             {{ $sizeName }}
                                         </label>
                                     @endforeach
                                 </div>
                             </div>

                             <div class="row" style="margin-left: 20px;">
                                 <img style="padding-top: 5px; height: 16px;" src="{{ asset('argon') }}/img/icons/customer_portal/rule.png" alt="">
                                 <p style="font-size: 14px; margin-bottom: 0.2rem; color: grey; padding-left: 15px;">View Size Chart</p>
                             </div>
                         </div>
                     </div>
                 </div>

             </div>
         </div>
     </div>
 </div> --}}
</div>
</div>

<script>
 function goToSlide(slideIndex) {
     var carousel = document.getElementById("carouselExample");
     var carouselInstance = bootstrap.Carousel.getInstance(carousel);
     carouselInstance.to(slideIndex);
 }

 function previousSlide() {
     var carousel = document.getElementById("carouselExample");
     var carouselInstance = bootstrap.Carousel.getInstance(carousel);
     var activeIndex = carouselInstance.getActiveIndex();
     var slidesCount = carouselInstance.getSlides().length;
     if (activeIndex > 0) {
         carouselInstance.to(activeIndex - 1);
     } else {
         carouselInstance.to(slidesCount - 1);
     }
 }

 function nextSlide() {
     var carousel = document.getElementById("carouselExample");
     var carouselInstance = bootstrap.Carousel.getInstance(carousel);
     var activeIndex = carouselInstance.getActiveIndex();
     if (activeIndex < carouselInstance.getSlides().length - 1) {
         carouselInstance.to(activeIndex + 1);
     } else {
         carouselInstance.to(0);
     }
 }
</script>




 {{-- <button class="scroll-to-top" id="copyButton"><i class="fa fa-clone" aria-hidden="true" title="Copy Page URL"></i></button> --}}


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

 <input type="hidden" id="productId" value="{{ $product->id }}">
 @if(isset($searchValue))
     <input type="hidden" id="searchValue" value="{{ $searchValue }}">
 @endif

<script>


 document.addEventListener("DOMContentLoaded", function () {
     const attributeTopic = document.getElementById("attribute-topic");
     if (attributeTopic) {
         attributeTopic.addEventListener("click", function () {
             document.querySelector(".attribute_content").classList.toggle("attribute_visible");
         });
     }

     // Description Topic
     const descriptionTopic1 = document.getElementById("description-topic");
        if (descriptionTopic1) {
            descriptionTopic1.addEventListener("click", function () {
                const descriptionContent = document.querySelector(".description_content");
                if (descriptionContent) {
                    descriptionContent.classList.toggle("description_visible");
                }
            });
        }

        // Made Topic
        const descriptionTopic2 = document.getElementById("made-topic");
        if (descriptionTopic2) {
            descriptionTopic2.addEventListener("click", function () {
                const descriptionContent = document.querySelector(".made_content");
                if (descriptionContent) {
                    descriptionContent.classList.toggle("made_visible");
                }
            });
        }

        // features Topic
        const descriptionTopic3 = document.getElementById("features-topic");
        if (descriptionTopic3) {
            descriptionTopic3.addEventListener("click", function () {
                const descriptionContent = document.querySelector(".features_content");
                if (descriptionContent) {
                    descriptionContent.classList.toggle("features_visible");
                }
            });
        }

     // Fit Topic
     const fitTopic = document.getElementById("fit-topic");
     if (fitTopic) {
         fitTopic.addEventListener("click", function () {
             const fitContent = document.querySelector(".fit_content");
             if (fitContent) {
                 fitContent.classList.toggle("fit_visible");
             }
         });
     }

     // Fabric Topic
     const fabricTopic = document.getElementById("fabric-topic");
     if (fabricTopic) {
         fabricTopic.addEventListener("click", function () {
             const fabricContent = document.querySelector(".fabric_content");
             if (fabricContent) {
                 fabricContent.classList.toggle("fabric_visible");
             }
         });
     }

     // File Donwload Topic
     const fileDownload = document.getElementById("file-download-topic");
     if (fileDownload) {
         fileDownload.addEventListener("click", function () {
             const fileDownloadContent = document.querySelector(".file_download_content");
             if (fileDownloadContent) {
                 fileDownloadContent.classList.toggle("file_download_visible");
             }
         });
     }
 });



 document.addEventListener('DOMContentLoaded', function () {
     const fabricOptions = document.querySelectorAll('.fabric-option');
     const colorInfoDiv = document.getElementById('colorInfo');

     fabricOptions.forEach(option => {
         option.addEventListener('click', function () {
             fabricOptions.forEach(opt => opt.classList.remove('active'));
             this.classList.add('active');

             const subProductId = this.getAttribute('data-subProduct-id');

             colorInfoDiv.innerHTML = '';
             colorInfoDiv.classList.add('display_hide');

             $.ajax({
                 url: "{{ route('filterEmbellishment') }}",
                 method: "GET",
                 data: {
                     subProductId: subProductId,
                 },
                 success: function (response) {
                     console.log(response);

                     const embellishmentTypeDiv = document.getElementById('embellishmentType');
                     const embellishmentTypeTopic = document.getElementById('embellishmentTypeTopic');

                     embellishmentTypeDiv.innerHTML = '';
                     embellishmentTypeDiv.classList.remove('display_hide');
                     embellishmentTypeTopic.classList.remove('display_hide');

                     if (response.relatedEmbellishments && response.relatedEmbellishments.length > 0) {
                         response.relatedEmbellishments.forEach(function (embellishment) {
                             // Create the main embellishment div for the name
                             const embellishmentDiv = document.createElement('div');
                             embellishmentDiv.className = 'fit_sections embellishment-option';
                             embellishmentDiv.style.marginRight = "7px";
                             embellishmentDiv.setAttribute('data-embellishmenttype-id', embellishment.id);

                             // Create the <span> for embellishment name
                             const embellishmentSpan = document.createElement('span');
                             embellishmentSpan.textContent = embellishment.embellishment_name;

                             // Append the <span> to the embellishment div
                             embellishmentDiv.appendChild(embellishmentSpan);

                             const embellishmentLink = document.createElement('a');

                             if (embellishment.description || embellishment.video_path) {
                             // Create the <a> element for the info icon
                                 embellishmentLink.href = "#";
                                 embellishmentLink.className = "sizing_link embellishment-info-link";
                                 embellishmentLink.setAttribute("data-embellishmenttype-id", embellishment.id);
                                 embellishmentLink.style.fontSize = "16px";
                                 embellishmentLink.style.paddingRight = "16px";

                                 // Create the <i> element for the info icon
                                 const embellishmentIcon = document.createElement('i');
                                 embellishmentIcon.className = "fas fa-circle-info info_icon";
                                 embellishmentLink.appendChild(embellishmentIcon);
                             }
                             // Now append both the div and the link as separate elements
                             embellishmentTypeDiv.appendChild(embellishmentDiv); // Append div first
                             embellishmentTypeDiv.appendChild(embellishmentLink); // Append link after div

                             // Add click event listener to the entire embellishment div
                             embellishmentDiv.addEventListener('click', function () {
                                 const embellishmentOptions = document.querySelectorAll('.embellishment-option');
                                 embellishmentOptions.forEach(opt => opt.classList.remove('active'));
                                 this.classList.add('active');

                                 const embellishmentName = this.querySelector('span').innerText;
                                 const colorTopic = document.getElementById('colorTopic');

                                 colorTopic.classList.remove('display_hide');

                                 if (embellishmentName === 'Sublimation') {
                                     colorInfoDiv.innerHTML = '<p style="font-size: 13px; color: rgb(95, 95, 95); font-weight: 500; margin-bottom: 0.2rem;">Customizable in any color</p>';
                                     colorInfoDiv.classList.remove('display_hide');
                                 } else {
                                     $.ajax({
                                         url: "{{ route('getColorDetails') }}",
                                         method: "GET",
                                         data: {
                                             subProductId: subProductId,
                                         },
                                         success: function (response) {
                                             console.log(response);

                                             colorInfoDiv.innerHTML = ''; // Clear previous colors

                                             if (response.relatedColors && response.relatedColors.length > 0) {
                                                 response.relatedColors.forEach(function (color) {
                                                     const colorDiv = document.createElement('div');
                                                     colorDiv.className = 'color_cercle';
                                                     colorDiv.style.backgroundColor = `#${color.hex}`;
                                                     colorDiv.title = color.pantone_code;
                                                     colorInfoDiv.appendChild(colorDiv);
                                                 });
                                                 colorInfoDiv.classList.remove('display_hide');
                                             } else {
                                                 colorInfoDiv.innerHTML = '<p style="font-size: 13px; color: rgb(95, 95, 95); font-weight: 500; margin-bottom: 0.2rem;">No colors have been added.</p>';
                                                 colorInfoDiv.classList.remove('display_hide');
                                             }
                                         },
                                         error: function (jqXHR, textStatus, errorThrown) {
                                             console.error("Error:", textStatus, errorThrown);
                                         }
                                     });
                                 }
                             });

                             // Add click event listener to the <a> element for info
                             embellishmentLink.addEventListener('click', function (event) {
                                 event.preventDefault();

                                 const selectedEmbellishmentId = this.getAttribute('data-embellishmenttype-id');

                                 $.ajax({
                                     url: "{{ route('getEmbellishmentDetails') }}",
                                     method: "GET",
                                     data: {
                                         selectedEmbellishmentId: selectedEmbellishmentId,
                                         subProductId: subProductId,
                                     },
                                     success: function (response) {
                                         console.log(response);

                                         const assetBaseUrl = "{{ asset('') }}";

                                         // Reset modal contents
                                         document.getElementById('relatedNameFabric').innerText = '';
                                         document.getElementById('relatedAttributeNameFabric').style.display = 'none';
                                         document.getElementById('relatedAttributeTextFabric').innerText = '';
                                         document.getElementById('relatedAttributeDescriptionFabric').style.display = 'none';
                                         document.getElementById('modalImageFabric').src = ''; // Clear image src

                                         if (response.embellishmentTypes) {
                                             // Display the embellishment name
                                             document.getElementById('relatedNameFabric').innerText = response.embellishmentTypes.embellishment_name || '';
                                             document.getElementById('relatedAttributeNameFabric').style.display = 'flex';

                                             // Display the embellishment description
                                             document.getElementById('relatedAttributeTextFabric').innerText = response.embellishmentTypes.description || '';
                                             document.getElementById('relatedAttributeDescriptionFabric').style.display = 'flex';

                                             // Set modal image source if available
                                             if (response.embellishmentTypes.video_path) {
                                                 document.getElementById('modalImageFabric').src = assetBaseUrl + response.embellishmentTypes.video_path;
                                             }

                                             // Open the modal
                                             $('#imageModalFabric').modal('show');
                                         }
                                     },
                                     error: function (jqXHR, textStatus, errorThrown) {
                                         console.error("Error:", textStatus, errorThrown);
                                     }
                                 });
                             });
                         });
                     } else {
                         embellishmentTypeDiv.innerHTML = '<div>No embellishments found.</div>';
                     }
                 },
                 error: function (jqXHR, textStatus, errorThrown) {
                     console.error("Error:", textStatus, errorThrown);
                 }
             });
         });
     });
 });

 document.addEventListener('DOMContentLoaded', function () {
     const fabricOptions = document.querySelectorAll('.fabric-option');
     const fabricInfoLink = document.getElementById('fabricInfoLink');
     let selectedFabricId = null;

     fabricOptions.forEach(option => {
         option.addEventListener('click', function () {
             fabricOptions.forEach(opt => opt.classList.remove('active'));
             this.classList.add('active');

             const fabricName = this.querySelector('span').innerText;
             // fabricInfoLink.innerText = `About ${fabricName}`;
             // fabricInfoLink.innerHTML = '<i class="fa fas fa-circle-info info_icon"></i>';


             // Store selected fabric ID for use when fabricInfoLink is clicked
             selectedFabricId = this.getAttribute('data-subProduct-id');
         });
     });

     // Add event listener to fabricInfoLink
     const fabricInfoLinks = document.querySelectorAll('.fabricInfoLink');

     fabricInfoLinks.forEach(link => {
         link.addEventListener('click', function (event) {
             event.preventDefault(); // Prevent default link behavior

             const subProductId = this.getAttribute('data-subProduct-id');

             // Make an AJAX call to fetch fabric details
             $.ajax({
                 url: "{{ route('getFabricDetails') }}",
                 method: "GET",
                 data: {
                     subProductId: subProductId
                 },
                 success: function (response) {
                     console.log(response);

                     const assetBaseUrl = "{{ asset('') }}";

                     // Reset modal contents before loading new data
                     document.getElementById('relatedNameFabric').innerText = '';
                     document.getElementById('relatedAttributeNameFabric').style.display = 'none';
                     document.getElementById('relatedAttributeTextFabric').innerText = '';
                     document.getElementById('relatedAttributeDescriptionFabric').style.display = 'none';
                     document.getElementById('modalImageFabric').src = ''; // Clear image src

                     // Populate modal with the retrieved fabric details
                     if (response.subProduct && response.subProduct.fabric) {
                         // Display the fabric name
                         document.getElementById('relatedNameFabric').innerText = response.subProduct.fabric.fabric_name || '';
                         document.getElementById('relatedAttributeNameFabric').style.display = 'flex';

                         // Display the fabric description or any additional data
                         document.getElementById('relatedAttributeTextFabric').innerText = response.subProduct.fabric.description || '';
                         document.getElementById('relatedAttributeDescriptionFabric').style.display = 'flex';

                         // Set modal image source if available
                         if (response.subProduct.fabric.image_1) {
                             document.getElementById('modalImageFabric').src = assetBaseUrl + response.subProduct.fabric.image_1;
                         }

                         // Open the modal
                         $('#imageModalFabric').modal('show');
                     } else {
                         alert('Fabric details not available.');
                     }
                 },
                 error: function (jqXHR, textStatus, errorThrown) {
                     console.error("Error:", textStatus, errorThrown);
                 }
             });
         });
     });
 });



 document.addEventListener('DOMContentLoaded', function () {
     const fabricOptions = document.querySelectorAll('.fabric-option');
     const fabricInfoLink = document.getElementById('fabricInfoLink');
     let selectedFabricId = null;

     fabricOptions.forEach(option => {
         option.addEventListener('click', function () {
             fabricOptions.forEach(opt => opt.classList.remove('active'));
             this.classList.add('active');

             const fabricName = this.querySelector('span').innerText;
             // fabricInfoLink.innerText = `About ${fabricName}`;
             // fabricInfoLink.innerHTML = '<i class="fa fas fa-circle-info info_icon"></i>';


             // Store selected fabric ID for use when fabricInfoLink is clicked
             selectedFabricId = this.getAttribute('data-subProduct-id');
         });
     });

     // Add event listener to fabricInfoLink
     const fabricInfoLinks = document.querySelectorAll('.fabricInfoLink');

 fabricInfoLinks.forEach(link => {
     link.addEventListener('click', function (event) {
         event.preventDefault(); // Prevent default link behavior

         const subProductId = this.getAttribute('data-subProduct-id');

         // Make an AJAX call to fetch fabric details
         $.ajax({
             url: "{{ route('getFabricDetails') }}",
             method: "GET",
             data: {
                 subProductId: subProductId
             },
             success: function (response) {
                 console.log(response);

                 const assetBaseUrl = "{{ asset('') }}";

                 // Reset modal contents before loading new data
                 document.getElementById('relatedNameFabric').innerText = '';
                 document.getElementById('relatedAttributeNameFabric').style.display = 'none';
                 document.getElementById('relatedAttributeTextFabric').innerText = '';
                 document.getElementById('relatedAttributeDescriptionFabric').style.display = 'none';
                 document.getElementById('modalImageFabric').src = ''; // Clear image src

                 // Populate modal with the retrieved fabric details
                 if (response.subProduct && response.subProduct.fabric) {
                     // Display the fabric name
                     document.getElementById('relatedNameFabric').innerText = response.subProduct.fabric.fabric_name || '';
                     document.getElementById('relatedAttributeNameFabric').style.display = 'flex';

                     // Display the fabric description or any additional data
                     document.getElementById('relatedAttributeTextFabric').innerText = response.subProduct.fabric.description || '';
                     document.getElementById('relatedAttributeDescriptionFabric').style.display = 'flex';

                     // Set modal image source if available
                     if (response.subProduct.fabric.image_1) {
                         document.getElementById('modalImageFabric').src = assetBaseUrl + response.subProduct.fabric.image_1;
                     }

                     // Open the modal
                     $('#imageModalFabric').modal('show');
                 } else {
                     alert('Fabric details not available.');
                 }
             },
             error: function (jqXHR, textStatus, errorThrown) {
                 console.error("Error:", textStatus, errorThrown);
             }
         });
     });
 });
 });


 $(document).ready(function() {
     $('.tagline_details').on('click', function() {
         var taglineId = $(this).data('value');

         $.ajax({
             url: "{{ route('getTaglineDetails') }}",
             type: "GET",
             data: {
                 taglineId: taglineId
             },
             success: function(response) {
                 console.log(response);
                 $('#relatedNameTagline').text(response.productTaglines.tagline_name || "");
                 $('#relatedTextTagline').text(response.productTaglines.description || "");

                 if (response.productTaglines.video_path) {
                     // Update the source on the <source> tag inside the <video> element
                     $('#modalVideoTagline source').attr('src', "{{ asset('') }}/" + response.productTaglines.video_path);
                     $('#modalVideoTagline')[0].load();  // Reload the video to apply the new source
                     $('#modalVideoTagline').show();
                 } else {
                     $('#modalVideoTagline').hide();
                 }

                 $('#videoModalTagline').modal('show');
             },
             error: function(xhr) {
                 console.error("An error occurred: " + xhr.responseText);
             }
         });
     });

     // Clear the video source when the modal is hidden
     $('#videoModalTagline').on('hidden.bs.modal', function () {
         $('#modalVideoTagline source').attr('src', '');  // Clear the <source> src
         $('#modalVideoTagline')[0].load();  // Reload the video to remove the previous source
     });
 });





</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>


{{-- <script>
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
</script> --}}


 <script>
     $(document).ready(function() {
         // Click event for the cart icon
         $('#cartDropdown').click(function(e) {
             e.preventDefault();

             // Toggle the dropdown menu
             $(this).next('.dropdown-menu').toggleClass('show');
         });
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


</script>


 <script>
     buttontext();
     function buttontext() {

         findQuotesCount();
         var userId = document.getElementById('userId').value;
         console.log(userId);
         var productId = $('#productId').val();
         //console.log(userId);
         //console.log(productId);

         // Send an AJAX request to the server
         $.ajax({
         url: "{{ route('buttontext') }}",
         method: "GET",
         data: {
             user_id: userId,
             product_id: productId,
                 },
         success: function(response) {

             var button = document.getElementById('filterButton_call');

             if(response.message_exist){
                 //console.log(response.message_exist);
                 button.innerText = 'REMOVE FROM INQUIRY';
             }else{
                 button.innerText = 'ADD TO INQUIRY';
             };

         },
         error: function(jqXHR, textStatus, errorThrown) {
             console.error("Error:", textStatus, errorThrown);
         }
         });
     }

     function toggleQuote(productId) {
         var button = document.getElementById('filterButton_call');

         if (button.innerText === 'ADD TO INQUIRY') {

             addToQuote(productId); // Call your add_to_quote function

         }
         if(button.innerText === 'REMOVE FROM INQUIRY') {

             removeFromQuote(productId); // Call your remove_from_quote function
         }
     }

     function addToQuote(productId) {
         var userId = document.getElementById('userId').value;
         //console.log(userId);
         //console.log(productId);

         // Send an AJAX request to the server
         $.ajax({
         url: "{{ route('product_addto_quotes') }}",
         method: "GET",
         data: {
             user_id: userId,
             product_id: productId,
                 },
         success: function(response) {

             var button = document.getElementById('filterButton_call');

             if(response.message_success){
                 console.log(response.message_success);
                 button.innerText = 'REMOVE FROM INQUIRY';
             };
             if(response.message_exist){
                 console.log(response.message_exist);
             };
             findQuotesCount();
             view_user_quotes();

         },
         error: function(jqXHR, textStatus, errorThrown) {
             console.error("Error:", textStatus, errorThrown);
         }
         });
     }

     function removeFromQuote(productId) {

         var userId = document.getElementById('userId').value;

         // Send an AJAX request to the server
         $.ajax({
         url: "{{ route('product_removefrom_quotes') }}",
         method: "GET",
         data: {
             user_id: userId,
             product_id: productId,
                 },
         success: function(response) {

             var button = document.getElementById('filterButton_call');

             findQuotesCount();
             view_user_quotes();

             if(response.message_notfound){
                 console.log(response.message_notfound);
             };

             if(response.message_remove){
                 console.log(response.message_remove);
                 button.innerText = 'ADD TO INQUIRY';
             }

         },
         error: function(jqXHR, textStatus, errorThrown) {
             console.error("Error:", textStatus, errorThrown);
         }
         });
     }

     view_user_quotes();

     function view_user_quotes() {

         var userId = document.getElementById('userId').value;

         var subtotal=0;

         // Send an AJAX request to the server
         $.ajax({
         url: "{{ route('view_user_quotes') }}",
         method: "GET",
         data: {
             user_id: userId,
                 },
         success: function(response) {

             //console.log(response.quotes)

             //console.log(response.products)

             var item = response.products;

             var cartItemsHtml = '';

         // Iterate over each cart item and generate the HTML
         item.forEach(function(item) {

             var imageURL = 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg?20200913095930';

             //console.log(imageURL);

             if (item.mockup_img_1) {
             imageURL = item.mockup_img_1;
             //console.log(imageURL);
             }

             subtotal = parseInt(subtotal) + parseInt(item.default_price);
             //console.log(subtotal);

             cartItemsHtml += '<div class="row">' +
             '<div class="col-lg-3">' +
             '<img src="' + imageURL+ '" alt="Item Image" style="height: 80px; width: 80px;margin: 15%;">' +
             '</div>' +
             '<div class="col-lg-7" style="margin-top: 3%">' +
             '<span style="color: grey;font-size: 16px;display: table-row;">' + item.product_name + '</span>' +
             '<span style="color: black;padding: 1%;font-size: 15px;">$ ' + item.default_price + '</span>' +
             '</div>' +
             '<div class="col-lg-2">' +
             '<button style="background: none;border: none;outline: unset;cursor: pointer;position: relative;top: 8%;"><i class="fa fa-trash" aria-hidden="true" style="color: black;" onclick="deleteRecord('+item.id+')"></i></button>' +
             '</div>' +
             '</div>' +
             '<div class="dropdown-divider"></div>';
         });



         $('#totalvalue').text(subtotal+'.00');

         // Update the HTML of the cart items section
         $('#dropdown-menu-content').html(cartItemsHtml);

         },
         error: function(jqXHR, textStatus, errorThrown) {
             console.error("Error:", textStatus, errorThrown);
         }
         });
     }

     function findQuotesCount() {

     var userId = document.getElementById('userId').value;

     // Send an AJAX request to the server
     $.ajax({
     url: "{{ route('count_records') }}",
     method: "GET",
     data: {
         user_id: userId,
             },
     success: function(response) {

         var count = response.count;
         //console.log(count);
         $('#quoteCountBadge').text(count);

         var generateQuoteCount = document.querySelector("#generateQotecount");

         //console.log(generateQuoteCount);

         generateQuoteCount.textContent = count;

     },
     error: function(jqXHR, textStatus, errorThrown) {
         console.error("Error:", textStatus, errorThrown);
     }
     });
     }
 </script>
 <script>
         // Image selecting functions

         var carousel_Default = document.getElementById('crouselDefault');
         var thumbnail_Default = document.getElementById('defaultThumbnail');
         var carousel_Lifestyle = document.getElementById('crouselLifestyle');
         var thumbnail_Lifestyle = document.getElementById('lifestyleThumbnail');
         var carousel_3D = document.getElementById('crousel3D');
         var thumbnail_3D = document.getElementById('3DThumbnail');
         var imageTextElement = document.getElementById('imageText');
         var carousel_DefaultContent = carousel_Default.innerHTML;
         var thumbnail_DefaultContent = thumbnail_Default.innerHTML;
         var carousel_LifestyleContent = carousel_Lifestyle.innerHTML;
         var thumbnail_LifestyleContent = thumbnail_Lifestyle.innerHTML;
         var carousel_3DContent = carousel_3D.innerHTML;
         var thumbnail_3DContent = thumbnail_3D.innerHTML;
         var contentArray = [];
         var clickedImage = 'default';

         contentArray.push(carousel_DefaultContent, thumbnail_DefaultContent, carousel_LifestyleContent, thumbnail_LifestyleContent, carousel_3DContent, thumbnail_3DContent);

         clickImage('default');

         function clickImage(clickedInputImage){

             var clickedInputImage = clickedInputImage;

             if( clickedImage == clickedInputImage){
                 clickedImage = 'default';
             }else{
                 clickedImage = clickedInputImage;
             }

         if(clickedImage == 'lifestyle'){
             //console.log(contentArray);
             carousel_Default.innerHTML = '';
             thumbnail_Default.innerHTML = '';
             carousel_3D.innerHTML = '';
             thumbnail_3D.innerHTML = '';

             carousel_Lifestyle.innerHTML = contentArray[2];
             thumbnail_Lifestyle.innerHTML = contentArray[3];
             imageTextElement.textContent = 'Lifestyle';
             document.getElementById('3DLable').style.border = 'none';
             document.getElementById('lifestyleLable').style.border = '3px solid black';
         }
         if(clickedImage == 'default'){
             //console.log(contentArray);
                 carousel_Lifestyle.innerHTML = '';
                 thumbnail_Lifestyle.innerHTML = '';
                 carousel_3D.innerHTML = '';
                 thumbnail_3D.innerHTML = '';

                 carousel_Default.innerHTML = contentArray[0];
                 thumbnail_Default.innerHTML = contentArray[1];
                 imageTextElement.textContent = 'Default';
                 document.getElementById('lifestyleLable').style.border = 'none';
                 document.getElementById('3DLable').style.border = 'none';
         }
         if(clickedImage == '3D'){
             //console.log(contentArray);
                 carousel_Lifestyle.innerHTML = '';
                 thumbnail_Lifestyle.innerHTML = '';
                 carousel_Default.innerHTML = '';
                 thumbnail_Default.innerHTML = '';

                 carousel_3D.innerHTML = contentArray[4];
                 thumbnail_3D.innerHTML = contentArray[5];
                 imageTextElement.textContent = '3D image';
                 document.getElementById('lifestyleLable').style.border = 'none';
                 document.getElementById('3DLable').style.border = '3px solid black';
         }

         }
 </script>
 <script>
     function goToSlide(slideIndex) {
     $('.thumbnail').removeClass('active');
     $('.thumbnail').eq(slideIndex).addClass('active');
     $('#carouselExample').carousel(slideIndex);
     }

 </script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 <script>
     function deleteRecord(itemId) {
             var itemId = itemId;
             Swal.fire({
                 title: 'Delete Confirmation',
                 text: 'Do you want to delete this record?',
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#d33',
                 cancelButtonColor: '#6c757d',
                 confirmButtonText: 'Delete'
             }).then((result) => {
                 if (result.isConfirmed) {
                     //console.log(itemId);
                     removeFromQuote(itemId);
                 }
             });
         }
 </script>


@endsection
