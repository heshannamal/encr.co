@extends('layouts.app',['activePage'=>'pdt_design_settings','titlePage'=>__('PDT Design Settings')])
@section('order-header')<span>PDT Design Settings</span>@endsection
@section('back-btn')<a class="home-btn-color" href="{{ $selected?route('pdt.design-settings.index'):route('home') }}">BACK</a>@endsection
@section('back-btn-Mobile')<a class="home-btn-color" href="{{ $selected?route('pdt.design-settings.index'):route('home') }}">BACK</a>@endsection
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/pdt-design-settings.css') }}?v={{ is_file(base_path('assets/css/pdt-design-settings.css')) ? filemtime(base_path('assets/css/pdt-design-settings.css')) : '20261120-table-2' }}">
<main class="pds-page">
@if(session('status'))<div class="pds-notice" role="status">{{ session('status') }}</div>@endif
@if($errors->any())<div class="pds-error">{{ $errors->first() }}</div>@endif
@if(!$selected)
<h2>PDT products</h2><p class="pds-muted">Choose a product to manage its designs.</p><input type="search" id="pdsProductSearch" placeholder="Search products..." aria-label="Search products">
<div class="pds-table-wrap"><table class="pds-product-table"><thead><tr><th>Product</th><th>Design count</th><th>Last updated</th><th>Status</th><th>Action</th></tr></thead><tbody>
@forelse($products as $product)<tr data-product-name="{{ strtolower($product->product->product_name ?? '') }}"><td><a href="{{ route('pdt.design-settings.product',$product->id) }}"><strong>{{ $product->product->product_name ?? 'Product #'.$product->id }}</strong></a></td><td><span class="pds-count">{{ $product->design_count }}</span></td><td>{{ $product->updated_at ? $product->updated_at->format('M d, Y · H:i') : '—' }}</td><td><span class="pds-product-status {{ $product->active?'is-active':'is-inactive' }}">{{ $product->active?'Active':'Inactive' }}</span></td><td><a class="pds-view-link" href="{{ route('pdt.design-settings.product',$product->id) }}">View designs →</a></td></tr>
@empty<tr><td colspan="5" class="pds-muted">No PDT products found.</td></tr>@endforelse
</tbody></table></div>
<p class="pds-muted">Design counts exclude soft-deleted designs.</p>
@else
<header class="pds-heading"><div><h2>{{ $selected->product->product_name ?? 'Product #'.$selected->id }}</h2><p class="pds-muted">Manage visibility and deleted designs. Customer copies are never listed publicly.</p></div><a href="{{ route('pdt.design-settings.index') }}">Change product</a></header>
<form class="pds-filters" method="get"><input name="search" value="{{ request('search') }}" placeholder="Search designs..."><select name="status">@foreach([''=>'Active designs','visible'=>'Shown in product','hidden'=>'Hidden designs','deleted'=>'Deleted designs'] as $key=>$label)<option value="{{ $key }}" @if(request('status','')===$key) selected @endif>{{ $label }}</option>@endforeach</select><button type="submit">Apply filters</button></form>
<div class="pds-grid">@forelse($designs as $design)
<button type="button" class="pds-card" data-open-design="pds-design-{{ $design->id }}"><img src="{{ $design->preview_url }}" alt="{{ $design->name }}" loading="lazy"><strong>{{ $design->name }}</strong><span class="pds-muted">#{{ $design->id }} · {{ $design->trashed()?'Deleted':(!$design->is_admin_created?'Customer copy':($design->show_in_product?'Shown in product':'Hidden')) }}</span></button>
<dialog class="pds-dialog" id="pds-design-{{ $design->id }}"><header><h3>{{ $design->name }}</h3><button type="button" data-close aria-label="Close">×</button></header><img src="{{ $design->preview_url }}" alt="{{ $design->name }}"><p class="pds-muted">Design #{{ $design->id }}</p>
@if($design->trashed())
<p>This design is soft deleted. Restore it to make it available again.</p>@if(Gate::check('restore pdt designs'))<form method="post" action="{{ route('pdt.design-settings.restore',$design->id) }}">@csrf<button type="submit">Restore design</button></form>@endif
@else
@if(Gate::check('edit pdt design settings'))<form method="post" action="{{ route('pdt.design-settings.update',$design->id) }}">@csrf @method('PATCH')<input type="hidden" name="show_in_product" value="0"><label><input type="checkbox" name="show_in_product" value="1" @if($design->show_in_product) checked @endif> Show in PDT product</label>@if(!$design->is_admin_created)<p class="pds-muted">This is a customer copy. Only published designs appear in the public product list.</p>@endif<button type="submit">Save settings</button></form>@endif
@if(Gate::check('delete pdt designs'))<form method="post" action="{{ route('pdt.design-settings.destroy',$design->id) }}" data-delete-design>@csrf @method('DELETE')<button type="submit" class="pds-danger">Soft delete design</button></form>@endif
@endif</dialog>
@empty<p class="pds-muted">No designs found.</p>@endforelse</div>
{{ $designs->links() }}
@endif</main><script src="{{ asset('assets/js/pdt-design-settings.js') }}?v={{ is_file(base_path('assets/css/pdt-design-settings.css')) ? filemtime(base_path('assets/css/pdt-design-settings.css')) : '20261120-table-2' }}" defer></script>
@endsection
