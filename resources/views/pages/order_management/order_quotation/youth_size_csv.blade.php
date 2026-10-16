
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Youth Size Names</title>

</head>
    <body>
        <table border="1px">
            <tbody>
                <tr>
                    <th colspan="6" style="width:900px; height: 60px; font-size: 20px; font-weight: 700;">ENTER NAMES AND CORRESPONDING NUMBERS PER SIZE</th>
                </tr>

                @if ($orderItemsDetails->individual_name == 1 && $orderItemsDetails->individual_no == 0)
                    <tr>
                        @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                            @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0 && $orderItemDetail->playerDetails !== null && $orderItemDetail->playerDetails['blank_player_names'])
                                <th style="width: 200px; text-align: center; font-size: 13px; font-weight: 700; border: 2px solid #000000; background-color: #fff5de;">{{ $orderItemDetail->sizeDetails['size_name'] }} Name</th>
                            @endif
                        @endforeach
                    </tr>
                    {{-- @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)
                            @if ($orderItemDetail->playerDetails !== null)
                                @if ($orderItemDetail->playerDetails['blank_player_names'])
                                    @php
                                         $blankPlayerNames = [];
                                         $blankPlayerNames = json_decode($orderItemDetail->playerDetails['blank_player_names']);
                                         $blRowCount = 0
                                    @endphp
                                    @foreach ($blankPlayerNames as $blankPlayerName)
                                         <tr>
                                             <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                                 {{ $blankPlayerName }}
                                             </th>
                                             <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">yb1
                                             </th>
                                         </tr>
                                    @endforeach
                                @endif
                            @endif
                        @endif
                    @endforeach --}}
                    @for ($i = 0; $i < 150; $i++)
                    <tr>
                        @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                            @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)
                                @if ($orderItemDetail->playerDetails !== null)
                                    @if ($orderItemDetail->playerDetails['blank_player_names'])
                                        @php
                                            $blankPlayerNames = [];
                                            $blankPlayerNames = json_decode($orderItemDetail->playerDetails['blank_player_names']);
                                            $blRowCount = 0
                                        @endphp
                                        <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                            {{ isset($blankPlayerNames[$i]) ? $blankPlayerNames[$i] : '' }}
                                        </th>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </tr>
                    @endfor
                @else

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)
                            <th style="width: 200px; text-align: center; font-size: 13px; font-weight: 700; border: 2px solid #000000; background-color: #fff5de;">{{ $orderItemDetail->sizeDetails['size_name'] }} Name</th>
                            <th style="width: 100px; text-align: center; font-size: 13px; font-weight: 700; border: 2px solid #000000; background-color: #fff5de;">{{ $orderItemDetail->sizeDetails['size_name'] }} <br> Number</th>
                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_ten']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ten}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eleven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eleven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_twelve']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twelve}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fourteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fourteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_sixteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seventeen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventeen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eighteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_nineteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_nineteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_twenty']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twenty}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_twenty_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twenty_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_twenty_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twenty_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_twenty_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twenty_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_twenty_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twenty_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_twenty_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twenty_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_twenty_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twenty_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                               @if ($orderItemDetail->playerDetails !== null) {{$orderItemDetail->playerDetails['player_twenty_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twenty_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_twenty_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twenty_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_twenty_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_twenty_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirty']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirty}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirty_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirty_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirty_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirty_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirty_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirty_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirty_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirty_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirty_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirty_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirty_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirty_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirty_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirty_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirty_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirty_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_thirty_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_thirty_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_forty']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_forty}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_forty_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_forty_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_forty_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_forty_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_forty_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_forty_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_forty_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_forty_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_forty_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_forty_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_forty_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_forty_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_forty_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_forty_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                               @if ($orderItemDetail->playerDetails !== null) {{$orderItemDetail->playerDetails['player_forty_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_forty_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_forty_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_forty_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifty']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifty}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifty_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifty_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifty_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifty_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifty_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifty_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifty_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifty_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifty_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifty_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifty_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifty_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifty_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifty_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifty_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifty_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_fifty_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_fifty_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                               @if ($orderItemDetail->playerDetails !== null) {{$orderItemDetail->playerDetails['player_sixty']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixty}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_sixty_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixty_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_sixty_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixty_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_sixty_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixty_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_sixty_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixty_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_sixty_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixty_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_sixty_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixty_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_sixty_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixty_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_sixty_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixty_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_sixty_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_sixty_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seventy']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventy}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seventy_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventy_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                               @if ($orderItemDetail->playerDetails !== null) {{$orderItemDetail->playerDetails['player_seventy_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventy_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seventy_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventy_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seventy_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventy_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seventy_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventy_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seventy_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventy_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seventy_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventy_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seventy_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventy_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_seventy_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_seventy_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eighty']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighty}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eighty_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighty_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eighty_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighty_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eighty_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighty_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eighty_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighty_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                               @if ($orderItemDetail->playerDetails !== null) {{$orderItemDetail->playerDetails['player_eighty_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighty_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eighty_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighty_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eighty_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighty_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eighty_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighty_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_eighty_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_eighty_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_ninety']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ninety}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_ninety_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ninety_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_ninety_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ninety_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_ninety_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ninety_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_ninety_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ninety_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_ninety_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ninety_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_ninety_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ninety_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                               @if ($orderItemDetail->playerDetails !== null) {{$orderItemDetail->playerDetails['player_ninety_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ninety_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_ninety_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ninety_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_ninety_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_ninety_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred}}</th>

                        @endif
                    @endforeach
                </tr>
                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_ten']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_ten}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_eleven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_eleven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_twelve']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twelve}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_fourteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_fourteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_fifteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_fifteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_sixteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_sixteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_seventeen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_seventeen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_eighteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_eighteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_nineteen']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_nineteen}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_twenty']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twenty}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_twenty_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twenty_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_twenty_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twenty_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_twenty_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twenty_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_twenty_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twenty_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_twenty_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twenty_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_twenty_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twenty_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                               @if ($orderItemDetail->playerDetails !== null) {{$orderItemDetail->playerDetails['player_hundred_twenty_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twenty_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_twenty_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twenty_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_twenty_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_twenty_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirty']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirty}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirty_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirty_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirty_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirty_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirty_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirty_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirty_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirty_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirty_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirty_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirty_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirty_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirty_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirty_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirty_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirty_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_thirty_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_thirty_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_forty']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_forty}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_forty_one']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_forty_one}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_forty_two']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_forty_two}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_forty_three']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_forty_three}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_forty_four']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_forty_four}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_forty_five']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_forty_five}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_forty_six']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_forty_six}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_forty_seven']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_forty_seven}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                               @if ($orderItemDetail->playerDetails !== null) {{$orderItemDetail->playerDetails['player_hundred_forty_eight']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_forty_eight}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_forty_nine']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_forty_nine}}</th>

                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($orderItemsDetails->orderItemDetails as $orderItemDetail)
                        @if (strpos($orderItemDetail->sizeDetails['size_name'], 'Youth') === 0)

                            <th style="width: 200px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                @if ($orderItemDetail->playerDetails !== null){{$orderItemDetail->playerDetails['player_hundred_fifty']}}@endif</th>
                            <th style="width: 100px; text-align: center;  font-size: 9px; background-color: #f0ece8; border: 2px solid #000000;">
                                {{$orderItemDetail->numseq_hundred_fifty}}</th>

                        @endif
                    @endforeach
                </tr>

                @endif

            </tbody>
            {{-- {{ dd('hi') }} --}}
        </table>
    </body>
</html>
