<div class="modal fade" id="manage-taxes-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="min-height: 80vh;">
        <div class="modal-header" style="padding: .95rem .95rem .75rem 1.5rem;;background-color: #f1f1f1;">
          <h5 class="modal-title" style="font-size: 1.3rem;color: grey;">taxes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="tax-container">
            <div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" style="background-color: #8cd4ef;color:white" class="btn btn-secondary" data-dismiss="modal">Done</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function taxAppend(){
          $.ajax({
              url: "{{ route('store.get_store_taxes') }}",
              type: "GET",
              data: {
                  'id' : $('#store_id').val(),
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                console.log(response);
                  $('#tax-container').empty();
                  $('#manage-taxes-area').empty();
                  response.store_taxes_all.forEach(element => {
                      var className = response.store_taxes.map(String).includes(String(element.id)) ? 'fa-eye' : 'fa-eye-slash';

                      var content = `<div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                      <div class="row">
                                          <div class="col-md-2 d-flex align-items-center">
                                              <i class="fa ${className}" aria-hidden="true" style="font-size: 1.5rem;color:black;cursor:pointer" value="${element.id}"></i>
                                          </div>
                                          <div class="col-md-10">
                                              <p style="color: grey; margin-bottom: .1rem; padding-top: .5rem; font-size: .8rem;">${element.tax_name}</p>
                                              <p style="color: #b3b3b3; margin-bottom: .1rem; padding-bottom: .5rem; font-size: .75rem;">$${element.amount} - ${element.type}</p>
                                          </div>
                                      </div>
                                   </div>`;

                      $('#tax-container').append(content);

                      if(response.store_taxes.map(String).includes(String(element.id))){
                        var cardContent = `<div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                                <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;" onclick="remove_tax(${element.id})">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;font-size: .8rem;">${element.tax_name}</p>
                                                <p style="color: #b3b3b3;margin-bottom:.1rem;padding-bottom: .5rem;    font-size: .75rem;">$${element.amount} - ${element.type}</p>
                                            </div>`;
                        $('#manage-taxes-area').append(cardContent);
                      }

                  });
              }

          });
          $(".se-pre-con").fadeOut('slow');
    }
    function remove_tax(tax_id){
        $(".se-pre-con").fadeIn('slow');
          $.ajax({
              url: "{{ route('store.remove_tax') }}",
              type: "POST",
              data: {
                  'store_id' : $('#store_id').val(),
                  'tax_id' : tax_id,
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                $(".se-pre-con").fadeOut('slow');
                taxAppend();
              }
          });
    }
    function add_tax(tax_id){
        $(".se-pre-con").fadeIn('slow');
          $.ajax({
              url: "{{ route('store.add_tax') }}",
              type: "POST",
              data: {
                  'store_id' : $('#store_id').val(),
                  'tax_id' : tax_id,
                  "_token": "{{ csrf_token() }}"
              },
              success: function(response) {
                $(".se-pre-con").fadeOut('slow');
                taxAppend();
              }
          });
    }
    $(document).ready(function() {

        $(document).on('click', '.manage-taxes', function() {
            $(".se-pre-con").fadeIn('slow');
            taxAppend();
            $('#manage-taxes-modal').modal('show');
        });

        $(document).on('click','#tax-container .fa-eye, #tax-container .fa-eye-slash', function() {

            var $icon = $(this);
            var id = $icon.attr('value');

            if ($icon.hasClass('fa-eye')) {
                $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                remove_tax(id);
            } else {
                $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                add_tax(id);
            }
        });
    });
</script>
