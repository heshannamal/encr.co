<div class="card w-100 d-flex h-100" id="mainDetails">
    <div class="card w-100 h-100 mobile_bc_none">
    <div class="row ">
        <div class="col-12 col-lg-6 d-flex ">
            <div class="card w-100">
                <div class="card-body">
                <h4 class="card-title mb-4 fw-bold">Item Details</h4>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="input1" class="form-label">Product Name</label>
                        <input type="text" class="form-control" value='{{ optional($order->orderItems->first())->display_name
                ?: optional($order->orderItems->first()->subProduct)->product_name }} - {{$order->orderItems->first()->item_description}}' readonly >
                    </div>
                    <div class="col-md-12">
                        <label for="input1" class="form-label">Unique Item No</label>
                        <input type="text" class="form-control" value="{{ $order->orderItems->first()->item_no}}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="input1" class="form-label">Ex Factory Date</label>
                        <input type="text" class="form-control" value='{{ $order->orderItems->first()->ex_factory_date }}' readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="input1" class="form-label">In Hand Due date</label>
                        <input type="text" class="form-control" value='{{ $order->orderItems->first()->in_hand_due_date }}' readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="input1" class="form-label">Item Status</label>
                        <input type="text" class="form-control" value='{{ $order->orderItems->first()->statusDetails->status_name }}' readonly>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex   ">
            <div class="card w-100 ">
                <div class="card-body">
                <h4 class="card-title mb-4 fw-bold">Team</h4>
                <label for="input1" class="form-label">Customer Name</label>
                <div class=" mb-2 border  form-control">

                    <span>{{$order->contactDetails->first_name}} {{$order->contactDetails->last_name}} </span>
                </div>
                <label for="input1" class="form-label">Shipping Address</label>
                <div class=" mb-2 border  form-control" >

                    @if($order->is_new_shipping_address == 1)
                        @if(!empty($order->street))<span>{{ $order->street }},</span><br>@endif
                        @if(!empty($order->city))<span>{{ $order->city }},</span><br>@endif
                        @if(!empty($order->state))<span>{{ $order->state }},</span><br>@endif
                        @if(!empty($order->postal_code))<span>{{ $order->postal_code }},</span><br>@endif
                        @if(!empty($order->country))<span>{{ $order->country }}.</span>@endif
                    @else
                        @if(!empty($order->contactDetails->shipping_street))<span>{{ $order->contactDetails->shipping_street }},</span><br>@endif
                        @if(!empty($order->contactDetails->shipping_city))<span>{{ $order->contactDetails->shipping_city }},</span><br>@endif
                        @if(!empty($order->contactDetails->shipping_state))<span>{{ $order->contactDetails->shipping_state }},</span><br>@endif
                        @if(!empty($order->contactDetails->postal_code))<span>{{ $order->contactDetails->postal_code }},</span><br>@endif
                        @if(!empty($order->contactDetails->country))<span>{{ $order->contactDetails->country }}.</span>@endif
                    @endif
                </div>
                <div class="row mb-3">
                    <label for="input36" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        @if($order->is_new_shipping_address == 1)
                            <input type="text" class="form-control" value="{{ $order->email ?? ''}}"  readonly>
                        @else
                            <input type="text" class="form-control" value="{{ $contacts->find($order->contact_id)->email ?? ''}}"   readonly>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="input36" class="col-sm-3 col-form-label">Mobile</label>
                    <div class="col-sm-9">
                        @if($order->is_new_shipping_address == 1)
                            <input type="text" class="form-control" value="{{ $order->phone_no ?? ''}}"  readonly>
                        @else
                            <input type="text" class="form-control" value="{{ $contacts->find($order->contact_id)->phone_no ?? ''}}"   readonly>
                        @endif
                    </div>
                </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row ">
        <div class="col-12 col-lg-6 d-flex ">
            <div class="card w-100">
                <div class="card-body">
                <h4 class="card-title mb-4 fw-bold">Shipping</h4>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="input1" class="form-label">Tracking No</label>
                        <input type="text" class="form-control" value='{{ $order->orderItems->first()->tracking_no }}' readonly >
                    </div>
                    <div class="col-md-12">
                        <label for="input1" class="form-label">Tracking Link</label>
                        <input type="text" class="form-control" value="{{ $order->orderItems->first()->tracking_link }}" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="input1" class="form-label">Unit Price</label>
                        <input type="text" class="form-control" value='{{ number_format($order->orderItems->first()->unit_price,2) }}' readonly>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex ">
            <div class="card w-100">
                <div class="card-body">
                    <label for="input11" class="form-label">Item Description</label>
                    <textarea class="form-control" readonly rows="6" placeholder="Is there anything else you want to let us know about this order?">{{ $order->orderItems->first()->item_description }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-12 col-lg-6 d-flex ">
            <div class="card w-100">
                <div class="card-body">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="input1" class="form-label">Fabric</label>
                        <input type="text" class="form-control" value='{{ $order->orderItems->first()->fabricDetails->fabric_name }}' readonly >
                    </div>
                    <div class="col-md-6">
                        <label for="input1" class="form-label">Embellishment</label>
                        <input type="text" class="form-control" value="{{ optional($order->orderItems->first()->embellishmentDetails)->embellishment_name ?? 'N/A' }}" readonly>
                    </div>
                    <div class="col-md-12">
                        @php
                                    $order->orderItems->first()->individual_no = 0;
                                    $order->orderItems->first()->individual_name = 0;
                                    $order->orderItems->first()->double_sided = 0;
                                    $order->orderItems->first()->pockets = 0;
                                    $order->orderItems->first()->zipper_pockets = 0;
                                    $order->orderItems->first()->dynamic_details = 0;
                                    $order->orderItems->first()->contrast_stratching = 0;
                                    $order->orderItems->first()->printing_over_sems = 0;
                                @endphp
                                @foreach ($orderItemAttributes as $orderItemAttribute)
                                    @if ($orderItemAttribute->attribute_id == 1)
                                        @php
                                            $order->orderItems->first()->individual_no = 1;
                                        @endphp
                                    @endif
                                    @if ($orderItemAttribute->attribute_id == 2)
                                        @php
                                            $order->orderItems->first()->individual_name = 1;
                                        @endphp
                                    @endif
                                    @if ($orderItemAttribute->attribute_id == 3)
                                        @php
                                            $order->orderItems->first()->double_sided = 1;
                                        @endphp
                                    @endif
                                    @if ($orderItemAttribute->attribute_id == 4)
                                        @php
                                            $order->orderItems->first()->pockets = 1;
                                        @endphp
                                    @endif
                                    @if ($orderItemAttribute->attribute_id == 5)
                                        @php
                                            $order->orderItems->first()->zipper_pockets = 1;
                                        @endphp
                                    @endif
                                    @if ($orderItemAttribute->attribute_id == 6)
                                        @php
                                            $order->orderItems->first()->dynamic_details = 1;
                                        @endphp
                                    @endif
                                    @if ($orderItemAttribute->attribute_id == 7)
                                        @php
                                            $order->orderItems->first()->contrast_stratching = 1;
                                        @endphp
                                    @endif
                                    @if ($orderItemAttribute->attribute_id == 8)
                                        @php
                                            $order->orderItems->first()->printing_over_sems = 1;
                                        @endphp
                                    @endif

                                @endforeach
                        <div class="row" >
                            <div class="col-md-12" style="padding: .5rem 1rem;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="individual-number" id="individual-number" class="custom-control-input" {{ $order->orderItems->first()->individual_no == 1 ? 'checked' : '' }} disabled>
                                    <label for="individual-number" class="custom-control-label">&nbsp;Individual
                                        Number</label>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding: .5rem 1rem;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="individual-name" id="individual-name" class="custom-control-input" {{ $order->orderItems->first()->individual_name == 1 ? 'checked' : '' }} disabled>
                                    <label for="individual-name" class="custom-control-label">&nbsp;Individual
                                        Name</label>
                                </div>
                            </div>
                            @if($order->orderItems->first()->double_sided == 1)
                                <div class="col-md-12" style="padding: .5rem 1rem;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked disabled>
                                        <label class="custom-control-label">&nbsp;Individual
                                            Name</label>
                                    </div>
                                </div>
                            @endif
                            @if($order->orderItems->first()->pockets == 1)
                                <div class="col-md-12" style="padding: .5rem 1rem;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked disabled>
                                        <label class="custom-control-label">&nbsp;Pockets</label>
                                    </div>
                                </div>
                            @endif
                            @if($order->orderItems->first()->zipper_pockets == 1)
                                <div class="col-md-12" style="padding: .5rem 1rem;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked disabled>
                                        <label class="custom-control-label">&nbsp;Zipper Pockets</label>
                                    </div>
                                </div>
                            @endif
                            @if($order->orderItems->first()->dynamic_details == 1)
                                <div class="col-md-12" style="padding: .5rem 1rem;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked disabled>
                                        <label class="custom-control-label">&nbsp;Dynamic Details</label>
                                    </div>
                                </div>
                            @endif
                            @if($order->orderItems->first()->contrast_stratching == 1)
                                <div class="col-md-12" style="padding: .5rem 1rem;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked disabled>
                                        <label class="custom-control-label">&nbsp;Contrast Stratching</label>
                                    </div>
                                </div>
                            @endif
                            @if($order->orderItems->first()->printing_over_sems == 1)
                                <div class="col-md-12" style="padding: .5rem 1rem;">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked disabled>
                                        <label class="custom-control-label">&nbsp;Printing Over Sems</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex ">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title mb-4 fw-bold">Item Files</h4>
                    <ul class="nav nav-tabs nav-success" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#successhome" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon">
                                    </div>
                                    <div class="tab-title">Tech Pack</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#successprofile" role="tab" aria-selected="false" tabindex="-1">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon">
                                    </div>
                                    <div class="tab-title">Test Print</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    @php
                        $firstItem = $order->orderItems->first();

                        $techPack = optional(
                            optional($firstItem->orderItemFiles)->whereNotNull('tech_pack_images')->first()
                        )->tech_pack_images;

                        $testPrint = optional(
                            optional($firstItem->orderItemFiles)->whereNotNull('test_print_images')->first()
                        )->test_print_images;
                    @endphp

                    <div class="tab-content py-3">

                        <div class="tab-pane fade show active" id="successhome" role="tabpanel">
                            <button
                                type="button"
                                class="btn btn-outline-secondary px-5 view-file-btn"
                                data-file="{{ $techPack }}">
                                VIEW TECH PACK
                            </button>
                        </div>

                        <div class="tab-pane fade" id="successprofile" role="tabpanel">
                            <button
                                type="button"
                                class="btn btn-outline-secondary px-5 view-file-btn"
                                data-file="{{ $testPrint }}">
                                VIEW TEST PRINT
                            </button>
                        </div>
                    </div>
				</div>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="card w-100 d-flex  h-100 " id="extraDetails" >

        <div class="col-12 col-lg-12 d-flex ">
            <div class="card w-100">
                <div class="card-body">
                <h4 class="card-title mb-4 fw-bold">Item Roster</h4>
                <ul class="nav nav-tabs nav-success" role="tablist">
                        @if($order->orderItems->first()->individual_no == 0)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if($order->orderItems->first()->individual_no == 0) active @endif" data-bs-toggle="tab" href="#QUANTITY_CHART" role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon">
                                        </div>
                                        <div class="tab-title">QUANTITY</div>
                                    </div>
                                </a>
                            </li>
                        @endif
                        @if($order->orderItems->first()->individual_no == 1)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if($order->orderItems->first()->individual_no == 1) active @endif" data-bs-toggle="tab" href="#NUMBER_ROSTER" role="tab" aria-selected="false" tabindex="-1">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon">
                                        </div>
                                        <div class="tab-title">NUMBER ROSTER</div>
                                    </div>
                                </a>
                            </li>
                        @endif
                        @if($order->orderItems->first()->individual_name == 1)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link " data-bs-toggle="tab" href="#NAME_ROSTER" role="tab" aria-selected="false" tabindex="-1">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon">
                                        </div>
                                        <div class="tab-title">NAME ROSTER</div>
                                    </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content py-3">
                        <div class="tab-pane fade @if($order->orderItems->first()->individual_no == 0) show active @endif " id="QUANTITY_CHART" role="tabpanel">
                            @php
                                $firstRow =
                                [ 'one' ,'two' ,'three' ,'four' ,'five', 'six' ,'seven' ,'eight' ,'nine' ,'ten',

                                'eleven' ,'twelve' ,'thirteen' ,'fourteen' ,'fifteen' , 'sixteen' ,'seventeen' ,'eighteen' ,'nineteen' ,'twenty' ,

                                'twenty_one' ,'twenty_two' ,'twenty_three' ,'twenty_four' ,'twenty_five'];

                                $secondRow =
                                ['twenty_six' ,'twenty_seven' ,'twenty_eight' ,'twenty_nine' ,'thirty' ,

                                'thirty_one' ,'thirty_two' ,'thirty_three' ,'thirty_four' ,'thirty_five' ,'thirty_six' ,'thirty_seven' ,'thirty_eight' ,'thirty_nine' ,'forty',

                                'forty_one' ,'forty_two' ,'forty_three' ,'forty_four' ,'forty_five' ,'forty_six' ,'forty_seven' ,'forty_eight' ,'forty_nine' ,'fifty'];

                                $thirdRow =
                                ['fifty_one' ,'fifty_two' ,'fifty_three' ,'fifty_four' ,'fifty_five' ,'fifty_six' ,'fifty_seven' ,'fifty_eight' ,'fifty_nine' ,'sixty' ,

                                'sixty_one' ,'sixty_two' ,'sixty_three' ,'sixty_four' ,'sixty_five' ,'sixty_six' ,'sixty_seven' ,'sixty_eight' ,'sixty_nine' ,'seventy',

                                'seventy_one' ,'seventy_two' ,'seventy_three' ,'seventy_four' ,'seventy_five'];

                                $fourthRow =
                                ['seventy_six' ,'seventy_seven' ,'seventy_eight' ,'seventy_nine' ,'eighty',

                                'eighty_one' ,'eighty_two' ,'eighty_three' ,'eighty_four' ,'eighty_five' ,'eighty_six' ,'eighty_seven' ,'eighty_eight' ,'eighty_nine' ,'ninety',

                                'ninety_one' ,'ninety_two' ,'ninety_three' ,'ninety_four' ,'ninety_five' ,'ninety_six' ,'ninety_seven' ,'ninety_eight' ,'ninety_nine' ,'hundred'];

                                $fifethRow =
                                [ 'hundred_one' ,'hundred_two' ,'hundred_three' ,'hundred_four' ,'hundred_five', 'hundred_six' ,'hundred_seven' ,'hundred_eight' ,'hundred_nine' ,'hundred_ten',

                                'hundred_eleven' ,'hundred_twelve' ,'hundred_thirteen' ,'hundred_fourteen' ,'hundred_fifteen' , 'hundred_sixteen' ,'hundred_seventeen' ,'hundred_eighteen' ,'hundred_nineteen' ,'hundred_twenty' ,

                                'hundred_twenty_one' ,'hundred_twenty_two' ,'hundred_twenty_three' ,'hundred_twenty_four' ,'hundred_twenty_five'];

                                $sixthRow =
                                ['hundred_twenty_six' ,'hundred_twenty_seven' ,'hundred_twenty_eight' ,'hundred_twenty_nine' ,'hundred_thirty' ,

                                'hundred_thirty_one' ,'hundred_thirty_two' ,'hundred_thirty_three' ,'hundred_thirty_four' ,'hundred_thirty_five' ,'hundred_thirty_six' ,'hundred_thirty_seven' ,'hundred_thirty_eight' ,'hundred_thirty_nine' ,'hundred_forty',

                                'hundred_forty_one' ,'hundred_forty_two' ,'hundred_forty_three' ,'hundred_forty_four' ,'hundred_forty_five' ,'hundred_forty_six' ,'hundred_forty_seven' ,'hundred_forty_eight' ,'hundred_forty_nine' ,'hundred_fifty'];
                            @endphp
                            @php
                                $sequenceArrs = array_merge($firstRow, $secondRow, $thirdRow, $fourthRow, $fifethRow, $sixthRow);
                            @endphp
                            @php
                                $productSizes = [29, 1, 2, 3, 4, 5, 6, 7, 8, 9, 26, 17, 18, 19, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 25, 16, 28];

                                $orderItemDetails = $order->orderItems->first()->orderItemDetails;

                                // Sort using custom order
                                $sortedDetails = $orderItemDetails->sortBy(function ($detail) use ($productSizes) {
                                    return array_search($detail->size_id, $productSizes);
                                })->values();
                            @endphp
                            <div class="col-12 col-md-4">
                                <table class="table table-bordered table-dark mb-0 w-100" >
                                    <thead>
                                        <tr>
                                            <th scope="col" >SIZE</th>
                                            <th scope="col"  style="width: 30%;">BLANK QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sortedDetails as $ProductItemDetail)
                                            <tr>
                                                @if (in_array($ProductItemDetail->size_id, [17, 20, 23]))
                                                    <td><input class="form-control" type="text" @if(empty($order->orderItems->first()->extra_size)) value="{{$ProductItemDetail->sizeDetails->size_name}}" @else value="{{$order->orderItems->first()->extra_size}}" @endif name="order[{{$order->id}}][{{$order->orderItems->first()->id}}][extra_size]"  @if($order->orderItems->first()->order_status_id == 1) @else disabled @endif></td>
                                                @elseif(in_array($ProductItemDetail->size_id, [18, 21, 24]))
                                                    <td><input class="form-control" type="text" @if(empty($order->orderItems->first()->extra_size_two)) value="{{$ProductItemDetail->sizeDetails->size_name}}" @else value="{{$order->orderItems->first()->extra_size_two}}" @endif name="order[{{$order->id}}][{{$order->orderItems->first()->id}}][extra_size_two]" @if($order->orderItems->first()->order_status_id == 1) @else disabled @endif></td>
                                                @elseif(in_array($ProductItemDetail->size_id, [19, 22, 25]))
                                                    <td><input class="form-control" type="text" @if(empty($order->orderItems->first()->extra_size_three)) value="{{$ProductItemDetail->sizeDetails->size_name}}" @else value="{{$order->orderItems->first()->extra_size_three}}" @endif name="order[{{$order->id}}][{{$order->orderItems->first()->id}}][extra_size_three]" @if($order->orderItems->first()->order_status_id == 1) @else disabled @endif></td>
                                                @else
                                                    <td style="font-size: 1rem;color: grey;padding-left: 1rem;">{{$ProductItemDetail->sizeDetails->size_name}}</td>
                                                @endif
                                                    <td class="text-center"><input class="blank-qty-{{$ProductItemDetail->order_item_id}} form-control" onchange="updateBlankQty({{$ProductItemDetail->order_item_id}}) " value="{{$ProductItemDetail->blanks}}" name="order[{{$order->id}}][{{$ProductItemDetail->order_item_id}}][{{$ProductItemDetail->id}}][blanks]" type="number" style="border: none;background-color: unset;text-align: center;width:100%"  @if($order->orderItems->first()->order_status_id == 1) @else disabled @endif></td>
                                            </tr>
                                            @endforeach

                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td >TOTAL</td>
                                            <td><input type="number" class="form-control" id="blank-qty-total-{{$order->orderItems->first()->id}}" name="order[{{$order->id}}][{{$order->orderItems->first()->id}}][blank-qty]" style="text-align: center;border: none;" value="{{$order->orderItems->first()->qty}}" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="NAME_ROSTER" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-2">
                                    @foreach ($sortedDetails as $ProductItemDetail)
                                        <button type="button" class="w-100 mb-1 btn btn-light px-2 player-name-tab-button player-name-tab-button_{{$order->orderItems->first()->id}}" @if($ProductItemDetail->qty == 0 && $ProductItemDetail->blanks == 0) style="display:none" @endif onclick="PlayerNameTabBarOptions('player-name-tab_{{$ProductItemDetail->id}}' , this , {{$order->orderItems->first()->id}})">{{$ProductItemDetail->sizeDetails->size_name}}</button>
                                    @endforeach
                                </div>
                                <div class="col-lg-10">
                                    <div class="col-md-12 player-name-tab_{{$order->orderItems->first()->id}} player-name-tab_{{$ProductItemDetail->id}}">
                                        <h3>
                                            Click Related tab to change player names
                                        </h3>
                                    </div>
                                    @foreach ($sortedDetails as $ProductItemDetail)
                                    @php
                                        $playerDetail = $ProductItemDetail->playerDetails;
                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-12 player-name-tab_{{$order->orderItems->first()->id}} player-name-tab_{{$ProductItemDetail->id}}" style="display: none">
                                            <h3>{{$ProductItemDetail->sizeDetails->size_name}}</h3>
                                            <table class="table table-bordered table-dark mb-0 w-100">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 20%;">SIZE</th>
                                                        <th style="width: 15%;" class="text-center">PLAYER NO</th>
                                                        <th style="width: 60%">PLAYER NAME</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($order->orderItems->first()->individual_no == 0 && $order->orderItems->first()->individual_name == 1)

                                                    @php
                                                        $playersNameArray = json_decode($playerDetail->blank_player_names, true);
                                                    @endphp
                                                        @for($i = 0; $i < $ProductItemDetail->blanks; $i++)
                                                            <tr>
                                                                <td style="padding-left: 1rem;">{{ $ProductItemDetail->sizeDetails->size_name }}</td>
                                                                <td class="text-center"></td>
                                                                <td><input type="text" class="form-control" placeholder="Enter Player Name" @if(!empty($playersNameArray[$i])) value="{{ $playersNameArray[$i] }}" @endif style="width: 100%;height: 3rem;border: none;" {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'disabled' }} name="players[{{$order->id}}][{{$order->orderItems->first()->id}}][{{$ProductItemDetail->id}}]['blank_player'][{{$i}}]" ></td>
                                                            </tr>
                                                        @endfor
                                                    @else

                                                        @foreach ($firstRow as $item)
                                                            @if(($ProductItemDetail->{'numseq_'.$item} !== null && $ProductItemDetail->{'numseq_'.$item} !== ''))
                                                                <tr>
                                                                    <td style="padding-left: 1rem;">{{ $ProductItemDetail->sizeDetails->size_name }}</td>
                                                                    <td class="text-center">{{ $ProductItemDetail->{'numseq_'.$item} }}</td>
                                                                    <td><input class="form-control" type="text" placeholder="Enter Player Name" @if(!empty($playerDetail->{'player_'.$item})) value="{{ $playerDetail->{'player_'.$item} }}" @endif style="width: 100%;height: 3rem;border: none;" {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'disabled' }} name="players[{{$order->id}}][{{$order->orderItems->first()->id}}][{{$ProductItemDetail->id}}][player_{{$item}}]" ></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @foreach ($secondRow as $item)
                                                            @if(($ProductItemDetail->{'numseq_'.$item} !== null && $ProductItemDetail->{'numseq_'.$item} !== ''))
                                                                <tr>
                                                                    <td style="padding-left: 1rem;">{{ $ProductItemDetail->sizeDetails->size_name }}</td>
                                                                    <td class="text-center">{{ $ProductItemDetail->{'numseq_'.$item} }}</td>
                                                                    <td><input class="form-control" type="text" placeholder="Enter Player Name" @if(!empty($playerDetail->{'player_'.$item})) value="{{ $playerDetail->{'player_'.$item} }}" @endif style="width: 100%;height: 3rem;border: none;" {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'disabled' }} name="players[{{$order->id}}][{{$order->orderItems->first()->id}}][{{$ProductItemDetail->id}}][player_{{$item}}]" ></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @foreach ($thirdRow as $item)
                                                            @if(($ProductItemDetail->{'numseq_'.$item} !== null && $ProductItemDetail->{'numseq_'.$item} !== ''))
                                                                <tr>
                                                                    <td style="padding-left: 1rem;">{{ $ProductItemDetail->sizeDetails->size_name }}</td>
                                                                    <td class="text-center">{{ $ProductItemDetail->{'numseq_'.$item} }}</td>
                                                                    <td><input class="form-control" type="text" placeholder="Enter Player Name" @if(!empty($playerDetail->{'player_'.$item})) value="{{ $playerDetail->{'player_'.$item} }}" @endif style="width: 100%;height: 3rem;border: none;" {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'disabled' }} name="players[{{$order->id}}][{{$order->orderItems->first()->id}}][{{$ProductItemDetail->id}}][player_{{$item}}]" ></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @foreach ($fourthRow as $item)
                                                            @if(($ProductItemDetail->{'numseq_'.$item} !== null && $ProductItemDetail->{'numseq_'.$item} !== ''))
                                                                <tr>
                                                                    <td style="padding-left: 1rem;">{{ $ProductItemDetail->sizeDetails->size_name }}</td>
                                                                    <td class="text-center">{{ $ProductItemDetail->{'numseq_'.$item} }}</td>
                                                                    <td><input class="form-control" type="text" placeholder="Enter Player Name" @if(!empty($playerDetail->{'player_'.$item})) value="{{ $playerDetail->{'player_'.$item} }}" @endif style="width: 100%;height: 3rem;border: none;" {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'disabled' }} name="players[{{$order->id}}][{{$order->orderItems->first()->id}}][{{$ProductItemDetail->id}}][player_{{$item}}]" ></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @foreach ($fifethRow as $item)
                                                            @if(($ProductItemDetail->{'numseq_'.$item} !== null && $ProductItemDetail->{'numseq_'.$item} !== ''))
                                                                <tr>
                                                                    <td style="padding-left: 1rem;">{{ $ProductItemDetail->sizeDetails->size_name }}</td>
                                                                    <td class="text-center">{{ $ProductItemDetail->{'numseq_'.$item} }}</td>
                                                                    <td><input class="form-control" type="text" placeholder="Enter Player Name" @if(!empty($playerDetail->{'player_'.$item})) value="{{ $playerDetail->{'player_'.$item} }}" @endif style="width: 100%;height: 3rem;border: none;" {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'disabled' }} name="players[{{$order->id}}][{{$order->orderItems->first()->id}}][{{$ProductItemDetail->id}}][player_{{$item}}]" ></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @foreach ($sixthRow as $item)
                                                            @if(($ProductItemDetail->{'numseq_'.$item} !== null && $ProductItemDetail->{'numseq_'.$item} !== ''))
                                                                <tr>
                                                                    <td style="padding-left: 1rem;">{{ $ProductItemDetail->sizeDetails->size_name }}</td>
                                                                    <td class="text-center">{{ $ProductItemDetail->{'numseq_'.$item} }}</td>
                                                                    <td><input class="form-control" type="text" placeholder="Enter Player Name" @if(!empty($playerDetail->{'player_'.$item})) value="{{ $playerDetail->{'player_'.$item} }}" @endif style="width: 100%;height: 3rem;border: none;" {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'disabled' }} name="players[{{$order->id}}][{{$order->orderItems->first()->id}}][{{$ProductItemDetail->id}}][player_{{$item}}]" ></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if($order->orderItems->first()->individual_no == 1) show active @endif" id="NUMBER_ROSTER" role="tabpanel">
                           @php
                                $productSizes = [29, 1, 2, 3, 4, 5, 6, 7, 8, 9, 26, 17, 18, 19, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 25, 16, 28];

                                $orderItemDetails = $order->orderItems->first()->orderItemDetails;

                                // Sort using custom order
                                $sortedDetails = $orderItemDetails->sortBy(function ($detail) use ($productSizes) {
                                    return array_search($detail->size_id, $productSizes);
                                })->values();
                            @endphp
                            <table class="table table-bordered table-dark mb-0 table-responsive w-100">
									<thead>
										<tr>
											<th scope="col">SIZE</th>
											<th scope="col">QTY</th>
											<th scope="col">PLAYER NUMBER</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($sortedDetails as $ProductItemDetail)
                                        <style>
                                            /* Must be outside media query */
#NUMBER_ROSTER .player-number-table tr.roster-row-hidden,
#NUMBER_ROSTER .no-border-table tr.roster-row-hidden {
    display: none !important;
}
                                            @media (max-width: 1350px) {
    /* Main roster table */
    #NUMBER_ROSTER > table {
        border: none !important;
        width: 100% !important;
    }

    #NUMBER_ROSTER > table > thead {
        display: none !important;
    }

    #NUMBER_ROSTER > table > tbody {
        display: block !important;
        width: 100% !important;
    }

    #NUMBER_ROSTER > table > tbody > tr {
        display: block !important;
        margin-bottom: 1rem !important;
        border-radius: 10px !important;
        padding: 0.75rem 1rem !important;
        border: 1px solid #e5e5e5 !important;
        background: #ffffff !important;
    }

    #NUMBER_ROSTER > table > tbody > tr > td {
        display: block !important;
        padding: 0.25rem 0 !important;
        white-space: normal !important;
        word-break: break-word !important;
        border: none !important;
    }

    /* Size and QTY same line */
    #NUMBER_ROSTER > table > tbody > tr > td:nth-child(1),
    #NUMBER_ROSTER > table > tbody > tr > td:nth-child(2) {
        display: inline-flex !important;
        align-items: center !important;
        width: auto !important;
        margin-right: 16px !important;
        margin-bottom: 8px !important;
        vertical-align: middle !important;
        color: #333 !important;
        font-size: 14px !important;
    }

    #NUMBER_ROSTER > table > tbody > tr > td:nth-child(1)::before {
        content: "Size: ";
        font-weight: 700;
        color: #111;
        margin-right: 4px;
    }

    #NUMBER_ROSTER > table > tbody > tr > td:nth-child(2)::before {
        content: "QTY: ";
        font-weight: 700;
        color: #111;
        margin-right: 4px;
    }

    #NUMBER_ROSTER > table > tbody > tr > td:nth-child(1) input {
        width: 110px !important;
        min-width: 110px !important;
        display: inline-block !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        color: #333 !important;
    }

    #NUMBER_ROSTER > table > tbody > tr > td:nth-child(2) input {
        width: 55px !important;
        min-width: 55px !important;
        display: inline-block !important;
        text-align: center !important;
        border: none !important;
        background: transparent !important;
        padding: 0 !important;
        color: #333 !important;
    }

    /* Player number area */
    #NUMBER_ROSTER > table > tbody > tr > td:nth-child(3) {
        display: block !important;
        width: 100% !important;
        margin-top: 4px !important;
        padding: 0 !important;
    }

    /* Inner player number table */
    #NUMBER_ROSTER .player-number-table,
    #NUMBER_ROSTER .no-border-table {
        display: block !important;
        width: 100% !important;
        border-spacing: 0 !important;
        border-collapse: collapse !important;
        border: none !important;
    }

    #NUMBER_ROSTER .player-number-table tbody,
    #NUMBER_ROSTER .no-border-table tbody {
        display: block !important;
        width: 100% !important;
        border: none !important;
    }

    /* IMPORTANT: hidden rows must stay hidden */
    #NUMBER_ROSTER .player-number-table tr.roster-row-hidden,
    #NUMBER_ROSTER .no-border-table tr.roster-row-hidden {
        display: none !important;
    }

    /* Visible player rows flow continuously */
    #NUMBER_ROSTER .player-number-table tr.player-number-row:not(.roster-row-hidden),
    #NUMBER_ROSTER .no-border-table tr.player-number-row:not(.roster-row-hidden) {
        display: contents !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
    }

    #NUMBER_ROSTER .player-number-table td,
    #NUMBER_ROSTER .no-border-table td {
        display: inline-block !important;
        padding: 2px !important;
        margin: 0 !important;
        border: none !important;
        width: auto !important;
        vertical-align: top !important;
    }

    #NUMBER_ROSTER .player-number-table input,
    #NUMBER_ROSTER .no-border-table input.boxed-input {
        width: 52px !important;
        min-width: 52px !important;
        max-width: 52px !important;
        height: 36px !important;
        margin: 0 !important;
        padding: 4px 5px !important;
        text-align: center !important;
        font-size: 13px !important;
        border-radius: 6px !important;
        box-sizing: border-box !important;
    }
}
                                        </style>
                                            <tr>
                                                @if (in_array($ProductItemDetail->size_id, [17, 20, 23]))
                                                    <td><input class="form-control" style="font-size: 1rem;color: #a390b1;padding-left: 1rem;border:none;width:9rem" type="text" @if(empty($order->orderItems->first()->extra_size)) value="{{$ProductItemDetail->sizeDetails->size_name}}" @else value="{{$order->orderItems->first()->extra_size}}" @endif name="order[{{$order->id}}][{{$order->orderItems->first()->id}}][extra_size-num]" {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'readonly' }}></td>
                                                @elseif(in_array($ProductItemDetail->size_id, [18, 21, 24]))
                                                    <td><input class="form-control" style="font-size: 1rem;color: #a390b1;padding-left: 1rem;border:none;width:9rem" type="text" @if(empty($order->orderItems->first()->extra_size_two)) value="{{$ProductItemDetail->sizeDetails->size_name}}" @else value="{{$order->orderItems->first()->extra_size_two}}" @endif name="order[{{$order->id}}][{{$order->orderItems->first()->id}}][extra_size_two-num]" {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'readonly' }}></td>
                                                @elseif(in_array($ProductItemDetail->size_id, [19, 22, 25]))
                                                    <td><input class="form-control" style="font-size: 1rem;color: #a390b1;padding-left: 1rem;border:none;width:9rem" type="text" @if(empty($order->orderItems->first()->extra_size_three)) value="{{$ProductItemDetail->sizeDetails->size_name}}" @else value="{{$order->orderItems->first()->extra_size_three}}" @endif name="order[{{$order->id}}][{{$order->orderItems->first()->id}}][extra_size_three-num]" {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'readonly' }}></td>
                                                @else
                                                <td style="font-size: 1rem;color: grey;padding-left: 1rem;width:8rem">{{$ProductItemDetail->sizeDetails->size_name}}</td>
                                                @endif
                                                {{-- <td><input value="{{$ProductItemDetail->blanks}}" type="number" style="border: none;background-color: unset;text-align: center;" name="order[{{$order->id}}][{{$order->orderItems->first()->id}}][{{$ProductItemDetail->id}}][num-blanks]"></td> --}}
                                                <td  class="num-sum-count-total-{{$order->orderItems->first()->id}}"><input class="form-control" id="num-total-count-{{$ProductItemDetail->id}}" value="{{$ProductItemDetail->qty}}" type="text" style="border: none;background-color: unset;text-align: center;width:4rem" name="order[{{$order->id}}][{{$order->orderItems->first()->id}}][{{$ProductItemDetail->id}}][qty]" readonly></td>
                                                <td>
                                                    <div class="">

                                                    @php
                                                        $allNumberRows = array_chunk($sequenceArrs, 15);
                                                    @endphp

                                                    <table class="no-border-table player-number-table"
                                                        data-item-id="{{ $order->orderItems->first()->id }}">

                                                        @foreach ($allNumberRows as $rowIndex => $numberRow)
                                                            @php
                                                                $rowNumber = $rowIndex + 1;
                                                            @endphp

                                                            <tr class="{{ $ProductItemDetail->id }}Row{{ $rowNumber }} player-row player-number-row player-number-row-{{ $ProductItemDetail->id }} {{ $rowNumber > 2 ? 'roster-row-hidden' : '' }}"
                                                                data-row-number="{{ $rowNumber }}">

                                                                @foreach ($numberRow as $item)
                                                                    <td>
                                                                        <input
                                                                            oninput="limitDigits(this, 6); NumberQtyCountUpdate({{ $ProductItemDetail->id }}, {{ $order->orderItems->first()->id }});"
                                                                            class="form-control boxed-input no-spinner num-input-count-{{ $ProductItemDetail->id }}"
                                                                            value="{{ $ProductItemDetail->{'numseq_'.$item} }}"
                                                                            name="order[{{ $order->id }}][{{ $order->orderItems->first()->id }}][{{ $ProductItemDetail->id }}][numseq_{{ $item }}]"
                                                                            type="number"
                                                                            {{ $order->orderItems->first()->order_status_id == 1 ? '' : 'disabled' }}>
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                                </td>
                                            </tr>
                                        @endforeach
									</tbody>
                                    <tbody>
                                        <tr>
                                            <td >TOTAL</td>
                                            <td><input type="number" id="num-sum-qty-total-{{$order->orderItems->first()->id}}" name="order[{{$order->id}}][{{$order->orderItems->first()->id}}][num-qty]" style="text-align: center;border:none;width:4rem" value="{{$order->orderItems->first()->qty}}" readonly></td>
                                        </tr>
                                    </tbody>
								</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row p-3">
            <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2 p-3">
                <!-- CANCEL Button -->
                <button type="button"
                        class="btn ripple btn-danger w-100 w-md-auto px-5"
                        onclick="window.location.reload();">
                    CANCEL
                </button>

                <!-- PAYMENT Button -->
                <a class="btn ripple btn-primary w-100 w-md-auto px-5"
                style="background-color: blue; color:white; @if(str_starts_with($order->order_no, 'TSR')) display:none @endif"
                href="{{ route('customer_portal.payment_edit', ['orderId' => $order->id]) }}">
                    PAYMENT
                </a>

                <!-- SAVE CHANGES Button -->
                @if ($order->order_status_id == 1)
                    <button class="btn btn-success w-100 w-md-auto px-5"
                            type="button"
                            onclick="submitOrderForm()">
                        SAVE CHANGES
                    </button>
                @endif
            </div>
        </div> --}}
        <div class="row p-3 align-items-center justify-content-end">

            <div class="col-12 col-md-auto mb-2 mb-md-0">
                <!-- CANCEL Button -->
                <button type="button"
                        class="btn ripple btn-danger w-100 w-md-auto px-5"
                        onclick="window.location.reload();">
                    CANCEL
                </button>
            </div>
            <div class="col-12 mb-2 mb-md-0 col-md-auto">
                <!-- PAYMENT Button -->
                <a class="btn ripple btn-primary w-100 w-md-auto px-5"
                style="background-color: blue; color:white; @if(str_starts_with($order->order_no, 'TSR')) display:none @endif"
                href="{{ route('customer_portal.payment_edit', ['orderId' => $order->id]) }}">
                    PAYMENT
                </a>
            </div>
            <div class="col-12 col-md-auto">
                <!-- SAVE CHANGES Button -->
                @if ($order->order_status_id == 1)
                    <button class="btn btn-success w-100 w-md-auto px-5"
                            type="button"
                            onclick="submitOrderForm()">
                        SAVE CHANGES
                    </button>
                @endif
            </div>
        </div>





