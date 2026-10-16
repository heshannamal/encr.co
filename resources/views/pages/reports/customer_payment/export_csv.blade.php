<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <thead>
            <tr><th colspan="8" style="background-color: #e06666; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 17px;">CUSTOMER PAYMENT SUMMARY </th></tr>
            <tr><td colspan="8"></td></tr>

            <tr style="background-color: #bbbbbb;">
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORDER ID</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PAYMENT ID</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">TPAYMENT DATE</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PAYMENT STATUS</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">ORGANIZATION</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PAYMENT TYPE</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">NAME ON CARD</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PAYMENT APPROVAL</th>
            </tr>


        </thead>
        <tbody>
            @foreach($firstTenItems as $item)
                <tr>
                    <td>{{ $item['Order'] }}</td>
                    <td style="text-align: left">{{ $item['TransactionID'] }}</td>
                    <td>{{ date('m/d/Y', strtotime($item['PaymentDate'])) }}</td>
                    <td>{{ $item['OrderStatus'] }}</td>
                    <td>{{ $item['TeamName'] }}</td>
                    <td>{{ $item['PaymentType'] }}</td>
                    <td>{{ $item['NameonCard'] }}</td>
                    <td>{{ $item['checkStatus'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</html>
