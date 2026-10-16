
<!--Price Addition Modal -->
<div class="modal fade" id="add_price_addition"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPriceAdditionLabel">Add Price Addition</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_price_addition_form">
                    @csrf
                    <input type="hidden" id="price_addition_id" name="price_addition_id" value="">
                    <div class="col-md-12 mb-3">
                        <label for="price_addition_name" class="form-label">Price addition name</label>
                        <input type="text" class="form-control" id="price_addition_name" placeholder="Price Addition Name">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="is_addition_value" class="form-label">Price addition type</label>
                        <table style="width: 60%;">
                            <tr style="border: none; font-size: .8rem;color:black">
                                <td>
                                    <input type="radio" value="1" name="is_addition_value" id="is_addition_value"> Value ($)
                                </td>
                                <td>
                                    <input type="radio" value="0" name="is_addition_value" id="is_addition_value"> Percentage (%)
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="addition_value" class="form-label">Amount</label>
                        <input type="number" step="0.01" min="0.00" class="form-control" name="addition_value" id="addition_value" placeholder="Amount">
                    </div>
                    <div class="col-md-12 mt-3 d-flex align-items-center">
                        <input type="checkbox" name="is_fundraising" id="is_fundraising" class="mr-1" checked>
                        <label for="is_fundraising" class="form-label-info mt-1 mb-0">Fundraising</label>
                    </div>
                    <div class="col-md-12 mt-3 d-flex align-items-center">
                        <input type="checkbox" name="hide_from_customer" id="hide_from_customer" class="mr-1">
                        <label for="hide_from_customer" class="form-label-info mt-1 mb-0">Hide from customers</label>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="addition_description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" name="addition_description" id="addition_description" cols="30" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save_price_addition">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    function price_addition_append(){
          $.ajax({
              url: "{{ route('store.get_store_product_price_additions') }}",
              type: "GET",
              data: {
                  'store_product_id' : $('#store_product_id').val(),
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                $('#price_addition_table').empty();
                if (response.length > 0) {

                    response.forEach(element => {
                        var additioRecord = `<tr style="border: none">
                                                <td style="font-size:.8rem;padding: 5px;border:0.5px solid #eaeaea;width:65%">${element.price_addition_name} ($${element.addition_amount})</td>
                                                <td class="text-right" style="font-size:.8rem;padding: 5px;border:0.5px solid #eaeaea;width:20%">${element.addition_value + " " + (element.is_addition_value == 1 ? '$' : '%')}</td>
                                                <td class="text-center" style="font-size:.8rem;padding: 5px;border:0.5px solid #eaeaea;width:15%">
                                                    <i class="fa fa-pencil edit_price_addition" style="color:grey;cursor:pointer" data-price-addition-id="${element.id}" aria-hidden="true"></i>&nbsp;
                                                    <i class="fa fa-trash delete_price_addition" style="color:#e98f8f;cursor:pointer" data-price-addition-id="${element.id}" aria-hidden="true"></i>
                                                </td>
                                            </tr>`;
                        $('#price_addition_table').append(additioRecord);
                    });

                    }else{
                    var additioRecord = `<tr style="border: none;">
                                                <td colspan="3" style="font-size:.8rem;padding: 5px;border:0.5px solid #eaeaea">No price addition available</td>
                                            </tr>`;

                    $('#price_addition_table').append(additioRecord);
                    }
              }

          });
          $(".se-pre-con").fadeOut('slow');
    }
    $(document).ready(function () {
        $('.add_price_addition').on('click', function() {
            $('#addPriceAdditionLabel').text('Add Price Addition');
            $('#price_addition_id').val('');
            $('#add_price_addition').modal('show');
        });
        $(document).on("click", ".edit_price_addition", function () {
            var additionId = $(this).data('price-addition-id');

            $(".se-pre-con").fadeIn('slow');

            $.ajax({
                url: "{{ route('store.product_price_addition') }}",
                type: "GET",
                data: {
                    addition_id: additionId
                },
                success: function (response) {
                    if (response) {
                        $('#addPriceAdditionLabel').text('Edit Price Addition');

                        $('#price_addition_id').val(response.id);
                        $('#price_addition_name').val(response.price_addition_name);
                        $('#addition_value').val(response.addition_value);
                        $('#addition_description').val(response.addition_description);

                        $('input[name="is_addition_value"][value="' + response.is_addition_value + '"]').prop("checked", true);

                        $('#hide_from_customer').prop('checked', response.hide_from_customer == 1);
                        $('#is_fundraising').prop('checked', response.is_fundraising == 1);

                        $('#add_price_addition').modal('show');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Failed to fetch price addition details."
                        });
                    }
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Something went wrong while fetching details. Please try again."
                    });
                }
            });

            $(".se-pre-con").fadeOut('slow');
        });
        $(document).on("click", ".delete_price_addition", function () {
            var additionId = $(this).data("price-addition-id");

            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently delete the price addition.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.value) {
                    $(".se-pre-con").fadeIn("slow");

                    $.ajax({
                        url: "{{ route('store.delete_price_addition') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            addition_id: additionId
                        },
                        success: function (response) {
                            $(".se-pre-con").fadeOut("slow");

                            if (response.status === "success") {
                                Swal.fire("Deleted!", response.message, "success");
                                price_addition_append();
                                loadProducts();
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function (xhr) {
                            $(".se-pre-con").fadeOut("slow");
                            Swal.fire("Error!", "Something went wrong.", "error");
                            console.error("Error:", xhr.responseText);
                        }
                    });
                }
            });
        });
        $(".save_price_addition").on("click", function (e) {
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            let formData = {
                _token: $("input[name=_token]").val(),
                price_addition_id: $("#price_addition_id").val(),
                price_addition_name: $("#price_addition_name").val(),
                is_addition_value: $("input[name='is_addition_value']:checked").val(),
                addition_value: $("#addition_value").val(),
                hide_from_customer: $("#hide_from_customer").is(":checked") ? 1 : 0,
                is_fundraising: $("#is_fundraising").is(":checked") ? 1 : 0,
                addition_description: $("#addition_description").val(),
                store_product_id: $("#store_product_id").val()
            };

            $.ajax({
                url: "{{ route('store.save_price_addition') }}",
                type: "POST",
                data: formData,
                success: function (response) {
                    console.log("Success:", response);

                    if (response.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: "Price addition saved successfully!",
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $("#add_price_addition").modal("hide");
                        price_addition_append();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.message
                        });
                    }
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);

                    let errorMessage = "Something went wrong. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: errorMessage
                    });
                }
            });

            $(".se-pre-con").fadeOut('slow');

        });
        $('#add_price_addition').on('hidden.bs.modal', function () {
            $('#add_price_addition_form')[0].reset();

            $('#price_addition_id').val('');

            $('input[name="is_addition_value"]').prop('checked', false);

            $('#mandotary').prop('checked', false);

            $('#addPriceAdditionLabel').text('Add Price Addition');
        });
    });
</script>
