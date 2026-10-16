<style>
    #add_ex_factory_modal .modal-body .form-lable {
        width: 50%;
    }
</style>

<div class="modal fade" id="add_ex_factory_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Add Ex-Factory Shipping Address</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="col-md-12 form-field">
                        <label class="form-lable">Name</label>
                        <input type="text" class="form-control" rows="4" id="ex_factory_name" name="ex_factory_name" />
                    </div>

                    <div class="col-md-12 form-field">
                        <label class="form-lable">Shipping PO Box</label>
                        <input type="text" class="form-control" id="ex_factory_po_box" name="ex_factory_po_box" />
                    </div>

                    <div class="col-md-12 form-field">
                        <label class="form-lable">Shipping City</label>
                        <input type="text" class="form-control" id="ex_factory_city" name="ex_factory_city" />
                    </div>

                    <div class="col-md-12 form-field">
                        <label class="form-lable">Shipping State</label>
                        <input type="text" class="form-control" id="ex_factory_state" name="ex_factory_state" />
                    </div>

                    <div class="col-md-12 form-field">
                        <label class="form-lable">Shipping Postal Code</label>
                        <input type="text" class="form-control" id="ex_factory_postal_code" name="ex_factory_postal_code" />
                    </div>

                    <div class="col-md-12 form-field">
                        <label class="form-lable">Shipping Country</label>
                        <input type="text" class="form-control" id="ex_factory_country" name="ex_factory_country" />
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-lg-12 control-btns">
                    <button type="button" class="btn btn-success btn-custom" id="btn_add_ex_factory">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn_add_ex_factory').on('click', function(){
        $(".se-pre-con").fadeIn('fast');
        var ex_factory_name = $('#ex_factory_name').val();
        var ex_factory_po_box = $('#ex_factory_po_box').val();
        var ex_factory_city = $('#ex_factory_city').val();
        var ex_factory_state = $('#ex_factory_state').val();
        var ex_factory_postal_code = $('#ex_factory_postal_code').val();
        var ex_factory_country = $('#ex_factory_country').val();

        $.ajax({
            url: "{{route('ex_factory.create')}}",
            type: "POST",
            data: {
                'ex_factory_name': ex_factory_name, 'ex_factory_po_box': ex_factory_po_box, 'ex_factory_city':ex_factory_city, 'ex_factory_state':ex_factory_state,
                'ex_factory_postal_code':ex_factory_postal_code, 'ex_factory_country':ex_factory_country, '_token':'{{csrf_token()}}'
            },
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                if(data.success){
                    var newExFactory = data.data;
                    $('#item_ex_factory_id').append(
                        '<option value="'+newExFactory.id+'">'+newExFactory.ex_factory_name+' | '+newExFactory.po_box+', '+newExFactory.city+', '+', '+newExFactory.state+', '+newExFactory.postal_code+', '+newExFactory.country+'</option>'
                    );
                    $('#item_ex_factory_id').val(newExFactory.id).trigger('change');

                }else{
                    swal({
                        title: "Error!",
                        text: data.message,
                        type: "error"
                    });
                    $('#item_ex_factory_id').val(0).trigger('change');
                }
                $('#add_ex_factory_modal').modal('hide');
                $(".se-pre-con").fadeOut('fast');
            },
            error: function (data, textStatus, jqXHR) {
                swal({
                    title: "Error!",
                    text: "Failed to save Ex Factory Address",
                    type: "error"
                });
                $('#item_ex_factory_id').val(0).trigger('change');
                $(".se-pre-con").fadeOut('fast');
            }
        });
    });
</script>
