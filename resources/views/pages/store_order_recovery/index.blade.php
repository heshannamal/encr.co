@extends('layouts.app', ['activePage' => 'store_order_recovery', 'titlePage' => __('Store Order Recovery')])

@section('content')
<style>
    .recovery-page .card { border: 0; box-shadow: 0 4px 18px rgba(0, 0, 0, .06); }
    .recovery-page .search-card { border-left: 4px solid #5e72e4; }
    .recovery-page .status-pill { display: inline-block; padding: 5px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .recovery-page .status-ok { background: #e8f7ee; color: #16854b; }
    .recovery-page .status-bad { background: #fdeaea; color: #c0392b; }
    .recovery-page .status-warn { background: #fff4df; color: #a66a00; }
    .recovery-page .restore-btn { min-width: 138px; }
    .recovery-page .table td, .recovery-page .table th { vertical-align: middle; }
    .recovery-page .small-note { color: #68727d; font-size: 12px; }
</style>

<div class="mb-5 content-position recovery-page">
    @section('order-header')
        <span>Store Order Recovery</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card search-card mb-4">
        <div class="card-body">
            <h5 class="mb-1">Find affected store orders</h5>
            <p class="text-muted mb-4">
                Enter the Store ID and the customer's account email. Orders are shown with payment, order-item, and remaining-cart status.
            </p>

            <form method="GET" action="{{ route('store-order-recovery.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="store_id">Store ID</label>
                        <input type="number" min="1" class="form-control" id="store_id" name="store_id" value="{{ old('store_id', $storeId) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email">Customer Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $email) }}" required>
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-search mr-1"></i> Find Orders
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($searched)
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-1">Recovery Results</h5>
                        <div class="small-note">
                            Store: {{ $store ? $store->store_name : 'N/A' }} (#{{ $storeId }}) &middot; Customer: {{ $email }}
                        </div>
                    </div>
                    <div class="small-note mt-2 mt-md-0">
                        Cart rows are removed only after the restore transaction finishes successfully.
                    </div>
                </div>

                @if ($orders->isEmpty())
                    <div class="alert alert-warning mb-0">No orders were found for this Store ID and customer email.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Order Items</th>
                                    <th>Remaining Cart</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    @php($meta = $order->recovery_meta)
                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_no ?: ('#' . $order->id) }}</strong>
                                            <div class="small-note">Order ID: {{ $order->id }}</div>
                                        </td>
                                        <td>{{ optional($order->created_at)->format('m/d/Y h:i A') }}</td>
                                        <td>${{ number_format((float) $order->total, 2) }}</td>
                                        <td>
                                            @if ($meta['payment_verified'])
                                                <span class="status-pill status-ok">Verified Paid</span>
                                                <div class="small-note mt-1">Net: ${{ number_format((float) $meta['net_paid'], 2) }}</div>
                                                @if (!empty($meta['transaction_id']))
                                                    <div class="small-note">Txn: {{ $meta['transaction_id'] }}</div>
                                                @endif
                                            @else
                                                <span class="status-pill status-bad">Not Verified</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($meta['item_count'] === 0)
                                                <span class="status-pill status-warn">0 - Missing</span>
                                            @else
                                                <span class="status-pill status-ok">{{ $meta['item_count'] }} Exists</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $meta['cart_count'] }}</strong> product row(s)
                                            <div class="small-note">{{ $meta['cart_detail_count'] }} item detail row(s)</div>
                                        </td>
                                        <td>
                                            @if ($meta['eligible'])
                                                <form method="POST" action="{{ route('store-order-recovery.restore', $order->id) }}" onsubmit="return confirm('Restore order items for {{ $order->order_no ?: ('order #' . $order->id) }} from the remaining cart?');">
                                                    @csrf
                                                    <input type="hidden" name="store_id" value="{{ $storeId }}">
                                                    <input type="hidden" name="email" value="{{ $email }}">
                                                    <button type="submit" class="btn btn-success btn-sm restore-btn">
                                                        <i class="fa fa-undo mr-1"></i> Restore Items
                                                    </button>
                                                </form>
                                            @elseif ($meta['item_count'] > 0)
                                                <span class="small-note">Already has order items</span>
                                            @elseif (!$meta['payment_verified'])
                                                <span class="small-note">Payment must be verified first</span>
                                            @else
                                                <span class="small-note">No usable cart remains</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection