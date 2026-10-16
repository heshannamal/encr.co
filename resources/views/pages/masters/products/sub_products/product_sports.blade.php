@extends('layouts.app', ['activePage' => 'product_sports', 'titlePage' => __('Product Sports')])

@section('content')

<style>
    .se-pre-con {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffffcc;
        display: none;
    }
    .table_header_text {
        color: white;
        font-weight: 600;
        text-align: center;
        background-color: rgba(50, 50, 50, 1) !important;
    }
    .save-icon {
        cursor: pointer;
        color: #47D6B6;
        font-size: 18px;
        transition: all 0.2s ease-in-out;
    }
    .save-icon:hover {
        color: #2cbda4;
        transform: scale(1.1);
    }
    .filter_div {
        margin: 20px 0;
        padding: 15px;
        background: #f9fafb;
        border-radius: 8px;
    }
    .table td {
        padding: 0;
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>PRODUCT SPORTS</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="card shadow-sm p-3">
        <button class="btn export-csv-btn ml-auto mb-2 mr-0" id="export_csv" style="max-width: 10rem;padding: .4rem .5rem;background-color: #47D6B6;color: white;border-radius: 0rem;" title="Export to CSV">
            <i class="fas fa-file-csv"></i> Export to CSV
        </button>
        <div class="">
            <table id="product_sport_table" class="table table-responsive table-bordered table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th class="table_header_text">PRODUCT NO</th>
                        <th class="table_header_text">PRODUCT NAME</th>
                        <th class="table_header_text">PATTERN CODE</th>
                        <th class="table_header_text">ADDED SPORTS</th>
                        <th class="table_header_text">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="text-center">{{ $product->product_no }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td class="text-center">{{ $product->pattern_code }}</td>
                            <td style="min-width: 250px;">
                                <select class="select2-sports form-control"
                                    multiple
                                    data-product-id="{{ $product->id }}">
                                    @foreach ($sports as $sport)
                                        <option
                                            value="{{ $sport->id }}"
                                            @if($product->productsport->pluck('sport_id')->contains($sport->id)) selected @endif>
                                            {{ $sport->sport_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-link save-icon" data-id="{{ $product->id }}" title="Save Sports" disabled>
                                    <i class="fas fa-save"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    const table = $('#product_sport_table').DataTable({
        pageLength: 25,
        responsive: true,
        autoWidth: false,
        ordering: false,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search products...",
            lengthMenu: "Show _MENU_ entries",
        },
        columnDefs: [
            { targets: [0, 2, 4], className: 'text-center align-middle' },
            { targets: '_all', className: 'align-middle' },
        ],
        drawCallback: function() {
            $('.select2-sports').select2({ width: '100%' });
        }
    });


    $('.select2-sports').select2({ width: '100%' });

    $(document).on('change', '.select2-sports', function () {
        $(this).closest('tr').find('.save-icon').prop('disabled', false);
    });

    $(document).on('click', '.save-icon', function () {
        const productId = $(this).data('id');
        const sports = $(this).closest('tr').find('.select2-sports').val();

        $.ajax({
            url: "{{ route('update.product.sports') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                sports: sports
            },
            beforeSend: function () {
                $('.se-pre-con').fadeIn('fast');
            },
            success: function (res) {
                $('.se-pre-con').fadeOut('fast');
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saved!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $(`button.save-icon[data-id='${productId}']`).prop('disabled', true);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message,
                    });
                }
            },
            error: function () {
                $('.se-pre-con').fadeOut('fast');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving. Please try again.',
                });
            }
        });
    });
    $('#export_csv').on('click', function () {
        $.ajax({
            url: "{{ route('export.product.sports.csv') }}",
            type: "GET",
            xhrFields: {
                responseType: 'blob'
            },
            beforeSend: function () {
                $('.se-pre-con').fadeIn('fast');
            },
            success: function (data) {
                $('.se-pre-con').fadeOut('fast');
                const blob = new Blob([data], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', 'product_sports.csv');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function () {
                $('.se-pre-con').fadeOut('fast');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while exporting. Please try again.',
                });
            }
        });
    });

});
</script>
@endsection
