@extends('layouts.app', ['activePage' => 'fabrics', 'titlePage' => __('Fabrics')])

@section('content')

<style>
    .file-upload-wrapper {
        display: inline-block;
        position: relative;
    }

    .file-upload-wrapper input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
        height: 100%;
        width: 100%;
    }
    /* Small preview display */
    .preview-container {
        margin-top: 10px;
        display: flex;
        align-items: center;
    }
    .preview-container img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-left: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    .file-upload-text {
        display: none; /* Hidden by default */
    }
    .upload-area {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 95px;
        border: 2px dashed #ccc;
        text-align: center;
        padding: 10px;
        cursor: pointer;
    }

    .upload-area:hover {
        border: 2px dashed #007bff;
        cursor: pointer;
    }
    .table_header_text {
        text-align: center;
        color: white;
        height: 40px;
        border-left: 1px solid rgb(181, 181, 181);
    }
    .top_image_div {
        padding-bottom: 20px;
        border-bottom: 7px solid rgb(193, 193, 193);
    }
    .top_topic {
        text-align: center;
        margin-top: 15px;
        background-color: rgb(64, 64, 64);
        width: 100%;
    }
    .top_topic_red {
        text-align: center;
        margin-top: 15px;
        background-color: #8c8c8c;
        width: 200px;
        z-index: 1;
    }
    .top_topic_text {
        font-size: 30px;
        font-weight: 700;
        color: white;
    }
    .table_header_span {
        font-size: 13px;
    }
    .socks_topic {
        width: 100%;
        position: relative;
        top: -60px;
    }
    .btn-green-filled{
        outline: unset !important;
        color: white;
        background-color: #47D6B6;
        border: 2px solid #47D6B6;
        font-weight: 700;
        font-size: .7rem;
        cursor: pointer;
        padding: .4rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .save_button {
        position: relative;
        top: -39px;
        margin-right: 6px;
    }
    .color_gray_text {
        color: rgb(145, 145, 145);
    }
    .mobile-tabs { display: none; }

    /* MOBILE RESPONSIVE STYLES (max-width: 768px) */
    @media (max-width: 768px) {

        /* body {
            background-color: #f8fafc !important;
        } */

        /* -- Page Container -- */
        /* .content-position {
            position: relative !important;
            top: 0 !important;
            padding: 10px 14px 36px 14px !important;
            margin-bottom: 0 !important;
        } */

        /* .col-md-12 {
            padding: 0 !important;
        } */

        /* -- Back Arrow Button -- */
        /* .home-btn-color {
            font-size: 0 !important;
            color: transparent !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 32px !important;
            height: 32px !important;
            background-color: #f1f5f9 !important;
            border-radius: 50% !important;
            text-decoration: none !important;
            position: absolute !important;
            left: 16px !important;
            top: 14px !important;
            z-index: 20 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
        } */

        /* .home-btn-color::before {
            content: "\f053" !important;
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            font-size: 11px !important;
            color: #94a3b8 !important;
        } */

        /* -- Header title -- */
        /* .header1 {
            display: block !important;
            width: 100% !important;
            text-align: center !important;
            margin: 0 !important;
            padding: 6px 0 10px 0 !important;
        } */

        /* .headder_size,
        #header span {
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #64748b !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase !important;
        } */

        /* -- Top Body Diagram Image Area -- */
        .top_image_div {
            position: relative !important;
            border-bottom: none !important;
            background: #ffffff !important;
            border-radius: 14px !important;
            padding: 0 !important;
            margin: 0 0 14px 0 !important;
            display: flex !important;
            flex-direction: column !important;
            border: 1px solid #e2e8f0 !important;
            overflow: hidden !important;
        }

        .top_image_div img {
            width: 100% !important;
            height: auto !important;
            display: block !important;
            object-fit: contain !important;
            order: 2 !important;
        }

        /* Export button (visual only - generated via CSS) */
        /* .top_image_div::before {
            content: "\f019\00a0\00a0 Export" !important;
            font-family: 'Font Awesome 5 Free', 'Open Sans', sans-serif !important;
            font-weight: 600 !important;
            order: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: calc(100% - 24px) !important;
            height: 42px !important;
            margin: 12px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            background-color: #ffffff !important;
            color: #64748b !important;
            font-size: 13px !important;
            cursor: pointer !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
            box-sizing: border-box !important;
        } */

        /* Zoom icon circle at top-right of diagram */
        /* .top_image_div::after {
            content: "\f00e" !important;
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            position: absolute !important;
            top: 72px !important;
            right: 14px !important;
            width: 30px !important;
            height: 30px !important;
            background-color: #334155 !important;
            color: #ffffff !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 12px !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.18) !important;
            z-index: 5 !important;
            pointer-events: none !important;
        } */

        /* -- Section header rows (Men's Sizes, Boy's Youth Sizes, etc.) -- */
        .row:has(> .top_topic) {
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            display: block !important;
            position: relative !important;
        }

        /* Hide the grey "SOCKS" badge (desktop overlap layout) */
        .top_topic_red {
            display: none !important;
        }

        .top_topic,
        div.top_topic {
            position: static !important;
            top: auto !important;
            margin: 0 !important;
            background-color: #222629 !important;
            border-radius: 14px 14px 0 0 !important;
            padding: 15px 18px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            text-align: left !important;
            cursor: pointer !important;
            box-shadow: none !important;
            box-sizing: border-box !important;
        }

        /* Socks_topic (the second top_topic in the row for socks) */
        .socks_topic {
            position: static !important;
            top: auto !important;
            width: 100% !important;
            margin: 0 !important;
        }

        /* Prefix socks header with "Socks — " to match design */
        .socks_topic .top_topic_text::before {
            content: "Socks \2014 " !important;
        }

        .top_topic_text {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            letter-spacing: 0.01em !important;
            margin: 0 !important;
            text-transform: capitalize !important;
        }

        /* Chevron icon on accordion headers */
        .top_topic::after {
            content: "\f078" !important;
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            font-size: 12px !important;
            color: #ffffff !important;
            opacity: 0.7 !important;
        }

        /* Hide the desktop SAVE button in the dark header row */
        /* .save_button {
            display: none !important;
        } */
        
        .order_sammary_table.card::after {
            display: none !important;
        }

        .order_sammary_table.card .save_button {
            position: absolute !important;
            top: auto !important;
            bottom: 14px !important;
            right: 14px !important;
            width: calc(50% - 20px) !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .order_sammary_table.card .save_button button {
            width: 100% !important;
            height: 48px !important;
            border: none !important;
            border-radius: 10px !important;
            background-color: #10b981 !important;
            color: #ffffff !important;
            font-size: 0 !important;
            padding: 0 !important;
            box-shadow: 0 2px 8px rgba(16,185,129,0.25) !important;
        }

        .order_sammary_table.card .save_button button::after {
            content: "Save Changes";
            font-size: 14px;
            font-weight: 600;
        }

        /* -- Open Accordion Card (table container) -- */
        .order_sammary_table.card {
            background-color: #ffffff !important;
            border-radius: 0 0 14px 14px !important;
            border: 1px solid #e2e8f0 !important;
            border-top: none !important;
            box-shadow: 0 4px 14px rgba(0,0,0,0.05) !important;
            margin: 0 0 10px 0 !important;
            padding: 14px 14px 76px 14px !important;
            overflow-x: hidden !important;
            overflow-y: visible !important;
            display: flex !important;
            flex-direction: column !important;
            position: relative !important;
        }

        #global_check_icon {
            display: none !important;
        }

        /* -- Size Pill Row (XS, S, M, L, XL, XXL, 3XL) -- */
        table.table,
        table.table#order_sammary_table {
            display: block !important;
            width: 100% !important;
            min-width: 0 !important;
            border-collapse: collapse !important;
        }

        table.table thead {
            display: block !important;
            width: 100% !important;
            background: transparent !important;
            border: none !important;
            margin-bottom: 16px !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            scrollbar-width: none !important;
        }

        table.table thead::-webkit-scrollbar {
            display: none !important;
        }

        table.table thead tr {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 7px !important;
            width: max-content !important;
            background: transparent !important;
            border: none !important;
            padding: 2px 0 !important;
        }

        /* Hide the first empty th placeholder */
        table.table thead tr th:first-child {
            display: none !important;
        }

        /* Size pill styling */
        table.table thead tr th.table_header_text {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 34px !important;
            min-width: 36px !important;
            padding: 0 12px !important;
            border: 1.5px solid transparent !important;
            background-color: #e2e8f0 !important;
            border-radius: 999px !important;
            color: #64748b !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            box-sizing: border-box !important;
            flex: 0 0 auto !important;
        }

        /* First active pill -- teal ring + teal text */
        /* table.table thead tr th.table_header_text:nth-child(2) {
            background-color: #f0fdf9 !important;
            color: #0d9488 !important;
            border: 1.5px solid #0d9488 !important;
        } */

        table.table thead tr th.table_header_text.active {
            background-color: #f0fdf9 !important;
            color: #0d9488 !important;
            border: 1.5px solid #0d9488 !important;
        }

        table.table thead tr th.table_header_text .table_header_span {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: inherit !important;
        }

        /* -- Table Body: stacked form-field rows -- */
        table.table tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 14px !important;
            width: 100% !important;
        }

        table.table tbody tr {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            background: transparent !important;
        }

        /* Row header label (HEIGHT, WEIGHT, etc.) -- small label above inputs */
        table.table tbody tr th {
            display: block !important;
            width: 100% !important;
            padding: 0 0 6px 0 !important;
            border: none !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            text-align: left !important;
            vertical-align: top !important;
            white-space: nowrap !important;
            text-transform: capitalize !important;
        }

        /* Unit suffixes for Men/Women sections */
        #adult_men_table_body tr:nth-child(2) th::after,
        #adult_women_table_body tr:nth-child(2) th::after { content: " (lbs)" !important; }
        #adult_men_table_body tr:nth-child(3) th::after,
        #adult_women_table_body tr:nth-child(3) th::after { content: " (in)" !important; }
        #adult_men_table_body tr:nth-child(4) th::after,
        #adult_women_table_body tr:nth-child(4) th::after { content: " (in)" !important; }

        /* Only show first td (active size column), hide the rest on mobile */
        table.table tbody tr td {
            display: none !important;
            border: none !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* table.table tbody tr td:first-of-type {
            display: block !important;
            width: 100% !important;
        } */

        table.table tbody tr td.active-col {
            display: block !important;
            width: 100% !important;
        }

        /* Inner row of inputs + dash */
        table.table tbody tr td .row {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: flex-start !important;
            width: 100% !important;
            min-width: 0 !important;
            margin: 0 !important;
            gap: 6px !important;
            flex-wrap: nowrap !important;
        }

        /* All form inputs in mobile view */
        table.table tbody tr td input.form-control {
            flex: 1 1 0 !important;
            width: auto !important;
            min-width: 0 !important;
            height: 48px !important;
            border-radius: 10px !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important;
            color: #1e293b !important;
            font-size: 15px !important;
            font-weight: 500 !important;
            text-align: center !important;
            box-shadow: none !important;
            outline: none !important;
            box-sizing: border-box !important;
            padding: 6px 4px !important;
            margin: 0 !important;
        }

        /* Dash separator spans */
        table.table tbody tr td .row span[style*="padding-top: 8px"] {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 2px !important;
            color: #94a3b8 !important;
            font-size: 16px !important;
            font-weight: 400 !important;
            flex-shrink: 0 !important;
        }

        /* Hide unit text spans (', ", lbs) */
        table.table tbody tr td .row > span:not([style*="padding-top: 8px"]) {
            display: none !important;
        }

        /* -- Reset & Save Changes footer buttons area -- */
        /* Use ::before for Reset and ::after for Save Changes at bottom of card */
        /* .order_sammary_table.card::before {
            content: "Reset" !important;
            position: absolute !important;
            bottom: 14px !important;
            left: 14px !important;
            width: calc(50% - 20px) !important;
            height: 48px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background-color: #f1f5f9 !important;
            border-radius: 10px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #334155 !important;
            box-sizing: border-box !important;
            pointer-events: none !important;
            order: 10 !important;
        } */

        /* .order_sammary_table.card::after {
            content: "Save Changes" !important;
            position: absolute !important;
            bottom: 14px !important;
            right: 14px !important;
            width: calc(50% - 20px) !important;
            height: 48px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background-color: #e2e8f0 !important;
            border-radius: 10px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #94a3b8 !important;
            box-sizing: border-box !important;
            pointer-events: none !important;
            order: 11 !important;
        } */

        /* When user changes input, make save changes green (via JS existing class toggle) */
        .order_sammary_table.card.has-changes::after {
            background-color: #10b981 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(16,185,129,0.25) !important;
        }

        /* Collapsed state */
        .top_topic.collapsed-section::after {
            transform: rotate(-90deg) !important;
        }

        /* .collapsed-section-card {
            display: none !important;
        } */

        .order_sammary_table.card.collapsed-section-card {
            display: none !important;
        }

        .top_topic::after {
            transition: transform .2s ease !important;
        }

        /* Keep header rounded when its card is hidden */
        .top_topic.collapsed-section {
            border-radius: 14px !important;
            margin-bottom: 10px !important;
        }

        .mobile-tabs {
            display: flex !important;
            gap: 10px;
            overflow-x: auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 10px;
            margin: 0 0 14px 0;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }
        .mobile-tabs::-webkit-scrollbar { display: none; }

        .mobile-tab {
            flex: 0 0 auto;
            height: 40px;
            padding: 0 26px;
            border-radius: 999px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 500;
            outline: none;
        }
        .mobile-tab.active {
            background: #1e2227;
            border-color: #1e2227;
            color: #fff;
        }

        /* top image zoom in */
        .top_image_div::after {
            content: "\f00e" !important;
            font-family: 'Font Awesome 5 Free', 'FontAwesome' !important;
            font-weight: 900 !important;
            position: absolute !important;
            top: 12px !important;
            right: 12px !important;
            width: 34px !important;
            height: 34px !important;
            background-color: #4b5563 !important;
            color: #ffffff !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 14px !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.18) !important;
            /* z-index: 5 !important; */
            pointer-events: none !important;
        }

        /* zoomed state: fullscreen image, no new HTML */
        .top_image_div.zoomed {
            position: fixed !important;
            inset: 0 !important;
            z-index: 99999 !important;
            margin: 0 !important;
            border-radius: 0 !important;
            background: rgba(0,0,0,0.9) !important;
            overflow: auto !important;
            justify-content: center !important;
        }
        .top_image_div.zoomed img {
            width: 200% !important;
            max-width: none !important;
        }
        .top_image_div.zoomed::after {
            content: "\f00d" !important;
        }
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>SIZE CHART</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12" style="padding: 0rem;">

        <div class="top_image_div">
            <img src="{{ asset('assets') }}\img\sizingFit\lighter.png" style="width: 100%;" alt="">
        </div>

        <div class="mobile-tabs">
            <button type="button" class="mobile-tab active" data-target="0">Men</button>
            <button type="button" class="mobile-tab" data-target="2">Women</button>
            <button type="button" class="mobile-tab" data-target="1">Boys</button>
            <button type="button" class="mobile-tab" data-target="3">Girls</button>
            <button type="button" class="mobile-tab" data-target="4,5">Socks</button>
        </div>

        {{-- Mens Sizes --}}
        <div class="row" style="margin: unset; height: 60px;">
            <div class="top_topic">
                <span class="top_topic_text">MEN'S SIZES</span>
            </div>
            <div class="ml-auto save_button">
                <button class="btn-green-filled" style="outline: unset;" href="#" id="man_size_save" title="Adult Men's Sizes Save">
                    SAVE
                </button>
            </div>
        </div>


        <div class="order_sammary_table card" style="overflow-x: auto; margin-top: 10px; padding: 10px; border: unset;">

            <div id="global_check_icon" style="text-align: right; padding-right: 10px;"></div>

            <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                <thead style="background-color: #afafaf;" id="adult_men_table_header">
                    <tr>

                    </tr>
                </thead>

                <tbody id="adult_men_table_body" class="color_gray_text">
                    <tr>
                        <th style="padding: 5px;">HEIGHT</th>
                        @foreach ($adultSizes as $adultSize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">
                                    @php

                                        $isHeightFrom = false;
                                        $sizeFrom = null;
                                        $isHeightTo = false;
                                        $sizeTo = null;
                                    @endphp

                                    @foreach ($adultMenSizes as $adultMenSize)
                                        @if ($adultMenSize->size_id == $adultSize->id && $adultMenSize->type == 'height')
                                            @php
                                                $isHeightFrom = true;
                                                $sizeFrom = $adultMenSize->size_from;
                                                $sizeTo = $adultMenSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isHeightFrom && $sizeFrom)
                                        @php
                                            // Extract feet and inches from sizeFrom
                                            preg_match('/(\d+)\s*\'\s*(\d*)/', $sizeFrom, $matchesFrom);
                                            $feetFrom = isset($matchesFrom[1]) ? $matchesFrom[1] : '';
                                            $inchesFrom = isset($matchesFrom[2]) && $matchesFrom[2] !== '' ? $matchesFrom[2] : ''; // Keep inches empty if not available
                                        @endphp

                                        <input type="text" style="width: 30px;" id="men_height_from_feet_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $feetFrom }}"> <span> ' </span>
                                        <input type="text" style="width: 30px;" id="men_height_from_inch_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $inchesFrom }}"> <span> " </span>
                                    @else
                                        <input type="text" style="width: 30px;" id="men_height_from_feet_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"> <span> ' </span>
                                        <input type="text" style="width: 30px;" id="men_height_from_inch_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"> <span> " </span>
                                    @endif

                                    <span style="padding-right: 5px; padding-left: 5px; padding-top: 8px;"> - </span>

                                    @if ($isHeightFrom && $sizeTo)
                                        @php
                                            // Extract feet and inches from sizeTo
                                            preg_match('/(\d+)\s*\'\s*(\d*)/', $sizeTo, $matchesTo);
                                            $feetTo = isset($matchesTo[1]) ? $matchesTo[1] : '';
                                            $inchesTo = isset($matchesTo[2]) && $matchesTo[2] !== '' ? $matchesTo[2] : ''; // Keep inches empty if not available
                                        @endphp

                                        <input type="text" style="width: 30px;" id="men_height_to_feet_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $feetTo }}"> <span> ' </span>
                                        <input type="text" style="width: 30px;" id="men_height_to_inch_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $inchesTo }}"> <span> " </span>
                                    @else
                                        <input type="text" style="width: 30px;" id="men_height_to_feet_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"> <span> ' </span>
                                        <input type="text" style="width: 30px;" id="men_height_to_inch_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"> <span> " </span>
                                    @endif
                                </div>
                            </td>
                        @endforeach

                    </tr>
                    <tr>
                        <th style="padding: 5px;">WEIGHT</th>
                        @foreach ($adultSizes as $adultSize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">

                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">
                                    @php
                                        $isWeighttFrom = false;
                                        $sizeFromWeight = null;
                                        $isWeighttTo = false;
                                        $sizeToWeight = null;
                                    @endphp
                                    @foreach ($adultMenSizes as $adultMenSize)
                                        @if ($adultMenSize->size_id == $adultSize->id && $adultMenSize->type == 'weight')
                                            @php
                                                $isWeighttFrom = true;
                                                $sizeFromWeight = $adultMenSize->size_from;
                                                $sizeToWeight = $adultMenSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isWeighttFrom && $sizeFromWeight)
                                        <input type="text" style="width: 50px;" id="men_weight_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeFromWeight }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="men_weight_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif

                                    @if ($sizeToWeight)
                                        <input type="text" style="width: 50px;" id="men_weight_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeToWeight }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> lbs </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="men_weight_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> lbs </span>
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">CHEST SIZE</th>
                        @foreach ($adultSizes as $adultSize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">
                                    @php
                                        $isChestFrom = false;
                                        $sizeFromChest = null;
                                        $isChestTo = false;
                                        $sizeToChest = null;
                                    @endphp
                                    @foreach ($adultMenSizes as $adultMenSize)
                                        @if ($adultMenSize->size_id == $adultSize->id && $adultMenSize->type == 'chest')
                                            @php
                                                $isChestFrom = true;
                                                $sizeFromChest = $adultMenSize->size_from;
                                                $sizeToChest = $adultMenSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isChestFrom && $sizeFromChest)
                                        <input type="text" style="width: 50px;" id="men_chest_from_{{ $adultSize->id }}"  class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeFromChest }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="men_chest_from_{{ $adultSize->id }}"  class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif
                                    @if ($sizeToChest)
                                        <input type="text" style="width: 50px;" id="men_chest_to_{{ $adultSize->id }}"  class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeToChest }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="men_chest_to_{{ $adultSize->id }}"  class="form-control" data-size-id="{{ $adultSize->id }}">
                                    @endif
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">WAIST SIZE</th>
                        @foreach ($adultSizes as $adultSize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">
                                    @php
                                        $isWaistFrom = false;
                                        $sizeFromWaist = null;
                                        $isWaistTo = false;
                                        $sizeToWaist = null;
                                    @endphp
                                    @foreach ($adultMenSizes as $adultMenSize)
                                        @if ($adultMenSize->size_id == $adultSize->id && $adultMenSize->type == 'waist')
                                            @php
                                                $isWaistFrom = true;
                                                $sizeFromWaist = $adultMenSize->size_from;
                                                $sizeToWaist = $adultMenSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isWaistFrom && $sizeFromWaist)
                                        <input type="text" style="width: 50px;" id="men_waist_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeFromWaist }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="men_waist_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif
                                    @if ($sizeToWaist)
                                        <input type="text" style="width: 50px;" id="men_waist_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeToWaist }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="men_waist_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}">
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

        </div>
        {{-- End Mens Sizes --}}

        {{-- Boy Sizes --}}
        <div class="row"  style="margin: unset; height: 60px;">
            <div class="top_topic">
                <span class="top_topic_text">BOY'S YOUTH SIZES</span>
            </div>
            <div class="ml-auto save_button">
                <button class="btn-green-filled" style="outline: unset;" href="#" id="boy_size_save" title="Boy's Sizes Save">
                    SAVE
                </button>
            </div>
        </div>


        <div class="order_sammary_table card" style="overflow-x: auto; margin-top: 10px; padding: 10px; border: unset;">

            <div id="global_check_icon" style="text-align: right; padding-right: 10px;"></div>

            <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                <thead style="background-color: #afafaf;" id="boy_table_header">
                    <tr>

                    </tr>
                </thead>

                <tbody id="boy_table_body" class="color_gray_text">
                    <tr>
                        <th style="padding: 5px;">HEIGHT</th>
                        @foreach ($boySizes as $boySize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php

                                        $isHeightFromBoy = false;
                                        $sizeFromBoy = null;
                                        $isHeightTo = false;
                                        $sizeToBoy = null;
                                    @endphp

                                    @foreach ($youthBoySizes as $youthBoySize)
                                        @if ($youthBoySize->size_id == $boySize->id && $youthBoySize->type == 'height')
                                            @php
                                                $isHeightFromBoy = true;
                                                $sizeFromBoy = $youthBoySize->size_from;
                                                $sizeToBoy = $youthBoySize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isHeightFromBoy && $sizeFromBoy)
                                        @php
                                            preg_match('/(\d+)\s*\'\s*(\d*)/', $sizeFromBoy, $matchesFrom);
                                            $feetFromBoy = isset($matchesFrom[1]) ? $matchesFrom[1] : '';
                                            $inchesFromBoy = isset($matchesFrom[2]) && $matchesFrom[2] !== '' ? $matchesFrom[2] : ''; // Keep inches empty if not available
                                        @endphp

                                        <input type="text" style="width: 30px;" id="boy_height_from_feet_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $feetFromBoy }}"> <span> ' </span>
                                        <input type="text"style="width: 30px;"  id="boy_height_from_inch_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $inchesFromBoy }}"> <span> " </span>
                                    @else
                                        <input type="text" style="width: 30px;" id="boy_height_from_feet_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"> <span> ' </span>
                                        <input type="text"style="width: 30px;"  id="boy_height_from_inch_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"> <span> " </span>
                                    @endif

                                    <span style="padding-right: 5px; padding-left: 5px; padding-top: 8px;"> - </span>

                                    @if ($sizeToBoy)
                                        @php
                                            preg_match('/(\d+)\s*\'\s*(\d*)/', $sizeToBoy, $matchesTo);
                                            $feetToBoy = isset($matchesTo[1]) ? $matchesTo[1] : '';
                                            $inchesToBoy = isset($matchesTo[2]) && $matchesTo[2] !== '' ? $matchesTo[2] : ''; // Keep inches empty if not available
                                        @endphp

                                        <input type="text"style="width: 30px;"  id="boy_height_to_feet_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $feetToBoy }}">  <span> ' </span>
                                        <input type="text"style="width: 30px;"  id="boy_height_to_inch_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $inchesToBoy }}">  <span> " </span>
                                    @else
                                    <input type="text"style="width: 30px;"  id="boy_height_to_feet_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}">  <span> ' </span>
                                    <input type="text"style="width: 30px;"  id="boy_height_to_inch_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}">  <span> " </span>
                                    @endif

                                </div>

                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">WEIGHT</th>
                        @foreach ($boySizes as $boySize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isWeighttFrom = false;
                                        $sizeFromWeight = null;
                                        $isWeighttTo = false;
                                        $sizeToWeight = null;
                                    @endphp
                                    @foreach ($youthBoySizes as $youthBoySize)
                                        @if ($youthBoySize->size_id == $boySize->id && $youthBoySize->type == 'weight')
                                            @php
                                                $isWeighttFrom = true;
                                                $sizeFromWeight = $youthBoySize->size_from;
                                                $sizeToWeight = $youthBoySize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isWeighttFrom && $sizeFromWeight)
                                        <input type="text" style="width: 50px;" id="boy_weight_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeFromWeight }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                    <input type="text" style="width: 50px;" id="boy_weight_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif

                                    @if ($sizeToWeight)
                                        <input type="text" style="width: 50px;" id="boy_weight_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeToWeight }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> lbs </span>
                                    @else
                                    <input type="text" style="width: 50px;" id="boy_weight_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> lbs </span>
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">T-SHIRT/PANT SIZE</th>
                        @foreach ($boySizes as $boySize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">


                                    @php
                                        $isTPantFrom = false;
                                        $sizeFromTPant = null;
                                        $isTPantTo = false;
                                        $sizeToTPant = null;
                                    @endphp
                                    @foreach ($youthBoySizes as $youthBoySize)
                                        @if ($youthBoySize->size_id == $boySize->id && $youthBoySize->type == 'tPant')
                                            @php
                                                $isTPantFrom = true;
                                                $sizeFromTPant = $youthBoySize->size_from;
                                                $sizeToTPant = $youthBoySize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isTPantFrom && $sizeFromTPant)
                                        <input type="text" style="width: 50px;" id="boy_tPant_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeFromTPant }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                    <input type="text" style="width: 50px;" id="boy_tPant_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif

                                    @if ($sizeToTPant)
                                        <input type="text" style="width: 50px;" id="boy_tPant_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"  value="{{ $sizeToTPant }}">
                                    @else
                                    <input type="text" style="width: 50px;" id="boy_tPant_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}">
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">CHEST SIZE</th>
                        @foreach ($boySizes as $boySize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isChestFrom = false;
                                        $sizeFromChest = null;
                                        $isChestTo = false;
                                        $sizeToChest = null;
                                    @endphp
                                    @foreach ($youthBoySizes as $youthBoySize)
                                        @if ($youthBoySize->size_id == $boySize->id && $youthBoySize->type == 'chest')
                                            @php
                                                $isChestFrom = true;
                                                $sizeFromChest = $youthBoySize->size_from;
                                                $sizeToChest = $youthBoySize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isChestFrom && $sizeFromChest)
                                        <input type="text" style="width: 50px;" id="boy_chest_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeFromChest }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="boy_chest_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif
                                    @if ($sizeToChest)
                                        <input type="text" style="width: 50px;" id="boy_chest_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeToChest }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="boy_chest_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}">
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">WAIST SIZE</th>
                        @foreach ($boySizes as $boySize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isWaistFrom = false;
                                        $sizeFromWaist = null;
                                        $isWaistTo = false;
                                        $sizeToWaist = null;
                                    @endphp
                                    @foreach ($youthBoySizes as $youthBoySize)
                                        @if ($youthBoySize->size_id == $boySize->id && $youthBoySize->type == 'waist')
                                            @php
                                                $isWaistFrom = true;
                                                $sizeFromWaist = $youthBoySize->size_from;
                                                $sizeToWaist = $youthBoySize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isWaistFrom && $sizeFromWaist)
                                        <input type="text" style="width: 50px;" id="boy_waist_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeFromWaist }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="boy_waist_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif
                                    @if ($sizeToWaist)
                                        <input type="text" style="width: 50px;" id="boy_waist_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeToWaist }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="boy_waist_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}">
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

        </div>

        {{-- End Boy Sizes --}}


        {{-- Womens Sizes --}}


        <div class="row" style="margin: unset; height: 60px;">
            <div class="top_topic">
                <span class="top_topic_text">WOMEN'S SIZES</span>
            </div>
            <div class="ml-auto save_button">
                <button class="btn-green-filled" style="outline: unset;" href="#" id="women_size_save" title="Adult Women's Sizes Save">
                    SAVE
                </button>
            </div>
        </div>

        <div class="order_sammary_table card" style="overflow-x: auto; margin-top: 10px; padding: 10px; border: unset;">

            <div id="global_check_icon" style="text-align: right; padding-right: 10px;"></div>

            <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                <thead style="background-color: #afafaf;" id="adult_women_table_header">
                    <tr>

                    </tr>
                </thead>

                <tbody id="adult_women_table_body" class="color_gray_text">
                    <tr>
                        <th style="padding: 5px;">SIZE</th>
                        @foreach ($adultSizes as $adultSize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php

                                        $isHeightFrom = false;
                                        $sizeFrom = null;
                                        $isHeightTo = false;
                                        $sizeTo = null;
                                    @endphp

                                    @foreach ($adultWomenSizes as $adultWomenSize)
                                        @if ($adultWomenSize->size_id == $adultSize->id && $adultWomenSize->type == 'height')
                                            @php
                                                $isHeightFrom = true;
                                                $sizeFrom = $adultWomenSize->size_from;
                                                $sizeTo = $adultWomenSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isHeightFrom && $sizeFrom)
                                        @php
                                            // Extract feet and inches from sizeFrom
                                            preg_match('/(\d+)\s*\'\s*(\d*)/', $sizeFrom, $matchesFrom);
                                            $feetFrom = isset($matchesFrom[1]) ? $matchesFrom[1] : '';
                                            $inchesFrom = isset($matchesFrom[2]) && $matchesFrom[2] !== '' ? $matchesFrom[2] : ''; // Keep inches empty if not available
                                        @endphp

                                        <input type="text" style="width: 30px;" id="women_height_from_feet_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $feetFrom }}">
                                        {{-- <input type="text" style="width: 30px;" id="women_height_from_inch_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $inchesFrom }}"> --}}
                                    @else
                                        <input type="text" style="width: 30px;" id="women_height_from_feet_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}">
                                        {{-- <input type="text" style="width: 30px;" id="women_height_from_inch_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"> --}}
                                    @endif

                                    <span style="padding-right: 5px; padding-left: 5px; padding-top: 8px;"> - </span>

                                    @if ($isHeightFrom && $sizeTo)
                                        @php
                                            // Extract feet and inches from sizeTo
                                            preg_match('/(\d+)\s*\'\s*(\d*)/', $sizeTo, $matchesTo);
                                            $feetTo = isset($matchesTo[1]) ? $matchesTo[1] : '';
                                            $inchesTo = isset($matchesTo[2]) && $matchesTo[2] !== '' ? $matchesTo[2] : ''; // Keep inches empty if not available
                                        @endphp

                                        <input type="text" style="width: 30px;" id="women_height_to_feet_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $feetTo }}">
                                        {{-- <input type="text" style="width: 30px;" id="women_height_to_inch_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $inchesTo }}"> --}}
                                    @else
                                        <input type="text" style="width: 30px;" id="women_height_to_feet_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}">
                                        {{-- <input type="text" style="width: 30px;" id="women_height_to_inch_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"> --}}
                                    @endif

                                    {{-- <input type="text" style="width: 30px;" id="women_height_from_feet_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"> <span> ' </span>
                                    <input type="text"style="width: 30px;"  id="women_height_from_inch_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"> <span> " </span> <span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    <input type="text"style="width: 30px;"  id="women_height_to_feet_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}">  <span> ' </span>
                                    <input type="text"style="width: 30px;"  id="women_height_to_inch_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}">  <span> " </span> --}}
                                </div>

                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">BUST</th>
                        @foreach ($adultSizes as $adultSize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isWeighttFrom = false;
                                        $sizeFromWeight = null;
                                        $isWeighttTo = false;
                                        $sizeToWeight = null;
                                    @endphp
                                    @foreach ($adultWomenSizes as $adultWomenSize)
                                        @if ($adultWomenSize->size_id == $adultSize->id && $adultWomenSize->type == 'weight')
                                            @php
                                                $isWeighttFrom = true;
                                                $sizeFromWeight = $adultWomenSize->size_from;
                                                $sizeToWeight = $adultWomenSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isWeighttFrom && $sizeFromWeight)
                                        <input type="text" style="width: 50px;" id="women_weight_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeFromWeight }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="women_weight_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif

                                    @if ($sizeToWeight)
                                        <input type="text" style="width: 50px;" id="women_weight_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeToWeight }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="women_weight_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}">
                                    @endif

                                    {{-- <input type="text" style="width: 50px;" id="women_weight_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    <input type="text" style="width: 50px;" id="women_weight_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> lbs </span> --}}
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">WAIST SIZE</th>
                        @foreach ($adultSizes as $adultSize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">
                                    @php
                                        $isWaistFrom = false;
                                        $sizeFromWaist = null;
                                        $isWaistTo = false;
                                        $sizeToWaist = null;
                                    @endphp
                                    @foreach ($adultWomenSizes as $adultWomenSize)
                                        @if ($adultWomenSize->size_id == $adultSize->id && $adultWomenSize->type == 'waist')
                                            @php
                                                $isWaistFrom = true;
                                                $sizeFromWaist = $adultWomenSize->size_from;
                                                $sizeToWaist = $adultWomenSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isWaistFrom && $sizeFromWaist)
                                        <input type="text" style="width: 50px;" id="women_waist_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeFromWaist }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="women_waist_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif
                                    @if ($sizeToWaist)
                                        <input type="text" style="width: 50px;" id="women_waist_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeToWaist }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="women_waist_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}">
                                    @endif

                                    {{-- <input type="text" style="width: 50px;" id="women_waist_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    <input type="text" style="width: 50px;" id="women_waist_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"> --}}
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">HIP SIZE</th>
                        @foreach ($adultSizes as $adultSize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isChestFrom = false;
                                        $sizeFromChest = null;
                                        $isChestTo = false;
                                        $sizeToChest = null;
                                    @endphp
                                    @foreach ($adultWomenSizes as $adultWomenSize)
                                        @if ($adultWomenSize->size_id == $adultSize->id && $adultWomenSize->type == 'chest')
                                            @php
                                                $isChestFrom = true;
                                                $sizeFromChest = $adultWomenSize->size_from;
                                                $sizeToChest = $adultWomenSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isChestFrom && $sizeFromChest)
                                        <input type="text" style="width: 50px;" id="women_chest_from_{{ $adultSize->id }}"  class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeFromChest }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="women_chest_from_{{ $adultSize->id }}"  class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif
                                    @if ($sizeToChest)
                                        <input type="text" style="width: 50px;" id="women_chest_to_{{ $adultSize->id }}"  class="form-control" data-size-id="{{ $adultSize->id }}" value="{{ $sizeToChest }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="women_chest_to_{{ $adultSize->id }}"  class="form-control" data-size-id="{{ $adultSize->id }}">
                                    @endif

                                    {{-- <input type="text" style="width: 50px;" id="women_chest_from_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    <input type="text" style="width: 50px;" id="women_chest_to_{{ $adultSize->id }}" class="form-control" data-size-id="{{ $adultSize->id }}"> --}}
                                </div>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

        </div>
        {{-- End Womens Sizes --}}


        {{-- Girl Sizes --}}

        <div class="row"  style="margin: unset; height: 60px;">
            <div class="top_topic">
                <span class="top_topic_text">GIRL'S YOUTH SIZES</span>
            </div>
            <div class="ml-auto save_button">
                <button class="btn-green-filled" style="outline: unset;" href="#" id="girl_size_save" title="Girl's Sizes Save">
                    SAVE
                </button>
            </div>
        </div>

        <div class="order_sammary_table card" style="overflow-x: auto; margin-top: 10px; padding: 10px; border: unset;">

            <div id="global_check_icon" style="text-align: right; padding-right: 10px;"></div>

            <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                <thead style="background-color: #afafaf;" id="girl_table_header">
                    <tr>

                    </tr>
                </thead>

                <tbody id="girl_table_body" class="color_gray_text">
                    <tr>
                        <th style="padding: 5px;">HEIGHT</th>
                        @foreach ($boySizes as $boySize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php

                                        $isHeightFromBoy = false;
                                        $sizeFromBoy = null;
                                        $isHeightTo = false;
                                        $sizeToBoy = null;
                                    @endphp

                                    @foreach ($youthGirlSizes as $youthGirlSize)
                                        @if ($youthGirlSize->size_id == $boySize->id && $youthGirlSize->type == 'height')
                                            @php
                                                $isHeightFromBoy = true;
                                                $sizeFromBoy = $youthGirlSize->size_from;
                                                $sizeToBoy = $youthGirlSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isHeightFromBoy && $sizeFromBoy)
                                        @php
                                            preg_match('/(\d+)\s*\'\s*(\d*)/', $sizeFromBoy, $matchesFrom);
                                            $feetFromBoy = isset($matchesFrom[1]) ? $matchesFrom[1] : '';
                                            $inchesFromBoy = isset($matchesFrom[2]) && $matchesFrom[2] !== '' ? $matchesFrom[2] : ''; // Keep inches empty if not available
                                        @endphp

                                        <input type="text" style="width: 30px;" id="girl_height_from_feet_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $feetFromBoy }}"> <span> ' </span>
                                        <input type="text"style="width: 30px;"  id="girl_height_from_inch_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $inchesFromBoy }}"> <span> " </span>
                                    @else
                                        <input type="text" style="width: 30px;" id="girl_height_from_feet_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"> <span> ' </span>
                                        <input type="text"style="width: 30px;"  id="girl_height_from_inch_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"> <span> " </span>
                                    @endif

                                    <span style="padding-right: 5px; padding-left: 5px; padding-top: 8px;"> - </span>

                                    @if ($sizeToBoy)
                                        @php
                                            preg_match('/(\d+)\s*\'\s*(\d*)/', $sizeToBoy, $matchesTo);
                                            $feetToBoy = isset($matchesTo[1]) ? $matchesTo[1] : '';
                                            $inchesToBoy = isset($matchesTo[2]) && $matchesTo[2] !== '' ? $matchesTo[2] : ''; // Keep inches empty if not available
                                        @endphp

                                        <input type="text"style="width: 30px;"  id="girl_height_to_feet_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $feetToBoy }}">  <span> ' </span>
                                        <input type="text"style="width: 30px;"  id="girl_height_to_inch_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $inchesToBoy }}">  <span> " </span>
                                    @else
                                        <input type="text"style="width: 30px;"  id="girl_height_to_feet_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}">  <span> ' </span>
                                        <input type="text"style="width: 30px;"  id="girl_height_to_inch_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}">  <span> " </span>
                                    @endif

                                </div>

                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">WEIGHT</th>
                        @foreach ($boySizes as $boySize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isWeighttFrom = false;
                                        $sizeFromWeight = null;
                                        $isWeighttTo = false;
                                        $sizeToWeight = null;
                                    @endphp
                                    @foreach ($youthGirlSizes as $youthGirlSize)
                                        @if ($youthGirlSize->size_id == $boySize->id && $youthGirlSize->type == 'weight')
                                            @php
                                                $isWeighttFrom = true;
                                                $sizeFromWeight = $youthGirlSize->size_from;
                                                $sizeToWeight = $youthGirlSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isWeighttFrom && $sizeFromWeight)
                                        <input type="text" style="width: 50px;" id="girl_weight_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeFromWeight }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                    <input type="text" style="width: 50px;" id="girl_weight_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif

                                    @if ($sizeToWeight)
                                        <input type="text" style="width: 50px;" id="girl_weight_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeToWeight }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> lbs </span>
                                    @else
                                    <input type="text" style="width: 50px;" id="girl_weight_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> lbs </span>
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">T-SHIRT/PANT SIZE</th>
                        @foreach ($boySizes as $boySize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isTPantFrom = false;
                                        $sizeFromTPant = null;
                                        $isTPantTo = false;
                                        $sizeToTPant = null;
                                    @endphp
                                    @foreach ($youthGirlSizes as $youthGirlSize)
                                        @if ($youthGirlSize->size_id == $boySize->id && $youthGirlSize->type == 'tPant')
                                            @php
                                                $isTPantFrom = true;
                                                $sizeFromTPant = $youthGirlSize->size_from;
                                                $sizeToTPant = $youthGirlSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isTPantFrom && $sizeFromTPant)
                                        <input type="text" style="width: 50px;" id="girl_tPant_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeFromTPant }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                    <input type="text" style="width: 50px;" id="girl_tPant_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif

                                    @if ($sizeToTPant)
                                        <input type="text" style="width: 50px;" id="girl_tPant_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"  value="{{ $sizeToTPant }}">
                                    @else
                                    <input type="text" style="width: 50px;" id="girl_tPant_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}">
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">CHEST SIZE</th>
                        @foreach ($boySizes as $boySize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isChestFrom = false;
                                        $sizeFromChest = null;
                                        $isChestTo = false;
                                        $sizeToChest = null;
                                    @endphp
                                    @foreach ($youthGirlSizes as $youthGirlSize)
                                        @if ($youthGirlSize->size_id == $boySize->id && $youthGirlSize->type == 'chest')
                                            @php
                                                $isChestFrom = true;
                                                $sizeFromChest = $youthGirlSize->size_from;
                                                $sizeToChest = $youthGirlSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isChestFrom && $sizeFromChest)
                                        <input type="text" style="width: 50px;" id="girl_chest_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeFromChest }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="girl_chest_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif
                                    @if ($sizeToChest)
                                        <input type="text" style="width: 50px;" id="girl_chest_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeToChest }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="girl_chest_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}">
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th style="padding: 5px;">WAIST SIZE</th>
                        @foreach ($boySizes as $boySize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isWaistFrom = false;
                                        $sizeFromWaist = null;
                                        $isWaistTo = false;
                                        $sizeToWaist = null;
                                    @endphp
                                    @foreach ($youthGirlSizes as $youthGirlSize)
                                        @if ($youthGirlSize->size_id == $boySize->id && $youthGirlSize->type == 'waist')
                                            @php
                                                $isWaistFrom = true;
                                                $sizeFromWaist = $youthGirlSize->size_from;
                                                $sizeToWaist = $youthGirlSize->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isWaistFrom && $sizeFromWaist)
                                        <input type="text" style="width: 50px;" id="girl_waist_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeFromWaist }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="girl_waist_from_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif
                                    @if ($sizeToWaist)
                                        <input type="text" style="width: 50px;" id="girl_waist_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}" value="{{ $sizeToWaist }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="girl_waist_to_{{ $boySize->id }}" class="form-control" data-size-id="{{ $boySize->id }}">
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

        </div>

        {{-- End Girl Sizes --}}

        {{-- Men Socks Sizes --}}


        <div class="row"  style="margin: unset; height: 60px;">
            <div class="top_topic_red">
                <span class="top_topic_text">SOCKS</span>
            </div>
            <div class="top_topic socks_topic" style="">
                <span class="top_topic_text">MEN'S SIZES</span>
            </div>
            <div class="ml-auto save_button" style=" position: relative; top: -99px;">
                <button class="btn-green-filled" style="outline: unset;" href="#" id="men_socks_size_save" title="Girl's Sizes Save">
                    SAVE
                </button>
            </div>
        </div>

        <div class="order_sammary_table card" style="overflow-x: auto; margin-top: 10px; padding: 10px; border: unset;">

            <div id="global_check_icon" style="text-align: right; padding-right: 10px;"></div>

            <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                <thead style="background-color: #afafaf;" id="men_socks_table_header">
                    <tr>

                    </tr>
                </thead>

                <tbody id="girl_table_body" class="color_gray_text">
                    <tr>
                        <th style="padding: 5px;">SHOE SIZE</th>
                        @foreach ($menSocksSizes as $menSocksSize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isMenSocksFrom = false;
                                        $sizeFromMenShock = null;
                                        $isWaistTo = false;
                                        $sizeToMenSocks = null;
                                    @endphp
                                    @foreach ($menSocks as $menSock)
                                        @if ($menSock->size_id == $menSocksSize->id && $menSock->type == 'menShoe')
                                            @php
                                                $isMenSocksFrom = true;
                                                $sizeFromMenShock = $menSock->size_from;
                                                $sizeToMenSocks = $menSock->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isMenSocksFrom && $sizeFromMenShock)
                                        <input type="text" style="width: 50px;" id="men_shoe_from_{{ $menSocksSize->id }}" class="form-control" data-size-id="{{ $menSocksSize->id }}" value="{{ $sizeFromMenShock }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="men_shoe_from_{{ $menSocksSize->id }}" class="form-control" data-size-id="{{ $menSocksSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif
                                    @if ($sizeToMenSocks)
                                        <input type="text" style="width: 50px;" id="men_shoe_to_{{ $menSocksSize->id }}" class="form-control" data-size-id="{{ $menSocksSize->id }}" value="{{ $sizeToMenSocks }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="men_shoe_to_{{ $menSocksSize->id }}" class="form-control" data-size-id="{{ $menSocksSize->id }}">
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>

                </tbody>
            </table>

        </div>

        {{-- End men socks Sizes --}}


        {{-- Women Socks Sizes --}}

        <div class="row" style="margin: unset; height: 60px;">
            <div class="top_topic_red">
                <span class="top_topic_text">SOCKS</span>
            </div>
            <div class="top_topic socks_topic" style="">
                <span class="top_topic_text">WOMEN'S SIZES</span>
            </div>
            <div class="ml-auto save_button" style=" position: relative; top: -99px;">
                <button class="btn-green-filled" style="outline: unset;" href="#" id="women_socks_size_save" title="Girl's Sizes Save">
                    SAVE
                </button>
            </div>
        </div>

        <div class="order_sammary_table card" style="overflow-x: auto; margin-top: 10px; padding: 10px; border: unset;">

            <div id="global_check_icon" style="text-align: right; padding-right: 10px;"></div>

            <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                <thead style="background-color: #afafaf;" id="women_socks_table_header">
                    <tr>

                    </tr>
                </thead>

                <tbody id="women_socks_table_body" class="color_gray_text">
                    <tr>
                        <th style="padding: 5px;">SHOE SIZE</th>
                        @foreach ($menSocksSizes as $menSocksSize)
                            <td style="padding: 5px; border-left: 1px solid rgb(181, 181, 181);">
                                <div class="row d-flex justify-content-center align-items-center" style="margin: unset; min-width: 150px;">

                                    @php
                                        $isMenSocksFrom = false;
                                        $sizeFromMenShock = null;
                                        $isWaistTo = false;
                                        $sizeToMenSocks = null;
                                    @endphp
                                    @foreach ($womenSocks as $womenSock)
                                        @if ($womenSock->size_id == $menSocksSize->id && $womenSock->type == 'womenShoe')
                                            @php
                                                $isMenSocksFrom = true;
                                                $sizeFromMenShock = $womenSock->size_from;
                                                $sizeToMenSocks = $womenSock->size_to;
                                            @endphp
                                            @break;
                                        @endif
                                    @endforeach

                                    @if ($isMenSocksFrom && $sizeFromMenShock)
                                        <input type="text" style="width: 50px;" id="women_shoe_from_{{ $menSocksSize->id }}" class="form-control" data-size-id="{{ $menSocksSize->id }}" value="{{ $sizeFromMenShock }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @else
                                        <input type="text" style="width: 50px;" id="women_shoe_from_{{ $menSocksSize->id }}" class="form-control" data-size-id="{{ $menSocksSize->id }}"><span style="padding-right: 5px; padding-left: 5px;  padding-top: 8px;"> - </span>
                                    @endif
                                    @if ($sizeToMenSocks)
                                        <input type="text" style="width: 50px;" id="women_shoe_to_{{ $menSocksSize->id }}" class="form-control" data-size-id="{{ $menSocksSize->id }}" value="{{ $sizeToMenSocks }}">
                                    @else
                                        <input type="text" style="width: 50px;" id="women_shoe_to_{{ $menSocksSize->id }}" class="form-control" data-size-id="{{ $menSocksSize->id }}">
                                    @endif

                                </div>
                            </td>
                        @endforeach
                    </tr>

                </tbody>
            </table>

        </div>

        {{-- End women socks Sizes --}}


    </div>
</div>


<script>

    var adultSizes = @json($adultSizes);

    //adult men table hearder
    const tableHeader = document.querySelector('#adult_men_table_header tr');

    const emptyTh = document.createElement('th');
    tableHeader.appendChild(emptyTh);

    adultSizes.forEach(size => {
        let formattedSizeName = size.size_name.replace('Adult ', '');

        formattedSizeName = formattedSizeName.replace(/([A-Z])[a-z]*/g, '$1').toUpperCase();

        const th = document.createElement('th');
        th.classList.add('table_header_text');

        const span = document.createElement('span');
        span.textContent = formattedSizeName;
        span.classList.add('table_header_span');


        th.appendChild(span);

        tableHeader.appendChild(th);
    });
    //end adult men table hearder

    //adult wommen table hearder
    const tableWomenHeader = document.querySelector('#adult_women_table_header tr');

    const emptyWomenTh = document.createElement('th');
    tableWomenHeader.appendChild(emptyWomenTh);

    adultSizes.forEach(size => {
        let formattedSizeName = size.size_name.replace('Adult ', '');

        formattedSizeName = formattedSizeName.replace(/([A-Z])[a-z]*/g, '$1').toUpperCase();

        const th = document.createElement('th');
        th.classList.add('table_header_text');

        const span = document.createElement('span');
        span.textContent = formattedSizeName;
        span.classList.add('table_header_span');


        th.appendChild(span);

        tableWomenHeader.appendChild(th);
    });
    //End adult wommen table hearder

    var boySizes = @json($boySizes);

    //adult boy table hearder
    const tableBoyHeader = document.querySelector('#boy_table_header tr');

    const emptyBoyTh = document.createElement('th');
    tableBoyHeader.appendChild(emptyBoyTh);

    boySizes.forEach(size => {
        let formattedSizeName = size.size_name.replace('Youth ', '');

        formattedSizeName = formattedSizeName.replace(/([A-Z])[a-z]*/g, '$1').toUpperCase();

        const th = document.createElement('th');
        th.classList.add('table_header_text');

        const span = document.createElement('span');
        span.textContent = formattedSizeName;
        span.classList.add('table_header_span');


        th.appendChild(span);

        tableBoyHeader.appendChild(th);
    });
    //End adult boy table hearder

    //adult girl table hearder
    const tableGirlHeader = document.querySelector('#girl_table_header tr');

    const emptyGirlTh = document.createElement('th');
    tableGirlHeader.appendChild(emptyGirlTh);

    boySizes.forEach(size => {
        let formattedSizeName = size.size_name.replace('Youth ', '');

        formattedSizeName = formattedSizeName.replace(/([A-Z])[a-z]*/g, '$1').toUpperCase();

        const th = document.createElement('th');
        th.classList.add('table_header_text');

        const span = document.createElement('span');
        span.textContent = formattedSizeName;
        span.classList.add('table_header_span');


        th.appendChild(span);

        tableGirlHeader.appendChild(th);
    });
    //End adult girl table hearder

    var menSocksSizes = @json($menSocksSizes);

    //adult men socks table hearder
    const tableMenSocksHeader = document.querySelector('#men_socks_table_header tr');

    const emptyMenSocksTh = document.createElement('th');
    tableMenSocksHeader.appendChild(emptyMenSocksTh);

    menSocksSizes.forEach(size => {
        let formattedSizeName = size.size_name.replace('Youth ', '');

        formattedSizeName = formattedSizeName.replace(/([A-Z])[a-z]*/g, '$1').toUpperCase();

        const th = document.createElement('th');
        th.classList.add('table_header_text');

        const span = document.createElement('span');
        span.textContent = formattedSizeName;
        span.classList.add('table_header_span');


        th.appendChild(span);

        tableMenSocksHeader.appendChild(th);
    });
    //End adult men socks table hearder

    //adult women socks table hearder
    const tableWomenSocksHeader = document.querySelector('#women_socks_table_header tr');

    const emptyWomenSocksTh = document.createElement('th');
    tableWomenSocksHeader.appendChild(emptyWomenSocksTh);

    menSocksSizes.forEach(size => {
        let formattedSizeName = size.size_name.replace('Youth ', '');

        formattedSizeName = formattedSizeName.replace(/([A-Z])[a-z]*/g, '$1').toUpperCase();

        const th = document.createElement('th');
        th.classList.add('table_header_text');

        const span = document.createElement('span');
        span.textContent = formattedSizeName;
        span.classList.add('table_header_span');


        th.appendChild(span);

        tableWomenSocksHeader.appendChild(th);
    });
    //end adult women socks table hearder

    //save men size table data
    document.getElementById('man_size_save').addEventListener('click', function (e) {
        e.preventDefault();

        let sizeData = [];

        adultSizes.forEach(size => {
            let dataSizeId = size.id;

            // Get height data
            let heightFromFeet = document.getElementById(`men_height_from_feet_${dataSizeId}`)?.value || null;
            let heightFromInch = document.getElementById(`men_height_from_inch_${dataSizeId}`)?.value || null;
            let heightToFeet = document.getElementById(`men_height_to_feet_${dataSizeId}`)?.value || null;
            let heightToInch = document.getElementById(`men_height_to_inch_${dataSizeId}`)?.value || null;

            // Get weight data
            let weightFrom = document.getElementById(`men_weight_from_${dataSizeId}`)?.value || null;
            let weightTo = document.getElementById(`men_weight_to_${dataSizeId}`)?.value || null;

            // Get chest data
            let chestFrom = document.getElementById(`men_chest_from_${dataSizeId}`)?.value || null;
            let chestTo = document.getElementById(`men_chest_to_${dataSizeId}`)?.value || null;

            // Get waist data
            let waistFrom = document.getElementById(`men_waist_from_${dataSizeId}`)?.value || null;
            let waistTo = document.getElementById(`men_waist_to_${dataSizeId}`)?.value || null;

            // Push height data to sizeData array
            sizeData.push({
                size_id: dataSizeId,
                type: 'height',
                from_feet: heightFromFeet,
                from_inch: heightFromInch,
                to_feet: heightToFeet,
                to_inch: heightToInch
            });

            // Push weight data to sizeData array
            sizeData.push({
                size_id: dataSizeId,
                type: 'weight',
                from: weightFrom,
                to: weightTo
            });

            // Push chest data to sizeData array
            sizeData.push({
                size_id: dataSizeId,
                type: 'chest',
                from: chestFrom,
                to: chestTo
            });

            // Push waist data to sizeData array
            sizeData.push({
                size_id: dataSizeId,
                type: 'waist',
                from: waistFrom,
                to: waistTo
            });
        });

        $.ajax({
            url: 'saveMenSizes',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sizeData: sizeData
            },
            success: function (response) {

                console.log(response);
                alert('Data saved successfully!');
            },
            error: function (error) {

                console.error(error);
                alert('There was an error saving the data.');
            }
        });
    });

    //End save men size table data


    //save men size table data
    document.getElementById('women_size_save').addEventListener('click', function (e) {
        e.preventDefault();

        let sizeData = [];

        adultSizes.forEach(size => {
            let dataSizeId = size.id;

            // Get height data
            let heightFromFeetWomen = document.getElementById(`women_height_from_feet_${dataSizeId}`)?.value || null;
            let heightFromInchWomen = document.getElementById(`women_height_from_inch_${dataSizeId}`)?.value || null;
            let heightToFeetWomen = document.getElementById(`women_height_to_feet_${dataSizeId}`)?.value || null;
            let heightToInchWomen = document.getElementById(`women_height_to_inch_${dataSizeId}`)?.value || null;

            // Get weight data
            let weightFromWomen = document.getElementById(`women_weight_from_${dataSizeId}`)?.value || null;
            let weightToWomen = document.getElementById(`women_weight_to_${dataSizeId}`)?.value || null;

            // Get chest data
            let chestFromWomen = document.getElementById(`women_chest_from_${dataSizeId}`)?.value || null;
            let chestToWomen = document.getElementById(`women_chest_to_${dataSizeId}`)?.value || null;

            // Get waist data
            let waistFromWomen = document.getElementById(`women_waist_from_${dataSizeId}`)?.value || null;
            let waistToWomen = document.getElementById(`women_waist_to_${dataSizeId}`)?.value || null;

            // Push height data to sizeData array
            sizeData.push({
                size_id: dataSizeId,
                type: 'height',
                from_feet: heightFromFeetWomen,
                from_inch: heightFromInchWomen,
                to_feet: heightToFeetWomen,
                to_inch: heightToInchWomen
            });

            // Push weight data to sizeData array
            sizeData.push({
                size_id: dataSizeId,
                type: 'weight',
                from: weightFromWomen,
                to: weightToWomen
            });

            // Push chest data to sizeData array
            sizeData.push({
                size_id: dataSizeId,
                type: 'chest',
                from: chestFromWomen,
                to: chestToWomen
            });

            // Push waist data to sizeData array
            sizeData.push({
                size_id: dataSizeId,
                type: 'waist',
                from: waistFromWomen,
                to: waistToWomen
            });
        });

        $.ajax({
            url: 'saveWomenSizes',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sizeData: sizeData
            },
            success: function (response) {

                console.log(response);
                alert('Data saved successfully!');
            },
            error: function (error) {

                console.error(error);
                alert('There was an error saving the data.');
            }
        });
    });

    //End save men size table data


    //save boy size table data
    document.getElementById('boy_size_save').addEventListener('click', function (e) {
        e.preventDefault();

        let sizeDataBoy = [];

        boySizes.forEach(size => {
            let dataSizeId = size.id;

            // Get height data
            let heightFromFeetBoy = document.getElementById(`boy_height_from_feet_${dataSizeId}`)?.value || null;
            let heightFromInchBoy = document.getElementById(`boy_height_from_inch_${dataSizeId}`)?.value || null;
            let heightToFeetBoy = document.getElementById(`boy_height_to_feet_${dataSizeId}`)?.value || null;
            let heightToInchBoy = document.getElementById(`boy_height_to_inch_${dataSizeId}`)?.value || null;

            // Get weight data
            let weightFromBoy = document.getElementById(`boy_weight_from_${dataSizeId}`)?.value || null;
            let weightToBoy = document.getElementById(`boy_weight_to_${dataSizeId}`)?.value || null;

            // Get t pant data
            let tPantFromBoy = document.getElementById(`boy_tPant_from_${dataSizeId}`)?.value || null;
            let tPantToBoy = document.getElementById(`boy_tPant_to_${dataSizeId}`)?.value || null;

            // Get chest data
            let chestFromBoy = document.getElementById(`boy_chest_from_${dataSizeId}`)?.value || null;
            let chestToBoy = document.getElementById(`boy_chest_to_${dataSizeId}`)?.value || null;

            // Get waist data
            let waistFromBoy = document.getElementById(`boy_waist_from_${dataSizeId}`)?.value || null;
            let waistToBoy = document.getElementById(`boy_waist_to_${dataSizeId}`)?.value || null;

            // Push height data to sizeData array
            sizeDataBoy.push({
                size_id: dataSizeId,
                type: 'height',
                from_feet: heightFromFeetBoy,
                from_inch: heightFromInchBoy,
                to_feet: heightToFeetBoy,
                to_inch: heightToInchBoy
            });

            // Push weight data to sizeData array
            sizeDataBoy.push({
                size_id: dataSizeId,
                type: 'weight',
                from: weightFromBoy,
                to: weightToBoy
            });

            // Push tPant data to sizeData array
            sizeDataBoy.push({
                size_id: dataSizeId,
                type: 'tPant',
                from: tPantFromBoy,
                to: tPantToBoy
            });

            // Push chest data to sizeData array
            sizeDataBoy.push({
                size_id: dataSizeId,
                type: 'chest',
                from: chestFromBoy,
                to: chestToBoy
            });

            // Push waist data to sizeData array
            sizeDataBoy.push({
                size_id: dataSizeId,
                type: 'waist',
                from: waistFromBoy,
                to: waistToBoy
            });
        });

        $.ajax({
            url: 'saveBoySizes',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sizeDataBoy: sizeDataBoy
            },
            success: function (response) {

                console.log(response);
                alert('Data saved successfully!');
            },
            error: function (error) {

                console.error(error);
                alert('There was an error saving the data.');
            }
        });
    });

    //End save boy size table data


    //save girl size table data
    document.getElementById('girl_size_save').addEventListener('click', function (e) {
        e.preventDefault();

        let sizeDataGirl = [];

        boySizes.forEach(size => {
            let dataSizeId = size.id;

            // Get height data
            let heightFromFeetGirl = document.getElementById(`girl_height_from_feet_${dataSizeId}`)?.value || null;
            let heightFromInchGirl = document.getElementById(`girl_height_from_inch_${dataSizeId}`)?.value || null;
            let heightToFeetGirl = document.getElementById(`girl_height_to_feet_${dataSizeId}`)?.value || null;
            let heightToInchGirl = document.getElementById(`girl_height_to_inch_${dataSizeId}`)?.value || null;

            // Get weight data
            let weightFromGirl = document.getElementById(`girl_weight_from_${dataSizeId}`)?.value || null;
            let weightToGirl = document.getElementById(`girl_weight_to_${dataSizeId}`)?.value || null;

            // Get t pant data
            let tPantFromGirl = document.getElementById(`girl_tPant_from_${dataSizeId}`)?.value || null;
            let tPantToGirl = document.getElementById(`girl_tPant_to_${dataSizeId}`)?.value || null;

            // Get chest data
            let chestFromGirl = document.getElementById(`girl_chest_from_${dataSizeId}`)?.value || null;
            let chestToGirl = document.getElementById(`girl_chest_to_${dataSizeId}`)?.value || null;

            // Get waist data
            let waistFromGirl = document.getElementById(`girl_waist_from_${dataSizeId}`)?.value || null;
            let waistToGirl = document.getElementById(`girl_waist_to_${dataSizeId}`)?.value || null;

            // Push height data to sizeData array
            sizeDataGirl.push({
                size_id: dataSizeId,
                type: 'height',
                from_feet: heightFromFeetGirl,
                from_inch: heightFromInchGirl,
                to_feet: heightToFeetGirl,
                to_inch: heightToInchGirl
            });

            // Push weight data to sizeData array
            sizeDataGirl.push({
                size_id: dataSizeId,
                type: 'weight',
                from: weightFromGirl,
                to: weightToGirl
            });

            // Push tPant data to sizeData array
            sizeDataGirl.push({
                size_id: dataSizeId,
                type: 'tPant',
                from: tPantFromGirl,
                to: tPantToGirl
            });

            // Push chest data to sizeData array
            sizeDataGirl.push({
                size_id: dataSizeId,
                type: 'chest',
                from: chestFromGirl,
                to: chestToGirl
            });

            // Push waist data to sizeData array
            sizeDataGirl.push({
                size_id: dataSizeId,
                type: 'waist',
                from: waistFromGirl,
                to: waistToGirl
            });
        });

        $.ajax({
            url: 'saveGirlSizes',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sizeDataGirl: sizeDataGirl
            },
            success: function (response) {

                console.log(response);
                alert('Data saved successfully!');
            },
            error: function (error) {

                console.error(error);
                alert('There was an error saving the data.');
            }
        });
    });

    //End save girl size table data

    //save Men Shoe size table data
    document.getElementById('men_socks_size_save').addEventListener('click', function (e) {
        e.preventDefault();

        let sizeDataMenShoe = [];

        menSocksSizes.forEach(size => {
            let dataSizeId = size.id;

            // Get shoe data
            let FromMenShoe = document.getElementById(`men_shoe_from_${dataSizeId}`)?.value || null;
            let ToMenShoe = document.getElementById(`men_shoe_to_${dataSizeId}`)?.value || null;


            // Push men shoe data to sizeData array
            sizeDataMenShoe.push({
                size_id: dataSizeId,
                type: 'menShoe',
                from: FromMenShoe,
                to: ToMenShoe
            });

        });

        $.ajax({
            url: 'saveMenShoeSizes',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sizeDataMenShoe: sizeDataMenShoe
            },
            success: function (response) {

                console.log(response);
                alert('Data saved successfully!');
            },
            error: function (error) {

                console.error(error);
                alert('There was an error saving the data.');
            }
        });
    });

    //End save Men Shoe size table data

    //save Men Shoe size table data
    document.getElementById('women_socks_size_save').addEventListener('click', function (e) {
        e.preventDefault();

        let sizeDataWomenShoe = [];

        menSocksSizes.forEach(size => {
            let dataSizeId = size.id;

            // Get shoe data
            let FromWomenShoe = document.getElementById(`women_shoe_from_${dataSizeId}`)?.value || null;
            let ToWomenShoe = document.getElementById(`women_shoe_to_${dataSizeId}`)?.value || null;


            // Push men shoe data to sizeData array
            sizeDataWomenShoe.push({
                size_id: dataSizeId,
                type: 'womenShoe',
                from: FromWomenShoe,
                to: ToWomenShoe
            });

        });

        $.ajax({
            url: 'saveWomenShoeSizes',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sizeDataWomenShoe: sizeDataWomenShoe
            },
            success: function (response) {

                console.log(response);
                alert('Data saved successfully!');
            },
            error: function (error) {

                console.error(error);
                alert('There was an error saving the data.');
            }
        });
    });

    //End save Men Shoe size table data

    // Mobile size pill switching
    function setActiveSize(table, idx) {
        table.querySelectorAll('thead th').forEach((th, i) => th.classList.toggle('active', i === idx));
        table.querySelectorAll('tbody tr').forEach(tr => {
            Array.from(tr.children).forEach((cell, i) => {
                if (cell.tagName === 'TD') cell.classList.toggle('active-col', i === idx);
            });
        });
    }

    document.querySelectorAll('table.table').forEach(t => setActiveSize(t, 1));

    document.addEventListener('click', function (e) {
        const th = e.target.closest('th.table_header_text');
        if (!th) return;
        const table = th.closest('table');
        setActiveSize(table, Array.from(th.parentElement.children).indexOf(th));
    });

    // Mobile accordion toggle
    document.addEventListener('click', function (e) {
        if (window.innerWidth > 768) return;
        if (e.target.closest('button')) return;

        const header = e.target.closest('.top_topic');
        if (!header) return;

        const row = header.closest('.row');
        const card = row.nextElementSibling;
        if (!card || !card.classList.contains('order_sammary_table')) return;

        header.classList.toggle('collapsed-section');
        card.classList.toggle('collapsed-section-card');
    });

    if (window.innerWidth <= 768) {
        document.querySelectorAll('.top_topic').forEach(h => {
            h.classList.add('collapsed-section');
            h.closest('.row').nextElementSibling.classList.add('collapsed-section-card');
        });
    }

    if (window.innerWidth <= 768) {
        document.querySelectorAll('.top_topic').forEach(h => {
            const row = h.closest('.row');
            const card = row.nextElementSibling;

            // Move the real save button into the card
            const saveBtn = row.querySelector('.save_button');
            if (saveBtn) card.appendChild(saveBtn);

            // Start collapsed
            h.classList.add('collapsed-section');
            card.classList.add('collapsed-section-card');
        });
    }

    // Mobile top tabs -> open matching accordion
    function openSection(indexes) {
        const list = Array.isArray(indexes) ? indexes : [indexes];
        document.querySelectorAll('.top_topic').forEach((h, idx) => {
            const card = h.closest('.row').nextElementSibling;
            const open = list.includes(idx);
            h.classList.toggle('collapsed-section', !open);
            card.classList.toggle('collapsed-section-card', !open);
        });
    }

    document.querySelectorAll('.mobile-tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.mobile-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            openSection(this.dataset.target.split(',').map(Number));
        });
    });

    if (window.innerWidth <= 768) openSection([0]);

    // top image zoom in
    document.querySelector('.top_image_div').addEventListener('click', function () {
        if (window.innerWidth <= 768) this.classList.toggle('zoomed');
    });
</script>

@endsection
