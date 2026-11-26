@extends('layouts.app', ['activePage' => 'organization_sales_tax', 'titlePage' => __('Organization Sales Tax Review')])

@section('content')
<div class="container-fluid py-4">
    @if (session('tax_report_status'))
        <div class="alert alert-success" role="status">{{ session('tax_report_status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header">
            <h2 class="mb-1">Organization Sales Tax Review</h2>
            <p class="mb-0 text-muted">{{ $organizations->count() }} active organizations with orders and an enabled sales tax rate that is zero or missing.</p>
        </div>
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Organization</th>
                        <th scope="col">Shipping state</th>
                        <th scope="col">Sales tax</th>
                        @can('edit organizations')
                            <th scope="col">Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($organizations as $organization)
                        <tr>
                            <th scope="row">{{ $organization->organization_name }} <span class="text-muted">#{{ $organization->id }}</span></th>
                            <td>{{ $organization->shipping_state ?: '—' }}</td>
                            <td>{{ $organization->sales_tax ?? 'Missing' }}</td>
                            @can('edit organizations')
                                <td>
                                    @php
                                        $retry = $errors->any() && old('editing_organization') == $organization->id;
                                    @endphp
                                    <details @if ($retry) open @endif>
                                        <summary class="text-primary">Edit address and tax</summary>
                                        <form class="mt-3" style="min-width: 16rem" method="POST" action="{{ route('reports.organization_sales_tax.update', $organization) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="editing_organization" value="{{ $organization->id }}">
                                            @foreach ([
                                                'shipping_street' => 'Shipping street',
                                                'shipping_city' => 'Shipping city',
                                                'shipping_state' => 'Shipping state',
                                                'shipping_postal_code' => 'Shipping postal code',
                                                'shipping_country' => 'Shipping country',
                                            ] as $field => $label)
                                                <label class="d-block mb-2">
                                                    {{ $label }}
                                                    <input class="form-control form-control-sm" type="text" name="{{ $field }}" maxlength="255"
                                                        value="{{ $retry ? old($field) : $organization->$field }}">
                                                </label>
                                            @endforeach
                                            <label class="d-block mb-2">
                                                Sales tax rate (%)
                                                <input class="form-control form-control-sm" type="number" name="sales_tax" min="0" max="100" step="any"
                                                    value="{{ $retry ? old('sales_tax') : $organization->sales_tax }}">
                                            </label>
                                            <label class="d-block mb-3">
                                                Sales tax status
                                                <select class="form-control form-control-sm" name="sales_tax_active">
                                                    <option value="1" @if (!$retry || old('sales_tax_active') === '1') selected @endif>Active</option>
                                                    <option value="0" @if ($retry && old('sales_tax_active') === '0') selected @endif>Inactive</option>
                                                </select>
                                            </label>
                                            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                                        </form>
                                    </details>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr><td colspan="{{ Gate::allows('edit organizations') ? 4 : 3 }}">No matching organizations.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
