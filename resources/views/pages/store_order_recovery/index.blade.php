@extends('layouts.app', ['activePage' => 'store_order_recovery', 'titlePage' => __('Store Order Recovery')])

@section('content')
<style>
    .recovery-page .card { border: 0; box-shadow: 0 4px 18px rgba(0,0,0,.06); }
    .recovery-page .filter-card { border-left: 4px solid #5e72e4; }
    .recovery-page .order-card { overflow: hidden; }
    .recovery-page .order-toggle { cursor: pointer; user-select: none; }
    .recovery-page .order-toggle:hover { background: #fafbff; }
    .recovery-page .status-pill { display:inline-block; padding:5px 10px; border-radius:999px; font-size:12px; font-weight:700; white-space:nowrap; }
    .recovery-page .status-ok { background:#e8f7ee; color:#16854b; }
    .recovery-page .status-bad { background:#fdeaea; color:#c0392b; }
    .recovery-page .status-warn { background:#fff4df; color:#a66a00; }
    .recovery-page .status-info { background:#eaf1ff; color:#3558c7; }
    .recovery-page .small-note { color:#68727d; font-size:12px; }
    .recovery-page .cart-table td,
    .recovery-page .cart-table th,
    .recovery-page .payment-table td,
    .recovery-page .payment-table th { vertical-align:middle; }
    .recovery-page .detail-list { margin:0; padding-left:18px; }
    .recovery-page .detail-list li { margin-bottom:3px; }
    .recovery-page .action-btn { min-width:118px; }
    .recovery-page .order-summary-grid { display:flex; flex-wrap:wrap; gap:18px; }
    .recovery-page .order-summary-grid > div { min-width:105px; }
    .recovery-page .collapse-arrow { transition:transform .2s ease; }
    .recovery-page [aria-expanded="true"] .collapse-arrow { transform:rotate(180deg); }
    .recovery-page .info-box { border:1px solid #edf0f4; border-radius:8px; padding:14px; background:#fff; height:100%; }
    .recovery-page .info-title { font-size:13px; font-weight:700; color:#32325d; margin-bottom:10px; text-transform:uppercase; letter-spacing:.3px; }
    .recovery-page .kv { display:flex; justify-content:space-between; gap:14px; padding:5px 0; border-bottom:1px dashed #edf0f4; font-size:13px; }
    .recovery-page .kv:last-child { border-bottom:0; }
    .recovery-page .kv span:first-child { color:#68727d; }
    .recovery-page .section-title { font-size:15px; font-weight:700; margin-bottom:10px; }
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

    <div class="card filter-card mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-start">
                <div>
                    <h5 class="mb-1">Receipt-less orders with remaining cart products</h5>
                    <p class="text-muted mb-3">
                        Only orders with no receipt and with cart products still available for the order customer's email are shown.
                    </p>
                </div>
                <div class="small-note text-md-right">
                    Add/Update changes order items only.<br>
                    Order totals, payment amounts, shipping, and payment records are never updated.<br>
                    Cart records are never deleted.
                </div>
            </div>

            <form method="GET" action="{{ route('store-order-recovery.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="store_id">Store ID <span class="text-muted">(optional)</span></label>
                        <input type="number" min="1" class="form-control" id="store_id" name="store_id" value="{{ $storeId }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="email">Customer Email <span class="text-muted">(optional)</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $email }}">
                    </div>

                    <div class="col-md-3 mb-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-filter mr-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($rows->isEmpty())
        <div class="card">
            <div class="card-body">
                <div class="alert alert-success mb-0">
                    No receipt-less store orders with remaining cart products were found.
                </div>
            </div>
        </div>
    @else
        @foreach ($rows as $row)
            @php
                $order = $row['order'];
                $customer = $row['customer'];
                $store = $row['store'];
                $payment = $row['payment'];
                $cartRows = $row['cart_rows'];
                $paymentRecords = $payment['records'];
                $collapseId = 'recovery-order-' . $order->id;
            @endphp

            <div class="card order-card mb-3">
                <div class="card-body order-toggle"
                     data-toggle="collapse"
                     data-target="#{{ $collapseId }}"
                     aria-expanded="false"
                     aria-controls="{{ $collapseId }}">
                    <div class="row align-items-center">
                        <div class="col-lg-4 mb-2 mb-lg-0">
                            <h5 class="mb-1">{{ $order->order_no ?: ('Order #' . $order->id) }}</h5>
                            <div class="small-note">
                                {{ trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) ?: 'Customer' }}
                                &middot; {{ $customer->email ?? 'No email' }}
                            </div>
                            <div class="small-note">
                                {{ $store ? $store->store_name : 'Store' }} (#{{ $order->store_id }})
                                &middot; {{ optional($order->created_at)->format('m/d/Y h:i A') }}
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="order-summary-grid">
                                <div>
                                    <div class="small-note">Order Total</div>
                                    <strong>${{ number_format((float) $order->total, 2) }}</strong>
                                </div>
                                <div>
                                    <div class="small-note">Paid</div>
                                    <strong>${{ number_format((float) $order->paid_invoice_amount, 2) }}</strong>
                                </div>
                                <div>
                                    <div class="small-note">Payment</div>
                                    @if ($payment['verified'])
                                        <span class="status-pill status-ok">Verified</span>
                                    @else
                                        <span class="status-pill status-bad">Not Verified</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="small-note">Cart Products</div>
                                    <strong>{{ $row['cart_count'] }}</strong>
                                </div>
                                <div>
                                    <div class="small-note">Missing</div>
                                    <span class="status-pill {{ $row['missing_count'] > 0 ? 'status-warn' : 'status-ok' }}">{{ $row['missing_count'] }}</span>
                                </div>
                                <div>
                                    <div class="small-note">Existing</div>
                                    <span class="status-pill status-info">{{ $row['existing_count'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-1 text-right">
                            <i class="fa fa-chevron-down collapse-arrow"></i>
                        </div>
                    </div>
                </div>

                <div id="{{ $collapseId }}" class="collapse">
                    <div class="card-body border-top">
                        <div class="row mb-4">
                            <div class="col-lg-6 mb-3 mb-lg-0">
                                <div class="info-box">
                                    <div class="info-title">Saved Order Details</div>
                                    <div class="kv"><span>Order ID</span><strong>{{ $order->id }}</strong></div>
                                    <div class="kv"><span>Order No</span><strong>{{ $order->order_no ?: '-' }}</strong></div>
                                    <div class="kv"><span>Sub Total</span><strong>${{ number_format((float) $order->sub_total, 2) }}</strong></div>
                                    <div class="kv"><span>Shipping</span><strong>${{ number_format((float) $order->shipping, 2) }}</strong></div>
                                    <div class="kv"><span>Handling Fee</span><strong>${{ number_format((float) $order->handling_fee, 2) }}</strong></div>
                                    <div class="kv"><span>Sales Tax</span><strong>${{ number_format((float) $order->sales_tax, 2) }}</strong></div>
                                    <div class="kv"><span>Discount</span><strong>${{ number_format((float) $order->discount, 2) }}</strong></div>
                                    <div class="kv"><span>Order Total</span><strong>${{ number_format((float) $order->total, 2) }}</strong></div>
                                    <div class="kv"><span>Paid Invoice Amount</span><strong>${{ number_format((float) $order->paid_invoice_amount, 2) }}</strong></div>
                                    <div class="kv"><span>Paid Processing Fee</span><strong>${{ number_format((float) $order->paid_processing_fee, 2) }}</strong></div>
                                    <div class="kv"><span>Paid Amount</span><strong>${{ number_format((float) $order->paid_amount, 2) }}</strong></div>
                                    <div class="kv"><span>Payment Method</span><strong>{{ $order->payment_method ?: '-' }}</strong></div>
                                    <div class="kv"><span>Shipping Method</span><strong>{{ $order->shipping_method ?? '-' }}</strong></div>
                                    <div class="kv"><span>Payment Success</span><strong>{{ (int) $order->is_payment_success === 1 ? 'Yes' : 'No' }}</strong></div>
                                    <div class="kv"><span>Order Status</span><strong>{{ $order->order_status ?? '-' }}</strong></div>
                                    <div class="kv"><span>Active</span><strong>{{ (int) $order->active === 1 ? 'Yes' : 'No' }}</strong></div>
                                    <div class="kv"><span>Coupon</span><strong>{{ $order->coupon_code ?: '-' }}</strong></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="info-box">
                                    <div class="info-title">Payment Summary</div>
                                    <div class="kv"><span>Verified</span><strong>{{ $payment['verified'] ? 'Yes' : 'No' }}</strong></div>
                                    <div class="kv"><span>Successful Charges</span><strong>${{ number_format((float) $payment['paid'], 2) }}</strong></div>
                                    <div class="kv"><span>Refunded</span><strong>${{ number_format((float) $payment['refunded'], 2) }}</strong></div>
                                    <div class="kv"><span>Net Paid</span><strong>${{ number_format((float) $payment['net_paid'], 2) }}</strong></div>
                                    <div class="kv"><span>Processing Fees</span><strong>${{ number_format((float) $payment['processing_fees'], 2) }}</strong></div>
                                    <div class="kv"><span>Total Charged</span><strong>${{ number_format((float) $payment['total_charged'], 2) }}</strong></div>
                                    <div class="kv"><span>Latest Successful Txn</span><strong>{{ $payment['transaction_id'] ?: '-' }}</strong></div>
                                    <div class="kv"><span>Payment Records</span><strong>{{ $paymentRecords->count() }}</strong></div>
                                </div>
                            </div>
                        </div>

                        <div class="section-title">Payment Details</div>
                        @if ($paymentRecords->isEmpty())
                            <div class="alert alert-warning">No store card payment records found for this order.</div>
                        @else
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-sm payment-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Transaction</th>
                                            <th>Card Owner</th>
                                            <th>Payment Amount</th>
                                            <th>Processing Fee</th>
                                            <th>Total Amount</th>
                                            <th>Success</th>
                                            <th>Refund</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paymentRecords as $paymentRow)
                                            <tr>
                                                <td>{{ $paymentRow->id }}</td>
                                                <td>{{ $paymentRow->transaction_id ?: '-' }}</td>
                                                <td>{{ $paymentRow->card_owner ?: '-' }}</td>
                                                <td>${{ number_format((float) $paymentRow->payment_amount, 2) }}</td>
                                                <td>${{ number_format((float) $paymentRow->processing_fee, 2) }}</td>
                                                <td>${{ number_format((float) $paymentRow->total_amount, 2) }}</td>
                                                <td>
                                                    @if ((int) $paymentRow->is_success === 1)
                                                        <span class="status-pill status-ok">Success</span>
                                                    @else
                                                        <span class="status-pill status-bad">Failed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ((int) $paymentRow->is_refund === 1)
                                                        <span class="status-pill status-warn">Refund</span>
                                                    @else
                                                        <span class="small-note">No</span>
                                                    @endif
                                                </td>
                                                <td>{{ optional($paymentRow->created_at)->format('m/d/Y h:i A') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <div>
                                <div class="section-title mb-1">Cart Items to Recover</div>
                                <div class="small-note">These cart records remain unchanged after Add/Update.</div>
                            </div>

                            <div class="mt-2 mt-md-0">
                                @if ($row['can_create_receipt'])
                                    <form method="POST"
                                          action="{{ route('store-order-recovery.create-first-receipt', ['orderId' => $order->id]) }}"
                                          onsubmit="return confirm('Create the first receipt for {{ $order->order_no ?: ('order #' . $order->id) }}? This can only be done once.');">
                                        @csrf
                                        @if ($storeId)
                                            <input type="hidden" name="return_store_id" value="{{ $storeId }}">
                                        @endif
                                        @if ($email)
                                            <input type="hidden" name="return_email" value="{{ $email }}">
                                        @endif
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fa fa-file-text-o mr-1"></i> Create First Receipt
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-secondary btn-sm" disabled>
                                        <i class="fa fa-file-text-o mr-1"></i> Create First Receipt
                                    </button>
                                    @if ($order->OrderItems->isEmpty())
                                        <div class="small-note text-danger mt-1">Add at least one item first.</div>
                                    @elseif ($row['missing_count'] > 0)
                                        <div class="small-note text-danger mt-1">Add all missing cart products first.</div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover cart-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Cart</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Cart Details</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartRows as $cartRow)
                                        @php
                                            $cart = $cartRow['cart'];
                                            $product = $cart->storeProduct;
                                            $existingOrderItem = $cartRow['existing_order_item'];
                                            $unitPrice = $product
                                                ? ((float) ($product->default_price ?? 0) + (float) $product->priceAdditions->sum('addition_amount'))
                                                : 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>#{{ $cart->id }}</strong>
                                                @if (!empty($cart->sub_team))
                                                    <div class="small-note">{{ $cart->sub_team }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $product->product_name ?? ('Product #' . $cart->store_product_id) }}</strong>
                                                <div class="small-note">Product ID: {{ $cart->store_product_id }}</div>
                                                <div class="small-note">Unit: ${{ number_format($unitPrice, 2) }}</div>
                                            </td>
                                            <td>{{ $cart->qty }}</td>
                                            <td>
                                                @if ($cart->StoreCartItems && $cart->StoreCartItems->isNotEmpty())
                                                    <ul class="detail-list small-note">
                                                        @foreach ($cart->StoreCartItems as $detail)
                                                            <li>
                                                                Size {{ $detail->size_id ?? '-' }}
                                                                @if (!empty($detail->product_variant)) &middot; {{ $detail->product_variant }} @endif
                                                                @if (!empty($detail->custom_name)) &middot; {{ $detail->custom_name }} @endif
                                                                @if (!empty($detail->custom_number)) #{{ $detail->custom_number }} @endif
                                                                &middot; Qty {{ $detail->qty ?? 0 }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="small-note">No cart detail rows</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($existingOrderItem)
                                                    <span class="status-pill status-ok">Exists</span>
                                                    <div class="small-note mt-1">Order Item #{{ $existingOrderItem->id }}</div>
                                                    <div class="small-note">Current qty: {{ $existingOrderItem->qty }}</div>
                                                @else
                                                    <span class="status-pill status-warn">Missing</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!$row['eligible'])
                                                    <span class="small-note text-danger">Payment not verified</span>
                                                @else
                                                    <form method="POST"
                                                          action="{{ route('store-order-recovery.sync-cart-item', ['orderId' => $order->id, 'cartId' => $cart->id]) }}"
                                                          onsubmit="return confirm('{{ $existingOrderItem ? 'Update the existing order item from this cart product? Only item data will change.' : 'Add this cart product to the order? Order totals/payment values will not change.' }}');">
                                                        @csrf
                                                        @if ($storeId)
                                                            <input type="hidden" name="return_store_id" value="{{ $storeId }}">
                                                        @endif
                                                        @if ($email)
                                                            <input type="hidden" name="return_email" value="{{ $email }}">
                                                        @endif
                                                        @if ($existingOrderItem)
                                                            <button type="submit" class="btn btn-primary btn-sm action-btn">
                                                                <i class="fa fa-refresh mr-1"></i> Update Item
                                                            </button>
                                                        @else
                                                            <button type="submit" class="btn btn-success btn-sm action-btn">
                                                                <i class="fa fa-plus mr-1"></i> Add to Order
                                                            </button>
                                                        @endif
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="small-note mt-3">
                            Add/Update only changes StoreOrderItem and StoreOrderPlayerDetail data. Existing StoreOrder amounts, payment values, payment status, shipping data and StoreCardPayment rows are preserved exactly as saved.
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
