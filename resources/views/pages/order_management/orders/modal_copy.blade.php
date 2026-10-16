{{-- <div class="modal fade" id="modal_copy" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-default">Copy Roster</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <button type="button" class="btn btn-info btn-sm btn-"></button>
            </div>
        </div>
    </div>
</div> --}}

<script>
    $('document').ready(function(){
        var copied_item_id = localStorage.getItem('copied_item_id');
        if (copied_item_id > 0) {
            $('.roster-paste').show();
        } else {
            $('.roster-paste').hide();
        }
    });

    $('body').on('click', '.roster-copy', function(){
        var item_id = $(this).val();
        localStorage.setItem('copied_item_id', item_id);

        Swal.fire({
            title: "Coped!",
            type: "success",
            allowOutsideClick: false,
            showConfirmButton: false,
            timer: 1000
        });

        $('.roster-paste').show(700);
    });

    $('body').on('click', '.roster-paste', function(){

        $("#orderItemSaveBtn").click();

        var item_id = $(this).val();
        var order_id = $('#order_id').val();
        var copied_item_id = localStorage.getItem('copied_item_id');

        $.ajax({
            url: '{{ url("order_details/paste_roster") }}',
            type: "POST",
            dataType: 'json',
            data: {
                'order_id': order_id, 'item_id': item_id, 'copied_item_id': copied_item_id, '_token':'{{csrf_token()}}'
            },
            beforeSend: function () {
                $(".se-pre-con").fadeIn('slow');
            },
            success: function(data) {
                console.log(data);

                if (data == 'no_size') {
                    $(".se-pre-con").fadeOut('slow');

                    Swal.fire({
                        title: "Sizes do not match!",
                        text: "To copy & paste a roster, both items must have the same product size (eg: YS-XXXL, Socks or N/A)",
                        type: "warning",
                        allowOutsideClick: false,
                    });
                } else {
                    // $('.roster-paste').hide(700);
                    // localStorage.setItem('copied_item_id', 0);
                    // window.location.href = "{{ url('order_details/edit') }}/" + order_id + '?active_tab=' + item_id;
                    window.location.reload();
                }
            }
        });
    });
</script>

