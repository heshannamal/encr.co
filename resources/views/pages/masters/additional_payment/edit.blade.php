<div class="modal fade" id="edit_addition_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Additional Payment Type</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('additional_payment.edit')}}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="" id="type_id" name="type_id" />
                    <div class="col-md-12 form-field mt-3 max_width01">
                        <label class="form-lable">Additional Payment Type Name: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-input" id="edit_additional_payment_name" name="edit_additional_payment_name" required />
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button  class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete addional payment'))
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endif
                        @if (Gate::check('edit addional payment'))
                        <button type="submit" class="btn btn-success btn-custom">Update</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    $(".delete").on("click", function(){
            var additionPaymentId = $('#type_id').val();
            var deleteUrl = "{{ route('additionPayment.delete', ['id' => ':id']) }}";
            deleteUrl = deleteUrl.replace(':id', additionPaymentId);
            window.location.replace(deleteUrl);

        });

    </script>
