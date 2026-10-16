@extends('layouts.app', ['activePage' => 'people', 'titlePage' => __('Creating New Contact')])

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
    <form action="{{ route('people.create') }}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- Basic Information --}}
        <div class="card mb-2">
            <div class="card-header">Basic Information</div>
            @if (request()->has('organization_id')) <input type="hidden" value="{{ request()->get('organization_id') }}" name="existing_organization" /> @endif

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-field">
                        <label class="form-lable">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-input" id="first_name" name="first_name" required />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-input" id="last_name" name="last_name" required />
                    </div>

                    @if (request()->has('organization_id'))
                        <div class="col-md-12 form-field">
                            <label class="form-lable">Organization Name <span class="text-danger">*</span></label>
                            <select class="form-control form-input" id="organization_id" name="organization_id" style="width: 34%;" required>
                                <option value="">Select an Organization</option>
                                @foreach ($organizations as $organization)
                                <option value="{{$organization->id}}" @if (request()->get('organization_id') == $organization->id) selected @endif>{{$organization->organization_name}}</option>
                                @endforeach
                            </select>

                            <a href="{{ route('organizations.add', ['people_id'=>1]) }}" class="btn btn-sm input-group-text"><i class="fas fa-plus"></i></a>
                        </div>

                    @else
                        <div class="col-md-12 form-field">
                            <label class="form-lable">Organization Name <span class="text-danger">*</span></label>
                            <select class="form-control form-input" id="organization_id" name="organization_id" style="width: 34%;" required>
                                <option value="">Select an Organization</option>
                                @foreach ($organizations as $organization)
                                <option value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                @endforeach
                            </select>

                            <a href="{{ route('organizations.add', ['people_id'=>1]) }}" class="btn btn-sm input-group-text"><i class="fas fa-plus"></i></a>
                        </div>
                    @endif

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Lead Source</label>
                        <select class="form-control form-input" id="lead_source" name="lead_source">
                            <option value="">Select lead source</option>
                            @foreach ($lead_sources as $lead_source)
                                <option value="{{$lead_source->id}}">{{$lead_source->lead_source_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Phone No </label>
                        <input type="text" class="form-control form-input" id="phone_no" name="phone_no"/>
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-input" id="email" name="email" required/>
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Title </label>
                        <input type="text" class="form-control form-input" id="title" name="title"/>
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Assigned To <span class="text-danger">*</span></label>
                        <select class="form-control form-input" class="form-control form-input" id="user_id" name="user_id" required>
                            <optgroup label="Users">
                                @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Groups">
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer"></div>
        </div>

        {{-- Shipping Address --}}
        <div class="card mt-3">
            <div class="card-header">Postal Address</div>

            <div class="card-body">
                <div class="row">
                    {{-- <div class="col-md-6 form-field">
                        <label class="form-lable">PO Box</label>
                        <input type="text" class="form-control form-input" id="shipping_po_box" name="shipping_po_box" />
                    </div> --}}

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Street</label>
                        <input type="text" class="form-control form-input" id="shipping_street" name="shipping_street" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">City</label>
                        <input type="text" class="form-control form-input" id="shipping_city" name="shipping_city" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">State</label>
                        <input type="text" class="form-control form-input" id="shipping_state" name="shipping_state" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Postal Code</label>
                        <input type="text" class="form-control form-input" id="shipping_zip" name="shipping_zip" />
                    </div>

                    <div class="col-md-6 form-field">
                        <label class="form-lable">Country</label>
                        <input type="text" class="form-control form-input" id="shipping_country" name="shipping_country" />
                    </div>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>

        <div class="col-lg-12 control-btns mt-3 mb-5">
            <button type="submit" id="submit_btn" class="btn btn-success btn-custom">Save</button>
            <button type="reset" id="cancel_btn" class="btn btn-secondary btn-custom">Cancel</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
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
