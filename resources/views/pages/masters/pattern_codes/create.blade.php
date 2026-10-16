<style>
    .select2-container {
        border: 1px solid rgb(236, 236, 236) !important;
        border-radius: 5px !important;
    }
</style>

<div class="modal fade" id="pattern_code_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Pattern Code</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('pattern_codes.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row ml-3 mr-3">
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Product name <span class="text-danger">*</span></label><br>
                            <select class="form-control form-input" id="new_sub_product_id" name="new_sub_product_id" required>
                                    <option value="">Select a Product</option>
                                @foreach ($subProducts as $subProduct)
                                    <option value="{{$subProduct->id}}">
                                        {{$subProduct->product_name ?? ''}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="row flex_set">
                                <div class="col-md-12 max_width01">
                                    <div class="">
                                        <label class="form-label">Pattern Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-input" id="new_pattern_code" name="new_pattern_code" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4" id="new_attributes">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#pattern_code_create_modal').on('shown.bs.modal', function () {
            $('#new_sub_product_id').select2({
                dropdownParent: $('#pattern_code_create_modal'),
                placeholder: "Select Product",
                allowClear: true,
                width: '100%',

                // templateResult: formatColorOption, // For dropdown options
                // templateSelection: formatColorOption // For selected options
            });
        });

        $('#new_sub_product_id').change(function(){
            $('#new_attributes').html('');
            $('#edit_attributes').html('');
            var subProductId = $(this).val();

            if(subProductId) {
                $.ajax({
                    url: "{{ url('pattern_codes/get_attributes') }}/" + subProductId,
                    type: 'GET',
                    success: function(data) {
                        if(data) {
                            $('#new_attributes').html(data);
                        }
                    }
                });
            } else {
                $('#new_attributes').html('');
            }
        });
    });
</script>