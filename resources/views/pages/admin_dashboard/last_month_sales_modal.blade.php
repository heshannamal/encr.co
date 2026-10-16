@if($orders->isEmpty())
    <p class="text-center text-muted">No orders found for {{ $date }}</p>
@else
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Order No</th>
                <th>Organization</th>
                <th>Order Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>
                        <a href="#"  class="edit-order orderDetails" data-value="{{ $order->id }}">{{ $order->order_no }}</a>
                    </td>
                    <td>{{ $order->organizationDetails->organization_name ?? '-' }}</td>
                    <td>{{ number_format($order->order_total, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
