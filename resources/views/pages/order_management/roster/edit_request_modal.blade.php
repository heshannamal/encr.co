<div class="modal fade" id="edit_request_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Request for Roster Edit</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form>
                <div class="modal-body">
                    <input type="hidden" name="request_order_id" id="request_order_id" />

                    <div class="col-md-12">
                        <table class="table invoice_details">
                            <tr>
                                <th>Reasons for Request :</th>
                                <td>
                                    <textarea class="invoice-inputs" name="request_reasons" id="request_reasons" rows="3"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 text-right">
                        <button type="button" class="btn btn-success" id="request_btn"><i class="fab fa-telegram-plane"></i> Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#request_btn').on('click', function(){
        var orderId = $('#request_order_id').val();
        var requestReasons = $('#request_reasons').val();

        if(requestReasons == ""){
                swal({title: "Invalid Input?", text: 'Please Enter Reasons for Edit Request', type: "error", confirmButtonColor: "#ce0029",})
                .then((value) => {$($('#item_designer').attr('data-focus')).focus();});

        } else {
            $.ajax({
            url: "request",
            type: "POST",
            data: {'order_id': orderId, 'request_reasons': requestReasons, '_token':'{{csrf_token()}}' },
            success: function (data) {
                $('#edit_request_modal').modal('hide');

                swal({
                    title: "Success!",
                    text: "Request Sent Successfully!",
                    type: "success",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        });
        }
    });
</script>
