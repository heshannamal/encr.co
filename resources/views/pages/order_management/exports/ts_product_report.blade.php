<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <tbody>
            <tr>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Product Code</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Product Name</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Fabric</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Embellishment</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Quantity</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Size</td>
                <td style="background-color: #e06666; border: 1px solid #000000; font-weight: bold;">Factory</td>
            </tr>

            @foreach ($itemData as $key => $items)
                @foreach ($items as $productData)
                    <tr>
                        <td style="border: 1px solid #000000">{{$productData[0]}}</td>
                        <td style="border: 1px solid #000000">{{$productData[1]}}</td>
                        <td style="border: 1px solid #000000">{{$productData[2]}}</td>
                        <td style="border: 1px solid #000000">{{$productData[3]}}</td>
                        <td style="border: 1px solid #000000">{{$productData[4]}}</td>
                        <td style="border: 1px solid #000000">{{$productData[5]}}</td>
                        <td style="border: 1px solid #000000">{{$productData[6]}}</td>
                    </tr>
                @endforeach

                @if($key < ($itemWithData - 1))
                    <tr><td colspan="7"></td></tr>
                @endif
            @endforeach

            <tr>
                <td style="background-color: #c4c4c4;" colspan="4"></td>
                <td style="border: 1px solid #000000; font-weight: bold; color: #ff0000;">{{$totalQty}}</td>
                <td style="background-color: #c4c4c4;" colspan="2"></td>
            </tr>
        </tbody>
    </table>
</html>
