@section('stores_header')

<style>
    /* Top header */
.store_name {
    font-size: 27px;
}
.status {
    font-size: 12px;
    margin-right: 15px;
    margin-left: 0px;
    width: 58px;
    text-align: center;
    border-radius: 16px;
    line-height: 1.7;
    height: 27px;
    padding-top: 3px;
    margin-top: 5px;
}

.status.open {
    background-color: rgba(199, 249, 123, 0.7);
    color: rgb(0, 101, 0);
}
.status.archived {
    color: white;
    background-color:#b3b3b3
}
.status.closed {
    color: white;
    background-color:rgb(223 22 22 / 70%)
}
.copy_link_btn {
    background-color: transparent;
    border: unset;
    cursor: pointer;
    margin-top: 6px;
    font-size: 10px;
    font-weight: 600;
    color: #B3B3B3;
}
.copy_btn_div {
    text-align: center;
    padding: unset;
}
.edit_store_btn {
    background-color: transparent;
    color: #B3B3B3;
    border: 1px solid #B3B3B3;
    width: 110px;
    height: 33px;
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
}
.view_store_btn {
    background-color: #47D6B6;
    color: white;
    border: unset;
    width: auto;
    height: 33px;
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
}
/* End Top header */

/* ===== Mobile-only overrides (does not affect PC view) ===== */
@media (max-width: 767px) {
    .store_header_wrap {
        margin-top: 44px !important;
        padding-top: 0 !important;
        background: #fff;
        border-radius: 14px;
        padding: 16px !important;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }
    .store_header_wrap .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    /* Title row: status pill inline with name, like Figma */
    .store_header_wrap > .row > div:first-child .row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .store_header_wrap .status {
        margin: 0;
        width: auto;
        padding: 3px 14px;
        height: auto;
        line-height: 1.6;
        border-radius: 20px;
        order: 2;
    }
    .store_header_wrap .status.open {
        background-color: rgba(71, 214, 182, 0.15);
        color: #17a589;
    }
    .store_header_wrap .status.closed {
        background-color: rgba(223, 22, 22, 0.12);
        color: #df1616;
    }
    .store_header_wrap .store_name {
        font-size: 17px;
        line-height: 1.3;
        order: 1;
    }

    /* Button area -> 2x2 grid + full width View Store, like Figma card */
    .store_header_wrap .ml-auto {
        width: 100%;
        text-align: left !important;
        margin-top: 14px;
    }
    .store_header_wrap .ml-auto > .row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin: 0 !important;
    }
    .store_header_wrap .copy_btn_div,
    .store_header_wrap .ml-auto > .row > div {
        margin: 0 !important;
        width: 100%;
    }
    .store_header_wrap .edit_store_btn {
        width: 100%;
        height: 40px;
        border-radius: 8px;
        border: 1px solid #E5E5E5;
        background-color: #F7F7F7;
        color: #9A9A9A;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .store_header_wrap #close_store_button {
        background-color: #F0F0F0;
        color: #B3B3B3;
    }
    .store_header_wrap .ml-auto > .row > div:last-child {
        grid-column: 1 / -1;
        width: 100% !important;
        text-align: left !important;
        margin: 0 !important;
    }
    .store_header_wrap .view_store_btn {
        display: flex !important;
        width: 100% !important;
        max-width: 100%;
        height: 44px;
        border-radius: 8px;
        font-size: 13px;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 2px;
        box-sizing: border-box;
    }
}
</style>

@section('back-btn')
    <a href="{{ route('stores') }}" class="home-btn-color" title="Back to overview">BACK TO TEAM STORES</a>
@endsection

<div class="col-lg-12 mt-4 store_header_wrap">
    <div class="row">
        <div class="">
            <div class="row" style="margin-left: unset;">
                @if ($store->store_status == 1)
                    <p class="status open">Open</p>
                @elseif ($store->store_status == 3)
                    <p class="status archived">Archived</p>
                @else
                    <p class="status closed">Closed</p>
                @endif
                <strong class="store_name">{{$store->store_name}}</strong>
            </div>
        </div>

        <div class="ml-auto" style="text-align: right">
            <div class="row" style="margin: 0;">
                <div class=" copy_btn_div" style="display:flex">
                    <button type="button" class="edit_store_btn" id="close_store_button" data-store-id="{{ $store->id }}"><i class="fa fa-times" aria-hidden="true"></i> CLOSE</button>
                </div>
                <div class="copy_btn_div" style="text-align: center; margin-left: 5px; margin-right: 5px;">
                    @if ($store->store_status == 3)
                        <button type="button" class="edit_store_btn unarchive_store" data-store_id="{{ $store->id }}">
                            <i class="fa fa-archive" aria-hidden="true"></i> ARCHIVE
                        </button>
                    @else
                        <button type="button" class="edit_store_btn archive_store" data-store_id="{{ $store->id }}">
                            <i class="fa fa-archive" aria-hidden="true"></i> ARCHIVE
                        </button>
                    @endif
                </div>
                <div class="copy_btn_div" style="text-align: center; margin-left: 5px; margin-right: 5px;">
                    <button type="button" class="edit_store_btn" onclick="confirmCopy('{{ route('store.copy', ['id' => $store->id]) }}')">
                        <i class="fa fa-clone" aria-hidden="true"></i> COPY
                    </button>
                </div>
                <div class=" copy_btn_div" style="text-align: center; margin-left: 5px; margin-right: 5px;">
                    <button type="button" class="edit_store_btn" onclick="window.location.href='{{ route('store.edit', ['id' => $store->id]) }}'">
                        <i class="fa fa-pencil" aria-hidden="true"></i> EDIT
                    </button>
                </div>
                <div class="" style="text-align: center; margin-right: 5px;">
                    <button type="button" class="view_store_btn" onclick="window.open('{{ makeStoreDomainRoute($store->direct_access_url) }}?is-authenticated=true', '_blank')">
                        <i class="fa fa-arrow-up-from-bracket" aria-hidden="true"></i> VIEW STORE
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.archive_store').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'Archiving this store will remove it from your store listing and close it for sales. Would you like to proceed?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, archive it',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('store.archive_store') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            store_id: $(this).data('store_id')
                        },
                        success: function (response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Archived!',
                                    'The store has been archived.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while archiving the store.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
        $('.unarchive_store').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to unarchive this store? It will be restored to your store listing.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, unarchive it',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('store.unarchive_store') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            store_id: $(this).data('store_id')
                        },
                        success: function (response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Unarchived!',
                                    'The store has been unarchived.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while archiving the store.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
        $('#close_store_button').on('click', function () {
            const storeId = $(this).data('store-id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will close the store. Do you want to proceed?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, close it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    $('.se-pre-con').fadeIn('slow');
                    $.ajax({
                        url: "{{ route('store.close_store') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            store_id: storeId
                        },
                        success: function (response) {
                            $('.se-pre-con').fadeOut('slow');
                            if (response.status === 'success') {
                                Swal.fire('Closed!', response.message, 'success').then(() => {
                                    $('.se-pre-con').fadeIn('slow');
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function (xhr) {
                            $('.se-pre-con').fadeOut('slow');
                            Swal.fire('Error!', 'An error occurred while closing the store.', 'error');
                        }
                    });
                }
            });
        });
    });


    function confirmCopy(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to copy this store?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, copy it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                window.open(url);
            }
        });
    }

</script>

@endsection