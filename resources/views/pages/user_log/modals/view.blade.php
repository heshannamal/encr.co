<div class="modal fade" id="viewUserLogModal" tabindex="-1" role="dialog" aria-labelledby="viewUserLogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered user-log-modal-dialog" role="document">
        <div class="modal-content border-0 rounded-3">
            <div class="modal-header user-log-modal-header">
                <div class="user-log-title-wrap">
                    <div class="user-log-icon">
                        <i class="fas fa-history"></i>
                    </div>

                    <div>
                        <h5 class="modal-title" id="viewUserLogModalLabel">
                            View User Log Details
                        </h5>
                        <small>Review changes made to this record</small>
                    </div>
                </div>

                <button type="button" class="close user-log-header-close"
                        data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="user_log_detail_modal_body">
                {{-- <div class="row gy-5">
                    <div class="col ps-md-5">
                        <h6>Name</h6>
                        <hr>
                        <div class="row gx-2 gy-4">
                            <div class="col-md-2 text-end" style="padding-right: 2rem;"> Old : </div>
                            <div class="col-md-10"> Perera </div>
                        </div>
                        <div class="row gx-2 gy-4 mb-5">
                            <div class="col-md-2 text-end" style="padding-right: 2rem;"> New : </div>
                            <div class="col-md-10"> Fernando </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="modal-footer">
                <div class="row mb-3 gy-3 justify-content-center">
                    <div class="col-6 col-xl-auto" style="display: flex;">
                        <button type="button" type="reset" class="btn btn-light close view_close_btn" data-dismiss="modal" style="margin: calc(var(--bs-modal-footer-gap) * .5);">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('body').on('click', '.view_close_btn', function(){
        $('#viewUserLogModal').modal('hide');
    });
</script>
