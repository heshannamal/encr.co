<div class="modal fade" id="manage-variants-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="min-height: 80vh;">
        <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem;;background-color: #f1f1f1;">
          <h5 class="modal-title" style="font-size: 1.3rem;color: grey;">Product Variants</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="variant-container">
        </div>
        <div class="modal-footer">
            <button type="button" style="background-color: #8cef94; color: white;" class="btn btn-secondary add-new-variant">Add</button>
          <button type="button" style="background-color: #8cd4ef;color:white" class="btn btn-secondary" data-dismiss="modal">Done</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="add_product_variant" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem; background-color: #f1f1f1;">
                <h5 class="modal-title" style="font-size: 1.3rem; color: grey;">Add Product variant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('store.add_new_product_variant')}}" id="add_new_product_variant">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">variant Name</label>
                            <input type="text" class="form-control info-form-input" name="variant_name" id="variant_name" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">variant Value</label>
                            <input type="text" class="form-control info-form-input" name="variant_value" id="variant_value" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="background-color: #8cef94; color: white;" class="btn btn-secondary save-product_variant">Add</button>
                    <button type="button" style="background-color: #8cd4ef; color: white;" class="btn btn-secondary" data-dismiss="modal">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>

  <script>
    function appendVariants() {
            $.ajax({
                url: "{{ route('store.get_product_variants') }}",
                type: "GET",
                data: {
                    'store_product_id': $('#store_product_id').val(),
                    "_token": "{{ csrf_token() }}"
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (response) {
                    $('.variant-select').empty();
                    $('#variant-container').empty();

                    $('.variant-select').append(`<option value="">No variant</option>`);

                    response.product_variants.forEach(function(element) {
                        if(response.store_added_variant.map(String).includes(String(element.id))){
                            var option = '<option value="' + element.variant_value + '">' + element.variant_name + '</option>';
                            $('.variant-select').append(option);

                            var content = `<div class="container mb-2" style="background-color: ${element.variant_value}; position: relative;">
                                                <div class="row">
                                                    <div class="col-md-2 d-flex align-items-center" style="background-color: white;">
                                                        <i class="fa fa-eye" aria-hidden="true" style="font-size: 1.5rem;color:black;cursor:pointer" value="${element.id}"></i>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <p style="color: white; margin-bottom: .1rem;font-size: .8rem;"></p>
                                                    </div>
                                                    <div class="col-md-3" style="background-color: white;">
                                                        <p style="color: black; margin-bottom: .1rem;font-size: .8rem;">${element.variant_name}</p>
                                                    </div>
                                                </div>
                                           </div>`;
                            $('#variant-container').append(content);
                        }else{
                            var content = `<div class="container mb-2" style="background-color: ${element.variant_value}; position: relative;">
                                                <div class="row">
                                                    <div class="col-md-2 d-flex align-items-center" style="background-color: white;">
                                                        <i class="fa fa-eye-slash" aria-hidden="true" style="font-size: 1.5rem;color:black;cursor:pointer" value="${element.id}"></i>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <p style="color: white; margin-bottom: .1rem;font-size: .8rem;"></p>
                                                    </div>
                                                    <div class="col-md-3" style="background-color: white;">
                                                        <p style="color: black; margin-bottom: .1rem;font-size: .8rem;">${element.variant_name}</p>
                                                    </div>
                                                </div>
                                           </div>`;
                            $('#variant-container').append(content);
                        }
                    });
                    response.store_product_images.forEach(function(element) {
                        var $selectElement = $('#store_product_variant_' + element.id);

                        if ($selectElement.length > 0) {
                            if ($selectElement.find('option[value="' + element.variant + '"]').length > 0) {
                                $selectElement.val(element.variant).trigger('change');
                            } else {
                                $selectElement.val('').trigger('change');
                            }
                        }
                    });
                },
                complete: function () {
                    can_save = true;
                    $(".se-pre-con").fadeOut('slow');
                }
            });
    }
    function remove_variant(variant_id){
        $(".se-pre-con").fadeIn('slow');
          $.ajax({
              url: "{{ route('store.remove_variant') }}",
              type: "POST",
              data: {
                  'store_product_id' : $('#store_product_id').val(),
                  'variant_id' : variant_id,
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                appendVariants();
              }
          });
    }
    function add_variant(variant_id){
        $(".se-pre-con").fadeIn('slow');
          $.ajax({
              url: "{{ route('store.add_variant') }}",
              type: "POST",
              data: {
                  'store_product_id' : $('#store_product_id').val(),
                  'variant_id' : variant_id,
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                appendVariants();
              }
          });
    }
    $(document).ready(function() {

        $(document).on('click', '.manage-variants', function() {
            $(".se-pre-con").fadeIn('slow');
            appendVariants();
            $('#manage-variants-modal').modal('show');
        });
        $(document).on('click', '.add-new-variant', function() {
            $('#add_product_variant').modal('show');
        });
        $('.save-product_variant').click(function() {

            $(".se-pre-con").fadeIn('slow');

            var formData = $('#add_new_product_variant').serialize();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            formData += '&_token=' + encodeURIComponent(csrfToken);
            var storeProductId = $('#store_product_id').val();
            formData += '&store_product_id=' + encodeURIComponent(storeProductId);

            $.ajax({
                url: $('#add_new_product_variant').attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#add_product_variant').modal('hide');
                    appendVariants();
                },
                error: function(xhr) {
                    console.log('Form submission error:', xhr);
                }
            });
        });
        $(document).on('click','#variant-container .fa-eye, #variant-container .fa-eye-slash', function() {

            var $icon = $(this);
            var id = $icon.attr('value');

            if ($icon.hasClass('fa-eye')) {
                $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                remove_variant(id);
            } else {
                $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                add_variant(id);
            }
        });
    });
  </script>
