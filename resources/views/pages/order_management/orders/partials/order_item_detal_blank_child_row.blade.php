<tr style="color:rgba(22, 22, 23, 1) !important;border-bottom: 2px solid #d7d7d7;background-color:rgb(251 251 251)" id="collapse_child_<?php echo $orderItemDetail->id; ?>" class="collapse sub_row_by_script_blanks<?php echo $orderItemDetail->id; ?> collapse-child-{{ $orderItem->id }} text-center mobile-blank-child-card-row">
    {{-- <td><input data-itemNumber="{{ $orderItem->id }}" type="checkbox" value="{{ $orderItem->id }}" name="subcheckbox<?php echo $orderItem->id; ?>" id='subcheck' class="chkItem"></td> --}}
    <td class="mobile-blank-child-cell mobile-blank-child-checkbox" style="background-color: white">
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][shipping_order_detail_id]" value="{{ $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'id') }}">
        @if ($shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'is_saved') == 1)
            <input type="hidden" class="saved-row saved-item-{{ $orderItem->id }} saved-item-detail-{{ $orderItemDetail->id }}">
        @else
            <input type="hidden" class="unsaved-row unsaved-item-{{ $orderItem->id }} unsaved-item-detail-{{ $orderItemDetail->id }}">
        @endif
        <input data-itemNumber="{{ $orderItem->id }}"
                type="checkbox"
                value="{{ $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'id') }}"
                name="subcheckbox<?php echo $orderItem->id; ?>"
                id='subcheck'
                class="chkItemChild emergency-edit-{{$shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'notify_status')}} seqcheckbox{{ $orderItemDetail->id }}"
                data-saved-status = "{{ $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'is_saved') }}"
                >
    </td>
    <td class="mobile-blank-child-cell mobile-blank-child-remake" style="background-color: white"><i class="fa fa-plus-circle aa" style="color: rgb(182 182 182);" aria-hidden="true" title="Add to remake" onclick="addToRemake({{ $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'id') }})"></i></td>
    <td class="mobile-blank-child-cell mobile-blank-child-size" style="outline: unset;text-align: end;">
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][size_id]" value="{{ $orderItemDetail->size_id }}">
        @php
            $rowSizeName = '';
            if ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size One'){
                if ($orderItem->extra_size == '1'){ $rowSizeName = 'Extra Size One'; }else{ $rowSizeName = $orderItem->extra_size; }
            }elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Two'){
                if ($orderItem->extra_size_two == '1'){ $rowSizeName = 'Extra Size Two'; }else{ $rowSizeName = $orderItem->extra_size_two; }
            }elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Three'){
                if ($orderItem->extra_size_three == '1'){ $rowSizeName = 'Extra Size Three'; }else{ $rowSizeName = $orderItem->extra_size_three; }
            }else{
                $rowSizeName = $orderItemDetail->sizeDetails['size_name'];
            }
        @endphp
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][size_name]" value="{{ $rowSizeName }}">

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
            @if ($orderItem->extra_size == '1') {{ 'Extra Size One' }} @else {{ $orderItem->extra_size }} @endif
        @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Two')
            @if ($orderItem->extra_size_two == '1') {{ 'Extra Size Two' }} @else {{ $orderItem->extra_size_two }} @endif
        @elseif ($orderItemDetail->sizeDetails['size_name'] == 'Extra Size Three')
            @if ($orderItem->extra_size_three == '1') {{ 'Extra Size Three' }} @else {{ $orderItem->extra_size_three }} @endif
        @else
            {{ $orderItemDetail->sizeDetails['size_name'] }}
        @endif
    </td>
    <td class="mobile-blank-child-cell mobile-blank-child-player" style="outline: unset">
        {{ $playerName }}
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][has_blank_name]" value="{{ $hasPlayerName }}">
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][seq_name]" value="{{ $seqName }}">
        <input type="hidden" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][player_name]" value="{{ $playerName }}">
    </td>
    <td class="mobile-blank-child-cell mobile-blank-child-number" style="outline: unset"></td>
    {{-- <td style="outline: unset">{{ $orderItemDetail->blanks + $orderItemDetail->qty }}</td> --}}
    <td class="mobile-blank-child-cell mobile-blank-child-order-qty" style="outline: unset">
        {{-- {{ $orderItemDetail->blanks }} --}}
        {{-- @php
            $orderQty = 0;
            // $itemDetailOrderQty = $orderItemDetail->blanks;
            $shippingDetailOrderQty = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'order_qty');
            if($shippingDetailOrderQty){
                $orderQty = $shippingDetailOrderQty;
            } else {
                $orderQty = $itemDetailOrderQty;
            }
        @endphp --}}
        <input type="number" class="invoice-inputs text-center order-qty" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][order_qty]" value="{{ $orderQty }}" readonly>
    </td>
        @php
            $shippedQty = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'shipped_qty');
            $backOrderedQty = $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'back_ordered_qty');
            if($shippedQty != '' && ($backOrderedQty == null || $backOrderedQty == '')){
                $backOrderedQty = $orderQty - $shippedQty;
            }
        @endphp
    <td class="mobile-blank-child-cell mobile-blank-child-shipped">
        <input type="number" class="invoice-inputs text-center emergency-edit-{{$shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'notify_status')}} shipping-input shipping-qty item-detail-shipped-qty-{{ $orderItemDetail->id }} item-shipped-qty-{{ $orderItem->id }}" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][shipped_qty]" value="{{$shippedQty}}" min="0" max="{{$orderQty}}" data-item-detail-id="{{ $orderItemDetail->id }}" data-item-id="{{ $orderItem->id }}" data-item-id="{{ $orderItem->id }}" onchange="updateBackorderedQty(this)"/>
    </td>

    <td class="mobile-blank-child-cell mobile-blank-child-backordered">
        <input type="number" class="invoice-inputs text-center shipping-input backed-qty item-detail-backed-qty-{{ $orderItemDetail->id }} item-backed-qty-{{ $orderItem->id }}" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][back_ordered_qty]" value="{{$backOrderedQty}}" readonly/>
    </td>

    <td class="mobile-blank-child-cell mobile-blank-child-delivery">
        <input type="text" class="invoice-inputs text-center emergency-edit-{{$shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'notify_status')}} shipping-datepicker shipping-input itemEstDiliveryDate" placeholder="MM/DD/YY" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][est_delivery_date]" value="{{ date_format(date_create($shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'est_delivery_date')),"m/d/Y"); }}"/>
    </td>
    <td class="mobile-blank-child-cell mobile-blank-child-courier">
        <select  class="CourierService CourierService-select invoice-inputs text-center emergency-edit-{{$shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'notify_status')}} shipping-input" name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][CourierService]"   id="CourierService{{ $orderItemDetail->id  }}">
            <option value="">Select Courier</option>
            <option value="UPS" @if( $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'CourierService')  == "UPS") selected="selected" @endif>UPS</option>
            <option value="FedEx" @if( $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'CourierService')  == "FedEx") selected="selected" @endif>FedEx</option>
            <option value="DHL" @if( $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'CourierService')  == "DHL") selected="selected" @endif>DHL</option>
            <option value="Other" @if( $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'CourierService')  == "Other") selected="selected" @endif>Other</option>
        </select>
    </td>
    <td class="mobile-blank-child-cell mobile-blank-child-tracking">
        <input
            type="text"
            {{-- onkeyup="addTrackingNo(this)" --}}
            class="txtTrackingNo invoice-inputs emergency-edit-{{$shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'notify_status')}} text-center shipping-input"
            data-itemNumber="{{ $orderItemDetail->id }}"
            name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][tracking_no]"
            id="txtTrackNo{{ $orderItemDetail->id  }}"
            value="{!! $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'tracking_no') !!}"
        />
    </td>

    <td class="mobile-blank-child-cell mobile-blank-child-tracking-link">
        <input
            type="text"
            {{-- onkeyup="addTrackingLink(this)" --}}
            class="txtTrackingLink invoice-inputs emergency-edit-{{$shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'notify_status')}} text-center shipping-input"
            data-itemNumber="{{ $orderItemDetail->id }}"
            name="items[{{ $orderItem->id }}][{{ $orderItemDetail->id }}][{{ $blankPlNameIndex }}][{{$indexKey}}][tracking_link]"
            id="txtTrackLink{{ $orderItemDetail->id  }}"
            value="{!! $shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'tracking_link') !!}"
        />
    </td>

    <td class="mobile-blank-child-cell mobile-blank-child-notify" style="vertical-align: middle;">
        @if ($shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'notify_status') == 1)
            <input type="hidden" class="notified-row">
            <p class="notify-status notify-sent" id = "remake_item_{{$shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'id')}}">Sent</p>
        @elseif ($shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'notify_status') == 2)
            <input type="hidden" class="notified-row">
            <p class="notify-status notify-sent" id = "remake_item_{{$shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'id')}}">Re-Sent</p>
        @elseif ($shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'notify_status') == 3)
            <input type="hidden" class="notified-row">
            <p class="notify-status notify-remake" id = "remake_item_{{$shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'id')}}">Re-Make</p>
        @else
            <input type="hidden" class="unnotified-row unnotified-item-{{ $orderItem->id }} unnotified-item-detail-{{ $orderItemDetail->id }}">
            <p class="notify-status notify-not-sent" id = "remake_item_{{$shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'id')}}">Not Sent</p>
        @endif
    </td>

    <td style="vertical-align: middle;" class="mobile-blank-child-cell mobile-blank-child-notified-by text-center">
        {{-- @if ($shipTrait->getShipping($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName, 'notified_by'))
            <p class="notify-user">{{$orderItem->notifiedUser->name}}</p>
        @else --}}
            <p class="notify-user">{!! $shipTrait->getNotifiedBy($order->id, $orderItem->id, $orderItemDetail->id, $orderItemDetail->size_id, 'yes', $hasPlayerName, null, $seqName) !!}</p>
        {{-- @endif --}}
    </td>
</tr>

{{-- <input type="hidden" name="playerName[{{ $orderItemDetail->id }}][itemId]"
    value="{{ $orderItemDetail->id }}" /> --}}
