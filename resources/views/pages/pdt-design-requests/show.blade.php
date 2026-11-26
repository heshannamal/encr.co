@extends('layouts.app', ['activePage'=>'pdt_design_requests','titlePage'=>__('Design Concept Request')])
@section('back-btn')
    <a href="{{ route('pdt.design-requests.index') }}" class="home-btn-color" title="Back to design requests">BACK</a>
@endsection
@section('back-btn-Mobile')
    <a href="{{ route('pdt.design-requests.index') }}" class="home-btn-color" title="Back to design requests">BACK</a>
@endsection
@section('order-header')
    <span class="pdt-page-title">Design Concept Request</span>
@endsection
@section('content')
@php($pdtUser=auth()->user())
<link rel="stylesheet" href="{{ asset('assets/css/pdt-design-requests.css') }}?v=20261117-organization-10">
<main class="pdt-requests-page pdt-detail-page">
    @if(session('status'))<div class="pdt-request-notice" role="status">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="pdt-request-error" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
    <section class="pdt-detail-overview">
    <header class="pdt-request-heading"><div><small>REQUEST #{{ $designRequest->id }}</small><h1>{{ $designRequest->title }}</h1><p>Requested by {{ $designRequest->requester->name ?? 'Sales representative' }} · {{ $designRequest->created_at->format('d M Y, H:i') }}</p>@if($designRequest->organization)<p>Organization: <strong>{{ $designRequest->organization->organization_name }}</strong></p>@endif</div><span class="pdt-status pdt-status-{{ $designRequest->status }}">{{ ucfirst(str_replace('_',' ',$designRequest->status)) }}</span></header>
    @if($designRequest->brief)<section class="pdt-detail-brief"><h2>Design brief</h2><p class="pdt-request-full-brief">{{ $designRequest->brief }}</p></section>@endif
    @if($manager)
        <div class="pdt-request-workflow">
            @if($designRequest->status==='completed')
                <p>Completed {{ optional($designRequest->completed_at)->format('d M Y, H:i') }}. Reopen to change selected designs.</p>
                @if(Gate::check('reopen pdt request designs'))<form method="post" action="{{ route('pdt.design-requests.status',$designRequest) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="in_progress"><button type="submit">Reopen request</button></form>@endif
            @else
                <p>Add designs for each product, then mark this request complete.</p>
                @if($designRequest->status==='pending' && Gate::check('start pdt request designs'))<form method="post" action="{{ route('pdt.design-requests.status',$designRequest) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="in_progress"><button type="submit">Start request</button></form>@endif
                @if(Gate::check('complete pdt request designs'))<form method="post" action="{{ route('pdt.design-requests.status',$designRequest) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="completed"><button type="submit" class="pdt-request-primary">Mark complete</button></form>@endif
            @endif
        </div>
    @endif
    </section>
    <div class="pdt-products-heading"><div><h2>Product designs</h2><p>Choose a product to view its designs.</p></div><span>{{ $designRequest->items->count() }} products · {{ $designRequest->items->sum(function($item){return $item->designs->count();}) }} designs</span></div>
    <section class="pdt-request-item-list" aria-label="Requested products">
        @foreach($designRequest->items as $item)
        <article class="pdt-request-card pdt-product-card">
            <details class="pdt-product-details" open>
            <summary><span>{{ $item->product->product->product_name ?? 'Product #'.$item->pdt_product_id }}</span><span>{{ $item->designs->count() }} designs <span aria-hidden="true">⌄</span></span></summary>
            <div class="pdt-request-card-top pdt-product-tools"><span>Selected designs</span>
                @if($manager && Gate::check('add pdt request designs') && $designRequest->status!=='completed')<button type="button" class="pdt-request-add" data-design-picker data-gallery="{{ route('pdt.design-requests.designs',[$designRequest,$item]) }}" data-add-url="{{ route('pdt.design-requests.add-designs',[$designRequest,$item]) }}" data-product-name="{{ $item->product->product->product_name ?? 'Product' }}" data-designer-url="{{ rtrim(config('pdt.public_url'),'/').'/designer/'.$item->pdt_product_id }}" aria-label="Add designs for {{ $item->product->product->product_name ?? 'this product' }}"><span aria-hidden="true">+</span> Add designs</button>@endif
            </div>
            <div class="pdt-request-design-grid pdt-product-design-grid">@forelse($item->designs as $design)
                <div class="pdt-request-design"><button type="button" class="pdt-design-image" data-preview-image="{{ $design->preview_url }}" data-preview-title="{{ $design->name }}"><img src="{{ $design->preview_url }}" alt="{{ $design->name }}" loading="lazy"></button><strong>{{ $design->name }}</strong>@if($design->pivot->design_status==='needs_redesign')<span class="pdt-status pdt-status-pending">Needs redesign</span>@endif
                    <div class="pdt-design-actions"><button type="button" data-preview-image="{{ $design->preview_url }}" data-preview-title="{{ $design->name }}">View</button>@if(Gate::check('copy pdt request designs'))<button type="button" data-copy-design="{{ $design->design_url }}">Copy link</button>@endif @if(Gate::check('redesign pdt request designs'))<form method="post" action="{{ route('pdt.design-requests.redesign',[$designRequest,$item,$design->id]) }}">@csrf @method('PATCH')<button type="submit" @if($design->pivot->design_status==='needs_redesign') disabled @endif>Redesign</button></form>@endif</div>
                    @if($manager && Gate::check('remove pdt request designs') && $designRequest->status!=='completed')<form method="post" action="{{ route('pdt.design-requests.remove-design',[$designRequest,$item,$design->id]) }}">@csrf @method('DELETE')<button type="submit">Remove</button></form>@endif
                </div>
            @empty<div class="pdt-request-empty-design"><span class="pdt-empty-icon" aria-hidden="true">▧</span><strong>No designs selected</strong><span>@if($manager && Gate::check('add pdt request designs') && $designRequest->status!=='completed')Use Add designs to choose designs for this product.@else Designs will appear here when the design team adds them.@endif</span></div>@endforelse</div>
            </details>
        </article>
        @endforeach
    </section>
    @if($manager)
    <dialog class="pdt-request-dialog pdt-design-picker" id="pdtDesignPicker" aria-labelledby="pdtDesignPickerTitle" data-csrf="{{ csrf_token() }}">
        <header><div><h2 id="pdtDesignPickerTitle">Choose designs</h2><p data-picker-product></p></div><button type="button" data-close-dialog aria-label="Close">×</button></header>
        <form data-design-search><label>Search designs<input name="search" type="search" placeholder="Design name"></label><button type="submit">Search</button></form>
        <p data-picker-error class="pdt-request-error" role="alert" hidden></p>
        <div data-picker-grid class="pdt-request-design-grid"></div>
        <button type="button" data-load-more hidden>Load more</button>
        <footer><a data-open-designer target="_blank" rel="noopener noreferrer">Create a new design ↗</a><span data-picked-count>0 selected</span><button type="button" data-add-designs class="pdt-request-primary" disabled>Add selected designs</button></footer>
    </dialog>
    @endif
    <dialog class="pdt-request-dialog pdt-image-dialog" id="pdtImagePreview" aria-labelledby="pdtPreviewTitle"><header><h2 id="pdtPreviewTitle">Design preview</h2><button type="button" data-close-dialog aria-label="Close">×</button></header><img data-preview-full alt=""></dialog>
</main>
<script src="{{ asset('assets/js/pdt-design-requests.js') }}?v=20261117-organization-10" defer></script>
@endsection
