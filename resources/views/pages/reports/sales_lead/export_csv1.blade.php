<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <tbody>
            <tr><th colspan="6" style="background-color: #e06666; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 17px;">SALES LEAD SUMMARY {{ $selectedCategory }}</th></tr>
            <tr><td colspan="6"></td></tr>

            <tr style="background-color: #bbbbbb;">
                <th style=" font-weight: bold; font-size: 15px; background-color: #cccccc;">ORDER ID</th>
                <th style=" font-weight: bold; font-size: 15px; background-color: #cccccc;">CREATED DATE</th>
                <th style=" font-weight: bold; font-size: 15px; background-color: #cccccc;">IN HAND DUE DATE</th>
                <th style=" font-weight: bold; font-size: 15px; background-color: #cccccc;">ORGANIZATION </th>
                <th style=" font-weight: bold; font-size: 15px; background-color: #cccccc;">ITEM QTY</th>
                <th style=" font-weight: bold; font-size: 15px; background-color: #cccccc;">TOTAL ($)</th>
            </tr>

            @foreach ($viewOrders as $viewOrder)
                <tr>
                    <td>{{ $viewOrder->order_no }}</td>
                    <td>{{ $viewOrder->open_date }}</td>
                    <td>{{ $viewOrder->due_date }}</td>
                    <td>{{ $viewOrder['organizationDetails']->organization_name }}</td>
                    <td>{{ $viewOrder->order_items_count }}</td>
                    <td style="text-align: right;">{{ $viewOrder->order_total }}</td>
                </tr>
            @endforeach

            @php
                $totalOrderItems = $viewOrders->sum('order_items_count');
                $orderTotal = $viewOrders->sum('order_total');
            @endphp

            <tr style="background-color: #e8e8e8;">
                <th colspan="4"  style=" font-weight: bold; font-size: 15px; background-color: #e9e9e9; text-align: center;">Total</th>
                <th  style=" font-weight: bold; font-size: 13px; background-color: #e9e9e9;">{{ $totalOrderItems }}</th>
                <th  style=" font-weight: bold; font-size: 13px; background-color: #e9e9e9; text-align: right;">{{ $orderTotal }}</th>
            </tr>
        </tbody>
    </table>
</html>
