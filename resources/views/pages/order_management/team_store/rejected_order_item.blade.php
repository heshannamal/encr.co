@extends('layouts.app', ['activePage' => 'team_store', 'titlePage' => __('Team Store Order Reports')])

@section('content')

<style>
    .paymentSummaryTable thead tr{
        background-color: grey;
        color: white;
        height: 40px;
        font-size: .7rem;
    }
    .paymentSummaryTable tr{
        background-color: white;
        color: grey;
        min-height: 40px;
        font-size: .7rem;
        border-bottom: 1px solid #b3b3b3;
    }
    .paymentSummaryTable{
        width: 100%;
    }
    .paymentSummaryTable th, .paymentSummaryTable td {
        padding: 10px;
    }
</style>


@section('order-header')
    <span>TEAM STORE ORDERS</span>
@endsection

@section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection

<div class="container" style="max-width: 100%;" id="DownloadArea">

    <div class="col-md-12" style="color: grey;font-size: 1.5rem;font-weight: 500;">
        #{{$order_no}}
    </div>
    <div class="col-md-12 mt-3" style="color: black;font-size: 1rem;font-weight: 500;">
        @if($type == 1)<span style="font-size: 1.2rem">Unfortunately, the Fabrics you  entered for the goods listed below are no longer available.</span><br>
        Please contact Admin if you require any other information. @elseif($type == 2)<span style="font-size: 1.2rem">
        Unfortunately, the Fabrics you entered for the goods listed below are no longer available.</span><br>
        Please contact Admin if you require any other information.
         @endif
    </div>
    <div class="col-md-12 mt-3" style="padding-bottom: 3%;">
        <table class="paymentSummaryTable">
            <thead>
                <th style="width: 35%;">PRODUCT</th>
                <th>FABRIC</th>
                <th>EMBELLISHMENT</th>
                <th class="text-center">DATE CREATED</th>
                <th class="text-center" style="width: 7%;">QTY</th>
                <th class="text-right" style="width: 10%;">UNIT PRICE</th>
            </thead>
            <tbody>
                @foreach ($missingSubProducts as $missingSubProduct)
                @php
                    $product = $products->where('id' , $missingSubProduct->product_id)->first();
                    $fabric = $fabrics->where('id' , $missingSubProduct->fabric_id)->first();
                    $embellishment = $embellishments->where('id' , $missingSubProduct->embellishment_type_id)->first();
                @endphp
                    <tr>
                        <td>{{$product->product_name}}</td>
                        <td>@if($fabric){{$fabric->fabric_name}} @else No Fabric @endif</td>
                        <td>@if($embellishment){{$embellishment->embellishment_name}} @else No Embellishment @endif</td>
                        <td class="text-center">{{$missingSubProduct->open_date}}</td>
                        <td class="text-center">{{$missingSubProduct->qty}}</td>
                        <td class="text-right">$ {{number_format($missingSubProduct->unit_price, 2)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
<div class="col-md-12" style="padding-bottom: 5%;">
    <button type="button" class="btn btn-success btn-custom ml-3" onclick="DownloadRejectItems()">Download PDF</button>
</div>

<script>
    function DownloadRejectItems() {
        var element = document.getElementById('DownloadArea');

        html2pdf(element, {
            margin: 10,
            filename: 'rejected_products.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
        });
    }
</script>

@endsection
