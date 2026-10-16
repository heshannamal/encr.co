<div class="modal fade" id="manage-coupons-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="min-height: 80vh;">
        <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem;;background-color: #f1f1f1;">
          <h5 class="modal-title" style="font-size: 1.3rem;color: grey;">Coupons</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="coupon-container">
            <div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" style="background-color: #8cef94;color:white" class="btn btn-secondary add-new-coupon">Add New Coupon</button>
          <button type="button" style="background-color: #8cd4ef;color:white" class="btn btn-secondary" data-dismiss="modal">Done</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="coupon-add-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem; background-color: #f1f1f1;">
                <h5 class="modal-title" style="font-size: 1.3rem; color: grey;">Add Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('store.add_new_coupon')}}" id="add_new_coupon">
                <input type="hidden" name="coupon_id" id="coupon_id" value="" />
                <input type="hidden" name="store_id" id="store_id" value="{{$store->id}}" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">Coupon Name</label>
                            <input type="text" class="form-control info-form-input" name="coupon_name" id="coupon_name" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">Coupon Type</label>
                            <select class="form-control info-form-input" name="coupon_type" id="coupon_type" required>
                                <option value="flat_from_sub">Flat($) From the Sub total</option>
                                <option value="percentage_from_sub">Percentage(%) From the Sub total</option>
                                <option value="flat_from_grand">Flat($) From the Grand total</option>
                                <option value="percentage_from_grand">Percentage(%) From the Grand total</option>
                                <option value="free_shipping">Free Shipping</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">Coupon Amount</label>
                            <input type="number" class="form-control info-form-input" name="coupon_amount" id="coupon_amount" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">Coupon Code</label>
                            <input type="text" class="form-control info-form-input" name="coupon_code" id="coupon_code" required />
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="limit_coupon_usage" id="limit_coupon_usage">
                                <label for="limit_coupon_usage" class="form-check-label">Limit Coupon Usage</label>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2 limit-coupon-usage-area" style="display: none;">
                            <label class="form-lable-info mb-2">Coupon valid times</label>
                            <input type="number" class="form-control info-form-input" min="1" step="1" name="coupon_valid_times" id="coupon_valid_times"/>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">Expire Date</label>
                            <input type="text" class="form-control info-form-input datepicker" name="expire_date" id="expire_date" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="background-color: #8cef94; color: white;" class="btn btn-secondary save-coupon">Add</button>
                    <button type="button" style="background-color: #8cd4ef; color: white;" class="btn btn-secondary" data-dismiss="modal">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>

  <script>
    function couponAppend(){
          $.ajax({
              url: "{{ route('store.get_store_coupons') }}",
              type: "GET",
              data: {
                  'id' : $('#store_id').val(),
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                  $('#coupon-container').empty();
                  $('#manage-coupons-area').empty();
                  response.store_coupons_all.forEach(element => {

                      var className = response.store_coupons.map(String).includes(String(element.id)) ? 'fa-eye' : 'fa-eye-slash';

                      var content = `<div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                      <div class="row">
                                          <div class="col-md-2 d-flex align-items-center">
                                              <i class="fa ${className}" aria-hidden="true" style="font-size: 1.5rem;color:black;cursor:pointer" value="${element.id}"></i>
                                          </div>
                                          <div class="col-md-8">
                                              <p style="color: grey; margin-bottom: .1rem; padding-top: .5rem; font-size: .8rem;">${element.coupon_name}</p>
                                              <p style="color: #b3b3b3; margin-bottom: .1rem; padding-bottom: .5rem; font-size: .75rem;">$${element.amount} - ${element.type}</p>
                                          </div>
                                          <div class="col-md-2 d-flex align-items-center">
                                            <i class="fa fa-pencil edit-coupon mr-2" style="font-size: .8rem;color:grey;cursor:pointer" data-info='${JSON.stringify(element).replace(/'/g, "&#39;").replace(/"/g, "&quot;")}' aria-hidden="true"></i><br>
                                            <i class="fa fa-trash ml-2 delete-coupon" style="font-size: .8rem;color:#eb9a9a;cursor:pointer" data-id="${element.id}" aria-hidden="true"></i>
                                          </div>
                                      </div>
                                   </div>`;

                      $('#coupon-container').append(content);

                      if(response.store_coupons.map(String).includes(String(element.id))){
                        var cardContent = `<div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                                <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;" onclick="remove_coupon(${element.id})">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;font-size: .8rem;">${element.coupon_name}</p>
                                                <p style="color: #b3b3b3;margin-bottom:0;padding-bottom:0;font-size: .75rem;">
                                                    ${element.type === 'free_shipping' ? 'Free Shipping' : element.type == 'flat_from_sub' ? `$${element.amount} Off From Sub total` : element.type == 'percentage_from_sub' ? `${element.amount}% Off From Sub total` : element.type == 'flat_from_grand' ? `$${element.amount} Off From Grand total` : element.type == 'percentage_from_grand' ? `${element.amount}% Off From Grand total` : ''}
                                                </p>
                                                <p style="color:#b3b3b3;margin-bottom:.1rem;padding-bottom:.5rem;font-size:.75rem;">${element.coupon_code} &nbsp;&nbsp; <i class="fa fa-clone" aria-hidden="true" style="cursor: pointer" onclick="copyCouponCode('${element.coupon_code}')"></i></p>
                                            </div>`;
                        $('#manage-coupons-area').append(cardContent);
                      }

                  });
              }

          });
          $(".se-pre-con").fadeOut('slow');
    }
    function remove_coupon(coupon_id){
        $(".se-pre-con").fadeIn('slow');
          $.ajax({
              url: "{{ route('store.remove_coupon') }}",
              type: "POST",
              data: {
                  'store_id' : $('#store_id').val(),
                  'coupon_id' : coupon_id,
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                couponAppend();
              }
          });
    }
    function add_coupon(coupon_id){
        $(".se-pre-con").fadeIn('slow');
          $.ajax({
              url: "{{ route('store.add_coupon') }}",
              type: "POST",
              data: {
                  'store_id' : $('#store_id').val(),
                  'coupon_id' : coupon_id,
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                couponAppend();
              }
          });
    }
    function edit_coupon(dataInfo) {
        $('#coupon_id').val(dataInfo.id);
        $('#coupon_name').val(dataInfo.coupon_name);
        $('#coupon_type').val(dataInfo.type);
        $('#coupon_amount').val(dataInfo.amount);
        $('#coupon_code').val(dataInfo.coupon_code);
        $('#expire_date').val(dataInfo.expire_date);
        if(dataInfo.limit_coupon_usage == 1){
            $('#limit_coupon_usage').prop('checked', true);
            $('.limit-coupon-usage-area').show();
            $('#coupon_valid_times').val(dataInfo.coupon_valid_times);
        } else {
            $('#limit_coupon_usage').prop('checked', false);
            $('.limit-coupon-usage-area').hide();
            $('#coupon_valid_times').val(1);
        }

        $('#coupon-add-modal .modal-title').text('Edit Coupon');
        $('.save-coupon').text('Update');

        $('#coupon-add-modal').modal('show');
    }
    function copyCouponCode(code) {
        navigator.clipboard.writeText(code).then(function() {
            Swal.fire({
                title: "Success",
                text: "Coupon code copied to clipboard!",
                icon: "success"
            });
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
    function delete_coupon(coupon_id){
        $(".se-pre-con").fadeIn('slow');
          $.ajax({
              url: "{{ route('store.delete_coupon') }}",
              type: "POST",
              data: {
                  'store_id' : $('#store_id').val(),
                  'coupon_id' : coupon_id,
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                couponAppend();
              }
          });
    }
    $(document).ready(function() {

        $(document).on('click', '.manage-coupons', function() {
            $(".se-pre-con").fadeIn('slow');
            couponAppend();
            $('#manage-coupons-modal').modal('show');
        });

        $('#limit_coupon_usage').change(function() {
            if($(this).is(':checked')) {
                $('.limit-coupon-usage-area').show();
            } else {
                $('.limit-coupon-usage-area').hide();
                $('#coupon_valid_times').val(1);
            }
        });

        $(document).on('click', '.add-new-coupon', function () {
            $('#coupon_id').val('');
            $('#coupon_name').val('');
            $('#coupon_type').val('flat_from_sub');
            $('#coupon_amount').val('');
            $('#coupon_code').val('');
            $('#expire_date').val('');
            $('#coupon_valid_times').val(1);
            $('#limit_coupon_usage').prop('checked', false);
            $('.limit-coupon-usage-area').hide();

            $('#coupon-add-modal .modal-title').text('Add New Coupon');
            $('.save-coupon').text('Add');

            $('#coupon-add-modal').modal('show');
        });

        $(document).on('click', '.edit-coupon', function() {
            let dataInfo = $(this).data('info');
            edit_coupon(dataInfo);
        });

        $(document).on('click','#coupon-container .fa-eye, #coupon-container .fa-eye-slash', function() {

            var $icon = $(this);
            var id = $icon.attr('value');

            if ($icon.hasClass('fa-eye')) {
                $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                remove_coupon(id);
            } else {
                $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                add_coupon(id);
            }
        });
        $('.save-coupon').click(function() {

            $(".se-pre-con").fadeIn('slow');

            var formData = $('#add_new_coupon').serialize();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            formData += '&_token=' + encodeURIComponent(csrfToken);

            $.ajax({
                url: $('#add_new_coupon').attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#coupon-add-modal').modal('hide');
                    couponAppend();
                },
                error: function(xhr) {
                    console.log('Form submission error:', xhr);
                    couponAppend();
                }
            });
        });
        $(document).on('click', '.delete-coupon', function() {
            var couponId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    delete_coupon(couponId);
                }
            });
        });
    });
</script>
