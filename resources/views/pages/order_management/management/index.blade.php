<style>
    .order-tile {
        border-radius: 12px;
        width: 50px;
        height: 50px;
        align-items: center;
        display: flex;
        fill: #fff;
        flex-direction: column;
        justify-content: center;
        flex-flow: column;
        position: relative;
    }

    .order-tile img {
        width: 35px;
        height: 35px;
        vertical-align: middle;
    }

    .management_title {
        padding-left: 15px;
        margin-bottom: 0;
    }

    .div-position {
        position: relative;
        left: 17px;
        top: 17px;
    }
    @media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
        .header1{
            display: inline !important;
        }
        .headder_size{
            font-size:15px;
        }
    }
</style>

<div class="col-md-12 div-position">
    <div class="row pb-1" style="border-bottom: 1px solid #d2d2d2;">
        <div>
            @foreach ($orders as $order)
                <div class="order-tile" style="background-color: {{ $order->flag }}">
                    @foreach ($organizationIMG as $organization)
                        @if ($order->organization_id == $organization->id)
                            @foreach ($sportIMG as $sport)
                                @if ($organization->sport == $sport->sport_name)
                                    <img class="tile-thumbnail" src="{{ asset('assets') }}/{{ $sport->sport_image }}" />
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>

        <div>
            @foreach ($orders as $order)
                @foreach ($orderDetails as $orderDetail)
                    <h4 class="management_title">#{{ $order->order_no }}
                        {{ $orderDetail->organizationDetails['organization_name'] }}<br><small
                            class="text-muted">{{ $order->order_description }}</small></h4>
                @endforeach
            @endforeach
        </div>
    </div>
</div>

@include('pages.order_management.management.list')
