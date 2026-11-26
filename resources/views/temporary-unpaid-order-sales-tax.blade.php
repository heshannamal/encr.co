@extends('layouts.app', ['activePage' => 'Sales_Tax_Report', 'titlePage' => __('Unpaid Order Sales Tax')])

@section('content')
<div class="container-fluid py-4">
    @if (session('tax_sync_status'))
        <div class="alert alert-success" role="status">{{ session('tax_sync_status') }}</div>
    @endif
    <div class="card shadow">
        <div class="card-header">
            <h2 class="mb-1">Unpaid Order Sales Tax</h2>
            <p class="text-muted mb-0">{{ $orders->count() }} unpaid or partially paid orders. Sync copies the organization's current tax rate. Inactive tax is saved as NULL.</p>
        </div>
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Organization</th>
                        <th scope="col">Order sales tax rate</th>
                        <th scope="col">Organization sales tax rate</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><a href="{{ route('orders.info', ['id' => $order->id, 'type' => 'order']) }}" target="_blank" rel="noopener">#{{ $order->id }}</a></td>
                            <td>
                                @if ($order->organizationDetails)
                                    <a href="{{ route('organizations.info', ['id' => $order->organization_id]) }}" target="_blank" rel="noopener">{{ $order->organizationDetails->organization_name }}</a>
                                @else
                                    Missing organization
                                @endif
                            </td>
                            <td>{{ $order->sales_tax_rate === null ? 'NULL' : $order->sales_tax_rate.'%' }}</td>
                            <td>
                                {{ $order->organizationDetails && $order->organizationDetails->sales_tax !== null ? $order->organizationDetails->sales_tax.'%' : 'NULL' }}
                                @if ($order->organizationDetails && $order->organizationDetails->sales_tax_active != 1)
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @can('edit organizations')
                                    @if ($order->organizationDetails)
                                        <form method="POST" action="{{ route('reports.unpaid_order_sales_tax.sync', ['order' => $order->id]) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-primary" type="submit">Sync from organization</button>
                                        </form>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No unpaid orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
