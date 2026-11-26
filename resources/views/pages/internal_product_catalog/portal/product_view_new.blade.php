@extends('layouts.app', ['activePage' => 'product_catalog', 'titlePage' => __('Product Catalog')])

@section('content')


@section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">
        BACK TO HOME
    </a>
@endsection

@section('order-header')
    <span>PRODUCT CATALOG</span>
@endsection

<div>
    @include('pages.customer_product_catlog.product_catlog.product_view')
</div>

@endsection
