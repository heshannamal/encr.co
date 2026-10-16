<tr style="color:rgba(22, 22, 23, 1) !important; background: #e7e7e7; border-bottom: 2px solid #d7d7d7;" id="collapse_<?php echo $orderItem->id; ?>" class="collapse mobile-main-child-card collapse_<?php echo $orderItem->id; ?> text-center row-item-detail-{{ $orderItemDetail->id }}">
    {{-- <td><input data-itemNumber="{{ $orderItem->id }}" type="checkbox" value="{{ $orderItem->id }}" name="subcheckbox<?php echo $orderItem->id; ?>" id='subcheck' class="chkItem"></td> --}}
    <td style="background-color: white"><input data-itemNumber="{{ $orderItem->id }}" type="checkbox" value="{{ $orderItemDetail->id }}" name="subcheckbox<?php echo $orderItem->id; ?>" id='subcheck' class="chkItemMainChild" onchange="toggleSeqCheckboxes(this, 'seqcheckbox<?php echo $orderItemDetail->id; ?>')"></td>
    <td style="background-color: white"></td>

    <td class="mobile-detail-size" style="outline: unset; text-align:left">

        <div class="mobile-expanded-field mobile-expanded-size">

            <div class="mobile-expanded-value mobile-size-value">

                <button
                    class="expand-button mr-1 ForClickFunc"
                    onclick="show_rosters({{$orderItem}} , {{$orderItemDetail}} , {{$orderItemDetail->playerDetails}} , {{$orderItemDetail->sizeDetails}})"
                    style="outline: unset !important;"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse_child_<?php echo $orderItemDetail->id; ?>"
                    aria-expanded="false"
                    aria-controls="collapse_child_<?php echo $orderItemDetail->id; ?>"
                >
                    <i
                        class="fas fa-angle-right"
                        id="toggle_icon_{{$orderItemDetail->id}}"
                    ></i>
                </button>

                @if ($orderItemDetail->sizeDetails['size_name'] == 'Youth Small')
                    YS
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Youth Medium')
                    YM
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Youth Large')
                    YL
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Adult XSmall')
                    AXS
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Adult Small')
                    AS
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Adult Medium')
                    AM
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Adult Large')
                    AL
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Adult XLarge')
                    AXL
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Adult XXLarge')
                    AXXL
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Kids')
                    Kids
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'XSmall')
                    XS
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Small')
                    S
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Medium')
                    M
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Large')
                    L
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'XLarge')
                    XL
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'N/A')
                    N/A
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size One')
                    @if ($orderItem->extra_size == '1')
                        {{ 'Extra Size One' }}
                    @else
                        {{ $orderItem->extra_size }}
                    @endif
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Two')
                    @if ($orderItem->extra_size_two == '1')
                        {{ 'Extra Size Two' }}
                    @else
                        {{ $orderItem->extra_size_two }}
                    @endif
                @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Three')
                    @if ($orderItem->extra_size_three == '1')
                        {{ 'Extra Size Three' }}
                    @else
                        {{ $orderItem->extra_size_three }}
                    @endif
                @else
                    {{ $orderItemDetail->sizeDetails['size_name'] }}
                @endif

            </div>

        </div>

    </td>


    <td class="mobile-detail-player-name" style="outline: unset">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label">Player Name</span>

            <div class="mobile-expanded-value">
                <!-- Player name is loaded dynamically -->
            </div>

        </div>

    </td>


    <td class="mobile-detail-player-number" style="outline: unset">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label">Player Number</span>

            <div class="mobile-expanded-value">
                <!-- Player number is loaded dynamically -->
            </div>

        </div>

    </td>


    <td class="mobile-detail-qty" style="outline: unset">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label">ORDER QTY</span>

            <div class="mobile-expanded-value mobile-expanded-orderqty-value">
                {{ $orderItemDetail->blanks + $orderItemDetail->qty }}
            </div>

        </div>

    </td>


    <td class="mobile-detail-shipped">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label">SHIPPED</span>

            <div class="mobile-expanded-value">

                <input
                    type="number"
                    class="invoice-inputs text-center item-detail-main-shipped-{{ $orderItemDetail->id }}"
                    value="@if(isset($orderItemDetail->shipped_qty)){{ $orderItemDetail->shipped_qty }}@endif"
                    readonly
                />

            </div>

        </div>

    </td>


    <td class="mobile-detail-backordered">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label"> BACKORDERED</span>

            <div class="mobile-expanded-value">

                <input
                    type="number"
                    class="invoice-inputs text-center item-detail-main-backed-{{ $orderItemDetail->id }}"
                    value="@if(isset($orderItemDetail->backordered_qty)){{ $orderItemDetail->backordered_qty }}@endif"
                    readonly
                />

            </div>

        </div>

    </td>


    <td class="mobile-detail-delivery">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label">Est. Delivery</span>

            <div class="mobile-expanded-value">
                <!-- Delivery date -->
            </div>

        </div>

    </td>


    <td class="mobile-detail-courier" style="text-align: left">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label">Courier</span>

            <div class="mobile-expanded-value">

                <input
                    type="text"
                    class="invoice-inputs text-center shipping-input"
                    data-itemNumber="{{ $orderItemDetail->id }}"
                    id="CourierService{{ $orderItemDetail->id }}"
                    value="@if(isset($orderItemDetail->CourierService)){{ $orderItemDetail->CourierService }}@endif"
                    style="outline: unset"
                    readonly
                />

            </div>

        </div>

    </td>


    <td class="mobile-detail-tracking">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label">Tracking No.</span>

            <div class="mobile-expanded-value">

                <input
                    type="text"
                    class="invoice-inputs text-center shipping-input"
                    data-itemNumber="{{ $orderItemDetail->id }}"
                    id="txtTrackNo{{ $orderItemDetail->id }}"
                    value="@if(isset($orderItemDetail->tracking_no)){{ $orderItemDetail->tracking_no }}@endif"
                    readonly
                />

            </div>

        </div>

    </td>


    <td class="mobile-detail-tracking-link">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label">Tracking Link</span>

            <div class="mobile-expanded-value">

                <input
                    type="text"
                    class="invoice-inputs text-center shipping-input"
                    data-itemNumber="{{ $orderItemDetail->id }}"
                    id="txtTrackLink{{ $orderItemDetail->id }}"
                    value="@if(isset($orderItemDetail->tracking_link)){{ $orderItemDetail->tracking_link }}@endif"
                    readonly
                />

            </div>

        </div>

    </td>


    <td class="mobile-detail-notify" style="vertical-align: middle;">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label">Notify</span>

            <div class="mobile-expanded-value">
                <!-- Notification status -->
            </div>

        </div>

    </td>


    <td class="mobile-detail-notified-by text-center" style="vertical-align: middle;">

        <div class="mobile-expanded-field">

            <span class="mobile-expanded-label">Notified By</span>

            <div class="mobile-expanded-value">
                <!-- Notified user -->
            </div>

        </div>

    </td>
</tr>
