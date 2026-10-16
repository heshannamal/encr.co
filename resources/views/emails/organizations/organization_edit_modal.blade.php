<style>
    #organization_edit_modal .select2-container--default{
        width: 75% !important;
    }
    #organization_edit_modal #select2-link_organization_id-container{
        padding-top: 0 !important;
    }
</style>

<div class="modal fade" id="organization_edit_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Link an Organization</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- <form action="{{ route('organizations.create') }}" method="post" enctype="multipart/form-data" id="add_organization_form"> --}}
                <form enctype="multipart/form-data" id="link_organization_form">
                    @csrf
                    {{-- Organization Details --}}
                    {{-- <div class="card"> --}}
                        {{-- <div class="modal-card-header card-header">Chnage Organization Details</div> --}}
                        {{-- @if (request()->has('people_id')) <input type="hidden" value="{{ request()->get('people_id') }}" name="existing_people" /> @endif --}}

                        {{-- <div class="card-body change-organization"> --}}
                            <div class="row">
                                <div class="col-md-12 modal-form-field">
                                    <label class="form-lable">Organization</label>
                                    <select class="form-control modal-form-input select2-organization-modal" id="link_organization_id" name="link_organization_id" style="width: 75%;">
                                        <option value="">Select an Organization</option>
                                        @foreach ($organizations as $organization)
                                            <option @if(isset($linkedOrganization) && $linkedOrganization->organization_id == $organization->id) selected @endif value="{{$organization->id}}">{{$organization->organization_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        {{-- </div>
                    </div> --}}

                    <div class="col-lg-12 control-btns mb-5">
                        <button type="button" class="btn btn-success btn-custom" id="link_organization">Link</button>
                        <button type="reset" class="btn btn-secondary btn-custom" id="cancel_btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.select2-organization-modal').select2({
            dropdownParent: $("#organization_edit_modal"),
            width: 'resolve'
        });
        $('#cancel_btn').click(function(){
            // $('#add_form input[type=text]').each(
            //     function(index){
            //         $(this).html('');
            //         // var input = $(this);
            //         // console.log('Type: ' + input.attr('type') + 'Name: ' + input.attr('name') + 'Value: ' + input.val());
            //     }
            // );
            $('.select2-organization-modal').each(
                function(index){
                    var input = $(this);
                    if(input.attr('id') == 'sales_tax_active'){
                        input.val(1).trigger("change");
                    } else {
                        input.val('').trigger("change");
                    }
                }
            );
        });

    });
</script>
