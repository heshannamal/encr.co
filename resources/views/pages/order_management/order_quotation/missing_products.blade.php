@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Orders')])

@section('content')

<style>
    .missing-produc-style table thead tr{
        background-color: rgba(50, 50, 50, 1);
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .missing-produc-style table tr{
        background-color: white;
        color: rgba(22, 22, 23, 1);
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .missing-produc-style th, .missing-produc-style td {
        padding: 10px;
    }
    .missing-produc-style .dataTables_info {
        color:#b3b3b3;
    }
    .missing-produc-style .select2-container--default{
        width: 80% !important;
    }
    .select2-container--default .select2-selection--single {
        background-color: transparent !important;
    }
</style>


@section('order-header')
    <span>RE-ORDER</span>
@endsection

@section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection

<div class="container" style="max-width: 100%;" id="DownloadArea">

    <div class="col-md-12" style="color: grey;font-size: 1.5rem;font-weight: 500;">
    </div>
    <div class="col-md-12 mt-3" style="color: black;font-size: 1rem;font-weight: 500;">
        <span style="font-size: 1.2rem">Unfortunately, the Fabrics you  re-ordered for the goods listed below are deactivated.</span><br>
        Please select existing product or contact Admin if you require any other information.
    </div>
    <div class="col-md-12 mt-3" style="padding-bottom: 3%;">
        <form action="{{ route('missing_reorder.products_update') }}" method="post">
            @csrf
            <div class="table-responsive missing-produc-style">
                <table class="missing-products-table" style="width: 100%;">
                    <thead>
                        <th class="text-center">Item</th>
                        <th class="text-left">Product</th>
                        <th class="text-left">Product Status</th>
                        <th class="text-center" style="width: 7%;">Qty</th>
                        <th class="text-right" style="width: 10%;">Unit Price</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item['item']->item_no}}</td>
                                <td>
                                    <select class="invoice-inputs border-style product-select2" name="order_items[{{$item['item']->id}}][sub_product_no]" id="sub_product_no_{{$item['item']->id}}">
                                        @foreach ($item['sub_products'] as $sub_product)
                                            <option value="{{ $sub_product->sub_product_no }}" data-sub_product_active="{{$sub_product->active}}" data-sub_product_price="{{$sub_product->default_price}}"
                                                @if ($sub_product->sub_product_no == $item['item']->sub_product_no)
                                                    selected
                                                @endif>
                                                {{ $sub_product->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    @php
                                        $subProduct = $item['sub_products']->where('sub_product_no', $item['item']->sub_product_no)->first();
                                    @endphp

                                    <span class="badge badge-pill badge-success" style="display: {{$subProduct->active == 1 ? 'block' : 'none'}};width: fit-content;">Active</span>
                                    <span class="badge badge-pill badge-danger" style="display: {{$subProduct->active == 1 ? 'none' : 'block'}};width: fit-content;">Inactive</span>

                                </td>
                                <td class="text-center">{{$item['item']->qty}}</td>
                                <td class="text-right default_price">$ {{number_format($item['item']->unit_price, 2)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-12 text-right mt-3">
                    <button type="submit" class="btn btn-success btn-custom ml-3">SAVE CHANGES</button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('.product-select2').select2();
        $('.missing-products-table').DataTable({
            "paging": false,
            "searching": false,
            "info": false,
            "ordering": false
        });
        $('.product-select2').on('change', function() {
            var activeStatus = $(this).find(':selected').data('sub_product_active');
            var default_price = $(this).find(':selected').data('sub_product_price');
            var $row = $(this).closest('tr');

            $row.find('.default_price').text('$ '+default_price);

            if (activeStatus == 1) {
                $row.find('.badge-success').show();
                $row.find('.badge-danger').hide();
            } else {
                $row.find('.badge-success').hide();
                $row.find('.badge-danger').show();
            }
        });
    });
</script>

@endsection
