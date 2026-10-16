<!doctype html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Encore Cloud</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/4e5c8d5a83.js" crossorigin="anonymous"></script>

        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/custom_css.css" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/timeline.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <!-- DataTables css -->
        <link rel="stylesheet" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ asset('argon') }}/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="{{ asset('argon') }}/css/colReorder.dataTables.min.css">

        <!--Datepicker-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <!--Timepicker-->
        <link rel="stylesheet" href="{{ asset('argon') }}/css/mdtimepicker.css">
        <script src="{{ asset('argon') }}/js/plugins/mdtimepicker.js"></script>

        <link rel="stylesheet" href="{{ asset('argon') }}/css/duDatepicker.css">
        <script src="{{ asset('argon') }}/js/plugins/duDatepicker.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/moment.js"></script>

        {{-- PDf Plugins --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/html2canvas.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/html2pdf.bundle.min.js"></script>

        {{-- Rich Text Editor --}}
        <link rel="stylesheet" href="{{ asset('argon') }}/css/editor.css" type="text/css" />
        <script src="{{ asset('argon') }}/js/plugins/editor.js"></script>

        {{-- JsZip --}}
        <script src="{{ asset('argon') }}/js/plugins/jszip.js" type="text/javascript"></script>

        <style>
            .card {
        border: none;
        box-shadow: none;
        /* width: 107%; */
        }

        .card-img-top {
        border-radius: 0;
        }

        .card-body {
        /* display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem; */
        }

        .heart-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        color: rgb(255, 0, 0);
        z-index: 1;
        background-color: transparent;
        border: none;
        cursor: pointer;
        }
        .card-title{
            /* width: 100%; */
            font-size: 17px;
            font-weight:600;
            color: black;
            /* position: relative;
            left: -5%; */
        }
        .filterbtn:hover {
        box-shadow: 0 6px 6px rgba(0, 0, 0, 0.2);
        }
        .filterbtn{
            box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.1);
        }

        /* checkbox */
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: red !important;
            border-color: red !important;
        }
        </style>
    </head>


    <body style="background-color: white;">
    {{-- navbar --}}

    <nav class="navbar row" style="background-color: black;">
        <div class="col-lg-4">
            <p style="color: white;font-size: 36px;font-weight: 600;position: relative;top: 6px;left: 20%;">Product Catalog</p>
        </div>
        <div class="col-lg-4" style="text-align: center; position: relative;top: -10%;">
            <a href="">
            <img src="https://encr.co/argon/img/encore/logo.png" alt="image" style="height: 90px;">
            </a>
        </div>
        <div class="row col-lg-4" style="position: relative;left: -1%;">
            <div class="col-lg-9 input-group-prepend" style="position: relative;left: 34%;">
                <span class="input-group-text" style="background-color: transparent; width: 12%;top: -15%;margin-right: 6px;left: 6px;border-left: unset;border-right: unset;border-top: unset;border-bottom: 1px solid grey;position: relative; border-radius: unset;">
                    <img src="{{ asset('assets/img/icons/catlog/search_1x.png') }}" alt="search">
                </span>
            <input type="text" class="form-control" id="exampleFormControlInput" placeholder="Search Products" style="background-color: transparent; width: 50%; border-left: unset; border-right: unset;border-top: unset;border-bottom: 1px solid grey;font-size: 16px; border-radius: unset;">
            </div>
        </div>
    </nav>

    <div class="container mt-6">
        <div class="row" style="width: 127%; position: relative;left: -18%;">
            <div class="row col-lg-3" style="position: relative;left: 1.8%; width: 23%;">
                <div class="col-lg-6">
                        <button class="filterbtn" type="button" id="filterButton_call" style="width: 100%; height: 50px; font-size: 15px; background-color:red; border: none; color: white; cursor: pointer;">
                            FILTER
                            <span id="badgeCount" class="translate-middle badge rounded-pill" style="background-color: rgb(255, 255, 255); color: red; position: relative;left: 6px;top: -6%;  border-radius: 2rem;height: 20px;">0</span>
                        </button>


                </div>
                <div class="col-lg-6">
                    <a href="{{ Request::url() }}">
                        <button class="filterbtn" style="width: 100%; height: 50px; font-size: 15px; background: none; cursor: pointer;">CLEAR FILTER</button>
                      </a>
                </div>
            </div>
            <div class="row col-lg-9" style="position: relative;left: 5%;">
                <div class="col-lg-2" style="border-left: 1px solid #c3c3c3;"></div>
                <div class="row col-lg-8" style="position: relative;left: -15%;top: 16%;" id="addlable">
                    {{-- <div class="col-lg-2" style="margin-right: 16px;">
                        <div style="background-color: #ccc; width: 150%; height:69%; border-radius: 1rem; padding: 10px; position: relative;">
                            <span style="position: relative;top: -48%;left: 6%;" id="addtext" >Outewear</span>
                            <span style="position: absolute; top: 16%; left: 82%; cursor: pointer;">
                                <i class="fas fa-times"></i>
                            </span>
                        </div>
                    </div> --}}
                </div>
                <div class="col-lg-2">
                    {{-- <i class="fa fa-angle-down fa-1x" style="color: black; position: relative; left: 9%;"></i> --}}
                <select name="selectedorder" id="selectedorder" style="border: none;font-size: 15px;font-weight: 700; position: relative;left: 102%;top: 19%;outline: unset;cursor: pointer;background: none;"  title="Select order">
                    <option value="0">SORT BY</option>
                    <option value="1">Ascending</option>
                    <option value="2">Descending</option>
                </select>
                </div>
            </div>
        </div>
        <div class="row" style="width: 128%; position: relative;top: 44px;left: -15.75%;">
            <div class="col-lg-3">
                <div class="card" style="width: 91%; border: 1px solid #c3c3c3; border-radius: unset; margin-bottom: 80px;">
                    <div style="color: grey;font-size: 15px;margin-top: 9%;margin-left: 10%;">FILTER BY:</div>
                    <div class="filters" style="border-bottom: 1px solid #c3c3c3;">
                        <div class="card-title mt-4" style="margin-left: 10% !important;color: black;font-size: 15px;font-weight: 700;">CATEGORY (<span id="categorycount">0</span>)<i class="fa fa-angle-down fa-1x" style="color: black; position: relative; left: 50%;"></i></div>
                        <div class="filter-fields">
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="category[]" class="custom-control-input" id="Training" value="Training">
                                <label class="custom-control-label ml-3 mt-2" for="Training" style="color: black;font-size: 16px;">Training</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="category[]" class="custom-control-input" id="Lifestyle" value="Lifestyle">
                                <label class="custom-control-label ml-3 mt-2" for="Lifestyle" style="color: black;font-size: 16px;">Lifestyle</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg mb-4" style="margin-left: 5%;">
                                <input type="checkbox" name="category[]" class="custom-control-input" id="Merch" value="Merch">
                                <label class="custom-control-label ml-3 mt-2" for="Merch" style="color: black;font-size: 16px;">Merch</label>
                            </div>
                        </div>
                    </div>
                    <div class="filters" style="    border-bottom: 1px solid #c3c3c3;">
                        <div class="card-title mt-4" style="margin-left: 10% !important;color: black;font-size: 15px;font-weight: 700;">GENDER (<span id="genderscount">0</span>)<i class="fa fa-angle-down fa-1x" style="color: black; position: relative; left: 50%;"></i></div>
                        <div class="filter-fields">
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="genders[]" class="custom-control-input" id="Men" value="Men">
                                <label class="custom-control-label ml-3 mt-2" for="Men" style="color: black;font-size: 16px;">Men</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="genders[]" class="custom-control-input" id="Women" value="Women">
                                <label class="custom-control-label ml-3 mt-2" for="Women" style="color: black;font-size: 16px;">Women</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg mb-4" style="margin-left: 5%;">
                                <input type="checkbox" name="genders[]" class="custom-control-input" id="Uni" value="Uni">
                                <label class="custom-control-label ml-3 mt-2" for="Uni" style="color: black;font-size: 16px;">Uni</label>
                            </div>
                        </div>
                    </div>
                    <div class="filters" style="    border-bottom: 1px solid #c3c3c3;">
                        <div class="card-title mt-4" style="margin-left: 10% !important;color: black;font-size: 15px;font-weight: 700;">SPORT (<span id="sportscount">0</span>)<i class="fa fa-angle-down fa-1x" style="color: black; position: relative; left: 50%;"></i></div>
                        <div class="filter-fields mb-4">
                            @foreach ($sports as $sport)
                                @if ($sport->sport_name !== 'Field Hockey' && $sport->sport_name !== 'Muay Thai' && $sport->sport_name !== 'Lifestyle' && $sport->sport_name !== 'Training')
                                <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                    <input type="checkbox" name="sports[]" class="custom-control-input" id="{{$sport->sport_name}}" value="{{$sport->sport_name}}">
                                    <label class="custom-control-label ml-3 mt-2" for="{{$sport->sport_name}}" style="color: black;font-size: 16px;">{{$sport->sport_name}}</label>
                                  </div>
                                @endif
                            @endforeach
                          </div>
                    </div>
                    <div class="filters" style="    border-bottom: 1px solid #c3c3c3;">
                        <div class="card-title mt-4" style="margin-left: 10% !important;color: black;font-size: 15px;font-weight: 700;">STYLE (<span id="stylecount">0</span>)<i class="fa fa-angle-down fa-1x" style="color: black; position: relative; left: 50%;"></i></div>
                        <div class="filter-fields mb-4">
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="style[]" class="custom-control-input" id='[["Tops"]]' value='[["Tops"]]'>
                                <label class="custom-control-label ml-3 mt-2" for='[["Tops"]]' style="color: black;font-size: 16px;">Tops</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="style[]" class="custom-control-input" id='[["Bottoms"]]'  value='[["Bottoms"]]'>
                                <label class="custom-control-label ml-3 mt-2" for='[["Bottoms"]]' style="color: black;font-size: 16px;">Bottoms</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="style[]" class="custom-control-input" id='[["Shorts"]]'  value='[["Shorts"]]'>
                                <label class="custom-control-label ml-3 mt-2" for='[["Shorts"]]' style="color: black;font-size: 16px;">Shorts</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="style[]" class="custom-control-input" id='[["Outerwear"]]' value='[["Outerwear"]]'>
                                <label class="custom-control-label ml-3 mt-2" for='[["Outerwear"]]' style="color: black;font-size: 16px;">Outewear</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="style[]" class="custom-control-input" id='[["Sweats"],["Tops"]]' value='[["Sweats"],["Tops"]]'>
                                <label class="custom-control-label ml-3 mt-2" for='[["Sweats"],["Tops"]]' style="color: black;font-size: 16px;">Hoodies & Fleece</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="style[]" class="custom-control-input" id='[["Bottoms"],["Sweats"]]' value='[["Bottoms"],["Sweats"]]'>
                                <label class="custom-control-label ml-3 mt-2" for='[["Bottoms"],["Sweats"]]' style="color: black;font-size: 16px;">Jogger & Sweats</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="style[]" class="custom-control-input" id='[["Socks"]]' value='[["Socks"]]'>
                                <label class="custom-control-label ml-3 mt-2" for='[["Socks"]]' style="color: black;font-size: 16px;">Socks</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="style[]" class="custom-control-input" id='[["Headwear"]]' value='[["Headwear"]]'>
                                <label class="custom-control-label ml-3 mt-2" for='[["Headwear"]]' style="color: black;font-size: 16px;">Hats</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg" style="margin-left: 5%;">
                                <input type="checkbox" name="style[]" class="custom-control-input"  id='Bras' value='Bras'>
                                <label class="custom-control-label ml-3 mt-2" for='Bras' style="color: black;font-size: 16px;">Bras</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-lg mb-4" style="margin-left: 5%;">
                                <input type="checkbox" name="style[]" class="custom-control-input" id='Compress' value='Compress'>
                                <label class="custom-control-label ml-3 mt-2" for='Compress' style="color: black;font-size: 16px;">Compression</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9" style="margin-bottom: 7%;">
                <div class="row container mb-5" style="width: 111%;position: relative;left: -2.2%;height: 1500px;">

                    <div class="row container mb-5" id="paste_container" style="width: 111%;">

                        {{-- products paste here --}}
                    {{-- <div class="col-md-3">
                        <a href="{{ route("product_view", ["id" => 5]) }}">
                            <div class="card ml-2" style="width: 106%;" data-toggle="modal" data-target="#productModal" data-product-name="" data-product-description="">
                                <img src="https://img.freepik.com/premium-photo/tshirt-design-tiger-wearing-small-sunglasses_717906-1480.jpg?w=2000" class="card-img-top" alt="Product Image">
                                <div class="card-body">
                                    <div class="row"><p class="card-title" style="font-family: revert; font-weight: 600;font-size: 19px;font-stretch: semi-condensed;">This is a test</p></div>
                                    <div class="row"><p style="color: rgb(0, 0, 0); font-size: 14px;position: relative;top: -19px;">PRO-5</p></div>
                                    <div class="row"><p style="color: grey; font-size: 14px;position: relative;top: -32px;"><i class="fas fa-light fa-tag" style="margin-right: 7px"></i>Customizable Product</p></div>
                                    <div class="row"><p  style="font-size: 23px;font-weight: 600;color: black;position: relative;top: -40px;">$60</p></div>

                                </div>
                            </div>
                        </a>
                    </div> --}}


                    </div>
                </div>

                <div>
                    <div id="paginationbar" class="row justify-content-center" style="width: 103%;">
                      {{-- pagination bar paste here --}}
                    </div>
                </div>

            </div>
        </div>
    </div>



{{-- footer --}}

    <footer class="col">
        <div class="row" style="background-color: #000000; color:white;">

            <div class="col-lg-5">
                <div class="m-5 " style="position: relative; top: 10%;">
                    <img src="https://encr.co/argon/img/encore/logo.png" alt="image" style="height: 80px;width: auto;position: relative;left: 13%;">
                </div>
            </div>
            <div class="row col-lg-7">
                <div class="col-lg-4">
                    <div style="position: relative; top: 37%;">
                        <div class="row">
                        <h4 style="color: white">SEND EMAIL</h4>
                        </div>
                        <div class="row">
                            <p style="color: #878787">info@encorecustom.com</p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div style="position: relative; top: 37%;">
                        <div class="row">
                        <h4 style="color: white">CALL US</h4>
                        </div>
                        <div class="row">
                            <p style="color: #878787;font-size: 27px;">+1 888-501-4999</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div style="position: relative; top: 37%;">
                        <div class="row">
                        <h4 style="color: white">VISIT US</h4>
                        </div>
                        <div class="row"><p style="color: #878787">891 4th St, San Rafael,</p></div>
                        <div class="row"><p style="color: #878787; position: relative;top: -17px;">CA 94901, USA</p></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row" style="background-color: rgb(20, 18, 18); color:white;  width: 102.65%;">
                <div class="row col-lg-12" style="margin-bottom: 29px">
                    <div class="col-lg-3">
                        <div><p style="position: relative;top: 40px;left: 26%; color:#878787; font-size:15px">© 2023 - Encore Custom. All Rights Reserved</p></div>
                    </div>
                    <div class="row col-lg-6">
                        <div class="col-lg-6"><div><p style="color: white;text-align: end;position: relative;left: 7%;top: 40px;">SUBSCRIBE OUR MAILING LIST</p></div></div>
                        <div class="col-lg-6">
                                <div class="col-md-6">
                                    <div class="form-group" style="width: 155%;position: relative;top: 37px;">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: transparent;border-left: unset;position: relative;top: -18%;border-right: unset;border-top: unset;border-bottom: 3px solid grey; border-radius: unset;">
                                            <img src="{{ asset('assets/img/icons/catlog/envelope_1x.png') }}" alt="envelope">
                                        </span>
                                        </div>
                                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Your Email Address" style="background-color: transparent; border-radius: unset; border-left: unset; border-right: unset;border-top: unset;border-bottom: 3px solid grey;font-size: 18px;">
                                    </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="row col-lg-3">
                        <div class="col" >
                        <a href="" class="me-4 text-reset">
                            <i class="fab fa-facebook-f fa-lg" style="color: white; position: relative;top: 37px;left: 177%;"></i>
                        </a>
                        </div>
                        <div class="col">
                        <a href="" class="me-4 text-reset">
                            <i class="fab fa-instagram fa-lg" style="color: white;position: relative;left: 83%;top: 37px;"></i>
                        </a>
                        </div>
                    </div>
                </div>
            </div>

    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var selectedStyles = [];
        var selectedCategories = [];
        var selectedGenders = [];
        var selectedSports = [];

        // Get selected style checkboxes
        $('input[name="style[]"]:checked').each(function() {
          selectedStyles.push($(this).val());
        });

        // Get selected category checkboxes
        $('input[name="category[]"]:checked').each(function() {
          selectedCategories.push($(this).val());
        });

        // Get selected gender checkboxes
        $('input[name="genders[]"]:checked').each(function() {
          selectedGenders.push($(this).val());
        });

        // Get selected sports checkboxes
        $('input[name="sports[]"]:checked').each(function() {
          selectedSports.push($(this).val());
        });

        // Send AJAX request to the controller
        $.ajax({
          url: "{{ route('product_filter') }}",
          method: "GET",
          data: {
            style: selectedStyles,
            category: selectedCategories,
            genders: selectedGenders,
            sports: selectedSports,
                },
          success: function(response) {
            //console.log(response.message);

            // Access the products data
            var products = response.products;
            //console.log(products);

            renderProducts(products);

          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error:", textStatus, errorThrown);
          }
        });

        //Canging the order
        $('#selectedorder').change(function() {
                $('#filterButton_call').trigger('click');
            });


            // {{-- After clicked filter button --}}


            $(document).ready(function() {
            // Event listener for the filter button click
            $('#filterButton_call').click(function() {
            // Initialize empty arrays
            var selectedStyles = [];
            var selectedCategories = [];
            var selectedGenders = [];
            var selectedSports = [];

            var selectedOrder;

        // Get selected style checkboxes
        $('input[name="style[]"]:checked').each(function() {
          selectedStyles.push($(this).val());
        });

        // Get selected category checkboxes
        $('input[name="category[]"]:checked').each(function() {
          selectedCategories.push($(this).val());
        });

        // Get selected gender checkboxes
        $('input[name="genders[]"]:checked').each(function() {
          selectedGenders.push($(this).val());
        });

        // Get selected sports checkboxes
        $('input[name="sports[]"]:checked').each(function() {
          selectedSports.push($(this).val());
        });

        $(document).ready(function() {
        selectedOrder = $('#selectedorder').val();
        // Call a separate function that relies on selectedOrder
        performAction(selectedOrder);
        });

        function performAction(selectedOrder) {
        // console.log(selectedOrder); // Use the selectedOrder variable here

        // Send AJAX request to the controller
        $.ajax({
          url: "{{ route('product_filter') }}",
          method: "GET",
          data: {
            style: selectedStyles,
            category: selectedCategories,
            genders: selectedGenders,
            sports: selectedSports,
          },
          success: function(response) {
            //console.log(response.message);

            // Access the products data and perform desired actions
            var products = response.products;
            //console.log(selectedOrder);

            if (selectedOrder == 2) {
            products.sort(function(a, b) {
                if (a.product_name < b.product_name) {
                return 1;
                } else if (a.product_name > b.product_name) {
                return -1;
                }
                return 0;
            });
            } else if (selectedOrder == 1) {
            products.sort(function(a, b) {
                if (a.product_name < b.product_name) {
                return -1;
                } else if (a.product_name > b.product_name) {
                return 1;
                }
                return 0;
            });
            }


            renderProducts(products);

          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error:", textStatus, errorThrown);
          }
        })};
        });
        });

        //commom functions

        $(document).ready(function() {
        $('#selectedorder').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue == 2) {
                console.log('Selected value:', selectedValue);
            } else {
                console.log(selectedValue);
            }
        });
        });



        function renderProducts(products){
            products=products;
            showProducts(products);
        }

        function showProducts(products) {
            $('#paste_container').empty();

            // Iterate over the fetched products and append them to the container
            $.each(products, function(index, product) {
                var imageURL = 'assets/img/products/product defaul image.jpg';

                //console.log(imageURL);

                if (product.mockup_img_1) {
                imageURL = product.mockup_img_1;
                //console.log(imageURL);
                }

                var id = product.id;
                var productUrl = "{{ route('product_view', ['id' => ':id']) }}";
                productUrl = productUrl.replace(':id', id);

                var productCard = '<div class="col-md-3">' +
                '<a href="' + productUrl + '">' +
                '<div class="card ml-2" style="width: 106%;" data-toggle="modal" data-target="#productModal" data-product-name="' + product.product_name + '" data-product-description="' + product.product_description + '">' +
                '<img src="' + imageURL + '" class="card-img-top" alt="Product Image">' +
                '<div class="card-body">' +
                '<div class="row"><p class="card-title" style="font-family: revert; font-weight: 600;font-size: 19px;font-stretch: semi-condensed;">' + product.product_name + '</p></div>' +
                '<div class="row"><p style="color: rgb(0, 0, 0); font-size: 14px;position: relative;top: -19px;">PRO-' + product.id + '</p></div>' +
                '<div class="row"><p style="color: grey; font-size: 14px;position: relative;top: -32px;"><img src="{{ asset("assets/img/icons/catlog/label_1x.png") }}" alt="label"></i>Customizable Product</p></div>' +
                '<div class="row"><p  style="font-size: 23px;font-weight: 600;color: black;position: relative;top: -40px;">$' + product.default_price + '</p></div>' +
                '</div></div></a></div>';

                $('#paste_container').append(productCard);
            });

            // Pagination
            var productsPerPage = 12;
            var totalPages = Math.ceil(products.length / productsPerPage);
            var maxPaginationLinks = 10;

            if (totalPages >= 1) {

                var currentPage = 1;
                var pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev">&laquo;</a></li>';

                if (totalPages <= maxPaginationLinks) {
                    for (var i = 1; i <= totalPages; i++) {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                    }
                } else {
                    var displayPaginationLinks = Math.min(maxPaginationLinks, totalPages);
                    var startPagination = 1;
                    var endPagination = displayPaginationLinks;

                    if (currentPage > Math.floor(maxPaginationLinks / 2)) {
                        startPagination = currentPage - Math.floor(maxPaginationLinks / 2);
                        endPagination = currentPage + Math.ceil(maxPaginationLinks / 2) - 1;

                        if (endPagination > totalPages) {
                            endPagination = totalPages;
                            startPagination = endPagination - maxPaginationLinks + 1;
                        }
                    }


                    for (var i = startPagination; i <= endPagination; i++) {
                        pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                    }
                }

                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next">&raquo;</a></li>';
                pagination += '</ul></nav>';

                $('#paginationbar').empty().append(pagination);

            // Show the initial page
            showPage(1, productsPerPage);

            // Pagination click event
            $('#paginationbar').on('click', '.page-link', function(e) {
                e.preventDefault();

                var page = $(this).data('page');

                if (page === 'prev') {
                currentPage = Math.max(1, currentPage - 1);
                } else if (page === 'next') {
                currentPage = Math.min(totalPages, currentPage + 1);
                } else {
                currentPage = page;
                }

                // Update pagination visibility
                var startPagination = 1;
                var endPagination = startPagination + maxPaginationLinks - 1;

                if (currentPage > maxPaginationLinks) {
                startPagination = currentPage - Math.floor(maxPaginationLinks / 2);
                endPagination = currentPage + Math.ceil(maxPaginationLinks / 2) - 1;
                }

                if (endPagination > totalPages) {
                endPagination = totalPages;
                startPagination = endPagination - maxPaginationLinks + 1;
                }

                if (startPagination < 1) {
                startPagination = 1;
                }

                pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev">&laquo;</a></li>';

                for (var i = startPagination; i <= endPagination; i++) {
                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                }

                pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next">&raquo;</a></li>';
                pagination += '</ul></nav>';

                $('#paginationbar').empty().append(pagination);

                showPage(currentPage, productsPerPage);
            });

            // Always show the previous and next link buttons
            $('#paginationbar .page-item:first-child').removeClass('d-none');
            $('#paginationbar .page-item:last-child').removeClass('d-none');
            }

            // Function to display products for the selected page
            function showPage(pageNum, productsPerPage) {
            var startIndex = (pageNum - 1) * productsPerPage;
            var endIndex = startIndex + productsPerPage;
            var products = $('#paste_container .col-md-3');

            products.hide();
            products.slice(startIndex, endIndex).show();

            // Update active page in pagination bar
            $('#paginationbar .page-item').removeClass('active');
            $('#paginationbar .page-link[data-page="' + pageNum + '"]').parent().addClass('active');
            }

        }




        // {{-- checkbox clicked count --}}


            // Get all the checkboxes
            const checkboxes = document.querySelectorAll('.custom-control-input');
            const badgeCount = document.getElementById('badgeCount'); // Get the badgeCount element

            // Add event listener to each checkbox
            checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const checkedCheckboxes = document.querySelectorAll('.custom-control-input:checked');
                badgeCount.innerText = checkedCheckboxes.length; // Update the badgeCount with the count of checked checkboxes
            });
            });


        // {{-- checkbox clicked count individually--}}

           updateCheckCount();
            function updateCheckCount(){
            const categoryCheckboxes = document.querySelectorAll('input[name="category[]"]');
            const genderCheckboxes = document.querySelectorAll('input[name="genders[]"]');
            const sportCheckboxes = document.querySelectorAll('input[name="sports[]"]');
            const styleCheckboxes = document.querySelectorAll('input[name="style[]"]');
            const categoryCount = document.getElementById('categorycount');
            const genderCount = document.getElementById('genderscount');
            const sportCount = document.getElementById('sportscount');
            const styleCount = document.getElementById('stylecount');

            // Function to update the count
            function updateCount(checkboxes, countElement) {
            let checkedCount = 0;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                checkedCount++;
                }
            });
            countElement.innerText = checkedCount;
            }

            // Add event listeners to each checkbox group
            categoryCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateCount(categoryCheckboxes, categoryCount);
            });
            });

            genderCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateCount(genderCheckboxes, genderCount);
            });
            });

            sportCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateCount(sportCheckboxes, sportCount);
            });
            });

            styleCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateCount(styleCheckboxes, styleCount);
            });
            });

            // Initial count updates
            updateCount(categoryCheckboxes, categoryCount);
            updateCount(genderCheckboxes, genderCount);
            updateCount(sportCheckboxes, sportCount);
            updateCount(styleCheckboxes, styleCount);
        }



        </script>



        <script>

        // {{-- search functions --}}

            $(document).ready(function() {
            // Bind keyup event to the search input field
            $('#exampleFormControlInput').keyup(function(event) {
                if (event.keyCode === 13) {
                // Enter key is pressed
                var searchValue = $(this).val();
                performSearch1(searchValue);
                }
            });

            // Bind blur event to the search input field (when user clicks outside the field)
            $('#exampleFormControlInput').blur(function() {
                var searchValue = $(this).val();
                performSearch1(searchValue);
            });

            // Function to perform the search
            function performSearch1(value) {
            // Do something with the search value
            console.log(value);

            // Send AJAX request to search route
            $.ajax({
                url: "{{ route('product_search') }}",
                method: "GET",
                data: {
                keyword: value,
                },
                success: function(response) {
                //console.log(response.message);

                // Access the search results and perform desired actions
                var products = response.products;
                //console.log(products);


                renderProducts(products);


                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
                }
            });
            }
            });

        </script>
        <script>
            const textArray = [];
            $(document).ready(function() {

              // Declare the textArray variable outside the event listener
              const closeArray = [];

              // Attach event listener to checkboxes
              $('input[type="checkbox"]').change(function() {

                document.getElementById("exampleFormControlInput").value = "";
                // Check if the checkbox is checked
                if ($(this).is(':checked')) {
                  // Get the value of the checked checkbox
                  const value = $(this).val();
                  let text;

                  // Check the value and assign the desired text
                  if (value === '[["Tops"]]') {
                    text = 'Tops';
                  } else if (value === '[["Bottoms"]]') {
                    text = 'Bottoms';
                  } else if (value === '[["Shorts"]]') {
                    text = 'Shorts';
                  } else if (value === '[["Outerwear"]]') {
                    text = 'Outerwear';
                  } else if (value === '[["Bottoms"],["Sweats"]]') {
                    text = 'Sweats';
                  } else if (value === '[["Headwear"]]') {
                    text = 'Hats';
                  } else if (value === '[["Sweats"],["Tops"]]') {
                    text = 'Hoodies';
                  } else if (value === '[["Socks"]]') {
                    text = 'Socks';
                  } else {
                    // Default text if no condition matches
                    text = value;
                  }

                  //console.log(text);

                  textArray.push('div_'+text);
                  closeArray.push(text);
                  //console.log(textArray);

                  printLables(textArray);


                }else{
                    document.getElementById("exampleFormControlInput").value = "";
                    const uncheckedValue = $(this).val();

                    var holder;

                    if (uncheckedValue === '[["Tops"]]') {
                    holder = 'Tops';
                  } else if (uncheckedValue === '[["Bottoms"]]') {
                    holder = 'Bottoms';
                  } else if (uncheckedValue === '[["Shorts"]]') {
                    holder = 'Shorts';
                  } else if (uncheckedValue === '[["Outerwear"]]') {
                    holder = 'Outerwear';
                  } else if (uncheckedValue === '[["Bottoms"],["Sweats"]]') {
                    holder = 'Sweats';
                  } else if (uncheckedValue === '[["Headwear"]]') {
                    holder = 'Hats';
                  } else if (uncheckedValue === '[["Sweats"],["Tops"]]') {
                    holder = 'Hoodies';
                  } else if (uncheckedValue === '[["Socks"]]') {
                    holder = 'Socks';
                  } else {
                    // Default text if no condition matches
                    holder = uncheckedValue;
                  }

                    var removeDivision='div_'+holder;

                    //console.log(holder);


                    //remove from front-end


                    if ($('#'+removeDivision).length > 0) {
                    // Remove the div and its content
                    $('#'+removeDivision).remove();
                    }

                    //updateCount();

                    // remove from array

                    const index = textArray.indexOf(removeDivision);
                    //console.log(textArray);
                    //console.log(index);
                    if (index > -1) {
                        textArray.splice(index, 1);
                    }
                    //console.log(textArray);

                    //console.log(textArray);
                    printLables(textArray);




                }
              });
            });

            function printLables(textArray) {

            const addLabelContainer = document.getElementById('addlable');
            const modifiedArray = textArray.map(item => item.replace('div_', ''));
            addLabelContainer.innerHTML = '';

            //console.log(modifiedArray);

            modifiedArray.forEach(text => {
            const newDiv = document.createElement('div');
            newDiv.id = `div_${text}`;
            newDiv.style.backgroundColor = '#ccc';
            newDiv.style.display = 'flex';
            newDiv.style.flexDirection = 'row';
            newDiv.style.alignItems = 'center';
            newDiv.style.borderRadius = '1rem';
            newDiv.style.margin = '5px';

            // Set the HTML content for the new div
            newDiv.innerHTML = `
                <span id="addtext" style="padding: 5%;">${text}</span>
                <span>
                    <button style="outline:unset; background-color:Transparent; border:none;">
                        <i class="fas fa-times" style="padding-right: 15px;" onclick="handleSpanClick('${text}')"></i>
                    </button>
                </span>
            `;

            // Append the new div to the addlabel container
            addLabelContainer.appendChild(newDiv);
            });
            }

            function handleSpanClick(closevalue) {
                //console.log(closevalue);

                  var tempory;

                  if (closevalue === 'Tops') {
                    tempory = '[["Tops"]]';
                  } else if (closevalue === 'Bottoms') {
                    tempory = '[["Bottoms"]]';
                  } else if (closevalue === 'Shorts') {
                    tempory = '[["Shorts"]]';
                  } else if (closevalue === 'Outerwear') {
                    tempory = '[["Outerwear"]]';
                  } else if (closevalue === 'Sweats') {
                    tempory = '[["Bottoms"],["Sweats"]]';
                  } else if (closevalue === 'Hats') {
                    tempory = '[["Headwear"]]';
                  } else if (closevalue === 'Hoodies') {
                    tempory = '[["Sweats"],["Tops"]]';
                  } else if (closevalue === 'Socks') {
                    tempory = '[["Socks"]]';
                  } else {
                    // Default text if no condition matches
                    tempory = closevalue;
                  }

                  //console.log(tempory);

                var closediv='div_'+closevalue;
                if ($('#'+closediv).length > 0) {
                    // Remove the div and its content
                    $('#'+closediv).remove();
                    }

                    const index = textArray.indexOf(closediv);
                    //console.log(textArray);
                    //console.log(index);
                    if (index > -1) {
                        textArray.splice(index, 1);
                    }
                    //console.log(textArray);

                const checkbox = document.getElementById(tempory);

                //console.log(checkbox);

                if (checkbox.checked) {
                    checkbox.checked = false;
                }
                const checkedCheckboxes = document.querySelectorAll('.custom-control-input:checked');
                badgeCount.innerText = checkedCheckboxes.length;
                updateCheckCount();
            }
          </script>




</body>

</html>
