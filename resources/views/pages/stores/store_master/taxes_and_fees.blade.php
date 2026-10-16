@extends('layouts.app', ['activePage' => 'taxes_and_fees', 'titlePage' => __('Taxes And Fees')])

@section('content')
{{-- Taxes and fees --}}
@section('back-btn')
    <a href="" class="home-btn-color" title="Back to home">BACK TO STORES</a>
@endsection
@section('order-header')
    <span>Team Store Taxes and Fees</span>
@endsection
<style>
    .grey-text-btn{
        background-color: transparent;
        border: none;
        font-size: .7rem;
        outline: unset;
        color: grey;
        font-weight: 600;
        cursor: pointer;
    }
</style>

<div class="col-md-12">
    <input type="hidden" id="store_id" name="store_id" value="1" />
    <div class="row">
        <div class="col-md-6" style="padding-right: 7px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 header-style mb-1">
                                Taxes
                            </div>
                            <div class="col-md-4 mb-1 text-right">
                                <button type="button" class="grey-text-btn manage-taxes">MANAGE</button>
                            </div>
                            <div class="col-md-12" id="manage-taxes-area">
                                @foreach ($store->StoreAddedTaxes as $tax)
                                    <div class="container mb-2" style="background-color: #f1f1f1c4; position: relative;">
                                        <button type="button" class="close" aria-label="Close" style="position: absolute; top: 5px; right: 5px;" onclick="remove_tax({{$tax->storeTaxesDetails->id}})">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p style="color: grey;margin-bottom:.1rem;padding-top: .5rem;font-size: .8rem;">{{$tax->storeTaxesDetails->tax_name}}</p>
                                        <p style="color: #b3b3b3;margin-bottom:.1rem;padding-bottom: .5rem;    font-size: .75rem;">${{$tax->storeTaxesDetails->amount}} - {{$tax->storeTaxesDetails->type}}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-12 mt-2 mb-2 d-flex align-items-center">
                                <p class="m-0" style="font-size: .8rem;">Calculate taxes automatically</p>
                                <label class="custom-toggle ml-2 mb-0">
                                    <input type="checkbox" checked>
                                    <span class="custom-toggle-slider rounded-circle"></span>
                                </label>
                            </div>
                            <div class="col-md-12">
                                <label class="form-lable-info mb-2" style="color: grey;font-size: .8rem;">When you enable this feature, it will automatically calculate taxes per customer based on your business nexuses, product tax categories and customer information</label>
                            </div>
                            <div class="col-md-12">
                                <label class="form-lable-info mb-2" style="color: grey;font-size: .8rem;"> <span style="font-size: .9rem; font-weight:600">Please Note:</span> This feature will replace any manually-added taxes. When this feature is on, you won’t be able to add manual taxes to this store.</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.stores.modals.taxes_modal')
@endsection
