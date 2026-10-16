@extends('layouts.app', ['activePage' => 'order', 'titlePage' => __('Pdf')])

@section('content')
    <style>
        .table thead th {
            text-transform: capitalize !important;
            font-size: .8125rem
        }

        .num-seq {
            display: flex;
            height: 30px;
        }

        .num-seq h5 {
            border: 1px solid #d2d2d2;
            padding: 5px;
            margin-bottom: 0rem;
            width: 23px;
            text-align: center;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        }
        }

    </style>
<div class="se-pre-con"></div>

<div style="background-color: transparent !important;" class="container-fluid" id="pdf_print">
    <table id="projectSpreadsheet" class="fixed_headers" style="width:875px">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>

        


        <tbody id="tbodyid">
            @foreach ($orders as $order)
                <input type="hidden" id="pdf_id" value="{{ $order->id }}" />

                <tr>
                    <td>Organization :</td>
                    <td>{{$order->organizationDetails['organization_name']}}</td>
                    <td></td>
                    <td>Order # :</td>
                    <td>{{$order->order_no}}</td>
                </tr>
                <tr>
                    <td>Status :</td>
                    <td>{{$order->statusDetails['status_name']}}</td>
                    <td></td>
                    <td>Sales Rep :</td>
                    <td>{{$order->userDetails['name']}}</td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Shipping Address:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Billing Address:</td>
                </tr>
                <tr>
                    <td>{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$order->contactDetails['first_name']}} {{$order->contactDetails['last_name']}}</td>
                </tr>
                <tr>
                    <td>{{$order->street}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$order->street}}</td>
                </tr>
                <tr>
                    <td>{{$order->city}} {{$order->state}} {{$order->postal_code}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$order->city}} {{$order->state}} {{$order->postal_code}}</td>
                </tr>
                <tr>
                    <td>{{$order->country}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$order->country}}</td>
                </tr>
                <tr>
                    <td>{{$order->phone_no}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$order->phone_no}}</td>
                </tr>
                <tr>
                    <td>{{$order->email}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{$order->email}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                @foreach ($order->orderItems as $orderItem)
                    <tr>
                        <td>Order Item #:</td>
                        <td>{{ $orderItem->item_no }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Style Name:</td>
                        <td>{{ $orderItem->productDetails['product_name'] }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Item Status:</td>
                        <td>{{ $orderItem->statusDetails['status_name'] }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Open Date:</td>
                        <td>{{ $orderItem->open_date }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @if ($orderItem->close_date)
                        <tr>
                            <td>Close Date:</td>
                            <td>{{ $orderItem->close_date }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    <tr>
                        <td>Ex Factory Date:</td>
                        <td>{{ $orderItem->ex_factory_date }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>In Hand Due Date:</td>
                        <td>{{ $orderItem->in_hand_due_date }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Factory:</td>
                        <td>@if(isset($orderItem->factoryDetails['factory_code'])){{ $orderItem->factoryDetails['factory_code'] }}@endif</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Primary Fabric:</td>
                        <td>@if(isset($orderItem->fabricDetails['fabric_name'])){{ $orderItem->fabricDetails['fabric_name'] }}@endif</td>
                        <td></td>
                        <td>Tracking No:</td>
                        <td>{{ $orderItem->tracking_no ?: '--' }}</td>
                    </tr>
                    <tr>
                        <td>Secondary Fabric:</td>
                        <td>@if(isset($orderItem->secFabricDetails['fabric_name'])){{ $orderItem->secFabricDetails['fabric_name'] }}@endif</td>
                        <td></td>
                        <td>Tracking Link:</td>
                        <td>{{ $orderItem->tracking_link ?: '--' }}</td>
                    </tr>
                    <tr>
                        <td>Embellishment:</td>
                        <td>@if(isset($orderItem->embellishmentDetails['embellishment_name'])){{ $orderItem->embellishmentDetails['embellishment_name'] }}@endif</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Double Sided</td>
                        <td>@if ($orderItem->double_sided == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                        <td></td>
                        <td>Individual Number</td>
                        <td>@if ($orderItem->individual_no == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                    </tr>
                    <tr>
                        <td>Pockets</td>
                        <td>@if ($orderItem->pockets == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                        <td></td>
                        <td>Individual Name</td>
                        <td>@if ($orderItem->individual_name == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                    </tr>
                    <tr>
                        <td>Zippered Pockets</td>
                        <td>@if ($orderItem->zipper_pockets == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                        <td></td>
                        <td>Dynamic Details</td>
                        <td>@if ($orderItem->dynamic_details == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                    </tr>
                    <tr>
                        <td>Contrast Stitching</td>
                        <td>@if ($orderItem->contrast_stratching == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                        <td></td>
                        <td>Printing over Seams</td>
                        <td>@if ($orderItem->printing_over_sems == 1) {{ 'True' }} @else <i class="far fa-square"></i> @endif</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Blank Qty</td>
                        <td>Num Qty</td>
                        <td>Sizes</td>
                        <td colspan="50">Sequences</td>
                    </tr>
                    @foreach ($orderItem->orderItemDetails as $orderItemDetail)
                        @if ($orderItemDetail->qty || $orderItemDetail->blanks)
                            <tr>
                                <td>{{ $orderItemDetail->blanks }}</td>
                                <td>{{ $orderItemDetail->qty }}</td>
                                <td>{{ $orderItemDetail->sizeDetails['size_name'] }}</td>

                                @if ($orderItemDetail->numseq_one !== null && $orderItemDetail->numseq_one !== '') <td>{{ $orderItemDetail->numseq_one }} </td> @endif
                                @if ($orderItemDetail->numseq_two !== null && $orderItemDetail->numseq_two !== '') <td>{{ $orderItemDetail->numseq_two }} </td> @endif
                                @if ($orderItemDetail->numseq_three !== null && $orderItemDetail->numseq_three !== '') <td>{{ $orderItemDetail->numseq_three }} </td> @endif
                                @if ($orderItemDetail->numseq_four !== null && $orderItemDetail->numseq_four !== '') <td>{{ $orderItemDetail->numseq_four }} </td> @endif
                                @if ($orderItemDetail->numseq_five !== null && $orderItemDetail->numseq_five !== '') <td>{{ $orderItemDetail->numseq_five }} </td> @endif
                                @if ($orderItemDetail->numseq_six !== null && $orderItemDetail->numseq_six !== '') <td>{{ $orderItemDetail->numseq_six }} </td> @endif
                                @if ($orderItemDetail->numseq_seven !== null && $orderItemDetail->numseq_seven !== '') <td>{{ $orderItemDetail->numseq_seven }} </td> @endif
                                @if ($orderItemDetail->numseq_eight !== null && $orderItemDetail->numseq_eight !== '') <td>{{ $orderItemDetail->numseq_eight }} </td> @endif
                                @if ($orderItemDetail->numseq_nine !== null && $orderItemDetail->numseq_nine !== '') <td>{{ $orderItemDetail->numseq_nine }} </td> @endif
                                @if ($orderItemDetail->numseq_ten !== null && $orderItemDetail->numseq_ten !== '') <td>{{ $orderItemDetail->numseq_ten }} </td> @endif
                                @if ($orderItemDetail->numseq_eleven !== null && $orderItemDetail->numseq_eleven !== '') <td>{{ $orderItemDetail->numseq_eleven }} </td> @endif
                                @if ($orderItemDetail->numseq_twelve !== null && $orderItemDetail->numseq_twelve !== '') <td>{{ $orderItemDetail->numseq_twelve }} </td> @endif
                                @if ($orderItemDetail->numseq_thirteen !== null && $orderItemDetail->numseq_thirteen !== '') <td>{{ $orderItemDetail->numseq_thirteen }} </td> @endif
                                @if ($orderItemDetail->numseq_fourteen !== null && $orderItemDetail->numseq_fourteen !== '') <td>{{ $orderItemDetail->numseq_fourteen }} </td> @endif
                                @if ($orderItemDetail->numseq_fifteen !== null && $orderItemDetail->numseq_fifteen !== '') <td>{{ $orderItemDetail->numseq_fifteen }} </td> @endif
                                @if ($orderItemDetail->numseq_sixteen !== null && $orderItemDetail->numseq_sixteen !== '') <td>{{ $orderItemDetail->numseq_sixteen }} </td> @endif
                                @if ($orderItemDetail->numseq_seventeen !== null && $orderItemDetail->numseq_seventeen !== '') <td>{{ $orderItemDetail->numseq_seventeen }} </td> @endif
                                @if ($orderItemDetail->numseq_eighteen !== null && $orderItemDetail->numseq_eighteen !== '') <td>{{ $orderItemDetail->numseq_eighteen }} </td> @endif
                                @if ($orderItemDetail->numseq_nineteen !== null && $orderItemDetail->numseq_nineteen !== '') <td>{{ $orderItemDetail->numseq_nineteen }} </td> @endif
                                @if ($orderItemDetail->numseq_twenty !== null && $orderItemDetail->numseq_twenty !== '') <td>{{ $orderItemDetail->numseq_twenty }} </td> @endif
                                @if ($orderItemDetail->numseq_twenty_one !== null && $orderItemDetail->numseq_twenty_one !== '') <td>{{ $orderItemDetail->numseq_twenty_one }} </td> @endif
                                @if ($orderItemDetail->numseq_twenty_two !== null && $orderItemDetail->numseq_twenty_two !== '') <td>{{ $orderItemDetail->numseq_twenty_two }} </td> @endif
                                @if ($orderItemDetail->numseq_twenty_three !== null && $orderItemDetail->numseq_twenty_three !== '') <td>{{ $orderItemDetail->numseq_twenty_three }} </td> @endif
                                @if ($orderItemDetail->numseq_twenty_four !== null && $orderItemDetail->numseq_twenty_four !== '') <td>{{ $orderItemDetail->numseq_twenty_four }} </td> @endif
                                @if ($orderItemDetail->numseq_twenty_five !== null && $orderItemDetail->numseq_twenty_five !== '') <td>{{ $orderItemDetail->numseq_twenty_five }} </td> @endif
                                @if ($orderItemDetail->numseq_twenty_six !== null && $orderItemDetail->numseq_twenty_six !== '') <td>{{ $orderItemDetail->numseq_twenty_six }} </td> @endif
                                @if ($orderItemDetail->numseq_twenty_seven !== null && $orderItemDetail->numseq_twenty_seven !== '') <td>{{ $orderItemDetail->numseq_twenty_seven }} </td> @endif
                                @if ($orderItemDetail->numseq_twenty_eight !== null && $orderItemDetail->numseq_twenty_eight !== '') <td>{{ $orderItemDetail->numseq_twenty_eight }} </td> @endif
                                @if ($orderItemDetail->numseq_twenty_nine !== null && $orderItemDetail->numseq_twenty_nine !== '') <td>{{ $orderItemDetail->numseq_twenty_nine }} </td> @endif
                                @if ($orderItemDetail->numseq_thirty !== null && $orderItemDetail->numseq_thirty !== '') <td>{{ $orderItemDetail->numseq_thirty }} </td> @endif
                                @if ($orderItemDetail->numseq_thirty_one !== null && $orderItemDetail->numseq_thirty_one !== '') <td>{{ $orderItemDetail->numseq_thirty_one }} </td> @endif
                                @if ($orderItemDetail->numseq_thirty_two !== null && $orderItemDetail->numseq_thirty_two !== '') <td>{{ $orderItemDetail->numseq_thirty_two }} </td> @endif
                                @if ($orderItemDetail->numseq_thirty_three !== null && $orderItemDetail->numseq_thirty_three !== '') <td>{{ $orderItemDetail->numseq_thirty_three }} </td> @endif
                                @if ($orderItemDetail->numseq_thirty_four !== null && $orderItemDetail->numseq_thirty_four !== '') <td>{{ $orderItemDetail->numseq_thirty_four }} </td> @endif
                                @if ($orderItemDetail->numseq_thirty_five !== null && $orderItemDetail->numseq_thirty_five !== '') <td>{{ $orderItemDetail->numseq_thirty_five }} </td> @endif
                                @if ($orderItemDetail->numseq_thirty_six !== null && $orderItemDetail->numseq_thirty_six !== '') <td>{{ $orderItemDetail->numseq_thirty_six }} </td> @endif
                                @if ($orderItemDetail->numseq_thirty_seven !== null && $orderItemDetail->numseq_thirty_seven !== '') <td>{{ $orderItemDetail->numseq_thirty_seven }} </td> @endif
                                @if ($orderItemDetail->numseq_thirty_eight !== null && $orderItemDetail->numseq_thirty_eight !== '') <td>{{ $orderItemDetail->numseq_thirty_eight }} </td> @endif
                                @if ($orderItemDetail->numseq_thirty_nine !== null && $orderItemDetail->numseq_thirty_nine !== '') <td>{{ $orderItemDetail->numseq_thirty_nine }} </td> @endif
                                @if ($orderItemDetail->numseq_forty !== null && $orderItemDetail->numseq_forty !== '') <td>{{ $orderItemDetail->numseq_forty }} </td> @endif
                                @if ($orderItemDetail->numseq_forty_one !== null && $orderItemDetail->numseq_forty_one !== '') <td>{{ $orderItemDetail->numseq_forty_one }} </td> @endif
                                @if ($orderItemDetail->numseq_forty_two !== null && $orderItemDetail->numseq_forty_two !== '') <td>{{ $orderItemDetail->numseq_forty_two }} </td> @endif
                                @if ($orderItemDetail->numseq_forty_three !== null && $orderItemDetail->numseq_forty_three !== '') <td>{{ $orderItemDetail->numseq_forty_three }} </td> @endif
                                @if ($orderItemDetail->numseq_forty_four !== null && $orderItemDetail->numseq_forty_four !== '') <td>{{ $orderItemDetail->numseq_forty_four }} </td> @endif
                                @if ($orderItemDetail->numseq_forty_five !== null && $orderItemDetail->numseq_forty_five !== '') <td>{{ $orderItemDetail->numseq_forty_five }} </td> @endif
                                @if ($orderItemDetail->numseq_forty_six !== null && $orderItemDetail->numseq_forty_six !== '') <td>{{ $orderItemDetail->numseq_forty_six }} </td> @endif
                                @if ($orderItemDetail->numseq_forty_seven !== null && $orderItemDetail->numseq_forty_seven !== '') <td>{{ $orderItemDetail->numseq_forty_seven }} </td> @endif
                                @if ($orderItemDetail->numseq_forty_eight !== null && $orderItemDetail->numseq_forty_eight !== '') <td>{{ $orderItemDetail->numseq_forty_eight }} </td> @endif
                                @if ($orderItemDetail->numseq_forty_nine !== null && $orderItemDetail->numseq_forty_nine !== '') <td>{{ $orderItemDetail->numseq_forty_nine }} </td> @endif
                                @if ($orderItemDetail->numseq_fifty !== null && $orderItemDetail->numseq_fifty !== '') <td>{{ $orderItemDetail->numseq_fifty }} </td> @endif

                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td>Total Blank Qty</td>
                        <td>Total Num Qty</td>
                        <td>Total Qty</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>@php
                            $totalBlank = 0;
                            foreach ($orderItem->orderItemDetails as $orderItemDetail) {
                                $totalBlank += $orderItemDetail->blanks;
                            }
                        @endphp {{ $totalBlank }} </td>
                        <td>@php
                            $totalNum = 0;
                            foreach ($orderItem->orderItemDetails as $orderItemDetail) {
                                $totalNum += $orderItemDetail->qty;
                            }
                        @endphp {{ $totalNum }} </td>
                        <td>{{ $orderItem->qty ?? 0 }}</td>
                        <td colspan="50"></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table><br>
    <a href="{{url('order_details/edit')}}/{{$order->id}}/?active_tab=order" id="redirect_link" style="display: none;">redirect link</a>
    <button hidden onclick="exportTableToCSV({{ $order->id }})" id="btnGen">Export HTML Table To CSV File</button>
</div>
    <script>
        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++)
                    row.push(cols[j].innerText);

                csv.push(row.join(","));
            }

            // Download CSV file
            downloadCSV(csv.join("\n"), filename);
        }

        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csvFile = new Blob([csv], {
                type: "text/csv"
            });

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = "Roster_"+filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide download link
            downloadLink.style.display = "none";

            // Add the link to DOM
            document.body.appendChild(downloadLink);

            // Click download link
            downloadLink.click();
            setTimeout(function(){
                $('#redirect_link')[0].click();
            },5000);
        }

        $(document).ready(function() {
            $("#btnGen").click();
        });



        /*function exportTableToCSV($table, filename) {

            var $rows = $table.find('tr:has(td),tr:has(th)'),

                // Temporary delimiter characters unlikely to be typed by keyboard
                // This is to avoid accidentally splitting the actual contents
                tmpColDelim = String.fromCharCode(11), // vertical tab character
                tmpRowDelim = String.fromCharCode(0), // null character

                // actual delimiter characters for CSV format
                colDelim = '","',
                rowDelim = '"\r\n"',

                // Grab text from table into CSV formatted string
                csv = '"' + $rows.map(function(i, row) {
                    var $row = $(row),
                        $cols = $row.find('td,th');

                        return $cols.map(function(j, col) {
                            var $col = $(col),
                            text = $col.text();

                        return text.replace(/"/g, '""'); // escape double quotes

                    }).get().join(tmpColDelim);

                }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"',



                // Data URI
                csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                console.log(csv);

            if (window.navigator.msSaveBlob) { // IE 10+
                //alert('IE' + csv);
                window.navigator.msSaveOrOpenBlob(new Blob([csv], {
                    type: "text/plain;charset=utf-8;"
                }), "csvname.csv")
            } else {
                $(this).attr({
                    'download': filename,
                    'href': csvData,
                    'target': '_blank'
                });
            }
        }*/

        /*$( document ).ready(function() {
            
            setTimeout(function(){
                console.log( "ready!" );
                
            },10000);
            
        });*/
    </script>

@endsection