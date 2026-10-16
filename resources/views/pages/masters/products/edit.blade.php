<style>
    .multy-selection {
        width: 248px !important;
    }
    .multy-box {
        height: 60px;
    }
</style>

<div class="modal fade" id="product_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Products</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('products.update') }}" method="post" enctype="multipart/form-data">
                
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <input type="hidden" value="" id="product_id" name="product_id" />

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Product Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="edit_product_name" name="edit_product_name" value="" required>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Product No: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="edit_product_no" name="edit_product_no" value="" readonly>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Pattern Code: </label>
                                <input type="text" class="form-control form-input" id="edit_pattern_code" name="edit_pattern_code">
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Sport: <span class="text-danger">*</span></label>
                                <select class="form-control form-input select2-edit" id="edit_sport" name="edit_sport" required>
                                    <option value="">Select a Sport</option>
                                    <option value="All">ALL</option>
                                    @foreach ($sports as $sport)
                                        <option value="{{$sport->sport_name}}">{{$sport->sport_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Gender: <span class="text-danger">*</span></label>
                                <select class="form-control form-input select2-edit" id="edit_gender" name="edit_gender" required>
                                    <option value="">Select a Gender</option>
                                    <option value="Men">Men's</option>
                                    <option value="Women">Women's</option>
                                    <option value="Uni">Uni</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Default Price ($): <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-input" id="edit_default_price" name="edit_default_price" step="0.01" required>
                            </div>

                            <div class="col-md-6 form-field ">
                                <label class="form-lable">Product Category: <span class="text-danger">*</span></label>
                                <select class="form-control form-input multy-selection" id="edit_product_category_id" name="edit_product_category_id[]" multiple="multiple" required>
                                    @foreach ($productCategories as $productCategory)
                                        <option value="{{$productCategory->id}}">{{$productCategory->product_category_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Product Sizes: <span class="text-danger">*</span></label>
                                <select class="form-control form-input select2-edit" id="edit_size_id" name="edit_size_id" required>
                                    <option value="">Select a Size</option>
                                    <option value="1">YS-XXL</option>
                                    <option value="2">Sock</option>
                                    <option value="3">N/A</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Standard Fabric:</label>
                                <select class="form-control form-input select2-edit" id="edit_standard_fabric_id" name="edit_standard_fabric_id">
                                    <option value="">Select a Fabric</option>
                                    @foreach ($fabrics as $fabric)
                                        <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Fabric Options:</label>
                                <select class="form-control form-input multy-selection" id="edit_fabric_id" name="edit_fabric_id[]" multiple="multiple">
                                    @foreach ($fabrics as $fabric)
                                        <option value="{{$fabric->id}}">{{$fabric->fabric_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Embellishment Options:</label>
                                <select class="form-control form-input multy-selection" id="edit_embellishment_type_id" name="edit_embellishment_type_id[]" multiple="multiple">
                                    @foreach ($embellishmentTypes as $embellishmentType)
                                        <option value="{{$embellishmentType->id}}">{{$embellishmentType->embellishment_name}} @if ($embellishmentType->price != 0) {{'(+$'.$embellishmentType->price.')'}} @endif</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Attributes:</label>
                                <select class="form-control form-input multy-selection" id="edit_product_attribute_id" name="edit_product_attribute_id[]" multiple="multiple">
                                    @foreach ($productAttributes as $productAttribute)
                                        <option value="{{$productAttribute->id}}">{{$productAttribute->attribute_name}} @if ($productAttribute->price != 0) {{'(+$'.$productAttribute->price.')'}} @endif</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Weight (oz):</label>
                                <input type="number" class="form-control form-input" id="edit_weight" name="edit_weight"/>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Factories:</label>
                                <select class="form-control form-input multy-selection" id="edit_product_factory_id" name="edit_product_factory_id[]" multiple="multiple">
                                    @foreach ($factories as $factory)
                                        <option value="{{$factory->id}}">{{$factory->factory_code}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Description:</label>
                                <textarea class="form-control form-input" id="edit_description" name="edit_description" rows="3"></textarea>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Notes:</label>
                                <textarea class="form-control form-input" id="edit_notes" name="edit_notes" rows="3"></textarea>
                            </div>

                            <div class="col-md-6 form-field">
                                <label class="form-lable">Status:</label>
                                <div id="form_status_div" style="display: flex; flex-direction: row; align-items: center;">

                                </div>
                            </div>

                            <hr style="height: 2px; width:100%;">

                            <div class="col-md-12 form-field">
                                <label class="form-lable" style="font-weight: bold">Mockup templates and mockup images</label>
                            </div>

                            <div class="row" style="width: 100%;margin-left: 15px;">
                                <div class="col-md-4">
                                    <div class="row" style="margin-bottom: 10px;">
                                        <label class="form-lable"  style="width: 100%">Mockup Image 1 :</label>
                                    </div>
                                    <div class="row">
                                        <input type="file" id="edit_mockup_img_1" name="edit_mockup_img_1" onchange="edit_uploadFile(1)" style="width: 100%" class="form-lable"/><br/>
                                    </div>
                                    <br/>
                                    <div class="row" style="align-content: center">
                                        <img id="edit_preview_mockup_img_1" style="height: 100px; width: 100px;border-color: black;"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="row" style="margin-bottom: 10px;">
                                        <label class="form-lable"  style="width: 100%">Mockup Image 2 :</label>
                                    </div>
                                    <div class="row">
                                        <input type="file" id="edit_mockup_img_2" name="edit_mockup_img_2" onchange="edit_uploadFile(2)" style="width: 100%" class="form-lable"/>
                                    </div>
                                    <br/>
                                    <div class="row" style="align-content: center">
                                        <img id="edit_preview_mockup_img_2" style="height: 100px; width: 100px;border-color: black;"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="row" style="margin-bottom: 10px;">
                                        <label class="form-lable"  style="width: 100%">Mockup Image 3 :</label>
                                    </div>
                                    <div class="row">
                                        <input type="file" id="edit_mockup_img_3" name="edit_mockup_img_3" onchange="edit_uploadFile(3)" style="width: 90%" class="form-lable"/>
                                    </div>
                                    <br/>
                                    <div class="row" style="align-content: center">
                                        <img id="edit_preview_mockup_img_3" style="height: 100px; width: 100px;border-color: black;"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @can('productedit')
                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @can('delete products')
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endcan
                        @can('edit products')
                        <button type="submit" class="btn btn-success btn-custom">Update</button>
                        @endcan
                    </div>
                </div>
                @endcan
            </form>
        </div>
    </div>
</div>

<script>
    $('#product_edit_modal').on('shown.bs.modal', function (e) {
        var productId = $('#product_id').val();

        $.ajax({
            url: '{{url("products/edit")}}/'+productId,
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data){
                var product = data[0];
                var productFabric = data[1];
                var productEmbellishmentType = data[2];
                var productCategory =  data[3];
                var productAttributes =  data[4];
                var productFactories =  data[5];

                // var productCategory = JSON.parse(product.product_category_id);
                $('#edit_product_name').val(product.product_name);
                $('#edit_product_no').val(product.product_no);
                $('#edit_pattern_code').val(product.pattern_code);
                $('#edit_sport').val(product.sport).change();
                $('#edit_gender').val(product.gender).change();
                $('#edit_default_price').val(product.default_price);
                $('#edit_product_category_id').val(productCategory).trigger('change');
                $('#edit_size_id').val(product.size_id).change();
                $('#edit_standard_fabric_id').val(product.fabric_id).change();
                $('#edit_fabric_id').val(productFabric).trigger('change');
                $('#edit_embellishment_type_id').val(productEmbellishmentType).trigger('change');
                $('#edit_product_attribute_id').val(productAttributes).trigger('change');
                $('#edit_weight').val(product.weight);
                $('#edit_product_factory_id').val(productFactories).trigger('change');
                $('#edit_description').val(product.description);
                $('#edit_notes').val(product.notes);

                if(product.mockup_img_1 != "" && product.mockup_img_1 != null){
                    $("#edit_preview_mockup_img_1").attr("src", "uploads/products/"+productId+"/"+product.mockup_img_1);
                }else{
                    $("#edit_preview_mockup_img_1").attr("src", "uploads/default_img.jpg");
                }

                if(product.mockup_img_2 != "" && product.mockup_img_2 != null){
                    $("#edit_preview_mockup_img_2").attr("src", "uploads/products/"+productId+"/"+product.mockup_img_2);
                }else{
                    $("#edit_preview_mockup_img_2").attr("src", "uploads/default_img.jpg");
                }

                if(product.mockup_img_3 != "" && product.mockup_img_3 != null){
                    $("#edit_preview_mockup_img_3").attr("src", "uploads/products/"+productId+"/"+product.mockup_img_3);
                }else{
                    $("#edit_preview_mockup_img_3").attr("src", "uploads/default_img.jpg");
                }

                if(product.active == 1){
                    $('#form_status_div').html("<span class='text-success text-danger mr-3' style='white-space: nowrap;'>Active</span><input type='button' class='btn btn-sm btn-secondary btn-secondary-custom' value='Set Under Construction' style='font-weight: inherit' onclick='setProductStatus(3);'>");
                }else if(product.active == 3){
                    $('#form_status_div').html("<span class='text-danger text-danger mr-3' style='white-space: nowrap;'>Under Construction</span><input type='button' class='btn btn-sm btn-secondary btn-secondary-custom' value='Set Active' style='font-weight: inherit' onclick='setProductStatus(1);'>");
                }
            },
            complete: function() {
                $(".se-pre-con").fadeOut('slow');
            }
        });
    })

    $(".delete").on("click", function(){
        var productId = $('#product_id').val();
        window.location.replace("../../products/delete/"+productId);
    });

    function setProductStatus(status){
        var productId = $('#product_id').val();
        window.location.replace("../../products/setStatus/"+productId+"/"+status);
    }
</script>
