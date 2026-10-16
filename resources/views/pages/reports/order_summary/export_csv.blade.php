<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <thead>
            <tr><th colspan="12" style="background-color: #e06666; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 17px;">ORDER SUMMARY REPORT</th></tr>
            <tr><td colspan="12"></td></tr>

            <tr style="background-color: #bbbbbb;">
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER ID</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORGANIZATION</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">FACTORY</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER CREATED DATE</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">SENT TO PRODUCTION</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">FACTORY CONFIRMED</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">CONFIRMED EX FACTORY DATE </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">IN HAND DUE DATE </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">TEST PRINT NEEDED? </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER TYPE </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER QTY</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER TOTAL</th>
            </tr>


        </thead>
            @foreach($firstTenItems as $item)
                <tr>
                    <td>{{ $item->order_no }}</td>
                    <td>{{ $item->organizationDetails->organization_name }}</td>
                    <td>{{ $item->factory_code }}</td>
                    <td>{{ date('m/d/Y', strtotime($item->created_at)) }}</td>
                    <td>{{ $item->production_date }}</td>
                    @if ($item->reject_or_confirm == 1)
                        <td>Rejected</td>
                    @else
                        <td>Confirmed</td>
                    @endif
                    <td>{{ $item->ex_factory_date }}</td>
                    <td>{{ $item->due_date }}</td>
                    <td>{{ $item->test_print_needed }}</td>
                    @if ($item->is_urgent == 1)
                        <td>Urgent Order</td>
                    @elseif ($item->order_type == 0 &&  $item->is_reordered == 0)
                        <td>Bulk New Order</td>
                    @elseif ($item->order_type == 1 &&  $item->is_reordered == 0)
                        <td>TS Order</td>
                    @elseif ($item->is_reordered == 1)
                        <td>Reorder</td>
                    @else
                        <td>New Order</td>
                    @endif
                    <td>{{ $item->order_item_count }}</td>
                    <td style="text-align: right">{{ $item->order_total }}</td>
                </tr>
            @endforeach
        <tbody>

        </tbody>
    </table>
</html>
