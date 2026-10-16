<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <thead>
            <tr><th colspan="9" style="background-color: #e06666; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 17px;">SALES INVOICE SUMMARY </th></tr>
            <tr><td colspan="9"></td></tr>

            <tr style="background-color: #bbbbbb;">
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER ID</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORGANIZATION</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">TOTAL ($) </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PAID ($)</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PAYMENT STATUS  </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PAYMENT APPROVAL </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PAYMENT TYPE </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">CREATED DATE </th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">IN HAND DUE DATE </th>
            </tr>


        </thead>

        <tbody>
            @foreach($firstTenItems as $item)
            <tr>
                <td>{{ $item['details']['order']['order_no'] }}</td>
                <td>{{ $item['details']['organization']->organization_name }}</td>
                <td style="text-align: right">{{ $item['details']['order']->order_total }}</td>
                <td style="text-align: right">{{ $item['details']['payedAmount'] }}</td>
                <td>{{ $item['details']['paymentStatus'] }}</td>
                @if (isset($item['details']['paymentApproval']) )
                    <td>{{ $item['details']['paymentApproval'] }}</td>
                @else
                    <td>{{ 'Not Approved' }}</td>
                @endif
                <td>{{ $item['details']['paymentTypes'] }}</td>
                <td>{{ $item['details']['order']['open_date'] }}</td>
                <td>{{ $item['details']['order']['due_date'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</html>
