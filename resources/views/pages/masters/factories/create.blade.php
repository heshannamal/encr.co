<div class="modal fade" id="factory_create_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add New Factories</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="{{ route('factories.create')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row div_flexdir1">
                            <div class="col-md-6 form-field div_none1">
                                <label class="form-lable">Factory Name: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="new_factory_name" name="new_factory_name" required />
                            </div>

                            <div class="col-md-6 form-field div_none1">
                                <label class="form-lable">Factory Code: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-input" id="new_factory_code" name="new_factory_code" required />
                            </div>

                            <div class="col-md-6 form-field div_none1">
                                <label class="form-lable">Group : <span class="text-danger">*</span></label>
                                <select class="invoice-inputs select2 item-table-border item-factory" name="Group_id">
                                    <option value="">Select Group</option>
                                    @foreach ($userGroups as $Group)
                                        <option value="{{ $Group->id }}" >{{ $Group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 control-btns">
                        <button class="btn btn-secondary btn-custom" type="button"  data-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn btn-success btn-custom">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
