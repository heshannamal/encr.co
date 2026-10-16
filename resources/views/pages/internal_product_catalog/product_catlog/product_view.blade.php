<!doctype html>
<html lang="en">

<head>
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
    </head>
    <style>
        .card {
    border: none;
    box-shadow: none;
    width: 107%;
    }

    .card-img-top {
    border-radius: 0;
    }

    .card-body {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
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
        width: 100%;
        font-size: 17px;
        font-weight:500;
        color: black;
        position: relative;
        left: -5%;
    }

    /* crousal thumbnail */
    .thumbnail {
    width: 80px;
    height: 80px;
    border-radius: unset;
    background: none;
    border: 1px solid transparent;
    }

    .thumbnail.active {
    width: 90px !important;
    height: 90px !important;
    position: relative !important;
    top: -5px !important;
    }


    /* clicked images */
    .image-container {
    position: relative;
    }

    .image-container input[type="radio"] {
    display: none;
    }

    .image-container img {
    cursor: pointer;
    }

    .image-container input[type="radio"]:checked + label {
    border: 3px solid black;
    }


    </style>


    <body style="background-color: white;">

    {{-- {{dd($lifestyleImages)}} --}}

    {{-- navbar --}}

    <nav class="navbar row" style="background-color: black; height: 125px;">
        <div class="col-lg-4"></div>
        <div class="col-lg-4" style="text-align: center; position: relative;top: -10%;">
            <a href="">
            <img src="https://encr.co/argon/img/encore/logo.png" alt="image" style="height: 90px;">
            </a>
        </div>
            <div class="row col-lg-4">
                <a href="#" id="cartDropdown" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left: 81%;">
                    <i class="fa fa-calculator fa-lg" style="color: white;"></i>
                    <span class="badge rounded-pill" id="quoteCountBadge" style="color: white; background-color: red; position: relative; top: -84%; left: 25%; border-radius: 3rem; width: 53%;">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cartDropdown" style="border-radius: 0rem;width: 75%;left: 8%;">
                    <div id="dropdown-menu-content" style="height: 400px; overflow-x: hidden; overflow-y: auto;">
                        {{-- Dropdown content --}}
                    </div>
                    <div class="col-lg-12">
                        <div class="row" style="margin-top: 6%;margin-bottom: 3%;color: black;">
                            <div class="col-lg-8">SUBTOTAL ($)</div>
                            <div class="col-lg-4" id="totalvalue" style="text-align: end;">0.00</div>
                        </div>
                        <div class="row" style="margin-bottom: 8%;margin-left: 0%;color: grey;">Taxes calculated at quote.</div>
                    </div>
                    <div class="row">
                        <button class="quotebtn" type="button" id="quoteButton_call" style="width: 60%; height: 50px; font-size: 15px; background-color:red; border: none; color: white; cursor: pointer; font-weight:600;margin-left: 20%;margin-bottom: 5%;" onclick="window.location.href='{{ route('product_quote') }}'">GENERATE INQUIRY ( <span id="generateQotecount">0</span> )</button>
                    </div>
                </div>

                <script>
                    document.addEventListener('click', function(event) {
                        const dropdownMenu = document.querySelector('.dropdown-menu');
                        const cartDropdown = document.getElementById('cartDropdown');

                        if (!dropdownMenu.contains(event.target) && !cartDropdown.contains(event.target)) {
                            dropdownMenu.classList.remove('show');
                        }
                    });
                </script>

            </div>

            {{-- <a href="{{ route('product_quote') }}" style="position: relative; left: 67%; top: 12px;">
                <i class="fa fa-calculator fa-lg" style="color: white;"></i>
                <span class="badge rounded-pill" id="quoteCountBadge" style="color: white; background-color: red; position: relative; top: -84%; left: 25%; border-radius: 3rem; width: 53%;">0</span>
            </a> --}}
    </nav>
    <div class="row ml-4 mr-4" style="margin-top: 4%;border-bottom: 3px solid #ededed; margin:2%">
        <div class="col-lg-6" style="margin-bottom: .5%;">
            <a href="{{route('product_catlog')}}">
                {{-- <button class="filterbtn" style="height: 50px; width: 100%; font-size: 15px; background: black; cursor: pointer;color:white; border-radius:.3rem">
                    BACK TO PRODUCTS
                </button> --}}
                <button style="font-size: 14px;font-weight: 700;background: none; outline:unset; border:none;cursor:pointer; margin-bottom:2%"><i class="fa fa-arrow-left" aria-hidden="true" style="margin: 10px;"></i>BACK TO PRODUCT CATALOG</button>
            </a>
        </div>
    </div>
    {{-- {{dd($product);}} --}}
    <div class="row">
            @php
                $mainCategoryId = $product->main_category_id;
                $mainCategory = $mainCategory->firstWhere('id', $mainCategoryId);
                $categoryName = $mainCategory ? $mainCategory->category_name : '';
            @endphp
                <p style="position: relative;left: 8%;margin-top: 3.5%; color: grey;">
             @if($categoryName)
                {{ $categoryName }} <i class="fas fa-angle-right" style="margin: 5px;"></i>
            @endif

            {{ $product->gender }}  <i class="fas fa-angle-right" style="margin: 5px;"></i>
            @if ($product->product_category_id == '[["Tops"]]')
                Tops
            @endif
            @if ($product->product_category_id == '[["Reversibles"]]')
                Reversibles
            @endif
            @if ($product->product_category_id == '[["Game Jerseys"]]')
                Game Jerseys
            @endif
            @if ($product->product_category_id == '[["Bottoms"],["Shorts"]]')
                Shorts
            @endif
            @if ($product->product_category_id == '[["Racerbacks"]]')
                Racerbacks
            @endif
            @if ($product->product_category_id == '[["Sweats"],["Tops"]]')
                Sweats
            @endif
            @if ($product->product_category_id == '[["Outerwear"]]')
                Outerwear
            @endif
            @if ($product->product_category_id == '[["Bottoms"],["Sweats"]]')
                Sweats
            @endif
            @if ($product->product_category_id == '[["Socks"]]')
                Socks
            @endif
            @if ($product->product_category_id == '[["Bags"]]')
                Bags
            @endif
            @if ($product->product_category_id == '[["Headwear"]]')
                Headwear
            @endif
            @if ($product->product_category_id == '[["Shorts"]]')
                Shorts

            @endif  <i class="fas fa-angle-right" style="margin: 5px;"></i>
            <span style="color: black; font-weight: 200;">{{ $product->product_name }}</span>
        </p>
    </div>
    @php
        // default images
        $imageUrl='assets/img/products/product defaul image.jpg';
    @endphp
    <div class="container mb-6">
        <div class="row">
            <div class="col-lg-4 " style="position: relative; top: 36px;left: -6.5%;">

                <div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel" style="width: 147%;">

                    {{-- Default crousel --}}

                <div id="crouselDefault">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{ $product->mockup_img_1 ? $product->mockup_img_1 : asset($imageUrl)}}" class="d-block w-100" style="width: 514px; height: 520px;" alt="Image 1">
                      </div>
                      @if ($product->mockup_img_2)
                        <div class="carousel-item">
                            <img src="{{ $product->mockup_img_2 }}" class="d-block w-100" style="width: 514px; height: 520px;" alt="Image 2">
                        </div>
                      @endif
                      @if ($product->mockup_img_3)
                        <div class="carousel-item">
                            <img src="{{ $product->mockup_img_3 }}" class="d-block w-100" style="width: 514px; height: 520px;" alt="Image 3">
                        </div>
                      @endif
                    </div>
                </div>

                    {{-- Lifestyle crousel --}}

                <div id="crouselLifestyle">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{ (count($lifestyleImages) > 0) ? $lifestyleImages[0] : asset($imageUrl)}}" class="d-block w-100" style="width: 514px; height: 520px;" alt="Image 1">
                      </div>
                        @if(count($lifestyleImages) > 1)
                            @foreach($lifestyleImages as $index => $productImage)
                                @if($index > 0)
                                    <div class="carousel-item">
                                        <img src="{{ $productImage }}" class="d-block w-100" style="width: 514px; height: 520px;" alt="Image {{$index+1}}">
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                    {{-- 3D crousel --}}

                <div id="crousel3D">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{ (count($Images3D) > 0) ? $Images3D[0] : asset($imageUrl)}}" class="d-block w-100" style="width: 514px; height: 520px;" alt="Image 1">
                      </div>
                        @if(count($Images3D) > 1)
                            @foreach($Images3D as $index => $Image3D)
                                @if($index > 0)
                                    <div class="carousel-item">
                                        <img src="{{ $Image3D }}" class="d-block w-100" style="width: 514px; height: 520px;" alt="Image {{$index+1}}">
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                    {{-- default thumbnails --}}

                <div id="defaultThumbnail">
                    <div class="carousel-thumbnails d-flex justify-content-center mt-2">
                        <img src="{{ $product->mockup_img_1 ? $product->mockup_img_1 : asset($imageUrl) }}" class="img-thumbnail mx-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="0" alt="Thumbnail 1" onclick="goToSlide(0)">
                        @if ($product->mockup_img_2)
                            <img src="{{ $product->mockup_img_2 }}" class="img-thumbnail mx-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="1" alt="Thumbnail 2" onclick="goToSlide(1)">
                        @endif

                        @if ($product->mockup_img_3)
                            <img src="{{ $product->mockup_img_3 }}" class="img-thumbnail mx-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="2" alt="Thumbnail 3" onclick="goToSlide(2)">
                        @endif

                    </div>
                </div>

                    {{-- lifestyle thumbnails --}}

                <div id="lifestyleThumbnail">
                    <div class="carousel-thumbnails d-flex justify-content-center mt-2">
                        <img src="{{ (count($lifestyleImages) > 0) ? $lifestyleImages[0] : asset($imageUrl) }}" class="img-thumbnail mx-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="0" alt="Thumbnail 1" onclick="goToSlide(0)">
                        @if(count($lifestyleImages) > 1)
                            @foreach($lifestyleImages as $index => $productImage)
                                @if($index > 0)
                                <img src="{{ $productImage}}" class="img-thumbnail mx-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="{{$index}}" alt="Thumbnail {{$index + 1}}" onclick="goToSlide({{$index}})">
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                    {{-- 3D thumbnails --}}

                <div id="3DThumbnail">
                    <div class="carousel-thumbnails d-flex justify-content-center mt-2">
                        <img src="{{ (count($Images3D) > 0) ? $Images3D[0] : asset($imageUrl) }}" class="img-thumbnail mx-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="0" alt="Thumbnail 1" onclick="goToSlide(0)">
                        @if(count($Images3D) > 1)
                            @foreach($Images3D as $index => $Image3D)
                                @if($index > 0)
                                <img src="{{ $Image3D}}" class="img-thumbnail mx-2 thumbnail" data-bs-target="#carouselExample" data-bs-slide-to="{{$index}}" alt="Thumbnail {{$index + 1}}" onclick="goToSlide({{$index}})">
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>


                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" style="background-color: transparent;border: none;">
                      <span class="carousel-control-prev-icon" aria-hidden="true" style="position: relative;top: -7%;"></span>
                      <span class="visually-hidden"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" style="background-color: transparent;border: none;">
                      <span class="carousel-control-next-icon" aria-hidden="true" style="position: relative;top: -7%;"></span>

                      <span class="visually-hidden"></span>
                    </button>
                  </div>

                  <script>
                    function goToSlide(slideIndex) {
                      var carousel = document.getElementById("carouselExample");
                      var carouselInstance = bootstrap.Carousel.getInstance(carousel);
                      carouselInstance.to(slideIndex);
                    }
                  </script>


                <div class="mt-6 mb-6">

                </div>
            </div>
            <div class="col-lg-8" style="position: relative;left: 5%;">
                <div class="row" style="position: relative;left: 22.5%;top: 5%;">
                    <p style="font-size: 27px;color: black;font-weight: 600;">{{ $product->product_name }}</p>
                </div>
                <div class="row"><p style="color: rgb(0, 0, 0); font-size: 15px;position: relative;top: 25px;left: 22%;">PRO-{{ $product->id }}</p></div>

                <div class="row mt-5"><p style="color: grey; font-size: 16px;position: relative;left: 22%;top: -21px;"><img src="{{ asset('assets/img/icons/catlog/label_1x.png') }}" alt="label">Customizable Product</p></div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="col-lg-6" style="position: relative;left: 61%;top: -2%;"><p style="font-size: 16px; color: black;font-weight: 700;">PRICE :</p></div>
                        <div class="col-lg-6" style="position: relative;left: 95%;top: -55%;"><p style="font-size: 35px; color: black; font-weight: 600;">${{ $product->default_price }}</p></div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">

                        <div class="col-lg-6" style="position: relative;left: 61%;top: -57%;"><p style="font-size: 16px; color: black;; font-weight: 700;">VIEW :</p></div>
                        <div class="col-lg-6" style="position: relative;left: 95%;top: -108%;">
                            <p id="imageText" style="font-size: 18px; color: black;"></p>
                        </div>

                    </div>
                </div>
                <div class="row">

                <div class="col" style="position: relative; left: 20%; top: -97px;">
                    <div class="image-container">
                            <input type="radio" name="image1" id="image1" class="image-radio">
                        <label for="3D" id="3DLable" onclick="clickImage('3D')">
                            <img src="{{ (count($Images3D) > 0) ? $Images3D[0] : asset($imageUrl) }}" class="img-thumbnail mx-2" style="width: 80px; height: 80px;">
                        </label>
                        <p style="color: grey;font-size: 14px;margin-left: 7%;">3D Image</p>
                    </div>
                </div>
                <div class="col" style="position: relative; left: -16%; top: -97px;">
                    <div class="image-container">
                        <input type="radio" name="image2" id="image2" class="image-radio">
                        <label for="lifestyle" id="lifestyleLable" onclick="clickImage('lifestyle')">
                            <img src="{{ (count($lifestyleImages) > 0) ? $lifestyleImages[0] : asset($imageUrl) }}" class="img-thumbnail mx-2" style="width: 80px; height: 80px;">
                        </label>
                        <p style="color: grey;font-size: 14px;margin-left: 3%;">Lifestyle Img</p>
                    </div>
                </div>
                <div class="col" hidden>
                  <div class="image-container">
                    <input type="radio" name="image" id="image3" class="image-radio" checked>
                    <p style="color: grey;font-size: 14px;margin-left: 7%;">Default</p>
                  </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="col-lg-10" style="position: relative;left: 61%;top: -204%;"><p style="font-size: 16px; color: black; font-weight: 700;">AVAILABLE SIZES :</p></div>
                        <div class="col-lg-2" style="position: relative;left: 95%;top: -66%;"></div>
                    </div>
                </div>
                <div class="row" style="position: relative;left: 23%;top: -15%;">
                    @php
                        $sizetypeid = $product->size_id;
                        $sizeNames = $size->where('size_type', $sizetypeid)->pluck('size_name')->toArray();
                    @endphp

                    @foreach($sizeNames as $sizeNames)
                    <div style="border-left: 2px solid black;text-align: center;margin-top: 10px;">
                        <span style="font-size: 15px;color: black;font-weight: 500;margin: 10px;">{{ $sizeNames }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="row" style="position: relative;top: -12%;">
                    <div class="col" style="left: 20%;font-size: 14px;color: black;"><i class="fa fa-bar-chart" style="margin-right: 7px"></i></div>
                    <div class="col" style="left: -27%;"><p style="color: black;font-size: 13px;font-weight: 600;">SIZE GUIDE</p></div>
                </div>
                <div class="row">
                    <div class="col" style="position: relative;left: 20%;top: -64px;">
                        <button class="quotebtn" type="button" id="filterButton_call" style="width: 39%; height: 50px; font-size: 15px; background-color:red; border: none; color: white; cursor: pointer; font-weight:600" onclick="toggleQuote({{ $product->id }})">ADD TO INQUIRY</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="width: 120%;">
            <div class="col-lg-12"  style="position: relative;left: -5%; border-bottom: 1px solid #cdcdcd;">
                <div class="row" style="color: black;font-size: 15px;font-weight: 600;"><p>DESCRIPTION</p></div>
                <div>{!! $product->description !!}</div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <p style="color: black;font-size: 22px;font-weight: 600;margin-bottom: 31px; position: relative;left: 4%;">You May Also Like</p>
        </div>

        <div class="row" style="position: relative;left: 3%;">
            <div class="row container mb-5">
                <div class="row">
                    @foreach ($randomProducts  as $randomProduct)
                    <div class="col-lg-3">
                        <a href="{{ route('product_view', ['id' => $randomProduct->id]) }}">
                            <div class="card ml-2" data-toggle="modal" data-target="#productModal" data-product-name="{{ $randomProduct->product_name }}" data-product-description="{{ $randomProduct->product_description }}">
                                <img src="{{ $randomProduct->mockup_img_1 ? $randomProduct->mockup_img_1 : asset($imageUrl) }}" class="card-img-top" style="height: 274px; width: 272px;" alt="Product Image">
                                <div class="card-body row">
                                    <div class="col-lg-12"><p class="card-title" style="font-family: revert; font-weight: 600;font-size: 19px;font-stretch: semi-condensed;">{{ $randomProduct->product_name }}</p></div>
                                    <div class="col-lg-12" style="position: relative;top: -15px;left: -4%;"><p style="color: rgb(0, 0, 0); font-size: 14px;">PRO-{{ $randomProduct->id }}</p></div>
                                    <div class="col-lg-12" style="position: relative;top: -18px;left: -4%;"><p style="color: grey; font-size: 14px;"><i class="fas fa-light fa-tag" style="margin-right: 7px"></i>Customizable Product</p></div>
                                    <div class="col-lg-12" style="position: relative;top: -19px;left: -4%;"><p  style="font-size: 23px;font-weight: 600;color: black;">${{ $randomProduct->default_price }}</p></div>
                                </div>
                            </div>
                        </a>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
  {{-- footer --}}

  <footer class="col">
    <div class="row" style="background-color: #000000; height:230px; color:white; width: 102.65%;">

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
    <div class="row" style="background-color: rgb(20, 18, 18);height:100px; color:white;  width: 102.65%;">
            <div class="row col-lg-12">
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
                                    <span class="input-group-text" style="background-color: transparent;border-left: unset;border-right: unset;border-top: unset;border-bottom: 3px solid grey; border-radius: unset;position: relative;top: -18%;">
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

<input type="hidden" id="productId" value="{{ $product->id }}">
<input type="hidden" id="userId" value="{{$token}}">

    <script>
        $(document).ready(function() {
            // Click event for the cart icon
            $('#cartDropdown').click(function(e) {
                e.preventDefault();

                // Toggle the dropdown menu
                $(this).next('.dropdown-menu').toggleClass('show');
            });
        });
    </script>


    <script>
        buttontext();
        function buttontext() {

            findQuotesCount();
            var userId = document.getElementById('userId').value;
            console.log(userId);
            var productId = $('#productId').val();
            //console.log(userId);
            //console.log(productId);

            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('buttontext') }}",
            method: "GET",
            data: {
                user_id: userId,
                product_id: productId,
                    },
            success: function(response) {

                var button = document.getElementById('filterButton_call');

                if(response.message_exist){
                    //console.log(response.message_exist);
                    button.innerText = 'REMOVE FROM INQUIRY';
                }else{
                    button.innerText = 'ADD TO INQUIRY';
                };

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
        }

        function toggleQuote(productId) {
            var button = document.getElementById('filterButton_call');

            if (button.innerText === 'ADD TO INQUIRY') {

                addToQuote(productId); // Call your add_to_quote function

            }
            if(button.innerText === 'REMOVE FROM INQUIRY') {

                removeFromQuote(productId); // Call your remove_from_quote function
            }
        }

        function addToQuote(productId) {
            var userId = document.getElementById('userId').value;
            //console.log(userId);
            //console.log(productId);

            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('product_addto_quotes') }}",
            method: "GET",
            data: {
                user_id: userId,
                product_id: productId,
                    },
            success: function(response) {

                var button = document.getElementById('filterButton_call');

                if(response.message_success){
                    console.log(response.message_success);
                    button.innerText = 'REMOVE FROM INQUIRY';
                };
                if(response.message_exist){
                    console.log(response.message_exist);
                };
                findQuotesCount();
                view_user_quotes();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
        }

        function removeFromQuote(productId) {

            var userId = document.getElementById('userId').value;

            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('product_removefrom_quotes') }}",
            method: "GET",
            data: {
                user_id: userId,
                product_id: productId,
                    },
            success: function(response) {

                var button = document.getElementById('filterButton_call');

                findQuotesCount();
                view_user_quotes();

                if(response.message_notfound){
                    console.log(response.message_notfound);
                };

                if(response.message_remove){
                    console.log(response.message_remove);
                    button.innerText = 'ADD TO INQUIRY';
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
        }

        view_user_quotes();

        function view_user_quotes() {

            var userId = document.getElementById('userId').value;

            var subtotal=0;

            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('view_user_quotes') }}",
            method: "GET",
            data: {
                user_id: userId,
                    },
            success: function(response) {

                //console.log(response.quotes)

                //console.log(response.products)

                var item = response.products;

                var cartItemsHtml = '';

            // Iterate over each cart item and generate the HTML
            item.forEach(function(item) {

                var imageURL = 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg?20200913095930';

                //console.log(imageURL);

                if (item.mockup_img_1) {
                imageURL = item.mockup_img_1;
                //console.log(imageURL);
                }

                subtotal = parseInt(subtotal) + parseInt(item.default_price);
                //console.log(subtotal);

                cartItemsHtml += '<div class="row">' +
                '<div class="col-lg-3">' +
                '<img src="' + imageURL+ '" alt="Item Image" style="height: 80px; width: 80px;margin: 15%;">' +
                '</div>' +
                '<div class="col-lg-7" style="margin-top: 3%">' +
                '<span style="color: grey;font-size: 16px;display: table-row;">' + item.product_name + '</span>' +
                '<span style="color: black;padding: 1%;font-size: 15px;">$ ' + item.default_price + '</span>' +
                '</div>' +
                '<div class="col-lg-2">' +
                '<button style="background: none;border: none;outline: unset;cursor: pointer;position: relative;top: 8%;"><i class="fa fa-trash" aria-hidden="true" style="color: black;" onclick="deleteRecord('+item.id+')"></i></button>' +
                '</div>' +
                '</div>' +
                '<div class="dropdown-divider"></div>';
            });



            $('#totalvalue').text(subtotal+'.00');

            // Update the HTML of the cart items section
            $('#dropdown-menu-content').html(cartItemsHtml);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
        }

        function findQuotesCount() {

        var userId = document.getElementById('userId').value;

        // Send an AJAX request to the server
        $.ajax({
        url: "{{ route('count_records') }}",
        method: "GET",
        data: {
            user_id: userId,
                },
        success: function(response) {

            var count = response.count;
            //console.log(count);
            $('#quoteCountBadge').text(count);

            var generateQuoteCount = document.querySelector("#generateQotecount");

            //console.log(generateQuoteCount);

            generateQuoteCount.textContent = count;

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error:", textStatus, errorThrown);
        }
        });
        }
    </script>
    <script>
            // Image selecting functions

            var carousel_Default = document.getElementById('crouselDefault');
            var thumbnail_Default = document.getElementById('defaultThumbnail');
            var carousel_Lifestyle = document.getElementById('crouselLifestyle');
            var thumbnail_Lifestyle = document.getElementById('lifestyleThumbnail');
            var carousel_3D = document.getElementById('crousel3D');
            var thumbnail_3D = document.getElementById('3DThumbnail');
            var imageTextElement = document.getElementById('imageText');
            var carousel_DefaultContent = carousel_Default.innerHTML;
            var thumbnail_DefaultContent = thumbnail_Default.innerHTML;
            var carousel_LifestyleContent = carousel_Lifestyle.innerHTML;
            var thumbnail_LifestyleContent = thumbnail_Lifestyle.innerHTML;
            var carousel_3DContent = carousel_3D.innerHTML;
            var thumbnail_3DContent = thumbnail_3D.innerHTML;
            var contentArray = [];
            var clickedImage = 'default';

            contentArray.push(carousel_DefaultContent, thumbnail_DefaultContent, carousel_LifestyleContent, thumbnail_LifestyleContent, carousel_3DContent, thumbnail_3DContent);

            clickImage('default');

            function clickImage(clickedInputImage){

                var clickedInputImage = clickedInputImage;

                if( clickedImage == clickedInputImage){
                    clickedImage = 'default';
                }else{
                    clickedImage = clickedInputImage;
                }

            if(clickedImage == 'lifestyle'){
                //console.log(contentArray);
                carousel_Default.innerHTML = '';
                thumbnail_Default.innerHTML = '';
                carousel_3D.innerHTML = '';
                thumbnail_3D.innerHTML = '';

                carousel_Lifestyle.innerHTML = contentArray[2];
                thumbnail_Lifestyle.innerHTML = contentArray[3];
                imageTextElement.textContent = 'Lifestyle';
                document.getElementById('3DLable').style.border = 'none';
                document.getElementById('lifestyleLable').style.border = '3px solid black';
            }
            if(clickedImage == 'default'){
                //console.log(contentArray);
                    carousel_Lifestyle.innerHTML = '';
                    thumbnail_Lifestyle.innerHTML = '';
                    carousel_3D.innerHTML = '';
                    thumbnail_3D.innerHTML = '';

                    carousel_Default.innerHTML = contentArray[0];
                    thumbnail_Default.innerHTML = contentArray[1];
                    imageTextElement.textContent = 'Default';
                    document.getElementById('lifestyleLable').style.border = 'none';
                    document.getElementById('3DLable').style.border = 'none';
            }
            if(clickedImage == '3D'){
                //console.log(contentArray);
                    carousel_Lifestyle.innerHTML = '';
                    thumbnail_Lifestyle.innerHTML = '';
                    carousel_Default.innerHTML = '';
                    thumbnail_Default.innerHTML = '';

                    carousel_3D.innerHTML = contentArray[4];
                    thumbnail_3D.innerHTML = contentArray[5];
                    imageTextElement.textContent = '3D image';
                    document.getElementById('lifestyleLable').style.border = 'none';
                    document.getElementById('3DLable').style.border = '3px solid black';
            }

            }
    </script>
    <script>
        function goToSlide(slideIndex) {
        $('.thumbnail').removeClass('active');
        $('.thumbnail').eq(slideIndex).addClass('active');
        $('#carouselExample').carousel(slideIndex);
        }

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function deleteRecord(itemId) {
                var itemId = itemId;
                Swal.fire({
                    title: 'Delete Confirmation',
                    text: 'Do you want to delete this record?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //console.log(itemId);
                        removeFromQuote(itemId);
                    }
                });
            }
    </script>


</body>

</html>
