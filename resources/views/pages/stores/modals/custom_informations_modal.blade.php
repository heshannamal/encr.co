<div class="modal fade" id="manage-custom-informations-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="min-height: 80vh;">
        <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem;;background-color: #f1f1f1;">
          <h5 class="modal-title" style="font-size: 1.3rem;color: grey;">Custom informations</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @if ($store_custom_information_templates->count() > 0)
            <div class="mt-2 mb-3">
                <label class="form-lable-info mb-2" style="margin-left: 15px; margin-top: 10px;">Load from template</label>
                <select class="form-control" id="use_custom_information_template" style="width: 200px; display: inline-block; margin-left: 10px;">
                    <option value="">Select Template</option>
                    @foreach($store_custom_information_templates as $template)
                        <option value="{{ $template->id }}">{{ $template->template_name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="modal-body" id="custom_information-container">
            <div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" style="background-color: #8cef94;color:white" class="btn btn-secondary add-custom-field">Add New Field</button>
          <button type="button" style="background-color: #eaab4c;color:white" class="btn btn-secondary save-as-template">Save as template</button>
          <button type="button" style="background-color: #8cd4ef;color:white" class="btn btn-secondary" data-dismiss="modal">Done</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="informations-add-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem; background-color: #f1f1f1;">
                <h5 class="modal-title" style="font-size: 1.3rem; color: grey;">Add custom input</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('store.add_new_custom_information')}}" id="add_new_custom_information">
                <input type="hidden" name="custom_information_id" id="custom_information_id" value="" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">Custom input type</label>
                            <div class="d-flex">
                                <div class="form-check mr-3">
                                    <input class="form-check-input" type="radio" name="custom_input_type" id="text_input" value="1" style="margin-top: .1rem;" required>
                                    <label class="form-check-label" for="text_input">
                                        Text input
                                    </label>
                                </div>
                                <div class="form-check mr-3">
                                    <input class="form-check-input" type="radio" name="custom_input_type" id="dropdown_input" value="2" style="margin-top: .1rem;" required>
                                    <label class="form-check-label" for="dropdown_input">
                                        Dropdown
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="custom_input_type" id="number_input" value="3" style="margin-top: .1rem;" required>
                                    <label class="form-check-label" for="number_input">
                                        Number Input
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">Custom input name</label>
                            <input type="text" class="form-control info-form-input" name="custom_input_name" id="custom_input_name" required />
                        </div>
                        <div class="col-md-12 mt-3 custom-input-options" style="display: none;">
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="make_as_sub_team" name="make_as_sub_team">
                                <label class="form-check-label" for="make_as_sub_team">Make as sub team</label>
                            </div>

                            <label class="form-label-info mb-2">Options</label>
                            <button type="button" id="add-option" class="btn btn-sm add-option-btn">
                                <i class="fa fa-plus-square mr-1"></i> Add Option
                            </button>
                            <div id="option-container" class="mt-2"></div>
                            <input type="hidden" name="custom_input_options" id="custom_input_options" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="background-color: #8cef94; color: white;" class="btn btn-secondary save-custom-field">Add</button>
                    {{-- <button type="button" style="background-color: #8cd4ef; color: white;" class="btn btn-secondary" data-dismiss="modal">Done</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="save-as-template-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem; background-color: #f1f1f1;">
                <h5 class="modal-title" style="font-size: 1.3rem; color: grey;">Save as template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="form-lable-info mb-2">Template Name</label>
                            <input type="text" class="form-control info-form-input" name="template_name" id="template_name" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="background-color: #8cef94; color: white;" class="btn btn-secondary save-template">Save</button>
                    <button type="button" style="background-color: #8cd4ef; color: white;" class="btn btn-secondary" data-dismiss="modal">Done</button>
                </div>
        </div>
    </div>
</div>


  <script>
    function custom_informationAppend(){
          $.ajax({
              url: "{{ route('store.get_store_custom_informations') }}",
              type: "GET",
              data: {
                  'id' : $('#store_id').val(),
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                  $('#custom_information-container').empty();
                  $('#manage-custom-informations-area').empty();
                  response.store_custom_informations_all.forEach(element => {
                      var className = response.store_custom_informations.map(String).includes(String(element.id)) ? 'fa-eye' : 'fa-eye-slash';

                      var content = `<div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                      <div class="row">
                                          <div class="col-md-2 d-flex align-items-center">
                                              <i class="fa ${className}" aria-hidden="true" style="font-size: 1.5rem;color:black;cursor:pointer" value="${element.id}"></i>
                                          </div>
                                          <div class="col-md-8">
                                              <p style="color: grey; margin-bottom: .1rem; padding-top: .5rem; padding-bottom: .5rem; font-size: .8rem;">${element.custom_name}</p>
                                          </div>
                                          <div class="col-md-2 d-flex align-items-center">
                                            <i class="fa fa-trash remove-custom-info mr-3" aria-hidden="true" style="font-size: .8rem;color:#eb9a9a;cursor:pointer" onclick="delete_custom_information(${element.id})"></i>
                                            <i class="fa fa-pencil edit-custom-info" style="font-size: .8rem;color:grey;cursor:pointer" data-info='${JSON.stringify(element).replace(/'/g, "&#39;").replace(/"/g, "&quot;")}'  aria-hidden="true"></i>
                                          </div>
                                      </div>
                                   </div>`;

                      $('#custom_information-container').append(content);

                      if(response.store_custom_informations.map(String).includes(String(element.id))){
                        var cardContent = `<div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                                <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;" onclick="remove_custom_information(${element.id})">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;padding-bottom: .5rem;font-size: .8rem;">${element.custom_name}</p>
                                            </div>`;
                        $('#manage-custom-informations-area').append(cardContent);
                      }

                  });
              }

          });
          $(".se-pre-con").fadeOut('slow');
    }
    function delete_custom_information(custom_information_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                $(".se-pre-con").fadeIn('slow');

                $.ajax({
                    url: "{{ route('store.delete_custom_information') }}",
                    type: "POST",
                    data: {
                        store_id: $('#store_id').val(),
                        custom_information_id: custom_information_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $(".se-pre-con").fadeOut('slow');

                        custom_informationAppend();

                        Swal.fire({
                            icon: response.status === 'success' ? 'success' : 'error',
                            title: response.message
                        });
                    },
                    error: function(xhr) {
                        $(".se-pre-con").fadeOut('slow');
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                            text: xhr.responseText
                        });
                    }
                });
            }
        });
    }

    function remove_custom_information(custom_information_id){
        $(".se-pre-con").fadeIn('slow');
          $.ajax({
              url: "{{ route('store.remove_custom_information') }}",
              type: "POST",
              data: {
                  'store_id' : $('#store_id').val(),
                  'custom_information_id' : custom_information_id,
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                $(".se-pre-con").fadeOut('slow');
                custom_informationAppend();
              }
          });
    }
    function edit_custom_information(custom_information) {
        $('#custom_information_id').val(custom_information.id);
        $('#custom_input_name').val(custom_information.custom_name);
        $(`input[name="custom_input_type"][value="${custom_information.type}"]`).prop('checked', true);
        $('#make_as_sub_team').prop('checked', custom_information.make_as_sub_team == 1);
        $('#custom_input_name').prop('readonly', custom_information.make_as_sub_team == 1);

        $('#informations-add-modal .modal-title').text('Edit Custom Input');

        if (custom_information.type == 2) {
            $('.custom-input-options').show();
            $('#option-container').empty();

            let optionsArray = [];
            try {
                optionsArray = JSON.parse(custom_information.options || '[]');
            } catch (e) {
                console.warn('Invalid options JSON:', custom_information.options);
            }

            $('#custom_input_options').val(JSON.stringify(optionsArray));
            $('#option-container').empty();

            optionsArray.forEach(function(option) {
                $('#option-container').append(`
                    <div class="option-item d-flex align-items-center mb-2">
                        <input type="text" class="form-control option-name mr-2" value="${option}" placeholder="Option Name" required />
                        <i class="fa fa-trash remove-option" aria-hidden="true" title="Remove option" style="font-size: .8rem;color:#eb9a9a;cursor:pointer"></i>
                    </div>
                `);
            });

        } else {
            $('.custom-input-options').hide();
            $('#option-container').empty();
            $('#custom_input_options').val('');
        }

        $('.save-custom-field').text('Update');
        $('#informations-add-modal').modal('show');
    }

    function add_custom_information(custom_information_id){
        $(".se-pre-con").fadeIn('slow');
          $.ajax({
              url: "{{ route('store.add_custom_information') }}",
              type: "POST",
              data: {
                  'store_id' : $('#store_id').val(),
                  'custom_information_id' : custom_information_id,
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                if(response.status == 'error'){
                    Swal.fire("Error", response.message, "error");
                }
                $(".se-pre-con").fadeOut('slow');
                custom_informationAppend();
              }
          });
    }
    $(document).ready(function() {
        $(document).on('click', '.edit-custom-info', function() {
            let dataInfo = $(this).data('info');
            edit_custom_information(dataInfo);
        });

        $(document).on('click', '.manage-custom-informations', function() {
            $(".se-pre-con").fadeIn('slow');
            custom_informationAppend();
            $('#manage-custom-informations-modal').modal('show');
        });
        $(document).on('click', '.add-custom-field', function() {
            $('#custom_information_id').val('');
            $('#custom_input_name').val('');
            $('#custom_input_options').val('');
            $('#option-container').empty();
            $('.custom-input-options').hide();
            $('.save-custom-field').text('Add');
            $('#informations-add-modal .modal-title').text('Add Custom Input');
            $('input[name="custom_input_type"]').prop('checked', false);
            $('input[name="custom_input_type"][value="1"]').prop('checked', true);
            $('#make_as_sub_team').prop('checked', false);
            $('#informations-add-modal').modal('show');
        });
        $(document).on('click', '.save-as-template', function() {
            $('#template_name').val('');
            $('#save-as-template-modal').modal('show');
        });
        $(document).on('click', '.save-template', function() {
            var templateName = $('#template_name').val().trim();
            if (templateName === '') {
                Swal.fire("Error", 'Template name is required!', "error");
                return;
            }
            $(".se-pre-con").fadeIn('slow');
            $.ajax({
                url: "{{ route('store.save_custom_information_template') }}",
                type: "POST",
                data: {
                    store_id: $('#store_id').val(),
                    template_name: templateName,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    $(".se-pre-con").show();
                },
                success: function(response) {
                    $(".se-pre-con").fadeOut('slow');
                    $('#save-as-template-modal').modal('hide');
                    Swal.fire("Success", response.message, "success");
                },
                error: function(xhr) {
                    $(".se-pre-con").fadeOut('slow');
                    let message = 'Something went wrong!';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire("Error", message, "error");
                }
            });
        });

        let previousName = '';
        $('#make_as_sub_team').on('change', function () {
            const $inputName = $('#custom_input_name');

            $inputName.prop('readonly', $(this).is(':checked'));

            if ($(this).is(':checked')) {
                previousName = $inputName.val();
                $inputName.val('Sub Team');
$inputName.prop('readonly', true);            } else {
                $inputName.val(previousName ?? '');
            }
        });


        $(document).on('change', '#use_custom_information_template', function() {
            var templateId = $(this).val();
            if (templateId) {
                $(".se-pre-con").fadeIn('slow');
                $.ajax({
                    url: "{{ route('store.load_custom_information_template') }}",
                    type: "POST",
                    data: {
                        store_id: $('#store_id').val(),
                        template_id: templateId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $(".se-pre-con").fadeOut('slow');
                        custom_informationAppend();
                        Swal.fire("Success", response.message, "success");
                    },
                    error: function(xhr) {
                        $(".se-pre-con").fadeOut('slow');
                        let message = 'Something went wrong!';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire("Error", message, "error");
                    }
                });
            }
        });

        if ($('#dropdown_input').is(':checked')) {
            $('.custom-input-options').show();
        }

        $('input[name="custom_input_type"]').change(function() {
            if ($(this).val() == '2') {
                $('.custom-input-options').slideDown();
            } else {
                $('.custom-input-options').slideUp();
            }
        });

        $(document).on('click','#custom_information-container .fa-eye, #custom_information-container .fa-eye-slash', function() {

            var $icon = $(this);
            var id = $icon.attr('value');

            if ($icon.hasClass('fa-eye')) {
                $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                remove_custom_information(id);
            } else {
                $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                add_custom_information(id);
            }
        });
    });
    $(document).ready(function() {
        $('input[name="custom_input_type"]').change(function() {
            $('#custom_input_options').val('');
            if ($(this).val() == '2') {
                $('.custom-input-options').slideDown();
            } else {
                $('.custom-input-options').slideUp();
                $('#option-container').empty();

                updateOptionsInput();
            }
        });

        $('#add-option').click(function() {
            var optionHTML = `
                <div class="option-item d-flex align-items-center mb-2">
                    <input type="text" class="form-control option-name mr-2" placeholder="Option Name" required />
                    <i class="fa fa-trash remove-option" aria-hidden="true" title="Remove option"  style="font-size: .8rem;color:#eb9a9a;cursor:pointer"></i>
                </div>`;
            $('#option-container').append(optionHTML);
        });

        $(document).on('click', '.remove-option', function() {
            $(this).closest('.option-item').remove();
            updateOptionsInput();
        });

        $(document).on('input', '.option-name', function() {
            updateOptionsInput();
        });

        function updateOptionsInput() {
            var options = [];
            $('#option-container .option-item').each(function() {
                var optionName = $(this).find('.option-name').val();
                if (optionName) {
                    options.push(optionName);
                }
            });
            $('#custom_input_options').val(JSON.stringify(options));
        }

        $('.save-custom-field').click(function() {

            $(".se-pre-con").fadeIn('slow');

            var formData = $('#add_new_custom_information').serialize();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var storeId = $('#store_id').val();
            formData += '&store_id=' + encodeURIComponent(storeId);
            formData += '&_token=' + encodeURIComponent(csrfToken);

            $.ajax({
                url: $('#add_new_custom_information').attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#informations-add-modal').modal('hide');
                    custom_informationAppend();
                },
                error: function(xhr) {
                    console.log('Form submission error:', xhr);
                    custom_informationAppend();
                }
            });
        });
    });


</script>
