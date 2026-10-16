<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <thead>
            <tr><th colspan="12" style="background-color: #e06666; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 17px;">ORDER SHEDULE REPORT</th></tr>
            <tr><td colspan="12"></td></tr>
            <tr>
                <td style="background-color: #19db7d; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 14px;">Today Orders</td>
                <td  colspan="2" style="background-color: #ff0000; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 14px;">Past The Ex Factory Date</td>
                <td  colspan="2" style="background-color: #ff7500; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 14px;">This Week Shipment</td>
                <td  style="background-color: #cdcdcd; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 14px;">Fulfilled Orders</td>
                <td  style="background-color: #ff8989; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 14px;">Canceled Orders</td>
            </tr>
            <tr><td colspan="12"></td></tr>

            <tr style="background-color: #bbbbbb;">
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER ID</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">FACTORY</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORGANIZATION</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">CONFIRMED EX FACTORY</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">REQUESTED EX FACTORY </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">IN HAND</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER STATUS</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">TEST PRINT NEEDED?</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER TYPE </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">SALES REP</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">RECEIVED DATE </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER QTY </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">SPECIAL COMMENTS </th>
            </tr>
        </thead>

        @php
            use Carbon\Carbon;
            $today = Carbon::today();
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $normalRows = [];
            $specialRows = [];
        @endphp

        @foreach($orders as $order)
            @php
                $exFactoryDate = Carbon::parse($order->ex_factory_date);
                $isToday = $exFactoryDate->isSameDay($today);
                $isPast = $exFactoryDate->lt($today);
                $isThisWeek = $exFactoryDate->between($startOfWeek, $endOfWeek);

                if ($isToday && $order->order_status_id == 3) {
                    $rowColor = '#19db7d';
                } elseif ($isPast && $order->order_status_id == 3) {
                    $rowColor = '#ff0000';
                } elseif ($isThisWeek && $order->order_status_id == 3) {
                    $rowColor = '#ff7500';
                } elseif ($order->order_status_id == 4) {
                    $rowColor = '#cdcdcd';
                    $specialRows[] = $order;
                    continue;
                } elseif ($order->order_status_id == 7) {
                    $rowColor = '#ff8989';
                    $specialRows[] = $order;
                    continue;
                } else {
                    $rowColor = $order->shedule_color;
                }

                $normalRows[] = ['order' => $order, 'rowColor' => $rowColor];
            @endphp
        @endforeach

        @foreach($normalRows as $row)
            <tr>
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->order_no }}</td>
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->factory_code }}</td>
                <!-- Add other table cells here -->
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->organizationDetails->organization_name }}</td>
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->factory_confirmation_date }}</td>
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->ex_factory_date }}</td>
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->due_date }}</td>
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->statusDetails->status_name }}</td>
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->test_print_needed }}</td>
                <!-- Add more columns as needed -->
                @if ($row['order']->is_urgent == 1)
                    <td style="background-color: {{ $row['rowColor'] }}">Urgent Order</td>
                @elseif ($row['order']->order_type == 0 && $row['order']->is_reordered == 0)
                    <td style="background-color: {{ $row['rowColor'] }}">Bulk New Order</td>
                @elseif ($row['order']->order_type == 1 && $row['order']->is_reordered == 0)
                    <td style="background-color: {{ $row['rowColor'] }}">TS Order</td>
                @elseif ($row['order']->is_reordered == 1)
                    <td style="background-color: {{ $row['rowColor'] }}">Reorder</td>
                @else
                    <td style="background-color: {{ $row['rowColor'] }}">New Order</td>
                @endif
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->userDetails->name }}</td>
                <td style="background-color: {{ $row['rowColor'] }}"></td>
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->order_item_count }}</td>
                <td style="background-color: {{ $row['rowColor'] }}">{{ $row['order']->shedule_comment }}</td>

            </tr>
        @endforeach

        @foreach($specialRows as $order)
            @php
                $rowColor = '';
                if ($order->order_status_id == 4) {
                    $rowColor = '#cdcdcd';
                } elseif ($order->order_status_id == 7) {
                    $rowColor = '#ff8989';
                } else {
                    $rowColor = $order->shedule_color;
                }
            @endphp
            <tr>
                <td style="background-color: {{ $rowColor }}">{{ $order->order_no }}</td>
                <td style="background-color: {{ $rowColor }}">{{ $order->factory_code }}</td>
                <td style="background-color: {{ $rowColor }}">{{ $order->organizationDetails->organization_name }}</td>
                <td style="background-color: {{ $rowColor }}">{{ $order->factory_confirmation_date }}</td>
                <td style="background-color: {{ $rowColor }}">{{ $order->ex_factory_date }}</td>
                <td style="background-color: {{ $rowColor }}">{{ $order->due_date }}</td>
                <td style="background-color: {{ $rowColor }}">{{ $order->statusDetails->status_name }}</td>
                <td style="background-color: {{ $rowColor }}">{{ $order->test_print_needed }}</td>
                @if ($order->is_urgent == 1)
                    <td style="background-color: {{ $rowColor }}">Urgent Order</td>
                @elseif ($order->order_type == 0 && $order->is_reordered == 0)
                    <td style="background-color: {{ $rowColor }}">Bulk New Order</td>
                @elseif ($order->order_type == 1 && $order->is_reordered == 0)
                    <td style="background-color: {{ $rowColor }}">TS Order</td>
                @elseif ($order->is_reordered == 1)
                    <td style="background-color: {{ $rowColor }}">Reorder</td>
                @else
                    <td style="background-color: {{ $rowColor }}">New Order</td>
                @endif
                <td style="background-color: {{ $rowColor }}">{{ $order->userDetails->name }}</td>
                <td style="background-color: {{ $rowColor }}"></td>
                <td style="background-color: {{ $rowColor }}">{{ $order->order_item_count }}</td>
                <td style="background-color: {{ $rowColor }}">{{ $order->shedule_comment }}</td>
            </tr>
        @endforeach



        <tbody>

        </tbody>
    </table>
</html>
