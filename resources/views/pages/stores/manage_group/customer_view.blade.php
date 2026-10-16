<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->store_name ?? 'Store' }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

    <style>
        .nav-tabs .nav-link, .nav-tabs .nav-item .nav-link {
            border: none;
            background-color: transparent;
            font-size: 1rem;
            color: grey;
        }
        .nav-item .nav-link {
            display: block;
        }
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active, .nav-tabs .nav-item:hover{
            border-bottom: 3px solid grey;
        }
        .status {
            font-size: 12px;
            margin-right: 15px;
            margin-left: 0px;
            width: 58px;
            text-align: center;
            border-radius: 16px;
            line-height: 1.7;
            height: 27px;
            padding-top: 3px;
            margin-top: 5px;
        }

        .status.open {
            background-color: rgba(199, 249, 123, 0.7);
            color: rgb(0, 101, 0);
        }
        .status.archived {
            color: white;
            background-color:#b3b3b3
        }
        .status.closed {
            color: white;
            background-color:rgb(223 22 22 / 70%)
        }
        .view_store_btn {
            background-color: #47D6B6;
            color: white;
            border: unset;
            width: auto;
            padding: .75rem 1.25rem;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        .add-member-btn {
            text-align: center;
            vertical-align: middle;
            touch-action: manipulation;
            cursor: pointer;
            white-space: nowrap;
            user-select: none;
            background-image: none;
            border: 1px solid #0000;
            border-radius: 4px;
            margin-bottom: 0;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857;
            display: inline-block;
            background-color: #8ab740;
            flex: 1;
            margin-left: 30px;
            margin-right: 30px;
            color: #fff !important;
            margin-bottom: 10px !important;
        }
        .fundraising-card {
            background-color: #8ab740;
            border: 1px solid #0000;
            color: #fff !important;
            border-radius: .2rem;
            padding: .5rem;
        }
        .share_btn {
            border: unset;
            background-color: transparent;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            color: #B3B3B3;
        }
        .btn_section {
            margin-right: 15px;
            padding: 15px;
            padding-bottom: unset;
        }
        .product_report {
            font-size: 18px;
        }
        .card_div {
            padding: 15px;
            padding-bottom: 5px;
        }
        .manage_group_p {
            font-size: 11px;
            color: #717070;
            font-weight: 500;
            margin-bottom: unset;
        }
        .share_btn_div {
            border-right: 1px solid #DEDEDE;
            margin: 5px;
        }
        .total_qty_text {
            font-size: 10px;
            color: #B3B3B3;
            font-weight: 500;
            margin-bottom: unset;
        }
        .total_qty_text2 {
            font-size: 11px;
            color: #B3B3B3;
            font-weight: 500;
            margin-bottom: unset;
        }
        .qty_div {
            margin-right: 5px;
        }
        .qty_div2 {
            margin-right: 10px;
            margin-left: 5px;
            border-right: 1px solid #DEDEDE;
            padding-right: 10px;
        }
        .date_div {
            margin-right: 5px;
            margin-left: 5px;
            padding-left: 5px;
            padding-right: 5px;
            border-radius: 8px;
        }
        .manufacturer_div {
            margin-right: 5px;
            margin-left: 5px;
            padding-left: 5px;
            padding-right: 5px;
            border-radius: 8px;
        }
        .symbol1 {
            font-size: 16px;
            font-weight: 100;
            line-height: 1.3;
            color: #B3B3B3;
            margin-bottom: unset;
        }
        .player_details1 {
            color: #4E4C4C;
            font-size: 12px;
            margin-bottom: unset;
            font-weight: 400;
        }
        .player_details2 {
            color: #717070;
            font-size: 12px;
            margin-bottom: unset;
            font-weight: 400;
        }
        .player_details_div {
            margin-left: 33px;
        }
        .player_details_row {
            padding-bottom: 5px;
        }
        .table_header_text {
            color: white;
            height: 40px;
        }
        .table_body {
            color: #4E4C4C;
        }
        .player_details_topic {
            width: 8rem;
        }
        .hover-func {
            text-decoration: none;
            cursor: pointer;
        }

        .hover-func:hover {
            text-decoration: underline;
        }
        .rotate-icon {
            transition: transform 0.3s ease;
        }
        .rotate-icon.open {
            transform: rotate(90deg);
        }
        table.table-bordered td{
            vertical-align: middle;
        }

    </style>
</head>
<body>

    <!-- Sticky Top Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo + Text -->
            <a class="navbar-brand d-flex align-items-center mb-0 h4" href="#">
                <img src="{{ asset($store->themeDetails->primary_logo) }}" alt="Logo" class="me-2" style="height: 4rem;">
                <span class="fw-bold text-dark" style="font-size: 1.5rem;">{{ $store->store_name }}</span>
            </a>

            <div class="d-flex align-items-center">
                <!-- Tabs -->
                <ul class="nav nav-tabs border-0 me-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#overview" role="tab">OVERVIEW</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#share" role="tab" id="share_with_tab">SHARE WITH GROUP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#orders" role="tab">ORDERS</a>
                    </li>
                </ul>

                <div class="dropdown ms-3">
                    <a class="d-flex align-items-center justify-content-center rounded-circle overflow-hidden"
                    href="#"
                    id="peopleDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    style="width: 3.5rem; height: 3.5rem; border: 1px solid #ccc;">
                        <img src="{{ asset('assets/img/people/default.png') }}" alt="User" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="peopleDropdown">
                        <li class="dropdown-item">
                        <strong>{{ $group_user->name }}</strong><br>
                        <small>{{ $group_user->email }}</small>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <div class="row">
                    <div class="col-md-2">
                        <div class="card fundraising-card text-center">
                            <table>
                                <tr>
                                    <td style="padding: .5rem;">
                                        <p class="mb-0" style="font-size: 1rem;font-weight: 500;">Fundraising Collected</p>
                                        <h3 style="font-size: 1.5rem;font-weight: 700;margin: 0;">${{ number_format($totalFundraising, 2) }}</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: .5rem;">
                                        <p class="mb-0" style="font-size: 1rem;font-weight: 500;">Card Processing Fees</p>
                                        <h3 style="font-size: 1.5rem;font-weight: 700;margin: 0;">${{ number_format($totalFundraising * 3 /100, 2) }}</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: .5rem;">
                                        <p class="mb-0" style="font-size: 1rem;font-weight: 500;">Net Fundraising</p>
                                        <h3 style="font-size: 2rem;font-weight: 700;margin: 0;">${{ number_format($totalFundraising * 103 / 100, 2) }}</h3>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="container" style="max-width: 55rem;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if ($store->store_status == 1)
                                                <p class="status open d-inline-block mb-0">Open</p>
                                            @elseif ($store->store_status == 3)
                                                <p class="status archived d-inline-block mb-0">Archived</p>
                                            @else
                                                <p class="status closed d-inline-block mb-0">Closed</p>
                                            @endif
                                            <span class="store_name ml-2" style="font-size: 2rem;">{{ $store->store_name }}</span>
                                        </div>

                                        <button type="button" class="view_store_btn"
                                            onclick="window.open('{{ makeStoreDomainRoute($store->direct_access_url) }}', '_blank')">
                                            <i class="fa fa-arrow-up-from-bracket" aria-hidden="true"></i> VIEW STORE
                                        </button>
                                    </div>
                                </div>
                                <hr style="margin-top: 1rem;margin-bottom: 1rem;border: 1px solid #b3b3b3;">
                                <div class="col-md-12">
                                    <p style="font-size: 1rem;">Your store is open! Help your group meet its fundraising goals by entering your group members' email addresses before the store closes</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="card" style="border: none;background-color: #e6e6e6;margin: .5rem 2.5rem;min-height: 13rem;">
                                        <div class="card-body text-center">
                                            <p style="font-size: 1.2rem;font-weight: 500;margin:0">Members:</p>
                                            <p style="font-size: 3rem;font-weight: 500;">{{ $memberCount }}</p>
                                            <button class="add-member-btn" type="button">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Add Group Members
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card" style="border: none;background-color: #e6e6e6;margin: .5rem 2.5rem;min-height: 13rem;">
                                        <div class="card-body">
                                            <p style="font-size: 1rem;font-weight: 500;margin:0">Want to generate even more traffic for your store? Try sharing a link on social media.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="tab-pane fade" id="share" role="tabpanel">
                <div class="container">
                    <h3 class="mb-4">Share With Group</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <p>Emails added to this list will automatically receive the following updates.</p>
                            <ul>
                                <li><h5>Store Opened</h5>
                                    <p> Customers will receive an email with a link to the store as soon as it opens.</p>
                                </li>
                                <li><h5>Store Closing Soon</h5>
                                    <p>Customers will receive an email warning that the store will be closing in the next 1-3 days. </p>
                                </li>
                            </ul>
                            <hr style="margin-top: 1rem;margin-bottom: 1rem;border: 1px solid #b3b3b3;">
                            <form id="downloadFlyerForm" action="{{ route('store.download_store_flyer') }}" method="POST">
                                @csrf
                                <input type="hidden" name="store_id" value="{{ $store->id }}">
                                <input type="hidden" name="is_download" value="1">
                                <button class="download-flyer-btn view_store_btn" type="submit">Download Flyer</button>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex mb-2">
                                <input type="text" class="form-control" placeholder="Email" value="">
                                <input type="text" class="form-control" placeholder="Name" value="">
                                <button class="btn btn-primary ms-2 btn-add-member-access" type="button">Add</button>
                            </div>
                            <p>This information is only used for automated emails and cannot be accessed by the dealer.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="orders" role="tabpanel">
                <div class="container-fluid">
                    <div class="card main_card mt-4" style="border: none;">
                        <div class="orders-list">
                            @if ($customerOrders->count() > 0)
                                @foreach ($customerOrders as $order)
                                @php
                                    $orderCollapseId = 'orderCollapse_' . $order->id;
                                @endphp

                                <div class="player-report-div mb-4 border rounded shadow-sm">
                                    <!-- Header -->
                                    <div class="order-header d-flex align-items-center justify-content-between bg-dark text-white p-2"
                                        style="background-color: #666666 !important; cursor: pointer;"
                                        data-target="#{{ $orderCollapseId }}">

                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/img/team_stores/report.png') }}" class="mr-2" style="width: 22px;" />
                                            <strong>{{ $order->storeCustomer->first_name ." ". $order->storeCustomer->last_name }}</strong>
                                            <span class="mx-2">|</span>
                                            <a class="hover-func text-white font-weight-bold"
                                            target="_blank"
                                            href="{{ route('store.customer_order_view', ['id' => $order->order_no]) }}">
                                                Order #{{ $order->order_no ?? 'N/A' }}
                                            </a>
                                        </div>

                                        <i class="fa fa-chevron-right rotate-icon"></i>
                                    </div>

                                    <!-- Order Details (hidden by default) -->
                                    <div id="{{ $orderCollapseId }}" class="order-details" style="display: none;">
                                        <div class="player_details_div mt-3 ml-4">
                                            <div class="row player_details_row">
                                                <div class="col-md-3 font-weight-bold text-muted small">Billing Name:</div>
                                                <div class="col-md-9 small">{{ $order->storeCustomer->first_name ." ". $order->storeCustomer->last_name }}</div>
                                            </div>
                                            <div class="row player_details_row">
                                                <div class="col-md-3 font-weight-bold text-muted small">Payment Method:</div>
                                                <div class="col-md-9 small">{{ $order->payment_method ?? 'N/A' }}</div>
                                            </div>
                                            <div class="row player_details_row">
                                                <div class="col-md-3 font-weight-bold text-muted small">Order Date:</div>
                                                <div class="col-md-9 small">{{ $order->created_at ? $order->created_at->format('d M Y (g:i a)') : 'N/A' }}</div>
                                            </div>
                                            <div class="row player_details_row">
                                                <div class="col-md-3 font-weight-bold text-muted small">Shipping Method:</div>
                                                <div class="col-md-9 small">{{ $order->shippingMethodDetails->shipping_method_name ?? 'N/A' }}</div>
                                            </div>
                                            <div class="row player_details_row">
                                                <div class="col-md-3 font-weight-bold text-muted small">Shipping Address:</div>
                                                <div class="col-md-9 small">
                                                    {{ $order->storeCustomer->street }}, {{ $order->storeCustomer->city }},
                                                    {{ $order->storeCustomer->state }}, {{ $order->storeCustomer->postal_code }},
                                                    {{ $order->storeCustomer->country }}
                                                </div>
                                            </div>
                                            @if($is_sub_team_added && count($subTeamArray) > 0)
                                            <div class="row player_details_row">
                                                <div class="col-md-3 font-weight-bold text-muted small"> Sub Team : </div>
                                                <div class="col-md-9 small">
                                                    <select style="height:1.5rem; border:none; background:transparent;" disabled>
                                                        <option value="">Not Selected</option>
                                                        @foreach($subTeamArray as $subTeam)
                                                            <option value="{{ $subTeam }}"
                                                                {{ ($order->OrderItems[0]->OrderItemDetails[0]->sub_team ?? '') == $subTeam ? 'selected' : '' }}>
                                                                {{ $subTeam }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="p-3">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="text-center">PRODUCT</th>
                                                        <th class="text-center">SIZE</th>
                                                        <th class="text-center">QTY</th>
                                                        <th class="text-center">PAID ($)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->OrderItems as $OrderItem)
                                                        @php $visibility = true; @endphp
                                                        @foreach ($OrderItem->OrderItemDetails as $OrderItemDetail)
                                                            <td class="text-left" style="vertical-align: middle;">
                                                                @if ($visibility)
                                                                    @php
                                                                        $product = $OrderItem->ProductDetails;

                                                                        $productImage = $product && $product->images && count($product->images) > 0
                                                                            ? $product->images[0]->url
                                                                            : 'assets/img/products/default-loading.gif';
                                                                    @endphp

                                                                    <div class="d-flex align-items-center">
                                                                        <div style="flex-shrink: 0;">
                                                                            <img src="{{ asset($productImage) }}"
                                                                                alt="Product Image"
                                                                                class="img-fluid"
                                                                                style="width: auto; height: 6rem; object-fit: cover;">
                                                                        </div>

                                                                        <div style="margin-left: 12px;">
                                                                            <div style="font-size: 18px; font-weight: 600; color: #4E4C4C;">
                                                                                {{ $product->product_name ?? 'N/A' }}
                                                                                (PRO - {{ $product->product_id ?? 'N/A' }})
                                                                            </div>

                                                                            @if(!empty($OrderItemDetail->player_name) && $OrderItemDetail->player_name !== 'null')
                                                                                <div style="font-size: 11px; color: #999999; font-weight: 600; margin-top: 4px;">
                                                                                    Name: {{ $OrderItemDetail->player_name }}
                                                                                </div>
                                                                            @endif

                                                                            @if($OrderItemDetail->player_number !== null && $OrderItemDetail->player_number !== '')
                                                                                <div style="font-size: 11px; color: #999999; font-weight: 600;">
                                                                                    Number: {{ $OrderItemDetail->player_number }}
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                                <td class="text-center">{{ $OrderItemDetail->SizeDetails->size_name }}</td>
                                                                <td class="text-center">{{ $OrderItemDetail->qty }}</td>
                                                                <td class="text-end">{{ $OrderItemDetail->paid_amount }}</td>
                                                            </tr>
                                                            @php $visibility = false; @endphp
                                                        @endforeach
                                                    @endforeach
                                                    @if (isset($order->couponDetails) && $order->couponDetails->count() > 0)
                                                        <tr>
                                                            <td scope="col" colspan="5" class="table_body text-left" style="font-size: large;color: #0aa636;">
                                                                You have applied coupon code "<strong>{{ $order->couponDetails->coupon_code }}</strong>" with
                                                                @if($order->couponDetails->type == 'free_shipping')
                                                                    Free Shipping ({{'$'.$order->discount}}).
                                                                @elseif($order->couponDetails->type == 'flat_from_sub')
                                                                    ${{ number_format($order->couponDetails->amount, 2) }} Off from Sub Total.
                                                                @elseif($order->couponDetails->type == 'percentage_from_sub')
                                                                    {{ rtrim(rtrim(number_format($order->couponDetails->amount, 2), '0'), '.') }}% ({{'$'.$order->discount}}) Off from Sub Total.
                                                                @elseif($order->couponDetails->type == 'flat_from_grand')
                                                                    ${{ number_format($order->couponDetails->amount, 2) }} Off from Grand Total.
                                                                @elseif($order->couponDetails->type == 'percentage_from_grand')
                                                                    {{ rtrim(rtrim(number_format($order->couponDetails->amount, 2), '0'), '.') }}% ({{'$'.$order->discount}}) Off from Grand Total.
                                                                @else
                                                                    Discount Applied
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </tr>

                                                    @endif
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td style="padding: 5px;">Subtotal:</td>
                                                        <td style="text-align: right;">${{ number_format($order->sub_total, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td style="padding: 5px;">Shipping:</td>
                                                        <td style="text-align: right;">${{ number_format($order->shipping, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td style="padding: 5px;">Handling Fee:</td>
                                                        <td style="text-align: right;">${{ number_format($order->handling_fee, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td style="padding: 5px;">Sales Tax:</td>
                                                        <td style="text-align: right;">${{ number_format($order->sales_tax, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td style="padding: 5px; font-weight: bold;">Total:</td>
                                                        <td style="text-align: right; font-weight: bold;">${{ number_format($order->total, 2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @else
                            <p>No Orders Found</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Member Modal -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="addMemberModalLabel">Add Group Member</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="addMemberForm">
            <div class="modal-body">
            <div class="mb-3">
                <label for="memberName" class="form-label">Name</label>
                <input type="text" class="form-control" id="memberName" name="member_name" placeholder="Enter name" required>
            </div>

            <div class="mb-3">
                <label for="memberEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="memberEmail" name="member_email" placeholder="Enter email" required>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Add Member</button>
            </div>
        </form>

        </div>
    </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.querySelector('.add-member-btn').addEventListener('click', function () {
            document.getElementById('share_with_tab').click();
        });
        $(document).ready(function () {
            $(".order-header").on("click", function () {
                let target = $(this).data("target");
                let detailsDiv = $(target);
                let chevron = $(this).find(".rotate-icon");

                // Toggle details
                detailsDiv.slideToggle(200);

                // Rotate chevron
                chevron.toggleClass("open");
            });
            $('.btn-add-member-access').on('click', function () {
                $('#addMemberModal').modal('show');
            });
        });


    </script>
</body>
</html>
