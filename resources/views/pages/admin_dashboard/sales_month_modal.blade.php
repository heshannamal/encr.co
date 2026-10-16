<h5>{{ $user->name }} - {{ $monthName }} {{ $year }}</h5>

@if($orders->count() > 0)
<table class="table table-striped">
    <thead>
        <tr>
            <th>Order No</th>
            <th>Organization</th>
            <th>Production Date</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>
                <a href="#"  class="edit-order orderDetails" data-value="{{ $order->id }}">{{ $order->order_no }}</a>
            </td>
            <td>{{ $order->organizationDetails->organization_name ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($order->production_date)->format('M d, Y') }}</td>
            <td>{{ number_format($order->order_total, 2, '.', ',') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p class="text-center text-muted">No sales data found for this month.</p>
@endif
