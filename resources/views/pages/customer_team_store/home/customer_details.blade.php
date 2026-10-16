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
    .cart_topic_text {
        font-size: 33px;
    }
    .cart_items {
        padding-top: 15px;
        padding-bottom: 15px !important;
        border-bottom: 1px solid rgb(231, 231, 231);
    }
    .cart_summary {
        max-width: 35%;
        width: 35%;
    }
    .text_input {
        font-size: 12px;
        border: 1px solid #DEDEDE !important;
        border-radius: 0rem !important;
        color: #717070 !important;
    }
    .text_input_div {
        margin-top: 5px;
        margin-bottom: 5px;
    }
</style>

<div class="navbar top-navbar  col-12 col-lg-12 {{ $teamStore->theme == 1 ? 'top_nav_dark' : '' }}" style=" background-color:white; z-index:99;">

    @include('pages.customer_team_store.layouts.header')

</div>

<div class="col-lg-12" style="padding-top: 120px;">
    <div class="row" style="margin: unset;">
        <div class="col-lg-12">
            <b style="font-size: 25px;">Personal Details</b>
        </div>

        <!-- Open form -->
        <form action="{{ makeStoreDomainRoute('customerTeamStorePersonalDetails') }}" method="POST" style="width: 100%;">
            @csrf
            <div class="row" style="margin: unset;">
                @foreach ($storeCustomInformation as $storeCustomInformations)
                    @if ($storeCustomInformations->storeCustomInformationsDetails->id == 1)
                        <div class="col-lg-12">
                            <b>First & Last Name</b>
                        </div>
                        <div class="col-lg-6 text_input_div">
                            <input type="text" class="form-control text_input" name="first_name" placeholder="First Name">
                        </div>
                        <div class="col-lg-6 text_input_div">
                            <input type="text" class="form-control text_input" name="last_name" placeholder="Last Name">
                        </div>

                    @elseif ($storeCustomInformations->storeCustomInformationsDetails->id == 2)
                        <div class="col-lg-12">
                            <b>Shipping Address</b>
                        </div>
                        <div class="col-lg-4 col-4 text_input_div">
                            <input type="text" class="form-control text_input" name="street" placeholder="Street">
                        </div>
                        <div class="col-lg-4 col-4 text_input_div">
                            <input type="text" class="form-control text_input" name="city" placeholder="City">
                        </div>
                        <div class="col-lg-4 col-4 text_input_div">
                            <input type="text" class="form-control text_input" name="state" placeholder="State">
                        </div>
                        <div class="col-lg-4 col-4 text_input_div">
                            <input type="text" class="form-control text_input" name="country" placeholder="Country">
                        </div>
                        <div class="col-lg-4 col-4 text_input_div">
                            <input type="text" class="form-control text_input" name="postal_code" placeholder="Postal Code">
                        </div>

                    @else
                        @if ($storeCustomInformations->storeCustomInformationsDetails->type == 3)
                            <div class="col-lg-12">
                                <b>{{ $storeCustomInformations->storeCustomInformationsDetails->custom_name }}</b>
                            </div>
                            <div class="col-lg-4 col-4 text_input_div">
                                <input type="number" class="form-control text_input" name="custom_{{ $storeCustomInformations->storeCustomInformationsDetails->id }}" placeholder="{{ $storeCustomInformations->storeCustomInformationsDetails->custom_name }}">
                            </div>

                        @elseif ($storeCustomInformations->storeCustomInformationsDetails->type == 2)
                            <div class="col-lg-12">
                                <b>{{ $storeCustomInformations->storeCustomInformationsDetails->custom_name }}</b>
                            </div>
                            <div class="col-lg-4 col-4 text_input_div">
                                @php
                                    $options = json_decode($storeCustomInformations->storeCustomInformationsDetails->options, true);
                                @endphp

                                <select name="custom_{{ $storeCustomInformations->storeCustomInformationsDetails->id }}" class="form-control text_input">
                                    @if(is_array($options))
                                        @foreach($options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    @else
                                        <option value="">Invalid data format</option>
                                    @endif
                                </select>
                            </div>

                        @elseif ($storeCustomInformations->storeCustomInformationsDetails->type == 1)
                            <div class="col-lg-12">
                                <b>{{ $storeCustomInformations->storeCustomInformationsDetails->custom_name }}</b>
                            </div>
                            <div class="col-lg-4 col-4 text_input_div">
                                <input type="text" class="form-control text_input" name="custom_{{ $storeCustomInformations->storeCustomInformationsDetails->id }}" placeholder="{{ $storeCustomInformations->storeCustomInformationsDetails->custom_name }}">
                            </div>
                        @endif
                    @endif
                @endforeach

            </div>

            @php
                $primaryColor = $teamStore->primary_color ? $teamStore->primary_color : '#47D6B6';
            @endphp
            <input type="hidden" name="estimatevalue" value="{{ $estimatevalue }}">
            <input type="hidden" name="storeId" value="{{ $teamStore->store_id }}">
            <!-- Submit button -->
            <div class="col-lg-4" style="padding-top: 20px;">
                <button class="btn btn-success" type="submit" style="background-color: {{ $primaryColor }}; border: unset; width: 100%;">Proceed to Checkout</button>
            </div>
        </form>
        <!-- Close form -->
    </div>
</div>


@include('pages.customer_team_store.layouts.footer')


@endsection
