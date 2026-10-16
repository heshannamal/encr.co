<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <tbody>
            <tr>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Product</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Player Numbers</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Player Name</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Quantity</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Size</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Total Quantity</td>
            </tr>

            @foreach ($itemData as $key => $items)
                @foreach ($items as $index => $rosterData)
                    <tr>
                        <td style="border: 1px solid #000000">{{$rosterData[5]}}</td>
                        <td style="border: 1px solid #000000">{{$rosterData[1]}}</td>
                        <td style="border: 1px solid #000000">{{$rosterData[2]}}</td>
                        <td style="border: 1px solid #000000">{{$rosterData[3]}}</td>
                        <td style="border: 1px solid #000000">{{$rosterData[4]}}</td>

                        @if ($index == 0)
                            <td style="border: 1px solid #000000; background-color: #f4cccc; text-align: center;" rowspan="{{count($items)}}">{{count($items)}}</td>
                        @endif
                    </tr>
                @endforeach

                @if($key < ($itemWithData - 1))
                    <tr><td colspan="5"></td></tr>
                @endif
            @endforeach

            <tr>
                <td style="background-color: #c4c4c4;" colspan="3"></td>
                <td style="border: 1px solid #000000; font-weight: bold; color: #ff0000;">{{$totalQty}}</td>
                <td style="background-color: #c4c4c4;" colspan="2"></td>
            </tr>
        </tbody>
    </table>
</html>
