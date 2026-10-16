@extends('layouts.app', ['activePage' => 'omg_store_profile', 'titlePage' => __('OMG Store & Profile')])
<style>
    #select2-data-7-tsnb {
        width: 100% !important;
    }

    #product_sizes_id {
        height: 160px !important;
    }

    #product_sizes_id+.select2.select2-container {
        min-height: 80px !important;
    }
    .outline-border {
        border-radius: 5px !important;
        border: 1px #e4e4e4b8 solid !important;
    }
    .select2.select2-container.select2-container--default {
       border-radius: 5px !important;
        border: 1px #e4e4e4b8 solid !important;
    }

</style>
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

            @section('order-header')
                <span>OMG - Add Store Products</span>
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
            <div class="card">
                {{-- <div class="card-header">
                    <div class="card-header-danger col-md-12">
                        <div class="col-md-5 float-left header-details">
                            <h4 class="mb-0">
                                <span class="d-block details-name">OMG - Add Store Products</span>
                            </h4>
                        </div>
                    </div>

                </div> --}}

                <div class="card-body">

                    <br>
                    <form method="post" action="{{ url('addOrganizationStoreProduct') }}" enctype="multipart/form-data">
                        @csrf
                        <h3>{{ $OrganizationStores[0]->organizationDetails['organization_name'] ." - ". $OrganizationStores[0]->store_name ." - Add Product" }}</h3>
                        <br>
                        <input type="text" value="{{ $OrganizationStores[0]->id }}" hidden
                                name="organizatinalStoreId" />
                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Select Product Gender
                                    Category</label>
                                <br>
                                <select class="invoice-inputs select2-edit-order outline-border " name="product_gender_category"
                                    id="product_gender_category" required>
                                    <option value="">Select a Product Gender Category</option>
                                    @foreach ($productsGenders as $productsGender)
                                        <option value="{{ $productsGender->gender }}">{{ $productsGender->gender }}
                                        </option>
                                    @endforeach
                                </select>


                            </div>
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Select Product</label>
                                <br>
                                <select class="invoice-inputs select2-edit-order" name="product_id" id="product_id"
                                    required>
                                    <option value="">Select a product</option>
                                </select>
                            </div>

                        </div><br>
                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Product SKU</label>
                                <br>
                                <input class="form-control" name="product_sku" id="product_sku" type='text' value='' />
                            </div>
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Select Status</label>
                                <br>
                                <select class="invoice-inputs select2-edit-order" name="product_status"
                                    id="product_status" required>
                                    <option value="1">In Stock</option>
                                    <option value="0">Out of Stock</option>
                                </select>
                            </div>

                        </div><br>
                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Price</label>
                                <br>
                                <input class="form-control" name="product_price" id="product_price" type='text' value='' />
                            </div>
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Discount</label>
                                <br>
                                <input class="form-control" name="product_discount" id="product_discount" type='text' value='' />
                            </div>

                        </div><br>
                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Qty</label>
                                <br>
                                <input class="form-control" name="product_qty" id="product_qty" type='text' value='' />
                            </div>
                            <div class="col">

                            </div>

                        </div><br>
                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Short
                                    Descrioption</label>
                                <br>
                                <textarea name="product_short_description" class="form-control" style="width: 100%;"></textarea>
                            </div>
                        </div><br>
                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Prodct Sizes</label>
                                <br>
                                <select class="invoice-inputs select2-edit-order" id="product_sizes_id"
                                    name="product_sizes_id[]" multiple="multiple" required>

                                    @foreach ($productSizes as $productSize)
                                        <option value="{{ $productSize->id }}">{{ $productSize->size_name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Picture 01
                                </label>
                                <br>
                                <input type="file" name="pic_one" id="pic_one" onchange="profilePreview(this);"
                                    class="form-control" style="width: 222px;">
                                <br>
                                <label for="cover_image"></label>
                                <img id="preview_img1"
                                    src="https://w7.pngwing.com/pngs/527/625/png-transparent-scalable-graphics-computer-icons-upload-uploading-cdr-angle-text-thumbnail.png"
                                    class="" width="210" height="150" /><br>
                            </div>

                        </div><br>

                        <div class="row g-3">
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Picture 02
                                </label>
                                <br>
                                <input type="file" name="pic_two" id="pic_two" onchange="profilePreview1(this);"
                                    class="form-control" style="width: 222px;">
                                <br>
                                <label for="cover_image1"></label>
                                <img id="preview_img2"
                                    src="https://w7.pngwing.com/pngs/527/625/png-transparent-scalable-graphics-computer-icons-upload-uploading-cdr-angle-text-thumbnail.png"
                                    class="" width="210" height="150" /><br>
                            </div>
                            <div class="col">
                                <label style="font-size: 15px;font-weight: 600;margin-bottom: 13px;">Picture 03
                                </label>
                                <br>
                                <input type="file" name="pic_three" id="pic_three" onchange="profilePreview2(this);"
                                    class="form-control" style="width: 222px;">
                                <br>
                                <label for="cover_image2"></label>
                                <img id="preview_img3"
                                    src="https://w7.pngwing.com/pngs/527/625/png-transparent-scalable-graphics-computer-icons-upload-uploading-cdr-angle-text-thumbnail.png"
                                    class="" width="210" height="150" />
                            </div>

                        </div><br>
                        <div style="text-align-last: end;"><button type="submit" class="btn btn-secondary">Save</button></div>
                    </form>

                </div>
            </div>
            <br>
        </div>
    </div>



    </html>
    <script>
        $(document).ready(function() {
            $('select').select2();
        });

        $("#product_gender_category").on('change', function() {
            $.ajax({
                url: "{{ url('organization/store/getproductnames') }}",
                type: "POST",
                data: {
                    'genderCategorySelected': this.value,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data);
                    $("#product_id").html(data);
                },
                complete: function() {

                }
            });
        });




        // front picture
    function profilePreview(input, id) {
    id = id || '#preview_img1';
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(id)
                    .attr('src', e.target.result)
                    .width(200)
                    .height(150);
        };

        reader.readAsDataURL(input.files[0]);
    }
 }
//  end

    // left side picture
    function profilePreview1(input, id) {
    id = id || '#preview_img2';
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(id)
                    .attr('src', e.target.result)
                    .width(200)
                    .height(150);
        };

        reader.readAsDataURL(input.files[0]);
    }
 }
//  end

    // right side picture
    function profilePreview2(input, id) {
    id = id || '#preview_img3';
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
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
