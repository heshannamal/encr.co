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
        var item_id = $(this).val();
        var order_id = $('#order_id').val();
        var copied_item_id = localStorage.getItem('copied_item_id');

        $.ajax({
            url: '{{ url("roster/paste_roster") }}',
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
                    window.location.href = "{{ url('roster') }}/" + order_id + '?active_tab=' + item_id;
                }
            }
        });
    });
</script>

