
<div class="card w-100 d-flex h-100 mobile_bc_none">
    <div class="row ">
        <div class="col-12 col-lg-6 d-flex   ">
            <div class="card w-100 ">
                <div class="card-body">
                <h4 class="card-title mb-4 fw-bold">Shipping Details</h4>
                <h6 class="form-label">Customer Name</h6>
                <div class=" mb-2 border  form-control">

                    <span>{{$order->contactDetails->first_name}} {{$order->contactDetails->last_name}} </span>
                </div>
                <h6 class="form-label">Shipping Address</h6>
                <div class=" mb-2 border  form-control" >

                    @if($order->is_new_shipping_address == 1)
                        @if(!empty($order->street))<span>{{ $order->street }},</span><br>@endif
                        @if(!empty($order->city))<span>{{ $order->city }},</span><br>@endif
                        @if(!empty($order->state))<span>{{ $order->state }},</span><br>@endif
                        @if(!empty($order->postal_code))<span>{{ $order->postal_code }},</span><br>@endif
                        @if(!empty($order->country))<span>{{ $order->country }}.</span>@endif
                    @elseif($order->is_new_shipping_address == 2)
                        @if(!empty($order->contactDetails->shipping_street))<span>{{ $order->contactDetails->shipping_street }},</span><br>@endif
                        @if(!empty($order->contactDetails->shipping_city))<span>{{ $order->contactDetails->shipping_city }},</span><br>@endif
                        @if(!empty($order->contactDetails->shipping_state))<span>{{ $order->contactDetails->shipping_state }},</span><br>@endif
                        @if(!empty($order->contactDetails->shipping_zip))<span>{{ $order->contactDetails->shipping_zip }},</span><br>@endif
                        @if(!empty($order->contactDetails->country))<span>{{ $order->contactDetails->country }}.</span>@endif
                    @else
                        @if(!empty($order->contactDetails->shipping_street_2))<span>{{ $order->contactDetails->shipping_street_2 }},</span><br>@endif
                        @if(!empty($order->contactDetails->shipping_city_2))<span>{{ $order->contactDetails->shipping_city_2 }},</span><br>@endif
                        @if(!empty($order->contactDetails->shipping_state_2))<span>{{ $order->contactDetails->shipping_state_2 }},</span><br>@endif
                        @if(!empty($order->contactDetails->shipping_zip_2))<span>{{ $order->contactDetails->shipping_zip_2 }},</span><br>@endif
                        @if(!empty($order->contactDetails->shipping_country_2))<span>{{ $order->contactDetails->shipping_country_2 }}.</span>@endif
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
        <div class="col-12 col-lg-6 d-flex ">
            <div class="card w-100 mobile_margin_bottom_unset">
                <div class="card-body">
                <h4 class="card-title mb-4 fw-bold">Timeline</h4>
                <div class="row g-3">
                    <div class="col-md-6 col-6">
                        <label for="input1" class="form-label">Quote Created Date</label>
                        <input type="text" class="form-control" value='{{ $order->open_date }}' readonly >
                    </div>
                    <div class="col-md-6 col-6">
                        <label for="input1" class="form-label">In-Hand Due Date</label>
                        <input type="text" class="form-control" value="{{ $order->due_date }}" readonly>
                    </div>
                    <div class="col-md-6 col-6">
                        <label for="input1" class="form-label">Est Delivery Date</label>
                        <input type="text" class="form-control" value='{{ $order->est_delivery_date }}' readonly>
                    </div>
                    <div class="col-md-6 col-6">
                        <label for="input1" class="form-label">Ex Factory Date</label>
                        <input type="text" class="form-control" value='{{ $order->ex_factory_date }}' readonly>
                    </div>
                    <div class="col-md-6 col-6">
                        <label for="input1" class="form-label">Confirmation Date</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-3">
        <div class="col-12 col-lg-12 d-flex mobile_padding_unset">
            <div class="card w-100">
                <div class="card-body">
                    <label for="input11" class="form-label">Order Items</label>
                    <table class="table table-bordered table-dark mb-0 w-100 mobile-card-table">
                        <thead>
                            <tr>
                                <th scope="col">Item Name</th>
                                <th scope="col" class="text-center">QTY</th>
                                <th scope="col" class="text-center">STATUS</th>
                                <th scope="col" class="text-center">TECH PACK</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order->orderItems as $item)
                                @php
                                    $techPack = optional(
                                        optional($item->orderItemFiles)->whereNotNull('tech_pack_images')->first()
                                    )->tech_pack_images;
                                @endphp

                                <tr>
                                    <td data-label="Item Name">
                                        <p class="order-tab mb-0"
                                        style="font-weight: bold;color: #000000;"
                                        role="button"
                                        data-item-id="{{ $item->id }}"
                                        data-order-id="{{ $item->order_id }}">
                                            {{ $item->display_name ?? $item->subProduct->product_name }} - {{ $item->item_description }}
                                        </p>
                                    </td>

                                    <td data-label="QTY" class="text-center">
                                        {{ $item->qty }}
                                    </td>

                                    <td data-label="Status" class="text-center">
                                        {{ $item->statusDetails->status_name ?? '-' }}
                                    </td>

                                    <td data-label="Tech Pack" class="text-center">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary btn-sm view-file-btn"
                                            data-file="{{ $techPack }}">
                                            VIEW TECH PACK
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-3">
        <div class="col-12 col-lg-6 d-flex mobile_padding_unset">
            <div class="card w-100">
                <div class="card-body">
                    <label for="input11" class="form-label">Order Description</label>
                    <textarea class="form-control" readonly rows="10" placeholder="Is there anything else you want to let us know about this order?">{{ $order->order_description }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex mobile_padding_unset">
            <div class="card w-100">
                 <div class="card-body">
                        <h6 class="card-title mb-4 fw-bold">Payment Summary </h6>
                        <div>
                            <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Invoice amount ($) :</p>
                            <p class="fw-semi-bold">{{number_format($order->sub_total, 2)}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Artwork & other fees ($) :</p>
                            <p class=" fw-semi-bold">{{number_format($order->artwork, 2)}}</p>
                            </div>
                            @php
                                if ($order->discountType == 2) {
                                    $discountValue = $order->discount;
                                } else {
                                    $totalWithoutdisc = $order->sub_total + $order->artwork;
                                    $discountPercentage = $order->discount;
                                    $discountValue = ($totalWithoutdisc / 100) * $discountPercentage;
                                }
                            @endphp
                                @if ($order->discount_hidation == 1)
                                @if ($order->discountType == 2)
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Discount value ($) :</p>
                                        <p class="fw-semi-bold">{{number_format($discountValue, 2)}}</p>
                                    </div>
                                @elseif ($order->discountType == 1)
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Discount value {{ $order->discount }}% ($) :</p>
                                        <p class="fw-semi-bold">{{number_format($discountValue, 2)}}</p>
                                    </div>
                                @endif
                            @endif
                            @php
                                if ($order->sub_total > 0)
                                    $sales_tax = $order->sales_tax;
                                else
                                    $sales_tax = 0;
                            @endphp
                            <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Total invoice amount ($) :</p>
                            <p class="fw-semi-bold">{{number_format(($order->sub_total + $order->artwork - $discountValue),2)}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Sales tax fee {{number_format(($order['organizationDetails']->sales_tax), 2)}}% ($) :</p>
                            <p class="fw-semi-bold">{{number_format($sales_tax, 2)}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                            <p class="fw-semi-bold">Shipping fee ($) :</p>
                            <p class="fw-semi-bold">{{number_format($order->shipping, 2)}}</p>
                            </div>
                        </div>
                        <div class=" border-top pt-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0 fw-bold">Grand Total :</h6>
                                    <p style="color: grey;font-weight: 100;font-size: .6rem;margin:0">(Invoice amount + Sales Tax + shipping)</p>
                                </div>
                                <h6 class="mb-0 fw-bold">{{number_format($order->sub_total + $sales_tax + $order->shipping + $order->artwork - $discountValue, 2)}}</h6>
                            </div>
                            @if($cardAmount || $checkAmount || $venmoAmount || $paypalAmount  || $otherAmount || $purchaseorderAmount)
                                <div class="d-flex justify-content-between">
                                    <p class="fw-semi-bold">Paid amount ($) :</p>
                                    <p class="text-success fw-semi-bold">{{number_format((($cardAmount/103*100) + $checkAmount + $venmoAmount + ($paypalAmount/103*100)) + $otherAmount + $purchaseorderAmount, 2)}}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="fw-semi-bold">Paid processing fees 3% ($) :</p>
                                    <p class="fw-semi-bold">{{number_format((($cardAmount/103*3) + ($paypalAmount/103*3)), 2)}}</p>
                                </div>
                            @endif

                        </div>
                        <div class=" border-top pt-4">


                            <div class="d-flex justify-content-between">
                                <p class="fw-semi-bold">Balance invoice amount ($) :</p>
                                <h6 class="mb-0 fw-bold">{{number_format(($order->sub_total + $sales_tax + $order->shipping + $order->artwork - ($cardAmount/103*100) - $checkAmount - $venmoAmount - $otherAmount - $purchaseorderAmount - ($paypalAmount/103*100) - $discountValue), 2)}}</h6>
                            </div>
                            @php
                                if ($order->sub_total > 0)
                                    $balanceDue = $order->sub_total + $sales_tax + $order->shipping + $order->artwork - ($cardAmount/103*100) - $checkAmount - $venmoAmount - $otherAmount - $purchaseorderAmount - ($paypalAmount/103*100) - $discountValue;
                                else
                                    $balanceDue = 0;
                            @endphp

                            @php
                                if ($order->sub_total > 0)
                                    $processing_fee = $balanceDue * 3 / 100;
                                else
                                    $processing_fee = 0;
                            @endphp
                            <script>
                                const balanceDue = {{ (float) $balanceDue }};
                                const processingRate = 0.03;
                            </script>
                            {{-- @if(number_format(($balanceDue), 2) > 0) --}}
                                <div id="fee-section" style="display:none;" class="mt-2">
                                    <div class="d-flex justify-content-between d-none" id="processing-fee-row">
                                        <p class="fw-semi-bold">Processing fee 3% ($) :</p>
                                        <p class="fw-semi-bold" id="processing-fee">{{number_format($processing_fee, 2)}}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="fw-semi-bold">Total amount to pay ($) :</p>
                                        <h6 class="text-danger mb-0 fw-bold" id="total-amount">{{number_format(($balanceDue + $processing_fee), 2)}}</h6>
                                    </div>
                                </div>
                            {{-- @endif --}}
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="row p-3 align-items-center justify-content-end">
        <!-- Approve Button -->
        <div class="col-12 col-md-auto mb-2 mb-md-0">
            <button type="button"
                    class="btn btn-success w-100 w-md-auto"
                    id="approve-btn"
                    data-order_id="{{$order->id}}"
                    @if(isset($order->productionApprovalDetail)) disabled @endif
                    @if($order->plorder == 1 && $order->order_status_id == 1) @else hidden @endif>
                Approve For Production
            </button>
        </div>

        <!-- Payment Button -->
        <div class="col-12 col-md-auto">
            <a class="btn ripple btn-primary px-5 w-100 w-md-auto"
            style="background-color: blue; color:white; @if(str_starts_with($order->order_no, 'TSR')) display:none @endif"
            href="{{ route('customer_portal.payment_edit', ['orderId' => $order->id]) }}">
                @if($order->payment_status['payment_status'] == 0 || $order->payment_status['payment_status'] == 1)
                    CLICK TO PAY
                @else
                    CHECK PAYMENT INFO
                @endif
            </a>
        </div>
    </div>



</div>
