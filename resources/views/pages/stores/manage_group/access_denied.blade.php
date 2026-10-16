@extends('layouts.customer_team_store.app')

@section('content')

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
        padding: 2%;
        border: unset !important;
        padding-left: 4% !important;
        padding-right: 4% !important;
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
        border: none;
    }
    .product_card_bundle {
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 12px;
        border: none;
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
</style>
@php
    $primaryColor = $teamStore->primary_color ? $teamStore->primary_color : '#47D6B6';
@endphp

<div style="padding-top: 4.4rem;">
        <div class="product1_div">
            <div class="card product1_card col-lg-12 {{ $teamStore->theme == 1 ? 'store_products_dark' : '' }}" style="border: none;">
                <div class="row justify-content-center">
                    <div class="product_card_bundle {{ $teamStore->theme == 1 ? 'store_product_card_dark' : '' }}" style="padding: 1.5rem; display: inline-block; text-align: center;min-width: 85%;">

                        <div class="sec_logo">
                            <img src="{{ asset($teamStore->secondary_logo) }}" alt="image" style="color:black" class="sec_logo_width">
                       </div>

                       <div class="store_name mb-2">
                           <b class="store_name_text">{{$store->store_name}}</b>
                       </div>
                       <div class="store_name">
                           <p class="store_name_text" style="color: red;font-weight: 500;">Your Access denied for manage your group !</p>
                       </div>


                        <div class="d-flex align-items-center justify-content-center flex-wrap">

                            <p style="color: grey;">Please contact your Encore Custom representative for futher informations.</p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>

