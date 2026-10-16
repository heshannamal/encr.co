<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <thead>
            <tr><th colspan="{{(empty($pricetype) ? 8 : 4)}}" style="background-color: #e06666; border: 1px solid #000000; text-align: center; font-weight: bold; font-size: 17px;">PRODUCT PRICE LIST </th></tr>
            <tr><td colspan="{{(empty($pricetype) ? 8 : 4)}}"></td></tr>

            <tr style="background-color: #bbbbbb;">
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PRODUCT NO</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PRODUCT NAME</th>
                <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc;">PATTERN CODE</th>
                @if(empty($pricetype) || $pricetype == 5)
                    <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc; text-align: right;">MANUFACTURER PRICE</th>
                @endif
                @if(empty($pricetype) || $pricetype == 1)
                    <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc; text-align: right;">GENERAL PRICE</th>
                @endif
                @if(empty($pricetype) || $pricetype == 2)
                    <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc; text-align: right;">SILVER PRICE</th>
                @endif
                @if(empty($pricetype) || $pricetype == 3)
                    <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc; text-align: right;">GOLD PRICE</th>
                @endif
                @if(empty($pricetype) || $pricetype == 4)
                    <th style=" font-weight: bold; font-size: 13px; background-color: #cccccc; text-align: right;">PLATINUM PRICE</th>
                @endif
            </tr>


        </thead>
        <tbody>
            @foreach($subProducts as $subProduct)
                <tr>
                    <td>{{ $subProduct->sub_product_no }}</td>
                    <td style="text-align: left">{{ $subProduct->product_name }}</td>
                    <td>{{ $subProduct->pattern_code }}</td>
                    @if(empty($pricetype) || $pricetype == 5)
                        <td>{{ $subProduct->price }}</td>
                    @endif
                    @if(empty($pricetype) || $pricetype == 1)
                        <td>{{ $subProduct->General_price }}</td>
                    @endif
                    @if(empty($pricetype) || $pricetype == 2)
                        <td>{{ $subProduct->Silver_price }}</td>
                    @endif
                    @if(empty($pricetype) || $pricetype == 3)
                        <td>{{ $subProduct->Gold_price }}</td>
                    @endif
                    @if(empty($pricetype) || $pricetype == 4)
                        <td>{{ $subProduct->Platinum_price }}</td>
                    @endif

                </tr>
            @endforeach
        </tbody>
    </table>
</html>
