@extends('layouts.app', ['activePage'=>'pdt_design_requests','titlePage'=>__('Design Concept Request')])
@section('order-header')
    <span class="pdt-page-title">Design Concept Request</span>
@endsection
@section('content')
@php($pdtUser=auth()->user())
<link rel="stylesheet" href="{{ asset('assets/css/pdt-design-requests.css') }}?v=20261117-select2-border-11">
<main class="pdt-requests-page">
    @if(session('status'))<div class="pdt-request-notice" role="status">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="pdt-request-error" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
    <form method="get" class="pdt-request-filters pdt-studio-filters">
        <label class="pdt-search-field"><span class="pdt-sr-only">Search requests</span><input type="search" name="search" value="{{ request('search') }}" placeholder="Search by request name..." aria-label="Search requests"></label>
        <label><span class="pdt-sr-only">Status</span><select name="status" aria-label="Status"><option value="">All statuses</option>@foreach(['pending'=>'Pending','in_progress'=>'In progress','completed'=>'Completed'] as $key=>$value)<option value="{{ $key }}" @if(request('status')===$key) selected @endif>{{ $value }}</option>@endforeach</select></label>
        <button type="submit" class="pdt-request-primary"><i class="fa fa-filter" aria-hidden="true"></i> Apply Filters</button>
        <a class="pdt-reset" href="{{ route('pdt.design-requests.index') }}" aria-label="Reset filters" title="Reset filters"><i class="fa fa-refresh" aria-hidden="true"></i></a>
        @if($canCreate)<button type="button" class="pdt-request-primary pdt-new-request-button" data-open-request>+ New design request</button>@endif
    </form>
    <section aria-label="Design requests" class="pdt-request-table-wrap">
        <table class="pdt-request-table">
            <thead><tr><th>Created date</th><th>Request name</th><th>Requested by</th><th>Products</th><th>Designs</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            @forelse($requests as $request)
                <tr data-expand-request="pdt-request-{{ $request->id }}" tabindex="0" aria-expanded="false" aria-controls="pdt-request-{{ $request->id }}" aria-label="Expand request {{ $request->title }}">
                    <td data-label="Created" class="pdt-date">{{ $request->created_at->format('M d, Y') }}</td>
                    <td data-label="Request" class="pdt-request-name"><button type="button" class="pdt-inline-title" data-toggle-request="pdt-request-{{ $request->id }}" aria-expanded="false"><strong>{{ $request->title }}</strong></button><small>#{{ $request->id }}</small>@if($request->organization)<p>{{ $request->organization->organization_name }}</p>@endif
@if($request->brief)<p title="{{ $request->brief }}">{{ \Illuminate\Support\Str::limit($request->brief,100) }}</p>@endif</td>
                    <td data-label="Requested by">{{ $request->requester->name ?? 'Sales representative' }}</td>
                    <td data-label="Products"><div class="pdt-table-products">@foreach($request->items as $item)<span>{{ $item->product->product->product_name ?? 'Product #'.$item->pdt_product_id }}</span>@endforeach</div></td>
                    <td data-label="Designs"><span class="pdt-design-count">{{ $request->items->sum(function($item){return $item->designs->count();}) }}</span></td>
                    <td data-label="Status"><span class="pdt-status pdt-status-{{ $request->status }}">{{ ucfirst(str_replace('_',' ',$request->status)) }}</span></td>
                    <td data-label="Action"><a class="pdt-view-request" href="{{ route('pdt.design-requests.workspace',$request) }}" target="_blank" rel="noopener">Open ↗</a> <button type="button" class="pdt-view-request" data-toggle-request="pdt-request-{{ $request->id }}" aria-expanded="false"><i class="fa fa-chevron-down" aria-hidden="true"></i> View</button></td>
                </tr>
                <tr id="pdt-request-{{ $request->id }}" class="pdt-expanded-request" hidden><td colspan="7">
                    <section class="pdt-request-item-list" aria-label="Products for {{ $request->title }}">
                    @foreach($request->items as $item)
                        <article class="pdt-request-card pdt-product-card"><details class="pdt-product-details">
                            <summary><span>{{ $item->product->product->product_name ?? 'Product #'.$item->pdt_product_id }}</span><span>{{ $item->designs->count() }} designs ⌄</span></summary>
                            <div class="pdt-request-design-grid pdt-product-design-grid">
                            @forelse($item->designs as $design)
                                <div class="pdt-request-design"><button type="button" class="pdt-design-image" data-preview-image="{{ $design->preview_url }}" data-preview-title="{{ $design->name }}"><img src="{{ $design->preview_url }}" alt="{{ $design->name }}" loading="lazy"></button><strong>{{ $design->name }}</strong>@if($design->pivot->design_status==='needs_redesign')<span class="pdt-status pdt-status-pending">Needs redesign</span>@endif
                                    <div class="pdt-design-actions"><button type="button" data-preview-image="{{ $design->preview_url }}" data-preview-title="{{ $design->name }}">View</button>@if(Gate::check('copy pdt request designs'))<button type="button" data-copy-design="{{ $design->design_url }}">Copy link</button>@endif @if(Gate::check('redesign pdt request designs'))<form method="post" action="{{ route('pdt.design-requests.redesign',[$request,$item,$design->id]) }}">@csrf @method('PATCH')<button type="submit" @if($design->pivot->design_status==='needs_redesign') disabled @endif>Redesign</button></form>@endif</div>
                                </div>
                            @empty<div class="pdt-request-empty-design">No designs added yet.</div>@endforelse
                            </div>
                        </details></article>
                    @endforeach
                    </section>
                    @if($manager)<a class="pdt-view-request" href="{{ route('pdt.design-requests.show',$request) }}">Manage designs and status →</a>@endif
                </td></tr>
            @empty
                <tr><td colspan="7" class="pdt-table-empty">No design requests found. @if($canCreate)Create a request to choose your products.@endif</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>
    {{ $requests->links() }}
    @if($canCreate)
    <dialog class="pdt-request-dialog" id="pdtNewRequest" aria-labelledby="pdtNewRequestTitle">
        <form method="post" action="{{ route('pdt.design-requests.store') }}">@csrf
            <header><h2 id="pdtNewRequestTitle">New design request</h2><button type="button" data-close-dialog aria-label="Close">×</button></header>
            <label>Request title<input name="title" maxlength="180" value="{{ old('title') }}" required placeholder="For example: New season basketball designs"></label>
            <label for="pdtRequestOrganization">Organization <span class="pdt-request-muted">(optional)</span></label>
            <select id="pdtRequestOrganization" name="organization_id" data-request-organization style="width:100%"><option value="">Without organization</option>@foreach($organizations as $organization)<option value="{{ $organization->id }}" @if(old('organization_id') == $organization->id) selected @endif>{{ $organization->organization_name }}</option>@endforeach</select>
            <label>Design brief<textarea name="brief" rows="4" maxlength="10000" placeholder="Colors, theme, logos, or other requirements">{{ old('brief') }}</textarea></label>
            <label>Choose products<input type="search" data-product-search placeholder="Search available products"></label>
            <div class="pdt-request-product-options">@forelse($products as $product)
                <label data-product-option><input type="checkbox" name="products[]" value="{{ $product->id }}" @if(in_array($product->id,old('products',[]))) checked @endif><span>{{ $product->product->product_name ?? 'Product #'.$product->id }}</span></label>
            @empty<p>No active PDT products are available. Add products to PDT first.</p>@endforelse</div>
            <p class="pdt-request-muted" data-product-count>Choose at least one product.</p>
            <footer><button type="button" data-close-dialog>Cancel</button><button type="submit" class="pdt-request-primary" @if($products->isEmpty()) disabled @endif>Send design request</button></footer>
        </form>
    </dialog>
    @endif
    <dialog class="pdt-request-dialog pdt-image-dialog" id="pdtImagePreview" aria-labelledby="pdtPreviewTitle"><header><h2 id="pdtPreviewTitle">Design preview</h2><button type="button" data-close-dialog aria-label="Close">×</button></header><img data-preview-full alt=""></dialog>
</main>
<script src="{{ asset('assets/js/pdt-design-requests.js') }}?v=20261117-select2-border-11" defer></script>
@if($errors->has('organization_id') || $errors->has('title') || $errors->has('products') || $errors->has('products.*') || $errors->has('brief'))<script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('pdtNewRequest')?.showModal();});</script>@endif
@endsection
