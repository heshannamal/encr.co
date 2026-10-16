@extends('layouts.app', ['activePage' => 'organizations', 'titlePage' => __('Creating New Organization')])

@section('content')
<style>
    #image_container {
        width: 100px;
        height: 100px;
        margin-left: 15px;
        margin-top: -30px;
        border-radius: 50%;
        overflow: hidden;
    }
    #image_preview {
        width: 100%;
        height: 100%;
    }
</style>

<div class="container-fluid mt-5">
    <form action="{{ route('organizations.create') }}" method="post" enctype="multipart/form-data">
    @csrf
{{-- Organization Details --}}
        <div class="card mb-2">
            <div class="card-header">Organization Details</div>
            @if (request()->has('people_id')) <input type="hidden" value="{{ request()->get('people_id') }}" name="existing_people" /> @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-field">
                        <label class="form-lable">Organization Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-input" id="organization_name" name="organization_name" required>
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Website</label>
                        <input type="text" class="form-control form-input" id="website" name="website" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Email</label>
                        <input type="email" class="form-control form-input" id="email" name="email" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Sport</label>
                        <select class="form-control form-input" id="sport" name="sport">
                            <option value="">Select a Sport</option>
                            @foreach ($sports as $sport)
                                <option value="{{$sport->sport_name}}">{{$sport->sport_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Sales Rep <span class="text-danger">*</span></label>
                        <select class="form-control form-input" class="form-control form-input" id="user_id" name="user_id" required>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="col-md-6 form-field">
                        <label class="form-lable">Assign to</label>
                        <select class="form-control form-input" class="form-control form-input" id="assigned_to" name="assigned_to" multiple="multiple">
                            <option value="designers">designers</option>
                            <option value="factories">factories</option>
                        </select>
                    </div> --}}

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Size Of Club</label>
                        <input type="number" class="form-control form-input" id="size_of_club" name="size_of_club" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Colors</label>
                        <input type="text" class="form-control form-input" id="colors" name="colors" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Sales Tax (%)</label>
                        <input type="number" class="form-control form-input" id="sales_tax" name="sales_tax" step="0.01" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Sales Tax Active</label>
                        <select class="form-control form-input" class="form-control form-input" id="sales_tax_active" name="sales_tax_active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-field mt-5">
                        <label class="form-lable">Organization Logo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control form-input" id="organization_logo" name="organization_logo" onchange="uploadFile()" required style="overflow: hidden;" />

                        <div id="image_container">
                            <img src="{{ asset('argon') }}/img/icons/placeholder.png" id="image_preview" />
                        </div>
                    </div>

                    {{-- <div class="col-md-6 form-field">
                        <label class="form-lable">Upload PayPal Receipt: <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="paypal_receipt" id="paypal_receipt" onchange="encodePaypalFileAsURL(this)" data-img-uri="" data-empty-message="Please Select a Payment Receipt" accept=".jpg,.jpeg,.png,.pdf" required />
                    </div>

                    <div class="col-md-6 form-field">
                        <div id="paypal_receipt_preview">
                            <img src="{{asset('argon')}}/img/icons/check.png" style="width: 50%; opacity: 0.5;" />
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

{{-- Shipping Address --}}
        <div class="card mb-2">
            <div class="card-header">Postal Address</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-field">
                        <label class="form-lable">Street</label>
                        <input type="text" class="form-control form-input" id="shipping_street" name="shipping_street" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable"> City</label>
                        <input type="text" class="form-control form-input" id="shipping_city" name="shipping_city" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable"> State</label>
                        <input type="text" class="form-control form-input" id="shipping_state" name="shipping_state" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable"> Postal Code</label>
                        <input type="text" class="form-control form-input" id="shipping_postal_code" name="shipping_postal_code" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable"> Country</label>
                        <input type="text" class="form-control form-input" id="shipping_country" name="shipping_country" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 control-btns mb-5">
            <button type="submit" class="btn btn-success btn-custom">Save</button>
            <button type="reset" class="btn btn-secondary btn-custom">Cancel</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('select').select2();
    });

    function uploadFile() {
        var image_preview = document.getElementById("image_preview");
        var file = document.querySelector("input[type=file]").files[0];

        var reader = new FileReader();
        reader.onloadend = function () {
            image_preview.src = reader.result;
            document.getElementById("base64").value = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            image_preview.src = "";

        }
    }
</script>
@endsection
