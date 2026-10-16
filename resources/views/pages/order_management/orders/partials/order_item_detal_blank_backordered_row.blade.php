<tr style="color:rgba(22, 22, 23, 1) !important;border-bottom: 2px solid #d7d7d7;background-color:rgb(246, 246, 246)" id="collapse_<?php echo $backOrderedShipping->order_item_id; ?>" class="collapse text-center mobile-backorder-detail-card">
    <td style="background-color: white">
        <input type="hidden" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blk][shipping_order_detail_id]" value="{{ $backOrderedShipping->id }}">
        @if ($backOrderedShipping->is_saved == 1)
            <input type="hidden" class="saved-row saved-item-{{ $backOrderedShipping->order_item_id }} saved-item-detail-{{ $backOrderedShipping->order_item_detail_id }}">
        @else
            <input type="hidden" class="unsaved-row unsaved-item-{{ $backOrderedShipping->order_item_id }} unsaved-item-detail-{{ $backOrderedShipping->order_item_detail_id }}">
        @endif
        <input data-itemNumber="{{ $backOrderedShipping->order_item_id }}"
                type="checkbox"
                value="{{ $backOrderedShipping->id }}"
                name="subcheckbox<?php echo $backOrderedShipping->order_item_id; ?>"
                id='subcheck'
                class="chkItemChild emergency-edit-{{$backOrderedShipping->notify_status}} seqcheckbox{{ $backOrderedShipping->order_item_detail_id }}"
                data-saved-status = "{{ $backOrderedShipping->is_saved }}"
                >
    </td>
    <td style="background-color: white"></td>
    <td style="outline: unset;text-align: end;">
        <input type="hidden" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blk][size_id]" value="{{ $backOrderedShipping->size_id }}">
        <input type="hidden" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blk][size_name]" value="{{ $backOrderedShipping->size_name ?? '' }}">
        @if ($backOrderedShipping->size_name == 'Youth Small')
            YS
        @elseif ($backOrderedShipping->size_name == 'Youth Medium')
            YM
        @elseif ($backOrderedShipping->size_name == 'Youth Large')
            YL
        @elseif ($backOrderedShipping->size_name == 'Adult XSmall')
            AXS
        @elseif ($backOrderedShipping->size_name == 'Adult Small')
            AS
        @elseif ($backOrderedShipping->size_name == 'Adult Medium')
            AM
        @elseif ($backOrderedShipping->size_name == 'Adult Large')
            AL
        @elseif ($backOrderedShipping->size_name == 'Adult XLarge')
            AXL
        @elseif ($backOrderedShipping->size_name == 'Adult XXLarge')
            AXXL
        @elseif ($backOrderedShipping->size_name == 'Kids')
            Kids
        @elseif ($backOrderedShipping->size_name == 'XSmall')
            XS
        @elseif ($backOrderedShipping->size_name == 'Small')
            S
        @elseif ($backOrderedShipping->size_name == 'Medium')
            M
        @elseif ($backOrderedShipping->size_name == 'Large')
            L
        @elseif ($backOrderedShipping->size_name == 'XLarge')
            XL
        @elseif ($backOrderedShipping->size_name == 'N/A')
            N/A
        {{-- @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size One')
            @if ($orderItem->extra_size == '1') {{ 'Extra Size One' }} @else {{ $orderItem->extra_size }} @endif
        @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Two')
            @if ($orderItem->extra_size_two == '1') {{ 'Extra Size Two' }} @else {{ $orderItem->extra_size_two }} @endif
        @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Three')
            @if ($orderItem->extra_size_three == '1') {{ 'Extra Size Three' }} @else {{ $orderItem->extra_size_three }} @endif --}}
        @else
            {{ $backOrderedShipping->size_name }}
        @endif
    </td>
    <td style="outline: unset"></td>
    <td style="outline: unset"></td>
    {{-- <td style="outline: unset">{{ $backOrderedShipping->blanks + $backOrderedShipping->qty }}</td> --}}
    <td style="outline: unset">
        {{-- {{ $backOrderedShipping->blanks }} --}}
        <input type="number" class="invoice-inputs text-center order-qty" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blk][order_qty]" value="{{ $backOrderedShipping->order_qty }}" readonly>
    </td>
        @php
            $shippedQty = $backOrderedShipping->shipped_qty;
            $backOrderedQty = $backOrderedShipping->back_ordered_qty;
            if($shippedQty != '' && ($backOrderedQty == null || $backOrderedQty == '')){
                $backOrderedQty = $backOrderedShipping->order_qty - $shippedQty;
            }
        @endphp
    <td>
        <input type="number" class="invoice-inputs text-center emergency-edit-{{$backOrderedShipping->notify_status}} shipping-input shipping-qty item-shipped-qty-{{ $backOrderedShipping->order_item_id }}" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blk][shipped_qty]" value="{{$shippedQty}}" min="0" max="{{$backOrderedShipping->order_qty}}" data-item-id="{{ $backOrderedShipping->order_item_id }}" onchange="updateBackorderedQty(this)"/>
    </td>

    <td  class="mobile-backorder-qty-cell">
        <input type="number" class="invoice-inputs text-center shipping-input backed-qty item-backed-qty-{{ $backOrderedShipping->order_item_id }}" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blk][back_ordered_qty]" value="{{$backOrderedQty}}" readonly/>
    </td>

    <td class="mobile-backorder-delivery-cell">
        <input type="text" class="invoice-inputs text-center emergency-edit-{{$backOrderedShipping->notify_status}} shipping-datepicker shipping-input itemEstDiliveryDate" placeholder="MM/DD/YY" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blk][est_delivery_date]" value="{{ date_format(date_create($backOrderedShipping->est_delivery_date),"m/d/Y"); }}"/>
    </td>
    <td class="mobile-backorder-courier-cell">
        <select  class="CourierService CourierService-select invoice-inputs text-center emergency-edit-{{$backOrderedShipping->notify_status}} shipping-input" name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blk][CourierService]"   id="CourierService{{  $backOrderedShipping->order_item_detail_id  }}">
            <option value="">Select Courier</option>
            <option value="UPS" @if( $backOrderedShipping->CourierService  == "UPS") selected="selected" @endif>UPS</option>
            <option value="FedEx" @if( $backOrderedShipping->CourierService  == "FedEx") selected="selected" @endif>FedEx</option>
            <option value="DHL" @if( $backOrderedShipping->CourierService  == "DHL") selected="selected" @endif>DHL</option>
            <option value="Other" @if( $backOrderedShipping->CourierService  == "Other") selected="selected" @endif>Other</option>
        </select>
    </td>
    <td class="mobile-backorder-tracking-cell">
        <input
            type="text"
            {{-- onkeyup="addTrackingNo(this)" --}}
            class="txtTrackingNo invoice-inputs text-center emergency-edit-{{$backOrderedShipping->notify_status}} shipping-input"
            data-itemNumber="{{ $backOrderedShipping->order_item_detail_id }}"
            name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blk][tracking_no]"
            id="txtTrackNo{{ $backOrderedShipping->order_item_detail_id  }}"
            value="{{ $backOrderedShipping->tracking_no  }}"
        />
    </td>

    <td class="mobile-backorder-tracking-link-cell">
        <input
            type="text"
            {{-- onkeyup="addTrackingLink(this)" --}}
            class="txtTrackingLink invoice-inputs text-center emergency-edit-{{$backOrderedShipping->notify_status}} shipping-input"
            data-itemNumber="{{ $backOrderedShipping->order_item_detail_id }}"
            name="items[{{ $backOrderedShipping->order_item_id }}][{{ $backOrderedShipping->order_item_detail_id }}][blk][tracking_link]"
            id="txtTrackLink{{ $backOrderedShipping->order_item_detail_id  }}"
            value="{{ $backOrderedShipping->tracking_link }}"
        />
    </td>

    <td class="mobile-backorder-notify-cell" style="vertical-align: middle;">
        @if ($backOrderedShipping->notify_status == 1)
            <input type="hidden" class="notified-row">
            <p class="notify-status notify-sent">Sent</p>
        @elseif ($backOrderedShipping->notify_status == 2)
            <input type="hidden" class="notified-row">
            <p class="notify-status notify-sent">Re-Sent</p>
        @else
            <input type="hidden" class="unnotified-row unnotified-item-{{ $backOrderedShipping->order_item_id }} unnotified-item-detail-{{ $backOrderedShipping->order_item_detail_id }}">
            <p class="notify-status notify-not-sent">Not Sent</p>
        @endif
    </td>

    <td style="vertical-align: middle;" class="text-center mobile-backorder-notified-by-cell">
        {{-- @if ($shipTrait->getShipping($order->id, $backOrderedShipping->order_item_id, $backOrderedShipping->order_item_detail_id, $backOrderedShipping->size_id, 'yes', null, 'notified_by'))
            <p class="notify-user">{{$orderItem->notifiedUser->name}}</p>
        @else --}}
            <p class="notify-user">{!! $shipTrait->getNotifiedByBackOrdered($backOrderedShipping->id) !!}</p>
        {{-- @endif --}}
    </td>
</tr>

{{-- <input type="hidden" name="playerName[{{ $backOrderedShipping->order_item_detail_id }}][itemId]"
    value="{{ $backOrderedShipping->order_item_detail_id }}" /> --}}
