<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <table>
        <tbody>
            <tr><th colspan="4" style="background-color: #e06666; border: 1px solid #000000; text-align: center; font-weight: bold;">ORDER DETAILS SHEET (Bulk Order)</th></tr>
            <tr><td colspan="4"></td></tr>

            <tr>
                <td style="background-color: #ea9999; border: 1px solid #000000; font-weight: bold;">ODS Date</td>
                <td style="background-color: #ea9999; border: 1px solid #000000">{{$nowDate}}</td>
                <td style="background-color: #ea9999; border: 1px solid #000000; font-weight: bold;">Order #</td>
                <td style="background-color: #ea9999; border: 1px solid #000000">{{$order->order_no}}</td>
            </tr>

            <tr>
                <td style="background-color: #ea9999; border: 1px solid #000000; font-weight: bold;">Club Name</td>
                <td style="background-color: #ea9999; border: 1px solid #000000">{{$order->organizationDetails->organization_name}}</td>
                <td style="background-color: #ea9999; border: 1px solid #000000; font-weight: bold;">Ex factory Date</td>
                <td style="background-color: #ea9999; border: 1px solid #000000">{{$order->ex_factory_date}}</td>
            </tr>

            <tr>
                <td style="background-color: #ea9999; border: 1px solid #000000; font-weight: bold;">Shipping Address</td>
                <td style="background-color: #ea9999; border: 1px solid #000000">{{$address}}</td>
                <td style="background-color: #ea9999; border: 1px solid #000000; font-weight: bold;">Po No #</td>
                <td style="background-color: #ea9999; border: 1px solid #000000"></td>
            </tr>

            <tr><td colspan="4"></td></tr>

            @foreach ($order->orderItems as $orderItem)
                <tr>
                    <td style="border: 1px solid #000000; font-weight: bold;">Order Type</td>
                    <td style="border: 1px solid #000000">{{$orderItem->embellishmentDetails->embellishment_name ?? ''}}</td>
                    <td style="border: 1px solid #000000; font-weight: bold;">Order Item #</td>
                    <td style="border: 1px solid #000000">{{$orderItem->item_no}}</td>
                </tr>

                @php
                    $sub_product_found = App\Models\SubProduct::where('sub_product_no', $orderItem->sub_product_no)->first();
                @endphp

                <tr>
                    <td style="border: 1px solid #000000; font-weight: bold;">Product</td>
                    <td style="border: 1px solid #000000">{{$sub_product_found->product_name ?? ''}}</td>
                    <td style="border: 1px solid #000000; font-weight: bold;">Ex Factory Date</td>
                    <td style="border: 1px solid #000000">{{$orderItem->ex_factory_date}}</td>
                </tr>

                <tr>
                    <td style="border: 1px solid #000000; font-weight: bold;">Pattern #</td>
                    {{-- <td style="border: 1px solid #000000">{{$sub_product_found->pattern_code ?? ''}}</td> --}}
                    <td style="border: 1px solid #000000">{{ domainencore\Facades\PatternCodeFacade\PatternCodeFacade::getOrderItemPatternCodeByOrderItemId($orderItem->id) }}</td>
                    <td style="border: 1px solid #000000; font-weight: bold;">Order Reference</td>
                    <td style="border: 1px solid #000000">{{$orderRef}}</td>
                </tr>

                <tr>
                    <td style="border: 1px solid #000000; font-weight: bold;">Fabric</td>
                    <td style="border: 1px solid #000000">{{$orderItem->fabricDetails->fabric_name ?? ''}}</td>
                    <td style="border: 1px solid #000000; font-weight: bold;">Factory</td>
                    <td style="border: 1px solid #000000">{{$orderItem->factoryDetails->factory_code ?? ''}}</td>
                </tr>

                <tr>
                    <td style="border: 1px solid #000000; font-weight: bold;">Order Item Description</td>
                    <td style="border: 1px solid #000000">{{$orderItem->item_description ?? ''}}</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr><td colspan="4"></td></tr>
            @endforeach
        </tbody>
    </table>
</html>
