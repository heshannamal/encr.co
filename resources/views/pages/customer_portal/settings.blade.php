@extends('pages.customer_portal.layouts.sidebar', ['sub_active' => 'orders'])

@section('sub-sidebar-content')
<style>
/* ===== PROFILE CARD FIXES ===== */

/* Avatar default (desktop) */
.profile-avatar img {
    width: 170px;
    height: 170px;
    object-fit: cover;
}

/* Mobile fixes */
@media (max-width: 576px) {
    .profile-avatar {
        top: 90%;
    }

    .profile-avatar img {
        width: 120px;
        height: 120px;
    }

    .profile-info {
        flex-direction: column;
        text-align: center;
        gap: 12px;
        margin-top: 20px;
    }

    .profile-info h3 {
        font-size: 1.4rem;
    }

    .profile-info p {
        font-size: 0.9rem;
    }
}

@media (max-width: 767.98px) {

    .organization-edit-layout {
        display: flex;
        flex-direction: column;
    }

    /* About + Organization Users */
    .organization-edit-layout .organization-side-column {
        order: 1;
    }

    /* Edit Organization */
    .organization-edit-layout .organization-edit-column {
        order: 2;
    }
}

</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3"><a href="{{ route('customer_portal.dashboard') }}" class="text-decoration-none" style="color: unset;"> HOME</a></div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Settings</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<div class="card rounded-4">
    <div class="card-body p-4">

        <!-- Cover -->
        <div class="position-relative mb-5">
            <img src="assets/images/gallery/profile-cover.png"
                 class="img-fluid rounded-4 shadow w-100"
                 alt="">

            <!-- Avatar -->
            <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                <img id="orgLogo"
                     src="{{ $organization->organization_logo ? asset($organization->organization_logo) : asset('assets/img/organization/default.png') }}"
                     class="rounded-circle p-1 bg-grd-danger shadow"
                     alt="Organization Logo">
            </div>
        </div>

        <!-- Profile Info -->
        <div class="profile-info pt-5 d-flex align-items-center justify-content-between">
            <div>
                <h3 class="mb-1">{{ $organization->organization_name }}</h3>
                <p class="mb-0 text-muted">{{ $organization->website }}</p>
            </div>

            <div>
                <button type="button"
                        class="btn btn-outline-secondary rounded-5 px-4 px-sm-4 px-3 py-sm-2 py-1"
                        id="changeLogoBtn">
                    <i class="bi bi-pen me-1"></i>
                    <span class="d-none d-sm-inline">Change LOGO</span>
                    <span class="d-inline d-sm-none">Edit</span>
                </button>

                <input type="file"
                       id="logoInput"
                       accept="image/*"
                       class="d-none">
            </div>
        </div>

    </div>
</div>
<div class="row organization-edit-layout">
    <div class="col-12 col-xl-8 organization-edit-column">
        <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="">
                        <h5 class="mb-0 fw-bold">Edit Organization</h5>
                    </div>
                </div>
                <form id="organizationForm" class="row g-4">
                    @csrf

                    <div class="col-md-12">
                        <label class="form-label">Organization Name</label>
                        <input type="text" class="form-control"  value="{{ $organization->organization_name }}" readonly>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Website</label>
                        <input type="text" class="form-control" name="website" value="{{ $organization->website }}">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control"  value="{{ $organization->email }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Sport</label>
                        <select class="form-select" name="sport_id">
                            @foreach ($sports as $sport)
                                <option value="{{ $sport->id }}" {{ $organization->sport == $sport->id ? 'selected' : '' }}>
                                    {{ $sport->sport_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Size of Club</label>
                        <input type="text" class="form-control" name="size_of_club" value="{{ $organization->size_of_club }}">
                    </div>

                    {{-- <div class="col-md-6">
                        <label class="form-label">Lead Source</label>
                        <select class="form-select" name="lead_source_id">
                            @foreach ($lead_sources as $lead_source)
                                <option value="{{ $lead_source->id }}" {{ $organization->lead_source == $lead_source->id ? 'selected' : '' }}>
                                    {{ $lead_source->lead_source_name }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    {{-- <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <select class="form-select" name="shipping_country" id="shipping_country">
                            <option value="">Select a Country</option>
                        </select>
                    </div> --}}

                    {{-- <div class="col-md-6">
                        <label class="form-label">State</label>
                        <input type="text" class="form-control" name="shipping_state" value="{{ $organization->shipping_state }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="shipping_city" value="{{ $organization->shipping_city }}">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Street Address</label>
                        <input type="text" class="form-control" name="shipping_street" value="{{ $organization->shipping_street }}">
                    </div>


                    <div class="col-md-4">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" name="shipping_postal_code" value="{{ $organization->shipping_postal_code }}">
                    </div> --}}
                    {{-- Shipping Address --}}
{{-- Billing Address Toggle --}}
<div class="col-md-12 mt-3">
    <div class="form-check form-switch">
        <input class="form-check-input"
               type="checkbox"
               id="sameAsShipping"
               name="same_as_shipping"
               value="1"
               {{ !empty($organization->same_as_shipping) ? 'checked' : '' }}>

        <label class="form-check-label fw-bold" for="sameAsShipping">
            Billing address same as shipping address
        </label>
    </div>
</div>


{{-- Shipping + Billing Address --}}
<div class="col-md-12">
    <div class="row g-4">

        {{-- Shipping Address --}}
        <div class="col-12 col-lg-6" id="shippingAddressCol">
            <div class=" border rounded-4 h-100">
                <div class="card-body">
                    <h6 class="fw-bold border-bottom pb-2 mb-3">
                        Shipping Address
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Shipping Country</label>
                            <select class="form-select shipping-field"
                                    name="shipping_country"
                                    id="shipping_country">
                                <option value="">Select a Country</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Shipping State</label>
                            <input type="text"
                                   class="form-control shipping-field"
                                   name="shipping_state"
                                   id="shipping_state"
                                   value="{{ $organization->shipping_state }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Shipping City</label>
                            <input type="text"
                                   class="form-control shipping-field"
                                   name="shipping_city"
                                   id="shipping_city"
                                   value="{{ $organization->shipping_city }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Shipping Street Address</label>
                            <input type="text"
                                   class="form-control shipping-field"
                                   name="shipping_street"
                                   id="shipping_street"
                                   value="{{ $organization->shipping_street }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Shipping Postal Code</label>
                            <input type="text"
                                   class="form-control shipping-field"
                                   name="shipping_postal_code"
                                   id="shipping_postal_code"
                                   value="{{ $organization->shipping_postal_code }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Billing Address --}}
        <div class="col-12 col-lg-6" id="billingAddressCol">
            <div class=" border rounded-4 h-100">
                <div class="card-body">
                    <h6 class="fw-bold border-bottom pb-2 mb-3">
                        Billing Address
                    </h6>

                    <div id="billingAddressWrapper">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Billing Country</label>
                                <select class="form-select billing-field"
                                        name="billing_country"
                                        id="billing_country">
                                    <option value="">Select a Country</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Billing State</label>
                                <input type="text"
                                       class="form-control billing-field"
                                       name="billing_state"
                                       id="billing_state"
                                       value="{{ $organization->billing_state ?? '' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Billing City</label>
                                <input type="text"
                                       class="form-control billing-field"
                                       name="billing_city"
                                       id="billing_city"
                                       value="{{ $organization->billing_city ?? '' }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Billing Street Address</label>
                                <input type="text"
                                       class="form-control billing-field"
                                       name="billing_street"
                                       id="billing_street"
                                       value="{{ $organization->billing_street ?? '' }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Billing Postal Code</label>
                                <input type="text"
                                       class="form-control billing-field"
                                       name="billing_postal_code"
                                       id="billing_postal_code"
                                       value="{{ $organization->billing_postal_code ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

                    <div class="col-md-12">
                        <label class="form-label">Organization Note</label>
                        <textarea class="form-control" name="organization_note" placeholder="Organization Note" rows="4">{{ $organization->organization_note }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="button" id="updateOrganization" class="btn btn-outline-secondary px-4">Update</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4 organization-side-column">
    <div class="card rounded-4">
        <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div class="">
            <h5 class="mb-0 fw-bold">About</h5>
            </div>
            </div>
            <div class="full-info">
            <div class="info-list d-flex flex-column gap-3">
            <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">account_circle</span><p class="mb-0">Full Name: {{$contact->first_name }} {{$contact->last_name }}</p></div>
            <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span><p class="mb-0">Status: active</p></div>
            <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">flag</span><p class="mb-0">Country: {{$contact->shipping_country }}</p></div>
            <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">language</span><p class="mb-0">Language: English</p></div>
            <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">send</span><p class="mb-0">Email: {{$contact->email }}</p></div>
            <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">call</span><p class="mb-0">Phone: {{$contact->phone_no }}</p></div>
            </div>
        </div>
        </div>
    </div>
    <div class="card rounded-4">
        <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div class="">
                <h5 class="mb-0 fw-bold">Organization Users</h5>
            </div>
        </div>

        <div class="account-list d-flex flex-column gap-4">
            @foreach ($organization->contactOrganizations as $user)
                <div class="account-list-item d-flex align-items-center gap-3">
                    <span class="material-icons-outlined">account_circle</span>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">{{$user->contacts[0]->first_name}} {{$user->contacts[0]->last_name}}</h6>
                        <p class="mb-0">{{$user->contacts[0]->email}}</p>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </div>
    </div>
</div><!--end row-->

<script>
$(document).ready(function() {

    document.getElementById('changeLogoBtn').addEventListener('click', function() {
        document.getElementById('logoInput').click();
    });

    document.getElementById('logoInput').addEventListener('change', function() {
        let file = this.files[0];
        if (!file) return;

        let formData = new FormData();
        formData.append('organization_logo', file);

        fetch("{{ route('customer_portal.updateLogo', $organization->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // update logo in view
                document.getElementById('orgLogo').src = data.logo_url;
                document.getElementById('orgLogo_headder').src = data.logo_url;
                Swal.fire({
                    icon: 'success',
                    title: 'Logo Updated!',
                    text: 'Organization logo was successfully updated.'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to update logo.'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An unexpected error occurred.'
            });
        });
    });
    // Fetch country data
//    $.ajax({
//         url: 'https://countriesnow.space/api/v0.1/countries',
//         method: 'GET',
//         success: function(data) {
//             const countries = data.data;
//             const $select = $('#shipping_country');

//             countries.forEach(function(country) {
//                 const option = $('<option></option>')
//                     .attr('value', country.country)
//                     .text(country.country);

//                 $select.append(option);
//             });

//             // Pre-select the current country (if any)
//             const currentCountry = "{{ $organization->shipping_country }}";
//             if (currentCountry) {
//                 $select.val(currentCountry);
//             }
//         },
//         error: function(error) {
//             console.error('Error fetching countries:', error);
//         }
//     });
        $.ajax({
            url: 'https://countriesnow.space/api/v0.1/countries',
            method: 'GET',
            success: function(data) {
                const countries = data.data;

                const $shippingSelect = $('#shipping_country');
                const $billingSelect = $('#billing_country');

                $shippingSelect.empty().append('<option value="">Select a Country</option>');
                $billingSelect.empty().append('<option value="">Select a Country</option>');

                countries.forEach(function(country) {
                    const shippingOption = $('<option></option>')
                        .attr('value', country.country)
                        .text(country.country);

                    const billingOption = $('<option></option>')
                        .attr('value', country.country)
                        .text(country.country);

                    $shippingSelect.append(shippingOption);
                    $billingSelect.append(billingOption);
                });

                const currentShippingCountry = "{{ $organization->shipping_country }}";
                const currentBillingCountry = "{{ $organization->billing_country ?? '' }}";

                if (currentShippingCountry) {
                    $shippingSelect.val(currentShippingCountry);
                }

                if (currentBillingCountry) {
                    $billingSelect.val(currentBillingCountry);
                }

                if ($('#sameAsShipping').is(':checked')) {
                    $('#billing_country').val($('#shipping_country').val());
                }
            },
            error: function(error) {
                console.error('Error fetching countries:', error);
            }
        });
    $('#updateOrganization').on('click', function() {
        let formData = $('#organizationForm').serialize(); // get all form data

        $.ajax({
            url: "{{ route('customer_portal.Org_update', $organization->id) }}", // route to update function
            method: "POST",
            data: formData,
            success: function(response) {
                if(response.success){
                    // alert('Organization updated successfully!');
                    Swal.fire('Success', 'Organization updated successfully!', 'success');
                    // optionally refresh page or update UI
                } else {
                    alert('Something went wrong.');
                    Swal.fire('Not Found', 'Something went wrong.', 'warning');
                }
            },
            error: function(xhr){
                console.log(xhr.responseJSON);
                alert('Validation error. Check console.');
            }
        });
    });

   function copyShippingToBilling() {
    $('#billing_country').val($('#shipping_country').val());

    $('#billing_state').val($('#shipping_state').val());
    $('#billing_city').val($('#shipping_city').val());
    $('#billing_street').val($('#shipping_street').val());
    $('#billing_postal_code').val($('#shipping_postal_code').val());
}

function toggleBillingAddress() {
    if ($('#sameAsShipping').is(':checked')) {
        copyShippingToBilling();

        $('#shippingAddressCol')
            .removeClass('col-lg-6')
            .addClass('col-lg-12');

        $('#billingAddressCol').hide();
    } else {
        $('#shippingAddressCol')
            .removeClass('col-lg-12')
            .addClass('col-lg-6');

        $('#billingAddressCol').show();
    }
}

$(document).on('change', '#sameAsShipping', function () {
    toggleBillingAddress();
});

$(document).on('input change', '.shipping-field', function () {
    if ($('#sameAsShipping').is(':checked')) {
        copyShippingToBilling();
    }
});

$(document).ready(function () {
    toggleBillingAddress();
});
});


</script>

@endsection

