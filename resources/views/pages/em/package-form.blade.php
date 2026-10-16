@extends('layouts.app', ['activePage' => 'schedules', 'titlePage' => __('Events and Meeting Schedules')])

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<style>
    .em-wrap{padding:0;margin:0}.form-card{background:#fff;border-radius:18px;box-shadow:0 12px 38px rgba(15,23,42,.06);padding:24px;margin:0;width:100%}.page-title{font-size:28px;font-weight:900;text-align: left;}.soft-input{height:48px;border-radius:10px;border:1px solid #d8dee9}.soft-input:focus{box-shadow:0 0 0 4px rgba(37,99,235,.12);border-color:#2563eb}.btn-gradient{background:linear-gradient(135deg,#2563eb,#7c3aed);color:#fff;border:0;border-radius:10px;font-weight:800;padding:12px 24px}.btn-outline-soft{border:1px solid #d8dee9;border-radius:10px;font-weight:800;padding:12px 24px;background:#fff}.required{color:#ef4444}
    .bg-box.container-fluid.fix-nav.header-layout{
        margin-bottom: .0 !important;
    }
</style>

@section('back-btn')
    <a href="{{ route('schedules.index') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection
@section('order-header')
    Events & Meetings
@endsection
<div class="em-wrap mb-4">
    <form class="form-card" method="POST" action="{{ $package ? route('em.packages.update', $package->id) : route('em.packages.store') }}">
        @csrf
        @if($package) @method('PUT') @endif
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h3 class="page-title mb-1">{{ $package ? 'Edit Package' : 'Create Package' }}</h3>
                <p class="text-muted mb-0">Add package details and available classes.</p>
            </div>
            <a href="{{ route('schedules.index', ['tab'=>'packages']) }}" class="btn btn-outline-soft">Back</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-3">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Package Name <span class="required">*</span></label>
                <input type="text" name="package_name" class="form-control soft-input" value="{{ old('package_name', optional($package)->package_name) }}" placeholder="Enter package name">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Package Price <span class="required">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" min="0" name="package_price" class="form-control soft-input" value="{{ old('package_price', optional($package)->package_price) }}" placeholder="Enter price">
                </div>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold">Package Description</label>
                <textarea name="package_description" class="form-control" rows="5" style="border-radius:10px" maxlength="5000" placeholder="Enter package description">{{ old('package_description', optional($package)->package_description) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Available Classes <span class="required">*</span></label>
                <input type="number" min="0" name="available_classes" class="form-control soft-input" value="{{ old('available_classes', optional($package)->available_classes) }}" placeholder="Enter number of classes">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-5">
            <a href="{{ route('schedules.index', ['tab'=>'packages']) }}" class="btn btn-outline-soft">Cancel</a>
            <button type="submit" class="btn btn-gradient">{{ $package ? 'Update Package' : 'Create Package' }}</button>
        </div>
    </form>
</div>
@endsection
