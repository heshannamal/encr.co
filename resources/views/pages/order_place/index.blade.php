@extends('layouts.app', ['activePage' => 'add_OMG_Store', 'titlePage' => __('Add OMG Store')])

@section('content')

    {{-- <html lang="en">
<head> --}}
    {{-- <title>Laravel Image Upload With Preview - W3Adda</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> --}}
    {{-- </head> --}}

    <div class="container-fluid mb-5">
        <div class="se-pre-con"></div>
        <div class="col-md-12 mt-5">

            @section('back-btn')
                <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
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
            <div class="card">
                {{-- <div class="card-header">
                    <div class="card-header-danger col-md-12">
                        <div class="col-md-5 float-left header-details">
                            <h4 class="mb-0">
                                <span class="d-block details-name">OMG - Add Store</span>
                            </h4>
                        </div>
                    </div>

                </div> --}}

                <div class="card-body">
                    <form method="post" action="{{ url('addOrganizationStore') }}" enctype="multipart/form-data">
                        @csrf
                        <h3>Add OMG Store Details</h3><br>

                            <div class="row g-3">
                                <div class="col">
                                    <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Select an
                                        Organization</label>
                                    <br>

                                    <select class="form-control select2-edit-order" name="organization_id"
                                        id="organization_id" required>
                                        <option value=""> Select an Organization</option>
                                        @foreach ($organizations as $organization)
                                            <option value="{{ $organization->id }}">
                                                {{ $organization->organization_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Store Name</label>
                                    <br>
                                    <input class="form-control" name="store_name" id="store_name" type='text' value='' />
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
                                        src="https://w7.pngwing.com/pngs/527/625/png-transparent-scalable-graphics-computer-icons-upload-uploading-cdr-angle-text-thumbnail.png"
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
                                        src="https://w7.pngwing.com/pngs/527/625/png-transparent-scalable-graphics-computer-icons-upload-uploading-cdr-angle-text-thumbnail.png"
                                        class="" width="200" height="150" />
                                </div>

                            </div><br>
                            <div class="row g-3">
                                <div class="col">
                                    <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Store Sport</label>
                                    <br>
                                    <input class="form-control" name="store_sport" id="store_sport" type='text'
                                        value='' />
                                </div>
                                <div class="col">
                                    <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Store Description</label>
                                    <br>
                                    <input class="form-control" name="store_description" id="store_description" type='text'
                                        value='' />
                                </div>

                            </div>
                            <br><br>


                        <div>
                            <button style="float: right;" type="submit" class="btn btn-danger"
                                style="margin-top:10px">+ Add OMG Store</button>
                        </div>
                    </form>




                </div>
            </div>
            <br>
        </div>
    </div>



    </html>
    <script>

        let header = "OMG - Add Store";
            document.getElementById("header").innerHTML = header;

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

        // End
    </script>
@endsection
