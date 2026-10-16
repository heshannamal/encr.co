<div class="modal fade" id="add_remove_contacts_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add / Remove Contacts</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('organizations.edit_contacts') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="organization_id_in_model" name="organization_id_in_model"/>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 modal-form-field">
                                    <label class="form-lable">Contact Persons</label>

                                    <select class="form-control form-input select2-add-remove-people" id="addRemoveContactsList" name="contact_ids[]" style="width: 100%;"  multiple="multiple">
                                        <option value="">Select a contact Person</option>
                                        @foreach ($peoples as $people)
                                        <option value="{{$people->id}}">{{$people->first_name.' '.$people->last_name}}</option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="btn btn-sm input-group-text" data-toggle="modal" data-target="#people_create_modal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 control-btns mb-5">
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                        <button type="reset" class="btn btn-secondary btn-custom" id="add_remove_contact_cancel_btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#add_remove_contact_cancel_btn').click(function(){
            $('#add_remove_contacts_modal').modal('hide');
        });
    });
</script>
