@extends('layouts.app', ['activePage' => 'schedules', 'titlePage' => __('Events and Meeting Schedules')])

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
    .em-wrap{padding:0;margin:0;}
    .form-card{background:#fff;border-radius:18px;box-shadow:0 12px 38px rgba(15,23,42,.06);padding:24px;margin:0;width:100%;}
    .page-title{font-size:28px;font-weight:900;text-align:left;}
    .soft-input{height:48px;border-radius:10px;border:1px solid #d8dee9;}
    .soft-input:focus,.soft-area:focus{box-shadow:0 0 0 4px rgba(37,99,235,.12);border-color:#2563eb;}
    .soft-area{border-radius:10px;border:1px solid #d8dee9;}
    .btn-gradient{background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;border:0;border-radius:10px;font-weight:800;padding:12px 24px;}
    .btn-gradient:hover{color:#fff;transform:translateY(-1px);}
    .btn-outline-soft{border:1px solid #d8dee9;border-radius:10px;font-weight:800;padding:12px 24px;background:#fff;}
    .required{color:#ef4444;}
    .map-box{height:310px;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;background:#f8fafc;}
    .map-box iframe{width:100%;height:100%;border:0;}
    .map-help{font-size:12px;color:#64748b;}
    .training-card{border:1px solid #e5e7eb;border-radius:14px;padding:14px;cursor:pointer;transition:.18s;background:#fff;}
    .training-card:hover{border-color:#2563eb;box-shadow:0 10px 24px rgba(37,99,235,.08);}
    .training-card.active{border-color:#2563eb;background:#eff6ff;box-shadow:0 0 0 4px rgba(37,99,235,.10);}
    .training-icon{width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;display:flex;align-items:center;justify-content:center;}
    .location-suggestions{position:absolute;z-index:20;left:0;right:0;top:100%;background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 18px 40px rgba(15,23,42,.15);max-height:260px;overflow:auto;display:none;margin-top:6px;}
    .location-suggestion{padding:11px 14px;cursor:pointer;border-bottom:1px solid #f1f5f9;}
    .location-suggestion:hover{background:#f8fafc;color:#2563eb;}
    .location-suggestion:last-child{border-bottom:0;}
    .bg-box.container-fluid.fix-nav.header-layout{
        margin-bottom: .0 !important;
    }
    .instructor-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .instructor-row {
        display: grid;
        grid-template-columns: 1fr 46px;
        gap: 10px;
        align-items: center;
    }

    .instructor-input-wrap {
        position: relative;
    }

    .instructor-input-wrap .instructor-input {
        padding-left: 46px;
    }

    .instructor-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 24px;
        height: 24px;
        border-radius: 999px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        z-index: 2;
    }

    .instructor-add-btn {
        border: 0;
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        color: #fff;
        border-radius: 999px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        box-shadow: 0 10px 22px rgba(37, 99, 235, .22);
        transition: .18s ease;
    }

    .instructor-add-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 28px rgba(37, 99, 235, .30);
    }

    .instructor-remove-btn {
        width: 46px;
        height: 46px;
        border: 0;
        border-radius: 14px;
        background: #fee2e2;
        color: #dc2626;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .18s ease;
    }

    .instructor-remove-btn:hover {
        background: #dc2626;
        color: #fff;
        transform: translateY(-1px);
    }

    @media (max-width: 575px) {
        .instructor-row {
            grid-template-columns: 1fr 42px;
        }

        .instructor-remove-btn {
            width: 42px;
            height: 42px;
        }

        .instructor-add-btn {
            padding: 8px 13px;
            font-size: 12px;
        }
    }
</style>

@section('back-btn')
    <a href="{{ route('schedules.index') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection

@section('order-header')
    Events & Meetings
@endsection

@php
    $selectedTraining = old('training_type', optional($session)->training_type ?: 'Stickwork');
    $instructorValue = old('instructor', optional($session)->instructor ?: '');
    $locationValue = old('location', optional($session)->location);
    $streetAddressValue = old('street_address', optional($session)->street_address);
    $cityValue = old('city', optional($session)->city);
    $capacityValue = old('capacity', optional($session)->capacity);
    $latValue = old('location_lat', optional($session)->location_lat);
    $lngValue = old('location_lng', optional($session)->location_lng);
@endphp

<div class="em-wrap mb-4">
    <form class="form-card"
          method="POST"
          action="{{ $session ? route('em.sessions.update', $session->id) : route('em.sessions.store') }}"
          enctype="multipart/form-data">
        @csrf

        @if($session)
            @method('PUT')
        @endif

        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <h3 class="page-title mb-1">
                    {{ $session ? 'Edit Event Session' : 'Create Event Session' }}
                </h3>

                <p class="text-muted mb-0">
                    Create a class/session with training type, instructor, location, date and time.
                </p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4" role="alert">
                <div class="fw-bold mb-2">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    Please correct the following errors:
                </div>

                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger rounded-3 mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="row g-4">

            <div class="col-12">
                <input type="hidden" name="name" value="temp">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">
                    Type of Training <span class="required">*</span>
                </label>

                <input type="hidden"
                       name="training_type"
                       id="trainingTypeInput"
                       value="{{ $selectedTraining }}">

                <div class="row g-3">
                    @foreach(['Stickwork' => 'fa-hockey-puck', 'Speedwork' => 'fa-bolt', 'Fieldwork' => 'fa-person-running'] as $type => $icon)
                        <div class="col-md-4">
                            <div class="training-card {{ $selectedTraining === $type ? 'active' : '' }}"
                                 data-training="{{ $type }}">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="training-icon">
                                        <i class="fa-solid {{ $icon }}"></i>
                                    </div>

                                    <div>
                                        <div class="fw-bold">
                                            {{ $type }}
                                        </div>

                                        <div class="small text-muted">
                                            {{ $type === 'Stickwork' ? 'Technical skills' : ($type === 'Speedwork' ? 'Speed and agility' : 'Field drills') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('training_type')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-lg-7">
                <div class="row g-4">

                    <div class="col-12">
                        <label class="form-label fw-bold">Description</label>

                        <textarea name="description"
                                  class="form-control soft-area @error('description') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Enter description">{{ old('description', optional($session)->description) }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-control-label">
                            Documentation
                            <small class="text-muted">(Optional PDF)</small>
                        </label>

                        <input type="file"
                               name="documentation"
                               class="form-control @error('documentation') is-invalid @enderror"
                               accept=".pdf,application/pdf">

                        <small class="text-muted">
                            Upload training notes, drills, instructions or other documentation.
                        </small>

                        <small class="form-text text-muted">
                            PDF files only. Maximum size: 20 MB.
                        </small>

                        @error('documentation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        @if(!empty(optional($session)->documentation))
                            <div class="mt-2">
                                <a href="{{ asset('storage/'.$session->documentation) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-file-pdf"></i>
                                    View Current PDF
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-bold">Street Address</label>

                        <input type="text"
                               name="street_address"
                               class="form-control soft-input @error('street_address') is-invalid @enderror"
                               value="{{ $streetAddressValue }}"
                               placeholder="Enter street address">

                        @error('street_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">City</label>

                        <input type="text"
                               name="city"
                               class="form-control soft-input @error('city') is-invalid @enderror"
                               value="{{ $cityValue }}"
                               placeholder="Enter city">

                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">
                            Location <span class="required">*</span>
                        </label>

                        <div class="position-relative">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fa-solid fa-location-dot text-primary"></i>
                                </span>

                                <input type="text"
                                       name="location"
                                       id="locationInput"
                                       class="form-control soft-input @error('location') is-invalid @enderror"
                                       value="{{ $locationValue }}"
                                       placeholder="Search location">

                                <button type="button" class="btn btn-outline-primary" id="previewMapBtn">
                                    Preview
                                </button>
                            </div>

                            <div class="location-suggestions" id="locationSuggestions"></div>
                        </div>

                        @error('location')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="map-help mt-1">
                            Start typing to search locations. Latitude and longitude are saved automatically and hidden.
                        </div>

                        <input type="hidden" name="location_lat" id="locationLat" value="{{ $latValue }}">
                        <input type="hidden" name="location_lng" id="locationLng" value="{{ $lngValue }}">

                        @error('location_lat')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        @error('location_lng')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="map-box">
                            <iframe id="mapFrame" src="https://maps.google.com/maps?q={{ urlencode($locationValue ?: 'Colombo') }}&output=embed"></iframe>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">What to Bring</label>

                        <textarea name="what_to_bring"
                                  class="form-control soft-area @error('what_to_bring') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Example: Stick, helmet, water bottle, training shoes">{{ old('what_to_bring', optional($session)->what_to_bring) }}</textarea>

                        @error('what_to_bring')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="col-lg-5">
                <div class="row g-4">
                    @php
                        $instructorText = old('instructor', $instructorValue ?? '');
                        $instructorList = old('instructors');

                        if (!is_array($instructorList)) {
                            $instructorList = collect(explode(',', $instructorText))
                                ->map(function ($name) {
                                    return trim($name);
                                })
                                ->filter()
                                ->values()
                                ->toArray();
                        }

                        if (empty($instructorList)) {
                            $instructorList = [''];
                        }
                    @endphp

                    <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <label class="form-label fw-bold mb-0">
                                    Instructors <span class="required">*</span>
                                </label>

                                <button type="button"
                                        class="instructor-add-btn"
                                        id="addInstructorBtn">
                                    <i class="fa-solid fa-plus"></i>
                                    Add New
                                </button>
                            </div>

                            <input type="hidden"
                                name="instructor"
                                id="instructorCombinedInput"
                                value="{{ old('instructor', $instructorValue) }}">

                            <div id="instructorFieldsWrapper" class="instructor-list">
                                @foreach($instructorList as $index => $instructorName)
                                    <div class="instructor-row">
                                        <div class="instructor-input-wrap">
                                            <span class="instructor-icon">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </span>

                                            <input type="text"
                                                name="instructors[]"
                                                class="form-control soft-input instructor-input @error('instructor') is-invalid @enderror @error('instructors.' . $index) is-invalid @enderror"
                                                value="{{ $instructorName }}"
                                                placeholder="Enter instructor name">
                                        </div>

                                        <button type="button"
                                                class="instructor-remove-btn remove-instructor-btn"
                                                title="Remove instructor">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            @error('instructor')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            @error('instructors')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Capacity <span class="required">*</span></label>

                        <input type="number"
                               name="capacity"
                               min="1"
                               class="form-control soft-input @error('capacity') is-invalid @enderror"
                               value="{{ $capacityValue }}"
                               placeholder="Enter maximum number of players">

                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">
                            Date <span class="required">*</span>
                        </label>

                        <input type="date"
                               name="event_date"
                               class="form-control soft-input @error('event_date') is-invalid @enderror"
                               value="{{ old('event_date', optional($session)->event_date ? \Carbon\Carbon::parse($session->event_date)->format('Y-m-d') : '') }}">

                        @error('event_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            Start Time <span class="required">*</span>
                        </label>

                        <input type="time"
                               name="start_time"
                               class="form-control soft-input @error('start_time') is-invalid @enderror"
                               value="{{ old('start_time', optional($session)->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '') }}">

                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">
                            End Time <span class="required">*</span>
                        </label>

                        <input type="time"
                               name="end_time"
                               class="form-control soft-input @error('end_time') is-invalid @enderror"
                               value="{{ old('end_time', optional($session)->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '') }}">

                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="p-4 bg-light rounded-3">
                            <div class="fw-bold mb-2">
                                <i class="fa-solid fa-circle-info text-primary me-2"></i>
                                Session Details
                            </div>

                            <div class="small text-muted">
                                Training type, instructor, location, address, capacity, and what-to-bring information will be visible on customer-side class details.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="d-flex justify-content-end gap-3 mt-5">
            <a href="{{ route('schedules.index', ['tab'=>'sessions']) }}" class="btn btn-outline-soft">
                Cancel
            </a>

            <button type="submit" class="btn btn-gradient">
                {{ $session ? 'Update Event' : 'Create Event' }}
            </button>
        </div>
    </form>
</div>

<script>
$(function(){
    $('.training-card').on('click', function(){
        $('.training-card').removeClass('active');
        $(this).addClass('active');
        $('#trainingTypeInput').val($(this).data('training'));
    });

    function updateMap(query){
        var q = query || $('#locationInput').val() || 'Colombo';
        $('#mapFrame').attr('src', 'https://maps.google.com/maps?q=' + encodeURIComponent(q) + '&output=embed');
    }

    $('#previewMapBtn').on('click', function(){
        updateMap();
    });

    var searchTimer = null;

    $('#locationInput').on('keyup', function(){
        var query = $(this).val();

        clearTimeout(searchTimer);

        if(!query || query.length < 3){
            $('#locationSuggestions').hide().html('');
            return;
        }

        searchTimer = setTimeout(function(){
            $.get('https://nominatim.openstreetmap.org/search', {
                q: query,
                format: 'json',
                limit: 6
            }).done(function(rows){
                var html = '';

                rows.forEach(function(row){
                    html += '<div class="location-suggestion" data-name="'+ $('<div>').text(row.display_name).html() +'" data-lat="'+ row.lat +'" data-lng="'+ row.lon +'">'+ $('<div>').text(row.display_name).html() +'</div>';
                });

                $('#locationSuggestions').html(html).toggle(!!html);
            });
        }, 350);
    });

    $(document).on('click', '.location-suggestion', function(){
        var name = $(this).data('name');
        var lat = $(this).data('lat');
        var lng = $(this).data('lng');

        $('#locationInput').val(name);
        $('#locationLat').val(lat);
        $('#locationLng').val(lng);
        $('#locationSuggestions').hide().html('');

        updateMap(name);
    });

    $(document).on('click', function(e){
        if(!$(e.target).closest('#locationInput,#locationSuggestions').length){
            $('#locationSuggestions').hide();
        }
    });
});

@if(config('services.google_maps.key') || env('GOOGLE_MAPS_API_KEY'))
function initEmGooglePlaces(){
    var input = document.getElementById('locationInput');

    if(!input || !window.google || !google.maps || !google.maps.places){
        return;
    }

    var autocomplete = new google.maps.places.Autocomplete(input, {
        fields: ['formatted_address', 'geometry', 'name']
    });

    autocomplete.addListener('place_changed', function(){
        var place = autocomplete.getPlace();
        var address = place.formatted_address || place.name || input.value;

        input.value = address;

        if(place.geometry && place.geometry.location){
            document.getElementById('locationLat').value = place.geometry.location.lat();
            document.getElementById('locationLng').value = place.geometry.location.lng();
        }

        $('#mapFrame').attr('src', 'https://maps.google.com/maps?q=' + encodeURIComponent(address) + '&output=embed');
    });
}
@endif
    function syncInstructorInput() {
        var instructors = [];

        $('.instructor-input').each(function () {
            var value = $.trim($(this).val());

            if (value !== '') {
                instructors.push(value);
            }
        });

        $('#instructorCombinedInput').val(instructors.join(', '));
    }

    $('#addInstructorBtn').on('click', function () {
        var html = ''
            + '<div class="instructor-row d-flex gap-2 mb-2">'
            + '<input type="text" name="instructors[]" class="form-control soft-input instructor-input" placeholder="Enter instructor name">'
            + '<button type="button" class="btn btn-outline-danger remove-instructor-btn" style="width:48px; height:48px;">'
            + '<i class="fa-solid fa-trash"></i>'
            + '</button>'
            + '</div>';

        $('#instructorFieldsWrapper').append(html);
        syncInstructorInput();
    });

    $(document).on('click', '.remove-instructor-btn', function () {
        if ($('.instructor-row').length > 1) {
            $(this).closest('.instructor-row').remove();
        } else {
            $(this).closest('.instructor-row').find('.instructor-input').val('');
        }

        syncInstructorInput();
    });

    $(document).on('input', '.instructor-input', function () {
        syncInstructorInput();
    });

    $('form').on('submit', function () {
        syncInstructorInput();
    });
</script>

@if(config('services.google_maps.key') || env('GOOGLE_MAPS_API_KEY'))
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') ?: env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initEmGooglePlaces"></script>
@endif

@endsection
