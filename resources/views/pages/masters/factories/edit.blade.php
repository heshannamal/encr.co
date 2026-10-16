<div class="modal fade" id="factory_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Factories</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('factories.update') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row div_flexdir1">
                            <input type="hidden" value="" id="factory_id" name="factory_id" />

                            <div class="col-md-6 form-field div_none1">
                                <label class="form-lable">Factory Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="edit_factory_name" name="edit_factory_name" required />
                            </div>

                            <div class="col-md-6 form-field div_none1">
                                <label class="form-lable">Factory Code: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="edit_factory_code" name="edit_factory_code" required />
                            </div>

                            <div class="col-md-6 form-field div_none1">
                                <label class="form-lable">Group : <span class="text-danger">*</span></label>
                                <select class="invoice-inputs select2 item-table-border item-factory" name="edit_Group_id" id="edit_Group_id">
                                    <option value="">Select Group</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete factories'))
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endif
                        @if (Gate::check('edit factories'))
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#factory_edit_modal').on('shown.bs.modal', function (e) {
        var factoryId = $('#factory_id').val();

        $.ajax({
            url: '{{url("factories/edit")}}/'+factoryId,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                $('#edit_factory_name').val(data.factory.factory_name);
                $('#edit_factory_code').val(data.factory.factory_code);
                // Clear existing options
                $('#edit_Group_id').empty();

                // Populate select with userGroups data
                $.each(data.userGroups, function(index, group) {
                    var option = $('<option>', {value: group.id, text: group.name});
                    if (data.factory.permission_id == group.id) {
                        option.attr('selected', 'selected');
                    }
                    $('#edit_Group_id').append(option);
                });

                // Initialize Select2 after populating options
                $('#edit_Group_id').select2();
            }
        });
    })

    $(".delete").on("click", function(){
        var factoryId = $('#factory_id').val();
        window.location.replace("../../factories/delete/"+factoryId);
    });
</script>
