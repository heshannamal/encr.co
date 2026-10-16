@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }
    .main_card {
        margin-top: 20px;
        border: unset;
        padding-bottom: 15px;
        border-radius: unset;
    }
    .flyer_download {
        width: 125px;
        height: 35px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .flyer_download_div {
        padding: 15px;
        padding-bottom: unset;
    }
    .flyer_topic {
        font-size: 18px;
    }
    .card_div {
        padding: 15px;
        padding-bottom: 5px;
    }
    .flyer_p {
        font-size: 11px;
        color: #717070;
        font-weight: 500;
        margin-bottom: unset;
    }
    .name_div {
        padding-top: 10px;
    }
    .info_input {
        height: 25px;
        border-radius: unset;
    }
    .info_label {
        font-size: 12px;
    }


.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 20px;
  margin-left: 10px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(16px);
  -ms-transform: translateX(16px);
  transform: translateX(16px);
}

.slider.round {
  border-radius: 10px;
}

.slider.round:before {
  border-radius: 50%;
}

.select_box {
    width: 100%;
    height: 25px;
    border: 1px solid #DEDEDE;
    color: #555;
}
.select_box:focus {
  outline: none;
}
.flyer_msg {
    font-size: 11px;
    color: #717070;
}
.flyer_textarea {
    width: 100%;
    height: 75px !important;
}
.styled-button-decoration{
    border: none !important;
    border-radius: 0rem !important;
    font-size: .8rem !important;
    padding: .2em 2em !important;
    cursor: pointer;
}

@media (max-width: 767px) {
    /* .bg-box.container-fluid.fix-nav.header-layout{ */
    .header-layout {
        margin-bottom: 0 !important;
        height: auto !important;
        min-height: 0 !important;
    }

    /* Prevent iOS Safari from auto-zooming on focus */
    input[type="text"],
    input[type="number"],
    input[type="search"],
    input[type="email"],
    input[type="password"],
    input[type="tel"],
    input[type="url"],
    select,
    textarea,
    .form-control,
    .select2-selection,
    .select2-search__field,
    .select2-search input {
        font-size: 16px !important;
    }
}
</style>

<div class="container-fluid mb-5" style="background-color: transparent;padding: 0 !important;">
    <div class="se-pre-con"></div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')

    <div class="card col-lg-12 main_card" style="margin-top: 20px;">
        <div class="">
            <div class="row">
                <div class="card_div">
                    <strong class="flyer_topic">Customize Your Flyer</strong>
                    <p class="flyer_p">Provide the details below to generate the custom flyer PDF.</p>
                </div>
                <div class="ml-auto flyer_download_div">
                    <form action="{{ route('store.download_store_flyer') }}" method="POST" enctype="multipart/form-data" id="download_flyer">
                        @csrf
                        <input type="hidden" name="store_id" value="{{$store->id}}">
                        <input type="hidden" name="is_download" value="1">
                        <button type="submit" class="flyer_download"><i class="fa fa-download" style="padding: 5px;"></i> DOWNLOAD</button>
                    </form>
                </div>
                <div class="flyer_download_div">
                    <form action="{{ route('store.download_store_flyer') }}" method="POST" enctype="multipart/form-data" id="download_flyer">
                        @csrf
                        <input type="hidden" name="store_id" value="{{$store->id}}">
                        <button type="submit" class="flyer_download"><i class="fa fa-eye" style="padding: 5px;"></i> VIEW</button>
                    </form>
                </div>
            </div>
            <hr style="margin: unset; margin-bottom: 10px;">
            <form action="{{ route('store.save_store_flyer') }}" method="POST" enctype="multipart/form-data" id="edit_flyer">
            @csrf
            <input type="hidden" name="store_id" value="{{$store->id}}">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <b>Contact Information</b>
                        </div>
                        <div class="col-lg-6 name_div">
                            <label for="name" class="info_label">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ $store->flyerDetails->flyer_name ?? '' }}" class="form-control info_input" required>
                        </div>
                        <div class="col-lg-6 name_div">
                            <label for="email" class="info_label">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ $store->flyerDetails->email ?? '' }}" class="form-control info_input" required>
                        </div>
                        <div class="col-lg-6 name_div">
                            <label for="phoneNumber" class="info_label">Phone Number<span class="text-danger">*</span></label>
                            <input type="text" name="phoneNumber" value="{{ $store->flyerDetails->phone_number ?? '' }}" class="form-control info_input" required>
                        </div>
                        <div class="col-lg-6 name_div">
                            <label for="website" class="info_label">Website<span class="text-danger">*</span></label>
                            <input type="text" name="website" value="{{ $store->flyerDetails->website ?? '' }}" class="form-control info_input" required>
                        </div>
                        {{-- <div class="col-lg-12 name_div">
                            <b>Flyer URL</b>
                            <input type="text" name="flyerUrl" value="{{ $store->flyerDetails->flyer_url ?? '' }}" class="form-control info_input" style="margin-top: .5rem;">
                        </div> --}}
                        <div class="col-lg-12">
                            <b>Design Options</b>
                        </div>
                        <div class="col-lg-6 name_div">
                            <label for="layoutType" class="info_label">Layout Type<span class="text-danger">*</span></label><br>
                            <select name="layoutType" id="layoutType" class="select_box"  required>
                                <option value="1" {{ ($store->flyerDetails->layout_type ?? '') == 1 ? 'selected' : '' }}>Small Grid</option>
                                <option value="2" {{ ($store->flyerDetails->layout_type ?? '') == 2 ? 'selected' : '' }}>Large Grid</option>
                                <option value="3" {{ ($store->flyerDetails->layout_type ?? '') == 3 ? 'selected' : '' }}>Table</option>
                            </select>
                        </div>
                        <div class="col-lg-6 name_div">
                            <label for="logoSize" class="info_label">Logo Size<span class="text-danger">*</span></label><br>
                            <select name="logoSize" id="logoSize" class="select_box"  required>
                                <option value="1" {{ ($store->flyerDetails->logo_size ?? '') == 1 ? 'selected' : '' }}>Small</option>
                                <option value="2" {{ ($store->flyerDetails->logo_size ?? '') == 2 ? 'selected' : '' }}>Large</option>
                                <option value="3" {{ ($store->flyerDetails->logo_size ?? '') == 3 ? 'selected' : '' }}>Extra Large</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <b>Flyer Message</b>
                            <p class="flyer_msg">Limit message to 200 characters.</p>
                            <textarea class="form-control flyer_textarea" name="flyerMsg" id="flyerMsg" maxlength="200" cols="" rows="">{{ $store->flyerDetails->flyer_message ?? '' }}</textarea>
                        </div>
                        <div class="col-lg-12 name_div" style="margin-top: 10px;">
                            <b>Manage Content Visibility</b><br>
                            <div class="name_div">
                                <input type="checkbox" id="instruction" name="instruction" checked disabled>
                                <label for="instruction"> Show Instructions</label><br>

                                <input type="checkbox" id="price" name="price" {{ ($store->flyerDetails->show_prices ?? 0) == 1 ? 'checked' : '' }}>
                                <label for="price"> Show Prices</label><br>

                                <input type="checkbox" id="description" name="description" {{ ($store->flyerDetails->show_description ?? 0) == 1 ? 'checked' : '' }}>
                                <label for="description"> Show Description</label><br>

                                <input type="checkbox" id="shipDate" name="shipDate" {{ ($store->flyerDetails->include_ship_date ?? 0) == 1 ? 'checked' : '' }}>
                                <label for="shipDate"> Include Ship Date</label><br>

                                <input type="checkbox" id="storeDeadline" name="storeDeadline" {{ ($store->flyerDetails->include_store_deadline ?? 0) == 1 ? 'checked' : '' }}>
                                <label for="storeDeadline"> Include Store Deadline</label><br>

                                <input type="checkbox" id="qrCode" name="qrCode" {{ ($store->flyerDetails->include_qr_code ?? 0) == 1 ? 'checked' : '' }}>
                                <label for="qrCode"> Include QR Code</label><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 text-right">
                    <button type="submit" style="background-color: #47aed6" class="styled-button-decoration btn btn-success mt-2">Update</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#edit_flyer').on('submit', function() {
            $('.se-pre-con').fadeIn('slow');
        });
    });

</script>

@endsection
@section('content')
    @include('pages.stores.layouts.sidebar')
@endsection

