
<div class="modal fade" id="type_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Edit Project Type</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('project_type.update')}}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="" id="type_id" name="type_id" />

                    <div class="col-md-6 form-field div_none1">
                        <label class="form-lable edit-item-label">Project Type Name: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-input" value=""  id="edit_type_name" name="edit_type_name" required style="width: 50% !important;" />
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom"  type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        @if (Gate::check('delete fabrics'))
                        <button type="button" class="btn btn-danger btn-custom delete">Delete</button>
                        @endif
                        @if (Gate::check('edit fabrics'))
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
        var projectTypeId = $('#type_id').val();
        var deleteUrl = "{{ route('projectType.delete', ['id' => ':id']) }}";
        deleteUrl = deleteUrl.replace(':id', projectTypeId);
        window.location.replace(deleteUrl);

    });

</script>


{{-- <script>
    $('#type_edit_modal').on('shown.bs.modal', function (e) {
    var projectTypeId = $('#project_type_id').val();
    console.log(projectTypeId);

    $.ajax({
        url: '{{ url("project_types/edit") }}/' + projectTypeId,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#edit_type_name').val(data.type_name);
            // $('#edit_type_description').val(data.type_description);
        },
        error: function (data) {
            console.log(data);
        }
    });
});

$(".delete").on("click", function(){
    var projectTypeId = $('#project_type_id').val();
    window.location.replace("../../project_types/delete/" + projectTypeId);
});


</script> --}}
{{-- <script>
    $('#factory_edit_modal').on('shown.bs.modal', function (e) {
        var factoryId = $('#factory_id').val();

        $.ajax({
            url: '{{url("factories/edit")}}/'+factoryId,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                $('#edit_factory_name').val(data.factory_name);
                $('#edit_factory_code').val(data.factory_code);
            }
        });
    })

    $(".delete").on("click", function(){
        var factoryId = $('#factory_id').val();
        window.location.replace("../../factories/delete/"+factoryId);
    });
</script> --}}
