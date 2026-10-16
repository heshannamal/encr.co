@extends('layouts.app', ['activePage' => 'omg_store_profile', 'titlePage' => __('OMG Store & Profile')])


@section('content')

<style>
    .add-btn-text {
        position: relative;
        right: -13px;
    }
    .btns-text {
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }
    .btns-text:hover {
        color: #909090 ;
    }
    .btns-style {
        width: 100%;
        height: 100%;
        background-color: #909090;
        border: unset;
        border-radius: 5px;
    }
    .btns-card:hover {
        background-color: #ffffff
    }
    .btns-padding {
        padding-left: 0.2rem;
        padding-right: 0.2rem;
    }
    .btns-right-position {
        position: relative;
        right: 52px;
    }
    .btn-top {
        position: relative;
        top: -12px;
    }
    .content-position {
        position: relative;
        top: -24px;
    }
    .copy-btn {
        position: relative;
        top: -4px;
        left: 10px;
    }
</style>
    {{-- <html lang="en">
<head> --}}
    {{-- <title>Laravel Image Upload With Preview - W3Adda</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> --}}
    {{-- </head> --}}

    <div class="container-fluid mb-5 content-position">
        <div class="se-pre-con"></div>
        <div class="col-md-12 mt-5">

            @section('order-header')
                <span>OMG - Organization Store Details</span>
            @endsection

            @section('back-btn')
            <a href="{{ route('pages.order_place.all_stores') }}" class="home-btn-color" title="Back to home">BACK TO OMG STORES</a>
            @endsection

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Apologies</strong> Some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="col-md-12 btn-top">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 ">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3 btns-padding">
                                    <button class="btns-text btns-style btns-card btnURLGen" style="outline: unset;"  title="Generate URL">
                                        Generate URL
                                    </button>
                            </div>
                            <div class="col-md-3 btns-padding">
                                    <button type="button" class="btns-text btns-style btns-card " style="outline: unset;"  title="Add Product">
                                        <a class="btns-text btns-style btns-card " href="{{ url('OMG/store/product/add/' . $OrganizationStores[0]->id . '') }}"> Add Product</a>
                                    </button>
                            </div>
                            <div type="button" class="col-md-3 btns-padding">
                                    <button class="btns-text btns-style btns-card " style="outline: unset;"   title="View All Products">
                                        <a class="btns-text btns-style btns-card " href="{{ url('OMG/store/'.$OrganizationStores[0]->id.'/products') }}">View All Products</a>
                                    </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                {{-- <div class="card-header">
                    <div class="card-header-danger col-md-12">
                        <div class="col-md-5 float-left header-details">
                            <h4 class="mb-0">
                                <span class="d-block details-name">OMG - Organization Store Details</span>
                            </h4>
                        </div>
                    </div>

                </div> --}}

                <div class="card-body">
                    {{-- <div style="text-align-last: end;">
                        <button style="" type="button" class="btn btn-success btnURLGen" style="">Generate URL</button>
                        <a type="button" href="{{ url('OMG/store/product/add/' . $OrganizationStores[0]->id . '') }}"
                            class="btn btn-secondary">Add Product</a>
                        <a type="button" href="{{ url('OMG/store/'.$OrganizationStores[0]->id.'/products') }}" class="btn btn-secondary">View All Products</a>
                        <button style="" type="submit" class="btn btn-danger" style="">Edit Organizatinal
                            Store</button>
                        <button style="" name="btnDelete" type="button" class="btn btn-danger btnDelete" style="">Delete</button>
                    </div> --}}
                    <br>
                    <form method="post" action="{{ url('editOrganizationStore') }}" enctype="multipart/form-data">
                        @csrf
                        <h3>{{ $OrganizationStores[0]->organizationDetails['organization_name'] . ' - ' . $OrganizationStores[0]->store_name }}
                        </h3>
                        <br>
                        <input type="text" value="{{ $OrganizationStores[0]->id }}" hidden
                                name="organizatinalStoreId" id="organizatinalStoreId"/>
                        <input type="text"
                                value="www.omg.encr.co/store/{{ $OrganizationStores[0]->id . '/' }}@php echo(str_replace(' ', '_', $OrganizationStores[0]->store_name)); @endphp"
                                hidden id="storeLinkGenerated" />

                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Select an
                                    Organization</label>
                                <br>

                                <select class="form-control select2-edit-order" name="organization_id"
                                    id="organization_id" required>
                                    <option value=""> Select an Organozation</option>
                                    @foreach ($organizations as $organization)
                                        <option value="{{ $organization->id }}" @if ($organization->id == $OrganizationStores[0]->organization_id) selected @endif>
                                            {{ $organization->organization_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Store Name</label>
                                <br>
                                <input class="form-control" name="store_name" id="store_name" type='text'
                                    value='{{ $OrganizationStores[0]->store_name }}' />
                            </div>
                        </div><br>
                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Profile Picture
                                </label>
                                <br>
                                <input type="file" name="profile_image" id="profile_image" onchange="loadPreview(this);"
                                    class="form-control">

                                <label for="profile_image"></label><br>
                                <img id="preview_img" style=""
                                    @if ($OrganizationStores[0]->profile_pic != null || $OrganizationStores[0]->profile_pic != "")
                                    src="../../../public/profile_images/{{ $OrganizationStores[0]->profile_pic }}"
                                    @else
                                    src="https://w7.pngwing.com/pngs/527/625/png-transparent-scalable-graphics-computer-icons-upload-uploading-cdr-angle-text-thumbnail.png"
                                    @endif
                                    class="" width="200" height="150" />
                            </div>
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Cover Picture
                                </label>
                                <br>
                                <input type="file" name="cover_image" id="cover_image" onchange="profilePreview(this);"
                                    class="form-control">

                                <label for="cover_image"></label><br>
                               <img id="preview_img1" style=""
                                    @if ($OrganizationStores[0]->cover_pic != null || $OrganizationStores[0]->cover_pic != "")
                                    src="../../../public/cover_image/{{ $OrganizationStores[0]->cover_pic }}"
                                    @else
                                    src="https://w7.pngwing.com/pngs/527/625/png-transparent-scalable-graphics-computer-icons-upload-uploading-cdr-angle-text-thumbnail.png"
                                    @endif
                                    class="" width="200" height="150" />
                            </div>
                        </div><br>
                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Store Sport</label>
                                    <br>
                                    <input class="form-control" name="store_sport" id="store_sport" type='text'
                                        value='{{ $OrganizationStores[0]->store_sport }}' />
                            </div>
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Store
                                    Description</label>
                                <br>
                                <input class="form-control" name="store_description" id="store_description"
                                    type='text' value='{{ $OrganizationStores[0]->store_description }}' />
                            </div>
                        </div><br>
                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Store
                                    Link</label>
                                <br>
                                <div style="width: 100%;display: flex ;">
                                    <input class="form-control" name="store_link" id="store_link" type='text'
                                        style="color: grey;" value='' readonly />
                                    <button type="button" class="btn btn-primary btnCopyText copy-btn">Copy</button>
                                </div>
                            </div>
                            <div class="col">

                            </div>
                        </div><br>


                        <div style="text-align-last: end;margin-top:10px;">
                            <button style="" type="button" class="btn btn-success btnURLGen" style="">Generate URL</button>
                            <a type="button" href="{{ url('OMG/store/product/add/' . $OrganizationStores[0]->id . '') }}"
                                class="btn btn-secondary">Add Product</a>
                            <a type="button" href="{{ url('OMG/store/'.$OrganizationStores[0]->id.'/products') }}" class="btn btn-secondary">View All Products</a>
                            <button style="" type="submit" class="btn btn-danger" style="">Edit Organizatinal
                                Store</button>
                            <button style="" name="btnDelete" type="button" class="btn btn-danger btnDelete" style="">Delete</button>
                        </div>
                    </form>




                </div>
            </div>
            <br>
        </div>
    </div>



    </html>
    <script>
        function loadPreview(input, id) {
            id = id || '#preview_img';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width(200)
                        .height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        //  Profile Picture
        function profilePreview(input, id) {
            id = id || '#preview_img1';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width(200)
                        .height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".btnURLGen").click(function() {
            document.getElementById("store_link").value = document.getElementById("storeLinkGenerated").value;
        });

        $(".btnCopyText").click(function() {
            var copyText = document.getElementById("store_link");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);

            /* Alert the copied text */
            alert("Copied");
        });
        $(".btnDelete").click(function(){



                $.ajax({
                    url: "{{ url('OMG/store/delete') }}",
                    type: "post",
                    data: {
                        'storeID': $("#organizatinalStoreId").val(),
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data);
                        if(data == "deleted")
                        {
                            window.location.href = "{{ url('OMG/stores') }}";
                        }
                    }
                });
        });

        // End
    </script>
@endsection
