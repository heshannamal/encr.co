<style>
    .select2-container {
        border: 1px solid rgb(236, 236, 236) !important;
        border-radius: 5px !important;
    }
</style>

<div class="modal fade" id="pattern_code_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="hidden" value="" id="pattern_code_id"/>
                <h3 class="modal-title" id="modal-title-default">Edit Pattern Code</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body" id="pattern_code_edit_modal_body">

                {{-- <form action="{{ route('pattern_codes.update', $paternCode->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Product name <span class="text-danger">*</span></label><br>
                            <select class="form-control form-input" id="edit_sub_product_id" name="edit_sub_product_id" required>
                                @foreach ($subProducts as $subProduct)
                                    <option value="{{$subProduct->id}}">
                                        {{$subProduct->product_name ?? ''}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="row flex_set">
                                <div class="col-md-12 max_width01">
                                    <div class="">
                                        <label class="form-label">Patter Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-input" id="edit_pattern_code" name="edit_pattern_code" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="edit_attributes">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 control-btns">
                            <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                            @if (Gate::check('delete pattern code'))
                                <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                            @endif
                            @if (Gate::check('edit pattern code'))
                                <button type="submit" class="btn btn-success btn-custom">Update</button>
                            @endif
                        </div>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#pattern_code_edit_modal').on('shown.bs.modal', function () {
            var patternCodeId = $('#pattern_code_id').val();

            $.ajax({
                url: "{{ url('pattern_codes/edit') }}/" + patternCodeId,
                type: 'GET',
                success: function(data) {
                    if(data) {
                        $('#pattern_code_edit_modal_body').html(data);
                        $('#edit_sub_product_id').select2({
                            dropdownParent: $('#pattern_code_edit_modal'),
                            placeholder: "Select Product",
                            allowClear: true,
                            width: '100%',
                            // templateResult: formatColorOption, // For dropdown options
                            // templateSelection: formatColorOption // For selected options
                        });
                    }
                }
            });
        });

        $('body').on('change', '#edit_sub_product_id', function(){
            $('#edit_attributes').html('');
            var subProductId = $(this).val();
            if(subProductId) {
                $.ajax({
                    url: "{{ url('pattern_codes/get_attributes') }}/" + subProductId,
                    type: 'GET',
                    success: function(data) {
                        if(data) {
                            $('#edit_attributes').html(data);
                        }
                    }
                });
            } else {
                $('#edit_attributes').html('');
            }
        });
    });

    function deletePatternCode(patternCodeId) {
        Swal.fire({
            title: 'Are you sure to delete pattern code?',
            text: 'This action delete your pattern code.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {

            if (result.value) {

                console.log('success');
                window.location = "{{ url('pattern_codes/delete') }}/" + patternCodeId;

            } else {
                Swal.close();
            }
        });
    }
</script>
