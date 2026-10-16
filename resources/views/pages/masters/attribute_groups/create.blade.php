<style>
    .select2-container {
        border: 1px solid rgb(236, 236, 236) !important;
        border-radius: 5px !important;
    }
</style>

<div class="modal fade" id="attribute_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Attribute Groups</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('attribute_groups.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row flex_set">
                            <div class="col-md-12 max_width01">
                                <div class="">
                                    <label class="form-label">Attribute Group <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-input" id="new_attribute_group" name="new_attribute_group" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="form-label" for="new_attribute_group_product_category">Product Style <span class="text-danger">*</span></label><br>
                        <select class="form-control form-input multy-selection" id="new_attribute_group_product_category" name="new_attribute_group_product_category[]" multiple="multiple" required>
                            @foreach ($productCategories as $productCategory)
                                <option value="{{$productCategory->id}}">
                                    {{$productCategory->product_category_name}}
                                </option>
                            @endforeach
                        </select>
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
        $('#attribute_create_modal').on('shown.bs.modal', function () {
            $('#new_attribute_group_product_category').select2({
                dropdownParent: $('#attribute_create_modal'),
                placeholder: "Select Product Style",
                allowClear: true,
                width: '100%',
                // templateResult: formatColorOption, // For dropdown options
                // templateSelection: formatColorOption // For selected options
            });
            $('#new_main_category_id').select2({
                dropdownParent: $('#attribute_create_modal'),
                placeholder: "Select Category",
                allowClear: true,
                width: '100%',
            });
        });
    });
</script>