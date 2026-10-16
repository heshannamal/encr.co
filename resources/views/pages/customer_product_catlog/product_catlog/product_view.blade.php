@extends('layouts.customer_portal.app')

@section('content')

    <style>

    @media only screen and (min-width: 320px) and (max-width: 421px )
    {
        .hide-icon{
            display: none;
        }
        .image_width_logo{
            width: -webkit-fill-available;
            height: 85px;
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
            padding-top: 190px !important;
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
            padding-top: 200px !important;
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
    /* .fit_visible{
        display: none;
    } */
    .product_details_visible{
        display: none;
    }
    .attribute_visible{
        display: none;
    }
    .embellishment_visible{
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
    font-weight: 500;
    font-size: 24px;
    text-align: right;
    /* margin-top: 1rem; */
    }
    .navbar {
        background-color: white;
        padding: 10px;
        width: 100%;
        /* position: fixed; */
        z-index: 1000;
        padding-top: unset;
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
    .navbar {
        position: fixed;
    }
    .container_style {
        padding-top: 100px;
        /* margin-left: 29px;
        margin-right: 37px; */
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
        padding-left: 25px;
        padding-right: 25px;
    }
    .details_div_style2 {
        padding: 10px 0px;
        padding-bottom: 20px;
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
    font-size: 0.7rem; /* smaller text */
    padding: 0.4rem 0.5rem; /* reduce padding */
    border: 1px solid rgb(233, 233, 233);
    border-radius: 5px;
    margin-right: 8px;
    /* margin-bottom: 8px; */
    /* width: 12%; smaller width */
    text-align: center;
    background-color: rgb(237 241 246 / var(--tw-bg-opacity, 1));
    color: rgb(55 65 81 / var(--tw-text-opacity, 1));
    font-weight: 500;
    line-height: 1rem;
    cursor: default;
}
/* Header layout */
.fit-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 12px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.fit-divider {
    width: 100%;
    height: 1px;
    background-color: #e5e5e5;
    margin: 10px 25px;
}
.fit-section {
    margin-bottom: 20px;
}

.fit-row {
    display: flex;
    align-items: center;
    gap: 8px;
    /* margin-bottom: 8px; */
}

.fit-label {
    /* font-weight: 600; */
    color: #222;
}

.fit-link {
    margin-left: auto;
    font-size: 13px;
    color: #222;
    text-decoration: none;
}
.fit-sizes {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    padding-left: 16px; /* aligns under label */
}

.fit-sizes span {
    font-size: 13px;
    color: #555;
}

.fit-track {
    position: relative;
    height: 8px;
    background: #e5e5e5;
    border-radius: 4px;
    margin: 12px 0;
}
/* Static dots (start, center, end) */
.fit-dot-point {
    position: absolute;
    top: 50%;
    width: 9px;
    height: 9px;
    background: #ffffff;          /* white center */
    border: 2px solid #bdbdbd;    /* gray border */
    border-radius: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
}

.fit-dot-point.start {
    left: 0%;
}

.fit-dot-point.center {
    left: 50%;
}

.fit-dot-point.end {
    left: 100%;
}

/* Moving indicator */
.fit-indicator {
    position: absolute;
    top: -1px;
    width: 10%;
    height: 8px;
    background: #1f2937;
    border-radius: 8px;
}
.fit-indicator {
    transition: left 0.3s ease;
}

.fit-scale {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #666;
}

.fit-scale .center {
    text-align: center;
}
.fit-dot {
    width: 8px;
    height: 8px;
    background-color: #111;
    border-radius: 50%;
}

.fit-dot.invisible {
    visibility: hidden;
}


/* Title */
.fit-header h2 {
    font-size: 16px;
    font-weight: 500;
    color: #111;
}

/* Toggle icon */
.fit-toggle i {
    font-size: 14px;
    transition: transform 0.25s ease;
    color: #111;
}

/* Rotate arrow when open */
.fit-header.open .fit-toggle i {
    transform: rotate(180deg);
}

/* Content animation */
.fit_content {
    overflow: hidden;
    transition: max-height 0.35s ease, opacity 0.25s ease;
}

/* Closed state */
.fit_content.collapsed {
    max-height: 0;
    opacity: 0;
    padding-top: 0;
}

/* Open state */
.fit_content.fit_visible {
    max-height: 1000px;
    opacity: 1;
}

    .fit_sections:hover {
        background-color: #f1f5f9;
        /* border-color: #cbd5e1; */
        transform: scale(1.05);
    }
    /* .fit_sections.active {
        border: 1px solid rgb(124, 124, 124);
    } */
    .size_tag {
        font-size: 13px;
        color: white;
        padding: 8px 15px;
        background-color: #333f48;
        border-radius: 20px;
    }
    .size_tag:hover {
        font-size: 13px;
        color: white;
        padding: 8px 15px;
        background-color: #556b8a;
        border-radius: 20px;
        padding-left: 18px;
        padding-right: 12px;
        text-decoration: unset !important;
    }
    .sizing_link:hover {
        text-decoration: underline;
    }
    .description_content p span, .made_content p span, .features_content p span {
        font-family: 'Quicksand', sans-serif;
        font-size: 12px;
        word-wrap: break-word;
        text-align: justify;
        color: #283039;
    }
    .description_content ul li, .made_content ul li, .features_content ul li {
        font-family: 'Quicksand', sans-serif;
        font-size: 12px;
        word-wrap: break-word;
        text-align: justify;
        color: #283039;
        font-weight: 100 !important;
    }
    .description_content p, .made_content p, .features_content p {
        font-family: 'Quicksand', sans-serif;
        font-size: 12px;
        word-wrap: break-word;
        text-align: justify;
        color: #283039;
        font-weight: 100 !important;
    }
    .description_content p strong, .made_content p strong, .features_content p strong {
        font-size: 12px;
        font-weight: 100 !important;
    }
    .description_content {
        padding-top: 0px;
    }
    .fit_content p span {
        font-size: 12px;
        color: gray !important;
    }
    .fit_content p {
        color: rgb(55 65 81 / var(--tw-text-opacity, 1)) !important;
        font-weight: 500 !important;
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
    }
    .cursor_pointer {
        cursor: pointer;
    }
    .display_hide {
        display: none !important;
    }
    .image_modal_css {
        background-color: #ffffff;
    }
    .next_button {
        background-color: rgba(185, 185, 185, 0.85);
        border: unset;
        box-shadow: unset;
        font-size: 20px;
        color: white;
    }
    .next_button:hover {
        /* background-color: transparent; */
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
        height: 6px;
        background: linear-gradient(90deg, #051220, #2d425a, #a5bcd6);
        display: flex;
        justify-content: space-between;
    }

    .horizontal-line::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(90deg, #051220, #2d425a, #a5bcd6);
    }

    .vertical-line {
        position: absolute;
        top: -10px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: white;
        border: 2px solid #2a2f39;
        cursor: grab;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    /* Positioning for labels */
    .label-left, .label-right {
        position: absolute;
        font-size: 12px;
        color: rgb(107 114 128 / var(--tw-text-opacity, 1));
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
        color: color: rgb(107 114 128 / var(--tw-text-opacity, 1));;
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
    .image_modal_css {
        width: 100%;
        max-width: 100%;
    }

.hover-image-section {
    position: relative;
    display: inline-block;
    width: 100%;
    max-width: 500px; /* Adjust as needed */
}

.hover-image-section {
    position: relative;
    width: 100%;
    max-width: 500px;
    height: auto;
}

.hover-image-section::before {
    content: "";
    display: block;
    padding-top: 55%; /* Maintain aspect ratio (1:1 square). Adjust as needed */
}

.hover-image-section img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    /* Fill the container */
    object-fit: cover;
    transition: opacity 0.3s ease;
}

.img-main {
    z-index: 2;
    opacity: 1;
    border-radius: 10px;
}

.img-hover {
    z-index: 1;
    opacity: 0;
    border-radius: 10px;
}

.hover-image-section:hover .img-main {
    opacity: 0;
}

.hover-image-section:hover .img-hover {
    opacity: 1;
}
.fabric-overlay-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 0, 0, 0.5); /* black with 0.5 opacity */
    color: white;
    padding: 8px 16px;
    font-size: 20px;
    border-radius: 6px;
    z-index: 3;
    pointer-events: none;
}
.color-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    display: inline-block;
    /* width: 56px; */
}

.color-swatch {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    border: 1px solid #ccc;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
}

.color-label {
    font-size: 12px;
    margin-top: 5px;
    font-weight: 500;
    position: absolute;
    left: 20px; /* 👉 dakunu paththa */
    top: 50%;
    transform: translateY(-50%);
    font-size: 12px;
    color: #555;
    white-space: nowrap;
    z-index: 1;
    opacity: 0;
    visibility: hidden;
    transition: 0.2s ease;
}
.color-label {
    background: #9c9c9c;
    color: #fff;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 11px;
}
.color-option:hover .color-label {
    opacity: 1;
    visibility: visible;
}
.embellishment-pill {
    background-color: #e5e5e5;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 10px;
    color: #000;
    font-weight: 500;
    white-space: nowrap;
    margin: 3px;
}
#imageModalFabric strong{
        font-weight: 600 !important;
}
#embellishmentHoverModal strong{
        font-weight: 600 !important;
}
.hover-zoom {
    transition: transform 0.1s ease;
}

.hover-zoom.zoomed {
    transform: scale(1.4);
    z-index: 2;
}
.fabric-pill {
    background-color: #f1f1f1;
    border-radius: 25px;
    padding: 6px 14px;
    font-size: 13px;
}
.image-section2 {
    position: relative;
    width: 100%;
    max-width: 500px; /* Set a max width if needed */
    aspect-ratio: 1.1; /* Maintains consistent height based on width */
    overflow: hidden;
}

.hover-image {
    position: absolute;
    border-radius: 10px;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 1;
    transform: scale(1);
    transition: opacity 0.6s ease;
    z-index: 1;
}
@keyframes zoomInFade {
    0% {
        opacity: 0;
        transform: scale(1);
    }
    100% {
        opacity: 1;
        transform: scale(1.2);
    }
}

.animate-zoom-in {
    animation: zoomInFade 0.4s ease-in-out;
}
.product_name_txt {
    color: rgb(30 27 75 / var(--tw-text-opacity, 1));
    /* font-family: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif; */
    font-size: 2.25rem;
    line-height: 2.5rem;
}
.body_class {
    /* background-color: rgb(247 246 243 / var(--tw-bg-opacity, 1)) !important; */
    /* font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; */
    font-family: var(--default-font-family, ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji");
}
.sweep-btn {
    padding: 10px 24px;
    background-color: #333f48;
    color: white;
    border-radius: 0.35rem;
    width: 100%;
    height: 50px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    position: relative;
    overflow: hidden;
    padding-bottom: 8px;
}
.sweep-btn i {
    transition: color 0.3s ease;
  }
  .sweep-btn:hover {
    background-color: #1b2226;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  }
  .sweep-btn:hover i {
    color: #00c853;
  }
  .sweep-btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: -75%;
    width: 50%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(58,107,138,0.3), transparent);
    transform: skewX(-20deg);
    pointer-events: none;
  }
  .sweep-btn:hover::before {
    animation: sweep 1.4s ease-in-out alternate 2;
  }
  @keyframes sweep {
    0%   { left: -75%; }
    100% { left: 125%; }
  }
  .en-section-header:hover::before {
    animation: sweep 0.7s ease-out forwards;
    }
    @keyframes sweep {
        0% {
            left: -75%;
        }
        100% {
            left: 130%;
        }
    }
    .en-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    user-select: none;
    padding: 0.5rem 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 1);
    /* margin-bottom: 1rem; */
    border-radius: 8px;
    /* padding-left: 8px; */
    border: 1px solid #ffffffff;
    background-color: #ffffffff;
    color: #ffffffff;
    font-weight: 500;
    position: relative;
    overflow: hidden;
    transition: background-color 0.3s ease;
    padding-left: unset;
    padding-bottom: unset;
    }

    .en-section-header::before {
    content: "";
    position: absolute;
    top: 0;
    left: -75%;
    width: 50%;
    height: 100%;
    background: linear-gradient(
        120deg,
        rgba(173, 216, 230, 0.1) 0%,
        rgba(173, 216, 230, 0.4) 50%,
        rgba(173, 216, 230, 0.1) 100%
    );
    transform: skewX(-20deg);
    pointer-events: none;
    }

    .en-section-header:hover::before {
    animation: sweep 0.7s ease-out forwards;
    }
    .en-hr-gradient {
        border: 0;
        height: 1px;
        background: linear-gradient(90deg, #0D2C54, #a2b9d2, #a2b9d2,#ffffff );
      }

    .en-hr-gradient1 {
        border: 0;
        height: 1px;
        background: linear-gradient(90deg, #183157, #1E4068, #1E4068,#183157 );
      }

      .en-section-2 .en-hr-gradient {
        background: linear-gradient(90deg, #0D2C54, #5C6B7E, #ffffff);
      }

      .en-section-3 .en-hr-gradient {
        background: linear-gradient(90deg, #5C6B7E, #8E9CB3, #ffffff);
      }

      .en-section-4 .en-hr-gradient {
        background: linear-gradient(90deg, #8E9CB3, #B8C6D9, #ffffff);
      }

      .en-section-5 .en-hr-gradient {
        background: linear-gradient(90deg, #8E9CB3, #B8C6D9, #ffffff);
      }
      .en-fabric-name-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
      }

      .en-fabric-btn,
      .en-embellish-btn {
        border: 2px solid var(--en-primary-dark);
        background-color: white;
        color: var(--en-primary-dark);
        border-radius: 0.75rem;
        /* width: 12rem; */
        padding: 0.5rem 0.8rem;
        text-align: left;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        background-color: white;
        color: var(--en-title-color);
        border-radius: 0.5rem;
        border: 1px solid #dbdbdbff;
        transition: all 0.3s ease;
        cursor: pointer;
        transform: translateY(-2px);
        font-size: 16px;
        /* margin-bottom: 10px; */
        margin-right: 10px;
        padding-bottom: 7px;
      }

      .en-section-2 .en-fabric-btn,
      .en-section-2 .en-embellish-btn {
        border-color: var(--en-primary-medium);
        color: var(--en-primary-medium);
      }

      .en-section-3 .en-fabric-btn,
      .en-section-3 .en-embellish-btn {
        border-color: var(--en-primary-light);
        color: var(--en-primary-light);
      }

      .en-section-4 .en-fabric-btn,
      .en-section-4 .en-embellish-btn {
        border-color: var(--en-primary-verylight);
        color: var(--en-primary-verylight);
      }
      .en-section-5 .en-fabric-btn,
      .en-section-5 .en-embellish-btn {
        border-color: var(--en-primary-verylight);
        color: var(--en-primary-verylight);
      }

      @media (max-width: 768px) {
        /* .en-fabric-btn,
        .en-embellish-btn {
          width: 100%;
        } */
      }
      /* .en-embellish-btn:hover,
      .en-embellish-btn.en-selected {
        background-color: #333f48;
        color: white;
      } */
      /* .fabricInfoLink:hover {
        background-color: #333f48;
        color: white;
        } */

        .en-embellish-btn:hover,
        .en-fabric-btn:hover {
            border: 1px solid black;
            transform: scale(1.05);
        }

      .en-section-2 .en-fabric-btn:hover,
      .en-section-2 .en-fabric-btn.en-selected,
      .en-section-2 .en-embellish-btn:hover,
      .en-section-2 .en-embellish-btn.en-selected {
        background-color: var(--en-primary-medium);
      }

      .en-section-3 .en-fabric-btn:hover,
      .en-section-3 .en-fabric-btn.en-selected,
      .en-section-3 .en-embellish-btn:hover,
      .en-section-3 .en-embellish-btn.en-selected {
        background-color: var(--en-primary-light);
      }

      .en-section-4 .en-fabric-btn:hover,
      .en-section-4 .en-fabric-btn.en-selected,
      .en-section-4 .en-embellish-btn:hover,
      .en-section-4 .en-embellish-btn.en-selected {
        background-color: var(--en-primary-verylight);
      }

      .en-section-5 .en-fabric-btn:hover,
      .en-section-5 .en-fabric-btn.en-selected,
      .en-section-5 .en-embellish-btn:hover,
      .en-section-5 .en-embellish-btn.en-selected {
        background-color: var(--en-primary-verylight);
      }

      .en-fabric-icon,
      .en-embellish-icon {
        position: absolute;

        right:  29px;
        width: 0px;
        height:  10px;
        display: none;
        color: white;
      }

      .en-fabric-btn:hover .en-fabric-icon,
      .en-fabric-btn.en-selected .en-fabric-icon,
      .en-embellish-btn:hover .en-embellish-icon,
      .en-embellish-btn.en-selected .en-embellish-icon {
        display: block;
      }
.en-fabric-details,
      .en-embellish-details {
        display: none;
        font-size: 0.75rem;
        color: var(--en-subtext-color);
        margin-top: 0.25rem;
  cursor: pointer;
  user-select: none;
      }

.en-fabric-details:hover {
  text-decoration: underline;
  color: var(--en-primary-verylight);
  cursor: pointer;
  user-select: none;

}


      .en-fabric-btn:hover .en-fabric-details,
      .en-fabric-btn.en-selected .en-fabric-details,
      .en-embellish-btn:hover .en-embellish-details,
      .en-embellish-btn.en-selected .en-embellish-details {
        display: block;
      }


      .en-fabric-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        cursor: pointer;
        user-select: none;
        margin-bottom: 7px;
      }

      @media (min-width: 768px) {
        .en-fabric-option {
          width: auto;
        }
      }

      .en-fabric-option input[type="radio"] {
        accent-color: var(--en-primary-dark);
        width: 18px;
        height: 18px;
        cursor: pointer;
      }

      .en-section-2 .en-fabric-option input[type="radio"] {
        accent-color: var(--en-primary-medium);
      }

      .en-section-3 .en-fabric-option input[type="radio"] {
        accent-color: var(--en-primary-light);
      }

      .en-section-4 .en-fabric-option input[type="radio"] {
        accent-color: var(--en-primary-verylight);
      }

      .en-section-5 .en-fabric-option input[type="radio"] {
        accent-color: var(--en-primary-verylight);
      }

      .en-fabric-name-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
      }

      .en-embellishment-section {
        display: none;
      }
      .en-fabric-details {
        display: none;
        }
        .en-section-container {
            /* padding: 20px;
            border-top: 4px solid rgba(145, 165, 255, 0.1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px; */
        }
        .en-fit-scale {
            background: linear-gradient(90deg, #051220, #2d425a, #a5bcd6);
            height: 8px;
            border-radius: 4px;
            position: relative;
            margin: 12px 0;
        }
        .description_text {
            font-family: 'Quicksand', sans-serif;
            font-size: 12px;
            word-wrap: break-word;
            text-align: justify;
            color: #283039;
        }
        .description_text ul {
            list-style: disc;
            padding-left: 20px;
        }

        .thumb-img {
            border: 2px solid transparent;
            transition: border 0.2s;
        }

        .thumb-img:hover {
            border-color: #333;
        }

        .main-image-container {
            /* height: 500px; */
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            /* padding-bottom: 15px; */
            border-radius: 5px !important;
        }

        .main-image-container img {
            object-fit: contain;
            max-height: 100%;
        }
        .thumb-img {
            border: 2px solid transparent;
            transition: border 0.2s;
        }

        .thumb-img:hover {
            border-color: #888;
        }

        .thumb-img.active {
            border-color: #333;
        }
        .pause_button_color {
            background-color: transparent;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            border-radius: 50%;
            padding: .3rem .6rem !important;
            color: #333F48;
            font-size: 12px;
        }
        .pause_button_color:hover {
            background-color: #677987;
            border: 1px solid white;
        }
        .product_number_onImage {
            background-color: #333f48 !important;
            color: white;
            padding: 6px 12px;
            border-radius: 13px;
            font-size: 12px;
        }
        .padding_unset {
            padding: unset;
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
.breadcrumb-wrapper {
    width: 100%;
    padding: 12px 0;
    border-bottom: 1px solid #e5e5e5;
    margin-bottom: 20px;
    padding-left: 60px;
}

.breadcrumb-nav {
    font-size: 14px;
    color: #3e3e3e;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
    font-weight: 500;
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
    color: #3e3e3e;
    font-size: 12px;
    font-weight: 400;
}

/* Mobile */
@media (max-width: 768px) {
    .breadcrumb-nav {
        font-size: 12px;
    }
}
/* Main container already exists */
.en-section-container {
    background: #fff;
    border-radius: 14px;
    padding: 10px 18px;
    /* border: 1px solid #eee; */
}

/* Card */
.fit-card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 14px;
    padding: 18px;
    margin-top: 14px;
}

/* Header */
.fit-card-header {
    margin-bottom: 18px;
}

.fit-header-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.fit-header-title {
    font-size: 16px;
    font-weight: 600;
    color: #111;
}

/* Sections */
.fit-section {
    margin-bottom: 22px;
}

/* Row */
.fit-row {
    display: flex;
    align-items: center;
    gap: 8px;
    /* margin-bottom: 10px; */
}

/* Dot */
.fit-dot {
    width: 8px;
    height: 8px;
    background: #111;
    border-radius: 50%;
}

/* Labels */
.fit-label {
    font-size: 14px;
    /* font-weight: 600; */
    color: #606060;
}

/* Size chart link */
.fit-link {
    margin-left: auto;
    font-size: 13px;
    color: #111;
    text-decoration: none;
    font-weight: 500;
}

/* Sizes inline (NO BOXES – matches image) */
.fit-sizes {
    padding-left: 14px;
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    font-size: 13px;
    color: #4b5563;
    padding-top: 9px;
}

/* Slider */
.fit-slider {
    padding-left: 14px;
    padding-right: 10px;
}

/* Slider indicator */
.fit-indicator {
    position: absolute;
    top: 0px;
    width: 10%;
    height: 8px;
    background: #111;
    /* border-radius: 50%; */
}

/* Scale labels */
.fit-scale {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #6b7280;
}

.fit-scale .center {
    font-weight: 500;
    color: #374151;
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
#relatedAttributeTextFabric ul {
    padding-left: 20px; /* indent list items */
    margin: 0;
}
#relatedAttributeTextFabric li {
    margin-bottom: 4px;
    list-style-type: disc; /* show bullet */
}
.send_inq_header {
    color: black;
    font-size: 17px;
    font-weight: 500;
}
.iti--allow-dropdown {
    width: 100%;
}
.iti__selected-flag {
    color: black;
}
.iti__country-list {
    color: black;
}
.submit_btn {
    background-color: red;
    border: unset !important;
}
.submit_btn:hover {
    background-color: rgb(255, 67, 67);
    border: unset !important;
}
.form-control {
    padding-left: 10px;
}
@media (min-width: 1536px){
    .product_name_txt {
        font-size: 3rem;
    }
    .reversible_product {
        font-size: 17px;
        padding: 1.8rem .8rem;
    }
    .description_content p strong, .description_content p span, .made_content p strong, .features_content p strong, .description_text ul li  {
        font-size: 18px;
    }
    .description_content p span, .made_content p span, .features_content p span {
        font-size: 18px;
    }
    .description_content ul li, .made_content ul li, .features_content ul li {
        font-size: 18px;
    }
    .description_content p, .made_content p, .features_content p {
        font-size: 18px;
    }
    .description_content p strong, .made_content p strong, .features_content p strong {
        font-size: 18px;
    }
    .description_content {
        padding-top: 12px;
        padding-bottom: 6px;
    }
    .en-content-title {
        font-size: 23px;
    }
    .en-section-header {
        font-size: 16px !important;
    }
    .product_feature_topic {
        font-size: 20px !important;
    }
    .fit_sections {
        font-size: 1.2rem;
    }
    .size_tag {
        font-size: 17px;
    }
    .fit_class {
        font-size: 17px;
    }
    .label-left, .label-right, .label-center{
        font-size: 18px !important;
    }
}
.fit_class {
    font-size: 15px;
}
.label-center {
    font-size: 13px;
}
.product_details_main_div {
    padding-left: 30px !important;
    padding-right: 30px !important;
}
.font-medium {
    font-weight: 400;
    font-size: 13px;
}
.fabric-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.fabric-left {
    display: flex;
    align-items: center;
    gap: 6px;
}

.view-all-fabrics {
    font-size: 11px;
    font-weight: 500;
    color: gray;
    text-decoration: none;
}

.view-all-fabrics:hover {
    text-decoration: underline;
    color: rgb(61, 61, 61);
}
.embellishment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.embellishment-left {
    display: flex;
    align-items: center;
    gap: 6px;
}

.view-all-embellishment {
    font-size: 11px;
    font-weight: 500;
    color: gray;
    text-decoration: none;
}

.view-all-embellishment:hover {
    text-decoration: underline;
    color: rgb(61, 61, 61);
}

.fit_content {
    display: none !important;
}

.fit_content.fit_visible {
    display: block !important;
}
/* Icon animation */
.fit-toggle i {
    transition: transform 0.3s ease;
}

.fit-toggle i.rotate {
    transform: rotate(180deg);
}
.product_details_content {
    display: none !important;
}

.product_details_content.product_details_visible {
    display: block !important;
}

/* Chevron animation */
.fit-toggle i {
    transition: transform 0.3s ease;
}

.fit-toggle i.rotate {
    transform: rotate(180deg);
}

.price_div {
    padding: 0.5rem 0rem;
}
.inquiry_btn {
    font-size: 17px;
}
@media (min-width: 2275px) {
    .breadcrumb-nav {
        font-size: 23px;
        font-weight: 600;
    }
    .breadcrumb-current {
        font-size: 22px;
    }
    .product_no_text {
        font-size: 26px;
    }
    .price_div {
        padding: 1.5rem 0rem;
    }
    .price_text {
        font-size: 2.5rem !important;
    }
    .inquiry_btn {
        font-size: 24px;
    }
    .fabric_main_topic {
        font-size: 24px;
    }
    .fit-label {
        font-size: 20px;
    }
    .font-medium {
        font-size: 18px;
    }
    .view-all-fabrics {
        font-size: 15px;
    }
    .view-all-embellishment {
        font-size: 15px;
    }
    .fit-sizes span {
        font-size: 18px;
    }
    .fit-scale {
        font-size: 18px;
    }
    .description_content p strong, .description_content p span, .made_content p strong, .features_content p strong, .description_text ul li {
        font-size: 20px;
    }
}

@media (min-width: 1536px){
    .breadcrumb-nav {
        font-size: 18px;
        font-weight: 600;
    }
    .breadcrumb-current {
        font-size: 17px;
    }
    .product_no_text {
        font-size: 23px;
    }
    .price_div {
        padding: 1rem 0rem;
    }
    .price_text {
        font-size: 2rem !important;
    }
    .inquiry_btn {
        font-size: 22px;
    }
    .fabric_main_topic {
        font-size: 22px;
    }
    .fit-label {
        font-size: 19px;
    }
    .font-medium {
        font-size: 17px;
    }
    .view-all-fabrics {
        font-size: 14px;
    }
    .view-all-embellishment {
        font-size: 14px;
    }
    .fit-sizes span {
        font-size: 16px;
    }
    .fit-scale {
        font-size: 16px;
    }
    .description_content p strong, .description_content p span, .made_content p strong, .features_content p strong, .description_text ul li {
        font-size: 18px;
    }
}
@media (max-width: 1138px) and (min-width: 992px){
    .product_name_txt {
        font-size: 1.75rem;
    }
}
.description_text b,
.description_text strong {
    font-weight: 100 !important;
}

.description_text * {
    font-weight: 100 !important;
}
.fabric-color-circle {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    /* border: 1px solid #ccc; */
    cursor: pointer;
    transition: transform 0.2s ease;
}

.fabric-color-circle:hover {
    transform: scale(1.2);
}
@media (max-width: 576px) {
    .fit-sizes-row {
        flex-direction: column;
        align-items: flex-start;
    }
}
#relatedAttributeTextFabric {
    font-size: 12px;
    color: #777; /* gray */
    line-height: 1.5;
}

/* li, p, span, normal text */
#relatedAttributeTextFabric li,
#relatedAttributeTextFabric p,
#relatedAttributeTextFabric span {
    font-size: 12px;
    color: #777;
}

/* strong & bold text */
#relatedAttributeTextFabric strong,
#relatedAttributeTextFabric b {
    font-size: 13px;
    color: #000; /* or darker gray */
    font-weight: 600;
}
.description_font_weight {
    font-family: 'Mollen Personal Use', cursive;
    font-weight: 400;
    text-shadow: 0 0 0.6px #000;
}

/* =========================================================
   PRODUCT DETAILS - MOBILE RESPONSIVE
   CSS ONLY
   Desktop remains unchanged
   ========================================================= */
@media (max-width: 768px) {

    /* =====================================================
       MAIN PRODUCT CONTAINER
       ===================================================== */

    .product_details_main_div {
        padding-top: 10px !important;
        padding-left: 20px !important;
        padding-right: 20px !important;
    }

    .product_details_main_div > .row {
        margin: 0 !important;
    }


    /* =====================================================
       LEFT IMAGE AREA

       NEW HTML:
       Parent = col-lg-5
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5:first-child {

        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;

        padding-left: 10px !important;
        padding-right: 10px !important;
    }


    /* =====================================================
       RIGHT PRODUCT DETAILS
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5 + .col-lg-7 {

        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;

        padding-left: 10px !important;
        padding-right: 10px !important;

        margin-top: 18px !important;
    }


    /* =====================================================
       FIRST IMAGE ROW

       Desktop:
       Thumbnail | Main Image

       Mobile:
       Main Image
       Thumbnail
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row:first-child {

        display: flex !important;

        flex-direction: column !important;

        margin: 0 !important;
    }


    /* =====================================================
       MOBILE MAIN IMAGE

       HTML:
       .col-lg-9.col-12.order-2
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row:first-child
    > .col-lg-9.col-12.order-2 {

        order: 1 !important;

        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;

        padding: 0 !important;

        margin: 0 !important;
    }


    /* =====================================================
       MAIN IMAGE CARD
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row:first-child
    > .col-lg-9.col-12.order-2
    .main-image-container {

        width: 100% !important;

        margin: 0 !important;

        overflow: hidden !important;

        border-radius: 12px !important;

        background-color: #f1f1f1 !important;
    }


    /* =====================================================
       MAIN IMAGE
       ===================================================== */

    .product_details_main_div #mainImage {

        width: 100% !important;

        height: auto !important;

        max-width: 100% !important;

        max-height: none !important;

        object-fit: contain !important;

        display: block !important;
    }


    /* =====================================================
       MOBILE THUMBNAILS

       HTML:
       .col-lg-3.col-12.order-1

       Move BELOW MAIN IMAGE
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row:first-child
    > .col-lg-3.col-12.order-1 {

        order: 2 !important;

        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;

        padding: 0 !important;

        margin-top: 10px !important;
        margin-bottom: 0 !important;

        display: flex !important;

        flex-direction: row !important;

        align-items: center !important;
    }


    /* =====================================================
       THUMBNAIL LIST
       ===================================================== */

    #thumbnailList {

        width: 100% !important;

        max-width: 100% !important;

        height: 76px !important;

        max-height: 76px !important;

        display: flex !important;

        flex-direction: row !important;

        align-items: center !important;

        justify-content: flex-start !important;

        overflow-x: auto !important;

        overflow-y: hidden !important;

        gap: 8px !important;

        padding: 6px 2px !important;

        margin: 0 !important;

        scroll-behavior: smooth;

        -webkit-overflow-scrolling: touch;

        scrollbar-width: none;
    }


    #thumbnailList::-webkit-scrollbar {
        display: none;
    }


    /* =====================================================
       THUMBNAIL IMAGES

       Inline HTML has:
       width: 90%;
       height: 90%;

       These rules override those values.
       ===================================================== */

    #thumbnailList .thumb-img {

        flex: 0 0 62px !important;

        width: 62px !important;

        height: 62px !important;

        min-width: 62px !important;

        min-height: 62px !important;

        margin: 0 !important;

        padding: 2px !important;

        object-fit: cover !important;

        border-radius: 8px !important;

        border: 1px solid #dedede !important;

        background: #f7f7f7 !important;

        cursor: pointer;

        transition:
            border-color 0.2s ease,
            transform 0.2s ease,
            opacity 0.2s ease !important;
    }


    #thumbnailList .thumb-img:active {
        transform: scale(0.94);
    }


    /* =====================================================
       ADDITIONAL IMAGE GALLERY

       Lifestyle
       Close Up
       Branding
       Studio

       2 COLUMNS
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row.g-2 {

        display: grid !important;

        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;

        gap: 8px !important;

        margin: 12px 0 0 0 !important;
    }


    /* =====================================================
       ADDITIONAL IMAGE ITEMS
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row.g-2
    > .col-12.col-md-6 {

        width: 100% !important;

        max-width: 100% !important;

        padding: 0 !important;

        margin: 0 !important;
    }


    /* =====================================================
       ADDITIONAL IMAGE CARD
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row.g-2
    .main-image-container {

        width: 100% !important;

        height: 100% !important;

        border-radius: 10px !important;

        overflow: hidden !important;

        background: #f3f3f3 !important;
    }


    /* =====================================================
       ADDITIONAL IMAGES
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row.g-2 img {

        width: 100% !important;

        height: 100% !important;

        object-fit: cover !important;

        display: block !important;
    }


    /* =====================================================
       PRODUCT INFORMATION
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5 + .col-lg-7
    .details_div_style {

        width: 100% !important;

        margin-left: 0 !important;
        margin-right: 0 !important;
    }


    /* =====================================================
       PRODUCT NAME
       ===================================================== */

    .product_name_txt {

        font-size: 25px !important;

        line-height: 1.2 !important;

        margin-top: 4px !important;

        margin-bottom: 0 !important;

        word-break: normal !important;
    }


    /* =====================================================
       PRODUCT NUMBER
       ===================================================== */

    .product_no_text {

        font-size: 13px !important;

        margin-bottom: 0 !important;
    }


    /* =====================================================
       PRICE
       ===================================================== */

    .price_text {

        font-size: 22px !important;
    }


    /* =====================================================
       FABRIC
       ===================================================== */

    .fabric_content {

        width: 100% !important;
    }


    .details_div_style2 {

        max-width: 100% !important;
    }


    .fit-row {

        width: 100% !important;
    }


    .fit-label {

        font-size: 14px !important;
    }


    .fabric-option {

        max-width: 100% !important;

        padding: 8px 10px !important;

        border-radius: 9px !important;
    }


    .en-fabric-name-container {

        gap: 7px !important;
    }


    .view-all-fabrics {

        white-space: nowrap !important;

        font-size: 12px !important;
    }


    /* =====================================================
       SIZES
       ===================================================== */

    .fit_content {

        width: 100% !important;
    }


    .fit-sizes-row {

        width: 100% !important;

        min-height: 40px !important;
    }


    .fit-sizes {

        padding-right: 0 !important;

        gap: 6px !important;
    }


    .fit-sizes span {

        min-width: 38px !important;

        padding: 6px 8px !important;

        border-radius: 7px !important;

        text-align: center !important;
    }


    /* Size chart */

    .fit-sizes-row > div:last-child {

        position: static !important;

        margin-top: 10px !important;

        text-align: left !important;
    }


    /* =====================================================
       FIT SLIDER
       ===================================================== */

    .fit-slider {

        width: 100% !important;

        padding-left: 3px !important;

        padding-right: 3px !important;
    }


    .fit-track {

        width: 100% !important;
    }


    .fit-scale {

        width: 100% !important;

        font-size: 11px !important;
    }


    /* =====================================================
       DESCRIPTION
       ===================================================== */

    .description_font_weight h2 {

        font-size: 17px !important;

        margin-bottom: 8px !important;
    }


    .description_text {

        font-size: 14px !important;

        line-height: 1.6 !important;
    }


    .product_feature_topic h2 {

        font-size: 16px !important;
    }


    /* =====================================================
       INQUIRY BUTTON
       ===================================================== */

    .inquiry_btn {

        width: 100% !important;

        min-height: 48px !important;

        border-radius: 10px !important;

        font-size: 14px !important;
    }

}


/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 575px) {

    .product_details_main_div {

        padding-top: 6px !important;
    }


    /* =====================================================
       MAIN IMAGE
       ===================================================== */

    .product_details_main_div #mainImage {

        min-height: 300px !important;

        object-fit: contain !important;
    }


    /* =====================================================
       THUMBNAIL CONTAINER
       ===================================================== */

    #thumbnailList {

        height: 70px !important;

        max-height: 70px !important;

        gap: 7px !important;
    }


    /* =====================================================
       THUMBNAILS
       ===================================================== */

    #thumbnailList .thumb-img {

        flex: 0 0 56px !important;

        width: 56px !important;

        height: 56px !important;

        min-width: 56px !important;

        min-height: 56px !important;
    }


    /* =====================================================
       ADDITIONAL IMAGES
       ===================================================== */

    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row.g-2 {

        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;

        gap: 6px !important;

        margin-top: 10px !important;
    }


    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row.g-2
    .main-image-container {

        height: 100% !important;

        border-radius: 8px !important;
    }


    /* =====================================================
       PRODUCT DETAILS
       ===================================================== */

    .product_name_txt {

        font-size: 22px !important;
    }


    .price_text {

        font-size: 21px !important;
    }
    .mobile-toggle-wrapper {
        display: none !important;
    }
    .mobile-back-wrapper {
        display: block !important;
        margin-top: 50px !important;
        padding-top: 0 !important;
        position: relative;
        z-index: 9999;
    }

    .mobile-back-button {
        position: relative;
        z-index: 10000;
        pointer-events: auto !important;
        padding: 5px 12px;
        background-color: white;
        color: gray;
        font-weight: 900;
        font-size: 14px;
    }

}


/* =========================================================
   VERY SMALL MOBILE
   ========================================================= */

@media (max-width: 380px) {

    .product_details_main_div
    > .row
    > .col-lg-5:first-child
    > .row.g-2
    .main-image-container {

        height: 125px !important;
    }


    .product_name_txt {

        font-size: 20px !important;
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
/* Desktop - button hidden */
.see-more-images-btn {
    display: none;
}

/* Mobile only */
@media (max-width: 768px) {

    .additional-images-hidden {
        display: none !important;
    }

    .see-more-images-btn {
        display: none;
        margin: 15px auto 0;
        padding: 8px 25px;
        border: 1px solid #777;
        background: white;
        color: #555;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }
    .breadcrumb-wrapper {
        padding-left: 30px;
    }

}

</style>
<script src="https://cdn.tailwindcss.com"></script>
<div class="navbar" style=" background-color:white; z-index:99; padding: unset;">

    @section('page-route')
        {{-- @if(isset($searchValue))
            <a href="{{ route('search.products', ['search' => $searchValue]) }}">
                <img src="{{ asset('argon') }}/img/encore/logo_dark.png" alt="image" style="width:auto !important; color:black;height: 85px;" class="image_width_logo">
            </a>
        @else
            <a href="{{ route('product_filter1', [
                'selectedGender' => $selectedGender,
                'selectedCategory' => $selectedCategory,
                'selectedSport' => $selectedSport,
                'selectedStyle' => $selectedStyle,
                ]) }}">
                <img src="{{ asset('argon') }}/img/encore/logo_dark.png" alt="image" style="width:auto !important; color:black;height: 85px;" class="image_width_logo">
            </a>
        @endif --}}
        <a href="{{ route('customer_catlog') }}">
            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" alt="image" style="width:auto !important; color:black;height: 85px;" class="image_width_logo">
        </a>
    @endsection

    @section('apparel-catalog')
        {{-- <p class="head_p">APPAREL CATALOG</p> --}}
    @endsection

    @include('pages.customer_product_catlog.layout.header')

</div>

@php
    // default images
    $imageUrl='assets/img/products/product defaul image.jpg';
@endphp

<div class="container_style" style="padding-bottom: 30px;">

    {{-- <div class="filter-toggle d-lg-none ml-auto">
        <button id="filterToggleBtn" class="btn btn-light">
            &#9776;
        </button>
    </div> --}}

    <!-- Filter Container (works for both large & small screens) -->
@php
    $mainCategoryId = $product->main_category_id;
    $currentCategory = $mainCategories->firstWhere('id', $mainCategoryId);
@endphp

<div class="breadcrumb-wrapper">
    <nav class="breadcrumb-nav">

        <a href="{{ route('customer_catlog') }}">Home</a>
        <span>/</span>

        <a href="{{ route('product_filter1', [
                    'selectedGender' => 'All',
                    'selectedCategory' => '5',
                    'selectedSport' => '18',
                    'selectedStyle' => '0',
                    ]) }}"
                    >Catalog</a>
        <span>/</span>

        @if($currentCategory)
            <a href="{{ route('product_filter1', [
                'selectedCategory' => $currentCategory->id,
                'selectedGender' => 'All',
                'selectedSport' => '18',
                'selectedStyle' => '0',
            ]) }}">
                {{ $currentCategory->category_name }}
            </a>
            <span>/</span>
        @endif

        <span class="breadcrumb-current">
            {{ $product->product_name }}
        </span>

    </nav>
</div>



    <!-- Overlay for mobile -->
    <div id="filterOverlay" class="filter-overlay"></div>

    <div class="col-lg-12 product_details_main_div" style="padding: unset; padding-top: 27px;">
        <div class="row" style="margin: unset;">
            {{-- <div class="col-lg-1">

            </div> --}}
            <div class="col-lg-5"
                style="">

                    <div class="row">
                        {{-- Thumbnails: first in HTML, first visually on desktop --}}
                        <div class="col-lg-3 col-12 d-flex flex-lg-column flex-row align-items-center order-lg-1 order-1 mt-lg-0 mt-2">
                            {{-- <button id="scrollUp" class="btn btn-dark pause_button_color mb-lg-2 me-lg-0 me-2 d-none d-lg-block">&#9650;</button> --}}

                            <div id="thumbnailList"
                                 class="d-flex flex-lg-column flex-row align-items-center overflow-auto"
                                 style=" width: 100%;">

                                {{-- Mockup Images --}}
                                @foreach ([$product->mockup_img_1, $product->mockup_img_2, $product->mockup_img_3] as $index => $img)
                                    @if (!empty($img))
                                        <img src="{{ asset('assets') . $img }}"
                                             class="img-thumbnail mb-lg-2 me-lg-0 me-2 thumb-img cursor_pointer"
                                             onclick="changeMainImage('{{ asset('assets') . $img }}', {{ $index }})"
                                             data-index="{{ $index }}"
                                             style="width: 90%; height: 90%; object-fit: cover;">
                                    @endif
                                @endforeach

                                {{-- 3D Images --}}
                                @if (!empty($images_3d))
                                    @foreach ($images_3d as $index => $image_3d)
                                        @if (!empty($image_3d->image_link))
                                            <img src="{{ asset($image_3d->image_link) }}"
                                                 class="img-thumbnail mb-lg-2 me-lg-0 me-2 thumb-img cursor_pointer"
                                                 onclick='changeMainImage(@json(asset($image_3d->image_link)), {{ $index + 3 }})'
                                                 data-index="{{ $index + 3 }}"
                                                 style="width: 90%; height: 90%; object-fit: cover;">
                                        @endif
                                    @endforeach

                                @endif
                            </div>

                            {{-- <button id="scrollDown" class="btn btn-dark pause_button_color mt-lg-2 ms-lg-0 me-2 d-none d-lg-block">&#9660;</button> --}}
                        </div>

                        {{-- Main Image: second in HTML, second visually on desktop --}}
                        <div class="col-lg-9 col-12 position-relative order-lg-2 order-2">
                            <div class="card main-image-container" style="background-color: #f1f1f1; border-radius: 10px;">
                                {{-- <span class="badge bg-dark position-absolute top-0 start-0 m-2 product_number_onImage" style="z-index: 1;">
                                    {{ $product->product_no }}
                                </span> --}}
                                <img id="mainImage" src="{{ asset('assets') . $product->mockup_img_1 }}"
                                     class="d-block w-100 img-fluid"
                                     alt="Main Image">

                                {{-- <button id="toggleSlider" class="btn btn-dark pause_button_color position-absolute top-0 end-0 m-2"
                                        onclick="toggleSlider()">
                                    <i id="sliderIcon" class="fas fa-pause"></i>
                                </button> --}}
                            </div>
                        </div>
                    </div>



                    <div class="row g-2" id="additionalImagesGallery">

                        {{-- Lifestyle images --}}
                        @if (!empty($lifeStyle_images))
                            @foreach ($lifeStyle_images as $index => $lifestyle_image)
                                @if (!empty($lifestyle_image->image_link))
                                    <div class="col-12 col-md-6">
                                        <div class="card main-image-container"
                                            style="border-radius: unset; background-color: rgb(241,241,241); position: relative;">

                                            <img id="lifeStyleImage_{{ $index }}"
                                                src="{{ asset($lifestyle_image->image_link) }}"
                                                class="d-block w-100 img-fluid cursor_pointer"
                                                alt="Lifestyle Image {{ $index + 1 }}"
                                                onclick="openModal({{ json_encode(asset($lifestyle_image->image_link)) }})">

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif


                        {{-- CloseUp images --}}
                        @if (!empty($closeUp_images))
                            @foreach ($closeUp_images as $index => $closeUp_image)
                                @if (!empty($closeUp_image->image_link))
                                    <div class="col-12 col-md-6">
                                        <div class="card main-image-container"
                                            style="border-radius: unset; background-color: rgb(241,241,241); position: relative;">

                                            <img id="closeUpImage_{{ $index }}"
                                                src="{{ asset($closeUp_image->image_link) }}"
                                                class="d-block w-100 img-fluid cursor_pointer"
                                                alt="Close Up Image {{ $index + 1 }}"
                                                onclick="openModal({{ json_encode(asset($closeUp_image->image_link)) }})">

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif


                        {{-- Branding images --}}
                        @if (!empty($branding_images))
                            @foreach ($branding_images as $index => $branding_image)
                                @if (!empty($branding_image->image_link))
                                    <div class="col-12 col-md-6">
                                        <div class="card main-image-container"
                                            style="border-radius: unset; background-color: rgb(241,241,241); position: relative;">

                                            <img id="brandingImage_{{ $index }}"
                                                src="{{ asset($branding_image->image_link) }}"
                                                class="d-block w-100 img-fluid cursor_pointer"
                                                alt="Branding Image {{ $index + 1 }}"
                                                onclick="openModal({{ json_encode(asset($branding_image->image_link)) }})">

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif


                        {{-- Studio images --}}
                        @if (!empty($studio_images))
                            @foreach ($studio_images as $index => $studio_image)
                                @if (!empty($studio_image->image_link))
                                    <div class="col-12 col-md-6">
                                        <div class="card main-image-container"
                                            style="border-radius: unset; background-color: rgb(241,241,241); position: relative;">

                                            <img id="studioImage_{{ $index }}"
                                                src="{{ asset($studio_image->image_link) }}"
                                                class="d-block w-100 img-fluid cursor_pointer"
                                                alt="Studio Image {{ $index + 1 }}"
                                                onclick="openModal({{ json_encode(asset($studio_image->image_link)) }})">

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif

                    </div>

                    <!-- See More Button -->
                    <button type="button"
                        id="seeMoreImagesBtn"
                        class="see-more-images-btn">
                        See More
                    </button>


            </div>

            <div class="col-lg-7"
                style="">
            {{-- <div class="col-lg-5"  style="padding: unset; padding-top: 10px; padding-left: 20px;"> --}}
                <div class="w-full lg:mt-0 bg-white rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl">

                    <div class="row details_div_style" style="margin: unset;">

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
                        <div style="padding: unset;">
                            <h1 class="product_name_txt">{{ $product->show_in_catalog_name ?? $product->product_name }}</h1>
                        </div>
                    </div>

                    <div class="row details_div_style" style="padding-top: 8px; padding-bottom: 10px; ">
                        <div style="padding: unset;">
                            <p class="text-gray-600 product_no_text" style="font-weight: 400;">Product # : {{ str_replace('-', '  ', $product->product_no) }}</p>

                        </div>
                    </div>

                    <div class="row details_div_style" style="padding-top: 8px; padding-bottom: 10px; ">
                        <div style="padding: unset;">
                            <span class="text-2xl font-bold text-indigo-950 price_text" style="font-weight: 500;">$ {{ $product->default_price }}</span>
                        </div>
                    </div>

                    <div class="row details_div_style" style="padding-top: 8px; padding-bottom: 10px; ">
                        <div style="padding: unset;">
                            <div class="fabric_content" style="">

                                <!-- Fabric Title -->
                                <div style="width: 100%;">
                                    <div class="fit-row fabric-header">
                                        <div class="fabric-left">
                                            <span class="fit-dot"></span>
                                            <span class="fit-label">Fabric</span>
                                        </div>

                                        {{-- <a href="{{ route('commonFabricPage') }}"
                                        target="_blank"
                                        class="view-all-fabrics">
                                            View All <i class="fas fa-arrow-right" style="padding-left: 5px;"></i>

                                        </a> --}}
                                    </div>


                                    <div class="row details_div_style2" style="display: flex;  align-items: center;">

                                        <div style="display: flex; gap: 10px;">
                                            @if (!empty($relatedFabric) && isset($relatedFabric[0]))
                                                @php $firstFabric = $relatedFabric[0]; @endphp

                                                @php
                                                    $colors = json_decode($firstFabric['fabric_detail']->colors, true);
                                                @endphp

                                                <div class="en-fabric-btn fabricInfoLink fit_sections fabric-option"
                                                    data-subProduct-id="{{ $firstFabric['subproduct_id'] }}">

                                                    <div class="en-fabric-name-container" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">

                                                        <!-- Fabric Name -->
                                                        <span class="font-medium">
                                                            {{ $firstFabric['fabric_detail']->fabric_name }}
                                                        </span>

                                                        <!-- Color Circles -->
                                                        @if (!empty($colors))
                                                            <div style="display:flex; gap:5px;">
                                                                @foreach ($colors as $color)
                                                                    <div class="fabric-color-circle"
                                                                        style="background-color: {{ $color['code'] }};"
                                                                        title="{{ $color['name'] }}">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <a href="{{ route('commonFabricPage') }}"
                                        target="_blank"
                                        class="view-all-fabrics">
                                            View All <i class="fas fa-arrow-right" style="padding-left: 5px;"></i>
                                        </a>

                                    </div>
                                </div>

                                <!-- Embellishment -->
                                <div class="row details_div_style display_hide" id="embellishmentTypeTopic" style="padding: unset; ">


                                    <div class="fit-row embellishment-header" style="width: 100%;">
                                        <div class="embellishment-left">
                                            <span class="fit-dot"></span>
                                            <span class="fit-label">Embellishment</span>
                                        </div>

                                        {{-- <a href="{{ route('embellishmentPage') }}"
                                            target="_blank"
                                            class="view-all-embellishment">
                                                View All
                                                <i class="fas fa-arrow-right" style="padding-left: 5px;"></i>
                                        </a> --}}

                                    </div>

                                </div>

                                <div class="row details_div_style2" style="padding-bottom: unset;">
                                    <div class="details_div_style2 display_hide row" id="embellishmentType" style="padding-top: unset;"></div>
                                </div>

                                <!-- Colors -->
                                <div class="row details_div_style display_hide" id="colorTopic">
                                    <div style="padding: unset;">
                                        <p style="font-size: 14px; color: rgb(80, 80, 80); font-weight: 300; margin-bottom: 0.2rem;">
                                            Available Colors
                                        </p>
                                    </div>
                                </div>

                                <div class="row details_div_style2 display_hide" id="colorInfo" style="padding-bottom: 13px;"></div>

                                <div class="row details_div_style2 display_hide" id="colorAllColor" style="padding-bottom: 13px;">
                                    <div style="padding: unset;">
                                        <p style="font-size: 13px; color: rgb(95, 95, 95); font-weight: 500; margin-bottom: 0.2rem;">
                                            Customizable in any color
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row details_div_style" style="padding-top: unset; padding-bottom: 10px;">
                        <span class="sublimation_text"></span>
                    </div>

                    {{-- <div class="row details_div_style" style="padding-top: 14px; padding-bottom: 10px;">
                        <div style="padding: unset;">
                            <p class="text-gray-600" style="font-weight: 400;">• Bulk shipping, sorted upon request <br>
                                • Custom online store, shipping options include direct-to-customer or bulk shipping, sorted upon request</p>
                        </div>
                    </div> --}}

                    <div class="row details_div_style" style="padding-top: 14px; padding-bottom: 10px;">
                        <!-- Button with data attributes -->
                        <button class="sweep-btn inquiry_btn" style=""
                                data-bs-toggle="modal"
                                data-bs-target="#inquiryModal">
                             Inquire for Custom Order
                        </button>
                    </div>

                    {{-- <div class="row details_div_style" style="padding-bottom: 10px; padding-top: 0; display: flex; justify-content: center;">
                        <span class="text-sm text-gray-600 ml-2">(Sales &amp; Order processing)</span>
                    </div> --}}

                    {{-- <div class="row details_div_style" style="padding-top: 14px;">
                        <div class="en-section-container" style="width: 100%;">

                            <!-- Header -->
                            <div class="en-section-header" id="fabric-topic" style="font-size: 16px;">
                                <div class="flex items-center fabric_main_topic">
                                    <span class="fit-dot"></span>
                                    <h2>&nbsp; Fabric &amp; Embellishment</h2>
                                </div>
                                <div class="en-toggle-icon fit-toggle">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>

                            <div class="fit-divider"></div>

                            <!-- Content -->
                            <div class="fabric_content" style="padding: 0rem 1rem;">

                                <!-- Fabric Title -->
                                <div style="width: 100%;">
                                    <div class="fit-row fabric-header">
                                        <div class="fabric-left">
                                            <span class="fit-dot"></span>
                                            <span class="fit-label">Fabric</span>
                                        </div>

                                        <a href="{{ route('commonFabricPage') }}"
                                        target="_blank"
                                        class="view-all-fabrics">
                                            View All Our Fabrics <i class="fas fa-arrow-right" style="padding-left: 5px;"></i>

                                        </a>
                                    </div>


                                    <div class="row details_div_style2" style="">
                                        @if (!empty($relatedFabric) && isset($relatedFabric[0]))
                                            @php $firstFabric = $relatedFabric[0]; @endphp

                                            <div class="en-fabric-btn fabricInfoLink fit_sections fabric-option"
                                                data-subProduct-id="{{ $firstFabric['subproduct_id'] }}">
                                                <div class="en-fabric-name-container">
                                                    <span class="font-medium">
                                                        {{ $firstFabric['fabric_detail']->fabric_name }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Embellishment -->
                                <div class="row details_div_style display_hide" id="embellishmentTypeTopic" style="padding: unset; ">


                                    <div class="fit-row embellishment-header" style="width: 100%;">
                                        <div class="embellishment-left">
                                            <span class="fit-dot"></span>
                                            <span class="fit-label">Embellishment</span>
                                        </div>

                                        <a href="{{ route('embellishmentPage') }}"
                                            target="_blank"
                                            class="view-all-embellishment">
                                                View All Our Embellishments
                                                <i class="fas fa-arrow-right" style="padding-left: 5px;"></i>
                                        </a>

                                    </div>

                                </div>

                                <div class="row details_div_style2" style="">
                                    <div class="details_div_style2 display_hide row" id="embellishmentType" style="padding-top: unset;"></div>
                                </div>

                                <!-- Colors -->
                                <div class="row details_div_style display_hide" id="colorTopic">
                                    <div style="padding: unset;">
                                        <p style="font-size: 14px; color: rgb(80, 80, 80); font-weight: 300; margin-bottom: 0.2rem;">
                                            Available Colors
                                        </p>
                                    </div>
                                </div>

                                <div class="row details_div_style2 display_hide" id="colorInfo" style="padding-bottom: 13px;"></div>

                                <div class="row details_div_style2 display_hide" id="colorAllColor" style="padding-bottom: 13px;">
                                    <div style="padding: unset;">
                                        <p style="font-size: 13px; color: rgb(95, 95, 95); font-weight: 500; margin-bottom: 0.2rem;">
                                            Customizable in any color
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> --}}


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
                        <div class="row details_div_style" style="padding-top: 20px; ">
                            <div class="en-section-container " style="width: 100%; padding:unset;">
                                {{-- <div class="en-section-header fit-header" id="fit-topic">
                                    <div class="flex items-center fabric_main_topic">
                                        <h2>Fit & Sizes Options</h2>
                                    </div>
                                </div> --}}

                                {{-- <div class="fit-divider"></div> --}}

                                <div class="fit_content fit_visible" style="">


                                     @if (!empty($shortenedSizeNames))

                                             <div class="fit-section">
                                            <div class="fit-row">
                                                <span class="fit-dot"></span>
                                                <span class="fit-label">Available Sizes</span>

                                                {{-- @if(!empty($product->size_chart))
                                                    <a id="open-size-chart"
                                                    href="javascript:void(0);"
                                                    class="fit-link view-all-embellishment"
                                                    data-chart="{{ asset($product->size_chart) }}">
                                                        Size Chart <i class="fas fa-arrow-right" style="padding-left: 5px;"></i>
                                                    </a>
                                                @else
                                                    <a href="https://encr.co/customerSizing"
                                                    class="fit-link view-all-embellishment"
                                                    target="_blank">
                                                        Size Chart <i class="fas fa-arrow-right" style="padding-left: 5px;"></i>
                                                    </a>
                                                @endif --}}
                                            </div>

                                            <div class="fit-sizes-row" style="position: relative;">

                                                <!-- Sizes -->
                                                <div class="fit-sizes" style="display:flex; gap:8px; flex-wrap: wrap; padding-right:120px;">
                                                    @foreach ($shortenedSizeNames as $sizeName)
                                                        <span>{{ $sizeName }}</span>
                                                    @endforeach
                                                </div>

                                                <!-- Size Chart Link -->
                                                <div style="position: absolute; top: 0; right: 0;">
                                                    @if(!empty($product->size_chart))
                                                        <a id="open-size-chart"
                                                        href="javascript:void(0);"
                                                        class="fit-link view-all-embellishment"
                                                        data-chart="{{ asset($product->size_chart) }}">
                                                            Size Chart <i class="fas fa-arrow-right" style="padding-left: 5px;"></i>
                                                        </a>
                                                    @else
                                                        <a href="https://encr.co/customerSizing"
                                                        class="fit-link view-all-embellishment"
                                                        target="_blank">
                                                            Size Chart <i class="fas fa-arrow-right" style="padding-left: 5px;"></i>
                                                        </a>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        @endif

                                        <!-- FIT SLIDER -->
                                        @if (!empty($product->fits_true_to_size))
                                        <div class="fit-section">
                                    <div class="fit-row">
                                        <span class="fit-dot"></span>
                                        <span class="fit-label">Fit</span>
                                    </div>


                                            <div class="fit-slider">

                                                <div class="fit-track">
                                                    <!-- Start dot -->
                                                    <span class="fit-dot-point start"></span>

                                                    <!-- Middle dot -->
                                                    <span class="fit-dot-point center"></span>

                                                    <!-- End dot -->
                                                    <span class="fit-dot-point end"></span>

                                                    <!-- Moving indicator -->
                                                    <span class="fit-indicator"
                                                        data-fit="{{ $product->fits_true_to_size }}">
                                                    </span>
                                                </div>


                                                <div class="fit-scale">
                                                    <span>Runs Small</span>
                                                    <span class="">True to Size</span>
                                                    <span>Runs Large</span>
                                                </div>
                                             </div>
                                         </div>

                                     @endif

                                </div>

                            </div>
                        </div>
                    @endif

                                <div class="fit-divider"></div>


                    @if (!empty($product->description) || !empty($product->who_we_made_this_for) || !empty($product->product_features))
                        <div class="row details_div_style" style="padding-top: 14px; padding-bottom: 20px;">
                            <div class="en-section-container " style="width: 100%;  padding:unset;">
                                <div class="en-section-header product_details_visible" id="product-details-topic" style="font-size: 16px;">
                                    <div class="flex items-center fabric_main_topic description_font_weight">
                                    {{-- <span class="fit-dot"></span> --}}
                                    <h2 class="">Description</h2>
                                    </div>
                                    {{-- <div class="en-toggle-icon fit-toggle">
                                       <i class="fas fa-chevron-down"></i>
                                   </div> --}}
                                </div>
                                {{-- <div class="fit-divider"></div> --}}

                                <div class="product_details_content product_details_visible" style="">



                                    <div class="description_content" style="">
                                        <p class=" description_text" style="">{!! $product->description !!}</p>
                                    </div>

                                    @if (!empty($product->product_features))
                                        <div class="product_feature_topic description_font_weight" style="padding-top: 17px;">
                                            <h2>Product Features</h2>
                                        </div>

                                        <div class="description_content" style="">
                                            <div class="description_text" style="">
                                                {!! $product->product_features !!}
                                            </div>
                                        </div>

                                    @endif

                                    @if (!empty($product->who_we_made_this_for))
                                        <div class="product_feature_topic description_font_weight" style="padding-top: 17px;">
                                            <h2>Who We Made This For</h2>
                                        </div>

                                        <div class="description_content" style="">
                                            <div class="description_text" style="">
                                                {!! $product->who_we_made_this_for !!}
                                            </div>
                                        </div>
                                    @endif

                                </div>

                            </div>
                        </div>

                    @endif

                </div>



                {{-- @if (!empty($relatedAttributes))
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
                @endif --}}

            </div>

        </div>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style=" width: auto;margin: auto;justify-content: center; min-width: 50%;">
            <div class="modal-content image_modal_css" style="height: 100%;">
                <div class="modal-body p-0 d-flex justify-content-center align-items-center"
                    style="overflow: hidden;">

                    <!-- Close Button -->
                    <button type="button" class="btn-close position-absolute close_btn_style"
                            style="top: 20px; right: 20px; z-index: 10;"
                            data-bs-dismiss="modal" aria-label="Close">&#10005;
                    </button>


                    <!-- Image and Details Section -->
                    <div class="container-fluid d-flex flex-column align-items-center mt-2 justify-content-center" style="">

                        <!-- Image Section -->
                        <div class="image-section mb-3 mb-md-0 text-center" style="background-color: rgba(255, 255, 255, 0.44);  width: 100%; height: 100%;">
                            <img id="modalImage" src="" alt="Image" class="img-fluid"
                            style="max-height: 100vh; max-width: 100%; width: 100%;">
                        </div>

                    </div>

                    <!-- Navigation Buttons -->
                    <button id="prevButton" class="btn btn-secondary position-absolute next_button"
                            style="left: 15px; top: 50%; transform: translateY(-50%);"
                            onclick="changeImage(-1)">
                        &#10094;
                    </button>

                    <button id="nextButton" class="btn btn-secondary position-absolute next_button"
                            style="right: 15px; top: 50%; transform: translateY(-50%);"
                            onclick="changeImage(1)">
                        &#10095;
                    </button>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="imageModalFabric" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " >
        <div class="modal-content image_modal_css">
            <div class="modal-body p-0 d-flex flex-column  align-items-center position-relative"
                 style=" overflow: hidden;">

                {{-- <button type="button" class="btn-close position-absolute close_btn_style"
                        style="top: 20px; right: 20px; z-index: 10;"
                        data-bs-dismiss="modal" aria-label="Close">&#10005;
                </button> --}}


                {{-- <div id="" class="position-relative d-flex justify-content-center align-items-center mt-2"
                    style="width: 80%; padding-bottom: 20px;">
                    <b style="font-size: 25px; margin-bottom: unset; color: #000000; text-align: center;">
                        {{ $product->product_name }}
                    </b>
                </div> --}}

                <div class="container-fluid d-flex flex-column align-items-center p-2 justify-content-center">

                    <div class="image-section hover-image-section mb-3 mb-md-0 text-center" style="background-color: rgba(255, 255, 255, 0.44); padding: 2px;">
                        <img id="modalImageFabricMain" src="" alt="Image" class="img-fluid img-main">
                        <img id="modalImageFabric" src="" alt="Image" class="img-fluid img-hover">
                        <div id="relatedAttributeNameFabric" class="fabric-overlay-text">
                            <span id="relatedNameFabric"></span>
                        </div>
                    </div>

                    <div class="text-section d-flex flex-column align-items-center align-items-md-start ms-md-3 mt-3 mt-md-0 text-center text-md-start p-2" >

                        <div id="fabricColorsDisplay" class="fabric-colors-section text-center mb-3" style="display: none;">
                            <div class="fw-bold text-uppercase mb-2" style="font-size: 13px;"><b>Available In</b></div>
                            <div id="fabricColorsWrapper" class="d-flex justify-content-center flex-wrap gap-3"></div>
                        </div>

                        <div id="relatedAttributeDescriptionFabric" class="position-relative d-flex justify-content-center align-items-center mt-2" style="display: none;">
                            <!-- changed from <p> to <div> -->
                            <div id="relatedAttributeTextFabric" style="font-size: 12px; margin-bottom: unset; padding-top: 3px; text-align: left;">
                            </div>
                        </div>

                        {{-- <div class="embellishment-section text-center mt-3">
                            <div class="fw-bold text-uppercase mb-2" style="font-size: 13px;"><b>Embellishment Types</b></div>
                            <div class="d-flex  flex-wrap gap-2">
                                <span class="embellishment-pill">Sublimation</span>
                                <span class="embellishment-pill">Screen Print</span>
                                <span class="embellishment-pill">Embroidery</span>
                                <span class="embellishment-pill">Heat Seal</span>
                                <span class="embellishment-pill">DTF</span>
                                <span class="embellishment-pill">Woven Label</span>
                            </div>
                        </div> --}}
                        <div id="embellishmentTypesDisplay" class="embellishment-section text-center mt-3" style="display: none;">
                            <div class="fw-bold text-uppercase mb-2" style="font-size: 13px;"><b>Embellishment Types</b></div>
                            <div id="embellishmentPillsWrapper" class="d-flex flex-wrap gap-2"></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="embellishmentHoverModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " >
        <div class="modal-content image_modal_css">
            <div id="hover_catch" class="modal-body p-0 d-flex flex-column  align-items-center position-relative"
                 style=" overflow: hidden;min-height: 65vh;">
                <div class="container-fluid d-flex flex-column align-items-center p-2 justify-content-center">
                    <div class="image-section2  mb-3 mb-md-0 text-center" style="background-color: rgba(255, 255, 255, 0.44); padding: 2px;">
                        {{-- <img id="hoverImage" src="" alt="Embellishment" class="img-fluid hover-zoom" style="transition: transform 0.5s ease;"> --}}
                        <div id="" class="fabric-overlay-text">
                            <span id="imageLabel"></span>
                        </div>
                    </div>
                    <div class=" d-flex flex-column align-items-center align-items-md-start ms-md-3 mt-3 mt-md-0 text-center text-md-start p-2" >
                        <div id="relatedAttributeDescriptionFabric" class="position-relative d-flex justify-content-center align-items-center mt-4"
                            style="  display: none;">
                            <p id="embellishmentDesc" style="font-size: 12px; margin-bottom: unset;  padding-top: 3px;">

                            </p>
                        </div>
                        <div id="fabricTypesDisplay" class="embellishment-section text-center mt-4" style="display:none">
                            <div class="fw-bold text-uppercase mb-2" style="font-size: 13px;"><b>Compatible Fabrics</b></div>
                            <div id="fabricTags" class="d-flex flex-wrap gap-2"></div>
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
                 style="min-height: 98vh; overflow: hidden;">

                <button type="button" class="btn-close position-absolute close_btn_style"
                        style="top: 20px; right: 20px; z-index: 10;"
                        data-bs-dismiss="modal" aria-label="Close">&#10005;
                </button>

                <div id="" class="position-relative d-flex justify-content-center align-items-center mt-2"
                    style="width: 80%;padding-bottom: 20px; font-size: 25px; color: #ffffff; text-align: center;">
                           {{ $product->product_name }}
                </div>

                <div class="container-fluid d-flex flex-column align-items-center mt-2 justify-content-center">

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

<!-- Modal Structure -->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content position-relative"
             style="background: url('{{ asset('assets') }}/img/customer_catalog/inquiry_modal_background.jpeg') center center / cover no-repeat; color: black;">

            <!-- Dark overlay for opacity -->
            <div style="position:absolute; top:0; left:0; width:100%; height:100%; background: rgba(255, 255, 255, 0.95); border-radius: inherit;"></div>

            <!-- Modal Header -->
            <div class="modal-header d-flex justify-content-between align-items-center position-relative"
                style="border-bottom: none; z-index:1;">

                <h5 class="modal-title send_inq_header mb-0" id="inquiryModalLabel">Send an Inquiry</h5>

                <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close"
                        style="border: none; background: none; font-size: 1.5rem; color: black;">
                    <i class="fas fa-times"></i>
                </button>

            </div>


            <!-- Modal Body -->
            <div class="modal-body position-relative" style="z-index:1; padding: 15px 20px !important;">
                <form action="{{ route('create_inquiry_catalog') }}" method="POST" id="inquiryForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">First Name <span style="color: red;">*</span></label>
                        <input type="text" name="first_name" class="form-control" placeholder="Name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="email" placeholder="Email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Team Name <span style="color: red;">*</span></label>
                        <input type="text" name="team_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sport <span style="color: red;">*</span></label>
                        <input type="text" name="sport" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number <span style="color: red;">*</span></label>
                        <input id="phone" type="tel" class="form-control" required>
                        <input type="hidden" name="phone_no" id="full_phone"> {{-- hidden field to send full number --}}
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" id="inquiryText" rows="3"></textarea>
                    </div>

                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_price" value="{{ $product->default_price }}">

                    <div style="text-align: center;">
                        <button type="submit" class="btn btn-primary submit_btn">
                            <i class="fa fas fa-paper-plane" style="padding-right: 8px;"></i>Submit
                        </button>
                    </div>
                </form>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script>

document.querySelectorAll('.fit-indicator').forEach(indicator => {
    const value = parseInt(indicator.dataset.fit, 10);

    const positionMap = {
        1: 0,
        2: 20,
        3: 45,
        4: 70,
        5: 90
    };

    const left = positionMap[value] ?? 50; // fallback = center

    indicator.style.left = left + '%';
});



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
});

    const input = document.querySelector("#phone");
    const iti = window.intlTelInput(input, {
        initialCountry: "auto",
        geoIpLookup: function(callback) {
            fetch('https://ipapi.co/json')
                .then(response => response.json())
                .then(data => callback(data.country_code))
                .catch(() => callback("lk")); // fallback
        },
        separateDialCode: true,
        preferredCountries: ["lk", "us", "gb", "au"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    });

    // Before form submit, put full number into hidden input
    document.querySelector("#inquiryForm").addEventListener("submit", function() {
        const fullNumber = iti.getNumber();
        document.querySelector("#full_phone").value = fullNumber;
    });
    document.addEventListener('DOMContentLoaded', function() {
    const fitContent = document.querySelector('.fit_content');
    fitContent.style.display = 'block';

    const toggleIcon = document.querySelector('#en-toggle-icon-fit i');
    toggleIcon.classList.remove('fa-plus');
    toggleIcon.classList.add('fa-minus');
});


</script>

<script>



let imageTimer;
let currentIndex = 0;
let images = [];

function showEmbellishmentHoverModal(imageList = [], label = '', description = '', fabrics = []) {
    const hoverModal = document.getElementById("hover_catch");
    const labelElement = document.getElementById("imageLabel");
    const descElement = document.getElementById("embellishmentDesc");
    const fabricWrapper = document.getElementById("fabricTags");
    const imageContainer = document.querySelector("#hover_catch .image-section2");
console.log(label);

    // Clean container
    imageContainer.innerHTML = '';

    // Filter out null images
    images = imageList.filter(img => img);
    currentIndex = 0;

    // Create two images to allow fade effect
    const imgA = document.createElement('img');
    const imgB = document.createElement('img');
    [imgA, imgB].forEach(img => {
        img.className = 'hover-image';
        img.id = 'hoverImage';
        imageContainer.appendChild(img);
    });
    // Add label overlay
    const overlayDiv = document.createElement('div');
    overlayDiv.className = 'fabric-overlay-text';

    const labelSpan = document.createElement('span');
    labelSpan.id = 'imageLabel';
    labelSpan.innerText = label;

    overlayDiv.appendChild(labelSpan);
    imageContainer.appendChild(overlayDiv);
    let activeImg = imgA, nextImg = imgB;

    activeImg.src = images[currentIndex];
    activeImg.classList.add("active");

    // Update text content
    // labelElement.innerText = label;
    descElement.innerHTML = description;

    // Fabric tags
    fabricWrapper.innerHTML = '';
    if ( fabrics == null) {
    document.getElementById('fabricTypesDisplay').style.display = 'none';
} else {
    document.getElementById('fabricTypesDisplay').style.display = 'block';
    fabrics.forEach(fab => {
        const span = document.createElement('span');
        span.className = 'embellishment-pill';
        span.textContent = fab;
        fabricWrapper.appendChild(span);
    });
}


    hoverModal.onmouseenter = () => {
        imageTimer = setInterval(() => {
            currentIndex = (currentIndex + 1) % images.length;
            nextImg.src = images[currentIndex];

            // Swap roles
            activeImg.classList.remove("active");
            nextImg.classList.add("active");

            [activeImg, nextImg] = [nextImg, activeImg]; // swap pointers
        }, 2000);
    };

    hoverModal.onmouseleave = () => {
        clearInterval(imageTimer);
        activeImg.classList.remove("active");
        nextImg.classList.remove("active");
    };
}





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

    // function changeMainImage(imageSrc) {

    //     document.getElementById('mainImage').src = imageSrc;


    //     document.getElementById('mainImage').setAttribute('onclick', 'openModal("' + imageSrc + '")');
    // }

    const imageList = [
    // {{-- Mockup images --}}
        @if (!empty($product->mockup_img_1)) "{{ asset('assets') . $product->mockup_img_1 }}", @endif
        @if (!empty($product->mockup_img_2)) "{{ asset('assets') . $product->mockup_img_2 }}", @endif
        @if (!empty($product->mockup_img_3)) "{{ asset('assets') . $product->mockup_img_3 }}", @endif

        // {{-- 3D images --}}
        @if (!empty($images_3d))
            @foreach ($images_3d as $image_3d)
                @if (!empty($image_3d->image_link))
                    "{{ asset($image_3d->image_link) }}",
                @endif
            @endforeach
        @endif
    ];

    let currentIndex2 = 0;
    let sliderInterval = null;
    let isPlaying = true;

    function changeMainImage(src, index = null) {
        document.getElementById('mainImage').src = src;

        // Remove previous active class
        document.querySelectorAll('.thumb-img').forEach(img => {
            img.classList.remove('active');
        });

        // Add active class to the correct one
        const activeThumb = document.querySelector(`.thumb-img[data-index="${index}"]`);
        if (activeThumb) {
            activeThumb.classList.add('active');
        }

        if (index !== null) currentIndex2 = index;
    }

    function startSlider() {
        sliderInterval = setInterval(() => {
            currentIndex2 = (currentIndex2 + 1) % imageList.length;
            changeMainImage(imageList[currentIndex2], currentIndex2);
        }, 2000);
    }
    function stopSlider() {
        clearInterval(sliderInterval);
    }

    // function toggleSlider() {
    //     const icon = document.getElementById('sliderIcon');
    //     if (isPlaying) {
    //         stopSlider();
    //         icon.classList.remove('fa-pause');
    //         icon.classList.add('fa-play');
    //     } else {
    //         startSlider();
    //         icon.classList.remove('fa-play');
    //         icon.classList.add('fa-pause');
    //     }
    //     isPlaying = !isPlaying;
    // }

    // Scroll buttons for thumbnail list
    // document.addEventListener('DOMContentLoaded', () => {
    //     startSlider();

    //     document.getElementById('scrollUp').addEventListener('click', () => {
    //         document.getElementById('thumbnailList').scrollBy({ top: -60, behavior: 'smooth' });
    //     });

    //     document.getElementById('scrollDown').addEventListener('click', () => {
    //         document.getElementById('thumbnailList').scrollBy({ top: 60, behavior: 'smooth' });
    //     });
    // });


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
            url: {!! json_encode(asset($image_3d->image_link)) !!},
            description: {!! json_encode(nl2br($image_3d->image_caption ?? '')) !!},
            name: ""
        });
        @endforeach

        @foreach ($lifeStyle_images as $lifeStyle_image)
        mockups.push({
            url: {!! json_encode(asset($lifeStyle_image->image_link)) !!},
            description: {!! json_encode(nl2br($lifeStyle_image->image_caption ?? '')) !!},
            name: ""
        });
        @endforeach

        @foreach ($studio_images as $studio_image)
        mockups.push({
            url: {!! json_encode(asset($studio_image->image_link)) !!},
            description: {!! json_encode(nl2br($studio_image->image_caption ?? '')) !!},
            name: ""
        });
        @endforeach

        @foreach ($closeUp_images as $closeUp_image)
        mockups.push({
            url: {!! json_encode(asset($closeUp_image->image_link)) !!},
            description: {!! json_encode(nl2br($closeUp_image->image_caption ?? '')) !!},
            name: ""
        });
        @endforeach

        @foreach ($branding_images as $branding_image)
        mockups.push({
            url: {!! json_encode(asset($branding_image->image_link)) !!},
            description: {!! json_encode(nl2br($branding_image->image_caption ?? '')) !!},
            name: ""
        });
        @endforeach

        // @foreach ($relatedAttributes as $relatedAttribute)
        // mockups.push({
        //     url: "{{ asset('') }}/{{ $relatedAttribute->image_1 }}",
        //     description: {!! json_encode(nl2br($relatedAttribute->description ?? '')) !!},
        //     name: "{{ $relatedAttribute->attribute_name ?? '' }}"
        // });
        // @endforeach

        // @foreach ($relatedFabric as $relatedFabrics)
        // mockups.push({
        //     url: "{{ asset('') }}/{{ $relatedFabrics['fabric_detail']->image_1 }}",
        //     description: {!! json_encode(nl2br($relatedFabrics['fabric_detail']->description ?? '')) !!},
        //     name: "{{ $relatedFabrics['fabric_detail']->fabric_name ?? '' }}"
        // });
        // @endforeach

        // @foreach ($relatedEmbellishments as $relatedEmbellishment)
        // mockups.push({
        //     url: "{{ asset('') }}/{{ $relatedEmbellishment->video_path }}",
        //     description: {!! json_encode(nl2br($relatedEmbellishment->description ?? '')) !!} ,
        //     name: "{{ $relatedEmbellishment->embellishment_name ?? '' }}"
        // });
        // @endforeach

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

            // if (mockups[currentIndex].description) {
            //     relatedAttributeDescription.style.display = "flex";
            //     relatedAttributeText.innerHTML = mockups[currentIndex].description;
            // } else {
            //     relatedAttributeDescription.style.display = "none";
            //     relatedAttributeText.innerHTML = "";
            // }

            // if (mockups[currentIndex].name) {
            //     relatedAttributeName.style.display = "flex";
            //     relatedName.innerText = mockups[currentIndex].name;
            // } else {
            //     relatedAttributeName.style.display = "none";
            //     relatedName.innerText = "";
            // }

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

    <button class="scroll-to-top" id="copyButton"><i class="fa fa-clone" aria-hidden="true" title="Copy Page URL"></i></button>

    <button class="scroll_up scroll-to-top " style="right: 90px;" id="scroll_up"><i class="fa fa-arrow-up" aria-hidden="true" title="Copy Page URL"></i></button>

    {{-- <form action="{{ route('search.products') }}" method="POST" id="searchForm">
        @csrf
        <input type="hidden" name="search" id="searchInput" value="">
        <button style="display: none;" type="submit">Submit</button>
    </form> --}}

    <form action="{{ route('search.products') }}" method="GET" id="searchForm" onsubmit="return submitSearchForm()">
        @csrf
        <input type="hidden" name="search" id="searchInput" value="">
        <button style="display: none;" type="submit">Submit</button>
    </form>

    <script>
document.addEventListener('DOMContentLoaded', function () {

    const gallery = document.getElementById('additionalImagesGallery');
    const seeMoreBtn = document.getElementById('seeMoreImagesBtn');

    if (!gallery || !seeMoreBtn) {
        return;
    }

    function handleMobileImages() {

        const images = gallery.querySelectorAll(':scope > div');

        // Desktop - show everything
        if (window.innerWidth > 768) {

            images.forEach(function (image) {
                image.classList.remove('additional-images-hidden');
            });

            seeMoreBtn.style.display = 'none';

            return;
        }

        // Mobile - show first 4
        if (images.length <= 4) {

            images.forEach(function (image) {
                image.classList.remove('additional-images-hidden');
            });

            seeMoreBtn.style.display = 'none';

            return;
        }

        images.forEach(function (image, index) {

            if (index >= 4) {
                image.classList.add('additional-images-hidden');
            } else {
                image.classList.remove('additional-images-hidden');
            }

        });

        seeMoreBtn.style.display = 'block';
    }

    handleMobileImages();

    window.addEventListener('resize', handleMobileImages);

    seeMoreBtn.addEventListener('click', function () {

        const images = gallery.querySelectorAll(':scope > div');

        images.forEach(function (image) {
            image.classList.remove('additional-images-hidden');
        });

        seeMoreBtn.style.display = 'none';
    });

});
</script>

    <script>
        document.getElementById("scroll_up").addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });

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
    {{-- <input type="hidden" id="userId" value="{{$token}}"> --}}

<script>

    // document.getElementById("description-topic").addEventListener("click", function() {
    //     document.querySelector(".description_content").classList.toggle("description_visible");
    // });

    // document.getElementById("fit-topic").addEventListener("click", function() {
    //     document.querySelector(".fit_content").classList.toggle("fit_visible");
    // });

    // document.getElementById("fabric-topic").addEventListener("click", function() {
    //     document.querySelector(".fabric_content").classList.toggle("fabric_visible");
    // });

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

        // Fit Topic Toggle
        // const fitTopic = document.getElementById("fit-topic");

        // if (fitTopic) {
        //     fitTopic.addEventListener("click", function () {

        //         const fitContent = document.querySelector(".fit_content");
        //         const toggleIconFit = this.querySelector(".fit-toggle i");

        //         if (!fitContent || !toggleIconFit) return;

        //         // Toggle visibility
        //         fitContent.classList.toggle("fit_visible");

        //         // Icon rotate (optional but clean UX)
        //         toggleIconFit.classList.toggle("rotate");
        //     });
        // }


        // Product Details Toggle
        const productDetailsTopic = document.getElementById("product-details-topic");

        if (productDetailsTopic) {
            productDetailsTopic.addEventListener("click", function () {

                const productDetailsContent = document.querySelector(".product_details_content");
                const toggleIcon = this.querySelector(".fit-toggle i");

                if (!productDetailsContent || !toggleIcon) return;

                // Toggle content
                productDetailsContent.classList.toggle("product_details_visible");

                // Rotate icon
                toggleIcon.classList.toggle("rotate");
            });
        }



        // Fabric Topic
        const fabricTopic = document.getElementById("fabric-topic");

        if (fabricTopic) {
            fabricTopic.addEventListener("click", function () {

                const fabricContent = document.querySelector(".fabric_content");
                const icon = this.querySelector(".fit-toggle i");

                if (!fabricContent) return;

                if (fabricContent.style.display === "block") {
                    fabricContent.style.display = "none";
                    icon.classList.add("rotate");
                } else {
                    fabricContent.style.display = "block";
                    icon.classList.remove("rotate");
                }
            });
        }

    });



    // document.addEventListener('DOMContentLoaded', function () {
    //     const fabricOptions = document.querySelectorAll('.fabric-option');
    //     const colorInfoDiv = document.getElementById('colorInfo');

    //     fabricOptions.forEach(option => {
    //         option.addEventListener('click', function () {

    //             fabricOptions.forEach(opt => {
    //                 opt.classList.remove('en-selected');
    //                 const detail = opt.querySelector('.en-fabric-details');
    //                 if (detail) detail.style.display = 'none';
    //             });

    //             this.classList.add('en-selected');
    //             const selectedDetail = this.querySelector('.en-fabric-details');
    //             if (selectedDetail) selectedDetail.style.display = 'block';

    //             fabricOptions.forEach(opt => opt.classList.remove('active'));
    //             this.classList.add('active');

    //             const subProductId = this.getAttribute('data-subProduct-id');

    //             colorInfoDiv.innerHTML = '';
    //             colorInfoDiv.classList.add('display_hide');

    //             $.ajax({
    //                 url: "{{ route('filterEmbellishment') }}",
    //                 method: "GET",
    //                 data: {
    //                     subProductId: subProductId,
    //                 },
    //                 success: function (response) {
    //                     console.log(response);

    //                     const embellishmentTypeDiv = document.getElementById('embellishmentType');
    //                     const embellishmentTypeTopic = document.getElementById('embellishmentTypeTopic');

    //                     embellishmentTypeDiv.innerHTML = '';
    //                     embellishmentTypeDiv.classList.remove('display_hide');
    //                     embellishmentTypeTopic.classList.remove('display_hide');



    //                     if (response.relatedEmbellishments && response.relatedEmbellishments.length > 0) {
    //                         response.relatedEmbellishments.forEach(function (embellishment) {

    //                             const embellishDiv = document.createElement('div');
    //                             embellishDiv.className = 'col-lg-5';
    //                             embellishDiv.className = 'padding_unset';

    //                             // Create <label>
    //                             const label = document.createElement('label');
    //                             label.className = 'en-fabric-option';

    //                             // Create .en-embellish-btn
    //                             const embellishBtn = document.createElement('div');
    //                             embellishBtn.className = 'en-embellish-btn';
    //                             embellishBtn.setAttribute('data-embellishmenttype-id', embellishment.id);

    //                             // Name container
    //                             const nameContainer = document.createElement('div');
    //                             nameContainer.className = 'en-fabric-name-container';

    //                             const nameSpan = document.createElement('span');
    //                             nameSpan.className = 'font-medium';
    //                             nameSpan.textContent = embellishment.embellishment_name;

    //                             const icon = document.createElement('i');
    //                             if (embellishment.embellishment_name == 'Sublimation') {
    //                                 icon.className = 'fas fa-fill-drip en-embellish-icon';
    //                             } else if (embellishment.embellishment_name == 'Embroidery') {
    //                                 icon.className = 'fa-solid fa-water en-embellish-icon';
    //                             } else if (embellishment.embellishment_name == 'Woven Label') {
    //                                 icon.className = 'fa-solid fa-ticket en-embellish-icon';
    //                             } else {
    //                                 icon.className = 'fa-solid fa-water en-embellish-icon';
    //                             }


    //                             nameContainer.appendChild(nameSpan);
    //                             nameContainer.appendChild(icon);

    //                             // Description text
    //                             const detailDiv = document.createElement('div');
    //                             detailDiv.className = 'en-embellish-details';
    //                             detailDiv.textContent = 'Embellishment Details';

    //                             embellishBtn.appendChild(nameContainer);
    //                             embellishBtn.appendChild(detailDiv);
    //                             label.appendChild(embellishBtn);
    //                             embellishDiv.appendChild(label);
    //                             embellishmentTypeDiv.appendChild(embellishDiv);

    //                             // Add click listener
    //                             embellishBtn.addEventListener('click', function () {
    //                                 const embellishmentOptions = document.querySelectorAll('.en-embellish-btn');
    //                                 embellishmentOptions.forEach(opt => opt.classList.remove('active'));
    //                                 this.classList.add('active');

    //                                 const embellishmentName = nameSpan.innerText;
    //                                 const colorTopic = document.getElementById('colorTopic');
    //                                 colorTopic.classList.remove('display_hide');

    //                                 if (embellishmentName === 'Sublimation') {
    //                                     colorInfoDiv.innerHTML = '<p style="font-size: 13px; color: rgb(95, 95, 95); font-weight: 500; margin-bottom: 0.2rem;">Customizable in any color</p>';
    //                                     colorInfoDiv.classList.remove('display_hide');
    //                                 } else {
    //                                     // Fetch related colors via AJAX
    //                                     $.ajax({
    //                                         url: "{{ route('getColorDetails') }}",
    //                                         method: "GET",
    //                                         data: {
    //                                             subProductId: subProductId,
    //                                         },
    //                                         success: function (response) {
    //                                             colorInfoDiv.innerHTML = '';
    //                                             if (response.relatedColors && response.relatedColors.length > 0) {
    //                                                 response.relatedColors.forEach(function (color) {
    //                                                     const colorDiv = document.createElement('div');
    //                                                     colorDiv.className = 'color_cercle';
    //                                                     colorDiv.style.backgroundColor = `#${color.hex}`;
    //                                                     colorDiv.title = color.pantone_code;
    //                                                     colorInfoDiv.appendChild(colorDiv);
    //                                                 });
    //                                             } else {
    //                                                 colorInfoDiv.innerHTML = '<p style="font-size: 13px; color: rgb(95, 95, 95); font-weight: 500; margin-bottom: 0.2rem;">No colors have been added.</p>';
    //                                             }
    //                                             colorInfoDiv.classList.remove('display_hide');
    //                                         }
    //                                     });
    //                                 }
    //                             });

    //                             // Add info icon modal trigger (if available)
    //                             if (embellishment.description || embellishment.video_path) {
    //                                 embellishBtn.style.cursor = 'pointer'; // Show clickable

    //                                 embellishBtn.addEventListener('click', function () {
    //                                     $.ajax({
    //                                         url: "{{ route('getEmbellishmentDetails') }}",
    //                                         method: "GET",
    //                                         data: {
    //                                             selectedEmbellishmentId: embellishment.id,
    //                                             subProductId: subProductId,
    //                                         },
    //                                         success: function (response) {
    //                                             const assetBaseUrl = "{{ asset('') }}";
    //                                             const imageListEM = [
    //                                                 response.embellishmentTypes.image_1,
    //                                                 response.embellishmentTypes.image_2,
    //                                                 response.embellishmentTypes.image_3,
    //                                                 response.embellishmentTypes.image_4
    //                                             ]
    //                                             .filter(Boolean)
    //                                             .map(image => assetBaseUrl + image);

    //                                             showEmbellishmentHoverModal(
    //                                                 imageListEM,
    //                                                 response.embellishmentTypes.embellishment_name,
    //                                                 response.embellishmentTypes.description,
    //                                                 response.embellishmentTypes.fabrics ? JSON.parse(response.embellishmentTypes.fabrics) : []
    //                                             );
    //                                             $('#embellishmentHoverModal').modal('show');
    //                                         }
    //                                     });
    //                                 });
    //                             }
    //                         });
    //                     } else {
    //                         embellishmentTypeDiv.innerHTML = '<div>No embellishments found.</div>';
    //                     }

    //                 },
    //                 error: function (jqXHR, textStatus, errorThrown) {
    //                     console.error("Error:", textStatus, errorThrown);
    //                 }
    //             });
    //         });
    //     });
    // });

    document.addEventListener('DOMContentLoaded', function () {
        const fabricOptions = document.querySelectorAll('.fabric-option');
        // const colorInfoDiv = document.getElementById('colorInfo');

        fabricOptions.forEach(option => {
            option.addEventListener('click', function () {

                fabricOptions.forEach(opt => {
                    opt.classList.remove('en-selected');
                    const detail = opt.querySelector('.en-fabric-details');
                    if (detail) detail.style.display = 'none';
                });

                this.classList.add('en-selected');
                const selectedDetail = this.querySelector('.en-fabric-details');
                if (selectedDetail) selectedDetail.style.display = 'block';

                fabricOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');

                const subProductId = this.getAttribute('data-subProduct-id');

                // colorInfoDiv.innerHTML = '';
                // colorInfoDiv.classList.add('display_hide');

                $.ajax({
                    url: "{{ route('filterEmbellishment') }}",
                    method: "GET",
                    data: {
                        product_id: subProductId,
                        'productType': '{{ request()->query('type') }}',
                    },
                    success: function (response) {
                        console.log(response);

                        const embellishmentTypeDiv = document.getElementById('embellishmentType');
                        const embellishmentTypeTopic = document.getElementById('embellishmentTypeTopic');

                        embellishmentTypeDiv.innerHTML = `
                            <div class="embellishment-flex" style="display:flex; justify-content: space-between; align-items:center; width:100%;">
                                <div class="embellishment-items" style="display:flex; gap:0px; flex-wrap:wrap;"></div>

                                <a href="{{ route('embellishmentPage') }}" target="_blank"
                                    class="view-all-embellishment d-inline-flex align-items-center gap-1 text-nowrap">
                                        View All <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        `;
                        embellishmentTypeDiv.classList.remove('display_hide');
                        embellishmentTypeTopic.classList.remove('display_hide');

                        const embellishmentItemsContainer = embellishmentTypeDiv.querySelector('.embellishment-items');

                        const sublimationTextSpan = document.querySelector('.sublimation_text');

                        let hasSublimation = false;

                        // check if Sublimation exists
                        if (response.relatedEmbellishments && response.relatedEmbellishments.length > 0) {
                            hasSublimation = response.relatedEmbellishments.some(function (emb) {
                                return emb.embellishment_name.toLowerCase() === 'sublimation';
                            });
                        }

                        // set text based on result
                        if (hasSublimation) {
                            sublimationTextSpan.innerText = "Sublimation included in list price. Embroidery and screen print start at $3 per item.";
                        } else {
                            sublimationTextSpan.innerText = "Embroidery and screen print start at $3 per item.";
                        }

                        if (response.relatedEmbellishments && response.relatedEmbellishments.length > 0) {
                            response.relatedEmbellishments.forEach(function (embellishment) {
                                const embellishDiv = document.createElement('div');
                                embellishDiv.className = 'col-lg-5';
                                embellishDiv.className = 'padding_unset';

                                // Create <label>
                                const label = document.createElement('label');
                                label.className = 'en-fabric-option';

                                // Create .en-embellish-btn
                                const embellishBtn = document.createElement('div');
                                embellishBtn.className = 'en-embellish-btn';
                                embellishBtn.setAttribute('data-embellishmenttype-id', embellishment.id);

                                // Name container
                                const nameContainer = document.createElement('div');
                                nameContainer.className = 'en-fabric-name-container';

                                const nameSpan = document.createElement('span');
                                nameSpan.className = 'font-medium';
                                nameSpan.textContent = embellishment.embellishment_name;

                                // const icon = document.createElement('i');
                                // if (embellishment.embellishment_name == 'Sublimation') {
                                //     icon.className = 'fas fa-fill-drip en-embellish-icon';
                                // } else if (embellishment.embellishment_name == 'Embroidery') {
                                //     icon.className = 'fa-solid fa-water en-embellish-icon';
                                // } else if (embellishment.embellishment_name == 'Woven Label') {
                                //     icon.className = 'fa-solid fa-ticket en-embellish-icon';
                                // } else {
                                //     icon.className = 'fa-solid fa-water en-embellish-icon';
                                // }


                                nameContainer.appendChild(nameSpan);
                                // nameContainer.appendChild(icon);

                                // Description text
                                const detailDiv = document.createElement('div');
                                detailDiv.className = '';
                                // detailDiv.textContent = 'Embellishment Details';

                                embellishBtn.appendChild(nameContainer);
                                embellishBtn.appendChild(detailDiv);
                                label.appendChild(embellishBtn);
                                embellishDiv.appendChild(label);
                                // embellishmentTypeDiv.appendChild(embellishDiv);
                                embellishmentItemsContainer.appendChild(embellishDiv);

                                // Add click listener
                                embellishBtn.addEventListener('click', function () {
                                    const embellishmentOptions = document.querySelectorAll('.en-embellish-btn');
                                    embellishmentOptions.forEach(opt => opt.classList.remove('active'));
                                    this.classList.add('active');

                                    const embellishmentName = nameSpan.innerText;
                                    // const colorTopic = document.getElementById('colorTopic');
                                    // colorTopic.classList.remove('display_hide');

                                    // if (embellishmentName === 'Sublimation') {
                                    //     colorInfoDiv.innerHTML = '<p style="font-size: 13px; color: rgb(95, 95, 95); font-weight: 500; margin-bottom: 0.2rem;">Customizable in any color</p>';
                                    //     colorInfoDiv.classList.remove('display_hide');
                                    // } else {
                                    //     // Fetch related colors via AJAX
                                    //     $.ajax({
                                    //         url: "{{ route('getColorDetails') }}",
                                    //         method: "GET",
                                    //         data: {
                                    //             subProductId: subProductId,
                                    //         },
                                    //         success: function (response) {
                                    //             colorInfoDiv.innerHTML = '';
                                    //             if (response.relatedColors && response.relatedColors.length > 0) {
                                    //                 response.relatedColors.forEach(function (color) {
                                    //                     const colorDiv = document.createElement('div');
                                    //                     colorDiv.className = 'color_cercle';
                                    //                     colorDiv.style.backgroundColor = `#${color.hex}`;
                                    //                     colorDiv.title = color.pantone_code;
                                    //                     colorInfoDiv.appendChild(colorDiv);
                                    //                 });
                                    //             } else {
                                    //                 colorInfoDiv.innerHTML = '<p style="font-size: 13px; color: rgb(95, 95, 95); font-weight: 500; margin-bottom: 0.2rem;">No colors have been added.</p>';
                                    //             }
                                    //             colorInfoDiv.classList.remove('display_hide');
                                    //         }
                                    //     });
                                    // }
                                });

                                // Add info icon modal trigger (if available)
                                if (embellishment.description || embellishment.video_path) {
                                    embellishBtn.style.cursor = 'pointer'; // Show clickable

                                    embellishBtn.addEventListener('click', function () {
                                        $.ajax({
                                            url: "{{ route('getEmbellishmentDetails') }}",
                                            method: "GET",
                                            data: {
                                                selectedEmbellishmentId: embellishment.id,
                                                subProductId: subProductId,
                                            },
                                            success: function (response) {
                                                const assetBaseUrl = "{{ asset('') }}";
                                                const imageListEM = [
                                                    response.embellishmentTypes.image_1,
                                                    response.embellishmentTypes.image_2,
                                                    response.embellishmentTypes.image_3,
                                                    response.embellishmentTypes.image_4
                                                ]
                                                .filter(Boolean)
                                                .map(image => assetBaseUrl + image);

                                                showEmbellishmentHoverModal(
                                                    imageListEM,
                                                    response.embellishmentTypes.embellishment_name,
                                                    response.embellishmentTypes.description,
                                                    response.embellishmentTypes.fabrics ? JSON.parse(response.embellishmentTypes.fabrics) : []
                                                );
                                                $('#embellishmentHoverModal').modal('show');
                                            }
                                        });
                                    });
                                }
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

        // ✅ Trigger click on the first fabric by default
        if (fabricOptions.length > 0) {
            fabricOptions[0].click();
        }
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
                        document.getElementById('relatedAttributeTextFabric').innerHTML  = '';
                        document.getElementById('relatedAttributeDescriptionFabric').style.display = 'none';
                        document.getElementById('modalImageFabric').src = ''; // Clear image src
                        document.getElementById('modalImageFabricMain').src = ''; // Clear image src

                        // Populate modal with the retrieved fabric details
                        if (response.subProduct && response.subProduct.fabric) {
                            // --------------------------
                            // Handle Fabric Colors
                            // --------------------------
                            const colorsWrapper = document.getElementById('fabricColorsWrapper');
                            colorsWrapper.innerHTML = ''; // Clear previous colors
                            var fabric = response.subProduct.fabric;
                            if (fabric.colors) {
                                let colorsArray;

                                try {
                                    colorsArray = typeof fabric.colors === 'string' ? JSON.parse(fabric.colors) : fabric.colors;
                                } catch (e) {
                                    console.error('Invalid colors JSON');
                                    colorsArray = [];
                                }

                                if (Array.isArray(colorsArray) && colorsArray.length > 0) {
                                    colorsArray.forEach(color => {
                                        const colorHtml = `
                                            <div class="color-option">
                                                <div class="color-swatch" style="background-color: ${color.code};"></div>
                                                <div class="color-label">${color.name}</div>
                                            </div>
                                        `;
                                        colorsWrapper.insertAdjacentHTML('beforeend', colorHtml);
                                    });

                                    // Show the section
                                    document.getElementById('fabricColorsDisplay').style.display = 'block';
                                } else {
                                    document.getElementById('fabricColorsDisplay').style.display = 'none';
                                }
                            }
                            // --------------------------
                            // Handle Embellishment Types
                            // --------------------------
                            const embellishmentWrapper = document.getElementById('embellishmentPillsWrapper');
                            embellishmentWrapper.innerHTML = ''; // Clear previous pills

                            const embellishments = response.subProduct.fabric.embellishments;

                            let embellishmentArray;
                            try {
                                embellishmentArray = typeof embellishments === 'string' ? JSON.parse(embellishments) : embellishments;
                            } catch (e) {
                                console.error('Invalid embellishments JSON');
                                embellishmentArray = [];
                            }

                            if (Array.isArray(embellishmentArray) && embellishmentArray.length > 0) {
                                embellishmentArray.forEach(item => {
                                    const pill = `<span class="embellishment-pill">${item}</span>`;
                                    embellishmentWrapper.insertAdjacentHTML('beforeend', pill);
                                });

                                document.getElementById('embellishmentTypesDisplay').style.display = 'block';
                            } else {
                                document.getElementById('embellishmentTypesDisplay').style.display = 'none';
                            }

                            // Display the fabric name
                            document.getElementById('relatedNameFabric').innerText = response.subProduct.fabric.fabric_name || '';
                            document.getElementById('relatedAttributeNameFabric').style.display = 'flex';

                            // Display the fabric description or any additional data
                            document.getElementById('relatedAttributeTextFabric').innerHTML = response.subProduct.fabric.description || '';
                            document.getElementById('relatedAttributeDescriptionFabric').style.display = 'flex';

                            // Set modal image source if available
                            if (response.subProduct.fabric.image_1) {
                                document.getElementById('modalImageFabric').src = assetBaseUrl + response.subProduct.fabric.image_1;
                            }
                            if (response.subProduct.fabric.image_2) {
                                document.getElementById('modalImageFabricMain').src = assetBaseUrl + response.subProduct.fabric.image_2;
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
                    document.getElementById('relatedAttributeTextFabric').innerHTML  = '';
                    document.getElementById('relatedAttributeDescriptionFabric').style.display = 'none';
                    document.getElementById('modalImageFabric').src = ''; // Clear image src
                    document.getElementById('modalImageFabricMain').src = ''; // Clear image src

                    // Populate modal with the retrieved fabric details
                    if (response.subProduct && response.subProduct.fabric) {
                        // Display the fabric name
                        document.getElementById('relatedNameFabric').innerText = response.subProduct.fabric.fabric_name || '';
                        document.getElementById('relatedAttributeNameFabric').style.display = 'flex';

                        // Display the fabric description or any additional data
                        document.getElementById('relatedAttributeTextFabric').innerHTML  = response.subProduct.fabric.description || '';
                        document.getElementById('relatedAttributeDescriptionFabric').style.display = 'flex';

                        // Set modal image source if available
                        if (response.subProduct.fabric.image_1) {
                            document.getElementById('modalImageFabric').src = assetBaseUrl + response.subProduct.fabric.image_1;
                        }
                        if (response.subProduct.fabric.image_2) {
                            document.getElementById('modalImageFabricMain').src = assetBaseUrl + response.subProduct.fabric.image_2;
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



    // const input = document.querySelector('.search_text');
    // const placeholderText = "Search Products By; Category, Sport, Style, Gender, Name";
    // let index = 0;

    // function updatePlaceholder() {
    //   input.setAttribute('placeholder', placeholderText.substring(0, index));

    //   if (index < placeholderText.length) {
    //     index++;
    //     setTimeout(updatePlaceholder, 100); // Adjust the delay (in milliseconds) between each letter
    //   } else {
    //     index = 0;
    //     setTimeout(updatePlaceholder, 1000); // Adjust the delay (in milliseconds) before it starts over
    //   }
    // }

    // updatePlaceholder();


  </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

{{-- <script>
    const images = [];
    let currentIndex = 0;

    // Store the mockup URLs separately for easier comparison
    let mockupImg1 = null;
    let mockupImg2 = null;
    let mockupImg3 = null;
    let mockupImg4 = null;
    let has3DImages = false;

    document.addEventListener("DOMContentLoaded", function() {
        // Add mockup images to the array
        @if (!empty($product->mockup_img_1))
        mockupImg1 = "{{ asset('assets') }}{{ $product->mockup_img_1 }}";
        images.push(mockupImg1);
        @endif

        @if (!empty($product->mockup_img_2))
        mockupImg2 = "{{ asset('assets') }}{{ $product->mockup_img_2 }}";
        images.push(mockupImg2);
        @endif

        @foreach ($images_3d as $image_3d)
            mockupImg3 = "{{ asset('') }}/{{ $image_3d->image_link }}";
            images.push(mockupImg3);
            has3DImages = true;
        @endforeach

        @foreach ($lifeStyle_images as $lifeStyle_image)
            mockupImg4 = "{{ asset('') }}/{{ $lifeStyle_image->image_link }}";
            images.push(mockupImg4);
            has3DImages = true;
        @endforeach

        @foreach ($relatedAttributes as $relatedAttribute)
            images.push("{{ asset('') }}/{{ $relatedAttribute->image_1 }}");
            has3DImages = false;
        @endforeach

        @foreach ($relatedFabric as $relatedFabrics)
            images.push("{{ asset('') }}/{{ $relatedFabrics['fabric_detail']->image_1 }}");
            has3DImages = false;
        @endforeach

        @foreach ($relatedEmbellishments as $relatedEmbellishment)
            images.push("{{ asset('') }}/{{ $relatedEmbellishment->video_path }}");
            has3DImages = false;
        @endforeach
    });

    function openModal(selectedImage) {
        // Find the index of the selected image
        currentIndex = images.indexOf(selectedImage);
        updateModalImage();

        // Open the modal
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }

    function updateModalImage() {
        // Update the modal image
        const modalImage = document.getElementById('modalImage');
        modalImage.src = images[currentIndex];

        const additionalInfo = document.getElementById('additionalInfo');

        // Check if the current image is mockupImg1 or mockupImg2
        const isMockupImage = modalImage.src === new URL(mockupImg1, window.location.origin).href ||
                            modalImage.src === new URL(mockupImg2, window.location.origin).href ||
                            modalImage.src === new URL(mockupImg3, window.location.origin).href ||
                            modalImage.src === new URL(mockupImg4, window.location.origin).href;

        // Toggle the 'display_hide' class based on whether the image is a mockup image
        if (isMockupImage || has3DImages ) {
            additionalInfo.classList.remove('display_hide');
        } else {
            additionalInfo.classList.add('display_hide');
        }

        // Disable navigation buttons if at start or end
        document.getElementById('prevButton').disabled = currentIndex === 0;
        document.getElementById('nextButton').disabled = currentIndex === images.length - 1;
    }

    function changeImage(direction) {
        currentIndex += direction;
        updateModalImage();
    }

</script> --}}

<script>
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


    <script>
        $(document).ready(function() {
            // Click event for the cart icon
            $('#cartDropdown').click(function(e) {
                e.preventDefault();

                // Toggle the dropdown menu
                $(this).next('.dropdown-menu').toggleClass('show');
            });
        });

        // document.getElementById("show-search-bar").addEventListener("click", function() {
        //     document.querySelector(".enquary_attribute_icon").classList.add("search_box_visible");
        //     document.querySelector(".search_box").classList.remove("search_box_visible");
        // });

        // document.getElementById("close-search").addEventListener("click", function() {
        //     document.querySelector(".search_box").classList.add("search_box_visible");
        //     document.querySelector(".enquary_attribute_icon").classList.remove("search_box_visible");
        // });


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

            function showEnPopup(url) {
        enPopupIframe.onload = () => {
          try {
            const iframeDocument = enPopupIframe.contentDocument || enPopupIframe.contentWindow.document;
            const contentWidth = iframeDocument.body.scrollWidth;
            const contentHeight = iframeDocument.body.scrollHeight;
            const maxWidth = window.innerWidth * 0.95;
            const maxHeight = window.innerHeight * 0.85;
            const finalWidth = Math.min(contentWidth, maxWidth);
            const finalHeight = Math.min(contentHeight, maxHeight);
            enPopupIframe.style.width = finalWidth + 'px';
            enPopupIframe.style.height = finalHeight + 'px';
            enPopupBox.style.width = finalWidth + 'px';
            enPopupBox.style.height = finalHeight + 'px';
          } catch (e) {
            enPopupIframe.style.width = '800px';
            enPopupIframe.style.height = '90vh';
            enPopupBox.style.width = '800px';
            enPopupBox.style.height = '90vh';
          }
        };

        enPopupIframe.src = url;
        enPopupOverlay.style.display = 'flex';
      }

      document.querySelectorAll('.en-fabric-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
          const sectionNum = this.name.split('-')[2];
          const embellishSection = document.getElementById(`en-embellishment-section-${sectionNum}`);

          // Remove selected class from all buttons in this section
          document.querySelectorAll(`.en-section-${sectionNum} .en-fabric-btn`).forEach(btn => {
            btn.classList.remove('en-selected');
          });

          // Add selected class to the clicked button
          this.nextElementSibling.classList.add('en-selected');

          // Show embellishment section
          if (embellishSection) {
            embellishSection.style.display = 'block';
          }
        });
      });

      document.querySelectorAll('.en-fabric-btn, .en-embellish-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          // Don't trigger if clicking on radio input
          if (e.target.tagName.toLowerCase() !== 'input') {
            const url = this.getAttribute('data-url');
            if (url) {
              showEnPopup(url);
            }
          }
        });
      });
    //   this.closest('.en-fabric-btn')?.classList.add('en-selected');


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


@endsection
