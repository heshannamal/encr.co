@extends('layouts.app', ['activePage' => 'activity_logs', 'titlePage' => __('Activity Logs')])

@section('content')
<style>

#searchbox{
        border: 2px solid #ffffff;
        height: 35px;
        /* width: 250px; */
        width: 100%;
        border-radius: 30px;
        padding: 0px 5px;
        background-color: #ffffff1a;
        margin-top: 10px;
        color: #ffffff;
    }
    #searchbox::placeholder {
        color: #aaaaaa;
        opacity: 1; /* Firefox */
        font-size: 14px;
    }
    #searchbox:focus {
        outline: 0px;
    }
    #searchbox:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #aaaaaa;
    }
    #searchbox::-ms-input-placeholder { /* Microsoft Edge */
        color: #aaaaaa;
    }
    .searchbox-position {
        position: relative;
        top: -5px;
    }
    .content-position {
        position: relative;
        top: -25px;
    }
    .right-align {
        text-align: right;
    }

</style>

<div class="container-fluid content-position">
    <div class="se-pre-con"></div>

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="row searchbox-position">
                <div class="col-md-6"></div>
                <div class="col-md-6 right-align" >
                    <input type="text" id="searchbox" placeholder="Causer Name Search" style="width: 68%;margin-right: 20px; border-radius: 5px; border: 0.125rem solid #787878; color: #787878; position: relative; right: 20px;">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card">
            {{-- <div class="card-header">
                <div class="card-header-danger col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="float-left header-title">Activity Logs</h1>
                        </div>
                        <div class="col-md-6 header-icons justify-content-end">
                            <div style="width: 100%;justify-content: flex-end;display: flex">
                                <input type="text" id="searchbox" placeholder="Causer Name Search" style="width: 50%;margin-right: 20px">
                                <span>
                                    <a class="btn btn-round" href="#" data-toggle="modal" data-target="#layout_modal">
                                        <i class="fas fa-wrench"></i>
                                    </a>
                                    <p>Table Layout</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table align-items-center table-bordered" id="user_groups_table">
                            <thead class="bg-theme">
                                <tr>
                                    <th class="user-group-name" scope="col">Causer Name</th>
                                    <th class="narration" scope="col">Type</th>
                                    <th class="created-at" scope="col">Used Model</th>
                                    <th class="created-at" scope="col">Order ID</th>
                                    <th class="updated-at" scope="col">Item ID</th>
                                    <th class="updated-at" scope="col">Changed Date</th>
                                </tr>
                            </thead>
{{-- {{ dd($activityLogs) }} --}}
                            <tbody class="list" id="tableBody">
                                @foreach ($activityLogs as $activityLog)
                                    <tr>
                                        <td class="causer-name">
                                            @foreach ($users as $user)
                                                @if(isset($user) && !empty($user) && $user->id ==  $activityLog->causer_id )
                                                    {{ $user->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="type">{{ $activityLog->description }}</td>
                                        <td class="used-model">{{ $activityLog->subject_type }}</td>
                                        <td>
                                            @if($activityLog->subject_type=='App\Models\Order')
                                                {{ $activityLog->subject_id }}
                                            @elseif ($activityLog->subject_type =='App\Models\OrderFolder')
                                                @foreach ($orderFolder as $orderFolders )
                                                    @if($activityLog->subject_id == $orderFolders->id)
                                                        {{ $orderFolders->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\OrderItemsDetail')
                                                @foreach ($order_item_details as $order_item_detail)
                                                    @if ($activityLog->subject_id == $order_item_detail->detailsid)
                                                        {{ $order_item_detail->orderid }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\OrderItem')
                                                @foreach ($order_items as $order_item)
                                                    @if ($activityLog->subject_id == $order_item->id)
                                                        {{ $order_item->orderid }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\OrderItemsDetailPlayerName')
                                                @foreach ($order_item_player as $order_item_players)
                                                    @if ($activityLog->subject_id == $order_item_players->playerId)
                                                        {{ $order_item_players->orderId }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\OrderItemFile')
                                                @foreach ($order_item_files as $order_item_file)
                                                    @if ($activityLog->subject_id == $order_item_file->id)
                                                        {{ $order_item_file->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\Notification')
                                                @foreach ($notifications as $notification)
                                                    @if ($activityLog->subject_id == $notification->id)
                                                        {{ $notification->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\CheckPayment')
                                                @foreach ($check_payments as $check_payment)
                                                    @if ($activityLog->subject_id == $check_payment->id)
                                                        {{ $check_payment->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\PaymentLog')
                                                @foreach ($payment_logs as $payment_log)
                                                    @if ($activityLog->subject_id == $payment_log->id)
                                                        {{ $payment_log->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\VenmoPayment')
                                                @foreach ($venmo_payments as $venmo_payment)
                                                    @if ($activityLog->subject_id == $venmo_payment->id)
                                                        {{ $venmo_payment->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\TeamStoreOrder')
                                                @foreach ($team_store_orders as $team_store_order)
                                                    @if ($activityLog->subject_id == $team_store_order->id)
                                                        {{ $team_store_order->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\TeamStorePlayerReport')
                                                @foreach ($team_store_player_reports as $team_store_player_report)
                                                    @if ($activityLog->subject_id == $team_store_player_report->reportId)
                                                        {{ $team_store_player_report->orderId }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\TeamStoreProductReport')
                                                @foreach ($team_store_product_reports as $team_store_product_report)
                                                    @if ($activityLog->subject_id == $team_store_product_report->reportId)
                                                        {{ $team_store_product_report->orderId }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\PaypalPayment')
                                                @foreach ($paypal_payments as $paypal_payment)
                                                    @if ($activityLog->subject_id == $paypal_payment->id)
                                                        {{ $paypal_payment->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\InHandDateLog')
                                                @foreach ($in_hand_date_logs as $in_hand_date_log)
                                                    @if ($activityLog->subject_id == $in_hand_date_log->id)
                                                        {{ $in_hand_date_log->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\ExFactoryDateLog')
                                                @foreach ($ex_factory_date_logs as $ex_factory_date_log)
                                                    @if ($activityLog->subject_id == $ex_factory_date_log->id)
                                                        {{ $ex_factory_date_log->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\ShippingNotificationDraft')
                                                @foreach ($shipping_notification_drafts as $shipping_notification_draft)
                                                    @if ($activityLog->subject_id == $shipping_notification_draft->id)
                                                        {{ $shipping_notification_draft->order_id }}
                                                    @endif
                                                @endforeach
                                            @elseif ($activityLog->subject_type =='App\Models\ShippedOrders')
                                                @foreach ($shipped_orders as $shipped_order)
                                                    @if ($activityLog->subject_id == $shipped_order->id)
                                                        {{ $shipped_order->order_id }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="item-id">{{ $activityLog->subject_id }}</td>
                                        <td class="updated-at">{{ $activityLog->updated_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-md-12 mt-2">
                    <div style="float: right">
                        {{ $activityLogs->onEachSide(5)->withQueryString()->links('layouts.paginationlinks') }}
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>

    let header = "ACTIVITY LOGS";
        document.getElementById("header").innerHTML = header;

        // search Causer Name
        const searchInput = document.getElementById('searchbox');
        const tableBody = document.getElementById('tableBody');

        searchInput.addEventListener('input', () => {

            const searchQuery = searchInput.value.toLowerCase();

            for (let i = 0; i < tableBody.rows.length; i++) {

                const projectName = tableBody.rows[i].cells[0];

                if (projectName.textContent.toLowerCase().includes(searchQuery)) {
                    tableBody.rows[i].style.display = '';
                } else {
                    tableBody.rows[i].style.display = 'none';
                }
            }
        });

</script>

@endsection
