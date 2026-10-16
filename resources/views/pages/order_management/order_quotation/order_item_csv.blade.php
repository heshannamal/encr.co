
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ITEM DETAIL SHEET</title>

</head>
<body>
    <table border="1px" style="border: 1px solid #000000;">

        <tbody style="border: 1px solid #000000;">
            <tr>
                <td></td>
                <td colspan="28"></td>
            </tr>
            <tr>
                <td></td>
                <th rowspan="7" colspan="3" style="text-align: center; vertical-align: middle; font-size: 14px; font-weight: bold; width: 350px; border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 5px solid #000000;">ITEM DETAIL SHEET</th>


                <td colspan="4" style="width:150px; font-size: 8px; font-weight: bold;  border-left: 2px solid #000000; border-top: 2px solid #000000; border-bottom: 1px solid grey;">ODS Date</td>
                <td colspan="11" style="width:180px; font-size: 8px; font-weight: 500; border-top: 2px solid #000000; border-bottom: 1px solid grey; border-left: 1px solid grey;">{{ $order->open_date }}</td>
                <td rowspan="7" style="width:30px;  border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-top: 2px solid #000000;"></td>
                <td colspan="4" rowspan="3" style="width:120px; font-size: 10px; font-weight: 600; text-align: left; border-left: 2px solid #000000; vertical-align: middle !important; border-top: 2px solid #000000; border-bottom: 1px solid grey;">Order #</td>
                <td colspan="5" rowspan="3" style="width:150px; font-size: 20px; font-weight: 700; text-align: center; border-right: 5px solid #000000; vertical-align: middle !important; border-top: 2px solid #000000; border-bottom: 1px solid grey; border-left: 1px solid grey;">#{{ $order->order_no }}</td>
            </tr>

            @php
                $Order_ex = App\Models\Order::where('id', $orderItem->order_id)->first();
            @endphp

            <tr>
                <td></td>
                <td colspan="4" style="font-weight: bold; font-size: 8px; border-left: 2px solid #000000; border-bottom: 1px solid grey;">Order Type</td>
                <td colspan="11" style=" font-size: 8px; font-weight: 500; border-bottom: 1px solid grey; border-left: 1px solid grey;">
                    <?php
                        if (strpos($Order_ex->order_no, 'WL') === 0) {
                            echo "WL Order";
                        } elseif (strpos($Order_ex->order_no, 'TSR') === 0) {
                            echo "TSR Order";
                        } else {
                            echo "Bulk Order";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" style="font-weight: bold; font-size: 8px; border-left: 2px solid #000000; border-bottom: 1px solid grey;">Embellishment Type</td>
                <td colspan="11" style=" font-size: 8px; font-weight: 500; border-bottom: 1px solid grey; border-left: 1px solid grey;">
                    @if ($orderItem->embellishmentDetails !== null)
                        {{ $orderItem->embellishmentDetails['embellishment_name'] }}
                    @endif
                </td>
            </tr>
            @php
                $sub_product_found = App\Models\SubProduct::where('sub_product_no', $orderItem->sub_product_no)->first();
            @endphp
            <tr>
                <td></td>
                <td colspan="4" style="font-weight: bold; font-size: 8px; border-left: 2px solid #000000; border-bottom: 1px solid grey;">Product</td>
                <td colspan="11" style=" font-size: 8px; font-weight: 500; border-left: 1px solid grey; border-bottom: 1px solid grey;">{{ $sub_product_found->product_name }}</td>
                <td colspan="4" style="font-weight: bold; font-size: 8px; border-left: 2px solid #000000; border-bottom: 1px solid grey;">Club</td>
                <td colspan="5" style=" font-size: 8px; font-weight: 500; border-right: 5px solid #000000; border-bottom: 1px solid grey; border-left: 1px solid grey;">{{ $order->organizationDetails['organization_name'] }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" style="font-weight: bold; font-size: 8px; border-left: 2px solid #000000; border-bottom: 1px solid grey;">Order Item Description</td>
                <td colspan="11" style=" font-size: 8px; font-weight: 500; border-bottom: 1px solid grey; border-left: 1px solid grey;">{{$orderItem->item_description ?? ''}}</td>
                <td colspan="4" style="font-weight: bold; font-size: 8px; border-left: 2px solid #000000; border-bottom: 1px solid grey;">Order Details</td>
                <td colspan="5" style=" font-size: 8px; font-weight: 500; border-right: 5px solid #000000; border-bottom: 1px solid grey; border-left: 1px solid grey;"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" style="font-weight: bold; font-size: 8px; border-left: 2px solid #000000; border-bottom: 1px solid grey;">Fabric</td>
                <td colspan="11" style=" font-size: 8px; font-weight: 500; border-bottom: 1px solid grey; border-left: 1px solid grey;">{{$orderItem->fabricDetails['fabric_name'] ?? 'N/A'}}</td>
                <td colspan="4" style="font-weight: bold; font-size: 8px; border-left: 2px solid #000000; border-bottom: 1px solid grey;">Label</td>
                <td colspan="5" style=" font-size: 8px; font-weight: 500; border-right: 5px solid #000000; border-bottom: 1px solid grey; border-left: 1px solid grey;"></td>

            </tr>
            <tr>
                <td></td>
                <td colspan="4" style="font-weight: bold; font-size: 8px; border-left: 2px solid #000000; border-bottom: 1px solid grey;">Pattern Reference</td>
                {{-- <td colspan="11" style=" font-size: 8px; font-weight: 500; border-bottom: 1px solid grey; border-left: 1px solid grey;">{{ $sub_product_found->pattern_code }}</td> --}}
                <td colspan="11" style=" font-size: 8px; font-weight: 500; border-bottom: 1px solid grey; border-left: 1px solid grey;">{{ domainencore\Facades\PatternCodeFacade\PatternCodeFacade::getOrderItemPatternCodeByOrderItemId($orderItem->id) }}</td>
                <td colspan="4" style="font-weight: bold; font-size: 8px; border-left: 2px solid #000000; border-bottom: 1px solid grey;">PO No</td>
                <td colspan="5" style=" font-size: 8px; font-weight: 500; border-right: 5px solid #000000; border-bottom: 1px solid grey; border-left: 1px solid grey;"></td>
            </tr>

            <tr>
                <td></td>
                <td colspan="28" style="border-bottom: 2px solid #000000; border-top: 2px solid #000000; height: 1px;"></td>
            </tr>

            <tr>
                <td></td>
                <td style="width: 50px; text-align: center; font-size: 10px; font-weight: 700; border-left: 2px solid #000000; border-right: 1px solid grey;">BLANKS</td>
                <td style="width: 50px; text-align: center; font-size: 10px; font-weight: 700; border-right: 1px solid grey;">Qtys</td>
                <td style="width: 130px; text-align: center; font-size: 10px; font-weight: 700; border-right: 1px solid grey;">Sizes</td>
                <td colspan="25" style="width: 120px; font-size: 10px; font-weight: 700; border-right: 5px solid #000000; text-align:center">Number Sequence</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="28" style="border-bottom: 2px solid #000000; border-top: 2px solid #000000; height: 1px;"></td>
            </tr>
            @php
                $sequences1 =[ 'one' ,'two' ,'three' ,'four' ,'five', 'six' ,'seven' ,'eight' ,'nine' ,'ten',

                            'eleven' ,'twelve' ,'thirteen' ,'fourteen' ,'fifteen' , 'sixteen' ,'seventeen' ,'eighteen' ,'nineteen' ,'twenty' ,

                            'twenty_one' ,'twenty_two' ,'twenty_three' ,'twenty_four'];

                $sequences2 =['twenty_six' ,'twenty_seven' ,'twenty_eight' ,'twenty_nine' ,'thirty' ,

                            'thirty_one' ,'thirty_two' ,'thirty_three' ,'thirty_four' ,'thirty_five' ,'thirty_six' ,'thirty_seven' ,'thirty_eight' ,'thirty_nine' ,'forty',

                            'forty_one' ,'forty_two' ,'forty_three' ,'forty_four' ,'forty_five' ,'forty_six' ,'forty_seven' ,'forty_eight' ,'forty_nine'];

                $sequences3 =['fifty_one' ,'fifty_two' ,'fifty_three' ,'fifty_four' ,'fifty_five' ,'fifty_six' ,'fifty_seven' ,'fifty_eight' ,'fifty_nine' ,'sixty' ,

                            'sixty_one' ,'sixty_two' ,'sixty_three' ,'sixty_four' ,'sixty_five' ,'sixty_six' ,'sixty_seven' ,'sixty_eight' ,'sixty_nine' ,'seventy',

                            'seventy_one' ,'seventy_two' ,'seventy_three' ,'seventy_four'];

                $sequences4 =['seventy_six' ,'seventy_seven' ,'seventy_eight' ,'seventy_nine' ,'eighty',

                            'eighty_one' ,'eighty_two' ,'eighty_three' ,'eighty_four' ,'eighty_five' ,'eighty_six' ,'eighty_seven' ,'eighty_eight' ,'eighty_nine' ,'ninety',

                            'ninety_one' ,'ninety_two' ,'ninety_three' ,'ninety_four' ,'ninety_five' ,'ninety_six' ,'ninety_seven' ,'ninety_eight' ,'ninety_nine'];

                $sequences5 =['hundred_one' ,'hundred_two' ,'hundred_three' ,'hundred_four' ,'hundred_five', 'hundred_six' ,'hundred_seven' ,'hundred_eight' ,'hundred_nine' ,'hundred_ten',

                            'hundred_eleven' ,'hundred_twelve' ,'hundred_thirteen' ,'hundred_fourteen' ,'hundred_fifteen' , 'hundred_sixteen' ,'hundred_seventeen' ,'hundred_eighteen' ,'hundred_nineteen' ,'hundred_twenty' ,

                            'hundred_twenty_one' ,'hundred_twenty_two' ,'hundred_twenty_three' ,'hundred_twenty_four'];

                $sequences6 = ['hundred_twenty_six' ,'hundred_twenty_seven' ,'hundred_twenty_eight' ,'hundred_twenty_nine' ,'hundred_thirty' ,

                            'hundred_thirty_one' ,'hundred_thirty_two' ,'hundred_thirty_three' ,'hundred_thirty_four' ,'hundred_thirty_five' ,'hundred_thirty_six' ,'hundred_thirty_seven' ,'hundred_thirty_eight' ,'hundred_thirty_nine' ,'hundred_forty',

                            'hundred_forty_one' ,'hundred_forty_two' ,'hundred_forty_three' ,'hundred_forty_four' ,'hundred_forty_five' ,'hundred_forty_six' ,'hundred_forty_seven' ,'hundred_forty_eight' ,'hundred_forty_nine'];
            @endphp

            @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                @if (!empty($orderItemDetail->blanks) || !empty($orderItemDetail->qty))
                    @php
                        $display2 = $display3 = $display4 = $display5 = $display6 = false;
                    @endphp

                    @foreach ($sequences2 as $sequence)
                        @if (($orderItemDetail->{'numseq_'.$sequence} !== null && $orderItemDetail->{'numseq_'.$sequence} !== ''))
                            @php $display2 = true; @endphp
                        @endif
                    @endforeach
                    @foreach ($sequences3 as $sequence)
                        @if (($orderItemDetail->{'numseq_'.$sequence} !== null && $orderItemDetail->{'numseq_'.$sequence} !== ''))
                            @php $display3 = true; @endphp
                        @endif
                    @endforeach
                    @foreach ($sequences4 as $sequence)
                        @if (($orderItemDetail->{'numseq_'.$sequence} !== null && $orderItemDetail->{'numseq_'.$sequence} !== ''))
                            @php $display4 = true; @endphp
                        @endif
                    @endforeach
                    @foreach ($sequences5 as $sequence)
                        @if (($orderItemDetail->{'numseq_'.$sequence} !== null && $orderItemDetail->{'numseq_'.$sequence} !== ''))
                            @php $display5 = true; @endphp
                        @endif
                    @endforeach
                    @foreach ($sequences6 as $sequence)
                        @if (($orderItemDetail->{'numseq_'.$sequence} !== null && $orderItemDetail->{'numseq_'.$sequence} !== ''))
                            @php $display6 = true; @endphp
                        @endif
                    @endforeach

                    @php
                        $colspan_count = $display6 ? 6 : ($display5 ? 5 : ($display4 ? 4 : ($display3 ? 3 : ($display2 ? 2 : 1))));
                    @endphp

                    @if ($orderItemDetail->sizeDetails['size_name'] == "Extra Size One" && isset($orderItem->extra_size))
                        @php
                            $size_name = $orderItem->extra_size;
                        @endphp
                    @elseif ($orderItemDetail->sizeDetails['size_name'] == "Extra Size Two" && isset($orderItem->extra_size_two))
                        @php
                            $size_name = $orderItem->extra_size_two;
                        @endphp
                    @elseif ($orderItemDetail->sizeDetails['size_name'] == "Extra Size Three" && isset($orderItem->extra_size_three))
                        @php
                            $size_name = $orderItem->extra_size_three;
                        @endphp
                    @else
                        @php
                            $size_name = $orderItemDetail->sizeDetails['size_name'];
                        @endphp
                    @endif

                    <tr>
                        <td></td>
                        <td rowspan="{{ $colspan_count }}" style="text-align: center; font-size: 10px; font-weight: 700; border-left: 5px solid #000000; border-right: 1px solid grey;">{{ $orderItemDetail->blanks }}</td>
                        <td rowspan="{{ $colspan_count }}" style="text-align: center; font-size: 10px; font-weight: 700; border-right: 1px solid grey;">{{ $orderItemDetail->qty }}</td>
                        <td rowspan="{{ $colspan_count }}" style="text-align: center; font-size: 10px; font-weight: 700;">{{ $size_name }}</td>

                        @foreach ($sequences1 as $sequence)
                            <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey">{{ $orderItemDetail->{'numseq_'.$sequence} ?? '' }}</td>
                        @endforeach

                        <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey; border-right: 5px solid #000000;">{{ $orderItemDetail->numseq_twenty_five ?? '' }}</td>
                    </tr>

                    @if ($display2)
                        <tr><td></td>
                            @foreach ($sequences2 as $sequence)
                                <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey">{{ $orderItemDetail->{'numseq_'.$sequence} ?? '' }}</td>
                            @endforeach
                            <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey; border-right: 5px solid #000000;">{{ $orderItemDetail->numseq_fifty ?? '' }}</td>
                        </tr>
                    @endif

                    @if ($display3)
                        <tr><td></td>
                            @foreach ($sequences3 as $sequence)
                                <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey">{{ $orderItemDetail->{'numseq_'.$sequence} ?? '' }}</td>
                            @endforeach
                            <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey; border-right: 5px solid #000000;">{{ $orderItemDetail->numseq_seventy_five ?? '' }}</td>
                        </tr>
                    @endif

                    @if ($display4)
                        <tr><td></td>
                            @foreach ($sequences4 as $sequence)
                                <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey">{{ $orderItemDetail->{'numseq_'.$sequence} ?? '' }}</td>
                            @endforeach
                            <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey; border-right: 5px solid #000000;">{{ $orderItemDetail->numseq_hundred ?? '' }}</td>
                        </tr>
                    @endif

                    @if ($display5)
                        <tr><td></td>
                            @foreach ($sequences5 as $sequence)
                                <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey">{{ $orderItemDetail->{'numseq_'.$sequence} ?? '' }}</td>
                            @endforeach
                            <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey; border-right: 5px solid #000000;">{{ $orderItemDetail->numseq_hundred_twenty_five ?? '' }}</td>
                        </tr>
                    @endif

                    @if ($display6)
                        <tr><td></td>
                            @foreach ($sequences6 as $sequence)
                                <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey">{{ $orderItemDetail->{'numseq_'.$sequence} ?? '' }}</td>
                            @endforeach
                            <td style="text-align: center; font-size: 10px; width: 30px; border: 1px solid grey; border-right: 5px solid #000000;">{{ $orderItemDetail->numseq_hundred_fifty ?? '' }}</td>
                        </tr>
                    @endif

                    <tr>
                        <td></td>
                        <td colspan="28" style="border-bottom: 2px solid #000000; border-top: 2px solid #000000; height: 1px;"></td>
                    </tr>
                @endif
            @endforeach


            <tr>
                <td></td>
                <th colspan="3" style="text-align: center; font-size: 10px; font-weight: 700; border-top: 2px solid #000000; border-left: 5px solid #000000;">Total Pieces</th>
                <th colspan="4" style="text-align: center; font-size: 10px; font-weight: 700;">{{ $orderItem->qty }}</th>
                <td colspan="21" style=" border-right: 5px solid #000000;"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="28" style="border-bottom: 2px solid #000000; border-top: 2px solid #000000; height: 2px; background-color:#000000"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
